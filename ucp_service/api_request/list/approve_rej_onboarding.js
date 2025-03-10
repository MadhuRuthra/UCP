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

// ApproveRejectOnboarding - start
async function ApproveRejectOnboarding(req) {
  var logger_all = main.logger_all
  var logger = main.logger
  try {
    // get all the req data

    var user_id = req.body.user_id;
    var change_user_id = req.body.change_user_id;
    var txt_remarks = req.body.txt_remarks;
    var aprj_status = req.body.aprj_status;
    var update_query_values = '';
    // query parameters
    var comments;
    var upload_media = '';
    logger_all.info("Deleted Reason :-", txt_remarks);
    logger_all.info("Deleted Reason :-", req.body.txt_remarks);

    console.log("Received req.body:", req.body); // logs the entire request body
    console.log("Deleted Reason:", txt_remarks); // logs the txt_remarks field directly
    

    logger_all.info("[select query request] : " + `SELECT * from user_management where user_id ='${change_user_id}' order by user_id desc`);
    get_manage_users = await db.query(`SELECT * from user_management where user_id ='${change_user_id}' order by user_id desc`);
    logger_all.info("[select query response] : " + JSON.stringify(get_manage_users))

console.log("*******", change_user_id, txt_remarks, aprj_status, user_id)
    if (aprj_status == 'A') {
      update_query_values = `UPDATE user_management SET usr_mgt_status = 'Y', reject_reason = '-' WHERE user_id = ${change_user_id}`;
      comments = "Account Activated!";
    }
    else if (aprj_status == 'D') {
      update_query_values = `UPDATE user_management SET usr_mgt_status = 'D', reject_reason = '${txt_remarks}'  WHERE user_id = ${change_user_id}`;
      comments = "Account Deleted";
    }
    else if (aprj_status == 'S') {
      update_query_values = `UPDATE user_management SET usr_mgt_status = 'S', reject_reason = '-' WHERE user_id = ${change_user_id}`;
      comments = "Account Suspended";
    }

    logger_all.info("[ApproveRejectOnboarding query parameters] : " + JSON.stringify(req.body));

    // ApproveRejectOnboarding to execute this query
    logger_all.info("[Update query request - User details] : " + ` ${update_query_values}`);
    const update_profile_details = await db.query(`${update_query_values}`);
    logger_all.info("[Update query request - User details] : " + JSON.stringify(update_profile_details));

    // if the get_available_message length is not available to send the no available data.otherwise it will be return the get_available_message details.
    if (update_profile_details.affectedRows > 0) {
      return { response_code: 1, response_status: 200, num_of_rows: 1, response_msg: comments };
    } else {
      return { response_code: 1, response_status: 204, response_msg: 'No data available' };
    }

  }
  catch (e) {// any error occurres send error response to client
    logger_all.info("[ApproveRejectOnboarding failed response] : " + e)
    return { response_code: 0, response_status: 201, response_msg: 'Error occured' };
  }
}
// ApproveRejectOnboarding - end

// using for module exporting
module.exports = {
  ApproveRejectOnboarding,
}

