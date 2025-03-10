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
const { use } = require("./route");
const nodemailer = require('nodemailer');

// Save_Sender_id - start
async function Save_Sender_id(req, res) {
    var logger_all = main.logger_all;
    var logger = main.logger;
    try {
        const header_json = req.headers;
        const ip_address = header_json['x-forwarded-for'] || req.connection.remoteAddress;
        const day = new Date();
        const today_date = day.getFullYear() + '-' + (day.getMonth() + 1).toString().padStart(2, '0') + '-' + day.getDate().toString().padStart(2, '0');
        const today_time = day.getHours().toString().padStart(2, '0') + ":" + day.getMinutes().toString().padStart(2, '0') + ":" + day.getSeconds().toString().padStart(2, '0');
        const current_date = today_date + ' ' + today_time;

        logger.info(`[API REQUEST - Save_Sender_id] ${req.originalUrl} - ${JSON.stringify(req.body)} - ${JSON.stringify(req.headers)}`);

        // Extract required data from the request body
        const { user_id, slt_operator, dlt_process, slt_template_type, request_id, slt_business_category, header_sender_id, txt_explanation, ex_new_senderid, filename, filename1 , txt_constempname, txt_consbrndname, txt_consmsg} = req.body;
        
        let last_insetid;
        logger_all.info("[Save Sender Id Parameter] : " + JSON.stringify(req.body));
        
        await db.query(
            `INSERT INTO api_log VALUES(NULL, 0, '${req.originalUrl}', '${ip_address}', '${request_id}', 'N', '-', '0000-00-00 00:00:00', 'Y', CURRENT_TIMESTAMP)`
        );

        const check_req_id_result = await db.query(
            `SELECT * FROM api_log WHERE request_id = '${request_id}' AND response_status != 'N' AND api_log_status='Y'`
        );

        if (check_req_id_result.length !== 0) {
            logger_all.info("[API RESPONSE] " + JSON.stringify({
                request_id, response_code: 0, response_status: 201, response_msg: 'Request already processed'
            }));

            await db.query(
                `UPDATE api_log SET response_status = 'F', response_date = CURRENT_TIMESTAMP, 
                 response_comments = 'Request already processed' WHERE request_id = '${request_id}' AND response_status = 'N'`
            );

            return { response_code: 0, response_status: 201, response_msg: 'Request already processed', request_id };
        }

        const select_header_sender_id = await db.query(`SELECT * FROM cm_senderid WHERE sender_title = '${header_sender_id}'`);
        if (select_header_sender_id.length !== 0) {
            logger_all.info("[API RESPONSE] " + JSON.stringify({
                request_id, response_code: 0, response_status: 201, response_msg: 'This Title already used. Kindly try with some others!!!'
            }));

            return { response_code: 0, response_status: 201, response_msg: 'This Title already used. Kindly try with some others!!!', request_id };
        } 

        const insert_cm_senderid = await db.query(`INSERT INTO cm_senderid VALUES( NULL, ${user_id}, '${slt_operator}', '${slt_template_type}', '${slt_business_category}', '${header_sender_id}', '${txt_explanation}', '${filename}', 'W', '${current_date}', NULL, NULL, NULL, NULL, '${ex_new_senderid}', ${dlt_process}, NULL )`);
        last_insetid = insert_cm_senderid.insertId;

        await db.query(`INSERT INTO cm_consent_template VALUES (NULL, ${last_insetid}, ${user_id}, '${txt_constempname}', '${txt_consbrndname}', '${txt_consmsg}', '${filename1}', 'W', '${current_date}', NULL, NULL, NULL)`);

        const get_user_email = await db.query(`SELECT * FROM user_management WHERE user_id = ${user_id}`);
        let user_emailid = get_user_email[0].user_email;
        let user_name = get_user_email[0].user_name;

        const select_business_category = await db.query(`SELECT * FROM sender_business_category WHERE business_category_status = 'Y' AND sender_buscategory_id = '${slt_business_category}' ORDER BY sender_buscategory_id ASC`);

        let business_category = select_business_category[0].business_category;

        // const transporter = nodemailer.createTransport({
        //     service: 'gmail',
        //     auth: {
        //         user: 'shanthini.m@yeejai.com', // Your email address
        //         pass: 'wsxnkyzsrkadpioy' // Your email password or app-specific password
        //     }
        // });

        // const mailOptions = {
        //     from: 'shanthini.m@yeejai.com', // Sender's email address
        //     to: 'selvalakshmi29102002@gmail.com', // Recipient's email address
        //     subject: `New Sender ID Creation - '${header_sender_id}'  Reg.`,
        //     html: `<table>
        //             <tr><td colspan="2">Dear Admin,<br><br></td></tr>
        //             <tr><td>Created User:</td><td>${user_name}</td></tr>
        //             <tr><td>Header Type:</td><td>${slt_template_type}</td></tr>
        //             <tr><td>Business Category:</td><td>${business_category}</td></tr>
        //             <tr><td>New Sender ID:</td><td>${header_sender_id}</td></tr>
        //             <tr><td>Explanation:</td><td>${txt_explanation}</td></tr>
        //             </table>`
        // };

        // return new Promise((resolve, reject) => {
        //     transporter.sendMail(mailOptions, async (error, info) => {
        //         if (error) {
        //             logger_all.info('Error occurred: Mail cannot be sent. Kindly check!!', error);
        //             return resolve({ response_code: 0, response_status: 201, response_msg: 'Mail cannot be sent. Kindly check!!' });
        //         } else {
        //             logger_all.info('Email sent: New password sent to your email. Kindly verify!!', info.response);
        //             return resolve({ response_code: 1, response_status: 200, response_msg: 'Success!!! New  senter id send  to your email. Kindly verify!!', request_id: req.body.request_id });
        //         }
        //     });
        // });

        return { response_code: 1, response_status: 200, response_msg: 'Success' };

    } catch (e) {
        logger_all.info("[Save_Sender_id failed response] : " + e);
        return { response_code: 0, response_status: 201, response_msg: 'Error occurred' };
    }
}
// Save_Sender_id - end

