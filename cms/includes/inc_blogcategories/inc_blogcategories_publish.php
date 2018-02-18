<?php
############################################################################################################################
## Publish general_pages
############################################################################################################################

function publish_items() {
	global $message,$item_select,$pages_maximum;

	if( !empty($item_select) )
    {
        
       
        run_query("UPDATE `page_meta_data` SET `status` = 'A' WHERE `id` IN(".implode(',', $item_select).")");

        $message = "Selected pages have been published";
	}
    else
    {
		$message = "Please select an item from the list";
	}

}

?>