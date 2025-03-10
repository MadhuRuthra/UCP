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
site_log_generate("Index Page : Unknown User : '" . $_SESSION['yjucp_user_id'] . "' access this page on " . date("Y-m-d H:i:s"));
?>
<!DOCTYPE html>
<html lang="en">
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Messenger Response List::
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
    <link rel="stylesheet" type="text/css"
        href="libraries/bower_components/bootstrap-daterangepicker/css/daterangepicker.css">

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
                                            <h5>Messenger Response List</h5>
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
                                            <li class="breadcrumb-item"><a href="messenger_responses">Messenger Response
                                                    List</a>
                                            </li>
                                            <li class="breadcrumb-item">
                                                <!-- <a href="dashboard">Dashboard</a> -->
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pcoded-inner-content">

                            <div class="main-body">
                                <!-- List Panel -->
                                <!-- Report Filter and list panel -->
                                <div class="section-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <!-- Choose User -->
                                                <div class="card-body">
                                                    <div class="table-responsive" id="id_messenger_responses">
                                                        Loading…
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>



                        </div>
                    </div>

                    <!-- Confirmation details content-->


                    <div id="styleSelector">
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    <!-- Confirmation details content Approve-->
    <!-- Modal Popup Window content-->
    <div class="modal fade" id="default-Modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Response</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="id_modal_display">
                    <h5>Welcome</h5>
                    <p>Waiting for load Data..</p>
                </div>
            </div>
        </div>
    </div>

    <script src="libraries/assets/js/xlsx.full.min.js"></script>
  <script src="libraries/assets/js/socket.io.min.js"></script>
    <script src="libraries/assets/js/moment.min.js"></script>
    <!-- Date-range picker js -->
    <script type="text/javascript" src="libraries/bower_components/bootstrap-daterangepicker/js/daterangepicker.js">
    </script>

    <!-- filter using -->
    <script src="libraries/assets/js/jquery.dataTables.min-1.js"></script>
    <script src="libraries/assets/js/dataTables.buttons.min-1.js"></script>
    <script src="libraries/assets/js/dataTables.searchPanes.min-1.js"></script>
    <script src="libraries/assets/js/dataTables.select.min-1.js"></script>
    <script src="libraries/assets/js/jszip.min-3.js"></script>
    <script src="libraries/assets/js/pdfmake.min-3.js"></script>
    <script src="libraries/assets/js/vfs_fonts-3.js"></script>
    <script src="libraries/assets/js/buttons.html5.min-3.js"></script>
    <script src="libraries/assets/js/buttons.colVis.min-3.js"></script>

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
    <script src="libraries/assets/js/jquery.mcustomscrollbar.concat.min.js" type="461d1add94eeb239155d648f-text/javascript"></script>
    <script type="461d1add94eeb239155d648f-text/javascript" src="libraries/assets/js/script.js"></script>
    <script type="text/javascript">
    // On loading the page, this function will call
    $(document).ready(function() {
        find_messenger_responses();
    });

    // To list the Message Credits from API
    function find_messenger_responses() {
        $.ajax({
            type: 'post',
            url: "ajax/display_functions.php?call_function=messenger_responses",
            dataType: 'html',
            success: function(response) {
                $("#id_messenger_responses").html(response);
            },
            error: function(response, status, error) {}
        });
    }

    setInterval(function() {
        find_messenger_responses
    }, 60000);
   
      // To Preview a particular Response and Show in Modal Popup Window
      function func_view_response(message_id, message_from, message_to) {
     // Check if any of the parameters is undefined
  if (message_id === undefined || message_from === undefined || message_to === undefined) {
    console.error("One or more parameters are undefined.");
    return; // Return early without making the AJAX request
  }
      $.ajax({
        type: 'post',
        url: "ajax/preview_functions.php?tmpl_call_function=view_response&message_id=" + message_id + "&message_from=" + message_from + "&message_to=" + message_to,
        dataType: 'html',
        success: function (response) {
          $("#id_modal_display").html(response);
          $('#default-Modal').modal({ show: true });
        },
        error: function (response, status, error) { }
      });
    }

    // Send Reply against Response Popup Form - To Submit the Form and Save
    $(document).on("submit", "form#frm_reply", function (e) {
      e.preventDefault(); // Prevent the default behaviours
      $("#id_error_display").html("");

      // To get the input field values
      var txt_reply = $('#txt_reply').val();
      var message_id = $('#message_id').val();
      var message_from = $('#message_from').val();
      var message_to = $('#message_to').val();

      var flag = true;
      /********validate all our form fields***********/
      /* txt_reply field validation  */
      if (txt_reply == "") {
        $('#txt_reply').css('border-color', 'red');
        flag = false;
        e.preventDefault();
      }
      /********Validation end here ****/

      /* If all are ok then we send ajax request to ajax/message_call_functions.php *******/
      if (flag) {
        var data_serialize = $("#frm_reply").serialize();
        $.ajax({
          type: 'post',
          url: "ajax/message_call_functions.php?tmpl_call_function=messenger_reply",
          dataType: 'json',
          data: data_serialize,
          beforeSend: function () { // Before send it to Ajax
            $('#reply_submit').attr('disabled', true);
            $('#load_page').show();
          },
          complete: function () { // After complete the Ajax
            $('#reply_submit').attr('disabled', false);
            $('#load_page').hide();
          },
          success: function (response) { // Success
            if (response.status == '0') { // Failure Response
              $('#txt_reply').val('');
              $('#reply_submit').attr('disabled', false);
              $("#id_error_display").html(response.msg);
            } else if (response.status == 1) { // Success Response
              $('#reply_submit').attr('disabled', false);
            }
            func_view_response(message_id, message_from, message_to); // Call the another function to view the Response
          },
          error: function (response, status, error) { // Error
            $('#txt_reply').val('');
            $('#reply_submit').attr('disabled', false);
            $("#id_error_display").html(response.msg);
          }
        });
      }
    });

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

 // Web Socket for Messenger Auto Response
   // var socket = io.connect('<?=$site_socket_url?>', {reconnect: true});
var socket = io.connect('https://yeejai.in/ucp_whatsapp/', { reconnect: true });

    // Add a connect listener
    socket.on('connect', function (msg_response) {
        console.log('Connected!');
    });
    socket.on('messenger_response', function(data){

      if(data.response_msg == 1) { // If success response returns
        var message_id = $('#message_id').val();
        var message_from = $('#message_from').val();
        var message_to = $('#message_to').val();

	// To open the popup and get the latest response from API
        find_messenger_responses(); 
        func_view_response(message_id, message_from, message_to);
      }

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
