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

    global $message,$valid,$item_select,$f_id,$f_position,$htmladmin,$cmsset_id, $main_heading;

    $action		= $_REQUEST['action'];
    $cmsset_id          = $_REQUEST['cmsset_id'];
    $main_heading = 'Cms Settings';
    switch ($action) {
        case 'save':
            @include('inc_cmssettings_save.php');
            $return = save_items();
            break;
    }

    $c = 0;
    $active_pages ="";
    $page_contents = "";
    $sql = "SELECT *
            FROM cms_settings
            ORDER BY cmsset_label";
    $result = run_query($sql);
    while($row = mysql_fetch_assoc($result)) {
        $cmsset_id           = $row['cmsset_id'];
        $cmsset_name     = $row['cmsset_name'];
        $cmsset_label       = $row['cmsset_label'];
        $cmsset_explanation       = $row['cmsset_explanation'];
        $cmsset_status         = $row['cmsset_status'];
        $cmsset_value  = $row['cmsset_value'];

        if ($c%2 == 0 ? $bgc = "#FFFFFF": $bgc = "#F6F8FD");
        $c++;

        if($cmsset_status == 'A'){ $checked = 'checked'; $disabled = ''; }else{ $checked = ''; $disabled = ' disabledinput'; }

        $set_status = "<input type=\"checkbox\" name=\"cmsset_status_$cmsset_id\" value=\"$cmsset_id\" class=\"onoffcheckbox\" $checked>";

        $set_value = "<input type=\"text\" name=\"cmsset_value_$cmsset_id\" style=\"padding:0 0 0 10px;text-align:left;width:140px;\" value=\"$cmsset_value\" class=\"$disabled\"/>
                        <input type=\"hidden\" name=\"cmsset_id[]\" value=\"$cmsset_id\" />";

        if($cmsset_explanation != ''){
            $set_explanation = "<span title=\"$cmsset_explanation\" class=\"tooltip\"></span>";
        }else{
            $set_explanation = '';
        }
        $editlink="$cmsset_label &nbsp;&nbsp; $set_explanation ";

        $active_pages .= <<< HTML
            <tr>
                <td width="70" align="left">$set_status</td>
                <td width="150">$set_value</td>
                <td>$editlink</td>
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
           
        </ul>
HTML;

					 

					 
    $page_contents.= <<< HTML
    <form action="$htmladmin/index.php" method="post" style="margin:0px;" name="pageList">
        <table width="100%" class="bordered">
            <thead>
                <tr>                                
                    <th width="70" align="left">&nbsp;Status</th>
                    <th width="150" align="left">VALUE</th>
                    <th >SETTING</th>
                </tr>
            </thead>
            <tbody>
                $active_pages
            </tbody>
        </table>
        
        <input type="hidden" name="action" value="" id="action">
        <input type="hidden" name="do" value="cmssettings">
    </form>
HTML;

    require "resultPage.php";
    echo $result_page;
    exit();
}




?>
