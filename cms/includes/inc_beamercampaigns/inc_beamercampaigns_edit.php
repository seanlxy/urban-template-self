<?php

############################################################################################################################
## Edit FAQ Item
############################################################################################################################

function edit_item()
{

    global $message,$id,$do,$disable_menu,$valid, $admin_dir, $htmladmin, $main_subheading, $js_vars, $htmlroot;

    $disable_menu = "true";

    $sql = "SELECT `id`, `name`, `subject`, `heading`, `photo`, `thumb_photo`, `preview_note`, `description`, `terms_and_conditions`
        FROM `beamer_campaign`
        WHERE `id` = '{$id}'
        LIMIT 1";

    $row = fetch_row($sql);

    if( empty($row) )
    {
        redirect("{$htmladmin}?do={$do}");
    }

    @extract($row);

    $main_subheading = 'Editing : '.$name;
    ##------------------------------------------------------------------------------------------------------
    // Init view variables

    $meta_content = '';

    ##------------------------------------------------------------------------------------------------------
    ## Page functions

    $page_functions = <<< HTML
    <ul class="page-action">
        <li><button type="button" class="btn btn-default" id="pg-save" onclick="submitForm('save',1)"><i class="glyphicon glyphicon-floppy-save"></i> Save</button></li>
        <li><a class="btn btn-default" href="{$htmladmin}/?do={$do}"><i class="glyphicon glyphicon-arrow-left"></i> Cancel</a>
        </li>
    </ul>
HTML;


##------------------------------------------------------------------------------------------------------
## Settings tab content
$settings_content = <<< HTML
<table width="100%" border="0" cellspacing="0" cellpadding="6">
    <tr>
        <td width="160"><label for="name">CMS Label:</label></td>
        <td><input name="name" type="text" id="name" value="{$name}" style="width:450px;" /></td> 
    </tr>
    <tr>
        <td width="160"><label for="heading">Campaign Heading:</label></td>
        <td><input name="heading" type="text" id="heading" value="{$heading}" style="width:450px;" /></td> 
    </tr>
    <tr>
        <td width="160"><label for="heroshot">Campaign Heroshot:</label></td>
        <td>
            <input name="photo" type="text" value="$photo" style="width:450px;" id="photo" readonly autocomplete="off">
            <input name="thumb_photo" type="hidden" value="$thumb_photo" id="thumb_photo" readonly autocomplete="off">
            <input type="button" value="browse" onclick="openFileBrowser('photo')"> 
            <input type="button" value="clear" onclick="clearValue('photo')"><br>            
        </td> 
    </tr>
    <tr>
        <td width="130" valign="top"><label for="preview_note">Campaign Preview Note:</label></td>
        <td>
            <textarea name="preview_note" id="preview_note" style="width:450px;min-height:100px;resize:none;" class="check-max" maxlength="250">{$preview_note}</textarea>
            <br><span class="text-muted"><small>Max 250 characters (including spaces) - <em></em></small></span>
        </td>
    </tr>
    <tr>
        <td width="160"><label for="subject">Campaign Subject:</label></td>
        <td><input name="subject" type="text" id="subject" value="{$subject}" style="width:450px;" /></td> 
    </tr>
    <tr>
        <td width="160" colspan="2"><label for="description">Campaign Description:</label></td>
    </tr>
    <tr>
        <td width="160" colspan="2">
            <textarea name="description" id="description">{$description}</textarea>
            <script>
                CKEDITOR.replace( 'description',
                {
                    toolbar : 'MyToolbar',
                    forcePasteAsPlainText : true,
                    resize_enabled : false,
                    height : 250,
                    filebrowserBrowseUrl : jsVars.dataManagerUrl
                });               
            </script>            
        </td>
    </tr>
</table>
HTML;
##------------------------------------------------------------------------------------------------------
## Settings tab content
$terms_and_conditions_content = <<< HTML
    <table width="100%" border="0" cellspacing="0" cellpadding="6">
        <tr>
            <td width="160" colspan="2"><label for="terms_and_conditions">Campaign Terms & Conditions:</label></td>
        </tr>
        <tr>
            <td width="160" colspan="2">
                <textarea name="terms_and_conditions" id="terms_and_conditions">{$terms_and_conditions}</textarea>
                <script>
                    CKEDITOR.replace( 'terms_and_conditions',
                    {
                        toolbar : 'MyToolbar',
                        forcePasteAsPlainText : true,
                        resize_enabled : false,
                        height : 250,
                        filebrowserBrowseUrl : jsVars.dataManagerUrl
                    });               
                </script>            
            </td>
        </tr>
    </table>
HTML;
##------------------------------------------------------------------------------------------------------
## tab arrays and build tabs
include_once 'views/campaignlists.php';
include_once 'views/campaignbody.php';

$temp_array_menutab = array();


$temp_array_menutab['Campaign Details']   = $settings_content;
$temp_array_menutab['Campaign Terms & Conditions']   = $terms_and_conditions_content;
$temp_array_menutab['Campaign Lists']     = $campaign_list_content;
$temp_array_menutab['Campaign Content']   = $campaign_body_content;

$counter     = 0;
$tablist     = "";
$contentlist = "";

foreach($temp_array_menutab as $key => $value)
{

	$tablist.= "<li><a href=\"#tabs-".$counter."\">".$key."</a></li>";

	$contentlist.=" <div id=\"tabs-".$counter."\">".$value."</div>";

	$counter++;
}

$tablist="<div id=\"tabs\"><ul>{$tablist}</ul><div style=\"padding:10px;\">{$contentlist}</div></div>";

$page_contents="<form action=\"$htmladmin/?do={$do}\" method=\"post\" name=\"pageList\" enctype=\"multipart/form-data\">
    $tablist
    <input type=\"hidden\" name=\"action\" value=\"\" id=\"action\">
    <input type=\"hidden\" name=\"do\" id=\"do\" value=\"{$do}\">
    <input type=\"hidden\" name=\"id\" value=\"{$id}\">
</form>";

require "resultPage.php";
echo $result_page;
exit();

}

?>