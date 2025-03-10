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
session_start(); // start session
error_reporting(E_ALL); // The error reporting function
include_once('../api/configuration.php'); // Include configuration.php
include_once "../api/send_request.php"; // Include send_request.php
extract($_REQUEST); // Extract the request
$milliseconds = round(microtime(true) * 1000); // milliseconds in time
$request_id = $_SESSION['yjucp_user_id'] . "_" . date("Y") . 
    str_pad((new DateTime())->diff(new DateTime(date("Y") . "-01-01"))->days + 1, 3, '0', STR_PAD_LEFT) . 
    date("His") . "_" . rand(100, 999);


// Template List Page remove_template - Start
if (isset($_GET['tmpl_call_function']) == "remove_template") {
  // Get data
  $template_response_id = htmlspecialchars(strip_tags(isset($_REQUEST['template_response_id']) ? $conn->real_escape_string($_REQUEST['template_response_id']) : ""));
  $change_status = htmlspecialchars(strip_tags(isset($_REQUEST['change_status']) ? $conn->real_escape_string($_REQUEST['change_status']) : ""));
  // To Send the request  API
  $replace_txt = '{
    "template_id" : "' . $template_response_id . '",
    "request_id" : "'.$request_id .'",
    "rights_name" : "SMS"
  }';
 // Call the reusable cURL function
 $response = executeCurlRequest($api_url . "/delete_template", "PUT", $replace_txt);
  // After got response decode the JSON result
  $json = processResponse($response);
}
// Template List Page remove_template - End


// Template List Page tmpl_call_function remove_template_smpp - Start
if (isset($_GET['tmpl_call_function_smpp']) == "remove_template_smpp") {
  // Get data
  $template_response_id = htmlspecialchars(strip_tags(isset($_REQUEST['template_response_id']) ? $conn->real_escape_string($_REQUEST['template_response_id']) : ""));
  $change_status = htmlspecialchars(strip_tags(isset($_REQUEST['change_status']) ? $conn->real_escape_string($_REQUEST['change_status']) : ""));
  // To Send the request  API
  $replace_txt = '{
    "template_id" : "' . $template_response_id . '",
    "request_id" : "'.$request_id .'",
    "rights_name": "SMPP"
  }';

   // Call the reusable cURL function
 $response = executeCurlRequest($api_url . "/list/delete_template_smpp", "DELETE", $replace_txt);
  // After got response decode the JSON result
  $json = processResponse($response);
}
// Template List Page remove_template_smpp - End


// copy_file Page copy_file - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $storecopy_file == "copy_file") {
  site_log_generate("copy_file Page : User : " . $_SESSION['yjucp_user_name'] . " " . date("Y-m-d H:i:s"), '../');
  // Check if the request contains the copied file

  if (isset($_FILES['copiedFile']) && $_FILES['copiedFile']['error'] === UPLOAD_ERR_OK) {

    // Get the file information
    $path_parts = pathinfo($_FILES["copiedFile"]["name"]);
    $extension = $path_parts['extension'];
    $filename = $_SESSION['yjucp_user_id'] . "_file_" . $milliseconds . "." . $extension;
    /* Location */
    $location = "../uploads/group_contact/" . $filename;
    $file_location = $full_pathurl . "uploads/group_contact/" . $filename;

    $location_1 = "../uploads/compose_variables/" . $filename;
    $file_location_1 = $full_pathurl . "uploads/compose_variables/" . $filename;

    $imageFileType = strtolower(pathinfo($location, PATHINFO_EXTENSION));
    $valid_extensions = array("csv", "txt"); // Allow both CSV and TXT files

    $response = 0;
    if (in_array(strtolower($imageFileType), $valid_extensions)) {
      /* Upload file */
      if (move_uploaded_file($_FILES['copiedFile']['tmp_name'], $location)) {
        // Copy the file to backup location
        if (copy($location, $location_1)) {
          $response = $location; // You can set this to any of the locations
          $response = $location_1;
          // Set file permissions
          chmod($filename, 0644);
          $csvFile = fopen($location, 'r') or die("can't open file");
          $json = array("status" => 1, "msg" => "File uploaded successfully", "file_location" => $file_location);
        } else {
          $json = array("status" => 0, "msg" => "Failed to copy the uploaded file to backup location");
        }
      } else {
        $json = array("status" => 0, "msg" => "Failed to move the uploaded file");
      }
    } else {
      $json = array("status" => 0, "msg" => "Invalid file extension. Only CSV files are allowed.");
    }
  } else {
    $json = array("status" => 0, "msg" => "No file uploaded or an error occurred during upload");
  }
  // Output JSON response
  header('Content-Type: application/json');
}
// copy_file copy_file - end



// copy_file Page in Compose SMPP  - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $storecopy_file == "copy_file_smpp") {
  site_log_generate("copy_file Page : User : " . $_SESSION['yjucp_user_name'] . " " . date("Y-m-d H:i:s"), '../');
  // Check if the request contains the copied file

  if (isset($_FILES['copiedFile']) && $_FILES['copiedFile']['error'] === UPLOAD_ERR_OK) {

    // Get the file information
    $path_parts = pathinfo($_FILES["copiedFile"]["name"]);
    $extension = $path_parts['extension'];
    $filename = $_SESSION['yjucp_user_id'] . "_file_" . $milliseconds . "." . $extension;
    $location = "../uploads/group_contact/" . $filename;
    $file_location = $full_pathurl . "uploads/group_contact/" . $filename;

    $location_1 = "../uploads/compose_variables/" . $filename;
    $file_location_1 = $full_pathurl . "uploads/compose_variables/" . $filename;

    $imageFileType = strtolower(pathinfo($location, PATHINFO_EXTENSION));
    $valid_extensions = array("csv", "txt"); // Allow both CSV and TXT files

    $response = 0;
    /* Check file extension */
    if (in_array(strtolower($imageFileType), $valid_extensions)) {
      /* Upload file */
      if (move_uploaded_file($_FILES['copiedFile']['tmp_name'], $location)) {
        // Copy the file to backup location
        if (copy($location, $location_1)) {
          $response = $location; // You can set this to any of the locations
          $response = $location_1;
          // Set file permissions
          chmod($filename, 0644);
          $csvFile = fopen($location, 'r') or die("can't open file");
          $json = array("status" => 1, "msg" => "File uploaded successfully", "file_location" => $file_location);
        } else {
          $json = array("status" => 0, "msg" => "Failed to copy the uploaded file to backup location");
        }
      } else {
        $json = array("status" => 0, "msg" => "Failed to move the uploaded file");
      }
    } else {
      $json = array("status" => 0, "msg" => "Invalid file extension. Only CSV files are allowed.");
    }
  } else {
    $json = array("status" => 0, "msg" => "No file uploaded or an error occurred during upload");
  }
  // Output JSON response
  header('Content-Type: application/json');
}
// copy_file in compose_SMPP - end


