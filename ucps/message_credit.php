<?php
session_start(); // start session
error_reporting(0); // The error reporting function
include_once 'api/configuration.php'; // Include configuration.php
include_once('api/send_request.php');
// Check if the parameters are set
if (isset($_GET['slot_id'], $_GET['usr_vlu'], $_GET['cnt_vlu'], $_GET['usrsmscrd_id'])) {
    // Extract the parameters from the GET request
    $slot_id = $_GET['slot_id'];
    $usr_vlu = $_GET['usr_vlu'];
    $cnt_vlu = $_GET['cnt_vlu'];
    $usrsmscrd_id = $_GET['usrsmscrd_id'];
} else {
}
?>
<!DOCTYPE html>
<html lang="en">
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <title>Message Credit ::
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
                      <h5>Message Credit</h5>
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
											<li class="breadcrumb-item"><a href="message_credit">Message Credit</a>
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
                  <form class="needs-validation" novalidate="" id="frm_message_credit" name="frm_message_credit"
                    action="#" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                      <!-- Admin Select menu Start-->
                      <div class="form-group mb-2 row">
                        <label class="col-sm-4 col-form-label">User
                        </label>
                        <div class="col-sm-8">
                          <select name="txt_receiver_user" id='txt_receiver_user' class="form-control"
                            data-toggle="tooltip" data-placement="top" title="" required=""
                            data-original-title="Receiver User" tabindex="1" autofocus
                            onchange="user_based_product();get_available_balance();" onblur="get_available_balance();getproductid();" >
                            <? // To get the child user list from API
                            $replace_txt = '{
                              "user_id" : "' . $_SESSION['yjucp_user_id'] . '"
                            }';
                                // Call the reusable cURL function
                            $response = executeCurlRequest($api_url . "/purchase_credit/slt_receiver_user", "GET", $replace_txt);
                            // After got response decode the JSON result
                            $state1 = json_decode($response, false);
                            // Based on the JSON response, list in the option button
                            if ($state1->num_of_rows > 0) {
                              for ($indicator = 0; $indicator < $state1->num_of_rows; $indicator++) {
                                // Looping the indicator is less than the num_of_rows.if the condition is true to continue the process and to get the details.if the condition are false to stop the process
                                ?>
                                <option
                                  value="<?= $state1->report[$indicator]
                                      ->user_id .
                                      "~~" .
                                      $state1->report[$indicator]
                                          ->user_name ?>" <?
                                       if ($indicator == 0 || $usr_vlu == $state1->report[$indicator]->user_id) { ?>selected<? }
                                       if ($usr_vlu != '' && $usr_vlu != $state1->report[$indicator]->user_id) { ?> disabled <? } ?> >
                                  <?= $state1->report[$indicator]->user_name ?> 
                                </option>
                                <?
                              }
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                      <!-- Admin Select menu End-->
<!-- Product Name Based If the yjucp_user_id ==  1.condition will be true -->
                      <? if ($slot_id == '' && $_SESSION['yjucp_user_id'] == 1) { ?>
 <div class="form-group mb-2 row">
 <label class="col-sm-4 col-form-label">Product Name</label>
 <div class="col-sm-8">
   <!-- Parent User Panel -->
   <select name="txt_product_name" id='txt_product_name' class="form-control"
     data-toggle="tooltip" data-placement="top" title="" required=""
     data-original-title="Product Name" tabindex="1" autofocus onchange="getproductid();"  onblur="getproductid();"
     >
     <? // To get the current user rights
     $replace_txt = '{
        "select_user_id" : "' . $_SESSION['yjucp_user_id'] . '"
     }'; // Send the User ID
           // Call the reusable cURL function
           $response = executeCurlRequest($api_url . "/list/products_name", "GET", $replace_txt);
     // After got response decode the JSON result
     $state1 = json_decode($response, false);
     // Based on the JSON response, list in the option button
     if ($state1->num_of_rows > 0) {
       // Looping the indicator is less than the num_of_rows.if the condition is true to continue the process and to get the details.if the condition are false to stop the process
       for ($indicator = 0; $indicator < $state1->num_of_rows; $indicator++) { ?>
         <option
           value="<?= $state1->product_name[$indicator]->rights_id .
               " ~~" .
               $state1->product_name[$indicator]->rights_name ?>"
           <? if ($indicator == 0 || $slot_id == $state1->product_name[$indicator]->rights_name) { ?>selected<? }   if ($slot_id != '' && $slot_id !=$state1->product_name[$indicator]->rights_id) { ?> disabled <? } ?>  >
           <?= $state1->product_name[$indicator]->rights_name ?>
         </option>
       <? 
       }
     } 
     ?>
   </select>
 </div>
</div>
                       <? }else{       // Otherwise
                         ?>
                      <div class="form-group mb-2 row">
                        <label class="col-sm-4 col-form-label">Product Name</label>
                        <div class="col-sm-8">
                          <!-- Parent User Panel -->
                          <select name="txt_product_name" id='txt_product_name' class="form-control"
                            data-toggle="tooltip" data-placement="top" title="" required=""
                            data-original-title="Product Name" tabindex="1" autofocus onchange="getproductid();"  onblur="getproductid();"
                            >
                            <? // To get the current user rights
                            $replace_txt = '{
                               "user_id" : "' . $_SESSION['yjucp_user_id'] . '"
                             
                            }'; // Send the User ID
                              // Call the reusable cURL function
           $response = executeCurlRequest($api_url . "/purchase_credit/pricing_slot", "GET", $replace_txt);
                            // After got response decode the JSON result
                            $state1 = json_decode($response, false);
                            // Based on the JSON response, list in the option button
                            if ($state1->num_of_rows > 0) {
                              // Looping the indicator is less than the num_of_rows.if the condition is true to continue the process and to get the details.if the condition are false to stop the process
                              for ($indicator = 0; $indicator < $state1->num_of_rows; $indicator++) { ?>
                                <option
                                  value="<?= $_SESSION['yjucp_user_id'] .
                                      "~~" .
                                      $state1->pricing_slot[$indicator]
                                          ->pricing_slot_id .
                                      "~~" .
                                      $state1->pricing_slot[$indicator]
                                          ->price_from .
                                      "~~" .
                                      $state1->pricing_slot[$indicator]
                                          ->price_to .
                                      "~~" .
                                      $state1->pricing_slot[$indicator]
                                          ->price_per_message .
                                      " ~~" .
                                      $state1->pricing_slot[$indicator]
                                          ->rights_name ?>"
                                  <? if ($indicator == 0 || $slot_id == $state1->pricing_slot[$indicator]->pricing_slot_id) { ?>selected<? }
                                  if ($slot_id != '' && $slot_id != $state1->pricing_slot[$indicator]->pricing_slot_id) { ?> disabled <? } ?> >
                                  <?= $state1->pricing_slot[$indicator]
                                      ->price_from .
                                      " - " .
                                      $state1->pricing_slot[$indicator]
                                          ->price_to .
                                      " [Rs." .
                                      $state1->pricing_slot[$indicator]
                                          ->price_per_message .
                                      "](" .
                                      $state1->pricing_slot[$indicator]
                                          ->rights_name .
                                      " )" ?>
                                </option>
                              <? 
                              }
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                      <? } ?>
                         <!-- Required Message Count -->
                      <div class="form-group mb-2 row">
                        <label class="col-sm-4 col-form-label">Required Message Count</label>
                        <div class="col-sm-8">
                          <input <? if ($cnt_vlu != '') { ?> type="hidden" <? } else { ?> type="text" <? } ?>
                            name="txt_message_count" id='txt_message_count' class="form-control" value="<?= $cnt_vlu ?>"
                            tabindex="3" required maxlength="7"
                            onkeypress="return (event.charCode !=8 && event.charCode ==0 || ( event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)))"
                            placeholder="Message Count" data-toggle="tooltip" data-placement="top" title=""
                            data-original-title="Message Count">
                          <?= $cnt_vlu ?><br>
                          <!-- Message Count and Error display -->
                        </div>
                      </div>
                    </div>
                    <div class="card-footer text-center">
                      <span class="error_display" id='id_error_display' style="color:red"></span><br> <!-- Error Display -->
                      <input type="hidden" class="form-control" name='tmpl_call_function' id='tmpl_call_function'
                        value='message_credit' />
                      <input type="hidden" class="form-control" name='hid_usrsmscrd_id' id='hid_usrsmscrd_id'
                        value='<?= $usrsmscrd_id ?>' />
                      <input type="submit" name="submit" id="submit" tabindex="10" value="Submit"
                        class="btn btn-success">
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

  <script>
    // If we click the Submit button, validate and save the data using API
    $("#submit").click(function (e) {
      $("#id_error_display").html("");
      var txt_product_name = $('#txt_product_name').val();
      var txt_receiver_user = $('#txt_receiver_user').val();
      var txt_message_count = $('#txt_message_count').val();
console.log("txt_product_name", txt_product_name);
console.log("txt_receiver_user", txt_receiver_user);
console.log("txt_message_count", txt_message_count)
      var flag = true;
      // *******validate all our form fields***********
      // Parent User field validation
      if (txt_product_name == "") {
        $('#txt_product_name').css('border-color', 'red');
        flag = false;
        e.preventDefault();
      }
      // Receiver field validation 
      if (txt_receiver_user == "") {
        $('#txt_receiver_user').css('border-color', 'red');
        flag = false;
        e.preventDefault();
      }
      // Message Count field validation 
      if (txt_message_count == "") {
        $('#txt_message_count').css('border-color', 'red');
        flag = false;
        e.preventDefault();
      }
      // *******Validation end here ****

      // If all are ok then we send ajax request to store_call_functions.php *******
      if (flag) {
        var data_serialize = $("#frm_message_credit").serialize();
        $.ajax({
          type: 'post',
          url: "ajax/message_call_functions.php",
          dataType: 'json',
          data: data_serialize,
          beforeSend: function () { // Before send to Ajax
            $('#submit').attr('disabled', true);
            $('#load_page').show();
          },
          complete: function () { // After complete the Ajax
            $('#submit').attr('disabled', true);
            $('#load_page').hide();
          },
          success: function (response) { // Success
            if (response.status == '0') { // If Failure response returns
              $('#txt_message_count').val('');
              $('#submit').attr('disabled', false);
              $("#id_error_display").html(response.msg);
            }
            else if (response.status == 2 || response.status == '2') {
              $('#txt_message_count').val('');
              $('#submit').attr('disabled', false);
              $("#id_error_display").html(response.msg);
            } else if (response.status == 1) { // If Success response returns
              $('#submit').attr('disabled', true);
              $("#id_error_display").html(response.msg);
              setInterval(function () {
               window.location = "message_credit_list";
              }, 2000);
            }
          },
          error: function (response, status, error) { // Error
            $('#txt_message_count').val('');
            $('#submit').attr('disabled', false);
            $("#id_error_display").html(response.msg);
          }
        });
      }
    });

    var product_id;
    function getproductid() {
      var txt_product_name = $("#txt_product_name").val();
      product_id = txt_product_name.split("~~")
      if(product_id[5]){
      if (product_id[5] == 'WHATSAPP') {
        product_id = 1;
      } else if (product_id[5] == 'GSM SMS') {
        product_id = 2;
      } else {
        product_id = 3;
      }
    }else{
      product_id = product_id[0];
    }
    get_available_balance(product_id);
    }
