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
    <title>Compose Whatsapp Approve ::
        <?= htmlspecialchars($site_title, ENT_QUOTES, 'UTF-8') ?>
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

</head>
<style>
.theme-loader {
    display: block;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 100;
    width: 100%;
    height: 100%;
    background-color: rgba(192, 192, 192, 0.5);
    background-image: url("assets/img/loader.gif");
    background-repeat: no-repeat;
    background-position: center;
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
                                            <h5>Compose Whatsapp Approve</h5>
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
                                                <a href="">Compose Whatsapp Approve</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pcoded-inner-content">
                            <!-- <P>main CONTENT</P> -->
                            <div class="section-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="table-responsive" id="id_approve_whatsapp">
                                                    Loading..
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
                    <p>Are you sure you want to reject ?</p>
                </div>
                <div class="modal-footer">
                    <span class="error_display" id='id_error_reject' style="color: red;"></span>
                    <button type="button" class="btn btn-danger reject_btn">Reject</button>
                    <button type="button" class="btn btn-secondary cancel_btn" data-dismiss="modal">Cancel</button>
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


    <!-- Confirmation details content-->
    <div class="modal" tabindex="-1" role="dialog" id="approve_error">
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
                        <span id="split_error"></span>
                    </div>
                </div>
                <div class="modal-footer" style="margin-right:40%; text-align: center;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Okay</button>
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
        <div class="modal-body" id="id_modal_display" style=" word-wrap: break-word; word-break: break-word;">
          <h5>No Data Available</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success waves-effect " data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
    <script src="libraries/assets//js/xlsx.full.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="libraries/assets/js/jquery.dataTables.min-1.js"></script>
    <script src="libraries/assets/js/dataTables.buttons.min-1.js"></script>
    <script src="libraries/assets/js/dataTables.searchPanes.min-1.js"></script>
    <script src="libraries/assets/js/dataTables.select.min-1.js"></script>
    <script>
$(document).ready(function() {
    find_approve_template();
    // Uncomment for auto-refresh every minute
    // setInterval(find_approve_template, 60000);
});

// To list the rcs No from API
function find_approve_template() {
    $.ajax({
        type: 'post',
        url: "ajax/display_functions.php?call_function=approve_whatsapp_list",
        dataType: 'html',
        success: function(response) {
            $("#id_approve_whatsapp").html(response);
        }
    });
}

function approve_campaign_popup(compose_whatsapp_id, user_id, indicatori) {
    user_ids = user_id;
    compose_whatsapp_ids = compose_whatsapp_id;
    indicatoris = indicatori;
    $('#approve-Modal').modal('show');
}

$('#approve-Modal').find('.btn-success').off().one('click', function() {
    $('#approve-Modal').modal('hide');
    func_save_phbabt(compose_whatsapp_ids, user_ids, indicatoris);
});

function campaign_status_popup(compose_message_id, user_id, approve_status, indicatori) {
    console.log(compose_message_id, user_id, approve_status, indicatori);
    compose_message_ids = compose_message_id;
    user_ids = user_id;
    approve_statuss = approve_status;
    indicatoris = indicatori;
    $('#reject-Modal').modal('show');
}

document.body.addEventListener("click", function (evt) {
    if (!evt.target.closest('#reject-Modal') && !evt.target.closest('.modal-dialog')) {
        $('#reject_reason').val('');
        $('#id_error_reject').html('');
    }
});

$('#reject-Modal').find('.btn-danger').off('click').on('click', function() {
    let reason = $('#reject_reason').val().trim();
    if (reason === "") {
        $("#id_error_reject").html("Please enter a reason to reject");
    } else if (reason.length < 4 || reason.length > 50) {
        $("#id_error_reject").html("Reason to reject must be between 4 and 50 characters.");
        $('#reject-Modal').modal({ show: true, backdrop: 'static', keyboard: false });
    } else {
        $('.reject_btn').attr("data-dismiss", "modal");
        $('#reject-Modal').modal('hide');
        change_status(compose_message_ids, user_ids, approve_statuss, indicatoris, reason);
    }
});

function func_save_phbabt(compose_id, user_id, indicatori) {
    var send_code = `&compose_message_id=${compose_id}&approve_status=Y&selected_userid=${user_id}`;
    $.ajax({
        type: 'post',
        url: `ajax/message_call_functions.php?tmpl_call_function=approve_reject_campaign_Whatsapp${send_code}`,
        dataType: 'json',
        beforeSend: function() { $('.theme-loader').show(); },
        complete: function() { $('.theme-loader').hide(); },
        success: function(response) {
            if (response.status == 1) {
                $('#image_display').attr('src', 'libraries/assets/png/success.png');
                $('#split_error').text("Campaign started successfully");
                $('#approve_error').modal('show');
                setTimeout(() => { window.location = 'compose_whatsapp_approval'; }, 2000);
            } else if (response.status == 403) {
                window.location = 'index';
            } else {
                $('#image_display').attr('src', 'libraries/assets/png/failed.png');
                $('#split_error').text(response.msg);
                $('#approve_error').modal('show');
            }
        },
        error: function(xhr) { console.error('AJAX Error:', xhr.responseText); }
    });
}

function change_status(compose_message_id, user_id, approve_status, indicatori, reason) {
    var send_code = `&compose_message_id=${compose_message_id}&approve_status=${approve_status}&selected_userid=${user_id}&reason=${reason}`;
    $.ajax({
        type: 'post',
        url: `ajax/message_call_functions.php?tmpl_call_function=approve_reject_campaign_Whatsapp${send_code}`,
        dataType: 'json',
        success: function(response) {
            if (response.status == 1) {
                $('#id_approved_lineno_' + indicatori).html('<a href="javascript:void(0)" class="btn disabled btn-outline-danger">Rejected</a>');
                setTimeout(() => { window.location = 'compose_whatsapp_approval'; }, 2000);
            } else if (response.status == 403) {
                window.location = 'index';
            }
        }
    });
}

function clsAlphaNoOnly(e) {
    var key = e.keyCode;
    return (key >= 65 && key <= 90) || (key >= 97 && key <= 122) || (key >= 48 && key <= 57) || key == 32 || key == 95;
}

function call_getsingletemplate(tmpl_name, indicatori) {
    var template_name = tmpl_name.split('!');
    $("#slt_whatsapp_template_single").html("");
    $.ajax({
        type: 'post',
        url: `ajax/whatsapp_call_functions.php?previewTemplate_meta=previewTemplate_meta&tmpl_name=${tmpl_name}`,
        success: function(response_msg) {
            if (response_msg.msg == '-') {
                $("#id_modal_display").html(`Template Name : ${template_name[0]}<br>No Data Available!!`);
            } else {
                $("#id_modal_display").html(`Template Name : ${template_name[0]}<br>${response_msg.msg}`);
            }
            $('#default-Modal').modal('show');
        },
        error: function(response_msg) {
            $("#id_modal_display").html(response_msg.msg);
            $('#default-Modal').modal('show');
        }
    });
}

    // To Show Datatable with Export, search panes and Column visible
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

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-23581568-13');
    </script>
    <script src="libraries/assets/js/rocket-loader.min.js" data-cf-settings="461d1add94eeb239155d648f-|49" defer="">
    </script>
</body>

<!-- Mirrored from colorlib.com/polygon/admindek/default/form-elements-add-on.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 12 Dec 2019 16:09:13 GMT -->

</html>