// Create Template create_template - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $temp_call_function == "create_template") {
  // Get data
  $categories = htmlspecialchars(strip_tags(isset($_REQUEST['categories']) ? $conn->real_escape_string($_REQUEST['categories']) : ""));
  $textarea = isset($_REQUEST['textarea']) ? $conn->real_escape_string($_REQUEST['textarea']) : '';
  $textarea = htmlspecialchars(strip_tags(str_replace(["'", '"', "\\r\\n", '\&quot;'], ["\'", '\"', '\n', '"'], $textarea)));

  $txt_header_name = htmlspecialchars(strip_tags(isset($_REQUEST['txt_header_name']) ? $conn->real_escape_string($_REQUEST['txt_header_name']) : ""));
  $txt_footer_name = htmlspecialchars(strip_tags(isset($_REQUEST['txt_footer_name']) ? $conn->real_escape_string($_REQUEST['txt_footer_name']) : ""));
  $media_category = htmlspecialchars(strip_tags(isset($_REQUEST['media_category']) ? $conn->real_escape_string($_REQUEST['media_category']) : ""));
  $txt_header_variable = htmlspecialchars(strip_tags(isset($_REQUEST['txt_header_variable']) ? $conn->real_escape_string($_REQUEST['txt_header_variable']) : ""));
   // To get the one by one data from the array
  foreach ($lang as $lang_id) {
    $langid .= $lang_id . "";
  }
  $language = explode("-", $langid);
  $language_code = $language[0];
  $language_id = $language[1];
if($language_code == 'en_GB' || $language_code == 'en_US'  ){
    $code .= "t";
  }else{
    $code .= "l";
  }
  $user_id = $_SESSION['yjucp_user_id'];
  foreach ($select_action1 as $slt_action1) {
    $slt_action_1 .= '"' . $slt_action1 . '"';
  }
  foreach ($select_action4 as $slt_action4) {
    $slt_action_4 .= '"' . $slt_action4 . '"';
  }
  foreach ($select_action5 as $slt_action5) {
    $slt_action_5 .= '"' . $slt_action5 . '"';
  }
  foreach ($select_action3 as $slt_action3) {
    $slt_action_3 .= '"' . $slt_action3 . '"';
  }
  foreach ($website_url as $web_url) {
    $web_url_link .= $web_url;

  }
  foreach ($button_url_text as $btn_txt_url) {
    $btn_txt_url_name .= $btn_txt_url;

  }
  foreach ($button_txt_phone_no as $btn_txt_phn) {
    $btn_txt_phn_no .= $btn_txt_phn;

  }
  foreach ($button_text as $btn_txt) {
    $btn_txt_name .= $btn_txt;

  }
  foreach ($txt_sample as $txt_variable) {
    $txt_sample_variable .= '"' . $txt_variable . '"' . ',';

  }
  $txt_variable = rtrim($txt_sample_variable, ",");
  foreach ($button_quickreply_text as $txt_button_qr_txt) {
    $txt_button_qr_text1 .= '"' . $txt_button_qr_txt . '"' . ',';
  }
  $txt_button_qr_text = explode(",", $txt_button_qr_text1);
  $txt_button_qr_text_1 = $txt_button_qr_text[0];
  $txt_button_qr_text_2 = $txt_button_qr_text[1];
  $txt_button_qr_text_3 = $txt_button_qr_text[2];

  $reply_arr = array();  // Initialize the array for quick replies

  // Add quick replies if the text variables are not empty and strip any unwanted quotes
  if (!empty($txt_button_qr_text_1)) {
      $reply_arr[] = array("type" => "QUICK_REPLY", "text" => trim($txt_button_qr_text_1, '"'));
  }
  if (!empty($txt_button_qr_text_2)) {
      $reply_arr[] = array("type" => "QUICK_REPLY", "text" => trim($txt_button_qr_text_2, '"'));
  }
  if (!empty($txt_button_qr_text_3)) {
      $reply_arr[] = array("type" => "QUICK_REPLY", "text" => trim($txt_button_qr_text_3, '"'));
  }
  
  // Convert the array to a JSON string
  $reply_array_content = json_encode($reply_arr, JSON_UNESCAPED_UNICODE);  // JSON_UNESCAPED_UNICODE avoids escaping non-ASCII characters
 /* $reply_arr = array();
  if ($txt_button_qr_text_1) {
    $reply_array .= '
  {"type":"QUICK_REPLY","text":' . $txt_button_qr_text_1 . '}';
    array_push($reply_arr, $reply_array);

  }
  if ($txt_button_qr_text_2) {
    $reply_array .= ',
  {"type":"QUICK_REPLY", "text":' . $txt_button_qr_text_2 . '}';
    array_push($reply_arr, $reply_array);
  }
  if ($txt_button_qr_text_3) {
    $reply_array .= ',
  {"type":"QUICK_REPLY", "text": ' . $txt_button_qr_text_3 . '}';
    array_push($reply_arr, $reply_array);
  }

  foreach ($reply_arr as $reply_arr1) {
    $reply_array_content = $reply_arr1;
  }*/
  
// select option to get the value
    $selectOption = $_POST['header'];
    $select_action = $_POST['select_action'];
    $select_action1 = $_POST['select_action1'];
    $select_action2 = $_POST['select_action2'];
    $select_action3 = $_POST['select_action3'];
    $select_action4 = $_POST['select_action4'];
    $select_action5 = $_POST['select_action5'];
    $country_code = $_POST['country_code'];
    // define the value
    $whtsap_send = '';
    $add_url_btn = '';
    $add_phoneno_btn = '';

    if ($textarea && $txt_variable) { // TextArea with Body Variable

      $whtsap_send .= '[
    {
      "type":"BODY", 
      "text":"' . $textarea . '",
      "example":{"body_text":[[' . $txt_variable . ']]}
  }';
    }
    if ($textarea && !$txt_variable) { // Only Textarea
      $whtsap_send .= '[ { 
                          "type": "BODY",
                          "text": "' . $textarea . '"
                        }';

    }
    if ($selectOption == 'TEXT') { // Text using Header Text
      switch ($selectOption == 'TEXT') {

        case $txt_header_name && !$txt_header_variable:
   $code .=  "h";
          $whtsap_send .= ', 
        {
            "type":"HEADER", 
            "format":"TEXT",
            "text":"' . $txt_header_name . '"
        }';
break;
        case $txt_header_name && $txt_header_variable: // Using Header Variable
 $code .= "h";
          $whtsap_send .= ', 
        {
            "type":"HEADER", 
            "format":"TEXT",
            "text":"' . $txt_header_name . '",
            "example":{"header_text":["' . $txt_header_variable . '"]}
        }';
break;
 default:
            # code...
            break;
      }
    }
else{
    
      $code .= "0";
    }

  if($selectOption == 'MEDIA'){ // Media
    switch ($media_category) {
      case 'image':
        $code .= "i00";
        break;
        case 'video':
          $code .= "0v0";
          break;
          case 'document':
            $code .= "00d";
            break;
            default:
            # code...
            break;
      }
    }
    else{  
      $code .= "000";
    }
