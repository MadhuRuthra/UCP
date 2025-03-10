<?php
/*
This page has some functions which is access from Frontend.
This page is act as a Backend page which is connect with Node JS API and PHP Frontend.
It will collect the form details and send it to API.
After get the response from API, send it back to Frontend.

Version : 1.0
Author : Selvalakshmi N (YJ0018)
Date : 03-DEC-2024
*/

session_start(); // Start session
error_reporting(E_ALL); // The error reporting function
// Buffer output to prevent sending data before the redirect
ob_start();
include_once('../api/configuration.php'); // Include configuration.php
include_once "../api/send_request.php"; // Include configuration.php
extract($_REQUEST); // Extract the request
$current_date = date("Y-m-d H:i:s"); // To get currentdate function
$bearer_token = 'Authorization: ' . $_SESSION['smpp_bearer_token'] . ''; // To get bearertoken
// Step 1: Get the current date
$todayDate = new DateTime();
// Step 2: Convert the date to Julian date
$baseDate = new DateTime($todayDate->format('Y-01-01'));
$julianDate = $todayDate->diff($baseDate)->format('%a') + 1; // Adding 1 since the day of the year starts from 0
// Step 3: Output the result in 3-digit format
$year = date("Y");
$julian_dates = str_pad($julianDate, 3, '0', STR_PAD_LEFT);
$hour_minutes_seconds = date("His");
$random_generate_three = rand(100, 999);


// template_list Page template_list - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $call_function == "template_list") {
    
        site_log_generate("Template List Page : User : " . $_SESSION['smpp_user_name'] . " Preview on " . date("Y-m-d H:i:s"), '../');
        // Here we can Copy, Export CSV, Excel, PDF, Search, Column visibility the Table            ?>
<form name="myform" id="myForm" method="post" action="message_credit">
    <input type="hidden" name="bar" id="bar" value="" />
</form>
<table class="table table-nomargin text-center" id="table-1">
    <thead>
        <tr class="text-center">
            <th>#</th>
            <th>User</th>
            <th style="width: 200px !important;">Message Content</th>
            <th>compose Name</th>
            <th>Mobile No Count</th>
            <th>Rejected Reason</th>
            <th>Status</th>
            <th>Entry Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody style=" text-align: center;">
        <?
                        // To Send the request API
                        $replace_txt = '{
             "user_id" : "' . $_SESSION['smpp_user_id'] . '",
                        "rights_name": "SMS"
                 }';
           
                // Call the reusable cURL function
                        $response = executeCurlRequest($api_url . "/list/compose_sms_list", "GET", $replace_txt);
                        // After got response decode the JSON result
                        if (empty($response)) {
                                // Redirect to index.php if response is empty
                                header("Location: index");
                                exit(); // Stop further execution after redirect
                        }
                        // After got response decode the JSON result
                        $sms = json_decode($response, false);
                        $indicatori = 0;

                        if ($sms->num_of_rows > 0) {
                                // If the response is success to execute this condition
                                for ($indicator = 0; $indicator < $sms->num_of_rows; $indicator++) {
                                        // Looping the indicator is less than the num_of_rows.if the condition is true to continue the process.if the condition is false to stop the process
                                        $indicatori++;
                                        $approve_date = '-';
                                        // To get the one by one data
                                        if ($sms->templates[$indicator]->ucp_start_date != '' and $sms->templates[$indicator]->ucp_start_date != '00-00-0000 12:00:00 AM') {
                                                $entry_date = date('d-m-Y h:i:s A', strtotime($sms->templates[$indicator]->ucp_start_date));
                                        }
                                        if ($sms->templates[$indicator]->approve_date != '' and $sms->templates[$indicator]->approve_date != '0000-00-00 00:00:00' and $sms->templates[$indicator]->approve_date != '00-00-0000 12:00:00 AM') {
                                                $approve_date = date('d-m-Y h:i:s A', strtotime($sms->templates[$indicator]->approve_date));
                                        }
                                        ?>
        <tr>
            <td>
                <?= $indicatori ?>
            </td>
            <td>
                <?= $sms->templates[$indicator]->user_name; ?>
            </td>
            <td
                style="max-width: 300px; width: 300px; word-wrap: break-word; white-space: normal; overflow: hidden; text-align: justify; padding: 10px;">
                <?= htmlspecialchars($sms->templates[$indicator]->message_content); ?>
            </td>

            <td>
                <?= $sms->templates[$indicator]->unique_compose_id; ?>
            </td>
            <td>
                <?= strtoupper($sms->templates[$indicator]->total_mobile_no_count); ?>

            </td>
            <td>
                <?= !empty($sms->templates[$indicator]->reject_reason) ? $sms->templates[$indicator]->reject_reason : '-'; ?>
            </td>
            <td>
                <? if ($sms->templates[$indicator]->ucp_status == 'V') { ?><a href="#!"
                    class="btn btn-outline-success btn-disabled" style="width:90px; text-align:center">Approved</a>
                <? } elseif ($sms->templates[$indicator]->ucp_status == 'W') { ?><a href="#!" class="btn
                                                                btn-outline-warning btn-disabled" style="width:90px; text-align:center">Inactive</a>
                <? } elseif ($sms->templates[$indicator]->ucp_status == 'R') { ?><a href="#!"
                    class="btn btn-outline-danger btn-disabled" style="width:90px; text-align:center">Rejected</a>
                <? } elseif ($sms->templates[$indicator]->ucp_status == 'F') { ?><a href="#!" class="btn
                                                                        btn-outline-dark btn-disabled" style="width:90px; text-align:center">Failed</a>
                <? } elseif ($sms->templates[$indicator]->ucp_status == 'D') { ?><a href="#!"
                    class="btn btn-outline-danger btn-disabled" style="width:90px; text-align:center">Deleted</a>
                <? } elseif ($sms->templates[$indicator]->ucp_status == 'S') { ?><a href="#!"
                    class="btn btn-outline-info btn-disabled" style="width:90px; text-align:center">Waiting</a>
                <? } ?>
            </td>
            <td>
                <?= date('d-m-Y h:i:s A', strtotime($sms->templates[$indicator]->compose_entry_date)); ?>
            </td>
            <td id='id_ucp_status_<?= $indicatori ?>'>
                <a href="#!" class="template_btn_<?= $indicatori ?>" onclick="call_getsingletemplate(
                 `<?= htmlspecialchars($sms->templates[$indicator]->message_content, ENT_QUOTES, 'UTF-8') ?>`,
                 '<?= htmlspecialchars($sms->templates[$indicator]->total_mobile_no_count, ENT_QUOTES, 'UTF-8') ?>'
         )">View</a>
                <? if ($sms->templates[$indicator]->ucp_status != 'D') { ?>
                <a href="#!" class="template_btn_<?= $indicatori ?>"
                    onclick="remove_template_popup('<?= $sms->templates[$indicator]->unique_compose_id ?>','<?= $indicatori ?>')">/
                    Delete</a>
                <? } ?>
            </td>
        </tr>
        <?
                                }
                        } else if ($sms->response_status == 403) { ?>
        <script>
        window.location = "index"
        </script>
        <? } else if ($sms->response_status == 204) {
                                $json = array("status" => 2, "msg" => $sms->response_msg);
                        } else {
                                $json = array("status" => 0, "msg" => $sms->response_msg);
                        }
                        ?>
    </tbody>
</table>
<!-- General Datatable JS Scripts -->
<script src="libraries/assets/js/jquery.dataTables.min-1.js"></script>
<script src="libraries/assets/js/dataTables.buttons.min-1.js"></script>
<script src="libraries/assets/js/dataTables.searchPanes.min-1.js"></script>
<script src="libraries/assets/js/dataTables.select.min-1.js"></script>
<script src="libraries/assets/js/jszip.min-3.js"></script>
<script src="libraries/assets/js/pdfmake.min-3.js"></script>
<script src="libraries/assets/js/vfs_fonts-3.js"></script>
<script src="libraries/assets/js/buttons.html5.min-3.js"></script>
<script src="libraries/assets/js/buttons.colVis.min-3.js"></script>
<!-- filter using -->
<script>
$('#table-1').DataTable({
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'copyHtml5',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        {
            extend: 'csvHtml5',
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'pdfHtml5',
            exportOptions: {
                columns: ':visible' // Ensure all visible columns are exported
            },
            customize: function(doc) {
                doc.pageSize = 'A3'; // Large page size
                doc.pageOrientation = 'landscape'; // Wide layout
            }
        },
        'colvis' // Column visibility toggle
    ]
});
</script>
<?
}
// template_list Page template_list - End



// template_list_SMPP Page template_list_SMPP - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $call_function == "template_list_SMPP") {
        site_log_generate("Template List Page : User : " . $_SESSION['smpp_user_name'] . " Preview on " . date("Y-m-d H:i:s"), '../');
        // Here we can Copy, Export CSV, Excel, PDF, Search, Column visibility the Table            ?>
<form name="myform" id="myForm" method="post" action="message_credit">
    <input type="hidden" name="bar" id="bar" value="" />
</form>
<table class="table table-nomargin text-center" id="table-1">
    <thead>
        <tr class="text-center">
            <th>#</th>
            <th>User</th>
            <th>Message Content</th>
            <th>compose Name</th>
            <th>Mobile No Count</th>
            <th>Rejected Reason</th>
            <th>Status</th>
            <th>Entry Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody style=" text-align: center;">
        <?
                        // To Send the request API
                        $replace_txt = '{
            "user_id" : "' . $_SESSION['smpp_user_id'] . '",
                        "rights_name": "SMPP"
               }';

                     
                // Call the reusable cURL function
                        $response = executeCurlRequest($api_url . "/list/compose_smpp_list", "GET", $replace_txt);
                        // After got response decode the JSON result
                        if (empty($response)) {
                                // Redirect to index.php if response is empty
                                header("Location: index");
                                exit(); // Stop further execution after redirect
                        }

                        // After got response decode the JSON result
                        $sms = json_decode($response, false);
                        $indicatori = 0;

                        if ($sms->num_of_rows > 0) {
                                // If the response is success to execute this condition
                                for ($indicator = 0; $indicator < $sms->num_of_rows; $indicator++) {
                                        // Looping the indicator is less than the num_of_rows.if the condition is true to continue the process.if the condition is false to stop the process
                                        $indicatori++;
                                        $approve_date = '-';
                                        // To get the one by one data
                                        if ($sms->templates[$indicator]->ucp_start_date != '' and $sms->templates[$indicator]->ucp_start_date != '00-00-0000 12:00:00 AM') {
                                                $entry_date = date('d-m-Y h:i:s A', strtotime($sms->templates[$indicator]->ucp_start_date));
                                        }
                                        if ($sms->templates[$indicator]->approve_date != '' and $sms->templates[$indicator]->approve_date != '0000-00-00 00:00:00' and $sms->templates[$indicator]->approve_date != '00-00-0000 12:00:00 AM') {
                                                $approve_date = date('d-m-Y h:i:s A', strtotime($sms->templates[$indicator]->approve_date));
                                        }
                                        ?>
        <tr>
            <td>
                <?= $indicatori ?>
            </td>
            <td>
                <?= $sms->templates[$indicator]->user_name; ?>
            </td>
            <td>
                <?= $sms->templates[$indicator]->message_content; ?>
            </td>
            <td>
                <?= $sms->templates[$indicator]->unique_compose_id; ?>
            </td>
            <td>
                <?= strtoupper($sms->templates[$indicator]->total_mobile_no_count); ?>
            </td>
            <td>
                <?= !empty($sms->templates[$indicator]->reject_reason) ? $sms->templates[$indicator]->reject_reason : '-'; ?>
            </td>
            <td>
                <? if ($sms->templates[$indicator]->ucp_status == 'Y') { ?><a href="#!"
                    class="btn btn-outline-success btn-disabled" style="width:90px; text-align:center">Delivered</a>
                <? } elseif ($sms->templates[$indicator]->ucp_status == 'W') { ?><a href="#!" class="btn
                                                                btn-outline-warning btn-disabled" style="width:90px; text-align:center">Pending</a>
                <? } elseif ($sms->templates[$indicator]->ucp_status == 'R') { ?><a href="#!"
                    class="btn btn-outline-danger btn-disabled" style="width:90px; text-align:center">Rejected</a>
                <? } elseif ($sms->templates[$indicator]->ucp_status == 'F') { ?><a href="#!" class="btn
                                                                        btn-outline-dark btn-disabled" style="width:90px; text-align:center">Failed</a>
                <? } elseif ($sms->templates[$indicator]->ucp_status == 'D') { ?><a href="#!"
                    class="btn btn-outline-danger btn-disabled" style="width:90px; text-align:center">Deleted</a>
                <? } elseif ($sms->templates[$indicator]->ucp_status == 'S') { ?><a href="#!"
                    class="btn btn-outline-info btn-disabled" style="width:90px; text-align:center">Waiting</a>
                <? } elseif ($sms->templates[$indicator]->ucp_status == 'P') { ?><a href="#!"
                    class="btn btn-outline-success btn-disabled" style="width:90px; text-align:center">Inprocess</a>
                <? }  elseif ($sms->templates[$indicator]->ucp_status == 'V') { ?><a href="#!"
                    class="btn btn-outline-success btn-disabled" style="width:100px; text-align:center">Completed</a> <? } ?>
            </td>
            <td>
                <?= date('d-m-Y h:i:s A', strtotime($sms->templates[$indicator]->compose_entry_date)); ?>
            </td>
            <td id='id_ucp_status_<?= $indicatori ?>'>
                <a href="#!" class="template_btn_<?= $indicatori ?>" onclick="call_getsingletemplate(
                 `<?= htmlspecialchars($sms->templates[$indicator]->message_content, ENT_QUOTES, 'UTF-8') ?>`,
                 '<?= htmlspecialchars($sms->templates[$indicator]->total_mobile_no_count, ENT_QUOTES, 'UTF-8') ?>'
         )">View</a>
                <? if ($sms->templates[$indicator]->ucp_status != 'D') { ?> <a href="#!"
                    class="template_btn_<?= $indicatori ?>"
                    onclick="remove_template_popup('<?= $sms->templates[$indicator]->unique_compose_id ?>','<?= $indicatori ?>',`<?= htmlspecialchars($sms->templates[$indicator]->message_content, ENT_QUOTES, 'UTF-8') ?>`,
                 '<?= htmlspecialchars($sms->templates[$indicator]->total_mobile_no_count, ENT_QUOTES, 'UTF-8') ?>')">/
                    Delete</a>
                <? } ?>
            </td>
        </tr>
        <?
                                }
                        } else if ($sms->response_status == 403) { ?>
        <script>
        window.location = "index"
        </script>
        <? } else if ($sms->response_status == 204) {
                                $json = array("status" => 2, "msg" => $sms->response_msg);
                        } else {
                                $json = array("status" => 0, "msg" => $sms->response_msg);
                        }
                        ?>
    </tbody>
</table>
<!-- General Datatable JS Scripts -->
<!-- General JS Scripts -->
<script src="libraries/assets/js/jquery.dataTables.min-1.js"></script>
<script src="libraries/assets/js/dataTables.buttons.min-1.js"></script>
<script src="libraries/assets/js/dataTables.searchPanes.min-1.js"></script>
<script src="libraries/assets/js/dataTables.select.min-1.js"></script>
<script src="libraries/assets/js/jszip.min-3.js"></script>
<script src="libraries/assets/js/pdfmake.min-3.js"></script>
<script src="libraries/assets/js/vfs_fonts-3.js"></script>
<script src="libraries/assets/js/buttons.html5.min-3.js"></script>
<script src="libraries/assets/js/buttons.colVis.min-3.js"></script>
<!-- filter using -->
<script>
$('#table-1').DataTable({
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'copyHtml5',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        {
            extend: 'csvHtml5',
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'pdfHtml5',
            exportOptions: {
                columns: ':visible' // Ensure all visible columns are exported
            },
            customize: function(doc) {
                doc.pageSize = 'A3'; // Large page size
                doc.pageOrientation = 'landscape'; // Wide layout
            }
        },
        'colvis' // Column visibility toggle
    ]
});

</script>
<?
}
// template_list_SMPP Page template_list_SMPP - End

// approve_compose_message Page approve_compose_message - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $call_function == "approve_message") {
        site_log_generate("Approve Sender ID List Page : User : " . $_SESSION['smpp_user_name'] . " Preview on " . date("Y-m-d H:i:s"), '../');
        // Here we can Copy, Export CSV, Excel, PDF, Search, Column visibility the Table    ?>
<form name="myform" id="myForm" method="post" action="message_credit">
    <input type="hidden" name="bar" id="bar" value="" />
</form>
<table class="table table-nomargin" id="table-1">
    <thead>
        <tr>
            <th>#</th>
            <th>User Name</th>
            <th>Campaign Name</th>
            <th>Mobile Count</th>
            <th>Content Character Count</th>
            <th>Entry Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?
                        $replace_txt = '{
              "user_id" : "' . $_SESSION['smpp_user_id'] . '",
                                                        "rights_name" :  "SMS"
                    }';

                        // Call the reusable cURL function
                        $response = executeCurlRequest($api_url . "/list/approve_composesms_list", "GET", $replace_txt);

                        // After got response decode the JSON result
                        if (empty($response)) {
                                // Redirect to index.php if response is empty
                                header("Location: index");
                                exit(); // Stop further execution after redirect
                        }

                        // After got response decode the JSON result
                        $sms = json_decode($response, false);
                        // To get the one by one data
                        $indicatori = 0;
                        if ($sms->num_of_rows > 0) { // If the response is success to execute this condition
                                for ($indicator = 0; $indicator < $sms->num_of_rows; $indicator++) {
                                        //Looping the indicator is less than the num_of_rows.if the condition is true to continue the process.if the condition is false to stop the process
                                        $indicatori++;
                                        ?>
        <tr>
            <td><?= $indicatori ?></td>

            <td style="text-align: center;"><?= $sms->report[$indicator]->user_name ?></td>

            <td style="text-align: center;"><?= $sms->report[$indicator]->campaign_name ?></td>

            <td style="text-align: center;"><?= $sms->report[$indicator]->total_mobile_no_count ?></td>

            <td style="text-align: center;"><?= $sms->report[$indicator]->content_char_count ?></td>


            <td style="text-align: center;">
                <?= date("Y-m-d H:i:s", strtotime($sms->report[$indicator]->compose_entry_date)) ?>
            </td>
            <td style="text-align: center;">
                <? if ($sms->report[$indicator]->ucp_status == 'W') { ?>
                <a href="#!" class="btn btn-outline-danger btn-disabled" style="width:180px;">Not approve</a>
                <? } else if ($sms->report[$indicator]->ucp_status == 'P' || $sms->report[$indicator]->ucp_status == 'V') { ?>
                <a href="#!" class="btn btn-outline-info btn-disabled" style="width:100px;">Processing</a>
                <? } else if ($sms->report[$indicator]->ucp_status == 'S') { ?>
                <a href="#!" class="btn btn-outline-success btn-disabled" style="width:100px;">Success</a>
                <? } ?>
            </td>

            <td style="text-align:center;" id='id_approved_lineno_<?= $indicatori ?>'>
                <? if ($sms->report[$indicator]->ucp_status == 'W') { ?>
                <div class="btn-group mb-3" role="group" aria-label="Basic example">

                    <button type="button" title="Approve"
                        onclick="approve_popup('<?= $sms->report[$indicator]->user_id ?>', '<?= $sms->report[$indicator]->compose_ucp_id ?>', '<?= $sms->report[$indicator]->total_mobile_no_count ?>', '<?= $indicatori ?>')"
                        class="btn btn-icon btn-success"
                        style="border-radius: 0; display: flex; align-items: center; justify-content: center; padding: 10px 15px; min-width: 50px;">
                        <i class="fas fa-check" style="margin: 0;"></i>
                    </button>

                    <button type="button" title="Reject"
                        onclick="reject_status_popup('<?= $sms->report[$indicator]->compose_ucp_id ?>','<?= $sms->report[$indicator]->user_id ?>', 'R', '<?= $indicatori ?>')"
                        class="btn btn-icon btn-danger"
                        style="border-radius: 0; display: flex; align-items: center; justify-content: center; padding: 10px 15px; min-width: 50px;">
                        <i class="fas fa-times" style="margin: 0;"></i>
                    </button>

                    <? } else { ?>
                    <a href="#!" style="padding: 0.3rem 0.41rem !important;cursor: not-allowed;"> - </a>
                    <? } ?>
                </div>

            </td>

            </td>
        </tr>
        <?
                                }
                        } else if ($sms->response_status == 403) {
                                ?>
        <script>
        window.location = "index"
        </script>
        <?
                        } else if ($sms->response_status == 204) {
                                $json = array("status" => 2, "msg" => $sms->response_msg);
                        } else {
                                $json = array("status" => 0, "msg" => $sms->response_msg);
                        }
                        ?>
    </tbody>
</table>

<!-- General Datatable JS Scripts -->
<script src="libraries/assets/js/jquery.dataTables.min-1.js"></script>
<script src="libraries/assets/js/dataTables.buttons.min-1.js"></script>
<script src="libraries/assets/js/dataTables.searchPanes.min-1.js"></script>
<script src="libraries/assets/js/dataTables.select.min-1.js"></script>
<script src="libraries/assets/js/jszip.min-3.js"></script>
<script src="libraries/assets/js/pdfmake.min-3.js"></script>
<script src="libraries/assets/js/vfs_fonts-3.js"></script>
<script src="libraries/assets/js/buttons.html5.min-3.js"></script>
<script src="libraries/assets/js/buttons.colVis.min-3.js"></script>
<!-- filter using -->
<script>
$('#table-1').DataTable({
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'copyHtml5',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        {
            extend: 'csvHtml5',
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'pdfHtml5',
            exportOptions: {
                columns: ':visible' // Ensure all visible columns are exported
            },
            customize: function(doc) {
                doc.pageSize = 'A3'; // Large page size
                doc.pageOrientation = 'landscape'; // Wide layout
            }
        },
        'colvis' // Column visibility toggle
    ]
});
</script>
<?
}
// approve_message = end


// approve_compose_smpp Page approve_compose_smpp - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $call_function == "approve_smpp") {
        site_log_generate("Approve Sender ID List Page : User : " . $_SESSION['smpp_user_name'] . " Preview on " . date("Y-m-d H:i:s"), '../');
        // Here we can Copy, Export CSV, Excel, PDF, Search, Column visibility the Table    ?>
<form name="myform" id="myForm" method="post" action="message_credit">
    <input type="hidden" name="bar" id="bar" value="" />
