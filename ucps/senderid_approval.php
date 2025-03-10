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
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<title>Senderid Approval ::
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
	<!-- CSS Files -->
	<link rel="stylesheet" type="text/css" href="libraries/assets/template_sender/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="libraries/assets/template_sender/buttons.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="libraries/assets/template_sender/responsive.bootstrap4.min.css">

	<link rel="stylesheet" type="text/css" href="libraries/assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="libraries/assets/css/pages.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	<style type="text/css">
		th,
		td {
			white-space: inherit;
			word-break: break-word;
		}

		.nav-tabs .nav-item.show .nav-link,
		.nav-tabs .nav-link.active {
			color: #000;
			/* background-color: #94c3ec54;
				border-color: #ddd #ddd #94c3ec54; */
		}

		.blockquote.blockquote-reverse {
			background-color: #e0e0e0;
			text-align: left;
			border-left: 0.25rem solid #505050;
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
											<h5>Senderid Approval</h5>
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
												<a href="">Senderid Approval</a>
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
												<div class="card-header">
													<div class="text-center">
														<a href="https://dltconnect.airtel.in/login/" class="red_status m-10" target="_blank"><img
																src="libraries/assets/png/airtel.png" style="width:100px; height:100px;"></a>&nbsp;<a
															href="https://trueconnect.jio.com/#/home/common-login" class="red_status m-10"
															target="_blank"><img src="libraries/assets/png/jio.png"
																style="width:100px; height:100px;"></a>&nbsp;<a href="https://www.ucc-bsnl.co.in/login/"
															class="red_status m-10" target="_blank"><img src="libraries/assets/png/bsnl.png"
																style="width:100px; height:100px;"></a>&nbsp;<a
															href="https://pingconnect.in/entity/register-with" class="red_status m-10"
															target="_blank"><img src="libraries/assets/png/videocon.png"
																style="width:100px; height:100px;"></a>&nbsp;
													</div>
													<div class="f-right"><a href="approval_instruction" class="f-18 text-danger"
															title="Help Documents"> <i class="icofont icofont-book"></i> HELP</div>
												</div>
												<div class="card-block">

													<div class="row">
														<div class="col-md-12">
															<div id="wizard">

																<span class="error_display f-right" id='id_error_display'></span>
																<section>
																	<ul class="nav nav-tabs tabs" role="tablist" id="myTab">
																		<li class="nav-item">
																			<a class="nav-link active" data-toggle="tab" href="#senderid_approval"
																				onclick="call_func_tabopen('senderid_approval')"
																				data-target="#senderid_approval" role="tab">DLT Approval</a>
																		</li>
																		<li class="nav-item">
																			<a class="nav-link" data-toggle="tab" href="#consent_approval"
																				onclick="call_func_tabopen('consent_approval')" data-target="#consent_approval"
																				role="tab">Consent Approval</a>
																		</li>
																		<li class="nav-item">
																			<a class="nav-link" data-toggle="tab" href="#content_approval"
																				onclick="call_func_tabopen('content_approval')" data-target="#content_approval"
																				role="tab">Content Approval</a>
																		</li>
																	</ul>

																	<div class="tab-content tabs card-block"
																		style="background-color: #FFF; border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd;">
																		<!-- Sender ID Approval -->
																		<div class="tab-pane active" id="senderid_approval" role="tabpanel">
																			<div class="table-responsive dt-responsive">
																				<table id="basic-btn" class="table table-striped table-bordered">
																					<thead>
																						<tr>
																							<th>#</th>
																							<th>User</th>
																							<th>Sender ID</th>
																							<th>Sender Category</th>
																							<th>Description</th>
																							<th>Status</th>
																							<th>Action</th>
																						</tr>
																					</thead>
																					<tbody>
																						<?php
																								$replace_txt = '';
																								// Call the reusable cURL function
         $response = executeCurlRequest($api_url . "/list/approve_templatelist", "POST", $replace_txt);
																						$list = json_decode($response);
																						if ($list->response_code == 1 && $list->response_status == 200) {
																							foreach ($list->result as $index => $sender) {
																								$entrydate = date('d-m-Y H:i:s A', strtotime($sender->sender_entrydate));
																								$status_text = '';
																								$status_info = '';

																								switch ($sender->sender_status) {
																									case 'W':
																										$status_text = "<label class='label label-lg label-warning'>Waiting for Approval</label>";
																										break;
																									case 'P':
																										$status_text = "<label class='label label-lg label-info'>Processing</label>";
																										break;
																									case 'Y':
																										$status_text = "<label class='label label-lg label-success'>Approved</label>";
																										$status_info = "Approved Date: {$sender->approved_date}<br>Approved Comments: {$sender->approved_comments}";
																										break;
																									case 'R':
																										$status_text = "<label class='label label-lg label-danger'>Rejected</label>";
																										$status_info = "Rejected Date: {$sender->approved_date}<br>Rejected Comments: {$sender->approved_comments}";
																										break;
																									default:
																										$status_text = "<label class='label label-lg label-info'>Processing</label>";
																										break;
																								}

																								$sender_id_type = $sender->exist_new_senderid === 'N' ? 'New Sender ID' : 'Existing Sender ID';
																								$message_type = "{$sender->sms_route_title} ({$sender->sms_route_desc})";
																								?>
																								<tr>
																									<td><?= $index + 1 ?></td>
																									<td><a href="view_user?ustat=view_user&uid=<?= $sender->user_id ?>"
																											target="_blank" class="text-bold"><?= $sender->user_id ?> -
																											<?= $sender->user_name ?></a></td>
																									<td><b><?= $sender->sender_title ?></b><br><br><?= $sender_id_type ?></td>
																									<td>
																										Message Type: <?= $message_type ?><br>
																										Header: <?= ucwords($sender->sender_temptype) ?><br>
																										Business Category: <?= $sender->business_category ?>
																									</td>
																									<td>
																										Attachments: <a href="uploads/license/<?= $sender->sender_documents ?>"
																											download class="text-bold"><?= $sender->sender_documents ?></a><br>
																										Description: <?= $sender->sender_explanation ?>
																									</td>
																									<td><?= $status_text ?><br>Date: <?= $entrydate ?><br><?= $status_info ?>
																									</td>
																									<td>
																										<div class="form-radio">
																											<div class="radio radiofill radio-inline" style="float: left;">
																												<label>
																													<input type="radio"
																														name="senderid_status_<?= $sender->cm_sender_id ?>" value="P"
																														onclick="call_function_senderid(<?= $sender->cm_sender_id ?>,'Processing')">
																													<i class="helper"></i>Processing
																												</label>
																											</div>
																											<div class="radio radiofill radio-inline" style="float: left;">
																												<label>
																													<input type="radio"
																														name="senderid_status_<?= $sender->cm_sender_id ?>" value="Y"
																														onclick="call_function_senderid(<?= $sender->cm_sender_id ?>, 'Approve')">
																													<i class="helper"></i>Approve
																												</label>
																											</div>
																											<div class="radio radiofill radio-inline" style="float: left;">
																												<label>
																													<input type="radio"
																														name="senderid_status_<?= $sender->cm_sender_id ?>" value="R"
																														onclick="call_function_senderid(<?= $sender->cm_sender_id ?>,'Reject')">
																													<i class="helper"></i>Reject
																												</label>
																											</div>
																										</div>
																										<input type="text" maxlength="30"
																											placeholder="Approved Sender Header ID"
																											title="Approved Sender Header ID" name="approved_hdrid[]"
																											id="approved_hdrid_<?= $sender->cm_sender_id ?>"><br>
																										<input type="text" maxlength="300" placeholder="Admin Comments"
																											title="Admin Comments" name="approved_comments[]"
																											id="approved_comments_<?= $sender->cm_sender_id ?>"
																											onfocus="call_function_mustsid(<?= $sender->cm_sender_id ?>, '<?= $sender->sender_title ?>')">
																									</td>
																								</tr>
																								<?php
																							}
																						}
																						?>
																					</tbody>
																					<tfoot>
																						<tr>
																							<th>#</th>
																							<th>User</th>
																							<th>Sender ID</th>
																							<th>Sender Category</th>
																							<th>Description</th>
																							<th>Status</th>
																							<th>Action</th>
																						</tr>
																					</tfoot>
																				</table>
																			</div>
																		</div>

																		<!-- Sender ID Approval -->

																		<!-- Sender ID Entry -->
																		<!-- Sender ID Entry -->
																		<div class="tab-pane" id="consent_approval" role="tabpanel">
																			<div class="table-responsive dt-responsive">
																				<table id="basic-btn1" class="table table-striped table-bordered">
																					<thead>
																						<tr>
																							<th style="width:8%">#</th>
																							<th style="width:12%">Sender ID</th>
																							<th style="width:20%">Consent Template</th>
																							<th style="width:20%">Documents</th>
																							<th style="width:15%">Status</th>
																							<th style="width:25%">Action</th>
																						</tr>
																					</thead>
																					<tbody>
																						<?php
$replace_txt = '';
// Call the reusable cURL function
$response = executeCurlRequest($api_url . "/list/consent_approval", "POST", $replace_txt);
$list = json_decode($response);
																						if ($list && $list->response_code == 1 && isset($list->result)) {
																							$increment1 = 0;
																							foreach ($list->result as $item) {
																								$increment1++;

																								// Status Label
																								$display_status = "";
																								$status_aprj = "";
																								$entrydate_1 = date('d-m-Y H:i:s A', strtotime($item->sender_entrydate));

																								switch ($item->cm_consent_status) {
																									case 'W':
																										$display_status = "<label class='label label-lg label-warning'>Waiting for Approval</label>";
																										break;
																									case 'P':
																										$display_status = "<label class='label label-lg label-info'>Processing</label>";
																										break;
																									case 'Y':
																										$display_status = "<label class='label label-lg label-success'>Approved</label>";
																										$status_aprj .= "<br>Approved Date: " . $item->cm_consent_appr_dt;
																										$status_aprj .= "<br>Approved Comments: " . $item->cm_consent_appr_cmnts;
																										break;
																									case 'R':
																										$display_status = "<label class='label label-lg label-danger'>Rejected</label>";
																										$status_aprj .= "<br>Rejected Date: " . $item->cm_consent_appr_dt;
																										$status_aprj .= "<br>Rejected Comments: " . $item->cm_consent_appr_cmnts;
																										break;
																									default:
																										$display_status = "<label class='label label-lg label-info'>Processing</label>";
																										break;
																								}
																								?>
																								<tr>
																									<td style="width:8%"><?= $increment1 ?></td>
																									<td style="width:12%">
																										User: <a href="view_user?ustat=view_user&uid=<?= $item->user_id ?>"
																											target="_blank" class="text-bold">
																											<?= $item->user_id . " - " . $item->user_name ?>
																										</a><br>
																										Sender ID: <?= strtoupper($item->sender_title) ?>
																									</td>
																									<td style="width:20%">
																										Consent: <label style="cursor: pointer; text-decoration: underline;"
																											onclick="preview_consent(<?= $item->cm_consent_id ?>)">
																											<b><?= $item->cm_consent_tmplname ?></b>
																										</label><br>
																										Brand: <?= $item->cm_consent_brand ?>
																									</td>
																									<td style="width:20%">
																										<a href="uploads/consent/<?= $item->cm_consent_docs ?>" download
																											class="text-bold"><?= $item->cm_consent_docs ?></a><br>
																										Message: <?= $item->cm_consent_msg ?>
																									</td>
																									<td style="width:15%">
																										<?= $display_status ?><br>
																										<?= $entrydate_1 ?><br>
																										<?= $status_aprj ?>
																									</td>
																									<td style="width:25%">
																										<div class="form-radio">
																											<div class="radio radiofill radio-inline" style="float: left;">
																												<label>
																													<input type="radio"
																														name="consentid_status_<?= $item->cm_consent_id ?>" value="P"
																														onclick="call_function_consentid(<?= $item->cm_consent_id ?>)">
																													<i class="helper"></i>Processing
																												</label>
																											</div>
																											<div class="radio radiofill radio-inline" style="float: left;">
																												<label>
																													<input type="radio"
																														name="consentid_status_<?= $item->cm_consent_id ?>" value="Y"
																														onclick="call_function_consentid(<?= $item->cm_consent_id ?>)">
																													<i class="helper"></i>Approve
																												</label>
																											</div>
																											<div class="radio radiofill radio-inline" style="float: left;">
																												<label>
																													<input type="radio"
																														name="consentid_status_<?= $item->cm_consent_id ?>" value="R"
																														onclick="call_function_consentid(<?= $item->cm_consent_id ?>)">
																													<i class="helper"></i>Reject
																												</label>
																											</div>
																										</div>
																										<input type="text" maxlength="300" name="approved_cscomments[]" value=""
																											id="approved_cscommentsVal_<?= $item->cm_consent_id ?>"
																											onfocus="call_function_mustcsid(<?= $item->cm_consent_id ?>, '<?= $item->cm_consent_tmplname ?>')"
																											onblur="call_function_consentid(<?= $item->cm_consent_id ?>)">

																									</td>
																								</tr>
																								<?php
																							}
																						}
																						?>
																					</tbody>
																					<tfoot>
																						<tr>
																							<th style="width:8%">#</th>
																							<th style="width:12%">Sender ID</th>
																							<th style="width:20%">Consent Template</th>
																							<th style="width:20%">Documents</th>
																							<th style="width:15%">Status</th>
																							<th style="width:25%">Action</th>
																						</tr>
																					</tfoot>
																				</table>
																			</div>
																		</div>
																		<!-- Sender ID Approval -->

																		<!-- Template Entry -->
																		<div class="tab-pane" id="content_approval" role="tabpanel">
																			<div class="table-responsive dt-responsive">
																				<table id="basic-btn2" class="table table-striped table-bordered">
																					<thead>
																						<tr>
																							<th style="width: 8%;">#</th>
																							<th style="width: 20%;">Sender ID</th>
																							<th style="width: 18%;">Consent Template</th>
																							<th style="width: 12%;">Content Template</th>
																							<th style="width: 20%;">Content Message</th>
																							<th style="width: 12%;">Status</th>
																							<th style="width: 15%;">Action</th>
																						</tr>
																					</thead>
																					<tbody>
																						<?php
$replace_txt = '';
// Call the reusable cURL function
$response = executeCurlRequest($api_url . "/list/content_approval", "POST", $replace_txt);
$list = json_decode($response);
																						$increment1 = 0;
																						if ($list->response_code == 1 && isset($list->result) && count($list->result) > 0) {
																							foreach ($list->result as $indicator => $item) {
																								$increment1++;
																								$entrydate_2 = date('d-m-Y H:i:s A', strtotime($item->cn_entry_date));
																								$display_business = $item->business_category;
																								$display_status = "";

																								// Determine status label
																								switch ($item->cn_status) {
																									case 'W':
																										$display_status = "<label class='label label-lg label-warning'>Waiting for Approval</label>";
																										break;
																									case 'P':
																										$display_status = "<label class='label label-lg label-info'>Processing</label>";
																										break;
																									case 'Y':
																										$display_status = "<label class='label label-lg label-success'>Approved</label>";
																										break;
																									case 'R':
																										$display_status = "<label class='label label-lg label-danger'>Rejected</label>";
																										break;
																									default:
																										$display_status = "<label class='label label-lg label-info'>Processing</label>";
																										break;
																								}

																								// Display the table row
																								?>
																								<tr>
																									<td style="width: 8%;"><?= $increment1 ?></td>
																									<td style="width: 20%;">
																										User: <a href="view_user?ustat=view_user&uid=<?= $item->user_id ?>"
																											target="_blank" class="text-bold"><?= $item->user_name ?>
																											(<?= $item->user_id ?>)</a><br>
																										Sender ID: <?= strtoupper($item->sender_title) ?><br>
																										Category: <?= $display_business ?>
																									</td>
																									<td style="width: 18%;"><?= $item->cm_consent_tmplname ?></td>
																									<td style="width: 12%;">
																										<label class="text-bold" title="Click to Preview"
																											style="cursor: pointer; text-decoration: underline;"
																											onclick="preview_content(<?= $item->cm_content_tmplid ?>)"><?= $item->cn_template_name ?></label><br><br>
																										<?= $item->exist_new_template == 'N' ? 'New Template' : 'Existing Template' ?>
																									</td>
																									<td style="width: 20%;">
																										<label class="text-bold"><?= $item->cn_msgtype ?></label><br>
																										<blockquote class="blockquote blockquote-reverse">
																											<p class="m-b-0"><?= $item->cn_message ?></p>
																										</blockquote>
																									</td>
																									<td style="width: 12%;"><?= $display_status ?><br><?= $entrydate_2 ?></td>
																									<td style="width: 15%;">
																										<div class="form-radio">
																											<div class="radio radiofill radio-inline" style="float: left;">
																												<label>
																													<input type="radio"
																														name="contentid_status_<?= $list->result[$indicator]->cm_content_tmplid ?>"
																														id="contentid_status_<?= $list->result[$indicator]->cm_content_tmplid ?>"
																														tabindex="1" value="P"
																														onclick="call_function_contentid(<?= $list->result[$indicator]->cm_content_tmplid ?>)">
																													<i class="helper"></i>Processing
																												</label>
																											</div>
																											<div class="radio radiofill radio-inline" style="float: left;">
																												<label>
																													<input type="radio"
																														name="contentid_status_<?= $list->result[$indicator]->cm_content_tmplid ?>"
																														id="contentid_status_<?= $list->result[$indicator]->cm_content_tmplid ?>"
																														tabindex="1" value="Y"
																														onclick="call_function_contentid(<?= $list->result[$indicator]->cm_content_tmplid ?>)">
																													<i class="helper"></i>Approve
																												</label>
																											</div>

																											<div class="radio radiofill radio-inline" style="float: left;">
																												<label>
																													<input type="radio"
																														name="contentid_status_<?= $list->result[$indicator]->cm_content_tmplid ?>"
																														id="contentid_status_<?= $list->result[$indicator]->cm_content_tmplid ?>"
																														tabindex="2" value="R"
																														onclick="call_function_contentid(<?= $list->result[$indicator]->cm_content_tmplid ?>)">
																													<i class="helper"></i>Reject
																												</label>
																											</div>
																										</div>
																										<input type="text" maxlength="30" placeholder="Approved Template ID"
																											title="Approved Template ID" name="approved_cttmpltmasid[]"
																											id="approved_cttmpltmasid_<?= $list->result[$indicator]->cm_content_tmplid ?>"
																											value=""
																											onblur="call_function_contentid(<?= $list->result[$indicator]->cm_content_tmplid ?>)">

																										<input type="text" maxlength="300" placeholder="Admin Content Comments"
																											title="Admin Content Comments" name="approved_ctcomments[]"
																											id="approved_ctcomments_<?= $list->result[$indicator]->cm_content_tmplid ?>"
																											value=""
																											onfocus="call_function_mustctid(<?= $list->result[$indicator]->cm_content_tmplid ?>, '<?= $list->result[$indicator]->cn_template_name ?>')"
																											onblur="call_function_contentid(<?= $list->result[$indicator]->cm_content_tmplid ?>)">

																									</td>
																								</tr>
																								<?php
																							}
																						}
																						?>
																					</tbody>
																				</table>
																			</div>
																		</div>

																		<!-- Template Entry -->
																	</div>
																</section>
															</div>
														</div>
													</div>
												</div>

												<div class="card-footer f-right">
													<a href="header_sender_id"><button class="btn btn-primary f-right btn-out-dashed"><i
																class="icofont icofont-rounded-double-left"></i> Back</button></a>
												</div>
											</div>

										</div>
									</div>
								</div>
								<!-- Page body end -->

							</div>


						</div>


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
										<button type="button" class="btn btn-primary waves-effect" id="btnExport"
											onclick="Export_pdf()" /><i class="icofont icofont-file-pdf"></i> PDF</button>
										<button type="button" class="btn btn-primary waves-effect" id="btnExportPrint"
											onclick="Export_print()" /><i class="icofont icofont-printer"></i> Print</button>
										<button type="button" class="btn btn-primary waves-effect" data-dismiss="modal">Close</button>
									</div>
								</div>
							</div>
						</div>

						<!-- Confirmation details content Reject-->
						<div class="modal" tabindex="-1" role="dialog" id="display-Modal">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title">Confirmation details</h4>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<form class="needs-validation" novalidate="" id="reject_form" name="reject_form" action="#"
											method="post" enctype="multipart/form-data" style="display: none;">

											<div class="form-group mb-2 row">
												<label class="col-sm-3 col-form-label">Reason <label style="color:#FF0000">*</label></label>
												<div class="col-sm-9">
													<input class="form-control form-control-primary" type="text" name="reject_reason"
														id="reject_reason" maxlength="50" title="Reason to Reject" tabindex="12"
														placeholder="Reason to Reject" onkeydown="return /[a-z, ]/i.test(event.key)">
												</div>
											</div>
										</form>
										<p id="display_content"></p>
									</div>
									<div class="modal-footer">
										<span class="error_display" id='id_error_reject' style="color: red;"></span>
										<button type="button" class="btn btn-danger display_btn"></button>
										<button type="button" class="btn btn-secondary cancel_btn" data-dismiss="modal">Cancel</button>
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

	<!-- data-table js -->

	<!-- JS Files -->
	<script src="libraries/assets/template_sender/jquery.dataTables.min.js"></script>
	<script src="libraries/assets/template_sender/dataTables.buttons.min.js"></script>
	<script src="libraries/assets/template_sender/js/jszip.min.js"></script>
	<script src="libraries/assets/template_sender/js/pdfmake.min.js"></script>
	<script src="libraries/assets/template_sender/js/vfs_fonts.js"></script>
	<script src="libraries/assets/template_sender/js/buttons.colVis.min.js"></script>
	<script src="libraries/assets/template_sender/buttons.print.min.js"></script>
	<script src="libraries/assets/template_sender/buttons.html5.min.js"></script>
	<script src="libraries/assets/template_sender/dataTables.bootstrap4.min.js"></script>
	<script src="libraries/assets/template_sender/dataTables.responsive.min.js"></script>
	<script src="libraries/assets/template_sender/responsive.bootstrap4.min.js"></script>

	<script>
		function Export_pdf() {
			html2canvas(document.getElementById('basic-btn3'), {
				onrendered: function (canvas) {
					var data = canvas.toDataURL();
					var docDefinition = {
						content: [{
							image: data,
							width: 500
						}]
					};
					pdfMake.createPdf(docDefinition).download("Table.pdf");
				}
			});
		}

		function Export_print() {
			var divToPrint = document.getElementById("basic-btn3");
			newWin = window.open("");
			newWin.document.write(divToPrint.outerHTML);
			newWin.print();
			newWin.close();
		}

		$('#basic-btn').DataTable({
		});
		$('#basic-btn1').DataTable({
		});
		$('#basic-btn2').DataTable({
		});


		function preview_senderid(user_senderid) {
			// // console.log("@@");
			$("#id_modal_display").load("ajax/preview_functions.php?tmpl_call_functions=preview_senderid&senderid=" + user_senderid, function () {
				// // console.log("SU22CC");
				$('#default-Modal').modal({ show: true });
				// console.log("SU33CC");
			});
		}
		function preview_consent(user_consentid) {
			// // console.log("@@");
			$("#id_modal_display").load("ajax/preview_functions.php?tmpl_call_functions=preview_consent&consentid=" + user_consentid, function () {
				// // console.log("SU22CC");
				$('#default-Modal').modal({ show: true });
				// console.log("SU33CC");
			});
		}
		function preview_content(user_contentid) {
			// // console.log("@@");
			$("#id_modal_display").load("ajax/preview_functions.php?tmpl_call_functions=preview_content&contentid=" + user_contentid, function () {
				// // console.log("SU22CC");
				$('#default-Modal').modal({ show: true });
				// console.log("SU33CC");
			});
		}
		var sender_id;
		var apprej;         // Declare globally
		var aprg_cmnts;     // Declare globally
		var aprg_hdrid;     // Declare globally

		// Function to call on sender ID with process name
		function call_function_senderid(senderid, process_name) {
			// Hide reject form initially
			$("#reject_form").css("display", "none");

			// Assign sender_id immediately
			sender_id = senderid;

			// Update modal content based on process_name
			let modalContent = '';
			let modalButtonText = '';

			if (process_name === 'Processing') {
				modalContent = "Are you sure you want to Process ?";
				modalButtonText = "Process";
			} else if (process_name === 'Approve') {
				modalContent = "Are you sure you want to Approve ?";
				modalButtonText = "Approve";
			} else if (process_name === 'Reject') {
				modalContent = "Are you sure you want to Reject ?";
				modalButtonText = "Reject";

				// Show the reject form when process is Reject
				$("#reject_form").css("display", "");
			}

			$("#display_content").html(modalContent);
			$(".display_btn").html(modalButtonText);

			// Get selected status, comments, and header ID
			apprej = $('input[name="senderid_status_' + sender_id + '"]:checked').val();
			aprg_cmnts = $("#approved_comments_" + sender_id).val();
			aprg_hdrid = $("#approved_hdrid_" + sender_id).val();

			// Show modal if all conditions are met
			if (sender_id && apprej !== undefined && aprg_cmnts && aprg_hdrid) {
				$('#display-Modal').modal({ show: true });
			}
		}

		// Event listener to clear input and error when modal is hidden
		$('#display-Modal').on('hidden.bs.modal', function (e) {
			$("#id_error_reject").html("");       // Clear error message
			$('#reject_reason').val('');          // Clear the input field
		});

		// Reject button click event with validation
		$('#display-Modal').find('.display_btn').on('click', function () {
			// Hide the modal and clear error display
			$('#display-Modal').modal('hide');
			$("#id_error_reject").html("");  // Clear error message

			// If process_name is 'Reject', validate the reason
			if ($(".display_btn").html() === "Reject") {
				var reason = $('#reject_reason').val();  // Get the reason input value
				if (reason === "") {
					$("#id_error_reject").html("Please enter a reason to reject");
					$('#display-Modal').modal('show');  // Show modal again with error message
					return;  // Stop further execution if validation fails
				} else if (reason.length < 4 || reason.length > 50) {
					$("#id_error_reject").html("Reason to reject must be between 4 and 50 characters.");
					$('#display-Modal').modal('show');  // Show modal again with error message
					return;  // Stop further execution if validation fails
				}
			}

			// Proceed with the AJAX request if validation passes
			$.ajax({
				type: 'post',
				url: "ajax/message_call_functions.php?tmpl_call_functions=cmnts_senderid&senderid=" + sender_id + "&apprej_status=" + apprej + "&apprej_cmnts=" + aprg_cmnts + "&aprg_hdrid=" + aprg_hdrid,
				dataType: 'json',
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
						$("#id_error_display").html(response.msg);
					} else if (response.status == 1) {
						$("#id_error_display").html("Status & Comments Saved..");
						window.location = 'senderid_approval';
					}
				},
				error: function (response, status, error) {
					$("#id_error_display").html("An error occurred. Please try again.");
				}
			});
		});

		// Clear data when clicking the "Cancel" button
		$('.cancel_btn').on('click', function () {
			$('#reject_reason').val('');           // Clear input field
			$("#id_error_reject").html('');        // Clear error message
		});

		// Function to check if comments and status are provided before proceeding
		function call_function_mustsid(sender_id, txtsender) {
			$("#id_error_display").html("");
			if ($('input[name="senderid_status_' + sender_id + '"]:checked').val() === undefined) {
				$("#id_error_display").html("Before providing your Comments, kindly add Header ID, Approve / Reject this Sender ID - " + txtsender);
			}
		}

		function call_function_consentid(consentid) {
			$("#id_error_display").html("");

			// Get the value of the input field using the new, correctly formatted ID
			var aprg_cmnts = $("#approved_cscommentsVal_" + consentid).val();
			console.log("aprg_cmnts:", aprg_cmnts); // This will now correctly log the value

			var apprej1 = $('input[name="consentid_status_' + consentid + '"]:checked').val();
			var apprej = apprej1 !== undefined ? apprej1 : $('input[name="consentid_status_' + consentid + '"]:checked').val();

			if (consentid != '' && apprej != undefined && aprg_cmnts != '') {
				$.ajax({
					type: 'post',
					url: "ajax/message_call_functions.php?tmpl_call_functions=cmnts_consentid&consentid=" + consentid + "&apprej_status=" + apprej + "&apprej_cmnts=" + aprg_cmnts,
					dataType: 'json',
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
							$("#id_error_display").html(response.msg);
						} else if (response.status == 1) {
							$("#id_error_display").html("Status & Comments Saved..");
							window.location = 'senderid_approval';
						}
						$('.theme-loader').hide();
					},
					error: function (response, status, error) {
						$("#id_error_display").html(response.msg);
						$('.theme-loader').hide();
					}
				});
			}
		}



		function call_function_contentid(contentid) {
			$("#id_error_display").html("");
			// console.log(apprej + "====" + $('input[name="contentid_status_'+contentid+'"]:checked').val());
			var apprej1 = $('input[name="contentid_status_' + contentid + '"]:checked').val();
			if (apprej1 == undefined) {
				var apprej = $('input[name="contentid_status_' + contentid + '"]:checked').val();
			} else {
				var apprej = apprej1;
			}
			var aprg_cmnts = $("#approved_ctcomments_" + contentid).val();
			var aprg_cmstid = $("#approved_cttmpltmasid_" + contentid).val();

			// console.log(apprej1 + "****" + apprej + "****" + $('input[name="contentid_status_'+contentid+'"]:checked').val());

			if (contentid != '' && apprej != undefined && aprg_cmnts != '' && aprg_cmstid != '') {
				// console.log("IPI");
				$.ajax({
					type: 'post',
					url: "ajax/message_call_functions.php?tmpl_call_functions=cmnts_contentid&contentid=" + contentid + "&apprej_status=" + apprej + "&apprej_cmnts=" + aprg_cmnts + "&aprg_cmstid=" + aprg_cmstid,
					dataType: 'json',
					data: "",
					// data : data_serialize,
					// data : fd,
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
							$("#id_error_display").html(response.msg);
						} else if (response.status == 1) {
							$("#id_error_display").html("Status & Comments Saved..");
							window.location = 'senderid_approval';
						}
						$('.theme-loader').hide();
					},
					error: function (response, status, error) {
						$("#id_error_display").html(response.msg);
						$('.theme-loader').hide();
					}
				});
			}
		}

		function call_function_mustctid(contentid, txtsender) {
			$("#id_error_display").html("");
			if ($('input[name="contentid_status_' + contentid + '"]:checked').val() == undefined) {
				$("#id_error_display").html("Before provide your Comments, Kindly Add Template ID, Approve / Reject this Content ID - " + txtsender);
			}
		}

		function call_func_tabopen(tab_name) {
			if (tab_name == 'senderid_approval') {
				// console.log("tab_name:"+tab_name);
				$("#consent_approval").removeClass("tab-pane active").addClass("tab-pane");
				$("#content_approval").removeClass("tab-pane active").addClass("tab-pane");

				$("#consent_approval").attr("aria-expanded", "false");
				$("#content_approval").attr("aria-expanded", "false");
			}
			if (tab_name == 'consent_approval') {
				// console.log("tab_name::"+tab_name);
				$("#senderid_approval").removeClass("tab-pane active").addClass("tab-pane");
				$("#content_approval").removeClass("tab-pane active").addClass("tab-pane");

				$("#senderid_approval").attr("aria-expanded", "false");
				$("#content_approval").attr("aria-expanded", "false");
			}
			if (tab_name == 'content_approval') {
				// console.log("tab_name:::"+tab_name);
				$("#senderid_approval").removeClass("tab-pane active").addClass("tab-pane");
				$("#consent_approval").removeClass("tab-pane active").addClass("tab-pane");
				// console.log("tab_name:::active");

				$("#senderid_approval").attr("aria-expanded", "false");
				$("#consent_approval").attr("aria-expanded", "false");
				// console.log("tab_name:::aria-expanded");
			}
		}
	</script>
	<!-- //js -->

	<!-- filter using -->

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