// VISIT_URL
    if ($select_action5 == "VISIT_URL" && $btn_txt_url_name && $web_url_link) {
      $add_url_btn .= ',
                                      {
                                              "type":"URL", "text": "' . $btn_txt_url_name . '","url":"' . $web_url_link . '"
                                      }';

    } // PHONE_NUMBER
    if ($select_action4 == "PHONE_NUMBER" && $btn_txt_name && $btn_txt_phn_no && $country_code) {
      $add_phoneno_btn .= ',
                                        {"type":"PHONE_NUMBER","text":"' . $btn_txt_name . '","phone_number":"' . $country_code . '' . $btn_txt_phn_no . '" }';

    }
    // PHONE_NUMBER with add anothor button 
    if ($select_action1 == "PHONE_NUMBER" && $btn_txt_name && $btn_txt_phn_no && $country_code && $add_url_btn) {

      $code .= "cu"; // PHONE_NUMBER
    }else if ($select_action1 == "PHONE_NUMBER" && $btn_txt_name && $btn_txt_phn_no && $country_code) {
      $code .= "c0"; // VISIT_URL
    }else if($select_action1 == "VISIT_URL" && $btn_txt_url_name && $web_url_link && $add_phoneno_btn){
      $code .= "cu";
    } // VISIT_URL
    else if($select_action1 == "VISIT_URL" && $btn_txt_url_name && $web_url_link){
      $code .= "0u";
    }
    else{
      
      $code .= "00";
    } // quickreply
   if ($select_action == "QUICK_REPLY") {
      if ($txt_button_qr_text_1) {
        $code .= "r";
      }
    }
    else{
    
      $code .= "0";
    }
    if ($txt_footer_name) { // footer
 $code .= "f";
      $whtsap_send .= ', 							
                      {
                        "type":"FOOTER", 
                        "text":"' . $txt_footer_name . '"
                    }';

    }else{
  
      $code .= "0";
    } // PHONE_NUMBER and add url button
    if ($select_action1 == "PHONE_NUMBER" && $btn_txt_name && $btn_txt_phn_no && $country_code && $add_url_btn) {

      $whtsap_send .= ',
                                    {
                                      "type":"BUTTONS",
                                      "buttons":[{"type":"PHONE_NUMBER","text":"' . $btn_txt_name . '","phone_number":"' . $country_code . '' . $btn_txt_phn_no . '"} ' . $add_url_btn . ' ]
                                  
                                   }';
                                   // PHONE_NUMBER 
    } else if ($select_action1 == "PHONE_NUMBER" && $btn_txt_name && $btn_txt_phn_no && $country_code) {

      $whtsap_send .= ',
                                      {
                                        "type":"BUTTONS",
                                        "buttons":[{"type":"PHONE_NUMBER","text":"' . $btn_txt_name . '","phone_number":"' . $country_code . '' . $btn_txt_phn_no . '"}]
                                    
                                      }';
    }
// VISIT_URL and add phone number button
    if ($select_action1 == "VISIT_URL" && $btn_txt_url_name && $web_url_link && $add_phoneno_btn) {

      $whtsap_send .= ',
                                    {
                                      "type":"BUTTONS",
                                          "buttons":[{"type":"URL", "text": "' . $btn_txt_url_name . '","url":"' . $web_url_link . '"}
                                          ' . $add_phoneno_btn . '	]	
                                          }';
                                          // VISIT_URL button
    } else if ($select_action1 == "VISIT_URL" && $btn_txt_url_name && $web_url_link) {

      $whtsap_send .= ',
                                            {
                                              "type":"BUTTONS",
                                                  "buttons":[{"type":"URL", "text": "' . $btn_txt_url_name . '","url":"' . $web_url_link . '"}
                                                    ]
                                                    }';
    } // QUICK_REPLY button
    if ($select_action == "QUICK_REPLY") {
      if ($txt_button_qr_text_1) {
        $whtsap_send .= ',
                                      {
                                        "type":"BUTTONS",
                      "buttons":' . json_encode($reply_array_content) . '
                                      }';


      }
    }

    $whtsap_send .= '
                                    ]';

 // MEDIA select option
    if ($selectOption == 'MEDIA') {
      switch ($media_category) {
        case 'image':  // Image
          if (isset($_FILES['file_image_header']['name'])) {
            /* Location */
            $image_size = $_FILES['file_image_header']['size'];
            $image_type = $_FILES['file_image_header']['type'];
            $file_type = explode("/", $image_type);

            $filename = $_SESSION['yjucp_user_id'] . "_" . $milliseconds . "." . $file_type[1];
            $location = $full_pathurl . "uploads/whatsapp_images/" . $filename;
 $location_1 = $site_url . "uploads/whatsapp_images/" . $filename;
            $imageFileType = pathinfo($location, PATHINFO_EXTENSION);
            $imageFileType = strtolower($imageFileType);
 //$location = $site_url . "uploads/whatsapp_images/" . $filename;
            /* Valid extensions */
            $valid_extensions = array("png", "jpg", "jpeg");

            $rspns = '';
            /* Check file extension */
            // if (in_array(strtolower($imageFileType), $valid_extensions)) {
            /* Upload file */
            if (move_uploaded_file($_FILES['file_image_header']['tmp_name'], $location)) {
              $rspns = $location;
              site_log_generate("Create Template Page : User : " . $_SESSION['yjucp_user_name'] . " whatsapp_images file moved into Folder on " . date("Y-m-d H:i:s"), '../');
            }
          }

          $replace_txt = '{
      "language" : "' . $language_code . '",
      "category" : "' . $categories . '",
 "code" : "'.$code.'",
      "media_url": "' . $location_1 . '",
      "components" : ' . $whtsap_send . ',
 "request_id" : "'.$request_id .'"
    }';
             // Call the reusable cURL function
 $response = executeCurlRequest($api_url . "/whsp_process/create_template", "POST", $replace_txt);

           // After got response decode the JSON result
          $obj = json_decode($response);
          if ($obj->response_status == 200) { //success
            $json = array("status" => 1, "msg" => $obj->response_msg);
          }
	       else{
            $json = array("status" => 0, "msg" => $obj->response_msg);
          }            

          break;
        case 'document':   // Document
          if (isset($_FILES['file_image_header']['name'])) {

            $image_size = $_FILES['file_image_header']['size'];
            $image_type = $_FILES['file_image_header']['type'];
            $file_type = explode("/", $image_type);

            $filename = $_SESSION['yjucp_user_id'] . "_" . $milliseconds ."." . $file_type[1];
           $location = $full_pathurl . "uploads/whatsapp_docs/" . $filename;
            $location_1 = $site_url . "uploads/whatsapp_docs/" . $filename;
            $imageFileType = pathinfo($location, PATHINFO_EXTENSION);
            $imageFileType = strtolower($imageFileType);
//$location = $site_url . "uploads/whatsapp_docs/" . $filename;
            /* Valid extensions */
            $valid_extensions = array("pdf");

            $rspns = '';
            /* Check file extension */
            if (in_array(strtolower($imageFileType), $valid_extensions)) {
              /* Upload file */
              if (move_uploaded_file($_FILES['file_image_header']['tmp_name'], $location)) {
                $rspns = $location;
                site_log_generate("Create Template Page : User : " . $_SESSION['yjucp_user_name'] . " whatsapp_docs file moved into Folder on " . date("Y-m-d H:i:s"), '../');
              }
            }
          }

          $replace_txt = '{
"language" : "' . $language_code . '",
"category" : "' . $categories . '",
"code" : "'.$code.'",
"media_url": "' . $location_1 . '",
"components" : ' . $whtsap_send . ',
"request_id" : "'.$request_id .'"
}';

            // Call the reusable cURL function
 $response = executeCurlRequest($api_url . "/whsp_process/create_template", "POST", $replace_txt);


          $obj = json_decode($response);
           if ($obj->response_status == 200) { //success
            $json = array("status" => 1, "msg" => $obj->response_msg);
          }
         	else{
            $json = array("status" => 0, "msg" => $obj->response_msg);
          }

          break;
        case 'video': // video
          if (isset($_FILES['file_image_header']['name'])) {

	$image_size = $_FILES['file_image_header']['size'];
											$image_type = $_FILES['file_image_header']['type'];
											$file_type = explode("/", $image_type);
            $filename = $_SESSION['yjucp_user_id'] . "_" . $milliseconds ."." .$file_type[1];

            /* Location */
           $location = $full_pathurl . "uploads/whatsapp_videos/" . $filename;
 $location_1 = $site_url . "uploads/whatsapp_videos/" . $filename;

            $imageFileType = pathinfo($location, PATHINFO_EXTENSION);
            $imageFileType = strtolower($imageFileType);
            $image_size = $_FILES['file_image_header']['size'];
            $image_type = $_FILES['file_image_header']['type'];
//$location = $site_url . "uploads/whatsapp_videos/" . $filename;
            /* Valid extensions */
            $valid_extensions = array("mp4");

            $rspns = '';
            /* Check file extension */
            if (in_array(strtolower($imageFileType), $valid_extensions)) {
              /* Upload file */
              if (move_uploaded_file($_FILES['file_image_header']['tmp_name'], $location)) {
                $rspns = $location;
                site_log_generate("Create Template Page : User : " . $_SESSION['yjucp_user_name'] . " whatsapp_videos file moved into Folder on " . date("Y-m-d H:i:s"), '../');
              }
            }
          }
          $replace_txt = '{
