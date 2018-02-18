<?php
############################################################################################################################
## Publish general_pages
############################################################################################################################

function publish_items() {
	global $message, $item_select, $pages_maximum, $htmladmin, $do;

	if( !empty($item_select) )
    {
        
       
        run_query("UPDATE `beamer_email` SET `status` = 'A' WHERE `id` IN(".implode(',', $item_select).")");

        set_flash_msg("Selected items has been published");
	}
    else
    {
		set_flash_msg("Please select an item from the list");
	}

	redirect("{$htmladmin}?do={$do}");

}

?>