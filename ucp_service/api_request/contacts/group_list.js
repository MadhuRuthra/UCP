/*
API that allows your frontend to communicate with your backend server (Node.js) for processing and retrieving data.
To access a MySQL database with Node.js and can be use it.
This API is used in product menu functions which is used to list product menu & header.

Version : 1.0
Author : Selvalakshmi N (YJ0018)
Date : 03-DEC-2024
*/

const db = require("../../db_connect/connect");
require("dotenv").config();
const main = require('../../logger');

async function GroupList(req) {
	const logger_all = main.logger_all
	const logger = main.logger
	try {

		// get all the req data
		const user_id = req.body.user_id;
		const user_master_id = req.body.user_master_id;
        let get_grpname;
		// query parameters
		logger_all.info("[GroupList query parameters] : " + JSON.stringify(req.body));
		// insert_contact_grp to execute this query
		if(user_master_id != '1'){

			get_grpname = await db.query(`SELECT cmgt.*, (select count(contact_no)from contact_management where contact_mgtgrp_id = cmgt.contact_mgtgrp_id and user_id = cmgt.user_id) cnt_contno FROM contact_mgt_group cmgt where user_id = '${user_id}' ORDER BY contact_mgtgrp_id Desc`);
		}else{

			get_grpname = await db.query(`SELECT cmgt.*, (select count(contact_no)from contact_management where contact_mgtgrp_id = cmgt.contact_mgtgrp_id and user_id = cmgt.user_id) cnt_contno FROM contact_mgt_group cmgt ORDER BY contact_mgtgrp_id Desc`);
		}

		// if the insert_contact_grp length is not available to send the no available data.otherwise it will be return the insert_contact_grp details.
		if (get_grpname.length == 0) {
			return { response_code: 1, response_status: 204, response_msg: 'No data available' };
		}
		else {
			return { response_code: 1, response_status: 200, response_msg: 'Success',num_of_rows: get_grpname.length,reports:get_grpname };
		}
	}
	catch (e) {// any error occurres send error response to client
		logger_all.info("[GroupList failed response] : " + e)
		return { response_code: 0, response_status: 201, response_msg: 'Error occured' };
	}
}

module.exports = {
	GroupList,
};

