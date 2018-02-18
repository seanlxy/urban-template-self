<?php

############################################################################################################################
## New FAQ Item
############################################################################################################################

function new_item()
{
	global $message,$id,$htmladmin;

	$temp_array_new['old_url']   = 'URL';
	$temp_array_new['status'] = 'H';

	$id = insert_row($temp_array_new, 'redirect');
	$message = "New item has been added and ready to edit";
        
    @include('inc_redirects_edit.php');
	edit_item();
}

?>
