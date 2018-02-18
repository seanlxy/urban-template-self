<?php
############################################################################################################################
## Delete a page
############################################################################################################################

function delete_items()
{
	global $message,$item_select;

	if( !empty($item_select) )
	{

		// run_query("UPDATE `compendium_section` SET `status` = 'D', `date_deleted` = NOW() WHERE `id` IN(".implode(',', $item_select).")");

		run_query("UPDATE `compendium_section` SET `status` = 'D' WHERE `id` IN(".implode(',', $item_select).")");

		$message = "Selected items have been moved to trash";
	}
	else
	{
		$message = "Please select an item from the list";
	}
}

?>