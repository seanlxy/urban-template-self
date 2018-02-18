<?php 

if ($page_form_id)
{

	$sql = "SELECT `public_token`, `name`, `email_subject`, `mailchimp_list_id`,
	   `success_message`, `terms_and_conditions`
		FROM `form`
		WHERE `id` = '{$page_form_id}'
		LIMIT 1";

	$form_details = fetch_row($sql);

	if( !empty($form_details) )
	{
		
		$success_message      = nl2br($form_details['success_message']);
		$terms_and_conditions = $form_details['terms_and_conditions'];
		$email_subject        = $form_details['email_subject'];
		$mailchimp_list_id    = $form_details['mailchimp_list_id'];
		
		$has_terms_and_conditions = ( $terms_and_conditions ) ? true : false;
		
		require_once 'inc/vars.php';


		if($_POST['continue'])
		{
			if($form_is_valid && !$captcha_error) {
			    require_once 'inc/insert_data.php';
            }else
            {
                require_once 'inc/form.php';
            }
		}
		elseif( isset($_GET['success']) )
		{
			require_once 'inc/success.php';
		}
		else
		{
			require_once 'inc/form.php';
		}
				
		$tags_arr['content'] .= $form;

    }


    
}

?>