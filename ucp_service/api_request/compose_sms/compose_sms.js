const db = require('../../db_connect/connect');


require("dotenv").config();
const main = require('../../logger');
const moment = require('moment');
const { count } = require("sms-length");
const { createObjectCsvWriter } = require('csv-writer');
const fs = require('fs');
const env = process.env;
const DB_NAME = env.DB_NAME;

const logger = main.logger;
const logger_all = main.logger_all;

async function ComposeSMS(req, res) {
    try {
        const header_json = req.headers;
        const ip_address = header_json['x-forwarded-for'] || req.connection.remoteAddress;  // Handle missing header
        const api_bearer = req.headers.authorization;

        const { receiver_nos_path, message_type, request_id, user_master_id, character_count, messages, user_id, rights_name , group_id } = req.body;

        let total_mobile_count = req.body.total_mobile_count;

        let store_id, full_short_name;
        await db.query(`INSERT INTO api_log VALUES(NULL, 0, '${req.originalUrl}', '${ip_address}', '${request_id}', 'N', '-', '0000-00-00 00:00:00', 'Y', CURRENT_TIMESTAMP)`);

        const check_req_id_result = await db.query(`SELECT * FROM api_log WHERE request_id = '${request_id}' AND response_status != 'N' AND api_log_status='Y'`);

        if (check_req_id_result.length !== 0) {
            logger.info("[API RESPONSE] " + JSON.stringify({
                request_id, response_code: 0, response_status: 201, response_msg: 'Request already processed'
            }));
            await db.query(`UPDATE api_log SET response_status = 'F', response_date = CURRENT_TIMESTAMP,response_comments = 'Request already processed' WHERE request_id = '${request_id}' AND response_status = 'N'`);
            return ({ response_code: 0, response_status: 201, response_msg: 'Request already processed', request_id });
        }
        if(!total_mobile_count){
            const get_total_mobilenos = await db.query(`SELECT count(*) as total_mobilenos FROM contact_management where contact_mgtgrp_id = '${group_id}'`)
             total_mobile_count = get_total_mobilenos[0].total_mobilenos;
            }
    
            if(total_mobile_count == 0){
                logger.info("[API RESPONSE] " + JSON.stringify({
                    response_code: 0, response_status: 201, response_msg: 'No Numbers in this group'
                }))
            }

        //SMS Calculation
        var data = count(messages);
        logger_all.info(JSON.stringify(data) + "SMS Calculation");
        txt_sms_count = data.messages;
        logger_all.info(txt_sms_count + " SMS count based");

        msg_mobile_credits = total_mobile_count * txt_sms_count;
        const select_rights_id = await db.query(`SELECT * From rights_master where rights_name = '${rights_name}'`)
        let rights_id = select_rights_id[0].rights_id;

        const check_available_credits = await db.query(`SELECT usr.user_master_id, lim.available_messages, usr.user_id, usr.user_short_name, usr.parent_id, usr.user_name, lim.total_messages, lim.expiry_date, rm.rights_name, rm.rights_short_name, rm.rights_status FROM user_management usr LEFT JOIN message_limit lim ON lim.user_id = usr.user_id LEFT JOIN rights_master rm ON rm.rights_id = lim.rights_id WHERE usr.user_id = '${user_id}' AND usr.usr_mgt_status = 'Y'`);


        if (check_available_credits[0].available_messages < msg_mobile_credits && user_master_id != 1) {
            logger.info("[API RESPONSE] " + JSON.stringify({
                response_code: 0, response_status: 201, response_msg: 'Available credit not enough.', request_id
            }));

            await db.query(`UPDATE api_log SET response_status = 'F',checkServerStatus response_date = CURRENT_TIMESTAMP,response_comments = 'Available credit not enough' WHERE request_id = '${request_id}' AND response_status = 'N'`);

            return ({ response_code: 0, response_status: 201, response_msg: 'Available credit not enough.', request_id });
        }

        const { parent_id: user_master, user_short_name, user_name } = check_available_credits[0];

        const get_user_short_name = await db.query(`SELECT usr1.user_short_name FROM user_management usr LEFT JOIN user_management usr1 ON usr.parent_id = usr1.user_id WHERE usr.user_short_name = '${user_short_name}'`);

        full_short_name = (get_user_short_name.length === 0 || user_master == 1) ? user_short_name : `${get_user_short_name[0].user_short_name}_${user_short_name}`;

        store_id = req.body.store_id || 0;

        Date.prototype.julianDate = function () {
            const j = parseInt((this.getTime() - new Date(`Dec 30, ${this.getFullYear() - 1} 23:00:00`).getTime()) / 86400000).toString();
            return j.padStart(3, '0');
        };
        // Get the latest compose_ucp_id and unique_compose_id in a single query
        const latest_compose = await db.query(`SELECT compose_ucp_id, unique_compose_id FROM compose_sms ORDER BY compose_ucp_id DESC LIMIT 1`);
        const fullShortName = full_short_name; // Alias for readability
        // Generate compose_unique_name based on the latest compose_ucp_id
        const compose_ucp_id = latest_compose[0]?.compose_ucp_id || 0;
        const compose_unique_name = `ca_${fullShortName}_${new Date().julianDate()}_${compose_ucp_id + 1}`;
        let unique_id = '001'; // Default to '001' if no previous records

        if (latest_compose.length) { // Check if the query returned any records (i.e., it's not an empty array)
            const lastUniqueId = latest_compose[0].unique_compose_id; // Get the 'unique_compose_id' from the latest record
            const lastSerial = parseInt(lastUniqueId.slice(-3), 10) || 0; // Extract the last 3 characters (serial number) from the 'unique_compose_id'
            // Convert it to an integer. If it's not a number or missing, default to 0.
            unique_id = String(lastSerial + 1).padStart(3, '0'); // Increment the serial number by 1
            // Convert it back to a string and pad with leading zeros to ensure it's 3 digits
        }

        // Generate the final unique_compose_id
        const unique_compose_id = `cmps_${fullShortName}_${new Date().julianDate()}_${unique_id}`;
        const insert_msg = `INSERT INTO compose_sms VALUES(NULL, ${user_id},${rights_id},'${unique_compose_id}', ${total_mobile_count}, '${message_type}','${messages}', ${character_count}, 'W',CURRENT_TIMESTAMP, NULL, NULL, '${compose_unique_name}', ${receiver_nos_path === undefined ? 'NULL' : `'${receiver_nos_path}'`}, NULL, 'N', NULL, ${group_id === undefined ? 'NULL' : group_id})`;

        const insert_compose = await db.query(insert_msg);

        const last_compose_id = insert_compose.insertId;
        logger_all.info("Last insert ID: " + last_compose_id);

        if (user_master_id !== 1) {
            // await db.query(`UPDATE message_limit SET available_messages = available_messages - ${msg_mobile_credits} 
            //      WHERE user_id = '${user_id}'`);
            const update_query = `UPDATE message_limit ml JOIN rights_master rm ON ml.rights_id = rm.rights_id SET ml.available_messages = ml.available_messages - ${msg_mobile_credits} WHERE ml.user_id = '${user_id}' AND rm.rights_id = ${rights_id}`;

            await db.query(update_query);
        }

        await db.query(`INSERT INTO user_summary_report VALUES(NULL, '${user_id}', ${rights_id}, '${last_compose_id}', '${compose_unique_name}','${total_mobile_count}', '${total_mobile_count}', 0, 0, 0, 0, 0, 'N', 'N', CURRENT_TIMESTAMP, NULL, NULL)`);
        await db.query(`UPDATE api_log SET response_status = 'S', response_date = CURRENT_TIMESTAMP,  response_comments = 'Success' WHERE request_id = '${request_id}' AND response_status = 'N'`);

        logger.info("[API RESPONSE] " + JSON.stringify({ response_code: 1, response_status: 200, response_msg: 'Initiated', compose_id: compose_unique_name, request_id }));

        return ({ response_code: 1, response_status: 200, response_msg: 'Initiated', compose_id: compose_unique_name, request_id });
    } catch (e) {
        logger_all.info("[Send msg failed response] : " + e);
        logger.info("[API RESPONSE] " + JSON.stringify({
            response_code: 0, response_status: 201, response_msg: 'Something went wrong', request_id: req.body.request_id
        }));
        return ({ response_code: 0, response_status: 201, response_msg: 'Something went wrong', request_id: req.body.request_id });
    }
}

module.exports = { ComposeSMS };