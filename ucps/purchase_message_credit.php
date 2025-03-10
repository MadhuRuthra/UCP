<?php
session_start(); // start session
error_reporting(0); // The error reporting function

include_once('api/configuration.php'); // Include configuration.php
include_once('api/send_request.php');
extract($_REQUEST); // Extract the request

// If the Session is not available redirect to index page
if ($_SESSION['yjucp_user_id'] == "") { ?>
  <script>window.location = "index";</script>
  <?php exit();
}

$site_page_name = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME); // Collect the Current page name
site_log_generate("Purchase Message Credit Page : User : " . $_SESSION['yjucp_user_name'] . " access the page on " . date("Y-m-d H:i:s"));
// Retrieve parameters with default values if they are missing
$status = isset($_GET['status']) ? $_GET['status'] : 'unpaid';
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : '';
$amount = isset($_GET['amount']) ? $_GET['amount'] : 0;

// Use these values to set defaults or for display

// Check if the parameters are set
if (isset($_GET['slot_id'], $_GET['usr_vlu'], $_GET['cnt_vlu'], $_GET['usrsmscrd_id'], $_GET['usr_credit_id'])) {
  // Extract the parameters from the GET request
  $slot_id = $_GET['slot_id'];
  $usr_vlu = $_GET['usr_vlu'];
  $cnt_vlu = $_GET['cnt_vlu'];
  $usrsmscrd_id = $_GET['usrsmscrd_id'];
  $usr_credit_id = $_GET['usr_credit_id'];
} else {
}

?>

