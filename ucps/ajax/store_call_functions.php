<?php
/*
This page has some functions which is access from Frontend.
This page is act as a Backend page which is connect with Node JS API and PHP Frontend.
It will collect the form details and send it to API.
After get the response from API, send it back to Frontend.

Version : 1.0
Author : Selvalakshmi N (YJ0018)
Date : 03-DEC-2024
*/
session_start(); //start session
error_reporting(E_ALL); // The error reporting function
include_once('../api/configuration.php'); // Include configuration.php
include_once "../api/send_request.php"; // Include send_request.php
extract($_REQUEST); // Extract the request
$milliseconds = round(microtime(true) * 1000); // milliseconds in time
$request_id = $_SESSION['yjucp_user_id'] . "_" . date("Y") . 
    str_pad((new DateTime())->diff(new DateTime(date("Y") . "-01-01"))->days + 1, 3, '0', STR_PAD_LEFT) . 
    date("His") . "_" . rand(100, 999);

// Manage Sender ID Page save_mobile_api - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $tmpl_call_function == "save_mobile_api") {
  site_log_generate("Manage Sender ID Page : User : " . $_SESSION['yjucp_user_name'] . " access the page on " . date("Y-m-d H:i:s"), '../');
  // Get data
  $slt_service_category = htmlspecialchars(strip_tags(isset($_REQUEST['slt_service_category']) ? $conn->real_escape_string($_REQUEST['slt_service_category']) : ""));
  $exp1 = htmlspecialchars(strip_tags(isset($_REQUEST['txt_country_code']) ? $conn->real_escape_string($_REQUEST['txt_country_code']) : "101"));
  $mobile_number = htmlspecialchars(strip_tags(isset($_REQUEST['mobile_number']) ? $conn->real_escape_string($_REQUEST['mobile_number']) : ""));
  $txt_display_name = htmlspecialchars(strip_tags(isset($_REQUEST['txt_display_name']) ? $conn->real_escape_string($_REQUEST['txt_display_name']) : ""));
  site_log_generate("Manage Sender ID Page : Username => " . $_SESSION['yjucp_user_name'] . " access this page on " . date("Y-m-d H:i:s"), '../');

  $exp2 = explode("~~", $exp1);
  $txt_country_code = $exp2[0];
  $country_code = $exp2[1];
  $filename = '';
  if ($_FILES['fle_display_logo']['name'] != '') {
    $path_parts = pathinfo($_FILES["fle_display_logo"]["name"]);
    $extension = $path_parts['extension'];
    $filename = $_SESSION['yjucp_user_id'] . "_" . $milliseconds . "." . $extension;

    /* Location */
    $location = "../uploads/whatsapp_images/" . $filename;
    $imageFileType = pathinfo($location, PATHINFO_EXTENSION);
    $imageFileType = strtolower($imageFileType);

    switch ($imageFileType) {
      case 'jpg':
      case 'jpeg':
        $mime_type = "image/jpeg";
        break;
      case 'png':
        $mime_type = "image/png";
        break;
    }

    /* Valid extensions */
    $valid_extensions = array("jpg", "jpeg", "png");

    $rspns = '';
    if (move_uploaded_file($_FILES['fle_display_logo']['tmp_name'], $location)) {
      site_log_generate("Manage Sender ID Page : User : " . $_SESSION['yjucp_user_name'] . " whatsapp_images file moved into Folder on " . date("Y-m-d H:i:s"), '../');
    }
  } else {
    $filename = '';
  }

  if ($_SESSION['yjucp_user_master_id'] == 1 or $_SESSION['yjucp_user_master_id'] == 2) {
    $qr_code_allowed = 'A';
  } else {
    $qr_code_allowed = 'U';
  }
// To Send the request  API
  $replace_txt = '{
    "user_id" : "' . $_SESSION['yjucp_user_id'] . '",
    "country_code" : "' . $country_code . '",
    "mobile_no" : "' . $mobile_number . '",
    "profile_name" : "' . $txt_display_name . '",
    "profile_image" : "' . $filename . '",
    "service_category" : "' . $slt_service_category . '",
    "request_id" : "'.$request_id .'"
  }';
   // Call the reusable cURL function
   $response = executeCurlRequest($api_url . "/sender_id/add_sender_id", "POST", $replace_txt);

   // After got response decode the JSON result
  $sql = json_decode($response, false);

  if ($sql->response_code == 1) {
    $json = array("status" => 1, "msg" => $sql->response_msg );
  }
  else{  
    $json = array("status" => 0, "msg" =>$sql->response_msg);
  }
}
// Manage Sender ID Page save_mobile_api - End

