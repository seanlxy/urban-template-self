<?php


function view_trash()
{

    global $message,$valid,$item_select,$testm_id,$testm_rank,$htmladmin, $main_heading, $do;

    $main_heading .= ' | Trash';

   if($_POST['action'] === 'restore')
    {
        $items_to_restore = $_POST['item_select'];

        if(count($items_to_restore) > 0)
        {
            $page_ids = implode(', ', $items_to_restore);

            $query = "UPDATE `page_meta_data` SET `status` = 'H', `date_deleted` = NULL WHERE `id` IN ($page_ids)";

            run_query($query);

            header("Location: $htmladmin/?do={$do}");
            exit();
        }
        else
        {
            $message = 'Plese select an item from list';
        }
    }
    
    $c = 0;

    $active_pages = "";
    $page_contents = "";
    
    function generate_item_list($parent_id = 0)
    {
        global $c, $htmladmin, $do;

        $sql = "SELECT bc.`id`, pmd.`id` AS page_meta_id, pmd.`name`, pmd.`status`, pmd.`rank`,
        DATE_FORMAT(pmd.`date_deleted`, '%d %M %Y %h:%i %p') AS deleted_date
        FROM `blog_category` bc
        LEFT JOIN `page_meta_data` pmd
        ON(pmd.`id` = bc.`page_meta_data_id`)
        WHERE pmd.`status` = 'D'
        ORDER BY pmd.`status`, pmd.`rank`";
        
        $rows = fetch_all($sql);

        $html = '';
        $indentation = 0;
        $c++;

        if(count($rows) > 0)
        {

            for ($i=1; $i < $c; $i++) $indentation += 48;

            foreach ($rows as $index => $row)
            {
                extract($row);
                $bgc = (($index % 2) == 1) ? '#fff' : '#f6f8fd';
                
                $label = ($name) ? str_truncate($name, 70) : 'Untitled';

                $editlink="<a href=\"$htmladmin/?do={$do}&action=edit&id=$id\">$label</a>";

                $item_select="<label class=\"custom-check\"><input type=\"checkbox\" name=\"item_select[]\" class =\"checkall\" value=\"$page_meta_id\"><span></span></label>";

                $status = '<span class="label label-danger">Deleted</span>';

                if(!$deleted_date)
                {
                    $deleted_date = '-';
                }

                $html .= <<< HTML
                <tr>
                    <td width="20" align="center">$item_select</td>
                    <td style="padding-left:{$indentation}px;">
                        <input type="hidden" name="testm_id[]" value="$page_meta_id">
                        <input type="text" name="testm_rank[]" value="$rank" style="color:#999999;margin-right:10px;margin-left:10px;width:30px;text-align:center;">
                        $editlink
                    </td>
                    <td width="250" align="right">$deleted_date</td>
                    <td width="100">$status</td>
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
        <li><button type="button" class="btn btn-default" onclick="submitForm('restore',1)"><i class="fa fa-history"></i> Restore</button></li>
    </ul>
HTML;

                     
    $page_contents.= <<< HTML
      <form action="$htmladmin/?do={$do}&view=trash" method="post" style="margin:0px;" name="pageList">
        <table width="100%" class="bordered">
             <thead>
                <tr>
                    <th width="20" align="center">
                        <label class="custom-check">
                            <input type="checkbox" name="all" id="checkall">
                            <span></span>
                        </label>
                    </th>
                    <th  align="left">Category</th>
                    <th  width="200" align="left" style="font-size:12px;">Deleted On</th>
                    <th  width="100" align="left">Status</th>
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