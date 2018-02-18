<?php

############################################################################################################################
## Save Testimonial Item
############################################################################################################################

function save_item()
{

    global $message,$id,$do,$disable_menu, $root, $rootfull, $rootadmin;

    $update_arr           = array();


    $update_arr['old_url']              = $_POST['old_url'];
    $update_arr['new_url']              = $_POST['new_url'];
    $update_arr['status_code']       = $_POST['status_code'];


    $end="WHERE id = '$id'";
    update_row($update_arr, 'redirect', $end);

    $message = "Item has been saved";
}

?>