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
?>
<!DOCTYPE html>
<html lang="en">
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>

	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

	<title>DLT Existing Sender ID ::
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


	<link rel="stylesheet" type="text/css" href="libraries/assets/css/feather.css">

	<link rel="stylesheet" type="text/css" href="libraries/assets/css/font-awesome-n.min.css">
	<link rel="stylesheet" type="text/css" href="libraries/assets/css/widget.css">

	<link rel="stylesheet" type="text/css" href="libraries/assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="libraries/assets/css/pages.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	<style type="text/css">
		tr {
			line-height: 20px;
			min-height: 20px;
			height: auto;
		}

		.j-label {
			font-size: 1em !important;
			font-weight: normal !important;
			line-height: 40px !important;
		}

		.j-pro .j-unit {
			margin-bottom: 0px !important;
		}

		.j-wrapper {
			padding: 0px !important;
		}

		textarea {
			resize: none !important;
		}

		.form-radio label {
			padding-left: 0rem;
		}

		.radio-toolbar {
			margin: 10px;
		}

		.radio-toolbar input[type="radio"] {
			opacity: 0;
			position: fixed;
			width: 0;
		}

		.radio-toolbar label {
			display: inline-block;
			/* background-color: #ddd;
				border: 2px solid #444;*/
			padding: 5px;
			font-family: sans-serif, Arial;
			font-size: 16px;
			border-radius: 4px;
		}

		.radio-toolbar label:hover {
			background-color: #dfd;
		}

		.radio-toolbar input[type="radio"]:focus+label {
			border: 2px dashed #444;
		}

		.radio-toolbar input[type="radio"]:checked+label {
			background-color: #bfb;
			border-color: #4c4;
		}

		th,
		td {
			white-space: inherit;
			word-break: break-word;
		}

		.nav-tabs .nav-item.show .nav-link,
		.nav-tabs .nav-link.active {
			color: #000;
			background-color: #94c3ec54;
			border-color: #ddd #ddd #94c3ec54;
		}

		select {
			-webkit-appearance: menulist !important;
			/*webkit browsers */
			-moz-appearance: menulist !important;
			/*Firefox */
			appearance: menulist !important;
			/* modern browsers */
			border-radius: 0;

		}

		.j-wrapper-850 {
			max-width: 100% !important;
		}

		.cen {
			margin: auto;
			clear: both;
			text-align: center;
			display: inline-block;
		}
	</style>
</head>

