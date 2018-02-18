<?php

## ----------------------------------------------------------------------------------------------------------------------
## NetZone 1.0
## inc_slides.php
##
## Author: Ton Jo Immanuel, Tomahawk Brand Management Ltd.
## Date: 16 April 2010
##
## Manage Slideshow
##
##
## ----------------------------------------------------------------------------------------------------------------------
function do_main() {


    global $slidegroup_id,$message,$valid,$item_select,$htmladmin, $main_heading, $do;

    $active_pages = "";

    $slidegroup_id = $_REQUEST['slidegroup_id'];
    $item_select   = $_REQUEST['item_select'];
    $action        = $_REQUEST['action'];

    $main_heading  = 'Galleries';

    switch ($action) {
        case 'edit':
            @include('inc_'.$do.'_edit.php');
            $return = edit_item();
            break;

        case 'new':
            @include('inc_'.$do.'_new.php');
            $return = new_item();
            break;

        case 'save':
            @include('inc_'.$do.'_save.php');
            $return = save_item();
            break;

        case 'delete':
            @include('inc_'.$do.'_delete.php');
            $return = delete_item();
            break;

        case 'saverank':
            include_once('inc_'.$do.'_saverank.php');
            $return = save_rank();
            break;
    }

    $c             = 0;
    $active_pages  = "";
    $page_contents = "";


    $galleries = fetch_all("SELECT `id`, `name`, `show_on_gallery_page`,`rank`
        FROM `photo_group`
        WHERE `type` = 'G'
        AND `show_in_cms` = 'Y'
        ORDER BY `rank`");


    foreach( $galleries as $gallery )
    {

        $slidegroup_id        = $gallery['id'];
        $slidegroup_name      = $gallery['name'];
        $rank                 = $gallery['rank'];
        $show_on_gallery_page = ($gallery['show_on_gallery_page'] == 'Y') ? '<span class="label label-success">Yes</span>' : '<span class="label label-default">No</span>';

        if ($c == 0 ? $bgc = "#FFFFFF": $bgc = "#F6F8FD");

        $c = $c + 1;
        if ($c == 2) {
            $c = 0;
        }

        $editlink="<a href=\"$htmladmin/index.php?do={$do}&action=edit&id=$slidegroup_id\">$slidegroup_name</a>";

        $item_select="<label class=\"custom-check\"><input type=\"checkbox\" name=\"item_select[]\" class =\"checkall\" value=\"$slidegroup_id\"><span></span></label>";

        $active_pages .= <<< HTML
        <tr>
            <td width="20" align="center">$item_select</td>
            <td>
                <input type="hidden" name="testm_id[]" value="$slidegroup_id">
                <input type="text" name="testm_rank[]" value="$rank" style="color:#999999;margin-right:10px;margin-left:10px;width:30px;text-align:center;">
                $editlink
            </td>
            <td width="120">$show_on_gallery_page</td>
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
        <li><button type="button" class="btn btn-default" onclick="submitForm('new',1)"><i class="fa fa-camera-retro"></i> New</button></li>
        <li><button type="button" class="btn btn-default" onclick="submitForm('saverank', 1)"><i class="glyphicon glyphicon-sort-by-order"></i> Save Rank</button></li>
        <li><button type="button" class="btn btn-default" onclick="submitForm('delete')"><i class="glyphicon glyphicon-remove"></i> Delete</button></li>
    </ul>
HTML;
$page_contents .= <<< HTML
    <form  action="$htmladmin/index.php" method="post" style="margin:0px;" name="pageList">
        <table width="100%" class="bordered">
            <thead>
                <tr>
                    <th width="20"><label class="custom-check"><input type="checkbox" name="all" id="checkall"><span></span></label></td>
                    <th>Name</td>
                    <th width="120">On gallery page</td>
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