"language" : "' . $language_code . '",
"category" : "' . $categories . '",
"code" : "'.$code.'",
"media_url": "' . $location_1 . '",
"components" : ' . $whtsap_send . ',
"request_id" : "'.$request_id .'"
}';
            
                        // Call the reusable cURL function
             $response = executeCurlRequest($api_url . "/whsp_process/create_template", "POST", $replace_txt);
           // After got response decode the JSON result
          $obj = json_decode($response);
          if ($obj->response_status == 200) { //success
            $json = array("status" => 1, "msg" => $obj->response_msg);
          }
        else{
            $json = array("status" => 0, "msg" => $obj->response_msg);
          }
          break;
        default:
          # code...
          break;
      }
    }
    else {

      $replace_txt = '{
"language" : "' . $language_code . '",
"code" : "'.$code.'",
"category" : "' . $categories . '",
"components" : ' . $whtsap_send . ',
"request_id" : "'.$request_id .'"
}';
                    
                                // Call the reusable cURL function
                     $response = executeCurlRequest($api_url . "/whsp_process/create_template", "POST", $replace_txt);
      $obj = json_decode($response);
      if ($obj->response_status == 200) { //success
        $json = array("status" => 1, "msg" => $obj->response_msg);
      }
    else{
        $json = array("status" => 0, "msg" => $obj->response_msg);
      }
    }

}
// Create Template create_template - End

