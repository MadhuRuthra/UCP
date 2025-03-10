<?php
session_start();
error_reporting(0);
include_once('api/configuration.php');// Include configuration.php
include_once "api/send_request.php"; // Include send_request.php
extract($_REQUEST);

if ($_SESSION['yjucp_user_id'] == "") { ?>
	<script>
		window.location = "index";
	</script>
	<?php exit();
}
site_log_generate("Index Page : Unknown User : '" . $_SESSION['yjucp_user_id'] . "' access this page on " . date("Y-m-d H:i:s"));
?>
<!DOCTYPE html>
<html lang="en">

<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>

	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

	<title>Manage Sender ID ::
		<?= htmlspecialchars($site_title, ENT_QUOTES, 'UTF-8') ?>
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


	<link rel="stylesheet" type="text/css" href="libraries/assets/css/feather.css">

	<link rel="stylesheet" type="text/css" href="libraries/assets/css/font-awesome-n.min.css">
	<link rel="stylesheet" type="text/css" href="libraries/assets/css/widget.css">

	<link rel="stylesheet" type="text/css" href="libraries/assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="libraries/assets/css/pages.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	
  <!-- style include in css -->
  <style>
    .loader {
      width: 50;
      background-color: #ffffffcf;
    }

    .loader img {}
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
					<?php include("libraries/site_header.php"); ?>
					<?php include("libraries/site_menu.php"); ?>
					<div class="pcoded-content">

						<div class="page-header card">
							<div class="row align-items-end">
								<div class="col-lg-8">
									<div class="page-header-title">
										<i class="feather icon-clipboard bg-c-blue"></i>
										<div class="d-inline">
											<h5>Manage Sender ID</h5>
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
 	  	 	 	  	  	 	 	  	 	  	 	 <a href="add_sender_id">Manage Sender ID</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>

						<div class="pcoded-inner-content">

							<div class="main-body">

								<div class="section-body">
									<div class="row">

										<div class="col-12 col-md-8 col-lg-8 offset-2">
											<div class="card">
												<form class="needs-validation" novalidate="" id="frm_store" name="frm_store" action="#"
													method="post" enctype="multipart/form-data">
													<div class="card-body">
														<div class="form-group mb-2 row">
															<label class="col-sm-3 col-form-label">Country Code<label
                                                                                                                                        style="color:#FF0000">*</label></label>
															<div class="col-sm-9">
																<select id="txt_country_code" name="txt_country_code" class="form-control" tabindex="1"
																	autofocus>
																	<? // To Show the country list
																	$replace_txt = '{
                              "user_id" : "' . $_SESSION['yjucp_user_id'] . '" 
                            }';

							$response = executeCurlRequest($api_url . "/sender_id/country_list", "GET", $replace_txt);
							// After got response decode the JSON result
							 if (empty($response)) {
								   // Redirect to index.php if response is empty
										 header("Location: index");
										 exit(); // Stop further execution after redirect
								  }
																	// After got response decode the JSON result
																	$state1 = json_decode($response, false);
																	// Based on the JSON response, list in the option button
																	if ($state1->num_of_rows > 0) {
																		for ($indicator = 0; $indicator < count($state1->report); $indicator++) {
																			// Looping the indicator is less than the count of report.if the condition is true to continue the process and to get the report details.if the condition are false to stop the process and to send the no available data
																			$shortname = $state1->report[$indicator]->shortname;
																			$phonecode = $state1->report[$indicator]->phonecode;
																			$countryid = $state1->report[$indicator]->id;
																			?>
																			<option value="<?= $countryid . "~~" . $phonecode ?>" <? if ($shortname == 'IN') {
																							echo "selected";
																						} ?>>
																				<?=
																					$shortname . " +" . $phonecode ?>
																			</option>
																		<?php }
																	}
																	site_log_generate("Manage Sender ID Page : User : " . $_SESSION['yjucp_user_name'] . " executed the Query ($sql_dashboard1) on " . date("Y-m-d H:i:s"));
																	?>
																</select>
															</div>
														</div>
														<!-- Mobile Number text field using -->
														<div class="form-group mb-2 row">
															<label class="col-sm-3 col-form-label">Mobile Number <label
																	style="color:#FF0000">*</label></label>
															<div class="col-sm-9">
																<input type="text" name="mobile_number" id='mobile_number' class="form-control"
																	value="<?= $_REQUEST['mob'] ?>" tabindex="1" required="" maxlength="10"
																	placeholder="Mobile Number" data-toggle="tooltip" data-placement="top" title=""
																	data-original-title="Mobile Number" oninput="validateInput_phone()"
																	onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"
																	<? if ($_REQUEST['mob'] != '') { ?> readonly <? } ?>>
															</div>
														</div>
														<!-- Profile name text field using -->
														<div class="form-group mb-2 row">
															<label class="col-sm-3 col-form-label">Profile Name <label
																	style="color:#FF0000">*</label></label>
															<div class="col-sm-9">
																<input type="text" name="txt_display_name" id='txt_display_name' class="form-control"
																	value="<?= $_REQUEST['mob'] ?>" tabindex="2" required="" maxlength="30"
																	oninput="validateInput_profile()" placeholder="Profile Name" data-toggle="tooltip"
																	data-placement="top" title="" data-original-title="Profile Name">
															</div>
														</div>
														<!-- profile image text field using -->
														<div class="form-group mb-2 row">
															<label class="col-sm-3 col-form-label">Profile Image <label
																	style="color:#FF0000">*</label></label>
															<div class="col-sm-9">
																<input type="file" class="form-control" name="fle_display_logo" id='fle_display_logo'
																	tabindex="3" accept="image/png, image/jpg, image/jpeg" required=""
																	data-toggle="tooltip" data-placement="top" title=""
																	data-original-title="Profile Image - Allowed only jpg, png images. Maximum 2 MB Size allowed">
															</div>
														</div>
														<!-- To select the Service Category using in dropdown-->
														<div class="form-group mb-2 row">
															<label class="col-sm-3 col-form-label">Service Category <label
																	style="color:#FF0000">*</label></label>
															<div class="col-sm-9">
																<select name="slt_service_category" id='slt_service_category' class="form-control"
																	data-toggle="tooltip" data-placement="top" title=""
																	data-original-title="Select Service Category" tabindex="4">
																	<?   // To Show the Service Category list
																	$replace_txt = '{
                              "user_id" : "' . $_SESSION['yjucp_user_id'] . '"
                            }';

							$response = executeCurlRequest($api_url . "/sender_id/service_category_list", "GET", $replace_txt);
							// After got response decode the JSON result
							 if (empty($response)) {
								   // Redirect to index.php if response is empty
										 header("Location: index");
										 exit(); // Stop further execution after redirect
								  }
																	// After got response decode the JSON result
																	$state1 = json_decode($response, false);
																	$i1 = 0;
																	// Based on the JSON response, list in the option button
																	if ($state1->num_of_rows > 0) {
																		// Looping the indicator is less than the count of report.if the condition is true to continue the process and to get the report details.if the condition are false to stop the process and to send the no available data
																		for ($indicator = 0; $indicator < count($state1->report); $indicator++) {
																			$message_category_id = $state1->report[$indicator]->message_category_id;
																			$message_category_title = $state1->report[$indicator]->message_category_title;
																			$i1++; ?>
																			<option value="<?= $message_category_id ?>" <? if ($i1 == 1) { ?> selected <? } ?>>
																				<?= $message_category_title ?>
																			</option>
																			<?
																		}
																	}
																	?>
																</select>
															</div>
														</div>
                                                                                                     <span class="error_display text-center" id="id_error_display" style="color:red; text-align:center; display: inline-block; position: absolute;left: 50%; transform: translate(-50%, -50%);"></span>
														<!-- submit button using -->
														<div class="card-footer text-center">
															<input type="hidden" class="form-control" name='tmpl_call_function'
																id='tmpl_call_function' value='save_mobile_api' />
															<input type="submit" name="compose_submit" id="compose_submit" tabindex="5" value="Submit"
																class="btn btn-success">

															<div class="container">
																<span class="error_display" id='qrcode_display' style="color: red;"></span>
																<img src='./assets/img/loader.gif' id="id_qrcode" alt='QR Code'>
															</div>
														</div>

												</form>
											</div>
										</div>
									</div>
									<div class="text-left" style="padding: 15px;">
										<span class="error_display1" style="color:red;">
											<b>Note:</b> <br>
											1) Enter 10 digit mobile number.<br>
											2) The sender ID or the mobile should not have or use WhatsApp. We recommend fresh mobile numbers
											for all your communications. <br>
											3) Super admin will have all the rights to control the Sender ID and template ID creation in terms
											of coordination & approval. <br>
											4) Profile Image - Allowed only jpg, png images. Maximum 2 MB size allowed.
										</span>
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

		function validateInput_phone() {
			$("#id_error_display").html("");
		}
		function validateInput_profile() {
			var textField = document.getElementById('txt_display_name');
			var text = textField.value;
			var isValid = !/\s{2,}|[^a-zA-Z_ ]/g.test(text);

			console.log(isValid);  // false (invalid due to multiple spaces)

			if (isValid === false) {
				console.log("&&");
				textField.value = text.replace(/\s{2,}|[^a-zA-Z_ ]/g, '');
				return false;
			}
		}


		const upload_limit = 2; //Maximum 2 MB
		// File type validation
		$("#fle_display_logo").change(function () {
			// xls, xlsx, csv, txt
			var file = this.files[0];
			var fileType = file.type;
			var match = ['image/jpeg', 'image/jpg', 'image/png'];
			if (!((fileType == match[0]) || (fileType == match[1]) || (fileType == match[2]) || (fileType == match[3]) || (fileType == match[4]) || (fileType == match[5]))) {
				$("#id_error_display").html('Sorry, only PNG, JPG files are allowed to upload.').css('color', 'red');
				$("#fle_display_logo").val('');
				return false;
			}

			const size = this.files[0].size / 1024 / 1024;
			if (size < upload_limit) { return true; }
			else {
				$("#id_error_display").html('Maximum File size allowed - ' + upload_limit + ' MB. Kindly reduce and choose below ' + upload_limit + ' MB').css('color', 'red');
				$("#fle_display_logo").val('');
				return false;
			}
		});

		// function call_composesms() {
		$(document).on("submit", "form#frm_store", function (e) {
			e.preventDefault();
			console.log("View Submit Pages");
			console.log("came Inside");
			$("#id_error_display").html("");
			$('#mobile_number').css('border-color', '#a0a0a0');
			$('#txt_display_name').css('border-color', '#a0a0a0');
			$('#fle_display_logo').css('border-color', '#a0a0a0');

			//get input field values 
			var mobile_number = $('#mobile_number').val();
			var txt_display_name = $('#txt_display_name').val();
			var fle_display_logo = $('#fle_display_logo').val();

			var flag = true;
			/********validate all our form fields***********/
			/* mobile_number field validation  */
			if (mobile_number == "") {
				$('#mobile_number').css('border-color', 'red');
				console.log("##");
				flag = false;
			}
			var mobile_number = document.getElementById('mobile_number').value;
			if (mobile_number.length != 10) {
                                $('#mobile_number').css('border-color', 'red');
				$("#id_error_display").html("Please enter a valid mobile number").css('color', 'red');
				console.log("##");
				flag = false;
			}
			if (!(mobile_number.charAt(0) == "9" || mobile_number.charAt(0) == "8" || mobile_number.charAt(0) == "6" || mobile_number.charAt(0) == "7")) {
				$("#id_error_display").html("Please enter a valid mobile number").css('color', 'red');
				document.getElementById('mobile_number').focus();
                                  $('#mobile_number').css('border-color', 'red');
				flag = false;
			}

			/* txt_display_name field validation  */
			if (txt_display_name == "") {
				$('#txt_display_name').css('border-color', 'red');
				console.log("##");
				flag = false;
			}

			/* fle_display_logo field validation  */
			if (fle_display_logo == "") {
				$('#fle_display_logo').css('border-color', 'red');
				console.log("##");
				flag = false;
			}

			/* If all are ok then we send ajax request to ajax/master_call_functions.php *******/
			if (flag) {
				var fd = new FormData(this);
				var files = $('#fle_display_logo')[0].files;
				if (files.length > 0) {
					fd.append('file', files[0]);
				}
				$.ajax({
					type: 'post',
					url: "ajax/store_call_functions.php?tmpl_call_function=save_mobile_api",
					dataType: 'json',
					data: fd,
					contentType: false,
					processData: false,
					beforeSend: function () {
						$('#compose_submit').attr('disabled', true);
						$('.theme-loader').show();
					},
					complete: function () {
						$('.theme-loader').hide();
					},
					success: function (response) {
						console.log("SUCC");
						if (response.status == '0') {
							//alert(response.status);
							$('#mobile_number').val('');
							$('#txt_display_name').val('');
							$('#fle_display_logo').val('');
							$('#compose_submit').attr('disabled', false);
							$("#id_error_display").html(response.msg).css('color', 'red');
						} else if (response.status == 1) {
							//alert(response.status);
							$('#compose_submit').attr('disabled', true);
							$("#id_error_display").html("Sender ID added successfully!..").css('color', 'red');
							setInterval(function () {
								window.location = 'manage_sender_id';
								$('#mobile_number').val('');
								$('#txt_display_name').val('');
								$('#fle_display_logo').val('');
							}, 2000);
						}
						$('.theme-loader').hide();
					},
					error: function (response, status, error) {

						console.log("FAL");
						$('#mobile_number').val('');
						$('#txt_display_name').val('');
						$('#fle_display_logo').val('');

						$('#compose_submit').attr('disabled', false);
						$('.theme-loader').show();
						window.location = 'manage_sender_id';
						$("#id_error_display").html(response.msg).css('color', 'red');
					}
				});
			}
		});

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
