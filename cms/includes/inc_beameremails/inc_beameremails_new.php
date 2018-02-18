<?php

############################################################################################################################
## New FAQ Item
############################################################################################################################

function new_item()
{
	global $message,$id,$pages_maximum, $do, $htmladmin;

    $temp_array_new = array();

    $temp_array_new['name']   = 'Untitled';
    $temp_array_new['status'] = 'H';

    $id = insert_row($temp_array_new, 'beamer_email');


    if( $id )
    {
        set_flash_msg("New item has been created successfully");
    	redirect("{$htmladmin}?do={$do}&id={$id}&action=edit");
    }
    
}

?>