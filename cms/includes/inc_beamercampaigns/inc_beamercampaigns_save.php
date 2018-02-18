<?php

############################################################################################################################
## Save Testimonial Item
############################################################################################################################

function save_item()
{
    global $message,$id,$do,$disable_menu, $root, $rootfull, $rootadmin, $upload_dir, $htmladmin;

    include_once("$rootadmin/classes/class_imageresizer.php");
    $resizer_class = new images();
    $upload_dir_full_path = "{$rootfull}{$upload_dir}";

    $data = array();

	$photo_path          = sanitize_input('photo');
    $thumb_photo_path    = sanitize_input('thumb_photo');

    $photo_full_path       = "{$rootfull}{$photo_path}";
    $thumb_photo_full_path = "{$rootfull}{$thumb_photo_path}";

    if( is_file( $thumb_photo_full_path ) )
    {
        unlink($thumb_photo_full_path);
    }

    if( is_file( $photo_full_path ) )
    {
        $thumb_name = uniqid('img-');
        $thumb_web_path = $upload_dir.'/'.$thumb_name;
        $resizer_class->resizer( $upload_dir_full_path, $photo_full_path, 600, 300, $thumb_name );
        $thumb_web_path .= '.jpg';
    }
    else
    {
        $thumb_web_path = '';
        $photo_path     = '';
    }

    $data['name']                 = sanitize_input( 'name' );
	$data['subject']      		  = sanitize_input( 'subject' );
    $data['heading']              = sanitize_input( 'heading' );
	$data['preview_note'] 		  = sanitize_input( 'preview_note' );
    $data['description']          = $_POST['description'];
	$data['terms_and_conditions'] = $_POST['terms_and_conditions'];
	$data['photo']                = $photo_path;
    $data['thumb_photo']          = $thumb_web_path;
    $data['date_updated']         = date('Y-m-d H:i:s');
    $data['updated_by']           = $_SESSION['s_user_id'];
    
    update_row($data, 'beamer_campaign', "WHERE `id` = '{$id}' LIMIT 1");

    //  SAVE CAMPAIGN EMAIL LISTS
    run_query("DELETE FROM `beamer_campaign_has_emails` WHERE `beamer_campaign_id` = '{$id}'");

    $beamer_email_ids = $_POST['beamer_email_id'];

    if( !empty($beamer_email_ids) )
    {
        $campaign_lists_ins_query = '';

        for ($t=0; $t < count($beamer_email_ids); $t++)
        { 
            $beamer_email_id = $beamer_email_ids[$t];
            $campaign_lists_ins_query .= ",('{$id}','{$beamer_email_id}')";
        }
       
        $campaign_lists_ins_query = ltrim($campaign_lists_ins_query, ',');

        if( $campaign_lists_ins_query )
        {
            $ins_query = "INSERT INTO `beamer_campaign_has_emails` (`beamer_campaign_id`, `beamer_email_id`) 
            		VALUES {$campaign_lists_ins_query}";
            
            run_query($ins_query);
        }

    }



    set_flash_msg("Changes has been saved successfully");

    redirect("{$htmladmin}?do={$do}");
}

?>