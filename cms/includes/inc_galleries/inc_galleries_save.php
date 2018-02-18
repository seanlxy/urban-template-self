<?php

############################################################################################################################
## Save slideshow
############################################################################################################################

function save_item()
{

    global $message, $id, $disable_menu, $htmladmin, $rootfull, $rootadmin, $root, $upload_dir;

    include_once("$rootadmin/classes/class_imageresizer.php");

    $resizer_class = new images();

    $upload_dir_full_path = "{$rootfull}{$upload_dir}";


    $photo_group_data = array();


    $photo_group_data['name']                 = sanitize_input('label');
    $photo_group_data['menu_label']           = sanitize_input('menu_label');
    $photo_group_data['show_on_gallery_page'] =  ( sanitize_input('show_on_gallery_page') == 'Y') ? 'Y' : 'N';

    update_row($photo_group_data, 'photo_group', "WHERE `id` = '{$id}'");

    //  Remove previous photos
    $prev_photo_thumbs = fetch_all("SELECT `thumb_path` FROM `photo` WHERE `photo_group_id` = '{$id}' AND `thumb_path` != '' ");

    if( !empty($prev_photo_thumbs) )
    {
        foreach ($prev_photo_thumbs as $prev_photo_thumb)
        {
            $prev_photo_thumb_full_path = "{$rootfull}{$prev_photo_thumb['thumb_path']}";

            if( is_file($prev_photo_thumb_full_path) )
            {
                unlink($prev_photo_thumb_full_path);
            }
        }
    }

    run_query("DELETE FROM `photo` WHERE `photo_group_id` = '{$id}'");


    //  Save new group photos
    $full_path  = $_POST['photo-full-path'];
    $thumb_path = $_POST['photo-thumb-path'];
    $rank       = $_POST['photo-rank'];
    $caption    = $_POST['caption'];
    $name       = $_POST['name'];
    $alt_text   = $_POST['alt_text'];

    if( !empty($full_path) )
    {
        for($i=0; $i < count($full_path); $i++)
        {

            $photo_data = array();

            $photo_full_path  = "{$rootfull}{$full_path[$i]}";
            $photo_thumb_path = "{$rootfull}{$thumb_path[$i]}";

            if( is_file($photo_full_path) )
            {

                $photo_details = getimagesize($photo_full_path);

                $new_thumb_path = '';

                $thumb_name = uniqid('img-');

                $new_thumb_path = "{$upload_dir}/{$thumb_name}.jpg";

                $resizer_class->resizer($upload_dir_full_path, $photo_full_path, 250, 206, $thumb_name);


                $photo_data['full_path']      = $full_path[$i];
                $photo_data['thumb_path']     = $new_thumb_path;
                $photo_data['rank']           = sanitize_var($rank[$i], FILTER_SANITIZE_NUMBER_INT);
                $photo_data['width']          = $photo_details[0];
                $photo_data['height']         = $photo_details[1];
                $photo_data['photo_group_id'] = $id;
                $photo_data['caption']        = $caption[$i];
                $photo_data['name']           = $name[$i];
                $photo_data['alt_text']       = $alt_text[$i];
                
                insert_row($photo_data, 'photo');

            }

        }
    }


    $message = "Gallery has been saved";

}


?>