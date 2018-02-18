<?php

############################################################################################################################
## Add a new user
############################################################################################################################

function new_item() {

	global $message,$id;

	$temp_array_new['user_fname'] = 'New User';
	$id = insert_row($temp_array_new,'cms_users');
	$message = "New user has been added and ready to edit";

        @include('inc_users_edit.php');
	edit_item();
}

?>
