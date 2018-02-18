<?php

############################################################################################################################
## New FAQ Item
############################################################################################################################

function new_item()
{
	global $message,$id,$pages_maximum, $do, $htmladmin;

    
    $temp_array_new['public_token'] = substr(md5( sha1( create_rand_chars() ) ), 0, 10);
    $temp_array_new['name']         = 'Untitled';
    $temp_array_new['date_created'] = date('Y-m-d H:i:s');
    $temp_array_new['status']       = 'H';

    $id = insert_row( $temp_array_new, 'form' );

    $message = "New item has been added and ready to edit";

    if( $id )
    {
    	header("Location: {$htmladmin}?do={$do}&id={$id}&action=edit");
    	exit();
    }

        
}

?>
