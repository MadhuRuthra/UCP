<?php

session_start();
error_reporting(E_ALL);
extract($_REQUEST);
$bearer_token = 'Authorization: ' . $_SESSION['yjucp_bearer_token'];
include_once "./configuration.php";

function executeCurlRequest($url, $method, $requestFields, $isLogoutRequest = false)
{
    global $bearer_token;

    $headers = ["Content-Type: application/json"];
    if (strpos($url, "/login/p_login") === false) {
        $headers[] = $bearer_token;
    }

    site_log_generate("Sent request to $url with method [$method] and payload [$requestFields] on " . date("Y-m-d H:i:s"), "../");

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_POSTFIELDS => $requestFields,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => false
    ]);

    $response = curl_exec($curl);
    if (curl_errno($curl)) {
        $response = 'cURL Error: ' . curl_error($curl);
    }
    curl_close($curl);

    $responseData = json_decode($response, true);
    // Prevent recursive logout calls by checking the isLogoutRequest flag
    if (!$isLogoutRequest && (empty($response) || ($responseData['response_status'] ?? null) === 403)) {
        handleSessionLogout();
    }

    site_log_generate("API Service response [$response] on " . date("Y-m-d H:i:s"), "../");
    return $response;
}


?>