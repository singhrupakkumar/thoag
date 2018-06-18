<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
//App::uses('ConnectionManager', 'Model');
/**
 * Restaurants Controller
 *
 * @property Payments Payments
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 */

class PaymentsController extends AppController{
    
    
  public $components = array(
   //     'Catercart',
     //   'Payment',
        'Paypal',
        'Cart',
        'AuthorizeNet'
    );  
    
    
    
 public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
        
       if($this->Session->read('Userdata')){
           $green = $this->Session->read('Userdata');
           $this->userdata=$green;
          $this->amount=$green['amount'];
       } 
       
        
    }

    public $userdata;
    public $gatewayHost        = 'https://checkout.payfort.com/';
    public $gatewaySandboxHost = 'https://sbcheckout.payfort.com/';
    public $language           = 'en';
    /**
     * @var string your Merchant Identifier account (mid)
     */
    public $merchantIdentifier = 'AWTcOlmZ';
    
    
    /**
     * @var string your access code
     */
    public $accessCode         = '4GWtxnCDHBIA9CEekdXr';
    
    /**
     * @var string SHA Request passphrase
     */
    public $SHARequestPhrase   = 'JAWADJI';
    
    /**
     * @var string SHA Response passphrase
     */
    public $SHAResponsePhrase = 'PASS';
    
    /**
     * @var string SHA Type (Hash Algorith)
     * expected Values ("sha1", "sha256", "sha512")
     */
    public $SHAType       = 'sha256';
    
    /**
     * @var string  command
     * expected Values ("AUTHORIZATION", "PURCHASE")
     */
    public $command       = 'AUTHORIZATION';
    
    /**
     * @var decimal order amount
     */
    public $amount;
    
    /**
     * @var string order currency
     */
    public $currency           = 'SAR';
    
    /**
     * @var string item name
     */
    public $itemName           = 'Apple iPhone 6s Plus';
    
    /**
     * @var string you can change it to your email
     */
    public $customerEmail      = 'test@test.com';
    
    /**
     * @var boolean for live account change it to false
     */
    public $sandboxMode        = true;
    /**
     * @var string  project root folder
     * change it if the project is not on root folder.
     */
    public $projectUrlPath     = '/foodolik/payments/rout';
    
    
