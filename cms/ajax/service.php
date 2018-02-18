<?php

require_once ('../../utility/config.php');                              ## System config file
if(!$c_Connection->Connect()) {

    echo "Database connection failed";
    exit;
}
$Message = "";
$c_Message	= $c_Connection->GetMessage();

$request_type = ($_POST) ? $_POST : $_GET;

$action = mysql_real_escape_string($request_type['action']);

switch ($action)
{
	case 'get-coords':
		get_latlng_of_address(mysql_real_escape_string($_POST['address']));
	break;
	case 'check-url':
		validate_url($_POST['url'], $_POST['currUrl']);
	break;
	case 'save-form':
		save_form( sanitize_input('id', FILTER_VALIDATE_INT) );
	break;
	case 'fetch-form-entry-data':
		get_form_entry_data( sanitize_input('ind', FILTER_VALIDATE_INT) );
	break;
}

function get_latlng_of_address($address, $return_json = TRUE)
{
	if($address)
	{
		$address = str_replace(' ','+',str_replace("\n",'',str_replace("\r",'',$address)));

		$request_url = "http://maps.googleapis.com/maps/api/geocode/json?address=$address&sensor=true";

		$c = curl_init();
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($c, CURLOPT_URL, $request_url);
		curl_setopt($c, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
		$json = curl_exec($c);
		$err  = curl_getinfo($c,CURLINFO_HTTP_CODE);
		curl_close($c);
		$details = json_decode($json);

		$result = $details->results[0]->geometry->location;

		$coords = array(
			'lat'              => $result->lat,
			'lng'              => $result->lng,
			'formattedAddress' => $details->results[0]->formatted_address
		);

		if($return_json) die(return_json($coords));
		else return $coords;
	}
}

function validate_url($url, $current_url)
{
 	global $root;

	$url         = prepare_item_url(trim(filter_var($url, FILTER_SANITIZE_MAGIC_QUOTES)));
	$current_url = trim(filter_var($current_url, FILTER_SANITIZE_MAGIC_QUOTES));
	$valid       = true;
	$message     = '';

 	if($url)
 	{

		if($valid)
		{
			// Check if url exists
			$sql = "SELECT `url` FROM `page_meta_data`
			WHERE `url` = '$url'
			AND `url` != '$current_url'
			AND `status` != 'D'";

			$valid = (fetch_value($sql)) ? false : true;

			$message = (!$valid) ? 'This page url already exists. Please enter another.' : '';
		}

		if($valid)
		{
			// Check if folder exists with the same name as the url
			$valid = (is_dir("$root/$url")) ? false : true;
			$message = (!$valid) ? 'This URL conflicts with the system. Please enter another.' : '';
		}
 	}
 	else
 	{
		$valid   = false;
		$message = 'Please provide valid URL';
 	}

 	die( json_encode( array('valid' => $valid, 'message'   => $message) ) );
}

// FORM FUNCTIONS -------------------------------------------------------------------------------------------------------------------


function get_form_field( $arr, $attr )
{

	return (isset($arr[$attr])) ? $arr->attributes()->class[0] : '';
}

function save_form( $form_id )
{
	$data = array();

	$xml_data  = $_POST['xml'];
	$json_data = $_POST['json'];

	if( $form_id )
	{

		update_row(array( 'xml_data' => $xml_data, 'json_data' => $json_data), 'form', "WHERE `id` = '{$form_id}' LIMIT 1");

		run_query("DELETE FROM `form_field` WHERE `form_id` = '{$form_id}'");

		$xml_form_data = simplexml_load_string( $xml_data );

		if( $xml_form_data )
		{

			$map_attrs = array(
				'type'        => 'type',
				'required'    => 'is_required',
				'label'       => 'label',
				'description' => 'help_text',
				'placeholder' => 'placeholder',
				'class'       => 'class',
				'name'        => 'name',
				'value'       => 'default_value',
				'subtype'     => 'subtype',
				'multiple'	  => 'is_multiple',
				'toggle'	  => 'is_toggle'

			);

			$rank = 1;

			foreach ( $xml_form_data->fields->field as $field )
			{

				$field_data        = array();
				$field_options_arr = array();


				foreach ( $field->attributes() as $attr_name => $attr_value )
				{

					settype($attr_value, 'string');

					if( isset($map_attrs[$attr_name]) )
					{

						if( $attr_name == 'required' || $attr_name == 'multiple'  || $attr_name == 'toggle' )
						{
							$field_data[$map_attrs[$attr_name]] = ($attr_value == 'true') ? 'Y' : 'N';
						}
						else
						{
							$field_data[$map_attrs[$attr_name]] = $attr_value;
						}
					}
				}

				if( isset( $field->option ) && !empty($field->option) )
				{

					foreach ($field->option as $k => $option)
					{
						$optionData = array();

						foreach ($option->attributes() as $opt_attr_name => $opt_attr_value)
						{
							settype($opt_attr_value, 'string');

							if( $opt_attr_name === 'value' ||  $opt_attr_name === 'label' )
							{
								$optionData[$opt_attr_name] = $opt_attr_value;
							}

						}

						$field_options_arr[] = $optionData;

					}

				}


				$field_data['options_json']  = json_encode($field_options_arr);
				$field_data['rank']          = $rank;
				$field_data['form_id']       = $form_id;

				insert_row($field_data, 'form_field');

				$rank++;

			}

		}
	}

	die( json_encode( $data ) );
}


function get_form_entry_data( $form_entry_id )
{

	$fields = array();

	if( $form_entry_id )
	{

		$entry_data = fetch_row("SELECT 'Entry Date' AS label, DATE_FORMAT(`date_added`, '%d %b %Y %h:%i %p') AS value
			FROM `form_entry`
			WHERE `id` = '{$form_entry_id}'
			LIMIT 1");

		$fields = fetch_all("SELECT `label`, `value` FROM `form_entry_data` WHERE `form_entry_id` = '{$form_entry_id}'");

		$fields[] = $entry_data;
	}

	die( json_encode( $fields ) );

}


?>
