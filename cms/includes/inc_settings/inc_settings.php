<?php
## ----------------------------------------------------------------------------------------------------------------------
## NetZone 1.0
## inc_settings.php
##
## Author: Ton Jo Immanuel, Tomahawk Brand Management Ltd.
## Date: 19 April 2010
##
## Manage Settings
##
##
## ----------------------------------------------------------------------------------------------------------------------


function do_main()
{

    global $message,$valid,$htmladmin,$scripts_onload,$main_heading, $incdir, $rootadmin;

    $action     = $_REQUEST['action'];

    $main_heading = 'Website Settings';

    switch ($action) {

        case 'save':

            $return = save_item();
            break;

    }
    
    if ($message != "") {

        $page_contents .= <<< HTML
          <div class="alert alert-warning page">
             <i class="glyphicon glyphicon-info-sign"></i>
              <strong>$message</strong>
          </div>
HTML;
    

    }

    $sql = "SELECT `id`, 
        `company_name`, 
        `start_year`, 
        `email_address`, 
        `phone_number`,
        `address`, 
        `js_code_head_close`, 
        `js_code_body_open`, 
        `js_code_body_close`, 
        `adwords_code`,
        `slideshow_speed`, 
        `homepage_slideshow_caption`, 
        `mailchimp_api_key`, 
        `mailchimp_list_id`, 
        `mailchimp_email`, 
        `resbook_id`,
        `map_latitude`, 
        `map_longitude`, 
        `map_address`, 
        `map_styles`, 
        `map_heading`, 
        `map_description`,
        `map_zoom_level`, 
        `map_marker_latitude`, 
        `map_marker_longitude`, 
        `tripadvisor_widget_code`, 
        `color_palette_id`, 
        `company_logo_path`, 
        `webfont_headings`, 
        `webfont_text`,
        `booking_engine_url`
        FROM `general_settings`
        WHERE `id` = '1'
        LIMIT 1";
    
    $row = fetch_row($sql);

    extract($row);


    $map_latitude         = ( $map_latitude != 0 ) ? $map_latitude : '';
    $map_longitude        = ( $map_longitude != 0 ) ? $map_longitude : '';
    $map_zoom_level       = ( $map_zoom_level ) ? $map_zoom_level : 8;
    $map_marker_latitude  = ( $map_marker_latitude != 0 ) ? $map_marker_latitude : '';
    $map_marker_longitude = ( $map_marker_longitude != 0 ) ? $map_marker_longitude : '';

    ##------------------------------------------------------------------------------------------------------
    ## Page functions

    $page_functions = <<< HTML
        <ul class="page-action">
            <li><button type="button" class="btn btn-default" onclick="submitForm('save',1)"><i class="glyphicon glyphicon-floppy-save"></i> Save</button></li>
        </ul>
HTML;

// Social Icons

 $social_icons = fetch_all("SELECT `id`, `label`, `url`, `widget_blob`, `has_widget` FROM `social_links` WHERE `is_active` = '1' ORDER BY `rank`");

    if(count($social_icons) > 0)
    {
        $links = '';
        foreach ($social_icons as $index => $social_icon)
        {
            $index++;

            if($social_icon['has_widget'])
            {
                $input = '<textarea style="width:700px;height:150px;" name="social-item[]" >'.$social_icon['widget_blob'].'</textarea>';
            }
            else
            {
                $input = '<input type="text" style="width:700px" name="social-item[]" value="'.$social_icon['url'].'" id="social-item-'.$index.'">';
            }
           $links .= <<< H
            <tr>
                <td width="150" valign="top"><label for="social-item-$index">{$social_icon['label']}</label></td>
                <td>
                    <input type="hidden" name="social-item-id[]" value="{$social_icon['id']}">
                    <input type="hidden" name="social-item-has-wdge[]" value="{$social_icon['has_widget']}">
                    $input
                </td>
            </tr>
H;
        }
    
    $social_links = <<< H
    
<table width="100%" border="0" cellspacing="0" cellpadding="4">
    $links
</table>

H;

}
else
{
    $social_links = '';
}


    ##------------------------------------------------------------------------------------------------------
    ## Important Pages

    $sql = "SELECT `imppage_name`, `imppage_id`, `page_id`
        FROM `general_importantpages`
        WHERE `imppage_showincms` = 'Y'";


    $imppages_arr = fetch_all($sql);

    $imppages_list = '<table cellspacing="0" cellpadding="5" border="0">';
    foreach($imppages_arr as $key => $array)
    {
        $imppage_name = ucwords($array['imppage_name']);
        $page_id      = $array['page_id'];
        $imppage_id   = $array['imppage_id'];

        $pages_select = page_list(false, 0, $page_id);

        $imppages_list .= <<< HTML
            <tr>
                <td>$imppage_name <input type="hidden" name="imppage_id[]" value="$imppage_id"/></td>
                <td>
                    <select name="page_id[]">
                        <option value="">--select--</option>
                        $pages_select
                    </select>
                </td>
            </tr>
HTML;
    }
    $imppages_list .= <<< HTML
        </table>
HTML;



   
    ##------------------------------------------------------------------------------------------------------
    ## Details Content
    $companydetails_content = <<< HTML
        <table width="100%" border="0" cellspacing="0" cellpadding="4">
            <tr>
                <td width="150"><label for="company_name">Company name</label></td>
                <td><input name="company_name" id="company_name" type="text" value="{$company_name}" style="width:350px;" /></td>
            </tr>
            <tr>
                <td width="150"><label for="phone_number">Phone Number</label></td>
                <td>
                    <input name="phone_number" type="text" value="{$phone_number}" style="width:350px;" id="phone_number" />
                </td>
            </tr>
            <!-- <tr>
                <td width="150"><label for="start_year">Start year</label></td>
                <td><input name="start_year" type="text" value="{$start_year}" style="width:150px;" id="start_year" /></td>
            </tr> -->
            <tr>
                <td width="150" valign="top"><label for="email_address">Email Addresses</label> <span data-title="Separate multiple email addresses with a semicolon ( ; )" data-placement="right" data-toggle="tooltip"></span></td>
                <td><textarea name="email_address" style="width:350px;min-height:100px;">{$email_address}</textarea></td>
            </tr>
            <tr>
                <td width="150"><label for="resbook_id">Resbook User ID</label></td>
                <td><input name="resbook_id" type="text" value="{$resbook_id}" style="width:350px;" id="resbook_id" /></td>
            </tr>
            <tr>
                <td width="150"><label>OR</label></td>
            </tr>
            <tr>
                <td width="150"><label for="booking_engine_url">Booking Engine URL</label></td>
                <td><input name="booking_engine_url" type="text" value="{$booking_engine_url}" style="width:350px;" id="booking_engine_url" /></td>
            </tr>
            <tr>
                <td width="150" valign="top"><label for="tripadvisor_widget_code">TripAdvisor Badge Code</label></td>
                <td><textarea name="tripadvisor_widget_code" style="width:600px;min-height:200px;">{$tripadvisor_widget_code}</textarea></td>
            </tr>
            <!--<tr>
                <td width="150"><label for="booking_url">Booking URL</label></td>
                <td><input name="booking_url" type="text" value="{$booking_url}" style="width:350px;" id="booking_url" /></td>
            </tr>
            <tr>
                <td width="150"><label for="homepage_slideshow_caption">Homepage Slideshow Caption</label></td>
                <td><input name="homepage_slideshow_caption" id="homepage_slideshow_caption" type="text" value="{$homepage_slideshow_caption}" style="width:350px;" /></td>
            </tr>-->
            <tr>
                <td width="150" valign="top"><label for="address">Address</label></td>
                <td><textarea name="address" style="width:350px;min-height:100px;">{$address}</textarea></td>
            </tr>
            <tr><td colspan="2">&nbsp;</td></tr>
        </table>

HTML;




    ##------------------------------------------------------------------------------------------------------
    ## Important pages Content
    $importantpages_content = <<< HTML
        <table width="100%" border="0" cellspacing="0" cellpadding="4">
            <tr>
                <td colspan="4">$imppages_list</td>
            </tr>
        </table>
HTML;



    ##------------------------------------------------------------------------------------------------------
    ## Developer Content
    $developer_content = <<< HTML
        <table width="100%" border="0" cellspacing="0" cellpadding="4">
            <tr>
                <td valign="top"><label for="js_code_head_close">Head tag insert (close)</label></td>
                <td valign="top">
                    <textarea name="js_code_head_close" style="width:720px; height:150px;resize:none;" id="js_code_head_close">{$js_code_head_close}</textarea>
                    <span data-toggle="tooltip" data-placement="left" data-title="Insert code before closing head tag e.g Google Analytics, Facebook Pixel"></span>
                </td>
            </tr>
            <tr>
                <td valign="top"><label for="js_code_body_open">Body tag insert (open)</label></td>
                <td valign="top">
                    <textarea name="js_code_body_open" style="width:720px; height:150px;resize:none;" id="js_code_body_open">{$js_code_body_open}</textarea>
                    <span data-toggle="tooltip" data-placement="left" data-title="Insert code after opening body tag e.g Google Analytics, Facebook Pixel"></span>
                </td>
            </tr>
            <tr>
                <td valign="top"><label for="js_code_body_close">Body tag insert (close)</label></td>
                <td valign="top">
                    <textarea name="js_code_body_close" style="width:720px; height:150px;resize:none;" id="js_code_body_close">{$js_code_body_close}</textarea>
                    <span data-toggle="tooltip" data-placement="left" data-title="Insert code before closing body tag e.g Google Analytics, Facebook Pixel"></span>
                </td>
            </tr>
            <!-- <tr>
                <td valign="top"><label for="adwords_code">AdWords Tracking Code</label></td>
                <td valign="top">
                    <textarea name="adwords_code" style="width:720px; height:150px;resize:none;" id="adwords_code">{$adwords_code}</textarea>
                    <span data-toggle="tooltip" data-placement="left" data-title="Google AdWords Tracking Code"></span>
                </td>
            </tr> -->
        </table>
HTML;

// $widgets_content = <<< HTML
//             <table width="100%" border="0" cellspacing="0" cellpadding="4">
//                 <tr>
//                     <td style="vertical-align:top;">Trip Advisor Widget</td>
//                     <td colspan="3">
//                         <textarea name="tripadvisor_widget" style="width:790px; height:200px;">$tripadvisor_widget</textarea>
//                     </td>
//                 </tr>
//                 <tr>
//                     <td style="vertical-align:top;">Facebook Widget</td>
//                     <td colspan="3">
//                         <textarea name="facebook_widget" style="width:790px; height:200px;">$facebook_widget</textarea>
//                     </td>
//                 </tr>
//             </table>
// HTML;

    $mailchimp_settings_content = <<< MAILCHIMP
        <table width="100%" border="0" cellspacing="0" cellpadding="4">
            <tr>
                <td width="150"><label for="mailchimp_email">MailChimp Account Email</label></td>
                <td><input name="mailchimp_email" type="text" value="{$mailchimp_email}" style="width:350px;" id="mailchimp_email" /></td>
            </tr>
            <tr>
                <td width="150"><label for="mailchimp_api_key">MailChimp API Key</label></td>
                <td><input name="mailchimp_api_key" type="text" value="{$mailchimp_api_key}" style="width:350px;" id="mailchimp_api_key" /></td>
            </tr>
            <tr>
                <td width="150"><label for="mailchimp_list_id">MailChimp List ID</label></td>
                <td><input name="mailchimp_list_id" type="text" value="{$mailchimp_list_id}" style="width:350px;" id="mailchimp_list_id" /></td>
            </tr>
        </table>
MAILCHIMP;

$map_contents = <<< HTML

<table width="100%" border="0" cellspacing="0" cellpadding="6">

    <tr>
        <td width="100"><label for="map_address">Map Address</label></td>
        <td>
            <input type="text" style="width:350px;" id="map_address" name="map_address" value="{$map_address}">
            <button type="button" id="get-map-address">Search</button>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <div id="gmap-canvas">
                <h3 style="font-size:18px;color:#000;padding:10px;font-weight:700;margin:0;">Loading map...</h3>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <input type="hidden" id="map_latitude" name="map_latitude" value="{$map_latitude}">
            <input type="hidden" id="map_longitude" name="map_longitude" value="{$map_longitude}">
            <input type="hidden" id="map_zoom_level" name="map_zoom_level" value="{$map_zoom_level}">
            <input type="hidden" id="map_marker_latitude" name="map_marker_latitude" value="{$map_marker_latitude}">
            <input type="hidden" id="map_marker_longitude" name="map_marker_longitude" value="{$map_marker_longitude}">
            <textarea name="map_styles" id="map_styles" class="hidden">{$map_styles}</textarea>
        </td>
    </tr>
</table>

HTML;

    $tripadvisor_widget_html = <<< H
    
    <textarea name="tripadvisor_widget_code" id="tripadvisor_widget_code" style="height:300px;width:100%;resize:none;">{$tripadvisor_widget_code}</textarea>


H;
    //Design Tab  
    include_once('views/design.php');

    //Installed Modules Tab  
    include_once('views/installed_modules.php');



    // Google WebFont loader
    $scripts_ext .= '<script src="https://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js"></script>';

    $scripts_ext .= '<script src="https://maps.google.com/maps/api/js?key=AIzaSyCqeRCfbUFp9cDWpnZPu1B8AnNnLCT9ZjQ"></script>';
    $scripts_ext .= '<script src="'.$htmladmin.'/js/general-map.js"></script>';
   

    ##------------------------------------------------------------------------------------------------------
    ## tab arrays and build tabs

    $temp_array_menutab = array();
    
   
    $temp_array_menutab ['General Settings']      = $companydetails_content;
    $temp_array_menutab ['Mailchimp Settings']      = $mailchimp_settings_content;
    $temp_array_menutab ['Design']                = $designContentView;
    $temp_array_menutab ['Map Location']          = $map_contents;
    $temp_array_menutab ['Social Links']          = $social_links;
    $temp_array_menutab ['Module Pages']          = $importantpages_content;
    $temp_array_menutab ['Template Code']         = $developer_content;
    $temp_array_menutab ['Installed Modules']     = $installedModulesView;

    $counter = 0;
    $tablist ="";
    $contentlist="";

    foreach($temp_array_menutab as $key => $value){

        $tablist.= "<li><a href=\"#tabs-".$counter."\">".$key."</a></li>";

        $contentlist.=" <div id=\"tabs-".$counter."\">".$value."</div>";

        $counter++;
    }

    $tablist="<div id=\"tabs\"><ul>".$tablist."</ul><div style=\"padding:10px;\">".$contentlist."</div></div>";

    $page_contents = <<< HTML
        <form action="$htmladmin/index.php" method="post" name="pageList" enctype="multipart/form-data">
            $tablist
            <input type="hidden" name="action" value="" id="action">
            <input type="hidden" name="do" value="settings">
            <input type="hidden" name="id" value="$id">
            <input type="hidden" name="set_id" value="$id">
        </form>
HTML;

    require "resultPage.php";
    echo $result_page;
    exit();
}

