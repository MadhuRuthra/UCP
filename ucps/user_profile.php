<?php
session_start();
error_reporting(0);
// Include configuration.php
include_once('api/configuration.php');
include_once('api/send_request.php');
extract($_REQUEST);

if ($_SESSION['yjucp_user_id'] == "") { ?>
	<script>
		window.location = "index";
	</script>
	<?php exit();
}
site_log_generate("Index Page : Unknown User : '" . $_SESSION['yjucp_user_id'] . "' access this page on " . date("Y-m-d H:i:s"));
// To Send the request  API
$replace_txt = '{
  "user_id" : "' . $_SESSION["yjucp_user_id"] . '"
}';
				// Call the reusable cURL function
				$response = executeCurlRequest($api_url . "/list/view_user", "GET", $replace_txt);
// After got response decode the JSON result
$state1 = json_decode($response, false);
// To get the API response one by one data and assign to Session
if ($state1->response_status == 200) {
	// Looping the indicator is less than the count of response_result.if the condition is true to continue the process.if the condition are false to stop the process
	for ($indicator = 0; $indicator < count($state1->view_user); $indicator++) {
		$user_name = $state1->view_user[$indicator]->user_name;
		$user_email = $state1->view_user[$indicator]->user_email;
		$user_mobile = $state1->view_user[$indicator]->user_mobile;

		$user_type = $state1->view_user[$indicator]->user_type;
		$user_details = $state1->view_user[$indicator]->user_details;
		$user_status = $state1->view_user[$indicator]->user_status;
		$login_id = $state1->view_user[$indicator]->login_id;


	}
}

?>
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from colorlib.com/polygon/admindek/default/compose_sms.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 12 Dec 2019 16:09:13 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>

	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<title>View Profile ::
    <?= $site_title ?>
  </title>


	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="description"
		content="Admindek Bootstrap admin template made using Bootstrap 4 and it has huge amount of ready made feature, UI components, pages which completely fulfills any dashboard needs." />
	<meta name="keywords"
		content="bootstrap, bootstrap admin template, admin theme, admin dashboard, dashboard template, admin template, responsive" />
	<meta name="author" content="colorlib" />

  <link rel="icon" href="libraries/assets/png/favicon1.ico" type="image/x-icon">

	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Quicksand:500,700" rel="stylesheet">

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="description" content="Admindek Bootstrap admin template optimized for better UI/UX." />
	<meta name="keywords" content="bootstrap, admin template, dashboard, responsive design" />
	<meta name="author" content="colorlib" />

	<link rel="icon" href="libraries/assets/png/favicon1.ico" type="image/x-icon">

	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Quicksand:500,700" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="libraries/assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="libraries/assets/css/waves.min.css">
	<link rel="stylesheet" type="text/css" href="libraries/assets/css/feather.css">
	<link rel="stylesheet" type="text/css" href="libraries/assets/css/themify-icons.css">
	<link rel="stylesheet" type="text/css" href="libraries/assets/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="libraries/assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="libraries/assets/css/pages.css">


  <link rel="stylesheet" type="text/css" href="libraries/assets/css/feather.css">

  <link rel="stylesheet" type="text/css" href="libraries/assets/css/font-awesome-n.min.css">
  <link rel="stylesheet" type="text/css" href="libraries/assets/css/widget.css">

	<style>
		.form-container {
			background-color: #f8f9fa;
			padding: 20px;
			border-radius: 8px;
			box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
		}

		.label {
			font-weight: 600;
			color: #333;
		}

		.form-control {
			border-radius: 6px;
			padding: 10px;
		}

		.btn-success {
			background-color: #28a745;
			border-color: #28a745;
			border-radius: 8px;
			transition: background-color 0.3s;
		}

		.btn-success:hover {
			background-color: #218838;
		}

		.error_display {
			color: red;
			font-weight: 600;
		}

		.card-header {
			background-color: #007bff;
			color: white;
			border-radius: 8px 8px 0 0;
			padding: 10px;
			text-align: center;
		}
	</style>

</head>

