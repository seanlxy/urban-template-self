<?php

############################################################################################################################
## Save Testimonial Item
############################################################################################################################

function save_item()
{

    global $message,$id,$do,$disable_menu, $root, $rootfull, $rootadmin, $upload_dir;


    //Get full url of accom page
    $sql = "SELECT pmd.`full_url`
            FROM `page_meta_data` pmd
            LEFT JOIN `general_pages` gp
            ON(pmd.`id` = gp.`page_meta_data_id`)
            LEFT JOIN `general_importantpages` imp
            ON(imp.`page_id` = gp.`id`)
            WHERE imp.`imppage_id` = 5 LIMIT 1";

    $accom_url = fetch_value($sql);

    //Save Meta Data
    $meta_data                      = $page_data = array();
    $meta_data_id                   = sanitize_input('meta_data_id', FILTER_SANITIZE_NUMBER_INT);
    $meta_data['name']              = sanitize_input('name');
    $meta_data['menu_label']        = sanitize_input('menu_label');
    $meta_data['heading']           = sanitize_input('heading');
    $url                            = prepare_item_url($_POST['url']);
    $meta_data['url']               = $url;
    $full_url                       = $accom_url.'/'.$url;
    $meta_data['full_url']          = $full_url;
    $meta_data['title']             = sanitize_input('title');
    $meta_data['meta_description']  = sanitize_input('meta_description');
    $photo                          = sanitize_input('photo');
    $meta_data['photo']             = $photo;
    $meta_data['introduction']      = sanitize_input('introduction');
    $meta_data['short_description'] = sanitize_input('short_description');
    $meta_data['og_title']          = sanitize_input('og_title');
    $meta_data['og_meta_description']= sanitize_input('og_meta_description');
    $meta_data['og_image']          = sanitize_input('og_image');
    $meta_data['date_updated']      = date('Y-m-d H:i:s');
    $meta_data['updated_by']        = $_SESSION['s_user_id'];




    if($photo)
    {
        //see if photo has been updated
        $current_photo = fetch_value("SELECT `photo` FROM `page_meta_data` WHERE `id` = '$meta_data_id' LIMIT 1");

        if($photo != $current_photo)
        {
            //delete the old thumb
            $current_thumb = fetch_value("SELECT `thumb_photo` FROM `page_meta_data` WHERE `id` = '$meta_data_id' LIMIT 1");

            if($current_thumb)
            {
                $current_thumb_full = "{$rootfull}{$current_thumb}";

                if( is_file($current_thumb_full) )
                {
                    unlink($current_thumb_full);
                }
            }

            include_once("$rootadmin/classes/class_imageresizer.php");
            $resizer_class = new images();
            $upload_dir_full_path = "{$rootfull}{$upload_dir}";

            $photo_full = "{$rootfull}{$photo}";

            if( is_file($photo_full) )
            {

                $new_thumb_path = '';
                $thumb_name     = uniqid('img-');
                $new_thumb_path = "{$upload_dir}/{$thumb_name}.jpg";

                $resizer_class->resizer($upload_dir_full_path, $photo_full, 570, 500, $thumb_name);

                $meta_data['thumb_photo'] = $new_thumb_path;
            }

        }

    }

    update_row($meta_data,'page_meta_data', "WHERE id = '{$meta_data_id}'");

    $accom_data                 = array();
    $accom_data['from_price']   = sanitize_input('from_price');
    $accom_data['gallery_id']   = sanitize_input('gallery_id', FILTER_SANITIZE_NUMBER_INT);
    $accom_data['slideshow_id'] = sanitize_input('slideshow_id', FILTER_SANITIZE_NUMBER_INT);

    $accom_data['beds']         = sanitize_input('beds');
    $accom_data['pax']          = sanitize_input('pax');
    $accom_data['sqm']          = sanitize_input('sqm');
    $accom_data['latitude']                       = $_POST['latitude'];
    $accom_data['longitude']                      = $_POST['longitude'];
    $accom_data['google_map_address']             = $_POST['google_map_address'];
    $latitude           = $accom_data['latitude'];
    $longitude          = $accom_data['longitude'];
    $google_map_address = $accom_data['google_map_address'];
    $accom_data['address']           = $_POST['address'];
    // preprint_r($accom_data);die;

    update_row($accom_data,'accommodation', "WHERE id = '{$id}'");

    // save features
    run_query("DELETE FROM `accom_has_feature` WHERE `accom_id` = '{$id}'");

    $feature_id = $_POST['feature_id'];

    if(count($feature_id) > 0)
    {
        for($i=0;$i<count($feature_id);$i++)
        {
            $ins_arr = array();
            $ins_arr['feature_id'] = $feature_id[$i];
            $ins_arr['accom_id'] = $id;

            insert_row($ins_arr, 'accom_has_feature');

        }
    }


    ### save page responsive content ###
    // Check if content record exist for this page

    //get all exisitng row belong to this page's content
    $existing_rows = fetch_value("SELECT GROUP_CONCAT(`id`) FROM `content_row` WHERE `page_meta_data_id` = '$meta_data_id'");

    if($existing_rows)
    {
        // delete all columns
        run_query("DELETE FROM `content_column` WHERE `content_row_id` IN($existing_rows)");

        // delete all rows
        run_query("DELETE FROM `content_row` WHERE `id` IN($existing_rows)");
    }

    if( !empty($_POST['row-index']) && $meta_data_id )
    {


        // save new content rows and columns
        $rows      = $_POST['row-index'];
        $rows_rank = $_POST['row-rank'];
        $row_count = count($rows);

        if($row_count > 0)
        {
            for ($i=0; $i < $row_count; $i++)
            {
                $row_record = array();
                $row_record['rank']              = ($rows_rank[$i]);
                $row_record['page_meta_data_id'] = $meta_data_id;

                $row_id = insert_row($row_record, 'content_row');

                if( $row_id )
                {

                    $columns_rank    = $_POST["content-{$rows[$i]}-rank"];
                    $columns_content = $_POST["content-{$rows[$i]}-text"];
                    $columns_class   = $_POST["content-{$rows[$i]}-class"];

                    $total_row_columns = count($columns_content);

                    if($total_row_columns > 0)
                    {
                        for ($k=0; $k < $total_row_columns; $k++)
                        {
                            $column_record                   = array();

                            $column_record['content']        = $columns_content[$k];
                            $column_record['css_class']      = $columns_class[$k];
                            $column_record['rank']           = $columns_rank[$k];
                            $column_record['content_row_id'] = $row_id;

                            insert_row($column_record, 'content_column');
                        }
                    }

                }
            }
        }



    }
    //save compendium content
    run_query("DELETE FROM `accommodation_has_compendium_section` WHERE `accommodation_id` = '$id'");

    $compendium_content = $_POST['compendium_content'];
    $compendium_id      = $_POST['compendium_id'];
    $is_map             = $_POST['is_map'];

    $generic_sections = fetch_all("SELECT `id` FROM `compendium_section` WHERE `is_generic` = '1' AND `status` = 'A' ORDER BY `rank`");

    if(!empty($generic_sections))
    {
        foreach ($generic_sections as $gen) {

            $insert_gen_section                          = array();
            $insert_gen_section['compendium_section_id'] = $gen['id'];
            $insert_gen_section['accommodation_id']           = $id;

            insert_row($insert_gen_section, 'accommodation_has_compendium_section');
        }
    }

    if(count($compendium_content) > 0)
    {
        for ($z=0; $z < count($compendium_content); $z++)
        {

            if($is_map[$z] == 1)
            {
                $insert_comp_section                          = array();
                $insert_comp_section['content']               = $compendium_content[$z];
                $insert_comp_section['compendium_section_id'] = $compendium_id[$z];
                $insert_comp_section['accommodation_id']           = $id;

                insert_row($insert_comp_section, 'accommodation_has_compendium_section');
            }
            else
            {
                if($compendium_content[$z] && $compendium_id[$z])
                {

                    $insert_comp_section                          = array();
                    $insert_comp_section['content']               = $compendium_content[$z];
                    $insert_comp_section['compendium_section_id'] = $compendium_id[$z];
                    $insert_comp_section['accommodation_id']           = $id;

                    insert_row($insert_comp_section, 'accommodation_has_compendium_section');
                }
            }

        }

    }



    $message = "Item has been saved";
}

?>
