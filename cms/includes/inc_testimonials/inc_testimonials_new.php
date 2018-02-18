<?php

############################################################################################################################
## New FAQ Item
############################################################################################################################

function new_item()
{
	global $message,$id,$pages_maximum, $do, $htmladmin;

	
    $temp_array_new['person'] = 'Untitled';
    $temp_array_new['status'] = 'H';


    $id = insert_row( $temp_array_new, 'testimonial' );

    $message = "New item has been added and ready to edit";

    if( $id )
    {
    	header("Location: {$htmladmin}?do={$do}&id={$id}&action=edit");
    	exit();
    }

        
}

?>
