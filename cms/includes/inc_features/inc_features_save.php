<?php

############################################################################################################################
## Save Testimonial Item
############################################################################################################################

function save_item()
{

    global $message,$id,$do,$disable_menu, $root, $rootfull, $rootadmin, $upload_dir;

    $page_data = array();

    $page_data['name']  = sanitize_input('name');
    
    update_row($page_data, 'accom_feature', "WHERE id = '{$id}'");

    $message = "Item has been saved";

}

?>