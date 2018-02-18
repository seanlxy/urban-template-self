<?php

############################################################################################################################
## Save Testimonial Item
############################################################################################################################

function save_item()
{

    global $message,$id,$do,$disable_menu, $root, $rootfull, $rootadmin, $upload_dir;


    $meta_data = $page_data = array();
    
    $meta_data_id       = sanitize_input('meta_data_id', FILTER_SANITIZE_NUMBER_INT);
    $author             = sanitize_input('author', FILTER_SANITIZE_NUMBER_INT);
    $url                = (sanitize_input('url')) ? sanitize_input('url') : sanitize_input('menu_label');
    $date_posted        = sanitize_input('posted_on');
    $og_image_path      = sanitize_input('og_image');

    $og_image_full_path = "$rootfull{$og_image_path}";

    $final_url = prepare_item_url($url);

    $thumb_photo = sanitize_input('thumb_photo');
    $photo       = sanitize_input('photo');

    if($thumb_photo)
    {
        $current_thumb_full = "{$rootfull}{$thumb_photo}";

        if( is_file($current_thumb_full) )
        {
            unlink($current_thumb_full);
        }
    }

    if($photo)
    {

        include_once("$rootadmin/classes/class_imageresizer.php");

        $resizer_class        = new images();
        $upload_dir_full_path = "{$rootfull}{$upload_dir}";
        $photo_full           = "{$rootfull}{$photo}";

        if( is_file($photo_full) )
        {
            
            $new_thumb_path           = '';
            $thumb_name               = uniqid('img-');
            $new_thumb_path           = "{$upload_dir}/{$thumb_name}.jpg";
            $meta_data['thumb_photo'] = $new_thumb_path;

            $resizer_class->resizer($upload_dir_full_path, $photo_full, 450, 300, $thumb_name);
            
        }
        
    }
    else
    {
        $meta_data['thumb_photo'] = '';
    }


    $meta_data['name']                = sanitize_input('heading');
    $meta_data['heading']             = sanitize_input('heading');
    $meta_data['url']                 = $final_url;
    $meta_data['full_url']            = "/post/{$final_url}";
    $meta_data['title']               = sanitize_input('title');
    $meta_data['meta_description']    = sanitize_input('meta_description');
    $meta_data['description']         = $_POST['description'];
    $meta_data['og_title']            = sanitize_input('og_title');
    $meta_data['og_image']            = ( is_file($og_image_full_path) ) ? $og_image_path : '';
    $meta_data['og_meta_description'] = sanitize_input('og_meta_description');
    $meta_data['date_updated']        = date('Y-m-d H:i:s');
    $meta_data['updated_by']          = ($author) ? $author : $_SESSION['s_user_id'];
    $meta_data['photo']               = $photo;
    $meta_data['short_description']   = sanitize_input('short_description');

    update_row($meta_data,'page_meta_data', "WHERE id = '{$meta_data_id}'");


    $date_posted_obj = (validate_date($date_posted, 'd/m/Y')) ? DateTime::createFromFormat('d/m/Y', $date_posted) : '';

    $page_data['date_posted'] = ($date_posted_obj) ? $date_posted_obj->format('Y-m-d') : '';

    update_row($page_data, 'blog_post', "WHERE `id` = '{$id}' LIMIT 1");

    
    // ### save page responsive content ###
    // // Check if content record exist for this page

    // if( !empty($_POST['row-index']) && $meta_data_id )
    // {

    //     // get all exisitng row belong to this page's content
    //     $existing_rows = fetch_value("SELECT GROUP_CONCAT(`id`) FROM `content_row` WHERE `page_meta_data_id` = '$meta_data_id'");

    //     if($existing_rows)
    //     {
    //         // delete all columns
    //         run_query("DELETE FROM `content_column` WHERE `content_row_id` IN($existing_rows)");

    //         // delete all rows
    //         run_query("DELETE FROM `content_row` WHERE `id` IN($existing_rows)");
    //     }

    //     // save new content rows and columns
    //     $rows      = $_POST['row-index'];
    //     $rows_rank = $_POST['row-rank'];
    //     $row_count = count($rows);

    //     if($row_count > 0)
    //     {
    //         for ($i=0; $i < $row_count; $i++)
    //         { 
    //             $row_record = array();
    //             $row_record['rank']              = ($rows_rank[$i]);
    //             $row_record['page_meta_data_id'] = $meta_data_id;

    //             $row_id = insert_row($row_record, 'content_row');

    //             if( $row_id )
    //             {
                    
    //                 $columns_rank    = $_POST["content-{$rows[$i]}-rank"];
    //                 $columns_content = $_POST["content-{$rows[$i]}-text"];
    //                 $columns_class   = $_POST["content-{$rows[$i]}-class"];

    //                 $total_row_columns = count($columns_content);

    //                 if($total_row_columns > 0)
    //                 {
    //                     for ($k=0; $k < $total_row_columns; $k++) 
    //                     { 
    //                         $column_record                   = array();
                            
    //                         $column_record['content']        = $columns_content[$k];
    //                         $column_record['css_class']      = $columns_class[$k];
    //                         $column_record['rank']           = $columns_rank[$k];
    //                         $column_record['content_row_id'] = $row_id;

    //                         insert_row($column_record, 'content_column');
    //                     }
    //                 }

    //             }
    //         }
    //     }
            
        

    // }


    // Attach categories

    run_query("DELETE FROM `blog_post_has_category` WHERE `post_id` = '{$id}'");

    $category_ids = $_POST['category_id'];

    if( !empty($category_ids) && is_array($category_ids) )
    {
        for ($i=0; $i < count($category_ids) ; $i++)
        { 
           $data = array();
           
           $data['category_id'] = $category_ids[$i];
           $data['post_id']     = $id;

           insert_row($data, 'blog_post_has_category');
        }
    }

    $message = "Item has been saved";
}

?>