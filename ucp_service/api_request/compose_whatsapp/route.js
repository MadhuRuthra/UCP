const express = require("express");
const router = express.Router();
const createCsvWriter = require('csv-writer').createObjectCsvWriter;
const fs = require('fs');
const moment = require('moment');
const csv = require('csv-parser');
const path = require('path');
const db = require('../../db_connect/connect');
const validator = require('../../validation/middleware');
const valid_user = require("../../validation/valid_user_middleware");
const dotenv = require('dotenv');
const ComposeWhatsapp = require("./compose_whatsapp");
const ApproveComposeWhatsapp = require("./approve_whatsapp_list");
const RejectCampaign = require("./reject_whatsapp_campaign");
const ComposeWhatsappList = require("./campaign_whatsapp_list");
const approve_whatspp_no_api_list = require("./approve_whatspp_no_api_list");
// Validation File
const ComposeWhatsappValidation = require("../../validation/send_message_validation");
const ApproveWhatsappNoApiListValidation = require("../../validation/approve_whatsapp_no_api");
const ApproveWhatsappNoValidation = require("../../validation/approve_whatsappno");
const getPortStatusData = require("../../get_port_status.js")
const main = require('../../logger');
const axios = require('axios');
const http = require('http');
dotenv.config();
require("dotenv").config();
const env = process.env;
const DB_NAME = env.DB_NAME;
const API_URL = env.API_URL;
const apiAdminUser = process.apiAdminUser;
const apiAdminPswd = env.apiAdminPswd;
let Message_Delay = env.Message_Delay;
let sendUser = env.sendUser;
let sendPassword = env.sendPassword;
let sendURL = env.sendURL;
let batchSize = parseInt(process.env.batchSize, 10);
let getPortStatus = env.getPortStatus;
let No_Of_port = env.No_Of_port;
const fse = require('fs-extra');
const util = require('util');

// Compose_SMS - start
router.post(
  "/whatsapp_compose",
  // validator.body(ComposeWhatsappValidation),
  valid_user,
  async (req, res, next) => {
    try {
      const result = await ComposeWhatsapp.ComposeWhatsapp(req);
      res.json(result);
    } catch (err) {
      console.error(`Error while Compose Whatsapp ${err.message}`);
      next(err);
    }
  }
);
// Compose_SMS - end


// Compose Whatsapp List - start
router.get(
  "/compose_whatsapp_list",
  // validator.body(),
  valid_user,
  async (req, res, next) => {
    try {
      const result = await ComposeWhatsappList.Compose_Whatsapp_List(req);
      res.json(result);
    } catch (err) {
      console.error(`Error while Compose Whatsapp ${err.message}`);
      next(err);
    }
  }
);
// Compose Whatsapp List - end

// Approve Whatsapp List - start
router.get(
  "/approve_whatsapp_list",
  // validator.body(),
  valid_user,
  async (req, res, next) => {
    try {
      const result = await ApproveComposeWhatsapp.ComposeApproveWhatsapp(req);
      res.json(result);
    } catch (err) {
      console.error(`Error while Compose Whatsapp ${err.message}`);
      next(err);
    }
  }
);
// Approve Whatsapp List - end


