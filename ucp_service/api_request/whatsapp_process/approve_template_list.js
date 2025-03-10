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
// approveTemplateList Function - start
async function approveTemplateList(req) {
const { logger_all, logger } = main;
    try {
      
        // query parameters
        logger_all.info("[approveTemplateList query parameters] : " + JSON.stringify(req.body));
            const get_approve_whatsapp_no_api = await db.query(`SELECT tmp.unique_template_id ,tmp.template_id, tmp.template_name, tmp.template_category, tmp.template_message,tmp.media_url,tmp.media_type,tmp.body_variable_count, tmp.template_response_id, tmp.template_status, DATE_FORMAT(tmp.template_entdate,'%d-%m-%Y %h:%i:%s %p') template_entdate, DATE_FORMAT(tmp.approve_date,'%d-%m-%Y %h:%i:%s %p') approve_date, crt.user_id created_userid, crt.user_name created_username, lng.language_id, lng.language_name, lng.language_code, cnf.whatspp_config_id, cnf.user_id receiver_userid, cnf.mobile_no, cnf.whatsapp_business_acc_id, cnf.phone_number_id, cnf.bearer_token, cnf.country_id, cnf.country_code FROM message_template tmp left join user_management crt on tmp.created_user = crt.user_id left join master_language lng on lng.language_id = tmp.language_id left join whatsapp_config cnf on cnf.whatspp_config_id = tmp.whatsapp_config_id where tmp.template_status = 'N' order by tmp.template_entdate desc`);
        // get_approve_whatsapp_no_api length is '0' to through the no data available message. 
        if (get_approve_whatsapp_no_api.length == 0) {
            return { response_code: 1, response_status: 204, response_msg: 'No data available' };
        }
        else { // otherwise get_approve_whatsapp_no_api to get the success message anag get_approve_whatsapp_no_api length and get_approve_whatsapp_no_api details
            return { response_code: 1, response_status: 200, num_of_rows: get_approve_whatsapp_no_api.length, response_msg: 'Success', report: get_approve_whatsapp_no_api };
        }
    }
    catch (e) { // any error occurres send error response to client
        logger_all.info("[approveTemplateList failed response] : " + e)
        return { response_code: 0, response_status: 201, response_msg: 'Error occured' };
    }
}
// approveTemplateList Function - end
// using for module exporting
module.exports = {
    approveTemplateList
}
