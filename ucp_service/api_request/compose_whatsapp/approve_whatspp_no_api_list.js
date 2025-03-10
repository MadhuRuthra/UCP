/*
This api has chat API functions which is used to connect the mobile chat.
This page is act as a Backend page which is connect with Node JS API and PHP Frontend.
It will collect the form details and send it to API.
After get the response from API, send it back to Frontend.

Version : 1.0
Author : Madhubala (YJ0009)
Date : 05-Jul-2023
*/
// Import the required packages and libraries
const db = require("../../db_connect/connect");
require("dotenv").config();
const main = require('../../logger');


// ApproveWhatsappNoAPIList Function - start
async function ApproveWhatsappNoAPIList(req) {
  var logger_all = main.logger_all;
  var logger = main.logger;

  try {
    const { user_id, whatsapp_config_id, reject_reason } = req.body;

    // Log the request body (ensure sensitive data is not logged)
    logger_all.info("[ApproveWhatsappNoAPIList request body]: " + JSON.stringify(req.body));

    // Execute the query with parameterized inputs to prevent SQL injection
      const update_succ = await db.query(
        `UPDATE whatsapp_config SET whatspp_config_status = ?, reject_reason = ? WHERE whatspp_config_id = ?`,
        ['R', reject_reason, whatsapp_config_id]
      );

      // Check if the update was successful
      if (update_succ.affectedRows > 0) {
        return {
          response_code: 1,
          response_status: 200,
          response_msg: 'Success'
        };
      } else {
        // No rows affected means no matching data was found
        return {
          response_code: 0,
          response_status: 204,
          response_msg: 'No data available'
        };
      }
 
  } catch (e) {
    // General error handling for unexpected failures in the request handler
    logger_all.error("[ApproveWhatsappNoAPIList failed]: " + e.message);
    return {
      response_code: 0,
      response_status: 500, // Internal server error
      response_msg: 'An unexpected error occurred'
    };
  }
}
// ApproveWhatsappNoAPIList Function - end

// ApproveWhatsappNoApiList Function - start
async function ApproveWhatsappNoApiList(req) {
	var logger_all = main.logger_all
	var logger = main.logger
	try {
           	// to get_approve_whatsapp_no_api using
		const get_approve_whatsapp_no_api = await db.query(`SELECT wht.whatspp_config_id, wht.user_id, usr.user_name,wht.mobile_no, wht.whatspp_config_status, wht.phone_number_id, wht.whatsapp_business_acc_id, wht.bearer_token, wht.country_id, wht.country_code FROM whatsapp_config wht left join user_management usr on usr.user_id = wht.user_id where wht.whatspp_config_status in ('N') order by wht.whatspp_config_entdate desc`);
              		// get_approve_whatsapp_no_api length is '0' to through the no data available message. 
		if (get_approve_whatsapp_no_api.length == 0) {
			return { response_code: 1, response_status: 204, response_msg: 'No data available' };
		}
		else { // otherwise get_approve_whatsapp_no_api to get the success message anag get_approve_whatsapp_no_api length and get_approve_whatsapp_no_api details
			return { response_code: 1, response_status: 200, num_of_rows: get_approve_whatsapp_no_api.length, response_msg: 'Success', report: get_approve_whatsapp_no_api };
		}

	}
	catch (e) { // any error occurres send error response to client
		logger_all.info("[ApproveWhatsappNoApiList failed response] : " + e)
		return { response_code: 0, response_status: 201, response_msg: 'Error occured' };
	}
}
// ApproveWhatsappNoApiList Function - end

// using for module exporting
module.exports = {
	ApproveWhatsappNoApiList,
	ApproveWhatsappNoAPIList
}
