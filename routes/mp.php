<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  date_default_timezone_set('Africa/Nairobi');

  // Fetching phone number and amount from the $_POST array
    $postedPhoneNumber = $_POST['phone_number'];
    $postedAmount = $_POST['amount'];

     // Validate phone number format (example: 254711234567)
    if (!preg_match('/^254\d{9}$/', $postedPhoneNumber)) {
        echo "Error: Invalid phone number format. Please enter a valid phone number.";
        exit;
    }

    // Validate amount (numeric and greater than 0)
    if (!is_numeric($postedAmount) || $postedAmount <= 0) {
        echo "Error: Invalid amount. Please enter a valid numeric amount greater than 0.";
        exit; 
    }

    $AccountReference = '2345';
  $TransactionDesc = 'payment';

  # access token
  $consumerKey = 'zNZWo4pXCeaJxHPLvmJvA7Ut6AkZvXXT'; //Fill with your app Consumer Key
  $consumerSecret = 'IXnZXRzqUvgI5kVh'; // Fill with your app Secret

  $BusinessShortCode = '6602100';//8728622
  $Partb='8858918';
  $Passkey = '7c1733bbcf56cfb4e781871ac3cc72d7f1ea123f3196bafd0e13533b4a8487a2';  
  
  /*
    This are your info, for
    $PartyA should be the ACTUAL clients phone number or your phone number, format 2547****
    $AccountRefference, it maybe invoice number, account number etc on production systems, but for test just put anything
    TransactionDesc can be anything, probably a better description of or the transaction
    $Amount this is the total invoiced amount, Any amount here will be 
    actually deducted from a clients side/your test phone number once the PIN has been entered to authorize the transaction. 
    for developer/test accounts, this money will be reversed automatically by midnight.
  */
  
  
  # Get the timestamp, format YYYYmmddhms -> 20181004151020
  $Timestamp = date('YmdHis');    
  
  # Get the base64 encoded string -> $password. The passkey is the M-PESA Public Key
  $Password = base64_encode($BusinessShortCode.$Passkey.$Timestamp);

  # header for access token
  $headers = ['Content-Type:application/json; charset=utf8'];

    # M-PESA endpoint urls
  $access_token_url = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
  $initiate_url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

  # callback url
   
  $receiptno = '1111';//====added receipt no

$CallBackURL = "https://xx.php?receipt_no=$receiptno";

  $curl = curl_init($access_token_url);
  curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($curl, CURLOPT_HEADER, FALSE);
  curl_setopt($curl, CURLOPT_USERPWD, $consumerKey.':'.$consumerSecret);
  $result = curl_exec($curl);
  $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
  $result = json_decode($result);
  $access_token = $result->access_token;  
  curl_close($curl);

  # header for stk push
  $stkheader = ['Content-Type:application/json','Authorization:Bearer '.$access_token];

  # initiating the transaction
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $initiate_url);
  curl_setopt($curl, CURLOPT_HTTPHEADER, $stkheader); //setting custom header

  $curl_post_data = array(
    //Fill in the request parameters with valid values
    'BusinessShortCode' => $BusinessShortCode,
    'Password' => $Password,
    'Timestamp' => $Timestamp,
    'TransactionType' => 'CustomerBuyGoodsOnline',
    //'TransactionType' => 'CustomerPayBillOnline',
    'Amount' => $postedAmount,
    'PartyA' => $postedPhoneNumber,
    'PartyB' => $Partb,
    'PhoneNumber' => $postedPhoneNumber,
    'CallBackURL' => $CallBackURL,
    'AccountReference' => $AccountReference,
    'TransactionDesc' => $TransactionDesc
  );

  $data_string = json_encode($curl_post_data);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
  $curl_response = curl_exec($curl);
  //print_r($curl_response);

  //echo $curl_response;

  $response_data = json_decode($curl_response, true);

// Access individual values using keys
if ($response_data !== null) {
   
    $responseCode = $response_data['ResponseCode'];
    
    echo $responseCode;
} else {
    // Handle JSON decoding error
    echo "Failed to decode JSON response.";
}
}
?>