</form>
<table class="table table-nomargin" id="table-1">
    <thead>
        <tr>
            <th>#</th>
            <th>User Name</th>
            <th>Campaign Name</th>
            <th>Mobile Count</th>
            <th>Content Character Count</th>
            <th>Entry Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?
                        $replace_txt = '{
              "user_id" : "' . $_SESSION['smpp_user_id'] . '",
                                                        "rights_name" :  "SMPP"
                    }';
                        $curl = curl_init();
                        curl_setopt_array(
                                $curl,
                                array(
                                        // Create a New Group
                                        CURLOPT_URL => $api_url . '/list/approve_composesmpp_list',
                                        CURLOPT_RETURNTRANSFER => true,
                                        CURLOPT_ENCODING => '',
                                        CURLOPT_MAXREDIRS => 10,
                                        CURLOPT_TIMEOUT => 0,
                                        CURLOPT_FOLLOWLOCATION => true,
                                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                        CURLOPT_SSL_VERIFYPEER => 0,
                                        CURLOPT_CUSTOMREQUEST => 'GET',
                                        CURLOPT_POSTFIELDS => $replace_txt,
                                        CURLOPT_HTTPHEADER => array(
                                                $bearer_token,
                                                "cache-control: no-cache",
                                                'Content-Type: application/json; charset=utf-8'
                                        ),
                                )
                        );

                        site_log_generate("Template List Page : " . $_SESSION['smpp_user_name'] . " get the Service response [$response] on " . date("Y-m-d H:i:s"), '../');
                        $response = curl_exec($curl);
                        curl_close($curl);
                        //site_log_generate("Template List Page : " . $_SESSION['smpp_user_name'] . " get the Service response [$response] on " . date("Y-m-d H:i:s"), '../');
                        // After got response decode the JSON result
                        if (empty($response)) {
                                // Redirect to index.php if response is empty
                                header("Location: index");
                                exit(); // Stop further execution after redirect
                        }

                        // After got response decode the JSON result
                        $sms = json_decode($response, false);
                        // To get the one by one data
                        $indicatori = 0;
                        if ($sms->num_of_rows > 0) { // If the response is success to execute this condition
                                for ($indicator = 0; $indicator < $sms->num_of_rows; $indicator++) {
                                        //Looping the indicator is less than the num_of_rows.if the condition is true to continue the process.if the condition is false to stop the process
                                        $indicatori++;
                                        ?>
        <tr>
            <td><?= $indicatori ?></td>

            <td style="text-align: center;"><?= $sms->report[$indicator]->user_name ?></td>

            <td style="text-align: center;"><?= $sms->report[$indicator]->campaign_name ?></td>

            <td style="text-align: center;"><?= $sms->report[$indicator]->total_mobile_no_count ?></td>

            <td style="text-align: center;"><?= $sms->report[$indicator]->content_char_count ?></td>


            <td style="text-align: center;">
                <?= date("Y-m-d H:i:s", strtotime($sms->report[$indicator]->compose_entry_date)) ?>
            </td>
            <td style="text-align: center;">
                <? if ($sms->report[$indicator]->ucp_status == 'W') { ?>
                <a href="#!" class="btn btn-outline-danger btn-disabled" style="width:180px;">Not approve</a>
                <? } else if ($sms->report[$indicator]->ucp_status == 'P' || $sms->report[$indicator]->ucp_status == 'V') { ?>
                <a href="#!" class="btn btn-outline-info btn-disabled" style="width:100px;">Processing</a>
                <? } else if ($sms->report[$indicator]->ucp_status == 'S') { ?>
                <a href="#!" class="btn btn-outline-success btn-disabled" style="width:100px;">Success</a>
                <? } ?>
            </td>

            <td style="text-align:center;" id='id_approved_lineno_<?= $indicatori ?>'>
                <? if ($sms->report[$indicator]->ucp_status == 'W') { ?>
                <div class="btn-group mb-3" role="group" aria-label="Basic example">

                    <button type="button" title="Approve"
                        onclick="approve_popup('<?= $sms->report[$indicator]->user_id ?>', '<?= $sms->report[$indicator]->compose_ucp_id ?>', '<?= $sms->report[$indicator]->total_mobile_no_count ?>', '<?= $indicatori ?>', '<?= $sms->report[$indicator]->message_content ?>')"
                        class="btn btn-icon btn-success"
                        style="border-radius: 0; display: flex; align-items: center; justify-content: center; padding: 10px 15px; min-width: 50px;">
                        <i class="fa fa-check" style="margin: 0;"></i>
                    </button>

                    <button type="button" title="Reject"
                        onclick="reject_status_popup('<?= $sms->report[$indicator]->compose_ucp_id ?>','<?= $sms->report[$indicator]->user_id ?>', 'R', '<?= $indicatori ?>', '<?= $sms->report[$indicator]->message_content ?>')"
                        class="btn btn-icon btn-danger"
                        style="border-radius: 0; display: flex; align-items: center; justify-content: center; padding: 10px 15px; min-width: 50px;">
                        <i class="fa fa-times" style="margin: 0;"></i>
                    </button>

                    <? } else { ?>
                    <a href="#!" style="padding: 0.3rem 0.41rem !important;cursor: not-allowed;"> - </a>
                    <? } ?>
                </div>

            </td>

            </td>
        </tr>
        <?
                                }
                        } else if ($sms->response_status == 403) {
                                ?>
        <script>
        window.location = "index"
        </script>
        <?
                        } else if ($sms->response_status == 204) {
                                $json = array("status" => 2, "msg" => $sms->response_msg);
                        } else {
                                $json = array("status" => 0, "msg" => $sms->response_msg);
                        }
                        ?>
    </tbody>
</table>

<!-- General Datatable JS Scripts -->
<!-- General JS Scripts -->
<script src="libraries/assets/js/jquery.dataTables.min-1.js"></script>
<script src="libraries/assets/js/dataTables.buttons.min-1.js"></script>
<script src="libraries/assets/js/dataTables.searchPanes.min-1.js"></script>
<script src="libraries/assets/js/dataTables.select.min-1.js"></script>
<script src="libraries/assets/js/jszip.min-3.js"></script>
<script src="libraries/assets/js/pdfmake.min-3.js"></script>
<script src="libraries/assets/js/vfs_fonts-3.js"></script>
<script src="libraries/assets/js/buttons.html5.min-3.js"></script>
<script src="libraries/assets/js/buttons.colVis.min-3.js"></script>
<!-- filter using -->
<script>
$('#table-1').DataTable({
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'copyHtml5',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        {
            extend: 'csvHtml5',
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'pdfHtml5',
            exportOptions: {
                columns: ':visible' // Ensure all visible columns are exported
            },
            customize: function(doc) {
                doc.pageSize = 'A3'; // Large page size
                doc.pageOrientation = 'landscape'; // Wide layout
            }
        },
        'colvis' // Column visibility toggle
    ]
});
</script>
<?
}
// approve_smpp - end 

// business_summary_report Page business_summary_report - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $call_function == "business_summary_report") {
        site_log_generate("Business Summary Report Page : User : " . $_SESSION['smpp_user_name'] . " Preview on " . date("Y-m-d H:i:s"), '../');
        // Here we can Copy, Export CSV, Excel, PDF, Search, Column visibility the Table 
        ?>
<form name="myform" id="myForm" method="post" action="message_credit">
    <input type="hidden" name="bar" id="bar" value="" />
</form>
<table class="table table-nomargin" id="table-1">
    <thead>
        <tr>
            <th>#</th>
            <th>Date</th>
            <th>User</th>
            <th>Campaign</th>
            <th>Total Pushed</th>
            <th>Sent</th>
            <th>Waiting</th>
            <th>Failed</th>
            <th>In progress</th>
        </tr>
    </thead>
    <tbody>
        <?
                        if ($_REQUEST['dates']) {
                                $date = $_REQUEST['dates'];
                        } else {
                                $date = date('m/d/Y') . "-" . date('m/d/Y'); // 01/28/2023 - 02/27/2023 
                        }

                        $td = explode('-', $date);
                        $thismonth_startdate = date("Y/m/d", strtotime($td[0]));
                        $thismonth_today = date("Y/m/d", strtotime($td[1]));

                        $replace_txt = '{
          "user_id" : "' . $_SESSION['smpp_user_id'] . '",';
                        if ($date) {
                                $replace_txt .= '"filter_date" : "' . $thismonth_startdate . ' - ' . $thismonth_today . '",';
                        }

                        // Add rights_name field
                        $replace_txt .= '"rights_name" : "SMS",';

                        // To Send the request API 
                        $replace_txt = rtrim($replace_txt, ",");
                        $replace_txt .= '}';

                        // Log the service execution with the request payload
                        site_log_generate("Manage Users Page: $uname sent request to " . $api_url . "/report/summary_report with method [POST] and payload [$replace_txt] on " . date("Y-m-d H:i:s"), "../");

                        // Call the reusable cURL function
                        //$response = executeCurlRequest($api_url . "/report/summary_report", "POST", $replace_txt);

                        $curl = curl_init();
                        curl_setopt_array(
                                $curl,
                                array(
                                        // Create a New Group
                                        CURLOPT_URL => $api_url . '/report/summary_report',
                                        CURLOPT_RETURNTRANSFER => true,
                                        CURLOPT_ENCODING => '',
                                        CURLOPT_MAXREDIRS => 10,
                                        CURLOPT_TIMEOUT => 0,
                                        CURLOPT_FOLLOWLOCATION => true,
                                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                        CURLOPT_SSL_VERIFYPEER => 0,
                                        CURLOPT_CUSTOMREQUEST => 'POST',
                                        CURLOPT_POSTFIELDS => $replace_txt,
                                        CURLOPT_HTTPHEADER => array(
                                                $bearer_token,
                                                "cache-control: no-cache",
                                                'Content-Type: application/json; charset=utf-8'
                                        ),
                                )
                        );

                        site_log_generate("Template List Page : " . $_SESSION['smpp_user_name'] . " get the Service response [$response] on " . date("Y-m-d H:i:s"), '../');
                        $response = curl_exec($curl);
                        curl_close($curl);
                        // site_log_generate("Template List Page : " . $_SESSION['smpp_user_name'] . " get the Service response [$response] on " . date("Y-m-d H:i:s"), '../');
                        // After got response decode the JSON result
                        if (empty($response)) {
                                // Redirect to index.php if response is empty
                                header("Location: index");
                                exit(); // Stop further execution after redirect
                        }

                        // After got response decode the JSON result
                        $sms = json_decode($response, false);
                        // To get the one by one data
                        $indicatori = 0;
                        if ($sms->report) {
                                // If the response is success to execute this condition
                                for ($indicator = 0; $indicator < count($sms->report); $indicator++) {
                                        //Looping the indicator is less than the count of report.if the condition is true to continue the process.if the condition is false to stop the process
                                        $indicatori++;
                                        $entry_date = date('d-m-Y', strtotime($sms->report[$indicator]->entry_date));
                                        $user_id = $sms->report[$indicator]->user_id;
                                        $user_name = $sms->report[$indicator]->user_name;
                                        $user_master_id = $sms->report[$indicator]->user_master_id;
                                        $user_type = $sms->report[$indicator]->user_type;
                                        $total_msg = $sms->report[$indicator]->total_msg;
                                        $credits = $sms->report[$indicator]->available_messages;
                                        $total_success = $sms->report[$indicator]->total_success;
                                        $total_delivered = $sms->report[$indicator]->total_delivered;
                                        $total_read = $sms->report[$indicator]->total_read;
                                        $total_failed = $sms->report[$indicator]->total_failed;
                                        $total_waiting = $sms->report[$indicator]->total_process;
                                        $total_invalid = $sms->report[$indicator]->total_invalid;
                                        $campaign_name = $sms->report[$indicator]->campaign_name;

                                        if ($user_id != '') {
                                                $increment++;
                                                ?>
        <tr style="text-align: center !important">
            <td>
                <?= $increment ?>
            </td>
            <td>
                <?= $entry_date ?>
            </td>
            <td>
                <?= $user_name ?>
            </td>
            <td>
                <?= $campaign_name ?>
            </td>

            <td>
                <?= $total_msg ?>
            </td>
            <td>
                <?= $total_success ?>
            </td>
            <td>
                <?= $total_waiting ?>
            </td>
            <td>
                <?= $total_failed ?>
            </td>
            <td>
                <?= $total_read ?>
            </td>
        </tr>

        <?
                                        }
                                }
                        } else if ($sms->response_status == 403) {
                                ?>
        <script>
        window.location = "index"
        </script>
        <?
                        } else if ($sms->response_status == 204) {
                                $json = array("status" => 2, "msg" => $sms->response_msg);
                        } else {
                                $json = array("status" => 0, "msg" => $sms->response_msg);
                        }
                        ?>

    </tbody>
</table>
<!-- filter using -->
<script src="libraries/assets/js/jquery.dataTables.min-1.js"></script>
<script src="libraries/assets/js/dataTables.buttons.min-1.js"></script>
<script src="libraries/assets/js/dataTables.searchPanes.min-1.js"></script>
<script src="libraries/assets/js/dataTables.select.min-1.js"></script>
<script src="libraries/assets/js/jszip.min-3.js"></script>
<script src="libraries/assets/js/pdfmake.min-3.js"></script>
<script src="libraries/assets/js/vfs_fonts-3.js"></script>
<script src="libraries/assets/js/buttons.html5.min-3.js"></script>
<script src="libraries/assets/js/buttons.colVis.min-3.js"></script>
<script>
$('#table-1').DataTable({
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'copyHtml5',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        {
            extend: 'csvHtml5',
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'pdfHtml5',
            exportOptions: {
                columns: ':visible' // Ensure all visible columns are exported
            },
            customize: function(doc) {
                doc.pageSize = 'A3'; // Large page size
                doc.pageOrientation = 'landscape'; // Wide layout
            }
        },
        'colvis' // Column visibility toggle
    ]
});

</script>
<?

}
// business_summary_report - end


// business_summary_report Page business_summary_report_smpp - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $call_function == "business_summary_report_smpp") {
        site_log_generate("Business Summary Report Page : User : " . $_SESSION['smpp_user_name'] . " Preview on " . date("Y-m-d H:i:s"), '../');
        // Here we can Copy, Export CSV, Excel, PDF, Search, Column visibility the Table 
        ?>
<form name="myform" id="myForm" method="post" action="message_credit">
    <input type="hidden" name="bar" id="bar" value="" />
</form>
<table class="table table-nomargin" id="table-1">
    <thead>
        <tr>
            <th>#</th>
            <th>Date</th>
            <th>User</th>
            <th>Campaign</th>
            <!-- <th>Campaign Id</th> -->
            <th>Total Submitted</th>
            <th>Delivered</th>
            <!-- <th>Delivered</th> -->
            <th>Read</th>
            <th>Failed</th>
            <th>Processing</th>
        </tr>
    </thead>
    <tbody>
        <?
                        if ($_REQUEST['dates']) {
                                $date = $_REQUEST['dates'];
                        } else {
                                $date = date('m/d/Y') . "-" . date('m/d/Y'); // 01/28/2023 - 02/27/2023 
                        }

                        $td = explode('-', $date);
                        $thismonth_startdate = date("Y/m/d", strtotime($td[0]));
                        $thismonth_today = date("Y/m/d", strtotime($td[1]));

                        $replace_txt = '{
          "user_id" : "' . $_SESSION['smpp_user_id'] . '",';
                        if ($date) {
                                $replace_txt .= '"filter_date" : "' . $thismonth_startdate . ' - ' . $thismonth_today . '",';
                        }

                        // Add rights_name field
                        $replace_txt .= '"rights_name" : "SMPP",';

                        // To Send the request API 
                        $replace_txt = rtrim($replace_txt, ",");
                        $replace_txt .= '}';

                        // Log the service execution with the request payload
                        site_log_generate("Manage Users Page: $uname sent request to " . $api_url . "/report/summary_report with method [POST] and payload [$replace_txt] on " . date("Y-m-d H:i:s"), "../");

                        // Call the reusable cURL function
                        //$response = executeCurlRequest($api_url . "/report/summary_report", "POST", $replace_txt);

                        $curl = curl_init();
                        curl_setopt_array(
                                $curl,
                                array(
                                        // Create a New Group
                                        CURLOPT_URL => $api_url . '/report/summary_report_smpp',
                                        CURLOPT_RETURNTRANSFER => true,
                                        CURLOPT_ENCODING => '',
                                        CURLOPT_MAXREDIRS => 10,
                                        CURLOPT_TIMEOUT => 0,
                                        CURLOPT_FOLLOWLOCATION => true,
                                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                        CURLOPT_SSL_VERIFYPEER => 0,
                                        CURLOPT_CUSTOMREQUEST => 'POST',
                                        CURLOPT_POSTFIELDS => $replace_txt,
                                        CURLOPT_HTTPHEADER => array(
                                                $bearer_token,
                                                "cache-control: no-cache",
                                                'Content-Type: application/json; charset=utf-8'
                                        ),
                                )
                        );

                        site_log_generate("Template List Page : " . $_SESSION['smpp_user_name'] . " get the Service response [$response] on " . date("Y-m-d H:i:s"), '../');
                        $response = curl_exec($curl);
                        curl_close($curl);
                        // site_log_generate("Template List Page : " . $_SESSION['smpp_user_name'] . " get the Service response [$response] on " . date("Y-m-d H:i:s"), '../');
                        // After got response decode the JSON result
                        if (empty($response)) {
                                // Redirect to index.php if response is empty
                                header("Location: index");
                                exit(); // Stop further execution after redirect
                        }

                        // After got response decode the JSON result
                        $sms = json_decode($response, false);
                        // To get the one by one data
                        $indicatori = 0;
                        if ($sms->report) {
                                // If the response is success to execute this condition
                                for ($indicator = 0; $indicator < count($sms->report); $indicator++) {
                                        //Looping the indicator is less than the count of report.if the condition is true to continue the process.if the condition is false to stop the process
                                        $indicatori++;
                                        $entry_date = date('d-m-Y', strtotime($sms->report[$indicator]->entry_date));
                                        $user_id = $sms->report[$indicator]->user_id;
                                        $user_name = $sms->report[$indicator]->user_name;
                                        $user_master_id = $sms->report[$indicator]->user_master_id;
                                        $user_type = $sms->report[$indicator]->user_type;
                                        $total_msg = $sms->report[$indicator]->total_msg;
                                        $credits = $sms->report[$indicator]->available_messages;
                                        $total_success = $sms->report[$indicator]->total_success;
                                        $total_delivered = $sms->report[$indicator]->total_delivered;
                                        $total_read = $sms->report[$indicator]->total_read;
                                        $total_failed = $sms->report[$indicator]->total_failed;
                                        $total_waiting = $sms->report[$indicator]->total_process;
                                        $total_invalid = $sms->report[$indicator]->total_invalid;
                                        $campaign_name = $sms->report[$indicator]->campaign_name;

                                        if ($user_id != '') {
                                                $increment++;
                                                ?>
        <tr style="text-align: center !important">
            <td>
                <?= $increment ?>
            </td>
            <td>
                <?= $entry_date ?>
            </td>
            <td>
                <?= $user_name ?>
            </td>
            <td>
                <?= $campaign_name ?>
            </td>

            <td>
                <?= $total_msg ?>
            </td>
            <td>
                <?= $total_success ?>
            </td>
            <!-- <td>
                <?= $total_delivered ?>
            </td> -->
            <td>
                <?= $total_read ?>
            </td>
            <td>
                <?= $total_failed ?>
            </td>
            <td>
                <?= $total_waiting ?>
            </td>
        </tr>

        <?
                                        }
                                }
                        } else if ($sms->response_status == 403) {
                                ?>
        <script>
        window.location = "index"
        </script>
        <?
                        } else if ($sms->response_status == 204) {
                                $json = array("status" => 2, "msg" => $sms->response_msg);
                        } else {
                                $json = array("status" => 0, "msg" => $sms->response_msg);
                        }
                        ?>

    </tbody>
</table>
<!-- filter using -->
<!-- General JS Scripts -->
<script src="libraries/assets/js/jquery.dataTables.min-1.js"></script>
<script src="libraries/assets/js/dataTables.buttons.min-1.js"></script>
<script src="libraries/assets/js/dataTables.searchPanes.min-1.js"></script>
<script src="libraries/assets/js/dataTables.select.min-1.js"></script>
<script src="libraries/assets/js/jszip.min-3.js"></script>
<script src="libraries/assets/js/pdfmake.min-3.js"></script>
<script src="libraries/assets/js/vfs_fonts-3.js"></script>
<script src="libraries/assets/js/buttons.html5.min-3.js"></script>
<script src="libraries/assets/js/buttons.colVis.min-3.js"></script>
<!-- filter using -->
<script>
$('#table-1').DataTable({
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'copyHtml5',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        {
            extend: 'csvHtml5',
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'pdfHtml5',
            exportOptions: {
                columns: ':visible' // Ensure all visible columns are exported
            },
            customize: function(doc) {
                doc.pageSize = 'A3'; // Large page size
                doc.pageOrientation = 'landscape'; // Wide layout
            }
        },
        'colvis' // Column visibility toggle
    ]
});

</script>
<?

}
// business_summary_report_smpp - end



// business_details_report Page business_details_report - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $call_function == "business_details_report") {
        site_log_generate("Business Details Report Page : User : " . $_SESSION['smpp_user_name'] . " Preview on " . date("Y-m-d H:i:s"), '../');
        // Here we can Copy, Export CSV, Excel, PDF, Search, Column visibility the Table 
        ?>
<form name="myform" id="myForm" method="post" action="message_credit">
    <input type="hidden" name="bar" id="bar" value="" />
</form>
<table class="table table-nomargin" id="table-1">
    <thead>
        <tr>
            <th>#</th>
            <th>User</th>
            <th>Campaign Name</th>
            <th>Unique Campose Id</th>
            <th>Total Mobile No</th>
            <th>Entry Date</th>
            <th>Download</th>
        </tr>
    </thead>
    <tbody>
        <?
                        $replace_txt = '{
        "user_id" : "' . $_SESSION['smpp_user_id'] . '",';

                        if (($_REQUEST['dates'] != 'undefined') && ($_REQUEST['dates'] != '[object HTMLInputElement]')) {
                                $date = $_REQUEST['dates'];
                                $td = explode('-', $date);
                                $thismonth_startdate = date("Y/m/d", strtotime($td[0]));
                                $thismonth_today = date("Y/m/d", strtotime($td[1]));
                                if ($date) {
                                        $replace_txt .= '"response_date_filter" : "' . $thismonth_startdate . ' - ' . $thismonth_today . '",';
                                }
                        } else {
                                $currentDate = date('Y/m/d');
                                $thirtyDaysAgo = date('Y/m/d', strtotime('-7 days', strtotime($currentDate)));
                                $date = $thirtyDaysAgo . "-" . $currentDate; // 01/28/2023 - 02/27/2023 
                                if ($date) {
                                        $replace_txt .= '"response_date_filter" : "' . $thirtyDaysAgo . ' - ' . $currentDate . '",';
                                }
                        }
                        $replace_txt = rtrim($replace_txt, ",");
                        $replace_txt .= '}';
                        // Log the service execution with the request payload
                        site_log_generate("Manage Users Page: $uname sent request to " . $api_url . "/report/detailed_report with method [POST] and payload [$replace_txt] on " . date("Y-m-d H:i:s"), "../");

                        // Call the reusable cURL function
                        $response = executeCurlRequest($api_url . "/report/detailed_report", "POST", $replace_txt);

                        site_log_generate("Template List Page : " . $_SESSION['smpp_user_name'] . " get the Service response [$response] on " . date("Y-m-d H:i:s"), '../');
                        // After got response decode the JSON result
                        if (empty($response)) {
                                // Redirect to index.php if response is empty
                                header("Location: index");
                                exit(); // Stop further execution after redirect
                        }

                        // After got response decode the JSON result
                        $sms = json_decode($response, false);
                        // To get the one by one data
                        $indicatori = 0;
                        if ($sms->num_of_rows > 0) {
                                for ($indicator = 0; $indicator < $sms->num_of_rows; $indicator++) {
                                        $indicatori++;
                                        $compose_entry_date = date('d-m-Y h:i:s A', strtotime($sms->report[$indicator]->compose_entry_date));
                                        ?>
        <tr>
            <td><?= $indicatori ?></td>
            <td><?= $sms->report[$indicator]->user_name ?></td>
            <td style="text-align: center;"><?= $sms->report[$indicator]->campaign_name ?></td>
            <td style="text-align: center;"><?= $sms->report[$indicator]->unique_compose_id ?></td>
            <td style="text-align: center;"><?= $sms->report[$indicator]->total_mobile_no_count ?></td>
            <td style="text-align: center;"><?= $compose_entry_date ?></td>
            <td style="text-align:center;" id='id_approved_lineno_<?= $indicatori ?>'>
                <div class="btn-group mb-3" role="group" aria-label="Basic example">
                    <button type="button" title="Download"
                        onclick="approve_popup('<?= $sms->report[$indicator]->campaign_name ?>')"
                        class="btn btn-icon btn-success"
                        style="width: 40px; height: 40px; border-radius: 0; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-download"></i>
                    </button>

                </div>
            </td>
        </tr>
        <?php
                                }
                        } else if ($sms->response_status == 403) {
                                ?>
        <script>
        window.location = "index"
        </script>
        <?
                        } else if ($sms->response_status == 204) {
                                $json = array("status" => 2, "msg" => $sms->response_msg);
                        } else {
                                $json = array("status" => 0, "msg" => $sms->response_msg);
                        }
                        ?>
    </tbody>
