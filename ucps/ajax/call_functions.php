<?php
session_start();
error_reporting(0);
// Include configuration.php
include_once('../api/configuration.php');
include_once "../api/send_request.php"; // Include configuration.php
extract($_REQUEST);
$current_date = date("Y-m-d H:i:s");
$milliseconds = round(microtime(true) * 1000);
$request_id = $_SESSION['yjucp_user_id'] . "_" . date("Y") . "" . date('z', strtotime(date("d-m-Y"))) . "" . date("His") . "_" . rand(1000, 9999);


// Index Page Signin - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $call_function == "signin") {
  // Get data
  $uname = htmlspecialchars(strip_tags(isset($_REQUEST['user-name']) ? $conn->real_escape_string($_REQUEST['user-name']) : ""));
  $password = htmlspecialchars(strip_tags(isset($_REQUEST['password']) ? $conn->real_escape_string($_REQUEST['password']) : ""));
  $upass = md5($password);
  $ip_address = $_SERVER['REMOTE_ADDR'];
  site_log_generate("Index Page : Username => " . $uname . " trying to login on " . date("Y-m-d H:i:s"), '../');

  $replace_txt = '{
    "txt_username" : "' . $uname . '",
    "txt_password" : "' . $password . '",
    "request_id" : "' . rand(1000000000, 9999999999) . '"
  }';


  // Call the reusable cURL function
  $response = executeCurlRequest($api_url . "/login", "POST", $replace_txt);
  // After got response decode the JSON result
  $state1 = json_decode($response, false);
  if ($state1->response_status == 200) {
    for ($indicator = 0; $indicator <= 1; $indicator++) {
      $_SESSION['yjucp_parent_id'] = $state1->parent_id;
      $_SESSION['yjucp_user_id'] = $state1->user_id;
      $_SESSION['yjucp_user_master_id'] = $state1->user_master_id;
      $_SESSION['yjucp_user_name'] = $state1->user_name;
      $_SESSION['yjucp_user_status'] = $state1->user_status;
      $_SESSION['yjucp_bearer_token'] = $state1->user_bearer_token;
      $_SESSION['yjucp_user_short_name'] = $state1->user_short_name;
    }
    site_log_generate("Index Page : " . $uname . " logged in success on " . date("Y-m-d H:i:s"), '../');
    $json = array("status" => 1, "info" => $result);
  } else {
    site_log_generate("Index Page : " . $uname . " logged in failed [Sign in Failed] on " . date("Y-m-d H:i:s"), '../');
    $json = array("status" => 0, "msg" => $state1->response_msg);
  }
}
// Index Page Signin - End

// Manage Users Page signup - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $call_function == "onboarding_signup") {
  // Get data
  $user_name = htmlspecialchars(strip_tags(isset($_REQUEST['clientname_txt']) ? $_REQUEST['clientname_txt'] : ""));
  $user_email = htmlspecialchars(strip_tags(isset($_REQUEST['email_id_contact']) ? $_REQUEST['email_id_contact'] : ""));
  $user_mobile = htmlspecialchars(strip_tags(isset($_REQUEST['mobile_no_txt']) ? $_REQUEST['mobile_no_txt'] : ""));
  $user_password = htmlspecialchars(strip_tags(isset($_REQUEST['txt_user_password']) ? $_REQUEST['txt_user_password'] : ""));
  $txt_confirm_password = htmlspecialchars(strip_tags(isset($_REQUEST['txt_confirm_password']) ? $_REQUEST['txt_confirm_password'] : ""));
  site_log_generate("Manage Users Page : " . $user_name . " trying to create a new account in our site on " . date("Y-m-d H:i:s"), '../');
  $replace_txt = '{
    "user_name" : "' . $user_name . '",
    "user_email" : "' . $user_email . '",
    "user_mobile" : "' . $user_mobile . '",
    "login_password" : "' . $user_password . '"    
  }';

  // Call the reusable cURL function
  $response = executeCurlRequest($api_url . "/login/signup", "POST", $replace_txt);

  // After got response decode the JSON result
  $json = processResponse($response);

}
// Manage Users Page signup - End

