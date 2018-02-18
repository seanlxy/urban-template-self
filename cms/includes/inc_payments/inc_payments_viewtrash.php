<?php


function view_trash()
{

    global $message,$valid,$item_select,$testm_id,$testm_rank,$htmladmin, $main_heading, $do, $obj_payment;

    $main_heading .= ' | Trash';

   if($_POST['action'] === 'restore')
    {
        $items_to_restore = $_POST['item_select'];

        if( !empty($items_to_restore) )
        {
            $ids = implode(', ', $items_to_restore);


            $query = "UPDATE `pmt_request` SET `cms_status` = '".Payment::FLAG_ACTIVE."' WHERE `id` IN({$ids})";

            run_query($query);

            $_SESSION['flash_msg'] = 'Selected items has been retored successfully.';
            
            header("Location: $htmladmin/?do={$do}");
            exit();
        }
        else
        {
            $_SESSION['flash_msg'] = 'Please select an item from list';
        }
    }
    
    $c = 0;

    $active_pages  = "";
    $page_contents = "";
    
    function generate_item_list($parent_id = 0)
    {
        global $c, $htmladmin, $do;


        $sql = "SELECT LPAD(pr.`id`, 5, '0') AS payment_no, pr.`id`, pr.`amount`, pr.`status`,
            pr.`request_url`, pr.`pmt_payer_id`, pp.`full_name`, pp.`email_address`,
            DATE_FORMAT(pr.`created_on`, '%d %b %Y at %h:%i %p') AS created_date
            FROM `pmt_request` pr
            LEFT JOIN `pmt_payer` pp
            ON(pp.`id` = pr.`pmt_payer_id`)
            WHERE pr.`cms_status` = '".Payment::FLAG_DELETED."'
            ORDER BY pr.`created_on` DESC";

        $rows = fetch_all($sql);

        $html = '';
        $indentation = 0;
        $c++;

        if( !empty($rows) )
        {

            for ($i=1; $i < $c; $i++) $indentation += 48;

            foreach ($rows as $index => $row)
            {
                extract($row);

                $bgc = (($index % 2) == 1) ? '#fff' : '#f6f8fd';
                
                $label = ($full_name) ? $full_name : 'Untitled';


                $item_select="<label class=\"custom-check\"><input type=\"checkbox\" name=\"item_select[]\" class =\"checkall\" value=\"{$id}\"><span></span></label>";

                $status = '<span class="label label-danger">DELETED</span>';

                $html .= <<< HTML
                <tr>
                    <td width="20" align="center">$item_select</td>
                    <td width="100"  align="center">#{$payment_no}</td>
                    <td width="160">{$created_date}</td>
                    <td width="200">{$label}</td>
                    <td width="200"><a href="mailto:{$email_address}">{$email_address}</a></td>
                    <td width="100">{$status}</td>
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
        <li><a class="btn btn-default" href="{$htmladmin}/?do={$do}"><i class="glyphicon glyphicon-arrow-left"></i> Back</a></li>
    </ul>
HTML;

                     
    $page_contents.= <<< HTML
      <form action="$htmladmin/?do={$do}&view=trash" method="post" style="margin:0px;" name="pageList">
        
        <table width="100%" class="bordered">
             <thead>
                <tr>
                    <th width="20"><label class="custom-check"><input type="checkbox" name="all" id="checkall"><span></span></label></td>
                    <th width="100">REQUEST ID</td>
                    <th width="160">REQUEST DATE</th>
                    <th width="200">NAME</th>
                    <th width="200">EMAIL ADDRESS</th>
                    <th width="100">STATUS</th>
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