<?php

/**
* Payment
* 
* @author Talwinder Singh <talwinder@tomahawk.co.nz>
*/

require_once 'payment_constants.php';
require_once 'class_phpmailer.php';
require_once 'dps.php';
require_once 'paypal.php';

class Payment extends PaymentConstants
{

    /**
    * Sets array of module settings
    * @var array
    */
    public $settings;

    /**
    * Sets array of single payment request data
    * @var array
    */
    public $data = array();
    

    /**
    * Sets mode of module (Development/Production)
    * @var boolean
    */
    protected $productionMode;


    /**
    * Sets if there is any payment accounts
    * @var boolean
    */
    protected $hasAccounts;


    /**
    * Sets payment request public URL
    * @var string
    */
    protected $paymentURL;


    /**
    * Sets path to new payment request email template
    * @var string
    */
    protected $requestEmailTmplPath;

    /**
    * Sets path to successfull payment request client email template
    * @var string
    */
    protected $clientSuccessEmailTmplPath;

    /**
    * Sets path to failed payment request client email template
    * @var string
    */
    protected $clientFailEmailTmplPath;

    /**
    * Sets path to successfull payment request admin email template
    * @var string
    */
    protected $adminSuccessEmailTmplPath;

    /**
    * Sets path to failed payment request admin email template
    * @var string
    */
    protected $adminFailEmailTmplPath;

    /**
    * Sets DPS object
    * @var object
    */
    protected $dps;

    /**
    * Sets PayPal object
    * @var object
    */
    protected $paypal;

    /**
    * Sets extra email template tags
    * @var array
    */
    protected $emailTmplData = array();


    /**
    * 
    * Constructor method of class
    *
    * @param array $config, Description - Array of default/Global configration required for this class
    * @param integer $paymentId, Description - Payment is required when working with single payment otherwise it's not required
    * @return void
    */

    public function __construct( $config, $paymentId = null )
    {
        $this->setConfig($config);

        $this->settings = self::getSettings();

        if( !empty($paymentId) )
        {

            $this->data = $this->getDetails($paymentId);
        }
    }

    /**
    * 
    * Create new payer record
    * Create new payment request
    * Create new payment transaction record
    * Send request email to payer
    *
    * @param array $data, Description - Array of payment related data
    * @return integer/boolean
    */
    public function create($data)
    {
        if( !empty($data) )
        {
            $subject         = $data['subject'];
            $templateContent = $data['content'];
            $reference       = $data['reference'];
            $firstName       = $data['first_name'];
            $lastName        = $data['last_name'];
            $fullName        = trim("{$firstName} {$lastName}");
            $emailAddress    = $data['email_address'];
            $amount          = $data['amount'];
            $emailTemplateId = $data['email_template_id'];
            $requestToken    = self::createUniqueId();
            $requestUrl      = "{$this->paymentURL}/?pid={$requestToken}";
            $payment_type    = ($data['payment_type'] == 1) ? 'P' : 'F';


            $templateBodyTags = array();

            $templateBodyTags['full_name']      = $fullName;
            $templateBodyTags['first_name']     = $firstName;
            $templateBodyTags['last_name']      = $lastName;
            $templateBodyTags['payment_amount'] = $amount;
            $templateBodyTags['payment_link']   = '<a href="'.$requestUrl.'" target="_blank">'.$requestUrl.'</a>';
            $templateBodyTags['currency_symbol'] = PaymentConstants::DEFAULT_CURRENCY_SYMBOL;


            if( !empty($templateBodyTags) )
            {
                $validTags = $this->getTemplateTagKeys();

                foreach ( $templateBodyTags as $key => $value )
                {
                    if( in_array($key, $validTags) )
                    {
                        $templateContent = str_replace('{'.$key.'}', $value, $templateContent);
                    }
                }

            }

            
            /* ==| CREATE NEW PAYER RECORD ==================================================== */

            $payerData = array();

            $payerData['first_name']    = $firstName;
            $payerData['last_name']     = $lastName;
            $payerData['full_name']     = $fullName;
            $payerData['email_address'] = $emailAddress;

            $payerId = insert_row($payerData, 'pmt_payer');

            if( !empty($payerId) )
            {

                $transactionId = insert_row(array('amount_settlement' => $amount), 'pmt_transaction');

                $payment_data                       = array();
                $payment_data['public_token']       = $requestToken;
                $payment_data['amount']             = $amount;
                $payment_data['status']             = self::FLAG_PENDING;
                $payment_data['reference']          = $reference;
                $payment_data['request_url']        = $requestUrl;
                $payment_data['email_sent']         = self::FLAG_NO;
                $payment_data['email_subject']      = $subject;
                $payment_data['email_content']      = $templateContent;
                $payment_data['created_on']         = self::getCurrentDateTime();
                $payment_data['pmt_payer_id']       = $payerId;
                $payment_data['email_template_id']  = $emailTemplateId;
                $payment_data['pmt_transaction_id'] = $transactionId;
                $payment_data['payment_type']       = $payment_type;

                $paymentRequestId = insert_row($payment_data, 'pmt_request');

                if( !empty($paymentRequestId) )
                {

                    self::logHistory( self::HISTORY_NEW_ID, $paymentRequestId );

                    $this->data = $this->getDetails($paymentRequestId);

                    /* ==| SENT REQUEST EMAIL TO CLIENT ==================================================== */
                    $this->sendRequestEmail();

                    return $paymentRequestId;

                }
            
            }
        }

        return false;
    }

