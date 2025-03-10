<?php
session_start(); // start session
error_reporting(0); // The error reporting function
include_once 'api/configuration.php'; // Include configuration.php
include_once('api/send_request.php');

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
	<title>Import Contacts ::
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
											<h5>Import Contacts</h5>
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
											<li class="breadcrumb-item"><a href="message_credit">Import Contacts</a>
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
																<form class="needs-validation" novalidate="" id="frm_message_credit"
																	name="frm_message_credit" action="#" method="post" enctype="multipart/form-data">
																	<div class="card-body">


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

																		<!--  Upload Mobile Numbers-->
																		<div class="form-group mb-2 row">
																			<label class="col-sm-4 col-form-label"> Upload Mobile Numbers <span
																					style="color: #FF0000;">*</span>
																				<span data-toggle="tooltip"
																					data-original-title="Upload the Contact Downloaded CSV File Here or Enter contact Name">[?]</span></label>
																			<div class="col-sm-8">
																				<input type="file" class="input-block-level" style="height:50px;"
																					name="upload_contact" id='upload_contact' tabindex="6" onclick="chooseFile()"
																					accept=".csv, .txt" data-placement="top" data-html="true"
																					title="Upload the Contacts via CSV or TXT Files">
																				<label class="j-label same_message_typ"><a
																						href="uploads/imports/compose_smpp.csv" download=""
																						class="btn btn-primary btn-md alert-ajax " tabindex="8"><i
																							class="icofont icofont-download"></i> Sample CSV
																						File</a></label>
																				<label class="j-label dynamic_media_typ" style="display: none;"><a
																						href="uploads/imports/compose_smpp_media.csv" download=""
																						class="btn btn-primary btn-md alert-ajax " tabindex="8"><i
																							class="icofont icofont-download"></i> Sample CSV
																						File</a></label>
																				<label class="j-label customized_message_typ" style="display: none;"><a
																						href="uploads/imports/compose_smpps.csv" download=""
																						class="btn btn-primary btn-md alert-ajax " tabindex="7"><i
																							class="icofont icofont-download"></i> Sample CSV
																						File</a></label>

																				<label style="color:#FF0000">[Upload the Contacts via CSV or TXT Files
																					Only]</label>
																			</div>
																		</div>

																		<span class="error_display" id='id_count_display' style="color: red;"></span>
																		<!-- Message Count and Error display -->
																		<div class="card-footer text-center">
																			<input type="submit" name="submit" id="submit" value="Submit"
																				class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20"
																				style="width:150px;">
																			<input type="hidden" name="filename_upload" id="filename_upload" value="">
																			<input type="hidden" name="total_mobilenos_count" id="total_mobilenos_count"
																				value="">
																			<input type="hidden" class="input-block-level" name='tmpl_call_function'
																				id='tmpl_call_function' value='import_contact' />
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
							<!-- Confirmation details content-->
							<div class="modal" tabindex="-1" role="dialog" id="upload_file_popup">
								<div class="modal-dialog" role="document">
									<div class="modal-content" style="width: 400px;">
										<div class="modal-body">
											<button type="button" class="close" data-dismiss="modal" style="width:30px" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
											<p id="file_response_msg"></p>
											<span class="ex_msg">Are you sure you want to Upload a File?</span>
										</div>
										<div class="modal-footer">
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
	function chooseFile() {
		console.log("Choose File")
		document.getElementById('upload_contact').value = '';
	}
	document.getElementById('upload_contact').addEventListener('change', function() {
		validateFile();
	});

	function validateFile() {
		console.log("Validate file")
		var group_avail = $("input[type='radio'][name='rdo_newex_group']:checked").val();

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

	function validateNumber(number) {
		console.log("Validate number")
		return /^[6-9]\d{9}$/.test(number);
	}

	var copiedFile, file_location_path;
	var cleanedData = [];

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
		var copiedFile = new File([file], copiedFileName, {
			type: file.type
		});
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
		reader.onload = function(event) {
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

	$('#upload_file_popup').find('.btn-secondary').on('click', function() {
		$('#upload_contact').val('');
	});

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
				data: {
					validateMobno: 'validateMobno',
					dup: chk_remove_duplicates,
					inv: chk_remove_invalids
				},
				success: function(response) { // Success
					if (response.status == 1) {
						let response_msg_text = response.msg;
						const response_msg_split = response_msg_text.split("||");
						if (response_msg_split[1] != '') {
							invalid_mobile_nos = "Invalid Mobile Nos : " + response_msg_split[1] +
								"This Mobile Numbers Are Invalid Mobile Numbers.Are You Sure The Compose sms ?";
						}
						if (chk_remove_stop_status == 1) {}
					} else {
						$("#id_error_display").html(response.msg).css('color', 'red');
					}
				},
				error: function(response, status, error) { // Error
				}
			});
		}
	}

	$("#upload_contact").change(function() { //csv
		if (this.files[0] == '') {
			var file = this.files[0];
			var fileType = file.type;
			var match = ['text/csv'];
			if (!((fileType == match[0]) || (fileType == match[1]) || (fileType == match[2]) || (fileType == match[
					3]) || (fileType == match[4]) || (fileType == match[5]))) {
				$("#id_error_display").html('Sorry, only CSV file are allowed to upload.');
				$("#upload_contact").val('');
				return false;
			}
		}
	});
	$(document).on("submit", "form#frm_attachments", function(e) {
		e.preventDefault();
		$("#id_error_display").html("");
		$('#upload_contact').css('border-color', '#a0a0a0');

		var upload_contact = $('#upload_contact').val();
		var flag = true;

		// Validate the file input
		if (upload_contact === "") {
			$('#upload_contact').css('border-color', 'red');
			$("#id_error_display").html("Please upload a file.");
			flag = false;
		}

		if ($('#contact_mgtgrp_id').val() === "") {
			$('#contact_mgtgrp_id').css('border-color', 'red');
			$("#id_error_display").html('Please select a Group Name.');
			flag = false;
		}

		// If validation passes, send AJAX request
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
					$('#load_page').show();
				},
				complete: function() {
					$('#submit').attr('disabled', false);
					$('#load_page').hide();
				},
				success: function(response) {
					$('#image_display').attr('src',
						`libraries/assets/png/${response.status === 1 ? 'success' : 'failed'}.png`);
					$("#message").html(response.msg || "Unexpected error.");
					$('#campaign_compose_message').modal('show');
					$('#submit').prop('disabled', response.status === 1);

					if (response.status === 1) {
						setTimeout(() => window.location = "contact_list", 2000);
					}
				},
				error: function(response) {
					$('#submit').prop('disabled', false);
				}
			});
		}
	});

	// File type validation
	$("#upload_contact").change(function() {
		// xls, xlsx, csv, txt
		var file = this.files[0];
		var fileType = file.type;
		var match = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
			'application/vnd.ms-excel',
			'text/csv', 'text/plain'
		];
		if (!((fileType == match[0]) || (fileType == match[1]) || (fileType == match[2]) || (fileType == match[
				3]) || (
				fileType == match[4]) || (fileType == match[5]))) {
			$("#id_error_display").html('Sorry, only XLS, CSV, TXT files are allowed to upload.');
			$("#upload_contact").val('');
			return false;
		}
	});

	$(".alert-ajax").click(function() {
		$("#id_modal_display").load("uploads/imports/import_content.htm", function() {
			$('#default-Modal').modal({
				show: true
			});
		});
	});


	$('#upload_file_popup').find('.save_compose_file').on('click', function() {
		csvfile();
	});

	function csvfile() {
		console.log("csvfile")
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
					const blob = new Blob([csvContent], {
						type: 'text/csv;charset=utf-8;'
					});
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