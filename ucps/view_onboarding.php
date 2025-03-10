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
// Check if the parameters are set
if (isset($_GET['usr'])) {
  // Get the user ID from the URL
  $user_id = $_GET['usr'];

  // To send the request to the API
  $replace_txt = '{
    "select_user_id": "' . $user_id . '"
  }';

}
		// Call the reusable cURL function
    $response = executeCurlRequest($api_url . "/list/view_user", "GET", $replace_txt);
// After got response decode the JSON result
$state1 = json_decode($response, false);
// To get the API response one by one data and assign to Session
if ($state1->response_status == 200) {
  // Looping the indicator is less than the count of response_result.if the condition is true to continue the process.if the condition are false to stop the process
  for ($indicator = 0; $indicator < count($state1->view_user); $indicator++) {
    $user_name = $state1->view_user[$indicator]->user_name;
    $user_email = $state1->view_user[$indicator]->user_email;
    $user_mobile = $state1->view_user[$indicator]->user_mobile;

    $user_type = $state1->view_user[$indicator]->user_type;
    $user_details = $state1->view_user[$indicator]->user_details;
    $user_status = $state1->view_user[$indicator]->user_status;
    $login_id = $state1->view_user[$indicator]->login_id;


  }
}
$user_name_value = $user_name;
?>
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from colorlib.com/polygon/admindek/default/compose_sms.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 12 Dec 2019 16:09:13 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <title>View Onboarding ::
    <?= $site_title ?>
  </title>


  <!--[if lt IE 10]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->

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
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="description" content="Admindek Bootstrap admin template optimized for better UI/UX." />
  <meta name="keywords" content="bootstrap, admin template, dashboard, responsive design" />
  <meta name="author" content="colorlib" />

  <link rel="icon" href="libraries/assets/png/favicon1.ico" type="image/x-icon">

  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Quicksand:500,700" rel="stylesheet">

  <link rel="stylesheet" type="text/css" href="libraries/assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="libraries/assets/css/waves.min.css">
  <link rel="stylesheet" type="text/css" href="libraries/assets/css/feather.css">
  <link rel="stylesheet" type="text/css" href="libraries/assets/css/themify-icons.css">
  <link rel="stylesheet" type="text/css" href="libraries/assets/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="libraries/assets/css/style.css">
  <link rel="stylesheet" type="text/css" href="libraries/assets/css/pages.css">


  <link rel="stylesheet" type="text/css" href="libraries/assets/css/feather.css">

  <link rel="stylesheet" type="text/css" href="libraries/assets/css/font-awesome-n.min.css">
  <link rel="stylesheet" type="text/css" href="libraries/assets/css/widget.css">

  <style>
    .form-container {
      background-color: #f8f9fa;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .label {
      font-weight: 600;
      color: #333;
    }

    .form-control {
      border-radius: 6px;
      padding: 10px;
    }

    .btn-success {
      background-color: #28a745;
      border-color: #28a745;
      transition: background-color 0.3s;
    }

    .btn-success:hover {
      background-color: #218838;
    }

    .error_display {
      color: red;
    }

    .card-header {
      background-color: #007bff;
      color: white;
      border-radius: 8px 8px 0 0;
      padding: 10px;
      text-align: center;
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
          <? include("libraries/site_header.php"); ?>
          <? include("libraries/site_menu.php"); ?>
          <div class="pcoded-content">

            <div class="page-header card">
              <div class="row align-items-end">
                <div class="col-lg-8">
                  <div class="page-header-title">
                    <i class="feather icon-clipboard bg-c-blue"></i>
                    <div class="d-inline">
                      <h5>View Profile</h5>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="page-header-breadcrumb">
                    <ul class=" breadcrumb breadcrumb-title">
                      <li class="breadcrumb-item">
                        <a href="dashboard"><i class="feather icon-home"></i></a>
                      </li>
                      <li class="breadcrumb-item"><a href="#!">View Onboarding</a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>

            <div class="pcoded-inner-content">

              <!-- Form Entry Panel -->
              <div class="section-body">
                <div class="row">
                  <div class="col-8 col-md-8 col-lg-8 offset-md-2">
                    <form class="md-float-material form-material" action="#" name="frm_edit_onboarding"
                      id='frm_edit_onboarding' class="needs-validation" novalidate="" enctype="multipart/form-data"
                      method="post">
                      <div class="card" style="padding: 10px;">
                        <h5 class="text-center">
                          <i class="icofont icofont-sign-in"></i> Basic Information
                        </h5>
                        <table class="table table-bordered table-striped mt-3">
                          <tbody>
                            <!-- Client Name -->
                            <tr>

                              <th>Client Name <span style="color:#FF0000">*</span></th>
                              <td><?= htmlspecialchars($user_name_value) ?></td>
                            </tr>

                            <!-- User Mobile -->
                            <tr>
                              <th>User Mobile <span style="color:#FF0000">*</span></th>
                              <td><?= htmlspecialchars($user_mobile) ?></td>
                            </tr>

                            <!-- User Email -->
                            <tr>
                              <th>User Email ID <span style="color:#FF0000">*</span></th>
                              <td><?= htmlspecialchars($user_email) ?></td>
                            </tr>

                            <!-- Login ID -->
                            <tr>
                              <th>Login ID <span style="color:#FF0000">*</span></th>
                              <td><?= htmlspecialchars($login_id) ?></td>
                            </tr>

                            <!-- Remarks (if any) -->
                            <?php if (!empty($rejected_comments)) { ?>
                              <tr>
                                <th>Remarks</th>
                                <td><b><?= htmlspecialchars($rejected_comments) ?></b></td>
                              </tr>
                            <?php } ?>
                          </tbody>
                        </table>

                        <div class="row mt-4">
                          <div class="col-md-12 text-center">
                            <span class="error_display" id="id_error_display_onboarding"></span>
                          </div>
                        </div>

                        <!-- Hidden Submit Button -->
                        <!-- <div class="row mt-3 text-center"> -->
                        <div class="col-md-12 text-center">
                          <input type="hidden" name="call_function" id="call_function" value="edit_onboarding" />
                          <div class="col-md-12" style="text-align:center">
                            <input type="hidden" class="form-control" name='txt_user' id='txt_user'
                              value='<?= $_REQUEST["usr"] ?>' />
                            <input type="hidden" class="form-control" name='call_function' id='call_function'
                              value='apprej_onboarding' />
                            <?php
                            // Check if the 'action' parameter is set in the URL and its value is 'viewrep'
                            if ($_GET['action'] == 'active') { ?>
                              <button type="button" onclick="approve_usr_popup()"
                                style="width:150px;margin-left:auto;margin-right:auto;" tabindex="30"
                                title="Active Account"
                                class="btn btn-success btn-md btn-block waves-effect waves-light text-center ">Active
                                Account</button>
                              <input type="hidden" class="form-control" name='user_status' id='user_status' value='A' />
                            <? } else if ($_GET['action'] == 'reject') { ?>
                                <button onclick="reject_usr_popup()" type="button" title="Delete Account"
                                  style="width:150px;margin-left:auto;margin-right:auto;margin-top: 0px;" tabindex="31"
                                  class="btn btn-danger btn-md btn-block waves-effect waves-light text-center ">Delete
                                  Account</button>
                                <input type="hidden" class="form-control" name='user_status' id='user_status' value='D' />
                            <? } else if ($_GET['action'] == 'suspend') { ?>
                                  <button onclick="suspend_usr_popup()" type="button" title="Suspend Account"
                                    style="width:150px;margin-right:auto;margin-left:auto;margin-top: 0px;" tabindex="31"
                                    class="btn btn-danger btn-md btn-block waves-effect waves-light text-center ">Suspend</button>
                                  <input type="hidden" class="form-control" name='user_status' id='user_status' value='S' />
                            <? } ?>
                          </div>
                        </div>
                        <!-- </div> -->

                      </div>
                    </form>
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
              <label class="col-sm-3 col-form-label">Reason<label style="color:#FF0000">*</label></label>
              <div class="col-sm-9">
                <input class="form-control form-control-primary" type="text" name="txt_remarks" id="txt_remarks"
                  maxlength="100" pattern="[a-zA-Z0-9 -_]+" onkeypress="return clsAlphaNoOnly(event)" value=""
                  title="Reason to De" tabindex="12" placeholder="Reason to Reject">
              </div>
            </div>
          </form>
          <p>Are you sure you want to Delete ?</p>
        </div>
        <div class="modal-footer">
          <span class="error_display common_information" id='id_error_reject' style="color:red;"></span>
          <button type="button" class="btn btn-success reject_btn">Delete</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>


  <!-- Confirmation details content Approve-->
  <div class="modal" tabindex="-1" role="dialog" id="suspend-Modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Confirmation details</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to Suspend Account ?</p>
        </div>
        <div class="modal-footer">
          <span class="error_display common_information" id='id_error_approve'></span>
          <button type="button" class="btn btn-success">Suspend</button>
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
          <p>Are you sure you want to Active Account ?</p>
        </div>
        <div class="modal-footer">
          <span class="error_display common_information" id='id_error_approve'></span>
          <button type="button" class="btn btn-success approve_cls">Active</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>

  <script src="libraries/assets//js/xlsx.full.min.js"></script>
  <script>
    // Popup function for reject action
    function reject_usr_popup() {
      $('#reject-Modal').modal({ show: true });
    }

    // Capture click on reject button inside the modal
    $('#reject-Modal').find('.reject_btn').on('click', function () {
      $('#reject-Modal').modal({ show: false });

      let txt_remarks = $('#txt_remarks').val().trim(); // Capture txt_remarks value
      console.log("Reject Reason->", txt_remarks);

      let flag = true;
      if (txt_remarks === "") {
        $('#txt_remarks').css('border-color', 'red'); // Highlight border if empty
        flag = false;
        $("#id_error_reject").html("Please enter reason to reject");
      } else if(txt_remarks.length < 4 || txt_remarks.length > 50){
             $('#txt_remarks').css('border-color', 'red'); // Highlight border if empty
        flag = false;
       $("#id_error_reject").html("Reason to reject must be between 4 and 50 characters.");
       }else {
        account_status(txt_remarks); // Pass txt_remarks to account_status function
      }
    });

    // Validate input to allow only alphanumeric characters
    function clsAlphaNoOnly(e) {
      var key = e.keyCode;
      if ((key >= 65 && key <= 90) || (key >= 97 && key <= 122) || (key >= 48 && key <= 57) || key === 32 || key === 95) {
        return true;
      }
      return false;
    }

    // Pass txt_remarks as parameter to the account_status function
    function account_status(txt_remarks) {
      let fd = $("#frm_edit_onboarding").serialize(); // Serialize form data
      fd += '&txt_remarks=' + encodeURIComponent(txt_remarks); // Append txt_remarks

      console.log("Form Data->", fd);

      $.ajax({
        type: 'post',
        url: "ajax/call_functions.php",
        dataType: 'json',
        data: fd,
        beforeSend: function () {
          $('#reject_btn').attr('disabled', true);
          $('#load_page').show();
        },
        complete: function () {
          $('#reject_btn').attr('disabled', false);
          $('#load_page').hide();
        },
        success: function (response) {
          if (response.status === '2' || response.status === '0') {
            $('#reject_btn').attr('disabled', false);
            alert(response.msg);
          } else if (response.status === 1) {
            $('#reject_btn').attr('disabled', true);
            alert(response.msg);
            window.location = "manage_users_list";
          }
        },
        error: function (response, status, error) {
          $('#reject_btn').attr('disabled', false);
          $("#common_information").html(response.msg);
        }
      });
    }

    // Modal popups for other actions (approve, suspend, etc.)
    function approve_usr_popup() {
      $('#approve-Modal').modal({ show: true });
    }

    $('#approve-Modal').find('.btn-success').on('click', function () {
      $('#approve-Modal').modal({ show: false });
      account_status('');
    });

    function suspend_usr_popup() {
      $('#suspend-Modal').modal({ show: true });
    }

    $('#suspend-Modal').find('.btn-success').on('click', function () {
      $('#suspend-Modal').modal({ show: false });
      account_status('');
    });

    function make_reseller_popup() {
      $('#reseller-Modal').modal({ show: true });
    }

    $('#reseller-Modal').find('.btn-success').on('click', function () {
      $('#reseller-Modal').modal({ show: false });
      account_status('');
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

<!-- Mirrored from colorlib.com/polygon/admindek/default/compose_sms.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 12 Dec 2019 16:09:13 GMT -->

</html>