// savetemplateid - start
async function savetemplateid(req, res) {
    var logger_all = main.logger_all;
    var logger = main.logger;
    try {
        const header_json = req.headers;
        const ip_address = header_json['x-forwarded-for'] || req.connection.remoteAddress;
        const day = new Date();
        const today_date = day.getFullYear() + '-' + (day.getMonth() + 1).toString().padStart(2, '0') + '-' + day.getDate().toString().padStart(2, '0');
        const today_time = day.getHours().toString().padStart(2, '0') + ":" + day.getMinutes().toString().padStart(2, '0') + ":" + day.getSeconds().toString().padStart(2, '0');
        const current_date = today_date + ' ' + today_time;

        logger.info(`[API REQUEST - savetemplateid] ${req.originalUrl} - ${JSON.stringify(req.body)} - ${JSON.stringify(req.headers)}`);

        // Extract required data from the request body
        const { user_id, request_id, t_cm_sender_id, t_cm_consent_id, cn_msgtype, cn_template_name, cn_message, exist_new_template} = req.body;
        cn_template_name
        let last_insetid;
        logger_all.info("[savetemplateid Parameter] : " + JSON.stringify(req.body));
        
        await db.query(
            `INSERT INTO api_log VALUES(NULL, 0, '${req.originalUrl}', '${ip_address}', '${request_id}', 'N', '-', '0000-00-00 00:00:00', 'Y', CURRENT_TIMESTAMP)`
        );

        const check_req_id_result = await db.query(
            `SELECT * FROM api_log WHERE request_id = '${request_id}' AND response_status != 'N' AND api_log_status='Y'`
        );

        if (check_req_id_result.length !== 0) {
            logger_all.info("[API RESPONSE] " + JSON.stringify({
                request_id, response_code: 0, response_status: 201, response_msg: 'Request already processed'
            }));

            await db.query(
                `UPDATE api_log SET response_status = 'F', response_date = CURRENT_TIMESTAMP, 
                 response_comments = 'Request already processed' WHERE request_id = '${request_id}' AND response_status = 'N'`
            );

            return { response_code: 0, response_status: 201, response_msg: 'Request already processed', request_id };
        }

        const select_header_sender_id = await db.query(`SELECT * FROM cm_content_template where cn_template_name = '${cn_template_name}'`);
        if (select_header_sender_id.length !== 0) {
            logger_all.info("[API RESPONSE] " + JSON.stringify({
                request_id, response_code: 0, response_status: 201, response_msg: 'This Title already used. Kindly try with some others!!!'
            }));

            return { response_code: 0, response_status: 201, response_msg: 'This Title already used. Kindly try with some others!!!', request_id };
        }
        const get_business_id = await db.query(`SELECT * FROM cm_senderid WHERE cm_sender_id = '${t_cm_sender_id}'`);
       let cn_template_buscategory = get_business_id[0].sender_buscategory;
        let sender_temptype = get_business_id[0].sender_temptype;

        const insert_cm_senderid = await db.query(`INSERT INTO cm_content_template VALUES( NULL, ${user_id},'${sender_temptype}' , '${cn_template_buscategory}', '${t_cm_sender_id}', '${t_cm_consent_id}', '${cn_template_name}', '${cn_msgtype}', '${cn_message}', 'W', '${current_date}', NULL, NULL, NULL, NULL, '${exist_new_template}')`);
        last_insetid = insert_cm_senderid.insertId; 

        // await db.query(`INSERT INTO cm_consent_template VALUES (NULL, ${last_insetid}, ${user_id}, '${txt_constempname}', '${txt_consbrndname}', '${txt_consmsg}', '${filename1}', 'W', '${current_date}', NULL, NULL, NULL)`);


        const get_user_email = await db.query(`SELECT * FROM cm_consent_template tmp LEFT JOIN user_management usr on tmp.user_id = usr.user_id LEFT JOIN cm_senderid snd on snd.cm_sender_id = tmp.cm_sender_id where tmp.user_id = '${user_id}' and tmp.cm_consent_id = '${t_cm_consent_id}' and snd.cm_sender_id = '${t_cm_sender_id}' Order by tmp.cm_consent_id desc`);
        //let user_emailid = get_user_email[0].user_email;
        //let user_name = get_user_email[0].user_name;

         const select_business_category = await db.query(`SELECT * FROM sender_business_category where business_category_status = 'Y' and sender_buscategory_id = '${cn_template_buscategory}' ORDER BY sender_buscategory_id Asc`);

        let business_category = select_business_category[0].business_category;

        // const transporter = nodemailer.createTransport({
        //     service: 'gmail',
        //     auth: {
        //         user: 'shanthini.m@yeejai.com', // Your email address
        //         pass: 'wsxnkyzsrkadpioy' // Your email password or app-specific password
        //     }
        // });

        // const mailOptions = {
        //     from: 'shanthini.m@yeejai.com', // Sender's email address
        //     to: 'selvalakshmi29102002@gmail.com', // Recipient's email address
        //     subject: `New Sender ID Creation - '${header_sender_id}'  Reg.`,
        //     html: `<table>
        //             <tr><td colspan="2">Dear Admin,<br><br></td></tr>
        //             <tr><td>Created User:</td><td>${user_name}</td></tr>
        //             <tr><td>Header Type:</td><td>${slt_template_type}</td></tr>
        //             <tr><td>Business Category:</td><td>${business_category}</td></tr>
        //             <tr><td>New Sender ID:</td><td>${header_sender_id}</td></tr>
        //             <tr><td>Explanation:</td><td>${txt_explanation}</td></tr>
        //             </table>`
        // };

        // return new Promise((resolve, reject) => {
        //     transporter.sendMail(mailOptions, async (error, info) => {
        //         if (error) {
        //             logger_all.info('Error occurred: Mail cannot be sent. Kindly check!!', error);
        //             return resolve({ response_code: 0, response_status: 201, response_msg: 'Mail cannot be sent. Kindly check!!' });
        //         } else {
        //             logger_all.info('Email sent: New password sent to your email. Kindly verify!!', info.response);
        //             return resolve({ response_code: 1, response_status: 200, response_msg: 'Success!!! New  senter id send  to your email. Kindly verify!!', request_id: req.body.request_id });
        //         }
        //     });
        // });

        return { response_code: 1, response_status: 200, response_msg: 'Success' };

    } catch (e) {
        logger_all.info("[savetemplateid failed response] : " + e);
        return { response_code: 0, response_status: 201, response_msg: 'Error occurred' };
    }
}
// savetemplateid - end

// using for module exporting
module.exports = {
    Save_Sender_id,
    savetemplateid
}