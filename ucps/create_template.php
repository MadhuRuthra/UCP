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

    <title>Create Template ::
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
    <script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
    <link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet" />

    <!-- style include in css -->
    <style>
    .loader {
        width: 50;
        background-color: #ffffffcf;
    }

    .loader img {}

    /* Messenger View Card Styling */
    .messenger-view {
        max-width: 400px;
        /* Set a width similar to mobile view */
        margin: 0 auto;
        /* Center the card horizontally */
        height: 600px;
        /* Set a height that resembles a mobile screen */
        display: flex;
        flex-direction: column;
        border: 5px;
        border-radius: 10px !important;
    }

    /* Header Styling */
    .messenger-view .card-header {
        background-color: #007bff;
        /* Typical messenger header color */
        color: white;
        padding: 10px;
        text-align: center;
        font-weight: bold;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }

    /* Body Styling */
    .messenger-view .card-body {
        flex-grow: 1;
        /* Take up remaining space */
        padding: 10px;
        background-color: #f0f0f0;
        /* Light gray background for the message area */
        border-bottom-left-radius: 15px;
        border-bottom-right-radius: 15px;
        /* overflow-y: auto; */
        /* Allows scrolling for long messages */
    }

    .messenger-view .preview-container {
        display: flex;
        overflow-x: auto;
        white-space: nowrap;
        max-height: 100%;
        background-color: white;
        padding: 10px;
        border-radius: 10px;
    }

    .messenger-view .preview-item {
        background-color: #dcf8c6;
        padding: 10px;
        margin-right: 10px;
        border-radius: 15px;
        width: 330px;
        display: inline-block;
        word-wrap: break-word;
    }


    /* Message Container Styling */
    /* .messenger-view .preview-container {
      max-height: 100%;
      overflow-y: auto;
      background-color: white;
      padding: 10px;
      border-radius: 10px;
    } */

    /* Message Item Styling */
    /* .messenger-view .preview-item {
      background-color: #dcf8c6;
      padding: 10px;
      margin-bottom: 10px;
      border-radius: 15px;
      max-width: 100%;
      word-wrap: break-word;
      position: center;
    } */

    .messenger-view .preview-item p {
        margin: 0;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .messenger-view .card-header {
            padding: 12px;
        }

        .messenger-view .card-header h4 {
            font-size: 1rem;
        }

        .messenger-view .preview-container {
            padding: 10px;
        }

        .messenger-view .preview-item p {
            font-size: 0.875rem;
        }
    }

    @media (max-width: 576px) {
        .messenger-view .card-header {
            padding: 8px;
        }

        .messenger-view .card-header h4 {
            font-size: 0.875rem;
        }

        .messenger-view .preview-container {
            padding: 8px;
        }

        .messenger-view .preview-item p {
            font-size: 0.75rem;
        }
    }

    .card .card-body p {
        font-weight: 550;
    }

    /* Base styles */
    .preview-card {
        text-align: center;
        padding: 5px 1;
        position: relative;
    }

    .preview-icon-text {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        /* Stack the icon and text vertically */
    }

    .preview-icon {
        font-size: 1.5rem;
        /* Adjust the size if needed */
        color: #000;
        /* Default color */
        margin-bottom: 5px;
        /* Space between icon and text */
    }

    /* .preview-text {
      font-size: 1rem;
      color: #000;
    } */

    .preview-card:after {
        content: '';
        display: block;
        width: 100%;
        border-bottom: 1px solid #ddd;
        /* Adds an underline */
        margin-top: 10px;
        /* Space between text and underline */
    }

    /* Mobile-specific styles */
    @media (max-width: 768px) {
        .preview-icon {
            color: #007bff;
            /* Mobile-specific icon color */
        }

        .preview-card {
            margin-bottom: 15px;
            /* Space between suggestions */
        }
    }
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
                                            <h5>Create Template</h5>
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
                                                <a href="create_template">Create Template</a>
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
                                        <div class="col-12 col-md-12 col-lg-12">
                                            <div class="card">
                                                <div class="row">
                                                    <div class="col-8">
                                                        <form class="needs-validation" novalidate=""
                                                            id="frm_compose_whatsapp" name="frm_compose_whatsapp"
                                                            action="#" method="post" enctype="multipart/form-data">
                                                            <div class="card-body">
                                                                      <!-- Choose Template Category -->
                      <div class="form-group mb-2 row" style='display: none;'>
                        <label class="col-sm-3 col-form-label">Choose Template Category <label
                            style="color:#FF0000">*</label><br>
                          <div><i class="fa fa-star checked"></i> New categories are available. <a href="#"
                              data-toggle="modal" data-target="#myModal"> Learn more about categories </a></div>
                        </label></br>
                        <div class="col-sm-7">
                          <div class="list-group" name="list_items()">
                            <div role="button" class="list-group-item list-group-item-action"><input
                                class="form-check-input" tabindex="1" type="radio" name="categories" id="MARKETING"
                                value="MARKETING" style="margin-left:2px;" checked />
                              <div style="margin-left:20px;"><i class="fas fa-bullhorn"></i> <b> Marketing </b><br> Send promotions or information about your products, services or business.</div>
                            </div>
                            <div role="button" class="list-group-item list-group-item-action"><input
                                class="form-check-input" tabindex="2" type="radio" name="categories" id="UTILITY"
                                value="UTILITY" style="margin-left:2px;" />
                              <div style="margin-left:20px;"><i class="fa fa-bell"></i><b> Utility </b><br> Send
                                messages about an existing order or account.</div>
                            </div>
                            <div role="button" class="list-group-item list-group-item-action"><input
                                class="form-check-input" tabindex="3" type="radio" name="categories" id="AUTHENTICATION"
                                value="AUTHENTICATION" style="margin-left:2px;" />
                              <div style="margin-left:20px;"><i class="fa fa-key"></i> <b> Authentication </b><br> Send
                                codes to verify a transaction or login.</div>
                            </div>
                          </div>
                        </div>
                      </div>
                                                                <!-- Choose Languages -->
                                                                <div class="form-group mb-2 row">
                                                                    <label class="col-sm-3 col-form-label">Languages
                                                                        <label style="color:#FF0000">*</label> <span
                                                                            data-toggle="tooltip"
                                                                            data-original-title="Choose languages for your message template. You can delete or add more languages later.">[?]</span></label>
                                                                    <div class="col-sm-8">
                                                                        <select name="lang[]" id="lang" required
                                                                            class="form-control" tabindex="2">
                                                                            <option value="">Choose Language</option>
                                                                            <? // To list the Languages
                                                                  $replace_txt = '{
                                                                  "user_id" : "' . $_SESSION['yjucp_user_id'] . '"
                            }'; 
                                // Call the reusable cURL function
                                $response = executeCurlRequest($api_url . "/sender_id/master_language", "GET", $replace_txt);
                                // After got response decode the JSON result
                                 if (empty($response)) {
                                       // Redirect to index.php if response is empty
                                             header("Location: index");
                                             exit(); // Stop further execution after redirect
                                      }
			                 // After got response decode the JSON result
                            $state1 = json_decode($response, false);
			               // Display the response data into Option Button
                            if ($state1->num_of_rows > 0) {
                                // Looping the indicator is less than the count of report details.if the condition is true to continue the process and to get the option value.if the condition are false to stop the process.to send the message in no available data.
                              for ($indicator = 0; $indicator < count($state1->report); $indicator++) {
                                $language_name = $state1->report[$indicator]->language_name;
                                $language_id = $state1->report[$indicator]->language_id;
                                $language_code = $state1->report[$indicator]->language_code;
                                ?>
                                                                            <option
                                                                                value="<?= $language_code . '-' . $language_id ?>">
                                                                                <?= $language_name ?></option> <?php }
                            }
                            ?>
                                                                        </select>
                                                                        <script>
                                                                        $(".chosen-select").chosen({
                                                                            no_results_text: "Oops, nothing found!"
                                                                        })
                                                                        </script>
                                                                    </div>
                                                                </div>

                                                                <!-- Header -->
                                                                <div class="form-group mb-2 row">
                                                                    <label class="col-sm-3 col-form-label">Header <span
                                                                            data-toggle="tooltip"
                                                                            data-original-title="Add a title or choose which type of media you'll use for this header">[?]</span><span
                                                                            style="margin-left:10px;"><b>Optional</b></span></label>
                                                                    <div class="col-sm-8">
                                                                        <select id="select_id" name="header"
                                                                            class="form-control" tabindex="3">
                                                                            <option value="None" type="radio"> None
                                                                            </option>
                                                                            <option value="TEXT"> Text </option>
                                                                            <option value="MEDIA"> Media </option>
                                                                        </select>
                                                                        <!-- <br> -->
                                                                        <!-- Header Name -->
                                                                        <div style="display: none; margin-left:4px; "
                                                                            id="text">
                                                                            </br>
                                                                            <input type="text" name="txt_header_name"
                                                                                id='txt_header_name'
                                                                                class="form-control custom-width"
                                                                                value="<?= $txt_header_name ?>"
                                                                                tabindex="4" maxlength="60"
                                                                                placeholder="Enter header name..."
                                                                                data-toggle="tooltip"
                                                                                data-placement="top" title=""
                                                                                data-original-title="Enter header Name">
                                                                            <!-- <div type="text" contenteditable="true"
                                                                                name="txt_header_name"
                                                                                id='txt_header_name'
                                                                                class="form-control custom-width"
                                                                                value="<?= $txt_header_name ?>"
                                                                                tabindex="4" maxlength="60"
                                                                                placeholder="Enter header name..."
                                                                                data-toggle="tooltip"
                                                                                data-placement="top" title=""
                                                                                data-original-title="Enter header Name">
                                                                            </div> -->
                                                                            Characters : ​<span id="count1">0</span>

                                                                        </div>
                                                                        <div class=" container" style="display: none;"
                                                                            id="header_variable_btn1">
                                                                            <div class="row">
                                                                                <div class="col-4"> ​<button name="btn1"
                                                                                        onclick="myFunction()"
                                                                                        type="button" id="btn1"
                                                                                        tabindex="5"
                                                                                        class="btn btn-success "
                                                                                        style="text-align:center; margin-top:5px;">
                                                                                        + Add variable</button></div>
                                                                                <!-- <div class="col-4" id='txt_header_variable'> </div> -->
                                                                                <div class="col-4">
                                                                                    <input type="text"
                                                                                        name="txt_header_variable"
                                                                                        style=" height:40px;"
                                                                                        id='txt_header_variable_1'
                                                                                        tabindex="6"
                                                                                        class="form-control"
                                                                                        value="<?= $txt_sample_name ?>"
                                                                                        maxlength="60"
                                                                                        placeholder="Header Variable"
                                                                                        data-toggle="tooltip"
                                                                                        data-placement="top" title=""
                                                                                        data-original-title="Header Variable"
                                                                                        style="display: none; margin-top:0px;">
                                                                                    <div class="col-4"></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Image / Document (Media) -->
                                                                        </br>
                                                                        <div class="row" id="image_category"
                                                                            style="display: none; "
                                                                            name="image_category">
                                                                            <div class="col-4" style="float: left;">
                                                                                <div role="button">
                                                                                    <label>Image</label><input
                                                                                        class="form-check-input"
                                                                                        type="radio"
                                                                                        name="media_category"
                                                                                        tabindex="7" id="image1"
                                                                                        value="image"
                                                                                        style="margin-left:2px;"
                                                                                        onclick=" media_category_img(this)" />
                                                                                    <div style="margin-left:20px;"><i
                                                                                            class="fa fa-image"
                                                                                            style="font-size: 20px"></i>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-4" style="float: left;">
                                                                                <div role="button">
                                                                                    <label>Video</label><input
                                                                                        class="form-check-input"
                                                                                        type="radio"
                                                                                        name="media_category"
                                                                                        tabindex="8" id="image2"
                                                                                        value="video"
                                                                                        style="margin-left:2px;"
                                                                                        onclick=" media_category_vid(this)" />
                                                                                    <div style="margin-left:20px;"><i
                                                                                            class="fa fa-play-circle"
                                                                                            style="font-size: 20px"></i>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-4" style="float: left;">
                                                                                <div role="button">
                                                                                    <label>Document</label><input
                                                                                        class="form-check-input"
                                                                                        type="radio"
                                                                                        name="media_category"
                                                                                        tabindex="9" id="image3"
                                                                                        value="document"
                                                                                        style="margin-left:2px;"
                                                                                        onclick=" media_category_doc(this)" />
                                                                                    <div style="margin-left:20px;"><i
                                                                                            class="fa fa-file-text"
                                                                                            style="font-size: 20px"></i>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-4 file_image_header"
                                                                                style="float: left; display:none;">
                                                                                <input type="file" name="file_image_header" id="file_image_header" tabindex="10" onchange="validateMediaFile()"/>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Body Content -->
                                                                <div class="form-group mb-2 row">
                                                                    <label class="col-sm-3 col-form-label">Body <label
                                                                            style="color:#FF0000">*</label> <span
                                                                            data-toggle="tooltip"
                                                                            data-original-title="Enter the text for your message in the language that you've selected.">[?]</span></label>
                                                                    <div class="col-sm-8">
                                                                        <div class="row">
                                                                            <div class="col-8">
                                                                                <!-- TEXT area alert -->
                                                                                <textarea id="textarea"
                                                                                    class="delete form-control"
                                                                                    name="textarea" required
                                                                                    maxlength="1024" tabindex="11"
                                                                                    placeholder="Enter Body Content"
                                                                                    rows="6" required
                                                                                    style="width: 100%; height: 150px !important;"></textarea>
                                                                                <div class="row" style="right: 0px;">
                                                                                    <div class="col-sm"
                                                                                        style="margin-top: 5px;"> <span
                                                                                            id="current_text_value">0</span><span
                                                                                            id="maximum">/ 1024</span>
                                                                                    </div>
                                                                                    <div class="col-sm"
                                                                                        style=" margin-top: 5px;">​<a
                                                                                            href='#!' name="btn"
                                                                                            type="button" id="btn"
                                                                                            tabindex="12"
                                                                                            class="btn btn-success"> +
                                                                                            Add
                                                                                            variable</a></div>
                                                                                </div>

                                                                                <!-- TEXT area alert End -->
                                                                            </div>
                                                                            <div class="col container1"
                                                                                id="add_variables"
                                                                                style="display:none;"><label
                                                                                    class="col-form-label">Variable
                                                                                    Values
                                                                                    <label style="color:#FF0000"> *
                                                                                    </label>
                                                                                    <span data-toggle="tooltip"
                                                                                        data-original-title="Variables must not empty.Template Name allowed maximum 60 Characters.">[?]</span></label>
                                                                            </div>
                                                                        </div>
                                                                    </div>


                                                                </div>
                                                                <div class="form-group mb-2 row">
                                                                    <label class="col-sm-3"></label>
                                                                    <div class="col-sm-8" style="display:none;"
                                                                        id="alert_variable" style="border-color:red">
                                                                        <!-- <div class="row"> -->
                                                                        <span>
                                                                            <ul style="list-style-type: disc;">
                                                                                <!-- <div> -->
                                                                                <li>The body text
                                                                                    contains variable parameters at the
                                                                                    beginning or end. You need
                                                                                    to either change this format or add
                                                                                    a sample.</li>
                                                                                <li>Variables must
                                                                                    not empty.</li>
                                                                                <li>This template
                                                                                    contains too many variable
                                                                                    parameters relative to the message
                                                                                    length. You need to decrease the
                                                                                    number of variable parameters or
                                                                                    increase the
                                                                                    message length.</li>
                                                                                <li>The body text
                                                                                    contains variable parameters that
                                                                                    are next to each other. You
                                                                                    need to either change this format or
                                                                                    add a sample.</li>
                                                                                <li> <a target="_blank"
                                                                                        href="https://developers.facebook.com/docs/whatsapp/message-templates/guidelines/">Learn
                                                                                        more about formatting in Message
                                                                                        Template Guidelines</a></li>
                                                                                <!-- </div> -->
                                                                            </ul>
                                                                        </span>
                                                                        <!-- </div> -->
                                                                    </div>
                                                                </div>


                                                                <!-- Footer -->
                                                                <div class="form-group mb-2 row">
                                                                    <label class="col-sm-3 col-form-label">Footer <span
                                                                            data-toggle="tooltip"
                                                                            data-original-title="Add a short line of text to the bottom of your message template. If you add the marketing opt-out button, the associated footer will be shown here by default.">[?]</span><span
                                                                            style="margin-left:10px;"><b>Optional</b></span></label></br>
                                                                    <div class="col-sm-8">
                                                                        <div>
                                                                            <input type="text" name="txt_footer_name"
                                                                                id='txt_footer_name' tabindex="13"
                                                                                class="form-control"
                                                                                value="<?= $txt_footer_name ?>"
                                                                                maxlength="60"
                                                                                placeholder="Enter Footer Name..."
                                                                                data-toggle="tooltip"
                                                                                data-placement="top" title=""
                                                                                data-original-title="Enter Footer Name">Characters
                                                                            : ​<span id="count2">0</span>
                                                                        </div>

                                                                    </div>
                                                                </div>

                                                                <!-- Buttons -->
                                                                <div class="form-group mb-2 row">
                                                                    <label class="col-sm-3 col-form-label">Buttons <span
                                                                            data-toggle="tooltip"
                                                                            data-original-title="Create buttons that let customers respond to your message or take action.">[?]</span><span
                                                                            style="margin-left:10px;"><b>Optional</b></span></label>
                                                                    <div class="col-sm-8">
                                                                        <div>
                                                                            <select id="select_action"
                                                                                name="select_action"
                                                                                class="form-control" tabindex="14">
                                                                                <option value="None" type="radio"> None
                                                                                </option>
                                                                                <option value="CALLTOACTION"> Call To
                                                                                    Action
                                                                                </option>
                                                                                <option value="QUICK_REPLY"> Quick Reply
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                        <br>

                                                                        <div class="container" style="display:none;"
                                                                            id="callaction">
                                                                            <div class="row">
                                                                                <div class="col">
                                                                                    <label for="lang1">Type of
                                                                                        action</label><br>

                                                                                    <select id="select_action1"
                                                                                        name="select_action1"
                                                                                        class="form-control"
                                                                                        tabindex="15">
                                                                                        <option value="PHONE_NUMBER">
                                                                                            Call Phone
                                                                                            Number </option>
                                                                                        <option value="VISIT_URL"> Visit
                                                                                            Website
                                                                                        </option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col">
                                                                                    <label for="lang1">Button
                                                                                        text</label><br>
                                                                                    <input type="text"
                                                                                        name="button_text[]"
                                                                                        id='button_text'
                                                                                        class="form-control"
                                                                                        value=""
                                                                                        tabindex="16" maxlength="25"
                                                                                        placeholder="Enter button name..."
                                                                                        data-toggle="tooltip"
                                                                                        data-placement="top" title=""
                                                                                        data-original-title="Enter button name">
                                                                                </div>

                                                                                <div class="col">
                                                                                    <label
                                                                                        for="lang1">Country</label><br>
                                                                                    <select id="country_code"
                                                                                        name="country_code"
                                                                                        class="form-control"
                                                                                        tabindex="17">
                                                                                        <? // To display the country from Master API
                                  $replace_txt = '{
                                    "user_id" : "' . $_SESSION['yjucp_user_id'] . '"
                                  }'; // User Id

                                    // Call the reusable cURL function
                                $response = executeCurlRequest($api_url . "/sender_id/country_list", "GET", $replace_txt);
                                // After got response decode the JSON result
                                 if (empty($response)) {
                                       // Redirect to index.php if response is empty
                                             header("Location: index");
                                             exit(); // Stop further execution after redirect
                                      }
				  // After got response decode the JSON result
                                  $state1 = json_decode($response, false);
				  // Display the Response data into option list. By default select India
                                  if ($state1->num_of_rows > 0) {
                                     // Looping the indicator is less than the count of report details.if the condition is true to continue the process and to get the option value.if the condition are false to stop the process.to send the message in no available data.
                                    for ($indicator = 0; $indicator < count($state1->report); $indicator++) {
                                      $shortname = $state1->report[$indicator]->shortname;
                                      $phonecode = $state1->report[$indicator]->phonecode;
                                      ?>
                                                                                        <option
                                                                                            value="<?= "+" . $phonecode ?>"
                                                                                            <? if ($shortname=='IN' ) {
                                                                                            echo "selected" ; } ?>
                                                                                            ><?=$shortname . "+" . $phonecode ?>
                                                                                        </option>
                                                                                        <?php }
                                  }
                                  ?>
                                                                                    </select></label>

                                                                                </div>
                                                                                <div class="col">
                                                                                    <label for="lang1">Phone
                                                                                        number</label><br>
                                                                                    <input type="text"
                                                                                        name="button_txt_phone_no[]"
                                                                                        id='button_txt_phone_no'
                                                                                        onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                                                                        oninput="validateInput_phone()"
                                                                                        class="form-control"
                                                                                        value=""
                                                                                        tabindex="18" maxlength="10"
                                                                                        placeholder="Phone number"
                                                                                        style="padding: 10px 5px !important;"
                                                                                        data-toggle="tooltip"
                                                                                        data-placement="top" title=""
                                                                                        data-original-title="Phone number">
                                                                                </div>
                                                                            </div>

                                                                            <div class="row add_phone_content"> </div>

                                                                            <div class="col"><a href='#!'
                                                                                    name="add_phone_btn" type="button"
                                                                                    id="add_phone_btn_btn" tabindex="19"
                                                                                    class="btn btn-success"
                                                                                    style="margin-top:30px; width:200px;">+
                                                                                    Add Another Button</a></div>
                                                                        </div>

                                                                        <!-- Call to Action -->
                                                                        <div class="container" style="display:none;"
                                                                            id="calltoaction">
                                                                            <div class="row">
                                                                                <div class="col">
                                                                                    <label for="lang1">Button
                                                                                        Text</label><br>
                                                                                    <input type="text"
                                                                                        name="button_quickreply_text[]"
                                                                                        id='button_quickreply_text1'
                                                                                        class="form-control add_reply"
                                                                                        value=""
                                                                                        tabindex="20" maxlength="25"
                                                                                        placeholder="Enter Button Name 1"
                                                                                        data-toggle="tooltip"
                                                                                        data-placement="top" title=""
                                                                                        data-original-title="Enter button name">
                                                                                </div>

                                                                                <div class="col">
                                                                                    ​<a href='#!'
                                                                                        name="add_another_button"
                                                                                        type="button"
                                                                                        id="add_another_button"
                                                                                        tabindex="21"
                                                                                        class="btn btn-success"
                                                                                        style="margin-top:30px;">+ Add
                                                                                        Another
                                                                                        Button</a>
                                                                                </div>
                                                                            </div>

                                                                            <div class="row ">
                                                                                <div
                                                                                    class="col-md-6 add_button_textbox">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="container" style="display:none;"
                                                                            id="visit_website">
                                                                            <div class="row">
                                                                                <div class="col"><label for="lang1">Type
                                                                                        of
                                                                                        action</label><br><select
                                                                                        id="select_action3"
                                                                                        name="select_action3"
                                                                                        class="form-control"
                                                                                        tabindex="22">
                                                                                        <option value="PHONE_NUMBER">
                                                                                            Phone
                                                                                            Number</option>
                                                                                        <option value="VISIT_URL"> Visit
                                                                                            Website
                                                                                        </option>
                                                                                    </select> </div>
                                                                                <div class="col"><label
                                                                                        for="select_action2">URL
                                                                                        Button Name</label><br>
                                                                                    <input type="text"
                                                                                        name="button_url_text[]"
                                                                                        id='button_url_text'
                                                                                        class="form-control"
                                                                                        value="<?= $website ?>"
                                                                                        tabindex="23" maxlength="25"
                                                                                        placeholder="Enter url name..."
                                                                                        data-toggle="tooltip"
                                                                                        data-placement="top" title=""
                                                                                        data-original-title="Enter button name">
                                                                                </div>
                                                                                <div class="col"><label
                                                                                        for="select_action2">Type</label><br>
                                                                                    <select name="select_action2"
                                                                                        id="select_action2"
                                                                                        class="form-control">
                                                                                        <option value="Static"> Static
                                                                                        </option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col"><label
                                                                                        for="select_action2">URL</label><br>
                                                                                    <input type="text"
                                                                                        name="website_url[]"
                                                                                        id='website_url'
                                                                                        class="form-control"
                                                                                        value="<?= $website ?>"
                                                                                        tabindex="24" maxlength="2000"
                                                                                        placeholder="Enter url..."
                                                                                        data-toggle="tooltip"
                                                                                        data-placement="top" title=""
                                                                                        data-original-title="Enter url">
                                                                                </div>
                                                                            </div>
                                                                            <div class="row add_url_content"> </div>

                                                                            <div class="col"><a href='#!'
                                                                                    name="add_url_btn_btn" type="button"
                                                                                    id="add_url_btn_btn" tabindex="25"
                                                                                    class="btn btn-success"
                                                                                    style="margin-top:30px; width:200px;">+
                                                                                    Add Another Button</a></div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <input type="hidden" class="form-control"
                                                                    name='tmp_qty_count' id='tmp_qty_count' value='1' />
                                                                <input type="hidden" class="form-control"
                                                                    name='temp_call_function' id='temp_call_function'
                                                                    value='create_template' />
                                                                <input type="hidden" class="form-control"
                                                                    name='hid_sendurl' id='hid_sendurl'
                                                                    value='<?= $server_http_referer ?>' />
                                                            </div>
                                                            <? // Sender List from API
       $replace_txt = '{
        "user_id" : "' . $_SESSION['yjucp_user_id'] . '"
      }'; 
            // Call the reusable cURL function
            $response = executeCurlRequest($api_url . "/whsp_process/check_sender_id", "GET", $replace_txt);
            // After got response decode the JSON result
             if (empty($response)) {
                   // Redirect to index.php if response is empty
                         header("Location: index");
                         exit(); // Stop further execution after redirect
                  }
      // After got response decode the JSON result
      $sms = json_decode($response, false);
