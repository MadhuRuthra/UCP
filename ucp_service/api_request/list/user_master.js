/*
API that allows your frontend to communicate with your backend server (Node.js) for processing and retrieving data.
To access a MySQL database with Node.js and can be use it.
This API is used in manageusers list functions which is used to list users.

Version : 1.0
Author : Selvalakshmi N (YJ0018)
Date : 03-DEC-2024
*/

// Import the required packages and libraries
const db = require("../../db_connect/connect");
require("dotenv").config();
const main = require('../../logger');
// Start function to User_Master
async function User_Master(req) {
	var logger_all = main.logger_all
	var logger = main.logger
	try {

		// query parameters
		logger_all.info("[User_Master query parameters] : " + JSON.stringify(req.body));

		const get_manage_users = await db.query(`SELECT * from user_master where user_master_status = 'Y'`);
		// if the get_manage_users length is '0' to get the no available data.otherwise it will be return the push the get_manage_users details.
		if (get_manage_users.length == 0) {
			return {
				response_code: 1,
				response_status: 204,
				response_msg: 'No data available'
			};
		} else {
			return {
				response_code: 1,
				response_status: 200,
				num_of_rows: get_manage_users.length,
				response_msg: 'Success',
				report: get_manage_users
			};
		}

	} catch (e) {  // any error occurres send error response to client
		logger_all.info("[User_Master failed response] : " + e)
		return {
			response_code: 0,
			response_status: 201,
			response_msg: 'Error occured'
		};
	}
}
// End Function to User_Master

// using for module exporting
module.exports = {
	User_Master
}