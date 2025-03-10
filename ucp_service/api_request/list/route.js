
// Import the required packages and libraries
const express = require("express");
const router = express.Router();
const createCsvWriter = require('csv-writer').createObjectCsvWriter;

const fs = require('fs');
const moment = require('moment');
const csv = require('csv-parser');
const path = require('path');
const db = require('../../db_connect/connect');
const validator = require('../../validation/middleware')

const valid_user = require("../../validation/valid_user_middleware");

const dotenv = require('dotenv');
dotenv.config();
require('dotenv').config()
const env = process.env
const ComposesmppList = require("./compose_smpp_list")
const Approve_composesmpp_list = require("./approve_compose_smpplist");
const Product_Name = require("./products_name");
const view_user = require("./view_user");
const deleteTemplate = require("./delete_template");
const changepassword = require("./changepassword");
const login_time_list = require("./login_time_list");
const Manage_users_ist = require("./manageuserslist");
const message_type=  require("./message_type");
const business_category = require("./business_category");
const preview_senderid_consent = require("./preview_senderid_consent")
const sender_business_category = require("./sender_business_category")
const approve_reject_onboarding = require("./approve_rej_onboarding");
const Waiting_Approval_List = require("./waiting_approval_list");
const approve_templatelist = require("./approve_templatelist");
const cmnts_senderid = require("./cmnts_senderid")
const content_template_business = require('./content_template_business');
const UserMaster = require("./user_master");
// Validation File starts
const TemplateListValidationSMPP = require("../../validation/template_list_smpp")
const main = require('../../logger');
const ViewuserValidation = require("../../validation/view_user_validation");
const ChangePasswordValidation = require("../../validation/change_password");
const LoginTimeListValidation = require("../../validation/login_time");
const approve_reject_onboarding_validation = require("../../validation/approve_reject_onboarding");
const UseridValidation = require("../../validation/user_id_optional_validation");
const deleteTemplateValidation = require("../../validation/delete_template_validation");
const save_senderid_validation = require("../../validation/save_senderid_validation");
const previwe_senderid_validation = require("../../validation/previwe_senderid_validation")
const cmnts_senderid_validation = require("../../validation/cmnts_senderid_validation");
const cmnts_consentid_validation = require("../../validation/cmnts_consentid_validation");
const previwe_cmsenderid_validation =  require("../../validation/previwe_cmsenderid_validation");
const cmnts_contentid_validation = require("../../validation/cmnts_contentid_validation");
const get_content_tmpl_validation = require("../../validation/get_content_tmpl_validation");
const select_compose_messageType_validation = require("../../validation/select_compose_messageType_validation");

