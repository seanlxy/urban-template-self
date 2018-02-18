<?php

############################################################################################################################
## Edit FAQ Item
############################################################################################################################

function edit_item()
{

    global $message,$id,$do,$disable_menu,$valid,$htmladmin, $main_subheading;

    $disable_menu = "true";

    $sql = "SELECT `old_url`, `new_url`, `status_code`
    FROM `redirect`
     WHERE `id` = '$id' 
     LIMIT 1";

    $row = fetch_row($sql);


    @extract($row);
    $main_subheading = '';

    $status_code_arr = array(301, 302);
    $status_code_list = '';

    foreach ($status_code_arr as $item)
    {
        $sel = ($item == $status_code) ? ' selected="selected"' : '';
        $status_code_list .= '<option value="'.$item.'"'.$sel.'>'.$item.'</option>';
    }
    ##------------------------------------------------------------------------------------------------------
    
    ##------------------------------------------------------------------------------------------------------
    ## Page functions

	    $page_functions = <<< HTML
        <ul class="page-action">
            <li><button type="button" class="btn btn-default" onclick="submitForm('save',1)"><i class="glyphicon glyphicon-floppy-save"></i> Save</button></li>
            <li><button type="button" class="btn btn-default" onclick="submitForm('cancelpagesave',1)"><i class="glyphicon glyphicon-arrow-left"></i> Cancel</button>
            </li>
        </ul>
HTML;
       ##------------------------------------------------------------------------------------------------------
       ## Settings tab content

	$settings_content = <<< HTML
        <table width="100%" border="0" cellspacing="0" cellpadding="8">
            <tr>
               <td width="100"><label for="old_url">Old URL:</label></td>
                <td><input name="old_url" type="text" id="old_url" value="$old_url" style="width:700px;"></td>
            </tr>
            <tr>
               <td width="100"><label for="new_url">New URL:</label></td>
                <td><input name="new_url" type="text" id="new_url" value="$new_url" style="width:700px;"></td>
            </tr>
            <tr>
               <td width="100"><label for="status_code">Status code:</label></td>
                <td>
                    <select name="status_code" id="status_code" style="width:100px;">
                        <option value="">--select--</option>
                        {$status_code_list}
                    </select>
                </td>
            </tr>
        </table>
HTML;


       ##------------------------------------------------------------------------------------------------------
       ## tab arrays and build tabs

	$temp_array_menutab = array();

    $temp_array_menutab ['Details']     = $settings_content;

	$counter = 0;
	$tablist ="";
	$contentlist="";

	foreach($temp_array_menutab as $key => $value){

		$tablist.= "<li><a href=\"#tabs-".$counter."\">".$key."</a></li>";
		

		$contentlist.=" <div id=\"tabs-".$counter."\">".$value."</div>";

		$counter++;
	}

	$tablist="<div id=\"tabs\"><ul>$tablist</ul><div style=\"padding:10px;\">$contentlist</div></div>";

        $page_contents="<form action=\"$htmladmin/index.php\" method=\"post\" name=\"pageList\" enctype=\"multipart/form-data\">
        <style>
            /* css for timepicker */
            .ui-timepicker-div .ui-widget-header { margin-bottom: 8px; }
            .ui-timepicker-div dl { text-align: left; }
            .ui-timepicker-div dl dt { float: left; clear:left; padding: 0 0 0 5px; }
            .ui-timepicker-div dl dd { margin: 0 10px 10px 45%; }
            .ui-timepicker-div td { font-size: 90%; }
            .ui-tpicker-grid-label { background: none; border: none; margin: 0; padding: 0; }

            .ui-timepicker-rtl{ direction: rtl; }
            .ui-timepicker-rtl dl { text-align: right; padding: 0 5px 0 0; }
            .ui-timepicker-rtl dl dt{ float: right; clear: right; }
            .ui-timepicker-rtl dl dd { margin: 0 45% 10px 10px; }
        </style>
                            $tablist
                            <input type=\"hidden\" name=\"action\" value=\"\" id=\"action\">
                            <input type=\"hidden\" name=\"do\" value=\"redirects\">
                            <input type=\"hidden\" name=\"id\" value=\"$id\">
                        </form>";
    require "resultPage.php";
    echo $result_page;
    exit();
}

?>