?>

                                                            <?php // If Sender ID is available
if ($sms->num_of_rows > 0) { ?>
                                                            <div class="error_display text-center" id='id_error_display_submit' style="color:red;">
                                                            </div>
                                                            <div class="card-footer text-center">
                                                                <input type="button" onclick="myFunction_clear()"
                                                                    value="Clear" class="btn btn-success"
                                                                    id="clr_button">
                                                                <input type="submit" name="submit" id="submit"
                                                                    tabindex="26" value=" Save & Submit"
                                                                    class="btn btn-success">
                                                                <input type="button" value="Preview Content"
                                                                    onclick="preview_content()" data-toggle="modal"
                                                                    data-target="#previewModal" class="btn btn-success"
                                                                    id="pre_button" name="pre_button">
                                                            </div>
                                                            <? } else { ?>
                                                            <div class="error_display" id='id_error_display_'> No Sender
                                                                Number
                                                                Available</div>
                                                            <? } ?>

                                                        </form>

                                                    </div>
                                                    <!-- Preview Designs -->
                                                    <div class="col-4 col-md-4 col-lg-4">
                                                        <div class="card shadow-sm rounded messenger-view">
                                                            <div class="card-header custom-header">
                                                                <h4>Message Preview</h4>
                                                            </div>
                                                            <div class="card-body">
                                                                <div id="preview-container"
                                                                    class="preview-container scrollable-content">
                                                                    <div class="row">
                                                                        <div class="col">
                                                                            <div class="preview-item"
                                                                                id="preview-item-1"
                                                                                style="margin-top:10px;">
                                                                                <div id="header_media"
                                                                                    style="display:none;">
                                                                                </div>
                                                                                <h4 id="header_text"
                                                                                    style="width: 330px;word-wrap: break-word;overflow-wrap: break-word;white-space: normal;">
                                                                                    <strong></strong>
                                                                                </h4>
                                                                                <p id="preview-body"
                                                                                    style="margin-top:10px;word-wrap: break-word;overflow-wrap: break-word;white-space: normal;">
                                                                                    Enter Body Content</p>
                                                                                <div class="card-fileds" id="card-fileds" style="background-color: #fafdfb"> </div>
                                                                            </div>
                                                                            <div style="word-wrap: break-word;overflow-wrap: break-word;white-space: normal;color:#333333c4;"> <span id="footer_text">Enter Footer Name...</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <!-- Navigation Buttons -->
                                                                <div class="navigation-buttons"
                                                                    style="text-align: center; margin-top: 10px;display:none;">
                                                                    <button id="prevBtn"
                                                                        class="btn btn-primary">Previous</button>
                                                                    <button id="nextBtn"
                                                                        class="btn btn-primary">Next</button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>


                        </div>


                        <!-- Modal Popup window content-->
                        <!-- Modal -->
                        <div class="modal fade" id="myModal" role="dialog">
                            <div class="modal-dialog modal-lg">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Learn more about categories</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <dl class="last">
                                            <dt><span class="order">Choose a category that describes the text, media and
                                                    buttons that you will
                                                    send.</span></dt><br>
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col">
                                                        <img src="./assets/img/image1.jpg" width="200px" height="200px">
                                                    </div>
                                                    <div class="col">
                                                        <img src="./assets/img/image2.jpg" width="200px" height="200px">
                                                    </div>
                                                    <div class="col">
                                                        <img src="./assets/img/image3.jpg" width="200px" height="200px">
                                                    </div>

                                                    <div class="col">
                                                        <i class="fas fa-bullhorn"></i> <b>Marketing</b></br>Any message
                                                        that is not utility or
                                                        authentication will be marketing.</br>Examples: welcome
                                                        messages, newsletters, offers, coupons,
                                                        catalogues, new store hours.
                                                    </div>
                                                    <div class="col">
                                                        <i class="fa fa-bell"></i> <b>Utility</b></br>Updates about an
                                                        order or account that a customer
                                                        has already created.</br>Examples: order confirmations, account
                                                        updates, receipts, appointment
                                                        reminders, billing.
                                                    </div>
                                                    <div class="col">
                                                        <i class="fa fa-key"></i> <b>
                                                            Authentication</b></br>Codes to help customers verify their
                                                        purchases or account
                                                        logins.</br>Examples: one-time password, account recovery code.
                                                    </div>

                                        </dl>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn-outline-secondary"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </div>

                            </div>
                        </div>


                        <!-- Preview Data Modal content-->
                        <!-- Modal content-->
                        <div class="modal fade" id="default-Modal" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document" style=" max-width: 75% !important;">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Template Details</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" id="id_modal_display"
                                        style=" word-wrap: break-word; word-break: break-word;">
                                        <h5>No Data Available</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-success waves-effect "
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Preview Data Modal content End-->
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
    $(function() {
        $('.theme-loader').fadeOut("slow");
    });
    /*document.body.addEventListener("click", function(evt) {
        //note evt.target can be a nested element, not the body element, resulting in misfires
        $("#id_error_display_submit").html("");
    });*/
    // id_error_display_submit -clear
    function validateInput_phone() {
        $("#id_error_display_submit").html("");
    }

    // Header Checkbox allowed - Media Image
    function media_category_img(e) {
        $('#header_media').empty();
        document.getElementById("file_image_header").value = "";
        $('.file_image_header').css("display", "block");
        $('#file_image_header').prop('accept', 'image/png, image/gif, image/jpeg, image/jpg');
    }

    // Header Checkbox allowed - Media Video
    function media_category_vid(e) {
        $('#header_media').empty();
        document.getElementById("file_image_header").value = "";
        $('.file_image_header').css("display", "block");
        $('#file_image_header').prop('accept', 'video/h263,video/m4v,video/mp4,video/mpeg,video/mpeg4,video/webm');
    }

    // Header Checkbox allowed - Media Document
    function media_category_doc(e) {
        $('#header_media').empty();
        document.getElementById("file_image_header").value = "";
        $('.file_image_header').css("display", "block");
        $('#file_image_header').prop('accept', 'text/plain,text/csv, .doc, .pdf,application/vnd.ms-excel');
    }

    // Header select the text or media
    $('#select_id').on('change', function() {
        var value = $(this).val();
        if (value == 'TEXT') { // If selected the Text
            $('#header_media').empty();
            $('#card-fileds').empty();
            $('#header_text').html('');
            $('.form-check-input').removeAttr('required');
            $('input[name="media_category"]').prop('checked', false);
            document.getElementById('btn1').style.pointerEvents = "auto";
            $('#header_variable_btn1').css("display", "block");
            $('#txt_header_variable_1').css("display", "none");
            $('#text').css("display", "block");
            $('#image_category').css("display", "none");
        } else if (value == 'MEDIA') { // If Selecte the Media
            $('#header_text').html('');
            $('#card-fileds').empty();
            $('#txt_header_variable_1').removeAttr('required');
            document.getElementById("txt_header_name").value = "";
            document.getElementById("txt_header_variable_1").value = "";
            $('#header_variable_btn1').css("display", "none");
            $('#text').css("display", "none");
            document.getElementById("txt_header_name").innerHTML = "";
            $('#image_category').css("display", "block");
        } else { // If selected the NONE
            $('#header_media').empty();
            $('#card-fileds').empty();
            $('#header_text').html('');
            $('#txt_header_name').css('border-color', '#28a745');
            document.getElementById("txt_header_name").innerHTML = "";
            $('.form-check-input').removeAttr('required');
            $('#txt_header_variable_1').css('border-color', '#28a745');
            $('#txt_header_variable_1').removeAttr('required');
            $('input[name="media_category"]').prop('checked', false);
            $('#text').css("display", "none");
            $('#image_category').css("display", "none");
            $('#header_variable_btn1').css("display", "none");
            $('#txt_header_variable_1').css("display", "none");
            $('.file_image_header').css("display", "none");
            document.getElementById("txt_header_name").value = "";
            document.getElementById("txt_header_variable_1").value = "";
        }
    });

    // Footer Buttons select the Call to action / Quick Reply
    $('#select_action').on('change', function() {
        var value = $(this).val();
        if (value == 'CALLTOACTION') { // If Selected the Call to Action  
            $('#card-fileds').empty();
            $('#card-fileds').append('<div><button type="button" title="Phone Call" style="width:80px;border-radius:20px;" class="btn btn-icon btn-success"><i class="fas fa-phone"></i> Call</button><span id="call_btn1"></span></div>')        
            $('#button_quickreply_text1').removeAttr('required');
            $(".add_reply").val('');
            document.getElementById("button_quickreply_text1").value = "";
            document.getElementById('add_another_button').style.pointerEvents = "auto";
            jQuery('.add_button_textbox').html('');

            document.getElementById('select_action3').value = "PHONE_NUMBER";
            document.getElementById('select_action1').value = "PHONE_NUMBER";
            $('#calltoaction').css("display", "none");
            $('#button_text').attr('required', 'required');
            $('#button_txt_phone_no').attr('required', 'required');
            $('#callaction').css("display", "block");
        } else if (value == 'QUICK_REPLY') { // If Selected the Quick Reply
            $('#card-fileds').empty();
            $('#card-fileds').append('<div><button type="button" title="Reply" style="width:80px;border-radius:20px;" class="btn btn-icon btn-warning"><i class="fas fa-reply"></i> Reply</button><span id="reply_btn1"></span></div>')
            $('#button_url_text').removeAttr('required');
            $('#website_url').removeAttr('required');
            $('#button_text').removeAttr('required');
            $('#button_txt_phone_no').removeAttr('required');
            jQuery('.add_button_textbox').html('');
            jQuery('.add_phone_content').html('');
            jQuery('.add_url_content').html('');

            document.getElementById("button_text").value = "";
            document.getElementById("button_txt_phone_no").value = "";
            document.getElementById("button_url_text").value = "";
            document.getElementById("website_url").value = "";
            $('#button_quickreply_text1').attr('required', 'required');
            $('#calltoaction').css("display", "block");
            $('#callaction').css("display", "none");
            $('#visit_website').css("display", "none");
        } else { // If selected the NONE
            $('#card-fileds').empty();
            $('#button_text').removeAttr('required');
            $('#button_txt_phone_no').removeAttr('required');
            $('#website_url').removeAttr('required');
            $('#button_url_text').removeAttr('required');
            $(".add_reply").val('');
            $('#button_quickreply_text1').removeAttr('required');
            document.getElementById("button_quickreply_text1").value = "";
            $("#add_phone_btn_btn").css({
                'cursor': '',
                'display': ''
            });
            $("#add_url_btn_btn").css({
                'cursor': '',
                'display': ''
            });

            document.getElementById('add_another_button').style.pointerEvents = "auto";
            document.getElementById('select_action3').value = "VISIT_URL";
            document.getElementById("button_text").value = "";
            document.getElementById("button_txt_phone_no").value = "";
            document.getElementById("button_url_text").value = "";
            document.getElementById("website_url").value = "";
            $('#callaction').css("display", "none");
            $('#calltoaction').css("display", "none");
            jQuery('.add_phone_content').html('');
            jQuery('.add_url_content').html('');
            jQuery('.add_button_textbox').html('');
            $('#visit_website').css("display", "none");
        }
    });

    // If selected the Call to Action, choose Call phone no / visit website
    $('#select_action3').on('change', function() {
        console.log("select_action3");
        var value = $(this).val();
        if (value == 'PHONE_NUMBER') { // If selected the Call phone no
            $('#card-fileds').empty();
            $('#card-fileds').append('<div><button type="button" title="Phone Call" style="width:80px;border-radius:20px;" class="btn btn-icon btn-success"><i class="fas fa-phone"></i> Call</button> <span id="call_btn2"></span></div>')
            document.getElementById("button_url_text").value = "";
            document.getElementById("website_url").value = "";
            document.getElementById("button_text").value = "";
            document.getElementById("button_txt_phone_no").value = "";
            $('#button_url_text').removeAttr('required');
            $('#website_url').removeAttr('required');
            $('#visit_website').css("display", "none");
            document.getElementById('select_action1').value = "PHONE_NUMBER";
            $('#callaction').css("display", "block");
        } else if (value == 'VISIT_URL') { // If selected the Visit Website
            $('#card-fileds').empty();
            $('#card-fileds').append('<div><button type="button" title="URL" style="width:80px;border-radius:20px;" class="btn btn-icon btn-info"><i class="fas fa-link"></i> URL</button><span id="url_btn1"></span></div>')
            $('#button_text').removeAttr('required');
            $('#button_txt_phone_no').removeAttr('required');
            document.getElementById("button_url_text").value = "";
            document.getElementById("website_url").value = "";
            document.getElementById("button_text").value = "";
            document.getElementById("button_txt_phone_no").value = "";
            document.getElementById('select_action1').value = "VISIT_URL";
            $('#callaction').css("display", "none");
            $('#visit_website').css("display", "block");
        } else { // If selected the NONE
            $('#card-fileds').empty();
            $('#button_url_text').removeAttr('required');
            $('#website_url').removeAttr('required');
            document.getElementById("button_url_text").value = "";
            document.getElementById("website_url").value = "";
            document.getElementById("button_text").value = "";
            document.getElementById("button_txt_phone_no").value = "";
            $('#callaction').css("display", "none");
            $('#calltoaction').css("display", "none");
            $('#visit_website').css("display", "none");
        }
    });

    // If Buttons second row added
    $('#select_action1').on('change', function() {
        console.log("select_action1");
        var value = $(this).val();
        if (value == 'PHONE_NUMBER') { // If phone number selected
            $('#card-fileds').empty();
            $('#card-fileds').append('<div><button type="button" title="Phone Call" style="width:80px;border-radius:20px;" class="btn btn-icon btn-success"><i class="fas fa-phone"></i> Call</button><span id="call_btn3"></span></div>')
            $('#button_url_text').removeAttr('required');
            $('#website_url').removeAttr('required');
            document.getElementById("button_url_text").value = "";
            document.getElementById("website_url").value = "";
            document.getElementById('select_action3').value = "PHONE_NUMBER";
            $('#visit_website').css("display", "none");
            $('#callaction').css("display", "block");
        }
        if (value == 'VISIT_URL') { // If Visit Website Selected
            $('#card-fileds').empty();
            $('#card-fileds').append('<div><button type="button" title="URL" style="width:80px;border-radius:20px;" class="btn btn-icon btn-info"><i class="fas fa-link"></i> URL</button><span id="url_btn2"></span></div>')
            document.getElementById("button_text").value = "";
            document.getElementById("button_txt_phone_no").value = "";
            $('#button_text').removeAttr('required');
            $('#button_txt_phone_no').removeAttr('required');
            $('#button_url_text').attr('required', 'required');
            $('#website_url').attr('required', 'required');
            document.getElementById('select_action3').value = "VISIT_URL";
            $('#add_another_button').css("visibility", "visible");
            $('#visit_website').css("display", "block");
            $('#callaction').css("display", "none");
            $('#calltoaction').css("display", "none");
        }
    });

    // While clicking the Submit button
    $(document).on("submit", "form#frm_compose_whatsapp", function(e) {
        flag = true;
        e.preventDefault();
        var txt_template_name = $('#txt_template_name').val();
        var lang = $('#lang').val();
        var list_items = $("input[type='radio'][name='categories']:checked").val();
        var textarea = $('#textarea').val().trim();
        var mediafile = $('#mediafile').val();
         if(textarea == ''){
                    $('#textarea').css('border-color', 'red');
                    flag = false;
                    e.preventDefault();
            }

        var selectElement = document.getElementById('select_id');
        var selectedValue = selectElement.value;
        var media_category = $('input[name="media_category"]:checked').attr('id');
        if (selectedValue == 'MEDIA') {
            if (media_category) {
                var media_category_id = media_category;
            } else {
                $("#id_error_display_submit").html("Please Select The Media category");
                flag = false;
            }
            if (document.getElementById("file_image_header").value == "") {
                $("#id_error_display_submit").html("Please Select The Media File");
                return false;
            }
        }


        var selectElement1 = document.getElementById('select_action');
        var selectedValue1 = selectElement1.value;
        console.log(selectedValue1);
        if (selectedValue1 == 'CALLTOACTION') {
            var selectElement = document.getElementById('select_action1');
            var selectedValue = selectElement.value;
            console.log(selectedValue);
            if (selectedValue == 'PHONE_NUMBER') {
                var user_mobile = $('#button_txt_phone_no').val();
                if (user_mobile.length != 10) {
                    $('#button_txt_phone_no').css('border-color', 'red');
                    $("#id_error_display_submit").html("Please enter a valid mobile number");
                    flag = false;
                    e.preventDefault();
                }
                if (!(user_mobile.charAt(0) == "9" || user_mobile.charAt(0) == "8" || user_mobile.charAt(0) ==
                        "6" || user_mobile.charAt(0) == "7")) {
                    $('#button_txt_phone_no').css('border-color', 'red');
                    $("#id_error_display_submit").html("Please enter a valid mobile number");
                    document.getElementById('button_txt_phone_no').focus();
                    flag = false;
                    e.preventDefault();
                }
            }
        }
        var selectElement2 = document.getElementById('select_action3');
        if (selectElement2) {
            var selectedValue2 = selectElement2.value;
        }
        var selectElement3 = document.getElementById('select_action4');
        if (selectElement3) {
            var selectedValue3 = selectElement3.value;
        }
        if (selectedValue2 == 'VISIT_URL' && selectedValue3 == 'PHONE_NUMBER') {
            var inputvalue = document.getElementsByName('button_txt_phone_no[]');
            if (inputvalue[1].value.length != 10) {
                $("#id_error_display_submit").html("Please enter a valid mobile number");
                flag = false;
                e.preventDefault();
            }
            if (!(inputvalue[1].value.charAt(0) == "9" || inputvalue[1].value.charAt(0) == "8" || inputvalue[1]
                    .value.charAt(0) == "6" || inputvalue[1].value.charAt(0) == "7")) {
                $("#id_error_display_submit").html("Please enter a valid mobile number");
                document.getElementById('button_txt_phone_no').focus();
                flag = false;
                e.preventDefault();
            }
        }
        var selectElement1 = document.getElementById('select_id');
        var selectedValue1 = selectElement1.value;
        console.log(selectedValue1);
        if (selectedValue1 == 'TEXT') {
            const txt_header_name1 = $('#txt_header_name').val().length;
            if (txt_header_name1) {

            } else {
                flag = false;
                e.preventDefault();
                $('#txt_header_name').css('border-color', 'red');
            }
        }

         var langSelect = document.getElementById('lang');
        var selectedValue = langSelect.value;

        if (selectedValue === "") {
                $('#lang').css('border-color', 'red');
               flag = false;
            event.preventDefault(); // Prevent form submission
             $("#id_error_display_submit").html("Please select a language.");
        } 
          
            const container = document.getElementById('add_variables');
            const inputs = container.querySelectorAll('input[name="txt_sample[]"]');
              let variable_flag = false;
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    input.classList.add('is-invalid'); // Highlight invalid input
                    variable_flag = true;
                } else {
                     variable_flag = false;
                    input.classList.remove('is-invalid'); // Remove error highlighting
                }
            });

            if (variable_flag) {
                 container.style.display = 'block'; // Ensure the container stays visible
                 $("#id_error_display_submit").html('Please fill all required fields!');
            }

        e.preventDefault();
        if (flag && (!variable_flag)) { // If no flag is red
            var fd = new FormData(this);
            var files = $('#file_image_header')[0].files;
            var text_area_value = $('.delete').text();
            var txt_header_name = $('#txt_header_name').val();
            if (files.length > 0) {
                fd.append('file', files[0]);
            }
            fd.append('txt_header_name', txt_header_name);
            // Submit the form into Ajax - ajax/whatsapp_call_functions.php
            $.ajax({
                type: 'post',
                url: "ajax/whatsapp_call_functions.php",
                dataType: 'json',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function() { // Before send to Ajax
                    $('#submit').attr('disabled', true);
                    $('.theme-loader').show();
                },
                complete: function() { // After complete the Ajax
                    $('#submit').attr('disabled', false);
                    $('.theme-loader').hide();
                },
                success: function(response) { // Succes
                    if (response.status == '0' || response.status == 0) { // Failed Status
                        $('#submit').attr('disabled', false);
                        $('.theme-loader').hide();
                        //$("#id_error_display_submit").html(response.msg);
                          response.msg === 'Invalid Token' ? (window.location.href = 'logout') :  $("#id_error_display_submit").html(response.msg);
                    } else if (response.status == 1 || response.status == '1') { // Success Status
                        $('#submit').attr('disabled', false);
                        $('.theme-loader').hide();
                        $("#id_error_display_submit").html("Template created successfully !!");
                        setInterval(function() {
                            window.location = 'template_list';
                            document.getElementById("frm_compose_whatsapp").reset();
                        }, 2000);
                    }
                    $('.theme-loader').hide();
                },
                error: function(response, status, error) { // Error
                    $('#submit').attr('disabled', false);
                    $("#id_error_display_submit").html(response.msg);
                    window.location = 'template_list';
                }
            })
        }
    });

    // FORM Clear value    
    function myFunction_clear() {
        document.getElementById("frm_compose_whatsapp").reset();
        window.location.reload();
    }


    // FORM preview value
    function preview_content() {
        var form = $("#frm_compose_whatsapp")[0]; // Get the HTMLFormElement from the jQuery selector
        var data_serialize = $("#frm_compose_whatsapp").serialize();
        var fd = new FormData(form); // Use the form element in the FormData constructor
        var txt_header_name = $('#txt_header_name').val();
        fd.append('txt_header_name', txt_header_name);

        $.ajax({
            type: 'post',
            url: "ajax/message_call_functions.php?preview_functions=preview_template",
            data: fd,
            processData: false, // Important: Prevent jQuery from processing the data
            contentType: false, // Important: Let the browser set the content type
            success: function(response) { // Success
                console.log("Response:", response);
                // If the response is JSON, you can also log it in a pretty format
                console.log("Pretty Response:", JSON.stringify(response, null, 2));
                if (response.status == 0) { // Failure Response
                    console.log(response.status);
                    $("#id_modal_display").html('No Data Available!!');
                } else if (response.status == 1) { // Success Response
                    console.log("elseif");
                    console.log(response.status);
                    $("#id_modal_display").html(response.msg);
                }
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

                 //Add another Url button
                var wrapper_url_button = $(".add_url_content");
                const add_another_url_button = document.getElementById('add_url_btn_btn');
                add_another_url_button.addEventListener('click', function handleClick() {
                    $('#card-fileds').append('<div><button type="button" title="Phone Call" style="width:80px;border-radius:20px;" class="btn btn-icon btn-success"><i class="fas fa-phone"></i> Call</button><span id="call_btn4"></span></div>')
                $(wrapper_url_button).append(
                    '</br><div class="col"><label for="lang1">Type of action</label><br><select id="select_action4" name="select_action4" class="form-control" tabindex="27"><option value="PHONE_NUMBER"> Phone Number</option> </select> </div> <div class="col"><label for="lang1">Button text</label><br> <input type="text" name="button_text[]" id="button_text_1" class="form-control" tabindex="28" maxlength="25" placeholder="Enter button name..." data-toggle="tooltip" data-placement="top" title="" data-original-title="Enter button name" required> </div>  <div class="col"> <label for="lang1">Country</label><br><select id="country_code" name="country_code" class="form-control" tabindex="29"><?
                    $replace_txt = '{ 
                    "user_id": "' . $_SESSION['yjucp_user_id'] . '"
                     }';
                       // Call the reusable cURL function
            $response = executeCurlRequest($api_url . "/sender_id/country_list", "GET", $replace_txt);
            // After got response decode the JSON result
             if (empty($response)) {
                   // Redirect to index.php if response is empty
                         header("Location: index");
                         exit(); // Stop further execution after redirect
                  }
                // After got response decode the JSON result
                $state = json_decode($response, true);
                if ($state1->num_of_rows > 0) {
                    // Looping the indicator is less than the num_of_rows.if the condition is true to continue the process.if the condition are false to stop the process
                    for ($indicator = 0; $indicator < $state1->num_of_rows; $indicator++) {
                        $shortname = $state1->report[$indicator]->shortname;
                        $phonecode = $state1->report[$indicator]->phonecode; ?> <option value= "<?= "+".$phonecode ?>" <? if ($shortname == 'IN') {
                      echo "selected";} ?>> <?=$shortname . "+" . $phonecode ?> </option><?php } } ?> </select></label></div><div class="col"><label for="lang1">Phone number</label><br><input type = "text" name = "button_txt_phone_no[]" onkeypress = "return event.charCode >= 48 && event.charCode <= 57" oninput = "validateInput_phone()" class = "form-control" tabindex = "30" maxlength = "10" placeholder = "Phone number" style = "padding: 10px 5px !important;" data - toggle = "tooltip" data-placement="top" title = "" data -original-title = "Phone number" required >');   
                    $("#add_url_btn_btn").css("display", "none");
                });

            // another PhoneButton
            var wrapper_button = $(".add_phone_content");
            const add_another_phn_button = document.getElementById('add_phone_btn_btn'); add_another_phn_button
            .addEventListener('click', function handleClick() {
                $('#card-fileds').append('<div><button type="button" title="URL" style="width:80px;border-radius:20px;" class="btn btn-icon btn-info"><i class="fas fa-link"></i> URL</button><span id="call_btn3"></span></div>')
                $(wrapper_button).append(
                    '<br><div class="col"><label for="lang1">Type of action</label><br><select id="select_action5" name="select_action5" class="form-control" tabindex="31"><option value="VISIT_URL" selected> Visit Website</option> </select> </div><div class="col"><label for="select_action2" >URL Button Name</label><br><input type="text" name="button_url_text[]" id="button_url_text_1" class="form-control" tabindex="32" maxlength="25" placeholder="Enter url name..." data-toggle="tooltip" data-placement="top" title="" data-original-title="Enter button name" required> </div> <div class="col"><label for="select_action2">Type</label><br> <select name="select_action2" id="select_action2" class="form-control"><option value="Static"> Static </option></select></div><div class="col"><label for="select_action2" >URL</label><br><input type="text" name="website_url[]" id="website_url" class="form-control" tabindex="33" maxlength="2000" placeholder="Enter url..." data-toggle="tooltip" data-placement="top" title=""data-original-title="Enter url" required></div>'
                    );
                $("#add_phone_btn_btn").css("display", "none");
            });

            // ADD ANOTHER REPLY BUTTON
            var wrapper1 = $(".add_button_textbox");
            const add_another_button = document.getElementById('add_another_button'); 
            count = 1;
            add_another_button.addEventListener('click', function handleClick() {
                count++;
                $(wrapper1).append(
                    `<br><input type="text" name="button_quickreply_text[]" id="button_quickreply_text${count}" class="form-control add_reply" placeholder="Enter Button Name" required/>`
                    );
                $('#card-fileds').append(`<div ><button type="button" title="Reply" style="width:80px;border-radius:20px;" class="btn btn-icon btn-warning"><i class="fas fa-reply"></i> Reply</button><span id="reply_btn${count}"></span></div>`)
                if (count == 3) {
                    document.getElementById('add_another_button').style.pointerEvents = "none";
                }
            });

            //TEXT AREA COUNT
            $("#textarea").keyup(function() {
            const text = $(this).val();
            $("#preview-body").text(text || 'Enter Body Content');
            $("#current_text_value").text(text.length);
                });

            //variable create
            const textarea = document.getElementById('textarea');
            var i = 1;
            var wrapper = $(".container1");
            var t = textarea.value;
            var txt_field_array = [];
            var text_field_length; textarea.addEventListener('keyup', updateResult); textarea.value += '';
            const btn = document.getElementById('btn'); btn.addEventListener('click', function handleClick() {
                if (i <= 12) {
                    $(wrapper).append('<input type="text" name="txt_sample[]" id="Variable' + i +
                        '" class="form-control" placeholder="Variable' + i + '" required/>');
                    txt_field_array.push(i.toString());
                    textarea.value += '{{' + i++ + '}}';
                    $('#alert_variable').css("display", "block");
                    $("#add_variables").css("display", "block");
                    console.log(txt_field_array);
                }
            });

            function updateResult() {
                var variable_count = [];
                var t = textarea.value;
                var s = t.split("{{");
                // Looping the j is less than the s.length.if the condition is true to continue the process and split the variable and push the variable count.if the condition are false to stop the process
                for (var j = 1; j < s.length; j++) {
                    var s1 = s[j].split("}}");
                    console.log(s1[0]);
                    variable_count.push(s1[0]);
                }
                if (variable_count.length == 0) {
                    $('#alert_variable').css("display", "none");
                    $("#add_variables").css("display", "none");
                }
                if (txt_field_array.length > variable_count.length) {
                    console.log(JSON.stringify(txt_field_array) + JSON.stringify(variable_count));
                    // console.log(JSON.stringify(variable_count));
                    var res = txt_field_array.filter(function(obj) {
                        return variable_count.indexOf(obj) == -1;
                    })
                    console.log(res[0] + "delected");
                    var item = res[0];
                    var index = txt_field_array.indexOf(item);
                    txt_field_array.splice(index, 1);
                    console.log(txt_field_array)
                    console.log(JSON.stringify(txt_field_array));
                    console.log(JSON.stringify(variable_count));
                    var element = document.getElementById("add_variables");
                    var child = document.getElementById('Variable' + res[0] + '');
                    element.removeChild(child);
                    console.log('Variable' + res[0] + '');
                }
            }
            // text area cannot split the variable in text area value - start
            $(function() {
                var tb = $("#textarea").get(0);
                $("#textarea").keydown(function(event) {
                    var start = tb.selectionStart;
                    var end = tb.selectionEnd;
                    var reg = new RegExp("({{.+?}})", "g");
                    var amatch = null;
                    while ((amatch = reg.exec(tb.value)) != null) {
                        var thisMatchStart = amatch.index;
                        var thisMatchEnd = amatch.index + amatch[0].length;
                        if (start <= thisMatchStart && end > thisMatchStart) {
                            event.preventDefault();
                            return false;
                        } else if (start > thisMatchStart && start < thisMatchEnd) {
                            event.preventDefault();
                            return false;
                        }
                    }
                });
            });
            // text area cannot split the variable in text area value - end

                //Header Text Count - HEADER & Variables clear & Add
                $("#txt_header_name").keyup(function() {
                    const headerNameValue = $(this).val();
                    $("#header_text").text(headerNameValue || '');
                    $("#count1").text(headerNameValue.length);
                    const variables = headerNameValue.match(/{{(.*?)}}/g) ||[]; // Extract variables using regex
                    const $headerVariable = $("#txt_header_variable_1");
                    const btn1 = document.getElementById('btn1');
                    if (variables.length === 0) {
                        btn1.style.pointerEvents = "auto";
                        $headerVariable.val("").css("display", "none");
                    }
                });
                //Header Text Variables Add
                function myFunction() {
                    $('#txt_header_name').val('{{1}}');
                    $('#txt_header_variable_1').attr('required', 'required');
                    $("#txt_header_variable_1").css("display", "block");
                    document.getElementById('btn1').style.pointerEvents = "none";
                }

                //Footer Text counts Get
                $("#txt_footer_name").keyup(function() {
                    const footerNameValue = $(this).val();
                    $("#count2").text(footerNameValue.length || '');
                    $("#footer_text").text(footerNameValue || 'Enter Footer Name...');
                })

          // Consolidated keyup event for dynamic button updates
$(document).on("keyup", "#button_text, #button_text_1, #button_url_text, #button_url_text_1, .add_reply", function () {
    const inputId = $(this).attr("id");  // Get the ID of the input
    const inputValue = $(this).val();      // Get the input value

    // Map input IDs to corresponding element IDs to update
    const mapping = {
        button_text: "call_btn1",
        button_text_1: "call_btn4",
        button_url_text: "url_btn2",
        button_url_text_1: "call_btn3"
    };

    if (mapping[inputId]) {
        $(`#${mapping[inputId]}`).html(inputValue);
    } else if ($(this).hasClass("add_reply")) {
        const count = inputId.split("text")[1]; // Extract number part after "text"
        if (count) {
            $(`#reply_btn${count}`).html(inputValue);
        }
    }
})

                function validateMediaFile() {
                   $("#header_media").css("display", "block");
                   $('#header_media').empty();
                    const file = $('#file_image_header')[0].files[0];
                    if (!file) return;
                     const { type: fileType, size: fileSize } = file;

                      const MAX_SIZE = { image: 1 * 1024 * 1024, video: 5 * 1024 * 1024, document: 5 * 1024 * 1024 };
                        const VALID_TYPES = {
                       image: /image\/(png|jpeg|jpg)/,
                       video: /video\/(mp4)/,
                       document: /application\/(pdf|msword|vnd.openxmlformats-officedocument.wordprocessingml.document)|text\/plain/
                           };

                      const isImage = VALID_TYPES.image.test(fileType);
                      const isVideo = VALID_TYPES.video.test(fileType);
                      const isDocument = VALID_TYPES.document.test(fileType);

                          // Validate type and size
                       if ((isImage && fileSize > MAX_SIZE.image) || 
                        (isVideo && fileSize > MAX_SIZE.video) || 
                        (isDocument && fileSize > MAX_SIZE.document) || 
                        (!isImage && !isVideo && !isDocument)) {
                          alert(isImage ? "Invalid image. Must be PNG, JPEG, or JPG and < 1 MB." :
                             isVideo ? "Invalid video. Must be MP4 < 5 MB." :
                               "Invalid document. Must be pdf,txt,docs and < 5 MB.");
                              $('#file_image_header').val('');
                                return;
                      }
                      // Create preview for image or video
                      if (isImage || isVideo){
                       $("#header_media").append(`<${isImage ? 'img' : 'video'} src="${URL.createObjectURL(file)}" style="max-width: 100%; margin-top: 10px;" ${isVideo ? 'controls' : ''}>`);
                      $('#header_media').removeAttr('style');
                       }
                     // Create a download link for documents
                     if (isDocument) {
                 // Assuming 'file' is already defined in the current scope
                   $("#header_media").append(`<button type="button" title="Download Document" class="btn btn-icon btn-success"><i class="fas fa-download"></i></button>`);

                // Attach the click event listener after appending the button
                $("#header_media button").on("click", function() {
                   const link = document.createElement('a');
                  link.href = URL.createObjectURL(file);
                   link.download = file.name;
                    link.click();
                    });

                   $('#header_media').css({
                  'left': '130px',       // Change the position
                  'position': 'relative' // Ensure it's displayed
                  });
                    }
                        }


                // TEMplate Name - Space
                $(function() {
                    $('#txt_template_name').on('keypress', function(e) {
                        if (e.which == 32) {
                            console.log('Space Detected');
                            return false;
                        }
                    });
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