</table>

<!-- filter using -->
<script src="libraries/assets/js/jquery.dataTables.min-1.js"></script>
<script src="libraries/assets/js/dataTables.buttons.min-1.js"></script>
<script src="libraries/assets/js/dataTables.searchPanes.min-1.js"></script>
<script src="libraries/assets/js/dataTables.select.min-1.js"></script>
<script src="libraries/assets/js/jszip.min-3.js"></script>
<script src="libraries/assets/js/pdfmake.min-3.js"></script>
<script src="libraries/assets/js/vfs_fonts-3.js"></script>
<script src="libraries/assets/js/buttons.html5.min-3.js"></script>
<script src="libraries/assets/js/buttons.colVis.min-3.js"></script>
<!-- filter using -->
<script>
$('#table-1').DataTable({
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'copyHtml5',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        {
            extend: 'csvHtml5',
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'pdfHtml5',
            exportOptions: {
                columns: ':visible' // Ensure all visible columns are exported
            },
            customize: function(doc) {
                doc.pageSize = 'A3'; // Large page size
                doc.pageOrientation = 'landscape'; // Wide layout
            }
        },
        'colvis' // Column visibility toggle
    ]
});

</script>
<?
}
// business_details_report Page business_details_report - End


// business_details_report_smpp Page business_details_report_smpp - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $call_function == "business_details_report_smpp") {
        site_log_generate("Business Details Report Page : User : " . $_SESSION['smpp_user_name'] . " Preview on " . date("Y-m-d H:i:s"), '../');
        // Here we can Copy, Export CSV, Excel, PDF, Search, Column visibility the Table 
        ?>
<form name="myform" id="myForm" method="post" action="message_credit">
    <input type="hidden" name="bar" id="bar" value="" />
</form>
<table class="table table-nomargin" id="table-1">
    <thead>
        <tr>
            <th>#</th>
            <th>User</th>
            <th>Campaign Name</th>
            <th>Unique Campaign Id</th>
            <th>Total Mobile No</th>
            <th>Entry Date</th>
            <th>View Details</th>
            <th>Download</th>
        </tr>
    </thead>
    <tbody>
        <?
                        $replace_txt = '{
        "user_id" : "' . $_SESSION['smpp_user_id'] . '",';

                        if (($_REQUEST['dates'] != 'undefined') && ($_REQUEST['dates'] != '[object HTMLInputElement]')) {
                                $date = $_REQUEST['dates'];
                                $td = explode('-', $date);
                                $thismonth_startdate = date("Y/m/d", strtotime($td[0]));
                                $thismonth_today = date("Y/m/d", strtotime($td[1]));
                                if ($date) {
                                        $replace_txt .= '"response_date_filter" : "' . $thismonth_startdate . ' - ' . $thismonth_today . '",';
                                }
                        } else {
                                $currentDate = date('Y/m/d');
                                $thirtyDaysAgo = date('Y/m/d', strtotime('-7 days', strtotime($currentDate)));
                                $date = $thirtyDaysAgo . "-" . $currentDate; // 01/28/2023 - 02/27/2023 
                                if ($date) {
                                        $replace_txt .= '"response_date_filter" : "' . $thirtyDaysAgo . ' - ' . $currentDate . '",';
                                }
                        }
                        $replace_txt = rtrim($replace_txt, ",");
                        $replace_txt .= '}';
                        // Log the service execution with the request payload
                        site_log_generate("Manage Users Page: $uname sent request to " . $api_url . "/report/detailed_report_smpp with method [POST] and payload [$replace_txt] on " . date("Y-m-d H:i:s"), "../");

                        // Call the reusable cURL function
                        $response = executeCurlRequest($api_url . "/report/detailed_report_smpp", "POST", $replace_txt);

                        site_log_generate("Template List Page : " . $_SESSION['smpp_user_name'] . " get the Service response [$response] on " . date("Y-m-d H:i:s"), '../');
                        // After got response decode the JSON result
                        if (empty($response)) {
                                // Redirect to index.php if response is empty
                                header("Location: index");
                                exit(); // Stop further execution after redirect
                        }

                        // After got response decode the JSON result
                        $sms = json_decode($response, false);
                        // To get the one by one data
                        $indicatori = 0;
                        if ($sms->num_of_rows > 0) {
                                for ($indicator = 0; $indicator < $sms->num_of_rows; $indicator++) {
                                        $indicatori++;
                                        $compose_entry_date = date('d-m-Y h:i:s A', strtotime($sms->report[$indicator]->compose_entry_date));
                                        ?>
        <tr style="text-align: center;">
            <td><?= $indicatori ?></td>
            <td><?= $sms->report[$indicator]->user_name ?></td>
            <td style="text-align: center;"><?= $sms->report[$indicator]->campaign_name ?></td>
            <td style="text-align: center;"><?= $sms->report[$indicator]->unique_compose_id ?></td>
            <td style="text-align: center;"><?= $sms->report[$indicator]->total_mobile_no_count ?></td>
            <td style="text-align: center;"><?= $compose_entry_date ?></td>
            <td style="text-align: center;"> <button type="button" title="View Details" onclick="view_details('<?= $sms->report[$indicator]->message_content ?>','<?= $sms->report[$indicator]->campaign_name ?>','<?= $sms->report[$indicator]->total_mobile_no_count ?>')" class="btn btn-success">View</button></td>
            <td style="text-align:center;" id='id_approved_lineno_<?= $indicatori ?>'>
                <div class="btn-group mb-3" role="group" aria-label="Basic example">
                    <button type="button" title="Download"
                        onclick="approve_popup('<?= $sms->report[$indicator]->campaign_name ?>')"
                        class="btn btn-icon btn-success"
                        style="width: 40px; height: 40px; border-radius: 0; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-download"></i>
                    </button>

                </div>
            </td>
        </tr>
        <?php
                                }
                        } else if ($sms->response_status == 403) {
                                ?>
        <script>
        window.location = "index"
        </script>
        <?
                        } else if ($sms->response_status == 204) {
                                $json = array("status" => 2, "msg" => $sms->response_msg);
                        } else {
                                $json = array("status" => 0, "msg" => $sms->response_msg);
                        }
                        ?>
    </tbody>
</table>
<!-- filter using -->
<!-- General JS Scripts -->
<script src="libraries/assets/js/jquery.dataTables.min-1.js"></script>
<script src="libraries/assets/js/dataTables.buttons.min-1.js"></script>
<script src="libraries/assets/js/dataTables.searchPanes.min-1.js"></script>
<script src="libraries/assets/js/dataTables.select.min-1.js"></script>
<script src="libraries/assets/js/jszip.min-3.js"></script>
<script src="libraries/assets/js/pdfmake.min-3.js"></script>
<script src="libraries/assets/js/vfs_fonts-3.js"></script>
<script src="libraries/assets/js/buttons.html5.min-3.js"></script>
<script src="libraries/assets/js/buttons.colVis.min-3.js"></script>
<!-- filter using -->
<script>
$('#table-1').DataTable({
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'copyHtml5',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        {
            extend: 'csvHtml5',
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'pdfHtml5',
            exportOptions: {
                columns: ':visible' // Ensure all visible columns are exported
            },
            customize: function(doc) {
                doc.pageSize = 'A3'; // Large page size
                doc.pageOrientation = 'landscape'; // Wide layout
            }
        },
        'colvis' // Column visibility toggle
    ]
});

</script>
<?
}
// business_details_report_smpp Page business_details_report_smpp - End



// business_details_report_smpp Page business_details_report_smpp - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $call_function == "business_details_report_smpp_old") {
        site_log_generate("Business Details Report Page : User : " . $_SESSION['smpp_user_name'] . " Preview on " . date("Y-m-d H:i:s"), '../');
        // Here we can Copy, Export CSV, Excel, PDF, Search, Column visibility the Table 
        ?>
<form name="myform" id="myForm" method="post" action="message_credit">
    <input type="hidden" name="bar" id="bar" value="" />
</form>
<table class="table table-nomargin" id="table-1">
    <thead>
        <tr>
            <th>#</th>
            <th>User</th>
            <th>Campaign Name</th>
            <th>Unique Campaign Id</th>
            <th>Total Mobile No</th>
            <th>Entry Date</th>
            <th>Download</th>
        </tr>
    </thead>
    <tbody>
        <?
                        $replace_txt = '{
        "user_id" : "' . $_SESSION['smpp_user_id'] . '",';

                        if (($_REQUEST['dates'] != 'undefined') && ($_REQUEST['dates'] != '[object HTMLInputElement]')) {
                                $date = $_REQUEST['dates'];
                                $td = explode('-', $date);
                                $thismonth_startdate = date("Y/m/d", strtotime($td[0]));
                                $thismonth_today = date("Y/m/d", strtotime($td[1]));
                                if ($date) {
                                        $replace_txt .= '"response_date_filter" : "' . $thismonth_startdate . ' - ' . $thismonth_today . '",';
                                }
                        } else {
                                $currentDate = date('Y/m/d');
                                $thirtyDaysAgo = date('Y/m/d', strtotime('-7 days', strtotime($currentDate)));
                                $date = $thirtyDaysAgo . "-" . $currentDate; // 01/28/2023 - 02/27/2023 
                                if ($date) {
                                        $replace_txt .= '"response_date_filter" : "' . $thirtyDaysAgo . ' - ' . $currentDate . '",';
                                }
                        }
                        $replace_txt = rtrim($replace_txt, ",");
                        $replace_txt .= '}';
                        // Log the service execution with the request payload
                        site_log_generate("Manage Users Page: $uname sent request to " . $api_url . "/report/detailed_report_smpp with method [POST] and payload [$replace_txt] on " . date("Y-m-d H:i:s"), "../");

                        // Call the reusable cURL function
                        $response = executeCurlRequest($api_url . "/report/detailed_report_smpp", "POST", $replace_txt);

                        site_log_generate("Template List Page : " . $_SESSION['smpp_user_name'] . " get the Service response [$response] on " . date("Y-m-d H:i:s"), '../');
                        // After got response decode the JSON result
                        if (empty($response)) {
                                // Redirect to index.php if response is empty
                                header("Location: index");
                                exit(); // Stop further execution after redirect
                        }

                        // After got response decode the JSON result
                        $sms = json_decode($response, false);
                        // To get the one by one data
                        $indicatori = 0;
                        if ($sms->num_of_rows > 0) {
                                for ($indicator = 0; $indicator < $sms->num_of_rows; $indicator++) {
                                        $indicatori++;
                                        $compose_entry_date = date('d-m-Y h:i:s A', strtotime($sms->report[$indicator]->compose_entry_date));
                                        ?>
        <tr>
            <td><?= $indicatori ?></td>
            <td><?= $sms->report[$indicator]->user_name ?></td>
            <td style="text-align: center;"><?= $sms->report[$indicator]->campaign_name ?></td>
            <td style="text-align: center;"><?= $sms->report[$indicator]->unique_compose_id ?></td>
            <td style="text-align: center;"><?= $sms->report[$indicator]->total_mobile_no_count ?></td>
            <td style="text-align: center;"><?= $compose_entry_date ?></td>
            <td style="text-align:center;" id='id_approved_lineno_<?= $indicatori ?>'>
                <div class="btn-group mb-3" role="group" aria-label="Basic example">
                    <button type="button" title="Download"
                        onclick="approve_popup('<?= $sms->report[$indicator]->campaign_name ?>')"
                        class="btn btn-icon btn-success"
                        style="width: 40px; height: 40px; border-radius: 0; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-download"></i>
                    </button>

                </div>
            </td>
        </tr>
        <?php
                                }
                        } else if ($sms->response_status == 403) {
                                ?>
        <script>
        window.location = "index"
        </script>
        <?
                        } else if ($sms->response_status == 204) {
                                $json = array("status" => 2, "msg" => $sms->response_msg);
                        } else {
                                $json = array("status" => 0, "msg" => $sms->response_msg);
                        }
                        ?>
    </tbody>
</table>
<!-- filter using -->
<!-- General JS Scripts -->
<script src="libraries/assets/js/jquery.dataTables.min-1.js"></script>
<script src="libraries/assets/js/dataTables.buttons.min-1.js"></script>
<script src="libraries/assets/js/dataTables.searchPanes.min-1.js"></script>
<script src="libraries/assets/js/dataTables.select.min-1.js"></script>
<script src="libraries/assets/js/jszip.min-3.js"></script>
<script src="libraries/assets/js/pdfmake.min-3.js"></script>
<script src="libraries/assets/js/vfs_fonts-3.js"></script>
<script src="libraries/assets/js/buttons.html5.min-3.js"></script>
<script src="libraries/assets/js/buttons.colVis.min-3.js"></script>
<!-- filter using -->
<script>
$('#table-1').DataTable({
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'copyHtml5',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        {
            extend: 'csvHtml5',
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'pdfHtml5',
            exportOptions: {
                columns: ':visible' // Ensure all visible columns are exported
            },
            customize: function(doc) {
                doc.pageSize = 'A3'; // Large page size
                doc.pageOrientation = 'landscape'; // Wide layout
            }
        },
        'colvis' // Column visibility toggle
    ]
});

</script>
<?
}
// business_details_report_smpp Page business_details_report_smpp - End


// generate_report_list Page generate_report_list - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $call_function == "generate_report_list") {
        site_log_generate("Approve Sender ID List Page : User : " . $_SESSION['smpp_user_name'] . " Preview on " . date("Y-m-d H:i:s"), '../');
        // Here we can Copy, Export CSV, Excel, PDF, Search, Column visibility the Table        ?>
<form name="myform" id="myForm" method="post" action="message_credit">
    <input type="hidden" name="bar" id="bar" value="" />
</form>
<table class="table table-nomargin" id="table-1">

    <thead>
        <tr>
            <th>#</th>
            <th>User Name</th>
            <th>Campaign Name</th>
            <th>Campaign Id</th>
            <th>Mobile Number Count</th>
            <th>Campaign Status</th>
            <th>Campaign Date</th>
            <th>Generate Report</th>
        </tr>
    </thead>
    <tbody>
        <?
                        $replace_txt = '{
                        "user_id" : "' . $_SESSION['smpp_user_id'] . '"
                                                }';
                        $curl = curl_init();
                        curl_setopt_array(
                                $curl,
                                array(
                                        // Create a New Group
                                        CURLOPT_URL => $api_url . '/report/generate_report_list',
                                        CURLOPT_RETURNTRANSFER => true,
                                        CURLOPT_ENCODING => '',
                                        CURLOPT_MAXREDIRS => 10,
                                        CURLOPT_TIMEOUT => 0,
                                        CURLOPT_FOLLOWLOCATION => true,
                                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                        CURLOPT_SSL_VERIFYPEER => 0,
                                        CURLOPT_CUSTOMREQUEST => 'GET',
                                        CURLOPT_POSTFIELDS => $replace_txt,
                                        CURLOPT_HTTPHEADER => array(
                                                $bearer_token,
                                                "cache-control: no-cache",
                                                'Content-Type: application/json; charset=utf-8'
                                        ),
                                )
                        );

                        site_log_generate("Template List Page : " . $_SESSION['smpp_user_name'] . " get the Service response [$response] on " . date("Y-m-d H:i:s"), '../');
                        $response = curl_exec($curl);
                        curl_close($curl);
                        site_log_generate("Template List Page : " . $_SESSION['smpp_user_name'] . " get the Service response [$response] on " . date("Y-m-d H:i:s"), '../');
                        // After got response decode the JSON result
                        if (empty($response)) {
                                // Redirect to index.php if response is empty
                                header("Location: index");
                                exit(); // Stop further execution after redirect
                        }

                        // After got response decode the JSON result
                        $sms = json_decode($response, false);
                        // To get the one by one data
                        $indicatori = 0;
                        if ($sms->num_of_rows > 0) { // If the response is success to execute this condition
                                for ($indicator = 0; $indicator < $sms->num_of_rows; $indicator++) {
                                        //Looping the indicator is less than the num_of_rows.if the condition is true to continue the process.if the condition is false to stop the process
                                        $indicatori++;
                                        $rcs_entry_date = date('d-m-Y h:i:s A', strtotime($sms->report[$indicator]->compose_entry_date));
                                        ?>
        <tr>
            <td>
                <?= $indicatori ?>
            </td>
            <td>
                <?= $sms->report[$indicator]->user_name ?>
            </td>
            <td style="text-align: center;">
                <?= $sms->report[$indicator]->campaign_name ?>
            </td>
            <td style="text-align: center;">
                <?= $sms->report[$indicator]->unique_compose_id ?>
            </td>
            <td style="text-align: center;">
                <?= $sms->report[$indicator]->total_mobile_no_count ?>
            </td>
            <td style="text-align: center;">
                <?php
                                                        switch ($sms->report[$indicator]->ucp_status) {
                                                                case 'O':
                                                                        echo '<a href="#!" class="btn btn-outline-success btn-disabled">Completed</a>';
                                                                        break;

                                                                default:
                                                                        echo '<a href="#!" class="btn btn-outline-success btn-disabled">Completed</a>';
                                                                        break;
                                                        }
                                                        ?>
            </td>
            <td style="text-align: center;">
                <?= $rcs_entry_date ?>
            </td>
            <td style="text-align:center;" id='id_approved_lineno_<?= $indicatori ?>'>

                <div class="btn-group mb-3" role="group" aria-label="Basic example">
                    <button type="button" title="Generate Report"
                        onclick="approve_popup('<?= $sms->report[$indicator]->compose_ucp_id ?>', '<?= $sms->report[$indicator]->user_id ?>')"
                        class="btn btn-icon btn-success"
                        style="width: 130px; height: 40px; padding: 0; border-radius: 0; display: flex; align-items: center; justify-content: center;">
                        Generate Report
                    </button>


                </div>

            </td>

        </tr>
        <?
                                }
                        } else if ($sms->response_status == 403) {
                                ?>
        <script>
        window.location = "index"
        </script>
        <?
                        } else if ($sms->response_status == 204) {
                                $json = array("status" => 2, "msg" => $sms->response_msg);
                        } else {
                                $json = array("status" => 0, "msg" => $sms->response_msg);
                        }
                        ?>
    </tbody>
</table>

<!-- General JS Scripts -->
<script src="libraries/assets/js/jquery.dataTables.min-1.js"></script>
<script src="libraries/assets/js/dataTables.buttons.min-1.js"></script>
<script src="libraries/assets/js/dataTables.searchPanes.min-1.js"></script>
<script src="libraries/assets/js/dataTables.select.min-1.js"></script>
<script src="libraries/assets/js/jszip.min-3.js"></script>
<script src="libraries/assets/js/pdfmake.min-3.js"></script>
<script src="libraries/assets/js/vfs_fonts-3.js"></script>
<script src="libraries/assets/js/buttons.html5.min-3.js"></script>
<script src="libraries/assets/js/buttons.colVis.min-3.js"></script>
<!-- filter using -->
<script>
$('#table-1').DataTable({
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'copyHtml5',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        {
            extend: 'csvHtml5',
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'pdfHtml5',
            exportOptions: {
                columns: ':visible' // Ensure all visible columns are exported
            },
            customize: function(doc) {
                doc.pageSize = 'A3'; // Large page size
                doc.pageOrientation = 'landscape'; // Wide layout
            }
        },
        'colvis' // Column visibility toggle
    ]
});

</script>
<?
}
// generate_report_list Page generate_report_list - End


// generate_report_list_smpp Page generate_report_list_smpp - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $call_function == "generate_report_list_smpp") {
        site_log_generate("generate_report_list_smpp Page : User : " . $_SESSION['smpp_user_name'] . " Preview on " . date("Y-m-d H:i:s"), '../');
        // Here we can Copy, Export CSV, Excel, PDF, Search, Column visibility the Table        ?>
<form name="myform" id="myForm" method="post" action="message_credit">
    <input type="hidden" name="bar" id="bar" value="" />
</form>
<table class="table table-nomargin" id="table-1">

    <thead>
        <tr>
            <th>#</th>
            <th>User Name</th>
            <th>Campaign Name</th>
            <th>Campaign Id</th>
            <th>Mobile Number Count</th>
            <th>Campaign Status</th>
            <th>Campaign Date</th>
            <th>Generate Report</th>
        </tr>
    </thead>
    <tbody>
        <?
                        $replace_txt = '{
                        "user_id" : "' . $_SESSION['smpp_user_id'] . '"
                                                }';
                        $curl = curl_init();
                        curl_setopt_array(
                                $curl,
                                array(
                                        // Create a New Group
                                        CURLOPT_URL => $api_url . '/report/generate_report_list_smpp',
                                        CURLOPT_RETURNTRANSFER => true,
                                        CURLOPT_ENCODING => '',
                                        CURLOPT_MAXREDIRS => 10,
                                        CURLOPT_TIMEOUT => 0,
                                        CURLOPT_FOLLOWLOCATION => true,
                                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                        CURLOPT_SSL_VERIFYPEER => 0,
                                        CURLOPT_CUSTOMREQUEST => 'GET',
                                        CURLOPT_POSTFIELDS => $replace_txt,
                                        CURLOPT_HTTPHEADER => array(
                                                $bearer_token,
                                                "cache-control: no-cache",
                                                'Content-Type: application/json; charset=utf-8'
                                        ),
                                )
                        );

                        site_log_generate("Template List Page : " . $_SESSION['smpp_user_name'] . " get the Service response [$response] on " . date("Y-m-d H:i:s"), '../');
                        $response = curl_exec($curl);
                        curl_close($curl);
                        site_log_generate("Template List Page : " . $_SESSION['smpp_user_name'] . " get the Service response [$response] on " . date("Y-m-d H:i:s"), '../');
                        // After got response decode the JSON result
                        if (empty($response)) {
                                // Redirect to index.php if response is empty
                                header("Location: index");
                                exit(); // Stop further execution after redirect
                        }

                        // After got response decode the JSON result
                        $sms = json_decode($response, false);
                        // To get the one by one data
                        $indicatori = 0;
                        if ($sms->num_of_rows > 0) { // If the response is success to execute this condition
                                for ($indicator = 0; $indicator < $sms->num_of_rows; $indicator++) {
                                        //Looping the indicator is less than the num_of_rows.if the condition is true to continue the process.if the condition is false to stop the process
                                        $indicatori++;
                                        $rcs_entry_date = date('d-m-Y h:i:s A', strtotime($sms->report[$indicator]->compose_entry_date));
                                        ?>
        <tr>
            <td>
                <?= $indicatori ?>
            </td>
            <td>
                <?= $sms->report[$indicator]->user_name ?>
            </td>
            <td style="text-align: center;">
                <?= $sms->report[$indicator]->campaign_name ?>
            </td>
            <td style="text-align: center;">
                <?= $sms->report[$indicator]->unique_compose_id ?>
            </td>
            <td style="text-align: center;">
                <?= $sms->report[$indicator]->total_mobile_no_count ?>
            </td>
            <td style="text-align: center;">
                <?php
                                                        switch ($sms->report[$indicator]->ucp_status) {
                                                                case 'O':
                                                                        echo '<a href="#!" class="btn btn-outline-success btn-disabled">Completed</a>';
                                                                        break;

                                                                default:
                                                                        echo '<a href="#!" class="btn btn-outline-success btn-disabled">Completed</a>';
                                                                        break;
                                                        }
                                                        ?>
            </td>
            <td style="text-align: center;">
                <?= $rcs_entry_date ?>
            </td>
            <td style="text-align:center;" id='id_approved_lineno_<?= $indicatori ?>'>

                <div class="btn-group mb-3" role="group" aria-label="Basic example">
                    <button type="button" title="Generate Report"
                        onclick="approve_popup('<?= $sms->report[$indicator]->compose_ucp_id ?>', '<?= $sms->report[$indicator]->user_id ?>')"
                        class="btn btn-icon btn-success"
                        style="width: 130px; height: 40px; padding: 0; border-radius: 0; display: flex; align-items: center; justify-content: center;">
                        Generate Report
                    </button>


                </div>

            </td>

        </tr>
        <?
                                }
                        } else if ($sms->response_status == 403) {
                                ?>
        <script>
        window.location = "index"
        </script>
        <?
                        } else if ($sms->response_status == 204) {
                                $json = array("status" => 2, "msg" => $sms->response_msg);
                        } else {
                                $json = array("status" => 0, "msg" => $sms->response_msg);
                        }
                        ?>
    </tbody>
