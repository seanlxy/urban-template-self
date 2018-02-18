<?php
############################################################################################################################
## Hide general_pages
############################################################################################################################

function hide_items()
{
    global $message,$item_select;

    if(!empty($item_select))
    {
        run_query("UPDATE `page_meta_data` SET `status` = 'H' WHERE `id` IN(".implode(',', $item_select).")");
        
        $message = "Selected pages have been hidden";
    }
    else
    {
        $message = "Please select an item from the list";
    }

}
?>