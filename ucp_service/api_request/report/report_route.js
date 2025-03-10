
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
const GenerateReportValidation = require("../../validation/generate_report_validation");

const dotenv = require('dotenv');
dotenv.config();
require('dotenv').config()
const env = process.env


// Import the report functions page
const CampaignReport = require("./detailed_report");
const Summary_Report = require("./summary_report");
const Summary_Report_Smpp = require("./summary_report_smpp")
const GenerateReport = require("./generate_report");
const GenerateReportList = require("./generate_report_list");
const GenerateReportListWhatsapp = require("./generate_report_list_whatsapp");
const Summary_Report_Whatsapp = require("./summary_report_whatsapp")
const main = require('../../logger');
// Import the validation page

const OtpsummaryreportValidation = require("../../validation/opt_summary_report");
const OtpdeliveryrptValidation = require("../../validation/otp_delivery_rpt_validation");
const SMPPsummaryreportValidation = require("../../validation/smpp_delivery_rpt_validation")
// summary_report - start
router.post(
    "/summary_report",
    validator.body(OtpsummaryreportValidation),
    valid_user,
    async function (req, res, next) {
        try {// access the OtpSummaryReport function
            const logger = main.logger
            const result = await Summary_Report.SummaryReport(req);
            res.json(result);
        } catch (err) {// any error occurres send error response to client
            console.error(`Error while getting data`, err.message);
            next(err);
        }
    }
);
// summary_report - end

// summary_report-smpp - start
router.post(
  "/summary_report_smpp",
  validator.body(SMPPsummaryreportValidation),
  valid_user,
  async function (req, res, next) {
      try {// access the OtpSummaryReport function
          const logger = main.logger
          const result = await Summary_Report_Smpp.SummaryReportSmpp(req);
          res.json(result);
      } catch (err) {// any error occurres send error response to client
          console.error(`Error while getting data`, err.message);
          next(err);
      }
  }
);
// summary_report-smpp - end

// detailed_report - start
router.post(
    "/detailed_report",
    validator.body(OtpdeliveryrptValidation),
    valid_user,
    async function (req, res, next) {
        try {// access the OtpDeliveryReport function
            const logger = main.logger
            const result = await CampaignReport.OtpDeliveryReport(req);
            res.json(result);
        } catch (err) {// any error occurres send error response to client
            console.error(`Error while getting data`, err.message);
            next(err);
        }
    }
);
// detailed_report - end

// detailed_report_smpp - start
router.post(
  "/detailed_report_smpp",
  validator.body(OtpdeliveryrptValidation),
  valid_user,
  async function (req, res, next) {
      try {// access the OtpDeliveryReport function
          const logger = main.logger
          const result = await CampaignReport.OtpDetailedReport(req);
          res.json(result);
      } catch (err) {// any error occurres send error response to client
          console.error(`Error while getting data`, err.message);
          next(err);
      }
  }
);
// detailed_report_smpp - end



// generate_report - start
router.post(
    "/generate_report",
    validator.body(GenerateReportValidation),
    valid_user,
    async function (req, res, next) {
      try {// access the activation_payment function
        let logger = main.logger
  
        let result = await GenerateReport.generatereport(req);
  
        logger.info("[API RESPONSE] " + result)
  
        logger.info("[API RESPONSE] " + JSON.stringify(result))
  
        res.json(result);
      } catch (err) {// any error occurres send error response to client
        console.error(`Error while getting data`, err.message);
        next(err);
      }
    }
  );
  // generate_report - end


// generate_report_smpp - start
router.post(
  "/generate_report_smpp",
  validator.body(GenerateReportValidation),
  valid_user,
  async function (req, res, next) {
    try {// access the activation_payment function
      let logger = main.logger

      let result = await GenerateReport.generatereportsmpp(req);

      logger.info("[API RESPONSE] " + result)

      logger.info("[API RESPONSE] " + JSON.stringify(result))

      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// generate_report_smpp - end
  
  
  // generate_report_list - start
  router.get(
    "/generate_report_list",
    async function (req, res, next) {
      try {// access the activation_payment function
        let logger = main.logger
  
        let result = await GenerateReportList.generatereportlist(req);
  
        logger.info("[API RESPONSE] " + result)
  
        logger.info("[API RESPONSE] " + JSON.stringify(result))
  
        res.json(result);
      } catch (err) {// any error occurres send error response to client
        console.error(`Error while getting data`, err.message);
        next(err);
      }
    }
  );
  // generate_report_list - end
  

  // generate_report_list_smpp - start
  router.get(
    "/generate_report_list_smpp",
    async function (req, res, next) {
      try {// access the activation_payment function
        let logger = main.logger
  
        let result = await GenerateReportList.generate_report_list_smpp(req);
  
        logger.info("[API RESPONSE] " + result)
  
        logger.info("[API RESPONSE] " + JSON.stringify(result))
  
        res.json(result);
      } catch (err) {// any error occurres send error response to client
        console.error(`Error while getting data`, err.message);
        next(err);
      }
    }
);
// generate_report_list_smpp - end

  // GenerateReportListWhatsapp - start
  router.get(
    "/generate_report_list_whatsapp",
    async function (req, res, next) {
      try {// access the generatereportlist function
        let logger = main.logger
  
        let result = await GenerateReportListWhatsapp.generatereportlist(req);
  
        logger.info("[API RESPONSE] " + result)
  
        logger.info("[API RESPONSE] " + JSON.stringify(result))
  
        res.json(result);
      } catch (err) {// any error occurres send error response to client
        console.error(`Error while getting data`, err.message);
        next(err);
      }
    }
  );
  // GenerateReportListWhatsapp - end


// generate_report_whatsapp - start
router.post(
  "/generate_report_whatsapp",
  validator.body(GenerateReportValidation),
  valid_user,
  async function (req, res, next) {
    try {// access the generate_report_whatsapp function
      let logger = main.logger

      let result = await GenerateReport.generatereportwhatsapp(req);

      logger.info("[API RESPONSE] " + result)

      logger.info("[API RESPONSE] " + JSON.stringify(result))

      res.json(result);
    } catch (err) {// any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// generate_report_whatsapp - end  


// summary_report-whatsapp - start
router.get(
  "/summary_report_whatsapp",
  validator.body(OtpsummaryreportValidation),
  valid_user,
  async function (req, res, next) {
      try {// access the OtpSummaryReport function
          const logger = main.logger
          const result = await Summary_Report_Whatsapp.SummaryReportWhatsapp(req);
          res.json(result);
      } catch (err) {// any error occurres send error response to client
          console.error(`Error while getting data`, err.message);
          next(err);
      }
  }
);
// summary_report-Whatsapp - end


// detailed_report_whatsapp - start
router.get(
  "/detailed_report_whatsapp",
  validator.body(OtpdeliveryrptValidation),
  valid_user,
  async function (req, res, next) {
      try {// access the OtpDeliveryReport function
          const logger = main.logger
          const result = await CampaignReport.DetailedReportWhatsapp(req);
          res.json(result);
      } catch (err) {// any error occurres send error response to client
          console.error(`Error while getting data`, err.message);
          next(err);
      }
  }
);
// detailed_report_whatsapp - end
module.exports = router