<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from colorlib.com/polygon/admindek/default/compose_sms.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 12 Dec 2019 16:09:13 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <title>Purchase Message Credit ::
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
                      <h5>Purchase Message Credit</h5>
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
                        <a href="">Purchase Message Credit</a>
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

                            <div class="col-12 col-md-6 col-lg-6 offset-3">
                              <div class="card">
                                <form class="needs-validation" novalidate="" id="frm_message_credit"
                                  name="frm_message_credit" action="#" method="post" enctype="multipart/form-data">
                                  <div class="card-body">

                                    <div class="form-group mb-2 row" style="display: none;">
                                      <label class="col-sm-3 col-form-label">Parent User</label>
                                      <div class="col-sm-9">
                                        <!-- Parent User Panel -->
                                        <input type="text" name="txt_parent_user" id='txt_parent_user'
                                          class="form-control" data-toggle="tooltip" readonly data-placement="top"
                                          required="" data-original-title="Parent User" tabindex="1"
                                          value="<?= $_SESSION["yjucp_parent_id"] ?>">
                                      </div>
                                    </div>

                                    <div class="form-group mb-2 row">
                                      <label class="col-sm-3 col-form-label">Choose Plan</label>
                                      <div class="col-sm-9">
                                        <select name="txt_pricing_plan" id='txt_pricing_plan' class="form-control"
                                          data-toggle="tooltip" data-placement="top" title="" required=""
                                          data-original-title="Choose Plan" tabindex="1" autofocus
                                          onchange="check_credit();" onblur="check_credit();">
                                          <? // To get the child user list from API
                                          $replace_txt = '{
                                     "user_id" : "' . $_SESSION['yjucp_user_id'] . '"
                                                   }';
                                   // Call the reusable cURL function
                                  $response = executeCurlRequest($api_url . "/purchase_credit/pricing_slot", "GET", $replace_txt);
                                          // After got response decode the JSON result
                                          $state1 = json_decode($response, false);
                                          if ($state1->num_of_rows > 0) {
                                            for ($indicator = 0; $indicator < $state1->num_of_rows; $indicator++) {
                                              if($state1->pricing_slot[$indicator]->pricing_slot_status == 'Y'){
                                              // Looping the indicator is less than the num_of_rows.if the condition is true to continue the process and to get the details.if the condition are false to stop the process ?>
                                              <option
                                                value="<?= $_SESSION['yjucp_user_id'] . "~~" . $state1->pricing_slot[$indicator]->pricing_slot_id . "~~" . $state1->pricing_slot[$indicator]->price_from . "~~" . $state1->pricing_slot[$indicator]->price_to . "~~" . $state1->pricing_slot[$indicator]->price_per_message ?>"
                                         <?php
                                         // Set 'selected' if the current option is the first or matches $slot_id
                                         if ($indicator == 0 || $slot_id == $state1->pricing_slot[$indicator]->pricing_slot_id) {
                                           echo 'selected';
                                         }

                                         // Set 'disabled' if $slot_id is set and does not match the current pricing slot
                                         if (!empty($slot_id) && $slot_id != $state1->pricing_slot[$indicator]->pricing_slot_id) {
                                           echo ' disabled';
                                         }
                                        }
                                         ?>>
                                                <?= $state1->pricing_slot[$indicator]->price_from . " - " . $state1->pricing_slot[$indicator]->price_to . " [Rs." . $state1->pricing_slot[$indicator]->price_per_message . "](" . $state1->pricing_slot[$indicator]->rights_name . ")" ?>
                                              </option>

                                              <?
                                            }
                                          }
                                          ?>
                                        </select>
                                      </div>
                                    </div>

                                    <div class="form-group mb-2 row">
                                      <label class="col-sm-3 col-form-label">Amount in INR</label>
                                      <div class="col-sm-9">
                                        <input type="hidden" name="txt_message_amount" id='txt_message_amount'
                                          class="form-control" value="<?= $txt_message_amount ?>" tabindex="3" required
                                          maxlength="7"
                                          onkeypress="return (event.charCode !=8 && event.charCode ==0 || ( event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)))"
                                          placeholder="Amount" data-toggle="tooltip" data-placement="top" title=""
                                          data-original-title="Amount">
                                        <span class="error_display" id='id_count_display'></span>
                                        <!-- Message Count and Error display -->
                                      </div>
                                    </div>


                                    <?php
                                    // Get the default comment from GET parameter, if available
                                    $default_comment = isset($_GET['usrsmscrd_id']) ? $_GET['usrsmscrd_id'] : '';

                                    // Check if the form was submitted and set the value
                                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                      $usrcrdbt_comments = !empty($_POST['usrcrdbt_comments']) ? $_POST['usrcrdbt_comments'] : '';
                                    } else {
                                      $usrcrdbt_comments = $default_comment;
                                    }

                                    // Determine if the field should be read-only (when $_GET['usrsmscrd_id'] is used as default value)
                                    $is_read_only = ($usrcrdbt_comments === $default_comment && !empty($default_comment)) ? 'readonly' : '';
                                    ?>

                                    <div class="form-group mb-2 row">
                                      <label class="col-sm-3 col-form-label">Comments</label>
                                      <div class="col-sm-9">
                                        <input type="text" name="usrcrdbt_comments" id="usrcrdbt_comments"
                                          class="form-control" minlength="3" maxlength="200" style="height:40px;"
                                          pattern="[a-zA-Z0-9 -_]+" onkeypress="return clsAlphaNoOnly(event)"
                                          value="<?= htmlspecialchars($usrcrdbt_comments) ?>" tabindex="4" required=""
                                          placeholder="Comments" <?= $is_read_only ?>>
                                        <!-- Message Count and Error display -->
                                      </div>
                                    </div>
                                    <input type="hidden" name="usr_credit_id" id="hiden_usr_credit_id"
                                      value="<?php echo htmlspecialchars($usr_credit_id); ?>">


                                    <div class="form-group mb-2 row">
                                      <div class="col-sm-12">
                                        <input type="checkbox" name="chk_terms" id="chk_terms" required value=""
                                          tabindex="5">
                                        <span class="cr"><i
                                            class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                        <span class="text-inverse" style="color:#FF0000 !important">I read and accept <a
                                            href="#" style="color:#FF0000 !important" data-toggle="tooltip"
                                            data-placement="top" title="" data-original-title="Terms & Conditions."
                                            class="alert-ajax btn-outline-info">Terms &amp;
                                            Conditions.</a></span>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="card-footer text-center">
                                    <span class="error_display" id='id_error_display' style="color:red"></span><br> <!-- Error Display -->
                                    <input type="hidden" class="form-control" name='tmpl_call_function'
                                      id='tmpl_call_function' value='purchase_sms_credit' />
                                    <input type="submit" name="submit" id="submit" tabindex="6" value="Submit"
                                      class="btn btn-success">
                                    <input type="hidden" name="hdsms" id="hdsms" class="form-control" maxlength="50"
                                      value="purchase_message_credit">
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
                      <button type="button" class="btn btn-success waves-effect " data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Preview Data Modal content End-->

              <!-- After Submit Preview Data Modal content-->
              <!-- Modal content-->
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
              <? include("libraries/site_footer.php"); ?>

            </div>
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
  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

  <script>
    $(".alert-ajax").click(function () {
      $("#id_modal_display").load("uploads/imports/payment_terms.htm", function () {
        $('#default-Modal').modal({ show: true });
      });
    });

    function check_credit() {
      console.log("Hai");
      var gst_percentage = 0.18;
      $("#id_count_display").html("");
      let text_credit = $('#txt_pricing_plan').val();
      console.log("text_credit", text_credit)
      const split_credit = text_credit.split("~~");
      console.log("text_credit1 : " + text_credit);
      console.log("split_credit3 : " + split_credit[3]);
      console.log(split_credit[4]);
      var splitarray = split_credit[3] * split_credit[4];
      console.log("splitarray : " + splitarray);
      console.log(splitarray + +(splitarray * gst_percentage));
      var ttl_amt = Math.round(+splitarray + +(splitarray * gst_percentage));
      console.log("ttl_amt : " + ttl_amt);
      $("#txt_message_amount").val(ttl_amt);
      $("#hdsms").val(ttl_amt);
      $("#id_count_display").html(ttl_amt);
    }

    $("#submit").click(function (e) {
      $("#id_error_display").html("");
      $('#txt_message_amount').css('border-color', '#00000026');
      $('#usrcrdbt_comments').css('border-color', '#00000026');
      var flag = 1;

      var txt_message_amount = $('#txt_message_amount').val();
      var usrcrdbt_comments = $('#usrcrdbt_comments').val();

      if (txt_message_amount == "") {
        $('#txt_message_amount').css('border-color', 'red');
        flag = false;
        e.preventDefault();
      }

      if (usrcrdbt_comments == "") {
        $('#usrcrdbt_comments').css('border-color', 'red');
        flag = false;
        e.preventDefault();
      } else if (usrcrdbt_comments.length < 3) {
        flag = false;
        $("#id_error_display").html("Comments must be a 3 characters");
        e.preventDefault();
      }

      if ($("#chk_terms").prop('checked') == false) {
        $('#chk_terms').css('border-color', 'red');
        $("#id_error_display").html("Please select terms & conditions");
        flag = false;
        e.preventDefault();
      }


      if (flag) {
        var data_serialize = $("#frm_message_credit").serialize();
        $.ajax({
          type: 'post',
          url: "ajax/message_call_functions.php",
          dataType: 'json',
          data: data_serialize,
          async: true,
          beforeSend: function () {
            $('#submit').attr('disabled', true);
            $('#load_page').show();
          },
          complete: function () {
            $('#submit').attr('disabled', false);
            $('#load_page').hide();
          },
          success: function (response) {
            if (response.status == '0' || response.status == 0) {
              $('#submit').attr('disabled', false);
              $("#id_error_display").html(response.msg);
            } else if (response.status == '1' || response.status == 1) {
              $('#submit').attr('disabled', false);
              <? if ($_SESSION['yjucp_user_master_id'] == 2) { ?>
                $("#id_error_display").html("Payment Processing..");

                let text_credit = $('#txt_pricing_plan').val();
                const split_credit = text_credit.split("~~");

                var getAmount = $("#txt_message_amount").val();
                var product_id = split_credit[1];
                var useremail = "<?= $_SESSION['yjucp_user_email'] ?>";
                var totalAmount = getAmount * 100;

                var options = {
                  "key": "<?= $rp_keyid ?>",
                  "amount": totalAmount,
                  "name": "<?= $_SESSION['yjucp_user_name'] ?>",
                  "description": "Purchase Message Credits",
                  "image": "https://www.codefixup.com/wp-content/uploads/2016/03/logo.png",
                  "handler": function (response) {
                    $.ajax({
                      url: 'ajax/rppayment_call_functions.php?action_process=razorpay_payment',
                      type: 'post',
                      dataType: 'json',
                      data: {
                        razorpay_payment_id: response.razorpay_payment_id,
                        totalAmount: totalAmount,
                        product_id: product_id,
                        useremail: useremail,
                      },
                      success: function (response) {
                        $('#txt_message_amount').val("");
                        $('#usrcrdbt_comments').val("");
                        if (response.status == '0' || response.status == 0) {
                          $("#id_error_display").html(response.msg);
                        } else if (response.status == '1' || response.status == 1) {
                          $("#id_error_display").html(response.msg);
                          setInterval(function () {
                            window.location = "purchase_message_list";
                          }, 1000);
                        }
                      },
                      error: function (response, status, error) {
                        window.location = "purchase_message_list";
                      }
                    });
                  },
                  "theme": {
                    "color": "#528FF0"
                  }
                };
                var rzp1 = new Razorpay(options);
                rzp1.on('payment.failed', function (response) {
                  $("#id_error_display").html("Payment failed. Redirecting to the purchase list...");
                  setTimeout(function () {
                    window.location = "purchase_message_list";
                  }, 2000);
                });
                rzp1.open();
                e.preventDefault();
              <? } else { ?>
                window.location = "purchase_message_list";
              <? } ?>
            }
            $('#load_page').hide();
            $("#result").hide().html(output).slideDown();
          },
          error: function (response, status, error) {
            $('#submit').attr('disabled', false);
            $("#id_error_display").html(response.msg);
          }
        });
      }

    });
    function clsAlphaNoOnly(e) { // Accept only alpha numerics, no special characters 
      var key = e.keyCode;
      if ((key >= 65 && key <= 90) || (key >= 97 && key <= 122) || (key >= 48 && key <= 57) || (key == 32) || (key == 95)) {
        return true;
      }
      return false;
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
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-23581568-13');
</script>
  <script src="libraries/assets/js/rocket-loader.min.js" data-cf-settings="461d1add94eeb239155d648f-|49"
    defer=""></script>
</body>

<!-- Mirrored from colorlib.com/polygon/admindek/default/compose_sms.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 12 Dec 2019 16:09:13 GMT -->

</html>