// Compose SMS Page PreviewTemplate - Start
if (isset($_GET['previewTemplate_meta']) == "previewTemplate_meta") {

  $tmpl_name = explode('!', $tmpl_name);
// Get data
  $wht_tmpl_url = htmlspecialchars(strip_tags(isset($_REQUEST['wht_tmpl_url']) ? $conn->real_escape_string($_REQUEST['wht_tmpl_url']) : ""));
  $wht_bearer_token = htmlspecialchars(strip_tags(isset($_REQUEST['wht_bearer_token']) ? $conn->real_escape_string($_REQUEST['wht_bearer_token']) : ""));
   // To Get Api URL
  $curl_get = $wht_tmpl_url . "/message_templates?name=" . $tmpl_name[0] . "&language=" . $tmpl_name[1];
  // add bearertoken
  $bearer_token = 'Authorization: '.$_SESSION['yjwatsp_bearer_token'].''; 
  // To Send the request  API
  $curl = curl_init();
  curl_setopt_array(
    $curl,
    array(
      CURLOPT_URL => $curl_get,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_SSL_VERIFYPEER => 0,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        $bearer_token ,
        'Authorization: Bearer ' . $wht_bearer_token
      ),
    )
  );

  $yjresponse = curl_exec($curl);
  curl_close($curl);
  $yjresponseobj = json_decode($yjresponse, false);

  if (count($yjresponseobj->data) > 0) {
    $stateData = '';
    $stateData_box = '';
    $hdr_type = '';
// Looping the ii is less than the count of response data.if the condition is true to continue the process.if the condition are false to stop the process
    for ($ii = 0; $ii < count($yjresponseobj->data); $ii++) {
      if ($yjresponseobj->data[$ii]->components[0]->type == 'HEADER') { //header
        switch ($yjresponseobj->data[$ii]->components[0]->format) {
          case 'TEXT':
            $hdr_type .= "<input type='hidden' name='hid_txt_header_variable' id='hid_txt_header_variable' value='" . $yjresponseobj->data[$ii]->components[0]->text . "'>";

            $stateData_1 = '';
            $stateData_1 = $yjresponseobj->data[$ii]->components[0]->text;
            $stateData_2 = $stateData_1;

            $matches = null;
            $prmt = preg_match_all("/{{[0-9]+}}/", $yjresponseobj->data[$ii]->components[0]->text, $matches);
            $matches_a0 = $matches[0];
            rsort($matches_a0);
            sort($matches_a0);
            for ($ij = 0; $ij < count($matches_a0); $ij++) {
   // Looping the ij is less than the count of matches_a0.if the condition is true to continue the process.if the condition are false to stop the process
              $expl2 = explode("{{", $matches_a0[$ij]);
              $expl3 = explode("}}", $expl2[1]);
              $stateData_box = "</div><div style='float:left; padding: 0 5px;'> <input type='text' readonly tabindex='10' name='txt_header_variable[$expl3[0]][]' id='txt_header_variable' placeholder='{{" . $expl3[0] . "}} Value' title='Header Text' maxlength='20' value='-' style='width:100px;height: 30px;cursor: not-allowed;margin-top:10px;' class='form-control required'> </div><div style='float: left;'>";
              $stateData_1 = str_replace("{{" . $expl3[0] . "}}", $stateData_box, $stateData_1);
              $stateData_2 = $stateData_1;
            }

            if ($stateData_2 != '') {
              $stateData .= "<div style='float:left; clear:both; line-height: 36px;'><div style='float:left; line-height: 36px;'>Header : </div><div style='float:left'>" . $stateData_2 . "</div></div>";
            }
            break;
  case 'DOCUMENT': //document
              $stateData .= "<div style='float:left; clear:both; line-height: 36px;'><div style='float:left; line-height: 36px;'>Header : </div><div style='float:left;margin-left:10px;'><a href=".$yjresponseobj->data[$ii]->components[0]->example->header_handle[0]." target='_blank'>Document Link</a></div>";
              break;
              case 'IMAGE': // Image
                $stateData .= "<div style='float:left; clear:both; line-height: 36px;'><div style='float:left; line-height: 36px;'>Header : </div><div style='float:left;margin-left:10px;'><a href=".$yjresponseobj->data[$ii]->components[0]->example->header_handle[0]." target='_blank'><img src=".$yjresponseobj->data[$ii]->components[0]->example->header_handle[0]." alt='image' style='width:600px;height:700px' ></a></div>";
                break;
            case 'VIDEO':  // Video
              $stateData .= "<div style='float:left; clear:both; line-height: 36px;'><div style='float:left; line-height: 36px;'>Header : </div><div style='float:left;margin-left:10px; '><a href=".$yjresponseobj->data[$ii]->components[0]->example->header_handle[0]." target='_blank'>Video Link</a></div>";
              break;        }
      }

      if ($yjresponseobj->data[$ii]->components[1]->type == 'BODY') { //body
        $hdr_type .= "<input type='hidden' style='margin-left:10px;' name='hid_txt_body_variable' id='hid_txt_body_variable' value='" . $yjresponseobj->data[$ii]->components[1]->text . "'>";

        $stateData_1 = '';
        $stateData_1 = $yjresponseobj->data[$ii]->components[1]->text;
        $stateData_2 = $stateData_1;

        $matches = null;
        $prmt = preg_match_all("/{{[0-9]+}}/", $yjresponseobj->data[$ii]->components[1]->text, $matches);
        $matches_a1 = $matches[0];
        rsort($matches_a1);
        sort($matches_a1);
        for ($ij = 0; $ij < count($matches_a1); $ij++) {
// Looping the ij is less than the count of matches_a1.if the condition is true to continue the process.if the condition are false to stop the process
          $expl2 = explode("{{", $matches_a1[$ij]);
          $expl3 = explode("}}", $expl2[1]);
          $stateData_box = "</div><div style='float:left; padding: 0 5px;'> <input type='text' readonly name='txt_body_variable[$expl3[0]][]' id='txt_body_variable' placeholder='{{" . $expl3[0] . "}} Value' maxlength='20' title='Enter {{" . $expl3[0] . "}} Value' value='-' style='width:100px;height: 30px;cursor: not-allowed;margin-top:10px;' class='form-control required'> </div><div style='float: left;'>";
          $stateData_1 = str_replace("{{" . $expl3[0] . "}}", $stateData_box, $stateData_1);
          $stateData_2 = $stateData_1;
        }

        if ($stateData_2 != '') {
          $stateData .= "<div style='float:left; clear:both; line-height: 36px;'><div style='float:left; line-height: 36px;'>Body : </div><div style='float:left'>" . $stateData_2 . "</div></div>";
        }

   
      }

      if ($yjresponseobj->data[$ii]->components[0]->type == 'BODY') { // body
        $hdr_type .= "<input type='hidden'  style='margin-left:10px;' name='hid_txt_body_variable' id='hid_txt_body_variable' value='" . $yjresponseobj->data[$ii]->components[0]->text . "'>";

        $stateData_1 = '';
        $stateData_1 = $yjresponseobj->data[$ii]->components[0]->text;
        $stateData_2 = $stateData_1;

        $matches = null;
        $prmt = preg_match_all("/{{[0-9]+}}/", $yjresponseobj->data[$ii]->components[0]->text, $matches);
        $matches_a1 = $matches[0];
        rsort($matches_a1);
        sort($matches_a1);
        for ($ij = 0; $ij < count($matches_a1); $ij++) {
 // Looping the ij is less than the count of matches_a1.if the condition is true to continue the process.if the condition are false to stop the process
          $expl2 = explode("{{", $matches_a1[$ij]);
          $expl3 = explode("}}", $expl2[1]);
          $stateData_box = "</div><div style='float:left; padding: 0 5px;'> <input type='text' readonly name='txt_body_variable[$expl3[0]][]' id='txt_body_variable' placeholder='{{" . $expl3[0] . "}} Value' maxlength='20' tabindex='12' title='Enter {{" . $expl3[0] . "}} Value' value='-' style='width:100px;height: 30px;cursor: not-allowed;margin-top:10px;' class='form-control required'> </div><div style='float: left;'>";
          $stateData_1 = str_replace("{{" . $expl3[0] . "}}", $stateData_box, $stateData_1);
          $stateData_2 = $stateData_1;
        }
        if ($stateData_2 != '') {
          $stateData .= "<div style='float:left; clear:both; line-height: 36px;'><div style='float:left; line-height: 36px;'>Body : </div><div style='float:left'>" . $stateData_2 . "</div></div>";
        }
      }

      if ($yjresponseobj->data[$ii]->components[1]->type == 'BUTTONS') { // buttons
        $stateData_2 = '';
        if ($yjresponseobj->data[$ii]->components[1]->buttons[0]->type == 'URL') {
          $stateData_2 .= "<a href='" . $yjresponseobj->data[$ii]->components[1]->buttons[0]->url . "' target='_blank'>" . $yjresponseobj->data[$ii]->components[1]->buttons[0]->text . "</a>";
          $stateData .= "<div style='float:left; clear:both; line-height: 36px;'><div style='float:left; line-height: 36px;'>Buttons URL : </div><div style='float:left'>" . $yjresponseobj->data[$ii]->components[1]->buttons[0]->url . " - " . $stateData_2 . "</div></div>";
        }

        if ($yjresponseobj->data[$ii]->components[1]->buttons[0]->type == 'PHONE_NUMBER') { // PHONE_NUMBER
          $stateData_2 .= $yjresponseobj->data[$ii]->components[1]->buttons[0]->text . " - " . $yjresponseobj->data[$ii]->components[1]->buttons[0]->phone_number;
          $stateData .= "<div style='float:left; clear:both; line-height: 36px;'><div style='float:left; line-height: 36px;'>Buttons Phone No. : </div><div style='float:left'>" . $stateData_2 . "</div></div>";
        }
 // Looping the ij is less than the count of buttons.if the condition is true to continue the process.if the condition are false to stop the process
        for ($kk = 0; $kk < count($yjresponseobj->data[$ii]->components[1]->buttons); $kk++) { // QUICK_REPLY
          if ($yjresponseobj->data[$ii]->components[1]->buttons[$kk]->type == 'QUICK_REPLY') {
            $stateData_2 .= $yjresponseobj->data[$ii]->components[1]->buttons[$kk]->text;
            $stateData .= "<div style='float:left; clear:both; line-height: 36px;'><div style='float:left; line-height: 36px;'>Buttons Quick Reply : </div><div style='float:left'>" . $stateData_2 . "</div></div>";
          }
        }
      }

      if ($yjresponseobj->data[$ii]->components[1]->type == 'FOOTER') { // FOOTER
        $hdr_type .= "<input type='hidden' name='hid_txt_footer_variable' id='hid_txt_footer_variable' value='" . $yjresponseobj->data[$ii]->components[1]->text . "'>";

        $stateData_2 = '';
        $stateData_2 = $yjresponseobj->data[$ii]->components[1]->text;

        if ($stateData_2 != '') {
          $stateData .= "<div style='float:left; clear:both; line-height: 36px;'><div style='float:left; line-height: 36px;'>Footer : </div><div style='float:left'>" . $stateData_2 . "</div></div>";
        }
      }

      if ($yjresponseobj->data[$ii]->components[2]->type == 'BUTTONS') { // BUTTONS
        $stateData_2 = '';

        if ($yjresponseobj->data[$ii]->components[2]->buttons[0]->type == 'URL') {
          $stateData_2 .= "<a href='" . $yjresponseobj->data[$ii]->components[2]->buttons[0]->url . "' target='_blank'>" . $yjresponseobj->data[$ii]->components[2]->buttons[0]->text . "</a>";
          $stateData .= "<div style='float:left; clear:both; line-height: 36px;'><div style='float:left; line-height: 36px;'>Buttons URL : </div><div style='float:left'>" . $yjresponseobj->data[$ii]->components[2]->buttons[0]->url . " - " . $stateData_2 . "</div></div>";
        }

        if ($yjresponseobj->data[$ii]->components[2]->buttons[0]->type == 'PHONE_NUMBER') { // PHONE_NUMBER
          $stateData_2 .= $yjresponseobj->data[$ii]->components[2]->buttons[0]->text . " - " . $yjresponseobj->data[$ii]->components[2]->buttons[0]->phone_number;
          $stateData .= "<div style='float:left; clear:both; line-height: 36px;'><div style='float:left; line-height: 36px;'>Buttons Phone No. : </div><div style='float:left'>" . $stateData_2 . "</div></div>";
        }
// Looping the kk is less than the count of buttons.if the condition is true to continue the process.if the condition are false to stop the process
        for ($kk = 0; $kk < count($yjresponseobj->data[$ii]->components[2]->buttons); $kk++) { // QUICK_REPLY
          if ($yjresponseobj->data[$ii]->components[2]->buttons[$kk]->type == 'QUICK_REPLY') {
            $stateData_2 .= $yjresponseobj->data[$ii]->components[2]->buttons[$kk]->text;
            $stateData .= "<div style='float:left; clear:both; line-height: 36px;'><div style='float:left; line-height: 36px;'>Buttons Quick Reply : </div><div style='float:left'>" . $stateData_2 . "</div></div>";
          }
        }
      }
    }
    site_log_generate("Compose Whatsapp Template Page : User : " . $_SESSION['yjwatsp_user_name'] . " Get Meta Message Template available on " . date("Y-m-d H:i:s"), '../');
    $json = array("status" => 1, "msg" => $stateData . $hdr_type);
  } else {
    site_log_generate("Compose Whatsapp Template Page : User : " . $_SESSION['yjwatsp_user_name'] . " Get Message Template not available on " . date("Y-m-d H:i:s"), '../');
    $json = array("status" => 0, "msg" => '-');
  }
}
// Compose SMS Page PreviewTemplate - End