</table>

<!-- General JS Scripts -->
<script src="libraries/assets/js/jquery.dataTables.min-1.js"></script>
<script src="libraries/assets/js/dataTables.buttons.min-1.js"></script>
<script src="libraries/assets/js/dataTables.searchPanes.min-1.js"></script>
<script src="libraries/assets/js/dataTables.select.min-1.js"></script>
<script src="libraries/assets/js/jszip.min-3.js"></script>
<script src="libraries/assets/js/pdfmake.min-3.js"></script>
<script src="libraries/assets/js/vfs_fonts-3.js"></script>
<script src="libraries/assets/js/buttons.html5.min-3.js"></script>
<script src="libraries/assets/js/buttons.colVis.min-3.js"></script>
<!-- filter using -->
<script>
$('#table-1').DataTable({
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'copyHtml5',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        {
            extend: 'csvHtml5',
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'pdfHtml5',
            exportOptions: {
                columns: ':visible' // Ensure all visible columns are exported
            },
            customize: function(doc) {
                doc.pageSize = 'A3'; // Large page size
                doc.pageOrientation = 'landscape'; // Wide layout
            }
        },
        'colvis' // Column visibility toggle
    ]
});

</script>
<?
}
// generate_report_list_smpp Page generate_report_list_smpp - End


// approve_payment Page approve_payment - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $call_function == "approve_payment") {
        site_log_generate("Approve Payment Page : User : " . $_SESSION['smpp_user_name'] . " Preview on " . date("Y-m-d H:i:s"), '../');
        // Here we can Copy, Export CSV, Excel, PDF, Search, Column visibility the Table 
        ?>
<form name="myform" id="myForm" method="post" action="message_credit">
    <input type="hidden" name="bar" id="bar" value="" />
</form>
<form name="myform" id="myForm" method="post" action="message_credit">
    <input type="hidden" name="bar" id="bar" value="" />
</form>

<table class="table table-nomargin" id="table-1" style="text-align:center;">
    <thead>
        <tr>
            <th>#</th>
            <th>User</th>
            <th>User Type</th>
            <th>Parent User</th>
            <th>Plan / Product Name</th>
            <th>Message Credit / Amount</th>
            <th>Comments</th>
            <th>Status</th>
            <th>Date</th>
            <th>Payment Details</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?
                        // To Send the request API 
                        $replace_txt = '{
                          "user_id" : "' . $_SESSION['smpp_user_id'] . '"
                        }';
                        // Add bearer token
                        $bearer_token = 'Authorization: ' . $_SESSION['smpp_bearer_token'] . '';
                        // It will call "approve_payment" API to verify, can we can we allow to view the message credit list
                        $curl = curl_init();
                        curl_setopt_array(
                                $curl,
                                array(
                                        CURLOPT_URL => $api_url . '/purchase_credit/approve_payment',
                                        CURLOPT_RETURNTRANSFER => true,
                                        CURLOPT_ENCODING => '',
                                        CURLOPT_MAXREDIRS => 10,
                                        CURLOPT_TIMEOUT => 0,
                                        CURLOPT_FOLLOWLOCATION => true,
                                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                        CURLOPT_CUSTOMREQUEST => 'GET',
                                        CURLOPT_POSTFIELDS => $replace_txt,
                                        CURLOPT_HTTPHEADER => array(
                                                $bearer_token,
                                                'Content-Type: application/json'
                                        ),
                                )
                        );
                        // Send the data into API and execute   
                        $response = curl_exec($curl);
                        site_log_generate("Approve Payment Page : " . $uname . " Execute the service [$replace_txt,$bearer_token] on " . date("Y-m-d H:i:s"), '../');
                        curl_close($curl);
                        // After got response decode the JSON result
                        $sms = json_decode($response, false);
                        site_log_generate("Approve Payment Page : " . $uname . " get the Service response [$response] on " . date("Y-m-d H:i:s"), '../');
                        // To get the one by one data
                        $indicatori = 0;
                        if ($response == '') { ?>
        <script>
        window.location = "index"
        </script>
        <? } else if ($sms->response_status == 403) { ?>
        <script>
        window.location = "index"
        </script>
        <? } else if ($sms->num_of_rows > 0) { // If the response is success to execute this condition
                                //Looping the indicator is less than the num_of_rows.if the condition is true to continue the process.if the condition is false to stop the process
                                for ($indicator = 0; $indicator < $sms->num_of_rows; $indicator++) {
                                        $indicatori++;
                                        $entry_date = date('d-m-Y h:i:s A', strtotime($sms->report[$indicator]->usr_credit_entry_date));
                                        ?>

        <tr>
            <td class="text-center"><?= $indicatori ?></td>
            <td class="text-center"><?= $sms->report[$indicator]->user_name ?></td>
            <td class="text-center"><?= $sms->report[$indicator]->user_type ?></td>
            <td class="text-center"><?= $sms->report[$indicator]->parent_name ?></td>
            <td>
                <?= $sms->report[$indicator]->price_from . " - " . $sms->report[$indicator]->price_to . " [Rs." . $sms->report[$indicator]->price_per_message . "] / (" . $sms->report[$indicator]->rights_name . ")" ?>
            </td>
            <td><?= $sms->report[$indicator]->raise_credits . " / Rs." . $sms->report[$indicator]->amount ?></td>
            <td><?= $sms->report[$indicator]->usr_credit_comments ?></td>
            <td class="text-center">
                <? switch ($sms->report[$indicator]->usr_credit_status) {
                                                                        case 'A':
                                                                                echo '<a href="#!" class="btn btn-outline-success btn-disabled" title="Approved" style="width:140px;text-align:center">Approved</a>';
                                                                                break;
                                                                        case 'W':
                                                                                echo '<a href="#!" class="btn btn-outline-info btn-disabled" style="width:140px;text-align:center" title="Waiting">Waiting</a>';
                                                                                break;
                                                                        case 'F':
                                                                                echo '<a href="#!" class="btn btn-outline-dark btn-disabled" title="Failed" style="width:140px;text-align:center">Failed</a>';
                                                                                break;
                                                                        case 'U':
                                                                                echo '<a href="#!" class="btn btn-outline-info btn-disabled" style="width:140px;text-align:center" title="Credit Updated">Credit Updated</a>';
                                                                                break;
                                                                        default:
                                                                                echo '<a href="#!" class="btn btn-outline-info btn-disabled" style="width:140px;text-align:center" title="Waiting">Waiting</a>';
                                                                                break;
                                                                } ?>
            </td>
            <td class="text-center"><?= $entry_date ?></td>
            <td class="text-center text-danger"
                style=" width: 100px;word-wrap: break-word;overflow-wrap: break-word;white-space: normal;">
                <?= $sms->report[$indicator]->usr_credit_status_cmnts ?>
            </td>
            <td class="text-center">
                <?php
                                                                $data = $sms->report[$indicator]->raise_credits . " / Rs." . $sms->report[$indicator]->amount;

                                                                // Use explode to split the string at '/ Rs.'
                                                                $parts = explode('/ Rs.', $data);

                                                                // Check if the split was successful
                                                                if (isset($parts[1])) {
                                                                        $amount_val = trim($parts[1]); // The value after '/ Rs.'
                                                                        //echo "Amount after '/ Rs.': " . $amount;
                                                                } 
                                                                if ($sms->report[$indicator]->usr_credit_status != 'U') {
                                                                        // Assign parameters to variables for readability
                                                                        $pricingSlotId = $sms->report[$indicator]->pricing_slot_id;
                                                                        $userId = $sms->report[$indicator]->user_id;
                                                                        $priceTo = $sms->report[$indicator]->price_to;
                                                                        $usrCreditId = $sms->report[$indicator]->usr_credit_id;
                                                                        $usr_credit_comments = $sms->report[$indicator]->usr_credit_comments;
                                                                        // Create the anchor tag with parameters in the URL
                                                                        echo '<a href="purchase_message_credit.php?slot_id=' . urlencode($pricingSlotId) .
                                                                                '&usr_vlu=' . urlencode($userId) .
                                                                                '&cnt_vlu=' . urlencode($priceTo) .
                                                                                '&usrsmscrd_id=' . urlencode($usrCreditId) .
                                                                                '&usr_credit_comments=' . urlencode($usr_credit_comments) .
                                                                                '&amount_val=' . urlencode($amount_val) .
                                                                                '" class="btn btn-primary formAnchor">Add Message Credit</a>';
                                                                } else {
                                                                        echo '<a href="#" class="btn btn-outline-light btn-disabled"
                 style="padding: 0.3rem 0.41rem !important; cursor: not-allowed;">Add Message Credit</a>';
                                                                }
                                                                ?>
            </td>
        </tr>

        <?
                                }
                        } else if ($sms->response_status == 204) {
                                site_log_generate("Approve Payment Page : " . $_SESSION['smpp_user_name'] . "get the Service response [$sms->response_status] on " . date("Y-m-d H:i:s"), '../');
                                $json = array("status" => 2, "msg" => $sms->response_msg);
                        } else {
                                site_log_generate("Approve Payment Page : " . $_SESSION['smpp_user_name'] . " get the Service response [$sms->response_msg] on  " . date("Y-m-d H:i:s"), '../');
                                $json = array("status" => 0, "msg" => $sms->response_msg);
                        }
                        ?>
    </tbody>
</table>

<!-- General JS Scripts -->
<script src="libraries/assets/js/jquery.dataTables.min-1.js"></script>
<script src="libraries/assets/js/dataTables.buttons.min-1.js"></script>
<script src="libraries/assets/js/dataTables.searchPanes.min-1.js"></script>
<script src="libraries/assets/js/dataTables.select.min-1.js"></script>
<script src="libraries/assets/js/jszip.min-3.js"></script>
<script src="libraries/assets/js/pdfmake.min-3.js"></script>
<script src="libraries/assets/js/vfs_fonts-3.js"></script>
<script src="libraries/assets/js/buttons.html5.min-3.js"></script>
<script src="libraries/assets/js/buttons.colVis.min-3.js"></script>
<!-- filter using -->
<script>
$('#table-1').DataTable({
    dom: 'Bfrtip',
  pageLength: 5, 
    buttons: [
        {
            extend: 'copyHtml5',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        {
            extend: 'csvHtml5',
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'pdfHtml5',
            exportOptions: {
                columns: ':visible' // Ensure all visible columns are exported
            },
            customize: function(doc) {
                doc.pageSize = 'A3'; // Large page size
                doc.pageOrientation = 'landscape'; // Wide layout
            }
        },
        'colvis' // Column visibility toggle
    ]
});

</script>
<?
}
// approve_payment Page approve_payment - End

// message_credit_list Page message_credit_list - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $call_function == "message_credit_list") {
        site_log_generate("Message Credit List Page : User : " . $_SESSION['smpp_user_name'] . " Preview on " . date("Y-m-d H:i:s"), '../');
        // Here we can Copy, Export CSV, Excel, PDF, Search, Column visibility the Table 
        ?>
<form name="myform" id="myForm" method="post" action="message_credit">
    <input type="hidden" name="bar" id="bar" value="" />
</form>
<form name="myform" id="myForm" method="post" action="message_credit">
    <input type="hidden" name="bar" id="bar" value="" />
</form>

<table class="table table-nomargin" id="table-1" style="text-align:center">
    <thead>
        <tr>
            <th>#</th>
            <th>Parent User</th>
            <th>Receiver User</th>
            <th>User Type</th>
            <th>Product Name</th>
            <th>Message Count</th>
            <th>Details</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <?
                        // To Send the request API 
                        $replace_txt = '{
            "user_id" : "' . $_SESSION['smpp_user_id'] . '"
          }';
                        // Add bearer token
                        $bearer_token = 'Authorization: ' . $_SESSION['smpp_bearer_token'] . '';
                        // It will call "message_credit_list" API to verify, can we can we allow to view the message credit list
                        $curl = curl_init();
                        curl_setopt_array(
                                $curl,
                                array(
                                        CURLOPT_URL => $api_url . '/purchase_credit/message_credit_list',
                                        CURLOPT_RETURNTRANSFER => true,
                                        CURLOPT_ENCODING => '',
                                        CURLOPT_MAXREDIRS => 10,
                                        CURLOPT_TIMEOUT => 0,
                                        CURLOPT_FOLLOWLOCATION => true,
                                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                        CURLOPT_CUSTOMREQUEST => 'GET',
                                        CURLOPT_POSTFIELDS => $replace_txt,
                                        CURLOPT_HTTPHEADER => array(
                                                $bearer_token,
                                                'Content-Type: application/json'
                                        ),
                                )
                        );
                        // Send the data into API and execute   
                        $response = curl_exec($curl);
                        site_log_generate("Message Credit List Page : " . $uname . " Execute the service [$replace_txt,$bearer_token] on " . date("Y-m-d H:i:s"), '../');
                        curl_close($curl);
                        // After got response decode the JSON result
                        $sms = json_decode($response, false);
                        site_log_generate("Message Credit List Page : " . $uname . " get the Service response [$response] on " . date("Y-m-d H:i:s"), '../');
                        // To get the one by one data
                        $indicatori = 0;
                        if ($response == '') { ?>
        <script>
        window.location = "index"
        </script>
        <? } else if ($sms->response_status == 403) { ?>
        <script>
        window.location = "index"
        </script>
        <? } else if ($sms->num_of_rows > 0) { // If the response is success to execute this condition
//Looping the indicator is less than the num_of_rows.if the condition is true to continue the process.if the condition is false to stop the process
                                for ($indicator = 0; $indicator < $sms->num_of_rows; $indicator++) {
                                        $indicatori++;
                                        $entry_date = date('d-m-Y h:i:s A', strtotime($sms->report[$indicator]->message_credit_log_entdate));
                                        ?>
        <tr>
            <td><?= $indicatori ?></td>
            <td><?= $sms->report[$indicator]->parntname ?></td>
            <td><?= $sms->report[$indicator]->usrname ?></td>
            <td><?= $sms->report[$indicator]->user_type ?></td>
            <td><?= $sms->report[$indicator]->rights_name ?></td>
            <td><?= $sms->report[$indicator]->provided_message_count ?></td>
            <td><?= $sms->report[$indicator]->message_comments ?></td>
            <td><?= $entry_date ?></td>
        </tr>
        <?
                                }
                        } else if ($sms->response_status == 204) {
                                site_log_generate("Message Credit List Page : " . $_SESSION['smpp_user_name'] . "get the Service response [$sms->response_status] on " . date("Y-m-d H:i:s"), '../');
                                $json = array("status" => 2, "msg" => $sms->response_msg);
                        } else {
                                site_log_generate("Message Credit List Page : " . $_SESSION['smpp_user_name'] . " get the Service response [$sms->response_msg] on  " . date("Y-m-d H:i:s"), '../');
                                $json = array("status" => 0, "msg" => $sms->response_msg);
                        }
                        ?>
    </tbody>
</table>

<!-- General JS Scripts -->
<script src="libraries/assets/js/jquery.dataTables.min-1.js"></script>
<script src="libraries/assets/js/dataTables.buttons.min-1.js"></script>
<script src="libraries/assets/js/dataTables.searchPanes.min-1.js"></script>
<script src="libraries/assets/js/dataTables.select.min-1.js"></script>
<script src="libraries/assets/js/jszip.min-3.js"></script>
<script src="libraries/assets/js/pdfmake.min-3.js"></script>
<script src="libraries/assets/js/vfs_fonts-3.js"></script>
<script src="libraries/assets/js/buttons.html5.min-3.js"></script>
<script src="libraries/assets/js/buttons.colVis.min-3.js"></script>
<script>
$('#table-1').DataTable({
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'copyHtml5',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        {
            extend: 'csvHtml5',
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'pdfHtml5',
            exportOptions: {
                columns: ':visible' // Ensure all visible columns are exported
            },
            customize: function(doc) {
                doc.pageSize = 'A3'; // Large page size
                doc.pageOrientation = 'landscape'; // Wide layout
            }
        },
        'colvis' // Column visibility toggle
    ]
});

</script>
<?
}
// message_credit_list Page message_credit_list - End

// purchase_message_credit_list Page purchase_message_credit_list - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $call_function == "purchase_message_credit_list") {
        site_log_generate("Payment History Page : User : " . $_SESSION['smpp_user_name'] . " Preview on " . date("Y-m-d H:i:s"), '../');
        // Here we can Copy, Export CSV, Excel, PDF, Search, Column visibility the Table 
        ?>
<form name="myform" id="myForm" method="post" action="purchase_message_credit">
    <input type="hidden" name="bar" id="bar" value="" />
</form>
<table class="table table-nomargin" id="table-1">
    <thead>
        <tr>
            <th>#</th>
            <th>User</th>
            <th>Parent User</th>
            <th>Plan / Product Name</th>
            <th>Message Credit / Amount</th>
            <th>Comments</th>
            <th>Status</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <?
                        // To Send the request API 
                        $replace_txt = '{
                          "user_id" : "' . $_SESSION['smpp_user_id'] . '"
                        }';
                        // Add bearer token
                        $bearer_token = 'Authorization: ' . $_SESSION['smpp_bearer_token'] . '';
                        // It will call "purchase_message_credit_list" API to verify, can we can we allow to view the message credit list
                        $curl = curl_init();
                        curl_setopt_array(
                                $curl,
                                array(
                                        CURLOPT_URL => $api_url . '/purchase_credit/payment_history',
                                        CURLOPT_RETURNTRANSFER => true,
                                        CURLOPT_ENCODING => '',
                                        CURLOPT_MAXREDIRS => 10,
                                        CURLOPT_TIMEOUT => 0,
                                        CURLOPT_FOLLOWLOCATION => true,
                                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                        CURLOPT_CUSTOMREQUEST => 'GET',
                                        CURLOPT_POSTFIELDS => $replace_txt,
                                        CURLOPT_HTTPHEADER => array(
                                                $bearer_token,
                                                'Content-Type: application/json'
                                        ),
                                )
                        );
                        // Send the data into API and execute   
                        $response = curl_exec($curl);
                        //      echo $response;

                        // Decode the JSON response
                        $sms = json_decode($response, false);

                        // Check if there is any response data
                        if ($sms->num_of_rows > 0) {
                                // Loop through the response and get each usr_credit_id
                                foreach ($sms->report as $entry) {
                                        // Store usr_credit_id (for example, in an array)
                                        $usr_credit_id = $entry->usr_credit_id;

                                        // Optionally, echo or store the value as needed
                                        //echo 'usr_credit_id: ' . $usr_credit_id . '<br>';

                                }
                        } else {
                                echo "No data found!";
                        }
                        //echo "ID",$usr_credit_id;
                        site_log_generate("Payment History Page : " . $uname . " Execute the service [$replace_txt,$bearer_token] on " . date("Y-m-d H:i:s"), '../');
                        curl_close($curl);
                        // After got response decode the JSON result
                        $sms = json_decode($response, false);
                        site_log_generate("Payment History Page : " . $uname . " get the Service response [$response] on " . date("Y-m-d H:i:s"), '../');
                        // To get the one by one data
                        $indicatori = 0;
                        if ($response == '') { ?>
        <script>
        window.location = "index"
        </script>
        <? } else if ($sms->response_status == 403) { ?>
        <script>
        window.location = "index"
        </script>
        <? }
                        if ($sms->num_of_rows > 0) { // If the response is success to execute this condition
                                //Looping the indicator is less than the num_of_rows.if the condition is true to continue the process.if the condition is false to stop the process
                                for ($indicator = 0; $indicator < $sms->num_of_rows; $indicator++) {
                                        $indicatori++;
                                        $entry_date = date('d-m-Y h:i:s A', strtotime($sms->report[$indicator]->usr_credit_entry_date));
                                        ?>
        <tr>
            <td class="text-center"><?= $indicatori ?></td>
            <td class="text-center"><?= $sms->report[$indicator]->user_name ?></td>
            <td class="text-center"><?= $sms->report[$indicator]->parent_name ?></td>
            <td>
                <?= $sms->report[$indicator]->price_from . " - " . $sms->report[$indicator]->price_to . " [Rs." . $sms->report[$indicator]->price_per_message . "] / (" . $sms->report[$indicator]->rights_name . ")" ?>
            </td>
            <td><?= $sms->report[$indicator]->raise_credits . " / Rs." . $sms->report[$indicator]->amount ?></td>
            <td><?= $sms->report[$indicator]->usr_credit_comments ?></td>
            <td class="text-center">
                <?php
                                                        switch ($sms->report[$indicator]->usr_credit_status) {
                                                                case 'A':
                                                                        echo '<a href="#!" class="btn btn-outline-success btn-disabled" title="Amount Paid" style="width:150px; text-align:center">Amount Paid</a>';
                                                                        break;
                                                                case 'U':
                                                                        echo '<a href="#!" class="btn btn-outline-success btn-disabled" title="Message Credited" style="width:150px; text-align:center">Message Credited</a>';
                                                                        break;
                                                                case 'W':
                                                                        // Display a clickable "Amount Not Paid" button with link parameters
                                                                        // Assign parameters
                                                                        $pricingSlotId = urlencode($sms->report[$indicator]->pricing_slot_id);
                                                                        $amount = urlencode($sms->report[$indicator]->amount);
                                                                        $usr_credit_comments = urlencode($sms->report[$indicator]->usr_credit_comments);
                                                                        $rights_name = urlencode($sms->report[$indicator]->rights_name);
                                                                        $usr_credit_id = urlencode($sms->report[$indicator]->usr_credit_id);
                                                                        // Create the clickable "Amount Not Paid" link
                                                                        echo '<a href="purchase_message_credit.php?' .
                                                                                'slot_id=' . $pricingSlotId .
                                                                                '&usr_vlu=' . $rights_name .
                                                                                '&cnt_vlu=' . $amount .
                                                                                '&usrsmscrd_id=' . $usr_credit_comments .
                                                                                '&usr_credit_id=' . $usr_credit_id .
                                                                                '" class="btn btn-outline-info" style="width:150px; text-align:center" title="Amount Not Paid">Amount Not Paid</a>';
                                                                        break;

                                                                case 'F':
                                                                        echo '<a href="#!" class="btn btn-outline-dark btn-disabled" title="Failed" style="width:150px; text-align:center">Failed</a>';
                                                                        break;
                                                                case 'N':
                                                                        echo '<a href="#!" class="btn btn-outline-dark btn-disabled" title="Inactive" style="width:150px; text-align:center">Inactive</a>';
                                                                        break;
                                                                default:
                                                                        echo '<a href="#!" class="btn btn-outline-info btn-disabled" style="width:150px; text-align:center" title="Amount Not Paid">Amount Not Paid</a>';
                                                                        break;
                                                        }
                                                        ?>
            </td>
            <td class="text-center"><?= $entry_date ?></td>
        </tr>

        <?
                                }
                        } else if ($sms->response_status == 204) {
                                site_log_generate("Payment History Page : " . $_SESSION['smpp_user_name'] . "get the Service response [$sms->response_status] on " . date("Y-m-d H:i:s"), '../');
                                $json = array("status" => 2, "msg" => $sms->response_msg);
                        } else {
                                site_log_generate("Payment History Page : " . $_SESSION['smpp_user_name'] . " get the Service response [$sms->response_msg] on  " . date("Y-m-d H:i:s"), '../');
                                $json = array("status" => 0, "msg" => $sms->response_msg);
                        }
                        ?>
    </tbody>
