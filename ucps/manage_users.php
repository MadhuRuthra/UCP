<?php
session_start(); // start session
error_reporting(0); // The error reporting function
include_once 'api/configuration.php'; // Include configuration.php
include_once('api/send_request.php');
// Check if the parameters are set
if (isset($_GET['slot_id'], $_GET['usr_vlu'], $_GET['cnt_vlu'], $_GET['usrsmscrd_id'])) {
    // Extract the parameters from the GET request
    $slot_id = $_GET['slot_id'];
    $usr_vlu = $_GET['usr_vlu'];
    $cnt_vlu = $_GET['cnt_vlu'];
    $usrsmscrd_id = $_GET['usrsmscrd_id'];
} else {
}
?>
<!DOCTYPE html>
<html lang="en">
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>

	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<title>Manage Users ::
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

	<link rel="stylesheet" type="text/css" href="libraries/assets/css/bootstrap.min.css">

	<link rel="stylesheet" href="libraries/assets/css/waves.min.css" type="text/css" media="all">

	<link rel="stylesheet" type="text/css" href="libraries/assets/css/feather.css">

	<link rel="stylesheet" type="text/css" href="libraries/assets/css/themify-icons.css">

	<link rel="stylesheet" type="text/css" href="libraries/assets/css/icofont.css">

	<link rel="stylesheet" type="text/css" href="libraries/assets/css/font-awesome.min.css">

	<link rel="stylesheet" type="text/css" href="libraries/assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="libraries/assets/css/pages.css">


	<link rel="stylesheet" type="text/css" href="libraries/assets/css/feather.css">

	<link rel="stylesheet" type="text/css" href="libraries/assets/css/font-awesome-n.min.css">
	<link rel="stylesheet" type="text/css" href="libraries/assets/css/widget.css">

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
											<h5>Manage Users</h5>
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
											<li class="breadcrumb-item"><a href="message_credit">Manage Users</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>

						<div class="pcoded-inner-content">

							<div class="main-body">
								<div class="page-wrapper">

									<div class="page-body">


										<!-- Main Content -->
										<div class="main-content">
											<section class="section">
												<div class="section-body">
													<div class="row">
														<div class="col-12 col-md-6 col-lg-6 offset-3">
															<div class="card">
																<form class="needs-validation" novalidate="" id="manage_users" name="manage_users"
																	action="#" method="post" enctype="multipart/form-data">
																	<div class="card-body">
																		<!-- Admin Select menu Start-->
																		<div class="form-group mb-2 row">
																			<label class="col-sm-4 col-form-label">Select User Type
																			</label>
																			<div class="col-sm-8">
																				<select name="slt_user_type" id="slt_user_type" class="form-control"
																					data-toggle="tooltip" data-placement="top" title="" required=""
																					data-original-title="Select User Type" tabindex="1" autofocus>
																					<?php // To get the child user list from API
                            $replace_txt = '{ "user_id" : "' . $_SESSION['yjucp_user_id'] . '"  }';
														$data = '';
                                // Call the reusable cURL function
                            $response = executeCurlRequest($api_url . "/list/user_master", "GET", $replace_txt);
                            // After got response decode the JSON result
                            $state1 = json_decode($response, false);
                            // Based on the JSON response, list in the option button
														if (!empty($state1) && isset($state1->response_code) && $state1->response_code == 1 && isset($state1->report) && is_array($state1->report)) {
															foreach ($state1->report as $report) {
																if(($_SESSION["yjucp_user_master_id"] == 2)&& ($report->user_master_id == 3)){
															 $data .= '<option value="' . htmlspecialchars($report->user_master_id) . '">' 
																				. htmlspecialchars($report->user_type) . '</option>';
													 }
														else if(($_SESSION["yjucp_user_master_id"] == 1)&& ($report->user_master_id != 1)){
															 $data .= '<option value="' . htmlspecialchars($report->user_master_id) . '">' 
																				. htmlspecialchars($report->user_type) . '</option>';
																 }
													}
													echo $data;
													} else {
															echo '<option value="">No available options</option>';
													}
                            ?>
																				</select>
																			</div>
																		</div>

																		<!-- Admin Select menu End-->
																		<!-- User Name -->
																		<div class="form-group mb-2 row">
																			<label class="col-sm-4 col-form-label">User Name</label>
																			<div class="col-sm-8">
																				<input type="text" name="clientname_txt" id="clientname_txt"
																					placeholder="User Name" class="form-control" value=""
																					onkeypress="return clsAlphaNoOnly(event)" required tabindex="3"
																					data-toggle="tooltip" data-placement="top" title=""
																					data-original-title="User Name">
																			</div>
																		</div>

																		<!-- Phone Number -->
																		<div class="form-group mb-2 row">
																			<label class="col-sm-4 col-form-label">Phone Number</label>
																			<div class="col-sm-8">
																				<input type="text" name="mobile_no_txt" id="mobile_no_txt"
																					placeholder="Phone Number" class="form-control" value=""
																					onkeypress="return clsAlphaNoOnly(event)" required tabindex="3"
																					data-toggle="tooltip" data-placement="top" title=""
																					data-original-title="Phone Number">
																			</div>
																		</div>

																		<!-- Email Address -->
																		<div class="form-group mb-2 row">
																			<label class="col-sm-4 col-form-label">Email Address</label>
																			<div class="col-sm-8">
																				<input type="text" name="email_id_contact" id="email_id_contact"
																					placeholder="Email Address" class="form-control" value="" required
																					tabindex="3" data-toggle="tooltip" data-placement="top" title=""
																					data-original-title="Email Address">
																			</div>
																		</div>

																		<div class="form-group mb-2 row">
																			<label class="col-sm-4 col-form-label">New Password</label>
																			<div class="col-sm-8">
																				<div class="input-group" title="" data-toggle="tooltip" data-placement="top"
																					title="" style="margin-bottom:0.40em;"
																					data-original-title="New Password : [Atleast 8 characters and Must Contains Numeric, Capital Letters and Special characters]">
																					<input type="password" name="txt_new_password" id='txt_new_password'
																						class="form-control" maxlength="100" value="" tabindex="2" required=""
																						placeholder="New Password : [Atleast 8 characters and Must Contains Numeric, Capital Letters and Special characters]"
																						onblur="return checkPasswordStrength()">
																					<div class="input-group-prepend">
																						<div class="input-group-text" onclick="password_visible1()"
																							id="display_visiblitity"><i class="fas fa-eye-slash custom-icon"></i>
																						</div>
																					</div>

																				</div>
																				<div id='idtxt_new_password' class='text-danger'></div>

																				<div class="progress" style="margin-top: 3px; height: 3px;">
																					<div class="progress-bar" role="progressbar" aria-valuenow="0"
																						aria-valuemin="0" aria-valuemax="100" style="width:0%" data-toggle="tooltip"
																						data-placement="top" title="" data-original-title="Password Strength Meter"
																						placeholder="Password Strength Meter">
																					</div>
																				</div>
																			</div>
																		</div>

																		<div class="form-group mb-2 row">
																			<label class="col-sm-4 col-form-label">Confirm Password</label>
																			<div class="col-sm-8">
																				<div class="input-group" title="" data-toggle="tooltip" data-placement="top"
																					title=""
																					data-original-title="Confirm Password : [Atleast 8 characters and Must Contains Numeric, Capital Letters and Special characters]">
																					<input type="password" name="txt_confirm_password" id='txt_confirm_password'
																						class="form-control" maxlength="100" value="" tabindex="3" required=""
																						placeholder="Your Confirm Password">
																					<div class="input-group-prepend">
																						<div class="input-group-text" onclick="password_visible2()"
																							id="display_visiblitity_1"><i class="fas fa-eye-slash custom-icon"></i>
																						</div>
																					</div>
																				</div>
																			</div>
																		</div>

																		<input type="checkbox" name="chk_terms" id="chk_terms" value="">
																		<span class="text-inverse">I read and accept <a href="#" id="show_terms">Terms &amp;
																				Conditions.</a></span>

																	</div>


																	<div class="card-footer text-center">
																		<span class="error_display" id='id_count_display' style="color:red"></span>
																		<!-- Error Display -->
																		<input type="hidden" class="form-control" name='tmpl_call_function'
																			id='tmpl_call_function' value='message_credit' />
																		<input type="hidden" class="form-control" name='hid_usrsmscrd_id'
																			id='hid_usrsmscrd_id' value='<?= $usrsmscrd_id ?>' />
																		<input type="submit" name="submit" id="submit" tabindex="10" value="Submit"
																			class="btn btn-success">
																	</div>
																</form>
															</div>
														</div>
													</div>
												</div>
										</div>
										</section>

									</div>

								</div>
							</div>
							<!-- Preview Data Modal content-->
							<!-- Modal content-->
							<div class="modal fade" id="default-Modal" tabindex="-1" role="dialog">
								<div class="modal-dialog" role="document" style=" max-width: 75% !important;">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title">Template Details</h4>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body" id="id_modal_display"
											style=" word-wrap: break-word; word-break: break-word;">
											<h5>No Data Available</p>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-success waves-effect " data-dismiss="modal">Close</button>
										</div>
									</div>

								</div>
							</div>
							<!-- Preview Data Modal content End-->

							<!-- Confirmation details content-->
							<div class="modal" tabindex="-1" role="dialog" id="upload_file_popup">
								<div class="modal-dialog" role="document">
									<div class="modal-content" style="width: 400px;">
										<div class="modal-body">
											<button type="button" class="close" data-dismiss="modal" style="width:30px" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
											<p id="file_response_msg"></p>
											<span class="ex_msg">Are you sure you want to create a campaign?</span>
										</div>
										<div class="modal-footer" style="margin-right:30%;">
											<button type="button" class="btn btn-danger save_compose_file" data-dismiss="modal">Yes</button>
											<button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
										</div>
									</div>
								</div>
							</div>
							<!-- After Submit Preview Data Modal content End-->
							<? include("libraries/site_footer.php"); ?>

						</div>
					</div>

					<!-- Confirmation details content-->
					<div class="modal" tabindex="-1" role="dialog" id="campaign_compose_message">
						<div class="modal-dialog" role="document">
							<div class="modal-content" style="width: 400px;">
								<div class="modal-body">
									<button type="button" class="close" data-dismiss="modal" style="width:30px" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
									<div class="container" style="text-align: center;">
										<img alt="image" style="width: 50px; height: 50px; display: block; margin: 0 auto;"
											id="image_display">

										<span id="message"></span>
									</div>
								</div>
								<div class="modal-footer" style="margin-right:40%; text-align: center;">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Okay</button>
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
	<script>
	function checkPasswordStrength() {
		var number = /([0-9])/;
		var alphabets = /([a-zA-Z])/;
		var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
		if ($('#txt_new_password').val().length < 8) {
			$('#idtxt_new_password').html("Weak (should be atleast 8 characters.)");
			$('#txt_new_password').css('border-color', 'red');
			return false;
		} else {
			if ($('#txt_new_password').val().match(number) && $('#txt_new_password').val().match(alphabets) && $(
					'#txt_new_password').val().match(special_characters)) {
				$('#idtxt_new_password').html("");
				$('#txt_new_password').css('border-color', '#a0a0a0');
				return true;
			} else {
				$('#idtxt_new_password').html("Medium (should include alphabets, numbers and special characters.)");
				$('#txt_new_password').css('border-color', 'red');
				return false;
			}
		}
	}

	function password_visible1() {
		var x = document.getElementById("txt_new_password");
		if (x.type === "password") {
			x.type = "text";
			$('#display_visiblitity').html('<i class="fas fa-eye"></i>');
		} else {
			x.type = "password";
			$('#display_visiblitity').html('<i class="fas fa-eye-slash custom-icon"></i>');
		}
	}

	function password_visible2() {
		var x = document.getElementById("txt_confirm_password");
		if (x.type === "password") {
			x.type = "text";
			$('#display_visiblitity_1').html('<i class="fas fa-eye"></i>');
		} else {
			x.type = "password";
			$('#display_visiblitity_1').html('<i class="fas fa-eye-slash custom-icon"></i>');
		}
	}

	function password_visible() {
		var x = document.getElementById("txt_ex_password");
		if (x.type === "password") {
			x.type = "text";
			$('#id_signup_display_visiblitity').html('<i class="fas fa-eye"></i>');
		} else {
			x.type = "password";
			$('#id_signup_display_visiblitity').html('<i class="fas fa-eye-slash custom-icon"></i>');
		}
	}

	var percentage = 0;

	function check(n, m) {
		var strn_disp = "Very Weak Password";
		if (n < 6) {
			percentage = 0;
			$(".progress-bar").css("background", "#FF0000");
			strn_disp = "Very Weak Password";
		} else if (n < 7) {
			percentage = 20;
			$(".progress-bar").css("background", "#758fce");
			strn_disp = "Weak Password";
		} else if (n < 8) {
			percentage = 40;
			$(".progress-bar").css("background", "#ff9800");
			strn_disp = "Medium Password";
		} else if (n < 10) {
			percentage = 60;
			$(".progress-bar").css("background", "#A5FF33");
			strn_disp = "Strong Password";
		} else {
			percentage = 80;
			$(".progress-bar").css("background", "#129632");
			strn_disp = "Very Strong Password";
		}

		//Lowercase Words only
		if ((m.match(/[a-z]/) != null)) {
			percentage += 5;
		}

		//Uppercase Words only
		if ((m.match(/[A-Z]/) != null)) {
			percentage += 5;
		}

		//Digits only
		if ((m.match(/0|1|2|3|4|5|6|7|8|9/) != null)) {
			percentage += 5;
		}

		//Special characters
		if ((m.match(/\W/) != null) && (m.match(/\D/) != null)) {
			percentage += 5;
		}

		// Update the width of the progress bar
		$(".progress-bar").css("width", percentage + "%");
		if (percentage > 80) {
			$("#strength_display").html("");
		} else {
			$("#strength_display").html(strn_disp);
		}
	}
	// Update progress bar as per the input
	$(document).ready(function() {
		// Whenever the key is pressed, apply condition checks.
		$("#txt_new_password").keyup(function() {
			var m = $(this).val();
			var n = m.length;

			// Function for checking
			check(n, m);
		});
	});

	$(document).ready(function() {
		// Limit the input to 10 digits
		$('#mobile_no_txt').on('input', function() {
			var currentValue = $(this).val();
			var sanitizedValue = currentValue.replace(/\D/g, '').substring(0, 10);
			$(this).val(sanitizedValue);
		});
	});


	// Sign up submit Button function Start
	$(document).on("submit", "form#manage_users", function(e) {
		e.preventDefault();
		$("#id_count_display").html("");
		var flag = true;
		// Get input field values
		var clientname_txt = $('#clientname_txt').val().trim();
		var mobile_no_txt = $('#mobile_no_txt').val();
		var email_id_contact = $('#email_id_contact').val();
		var password = $('#txt_new_password').val();
		var confirm_password = $('#txt_confirm_password').val();

		// Clear previous field borders
		$('#clientname_txt, #mobile_no_txt, #email_id_contact, #txt_new_password, #txt_confirm_password')
			.css('border-color', '');

		// Name validation
		if (clientname_txt == "") {
			$('#clientname_txt').css('border-color', 'red');
			flag = false;
		}

		// Mobile number validation (India only)
		if (mobile_no_txt == "") {
			$('#mobile_no_txt').css('border-color', 'red');
			flag = false;
		} else if (!/^[6789]\d{9}$/.test(mobile_no_txt)) {
			$("#id_count_display").html("Please enter a valid Indian mobile number.");
			$('#mobile_no_txt').css('border-color', 'red');
			flag = false;
		}

		// Email validation
		var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z]+[a-zA-Z0-9-]*\.[a-zA-Z]{2,}$/;;
		if (email_id_contact == "") {
			$('#email_id_contact').css('border-color', 'red');
			flag = false;
		} else if (!emailPattern.test(email_id_contact)) {
			$("#id_count_display").html("Email is invalid.");
			$('#email_id_contact').css('border-color', 'red');
			flag = false;
		}

		// Password validation
		if (password == "") {
			$('#txt_new_password').css('border-color', 'red');
			flag = false;
		}

		// Confirm password validation
		if (confirm_password == "") {
			$('#txt_confirm_password').css('border-color', 'red');
			flag = false;
		} else if (confirm_password !== password) {
			$('#txt_confirm_password').css('border-color', 'red');
			$("#id_count_display").html("Password and Confirm Password do not match.");
			flag = false;
		}

		// Terms and conditions validation
		if (!$("#chk_terms").prop('checked')) {
			$("#id_count_display").html("Please accept the terms & conditions.");
			flag = false;
		}

		const resetBorders = ['#slt_user_type'];
		resetBorders.forEach(selector => $(selector).css('border-color', '#a0a0a0'));

		// If all validations pass, submit form via AJAX
		if (flag) {
			var fd = new FormData(this);
			$.ajax({
				type: 'post',
				url: "ajax/call_functions.php?call_function=manage_users",
				dataType: 'json',
				data: fd,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$('#submit').attr('disabled', true);
					$('.theme-loader').css("display", "block").show();
					$("#id_count_display").html("");
				},
				complete: function() {
					$('.theme-loader').css("display", "none").hide();
					$('#submit').attr('disabled', false);
				},
				success: function(response) {
					$('#image_display').attr('src',
						`libraries/assets/png/${response.status === 1 ? 'success' : 'failed'}.png`);
					$("#message").html(response.msg || "Unexpected error.");
					$('#campaign_compose_message').modal('show');
					$('#submit').prop('disabled', response.status === 1);

					if (response.status === 1) {
						setTimeout(() => window.location = "manage_users_list", 2000);
					}
				},
				error: function(response) {
					$('#submit').prop('disabled', false);
				}
			});
		}
	});

	function clsAlphaNoOnly(e) {
		var char = e.key;
		if (/^[a-zA-Z0-9 ]$/.test(char)) {
			return true;
		}
		if (['Backspace', 'ArrowLeft', 'ArrowRight', 'Tab', 'Delete'].includes(e.key)) {
			return true;
		}
		e.preventDefault();
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

	function gtag() {
		dataLayer.push(arguments);
	}
	gtag('js', new Date());

	gtag('config', 'UA-23581568-13');
	</script>
	<script src="libraries/assets/js/rocket-loader.min.js" data-cf-settings="461d1add94eeb239155d648f-|49" defer="">
	</script>
</body>

<!-- Mirrored from colorlib.com/polygon/admindek/default/compose_sms.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 12 Dec 2019 16:09:13 GMT -->

</html>