// Message Credit Page message_credit - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $tmpl_call_function == "message_credit") {
  site_log_generate("Message Credit Page : User : " . $_SESSION['yjucp_user_name'] . " access the page on " . date("Y-m-d H:i:s"), '../');
  // Get data
  $txt_parent_user = htmlspecialchars(strip_tags(isset($_REQUEST['txt_parent_user']) ? $conn->real_escape_string($_REQUEST['txt_parent_user']) : ""));
  $txt_receiver_user = htmlspecialchars(strip_tags(isset($_REQUEST['txt_receiver_user']) ? $conn->real_escape_string($_REQUEST['txt_receiver_user']) : ""));
  $txt_message_count = htmlspecialchars(strip_tags(isset($_REQUEST['txt_message_count']) ? $conn->real_escape_string($_REQUEST['txt_message_count']) : ""));
  $hid_usrsmscrd_id = htmlspecialchars(strip_tags(isset($_REQUEST['hid_usrsmscrd_id']) ? $conn->real_escape_string($_REQUEST['hid_usrsmscrd_id']) : ""));
  site_log_generate("Message Credit Page : Username => " . $_SESSION['yjucp_user_name'] . " access this page on " . date("Y-m-d H:i:s"), '../');

  $replace_txt = '{
    "user_id" : "' . $_SESSION['yjucp_user_id'] . '"
  }'; 
     // Call the reusable cURL function
     $response = executeCurlRequest($api_url . "/list/check_available_msg", "POST", $replace_txt);
  // After got response decode the JSON result
  $header = json_decode($response, false);
 
  $available_messages = 0;
  if ($header->response_status == 200) {
    for ($indicator = 0; $indicator < $header->num_of_rows; $indicator++) {
        // Looping the indicator is less than the num_of_rows.if the condition is true to continue the process.if the condition are false to stop the process
        $available_messages = $header->report[$indicator]->available_messages;
    }
  }

  if($available_messages < $txt_message_count) {
   	$json = array("status" => 0, "msg" => "Message credit exceeds. Kindly try again after refill your message Credit!!");
  } else {
    // echo "CAME"; exit;
    // To Send the request  API
    if($hid_usrsmscrd_id != '') {
      $replace_txt = '{
        "user_id" : "' . $_SESSION['yjucp_user_id'] . '",
        "parent_user" : "' . $txt_parent_user . '",
        "receiver_user" : "' . $txt_receiver_user . '",
        "message_count" : "' . $txt_message_count . '",
        "credit_raise_id" : "' . $hid_usrsmscrd_id . '",
        "request_id" : "'.$request_id .'"
      }'; // exit;
    } else {
      $replace_txt = '{
        "user_id" : "' . $_SESSION['yjucp_user_id'] . '",
        "parent_user" : "' . $txt_parent_user . '",
        "receiver_user" : "' . $txt_receiver_user . '",
        "message_count" : "' . $txt_message_count . '",
        "request_id" : "'.$request_id .'"
      }'; // exit;
    }

         // Call the reusable cURL function
         $response = executeCurlRequest($api_url . "/list/add_message_credit", "POST", $replace_txt);

      // After got response decode the JSON result
      $header = json_decode($response, false);
      if ($header->response_status == 200) {
        $json = array("status" => 1, "msg" => "Message Credit updated.");
      }  else if($header->response_status == 201){
        $json = array("status" => 2, "msg" => $header->response_msg);
      }else {
        $json = array("status" => 0, "msg" => "Message Credit updation failed [Invalid Inputs]. Kindly try again with the correct Inputs!");
      }
  }
}
// Message Credit Page message_credit - End

// Finally Close all Opened Mysql DB Connection
$conn->close();

// Output header with JSON Response
header('Content-type: application/json');
echo json_encode($json);
