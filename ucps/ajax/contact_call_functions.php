<?php
session_start();
error_reporting(E_ALL);
include_once('../api/configuration.php'); // Include configuration.php
include_once "../api/send_request.php"; // Include configuration.php
extract($_REQUEST);

$current_date = date("Y-m-d H:i:s");
$milliseconds = round(microtime(true) * 1000);

// contacts_group Page add_contact_group - Start
if($_SERVER['REQUEST_METHOD'] == "POST" and $tmpl_call_function == "add_contact_group") {
	// Get data
	$contact_group_title 		= htmlspecialchars(strip_tags(isset($_REQUEST['contact_group_name']) ? $_REQUEST['contact_group_name'] : ""));
	$contact_group_status		= htmlspecialchars(strip_tags(isset($_REQUEST['contact_status']) ? $_REQUEST['contact_status'] : ""));
	$group_description		= htmlspecialchars(strip_tags(isset($_REQUEST['group_description']) ? $_REQUEST['group_description'] : ""));
	$group_id = htmlspecialchars(strip_tags(isset($_REQUEST['group_id']) ? $_REQUEST['group_id'] : ""));
  // To Send the request API
  $replace_txt .= '{
	"user_id" : "' . $_SESSION['yjucp_user_id'] . '",
	"group_name" : "' . $contact_group_title . '",
	"group_status" : "' . $contact_group_status . '",
	"group_description" : "'.$group_description.'"';

	if($group_id){
		$replace_txt .= '
		,"group_id" : "'.$group_id.'"';
	}
	$replace_txt .= '}';
	  // Call the reusable cURL function
 $response = executeCurlRequest($api_url . "/contacts/add_group", "POST", $replace_txt);
  // After got response decode the JSON result
  if (empty($response)) {
	// Redirect to index.php if response is empty
	header("Location: index");
	exit(); // Stop further execution after redirect
  }
 $respobj = json_decode($response);

 if ($respobj->response_status == 403) { ?>
<script>
window.location = "index";
</script>
<?} elseif ($respobj->response_status == 200) {
   $json = array("status" => 1, "msg" => "Group Name is Created..");
 }else{
	$json = array("status" => 0, "msg" => $respobj->response_msg);
  } 
} 
// contacts_group Page add_contact_group - End

// contacts_group Page add_contact - Start
if($_SERVER['REQUEST_METHOD'] == "POST" and $tmpl_call_function == "add_contact") {
	// Get data
	$group_id 	= htmlspecialchars(strip_tags(isset($_REQUEST['contact_mgtgrp_id']) ? $_REQUEST['contact_mgtgrp_id'] : ""));
	$contact_no 				= htmlspecialchars(strip_tags(isset($_REQUEST['contact_no']) ? $_REQUEST['contact_no'] : ""));
	$contact_name 			= htmlspecialchars(strip_tags(isset($_REQUEST['contact_name']) ? $_REQUEST['contact_name'] : ""));
	$contact_email 			= htmlspecialchars(strip_tags(isset($_REQUEST['contact_email']) ? $_REQUEST['contact_email'] : ""));
	$contact_operator 	= htmlspecialchars(strip_tags(isset($_REQUEST['contact_operator']) ? $_REQUEST['contact_operator'] : ""));
	$contact_status			= htmlspecialchars(strip_tags(isset($_REQUEST['contact_status']) ? $_REQUEST['contact_status'] : ""));
	$contact_id			= htmlspecialchars(strip_tags(isset($_REQUEST['contact_id']) ? $_REQUEST['contact_id'] : ""));

	 // To Send the request API
	 $replace_txt .= '{
		"user_id" : "' . $_SESSION['yjucp_user_id'] . '",
		"contact_name" : "' . $contact_name . '",
		"contact_email" : "' . $contact_email . '",
		"contact_status" : "'.$contact_status.'",
		"contact_operator" : "' . $contact_operator . '",
		"contact_no" : "' . $contact_no . '",
		"group_id" : "'.$group_id.'"
		';
	
		if($contact_id){
			$replace_txt .= '
			,"contact_id" : "'.$contact_id.'"';
		}
		$replace_txt .= '}';
		  // Call the reusable cURL function
	 $response = executeCurlRequest($api_url . "/contacts/add_contacts", "POST", $replace_txt);
	  // After got response decode the JSON result
	  if (empty($response)) {
		// Redirect to index.php if response is empty
		header("Location: index");
		exit(); // Stop further execution after redirect
	  }
	 $respobj = json_decode($response);
	
	 if ($respobj->response_status == 403) { ?>
<script>
window.location = "index";
</script>
<?} elseif ($respobj->response_status == 200) {
	   $json = array("status" => 1, "msg" => "Contact is Created..");
	 }else{
		$json = array("status" => 0, "msg" => $respobj->response_msg);
	  } 
	} 
