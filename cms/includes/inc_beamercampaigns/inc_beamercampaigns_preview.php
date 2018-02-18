<?php
############################################################################################################################
## Publish general_pages
############################################################################################################################

function preview_item() 
{
	global $message, $htmladmin, $do, $tmpldir_admin, $classdir, $incdir_admin, $ajaxdir_admin_html , $htmlroot, $rootfull;
	ini_set('display_errors', 'Off');
	
	$campaign_id       = ($_GET['token']) ? $_GET['token'] : $_REQUEST['token'];

	require_once "{$classdir}/underscore.php";
    $objUnderscore = new __();

    $template_path     = "{$incdir_admin}/inc_{$do}/underscore/";
    $email_template_path    = file_get_contents($template_path."campaign_email.tmpl");

    $bemer_ajax_url	   = "{$htmladmin}/ajax/beamer/beamer.php";
    $post_data		   = array("action" => "fetch", "token" => $campaign_id, "is-preview" => "Y");
    

    $email_data = array();
    //curl_setopt($ch, CURLOPT_POSTFIELDS, "action=fetch&token={$campaign_id}");
	
	$ch = curl_init();
	
	curl_setopt($ch, CURLOPT_URL, $bemer_ajax_url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$beamer_campaign_data = curl_exec ($ch);

	curl_close ($ch);
	
	$company_data = fetch_row("SELECT `company_name`, `email_address`, `phone_number`, `address`, `company_logo_path`, `color_palette_id`
            FROM `general_settings`
            WHERE `id` = '1'
            LIMIT 1");

	$campaign_data = fetch_row("SELECT `id`, `name`,`subject`, `heading`, `photo`, `thumb_photo`, `preview_note`, `description`, `terms_and_conditions`
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
    $email_data['company_logo']          = $company_data['company_logo_path'];
	$email_data['company_address']       = $company_data['address'];
	$email_data['company_phone']         = $company_data['phone_number'];
	$email_data['company_free_phone']    = $company_data['free_phone'];
	$email_data['company_website']       = $_SERVER['HTTP_HOST'];
	$email_data['campaign_name']         = $campaign_data['name'];
	$email_data['campaign_subject']      = $campaign_data['subject'];
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
	WHERE `id` = '{$color_palette_id}'");

    $email_data['primary_color'] = $colors['primary_color'];
    $email_data['secondary_color'] = $colors['secondary_color'];
    $email_data['color1'] = $colors['color1'];
    $email_data['color2'] = $colors['color2'];
    $email_data['color3'] = $colors['color3'];

    echo $email_template = $objUnderscore->template($email_template_path, $email_data);
	exit();
}

?>