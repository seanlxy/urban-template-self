<?php

## ----------------------------------------------------------------------------------------------------------------------
## NetZone 1.0
## inc_slides.php
##
## Author: Ton Jo Immanuel, Tomahawk Brand Management Ltd.
## Date: 16 April 2010
##
## Manage Enquiries
##
##
## ----------------------------------------------------------------------------------------------------------------------
function do_main() {


    global $slidegroup_id,$message,$valid,$item_select,$htmladmin, $main_heading;

    $active_pages = "";

    $slidegroup_id		= $_REQUEST['slidegroup_id'];
    $item_select		= $_REQUEST['item_select'];
    $action			= $_REQUEST['action'];
     $main_heading = 'Enquiries';

    switch ($action) {
        case 'edit':
            @include('inc_enquiries_edit.php');
            $return = edit_item();
            break;
        case 'delete':
            @include('inc_enquiries_delete.php');
            $return = delete_item();
            break;
    }

    $c = 0;
    $active_pages ="";
    $page_contents = "";

    $sql = "SELECT `id`, TRIM(CONCAT(`first_name`, ' ', `last_name`)) AS name, `email_address`,
    DATE_FORMAT(`date_of_enquiry`, '%e %b %Y @ %h:%i %p') AS date_enquired
    FROM `enquiry`
    WHERE `status` != 'D'
    ORDER BY `date_of_enquiry` DESC";

    $result = fetch_all($sql);


    foreach($result as $row)
    {

        $eid      = $row['id'];
        $ename    = $row['name'];
        $eemail   = mail_to($row['email_address']);
       
        $edate    = $row['date_enquired'];
        
        if ($c == 0 ? $bgc = "#FFFFFF": $bgc = "#F6F8FD");

        $c++;
        if($c == 2) $c = 0;

        $editlink="<a title=\"View Details\" href=\"$htmladmin/index.php?do=enquiries&action=edit&id=$eid\">#".str_pad($eid, 4, 0, STR_PAD_LEFT)."</a>";
        $item_select="<label class=\"custom-check\"><input type=\"checkbox\" name=\"item_select[]\" class =\"checkall\" value=\"$eid\"><span></span></label>";


        $active_pages .= <<< HTML
                    
                <tr>
                    <td width="20">$item_select</td>
                    <td width="70">$editlink</td>
                    <td width="250">$ename</td>
                    <td width="250">$eemail</td>
                    <td width="150">$edate</td>
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
            <li><button type="button" class="btn btn-default" onclick="submitForm('delete')"><i class="glyphicon glyphicon-remove"></i> Delete</button></li>
        </ul>
HTML;
    $page_contents .= <<< HTML
        <form action="$htmladmin/index.php" method="post" style="margin:0px;" name="pageList">
            <table width="100%" class="bordered">
                <thead>
                <tr>
                    <th width="20" align="center">
                        <label class="custom-check">
                            <input type="checkbox" name="all" id="checkall">
                            <span></span>
                        </label>
                    </th>
                    <th width="70">Enquiry ID</th>
                    <th  width="250">Person Name</th>
                    <th  width="250">Person Email</th>
                    <th  width="150">Enquiry Date</th>
                </tr>
                </thead>
                <tbody>
                    $active_pages
                </tbody>
            </table>
            <input type="hidden" name="action" value="" id="action">
            <input type="hidden" name="do" value="enquiries">
        </form>
HTML;

    require "resultPage.php";
    echo $result_page;
    exit();
}

?>
