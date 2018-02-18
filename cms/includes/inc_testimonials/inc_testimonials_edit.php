<?php

############################################################################################################################
## Edit FAQ Item
############################################################################################################################

function edit_item()
{

    global $message,$id,$do,$disable_menu,$valid,$htmladmin, $main_subheading, $js_vars;

    $disable_menu = "true";

    $sql = "SELECT `person`, `detail` FROM `testimonial` WHERE `id` = '{$id}' LIMIT 1";

    $row = fetch_row($sql);

    @extract($row);


    ##------------------------------------------------------------------------------------------------------
    // Init view variables


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
            <td width="130"><label for="person">Person:</label></td>
            <td><input name="person" type="text" id="person" value="$person" style="width:718px;" /></td>

        </tr>
        <tr>
            <td width="130" valign="top"><label for="detail">Testimonial:</label></td>
            <td valign="top">
                <textarea name="detail" id="detail" class="check-max" style="width:718px;min-height:200px;">$detail</textarea>
            </td>
        </tr>
    </table>
HTML;


##------------------------------------------------------------------------------------------------------
## tab arrays and build tabs

$temp_array_menutab = array();


$temp_array_menutab['Details']   = $settings_content;



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
        <input type=\"hidden\" name=\"meta_data_id\" value=\"$id\">
    </form>";
require "resultPage.php";
echo $result_page;
exit();

}

?>
