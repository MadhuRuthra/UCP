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
// approveComposeMessage Function - start

async function generatereportlist(req) {

    try {
        
        const get_report_list = await db.query(`SELECT c.compose_ucp_id,c.campaign_name, c.total_mobile_no_count,c.unique_compose_id, c.compose_entry_date, u.user_name,c.compose_ucp_id,c.ucp_status, c.user_id FROM compose_sms AS c JOIN user_management AS u ON c.user_id = u.user_id where c.ucp_status in ('V') ORDER BY compose_entry_date DESC`);

        if (get_report_list.length == 0) {
            return { response_code: 1, response_status: 204, response_msg: 'No data available' };
        } else {
            return { response_code: 1, response_status: 200, num_of_rows: get_report_list.length, response_msg: 'Success', report: get_report_list };
        }
    } catch (e) {
        console.error("Error occurred:", e);
        return { response_code: 0, response_status: 201, response_msg: 'Error occurred' };
    }
}

// approveComposeMessage Function - end

async function generate_report_list_smpp(req) {

    try {
        const header_token = req.headers['authorization'];
        let { user_id, user_master_id } = req.body;
        let user_ids = [];
        const userIds = await db.query("SELECT user_id FROM user_management");

        let report_generate_list = "";
        for (let i = 0; i < userIds.length; i++) {
            user_ids.push(userIds[i].user_id);
        }
        let array_list_userid_string = user_ids.join("','");
        if (user_master_id == 1 && user_id == 1) {

            report_generate_list = `SELECT c.compose_ucp_id,c.campaign_name, c.total_mobile_no_count,c.unique_compose_id, c.compose_entry_date, u.user_name,c.compose_ucp_id,c.ucp_status, c.user_id FROM compose_smpp AS c JOIN user_management AS u ON c.user_id = u.user_id  where c.user_id in ('${array_list_userid_string}') and c.ucp_status in ('V') ORDER BY compose_entry_date DESC`;

           
        } else if (user_master_id == 1 && user_id != 1) {

            report_generate_list = `SELECT c.compose_ucp_id,c.campaign_name, c.total_mobile_no_count, c.compose_entry_date,c.unique_compose_id, u.user_name,c.compose_ucp_id,c.ucp_status, c.user_id FROM compose_smpp AS c JOIN user_management AS u ON c.user_id = u.user_id  where u.parent_id in ('${user_id}') and c.ucp_status in ('V') ORDER BY compose_entry_date DESC`;

           
        }
        else if (user_master_id == 2) {

            report_generate_list = `SELECT c.compose_ucp_id,c.campaign_name, c.total_mobile_no_count, c.compose_entry_date, u.user_name,c.unique_compose_id,c.compose_ucp_id,c.ucp_status, c.user_id FROM compose_smpp AS c JOIN user_management AS u ON c.user_id = u.user_id  where (u.parent_id = ${user_id} or u.user_id = ${user_id}) and c.ucp_status in ('V') ORDER BY compose_entry_date DESC`;
        }
        else {

            report_generate_list = `SELECT c.compose_ucp_id,c.campaign_name, c.total_mobile_no_count, c.compose_entry_date, u.user_name,c.unique_compose_id,c.compose_ucp_id,c.ucp_status, c.user_id FROM compose_smpp AS c JOIN user_management AS u ON c.user_id = u.user_id  where c.user_id in ('${array_list_userid_string}') and c.ucp_status in ('V') ORDER BY compose_entry_date DESC`;
            
        }
        const get_approve_rcs_no_api = await db.query(report_generate_list);
        if (get_approve_rcs_no_api.length == 0) {
            return { response_code: 1, response_status: 204, response_msg: 'No data available' };
        } else {
            return { response_code: 1, response_status: 200, num_of_rows: get_approve_rcs_no_api.length, response_msg: 'Success', report: get_approve_rcs_no_api };
        }
    } catch (e) {
        console.error("Error occurred:", e);
        return { response_code: 0, response_status: 201, response_msg: 'Error occurred' };
    }
}
// using for module exporting
module.exports = {
    generatereportlist,
    generate_report_list_smpp
}