// Approve_compose_sms - start
router.post("/approve_whatsapp", valid_user,
  async (req, res, next) => {
    try {
      const logger = main.logger;
      const logger_all = main.logger_all;
      const { compose_message_id, selected_userid: selected_user_id, request_id, rights_name } = req.body;
      var sender_numbers = {}, valid_mobile_numbers = [], push_name_and_values = [], whatspp_config_ids = [], inserted_ids = [];
      let insert_count = 0;


      const header_json = req.headers;
      const ip_address = header_json['x-forwarded-for'] || req.connection.remoteAddress;  // Handle missing header
      await db.query(`INSERT INTO api_log VALUES(NULL, 0, '${req.originalUrl}', '${ip_address}', '${request_id}', 'N', '-', '0000-00-00 00:00:00', 'Y', CURRENT_TIMESTAMP)`);

      const check_req_id_result = await db.query(`SELECT * FROM api_log WHERE request_id = '${request_id}' AND response_status != 'N' AND api_log_status='Y'`);

      if (check_req_id_result.length !== 0) {
        await db.query(`UPDATE api_log SET response_status = 'F', response_date = CURRENT_TIMESTAMP,response_comments = 'Request already processed' WHERE request_id = '${request_id}' AND response_status = 'N'`);
        return res.json({ response_code: 0, response_status: 201, response_msg: 'Request already processed', request_id });
      }

      const select_rights_id = await db.query(`SELECT * From rights_master where rights_name = '${rights_name}'`)
      let rights_id = select_rights_id[0].rights_id;

      const get_user_det = await db.query(`SELECT * FROM compose_whatsapp where user_id = '${selected_user_id}' AND compose_ucp_id = '${compose_message_id}' AND ucp_status = 'W'`);

      //Check if selected data is equal to zero, send failuer response 'Compose ID Not Available'
      if (get_user_det.length == 0) {
        await db.query(`UPDATE api_log SET response_status = 'F',response_date = CURRENT_TIMESTAMP,response_comments = 'Compose ID Not Available.' WHERE request_id = '${request_id}' AND response_status = 'N'`);
        const composeid_msg = { response_code: 0, response_status: 201, response_msg: 'Compose ID Not Available', request_id: request_id }

        return res.json(composeid_msg);
      }

      const { campaign_name, file_path, total_mobile_no_count, whatspp_config_id, template_id,group_id } = get_user_det[0];
      let components_data = get_user_det[0].components;

      whatspp_config_id.toString().split(',').forEach(id => {
        const numericId = Number(id.trim());
        if (!whatspp_config_ids.includes(numericId)) {
          whatspp_config_ids.push(numericId);
        }
      });

      for (var s = 0; s < whatspp_config_ids.length; s++) {
        const select_details = await db.query(`SELECT con.phone_number_id,con.whatsapp_business_acc_id,con.bearer_token from whatsapp_config con WHERE whatspp_config_id = '${whatspp_config_ids[s]}' AND con.whatspp_config_status = 'Y'`);

        // check if the sender number have the template
        if (select_details.length != 0) {
          const check_template = await db.query(`SELECT lan.language_code,con.user_id,tmp.template_name,con.available_credit-con.sent_count available_credit FROM message_template tmp LEFT JOIN whatsapp_config con ON con.whatspp_config_id = tmp.whatsapp_config_id LEFT JOIN master_language lan ON lan.language_id = tmp.language_id WHERE tmp.unique_template_id = '${template_id}' AND tmp.template_status = 'Y' AND whatspp_config_id = '${whatspp_config_ids[s]}'`);

          tmpl_name = check_template[0].template_name;
          tmpl_lang = check_template[0].language_code;

          sender_numbers[whatspp_config_ids[s]] = ({ user_id: check_template[0].user_id, count: check_template[0].available_credit, phone_number_id: select_details[0].phone_number_id, whatsapp_business_acc_id: select_details[0].whatsapp_business_acc_id, bearer_token: select_details[0].bearer_token })
        }
        // if sender_number not available push the sender number in notready_numbers array.
        else {
          notready_numbers.push({ sender_number: whatspp_config_ids[s], reason: 'Number not available.' })
        }
      }
      if (!group_id) {
        logger_all.info("Coming to File")
      fs.createReadStream(file_path)
        .pipe(csv({ headers: false }))
        .on('data', (row) => {
          const firstColumnValue = row[0]?.trim();
          if (!firstColumnValue) return; // Skip empty rows

          valid_mobile_numbers.push(firstColumnValue);

          const otherValues = Object.values(row).slice(1).map(val => val?.trim()).filter(Boolean);
          push_name_and_values.push(otherValues);
        })
        .on('error', (error) => console.error('Error:', error.message))
        .on('end', async () => {
          Send_File_Values(valid_mobile_numbers);
          logger_all.info(valid_mobile_numbers)

        });
        }else {
        logger_all.info("Coming to Group using ")

          const get_total_mobilenos = await db.query(`SELECT * FROM contact_management where contact_mgtgrp_id = '${group_id}'`)
          const total_mobile_numbers = get_total_mobilenos.map(contact => contact.contact_no);
          Send_File_Values(total_mobile_numbers);
  
        }
        async function Send_File_Values(valid_mobile_numbers) {
          //Check For valid numbers
          if (valid_mobile_numbers.length === 0) {
            logger_all.info("[API RESPONSE] " + JSON.stringify({ response_code: 0, response_status: 201, response_msg: 'Failed', request_id: request_id }))
            return res.json({ response_code: 0, response_status: 201, response_msg: 'Failed', request_id: request_id });
          }

          await db.query(`UPDATE compose_whatsapp SET ucp_status = "P",ucp_start_date = CURRENT_TIMESTAMP WHERE compose_ucp_id = '${compose_message_id}' AND user_id = '${selected_user_id}'AND ucp_status = "W"`);

          await db.query(`INSERT INTO user_summary_report VALUES(NULL, '${selected_user_id}', ${rights_id}, '${compose_message_id}', '${campaign_name}','${total_mobile_no_count}', '${total_mobile_no_count}', 0, 0, 0, 0, 0, 'N', 'N', CURRENT_TIMESTAMP, NULL, NULL)`);


          logger_all.info("[API RESPONSE] " + JSON.stringify({ response_code: 1, response_status: 200, response_msg: 'Initiated', request_id: request_id }))
          res.json({ response_code: 1, response_status: 200, response_msg: 'Initiated', request_id: request_id });

          let insert_numbers = `INSERT INTO ${DB_NAME}_${selected_user_id}.compose_whatsapp_status_tmpl_${selected_user_id} VALUES`;

          for (let k = 0; k < valid_mobile_numbers.length; k++) {
            insert_numbers += `(NULL, ${compose_message_id}, '${valid_mobile_numbers[k]}', '-', 'Y', CURRENT_TIMESTAMP, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),`;

            if (++insert_count === 1000 || k === valid_mobile_numbers.length - 1) {
              insert_numbers = insert_numbers.slice(0, -1); // Remove trailing comma
              const result = await db.query(insert_numbers);
              const first_insert_id = result.insertId;
              const affectedRows = result.affectedRows;

              for (let j = 0; j < affectedRows; j++) {
                inserted_ids.push(first_insert_id + j);
                logger_all.info(`Inserted ID: ${first_insert_id + j}`);
              }

              // Reset for the next batch
              insert_numbers = `INSERT INTO ${DB_NAME}_${selected_user_id}.compose_whatsapp_status_tmpl_${selected_user_id} VALUES`;
              insert_count = 0;
            }
          }

          logger_all.info(`Total Inserted IDs: ${JSON.stringify(inserted_ids)}`);


          for (var m = 0; m < valid_mobile_numbers.length; m) {
            // loop with in loop key var using in sender numbers 
            for (var key in sender_numbers) {
              if (sender_numbers[key].count >= 1) {

                api_url_updated = `${API_URL}${sender_numbers[key].phone_number_id}/messages`

                var data;
                // Construct message data For Variables values
                if (push_name_and_values.length > 0) {
                  components_data = components_data.filter(component => component.type !== 'body' && component.type !== 'BODY');

                  let variable_array = push_name_and_values[m].map(value => ({
                    "type": "text",
                    "text": value
                  }));

                  components_data.push({
                    "type": "body",
                    "parameters": variable_array
                  });
                }

                // whtsap_send length is not equal to '0' to get the valaue in data
                if (components_data.length != 0) {
                  data = JSON.stringify({
                    "messaging_product": "whatsapp",
                    "to": valid_mobile_numbers[m].toString(),
                    "type": "template",
                    "template": {
                      "name": tmpl_name,
                      "language": {
                        "code": tmpl_lang
                      },
                      "components": JSON.parse(components_data)
                    }
                  });
                }
                else { // otherwise to get the details in the value name is data
                  data = JSON.stringify({
                    "messaging_product": "whatsapp",
                    "to": valid_mobile_numbers[m].toString(),
                    "type": "template",
                    "template": {
                      "name": tmpl_name,
                      "language": {
                        "code": tmpl_lang
                      }
                    }
                  });
                }
                // send msg value initiated .
                var send_msg = {
                  method: 'post',
                  url: api_url_updated,
                  headers: {
                    'Authorization': 'Bearer ' + sender_numbers[key].bearer_token,
                    'Content-Type': 'application/json'
                  },
                  data: JSON.parse(data)
                };

                logger_all.info("[send msg request] : " + JSON.stringify(send_msg))
                // send_msg function 
                await axios(send_msg)
                  .then(async function (response) {
                    logger_all.info("[send msg response] : " + util.inspect(response));

                    if (response.status != 200) {
                      await db.query(`UPDATE ${DB_NAME}_${selected_user_id}.compose_whatsapp_status_tmpl_${selected_user_id} SET response_date = CURRENT_TIMESTAMP,response_status = 'F',response_message = 'FAILED' WHERE compose_whatsapp_id = ${compose_message_id} AND mobile_no = '${valid_mobile_numbers[m]}'`);
                    } else {
                      await db.query(`UPDATE ${DB_NAME}_${selected_user_id}.compose_whatsapp_status_tmpl_${selected_user_id} SET response_date = CURRENT_TIMESTAMP,response_status = 'S',response_message = 'SUCCESS',response_id = '${response.data.messages[0].id}',comments='${key}' WHERE compose_whatsapp_id = ${compose_message_id} AND mobile_no = '${valid_mobile_numbers[m]}'`);

                      await db.query(`UPDATE whatsapp_config SET sent_count = sent_count+1 WHERE concat(country_code, mobile_no) = '${key}'`);

                      await db.query(`UPDATE message_limit SET available_messages = available_messages - 1 WHERE user_id ='${sender_numbers[key].user_id}'`);

                      sender_numbers[key].count = sender_numbers[key].count - 1;
                    }
                    m++;

                    if (m == valid_mobile_numbers.length) {
                      await db.query(`UPDATE compose_whatsapp SET ucp_status = "V",ucp_end_date = CURRENT_TIMESTAMP WHERE compose_ucp_id = ${compose_message_id} AND user_id = '${selected_user_id}'AND ucp_status = "P"`);
                    }
                  })
                  // any error occurres send error response to client and to update the getting details
                  .catch(async function (error) {
                    logger_all.info("[send msg failed response] : " + error);
                    await db.query(`UPDATE ${DB_NAME}_${selected_user_id}.compose_whatsapp_status_tmpl_${selected_user_id} SET response_date = CURRENT_TIMESTAMP,response_status = 'F',response_message = '${error.message}' WHERE compose_whatsapp_id = ${compose_message_id} AND mobile_no = '${valid_mobile_numbers[m]}'`);
                    m++;
                    if (m == valid_mobile_numbers.length) {
                      await db.query(`UPDATE compose_whatsapp SET ucp_status = "F",ucp_end_date = CURRENT_TIMESTAMP WHERE compose_ucp_id = ${compose_message_id} AND user_id = '${selected_user_id}'AND ucp_status = "P"`);
                    }
                  });
              }
              if (m == valid_mobile_numbers.length) {
                break;
              }
            }
          }

          await db.query(`UPDATE api_log SET response_status = 'S', response_date = CURRENT_TIMESTAMP,  response_comments = 'Success' WHERE request_id = '${request_id}' AND response_status = 'N'`);

          await db.query(`UPDATE user_summary_report SET total_waiting = '0',total_process = '${valid_mobile_numbers.length}' where user_id = '${selected_user_id}' AND com_msg_id = '${compose_message_id}' and rights_id = '${rights_id}' `);
    }
  }
    catch (err) {
      //If error occurs, send failure response
      await db.query(`UPDATE api_log SET response_status = 'F',response_date = CURRENT_TIMESTAMP,response_comments = 'Error occurred.' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);
      send_response = { response_code: 0, response_status: 201, response_msg: "Error Occurred." };
      return res.json(send_response);
    }
  });
// Approve_compose_sms - end

// reject_campaign - start
router.put(
  "/reject_campaign_whatsapp",
  valid_user,
  async function (req, res, next) {
    try {// access the reject_campaign function
      let logger = main.logger
      const logger_all = main.logger_all;
      let result = await RejectCampaign.Reject_Campaign(req);
      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// reject_campaign - end


// approve_whatsapp_no_api - start
router.get(
  "/approve_whatsapp_no_api",
  validator.body(ApproveWhatsappNoApiListValidation),
  valid_user,
  async function (req, res, next) {
    try {// access the ApproveWhatsappNoApiList function
      var logger = main.logger

      var result = await approve_whatspp_no_api_list.ApproveWhatsappNoApiList(req);


      logger.info("[API RESPONSE] " + JSON.stringify(result))

      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// approve_whatsapp_no_api - end

// approve_whatsappno - start
router.put(
  "/approve_whatsappno",
  validator.body(ApproveWhatsappNoValidation),
  valid_user,
  async function (req, res, next) {
    try {// access the ApproveWhatsappNo function
      var logger = main.logger
      var result = await approve_whatspp_no_api_list.ApproveWhatsappNoAPIList(req);
      logger.info("[API RESPONSE] " + JSON.stringify(result))
      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// approve_whatsappno - end


module.exports = router;