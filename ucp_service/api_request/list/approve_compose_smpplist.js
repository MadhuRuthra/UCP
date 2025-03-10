/*
This API handles chat API functions for connecting to mobile chat.
This page acts as a backend, connecting Node.js API and PHP frontend.
It collects form details, sends them to the API, and returns the response to the frontend.

Version : 1.0
Author : Madhubala (YJ0009)
Date : 05-Jul-2023
*/

// Import the required packages and libraries
const db = require('../../db_connect/connect');


require("dotenv").config();
const main = require('../../logger');
const moment = require('moment');
const { createObjectCsvWriter } = require('csv-writer');
const fs = require('fs');
const env = process.env;
const DB_NAME = env.DB_NAME;
// Approve_Composesms_List function - start
async function Approve_ComposeSMPP_List(req) {
    const logger_all = main.logger_all;
    const logger = main.logger;

    try {
        // Declare the variables
        logger_all.info(JSON.stringify(req.body))
        let { user_id, user_master_id } = req.body;
        let sms_query = '';

        logger_all.info(user_master_id);

        // Construct the SQL query based on user_id
        if (user_master_id.toString() === '1') {
            sms_query = `
                SELECT mt.*, um.user_name 
                FROM compose_smpp mt
                JOIN user_management um ON mt.user_id = um.user_id where mt.ucp_status = 'W'
                ORDER BY mt.ucp_start_date DESC`;
        }
         else {
            sms_query = `
                SELECT mt.*, um.user_name 
                FROM compose_smpp mt
                JOIN user_management um ON mt.user_id = um.user_id
                WHERE mt.user_id = ${user_id} and mt.ucp_status = 'W'
                ORDER BY mt.ucp_start_date DESC`;
        }

        // Execute the query
        const sms_list = await db.query(sms_query);

        // Check if any templates are returned
        if (sms_list.length === 0) {
            return { response_code: 1, response_status: 204, response_msg: 'No data available' };
        } else {
            return {
                response_code: 1,
                response_status: 200,
                response_msg: 'Success',
                num_of_rows: sms_list.length,
                report: sms_list
            };
        }

    } catch (e) {
        // Log the error and send an error response to the client
        logger_all.info("[Template List failed response] : " + e);
        return { response_code: 0, response_status: 500, response_msg: 'An error occurred' };
    }
}
// Approve_Composesms_List - end

// Export the Approve_Composesms_List function for use in other modules
module.exports = {
    Approve_ComposeSMPP_List
};