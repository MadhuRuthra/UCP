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
	<title> Generate Report List SMPP ::
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
	<!-- CSS Libraries -->
	<link rel="stylesheet" href="libraries/assets/css/jquery.dataTables.min-1.css">
	<link rel="stylesheet" href="libraries/assets/css/searchPanes.dataTables.min-1.css">
	<link rel="stylesheet" href="libraries/assets/css/select.dataTables.min-1.css">
	<link rel="stylesheet" href="libraries/assets/css/colReorder.dataTables.min-1.css">
	<link rel="stylesheet" href="libraries/assets/css/buttons.dataTables.min-3.css">
	<!-- Date-range picker css  -->
<link rel="stylesheet" type="text/css" href="libraries\bower_components\bootstrap-daterangepicker\css\daterangepicker.css">

</head>
<style>
	.card-info {
		margin-bottom: 20px;
		/* Space between card info and suggestions */
	}

	.card-fields {
		display: flex;
		flex-direction: column;
		align-items: flex-start;
	}

	.suggestion-rows {
		display: flex;
		flex-direction: column;
		width: 100%;
	}

	.suggestion-row {
		display: flex;
		justify-content: space-between;
		/* Adjusts space between boxes */
		margin-bottom: 10px;
		/* Space between rows */
	}

	.action-box {
		border: 1px solid #ddd;
		padding: 10px;
		margin-right: 10px;
		/* Space between boxes */
		border-radius: 5px;
		background-color: #f9f9f9;
		width: 48%;
		/* Adjust width to fit two boxes in one row */
	}

	.text-box {
		border: 1px solid #ddd;
		padding: 10px;
		border-radius: 5px;
		background-color: #f9f9f9;
	}

	.suggestion-card-container {
		display: grid;
		grid-template-columns: repeat(3, 1fr);
		/* Creates three equal-width columns */
		gap: 16px;
		/* Space between cards */
	}

	.suggestion-card {
		padding: 16px;
		border: 1px solid #ddd;
		border-radius: 8px;
		box-sizing: border-box;
		background-color: #fff;
		/* Optional: background color for cards */
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
											<h5>Generate Report SMPP</h5>
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
												<a href="">Generate Report SMPP</a>
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
													<div class="table-responsive" id="report_generate_list">
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

	<script src="libraries\assets\js\moment.min.js"></script>
<!-- Date-range picker js -->
<script type="text/javascript" src="libraries\bower_components\bootstrap-daterangepicker\js\daterangepicker.js"></script>

	<script src="libraries/assets/js/jquery.dataTables.min-1.js"></script>
	<script src="libraries/assets/js/dataTables.buttons.min-1.js"></script>
	<script src="libraries/assets/js/dataTables.searchPanes.min-1.js"></script>
	<script src="libraries/assets/js/dataTables.select.min-1.js"></script>

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

	<script type="text/javascript">
    $(document).ready(function () {
      find_approve_template();
    }); 

    // business_summary_report func  
    function find_approve_template() {
      $.ajax({
        type: 'post',
        url: "ajax/display_functions.php?call_function=generate_report_list_smpp",
        dataType: 'html',
        success: function (response) {
          $("#report_generate_list").html(response);
        },
        error: function (response, status, error) { }
      });
    }

 
    function approve_popup(compose_whatsapp_id, user_id) {
      console.log(compose_whatsapp_id);
      console.log(user_id);
      $('#approve-Modal').modal('show'); // Simplified modal show method

      // Call remove_senderid function with the provided parameters
      $('#approve-Modal').find('.btn-success').on('click', function () {
        // Get the file input element
        func_save_phbabt(compose_whatsapp_id, user_id);
      });
    }


    function func_save_phbabt(compose_whatsapp_id, user_id) {

      var send_code = "&user_id=" + user_id + "&compose_whatsapp_id=" + compose_whatsapp_id
      $.ajax({
        type: 'post',
        url: "ajax/message_call_functions.php?tmpl_call_function=generate_report_smpp" + send_code,
        processData: false, // Prevent jQuery from processing the data
        contentType: false, // Set content type to false
        dataType: 'json',
        beforeSend: function () {
          $('.theme-loader').show();
        },
        complete: function () {
          $('.theme-loader').hide();
        },
        success: function (response) { // Success
          console.log(response);
          if (response.status == 0) {
            console.log("success");
            // Every 3 seconds it will check
            $('#id_approved_lineno_').html('<a href="javascript:void(0)" class="btn disabled btn-outline-success">' + response.msg + '</a>');
            setTimeout(function () {
              window.location = 'generate_report_list_smpp';
            }, 1000);
          } else { // Success
            console.log("else");
            $('#id_approved_lineno_').html('<a href="javascript:void(0)" class="btn disabled btn-outline-success">Success</a>');
            setTimeout(function () {
              window.location = 'generate_report_list_smpp';
            }, 1000); // Every 3 seconds it will check
            $('.theme-loader').hide();
          }
        },
        error: function (response, status, error) { // Error
          console.log("error");
          console.log(error);
          console.log(response)

        }
      });
    }

    // function adding to the filters
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
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());

	gtag('config', 'UA-23581568-13');
</script>
	<script src="libraries/assets/js/rocket-loader.min.js" data-cf-settings="461d1add94eeb239155d648f-|49"
		defer=""></script>
</body>

<!-- Mirrored from colorlib.com/polygon/admindek/default/compose_sms.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 12 Dec 2019 16:09:13 GMT -->

</html>
