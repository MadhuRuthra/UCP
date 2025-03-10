<?php
session_start(); // start session
error_reporting(0); // The error reporting function
include_once 'api/configuration.php'; // Include configuration.php
include_once('api/send_request.php');
// Check if the parameters are set
if (isset($_GET['plan_id'])) {
	// Get the user ID from the URL
	// To send the request to the API
	$replace_txt = '{
		"pricing_slot_id": "' . $_GET['plan_id'] . '"
	}';

}

																// Call the reusable cURL function
															$response = executeCurlRequest($api_url . "/contacts/view_plans", "GET", $replace_txt);
															
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
		$plan_name = $state1->reports[$indicator]->plan_name;
		$slt_rights_id = $state1->reports[$indicator]->rights_id;
		$price_to = $state1->reports[$indicator]->price_to;
		$price_per_message = $state1->reports[$indicator]->price_per_message;
		$pricing_slot_status = $state1->reports[$indicator]->pricing_slot_status;
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
	<title>Plan Creation ::
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
											<h5>Plan Creation</h5>
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
											<li class="breadcrumb-item"><a href="message_credit">Plan Creation</a>
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
																<form class="needs-validation" novalidate="" id="frm_plan_creation"
																	name="frm_plan_creation" action="#" method="post" enctype="multipart/form-data">
																	<div class="card-body">
																		<!-- Admin Select menu Start-->
																		<div class="form-group mb-2 row">
																			<label class="col-sm-4 col-form-label">Product Name
																			</label>
																			<div class="col-sm-8">
																				<select name="txt_product_name" id='txt_product_name' class="form-control"
																					data-toggle="tooltip" data-placement="top" title="" required=""
																					data-original-title="Product Name" tabindex="1" autofocus
																					onchange="getproductid();" onblur="getproductid();">
																					<? // To get the child user list from API
                           $replace_txt = '{ "select_user_id" : "' . $_SESSION['yjucp_user_id'] . '" }';
                                // Call the reusable cURL function
                            $response = executeCurlRequest($api_url . "/list/products_name", "GET", $replace_txt);
														$state1 = json_decode($response, false);

														if ($state1->num_of_rows > 0) { for ($indicator = 0; $indicator < $state1->num_of_rows; $indicator++) { 
															$selected = ($slt_rights_id === $state1->product_name[$indicator]->rights_id || $indicator === 0) ? 'selected' : '';
															?>
																					<option
																						value="<?= $state1->product_name[$indicator]->rights_id . " ~~" .$state1->product_name[$indicator]->rights_name ?>"
																						<? if ($indicator==0 || $slot_id==$state1->
																						product_name[$indicator]->rights_name) { echo $selected ;} if ($slot_id !=
																						'' && $slot_id !=$state1->product_name[$indicator]->rights_id) { ?>disabled
																						<? } ?> ><?= $state1->product_name[$indicator]->rights_name ?>
																					</option>
																					<?  } } ?>
																				</select>
																			</div>
																		</div>

																		<!-- Admin Select menu End-->
																		<!-- Plan Name -->
																		<div class="form-group mb-2 row">
																			<label class="col-sm-4 col-form-label">Plan Name</label>
																			<div class="col-sm-8">
																				<input type="text" name="txt_plan_name" id='txt_plan_name' class="form-control"
																					value="<?= $plan_name ?>" maxlength="10"
																					onkeypress="return clsAlphaNoOnly(event)" required tabindex="3"
																					data-toggle="tooltip" data-placement="top" title="" placeholder="Plan Name"
																					data-original-title="Plan Name">
																				<!-- Plan Name-->
																			</div>
																		</div>

																		<!-- Total Messages -->
																		<div class="form-group mb-2 row">
																			<label class="col-sm-4 col-form-label">Total Messages</label>
																			<div class="col-sm-8">
																				<input type="text" name="txt_total_message" id='txt_total_message'
																					class="form-control" value="<?= $price_to ?>" tabindex="3" required
																					maxlength="10"
																					onkeypress="return (event.charCode !=8 && event.charCode ==0 || ( event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)))"
																					data-toggle="tooltip" data-placement="top" title=""
																					placeholder="Total Messages" data-original-title="Total Messages">
																				<!--Total Messages -->
																			</div>
																		</div>

																		<!--Price Of Amount Per Message-->
																		<div class="form-group mb-2 row">
																			<label class="col-sm-4 col-form-label">Price Per Message</label>
																			<div class="col-sm-8">
																				<input type="text" name="txt_price_per_msg" id='txt_price_per_msg'
																					class="form-control" value="<?= $price_per_message ?>" tabindex="3" required
																					maxlength="7" onkeypress="return FloatNumbersOnly(event)"
																					placeholder="Price Per Message" tabindex="3" data-toggle="tooltip"
																					data-placement="top" title="" data-original-title="Price Per Message">
																				<!--Price Of Amount Per Message-->
																			</div>
																		</div>
																		<!-- Plan Status -->
																		<div class="form-group mb-2 row">
																			<label class="col-sm-4 col-form-label">Plan Status</label>
																			<div class="col-sm-8">
																				<input type="radio" name="plan_status" id="active_plan"
																					<?= $pricing_slot_status === 'Y' || empty($pricing_slot_status) ? 'checked' : '' ?>
																					style="margin-bottom:5px;" value="Y" tabindex="3"> Active Plan
																				&nbsp;&nbsp;&nbsp;
																				<input type="radio" name="plan_status" id="inactive_plan"
																					<?= $pricing_slot_status === 'N' ? 'checked' : '' ?>
																					style="margin-bottom:5px;" value="N" tabindex="3"> Inactive Plan
																				<!-- Plan Status -->
																			</div>
																		</div>



																	</div>


																	<span class="error_display" id='id_count_display' style="color: red;"></span>
																	<!-- Message Count and Error display -->
																	<div class="card-footer text-center">
																		<span class="error_display" id='id_error_display' style="color: red;"></span>
																		<!-- Error Display -->
																		<input type="hidden" class="form-control" name='tmpl_call_function'
																			id='tmpl_call_function' value='create_plan' />
																		<? if (isset($_GET['plan_id'])) { ?>
																		<input type="hidden" class="form-control" name='plan_id' id='plan_id'
																			value='<?= $plan_id ?>' />
																		<? } ?>
																		<input type="hidden" id="temp-textarea" value="" />
																		<input type="submit" name="submit" id="submit" value="Submit"
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

	<script src="libraries/assets//js/xlsx.full.min.js"></script>

	<script>
	// If we click the Submit button, validate and save the data using API
	$("#submit").click(function(e) {
		$("#id_error_display").html("");
		var txt_product_name = $('#txt_product_name').val().trim();
		var txt_plan_name = $('#txt_plan_name').val().trim();
		var txt_total_message = $('#txt_total_message').val();
		var txt_price_per_msg = $('#txt_price_per_msg').val();
		var plan_status = $('#plan_status').val();


		var flag = true;
		// *******validate all our form fields***********
		// Parent User field validation
		if (txt_product_name == "") {
			$('#txt_product_name').css('border-color', 'red');
			flag = false;
			e.preventDefault();
		}
		// Receiver field validation 
		if (txt_total_message == "") {
			$('#txt_total_message').css('border-color', 'red');
			flag = false;
			e.preventDefault();
		}
		// Message Count field validation 
		if (txt_plan_name == "") {
			$('#txt_plan_name').css('border-color', 'red');
			flag = false;
			e.preventDefault();
		}

		if (txt_price_per_msg == "") {
			$('#txt_price_per_msg').css('border-color', 'red');
			flag = false;
			e.preventDefault();
		}

		// *******Validation end here ****

		// If all are ok then we send ajax request to store_call_functions.php *******
		if (flag) {
			var data_serialize = $("#frm_plan_creation").serialize();
			$.ajax({
				type: 'post',
				url: "ajax/contact_call_functions.php",
				dataType: 'json',
				data: data_serialize,
				beforeSend: function() { // Before send to Ajax
					$('#submit').attr('disabled', true);
					$('#load_page').show();
				},
				complete: function() { // After complete the Ajax
					$('#submit').attr('disabled', true);
					$('#load_page').hide();
				},
				success: function(response) {
					$('#image_display').attr('src',
						`libraries/assets/png/${response.status === 1 ? 'success' : 'failed'}.png`);
					$("#message").html(response.msg || "Unexpected error.");
					$('#campaign_compose_message').modal('show');
					$('#submit').prop('disabled', response.status === 1);

					if (response.status === 1) {
						setTimeout(() => window.location = "plans_list", 2000);
					}
				},
				error: function(response) {
					$('#submit').prop('disabled', false);
					$("#id_error_display").html(response.msg);
				}

			});
		}
	});

	var product_id;

	function getproductid() {
		var txt_product_name = $("#txt_product_name").val();
		product_id = txt_product_name.split("~~")
		if (product_id[5]) {
			if (product_id[5] == 'WHATSAPP') {
				product_id = 1;
			} else if (product_id[5] == 'GSM SMS') {
				product_id = 2;
			} else {
				product_id = 3;
			}
		} else {
			product_id = product_id[0];
		}
	}

	function FloatNumbersOnly(e) {
		var key = e.keyCode || e.which; // Use e.which for compatibility
		if (
			(key >= 48 && key <= 57) || // 0-9
			key == 46 // period (.)
		) {
			return true;
		}
		return false;
	}

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