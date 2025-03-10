const db = require('../../db_connect/connect');


require("dotenv").config();
const main = require('../../logger');
const moment = require('moment');
const { count } = require("sms-length");
const { createObjectCsvWriter } = require('csv-writer');
const fs = require('fs');
const env = process.env;
const DB_NAME = env.DB_NAME;
const { logger_all, logger } = main;

async function ComposeWhatsapp(req, res) {
    try {
        var header_json = req.headers;
        let ip_address = header_json['x-forwarded-for'];
        logger.info(" [send_msg query parameters] : " + JSON.stringify(req.body));

        const { sender_numbers: senders, receiver_nos_path, components: whtsap_send, template_id, body_variable: variable_values, request_id, user_id, user_master_id, rights_name,group_id } = req.body;
        let total_mobile_count = req.body.total_mobile_count;
        // declare and initialize all the required variables and array
        var notready_numbers = [], sender_numbers = {}, error_array = [], whatsapp_config_ids;
        var sender_numbers_array = [];


        await db.query(`INSERT INTO api_log VALUES(NULL, 0, '${req.originalUrl}', '${ip_address}', '${request_id}', 'N', '-', '0000-00-00 00:00:00', 'Y', CURRENT_TIMESTAMP)`);
        const check_req_id_result = await db.query(`SELECT * FROM api_log WHERE request_id = '${request_id}' AND response_status != 'N' AND api_log_status='Y'`);

        if (check_req_id_result.length !== 0) {
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

        //  check Credit available or not
        const check_available_credits = await db.query(`SELECT lim.available_messages, usr.user_short_name, usr.parent_id, usr.user_name FROM user_management usr LEFT JOIN message_limit lim ON lim.user_id = usr.user_id WHERE usr.user_id = '${user_id}' AND usr.usr_mgt_status = 'Y'`);

        if (check_available_credits[0].available_messages < total_mobile_count && user_master_id != 1) {
            await db.query(`UPDATE api_log SET response_status = 'F',checkServerStatus response_date = CURRENT_TIMESTAMP,response_comments = 'Available credit not enough' WHERE request_id = '${request_id}' AND response_status = 'N'`);

            return ({ response_code: 0, response_status: 201, response_msg: 'Available credit not enough.', request_id });
        }

        const { user_short_name: fullShortName } = check_available_credits[0];
        // Get Rights Masters  
        const select_rights_id = await db.query(`SELECT * From rights_master where rights_name = '${rights_name}'`)
        let rights_id = select_rights_id[0].rights_id;

        // check if the template is available 
        const check_variable_count = await db.query(`SELECT * FROM message_template tmp LEFT JOIN master_language lan ON lan.language_id = tmp.language_id WHERE tmp.unique_template_id = '${template_id}' AND tmp.template_status = 'Y'`);

        // if template not available send error response to the client
        if (check_variable_count.length == 0) {

            await db.query(`UPDATE api_log SET response_status = 'F',response_date = CURRENT_TIMESTAMP, response_comments = 'Template not available' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);

            return res.json({ response_code: 0, response_status: 201, response_msg: 'template not available', request_id: req.body.request_id });
        }
        // if template available process will be continued
        else {

            // get the template name and language from template id
            tmpl_name = check_variable_count[0].template_name;
            tmpl_lang = check_variable_count[0].language_code;
            //var tmpl_message = JSON.parse(check_variable_count[0].template_message);
            try {
                // Parse and replace the newlines in the template message
                var replced_message = check_variable_count[0].template_message.replace(/(\r\n|\n|\r)/gm, " ");
                var tmpl_message = JSON.parse(replced_message);

                // Initialize the template media flags (image, video, document)
                var get_temp_details = [0, 0, 0, 0];  // [image, video, document]

                // Loop through the template JSON to check for media types
                tmpl_message.forEach(template => {
                    let type = template.type.toLowerCase();
                    let format = template.format.toLowerCase();

                    if (type === 'header') {
                        switch (format) {
                            case 'image':
                                get_temp_details[2] = 'i';
                                break;
                            case 'video':
                                get_temp_details[3] = 'v';
                                break;
                            case 'document':
                                get_temp_details[4] = 'd';
                                break;
                            default:
                                break;
                        }
                    }
                });

                // Check if any media type is required in the template
                if (get_temp_details[2] || get_temp_details[3] || get_temp_details[4]) {

                    // Flag to track if media is provided in the request
                    let media_flag = false;

                    // Function to validate media in the request
                    const validateMedia = async (mediaType, expectedType, mediaFlagMessage) => {
                        if (mediaType !== 0) {
                            if (!whtsap_send.some(item => item['type'].toLowerCase() === 'header' && item['parameters'][0]['type'].toLowerCase() === expectedType)) {
                                await db.query(`UPDATE api_log SET response_status = 'F', response_date = CURRENT_TIMESTAMP, response_comments = '${mediaFlagMessage}' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);
                                return res.json({ response_code: 0, response_status: 201, response_msg: mediaFlagMessage, request_id: req.body.request_id });
                            }
                            media_flag = true;
                        }
                    };

                    // Validate each type of media (image, video, document)
                    await validateMedia(get_temp_details[2], 'image', 'Image required for this template');
                    await validateMedia(get_temp_details[3], 'video', 'Video required for this template');
                    await validateMedia(get_temp_details[4], 'document', 'Document required for this template');

                }
            } catch (e) {
                logger_all.info("[media check error] : " + e);
            }

            // check how many variables the template have
            if (check_variable_count[0].body_variable_count != 0) {
                if (req.body.variable_values && body_variable.length != 0) {
                    if (check_variable_count[0].body_variable_count == body_variable[0].length && body_variable.length == total_mobile_count) {
                    }
                    else {
                        await db.query(`UPDATE api_log SET response_status = 'F',response_date = CURRENT_TIMESTAMP, response_comments = 'Variable value mismatch' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);

                        return res.json({ response_code: 0, response_status: 201, response_msg: 'Variable value mismatch.', request_id: req.body.request_id });
                    }
                }
                else {

                    await db.query(`UPDATE api_log SET response_status = 'F',response_date = CURRENT_TIMESTAMP, response_comments = 'Variable values required' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);

                    return res.json({ response_code: 0, response_status: 201, response_msg: 'Variable values required', request_id: req.body.request_id });
                }
            }


            var msg_limit_for_sender = 0;
            // loop all the sender number's to get available credit
            for (var s = 0; s < senders.length; s++) {

                const select_details = await db.query(`SELECT con.phone_number_id,con.whatspp_config_id,con.whatsapp_business_acc_id,con.bearer_token from whatsapp_config con WHERE concat(con.country_code, con.mobile_no) = '${senders[s]}' AND con.whatspp_config_status = 'Y'`);

                // check if the sender number have the template
                if (select_details.length != 0) {

                    const check_template = await db.query(`SELECT con.user_id,tmp.template_name,con.available_credit-con.sent_count available_credit FROM message_template tmp LEFT JOIN whatsapp_config con ON con.whatspp_config_id = tmp.whatsapp_config_id WHERE tmp.template_name = '${tmpl_name}' AND tmp.template_status = 'Y' AND concat(con.country_code, con.mobile_no) = '${senders[s]}'`);

                    // if template not available push the sender number in notready_numbers array.
                    if (check_template.length == 0) {
                        notready_numbers.push({ sender_number: senders[s], reason: 'Template not available for this number.' })
                    }
                    // otherwise process will be continued. Add the available sender_numbers in array
                    else {
                        whatsapp_config_ids = select_details.map(row => row.whatspp_config_id);
                        msg_limit_for_sender = msg_limit_for_sender + check_template[0].available_credit
                        sender_numbers_array.push(senders[s])
                        sender_numbers[senders[s]] = ({ user_id: check_template[0].user_id, count: check_template[0].available_credit, phone_number_id: select_details[0].phone_number_id, whatsapp_business_acc_id: select_details[0].whatsapp_business_acc_id, bearer_token: select_details[0].bearer_token })
                    }
                }
                // if sender_number not available push the sender number in notready_numbers array.
                else {
                    notready_numbers.push({ sender_number: senders[s], reason: 'Number not available.' })
                }

            }

            // if the sender_number json have no values then no sender number available. then send error response to the client.
            if (Object.keys(sender_numbers).length == 0) {
                await db.query(`UPDATE api_log SET response_status = 'F',response_date = CURRENT_TIMESTAMP, response_comments = 'No sender available' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);

                res.json({ response_code: 0, response_status: 201, response_msg: 'No sender available', data: notready_numbers, request_id: req.body.request_id });
            }
            else {

                // check the limits and messages count
                if (msg_limit_for_sender < total_mobile_count) {
                    await db.query(`UPDATE api_log SET response_status = 'F',response_date = CURRENT_TIMESTAMP, response_comments = 'Not sufficient credits' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);

                    return res.json({ response_code: 0, response_status: 201, response_msg: 'Not sufficient credits.', request_id: req.body.request_id });
                }

                // Helper function to calculate Julian Date
                Date.prototype.julianDate = function () {
                    const j = parseInt((this.getTime() - new Date(`Dec 30, ${this.getFullYear() - 1} 23:00:00`).getTime()) / 86400000).toString();
                    return j.padStart(3, '0');
                };
                // Get the latest compose_ucp_id and unique_compose_id in a single query
                const latest_compose = await db.query(`SELECT compose_ucp_id, unique_compose_id FROM compose_whatsapp ORDER BY compose_ucp_id DESC LIMIT 1`);
                // Generate compose_unique_name based on the latest compose_ucp_id
                const compose_ucp_id = latest_compose[0]?.compose_ucp_id || 0;
                const compose_unique_name = `ca_${fullShortName}_${new Date().julianDate()}_${compose_ucp_id + 1}`;


                // Generate the next unique_compose_id with proper zero padding
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

                console.log(compose_unique_name, unique_compose_id);
                const usedCampaignIds = new Set();
                function generateCampaignId() {
                    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                    let campaignId;

                    do {
                        campaignId = Array.from({ length: 10 }, () => characters.charAt(Math.floor(Math.random() * characters.length))).join('');
                    } while (usedCampaignIds.has(campaignId));

                    usedCampaignIds.add(campaignId);
                    return campaignId;
                }

                // Example usage:
                const campaign_id = generateCampaignId();
                const insert_msg = `INSERT INTO compose_whatsapp VALUES(NULL, ${user_id}, ${rights_id}, '${whatsapp_config_ids}', '${unique_compose_id}', '${total_mobile_count}', '${template_id}', 'W', CURRENT_TIMESTAMP, NULL, NULL, '${compose_unique_name}', '${campaign_id}', ${receiver_nos_path === undefined ? 'NULL' : `'${receiver_nos_path}'`}, NULL, 'N', NULL, '${JSON.stringify(whtsap_send)}', ${group_id === undefined ? 'NULL' : group_id})`;

                const insert_compose = await db.query(insert_msg);

                const last_compose_id = insert_compose.insertId;
                logger_all.info("Last insert ID: " + last_compose_id);

                if (user_master_id !== 1) {
                    await db.query(`UPDATE message_limit ml JOIN rights_master rm ON ml.rights_id = rm.rights_id SET ml.available_messages = ml.available_messages - ${total_mobile_count} WHERE ml.user_id = '${user_id}' AND rm.rights_id = ${rights_id}`);
                }

                logger.info("[API RESPONSE] " + JSON.stringify({
                    response_code: 1, response_status: 200, response_msg: 'Initiated', compose_id: compose_unique_name, request_id
                }));

                await db.query(`UPDATE api_log SET response_status = 'S',response_date = CURRENT_TIMESTAMP, response_comments = 'Success' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);

                return { response_code: 1, response_status: 200, response_msg: 'Initiated', compose_id: compose_unique_name, available_senders: sender_numbers_array, not_available_senders: notready_numbers, request_id: req.body.request_id };

            }
        }
    } catch (e) {
        logger_all.info("[Send msg failed response] : " + e);
        logger.info("[API RESPONSE] " + JSON.stringify({
            response_code: 0, response_status: 201, response_msg: 'Something went wrong', request_id: req.body.request_id
        }));
        return ({ response_code: 0, response_status: 201, response_msg: 'Something went wrong', request_id: req.body.request_id });
    }
}

module.exports = { ComposeWhatsapp };
