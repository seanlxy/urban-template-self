<?php

############################################################################################################################
## Delete user
############################################################################################################################

function delete_item() {
	global $message,$item_select;

        if(!empty($item_select)){

		foreach($item_select as $i){

			$sql = "delete from cms_users where user_id= ".$i;
                        run_query($sql);
                        $message = "Selected users have been deleted";
		}
	}else{

		$message = "Please select a user from the list";

	}
}
?>
