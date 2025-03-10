const express = require("express");
const router = express.Router();
const fs = require('fs');
const csv = require('csv-parser');
const db = require('../../db_connect/connect');
const validator = require('../../validation/middleware');
const valid_user = require("../../validation/valid_user_middleware");
const dotenv = require('dotenv');
const ComposeSMS = require("./compose_sms");
const Composesmslist = require("../compose_sms/compose_sms_list");
const Approve_composesms_list = require("./approve_compose_smslist");

//const ComposeSMPP =  require("./compose_smpp");
const RejectCampaign = require("./reject_sms_campaign");
const ComposeSmsValidation = require("../../validation/send_message_validation");
const UseridValidation = require("../../validation/user_id_optional_validation");
const RightsNameValidation = require("../../validation/rights_name_validation");
const deleteTemplateValidation = require("../../validation/delete_template_validation");
const main = require('../../logger');

dotenv.config();
require("dotenv").config();
const env = process.env;
const DB_NAME = env.DB_NAME;
const apiAdminUser = process.apiAdminUser;
const apiAdminPswd = env.apiAdminPswd;

// delete_template - start
router.put(
  "/delete_template",
  validator.body(deleteTemplateValidation),
  valid_user,
  async function (req, res, next) {
    try {// access the CampaignReport function
      const logger = main.logger
      const logger_all = main.logger_all;

      const header_json = req.headers;
      const ip_address = header_json['x-forwarded-for'];
      await db.query(`INSERT INTO api_log VALUES(NULL,0,'${req.originalUrl}','${ip_address}','${req.body.request_id}','N','-','0000-00-00 00:00:00','Y',CURRENT_TIMESTAMP)`);
      const check_req_id_result = await db.query(`SELECT * FROM api_log WHERE request_id = '${req.body.request_id}' AND response_status != 'N' AND api_log_status='Y'`);
      if (check_req_id_result.length != 0) {
        logger_all.info("[failed response] : Request already processed");
        logger.info("[API RESPONSE] " + JSON.stringify({ request_id: req.body.request_id, response_code: 0, response_status: 201, response_msg: 'Request already processed' }))
           await db.query(`UPDATE api_log SET response_status = 'F',response_date = CURRENT_TIMESTAMP, response_comments = 'Request already processed' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);
        return res.json({ response_code: 0, response_status: 201, response_msg: 'Request already processed', request_id: req.body.request_id });
      }
      let result = await RejectCampaign.deleteTemplate(req);
      result['request_id'] = req.body.request_id;
      if (result.response_code == 0) {
        await db.query(`UPDATE api_log SET response_status = 'F',response_date = CURRENT_TIMESTAMP, response_comments = '${result.response_msg}' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);
      }
      else {
       await db.query(`UPDATE api_log SET response_status = 'S',response_date = CURRENT_TIMESTAMP, response_comments = 'Success' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);
      }
      logger.info("[API RESPONSE] " + JSON.stringify(result))
      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// delete_template - end

// compose_sms_list - start
router.get(
  "/compose_sms_list",
  validator.body(RightsNameValidation),
  valid_user,
  async function (req, res, next) {
    try {// access the ComposeSMSList function
      let logger = main.logger

      let result = await Composesmslist.ComposeSMSList(req);


      logger.info("[API RESPONSE] " + JSON.stringify(result))

      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// compose_sms_list - end

// Approve_compose_sms - start
router.get(
  "/approve_composesms_list",
  validator.body(UseridValidation),
  valid_user,
  async function (req, res, next) {
    try {// access the approve_composesms_list function
      let logger = main.logger

      let result = await Approve_composesms_list.Approve_Composesms_List(req)


      logger.info("[API RESPONSE] " + JSON.stringify(result))

      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// Approve_compose_sms - end

// Compose_SMS - start
router.post(
  "/sms_compose",
  validator.body(ComposeSmsValidation),
  valid_user,
  async (req, res, next) => {
    try {
      const logger = main.logger;
      const logger_all = main.logger_all;
      const result = await ComposeSMS.ComposeSMS(req);
      res.json(result);
    } catch (err) {
      console.error(`Error while composing SMS: ${err.message}`);
      next(err);
    }
  }
);
// Compose_SMS - end


// Approve_compose_sms - start
router.post("/approve_composesms", valid_user,
  async (req, res, next) => {
    try {
      const logger = main.logger;
      const logger_all = main.logger_all;
      const { campaign_id, selected_user_id: selected_user_id, request_id } = req.body;

      const header_json = req.headers;
      const ip_address = header_json['x-forwarded-for'] || req.connection.remoteAddress;  // Handle missing header
      await db.query(
        `INSERT INTO api_log VALUES(NULL, 0, '${req.originalUrl}', '${ip_address}', '${request_id}', 'N', '-', '0000-00-00 00:00:00', 'Y', CURRENT_TIMESTAMP)`
      );

      const check_req_id_result = await db.query(
        `SELECT * FROM api_log WHERE request_id = '${request_id}' AND response_status != 'N' AND api_log_status='Y'`
      );

      if (check_req_id_result.length !== 0) {
        logger_all.info("[API RESPONSE] " + JSON.stringify({
          request_id, response_code: 0, response_status: 201, response_msg: 'Request already processed'
        }));

        await db.query(
          `UPDATE api_log SET response_status = 'F', response_date = CURRENT_TIMESTAMP, 
                 response_comments = 'Request already processed' WHERE request_id = '${request_id}' AND response_status = 'N'`
        );

        return res.json({ response_code: 0, response_status: 201, response_msg: 'Request already processed', request_id });
      }

      let insert_count = 1;
      const valid_mobile_numbers = [], push_name_and_values = [], media_url_array = [], media_type_array = [], file_names_array = [];
      let transactionIdString = [], corelationId = [];

      const get_user_det = await db.query(`SELECT * FROM compose_sms where user_id = '${selected_user_id}' AND compose_ucp_id = '${campaign_id}' AND ucp_status = 'W'`);

      //Check if selected data is equal to zero, send failuer response 'Compose ID Not Available'
      if (get_user_det.length == 0) {
        const update_api_log = await db.query(`UPDATE api_log SET response_status = 'F',response_date = CURRENT_TIMESTAMP,response_comments = 'Compose ID Not Available.' WHERE request_id = '${request_id}' AND response_status = 'N'`);
        const composeid_msg = { response_code: 0, response_status: 201, response_msg: 'Compose ID Not Available', request_id: request_id }

        return res.json(composeid_msg);
      }
      const { campaign_name, file_path, message_content, content_char_count, total_mobile_no_count,group_id } = get_user_det[0];
      let insert_id_array = [];
      if (!group_id) {
      // Fetch the CSV file
      await fs.createReadStream(file_path)

        // Read the CSV file from the stream
        .pipe(csv({
          headers: false
        }))

        // Set headers to false since there are no column headers
        .on('data', (row) => {
          if (Object.values(row).every(value => value === '')) {
            return;
          }

          const firstColumnValue = row[0].trim();
          const name = row[1] ? row[1].trim() : '';
          valid_mobile_numbers.push(firstColumnValue)
          //push_name.push(name)
          const otherValues = [];
          for (let i = 1; i < Object.keys(row).length; i++) { // Start from 2 to skip mobile number and name
            if (row[i]) {
              otherValues.push(row[i].trim());
            }
          }
          push_name_and_values.push([...otherValues]);

        })
        .on('error', (error) => {
          console.error('Error:', error.message);
        })
        .on('end', async () => {
          logger_all.info(valid_mobile_numbers)
          logger_all.info(push_name_and_values)
          logger_all.info("**********************_______________________________")
          Send_File_Values(valid_mobile_numbers);

        }) 
       }else {
          const get_total_mobilenos = await db.query(`SELECT * FROM contact_management where contact_mgtgrp_id = '${group_id}'`)
          const total_mobile_numbers = get_total_mobilenos.map(contact => contact.contact_no);
          Send_File_Values(total_mobile_numbers);
  
        }
        async function Send_File_Values(valid_mobile_numbers) {
          //Insert compose details to compose_msg_status table
          let insert_numbers = ""
          insert_numbers = `INSERT INTO ${DB_NAME}_${selected_user_id}.compose_ucp_status_${selected_user_id} VALUES`;
          let insertId;
          let inserted_ids = [];
          //Loop for receiver numbers
          if (valid_mobile_numbers.length === 0) {
            logger_all.info("[API RESPONSE] " + JSON.stringify({ response_code: 0, response_status: 201, response_msg: 'Failed', request_id: request_id }))
            return res.json({ response_code: 0, response_status: 201, response_msg: 'Failed', request_id: request_id });
          }

          await db.query(`UPDATE compose_sms SET ucp_status = "P",ucp_start_date = CURRENT_TIMESTAMP WHERE compose_ucp_id = '${campaign_id}' AND user_id = '${selected_user_id}'AND ucp_status = "W"`);

          for (let k = 0; k < valid_mobile_numbers.length; k) {

            if (k == valid_mobile_numbers.length) {
              break;
            }
            //Insert compose data
            insert_numbers = insert_numbers + "" + `(NULL,'${campaign_id}','${valid_mobile_numbers[k]}','${message_content}','V','N',CURRENT_TIMESTAMP,NULL,NULL,NULL),`;

            //check if insert_count is 1000, insert 1000 splits data
            // If batch size is 1000, execute the insert query
            if (insert_count === 1000) {
              insert_numbers = insert_numbers.slice(0, -1); // Remove trailing comma
              let insert_numbers_result = await db.query(insert_numbers);

              let first_insert_id = insert_numbers_result.insertId; // First inserted ID

              // Log the correct number of inserted IDs
              for (let j = 0; j < 1000; j++) {
                let current_id = first_insert_id + j;
                inserted_ids.push(current_id);
                logger_all.info(`Inserted ID: ${current_id}`);
              }

              // Reset for the next batch
              insert_count = 0;
              insert_numbers = `INSERT INTO ${DB_NAME}_${selected_user_id}.compose_ucp_status_${selected_user_id} VALUES`;
            }
            insert_count = insert_count + 1;
            k++;
          }

          //After the loops complete, this if statement checks if any pending insert queries are left to be executed. If so, it executes
          if (insert_numbers !== `INSERT INTO ${DB_NAME}_${selected_user_id}.compose_ucp_status_${selected_user_id} VALUES`) {
            insert_numbers = insert_numbers.slice(0, -1); // Remove trailing comma
            let insert_numbers_result = await db.query(insert_numbers);

            let first_insert_id = insert_numbers_result.insertId; // First inserted row ID
            let affectedRows = insert_numbers_result.affectedRows
            // Log only the remaining inserted IDs
            for (let j = 0; j < affectedRows; j++) {
              let current_id = first_insert_id + j;
              inserted_ids.push(current_id);
              logger_all.info(`Inserted ID: ${current_id}`);
            }
            insertId = insert_numbers_result.insertId;
          }

          logger_all.info(`Total Inserted IDs: ${JSON.stringify(inserted_ids)}`);

          await db.query(`UPDATE user_summary_report SET total_waiting = '0' ,total_process = '${valid_mobile_numbers.length}' where user_id = '${selected_user_id}' AND com_msg_id = '${campaign_id}'`);

          logger_all.info("[API RESPONSE] " + JSON.stringify({ response_code: 1, response_status: 200, response_msg: 'Initiated', request_id: request_id }))
          res.json({ response_code: 1, response_status: 200, response_msg: 'Initiated', request_id: request_id });

          const get_boardurl = await db.query(`SELECT board_url FROM sms_board_settings `);

          if (get_boardurl.length > 0) {
            apiKeyUrl = get_boardurl[0].board_url;
          }
          console.log(apiKeyUrl + "apiKeyUrl")

          await db.query(`UPDATE ${DB_NAME}_${selected_user_id}.compose_ucp_status_${selected_user_id} SET comsms_status = 'Q', sms_comments = 'SMS IN QUEUE' WHERE comsms_status_id in (${inserted_ids}) and comsms_status != 'S'`);


          async function sendSMS(apiAdminUser, apiAdminPswd, apiKeyUrl, tmpValu) {
            const sendData = {
              user: apiAdminUser,
              password: apiAdminPswd,
              taskCnt: tmpValu.length,
              tasks: tmpValu
            };

            console.log(JSON.stringify(sendData) + "sendData" + apiKeyUrl + "apiKeyUrl")

            try {

              // const response = await axios.post(apiKeyUrl, sendData, {
              //   headers: {
              //     'Content-Type': 'application/json; charset=utf-8'
              //   }
              // });
              const response = {
                data: {
                  result: "success",
                  message: "SMS sent successfully",
                  details: {
                    timestamp: "2025-01-28T10:00:00Z",
                    message_id: "12345"
                  }
                }
              };
              
              const responseObj = response.data;
              if (responseObj.result === 'success' || responseObj.result === 'ok') {
                logger_all.info('SMS sent successfully.');
              } else {
                logger_all.info('Failed to send SMS:', responseObj.result);
              }
            } catch (error) {
              console.error('Error Board Connection Failed:', error);
            }
          }
          console.log(valid_mobile_numbers.length + "valid_mobile_numbers.length")
          const batchSize = 60;//mobile numbers
          for (let i = 0; i < valid_mobile_numbers.length; i += batchSize) {
            console.log("coming loop")
            const batchNos = valid_mobile_numbers.slice(i, i + batchSize);
            const batchIds = inserted_ids.slice(i, i + batchSize);

            let tmp_valu = batchIds.map((id, index) => ({
              tid: id,
              mode: 0,
              to: batchNos[index],
              smsFormat: 0,
              chset: 0,
              "content/profile": message_content
            }));
            console.log(JSON.stringify(tmp_valu) + "tmp_valu")
            logger_all.info("&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&")
            // logger_all.info(apiAdminUser, apiAdminPswd, apiKeyUrl, tmp_valu+"apiAdminUser, apiAdminPswd, apiKeyUrl, tmp_valu")
            await sendSMS(apiAdminUser, apiAdminPswd, apiKeyUrl, tmp_valu);
          }
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
  "/reject_campaign_sms",
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

module.exports = router;