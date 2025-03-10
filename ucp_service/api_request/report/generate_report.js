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
const moment = require('moment');
const { createObjectCsvWriter } = require('csv-writer');
const fs = require('fs');
const env = process.env
const DB_NAME = env.DB_NAME;
const csvFilePath = env.csvFilePath;
async function generatereport(req, res) {
    const logger = main.logger

    const logger_all = main.logger_all;

    const { compose_user_id: user_id, compose_id: campaign_id } = req.body;

    const currentDate = new Date();

    // Format date and time without spaces

    logger_all.info('CSV file processing started.');
    // Use a stream to read the CSV file
    let data = [];
    const report_data = await db.query(`
        SELECT 
            usr.user_name,
            cmm.campaign_name AS campaign_name,
            cmp.mobile_no,
            CASE 
                WHEN cmp.comsms_status = 'F' THEN 'Failure'
                ELSE 'SUCCESS'
            END AS response_status,
            cmp.comsms_entry_date,
            cmp.comsms_sent_date
        FROM 
            compose_sms cmm
            LEFT JOIN ${DB_NAME}_${user_id}.compose_ucp_status_${user_id} cmp ON cmm.compose_ucp_id = cmp.compose_sms_id 
            LEFT JOIN user_management usr ON usr.user_id = cmm.user_id 
        WHERE 
            cmp.compose_sms_id = '${campaign_id}' 
        ORDER BY 
            cmp.comsms_entry_date;
    `);
    
    if (report_data.length == 0) {
        return { response_code: 0, response_status: 201, response_msg: 'No data available.' };
    }
    console.log(report_data[0])
    let campaign_name_file = report_data[0].campaign_name.replaceAll("\n", "");
    let download_csvFilePath = `${csvFilePath}${campaign_name_file}.csv`
    for (let i = 0; i < report_data.length; i++) {
        let single_data = report_data[i];
        logger_all.info(single_data);

        // Format the response date and time
        let formattedDateTime = moment(single_data.response_date).isValid() ? moment(single_data.response_date).format('YYYY-MM-DD HH:mm:ss') : "-";

        // Format the delivery date and time
        let formattedDelDateTime = moment(single_data.delivery_date).isValid() ? moment(single_data.delivery_date).format('YYYY-MM-DD HH:mm:ss') : "-";

        // Push formatted data into the array
        data.push({
            user_name: single_data.user_name,
            rcs_campaign: single_data.campaign_name,
            template_id: single_data.template_id,
            mobile_no: single_data.mobile_no,
            response_status: single_data.response_status || "-",  // Use fallback for undefined or null
            response_date: formattedDateTime,
            delivery_status: single_data.delivery_status || "-",  // Default to "-" if delivery_status is missing
            delivery_date: formattedDelDateTime
        });
    }

    // Log the entire data array after the loop
    console.log(data);


    // Define CSV file headers
    const csvWriter = createObjectCsvWriter({
        path: download_csvFilePath,  // File path to save the CSV
        header: [
            { id: 'user_name', title: 'User Name' },
            { id: 'rcs_campaign', title: 'Campaign Name' },
            { id: 'mobile_no', title: 'Mobile No' },
            { id: 'response_status', title: 'Response Status' },
            { id: 'response_date', title: 'Response Date' },
            { id: 'delivery_status', title: 'Delivery Status' },
            { id: 'delivery_date', title: 'Delivery Date' }
        ]
    });
try {
    await csvWriter.writeRecords(data);
    logger_all.info('CSV file written successfully - ' + download_csvFilePath);

    // Perform database updates sequentially
    const get_update_status_sts = await db.query(`UPDATE compose_sms SET ucp_status = 'S',report_status = "Y" WHERE compose_ucp_id = '${campaign_id}' AND user_id = '${user_id}' AND ucp_status = "V"`);

    const get_update_status_summary = await db.query(`UPDATE user_summary_report SET generate_status = "Y",report_status = "Y" WHERE com_msg_id = '${campaign_id}' AND user_id = '${user_id}'`);

    // Return the success response
    return { response_code: 1, response_status: 200, response_msg: 'Success.' };

} catch (error) {
    // Log the error and return an error response
    console.error('Error writing CSV file or updating database:', error);
    return { response_code: 0, response_status: 201, response_msg: 'Error Occurred.' };
}


}

