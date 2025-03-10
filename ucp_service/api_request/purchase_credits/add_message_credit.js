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

// AddMessageCredit Function - start
async function AddMessageCredit(req) {
	var logger_all = main.logger_all
	var logger = main.logger
	try {
		
		// Extract all the required data from the request body using object destructuring
		let { user_id, parent_user, product_id, receiver_user, message_count, credit_raise_id , user_master_id} = req.body;
		//let user_master_id;
		// declare variable
		logger_all.info(" [AddMessageCredit] - " + req.body);
		logger.info("[API REQUEST - AddMessageCredit] " + req.originalUrl + " - " + JSON.stringify(req.body) + " - " + JSON.stringify(req.headers))

		if (typeof parent_user !== 'undefined') {
			exp1 = parent_user.split("~~");
		}

		var exp2 = receiver_user.split("~~");

		const select_credit = await db.query(`SELECT available_messages from message_limit WHERE user_id = '${user_id}' AND message_limit_status = 'Y' and rights_id= '${product_id}'`);
		// To check the available_messages
		if (select_credit[0].available_messages < message_count) {
			return {
				response_code: 0,
				response_status: 201,
				response_msg: 'Insufficient credits.'
			};
		}
		console.log("*******",message_count)
		// insert the message_credit_log to request data
		const insert_template = await db.query(`INSERT INTO message_credit_log VALUES (NULL, '${user_id}', '${exp2[0]}', '${product_id}','${message_count}', '${message_count} Messages allocated to ${exp2[1]} by admin', 'Y', CURRENT_TIMESTAMP)`);

		// upadte the message_limit to request data
		// const update_succ = await db.query(`UPDATE message_limit SET available_messages = available_messages + '${message_count}', total_messages = total_messages + '${message_count}', expiry_date = '${next_year_date}' WHERE user_id = ${exp2[0]} and rights_id = '${product_id}'`);

		const update_succ = await db.query(`UPDATE message_limit SET available_messages = available_messages + '${message_count}', total_messages = total_messages + '${message_count}', expiry_date = CURRENT_DATE + INTERVAL 1 YEAR WHERE user_id = ${exp2[0]} and rights_id = '${product_id}'`);
		logger_all.info("USER_MASTER_ID:",user_master_id)
		if (user_master_id !== 1)  {  // upadte the message_limit for expect the primaryadmin using the condition
			const update_succ2 = await db.query(`UPDATE message_limit SET available_messages = available_messages - '${message_count}' WHERE user_id = ${user_id} and rights_id = '${product_id}'`);
		}
			logger_all.info("credit_raise_id->" + credit_raise_id);
			//insert usr_credit_status = W, admin approve usr_credit_status = A, user purchase usr_credit_status = U
			if (typeof credit_raise_id !== 'undefined') {
				console.log("INSIDE IF");
				logger_all.info("INSIDE IF")
				// Purchase Credit Raised and Approved
				const update_succ3 = await db.query(`UPDATE user_credit_raise SET usr_credit_status = 'U' WHERE usr_credit_id = ${credit_raise_id} and usr_credit_status = 'A'`);
			}

			// update_succ2 to get the response message through theMessage Credit updated. 
			if ( update_succ.affectedRows > 0) {
				return {
					response_code: 1,
					response_status: 200,
					num_of_rows: 1,
					response_msg: 'Message Credit updated.'
				};

			} 
		
		if (update_succ.affectedRows > 0) {
			return {
				response_code: 1,
				response_status: 200,
				num_of_rows: 1,
				response_msg: 'Message Credit updated.'
			};

		} 
	} catch (e) { // any error occurres send error response to client
		logger_all.info("[AddMessageCredit failed response] : " + e)
		return {
			response_code: 0,
			response_status: 201,
			response_msg: 'Error occured'
		};
	}
}
// AddMessageCredit Function - end
// using for module exporting
module.exports = {
	AddMessageCredit
}