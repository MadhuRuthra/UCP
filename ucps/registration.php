<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from colorlib.com/polygon/admindek/default/registration.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 12 Dec 2019 16:10:00 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>
  <title>Sign Up ::
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

  <link rel="stylesheet" type="text/css" href="libraries/assets/css/font-awesome.min.css">

  <link rel="stylesheet" type="text/css" href="libraries/assets/css/style.css">
  <link rel="stylesheet" type="text/css" href="libraries/assets/css/pages.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    .custom-icon {
      color: #0056b3;
      /* Change this to your preferred color */
      font-size: 15px;
      /* Adjust the size as needed */
      transition: color 0.3s ease;
      /* Smooth color transition */
      cursor: pointer;
      /* Change cursor to pointer */
      position: absolute;
      /* Make the icon position absolute */
      right: 10px;
      /* Adjust positioning */
      top: 15px;
      /* Adjust positioning */
      z-index: 10;
      /* Ensure the icon is above the input */
    }

    .custom-icon:hover {
      color: #003d7a;
      /* Darker shade on hover */
      transform: scale(1.1);
      /* Slightly enlarge on hover */
    }

    .form-primary {
      position: relative;
      /* Set parent position relative for absolute icon positioning */
    }

    .btn-close {
      border: none;
      background-color: transparent;
      font-size: 1.5rem;
      font-weight: bold;
      cursor: pointer;
      color: black;
    }

    .btn-close:hover {
      color: red;
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }
  </style>
</head>