    /**
    * 
    * Create email template tags
    * Compile email template
    * Buid and send email request
    * Log history if email is sent successfully
    *
    * @return boolean
    */

    public function sendRequestEmail()
    {
        
        $paymentDetails = $this->data;

        if( !empty($paymentDetails) )
        {

            $paymentRequestId = $paymentDetails['id'];

            /* ==| SEND EMAIL TO CLIENT ==================================================== */

            $templateDetails                     = self::getTemplateDetails($paymentDetails['email_template_id']);
            
            $templateTags = array();
            
            $templateTags['email_body'] = $paymentDetails['email_content'];
            $templateTags['subject']    = $paymentDetails['email_subject'];
            
            $templateTags               = array_merge($this->emailTmplData, $templateTags);

            $compiledTemplate = self::processTemplate($this->requestEmailTmplPath, $templateTags);

            $templateDetails['subject']          = $paymentDetails['email_subject'];
            $templateDetails['email_body']       = $compiledTemplate;
            $templateDetails['to_email_address'] = $paymentDetails['email_address'];
            if(empty($templateDetails['from_email_address'])) {
                $templateDetails['from_email_address'] = $this->settings['notification_email_address'];
            }


            if( !empty($templateDetails) )
            {

                $emailIsSent = self::sendEmail($templateDetails);

                if( $emailIsSent )
                {
                    self::logHistory( self::HISTORY_SENT_ID, $paymentRequestId );
                }

                return $emailIsSent;
            }

        }

        return false;
    }

