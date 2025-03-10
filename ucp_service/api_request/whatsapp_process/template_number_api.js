/*
API that allows your frontend to communicate with your backend server (Node.js) for processing and retrieving data.
To access a MySQL database with Node.js and can be use it.
This page is used in template function which is used to get a number of template
details.

Version : 1.0
Author : Madhubala (YJ0009)
Date : 05-Jul-2023
*/
// Import the required packages and libraries
const db = require("../../db_connect/connect");
const main = require('../../logger')
require('dotenv').config();
// getTemplateNumber - start
async function getTemplateNumber(req) {
    try {
        var logger_all = main.logger_all
        const { user_id, user_master_id: user_type, template_id } = req.body;
        // get all the req data
        var select_template_numbers = '';
        // query parameters
        logger_all.info("[get template numbers query parameters] : " + JSON.stringify(req.body));

        if (user_type != 1) {//if the user type is '3' the process are executed and to get the userid will act as a parent id.

            select_template_numbers = await db.query(`SELECT distinct wht.mobile_no, wht.available_credit- wht.sent_count available_credit,wht.country_code FROM message_template tmp left join whatsapp_config wht on tmp.whatsapp_config_id = wht.whatspp_config_id left join master_language lng on lng.language_id = tmp.language_id where tmp.unique_template_id = '${template_id}' and (wht.user_id = '${user_id}' or wht.parent_id = '${user_id}') and wht.whatspp_config_status = 'Y' and template_status = 'Y' ORDER BY wht.mobile_no ASC`);

        } else {

            select_template_numbers = await db.query(`SELECT distinct wht.mobile_no, wht.available_credit- wht.sent_count available_credit,wht.country_code FROM message_template tmp left join whatsapp_config wht on tmp.whatsapp_config_id = wht.whatspp_config_id left join master_language lng on lng.language_id = tmp.language_id where tmp.unique_template_id = '${template_id}' and wht.whatspp_config_status = 'Y' and template_status = 'Y' ORDER BY wht.mobile_no ASC`);

        }

        // to return the success message 
        return { response_code: 1, response_status: 200, response_msg: 'Success', num_of_rows: select_template_numbers.length, data: select_template_numbers };

    }
    catch (e) {// any error occurres send error response to client
        logger_all.info("[get template numbers failed response] : " + e)
        return { response_code: 0, response_status: 201, response_msg: 'Error Occurred ' };
    }
}
// getTemplateNumber - end

// PgetTemplateNumber - start
async function PgetTemplateNumber(req) {
    try {
        var logger_all = main.logger_all

        // Get all the req data
        let template_id = req.body.template_id;
        // query parameters
        logger_all.info("[get template numbers query parameters] : " + JSON.stringify(req.body));
        const select_template_numbers = await db.query(`SELECT distinct wht.whatspp_config_id, wht.sent_count, wht.available_credit, wht.user_id, wht.store_id, wht.country_code, wht.mobile_no,wht.phone_number_id, wht.whatsapp_business_acc_id, wht.bearer_token FROM message_template tmp left join whatsapp_config wht on tmp.whatsapp_config_id = wht.whatspp_config_id left join master_language lng on lng.language_id = tmp.language_id where tmp.unique_template_id = '${template_id}' and wht.whatspp_config_status = 'Y' ORDER BY wht.mobile_no ASC`);
        // to return the success message 
        return { response_code: 1, response_status: 200, response_msg: 'Success', data: select_template_numbers };

    }
    catch (e) {// any error occurres send error response to client
        logger_all.info("[get template numbers failed response] : " + e)
        return { response_code: 0, response_status: 201, response_msg: 'Error Occurred ' };
    }
}
// PgetTemplateNumber - end

// getVariableCount - start
async function getVariableCount(req) {
    try {
        var logger_all = main.logger_all
        // Get all the req data
        const { template_lang, template_name } = req.body;
        // query parameters
        logger_all.info("[get template variable count query parameters] : " + JSON.stringify(req.body));

        // to check template_name ,template_status = 'Y',language_code to select_variable_count 
        const select_variable_count = await db.query(`SELECT tmp.body_variable_count FROM message_template tmp LEFT JOIN master_language lan ON lan.language_id = tmp.language_id WHERE tmp.template_name = '${template_name}' AND tmp.template_status = 'Y' AND lan.language_code = '${template_lang}'`);
        //if the select_variable_count length is '0' to send the 'Template not available' in the response message.
        if (select_variable_count.length == 0) {
            return { response_code: 0, response_status: 201, response_msg: 'Template not available' };
        }
        else { // otherwise to send the success message, select_variable_count,body_variable_count
            return { response_code: 1, response_status: 200, response_msg: 'Success', variable_count: select_variable_count[0].body_variable_count };
        }
    }
    catch (e) { // any error occurres send error response to client
        logger_all.info("[get template variable count failed response] : " + e)
        return { response_code: 0, response_status: 201, response_msg: 'Error Occurred ' };
    }
}
// getVariableCount - end

// using for module exporting
module.exports = {
    getTemplateNumber,
    PgetTemplateNumber,
    getVariableCount
};
