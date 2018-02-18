<?php

############################################################################################################################
## Add a new slideshow
############################################################################################################################

function new_item()
{

	global $message, $id, $htmladmin, $do;

	$temp_array_new['name'] = 'Untitled';
	$temp_array_new['auto_rotate'] = 'Y';

	$id      = insert_row($temp_array_new,'photo_group');

	$message = "New slideshow has been added and ready to edit";

	header("Location: {$htmladmin}?do={$do}&action=edit&id={$id}");
    exit();
}

?>