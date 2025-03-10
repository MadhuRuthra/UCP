
// Import necessary modules and dependencies
const db = require("../../db_connect/connect");
require("dotenv").config();
const main = require('../../logger')
// PreviewSenderidConsent - start
async function PreviewSenderidConsent(req) {
	const logger_all = main.logger_all;
	const logger = main.logger;

	try {
		// Get the authorization header token
		const header_token = req.headers['authorization'];

		const {slt_business_category} = req.body;

		// Log the request body
		logger_all.info("[PreviewSenderidConsent] : " + JSON.stringify(req.body));

		// Execute the query
		const business_category = await db.query(`SELECT * FROM sender_business_category where business_category_status = 'Y' and sender_buscategory_id = '${slt_business_category}' ORDER BY sender_buscategory_id Asc`);
		
		// Check if any rows are returned
		if (business_category.length === 0) {
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
				result: business_category // include the query result here
			};
		}
	} catch (e) {
		// Log and return an error response in case of failure
		logger_all.info("[PreviewSenderidConsent failed response] : " + e);
		return {
			response_code: 0,
			response_status: 201,
			response_msg: 'Error occurred'
		};
	}
}

// PreviewSenderidConsent - end

// select_message_type - start
async function select_message_type(req) {
	const logger_all = main.logger_all;
	const logger = main.logger;

	try {
		// Get the authorization header token
		const header_token = req.headers['authorization'];

		const {dlt_process} = req.body;

		// Log the request body
		logger_all.info("[select_message_type] : " + JSON.stringify(req.body));
  
		// Execute the query
		const business_category = await db.query(`SELECT * FROM sms_route_master where sms_route_status = 'Y' and sms_route_id = '${dlt_process}' ORDER BY sms_route_id Asc`);
		
		// Check if any rows are returned
		if (business_category.length === 0) {
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
				result: business_category // include the query result here
			};
		}
	} catch (e) {
		// Log and return an error response in case of failure
		logger_all.info("[select_message_type failed response] : " + e);
		return {
			response_code: 0,
			response_status: 201,
			response_msg: 'Error occurred'
		};
	}
}

// select_message_type - end

// CmSenterId - start
async function CmSenterId(req) {
	const logger_all = main.logger_all;
	const logger = main.logger;

	try {
		// Get the authorization header token
		const header_token = req.headers['authorization'];

		const {user_id,t_cm_sender_id, t_cm_consent_id} = req.body;

		// Log the request body
		logger_all.info("[CmSenterId] : " + JSON.stringify(req.body));
  
		// Execute the query
		const business_category = await db.query(`SELECT * FROM cm_senderid where sender_status = 'Y' and user_id = '${user_id}' and cm_sender_id = '${t_cm_sender_id}' ORDER BY sender_title Asc`);
		
		// Check if any rows are returned
		if (business_category.length === 0) {
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
				result: business_category // include the query result here
			};
		}
	} catch (e) {
		// Log and return an error response in case of failure
		logger_all.info("[CmSenterId failed response] : " + e);
		return {
			response_code: 0,
			response_status: 201,
			response_msg: 'Error occurred'
		};
	}
}

// select_message_type - end

// selectcmconsentid - start
async function selectcmconsentid(req) {
	const logger_all = main.logger_all;
	const logger = main.logger;

	try {
		// Get the authorization header token
		const header_token = req.headers['authorization'];

		const {user_id,t_cm_sender_id, t_cm_consent_id} = req.body;

		// Log the request body
		logger_all.info("[selectcmconsentid] : " + JSON.stringify(req.body));
  
		// Execute the query
		const business_category = await db.query(`SELECT * FROM cm_consent_template where cm_consent_status = 'Y' and user_id = '${user_id}' and cm_consent_id = '${t_cm_consent_id}' ORDER BY cm_consent_tmplname Asc`);
		
		// Check if any rows are returned
		if (business_category.length === 0) {
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
				result: business_category // include the query result here
			};
		}
	} catch (e) {
		// Log and return an error response in case of failure
		logger_all.info("[selectcmconsentid failed response] : " + e);
		return {
			response_code: 0,
			response_status: 201,
			response_msg: 'Error occurred'
		};
	}
}

// select_message_type - end
// using for module exporting
module.exports = {
	PreviewSenderidConsent,
    select_message_type,
	CmSenterId,
	selectcmconsentid
}