// Manage Users Page manage_users - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $call_function == "manage_users") {
  // Get data
  $user_name = htmlspecialchars(strip_tags(isset($_REQUEST['clientname_txt']) ? $_REQUEST['clientname_txt'] : ""));
  $user_email = htmlspecialchars(strip_tags(isset($_REQUEST['email_id_contact']) ? $_REQUEST['email_id_contact'] : ""));
  $user_mobile = htmlspecialchars(strip_tags(isset($_REQUEST['mobile_no_txt']) ? $_REQUEST['mobile_no_txt'] : ""));
  $user_password = htmlspecialchars(strip_tags(isset($_REQUEST['txt_new_password']) ? $_REQUEST['txt_new_password'] : ""));
  $txt_confirm_password = htmlspecialchars(strip_tags(isset($_REQUEST['txt_confirm_password']) ? $_REQUEST['txt_confirm_password'] : ""));
  $slt_user_type = htmlspecialchars(strip_tags(isset($_REQUEST['slt_user_type']) ? $_REQUEST['slt_user_type'] : ""));

  site_log_generate("Manage Users Page : " . $user_name . " trying to create a new account in our site on " . date("Y-m-d H:i:s"), '../');
  $replace_txt = '{
    "user_id" : "'. $_SESSION['yjucp_user_id'] .'",
    "user_name" : "' . $user_name . '",
    "user_email" : "' . $user_email . '",
    "user_mobile" : "' . $user_mobile . '",
    "login_password" : "' . $user_password . '",
    "user_type" : "'.$slt_user_type.'"    
  }';

  // Call the reusable cURL function
  $response = executeCurlRequest($api_url . "/login/signup", "POST", $replace_txt);

  // After got response decode the JSON result
  $json = processResponse($response);

}
// Manage Users Page manage_users - End

// Index Page Reset Password - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $call_function == "resetpwd") {
  // Get data
  $user_email = htmlspecialchars(strip_tags(isset($_REQUEST['email_id_reset']) ? $_REQUEST['email_id_reset'] : ""));
  site_log_generate("Index Page : " . $user_email . " trying to reset the password on " . $current_date, '../');
  $request_id = date("Y") . "" . date('z', strtotime(date("d-m-Y"))) . "" . date("His") . "_" . rand(1000, 9999);

  $replace_txt = '{
    "user_emailid" : "' . $user_email . '",
    "request_id" : "' . $request_id . '"
  }';

  site_log_generate("Index Page : " . $_SESSION['yjucp_user_name'] . " Execute the service On Reset Password Request [$replace_txt] on " . $current_date, '../');

    // Call the reusable cURL function
    $response = executeCurlRequest($api_url . "/login/reset_password", "PUT", $replace_txt);

  if ($header->num_of_rows > 0) {
    site_log_generate("Reset Password Page : " . $user_name . " Password Reseted on successfully on " . $current_date, '../');
    $json = array("status" => 1, "msg" => "New Password send it to your email. Kindly verify!!");
  } else {
    site_log_generate("Reset Password Page : " . $user_name . "  Password Reseted on Failed [$header->response_msg] on " . $current_date, '../');
    $json = array("status" => 0, "msg" => $header->response_msg);
  }
}

// Index Page Reset Password - End


// Change Password Page change_pwd - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $pwd_call_function == "change_pwd") {
  // Get data
  $ex_password = htmlspecialchars(strip_tags(isset($_REQUEST['txt_ex_password']) ? $_REQUEST['txt_ex_password'] : ""));
  $new_password = htmlspecialchars(strip_tags(isset($_REQUEST['txt_new_password']) ? $_REQUEST['txt_new_password'] : ""));
  $ex_pass = $ex_password;
  $upass = $new_password;

  $replace_txt = '{
    "user_id" : "' . $_SESSION['yjucp_user_id'] . '",
    "ex_password" : "' . $ex_pass . '",
    "new_password" : "' . $upass . '",
    "request_id":"' . $request_id . '"
  }';

  // Call the reusable cURL function
  $response = executeCurlRequest($api_url . "/list/change_password", "POST", $replace_txt);

  $header = json_decode($response, false);

  $json = array("status" => $header->response_code, "msg" => $header->response_msg);
}
// Change Password Page change_pwd - End

