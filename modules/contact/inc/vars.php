<?php 
	
	//  Initialize variables
	$form          = '';
	$form_is_valid = false;
	$output        = '';

	$gcSiteKey     = GC_SITE_KEY;
	$gcSecretKey   = GC_SECRET_KEY;
	
	//  Create post variables
	$first_name             = sanitize_input('first-name');
	$last_name              = sanitize_input('last-name');
	$email_address          = sanitize_input('email-address', FILTER_VALIDATE_EMAIL);
	$contact_number         = sanitize_input('contact-number');
	$number_of_person       = sanitize_input('number-of-person');
	$date                   = sanitize_input('checkIn');
	$message                = sanitize_input('message');
	$captcha_response_token = filter_input(INPUT_POST, 'g-recaptcha-response');
	
	// $tour       = ( sanitize_input('tour') ) ? sanitize_input('tour')  : ((isset($_GET['tour'])) ? sanitize_var($_GET['tour']) : '') ;
	// $motorcycle = ( sanitize_input('motorcycle') ) ? sanitize_input('motorcycle')  : ((isset($_GET['motorcycle'])) ? sanitize_var($_GET['motorcycle']) : '') ;


	
	// validate required fields
	if(sanitize_input('continue') === '1')
	{

		//  Create error variables
		$first_name_error     = true;
		$last_name_error      = true;
		$email_address_error  = true;
		$contact_number_error = true;
		$date_error_msg       = true;
		$captcha_error        = true;

		
		// validate first name
		if(empty($first_name))
		{
			
			$first_name_error_msg = display_message('First name is required.');
		}
		elseif(!is_alpha($first_name))
		{
			$first_name_error_msg = display_message('Invalid first name provided.');
		}
		else
		{
			$first_name_error_msg = '';
			$first_name_error     = false;
		}

		// validate last name
		if(empty($last_name))
		{
			$last_name_error_msg = display_message('Last name is required.');
		}
		elseif(!is_alpha($last_name))
		{
			$last_name_error_msg = display_message('Invalid last name provided.');
		}
		else
		{
			$last_name_error_msg = '';
			$last_name_error     = false;
		}


		// validate email address
		if(empty($email_address))
		{
			$email_address_error_msg = display_message('Email address is required.');
		}
		elseif(!is_email($email_address))
		{
			$email_address_error_msg = display_message('Invalid email provided.');
		}
		else
		{
			$email_address_error_msg = '';
			$email_address_error     = false;
		}

		// validate date
		if(empty($date))
		{
			$date_error_msg = display_message('Date is required.');
		}
		elseif(!is_alpha($date))
		{
			$date_error_msg = display_message('Invalid date provided.');
		}
		else
		{
			$date_error_msg = '';
			$date_error     = false;
		}

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



		if(!$first_name_error && !$last_name_error && !$email_address_error && !$date_error && !$captcha_error)
		{
			$form_is_valid = true;
		}
	}

?>