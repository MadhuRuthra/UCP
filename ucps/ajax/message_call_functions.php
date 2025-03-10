<?php
session_start();
error_reporting(E_ALL);
// Include configuration.php
include_once('../api/configuration.php');
include_once "../api/send_request.php"; // Include configuration.php
extract($_REQUEST);
$milliseconds = round(microtime(true) * 1000); // milliseconds in time
$request_id = $_SESSION['yjucp_user_id'] . "_" . date("Y") . 
    str_pad((new DateTime())->diff(new DateTime(date("Y") . "-01-01"))->days + 1, 3, '0', STR_PAD_LEFT) . 
    date("His") . "_" . rand(100, 999);


// Message Credit Page message_credit - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $tmpl_call_function == "message_credit") {
  site_log_generate("Message Credit Page : User : " . $_SESSION['yjucp_user_name'] . " access the page on " . date("Y-m-d H:i:s"), '../');
  // Get data
  $txt_product_name = htmlspecialchars(strip_tags(isset($_REQUEST['txt_product_name']) ? $conn->real_escape_string($_REQUEST['txt_product_name']) : ""));
  $txt_receiver_user = htmlspecialchars(strip_tags(isset($_REQUEST['txt_receiver_user']) ? $conn->real_escape_string($_REQUEST['txt_receiver_user']) : ""));
  $txt_message_count = htmlspecialchars(strip_tags(isset($_REQUEST['txt_message_count']) ? $conn->real_escape_string($_REQUEST['txt_message_count']) : ""));
  $hid_usrsmscrd_id = htmlspecialchars(strip_tags(isset($_REQUEST['hid_usrsmscrd_id']) ? $conn->real_escape_string($_REQUEST['hid_usrsmscrd_id']) : ""));

  $productid = explode("~~", $txt_product_name);
  $request_id = $_SESSION['yjucp_user_id'] . "_" . date("Y") . "" . date('z', strtotime(date("d-m-Y"))) . "" . date("His") . "_" . rand(1000, 9999);
  switch ($productid[5] || trim($productid[1])) {
    case ($productid[5] == 'SMS' || trim($productid[1]) == 'SMS'):
      $productid = 1;
      break;
    case ($productid[5] == 'SMPP' || ($productid[1]) == 'SMPP'):
      $productid = 2;
      break;
    case ($productid[5] == 'Whatsapp' || ($productid[1]) == 'Whatsapp'):
      $productid = 3;
      break;
    default:

  }

  // To Send the request  API
  if ($hid_usrsmscrd_id != '') {
    $replace_txt = '{
      "user_id" : "' . $_SESSION['yjucp_user_id'] . '",
      "product_id" : "' . $productid . '",
      "parent_user" : "' . $_SESSION['yjucp_user_id'] . '~~' . $_SESSION['yjucp_user_name'] . '",
      "receiver_user" : "' . $txt_receiver_user . '",
      "message_count" : "' . $txt_message_count . '",
      "credit_raise_id" : "' . $hid_usrsmscrd_id . '",
      "request_id" : "' . $request_id . '"
    }'; // exit;
  } else {
    $replace_txt = '{
      "user_id" : "' . $_SESSION['yjucp_user_id'] . '",
      "product_id" : "' . $productid . '",
      "receiver_user" : "' . $txt_receiver_user . '",
      "message_count" : "' . $txt_message_count . '",
      "request_id" : "' . $request_id . '"
    }';
  }

      // Call the reusable cURL function
      $response = executeCurlRequest($api_url ."/purchase_credit/add_message_credit", "POST", $replace_txt);

  // After got response decode the JSON result
  $header = json_decode($response, false);
 
  if ($header->response_status == 200) {
    $json = array("status" => 1, "msg" => "Message Credit updated.");
  } else if ($header->response_status == 201) {
    $json = array("status" => 2, "msg" => $header->response_msg);
  } else {
    $json = array("status" => 0, "msg" => "Message Credit updation failed [Invalid Inputs]. Kindly try again with the correct Inputs!");
  }
}
// Message Credit Page message_credit - End


//generate_report -> start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $tmpl_call_function == "generate_report") {
  // Get data
  site_log_generate("generate_report Page : User : " . $_SESSION['yjucp_user_name'] . " access the page on " . date("Y-m-d H:i:s"), '../');
  $compose_whatsapp_id = htmlspecialchars(strip_tags(isset($_REQUEST['compose_whatsapp_id']) ? $conn->real_escape_string($_REQUEST['compose_whatsapp_id']) : ""));
  $user_id = htmlspecialchars(strip_tags(isset($_REQUEST['user_id']) ? $conn->real_escape_string($_REQUEST['user_id']) : ""));

  // File moved successfully
  $replace_txt = '{
                "user_id" : "' . $_SESSION['yjucp_user_id'] . '",
                "compose_user_id" : "' . $user_id . '",
                "compose_id" : "' . $compose_whatsapp_id . '"
            }';

 // Call the reusable cURL function
 $response = executeCurlRequest($api_url ."/report/generate_report", "POST", $replace_txt);

  $respobj = json_decode($response);
  $rsp_id = $respobj->response_status;
if ($respobj->response_status == 201) {
    $json = array("status" => 0, "msg" => "Failure: " . $respobj->response_msg);
  } elseif ($respobj->response_status == 200) {
    $json = array("status" => 1, "msg" => "Success");
  }
}
//generate_report -> End

//generate_report_smpp -> start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $tmpl_call_function == "generate_report_smpp") {
  // Get data
  site_log_generate("generate_report_smpp Page : User : " . $_SESSION['yjucp_user_name'] . " access the page on " . date("Y-m-d H:i:s"), '../');

  $compose_whatsapp_id = htmlspecialchars(strip_tags(isset($_REQUEST['compose_whatsapp_id']) ? $conn->real_escape_string($_REQUEST['compose_whatsapp_id']) : ""));
  $user_id = htmlspecialchars(strip_tags(isset($_REQUEST['user_id']) ? $conn->real_escape_string($_REQUEST['user_id']) : ""));

  // File moved successfully
  $replace_txt = '{
                "user_id" : "' . $_SESSION['yjucp_user_id'] . '",
                "compose_user_id" : "' . $user_id . '",
                "compose_id" : "' . $compose_whatsapp_id . '"
            }';
 // Call the reusable cURL function
 $response = executeCurlRequest($api_url ."/report/generate_report_smpp", "POST", $replace_txt);

  $respobj = json_decode($response);
if ($respobj->response_status == 201) {
    $json = array("status" => 0, "msg" => "Failure: " . $respobj->response_msg);

  } elseif ($respobj->response_status == 200) {
    $json = array("status" => 1, "msg" => "Success");
  }
}
//generate_report_smpp -> END

// approve_compose - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $tmpl_call_function == "approve_compose") {
  // Get data
  site_log_generate("approve_compose Page : User : " . $_SESSION['yjucp_user_name'] . " access the page on " . date("Y-m-d H:i:s"), '../');

  $select_user_id = htmlspecialchars(strip_tags(isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : ""));
  $compose_id = htmlspecialchars(strip_tags(isset($_REQUEST['compose_id']) ? $_REQUEST['compose_id'] : ""));

  $replace_txt = '{
          "selected_user_id":"' . $select_user_id . '",
          "campaign_id":"' . $compose_id . '",
          "request_id" : "'.$request_id .'"
        }';

        // Call the reusable cURL function
 $response = executeCurlRequest($api_url ."/approve_composesms", "POST", $replace_txt);
  $respobj = json_decode($response);
  $rsp_id = $respobj->response_status;

if ($respobj->response_status == 201) {
    $json = array("status" => 0, "msg" => "Failure: " . $respobj->response_msg);

  } elseif ($respobj->response_status == 200) {
    $json = array("status" => 1, "msg" => "Success");
  }
}
// approve_compose - End 

// approve_compose_smpp - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $tmpl_call_function == "approve_compose_smpp") {
  // Get data
  site_log_generate("approve_compose_smpp Page : User : " . $_SESSION['yjucp_user_name'] . " access the page on " . date("Y-m-d H:i:s"), '../');

  $select_user_id = htmlspecialchars(strip_tags(isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : ""));
  $compose_id = htmlspecialchars(strip_tags(isset($_REQUEST['compose_id']) ? $_REQUEST['compose_id'] : ""));

  $replace_txt = '{
          "selected_user_id":"' . $select_user_id . '",
          "campaign_id":"' . $compose_id . '",
          "request_id" : "'.$request_id .'"
        }';
        // Call the reusable cURL function
 $response = executeCurlRequest($api_url ."/approve_composesmpp", "POST", $replace_txt);

  $respobj = json_decode($response);

  $rsp_id = $respobj->response_status;
if ($respobj->response_status == 201) {
    $json = array("status" => 0, "msg" => "Failure: " . $respobj->response_msg);

  } elseif ($respobj->response_status == 200) {
    $json = array("status" => 1, "msg" => "Success");
  }
}
// approve_compose_smpp 


// Compose Whatsapp Page reject_campaign_sms - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $tmpl_call_function == "reject_campaign_sms") {
  // Get data
  site_log_generate("reject_campaign_sms Page : User : " . $_SESSION['yjucp_user_name'] . " access the page on " . date("Y-m-d H:i:s"), '../');

  $compose_message_id = htmlspecialchars(strip_tags(isset($_REQUEST['compose_message_id']) ? $conn->real_escape_string($_REQUEST['compose_message_id']) : ""));
  $approve_status1 = htmlspecialchars(strip_tags(isset($_REQUEST['approve_status']) ? $conn->real_escape_string($_REQUEST['approve_status']) : ""));
  $selected_userid = htmlspecialchars(strip_tags(isset($_REQUEST['selected_userid']) ? $conn->real_escape_string($_REQUEST['selected_userid']) : ""));
  $reason = htmlspecialchars(strip_tags(isset($_REQUEST['reason']) ? $_REQUEST['reason'] : ""));

  // To Send the request API
  $replace_txt = '{
      "user_id" : "' . $_SESSION['yjucp_user_id'] . '",
      "campaign_status" : "' . $approve_status1 . '",
      "compose_message_id" : "' . $compose_message_id . '",
      "selected_userid" : "' . $selected_userid . '",
      "reason" : "' . $reason . '"
    }';
       // Call the reusable cURL function
       $response = executeCurlRequest($api_url ."/reject_campaign_sms", "PUT", $replace_txt);

  $respobj = json_decode($response);
 if ($respobj->response_status == 201) {
    $json = array("status" => 0, "msg" => "Failure: " . $respobj->response_msg);

  } elseif ($respobj->response_status == 200) {
    $json = array("status" => 1, "msg" => "Success");
  }
}
// reject_campaign_sms - End