function save_item()
{

    global $message,$id,$do,$disable_menu, $incdir;

    $temp_array_save['company_name']               = sanitize_input('company_name');
    $temp_array_save['email_address']              = sanitize_input('email_address');
    $temp_array_save['js_code_head_close']         = filter_input(INPUT_POST, 'js_code_head_close');
    $temp_array_save['js_code_body_open']          = filter_input(INPUT_POST, 'js_code_body_open');
    $temp_array_save['js_code_body_close']         = filter_input(INPUT_POST, 'js_code_body_close');
    $temp_array_save['adwords_code']               = filter_input(INPUT_POST, 'adwords_code');
    $temp_array_save['start_year']                 = sanitize_input('start_year');
    $temp_array_save['resbook_id']                 = sanitize_input('resbook_id');
    $temp_array_save['phone_number']               = sanitize_input('phone_number');
    $temp_array_save['address']                    = sanitize_input('address');
    $temp_array_save['homepage_slideshow_caption'] = sanitize_input('homepage_slideshow_caption');
    $temp_array_save['mailchimp_api_key']          = sanitize_input('mailchimp_api_key');
    $temp_array_save['mailchimp_list_id']          = sanitize_input('mailchimp_list_id');
    $temp_array_save['mailchimp_email']            = sanitize_input('mailchimp_email');
    $temp_array_save['map_latitude']               = sanitize_input('map_latitude');
    $temp_array_save['map_longitude']              = sanitize_input('map_longitude');
    $temp_array_save['map_heading']                = sanitize_input('map_heading');
    $temp_array_save['map_address']                = sanitize_input('map_address');
    $temp_array_save['map_description']            = sanitize_input('map_description');
    $temp_array_save['map_zoom_level']             = sanitize_input('map_zoom_level', FILTER_VALIDATE_INT);
    $temp_array_save['map_marker_latitude']        = sanitize_input('map_marker_latitude', FILTER_VALIDATE_FLOAT);
    $temp_array_save['map_marker_longitude']       = sanitize_input('map_marker_longitude', FILTER_VALIDATE_FLOAT);
    $temp_array_save['booking_url']                = sanitize_input('booking_url', FILTER_VALIDATE_URL);
    $temp_array_save['tripadvisor_widget_code']    = filter_input(INPUT_POST, 'tripadvisor_widget_code');
    $temp_array_save['color_palette_id']           = sanitize_input('palette_id');
    $temp_array_save['company_logo_path']          = sanitize_input('company_logo_path');
    $temp_array_save['webfont_headings']           = sanitize_input('webfont_headings');
    $temp_array_save['webfont_text']               = sanitize_input('webfont_text');
    $temp_array_save['booking_engine_url']         = sanitize_input('booking_engine_url');
    $temp_array_save['slideshow_speed']            = sanitize_input('slideshow_speed');


    if( update_row($temp_array_save, 'general_settings', "WHERE id = '1' LIMIT 1") )
    {
        $message = "Settings have been saved";
    }

    // save social urls
    $url_ids    = $_POST['social-item-id'];
    $urls       = $_POST['social-item'];
    $has_widget = $_POST['social-item-has-wdge'];
    
    if(count($url_ids) > 0)
    {
        for ($i=0; $i < count($url_ids); $i++)
        { 
            $url_save_arr = array();
            if($has_widget[$i]) $url_save_arr['widget_blob'] = $urls[$i];
            else $url_save_arr['url'] = $urls[$i];

            update_row($url_save_arr, 'social_links', "WHERE id = '{$url_ids[$i]}'");
        }
    }


    // Save Partner Logos
    $partnerLogoIds       = $_POST['logo-item-id'];
    $partnerLogoItemsPath = $_POST['logo-item-path'];
    $partnerLogoItemsUrl  = $_POST['logo-item-url'];
    $partnerLogoItemsAlt  = $_POST['logo-item-alt'];
    
    $arrayPartnerIds = array_unique($partnerLogoIds);
    $item_array = [];
    $count = 0;
    foreach($arrayPartnerIds as $key => $value){
        $item_array[] = [
                            'id'    => $value,
                            'photo' => $partnerLogoItemsPath[$count],
                            'url'   => $partnerLogoItemsUrl[$count],
                            'alt_text'   => $partnerLogoItemsAlt[$count],
                        ];
    $count++;
    }

    if (!empty($partnerLogoIds)) { 
        $arrPartnerLogo = array();
        foreach($item_array as $item){
            $arrPartnerLogo['photo_path']          = $item['photo'];
            $arrPartnerLogo['url']                 = $item['url'];
            $arrPartnerLogo['alt_text']            = $item['alt_text'];

            update_row($arrPartnerLogo, 'partner_logos', "WHERE id = '{$item['id']}' LIMIT 1");
        }
    }

    $imppage_id = $_REQUEST['imppage_id'];
    $page_id = $_REQUEST['page_id'];
    $i = 0;
    foreach($imppage_id as $key => $value){
        $end = "WHERE imppage_id = '$value'";
        $temp_array_save = '';
        $temp_array_save['page_id']     = $page_id[$i];
        update_row($temp_array_save, 'general_importantpages', $end);
        $i++;
    }




}

?>