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
// approvepayment - start
async function WaitingApprovalList(req) {
	const logger_all = main.logger_all;
	const logger = main.logger;
	try {

		// Notification Waiting approval Payment
		const get_approve_payment = await db.query(`SELECT count(*) as approve_payment FROM user_credit_raise WHERE usr_credit_status = 'A' ORDER BY usr_credit_entry_date DESC`);

		// Construct the SQL query to fetch approval details for the current user ID for sms
		const waiting_compose_count = await db.query(`SELECT count(*) as approve_sms FROM compose_sms WHERE ucp_status = 'W' AND rights_id = 1`);
		const waiting_compose_count_smpp = await db.query(`SELECT count(*) as approve_smpp FROM compose_smpp WHERE ucp_status = 'W' AND rights_id = 2 `);

		// Notification Waiting Users
		const waiting_users_count = await db.query(`SELECT count(*) as approve_users FROM user_management WHERE usr_mgt_status = 'Y'`);

		// Notification for DLT Process
		let dlt_template = await db.query(`SELECT count(*) as approve_consent_dlt FROM cm_consent_template WHERE cm_consent_status = 'W'`) || [];
		let dlt_senderid = await db.query(`SELECT count(*) as approve_dlt_senders FROM cm_senderid WHERE sender_status = 'W' `) || [];
		let dlt_content_tmpl = await db.query(`SELECT count(*) as approve_content_dlt FROM cm_content_template WHERE cn_status = 'W' `) || [];

		let length_dlt = dlt_template[0].approve_consent_dlt + dlt_senderid[0].approve_dlt_senders + dlt_content_tmpl[0].approve_content_dlt;

		// Notification Waiting senderids
		const waiting_sender_ids = await db.query(`SELECT count(*) as approve_wtsp_senders FROM whatsapp_config WHERE whatspp_config_status = 'N'`);
		const waiting_whatsapp_templates = await db.query(`SELECT count(*) as approve_wtsp_templates FROM message_template WHERE template_status = 'N'`);
		const waiting_whatsapp_compose = await db.query(`SELECT count(*) as approve_whatsapps FROM compose_whatsapp WHERE ucp_status = 'W' AND rights_id = 3`);

		return { response_code: 1, response_status: 200, waiting_payment: get_approve_payment[0].approve_payment, waiting_compose: waiting_compose_count[0].approve_sms, waiting_users: waiting_users_count[0].approve_users, waiting_compose_smpp: waiting_compose_count_smpp[0].approve_smpp, waiting_dlt_res: length_dlt, waiting_template: dlt_template[0].approve_consent_dlt, waiting_senderid: dlt_senderid[0].approve_dlt_senders, waiting_content_tmpl: dlt_content_tmpl[0].approve_content_dlt, waiting_wtsp_senderid: waiting_sender_ids[0].approve_wtsp_senders, waiting_wtsp_template: waiting_whatsapp_templates[0].approve_wtsp_templates, waiting_whatsapp_compose: waiting_whatsapp_compose[0].approve_whatsapps, response_msg: 'Success' };

	} catch (e) { // any error occurs, send error response to client
		logger_all.info("[PaymentHistory failed response] : " + e);
		return { response_code: 0, response_status: 201, response_msg: 'Error occurred' };
	}
}

// approvepayment - end

// using for module exporting
module.exports = {
	WaitingApprovalList
}
