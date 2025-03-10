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
const main = require('../../logger');
// ComposeSMSList function - start
async function ComposeSMSList(req) {
    const logger_all = main.logger_all;
    const logger = main.logger;

    try {
        // Declare the variables
       let { user_id,rights_name } = req.body;
        let template_query = '';
        const get_rights_id = await db.query(`SELECT * FROM rights_master where rights_name = '${rights_name}'`);
        let rights_id = get_rights_id[0]?.rights_id;

        // Construct SQL query based on the user_master_id and user_id
        if (user_master_id.toString() === '1') {
            template_query = `SELECT mt.*, um.user_name FROM compose_sms mt JOIN user_management um ON mt.user_id = um.user_id and mt.rights_id = ${rights_id} ORDER BY mt.compose_ucp_id DESC`;
        }
        else {
            template_query = `SELECT mt.*, um.user_name FROM compose_sms mt JOIN user_management um ON mt.user_id = um.user_id and mt.rights_id = ${rights_id} WHERE mt.user_id = ${user_id} ORDER BY mt.compose_ucp_id DESC`;
        }

        // Execute the query
        const template_result = await db.query(template_query);

        // Check if any templates are returned
        if (template_result.length === 0) {
            return { response_code: 1, response_status: 204, response_msg: 'No data available' };
        } else {
            return {
                response_code: 1,
                response_status: 200,
                response_msg: 'Success',
                num_of_rows: template_result.length,
                templates: template_result
            };
        }

    } catch (e) {
        // Log the error and send an error response to the client
        logger_all.info("[Template List failed response] : " + e);
        return { response_code: 0, response_status: 500, response_msg: 'An error occurred' };
    }
}
// ComposeSMSList - end

// Export the ComposeSMSList function for use in other modules
module.exports = {
    ComposeSMSList
};