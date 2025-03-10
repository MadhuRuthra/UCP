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
    <title>Compose Whatsapp ::
        <?= htmlspecialchars($site_title, ENT_QUOTES, 'UTF-8') ?>
    </title>
    <link rel="icon" href="libraries/assets/png/favicon1.ico" type="image/x-icon">

    <!-- <link rel="icon" href="libraries/assets/png/favicon1.ico" type="image/x-icon"> -->

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
<style>
.dropdown-select {
    background-image: linear-gradient(to bottom, rgba(255, 255, 255, 0.25) 0%, rgba(255, 255, 255, 0) 100%);
    background-repeat: repeat-x;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#40FFFFFF', endColorstr='#00FFFFFF', GradientType=0);
    background-color: #fff;
    border-radius: 6px;
    border: solid 1px #eee;
    box-shadow: 0px 2px 5px 0px rgba(155, 155, 155, 0.5);
    box-sizing: border-box;
    cursor: pointer;
    display: block;
    float: left;
    font-size: 14px;
    font-weight: normal;
    height: 42px;
    line-height: 40px;
    outline: none;
    padding-left: 18px;
    padding-right: 30px;
    position: relative;
    text-align: left !important;
    transition: all 0.2s ease-in-out;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    white-space: nowrap;
    width: auto;

}

.dropdown-select:focus {
    background-color: #fff;
}

.dropdown-select:hover {
    background-color: #fff;
}

.dropdown-select:active,
.dropdown-select.open {
    background-color: #fff !important;
    border-color: #bbb;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05) inset;
}

.dropdown-select:after {
    height: 0;
    width: 0;
    border-left: 4px solid transparent;
    border-right: 4px solid transparent;
    border-top: 4px solid #777;
    -webkit-transform: origin(50% 20%);
    transform: origin(50% 20%);
    transition: all 0.125s ease-in-out;
    content: '';
    display: block;
    margin-top: -2px;
    pointer-events: none;
    position: absolute;
    right: 10px;
    top: 50%;
}

.dropdown-select.open:after {
    -webkit-transform: rotate(-180deg);
    transform: rotate(-180deg);
}

.dropdown-select.open .list {
    -webkit-transform: scale(1);
    transform: scale(1);
    opacity: 1;
    pointer-events: auto;
}

.dropdown-select.open .option {
    cursor: pointer;
}

.dropdown-select.wide {
    width: 100%;
}

.dropdown-select.wide .list {
    left: 0 !important;
    right: 0 !important;
}

.dropdown-select .list {
    box-sizing: border-box;
    transition: all 0.15s cubic-bezier(0.25, 0, 0.25, 1.75), opacity 0.1s linear;
    -webkit-transform: scale(0.75);
    transform: scale(0.75);
    -webkit-transform-origin: 50% 0;
    transform-origin: 50% 0;
    box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.09);
    background-color: #fff;
    border-radius: 6px;
    margin-top: 4px;
    padding: 3px 0;
    opacity: 0;
    overflow: hidden;
    pointer-events: none;
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 999;
    max-height: 250px;
    overflow: auto;
    border: 1px solid #ddd;
}

.dropdown-select .list:hover .option:not(:hover) {
    background-color: transparent !important;
}

.dropdown-select .dd-search {
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0.5rem;
}

.dropdown-select .dd-searchbox {
    width: 100%;
    height: 50px;
    padding: 0.5rem;
    border: 1px solid #999;
    border-color: #999;
    border-radius: 4px;
    outline: none;
}

.dropdown-select .dd-searchbox:focus {
    border-color: #12CBC4;
}

.dropdown-select .list ul {
    padding: 0;
}

.dropdown-select .option {
    cursor: default;
    font-weight: 400;
    line-height: 40px;
    outline: none;
    padding-left: 18px;
    padding-right: 29px;
    text-align: left;
    transition: all 0.2s;
    list-style: none;
}

.dropdown-select .option:hover,
.dropdown-select .option:focus {
    background-color: #f6f6f6 !important;
}

