/*
API that allows your frontend to communicate with your backend server (Node.js) for processing and retrieving data.
To access a MySQL database with Node.js and can be use it.
This page is used in senderid functions which is used to senderid details.

Version : 1.0
Author : Madhubala (YJ0009)
Date : 05-Jul-2023
*/
// Import the required packages and libraries
const db = require("../../db_connect/connect");
const main = require('../../logger');
require('dotenv').config()

// AddSenderId function - start
async function AddSenderId(req) {
  try {
    var logger_all = main.logger_all
    // query parameters
    logger_all.info("[AddSenderId query parameters] : " + JSON.stringify(req.body));
    // Get all the req data
    const { user_id, country_code, mobile_no, profile_name, profile_image, service_category } = req.body;
    // Get country details using parameterized query to prevent SQL injection
    const get_ccode = await db.query(`SELECT * FROM master_countries WHERE phonecode = ?`, [country_code]);
    if (get_ccode.length === 0) {
      return { response_code: 0, response_status: 201, response_msg: 'Country not available' };
    }
    const country_code_id = get_ccode[0].id;
    // Check if the sender ID exists
    const get_number = await db.query(`SELECT * FROM whatsapp_config WHERE mobile_no = ? AND country_code = ? AND whatspp_config_status IN ('Y', 'N')`, [mobile_no, country_code]);
    if (get_number.length === 0) {
      // Insert the new sender ID into the database
      const response_result = await db.query(`INSERT INTO whatsapp_config (user_id,store_id, mobile_no, whatspp_config_status, whatspp_config_entdate, wht_display_name, wht_display_logo, message_category_id, available_credit,sent_count,country_id, country_code) VALUES (?, '1', ?, 'N', CURRENT_TIMESTAMP, ?, ?, ?,'0','0', ?, ?)`, [user_id, mobile_no, profile_name, profile_image, service_category, country_code_id, country_code]);
      if (response_result.affectedRows !== 1) {
        return { response_code: 0, response_status: 201, response_msg: 'Error occurred' };
      }
      return { response_code: 1, response_status: 200, response_msg: 'Sender ID added successfully!' };
    } else { // otherwise the SenderID already exists the reponse message send
      return { response_code: 0, response_status: 201, response_msg: 'SenderID exists' };
    }
  }
  catch (e) { // any error occurres send error response to client
    logger_all.info("[Add Sender Id failed response] : " + e)
    return { response_code: 0, response_status: 201, response_msg: 'Error occured' };
  }
}
// AddSenderId function - end

//Function Delete Sender Id - start
async function deleteSenderId(req) {
  try {
    const logger_all = main.logger_all;

    // Log query parameters
    logger_all.info("[deleteSenderId query parameters] : " + JSON.stringify(req.body));

    // Destructure values from the request body
    const { user_id, whatspp_config_id, reject_reason: reason_delete } = req.body;

    // Use parameterized queries to avoid SQL injection
    const query = `SELECT * FROM whatsapp_config WHERE whatspp_config_id = ?`;
    const check_user_id = await db.query(query, [whatspp_config_id]);

    // If the sender ID is found, proceed with the update
    if (check_user_id.length > 0) {
      // Update the WhatsApp config status to 'D' and set the rejection reason
      const updateQuery = `UPDATE whatsapp_config SET whatspp_config_status = 'D', reject_reason = ? WHERE whatspp_config_id = ? and user_id = ?`;
      const response_result = await db.query(updateQuery, [reason_delete, whatspp_config_id, user_id]);
      return { response_code: 1, response_status: 200, response_result, response_msg: 'Success' };
    } else {
      // If the sender ID is not found
      return { response_code: 0, response_status: 404, response_msg: 'Sender ID not found.' };
    }
  } catch (error) {
    // Log the error and return a standardized error response
    const logger_all = main.logger_all;
    logger_all.error("[Delete Sender ID report failed response] : " + error.message);

    return { response_code: 0, response_status: 500, response_msg: 'An error occurred while processing the request.' };
  }
}

// deleteSenderId - end

// using for module exporting
module.exports = {
  AddSenderId,
  deleteSenderId
};
