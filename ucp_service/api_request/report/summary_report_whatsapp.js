
// Import the required packages and libraries
const db = require('../../db_connect/connect');


require("dotenv").config();
const main = require('../../logger');
const moment = require('moment');
const { createObjectCsvWriter } = require('csv-writer');
const fs = require('fs');
const env = process.env;
const DB_NAME = env.DB_NAME;
async function SummaryReportWhatsapp(req) {
			const { logger_all, logger } = main;
    try {
        logger_all.info(" [summary report] - " + req.body);
        // Get current Date and format as YYYY-MM-DD
        const day = new Date();
        const today_date = `${day.getFullYear()}-${(day.getMonth() + 1).toString().padStart(2, '0')}-${day.getDate().toString().padStart(2, '0')}`;

        // Destructure req.body to extract the variables
        const { filter_date, user_id, user_master_id, rights_name } = req.body;

        // Initialize query-related variables
        let report_query = '', filter_date_1;
        let total_response = [];
        let filter_condition = ``;

        // Set filter_date to today if not provided
        const date_range = filter_date ? filter_date.split("-") : [today_date, today_date];

        logger_all.info("[Otp summary report query parameters] : " + JSON.stringify(req.body));
        const select_rights_id = await db.query(`SELECT * From rights_master where rights_name = '${rights_name}'`)
        let rights_id = select_rights_id[0].rights_id;
        // Build the query based on user_master_id
        if (user_master_id == 1) {
            report_query = `SELECT Distinct wht.campaign_name,wht.user_id, usr.user_name, ussr.user_type, DATE_FORMAT(wht.com_entry_date, '%d-%m-%Y') AS entry_date, wht.total_msg,(CASE WHEN wht.report_status = 'Y' THEN wht.total_waiting ELSE 0 END) AS total_waiting,(CASE WHEN wht.report_status = 'Y' THEN wht.total_process ELSE 0 END) AS total_process,(CASE WHEN wht.report_status = 'Y' THEN wht.total_success ELSE 0 END) AS total_success,(CASE WHEN wht.report_status = 'Y' THEN wht.total_failed ELSE 0 END) AS total_failed,(CASE WHEN wht.report_status = 'Y' THEN wht.total_delivered ELSE 0 END) AS total_delivered,(CASE WHEN wht.report_status = 'Y' THEN wht.total_read ELSE 0 END) AS total_read FROM user_summary_report wht LEFT JOIN user_management usr ON wht.user_id = usr.user_id LEFT JOIN user_master ussr ON usr.user_master_id = ussr.user_master_id WHERE  wht.rights_id = ${rights_id} AND (DATE(wht.com_entry_date) BETWEEN '${date_range[0]}' AND '${date_range[1]}') AND wht.report_status = 'Y' ${filter_condition} ORDER BY wht.com_entry_date DESC`;
        } else {
            report_query = `SELECT Distinct wht.campaign_name,wht.user_id, usr.user_name, ussr.user_type, wht.campaign_name, DATE_FORMAT(wht.com_entry_date, '%d-%m-%Y') AS entry_date, wht.total_msg,(CASE WHEN wht.report_status = 'Y' THEN wht.total_waiting ELSE 0 END) AS total_waiting,(CASE WHEN wht.report_status = 'Y' THEN wht.total_process ELSE 0 END) AS total_process,(CASE WHEN wht.report_status = 'Y' THEN wht.total_success ELSE 0 END) AS total_success,(CASE WHEN wht.report_status = 'Y' THEN wht.total_failed ELSE 0 END) AS total_failed,(CASE WHEN wht.report_status = 'Y' THEN wht.total_delivered ELSE 0 END) AS total_delivered,(CASE WHEN wht.report_status = 'Y' THEN wht.total_read ELSE 0 END) AS total_read FROM user_summary_report wht LEFT JOIN user_management usr ON wht.user_id = usr.user_id LEFT JOIN user_master ussr ON usr.user_master_id = ussr.user_master_id WHERE (usr.user_id = '${user_id}' OR usr.parent_id IN (${user_id})) AND wht.rights_id = ${rights_id} AND (DATE(wht.com_entry_date) BETWEEN '${date_range[0]}' AND '${date_range[1]}') AND wht.report_status = 'Y' ${filter_condition} ORDER BY wht.com_entry_date DESC`;
        }

        // Execute the query
        const getsummary = await db.query(report_query);

        // Check if the query returned any results
        if (!getsummary.length) {
            logger.info("[API SUCCESS RESPONSE - No data available]");
            return {
                response_code: 1,
                response_status: 201,
                response_msg: 'No data available'
            };
        } else {
            logger.info("[API SUCCESS RESPONSE - Data found]");
            return {
                response_code: 1,
                response_status: 200,
                response_msg: 'Success',
                report: getsummary
            };
        }
    } catch (e) {
        logger_all.info("[summary report - error] : " + e);
        logger.info("[Failed response - Error occurred]");
        return {
            response_code: 0,
            response_status: 201,
            response_msg: 'Error occurred'
        };
    }
}
// End function to create a summary report

module.exports = {
    SummaryReportWhatsapp,
};