async function generatereportsmpp(req, res) {
    const logger = main.logger

    const logger_all = main.logger_all;

    const { compose_user_id: user_id, compose_id: campaign_id } = req.body;

    const currentDate = new Date();

    // Format date and time without spaces

    logger_all.info('CSV file processing started.');
    // Use a stream to read the CSV file
    let data = [];
    const report_data = await db.query(`
        SELECT 
            usr.user_name,
            cmm.campaign_name AS campaign_name,
            cmp.mobile_no,
            CASE 
                WHEN cmp.comsmpp_status = 'F' THEN 'Failure'
                ELSE 'SUCCESS'
            END AS response_status,
            cmp.comsmpp_entry_date,
            cmp.comsmpp_sent_date
        FROM 
            compose_smpp cmm
            LEFT JOIN ${DB_NAME}_${user_id}.compose_smpp_status_${user_id} cmp ON cmm.compose_ucp_id = cmp.compose_smpp_id 
            LEFT JOIN user_management usr ON usr.user_id = cmm.user_id 
        WHERE 
            cmp.compose_smpp_id = '${campaign_id}' 
        ORDER BY 
            cmp.comsmpp_entry_date;
    `);
    const get_select_update_status = await db.query(`SELECT 
            COUNT(CASE WHEN comsmpp_status = 'Y' THEN 1 END) AS success_count,
            COUNT(CASE WHEN comsmpp_status = 'F' THEN 1 END) AS failure_count,
           
            COUNT(CASE WHEN comsmpp_status IS NULL THEN 1 END) AS null_count
        FROM ${DB_NAME}_${user_id}.compose_smpp_status_${user_id}
        WHERE compose_smpp_id = '${campaign_id}'`);

            let { null_count: nullCount, success_count, failure_count } = get_select_update_status[0];
            //rcsStatus = (nullCount !== 0) ? 'C' : rcsStatus;

            const get_update_status_summaryReport = await db.query(`UPDATE user_summary_report 
                SET total_process = '0', 
                total_waiting = '0',
                    total_success = '${success_count}', 
                    total_failed = '${failure_count}'
                WHERE com_msg_id = '${campaign_id}' 
                  AND user_id = '${user_id}'`);
    if (report_data.length == 0) {
        return { response_code: 0, response_status: 201, response_msg: 'No data available.' };
    }
    console.log(report_data[0])
    let campaign_name_file = report_data[0].campaign_name.replaceAll("\n", "");
    let download_csvFilePath = `${csvFilePath}${campaign_name_file}.csv`
    for (let i = 0; i < report_data.length; i++) {
        let single_data = report_data[i];
        logger_all.info(single_data);
        
        // Format the response date and time
        let formattedDateTime = moment(single_data.response_date).isValid() ? moment(single_data.response_date).format('YYYY-MM-DD HH:mm:ss') : "-";

        // Format the delivery date and time
        let formattedDelDateTime = moment(single_data.delivery_date).isValid() ? moment(single_data.delivery_date).format('YYYY-MM-DD HH:mm:ss') : "-";

        // Push formatted data into the array
        data.push({
            user_name: single_data.user_name,
            rcs_campaign: single_data.campaign_name,
            template_id: single_data.template_id,
            mobile_no: single_data.mobile_no,
            response_status: single_data.response_status || "-",  // Use fallback for undefined or null
            response_date: formattedDateTime,
            delivery_status: single_data.delivery_status || "-",  // Default to "-" if delivery_status is missing
            delivery_date: formattedDelDateTime
        });
    }

    // Log the entire data array after the loop
    console.log(data);


    // Define CSV file headers
    const csvWriter = createObjectCsvWriter({
        path: download_csvFilePath,  // File path to save the CSV
        header: [
            { id: 'user_name', title: 'User Name' },
            { id: 'rcs_campaign', title: 'Campaign Name' },
            { id: 'mobile_no', title: 'Mobile No' },
            { id: 'response_status', title: 'Response Status' },
            { id: 'response_date', title: 'Response Date' },
            { id: 'delivery_status', title: 'Delivery Status' },
            { id: 'delivery_date', title: 'Delivery Date' }
        ]
    });
try {
    await csvWriter.writeRecords(data);
    logger_all.info('CSV file written successfully - ' + download_csvFilePath);

    // Perform database updates sequentially
    const get_update_status_sts = await db.query(`UPDATE compose_smpp SET ucp_status = 'S',report_status = "Y" WHERE compose_ucp_id = '${campaign_id}' AND user_id = '${user_id}' AND ucp_status = "V"`);

    const get_update_status_summary = await db.query(`UPDATE user_summary_report SET generate_status = "Y",report_status = "Y" WHERE com_msg_id = '${campaign_id}' AND user_id = '${user_id}'`);

    // Return the success response
    return { response_code: 1, response_status: 200, response_msg: 'Success.' };

} catch (error) {
    // Log the error and return an error response
    console.error('Error writing CSV file or updating database:', error);
    return { response_code: 0, response_status: 201, response_msg: 'Error Occurred.' };
}
}

