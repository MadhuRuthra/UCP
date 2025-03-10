<?php
session_start();
error_reporting(0);
// Include configuration.php
include_once('api/configuration.php');
extract($_REQUEST);

$current_date = date("Y-m-d H:i:s"); // To get currentdate function
$bearer_token = 'Authorization: ' . $_SESSION['yjucp_bearer_token'] . ''; // To get bearertoken

// Step 1: Get the current date
$todayDate = new DateTime();

// Step 2: Convert the date to Julian date
$baseDate = new DateTime($todayDate->format('Y-01-01'));
$julianDate = $todayDate->diff($baseDate)->format('%a') + 1; // Adding 1 since the day of the year starts from 0
$year = date("Y");
$julian_dates = str_pad($julianDate, 3, '0', STR_PAD_LEFT);
$hour_minutes_seconds = date("His");
$random_generate_three = rand(100, 999);
if ($_SESSION["yjucp_user_master_id"] == '1') {
        // To Send the request API 
        $replace_txt = '{
  "user_id" : "' . $_SESSION['yjucp_user_id'] . '"
}';
        // Add bearer token
        $bearer_token = 'Authorization: ' . $_SESSION['yjucp_bearer_token'] . '';
        // It will call "approve_payment" API to verify, can we can we allow to view the message credit list
        $curl = curl_init();
        curl_setopt_array(
                $curl,
                array(
                        CURLOPT_URL => $api_url . '/list/waiting_approval_list',
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

        if ($sms->response_status == 403 || $response == '') { ?>
                <script>
                        window.location = "index"
                </script>
        <? }

}
$waiting_payment = $sms->waiting_payment ? $sms->waiting_payment : 0;
$waiting_compose = $sms->waiting_compose ? $sms->waiting_compose : 0;
$waiting_compose_smpp = $sms->waiting_compose_smpp ? $sms->waiting_compose_smpp : 0;
$waiting_users = $sms->waiting_users ? $sms->waiting_users : 0;
$waiting_dlt_res = $sms->waiting_dlt_res ? $sms->waiting_dlt_res : 0;

$waiting_wtsp_senderid = $sms->waiting_wtsp_senderid ? $sms->waiting_wtsp_senderid : 0;
$waiting_wtsp_template = $sms->waiting_wtsp_template ? $sms->waiting_wtsp_template : 0;
$waiting_whatsapp_compose = $sms->waiting_whatsapp_compose ? $sms->waiting_whatsapp_compose : 0;

if ($_SESSION['yjucp_user_id'] == "") { ?>
        <script>
                window.location = "index";
        </script>
        <?php exit();
}
site_log_generate("Index Page : Unknown User : '" . $_SESSION['yjucp_user_id'] . "' access this page on " . date("Y-m-d H:i:s"));
?>

<nav class="pcoded-navbar">
        <div class="nav-list">
                <div class="pcoded-inner-navbar main-menu">
                        <!-- <div class="pcoded-navigation-label">Navigation</div> -->
                        <ul class="pcoded-item pcoded-left-item">
                                <li class="pcoded-hasmenu">
                                        <a href="dashboard" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                                                <span class="pcoded-mtext">Dashboard</span>
                                        </a>
                                        <ul class="pcoded-submenu">

                                        </ul>
                                </li>

                        </ul>


                        <!-- <div class="pcoded-navigation-label">SMS</div> -->
                        <ul class="pcoded-item pcoded-left-item">
                        <? if( $_SESSION['yjucp_user_master_id'] == '1' ||  $_SESSION['yjucp_user_master_id'] == '2'){ ?>
                                        <li class="pcoded-hasmenu">
                                                <a href="javascript:void(0)" class="waves-effect waves-dark">
                                                        <span class="pcoded-micon">
                                                                <i class="feather icon-shopping-cart"></i>
                                                        </span>
                                                        <span class="pcoded-mtext">Admin</span>
                                                        <? if ($waiting_payment > 0) { ?><span class="badge badge-success"
                                                                        style="width: auto; min-width:30px; font-weight: bold; margin-left: 50px; margin-right: 20px; line-height: 20px;">
                                                                        <?= $waiting_payment ?>
                                                                </span>
                                                        <? } ?>
                                                </a>
                                                <ul class="pcoded-submenu">
                                                <? if($_SESSION['smpp_user_id'] == '1'){ ?>
                                                        <li class=" ">
                                                                <a href="approve_payment" class="waves-effect waves-dark">
                                                                        <span class="pcoded-mtext">Approve Payment</span>
                                                                        <? if ($waiting_payment > 0) { ?><span
                                                                                        class="badge badge-success"
                                                                                        style="width: auto; min-width:30px; font-weight: bold; margin-left: 10px; margin-right: 20px; line-height: 20px;">
                                                                                        <?= $waiting_payment ?>
                                                                                </span>
                                                                        <? } ?>
                                                                </a>

                                                        </li>
                                                        <? } ?>
                                                        <li class="">
                                                                <a href="message_credit_list" class="waves-effect waves-dark">
                                                                        <span class="pcoded-mtext">Message Credit List</span>
                                                                </a>
                                                        </li>
                                                        <li class="">
                                                                <a href="message_credit" class="waves-effect waves-dark">
                                                                        <span class="pcoded-mtext">Message Credit</span>
                                                                </a>
                                                        </li>
                                                        <li class="">
                                                                <a href="manage_users" class="waves-effect waves-dark">
                                                                        <span class="pcoded-mtext">Manage Users</span>
                                                                </a>
                                                        </li>
                                                        <li class="">
                                                                <a href="manage_users_list" class="waves-effect waves-dark">
                                                                        <span class="pcoded-mtext">Manage Users List</span>
                                                                </a>
                                                        </li>
                                                        <li class="">
                                                                <a href="plan_create" class="waves-effect waves-dark">
                                                                        <span class="pcoded-mtext">Plan Create</span>
                                                                </a>
                                                        </li>
                                                        <li class="">
                                                                <a href="plans_list" class="waves-effect waves-dark">
                                                                        <span class="pcoded-mtext">Plans List</span>
                                                                </a>
                                                        </li>
                                                </ul>
                                        </li>

                                <? }
                                if ($_SESSION['yjucp_user_master_id'] != '1') { ?>

                                        <li class="pcoded-hasmenu">
                                                <a href="javascript:void(0)" class="waves-effect waves-dark">
                                                        <span class="pcoded-micon">
                                                                <i class="feather icon-clipboard"></i>
                                                        </span>
                                                        <span class="pcoded-mtext">Purchase Credits</span>
                                                </a>
                                                <ul class="pcoded-submenu">
                                                        <li class=" ">
                                                                <a href="purchase_message_credit"
                                                                        class="waves-effect waves-dark">
                                                                        <span class="pcoded-mtext">Purchase SMS Credit</span>
                                                                </a>
                                                        </li>
                                                        <li class="">
                                                                <a href="purchase_message_list" class="waves-effect waves-dark">
                                                                        <span class="pcoded-mtext">Purchase SMS Credit
                                                                                List</span>
                                                                </a>
                                                        </li>
                                                </ul>
                                        </li>
                                <? } ?>

                                    <!--Contacts Start -->
                                    <li class="pcoded-hasmenu">
                                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                                                <span class="pcoded-micon">
                                                        <i class="feather icon-message-circle"></i>
                                                </span>
                                                <span class="pcoded-mtext">Contacts</span></a>
                                        <ul class="pcoded-submenu">
                                                <li class=" ">
                                                        <a href="contacts_list" class="waves-effect waves-dark">
                                                                <span class="pcoded-mtext">Contacts List</span>
                                                        </a>
                                                </li>
                                                <li class="">
                                                        <a href="create_contact" class="waves-effect waves-dark">
                                                                <span class="pcoded-mtext">Contacts</span>
                                                        </a>
                                                </li>
                                                <li class="">
                                                        <a href="group_list" class="waves-effect waves-dark">
                                                                <span class="pcoded-mtext">Group List</span>
                                                        </a>
                                                </li>
                                                <li class="">
                                                        <a href="create_group" class="waves-effect waves-dark">
                                                                <span class="pcoded-mtext">create Group</span>
                                                        </a>
                                                </li>
                                                <li class="">
                                                        <a href="import_contacts" class="waves-effect waves-dark">
                                                                <span class="pcoded-mtext">Import Contacts</span>
                                                        </a>
                                                </li>
                                        </ul>

                                </li>
                                <!-- Contacts End -->

                                <!-- SMS Start -->
                                <li class="pcoded-hasmenu">
                                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                                                <span class="pcoded-micon">
                                                        <i class="feather icon-message-circle"></i>
                                                </span>
                                                <span class="pcoded-mtext">SMS</span>
                                                <? if ($waiting_compose > 0) { ?><span class="badge badge-success"
                                                                style="width: auto; min-width:30px; font-weight: bold; margin-left: 50px; margin-right: 20px; line-height: 20px;">
                                                                <?= $waiting_compose ?>
                                                        </span>
                                                <? } ?>

                                        </a>
                                        <ul class="pcoded-submenu">

                                                <li class=" ">
                                                        <a href="compose_sms" class="waves-effect waves-dark">
                                                                <span class="pcoded-mtext">Compose SMS</span>
                                                                <!-- //Add on -->
                                                        </a>
                                                </li>
                                                <li class="">
                                                        <a href="compose_sms_list" class="waves-effect waves-dark">
                                                                <span class="pcoded-mtext">SMS Campign List</span>
                                                        </a>
                                                </li>

                                                <?php if ($_SESSION['yjucp_user_master_id'] == '1') { ?>
                                                        <li class="">
                                                                <a href="compose_message_approval"
                                                                        class="waves-effect waves-dark">
                                                                        <span class="pcoded-mtext">Approve</span>
                                                                        <?php if ($waiting_compose > 0) { ?>
                                                                                <span class="badge badge-success"
                                                                                        style="width: auto; min-width:30px; font-weight: bold; margin-left: 10px; margin-right: 20px; line-height: 20px;">
                                                                                        <?= $waiting_compose ?>
                                                                                </span>
                                                                        <?php } ?>
                                                                </a>
                                                        </li>
                                                <?php } ?>

                                                <li class=" ">
                                                        <a href="summary_report" class="waves-effect waves-dark">
                                                                <span class="pcoded-mtext">Summary Report</span>
                                                        </a>
                                                </li>
                                                <?php if ($_SESSION['yjucp_user_master_id'] == '1') { ?>
                                                        <li class=" ">
                                                                <a href="generate_report_list" class="waves-effect waves-dark">
                                                                        <span class="pcoded-mtext">Report Generate</span>
                                                                </a>
                                                        </li>
                                                <?php } ?>
                                                <li class=" ">
                                                        <a href="detailed_report" class="waves-effect waves-dark">
                                                                <span class="pcoded-mtext">Detailed Report</span>
                                                        </a>
                                                </li>
                                        </ul>

                                </li>
                                <!-- SMS End -->

                                <!-- SMPP Start -->

                             <?/*   <li class="pcoded-hasmenu" >
                                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                                                <span class="pcoded-micon">
                                                        <i class="feather icon-clipboard"></i>
                                                </span>
                                                <span class="pcoded-mtext">SMPP</span>
                                                <? if ($waiting_compose_smpp > 0) { ?><span class="badge badge-success"
                                                                style="width: auto; min-width:30px; font-weight: bold; margin-left: 50px; margin-right: 20px; line-height: 20px;">
                                                                <?= $waiting_compose_smpp ?>
                                                        </span>
                                                <? } ?>
                                        </a>
                                        <ul class="pcoded-submenu">

                                                <li class=" ">
                                                        <a href="compose_smpp" class="waves-effect waves-dark">
                                                                <span class="pcoded-mtext">Compose SMPP</span>
                                                                <!-- //Add on -->
                                                        </a>
                                                </li>
                                                <li class="">
                                                        <a href="compose_smpp_list" class="waves-effect waves-dark">
                                                                <span class="pcoded-mtext">SMPP Campign List</span>
                                                        </a>
                                                </li>
                                                <?php if ($_SESSION['yjucp_user_master_id'] == '1') { ?>
                                                        <li class="">
                                                                <a href="compose_smpp_approval" class="waves-effect waves-dark">
                                                                        <span class="pcoded-mtext">Approve</span>
                                                                        <? if ($waiting_compose_smpp > 0) { ?><span
                                                                                        class="badge badge-success"
                                                                                        style="width: auto; min-width:30px; font-weight: bold; margin-left: 10px; margin-right: 20px; line-height: 20px;">
                                                                                        <?= $waiting_compose_smpp ?>
                                                                                </span>
                                                                        <? } ?>
                                                                </a>
                                                        </li>
                                                <?php } ?>
                                                <li class=" ">
                                                        <a href="summary_report_smpp" class="waves-effect waves-dark">
                                                                <span class="pcoded-mtext">Summary Report</span>
                                                        </a>
                                                </li>
                                                <?php if ($_SESSION['yjucp_user_master_id'] == '1') { ?>
                                                        <li class=" ">
                                                                <a href="generate_report_list_smpp"
                                                                        class="waves-effect waves-dark">
                                                                        <span class="pcoded-mtext">Report Generate</span>
                                                                </a>
                                                        </li>
                                                <?php } ?>
                                                <li class=" ">
                                                        <a href="detailed_report_smpp" class="waves-effect waves-dark">
                                                                <span class="pcoded-mtext">Detailed Report</span>
                                                        </a>
                                                </li>
                                        </ul>
                                </li>

                                <!-- SMPP End -->

                                <li class="pcoded-hasmenu" >

                                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                                                <span class="pcoded-micon">
                                                        <i class="feather icon-triangle"></i>
                                                </span>
                                                <span class="pcoded-mtext">DLT</span>
                                                <? if ($waiting_dlt_res > 0) { ?><span class="badge badge-success"
                                                                style="width: auto; min-width:30px; font-weight: bold; margin-left: 50px; margin-right: 20px; line-height: 20px;">
                                                                <?= $waiting_dlt_res ?>
                                                        </span>
                                                <? } ?>
                                        </a>
                                        <ul class="pcoded-submenu">
                                                <li class=" ">
                                                        <a href="dlt_new_senderid" class="waves-effect waves-dark">
                                                                <span class="pcoded-mtext">DLT Sender ID - New</span>
                                                        </a>
                                                </li>
                                                <li class=" ">
                                                        <a href="dlt_existing_senderid" class="waves-effect waves-dark">
                                                                <span class="pcoded-mtext">DLT Sender ID -
                                                                        Existing</span>
                                                        </a>
                                                </li>
                                                <li class=" ">
                                                        <a href="content_template_new" class="waves-effect waves-dark">
                                                                <span class="pcoded-mtext">Content Template -
                                                                        New</span>
                                                        </a>
                                                </li>
                                                <li class=" ">
                                                        <a href="content_template_existing"
                                                                class="waves-effect waves-dark">
                                                                <span class="pcoded-mtext">Content Template -
                                                                        Existing</span>
                                                        </a>
                                                </li>
                                                <li class=" ">
                                                        <a href="senderid_list" class="waves-effect waves-dark">
                                                                <span class="pcoded-mtext">DLT List</span>
                                                        </a>
                                                </li>
                                                <?php if ($_SESSION['yjucp_user_master_id'] == '1') { ?>
                                                        <li class=" ">
                                                                <a href="senderid_approval" class="waves-effect waves-dark">
                                                                        <span class="pcoded-mtext">DLT Approval</span>
                                                                        <? if ($waiting_dlt_res > 0) { ?><span
                                                                                        class="badge badge-success"
                                                                                        style="width: auto; min-width:30px; font-weight: bold; margin-left: 10px; margin-right: 20px; line-height: 20px;">
                                                                                        <?= $waiting_dlt_res ?>
                                                                                </span>
                                                                        <? } ?>
                                                                </a>
                                                        </li>
                                                <?php } ?>
                                        </ul>
                                </li>*/?>
                                <!-- MANADE -->
                                <li class="pcoded-hasmenu" >
                                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                                                <span class="pcoded-micon">
                                                        <i class="feather icon-alert-octagon"></i>
                                                </span>
                                                <span class="pcoded-mtext">Manage</span>
                                                <? if (($waiting_wtsp_senderid + $waiting_wtsp_template) > 0) { ?><span class="badge badge-success"
                                                        style="width: auto; min-width:30px; font-weight: bold; margin-left: 75px; margin-right: 20px; line-height: 20px;">
                                                                <?= $waiting_wtsp_senderid + $waiting_wtsp_template ?>
                                                        </span>
                                                <? } ?>
                                        </a>
                                        <ul class="pcoded-submenu">

                                                <li class=" ">
                                                        <a href="manage_sender_id" class="waves-effect waves-dark">
                                                                <span class="pcoded-mtext">Sender Id</span>
                                                                <!-- //Add on -->
                                                        </a>
                                                </li>
                                                <li class="">
                                                        <a href="template_list" class="waves-effect waves-dark">
                                                                <span class="pcoded-mtext">Template List</span>
                                                        </a>
                                                </li>

                                                <?php if ($_SESSION['yjucp_user_master_id'] == '1') { ?>
                                                        <li class="">
                                                                <a href="approve_whatsapp_no_api" class="waves-effect waves-dark">
                                                                        <span class="pcoded-mtext">Approve Senderid<? if ($waiting_wtsp_senderid > 0) { ?><span
                                                                                        class="badge badge-success"
                                                                                        style="width: auto; min-width:30px; font-weight: bold; margin-left: 10px; margin-right: 20px; line-height: 20px;">
                                                                                        <?= $waiting_wtsp_senderid ?>
                                                                                </span>
                                                                        <? } ?></span>
                                                                </a>
                                                        </li>
                                                        <li class="">
                                                                <a href="approve_template" class="waves-effect waves-dark">
                                                                        <span class="pcoded-mtext">Approve Template <? if ($waiting_wtsp_template > 0) { ?><span
                                                                                        class="badge badge-success"
                                                                                        style="width: auto; min-width:30px; font-weight: bold; margin-left: 10px; margin-right: 20px; line-height: 20px;">
                                                                                        <?= $waiting_wtsp_template ?>
                                                                                </span>
                                                                        <? } ?></span>
                                                                </a>
                                                        </li>
                                                <?php } ?>
                                        </ul>
                                </li>
                                <!-- Manage End -->

                                    <!-- MANADE -->
                                    <li class="pcoded-hasmenu" >
                                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                                                <span class="pcoded-micon">
                                                        <i class="feather icon-phone"></i>
                                                </span>
                                                <span class="pcoded-mtext">Whatsapp</span>
                                                <? if (($waiting_whatsapp_compose) > 0) { ?><span class="badge badge-success"
                                                        style="width: auto; min-width:30px; font-weight: bold; margin-left: 75px; margin-right: 20px; line-height: 20px;">
                                                                <?= $waiting_whatsapp_compose ?>
                                                        </span>
                                                <? } ?>
                                        </a>
                                        <ul class="pcoded-submenu">

                                                <li class=" ">
                                                        <a href="compose_whatsapp" class="waves-effect waves-dark">
                                                                <span class="pcoded-mtext">Compose Whatsapp </span>
                                                        </a>
                                                </li>
                                                <li class="">
                                                        <a href="compose_whatsapp_list" class="waves-effect waves-dark">
                                                                <span class="pcoded-mtext">Campaign List</span>
                                                        </a>
                                                </li>

                                                <?php if ($_SESSION['yjucp_user_master_id'] == '1') { ?>
                                                        <li class="">
                                                                <a href="compose_whatsapp_approval" class="waves-effect waves-dark">
                                                                        <span class="pcoded-mtext">Approve <? if ($waiting_whatsapp_compose > 0) { ?><span
                                                                                        class="badge badge-success"
                                                                                        style="width: auto; min-width:30px; font-weight: bold; margin-left: 10px; margin-right: 20px; line-height: 20px;">
                                                                                        <?= $waiting_whatsapp_compose ?>
                                                                                </span>
                                                                        <? } ?></span>
                                                                </a>
                                                        </li>
                                                <?php } ?>
                                                <li class=" ">
                                                        <a href="summary_report_whatsapp" class="waves-effect waves-dark">
                                                                <span class="pcoded-mtext">Summary Report</span>
                                                        </a>
                                                </li>
                                                <?php if ($_SESSION['yjucp_user_master_id'] == '1') { ?>
                                                        <li class=" ">
                                                                <a href="generate_report_list_whatsapp"
                                                                        class="waves-effect waves-dark">
                                                                        <span class="pcoded-mtext">Report Generate</span>
                                                                </a>
                                                        </li>
                                                <?php } ?>
                                                <li class=" ">
                                                        <a href="detailed_report_whatsapp" class="waves-effect waves-dark">
                                                                <span class="pcoded-mtext">Detailed Report</span>
                                                        </a>
                                                </li>
                                                <!---<li class=" ">
                                                        <a href="messenger_responses" class="waves-effect waves-dark">
                                                                <span class="pcoded-mtext">Messenger Response</span>
                                                        </a>
                                                </li>--->

                                        </ul>
                                </li>
                                <!-- Manage End -->
                        </ul>
                </div>
        </div>
</nav>
