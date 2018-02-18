<?php

function export_items()
{
	global $message, $id, $do, $disable_menu, $valid, $htmladmin, $main_subheading, $js_vars, $admin_dir;

	$form_data = fetch_row( "SELECT `id`, `name`
		FROM `form`
		WHERE `id` = '{$id}'
		LIMIT 1" );

	$csv_content = '';
	$csv_header  = '';
	$csv_body    = '';
	$delimiter   = ',';

	if( $form_data )
	{

		$form_id       = $form_data['id'];
		$form_name     = $form_data['name'];

		$order_fields = fetch_value("SELECT GROUP_CONCAT(CONCAT( 'fed.`label` <> ', \"'\",`label`, \"'\") )  FROM `form_field` WHERE `form_id` = '{$form_id}' ORDER BY `rank`");
		
		$form_entries_query    = run_query("SELECT fed.`label`, fed.`value`, fed.`form_entry_id`
			FROM `form_entry_data` fed
			WHERE fed.`form_id` = '{$form_id}'
			AND fed.`value` != 'yes'
			ORDER BY fed.`form_entry_id`, {$order_fields}");

		$form_entries_arr = array();
		$csv_header_cols  = array();
		
		if( mysql_num_rows($form_entries_query) > 0 )
		{

			//  Build header
			while( $form_entry = mysql_fetch_assoc($form_entries_query) )
			{

				$form_entry_label     = $form_entry['label'];
				$form_entry_label_key = prepare_item_url($form_entry_label);
				
				if( !in_array($form_entry_label, $csv_header_cols) )
				{
					$csv_header_cols[$form_entry_label_key] = $form_entry_label;
				}

				$form_entries_arr[$form_entry['form_entry_id']][] = $form_entry;
				
			}

			$csv_header_cols = array_values($csv_header_cols);

			//  Build body content
			foreach ( $form_entries_arr as $form_entry )
			{
				$row_cols = '';

				foreach ( $csv_header_cols as $hkey => $head_col )
				{


					$field_value = ( isset($form_entry[$hkey]) ) ? $form_entry[$hkey]['value'] : '';
					$field_value = str_replace($delimiter, '-', $field_value);

					$row_cols .= "{$delimiter}{$field_value}";

				}

				$row_cols = trim($row_cols, $delimiter);

				$csv_body .= "{$row_cols}\n";
				
			}



			$csv_header  = implode($delimiter, $csv_header_cols)."\n";

			$csv_content = $csv_header;
			$csv_content .= $csv_body;



			$csv_file_name = prepare_item_url($form_name).'-'.time().'.csv';

			
			header('Content-Type: text/csv; charset=utf-8');
  			header("Content-Disposition: attachment; filename={$csv_file_name}");
		    print($csv_content);
		    exit();
		}
	}
}

?>