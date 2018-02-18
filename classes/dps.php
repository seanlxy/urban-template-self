<?php

require_once 'PxPay_Curl.inc.php';

class DPS extends PxPay_Curl
{
	
	private $requestUri;

	private $currencySettlement;

	private $txnType;


	const PXPAY_URL = 'https://sec.paymentexpress.com/pxpay/pxaccess.aspx';


	public function __construct( $settings )
	{

		parent::__construct( self::PXPAY_URL, $settings['user'], $settings['api_key'] );

		$this->requestUri         = $settings['request_url'];
		$this->currencySettlement = $settings['currency_settlement'];
		$this->txnType            = $settings['payment_type'];

	}


	public function makePaymentRequest($extraData, $amount)
	{

		$objRequest = new PxPayRequest();

		# the following variables are read from the form
		$MerchantReference = uniqid('PMT-');

		#Generate a unique identifier for the transaction
		$TxnId = uniqid();
	
		#Set PxPay properties
		$objRequest->setMerchantReference($MerchantReference);
		$objRequest->setAmountInput($amount);
		$objRequest->setTxnData1($extraData);
		($this->txnType === 'P') ? $objRequest->setTxnType('Auth') : $objRequest->setTxnType('Purchase');
		$objRequest->setCurrencyInput($this->currencySettlement);
		$objRequest->setUrlFail($this->requestUri);	    # can be a dedicated failure page
		$objRequest->setUrlSuccess($this->requestUri);  # can be a dedicated success page
		$objRequest->setTxnId($TxnId);


		#The following properties are not used in this case
		$objRequest->setEnableAddBillCard(1);  # Token Billing

		#Call makeRequest function to obtain input XML
		$strRequest = $this->makeRequest($objRequest);

		#Obtain output XML
		$response = new MifMessage($strRequest);


		#Parse output XML
		$redirectUrl = $response->get_element_text('URI');
		$isValid     = (bool) $response->get_attribute('valid');


		if( $isValid === true )
		{

			#Redirect to payment page
			header("Location: ".$redirectUrl);
			exit();

		}
		
		return false;

	}

}

?>