
// Import necessary modules and dependencies
const db = require("../../db_connect/connect");
require("dotenv").config();
const main = require('../../logger')

// CmntsSenderid - start
async function CmntsSenderid(req) {
	const logger_all = main.logger_all;
	const logger = main.logger;

	try {
		// Get the authorization header token
		const header_token = req.headers['authorization'];
		const { user_id, senderid, apprej_status, aprg_hdrid } = req.body
		// Log the request body
		logger_all.info("[CmntsSenderid] : " + JSON.stringify(req.body));

		// Execute the query
		const business_category = await db.query(`SELECT snd.*, usr.user_email FROM cm_senderid snd LEFT JOIN user_management usr on usr.user_id = snd.user_id where cm_sender_id = '${senderid}'`);

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
		logger_all.info("[CmntsSenderid failed response] : " + e);
		return {
			response_code: 0,
			response_status: 201,
			response_msg: 'Error occurred'
		};
	}
}
// CmntsSenderid - end

// UpdateCmntsSenderid - start
async function UpdateCmntsSenderid(req) {
	const logger_all = main.logger_all;
	const logger = main.logger;

	try {
		// Get the authorization header token
		const header_token = req.headers['authorization'];
		const { user_id, senderid, apprej_status, aprg_hdrid, apprej_cmnts } = req.body
		// Current Date and Time
		var day = new Date();
		var today_date = day.getFullYear() + '-' + (day.getMonth() + 1) + '-' + day.getDate();
		var today_time = day.getHours() + ":" + day.getMinutes() + ":" + day.getSeconds();
		var current_date = today_date + ' ' + today_time;
		// Log the request body
		logger_all.info("[UpdateCmntsSenderid] : " + JSON.stringify(req.body));

		// Execute the query
		const business_category = await db.query(`UPDATE cm_senderid SET approved_user = '${user_id}', approved_date = '${current_date}',sender_status = '${apprej_status}', approved_comments = '${apprej_cmnts}', header_master_id = '${aprg_hdrid}' WHERE cm_sender_id = '${senderid}'`);

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
		logger_all.info("[UpdateCmntsSenderid failed response] : " + e);
		return {
			response_code: 0,
			response_status: 201,
			response_msg: 'Error occurred'
		};
	}
}
// CmntsSenderid - end

// CmntsConsentid - start
async function CmntsConsentid(req) {
	const logger_all = main.logger_all;
	const logger = main.logger;

	try {
		// Get the authorization header token
		const header_token = req.headers['authorization'];
		const { user_id, consentid, apprej_status, aprg_hdrid } = req.body
		// Log the request body
		logger_all.info("[CmntsConsentid] : " + JSON.stringify(req.body));

		// Execute the query
		const business_category = await db.query(`SELECT snd.*, usr.user_email FROM cm_consent_template snd LEFT JOIN user_management usr on usr.user_id = snd.user_id where cm_consent_id = '${consentid}'`);

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
		logger_all.info("[CmntsConsentid failed response] : " + e);
		return {
			response_code: 0,
			response_status: 201,
			response_msg: 'Error occurred'
		};
	}
}
// CmntsSenderid - end

// UpdateCmntsConsentid - start
async function UpdateCmntsConsentid(req) {
	const logger_all = main.logger_all;
	const logger = main.logger;

	try {
		// Get the authorization header token
		const header_token = req.headers['authorization'];
		const { user_id, consentid, apprej_status, aprg_hdrid, apprej_cmnts } = req.body
		// Current Date and Time
		var day = new Date();
		var today_date = day.getFullYear() + '-' + (day.getMonth() + 1) + '-' + day.getDate();
		var today_time = day.getHours() + ":" + day.getMinutes() + ":" + day.getSeconds();
		var current_date = today_date + ' ' + today_time;
		// Log the request body
		logger_all.info("[UpdateCmntsConsentid] : " + JSON.stringify(req.body));
		const business_category = await db.query(`UPDATE cm_consent_template SET cm_consent_appr_user = '${user_id}', cm_consent_appr_dt = '${current_date}',cm_consent_status = '${apprej_status}', cm_consent_appr_cmnts = '${apprej_cmnts}' WHERE cm_sender_id = '${consentid}'`);

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
		logger_all.info("[UpdateCmntsConsentid failed response] : " + e);
		return {
			response_code: 0,
			response_status: 201,
			response_msg: 'Error occurred'
		};
	}
}
// CmntsSenderid - end

// cmnts_contentid - start
async function cmnts_contentid(req) {
	const logger_all = main.logger_all;
	const logger = main.logger;

	try {
		// Get the authorization header token
		const header_token = req.headers['authorization'];
		const { user_id, contentid, apprej_status, aprg_cmstid, apprej_cmnts } = req.body
		// Log the request body
		logger_all.info("[cmnts_contentid] : " + JSON.stringify(req.body));

		// Execute the query
		const business_category = await db.query(`SELECT snd.*, usr.user_email FROM cm_content_template snd LEFT JOIN user_management usr on usr.user_id = snd.user_id where cm_content_tmplid = '${contentid}'`);

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
		logger_all.info("[cmnts_contentid failed response] : " + e);
		return {
			response_code: 0,
			response_status: 201,
			response_msg: 'Error occurred'
		};
	}
}
// cmnts_contentid - end


// update_cmnts_contentid - start
async function update_cmnts_contentid(req) {
	const logger_all = main.logger_all;
	const logger = main.logger;

	try {
		// Get the authorization header token
		const header_token = req.headers['authorization'];
		const { user_id, contentid, apprej_status, aprg_cmstid, apprej_cmnts } = req.body
		// Current Date and Time
		var day = new Date();
		var today_date = day.getFullYear() + '-' + (day.getMonth() + 1) + '-' + day.getDate();
		var today_time = day.getHours() + ":" + day.getMinutes() + ":" + day.getSeconds();
		var current_date = today_date + ' ' + today_time;
		// Log the request body
		logger_all.info("[update_cmnts_contentid] : " + JSON.stringify(req.body));

		/* '{
	"table_name" : "cm_content_template",
	"values" : "cn_approve_id = \'' . $_SESSION['yjtsms_user_id'] . '\', cn_approve_date = \'' . $current_date . '\', cn_status = \'' . $apprej_status . '\', cn_approve_cmnts = \'' . $apprej_cmnts . '\', tmplt_master_id = \'' . $aprg_cmstid . '\'",
	"where_condition" : "cm_content_tmplid = ' . $contentid . '"
}', */
		const business_category = await db.query(`UPDATE cm_content_template SET cn_approve_id = '${user_id}', cn_approve_date = '${current_date}',cn_status = '${apprej_status}', cn_approve_cmnts = '${apprej_cmnts}', tmplt_master_id = '${aprg_cmstid}' WHERE cm_content_tmplid = '${contentid}'`);

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
		logger_all.info("[ update_cmnts_contentid failed response] : " + e);
		return {
			response_code: 0,
			response_status: 201,
			response_msg: 'Error occurred'
		};
	}
}
// CmntsSenderid - end

// using for module exporting
module.exports = {
	CmntsSenderid,
	UpdateCmntsSenderid,
	CmntsConsentid,
	UpdateCmntsConsentid,
	cmnts_contentid,
	update_cmnts_contentid
}
