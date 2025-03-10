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
const main = require('../../logger')

async function Add_Group(req) {
    const logger_all = main.logger_all;
    const logger = main.logger;

    try {
        // Validate req.body
        if (!req.body || typeof req.body !== "object") {
            throw new Error("Invalid request body");
        }

        const { user_id, group_name, group_status, group_description, group_id } = req.body;

        logger_all.info("[Add_Group query parameters]: " + JSON.stringify(req.body));

        if (group_id) {
            const updateQuery = `UPDATE contact_mgt_group SET contact_group_status = ?, contact_group_desc = ?, contact_group_title = ? WHERE contact_mgtgrp_id = ?`;
            const updateResult = await db.query(updateQuery, [group_status, group_description, group_name, group_id]);

            if (updateResult.affectedRows) {
                return { response_code: 1, response_status: 200, response_msg: "Success" };
            } else {
                return { response_code: 0, response_status: 204, response_msg: "No data available" };
            }
        } else {
            const checkQuery = `SELECT * FROM contact_mgt_group WHERE contact_group_title = ? AND user_id = ?`;
            const existingGroup = await db.query(checkQuery, [group_name, user_id]);

            if (existingGroup.length > 0) {
                return { response_code: 1, response_status: 204, response_msg: "This title is already used. Please try another." };
            }

            const insertQuery = `INSERT INTO contact_mgt_group VALUES (NULL, ?, ?, ?, CURRENT_TIMESTAMP, ?)`;
            const insertResult = await db.query(insertQuery, [group_name, group_description, group_status, user_id]);

            if (insertResult.affectedRows) {
                return { response_code: 1, response_status: 200, response_msg: "Success" };
            } else {
                return { response_code: 0, response_status: 204, response_msg: "No data available" };
            }
        }
    } catch (error) {
        logger_all.error("[Add_Group failed response]: " + error.message);
        return { response_code: 0, response_status: 500, response_msg: "An error occurred." };
    }
}
module.exports = {
	Add_Group,
};