<body>

	<div class="loader-bg">
		<div class="loader-bar"></div>
	</div>

	<div id="pcoded" class="pcoded">
		<div class="pcoded-overlay-box"></div>
		<div class="pcoded-container navbar-wrapper">



			<div class="pcoded-main-container">
				<div class="pcoded-wrapper">
				<? include("libraries/site_header.php"); ?>
					<? include("libraries/site_menu.php"); ?>
					<div class="pcoded-content">

						<div class="page-header card">
							<div class="row align-items-end">
								<div class="col-lg-8">
									<div class="page-header-title">
										<i class="feather icon-clipboard bg-c-blue"></i>
										<div class="d-inline">
											<h5>View Profile</h5>
											<!-- <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span> -->
										</div>
									</div>
								</div>
								<div class="col-lg-4">
									<div class="page-header-breadcrumb">
										<ul class=" breadcrumb breadcrumb-title">
											<li class="breadcrumb-item">
												<a href="dashboard"><i class="feather icon-home"></i></a>
											</li>
											<li class="breadcrumb-item">
												<a href="">View Profile</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>

						<div class="pcoded-inner-content">
							<!-- Form Entry Panel -->
							<div class="section-body">
								<div class="row">
									<div class="col-8 col-md-8 col-lg-8 offset-md-2">
										<div class="card" style="padding: 10px;">
											<h5 class="text-center">
												<i class="icofont icofont-sign-in"></i> Basic Information
											</h5>

											<table class="table table-bordered table-striped mt-3">
												<tbody>
													<!-- Client Name -->
													<tr>
														
														<th>Client Name <span style="color:#FF0000">*</span></th>
														<td><?= htmlspecialchars($user_name) ?></td>
													</tr>

													<!-- User Mobile -->
													<tr>
														<th>User Mobile <span style="color:#FF0000">*</span></th>
														<td><?= htmlspecialchars($user_mobile) ?></td>
													</tr>

													<!-- User Email -->
													<tr>
														<th>User Email ID <span style="color:#FF0000">*</span></th>
														<td><?= htmlspecialchars($user_email) ?></td>
													</tr>

													<!-- Login ID -->
													<tr>
														<th>Login ID <span style="color:#FF0000">*</span></th>
														<td><?= htmlspecialchars($login_id) ?></td>
													</tr>

													<!-- Remarks (if any) -->
													<?php if (!empty($rejected_comments)) { ?>
														<tr>
															<th>Remarks</th>
															<td><b><?= htmlspecialchars($rejected_comments) ?></b></td>
														</tr>
													<?php } ?>
												</tbody>
											</table>

											<!-- Error Display -->
											<?php if ($user_status != 'Y') { ?>
												<div class="row mt-4">
													<div class="col-md-12 text-center">
														<span class="error_display" id="id_error_display_onboarding"></span>
													</div>
												</div>

												<!-- Hidden Submit Button -->
												<div class="row mt-3" style="display:none;">
													<div class="col-md-12 text-center">
														<input type="hidden" name="call_function" id="call_function" value="edit_onboarding" />
														<input type="submit" name="submit_onboarding" id="submit_onboarding"
															class="btn btn-success btn-md btn-block" style="width:150px" value="Submit">
													</div>
												</div>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>


						</div>
					</div>
				</div>
			</div>


			<div id="styleSelector">
			</div>
		</div>
	</div>
	</div>
	</div>
	</div>
	</div>

	<script src="libraries/assets//js/xlsx.full.min.js"></script>
	<script>
		// start function document
		$(function () {
			$('#id_qrcode').fadeOut("slow");
		});

		document.body.addEventListener("click", function (evt) {
			$("#id_error_display_onboarding").html("");
		})
		// Sign up submit Button function Start
		$(document).on("submit", "form#frm_edit_onboarding", function (e) {
			e.preventDefault();
			$("#id_error_display_onboarding").html("");
			//get input field values 
			var clientname_txt = $('#clientname_txt').val();
			var login_id_txt = $('#login_id_txt').val();
			var mobile_no_txt = $('#mobile_no_txt').val();
			var email_id_contact = $('#email_id_contact').val();
			var flag = true;
			/********validate all our form fields***********/
			if (clientname_txt == "") {
				$('#clientname_txt').css('border-color', 'red');
				flag = false;
			}
			if (login_id_txt == "") {
				$('#login_id_txt').css('border-color', 'red');
				flag = false;
			}
			if (email_id_contact == "") {
				$('#email_id_contact').css('border-color', 'red');
				flag = false;
			}

			if (mobile_no_txt == "") {
				$('#mobile_no_txt').css('border-color', 'red');
				flag = false;
			}
			var mobile_no_txt = document.getElementById('mobile_no_txt').value;
			if (mobile_no_txt.length != 10) {
				$("#id_error_display_onboarding").html("Please enter a valid mobile number");
				flag = false;
			}
			if (!(mobile_no_txt.charAt(0) == "9" || mobile_no_txt.charAt(0) == "8" || mobile_no_txt.charAt(0) == "6" || mobile_no_txt.charAt(0) == "7")) {
				$("#id_error_display_onboarding").html("Please enter a valid mobile number");
				document.getElementById('mobile_no_txt').focus();
				flag = false;
			}
			/************************************/

			var email_id_contact = $('#email_id_contact').val();
			/* Email field validation  */
			var filter = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i
			if (filter.test(email_id_contact)) {
				// flag = true;
			} else {
				$("#id_error_display_onboarding").html("Email is invalid");
				document.getElementById('email_id_contact').focus();
				flag = false;
				e.preventDefault();
			}
			/********Validation end here ****/

			// alert("FLAG=="+flag+"==");
			$('#submit_onboarding').attr('disabled', false);
			/* If all are ok then we send ajax request to call_functions.php *******/
			if (flag) {
				var fd = new FormData(this);
				$.ajax({
					type: 'post',
					url: "ajax/call_functions.php",
					dataType: 'json',
					data: fd,
					contentType: false,
					processData: false,
					beforeSend: function () { // Before Send to Ajax
						$('#submit_onboarding').attr('disabled', true);
						$('#load_page').show();
					},
					complete: function () { // After complete the Ajax
						$('#submit_onboarding').attr('disabled', false);
						$('#load_page').hide();
					},
					success: function (response) { // Success
						// exit();
						if (response.status == 2 || response.status == 0) { // Failure Response
							$('#submit_onboarding').attr('disabled', false);
							$("#id_error_display_onboarding").html(response.msg);
						} else if (response.status == 1) { // Success Response
							$('#submit_onboarding').attr('disabled', false);
							$("#id_error_display_onboarding").html(response.msg);
							setInterval(function () {
								window.location = 'dashboard';
							}, 2000);
						}
					},
					error: function (response, status, error) { // If any error occurs
						// die();
						$('#submit_onboarding').attr('disabled', false);
						$("#id_error_display_onboarding").html(response.msg);
					}
				});
			}
		});
		// Sign up submit Button function End
		function address_validation(e) {
			// Accept only alphanumeric characters, spaces, '/', ',', '.', and '-'
			var key = e.key;
			var allowedCharacters = /^[a-zA-Z0-9/\s,.-]$/;
			if (allowedCharacters.test(key) || key === " ") {
				return true;
			}
			return false;
		}

		function clsAlphaNoOnly(e) { // Accept only alpha numerics, no special characters 
			var key = e.keyCode;
			if ((key >= 65 && key <= 90) || (key >= 97 && key <= 122) || (key >= 48 && key <= 57) || (key == 32) || (key == 95)) {
				return true;
			}
			return false;
		}

		// TEMplate Name - Space
		$(function () {
			$('#clientname_txt').on('keypress', function (e) {
				if (e.which == 32) {
					console.log('Space Detected');
					return false;
				}
			});
		});
		$(function () {
			$('#contact_person_txt').on('keypress', function (e) {
				if (e.which == 32) {
					console.log('Space Detected');
					return false;
				}
			});
		});

		function single_quote_validation(e) {
			// Accept only alphanumeric characters, spaces, '/', ',', '.', and '-'
			var key = e.key;
			var allowedCharacters = /^[a-zA-Z0-9\[\]\$\!\#\%\^\&\\(\)\-\+\=\-\;\:\,\.\?\@\_ ]$/;
			if (allowedCharacters.test(key) || key === " ") {
				return true;
			}
			return false;
		}

		function single_quote(e) {
			// Accept only alphanumeric characters, spaces, '/', ',', '.', '-', and some special characters
			var key = e.key;
			var allowedCharacters = /^[a-zA-Z0-9\[\]\$\!\#\%\^\&\/\(\)\-\+\=\-\;\:\,\.\?\@\_\ ]$/;
			if (allowedCharacters.test(key) || key === " ") {
				return true;
			}
			return false;
		}

	</script>
	<script type="461d1add94eeb239155d648f-text/javascript" src="libraries/assets/js/jquery.min.js"></script>
	<script type="461d1add94eeb239155d648f-text/javascript" src="libraries/assets/js/jquery-ui.min.js"></script>
	<script type="461d1add94eeb239155d648f-text/javascript" src="libraries/assets/js/popper.min.js"></script>
	<script type="461d1add94eeb239155d648f-text/javascript" src="libraries/assets/js/bootstrap.min.js"></script>

	<script type="461d1add94eeb239155d648f-text/javascript" src="libraries/assets/js/jquery.slimscroll.js"></script>

	<script src="libraries/assets/js/waves.min.js" type="461d1add94eeb239155d648f-text/javascript"></script>

	<script type="461d1add94eeb239155d648f-text/javascript" src="libraries/assets/js/modernizr.js"></script>
	<script type="461d1add94eeb239155d648f-text/javascript" src="libraries/assets/js/css-scrollbars.js"></script>

	<script src="libraries/assets/js/pcoded.min.js" type="461d1add94eeb239155d648f-text/javascript"></script>
	<script src="libraries/assets/js/vertical-layout.min.js" type="461d1add94eeb239155d648f-text/javascript"></script>
	<script src="libraries/assets/js/jquery.mcustomscrollbar.concat.min.js"
		type="461d1add94eeb239155d648f-text/javascript"></script>
	<script type="461d1add94eeb239155d648f-text/javascript" src="libraries/assets/js/script.js"></script>

	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"
		type="461d1add94eeb239155d648f-text/javascript"></script>
	<script type="461d1add94eeb239155d648f-text/javascript">
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());

	gtag('config', 'UA-23581568-13');
</script>
	<script src="libraries/assets/js/rocket-loader.min.js" data-cf-settings="461d1add94eeb239155d648f-|49"
		defer=""></script>
</body>

<!-- Mirrored from colorlib.com/polygon/admindek/default/compose_sms.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 12 Dec 2019 16:09:13 GMT -->

</html>
