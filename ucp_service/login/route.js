/*
Routes are used in direct incoming API requests to backend resources.
It defines how our application should handle all the HTTP requests by the client.
This API is used to the login user.

Version : 1.0
Author : Sabena yasmin (YJ0008)
Date : 22-Nov-2023
*/

// Import the required packages and libraries
const express = require("express");
const router = express.Router();
const Login = require("./login");
const validator = require('../validation/middleware')
const valid_user_reqID = require("../validation/valid_user_middleware_reqID");

const LoginValidation = require("../validation/login_validation");
const signupValidation = require("../validation/signupValidation"); //add
const ResetValidation = require("../validation/resetpasswordValidation");
const main = require('../logger')
const path = require('path');

const db = require('../db_connect/connect');

//Start Route - Login
router.post(
  "/",
  validator.body(LoginValidation),
  async function (req, res, next) {
    try {
      const logger = main.logger
      const logger_all = main.logger_all

      var result = await Login.login(req);
      result['request_id'] = req.body.request_id;

      logger.info("[API RESPONSE] " + JSON.stringify(result))

      if (result.response_code == 0) {
        const update_api_log = await db.query(`UPDATE api_log SET response_status = 'F',response_date = CURRENT_TIMESTAMP,response_comments = '${result.response_msg}' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);
      }
      else {
        const update_api_log = await db.query(`UPDATE api_log SET response_status = 'S',response_date = CURRENT_TIMESTAMP,response_comments = 'Success' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);
      }
      res.json(result);
    } catch (err) {
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
//End Route - Login

//Start Route - Signup
router.post(
  "/signup",
  validator.body(signupValidation),
  // valid_user_reqID,
  async function (req, res, next) {
    try { // access the api_login function
      const logger = main.logger

      const logger_all = main.logger_all;

      var header_json = req.headers;
      let ip_address = header_json['x-forwarded-for'];

      var result = await Login.Signup(req);

      result['request_id'] = req.body.request_id;
      logger.info("[API RESPONSE] " + JSON.stringify(result))
      res.json(result);
    } catch (err) { // any error occurres send error response to client
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
//End Route - Signup

//Start Route - Reset Password
router.put(
  "/reset_password",
  validator.body(ResetValidation),
  async function (req, res, next) {
    try {
      const logger = main.logger;
      const logger_all = main.logger_all;

      // Ensure result is initialized
      var result = await Login.ResetPassword(req);

      // Check if result is defined and is an object
      if (result && typeof result === 'object') {
        result['request_id'] = req.body.request_id;
        logger.info("[API RESPONSE] " + JSON.stringify(result));

        let query = '';
        if (result.response_code == 0) {
          const update_api_log = await db.query(`UPDATE api_log SET response_status = 'F', response_date = CURRENT_TIMESTAMP, response_comments = '${result.response_msg}' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);
        } else {
          const update_api_log = await db.query(`UPDATE api_log SET response_status = 'S', response_date = CURRENT_TIMESTAMP, response_comments = 'Success' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);
        }

        res.json(result);
      } else {
        // Handle case where result is not an object or is undefined
        const errorMsg = "Unexpected response from ResetPassword function";
        logger.error(errorMsg);
        res.status(500).json({ error: errorMsg });
      }
    } catch (err) {
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
//End Route - Reset Password

module.exports = router;
