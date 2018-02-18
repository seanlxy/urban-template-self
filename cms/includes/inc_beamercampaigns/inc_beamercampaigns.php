<?php

## ----------------------------------------------------------------------------------------------------------------------
## NetZone 1.0
## inc_faq.php
##
## Author: Ton Jo Immanuel, Tomahawk Brand Management Ltd.
## Date: 19 April 2010
##
## Manage FAQ
## ----------------------------------------------------------------------------------------------------------------------

function do_main(){

    global $message, $valid, $item_select, $testm_id, $testm_rank, $admin_dir, $htmladmin, $main_heading, $do, $action;

    $action       = ($_GET['view']) ? $_GET['view'] : $action;
    $item_select  = $_POST['item_select'];
    $testm_id     = $_POST['testm_id'];

    $main_heading = 'Newsletter Campaigns';

    $message = get_flash_msg();

    destroy_flash_msg();

    switch($action)
    {

        case 'publish':
            @include_once('inc_'.$do.'_publish.php');
            $return = publish_items();
            break;

        case 'hide':
            include_once('inc_'.$do.'_hide.php');
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
        case 'preview':
            @include_once('inc_'.$do.'_preview.php');
            $return = preview_item();
            break;
        case 'trash':
            @include_once('inc_'.$do.'_viewtrash.php');
             $return = view_trash();
        break;
       
    }

    $c = 0;

    $active_pages = "";
    $page_contents = "";
    
    function generate_item_list($parent_id = 0)
    {
        global $c, $htmladmin, $do;

        $sql = "SELECT `id`, `name`, `status`, `beamer_phase` AS phase,
            DATE_FORMAT(`date_updated`, '%d %b %Y %r') AS updated_date,
            DATE_FORMAT(`date_created`, '%d %b %Y %r') AS created_date
            FROM `beamer_campaign`
            WHERE `status` != 'D'
            ORDER BY `status`, `beamer_phase`, `name`";

        $rows = fetch_all($sql);

        $html = '';
       
        if( !empty($rows) )
        {
            foreach ($rows as $index => $row)
            {
                extract($row);

                $bgc = (($index % 2) == 1) ? '#fff' : '#f6f8fd';
                
                $label = ($name) ? $name : 'Untitled';

                $editlink="<a href=\"$htmladmin/?do={$do}&action=edit&id=$id\">$label</a>";

                $item_select="<label class=\"custom-check\"><input type=\"checkbox\" name=\"item_select[]\" class =\"checkall\" value=\"$id\"><span></span></label>";

                if ($status == "A") { $status = '<span class="label label-success">Active</span>'; }
                if ($status == "H") { $status = '<span class="label label-warning">Hidden</span>'; }

                if ($phase == "P") { $phase = '<span class="label label-success">Published</span>'; }
                if ($phase == "D") { $phase = '<span class="label label-warning">Draft</span>'; }
              
                $html .= <<< HTML
                <tr>
                    <td width="20" align="center">$item_select</td>
                    <td>
                        $editlink
                    </td>
                    <td width="200">$created_date</td>
                    <td width="200">$updated_date</td>
                    <td width="90">$phase</td>
                </tr>
HTML;

            }

        }

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
            <li><button type="button" class="btn btn-default" onclick="submitForm('new',1)"><i class="glyphicon glyphicon-plus-sign"></i> New</button></li>
            <li><button type="button" class="btn btn-default" onclick="submitForm('delete')"><i class="glyphicon glyphicon-trash"></i> Move to trash</button></li>
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
                    <th align="left">Newsletter Campaign</th>
                    <th width="200" align="left">Created On</th>
                    <th width="200" align="left">Updated On</th>
                    <th width="90" align="left">Status</th>
        
                </tr>
            </thead>
            <tbody>
                {$active_pages}
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