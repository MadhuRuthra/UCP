// Import the required packages and libraries
const main = require('../../logger');
const db = require("../../db_connect/connect");
const axios = require('axios');
const dotenv = require('dotenv');
const logger_all = main.logger_all;
const env = process.env;
const DB_NAME = env.DB_NAME;
const apiAdminUser = process.apiAdminUser;
const apiAdminPswd = env.apiAdminPswd;
dotenv.config();

// Define the function containing the logic you want to run periodically
async function cron_send_msg() {
    try {
        // Retrieve composed SMS with pending status
        const get_compose_query = `SELECT * FROM compose_sms WHERE ucp_status = 'P'`;
        logger_all.info("[select query request] : " + get_compose_query);

        const get_compose_result = await db.query(get_compose_query);
        logger_all.info("[select query get_compose_result response] : " + JSON.stringify(get_compose_result));

        if (get_compose_result.length === 0) {
            logger_all.info("No pending SMS found.");
            return; // Exit if there are no pending messages
        }

        const user_ids = get_compose_result.map(item => item.user_id);
        const compose_ucp_ids = get_compose_result.map(item => item.compose_ucp_id);
        const total_mobile_no_counts = get_compose_result.map(item => item.total_mobile_no_count);
        for (const user_id of user_ids) {
            const get_boardurl_query = `SELECT board_url FROM sms_board_settings `;

            const boardurl_result = await db.query(get_boardurl_query, [user_id]);
            const apiKeyUrl = boardurl_result.length > 0 ? boardurl_result[0].board_url : null;


            // Get valid mobile numbers with specific status
            const get_status_result = await db.query(`SELECT * FROM ${DB_NAME}_${user_id}.compose_ucp_status_${user_id} WHERE mobileno_valid = 'V' AND comsms_status = 'Q' AND comsms_entry_date >= (NOW() - INTERVAL 90 MINUTE) AND comsms_entry_date <= (NOW() - INTERVAL 30 MINUTE)`);

            if (get_status_result.length === 0) continue; // Skip if no valid numbers

            const sendData = {
                user: apiAdminUser,
                password: apiAdminPswd
            };

            try {
                const response = await axios.post(apiKeyUrl, sendData, {
                    headers: {
                        'Content-Type': 'application/json; charset=utf-8'
                    }
                });

                const taskResults = response.data.taskResults;
                logger_all.info("response taskResults: " + JSON.stringify(taskResults));

                for (const task of taskResults) {
                    const comsmsStatusId = task.tid;
                    const rows = await db.query(`
                        SELECT csms.compose_ucp_id, cstt.comsms_status_id, cstt.mobile_no 
                        FROM compose_sms csms 
                        JOIN ${DB_NAME}_${user_id}.compose_ucp_status_${user_id} cstt 
                        ON csms.compose_ucp_id = cstt.compose_ucp_id 
                        WHERE csms.ucp_status = 'N' AND cstt.mobileno_valid = 'V' 
                        AND cstt.comsms_status IN ('N', 'F', 'Q') 
                        AND cstt.comsms_status_id = ?
                    `, [comsmsStatusId]);

                    if (rows.length > 0) {
                        for (const row of rows) {
                            const campaignId = row.compose_ucp_id;
                            const mobileNo = row.mobile_no;
                            const responseObjResult = task.result;

                            logger_all.info(`API Schedule SMS Update: campaign => ${campaignId}, Mobile No => ${mobileNo}, response => '${responseObjResult}' on ${new Date()}`);

                            if (responseObjResult === 'fail' || responseObjResult === 'failed') {
                                await updateSmsStatus(user_id, campaignId, comsmsStatusId, 'F', mobileNo);
                            } else if (responseObjResult === 'success' || responseObjResult === 'ok') {
                                await updateSmsStatus(user_id, campaignId, comsmsStatusId, 'S', mobileNo);
                            }
                        }
                    }
                }

                // Update compose SMS status
                for (const [index, compose_ucp_id] of compose_ucp_ids.entries()) {
                    const get_counts = await db.query(`
                        SELECT * FROM ${DB_NAME}_${user_ids[index]}.compose_ucp_status_${user_ids[index]}  
                        WHERE mobileno_valid = 'V' AND comsms_status NOT IN ('N', 'Q') 
                        AND compose_sms_id = ?
                    `, [compose_ucp_id]);

                    if (get_counts.length === total_mobile_no_counts[index]) {
                        await db.query(`
                            UPDATE compose_sms 
                            SET ucp_end_date = CURRENT_TIMESTAMP, ucp_status = 'V' 
                            WHERE compose_ucp_id = ? AND user_id = ?
                        `, [compose_ucp_id, user_ids[index]]);
                    }
                }

            } catch (error) {
                logger_all.error('Error sending data to API:', error);
            }
        }

    } catch (error) {
        logger_all.error("Error in cron task:", error);
    }
}

// Helper function to update SMS status
async function updateSmsStatus(user_id, campaignId, comsmsStatusId, status, mobileNo) {
    const comment = status === 'F' ? 'Failed' : 'Success';
    await db.query(`
        UPDATE ${DB_NAME}_${user_id}.compose_ucp_status_${user_id}
        SET comsms_status = ?, comsms_sent_date = NOW(), sms_comments = ? , delivery_date = 'CURRENT_TIMESTAMP'
        WHERE comsms_status_id = ? AND comsms_status != 'S'
    `, [status, comment, comsmsStatusId]);

    const summaryUpdate = status === 'F'
        ? `total_failed = total_failed + 1`
        : `total_success = total_success + 1`;

    await db.query(`
        UPDATE user_summary_report 
        SET total_process = total_process - 1, ${summaryUpdate} 
        WHERE com_msg_id = ? AND user_id = ? AND report_status = "N"
    `, [campaignId, user_id]);

    if (user_master_id !== 1) {
        await db.query(`
            UPDATE message_limit 
            SET available_messages = available_messages + 1 
            WHERE user_id IN (
                SELECT DISTINCT user_id FROM compose_sms csms 
                JOIN ${DB_NAME}_${user_id}.compose_ucp_status_${user_id} cstt 
                ON csms.compose_ucp_id = cstt.compose_ucp_id 
                WHERE cstt.comsms_status_id = ?
            )
        `, [comsmsStatusId]);
    }

    logger_all.info(`${status === 'F' ? 'Failed' : 'Success'} SMS Status Updated for campaign => ${campaignId} : Mobile No => ${mobileNo}`);
}

module.exports = cron_send_msg;