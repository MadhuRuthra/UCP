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
// PTemplateList function start
async function PTemplateList(req) {
	// get all the data from the api body and headers
const { logger_all, logger } = main;
	try {

		const { user_id, user_master_id } = req.body;
		var get_template_list = '';
		if (user_master_id == 3 || user_master_id == 2) {
			get_template_list = await db.query(`SELECT tmp.unique_template_id ,tmp.template_id, tmp.template_name, tmp.template_category, tmp.template_message, tmp.template_response_id, tmp.template_status, DATE_FORMAT(tmp.template_entdate,'%d-%m-%Y %h:%i:%s %p') template_entdate, DATE_FORMAT(tmp.approve_date,'%d-%m-%Y %h:%i:%s %p') approve_date, crt.user_id created_userid, crt.user_name created_username, lng.language_id, lng.language_name, lng.language_code, cnf.whatspp_config_id, cnf.user_id receiver_userid, cnf.mobile_no, cnf.whatsapp_business_acc_id, cnf.phone_number_id, cnf.bearer_token, cnf.country_id, cnf.country_code FROM message_template tmp left join user_management crt on tmp.created_user = crt.user_id left join master_language lng on lng.language_id = tmp.language_id left join whatsapp_config cnf on cnf.whatspp_config_id = tmp.whatsapp_config_id where (crt.user_id = '${user_id}' or crt.parent_id in ('${user_id}') ) order by tmp.template_entdate desc`);
		} else {

			get_template_list = await db.query(`SELECT tmp.unique_template_id ,tmp.template_id, tmp.template_name, tmp.template_category, tmp.template_message, tmp.template_response_id, tmp.template_status, DATE_FORMAT(tmp.template_entdate,'%d-%m-%Y %h:%i:%s %p') template_entdate, DATE_FORMAT(tmp.approve_date,'%d-%m-%Y %h:%i:%s %p') approve_date, crt.user_id created_userid, crt.user_name created_username, lng.language_id, lng.language_name, lng.language_code, cnf.whatspp_config_id, cnf.user_id receiver_userid,cnf.mobile_no, cnf.whatsapp_business_acc_id, cnf.phone_number_id, cnf.bearer_token, cnf.country_id, cnf.country_code FROM message_template tmp left join user_management crt on tmp.created_user = crt.user_id left join master_language lng on lng.language_id = tmp.language_id left join whatsapp_config cnf on cnf.whatspp_config_id = tmp.whatsapp_config_id order by tmp.template_entdate desc`);
		}

		// if the get get_template_list length is '0' to send the no available data.otherwise it will be return the get_template_list details.
		if (get_template_list.length == 0) {
			return { response_code: 1, response_status: 204, response_msg: 'No data available' };
		}
		else {
			return { response_code: 1, response_status: 200, num_of_rows: get_template_list.length, response_msg: 'Success', templates: get_template_list };
		}

	}
	catch (e) {// any error occurres send error response to client
		logger_all.info("[PTemplateList failed response] : " + e)
		return { response_code: 0, response_status: 201, response_msg: 'Error occured' };
	}
}
// 	PTemplateList - end

// CheckSenderId - start
async function CheckSenderId(req) {
const { logger_all, logger } = main;
	try {
		const { user_id } = req.body;
		// query_select to get the query
		const get_manage_sender_id =  await db.query(`SELECT wht.whatspp_config_id, wht.user_id,concat(wht.country_code,wht.mobile_no) mobile_no, wht.whatspp_config_status, DATE_FORMAT(wht.whatspp_config_entdate,'%d-%m-%Y %h:%i:%s %p') whatspp_config_entdate, wht.wht_display_name, wht.wht_display_logo, wht.sent_count, wht.available_credit - wht.sent_count available_credit, DATE_FORMAT(wht.whatspp_config_apprdate,'%d-%m-%Y %h:%i:%s %p') whatspp_config_apprdate FROM whatsapp_config wht where wht.user_id = '${user_id}' and whatspp_config_status = 'Y' order by wht.whatspp_config_entdate desc`);
		// if the get_manage_sender_id is '0' to send the no available data.otherwise it will be return the get_manage_sender_id details.
		if (get_manage_sender_id.length == 0) {
			return { response_code: 1, response_status: 204, response_msg: 'No data available' };
		}
		else {
			return { response_code: 1, response_status: 200, num_of_rows: get_manage_sender_id.length, response_msg: 'Success', sender_id: get_manage_sender_id };
		}

	}
	catch (e) { // any error occurres send error response to client
		logger_all.info("[CheckSenderId failed response] : " + e)
		return { response_code: 0, response_status: 201, response_msg: 'Error occured' };
	}
}
// CheckSenderId - end

// using for module exporting
module.exports = {
	PTemplateList,
	CheckSenderId
}
