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

    global  $message, $valid, $item_select, $testm_id, $testm_rank, $js_vars, $htmlroot, $rootfull,
        $htmladmin, $main_heading, $do, $action, $classdir, $obj_payment, $obj_form_validation;

    $action       = ($_GET['view']) ? $_GET['view'] : $action;
    $item_select  = $_POST['item_select'];
    $testm_id     = $_POST['testm_id'];
    $id           = $_GET['id'];

    $main_heading = 'Payment Requests';

    $company_details = fetch_row("SELECT `company_name`, `phone_number`, `address`
        FROM `general_settings`
        WHERE `id` = '1'
        LIMIT 1");

    $company_details['root']          = $htmlroot;
    $company_details['logo_path']     = "{$htmlroot}/graphics/logo-sm.png";
    $company_details['dps_logo_path'] = "{$htmlroot}/graphics/dps.jpg";

    require_once "{$classdir}/form_validation.php";
    require_once "{$classdir}/payment.php";

    $obj_form_validation = new FormValidation();


    $payment_config = array(
        'productionMode' => PAYMENT_PRODUCTION_MODE,
        'paymentURL' => "{$htmlroot}/payments",
        'requestEmailTmplPath' => dirname(__FILE__)."/templates/email/request.tmpl",
        'emailTmplData' => $company_details
    );

    $obj_payment = new Payment($payment_config, $id);

    $message = ($_SESSION['flash_msg']) ? $_SESSION['flash_msg'] : '';

    unset($_SESSION['flash_msg']);

    switch($action)
    {

        case 'new':
            @include_once('inc_'.$do.'_new.php');
            $return = new_item();
            break;

        case 'delete':
            @include_once('inc_'.$do.'_delete.php');
            $return = delete_items();
            break;

        case 'resend':
            @include_once('inc_'.$do.'_resend.php');
            $return = resend();
            break;

        case 'cancel':
            @include_once('inc_'.$do.'_cancel.php');
            $return = cancel();
            break;

        case 'restore':
            @include_once('inc_'.$do.'_restore.php');
            $return = restore();
            break;


        case 'templates':
            @include_once('inc_'.$do.'_templates.php');
            $return = templates();
            break;


        case 'config':
            @include_once('inc_'.$do.'_config.php');
            $return = config();
            break;

        case 'edit':
            @include_once('inc_'.$do.'_edit.php');

            $return = edit_item();
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
        global $c, $htmladmin, $do, $obj_payment;

        $sql = "SELECT LPAD(pr.`id`, 5, '0') AS payment_no, pr.`id`, pr.`amount`, pr.`status`, pr.`request_url`,
            pr.`pmt_payer_id`, pp.`full_name`, pp.`email_address`,
            DATE_FORMAT(pr.`created_on`, '%d %b %Y at %h:%i %p') AS created_date
            FROM `pmt_request` pr
            LEFT JOIN `pmt_payer` pp
            ON(pp.`id` = pr.`pmt_payer_id`)
            WHERE pr.`cms_status` = '".Payment::FLAG_ACTIVE."'
            ORDER BY pr.`created_on` DESC";
        
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
                
                $label = ($full_name) ? $full_name : 'Untitled';

                $editlink="<a href=\"$htmladmin/?do={$do}&action=edit&id=$id\"><strong>VIEW</strong></a>";

                $item_select="<label class=\"custom-check\"><input type=\"checkbox\" name=\"item_select[]\" class =\"checkall\" value=\"$id\"><span></span></label>";

                $resend_link = ( $status != Payment::FLAG_APPROVED ) ? '<a href="'.$htmladmin.'/?do='.$do.'&action=resend&id='.$id.'&confirm=0"><strong>RESEND</strong></a>' : '&nbsp;';


                if( $status === Payment::FLAG_CANCELED )
                {

                    $cancel_link = '<a href="'.$htmladmin.'/?do='.$do.'&action=restore&id='.$id.'&confirm=0"><strong>RESTORE</strong></a>';
                }
                else
                {
                    $cancel_link = ( $status != Payment::FLAG_APPROVED ) ? '<a href="'.$htmladmin.'/?do='.$do.'&action=cancel&id='.$id.'&confirm=0"><strong>CANCEL</strong></a>' : '&nbsp;';
                }

                switch ($status)
                {
                    case Payment::FLAG_APPROVED:
                       $status = '<span class="label label-success">APPROVED</span>';
                    break;
                    case Payment::FLAG_DECLINED:
                       $status = '<span class="label label-danger">DECLINED</span>';
                    break;
                    case Payment::FLAG_CANCELED:
                       $status = '<span class="label label-warning">CANCELED</span>';
                    break;
                    case Payment::FLAG_PENDING:
                       $status = '<span class="label label-primary">PENDING</span>';
                    break;
                    case Payment::FLAG_NEW:
                       $status = '<span class="label label-info">NEW REQUEST</span>';
                    break;
                }



                $html .= <<< HTML
                <tr>
                    <td width="100" height="30" align="center">#{$payment_no}</td>
                    <td width="160">{$created_date}</td>
                    <td width="200">{$label}</td>
                    <td width="200"><a href="mailto:{$email_address}">{$email_address}</a></td>
                    <td width="50">{$editlink}</td>
                    <td width="50"><a href="$htmladmin/?do={$do}&action=delete&id={$id}&confirm=0"><strong>DELETE</strong></a></td>
                    <td width="80">{$resend_link}</td>
                    <td width="140">{$cancel_link}</td>
                    <td width="80">{$status}</td>
                </tr>
HTML;
                

            }

        }

        $c--;


        return $html;
    }


    $active_pages = generate_item_list();


   if ($message != "")
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
            <li><a href="{$htmladmin}/?do={$do}&action=new" class="btn btn-default"><i class="glyphicon glyphicon-plus-sign"></i> New</a></li>
            <li><a href="{$htmladmin}/?do={$do}&action=templates" class="btn btn-default"><i class="glyphicon glyphicon-list-alt"></i> Templates</a></li>
            <li><a href="{$htmladmin}/?do={$do}&action=config" class="btn btn-default"><i class="glyphicon glyphicon-cog"></i> Configuration</a></li>
            <li><a href="{$htmladmin}/?do={$do}&action=trash" class="btn btn-default"><i class="glyphicon glyphicon-trash"></i> View Trash</a></li>
        </ul>
HTML;
                     
    $page_contents.= <<< HTML

    <form action="{$htmladmin}/?do={$do}" method="post" style="margin:0px;" name="pageList">
        <table width="100%" class="bordered">
            <thead>
                <tr>
                    <th width="100" height="30">ID</td>
                    <th align="left" width="160">REQUEST DATE</th>
                    <th align="left" width="200">NAME</th>
                    <th align="left" width="200">EMAIL ADDRESS</th>
                    <th align="left" width="50">VIEW</th>
                    <th align="left" width="50">DELETE</th>
                    <th align="left" width="80">RESEND</th>
                    <th align="left" width="140">RESTORE/CANCEL</th>
                    <th align="left" width="80">STATUS</th>
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