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

async function Manage_Plans(req) {
    const logger_all = main.logger_all;
    const logger = main.logger;

    try {
        // Validate req.body
        if (!req.body || typeof req.body !== "object") {
            throw new Error("Invalid request body");
        }

        const { user_id, txt_total_message, txt_price_per_msg, plan_status, plan_id,txt_plan_name,txt_product_name } = req.body;

        logger_all.info("[Manage_Plans query parameters]: " + JSON.stringify(req.body));

        if (plan_id) {
            const updateQuery = `UPDATE pricing_slot SET rights_id = ?, plan_name = ?, price_to = ?, price_per_message = ?,pricing_slot_status = ? WHERE pricing_slot_id = ?`;
            const updateResult = await db.query(updateQuery, [txt_product_name,txt_plan_name,txt_total_message, txt_price_per_msg, plan_status,plan_id]);

            if (updateResult.affectedRows) {
                return { response_code: 1, response_status: 200, response_msg: "Success" };
            } else {
                return { response_code: 0, response_status: 204, response_msg: "No data available" };
            }
        } else {
            const checkQuery = `SELECT * FROM pricing_slot WHERE plan_name = ? `;
            const existingGroup = await db.query(checkQuery, [txt_plan_name]);

            if (existingGroup.length > 0) {
                return { response_code: 1, response_status: 204, response_msg: "This plan name is already used. Please try another." };
            }

            const insertQuery = `INSERT INTO pricing_slot VALUES (NULL, ?, ?, 1,?,?,?, CURRENT_TIMESTAMP)`;
            const insertResult = await db.query(insertQuery, [txt_product_name,txt_plan_name,txt_total_message, txt_price_per_msg, plan_status]);

            if (insertResult.affectedRows) {
                return { response_code: 1, response_status: 200, response_msg: "Success" };
            } else {
                return { response_code: 0, response_status: 204, response_msg: "No data available" };
            }
        }
    } catch (error) {
        logger_all.error("[Manage_Plans failed response]: " + error.message);
        return { response_code: 0, response_status: 500, response_msg: "An error occurred." };
    }
}
module.exports = {
	Manage_Plans,
}
