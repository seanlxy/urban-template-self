<?php
## ----------------------------------------------------------------------------------------------------------------------
## NetZone 1.0
## inc_faq.php
##
## Author: Ton Jo Immanuel, Tomahawk Brand Management Ltd.
## Date: 19 April 2010
##
## Manage FAQ
##
##
## ----------------------------------------------------------------------------------------------------------------------

function do_main(){

    global $message,$valid,$item_select,$htmladmin,$access_id, $main_heading;

    $action		= $_REQUEST['action'];
    $access_id          = $_REQUEST['access_id'];
    $main_heading = 'User Groups';
    switch ($action) {
        case 'save':
            @include('inc_accessgroups_save.php');
            $return = save_items();
            break;
    }

    $c = 0;
    $active_pages ="";
    $page_contents = "";
    $sql = "SELECT *
            FROM cms_accessgroups
            ORDER BY access_name";
    $result = run_query($sql);
    while($row = mysql_fetch_assoc($result)) {
        $access_id                  = $row['access_id'];
        $access_name                = $row['access_name'];
        $access_users               = $row['access_users'];
        $access_userpasswords       = $row['access_userpasswords'];
        $access_useraccesslevel     = $row['access_useraccesslevel'];
        $access_accessgroups        = $row['access_accessgroups'];
        $access_cmssettings         = $row['access_cmssettings'];
        $access_settings            = $row['access_settings'];

        if ($c%2 == 0 ? $bgc = "#FFFFFF": $bgc = "#F6F8FD");
        $c++;

        if($access_users == 'Y'){ $checked = 'checked'; }else{ $checked = ''; }
        $set_users = "<input type=\"checkbox\" name=\"access_users_$access_id\" class=\"onoffcheckbox\" $checked />";

        if($access_userpasswords == 'Y'){ $checked = 'checked'; }else{ $checked = ''; }
        $set_userpasswords = "<input type=\"checkbox\" name=\"access_userpasswords_$access_id\" class=\"onoffcheckbox\" $checked />";

        if($access_useraccesslevel == 'Y'){ $checked = 'checked'; }else{ $checked = ''; }
        $set_useraccesslevel = "<input type=\"checkbox\" name=\"access_useraccesslevel_$access_id\" class=\"onoffcheckbox\" $checked />";

        if($access_accessgroups == 'Y'){ $checked = 'checked'; }else{ $checked = ''; }
        $set_accessgroups = "<input type=\"checkbox\" name=\"access_accessgroups_$access_id\" class=\"onoffcheckbox\" $checked />";

        if($access_cmssettings == 'Y'){ $checked = 'checked'; }else{ $checked = ''; }
        $set_cmssettings = "<input type=\"checkbox\" name=\"access_cmssettings_$access_id\" class=\"onoffcheckbox\" $checked />";
        
        if($access_settings == 'Y'){ $checked = 'checked'; }else{ $checked = ''; }
        $set_settings = "<input type=\"checkbox\" name=\"access_settings_$access_id\" class=\"onoffcheckbox\" $checked />";


        $set_id = "<input type=\"hidden\" name=\"access_id[]\" value=\"$access_id\" />";

        if($cmsset_explanation != ''){
            $set_explanation = "<span title=\"$cmsset_explanation\" class=\"tooltip\"></span>";
        }else{
            $set_explanation = '';
        }
        
        $active_pages .= <<< HTML
            <tr>
                <td>$access_name $set_id</td>
                <td width="70" title="Users" align="center">$set_users</td>
                <td width="150" title="Change Passwords" align="center">$set_userpasswords</td>
                <td width="150" title="User Access Groups" align="center">$set_useraccesslevel</td>
                <td width="130" title="Access Groups" align="center">$set_accessgroups</td>
                <td width="130" title="CMS Settings" align="center">$set_cmssettings</td>
                <td width="70" title="Settings" align="center">$set_settings</td>
            </tr>
HTML;
    }
   
    if ($message != "") {

        $page_contents .= <<< HTML
          <div class="alert alert-warning page">
             <i class="glyphicon glyphicon-info-sign"></i>
              <strong>$message</strong>
          </div>
HTML;
    }
    ############################################################################################################################
    ## Get the page functions
    ############################################################################################################################

  $page_functions = <<< HTML
        <ul class="page-action">
            <li><button type="button" class="btn btn-default" onclick="submitForm('save',1)"><i class="glyphicon glyphicon-floppy-save"></i> Save</button></li>
            </li>
        </ul>
HTML;

					 

					 
    $page_contents.= <<< HTML
    <form action="$htmladmin/index.php" method="post" style="margin:0px;" name="pageList">
        <table width="100%" class="bordered">
            <thead>
                <tr style="height:auto;">                                
                    <th align="left">&nbsp;ACCESS GROUP</th>
                    <th width="70" align="left">Users</th>
                    <th width="150" align="left">Change Passwords</th>
                    <th width="150" align="left">User Access Groups</th>
                    <th width="130" align="left">Access Groups</th>
                    <th width="130" align="left">CMS Settings</th>
                    <th width="70" align="left">Settings</th>
                </tr>
            </thead>
            <tbody>
                $active_pages
            </tbody>
        </table>
        <input type="hidden" name="action" value="" id="action">
        <input type="hidden" name="do" value="accessgroups">
    </form>
HTML;

    require "resultPage.php";
    echo $result_page;
    exit();
}




?>