// User Master - start
router.get(
  "/user_master",
  // validator.body(),
  valid_user,
  async function (req, res, next) {
    try {// access the ApproveWhatsappNo function
      var logger = main.logger

      var result = await UserMaster.User_Master(req);
       

      logger.info("[API RESPONSE] " + JSON.stringify(result))

      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// user_master - end

//compose_smpp_list - start
router.get(
  "/compose_smpp_list",
  validator.body(TemplateListValidationSMPP),
  valid_user,
  async function (req, res, next) {
    try {// access the ComposeSMPPList function
      let logger = main.logger

      let result = await ComposesmppList.ComposeSMPPList(req);


      logger.info("[API RESPONSE] " + JSON.stringify(result))

      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
//compose_smpp_list - end

// Approve_compose_smpp - start
router.get(
  "/approve_composesmpp_list",
  validator.body(),
  valid_user,
  async function (req, res, next) {
    try {// access the approve_composesms_list function
      let logger = main.logger

      let result = await Approve_composesmpp_list.Approve_ComposeSMPP_List(req)


      logger.info("[API RESPONSE] " + JSON.stringify(result))

      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// Approve_compose_smpp - end


// Start route for getting a list of products_name
router.get(
  "/products_name",
  validator.body(UseridValidation),
  valid_user,
  async function (req, res, next) {
    try {
      var logger = main.logger
      var logger_all = main.logger_all

      // Call the 'products_name' function from the List module to get a list of products_name
      var result = await Product_Name.product_name(req);
      logger.info("[API RESPONSE - country list] " + JSON.stringify(result))
      // Send the response in JSON
      res.json(result);
    } catch (err) {
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// End route for getting a list of products_name


// Start route for view user
router.get(
  "/view_user",
  validator.body(ViewuserValidation),
  // valid_user,
  async function (req, res, next) {
    try {// access the ViewUser function
      var logger = main.logger

      var result = await view_user.ViewUser(req);

      logger.info("[API RESPONSE] " + JSON.stringify(result))

      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// End route for view user

// change_password - start
router.post(
  "/change_password",
  validator.body(ChangePasswordValidation),
  valid_user,
  async function (req, res, next) {
    try {// access the ChangePassword function
      let logger = main.logger

      let logger_all= main.logger_all;

      const header_json= req.headers;
      let ip_address = header_json['x-forwarded-for'];

      const insert_api_log_result = await db.query(`INSERT INTO api_log VALUES(NULL,0,'${req.originalUrl}','${ip_address}','${req.body.request_id}','N','-','0000-00-00 00:00:00','Y',CURRENT_TIMESTAMP)`);

      const check_req_id_result = await db.query(`SELECT * FROM api_log WHERE request_id = '${req.body.request_id}' AND response_status != 'N' AND api_log_status='Y'`);

      if (check_req_id_result.length != 0) {

        logger_all.info("[failed response] : Request already processed");
        logger.info("[API RESPONSE] " + JSON.stringify({ request_id: req.body.request_id, response_code: 0, response_status: 201, response_msg: 'Request already processed' }))

        const log_update_result = await db.query(`UPDATE api_log SET response_status = 'F',response_date = CURRENT_TIMESTAMP, response_comments = 'Request already processed' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);

        return res.json({ response_code: 0, response_status: 201, response_msg: 'Request already processed', request_id: req.body.request_id });

      }

      let result = await changepassword.ChangePassword(req);

      result['request_id'] = req.body.request_id;

      if (result.response_code == 0) {
        const update_api_log = await db.query(`UPDATE api_log SET response_status = 'F',response_date = CURRENT_TIMESTAMP, response_comments = '${result.response_msg}' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);
      }
      else {
        const update_api_log = await db.query(`UPDATE api_log SET response_status = 'S',response_date = CURRENT_TIMESTAMP, response_comments = 'Success' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);
      }

      logger.info("[API RESPONSE] " + JSON.stringify(result))

      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// change_password - end

// login_time - start
router.post(
  "/login_time",
  async function (req, res, next) {
    try {// access the LoginTimeList function
      let logger = main.logger

      let result = await login_time_list.LoginTimeList(req);

      logger.info("[API RESPONSE] " + JSON.stringify(result))

      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// login_time - end


// Start route for getting a list of ManageUsersList
router.get(
  "/manage_users_list",
  validator.body(UseridValidation),
  valid_user,
  async function (req, res, next) {
    try {
      var logger = main.logger
      var logger_all = main.logger_all

      // Call the 'ManageUsersList' function from the List module to get a list of ManageUsersList
      var result = await Manage_users_ist.ManageUsersList(req);
      logger.info("[API RESPONSE - ManageUsersList] " + JSON.stringify(result))
      // Send the response in JSON
      res.json(result);
    } catch (err) {
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// End route for getting a list of ManageUsersList


// mc_receiver_user - start
router.get(
  "/slt_receiver_user",
  validator.body(UseridValidation),
  valid_user,
  async function (req, res, next) {
    try {// access the MCReceiverUser function

      var result = await mcreceiveruser.MCReceiverUser(req);

      logger.info("[API RESPONSE] " + JSON.stringify(result))

      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// mc_receiver_user - end


// approve_reject_onboarding - start
router.post(
  "/approve_reject_onboarding",
  validator.body(approve_reject_onboarding_validation),
  valid_user,
  async function (req, res, next) {
    try { // access the approve_reject_onboarding function
      var logger = main.logger
      var logger_all = main.logger_all;
      var result = await approve_reject_onboarding.ApproveRejectOnboarding(req);

      result['request_id'] = req.body.request_id;

      //update api log for failure response
      if (result.response_code == 0) {
        logger.silly("[update query request] : " + `UPDATE api_log SET response_status = 'F',response_date = CURRENT_TIMESTAMP, response_comments = '${result.response_msg}' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);
        const update_api_log = await db.query(`UPDATE api_log SET response_status = 'F',response_date = CURRENT_TIMESTAMP, response_comments = '${result.response_msg}' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);
        logger.silly("[update query response] : " + JSON.stringify(update_api_log))
      } else {
        //Otherwise update api log with success response
        logger.silly("[update query request] : " + `UPDATE api_log SET response_status = 'S',response_date = CURRENT_TIMESTAMP, response_comments = 'Success' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);
        const update_api_log = await db.query(`UPDATE api_log SET response_status = 'S',response_date = CURRENT_TIMESTAMP, response_comments = 'Success' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);
        logger.silly("[update query response] : " + JSON.stringify(update_api_log))
      }

      logger.info("[API RESPONSE] " + JSON.stringify(result))
      res.json(result);

    } catch (err) { // any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// approve_reject_onboarding - End




// delete_template_smpp - start
router.delete(
  "/delete_template_smpp",
  validator.body(deleteTemplateValidation),
  valid_user,
  async function (req, res, next) {
    try {// access the CampaignReport function
      const logger = main.logger
      const logger_all = main.logger_all;

      const header_json = req.headers;
      const ip_address = header_json['x-forwarded-for'];

      const insert_api_log_result = await db.query(`INSERT INTO api_log VALUES(NULL,0,'${req.originalUrl}','${ip_address}','${req.body.request_id}','N','-','0000-00-00 00:00:00','Y',CURRENT_TIMESTAMP)`);

      const check_req_id_result = await db.query(`SELECT * FROM api_log WHERE request_id = '${req.body.request_id}' AND response_status != 'N' AND api_log_status='Y'`);

      if (check_req_id_result.length != 0) {

        logger_all.info("[failed response] : Request already processed");
        logger.info("[API RESPONSE] " + JSON.stringify({ request_id: req.body.request_id, response_code: 0, response_status: 201, response_msg: 'Request already processed' }))

        const log_update_result = await db.query(`UPDATE api_log SET response_status = 'F',response_date = CURRENT_TIMESTAMP, response_comments = 'Request already processed' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);

        return res.json({ response_code: 0, response_status: 201, response_msg: 'Request already processed', request_id: req.body.request_id });

      }


      let result = await deleteTemplate.delete_template_smpp(req);

      result['request_id'] = req.body.request_id;

      if (result.response_code == 0) {
        const update_api_log = await db.query(`UPDATE api_log SET response_status = 'F',response_date = CURRENT_TIMESTAMP, response_comments = '${result.response_msg}' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);
      }
      else {
        const update_api_log = await db.query(`UPDATE api_log SET response_status = 'S',response_date = CURRENT_TIMESTAMP, response_comments = 'Success' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);
      }

      logger.info("[API RESPONSE] " + JSON.stringify(result))
      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// delete_template_smpp - end

// waiting_approval_list - start
router.get(
  "/waiting_approval_list",
  async function (req, res, next) {
    try {// access the activation_payment function
      let logger = main.logger

      let result = await Waiting_Approval_List.WaitingApprovalList(req);

      logger.info("[API RESPONSE] " + JSON.stringify(result))

      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// waiting_approval_list - end


// message_type - start
router.post(
  "/message_type",
  valid_user,
  async function (req, res, next) {
    try {// access the AvailableCreditsList function
      var logger = main.logger

      var result = await message_type.MessageType(req);

      logger.info("[API RESPONSE] " + JSON.stringify(result))

      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// message_type - end


// business_category - start
router.post(
  "/business_category",
  validator.body(save_senderid_validation),
  valid_user,
  async function (req, res, next) {
    try {// access the AvailableCreditsList function
      var logger = main.logger

      var result = await business_category.BusinessCategory(req);

      logger.info("[API RESPONSE] " + JSON.stringify(result))

      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// business_category - end


// business_category - start
router.post(
  "/sender_business_category",
  validator.body(save_senderid_validation),
  valid_user,
  async function (req, res, next) {
    try {// access the AvailableCreditsList function
      var logger = main.logger

      var result = await sender_business_category.SenderBusinessCategory(req);

      logger.info("[API RESPONSE] " + JSON.stringify(result))

      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// business_category - end

// preview_senderid_consent - start
router.post(
  "/preview_senderid_consent",
  validator.body(previwe_senderid_validation),
  valid_user,
  async function (req, res, next) {
    try {// access the preview_senderid_consent function
      var logger = main.logger

      var result = await preview_senderid_consent.PreviewSenderidConsent(req);

      logger.info("[API RESPONSE] " + JSON.stringify(result))

      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// preview_senderid_consent - end

// select_message_type - start
router.post(
  "/select_message_type",
  validator.body(previwe_senderid_validation),
  valid_user,
  async function (req, res, next) {
    try {// access the select_message_type function
      var logger = main.logger

      var result = await preview_senderid_consent.select_message_type(req);

      logger.info("[API RESPONSE] " + JSON.stringify(result))

      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// select_message_type - end

// select_message_type - start
router.post(
  "/cm_senter_id",
  validator.body(previwe_cmsenderid_validation),
  valid_user,
  async function (req, res, next) {
    try {// access the select_message_type function
      var logger = main.logger

      var result = await preview_senderid_consent.CmSenterId(req);

      logger.info("[API RESPONSE] " + JSON.stringify(result))

      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// select_message_type - end

// select_cm_consent_id - start
router.post(
  "/select_cm_consent_id",
  validator.body(previwe_cmsenderid_validation),
  valid_user,
  async function (req, res, next) {
    try {// access the select_message_type function
      var logger = main.logger

      var result = await preview_senderid_consent.selectcmconsentid(req);

      logger.info("[API RESPONSE] " + JSON.stringify(result))

      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// select_cm_consent_id - end

// approve_templatelist - start
router.post(
  "/approve_templatelist",
  valid_user,
  async function (req, res, next) {
    try {// access the approve_templatelist function
      var logger = main.logger

      var result = await approve_templatelist.ApproveTemplateList(req);

      logger.info("[API RESPONSE] " + JSON.stringify(result))

      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// approve_templatelist - end

//consent_approval - start
router.post(
  "/consent_approval",
  valid_user,
  async function (req, res, next) {
    try {// access the consent_approval function
      var logger = main.logger

      var result = await approve_templatelist.ConsentApproval(req);

      logger.info("[API RESPONSE] " + JSON.stringify(result))

      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// approve_templatelist - end

//content_approval - start
router.post(
  "/content_approval",
  valid_user,
  async function (req, res, next) {
    try {// access the content_approval function
      var logger = main.logger

      var result = await approve_templatelist.ContentApproval(req);

      logger.info("[API RESPONSE] " + JSON.stringify(result))

      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// content_approval - end


//cmnts_senderid - start
router.post(
  "/cmnts_senderid",
  validator.body(cmnts_senderid_validation),
  valid_user,
  async function (req, res, next) {
    try {// access the cmnts_senderid function
      var logger = main.logger

      var result = await cmnts_senderid.CmntsSenderid(req);

      logger.info("[API RESPONSE] " + JSON.stringify(result))

      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// cmnts_senderid - end

//update_cmnts_senderid - start
router.post(
  "/update_cmnts_senderid",
  validator.body(cmnts_senderid_validation),
  valid_user,
  async function (req, res, next) {
    try {// access the update_cmnts_senderid function
      var logger = main.logger

      var result = await cmnts_senderid.UpdateCmntsSenderid(req);

      logger.info("[API RESPONSE] " + JSON.stringify(result))

      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// cmnts_senderid - end

//cmnts_consentid - start
router.post(
  "/cmnts_consentid",
  validator.body(cmnts_consentid_validation),
  valid_user,
  async function (req, res, next) {
    try {// access the cmnts_consentid function
      var logger = main.logger

      var result = await cmnts_senderid.CmntsConsentid(req);

      logger.info("[API RESPONSE] " + JSON.stringify(result))

      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// cmnts_senderid - end

//update_cmnts_consentid - start
router.post(
  "/update_cmnts_consentid",
  validator.body(cmnts_consentid_validation),
  valid_user,
  async function (req, res, next) {
    try {// access the update_cmnts_consentid function
      var logger = main.logger

      var result = await cmnts_senderid.UpdateCmntsConsentid(req);

      logger.info("[API RESPONSE] " + JSON.stringify(result))

      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// update_cmnts_senderid - end

//cmnts_contentid - start
router.post(
  "/cmnts_contentid",
  validator.body(cmnts_contentid_validation),
  valid_user,
  async function (req, res, next) {
    try {// access the cmnts_contentid function
      var logger = main.logger

      var result = await cmnts_senderid.cmnts_contentid(req);

      logger.info("[API RESPONSE] " + JSON.stringify(result))

      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// cmnts_consentid - end

//update_cmnts_contentid - start
router.post(
  "/update_cmnts_contentid",
  validator.body(cmnts_contentid_validation),
  valid_user,
  async function (req, res, next) {
    try {// access the update_cmnts_contentid function
      var logger = main.logger

      var result = await cmnts_senderid.update_cmnts_contentid(req);

      logger.info("[API RESPONSE] " + JSON.stringify(result))

      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// update_cmnts_contentid - end

//content_template_business - start
router.post(
  "/content_template_business",
  valid_user,
  async function (req, res, next) {
    try {// access the content_template_business function
      var logger = main.logger

      var result = await content_template_business.ContentTemplateBusiness(req);

      logger.info("[API RESPONSE] " + JSON.stringify(result))

      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// content_template_business - end

//content_template_headersenderid - start
router.post(
  "/content_template_headersenderid_new",
  valid_user,
  async function (req, res, next) {
    try {// access the content_template_business function
      var logger = main.logger

      var result = await content_template_business.ContentTemplateHeaderSenderid(req);

      logger.info("[API RESPONSE] " + JSON.stringify(result))

      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// content_template_headersenderid - end

//consenttmpl - start
router.post(
  "/consenttmpl_new",
  valid_user,
  async function (req, res, next) {
    try {// access the consenttmpl function
      var logger = main.logger

      var result = await content_template_business.ConsentTmpl(req);

      logger.info("[API RESPONSE] " + JSON.stringify(result))

      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// consenttmpl - end


//content_template_headersenderid_exist - start
router.post(
  "/content_template_headersenderid_exist",
  valid_user,
  async function (req, res, next) {
    try {// access the content_template_business function
      var logger = main.logger

      var result = await content_template_business.content_template_headersenderid_exist(req);

      logger.info("[API RESPONSE] " + JSON.stringify(result))

      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// content_template_headersenderid_exist - end

//consenttmpl_exists - start
router.post(
  "/consenttmpl_exists",
  valid_user,
  async function (req, res, next) {
    try {// access the consenttmpl_exists function
      var logger = main.logger

      var result = await content_template_business.consenttmpl_exists(req);

      logger.info("[API RESPONSE] " + JSON.stringify(result))

      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// consenttmpl_exists - end


//dlt_list - start
router.post(
  "/dlt_list",
  valid_user,
  async function (req, res, next) {
    try {// access the dlt_list function
      var logger = main.logger

      var result = await content_template_business.dlt_list(req);

      logger.info("[API RESPONSE] " + JSON.stringify(result))

      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// dlt_list - end


//dlt_consent_list - start
router.post(
  "/dlt_consent_list",
  valid_user,
  async function (req, res, next) {
    try {// access the dlt_consent_list function
      var logger = main.logger

      var result = await content_template_business.dlt_consent_list(req);

      logger.info("[API RESPONSE] " + JSON.stringify(result))

      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// dlt_consent_list - end

//dlt_content_list - start
router.post( 
  "/dlt_content_list",
  valid_user,
  async function (req, res, next) {
    try {// access the dlt_consent_list function
      var logger = main.logger

      var result = await content_template_business.dlt_content_list(req);

      logger.info("[API RESPONSE] " + JSON.stringify(result))

      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// dlt_consent_list - end

//select_compose_messageType - start
router.post( 
  "/select_compose_messageType",
  validator.body(select_compose_messageType_validation),
  valid_user,
  async function (req, res, next) {
    try {// access the dlt_consent_list function
      var logger = main.logger

      var result = await content_template_business.select_compose_messageType(req);

      logger.info("[API RESPONSE] " + JSON.stringify(result))

      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// select_compose_messageType - end
 
//select_compose_messageType - start
router.post( 
  "/select_compose_messageType",
  valid_user,
  async function (req, res, next) {
    try {// access the dlt_consent_list function
      var logger = main.logger

      var result = await content_template_business.select_compose_messageType(req);

      logger.info("[API RESPONSE] " + JSON.stringify(result))

      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// select_compose_messageType - end
  
//compose_headersender - start
router.post( 
  "/compose_headersender",
  valid_user,
  async function (req, res, next) {
    try {// access the compose_headersender function
      var logger = main.logger

      var result = await content_template_business.compose_headersender(req);

      logger.info("[API RESPONSE] " + JSON.stringify(result))

      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// compose_headersender - end
 
//get_content_tmpl - start
router.post( 
  "/get_content_tmpl",
  validator.body(get_content_tmpl_validation),
  valid_user,
  async function (req, res, next) {
    try {// access the get_content_tmpl function
      var logger = main.logger

      var result = await content_template_business.get_content_tmpl(req);

      logger.info("[API RESPONSE] " + JSON.stringify(result))

      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// get_content_tmpl - end

  module.exports = router
