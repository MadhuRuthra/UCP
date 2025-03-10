/*
API that allows your frontend to communicate with your backend server (Node.js) for processing and retrieving data.
To access a MySQL database with Node.js and can be use it.
This page is used in delete template function which is used to delete a template.

Version : 1.0
Author : Madhubala (YJ0009)
Date : 05-Jul-2023
*/
// Import the required packages and libraries
const db = require("../../db_connect/connect");
const main = require('../../logger')
const { count } = require("sms-length");
require('dotenv').config();


// delete_template_smpp - start
async function delete_template_smpp(req) {
  const logger_all = main.logger_all
  try {

    //  Get all the req header data
    const header_token = req.headers['authorization'];

    // get all the req data
    let template_id = req.body.template_id;

    // query parameters
    logger_all.info("[delete_template_smpp query parameters] : " + JSON.stringify(req.body));
    // To get the User_id
    let get_user = `SELECT * FROM user_management where user_bearer_token  = '${header_token}' AND usr_mgt_status = 'Y' `;
    if (req.body.user_id) {
      get_user = get_user + `and user_id = '${req.body.user_id}' `;
    }
    const get_user_id = await db.query(get_user);
    // If get_user not available send error response to client in ivalid token
    if (get_user_id.length == 0) {
      logger_all.info("Invalid Token")
      return { response_code: 0, response_status: 201, response_msg: 'Invalid Token' };
    }
    else {   // otherwise to get the user details
      user_id = get_user_id[0].user_id;
    }
    // to check the unique_compose_id from the message_template
    const select_template = await db.query(`SELECT * from compose_smpp WHERE unique_compose_id = '${template_id}'`);

    let messages = select_template[0].message_content;
    let total_mobile_no_count = select_template[0].total_mobile_no_count
    //SMS Calculation
    var data = count(messages);
    logger_all.info(JSON.stringify(data) + "SMS Calculation");
    let txt_sms_count = data.messages;
    logger_all.info(txt_sms_count + " SMS count based");

    let msg_mobile_credits = total_mobile_no_count * txt_sms_count;

    if (user_master_id !== 1) {
      await db.query(`UPDATE message_limit SET available_messages = available_messages + ${msg_mobile_credits} 
               WHERE user_id = '${user_id}'`);
    }
    // if the select_template length is '0' to send the Template not found response message.
    if (select_template.length == 0) {
      return { response_code: 0, response_status: 201, response_msg: 'Template not found.' };
    }
    else { // otherwise process will be continued to update the message_template table in template_status 'D'
      const delete_template = await db.query(`UPDATE compose_smpp SET ucp_status = 'D' WHERE unique_compose_id ='${template_id}'`);
      // to return the response message in 'Template deleted successfully'.
      return { response_code: 1, response_status: 200, response_msg: 'Template deleted successfully.' };

    }
  }
  catch (e) {// any error occurres send error response to client
    logger_all.info("[delete_template_smpp failed response] : " + e)
    return { response_code: 0, response_status: 201, response_msg: 'Error occurred while delete template' };

  }
}
// deleteTemplate - end
// using for module exporting
module.exports = {
  delete_template_smpp
};