</table>

<!-- General JS Scripts -->
<script src="libraries/assets/js/jquery.dataTables.min-1.js"></script>
<script src="libraries/assets/js/dataTables.buttons.min-1.js"></script>
<script src="libraries/assets/js/dataTables.searchPanes.min-1.js"></script>
<script src="libraries/assets/js/dataTables.select.min-1.js"></script>
<script src="libraries/assets/js/jszip.min-3.js"></script>
<script src="libraries/assets/js/pdfmake.min-3.js"></script>
<script src="libraries/assets/js/vfs_fonts-3.js"></script>
<script src="libraries/assets/js/buttons.html5.min-3.js"></script>
<script src="libraries/assets/js/buttons.colVis.min-3.js"></script>
<!-- filter using -->
<script>
$('#table-1').DataTable({
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'copyHtml5',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        {
            extend: 'csvHtml5',
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'pdfHtml5',
            exportOptions: {
                columns: ':visible' // Ensure all visible columns are exported
            },
            customize: function(doc) {
                doc.pageSize = 'A3'; // Large page size
                doc.pageOrientation = 'landscape'; // Wide layout
            }
        },
        'colvis' // Column visibility toggle
    ]
});
</script>
<?
}
// purchase_message_credit_list Page purchase_message_credit_list - End

// manage_users_list Page manage_users_list - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $call_function == "manage_users_list") {
        site_log_generate("Message Credit List Page : User : " . $_SESSION['smpp_user_name'] . " Preview on " . date("Y-m-d H:i:s"), '../');
        // Here we can Copy, Export CSV, Excel, PDF, Search, Column visibility the Table 
        ?>
<form name="myform" id="myForm" method="post" action="message_credit">
    <input type="hidden" name="bar" id="bar" value="" />
</form>
<table class="table table-nomargin" id="table-1" style="text-align:center">
    <thead>
        <tr>
            <th>#</th>
            <th>Parent</th>
            <th>User Name </th>
            <th>User Type</th>
            <th>Contact Details</th>
            <th>User status</th>
            <th>Deleted Reason</th>
            <th>View</th>
        </tr>
    </thead>
    <tbody>
        <?
                        // To Send the request API 
                        $replace_txt = '{
            "user_id" : "' . $_SESSION['smpp_user_id'] . '"
          }';
                        // Add bearer token
                        $bearer_token = 'Authorization: ' . $_SESSION['smpp_bearer_token'] . '';
                        // It will call "manage_users_list" API to verify, can we can we allow to view the message credit list
                        $curl = curl_init();
                        curl_setopt_array(
                                $curl,
                                array(
                                        CURLOPT_URL => $api_url . '/list/manage_users_list',
                                        CURLOPT_RETURNTRANSFER => true,
                                        CURLOPT_ENCODING => '',
                                        CURLOPT_MAXREDIRS => 10,
                                        CURLOPT_TIMEOUT => 0,
                                        CURLOPT_FOLLOWLOCATION => true,
                                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                        CURLOPT_CUSTOMREQUEST => 'GET',
                                        CURLOPT_POSTFIELDS => $replace_txt,
                                        CURLOPT_HTTPHEADER => array(
                                                $bearer_token,
                                                'Content-Type: application/json'
                                        ),
                                )
                        );
                        // Send the data into API and execute   
                        $response = curl_exec($curl);
                        //echo $response;
                        site_log_generate("Message Credit List Page : " . $uname . " Execute the service [$replace_txt,$bearer_token] on " . date("Y-m-d H:i:s"), '../');
                        curl_close($curl);
                        // After got response decode the JSON result
                        $sms = json_decode($response, false);
                        site_log_generate("Message Credit List Page : " . $uname . " get the Service response [$response] on " . date("Y-m-d H:i:s"), '../');
                        // To get the one by one data
                        $indicatori = 0;
                        if ($response == '') { ?>
        <script>
        window.location = "index"
        </script>
        <? } else if ($sms->response_status == 403) { ?>
        <script>
        window.location = "index"
        </script>
        <? } else if ($sms->num_of_rows > 0) { // If the response is success to execute this condition
//Looping the indicator is less than the num_of_rows.if the condition is true to continue the process.if the condition is false to stop the process
                                for ($indicator = 0; $indicator < $sms->num_of_rows; $indicator++) {
                                        $indicatori++;
                                        $entry_date = date('d-m-Y h:i:s A', strtotime($sms->report[$indicator]->usr_mgt_entry_date));
                                        ?>
        <tr>
            <td>
                <?= $indicatori ?>
            </td>
            <td>
                <?= $sms->report[$indicator]->parent_name ?>
            </td>
            <td>
                <?= $sms->report[$indicator]->user_name ?>
            </td>
            <td>
                <?= $sms->report[$indicator]->user_type ?>
            </td>
            <td>Mobile :
                <?= $sms->report[$indicator]->user_mobile ?><br>Email :
                <?= $sms->report[$indicator]->user_email ?>
            </td>
            <td>
                <? if ($sms->report[$indicator]->usr_mgt_status == 'Y') { ?>
                <div class="badge badge-success">Active</div>
                <? } elseif ($sms->report[$indicator]->usr_mgt_status == 'R') { ?>
                <div class="badge badge-danger">Rejected</div>
                <? } elseif ($sms->report[$indicator]->usr_mgt_status == 'N') { ?>
                <div class="badge badge-info">Waiting for Approval</div>
                <? } elseif ($sms->report[$indicator]->usr_mgt_status == 'S') { ?>
                <div class="badge badge-info">Suspend</div>
                <? } elseif ($sms->report[$indicator]->usr_mgt_status == 'D') { ?>
                <div class="badge badge-info">Delete</div>
                <? } ?>
                <br>
                <?= $entry_date ?>
            </td>
            <td>
                <?= $sms->report[$indicator]->reject_reason ?>
            </td>
            <td>
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <div>
                            <a href="view_onboarding?action=viewrep&usr=<?= $sms->report[$indicator]->user_id ?>"
                                class="dropdown-item">View Account</a>
                        </div>
                        <?php if ($sms->report[$indicator]->usr_mgt_status != 'S') { ?>
                        <div> <a href="view_onboarding?action=suspend&usr=<?= $sms->report[$indicator]->user_id ?>"
                                class="dropdown-item">Suspend Account</a></div>
                        <?php } ?>
                        <?php if ($sms->report[$indicator]->usr_mgt_status != 'D') { ?>
                        <div><a href="view_onboarding?action=reject&usr=<?= $sms->report[$indicator]->user_id ?>"
                                class="dropdown-item">Delete Account</a></div>
                        <?php } ?>
                        <?php if ($sms->report[$indicator]->usr_mgt_status != 'Y') { ?>
                        <div><a href="view_onboarding?action=active&usr=<?= $sms->report[$indicator]->user_id ?>"
                                class="dropdown-item">Activate Account</a></div>
                        <?php } ?>
                        <div class="dropdown-divider"></div>
                    </div>
                </div>
            </td>
        </tr>
        <?
                                }
                        } else if ($sms->response_status == 204) {
                                site_log_generate("Message Credit List Page : " . $_SESSION['smpp_user_name'] . "get the Service response [$sms->response_status] on " . date("Y-m-d H:i:s"), '../');
                                $json = array("status" => 2, "msg" => $sms->response_msg);
                        } else {
                                site_log_generate("Message Credit List Page : " . $_SESSION['smpp_user_name'] . " get the Service response [$sms->response_msg] on  " . date("Y-m-d H:i:s"), '../');
                                $json = array("status" => 0, "msg" => $sms->response_msg);
                        }
                        ?>
    </tbody>
</table>
<!-- General JS Scripts -->
<script src="libraries/assets/js/jquery.dataTables.min-1.js"></script>
<script src="libraries/assets/js/dataTables.buttons.min-1.js"></script>
<script src="libraries/assets/js/dataTables.searchPanes.min-1.js"></script>
<script src="libraries/assets/js/dataTables.select.min-1.js"></script>
<script src="libraries/assets/js/jszip.min-3.js"></script>
<script src="libraries/assets/js/pdfmake.min-3.js"></script>
<script src="libraries/assets/js/vfs_fonts-3.js"></script>
<script src="libraries/assets/js/buttons.html5.min-3.js"></script>
<script src="libraries/assets/js/buttons.colVis.min-3.js"></script>
<!-- filter using -->
<script>
$('#table-1').DataTable({
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'copyHtml5',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        {
            extend: 'csvHtml5',
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'pdfHtml5',
            exportOptions: {
                columns: ':visible' // Ensure all visible columns are exported
            },
            customize: function(doc) {
                doc.pageSize = 'A3'; // Large page size
                doc.pageOrientation = 'landscape'; // Wide layout
            }
        },
        'colvis' // Column visibility toggle
    ]
});

</script>
<?
}
// manage_users_list Page manage_users_list - End



// Dashboard Page dashboard_count - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $call_function == "dashboard_counts") {
        site_log_generate("Dashboard Page : User : " . $_SESSION['smpp_user_name'] . " access this page on " . date("Y-m-d H:i:s"), '../');
        // To Send the request  API
        $replace_txt = '{
    "user_id" : "' . $_SESSION['smpp_user_id'] . '"
  }';
        // Log the service execution with the request payload
        site_log_generate("Manage Users Page: $uname sent request to " . $api_url . "/dashboard/dashboard with method [POST] and payload [$replace_txt] on " . date("Y-m-d H:i:s"), "../");


        $curl = curl_init();
        curl_setopt_array(
                $curl,
                array(
                        // Create a New Group
                        CURLOPT_URL => $api_url . '/dashboard/dashboard_list',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_SSL_VERIFYPEER => 0,
                        CURLOPT_CUSTOMREQUEST => 'GET',
                        CURLOPT_POSTFIELDS => $replace_txt,
                        CURLOPT_HTTPHEADER => array(
                                $bearer_token,
                                "cache-control: no-cache",
                                'Content-Type: application/json; charset=utf-8'
                        ),
                )
        );

        site_log_generate("Template List Page : " . $_SESSION['smpp_user_name'] . " get the Service response [$response] on " . date("Y-m-d H:i:s"), '../');
        $response = curl_exec($curl);
        //echo $response;
        curl_close($curl);
        // After got response decode the JSON result
        if (empty($response)) {
                // Redirect to index.php if response is empty
                header("Location: index");
                exit(); // Stop further execution after redirect
        }
        // After got response decode the JSON result
        $state1 = json_decode($response, false);
        site_log_generate("Dashboard Page : " . $_SESSION['smpp_user_name'] . " get the Service response [$response] on " . date("Y-m-d H:i:s"), '../');
        $total_msg = 0;
        $total_success = 0;
        $total_failed = 0;
        $total_invalid = 0;
        $total_waiting = 0;
        $total_delivered = 0;

        $total_msg = array();
        $total_success = array();
        $total_delivered = array();
        $total_waiting = array();
        $tot_failed = array();
        $tot_read = array();
        $available_messages = array();
        $user_name = array();
        $header_title = array();
        $entry_dates = array();
        $rights_names = array();
        // To get the one by one data
        if ($state1->response_status == 403) { ?>
<script>
window.location = "index"
</script>
<? } else if ($state1->response_code == 1) { // If the response is success to execute this condition
                foreach ($state1->report as $report_group) {
                        foreach ($report_group as $report) {
                                //      echo  $report->rights_name;
                                $user_name[] = $report->user_name; // Assuming 'user_name' is consistent across rights
                                $total_msg[] = $report->total_msg;
                                $rights_names[] = $report->rights_name;
                                $total_success[] = $report->total_success;
                                $total_delivered[] = $report->total_delivered;
                                $total_waiting[] = $report->total_waiting;
                                $tot_failed[] = isset($report->total_failed) ? $report->total_failed + (isset($report->total_invalid) ? $report->total_invalid : 0) : 0;
                                $tot_read[] = isset($report->total_read) ? $report->total_read : 0;
                                $entry_dates[] = $report->entry_date;
                        }
                }

                for ($indicator = 0; $indicator < count($state1->rights_name); $indicator++) {
                        //Looping the indicator is less than the count of report.if the condition is true to continue the process.if the condition is false to stop the process 
                        $header_title[] = $state1->rights_name[$indicator]->rights_name;
                }
                ?>
<input type="hidden" class="form-control" name='user_name' id='user_name' value='<?= json_encode($user_name) ?>' />
<input type="hidden" class="form-control" name='rights_names' id='rights_names'
    value='<?= json_encode($rights_names) ?>' />
<input type="hidden" class="form-control" name='available_messages' id='available_messages'
    value='<?= json_encode($available_messages) ?>' />
<input type="hidden" class="form-control" name='total_msg' id='total_msg' value='<?= json_encode($total_msg) ?>' />
<input type="hidden" class="form-control" name='total_read' id='total_read' value='<?= json_encode($total_read) ?>' />
<input type="hidden" class="form-control" name='total_success' id='total_success'
    value='<?= json_encode($total_success) ?>' />
<input type="hidden" class="form-control" name='total_delivered' id='total_delivered'
    value='<?= json_encode($total_delivered) ?>' />
<input type="hidden" class="form-control" name='total_waiting' id='total_waiting'
    value='<?= json_encode($total_waiting) ?>' />
<input type="hidden" class="form-control" name='tot_failed' id='tot_failed' value='<?= json_encode($tot_failed) ?>' />
<input type="hidden" class="form-control" name='rights_name' id='rights_name'
    value='<?= json_encode($header_title) ?>' />
<input type="hidden" class="form-control" name='entry_date' id='entry_date' value='<?= json_encode($entry_dates) ?>' />
<? }
}
//dashboard_count end

//compose_call_smpp - start 
if ($_SERVER["REQUEST_METHOD"] == "POST" and $call_function == "compose_call_smpp") {
        site_log_generate("Compose smpp On Boarding Page : User : " . $_SESSION["smpp_user_name"] . " access the page on " . date("Y-m-d H:i:s"), "../");
        // Get data
        $selectedValue_tmplname = htmlspecialchars(strip_tags($_REQUEST['selectedValue_tmplname'] ?? ""));
        // Build JSON payload
        $replace_txt = '{
  "selectedValue_tmplname" : "' . $selectedValue_tmplname . '"
}';

        $curl = curl_init();
        curl_setopt_array($curl, array(
                CURLOPT_URL => $api_url . '/list/get_content_tmpl',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $replace_txt,
                CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json',
                        $bearer_token
                ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $sql_routmast2 = json_decode($response);
  if($sql_routmast2->result){?>
    <select name="id_slt_template" id="id_slt_template" tabindex="3" class="input-block-level input-block-level-primary required" data-toggle="tooltip" data-placement="top" title="" data-original-title="Select Template" onclick="select_content_template()">
        <? for ($indicator = 0; $indicator < count($sql_routmast2->result); $indicator++) {?>
<option
    value="<?= $sql_routmast2->result[$indicator]->cn_msgtype ?>!<?= $sql_routmast2->result[$indicator]->cn_message ?>!<?= $sql_routmast2->result[$indicator]->cm_content_tmplid ?>">
    <?= $sql_routmast2->result[$indicator]->cn_template_name ?>
</option>
<?
        }?>
</select>
<?php
}else{
    echo '<option value="">No available content template</option>';
}
}
// compose_call_smpp - end 


// whatsapp_no_api_list Page whatsapp_no_api_list - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $call_function == "whatsapp_no_api_list") {
        site_log_generate("Manage Sender ID List Page : User : " . $_SESSION['smpp_user_name'] . " Preview on " . date("Y-m-d H:i:s"), '../');
        // Here we can Copy, Export CSV, Excel, PDF, Search, Column visibility the Table ?>
<form name="myform" id="myForm" method="post" action="message_credit">
    <input type="hidden" name="bar" id="bar" value="" />
</form>
<table class="table table-nomargin text-center" id="table-1">
    <thead>
        <tr class="text-center">
            <th>#</th>
            <th>User</th>
            <th>Mobile No</th>
            <th>Profile Details</th>
            <th>Available Credits</th>
            <th>Used Credits</th>
            <th>Status</th>
            <th>Entry Date</th>
            <th>Approved Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?
                        // To Send the request API 
                        $replace_txt = '{
        "user_id" : "' . $_SESSION['smpp_user_id'] . '"
      }';

                // Call the reusable cURL function
              $response = executeCurlRequest($api_url . "/list/sender_id_list", "GET", $replace_txt);

              // After got response decode the JSON result
              if (empty($response)) {
                  // Redirect to index.php if response is empty
                  header("Location: index");
                  exit(); // Stop further execution after redirect
              }

                        // After got response decode the JSON result
                        $sms = json_decode($response, false);
                        // To get the one by one data
                        $indicatori = 0;
                        if ($sms->num_of_rows > 0) {
                                // Looping the indicator is less than the num_of_rows.if the condition is true to continue the process.if the condition is false to stop the process
                                for ($indicator = 0; $indicator < $sms->num_of_rows; $indicator++) {
                                        $indicatori++;
                                        $entry_date = date('d-m-Y h:i:s A', strtotime($sms->sender_id[$indicator]->whatspp_config_entdate));
                                        if ($sms->sender_id[$indicator]->whatspp_config_apprdate != '' and $sms->sender_id[$indicator]->whatspp_config_apprdate != '0000-00-00 00:00:00') {
                                                $approved_date = date('d-m-Y h:i:s A', strtotime($sms->sender_id[$indicator]->whatspp_config_apprdate));
                                        }
                                        ?>
        <tr>
            <td><?= $indicatori ?></td>
            <td><?= strtoupper($sms->sender_id[$indicator]->user_name) ?></td>
            <td><?= $sms->sender_id[$indicator]->country_code . $sms->sender_id[$indicator]->mobile_no ?></td>
            <td>
                <? echo $sms->sender_id[$indicator]->wht_display_name . "<br>";
                                                        if ($sms->sender_id[$indicator]->wht_display_logo != '') {
                                                                echo "<img src='uploads/whatsapp_images/" . $sms->sender_id[$indicator]->wht_display_logo . "' style='width:100px; max-height: 200px;'>";
                                                        } ?>
            </td>
            <td><b>
                    <? if ($sms->sender_id[$indicator]->whatspp_config_status == 'Y') {
                                                        echo ($sms->sender_id[$indicator]->available_credit);
                                                } else {
                                                        echo "0";
                                                } ?>
                </b></td>
            <td><b>
                    <? if ($sms->sender_id[$indicator]->whatspp_config_status == 'Y') {
                                                        echo $sms->sender_id[$indicator]->sent_count;
                                                } else {
                                                        echo "0";
                                                } ?>
                </b></td>
            <td>
                <? if ($sms->sender_id[$indicator]->whatspp_config_status == 'Y') { ?><a href="#!"
                    class="btn btn-outline-success btn-disabled" style="width:100px; text-align:center">Active</a>
                <? } elseif ($sms->sender_id[$indicator]->whatspp_config_status == 'D') { ?><a href="#!"
                    class="btn btn-outline-danger btn-disabled" style="width:100px; text-align:center">Deleted</a>
                <? } elseif ($sms->sender_id[$indicator]->whatspp_config_status == 'B') { ?><a href="#!"
                    class="btn btn-outline-dark btn-disabled" style="width:100px; text-align:center">Blocked</a>
                <? } elseif ($sms->sender_id[$indicator]->whatspp_config_status == 'N') { ?><a href="#!"
                    class="btn btn-outline-danger btn-disabled" style="width:100px; text-align:center">Inactive</a>
                <? } elseif ($sms->sender_id[$indicator]->whatspp_config_status == 'M') { ?><a href="#!"
                    class="btn btn-outline-danger btn-disabled" style="width:100px; text-align:center">Mobile No
                    Mismatch</a>
                <? } elseif ($sms->sender_id[$indicator]->whatspp_config_status == 'I') { ?><a href="#!"
                    class="btn btn-outline-warning btn-disabled" style="width:100px; text-align:center">Invalid</a>
                <? } elseif ($sms->sender_id[$indicator]->whatspp_config_status == 'P') { ?><a href="#!"
                    class="btn btn-outline-info btn-disabled" style="width:100px; text-align:center">Processing</a>
                <? } elseif ($sms->sender_id[$indicator]->whatspp_config_status == 'R') { ?><a href="#!"
                    class="btn btn-outline-danger btn-disabled" style="width:100px; text-align:center">Rejected</a>
                <? } elseif ($sms->sender_id[$indicator]->whatspp_config_status == 'X') { ?><a href="#!"
                    class="btn btn-outline-primary btn-disabled" style="width:100px; text-align:center">Need
                    Rescan</a>
                <? } elseif ($sms->sender_id[$indicator]->whatspp_config_status == 'L') { ?><a href="#!"
                    class="btn btn-outline-info btn-disabled" style="width:100px; text-align:center">Linked</a>
                <? } elseif ($sms->sender_id[$indicator]->whatspp_config_status == 'U') { ?><a href="#!"
                    class="btn btn-outline-warning btn-disabled" style="width:100px; text-align:center">Unlinked</a>
                <? } ?>
            </td>
            <td><?= $entry_date ?></td>
            <td><?= $approved_date ?></td>
            <td id='id_approved_lineno_<?= $indicatori ?>'>
                <? if ($sms->sender_id[$indicator]->whatspp_config_status != 'D') { ?>
                <button type="button" title="Delete Sender ID"
                    onclick="remove_senderid_popup('<?= $sms->sender_id[$indicator]->whatspp_config_id ?>', 'D', '<?= $indicatori ?>')"
                    class="btn btn-icon btn-danger"
                    style="width: 60.21px; height: 33.89px; display: inline-block; text-align: center; padding: 0; line-height: 33.89px; border-radius: 0;">
                    Delete
                </button>
                <? } else { ?>
                <a href="#!" class="btn btn-outline-light btn-disabled"
                    style="padding: 0.3rem 0.41rem !important;cursor: not-allowed;">Delete</a>
                <? } ?>
            </td>
        </tr>
        <?
                                }
                        } else if ($sms->response_status == 204) {
                                site_log_generate("Manage Sender ID List Page : " . $_SESSION['smpp_user_name'] . "get the Service response [$sms->response_status] on " . date("Y-m-d H:i:s"), '../');
                                $json = array("status" => 2, "msg" => $sms->response_msg);
                        } else {
                                site_log_generate("Manage Sender ID List Page : " . $_SESSION['smpp_user_name'] . " get the Service response [$sms->response_msg] on  " . date("Y-m-d H:i:s"), '../');
                                $json = array("status" => 0, "msg" => $sms->response_msg);
                        }
                        ?>
    </tbody>