// Reject SMPP Page reject_campaign_smpp - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $tmpl_call_function == "reject_campaign_smpp") {
  // Get data
  site_log_generate("reject_campaign_smpp Page : User : " . $_SESSION['yjucp_user_name'] . " access the page on " . date("Y-m-d H:i:s"), '../');

  $compose_message_id = htmlspecialchars(strip_tags(isset($_REQUEST['compose_message_id']) ? $conn->real_escape_string($_REQUEST['compose_message_id']) : ""));
  $approve_status1 = htmlspecialchars(strip_tags(isset($_REQUEST['approve_status']) ? $conn->real_escape_string($_REQUEST['approve_status']) : ""));
  $selected_userid = htmlspecialchars(strip_tags(isset($_REQUEST['selected_userid']) ? $conn->real_escape_string($_REQUEST['selected_userid']) : ""));
  $reason = htmlspecialchars(strip_tags(isset($_REQUEST['reason']) ? $_REQUEST['reason'] : ""));

  // To Send the request API
  $replace_txt = '{
      "user_id" : "' . $_SESSION['yjucp_user_id'] . '",
      "campaign_status" : "' . $approve_status1 . '",
      "compose_message_id" : "' . $compose_message_id . '",
      "selected_userid" : "' . $selected_userid . '",
      "reason" : "' . $reason . '"
    }';
    // Call the reusable cURL function
    $response = executeCurlRequest($api_url ."/reject_campaign_smpp", "PUT", $replace_txt);

  $respobj = json_decode($response);
  $rsp_id = $respobj->response_status;
if ($respobj->response_status == 201) {
    $json = array("status" => 0, "msg" => "Failure: " . $respobj->response_msg);
  
  } elseif ($respobj->response_status == 200) {
    $json = array("status" => 1, "msg" => "Success");
  }
}
// Reject SMPP Page reject_campaign_smpp - Start

// Compose Sms Page compose_sms - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $tmpl_call_function == "compose_sms") {

  site_log_generate("compose_sms Page : User : " . $_SESSION['yjucp_user_name'] . " access this page on " . date("Y-m-d H:i:s"), '../');

  // Get data
  $txt_list_mobno = htmlspecialchars(strip_tags(isset($_REQUEST['txt_list_mobno']) ? $conn->real_escape_string($_REQUEST['txt_list_mobno']) : ""));
  $txt_list_mobno = str_replace("\\r\\n", '', $txt_list_mobno);
  $rdo_sameperson_video = htmlspecialchars(strip_tags(isset($_REQUEST['rdo_sameperson_video']) ? $_REQUEST['rdo_sameperson_video'] : ""));
  $txt_group_name = urldecode($conn->real_escape_string($_REQUEST['textarea']));
  $txt_group_name = str_replace("'", "\'", $txt_group_name);
  $txt_group_name = str_replace('"', '\"', $txt_group_name);
  $txt_group_name = str_replace("\\r\\n", '\n', $txt_group_name);
  $txt_group_name = str_replace('&amp;', '&', $txt_group_name);
  $txt_group_name = str_replace(PHP_EOL, '\n', $txt_group_name);
  $txt_group_name = str_replace('\\&quot;', '"', $txt_group_name);
  $txt_group_name = str_replace('"', '\"', $txt_group_name);
  $txt_group_name = trim(preg_replace('/[ \t]+/', ' ', $txt_group_name));
  $txt_group_name = preg_replace('/\s*\n\s*/', "\n", $txt_group_name);
  $upload_contact = htmlspecialchars(strip_tags(isset($_REQUEST['upload_contact']) ? $_REQUEST['upload_contact'] : ""));
  $filename_upload = htmlspecialchars(strip_tags(isset($_REQUEST['filename_upload']) ? $_REQUEST['filename_upload'] : ""));
  $total_mobileno_count = htmlspecialchars(strip_tags(isset($_REQUEST['total_mobilenos_count']) ? $_REQUEST['total_mobilenos_count'] : ""));
  $contact_mgtgrp_id = htmlspecialchars(strip_tags(isset($_REQUEST['contact_mgtgrp_id']) ? $_REQUEST['contact_mgtgrp_id'] : ""));
  $mobile_numbers = htmlspecialchars(strip_tags(isset($_REQUEST['mobile_numbers']) ? $_REQUEST['mobile_numbers'] : ""));
  $character_count = htmlspecialchars(strip_tags(isset($_REQUEST['character_count']) ? $_REQUEST['character_count'] : ""));


  $file_location = $full_pathurl . "uploads/compose_variables/" . $filename_upload;
  $file_basename = basename($file_location);
  if ($file_basename === false) {
    $json = array("status" => 2, "msg" => "Error occurred while extracting file name!");
  }


    $replace_txt = '{
          "messages":"' . $txt_group_name . '",
          "character_count":"' . $character_count . '",
          "request_id":"' . $request_id . '",
          "message_type":"' . "Generic Message" . '",
          "rights_name":"' . "SMS" . '"';
 
          if(!$filename_upload){
            $replace_txt .= ',"group_id" :"'.$contact_mgtgrp_id.'"';
            }else{
              $replace_txt .= ',"total_mobile_count":"' . $total_mobileno_count . '"
                               ,"receiver_nos_path" : "' . $file_location . '"';
            }
        
            $replace_txt .= '}';
    // Call the reusable cURL function
    $response = executeCurlRequest($api_url ."/sms_compose", "POST", $replace_txt);

  $respobj = json_decode($response);

  $rsp_id = $respobj->response_status;
if ($respobj->response_status == 201) {
    $json = array("status" => 0, "msg" => "Failure: " . $respobj->response_msg);
  } elseif ($respobj->response_status == 200) {
    $responses = '';
    if ($respobj->invalid_count) {
      $responses .= "Invalid Count : " . $respobj->invalid_count;
    }
    ;
    $json = array("status" => 1, "msg" => "Template Created Successfully..!</br>" . $responses);
  }
}
// Compose sms Page compose_sms - End


// Compose Sms Page compose_smpp - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $tmpl_call_function == "compose_smpp") {

  site_log_generate("compose_smpp Page : User : " . $_SESSION['yjucp_user_name'] . " access this page on " . date("Y-m-d H:i:s"), '../');

  // Get data
  $txt_list_mobno = htmlspecialchars(strip_tags(isset($_REQUEST['txt_list_mobno']) ? $conn->real_escape_string($_REQUEST['txt_list_mobno']) : ""));
  $txt_list_mobno = str_replace("\\r\\n", '', $txt_list_mobno);
  $rdo_newex_group = htmlspecialchars(strip_tags(isset($_REQUEST['rdo_newex_group']) ? $_REQUEST['rdo_newex_group'] : ""));
  $txt_sms_type = htmlspecialchars(strip_tags(isset($_REQUEST['txt_sms_type']) ? $_REQUEST['txt_sms_type'] : ""));
  $txt_group_name = urldecode($conn->real_escape_string($_REQUEST['txt_sms_content']));
  $txt_group_name = str_replace("'", "\'", $txt_group_name);
  $txt_group_name = str_replace('"', '\"', $txt_group_name);
  $txt_group_name = str_replace("\\r\\n", '\n', $txt_group_name);
  $txt_group_name = str_replace('&amp;', '&', $txt_group_name);
  $txt_group_name = str_replace(PHP_EOL, '\n', $txt_group_name);
  $txt_group_name = str_replace('\\&quot;', '"', $txt_group_name);
  $txt_group_name = str_replace('"', '\"', $txt_group_name);
  $txt_group_name = trim(preg_replace('/[ \t]+/', ' ', $txt_group_name));
  $txt_group_name = preg_replace('/\s*\n\s*/', "\n", $txt_group_name);
  $upload_contact = htmlspecialchars(strip_tags(isset($_REQUEST['upload_contact']) ? $_REQUEST['upload_contact'] : ""));
  $filename_upload = htmlspecialchars(strip_tags(isset($_REQUEST['filename_upload']) ? $_REQUEST['filename_upload'] : ""));
  $total_mobileno_count = htmlspecialchars(strip_tags(isset($_REQUEST['total_mobilenos_count']) ? $_REQUEST['total_mobilenos_count'] : ""));

  $mobile_numbers = htmlspecialchars(strip_tags(isset($_REQUEST['mobile_numbers']) ? $_REQUEST['mobile_numbers'] : ""));
  $id_slt_header = htmlspecialchars(strip_tags(isset($_REQUEST['id_slt_header']) ? $_REQUEST['id_slt_header'] : ""));
  $parts = explode("!", $id_slt_header);
  $character_count = htmlspecialchars(strip_tags(isset($_REQUEST['txt_char_count']) ? $_REQUEST['txt_char_count'] : ""));
  $txt_group_name1 = trim(htmlspecialchars(strip_tags(isset($_REQUEST['templateName']) ? $_REQUEST['templateName'] : "")));

  $msg_type = 'TEXT';
  $isSameTxt = 'false';
  if ($rdo_newex_group == 'N') {
    $isSameTxt = 'true';
  } else {
    // Define a regular expression pattern
    $pattern = '/{{(\w+)}}/';
    // Perform the regular expression match
    $matches_patterns = [];
    preg_match_all($pattern, $txt_group_name, $matches_patterns);
    // $matches[0] will contain an array of all matches
    $variable_values = $matches_patterns[0];
    // Output the count of valid numeric placeholders
    $variable_count = count($variable_values);
  }
  $file_location = $full_pathurl . "uploads/compose_variables/" . $filename_upload;
  $file_basename = basename($file_location);
  if ($file_basename === false) {
    $json = array("status" => 2, "msg" => "Error occurred while extracting file name!");
  }


  if ($samevdo == 1) {
    $variable_count--;
  }

  if ($location == '') {
    $location = '-';
  }

  if ($rdo_newex_group == 'N') {
    $replace_txt = '{
          "receiver_nos_path" : "' . $file_location . '",
          "messages":"' . $txt_group_name . '",
          "character_count":"' . $character_count . '",
          "request_id":"' . $request_id . '",
          "total_mobile_count":"' . $total_mobileno_count . '",
          "rights_name":"' . "SMPP" . '",
          "header": "' . "$parts[1]" . '",
          "txt_sms_type":"' . $txt_sms_type . '",
          "templateName":"' . $txt_group_name1 . '"
          }';
  } else {
    $replace_txt = '{
          "receiver_nos_path" : "' . $file_location . '",
          "messages":"' . $txt_group_name . '",
          "character_count":"' . $character_count . '",';
    $replace_txt .= '"request_id":"' . $request_id . '",

          "total_mobile_count":"' . $total_mobileno_count . '",
          "rights_name":"' . "SMPP" . '",
          "header": "' . "$parts[1]" . '",
          "txt_sms_type":"' . $txt_sms_type . '",
          "templateName":"' . $txt_group_name1 . '"
        }';
  }

     // Call the reusable cURL function
     $response = executeCurlRequest($api_url ."/smpp_compose", "POST", $replace_txt);

  $respobj = json_decode($response);

  $rsp_id = $respobj->response_status;

if ($respobj->response_status == 201) {
    $json = array("status" => 0, "msg" => "Failure: " . $respobj->response_msg);
  } elseif ($respobj->response_status == 200) {
    $responses = '';
    if ($respobj->invalid_count) {
      $responses .= "Invalid Count : " . $respobj->invalid_count;
    }
    ;
    $json = array("status" => 1, "msg" => "Template Created Successfully..!</br>" . $responses);
  }
}
// Compose sms Page compose_smpp - End

