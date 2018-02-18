<?php

############################################################################################################################
## Save slideshow
############################################################################################################################

function save_item()
{

    global $message, $id, $disable_menu, $htmladmin, $rootfull, $rootadmin, $root, $upload_dir;

    $photo_group_data = array();

    $photo_group_data['name'] = sanitize_input('label');

    $photo_group_data['auto_rotate'] = sanitize_input('auto_rotate');
    if($photo_group_data['auto_rotate']=='on'){
        $photo_group_data['auto_rotate']='Y';
    }else{
        $photo_group_data['auto_rotate']='N';
    }


    update_row($photo_group_data, 'photo_group', "WHERE `id` = '{$id}'");
   

    run_query("DELETE FROM `photo` WHERE `photo_group_id` = '{$id}'");

    //  Save new group photos
    $full_path       = $_POST['photo-full-path'];
    $rank            = $_POST['photo-rank'];
    $caption         = $_POST['caption'];
    $caption_heading = $_POST['photo-caption-heading'];
    $alt_text        = $_POST['alt_text'];

    if( !empty($full_path) )
    {
        for($i=0; $i < count($full_path); $i++)
        {

            $photo_data = array();

            $photo_full_path  = "{$rootfull}{$full_path[$i]}";

            if( is_file($photo_full_path) )
            {

                $photo_details                 = getimagesize($photo_full_path);
                
                $photo_data['full_path']       = $full_path[$i];
                $photo_data['rank']            = sanitize_var($rank[$i], FILTER_SANITIZE_NUMBER_INT);
                $photo_data['width']           = $photo_details[0];
                $photo_data['height']          = $photo_details[1];
                $photo_data['caption']         = $caption[$i];
                $photo_data['caption_heading'] = $caption_heading[$i];
                $photo_data['photo_group_id']  = $id;
                $photo_data['alt_text']         = $alt_text[$i];

                insert_row($photo_data, 'photo');

            }

        }
    }

    $message = "Item has been saved";

}


?>