</table>
<!-- General JS Scripts -->
<script src="libraries/assets/js/jquery.dataTables.min-1.js"></script>
<script src="libraries/assets/js/dataTables.buttons.min-1.js"></script>
<script src="libraries/assets/js/dataTables.searchPanes.min-1.js"></script>
<script src="libraries/assets/js/dataTables.select.min-1.js"></script>
<script src="libraries/assets/js/jszip.min-3.js"></script>
<script src="libraries/assets/js/pdfmake.min-3.js"></script>
<script src="libraries/assets/js/vfs_fonts-3.js"></script>
<script src="libraries/assets/js/buttons.html5.min-3.js"></script>
<script src="libraries/assets/js/buttons.colVis.min-3.js"></script>
<!-- filter using -->
<script>
$('#table-1').DataTable({
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'copyHtml5',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        {
            extend: 'csvHtml5',
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'pdfHtml5',
            exportOptions: {
                columns: ':visible' // Ensure all visible columns are exported
            },
            customize: function(doc) {
                doc.pageSize = 'A3'; // Large page size
                doc.pageOrientation = 'landscape'; // Wide layout
            }
        },
        'colvis' // Column visibility toggle
    ]
});

</script>
<?
}
// whatsapp_no_api_list Page whatsapp_no_api_list - End


// template_list Page template_list - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $call_function == "template_list_whsp") {
  site_log_generate("Template List Page : User : " . $_SESSION['smpp_user_name'] . " Preview on " . date("Y-m-d H:i:s"), '../');
  // Here we can Copy, Export CSV, Excel, PDF, Search, Column visibility the Table ?>
<form name="myform" id="myForm" method="post" action="message_credit">
    <input type="hidden" name="bar" id="bar" value="" />
</form>
<table class="table table-nomargin text-center" id="table-1">
    <thead>
        <tr class="text-center">
            <th>#</th>
            <th>User</th>
            <th>Template Name</th>
            <th>Template Category</th>
            <th>Template Details</th>
            <th>Sender ID</th>
            <th>Status</th>
            <th>Entry Date</th>
            <th>Approved Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?
          // To Send the request API
          $replace_txt = '{
      "user_id" : "' . $_SESSION['smpp_user_id'] . '"
    }';

        // Call the reusable cURL function
        $response = executeCurlRequest($api_url . "/list/p_template_list", "GET", $replace_txt);

        // After got response decode the JSON result
        if (empty($response)) {
            // Redirect to index.php if response is empty
            header("Location: index");
            exit(); // Stop further execution after redirect
        }
          // After got response decode the JSON result
          $sms = json_decode($response, false);
          $indicatori = 0;
          if ($sms->num_of_rows > 0) {
            // If the response is success to execute this condition
            for ($indicator = 0; $indicator < $sms->num_of_rows; $indicator++) {
              // Looping the indicator is less than the num_of_rows.if the condition is true to continue the process.if the condition is false to stop the process
              $indicatori++;
              $approve_date = '-';
              // To get the one by one data
              if ($sms->templates[$indicator]->template_entdate != '' and $sms->templates[$indicator]->template_entdate != '00-00-0000 12:00:00 AM') {
                $entry_date = date('d-m-Y h:i:s A', strtotime($sms->templates[$indicator]->template_entdate));
              }
              if ($sms->templates[$indicator]->approve_date != '' and $sms->templates[$indicator]->approve_date != '0000-00-00 00:00:00' and $sms->templates[$indicator]->approve_date != '00-00-0000 12:00:00 AM') {
                $approve_date = date('d-m-Y h:i:s A', strtotime($sms->templates[$indicator]->approve_date));
              }

              $wht_tmpl_url = $whatsapp_tmplate_url . $sms->templates[$indicator]->whatsapp_business_acc_id;
              $wht_bearer_token = $sms->templates[$indicator]->bearer_token;
              ?>
        <tr>
            <td><?= $indicatori ?></td>
            <td class="text-left no-wrap"><?= $sms->templates[$indicator]->receiver_username; ?></td>
            <td class="text-left"><?= $sms->templates[$indicator]->template_name; ?></td>
            <td class="text-left"><?= $sms->templates[$indicator]->template_category ?></td>
            <td class="text-left" id='id_display_template_<?= $indicatori ?>'>
                <?= $sms->templates[$indicator]->template_message ?>
            </td>
            <td><?= $sms->templates[$indicator]->country_code . $sms->templates[$indicator]->mobile_no ?></td>
            <td id='id_template_status_<?= $indicatori ?>'>
                <? if ($sms->templates[$indicator]->template_status == 'Y') { ?><a href="#!"
                    class="btn btn-outline-success btn-disabled" style="width:90px; text-align:center">Approved</a>
                <? } elseif ($sms->templates[$indicator]->template_status == 'N') { ?><a href="#!"
                    class="btn btn-outline-warning btn-disabled" style="width:90px; text-align:center">Inactive</a>
                <? } elseif ($sms->templates[$indicator]->template_status == 'R') { ?><a href="#!"
                    class="btn btn-outline-danger btn-disabled" style="width:90px; text-align:center">Rejected</a>
                <? } elseif ($sms->templates[$indicator]->template_status == 'F') { ?><a href="#!"
                    class="btn btn-outline-dark btn-disabled" style="width:90px; text-align:center">Failed</a>
                <? } elseif ($sms->templates[$indicator]->template_status == 'D') { ?><a href="#!"
                    class="btn btn-outline-danger btn-disabled" style="width:90px; text-align:center">Deleted</a>
                <? } elseif ($sms->templates[$indicator]->template_status == 'S') { ?><a href="#!"
                    class="btn btn-outline-info btn-disabled" style="width:90px; text-align:center">Waiting</a>
                <? } ?>
            </td>
            <td><?= $entry_date ?></td>
            <td><?= $approve_date ?></td>
            <td><a href="#!"
                    onclick="call_getsingletemplate('<?= $sms->templates[$indicator]->template_name ?>!<?= $sms->templates[$indicator]->language_code ?>', '<?= $wht_tmpl_url ?>', '<?= $wht_bearer_token ?>', '<?= $indicatori ?>')">View</a>
                <? if ($sms->templates[$indicator]->template_response_id != '-' and $sms->templates[$indicator]->template_status != 'D') { ?>/
                <a href="#!"
                    onclick="remove_template_popup('<?= $sms->templates[$indicator]->unique_template_id ?>', '<?= $indicatori ?>')">Delete</a>
                <? } ?>
            </td>
        </tr>
        <?
            }
          } else if ($sms->response_status == 204) {
            site_log_generate("Template List Page : " . $_SESSION['smpp_user_name'] . "get the Service response [$sms->response_status] on " . date("Y-m-d H:i:s"), '../');
            $json = array("status" => 2, "msg" => $sms->response_msg);
          } else {
            site_log_generate("Template List Page : " . $_SESSION['smpp_user_name'] . " get the Service response [$sms->response_msg] on  " . date("Y-m-d H:i:s"), '../');
            $json = array("status" => 0, "msg" => $sms->response_msg);
          }
          ?>
    </tbody>
</table>
<!-- General Datatable JS Scripts -->
<script src="libraries/assets/js/jquery.dataTables.min-1.js"></script>
<script src="libraries/assets/js/dataTables.buttons.min-1.js"></script>
<script src="libraries/assets/js/dataTables.searchPanes.min-1.js"></script>
<script src="libraries/assets/js/dataTables.select.min-1.js"></script>
<script src="libraries/assets/js/jszip.min-3.js"></script>
<script src="libraries/assets/js/pdfmake.min-3.js"></script>
<script src="libraries/assets/js/vfs_fonts-3.js"></script>
<script src="libraries/assets/js/buttons.html5.min-3.js"></script>
<script src="libraries/assets/js/buttons.colVis.min-3.js"></script>
<!-- filter using -->
<script>
$('#table-1').DataTable({
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'copyHtml5',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        {
            extend: 'csvHtml5',
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'pdfHtml5',
            exportOptions: {
                columns: ':visible' // Ensure all visible columns are exported
            },
            customize: function(doc) {
                doc.pageSize = 'A3'; // Large page size
                doc.pageOrientation = 'landscape'; // Wide layout
            }
        },
        'colvis' // Column visibility toggle
    ]
});

</script>
<?
}
// template_list Page template_list - End


// approve_whatsapp_no_api Page approve_whatsapp_no_api - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $call_function == "approve_whatsapp_no_api") {
        site_log_generate("Approve Sender ID List Page : User : " . $_SESSION['smpp_user_name'] . " Preview on " . date("Y-m-d H:i:s"), '../');
        // Here we can Copy, Export CSV, Excel, PDF, Search, Column visibility the Table    ?>
<form name="myform" id="myForm" method="post" action="message_credit">
    <input type="hidden" name="bar" id="bar" value="" />
</form>
<table class="table table-nomargin" id="table-1">
    <thead>
        <tr>
            <th>#</th>
            <th>User</th>
            <th>Mobile No</th>
            <th>Phone No ID</th>
            <th>Business Account ID</th>
            <th>Bearer Token</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?
                        $replace_txt = '{
        "user_id" : "' . $_SESSION['smpp_user_id'] . '"
  }';
  
        // Call the reusable cURL function
         $response = executeCurlRequest($api_url . "/list/approve_whatsapp_no_api", "GET", $replace_txt);

         // After got response decode the JSON result
         if (empty($response)) {
             // Redirect to index.php if response is empty
             header("Location: index");
             exit(); // Stop further execution after redirect
         }
                        // After got response decode the JSON result
                        $sms = json_decode($response, false);
                        // To get the one by one data
                        $indicatori = 0;
                        if ($sms->num_of_rows > 0) { // If the response is success to execute this condition
                          for ($indicator = 0; $indicator < $sms->num_of_rows; $indicator++) {
                                //Looping the indicator is less than the num_of_rows.if the condition is true to continue the process.if the condition is false to stop the process
                                $indicatori++;
                                ?>
        <tr>
            <td><?= $indicatori ?></td>
            <td><?= $sms->report[$indicator]->user_name ?></td>
            <td style="text-align: center;">
                <?= $mobile_number = $sms->report[$indicator]->country_code . $sms->report[$indicator]->mobile_no ?>
            </td>

            <td><input type='text' class="form_control" autofocus id="phone_number_id_<?= $indicatori ?>"
                    name="phone_number_id_<?= $indicatori ?>" value="<?= $sms->report[$indicator]->phone_number_id ?>"
                    placeholder="Phone No ID" maxlength="15"
                    onkeypress="return (event.charCode !=8 && event.charCode ==0 || ( event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)))"
                    style="width: 100%"></td>

            <td><input type='text' class="form_control" id="whatsapp_business_acc_id_<?= $indicatori ?>"
                    name="whatsapp_business_acc_id_<?= $indicatori ?>"
                    value="<?= $sms->report[$indicator]->whatsapp_business_acc_id ?>" placeholder="Business Account ID"
                    maxlength="15"
                    onkeypress="return (event.charCode !=8 && event.charCode ==0 || ( event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)))"
                    style="width: 100%"></td>

            <td><input type='text' class="form_control" id="bearer_token_value_<?= $indicatori ?>"
                    name="bearer_token_value_<?= $indicatori ?>" value="<?= $sms->report[$indicator]->bearer_token ?>"
                    placeholder="Bearer Token" maxlength="300" style="text-transform: uppercase; width: 100%"></td>

            <td style="text-align: center;">
                <?
                                        switch ($sms->report[$indicator]->whatspp_config_status) {
                                          case 'N':
                                                ?><a href="#!" class="btn btn-outline-primary btn-disabled">New</a>
                <?
                                                break;
  
                                          case 'L':
                                                ?><a href="#!" class="btn btn-outline-info btn-disabled">Whatsapp Linked</a>
                <?
                                                break;
                                          case 'U':
                                                ?><a href="#!" class="btn btn-outline-warning btn-disabled">Whatsapp Unlinked</a>
                <?
                                                break;
                                          case 'X':
                                                ?><a href="#!" class="btn btn-outline-primary btn-disabled">Rescan</a>
                <?
                                                break;
  
                                          case 'Y':
                                                ?><a href="#!" class="btn btn-outline-success btn-disabled">Super Admin Approved</a>
                <?
                                                break;
                                          case 'R':
                                                ?><a href="#!" class="btn btn-outline-danger btn-disabled">Super Admin Rejected</a>
                <?
                                                break;
  
                                          default:
                                                ?><a href="#!" class="btn btn-outline-dark btn-disabled">Invalid</a>
                <?
                                                break;
                                        } ?>
            </td>
            <td style="text-align:center;" id='id_approved_lineno_<?= $indicatori ?>'>
                <div class="btn-group mb-3" role="group" aria-label="Basic example">
                    <button type="button" title="Approve"
                        onclick="func_save_phbabt_popup('<?= $sms->report[$indicator]->whatspp_config_id ?>', 'Y', '<?= $indicatori ?>', 'phone_number_id', 'whatsapp_business_acc_id', 'bearer_token_value', <?= $mobile_number ?>)"
                        class="btn btn-icon btn-success"
                        style="border-radius: 0; display: flex; align-items: center; justify-content: center; padding: 10px 15px; min-width: 50px;">
                        <i class="fas fa-check" style="margin: 0;"></i>
                    </button>

                    <button type="button" title="Reject"
                        onclick="change_status_popup('<?= $sms->report[$indicator]->whatspp_config_id ?>', 'R', '<?= $indicatori ?>')"
                        class="btn btn-icon btn-danger"
                        style="border-radius: 0; display: flex; align-items: center; justify-content: center; padding: 10px 15px; min-width: 50px;">
                        <i class="fas fa-times" style="margin: 0;"></i>
                    </button>
                </div>

            </td>
        </tr>
        <?
                          }
                        } else if ($sms->response_status == 204) {
                          site_log_generate("Approve Sender ID Page : " . $_SESSION['smpp_user_name'] . "get the Service response [$sms->response_status] on " . date("Y-m-d H:i:s"), '../');
                          $json = array("status" => 2, "msg" => $sms->response_msg);
                        } else {
                          site_log_generate("Approve Sender ID Page : " . $_SESSION['smpp_user_name'] . " get the Service response [$sms->response_msg] on  " . date("Y-m-d H:i:s"), '../');
                          $json = array("status" => 0, "msg" => $sms->response_msg);
                        }
                        ?>
    </tbody>
</table>
<!-- General JS Scripts -->
<script src="libraries/assets/js/jquery.dataTables.min-1.js"></script>
<script src="libraries/assets/js/dataTables.buttons.min-1.js"></script>
<script src="libraries/assets/js/dataTables.searchPanes.min-1.js"></script>
<script src="libraries/assets/js/dataTables.select.min-1.js"></script>
<script src="libraries/assets/js/jszip.min-3.js"></script>
<script src="libraries/assets/js/pdfmake.min-3.js"></script>
<script src="libraries/assets/js/vfs_fonts-3.js"></script>
<script src="libraries/assets/js/buttons.html5.min-3.js"></script>
<script src="libraries/assets/js/buttons.colVis.min-3.js"></script>
<!-- filter using -->
<script>
$('#table-1').DataTable({
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'copyHtml5',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        {
            extend: 'csvHtml5',
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'pdfHtml5',
            exportOptions: {
                columns: ':visible' // Ensure all visible columns are exported
            },
            customize: function(doc) {
                doc.pageSize = 'A3'; // Large page size
                doc.pageOrientation = 'landscape'; // Wide layout
            }
        },
        'colvis' // Column visibility toggle
    ]
});

</script>
<?
  }
  // approve_whatsapp_no_api Page approve_whatsapp_no_api - End

  // approve_template Page approve_template - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $call_function == "approve_template") {
    site_log_generate("Approve Sender ID List Page : User : " . $_SESSION['yjwatsp_user_name'] . " Preview on " . date("Y-m-d H:i:s"), '../');
    // Here we can Copy, Export CSV, Excel, PDF, Search, Column visibility the Table?>
<form name="myform" id="myForm" method="post" action="message_credit">
    <input type="hidden" name="bar" id="bar" value="" />
</form>
<table class="table table-nomargin" id="table-1">
    <thead>
        <tr>
            <th>#</th>
            <th>User</th>
            <th>Template Name</th>
            <th>Template_language</th>
            <th>Template Date</th>
            <th>Status</th>
            <th>Action</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?
        $replace_txt = '{
    "user_id" : "' . $_SESSION['smpp_user_id'] . '"
  }';
        // Call the reusable cURL function
         $response = executeCurlRequest($api_url . "/whsp_process/approve_template_list", "GET", $replace_txt);

         // After got response decode the JSON result
         if (empty($response)) {
             // Redirect to index.php if response is empty
             header("Location: index");
             exit(); // Stop further execution after redirect
         }

        // After got response decode the JSON result
        $sms = json_decode($response, false);
        site_log_generate("Approve Sender ID Page : " . $uname . " get the Service response [$response] on " . date("Y-m-d H:i:s"), '../');
        // To get the one by one data
        $indicatori = 0;
        if ($sms->num_of_rows > 0) { // If the response is success to execute this condition
          for ($indicator = 0; $indicator < $sms->num_of_rows; $indicator++) {
            //Looping the indicator is less than the num_of_rows.if the condition is true to continue the process.if the condition is false to stop the process
            $indicatori++;
            $template_entdate = date('d-m-Y h:i:s A', strtotime($sms->report[$indicator]->template_entdate));
            ?>
        <tr>
            <td>
                <?= $indicatori ?>
            </td>
            <td>
                <?= $sms->report[$indicator]->user_name ?>
            </td>
            <td style="text-align: center;">
                <?= $sms->report[$indicator]->unique_template_id ?>
            </td>

            <td style="text-align: center;">
                <?= $sms->report[$indicator]->language_name ?>
            </td>

            <td style="text-align: center;">
                <?= $template_entdate ?>
            </td>

            <td style="text-align: center;">
                <? if ($sms->report[$indicator]->template_status == 'N') { ?>
                <a href="#!" class="btn btn-outline-danger btn-disabled">Not approve</a>
                <? } ?>
            </td>

            <td><a href="#!"
                    onclick="call_getsingletemplate('<?= $sms->report[$indicator]->template_name?>!<?= $sms->report[$indicator]->language_code ?>', '<?= $indicatori ?>')">View</a>
            </td>
            <td style="text-align:center;" id='id_approved_lineno_<?= $indicatori ?>'>
                <div class="btn-group mb-3" role="group" aria-label="Basic example">
                    <button type="button" title="Approve"
                        style="border-radius: 0; display: flex; align-items: center; justify-content: center; padding: 10px 15px; min-width: 50px;"
                        onclick="approve_popup('<?= $sms->report[$indicator]->unique_template_id ?>', 'Y', '<?= $indicatori ?>')"
                        class="btn btn-icon btn-success"><i class="fas fa-check"></i></button>

                    <button type="button" title="Reject" onclick="change_status_popup('<?= $sms->report[$indicator]->unique_template_id ?>', 'R',
            '<?= $indicatori ?>')" class="btn btn-icon btn-danger"
                        style="border-radius: 0; display: flex; align-items: center; justify-content: center; padding: 10px 15px; min-width: 50px;"><i
                            class="fas fa-times"></i></button>
                </div>
            </td>
        </tr>
        <?
          }
        } else if ($sms->response_status == 204) {
          site_log_generate("Approve Sender ID Page : " . $user_name . "get the Service response [$sms->response_status] on " . date("Y-m-d H:i:s"), '../');
          $json = array("status" => 2, "msg" => $sms->response_msg);
        } else {
          if ($sms->response_status == 403 || $response == '') { ?>
        <script>
        window.location = "index"
        </script>
        <? }
          site_log_generate("Approve Sender ID Page : " . $user_name . " get the Service response [$sms->response_msg] on  " . date("Y-m-d H:i:s"), '../');
          $json = array("status" => 0, "msg" => $sms->response_msg);
        }
        ?>
    </tbody>
</table>
<!-- General JS Scripts -->
<!-- General JS Scripts -->
<script src="libraries/assets/js/jquery.dataTables.min-1.js"></script>
<script src="libraries/assets/js/dataTables.buttons.min-1.js"></script>
<script src="libraries/assets/js/dataTables.searchPanes.min-1.js"></script>
<script src="libraries/assets/js/dataTables.select.min-1.js"></script>
<script src="libraries/assets/js/jszip.min-3.js"></script>
<script src="libraries/assets/js/pdfmake.min-3.js"></script>
<script src="libraries/assets/js/vfs_fonts-3.js"></script>
<script src="libraries/assets/js/buttons.html5.min-3.js"></script>
<script src="libraries/assets/js/buttons.colVis.min-3.js"></script>
<!-- filter using -->
<script>
$('#table-1').DataTable({
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'copyHtml5',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        {
            extend: 'csvHtml5',
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'pdfHtml5',
            exportOptions: {
                columns: ':visible' // Ensure all visible columns are exported
            },
            customize: function(doc) {
                doc.pageSize = 'A3'; // Large page size
                doc.pageOrientation = 'landscape'; // Wide layout
            }
        },
        'colvis' // Column visibility toggle
    ]
});

</script>

<?
  }
// approve_template Page approve_template - End
  
// whatsapp_list Page whatsapp_list - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $call_function == "whatsapp_list") {
    site_log_generate("Whatsapp List Page : User : " . $_SESSION['smpp_user_name'] . " Preview on " . date("Y-m-d H:i:s"), '../');
    // Here we can Copy, Export CSV, Excel, PDF, Search, Column visibility the Table ?>
<form name="myform" id="myForm" method="post" action="message_credit">
    <input type="hidden" name="bar" id="bar" value="" />
