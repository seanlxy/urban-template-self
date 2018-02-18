<?php


function view_trash()
{

    global $message,$valid,$item_select,$testm_id,$testm_rank,$htmladmin;

   if($_POST['action'] === 'restore')
    {
        $items_to_restore = $_POST['item_select'];
        if(count($items_to_restore) > 0)
        {
            $page_ids = implode(', ', $items_to_restore);
            $query = "UPDATE region SET status = 'H' WHERE id IN ($page_ids)";
            run_query($query);

            header("Location: $htmladmin/index.php?do=region");
            exit();
        }
        else
        {
            $message = 'Plese select an item from list';
        }
    }

    $c = 0;
    $active_pages ="";
    $page_contents = "";
    $sql = "SELECT `id`, `name`, `rank`
    FROM `region`
    WHERE `status` = 'D'
    ORDER BY `status`, `rank`";

    $result = run_query($sql);
       while($row = mysql_fetch_assoc($result)) {
        extract($row);
        if ($c%2 == 1 ? $bgc = "#FFFFFF": $bgc = "#F6F8FD");
        $c++;

        $label = ($name) ? str_truncate($name, 70) : 'Untitled';
        $editlink="<a href=\"$htmladmin/index.php?do=region&action=edit&id=$id\">$label</a>";
        $item_select="<label class=\"custom-check\"><input type=\"checkbox\" name=\"item_select[]\" class =\"checkall\" value=\"$id\"><span></span></label>";
        $active_pages .= <<< HTML
           <tr>
                <td width="20" align="center">$item_select</td>
                <td width="50">
                    <input type="hidden" name="testm_id[]" value="$id">
                    <input type="text" name="testm_rank[]" value="$rank" style="color:#999999; width:30px;text-align:center;">
                </td>
                <td width="700">$editlink</td>
                <td width="100"><span class="label label-danger">Deleted</span></td>
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
        <li><button type="button" class="btn btn-default" onclick="submitForm('restore',1)"><i class="fa fa-history"></i> Restore</button></li>
    </ul>
HTML;

                     
    $page_contents.= <<< HTML
      <form action="$htmladmin/index.php?do=region&view=trash" method="post" style="margin:0px;" name="pageList">
        <table width="100%" class="bordered">
            <thead>
                <tr>
                    <th width="20" align="center">
                        <label class="custom-check">
                            <input type="checkbox" name="all" id="checkall">
                            <span></span>
                        </label>
                    </th>
                    <th  width="50" align="left">Rank</th>
                    <th  width="700" align="left">Label</th>
                    <th  width="100" align="left">Status</th>
                </tr>
            </thead>
            <tbody>
                $active_pages
            </tbody>
        </table>
        <input type="hidden" name="action" value="" id="action">
        <input type="hidden" name="do" value="region">
    </form>
HTML;

    require "resultPage.php";
    echo $result_page;
    exit();
}




?>