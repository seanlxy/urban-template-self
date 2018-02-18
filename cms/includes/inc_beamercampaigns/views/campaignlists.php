<?php

$campaign_list_content = '';

$email_lists = fetch_all("SELECT `id`, `name`
	FROM `beamer_email` 
	WHERE `status` != 'D'
	AND `status` != 'H'
	ORDER BY `name`");

if( !empty($email_lists) )
{
	$attached_emails_csv = fetch_value("SELECT GROUP_CONCAT(`beamer_email_id`)
		FROM `beamer_campaign_has_emails`
		WHERE `beamer_campaign_id` = '{$id}'");


	$attached_emails_arr = explode(',', $attached_emails_csv);


	$campaign_list_content = '<ul class="list-grid">';

	foreach ($email_lists as $email_list)
	{
		$beamer_email_id  	= $email_list['id'];
		$beamer_email_label = $email_list['name'];


		$is_checked 	 = ( in_array($beamer_email_id, $attached_emails_arr) ) ? ' checked' : ''; 

		$campaign_list_content .= '<li>
			<label class="checkbox-inline">
				<input type="checkbox" value="'.$beamer_email_id.'" name="beamer_email_id[]"'.$is_checked.'> <span>'.$beamer_email_label.'</span>
			</label>
		</li>';
	}

	$campaign_list_content .= '</ul>';	
}

?>