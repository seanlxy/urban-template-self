<?php

// $chars = create_rand_chars(array('make_uppercase' => TRUE));

// $encrypt_key = hash('ripemd128', $chars);

// echo $encrypt_key.'<br>';
// echo $chars.'<br>';
// die();

/* ==| GENERAL VARIABLES ============================= */
$templates_dir_path       = dirname(dirname(__FILE__)).'/templates';
$email_templates_dir_path = "{$templates_dir_path}/email";
$g_recaptcha_secret = GC_SECRET_KEY;

/* ==| FORM INPUT VARIABLES ============================= */
$payment_method  = filter_input(INPUT_POST, 'payment-method', FILTER_VALIDATE_INT);
$comments        = filter_input(INPUT_POST, 'comments');
$process_payment = sanitize_input('process-payment', FILTER_VALIDATE_BOOLEAN);
$captcha_response_token = filter_input(INPUT_POST, 'g-recaptcha-response');

/* ==| URL VARS ============================= */
$payment_token = $_GET['pid'];
$imgPath = "{$htmlroot}/graphics/logo.gif";
$imgDrivingPath = "{$htmlroot}/graphics/logo-drivingnz.png";
$tags_arr['payment-logo'] = <<<H
	<div class="col-md-12 col-xs-12 text-center"> 
		<img src="{$imgPath}">
		<img src="{$imgDrivingPath}">
	</div>
H;

/* ==| ERROR VARIABLES ============================= */
$payment_method_error = '';
$terms_error          = '';
$captcha_error        = '';

$company_details = array();

$company_details['root']         = $htmlroot;
$company_details['logo_root_path'] = "{$htmlroot}";
$company_details['company_name'] = $company_name;
$company_details['phone_number'] = $phone_number;
$company_details['address']      = $company_address;
$company_details['logo_path']    = $company_logo_path;

require_once "{$classdir}/payment.php";

$payment_config = array(
    // 'productionMode' => PAYMENT_PRODUCTION_MODE,
    'productionMode' => true,
    'paymentURL' => "{$htmlroot}/payments",
    'clientSuccessEmailTmplPath' => "{$email_templates_dir_path}/client_success.tmpl",
    'clientFailEmailTmplPath' => "{$email_templates_dir_path}/client_fail.tmpl",
    'adminSuccessEmailTmplPath' => "{$email_templates_dir_path}/admin_success.tmpl",
    'adminFailEmailTmplPath' => "{$email_templates_dir_path}/admin_fail.tmpl",
    'emailTmplData' => $company_details
);

$obj_payment = new Payment($payment_config, $payment_token);

/* ==| GENERAL VARIABLES ============================= */
$form_is_valid = false;


// $payment_data     = $obj_payment->getDetails($payment_token);
$payment_data     = $obj_payment->data;
$payment_settings = $obj_payment->settings;


if( !empty($payment_data) )
{
	$payment_id           = $payment_data['id'];
	$payment_public_token = $payment_data['public_token'];
	$full_name            = $payment_data['full_name'];
	$email_address        = $payment_data['email_address'];
	$amount               = $payment_data['amount'];
	$request_url          = $payment_data['request_url'];
	$amount_formatted     = number_format($amount, 2);

	$payment_accounts         = $obj_payment->getSiteAccounts();
	$payment_accounts_ccs     = $obj_payment->getAccountCreditCards();

	//  Log if payer has first arrived on payment page once

	if( empty($_SESSION[$payment_public_token]) )
	{

		Payment::logHistory( Payment::HISTORY_VIEWED_ID, $payment_id );

		$_SESSION[$payment_public_token] = true;

	}


	if( $process_payment )
	{
		require_once "{$classdir}/form_validation.php";

		$form_validation = new FormValidation();
		
		$form_validation->setRule('payment-method', 'Please choose your payment method', 'trim|required', true);
		$form_validation->setRule('terms-checkbox', 'Please accept the Terms and Conditions', 'trim|required', true);

		$form_is_valid = $form_validation->validate();

		/* ==| CATCH ANY FORM ERROR ============================= */
		$payment_method_error = $form_validation->getError('payment-method');
		$terms_error          = $form_validation->getError('terms-checkbox');

        // validate captcha
        if( !empty($captcha_response_token) )
        {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "secret={$g_recaptcha_secret}&response={$captcha_response_token}&remoteip=".getenv('REMOTE_ADDR'));

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $g_recaptcha_response_json = curl_exec($ch);

            curl_close ($ch);

            $g_recaptcha_response = json_decode($g_recaptcha_response_json, true);

            $captcha_error = ($g_recaptcha_response['success'] == 1) ? FALSE : TRUE;
        }
        else
        {
            $captcha_error = TRUE;
            $captcha_error_msg = 'Captcha is required.';
        }
	}

}
else
{
	header("Location: {$htmlroot}");
	exit();
}


?>