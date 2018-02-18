<?php


/* ==| UPDATE PAYMENT REQUEST DETAILS ==================================================== */

$up_payment_data = array();
$up_payment_data['comments'] = $comments;

$obj_payment->updateDetails($up_payment_data);

/* ==| UPDATE PAYMENT REQUEST TRANSACTION DETAILS ==================================================== */

$up_payment_txn_data = array();
$up_payment_txn_data['pmt_account_id'] = $payment_method;

$obj_payment->updateTxnDetails($up_payment_txn_data);

$obj_payment->makePayment( $payment_method );


?>