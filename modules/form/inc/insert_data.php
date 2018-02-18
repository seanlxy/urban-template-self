<?php
	
	$first_name    = sanitize_input('first-name');
	$last_name     = sanitize_input('last-name');
	$email_address = sanitize_input('email-address', FILTER_VALIDATE_EMAIL);


	// If all posted data is valid store entry information in database
	$ins_arr = array();
	
	$ins_arr['first_name']    = $first_name;
	$ins_arr['last_name']     = $last_name;
	$ins_arr['full_name']     = trim("{$first_name} {$last_name}");
	$ins_arr['email_address'] = $email_address;
	$ins_arr['date_added']    = date('Y-m-d H:i:s');
	$ins_arr['ip_address']    = getenv('REMOTE_ADDR');
	$ins_arr['form_id']       = $page_form_id;

	$form_entry_id = insert_row($ins_arr, 'form_entry');

	if( $form_entry_id && $page_form_id )
	{

		$insert_query = '';

		foreach ($form_fields as $form_field)
		{
			$field_posted_value = $_REQUEST["{$form_field['name']}"];
			if(is_array($field_posted_value)) {
                $value_string = '';
				foreach ($field_posted_value as $item ) {
					$value_string .= htmlspecialchars($item) . ", ";
				}
                $field_posted_value = $value_string;
			}
            $field_posted_value = htmlspecialchars($field_posted_value);
			$insert_query .= ",('{$form_field['label']}','{$field_posted_value}',{$page_form_id},{$form_entry_id})";
		}

		if( $insert_query )
		{
			$insert_query = ltrim($insert_query, ',');
			run_query("INSERT INTO `form_entry_data`(`label`, `value`, `form_id`, `form_entry_id`) VALUES {$insert_query}");
		}

		$entry_data = fetch_row("SELECT `id`, `first_name`, `last_name`, `full_name`,
			`email_address`, DATE_FORMAT(`date_added`, '%d %b %Y %h:%i %p') AS added_date
			FROM `form_entry`
			WHERE `id` = '{$form_entry_id}'
			AND `form_id` = '{$page_form_id}'
			LIMIT 1");


		$posted_form_data = fetch_all("SELECT `label`, `value`
			FROM `form_entry_data`
			WHERE `value` != ''
			AND `form_id` = '{$page_form_id}'
			AND `form_entry_id` = '{$form_entry_id}'");

		//  Assign to mailchimp if mailchimp list id is assiged to this form

		if( $mailchimp_list_id && $mailchimp_api_key )
		{
			
			$user_info = array('FNAME' => $entry_data['first_name'], 'LNAME' => $entry_data['last_name']);

			require_once "{$classdir}/mail_chimp.php";

			$mc_api  = new MCAPI( $mailchimp_api_key );

			$mc_api->listSubscribe($mailchimp_list_id, $entry_data['email_address'], $user_info);

		}


		if( !empty($posted_form_data) )
		{

			//  Generate form fields view
			$form_data = '';

			foreach ($posted_form_data as $field_data)
			{
				$field_data_value = (($field_data['value']) ? $field_data['value'] : '-');

				$field_data_value = ( filter_var($field_data_value, FILTER_VALIDATE_EMAIL) ) ? mail_to($field_data_value) : $field_data_value;

				$form_data .= '<tr>
					<td width="200" valign="top"><strong>'.$field_data['label'].':</strong></td>
					<td valign="top">'.$field_data_value.'</td>
				</tr>';
			}

			//  Send email to user and admin
			$email_template_path = "{$tmpldir}/email/client_success.tmpl";

			$email_template_tags = array();

			$email_template_tags['email_subject'] = $email_subject;
			$email_template_tags['added_date']    = $entry_data['added_date'];
			$email_template_tags['form_data']     = $form_data;

		    $compiled_email = process_template($email_template_path, $email_template_tags);
			
			// Initiate php mailer class to send email
			require_once "$classdir/class_phpmailer.php";


			// Send Email
			$mail = new PHPMailer();
			$mail->IsHTML();
			$mail->AddReplyTo($entry_data['email_address']);
			$mail->AddAddress($primary_email);
			// $mail->AddAddress('martinrobertjones@gmail.com');
			if( !empty($comp_emails) )
			{
				foreach ($comp_emails->list as $email)
				{
					$mail->AddCC($email);
				}
			}
			$mail->SetFrom($entry_data['email_address']);
			$mail->FromName = $entry_data['full_name'];
			$mail->Subject  = $email_subject;
			$mail->msgHTML($compiled_email);
			$isEmailSent = $mail->Send();

			// if email is sent, redirect user to success page
			if($isEmailSent)
			{
				header("Location: {$htmlrootfull}{$page_full_url}?success=".md5($entry_data['id']));
				exit();
			}

		}

	}
?>
