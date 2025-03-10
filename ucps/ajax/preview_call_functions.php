<?php
/*
This page has some functions which is access from Frontend.
This page is act as a Backend page which is connect with Node JS API and PHP Frontend.
It will collect the form details and send it to API.
After get the response from API, send it back to Frontend.

Version : 1.0
Author : Madhubala (YJ0009)
Date : 01-Jul-2023
*/
session_start(); //start session
error_reporting(E_ALL); // The error reporting function
include_once('../api/configuration.php'); // Include configuration.php
include_once "../api/send_request.php"; // Include configuration.php
extract($_REQUEST); // Extract the request
$current_date = date("Y-m-d H:i:s"); // To get currentdate function
$milliseconds = round(microtime(true) * 1000);

// Compose Sms Preview Page - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $preview_functions == "preview_compose_sms") {
  $txt_list_mobno = str_replace("\\r\\n", '', $txt_list_mobno);
  $txt_message_content = htmlspecialchars(strip_tags(isset($_REQUEST['textarea']) ? $_REQUEST['textarea'] : ""));
  // To get the one by one data
  $rdo_newex_group = htmlspecialchars(strip_tags(isset($_REQUEST['rdo_newex_group']) ? $_REQUEST['rdo_newex_group'] : ""));
  $file_image_header_url = htmlspecialchars(strip_tags(isset($_REQUEST['file_image_header_url']) ? $_REQUEST['file_image_header_url'] : ""));
  if ($txt_list_mobno != '') {
    // Explode
    $str_arr = explode(",", $txt_list_mobno);
    $entry_contact = '';
    for ($indicatori = 0; $indicatori < count($str_arr); $indicatori++) {
      $entry_contact .= '' . $str_arr[$indicatori] . ',';
    }
    $entry_contact = rtrim($entry_contact, ", ");

  }
  $message_type = '';
  if ($rdo_newex_group == 'N') {
    $message_type = "Same message";
  } else {
    $message_type = "Customized message";
  }

  if ($_FILES["upload_contact"]["name"] != '') {
    $path_parts = pathinfo($_FILES["upload_contact"]["name"]);
    $extension = $path_parts['extension'];
    $filename = $_SESSION['yjucp_user_id'] . "_csv_" . $milliseconds . "." . $extension;
    /* Location */
    $location = "../uploads/group_contact/" . $filename;
    $group_contact = $site_url . "uploads/group_contact/" . $filename;
    $imageFileType = pathinfo($location, PATHINFO_EXTENSION);
    $imageFileType = strtolower($imageFileType);

    /* Valid extensions */
    // $valid_extensions = array("csv");
    $valid_extensions = array("csv", "txt"); // Allow both CSV and TXT files

    $response = 0;
    /* Check file extension */
    // if (in_array(strtolower($imageFileType), $valid_extensions)) {
    //   /* Upload file */
    //   if (move_uploaded_file($_FILES['upload_contact']['tmp_name'], $location)) {
    //     $response = $location;
    //   }
    // }
    if (in_array(strtolower($imageFileType), $valid_extensions)) {
      if (move_uploaded_file($_FILES['upload_contact']['tmp_name'], $location)) {
        $response = $location;
        site_log_generate("File uploaded: " . $location, '../');
      } else {
        site_log_generate("Failed to upload file: " . $_FILES['upload_contact']['name'], '../');
      }
    }

  }


  if ($_FILES["file_image_header"]["name"] != '') {
    /* Location */
    $msg_type = 'IMAGE';

    $image_size = $_FILES['file_image_header']['size'];
    $image_type = $_FILES['file_image_header']['type'];
    $file_type = explode("/", $image_type);

    $filename = $_SESSION['yjucp_user_id'] . "_" . $milliseconds . "." . $file_type[1];
    $location = "../uploads/whatsapp_images/" . $filename;
    $location_1 = $site_url . "uploads/whatsapp_images/" . $filename;
    $imageFileType = pathinfo($location, PATHINFO_EXTENSION);
    $imageFileType = strtolower($imageFileType);
    /* Valid extensions */
    $valid_extensions = array("png", "jpg", "jpeg");

    $rspns = '';
    /* Check file extension */
    // if (in_array(strtolower($imageFileType), $valid_extensions)) {
    /* Upload file */
    if (move_uploaded_file($_FILES['file_image_header']['tmp_name'], $location)) {
      $rspns = $location;
      site_log_generate("Create Template Page : User : " . $_SESSION['yjucp_user_name'] . " whatsapp_images file moved into Folder on " . date("Y-m-d H:i:s"), '../');
    }
  }
  if ($file_image_header_url) {
    $location_1 = $file_image_header_url;
  }

  ?>
