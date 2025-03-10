<?php
/*
This page has some functions which is access from Frontend.
This page is act as a Backend page which is connect with Node JS API and PHP Frontend.
It will collect the form details and send it to API.
After get the response from API, send it back to Frontend.

Version : 1.0
Author : Madhubala (YJ0009)
Date : 01-Jul-2023
*/
session_start();
error_reporting(E_ALL);
// Include configuration.php
include_once('../api/configuration.php');
extract($_REQUEST);
$current_date = date("Y-m-d H:i:s");

if ($_SESSION["yjucp_user_status"] == 'N' or $_SESSION["yjucp_user_status"] == 'R') {
    if ($site_page_name != 'user_profiles' and $site_page_name != 'dashboard') {
        ?><script>
window.location = "user_profiles";
</script>
<?}
} 
site_log_generate("Site Header Page : " . $_SESSION['yjucp_user_name'] . " Access on MADHU " . date("Y-m-d H:i:s"), '../');

$bearer_token = 'Authorization: ' . $_SESSION['yjucp_bearer_token'] . '';
$replace_txt = '{
     "user_id" : "' . $_SESSION['yjucp_user_id'] . '"    }';
$curl = curl_init();
curl_setopt_array(
    $curl,
    array(
        CURLOPT_URL => $api_url . '/site_menu/product_header',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30, // Set timeout to 20 seconds
        CURLOPT_CONNECTTIMEOUT => 30, // Set timeout for the connection phase to 5 seconds
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            $bearer_token,
            'Content-Type: application/json'
        ),
    )
);
site_log_generate("Site Header Page : " . $_SESSION['yjucp_user_name'] . " Execute the service [$replace_txt] on " . date("Y-m-d H:i:s"), '../');
$response = curl_exec($curl);
curl_close($curl);
$sms = json_decode($response, false);

   // Prevent recursive logout calls by checking the isLogoutRequest flag
   if ($sms->response_status == 403) {
    handleSessionLogout();
}

