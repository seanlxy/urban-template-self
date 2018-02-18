<?php

############################################################################################################################
## New FAQ Item
############################################################################################################################

function new_item()
{
	global $message,$id,$pages_maximum, $do, $htmladmin, $htmlroot, $js_vars,
    $disable_menu, $valid, $obj_payment, $main_heading, $obj_form_validation;

    $disable_menu = "true";
    $valid        = 1;

    $main_heading = 'Payments - New Request';

    $validation_rules = array();
    $form_is_valid = false;


    ##--------------  IF FORM IS POSTED  ----------------------------------------------------------------------------------------

    if( !empty($_POST['send-request']) )
    {
        $payment_id = $obj_payment->create($_POST);

        if( $payment_id !== false )
        {

            $_SESSION['flash_msg'] = $obj_payment::getMsg($obj_payment::MSG_SENT_ID);

            header("Location: {$htmladmin}/?do={$do}");
            exit();

        }

    }
    elseif( !empty($_POST['show-preview']) )
    {

        $reference         = sanitize_input('reference');
        $first_name        = sanitize_input('first_name');
        $last_name         = sanitize_input('last_name');
        $email_address     = sanitize_input('email_address', FILTER_VALIDATE_EMAIL);
        $amount            = sanitize_input('amount', FILTER_VALIDATE_FLOAT);
        $email_template_id = sanitize_input('email_template_id', FILTER_VALIDATE_INT);
        $payment_type      = sanitize_input('payment_type');

        $obj_form_validation->setRule('reference', 'Reference', 'trim|required');
        $obj_form_validation->setRule('first_name', 'First Name', 'trim|required');
        $obj_form_validation->setRule('last_name', 'Last Name', 'trim|required');
        $obj_form_validation->setRule('email_address', 'Email address', 'trim|required|email');
        $obj_form_validation->setRule('amount', 'Payment amount', 'trim|required|float|min[1]');
        $obj_form_validation->setRule('email_template_id', 'Template', 'trim|required|integer');

        $form_is_valid = $obj_form_validation->validate();

        $reference_error         = $obj_form_validation->getError('reference');
        $first_name_error        = $obj_form_validation->getError('first_name');
        $last_name_error         = $obj_form_validation->getError('last_name');
        $email_address_error     = $obj_form_validation->getError('email_address');
        $amount_error            = $obj_form_validation->getError('amount');
        $email_template_id_error = $obj_form_validation->getError('email_template_id');

    }
    else
    {
        $reference         = '';
        $first_name        = '';
        $last_name         = '';
        $email_address     = '';
        $amount            = '';
        $email_template_id = '';


        $reference_error         = '';
        $first_name_error        = '';
        $last_name_error         = '';
        $email_address_error     = '';
        $amount_error            = '';
        $email_template_id_error = '';

    }

    ##------------------------------------------------------------------------------------------------------
    ## Page functions

 
    
   
    if( !empty($_POST['send-request']) )
    {

    }
    elseif( $_POST['show-preview'] == '1' && $form_is_valid === true )
    {


        $email_template_details = $obj_payment->getTemplateDetails($email_template_id);
        
        $email_template_content = ($email_template_details['content']);

        // $tmpl_tags = array();
        // $tmpl_tags['full_name']      = trim("{$first_name} {$last_name}");
        // $tmpl_tags['payment_amount'] = $amount;
        // $tmpl_tags['payment_link']   = "{$htmlroot}/payments/?pid=XXXXXXXXXXXXXXX";

        // 

        // foreach ($tmpl_tags as $key => $value)
        // {
        //     $email_template_content = str_replace('{'.$key.'}', $value, $email_template_content);
        // }

        
        $settings_content = <<< HTML
            <table width="100%" border="0" cellspacing="0" cellpadding="8">

                <tr>
                    <td width="100" valign="top"><strong>Template:</strong></td>
                    <td>
                        {$email_template_details['name']}
                    </td>
                </tr>
                <tr>
                    <td width="100" valign="top"><label for="subject">Subject:</label></td>
                    <td>
                        <input name="subject" type="text" id="subject" value="{$email_template_details['subject']}" style="width:100%;" />
                    </td>
                </tr>
                <tr>
                    <td width="100" valign="top"><label for="content">Content:</label></td>
                    <td>
                        <textarea name="content" id="tmpl-content">{$email_template_content}</textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input name="reference" type="hidden" id="reference" value="{$reference}" />
                        <input name="first_name" type="hidden" id="first_name" value="{$first_name}" />
                        <input name="last_name" type="hidden" id="last_name" value="{$last_name}" />
                        <input name="email_address" type="hidden" id="email_address" value="{$email_address}" />
                        <input name="amount" type="hidden" id="amount" value="{$amount}" />
                        <input name="email_template_id" type="hidden" id="email_template_id" value="{$email_template_id}" />
                        <input name="payment_type" type="hidden" id="payment_type" value="{$payment_type}" />
                        <input name="send-request" type="hidden" id="send-request" value="1" />
                    </td>
                </tr>
            </table>
           <script>
                CKEDITOR.replace( 'tmpl-content',
                {
                    toolbar : 'MyToolbar',
                    forcePasteAsPlainText : true,
                    resize_enabled : false,
                    height : 600,
                    extraPlugins:'tags',
                    filebrowserBrowseUrl : jsVars.dataManagerUrl
                });               
            </script>

HTML;

           $page_functions = <<< HTML

           <ul class="page-action">
                <li>
                    <button type="button" class="btn btn-default" onclick="submitForm('new', 1)"><i class="glyphicon glyphicon-envelope"></i> Send Request</button>
                </li>
                <li>
                    <a class="btn btn-default" href="{$htmladmin}/?do={$do}&action=new"><i class="glyphicon glyphicon-arrow-left"></i> Back</a>
                </li>
            </ul>
HTML;


    }
    else
    {

        $templates = $obj_payment->getTemplates();

        $templates_list_view = '';

        $currency_symbol = PaymentConstants::DEFAULT_CURRENCY_SYMBOL;

        if( !empty($templates) )
        {
            $templates_list_view .= '<select name="email_template_id" id="email_template_id" style="width:250px;">';

            $templates_list_view .= '<option value="">-- select --</option>';
            
            foreach ($templates as $email_template)
            {
                $templates_list_view .= '<option value="'.$email_template['id'].'"'.(($email_template_id == $email_template['id']) ? ' selected' : '').'>'.$email_template['name'].'</option>';
            }

            $templates_list_view .= '</select>';
        }
        

        $settings_content = <<< HTML
            <table width="100%" border="0" cellspacing="0" cellpadding="8">
                <tr>
                    <td width="100" valign="top"><label for="reference">Reference:</label></td>
                    <td>
                        <input name="reference" type="text" id="reference" value="{$reference}" style="width:250px;" />
                        <span class="text-danger"><i class="fa fa-asterisk"></i></span>
                        {$reference_error}
                    </td>
                </tr>
                <tr>
                    <td width="100" valign="top"><label for="first_name">First Name:</label></td>
                    <td>
                        <input name="first_name" type="text" id="first_name" value="{$first_name}" style="width:250px;" />
                        <span class="text-danger"><i class="fa fa-asterisk"></i></span>
                        {$first_name_error}
                    </td>
                </tr>
                <tr>
                    <td width="100" valign="top"><label for="last_name">Last Name:</label></td>
                    <td>
                        <input name="last_name" type="text" id="last_name" value="{$last_name}" style="width:250px;" />
                        <span class="text-danger"><i class="fa fa-asterisk"></i></span>
                        {$last_name_error}
                    </td>
                </tr>
                <tr>
                    <td width="100" valign="top"><label for="email_address">Email Address:</label></td>
                    <td>
                        <input name="email_address" type="email" id="email_address" value="{$email_address}" style="width:250px;" />
                        <span class="text-danger"><i class="fa fa-asterisk"></i></span>
                        {$email_address_error}
                    </td>
                </tr>
                <tr>
                    <td width="100" valign="top"><label for="amount">Amount:</label></td>
                    <td>
                        {$currency_symbol} 
                        <input name="amount" type="text" id="amount" value="{$amount}" style="width:80px;" min="1" />
                        <span class="text-danger"><i class="fa fa-asterisk"></i></span>
                        {$amount_error}
                    </td>
                </tr>
                <tr>
                    <td width="100" valign="top"><label for="email_address">Payment Type:</label></td>
                    <td>
                        <label>
                            <input type="radio" name="payment_type" value="0" checked>
                            Full Payment
                        </label>
                        <label>
                            <input type="radio" name="payment_type" value="1">
                            Pre Auth Payment
                        </label>
                    </td>
                </tr>
                <tr>
                    <td width="100" valign="top"><label for="email_template_id">Template:</label></td>
                    <td>
                        {$templates_list_view} 
                        <span class="text-danger"><i class="fa fa-asterisk"></i></span>
                        {$email_template_id_error}
                    </td>
                    <input type="hidden" name="show-preview" value="1">
                </tr>
            </table>

HTML;

        
        $page_functions = <<< H

        
        <ul class="page-action">
            <li>
                <button type="button" class="btn btn-default" onclick="submitForm('new', 1)"><i class="glyphicon glyphicon-plus-sign"></i> Create</button>
            </li>
            <li>
                <a class="btn btn-default" href="{$htmladmin}/?do={$do}"><i class="glyphicon glyphicon-arrow-left"></i> Cancel</a>
            </li>
        </ul>

H;


    }








##------------------------------------------------------------------------------------------------------
## tab arrays and build tabs

$temp_array_menutab = array();

$temp_array_menutab['Details'] = $settings_content;

$counter     = 0;
$tablist     = "";
$contentlist = "";

foreach($temp_array_menutab as $key => $value)
{

    $tablist.= "<li><a href=\"#tabs-".$counter."\">".$key."</a></li>";

    $contentlist.=" <div id=\"tabs-".$counter."\">".$value."</div>";

    $counter++;
}

$tablist="<div id=\"tabs\"><ul>{$tablist}</ul><div style=\"padding:10px;\">$contentlist</div></div>";

$page_contents="{$message}<form action=\"$htmladmin/?do={$do}&action=new\" method=\"post\" name=\"pageList\" enctype=\"multipart/form-data\">
    {$tablist}
</form>";

require "resultPage.php";
echo $result_page;
exit();

        
}

?>