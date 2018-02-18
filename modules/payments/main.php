<?php
$payments_view = '';

require_once 'inc/vars.php';

if( !empty($process_payment) && $form_is_valid === true && !$captcha_error )
{
	require_once 'inc/process_payment.php';
}
elseif( !empty($_GET['result']) || !empty($_GET['tx']) )
{
	require_once 'inc/handle_result.php';
}
elseif( $_GET['success'] == '1' )
{
	require_once 'views/success.php';
}
elseif( $_GET['error'] == '1' )
{
	require_once 'views/error.php';
}
else
{

	if( $payment_data['status'] != Payment::FLAG_APPROVED && $payment_data['status'] != Payment::FLAG_CANCELED  )
	{
		require_once 'views/form.php';
	}
	else
	{
		require_once 'views/payment_processed.php';
	}
}


$tags_arr['mod_view'] .= $payments_view;

?>