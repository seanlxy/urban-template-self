<?php

############################################################################################################################
## Save Testimonial Item
############################################################################################################################

function save_item()
{

    global $message,$id,$do,$disable_menu, $root, $rootfull, $rootadmin, $upload_dir;

    $page_data = array();



    $page_data['person']  = sanitize_input('person');
    $page_data['detail']  = sanitize_input('detail');
    
    update_row($page_data, 'testimonial', "WHERE id = '{$id}'");


    $message = "Item has been saved";

}

?>