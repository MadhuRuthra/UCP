<?php
session_start();
error_reporting(E_ALL);
// Include configuration.php
include_once('../api/configuration.php');
include_once "../api/send_request.php"; // Include configuration.php
extract($_REQUEST);

$current_date = date("Y-m-d H:i:s");


// compose_sms Page preview_composesms - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $tmpl_prevcall_functions == "preview_composesms") { ?>
    <table class="table table-striped table-bordered m-0"
        style="table-layout: fixed; white-space: inherit; width: 100%; overflow-x: scroll;">
        <tbody>

            <? if ($txt_list_mobno != '') { ?>
                <tr>
                    <th scope="row">Mobile Numbers</th>
                    <td style="white-space: inherit !important;"><?= $txt_list_mobno ?></td>
                </tr>
            <? } ?>
            <? if ($txt_sms_content != '') { ?>
                <tr>
                    <th scope="row">SMS Content</th>
                    <td style="white-space: inherit !important;"><?= $txt_sms_content ?></td>
                </tr>
            <? } ?>
        </tbody>
    </table>
<?
}
// compose_sms Page preview_composesms - End



// message Page preview_senderid_consent - Start -- This is for Sender ID, Consent ID Tempory Display
if ($_SERVER['REQUEST_METHOD'] == "POST" and $tmpl_call_preview_functions == "preview_senderid_consent") {

    // Get data
    $slt_operator = htmlspecialchars(strip_tags(isset($_REQUEST['slt_operator']) ? $_REQUEST['slt_operator'] : ""));
    $dlt_process = htmlspecialchars(strip_tags(isset($_REQUEST['dlt_process']) ? $_REQUEST['dlt_process'] : ""));
    $slt_template_type = htmlspecialchars(strip_tags(isset($_REQUEST['slt_template_type']) ? $_REQUEST['slt_template_type'] : ""));
    $license_docs = htmlspecialchars(strip_tags(isset($_REQUEST['license_docs']) ? $_REQUEST['license_docs'] : ""));
    $slt_business_category = htmlspecialchars(strip_tags(isset($_REQUEST['slt_business_category']) ? $_REQUEST['slt_business_category'] : ""));
    $header_sender_id = htmlspecialchars(strip_tags(isset($_REQUEST['header_sender_id']) ? $_REQUEST['header_sender_id'] : ""));
    $txt_explanation = htmlspecialchars(strip_tags(isset($_REQUEST['txt_explanation']) ? $_REQUEST['txt_explanation'] : ""));
    $ex_new_senderid = htmlspecialchars(strip_tags(isset($_REQUEST['ex_new_senderid']) ? $_REQUEST['ex_new_senderid'] : ""));
    site_log_generate("Message Page : User : " . $_SESSION['yjucp_user_name'] . " Preview Sender ID Consent - Access this page on " . date("Y-m-d H:i:s"), '../');

    $replace_txt = '{
    "user_id" : "' . $_SESSION['yjucp_user_id'] . '",
    "slt_operator" : "' . $slt_operator . '",
    "dlt_process" : "' . $dlt_process . '",
    "slt_template_type" : "' . $slt_template_type . '",
    "slt_business_category" : "' . $slt_business_category . '",
     "ex_new_senderid" : "' . $ex_new_senderid . '"
}';

        // Call the reusable cURL function
    $response = executeCurlRequest($api_url . "/list/preview_senderid_consent", "POST", $replace_txt);

    $obj = json_decode($response);

    // Check if the decoding was successful and if 'result' exists
    if ($obj && isset($obj->result) && count($obj->result) > 0) {
        // Access the first business category from the result array
        $display_business = $obj->result[0]->business_category;
    } else {
        $display_business = "No business category found"; // Handle if no result is found
    }
    $disp_ex_new_senderid = '';
    if ($ex_new_senderid == 'N') {
        $disp_ex_new_senderid = "New Sender ID";
    } elseif ($ex_new_senderid == 'E') {
        $disp_ex_new_senderid = "Existing Sender ID";
    }
           // Call the reusable cURL function
   $response = executeCurlRequest($api_url . "/list/select_message_type", "POST", $replace_txt);

    $obj = json_decode($response);

    // Check if there are any results and process them
    if (!empty($obj->result)) {
        $sms_route = $obj->result[0];
        $disp_dlt_process = $sms_route->sms_route_title . " (" . $sms_route->sms_route_desc . ")";
    }
    ?>
    <table id="basic-btn3" class="table table-striped table-bordered m-0"
        style="table-layout: fixed; white-space: inherit; width: 100%; overflow-x: scroll;">
        <tbody>
            <tr>
                <th scope="row" colspan="2" class="text-center">HEADER / SENDER ID</th>
            </tr>
            <tr>
                <td style="width:35% !important;"></td>
                <td style="width:65% !important;"></td>
            </tr>
            <? if ($disp_dlt_process != '') { ?>
                <tr>
                    <td scope="row">Message Type</td>
                    <td style="white-space: inherit !important;"><?= $disp_dlt_process ?></td>
                </tr>
            <? } ?>
            <? if ($slt_template_type != '') { ?>
                <tr>
                    <td scope="row">Header Type</td>
                    <td style="white-space: inherit !important;"><?= ucwords($slt_template_type) ?></td>
                </tr>
            <? } ?>
            <? if ($display_business != '') { ?>
                <tr>
                    <td scope="row">Business Category</td>
                    <td style="white-space: inherit !important;"><?= $display_business ?></td>
                </tr>
            <? } ?>
            <? if ($disp_ex_new_senderid != '') { ?>
                <tr>
                    <td scope="row">New / Existing Sender ID</td>
                    <td style="white-space: inherit !important;"><label
                            class='label label-lg label-warning'><?= $disp_ex_new_senderid ?></label></td>
                </tr>
            <? } ?>
            <? if ($header_sender_id != '') { ?>
                <tr>
                    <td scope="row">Header / Sender ID</td>
                    <td style="white-space: inherit !important;"><?= strtoupper($header_sender_id) ?></td>
                </tr>
            <? } ?>
            <? if ($txt_explanation != '') { ?>
                <tr>
                    <td scope="row">Explanation</td>
                    <td style="white-space: inherit !important;"><?= $txt_explanation ?></td>
                </tr>
            <? } ?>
            <? if ($license_docs != '') { ?>
                <tr>
                    <td scope="row">Sender ID Documents</td>
                    <td style="white-space: inherit !important;"><a href="uploads/license/<?= $license_docs ?>"
                            download><?= $license_docs ?></a></td>
                </tr>
            <? } ?>


            <? if ($txt_constempname != '') { ?>
                <tr>
                    <td scope="row">Consent Template Name</td>
                    <td style="white-space: inherit !important;"><?= $txt_constempname ?></td>
                </tr>
            <? } ?>
            <? if ($txt_consbrndname != '') { ?>
                <tr>
                    <td scope="row">Company / Brand Name</td>
                    <td style="white-space: inherit !important;"><?= $txt_consbrndname ?></td>
                </tr>
            <? } ?>
            <? if ($txt_consmsg != '') { ?>
                <tr>
                    <td scope="row">Consent Message</td>
                    <td style="white-space: inherit !important;"><?= $txt_consmsg ?></td>
                </tr>
            <? } ?>

            <? if ($consent_docs != '') { ?>
                <tr>
                    <td scope="row">Consent Documents</td>
                    <td style="white-space: inherit !important;"><a href="uploads/consent/<?= $consent_docs ?>"
                            download><?= $consent_docs ?></a></td>
                </tr>
            <? } ?>
        </tbody>
    </table>
    <?

    site_log_generate("Message Page : User : " . $_SESSION['yjucp_user_name'] . " Preview Sender ID Consent on " . date("Y-m-d H:i:s"), '../');
}
// message Page preview_senderid_consent - End