// Generate Report Whatsapp
async function generatereportwhatsapp(req, res) {
      const { logger_all, logger } = main;
    const { compose_user_id: user_id, compose_id: campaign_id } = req.body;
    // Format date and time without spaces

    logger_all.info('CSV file processing started.');
    // Use a stream to read the CSV file
    let data = [];

const report_data = await db.query(`SELECT usr.user_name,cmm.campaign_name AS campaign_name,cmp.mobile_no, CASE WHEN cmp.response_status = 'F' THEN 'Failure' WHEN cmp.response_status = NULL THEN 'Failure' ELSE 'SUCCESS' END AS response_status,cmp.comwtap_entry_date,cmp.response_date,cmp.delivery_date FROM compose_whatsapp cmm LEFT JOIN ${DB_NAME}_${user_id}.compose_whatsapp_status_tmpl_${user_id} cmp ON cmm.compose_ucp_id = cmp.compose_whatsapp_id LEFT JOIN user_management usr ON usr.user_id = cmm.user_id WHERE cmp.compose_whatsapp_id = '${campaign_id}' ORDER BY cmp.comwtap_entry_date;`);

const get_select_update_status = await db.query(`SELECT COUNT(CASE WHEN response_status = 'S' THEN 1 END) AS success_count,COUNT(CASE WHEN response_status = 'F' THEN 1 END) AS waiting_count,COUNT(CASE WHEN response_status IS NULL THEN 1 END) AS null_count FROM ${DB_NAME}_${user_id}.compose_whatsapp_status_tmpl_${user_id} WHERE compose_whatsapp_id = '${campaign_id}'`);

    let { null_count: nullCount, success_count, waiting_count } = get_select_update_status[0];
    //rcsStatus = (nullCount !== 0) ? 'C' : rcsStatus;

    const get_update_status_summaryReport = await db.query(`UPDATE user_summary_report SET total_process = '0', total_waiting = '0',total_success = '${success_count}', total_failed = '${waiting_count}' WHERE com_msg_id = '${campaign_id}' AND user_id = '${user_id}' and rights_id = '3'`);
    if (report_data.length == 0) {
        return { response_code: 0, response_status: 201, response_msg: 'No data available.' };
    }
    console.log(report_data[0])
    let campaign_name_file = report_data[0].campaign_name.replaceAll("\n", "");
    let download_csvFilePath = `${csvFilePath}${campaign_name_file}.csv`
    for (let i = 0; i < report_data.length; i++) {
        let single_data = report_data[i]; 
        // Format the response date and time
        let formattedDateTime = moment(single_data.response_date).isValid() ? moment(single_data.response_date).format('YYYY-MM-DD HH:mm:ss') : "-";

        // Format the delivery date and time
        let formattedDelDateTime = moment(single_data.delivery_date).isValid() ? moment(single_data.delivery_date).format('YYYY-MM-DD HH:mm:ss') : "-";

        // Push formatted data into the array
        data.push({
            user_name: single_data.user_name,
            rcs_campaign: single_data.campaign_name,
            template_id: single_data.template_id,
            mobile_no: single_data.mobile_no,
            response_status: single_data.response_status || "-",  // Use fallback for undefined or null
            response_date: formattedDateTime,
            delivery_status: single_data.delivery_status || "-",  // Default to "-" if delivery_status is missing
            delivery_date: formattedDelDateTime
        });
    }

    // Define CSV file headers
    const csvWriter = createObjectCsvWriter({
        path: download_csvFilePath,  // File path to save the CSV
        header: [
            { id: 'user_name', title: 'User Name' },
            { id: 'rcs_campaign', title: 'Campaign Name' },
            { id: 'mobile_no', title: 'Mobile No' },
            { id: 'response_status', title: 'Response Status' },
            { id: 'response_date', title: 'Response Date' },
            { id: 'delivery_status', title: 'Delivery Status' },
            { id: 'delivery_date', title: 'Delivery Date' }
        ]
    });
    try {
        await csvWriter.writeRecords(data);
        logger_all.info('CSV file written successfully - ' + download_csvFilePath);

        // Perform database updates sequentially
        await db.query(`UPDATE compose_whatsapp SET ucp_status = 'S',report_status = "Y" WHERE compose_ucp_id = '${campaign_id}' AND user_id = '${user_id}' AND ucp_status = "V"`);
        await db.query(`UPDATE user_summary_report SET generate_status = "Y",report_status = "Y" WHERE com_msg_id = '${campaign_id}' AND user_id = '${user_id}' and rights_id = "3"`);

        // Return the success response
        return { response_code: 1, response_status: 200, response_msg: 'Success.' };

    } catch (error) {
        // Log the error and return an error response
        console.error('Error writing CSV file or updating database:', error);
        return { response_code: 0, response_status: 201, response_msg: 'Error Occurred.' };
    }


}

// using for module exporting
module.exports = {
    generatereport,
    generatereportsmpp,
    generatereportwhatsapp,

}
