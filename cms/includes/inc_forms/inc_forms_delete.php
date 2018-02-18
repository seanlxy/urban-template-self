<?php
############################################################################################################################
## Delete a page
############################################################################################################################

function delete_items()
{
	global $message,$item_select;

	if( !empty($item_select) )
	{

		run_query("UPDATE `form` SET `status` = 'D', `date_deleted` = NOW() WHERE `id` IN(".implode(',', $item_select).")");

		$message = "Selected item(s) have been moved to trash";
	}
	else
	{
		$message = "Please select an item from the list";
	}
}

?>