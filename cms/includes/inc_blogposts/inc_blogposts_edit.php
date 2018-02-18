<?php

############################################################################################################################
## Edit FAQ Item
############################################################################################################################

function edit_item()
{

    global $message,$id,$do,$disable_menu,$valid,$htmladmin, $main_subheading, $js_vars;

    $disable_menu = "true";

    $sql = "SELECT bp.`id`, bp.`page_meta_data_id`, pmd.`heading`, pmd.`description`,
        pmd.`url`, pmd.`introduction`, pmd.`title`, pmd.`meta_description`, pmd.`thumb_photo`, pmd.`photo`,
        pmd.`og_title`, pmd.`og_meta_description`, pmd.`og_image`, pmd.`short_description`, pmd.`updated_by`,
        IF(bp.`date_posted`, DATE_FORMAT(bp.`date_posted`, '%d/%m/%Y'), '') AS posted_on,
        (SELECT GROUP_CONCAT(`category_id`) FROM `blog_post_has_category` WHERE `post_id` = bp.`id`) AS categories_csv
        FROM `blog_post` bp
        LEFT JOIN `page_meta_data` pmd
        ON(pmd.`id` = bp.`page_meta_data_id`)
        WHERE bp.`id` = '{$id}'
        LIMIT 1";


    $row = fetch_row($sql);

    if( empty($row) )
    {
        header("Location: {$htmladmin}/?do={$do}");
        exit();
    }

    @extract($row);

    $main_subheading = 'Editing blog post: '.$heading;


    $updated_by = ( $updated_by ) ? $updated_by : $_SESSION['s_user_id'];


    $author_list = create_item_list("SELECT `user_id` AS ind, TRIM(CONCAT(`user_fname`, ' ', `user_lname`)) AS label
        FROM `cms_users`
        WHERE `user_fname` != ''
        ORDER BY label", $updated_by);


    ##------------------------------------------------------------------------------------------------------
    // Init view variables

    $meta_content = '';

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
        <td width="130"><label for="heading">Heading:</label></td>
        <td><input name="heading" type="text" id="heading" value="$heading" style="width:718px;" /></td>
    </tr>
    <tr>
        <td width="130"><label for="author">Author:</label></td>
        <td>
            <select name="author" id="author" style="width:250px;">
                <option value="">-- select --</option>
                {$author_list}
            </select>
        </td>

    </tr>
    <tr>
        <td width="130"><label for="posted_on">Posted On:</label></td>
        <td><input name="posted_on" type="text" id="posted_on" value="$posted_on" style="width:250px;" /></td>
    </tr>
    <tr>
        <td width="130"><label for="url">URL:</label></td>
        <td><input name="url" type="text" id="url" value="$url" style="width:250px;" /></td>
    </tr>
    <tr>
        <td width="130" valign="top"><label for="photo">Thumbnail Photo:</label></td>
        <td>
            <input name="photo" type="text" value="$photo" style="width:350px;" id="photo" readonly autocomplete="off">
            <input type="button" value="browse" onclick="openFileBrowser('photo')"> 
            <input type="button" value="clear" onclick="clearValue('photo')"><br>
            <input type="hidden" value="$thumb_photo" id="thumb_photo" name="thumb_photo"> 
        </td>
    </tr>
    <tr>
        <td valign="top"><label for="short_description">Short Description:</label></td>
        <td>
            <textarea name="short_description" class="check-max" style="width:600px; font-family: sans-serif, Verdana, Arial, Helvetica;" rows="5" id="short_description">$short_description</textarea>
            <br><span class="text-muted"><small>Short descriptions is displayed on the Blog Category<em></em></small></span>
        </td>
    </tr>
</table>
<script>
    $('#posted_on').datepicker({
        dateFormat:'dd/mm/yy',
        changeYear:true,
        changeMonth:true
    });
</script>

HTML;

include_once 'views/overview.php';
include_once 'views/meta_data.php';
include_once 'views/category_list.php';

##------------------------------------------------------------------------------------------------------
## tab arrays and build tabs

$temp_array_menutab = array();


$temp_array_menutab['Details']    = $settings_content;
$temp_array_menutab['Content']    = $main_content;
$temp_array_menutab['Meta Data']  = $meta_content;
$temp_array_menutab['Categories'] = $categories_list;



$counter = 0;
$tablist ="";
$contentlist="";

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