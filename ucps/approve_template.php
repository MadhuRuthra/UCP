<?php
session_start();
error_reporting(0);
// Include configuration.php
include_once('api/configuration.php');
extract($_REQUEST);

if ($_SESSION['yjucp_user_id'] == "") { ?>
<script>
window.location = "index";
</script>
<?php exit();
}
site_log_generate(" Approve Template Page : Unknown User : '" . $_SESSION['yjucp_user_id'] . "' access this page on " . date("Y-m-d H:i:s"));
?>
<!DOCTYPE html>
<html lang="en">

<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Approve Template::
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

    <link rel="stylesheet" type="text/css" href="libraries/assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="libraries/assets/css/pages.css">


    <!-- CSS Libraries -->
    <link rel="stylesheet" href="libraries/assets/css/jquery.dataTables.min-1.css">
    <link rel="stylesheet" href="libraries/assets/css/searchPanes.dataTables.min-1.css">
    <link rel="stylesheet" href="libraries/assets/css/select.dataTables.min-1.css">
    <link rel="stylesheet" href="libraries/assets/css/colReorder.dataTables.min-1.css">
    <link rel="stylesheet" href="libraries/assets/css/buttons.dataTables.min-3.css">


    <link rel="stylesheet" type="text/css" href="libraries/assets/css/feather.css">

    <link rel="stylesheet" type="text/css" href="libraries/assets/css/font-awesome-n.min.css">
    <link rel="stylesheet" type="text/css" href="libraries/assets/css/widget.css">
    <!-- Date-range picker css  -->
   <link rel="stylesheet" type="text/css" href="libraries/bower_components/bootstrap-daterangepicker/css/daterangepicker.css">
    <style>
    .theme-loader {
        display: block;
        position: absolute;
        top: 0;
        left: 0;
        z-index: 100;
        width: 100%;
        height: 100%;
        background-color: rgba(192, 192, 192, 0.5);
        background-image: url("assets/img/loader.gif");
        background-repeat: no-repeat;
        background-position: center;
    }

   #body_content {
        word-wrap: break-word;
        white-space: pre-wrap; /* Preserves newlines and wraps text */
        overflow-wrap: break-word; /* Break words if needed */
        max-width: 100%; /* Ensure content doesn't overflow */
    }
    .view_table td {
        word-wrap: break-word;
        white-space: pre-wrap;
        overflow-wrap: break-word;
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
                                            <h5>Approve Template</h5>
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
                                                <a href="">Approve Template</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pcoded-inner-content">

                            <div class="main-body">
                                <!-- List Panel -->
                                <!-- Report List Panel -->
                                <div class="section-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <!-- Choose User -->
                                                <div class="card-body">
                                                    <form method="post">
                                                        <div id="table-1_filter" class="dataTables_filter">                                               
                                                        </div>
                                                    </form>
                                                    <div class="table-responsive" id="id_approve_template">
                                                        Loading..
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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

        <!-- Modal Popup window content-->
        <div class="modal fade" id="default-Modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document" style=" max-width: 50% !important;">
                        <div class="modal-content">
                                <div class="modal-header">
                                        <h4 class="modal-title" id="template_name"></h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                        </button>
                                </div>
                                <div class="modal-body" id="id_modal_display">
                                </div>
                                <div class="modal-footer">
                                        <button type="button" class="btn btn-success waves-effect " data-dismiss="modal">Close</button>
                                </div>
                        </div>
                </div>
        </div>

  <!-- Confirmation details content Reject-->
  <div class="modal" tabindex="-1" role="dialog" id="reject-Modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Confirmation details</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="needs-validation" novalidate="" id="frm_sender_id" name="frm_sender_id" action="#" method="post"
            enctype="multipart/form-data">

            <div class="form-group mb-2 row">
              <label class="col-sm-3 col-form-label">Reason <label style="color:#FF0000">*</label></label>
              <div class="col-sm-9">
                <input class="form-control form-control-primary" type="text" name="reject_reason" id="reject_reason"
                  maxlength="50" title="Reason to Reject" tabindex="12" placeholder="Reason to Reject" onkeydown="return /[a-z, ]/i.test(event.key)">
              </div>
            </div>
          </form>
          <p>Are you sure you want to reject ?</p>
        </div>
        <div class="modal-footer">
          <span class="error_display" id='id_error_reject' style="color:red;"></span>
          <button type="button" class="btn btn-danger">Reject</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Confirmation details content Approve-->
  <div class="modal" tabindex="-1" role="dialog" id="approve-Modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Confirmation details</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to approve ?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" data-dismiss="modal">Approve</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>

  <script src="libraries/assets//js/xlsx.full.min.js"></script>

<script src="libraries/assets/js/moment.min.js"></script>
<!-- Date-range picker js -->
<script type="text/javascript" src="libraries/bower_components/bootstrap-daterangepicker/js/daterangepicker.js">
</script>

<script src="libraries/assets/js/jquery.dataTables.min-1.js"></script>
<script src="libraries/assets/js/dataTables.buttons.min-1.js"></script>
<script src="libraries/assets/js/dataTables.searchPanes.min-1.js"></script>
<script src="libraries/assets/js/dataTables.select.min-1.js"></script>

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

<script>

    // On loading the page, this function will call
    $(document).ready(function () {
      find_approve_template();
    });
    // start function document
    $(function () {
      $('.theme-loader').fadeOut("slow");
      init();
    });

    // To list the Whatsapp No from API
    function find_approve_template() {
      $.ajax({
        type: 'post',
        url: "ajax/display_functions.php?call_function=approve_template",
        dataType: 'html',
        success: function (response) {
          $("#id_approve_template").html(response);
        },
        error: function (response, status, error) { }
      });
    }
    setInterval(find_approve_template, 60000); // Every 1 min (60000), it will call

    var unique_templateid, templatestatus, table_id;
    //popup function
    function approve_popup(unique_template_id, template_status, indicatori) {
      unique_templateid = unique_template_id, templatestatus = template_status, table_id = indicatori;
      $('#approve-Modal').modal({ show: true });
      // Call remove_senderid function with the provided parameters
    }

    $('#approve-Modal').find('.btn-success').on('click', function () {
      $('#approve-Modal').modal({ show: false });
      func_save_phbabt(unique_templateid, templatestatus, table_id);
    });


    // To save the Phone no id, business account id, bearer token
    function func_save_phbabt(unique_template_id, template_status, indicatori) {
      var send_code = "&unique_template_id=" + unique_template_id + "&template_status=" + template_status;
      $.ajax({
        type: 'post',
        url: "ajax/message_call_functions.php?tmpl_call_function=approve_template" + send_code,
        dataType: 'json',
        beforeSend: function () {
          $('.theme-loader').show();
        },
        complete: function () {
          $('.theme-loader').hide();
        },
        success: function (response) { // Success
          if (response.status = 0) {
            $('#id_approved_lineno_' + indicatori).html('<a href="javascript:void(0)" class="btn disabled btn-outline-success">' + response.msg + '</a>');
          } else { // Success
            $('#id_approved_lineno_' + indicatori).html('<a href="javascript:void(0)" class="btn disabled btn-outline-success">Success</a>');
            setTimeout(function () {
              window.location = 'approve_template';
            }, 3000); // Every 3 seconds it will check
            $('.theme-loader').hide();
          }
        },
        error: function (response, status, error) { // Error
        }
      });
    }

    var unique_templateid, approvestatus, table_id;
    //popup function
    function change_status_popup(unique_template_id, approve_status, indicatori) {
      unique_templateid = unique_template_id, approvestatus = approve_status, table_id = indicatori
      $('#reject-Modal').modal({ show: true });
    }

    $('#reject-Modal').on('hidden.bs.modal', function (e) {
      $("#id_error_reject").html("");
      $('#reject_reason').val('');
    });


    // Call remove_senderid function with the provided parameters
    $('#reject-Modal').find('.btn-danger').on('click', function () {
      var reason = $('#reject_reason').val().trim();
      //console.log(reason);
      if (reason == "") {
        $('#reject-Modal').modal({ show: true });
        $("#id_error_reject").html("Please enter reason to reject");
      }else if (reason.length < 4 || reason.length > 50) {
        $('#reject-Modal').modal({ show: true });
        $("#id_error_reject").html("Reason to reject must be between 4 and 50 characters.");
      }
      else {
        $('#reject-Modal').modal({ show: false });
        var send_code = "&unique_template_id=" + unique_templateid + "&template_status=" + approvestatus + "&reject_reason=" + reason;
        $.ajax({
          type: 'post',
          url: "ajax/message_call_functions.php?tmpl_call_function=approve_template" + send_code,
          dataType: 'json',
          success: function (response) { // Success
            if (response.status == 1) { // Success Response
              $('#reject-Modal').modal({ show: close });
              $('#id_approved_lineno_' + table_id).html('<a href="javascript:void(0)" class="btn disabled btn-outline-danger">Rejected</a>');
              setTimeout(function () {
                window.location = 'approve_template';
              }, 2000);
            }
          },
          error: function (response, status, error) { // Error 
          }
        });
      }
    });


        function call_getsingletemplate(tmpl_name, wht_tmpl_url, wht_bearer_token, indicatori, message, media_url, media_type,
                body_variable_count) {
                $("#slt_whatsapp_template_single").html("");
                //console.log("Message before parsing:", message); // Inspect the message
                try {
                        // Display template name
                        $("#template_name").html(`<span style="color:red;">Template Name: </span> ${tmpl_name.split("!")[0]}<br>`);

                        // Clean the message (remove extra characters, quotes, etc.)
                        var cleanedMessage = message.replace(/^"|"$/g, '').replace(/[\n\r\t]/g, ''); // Clean newline and tab characters
                        var parsedMessage = JSON.parse(cleanedMessage); // Parse the JSON string into an object

                        // Create a table to display the records
                        var tableContent =
                                '<table class="table table-bordered view_table"><thead><tr><th>Type</th><th colspan="2">Text</th></tr></thead><tbody>';

                        parsedMessage.forEach(item => {
                                if (item.type === "BUTTONS" && Array.isArray(item.buttons)) {
                                        // Loop through buttons and display button type and text
                                        item.buttons.forEach(button => {
                                                if (button.type === "URL") {
                                                        // If the button type is URL, create an anchor tag with href
                                                        tableContent +=
                                                                `<tr><td>${item.type}</td><td><b style="font-weight: 700;">TYPE: </b>URL</td><td><b style="font-weight: 700;">Value: </b><a href="${button.url}" target="_blank">${button.text} link</a></td></tr>`;
                                                } else {
                                                        // Otherwise, display as normal
                                                        tableContent +=
                                                                `<tr><td>${item.type}</td><td><b style="font-weight: 700;">TYPE: </b>${button.type}</td><td><b style="font-weight: 700;">Value: </b>${button.text}</td></tr>`;
                                                }

                                        });
                                } else if (item.type === "FOOTER") {
                                        // Handle footer type
                                        tableContent += `<tr><td>${item.type}</td><td colspan="2">${item.text}</td></tr>`;
                                } else if (item.type === "HEADER" && item.format && item.example && item.example.header_handle) {
                                        // Handle header type or media information
                                        tableContent +=
                                                `<tr><td>${item.type}</td><td colspan="2"><a href="${item.example.header_handle[0]}" target="_blank">${item.format} LINK</a></td></tr>`;
                                } else if (item.type === "HEADER") {
                                        // Handle header type or media information
                                        tableContent +=
                                                `<tr><td>${item.type}</td><td colspan="2">${item.text}</td></tr>`;
                                } 
                                else if (item.type === "BODY") {
                                      tableContent += `<tr><td>${item.type}</td><td colspan="2" id="body_content" style="word-wrap: break-word; white-space: pre-wrap;">${item.text}</td></tr>`;

                                };
															})
                        // Close the table tag
                        tableContent += '</tbody></table>';

                        // Insert the table content into the modal display
                        $("#id_modal_display").html(tableContent);

                        // Show the modal
                        $('#default-Modal').modal({
                                show: true
                        });
                } catch (error) {
                        console.error("Error parsing JSON:", error.message);
                }
        }


  // To Show Datatable with Export, search panes and Column visible
  $('#table-1').DataTable({
        dom: 'Bfrtip',
        colReorder: true,
        buttons: [{
            extend: 'copyHtml5',
            exportOptions: {
                columns: [0, ':visible']
            }
        }, {
            extend: 'csvHtml5',
            exportOptions: {
                columns: ':visible'
            }
        }, {
            extend: 'pdfHtml5',
            exportOptions: {
                columns: ':visible'
            }
        }, {
            extend: 'searchPanes',
            config: {
                cascadePanes: true
            }
        }, 'colvis'],
        columnDefs: [{
            searchPanes: {
                show: false
            },
            targets: [0]
        }]
    });
    </script>

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

