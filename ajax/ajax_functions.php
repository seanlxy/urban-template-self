<?php
session_start();   
require_once ('../utility/config.php');
// error_reporting(E_ALL);

if(!$c_Connection->Connect())
{
	echo "Database connection failed";
	exit;
}

if($debug)
{
	include_once $classdir.'/firephp/fb.php';
	FB::setEnabled($debug);
}

$request_type = ($_POST) ? $_POST : $_GET;

$action       = sanitize_var($request_type['action']);

switch($action)
{
	case 'sign-up':
		do_mailchimp_signup();
	break;
	case 'fetch-gallery':
		get_gallery_photos( sanitize_var($request_type['key']) );
	break;
}

function get_gallery_photos( $gallery_id )
{
	$data = array();

	if( $gallery_id )
	{
		$data = fetch_all("SELECT `full_path` AS src, `thumb_path` AS msrc, `width` AS w, `height` AS h
			FROM `photo`
			WHERE `photo_group_id` = '{$gallery_id}'
			ORDER BY `rank`");
	}

	die( json_encode( $data ) );
} 

function do_mailchimp_signup()
{
	global $request_type, $classdir;

	$msg      = '';
	$msg_type = 'msg--error';
	$is_valid = false;

	$full_name     = '';
	$email_address = sanitize_one($request_type['email']);

	if(!empty($email_address))
	{
		if(filter_var($email_address, FILTER_VALIDATE_EMAIL))
		{
			include_once "{$classdir}/mail_chimp.php";

			$mailchimp_data = fetch_row("SELECT `mailchimp_api_key`, `mailchimp_list_id` FROM `general_settings` WHERE `id` = '1' LIMIT 1");

			if( $mailchimp_data )
			{

				$user_info = array('FNAME' => $full_name, 'LNAME' => '');

				$mc_api  = new MCAPI($mailchimp_data['mailchimp_api_key']);

				$list_id = $mailchimp_data['mailchimp_list_id'];

				if($mc_api->listSubscribe($list_id, $email_address, $user_info) === true)
				{
					$msg      = 'Success! Check your email to confirm sign up.';
					$msg_type = 'msg--success';
					$is_valid = true;
				}
				else
				{
					$msg = $mc_api->errorMessage;
				}
			}

		}
		else
		{
			$msg = 'Invalid email address provided.';
		}
	}
	else
	{
		$msg = 'Your name and email address is required.';
	}


	die( json_encode( array( 'msg' => $msg, 'type' => $msg_type, 'isValid' => $is_valid ) ) );
}

?>