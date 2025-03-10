
// Import necessary modules and dependencies
const db = require("../../db_connect/connect");
require("dotenv").config();
const main = require('../../logger')
// ChangePassword - start
async function MessageType(req) {
	const logger_all = main.logger_all;
	const logger = main.logger;

	try {
		// Get the authorization header token
		const header_token = req.headers['authorization'];

		// Log the request body
		logger_all.info("[Message Type] : " + JSON.stringify(req.body));

		// Execute the query
		const message_type = await db.query(`SELECT * FROM sms_route_master WHERE sms_route_status = 'Y' AND sms_route_id = '3' ORDER BY sms_route_id ASC`);
		
		// Check if any rows are returned
		if (message_type.length === 0) {
			return {
				response_code: 0,
				response_status: 201,
				response_msg: 'No Data Available'
			};
		} else {
			// Return the data along with the success message
			return {
				response_code: 1,
				response_status: 200,
				response_msg: 'Success',
				result: message_type // include the query result here
			};
		}
	} catch (e) {
		// Log and return an error response in case of failure
		logger_all.info("[Message Type failed response] : " + e);
		return {
			response_code: 0,
			response_status: 201,
			response_msg: 'Error occurred'
		};
	}
}

// ChangePassword - end

// using for module exporting
module.exports = {
	MessageType
}
