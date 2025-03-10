/*
This api has chat API functions which is used to connect the mobile chat.
This page is act as a Backend page which is connect with Node JS API and PHP Frontend.
It will collect the form details and send it to API.
After get the response from API, send it back to Frontend.

Version : 1.0
Author : Madhubala (YJ0009)
Date : 05-Jul-2023
*/
// Import the required packages and libraries
const db = require("../../db_connect/connect");
const dotenv = require('dotenv');
dotenv.config();
require('dotenv').config()
const { count } = require("sms-length");
const env = process.env
const DB_NAME = env.DB_NAME;
const main = require('../../logger');
// Reject_Campaign function - start
async function Reject_Campaign(req) {
    const logger_all = main.logger_all
    const logger = main.logger
    // Save phone_number_id, rcs_business_acc_id, bearer_token
    try {

        // get all the req data
        let { compose_message_id, campaign_status, selected_userid, reason, user_id } = req.body;

        // declare the variable
        let update_campaign_set = "", update_create_value = "";
        // query parameters
        logger_all.info("[Reject_Campaign query parameters] : " + JSON.stringify(req.body));

        get_campaign = await db.query(`SELECT total_mobile_no_count,ucp_status,rights_id FROM compose_whatsapp WHERE ucp_status = 'W' and compose_ucp_id = '${compose_message_id}' `);

        if (get_campaign.length > 0) {

            let total_mobileno = get_campaign[0].total_mobile_no_count;
            let rights_id = get_campaign[0].rights_id;

            update_campaign_set = await db.query(`UPDATE compose_whatsapp SET ucp_status = '${campaign_status}',reject_reason = '${reason}' WHERE ucp_status = 'W' and compose_ucp_id = '${compose_message_id}'`);

            const select_user_master_id = await db.query(`SELECT user_master_id From user_management where user_id = ${selected_userid}`);
            let user_master_id = select_user_master_id[0].user_master_id;
            logger_all.info("USER Master Id:-", user_master_id)
            if (user_master_id !== 1) {
                logger_all.info("INside if condition");
                update_create_value = await db.query(`UPDATE message_limit SET available_messages = available_messages + ${total_mobileno} WHERE user_id = '${selected_userid}' and rights_id = ${rights_id} and message_limit_status = 'Y'`);
            }
            // if the update_wpcnf is successfully updated to return the success message
            if (update_campaign_set.affectedRows) {
                return {
                    response_code: 1,
                    response_status: 200,
                    num_of_rows: 1,
                    response_msg: 'Success'
                };
            } else {
                return { // otherwise the failed the message response.
                    response_code: 1,
                    response_status: 204,
                    response_msg: 'Failed'
                };
            }
        } else {
            logger_all.info("[update query response] : response_code: 1,response_status: 204,response_msg: 'Campaign Not Found.'")
            return { // otherwise the failed the message response.
                response_code: 1,
                response_status: 204,
                response_msg: 'Campaign Not Found.'
            };
        }
    } catch (e) { // any error occurres send error response to client
        logger_all.info("[Reject_Campaign failed response] : " + e)
        return {
            response_code: 0,
            response_status: 201,
            response_msg: 'Error occured'
        };
    }
}
// Reject_Campaign - end

// using for module exporting
module.exports = {
    Reject_Campaign
}
