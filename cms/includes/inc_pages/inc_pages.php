<?php
session_start();

## ----------------------------------------------------------------------------------------------------------------------
## NetZone 1.0
## inc_pages.php
##
## Author: Ton Jo Immanuel, Tomahawk Brand Management Ltd.
## Date: 15 April 2010
##
## Manage website pages
## ----------------------------------------------------------------------------------------------------------------------

############################################################################################################################
## Page editor
############################################################################################################################

function do_main() {

    global $htmladmin, $active_pages, $valid, $page_id, $page_rank, $message, $item_select, $page_slidegroup, $page_title, $page_mkeywords, $page_mdescription,
    $page_heading,$page_url,$scripts_onload, $main_heading, $do, $upload_dir;

    $active_pages = "";

    $page          = $_REQUEST['page'];
    $action        = ($_GET['view']) ? $_GET['view'] : $_REQUEST['action'];
    $page_id       = $_REQUEST['page_id'];
    $page_rank     = $_REQUEST['page_rank'];
    $remove        = $_REQUEST['remove'];
    $removef       = $_REQUEST['removef'];
    $status        = $_REQUEST['status'];
    $item_select   = $_REQUEST['item_select'];
    $fl_select     = $_REQUEST['fl_select'];
    $page_default  = $_REQUEST['page_default'];
    $page_contents = "";
    $main_heading = 'General Pages';


############################################################################################################################
## Get the form action and do something...
############################################################################################################################

    switch ($action) {
        case 'publish':
            @include_once('inc_'.$do.'_publish.php');
            $return = publish_items();
            break;

        case 'hide':
            @include_once('inc_'.$do.'_hide.php');
            $return = hide_items();
            break;
        case 'new':
            @include_once('inc_'.$do.'_new.php');
            $return = new_item();
            break;
        case 'delete':
            @include_once('inc_'.$do.'_delete.php');
            $return = delete_items();
            break;

        case 'edit':
            @include_once('inc_'.$do.'_edit.php');
            $return = edit_item();
            break;

        case 'save':
            @include_once('inc_'.$do.'_save.php');
            $return = save_item();
            
        break;
        case 'trash':
            @include_once('inc_'.$do.'_viewtrash.php');
            view_trash();
        break;
        case 'saverank':
            @include_once('inc_'.$do.'_saverank.php');
            $return = save_rank($page_id,$page_rank);
            break;
    }

############################################################################################################################
## Get the list of general_pages
############################################################################################################################

    //Making the list of Parent
    function generatePageTable($active_pages,$parent_id = 0)
    {

        global $generation, $id, $htmladmin, $scripts_onload, $do;

        $sql = "SELECT gp.`id`, pmd.`id` AS meta_data_id, pmd.`name`, pmd.`status`, pmd.`title`, pmd.`url`, pmd.`rank`,
            pmd.`is_locked`, DATE_FORMAT(pmd.`date_updated`, '%d %b %Y %r') AS updated_date, pmd.`updated_by`, gp.`parent_id`
            FROM `general_pages` gp
            LEFT JOIN `page_meta_data` pmd
            ON(gp.`page_meta_data_id` = pmd.`id`)
            WHERE pmd.`status` != 'D'
            AND gp.`parent_id` = '{$parent_id}'
            ORDER BY pmd.`status`, pmd.`rank`";

        $result = run_query($sql);

        $generation++;
        $indentation = '';
        for($i=1;$i<$generation;$i++){ $indentation = $indentation + 48; }

        if(mysql_num_rows($result) > 0){
            $functioncount++;
            $active_pages .= <<< HTML
            <ul>
HTML;
        }

        $important_pages = array();
        $important_pages_csv = fetch_value("SELECT GROUP_CONCAT(DISTINCT `page_id`) FROM `general_importantpages` WHERE `page_id` != '0'");
      
        if($important_pages_csv)
        {
            $important_pages = explode(',', $important_pages_csv);
        }

 
        while($row = mysql_fetch_assoc($result))
        {
            $c++;

            // Set all of this page's values
            $page_id                = $row['id'];
            $page_parentid          = $row['parent_id'];
            $page_title             = $row['title'];
            $page_label             = $row['name'];
            $page_rank              = $row['rank'];
            $page_status            = $row['status'];
            $page_url               = $row['page_url'];
            $page_dateupdated       = $row['updated_date'];
            $page_is_locked         = $row['is_locked'];
            $meta_data_id           = $row['meta_data_id'];

            ## if this page's label is empty, then set it to be the page's title
            if($page_label == ''){ $page_label = $page_title; }
            ## if this page's label is STILL empty, then set it to be the page's url
            if($page_label == ''){ $page_label = $page_url;   }


            $page_label = ($page_label) ? $page_label : 'Untitled';

            $item_select="<label class=\"custom-check\"><input type=\"checkbox\" name=\"item_select[]\" class =\"checkall\" value=\"$meta_data_id\"><span></span></label>";

            if ($page_is_locked || in_array($page_id, $important_pages))
            {
                $item_select="<i class=\"glyphicon glyphicon-lock row-locked\" title=\"The homepage is always locked and can not be hidden \"></i>";
            }
            $page_status = ($page_status === 'A') ? '<span class="label label-success">Published</span>' : '<span class="label label-warning">Hidden</span>';

            $editlink="<a href=\"$htmladmin/?do={$do}&action=edit&id=$page_id\" title=\"Edit the '$page_label' page\">$page_label</a>";

            // Add this page to the dropdown menu
            $active_pages .= <<< HTML
            <tr>
                <td width="20" align="center">$item_select</td>
                <td style="padding-left:$indentation;">
                <input type="hidden" name="page_id[]" value="$meta_data_id">
                <input type="text" name="page_rank[]" value="$page_rank" title="Page Rank for $page_label" style="color:#999999;margin-left:{$indentation}px;margin-right:15px;text-align:center;width:30px;">
                $editlink
                </td>
                <td width="200">$page_dateupdated</td>
                <td width="100" align="center">$page_status</td>
            </tr>
HTML;

            // Get all of the children of this page.
            // put the $disabled parameter to make sure that if this page can not be selected, then all of its childeren should not be able to be selected.
            $active_pages = generatePageTable($active_pages,$page_id);
            
            // Reset the disabled variable to 'enabled' (effectively) so that all of the siblings of this page CAN be selected
            $disabled = '';
            $active_pages .= <<< HTML
                </li>
HTML;
        }
        $generation--;
        if(mysql_num_rows($result) > 0){
            $active_pages .= <<< HTML
            </ul>
HTML;
        }

        return $active_pages;
    }


$functioncount = 1;
        $active_pages = <<< HTML
            <ul class="sortablerow"><li>
HTML;
$generation = 0;
        $active_pages = generatePageTable($active_pages);
$active_pages .= <<< HTML
            </li></ul>
HTML;

    if($message != "")
    {
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
            <li class="pull-right">
                <a href="$htmladmin/?do={$do}&view=trash" class="btn btn-default">
                    <i class="glyphicon glyphicon-trash"></i> View trash
                </a>
            </li>
            <li><button type="button" class="btn btn-default" onclick="submitForm('new',1)"><i class="glyphicon glyphicon-plus-sign"></i> New</button></li>
            <li><button type="button" class="btn btn-default" onclick="submitForm('saverank', 1)"><i class="glyphicon glyphicon-sort-by-order"></i> Save Rank</button></li>
            <li><button type="button" class="btn btn-default" onclick="submitForm('delete')"><i class="glyphicon glyphicon-trash"></i> Move to trash</button></li>
            <li><button type="button" class="btn btn-default" onclick="submitForm('publish')"><i class="glyphicon glyphicon-eye-open"></i> Publish</button></li>
            <li><button type="button" class="btn btn-default" onclick="submitForm('hide')"><i class="glyphicon glyphicon-eye-close"></i> Hide</button></li>
            
        </ul>
HTML;

    $page_contents .= <<< HTML
        <form action="$htmladmin/?do={$do}" method="post" style="margin:0px;" name="pageList" id="pageList">
            <table width="100%" class="bordered">
                <thead>
                    <tr>
                        <th width="20">
                            <label class="custom-check">
                                <input type="checkbox" name="all" id="checkall">
                                <span></span>
                            </label>
                        </th>
                        <th>Page</th>                        
                        <th width="200" align="left">Updated On</th>
                        <th width="100" align="left" align="center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    $active_pages
                </tbody>
            </table>
            <input type="hidden" name="action" value="" id="action">
            <input type="hidden" name="do" value="$do">
        </form>
HTML;
    require "resultPage.php";
    echo $result_page;
    exit();


}
?>