<?php

$payment_accounts_view    = '';
$payment_accounts_cc_view = '';
$g_recaptcha_site_key = GC_SITE_KEY;
if( !empty($payment_accounts) )
{
	foreach ($payment_accounts as $i => $payment_account)
	{

		$payment_method_id  = $payment_account['id'];

		$payment_account_cc = $payment_accounts_ccs[$payment_method_id];

		$cc_wrapper_id = "cc-{$i}";

		$is_checked = ( $payment_method == $payment_method_id ) ? ' checked' : (( empty($payment_method) && $i == 0 ) ? ' checked' : '');

		$payment_accounts_view .= '<label title="'.$payment_account['label'].'" class="icon-radio">
			<input type="radio" name="payment-method" value="'.$payment_method_id.'"'.$is_checked.' data-target="#'.$cc_wrapper_id.'">
			<span><img src="'.$payment_account['logo_path'].'" alt="'.$payment_account['label'].'"></span>
		</label>';


		if( !empty($payment_account_cc) )
		{
			$payment_accounts_cc_view .= '<div id="'.$cc_wrapper_id.'" class="icon-grp'.(($i > 0) ? ' hidden' : '').'">';

			foreach ($payment_account_cc as $acc_cc)
			{
				$payment_accounts_cc_view .= '<span class="icon-grp--icon" title="'.$acc_cc['name'].'" style="background-image:url('.$acc_cc['image_path'].');"></span>';
			}

			$payment_accounts_cc_view .= '</div>';

		}


	}
}

$comments = ( !empty($comments) ) ? $comments : $payment_data['comments'];

$currency_symbol = PaymentConstants::DEFAULT_CURRENCY_SYMBOL;

$payments_view = <<< H

