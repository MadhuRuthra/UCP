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

	<title>Change Password ::
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


  <link rel="stylesheet" type="text/css" href="libraries/assets/css/feather.css">

  <link rel="stylesheet" type="text/css" href="libraries/assets/css/font-awesome-n.min.css">
  <link rel="stylesheet" type="text/css" href="libraries/assets/css/widget.css">

	<link rel="stylesheet" type="text/css" href="libraries/assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="libraries/assets/css/pages.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .custom-icon {
            color: #0056b3; /* Change this to your preferred color */
            font-size: 15px; /* Adjust the size as needed */
            transition: color 0.3s ease; /* Smooth color transition */
        }

        .custom-icon:hover {
            color: #0056b3; /* Darker shade on hover */
            transform: scale(1.1); /* Slightly enlarge on hover */
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
											<h5>Change Password</h5>
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
												<span>Change Password</span>
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

										<div class="col-12 col-md-8 col-lg-8 offset-2">
											<div class="card">
												<form class="needs-validation" novalidate="" id="frmid_change_pwd" name="frmid_change_pwd"
													action="#" method="post" enctype="multipart/form-data">
													<div class="card-body">

														<div class="form-group mb-2 row">
															<label class="col-sm-3 col-form-label">Existing Password</label>
															<div class="col-sm-9">
																<div class="input-group" title="" data-toggle="tooltip" data-placement="top" title=""
																	data-original-title="Existing Password">
																	<!-- <span class="input-group-addon"><i class="icofont icofont-lock"></i></span> -->
																	<input type="password" name="txt_ex_password" id='txt_ex_password'
																		class="form-control" maxlength="100" value="" tabindex="1" autofocus required=""
																		placeholder="Existing Password">
																	<div class="input-group-prepend">
																		<div class="input-group-text" onclick="password_visible()"
																			id="id_signup_display_visiblitity"><i class="fas fa-eye-slash custom-icon"></i>
																		</div>
																	</div>

																</div>
															</div>
														</div>

														<div class="form-group mb-2 row">
															<label class="col-sm-3 col-form-label">New Password</label>
															<div class="col-sm-9">
																<div class="input-group" title="" data-toggle="tooltip" data-placement="top" title=""
																	data-original-title="New Password : [Atleast 8 characters and Must Contains Numeric, Capital Letters and Special characters]">
																	<!-- <span class="input-group-addon"><i class="icofont icofont-ui-lock"></i></span> -->
																	<input type="password" name="txt_new_password" id='txt_new_password'
																		class="form-control" maxlength="100" value="" tabindex="2" required=""
																		placeholder="New Password : [Atleast 8 characters and Must Contains Numeric, Capital Letters and Special characters]"
																		onblur="return checkPasswordStrength()">
																	<div class="input-group-prepend">
																		<div class="input-group-text" onclick="password_visible1()"
																			id="display_visiblitity"><i class="fas fa-eye-slash custom-icon"></i>
																		</div>
																	</div>

																</div>
																<div id='idtxt_new_password' class='text-danger'></div>

																<div class="progress" style="margin-top: 3px; height: 3px;">
																	<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0"
																		aria-valuemax="100" style="width:0%" data-toggle="tooltip" data-placement="top"
																		title="" data-original-title="Password Strength Meter"
																		placeholder="Password Strength Meter">
																	</div>
																</div>
															</div>
														</div>

														<div class="form-group mb-2 row">
															<label class="col-sm-3 col-form-label">Confirm Password</label>
															<div class="col-sm-9">
																<div class="input-group" title="" data-toggle="tooltip" data-placement="top" title=""
																	data-original-title="Confirm Password : [Atleast 8 characters and Must Contains Numeric, Capital Letters and Special characters]">
																	<!-- <span class="input-group-addon"><i class="icofont icofont-sand-clock"></i></span> -->
																	<input type="password" name="txt_confirm_password" id='txt_confirm_password'
																		class="form-control" maxlength="100" value="" tabindex="3" required=""
																		placeholder="Your Confirm Password">
																	<div class="input-group-prepend">
																		<div class="input-group-text" onclick="password_visible2()"
																			id="display_visiblitity_1"><i class="fas fa-eye-slash custom-icon"></i>
																		</div>
																	</div>
																</div>
															</div>
														</div>

														<div class="card-footer text-center">
															<span class="error_display" id='pwd_id_error_display'></span><br>
															<input type="hidden" class="form-control" name='pwd_call_function' id='pwd_call_function'
																value='change_pwd' />
															<input type="submit" name="pwd_submit" id="pwd_submit" tabindex="4"
																value="Change Password" class="btn btn-success">
														</div>
												</form>
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

	<script src="libraries/assets//js/xlsx.full.min.js"></script>


	<script>
		function checkPasswordStrength() {
			var number = /([0-9])/;
			var alphabets = /([a-zA-Z])/;
			var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
			if ($('#txt_new_password').val().length < 8) {
				$('#idtxt_new_password').html("Weak (should be atleast 8 characters.)");
				$('#txt_new_password').css('border-color', 'red');
				return false;
			} else {
				if ($('#txt_new_password').val().match(number) && $('#txt_new_password').val().match(alphabets) && $('#txt_new_password').val().match(special_characters)) {
					$('#idtxt_new_password').html("");
					$('#txt_new_password').css('border-color', '#a0a0a0');
					return true;
				} else {
					$('#idtxt_new_password').html("Medium (should include alphabets, numbers and special characters.)");
					$('#txt_new_password').css('border-color', 'red');
					return false;
				}
			}
		}

		function password_visible1() {
			var x = document.getElementById("txt_new_password");
			if (x.type === "password") {
				x.type = "text";
				$('#display_visiblitity').html('<i class="fas fa-eye"></i>');
			} else {
				x.type = "password";
				$('#display_visiblitity').html('<i class="fas fa-eye-slash custom-icon"></i>');
			}
		}

		function password_visible2() {
			var x = document.getElementById("txt_confirm_password");
			if (x.type === "password") {
				x.type = "text";
				$('#display_visiblitity_1').html('<i class="fas fa-eye"></i>');
			} else {
				x.type = "password";
				$('#display_visiblitity_1').html('<i class="fas fa-eye-slash custom-icon"></i>');
			}
		}

		function password_visible() {
			var x = document.getElementById("txt_ex_password");
			if (x.type === "password") {
				x.type = "text";
				$('#id_signup_display_visiblitity').html('<i class="fas fa-eye"></i>');
			} else {
				x.type = "password";
				$('#id_signup_display_visiblitity').html('<i class="fas fa-eye-slash custom-icon"></i>');
			}
		}

		$("#pwd_submit").click(function (e) {
			$("#pwd_id_error_display").html("");

			//get input field values
			var ex_password = $('#txt_ex_password').val();
			var new_password = $('#txt_new_password').val();
			var confirm_password = $('#txt_confirm_password').val();

			var flag = true;
			/********validate all our form fields***********/
			/* password field validation  */
			if (ex_password == "") {
				$('#txt_ex_password').css('border-color', 'red');
				flag = false;
				e.preventDefault();
			}
			if (new_password == "") {
				$('#txt_new_password').css('border-color', 'red');
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

			/* ex password, new password, confirm_password field validation  */
			if (new_password == ex_password && (new_password != '') && (ex_password != '')) {
				$('#txt_new_password').css('border-color', 'red');
				$("#pwd_id_error_display").html("New Password cannot same with Existing Password");
				flag = false;
				e.preventDefault();
			}

			if (confirm_password != "" && new_password != "" && confirm_password != new_password) {
				$('#txt_confirm_password').css('border-color', 'red');
				$("#pwd_id_error_display").html("Confirm Password mismatch with New Password");
				flag = false;
				e.preventDefault();
			}
			/********Validation end here ****/

			/* If all are ok then we send ajax request to ajax/call_functions.php *******/
			if (flag) {
				$('#txt_confirm_password').css('border-color', '');
				$('#txt_ex_password').css('border-color', '');
				var data_serialize = $("#frmid_change_pwd").serialize();
				$.ajax({
					type: 'post',
					url: "ajax/call_functions.php",
					dataType: 'json',
					data: data_serialize,
					beforeSend: function () {
						$('#pwd_submit').attr('disabled', true);
						$('#load_page').show();
					},
					complete: function () {
						$('#pwd_submit').attr('disabled', false);
						$('#load_page').hide();
					},
					success: function (response) {
						if (response.status == '0') {
							$('#txt_ex_password').val('');
							$('#txt_new_password').val('');
							$('#txt_confirm_password').val('');
							$('#pwd_submit').attr('disabled', false);
							$("#pwd_id_error_display").html(response.msg);
						} else if (response.status == 1) {
							$('#pwd_submit').attr('disabled', false);
							$("#pwd_id_error_display").html("Password Changed..Kindly Login The New Password!");
							setInterval(function () {
								window.location = 'index';
							}, 2000);
						}
						$('#load_page').hide();
					},
					error: function (response, status, error) {
						$('#txt_ex_password').val('');
						$('#txt_new_password').val('');
						$('#txt_confirm_password').val('');
						$('#pwd_submit').attr('disabled', false);
						$("#pwd_id_error_display").html(response.msg);
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

			// Check for the character-set constraints
			// and update percentage variable as needed.

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
			if (percentage > 80) {
				$("#strength_display").html("");
			} else {
				$("#strength_display").html(strn_disp);
			}
		}
		// Update progress bar as per the input
		$(document).ready(function () {
			// Whenever the key is pressed, apply condition checks.
			$("#txt_new_password").keyup(function () {
				var m = $(this).val();
				var n = m.length;

				// Function for checking
				check(n, m);
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
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());

	gtag('config', 'UA-23581568-13');
</script>
	<script src="libraries/assets/js/rocket-loader.min.js" data-cf-settings="461d1add94eeb239155d648f-|49"
		defer=""></script>
</body>

<!-- Mirrored from colorlib.com/polygon/admindek/default/compose_sms.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 12 Dec 2019 16:09:13 GMT -->

</html>
