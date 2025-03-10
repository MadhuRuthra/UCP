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
?>
<!DOCTYPE html>
<html lang="en">

<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title> Approve Whatsapp SenderID List ::
        <?= htmlspecialchars($site_title, ENT_QUOTES, 'UTF-8') ?>
    </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description"
        content="Admindek Bootstrap admin Approve Whatsapp SenderID made using Bootstrap 4 and it has huge amount of ready made feature, UI components, pages which completely fulfills any dashboard needs." />
    <meta name="keywords"
        content="bootstrap, bootstrap admin Approve Whatsapp SenderID, admin theme, admin dashboard, dashboard Approve Whatsapp SenderID, admin Approve Whatsapp SenderID, responsive" />
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
    <link rel="stylesheet" type="text/css"
        href="libraries\bower_components\bootstrap-daterangepicker\css\daterangepicker.css">

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
    grid-Approve Whatsapp SenderID-columns: repeat(3, 1fr);
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
                    <?php include("libraries/site_header.php"); ?>
                    <?php include("libraries/site_menu.php"); ?>
                    <div class="pcoded-content">

                        <div class="page-header card">
                            <div class="row align-items-end">
                                <div class="col-lg-8">
                                    <div class="page-header-title">
                                        <i class="feather icon-clipboard bg-c-blue"></i>
                                        <div class="d-inline">
                                            <h5>Approve Whatsapp SenderID List</h5>
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
                                                <a href="">Approve Whatsapp SenderID List</a>
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

                                    <div class="col-12">
                                        <div class="card">
                                            <!-- Choose User -->
                                            <div class="card-body">
                                                <div class="table-responsive" id="id_approve_whatsapp_no_api">
                                                    Loading…
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

        <!-- Confirmation details content-->
               <div class="modal" id="default-Modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                        <div class="modal-content">
                                <div class="modal-header">
                                        <h4 class="modal-title">Confirmation details</h4>
                                        <button type="button" class="close close_model" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                        </button>
                                </div>
                                <div class="modal-body">
                                              <form class="needs-validation" novalidate="" id="frm_sender_id" name="frm_sender_id" action="#"
                        method="post" enctype="multipart/form-data">

                        <div class="form-group mb-2 row">
                            <label class="col-sm-3 col-form-label">Reason <label style="color:#FF0000">*</label></label>
                            <div class="col-sm-9">
                                <input class="form-control form-control-primary" type="text" name="reject_reason"
                                    id="reject_reason" maxlength="50" title="Reason to Reject" tabindex="12"
                                    placeholder="Reason to Reject" onkeydown="return /[a-z, ]/i.test(event.key)">
                            </div>
                        </div>
                    </form>
                                        <p>Are you sure you want to Reject ?</p>
                                </div>
                                <div class="modal-footer">
                                       <span class="error_display" id='id_error_reject' style="color: red;"></span>
                                        <button type="button" class="btn btn-danger">Reject</button>
                                        <button type="button" class="btn btn-secondary close_model" data-dismiss="modal">Cancel</button>
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

    <script src="libraries/assets/js/moment.min.js"></script>
    <!-- Date-range picker js -->
    <script type="text/javascript" src="libraries\bower_components\bootstrap-daterangepicker\js\daterangepicker.js">
    </script>

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


  <script>
    // On loading the page, this function will call
    $(document).ready(function() {
        find_approve_whatsapp_no_api();
    });
    // start function document
    $(function() {
        $('.theme-loader').fadeOut("slow");
    });

    // To list the Whatsapp No from API
    function find_approve_whatsapp_no_api() {
        $.ajax({
            type: 'post',
            url: "ajax/display_functions.php?call_function=approve_whatsapp_no_api",
            dataType: 'html',
            success: function(response) {
                $("#id_approve_whatsapp_no_api").html(response);
            },
            error: function(response, status, error) {}
        });
    }
    setInterval(find_approve_whatsapp_no_api, 60000); // Every 1 min (60000), it will call


    //popup function
    function func_save_phbabt_popup(indicatori, whatspp_config_id, text_value, phone_number_id,
        whatsapp_business_acc_id, bearer_token_value, mobile_number) {
        // $(".btn-outline-danger").remove();
        $('#' + text_value).remove();
        let phone_numberid = $('input[name' + "=" + 'phone_number_id' + "_" + text_value + ']').val();
        let whatsapp_business_accid = $('input[name' + "=" + 'whatsapp_business_acc_id' + "_" + text_value + ']').val();
        let bearer_token_value_id = $('input[name' + "=" + 'bearer_token_value' + "_" + text_value + ']').val();
        if ((phone_numberid == '') && (whatsapp_business_accid == '') && (bearer_token_value_id == '')) {
            $('#id_approved_lineno_' + text_value).append('<a href="javascript:void(0)" id="' + text_value +
                '" class="btn disabled btn-outline-danger">Kindly fill all the fields.!!</a>');
        } else if ((phone_numberid.length != 15) || (whatsapp_business_accid.length != 15)) {
            $('#id_approved_lineno_' + text_value).append('<a href="javascript:void(0)" id="' + text_value +
                '" class="btn disabled btn-outline-danger">Invalid format!</a>');
        } else if (bearer_token_value_id == '') {
            $('#id_approved_lineno_' + text_value).append('<a href="javascript:void(0)" id="' + text_value +
                '" class="btn disabled btn-outline-danger">Kindly fill all the fields.!!</a>');
        } else {
            $(".btn-outline-danger").remove();
            $('#approve-Modal').modal({
                show: true
            });
            // Call remove_senderid function with the provided parameters
            $('#approve-Modal').find('.btn-success').on('click', function() {
                $('#approve-Modal').modal({
                    show: false
                });
                func_save_phbabt(indicatori, whatspp_config_id, text_value, phone_number_id,
                    whatsapp_business_acc_id, bearer_token_value, mobile_number);
            });
        }
    }


    // To save the Phone no id, business account id, bearer token
    function func_save_phbabt(indicatori, whatspp_config_id, text_value, phone_number_id, whatsapp_business_acc_id,
        bearer_token_value, mobile_number) {
        let phone_numberid = $('input[name' + "=" + 'phone_number_id' + "_" + text_value + ']').val();
        let whatsapp_business_accid = $('input[name' + "=" + 'whatsapp_business_acc_id' + "_" + text_value + ']').val();
        let bearer_token_value_id = $('input[name' + "=" + 'bearer_token_value' + "_" + text_value + ']').val();
        var send_code = `&whatspp_config_id=${whatspp_config_id}&phone_number_id=${phone_numberid}&whatsapp_business_acc_id=${whatsapp_business_accid}&bearer_token_value=${bearer_token_value_id}&mobile_number=${mobile_number}`;
        $.ajax({
            type: 'post',
            url: "ajax/message_call_functions.php?tmpl_call_function=save_phbabt" + send_code,
            dataType: 'json',
            beforeSend: function() {
                $('.theme-loader').show();
            },
            complete: function() {
                $('.theme-loader').hide();
            },
            success: function(response) { // Success
                if (response.status == 0) {
                    $('#id_approved_lineno_' + text_value).html('<a href="javascript:void(0)" class="btn disabled btn-outline-danger">' +(response.msg == null ? 'Success' : response.msg) + '</a>' );
                        setTimeout(function() {
                           window.location = 'approve_whatsapp_no_api';
                                 }, 5000); // Redirect after 5 seconds
                        } else { // Success
                      $('#id_approved_lineno_' + text_value).html('<a href="javascript:void(0)" class="btn disabled btn-outline-success">Success</a>'
                        );
                    setTimeout(function() {
                        window.location = 'approve_whatsapp_no_api';
                    }, 3000); // Every 3 seconds it will check
                    $('.theme-loader').hide();
                }
            },
            error: function(response, status, error) { // Error
            }
        });
    }



