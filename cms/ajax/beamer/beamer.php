<?php

require_once ('../../../utility/config.php');

if(!$c_Connection->Connect()) {

    echo "Database connection failed";
    exit;
}

$Message   = "";
$c_Message = $c_Connection->GetMessage();


$action = mysql_real_escape_string($_POST['action']);

switch ($action)
{

	case 'fetch':
		get( sanitize_input('token'));
	break;
	case 'add':
		create( sanitize_input('token') );
	break;
	case 'remove':
		delete( sanitize_input('token') );
	break;
	case 'save':
		update( sanitize_input('section') );
	break;
	case 'add-item':
		create_item(sanitize_input('type'), sanitize_input('section'), sanitize_input('item'), sanitize_input('rank') );
	break;
	case 'fetch-items':
		get_section_items(sanitize_input('type'));
	break;
	case 'remove-item':
		delete_section_item(sanitize_input('item'));
	break;
	case 'send-beamer':
		send_beamer(sanitize_input('token'));
	break;
}

function get( $beamer_campaign_id, $send_campaign = 0 )
{
	$beamer_campaign_id = filter_var($beamer_campaign_id, FILTER_VALIDATE_INT);
	$is_preview			= sanitize_input('is-preview');
	
	$data    = array();
	
	if( $beamer_campaign_id )
	{
		/*$data = fetch_all("SELECT  `id` as ind, `heading`, `section_type` AS sectionKey, `rank`, `beamer_campaign_id`
			FROM `beamer_campaign_sections`
			WHERE `beamer_campaign_id` = '{$beamer_campaign_id}'
			ORDER BY `rank`");

		*/
		$sections_query = run_query("SELECT  `id` as ind, `heading`, `section_type` AS sectionKey, `rank`, `beamer_campaign_id`
			FROM `beamer_campaign_sections`
			WHERE `beamer_campaign_id` = '{$beamer_campaign_id}'
			ORDER BY `rank`");
		$total_sections = mysql_num_rows($sections_query);

		if( $total_sections > 0 )
		{
			while( $section = mysql_fetch_assoc($sections_query) )
			{
				$type = $section['sectionKey'];
				$section_id = $section['ind'];
				
				if($is_preview != 'Y'){
					$section['ddItems'] 	= (!empty($type)) ? get_items($type, DD_FLAG) : array(); // GET section ITEMs here for Dropdown
				}
				
				$section['bodyItems'] 	= get_items($type, CONTENT_FLAG, $section_id, 0); // GET section ITEMs here

				$data[] = $section;
			}
		}		
	}

	
	$result_data = json_encode( $data ) ;

	if ($send_campaign == 1)
	{
		return $result_data;
	}
	else
	{
		die( $result_data );
	}
	
}

function create( $beamer_campaign_id )
{
	$beamer_campaign_id  = filter_var($beamer_campaign_id, FILTER_VALIDATE_INT);
	$data    = array();
	$is_valid = false;
	$state    = '';
	$message  = '';

	if( $beamer_campaign_id )
	{

		$temp_section_data = array();

		$temp_section_data['heading'] 			= 'Untitled';
		$temp_section_data['section_type']  	= '';
		$temp_section_data['beamer_campaign_id']= $beamer_campaign_id;

		$campaign_section_id = insert_row( $temp_section_data, 'beamer_campaign_sections' );

		if( $campaign_section_id )
		{
			$is_valid = true;
			$message  = 'New section has been added successfully.';
			$state    = 'success';
		}
	}

	$data['isValid'] = $is_valid;
	$data['state']   = $state;
	$data['msg']     = $message;

	die(json_encode($data));
}

function delete( $section_id )
{
	$section_id = filter_var($section_id, FILTER_VALIDATE_INT);
	$data     = array();
	$is_valid = false;
	$state    = '';
	$message  = '';

	if($section_id)
	{
		run_query("DELETE FROM `beamer_campaign_section_items` WHERE `beamer_campaign_section_id` = '{$section_id}'");
		run_query("DELETE FROM `beamer_campaign_sections` WHERE `id` = '{$section_id}'");
		
		$is_valid = true;
		$state    = 'success';
		$message  = 'Section has been removed successfully.';	
	}
	
	$data['isValid'] = $is_valid;
	$data['state']   = $state;
	$data['msg']     = $message;

	die(json_encode($data));
}

function update( $section_id)
{
	$beamer_campaign_section_id = filter_var($section_id, FILTER_VALIDATE_INT);
	$data    = array();
	$is_valid = false;
	$state    = '';
	$message  = '';

	if($beamer_campaign_section_id)
	{
		$section_data = array();

		$section_data['heading']        = sanitize_input('section-heading');
		$section_data['section_type']   = sanitize_input('section-type');
		$section_data['rank']           = sanitize_input('section-rank', FILTER_VALIDATE_INT);
		
		update_row( $section_data, 'beamer_campaign_sections', "WHERE `id` = '{$beamer_campaign_section_id}' LIMIT 1" );

		$item_rank_arr = $_POST['item-rank'];
        $item_type_arr = (!empty($_POST['item-type'])) ? $_POST['item-type'] : array();

        $itemDifference = array_diff($item_type_arr, array($sectionType));

        if(empty($itemDifference )){

            if($item_rank_arr)
            {
                foreach ($item_rank_arr as $id => $rank)
                {
                    $id = filter_var($id, FILTER_VALIDATE_INT);
                    $rank = filter_var($rank, FILTER_VALIDATE_INT);

                    if($id && $rank)
                    {
                        run_query("UPDATE `beamer_campaign_section_items` SET `rank`= '{$rank}' WHERE `id`='{$id}' LIMIT 1");
                    }
                }
            }

            $is_valid = true;
            $state    = 'success';
            $message  = 'Changes has been saved successfully.';

        } else {

            $state    = 'danger';
            $message  = 'Section has irrelevant item added. Please remove items and try again.';
        }
	}

	$data['isValid'] = $is_valid;
	$data['state']   = $state;
	$data['msg']     = $message;

	die(json_encode($data));
}

function create_item($type, $section_id, $item_id, $item_rank)
{
	$data    = array();
	$is_valid = false;
	$state    = '';
	$message  = '';

	$type  		= filter_var($type, FILTER_SANITIZE_STRING);
	$section_id = filter_var($section_id, FILTER_VALIDATE_INT);
	$item_id 	= filter_var($item_id, FILTER_VALIDATE_INT);
	$item_rank 	= filter_var($item_rank, FILTER_VALIDATE_INT);

	if($section_id && $item_id && $item_rank)
	{
		$temp_item_data = array();

		$temp_item_data['item_id'] 					 = $item_id;
		$temp_item_data['rank']  					 = $item_rank;
		$temp_item_data['beamer_campaign_section_id']= $section_id;

		$new_section_item_id = insert_row( $temp_item_data, 'beamer_campaign_section_items' );

		$data['bodyItems'] 	= get_items($type,CONTENT_FLAG, $section_id, $item_id); 

		if( $new_section_item_id )
		{
			$is_valid = true;
			$message  = 'New item has been added successfully.';
			$state    = 'success';
		}
	}

	$data['isValid'] = $is_valid;
	$data['state']   = $state;
	$data['msg']     = $message;

	die(json_encode($data));
}

function delete_section_item( $item_id )
{
	$item_id = filter_var($item_id, FILTER_VALIDATE_INT);
	$data    = array();
	$is_valid = false;
	$state    = '';
	$message  = '';

	if($item_id)
	{
		run_query("DELETE FROM `beamer_campaign_section_items` WHERE `id` = '{$item_id}'");
		
		$is_valid = true;
		$state    = 'success';
		$message  = 'Item has been removed successfully.';	
	}
	
	$data['isValid'] = $is_valid;
	$data['state']   = $state;
	$data['msg']     = $message;

	die(json_encode($data));
}

function get_section_items($type)
{
	$data    = array();
	$is_valid = false;
	$state    = '';
	$message  = '';

	$section_type  = filter_var($type, FILTER_SANITIZE_STRING);

	if(!empty($section_type))
	{
		$data['ddItems'] = get_items($section_type);
	}

	$is_valid = (count($data['ddItems']) > 0) ? true : false; 

	$data['isValid'] = $is_valid;
	$data['state']   = $state;
	$data['msg']     = $message;

	die(json_encode($data));
}

function get_items($type, $option = DD_FLAG, $section_id = 0, $item_id = 0)
{
	if( $type === 'accommodations' )
	{
		$result_items  = get_accommodations($option, $section_id, $item_id);
	}
	elseif ($type === 'blogs') 
	{
		$result_items = get_blogs($option, $section_id, $item_id);
	}
	elseif ($type === 'pages') 
	{
		$result_items = get_pages($option, $section_id, $item_id);
	}	
	
	return $result_items;
}

function get_accommodations($option, $section_id, $item_id)
{
	$result = array();

	if($option === DD_FLAG)
	{
		$result = fetch_all("SELECT h.`id` AS ind, pmd.`heading` AS label
				FROM `accommodation` h
				LEFT JOIN `page_meta_data` pmd
				ON(pmd.`id` = h.`page_meta_data_id`)
				WHERE pmd.`status` = 'A'
				ORDER BY pmd.`rank`, pmd.`heading`");
	}
	elseif($option === CONTENT_FLAG)
	{
		if($section_id != 0)
		{
			$ex_query = ($item_id != 0) ? ' AND bcsi.`item_id`="'.$item_id.'"' : '';

			$main_sql = "SELECT h.`id` AS ind, 
                                pmd.`heading` AS label,
                                h.`beds`,
                                h.`sqm`,
                                h.`pax`,
                                IF(h.`from_price` != 0, REPLACE(FORMAT(h.`from_price`, 2), '.00', ''), 'POA') AS rate,
                                pmd.`short_description` AS details, pmd.`full_url` AS uri, pmd.`thumb_photo` AS thumbPhoto, 
                                bcsi.`id` AS itemInd, bcsi.`rank` AS itemRank, 'accommodations' AS type
					FROM `beamer_campaign_section_items` bcsi 
					LEFT JOIN `accommodation` h
					  ON(h.`id` = bcsi.`item_id`)
					LEFT JOIN `page_meta_data` pmd
					  ON(pmd.`id` = h.`page_meta_data_id`)
					WHERE pmd.`status` = 'A'
                        AND bcsi.`beamer_campaign_section_id` = '{$section_id}'
                        {$ex_query}
					ORDER BY bcsi.`rank`";

			$result = ($item_id != 0) ? fetch_row($main_sql) : fetch_all($main_sql);
		}
	}

	return $result;
}

function get_blogs($option, $section_id, $item_id)
{
	$result = array();

	if($option === DD_FLAG)
	{
		$result = fetch_all("SELECT bp.`id` AS ind, pmd.`heading` AS label
			FROM `blog_post` bp
            LEFT JOIN `page_meta_data` pmd
            ON(pmd.`id` = bp.`page_meta_data_id`)
            WHERE pmd.`status` = 'A'
            ORDER BY pmd.`status`, bp.`date_posted` DESC");
	}
	elseif($option === CONTENT_FLAG)
	{
		if($section_id != 0)
		{
			$ex_query = ($item_id != 0) ? ' AND bcsi.`item_id`="'.$item_id.'"' : '';

			$main_sql = "SELECT bp.`id` AS ind, pmd.`heading` AS label,
				pmd.`full_url` AS uri, pmd.`short_description` AS details, pmd.`thumb_photo` AS thumbPhoto, 
				bcsi.`id` AS itemInd, bcsi.`rank` AS itemRank, 'blogs' AS type
				FROM `beamer_campaign_section_items` bcsi 
				LEFT JOIN `blog_post` bp
				ON(bp.`id` = bcsi.`item_id`)
				LEFT JOIN `page_meta_data` pmd 
				ON(pmd.`id` = bp.`page_meta_data_id`)
				WHERE pmd.`status` = 'A'
				AND bcsi.`beamer_campaign_section_id` = '{$section_id}'
				{$ex_query}
				ORDER BY bcsi.`rank`";

			$result = ($item_id != 0) ? fetch_row($main_sql) : fetch_all($main_sql);
		}
	}

	return $result;		
}

function get_pages($option, $section_id, $item_id)
{
	$result = array();

	if($option === DD_FLAG)
	{
		$result = fetch_all("SELECT gp.`id` AS ind, pmd.`name` AS label 
            FROM `general_pages` gp
            LEFT JOIN `page_meta_data` pmd
            ON(gp.`page_meta_data_id` = pmd.`id`)
            WHERE pmd.`status` = 'A'
            ORDER BY pmd.`rank`,pmd.`name`");
	}
	elseif($option === CONTENT_FLAG)
	{
		if($section_id != 0)
		{
			$ex_query = ($item_id != 0) ? ' AND bcsi.`item_id`="'.$item_id.'"' : '';

			$main_sql = "SELECT gp.`id` AS ind, pmd.`name` AS label,pmd.`full_url` AS uri, 
			    pmd.`introduction` AS introduction, pmd.`thumb_photo` AS thumbPhoto, 
				bcsi.`id` AS itemInd, bcsi.`rank` AS itemRank, 'pages' AS type
				FROM `beamer_campaign_section_items` bcsi 
				LEFT JOIN `general_pages` gp
				ON(gp.`id` = bcsi.`item_id`)
				LEFT JOIN `page_meta_data` pmd 
				ON(pmd.`id` = gp.`page_meta_data_id`)
				WHERE pmd.`status` = 'A'
				AND bcsi.`beamer_campaign_section_id` = '{$section_id}'
				{$ex_query}
				ORDER BY bcsi.`rank`";

			$result = ($item_id != 0) ? fetch_row($main_sql) : fetch_all($main_sql);
		}
	}

	return $result;		
}

function send_beamer( $campaign_id )
{
	global $classdir, $incdir_admin, $tmpldir_admin, $htmlroot, $rootfull;

	$campaign_id  	= filter_var($campaign_id, FILTER_VALIDATE_INT);
	$do 			= sanitize_input('do');
	$data    		= array();
	$is_valid 		= false;
	$state    		= '';
	$message  		= '';
	$send_beamer 	= 1;

	if( $campaign_id )
	{
		ini_set('display_errors', 'Off');

		require_once "{$classdir}/underscore.php";
		$objUnderscore = new __();

		$template_path     		= "{$incdir_admin}/inc_{$do}/underscore/";
	    $email_template_path    = file_get_contents($template_path."campaign_email.tmpl");

	    $beamer_campaign_data   = get($campaign_id, $send_beamer);

        $company_data = fetch_row("SELECT `company_name`, `email_address`, `mailchimp_email`, `phone_number`, `address`, `company_logo_path`, `color_palette_id`
            FROM `general_settings`
            WHERE `id` = '1'
            LIMIT 1");

		$campaign_data = fetch_row("SELECT `id`, `subject`, `name`, `heading`, `photo`, `thumb_photo`, `preview_note`, `description`, `terms_and_conditions`
	        FROM `beamer_campaign`
	        WHERE `id` = '{$campaign_id}'
	        LIMIT 1");

		$social_links = fetch_all("SELECT `url`, `title`, `icon_alt`, `icon_path`
			FROM `social_links`
			WHERE `is_active` = '1'
			AND (`url` != '')
			ORDER BY `rank` ASC");

		$im_page_sql = "SELECT ip.`imppage_name` AS name, pmd.`url`, pmd.`full_url`, pmd.`name` AS menu_name, pmd.`menu_label`,
		    pmd.`title`, gp.`id` AS pg_id
		    FROM `general_importantpages` ip
		    LEFT JOIN `general_pages` gp
		    ON(gp.`id` = ip.`page_id`)
		    LEFT JOIN `page_meta_data` pmd
		    ON(gp.`page_meta_data_id` = pmd.`id`)
		    WHERE pmd.`status` = 'A'
		    AND pmd.`url` != ''";

	    $im_page_reults = fetch_all($im_page_sql);

	    foreach( $im_page_reults as $key => $page )
	    {
	        $this_importantpage_url  = ($this_importantpage_name != '')  ? $page['url'] : 'home' ;
		    $this_importantpage_name = strtolower(str_replace(' ','',$page['name']));
		    $email_data["page_{$this_importantpage_name}"] = $htmlroot.$page['full_url'];
	    }

		$email_data['root']                  = $htmlroot;
		$email_data['company_name']          = $company_data['company_name'];
		$email_data['company_email']         = $company_data['email_address'];
		$email_data['company_address']       = $company_data['address'];
        $email_data['company_logo']          = $company_data['company_logo_path'];
		$email_data['company_phone']         = $company_data['phone_number'];
		$email_data['company_free_phone']    = $company_data['free_phone'];
		$email_data['company_website']       = $_SERVER['HTTP_HOST'];
		$email_data['campaign_heading']      = $campaign_data['heading'];
		$email_data['campaign_photo']        = $campaign_data['thumb_photo'];
		$email_data['campaign_preview_note'] = $campaign_data['preview_note'];
		$email_data['campaign_details']      = $campaign_data['description'];
		$email_data['campaign_terms']        = $campaign_data['terms_and_conditions'];
		$email_data['social_links']          = $social_links;
		$email_data['sections']              = (array) json_decode($beamer_campaign_data);

        $color_palette_id = $company_data['color_palette_id'];
        $colors = fetch_row("
            SELECT `primary_color`, `secondary_color`, `color1`, `color2`, `color3`
            FROM `color_palette_hex`
            WHERE `id` = '{$color_palette_id}'
        ");

        $email_data['primary_color'] = $colors['primary_color'];
        $email_data['secondary_color'] = $colors['secondary_color'];
        $email_data['color1'] = $colors['color1'];
        $email_data['color2'] = $colors['color2'];
        $email_data['color3'] = $colors['color3'];

	    $email_template = $objUnderscore->template($email_template_path, $email_data);

	    if( $email_template )
		{
			// Initiate php mailer class to send email
			require_once "$classdir/class_phpmailer.php";
			
			// get comany details i.e. name and emai laddress
			$company_email   = (!empty($company_data['mailchimp_email'])) ? $company_data['mailchimp_email'] : '';
			$company_name    = ($company_data['company_name']) ? $company_data['company_name'] : '';

			if( $company_email )
			{
				$beam_emails = fetch_all("SELECT be.`id`, be.`list_email_address` AS beamer_email
					FROM `beamer_campaign_has_emails` bche 
					LEFT JOIN `beamer_email`be
					ON(be.`id` = bche.`beamer_email_id`)
					WHERE bche.`beamer_campaign_id` = '{$campaign_id}'
					AND be.`status` = 'A'
					AND be.`list_email_address` != ''");

				if($beam_emails)
				{
					foreach ($beam_emails as $beam_email) {
						$beamer_email_address = $beam_email['beamer_email'];

						// Send Email
						$mail = new PHPMailer();
						$mail->IsHTML();
						$mail->AddReplyTo($company_email);
						$mail->AddAddress($beamer_email_address);
						$mail->SetFrom($company_email);
						$mail->FromName = $company_name;
						$mail->Subject  = $campaign_data['subject'];
						$mail->msgHTML($email_template);
						
						$is_mail_sent =  $mail->Send();
						
						if($is_mail_sent)
						{
							$temp_data = array();
							$temp_data['beamer_phase']  	  = 'P'; // P = Published / Sent
							
							update_row($temp_data, 'beamer_campaign', "WHERE `id` = '{$campaign_id}' LIMIT 1");
							
							$is_valid     = true;
							$state        = 'success';
							$message      = 'Newsletter has been sent to MailChimp.';
						}						
					}
				} else {
                    $state        = 'danger';
                    $message      = 'Please select at least one campaign list.';
                }
			}
			else
			{
				$state        = 'danger';
				$message      = 'Please add MailChimp Account Email.';
			}
		}
		else
		{
			$state        = 'danger';
			$message      = "Couldn't send newsletter to MailChimp. Please try again later.";
		}
	}

	$data['isValid'] = $is_valid;
	$data['state']   = $state;
	$data['msg']     = $message;

	die(json_encode($data));
}

?>