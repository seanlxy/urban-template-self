<?php

############################################################################################################################
## Delete slideshows
############################################################################################################################

function delete_item()
{
    global $message, $item_select;



    if( !empty($item_select) )
    {

        $photo_group_csv = implode(',', $item_select);

        if( $photo_group_csv )
        {
            
            run_query("UPDATE `general_pages` SET `slideshow_id` = '0' WHERE `slideshow_id` IN($photo_group_csv)");

            run_query("DELETE FROM `photo` WHERE `photo_group_id` IN($photo_group_csv)");

            run_query("DELETE FROM `photo_group` WHERE `id` IN($photo_group_csv)");

            $message = "Slideshow(s) has been deleted successfully.";
        }

    }
    else
    {
        $message = "Please select a slideshow from the list";
    }
}

?>