<body themebg-pattern="theme1">

  <section class="login-block">

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-12">

          <form class="md-float-material form-material" name="frm_signup" id='frm_signup' method="post">
            <div class="text-center">
              <!-- <img src="libraries/assets/png/logo.png" alt="logo.png"> -->
              <img class="img-fluid" src="libraries/assets/png/YJ-Logo" alt="Theme-Logo" />
            </div>
            <div class="auth-box card">
              <div class="card-block">
                <div class="row m-b-20">
                  <div class="col-md-12">
                    <h3 class="text-center txt-primary">Sign up</h3>
                  </div>
                </div>
                <div class="form-group form-primary">
                  <input type="text" name="clientname_txt" id="clientname_txt" class="form-control" required  oninput="this.value = this.value.replace(/[^a-z0-9, ]/gi, '')" maxlength="50">
                  <span class="form-bar"></span>
                  <label class="float-label">Your Username</label>
                </div>

                <div class="form-group form-primary">
                  <input type="number" name="mobile_no_txt" id="mobile_no_txt" class="form-control" required maxlength="10"
                    style="-moz-appearance: textfield; -webkit-appearance: none; appearance: none;">
                  <span class="form-bar"></span>
                  <label class="float-label">Your Mobile Number</label>
                </div>

                <!-- <div class="form-group form-primary">
                  <input type="number" name="mobile_no_txt" id="mobile_no_txt" class="form-control" required maxlength="10"> 
                  <span class="form-bar"></span>
                  <label class="float-label">Your Mobile Number</label>
                </div> -->

                <div class="form-group form-primary">
                  <input type="email" name="email_id_contact" id="email_id_contact" class="form-control" required maxlength="50">
                  <span class="form-bar"></span>
                  <label class="float-label">Your Email Address</label>
                </div>

                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group form-primary">
                      <input type="password" name="txt_user_password" id="txt_user_password" class="form-control" maxlength="50"
                        required>
                      <span class="form-bar"></span>
                      <label class="float-label">Password</label>
                      <i class="fas fa-eye-slash custom-icon" id="togglePassword1"></i>
                    </div>
                  </div>

                  <div class="col-sm-6">
                    <div class="form-group form-primary">
                      <input type="password" name="txt_confirm_password" id="txt_confirm_password" class="form-control" maxlength="50"
                        required>
                      <span class="form-bar"></span>
                      <label class="float-label">Confirm Password</label>
                      <i class="fas fa-eye-slash custom-icon" id="togglePassword2"></i>
                    </div>
                  </div>
                </div>

                <!-- Terms & Conditions Card -->
                <div id="terms_card" class="card" style="display: none;">
                  <div class="card-header">
                    <h5 class="card-title">
                      Terms & Conditions
                      <button id="close_terms" type="button" class="btn-close">&times;</button>
                    </h5>
                  </div>


                  <div class="card-body">
                    <h6>1. Terms and Conditions</h6>
                    <p>IMPORTANT: The contents of this email and any attachments are confidential. They are intended for
                      the named recipient(s) only. If you have received this email by mistake, please notify the sender
                      immediately and do not disclose the contents to anyone or make copies thereof.</p>
                  </div>
                </div>

                <!-- Checkbox & Submit Button -->
                <div class="row m-t-25 text-left">
                  <div class="col-md-12">
                    <div class="checkbox-fade fade-in-primary">
                      <label>
                        <input type="checkbox" name="chk_terms" id="chk_terms" value="">
                        <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                        <span class="text-inverse">I read and accept <a href="#" id="show_terms">Terms &amp;
                            Conditions.</a></span>
                      </label>
                    </div>
                  </div>
                </div>
                  <br>
                <span class="error_display" id="id_error_display_onboarding" style="position: absolute;left: 50%; transform: translate(-50%, -50%); text-align: center; color:red;"></span>
                <div class="row m-t-30">
                  <div class="col-md-12">
                    <input type="submit" name="submit_signup" id="submit_signup" value="Sign Up Now"
                      class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">
                  </div>
                </div>
                <hr />
              </div>
            </div>
          </form>

        </div>

      </div>

    </div>

  </section>

  <script>
    console.log("Welcome");
    var $ = jQuery.noConflict();
    const termsCard = document.getElementById('terms_card');
    const showTermsLink = document.getElementById('show_terms');
    const closeTermsButton = document.getElementById('close_terms');

    showTermsLink.addEventListener('click', function (event) {
      event.preventDefault();
      termsCard.style.display = 'block';
    });

    closeTermsButton.addEventListener('click', function () {
      termsCard.style.display = 'none';
    });
    // To Submit the Form
    document.body.addEventListener("click", function (evt) {
      //note evt.target can be a nested element, not the body element, resulting in misfires
      $("#id_error_display_signin").html("");
    });

    $("option").each(function () {
      var $this = $(this);
      $this.text($this.text().charAt(0).toUpperCase() + $this.text().slice(1));
    });

    function func_open_tab_signup() {
      $('#tab_signin').css("display", "block");
      $('#tab_signup').css("display", "none");
      $('#tab_forgot_pass').css("display", "none");
      // Clear signup fields
      $('#clientname_txt').val('');
      $('#mobile_no_txt').val('');
      $('#email_id_contact').val('');
      $('#txt_user_password').val('');
      $('#txt_confirm_password').val('');
    }
    // Password visibility toggle for the first password field
    document.getElementById('togglePassword1').addEventListener('click', function () {
      const passwordInput = document.getElementById('txt_user_password');
      const icon = this;

      // Toggle the type attribute
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);

      // Toggle the icon
      icon.classList.toggle('fa-eye');
      icon.classList.toggle('fa-eye-slash');
    });

    // Password visibility toggle for the confirm password field
    document.getElementById('togglePassword2').addEventListener('click', function () {
      const confirmPasswordInput = document.getElementById('txt_confirm_password');
      const icon = this;

      // Toggle the type attribute
      const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      confirmPasswordInput.setAttribute('type', type);

      // Toggle the icon
      icon.classList.toggle('fa-eye');
      icon.classList.toggle('fa-eye-slash');
    });

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

    $(document).ready(function () {
      // Limit the input to 10 digits
      $('#mobile_no_txt').on('input', function () {
        // Get the current value of the input field
        var currentValue = $(this).val();

        // Remove any non-digit characters and restrict length to 10
        var sanitizedValue = currentValue.replace(/\D/g, '').substring(0, 10);
        $(this).val(sanitizedValue);
      });
      // Sign up submit Button function Start
      $(document).on("submit", "form#frm_signup", function (e) {
        e.preventDefault();

        $("#id_error_display_onboarding").html("");
        var flag = true;

        // Get input field values
        var clientname_txt = $('#clientname_txt').val().trim();
        var mobile_no_txt = $('#mobile_no_txt').val();
        var email_id_contact = $('#email_id_contact').val();
        var password = $('#txt_user_password').val();
        var confirm_password = $('#txt_confirm_password').val();

        // Clear previous field borders
        $('#clientname_txt, #mobile_no_txt, #email_id_contact, #txt_user_password, #txt_confirm_password').css('border-color', '');

        // Name validation
        if (clientname_txt == "") {
          $('#clientname_txt').css('border-color', 'red');
          flag = false;
        }

        // Mobile number validation (India only)
        if (mobile_no_txt == "") {
          $('#mobile_no_txt').css('border-color', 'red');
          flag = false;
        } else if (!/^[6789]\d{9}$/.test(mobile_no_txt)) {
          $("#id_error_display_onboarding").html("Please enter a valid Indian mobile number.");
          $('#mobile_no_txt').css('border-color', 'red');
          flag = false;
        }

        // Email validation
        var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z]+[a-zA-Z0-9-]*\.[a-zA-Z]{2,}$/;;
        if (email_id_contact == "") {
          $('#email_id_contact').css('border-color', 'red');
          flag = false;
        } else if (!emailPattern.test(email_id_contact)) {
          $("#id_error_display_onboarding").html("Email is invalid.");
          $('#email_id_contact').css('border-color', 'red');
          flag = false;
        }

        // Password validation
        if (password == "") {
          $('#txt_user_password').css('border-color', 'red');
          flag = false;
        } else if (!checkPasswordStrength()) {
          flag = false;
        }

        // Confirm password validation
        if (confirm_password == "") {
          $('#txt_confirm_password').css('border-color', 'red');
          flag = false;
        } else if (confirm_password !== password) {
          $('#txt_confirm_password').css('border-color', 'red');
          $("#id_error_display_onboarding").html("Password and Confirm Password do not match.");
          flag = false;
        }

        // Terms and conditions validation
        if (!$("#chk_terms").prop('checked')) {
          $("#id_error_display_onboarding").html("Please accept the terms & conditions.");
          flag = false;
        }

        // If all validations pass, submit form via AJAX
        if (flag) {
          var fd = new FormData(this);

          $.ajax({
            type: 'post',
            url: "ajax/call_functions.php?call_function=onboarding_signup",
            dataType: 'json',
            data: fd,
            contentType: false,
            processData: false,
            beforeSend: function () {
              $('#submit').attr('disabled', true);
              $('.theme-loader').css("display", "block").show();
              $("#id_error_display_onboarding").html("");
            },
            complete: function () {
              $('.theme-loader').css("display", "none").hide();
              $('#submit').attr('disabled', false);
            },
            success: function (response) {
              if (response.status == 1) {
                $("#id_error_display_onboarding").html("Login ID created.Kindly login");
                $('#frm_signup')[0].reset(); // Clear form fields
                setTimeout(function () {
                  window.location = 'index';
                }, 2000);
              } else {
                $("#id_error_display_onboarding").html(response.msg || 'Service not running, please check the service.');
              }
            },
            error: function () {
              $('#submit').attr('disabled', false);
              $("#id_error_display_onboarding").html('An error occurred. Please try again.');
            }
          });
        }
      });
    });
    // Sign in submit Button function End


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
  <!-- Mirrored from colorlib.com/polygon/admindek/default/registration.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 12 Dec 2019 16:10:00 GMT -->

</html>
