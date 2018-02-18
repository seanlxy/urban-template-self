<?php

############################################################################################################################
## New FAQ Item
############################################################################################################################

function new_item()
{
	global $message,$id,$pages_maximum, $do, $htmladmin;

    $temp_array_new = array();
    
    $now = date("Y-m-d H:i:s");

    $temp_array_new['name']             = 'Untitled';
    $temp_array_new['date_created']     = $now;
    $temp_array_new['date_updated']     = $now;
    $temp_array_new['created_by']       = $_SESSION['s_user_id'];
    $temp_array_new['status']           = 'H';

    $id = insert_row($temp_array_new, 'beamer_campaign');


    if( $id )
    {
        set_flash_msg("New item has been created successfully");
    	redirect("{$htmladmin}?do={$do}&id={$id}&action=edit");
    }
    
}

?>