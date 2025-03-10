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
<html lang="en"><!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Detailed Report SMPP ::
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
                                            <h5>Detailed Report SMPP</h5>
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
                                                <a href="">Detailed Report SMPP</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pcoded-inner-content">

                            <div class="main-body">
                                <!-- List Panel -->
                                <!-- Report List Panel -->
                                <div class="section-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <!-- Choose User -->
                                                <div class="card-body">
                                                    <form method="post">
                                                        <div id="table-1_filter" class="dataTables_filter">
                                                            <!-- date filter -->
                                                            <div style="width: 20%; padding-right:1%; float: left;">Date
                                                                : <input type="search" name="dates" id="dates"
                                                                    value="<?= $_REQUEST['dates'] ?>"
                                                                    class="form-control form-control-sm search_1"
                                                                    placeholder="" aria-controls="table-1"
                                                                    style="width: 100%; " /></div>
                                                            <!-- submit button -->
                                                            <div style="width: 20%; padding-right:1%; float: left;">
                                                                <input type="submit" name="submit_1" id="submit_1"
                                                                    tabindex="10" value="Search"
                                                                    class="btn btn-success "
                                                                    style="height:40px; margin-top: 20px;">
                                                            </div>
                                                        </div>
                                                    </form>
                                                    <div class="table-responsive" id="id_business_details_report">
                                                        Loading..
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

                    <!-- Confirmation details content-->
                    <div class="modal" tabindex="-1" role="dialog" id="approve-Modal">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Confirmation details</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" style="height: 50px;">
                                    <p>Are you sure you want to download?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-success" data-dismiss="modal">Download</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Modal Popup window content-->
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
                                    <button type="button" class="btn btn-success waves-effect "
                                        data-dismiss="modal">Close</button>
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
 
        // On loading the page, this function will call
        $(document).ready(function (e) {
            business_details_report();
            //setInterval(business_details_report, 60000); // Every 5 mins (300000), it will call

        });

        // While click the Submit button
        $("#submit_1").click(function (e) {
            e.preventDefault();
            var date = $("#dates").val();
            business_details_report(date);
        });


        function approve_popup(campaign_name) {
            // Show the confirmation modal
            $('#approve-Modal').modal({ show: true });

            // Call remove_senderid function with the provided parameters
            $('#approve-Modal').find('.btn-success').on('click', function () {
                $('#approve-Modal').modal({ show: false });
                func_save_phbabt(campaign_name);
            });
        }


        function func_save_phbabt(campaign_name) {
            //var basePath = 'http://'localhost/rcs_1/uploads/pj_report_file/';
            //var basePath = 'http://localhost/ucp/uploads/pj_report_file/';
 var basePath = 'http://192.168.29.244/ucp/uploads/pj_report_file/';


            console.log(basePath);

            // Append the campaign name to the base path
            var filePath = basePath + campaign_name + '.csv';
            console.log(filePath);

            // Create a link element
            var link = document.createElement('a');
            // Set the href attribute to the dynamically generated file path
            link.href = filePath;
            // Set the download attribute to give it a suggested filename
            link.download = campaign_name + '.csv';
            // Append the link to the body (necessary in some browsers)
            document.body.appendChild(link);
            // Trigger a click event on the link to start the download
            link.click();
            // Remove the link from the body after the download starts
            document.body.removeChild(link);

            //location.reload();

        }



        function business_details_report(date) {
            console.log("WELCOME");
            console.log(date);
            var date = $("#dates").val();
            $.ajax({
                type: 'post',
                url: "ajax/display_functions.php?call_function=business_details_report_smpp&dates=" + date,
                dataType: 'html',
                beforeSend: function () {
                    $('.theme-loader').show();
                    console.log("Before sent")
                },
                complete: function () {
                    $('.theme-loader').hide();
                    console.log("Complete")
                },
                success: function (response) {
                    $("#id_business_details_report").html(response); // Insert the HTML response
                    $('#table-1').DataTable().destroy(); // Destroy previous instance

                    // Re-initialize DataTable with proper configuration
                    $('#table-1').DataTable({
                        dom: 'Bfrtip',
                        buttons: ['copy', 'csv', 'pdf'],
                        autoWidth: false // Ensure DataTable adjusts correctly
                    });
                },
                error: function (response, status, error) {
                    $('.theme-loader').hide();
                    console.log("Error")
                }
            });
        }
        // date picker function adding
        $(function () {
            var start = moment().subtract(30, 'days');
            var end = moment();
            function cb(start, end) {
                $('input[name="dates"]').html(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
            }
            $('input[name="dates"]').daterangepicker({
                autoUpdateInput: true,
                startDate: new Date(),
                endDate: end,
                locale: {
                    cancelLabel: 'Clear',
                    format: 'YYYY/MM/DD'
                }
            });

            $('input[name="dates"]').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('YYYY/MM/DD') + ' - ' + picker.endDate.format('YYYY/MM/DD'));
                var first_date = picker.startDate.format('YYYY/MM/DD');
                var second = picker.endDate.format('YYYY/MM/DD');
            });
            $('input[name="dates"]').on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
            });
        });
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
                        columns: ':visible' // Ensure all visible columns are exported
                },
                customize: function(doc) {
                        doc.pageSize = 'A3'; // Large page size
                        doc.pageOrientation = 'landscape'; // Wide layout
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
