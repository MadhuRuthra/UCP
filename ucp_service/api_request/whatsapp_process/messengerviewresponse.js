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
// MessengerViewResponse function start
async function MessengerViewResponse(req) {
	var logger_all = main.logger_all
	var logger = main.logger
	try {

		// get all the req data
		var {message_from ,message_to ,user_id} = req.body;

		// query parameters
		logger_all.info("[MessengerViewResponse - query parameters] : " + JSON.stringify(req.body));

		const get_messenger_view_response = await db.query(`SELECT res.message_id, usr.user_id,res.message_data,res.msg_list, usr.user_name, res.message_from, res.message_to, res.message_from_profile, upper(res.message_type) message_type, res.msg_text, res.msg_media, res.msg_media_type, res.msg_media_caption, res.msg_reply_button, res.msg_reaction, res.message_is_read, res.message_status,DATE_FORMAT(res.message_rec_date,'%d-%m-%Y %h:%i:%s %p') message_rec_date , res.message_read_date, concat(cnf.country_code, cnf.mobile_no) mobile_no, cnf.bearer_token,cnf.whatspp_config_status FROM messenger_response res left join user_management usr on usr.user_id = res.user_id left join whatsapp_config cnf on concat(cnf.country_code, cnf.mobile_no) = res.message_to and cnf.whatspp_config_status = 'Y' where res.message_status = 'Y' and (usr.user_id = '${user_id}' or usr.parent_id = '${user_id}') and (res.message_from = '${message_to}' or res.message_to = '${message_to}') and (res.message_from = '${message_from}' or res.message_to = '${message_from}') order by res.message_id desc`);
		
		if (get_messenger_view_response.length == 0) {
			return {
				response_code: 1,
				response_status: 204,
				response_msg: 'No data available'
			};
		} else {
			return {
				response_code: 1,
				response_status: 200,
				num_of_rows: get_messenger_view_response.length,
				response_msg: 'Success',
				report: get_messenger_view_response
			};
		}

	} catch (e) {// any error occurres send error response to client
		logger_all.info("[MessengerViewResponse - failed response] : " + e)
		return {
			response_code: 0,
			response_status: 201,
			response_msg: 'Error occured'
		};
	}
}
// MessengerViewResponse function - end

// using for module exporting
module.exports = {
	MessengerViewResponse
}
