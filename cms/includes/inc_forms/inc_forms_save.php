<?php

############################################################################################################################
## Save Testimonial Item
############################################################################################################################

function save_item()
{

    global $message,$id,$do,$disable_menu, $root, $rootfull, $rootadmin, $upload_dir;


    $page_data = array();
	$page_data['name']                 = sanitize_input('cms_name');
	$page_data['email_subject']        = sanitize_input('email_subject');
	$page_data['mailchimp_list_id']    = sanitize_input('mailchimp_list_id');
	$page_data['success_message']      = sanitize_input('success_message');
	$page_data['terms_and_conditions'] = filter_input(INPUT_POST, 'terms_and_conditions');
	$page_data['date_updated']         = date('Y-m-d H:i:s');

    update_row($page_data, 'form', "WHERE id = '{$id}'");

    $message = "Changes has been saved successfully.";


}

?>