// contacts_group Page add_contact - End

// contacts_group Page import_contact - Start
if($_SERVER['REQUEST_METHOD'] == "POST" and $tmpl_call_function == "import_contact") {
	// Get data
	$filename_upload = htmlspecialchars(strip_tags(isset($_REQUEST['filename_upload']) ? $_REQUEST['filename_upload'] : ""));
	$total_mobileno_count = htmlspecialchars(strip_tags(isset($_REQUEST['total_mobilenos_count']) ? $_REQUEST['total_mobilenos_count'] : ""));
	$group_id = htmlspecialchars(strip_tags(isset($_REQUEST['contact_mgtgrp_id']) ? $_REQUEST['contact_mgtgrp_id'] : ""));
	$file_location = $full_pathurl . "uploads/compose_variables/" . $filename_upload;
	$file_basename = basename($file_location);
	if ($file_basename === false) {
	  $json = array("status" => 2, "msg" => "Error occurred while extracting file name!");
	}
	
		$replace_txt = '{
			  "import_file" : "' . $file_location . '",
			  "total_mobile_count":"' . $total_mobileno_count . '",
			  "group_id" : "'.$group_id.'"
			  }';
			  $response = executeCurlRequest($api_url . "/contacts/add_contacts", "POST", $replace_txt);
			  // After got response decode the JSON result
			  if (empty($response)) {
				// Redirect to index.php if response is empty
				header("Location: index");
				exit(); // Stop further execution after redirect
			  }
			 $respobj = json_decode($response);
			
			 if ($respobj->response_status == 403) { ?>
          <script>
              window.location = "index";
          </script>
             <?} elseif ($respobj->response_status == 200) {
			   $json = array("status" => 1, "msg" => "Contact is Created..");
			 }else{
				$json = array("status" => 0, "msg" => $respobj->response_msg);
			  } 
			} 

// contacts_group Page import_contact - End

// create_plan Page create_plan - Start
if($_SERVER['REQUEST_METHOD'] == "POST" and $tmpl_call_function == "create_plan") {
	// Get data
	$txt_product_name 		= htmlspecialchars(strip_tags(isset($_REQUEST['txt_product_name']) ? $_REQUEST['txt_product_name'] : ""));
	$txt_plan_name		= htmlspecialchars(strip_tags(isset($_REQUEST['txt_plan_name']) ? $_REQUEST['txt_plan_name'] : ""));
	$txt_total_message		= htmlspecialchars(strip_tags(isset($_REQUEST['txt_total_message']) ? $_REQUEST['txt_total_message'] : ""));
	$txt_price_per_msg = htmlspecialchars(strip_tags(isset($_REQUEST['txt_price_per_msg']) ? $_REQUEST['txt_price_per_msg'] : ""));
	$plan_status = htmlspecialchars(strip_tags(isset($_REQUEST['plan_status']) ? $_REQUEST['plan_status'] : ""));
								$parts = explode('~~', $txt_product_name);
  // To Send the request API
  $replace_txt .= '{
	"user_id" : "' . $_SESSION['yjucp_user_id'] . '",
	"txt_product_name" : "' . $parts[0] . '",
	"txt_plan_name" : "' . $txt_plan_name . '",
	"txt_total_message" : "'.$txt_total_message.'",
	"txt_price_per_msg" : "' . $txt_price_per_msg . '",
	"plan_status" : "'.$plan_status.'"';

	if($plan_id){
		$replace_txt .= '
		,"plan_id" : "'.$plan_id.'"';
	}
	$replace_txt .= '}';
	  // Call the reusable cURL function
 $response = executeCurlRequest($api_url . "/contacts/create_plans", "POST", $replace_txt);
  // After got response decode the JSON result
  if (empty($response)) {
	// Redirect to index.php if response is empty
	header("Location: index");
	exit(); // Stop further execution after redirect
  }
 $respobj = json_decode($response);

 if ($respobj->response_status == 403) { ?>
<script>
window.location = "index";
</script>
<?} elseif ($respobj->response_status == 200) {
   $json = array("status" => 1, "msg" => "Plan is Created..");
 }else{
	$json = array("status" => 0, "msg" => $respobj->response_msg);
  } 
} 
// create_plan Page create_plan - End


// Finally Close all Opened Mysql DB Connection
$conn->close();

// Output header with JSON Response
header('Content-type: application/json');
echo json_encode($json);
