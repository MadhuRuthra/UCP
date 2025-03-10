<!DOCTYPE html>
<html lang="en">
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>
  <title>Forgot Password ::
    <?= $site_title ?>
  </title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


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

  <link rel="stylesheet" type="text/css" href="libraries/assets/css/style.css">
  <link rel="stylesheet" type="text/css" href="libraries/assets/css/pages.css">


  <link rel="stylesheet" type="text/css" href="libraries/assets/css/feather.css">

  <link rel="stylesheet" type="text/css" href="libraries/assets/css/font-awesome-n.min.css">
  <link rel="stylesheet" type="text/css" href="libraries/assets/css/widget.css">
</head>

<body themebg-pattern="theme1">

  <div class="theme-loader">
    <div class="loader-track">
      <div class="preloader-wrapper">
        <div class="spinner-layer spinner-blue">
          <div class="circle-clipper left">
            <div class="circle"></div>
          </div>
          <div class="gap-patch">
            <div class="circle"></div>
          </div>
          <div class="circle-clipper right">
            <div class="circle"></div>
          </div>
        </div>
        <div class="spinner-layer spinner-red">
          <div class="circle-clipper left">
            <div class="circle"></div>
          </div>
          <div class="gap-patch">
            <div class="circle"></div>
          </div>
          <div class="circle-clipper right">
            <div class="circle"></div>
          </div>
        </div>
        <div class="spinner-layer spinner-yellow">
          <div class="circle-clipper left">
            <div class="circle"></div>
          </div>
          <div class="gap-patch">
            <div class="circle"></div>
          </div>
          <div class="circle-clipper right">
            <div class="circle"></div>
          </div>
        </div>
        <div class="spinner-layer spinner-green">
          <div class="circle-clipper left">
            <div class="circle"></div>
          </div>
          <div class="gap-patch">
            <div class="circle"></div>
          </div>
          <div class="circle-clipper right">
            <div class="circle"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <section class="login-block">

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-12">

          <form class="md-float-material form-material" name="frm_forgotpass" id='frm_forgotpass'>
            <div class="text-center">
              <img class="img-fluid" src="libraries/assets/png/YJ-Logo" alt="Theme-Logo" />
            </div>
            <div class="auth-box card">
              <div class="card-block">
                <div class="row m-b-20">
                  <div class="col-md-12">
                    <h3 class="text-left">Recover your password</h3>
                  </div>
                </div>
                <div class="form-group form-primary">
                  <input type="text" name="email_id_reset" id="email_id_reset" class="form-control" required="">
                  <span class="form-bar"></span>
                  <label class="float-label">Your Email Address</label>
                </div>

                <div class="row m-t-30">
                  <div class="col-md-12" style="text-align:center;">
                    <span class="error_display text-center" id='id_error_forgotpass'></span>&nbsp;
                  </div>
                  <div class="col-md-4"></div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <input type="submit" name="submit_forgot" id="submit_forgot" value="Reset Password"
                      class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">
                  </div>
                </div>
                <p class="f-w-600 text-right">Back to <a href="index.php">Login.</a></p>
                <div class="row">
                  <div class="col-md-10">
                    <p class="text-inverse text-left m-b-0">Thank you.</p>
                    <p class="text-inverse text-left"><a href="index"><b>Back to
                          website</b></a></p>
                  </div>
                  <div class="col-md-2">
                    <img src="libraries/assets/png/favicon1.ico" alt="small-logo.png">
                  </div>
                </div>
              </div>
            </div>
          </form>

        </div>

      </div>

    </div>

  </section>
  <style>
    .btn-close {
      border: none;
      background-color: transparent;
      font-size: 1.25rem;
      cursor: pointer;
    }

    .btn-close:hover {
      color: red;
    }
  </style>

  <script>
    // To Submit the Form
    var $ = jQuery.noConflict();
    document.body.addEventListener("click", function (evt) {
      //note evt.target can be a nested element, not the body element, resulting in misfires
      $("#id_error_display_signin").html("");
    });

    $("option").each(function () {
      var $this = $(this);
      $this.text($this.text().charAt(0).toUpperCase() + $this.text().slice(1));
    });

    $(".alert-ajax").click(function () {
      $("#id_modal_display").load("uploads/imports/terms.htm", function () {
        $('#default-Modal').modal({ show: true });
      });
    });


    function func_open_tab_signin() {
      $('#tab_signup').css("display", "block");
      $('#tab_signin').css("display", "none");
      $('#tab_forgot_pass').css("display", "none");

      // login clear
      $('#txt_user_password').css('border-color', '');
      $('#txt_username').val("");
      $('#txt_password').val("");
    }

    function func_open_tab_signup() {
      $('#tab_signin').css("display", "block");
      $('#tab_signup').css("display", "none");
      $('#tab_forgot_pass').css("display", "none");
      // signup clear 
      $('#clientname_txt').val('');
      $('#login_id_txt').val('');
      $('#mobile_no_txt').val('');
      $('#email_id_contact').val('');
      $('#txt_user_password').val('');
      $('#txt_confirm_password').val('');
    }


    function func_open_tab_forgot() {

      $('#tab_forgot_pass').css("display", "block");
      $('#tab_signin').css("display", "none");
      $('#tab_signup').css("display", "none");
      // signup clear 
      $('#clientname_txt').val('');
      $('#login_id_txt').val('');
      $('#mobile_no_txt').val('');
      $('#email_id_contact').val('');
      $('#txt_user_password').val('');
      $('#txt_confirm_password').val('');
    }

    function password_visible1() {
      var x = document.getElementById("txt_user_password");
      if (x.type === "password") {
        x.type = "text";
        $('#display_visiblitity').html('<i class="fas fa-eye"></i>');
      } else {
        x.type = "password";
        $('#display_visiblitity').html('<i class="fas fa-eye-slash"></i>');
      }
    }

    function password_visible2() {
      var x = document.getElementById("txt_confirm_password");
      if (x.type === "password") {
        x.type = "text";
        $('#display_visiblitity_1').html('<i class="fas fa-eye"></i>');
      } else {
        x.type = "password";
        $('#display_visiblitity_1').html('<i class="fas fa-eye-slash"></i>');
      }
    }

    function password_visible() {
      var x = document.getElementById("txt_password");
      if (x.type === "password") {
        x.type = "text";
        $('#id_signup_display_visiblitity').html('<i class="fas fa-eye"></i>');
      } else {
        x.type = "password";
        $('#id_signup_display_visiblitity').html('<i class="fas fa-eye-slash"></i>');
      }
    }


    $("#submit").click(function (e) {
      $("#id_error_display_signin").html("");
      var uname = $('#txt_username').val();
      var password = $('#txt_password').val();
      var flag = true;
      /********validate all our form fields***********/
      /* Name field validation  */
      if (uname == "") {
        $('#txt_username').css('border-color', 'red');
        flag = false;
        e.preventDefault();
      }
      /* password field validation  */
      if (password == "") {
        $('#txt_password').css('border-color', 'red');
        flag = false;
        e.preventDefault();
      } else {
      }
      /********Validation end here ****/

      /* If all are ok then we send ajax request to process_connect.php *******/
      if (flag) {
        var data_serialize = $("#frm_login").serialize();
        $.ajax({
          type: 'post',
          url: "ajax/call_functions.php",
          dataType: 'json',
          data: data_serialize,
          beforeSend: function () { // Before Send to Ajax
            $('#submit').attr('disabled', true);
            $('.theme-loader').css("display", "block");
            $('.theme-loader').show();
          },
          complete: function () { // After complete the Ajax
            $('#submit').attr('disabled', false);
            $('.theme-loader').css("display", "none");
            $('.theme-loader').hide();
          },
          success: function (response) {
            if (response.status == 0 || response.status == '0') { // Failure Response
              $('#txt_password').val('');
              $('#submit').attr('disabled', false);
              $("#id_error_display_signin").html(response.msg);
              if (response.msg === null || response.msg === '') {
                $("#id_error_display_signin").html('Service not running, Kindly check the service!!');
              }
            }
            else if (response.status == 1) { // Success Response
              $('#submit').attr('disabled', false);
              var hid_sendurl = $("#hid_sendurl").val();
              console.log(hid_sendurl)
              window.location = hid_sendurl; // Redirect the URL
            }
          },
          error: function (response, status, error) {
            console.log(error)
            console.log(response)
            $('#txt_password').val('');
            $('#submit').attr('disabled', false);
            $("#id_error_display_signin").html(response.msg);
          }
        });
      }
    });

    var percentage = 0;

    function check(n, m) {
      var strn_disp = "Very Weak Password";
      if (n < 6) {
        percentage = 0;
        $(".progress-bar").css("background", "#FF0000");
        strn_disp = "Very Weak Password";
      } else if (n < 7) {
        percentage = 20;
        $(".progress-bar").css("background", "#758fce");
        strn_disp = "Weak Password";
      } else if (n < 8) {
        percentage = 40;
        $(".progress-bar").css("background", "#ff9800");
        strn_disp = "Medium Password";
      } else if (n < 10) {
        percentage = 60;
        $(".progress-bar").css("background", "#A5FF33");
        strn_disp = "Strong Password";
      } else {
        percentage = 80;
        $(".progress-bar").css("background", "#129632");
        strn_disp = "Very Strong Password";
      }

      //Lowercase Words only
      if ((m.match(/[a-z]/) != null)) {
        percentage += 5;
      }

      //Uppercase Words only
      if ((m.match(/[A-Z]/) != null)) {
        percentage += 5;
      }

      //Digits only
      if ((m.match(/0|1|2|3|4|5|6|7|8|9/) != null)) {
        percentage += 5;
      }

      //Special characters
      if ((m.match(/\W/) != null) && (m.match(/\D/) != null)) {
        percentage += 5;
      }

      // Update the width of the progress bar
      $(".progress-bar").css("width", percentage + "%");
      $("#strength_display").html(strn_disp);
    }

    // Update progress bar as per the input
    $(document).ready(function () {
      // Whenever the key is pressed, apply condition checks.
      $("#txt_user_password").keyup(function () {
        var m = $(this).val();
        var n = m.length;

        // Function for checking
        check(n, m);
      });
    });


    function checkPasswordStrength() {
      var txt_user_password = $('#txt_user_password').val();
      var number = /([0-9])/;
      var alphabets = /([a-zA-Z])/;
      var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
      var txt_user_password = $('#txt_user_password').val();
      $('#txt_user_password').css('border-color', '');
      if (txt_user_password != '') {
        if (txt_user_password.length < 8) {
          console.log("Weak (should be at least 8 characters.)");
          $('#txt_user_password').css('border-color', 'red');
          return false;
        } else {
          if ($('#txt_user_password').val().match(number) && $('#txt_user_password').val().match(alphabets) && $(
            '#txt_user_password').val().match(special_characters)) {
            console.log("Strong");
            $('#txt_user_password').css('border-color', '#a0a0a0');
            return true;
          } else {
            console.log("Medium (should include alphabets, numbers and special characters.)");
            $('#txt_user_password').css('border-color', 'red');
            return false;
          }
        }
      }
    }

    // Sign up submit Button function Start
    $(document).on("submit", "form#frm_signup", function (e) {
      $("#id_error_display_signup").html("");
      e.preventDefault();
      //get input field values 
      var clientname_txt = $('#clientname_txt').val();
      var login_id_txt = $('#login_id_txt').val();
      var mobile_no_txt = $('#mobile_no_txt').val();
      var email_id_contact = $('#email_id_contact').val();
      var password = $('#txt_user_password').val();
      var confirm_password = $('#txt_confirm_password').val();
      var flag = true;

      /********validate all our form fields***********/
      if (clientname_txt == "") {
        $('#clientname_txt').css('border-color', 'red');
        flag = false;
      }
      if (login_id_txt == "") {
        $('#login_id_txt').css('border-color', 'red');
        flag = false;
      }
      if (email_id_contact == "") {
        $('#email_id_contact').css('border-color', 'red');
        flag = false;
      }

      if (mobile_no_txt == "") {
        $('#mobile_no_txt').css('border-color', 'red');
        flag = false;
      }
      var mobile_no_txt = document.getElementById('mobile_no_txt').value;
      if (mobile_no_txt.length != 10) {
        $("#id_error_display_onboarding").html("Please enter a valid mobile number");
        flag = false;
      }
      if (!(mobile_no_txt.charAt(0) == "9" || mobile_no_txt.charAt(0) == "8" || mobile_no_txt.charAt(0) == "6" || mobile_no_txt.charAt(0) == "7")) {
        $("#id_error_display_onboarding").html("Please enter a valid mobile number");
        document.getElementById('mobile_no_txt').focus();
        flag = false;
      }
      /************************************/

      var email_id_contact = $('#email_id_contact').val();
      /* Email field validation  */
      var filter = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i
      if (filter.test(email_id_contact)) {
        // flag = true;
      } else {
        $("#id_error_display_onboarding").html("Email is invalid");
        document.getElementById('email_id_contact').focus();
        flag = false;
        e.preventDefault();
      }
      /* password field validation  */
      if (password == "") {
        $('#txt_user_password').css('border-color', 'red');
        flag = false;
        e.preventDefault();
      } else {
        if (checkPasswordStrength() == false) {
          flag = false;
          e.preventDefault();
        }
      }
      /* confirm_password field validation  */
      if (confirm_password == "") {
        $('#txt_confirm_password').css('border-color', 'red');
        flag = false;
        e.preventDefault();
      }
      /* password, confirm_password field validation  */
      if (confirm_password != "" && password != "" && confirm_password != password) {
        $('#txt_confirm_password').css('border-color', 'red');
        //alert();
        $("#id_error_display_onboarding").html("Confirm Password mismatch with Password");
        flag = false;
        e.preventDefault();
      }

      if ($("#chk_terms").prop('checked') == true) {
      } else {
        $("#id_error_display_onboarding").html("Please select the terms & conditions");
        flag = false;
        e.preventDefault();
      }

      /********Validation end here ****/

      /* If all are ok then we send ajax request to call_functions.php *******/
      if (flag) {
        $('#txt_confirm_password').css({ 'border-color': '' });
        var data_serialize = $("#frm_signup").serialize();
        var fd = new FormData(this);

        $.ajax({
          type: 'post',
          url: "ajax/call_functions.php?call_function=onboarding_signup",
          dataType: 'json',
          data: fd,
          contentType: false,
          processData: false,
          beforeSend: function () { // Before Send to Ajax
            $('#submit').attr('disabled', true);
            $('.theme-loader').css("display", "block");
            $('.theme-loader').show();
            $("#id_error_display_onboarding").html("");

          },
          complete: function () { // After complete the Ajax
            $('.theme-loader').css("display", "none");
            $('#submit').attr('disabled', false);
            $('.theme-loader').hide();
          },
          success: function (response) { // Success
            if (response.status == 0 || response.status == '0') { // Failure Response
              $('#submit').attr('disabled', false);
              $("#id_error_display_onboarding").html(response.msg);
              if (response.msg === null || response.msg === '') {
                $("#id_error_display_onboarding").html('Service not running, Kindly check the service!!');
              }
            }
            else if (response.status == 1) { // Success Response
              $('#submit').attr('disabled', false);
              $("#id_error_display_onboarding").html(response.msg);
              $('#clientname_txt').val('');
              $('#login_id_txt').val('');
              $('#email_id_contact').val('');
              $('#mobile_no_txt').val('');
              $('#txt_user_password').val('');
              $('#txt_confirm_password').val('');
              setInterval(function () {
                window.location = 'index';
              }, 2000);
            } else if (response.status == 2) {
              //alert(response.msg);
              $('#submit').attr('disabled', false);
              $("#id_error_display_onboarding").html(response.msg);
            }
          },
          error: function (response, status, error) { // If any error occurs
            $('#txt_password').val('');
            $('#submit').attr('disabled', false);
            $("#id_error_display_onboarding").html(response.msg);
          }
        });
      }
    });
    // Sign in submit Button function End


    function clsAlphaNoOnly(e) { // Accept only alpha numerics, no special characters 
      var key = e.keyCode;
      if ((key >= 65 && key <= 90) || (key >= 97 && key <= 122) || (key >= 48 && key <= 57) || (key == 32) || (key == 95)) {
        return true;
      }
      return false;
    }

    // TEMplate Name - Space
    $(function () {
      $('#clientname_txt').on('keypress', function (e) {
        if (e.which == 32) {
          console.log('Space Detected');
          return false;
        }
      });
    });
    $(function () {
      $('#login_id_txt').on('keypress', function (e) {
        if (e.which == 32) {
          console.log('Space Detected');
          return false;
        }
      });
    });
    $(function () {
      $('#txt_username').on('keypress', function (e) {
        if (e.which == 32) {
          console.log('Space Detected');
          return false;
        }
      });
    });

    // 
    $(document).on("submit", "form#frm_forgotpass", function (e) {
      $("#id_error_forgotpass").html(""); // Clear any previous error messages
      e.preventDefault();

      var email_id_reset = $('#email_id_reset').val().trim();
      var flag = true;

      // Email field empty check
      if (email_id_reset === "") {
        $('#email_id_reset').css('border-color', 'red');
        $("#id_error_forgotpass").html("Email address is required.");
        flag = false;
      } else {
        $('#email_id_reset').css('border-color', ''); // Clear any previous error borders
      }

      // Enhanced email format validation
      var emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
      if (!emailRegex.test(email_id_reset)) {
        $('#email_id_reset').css('border-color', 'red');
        $("#id_error_forgotpass").html("Please enter a valid email address.");
        flag = false;
      } else {
        $('#email_id_reset').css('border-color', ''); // Clear error border if valid
      }

      // If all validations pass, proceed with AJAX request
      if (flag) {
        var data_serialize = $("#frm_forgotpass").serialize();

        $.ajax({
          type: 'post',
          url: "ajax/call_functions.php?call_function=resetpwd",
          dataType: 'json',
          data: data_serialize,
          beforeSend: function () {
            $('#submit_forgot').attr('disabled', true);
            $('.theme-loader').css("display", "block");
          },
          complete: function () {
            $('#submit_forgot').attr('disabled', false);
            $('.theme-loader').css("display", "none");
          },
          success: function (response) {
            if (response.status == 0) { // Failure Response
              $('#email_id_reset').val('');
              $("#id_error_forgotpass").html(response.msg || 'Service not running, kindly check the service!');
            } else if (response.status == 1) { // Success Response
              var hid_sendurl = $("#hid_sendurl").val();
              window.location = hid_sendurl; // Redirect on success
            }
          },
          error: function (response) {
            $('#email_id_reset').val('');
            $("#id_error_forgotpass").html(response.msg || 'An error occurred. Please try again.');
          }
        });
      }
    });


  </script>

  <!-- <script src="libraries/assets/js/rocket-loader.min.js" data-cf-settings="a371f3c3996957007cacd73a-|49" defer=""></script></body> -->
  <script type="text/javascript" src="libraries\bower_components\jquery\js\jquery.min.js"></script>
  <script type="4878d7dfa7bc22a8dfa99416-text/javascript" src="libraries/assets/js/jquery.min.js"></script>
  <script type="4878d7dfa7bc22a8dfa99416-text/javascript" src="libraries/assets/js/jquery-ui.min.js"></script>
  <script type="4878d7dfa7bc22a8dfa99416-text/javascript" src="libraries/assets/js/popper.min.js"></script>
  <script type="4878d7dfa7bc22a8dfa99416-text/javascript" src="libraries/assets/js/bootstrap.min.js"></script>

  <script src="libraries/assets/js/waves.min.js" type="4878d7dfa7bc22a8dfa99416-text/javascript"></script>

  <script type="4878d7dfa7bc22a8dfa99416-text/javascript" src="libraries/assets/js/jquery.slimscroll.js"></script>

  <script type="4878d7dfa7bc22a8dfa99416-text/javascript" src="libraries/assets/js/modernizr.js"></script>
  <script type="4878d7dfa7bc22a8dfa99416-text/javascript" src="libraries/assets/js/css-scrollbars.js"></script>
  <script type="4878d7dfa7bc22a8dfa99416-text/javascript" src="libraries/assets/js/common-pages.js"></script>

  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"
    type="4878d7dfa7bc22a8dfa99416-text/javascript"></script>
  <script type="4878d7dfa7bc22a8dfa99416-text/javascript">
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-23581568-13');
</script>
  <script src="libraries/assets/js/rocket-loader.min.js" data-cf-settings="4878d7dfa7bc22a8dfa99416-|49"
    defer=""></script>
</body>

<!-- Mirrored from colorlib.com/polygon/admindek/default/forgot_password.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 12 Dec 2019 16:10:00 GMT -->

</html>