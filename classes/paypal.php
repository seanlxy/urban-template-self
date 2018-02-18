<?php

class Paypal {


    const PRODUCTION_URL                  = 'https://www.paypal.com/cgi-bin/webscr/?';
    
    const SANDBOX_URL                     = 'https://www.sandbox.paypal.com/cgi-bin/webscr/?';
    
    const TRANSACTION_PROCESS_URL         = 'https://www.paypal.com/cgi-bin/webscr';
    
    const SANDBOX_TRANSACTION_PROCESS_URL = 'https://www.sandbox.paypal.com/cgi-bin/webscr';

    const TXN_FEE_PERCENTAGE              = 2.9;


    private $params = array(
        
        'business'              => '', //Account email or id
        'cmd'                   => '_cart', //Do not modify
        'production'            => false,
        
        #Custom variable here we send the billing code-->
        'custom'                => '',
        'invoice'               => '', //Code to identify the bill
        
        #API Configuration-->
        'upload'                => '1', //Do not modify
        'currency_code'         => 'NZD', //http://bit.ly/anciiH
        'disp_tot'              => 'Y',
        
        #Page Layout -->
        'cpp_header_image'      => '', //Image header url [750 pixels wide by 90 pixels high]
        'cpp_cart_border_color' => 'FFFFFF', //The HTML hex code for your principal identifying color
        'no_note'               => 1, //[0,1] 0 show, 1 hide
        
        #Payment Page Information -->
        'return'                => '', //The URL to which PayPal redirects buyersÃ¢â‚¬â„¢ browser after they complete their payments.
        'cancel_return'         => '', //Specify a URL on your website that displays a Ã¢â‚¬Å“Payment CanceledÃ¢â‚¬Â page.
        'notify_url'            => '',  //The URL to which PayPal posts information about the payment (IPN)
        'rm'                    => '12', //Leave this to get payment information 
        'lc'                    => 'EN', //Languaje [EN,ES]
        
        #Shipping and Misc Information -->
        'shipping'              => '',
        'shipping2'             => '',
        'handling'              => '',
        'tax'                   => '',
        'discount_amount_cart'  => '', //Discount amount [9.99]
        'discount_rate_cart'    => '', //Discount percentage [15]
        
        #Customer Information -->
        'first_name'            => '',
        'last_name'             => '',
        'address1'              => '',
        'address2'              => '',
        'city'                  => '',
        'state'                 => '',
        'zip'                   => '',
        'email'                 => '',
        'night_phone_a'         => '',
        'night_phone_b'         => '',
        'night_phone_c'         => '',
        'result'                => '12',
        
        'method'                => ''

    );

    private $no_of_items    = 1;

    private $access_token;

    public function __construct( $config = array(), $access_token = '' )
    {
        $this->setParams( $config );

        $this->access_token = $access_token;
        
    }


    public function addItem( $item_name = '', $item_amount = NULL, $item_qty = NULL, $item_number = NULL )
    {
        $this->params['item_name_'.$this->no_of_items]   = $item_name;
        $this->params['amount_'.$this->no_of_items]      = $item_amount;
        $this->params['quantity_'.$this->no_of_items]    = $item_qty;
        $this->params['item_number_'.$this->no_of_items] = $item_number;
        $this->no_of_items++;
    }


    public function getRequestUrl()
    {

        $redirect_url = ( $this->params['production'] === true ) ? static::PRODUCTION_URL : static::SANDBOX_URL;

        $redirect_url .= http_build_query($this->params);

        return $redirect_url;

    }

    public function pay()
    {

        $url = filter_var($this->getRequestUrl(), FILTER_VALIDATE_URL);

        if( $url )
        {
            
            header("Location: ".$url);
            exit();
        }
        else
        {
            $this->logMessage('Invalid URL provided');
            die('Invalid URL provided');
        }

    }

    private function makeTransactionRequest( $transaction_token )
    {

        $request_url = ( $this->params['production'] ) ? static::TRANSACTION_PROCESS_URL : static::SANDBOX_TRANSACTION_PROCESS_URL;


        if( $request_url && $transaction_token && $this->access_token )
        {
            $request_data = array(
                'cmd' => '_notify-synch',
                'tx' => $transaction_token,
                'at' => $this->access_token
            );

            $str_request_data = '';

            foreach( $request_data as $key => $value )
            { 
                $str_request_data .= '&'.$key.'='.$value;
            }

            $str_request_data = ltrim($str_request_data, '&');


            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $request_url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $str_request_data);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            
            $response = curl_exec($ch);

            $error =  curl_error($ch);


            curl_close($ch);


            return array('response' => $response, 'error' => $error);
            
        }
        return false;
    }

    public function getTransactionDetails( $transaction_token )
    {
        $response_data = $this->makeTransactionRequest( $transaction_token );

        $response = $response_data['response'];
        $error    = $response_data['error'];

        if( !$error && $response )
        {
            $pos_first_line = strpos($response, "\n");

            $status = trim(substr($response, 0, $pos_first_line));

            $query_str = str_replace("\n", '&', substr($response, $pos_first_line+1));
            
            $final_data = array();
            parse_str($query_str, $final_data);
            

            return array( 'status' => $status, 'data' => $final_data );
        }
        else
        {

            // Return and Log error returned from HTTP POST

            $this->logMessage("ERROR: {$error}");
            return $error;
        }
    }

    private function logMessage( $error )
    {
        if( $error )
        {
            
            $to_append = '';
            $log_file  = dirname(__FILE__).'/_paypal_log';
            

            //  Get existing file contents
            $file_r = @fopen($log_file, 'r');
            $file_contents = @fread($file_r, filesize($log_file));
            @fclose($file_r);

            // Write new record to file
            $now = new DateTime();
            $to_append .= $error. " - {$now->format('Y-m-d H:i:s')}";

            $file_w = @fopen($log_file, 'w');
            @fwrite($file_w, $file_contents.$to_append."\n");
            @fclose($file_w);
        }
    }


    private function setParams( $config )
    {
        if( is_array($config) && !empty($config) )
        {

            $this->params = array_merge($this->params, $config);
        }
        
    }

}

/* End of file paypal.php */
/* Location: /classes/paypal.php */

?>