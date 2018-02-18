<?php

############################################################################################################################
## Delete slideshows
############################################################################################################################

function delete_item()
{
    global $message, $item_select, $rootfull;



    if( !empty($item_select) )
    {

        $photo_group_csv = implode(',', $item_select);

        if( $photo_group_csv )
        {
            
            run_query("UPDATE `general_pages` SET `gallery_id` = '0' WHERE `gallery_id` IN($photo_group_csv)");

            $photos = fetch_all("SELECT `thumb_path` FROM `photo` WHERE `photo_group_id` IN($photo_group_csv) AND `thumb_path` != ''");

            if( !empty($photos) )
            {
                foreach ( $photos as $photo )
                {
                    $thumb_path      = $photo['thumb_path'];
                    $thumb_full_path = "{$rootfull}{$thumb_path}";

                    if( is_file($thumb_full_path) )
                    {
                        unlink($thumb_full_path);
                    }

                }
            }

            run_query("DELETE FROM `photo` WHERE `photo_group_id` IN($photo_group_csv)");

            run_query("DELETE FROM `photo_group` WHERE `id` IN($photo_group_csv)");

            $message = "Galleries has been deleted successfully.";
        }

    }
    else
    {
        $message = "Please select a gallery from the list";
    }
}

?>