//        public function __construct() {
//     $userdata=$_REQUEST;
//     $this->Session->write('Userdata', $userdata);
//      echo "<pre>"; print_r($this->Session->read('Userdata')); echo "</pre>";
//      $this->amount=$userdata['amount'];
//      exit;
//    }
//    
    
    private function removeappcart($id = NULL) {
        if ($id) {
            $this->loadModel('Cart');
            $data = $this->Cart->deleteAll(array('Cart.uid' => $id), false);
        }
    }
    
    
    private function removecatercart($id = NULL) {
        if ($id) {
            $this->loadModel('Cateringcart');
            $data = $this->Cateringcart->deleteAll(array('Cateringcart.users_id' => $id), false);
        }
    }
    
 public function processRequest($paymentMethod)
    {
        if ($paymentMethod == 'cc_merchantpage' || $paymentMethod == 'cc_merchantpage2') {
            $merchantPageData = $this->getMerchantPageData();
            $postData = $merchantPageData['params'];
            $gatewayUrl = $merchantPageData['url'];
        }
        else{
            $data = $this->getRedirectionData($paymentMethod);
            $postData = $data['params'];
            $gatewayUrl = $data['url'];
        }
        $form = $this->getPaymentForm($gatewayUrl, $postData);
        echo json_encode(array('form' => $form, 'url' => $gatewayUrl, 'params' => $postData, 'paymentMethod' => $paymentMethod));
        exit;
    }
     public function getRedirectionData($paymentMethod) {
        $merchantReference = $this->generateMerchantReference();
        if ($this->sandboxMode) {
            $gatewayUrl = $this->gatewaySandboxHost . 'FortAPI/paymentPage';
        }
        else {
            $gatewayUrl = $this->gatewayHost . 'FortAPI/paymentPage';
        }

        if ($paymentMethod == 'sadad') {
            $this->currency = 'SAR';
        }
        $postData = array(
            'amount'              => $this->convertFortAmount($this->amount, $this->currency),
            'currency'            => strtoupper($this->currency),
            'merchant_identifier' => $this->merchantIdentifier,
            'access_code'         => $this->accessCode,
            'merchant_reference'  => $merchantReference,
            'customer_email'      => 'test@payfort.com',
            //'customer_name'         => trim($order_info['b_firstname'].' '.$order_info['b_lastname']),
            'command'             => $this->command,
            'language'            => $this->language,
            'return_url'          => $this->getUrl('?r=processResponse'),
        );

        if ($paymentMethod == 'sadad') {
             $postData['payment_option'] = 'SADAD';
            $postData['command'] = 'PURCHASE';
        }
        elseif ($paymentMethod == 'naps') {
            $postData['payment_option']    = 'NAPS';
            $postData['order_description'] = $this->itemName;
        }
        elseif ($paymentMethod == 'installments') {
            $postData['installments']    = 'STANDALONE';
            $postData['command']         = 'PURCHASE';
        }
        $postData['signature'] = $this->calculateSignature($postData, 'request');
        $debugMsg = "Fort Redirect Request Parameters \n".print_r($postData, 1);
        $this->log($debugMsg);
        return array('url' => $gatewayUrl, 'params' => $postData);
    }
    
   public function getMerchantPageData()
    {
        $merchantReference = $this->generateMerchantReference();
        $returnUrl = $this->getUrl('?r=merchantPageReturn');
        if(isset($_GET['3ds']) && $_GET['3ds'] == 'no') {
            $returnUrl = $this->getUrl('?r=merchantPageReturn&3ds=no');
        }
        $iframeParams              = array(
            'merchant_identifier' => $this->merchantIdentifier,
            'access_code'         => $this->accessCode,
            'merchant_reference'  => $merchantReference,
            'service_command'     => 'TOKENIZATION',
            'language'            => $this->language,
            'return_url'          => $returnUrl,
        );
        $iframeParams['signature'] = $this->calculateSignature($iframeParams, 'request');

        if ($this->sandboxMode) {
            $gatewayUrl = $this->gatewaySandboxHost . 'FortAPI/paymentPage';
        }
        else {
            $gatewayUrl = $this->gatewayHost . 'FortAPI/paymentPage';
        }
        $debugMsg = "Fort Merchant Page Request Parameters \n".print_r($iframeParams, 1);
        $this->log($debugMsg);
        
        return array('url' => $gatewayUrl, 'params' => $iframeParams);
    } 
    
     public function getPaymentForm($gatewayUrl, $postData)
    {
        $form = '<form style="display:none" name="payfort_payment_form" id="payfort_payment_form" method="post" action="' . $gatewayUrl . '">';
        foreach ($postData as $k => $v) {
            $form .= '<input type="hidden" name="' . $k . '" value="' . $v . '">';
        }
        $form .= '<input type="submit" id="submit">';
        return $form;
    }
     public function processResponse()
    {
        $fortParams = array_merge($_GET, $_POST);
        
        $debugMsg = "Fort Redirect Response Parameters \n".print_r($fortParams, 1);
        $this->log($debugMsg);

        $reason        = '';
        $response_code = '';
        $success = true;
        if(empty($fortParams)) {
            $success = false;
            $reason = "Invalid Response Parameters";
            $debugMsg = $reason;
            $this->log($debugMsg);
        }
        else{
            //validate payfort response
            $params        = $fortParams;
            $responseSignature     = $fortParams['signature'];
            $merchantReference = $params['merchant_reference'];
            unset($params['r']);
            unset($params['signature']);
            unset($params['integration_type']);
            $calculatedSignature = $this->calculateSignature($params, 'response');
            $success       = true;
            $reason        = '';

            if ($responseSignature != $calculatedSignature) {
                $success = false;
                $reason  = 'Invalid signature.';
                $debugMsg = sprintf('Invalid Signature. Calculated Signature: %1s, Response Signature: %2s', $responseSignature, $calculatedSignature);
                $this->log($debugMsg);
            }
            else {
                $response_code    = $params['response_code'];
                $response_message = $params['response_message'];
                $status           = $params['status'];
                if (substr($response_code, 2) != '000') {
                    $success = false;
                    $reason  = $response_message;
                    $debugMsg = $reason;
                    $this->log($debugMsg);
                }
            }
        }
        if(!$success) {
            $p = $params;
            $p['error_msg'] = $reason;
            $return_url = $this->getUrl('error.php?'.http_build_query($p));
        }
        else{
            
            $params['amount']=$this->castAmountFromFort($params['amount'], $this->currency);
            if($this->userdata['for']=="cateringorder"){
                $uid=$this->userdata['user_id'];
                $data = $this->Catercart->appcart($uid);
                $tax=$this->userdata['tax'];
                $notes=$this->userdata['notes'];
                $saveorder= $this->Payment->savecartorder($data, $tax, $notes, $params);
                $outputid=array("order_id"=>$saveorder);
                $this->removecatercart($uid);
             }
             if($this->userdata['for']=="delivery_collection"){
                 $uid=$this->userdata['user_id'];
                 $delivery_status=$this->userdata['delivery_status'];
                 $delivery_time=$this->userdata['delivery_time'];
                 $address_id=$this->userdata['address_id'];
                 $orderdata=$this->Cart->appcart($uid);
                 $tax=$this->userdata['tax'];
                 $notes=$this->userdata['notes'];
                 $savedcorder=$this->Payment->savedcorder($orderdata, $address_id, $delivery_status, $delivery_time, $tax, $notes, $params);
                 $outputid=array("order_id"=>$savedcorder);
                 $this->removeappcart($uid);
                
             }if($this->userdata['for']=="tableres"){
                 $uid=$this->userdata['user_id'];
                 $res_id=$this->userdata['res_id'];
                 $table_rres_id=$this->userdata['table_res_id'];
                 $tax=$this->userdata['tax'];
                 $notes=$this->userdata['notes'];
                 $cartdata = $this->Cart->getcartdata($uid, $res_id);
                 $savetableorder= $this->Payment->savetableorder($cartdata, $uid, $table_rres_id, $tax, $notes, 3, $params);
                 $outputid=array("table_id"=>$savetableorder);
                 $this->removeappcart($uid);
                 
             }if($this->userdata['for']=="table_food"){
                 $uid=$this->userdata['user_id'];
                 $res_id=$this->userdata['res_id'];
                 $table_rres_id=$this->userdata['table_res_id'];
                 $tax=$this->userdata['tax'];
                 $notes=$this->userdata['notes'];
                 $cartdata = $this->Cart->getcartdata($uid, $res_id);
                 $savetableorder= $this->Payment->savetableorder($cartdata, $uid, $table_rres_id, $tax, $notes, 3, $params);
                 $outputid=array("table_id"=>$savetableorder);
                 $this->removeappcart($uid);
             }
             if($this->userdata['for']=="qrfood"){
                 $uid=$this->userdata['user_id'];
                 $res_id=$this->userdata['res_id'];
                 $table_rres_id=$this->userdata['table_res_id'];
                 $tax=$this->userdata['tax'];
                 $notes=$this->userdata['notes'];
                 $cartdata = $this->Cart->getcartdata($uid, $res_id);
                 $savetableorder= $this->Payment->savetableorder($cartdata, $uid, $table_rres_id, $tax, $notes, 2, $params);
                 $outputid=array("table_id"=>$savetableorder);
                 $this->removeappcart($uid);
             }
             
             
             
             
           
            
             return $this->redirect(array('action' => 'success','?' => array($outputid)));
        }
       // echo "<html><body onLoad=\"javascript: window.top.location.href='" . $return_url . "'\"></body></html>";
        exit;
    }
    
    public function processMerchantPageResponse()
    {
        $fortParams = array_merge($_GET, $_POST);

        $debugMsg = "Fort Merchant Page Response Parameters \n".print_r($fortParams, 1);
        $this->log($debugMsg);
        $reason = '';
        $response_code = '';
        $success = true;
        if(empty($fortParams)) {
            $success = false;
            $reason = "Invalid Response Parameters";
            $debugMsg = $reason;
            $this->log($debugMsg);
        }
        else{
            //validate payfort response
            $params        = $fortParams;
            $responseSignature     = $fortParams['signature'];
            unset($params['r']);
            unset($params['signature']);
            unset($params['integration_type']);
            unset($params['3ds']);
            $merchantReference = $params['merchant_reference'];
            $calculatedSignature = $this->calculateSignature($params, 'response');
            $success       = true;
            $reason        = '';

            if ($responseSignature != $calculatedSignature) {
                $success = false;
                $reason  = 'Invalid signature.';
                $debugMsg = sprintf('Invalid Signature. Calculated Signature: %1s, Response Signature: %2s', $responseSignature, $calculatedSignature);
                $this->log($debugMsg);
            }
            else {
                $response_code    = $params['response_code'];
                $response_message = $params['response_message'];
                $status           = $params['status'];
                if (substr($response_code, 2) != '000') {
                    $success = false;
                    $reason  = $response_message;
                    $debugMsg = $reason;
                    $this->log($debugMsg);
                }
                else {
                    $success         = true;
                    $host2HostParams = $this->merchantPageNotifyFort($fortParams);
                    $debugMsg = "Fort Merchant Page Host2Hots Response Parameters \n".print_r($fortParams, 1);
                    $this->log($debugMsg);
                    if (!$host2HostParams) {
                        $success = false;
                        $reason  = 'Invalid response parameters.';
                        $debugMsg = $reason;
                        $this->log($debugMsg);
                    }
                    else {
                        $params    = $host2HostParams;
                        $responseSignature = $host2HostParams['signature'];
                        $merchantReference = $params['merchant_reference'];
                        unset($params['r']);
                        unset($params['signature']);
                        unset($params['integration_type']);
                        $calculatedSignature = $this->calculateSignature($params, 'response');
                        if ($responseSignature != $calculatedSignature) {
                            $success = false;
                            $reason  = 'Invalid signature.';
                            $debugMsg = sprintf('Invalid Signature. Calculated Signature: %1s, Response Signature: %2s', $responseSignature, $calculatedSignature);
                            $this->log($debugMsg);
                        }
                        else {
                            $response_code = $params['response_code'];
                            if ($response_code == '20064' && isset($params['3ds_url'])) {
                                $success = true;
                                $debugMsg = 'Redirect to 3DS URL : '.$params['3ds_url'];
                                $this->log($debugMsg);
                                echo "<html><body onLoad=\"javascript: window.top.location.href='" . $params['3ds_url'] . "'\"></body></html>";
                                exit;
                                //header('location:'.$params['3ds_url']);
                            }
                            else {
                                if (substr($response_code, 2) != '000') {
                                    $success = false;
                                    $reason  = $host2HostParams['response_message'];
                                    $debugMsg = $reason;
                                    $this->log($debugMsg);
                                }
                            }
                        }
                    }
                }
            }
            
            if(!$success) {
                $p = $params;
                $p['error_msg'] = $reason;
                $return_url = $this->getUrl('error.php?'.http_build_query($p));
            }
            else{
                
                return $this->redirect(array('action' => 'success','?' => array($params)));
                
                //$return_url = $this->getUrl('success.php?'.http_build_query($params));
            }
            //echo "<html><body onLoad=\"javascript: window.top.location.href='" . $return_url . "'\"></body></html>";
            exit;
        }
    }
    
    public function merchantPageNotifyFort($fortParams)
    {
        //send host to host
        if ($this->sandboxMode) {
            $gatewayUrl = $this->gatewaySandboxHost . 'FortAPI/paymentPage';
        }
        else {
            $gatewayUrl = $this->gatewayHost . 'FortAPI/paymentPage';
        }

        $postData      = array(
            'merchant_reference'  => $fortParams['merchant_reference'],
            'access_code'         => $this->accessCode,
            'command'             => $this->command,
            'merchant_identifier' => $this->merchantIdentifier,
            'customer_ip'         => $_SERVER['REMOTE_ADDR'],
            'amount'              => $this->convertFortAmount($this->amount, $this->currency),
            'currency'            => strtoupper($this->currency),
            'customer_email'      => $this->customerEmail,
            'customer_name'       => 'John Doe',
            'token_name'          => $fortParams['token_name'],
            'language'            => $this->language,
            'return_url'          => $this->getUrl('?r=processResponse'),
        );
        if(isset($fortParams['3ds']) && $fortParams['3ds'] == 'no') {
            $postData['check_3ds'] = 'NO';
        }
        
        //calculate request signature
        $signature             = $this->calculateSignature($postData, 'request');
        $postData['signature'] = $signature;

        $debugMsg = "Fort Host2Host Request Parameters \n".print_r($postData, 1);
        $this->log($debugMsg);
        
        if ($this->sandboxMode) {
            $gatewayUrl = 'https://sbpaymentservices.payfort.com/FortAPI/paymentApi';
        }
        else {
            $gatewayUrl = 'https://paymentservices.payfort.com/FortAPI/paymentApi';
        }
        
        $array_result = $this->callApi($postData, $gatewayUrl);
        
        $debugMsg = "Fort Host2Host Response Parameters \n".print_r($array_result, 1);
        $this->log($debugMsg);
        
        return  $array_result;
    }
    
    public function callApi($postData, $gatewayUrl)
    {
        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        $useragent = "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:20.0) Gecko/20100101 Firefox/20.0";
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json;charset=UTF-8',
                //'Accept: application/json, application/*+json',
                //'Connection:keep-alive'
        ));
        curl_setopt($ch, CURLOPT_URL, $gatewayUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_ENCODING, "compress, gzip");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // allow redirects		
        //curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return into a variable
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0); // The number of seconds to wait while trying to connect
        //curl_setopt($ch, CURLOPT_TIMEOUT, Yii::app()->params['apiCallTimeout']); // timeout in seconds
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

        $response = curl_exec($ch);

        //$response_data = array();
        //parse_str($response, $response_data);
        curl_close($ch);

        $array_result = json_decode($response, true);
        
        if (!$response || empty($array_result)) {
            return false;
        }
        return $array_result;
    }
     public function calculateSignature($arrData, $signType = 'request')
    {
        $shaString             = '';
        ksort($arrData);
        foreach ($arrData as $k => $v) {
            $shaString .= "$k=$v";
        }

        if ($signType == 'request') {
            $shaString = $this->SHARequestPhrase . $shaString . $this->SHARequestPhrase;
        }
        else {
            $shaString = $this->SHAResponsePhrase . $shaString . $this->SHAResponsePhrase;
        }
        $signature = hash($this->SHAType, $shaString);

        return $signature;
    }
     public function convertFortAmount($amount, $currencyCode)
    {
        $new_amount = 0;
        $total = $amount;
        $decimalPoints    = $this->getCurrencyDecimalPoints($currencyCode);
        $new_amount = round($total, $decimalPoints) * (pow(10, $decimalPoints));
        return $new_amount;
    }
     public  function castAmountFromFort($amount, $currencyCode)
    {
        $decimalPoints    = $this->getCurrencyDecimalPoints($currencyCode);
        //return $amount / (pow(10, $decimalPoints));
        $new_amount = round($amount, $decimalPoints) / (pow(10, $decimalPoints));
        return $new_amount;
    }
    
    /**
     * 
     * @param string $currency
     * @param integer 
     */
    public function getCurrencyDecimalPoints($currency)
    {
        $decimalPoint  = 2;
        $arrCurrencies = array(
            'JOD' => 3,
            'KWD' => 3,
            'OMR' => 3,
            'TND' => 3,
            'BHD' => 3,
            'LYD' => 3,
            'IQD' => 3,
        );
        if (isset($arrCurrencies[$currency])) {
            $decimalPoint = $arrCurrencies[$currency];
        }
        return $decimalPoint;
    }

    public function getUrl($path)
    {
        $url = 'http://' .$_SERVER['HTTP_HOST'] . $this->projectUrlPath. $path;
        return $url;
        
    }

    public function generateMerchantReference()
    {
        return rand(0, 9999999999);
    }
    function getPaymentOptionName($po) {
        switch($po) {
            case 'creditcard' : return 'Credit Cards';
            case 'cc_merchantpage' : return 'Credit Cards (Merchant Page)';
            case 'installments' : return 'Installments';
            case 'sadad' : return 'SADAD';
            case 'naps' : return 'NAPS';
            default : return '';
        }
    }
    
    
           
      public function index()
    {
         
          $userdata=$_REQUEST;
        $this->Session->write('Userdata', $userdata);
        $green = $this->Session->read('Userdata');
    //  echo "<pre>";  print_r($green); echo "</pre>";
      if($green['paymentmethod']=="cc_merchantpage"){
         $this->amount=$green['amount'];
           return $this->redirect(array('action' => 'conferm','?' => array('payment_method' => $green['paymentmethod'])));
          
      }
      
      if($green['paymentmethod']=="sadad"){
           $this->amount=$green['amount'];
          $this->set('paymenttype', $green['paymentmethod']);
        
      }
       
       
       
        }
        
        
        
         public function conferm()
    {
        $data['paymentMethod'] = $_REQUEST['payment_method']; 
        $optionval= $this->getPaymentOptionName($data['paymentMethod']);
         $data['amount'] =  $this->amount;
         $data['currency'] = $this->currency;
       $data['totalAmount'] = $data['amount'];
       if($data['paymentMethod']== 'cc_merchantpage'){
        $merchantPageData = $this->getMerchantPageData();
        $postData = $merchantPageData['params'];
        $gatewayUrl = $merchantPageData['url'];
      }
                $this->set('data', $data);
                $this->set('optional', $optionval);
                $this->set('merchantPageData', $merchantPageData);
     
        }
         public function error()
    {
          
       
        }
         public function success()
    {
          
       
        }
         public function rout()
    {
         if($_REQUEST['r'] == 'getPaymentPage') {
$this->processRequest($_REQUEST['paymentMethod']);
}
elseif($_REQUEST['r'] == 'merchantPageReturn') {
    $this->processMerchantPageResponse();
}
elseif($_REQUEST['r'] == 'processResponse') {
    $this->processResponse();
}
else{
    echo 'Page Not Found!';
    exit;
}
exit();
        }
}
?>