.dropdown-select .option.selected {
    font-weight: 600;
    color: #12cbc4;
}

.dropdown-select .option.selected:focus {
    background: #f6f6f6;
}

.dropdown-select a {
    color: #aaa;
    text-decoration: none;
    transition: all 0.2s ease-in-out;
}

.dropdown-select a:hover {
    color: #666;
}
</style>

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
                    <?php
          include("libraries/site_menu.php"); ?>

                    <div class="pcoded-content">

                        <div class="page-header card">
                            <div class="row align-items-end">
                                <div class="col-lg-8">
                                    <div class="page-header-title">
                                        <i class="feather icon-clipboard bg-c-blue"></i>
                                        <div class="d-inline">
                                            <h5>Compose Whatsapp</h5>
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
                                                <a href="compose_whatsapp">Compose Whatsapp</a>
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
                                                                <form class="needs-validation" novalidate=""
                                                                    id="frm_contact_group" name="frm_contact_group"
                                                                    action="#" method="post"
                                                                    enctype="multipart/form-data">
                                                                    <div class="card-body">

                                                                        <div class="form-group mb-4 row">
                                                                            <label
                                                                                class="col-sm-3 col-form-label">Select
                                                                                Whatsapp Template <label
                                                                                    style="color:#FF0000">*</label></label>
                                                                            <div class="col-sm-7">

                                                                                <select name="slt_whatsapp_template"
                                                                                    id='slt_whatsapp_template'
                                                                                    class="form-control"
                                                                                    style="display:none;"
                                                                                    data-toggle="tooltip"
                                                                                    data-placement="top" title=""
                                                                                    onchange="func_template_senderid();"
                                                                                    onfocus="func_template_senderid()"
                                                                                    data-original-title="Select Whatsapp Template"
                                                                                    tabindex="1" autofocus required="">
                                                                                    <option value="" selected
                                                                                        style="text-align:center;">
                                                                                        Choose
                                                                                        Whatsapp Template</option>

                                                                                    <? // To using the select template 
                                                               $load_templates = '{
                                                                     "user_id" : "' . $_SESSION['yjucp_user_id'] . '"
                                                                                  }';// Add user id

                           	                                     // Call the reusable cURL function
			                                                     $response = executeCurlRequest($api_url . "/whsp_process/get_template", "GET", $load_templates);
			                                                       // After got response decode the JSON result
			                                                        if (empty($response)) {
				                                                          // Redirect to index.php if response is empty
				                                                                header("Location: index");
				                                                                exit(); // Stop further execution after redirect
			                                                             }
                                                              $state1 = json_decode($response, false);
                                                                 // After got response decode the JSON result
                                                                  if ($state1->response_code == 1) {
                                                                      for ($indicator = 0; $indicator < count($state1->templates); $indicator++) { // Set the response details into Option ?>
                                                                                    <option
                                                                                        value="<?= $state1->templates[$indicator]->template_name ?>!<?= $state1->templates[$indicator]->language_code ?>!<?= $state1->templates[$indicator]->body_variable_count ?>!<?= $state1->templates[$indicator]->template_id ?>">
                                                                                        <?= $state1->templates[$indicator]->template_name ?>[<?= $state1->templates[$indicator]->language_code ?>]
                                                                                    </option>
                                                                                    <? }
                                                                        } else if ($state1->response_status == 403 || $response == '') {
                                                                          header("Location: index");
                                                                               }?>
                                                                                    </table>
                                                                                </select>

                                                                            </div>
                                                                            <div class="col-sm-2">
                                                                            </div>
                                                                        </div>

                                                                        <!-- Whatsapp Sender ID -->
                                                                        <div class="form-group mb-2 row">
                                                                            <label
                                                                                class="col-sm-3 col-form-label">Whatsapp
                                                                                Sender ID <label
                                                                                    style="color:#FF0000">*</label>
                                                                                <span data-toggle="tooltip"
                                                                                    data-original-title="Avl. Credits - Available Credits">[?]</span></label>
                                                                            <div class="col-sm-7">
                                                                                <div id='id_own_senderid'>

                                                                                </div>

                                                                            </div>
                                                                            <div class="col-sm-2">
                                                                            </div>
                                                                        </div>
                                                                        <!-- Upload Mobile Numbers  -->
                                                                        <div class="form-group mb-2 row">
                                                                            <label class="col-sm-3 col-form-label">
                                                                                Upload Mobile Numbers
                                                                                <span data-toggle="tooltip"
                                                                                    data-original-title="Upload the Contact Downloaded CSV File Here or Enter contact Name">[?]</span>
                                                                            </label>
                                                                            <div class="col-sm-7">
                                                                                <input type="file" class="form-control"
                                                                                    name="upload_contact"
                                                                                    id='upload_contact' tabindex="6"
                                                                                    onclick="chooseFile();call_remove_duplicate_invalid()"
                                                                                    accept=".csv, .txt"
                                                                                    data-placement="top"
                                                                                    data-html="true"
                                                                                    title="Upload the Contacts Mobile Number via CSV Files">
                                                                                <label style="color:#FF0000">[Upload the
                                                                                    Mobile Number via CSV/TXT Files
                                                                                    Only]</label>
                                                                            </div>
                                                                            <div class="col-sm-2">

                                                                                <label
                                                                                    class="j-label same_message_typ"><a
                                                                                        href="uploads/imports/compose_whatsapp.csv"
                                                                                        download=""
                                                                                        class="btn btn-success alert-ajax btn-outline-success"
                                                                                        tabindex="8"><i
                                                                                            class="icofont icofont-download"></i>
                                                                                        Sample CSV
                                                                                        File</a></label>
                                                                                <label class="j-label dynamic_media_typ"
                                                                                    style="display: none;"><a
                                                                                        href="uploads/imports/compose_sms_media.csv"
                                                                                        download=""
                                                                                        class="btn btn-success alert-ajax btn-outline-success"
                                                                                        tabindex="8"><i
                                                                                            class="icofont icofont-download"></i>
                                                                                        Sample CSV
                                                                                        File</a></label>
                                                                                <label
                                                                                    class="j-label customized_message_typ"
                                                                                    style="display: none;"><a
                                                                                        href="uploads/imports/compose_smss.csv"
                                                                                        download=""
                                                                                        class="btn btn-success alert-ajax btn-outline-success"
                                                                                        tabindex="7"><i
                                                                                            class="icofont icofont-download"></i>
                                                                                        Sample CSV
                                                                                        File</a></label>
                                                                                <div class="checkbox-fade fade-in-primary"
                                                                                    id='id_mobupload'>
                                                                                </div>
                                                                            </div>
                                                                        </div>


																		<!-- Select Group Name -->
																		<div class="form-group mb-2 row">
																			<label class="col-sm-3 col-form-label" >
																				Select Group Name
																				<span data-toggle="tooltip"
																					data-original-title="Enter the text for your message in the language that you've selected.">[?]</span>
																			</label>
																			<div class="col-sm-7">
																				<select name="contact_mgtgrp_id" id="contact_mgtgrp_id" class="form-control" style="display:none"
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
																			<label class="col-sm-3 col-form-label" >
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