<style>

	.form-control {
	    display: block;
	    width: 100%;
	    height: 34px;
	    padding: 6px 12px;
	    font-size: 14px;
	    line-height: 1.42857143;
	    color: #0a2f4d;
	    border: 1px solid #ccc;
	    background-color: #fff;
	    background-image: none;
	}

	#payment-form {
		background: #F5F5F5;
		max-width: 600px;
		margin: 0 auto;
		border-radius: 5px;
	}

	#payment-form .input-lg {
		font-size: 20px;
		font-weight: 700;
	}

	.payment-form__header {
        background: #545453;
        padding: 15px;
        color: #fff;
        text-transform: uppercase;
        font-weight: 700;
        position: static;
        margin-bottom: 15px;
	}

	.payment-form__header__heading {
		margin: 0;
		color: #fff;
	}

	#payment-form .form-control-static{
		margin: 0;
		padding: 0;
	}
    
    #payment-form .form-group {
        padding: 0 15px;
    }
    
	.icon-radio{
		display: inline-block;
		position: relative;
		cursor: pointer;
		margin-top: 10px;
	}

	.icon-radio span{
		display: inline-block;
		background: #fff;
		padding: 10px 20px;
		-webkit-border-radius: 5px;
		border-radius: 5px;
		vertical-align: middle;
		border: .1em solid #d3d3d3;
	    background: #fff;
	    background: -moz-linear-gradient(top,#fff 0,#fdfdfd 52%,#ededed 99%,#dedede 100%);
	    background: -webkit-gradient(linear,left top,left bottom,color-stop(0%,#fff),color-stop(52%,#fdfdfd),color-stop(99%,#ededed),color-stop(100%,#dedede));
	    background: -webkit-linear-gradient(top,#fff 0,#fdfdfd 52%,#ededed 99%,#dedede 100%);
	    background: -o-linear-gradient(top,#fff 0,#fdfdfd 52%,#ededed 99%,#dedede 100%);
	    background: -ms-linear-gradient(top,#fff 0,#fdfdfd 52%,#ededed 99%,#dedede 100%);
	    background: linear-gradient(to bottom,#fff 0,#fdfdfd 52%,#ededed 99%,#dedede 100%);
	    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff',endColorstr='#dedede',GradientType=0);
	    outline: 0;
	    outline-width: 0;

	}

	.icon-radio span img{
		pointer-events: none;
	}


	.icon-radio:not(:first-child){
		margin-left: 15px;
	}

	.icon-radio input[type="radio"]{

		visibility: hidden;
		position: absolute;
	}

	.icon-radio input[type="radio"]:checked ~ span{
 	    background: #e8e8e8;
	    -webkit-box-shadow: inset 0 -1px 1px #fff,inset 0 0 3px rgba(0,0,0,0.4);
	    box-shadow: inset 0 -1px 1px #fff,inset 0 0 3px rgba(0,0,0,0.4);
	    border-color: transparent;

	}

	.icon-grp{
		margin-top: 10px;
	}

	.icon-grp--icon{
		display: inline-block;
		width: 54px;
		height: 34px;
		background-position: center;
		background-repeat: no-repeat;
		background-size: cover;
	}

	.icon-grp--icon:not(:first-child){
		margin-left: 5px;
	}

</style>

<form method="post" action="{$request_url}" id="payment-form">
	<header class="payment-form__header"><h3 class="payment-form__header__heading">Payment request</h3></header>
	<div class="form-group">
	    <div class="row">
			<label class="col-xs-12 col-sm-4 control-label">Name:</label>
		    <div class="col-xs-12 col-sm-8">
		      <p class="form-control-static">{$full_name}</p>
		    </div>
	    </div>
  	</div>
  	<div class="form-group">
	    <div class="row">
			<label class="col-xs-12 col-sm-4 control-label">Email address:</label>
		    <div class="col-xs-12 col-sm-8">
		      <p class="form-control-static">{$email_address}</p>
		    </div>
	    </div>
  	</div>
  	<div class="form-group">
	    <div class="row">
			<label class="col-xs-12 col-sm-4 control-label control-label-lg">Amount to pay:</label>
		    <div class="col-xs-12 col-sm-8">
		      <p class="form-control-static input-lg">{$currency_symbol} {$amount_formatted}</p>
		    </div>
	    </div>
  	</div>
  	<div class="form-group">
	    <div class="row">
			<label class="col-xs-12 control-label" for="comments">Comments:</label>
		    <div class="col-xs-12">
		      <textarea name="comments" id="comments" class="form-control" style="height:70px;resize: none;">{$comments}</textarea>
		    </div>
	    </div>
  	</div>
  	<div class="form-group">
	    <div class="row">
			<label class="col-xs-12 control-label">Choose your payment method:</label>
		    <div class="col-xs-12">
		      {$payment_accounts_view}
		      {$payment_method_error}
		      {$payment_accounts_cc_view}
		    </div>
	    </div>
  	</div>
	<div class="form-group">
        <div class="row">
			<div class="col-xs-12">
				<p>In order to assist us in reducing spam, please type the characters you see:</p>
                <script src='https://www.google.com/recaptcha/api.js'></script>
                <div class="g-recaptcha" data-sitekey="{$g_recaptcha_site_key}"></div>
                {$captcha_error_msg}
			</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
			<div class="col-xs-12">
				<label class="checkbox-inline">
					<input type="checkbox" name="terms-checkbox" value="1"> 
					I have read and accept the <a href="#terms" data-toggle="modal" data-target="#terms">Terms and Conditions</a>
				</label>
				{$terms_error}
			</div>
        </div>
    </div>
	<div class="form-group">
		<button type="submit" name="process-payment" value="1" class="btn btn-style-3">Continue to payment</button>
	</div>
</form>
H;


$tags_arr['mod_view'] = <<< H

<div class="modal fade" id="terms" tabindex="-1" role="dialog" aria-labelledby="modal-label">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="modal-label">Terms and Conditions</h4>
			</div>
			<div class="modal-body">
				{$payment_settings['terms_and_conditions']}
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

H;

?>