<table class="table table-striped table-bordered m-0"
    style="table-layout: fixed; white-space: inherit; width: 100%; overflow-x: scroll;">
    <tbody>
        <? if ($message_type != '') { ?>
        <tr>
            <th scope="row">Message Type</th>
            <td style="white-space: inherit !important;">Generic Message</td>
        </tr>
        <? } ?>
        <? if ($txt_message_content != '') { ?>
        <tr>
            <th scope="row">Message Content</th>
            <td style="white-space: inherit !important;"><?= $txt_message_content ?></td>
        </tr>
        <? } ?>
        <? if ($location_1 != '') { ?>
        <tr>
            <th scope="row">Upload Media</th>
            <td style="white-space: inherit !important;"><a href="<?= $location_1 ?>" target='_blank'>Media Link</a>
            </td>
        </tr>
        <? } ?>
        <? if ($group_contact != '') { ?>
        <tr>
            <th scope="row">Upload Mobile Numbers</th>
            <td style="white-space: inherit !important;"><a href="<?= $group_contact ?>" target='_blank'>Download Mobile
                    Numbers</a></td>
        </tr>
        <? } ?>
    </tbody>
</table>
<?
}

//Compose Sms Preview Page - END


// Compose Smpp Preview Page - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $preview_functions == "preview_compose_smpp") {
  $txt_list_mobno = str_replace("\\r\\n", '', $txt_list_mobno);
  $id_slt_header = htmlspecialchars(strip_tags(isset($_REQUEST['id_slt_header']) ? $_REQUEST['id_slt_header'] : ""));
  $txt_sms_content = htmlspecialchars(strip_tags(isset($_REQUEST['txt_sms_content']) ? $_REQUEST['txt_sms_content'] : ""));
  $txt_sms_type = htmlspecialchars(strip_tags(isset($_REQUEST['txt_sms_type']) ? $_REQUEST['txt_sms_type'] : ""));
  $txt_message_content = htmlspecialchars(strip_tags(isset($_REQUEST['textarea']) ? $_REQUEST['textarea'] : ""));
  // To get the one by one data
  $rdo_newex_group = htmlspecialchars(strip_tags(isset($_REQUEST['rdo_newex_group']) ? $_REQUEST['rdo_newex_group'] : ""));
  $file_image_header_url = htmlspecialchars(strip_tags(isset($_REQUEST['file_image_header_url']) ? $_REQUEST['file_image_header_url'] : ""));
  if ($txt_list_mobno != '') {
    // Explode
    $str_arr = explode(",", $txt_list_mobno);
    $entry_contact = '';
    for ($indicatori = 0; $indicatori < count($str_arr); $indicatori++) {
      $entry_contact .= '' . $str_arr[$indicatori] . ',';
    }
    $entry_contact = rtrim($entry_contact, ", ");

  }
  $message_type = '';
  if ($rdo_newex_group == 'N') {
    $message_type = "Same message";
  } else {
    $message_type = "Customized message";
  }

  if ($_FILES["upload_contact"]["name"] != '') {
    $path_parts = pathinfo($_FILES["upload_contact"]["name"]);
    $extension = $path_parts['extension'];
    $filename = $_SESSION['yjucp_user_id'] . "_csv_" . $milliseconds . "." . $extension;
    /* Location */
    $location = "../uploads/group_contact/" . $filename;
    $group_contact = $site_url . "uploads/group_contact/" . $filename;
    $imageFileType = pathinfo($location, PATHINFO_EXTENSION);
    $imageFileType = strtolower($imageFileType);

    $valid_extensions = array("csv", "txt"); // Allow both CSV and TXT files

    $response = 0;
    if (in_array(strtolower($imageFileType), $valid_extensions)) {
      if (move_uploaded_file($_FILES['upload_contact']['tmp_name'], $location)) {
        $response = $location;
        site_log_generate("File uploaded: " . $location, '../');
      } else {
        site_log_generate("Failed to upload file: " . $_FILES['upload_contact']['name'], '../');
      }
    }

  }


  if ($_FILES["file_image_header"]["name"] != '') {
    /* Location */
    $msg_type = 'IMAGE';

    $image_size = $_FILES['file_image_header']['size'];
    $image_type = $_FILES['file_image_header']['type'];
    $file_type = explode("/", $image_type);

    $filename = $_SESSION['yjucp_user_id'] . "_" . $milliseconds . "." . $file_type[1];
    $location = "../uploads/whatsapp_images/" . $filename;
    $location_1 = $site_url . "uploads/whatsapp_images/" . $filename;
    $imageFileType = pathinfo($location, PATHINFO_EXTENSION);
    $imageFileType = strtolower($imageFileType);
    /* Valid extensions */
    $valid_extensions = array("png", "jpg", "jpeg");

    $rspns = '';
    /* Check file extension */
    // if (in_array(strtolower($imageFileType), $valid_extensions)) {
    /* Upload file */
    if (move_uploaded_file($_FILES['file_image_header']['tmp_name'], $location)) {
      $rspns = $location;
      site_log_generate("Create Template Page : User : " . $_SESSION['yjucp_user_name'] . " whatsapp_images file moved into Folder on " . date("Y-m-d H:i:s"), '../');
    }
  }
  if ($file_image_header_url) {
    $location_1 = $file_image_header_url;
  }

  ?>
