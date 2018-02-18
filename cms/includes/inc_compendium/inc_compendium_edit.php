<?php

############################################################################################################################
## Edit FAQ Item
############################################################################################################################

function edit_item()
{

    global $message,$id,$do,$disable_menu,$valid,$htmladmin, $main_subheading, $js_vars;

    $disable_menu = "true";


    $sql = "SELECT `id`, `icon`, `heading`, `status`, `rank`, `is_generic`, `has_dark_bg`, `is_map`,`default_content`
    FROM `compendium_section` 
    WHERE `id` = '{$id}'
    LIMIT 1";

    $row = fetch_row($sql);

    @extract($row);

    $main_subheading = 'Editing Compendium Section: '.$heading;

    $generic_check  = ($is_generic) ? ' checked="checked"' : '';
    $bg_check  = ($has_dark_bg) ? ' checked="checked"' : '';
    $map_check  = ($is_map) ? ' checked="checked"' : '';


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
            <td width="130"><label for="icon">Font Awesome Icon Class:</label></td>
            <td><input name="icon" type="text" id="icon" value="$icon" style="width:300px;" /></td>

        </tr>
        <tr>
            <td width="130"><label for="heading">Heading:</label></td>
            <td><input name="heading" type="text" id="heading" value="$heading" style="width:300px;" /></td>

        </tr>
        <tr>
            <td width="100" valign="top"><label for="is_generic">Is Generic?:</label></td>
            <td valign="top" width="50">
                <input name="is_generic" type="checkbox" id="is_generic" value="1"$generic_check>
            </td>
        </tr>
        <tr>
            <td width="100" valign="top"><label for="has_dark_bg">Has Dark Background?:</label></td>
            <td valign="top" width="50">
                <input name="has_dark_bg" type="checkbox" id="has_dark_bg" value="1"$bg_check>
            </td>
        </tr>
        <tr>
            <td width="100" valign="top"><label for="is_map">Is Map Section?:</label></td>
            <td valign="top"  width="50">
                <input name="is_map" type="checkbox" id="is_map" value="1"$map_check>
            </td>
        </tr>

        <tr>
            <td width="100" valign="top"><label for="default_content">Default content:</label></td>
            <td colspan="3">
                <textarea name="default_content" id="default_content" style="width:700px;height:130px;">$default_content</textarea>
                <script type="text/javascript">
                    CKEDITOR.replace( 'default_content',
                    {
                        toolbar : 'MyToolbar',
                        forcePasteAsPlainText : true,
                        resize_enabled : false,
                        height:650,
                        filebrowserBrowseUrl : jsVars.dataManagerUrl
                    });
                 </script>

            </td>
        </tr>


</table>
HTML;




// include_once 'views/overview.php';
// include_once 'views/meta_data.php';

##------------------------------------------------------------------------------------------------------
## tab arrays and build tabs

$temp_array_menutab                       = array();
$temp_array_menutab['Details']            = $settings_content;
// $temp_array_menutab['Content']            = $main_content;
// $temp_array_menutab['Meta Data']          = $meta_content;

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
        <input type=\"hidden\" name=\"meta_data_id\" value=\"$id\">
    </form>";

require "resultPage.php";
echo $result_page;
exit();

}

?>
