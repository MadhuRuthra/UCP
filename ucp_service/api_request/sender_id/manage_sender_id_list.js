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

// ManageSenderIdList - start
async function ManageSenderIdList(req) {
    const logger_all = main.logger_all;
    const { user_id } = req.body;
    try {
        // query parameters
        logger_all.info("[ManageSenderIdList query parameters] : " + JSON.stringify(req.body));
        let condition = `${user_id != 1 ? `wht.user_id = ${user_id} ` : `(wht.user_id = ${user_id} OR usr.parent_id = ${user_id} )`}`;

        const query_select = `SELECT wht.whatspp_config_id, wht.reject_reason, wht.user_id, usr.user_name, CONCAT(wht.country_code, wht.mobile_no) AS mobile_no, wht.whatspp_config_status, DATE_FORMAT(wht.whatspp_config_entdate, '%d-%m-%Y %h:%i:%s %p') AS whatspp_config_entdate, wht.wht_display_name, wht.wht_display_logo, wht.sent_count, wht.available_credit - wht.sent_count AS available_credit, DATE_FORMAT(wht.whatspp_config_apprdate, '%d-%m-%Y %h:%i:%s %p') AS whatspp_config_apprdate FROM whatsapp_config wht LEFT JOIN user_management usr ON usr.user_id = wht.user_id LEFT JOIN store_details str ON str.store_id = wht.store_id WHERE ${condition} ORDER BY wht.whatspp_config_id DESC`;

        const get_manage_sender_id = await db.query(query_select, [condition]);
            console.log((query_select, [condition]))
        if (get_manage_sender_id.length === 0) {
            return { response_code: 1, response_status: 204, response_msg: 'No data available' };
        }

        return { response_code: 1, response_status: 200, num_of_rows: get_manage_sender_id.length, response_msg: 'Success', sender_id: get_manage_sender_id };
    } catch (e) {
        logger_all.info("[ManageSenderIdList failed response] : " + e);
        return { response_code: 0, response_status: 201, response_msg: 'Error occurred' };
    }
}
// ManageSenderIdList - End

// CountryList - start
async function CountryList(req) {
    var logger_all = main.logger_all
    try {
        // query parameters
        logger_all.info("[CountryList query parameters] : " + JSON.stringify(req.body));
        // to get the master_countries details
        const get_country_list = await db.query(`SELECT shortname, phonecode, id FROM master_countries order by shortname`);
        // if the master_countries length is coming to get the master_countries details.otherwise to send the no data available message.
        if (get_country_list.length == 0) {
            return { response_code: 1, response_status: 204, response_msg: 'No data available' };
        }
        else {
            return { response_code: 1, response_status: 200, num_of_rows: get_country_list.length, response_msg: 'Success', report: get_country_list };
        }
    }
    catch (e) {// any error occurres send error response to client
        logger_all.info("[CountryList failed response] : " + e)
        return { response_code: 0, response_status: 201, response_msg: 'Error occured' };
    }
}
// 	CountryList - end


// ServiceCategoryList function - start
async function ServiceCategoryList(req) {
    var logger_all = main.logger_all
    try {

        // query parameters
        logger_all.info("[ServiceCategoryList query parameters] : " + JSON.stringify(req.body));
        const get_service_category_list = await db.query(`SELECT * FROM message_category where message_category_status = 'Y' ORDER BY message_category_title Asc`);
        // if the get_service_category_list length is '0' to send the no available data.otherwise it will be return the get_service_category_list details.
        if (get_service_category_list.length == 0) {
            return { response_code: 1, response_status: 204, response_msg: 'No data available' };
        }
        else {
            return { response_code: 1, response_status: 200, num_of_rows: get_service_category_list.length, response_msg: 'Success', report: get_service_category_list };
        }
    }
    catch (e) {// any error occurres send error response to client
        logger_all.info("[ServiceCategoryList failed response] : " + e)
        return { response_code: 0, response_status: 201, response_msg: 'Error occured' };
    }
}
// ServiceCategoryList - end

// using for module exporting
module.exports = {
    ManageSenderIdList,
    CountryList,
    ServiceCategoryList
};
