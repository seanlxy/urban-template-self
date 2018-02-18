<?php

if( $payment_data['pmt_account_type'] == Payment::ACCOUNT_TYPE_2 )
{
	
	$request_key = $_GET['tx'];
	$paymentIsSuccessfull = $obj_payment->handlePayPalResponse($request_key);
}
else
{
	$request_key = $_GET['result'];

	$paymentIsSuccessfull = $obj_payment->handleDPSResponse($request_key);
}


$response_type = ($paymentIsSuccessfull) ? 'success' : 'error';

header("Location: {$htmlroot}/payments/?pid={$payment_data['public_token']}&{$response_type}=1");
exit();

?>