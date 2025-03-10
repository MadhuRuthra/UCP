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
	<title>Compose SMS ::
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
											<h5>Compose SMS</h5>
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
												<a href="compose_sms">Compose SMS</a>
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
														<!-- Message Type Defiend -->
														<div class="col-12 col-md-12 col-lg-12">
															<div class="card">
																<form class="needs-validation" novalidate="" id="frm_contact_group"
																	name="frm_contact_group" action="#" method="post" enctype="multipart/form-data">
																	<div class="card-body">

																		<!-- Message Content Text Box -->
																		<div class="form-group mb-2 row">
																			<label class="col-sm-3 col-form-label" style="padding-left: 50px;">
																				Message Content
																				<span style="color: #FF0000;">*</span>
																				<span data-toggle="tooltip"
																					data-original-title="Enter the text for your message in the language that you've selected.">[?]</span>
																			</label>
																			<div class="col-sm-7">
																				<div class="row">
																					<div class="col-12">
																						<!-- TEXT area alert -->
																						<textarea id="textarea" class="delete form-control" name="textarea" required
																							maxlength="1024" tabindex="11" placeholder="Enter Message Content"
																							rows="6"
																							style="width: 100%; height: 150px !important; resize: none;"></textarea>
																						<div class="row" style="right: 0px;">
																							<div class="col-sm-2" style="margin-top: 5px;">
																								Count:
																								<span id="current_text_value">0</span><span id="maximum"> / 1024</span>
																							</div>
																							<div class="col-sm-6" style="margin-top: 5px; display: none;">
																								<span class="error_display variable_msg" style="display: none;">
																									[ Variables should be in this format {{ Numbers }} ]
																								</span>
																							</div>
																							<div class="col-sm-4" style="margin-top: 5px;display: none;">
																								<a href="#!" name="btn" type="button" id="btn" tabindex="12"
																									class="btn btn-success">
																									+ Add variable
																								</a>
																							</div>
																						</div>
																						<!-- TEXT area alert End -->
																					</div>
																				</div>
																			</div>
																		</div>

																		<!-- Upload Mobile Numbers  -->
																		<div class="form-group mb-2 row">
																			<label class="col-sm-3 col-form-label" style="padding-left: 50px;">
																				Upload Mobile Numbers
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
																						href="uploads/imports/compose_sms.csv" download=""
																						class="btn btn-success alert-ajax btn-outline-success" tabindex="8"><i
																							class="icofont icofont-download"></i> Sample CSV
																						File</a></label>
																				<label class="j-label dynamic_media_typ" style="display: none;"><a
																						href="uploads/imports/compose_sms_media.csv" download=""
																						class="btn btn-success alert-ajax btn-outline-success" tabindex="8"><i
																							class="icofont icofont-download"></i> Sample CSV
																						File</a></label>
																				<label class="j-label customized_message_typ" style="display: none;"><a
																						href="uploads/imports/compose_smss.csv" download=""
																						class="btn btn-success alert-ajax btn-outline-success" tabindex="7"><i
																							class="icofont icofont-download"></i> Sample CSV
																						File</a></label>
																				<div class="checkbox-fade fade-in-primary" id='id_mobupload'>
																				</div>
																			</div>
																		</div>


																		<!-- Select Group Name -->
																		<div class="form-group mb-2 row">
																			<label class="col-sm-3 col-form-label" style="padding-left: 50px;">
																				Select Group Name
																				<span data-toggle="tooltip"
																					data-original-title="Enter the text for your message in the language that you've selected.">[?]</span>
																			</label>
																			<div class="col-sm-7">
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
                                                        echo $data;?>
																				</select>

																			</div>
																		</div>

																		<!-- Select Group Name -->
																		<div class="form-group mb-2 row">
																			<label class="col-sm-3 col-form-label" style="padding-left: 50px;">
																				Enter Mobile Numbers
																				<span data-toggle="tooltip"
																					data-original-title="Enter the text for your message in the language that you've selected.">[?]</span>
																			</label>
																			<div class="col-sm-7">
																				<textarea id="mobile_numbers_txt" class="form-control" name="mobile_numbers_txt"
																					placeholder="Enter Mobile Numbers" onclick="call_remove_duplicate_invalid()"
																					value="" onblur="call_remove_duplicate_invalid()" tabindex="13"
																					data-toggle="tooltip" data-placement="top" title="Enter Mobile Numbers"
																					style="height: 150px; width: 100%; resize: none;"
																					onkeypress="return (event.charCode != 8 && event.charCode == 0 || (event.charCode == 44 || (event.charCode >= 48 && event.charCode <= 57)))"> </textarea>
																				<span class="invalid_msg" style="color:red"></span>
																			</div>
																		</div>


																	</div>
																	<div class="card-footer text-center">
																		<div class="text-center">
																			<span class="error_display" id='id_error_display' style="color:red;"></span>
																		</div>
																		<input type="hidden" name="filename_upload" id="filename_upload" value="">
																		<input type="hidden" name="total_mobilenos_count" id="total_mobilenos_count"
																			value="">
																		<input type="hidden" class="form-control" name='tmpl_call_function'
																			id='tmpl_call_function' value='compose_sms' />
																		<input type="button" onclick="myFunction_clear()" value="Clear"
																			class="btn btn-success submit_btn" id="clr_button" tabindex="9">
																		<input type="submit" name="compose_submit" id="compose_submit" tabindex="10"
																			value="Submit" class="btn btn-success submit_btn">
																		<input type="button" value="Preview Content" onclick="preview_content()"
																			data-toggle="modal" data-target="#previewModal" class="btn btn-success submit_btn"
																			id="pre_button" name="pre_button" tabindex="11">
																	</div>
																</form>
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
												<h4 class="modal-title">SMS Details</h4>
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
	$(document).ready(function() {
		call_remove_duplicate_invalid();
	});
	var invalid_mobile_nos;
	var mobile_array = [];
	var trimmedText;
	var valid_variable_values = [];
	var message_txt;
	// FORM Clear value    
	function myFunction_clear() {
		document.getElementById("frm_contact_group").reset();
		window.location.reload();
	}
	var used_numbers = []; // Track used numbers
	const textarea = document.getElementById('textarea');
	const btn = document.getElementById('btn');
	textarea.addEventListener('input', updateResult);
	textarea.value = '';
	btn.disabled = checkIfButtonShouldBeDisabled(); // Update button state on page load
	btn.addEventListener('click', function handleClick() {
		if (used_numbers.length < 10) {
			let missingNumber = getMissingNumber();
			if (missingNumber !== null) {
				insertVariable(missingNumber);
			}
		}
	});

	function insertVariable(number) {
		const startPos = textarea.selectionStart;
		const endPos = textarea.selectionEnd;
		const textBeforeCursor = textarea.value.substring(0, startPos);
		const textAfterCursor = textarea.value.substring(endPos);
		textarea.value = textBeforeCursor + '{{' + number + '}}' + textAfterCursor;
		textarea.setSelectionRange(textarea.value.length, textarea.value.length);
		textarea.focus();
		used_numbers.push(number);
		used_numbers.sort((a, b) => a - b); // Keep numbers sorted
		btn.disabled = checkIfButtonShouldBeDisabled();
	}

	function updateResult() {
		var t = textarea.value;
		var regex = /{{(\d+)}}/g;
		var matches = [...t.matchAll(regex)];
		let temp_numbers = matches.map(m => parseInt(m[1])); // Extract numbers inside {{}}
		// Filter valid numbers (1 to 10) and remove duplicates
		used_numbers = [...new Set(temp_numbers.filter(n => n >= 1 && n <= 10))].sort((a, b) => a - b);
		// Replace invalid or duplicate variables while keeping the rest of the text
		let cleanedText = t.replace(regex, (match, num) => {
			num = parseInt(num);
			return num >= 1 && num <= 10 && used_numbers.includes(num) ? `{{${num}}}` : ''; // Remove invalid
		});
		textarea.value = cleanedText; // Update textarea with cleaned text
		btn.disabled = checkIfButtonShouldBeDisabled();
	}

	function getMissingNumber() {
		for (let i = 1; i <= 10; i++) {
			if (!used_numbers.includes(i)) {
				return i; // Return the first missing number
			}
		}
		return null;
	}

	function checkIfButtonShouldBeDisabled() {
		return used_numbers.length >= 10;
	}


	document.body.addEventListener("click", function(evt) {
		//note evt.target can be a nested element, not the body element, resulting in misfires
		$("#id_error_display").html("");
	});

	function chooseFile() {
		document.getElementById('upload_contact').value = '';
	}
	document.getElementById('upload_contact').addEventListener('change', function() {
		validateFile();
	});

	function validateFile() {
		var textarea = document.getElementById('textarea');

		if (textarea.value.trim().length >= 2) {
			// var pattern = /{{(\w+)}}/g;
			// if (!pattern.test(textarea.value.trim())) {
			// 	console.log("Pattern not found in the text.");
			// 	$("#id_error_display").html("Variable count should not be zero because it is a customized message.");
			// 	document.getElementById('upload_contact').value = ''; // Clear the file input
			// 	return;
			// }
			$('#textarea').css('border-color', '#e4e6fc');
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
		} else {
			handleEmptyOrInvalidTextarea();
		}
	}

	function handleEmptyOrInvalidTextarea() {
		var textarea = document.getElementById('textarea');
		if (textarea.value.trim().length == '') {
			$('#textarea').css('border-color', 'red');
			$("#id_error_display").html("Enter the message content.");
		} else if (textarea.value.trim().length < 2) {
			$("#id_error_display").html('Message content should have at least 2 characters.');
			$('#textarea').css('border-color', 'red');
		}
		document.getElementById('upload_contact').value = ''; // Clear the file input
	}

	function validateNumber(number) {
		return /^91[6-9]\d{9}$/.test(number);
	}

	var copiedFile, file_location_path;
	var cleanedData = [];
	// validate mobile numbers
	function validateNumber(number) {
		return /^91[6-9]\d{9}$/.test(number);
	}
	//copy file
	function copyFile(file) {
		// Extract filename and extension
		var fileNameParts = file.name.split('.');
		var fileName = fileNameParts[0];
		var fileExtension = fileNameParts[1];
		// Append "_copy" to the filename
		var copiedFileName = fileName + "_copy." + fileExtension;
		// Create a new file with the copied filename
		var copiedFile = new File([file], copiedFileName, {
			type: file.type
		});
		// Return the copied file
		return copiedFile;
	}

	// read Files 
	function readFileContents(file, Media, DuplicateAllowed) {
		message_txt = textarea.value;
		var media_name = $("input[type='radio'][name='rdo_sameperson_video']:checked").val();
		var slt_whatsapp_template = $("#slt_whatsapp_template").val();
		cleanedData = [];
		$(".display_msg").css("display", "");
		$(".modal-footer").css("display", "");
		$('#img_display').removeAttr('src');
		$('.preloader-wrapper').show();
		var reader = new FileReader();
		reader.onload = function(event) {
			var contents = event.target.result;
			var workbook = XLSX.read(contents, {
				type: 'binary'
			});
			// Copy the file  
			copiedFile = copyFile(file);
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
				} else if (data[rowIndex].length == template_variable_count) {
					invalidValues.push(valueA);
				} else if (uniqueValuesInColumnA.has(valueA) && DuplicateAllowed === false && valueA != undefined) {
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
			} else if (((template_variable_count != '0') && template_variable_count != firstRowLength)) {
				$('.preloader-wrapper').hide();
				$('.loading_error_message').css("display", "none");
				$(".display_msg").css("display", "none");
				$(".modal-footer").css("display", "none");
				$('#upload_file_popup').modal('show');
				$('#img_display').attr('src', 'libraries/assets/png/failed.png');
				$('#file_response_msg').html('<b>Variable count mismatch. </b>');
				document.getElementById('upload_contact').value = '';
			} else if ((invalidValues.length + duplicateValuesInColumnA.length === totalCount)) {
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
			} else if ((Media == undefined && firstRowLength > 1 && !template_variable_count)) {
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

	$('#upload_file_popup').find('.btn-secondary').on('click', function() {
		$('#upload_contact').val('');
	});

	$("#textarea").keyup(function() {
		trimmedText = $(this).val().trim(); // Trim the input text
		$("#current_text_value").text(trimmedText.length); // Update the length of trimmed text
	});
	// FORM preview value
	function preview_content() {
		var form = $("#frm_contact_group")[0]; // Get the HTMLFormElement from the jQuery selector
		var txt_sms_mobno = $('input[name="txt_sms_mobno"]:checked').serialize()
		var data_serialize = $("#frm_contact_group").serialize();
		var fd = new FormData(form); // Use the form element in the FormData constructor
		var upload_contact = $('#upload_contact').text();
		fd.append('upload_contact', upload_contact);
		if (txt_sms_mobno == "") {} else {
			var mobile_split = txt_sms_mobno.split("&")
			for (var i = 0; i < mobile_split.length; i++) {
				var mobile_no_split = mobile_split[i].split("=")
				if (i == 0) {
					mobile_array = mobile_no_split[1]
				} else {
					mobile_array = mobile_array + "," + mobile_no_split[1]
				}
			}
		}
		fd.append('mobile_numbers', mobile_array);
		$.ajax({
			type: 'post',
			url: "ajax/preview_call_functions.php?preview_functions=preview_compose_sms",
			data: fd,
			processData: false, // Important: Prevent jQuery from processing the data
			contentType: false, // Important: Let the browser set the content type
			success: function(response) { // Success
				$("#id_modal_display").html(response);
				console.log(response.status);
				$('#default-Modal').modal({
					show: true
				}); // Open in a Modal Popup window
			},
			error: function(response, status, error) { // Error
				console.log("error");
				$("#id_modal_display").html(response.status);
				$('#default-Modal').modal({
					show: true
				});
			}
		});
	}
	// Define a flag to track whether the modal has been opened
	var modalOpened = false;

	$(document).on("submit", "form#frm_contact_group", function(e) {
		e.preventDefault();
		$('#compose_submit').prop('disabled', false);
		$("#id_error_display").html("");
		$('#textarea').css('border-color', '#a0a0a0');
		$('#upload_contact').css('border-color', '#a0a0a0');
		//get input field values 
		var textarea = $('#textarea').val();
		textarea = textarea.trim();
		var upload_contact = $('#upload_contact').val();
		var txt_sms_mobno = $('input[name="txt_sms_mobno"]:checked').serialize();
		var flag = true;

		var mobile_array = "";

		/********validate all our form fields***********/
		/* textarea field validation  */
		if (textarea == "") {
			$('#textarea').css('border-color', 'red');
			flag = false;
		} else if (textarea.length < 2) {
			// Show error message
			$("#id_error_display").html('Message content should have atleast 2 characters .');
			$('#textarea').css('border-color', 'red');
			flag = false;
		}

		if (($('#upload_contact').val() === "") && ($('#mobile_numbers_txt').val().trim()) === "" && ($(
				'#contact_mgtgrp_id').val() === "")) {
			$('#upload_contact, #mobile_numbers_txt, #contact_mgtgrp_id').css('border-color', 'red');
			errorMessages.push('Please upload a file (CSV or TXT).');
			flag = false;
		}

		var txt_sms_mobno = $('input[name="txt_sms_mobno"]:checked').serialize();
		var txt_qr_mobno = $("input[type='radio'][name='txt_qr_mobno']:checked").val();
		var mobile_split = txt_sms_mobno.split("&")
		for (var i = 0; i < mobile_split.length; i++) {
			var mobile_no_split = mobile_split[i].split("=")
			if (i == 0) {
				mobile_array = mobile_no_split[1]
			} else {
				mobile_array = mobile_array + "," + mobile_no_split[1]
			}
		}
		if (flag) {
			let character_count = textarea.length


			// Process selected mobile numbers
			var mobile_array = $('input[name="txt_sms_mobno"]:checked').serialize()
				.split("&")
				.map(pair => pair.split("=")[1])
				.join(",");
			if ($('#mobile_numbers_txt').val().trim().length > 0) {
				NumbersToFile();
			}
			var fd = new FormData(this);
			fd.append('mobile_numbers', valid_variable_values.length);
			fd.append('character_count', character_count);
			$.ajax({
				type: 'post',
				url: "ajax/message_call_functions.php",
				dataType: 'json',
				data: fd,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$('#compose_submit').attr('disabled', true);
					$('.theme-loader').show();
				},
				complete: function() {
					$('#compose_submit').attr('disabled', false);
					$('.theme-loader').hide();
				},
				success: function(response) {
					$('#image_display').removeAttr('src');
					if (response.status == 0) {
						$('#textarea').val('');
						$('#frm_contact_group').removeClass('was-validated');
						$('#upload_contact').val('');
						$('#compose_submit').attr('disabled', false);
						$('#image_display').attr('src', 'libraries/assets/png/failed.png');
						$('#campaign_compose_message').modal({
							show: true
						});
						$("#message").html(response.msg);
					} else if (response.status == 2) {
						$('#frm_contact_group').removeClass('was-validated');
						$('#compose_submit').attr('disabled', false);
						$('#compose_submit').attr('disabled', false);
						$('#image_display').attr('src', 'libraries/assets/png/failed.png');
						$('#campaign_compose_message').modal({
							show: true
						});
						$("#message").html(response.msg);
					} else if (response.status == 1) {
						$('#textarea').val('');
						$('#upload_contact').val('');
						$('#frm_contact_group').removeClass('was-validated');
						$('#campaign_compose_message').modal({
							show: true
						});
						$('#image_display').attr('src', 'libraries/assets/png/success.png');
						$("#message").html("Campign Created Successfully");
						setInterval(function() {
							window.location = 'compose_sms_list';
							document.getElementById("frm_contact_group").reset();
						}, 2000);
					}
					$('.theme-loader').hide();
				},
				error: function(response, status, error) {
					$('#textarea').val('');
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

	$("#upload_contact").change(function() { //csv
		if (this.files[0] == '') {
			var file = this.files[0];
			var fileType = file.type;
			var match = ['text/csv'];
			if (!((fileType == match[0]) || (fileType == match[1]) || (fileType == match[2]) || (fileType == match[3]) || (
					fileType == match[4]) || (fileType == match[5]))) {
				$("#id_error_display").html('Sorry, only CSV file are allowed to upload.');
				$("#upload_contact").val('');
				return false;
			}
		}
	});


	$('#upload_file_popup').find('.save_compose_file').on('click', function() {
		csvfile();
	});

	function csvfile() {
		var fd = new FormData();
		fd.append('copiedFile', copiedFile);
		$.ajax({
			type: 'post',
			url: "ajax/whatsapp_call_functions.php?storecopy_file=copy_file",
			dataType: 'json',
			data: fd,
			contentType: false,
			processData: false,
			beforeSend: function() {
				$('.updateprocessing').show();
			},
			complete: function() {
				$('.updateprocessing').hide();
				$('.loading_error_message').css("display", "none");
			},
			success: function(response) {
				if (response.status == '0') {
					console.log("File Not copied ...failed");
					// console.log(response.msg);
				} else {
					file_location_path = response.file_location;
					console.log("File copied Successfully");
					const productValuesArrays = cleanedData.map(obj => Object.values(obj));
					const csvContent = productValuesArrays.map(row => row.join(",")).join("\n");
					var fileName = file_location_path.substring(file_location_path.lastIndexOf('/') + 1);
					document.getElementById('filename_upload').value = fileName;
					const blob = new Blob([csvContent], {
						type: 'text/csv;charset=utf-8;'
					});
					const formData = new FormData();
					formData.append('valid_numbers', blob);
					formData.append('filename', fileName);
					$.ajax({
						type: 'POST',
						url: 'csvfile_write.php',
						data: formData,
						contentType: false,
						processData: false,
						success: function(response) {
							console.log('File written successfully');
						},
						error: function(xhr, status, error) {
							console.error('Error occurred while writing the file:', error);
						}
					});
				}
			}
		});
	}

	var dup, inv, DuplicateAllowed = false;

	function call_remove_duplicate_invalid() {
		inv = 1; // Define or assign the variable inv
		dup = dup ? dup : 0; // Set dup to its current value if defined, otherwise set it to 0

		var txt_list_mobno = $('#mobile_numbers_txt').val();
		var mobno = txt_list_mobno.replace(/\n/g, ',');
		var newline = mobno.split('\n');
		var correct_mobno_data = [];
		var return_mobno_data = '';
		var issu_mob = '';
		var cnt_vld_no = 0;
		var max_vld_no = 2000000;

		for (var i = 0; i < newline.length; i++) {
			var expl = newline[i].split(',');
			for (var ij = 0; ij < expl.length; ij++) {
				var vlno;
				if (inv === 1) {
					vlno = validateNumber(expl[ij]);
				} else {
					vlno = newline[i];
				}

				if (vlno === true) {
					if (dup === 1 || correct_mobno_data.indexOf(expl[ij]) === -1) {
						if (expl[ij] !== '') {
							cnt_vld_no++;
							if (cnt_vld_no <= max_vld_no) {
								correct_mobno_data.push(expl[ij]);
								return_mobno_data += expl[ij] + ',\n';
							} else {
								issu_mob += expl[ij] + ',';
							}
						} else {
							issu_mob += expl[ij] + ',';
						}
					} else {
						issu_mob += expl[ij] + ',';
					}
				} else {
					issu_mob += expl[ij] + ',';
				}
			}
		}
		// Output the results as needed
		$('#mobile_numbers_txt').val(return_mobno_data);
		var txt_list_mobno = $('#mobile_numbers_txt').val();
		var mobileNumbersArray = txt_list_mobno.split(',').filter(function(number) {
			return number.trim() !== ''; // Remove empty values after trimming whitespace
		});
		console.log(mobileNumbersArray.length);
		document.getElementById('total_mobilenos_count').value = mobileNumbersArray.length;
		$('.invalid_msg').html('Invalid Mobile Nos: ' + issu_mob);
	}

	$('#textarea').on('input', function(event) {
		var inputValue = $(this).val();
		if (inputValue.includes('`') || inputValue.includes("'") || inputValue.includes('"')) {
			inputValue = inputValue.replace(/[`'"]/g, '');
			$(this).val(inputValue);
		}
	});



	function NumbersToFile() {
		const mobile_numbers_txt = $("#mobile_numbers_txt").val().split('\n').map(line => line.trim().split(','));
		const smppUserId = <?php echo isset($_SESSION['smpp_user_id']) ? $_SESSION['smpp_user_id'] : '""'; ?>;
		const milliseconds = new Date().getTime();
		const currentDate = new Date().toISOString().replace(/[^\d]/g, '').slice(0, 14);
		const fileName = `${smppUserId}_${milliseconds}_${currentDate}.csv`;
		const csvContent = mobile_numbers_txt
			.map(row => row.filter(cell => cell !== "").join(
			",")) // Remove empty cells from each row before joining with commas
			.join("\n"); // Join rows with newlines
		document.getElementById('filename_upload').value = fileName;
		// Create a Blob from the CSV content
		const blob = new Blob([csvContent], {
			type: 'text/csv;charset=utf-8;'
		});

		// Create FormData and append Blob and filename
		const formData = new FormData();
		formData.append('valid_numbers', blob);
		formData.append('filename', fileName);

		// Send data via AJAX
		$.ajax({
			type: 'POST',
			url: 'csvfile_write.php',
			data: formData,
			contentType: false,
			processData: false,
			success: function(response) {
				console.log('File written successfully');
			},
			error: function(xhr, status, error) {
				console.error('Error occurred while writing the file:', error);
			}
		});
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