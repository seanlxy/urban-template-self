<?php

############################################################################################################################
## Edit FAQ Item
############################################################################################################################

function edit_item()
{

    global $message,$id,$do,$disable_menu,$valid,$htmladmin, $main_subheading, $js_vars;

    $disable_menu = "true";

    $sql = "SELECT
                a.`id`,
                a.`page_meta_data_id`,
                a.`beds`,
                a.`pax`,
                a.`sqm`,
                a.`from_price`,
                a.`gallery_id`,
                a.`slideshow_id`,
                a.`latitude`,
                a.`longitude`,
                a.`google_map_address`,
                a.`address`,
                pmd.`name`,
                pmd.`menu_label`,
                pmd.`heading`,
                pmd.`url`,
                pmd.`title`,
                pmd.`meta_description`,
                pmd.`introduction`,
                pmd.`og_title`,
                pmd.`og_image`,
                pmd.`og_meta_description`,
                pmd.`short_description`,
                pmd.`photo`
            FROM
                `accommodation` a
            LEFT JOIN `page_meta_data` pmd ON
                (pmd.`id` = a.`page_meta_data_id`)
            WHERE
                a.`id` = '{$id}'
            LIMIT 1";

    $row = fetch_row($sql);

    @extract($row);

    $main_subheading = 'Editing: '.$name;

    ##------------------------------------------------------------------------------------------------------
    // Init view variables

    $meta_content = '';

    ##-------------------------------
    ##Create drop down for gallery

    $sql2 = "SELECT `id`, `name` FROM `photo_group` WHERE `type` = 'G'";

    $gallery_list = fetch_all($sql2);
    $gallery_view = '<select name="gallery_id" style="height:25px;width:200px;"><option value="">--Choose gallery--</option>';

    foreach ($gallery_list as $gallery) {

        $sel = ($gallery_id == $gallery['id']) ? 'selected' : '';
        $gallery_view .= '<option '.$sel.' value="'.$gallery['id'].'">'.$gallery['name'].'</option>';
    }

    $gallery_view .= '</select>';


    ##--------------------------------
    ##Create drop down for slideshow

    $sql3 = "SELECT `id`, `name` FROM `photo_group` WHERE `type` = 'S'";

    $slideshow_list = fetch_all($sql3);
    $slideshow_view = '<select name="slideshow_id" style="height:25px;width:200px;"><option value="">--Choose slideshow--</option>';

    foreach ($slideshow_list as $slideshow) {

        $sel1 = ($slideshow_id == $slideshow['id']) ? 'selected' : '';
        $slideshow_view .= '<option '.$sel1.' value="'.$slideshow['id'].'">'.$slideshow['name'].'</option>';
    }

    $slideshow_view .= '</select>';


    ##------------------------------------------------------------------------------------------------------
    ## Page functions

    $page_functions = <<< HTML
    <ul class="page-action">
        <li><button type="button" class="btn btn-default" onclick="submitForm('save',1)"><i class="glyphicon glyphicon-floppy-save"></i> Save</button></li>
        <li><a class="btn btn-default" href="{$htmladmin}/?do={$do}"><i class="glyphicon glyphicon-arrow-left"></i> Cancel</a>
        </li>
    </ul>
HTML;

##------------------------------------------------------------------------------------------------------
## Settings tab content
$settings_content = <<< HTML
    <table width="100%" border="0" cellspacing="0" cellpadding="8">
        <tr>
            <td width="130"><label for="name">Name:</label></td>
            <td><input name="name" type="text" id="name" value="$name" style="width:300px;" /></td>
            <td width="130"><label for="menu_label">Menu Label:</label></td>
            <td><input name="menu_label" type="text" id="menu_label" value="$menu_label" style="width:300px;" /></td>
        </tr>
        <tr>
            <td width="130"><label for="heading">Heading:</label></td>
            <td><input name="heading" type="text" id="heading" value="$heading" style="width:300px;" /></td>
            <td width="130"><label for="url">URL:</label></td>
            <td><input name="url" type="text" id="url" value="$url" style="width:300px;" /></td>
        </tr>
        <tr>

            <td width="130"><label for="from_price">From Price:</label></td>
            <td><input name="from_price" type="text" id="from_price" value="$from_price" style="width:300px;" /></td>

            <td width="130"><label for="beds">Beds:</label></td>
            <td><input name="beds" type="text" id="beds" value="$beds" style="width:300px;" /></td>

        </tr>
        <tr>

            <td width="130"><label for="pax">Maximum Guests:</label></td>
            <td><input name="pax" type="text" id="pax" value="$pax" style="width:300px;" /></td>

            <td width="130"><label for="sqm">Square Metres:</label></td>
            <td><input name="sqm" type="text" id="sqm" value="$sqm" style="width:300px;" /></td>

        </tr>
        <tr>
            <td width="130" valign="top"><label>Slideshow:</label></td>
            <td valign="top">
                {$slideshow_view}
            </td>
            <td width="130" valign="top"><label>Gallery:</label></td>
            <td valign="top">
                {$gallery_view}
            </td>
        </tr>
        <tr>
     <td valign="top"><label>Quicklink Photo:</label></td>
            <td>
                <input name="photo" type="text" id="photo" value="$photo" style="margin-right:5px;width:300px;height:25px;float:left;" />
                <input type="button" onclick="openFileBrowser('photo')" style="height:25px;padding:1px 5px;" value="Browse">
                <input type="button" value="clear" onclick="clearValue('photo')" style="height:25px;"><br>
            </td>
        </tr>
        <tr>
            <td width="130" valign="top"><label for="address">Address:<br><small>Used in Property Compendium front page and google map info window</small></label></td>
            <td valign="top">
                <textarea name="address" maxlength="250" style="width:300px;height:120px;resize:none;">$address</textarea>
            </td>
        </tr>
        <tr>
            <td width="130" valign="top"><label for="introduction">Introduction:</label></td>
            <td valign="top" colspan="3">
                <textarea name="introduction" class="check-max" style="width:100%;height:70px;resize:none;">$introduction</textarea>
                <br/><span class="text-muted"><small>Introduction (including spaces) <em></em></small></span>
            </td>
        </tr>
        <tr>
            <td width="130" valign="top"><label for="short_description">Short Description:</label></td>
            <td valign="top" colspan="3">
                <textarea name="short_description" class="check-max" maxlength="180" style="width:100%;height:70px;resize:none;">$short_description</textarea>
                <br/><span class="text-muted"><small>Short Description should be between 100-180 characters (including spaces) <em></em></small></span>
            </td>
        </tr>
</table>
HTML;

//List the features
$sql = "SELECT `id`,`name` FROM `accom_feature` WHERE `status` = 'A' ORDER BY `rank`";
$feat_arr = fetch_all($sql);

$attached_ids     = fetch_value("SELECT GROUP_CONCAT(`feature_id`) FROM `accom_has_feature` WHERE `accom_id` = '$id'");
$attached_ids_arr = explode(',', $attached_ids);

$feat_list = '';

if(!empty($feat_arr)){

    $feat_list = '<ul>';

    foreach ($feat_arr as $feat) {

        $checked = (in_array($feat['id'], $attached_ids_arr)) ? 'checked' : '';
        $feat_list .= '<li style="float:left;width:250px;padding-right:15px;"><label><input type="checkbox" '.$checked.' name="feature_id[]" value="'.$feat['id'].'"><span style="vertical-align:top;margin:4px 0 0 10px;display:inline-block;">'.$feat['name'].'</span></label></li>';
    }

    $feat_list .= '</ul>';
}

$feat_content = <<< HTML
<table width="100%" border="0" cellspacing="0" cellpadding="8">
    <tr>
        <td>
            $feat_list
        </td>
    </tr>
</table>
HTML;


include_once 'views/overview.php';
include_once 'views/meta_data.php';
include_once 'views/map.php';
include_once 'views/compendium.php';

##------------------------------------------------------------------------------------------------------
## tab arrays and build tabs

$temp_array_menutab                       = array();
$temp_array_menutab['Details']            = $settings_content;
$temp_array_menutab['Features']           = $feat_content;
$temp_array_menutab['Content']            = $main_content;
$temp_array_menutab['Meta Data']          = $meta_content;
$temp_array_menutab ['Map']               = $map_html;
$temp_array_menutab ['Compendium']        = $compendium_html;

$counter     = 0;
$tablist     = "";
$contentlist = "";

foreach($temp_array_menutab as $key => $value){

	$tablist.= "<li><a href=\"#tabs-".$counter."\">".$key."</a></li>";
	$contentlist.=" <div id=\"tabs-".$counter."\">".$value."</div>";
	$counter++;
}

$tablist="<div id=\"tabs\"><ul>$tablist</ul><div style=\"padding:10px;\">$contentlist</div></div>";

    $page_contents="<form action=\"$htmladmin/?do={$do}\" method=\"post\" name=\"pageList\" enctype=\"multipart/form-data\">
        $tablist
        <input type=\"hidden\" name=\"action\" value=\"\" id=\"action\">
        <input type=\"hidden\" name=\"do\" value=\"{$do}\">
        <input type=\"hidden\" name=\"id\" value=\"$id\">
        <input type=\"hidden\" name=\"meta_data_id\" value=\"$page_meta_data_id\">
    </form>";

require "resultPage.php";
echo $result_page;
exit();

}

?>
