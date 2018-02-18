<?php

############################################################################################################################
## Save Testimonial Item
############################################################################################################################

function save_item()
{

    global $message,$id,$do,$disable_menu, $root, $rootfull, $rootadmin, $upload_dir, $htmladmin;


    $data = array();

	$data['name']      			= sanitize_input( 'name' );
	$data['label']     			= sanitize_input( 'label' );
	$data['list_id']     		= sanitize_input( 'list_id' );
	$data['list_email_address'] = sanitize_input( 'list_email_address' );
	
    update_row($data, 'beamer_email', "WHERE `id` = '{$id}' LIMIT 1");

    set_flash_msg("Changes has been saved successfully");

    redirect("{$htmladmin}?do={$do}");
}

?>