// message Page preview_content - Start -- This is for Content ID Tempory Display
if ($_SERVER['REQUEST_METHOD'] == "POST" and $tmpl_call_preview_functions == "preview_content") {
    $t_cm_sender_id = htmlspecialchars(strip_tags(isset($_REQUEST['t_cm_sender_id']) ? $_REQUEST['t_cm_sender_id'] : ""));
    $t_cm_consent_id = htmlspecialchars(strip_tags(isset($_REQUEST['t_cm_consent_id']) ? $_REQUEST['t_cm_consent_id'] : ""));

    site_log_generate("Message Page : User : " . $_SESSION['yjucp_user_name'] . " Preview Content - access this page on " . date("Y-m-d H:i:s"), '../');

    $replace_txt = '{
        "user_id" : "' . $_SESSION['yjucp_user_id'] . '",
        "t_cm_sender_id" : "' . $t_cm_sender_id . '",
        "t_cm_consent_id" : "' . $t_cm_consent_id . '"
    }';

        // Call the reusable cURL function
   $response = executeCurlRequest($api_url . "/list/cm_senter_id", "POST", $replace_txt);
    // Decode the JSON response
    $obj = json_decode($response);

    // Check if the result array exists and contains at least one item
    if (isset($obj->result) && count($obj->result) > 0) {
        // Loop through each item in the result array
        foreach ($obj->result as $record) {
            // Access the sender_title field
            $sender_title = $record->sender_title;

        }
    } else {
        echo "No data available in the response.";
    }

  // Call the reusable cURL function
   $response = executeCurlRequest($api_url . "/list/select_cm_consent_id", "POST", $replace_txt);

    // Decode the JSON response
    $obj = json_decode($response);
    
    // Check if the result array has any data
    if (isset($obj->result) && count($obj->result) > 0) {
        // Loop through each item in the result array
        foreach ($obj->result as $item) {
            // Extract the cm_consent_tmplname and display it
            $cm_consent_tmplname = $item->cm_consent_tmplname;
        }
    } else {
        echo "No template data found.";
    }
    
    ?>
    <table id="basic-btn3" class="table table-striped table-bordered m-0"
        style="table-layout: fixed; white-space: inherit; width: 100%; overflow-x: scroll;">
        <tbody>
            <tr>
                <th scope="row" colspan="2" class="text-center">Content Template</th>
            </tr>
            <tr>
                <td style="width:35% !important;"></td>
                <td style="width:65% !important;"></td>
            </tr>
            <? if ($cn_template_type != '') { ?>
                <tr>
                    <td scope="row">Template Type</td>
                    <td style="white-space: inherit !important;"><?= ucwords($cn_template_type) ?></td>
                </tr>
            <? } ?>
            <? if ($display_business != '') { ?>
                <tr>
                    <td scope="row">Business Category</td>
                    <td style="white-space: inherit !important;"><?= $display_business ?></td>
                </tr>
            <? } ?>
            <? if ($sender_title != '') { ?>
                <tr>
                    <td scope="row">Header / Sender ID</td>
                    <td style="white-space: inherit !important;"><?= strtoupper($sender_title) ?></td>
                </tr>
            <? } ?>
            <? if ($cm_consent_tmplname != '') { ?>
                <tr>
                    <td scope="row">Consent Template</td>
                    <td style="white-space: inherit !important;"><?= $cm_consent_tmplname ?></td>
                </tr>
            <? } ?>
            <? if ($cn_msgtype != '') { ?>
                <tr>
                    <td scope="row">Message Type</td>
                    <td style="white-space: inherit !important;"><?= $cn_msgtype ?></td>
                </tr>
            <? } ?>


            <? if ($cn_template_name != '') { ?>
                <tr>
                    <td scope="row">Content Template Name</td>
                    <td style="white-space: inherit !important;"><?= $cn_template_name ?></td>
                </tr>
            <? } ?>
            <? if ($cn_message != '') { ?>
                <tr>
                    <td scope="row">Content Template Message</td>
                    <td style="white-space: inherit !important;"><?= $cn_message ?></td>
                </tr>
            <? } ?>
        </tbody>
    </table>
    <?

    site_log_generate("Message Page : User : " . $_SESSION['yjucp_user_name'] . " Preview Content on " . date("Y-m-d H:i:s"), '../');
}
// message Page preview_content - End


