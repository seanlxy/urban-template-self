<?php
############################################################################################################################
## Delete a page
############################################################################################################################

function delete_items()
{
	global $message,$item_select, $htmladmin, $do;

	if( !empty($item_select) )
	{
		$deleted_by = $_SESSION['s_user_id'];
		
		run_query("UPDATE `beamer_campaign` SET `status` = 'D', `date_deleted` = NOW(), `deleted_by`='".$deleted_by."'  WHERE `id` IN(".implode(',', $item_select).")");

		set_flash_msg("Selected items has been removed");
	}
	else
	{
		set_flash_msg("Please select an item from the list");
	}

	redirect("{$htmladmin}?do={$do}");

}

?>