// Message Credit Page find get_available_balance - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $tmpl_call_function == "get_available_balance") {
  // Get data
  $txt_receiver_user = htmlspecialchars(strip_tags(isset($_GET["txt_receiver_user"]) ? $conn->real_escape_string($_GET["txt_receiver_user"]) : ""));
  $product_id = htmlspecialchars(strip_tags(isset($_GET["product_id"]) ? $conn->real_escape_string($_GET["product_id"]) : ""));
  $expl = explode("~~", $txt_receiver_user); // explode function using

  // To Send the request API 
  $replace_txt =
    '{
      "user_id" : "' . $_SESSION["yjucp_user_id"] . '",
      "select_user_id" : "' . $expl[0] . '",
      "product_id" :  "' . $product_id . '"
  }';

    // Call the reusable cURL function
    $response = executeCurlRequest($api_url . "/purchase_credit/available_credits", "GET", $replace_txt);

  // After got response decode the JSON result
  $header = json_decode($response, true); // Decode JSON as associative array for easier access

  // Check if response is valid and contains the expected fields
  if (isset($header['num_of_rows']) && $header['num_of_rows'] > 0) {
    $availableMessages = $header['report'][0]['available_messages'];
    $json = ["status" => 1, "msg" => "Available Credits: " . $availableMessages];
  } else if (isset($header['response_status']) && $header['response_status'] == 204) {
    $json = array("status" => 2, "msg" => $header['response_msg']);
  } else {
    $json = [ "status" => 0,"msg" => "Invalid Inputs. Kindly try again with the correct Inputs!"];
  }

}
// Message Credit Page find get_available_balance - End

// user_based_product Page find user_based_product - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $tmpl_call_function == "user_based_product") {
  // Get data
  $txt_receiver_user = htmlspecialchars( strip_tags( isset($_GET["txt_receiver_user"]) ? $conn->real_escape_string($_GET["txt_receiver_user"]) : "" ));
  $expl = explode("~~", $txt_receiver_user); // explode function using
  $replace_txt = '{
"select_user_id":"' . $expl[0] . '"
}'; 
  // Call the reusable cURL function
  $response = executeCurlRequest($api_url . "/list/products_name", "GET", $replace_txt);
  // After got response decode the JSON result
  $state1 = json_decode($response, false);

  // Based on the JSON response, list in the option button
  if ($state1->num_of_rows > 0) {
    // Looping the indicator is less than the num_of_rows.if the condition is true to continue the process and to get the details.if the condition are false to stop the process
    for ($indicator = 0; $indicator < $state1->num_of_rows; $indicator++) {
      $data .= '<option value="' . $state1->product_name[$indicator]->rights_id . " ~~" . $state1->product_name[$indicator]->rights_name . '"' . ($indicator == 0 || $slot_id == $state1->product_name[$indicator]->rights_name ? 'selected' : '') . '>' . $state1->product_name[$indicator]->rights_name . '</option>';
    }
    $json = ["status" => 1, "msg" => $data];
  } else if ($state1->response_status == 201) {
    $json = ["status" => 0, "msg" => ''];
  }
}
// user_based_product Page find user_based_product - ENd

// View On Boarding Page apprej_onboarding - Start
if ($_SERVER["REQUEST_METHOD"] == "POST" and $call_function == "apprej_onboarding") {
  $txt_user = htmlspecialchars(strip_tags(isset($_REQUEST["txt_user"]) ? $conn->real_escape_string($_REQUEST["txt_user"]) : ""));
  $txt_remarks = htmlspecialchars(strip_tags(isset($_REQUEST["txt_remarks"]) ? $conn->real_escape_string($_REQUEST["txt_remarks"]) : ""));
  $user_status = htmlspecialchars(strip_tags(isset($_REQUEST["user_status"]) ? $conn->real_escape_string($_REQUEST["user_status"]) : ""));
  $user_masterid = htmlspecialchars(strip_tags(isset($_REQUEST["user_masterid"]) ? $conn->real_escape_string($_REQUEST["user_masterid"]) : ""));
  $resellerid = htmlspecialchars(strip_tags(isset($_REQUEST['resellerid']) ? $conn->real_escape_string($_REQUEST['resellerid']) : ""));
  $select_user_id = htmlspecialchars(strip_tags(isset($_REQUEST["select_user_id"]) ? $conn->real_escape_string($_REQUEST["select_user_id"]) : ""));
  $usersid = htmlspecialchars(strip_tags(isset($_REQUEST["usersid"]) ? $conn->real_escape_string($_REQUEST["usersid"]) : ""));
  $users_resellerids = str_replace(',', '","', $usersid);
  $rep_txt_remarks = "";
  if ($txt_remarks != '') {
    $rep_txt_remarks = '"txt_remarks" : "' . $txt_remarks . '",';
  }
  $makeresller = "";

  if ($user_masterid) {
    $makeresller = '"reseller_masterid" : "' . $user_masterid . '",';
  }
  if ($user_status) {
    $user_status = '"aprj_status" : "' . $user_status . '",';
  }

  if ($select_user_id) {
    $txt_user = $select_user_id;
  }

  if ($location_1) {
    $replace_txt = '{
      "user_id" : "' . $_SESSION["yjucp_user_id"] . '",
      "change_user_id" : "' . $txt_user . '",
      "media_url":' . $location_1 . ',
      "request_id" : "' . $request_id . '"
    }';
  } else {
    // To Send the request API
    $replace_txt = '{
          "user_id" : "' . $_SESSION["yjucp_user_id"] . '",
          "change_user_id" : "' . $txt_user . '",
          ' . $rep_txt_remarks . '
          ' . $makeresller . '
          ' . $user_status . '
          "request_id" : "' . $request_id . '"
          }';
  }

    // Call the reusable cURL function
    $response = executeCurlRequest($api_url . "/list/approve_reject_onboarding", "POST", $replace_txt);

  // After got response decode the JSON result
  $header = json_decode($response, false);

  // To get the response message
  if ($header->response_status == 200) {
    $json = array("status" => 1, "msg" => $header->response_msg);
  } else if ($header->response_status == 201) {
    $json = array("status" => 2, "msg" => $header->response_msg);
  } else {
    $json = array("status" => 0, "msg" => "On Boarding form updation failed [Invalid Inputs]. Kindly try again with the correct Inputs!");
  }
}
// View On Boarding Page apprej_onboarding - End