console.log(product_id);
    function user_based_product(){
    var txt_receiver_user = $("#txt_receiver_user").val();
    var send_code = "&txt_receiver_user=" + txt_receiver_user + "";
    <? if($slot_id == '' && $_SESSION["yjucp_user_id"] == 1){?>
 $.ajax({
	type: 'post',
        url: "ajax/call_functions.php?tmpl_call_function=user_based_product" + send_code,
        dataType: 'json',
       success: function (response) { // Success
$("#txt_product_name").html(response.msg)
}
});
<? } ?>
    }

    // To Display the Department Admin
    function get_available_balance() {
      var txt_receiver_user = $("#txt_receiver_user").val();
      var send_code = "&product_id=" + product_id + "&txt_receiver_user=" + txt_receiver_user + "";
      $.ajax({
        type: 'post',
        url: "ajax/call_functions.php?tmpl_call_function=get_available_balance" + send_code,
        dataType: 'json',
        success: function (response) { // Success
          if (response.status == 0) { // Failure response
            $('#id_deptadmin').css("display", "block");
            $('#txt_loginid').val('');
            $('#id_loginid').html('');
            $('#submit_signup').attr('disabled', true);
            $("#id_error_display").html(response.msg);
          } else { // Success Response
            $('#submit_signup').attr('disabled', false);
            $('#id_deptadmin').css("display", "block");
            $("#id_error_display").html(response.msg);
          }
        },
        error: function (response, status, error) { // Error
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
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-23581568-13');
</script>
  <script src="libraries/assets/js/rocket-loader.min.js" data-cf-settings="461d1add94eeb239155d648f-|49"
    defer=""></script>
</body>

<!-- Mirrored from colorlib.com/polygon/admindek/default/compose_sms.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 12 Dec 2019 16:09:13 GMT -->

</html>
