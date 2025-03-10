
// Import necessary modules and dependencies
const db = require("../../db_connect/connect");
require("dotenv").config();
const main = require('../../logger')
// ChangePassword - start
async function BusinessCategory(req) {
	const logger_all = main.logger_all;
	const logger = main.logger;

	try {
		// Get the authorization header token
		const header_token = req.headers['authorization'];

		const {slt_business_category} = req.body;

		// Log the request body
		logger_all.info("[business_category_status] : " + JSON.stringify(req.body));

		// Execute the query
		const business_category = await db.query(`SELECT * FROM sender_business_category where business_category_status = 'Y' ORDER BY sender_buscategory_id Asc`);
		
		const select_business_id = await db.query(`SELECT * FROM sender_business_category where sender_buscategory_id = '${slt_business_category}'`)

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
		logger_all.info("[business_category_status failed response] : " + e);
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
	BusinessCategory
}
