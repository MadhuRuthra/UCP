
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
  <title>Compose SMPP Approve ::
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


  <!-- CSS Libraries -->
  <link rel="stylesheet" href="libraries/assets/css/jquery.dataTables.min-1.css">
  <link rel="stylesheet" href="libraries/assets/css/searchPanes.dataTables.min-1.css">
  <link rel="stylesheet" href="libraries/assets/css/select.dataTables.min-1.css">
  <link rel="stylesheet" href="libraries/assets/css/colReorder.dataTables.min-1.css">
  <link rel="stylesheet" href="libraries/assets/css/buttons.dataTables.min-3.css">


  <link rel="stylesheet" type="text/css" href="libraries/assets/css/feather.css">

  <link rel="stylesheet" type="text/css" href="libraries/assets/css/font-awesome-n.min.css">
  <link rel="stylesheet" type="text/css" href="libraries/assets/css/widget.css">

</head>
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
          <? include("libraries/site_header.php"); ?>
          <? include("libraries/site_menu.php"); ?>
          <div class="pcoded-content">

            <div class="page-header card">
              <div class="row align-items-end">
                <div class="col-lg-8">
                  <div class="page-header-title">
                    <i class="feather icon-clipboard bg-c-blue"></i>
                    <div class="d-inline">
                      <h5>Compose SMPP Approve</h5>
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
                        <a href="">Compose SMPP Approve</a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>

            <div class="pcoded-inner-content">
              <!-- <P>main CONTENT</P> -->
              <div class="section-body">
                <div class="row">
                  <div class="col-12">
                    <div class="card">
                      <div class="card-body">
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

          <!-- Confirmation details content-->


          <div id="styleSelector">
          </div>
        </div>
      </div>
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
                  maxlength="50" title="Reason to Reject" tabindex="12" placeholder="Reason to Reject"
                  onkeydown="return /[a-z, ]/i.test(event.key)">
              </div>
            </div>
          </form>
          <p>Are you sure you want to reject ?</p>
        </div>
        <div class="modal-footer">
          <span class="error_display" id='id_error_reject' style="color: red;"></span>
          <button type="button" class="btn btn-danger reject_btn">Reject</button>
          <button type="button" class="btn btn-secondary cancel_btn" data-dismiss="modal">Cancel</button>
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


  <!-- Confirmation details content-->
  <div class="modal" tabindex="-1" role="dialog" id="approve_error">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="width: 400px;">
        <div class="modal-body">
          <button type="button" class="close" data-dismiss="modal" style="width:30px" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <div class="container" style="text-align: center;">
            <img alt="image" style="width: 50px; height: 50px; display: block; margin: 0 auto;" id="image_display">
            <br>
            <span id="split_error"></span>
          </div>
        </div>
        <div class="modal-footer" style="margin-right:40%; text-align: center;">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Okay</button>
        </div>
      </div>
    </div>
  </div>


  <script src="libraries/assets//js/xlsx.full.min.js"></script>



  <script src="libraries/assets/js/jquery.dataTables.min-1.js"></script>
  <script src="libraries/assets/js/dataTables.buttons.min-1.js"></script>
  <script src="libraries/assets/js/dataTables.searchPanes.min-1.js"></script>
  <script src="libraries/assets/js/dataTables.select.min-1.js"></script>


  <script>

    // On loading the page, this function will call
    $(document).ready(function () {
      find_approve_template();
      //setInterval(find_approve_template, 60000); // Every 1 min (60000), it will call
    });

    // start function document
    $(function () {
      $('.theme-loader').fadeOut("slow");
      init();
    });
    console.log("APProval PAge")
    // To list the rcs No from API
    function find_approve_template() {
      $.ajax({
        type: 'post',
        url: "ajax/display_functions.php?call_function=approve_smpp",
        dataType: 'html',
        success: function (response) {
          $("#id_approve_template").html(response);
        },
        error: function (response, status, error) { }
      });
    }


    function approve_popup(user_id, compose_rcs_id, total_mobileno_count, indicatori) {

      console.log(compose_rcs_id)
      console.log(total_mobileno_count)
      // Show the confirmation modal
      $('#approve-Modal').modal({ show: true });
      // Call remove_senderid function with the provided parameters
      //   $('#approve-Modal').find('.btn-success').on('click', function() {
      $('#approve-Modal').find('.btn-success').off().one('click', function () {
        $('#approve-Modal').modal({ show: false });
        func_save_phbabt(user_id, compose_rcs_id, indicatori);
      });
    }



    var compose_message_ids, user_ids, approve_statuss, indicatoris;
    //popup function
    function reject_status_popup(compose_message_id, user_id, approve_status, indicatori) {
      console.log(compose_message_id, user_id, approve_status, indicatori);
      compose_message_ids = compose_message_id, user_ids = user_id, approve_statuss = approve_status, indicatoris = indicatori;
      $('#reject-Modal').modal({ show: true });
    }


    // Event listener to clear input and error when modal is hidden
    $('#reject-Modal').on('hidden.bs.modal', function (e) {
      $("#id_error_reject").html("");       // Clear error message
      $('#reject_reason').val('');          // Clear the input field
    });

    // Reject button click event
    var reason;
    $('#reject-Modal').find('.btn-danger').on('click', function () {
      reason = $('#reject_reason').val();
      if (reason === "") {
        $("#id_error_reject").html("Please enter a reason to reject");
      } else if (reason.length < 4 || reason.length > 50) {
        $("#id_error_reject").html("Reason to reject must be between 4 and 50 characters.");
      } else {
        // Dismiss the modal if validation passes
        $('.reject_btn').attr("data-dismiss", "modal");
        $('#reject-Modal').modal('hide');
        change_status(compose_message_ids, user_ids, approve_statuss, indicatoris);
      }
    });

    // Clear data when clicking the "Cancel" button
    $('.cancel_btn').on('click', function () {
      $('#reject_reason').val('');           // Clear input field
      $("#id_error_reject").html('');        // Clear error message
    });

    // To save the Phone no id, business account id, bearer token
    function func_save_phbabt(user_id, compose_id, indicatori) {

      var send_code = "&user_id=" + user_id + "&compose_id=" + compose_id;
      $.ajax({
        type: 'post',
        url: "ajax/message_call_functions.php?tmpl_call_function=approve_compose_smpp" + send_code,
        dataType: 'json',
        beforeSend: function () {
          $('.theme-loader').show();
        },
        complete: function () {
          $('.theme-loader').hide();
        },
        success: function (response) {
          console.log('Success Response:', response);

          if (response.status == 1) {
            console.log("!!!!");
            console.log(response.msg);
            $('#image_display').attr('src', 'libraries/assets/png/success.png');
            // Update the value of the 'message' element
            //$('#split_error').text(response.msg);
            $('#split_error').text("Campaign started successfully");
            // Show the modal with the id 'approve_error'
            $('#approve_error').modal('show');
            setTimeout(function () {
              window.location = 'compose_smpp_approval';
            }, 2000);

          } else if (response.status == 403) {
            window.location = 'index';
          }

          else if (response.status == 0) {
            console.log("!!!!");
            console.log(response.msg);
            $('#image_display').attr('src', 'libraries/assets/png/failed.png');
            // Update the value of the 'message' element
            $('#split_error').text(response.msg);
            // Show the modal with the id 'approve_error'
            $('#approve_error').modal('show');
          }

          else {
            console.error('Error:', response.response_msg);
          }
        },
        error: function (xhr, status, error) {
          console.error('AJAX Error:', xhr.responseText); // Log the entire response
        }
      });
    }

    // Rejected status update
    function change_status(compose_message_id, user_id, approve_status, indicatori) {
      var send_code = "&compose_message_id=" + compose_message_id + "&approve_status=" + approve_statuss + "&selected_userid=" + user_id + "&reason=" + reason;
      $.ajax({
        type: 'post',
        url: "ajax/message_call_functions.php?tmpl_call_function=reject_campaign_smpp" + send_code,
        dataType: 'json',
        success: function (response) { // Success
          if (response.status == 1) { // Success Response
            $('#id_approved_lineno_' + indicatori).html('<a href="javascript:void(0)" class="btn disabled btn-outline-danger">Rejected</a>');
            setTimeout(function () {
              window.location = 'compose_smpp_approval';
            }, 2000);
          } else if (response.status == 403) {
            window.location = 'index';
          }
        },
        error: function (response, status, error) { // Error 
        }
      });
    }


    function clsAlphaNoOnly(e) { // Accept only alpha numerics, no special characters
      var key = e.keyCode;
      if ((key >= 65 && key <= 90) || (key >= 97 && key <= 122) || (key >= 48 && key <= 57) || (key == 32) || (key == 95)) {
        return true;
      }
      return false;
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

<!-- Mirrored from colorlib.com/polygon/admindek/default/form-elements-add-on.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 12 Dec 2019 16:09:13 GMT -->

</html>
