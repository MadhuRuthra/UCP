const express = require("express");
const smpp = require("smpp");
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
//const ComposeSMS = require("./compose_smpp");
const ComposeSMPP = require("./compose_smpp");
const RejectCampaign = require("./reject_smpp_campaign");
const compose_smpp_validation = require("../../validation/compose_smpp_validation")
const ComposeSmsValidation = require("../../validation/send_message_validation");
const main = require('../../logger');
const axios = require('axios');

dotenv.config();
require("dotenv").config();
const env = process.env;
const DB_NAME = env.DB_NAME;
const apiAdminUser = process.apiAdminUser;
const apiAdminPswd = env.apiAdminPswd;
const fse = require('fs-extra');

// Compose_SMPP - start
router.post(
  "/smpp_compose",
  validator.body(compose_smpp_validation),
  valid_user,
  async (req, res, next) => {
    try {
      const logger = main.logger;
      const logger_all = main.logger_all;
      const result = await ComposeSMPP.ComposeSMPP(req);
      res.json(result);
    } catch (err) {
      console.error(`Error while composing SMS: ${err.message}`);
      next(err);
    }
  }
);
// Compose_SMPP - end

// Approve_compose_sms - start
router.post("/approve_composesmpp", valid_user,
  async (req, res, next) => {
    try {
      const logger = main.logger;
      const logger_all = main.logger_all;
      const { campaign_id, selected_user_id: selected_user_id, request_id } = req.body;
      // let url, system_id, password;
      smpp.addTLV("Pe_Id", {
        id: 5120,
        type: smpp.types.tlv.string,
      });

      smpp.addTLV("Telemarketer_ID", {
        id: 5122,
        type: smpp.types.tlv.string,
      });

      smpp.addTLV("Header_Id", {
        id: 5123,
        type: smpp.types.tlv.string,
      });

      smpp.addTLV("Template_ID", {
        id: 5121,
        type: smpp.types.tlv.string,
      });
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
      let response_array = [];
      const valid_mobile_numbers = [], push_name_and_values = [], media_url_array = [], media_type_array = [], file_names_array = [];
      let transactionIdString = [], corelationId = [];

      const get_user_det = await db.query(`SELECT * FROM compose_smpp where user_id = '${selected_user_id}' AND compose_ucp_id = '${campaign_id}' AND ucp_status = 'W'`);

      //Check if selected data is equal to zero, send failuer response 'Compose ID Not Available'
      if (get_user_det.length == 0) {
        const update_api_log = await db.query(`UPDATE api_log SET response_status = 'F',response_date = CURRENT_TIMESTAMP,response_comments = 'Compose ID Not Available.' WHERE request_id = '${request_id}' AND response_status = 'N'`);
        const composeid_msg = { response_code: 0, response_status: 201, response_msg: 'Compose ID Not Available', request_id: request_id }

        return res.json(composeid_msg);
      }
      const { campaign_name, file_path, message_content, content_char_count, total_mobile_no_count } = get_user_det[0];
      let insert_id_array = [];

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
          //Insert compose details to compose_msg_status table
          let insert_numbers = ""
          insert_numbers = `INSERT INTO ${DB_NAME}_${selected_user_id}.compose_smpp_status_${selected_user_id} VALUES`;
          let insertId;
          let inserted_ids = [];
          //Loop for receiver numbers
          if (valid_mobile_numbers.length === 0) {
            logger_all.info("[API RESPONSE] " + JSON.stringify({ response_code: 0, response_status: 201, response_msg: 'Failed', request_id: request_id }))
            return res.json({ response_code: 0, response_status: 201, response_msg: 'Failed', request_id: request_id });
          }

          await db.query(`UPDATE compose_smpp SET ucp_status = "P",ucp_start_date = CURRENT_TIMESTAMP WHERE compose_ucp_id = '${campaign_id}' AND user_id = '${selected_user_id}'AND ucp_status = "W"`);

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
              insert_numbers = `INSERT INTO ${DB_NAME}_${selected_user_id}.compose_smpp_status_${selected_user_id} VALUES`;
            }
            insert_count = insert_count + 1;
            k++;
          }

          //After the loops complete, this if statement checks if any pending insert queries are left to be executed. If so, it executes
          if (insert_numbers !== `INSERT INTO ${DB_NAME}_${selected_user_id}.compose_smpp_status_${selected_user_id} VALUES`) {
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
          async function submitMessages(session, valid_mobile_numbers, message_content) {
            for (let k = 0; k < valid_mobile_numbers.length; k++) {
              await session.submit_sm({
                source_addr: "CLMOTP",
                source_addr_ton: 5,
                dest_addr_npi: 1,
                dest_addr_ton: 1,
                destination_addr: valid_mobile_numbers[k],
                Telemarketer_ID: "1502642990000010001",
                Header_Id: "1505165418264130157",
                Pe_Id: "1501610690000041673",
                Template_ID: "1507165426192695458",
                short_message: message_content
              });
            }
          }

          const session = smpp.connect({
            url: "smpp://152.67.11.66:5004",
            auto_enquire_link_period: 5000,
            debug: true
          }, async function () {
            await session.bind_transceiver({
              system_id: "celebdtr",
              password: "gFaBuABf",
            }, async function (bind_pdu) {
              console.log(bind_pdu);
              logger_all.info("Bind_pdu ---->", bind_pdu);

              if (bind_pdu.command_status === 0) {
                // Successfully bound
                console.log("Successfully bound. Starting message submission.");

                // Call the function to submit messages after binding is successful
                await submitMessages(session, valid_mobile_numbers, message_content);

                // Set up the deliver_sm event handler to process the response
                session.on("deliver_sm", async function (deliver_pdu) {
                  let stat = '';
                  let err = '';

                  // Check if the message contains a valid "short_message" field
                  if (deliver_pdu.short_message && deliver_pdu.short_message.message) {
                    const messageParts = deliver_pdu.short_message.message.split(" ");

                    // Loop through the message parts to find "stat" and "err"
                    messageParts.forEach(part => {
                      if (part.startsWith("stat:")) {
                        stat = part.split(":")[1];
                      }
                      if (part.startsWith("err:")) {
                        err = part.split(":")[1];
                      }
                    });

                    console.log("Status (stat):", stat);
                    console.log("Error (err):", err);

                    // Determine the comsmpp_status based on the error code
                    let comsmpp_status = err === "000" ? 'S' : 'F';
                    console.log("********", comsmpp_status.length)
                    // Perform the database update query
                    await db.query(`
                      UPDATE ${DB_NAME}_${selected_user_id}.compose_smpp_status_${selected_user_id}
                      SET comsmpp_status = '${comsmpp_status}', smpp_comments = "${stat}"
                      WHERE comsmpp_status_id IN (${inserted_ids}) 
                      AND comsmpp_status != 'S'`
                    );


                    // Send the deliver_sm_resp
                    if (deliver_pdu) {
                      session.deliver_sm_resp(deliver_pdu);
                      console.log("Delivery response sent successfully");
                      logger_all.info("Delivery response sent successfully");
                    } else {
                      logger_all.info("Invalid PDU received, cannot send response.");
                    }
                    // Clear the auto_enquire_link_period interval after processing is complete
                    //(enquireLinkInterval);
                    session.close(); // Optionally, you can close the session as well
                    console.log("Enquire link interval cleared, session closed.");
                    logger_all.info("Enquire link interval cleared, session closed.");
                  }
                });
              } 
            });
          });
          await db.query(`UPDATE compose_smpp SET ucp_status = "V",ucp_end_date = CURRENT_TIMESTAMP WHERE compose_ucp_id = '${campaign_id}' AND user_id = '${selected_user_id}'AND ucp_status = "P"`);



          logger_all.info("[API RESPONSE] " + JSON.stringify({ response_code: 1, response_status: 200, response_msg: 'Initiated', request_id: request_id }))
          res.json({ response_code: 1, response_status: 200, response_msg: 'Initiated', request_id: request_id });

        });
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
  "/reject_campaign_smpp",
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