// send_reject_campaign_wastp - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $tmpl_call_function == "send_reject_campaign_wastp") {
  site_log_generate("send_reject_campaign_wastp Page : User : " . $_SESSION['yjucp_user_name'] . " access this page on " . date("Y-m-d H:i:s"), '../');
  // Get data
  $compose_message_id = htmlspecialchars(strip_tags(isset($_REQUEST['compose_message_id']) ? $conn->real_escape_string($_REQUEST['compose_message_id']) : ""));
  $select_user_id = htmlspecialchars(strip_tags(isset($_REQUEST['select_user_id']) ? $conn->real_escape_string($_REQUEST['select_user_id']) : ""));
  $reason = htmlspecialchars(strip_tags(isset($_REQUEST['reason']) ? $_REQUEST['reason'] : ""));
  $request_id = $_SESSION['yjucp_user_id'] . "_" . date("Y") . "" . date('z', strtotime(date("d-m-Y"))) . "" . date("His") . "_" . rand(1000, 9999);
  $replace_txt = '{
  "request_id":"' . $request_id . '",
      "selected_user_id":"' . $select_user_id . '",
      "user_id":"' . $_SESSION['yjucp_user_id'] . '",
      "compose_message_id":"' . $compose_message_id . '",
       "product_name" : "WHATSAPP",
      "reason" : "' . $reason . '"
    }';

       // Call the reusable cURL function
       $response = executeCurlRequest($api_url ."/approve_user/reject_campaign", "POST", $replace_txt);

  $respobj = json_decode($response);

  $rsp_id = $respobj->response_status;
if ($rsp_id == 201) {
    $json = array("status" => 0, "msg" => "Failure: " . $respobj->response_msg);
  
  } elseif ($rsp_id == 200) {
    $json = array("status" => 1, "msg" => "Success");
  }
}
// send_reject_campaign_wastp - End

// Approve_campaign Page send_approve_campaign_sms - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $tmpl_call_function == "send_approve_campaign_sms") {
  site_log_generate("send_approve_campaign_sms : User : " . $_SESSION['yjucp_user_name'] . " access this page on " . date("Y-m-d H:i:s"), '../');

  // Get data
  $compose_message_id = htmlspecialchars(strip_tags(isset($_REQUEST['compose_message_id']) ? $conn->real_escape_string($_REQUEST['compose_message_id']) : ""));
  $select_user_id = htmlspecialchars(strip_tags(isset($_REQUEST['select_user_id']) ? $conn->real_escape_string($_REQUEST['select_user_id']) : ""));


  $campaign_name = htmlspecialchars(strip_tags(isset($_REQUEST['campaign_name']) ? $_REQUEST['campaign_name'] : ""));

  $mobile_numbers = htmlspecialchars(strip_tags(isset($_REQUEST['mobile_numbers']) ? $_REQUEST['mobile_numbers'] : ""));
  $request_id = $_SESSION['yjucp_user_id'] . "_" . date("Y") . "" . date('z', strtotime(date("d-m-Y"))) . "" . date("His") . "_" . rand(1000, 9999);
  $mobile_number = str_replace(',', '","', $mobile_numbers);
  $replace_txt = '{
"request_id":"' . $request_id . '",
      "selected_user_id":"' . $select_user_id . '",
 "user_id":"' . $_SESSION['yjucp_user_id'] . '",
      "compose_message_id":"' . $compose_message_id . '",
      "sender_numbers" : ["' . $mobile_number . '"]
    }';
       // Call the reusable cURL function
       $response = executeCurlRequest($api_url ."/approve_user/approve_usr", "POST", $replace_txt);

  $respobj = json_decode($response);

  $rsp_id = $respobj->response_status;
if ($rsp_id == 201) {
    $json = array("status" => 0, "msg" => "Failure: " . $respobj->response_msg);
  } elseif ($rsp_id == 200) {
    $json = array("status" => 1, "msg" => "Success");
  }

}
//  Approve_campaign page send_approve_campaign_sms - end 


// Approve_campaign Page send_approve_campaign_wastp - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $tmpl_call_function == "send_approve_campaign_wastp") {
  site_log_generate("send_approve_campaign_wastp Page : User : " . $_SESSION['yjucp_user_name'] . " access this page on " . date("Y-m-d H:i:s"), '../');

  // Get data
  $select_user_id = htmlspecialchars(strip_tags(isset($_REQUEST['select_user_id']) ? $conn->real_escape_string($_REQUEST['select_user_id']) : ""));
  $compose_message_id = htmlspecialchars(strip_tags(isset($_REQUEST['compose_message_id']) ? $conn->real_escape_string($_REQUEST['compose_message_id']) : ""));
  $campaign_name = htmlspecialchars(strip_tags(isset($_REQUEST['campaign_name']) ? $_REQUEST['campaign_name'] : ""));

  $mobile_numbers = htmlspecialchars(strip_tags(isset($_REQUEST['mobile_numbers']) ? $_REQUEST['mobile_numbers'] : ""));
  $request_id = $_SESSION['yjucp_user_id'] . "_" . date("Y") . "" . date('z', strtotime(date("d-m-Y"))) . "" . date("His") . "_" . rand(1000, 9999);
  $mobile_number = str_replace(',', '","', $mobile_numbers);
  $replace_txt = '{
"request_id":"' . $request_id . '",
   "selected_user_id":"' . $select_user_id . '",
      "user_id":"' . $_SESSION['yjucp_user_id'] . '",
      "compose_whatsapp_id":"' . $compose_message_id . '",
      "sender_numbers" : ["' . $mobile_number . '"]
    }';

        // Call the reusable cURL function
        $response = executeCurlRequest($api_url ."/approve_user/approve_wtsp", "POST", $replace_txt);

  $respobj = json_decode($response);
  $rsp_id = $respobj->response_status;
if ($rsp_id == 201) {
    $json = array("status" => 0, "msg" => "Failure: " . $respobj->response_msg);

  } elseif ($rsp_id == 200) {
    $json = array("status" => 1, "msg" => "Success");
  }

}
//  Approve_campaign page send_approve_campaign_wastp - end 

// send_reject_campaign_sms - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $tmpl_call_function == "send_reject_campaign_sms") {
  site_log_generate("send_reject_campaign_sms Page : User : " . $_SESSION['yjucp_user_name'] . " access this page on " . date("Y-m-d H:i:s"), '../');
  // Get data
  $compose_message_id = htmlspecialchars(strip_tags(isset($_REQUEST['compose_message_id']) ? $conn->real_escape_string($_REQUEST['compose_message_id']) : ""));
  $select_user_id = htmlspecialchars(strip_tags(isset($_REQUEST['select_user_id']) ? $conn->real_escape_string($_REQUEST['select_user_id']) : ""));
  $reason = htmlspecialchars(strip_tags(isset($_REQUEST['reason']) ? $_REQUEST['reason'] : ""));
  $request_id = $_SESSION['yjucp_user_id'] . "_" . date("Y") . "" . date('z', strtotime(date("d-m-Y"))) . "" . date("His") . "_" . rand(1000, 9999);
  $replace_txt = '{
"request_id":"' . $request_id . '",
    "selected_user_id":"' . $select_user_id . '",
    "user_id":"' . $_SESSION['yjucp_user_id'] . '",
    "compose_message_id":"' . $compose_message_id . '",
    "product_name" : "GSM SMS",
    "reason" : "' . $reason . '"
  }';

      // Call the reusable cURL function
      $response = executeCurlRequest($api_url ."/approve_user/reject_campaign", "POST", $replace_txt);

  $respobj = json_decode($response);

  $rsp_id = $respobj->response_status;
if ($rsp_id == 201) {
    $json = array("status" => 0, "msg" => "Failure: " . $respobj->response_msg);
  } elseif ($rsp_id == 200) {
    $json = array("status" => 1, "msg" => "Success");
  }
}
// send_reject_campaign_sms - End

// purchase_sms_credit Page purchase_sms_credit - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $tmpl_call_function == "purchase_sms_credit") {
  site_log_generate("Purchase SMS Credit Page : User : " . $_SESSION['yjucp_user_name'] . " Purchase SMS Credit - access this page on " . date("Y-m-d H:i:s"), '../');
  // Get data
  $txt_pricing_plan = htmlspecialchars(strip_tags(isset($_REQUEST["txt_pricing_plan"]) ? $conn->real_escape_string($_REQUEST["txt_pricing_plan"]) : ""));
  $txt_message_amount = htmlspecialchars(strip_tags(isset($_REQUEST["txt_message_amount"]) ? $conn->real_escape_string($_REQUEST["txt_message_amount"]) : ""));
  $usrcrdbt_comments = htmlspecialchars(strip_tags(isset($_REQUEST["usrcrdbt_comments"]) ? $conn->real_escape_string($_REQUEST["usrcrdbt_comments"]) : "-"));

  $slt_expiry_date = 12; // 12 Months
  $exp_date = date("Y-m-d H:i:s", strtotime('+' . $slt_expiry_date . ' month'));
  $expl = explode("~~", $txt_pricing_plan);

  // $paid_status = 'A';
  //$paid_status_cmnts = "Direct Approval. Collect the Money from them, before Credit the Messages";
  if ($_SESSION['yjucp_user_master_id'] != 1) {

    $paid_status = 'W';
    $paid_status_cmnts = 'Direct Approval. Collect the Money from them, before Credit the Messages';
  }

  $usr_credit_id = isset($_POST['usr_credit_id']) ? $_POST['usr_credit_id'] : '';

  // Prepare JSON payload based on the presence of usr_credit_id
  if (!empty($usr_credit_id)) {
    $replace_txt = '{
        "user_id" : "' . $_SESSION['yjucp_user_id'] . '",
        "parent_id" : "' . $_SESSION['yjucp_parent_id'] . '",
        "pricing_slot_id" : "' . $expl[1] . '",
        "exp_date" : "' . $exp_date . '",
        "slt_expiry_date" : "' . $slt_expiry_date . '",
        "raise_sms_credits" : "' . $expl[3] . '",
        "sms_amount" : "' . $hdsms . '",
        "usr_credit_id" : "' . $usr_credit_id . '",
        "paid_status_cmnts" : "' . $paid_status_cmnts . '",
        "paid_status" : "' . $paid_status . '",
        "usrcrdbt_comments" : "' . $usrcrdbt_comments . '"
    }';
  } else {
    $replace_txt = '{
        "user_id" : "' . $_SESSION['yjucp_user_id'] . '",
        "parent_id" : "' . $_SESSION['yjucp_parent_id'] . '",
        "pricing_slot_id" : "' . $expl[1] . '",
        "exp_date" : "' . $exp_date . '",
        "slt_expiry_date" : "' . $slt_expiry_date . '",
        "raise_sms_credits" : "' . $expl[3] . '",
        "sms_amount" : "' . $hdsms . '",
        "paid_status_cmnts" : "' . $paid_status_cmnts . '",
        "paid_status" : "' . $paid_status . '",
        "usrcrdbt_comments" : "' . $usrcrdbt_comments . '"
    }';
  }
      // Call the reusable cURL function
      $response = executeCurlRequest($api_url ."/purchase_credit/user_credit_raise", "POST", $replace_txt);

  $sms = json_decode($response, false);

  if ($sms->response_status == 200) {
    $json = array("status" => 1, "msg" => "Success");
  } else {
    $json = array("status" => 0, "msg" => "Data not inserted. Kindly try again!!");
  }
}
// purchase_sms_credit Page purchase_sms_credit - End