    /**
    * 
    * Get payment details
    * If payment details not empty append payment histroy
    *
    * @param mixed $paymentToken, Description - Payment id or public token
    * @return array
    */
    private function getDetails( $paymentToken )
    {
        if( !empty($paymentToken) )
        {

            $paymentDetails = fetch_row("SELECT pr.`id`, pr.`public_token`, pr.`amount`, pr.`status`, pr.`reference`, pr.`request_url`,
                pr.`email_template_id`, pr.`email_sent`, pr.`email_subject`, pr.`email_content`, pr.`created_on`, pr.`approved_on`,
                pr.`declined_on`, pr.`pmt_payer_id`, pr.`pmt_transaction_id`, pp.`first_name`, pp.`last_name`, pp.`full_name`,
                pp.`email_address`, pt.`amount_settlement`, pt.`auth_code`, pt.`dps_billing_id`, pt.`dps_ref`, pt.`currency_settlement`,
                pt.`txn_id`, pt.`currency_input`, pt.`merchant_ref`, pt.`response_text`, pt.`response_url`, pt.`date_processsed`,
                pr.`comments`, pt.`pmt_account_id`, pa.`user` AS pmt_account_user, pa.`api_key` AS pmt_account_api_key,
                pa.`type` AS pmt_account_type, pt.`paypal_payer_id`, pt.`paypal_payer_status`, pr.`payment_type`
                FROM `pmt_request` pr
                LEFT JOIN `pmt_payer` pp
                ON(pp.`id` = pr.`pmt_payer_id`)
                LEFT JOIN `pmt_transaction` pt
                ON(pt.`id` = pr.`pmt_transaction_id`)
                LEFT JOIN `pmt_account` pa
                ON(pa.`id` = pt.`pmt_account_id`)
                WHERE ".( (is_numeric($paymentToken)) ? "pr.`id` = '{$paymentToken}'" : "pr.`public_token` = '{$paymentToken}'")."
                LIMIT 1" );

            if( !empty($paymentDetails) )
            {
                $paymentDetails['history'] = $this->getHistory($paymentDetails['id']);
            }

            return $paymentDetails;

        }

        return false;
    }

    /**
    * 
    * Update payment details
    *
    * @param array $paymentData, Description - Array of new payment data
    * @return boolean
    */
    public function updateDetails( $paymentData )
    {
        $paymentId = $this->data['id'];

        if( !empty($paymentId) && !empty($paymentData) && is_array($paymentData))
        {
            update_row($paymentData, 'pmt_request', "WHERE `id` = '{$paymentId}' LIMIT 1");

            return true;
        }

        return false;
    }


    /**
    * 
    * Update payment transaction details
    *
    * @param array $paymentTxnData, Description - Array of new payment transaction data
    * @return boolean
    */
    public function updateTxnDetails( $paymentTxnData )
    {
        $paymentTxnId = $this->data['pmt_transaction_id'];

        if( !empty($paymentTxnId) && !empty($paymentTxnData) && is_array($paymentTxnData))
        {
            update_row($paymentTxnData, 'pmt_transaction', "WHERE `id` = '{$paymentTxnId}' LIMIT 1");

            return true;
        }

        return false;
    }


    /**
    * 
    * Log any action/changes happend on payment
    *
    * @param integer $statusId, Description - Id from `pmt_history_status` table
    * @param integer $requestId, Description - Payment request Id
    * @return integer/boolean
    */
    public static function logHistory( $statusId, $requestId )
    {

        if( !empty($statusId) && !empty($requestId) )
        {

            $data = self::getHistoryStatusDetails($statusId);

            $data['pmt_request_id'] = $requestId;

            $historyId = insert_row($data, 'pmt_request_history');

            return $historyId;

        }

        return false;
    }

    /**
    * 
    * Flag payment request cms status as deleted
    *
    * @param integer $paymentId, Description - payment request id
    * @return boolean
    */
    public function delete($paymentId)
    {
        return self::updateCmsStatus($paymentId, self::FLAG_DELETED);
    }

    /**
    * 
    * Flag payment request status as canceled
    *
    * @param integer $paymentId, Description - payment request id
    * @return boolean
    */
    public function cancel($paymentId)
    {
        return self::updateStatus($paymentId, self::FLAG_CANCELED);
    }

    /**
    * 
    * Flag payment request status as pending
    *
    * @param integer $paymentId, Description - payment request id
    * @return boolean
    */
    public function restore($paymentId)
    {
        return self::updateStatus($paymentId, self::FLAG_PENDING);
    }


    /**
    * 
    * Check if payment request and been processed or not
    *
    * @param string $txnId, Description - Transaction ID
    * @return boolean
    */
    public function isProcessed($txnId)
    {

        $pmt_transaction = fetch_value("SELECT `id`
            FROM `pmt_transaction`
            WHERE `txn_id` = '{$txnId}'
            LIMIT 1");
        
        return !empty($pmt_transaction);
    }

    /**
    * 
    * Get an array of al credit cards
    *
    * @return array
    */
    public function getCreditCards()
    {

        $creditCards =  fetch_all("SELECT `id`, `name`, `image_path`
            FROM `pmt_credit_card`
            WHERE 1");

        return $creditCards;
    }

    /**
    * 
    * Get an array of all credit cards based on accounts
    *
    * @param integer $accountId, Description - Payment account ID
    * @return array
    */
    public function getAccountCreditCards($accountId = '')
    {

        $creditCards = array();

        $accountId = filter_var($accountId, FILTER_VALIDATE_INT) ;

        $query =  run_query("SELECT pcc.`id`, pcc.`name`, pcc.`image_path`,
            pahpcc.`pmt_account_id`
            FROM `pmt_account_has_pmt_credit_card` pahpcc
            LEFT JOIN `pmt_credit_card` pcc
            ON(pahpcc.`pmt_credit_card_id` = pcc.`id`)
            WHERE ".((!empty($accountId)) ? "pahpcc.`pmt_account_id` = '{$accountId}'" : '1') );

        if( mysql_num_rows($query) > 1 )
        {

            while ( $creditCard = mysql_fetch_assoc($query) )
            {
                $creditCards[$creditCard['pmt_account_id']][$creditCard['id']] = $creditCard;
            }

        }

        return $creditCards;
    }


    /**
    * 
    * Get an array of all payment accounts
    *
    * @return array
    */
    public function getAllAccounts()
    { 

        $accounts =  fetch_all("SELECT `id`, `label`, `user`,
            `api_key`, `logo_path`, `is_live`, `has_cc`, `type`
            FROM `pmt_account`
            WHERE 1
            ORDER BY `is_live` DESC");

        $this->hasAccounts = !empty($accounts);

        return $accounts;
    }

    /**
    * 
    * Get an array of live/staging payment accounts
    *
    * @return array
    */
    public function getSiteAccounts()
    { 

        $accounts =  fetch_all("SELECT `id`, `label`, `user`,
            `api_key`, `logo_path`, `is_live`, `has_cc`, `type`
            FROM `pmt_account`
            WHERE `user` != '' 
            AND `api_key` != '' 
            AND `is_live` = '".((!empty($this->productionMode)) ? self::FLAG_YES : self::FLAG_NO)."'");

        $this->hasAccounts = !empty($accounts);

        return $accounts;
    }


    /**
    * 
    * Get an array of details of payment account
    *
    * @param integer $accountId, Description - Payment account ID
    * @return array
    */
    public function getAccountDetails( $accountId )
    { 
        if( empty($accountId) ) return false;

        return fetch_row("SELECT `id`, `label`, `user`,
            `api_key`, `logo_path`, `is_live`, `has_cc`, `type`
            FROM `pmt_account`
            WHERE `id` = '{$accountId}'
            LIMIT 1");
    }


    /**
    * 
    * Get an array of request email template tags keys
    *
    * @return array
    */
    public function getTemplateTagKeys()
    {
        $keys = array();

        $keys_query =  run_query("SELECT `key`
            FROM `pmt_template_tag`
            WHERE `key` != ''");

        if( mysql_num_rows($keys_query) > 1 )
        {
            while ( $key = mysql_fetch_assoc($keys_query) )
            {
                $keys[] = $key['key'];
            }
        }

        return $keys;
    }


    /**
    * 
    * Get an array of request email template tags
    *
    * @return array
    */
    public function getTemplateTags()
    {
        $tags =  fetch_all("SELECT `id`, `label`, `key`, `description`
            FROM `pmt_template_tag`
            WHERE `key` != ''");

        return $tags;
    }

    /**
    * 
    * Get an array of request email templates
    *
    * @return array
    */
    public function getTemplates()
    {
        $templates =  fetch_all("SELECT `id`, `name`, `short_description`, `from_name`,
            `from_email_address`, `subject`, `content`
            FROM `pmt_template`
            WHERE 1");

        return $templates;
    }

    /**
    * 
    * Get an array of request email template details
    *
    * @param integer templateId, Description - Email template id
    * @return array/boolean
    */
    public static function getTemplateDetails($templateId)
    {
        $templateId = filter_var($templateId, FILTER_VALIDATE_INT);

        if( !empty($templateId) )
        {
            $template_details =  fetch_row("SELECT `name`, `short_description`, `from_name`,
                `from_email_address`, `subject`, `content`,`logo_path`
                FROM `pmt_template`
                WHERE `id` = '{$templateId}'
                LIMIT 1");

            return $template_details;
        }

        return false;
    }

    /**
    * 
    * Get an array of payment request history
    *
    * @param integer paymentId, Description - Payment request id
    * @return array
    */
    private function getHistory($paymentId)
    {

        $paymentId = filter_var($paymentId, FILTER_VALIDATE_INT);

        $history =  fetch_all("SELECT `label`, `details`,
            DATE_FORMAT(`date_time`, '%d %b %Y at %h:%i %p') AS pmt_date_time
            FROM `pmt_request_history`
            WHERE `pmt_request_id` = '{$paymentId}'
            ORDER BY `date_time` ASC");

        return $history;
    }

    /**
    * 
    * Change payment request status
    *
    * @param integer paymentId, Description - Payment request id
    * @param string status, Description - Payment request status
    * @return boolean
    */
    public static function updateStatus( $paymentId, $status )
    {
        $paymentId = filter_var($paymentId, FILTER_VALIDATE_INT);

        if( !empty($paymentId) && !empty($status) )
        {
            run_query("UPDATE `pmt_request`
                SET `status` = '{$status}'
                WHERE `id` = '{$paymentId}' 
                LIMIT 1");

            return true;
        }

        return false;
    }


    /**
    * 
    * Change payment request cms status
    *
    * @param integer paymentId, Description - Payment request id
    * @param string status, Description - Payment request cms status
    * @return boolean
    */
    private static function updateCmsStatus( $paymentId, $status )
    {
        $paymentId = filter_var($paymentId, FILTER_VALIDATE_INT);

        if( !empty($paymentId) && !empty($status) )
        {
            run_query("UPDATE `pmt_request`
                SET `cms_status` = '{$status}'
                WHERE `id` = '{$paymentId}' 
                LIMIT 1");

            return true;
        }

        return false;
    }


    /**
    * 
    * Get payment history status record
    *
    * @param integer statusId, Description - Payment history status id
    * @return array/boolean
    */
    private static function getHistoryStatusDetails($statusId)
    {
        $statusId = filter_var($statusId, FILTER_VALIDATE_INT);

        if( !empty($statusId) )
        {

            return fetch_row("SELECT NOW() AS date_time, UPPER(`label`) AS label, 
                `description` AS details
                FROM `pmt_history_status`
                WHERE `id` = '{$statusId}'
                LIMIT 1");

        }

        return false;
    }

    /**
    * 
    * Get action message record
    *
    * @param integer messageId, Description - Payment message id
    * @return array/boolean
    */
    public static function getMsg($messageId)
    {
        $messageId = filter_var($messageId, FILTER_VALIDATE_INT);

        if( !empty($messageId) )
        {
            return fetch_value("SELECT `description`
                FROM `pmt_message`
                WHERE `id` = '{$messageId}'
                LIMIT 1");

        }

        return false;
    }


    /**
    * 
    * Get global payments module settings
    *
    * @return array
    */
    private static function getSettings()
    {
        $settings = fetch_row("SELECT `encryption_key`, `notification_email_address`, `terms_and_conditions`,
            `success_message`, `fail_message`, `success_email_body`, `fail_email_body`, `processed_message`, `payment_type`
            FROM `pmt_settings`
            WHERE `id` = '1'
            LIMIT 1");

        return $settings;
    }


    /**
    * 
    * Process payment request
    * Get payment account details
    * Init payment request using DPS/PayPal
    *
    * @param integer paymentAccountId, Description - Payment account id
    * @return boolean
    */
    public function makePayment($paymentAccountId)
    {

        $paymentId     = $this->data['public_token'];
        $firstName     = $this->data['first_name'];
        $lastName      = $this->data['last_name'];
        $emailAddress  = $this->data['email_address'];
        $paymentAmount = $this->data['amount'];
        $accountDetails = $this->getAccountDetails($paymentAccountId);

        if( !empty($accountDetails) && !empty($paymentId) && !empty($paymentAmount) )
        {

            $request_url = $this->paymentURL.'/?pid='.$paymentId;


            if( $accountDetails['type'] === Payment::ACCOUNT_TYPE_2 )
            {

                $paypal_config = array();

                $paypal_config['business']         = $accountDetails['user'];
                $paypal_config['production']       = $this->productionMode;
                $paypal_config['cancel_return']    = $request_url;
                $paypal_config['return']           = $request_url;
                $paypal_config['cpp_header_image'] = $this->emailTmplData['logo_path'];
                $paypal_config['first_name']       = $firstName;
                $paypal_config['last_name']        = $lastName;
                $paypal_config['email']            = $emailAddress;
                $paypal_config['currency_code']    = PaymentConstants::DEFAULT_CURRENCY;

                if ($this->data['payment_type'] === 'P') {
                    $paypal_config['method']           = 'DoReferenceTransaction';
                }

                $this->paypal = new Paypal( $paypal_config );

                $transactionFee = round( ( $paymentAmount * ( Paypal::TXN_FEE_PERCENTAGE / 100 ) ), 2);

                $this->paypal->addItem("Payment from: {$firstName} {$lastName}, Email: {$emailAddress}", $paymentAmount, 1);

                $this->paypal->pay();
            }
            else
            {

                $dps_config = array();

                $dps_config['user']                = $accountDetails['user'];
                $dps_config['api_key']             = $accountDetails['api_key'];
                $dps_config['email_address']       = $emailAddress;
                $dps_config['request_url']         = $request_url;
                $dps_config['currency_settlement'] = PaymentConstants::DEFAULT_CURRENCY;
                $dps_config['payment_type']        = $this->data['payment_type'];

                $this->dps = new DPS( $dps_config );

                $this->dps->makePaymentRequest($paymentId, $paymentAmount);
            }
        }

        return false;
    }


    /**
    * 
    * Handle response from DPS
    * Check if there is payment data and DPS encrypted key
    * Update payment request details based on response
    * Notify payer and admin
    *
    * @param string $encHex, Description - Encrypted string from DPS
    * @return boolean
    */
    public function handleDPSResponse($encHex)
    {

        $paymentData = $this->data;

        if( !empty($encHex) && !empty($paymentData) )
        {

            $dps_config = array();

            $dps_config['user']    = $paymentData['pmt_account_user'];
            $dps_config['api_key'] = $paymentData['pmt_account_api_key'];

            $this->dps = new DPS( $dps_config );

            $dpsResponse = $this->dps->getResponse($encHex);

            $txnId = $dpsResponse->TxnId;

            $isSuccessfull = ($dpsResponse->getSuccess() == '1');
            
            if( !$this->isProcessed($txnId) )
            {
                $pmtDateKey = (($isSuccessfull) ? 'approved_on' : 'declined_on');

                $pmtData = array();

                $pmtData['status']     = ( $isSuccessfull ) ? self::FLAG_APPROVED : self::FLAG_DECLINED;
                $pmtData['email_sent'] = self::FLAG_YES;
                $pmtData[$pmtDateKey]  = $this->getCurrentDateTime();

                $this->updateDetails($pmtData);

                $pmtTxnData = array();

                $pmtTxnData['amount_settlement']   = $dpsResponse->getAmountSettlement();
                $pmtTxnData['auth_code']           = $dpsResponse->getAuthCode();
                $pmtTxnData['cc_name']             = $dpsResponse->getCardName();
                $pmtTxnData['cc_holder_name']      = $dpsResponse->getCardHolderName();
                $pmtTxnData['cc_number']           = $dpsResponse->getCardNumber();
                $pmtTxnData['cc_date_expire']      = $dpsResponse->getDateExpiry();
                $pmtTxnData['dps_billing_id']      = $dpsResponse->getDpsBillingId();
                $pmtTxnData['dps_ref']             = $dpsResponse->getDpsTxnRef();
                $pmtTxnData['type']                = $dpsResponse->getTxnType();
                $pmtTxnData['data1']               = $dpsResponse->getTxnData1();
                $pmtTxnData['currency_settlement'] = $dpsResponse->getCurrencySettlement();
                $pmtTxnData['client_ip']           = $dpsResponse->getClientInfo();
                $pmtTxnData['txn_id']              = $dpsResponse->getTxnId();
                $pmtTxnData['currency_input']      = $dpsResponse->getCurrencyInput();
                $pmtTxnData['merchant_ref']        = $dpsResponse->getMerchantReference();
                $pmtTxnData['response_text']       = $dpsResponse->getResponseText();
                $pmtTxnData['mac_address']         = $dpsResponse->getTxnMac();
                $pmtTxnData['response_url']        = $encHex;
                $pmtTxnData['date_processsed']     = $this->getCurrentDateTime();
                
                $this->updateTxnDetails($pmtTxnData);


                self::logHistory( (($isSuccessfull) ? self::HISTORY_SUCCESS_ID : self::HISTORY_DECLINED_ID), $paymentData['id'] );

                if( !empty($isSuccessfull) )
                {
                    $this->sendPaymentSuccessEmail();
                }
                else
                {
                    $this->sendPaymentFailEmail();
                }

            }


    
            return $isSuccessfull;


        }

        return false;

    }

    /**
    * 
    * Handle response from PayPal
    * Check if there is payment data and PayPal identity token
    * Update payment request details based on response
    * Notify payer and admin
    *
    * @param string $identityToken, Description - Tdentity token from PayPal
    * @return boolean
    */
    public function handlePayPalResponse($identityToken)
    {

        $paymentData = $this->data;


        if( !empty($identityToken) && !empty($paymentData) )
        {

            $this->paypal = new Paypal( array( 'production' => $this->productionMode ), $paymentData['pmt_account_api_key']);

            $paypalResponseArr =  $this->paypal->getTransactionDetails( $identityToken );

            $paypalResponseStatus =  $paypalResponseArr['status'];
            $paypalResponseData   =  $paypalResponseArr['data'];

            $txnId = $paypalResponseData['txn_id'];

            $isSuccessfull = ($paypalResponseStatus === 'SUCCESS');
            
            

            if( !$this->isProcessed($txnId) )
            {
                $pmtDateKey = (($isSuccessfull) ? 'approved_on' : 'declined_on');

                $pmtData = array();

                $pmtData['status']     = ( $isSuccessfull ) ? self::FLAG_APPROVED : self::FLAG_DECLINED;
                $pmtData['email_sent'] = self::FLAG_YES;
                $pmtData[$pmtDateKey]  = $this->getCurrentDateTime();

                $this->updateDetails($pmtData);

                $pmtTxnData = array();

                $pmtTxnData['amount_settlement']   = $paypalResponseData['mc_gross'];
                $pmtTxnData['cc_holder_name']      = trim("{$paypalResponseData['first_name']} {$paypalResponseData['last_name']}");
                $pmtTxnData['type']                = $paypalResponseData['payment_type'];
                $pmtTxnData['data1']               = $paymentData['public_token'];
                $pmtTxnData['currency_settlement'] = $paypalResponseData['mc_currency'];
                $pmtTxnData['txn_id']              = $txnId;
                $pmtTxnData['paypal_payer_id']     = $paypalResponseData['payer_id'];
                $pmtTxnData['paypal_payer_status'] = $paypalResponseData['payer_status'];
                $pmtTxnData['response_text']       = $paypalResponseData['payment_status'];
                $pmtTxnData['response_url']        = $identityToken;
                $pmtTxnData['date_processsed']     = $this->getCurrentDateTime();

                $this->updateTxnDetails($pmtTxnData);


                self::logHistory( (($isSuccessfull) ? self::HISTORY_SUCCESS_ID : self::HISTORY_DECLINED_ID), $paymentData['id'] );

                if( !empty($isSuccessfull) )
                {
                    $this->sendPaymentSuccessEmail();
                }
                else
                {
                    $this->sendPaymentFailEmail();
                }

            }


    
            return $isSuccessfull;


        }

        return false;

    }


    /**
    * 
    * Generate payer and admin success notification emails
    * Create email template tags
    * Compile email templates
    * Send success notification email to payer and admin
    *
    * @return boolean
    */
    private function sendPaymentSuccessEmail()
    {

        $paymentDetails = $this->data;

        if( !empty($paymentDetails) )
        {

            $templateDetails = self::getTemplateDetails($paymentDetails['email_template_id']);

            $paymentRequestId              = $paymentDetails['id'];
            $paymentRequestDateObj         = new DateTime($paymentDetails['created_on']);
            $paymentRequestApprovedDateObj = new DateTime($paymentDetails['approved_on']);

            /* ==| CREATE TEMPLATE TAGS ==================================================== */
            $templateTags = array();
            
            $templateTags['success_email_body']     = $this->settings['success_email_body'];
            $templateTags['client_success_subject'] = 'Payment Success';
            $templateTags['admin_success_subject']  = 'Payment Transaction Success';
            $templateTags['full_name']              = $paymentDetails['full_name'];
            $templateTags['email_address']          = $paymentDetails['email_address'];
            $templateTags['amount']                 = $paymentDetails['amount'];
            $templateTags['from_name']              = $templateDetails['from_name'];
            $templateTags['from_email_address']     = $templateDetails['from_email_address'];
            $templateTags['currency_symbol']        = PaymentConstants::DEFAULT_CURRENCY_SYMBOL;
            $templateTags['request_date']           = ($paymentRequestDateObj->format('l, j M Y @ h:i a'));
            $templateTags['payment_date']           = ($paymentRequestApprovedDateObj->format('l, j M Y @ h:i a'));

            $templateTags = array_merge($this->emailTmplData, $templateTags);

            

            /* ==| SEND SUCCESS EMAIL TO CLIENT ==================================================== */
            $compiledTemplate = self::processTemplate($this->clientSuccessEmailTmplPath, $templateTags);
            $templateDetails['subject'] = 'Payment Success';
            $templateDetails['email_body']       = $compiledTemplate;
            $templateDetails['to_email_address'] = $paymentDetails['email_address'];
            
            if(empty($templateDetails['from_email_address'])) {
                $templateDetails['from_email_address'] = $this->settings['notification_email_address'];
            }
            $emailIsSent = self::sendEmail($templateDetails);

            if( $emailIsSent )
            {
                self::logHistory( self::HISTORY_NTF_CLIENT_ID, $paymentRequestId );
            }

            /* ==| SEND SUCCESS EMAIL TO ADMIN ==================================================== */
            $adminEmailDetails = array();

            $adminEmailDetails['subject']          = 'Payment Transaction Success';
            $adminEmailDetails['email_body']       = self::processTemplate($this->adminSuccessEmailTmplPath, $templateTags);
            $adminEmailDetails['to_email_address'] = $templateDetails['from_email_address'];
            $adminEmailDetails                     = array_merge($templateDetails, $adminEmailDetails);
            $adminEmailIsSent = self::sendEmail($adminEmailDetails);

            if( $adminEmailIsSent )
            {
                self::logHistory( self::HISTORY_NTF_ADMIN_ID, $paymentRequestId );
            }

            return ($emailIsSent && $adminEmailIsSent);
        }

        return false;
    }

    /**
    * 
    * Generate payer and admin fail notification emails
    * Create email template tags
    * Compile email templates
    * Send fail notification email to payer and admin
    *
    * @return boolean
    */
    private function sendPaymentFailEmail()
    {

        $paymentDetails = $this->data;

        if( !empty($paymentDetails) )
        {

            $templateDetails = self::getTemplateDetails($paymentDetails['email_template_id']);

            $paymentRequestId              = $paymentDetails['id'];
            $paymentRequestDateObj         = new DateTime($paymentDetails['created_on']);
            $paymentRequestDeclinedDateObj = new DateTime($paymentDetails['declined_on']);

            /* ==| CREATE TEMPLATE TAGS ==================================================== */
            $templateTags = array();
            
            $templateTags['fail_email_body']     = $this->settings['fail_email_body'];
            $templateTags['from_email_address']  = $this->settings['notification_email_address'];
            $templateTags['client_fail_subject'] = 'Payment Fail';
            $templateTags['admin_fail_subject']  = 'Payment Transaction Fail';
            $templateTags['full_name']           = $paymentDetails['full_name'];
            $templateTags['email_address']       = $paymentDetails['email_address'];
            $templateTags['from_name']           = $templateDetails['from_name'];
            $templateTags['from_email_address']  = $paymentDetails['from_email_address'];
            $templateTags['amount']              = $paymentDetails['amount'];
            $templateTags['payment_url']         = $paymentDetails['request_url'];
            $templateTags['response_text']       = $templateDetails['response_text'];
            $templateTags['currency_symbol']     = PaymentConstants::DEFAULT_CURRENCY_SYMBOL;
            $templateTags['request_date']        = ($paymentRequestDateObj->format('l, j M Y @ h:i a'));
            $templateTags['payment_date']        = ($paymentRequestDeclinedDateObj->format('l, j M Y @ h:i a'));

            $templateTags = array_merge($this->emailTmplData, $templateTags);

            /* ==| SEND FAIL EMAIL TO CLIENT ==================================================== */
            $compiledTemplate                    = self::processTemplate($this->clientFailEmailTmplPath, $templateTags);
            $templateDetails['subject']          = 'Payment Fail';
            $templateDetails['email_body']       = $compiledTemplate;
            $templateDetails['to_email_address'] = $paymentDetails['email_address'];
            
            if(empty($templateDetails['from_email_address'])) {
                $templateDetails['from_email_address'] = $this->settings['notification_email_address'];
            }

            $emailIsSent = self::sendEmail($templateDetails);

            if( $emailIsSent )
            {
                self::logHistory( self::HISTORY_NTF_CLIENT_ID, $paymentRequestId );
            }

            /* ==| SEND Fail EMAIL TO ADMIN ==================================================== */
            $adminEmailDetails = array();

            $adminEmailDetails['subject']          = 'Payment Transaction Fail';
            $adminEmailDetails['email_body']       = self::processTemplate($this->adminFailEmailTmplPath, $templateTags);
            $adminEmailDetails['to_email_address'] = $templateDetails['from_email_address'];
            $adminEmailDetails                     = array_merge($templateDetails, $adminEmailDetails);
            $adminEmailIsSent = self::sendEmail($adminEmailDetails);

            if( $adminEmailIsSent )
            {
                self::logHistory( self::HISTORY_NTF_FAIL_ADMIN_ID, $paymentRequestId );
            }

            return ($emailIsSent && $adminEmailIsSent);

        }

        return false;
    }


    /**
    * 
    * Complie success message 
    *
    * @return string
    */
    public function getSuccessMsg()
    {

        return self::processTemplate($this->settings['success_message'], $this->data);
    }

    /**
    * 
    * Complie fail message 
    *
    * @return string
    */
    public function getFailMsg()
    {

        return self::processTemplate($this->settings['fail_message'], $this->data);
    }

    /**
    * 
    * Complie proccessed payment message 
    *
    * @return string
    */
    public function getProccessPaymentMsg()
    {

        return self::processTemplate($this->settings['processed_message'], $this->data);
    }

    /**
    * 
    * Send emails using PHPMailer
    *
    * @param array $data, Description - Array of data which containers PHPMailer setting
    * @return boolean
    */
    private static function sendEmail($data)
    {

        if( !empty($data) )
        {
            $mailer = new PHPMailer();

            $fromName         = $data['from_name'];
            $fromEmailAddress = $data['from_email_address'];
            if(strpos($fromEmailAddress, ';')) {
                $fromEmailAddress = explode(';', $fromEmailAddress);
                $fromEmailAddress = trim($fromEmailAddress[0]);
            }
            $toEmailAddress   = $data['to_email_address'];
            if(strpos($toEmailAddress, ';')) {
                $toEmailAddress = explode(';', $toEmailAddress);
                foreach ($toEmailAddress as $email ) {
                    $mailer->AddAddress(trim($email));
                }
            } else {
                $mailer->AddAddress($toEmailAddress);
            }
            $subject          = $data['subject'];
            $emailBody        = $data['email_body'];

            $mailer->IsHTML();
            $mailer->AddReplyTo($fromEmailAddress);
            $mailer->SetFrom($fromEmailAddress);
            $mailer->FromName = $fromName;
            $mailer->Subject  = $subject;
            $mailer->msgHTML($emailBody);

            return $mailer->Send();
            
        }

        return false;
    }


    /**
    * 
    * Compile content using tags
    *
    * @param string $path, Description - real path to template file or string of tempalte
    * @param array $tags, Description - Array of template tags
    * @param string $start_tag, Description - Opening tag
    * @param string $end_tag, Description - Closing tag
    * @return string
    */
    private static function processTemplate($path, $tags = array(), $start_tag = '{', $end_tag = '}')
    {


        $is_file      = is_file($path);
        $is_not_empty = !empty($path);

        if( $is_file || $is_not_empty )
        {

            // read email tempalte file
            if( $is_file )
            {
                $template = file_get_contents($path);
            }
            elseif( $is_not_empty )
            {
                $template = $path;
            }
            else
            {
                return '';
            }


            // replace tags with value
            foreach ($tags as $tag => $value)
            {
                $value    = ($value) ? $value : '';
                $template = str_replace($start_tag.$tag.$end_tag, $value, $template);
            }

            return $template;
            
        }

        return '';

    }

    /**
    * 
    * Create unique id
    *
    * @param integer $length, Description - Total characters of ID
    * @return string
    */
    private static function createUniqueId($length = 15)
    {

        $id = (uniqid().session_id());
        $id = str_shuffle($id);

        $id = ( $length > 0 ) ? substr($id, 0, $length) : $id;

        return $id;

    }


    /**
    * 
    * Get current date and time in sql format
    *
    * @return string
    */
    private static function getCurrentDateTime()
    {

        $current_date = new DateTime();

        return $current_date->format('Y-m-d H:i:s');

    }


    /**
    * 
    * Check if class property exists in $config array
    * Set value of class property exists if exists
    *
    * @param array $config, Description - Array of class properties with relative values
    * @return void
    */
    private function setConfig($config)
    {
        if( !empty($config) )
        {
            foreach ($config as $property => $value)
            {

                if( property_exists($this, $property) )
                {
                    $this->$property = $value;
                }
            }
        }
    }


};

?>