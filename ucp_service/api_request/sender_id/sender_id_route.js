/*
Routes are used in direct incoming API requests to backend resources.
It defines how our application should handle all the HTTP requests by the client.
This page is used to routing the senderids.

Version : 1.0
Author : Madhubala (YJ0009)
Date : 05-Jul-2023
*/
// Import the required packages and libraries
const express = require("express");
const router = express.Router();
// Import the senderid functions page
const addsenderid = require("./add_sender_id");
const manage_sender_id_list = require("./manage_sender_id_list");
const masterlanguage = require("./masterlanguage");
const approve_whatsapp_sender_id = require("./approve_senderid");
// Import the validation page
const AddSenderIdValidation = require("../../validation/sender_id_validation");
const deleteSenderIdValidation = require("../../validation/delete_senderid_validation");
const ManageSenderIdValidation = require("../../validation/manage_sender_idlist_validation");
const MasterLanguageValidation = require("../../validation/master_language");
const CountryListValidation = require("../../validation/country_list");
const UserApprovalValidation = require("../../validation/user_approval_validation");
// Import the default validation middleware
const validator = require('../../validation/middleware');
const valid_user = require("../../validation/valid_user_middleware");
const main = require('../../logger');
const db = require("../../db_connect/connect");

// add_sender_id - start
router.post(
    "/add_sender_id",
    validator.body(AddSenderIdValidation),
    valid_user,
    async function (req, res, next) {
        try {// access the AddSenderId function
            var logger = main.logger
            var logger_all = main.logger_all;

            var header_json = req.headers;
            let ip_address = header_json['x-forwarded-for'];

             await db.query(`INSERT INTO api_log VALUES(NULL, 0, '${req.originalUrl}', '${ip_address}', '${req.body.request_id}', 'N', '-', '0000-00-00 00:00:00', 'Y', CURRENT_TIMESTAMP)`);
            const check_req_id_result = await db.query(`SELECT * FROM api_log WHERE request_id = '${req.body.request_id}' AND response_status != 'N' AND api_log_status='Y'`);
            if (check_req_id_result.length != 0) {
                logger.info("[API RESPONSE] " + JSON.stringify({ request_id: req.body.request_id, response_code: 0, response_status: 201, response_msg: 'Request already processed' }))
                await db.query(`UPDATE api_log SET response_status = 'F',response_date = CURRENT_TIMESTAMP, response_comments = 'Request already processed' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);
                return res.json({ response_code: 0, response_status: 201, response_msg: 'Request already processed', request_id: req.body.request_id });
            }
            var result = await addsenderid.AddSenderId(req);
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
// add_sender_id - end

// delete_sender_id - start
router.delete(
    "/delete_sender_id",
    validator.body(deleteSenderIdValidation),
    valid_user,
    async function (req, res, next) {
        try {// access the deleteSenderId function
            var logger = main.logger
            var logger_all = main.logger_all;

            var header_json = req.headers;
            let ip_address = header_json['x-forwarded-for'];
            await db.query(`INSERT INTO api_log VALUES(NULL, 0, '${req.originalUrl}', '${ip_address}', '${req.body.request_id}', 'N', '-', '0000-00-00 00:00:00', 'Y', CURRENT_TIMESTAMP)`);
            const check_req_id_result = await db.query(`SELECT * FROM api_log WHERE request_id = '${req.body.request_id}' AND response_status != 'N' AND api_log_status='Y'`);

            if (check_req_id_result.length != 0) {
                logger.info("[API RESPONSE] " + JSON.stringify({ request_id: req.body.request_id, response_code: 0, response_status: 201, response_msg: 'Request already processed' }))
                const log_update_result = await db.query(`UPDATE api_log SET response_status = 'F',response_date = CURRENT_TIMESTAMP, response_comments = 'Request already processed' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);
                logger.silly("[update query response] : " + JSON.stringify(log_update_result))
                return res.json({ response_code: 0, response_status: 201, response_msg: 'Request already processed', request_id: req.body.request_id });
            }
            var result = await addsenderid.deleteSenderId(req);
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
// delete_sender_id - end


// sender_id_list - start
router.get(
    "/sender_id_list",
    validator.body(ManageSenderIdValidation),
    valid_user,
    async function (req, res, next) {
      try { // access the getNumbers function
        var logger = main.logger
  
        var result = await manage_sender_id_list.ManageSenderIdList(req);
         
        logger.info("[API RESPONSE] " + JSON.stringify(result))
  
        res.json(result);
      } catch (err) {// any error occurres send error response to client
        console.error(`Error while getting data`, err.message);
        next(err);
      }
    }
  );
  // sender_id_list - end
  
  // country_list -start
  router.get(
    "/country_list",
    validator.body(CountryListValidation),
    valid_user,
    async function (req, res, next) {
      try {// access the CountryList function
        var logger = main.logger
        var result = await manage_sender_id_list.CountryList(req);
  
        logger.info("[API RESPONSE] " + JSON.stringify(result))
  
        res.json(result);
      } catch (err) {// any error occurres send error response to client
        console.error(`Error while getting data`, err.message);
        next(err);
      }
    }
  );
  // country_list -end
  
  // service_category_list - start
  router.get(
    "/service_category_list",
    async function (req, res, next) {
      try {// access the ServiceCategoryList function
        var logger = main.logger
  
        var result = await manage_sender_id_list.ServiceCategoryList(req);
         
  
        logger.info("[API RESPONSE] " + JSON.stringify(result))
  
        res.json(result);
      } catch (err) {// any error occurres send error response to client
        console.error(`Error while getting data`, err.message);
        next(err);
      }
    }
  );
  // service_category_list - end
  
  // whatsapp_senderid -start
  router.get(
    "/master_language",
    validator.body(MasterLanguageValidation),
    valid_user,
    async function (req, res, next) {
      try {// access the MasterLanguage function
        var logger = main.logger
       var result = await masterlanguage.MasterLanguage(req);     
        logger.info("[API RESPONSE] " + JSON.stringify(result))
  
        res.json(result);
      } catch (err) { // any error occurres send error response to client
        console.error(`Error while getting data`, err.message);
        next(err);
      }
    }
  );
  // whatsapp_senderid -end
  
  // approveSenderID - start
router.post(
  "/approve_wht_senderid",
  validator.body(UserApprovalValidation),
  valid_user,
  async function (req, res, next) {
    try {
      const logger = main.logger;
      let result = await approve_whatsapp_sender_id.ApproveSenderId(req);
     if (!result) {
          result = { response_code: 1, response_status: 200, response_msg: 'Success' };
            }
      logger.info("[API RESPONSE] " + JSON.stringify(result));
      res.json(result);
    } catch (err) {
      console.error("Error while getting data", err.message);
      next(err);
    }
  }
);
// approveUser - End

module.exports = router;
