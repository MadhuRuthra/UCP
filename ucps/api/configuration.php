<?php
session_start();
set_time_limit(0);
header("Cache-Control: no-cache, must-revalidate, max-age=0");
header("Expires: 0");
header("Pragma: no-cache");

// Check if the session user ID is not set or empty
if ((!isset($_SESSION['yjucp_user_id']) || $_SESSION['yjucp_user_id'] == "" || empty($_SESSION['yjucp_user_id'])) && isset($_REQUEST['call_function']) && $_REQUEST['call_function'] != 'signin' && $_REQUEST['call_function'] != "onboarding_signup" && $_REQUEST['call_function'] != "resetpwd" ) {
    echo '<script type="text/javascript">
    window.location.replace("../index");
</script>';
exit;
}

// Live server Credentials
$servername = "localhost";
// $username = "yj_ucp_portal";
// $password = "UCP-My5ql@YJ_202!*u21^c3^p16";
$username = "admin";
$password = "Password@123";
$dbname = "ucp";

// SMS Gateway Board 1 credentials - Start
$full_pathurl = '/var/www/html/ucp/';
$api_url    = "http://localhost:10024";
// $api_url = "https://yeejai.in/ucp_whatsapp";
$api_result_url = 'http://192.168.1.198:8000/wg_api_v2/getResult';
$api_adminuser  = "administrator";
$api_adminpswd  = "12345678";
$site_title     = "SMS API";
// $site_socket_url    ="https://yeejai.in/ucp_whatsapp/";
// $site_url = "https://yeejai.in/ucp/";
$site_url = "http://localhost/ucp/";



// Whatsapp Connection - Start
$monthly_allowed_qty    = 800;
$whatsapp_mobno         = "8610110464"; // 8610110464 - Shanthini 2 Mobile No
$whatsapp_wabaid        = "100175206060494"; // 8610110464 - Shanthini 2 Mobile No
$whatsapp_phone_id      = "103741605696935"; // 8610110464 - Shanthini 2 Mobile No
$whatsapp_bearer_token  = 'EAAlaTtm1XV0BANV3Lc8mA5kEO4BqWsCKudO6lNWGcVyl6O6wIK7mJqXCtPtpyjhO36ZA1eEGLra4Q21T7aEWns1VxqwcOFVR4BtQsxShdMB9zBIPjN4gaj3KTz5ZBHnEtO3WVkC26UdLpM75vIZBIZCw8eCRVus4NcZC7FZC3NhBFqpF3ntmGh13ZAZBdUcVtwJ9Mcout3A1ZCwZDZD';
$whatsapp_tmpl_url      = "https://graph.facebook.com/v15.0/".$whatsapp_wabaid;             // Collect the Template URL
$whatsapp_tmplsend_url  = "https://graph.facebook.com/v15.0/".$whatsapp_phone_id;           // Send Whatsapp message URL
$whatsapp_tmplate_url   = "https://graph.facebook.com/v15.0/";

// Razorpay TEST Configuration
$rp_keyid	= "rzp_test_3d14kxnIjpcKIz";
$rp_keysecret   = "kSusodeEnSRcjdDLmtZEe0ud";

// Create connection to MySQL DB
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set MySQL sql mode
mysqli_query($conn, "SET SESSION sql_mode = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION'");
date_default_timezone_set("Asia/Kolkata"); // Set timezone

// Function to generate log files
function site_log_generate($log_msg, $location = '')
{
    $max_size = 10485760; // 10 MB allowed
    $log_base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
    $log_url = $log_base_url . $_SERVER["REQUEST_URI"] . " : IP Address : " . $_SERVER['SERVER_ADDR'] . " ==> ";

    $log_filename = "site_log";
    if (!file_exists($location . "log/" . $log_filename)) {
        mkdir($location . "log/" . $log_filename, 0777, true);
    }
    $log_file_data1 = $location . "log/" . $log_filename . '/log_' . date('d-M-Y');
    $log_file_data = $log_file_data1 . '.log';

    clearstatcache();
    $size = file_exists($log_file_data) ? filesize($log_file_data) : 0;

    // If size exceeds, rename the file
    if ($size > $max_size) {
        shell_exec("mv " . escapeshellarg($log_file_data) . " " . escapeshellarg($log_file_data1 . "-" . date('YmdHis') . ".log"));
    }

    // Append the data into the log file
    file_put_contents($log_file_data, $log_url . $log_msg . "\n", FILE_APPEND);
}


// Function to process API response
function processResponse($response)
{
    site_log_generate("API send Response: [$response] on " . date("Y-m-d H:i:s"), "../");


    $response_object = json_decode($response);

          // Prevent recursive logout calls by checking the isLogoutRequest flag
        if ($response_object->response_status == 200) {
            return array("status" => 1, "msg" => $response_object->response_msg); // Success
        }
        else if ($response_object->response_status == 403) {
            session_destroy();
            header("Location: index");
                exit();
              }
          else {
            return array("status" => 0, "msg" => $response_object->response_msg); // Failure
            }
}

function handleSessionLogout()
{
    session_destroy();
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
session_write_close(); 
}
?>