// Messenger Response Page view_response - Start
if ($_SERVER['REQUEST_METHOD'] == "POST" and $tmpl_call_function == "view_response") {
  // To log file generate
  site_log_generate("Messenger Response Page : User : " . $_SESSION['yjucp_user_name'] . " access this page on " . date("Y-m-d H:i:s"), '../');
   // Get data
  $message_id = htmlspecialchars(strip_tags(isset($_REQUEST['message_id']) ? $conn->real_escape_string($_REQUEST['message_id']) : ""));
  $message_from = htmlspecialchars(strip_tags(isset($_REQUEST['message_from']) ? $conn->real_escape_string($_REQUEST['message_from']) : ""));
  $message_to = htmlspecialchars(strip_tags(isset($_REQUEST['message_to']) ? $conn->real_escape_string($_REQUEST['message_to']) : ""));
  ?>
  <div class="inner_div" id="chathist">
    <?php
// To Send the request  API
    $replace_txt = '{
    "user_id" : "' . $_SESSION['yjucp_user_id'] . '",
    "message_from" : "' . $message_from . '",
    "message_to" : "' . $message_to . '"
  }';
            // Call the reusable cURL function
   $response = executeCurlRequest($api_url . "/whsp_process/messenger_view_response", "POST", $replace_txt);

     // After got response decode the JSON result
    $header = json_decode($response, false);
    $i = 0;
    $first_message_from = '-';
    $last_msg_time = '';
    $first_occurrence = 0;
    $message_id = '';
     // To get the one by one data
    if ($header->num_of_rows > 0) { // If the response is success to execute this condition
      for ($indicator = 0; $indicator < $header->num_of_rows; $indicator++) {
// If the response is success to execute this condition. Looping the indicator is less than the num_of_rows.if the condition is true to continue the process.if the condition are false to stop the process
        if($header->report[$indicator]->bearer_token != '') { 
          $sndrid = $header->report[$indicator]->mobile_no;
        }

        if ($message_to == $header->report[$indicator]->mobile_no) {
          $sendfr = $message_to;
          $sendto = $message_from;
        } elseif ($message_from == $header->report[$indicator]->mobile_no) {
          $sendfr = $message_from;
          $sendto = $message_to;
        }
        $message_id .= $header->report[$indicator]->message_id . ", ";
        $entry_date = date('d-m-Y h:i:s A', strtotime($header->report[$indicator]->message_rec_date));
        $display_data = '';
        switch (strtoupper($header->report[$indicator]->message_type)) {
          case 'TEXT':
            $display_data = "Text : " . base64_decode($header->report[$indicator]->msg_text);
            break;
            case 'LIST':?>
             <style>
                li{
                  text-align: left;
                }
             </style>
             <? $msg_data = $header->report[$indicator]->message_data;
                // Convert JSON string to PHP array
              $jsonArray = json_decode($msg_data, true);
              // Access the "body" content
              $bodyText = $jsonArray['interactive']['body']['text'];
              $expl2 = explode("'</li><li>'", $header->report[$indicator]->msg_list);
              // print_r($expl2[0]);
             $display_data = $bodyText. $expl2[0];
              break;
              case 'INTERACTIVE':
                $msg_data = $header->report[$indicator]->message_data;
                // Convert JSON string to PHP array
              $jsonArray = json_decode($msg_data, true);
              // Access the "body" content
              $bodyText = $jsonArray['list_reply']['title'];
              $display_data = $bodyText;
                break;
          case 'BUTTON':
            $display_data = "Reply Button : " . $header->report[$indicator]->msg_reply_button;
            break;
          case 'REACTION':
            $display_data = "Reaction : &#x" . $header->report[$indicator]->msg_reaction;
            break;
          case 'STICKER':
            $expl1 = explode("/", $header->report[$indicator]->msg_media_type);
            $display_data = "Sticker : <img src='uploads/response_media/" . $header->report[$indicator]->msg_media . "' style='max-width:200px !important; height: auto !important;'>";
            break;
          case 'AUDIO':
            $expl2 = explode(";", $header->report[$indicator]->msg_media_type);
            $display_data = ucwords($header->report[$indicator]->message_type) . ' : <audio controls>
            <source src="uploads/response_media/' . $header->report[$indicator]->msg_media . '" type="' . $expl2[0] . '">
          </audio>';
            break;
          case 'VIDEO':
            $display_data = ucwords($header->report[$indicator]->message_type) . ' : <video width="320" height="240" controls>
            <source src="uploads/response_media/' . $header->report[$indicator]->msg_media . '" type="' . $header->report[$indicator]->msg_media_type . '">
          </video>' . base64_decode($header->report[$indicator]->msg_media_caption);
            break;
          case 'IMAGE':
            $display_data = ucwords($header->report[$indicator]->message_type) . " : <img src='uploads/response_media/" . $header->report[$indicator]->msg_media . "' style='max-width:200px !important; height: auto !important;'>" . base64_decode($header->report[$indicator]->msg_media_caption);
            break;
          case 'DOCUMENT':
            $display_data = ucwords($header->report[$indicator]->message_type) . " : <a href='uploads/response_media/" . $header->report[$indicator]->msg_media . "'>Download</a>" . base64_decode($header->report[$indicator]->msg_media_caption);
            break;
          default:
            $display_data = "Text : " . base64_decode($header->report[$indicator]->msg_text);
            break;            
        }
        if ($i == 0) {
          $i++;
          $first_message_from = $row;
        }
        $display_user = '';
        if ($header->report[$indicator]->mobile_no == $header->report[$indicator]->message_to) { // If the response is success to execute this condition
          $display_user = $header->report[$indicator]->message_from;
          if ($first_occurrence == 0) {
            $first_occurrence++;
            $last_msg_time = $entry_date;
          }
          ?>
          <div id="triangle" class="chat-item chat-right mb-2">
            <div id="message" class="chat-details">
              <span style="float:left;" class="chat-text">
                <?php echo $display_data; ?>
              </span> <br />
              <div>
                <span style="color:#606060;float:left;font-size:10px;clear:both;" class="chat-time">
                  <b>
                    <?php echo $display_user; ?>
                  </b>,
                  <?php echo $entry_date; ?>
                </span>
              </div>
            </div>
          </div>
          <?php
        } else { // otherwise
          $display_user = $header->report[$indicator]->message_from;
          ?>
          <div id="triangle1" class="chat-item chat-left mb-2">
            <div id="message1" class="chat-details">
              <span style="color:#000;float:right;" class="chat-text1">
                <?php echo $display_data; ?>
              </span> <br />
              <div>
                <span style="color:#606060;float:right;font-size:10px;clear:both;">
                  <b>
                    <?php echo $display_user; ?>
                  </b>,
                  <?php echo $entry_date; ?>
                </span>
              </div>
            </div>
          </div>
          <?php
        }
      }
      $message_id = rtrim($message_id, ", ");
      // To Send the request  API
      $replace_txt = '{
        "user_id" : "' . $_SESSION['yjucp_user_id'] . '",
        "message_id" : "' . $message_id . '"
      }';
          // Call the reusable cURL function
   $response = executeCurlRequest($api_url . "/whsp_process/messenger_response_update", "POST", $replace_txt);
         // After got response decode the JSON result
      $header = json_decode($response, false);
    }
    ?>
  </div>
  <div id="app_footer" style='clear: both; border-top: 1px dashed #e4e6fc; padding: 10px;'>
    <div>
      <form id="frm_reply" name="frm_reply" action="#" method="POST">
        <div>
          <div class="row align-items-center justify-content-center">
            <?
            $time1 = strtotime($last_msg_time);
            $time2 = strtotime(date("Y-m-d h:i:s A"));
            $difference = round(abs($time2 - $time1) / 3600, 2);

            if ($difference <= 23) { ?>
              <div style="width:80%; float: left">
                <textarea id="txt_reply" name="txt_reply" autofocus required tabindex="1"
                  style="height: 75px !important; width: 100%;" placeholder="Enter your reply"
                  class="form-control form-control-primary required"></textarea>
              </div>
              <div class="text-center" style="width:20%; float: left;">
                <span class="error_display" id='id_error_display'></span>
                <input type="hidden" class="form-control" name='message_id' id='message_id' value='<?= $message_id ?>' />
                <input type="hidden" class="form-control" name='message_from' id='message_from' value='<?= $sendfr ?>' />
                <input type="hidden" class="form-control" name='message_to' id='message_to' value='<?= $sendto ?>' />
                <input type="hidden" class="form-control" name='sender_id' id='sender_id' value='<?= $sndrid ?>' />
                <input type="hidden" class="form-control" name='admin_number' id='admin_number' value='<?= $admin_number ?>' />

                <input type="hidden" class="form-control" name='tmpl_call_function' id='tmpl_call_function'
                  value='messenger_reply' />
                <input type="submit" name="reply_submit" id="reply_submit" tabindex="2" value="Reply"
                  class="btn btn-success" style="margin-top: 18px;">
              </div>
            <? } else { ?>
              <span class="error_display">Last message received from client before 24 hours. So, We cannot send response
                here!!</span>
            <? } ?>
          </div>
        </div>
      </form>
    </div>
  </div>
  <?
  site_log_generate("Messenger Response Page : User : " . $_SESSION['yjucp_user_name'] . " Preview User on " . date("Y-m-d H:i:s"), '../');
}
// Messenger Response Page view_response - End

?>
<!-- script include -->
<script>
  $(document).ready(function () {
    $('#txt_reply').keydown(function () {
      var message = $("txt_reply").val();
      if (event.keyCode == 13) {
        if (message == "") { } else {
          $('#frm_reply').submit();
        }
        $("#txt_reply").val('');
        return false;
      }
    });
  });
</script>
<?

// Finally Close all Opened Mysql DB Connection
$conn->close();

// Output header with HTML Response
header('Content-type: text/html');
echo $result_value;
