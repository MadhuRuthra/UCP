<?php
session_start(); // start session
error_reporting(0); // The error reporting function
include_once 'api/configuration.php'; // Include configuration.php
include_once('api/send_request.php');
// Check if the parameters are set
if (isset($_GET['contact_id'])) {
	// Get the user ID from the URL
	$contact_id = $_GET['contact_id'];

	// To send the request to the API
	$replace_txt = '{
		"contact_id": "' . $contact_id . '"
	}';

}

																// Call the reusable cURL function
															$response = executeCurlRequest($api_url . "/contacts/view_contact", "GET", $replace_txt);
															// After got response decode the JSON result
													if (empty($response)) {
														 // Redirect to index.php if response is empty
														 header("Location: index");
														 exit(); // Stop further execution after redirect
													}
// After got response decode the JSON result
$state1 = json_decode($response, false);
// To get the API response one by one data and assign to Session
if ($state1->response_status == 200) {
	// Looping the indicator is less than the count of response_result.if the condition is true to continue the process.if the condition are false to stop the process
	for ($indicator = 0; $indicator < count($state1->reports); $indicator++) {
		$contactno = $state1->reports[$indicator]->contact_no;
		$contactname = $state1->reports[$indicator]->contact_name;
		$contactemail = $state1->reports[$indicator]->contact_email;
		$contactoperator = $state1->reports[$indicator]->contact_operator;
		$contactstatus = $state1->reports[$indicator]->contact_status;
		$contactmgtgrp_id = $state1->reports[$indicator]->contact_mgtgrp_id;
		$contactid = $state1->reports[$indicator]->contact_mgt_id;


	}
}
// Check if the parameters are set
if ($_SESSION['yjucp_user_id'] == "") { ?>
<script>
window.location = "index";
</script>
<?php exit();
				}