$indicatori = 0;
if ($sms->response_status == 200) {
    for ($indicator = 0; $indicator < count($sms->report); $indicator++) {
        $indicatori++;
        $user_master_id = $sms->report[$indicator]->user_master_id;
        $available_credits[] = $sms->report[$indicator]->available_credits;
        $total_credits = $sms->report[$indicator]->total_credits;
        $user_name = $sms->report[$indicator]->user_name;
        $used_credits = $sms->report[$indicator]->used_credits;
        $rights_name[] = $sms->report[$indicator]->rights_name;
    }
}
?>
<nav class="navbar header-navbar pcoded-header" style="height: 70px;">
	<div class="navbar-wrapper">
		<div class="navbar-logo">
			<img class="img-fluid" src="libraries/assets/png/YJ-Logo" alt="Theme-Logo" />
			<a class="mobile-menu" id="mobile-collapse" href="#!">
				<i class="feather icon-menu icon-toggle-right"></i>
			</a>
			<a class="mobile-options waves-effect waves-light">
				<i class="feather icon-more-horizontal"></i>
			</a>
		</div>

		<div class="navbar-container container-fluid">
			<ul class="nav-left">
				<li class="header-search">
					<div class="main-search morphsearch-search">
						<div class="input-group">
							<span class="input-group-prepend search-close">
								<i class="feather icon-x input-group-text"></i>
							</span>
							<input type="text" class="form-control" placeholder="Enter Keyword">
							<span class="input-group-append search-btn">
								<i class="feather icon-search input-group-text"></i>
							</span>
						</div>
					</div>
				</li>
				<li>
					<a href="#!" onclick="javascript:toggleFullScreen()" class="waves-effect waves-light">
						<i class="full-screen feather icon-maximize"></i>
					</a>
				</li>
			</ul>

			<ul class="nav-right"
				style="display: flex; align-items: center; gap: 20px; list-style: none; padding: 0; margin: 0;">
				<!-- Cards Section -->
				<? if($_SESSION['yjucp_user_master_id'] != '1'){ ?>
				<li style="display: flex; gap: 5px;">
					<!-- SMS Card -->
					<div class="card card-red st-cir-card text-white" style="width:200px;">
						<div class="card-block" style="padding: 5px;">
							<div class="row align-items-center">
								<div class="col-auto">
									<div id="status-round-1" class="chart-shadow st-cir-chart" style="width: 40px; height: 40px;">
										<h5 style="font-size: 14px;">
											<? echo $rights_name[0] ?>
										</h5>
									</div>
								</div>
								<div class="col text-center" style="padding: 0;">
									<h3 class="f-w-700 m-b-0" style="font-size: 16px;">
										<? echo  $available_credits[0] ?>
									</h3>
									<!-- <h6 class="m-b-0" style="font-size: 12px;">SMS</h6> -->
								</div>
							</div>
						</div>
					</div>

					<!-- SMPP Card -->
					<div class="card card-blue st-cir-card text-white" style="width:200px;">
						<div class="card-block" style="padding: 5px;">
							<div class="row align-items-center">
								<div class="col-auto">
									<div id="status-round-2" class="chart-shadow st-cir-chart" style="width: 40px; height: 40px;">
										<h5 style="font-size: 14px;">
											<? echo $rights_name[1] ?>
										</h5>
									</div>
								</div>
								<div class="col text-center" style="padding: 0;">
									<h3 class="f-w-700 m-b-0" style="font-size: 16px;">
										<? echo $available_credits[1] ?>
									</h3>
									<!-- <h6 class="m-b-0" style="font-size: 12px;">SMPP</h6> -->
								</div>
							</div>
						</div>
					</div>

					<!-- WhatsApp Card -->
					<div class="card card-green st-cir-card text-white" style="width:200px;">
						<div class="card-block" style="padding: 5px;">
							<div class="row align-items-center">
								<div class="col-auto">
									<div id="status-round-3" class="chart-shadow st-cir-chart" style="width: 70px; height: 40px;">
										<h5 style="font-size: 14px;">
											<? echo $rights_name[2] ?>
										</h5>
									</div>
								</div>
								<div class="col text-center" style="padding: 0;">
									<h3 class="f-w-700 m-b-0" style="font-size: 16px;">
										<? echo $available_credits[2] ?>
									</h3>
									<!-- <h6 class="m-b-0" style="font-size: 12px;">WhatsApp</h6> -->
								</div>
							</div>
						</div>
					</div>
				</li>
				<? }?>

				<!-- User Profile Section -->
				<li class="user-profile header-notification" style="margin-left: auto;">
					<div class="dropdown-primary dropdown">
						<div class="dropdown-toggle" data-toggle="dropdown"
							style="display: flex; align-items: center; cursor: pointer;">
							<img src="libraries/assets/jpg/avatar-1.png" class="img-radius" alt="User-Profile-Image"
								style="width: 40px; height: 40px; border-radius: 50%; margin-right: 8px;">
							<span style="font-weight: 500; color: #333; margin-right: 8px;">
								Hi, <?= strtoupper($_SESSION['yjucp_user_name']) ?>
							</span>
							<i class="feather icon-chevron-down" style="font-size: 16px;"></i>
						</div>

						<ul class="show-notification profile-notification dropdown-menu" style="position: absolute; top: 100%; left: 0; min-width: 150px; 
                                   padding: 10px 0; margin: 0; background-color: #fff; 
                                   box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); list-style: none;">
							<li style="padding: 8px 16px;">
								<a href="user_profile" style="display: flex; align-items: center; text-decoration: none; color: #333;">
									<i class="feather icon-user" style="margin-right: 8px;"></i> My Profile
								</a>
							</li>
							<li style="padding: 8px 16px;">
								<a href="change_password"
									style="display: flex; align-items: center; text-decoration: none; color: #333;">
									<i class="feather icon-lock" style="margin-right: 8px;"></i> Change Password
								</a>
							</li>
							<li style="padding: 8px 16px;">
								<a href="logout" style="display: flex; align-items: center; text-decoration: none; color: #333;">
									<i class="feather icon-log-out" style="margin-right: 8px;"></i> Logout
								</a>
							</li>
						</ul>
					</div>
				</li>
			</ul>
		</div>
	</div>
</nav>