// Message Page save_senderid - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $tmpl_call_function == "save_senderid") {
  site_log_generate("save_senderid Page : User : " . $_SESSION['yjucp_user_name'] . " access this page on " . date("Y-m-d H:i:s"), '../');
  // Get data
  $slt_operator = htmlspecialchars(strip_tags(isset($_REQUEST['slt_operator']) ? $_REQUEST['slt_operator'] : ""));
  $dlt_process = htmlspecialchars(strip_tags(isset($_REQUEST['dlt_process']) ? $_REQUEST['dlt_process'] : ""));
  $slt_template_type = htmlspecialchars(strip_tags(isset($_REQUEST['slt_template_type']) ? $_REQUEST['slt_template_type'] : ""));
  $license_docs = htmlspecialchars(strip_tags(isset($_REQUEST['license_docs']) ? $_REQUEST['license_docs'] : ""));
  $slt_business_category = htmlspecialchars(strip_tags(isset($_REQUEST['slt_business_category']) ? $_REQUEST['slt_business_category'] : ""));
  $header_sender_id = htmlspecialchars(strip_tags(isset($_REQUEST['header_sender_id']) ? $_REQUEST['header_sender_id'] : ""));
  $txt_explanation = htmlspecialchars(strip_tags(isset($_REQUEST['txt_explanation']) ? $_REQUEST['txt_explanation'] : ""));
  $ex_new_senderid = htmlspecialchars(strip_tags(isset($_REQUEST['ex_new_senderid']) ? $_REQUEST['ex_new_senderid'] : ""));
  $txt_constempname = htmlspecialchars(strip_tags(isset($_REQUEST['txt_constempname']) ? $_REQUEST['txt_constempname'] : ""));
  $txt_consbrndname = htmlspecialchars(strip_tags(isset($_REQUEST['txt_consbrndname']) ? $_REQUEST['txt_consbrndname'] : ""));
  $txt_consmsg = htmlspecialchars(strip_tags(isset($_REQUEST['txt_consmsg']) ? $_REQUEST['txt_consmsg'] : ""));
  if ($obj->num_of_rows > 0) {
    $json = array("status" => 0, "msg" => "This Title already used. Kindly try with some others!!");
  } else {
    // File Upload - Start
    if (isset($_FILES['license_docs']['name'])) {
      /* Getting file name */
      $filename = $_SESSION['yjucp_user_id'] . "_" . $milliseconds . "_" . $_FILES['license_docs']['name'];

      /* Location */
      $location = "../uploads/license/" . $filename;
      $imageFileType = pathinfo($location, PATHINFO_EXTENSION);
      $imageFileType = strtolower($imageFileType);

      /* Valid extensions */
      $valid_extensions = array("pdf", "png", "jpg", "jpeg");

      $response = '';
      /* Check file extension */
      if (in_array(strtolower($imageFileType), $valid_extensions)) {
        /* Upload file */
        if (move_uploaded_file($_FILES['license_docs']['tmp_name'], $location)) {
          $response = $location;
        }
      }
    }

    // File Upload - Start
    if (isset($_FILES['consent_docs']['name'])) {
      /* Getting file name */
      $filename1 = $_SESSION['yjucp_user_id'] . "_" . ($milliseconds + 10) . "_" . $_FILES['consent_docs']['name'];

      /* Location */
      $location1 = "../uploads/consent/" . $filename1;
      $imageFileType1 = pathinfo($location1, PATHINFO_EXTENSION);
      $imageFileType1 = strtolower($imageFileType1);

      /* Valid extensions */
      $valid_extensions1 = array("pdf", "png", "jpg", "jpeg");

      $response1 = 0;
      /* Check file extension */
      if (in_array(strtolower($imageFileType1), $valid_extensions1)) {
        /* Upload file */
        if (move_uploaded_file($_FILES['consent_docs']['tmp_name'], $location1)) {
          $response1 = $location1;
        }
      }
    }

    $replace_txt = '{
    "user_id" : "' . $_SESSION['yjucp_user_id'] . '",
    "slt_operator" : "' . $slt_operator . '",
    "dlt_process" : "' . $dlt_process . '",
    "slt_template_type" : "' . $slt_template_type . '",
    "slt_business_category" : "' . $slt_business_category . '",
    "header_sender_id" : "' . $header_sender_id . '",
    "txt_explanation" : "' . $txt_explanation . '",
     "ex_new_senderid" : "' . $ex_new_senderid . '",
     "filename" : "' . $filename . '",
     "filename1":  "' . $filename1 . '",
     "request_id" : "'.$request_id .'",
     "txt_constempname":  "' . $txt_constempname . '",
     "txt_consbrndname":  "' . $txt_consbrndname . '",
     "txt_consmsg":  "' . $txt_consmsg . '"
}';

    // Call the reusable cURL function
    $response = executeCurlRequest($api_url ."/template/save_senderid", "POST", $replace_txt);

    $obj_1 = json_decode($response);

    if ($response != '') {
  // Call the reusable cURL function
  $response = executeCurlRequest($api_url ."/list/sender_business_category", "POST", $replace_txt);
        $obj = json_decode($response);

        if ($obj->num_of_rows > 0) {
          for ($indicator = 0; $indicator < $obj->num_of_rows; $indicator++) {
            $display_business = $obj->result[$indicator]->business_category;
          }
        }
        $json = array("status" => 1, "msg" => "Success");

    } else {
      site_log_generate("Message Page : User : " . $_SESSION['yjucp_user_name'] . " Save Sender ID Failed [File cannot upload] on " . date("Y-m-d H:i:s"), '../');
      $json = array("status" => 0, "msg" => "File cannot upload. Kindly try again!");
    }
  }
}
// Message Page save_senderid - End


// Message Page cmnts_senderid - Start 
if ($_SERVER['REQUEST_METHOD'] == "POST" and $tmpl_call_functions == "cmnts_senderid" and $_SESSION['yjucp_user_master_id'] == 1) {
  // Get data
  site_log_generate("cmnts_senderid Page : User : " . $_SESSION['yjucp_user_name'] . " access the page - Comments on " . date("Y-m-d H:i:s"), '../');
  $senderid = htmlspecialchars(strip_tags(isset($_REQUEST['senderid']) ? $_REQUEST['senderid'] : ""));
  $apprej_status = htmlspecialchars(strip_tags(isset($_REQUEST['apprej_status']) ? $_REQUEST['apprej_status'] : ""));
  $apprej_cmnts = htmlspecialchars(strip_tags(isset($_REQUEST['apprej_cmnts']) ? $_REQUEST['apprej_cmnts'] : ""));
  $aprg_hdrid = htmlspecialchars(strip_tags(isset($_REQUEST['aprg_hdrid']) ? $_REQUEST['aprg_hdrid'] : ""));

  $replace_txt = '{
    "user_id" : "' . $_SESSION['yjucp_user_id'] . '",
    "senderid" : "' . $senderid . '",
     "apprej_status" : "' . $apprej_status . '",
     "apprej_cmnts" : "' . $apprej_cmnts . '",
     "aprg_hdrid":  "' . $aprg_hdrid . '"
}';

    // Call the reusable cURL function
    $response = executeCurlRequest($api_url ."/list/cmnts_senderid", "POST", $replace_txt);

  $obj = json_decode($response);


  // Check if there are any results in the 'result' array
  if (!empty($obj->result) && count($obj->result) > 0) {

       // Call the reusable cURL function
       $response = executeCurlRequest($api_url ."/list/update_cmnts_senderid", "POST", $replace_txt);
    $obj_1 = json_decode($response);

    if ($response && $apprej_status != 'P') {
      $stts_display = ($data['apprej_status'] === 'Y') ? 'Approved' : 'Rejected';
      $json = array("status" => 1, "msg" => "Success");
    }

  } else {
    $json = array("status" => 0, "msg" => "This Sender ID not available. Kindly try with some others!!");
  }
}
// Message Page cmnts_senderid - End 

//cmnts_consentid - start
if ($_SERVER['REQUEST_METHOD'] == "POST" && $tmpl_call_functions == "cmnts_consentid" && $_SESSION['yjucp_user_master_id'] == 1) {
  site_log_generate("cmnts_consentid Page : User : " . $_SESSION['yjucp_user_name'] . " Consent Comments accessed this page on " . date("Y-m-d H:i:s"), '../');
  // Get and sanitize data
  $consentid = htmlspecialchars(strip_tags($_REQUEST['consentid'] ?? ""));
  $apprej_status = htmlspecialchars(strip_tags($_REQUEST['apprej_status'] ?? ""));
  $apprej_cmnts = htmlspecialchars(strip_tags($_REQUEST['apprej_cmnts'] ?? ""));

  $replace_txt = '{
    "user_id" : "' . $_SESSION['yjucp_user_id'] . '",
    "consentid" : "' . $consentid . '",
    "apprej_status" : "' . $apprej_status . '",
    "apprej_cmnts" : "' . $apprej_cmnts . '"
}';

  // Call the reusable cURL function
  $response = executeCurlRequest($api_url ."/list/cmnts_consentid", "POST", $replace_txt);
  $obj = json_decode($response);
  if (!empty($obj->result) && count($obj->result) > 0) {
    // Second API call - Update Consent Information
  $response = executeCurlRequest($api_url ."/list/update_cmnts_consentid", "POST", $replace_txt);
    // Decode the JSON response
    $obj_1 = json_decode($response);
    // Check for JSON decode errors
    if (json_last_error() !== JSON_ERROR_NONE) {
      site_log_generate("JSON Decode Error on Update: " . json_last_error_msg(), '../');
    } elseif ($obj_1 !== null) {
      site_log_generate("Decoded Update Response: " . var_export($obj_1, true), '../');
      if ($apprej_status != 'P') {
        $stts_display = $apprej_status == 'Y' ? 'Approved' : 'Rejected';
      }
      $json = array("status" => 1, "msg" => "Success");
    } else {
      $json = array("status" => 0, "msg" => "Invalid Inputs. Kindly try again with the correct Inputs!");
    }
  } else {
    $json = array("status" => 0, "msg" => "This Sender ID not available. Kindly try with some others!!");
  }
}
//cmnts_consentid - end