// Compose SMS Page getSingleTemplate_meta - Start
if (isset($_GET['getSingleTemplate_meta']) == "getSingleTemplate_meta") {
  $tmpl_name = explode('!', $tmpl_name);
// Get data
  $wht_tmpl_url = htmlspecialchars(strip_tags(isset($_REQUEST['wht_tmpl_url']) ? $conn->real_escape_string($_REQUEST['wht_tmpl_url']) : ""));
  $wht_bearer_token = htmlspecialchars(strip_tags(isset($_REQUEST['wht_bearer_token']) ? $conn->real_escape_string($_REQUEST['wht_bearer_token']) : ""));
    // It will call "message_templates" API to verify, can we access for the message_templates
  $curl_get = $wht_tmpl_url . "/message_templates?name=" . $tmpl_name[0] . "&language=" . $tmpl_name[1];
  $curl = curl_init();
  curl_setopt_array(
    $curl,
    array(
      CURLOPT_URL => $curl_get,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_SSL_VERIFYPEER => 0,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer ' . $wht_bearer_token
      ),
    )
  );
  // Send the data into API and execute 
  $yjresponse = curl_exec($curl);
  curl_close($curl);
  // After got response decode the JSON result
  $yjresponseobj = json_decode($yjresponse, false);

  if (count($yjresponseobj->data) > 0) {
    $stateData = '';
    $stateData_box = '';
    $hdr_type = '';
 // Looping the ii is less than the count of data.if the condition is true to continue the process.if the condition are false to stop the process
    for ($ii = 0; $ii < count($yjresponseobj->data); $ii++) {
      if ($yjresponseobj->data[$ii]->components[0]->type == 'HEADER') {
        switch ($yjresponseobj->data[$ii]->components[0]->format) {
          case 'TEXT': // text
            $hdr_type .= "<input type='hidden' name='hid_txt_header_variable' id='hid_txt_header_variable' value='" . $yjresponseobj->data[$ii]->components[0]->text . "'>";

            $stateData_1 = '';
            $stateData_1 = $yjresponseobj->data[$ii]->components[0]->text;
            $stateData_2 = $stateData_1;

            $matches = null;
            $prmt = preg_match_all("/{{[0-9]+}}/", $yjresponseobj->data[$ii]->components[0]->text, $matches);
            $matches_a0 = $matches[0];
            rsort($matches_a0);
            sort($matches_a0);
            for ($ij = 0; $ij < count($matches_a0); $ij++) {
  // Looping the ii is less than the count of matches_a0.if the condition is true to continue the process.if the condition are false to stop the process
              $expl2 = explode("{{", $matches_a0[$ij]);
              $expl3 = explode("}}", $expl2[1]);
              $stateData_box = "</div><div style='float:left; padding: 0 5px;'> <input type='text' readonly tabindex='10' name='txt_header_variable[$expl3[0]][]' id='txt_header_variable' placeholder='{{" . $expl3[0] . "}} Value' title='Header Text' maxlength='20' value='-' style='width:100px;height: 30px;cursor: not-allowed;margin-top:10px;' class='form-control required'> </div><div style='float: left;'>";
              $stateData_1 = str_replace("{{" . $expl3[0] . "}}", $stateData_box, $stateData_1);
              $stateData_2 = $stateData_1;
            }

            if ($stateData_2 != '') {
              $stateData .= "<div style='float:left; clear:both; line-height: 36px;'><div style='float:left; line-height: 36px;'>Header : </div><div style='float:left'>" . $stateData_2 . "</div></div>";
            }
            break;

          case 'DOCUMENT': //document
            $stateData .= "<div style='float:left; clear:both; line-height: 36px;'><div style='float:left; line-height: 36px;'>Header : </div><div style='float:left'><input type='file' style='margin-left:10px;'  class='form-control' name='file_document_header' id='file_document_header' tabindex='11' accept='application/pdf' data-toggle='tooltip' onblur='validate_filesizes(this)' onfocus='disable_texbox(\"file_document_header\", \"file_document_header_url\")' data-placement='top' data-html='true' title='Upload Any PDF file, below or equal to 5 MB Size' data-original-title='Upload Any PDF file, below or equal to 5 MB Size'></div><div style='float:left'><span style='color:#FF0000 ;margin-left:20px;'>[OR]</span></div><div style='float:left'><div class='' style='margin-left:10px;' data-toggle='tooltip' data-placement='top' title='Enter Document URL' data-original-title='Enter Document URL'>
                <div class='input-group'>
                  <input class='form-control form-control-primary' type='url' name='file_document_header_url' id='file_document_header_url' maxlength='100' title='Enter Document URL' onfocus='disable_texbox(\"file_document_header_url\", \"file_document_header\")' tabindex='12' placeholder='Enter Document URL'>
                </div>
              </div>
              </div></div>";
            break;


          case 'IMAGE': // Image
            $stateData .= "<div style='float:left; clear:both; line-height: 36px;'><div style='float:left; line-height: 36px;'>Header : </div><div style='float:left'><input type='file' style='margin-left:10px;' class='form-control' name='file_image_header' id='file_image_header' tabindex='11' accept='image/png,image/jpg,image/jpeg' data-toggle='tooltip' onblur='validate_filesizes(this)' onfocus='disable_texbox(\"file_image_header\", \"file_image_header_url\")' data-placement='top' data-html='true' title='Upload Any PNG, JPG, JPEG files, below or equal to 5 MB Size' data-original-title='Upload Any PNG, JPG, JPEG files, below or equal to 5 MB Size'></div><div style='float:left'><span style='color:#FF0000;margin-left:20px;'>[OR]</span></div><div style='float:left'><div class='' style='margin-left:10px;' data-toggle='tooltip' data-placement='top' title='Enter Image URL' data-original-title='Enter Image URL'>
                <div class='input-group'>
                  <input class='form-control form-control-primary' type='url' name='file_image_header_url' id='file_image_header_url' maxlength='100' title='Enter Image URL' tabindex='12' onfocus='disable_texbox(\"file_image_header_url\", \"file_image_header\")' placeholder='Enter Image URL'>
                  <span class='input-group-addon'><i class='icofont icofont-ui-messaging'></i></span>
                </div>
              </div>
              </div></div>";
            break;


          case 'VIDEO':  // Video
            $stateData .= "<div style='float:left; clear:both; line-height: 36px;'><div style='float:left; line-height: 36px;'>Header : </div><div style='float:left'><input type='file' style='margin-left:10px;' class='form-control' name='file_video_header' id='file_video_header' tabindex='11' accept='video/mp4' data-toggle='tooltip' onblur='validate_filesizes(this)' onfocus='disable_texbox(\"file_video_header\", \"file_video_header_url\")' data-placement='top' data-html='true' title='Upload Any MP4 file, below or equal to 5 MB Size' data-original-title='Upload Any MP4, MPEG, WEBM file, below or equal to 5 MB Size'></div><div style='float:left'><span style='color:#FF0000;margin-left:20px;'>[OR]</span></div><div style='float:left'><div class='' style='margin-left:10px;'data-toggle='tooltip' data-placement='top' title='Enter Video URL' data-original-title='Enter Video URL'>
                <div class='input-group'>
                  <input class='form-control form-control-primary' type='url' name='file_video_header_url' id='file_video_header_url' maxlength='100' title='Enter Video URL' tabindex='12' onfocus='disable_texbox(\"file_video_header_url\", \"file_video_header\")' placeholder='Enter Video URL'>
                  <span class='input-group-addon'><i class='icofont icofont-ui-messaging'></i></span>
                </div>
              </div>
              </div></div>";
            break;
}

      }

      if ($yjresponseobj->data[$ii]->components[1]->type == 'BODY') { // Body text
        $hdr_type .= "<input type='hidden' name='hid_txt_body_variable'  style='margin-left:10px;'  id='hid_txt_body_variable' value='" . $yjresponseobj->data[$ii]->components[1]->text . "'>";

        $stateData_1 = '';
        $stateData_1 = $yjresponseobj->data[$ii]->components[1]->text;
        $stateData_2 = $stateData_1;

        $matches = null;
        $prmt = preg_match_all("/{{[0-9]+}}/", $yjresponseobj->data[$ii]->components[1]->text, $matches);
        $matches_a1 = $matches[0];
        rsort($matches_a1);
        sort($matches_a1);
        for ($ij = 0; $ij < count($matches_a1); $ij++) {
 // Looping the ij is less than the count of matches_a1.if the condition is true to continue the process.if the condition are false to stop the process
          $expl2 = explode("{{", $matches_a1[$ij]);
          $expl3 = explode("}}", $expl2[1]);
          $stateData_box = "</div><div style='float:left; padding: 0 5px;'> <input type='text' readonly name='txt_body_variable[$expl3[0]][]' id='txt_body_variable' placeholder='{{" . $expl3[0] . "}} Value' maxlength='20' title='Enter {{" . $expl3[0] . "}} Value' value='-' style='width:100px;height: 30px;cursor: not-allowed;margin-top:10px;' class='form-control required'> </div><div style='float: left;'>";
          $stateData_1 = str_replace("{{" . $expl3[0] . "}}", $stateData_box, $stateData_1);
          $stateData_2 = $stateData_1;
        }

        if ($stateData_2 != '') {
          $stateData .= "<div style='float:left; clear:both; line-height: 36px;'><div style='float:left; line-height: 36px;'>Body : </div><div style='float:left;margin-left:10px;'>" . $stateData_2 . "</div></div>";
        }

      }

      if ($yjresponseobj->data[$ii]->components[0]->type == 'BODY') { // Body text
        $hdr_type .= "<input type='hidden' style='margin-left:10px;' name='hid_txt_body_variable' id='hid_txt_body_variable' value='" . $yjresponseobj->data[$ii]->components[0]->text . "'>";

        $stateData_1 = '';
        $stateData_1 = $yjresponseobj->data[$ii]->components[0]->text;
        $stateData_2 = $stateData_1;

        $matches = null;
        $prmt = preg_match_all("/{{[0-9]+}}/", $yjresponseobj->data[$ii]->components[0]->text, $matches);
        $matches_a1 = $matches[0];
        rsort($matches_a1);
        sort($matches_a1);
        for ($ij = 0; $ij < count($matches_a1); $ij++) {
 // Looping the ij is less than the count of matches_a1.if the condition is true to continue the process.if the condition are false to stop the process
          $expl2 = explode("{{", $matches_a1[$ij]);
          $expl3 = explode("}}", $expl2[1]);
          $stateData_box = "</div><div style='float:left; padding: 0 5px;'> <input type='text' readonly name='txt_body_variable[$expl3[0]][]' id='txt_body_variable' placeholder='{{" . $expl3[0] . "}} Value' maxlength='20' tabindex='12' title='Enter {{" . $expl3[0] . "}} Value' value='-' style='width:100px;height: 30px;cursor: not-allowed;margin-top:10px;' class='form-control required'> </div><div style='float: left;'>";
          $stateData_1 = str_replace("{{" . $expl3[0] . "}}", $stateData_box, $stateData_1);
          $stateData_2 = $stateData_1;
        }
        if ($stateData_2 != '') {
          $stateData .= "<div style='float:left; clear:both; line-height: 36px;'><div style='float:left; line-height: 36px;'>Body : </div><div style='float:left;margin-left:10px;'>" . $stateData_2 . "</div></div>";
        }
      }

      if ($yjresponseobj->data[$ii]->components[1]->type == 'BUTTONS') {  // B Buttons
        $stateData_2 = '';
        if ($yjresponseobj->data[$ii]->components[1]->buttons[0]->type == 'URL') {
          $stateData_2 .= "<a href='" . $yjresponseobj->data[$ii]->components[1]->buttons[0]->url . "' target='_blank'>" . $yjresponseobj->data[$ii]->components[1]->buttons[0]->text . "</a>";
          $stateData .= "<div style='float:left; clear:both; line-height: 36px;'><div style='float:left; line-height: 36px;'>Buttons URL : </div><div style='float:left'>" . $yjresponseobj->data[$ii]->components[1]->buttons[0]->url . " - " . $stateData_2 . "</div></div>";
        }

        if ($yjresponseobj->data[$ii]->components[1]->buttons[0]->type == 'PHONE_NUMBER') { // Phone number
          $stateData_2 .= $yjresponseobj->data[$ii]->components[1]->buttons[0]->text . " - " . $yjresponseobj->data[$ii]->components[1]->buttons[0]->phone_number;
          $stateData .= "<div style='float:left; clear:both; line-height: 36px;'><div style='float:left; line-height: 36px;'>Buttons Phone No. : </div><div style='float:left'>" . $stateData_2 . "</div></div>";
        }
// Looping the kk is less than the count of buttons.if the condition is true to continue the process.if the condition are false to stop the process
        for ($kk = 0; $kk < count($yjresponseobj->data[$ii]->components[1]->buttons); $kk++) { // Quickreply
          if ($yjresponseobj->data[$ii]->components[1]->buttons[$kk]->type == 'QUICK_REPLY') {
            $stateData_2 .= $yjresponseobj->data[$ii]->components[1]->buttons[$kk]->text;
            $stateData .= "<div style='float:left; clear:both; line-height: 36px;'><div style='float:left; line-height: 36px;'>Buttons Quick Reply : </div><div style='float:left'>" . $stateData_2 . "</div></div>";
          }
        }
      }

      if ($yjresponseobj->data[$ii]->components[1]->type == 'FOOTER') { // Footer
        $hdr_type .= "<input type='hidden' name='hid_txt_footer_variable' id='hid_txt_footer_variable' value='" . $yjresponseobj->data[$ii]->components[1]->text . "'>";

        $stateData_2 = '';
        $stateData_2 = $yjresponseobj->data[$ii]->components[1]->text;

        if ($stateData_2 != '') {
          $stateData .= "<div style='float:left; clear:both; line-height: 36px;'><div style='float:left; line-height: 36px;'>Footer : </div><div style='float:left'>" . $stateData_2 . "</div></div>";
        }
      }
      if ($yjresponseobj->data[$ii]->components[2]->type == 'BUTTONS') { // Buttons
        $stateData_2 = '';

        if ($yjresponseobj->data[$ii]->components[2]->buttons[0]->type == 'URL') {
          $stateData_2 .= "<a href='" . $yjresponseobj->data[$ii]->components[2]->buttons[0]->url . "' target='_blank'>" . $yjresponseobj->data[$ii]->components[2]->buttons[0]->text . "</a>";
          $stateData .= "<div style='float:left; clear:both; line-height: 36px;'><div style='float:left; line-height: 36px;'>Buttons URL : </div><div style='float:left'>" . $yjresponseobj->data[$ii]->components[2]->buttons[0]->url . " - " . $stateData_2 . "</div></div>";
        }

        if ($yjresponseobj->data[$ii]->components[2]->buttons[0]->type == 'PHONE_NUMBER') { // Phone Number
          $stateData_2 .= $yjresponseobj->data[$ii]->components[2]->buttons[0]->text . " - " . $yjresponseobj->data[$ii]->components[2]->buttons[0]->phone_number;
          $stateData .= "<div style='float:left; clear:both; line-height: 36px;'><div style='float:left; line-height: 36px;'>Buttons Phone No. : </div><div style='float:left'>" . $stateData_2 . "</div></div>";
        }
// Looping the kk is less than the count of buttons.if the condition is true to continue the process.if the condition are false to stop the process
        for ($kk = 0; $kk < count($yjresponseobj->data[$ii]->components[2]->buttons); $kk++) { //QUICK_REPLY
          if ($yjresponseobj->data[$ii]->components[2]->buttons[$kk]->type == 'QUICK_REPLY') {
            $stateData_2 .= $yjresponseobj->data[$ii]->components[2]->buttons[$kk]->text;
            $stateData .= "<div style='float:left; clear:both; line-height: 36px;'><div style='float:left; line-height: 36px;'>Buttons Quick Reply : </div><div style='float:left'>" . $stateData_2 . "</div></div>";
          }
        }
      }
    }
    site_log_generate("Compose Whatsapp Template Page : User : " . $_SESSION['yjwatsp_user_name'] . " Get Meta Message Template available on " . date("Y-m-d H:i:s"), '../');
    $json = array("status" => 1, "msg" => $stateData . $hdr_type);
  } else {
    site_log_generate("Compose Whatsapp Template Page : User : " . $_SESSION['yjwatsp_user_name'] . " Get Message Template not available on " . date("Y-m-d H:i:s"), '../');
    $json = array("status" => 0, "msg" => '-');
  }
}
// Compose SMS Page getSingleTemplate_meta - End


// Finally Close all Opened Mysql DB Connection
$conn->close();

// Output header with JSON Response
header('Content-type: application/json');
echo json_encode($json);