// Compose Whatsapp Page senderid_template - Start
if ($_SERVER["REQUEST_METHOD"] == "POST" and $tmpl_call_function == "senderid_template") {
  // Get data
  $slt_whatsapp_template = htmlspecialchars(strip_tags(isset($_REQUEST["slt_whatsapp_template"]) ? strtolower($_REQUEST["slt_whatsapp_template"]) : ""));
  $expl = explode("!", $slt_whatsapp_template);
    // To Send the request API Load Templates
  $load_templates ='{ "template_id" : "' . $expl[3] . '" }';

     // Call the reusable cURL function
     $response = executeCurlRequest($api_url ."/whsp_process/p_get_template_numbers", "GET", $load_templates);
    // After got response decode the JSON result
  $state1 = json_decode($response, false);
  $rsmsg .= '<table style="width: 100%;">';
  if ($state1->response_code == 1) { // If the response is success to execute this condition
      for ($indicator = 0; $indicator < count($state1->data); $indicator++) {
// Looping the indicator is less than the count of data.if the condition is true to continue the process.if the condition are false to stop the process
          $cntmonth =
              $state1->data[$indicator]->available_credit -
              $state1->data[$indicator]->sent_count;
          if ($cntmonth > 0) {
              if ($indicator % 2 == 0) {
                  $rsmsg .= "<tr>";
              }
              $rsmsg .='<td><input type="checkbox" checked class="cls_checkbox" id="txt_whatsapp_mobno" name="txt_whatsapp_mobno[]" tabindex="1" autofocus value="' .$state1->data[$indicator]->store_id ."~~" .$state1->data[$indicator]->whatspp_config_id ."~~" . $state1->data[$indicator]->country_code .$state1->data[$indicator]->mobile_no ."~~" .$state1->data[$indicator]->bearer_token ."~~" .$whatsapp_tmplate_url . $state1->data[$indicator]->whatsapp_business_acc_id ."~~0~~" .$whatsapp_tmplate_url .$state1->data[$indicator]->phone_number_id .'"> <label class="form-label"> ' . $state1->data[$indicator]->country_code . $state1->data[$indicator]->mobile_no ." [Avl. Credits : <b>" . $cntmonth .'</b>]</label> </td>';
              if ($indicator % 2 == 1) {
                  $rsmsg .= "</tr>";
              }
          }
      }
  }  else if($state1->response_status == 204){
      $json = array("status" => 2, "msg" => $state1->response_msg);
    }else {
      $json = array("status" => 0, "msg" => $state1->response_msg);
    }
  $rsmsg .= "</table>";
  $json = ["status" => 1, "msg" => $rsmsg];
}
// Compose Whatsapp Page senderid_template - End


// Finally Close all Opened Mysql DB Connection
$conn->close();

// Output header with JSON Response
header('Content-type: application/json');
echo json_encode($json);