// Message Page save_templateid - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $tmpl_call_functions == "save_templateid") {
  site_log_generate("save_templateid Page : User : " . $_SESSION['yjucp_user_name'] . " access this page on " . date("Y-m-d H:i:s"), '../');
  // Get data
  //$cn_template_type = htmlspecialchars(strip_tags(isset($_REQUEST['cn_template_type']) ? $_REQUEST['cn_template_type'] : ""));
  $t_cm_sender_id = htmlspecialchars(strip_tags(isset($_REQUEST['t_cm_sender_id']) ? $_REQUEST['t_cm_sender_id'] : "NULL"));
  $t_cm_consent_id = htmlspecialchars(strip_tags(isset($_REQUEST['t_cm_consent_id']) ? $_REQUEST['t_cm_consent_id'] : "NULL"));
  $cn_msgtype = htmlspecialchars(strip_tags(isset($_REQUEST['cn_msgtype']) ? $_REQUEST['cn_msgtype'] : ""));
  $cn_template_name = htmlspecialchars(strip_tags(isset($_REQUEST['cn_template_name']) ? $_REQUEST['cn_template_name'] : ""));
  $cn_message = htmlspecialchars(strip_tags(isset($_REQUEST['cn_message']) ? $_REQUEST['cn_message'] : ""));
  $exist_new_template = htmlspecialchars(strip_tags(isset($_REQUEST['exist_new_template']) ? $_REQUEST['exist_new_template'] : ""));

  $replace_txt = '{
    "user_id" : "' . $_SESSION['yjucp_user_id'] . '",
    "t_cm_sender_id" : "' . $t_cm_sender_id . '",
    "t_cm_consent_id" : "' . $t_cm_consent_id . '",
    "cn_msgtype" : "' . $cn_msgtype . '",
    "cn_template_name" : "' . $cn_template_name . '",
    "cn_message" : "' . $cn_message . '",
    "exist_new_template" : "' . $exist_new_template . '"
}';

 // Call the reusable cURL function
 $response = executeCurlRequest($api_url ."/template/save_templateid", "POST", $replace_txt);

  // Decode the response
  $obj = json_decode($response);

  // Check for success or failure based on response_code or response_status
  if (isset($obj->response_code) && $obj->response_code == 1) {
    $json = array("status" => 1, "msg" => "Success");
  } else {
    $json = array("status" => 0, "msg" => $obj->response_msg ?? "This Title already used. Kindly try with some others!!");
  }
}

// Message Page save_templateid - End

// Message Page cmnts_contentid - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" && $tmpl_call_functions == "cmnts_contentid" && $_SESSION['yjucp_user_master_id'] == 1) {
  site_log_generate("cmnts_contentid Page : User : " . $_SESSION['yjucp_user_name'] . " accessed Content Comments page on " . date("Y-m-d H:i:s"), '../');

  // Gather and sanitize input data
  $contentid = htmlspecialchars(strip_tags($_REQUEST['contentid'] ?? ""));
  $apprej_status = htmlspecialchars(strip_tags($_REQUEST['apprej_status'] ?? ""));
  $apprej_cmnts = htmlspecialchars(strip_tags($_REQUEST['apprej_cmnts'] ?? ""));
  $aprg_cmstid = htmlspecialchars(strip_tags($_REQUEST['aprg_cmstid'] ?? ""));

  // Build JSON payload
  $replace_txt = '{
    "user_id" : "' . $_SESSION['yjucp_user_id'] . '",
    "contentid" : "' . $contentid . '",
    "apprej_status" : "' . $apprej_status . '",
    "apprej_cmnts" : "' . $apprej_cmnts . '",
    "aprg_cmstid" : "' . $aprg_cmstid . '"
  }';

 // Call the reusable cURL function
 $response = executeCurlRequest($api_url ."/list/cmnts_contentid", "POST", $replace_txt);

  // Decode and process response
  $obj = json_decode($response);
  if ($obj && isset($obj->response_code) && $obj->response_code === 1) {
 // Call the reusable cURL function
 $response = executeCurlRequest($api_url ."/list/update_cmnts_contentid", "POST", $replace_txt);

    $update_obj = json_decode($update_response);
    if ($update_obj && isset($update_obj->response_code) && $update_obj->response_code === 1) {
      $json = ["status" => 1, "msg" => "Success"];
    } else {
      $json = ["status" => 0, "msg" => "Failed to save Content Comments. Please check inputs."];
    }
  } else {
    // Handle error scenario when the content is not available or invalid
    $json = ["status" => 0, "msg" => "This Content Not Available. Try with others."];
  }
}
// Message Page cmnts_contentid - End


// Compose Whatsapp Page delete_senderid - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $tmpl_call_function == "delete_senderid") {
  // Get data
  site_log_generate("delete_senderid Page : User : " . $_SESSION['yjucp_user_name'] . " accessed Content Comments page on " . date("Y-m-d H:i:s"), '../');
  $whatspp_config_id1 = htmlspecialchars(strip_tags(isset($_REQUEST['whatspp_config_id']) ? $conn->real_escape_string($_REQUEST['whatspp_config_id']) : ""));
  $approve_status1 = htmlspecialchars(strip_tags(isset($_REQUEST['approve_status']) ? $conn->real_escape_string($_REQUEST['approve_status']) : ""));
$reject_reason = htmlspecialchars(strip_tags(isset($_REQUEST['reject_reason']) ? $conn->real_escape_string($_REQUEST['reject_reason']) : ""));

  // To Send the request  API
  $replace_txt = '{
   "whatspp_config_id" : "' . $whatspp_config_id1 . '",
"request_id" : "'.$request_id .'",
"reject_reason" : "'.$reject_reason.'"
 }';
  // Call the reusable cURL function
  $response = executeCurlRequest($api_url ."/sender_id/delete_sender_id", "DELETE", $replace_txt);

  // After got response decode the JSON result
  $header = json_decode($response, false);

  // To get the one by one data
  if ($header->response_code == 1) { // If the response is success to execute this condition
    $json = array("status" => 1, "msg" => $header->response_msg);
  } else if ($header->response_status == 204) {
    $json = array("status" => 2, "msg" => $header->response_msg);
  } else {
    $json = ["status" => 0, "msg" => "Failed"];
  }
}
// Compose Whatsapp Page delete_senderid - Start


// Approve Page save_phbabt - Start
if($_SERVER['REQUEST_METHOD'] == "POST" and $tmpl_call_function == "save_phbabt") {
  // Get data
  site_log_generate("save_phbabt Page : User : " . $_SESSION['yjucp_user_name'] . " accessed Content Comments page on " . date("Y-m-d H:i:s"), '../');
 $whatspp_config_id		= htmlspecialchars(strip_tags(isset($_REQUEST['whatspp_config_id']) ? $conn->real_escape_string($_REQUEST['whatspp_config_id']) : ""));
 $fieldname  		= htmlspecialchars(strip_tags(isset($_REQUEST['fieldname']) ? $conn->real_escape_string($_REQUEST['fieldname']) : ""));
 $fieldvalue  		= htmlspecialchars(strip_tags(isset($_REQUEST['fieldvalue']) ? $conn->real_escape_string($_REQUEST['fieldvalue']) : ""));
 $whatspp_config_id1		= htmlspecialchars(strip_tags(isset($_REQUEST['whatspp_config_id']) ? $conn->real_escape_string($_REQUEST['whatspp_config_id']) : ""));
 $approve_status1  		= htmlspecialchars(strip_tags(isset($_REQUEST['approve_status']) ? $conn->real_escape_string($_REQUEST['approve_status']) : ""));
 $phone_number_id		= htmlspecialchars(strip_tags(isset($_REQUEST['phone_number_id']) ? $conn->real_escape_string($_REQUEST['phone_number_id']) : ""));
 $whatsapp_business_acc_id  		= htmlspecialchars(strip_tags(isset($_REQUEST['whatsapp_business_acc_id']) ? $conn->real_escape_string($_REQUEST['whatsapp_business_acc_id']) : ""));
 $bearer_token_value		= htmlspecialchars(strip_tags(isset($_REQUEST['bearer_token_value']) ? $conn->real_escape_string($_REQUEST['bearer_token_value']) : ""));
 $mobile_no  		= htmlspecialchars(strip_tags(isset($_REQUEST['mobile_number']) ? $conn->real_escape_string($_REQUEST['mobile_number']) : ""));

 $replace_txt = '{
         "user_id":"'.$_SESSION['yjucp_user_id'].'",
         "mobile_number": "'.$mobile_no.'",
         "phone_number_id": "'.$phone_number_id.'",
         "whatsapp_business_acc_id": "'.$whatsapp_business_acc_id.'",
         "bearer_token": "'.$bearer_token_value.'",
"request_id" : "'.$request_id .'"
       }';
  // Call the reusable cURL function
  $response = executeCurlRequest($api_url ."/sender_id/approve_wht_senderid", "POST", $replace_txt);

   // After got response decode the JSON result
 $yjresponseobj = json_decode($response, false);

 if($yjresponseobj->response_status == 204){ //otherwise
   $json = array("status" => 1, "msg" => $yjresponseobj->response_msg);
 }else {
   $json = ["status" => 0, "msg" => $yjresponseobj->response_msg];
 } 
}
// Approve Page save_phbabt - Start


// Compose Whatsapp Page approve_whatsappno - Start
if($_SERVER['REQUEST_METHOD'] == "POST" and $tmpl_call_function == "approve_whatsappno") {
  // Get data
  site_log_generate("approve_whatsappno Page : User : " . $_SESSION['yjucp_user_name'] . " accessed Content Comments page on " . date("Y-m-d H:i:s"), '../');

$whatspp_config_id1		= htmlspecialchars(strip_tags(isset($_REQUEST['whatspp_config_id']) ? $conn->real_escape_string($_REQUEST['whatspp_config_id']) : ""));
$reject_reason  		= htmlspecialchars(strip_tags(isset($_REQUEST['reject_reason']) ? $conn->real_escape_string($_REQUEST['reject_reason']) : ""));
   // To Send the request API
  $replace_txt = '{
    "user_id" : "'.$_SESSION['yjucp_user_id'].'",
    "whatsapp_config_id" : "'.$whatspp_config_id1.'",
    "reject_reason": "'.$reject_reason.'"
  }';
 
    // Call the reusable cURL function
    $response = executeCurlRequest($api_url ."/whsp_process/approve_whatsappno", "PUT", $replace_txt);

  // After got response decode the JSON result
  $sms = json_decode($response, false);
  
  if ($sms->response_msg  == 'Success') { // If the response is success to execute this condition
    $json = array("status" => 1, "msg" =>  $yjresponseobj->reponse_msg );
  }
  else if($sms->response_status == 204){ //otherwise
    $json = array("status" => 1, "msg" => $sms->response_msg);
  }else {
    $json = ["status" => 0, "msg" => $sms->response_msg];
  } 
}

// Compose Whatsapp Page approve_whatsappno - Start