<body>
<!-- Pre-loader start -->
<div class="theme-loader">
		<div class="ball-scale">
			<div class='contain'>
				<div class="ring">
					<div class="frame"></div>
				</div>
				<div class="ring">
					<div class="frame"></div>
				</div>
				<div class="ring">
					<div class="frame"></div>
				</div>
				<div class="ring">
					<div class="frame"></div>
				</div>
				<div class="ring">
					<div class="frame"></div>
				</div>
				<div class="ring">
					<div class="frame"></div>
				</div>
				<div class="ring">
					<div class="frame"></div>
				</div>
				<div class="ring">
					<div class="frame"></div>
				</div>
				<div class="ring">
					<div class="frame"></div>
				</div>
				<div class="ring">
					<div class="frame"></div>
				</div>
			</div>
		</div>
	</div>
	<!-- Pre-loader end -->
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
											<h5>DLT Existing Sender ID</h5>
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
												<a href="">DLT Existing Sender ID</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>

						<div class="pcoded-inner-content">

							<div class="main-body">

								<!-- Page body start -->
								<div class="page-body">
									<div class="row">
										<div class="col-sm-12">
											<!-- Register your self card start -->
											<div class="card">
												<div class="card-block">

													<div class="row">
														<div class="col-md-12">
															<div id="wizard">
																<section>

																	<div class="tab-content tabs card-block" style="background-color: #FFF;">
																		<!-- Sender ID Entry -->
																		<div class="tab-pane active" id="dlt_entry" role="tabpanel">
																			<div class="j-wrapper j-wrapper-850">
																				<form class="form-horizontal j-pro" id="j-pro"
																					action="ajax/message_call_functions.php" method="post"
																					enctype="multipart/form-data">
																					<div class="j-content">
																						<div class="row">
																							<div class="col-lg-3"> </div>
																							<div class="col-lg-6">
																								<!-- start Operator -->
																								<div style="display: none;">
																									<div>
																										<label class="j-label">Operator</label>
																									</div>
																									<div class="j-unit">
																										<div class="j-input">
																											<div class="form-radio radio-toolbar text-center">
																												<div class="radio radiofill radio-inline" style="float: left;">
																													<label>
																														<input type="radio" name="slt_operator" id="operator1"
																															tabindex="1" autofocus value="1"
																															onclick="call_function_document('operator1')"
																															checked="checked">
																														<? /* <i class="helper"></i>Airtel */ ?>
																														<label for="operator1"><img
																																src="libraries/assets/images/airtel.png"
																																style="width:100px; height:100px;"></label>
																													</label>
																												</div>

																												<div class="radio radiofill radio-inline" style="float: left;">
																													<label>
																														<input type="radio" name="slt_operator" id="operator2"
																															tabindex="2" value="2"
																															onclick="call_function_document('operator2')" <?
																															if ($slt_operator == 'N') { ?> checked="checked" <? } ?>>
																														<? /* <i class="helper"></i>Videocon */ ?>
																														<label class="label_item" for="operator2"> <img
																																src="libraries/assets/images/videocon.png"
																																style="width:100px; height: 100px;"> </label>
																													</label>
																												</div>

																												<div class="radio radiofill radio-inline" style="float: left;">
																													<label>
																														<input type="radio" name="slt_operator" id="operator3"
																															tabindex="3" value="3"
																															onclick="call_function_document('operator3')" <?
																															if ($slt_operator == 'N') { ?> checked="checked" <? } ?>>
																														<? /* <i class="helper"></i>BSNL */ ?>
																														<label class="label_item" for="operator3"> <img
																																src="libraries/assets/images/bsnl.png"
																																style="width:100px; height: 100px;"> </label>
																													</label>
																												</div>

																												<div class="radio radiofill radio-inline" style="float: left;">
																													<label>
																														<input type="radio" name="slt_operator" id="operator4"
																															tabindex="4" value="4"
																															onclick="call_function_document('operator4')" <?
																															if ($slt_operator == 'N') { ?> checked="checked" <? } ?>>
																														<? /* <i class="helper"></i>JIO*/ ?>
																														<label class="label_item" for="operator4"> <img
																																src="libraries/assets/images/jio.png"
																																style="width:100px; height: 100px;"> </label>
																													</label>
																												</div>

																											</div>
																										</div>
																									</div>
																								</div>
																								<!-- end Operator -->

																								<!-- start Message Type -->
																								<table class="table table-striped table-bordered">
																									<tbody>

																										<div style="clear:both;">
																											<tr>

																												<th>
																													<div>
																														<label class="j-label">Message Type
																															<span class="mytooltip tooltip-effect-1">
																																<span class="tooltip-item2">[?]</span>
																																<span class="tooltip-content4 clearfix">
																																	<span class="tooltip-text2">
																																		Message Type - Choose any of these DLT Approval
																																		Process - Trns (OTP SMS) / Transactional
																																		(Transactional (Sender ID Based)) / Default
																																		(Promotional SMS (Sender ID Based)) / Fastac (SIM
																																		Based Promotional SMS) / Premium (Dummy Sender ID
																																		DND/NON DND SMS)
																																	</span>
																																</span>
																															</span>
																														</label>
																												</th>
 
																												<td>
																												<div class="j-unit">
																															<div class="j-unit">
																																<div class="j-input">
																																	<select name="dlt_process" id="dlt_process"
																																		tabindex="5" autofocus
																																		class="form-control form-control-primary"
																																		style="height:40px;">
																																		<?php
																																				$replace_txt = '';
																																						// Call the reusable cURL function
																		 $response = executeCurlRequest($api_url . "/list/message_type", "POST", $replace_txt);
																																		// Decode JSON response
																																		$qur_routmast0 = json_decode($response);
																																		// Check for response_code and populate options if result is available
																																		if ($qur_routmast0->response_code == 1 && !empty($qur_routmast0->result)) {
																																			foreach ($qur_routmast0->result as $route) { ?>
																																				<option
																																					value="<?= htmlspecialchars($route->sms_route_id) ?>">
																																					<?= htmlspecialchars($route->sms_route_title) ?>
																																				</option>
																																				<?php
																																			}
																																		} else {
																																			echo "<option disabled>No routes available</option>";
																																		}
																																		?>
																																	</select>
																																</div>
																															</div>

																										</div>
																										</td>
																										</tr>
																										<!-- end Message Type -->

																										<!-- start Template Type -->
																										<div style="clear:both;">

																											<tr>
																												<th>
																													<div>
																														<label class="j-label">Header Type
																															<span class="mytooltip tooltip-effect-1">
																																<span class="tooltip-item2">[?]</span>
																																<span class="tooltip-content4 clearfix">
																																	<span class="tooltip-text2">
																																		Header Type - It depends on the type of the
																																		commercial communication message that need s to be
																																		sent with that header. (Eg: Promotional for
																																		promotional messages and for all other select the
																																		Other type)
																																	</span>
																																</span>
																															</span>
																														</label>
																													</div>
																												</th>
																												<td>
																													<div class="j-unit">
																														<div class="j-input">
																															<select name="slt_template_type" id="slt_template_type"
																																tabindex="5" style="height:40px;"
																																class="form-control form-control-primary">
																																<option value="promotional1" selected>Implicit
																																	Promotional</option>
																																<option value="promotional2">Explicit Promotional
																																</option>
																																<option value="transactional">Transactional</option>
																																<option value="service">Service</option>
																															</select>
																														</div>
																													</div>
																										</div>
																										</td>
																										</tr>
																										<!-- end Template Type -->

																										<!-- start Business Category -->
																										<tr>
																											<th>
																												<div>
																													<div>
																														<label class="j-label">Business Category
																															<span class="mytooltip tooltip-effect-1">
																																<span class="tooltip-item2">[?]</span>
																																<span class="tooltip-content4 clearfix">
																																	<span class="tooltip-text2">
																																		Business Category - There are 9 number of
																																		categories listed in the dropdown list those
																																		entities who does not find their business can
																																		choose "Other" in the category to create the
																																		header. In case the Header Type is "Other" then
																																		category is optional but for Promotional category
																																		is mandatory.
																																	</span>
																																</span>
																															</span>
																														</label>
																													</div>
																											</th>
																											<td>
																											<div class="j-unit">
																															<select name="slt_business_category"
																																id="slt_business_category" tabindex="6"
																																class="form-control form-control-primary"
																																style="height:40px;">
																																<?php
																																					$replace_txt = '';
																																					// Call the reusable cURL function
																	 $response = executeCurlRequest($api_url . "/list/business_category", "POST", $replace_txt);
																																// Decode JSON response
																																$sql_routmast1 = json_decode($response);
																																// Check if the response has the expected data
																																if ($sql_routmast1->response_code == 1 && !empty($sql_routmast1->result)) {
																																	foreach ($sql_routmast1->result as $category) { ?>
																																		<option
																																			value="<?= htmlspecialchars($category->sender_buscategory_id) ?>">
																																			<?= htmlspecialchars($category->business_category) ?>
																																		</option>
																																		<?php
																																	}
																																} else {
																																	echo "<option disabled>No categories available</option>";
																																}
																																?>
																															</select>
																														</div>

																							</div>
																							</td>
																							</tr>
																							<!-- end Business Category -->

																							<!-- start Header / Sender ID -->
																							<tr>
																								<th>
																									<div>
																										<div>
																											<label class="j-label">Header / Sender ID
																												<span class="mytooltip tooltip-effect-1">
																													<span class="tooltip-item2">[?]</span>
																													<span class="tooltip-content4 clearfix">
																														<span class="tooltip-text2">
																															Sender ID - Header Name will be decided by the Entity
																															basis on their business requirements and Entity name.
																															(Eg: Entity Name: HDFC BANK , Header Name: HDFCBK) Refer
																															Table 1 to understand the validations and possible type
																															of headers that can be created under various categories
																															for Govt and Non-Govt entities.
																														</span>
																													</span>
																												</span>
																											</label>
																										</div>
																								</th>
																								<td>
																									<div class="j-unit">
																										<div class="j-input">
																											<!-- <label class="j-icon-right" for="header_sender_id">
																												<i class="icofont icofont-map"></i>
																											</label> -->
																											<input type="text" name="header_sender_id" id='header_sender_id'
																												class="form-control" maxlength="6"
																												value="<?= $header_sender_id ?>" tabindex="7" required=""
																												placeholder="Header / Sender ID"
																												style="text-transform: uppercase; height:40px; ">

																											<? site_log_generate("DLT Existing Sender ID Page : User : " . $_SESSION['yjucp_user_name'] . " Collect Sender ID form on " . date("Y-m-d H:i:s")); ?>
																										</div>
																									</div>
																						</div>
																						</td>
																						</tr>
																						<!-- end Header / Sender ID -->

																						<!-- start Attachment -->
																						<div id='hide_attachments' style="clear:both; padding-top: 10px;">
																							<tr>
																								<th>
																									<div id='ex_doc'>
																										<label class="j-label">Upload Existing Documents
																											<span class="mytooltip tooltip-effect-1">
																												<span class="tooltip-item2">[?]</span>
																												<span class="tooltip-content4 clearfix">
																													<span class="tooltip-text2">
																														Must Upload the Existing Sender ID Approval attachment.
																														Only JPG, PNG, PDF Allowed
																													</span>
																												</span>
																											</span>
																										</label>
																									</div>
																								</th>

																								<td>
																									<div class="j-unit">
																										<div class="j-input">
																											<!-- <label class="j-icon-right" for="license_docs">
																												<i class="icofont icofont-map"></i>
																											</label> -->
																											<input type="file" class="form-control" style="height:40px;"
																												name="license_docs" id='license_docs' tabindex="11" <?
																												if ($display_action == 'Add') { ?>required="" <? } ?>>
																										</div>
																									</div>
																						</div>
																						</td>
																						</tr>
																						<!-- end Attachment -->
																						<!-- start Explanation -->
																						<tr>
																							<th>
																								<div>
																									<div>
																										<label class="j-label">Sender ID Description
																											<span class="mytooltip tooltip-effect-1">
																												<span class="tooltip-item2">[?]</span>
																												<span class="tooltip-content4 clearfix">
																													<span class="tooltip-text2">
																														Description about the Business and Sender ID
																													</span>
																												</span>
																											</span>
																										</label>
																									</div>
																							</th>
																							<td>
																								<div class="j-unit">
																									<div class="j-input">
																										<!-- <label class="j-icon-right" for="txt_explanation">
																											<i class="icofont icofont-map"></i>
																										</label> -->
																										<input type="text" name="txt_explanation" style="height:40px;"
																											id='txt_explanation' class="form-control" maxlength="100"
																											value="<?= $txt_explanation ?>" tabindex="8" required=""
																											placeholder="Sender ID Description">
																									</div>
																								</div>
																					</div>
																					</td>
																					</tr>
																					<!-- end Explanation -->

																					<!-- start Consent Template Name -->
																					<tr>
																						<th>
																							<div>
																								<div>
																									<label class="j-label">Consent Template Name
																										<span class="mytooltip tooltip-effect-1">
																											<span class="tooltip-item2">[?]</span>
																											<span class="tooltip-content4 clearfix">
																												<span class="tooltip-text2">
																													Consent Template is created to acquire prior consent from
																													the customer to send commercial communication which are
																													related to Service or Promotion of Product / Services of an
																													Business Entity. To create a New Consent Template, first
																													type a relevant Consent Template Name as per the Entity
																													business requirement.
																												</span>
																											</span>
																										</span>
																									</label>
																								</div>
																						</th>
																						<td>
																							<div class="j-unit">
																								<div class="j-input">
																									<!-- <label class="j-icon-right" for="txt_constempname">
																										<i class="icofont icofont-map"></i>
																									</label> -->
																									<input type="text" name="txt_constempname" id='txt_constempname'
																										class="form-control" style="height:40px;" maxlength="100"
																										value="<?= $txt_constempname ?>" tabindex="12" required=""
																										placeholder="Consent Template Name">
																									<? site_log_generate("DLT Existing Sender ID Page : User : " . $_SESSION['yjucp_user_name'] . " Collect Consent Details form on " . date("Y-m-d H:i:s")); ?>
																								</div>
																							</div>
																			</div>
																			</td>
																			<!-- end Consent Template Name -->

																			<!-- start Brand Name -->
																			<tr>
																				<th>
																					<div>
																						<div>
																							<label class="j-label">Company / Brand Name
																								<span class="mytooltip tooltip-effect-1">
																									<span class="tooltip-item2">[?]</span>
																									<span class="tooltip-content4 clearfix">
																										<span class="tooltip-text2">
																											Company Name known as Brand Name
																										</span>
																									</span>
																								</span>
																							</label>
																						</div>
																				</th>
																				<td>
																					<div class="j-unit">
																						<div class="j-input">
																							<!-- <label class="j-icon-right" for="txt_consbrndname">
																								<i class="icofont icofont-map"></i>
																							</label> -->
																							<input type="text" name="txt_consbrndname" style="height:40px;"
																								id='txt_consbrndname' class="form-control" maxlength="100"
																								value="<?= $txt_consbrndname ?>" tabindex="13" required=""
																								placeholder="Company / Brand Name">
																						</div>
																					</div>
																		</div>
																		</td>
																		<!-- end Brand Name -->

																		<!-- start Consent Message -->
																		<tr>
																			<th>
																				<div>
																					<div>
																						<label class="j-label">Consent Message
																							<span class="mytooltip tooltip-effect-1">
																								<span class="tooltip-item2">[?]</span>
																								<span class="tooltip-content4 clearfix">
																									<span class="tooltip-text2">
																										To create content for the consent template type the content
																										required in this Content Message
																									</span>
																								</span>
																							</span>
																						</label>
																					</div>
																			</th>
																			<td>
																				<div class="j-unit">
																					<div class="j-input">
																						<!-- <label class="j-icon-right" for="txt_consmsg">
																							<i class="icofont icofont-map"></i>
																						</label> -->
																						<input type="text" name="txt_consmsg" style="height:40px;" id='txt_consmsg'
																							class="form-control" maxlength="100" value="<?= $txt_consmsg ?>"
																							tabindex="14" required="" placeholder="Consent Message">
																					</div>
																				</div>
																	</div>
																	</td>
																	</tr>
																	<!-- end Consent Message -->

																	<!-- start Consent Attachment -->
																	<tr>
																		<th>
																			<div id='hide_attachments'>
																				<div>
																					<label class="j-label">Consent Documents
																						<span class="mytooltip tooltip-effect-1">
																							<span class="tooltip-item2">[?]</span>
																							<span class="tooltip-content4 clearfix">
																								<span class="tooltip-text2">
																									Upload the relevant document related to Consent. Existing Consent
																									Template / Licenses / Agreement / Trademark etc. Only JPG, PNG, PDF
																									Allowed.
																								</span>
																							</span>
																						</span>
																					</label>
																				</div>
																		</th>
																		<td>
																			<div class="j-unit">
																				<div class="j-input">
																					<!-- <label class="j-icon-right" for="consent_docs">
																						<i class="icofont icofont-map"></i>
																					</label> -->
																					<input type="file" class="form-control" style="height:40px;"
																						name="consent_docs" id='consent_docs' tabindex="15" <?
																						if ($display_action == 'Add') { ?>required="" <? } ?>>
																				</div>
																			</div>
															</div>
															</td>
															</tr>
															</tbody>
															</table>
															<!-- end Consent Attachment -->

															<!-- start response from server -->
															<div class="j-response"></div>
															<!-- end response from server -->
															<!-- </div> -->

														</div>
														<!-- end /.content -->

													</div>
												</div>
												<div style="clear: both;">&nbsp;</div>
												<div class="j-footer">
													<button type="submit" style="display:none;" class="btn btn-primary">Register</button>
													<input type="submit" name="submit" id="submit" value="Confirm" class="btn btn-primary"
														style="float: right; margin-left: 10px;">
													<button type="button" tabindex="16" class="btn btn-primary waves-effect" id="btn_preview1"
														onclick="preview_senderid()" /> Preview</button>
													<span class="error_display" id='id_error_display'></span>
													<input type="hidden" class="form-control" name='tmpl_call_function' id='tmpl_call_function'
														value='save_senderid' />
													<input type="hidden" class="form-control" name='ex_new_senderid' id='ex_new_senderid'
														value='E' />
												</div>
												<!-- </div> -->
												<!-- end /.footer -->
											</div>

											<div class="col-lg-6">
												<!-- Modal content-->
												<div class="modal fade" id="default-Modal" tabindex="-1" role="dialog">
													<div class="modal-dialog modal-lg" role="document">
														<div class="modal-content">
															<div class="modal-header">
																<h4 class="modal-title">Preview</h4>
																<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																</button>
															</div>
															<div class="modal-body" id="id_modal_display"
																style=" word-break: break-all; white-space: break-all !important;word-wrap: break-word;">
																<h5>Welcome</h5>
																<p>Waiting for load Data..</p>
															</div>
															<div class="modal-footer">
																<input type="submit" name="submit" id="submit" value="Confirm" class="btn btn-primary">
																<button type="button" class="btn btn-primary waves-effect"
																	data-dismiss="modal">Close</button>
															</div>
														</div>
													</div>
												</div>

												</form>
											</div>
										</div>
										<!-- Sender ID Entry -->

									</div>
									</section>
								</div>


							</div>


						</div>
						<div class="card-footer f-right">
							<a href="senderid_list"><button class="btn btn-primary f-right btn-out-dashed"><i
										class="icofont icofont-rounded-double-left"></i> Back</button></a>
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
		$(document).ready(function () {
			$('[data-toggle="tooltip"]').tooltip();
		});

		$(document).ready(function () {
			$('[data-toggle="popover"]').popover({
				html: true,
				content: function () {
					return $('#primary-popover-content').html();
				}
			});
		});

		$('#cn_message').keyup(function () {
			var maxLength = 1000;
			var text = $(this).val();
			var textLength = text.length;
			if (textLength > maxLength) {
				$(this).val(text.substring(0, (maxLength)));
			} else {
			}
		});

		function call_function_updoc(doc_type) {
			if (doc_type == 1) {
				$('#new_doc').css("display", 'block');
				$('#ex_doc').css("display", 'none');
			} else {
				$('#new_doc').css("display", 'none');
				$('#ex_doc').css("display", 'block');
			}
		}

		function preview_senderid() {

			var data_serialize = $("#j-pro").serialize();
			// AJAX request
			$.ajax({
				url: 'ajax/preview_functions.php?tmpl_call_preview_functions=preview_senderid_consent',
				type: 'post',
				data: data_serialize,
				success: function (response) {
					// Add response in Modal body
					$("#id_modal_display").html(response);

					// Display Modal
					$('#default-Modal').modal('show');
				}
			});
		}

		function preview_contenttmpl() {
			var data_serialize = $("#j-pro1").serialize();
			// AJAX request
			$.ajax({
				url: 'ajax/preview_functions.php?tmpl_call_preview_functions=preview_content',
				type: 'post',
				data: data_serialize,
				success: function (response) {
					// Add response in Modal body
					$("#id_modal_display1").html(response);

					// Display Modal
					$('#default-Modal1').modal('show');
				}
			});
		}


		function call_function_document(operator) {
			var rr = $('input[name=slt_operator]:checked', '#j-pro').val();
			if (rr == 3 || rr == 2) {
				$("#hide_attachments").css("display", "block");
			} else {
				$("#hide_attachments").css("display", "none");
			}
		}

		$(document).on("submit", "form#j-pro", function (e) {
			e.preventDefault();
			$("#id_error_display").html("");
			$('#header_sender_id').css('border-color', '#a0a0a0');
			$('#txt_explanation').css('border-color', '#a0a0a0');
			$('#license_docs').css('border-color', '#a0a0a0');

			$('#txt_constempname').css('border-color', '#a0a0a0');
			$('#txt_consbrndname').css('border-color', '#a0a0a0');
			$('#txt_consmsg').css('border-color', '#a0a0a0');
			$('#consent_docs').css('border-color', '#a0a0a0');

			//get input field values
			var header_sender_id = $('#header_sender_id').val();
			var txt_explanation = $('#txt_explanation').val();
			var license_docs = $('#license_docs').val();

			var txt_constempname = $('#txt_constempname').val();
			var txt_consbrndname = $('#txt_consbrndname').val();
			var txt_consmsg = $('#txt_consmsg').val();
			var consent_docs = $('#consent_docs').val();

			var flag = true;
			/********validate all our form fields***********/
			/* header_sender_id field validation  */
			if (header_sender_id == "") {
				$('#header_sender_id').css('border-color', 'red');
				flag = false;
				e.preventDefault();
			}
			if (txt_explanation == "") {
				$('#txt_explanation').css('border-color', 'red');
				flag = false;
				e.preventDefault();
			}

			/* license_docs field validation  */
			if (license_docs == "") {
				$('#license_docs').css('border-color', 'red');
				flag = false;
				e.preventDefault();
			}

			if (txt_constempname == "") {
				$('#txt_constempname').css('border-color', 'red');
				flag = false;
				e.preventDefault();
			}
			if (txt_consbrndname == "") {
				$('#txt_consbrndname').css('border-color', 'red');
				flag = false;
				e.preventDefault();
			}
			if (txt_consmsg == "") {
				$('#txt_consmsg').css('border-color', 'red');
				flag = false;
				e.preventDefault();
			}
			if (consent_docs == "") {
				$('#consent_docs').css('border-color', 'red');
				flag = false;
				e.preventDefault();
			}
			/********Validation end here ****/

			/* If all are ok then we send ajax request to ajax/master_call_functions.php *******/
			if (flag) {
				// var data_serialize = $("#j-pro").serialize();
				var fd = new FormData(this);
				var files = $('#license_docs')[0].files;
				var files1 = $('#consent_docs')[0].files;

				if (files.length > 0) {
					fd.append('file', files[0]);
				}
				if (files1.length > 0) {
					fd.append('file', files1[0]);
				}

				$.ajax({
					type: 'post',
					url: "ajax/message_call_functions.php",
					dataType: 'json',
					data: fd,
					contentType: false,
					processData: false,
					beforeSend: function () {
						$('.theme-loader').show();
					},
					complete: function () {
						$('.theme-loader').hide();
					},
					success: function (myresponse, status, xhr) {
						if (myresponse.status == '0') {
							$('#header_sender_id').val('');
							$('#txt_explanation').val('');
							$('#license_docs').val('');
							$('#txt_constempname').val();
							$('#txt_consbrndname').val();
							$('#txt_consmsg').val();
							$('#consent_docs').val();

							$("#id_error_display").html(myresponse.msg);
							$('#submit').attr('disabled', false);
						} else if (myresponse.status == 1) {
							$("#id_error_display").html("Sender ID Updated..");
							window.location = 'dlt_existing_senderid';
							$('#submit').attr('disabled', false);
						}
						$('.theme-loader').hide();
					},
					error: function (xhr, status, error) {
						$('#header_sender_id').val('');
						$('#txt_explanation').val('');
						$('#license_docs').val('');
						$('#txt_constempname').val();
						$('#txt_consbrndname').val();
						$('#txt_consmsg').val();
						$('#consent_docs').val();

						$("#id_error_display").html(xhr.msg);
						$('#submit').attr('disabled', false);
						$('.theme-loader').hide();
					}
				});
			}
		});

		$(document).on("submit", "form#j-pro1", function (e) {
			e.preventDefault();
			$("#id_error_displays").html("");
			$('#cn_template_name').css('border-color', '#a0a0a0');
			$('#cn_message').css('border-color', '#a0a0a0');

			//get input field values
			var cn_template_name = $('#cn_template_name').val();
			var cn_message = $('#cn_message').val();

			var flag = true;
			/********validate all our form fields***********/
			/* cn_template_name field validation  */
			if (cn_template_name == "") {
				$('#cn_template_name').css('border-color', 'red');
				flag = false;
				e.preventDefault();
			}
			if (cn_message == "") {
				$('#cn_message').css('border-color', 'red');
				flag = false;
				e.preventDefault();
			}
			/********Validation end here ****/

			/* If all are ok then we send ajax request to ajax/master_call_functions.php *******/
			if (flag) {
				var fd = new FormData(this);

				$.ajax({
					type: 'post',
					url: "ajax/message_call_functions.php",
					dataType: 'json',
					data: fd,
					contentType: false,
					processData: false,
					beforeSend: function () {
						$('.theme-loader').show();
					},
					complete: function () {
						$('.theme-loader').hide();
					},
					success: function (response) {
						if (response.status == '0') {
							$('#cn_template_name').val('');
							$('#cn_message').val('');
							$('#submit_template').attr('disabled', false);

							$("#id_error_displays").html(response.msg);
						} else if (response.status == 1) {
							$('#submit_template').attr('disabled', false);
							$("#id_error_displays").html("Sender ID Updated..");
							window.location = 'dlt_existing_senderid';
						}
						$('.theme-loader').hide();
						$("#result").hide().html(output).slideDown();
					},
					error: function (response, status, error) {
						$('#cn_template_name').val('');
						$('#cn_message').val('');
						$('#submit_template').attr('disabled', false);

						$("#id_error_displays").html(response.msg);
						$('.theme-loader').hide();
					}
				});
			}
		});

		// File type validation
		$("#license_docs").change(function () {
			var file = this.files[0];
			var fileType = file.type;
			var match = ['application/pdf', 'image/png', 'image/jpg', 'image/jpeg'];
			if (!((fileType == match[0]) || (fileType == match[1]) || (fileType == match[2]) || (fileType == match[3]) || (
				fileType == match[4]) || (fileType == match[5]))) {
				$("#id_error_display").html('Sorry, only PDF, TXT files are allowed to upload.');
				$("#license_docs").val('');
				return false;
			}
		});
	</script>
	<!-- //js -->
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
