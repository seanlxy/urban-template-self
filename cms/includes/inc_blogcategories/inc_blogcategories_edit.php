<?php

############################################################################################################################
## Edit FAQ Item
############################################################################################################################

function edit_item()
{

    global $message,$id,$do,$disable_menu,$valid,$htmladmin, $main_subheading, $js_vars;

    $disable_menu = "true";

    $sql = "SELECT bc.`id`, bc.`page_meta_data_id`, pmd.`name`, pmd.`menu_label`, pmd.`heading`,
        pmd.`url`, pmd.`introduction`, pmd.`title`, pmd.`meta_description`,
        pmd.`og_title`, pmd.`og_meta_description`, pmd.`og_image`
        FROM `blog_category` bc
        LEFT JOIN `page_meta_data` pmd
        ON(pmd.`id` = bc.`page_meta_data_id`)
        WHERE bc.`id` = '{$id}'
        LIMIT 1";


    $row = fetch_row($sql);

    if( empty($row) )
    {
        header("Location: {$htmladmin}/?do={$do}");
        exit();
    }

    @extract($row);

    $main_subheading = 'Editing category: '.$name;


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
        <td colspan="3"><input name="heading" type="text" id="heading" value="$heading" style="width:250px;" /></td>
    </tr>
    <tr>
        <td width="130"><label for="label">Name:</label></td>
        <td><input name="label" type="text" id="label" value="$name" style="width:250px;" /></td>
    </tr>
    <tr>
        <td width="130"><label for="menu_label">Menu Label:</label></td>
        <td><input name="menu_label" type="text" id="menu_label" value="$menu_label" style="width:250px;" /></td> 
    </tr>
    <tr>
        <td width="130"><label for="url">URL:</label></td>
        <td colspan="3"><input name="url" type="text" id="url" value="$url" style="width:250px;" /></td>
    </tr>
    
</table>


HTML;

// include_once 'views/overview.php';
include_once 'views/meta_data.php';

##------------------------------------------------------------------------------------------------------
## tab arrays and build tabs

$temp_array_menutab = array();


$temp_array_menutab['Details']   = $settings_content;
// $temp_array_menutab['Content']   = $main_content;
$temp_array_menutab['Meta Data'] = $meta_content;



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