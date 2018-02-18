<?php


function config()
{
	global $message, $id, $htmladmin, $do, $obj_payment,
		$disable_menu, $valid, $main_heading, $js_vars;


	$disable_menu      = "true";
	$valid             = 1;
	$pr_templates_view = '';

    $main_heading = "Payment Requests - Configurations";
	

	if( filter_input(INPUT_POST, 'update-accounts', FILTER_VALIDATE_INT) === 1 )
	{
		// SAVE SETTINGS
        $notification_email_address = filter_input(INPUT_POST, 'notification_email_address');
        $terms_and_conditions       = filter_input(INPUT_POST, 'terms_and_conditions');
        $success_message            = filter_input(INPUT_POST, 'success_message');
        $fail_message               = filter_input(INPUT_POST, 'fail_message');
        $success_email_body         = filter_input(INPUT_POST, 'success_email_body');
        $fail_email_body            = filter_input(INPUT_POST, 'fail_email_body');
        $processed_message          = filter_input(INPUT_POST, 'processed_message');
        $payment_type               = filter_input(INPUT_POST, 'payment_type');

		$settings_data = array();

        $settings_data['notification_email_address'] = $notification_email_address;
        $settings_data['terms_and_conditions']       = $terms_and_conditions;
        $settings_data['success_message']            = $success_message;
        $settings_data['fail_message']               = $fail_message;
        $settings_data['success_email_body']         = $success_email_body;
        $settings_data['fail_email_body']            = $fail_email_body;
        $settings_data['processed_message']          = $processed_message;
        $settings_data['payment_type']               = ($payment_type == 1) ? 'P' : 'F';


		update_row($settings_data, 'pmt_settings', "WHERE `id` = '1' LIMIT 1");
		

		// SAVE ACCOUNTS
		$account_users         = $_POST['account-user'];
		$account_keys          = $_POST['account-key'];
		$accounts_credit_cards = $_POST['account-cc'];


		if( !empty($account_users) )
		{

			$acc_query           = '';
			$acc_cc_query        = '';
			$acc_cc_delete_query = '';

			foreach ($account_users as $account_id => $account_user)
			{
				$acc_query .= ",('{$account_id}','{$account_user}','{$account_keys[$account_id]}')";

				$account_credit_cards = $accounts_credit_cards[$account_id];

				$acc_cc_delete_query .= ",{$account_id}";


				if( !empty($account_credit_cards) )
				{

					$acc_cc_query .= ",({$account_id},".implode("),({$account_id},", $account_credit_cards).")";

				}
				
			}



		
			if( !empty($acc_query) )
			{

				$acc_query           = ltrim($acc_query, ',');
				$acc_cc_delete_query = ltrim($acc_cc_delete_query, ',');
				$acc_cc_query        = ltrim($acc_cc_query, ',');


				run_query("INSERT INTO `pmt_account`(`id`, `user`, `api_key`) VALUES {$acc_query} ON DUPLICATE KEY UPDATE `user` = VALUES(`user`), `api_key` = VALUES(`api_key`)");

				
				if( !empty($acc_cc_delete_query) )
				{
					run_query("DELETE FROM `pmt_account_has_pmt_credit_card` WHERE `pmt_account_id` IN({$acc_cc_delete_query})");
				}

				if( !empty($acc_cc_query) )
				{
					run_query("INSERT INTO `pmt_account_has_pmt_credit_card`(`pmt_account_id`, `pmt_credit_card_id`) VALUES {$acc_cc_query}");
				}
				

			}

		}


		$_SESSION['flash_msg'] = 'Changes has been saved successfully.';
		header("Location: {$htmladmin}?do={$do}&action=config");
		exit();

	}
    else
    {
        
    	$payment_accounts = $obj_payment->getAllAccounts();

		$payment_credit_cards  = $obj_payment->getCreditCards();

		$accounts_credit_cards = $obj_payment->getAccountCreditCards();


    	if( !empty($payment_accounts) )
    	{

    		foreach($payment_accounts as $i => $payment_account)
    		{
				$payment_account_id      = $payment_account['id'];
				$payment_account_is_test = ($payment_account['is_live'] === Payment::FLAG_YES) ? '<span class="label label-success" style="vertical-align:middle;margin:-5px 0 0 7px;">LIVE</span>' : '<span style="vertical-align:middle;margin:-5px 0 0 7px;" class="label label-default">TEST</span>';


				// CREDIT CARDS VIEW
				$cc_view = '';

				if( $payment_account['has_cc'] === Payment::FLAG_YES  )
				{

					foreach ($payment_credit_cards as $credit_card)
					{

						$credit_card_id = $credit_card['id'];

						$is_checked = !empty( $accounts_credit_cards[$payment_account_id][$credit_card_id] );

						$cc_view .= '<label class="checkbox-inline">
							<input style="margin-top:1px;" type="checkbox" name="account-cc['.$payment_account_id.'][]" value="'.$credit_card_id.'"'.(($is_checked) ? ' checked' : '').'> 
						'.$credit_card['name'].'</label>';

					}


					$cc_view = ' <tr>
	                    <td width="90" valign="top"><strong>Credit Cards:</strong></td>
	                    <td>
	                        '.$cc_view.'
	                    </td>
	                </tr>';
					
				}



				$hr = ( $i != 0 ) ? '<tr>
                    <td colspan="2" valign="top">
                    	<hr style="border-color:#000;">
                	</td>
                </tr>' : '';

    			$pr_templates_view .= $hr.'<tr>
                    <td colspan="2" valign="top">
                    	<strong style="font-size:17px;">'.$payment_account['label'].'</strong> '.$payment_account_is_test.'
                	</td>
                </tr>
                <tr>
                    <td width="90" valign="top"><label for="account-user-'.$i.'">User:</label></td>
                    <td>
                        <input name="account-user['.$payment_account_id.']" type="text" id="account-user-'.$i.'" value="'.$payment_account['user'].'" style="width:300px;" autocomplete="off" />
                    </td>
                </tr>
                <tr>
                    <td width="90" valign="top"><label for="account-key-'.$i.'">API Key:</label></td>
                    <td>
                        <input name="account-key['.$payment_account_id.']" type="text" id="account-key-'.$i.'" value="'.$payment_account['api_key'].'" style="width:650px;" autocomplete="off" />
                    </td>
                </tr>'.$cc_view;


    		}


    		$pr_templates_view = '<div>
				<table width="100%" border="0" cellspacing="0" cellpadding="5">
				'.$pr_templates_view.'
				</table>
				<input type="hidden" name="update-accounts" value="1">
			</div>';

    	}


    	// GENERAL SETTINGS TAB

    	$settings = $obj_payment->settings;

    	$js_vars['ckTags'] = array(

            array(
            	'label' => 'Full name',
            	'tag' => 'full_name'
            ),
            array(
                'label' => 'Email address',
                'tag' => 'email_address'
            ),
            array(
            	'label' => 'Request date',
            	'tag' => 'request_date'
            ),
            array(
            	'label' => 'Request from',
            	'tag' => 'from_name'
            ),
            array(
            	'label' => 'Amount to pay',
            	'tag' => 'amount'
            ),
            array(
            	'label' => 'Payment date',
            	'tag' => 'payment_date'
            ),
            array(
                'label' => 'Payment URL',
                'tag' => 'payment_url'
            ),
            array(
            	'label' => 'Payment response text',
            	'tag' => 'response_text'
            ),
             array(
                'label' => 'Currency Symbol',
                'tag' => 'currency_symbol'
            ),

        );

        $fullptm_checked = ($settings['payment_type'] === 'F') ? ' checked="checked"' : ''; 
        $preptm_checked = ($settings['payment_type'] === 'P') ? ' checked="checked"' : ''; 
    	$settings_content = <<< H

		<div>
			<table width="100%" border="0" cellspacing="0" cellpadding="8">
				<tr>
                    <td>
                    	<label for="notification_email_address">Notification Email Address:</label> <span data-title="Separate multiple email addresses with a semicolon ( ; )" data-placement="right" data-toggle="tooltip"></span><br>
                        <input name="notification_email_address" type="text" id="notification_email_address" value="{$settings['notification_email_address']}" style="width:300px;" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label style="text-align:center">
                            <input type="radio" name="payment_type" value="0" $fullptm_checked>
                            Full Payment
                        </label>
                        &nbsp;
                        <label style="text-align:center">
                            <input type="radio" name="payment_type" value="1" $preptm_checked>
                            Pre Auth Payment
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>
                    	<label for="terms_and_conditions">Terms & Conditions:</label><br>
                        <textarea name="terms_and_conditions" id="terms_and_conditions">{$settings['terms_and_conditions']}</textarea>
                    </td>
                </tr>
			</table>
			<script>
                CKEDITOR.replace( 'terms_and_conditions',
                {
                    toolbar : 'MyToolbar',
                    forcePasteAsPlainText : true,
                    resize_enabled : false,
                    height : 600,
                    extraPlugins:'tags',
                    filebrowserBrowseUrl : jsVars.dataManagerUrl
                });               
            </script>
		</div>

H;


	$success_message_content = <<< H
		<textarea name="success_message" id="success_message">{$settings['success_message']}</textarea>
		<script>
            CKEDITOR.replace( 'success_message',
            {
                toolbar : 'MyToolbar',
                forcePasteAsPlainText : true,
                resize_enabled : false,
                height : 600,
                extraPlugins:'tags',
                filebrowserBrowseUrl : jsVars.dataManagerUrl
            });               
        </script>

H;


	$fail_message_content = <<< H
		<textarea name="fail_message" id="fail_message">{$settings['fail_message']}</textarea>
		<script>
            CKEDITOR.replace( 'fail_message',
            {
                toolbar : 'MyToolbar',
                forcePasteAsPlainText : true,
                resize_enabled : false,
                height : 600,
                extraPlugins:'tags',
                filebrowserBrowseUrl : jsVars.dataManagerUrl
            });
        </script>

H;

	$success_email_body_content = <<< H
		<textarea name="success_email_body" id="success_email_body">{$settings['success_email_body']}</textarea>
		<script>
            CKEDITOR.replace( 'success_email_body',
            {
                toolbar : 'MyToolbar',
                forcePasteAsPlainText : true,
                resize_enabled : false,
                height : 600,
                extraPlugins:'tags',
                filebrowserBrowseUrl : jsVars.dataManagerUrl
            });
        </script>

H;

	$fail_email_body_content = <<< H
		<textarea name="fail_email_body" id="fail_email_body">{$settings['fail_email_body']}</textarea>
		<script>
            CKEDITOR.replace( 'fail_email_body',
            {
                toolbar : 'MyToolbar',
                forcePasteAsPlainText : true,
                resize_enabled : false,
                height : 600,
                extraPlugins:'tags',
                filebrowserBrowseUrl : jsVars.dataManagerUrl
            });
        </script>

H;


	$processed_message_content = <<< H
		<textarea name="processed_message" id="processed_message">{$settings['processed_message']}</textarea>
		<script>
            CKEDITOR.replace( 'processed_message',
            {
                toolbar : 'MyToolbar',
                forcePasteAsPlainText : true,
                resize_enabled : false,
                height : 600,
                filebrowserBrowseUrl : jsVars.dataManagerUrl
            });
        </script>

H;

    	$page_functions = <<< HTML

           <ul class="page-action">
                <li><button type="button" class="btn btn-default" onclick="submitForm('update-accounts', 1)"><i class="glyphicon glyphicon-floppy-save"></i> Update</button></li>
                <li><a class="btn btn-default" href="{$htmladmin}/?do={$do}"><i class="glyphicon glyphicon-arrow-left"></i> Back</a></li>
            </ul>
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


	##------------------------------------------------------------------------------------------------------
	## tab arrays and build tabs

	$temp_array_menutab = array();

	$temp_array_menutab['Accounts']                  = $pr_templates_view;
	$temp_array_menutab['General']                   = $settings_content;
	$temp_array_menutab['Success Message']           = $success_message_content;
	$temp_array_menutab['Fail Message']              = $fail_message_content;
	$temp_array_menutab['Success Email Body']        = $success_email_body_content;
	$temp_array_menutab['Fail Email Body']           = $fail_email_body_content;
	$temp_array_menutab['Processed Payment Message'] = $processed_message_content;


	$counter = 0;
	$tablist ="";
	$contentlist="";

	foreach($temp_array_menutab as $key => $value)
	{

	    $tablist.= "<li><a href=\"#tabs-".$counter."\">".$key."</a></li>";

	    $contentlist.=" <div id=\"tabs-".$counter."\">".$value."</div>";

	    $counter++;
	}

	$tablist="<div id=\"tabs\"><ul>$tablist</ul><div >{$contentlist}</div></div>";

    $page_contents.="<form action=\"$htmladmin/?do={$do}&action=config\" method=\"post\" name=\"pageList\" enctype=\"multipart/form-data\">
        {$tablist}
    </form>";

	require "resultPage.php";
	echo $result_page;
	exit();
}

?>