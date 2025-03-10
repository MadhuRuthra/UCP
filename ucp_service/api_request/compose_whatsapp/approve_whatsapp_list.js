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
require("dotenv").config();
const main = require('../../logger');
// ComposeApproveWhatsapp Function - start
async function ComposeApproveWhatsapp(req) {
    var logger_all = main.logger_all
    var logger = main.logger
    try {
        // query parameters
        logger_all.info("[ComposeApproveWhatsapp query parameters] : " + JSON.stringify(req.body));

        // to get_approve_whatsapp_no_api using
        const get_approve_whatsapp_no_api = await db.query(`SELECT * from compose_whatsapp wtsp left join user_management usr on wtsp.user_id = usr.user_id left join message_template tmpl on tmpl.template_id = wtsp.template_id left join master_language ml on ml.language_id = tmpl.language_id where wtsp.ucp_status = 'W' order by compose_ucp_id desc`);

        // get_approve_whatsapp_no_api length is '0' to through the no data available message. 
        if (get_approve_whatsapp_no_api.length == 0) {
            return { response_code: 1, response_status: 204, response_msg: 'No data available' };
        }
        else { // otherwise get_approve_whatsapp_no_api to get the success message anag get_approve_whatsapp_no_api length and get_approve_whatsapp_no_api details
            return { response_code: 1, response_status: 200, num_of_rows: get_approve_whatsapp_no_api.length, response_msg: 'Success', report: get_approve_whatsapp_no_api };
        }
    }
    catch (e) { // any error occurres send error response to client
        logger_all.info("[ComposeApproveWhatsapp failed response] : " + e)
        return { response_code: 0, response_status: 201, response_msg: 'Error occured' };
    }
}
// ComposeApproveWhatsapp Function - end
// using for module exporting
module.exports = {
    ComposeApproveWhatsapp
}