<table class="table table-striped table-bordered m-0"
    style="table-layout: fixed; white-space: inherit; width: 100%; overflow-x: scroll;">
    <tbody>
        <? if ($id_slt_header != '') { ?>
        <!-- <tr>
          <th scope="row">Header / Sender ID</th>
          <td style="white-space: inherit !important;"><?= $id_slt_header ?></td>
        </tr> -->
        <? } ?>
        <? if ($txt_sms_content != '') { ?>
        <tr>
            <th scope="row">Message Content</th>
            <td style="white-space: inherit !important;"><?= $txt_sms_content ?></td>
        </tr>
        <? } ?>
        <? if ($txt_sms_type != '') { ?>
        <tr>
            <th scope="row">SMS Type</th>
            <td style="white-space: inherit !important;"><?= $txt_sms_type ?></td>
        </tr>
        <? } ?>
        <? if ($location_1 != '') { ?>
        <tr>
            <th scope="row">Upload Media</th>
            <td style="white-space: inherit !important;"><a href="<?= $location_1 ?>" target='_blank'>Media Link</a>
            </td>
        </tr>
        <? } ?>
        <? if ($group_contact != '') { ?>
        <tr>
            <th scope="row">Upload Mobile Numbers</th>
            <td style="white-space: inherit !important;"><a href="<?= $group_contact ?>" target='_blank'>Download Mobile
                    Numbers</a></td>
        </tr>
        <? } ?>
    </tbody>
</table>
<?
}

//Compose Smpp Preview Page - END


