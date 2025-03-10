<?php
include_once('api/configuration.php');
include_once('api/send_request.php');

header('Cache-Control: no cache'); // no cache // This is for avoid failure in submit form  pagination form details page
session_cache_limiter('private_no_expire, must-revalidate'); // works // This is for avoid failure in submit form  pagination form details page

session_start();// start session
site_log_generate("Logout Page : User : '" . $_SESSION['yjucp_user_name'] . "' logged out successfully on " . date("Y-m-d H:i:s"));
$current_date = date("Y-m-d H:i:s"); // get date and time
// Step 1: Get the current date
$todayDate = new DateTime();
// Step 2: Convert the date to Julian date
$baseDate = new DateTime($todayDate->format('Y-01-01'));
$julianDate = $todayDate->diff($baseDate)->format('%a') + 1; // Adding 1 since the day of the year starts from 0
// Step 3: Output the result in 3-digit format
// echo "Today's Julian date in 3-digit format: " . str_pad($julianDate, 3, '0', STR_PAD_LEFT);
$year = date("Y");
$julian_dates = str_pad($julianDate, 3, '0', STR_PAD_LEFT);
$hour_minutes_seconds = date("His");
$random_generate_three = rand(100, 999);
$replace_txt = '{
  "request_id" : "' . $_SESSION["yjucp_user_short_name"] . "_" . $year . $julian_dates . $hour_minutes_seconds . "_" . $random_generate_three . '"
}';

    // Call the reusable cURL function
$response = executeCurlRequest($api_url . "/logout", "POST", $replace_txt);
session_destroy();
// After got response decode the JSON result
$header = json_decode($response, false);
if ($header->response_status == 403 || $response == '') {
  header("Location: index");
  exit(); // Stop further execution after redirect
 }
// Unset specific session variables
unset($_SESSION["yjucp_parent_id"]);
unset($_SESSION["yjucp_user_id"]);
unset($_SESSION["yjucp_user_master_id"]);
unset($_SESSION["yjucp_user_name"]);
unset($_SESSION["yjucp_user_short_name"]);
unset($_SESSION["yjucp_api_key"]);
unset($_SESSION["yjucp_user_permission"]);
unset($_SESSION["yjucp_bearer_token"]);
unset($_SESSION["yjucp_login_id"]);
unset($_SESSION["yjucp_user_email"]);
unset($_SESSION["yjucp_user_mobile"]);
unset($_SESSION["yjucp_price_per_sms"]);
unset($_SESSION["yjucp_netoptid"]);
unset($_SESSION["yjucp_usraprstat"]);
unset($_SESSION["yjucp_usr_mgt_status"]);
unset($_SESSION["yjucp_login_time"]);

site_log_generate("Logout Page : All sessions destroyed successfully on " . date("Y-m-d H:i:s"));
header("Location: index");
exit(); // Stop further execution after redirect
?>