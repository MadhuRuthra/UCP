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

	<title>DLT New Sender ID ::
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
			/* background-color: #94c3ec54;
		border-color: #ddd #ddd #94c3ec54; */
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
											<h5>DLT New Sender ID</h5>
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
												<a href="">DLT New Sender ID</a>
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
													<? /* <h5><?=$display_action?> Attachments</h5> */ ?>
												</div>
												<div class="card-block">

													<div class="row">
														<div class="col-md-12">
															<div id="wizard">
																<section>
																	<ul class="nav nav-tabs tabs" role="tablist">
																		<li class="nav-item">
																			<a class="nav-link active" data-toggle="tab" href="#senderid_approval"
																				onclick="call_func_tabopen('senderid_approval')" role="tab">DLT List</a>
																		</li>
																		<li class="nav-item">
																			<a class="nav-link" data-toggle="tab" href="#consent_approval"
																				onclick="call_func_tabopen('consent_approval')" role="tab">Consent List</a>
																		</li>
																		<li class="nav-item">
																			<a class="nav-link" data-toggle="tab" href="#content_approval"
																				onclick="call_func_tabopen('content_approval')" role="tab">Content List</a>
																		</li>
																	</ul>

																	<div class="tab-content tabs card-block"
																		style="background-color: #FFF; border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd;">
																		<!-- Sender ID List -->
																		<div class="tab-pane active" id="senderid_approval" role="tabpanel">
																			<div class="table-responsive dt-responsive">
																				<table id="basic-btn" class="table table-striped table-bordered">
																					<thead>
																						<tr>
																							<th>#</th>
																							<th>DLT</th>
																							<th>Description</th>
																							<th>Status</th>
																						</tr>
																					</thead>
																					<tbody>

																						<?php
																						$replace_txt = '';
																						// Call the reusable cURL function
																						$response = executeCurlRequest($api_url . "/list/dlt_list", "POST", $replace_txt);
																						$list = json_decode($response);
																						$increment = 0;

																						if (!empty($list->result)) {
																							foreach ($list->result as $item) {
																								$increment++;
																								$entrydate = date('d-m-Y H:i:s A', strtotime($item->sender_entrydate));
																								$display_business = $item->business_category;
																								$status_aprj = "";

																								// Determine sender status
																								switch ($item->sender_status) {
																									case 'W':
																										$display_status = "<label class='label label-lg label-warning'>Waiting for Approval</label>";
																										break;
																									case 'P':
																										$display_status = "<label class='label label-lg label-info'>Processing</label>";
																										break;
																									case 'Y':
																										$display_status = "<label class='label label-lg label-success'>Approved</label>";
																										$status_aprj .= "<br>Approved Date: " . $item->approved_date;
																										$status_aprj .= "<br>Approved Comments: " . $item->approved_comments;
																										break;
																									case 'R':
																										$display_status = "<label class='label label-lg label-danger'>Rejected</label>";
																										$status_aprj .= "<br>Rejected Date: " . $item->approved_date;
																										$status_aprj .= "<br>Rejected Comments: " . $item->approved_comments;
																										break;
																									default:
																										$display_status = "<label class='label label-lg label-info'>Processing</label>";
																										break;
																								}

																								$disp_ex_new_senderid = ($item->exist_new_senderid == 'N') ? "New Sender ID" : "Existing Sender ID";
																								$disp_dlt_process = $item->sms_route_title . " (" . $item->sms_route_desc . ")";
																								?>

																								<tr>
																									<td><?= $increment ?></td>
																									<td>
																										Message Type: <label
																											class='label label-lg label-success'><?= $disp_dlt_process ?></label><br>
																										Header: <?= ucwords($item->sender_temptype) ?><br>
																										Business Category: <?= $display_business ?><br>
																										Sender ID:
																										<label class='label label-lg label-primary' style="cursor: pointer;"
																											onclick="preview_senderid(<?= $item->cm_sender_id ?>)">
																											<b><?= $item->sender_title ?></b>
																										</label>
																										&nbsp;<label
																											class='label label-lg label-warning'><?= $disp_ex_new_senderid ?></label>
																									</td>

																									<td>
																										Attachments:
																										<a href="uploads/license/<?= $item->sender_documents ?>" download
																											class="text-danger"><?= $item->sender_documents ?></a><br>
																										Description: <?= $item->sender_explanation ?><br>
																										<?php if ($item->header_master_id) { ?>
																											<label
																												class='label label-lg label-danger'><?= $item->header_master_id ?></label>
																										<?php } ?>
																									</td>

																									<td>
																										<?= $display_status ?><br>
																										Date: <?= $entrydate ?><br>
																										<?= $status_aprj ?>
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
																							<th>Sender ID</th>
																							<th>Description</th>
																							<th>Status</th>
																						</tr>
																					</tfoot>
																				</table>
																			</div>
																		</div>
																		<!-- Sender ID List -->


																		<!-- Consent List -->
																		<div class="tab-pane" id="consent_approval" role="tabpanel">
																			<div class="table-responsive dt-responsive">
																				<table id="basic-btn1" class="table table-striped table-bordered">
																					<thead>
																						<tr>
																							<th style="width:10%">#</th>
																							<th style="width:20%">Sender ID</th>
																							<th style="width:25%">Consent Template</th>
																							<th style="width:25%">Documents</th>
																							<th style="width:20%">Status</th>
																						</tr>
																					</thead>
																					<tbody>
																						<?php
																						$replace_txt = '';
																							// Call the reusable cURL function
																							$response = executeCurlRequest($api_url . "/list/dlt_consent_list", "POST", $replace_txt);
																							$list = json_decode($response);;
																						$increment1 = 0;

																						if (!empty($list->result)) {
																							foreach ($list->result as $index => $item) {
																								$increment1++;
																								$entrydate_1 = date('d-m-Y H:i:s A', strtotime($item->sender_entrydate));
																								$display_status = "";
																								$status_aprj = "";

																								switch ($item->cm_consent_status) {
																									case 'W':
																										$display_status = "<label class='label label-lg label-warning'>Waiting for Approval</label>";
																										break;
																									case 'P':
																										$display_status = "<label class='label label-lg label-info'>Processing</label>";
																										break;
																									case 'Y':
																										$display_status = "<label class='label label-lg label-success'>Approved</label>";
																										$status_aprj = "<br>Approved Date : " . $item->cm_consent_appr_dt;
																										$status_aprj .= "<br>Approved Comments : " . $item->cm_consent_appr_cmnts;
																										break;
																									case 'R':
																										$display_status = "<label class='label label-lg label-danger'>Rejected</label>";
																										$status_aprj = "<br>Rejected Date : " . $item->cm_consent_appr_dt;
																										$status_aprj .= "<br>Rejected Comments : " . $item->cm_consent_appr_cmnts;
																										break;
																									default:
																										$display_status = "<label class='label label-lg label-info'>Processing</label>";
																										break;
																								}
																								?>
																								<tr>
																									<td style="width:10%"><?= $increment1 ?></td>
																									<td style="width:20%">Sender ID : <?= strtoupper($item->sender_title) ?>
																									</td>
																									<td style="width:25%">
																										Consent : <label class='label label-lg label-primary'
																											style="cursor: pointer;"
																											onclick="preview_consent(<?= $item->cm_consent_id ?>)"><b><?= $item->cm_consent_tmplname ?></b></label>
																										<br>Brand : <?= $item->cm_consent_brand ?>
																									</td>
																									<td style="width:25%">
																										<a href="uploads/consent/<?= $item->cm_consent_docs ?>" download
																											class="text-danger"><?= $item->cm_consent_docs ?></a>
																										<br>Message : <?= $item->cm_consent_msg ?>
																									</td>
																									<td style="width:20%">
																										<?= $display_status ?>
																										<br><?= $entrydate_1 ?>
																										<br><?= $status_aprj ?>
																									</td>
																								</tr>
																								<?php
																							}
																						}
																						?>
																					</tbody>
																					<tfoot>
																						<tr>
																							<th style="width:10%">#</th>
																							<th style="width:20%">Sender ID</th>
																							<th style="width:25%">Consent Template</th>
																							<th style="width:25%">Documents</th>
																							<th style="width:20%">Status</th>
																						</tr>
																					</tfoot>
																				</table>
																			</div>
																		</div>
																		<!-- Consent List -->



																		<!-- Content List -->
																		<div class="tab-pane" id="content_approval" role="tabpanel">
																			<div class="table-responsive dt-responsive">
																				<table id="basic-btn2" class="table table-striped table-bordered">
																					<thead>
																						<tr>
																							<th style="width: 10%;">#</th>
																							<th style="width: 20%;">Sender ID</th>
																							<th style="width: 15%;">Consent Template</th>
																							<th style="width: 20%;">Content Template</th>
																							<th style="width: 20%;">Content Message</th>
																							<th style="width: 15%;">Status</th>
																						</tr>
																					</thead>
																					<tbody>
																						<?php
																									$replace_txt = '';
																									// Call the reusable cURL function
																									$response = executeCurlRequest($api_url . "/list/dlt_content_list", "POST", $replace_txt);
																									$list = json_decode($response);;
																						$increment1 = 0;
																						foreach ($list->result as $item) {
																							$increment1++;
																							$entrydate_2 = date('d-m-Y H:i:s A', strtotime($item->sender_entrydate));
																							$approve_date = date('d-m-Y H:i:s A', strtotime($item->cn_approve_date));
																							$display_business = $item->business_category;

																							switch ($item->cn_status) {
																								case 'W':
																									$display_status = "<label class='label label-lg label-warning'>Waiting for Approval</label>";
																									break;
																								case 'P':
																									$display_status = "<label class='label label-lg label-info'>Processing</label>";
																									break;
																								case 'Y':
																									$display_status = "<label class='label label-lg label-success'>Approved</label><br>Approved Date: {$approve_date}<br>Approved Comments: {$item->cn_approve_cmnts}";
																									break;
																								case 'R':
																									$display_status = "<label class='label label-lg label-danger'>Rejected</label><br>Rejected Date: {$approve_date}<br>Rejected Comments: {$item->cn_approve_cmnts}";
																									break;
																								default:
																									$display_status = "<label class='label label-lg label-info'>Processing</label>";
																									break;
																							}
																							?>
																							<tr>
																								<td style="width: 10%;"><?= $increment1 ?></td>
																								<td style="width: 20%;">Sender ID:
																									<?= strtoupper($item->sender_title) ?><br>Template Type:
																									<?= $item->cn_template_type ?><br>Category: <?= $display_business ?>
																								</td>
																								<td style="width: 15%;"><?= $item->cm_consent_tmplname ?></td>
																								<td style="width: 20%;"><label class="label label-lg label-primary"
																										style="cursor: pointer;"
																										onclick="preview_content(<?= $item->cm_content_tmplid ?>)"><b><?= $item->cn_template_name ?></b></label>
																								</td>
																								<td style="width: 20%;"><label
																										class="text-success"><?= $item->cn_msgtype ?></label><br><?= $item->cn_message ?>
																								</td>
																								<td style="width: 15%;"><?= $display_status ?><br><?= $entrydate_2 ?></td>
																							</tr>
																						<?php } ?>
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
	<!-- CSS Files -->
<link rel="stylesheet" type="text/css" href="libraries/assets/template_sender/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="libraries/assets/template_sender/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="libraries/assets/template_sender/responsive.bootstrap4.min.css">

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
