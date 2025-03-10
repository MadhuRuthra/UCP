<?php
session_start();
error_reporting(E_ALL);
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");
// Include configuration.php
include_once('../api/configuration.php');
include_once "../api/send_request.php"; // Include send_request.php
// Paytm Operation - Start
extract($_REQUEST);
$current_date = date("Y-m-d H:i:s");
$milliseconds = round(microtime(true) * 1000);


// user_management Page razorpay_payment - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $action_process == "razorpay_payment") {
  $replace_txt = '{
    "user_id" : "' . $_SESSION['yjucp_user_id'] . '"
  }';

     // Call the reusable cURL function
     $response = executeCurlRequest($api_url ."/purchase_credit/rppayment_user_id", "GET", $replace_txt);
  // After got response decode the JSON result
  $header = json_decode($response, false);
  $sms_amount = 0;
  $cda = '';
  if ($header->response_status == 200) {
    for ($indicator = 0; $indicator < $header->num_of_rows; $indicator++) {
      // Looping the indicator is less than the num_of_rows.if the condition is true to continue the process.if the condition are false to stop the process
      $cda = $header->report[$indicator]->usr_credit_id;
      $sms_amount = $header->report[$indicator]->amount;
    }
  }

  if ($cda != '') {
    $_SESSION['user_cda'] = $cda;
    $_SESSION['hid_yjucp_bearer_token'] = $_SESSION['yjucp_bearer_token'];
    $orderId = time();
    $txnAmount = $sms_amount;
    $custId = $_SESSION['yjucp_user_id'];
    $mobileNo = $_SESSION['yjucp_user_mobile'];
    $email = $_SESSION['yjucp_user_email'];

    $paytmParams = array();
    $paytmParams["ORDER_ID"] = $orderId;
    $paytmParams["CUST_ID"] = $custId;
    $paytmParams["MOBILE_NO"] = $mobileNo;
    $paytmParams["EMAIL"] = $email;
    $paytmParams["TXN_AMOUNT"] = $txnAmount;
    //check payment is authrized or not via API call

    $razorPayId = htmlspecialchars(strip_tags(isset($_POST['razorpay_payment_id']) ? $_POST['razorpay_payment_id'] : ""));
    $ch = curl_init('https://api.razorpay.com/v1/payments/' . $razorPayId . '');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_USERPWD, $rp_keyid . ":" . $rp_keysecret); // Input your Razorpay Key Id and Secret Id here
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = json_decode(curl_exec($ch));

    // check that payment is authorized by razorpay or not
    if ($response->status == 'authorized') {
      $respval = array('msg' => 'Payment successfully credited', 'status' => true, 'productCode' => $_POST['product_id'], 'paymentID' => $_POST['razorpay_payment_id'], 'userEmail' => $_POST['useremail']);
      $respval1 = 'msg:Payment successfully credited, status:true, productCode:' . $_POST['product_id'] . ', paymentID:' . $_POST['razorpay_payment_id'] . ', userEmail' . $_POST['useremail'];

      $replace_txt = '{
            "user_id" : "' . $_SESSION['yjucp_user_id'] . '",
            "usrsmscrd_id" : "' . $_SESSION['user_cda'] . '",
            "usrsmscrd_status" : "A",
            "usrsmscrd_status_comments" : "' . $respval1 . '"
          }';
             // Call the reusable cURL function
     $response = executeCurlRequest($api_url ."/purchase_credit/update_credit_raise_status", "PUT", $replace_txt);
      $sms = json_decode($response, false);
      $json = array("status" => 1, "msg" => "Payment process is successfully");

    } else {
      $respval = array('msg' => 'Payment failed', 'status' => false, 'productCode' => $_POST['product_id'], 'paymentID' => $_POST['razorpay_payment_id'], 'userEmail' => $_POST['useremail']);
      $respval1 = 'msg:Payment failed, status:false, productCode:' . $_POST['product_id'] . ', paymentID:' . $_POST['razorpay_payment_id'] . ', userEmail' . $_POST['useremail'];

      $replace_txt = '{
	    "user_id" : "' . $_SESSION['yjucp_user_id'] . '",
            "usrsmscrd_id" : "' . $_SESSION['user_cda'] . '",
            "usrsmscrd_status" : "F",
            "usrsmscrd_status_comments" : "' . $respval1 . '"
          }';
     $response = executeCurlRequest($api_url ."/purchase_credit/update_credit_raise_status", "PUT", $replace_txt);

      $sms = json_decode($response, false);
      $json = array("status" => 0, "msg" => "payment processing is failed");
    }
  }

}
// user_management Page razorpay_payment - End

// Finally Close all Opened Mysql DB Connection
$conn->close();
// Output header with JSON Response
header('Content-type: application/json');
echo json_encode($json);
?>
