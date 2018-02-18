<?php
############################################################################################################################
## Hide items
############################################################################################################################

function hide_items()
{
    global $message, $item_select, $htmladmin, $do;

    if(!empty($item_select))
    {
        
        run_query("UPDATE `beamer_campaign` SET `status` = 'H' WHERE `id` IN(".implode(',', $item_select).")");
        
        set_flash_msg("Selected items has been hidden");
    }
    else
    {
        set_flash_msg("Please select an item from the list");
    }

    redirect("{$htmladmin}?do={$do}");

}
?>