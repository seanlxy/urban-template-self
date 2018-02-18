<?php

############################################################################################################################
## Edit FAQ Item
############################################################################################################################

function edit_item()
{

    global $message,$id,$do,$disable_menu,$valid,$htmladmin, $main_subheading, $js_vars, $htmlroot;

    $disable_menu = "true";

   $sql = "SELECT `id`, `name`, `label`, `list_id`, `list_email_address`
        FROM `beamer_email`
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
        <td width="160"><label for="label">Label:</label></td>
        <td><input name="label" type="text" id="label" value="{$label}" style="width:450px;" /></td> 
    </tr>
    <tr>
        <td width="160"><label for="list_id">MailChimp List Id:</label></td>
        <td><input name="list_id" type="text" id="list_id" value="{$list_id}" style="width:450px;" /></td> 
    </tr>
    <tr>
        <td width="160"><label for="list_email_address">Email Beamer Address:</label></td>
        <td><input name="list_email_address" type="text" id="list_email_address" value="{$list_email_address}" style="width:450px;" /></td>
    </tr>
    <tr>
        <td width="160"></td>
        <td><p>To locate your list's Email Beamer address, follow these steps.</p>
            <p>
                <ul>
                    <li>1. Navigate to the Lists page.</li>
                    <li>2. Click on the drop-down menu for the list you want to send to, and select Settings.</li>
                    <li>3. Click Email beamer.</li>
                </ul>
            </p>
        </td>
    </tr>
</table>
HTML;


##------------------------------------------------------------------------------------------------------
## tab arrays and build tabs

$temp_array_menutab = array();


$temp_array_menutab['Details']   = $settings_content;

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
    <input type=\"hidden\" name=\"do\" value=\"{$do}\">
    <input type=\"hidden\" name=\"id\" value=\"{$id}\">
</form>";

require "resultPage.php";
echo $result_page;
exit();

}

?>