<?php

############################################################################################################################
## Save Testimonial Item
############################################################################################################################

function save_item()
{

    global $message,$id,$do,$disable_menu, $root, $rootfull, $rootadmin, $upload_dir;


    $meta_data = $page_data = array();

    $meta_data_id       = sanitize_input('meta_data_id', FILTER_SANITIZE_NUMBER_INT);
    $url                = (sanitize_input('url')) ? sanitize_input('url') : sanitize_input('menu_label');
    $og_image_path      = sanitize_input('og_image');
    $og_image_full_path = "$rootfull{$og_image_path}";


    $final_url = prepare_item_url($url);

    $meta_data['name']                = sanitize_input('label');
    $meta_data['menu_label']          = sanitize_input('menu_label');
    $meta_data['heading']             = sanitize_input('heading');
    $meta_data['url']                 = $final_url;
    $meta_data['full_url']            = "/category/{$final_url}";
    $meta_data['photo']               = ( is_file($photo_full_path) ) ? $photo_path : '';
    $meta_data['title']               = sanitize_input('title');
    $meta_data['meta_description']    = sanitize_input('meta_description');
    $meta_data['og_title']            = sanitize_input('og_title');
    $meta_data['og_image']            = ( is_file($og_image_full_path) ) ? $og_image_path : '';
    $meta_data['og_meta_description'] = sanitize_input('og_meta_description');
    $meta_data['date_updated']        = date('Y-m-d H:i:s');
    $meta_data['updated_by']          = $_SESSION['s_user_id'];

    update_row($meta_data,'page_meta_data', "WHERE id = '{$meta_data_id}'");

    

    $message = "Item has been saved";
}

?>