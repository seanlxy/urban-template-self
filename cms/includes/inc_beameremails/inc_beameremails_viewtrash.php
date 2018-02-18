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

            $query = "UPDATE `beamer_email` SET `status` = 'H' WHERE `id` IN ($page_ids)";

            run_query($query);

            set_flash_msg('Selected items has been restored successfully');
            redirect("{$htmladmin}?do={$do}");
        }
        else
        {
            set_flash_msg('Plese select an item from list');
            redirect("{$htmladmin}?do={$do}&view=trash");
        }
    }
    
    $c = 0;

    $active_pages  = "";
    $page_contents = "";
    
    function generate_item_list($parent_id = 0)
    {
        global $c, $htmladmin, $do;

       $sql = "SELECT `id`, `name`
            FROM `beamer_email`
            WHERE `status` = 'D'
            ORDER BY `name`";

        $rows = fetch_all($sql);

        $html        = '';
       
        if( !empty($rows) )
        {
            foreach ($rows as $index => $row)
            {
                extract($row);
                $bgc = (($index % 2) == 1) ? '#fff' : '#f6f8fd';
                
                $label = ($name) ? $name : 'Untitled';

                $editlink="<a href=\"$htmladmin/?do={$do}&action=edit&id=$id\">$label</a>";

                $item_select="<label class=\"custom-check\"><input type=\"checkbox\" name=\"item_select[]\" class =\"checkall\" value=\"$id\"><span></span></label>";

                $status = '<span class="label label-danger">Deleted</span>';

                $html .= <<< HTML
                <tr>
                    <td width="20" align="center">$item_select</td>
                    <td>
                        $editlink
                    </td>
                    <td width="90">$status</td>
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
                    <th align="left">MailChimp Lists</th>
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
    
    destroy_flash_msg();
    require "resultPage.php";
    echo $result_page;
    exit();
    
}




?>