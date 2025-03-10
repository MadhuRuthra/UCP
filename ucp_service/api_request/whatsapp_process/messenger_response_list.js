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

// MessengerResponseList - start
async function MessengerResponseList(req) {
  try {
 var logger_all = main.logger_all
var user_id = req.body.user_id;

    const get_messenger_response = await db.query(`SELECT res.message_id, usr.user_id, usr.user_name, res.message_from, res.message_to, res.message_from_profile, res.message_resp_id, res.message_type, res.msg_text, res.msg_media, res.msg_media_type, res.msg_media_caption, res.msg_reply_button, res.msg_reaction, res.message_is_read, res.message_status, res.message_rec_date, res.message_read_date FROM messenger_response res left join user_management usr on usr.user_id = res.user_id where res.message_status = 'Y' and res.message_from != 'yeejai_technologies_lgzmaa9c_agent@rbm.goog' group by message_from order by res.message_rec_date desc`);
    // if the get_messenger_response length is '0' to send the no available data.otherwise it will be return the get_messenger_response details.
    if (get_messenger_response.length == 0) {
      return { response_code: 1, response_status: 204, response_msg: 'No data available' };
    }
    else {
      return { response_code: 1, response_status: 200, num_of_rows: get_messenger_response.length, response_msg: 'Success', report: get_messenger_response };
    }

  }
  catch (e) {// any error occurres send error response to client
    logger_all.info("[messenger response failed response] : " + e)
    return { response_code: 0, response_status: 201, response_msg: 'Error occured' };
  }
}
// MessengerResponseList - end

// using for module exporting
module.exports = {
	MessengerResponseList
}
