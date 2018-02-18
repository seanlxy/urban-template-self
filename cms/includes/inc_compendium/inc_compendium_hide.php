<?php
############################################################################################################################
## Hide items
############################################################################################################################

function hide_items()
{
    global $message,$item_select;

    if(!empty($item_select))
    {

        
        run_query("UPDATE `compendium_section` SET `status` = 'H' WHERE `id` IN(".implode(',', $item_select).")");
        
        $message = "Selected items have been hidden";
    }
    else
    {
        $message = "Please select an item from the list";
    }

}
?>