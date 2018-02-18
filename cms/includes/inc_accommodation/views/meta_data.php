<?php
$meta_content = <<< HTML
   <table width="100%" border="0" cellspacing="0" cellpadding="4" >
        <tr>
            <td width="150" valign="top"><label for="title">Title</label></td>
            <td>
                <input name="title" type="text" id="title" class="check-max" value="$title" style="width:600px;"><br>
                <span class="text-muted"><small>Page titles should be under 65 characters (including spaces) <em></em></small></span>
            </td>
        </tr>
        <tr>
            <td valign="top"><label for="meta_description">Meta Description</label> <span class="tooltip" title="This description is hidden from the user but useful to some search engines and appears in search results"></span></td>
            <td>
                <textarea name="meta_description" class="check-max" style="width:600px; font-family: sans-serif, Verdana, Arial, Helvetica;" rows="5" id="meta_description">$meta_description</textarea>
                <br><span class="text-muted"><small>Meta descriptions should be between 150-160 characters (including spaces) <em></em></small></span>
            </td>
        </tr>
        <tr>
            <td width="150" valign="top"><label for="og_title">OG Title:</label></td>
            <td>
                <input name="og_title" type="text" id="og_title" class="check-max" value="$og_title" style="width:600px;"><br>
            </td>
        </tr>
        <tr>
            <td valign="top"><label for="og_meta_description">OG Description:</label></td>
            <td>
                <textarea name="og_meta_description" class="check-max" style="width:600px; font-family: sans-serif, Verdana, Arial, Helvetica;" rows="5" id="og_meta_description">$og_meta_description</textarea>
            </td>
        </tr>
        <tr>
            <td width="130" valign="top"><label>OG Photo:</label></td>
            <td>
                <input name="og_image" type="text" id="og_image" value="$og_image" style="margin-right:5px;width:300px;margin-bottom:5px;" /><br>
                <input type="button" onclick="openFileBrowser('og_image')" style="padding:1px 5px;height:25px;" value="Browse">
                <input type="button" style="height:25px;" value="clear" onclick="clearValue('og_image')"><br>
            </td>
        </tr>
    </table>
HTML;
?>