// Create Template Preview Page - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $preview_functions == "preview_template" ) {
  site_log_generate("preview_template Page : User : " . $_SESSION['yjucp_user_name'] . " accessed Content Comments page on " . date("Y-m-d H:i:s"), '../');

  // To get the one by one data
  foreach ($button_url_text as $btn_txt_url) {
   $btn_txt_url_name .= $btn_txt_url;
 }
 foreach ($button_text as $btn_txt) {
   $btn_txt_name .= $btn_txt;
 }
 foreach ($button_quickreply_text as $txt_button_qr_txt) {
   $txt_button_qr_text1 .= '"' . $txt_button_qr_txt . '"' . ',';
 }
  $button_quickreply_text = $_POST['button_quickreply_text'];
 
  foreach ($reply_arr as $reply_arr1) {
   $reply_array_content = $reply_arr1;
 }
 
 foreach ($button_txt_phone_no as $btn_txt_phn) {
   $btn_txt_phn_no .= $btn_txt_phn;
 }
 foreach ($website_url as $web_url) {
   $web_url_link .= $web_url;
 
 }
 
   $stateData = '';
   $stateData_box = '';
   $hdr_type = '';
   if($_SERVER['REQUEST_METHOD'] == "POST"){ // // If the response is success to execute this condition
    if ($header) { // header variable
     
         switch ($header) {
           case ('TEXT'):  // text
             $hdr_type .= "<input type='hidden' name='hid_txt_header_variable' id='hid_txt_header_variable' value='". $txt_header_name ."'>";
 
             $stateData_1 = '';
             $stateData_1 = $txt_header_name;
             $stateData_2 = $stateData_1;
 
             $matches = null;
             $prmt = preg_match_all("/{{[0-9]+}}/", $txt_header_name, $matches);
             $matches_a0 = $matches[0];
             rsort($matches_a0);
             sort($matches_a0);
             for ($ij = 0; $ij < count($matches_a0); $ij++) {
   // Looping the ij is less than the count of matches_a0. if the condition is true to continue the process.if the condition is false to stop the process
               $expl2 = explode("{{", $matches_a0[$ij]);
               $expl3 = explode("}}", $expl2[1]);
               $stateData_box = "</div><div style='float:left; padding: 0 5px;'> <input type='text' readonly tabindex='10' name='txt_header_variable[$expl3[0]][]' id='txt_header_variable' placeholder='{{" . $expl3[0] . "}} Value' title='Header Text' maxlength='20' value='-' style='width:100px;height: 30px;cursor: not-allowed;' class='form-control required'> </div><div style='float: left;'>";
               $stateData_1 = str_replace("{{" . $expl3[0] . "}}", $stateData_box, $stateData_1);
               $stateData_2 = $stateData_1;
             }
 
             if ($stateData_2 != '') {
               $stateData .= "<div style='float:left; clear:both; line-height: 36px;'><div style='float:left; line-height: 36px;'>Header : </div><div style='float:left'>" . $stateData_2 . "</div></div>";
             }
             break;
 
 
           case ($media_category == 'document'): // document
             $stateData .= "<div style='float:left; clear:both; line-height: 36px;'><div style='float:left; line-height: 36px;'>Header : </div> <div style='margin-left:60px;'><i class='fa fa-file-text' style='font-size: 18px'></i> <span> DOCUMENT</span>
             </div>
                 </div>
               </div>
               </div></div>";
             break;
 
 
           case ($media_category == 'image' ): // image
             $stateData .= "<div style='float:left; clear:both; line-height: 36px;'><div style='float:left; line-height: 36px;'>Header : </div><div style='margin-left:60px;'><i class='fa fa-image' style='font-size: 18px'></i> <span> IMAGE</span></div>
                   <span class='input-group-addon'><i class='icofont icofont-ui-messaging'></i></span>
                 </div>
               </div>
               </div></div>";
             break;
 
 
           case $media_category == 'video': // video
           
             $stateData .= "<div style='float:left; clear:both; line-height: 36px;'><div style='float:left; line-height: 36px;'>Header :</div> <div style='margin-left:60px;'><i cl// header variableass='fa fa-play-circle' style='font-size: 18px'></i> <span> VIDEO</span>
             </div>
                   <span class='input-group-addon'><i class='icofont icofont-ui-messaging'></i></span>
                 </div>
               </div>
               </div></div>";
             break;
         }
       }
 
       if ($textarea) { // body variable
         $hdr_type .= "<input type='hidden' name='hid_txt_body_variable' id='hid_txt_body_variable' value='" . $textarea . "'>";
 
         $stateData_1 = '';
         $stateData_1 = $textarea;
         $stateData_2 = $stateData_1;
 
         $matches = null;
         $prmt = preg_match_all("/{{[0-9]+}}/", $textarea, $matches);
         $matches_a1 = $matches[0];
         rsort($matches_a1);
         sort($matches_a1);
         for ($ij = 0; $ij < count($matches_a1); $ij++) {
  // Looping the ij is less than the count of matches_a1. if the condition is true to continue the process.if the condition is false to stop the process
           $expl2 = explode("{{", $matches_a1[$ij]);
           $expl3 = explode("}}", $expl2[1]);
           $stateData_box = "</div><div style='float:left; padding: 0 5px;'> <input type='text' readonly name='txt_body_variable[$expl3[0]][]' id='txt_body_variable' placeholder='{{" . $expl3[0] . "}} Value' maxlength='20' title='Enter {{" . $expl3[0] . "}} Value' value='-' style='width:100px;height: 30px;cursor: not-allowed;' class='form-control required'> </div><div style='float: left;'>";
           $stateData_1 = str_replace("{{" . $expl3[0] . "}}", $stateData_box, $stateData_1);
           $stateData_2 = $stateData_1;
         }
 
         if ($stateData_2 != '') {
           $stateData .= "<div style='float:left; clear:both; line-height: 36px;'><div style='float:left; line-height: 36px;'>Body : </div><div style='float:left'>" . $stateData_2 . "</div></div>";
         }     
       }
 
       if ($select_action5 =  'VISIT_URL' || ($select_action1 = 'PHONE_NUMBER' || $select_action3 = 'PHONE_NUMBER') && $select_action == 'QUICK_REPLY' ) {
         $stateData_2 = '';
         if ($select_action5 =  'VISIT_URL' && $web_url_link ) {
           $stateData_2 .= "<a href='" . $web_url_link . "' target='_blank'>" . $btn_txt_url_name . "</a>";
           $stateData .= "<div style='float:left; clear:both; line-height: 36px;'><div style='float:left; line-height: 36px;'>Buttons URL : </div><div style='float:left'>" . $web_url_link . " - " . $stateData_2 . "</div></div>";
         }
 
         if (($select_action1 = 'PHONE_NUMBER' || $select_action3 = 'PHONE_NUMBER') && $btn_txt_phn_no) {
           $stateData_2 .= $country_code . " - " . $btn_txt_phn_no;
           $stateData .= "<div style='float:left; clear:both; line-height: 36px;'><div style='float:left; line-height: 36px;'>Buttons Phone No. : </div><div style='float:left'>" . $stateData_2 . "</div></div>";
         }
 
         for ($kk = 0; $kk < count($button_quickreply_text); $kk++) {
  // Looping the kk is less than the count of button_quickreply_text. if the condition is true to continue the process.if the condition is false to stop the process
           if ($select_action == 'QUICK_REPLY') {
             $stateData_2 = $button_quickreply_text[$kk];
             $stateData .= "<div style='float:left; clear:both; line-height: 36px;'><div style='float:left; line-height: 36px;'>Buttons Quick Reply : </div><div style='float:left'>" . $stateData_2 . "</div></div>";
           }
         }
       }
       if ($txt_footer_name) { // Footer 
         $hdr_type .= "<input type='hidden' name='hid_txt_footer_variable' id='hid_txt_footer_variable' value='" . $txt_footer_name . "'>";
 
         $stateData_2 = '';
         $stateData_2 = $txt_footer_name;
 
         if ($stateData_2 != '') {
           $stateData .= "<div style='float:left; clear:both; line-height: 36px;'><div style='float:left; line-height: 36px;'>Footer : </div><div style='float:left'>" . $stateData_2 . "</div></div>";
         }
       }

         $json = array("status" => 1, "msg" => $stateData . $hdr_type);
     }
     else {    // otherwise
     $json = array("status" => 0, "msg" => '-');
   }
   
 }
  //Create Template Preview Page - END
 
  // Compose Whatsapp Page approve_template - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $tmpl_call_function == "approve_template") {
  // Get data
  site_log_generate("approve_template Page : User : " . $_SESSION['yjucp_user_name'] . " accessed Content Comments page on " . date("Y-m-d H:i:s"), '../');
  $template_id1 = htmlspecialchars(strip_tags(isset($_REQUEST['unique_template_id']) ? $conn->real_escape_string($_REQUEST['unique_template_id']) : ""));
  $approve_status1 = htmlspecialchars(strip_tags(isset($_REQUEST['template_status']) ? $conn->real_escape_string($_REQUEST['template_status']) : ""));
  $reject_reason = htmlspecialchars(strip_tags(isset($_REQUEST['reject_reason']) ? $conn->real_escape_string($_REQUEST['reject_reason']) : ""));

  // To Send the request API
  $replace_txt = '{
    "user_id" : "' . $_SESSION['yjucp_user_id'] . '",
    "change_status" : "' . $approve_status1 . '",
    "template_id" : "' . $template_id1 . '"';

