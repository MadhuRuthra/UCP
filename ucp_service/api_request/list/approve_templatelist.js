 
// Import necessary modules and dependencies
const db = require("../../db_connect/connect");
require("dotenv").config();
const main = require('../../logger')
// ApproveTemplateList - start
async function ApproveTemplateList(req) {
	const logger_all = main.logger_all;
	const logger = main.logger;

	try {
		// Get the authorization header token
		const header_token = req.headers['authorization'];

		// Log the request body
		logger_all.info("[ApproveTemplateList] : " + JSON.stringify(req.body));

		// Execute the query
		const business_category = await db.query(`SELECT * FROM cm_senderid snd LEFT JOIN user_management usr on snd.user_id = usr.user_id LEFT JOIN sms_route_master rut on rut.sms_route_id = snd.dlt_process LEFT JOIN sender_business_category cat on snd.sender_buscategory = cat.sender_buscategory_id where snd.sender_status not in ('Y', 'R')Order by snd.cm_sender_id desc`);
		
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
		logger_all.info("[ApproveTemplateList failed response] : " + e);
		return {
			response_code: 0,
			response_status: 201,
			response_msg: 'Error occurred'
		};
	}
}
// ApproveTemplateList - end

// ConsentApproval - start
async function ConsentApproval(req) {
	const logger_all = main.logger_all;
	const logger = main.logger;

	try {
		// Get the authorization header token
		const header_token = req.headers['authorization'];

		// Log the request body
		logger_all.info("[ConsentApproval] : " + JSON.stringify(req.body));

		// Execute the query
		const business_category = await db.query(`SELECT * FROM cm_consent_template tmp LEFT JOIN user_management usr on tmp.user_id = usr.user_id LEFT JOIN cm_senderid snd on snd.cm_sender_id = tmp.cm_sender_id where tmp.cm_consent_status not in ('Y', 'R')Order by tmp.cm_consent_id desc`);
		
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
		logger_all.info("[ConsentApproval failed response] : " + e);
		return {
			response_code: 0,
			response_status: 201,
			response_msg: 'Error occurred'
		};
	}
}
// ConsentApproval - end

// ContentApproval - start
async function ContentApproval(req) {
	const logger_all = main.logger_all;
	const logger = main.logger;

	try {
		// Get the authorization header token
		const header_token = req.headers['authorization'];

		// Log the request body
		logger_all.info("[ContentApproval] : " + JSON.stringify(req.body));

		// Execute the query
		const business_category = await db.query(`SELECT * FROM cm_content_template ntmp LEFT JOIN user_management usr on ntmp.user_id = usr.user_id LEFT JOIN cm_senderid snd on snd.cm_sender_id = ntmp.cm_sender_id LEFT JOIN cm_consent_template tmp on tmp.cm_consent_id = ntmp.cm_consent_id LEFT JOIN sender_business_category cat on ntmp.cn_template_buscategory = cat.sender_buscategory_id where ntmp.cn_status not in ('Y', 'R')Order by ntmp.cm_content_tmplid desc`);
		
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
		logger_all.info("[ContentApproval failed response] : " + e);
		return {
			response_code: 0,
			response_status: 201,
			response_msg: 'Error occurred'
		};
	}
}
// ContentApproval - end

// using for module exporting
module.exports = {
	ApproveTemplateList,
    ConsentApproval,
	ContentApproval
}
