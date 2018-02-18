<?php


$gcSiteKey     = GC_SITE_KEY;
$gcSecretKey   = GC_SECRET_KEY;

$json_data = fetch_value("
    SELECT `json_data` FROM `form` WHERE `id` = {$page_form_id}
");

$form_fields = json_decode($json_data, true);

$form                 = '';
$captcha_error_msg    = '';
$tc_error_msg         = '';

$tc             = filter_input(INPUT_POST, 'tc');

$form_submit_btn_cls  = ($has_terms_and_conditions && !$tc ) ? ' disabled' : '';
$form_submit_btn_attr = ($has_terms_and_conditions && !$tc ) ? ' disabled="disabled"' : '';

$tc_checked = ($tc) ?  'checked="checked"' : 'disabled="disabled"';

// validate required fields
if($_POST['continue'])
{
	//  Create form validation rules
	require_once "{$classdir}/form_validation.php";

	$form_validation = new FormValidation();

	foreach ($form_fields as $form_field)
	{
	    $form_field_label       = ($form_field['type'] == 'checkbox-group') ? 'This field' : $form_field['label'];
	    $form_field_name        = $form_field['name'];
	    $form_field_type        = $form_field['type'];
	    $form_field_subtype     = $form_field['subtype'];
	    $form_field_is_required = $form_field['required'];

	    if( $form_field_is_required == true )
	    {
	        $additional_rule .= ($form_field_subtype == 'email') ? '|email' : '';
	        $validation_rule = 'trim|required'.$additional_rule;

	        $validation_rule = (preg_match("/.*(group)/", $form_field_type)) ? 'group' : $validation_rule;
	        $form_validation->setRule($form_field_name, $form_field_label, $validation_rule);
	    }
	}

	if( $has_terms_and_conditions )
	{
		$form_validation->setRule('tc', 'Please accept out terms and conditions', 'trim|required', true);
	}

	$captcha_response_token = filter_input(INPUT_POST, 'g-recaptcha-response');
	$captcha_error = false;

	// validate captcha
	if( !empty($captcha_response_token) )
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "secret={$gcSecretKey}&response={$captcha_response_token}&remoteip=".getenv('REMOTE_ADDR'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$g_recaptcha_response_json = curl_exec ($ch);
		curl_close ($ch);

		$g_recaptcha_response = json_decode($g_recaptcha_response_json, true);

		$captcha_error = (bool) !$g_recaptcha_response['success'];
	}
	else
	{
		$captcha_error = TRUE;
		$captcha_error_msg = 'Invalid captcha provided.';
	}

	$form_is_valid     = $form_validation->validate();

	//  Catch form errors
	$tc_error_msg      = $form_validation->getError('tc');
}

?>