</form>
<table class="table table-nomargin text-center" id="table-1">
    <thead>
        <tr class="text-center">
            <th>#</th>
            <th>User</th>
            <th>Campaign Name</th>
            <th>Campaign id</th>
            <th>Total Count</th>
            <th>Status</th>
            <th>Entry Date</th>
            <th>Approved Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?
            // To Send the request API
            $replace_txt = '{
        "user_id" : "' . $_SESSION['smpp_user_id'] . '"
      }';
                // Call the reusable cURL function
                   $response = executeCurlRequest($api_url . "/compose_whatsapp_list", "GET", $replace_txt);

                   // After got response decode the JSON result
                   if (empty($response)) {
                       // Redirect to index.php if response is empty
                       header("Location: index");
                       exit(); // Stop further execution after redirect
                   }
            // After got response decode the JSON result
            $sms = json_decode($response, false);
            $indicatori = 0;
            if ($sms->num_of_rows > 0) {
              // If the response is success to execute this condition
              for ($indicator = 0; $indicator < $sms->num_of_rows; $indicator++) {
                // Looping the indicator is less than the num_of_rows.if the condition is true to continue the process.if the condition is false to stop the process
                $indicatori++;
                // To get the one by one data
                  $entry_date = date('d-m-Y h:i:s A', strtotime($sms->report[$indicator]->compose_entry_date));
                  $ucp_start_date = !empty($sms->report[$indicator]->ucp_start_date) ? date('d-m-Y h:i:s A', strtotime($sms->report[$indicator]->ucp_start_date)) : '-';
                $wht_tmpl_url = $whatsapp_tmplate_url . $sms->report[$indicator]->whatsapp_business_acc_id;
                $wht_bearer_token = $sms->report[$indicator]->bearer_token;
                ?>
        <tr class="text-center">
            <td><?= $indicatori ?></td>
            <td><?= $sms->report[$indicator]->user_name; ?></td>
            <td><?= $sms->report[$indicator]->campaign_name; ?></td>
            <td><?= $sms->report[$indicator]->campaign_id ?></td>
            <td><?= $sms->report[$indicator]->total_mobile_no_count ?> </td>
            <td id='id_ucp_status_<?= $indicatori ?>'>
                <? if ($sms->report[$indicator]->ucp_status == 'Y') { ?>
                <a href="#!" class="btn btn-outline-success btn-disabled"
                    style="width:90px; text-align:center">Completed</a>
                <? } 
                elseif ($sms->report[$indicator]->ucp_status == 'P') { ?>
                <a href="#!" class="btn btn-outline-warning btn-disabled"
                    style="width:90px; text-align:center">Processing</a>
                <? } 
                elseif ($sms->report[$indicator]->ucp_status == 'R') { ?><a href="#!"
                    class="btn btn-outline-danger btn-disabled" style="width:90px; text-align:center">Rejected</a>
                <? } 
                elseif ($sms->report[$indicator]->ucp_status == 'F') { ?><a href="#!"
                    class="btn btn-outline-dark btn-disabled" style="width:90px; text-align:center">Failed</a>
                <? } 
                elseif ($sms->report[$indicator]->ucp_status == 'W') { ?><a href="#!"
                    class="btn btn-outline-info btn-disabled" style="width:90px; text-align:center">Waiting</a>
                <? } ?>
            </td>
            <td><?= $entry_date ?></td>

            <td><?= ($ucp_start_date === "null" || $ucp_start_date === null) ? '-' : $ucp_start_date; ?></td>
            <td><a href="#!"
                    onclick="call_getsingletemplate('<?= $sms->report[$indicator]->campaign_name ?>!<?= $sms->report[$indicator]->language_code ?>', '<?= $wht_tmpl_url ?>', '<?= $wht_bearer_token ?>', '<?= $indicatori ?>')">View</a>
                <? if ($sms->report[$indicator]->template_response_id != '-' and $sms->report[$indicator]->template_status != 'D') { ?>/
                <a href="#!"
                    onclick="remove_template_popup('<?= $sms->report[$indicator]->unique_template_id ?>', '<?= $indicatori ?>')">Delete</a>
                <? } ?>
            </td>
        </tr>
        <?
              }
            } else if ($sms->response_status == 204) {
              site_log_generate("Template List Page : " . $_SESSION['smpp_user_name'] . "get the Service response [$sms->response_status] on " . date("Y-m-d H:i:s"), '../');
              $json = array("status" => 2, "msg" => $sms->response_msg);
            } else {
              site_log_generate("Template List Page : " . $_SESSION['smpp_user_name'] . " get the Service response [$sms->response_msg] on  " . date("Y-m-d H:i:s"), '../');
              $json = array("status" => 0, "msg" => $sms->response_msg);
            }
            ?>
    </tbody>
</table>
<!-- General Datatable JS Scripts -->
<script src="libraries/assets/js/jquery.dataTables.min-1.js"></script>
<script src="libraries/assets/js/dataTables.buttons.min-1.js"></script>
<script src="libraries/assets/js/dataTables.searchPanes.min-1.js"></script>
<script src="libraries/assets/js/dataTables.select.min-1.js"></script>
<script src="libraries/assets/js/jszip.min-3.js"></script>
<script src="libraries/assets/js/pdfmake.min-3.js"></script>
<script src="libraries/assets/js/vfs_fonts-3.js"></script>
<script src="libraries/assets/js/buttons.html5.min-3.js"></script>
<script src="libraries/assets/js/buttons.colVis.min-3.js"></script>
<!-- filter using -->
<script>
$('#table-1').DataTable({
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'copyHtml5',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        {
            extend: 'csvHtml5',
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'pdfHtml5',
            exportOptions: {
                columns: ':visible' // Ensure all visible columns are exported
            },
            customize: function(doc) {
                doc.pageSize = 'A3'; // Large page size
                doc.pageOrientation = 'landscape'; // Wide layout
            }
        },
        'colvis' // Column visibility toggle
    ]
});

</script>
<?
  }
  // whatsapp_list Page whatsapp_list - End

  // approve_whatsappList Page approve_whatsappList - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $call_function == "approve_whatsapp_list") {
    site_log_generate("Approve Whatsapp List Page : User : " . $_SESSION['yjwatsp_user_name'] . " Preview on " . date("Y-m-d H:i:s"), '../');
    // Here we can Copy, Export CSV, Excel, PDF, Search, Column visibility the Table?>
<form name="myform" id="myForm" method="post" action="message_credit">
    <input type="hidden" name="bar" id="bar" value="" />
</form>
<table class="table table-nomargin" id="table-1">
    <thead>
        <tr>
            <th>#</th>
            <th>User</th>
            <th>Campaign Name</th>
            <th>Campaign id</th>
            <th>Total Count</th>
            <th>Status</th>
            <th>Entry Date</th>
            <th>Message View</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?
        $replace_txt = '{
                 "user_id" : "' . $_SESSION['smpp_user_id'] . '"
                         }';
            // Call the reusable cURL function
            $response = executeCurlRequest($api_url . "/approve_whatsapp_list", "GET", $replace_txt);

                        // After got response decode the JSON result
                        if (empty($response)) {
                                // Redirect to index.php if response is empty
                                header("Location: index");
                                exit(); // Stop further execution after redirect
                        }
        // After got response decode the JSON result
        $sms = json_decode($response, false);
        site_log_generate("Approve Sender ID Page : " . $uname . " get the Service response [$response] on " . date("Y-m-d H:i:s"), '../');
        // To get the one by one data
        $indicatori = 0;
       if ($sms->num_of_rows > 0) {
              // If the response is success to execute this condition
              for ($indicator = 0; $indicator < $sms->num_of_rows; $indicator++) {
                // Looping the indicator is less than the num_of_rows.if the condition is true to continue the process.if the condition is false to stop the process
                $indicatori++;
                // To get the one by one data
                  $entry_date = date('d-m-Y h:i:s A', strtotime($sms->report[$indicator]->compose_entry_date));
                ?>
        <tr class="text-center">
            <td><?= $indicatori ?></td>
            <td><?= $sms->report[$indicator]->user_name; ?></td>
            <td><?= $sms->report[$indicator]->campaign_name; ?></td>
            <td><?= $sms->report[$indicator]->campaign_id ?></td>
            <td><?= $sms->report[$indicator]->total_mobile_no_count ?> </td>
            <td id='id_ucp_status_<?= $indicatori ?>'>
                <? if ($sms->report[$indicator]->ucp_status == 'Y') { ?>
                <a href="#!" class="btn btn-outline-success btn-disabled"
                    style="width:90px; text-align:center">Completed</a>
                <? } 
                elseif ($sms->report[$indicator]->ucp_status == 'P') { ?>
                <a href="#!" class="btn btn-outline-warning btn-disabled"
                    style="width:90px; text-align:center">Processing</a>
                <? } 
                elseif ($sms->report[$indicator]->ucp_status == 'R') { ?><a href="#!"
                    class="btn btn-outline-danger btn-disabled" style="width:90px; text-align:center">Rejected</a>
                <? } 
                elseif ($sms->report[$indicator]->ucp_status == 'F') { ?><a href="#!"
                    class="btn btn-outline-dark btn-disabled" style="width:90px; text-align:center">Failed</a>
                <? } 
                elseif ($sms->report[$indicator]->ucp_status == 'W') { ?><a href="#!"
                    class="btn btn-outline-info btn-disabled" style="width:90px; text-align:center">Waiting</a>
                <? } ?>
            </td>
            <td><?= $entry_date ?></td>
            <td><a href="#!"
                    onclick="call_getsingletemplate('<?= $sms->report[$indicator]->campaign_name?>!<?= $sms->report[$indicator]->compose_ucp_id ?>', '<?= $indicatori ?>')">View</a>
            </td>
            <td style="text-align:center;" id='id_approved_lineno_<?= $indicatori ?>'>
                <div class="btn-group mb-3" role="group" aria-label="Basic example">
                    <button type="button" title="Approve"
                        style="border-radius: 0; display: flex; align-items: center; justify-content: center; padding: 10px 15px; min-width: 50px;"
                        onclick="approve_campaign_popup('<?= $sms->report[$indicator]->compose_ucp_id?>','<?= $sms->report[$indicator]->user_id ?>', '<?= $indicatori ?>')"
                        class="btn btn-icon btn-success"><i class="fas fa-check"></i></button>
                    <button type="button" title="Reject"
                        onclick="campaign_status_popup('<?= $sms->report[$indicator]->compose_ucp_id ?>', '<?= $sms->report[$indicator]->user_id ?>','R','<?= $indicatori ?>')"
                        class="btn btn-icon btn-danger"
                        style="border-radius: 0; display: flex; align-items: center; justify-content: center; padding: 10px 15px; min-width: 50px;"><i
                            class="fas fa-times"></i></button>
                </div>
            </td>
        </tr>
        <?
          }
        } else if ($sms->response_status == 204) {
          site_log_generate("Approve Sender ID Page : " . $user_name . "get the Service response [$sms->response_status] on " . date("Y-m-d H:i:s"), '../');
          $json = array("status" => 2, "msg" => $sms->response_msg);
        } else {
          if ($sms->response_status == 403 || $response == '') { ?>
        <script>
        window.location = "index"
        </script>
        <? }
          site_log_generate("Approve Sender ID Page : " . $user_name . " get the Service response [$sms->response_msg] on  " . date("Y-m-d H:i:s"), '../');
          $json = array("status" => 0, "msg" => $sms->response_msg);
        }
        ?>
    </tbody>
</table>
<!-- General JS Scripts -->
<script src="libraries/assets/js/jquery.dataTables.min-1.js"></script>
<script src="libraries/assets/js/dataTables.buttons.min-1.js"></script>
<script src="libraries/assets/js/dataTables.searchPanes.min-1.js"></script>
<script src="libraries/assets/js/dataTables.select.min-1.js"></script>
<script src="libraries/assets/js/jszip.min-3.js"></script>
<script src="libraries/assets/js/pdfmake.min-3.js"></script>
<script src="libraries/assets/js/vfs_fonts-3.js"></script>
<script src="libraries/assets/js/buttons.html5.min-3.js"></script>
<script src="libraries/assets/js/buttons.colVis.min-3.js"></script>
<!-- filter using -->
<script>
$('#table-1').DataTable({
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'copyHtml5',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        {
            extend: 'csvHtml5',
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'pdfHtml5',
            exportOptions: {
                columns: ':visible' // Ensure all visible columns are exported
            },
            customize: function(doc) {
                doc.pageSize = 'A3'; // Large page size
                doc.pageOrientation = 'landscape'; // Wide layout
            }
        },
        'colvis' // Column visibility toggle
    ]
});

</script>

<?
  }
  // approve_whatsappList Page approve_whatsappList - End


// summary_report_whatsapp Page summary_report_whatsapp - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $call_function == "summary_report_whatsapp") {
        site_log_generate("Business Summary Report Page : User : " . $_SESSION['smpp_user_name'] . " Preview on " . date("Y-m-d H:i:s"), '../');
        // Here we can Copy, Export CSV, Excel, PDF, Search, Column visibility the Table 
        ?>
<form name="myform" id="myForm" method="post" action="message_credit">
    <input type="hidden" name="bar" id="bar" value="" />
</form>
<table class="table table-nomargin" id="table-1">
    <thead>
        <tr>
            <th>#</th>
            <th>Date</th>
            <th>User</th>
            <th>Campaign</th>
            <!-- <th>Campaign Id</th> -->
            <th>Total Pushed</th>
            <th>Sent</th>
            <th>Delivered</th>
            <th>Read</th>
            <th>Failed</th>
            <th>In progress</th>
        </tr>
    </thead>
    <tbody>
        <?
                        if ($_REQUEST['dates']) {
                                $date = $_REQUEST['dates'];
                        } else {
                                $date = date('m/d/Y') . "-" . date('m/d/Y'); // 01/28/2023 - 02/27/2023 
                        }

                        $td = explode('-', $date);
                        $thismonth_startdate = date("Y/m/d", strtotime($td[0]));
                        $thismonth_today = date("Y/m/d", strtotime($td[1]));

                        $replace_txt = '{
          "user_id" : "' . $_SESSION['smpp_user_id'] . '",';
                        if ($date) {
                                $replace_txt .= '"filter_date" : "' . $thismonth_startdate . ' - ' . $thismonth_today . '",';
                        }

                        // Add rights_name field
                        $replace_txt .= '"rights_name" : "SMPP",';

                        // To Send the request API 
                        $replace_txt = rtrim($replace_txt, ",");
                        $replace_txt .= '}';
                                                // Call the reusable cURL function
                        $response = executeCurlRequest($api_url . "/report/summary_report_whatsapp", "GET", $replace_txt);

                        // After got response decode the JSON result
                        if (empty($response)) {
                                // Redirect to index.php if response is empty
                                header("Location: index");
                                exit(); // Stop further execution after redirect
                        }

                        // After got response decode the JSON result
                        $sms = json_decode($response, false);
                        // To get the one by one data
                        $indicatori = 0;
                        if ($sms->report) {
                                // If the response is success to execute this condition
                                for ($indicator = 0; $indicator < count($sms->report); $indicator++) {
                                        //Looping the indicator is less than the count of report.if the condition is true to continue the process.if the condition is false to stop the process
                                        $indicatori++;
                                        $entry_date = date('d-m-Y', strtotime($sms->report[$indicator]->entry_date));
                                        $user_id = $sms->report[$indicator]->user_id;
                                        $user_name = $sms->report[$indicator]->user_name;
                                        $user_master_id = $sms->report[$indicator]->user_master_id;
                                        $user_type = $sms->report[$indicator]->user_type;
                                        $total_msg = $sms->report[$indicator]->total_msg;
                                        $credits = $sms->report[$indicator]->available_messages;
                                        $total_success = $sms->report[$indicator]->total_success;
                                        $total_delivered = $sms->report[$indicator]->total_delivered;
                                        $total_read = $sms->report[$indicator]->total_read;
                                        $total_failed = $sms->report[$indicator]->total_failed;
                                        $total_waiting = $sms->report[$indicator]->total_process;
                                        $total_invalid = $sms->report[$indicator]->total_invalid;
                                        $campaign_name = $sms->report[$indicator]->campaign_name;

                                        if ($user_id != '') {
                                                $increment++;
                                                ?>
        <tr style="text-align: center !important">
            <td>
                <?= $increment ?>
            </td>
            <td>
                <?= $entry_date ?>
            </td>
            <td>
                <?= $user_name ?>
            </td>
            <td>
                <?= $campaign_name ?>
            </td>

            <td>
                <?= $total_msg ?>
            </td>
            <td>
                <?= $total_success ?>
            </td>
            <td>
                <?= $total_delivered ?>
            </td>
            <td>
                <?= $total_read ?>
            </td>
            <td>
                <?= $total_failed ?>
            </td>
            <td>
                <?= $total_waiting ?>
            </td>
        </tr>

        <?
                                        }
                                }
                        } else if ($sms->response_status == 403) {
                                ?>
        <script>
        window.location = "index"
        </script>
        <?
                        } else if ($sms->response_status == 204) {
                                $json = array("status" => 2, "msg" => $sms->response_msg);
                        } else {
                                $json = array("status" => 0, "msg" => $sms->response_msg);
                        }
                        ?>

    </tbody>
</table>
<!-- filter using -->
<script src="libraries/assets/js/jquery.dataTables.min-1.js"></script>
<script src="libraries/assets/js/dataTables.buttons.min-1.js"></script>
<script src="libraries/assets/js/dataTables.searchPanes.min-1.js"></script>
<script src="libraries/assets/js/dataTables.select.min-1.js"></script>
<script src="libraries/assets/js/jszip.min-3.js"></script>
<script src="libraries/assets/js/pdfmake.min-3.js"></script>
<script src="libraries/assets/js/vfs_fonts-3.js"></script>
<script src="libraries/assets/js/buttons.html5.min-3.js"></script>
<script src="libraries/assets/js/buttons.colVis.min-3.js"></script>
<script>
$('#table-1').DataTable({
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'copyHtml5',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        {
            extend: 'csvHtml5',
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'pdfHtml5',
            exportOptions: {
                columns: ':visible' // Ensure all visible columns are exported
            },
            customize: function(doc) {
                doc.pageSize = 'A3'; // Large page size
                doc.pageOrientation = 'landscape'; // Wide layout
            }
        },
        'colvis' // Column visibility toggle
    ]
});

</script>
<?

}
// summary_report_whatsapp - end

// generate_report_list_whatsapp Page generate_report_list_whatsapp - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $call_function == "generate_report_list_whatsapp") {
        site_log_generate("generate_report_list_whatsapp Page : User : " . $_SESSION['smpp_user_name'] . " Preview on " . date("Y-m-d H:i:s"), '../');
        // Here we can Copy, Export CSV, Excel, PDF, Search, Column visibility the Table        ?>
<form name="myform" id="myForm" method="post" action="message_credit">
    <input type="hidden" name="bar" id="bar" value="" />
</form>
<table class="table table-nomargin" id="table-1">

    <thead>
        <tr>
            <th>#</th>
            <th>User Name</th>
            <th>Campaign Name</th>
            <th>Campaign Id</th>
            <th>Mobile Number Count</th>
            <th>Campaign Status</th>
            <th>Campaign Date</th>
            <th>Generate Report</th>
        </tr>
    </thead>
    <tbody>
        <?
                        $replace_txt = '{
                        "user_id" : "' . $_SESSION['smpp_user_id'] . '"
                                                }';

                                                // Call the reusable cURL function
                        $response = executeCurlRequest($api_url . "/report/generate_report_list_whatsapp", "GET", $replace_txt);

                        // After got response decode the JSON result
                        if (empty($response)) {
                                // Redirect to index.php if response is empty
                                header("Location: index");
                                exit(); // Stop further execution after redirect
                        }

                        // After got response decode the JSON result
                        $sms = json_decode($response, false);
                        // To get the one by one data
                        $indicatori = 0;
                        if ($sms->num_of_rows > 0) { // If the response is success to execute this condition
                                for ($indicator = 0; $indicator < $sms->num_of_rows; $indicator++) {
                                        //Looping the indicator is less than the num_of_rows.if the condition is true to continue the process.if the condition is false to stop the process
                                        $indicatori++;
                                        $rcs_entry_date = date('d-m-Y h:i:s A', strtotime($sms->report[$indicator]->compose_entry_date));
                                        ?>
        <tr>
            <td>
                <?= $indicatori ?>
            </td>
            <td>
                <?= $sms->report[$indicator]->user_name ?>
            </td>
            <td style="text-align: center;">
                <?= $sms->report[$indicator]->campaign_name ?>
            </td>
            <td style="text-align: center;">
                <?= $sms->report[$indicator]->unique_compose_id ?>
            </td>
            <td style="text-align: center;">
                <?= $sms->report[$indicator]->total_mobile_no_count ?>
            </td>
            <td style="text-align: center;">
                <?php
                                                        switch ($sms->report[$indicator]->ucp_status) {
                                                                case 'O':
                                                                        echo '<a href="#!" class="btn btn-outline-success btn-disabled">Completed</a>';
                                                                        break;

                                                                default:
                                                                        echo '<a href="#!" class="btn btn-outline-success btn-disabled">Completed</a>';
                                                                        break;
                                                        }
                                                        ?>
            </td>
            <td style="text-align: center;">
                <?= $rcs_entry_date ?>
            </td>
            <td style="text-align:center;" id='id_approved_lineno_<?= $indicatori ?>'>

                <div class="btn-group mb-3" role="group" aria-label="Basic example">
                    <button type="button" title="Generate Report"
                        onclick="approve_popup('<?= $sms->report[$indicator]->compose_ucp_id ?>', '<?= $sms->report[$indicator]->user_id ?>')"
                        class="btn btn-icon btn-success"
                        style="width: 130px; height: 40px; padding: 0; border-radius: 0; display: flex; align-items: center; justify-content: center;">
                        Generate Report
                    </button>


                </div>

            </td>

        </tr>
        <?
                                }
                        } else if ($sms->response_status == 403) {
                                ?>
        <script>
        window.location = "index"
        </script>
        <?
                        } else if ($sms->response_status == 204) {
                                $json = array("status" => 2, "msg" => $sms->response_msg);
                        } else {
                                $json = array("status" => 0, "msg" => $sms->response_msg);
                        }
                        ?>
    </tbody>
</table>

<!-- General JS Scripts -->
<script src="libraries/assets/js/jquery.dataTables.min-1.js"></script>
<script src="libraries/assets/js/dataTables.buttons.min-1.js"></script>
<script src="libraries/assets/js/dataTables.searchPanes.min-1.js"></script>
<script src="libraries/assets/js/dataTables.select.min-1.js"></script>
<script src="libraries/assets/js/jszip.min-3.js"></script>
<script src="libraries/assets/js/pdfmake.min-3.js"></script>
<script src="libraries/assets/js/vfs_fonts-3.js"></script>
<script src="libraries/assets/js/buttons.html5.min-3.js"></script>
<script src="libraries/assets/js/buttons.colVis.min-3.js"></script>
<!-- filter using -->
<script>
$('#table-1').DataTable({
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'copyHtml5',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        {
            extend: 'csvHtml5',
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'pdfHtml5',
            exportOptions: {
                columns: ':visible' // Ensure all visible columns are exported
            },
            customize: function(doc) {
                doc.pageSize = 'A3'; // Large page size
                doc.pageOrientation = 'landscape'; // Wide layout
            }
        },
        'colvis' // Column visibility toggle
    ]
});

</script>
<?
}
// generate_report_list_whatsapp Page generate_report_list_whatsapp - End

// details_report_whatsapp Page details_report_whatsapp - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $call_function == "details_report_whatsapp") {
        site_log_generate("Business Details Report Page : User : " . $_SESSION['smpp_user_name'] . " Preview on " . date("Y-m-d H:i:s"), '../');
        // Here we can Copy, Export CSV, Excel, PDF, Search, Column visibility the Table 
        ?>
<form name="myform" id="myForm" method="post" action="message_credit">
    <input type="hidden" name="bar" id="bar" value="" />