<!-- To upload the Customized Template -->
                      <div class="form-group mb-2 row">
                        <label class="col-sm-3 col-form-label">&nbsp;</label>
                        <div class="col-sm-7">
                          <div style="clear: both; word-wrap: break-word; word-break: break-word;" id="slt_whatsapp_template_single"></div>
                          <input type="hidden" id="txt_sms_content" name="txt_sms_content">

                          <div id="id_show_variable_csv" style="clear: both; display: none">
                            <label class="error_display"><b>Customized Template</b></label>
                            <input type="file" class="form-control" name="fle_variable_csv" id='fle_variable_csv'
                              accept="text/csv" data-toggle="tooltip" data-placement="top" data-html="true" title=""
                              data-original-title="Upload the Mobile Numbers via CSV Files" tabindex="8">
                            <input type="hidden" id="txt_variable_count" name="txt_variable_count" value="0">
                            <label class="j-label mt-1"><a href="uploads/imports/sample_variables.csv" download
                                class="btn btn-info alert-ajax btn-outline-info"><i class="fas fa-download"></i>
                                Download Sample CSV File</a></label>
                          </div>
                        </div>
                        <div class="col-sm-2">
                        </div>
                      </div>                    
                                                </div>
                                                                    <div class="card-footer text-center">
                                                                        <div class="text-center">
                                                                            <span class="error_display"
                                                                                id='id_error_display'
                                                                                style="color: red;"></span>
                                                                        </div>
                                                                        <input type='hidden' name="id_slt_mobileno" id="id_slt_mobileno"
                                                                        value="<?= $whatsapp_bearer_token ?>||<?= $whatsapp_tmpl_url ?>||0||<?= $whatsapp_tmplsend_url ?>" />
                                                                        <input type="hidden" name="filename_upload"
                                                                            id="filename_upload" value="">
                                                                        <input type="hidden"
                                                                            name="total_mobilenos_count"
                                                                            id="total_mobilenos_count" value="">
                                                                        <input type="hidden" class="form-control"
                                                                            name='tmpl_call_function'
                                                                            id='tmpl_call_function'
                                                                            value='compose_whatsapp' />
                                                                        <input type="button"
                                                                            onclick="myFunction_clear()" value="Clear"
                                                                            class="btn btn-success submit_btn"
                                                                            id="clr_button" tabindex="9">
                                                                        <input type="submit" name="compose_submit"
                                                                            id="compose_submit" tabindex="10"
                                                                            value="Submit"
                                                                            class="btn btn-success submit_btn">
                                                                        <!---<input type="button" value="Preview Content"
                                                                            onclick="preview_content()"
                                                                            data-toggle="modal"
                                                                            data-target="#previewModal"
                                                                            class="btn btn-success submit_btn"
                                                                            id="pre_button" name="pre_button"
                                                                            tabindex="11">--->
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
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body" id="id_modal_display"
                                                style=" word-wrap: break-word; word-break: break-word;">
                                                <h5>No Data Available</h5>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-success waves-effect "
                                                    data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Confirmation details content-->
                                <div class="modal" tabindex="-1" role="dialog" id="upload_file_popup">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content" style="width: 400px;">
                                            <div class="modal-body">
                                                <button type="button" class="close" data-dismiss="modal"
                                                    style="width:30px" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                <p id="file_response_msg"></p>
                                                <span class="ex_msg">Are you sure you want to create a campaign?</span>
                                            </div>
                                            <div class="modal-footer" style="margin-right:30%;">
                                                <button type="button" class="btn btn-danger save_compose_file"
                                                    data-dismiss="modal">Yes</button>
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">No</button>
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
                                        <button type="button" class="close" data-dismiss="modal" style="width:30px"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <div class="container" style="text-align: center;">
                                            <img alt="image"
                                                style="width: 50px; height: 50px; display: block; margin: 0 auto;"
                                                id="image_display">
                                            <br>
                                            <span id="message"></span>
                                        </div>
                                    </div>
                                    <div class="modal-footer" style="margin-right:40%; text-align: center;">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Okay</button>
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

    <script src="libraries/assets/js/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
    <script src="libraries/assets/js/dropdown.js"></script>

    <script>


    $(document).ready(function() {
        create_custom_dropdowns();
        call_remove_duplicate_invalid()
    });


    // Initialize modal with the backdrop option to allow dismissal by clicking outside

    var invalid_mobile_nos;
    var mobile_array = [];
    var trimmedText;
    var valid_variable_values = [];
    // FORM Clear value    
    function myFunction_clear() {
        document.getElementById("frm_contact_group").reset();
        window.location.reload();
    }

    document.body.addEventListener("click", function(evt) {
        //note evt.target can be a nested element, not the body element, resulting in misfires
        $("#id_error_display").html("");
        $("#file_image_header").prop('disabled', false);
        $("#file_image_header_url").prop('disabled', false);
    });

    function chooseFile() {
        document.getElementById('upload_contact').value = '';
    }
    document.getElementById('upload_contact').addEventListener('change', function() {
        validateFile();
    });

    function validateFile() {
        var group_avail = $("input[type='radio'][name='rdo_newex_group']:checked").val();
        var input = document.getElementById('upload_contact');
        var file = input.files[0];
        var allowedExtensions = /\.(csv|txt)$/i;
        var maxSizeInBytes = 100 * 1024 * 1024; // 100MB
        if (!allowedExtensions.test(file.name)) {
            $("#id_error_display").html("Invalid file type. Please select an .csv file.");
            document.getElementById('upload_contact').value = ''; // Clear the file input
        } else if (file.size > maxSizeInBytes) {
            $("#id_error_display").html("File size exceeds the maximum limit (100MB).");
            document.getElementById('upload_contact').value = ''; // Clear the file input
        } else {
            $("#id_error_display").html(""); // Clear any previous error message
            readFileContents(file);
        }
    }

    function validateNumber(number) {
        return /^[6-9]\d{9}$/.test(number);
    }

    var copiedFile, file_location_path;
    var cleanedData = [];
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
        // message_txt = textarea.value;
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
            document.getElementById('total_mobilenos_count').value = validCount;
            var totalCount = data.length;

            var selectedValue = $('input[name="duplicate_value"]:checked').val();
            if (selectedValue === 'duplicate_allowed') {
                document.getElementById('total_mobilenos_count').value = validCount;
            } else {
                var valid_no = validCount - duplicateValuesInColumnA.length;
                document.getElementById('total_mobilenos_count').value = valid_no;
            }
            // Initialize modal with the backdrop option to allow dismissal by clicking outside
            $('#upload_file_popup').modal({
                backdrop: 'static',
                keyboard: true
            });
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
                $('.preloader-wrapper').hide();
                $('.loading_error_message').css("display", "none");
                $('#file_response_msg').html('<b>Validating Successfully.</b>');
            }
        }
        reader.readAsBinaryString(file);
    }

    // Event listener for when the modal is hidden
    $('#upload_file_popup').on('hidden.bs.modal', function() {
        // Programmatically trigger the "Yes" button action
        $('.save_compose_file').trigger('click');
    });

    // Action for the "Yes" button
    $('#upload_file_popup').find('.save_compose_file').on('click', function() {
        console.log('Yes button clicked or modal dismissed.');
        // Perform the "OK" action here
    });
    // Action for the "No" button
    $('#upload_file_popup').find('.btn-secondary').on('click', function() {
        console.log('No button clicked.');
        $('#upload_contact').val('');
    });

    // FORM preview value
    function preview_content() {
        var form = $("#frm_contact_group")[0]; // Get the HTMLFormElement from the jQuery selector
        var txt_sms_mobno = $('input[name="txt_sms_mobno"]:checked').serialize()
        var data_serialize = $("#frm_contact_group").serialize();
        var group_avail = $("input[type='radio'][name='rdo_newex_group']:checked").val();
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
                console.log("Response", response);
                console.log("Pretty Response:", JSON.stringify(response, null, 2));
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

    // Define a flag to track whether the modal has been opened
    var modalOpened = false;

    $(document).on("submit", "form#frm_contact_group", function(e) {
        e.preventDefault();
        $('#compose_submit').prop('disabled', false);
        $("#id_error_display").html("");
        $('#slt_group').css('border-color', '#a0a0a0');
        $('#upload_contact').css('border-color', '#a0a0a0');
        $('#file_image_header').css('border-color', '#a0a0a0');
        var slt_group = $('#slt_group').val();
        var upload_contact = $('#upload_contact').val();
        var group_avail = $("input[type='radio'][name='rdo_newex_group']:checked").val();
        var txt_sms_mobno = $('input[name="txt_sms_mobno"]:checked').serialize();
        var file_image_header = $('#file_image_header').val();
        var file_image_header_url = $('#file_image_header_url').val();
        var media = $("input[type='radio'][name='rdo_sameperson_video']:checked").val();
        var flag = true;
        var errorMessages = [];
        var mobile_array = "";

		if (($('#upload_contact').val() === "") && ($('#mobile_numbers_txt').val().trim()) === "" && ($(
				'#contact_mgtgrp_id').val() === "")) {
			$('#upload_contact, #mobile_numbers_txt, #contact_mgtgrp_id').css('border-color', 'red');
			errorMessages.push('Please upload a file (CSV or TXT).');
			flag = false;
		}
        
        // Display consolidated error messages
        if (errorMessages.length > 0) {
            console.log("Error messages:", errorMessages);
            $("#id_error_display").html(errorMessages.join('<br>')).css('color', 'red');
        }

        // Prevent form submission if flag is false
        if (!flag) {
            console.log("Form submission prevented due to validation errors.");
            return; // Exit early if validation failed
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
        // let character_count = message_txt.length
        /* If all are ok then we send ajax request to ajax/master_call_functions.php *******/
        if (flag) {
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
                        $('#frm_contact_group').removeClass('was-validated');
                        $('#upload_contact').val('');
                        $('#compose_submit').attr('disabled', false);
                        // $("#id_error_display").html(response.msg).css('color', 'red');
                        $('#image_display').attr('src', 'libraries/assets/png/failed.png');
                        $('#campaign_compose_message').modal({
                            show: true
                        });
                        $("#message").html(response.msg).css('color', 'red');
                    } else if (response.status == 2) {
                        $('#frm_contact_group').removeClass('was-validated');
                        $('#compose_submit').attr('disabled', false);
                        $('#compose_submit').attr('disabled', false);
                        $('#image_display').attr('src', 'libraries/assets/png/failed.png');
                        $('#campaign_compose_message').modal({
                            show: true
                        });
                        $("#message").html(response.msg).css('color', 'red');
                    } else if (response.status == 1) {
                        $('#upload_contact').val('');
                        $('#frm_contact_group').removeClass('was-validated');
                        $('#campaign_compose_message').modal({
                            show: true
                        });
                        $('#image_display').attr('src', 'libraries/assets/png/success.png');
                        $("#message").html("Campign Created Successfully");
                        setInterval(function() {
                            window.location = 'compose_whatsapp_list';
                            document.getElementById("frm_contact_group").reset();
                        }, 2000);
                    }
                    $('.theme-loader').hide();
                },
                error: function(response, status, error) {
                    $('#upload_contact').val('');
                    $('#compose_submit').attr('disabled', false);
                    $('.theme-loader').show();
                    $("#id_error_display").html(response.msg).css('color', 'red');
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
            var match = ['text/csv', 'text/plain']; // Allow CSV and text files
            if (!((fileType == match[0]) || (fileType == match[1]) || (fileType == match[2]) || (fileType ==
                    match[3]) || (fileType == match[4]) || (fileType == match[5]))) {
                $("#id_error_display").html('Sorry, only CSV file are allowed to upload.');
                $("#upload_contact").val('');
                return false;
            }
        }
    });

    $("#file_image_header").change(function() {
        $("#id_error_display").html('');

        var file = $("#file_image_header")[0].files[0];
        var fileType = file.type;
        var fileSize = Math.round(file.size / 1024 / 1024);

        var allowedTypes = ['image/jpeg', 'image/png', 'video/mp4', 'video/x-msvideo', 'video/x-matroska',
            'video/quicktime'
        ];
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
            reader.onload = function(e) {
                var video = document.createElement('video');
                video.src = e.target.result;
                video.onloadedmetadata = function() {
                    var duration = video.duration; // in seconds
                    var maxDuration = 30;
                    if (duration > maxDuration) {
                        $("#id_error_display").html(
                            'Sorry, Upload video with duration below 30 seconds.');
                        $("#file_image_header").val('');
                    }
                };
            };
            reader.readAsDataURL(file);
        }
    });

    $('#upload_file_popup').find('.save_compose_file').on('click', function() {
        csvfile();
    });

    function csvfile() {
        var fd = new FormData();
        // Append the copied file to the FormData object
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


    // func_template_senderid func
    function func_template_senderid(admin_user) {
        var slt_whatsapp_template = $("#slt_whatsapp_template").val();
        var send_code = "&slt_whatsapp_template=" + slt_whatsapp_template;
        $('#txt_variable_count').val(0);
        $("#fle_variable_csv").attr("required", false);
        $('#id_show_variable_csv').css('display', 'none');
        $('#txt_list_mobno').attr('readonly', false);
        $("#id_mobupload").css('display', 'block');
        $("#id_mobupload_sub").css('display', 'none');
        $.ajax({
            type: 'post',
            url: "ajax/call_functions.php?tmpl_call_function=senderid_template" + send_code,
            dataType: 'json',
            beforeSend: function() {
                $('.theme-loader').show();
            },
            complete: function() {
                $('.theme-loader').hide();
            },
            success: function(response) {
                $('#id_own_senderid').html(response.msg);
                var slt_whatsapp_template_split = slt_whatsapp_template.split("!");
                if (slt_whatsapp_template_split[2] > 0) {
                    $('#txt_variable_count').val(slt_whatsapp_template_split[2]);
                    $('#txt_list_mobno').attr('readonly', true);
                    $("#fle_variable_csv").attr("required", true);
                    $('#id_show_variable_csv').css('display', 'block');
                    $("#upload_contact").val('');
                    $('#txt_list_mobno').val('');
                    $("#id_mobupload").css('display', 'none');
                    $("#id_mobupload_sub").css('display', 'block');
                }
                $('.theme-loader').hide();
                  call_getsingletemplate();
            },
            error: function(response, status, error) {}
        });
    }

    // call_getsingletemplate funtc
    function call_getsingletemplate() {
        var tmpl_name = $("#slt_whatsapp_template").val();
        var id_slt_mobileno = $("#txt_whatsapp_mobno").val();
        var id_slt_mobileno_split = id_slt_mobileno.split("~~");
        $("#id_slt_mobileno").val(id_slt_mobileno_split[3] + "||" + id_slt_mobileno_split[4] + "||0||" +
            id_slt_mobileno_split[6]);
        $.ajax({
            type: 'post',
            url: "ajax/whatsapp_call_functions.php?getSingleTemplate_meta=getSingleTemplate_meta&tmpl_name=" +
                tmpl_name + "&wht_tmpl_url=" + id_slt_mobileno_split[4] + "&wht_bearer_token=" +
                id_slt_mobileno_split[3],
            beforeSend: function() {
                $("#id_error_display").html("");
                $('.theme-loader').show();
            },
            complete: function() {
                $("#id_error_display").html("");
                $('.theme-loader').hide();
            },
            success: function(response_msg) {
                $('#slt_whatsapp_template_single').html(response_msg.msg);
                $("#txt_sms_content").val(response_msg.msg);
                $('.theme-loader').hide();
                $("#id_error_display").html("");
            },
            error: function(response_msg, status, error) {
                $('.theme-loader').hide();
                $("#id_error_display").html("");
            }
        });
    }


    function isValidInput(event) {
        var slt_whatsapp_template = $("#slt_whatsapp_template").val();
        if (slt_whatsapp_template == '') {
            $('#id_error_display').html('<b>Please select Template! .</b>');
            return false;
        }
        var charCode = event.charCode || event.keyCode;
        return (charCode === 44 || // Allow comma (,)
            charCode === 8 || // Allow backspace
            charCode === 13 || // Allow enter
            (charCode >= 48 && charCode <= 57)); // Allow digits (0-9)
    }


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
