/*
Routes are used in direct incoming API requests to backend resources.
It defines how our application should handle all the HTTP requests by the client.
This page is used to routing the product menu.

Version : 1.0
Author : Selvalakshmi N (YJ0018)
Date : 03-DEC-2024
*/

const express = require("express");
const router = express.Router();
require("dotenv").config();
const getHeaderFile = require('./getHeader');
const create_template = require("./create_template");
const Template = require("./template_api")
const TemplateNumbers = require("./template_number_api");
const messengerviewresponse = require("./messengerviewresponse");
const messengerresponseupdate = require("./messengerresponseupdate");
const readstatusupdate = require("./readstatusupdate");
const Messenger_Response_List = require("./messenger_response_list");
const approve_template = require("../whatsapp_process/approve_template")
const ApproveTemplateList = require("../whatsapp_process/approve_template_list")
const ptemplatelist = require("./template_details_list");
// Validation Files start
const ApproveRejectTemplateValidation = require("../../validation/approve_reject_temlpate_validation");
const create_template_validation = require("../../validation/create_template_validation");
const getTemplateValidation = require("../../validation/common_user_id_validation");
const validator = require('../../validation/middleware')
const valid_user = require("../../validation/valid_user_middleware");
const main = require('../../logger');
const getTemplateNumberValidation = require("../../validation/get_template_number_validation");
const PTemplateListValidation = require("../../validation/p_tmpl_list_validation");
// DB connection
const db = require("../../db_connect/connect");
const dotenv = require('dotenv');
dotenv.config();
require('dotenv').config()
const env = process.env
const { use } = require("./route");
const api_url = env.API_URL;
const media_bearer = env.MEDIA_BEARER;
const axios = require('axios');
// Log file Generation based on the current date
var util = require('util');
var exec = require('child_process').exec;
const fs = require('fs');


// create_template - start
router.post(
  "/create_template",
  validator.body(create_template_validation),
  valid_user,
  async function (req, res, next) {
    try {
      const logger = main.logger;
      const result = await create_template.createtemplate(req);
      logger.info("[API RESPONSE] " + JSON.stringify(result));
      res.json(result);
    } catch (err) {
      console.error("Error while getting data", err.message);
      next(err);
    }
  }
);
// create_template - End