if($approve_status1 == "R"){
  $replace_txt .= ',"reject_reason" : "' . $reject_reason . '"';
}

 $replace_txt .= '}' ;
     // Call the reusable cURL function
     $response = executeCurlRequest($api_url ."/whsp_process/approve_reject_template", "POST", $replace_txt);

  // After got response decode the JSON result  
  $header = json_decode($response, false);

  if ($header->response_code == 1) { // If the response is success to execute this condition
    $json = array("status" => 1, "msg" => $header->response_msg);
  } else if ($header->response_status == 204) { //otherwise
    $json = array("status" => 1, "msg" => $header->response_msg);
  } else {
    $json = ["status" => 0, "msg" => $header->response_msg];
  }
}
// Compose Whatsapp Page approve_template - Start

 
// compose_whatsapp Page compose_whatsapp - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $tmpl_call_function == "compose_whatsapp") {

  site_log_generate("Compose Whatsapp Page : Login User  " . $_SESSION['yjucp_user_name'] . " access this page on " . date("Y-m-d H:i:s"), '../');
  // Get data
  $upload_contact = htmlspecialchars(strip_tags(isset($_REQUEST['upload_contact']) ? $_REQUEST['upload_contact'] : ""));
  $filename_upload = htmlspecialchars(strip_tags(isset($_REQUEST['filename_upload']) ? $_REQUEST['filename_upload'] : ""));
  $total_mobileno_count = htmlspecialchars(strip_tags(isset($_REQUEST['total_mobilenos_count']) ? $_REQUEST['total_mobilenos_count'] : ""));
  $mobile_numbers = htmlspecialchars(strip_tags(isset($_REQUEST['mobile_numbers']) ? $_REQUEST['mobile_numbers'] : ""));
  $character_count = htmlspecialchars(strip_tags(isset($_REQUEST['character_count']) ? $_REQUEST['character_count'] : ""));
  // Get data
  $id_slt_mobileno = htmlspecialchars(strip_tags(isset($_REQUEST['id_slt_mobileno']) ? $_REQUEST['id_slt_mobileno'] : "0"));
  $contact_mgtgrp_id = htmlspecialchars(strip_tags(isset($_REQUEST['contact_mgtgrp_id']) ? $_REQUEST['contact_mgtgrp_id'] : ""));
  $expl_id_slt_mobileno = explode('||', $id_slt_mobileno);
  $id_slt_mobileno = $expl_id_slt_mobileno[2];
  $wht_tmplsend_url = $expl_id_slt_mobileno[3];
  $wht_tmpl_url = $expl_id_slt_mobileno[1];
  $wht_bearer_token = $expl_id_slt_mobileno[0];
  $filename = '';
  $character_count = htmlspecialchars(strip_tags(isset($_REQUEST['txt_char_count']) ? $_REQUEST['txt_char_count'] : "1"));

  $expl_wht = explode("~~", $txt_whatsapp_mobno[0]);
  $storeid = $expl_wht[0];
  $confgid = $expl_wht[1];

  if (isset($txt_header_variable)) {
    for ($i1 = 1; $i1 <= count($txt_header_variable); $i1++) {
    // Looping the i1 is less than the count of txt_header_variable.if the condition is true to continue the process.if the condition are false to stop the process
      $stateData_1 = '';
      $stateData_1 = $hid_txt_header_variable;

      $matches = null;
      $prmt = preg_match_all("/{{[0-9]+}}/", $hid_txt_header_variable, $matches);
      $matches_a0 = $matches[0];
      rsort($matches_a0);
      sort($matches_a0);
// Looping  with in the looping the ij is less than the count of matches_a0.if the condition is true to continue the process.if the condition are false to stop the process
      for ($ij = 0; $ij < count($matches_a0); $ij++) {
        $expl2 = explode("{{", $matches_a0[$ij]);
        $expl3 = explode("}}", $expl2[1]);
        $stateData_1 = str_replace("{{" . $expl3[0] . "}}", $txt_header_variable[$i1][0], $stateData_1);
      }

      $header_details = $stateData_1;
    }
  }

  $matches_a1 = [];
  if (isset($txt_body_variable)) {
    $path_parts = pathinfo($_FILES["fle_variable_csv"]["name"]);
    $extension = $path_parts['extension'];
    $filename = $_SESSION['yjucp_user_id'] . "_csv_" . $milliseconds . "." . $extension;
    /* Location */
    $location = "../uploads/compose_variables/" . $filename;
    $imageFileType = pathinfo($location, PATHINFO_EXTENSION);
    $imageFileType = strtolower($imageFileType);

    /* Valid extensions */
    $valid_extensions = array("csv");
    $response = 0;
    /* Check file extension */
    if (in_array(strtolower($imageFileType), $valid_extensions)) {
      /* Upload file */
      if (move_uploaded_file($_FILES['fle_variable_csv']['tmp_name'], $location)) {
        $response = $location;
      }
    }

    $csvFile = fopen($location, 'r') or die("can't open file");
    // Skip the first line
    $vrble = '[';
    // Parse data from CSV file line by line
    while (($line = fgetcsv($csvFile)) !== FALSE) {
      $vrble .= "[";
      // Get row data
      $tmp = '';
      for ($txt_variable_counti = 0; $txt_variable_counti <= $txt_variable_count; $txt_variable_counti++) {
   // Looping the txt_variable_counti is less than the count of txt_variable_counti.if the condition is true to continue the process.if the condition are false to stop the process
        if ($txt_variable_counti > 0) {
          if ($line[$txt_variable_counti] == '') {
            $tmp .= '"' . $default_variale_msg . '", ';
          } else {
            $tmp .= '"' . $line[$txt_variable_counti] . '", ';
          }
        }
      }
      $tmp = rtrim($tmp, ", ");
      $vrble .= $tmp . "], ";
    }
    $vrble = rtrim($vrble, ", ");
    $vrble = $vrble . "]";
    // Close opened CSV file
    fclose($csvFile);

    $body_vrble = $vrble;
  }

  if ($_FILES['txt_media']['name'] != '') { // file name
    $path_parts = pathinfo($_FILES["txt_media"]["name"]);
    $extension = $path_parts['extension'];
    $filename = $_SESSION['yjucp_user_id'] . "_" . $milliseconds . "." . $extension;

    /* Location */
    $location = "../uploads/whatsapp_media/" . $filename;
    $send_location = realpath($_SERVER["DOCUMENT_ROOT"]) . "/whatsapp/uploads/whatsapp_media/" . $filename;
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
      case 'gif':
        $mime_type = "image/gif";
        break;

      case 'pdf':
        $mime_type = "application/pdf";
        break;
      case 'mp4':
        $mime_type = "video/mp4";
        break;
      case 'webm':
        $mime_type = "video/webm";
        break;
    }

    /* Valid extensions */
    $valid_extensions = array("jpg", "jpeg", "png", "pdf", "gif", "mp4", "webm");

    $rspns = '';
    /* Upload file */
    if (move_uploaded_file($_FILES['txt_media']['tmp_name'], $location)) {
      $rspns = $location;
    }
    // }
  } else {
    $filename = '';
  }

  // Sender Mobile Numbers
  $sender_mobile_nos = '';
  for ($i1 = 0; $i1 < count($txt_whatsapp_mobno); $i1++) {
 // Looping the i1 is less than the count of txt_whatsapp_mobno.if the condition is true to continue the process.if the condition are false to stop the process
    $ex1 = explode('~~', $txt_whatsapp_mobno[$i1]);
    $sender_mobile_nos .= $ex1[2] . ',';
  }
  $sender_mobile_nos = rtrim($sender_mobile_nos, ",");

    // Send Whatsapp Message - Start
    $tmpl_name1 = explode('!', $slt_whatsapp_template);
    $curl_get = $wht_tmpl_url . "/message_templates?name=" . $tmpl_name1[0] . "&language=" . $tmpl_name1[1] . "&access_token=" . $wht_bearer_token;
    //Submit to server
    $yjresponse = file_get_contents($curl_get);
    $yjresponseobj = json_decode($yjresponse, false);

    $whatsapp_tmpl_hdtext = '';
    $whatsapp_tmpl_body = '';
    $whatsapp_tmpl_footer = '';
    $whtsap_send = '';

    if ($yjresponseobj->data[0]->components[0]->type == 'HEADER') { // header
      switch ($yjresponseobj->data[0]->components[0]->format) {
        case 'TEXT':
          if (isset($txt_header_variable)) {
            if (count($txt_header_variable) > 0) {
              $whtsap_send .= '[
                                    {
                                        "type": "HEADER",
                                        "parameters": [
                                            {
                                                "type": "text",
                                                "text": "' . $txt_header_variable[1][0] . '"
                                            }
                                        ]
                                    },';
            }
          } else {
            $whtsap_send .= '""';
          }
          break;

        case 'DOCUMENT': // document
          if (isset($_FILES['file_document_header']['name']) or $file_document_header_url != '') {
            $whtsap_send .= '[
                                    {
                                        "type": "HEADER",
                                        "parameters": [
                                            {
                                                "type": "document",';

            if (isset($_FILES['file_document_header']['name'])) {

              $filename = $_SESSION['yjucp_user_id'] . "_" . $milliseconds . "_" . $_FILES['file_document_header']['name'];

              /* Location */
              $location = "../uploads/whatsapp_docs/" . $filename;
              $imageFileType = pathinfo($location, PATHINFO_EXTENSION);
              $imageFileType = strtolower($imageFileType);

              /* Valid extensions */
              $valid_extensions = array("pdf");

              $rspns = '';
              /* Check file extension */
              if (in_array(strtolower($imageFileType), $valid_extensions)) {
                /* Upload file */
                if (move_uploaded_file($_FILES['file_document_header']['tmp_name'], $location)) {
                  $rspns = $location;
                }
              }

              $whtsap_send .= '"document": {
                                                  "link": "' . $site_url . 'uploads/whatsapp_docs/' . $filename . '",
                                                  "filename": "File PDF"
                                              }';

            } elseif ($file_document_header_url != '') {
              $whtsap_send .= '"document": {
                                                  "link": "' . $file_document_header_url . '",
                                                  "filename": "File PDF"
                                              }';
            }

            $whtsap_send .= ' }
                              ]
                          },';
          }
          break;

        case 'IMAGE': // image
          if (isset($_FILES['file_image_header']['name']) or $file_image_header_url != '') {
            $whtsap_send .= '[
                                  {
                                      "type": "HEADER",
                                      "parameters": [
                                          {
                                              "type": "image",';

            if (isset($_FILES['file_image_header']['name'])) {

              $filename = $_SESSION['yjucp_user_id'] . "_" . $milliseconds . "_" . $_FILES['file_image_header']['name'];

              /* Location */
              $location = "../uploads/whatsapp_images/" . $filename;
              $imageFileType = pathinfo($location, PATHINFO_EXTENSION);
              $imageFileType = strtolower($imageFileType);

              /* Valid extensions */
              $valid_extensions = array("png", "jpg", "jpeg");

              $rspns = '';
              /* Check file extension */
              if (in_array(strtolower($imageFileType), $valid_extensions)) {
                /* Upload file */
                if (move_uploaded_file($_FILES['file_image_header']['tmp_name'], $location)) {
                  $rspns = $location;
                }
              }

              $whtsap_send .= '"image": {
                                              "link": "' . $site_url . 'uploads/whatsapp_images/' . $filename . '"
                                          }';

            } elseif ($file_image_header_url != '') {
              $whtsap_send .= '"image": {
                                              "link": "' . $file_image_header_url . '"
                                          }';
            }

            $whtsap_send .= ' }
                              ]
                          },';
          }
          break;

        case 'VIDEO': // video
          if (isset($_FILES['file_video_header']['name']) or $file_video_header_url != '') {
            $whtsap_send .= '[
                                  {
                                      "type": "HEADER",
                                      "parameters": [
                                          {
                                              "type": "video",';

            if (isset($_FILES['file_video_header']['name'])) {

              $filename = $_SESSION['yjucp_user_id'] . "_" . $milliseconds . "_" . $_FILES['file_video_header']['name'];

              /* Location */
              $location = "../uploads/whatsapp_videos/" . $filename;
              $imageFileType = pathinfo($location, PATHINFO_EXTENSION);
              $imageFileType = strtolower($imageFileType);

              /* Valid extensions */
              $valid_extensions = array("mp4");

              $rspns = '';
              /* Check file extension */
              if (in_array(strtolower($imageFileType), $valid_extensions)) {
                /* Upload file */
                if (move_uploaded_file($_FILES['file_video_header']['tmp_name'], $location)) {
                  $rspns = $location;
                }
              }
              $whtsap_send .= '"video": {
                                              "link": "' . $site_url . 'uploads/whatsapp_videos/' . $filename . '"
                                          }';

            } elseif ($file_video_header_url != '') {
              $whtsap_send .= '"video": {
                                              "link": "' . $file_video_header_url . '"
                                          }';
            }

            $whtsap_send .= ' }
                            ]
                        },';
          }
          break;

        default:
          $whtsap_send .= '[
                  {
                      "type": "HEADER",
                      "parameters": [
                          {
                              "type": "text",
                              "text": "' . $hid_txt_header_variable . '"
                          }
                      ]
                  },
                  {
                    "type": "BODY",
                    "parameters": [
                        {
                            "type": "text",
                            "text": "' . $hid_txt_body_variable . '"
                        }
                    ]
                  },';
