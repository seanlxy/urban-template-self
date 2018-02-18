<?php

############################################################################################################################
## Hide FAQ
############################################################################################################################

function hide_items() {

	global $message,$item_select,$htmladmin;

 	if(!empty($item_select))
    {
    	$ids = implode(', ', $item_select);
		
	 	$query = "UPDATE redirect SET status = 'H' WHERE id IN ($ids)";
	 	run_query($query);

	 	$message = "Selected items have been hidden";
	}
	else
	{
		$message = "Please select an item from the list";
	}

}

?>
