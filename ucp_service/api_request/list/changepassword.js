
// Import necessary modules and dependencies
const db = require("../../db_connect/connect");
require("dotenv").config();
const main = require('../../logger')
// ChangePassword - start
async function ChangePassword(req) {
	const logger_all = main.logger_all
	const logger = main.logger;
	const md5 = require("md5")
	try {
		//  Get all the req header data
		const header_token = req.headers['authorization'];

		// get all the req data
		let ex_password = md5(req.body.ex_password);
		let new_password = md5(req.body.new_password);
		// query parameters
		logger_all.info("[Change Password query parameters] : " + JSON.stringify(req.body));
		// To get the User_id
		let get_user = `SELECT * FROM user_management where user_bearer_token = '${header_token}' AND usr_mgt_status = 'Y' `;
		if (req.body.user_id) {
			get_user = get_user + `and user_id = '${req.body.user_id}' `;
		}
		const get_user_id = await db.query(get_user);
		// If get_user not available send error response to client
		if (get_user_id.length == 0) {
			logger_all.info("Invalid Token")
			return { response_code: 0, response_status: 201, response_msg: 'Invalid Token' };
		}
		else {// otherwise to get the user details
			user_id = get_user_id[0].user_id;
		}

		// get_change_password this condition is true.process will be continued. otherwise process are stoped.
		const get_change_password = await db.query(`SELECT * FROM user_management where user_id = '${user_id}' and login_password = '${ex_password}'`);

		// if the get_change_password length is not available to send the Invalid Existing Password. Kindly try again!.otherwise the process was continued
		if (get_change_password.length == 0) {
			return {
				response_code: 0,
				response_status: 201,
				response_msg: 'Invalid Existing Password. Kindly try again!'
			};
		} else { // to update the user_management new password.
			const update_succ = await db.query(`UPDATE user_management SET login_password = '${new_password}' WHERE user_id = '${user_id}'`);

			return { // to return the success message
				response_code: 1,
				response_status: 200,
				response_msg: 'Success'
			};
		}

	} catch (e) {// any error occurres send error response to client
		logger_all.info("[ChangePassword failed response] : " + e)
		return {
			response_code: 0,
			response_status: 201,
			response_msg: 'Error occured'
		};
	}
}
// ChangePassword - end

// using for module exporting
module.exports = {
	ChangePassword
}