//echo "!!";
          break;
      }
      $whtsap_send = rtrim($whtsap_send, ",");
      $whtsap_send .= ']';

      if ($yjresponseobj->data[0]->components[1]->type == 'BODY') { // body
        if (count($matches_a1) > 0) {
          $whtsap_send .= '{
                                  "type": "BODY",
                                  "parameters": [ ';

          for ($ij1 = 1; $ij1 <= count($matches_a1); $ij1++) {
 // Looping the ij1 is less than the matches_a1.if the condition is true to continue the process.if the condition are false to stop the process
            $whtsap_send .= '{
                                    "type": "text",
                                    "text": "' . $txt_body_variable[$ij1][0] . '"
                                }';
            if ($ij1 != count($matches_a1)) {
              $whtsap_send .= ',';
            }
          }

          $whtsap_send .= ']
                        }]';
        }
      } else {
        $whtsap_send .= '
                    ]';
      }

      $whatsapp_tmpl_hdtext = $header_details;
      $whatsapp_tmpl_body = $body_details;
      $whatsapp_tmpl_footer = $yjresponseobj->data[0]->components[2]->text;
    }

    if ($yjresponseobj->data[0]->components[0]->type == 'BODY') { // body
//echo "@@";
      if (isset($matches_a1)) {
        if (count($matches_a1) > 0) {
          $whtsap_send .= '[
                                {
                                  "type": "BODY",
                                  "parameters": [';

          for ($ij1 = 1; $ij1 <= count($matches_a1); $ij1++) {
 // Looping the ij1 is less than the matches_a1.if the condition is true to continue the process.if the condition are false to stop the process
            $whtsap_send .= '{
                                    "type": "text",
                                    "text": "' . $txt_body_variable[$ij1][0] . '"
                                }';
            if ($ij1 != count($matches_a1)) {
              $whtsap_send .= ',';
            }
          }

          $whtsap_send .= ']
                        }]';
        } else {
          $whtsap_send .= '""';
        }
      }

    }

    $whtsap_send = rtrim($whtsap_send, ",");
    $whtsap_send = str_replace('""', '[]', $whtsap_send);
    $whatsapp_tmpl_body = $whtsap_send;
    $expld1 = explode("!", $slt_whatsapp_template);
      if($whtsap_send == '[]]'){
            $whtsap_send = str_replace('""','[]]',"[]");
                   }

  $msg_type = 'TEXT';
  $isSameTxt = 'false';
  if ($rdo_newex_group == 'N') {
    $isSameTxt = 'true';
  } else {
    // Define a regular expression pattern
    $pattern = '/{{(\w+)}}/';
    // Perform the regular expression match
    $matches_patterns = [];
    preg_match_all($pattern, $txt_group_name, $matches_patterns);
    // $matches[0] will contain an array of all matches
    $variable_values = $matches_patterns[0];
    // Output the count of valid numeric placeholders
    $variable_count = count($variable_values);
  }

  $file_location = $full_pathurl . "uploads/compose_variables/" . $filename_upload;
  $file_basename = basename($file_location);
  if ($file_basename === false) {
    $json = array("status" => 2, "msg" => "Error occurred while extracting file name!");
  }

  if ($txt_variable_count > 0) {
    $sendto_api .= '{
                     
                      "user_id":"' . $_SESSION['yjucp_user_id'] . '",
                      "sender_numbers":[' . $sender_mobile_nos . '],
                      "components":' . $whtsap_send . ',
                      "template_id":"' . $expld1[3] . '",
                      "variable_values":' . $body_vrble . ',
                       "rights_name":"' . "Whatsapp" . '",
"request_id" : "'.$request_id .'"';
  } else {
    $sendto_api .= '{
                     
                      "user_id":"' . $_SESSION['yjucp_user_id'] . '",
                      "sender_numbers":[' . $sender_mobile_nos . '],
                      "components":' . $whtsap_send . ',
                      "template_id":"' . $expld1[3] . '",
                      "rights_name":"' . "Whatsapp" . '",
                      "request_id" : "'.$request_id .'"';
  }

  if(!$filename_upload){
    $sendto_api .= ',"group_id" :"'.$contact_mgtgrp_id.'"';
    }else{
      $sendto_api .= ',"total_mobile_count":"' . $total_mobileno_count . '"
                       ,"receiver_nos_path" : "' . $file_location . '"';
    }

    $sendto_api .= '}';

    // Call the reusable cURL function
    $response = executeCurlRequest($api_url ."/whatsapp_compose", "POST", $sendto_api);

    // After got response decode the JSON result
  $respobj = json_decode($response);
  $rsp_id = $respobj->response_status;
if ($respobj->response_status == 201) {
    $json = array("status" => 0, "msg" => "Failure: " . $respobj->response_msg);
  } elseif ($respobj->response_status == 200) {
    $responses = '';
    if ($respobj->invalid_count) {
      $responses .= "Invalid Count : " . $respobj->invalid_count;
    };
    $json = array("status" => 1, "msg" => "Template Created Successfully..!</br>" . $responses);
  }
}
//  compose_whatsapp Page compose_whatsapp - End


// Compose reject_campaign_whatsapp Page reject_campaign_whatsapp - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $tmpl_call_function == "approve_reject_campaign_Whatsapp") {
  // Get data
  $compose_message_id = htmlspecialchars(strip_tags(isset($_REQUEST['compose_message_id']) ? $conn->real_escape_string($_REQUEST['compose_message_id']) : ""));
  $approve_status1 = htmlspecialchars(strip_tags(isset($_REQUEST['approve_status']) ? $conn->real_escape_string($_REQUEST['approve_status']) : ""));
  $selected_userid = htmlspecialchars(strip_tags(isset($_REQUEST['selected_userid']) ? $conn->real_escape_string($_REQUEST['selected_userid']) : ""));
  $reason = htmlspecialchars(strip_tags(isset($_REQUEST['reason']) ? $_REQUEST['reason'] : ""));

  // To Send the request API
  $replace_txt = '{
      "user_id" : "' . $_SESSION['yjucp_user_id'] . '",
      "compose_message_id" : "' . $compose_message_id . '",
      "selected_userid" : "' . $selected_userid . '"';
    
    if($reason && ($approve_status1 == 'R')){
      
      $replace_txt .= ',"campaign_status" : "' . $approve_status1 . '",
      "reason" : "' .$reason . '"
     }';

        // Call the reusable cURL function
   $response = executeCurlRequest($api_url . "/reject_campaign_whatsapp", "PUT", $replace_txt);


    }else{
      $replace_txt .= ',"request_id" : "'.$request_id .'",
      "rights_name":"' . "Whatsapp" . '"
      }';

        // Call the reusable cURL function
   $response = executeCurlRequest($api_url . "/approve_whatsapp", "POST", $replace_txt);

    }

  $respobj = json_decode($response);
  $rsp_id = $respobj->response_status;
if ($respobj->response_status == 201) {
    $json = array("status" => 0, "msg" => "Failure: " . $respobj->response_msg);

  } elseif ($respobj->response_status == 200) {
    $json = array("status" => 1, "msg" => "Success");
  }
}
// reject_campaign_whatsapp reject_campaign_whatsapp - end

// Messenger Reply Page messenger_reply - Start
if($_SERVER['REQUEST_METHOD'] == "POST" and $tmpl_call_function == "messenger_reply") {
   // Get data
   site_log_generate("Messenger Reply Page : User : ".$_SESSION['yjucp_user_name']." access this page on ".date("Y-m-d H:i:s"), '../');

    $txt_reply				= htmlspecialchars(strip_tags(isset($_REQUEST['txt_reply']) ? $conn->real_escape_string($_REQUEST['txt_reply']) : ""));
    $receiver_mobile	= htmlspecialchars(strip_tags(isset($_REQUEST['message_to']) ? $conn->real_escape_string($_REQUEST['message_to']) : ""));
    $sender_id				= htmlspecialchars(strip_tags(isset($_REQUEST['sender_id']) ? $conn->real_escape_string($_REQUEST['sender_id']) : ""));
    $message_from		= htmlspecialchars(strip_tags(isset($_REQUEST['message_from']) ? $conn->real_escape_string($_REQUEST['message_from']) : ""));
    // To Send the request API
    $send_reply = '{
        "user_id":"'.$_SESSION['yjucp_user_id'].'",
        "sender_mobile":"'.$sender_id.'",
        "receiver_mobile":"'.$message_to.'",
        "reply_msg":"'.$txt_reply.'",
  "request_id" : "'.$request_id .'"
      }';

        // Call the reusable cURL function
   $response = executeCurlRequest($api_url . "/message/reply_message", "POST", $send_reply);

     // After got response decode the JSON result
    $yjresponseobj = json_decode($response, false);
    
    if($yjresponseobj->response_status == 200) {// If the response is success to execute this condition
      $json = array("status" => 1, "msg" => $yjresponseobj->response_msg);
    }else if($yjresponseobj->response_status == 204){ //otherwise
      $json = array("status" => 1, "msg" => $yjresponseobj->response_msg);
    }else {

      $json = array("status" => 0, "msg" => "Failed while saving the Reply!!");
    } 
  }
  // Messenger Reply Page messenger_reply - Start



//generate_report_whatsapp -> start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $tmpl_call_function == "generate_report_whatsapp") {
  // Get data
  site_log_generate("generate_report_whatsapp Page : User : ".$_SESSION['yjucp_user_name']." access this page on ".date("Y-m-d H:i:s"), '../');

  $compose_whatsapp_id = htmlspecialchars(strip_tags(isset($_REQUEST['compose_whatsapp_id']) ? $conn->real_escape_string($_REQUEST['compose_whatsapp_id']) : ""));
  $user_id = htmlspecialchars(strip_tags(isset($_REQUEST['user_id']) ? $conn->real_escape_string($_REQUEST['user_id']) : ""));

  // File moved successfully
  $replace_txt = '{
                "user_id" : "' . $_SESSION['yjucp_user_id'] . '",
                "compose_user_id" : "' . $user_id . '",
                "compose_id" : "' . $compose_whatsapp_id . '"
            }';

               // Call the reusable cURL function
   $response = executeCurlRequest($api_url . "/report/generate_report_whatsapp", "POST", $replace_txt);

  $respobj = json_decode($response);

  $rsp_id = $respobj->response_status;
if ($respobj->response_status == 201) {
    $json = array("status" => 0, "msg" => "Failure: " . $respobj->response_msg);
  } elseif ($respobj->response_status == 200) {
    $json = array("status" => 1, "msg" => "Success");
  }
}
// generate_report_whatsapp - End

// Finally Close all Opened Mysql DB Connection
$conn->close();

// Output header with JSON Response
header('Content-type: application/json');
echo json_encode($json);