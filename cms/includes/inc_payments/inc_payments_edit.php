<?php

############################################################################################################################
## Edit FAQ Item
############################################################################################################################

function edit_item()
{

    global $message,$id,$do,$disable_menu,$valid,$htmladmin, $main_subheading, $js_vars, $obj_payment;

    $disable_menu = "true";

    // $payment_data    = $obj_payment->getDetails($id);
    $payment_data    = $obj_payment->data;
    $payment_history = $payment_data['history'];
    $payment_data['payment_type'] = ($payment_data['payment_type'] === 'P') ? 'Pre Auth Payment' : 'Full Payment'; 

    @extract($payment_data);

    $payment_no = str_pad($id, 5, '0', STR_PAD_LEFT);


    $obj_date_created  = new DateTime($created_on);
    $obj_date_approved = new DateTime($approved_on);
    $obj_date_declined = new DateTime($declined_on);

    $comments = nl2br($comments);


    switch ($status)
    {
        case Payment::FLAG_APPROVED:
           $status_view = '<span class="label label-success">APPROVED</span>';

           $date_label = '<span class="label label-success">APPROVED ON</span>';
           $payment_date = $obj_date_approved->format('l, j M Y @ h:i a');;
        break;
        case Payment::FLAG_DECLINED:
           $status_view = '<span class="label label-danger">DECLINED</span>';
           $date_label = '<span class="label label-danger">DECLINED ON</span>';
           $payment_date = $obj_date_declined->format('l, j M Y @ h:i a');;
        break;
        case Payment::FLAG_CANCELED:
           $status_view = '<span class="label label-warning">CANCELED</span>';
        break;
        case Payment::FLAG_PENDING:
           $status_view = '<span class="label label-primary">PENDING</span>';
        break;
        case Payment::FLAG_NEW:
           $status_view = '<span class="label label-info">NEW REQUEST</span>';
        break;

    }


    $date_view = '';

    if( !empty($date_label) && !empty($payment_date) )
    {

        $date_view = '<tr>
            <td><strong>'.$date_label.'</strong></td>
            <td valign="top">'.$payment_date.'</td>
        </tr>';

    }


    if( $pmt_account_type === Payment::ACCOUNT_TYPE_1 )
    {

        $pmt_account_details_view = <<< H
    
        <tr>
            <td><strong>Merchant Ref.</strong></td>
            <td valign="top">{$merchant_ref}</td>
        </tr>
        <tr>
            <td><strong>DPS Response</strong></td>
            <td valign="top">{$dps_ref}</td>
        </tr>

H;


    }
    elseif( $pmt_account_type === Payment::ACCOUNT_TYPE_2 )
    {

        $pmt_account_details_view = <<< H
    
        <tr>
            <td><strong>PayPal Payer Id</strong></td>
            <td valign="top">{$paypal_payer_id}</td>
        </tr>
        <tr>
            <td><strong>PayPal Payer Status</strong></td>
            <td valign="top">{$paypal_payer_status}</td>
        </tr>

H;


    }


    ##------------------------------------------------------------------------------------------------------
    ## Page functions

    $page_functions = <<< HTML
    <ul class="page-action">
        <li><a class="btn btn-default" href="{$htmladmin}/?do={$do}"><i class="glyphicon glyphicon-arrow-left"></i> Back</a></li>
    </ul>
HTML;

$currency_symbol = PaymentConstants::DEFAULT_CURRENCY_SYMBOL;

$settings_content = <<< HTML
        <style>
            h3{
                margin:0 0 15px 0;
                padding:0;
                font-size:15px;
                color:#1b75bb;
                font-weight:100;
            }
            
            table.striped h3{
                font-size:13px;
            }

            table.striped{
                color:#000;
                font-size:14px;
                border:1px solid #EFEFEF;
                border-bottom:none;
                width: 900px;
            }
            table.striped tr td{
                border-bottom:1px solid #EFEFEF;
                padding:4px 7px;
                vertical-align:top;
                font-size: inherit;
            }
            table.striped tr td:first-child{
                background:#EFEFEF;
                border-bottom:1px solid #fff;
                width:200px;
            }
            
            table.striped.upgrade-opt  tr:last-child td:first-child{
                background:#fff;
            }

            table.striped.upgrade-opt td table td, table.striped.upgrade-opt td table th{
                padding:4px 7px 4px 0;
                text-align:left;
            }
            
            table.striped td.to-right{
                text-align: right;
            }

            .separator{
                border-left:1px dotted #ccc;
            }
            
        </style>
        <h3>Request: #{$payment_no}</h3>
        <table  border="0" cellspacing="0" cellpadding="7" class="striped">
            <tbody>
                <tr>
                    <td><strong>Reference</strong></td>
                    <td valign="top"><strong>{$reference}</strong></td>
                </tr>
                <tr>
                    <td><strong>Payment Method</strong></td>
                    <td valign="top"><strong>{$pmt_account_type}</strong></td>
                </tr>
                <tr>
                    <td><strong>Response Text</strong></td>
                    <td valign="top"><strong>{$response_text}</strong></td>
                </tr>
                <tr>
                    <td><strong>Status</strong></td>
                    <td valign="top">{$status_view}</td>
                </tr>
                
                {$pmt_account_details_view}
                <tr>
                    <td><strong>Date Sent</strong></td>
                    <td valign="top">{$obj_date_created->format('l, j M Y @ h:i a')}</td>
                </tr>
                {$date_view}
                <tr>
                    <td><strong>Amount:</strong></td>
                    <td valign="top">{$currency_symbol} {$amount}</td>
                </tr>
                <tr>
                    <td><strong>To</strong></td>
                    <td valign="top">{$full_name}</td>
                </tr>
                <tr>
                    <td><strong>Email address</strong></td>
                    <td><a href="mailto:{$email_address}">{$email_address}</a></td>
                </tr>
                <tr>
                    <td><strong>Payment Link</strong></td>
                    <td><a target="_blank" href="{$request_url}">{$request_url}</a></td>
                </tr>
                <tr>
                    <td><strong>Payment Type</strong></td>
                    <td>{$payment_type}</td>
                </tr>
                <tr>
                    <td><strong>Comments</strong></td>
                    <td>{$comments}</td>
                </tr>
                <tr>
                    <td><strong>Email Subject</strong></td>
                    <td>{$email_subject}</td>
                </tr>
                <tr>
                    <td><strong>Email Content</strong></td>
                    <td>{$email_content}</td>
                </tr>
            </tbody>
            
        </table>
HTML;


if( !empty($payment_history) )
{

    $history_content = '<table align="center" class="bordered" width="100%">
        <thead>
            <tr>
                <th width="170" height="25">DATE</th>
                <th width="80" height="25">ACTION</th>
                <th height="25">DESCRIPTION</th>
            </tr>
        </thead>
        <tbody>';

   foreach ($payment_history as $history_data)
   {
       $history_content .= '<tr>
            <td width="170" align="center" height="25">'.$history_data['pmt_date_time'].'</td>
            <td width="80" align="center" height="25">'.$history_data['label'].'</td>
            <td align="center" height="25">'.$history_data['details'].'</td>
        </tr>';
   }

   $history_content .= '</tbody>
    </table>';


}


if ($message != "") {

    $message = <<< HTML
      <div class="alert alert-danger page">
          <strong>$message</strong>
      </div>
HTML;


    }

##------------------------------------------------------------------------------------------------------
## tab arrays and build tabs

$temp_array_menutab = array();

$temp_array_menutab['Details'] = $settings_content;
$temp_array_menutab['History'] = $history_content;


$counter = 0;
$tablist ="";
$contentlist="";

foreach($temp_array_menutab as $key => $value)
{

    $tablist.= "<li><a href=\"#tabs-".$counter."\">".$key."</a></li>";

    $contentlist.=" <div id=\"tabs-".$counter."\">".$value."</div>";

    $counter++;
}

$tablist="<div id=\"tabs\"><ul>$tablist</ul><div style=\"padding:10px;\">$contentlist</div></div>";

    $page_contents="{$message}<form action=\"$htmladmin/?do={$do}&action=edit&id={$id}\" method=\"post\" name=\"pageList\" enctype=\"multipart/form-data\">
        $tablist
        <input type=\"hidden\" name=\"action\" value=\"edit\" id=\"action\">
        <input type=\"hidden\" name=\"do\" value=\"{$do}\">
        <input type=\"hidden\" name=\"id\" value=\"$id\">
        <input type=\"hidden\" name=\"payer_id\" value=\"$payer_id\">
    </form>";

require "resultPage.php";
echo $result_page;
exit();

}

?>
