<?php

############################################################################################################################
## Edit User
############################################################################################################################

function edit_item(){

     global $message,$id,$do,$disable_menu,$valid,$htmladmin, $main_subheading;

     $disable_menu = "true";

     $sql = "SELECT *
             FROM cms_users
             WHERE user_id = $id";
     
     $row = fetch_row($sql);

     $user_id           = $row['user_id'];
     $user_fname        = $row['user_fname'];
     $user_lname        = $row['user_lname'];
     $user_email        = $row['user_email'];
     $user_photo_path   = $row['user_photo_path'];
     $user_thumb_path   = $row['user_thumb_path'];
     $user_introduction = $row['user_introduction'];
     // $social_links  = unserialize($row['social_links']);

     $main_subheading = "Editing user: $user_fname $user_lname details";
     $access_id     = $row['access_id'];

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
	## Access List

        if($user_id == USER_ID){
            $accesslist = 'Sorry, but you can not change your own access group';
        }else{
            $sql = "SELECT access_id, access_name
                    FROM cms_accessgroups";
            $result = run_query($sql);

            $accesslist = "<select name=\"access_id\" id=\"access_id\">";
            while($row = mysql_fetch_assoc($result)) {
                $this_access_id     = $row['access_id'];
                $this_access_name   = $row['access_name'];
                if($this_access_id == $access_id){ $selected = 'selected="selected"'; }else{ $selected = '';}
                $accesslist .= "<option value=\"$this_access_id\" $selected>$this_access_name</option>";
            }
            $accesslist .= "</select>";
        }

        ##------------------------------------------------------------------------------------------------------
	## Settings tab content

	$settings_content = <<< HTML
        <table width="100%" border="0" cellspacing="0" cellpadding="4">
            <tr>
                <td width="180"><label for="user_fname">First Name</label></td>
                <td><input name="user_fname" type="text" id="user_fname" value="$user_fname" style="width:600px;" /></td>
            </tr>
            <tr>
                <td width="180"><label for="user_lname">Last Name</label></td>
                <td><input name="user_lname" type="text" id="user_lname" value="$user_lname" style="width:600px;" /></td>
            </tr>
            <tr>
                <td width="180"><label for="user_email">Email</label></td>
                <td><input name="user_email" type="text" id="user_email" value="$user_email" style="width:600px;" /></td>
            </tr>
            <tr>
                <td width="180"><label for="user_pass">Password</label></td>
                <td><input name="user_pass" type="password" id="user_pass" value="********" style="width:600px;" onClick="this.value='';"/></td>
            </tr>
            <tr>
                <td width="180"><label for="access_id">Access Group</label></td>
                <td>$accesslist</td>
            </tr>
        </table>
HTML;




        ##------------------------------------------------------------------------------------------------------
        ## tab arrays and build tabs

	$temp_array_menutab = array();

    $temp_array_menutab['Details']      = $settings_content;

    $counter     = 0;
    $tablist     = "";
    $contentlist = "";

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
                            <input type="hidden" name="do" value="users">
                            <input type="hidden" name="id" value="$id">
                        </form>
HTML;
    require "resultPage.php";
    echo $result_page;
    exit();
}
?>
