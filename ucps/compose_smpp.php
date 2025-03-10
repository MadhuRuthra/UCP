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
?>
<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<title>Compose SMPP ::
		<?= $site_title ?>
	</title>
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
					<?
					include("libraries/site_menu.php"); ?>

					<div class="pcoded-content">

						<div class="page-header card">
							<div class="row align-items-end">
								<div class="col-lg-8">
									<div class="page-header-title">
										<i class="feather icon-clipboard bg-c-blue"></i>
										<div class="d-inline">
											<h5>Compose SMPP</h5>
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
												<a href="compose_smpp">Compose SMPP</a>
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
												<div class="section-header">

												</div>
												<div class="section-body">
													<div class="row">
														<!-- Message Type Defined -->
														<div class="col-12 col-md-12 col-lg-12">
															<div class="card">
																<form class="needs-validation" novalidate="" id="frm_contact_group"
																	name="frm_contact_group" action="#" method="post" enctype="multipart/form-data">
																	<div class="card-body">
																		<div class="form-group mb-2 row" style="display:none;">
																			<!-- Added style to hide the row -->
																			<label class="col-sm-3 col-form-label">Message <label
																					style="color:#FF0000">*</label>
																				<span data-toggle="tooltip"
																					data-original-title="Choose Same Message or Personalized Message">[?]</span>
																			</label>
																			<div class="col-sm-7">
																				<input type="radio" name="rdo_newex_group" id="rdo_new_group" checked value="N"
																					tabindex="3" onclick="func_open_newex_group('N')"> Generic message
																				&nbsp;&nbsp;&nbsp;
																				<input type="radio" name="rdo_newex_group" id="rdo_ex_group" tabindex="3"
																					value="E" onclick="func_open_newex_group('E')" disabled>
																				<!-- Disabled Personalized message -->
																				Personalized message
																			</div>
																			<div class="col-sm-2">
																			</div>
																		</div>

																		<!-- Conditional Message Type -->
																		<?php if ($_SESSION['yjucp_user_id'] === 1) { ?>
																			<div class="form-group mb-2 row" style="display:none;">
																			<?php } else { ?>
																				<div class="form-group mb-2 row">
																				<?php } ?>
																				<label class="col-sm-3 col-form-label" style="padding-left: 50px;">
																					Message Type
																					<span style="color: #FF0000;">*</span>
																					<span data-toggle="tooltip"
																						data-original-title="Enter the text for your message in the language that you've selected.">[?]</span>
																				</label>
																				<div class="col-md-6 col-lg-8 f-left">
																					<div class="input-group">

																						<?php
																						$replace_txt = '{
																							"rights_name":"SMPP"
																								}';
																								// Call the reusable cURL function
         $response = executeCurlRequest($api_url . "/list/select_compose_messageType", "POST", $replace_txt);

																						$sql_sntsms = json_decode($response);
																						$i1 = 0;
																						$firsthid = 0;
																						$first_hid_display = '';
																						if ($sql_sntsms->response_code == 1 && $sql_sntsms->response_status == 200) {
																							// Check if 'result' has items
																							if (isset($sql_sntsms->result) && count($sql_sntsms->result) > 0) {
																								foreach ($sql_sntsms->result as $indicator => $route) {
																									$i1++;
																									if ($firsthid == 0) {
																										$first_hid_display = $route->sms_route_id;
																									}
																									$firsthid++;

																									$avl_credits = (isset($route->available_messages) && $route->available_messages > 0) ? $route->available_messages : "0";
																									?>
																									<div class="form-radio" data-toggle="tooltip" data-placement="top" title=""
																										data-original-title="Choose Message Type - <?= htmlspecialchars($route->sms_route_title) ?> (<?= htmlspecialchars($route->sms_route_desc) ?> & Available Credits - <?= htmlspecialchars($avl_credits) ?>)">
																										<div class="radio radiofill radio-inline" style="float: left;">
																											<label>
																												<input type="hidden"
																													name="hid_id_slt_route_<?= $route->sms_route_id ?>"
																													id="hid_id_slt_route_<?= $route->sms_route_id ?>"
																													value="<?= htmlspecialchars($avl_credits) ?>">
																												<input type="radio" name="id_slt_route"
																													id="id_slt_route_<?= $firsthid ?>" tabindex="1" autofocus
																													value="<?= $route->sms_route_id ?>" <?= ($route->sms_route_id == 3) ? 'checked="checked"' : '' ?> onchange="call_getheader()"
																													onblur="call_getheader()">
																												<i class="helper"></i><?= htmlspecialchars($route->sms_route_title) ?>
																												[ <?= htmlspecialchars($avl_credits) ?> ]&nbsp;&nbsp;&nbsp;
																											</label>
																										</div>
																									</div>
																									<?php
																								}
																							}
																						}
																						?>
																					</div>
																				</div>
																				<div class="col-md-3 col-lg-2"></div>
																			</div>

																			<div class="form-group mb-2 row">
																				<label class="col-sm-3 col-form-label" style="padding-left: 50px;">
																					Header / Sender ID
																					<span style="color: #FF0000;">*</span>
																					<span data-toggle="tooltip"
																						data-original-title="Enter the text for your message in the language that you've selected.">[?]</span>
																				</label>
																				<div class="col-sm-7">
																					<div id="nw_sndhd_id" style="display: none;">
																						<div class="input-group">
																							<input type="text" placeholder='Enter Header / Sender ID'
																								id="new_id_slt_header" tabindex="2" name="new_id_slt_header"
																								maxlength="6" value="" class="form-control" data-toggle="tooltip"
																								data-placement="top" data-html="true" title=""
																								data-original-title="Enter Header / Sender ID">
																							<span class="input-group-addon"><i
																									class="icofont icofont-listing-box"></i></span>
																						</div>
																					</div>
																					<div id="ex_sndhd_id">
																						<div class="input-group">
																							<select name="id_slt_header" id="id_slt_header" tabindex="2"
																								class="form-control form-control-primary required" data-toggle="tooltip"
																								data-placement="top" title=""
																								data-original-title="Select Header / Sender ID"
																								onchange="updateReplaceText()" onblur="updateReplaceText()">
																								<option value="">Select Header / Sender ID</option>
																								<?php
																								$id_slt_header = htmlspecialchars(strip_tags(isset($_REQUEST['id_slt_header']) ? $conn->real_escape_string($_REQUEST['id_slt_header']) : ""));
																								$user_id = htmlspecialchars(strip_tags(isset($_REQUEST['user_id']) ? $conn->real_escape_string($_REQUEST['user_id']) : ""));
																								$replace_txt = '';
																										// Call the reusable cURL function
						 $response = executeCurlRequest($api_url . "/list/compose_headersender", "POST", $replace_txt);
																								// Decode JSON response
																								$sql_routmast1 = json_decode($response);
																								// Generate options based on API response
																								if ($sql_routmast1->response_code == 1 && isset($sql_routmast1->result) && count($sql_routmast1->result) > 0) {
																									foreach ($sql_routmast1->result as $route) {
																										echo '<option value="' . htmlspecialchars($route->cm_sender_id) . ' ! ' . htmlspecialchars($route->sender_title) . '">' . htmlspecialchars($route->sender_title) . '</option>';
																									}
																								} else {
																									echo '<option value="">No available headers/sender IDs</option>';
																								}
																								?>
																							</select>
																						</div>
																					</div>

																				</div>


																				<div class="col-md-3 col-lg-2 f-left" style="padding-top: 8px;">
																					<a href="dlt_new_senderid" target="_blank"><i
																							class="icofont icofont-plus-circle"></i> Add Header</a>
																				</div>
																			</div>

																			<div class="form-group mb-2 row">
																				<label class="col-sm-3 col-form-label" style="padding-left: 50px;">
																					Content Template
																					<span style="color: #FF0000;">*</span>
																					<span data-toggle="tooltip"
																						data-original-title="Enter the text for your message in the language that you've selected.">[?]</span>
																				</label>

																				<div class="col-sm-7">

																					<div id="ex_cntmpl_id">
																						<div class="input-group">
																							<select name="id_slt_template" id="id_slt_template" tabindex="3"
																								class="form-control form-control-primary required" data-toggle="tooltip"
																								data-placement="top" title="" data-original-title="Select Template"
																								onclick="select_content_template()">

																							</select>
																						</div>
																					</div>
																				</div>
																				<div class="col-md-3 col-lg-2">
																					<a href="content_template_new" target="_blank"><i
																							class="icofont icofont-plus-circle"></i> Add Template</a>
																				</div>
																			</div>

																			.nav-tabs>.active>a, .nav-tabs>.active>a:hover, .nav-tabs>.active>a:focus {

			

																			<div class="fform-group mb-2 row">
																				<label class="col-sm-3 col-form-label" style="padding-left: 50px;">
																					Select SMS Type
																					<span style="color: #FF0000;">*</span>
																					<span data-toggle="tooltip"
																						data-original-title="Enter the text for your message in the language that you've selected.">[?]</span>
																				</label>
																				<div class="col-md-6 col-lg-8 form-radio"
																					style="line-height: 35px; vertical-align: middle;  pointer-events: none;">
																					<div class="radio radio-inline" data-toggle="tooltip" data-placement="top"
																						title="" data-original-title="TEXT SMS : This is only for English Text">
																						<label>
																							<input type="radio" name="txt_sms_type" id="txt_sms_type" value='text'
																								tabindex="11">
																							<i class="helper"></i> TEXT
																						</label>
																					</div>

																					<div class="radio radio-inline" data-toggle="tooltip" data-placement="top"
																						title=""
																						data-original-title="UNICODE SMS : This is allowed Multilingual Text">
																						<label>
																							<input type="radio" name="txt_sms_type" id="txt_sms_type" value='unicode'
																								tabindex="12">
																							<i class="helper"></i> UNICODE
																						</label>
																					</div>
																				</div>
																				<div class="col-md-3 col-lg-2">

																				</div>
																			</div>

																			<div class="form-group mb-2 row">
																				<label class="col-sm-3 col-form-label" style="padding-left: 50px;">
																					Enter SMS content
																					<span style="color: #FF0000;">*</span>
																					<span data-toggle="tooltip"
																						data-original-title="Enter the text for your message in the language that you've selected.">[?]</span>
																				</label>
																				<div class="col-sm-7">
																					<div class="input-group">
																						<textarea id="txt_sms_content" name="txt_sms_content"
																							onkeyup="call_getsmscount()" maxlength="1000" tabindex="13"
																							class="form-control form-control-primary required" data-toggle="tooltip"
																							data-placement="top" placeholder="SMS Content" title=""
																							data-original-title="Enter SMS Content. Note: Confirm SMS / Characters length and No. of SMS before launching this Campaign. Maximum 1000 Characters allowed." readonly
																							style="height: 150px; width: 100%; resize: none;"><?= $cn_msg ?></textarea>
																						<span class="input-group-addon"></span>
																					</div>
																				</div>
																				<div class="col-md-3 col-lg-2">
																					<div style="clear: both; vertical-align: middle;">
																						<? $cnt_ttl_chars = 0;
																						$sms_ttl_chars = 1;
																						if (strlen($cn_msg) > 0) {
																							$cnt_ttl_chars = strlen($cn_msg);
																							$sms_ttl_chars = ceil($cnt_ttl_chars / 160);
																						} ?>
																						<div class="f-left"><input type="text" class="form-control" readonly
																								tabindex="14" style="width: 77px; padding: 10px 5px;"
																								name="txt_char_count" id="txt_char_count" value="<?= $cnt_ttl_chars ?>"
																								data-toggle="tooltip" data-placement="top" title=""
																								data-original-title="Display the Count of Characters"></div>
																						<div class="f-left p-l-10" style="line-height: 35px;"> Characters</div>
																					</div>

																					<div class="m-t-20" style="clear: both; vertical-align: middle;">
																						<div class="f-left" style="clear: both;"><input type="text"
																								class="form-control" readonly tabindex="15"
																								style="width: 77px; padding: 10px 5px;" name="txt_sms_count"
																								id="txt_sms_count" value="<?= $sms_ttl_chars ?>" data-toggle="tooltip"
																								data-placement="top" title=""
																								data-original-title="Display the Count of SMS"></div>
																						<div class="f-left p-l-10" style="line-height: 35px;"> SMS</div>
																					</div>
																				</div>
																			</div>

																			<div class="form-group mb-2 row txt_message_content_area" style="display:none;">
																				<div class="col-sm-7">
																					<div id="txt_list_mobno_txt" class="text-danger"></div>
																				</div>
																				<div class="col-sm-2">
																					<div class="checkbox-fade fade-in-primary">
																						<label data-toggle="tooltip" data-placement="top" data-html="true" title=""
																							data-original-title="Click here to Remove the Duplicates">
																							<input type="checkbox" name="chk_remove_duplicates"
																								id="chk_remove_duplicates" checked="" value="remove_duplicates"
																								tabindex="6" onclick="call_remove_duplicate_invalid()">
																							<span class="cr"><i
																									class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
																							<span class="text-inverse" style="color:#FF0000 !important">Remove
																								Duplicates</span>
																						</label>
																					</div>
																					<div class="checkbox-fade fade-in-primary">
																						<label data-toggle="tooltip" data-placement="top" data-html="true" title=""
																							data-original-title="Click here to remove Invalids Mobile Nos">
																							<input type="checkbox" name="chk_remove_invalids" id="chk_remove_invalids"
																								checked="" value="remove_invalids" tabindex="7"
																								onclick="call_remove_duplicate_invalid()">
																							<span class="cr"><i
																									class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
																							<span class="text-inverse" style="color:#FF0000 !important">Remove
																								Invalids</span>
																						</label>
																					</div>
																				</div>
																			</div>
																			<!-- Upload Mobile Numbers  -->
																			<div class="form-group mb-2 row">
																				<label class="col-sm-3 col-form-label" style="padding-left: 50px;">
																					Upload Mobile Numbers
																					<span style="color: #FF0000;">*</span>
																					<span data-toggle="tooltip"
																						data-original-title="Upload the Contact Downloaded CSV File Here or Enter contact Name">[?]</span>
																				</label>
																				<div class="col-sm-7">
																					<input type="file" class="form-control" name="upload_contact"
																						id='upload_contact' tabindex="6" onclick="chooseFile()" accept=".csv, .txt"
																						data-placement="top" data-html="true"
																						title="Upload the Contacts via CSV or TXT Files">
																					<label style="color:#FF0000">[Upload the Contacts via CSV or TXT Files
																						Only]</label>
																				</div>
																				<div class="col-sm-2">

																					<label class="j-label same_message_typ"><a
																							href="uploads/imports/compose_smpp.csv" download=""
																							class="btn btn-success alert-ajax btn-outline-success" tabindex="8"><i
																								class="icofont icofont-download"></i> Sample CSV
																							File</a></label>
																					<label class="j-label dynamic_media_typ" style="display: none;"><a
																							href="uploads/imports/compose_smpp_media.csv" download=""
																							class="btn btn-success alert-ajax btn-outline-success" tabindex="8"><i
																								class="icofont icofont-download"></i> Sample CSV
																							File</a></label>
																					<label class="j-label customized_message_typ" style="display: none;"><a
																							href="uploads/imports/compose_smpps.csv" download=""
																							class="btn btn-success alert-ajax btn-outline-success" tabindex="7"><i
																								class="icofont icofont-download"></i> Sample CSV
																							File</a></label>

																					<div class="checkbox-fade fade-in-primary" style="display: none;">
																						<label data-toggle="tooltip" data-placement="top" data-html="true" title=""
																							data-original-title="Click here to Remove the Duplicates">
																							<input type="checkbox" name="chk_remove_duplicates"
																								id="chk_remove_duplicates" checked value="remove_duplicates"
																								tabindex="8" onclick="call_remove_duplicate_invalid()">
																							<span class="cr"><i
																									class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
																							<span class="text-inverse" style="color:#FF0000 !important">Remove
																								Duplicates</span>
																						</label>
																					</div>
																					<div class="checkbox-fade fade-in-primary" style="display: none;">
																						<label data-toggle="tooltip" data-placement="top" data-html="true" title=""
																							data-original-title="Click here to remove Invalids Mobile Nos">
																							<input type="checkbox" name="chk_remove_invalids" id="chk_remove_invalids"
																								checked value="remove_invalids" tabindex="8"
																								onclick="call_remove_duplicate_invalid()">
																							<span class="cr"><i
																									class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
																							<span class="text-inverse" style="color:#FF0000 !important">Remove
																								Invalids</span>
																						</label>
																					</div>
																					<div class="checkbox-fade fade-in-primary" style="display: none;">
																						<label data-toggle="tooltip" data-placement="top" data-html="true" title=""
																							data-original-title="Click here to remove Stop Status Mobile No's">
																							<input type="checkbox" name="chk_remove_stop_status"
																								id="chk_remove_stop_status" checked value="remove_stop_status"
																								tabindex="8" onclick="call_remove_duplicate_invalid()">
																							<span class="cr"><i
																									class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
																							<span class="text-inverse" style="color:#FF0000 !important">Remove Stop
																								Status Mobile
																								No's</span>
																						</label>
																					</div>

																					<div class="checkbox-fade fade-in-primary" id='id_mobupload'>
																					</div>
																				</div>
																			</div>
																		</div>
																		<div class="card-footer text-center">
																			<div class="text-center">
																				<span class="error_display" id='id_error_display'></span>
																			</div>
																			<input type="hidden" name="filename_upload" id="filename_upload" value="">
																			<input type="hidden" name="total_mobilenos_count" id="total_mobilenos_count"
																				value="">
																			<input type="hidden" class="form-control" name='tmpl_call_function'
																				id='tmpl_call_function' value='compose_smpp' />
																			<input type="button" onclick="myFunction_clear()" value="Clear"
																				class="btn btn-success submit_btn" id="clr_button" tabindex="9">
																			<input type="submit" name="compose_submit" id="compose_submit" tabindex="10"
																				value="Submit" class="btn btn-success submit_btn">
																			<input type="button" value="Preview Content" onclick="preview_content()"
																				data-toggle="modal" data-target="#previewModal"
																				class="btn btn-success submit_btn" id="pre_button" name="pre_button"
																				tabindex="11">
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
											<h4 class="modal-title">SMPP Details</h4>
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


						</div>

						<?php include("libraries/site_footer.php"); ?>

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
										<br>
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
		// Initialize replace_txt with default values
		let replace_txt_for = {
			"user_id": "<?php echo $_SESSION['yjucp_user_id']; ?>",
			"id_slt_header": ""
		};

		function updateReplaceText() {
			console.log("updateReplaceText")
			const selectedValue = document.getElementById('id_slt_header').value.split("!");
			$.ajax({
				type: 'post',
				url: "ajax/display_functions.php?call_function=compose_call_smpp&selectedValue_tmplname=" + selectedValue[0],
				dataType: 'html',
				processData: false, // Important: Prevent jQuery from processing the data
				contentType: false, // Important: Let the browser set the content type
				success: function (response) {
					//alert(response);// Success
					$("#id_slt_template").html(response);
					var get_msgtype = $("#id_slt_template").val().split("!");
					$("#txt_sms_content").val(get_msgtype[1])
					$("#txt_char_count").val(get_msgtype[1].length)
					// Check if get_msgtype[0] is available and set the radio button accordingly
					if (get_msgtype[0] === 'TEXT') {
						$("input[name='txt_sms_type'][value='text']").prop("checked", true);
					} else if (get_msgtype[0] === 'UNICODE') {
						$("input[name='txt_sms_type'][value='unicode']").prop("checked", true);
					}
					console.log(get_msgtype[0])
					console.log(response.status);

				},
				error: function (response, status, error) { // Error
					console.log("error");
				}
			});
		}
		function select_content_template() {
			var get_msgtype = $("#id_slt_template").val().split("!");
			$("#txt_sms_content").val(get_msgtype[1])
			$("#txt_char_count").val(get_msgtype[1].length)
			// Check if get_msgtype[0] is available and set the radio button accordingly
			if (get_msgtype[0] === 'TEXT') {
				$("input[name='txt_sms_type'][value='text']").prop("checked", true);
			} else if (get_msgtype[0] === 'UNICODE') {
				$("input[name='txt_sms_type'][value='unicode']").prop("checked", true);
			}
		}

		var invalid_mobile_nos;
		var mobile_array = [];
		var trimmedText;
		var valid_variable_values = [];
		var message_txt;
		// FORM Clear value    
		function myFunction_clear() {
			document.getElementById("frm_contact_group").reset();
			//window.location.reload();
		}
		//const textarea = document.getElementById('textarea');

		var variable_count = 0;  // Initialize variable_count to 0
		var add_variable_count = variable_count + 1;
		console.log(add_variable_count)
		//textarea.addEventListener('input', updateResult);
		//textarea.value = '';
		// const btn = document.getElementById('btn');
		// btn.disabled = checkIfButtonShouldBeDisabled(); // Update button state on page load
		// btn.addEventListener('click', function handleClick() {
		// 	if (add_variable_count <= 10) {
		// 		// const startPos = textarea.selectionStart;
		// 		// const endPos = textarea.selectionEnd;
		// 		// const textBeforeCursor = textarea.value.substring(0, startPos);
		// 		// const textAfterCursor = textarea.value.substring(endPos);
		// 		// textarea.value = textBeforeCursor + '{{' + add_variable_count++ + '}}' + textAfterCursor;
		// 		// const end = textarea.value.length;
		// 		// textarea.setSelectionRange(end, end);
		// 		// textarea.focus();
		// 		// Disable button if 10 variables are reached
		// 		if (add_variable_count === 11) {
		// 			btn.disabled = true;
		// 		}
		// 	}
		// });

		function updateResult() {
			console.log("Update Result");
			var t = textarea.value;
			var regex = /{{(\w+)}}/g;
			var matches = t.match(regex);
			variable_count = matches ? matches.length : 0;

			// If the textarea is cleared, allow adding 10 variables again
			if (t.trim() === '') {
				variable_count = 0;
				btn.disabled = false; // Enable the button
			}
			// If more than 10 variables are detected, prevent adding more
			if (variable_count > 10) {
				// Remove the last typed variable
				textarea.value = t.substring(0, t.lastIndexOf('{{')) + t.substring(t.lastIndexOf('}}') + 2);
				variable_count--;
			}
			// Update add_variable_count based on variable_count
			add_variable_count = variable_count + 1;
			// Update button state based on the current variable count
			btn.disabled = checkIfButtonShouldBeDisabled();
		}

		function checkIfButtonShouldBeDisabled() {
			return variable_count >= 10;
		}
		console.log(variable_count)
		$(function () {
			$('.theme-loader').fadeOut("slow");
			func_open_newex_group('N');
		});
		document.body.addEventListener("click", function (evt) {
			//note evt.target can be a nested element, not the body element, resulting in misfires
			$("#id_error_display").html("");
			$("#file_image_header").prop('disabled', false);
			$("#file_image_header_url").prop('disabled', false);
		});
		function func_change_groupname(sender_id) {
			var send_code = "&sender_id=" + sender_id;
			$('#slt_group').html('');
			console.log("!!!FALSE");
		}

		function func_open_personalised_video(personalized_video) {
			if (personalized_video == 'S') {
				$('.media_type').css("display", "none");
				$('.dynamic_media_typ').css("display", "none");
				$('.same_message_typ').css("display", "none");
				$('.customized_message_typ').css("display", "block");
				// $('#id_upload_media').css("display", "block");
				document.getElementById('upload_contact').value = '';
			} else if (personalized_video == 'P') {
				$("#media_type_img").prop("checked", true);
				$('.media_type').css("display", "");
				$('.dynamic_media_typ').css("display", "block");
				$('#id_upload_media').css("display", "none");
				$('.same_message_typ').css("display", "none");
				$('.customized_message_typ').css("display", "none");
				document.getElementById('upload_contact').value = '';
			} else if (personalized_video == 'N') {
				$('.media_type').css("display", "none");
				$('.dynamic_media_typ').css("display", "none");
				$('.same_message_typ').css("display", "none");
				$('.customized_message_typ').css("display", "block");
				$('#id_upload_media').css("display", "none");
				document.getElementById('upload_contact').value = '';
			}
		}

		function func_open_newex_group(group_available) {
			// $('#textarea').css('border-color', '');
			// $('#textarea').val('');
			$('#upload_contact').val('');
			$('#file_image_header').val('');
			$('#file_image_header_url').val('');
			var group_avail = $("input[type='radio'][name='rdo_newex_group']:checked").val();
			if (group_avail == 'N') {
				// $('#id_upload_media').css("display", "block");
				$('.media_type').css("display", "none");
				$('.variable_msg').css("display", "none");
				$('.dynamic_media_typ').css("display", "none");
				$('.customized_message_typ').css("display", "none");
				$('.same_message_typ').css("display", "block");
				$('#btn').css("display", "none");
				$('#id_personalised_video').css("display", "none");
				$('#id_ex_groupname').css("display", "none");
				$('.txt_message_content_area').css({ display: 'none' });
				//$('#textarea').prop("required", true);
				$('#slt_group').prop("required", false);
				$('.required_mn').css("visibility", "hidden");
				$('.required_mn').css("display", "none");
				//$('#textarea').val('');
				$("#current_text_value").html("0");
				$('#frm_contact_group').removeClass("was-validated");
				$('#upload_contact').prop("required", true);
			} else if (group_avail == 'E') {
				$('#id_upload_media').css("display", "none");
				$("#rdo_same_video").prop("checked", true);
				$('.dynamic_media_typ').css("display", "none");
				$('#file_image_header_url').val('');
				$('.txt_message_content_area').css("display", "none");
				// $('#textarea').val('');
				$('.variable_msg').css("display", "block");
				$("#current_text_value").html("0");
				$('#frm_contact_group').removeClass("was-validated");
				$('.customized_message_typ').css("display", "block");
				$('.same_message_typ').css("display", "none");
				$('#btn').css("display", "block");
				// $('#id_personalised_video').css("display", "");
				// $('#textarea').val('');
				$('.required_mn').css("visibility", "visible");
				$('.required_mn').css("display", "");
				$('#id_ex_groupname').css("display", "block");
				//$('#textarea').prop("required", false);
				//$('#slt_group').prop("required", true);
				$('#upload_contact').prop("required", true);
			}
		}

		function chooseFile() {
			console.log("Choose File")
			document.getElementById('upload_contact').value = '';
		}
		document.getElementById('upload_contact').addEventListener('change', function () {
			validateFile();
		});
		function validateFile() {
			console.log("Validate file")
			var group_avail = $("input[type='radio'][name='rdo_newex_group']:checked").val();
			//	var textarea = document.getElementById('textarea');

			//if (textarea.value.trim().length >= 2) {
			// if (group_avail == 'E') {
			// 	var pattern = /{{(\w+)}}/g;
			// 	if (!pattern.test(textarea.value.trim())) {
			// 		console.log("Pattern not found in the text.");
			// 		$("#id_error_display").html("Variable count should not be zero because it is a customized message.");
			// 		document.getElementById('upload_contact').value = ''; // Clear the file input
			// 		return;
			// 	}
			// }
			//$('#textarea').css('border-color', '#e4e6fc');
			var input = document.getElementById('upload_contact');
			var file = input.files[0];
			var allowedExtensions = /\.(csv|txt)$/i; // Updated to allow both CSV and TXT
			var maxSizeInBytes = 100 * 1024 * 1024; // 100MB

			if (!allowedExtensions.test(file.name)) {
				$("#id_error_display").html("Invalid file type. Please select a .csv or .txt file.");
				document.getElementById('upload_contact').value = ''; // Clear the file input
			} else if (file.size > maxSizeInBytes) {
				$("#id_error_display").html("File size exceeds the maximum limit (100MB).");
				document.getElementById('upload_contact').value = ''; // Clear the file input
			} else {
				$("#id_error_display").html(""); // Clear any previous error message
				readFileContents(file);
			}
			console.log(file);
		}
		//else {
		// 	handleEmptyOrInvalidTextarea(group_avail);
		// }
		//}

		// function handleEmptyOrInvalidTextarea(group_avail) {
		// 	var textarea = document.getElementById('textarea');
		// 	if (textarea.value.trim().length == '') {
		// 		if (group_avail == 'E') {
		// 			$('#textarea').css('border-color', 'red');
		// 			$("#id_error_display").html("Enter the message content.");
		// 		}
		// 	} else if (textarea.value.trim().length < 2 && group_avail == 'E') {
		// 		$("#id_error_display").html('Message content should have at least 2 characters.');
		// 		$('#textarea').css('border-color', 'red');
		// 	}
		// 	document.getElementById('upload_contact').value = ''; // Clear the file input
		// }

		function validateNumber(number) {
			console.log("Validate number")
			return /^91[6-9]\d{9}$/.test(number);
		}

		var copiedFile, file_location_path;
		var cleanedData = [];
		// validate mobile numbers
		function validateNumber(number) {
			console.log("Validate number 1")
			return /^91[6-9]\d{9}$/.test(number);
		}
		//copy file
		function copyFile(file) {
			console.log("Copy file")
			// Extract filename and extension
			var fileNameParts = file.name.split('.');
			var fileName = fileNameParts[0];
			var fileExtension = fileNameParts[1];
			// Append "_copy" to the filename
			var copiedFileName = fileName + "_copy." + fileExtension;
			// Create a new file with the copied filename
			var copiedFile = new File([file], copiedFileName, { type: file.type });
			// Return the copied file
			return copiedFile;
		}

		// read Files 
		function readFileContents(file, Media, DuplicateAllowed) {
			console.log("readFileContents")
			//	message_txt = textarea.value;
			var media_name = $("input[type='radio'][name='rdo_sameperson_video']:checked").val();
			var slt_whatsapp_template = $("#slt_whatsapp_template").val();
			// console.log(file, Media, DuplicateAllowed + "file, Media, DuplicateAllowed")
			cleanedData = [];
			// console.log(DuplicateAllowed + "DuplicateAllowed");
			$(".display_msg").css("display", "");
			$(".modal-footer").css("display", "");
			$('#img_display').removeAttr('src');
			$('.preloader-wrapper').show();
			var reader = new FileReader();
			reader.onload = function (event) {
				var contents = event.target.result;
				var workbook = XLSX.read(contents, {
					type: 'binary'
				});
				// Copy the file  
				copiedFile = copyFile(file);
				// Use the copied file as needed
				// console.log("Copied file:", copiedFile);

				var firstSheetName = workbook.SheetNames[0];
				var worksheet = workbook.Sheets[firstSheetName];
				var data = XLSX.utils.sheet_to_json(worksheet, {
					header: 1
				});
				var totalColumns = data[0].length;
				//array values get in invalids,dublicates
				var invalidValues = [];
				var duplicateValuesInColumnA = [];
				var uniqueValuesInColumnA = new Set();
				var validCount = 0;

				for (var columnIndex = 0; columnIndex < data[0].length; columnIndex++) {
					var value = data[0][columnIndex]; // Value in the first row at the current column index
					// console.log(value + "value");
				}

				var firstRowLength = data[0].length;
				template_variable_count = 0;
				// var template_variable_count = parseInt(templateDetails[2], 10);
				// console.log(template_variable_count + "template_variable_count STARt")
				for (var rowIndex = 0; rowIndex < data.length; rowIndex++) {
					var valueA = data[rowIndex][0]; // Assuming column A is at index 0
					if (!validateNumber(valueA) && valueA != undefined) {
						invalidValues.push(valueA);
					}
					else if (data[rowIndex].length == template_variable_count) {
						invalidValues.push(valueA);
					}
					else if (uniqueValuesInColumnA.has(valueA) && DuplicateAllowed === false && valueA != undefined) {
						validCount++;
						duplicateValuesInColumnA.push(valueA);
					} else if (valueA != undefined) {
						uniqueValuesInColumnA.add(valueA);
						validCount++;
						// Construct a JSON object for the current row
						var jsonObject = {};
						for (var columnIndex = 0; columnIndex < data[rowIndex].length; columnIndex++) {
							var key = columnIndex; // You can customize the key names as needed
							jsonObject[key] = data[rowIndex][columnIndex];
						}
						cleanedData.push(jsonObject); // Add the JSON object to cleanedData
					}
				}
				valid_count = uniqueValuesInColumnA.length;
				// console.log(validCount);
				document.getElementById('total_mobilenos_count').value = validCount;
				var totalCount = data.length;

				var selectedValue = $('input[name="duplicate_value"]:checked').val();
				if (selectedValue === 'duplicate_allowed') {
					document.getElementById('total_mobilenos_count').value = validCount;
				} else {
					var valid_no = validCount - duplicateValuesInColumnA.length;
					document.getElementById('total_mobilenos_count').value = valid_no;
				}

				if (slt_whatsapp_template == '') {
					$('.preloader-wrapper').hide();
					$('.loading_error_message').css("display", "none");
					$(".display_msg").css("display", "none");
					$(".modal-footer").css("display", "none");
					$('#img_display').attr('src', 'libraries/assets/png/failed.png');
					$('#upload_file_popup').modal('show');
					$('#file_response_msg').html('<b>Please select Template!.</b>');
					document.getElementById('upload_contact').value = '';
				}
				else if (((template_variable_count != '0') && template_variable_count != firstRowLength)) {
					$('.preloader-wrapper').hide();
					$('.loading_error_message').css("display", "none");
					$(".display_msg").css("display", "none");
					$(".modal-footer").css("display", "none");
					$('#upload_file_popup').modal('show');
					$('#img_display').attr('src', 'libraries/assets/png/failed.png');
					$('#file_response_msg').html('<b>Variable count mismatch. </b>');
					document.getElementById('upload_contact').value = '';
				}
				else if ((invalidValues.length + duplicateValuesInColumnA.length === totalCount)) {
					$('.preloader-wrapper').hide();
					$('.loading_error_message').css("display", "none");
					$(".display_msg").css("display", "none");
					$(".modal-footer").css("display", "none");
					$('#img_display').attr('src', 'libraries/assets/png/failed.png');
					$('#upload_file_popup').modal('show');
					$('#file_response_msg').html(
						'<b>The count of valid numbers is 0. Therefore, it is not possible to create a campaign, and the file cannot be uploaded. </b>'
					);
					document.getElementById('upload_contact').value = '';
				}
				else if ((Media == undefined && firstRowLength > 1 && !template_variable_count)) {
					$('.preloader-wrapper').hide();
					$('.loading_error_message').css("display", "none");
					$(".display_msg").css("display", "none");
					$(".modal-footer").css("display", "none");
					$('#upload_file_popup').modal('show');
					$('#img_display').attr('src', 'libraries/assets/png/failed.png');
					$('#file_response_msg').html('<b>Invalid File Format.Check Template. </b>');
					document.getElementById('upload_contact').value = '';

				} else if (invalidValues.length > 0 && duplicateValuesInColumnA.length > 0) {
					$('.preloader-wrapper').hide();
					$('.loading_error_message').css("display", "none");
					$('#img_display').css("display", "none");
					// Show the modal
					$('#upload_file_popup').modal('show');
					$('#file_response_msg').html('<b>Invalid Numbers: \n' + JSON.stringify(invalidValues.length) +
						'\n Duplicate Numbers: \n' + JSON.stringify(duplicateValuesInColumnA.length) + '</b>');
				} else if (duplicateValuesInColumnA.length > 0) {
					$('#img_display').css("display", "none");
					$('.preloader-wrapper').hide();
					$('.loading_error_message').css("display", "none");
					// Show the modal
					$('#upload_file_popup').modal('show');
					$('#file_response_msg').html('<b>Duplicate Numbers : \n' + JSON.stringify(duplicateValuesInColumnA
						.length) + '</b>');
				} else if (invalidValues.length > 0) {
					$('#img_display').css("display", "none");
					// console.log("else if 7")
					$('.preloader-wrapper').hide();
					$('.loading_error_message').css("display", "none");
					// Show the modal
					$('#upload_file_popup').modal('show');
					$('#file_response_msg').html('<b>Invalid Numbers : \n' + JSON.stringify(invalidValues.length) +
						'</b>');
				} else {
					csvfile();
					// console.log("else  8");
					$('.preloader-wrapper').hide();
					$('.loading_error_message').css("display", "none");
					// $('#upload_file_popup').modal('show');
					$('#file_response_msg').html('<b>Validating Successfully.</b>');
				}
			}
			reader.readAsBinaryString(file);
		}

		$('#upload_file_popup').find('.btn-secondary').on('click', function () {
			$('#upload_contact').val('');
		});

		// $("#textarea").keyup(function () {
		// 	trimmedText = $(this).val().trim(); // Trim the input text
		// 	$("#current_text_value").text(trimmedText.length); // Update the length of trimmed text
		// });
		// FORM preview value
		function preview_content() {
			var form = $("#frm_contact_group")[0]; // Get the HTMLFormElement from the jQuery selector
			var txt_sms_mobno = $('input[name="txt_sms_mobno"]:checked').serialize()
			var data_serialize = $("#frm_contact_group").serialize();
			var group_avail = $("input[type='radio'][name='rdo_newex_group']:checked").val();
			var fd = new FormData(form); // Use the form element in the FormData constructor
			var upload_contact = $('#upload_contact').text();
			fd.append('upload_contact', upload_contact);
			if (txt_sms_mobno == "") {
			}
			else {
				var mobile_split = txt_sms_mobno.split("&")
				for (var i = 0; i < mobile_split.length; i++) {
					var mobile_no_split = mobile_split[i].split("=")
					if (i == 0) {
						mobile_array = mobile_no_split[1]
					}
					else {
						mobile_array = mobile_array + "," + mobile_no_split[1]
					}
				}
			}
			fd.append('mobile_numbers', mobile_array);
			$.ajax({
				type: 'post',
				url: "ajax/preview_call_functions.php?preview_functions=preview_compose_smpp",
				data: fd,
				processData: false, // Important: Prevent jQuery from processing the data
				contentType: false, // Important: Let the browser set the content type
				success: function (response) { // Success
					$("#id_modal_display").html(response);
					console.log(response.status);
					$('#default-Modal').modal({ show: true }); // Open in a Modal Popup window
				},
				error: function (response, status, error) { // Error
					console.log("error");
					$("#id_modal_display").html(response.status);
					$('#default-Modal').modal({ show: true });
				}
			});
		}


		// To Remove the Duplicate Mobile numbers
		function call_remove_duplicate_invalid() {
			var chk_remove_duplicates = 0;
			if ($("#chk_remove_duplicates").prop('checked') == true) {
				chk_remove_duplicates = 1;
			}
			var chk_remove_invalids = 0;
			if ($("#chk_remove_invalids").prop('checked') == true) {
				chk_remove_invalids = 1;
			}
			var chk_remove_stop_status = 0;
			if ($("#chk_remove_stop_status").prop('checked') == true) {
				chk_remove_stop_status = 1;
			}
			var upload_contact = $('#upload_contact').text();
			if (upload_contact != '') {
				$.ajax({
					type: 'post',
					url: "ajax/message_call_functions.php",
					data: { validateMobno: 'validateMobno', dup: chk_remove_duplicates, inv: chk_remove_invalids },
					success: function (response) { // Success
						if (response.status == 1) {
							let response_msg_text = response.msg;
							const response_msg_split = response_msg_text.split("||");
							if (response_msg_split[1] != '') {
								invalid_mobile_nos = "Invalid Mobile Nos : " + response_msg_split[1] + "This Mobile Numbers Are Invalid Mobile Numbers.Are You Sure The Compose sms ?";
							}
							if (chk_remove_stop_status == 1) {
							}
						} else {
							$("#id_error_display").html(response.msg);
						}
					},
					error: function (response, status, error) { // Error
					}
				});
			}
		}

		// Define a flag to track whether the modal has been opened
		var modalOpened = false;

		$(document).on("submit", "form#frm_contact_group", function (e) {
			e.preventDefault();
			$('#compose_submit').prop('disabled', false);
			$("#id_error_display").html("");
			//	$('#textarea').css('border-color', '#a0a0a0');
			$('#slt_group').css('border-color', '#a0a0a0');
			$('#upload_contact').css('border-color', '#a0a0a0');
			$('#file_image_header').css('border-color', '#a0a0a0');

			//get input field values 
			// var textarea = $('#textarea').val();
			// textarea = textarea.trim();
			var slt_group = $('#slt_group').val();
			var txt_char_count = $('#txt_char_count').val();
			var upload_contact = $('#upload_contact').val();
			var group_avail = $("input[type='radio'][name='rdo_newex_group']:checked").val();
			var txt_sms_mobno = $('input[name="txt_sms_mobno"]:checked').serialize();
			var file_image_header = $('#file_image_header').val();
			var file_image_header_url = $('#file_image_header_url').val();
			var media = $("input[type='radio'][name='rdo_sameperson_video']:checked").val();
			var templateName = $('#id_slt_template option:selected').text(); // Get the text

			var flag = true;

			var mobile_array = "";

			/********validate all our form fields***********/
			/* textarea field validation  */
			// if (group_avail == 'N') {
			// 	// if (textarea == "") {
			// 	// 	$('#textarea').css('border-color', 'red');
			// 	// 	flag = false;
			// 	// } else if (textarea.length < 2) {
			// 	// 	// Show error message
			// 	// 	$("#id_error_display").html('Message content should have atleast 2 characters .');
			// 	// 	$('#textarea').css('border-color', 'red');
			// 	// 	flag = false;
			// 	// }
			// } else if (group_avail == 'E') {
			// 	if (textarea == "") {
			// 		$('#textarea').css('border-color', 'red');
			// 		document.getElementById('upload_contact').value = '';
			// 		flag = false;
			// 	} else if (textarea.length < 2) {
			// 		// Show error message
			// 		$("#id_error_display").html('Message content should have atleast 2 Characters.');
			// 		$('#textarea').css('border-color', 'red');
			// 		flag = false;
			// 	}
			// }

			if (media == 'S') {
				if (file_image_header_url == "" && file_image_header == "") {
					$('#file_image_header').css('border-color', 'red');
					flag = false;
				}
			}
			<? if ($_REQUEST['group'] == '') { ?>
			<? } ?>
			var txt_sms_mobno = $('input[name="txt_sms_mobno"]:checked').serialize();
			var txt_qr_mobno = $("input[type='radio'][name='txt_qr_mobno']:checked").val();
			var mobile_split = txt_sms_mobno.split("&")
			for (var i = 0; i < mobile_split.length; i++) {
				var mobile_no_split = mobile_split[i].split("=")
				if (i == 0) {
					mobile_array = mobile_no_split[1]
				}
				else {
					mobile_array = mobile_array + "," + mobile_no_split[1]
				}
			}
			//let character_count = message_txt.length
			/* If all are ok then we send ajax request to ajax/master_call_functions.php *******/
			if (flag) {
				var fd = new FormData(this);

				console.log("******|||||||||*****", valid_variable_values.length)
				fd.append('mobile_numbers', valid_variable_values.length);
				fd.append('templateName', templateName);
				$.ajax({
					type: 'post',
					url: "ajax/message_call_functions.php",
					dataType: 'json',
					data: fd,
					contentType: false,
					processData: false,
					beforeSend: function () {
						$('#compose_submit').attr('disabled', true);
						$('.theme-loader').show();
					},
					complete: function () {
						$('#compose_submit').attr('disabled', false);
						$('.theme-loader').hide();
					},
					success: function (response) {
						$('#image_display').removeAttr('src');
						if (response.status == 0) {
							// $('#textarea').val('');
							$('#frm_contact_group').removeClass('was-validated');
							$('#upload_contact').val('');
							$('#compose_submit').attr('disabled', false);
							// $("#id_error_display").html(response.msg);
							$('#image_display').attr('src', 'libraries/assets/png/failed.png');
							$('#campaign_compose_message').modal({ show: true });
							$("#message").html(response.msg);
						} else if (response.status == 2) {
							//window.location = 'logout';
							$('#frm_contact_group').removeClass('was-validated');
							$('#compose_submit').attr('disabled', false);
							// $("#id_error_display").html(response.msg);
							$('#compose_submit').attr('disabled', false);
							$('#image_display').attr('src', 'libraries/assets/png/failed.png');
							$('#campaign_compose_message').modal({ show: true });
							$("#message").html(response.msg);
						} else if (response.status == 1) {
							// $('#textarea').val('');
							$('#upload_contact').val('');
							$('#frm_contact_group').removeClass('was-validated');
							//$('#compose_submit').attr('disabled', true);
							$('#campaign_compose_message').modal({ show: true });
							$('#image_display').attr('src', 'libraries/assets/png/success.png');
							$("#message").html("Campign Created Successfully");
							// $("#id_error_display").html(response.msg);
							setInterval(function () {
								window.location = 'compose_smpp_list';
								document.getElementById("frm_contact_group").reset();
							}, 2000);
						}
						$('.theme-loader').hide();
					},
					error: function (response, status, error) {
						// window.location = 'logout';
						// $('#textarea').val('');
						$('#upload_contact').val('');
						$('#compose_submit').attr('disabled', false);
						$('.theme-loader').show();
						$("#id_error_display").html(response.msg);
					}
				})
			}
		});

		function disable_texbox(my_filename, new_filename) {
			$("#" + my_filename).prop('disabled', false);
			$("#" + new_filename).val('');
			$("#" + new_filename).prop('disabled', true);
		}

		$("#upload_contact").change(function () { //csv
			if (this.files[0] == '') {
				var file = this.files[0];
				var fileType = file.type;
				var match = ['text/csv'];
				if (!((fileType == match[0]) || (fileType == match[1]) || (fileType == match[2]) || (fileType == match[3]) || (fileType == match[4]) || (fileType == match[5]))) {
					$("#id_error_display").html('Sorry, only CSV file are allowed to upload.');
					$("#upload_contact").val('');
					return false;
				}
			}
		});

		$("#file_image_header").change(function () {
			$("#id_error_display").html('');

			var file = $("#file_image_header")[0].files[0];
			var fileType = file.type;
			var fileSize = Math.round(file.size / 1024 / 1024);

			var allowedTypes = ['image/jpeg', 'image/png', 'video/mp4', 'video/x-msvideo', 'video/x-matroska', 'video/quicktime'];
			if (!allowedTypes.includes(fileType)) {
				$("#id_error_display").html('Sorry, only JPG/PNG/MP4/AVI/MOV/MKV files are allowed to upload.');
				$("#file_image_header").val('');
				return false;
			}

			if (fileSize > 5) {
				$("#id_error_display").html('Sorry, Upload Media file below 5 MB size');
				$("#file_image_header").val('');
				return false;
			}

			// Additional check for video duration
			if (fileType.startsWith('video/')) {
				var reader = new FileReader();
				reader.onload = function (e) {
					var video = document.createElement('video');
					video.src = e.target.result;
					video.onloadedmetadata = function () {
						var duration = video.duration; // in seconds
						var maxDuration = 30;
						if (duration > maxDuration) {
							$("#id_error_display").html('Sorry, Upload video with duration below 30 seconds.');
							$("#file_image_header").val('');
						}
					};
				};
				reader.readAsDataURL(file);
			}
		});

		$('#upload_file_popup').find('.save_compose_file').on('click', function () {
			csvfile();
		});

		function csvfile() {
			var fd = new FormData();
			// Append the copied file to the FormData object
			fd.append('copiedFile', copiedFile);
			$.ajax({
				type: 'post',
				url: "ajax/whatsapp_call_functions.php?storecopy_file=copy_file_smpp",
				dataType: 'json',
				data: fd,
				contentType: false,
				processData: false,
				beforeSend: function () {
					$('.updateprocessing').show();
				},
				complete: function () {
					$('.updateprocessing').hide();
					$('.loading_error_message').css("display", "none");
				},
				success: function (response) {
					if (response.status == '0') {
						console.log("File Not copied ...failed");
						// console.log(response.msg);
					} else {
						file_location_path = response.file_location;
						console.log("File copied Successfully");
						// Convert cleanedData to CSV format
						const productValuesArrays = cleanedData.map(obj => Object.values(obj));
						// const headers = Object.keys(cleanedData[0]);
						// productValuesArrays.unshift(headers);
						const csvContent = productValuesArrays.map(row => row.join(",")).join("\n");
						// Get the file name
						var fileName = file_location_path.substring(file_location_path.lastIndexOf('/') + 1);
						// console.log("File name:", fileName);
						// Set the hidden value
						document.getElementById('filename_upload').value = fileName;
						// Convert the CSV content into a Blob
						const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
						// Create a FormData object and append the Blob
						const formData = new FormData();
						formData.append('valid_numbers', blob);
						formData.append('filename', fileName);
						// Send the FormData to the server using AJAX
						$.ajax({
							type: 'POST',
							url: 'csvfile_write.php',
							data: formData,
							contentType: false,
							processData: false,
							success: function (response) {
								console.log('File written successfully');
							},
							error: function (xhr, status, error) {
								console.error('Error occurred while writing the file:', error);
							}
						});
					}
				}
			});
		}


		// $('#textarea').on('input', function (event) {
		// 	// Get the input value
		// 	var inputValue = $(this).val();

		// 	// Check if backticks (`), single quotes ('), or double quotes (") are present in the input
		// 	if (inputValue.includes('`') || inputValue.includes("'") || inputValue.includes('"')) {
		// 		// Remove all occurrences of backticks, single quotes, and double quotes from the input
		// 		inputValue = inputValue.replace(/[`'"]/g, '');

		// 		// Update the input value
		// 		$(this).val(inputValue);
		// 	}
		// });
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
