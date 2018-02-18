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

    global $message, $valid, $item_select, $testm_id, $testm_rank, $htmladmin, $main_heading, $do, $action;

    $action       = ($_GET['view']) ? $_GET['view'] : $action;
    $item_select  = $_POST['item_select'];
    $testm_id     = $_POST['testm_id'];

    $main_heading = 'Accommodation';

    switch($action)
    {

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
            $return = view_trash();
        break;
        
        case 'saverank':
            @include_once('inc_'.$do.'_saverank.php');
            $return = save_rank();
            break;
    }

    $c             = 0;
    $active_pages  = "";
    $page_contents = "";
    
    function generate_item_list($parent_id = 0)
    {
        global $c, $htmladmin, $do;

        $sql = "SELECT a.`id`, pmd.`name`, pmd.`id` AS page_meta_id, pmd.`status`, pmd.`rank`,
        DATE_FORMAT(pmd.`date_created`, '%d %b %Y %h:%i %p') AS created_date, DATE_FORMAT(pmd.`date_updated`, '%d %b %Y %h:%i %p') AS updated_date
        FROM `accommodation` a
        LEFT JOIN `page_meta_data` pmd
        ON(pmd.`id` = a.`page_meta_data_id`)
        WHERE pmd.`status` != 'D'
        ORDER BY pmd.`status`, pmd.`rank`";
        
        $rows = fetch_all($sql);

        $html        = '';
        $indentation = 0;
        $c++;

        if( !empty($rows) )
        {

            for ($i=1; $i < $c; $i++) $indentation += 48;

            foreach ($rows as $index => $row)
            {
                extract($row);
                $bgc = (($index % 2) == 1) ? '#fff' : '#f6f8fd';
                $label = ($name) ? str_truncate($name, 70) : 'Untitled';

                $editlink = "<a href=\"$htmladmin/?do={$do}&action=edit&id=$id\">$label</a>";

                $item_select = "<label class=\"custom-check\"><input type=\"checkbox\" name=\"item_select[]\" class =\"checkall\" value=\"$page_meta_id\"><span></span></label>";

                if ($status == "A") { $status = '<span class="label label-success">Published</span>'; }
                if ($status == "H") { $status = '<span class="label label-warning">Hidden</span>'; }

                if(!$updated_date)
                {
                    $updated_date = '-';
                }

                $html .= <<< HTML
                <tr>
                    <td width="20" align="center">$item_select</td>
                    <td style="padding-left:{$indentation}px;">
                        <input type="hidden" name="testm_id[]" value="$page_meta_id">
                        <input type="text" name="testm_rank[]" value="$rank" style="color:#999999;margin-right:10px;margin-left:10px;width:30px;text-align:center;">
                        $editlink
                    </td>
                    <td width="200" align="right">$created_date</td>
                    <td width="200" align="right">$updated_date</td>
                    <td width="60">$status</td>
                </tr>
HTML;
                

            }



        }

        $c--;


        return $html;
    }


    $active_pages = generate_item_list();

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
            <li class="pull-right">
                <a href="$htmladmin/?do={$do}&view=trash" class="btn btn-default">
                    <i class="glyphicon glyphicon-trash"></i> View trash
                </a>
            </li>
            <li><button type="button" class="btn btn-default" onclick="submitForm('new',1)"><i class="glyphicon glyphicon-picture"></i> New</button></li>
            <li><button type="button" class="btn btn-default" onclick="submitForm('delete')"><i class="glyphicon glyphicon-trash"></i> Move to trash</button></li>
            <li><button type="button" class="btn btn-default" onclick="submitForm('publish')"><i class="glyphicon glyphicon-eye-open"></i> Publish</button></li>
            <li><button type="button" class="btn btn-default" onclick="submitForm('hide')"><i class="glyphicon glyphicon-eye-close"></i> Hide</button></li>
            <li><button type="button" class="btn btn-default" onclick="submitForm('saverank', 1)"><i class="glyphicon glyphicon-sort-by-order"></i> Save Rank</button></li>
        </ul>
HTML;
					 
    $page_contents.= <<< HTML

    <form action="{$htmladmin}/?do={$do}" method="post" style="margin:0px;" name="pageList">
        <table width="100%" class="bordered">
            <thead>
                <tr>
                    <th width="20" align="center">
                        <label class="custom-check">
                            <input type="checkbox" name="all" id="checkall">
                            <span></span>
                        </label>
                    </th>
                    <th align="left">Accommodation Name</th>
                    <th  width="200" align="left" style="font-size:12px;">Created on</th>
                    <th  width="200" align="left" style="font-size:12px;">Last Updated On</th>
                    <th  width="60" align="left">Status</th>
                </tr>
            </thead>
            <tbody>
                $active_pages
            </tbody>
        </table>
        <input type="hidden" name="action" value="" id="action">
        <input type="hidden" name="do" value="{$do}">
    </form>
HTML;

require "resultPage.php";
echo $result_page;
exit();

}

?>