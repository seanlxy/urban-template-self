<?php
############################################################################################################################
## Delete a page
############################################################################################################################

function delete_items()
{
	global $message,$item_select, $htmladmin, $do;

	if( !empty($item_select) )
	{
		run_query("UPDATE `beamer_email` SET `status` = 'D' WHERE `id` IN(".implode(',', $item_select).")");
		set_flash_msg("Selected items has been removed");
	}
	else
	{
		set_flash_msg("Please select an item from the list");
	}

	redirect("{$htmladmin}?do={$do}");

}

?>