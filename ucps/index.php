<?php
session_start();
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Login ::
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
    </style>

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
                    <form class="md-float-material form-material" id="frm_login">
                        <div class="text-center">
                            <!-- <img src="libraries/assets/png/logo.png" alt="logo.png"> -->
                            <img class="img-fluid" src="libraries/assets/png/YJ-Logo" alt="Theme-Logo" />
                        </div>
                        <div class="auth-box card">
                            <div class="card-block">
                                <div class="row m-b-20">
                                    <div class="col-md-12">
                                        <h3 class="text-center txt-primary">Sign In</h3>
                                    </div>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" name="user-name" id="user-name" class="form-control" required="" oninput="this.value = this.value.replace(/[^a-z0-9@._-]/gi, '')">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Useremail</label>
                                </div>

                                <div class="form-group form-primary">
                                    <input type="password" name="password" id="password" class="form-control"
                                        required="">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Password</label>
                                    <i class="fas fa-eye-slash custom-icon" id="togglePassword"></i>
                                    <!-- Password visibility toggle icon -->
                                </div>
                                <div class="row m-t-25 text-left">
                                    <div class="col-12">
                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
	 	   	 	 	 		  <input type="checkbox" name="chk_terms" id="chk_terms" value="">
                                                <span class="cr"><i
                                                        class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span class="text-inverse">Remember me</span>
                                            </label>
                                        </div>
                                        <div class="forgot-phone text-right float-right">
                                            <a href="forgot_password" class="text-right f-w-600"> Forgot
                                                Password?</a>
                                        </div>
                                    </div>
                                </div><br>
<span class="error_display" id="id_error_display_signin" style="display: flex; justify-content: center; align-items: center; text-align: center; color:red; position: absolute; left: 50%; transform: translate(-50%, -50%);"></span>


                                <div class="row m-t-30">

                                    <div class="col-md-12">
                                        <input type="hidden" class="form-control" name='call_function'
                                            id='call_function' value='signin' /> <!-- Process Name -->
                                        <input type="hidden" class="form-control" name='hid_sendurl' id='hid_sendurl'
                                            value='<?= $server_http_referer ?>' /> <!-- Redirect Link -->
                                        <button type="button"
                                            class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20"
                                            id="submit">LOGIN</button>
                                    </div>
                                </div>
                                <p class="text-inverse text-left">Don't have an account?<a href="registration">
                                        <b>Register here </b></a>for free!</p>
                            </div>
                        </div>
                    </form>

                </div>

            </div>

        </div>

        </div>

    </section>


    <script>
        // To Submit the Form
        var $ = jQuery.noConflict();
        document.body.addEventListener("click", function (evt) {
            //note evt.target can be a nested element, not the body element, resulting in misfires
           // $("#id_error_display_signin").html("");
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
            //$('#txt_user_password').css('border-color', '');
            $('#user-name').val("");
            $('#password').val("");
        }
        // Password visibility toggle
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            const icon = this;

            // Toggle the type attribute
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Toggle the icon
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
        $("#submit").click(function (e) {
            $("#id_error_display_signin").html("");
            var uname = $('#user-name').val();
            var password = $('#password').val();
            var flag = true;

            // Validate Username
            if (uname === "") {
                $('#user-name').css('border-color', 'red');
                flag = false;
                e.preventDefault();
            }
            // Validate Password
            if (password === "") {
                $('#password').css('border-color', 'red');
                flag = false;
                e.preventDefault();
            }

// Terms and conditions validation
if (!$("#chk_terms").prop('checked')) {
    //alert("Please accept the terms & conditions.");  // Display alert
    $("#id_error_display_signin").html("Please click remember me");  // Display error message
    flag = false;
}

            // If validation passes
            if (flag) {
                var data_serialize = $("#frm_login").serialize();
                $.ajax({
                    type: 'POST',
                    url: "ajax/call_functions.php",
                    dataType: 'json',
                    data: data_serialize,
                    beforeSend: function () {
                        $('#submit').attr('disabled', true);
                        $('.theme-loader').show();
                    },
                    complete: function () {
                        $('#submit').attr('disabled', false);
                        $('.theme-loader').hide();
                    },
                    success: function (response) {
                        if (response.status == 0 || response.status == '0') { // Failure Response
                            $('#password').val('');
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
                            //alert("Success");
                            window.location = 'dashboard'; // Redirect the URL
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log("AJAX Error: " + error);
                        $("#id_error_display_signin").html('An unexpected error occurred.');
                    }
                });

            }
        });



    </script>

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

<!-- Mirrored from colorlib.com/polygon/admindek/default/auth-sign-in-social.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 12 Dec 2019 16:08:30 GMT -->

</html>
