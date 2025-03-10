/*
API that allows your frontend to communicate with your backend server (Node.js) for processing and retrieving data.
To access a MySQL database with Node.js and can be use it.
This page is used in dashboard functions which is used to get the dashboard details.

Version : 1.0
Author : Madhubala (YJ0009)
Date : 05-Jul-2023
*/
const db = require("../../db_connect/connect");
require('dotenv').config()
const main = require('../../logger');
// Dashboard OTP Function - start
async function Dash_Board(req) {
    const logger_all = main.logger_all;
    const logger = main.logger;

    try {
        // Get today's date
        const today = new Date();
        // Function to format date to DD-MM-YYYY
        const formatDate = (date) => {
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();
            return `${day}-${month}-${year}`;
        };

        // Declare arrays
        const { user_id } = req.body;
        
        let get_response_array = [];
        // Log query parameters
        logger_all.info("[Dashboard query parameters] : " + JSON.stringify(req.body));

        // Get user details
        const get_user_details = await db.query(`SELECT ml.available_messages,rm.rights_name,usr.user_name from message_limit ml LEFT JOIN rights_master rm ON rm.rights_id = ml.rights_id LEFT JOIN user_management usr ON usr.user_id = ml.user_id where ml.user_id = '${user_id}' and ml.message_limit_status = 'Y'`);
        for (let j = 1; j <= get_user_details.length ; j++) {
            let total_response = [];
            // Loop through the last 7 days
            for (let i = 0; i < 7; i++) {
                const pastDate = new Date(today);
                pastDate.setDate(today.getDate() - i);
                // Get date in YYYY-MM-DD format for MySQL
                const formattedDate = pastDate.toISOString().split('T')[0]; // '2024-10-23'

                const dashboard_user_1 = await db.query(`SELECT rm.rights_name, DATE_FORMAT(wht.com_entry_date, '%d-%m-%Y') AS entry_date, SUM(wht.total_msg) AS total_msg, SUM(wht.total_waiting) AS total_waiting, SUM(wht.total_process) AS total_process, SUM(wht.total_success) AS total_success, SUM(wht.total_delivered) AS total_delivered, SUM(wht.total_failed) AS total_failed, SUM(wht.total_read) AS total_read FROM user_summary_report wht LEFT JOIN user_management usr ON wht.user_id = usr.user_id LEFT JOIN user_master ussr ON usr.user_master_id = ussr.user_master_id LEFT JOIN rights_master rm ON wht.rights_id = rm.rights_id  WHERE (usr.user_id = '${user_id}') AND (DATE(wht.com_entry_date) BETWEEN '${formattedDate}' AND '${formattedDate}') AND wht.rights_id = ${j} GROUP BY usr.user_master_id, DATE(wht.com_entry_date) ORDER BY usr.user_master_id, usr.user_name, entry_date DESC`);

                if (dashboard_user_1.length > 0) {
                    total_response.push(dashboard_user_1[0]);
                } else {
                    total_response.push({
                        rights_name: get_user_details[j-1].rights_name,
                        entry_date: formatDate(pastDate), // Use formatted date here
                        total_msg: 0,
                        total_success: 0,
                        total_failed: 0,
                        total_invalid: 0,
                        total_waiting: 0,
                        total_process: 0,
                    });
                }
            }
            get_response_array.push(total_response)

        }

        return {
            response_code: 1,
            response_status: 200,
            response_msg: 'Success',
            
            report: get_response_array,
            rights_name: get_user_details
        };
    } catch (e) {
        logger_all.error("[DashBoard OTP failed response] : " + e.stack); // Log error stack
        return { response_code: 0, response_status: 201, response_msg: 'Error occurred' };
    }
}
// Dash_Board - end
// using for module exporting
module.exports = {
    Dash_Board,
};