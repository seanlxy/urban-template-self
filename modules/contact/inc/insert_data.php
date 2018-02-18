<?php 


	date_default_timezone_set('Pacific/Auckland');
	$enquiry_data = array();

	$enquiry_data['first_name']      = $first_name;
	$enquiry_data['last_name']       = $last_name;
	$enquiry_data['email_address']   = $email_address;
	$enquiry_data['contact_number']  = $contact_number;
	$enquiry_data['comments']        = $message;
	$enquiry_data['status']          = 'A';
	$enquiry_data['ip_address']      = getenv('REMOTE_ADDR');
	$enquiry_data['date_of_enquiry']  = date('Y-m-d H:i:s');


	// if all posted data is valid store enquiry information in database
	$new_enquiry = insert_row($enquiry_data, 'enquiry');
	
	$contact_details = array();

	if($new_enquiry) 
	{	
		// get new enquiry details from database
		$contact_details = fetch_row("SELECT `first_name`, `last_name`, `email_address`, `contact_number`,
			`comments`, DATE_FORMAT(`date_of_enquiry`, '%e %M %Y @ %h:%i %p') AS date_enquired
			FROM `enquiry`
			WHERE `id` = '$new_enquiry'
			LIMIT 1");

		// email tempalte tags
		$email_template_tags = array();
		$email_template_tags['email_subject'] = 'You have received a new enquiry from website.';
		$email_template_tags['root']	= $htmlroot;

		//merge email template tags along with data from database
		$email_template_tags = array_merge($email_template_tags, $contact_details);


		// get email template file
		$etemplate_path = "{$tmpldir}/email/contact.tmpl";

		$email_template = process_template($etemplate_path, $email_template_tags);
		
		if( $email_template )
		{

			// Initiate php mailer class to send email
			require_once "$classdir/class_phpmailer.php";

			// get comany details i.e. name and emai laddress
			$company_email   = ($comp_emails->primaryEmail) ? $comp_emails->primaryEmail : '';

			if( $company_email )
			{
				// Send Email
				$mail = new PHPMailer();
				$mail->IsHTML();
				$mail->AddReplyTo($email_template_tags['email_address']);
				$mail->AddAddress($company_email);
				if( !empty($comp_emails) )
				{
					foreach ($comp_emails->list as $email)
					{
						$mail->AddCC($email);
					}
				}

				$mail->SetFrom($company_email);
				$mail->FromName = "{$email_template_tags['first_name']} {$email_template_tags['last_name']}";
				$mail->Subject  = $email_template_tags['email_subject'];
				$mail->msgHTML($email_template);

				// if email is sent, redirect user to success page

				if( $mail->Send() )
				{
					header("Location: {$htmlrootfull}/{$page}?success=".md5($new_enquiry));
					exit();
				}

			}
			
		}
		
	}
?>