<?php
## ----------------------------------------------------------------------------------------------------------------------
## Save page
function build_page_url($page_id, $reset = false)
{
    static $urls = array();
    static $count = 0;

    if($page_id)
    {
        $page_data = fetch_row("SELECT gp.`parent_id`, pmd.`url`
            FROM `general_pages` gp
            LEFT JOIN `page_meta_data` pmd
            ON(pmd.`id` = gp.`page_meta_data_id`)
            WHERE gp.`id` = '{$page_id}'
            LIMIT 1");



        if($page_data)
        {
            $pg_url = (in_array($page_data['url'], array('/', 'home'))) ? '' : $page_data['url'];

            array_unshift($urls, $pg_url);

            $parent_id = $page_data['parent_id'];

            if($parent_id != 0)
            {
                build_page_url($parent_id);
            }

        }

    }


    $csv = implode('/', $urls);
    if($reset == true)
    {
        $urls = array();
    }
    return $csv;
}

function save_item (){

	global $id,$message, $rootfull, $rootadmin, $do, $htmladmin, $upload_dir;

	$full_upload_dir_path = "{$rootfull}{$upload_dir}";

	include_once("$rootadmin/classes/class_imageresizer.php");
    $resizer_class = new images();

    $meta_data_id    = sanitize_input('meta_data_id', FILTER_SANITIZE_NUMBER_INT);
	$url             = ($_POST['page_url']) ? sanitize_input('page_url') : sanitize_input('page_label');
	$photo_path      = sanitize_input('photo');
	$photo_full_path = "$rootfull{$photo_path}";
    $parent_id       = sanitize_input('page_parentid', FILTER_SANITIZE_NUMBER_INT);

  //   if( $parent_id != 0 &&  !is_file($photo_full_path) )
  //   {
  //   	header("Location: {$htmladmin}/?do={$do}&action=edit&id={$id}&msg=1");
		// exit();
  //   }

	$meta_data = $page_data = array();

	//  Save  page meta  data

	$thumb_photo_path      = sanitize_input('page_thumb_photo');
	$thumb_photo_full_path = "$rootfull{$thumb_photo_path}";

	if( file_exists($thumb_photo_full_path) && !is_dir($thumb_photo_full_path) )
	{
		unlink($thumb_photo_full_path);
	}

	if( file_exists($photo_full_path) && !is_dir($photo_full_path) )
    {

    	$thumb_name = uniqid('img-');

    	$thumb_web_path = $upload_dir.'/'.$thumb_name;

        $resizer_class->resizer($full_upload_dir_path, $photo_full_path, 640, 570, $thumb_name);

    }
    else
    {
    	$thumb_web_path = '';
    	$photo_path     = '';
    }



    $og_image_path      = sanitize_input('og_image');
    $og_image_full_path = "$rootfull{$og_image_path}";


	$meta_data['name']                 = sanitize_input('page_label');
	$meta_data['menu_label']           = sanitize_input('page_menu');
	$meta_data['footer_menu']          = sanitize_input('page_footer');
	$meta_data['heading']              = sanitize_input('page_heading');
	$meta_data['sub_heading']          = sanitize_input('page_sub_heading');
	$meta_data['introduction']         = sanitize_input('introduction');
	$meta_data['quicklink_heading']    = sanitize_input('quicklink_heading');
	$meta_data['quicklink_menu_label'] = sanitize_input('quicklink_menu_label');
  $ql_photo                            = sanitize_input('quicklink_photo');
	$meta_data['quicklink_photo']        = $ql_photo;
	$meta_data['short_description']    = sanitize_input('short_description');
	$meta_data['url']                  = ($id == 1) ? 'home' : prepare_item_url($url);
	$meta_data['photo']                = $photo_path;
	$meta_data['thumb_photo']          = ($thumb_web_path) ? $thumb_web_path.'.jpg' : '';
	$meta_data['photo_caption']    	   = sanitize_input('page_photo_caption');
	$meta_data['title']                = sanitize_input('title');
	$meta_data['meta_description']     = sanitize_input('meta_description');
	$meta_data['og_title']             = sanitize_input('og_title');
	$meta_data['og_image']             = ( is_file($og_image_full_path) ) ? $og_image_path : '';
	$meta_data['og_meta_description']  = sanitize_input('og_meta_description');
	$meta_data['date_updated']         = date('Y-m-d H:i:s');
	$meta_data['updated_by']           = $_SESSION['s_user_id'];
	$meta_data['page_meta_index_id']   = sanitize_input('page_mrobots');
	$meta_data['slideshow_id']         = sanitize_input('slideshow_id', FILTER_SANITIZE_NUMBER_INT);
	$meta_data['gallery_id']           = sanitize_input('gallery_id', FILTER_SANITIZE_NUMBER_INT);

	$meta_data['page_js_code_head_close']   = filter_input(INPUT_POST, 'page_js_code_head_close');
    $meta_data['page_js_code_body_open']    = filter_input(INPUT_POST, 'page_js_code_body_open');
    $meta_data['page_js_code_body_close']   = filter_input(INPUT_POST, 'page_js_code_body_close');


  if($ql_photo)
	{
		//see if photo has been updated
		$current_ql_photo = fetch_value("SELECT `quicklink_photo` FROM `page_meta_data` WHERE `id` = '$meta_data_id' LIMIT 1");

		if($ql_photo != $current_ql_photo)
		{
			//delete the old thumb
			$current_thumb = fetch_value("SELECT `quicklink_thumb` FROM `page_meta_data` WHERE `id` = '$meta_data_id' LIMIT 1");
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

			$ql_photo_full = "{$rootfull}{$ql_photo}";

			if( is_file($ql_photo_full) )
	        {

				$new_thumb_path = '';
				$thumb_name     = uniqid('img-');
				$new_thumb_path = "{$upload_dir}/{$thumb_name}.jpg";

	            $resizer_class->resizer($upload_dir_full_path, $ql_photo_full, 600, 400, $thumb_name);

	            $meta_data['quicklink_thumb'] = $new_thumb_path;
	        }

		}

	}


	update_row($meta_data,'page_meta_data', "WHERE id = '{$meta_data_id}'");


	//  Save general page data
	$publish_date     = $_POST['page_publish_date'];
	$publish_time     = $_POST['page_publish_time'];
	$publish_datetime = "{$publish_date} {$publish_time}";

	$obj_publish_datetime = (validate_date($publish_datetime, 'd/m/Y H:i:s')) 
		? DateTime::createFromFormat('d/m/Y H:i:s', $publish_datetime) 
		: null;

	$hide_date        = $_POST['page_hide_date'];
	$hide_time        = $_POST['page_hide_time'];
	$hide_datetime    = "{$hide_date} {$hide_time}";

	$obj_hide_datetime = (validate_date($hide_datetime, 'd/m/Y H:i:s')) 
		? DateTime::createFromFormat('d/m/Y H:i:s', $hide_datetime) 
		: null;


	$page_data['publish_on_set_time'] = (sanitize_input('page_timebase_publishing') == 'Y') ? 'Y' : 'N';
	$page_data['publish_on']          = (!empty($obj_publish_datetime)) ? $obj_publish_datetime->format('Y-m-d H:i:s') : '';
	$page_data['hide_on']             = (!empty($obj_hide_datetime)) ? $obj_hide_datetime->format('Y-m-d H:i:s') : '';


	$page_data['slideshow_type']      = (sanitize_input('slideshow_type') === 'C') ? 'C' : 'D';
	$page_data['template_id']         = sanitize_input('template_id', FILTER_SANITIZE_NUMBER_INT);
	$page_data['parent_id']           = $parent_id;
	$page_data['form_id']        = sanitize_input('form_id', FILTER_VALIDATE_INT);

	update_row($page_data,'general_pages', "WHERE id='$id'");


	if( $id != 1 )
	{
	    $full_url = build_page_url($id, true);

	    if( $full_url )
	    {
	        update_row(array('full_url' => "/{$full_url}"), 'page_meta_data', "WHERE `id` = '{$meta_data_id}'");
	    }
    }


	// save quicklinks
	run_query("DELETE FROM `page_has_quicklink` WHERE `page_id` = '{$id}'");

	$quicklinks = $_POST['quicklink_id'];

	if( !empty($quicklinks) )
	{
		for($i=0;$i<count($quicklinks);$i++)
		{
			$ql_arr = array();

			$ql_arr['quicklink_page_id'] = $quicklinks[$i];
			$ql_arr['page_id']           = $id;

			insert_row($ql_arr, 'page_has_quicklink');

		}
	}

	### save page responsive content ###
	// Check if content record exist for this page

	// get all exisitng row belong to this page's content
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


	$mp_rank = $_POST['mp_rank'];
	$mod_id  = $_POST['mod_id'];

	$sql = "DELETE mp.*
            FROM module_pages mp
		    LEFT JOIN modules m ON m.mod_id = mp.mod_id
            WHERE mp.page_id = '$id'
		    AND m.mod_showincms='Y'";

	run_query($sql);

	for($i=0;$i<=count($mod_id);$i++)
	{

		if($mp_rank[$i] >0)
		{

			$temp_array_modules['page_id']       = $id;
			$temp_array_modules['modpages_rank'] = $mp_rank[$i];
			$temp_array_modules['mod_id']        = $mod_id[$i];

			insert_row($temp_array_modules,'module_pages');
		}
	}

	$message = "Page has been saved";
}


?>