// approve_template - start
router.get(
  "/approve_template_list",
  // validator.body(),
  valid_user,
  async function (req, res, next) {
    try {// access the ApproveWhatsappNoApiList function
      var logger = main.logger
      var result = await ApproveTemplateList.approveTemplateList(req);
      logger.info("[API RESPONSE] " + JSON.stringify(result))

      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// approve_template - end

//approve_reject_template - start
router.post(
  "/approve_reject_template",
  validator.body(ApproveRejectTemplateValidation),
  valid_user,
  async function (req, res, next) {
    try {
const { logger_all, logger } = main;
      // get all the req data
      var change_status = req.body.change_status;
      var unique_template_id = req.body.template_id;
      var reject_reason = req.body.reject_reason;
      var succ_array = [], error_array = [], h_file;
      var count = 0;
      // query parameters
     logger.info("[ApproveRejectTemplate query parameters] : " + JSON.stringify(req.body));
      if (change_status == 'R') {
        // to check template_id and update the message_template table in template status and approve date.
        const update_template_status = await db.query(`UPDATE message_template SET template_status = '${change_status}', approve_date = CURRENT_TIMESTAMP,reject_reason = '${reject_reason}' WHERE unique_template_id = '${unique_template_id}'`);

        // if the update_template_status is '0' to send the 'No data available' message
        if (update_template_status.affectedRows) {
          return res.json({
            response_code: 1,
            response_status: 200,
            num_of_rows: update_template_status.affectedRows,
            response_msg: 'Success'
          });

        } else { // otherwise to send the 'Success' in response message.
          return res.json({
            response_code: 1,
            response_status: 204,
            response_msg: 'No data available'
          });
        }
      } else {
        // Using parameterized queries for safety against SQL injection
        const get_template = await db.query(`SELECT * FROM message_template WHERE unique_template_id = ? AND template_status = 'N'`, [unique_template_id]);

        // Mapping the template_ids and whatspp_config_ids
        const temp_insert_ids = get_template.map(row => row.template_id);
        const whatspp_config_ids = get_template.map(row => row.whatsapp_config_id);
        const media_urls = get_template.map(row => row.media_url);
        const media_types = get_template.map(row => row.media_type);

        // Assuming media_url and media_type are arrays you want to filter
        const unique_media_type = [...new Set(media_types)];
        const unique_media_url = [...new Set(media_urls)];
        console.log(unique_media_type);
        console.log(unique_media_url);
        // get the all sender number which are mapped to the user
        const mobile_number = await db.query(`SELECT whatspp_config_id, user_id, concat(country_code,mobile_no) mobile_no, bearer_token,phone_number_id,whatsapp_business_acc_id FROM whatsapp_config where whatspp_config_id in ('${whatspp_config_ids}') and whatspp_config_status = 'Y'`);

        // Extract separate arrays for each field
        const sender_number = mobile_number.map(row => row.mobile_no);
        const sender_number_bearer_token = mobile_number.map(row => row.bearer_token);
        const sender_number_business_id = mobile_number.map(row => row.whatsapp_business_acc_id);

        if (mobile_number.length == 0) {
          logger.info("[API RESPONSE] " + JSON.stringify({ response_code: 0, response_status: 201, response_msg: 'No number available', request_id: req.body.request_id }))
        }
        else {

          // loop fo all the sender_number the user have
          for (var i = 0; i < mobile_number.length; i++) {
            const { template_id, language_id, template_category, template_name: temp_name } = get_template[0];
            let temp_components =  get_template[0].template_message;
            // check if the language is in our db 
            const select_lang = await db.query(`SELECT * from master_language WHERE language_id = '${language_id}' AND language_status = 'Y'`);
            // const language = select_lang.map(row => row.language_code);
            const language = select_lang[0].language_code;
            // if no sender_number found send error response to the client
            if (sender_number.length == 0) {
              logger.info("[API RESPONSE] " + JSON.stringify({ response_code: 0, response_status: 201, response_msg: 'No number available or Language not available', request_id: req.body.request_id }))
              await db.query(`UPDATE api_log SET response_status = 'F',response_date = CURRENT_TIMESTAMP, response_comments = 'No number available or language not available' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);

              res.json({ response_code: 0, response_status: 201, response_msg: 'No number available or Language not available', request_id: req.body.request_id });
            }
            else {
              // if media is in template
              if (unique_media_url[0] != null) {
                // if receive unique_media_url get the media type of the media
                h_file = await getHeaderFile.getHeaderFile(unique_media_url[0]);
                // get the header_handle value for the media
                var command = `curl -X POST \
                      "${api_url}${h_file[0]}" \
                      --header "Authorization: OAuth ${media_bearer}" \
                      --header "file_offset: 0" \
                      --data-binary @${h_file[1]}`

                child = exec(command, async function (error, stdout, stderr) {

                  logger_all.info(' stdout: ' + stdout);
                  logger_all.info(' stderr: ' + stderr);

                  var curl_output = JSON.parse(stdout);
                  // add media json block in components
                  temp_components.push({
                    "type": "HEADER",
                    "format": unique_media_type[0],
                    "example": { "header_handle": [curl_output.h] }
                  })

                  fs.unlinkSync(h_file[1]);

                  // loop for the sender numbers in the user to request template for all sender numbers
                  for (var i = 0; i < sender_number.length; i++) {
                    // api url will have the sender number's whatsapp business acc id
                    api_url_updated = `${api_url}${sender_number_business_id[i]}/message_templates`
                    // json for request template
                    var data = {
                      name: temp_name,
                      language: language,
                      category: template_category,
                      components: JSON.parse(temp_components)
                    };

                    var temp_msg = {
                      method: 'post',
                      url: api_url_updated,
                      headers: {
                        'Authorization': 'Bearer ' + sender_number_bearer_token[i],
                      },
                      params: data
                    };

                    logger_all.info("[template approval request] : " + JSON.stringify(temp_msg))
                    
                    await axios(temp_msg)
                      .then(async function (response) {
                        logger_all.info("[template approval success number] : " + sender_number[i] + " - " + util.inspect(response.data))
                        // push the success template in succ_template
                        succ_array.push({ mobile_number: sender_number[i], template_id: unique_template_id, template_name: temp_name })
                        // if successfully requested, then update the template status and template id
                        await db.query(`UPDATE message_template SET template_response_id = '${response.data.id}', template_status = 'S',template_message = '${JSON.stringify(temp_components)}',approve_date = CURRENT_TIMESTAMP WHERE template_id = ${temp_insert_ids[i]}`);
                        // increment the counter
                        count++;
                        // check if this is the last sender number, so we can send response to client
                        if (count == sender_number.length) {
                          res_send();
                        }

                      })
                      .catch(async function (error) {
                        logger_all.info("[template approval failed number] : " + sender_number[i] + " - " + error)
                        // push the failed template in failed_template array
                        error_array.push({ mobile_number: sender_number[i], reason: error.message })
                        // if any error or failure, update the template status as F
                        await db.query(`UPDATE message_template SET template_status = 'F' WHERE template_id = ${temp_insert_ids[i]}`);
                        // increment the counter
                        count++;
                        // check if this is the last sender number, so we can send response to client
                        if (count == sender_number.length) {
                          res_send();
                        }
                      })
                  }
                  // if got error when get header_handle, all template request will fail. push the all number in failed_array
                  if (error !== null) {
                    logger_all.info("[upload file failed number] : " + error)
                    for (var f = 0; f < temp_insert_ids; f++) {
                      await db.query(`UPDATE message_template SET template_status = 'F' WHERE template_id = ${temp_insert_ids[f]}`);
                      error_array.push({ mobile_number: sender_number[f], reason: 'Image upload failed' })
                    }
                    res_send();
                  }
                });
              }
              // if media is not in template
              else {
                // loop for the sender numbers in the user to request template for all sender numbers
                for (var i = 0; i < sender_number.length; i++) {
                  // api url will have the sender number's whatsapp business acc id
                  api_url_updated = `${api_url}${sender_number_business_id[i]}/message_templates`
                  // json for request template
                  var data = {
                    name: temp_name,
                    language: language,
                    category: template_category,
                    components: JSON.parse(temp_components)
                  };
                  var temp_msg = {
                    method: 'post',
                    url: api_url_updated,
                    headers: {
                      'Authorization': 'Bearer ' + sender_number_bearer_token[i],
                    },
                    params: data
                  };

                  logger_all.info("[template approval request] : " + JSON.stringify(temp_msg))
                  await axios(temp_msg)
                    .then(async function (response) {
                      logger_all.info("[template approval success number] : " + sender_number[i] + " - " + util.inspect(response.data))
                      // push the success template in succ_template
                      succ_array.push({ mobile_number: sender_number[i], template_id: unique_template_id, template_name: temp_name })
                      // if successfully requested, then update the template status and template id
                      await db.query(`UPDATE message_template SET template_response_id = '${response.data.id}', template_status = 'S',template_message = '${JSON.stringify(temp_components)}',approve_date = CURRENT_TIMESTAMP WHERE template_id = ${temp_insert_ids[i]}`);
                      // increment the counter
                      count++
                      // check if this is the last sender number, so we can send response to client
                      if (count == sender_number.length) {
                        res_send()
                      }
                    })
                    .catch(async function (error) {
                      logger_all.info("[template approval failed number] : " + sender_number[i] + " - " + error)
                      // push the failed template in failed_template array
                      error_array.push({ mobile_number: sender_number[i], reason: error.message })
                      // if any error or failure, update the template status as F
                      await db.query(`UPDATE message_template SET template_status = 'F' WHERE template_id = ${temp_insert_ids[i]}`);
                      // increment the counter
                      count++
                      // check if this is the last sender number, so we can send response to client
                      if (count == sender_number.length) {
                        res_send()
                      }
                    })
                }
              }
            }
          }
        }
      }
      // function to send response to the client
      async function res_send() {
        logger.info("[API RESPONSE] " + JSON.stringify({ response_code: 1, response_status: 200, response_msg: 'Success ', success: succ_array, failure: error_array, request_id: req.body.request_id }))
        await db.query(`UPDATE api_log SET response_status = 'S',response_date = CURRENT_TIMESTAMP, response_comments = 'Success' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);
        res.json({ response_code: 1, response_status: 200, response_msg: 'Success ', success: succ_array, failure: error_array, request_id: req.body.request_id });
      }
    }
    catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// approve_reject_template - end


// get_template - start
router.get(
  "/get_template",
  validator.body(getTemplateValidation),
  valid_user,
  async function (req, res, next) {
    try {// access the getTemplate function
      var logger = main.logger
      var result = await Template.getTemplate(req);
      logger.info("[API RESPONSE] " + JSON.stringify(result))
      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// get_template - end

// get_template_numbers - start
router.post(
  "/get_template_numbers",
  validator.body(getTemplateNumberValidation),
  valid_user,
  async function (req, res, next) {
    try {// access the CampaignReport function
      var logger = main.logger
      var result = await TemplateNumbers.getTemplateNumber(req);
      logger.info("[API RESPONSE] " + JSON.stringify(result))
      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// get_template_numbers - end

// p_get_template_numbers - start
router.get(
  "/p_get_template_numbers",
  validator.body(getTemplateNumberValidation),
  valid_user,
  async function (req, res, next) {
    try {// access the CampaignReport function
      var logger = main.logger
      var result = await TemplateNumbers.PgetTemplateNumber(req);
      logger.info("[API RESPONSE] " + JSON.stringify(result))
      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// messenger_view_response - start
router.post(
  "/messenger_view_response",
  // validator.body(MessengerViewResponseValidation),
  valid_user,
  async function (req, res, next) {
    try { // access the MessengerViewResponse function
      var logger = main.logger

      var result = await messengerviewresponse.MessengerViewResponse(req);
       
      logger.info("[API RESPONSE] " + JSON.stringify(result))

      res.json(result);
    } catch (err) { // any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// messenger_view_response - end
// messenger_response_update - start
router.post(
  "/messenger_response_update",
  // validator.body(MessengerResponseUpdateValidation),
  valid_user,
  async function (req, res, next) {
    try { // access the MessengerResponseUpdate function
      var logger = main.logger

      var result = await messengerresponseupdate.MessengerResponseUpdate(req);
       
      logger.info("[API RESPONSE] " + JSON.stringify(result))

      res.json(result);
    } catch (err) { // any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// messenger_response_update - end
// read_status_update -start
router.post(
  "/read_status_update",
  // validator.body(Read_status_validation),
  valid_user,
  async function (req, res, next) {
    try { // access the ReadStatusUpdate function
      var logger = main.logger

      var result = await readstatusupdate.ReadStatusUpdate(req);
       
      logger.info("[API RESPONSE] " + JSON.stringify(result))

      res.json(result);
    } catch (err) { // any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// read_status_update - end

// messenger_response_list - start
router.get(
    "/messenger_response_list",
    //validator.body(MessengerResponseListValidation),
    valid_user,
    async function (req, res, next) {
        try {// access the MessengerResponseList function
            var logger = main.logger
            var result = await Messenger_Response_List.MessengerResponseList(req);
            logger.info("[API RESPONSE] " + JSON.stringify(result))
            res.json(result);
        } catch (err) {// any error occurres send error response to client
            console.error(`Error while getting data`, err.message);
            next(err);
        }
    }
);


  // template_list - start
  router.get(
    "/template_list",
    validator.body(PTemplateListValidation),
    valid_user,
    async function (req, res, next) {
      try {// access the PTemplateList 
        var logger = main.logger
  
        var result = await ptemplatelist.PTemplateList(req);
         
  
        logger.info("[API RESPONSE] " + JSON.stringify(result))
  
        res.json(result);
      } catch (err) {// any error occurres send error response to client
        console.error(`Error while getting data`, err.message);
        next(err);
      }
    }
  );
  // template_list - end
  
  // check_sender_id - start
  router.get(
    "/check_sender_id",
    async function (req, res, next) {
      try {// access the ViewOnboarding function
        var logger = main.logger
  
        var result = await ptemplatelist.CheckSenderId(req);
  
        logger.info("[API RESPONSE] " + JSON.stringify(result))
  
        res.json(result);
      } catch (err) {// any error occurres send error response to client
        console.error(`Error while getting data`, err.message);
        next(err);
      }
    }
  );
  // check_sender_id - end
  
// messenger_response_list - end
module.exports = router;