</form>
<table class="table table-nomargin" id="table-1">
    <thead>
        <tr>
            <th>#</th>
            <th>User</th>
            <th>Campaign Name</th>
            <th>Unique Campose Id</th>
            <th>Total Mobile No</th>
            <th>Entry Date</th>
            <th>Download</th>
        </tr>
    </thead>
    <tbody>
        <?
                        $replace_txt = '{
        "user_id" : "' . $_SESSION['smpp_user_id'] . '",';

                        if (($_REQUEST['dates'] != 'undefined') && ($_REQUEST['dates'] != '[object HTMLInputElement]')) {
                                $date = $_REQUEST['dates'];
                                $td = explode('-', $date);
                                $thismonth_startdate = date("Y/m/d", strtotime($td[0]));
                                $thismonth_today = date("Y/m/d", strtotime($td[1]));
                                if ($date) {
                                        $replace_txt .= '"response_date_filter" : "' . $thismonth_startdate . ' - ' . $thismonth_today . '",';
                                }
                        } else {
                                $currentDate = date('Y/m/d');
                                $thirtyDaysAgo = date('Y/m/d', strtotime('-7 days', strtotime($currentDate)));
                                $date = $thirtyDaysAgo . "-" . $currentDate; // 01/28/2023 - 02/27/2023 
                                if ($date) {
                                        $replace_txt .= '"response_date_filter" : "' . $thirtyDaysAgo . ' - ' . $currentDate . '",';
                                }
                        }
                        $replace_txt = rtrim($replace_txt, ",");
                        $replace_txt .= '}';
                        // Log the service execution with the request payload
                        site_log_generate("Manage Users Page: $uname sent request to " . $api_url . "/report/details_report_whatsapp with method [POST] and payload [$replace_txt] on " . date("Y-m-d H:i:s"), "../");

                        // Call the reusable cURL function
                        $response = executeCurlRequest($api_url . "/report/details_report_whatsapp", "POST", $replace_txt);

                        site_log_generate("Template List Page : " . $_SESSION['smpp_user_name'] . " get the Service response [$response] on " . date("Y-m-d H:i:s"), '../');
                        // After got response decode the JSON result
                        if (empty($response)) {
                                // Redirect to index.php if response is empty
                                header("Location: index");
                                exit(); // Stop further execution after redirect
                        }

                        // After got response decode the JSON result
                        $sms = json_decode($response, false);
                        // To get the one by one data
                        $indicatori = 0;
                        if ($sms->num_of_rows > 0) {
                                for ($indicator = 0; $indicator < $sms->num_of_rows; $indicator++) {
                                        $indicatori++;
                                        $compose_entry_date = date('d-m-Y h:i:s A', strtotime($sms->report[$indicator]->compose_entry_date));
                                        ?>
        <tr>
            <td><?= $indicatori ?></td>
            <td><?= $sms->report[$indicator]->user_name ?></td>
            <td style="text-align: center;"><?= $sms->report[$indicator]->campaign_name ?></td>
            <td style="text-align: center;"><?= $sms->report[$indicator]->unique_compose_id ?></td>
            <td style="text-align: center;"><?= $sms->report[$indicator]->total_mobile_no_count ?></td>
            <td style="text-align: center;"><?= $compose_entry_date ?></td>
            <td style="text-align:center;" id='id_approved_lineno_<?= $indicatori ?>'>
                <div class="btn-group mb-3" role="group" aria-label="Basic example">
                    <button type="button" title="Download"
                        onclick="approve_popup('<?= $sms->report[$indicator]->campaign_name ?>')"
                        class="btn btn-icon btn-success"
                        style="width: 40px; height: 40px; border-radius: 0; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-download"></i>
                    </button>

                </div>
            </td>
        </tr>
        <?php
                                }
                        } else if ($sms->response_status == 403) {
                                ?>
        <script>
        window.location = "index"
        </script>
        <?
                        } else if ($sms->response_status == 204) {
                                $json = array("status" => 2, "msg" => $sms->response_msg);
                        } else {
                                $json = array("status" => 0, "msg" => $sms->response_msg);
                        }
                        ?>
    </tbody>
</table>

<!-- filter using -->
<script src="libraries/assets/js/jquery.dataTables.min-1.js"></script>
<script src="libraries/assets/js/dataTables.buttons.min-1.js"></script>
<script src="libraries/assets/js/dataTables.searchPanes.min-1.js"></script>
<script src="libraries/assets/js/dataTables.select.min-1.js"></script>
<script src="libraries/assets/js/jszip.min-3.js"></script>
<script src="libraries/assets/js/pdfmake.min-3.js"></script>
<script src="libraries/assets/js/vfs_fonts-3.js"></script>
<script src="libraries/assets/js/buttons.html5.min-3.js"></script>
<script src="libraries/assets/js/buttons.colVis.min-3.js"></script>
<!-- filter using -->
<script>
$('#table-1').DataTable({
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'copyHtml5',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        {
            extend: 'csvHtml5',
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'pdfHtml5',
            exportOptions: {
                columns: ':visible' // Ensure all visible columns are exported
            },
            customize: function(doc) {
                doc.pageSize = 'A3'; // Large page size
                doc.pageOrientation = 'landscape'; // Wide layout
            }
        },
        'colvis' // Column visibility toggle
    ]
});

</script>
<?
}
// details_report_whatsapp Page details_report_whatsapp - End




// Contact Group Page Contact Group - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $call_function == "contact_group_list") {
        site_log_generate("Contact Group Page : User : " . $_SESSION['smpp_user_name'] . " Preview on " . date("Y-m-d H:i:s"), '../');
        // Here we can Copy, Export CSV, Excel, PDF, Search, Column visibility the Table            ?>
<form name="myform" id="myForm" method="post" action="message_credit">
    <input type="hidden" name="bar" id="bar" value="" />
</form>
<table class="table table-nomargin text-center" id="table-1">
    <thead>
        <tr class="text-center">
            <th>#</th>
            <th>Contact Group Title</th>
            <th>Total Contacts</th>
            <th>Contact Group Description</th>
            <th>Status</th>
            <th>Entry Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody style=" text-align: center;">
        <?
                        // To Send the request API
                        $replace_txt = '{
            "user_id" : "' . $_SESSION['smpp_user_id'] . '"
               }';
                // Call the reusable cURL function
                        $response = executeCurlRequest($api_url . "/contacts/group_list", "GET", $replace_txt);
                        // After got response decode the JSON result
                        if (empty($response)) {
                                // Redirect to index.php if response is empty
                                header("Location: index");
                                exit(); // Stop further execution after redirect
                        }
                        // After got response decode the JSON result
                        $sms = json_decode($response, false);
                        $indicatori = 0;

                        if ($sms->num_of_rows > 0) {
                                // If the response is success to execute this condition
                                for ($indicator = 0; $indicator < $sms->num_of_rows; $indicator++) {
                                        // Looping the indicator is less than the num_of_rows.if the condition is true to continue the process.if the condition is false to stop the process
                                        $indicatori++;
                                        ?>
        <tr>
            <td>
                <?= $indicatori ?>
            </td>
            <td>
                <?= $sms->reports[$indicator]->contact_group_title; ?>
            </td>
            <td>
                <?= $sms->reports[$indicator]->cnt_contno; ?>
            </td>
            <td>
                <?= $sms->reports[$indicator]->contact_group_desc; ?>
            </td>
            <td>
                <? if ($sms->reports[$indicator]->contact_group_status == 'Y') { ?><a href="#!"
                    class="btn btn-outline-success btn-disabled" style="width:90px; text-align:center">Active</a>
                <? }  elseif ($sms->reports[$indicator]->contact_group_status == 'N') { ?><a href="#!"
                    class="btn btn-outline-danger btn-disabled" style="width:90px; text-align:center">In Active</a>
                <? }?>

            </td>
            <td>
                <?= date('d-m-Y h:i:s A', strtotime($sms->reports[$indicator]->contact_group_date)); ?>
            </td>
            <td>
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <div>
                            <a href="create_group?action=edit&grp_id=<?= $sms->reports[$indicator]->contact_mgtgrp_id ?>"
                                class="dropdown-item">Edit Group</a>
                        </div>
                        <div class="dropdown-divider"></div>
                    </div>
                </div>
            </td>
        </tr>
        <?
                                }
                        } else if ($sms->response_status == 403) { ?>
        <script>
        window.location = "index"
        </script>
        <? } else if ($sms->response_status == 204) {
                                $json = array("status" => 2, "msg" => $sms->response_msg);
                        } else {
                                $json = array("status" => 0, "msg" => $sms->response_msg);
                        }
                        ?>
    </tbody>
</table>
<!-- General Datatable JS Scripts -->
<!-- General JS Scripts -->
<script src="libraries/assets/js/jquery.dataTables.min-1.js"></script>
<script src="libraries/assets/js/dataTables.buttons.min-1.js"></script>
<script src="libraries/assets/js/dataTables.searchPanes.min-1.js"></script>
<script src="libraries/assets/js/dataTables.select.min-1.js"></script>
<script src="libraries/assets/js/jszip.min-3.js"></script>
<script src="libraries/assets/js/pdfmake.min-3.js"></script>
<script src="libraries/assets/js/vfs_fonts-3.js"></script>
<script src="libraries/assets/js/buttons.html5.min-3.js"></script>
<script src="libraries/assets/js/buttons.colVis.min-3.js"></script>
<script>
$('#table-1').DataTable({
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'copyHtml5',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        {
            extend: 'csvHtml5',
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'pdfHtml5',
            exportOptions: {
                columns: ':visible' // Ensure all visible columns are exported
            },
            customize: function(doc) {
                doc.pageSize = 'A3'; // Large page size
                doc.pageOrientation = 'landscape'; // Wide layout
            }
        },
        'colvis' // Column visibility toggle
    ]
});

</script>
<?
}
// Contact Group Page Contact Group - End

// Contact Group Page Contact Group - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $call_function == "contact_list") {
        site_log_generate("Contact Group Page : User : " . $_SESSION['smpp_user_name'] . " Preview on " . date("Y-m-d H:i:s"), '../');
        // Here we can Copy, Export CSV, Excel, PDF, Search, Column visibility the Table            ?>
<form name="myform" id="myForm" method="post" action="message_credit">
    <input type="hidden" name="bar" id="bar" value="" />
</form>
<table class="table table-nomargin text-center" id="table-1">
    <thead>
        <tr class="text-center">
            <th>#</th>
            <th>Contact Name</th>
            <th>Contacts Number</th>
            <th>Email ID</th>
            <th>Group </th>
            <th>Operater</th>
            <th>Status</th>
            <th>Entry Time</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody style=" text-align: center;">
        <?
                        // To Send the request API
                        $replace_txt = '{
            "user_id" : "' . $_SESSION['smpp_user_id'] . '"
               }';
                // Call the reusable cURL function
                        $response = executeCurlRequest($api_url . "/contacts/contact_list", "GET", $replace_txt);
                        // After got response decode the JSON result
                        if (empty($response)) {
                                // Redirect to index.php if response is empty
                                header("Location: index");
                                exit(); // Stop further execution after redirect
                        }
                        // After got response decode the JSON result
                        $sms = json_decode($response, false);
                        $indicatori = 0;

                        if ($sms->num_of_rows > 0) {
                                // If the response is success to execute this condition
                                for ($indicator = 0; $indicator < $sms->num_of_rows; $indicator++) {
                                        // Looping the indicator is less than the num_of_rows.if the condition is true to continue the process.if the condition is false to stop the process
                                        $indicatori++;
                                        ?> <tr>
            <td>
                <?= $indicatori ?>
            </td>
            <td>
                <?= $sms->reports[$indicator]->contact_name; ?>
            </td>
            <td>
                <?= $sms->reports[$indicator]->contact_no; ?>
            </td>
            <td>
                <?= $sms->reports[$indicator]->contact_email; ?>
            </td>
            <td>
                <?= $sms->reports[$indicator]->contact_group_title; ?>
            </td>
            <td>
                <?= $sms->reports[$indicator]->contact_operator; ?>
            </td>
            <td>
                <? if ($sms->reports[$indicator]->contact_group_status == 'Y') { ?><a href="#!"
                    class="btn btn-outline-success btn-disabled" style="width:90px; text-align:center">Active</a>
                <? }  elseif ($sms->reports[$indicator]->contact_group_status == 'N') { ?><a href="#!"
                    class="btn btn-outline-danger btn-disabled" style="width:90px; text-align:center">In Active</a>
                <? }?>

            </td>
            <td>
                <?= date('d-m-Y h:i:s A', strtotime($sms->reports[$indicator]->contact_date)); ?>
            </td>
            <td>
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <div>
                            <a href="create_contact?action=edit&contact_id=<?= $sms->reports[$indicator]->contact_mgt_id ?>"
                                class="dropdown-item">Edit Contacts</a>
                        </div>
                        <div class="dropdown-divider"></div>
                    </div>
                </div>
            </td>
        </tr>
        <?
                                }
                        } else if ($sms->response_status == 403) { ?>
        <script>
        window.location = "index"
        </script>
        <? } else if ($sms->response_status == 204) {
                                $json = array("status" => 2, "msg" => $sms->response_msg);
                        } else {
                                $json = array("status" => 0, "msg" => $sms->response_msg);
                        }
                        ?>
    </tbody>
</table>
<!-- General Datatable JS Scripts -->
<!-- General JS Scripts -->
<script src="libraries/assets/js/jquery.dataTables.min-1.js"></script>
<script src="libraries/assets/js/dataTables.buttons.min-1.js"></script>
<script src="libraries/assets/js/dataTables.searchPanes.min-1.js"></script>
<script src="libraries/assets/js/dataTables.select.min-1.js"></script>
<script src="libraries/assets/js/jszip.min-3.js"></script>
<script src="libraries/assets/js/pdfmake.min-3.js"></script>
<script src="libraries/assets/js/vfs_fonts-3.js"></script>
<script src="libraries/assets/js/buttons.html5.min-3.js"></script>
<script src="libraries/assets/js/buttons.colVis.min-3.js"></script>
<!-- filter using -->
<script>
$('#table-1').DataTable({
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'copyHtml5',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        {
            extend: 'csvHtml5',
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'pdfHtml5',
            exportOptions: {
                columns: ':visible' // Ensure all visible columns are exported
            },
            customize: function(doc) {
                doc.pageSize = 'A3'; // Large page size
                doc.pageOrientation = 'landscape'; // Wide layout
            }
        },
        'colvis' // Column visibility toggle
    ]
});

</script>
<?
}
// Contact Group Page Contact Group - End

if ($_SERVER["REQUEST_METHOD"] == "POST" && $call_function == "new_consent_template") {
    // Get data from the request
    $t_cm_sender_id = isset($_REQUEST["t_cm_sender_id"]) ? htmlspecialchars(strip_tags(strtolower($_REQUEST["t_cm_sender_id"]))) : "";
    $values = explode('||', $t_cm_sender_id);

     $replace_txt = '{ "cm_consent_id" : "'.$values[2].'" }';
  
        // Call the reusable cURL function
  $response = executeCurlRequest($api_url . "/list/consenttmpl_new", "POST", $replace_txt);
  if (empty($response)) {
  // Redirect to index.php if response is empty
  header("Location: index");
  exit(); // Stop further execution after redirect
  }
  // Decode JSON response
  $sql_routmast2 = json_decode($response);
  
  // Check if the response contains 'result' and if there are any rows
  if (isset($sql_routmast2->result) && count($sql_routmast2->result) > 0) {
  foreach ($sql_routmast2->result as $record) {
  // Display consent template name or placeholder if null
  $templateName = $record->cm_consent_tmplname ?? 'Unnamed Template';
  
  // Render the option with the selected attribute if it matches
  echo "  <select name='t_cm_consent_id' id='t_cm_consent_id' tabindex='8'class='form-control form-control-primary required' title='User Type'style='height:40px;'><option value=\"{$record->cm_consent_id}\" selected>{$templateName}</option>";
  }
  echo " </select>";
  } else {
  echo "<option value=\"\">No templates available</option>";
  }
  
  }


if ($_SERVER["REQUEST_METHOD"] == "POST" && $call_function == "slt_language_id") {
    // Get data from the request
    $t_cm_sender_id = isset($_REQUEST["t_cm_sender_id"]) ? htmlspecialchars(strip_tags(strtolower($_REQUEST["t_cm_sender_id"]))) : "";
    $values = explode('||', $t_cm_sender_id);
if($values[1]){
     $replace_txt = '{ "language_id" : "'.$values[1].'" }';
     $response = executeCurlRequest($api_url . "/list/master_language", "GET", $replace_txt);
     if (empty($response)) {
     header("Location: index");
     exit();
     }
     // Decode JSON response
     $sql_routmast2 = json_decode($response);
     
     // Check if the response contains 'result' and if there are any rows
     if (isset($sql_routmast2->report) && count($sql_routmast2->report) > 0) {
     foreach ($sql_routmast2->report as $record) {
     // Display consent template name or placeholder if null
     $language_name = $record->language_name ?? 'Unnamed Template';
  // Render the option with the selected attribute if it matches
  echo "  <select name='language_id' id='language_id' tabindex='8'class='form-control form-control-primary required' title='Select Languages' style='height:40px;'><option value=\"{$record->language_id}\" selected>{$language_name}</option>";
  echo " </select>";

     }

    }  

  } else {
    echo "<option value=\"\">No languages is available</option>";
  }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && $call_function == "exist_consent_template") {
    // Get data from the request
    $t_cm_sender_id = isset($_REQUEST["t_cm_sender_id"]) ? htmlspecialchars(strip_tags(strtolower($_REQUEST["t_cm_sender_id"]))) : "";
    $values = explode('||', $t_cm_sender_id);

     $replace_txt = '{ "cm_consent_id" : "'.$values[2].'" }';
  
        // Call the reusable cURL function
  $response = executeCurlRequest($api_url . "/list/consenttmpl_exists", "POST", $replace_txt);
  if (empty($response)) {
  // Redirect to index.php if response is empty
  header("Location: index");
  exit(); // Stop further execution after redirect
  }
  // Decode JSON response
  $sql_routmast2 = json_decode($response);
  
  // Check if the response contains 'result' and if there are any rows
  if (isset($sql_routmast2->result) && count($sql_routmast2->result) > 0) {
  foreach ($sql_routmast2->result as $record) {
  // Display consent template name or placeholder if null
  $templateName = $record->cm_consent_tmplname ?? 'Unnamed Template';
  
  // Render the option with the selected attribute if it matches
  echo "  <select name='t_cm_consent_id' id='t_cm_consent_id' tabindex='8'class='form-control form-control-primary required' title='User Type'style='height:40px;'><option value=\"{$record->cm_consent_id}\" selected>{$templateName}</option>";
  }
  echo " </select>";
  } else {
  echo "<option value=\"\">No templates available</option>";
  }
  
  }


// plans_list Page plans_list - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $call_function == "plans_list") {
        site_log_generate("Contact Group Page : User : " . $_SESSION['smpp_user_name'] . " Preview on " . date("Y-m-d H:i:s"), '../');
        // Here we can Copy, Export CSV, Excel, PDF, Search, Column visibility the Table            ?>
<form name="myform" id="myForm" method="post" action="message_credit">
    <input type="hidden" name="bar" id="bar" value="" />
</form>
<table class="table table-nomargin text-center" id="table-1">
    <thead>
        <tr class="text-center">
            <th>#</th>
            <th>Plan Name</th>
            <th>Product Name</th>
            <th>Price From - Price To </th>
            <th>Price Per Message </th>
            <th>Plan Status</th>
            <th>Entry Time</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody style=" text-align: center;">
        <?
                        // To Send the request API
                        $replace_txt = '{
            "user_id" : "' . $_SESSION['smpp_user_id'] . '"
               }';
                // Call the reusable cURL function
                        $response = executeCurlRequest($api_url . "/purchase_credit/pricing_slot", "GET", $replace_txt);
                        // After got response decode the JSON result
                        if (empty($response)) {
                                // Redirect to index.php if response is empty
                                header("Location: index");
                                exit(); // Stop further execution after redirect
                        }
                        // After got response decode the JSON result
                        $sms = json_decode($response, false);
                        $indicatori = 0;

                        if ($sms->num_of_rows > 0) {
                                // If the response is success to execute this condition
                                for ($indicator = 0; $indicator < $sms->num_of_rows; $indicator++) {
                                        // Looping the indicator is less than the num_of_rows.if the condition is true to continue the process.if the condition is false to stop the process
                                        $indicatori++;
                                        ?> <tr>
            <td>
                <?= $indicatori ?>
            </td>
            <td>
                <?= $sms->pricing_slot[$indicator]->plan_name; ?>
            </td>
            <td>
                <?= $sms->pricing_slot[$indicator]->rights_name; ?>
            </td>
            <td>
                <?= $sms->pricing_slot[$indicator]->price_from . "-" .  $sms->pricing_slot[$indicator]->price_to;?>
            </td>
            <td>
                <?= $sms->pricing_slot[$indicator]->price_per_message; ?>
            </td>
            <td>
                <? if ($sms->pricing_slot[$indicator]->pricing_slot_status == 'Y') { ?><a href="#!"
                    class="btn btn-outline-success btn-disabled" style="width:90px; text-align:center">Active</a>
                <? }  elseif ($sms->pricing_slot[$indicator]->pricing_slot_status == 'N') { ?><a href="#!"
                    class="btn btn-outline-danger btn-disabled" style="width:90px; text-align:center">In Active</a>
                <? }?>

            </td>
            <td>
                <?= date('d-m-Y h:i:s A', strtotime($sms->pricing_slot[$indicator]->pricing_slot_date)); ?>
            </td>
            <td>
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <div>
                            <a href="plan_create?action=edit&plan_id=<?= $sms->pricing_slot[$indicator]->pricing_slot_id ?>"
                                class="dropdown-item">Edit Plans</a>
                        </div>
                        <div class="dropdown-divider"></div>
                    </div>
                </div>
            </td>
        </tr>
        <?
                                }
                        } else if ($sms->response_status == 403) { ?>
        <script>
        window.location = "index"
        </script>
        <? } else if ($sms->response_status == 204) {
                                $json = array("status" => 2, "msg" => $sms->response_msg);
                        } else {
                                $json = array("status" => 0, "msg" => $sms->response_msg);
                        }
                        ?>
    </tbody>
</table>
<!-- General Datatable JS Scripts -->
<!-- General JS Scripts -->
<script src="libraries/assets/js/jquery.dataTables.min-1.js"></script>
<script src="libraries/assets/js/dataTables.buttons.min-1.js"></script>
<script src="libraries/assets/js/dataTables.searchPanes.min-1.js"></script>
<script src="libraries/assets/js/dataTables.select.min-1.js"></script>
<script src="libraries/assets/js/jszip.min-3.js"></script>
<script src="libraries/assets/js/pdfmake.min-3.js"></script>
<script src="libraries/assets/js/vfs_fonts-3.js"></script>
<script src="libraries/assets/js/buttons.html5.min-3.js"></script>
<script src="libraries/assets/js/buttons.colVis.min-3.js"></script>
<script>
$('#table-1').DataTable({
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'copyHtml5',
            exportOptions: {
                columns: [0, ':visible']
            }
        },
        {
            extend: 'csvHtml5',
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'pdfHtml5',
            exportOptions: {
                columns: ':visible' // Ensure all visible columns are exported
            },
            customize: function(doc) {
                doc.pageSize = 'A3'; // Large page size
                doc.pageOrientation = 'landscape'; // Wide layout
            }
        },
        'colvis' // Column visibility toggle
    ]
});

</script>
<?
}
//plans_list - End

// Finally Close all Opened Mysql DB Connection
$conn->close();

// Output header with HTML Response
header('Content-type: text/html');
echo $result_value;
ob_end_flush();
?>