?>
<!DOCTYPE html>
<html lang="en">
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>

	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<title>Contact Creation ::
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
											<h5>Contact Creation</h5>
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
											<li class="breadcrumb-item"><a href="message_credit">Contact Creation</a>
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
																<form class="needs-validation" novalidate="" id="create_contact"
																	name="create_contact" action="#" method="post" enctype="multipart/form-data">
																	<div class="card-body">

																		<!-- Contacts Name-->
																		<div class="form-group mb-2 row">
																			<label class="col-sm-4 col-form-label">Contacts Name</label>
																			<div class="col-sm-8">
																				<input type="text" name="contact_name" id='contact_name' class="form-control"
																					value="<?= $contactname ?>" maxlength="100" class="form-control"
																					onkeypress="return clsAlphaNoOnly(event)" required tabindex="3"
																					data-toggle="tooltip" data-placement="top" title=""
																					placeholder="Contacts Name" data-original-title="Contacts Name">
																			</div>
																		</div>
																		<!-- Mobile Number-->
																		<div class="form-group mb-2 row">
																			<label class="col-sm-4 col-form-label">Mobile Number</label>
																			<div class="col-sm-8">
																				<input type="text" name="contact_no" id='contact_no' value="<?= $contactno ?>"
																					tabindex="3" required maxlength="10"
																					onkeypress="return (event.charCode !=8 && event.charCode ==0 || ( event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)))"
																					class="form-control" data-toggle="tooltip" data-placement="top" title=""
																					placeholder="Mobile Number" data-original-title="Mobile Number">
																			</div>
																		</div>
																		<!-- Email Address -->
																		<div class="form-group mb-2 row">
																			<label class="col-sm-4 col-form-label">Email Address</label>
																			<div class="col-sm-8">
																				<input type="email" name="contact_email" id="contact_email"
																					value="<?= $contactemail?>" tabindex="3" required maxlength="100"
																					data-toggle="tooltip" data-placement="top" title=""
																					placeholder="Email Address" class="form-control"
																					data-original-title="Email Address">
																			</div>
																		</div>
																		<!-- Contacts Operater-->
																		<div class="form-group mb-2 row">
																			<label class="col-sm-4 col-form-label">Contacts Operater</label>
																			<div class="col-sm-8">
																				<input type="text" name="contact_operator" id='contact_operator'
																					class="form-control" value="<?= $contactoperator ?>" maxlength="20"
																					onkeypress="return clsAlphaNoOnly(event)" required tabindex="3"
																					data-toggle="tooltip" data-placement="top" title=""
																					placeholder="Contacts Operater" data-original-title="Contacts Operater">
																			</div>
																		</div>
																		<!-- Admin Select menu Start-->
																		<div class="form-group mb-2 row">
																			<label class="col-sm-4 col-form-label">Contact Management Group
																			</label>
																			<div class="col-sm-8">
																				<select name="contact_mgtgrp_id" id="contact_mgtgrp_id" class="form-control"
																					data-toggle="tooltip" data-placement="top" title="" required=""
																					data-original-title="Select Group Name
                                                Group" tabindex="1" autofocus>
																					<?php 
                                                    echo '<option value="">Select Group name</option>';
        $send_request = json_encode(["user_id" => $_SESSION["yjucp_user_id"]]);
        $response = executeCurlRequest($api_url . "/contacts/group_list", "GET", $send_request);
            $state1 = json_decode($response, false);
            $data = '';
            if ($state1->response_code == 1) {
                foreach ($state1->reports as $report) {
                     if($report->contact_group_status != 'N'){
                    $selected = ($contactmgtgrp_id == $report->contact_mgtgrp_id) ? ' selected' : '';
                    $data .= '<option value="' . htmlspecialchars($report->contact_mgtgrp_id) . '"' . $selected . '>' 
                             . htmlspecialchars($report->contact_group_title) . '</option>';
                }
                 }
            } elseif ($state1->response_status == 204) {
                $data = '<option value="">No available options</option>';
            } 
            echo $data;
        ?>
																				</select>
																			</div>
																		</div>

																		<!-- Admin Select menu End-->

																		<!-- Contacts Status -->
																		<div class="form-group mb-2 row">
																			<label class="col-sm-4 col-form-label">Contacts Status</label>
																			<div class="col-sm-8">
																				<input type="radio" name="contact_status" id="contact_status_inactive"
																					<?= $contactstatus === 'Y' || empty($contactstatus) ? 'checked' : '' ?>
																					style="margin-bottom:5px;" value="Y" tabindex="3"> Active &nbsp;&nbsp;&nbsp;
																				<input type="radio" name="contact_status" id="contact_status_inactive"
																					<?= $contactstatus === 'N' ? 'checked' : '' ?> style="margin-bottom:5px;"
																					value="N" tabindex="3"> Inactive
																			</div>
																		</div>
																	</div>

																	<!-- Terms & Conditions Card -->
																	<div id="terms_card" class="card" style="display: none;">
																		<div class="card-header">
																			<h5 class="card-title">
																				Terms & Conditions
																				<button id="close_terms" type="button" class="btn-close">&times;</button>
																			</h5>
																		</div>


																		<div class="card-body">
																			<h6>1. Terms and Conditions</h6>
																			<p>IMPORTANT: The contents of this email and any attachments are
																				confidential. They are intended for
																				the named recipient(s) only. If you have received this email by
																				mistake, please notify the sender
																				immediately and do not disclose the contents to anyone or make
																				copies thereof.</p>
																		</div>
																	</div>


																	<span class="error_display" id='id_count_display' style="color: red;"></span>
																	<!-- Message Count and Error display -->
																	<div class="card-footer text-center">
																		<input type="hidden" class="input-block-level" name='tmpl_call_function'
																			id='tmpl_call_function' value='add_contact' />
																		<? if($action == 'edit') { ?>
																		<input type="hidden" class="input-block-level" name='contact_id' id='contact_id'
																			value='<?=$contact_id?>' />
																		<? } ?>
																		<input type="submit" name="submit_signup" id="submit_signup" value="Submit"
																			class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20"
																			style="width:150px;">
																	</div>
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
						<!-- Confirmation details content-->
						<div class="modal" tabindex="-1" role="dialog" id="campaign_compose_message">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-body">
										<button type="button" class="close" data-dismiss="modal" style="width:30px" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
										<div class="container" style="text-align: center;">
											<img alt="image" style="width: 50px; height: 50px; display: block; margin: 0 auto;"
												id="image_display">
											<br>
											<span id="message"></span>
										</div>
									</div>
									<div class="modal-footer" style="text-align: center;">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Okay</button>
									</div>
								</div>
							</div>
						</div>
						<!-- After Submit Preview Data Modal content End-->
						<? include("libraries/site_footer.php"); ?>

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
	$(document).ready(function() {
		// Limit the input to 10 digits
		$('#contact_no').on('input', function() {
			var currentValue = $(this).val();
			var sanitizedValue = currentValue.replace(/\D/g, '').substring(0, 10);
			$(this).val(sanitizedValue);
		});
	});


	// Sign up submit Button function Start
	$(document).on("submit", "form#create_contact", function(e) {
		e.preventDefault();
		$("#id_count_display").html("");
		var flag = true;
		// Get input field values
		var contact_name = $('#contact_name').val().trim();
		var contact_no = $('#contact_no').val();
		var contact_email = $('#contact_email').val();
		var contact_operator = $('#contact_operator').val().trim();


		// Clear previous field borders
		$('#contact_name, #contact_no, #contact_email, #contact_operator').css('border-color', '');

		// Name validation
		if (contact_name == "") {
			$('#contact_name').css('border-color', 'red');
			flag = false;
			console.log("*1")
		}

		// Mobile number validation (India only)
		if (contact_no == "") {
			$('#contact_no').css('border-color', 'red');
			flag = false;
			console.log("*2")
		} else if (!/^[6789]\d{9}$/.test(contact_no)) {
			$("#id_count_display").html("Please enter a valid Indian mobile number.");
			$('#contact_no').css('border-color', 'red');
			flag = false;
			console.log("*2*")
		}

		// Email validation
		var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z]+[a-zA-Z0-9-]*\.[a-zA-Z]{2,}$/;;
		if (contact_email == "") {
			$('#contact_email').css('border-color', 'red');
			flag = false;
			console.log("*3")
		} else if (!emailPattern.test(contact_email)) {
			$("#id_count_display").html("Email is invalid.");
			$('#contact_email').css('border-color', 'red');
			flag = false;
			console.log("3*")
		}

		// Password validation
		if (contact_operator == "") {
			$('#contact_operator').css('border-color', 'red');
			flag = false;
			console.log("4");
		}

		const resetBorders = ['#contact_mgtgrp_id'];
		resetBorders.forEach(selector => $(selector).css('border-color', '#a0a0a0'));

		// If all validations pass, submit form via AJAX
		if (flag) {
			var fd = new FormData(this);
			$.ajax({
				type: 'post',
				url: "ajax/contact_call_functions.php",
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
						setTimeout(() => window.location = "contacts_list", 2000);
					}
				},
				error: function(response) {
					$('#submit').prop('disabled', false);
				}

			});
		}
	});

	function clsAlphaNoOnly(e) {
		var char = e.key; // Get the key pressed
		// Allow only letters, numbers, and spaces
		if (/^[a-zA-Z0-9 ]$/.test(char)) {
			return true; // Valid input
		}
		// Allow navigation and control keys (Backspace, Arrow keys, Tab, etc.)
		if (['Backspace', 'ArrowLeft', 'ArrowRight', 'Tab', 'Delete'].includes(e.key)) {
			return true; // Allow control keys
		}
		e.preventDefault(); // Block invalid input
		return false; // Invalid input
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