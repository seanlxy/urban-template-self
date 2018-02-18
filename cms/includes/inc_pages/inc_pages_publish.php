<?php
############################################################################################################################
## Publish general_pages
############################################################################################################################

function publish_items() {
	global $message,$item_select,$pages_maximum;

	if(!empty($item_select))
    {
            
        $number_of_pages_selected = count($item_select);

        $number_of_active_pages = fetch_value("SELECT COUNT(gp.`id`)
            FROM `general_pages` gp
            LEFT JOIN `page_meta_data` pmd
            ON(gp.`page_meta_data_id` = pmd.`id`)
            WHERE pmd.`status` = 'A'");

        if( ($pages_maximum > $number_of_active_pages + $number_of_pages_selected-1) || ($pages_maximum == '') )
        {
            run_query("UPDATE `page_meta_data` SET `status` = 'A' WHERE `id` IN(".implode(',', $item_select).")");

            $message = "Selected pages have been published";
        }
        else
        {
            $message = "Could not make the selected pages active as it would exceed the maximum number of active pages allowed  <b>(<i>$pages_maximum pages</i>)</b> ";
        }
	}
    else
    {
		$message = "Please select an item from the list";
	}

}

?>