// Compose whatsapp Preview Page - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $preview_functions == "preview_compose_whatsapp") {
  $txt_list_mobno = str_replace("\\r\\n", '', $txt_list_mobno);
  $txt_message_content = htmlspecialchars(strip_tags(isset($_REQUEST['textarea']) ? $_REQUEST['textarea'] : ""));
  // To get the one by one data
  $rdo_newex_group = htmlspecialchars(strip_tags(isset($_REQUEST['rdo_newex_group']) ? $_REQUEST['rdo_newex_group'] : ""));
  $file_image_header_url = htmlspecialchars(strip_tags(isset($_REQUEST['file_image_header_url']) ? $_REQUEST['file_image_header_url'] : ""));
  if ($txt_list_mobno != '') {
    // Explode
    $str_arr = explode(",", $txt_list_mobno);
    $entry_contact = '';
    for ($indicatori = 0; $indicatori < count($str_arr); $indicatori++) {
      $entry_contact .= '' . $str_arr[$indicatori] . ',';
    }
    $entry_contact = rtrim($entry_contact, ", ");

  }
  $message_type = '';
  if ($rdo_newex_group == 'N') {
    $message_type = "Same message";
  } else {
    $message_type = "Customized message";
  }

  if ($_FILES["upload_contact"]["name"] != '') {
    $path_parts = pathinfo($_FILES["upload_contact"]["name"]);
    $extension = $path_parts['extension'];
    $filename = $_SESSION['yjucp_user_id'] . "_csv_" . $milliseconds . "." . $extension;
    /* Location */
    $location = "../uploads/group_contact/" . $filename;
    $group_contact = $site_url . "uploads/group_contact/" . $filename;
    $imageFileType = pathinfo($location, PATHINFO_EXTENSION);
    $imageFileType = strtolower($imageFileType);

    /* Valid extensions */
    $valid_extensions = array("csv");
    $response = 0;
    /* Check file extension */
    if (in_array(strtolower($imageFileType), $valid_extensions)) {
      /* Upload file */
      if (move_uploaded_file($_FILES['upload_contact']['tmp_name'], $location)) {
        $response = $location;
      }
    }
  }


  if ($_FILES["file_image_header"]["name"] != '') {
    /* Location */
    $msg_type = 'IMAGE';

    $image_size = $_FILES['file_image_header']['size'];
    $image_type = $_FILES['file_image_header']['type'];
    $file_type = explode("/", $image_type);

    $filename = $_SESSION['yjucp_user_id'] . "_" . $milliseconds . "." . $file_type[1];
    $location = "../uploads/whatsapp_images/" . $filename;
    $location_1 = $site_url . "uploads/whatsapp_images/" . $filename;
    $imageFileType = pathinfo($location, PATHINFO_EXTENSION);
    $imageFileType = strtolower($imageFileType);
    /* Valid extensions */
    $valid_extensions = array("png", "jpg", "jpeg");

    $rspns = '';
    /* Check file extension */
    // if (in_array(strtolower($imageFileType), $valid_extensions)) {
    /* Upload file */
    if (move_uploaded_file($_FILES['file_image_header']['tmp_name'], $location)) {
      $rspns = $location;
      site_log_generate("Create Template Page : User : " . $_SESSION['yjucp_user_name'] . " whatsapp_images file moved into Folder on " . date("Y-m-d H:i:s"), '../');
    }
  }
  if ($file_image_header_url) {
    $location_1 = $file_image_header_url;
  }

  ?>
<table class="table table-striped table-bordered m-0"
    style="table-layout: fixed; white-space: inherit; width: 100%; overflow-x: scroll;">
    <tbody>
        <? if ($message_type != '') { ?>
        <tr>
            <th scope="row">Message Type</th>
            <td style="white-space: inherit !important;"><?= $message_type ?></td>
        </tr>
        <? } ?>
        <? if ($txt_message_content != '') { ?>
        <tr>
            <th scope="row">Message Content</th>
            <td style="white-space: inherit !important;"><?= $txt_message_content ?></td>
        </tr>
        <? } ?>
        <? if ($location_1 != '') { ?>
        <tr>
            <th scope="row">Upload Media</th>
            <td style="white-space: inherit !important;"><a href="<?= $location_1 ?>" target='_blank'>Media Link</a>
            </td>
        </tr>
        <? } ?>
        <? if ($group_contact != '') { ?>
        <tr>
            <th scope="row">Upload Mobile Numbers</th>
            <td style="white-space: inherit !important;"><a href="<?= $group_contact ?>" target='_blank'>Download Mobile
                    Numbers</a></td>
        </tr>
        <? } ?>
    </tbody>
</table>
<?

}
//Compose Whatsapp Preview Page - END

// Finally Close all Opened Mysql DB Connection
$conn->close();

// Output header with HTML Response
header('Content-type: text/html');
echo $result_value;
