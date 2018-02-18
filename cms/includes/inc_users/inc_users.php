<?php
## ----------------------------------------------------------------------------------------------------------------------
## NetZone 1.0
## inc_users.php
##
## Author: Ton Jo Immanuel, Tomahawk Brand Management Ltd.
## Date: 16 April 2010
##
## Manage Users
##
##
## ----------------------------------------------------------------------------------------------------------------------

function do_main(){

    global $message,$valid,$item_select,$htmladmin, $main_heading;

    $test_id		= $_REQUEST['user_id'];
    $item_select	= $_REQUEST['item_select'];
    $action		= $_REQUEST['action'];
    $main_heading = "Cms Users";
    switch ($action) {
        case 'edit':
            @include('inc_users_edit.php');
            $return = edit_item();
            break;

        case 'new':
            @include('inc_users_new.php');
            $return = new_item();
            break;

        case 'save':
            @include('inc_users_save.php');
            $return = save_item();
            break;
        case 'delete':
            @include('inc_users_delete.php');
            $return = delete_item();
            break;
    }

    $c = 0;
    $active_pages ="";
    $page_contents = "";
    $sql = "SELECT *, ag.access_name AS user_rights
            FROM cms_users u
            LEFT JOIN cms_accessgroups ag ON ag.access_id = u.access_id
            ORDER BY user_lname";
    $result = run_query($sql);
    while($row = mysql_fetch_assoc($result)) {

        $user_id	= $row['user_id'];
        $user_first	= $row['user_fname'];
        $user_last	= $row['user_lname'];
        $user_email	= $row['user_email'];
        $user_rights    = $row['user_rights'];

        if ($c%2 == 1 ? $bgc = "#FFFFFF" : $bgc = "#F6F8FD");
        $c++;
        
        $editlink="<a href=\"$htmladmin/index.php?do=users&action=edit&id=$user_id\">$user_first $user_last </a>";

        $item_select="<label class=\"custom-check\"><input type=\"checkbox\" name=\"item_select[]\" class =\"checkall\" value=\"$user_id\"><span></span></label>";

        $active_pages .= <<< HTML
            <tr>
                <td width="30" align="center">$item_select</td>
                <td>$editlink</td>
                <td width="200">$user_email</td>
                <td width="200">$user_rights</td>
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
    $page_functions = <<< HTML

    <ul class="page-action"> 
        <li><button type="button" class="btn btn-default" onclick="submitForm('new',1)"><i class="glyphicon glyphicon-plus-sign"></i> New</button></li>
        <li><button type="button" class="btn btn-default" onclick="submitForm('delete')"><i class="glyphicon glyphicon-remove"></i> Delete</button></li>
    </ul>
HTML;
    $page_contents .= <<< HTML
        <form action="$htmladmin/index.php" method="post" style="margin:0px;" name="pageList">
            <table width="100%" class="bordered">
                    <thead>
                        <tr>
                            <th width="30" align="center">
                                <label class="custom-check">
                                    <input type="checkbox" name="all" id="checkall">
                                    <span></span>
                                </label>
                            </th>
                            <th>USER</th>
                            <th width="200">EMAIL ADDRESS</th>
                            <th width="200">ACCESS GROUP</th>
                        </tr>
                    </thead>
                    <tbody style="border-left:1px solid #CCCCCC;border-right:1px solid #CCCCCC;">$active_pages</tbody>
            </table>
            
            <input type="hidden" name="action" value="" id="action">
            <input type="hidden" name="do" value="users">
		</form>
HTML;

require "resultPage.php";
echo $result_page;
exit();
}







?>