// Popup function to show the modal
function change_status_popup(whatspp_config_id, approve_status, indicatori) {
    $('#default-Modal').modal('show'); // Show the modal

    // Attach a click event handler to the modal's danger button (delegated to avoid duplication)
    $('#default-Modal').off('click', '.btn-danger').on('click', '.btn-danger', function () {
        const reason = $('#reject_reason').val().trim(); // Trim input to avoid unnecessary validation failures

        // Validation checks
        if (!reason) {
            $("#id_error_reject").html("Please enter a reason to reject");
        } else if (reason.length < 4 || reason.length > 50) {
            $("#id_error_reject").html("Reason to reject must be between 4 and 50 characters.");
        } else {
            // Clear error, hide modal, and proceed with sender ID removal
            $("#id_error_reject").html("");
            $('#default-Modal').modal('hide');
            remove_senderid(whatspp_config_id, approve_status, indicatori,reason); // Call the removal function
        }
    });
}

// Function to delete the sender ID from the list
function remove_senderid(whatspp_config_id, approve_status, indicatori,reason) {
    const send_code = `&whatspp_config_id=${whatspp_config_id}&approve_status=${approve_status}&reject_reason=${reason}`;
    $.ajax({
        type: 'POST',
        url:  "ajax/message_call_functions.php?tmpl_call_function=approve_whatsappno" + send_code,
        dataType: 'json',
        success: function (response) {
            if (response.status == 0) {
                // Show 'Not Deleted' status
                $(`#id_approved_lineno_${indicatori}`).html('<a href="javascript:void(0)" class="btn disabled btn-outline-warning">Not Rejected</a>');
            } else {
                // Show 'Deleted' status and reload the page
                $(`#id_approved_lineno_${indicatori}`).html('<a href="javascript:void(0)" class="btn disabled btn-outline-danger">Rejected</a>');
                window.location.reload();
            }
        },
        error: function (xhr, status, error) {
            console.error("Error in AJAX request:", status, error);
        }
    });
}

document.body.addEventListener("click", function (evt) {
    if (!evt.target.closest('#default-Modal') && !evt.target.closest('.modal-dialog')) {
        $('#reject_reason').val(''); // Clear the input field
        $('#id_error_reject').html(''); // Clear error messages
    }
});

    // To Show Datatable with Export, search panes and Column visible
    $('#table-1').DataTable({
        // dom: 'Bfrtip',
        dom: 'PlBfrtip',
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
            /* }, {
              extend: 'searchPanes',
              config: {
                cascadePanes: true
              } */
        }, 'colvis'],
        /* columnDefs: [{
          searchPanes: {
            show: false
          },
          targets: [0]
        },
        {
          targets: -6,
          visible: false
        }
        ] */
    });
    </script>

    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"
        type="461d1add94eeb239155d648f-text/javascript"></script>
    <script type="461d1add94eeb239155d648f-text/javascript">
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-23581568-13');
    </script>
    <script src="libraries/assets/js/rocket-loader.min.js" data-cf-settings="461d1add94eeb239155d648f-|49" defer="">
    </script>
</body>

<!-- Mirrored from colorlib.com/polygon/admindek/default/compose_sms.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 12 Dec 2019 16:09:13 GMT -->

</html>
