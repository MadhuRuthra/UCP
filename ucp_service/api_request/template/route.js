/*
Routes are used in direct incoming API requests to backend resources.
It defines how our application should handle all the HTTP requests by the client.
This page is used to routing the product menu.

Version : 1.0
Author : Sabena yasmin (YJ0008)
Date : 30-Sep-2023
*/

const express = require("express");
const router = express.Router();
require("dotenv").config();
const validator = require('../../validation/middleware')
const valid_user = require("../../validation/valid_user_middleware");
const save_senderid = require("./save_senderid")
const save_senderid_validation = require("../../validation/save_senderid_validation");
const savetemplateid = require("../../validation/save_templateid_validation");
const main = require('../../logger');
router.post(
  "/save_senderid",
  validator.body(save_senderid_validation),
  valid_user,
  async function (req, res, next) {
    try {
      const logger = main.logger;
      const result = await save_senderid.Save_Sender_id(req);
      logger.info("[API RESPONSE] " + JSON.stringify(result));
      res.json(result);
    } catch (err) {
      console.error("Error while getting data", err.message);
      next(err);
    }
  }
);

router.post(
  "/save_templateid",
  validator.body(savetemplateid),
  valid_user,
  async function (req, res, next) {
    try {
      const logger = main.logger;
      const result = await save_senderid.savetemplateid(req);
      logger.info("[API RESPONSE] " + JSON.stringify(result));
      res.json(result);
    } catch (err) {
      console.error("Error while getting data", err.message);
      next(err);
    }
  }
);

module.exports = router;