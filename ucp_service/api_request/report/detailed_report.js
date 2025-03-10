
// Import the required packages and libraries
const db = require('../../db_connect/connect');
const main = require('../../logger');
const logger_all = main.logger_all
const logger = main.logger
// OtpDeliveryReport - start 
async function OtpDeliveryReport(req) {
    try {
        //  Get all the req header data
        let { user_id, user_master_id } = req.body
        let detail_report = "";
        // query parameters
        logger_all.info("[ManualUploadList query parameters] : " + JSON.stringify(req.body));
        if (user_master_id == 1) {
            // SQL query for user_master_id == 1
            detail_report = `SELECT c.campaign_name,c.message_content,c.unique_compose_id, c.compose_ucp_id,c.total_mobile_no_count, c.compose_entry_date, c.ucp_status,u.user_name,sr.total_success, sr.total_failed,sr.total_delivered FROM compose_sms AS c JOIN user_management AS u ON c.user_id = u.user_id JOIN user_summary_report AS sr ON c.compose_ucp_id = sr.com_msg_id WHERE c.ucp_status IN ('V', 'S', 'Y') AND sr.generate_status = 'Y' ORDER BY c.compose_entry_date DESC`;
        }
        else {
            // SQL query for user_master_id == 2
            detail_report = `SELECT c.campaign_name,c.message_content,c.unique_compose_id, c.compose_ucp_id,c.total_mobile_no_count, c.compose_entry_date, c.ucp_status,u.user_name,sr.total_success, sr.total_failed,sr.total_delivered FROM compose_sms AS c JOIN user_management AS u ON c.user_id = u.user_id JOIN user_summary_report AS sr ON c.compose_ucp_id = sr.com_msg_id WHERE c.ucp_status IN ('V', 'S', 'Y') AND (c.user_id = '${user_id}' OR u.parent_id = ${user_id}) AND sr.generate_status = 'Y' ORDER BY c.compose_entry_date DESC`
        }
        const get_report = await db.query(detail_report);

        if (get_report.length == 0) {
            return { response_code: 0, response_status: 201, response_msg: 'No Data available' };
        } else {
            return { response_code: 1, response_status: 200, response_msg: 'Success', num_of_rows: get_report.length, report: get_report };
        }
    }
    catch (e) { // any error occurres send error response to client
        logger_all.info("[OTP DELIVERY REPORT failed response] : " + e)
        return { response_code: 0, response_status: 201, response_msg: 'Error Occurred ' };
    }

}
// OtpDeliveryReport- end

// OtpDetailedReport - start 
async function OtpDetailedReport(req) {
    try {

        //  Get all the req header data
        const header_token = req.headers['authorization'];
        let { user_id, user_master_id } = req.body
        let detail_report = "";
        let array_userid = [];
        // query parameters
        logger_all.info("[OtpDetailedReport query parameters] : " + JSON.stringify(req.body));
        // To get the User_id
        let get_user = `SELECT * FROM user_management where user_bearer_token = '${header_token}' AND usr_mgt_status = 'Y'`
        if (user_id) {
            get_user = get_user + `and user_id = '${user_id}' `;
        }
        const get_user_id = await db.query(get_user);

        if (get_user_id.length == 0) { // If get_user not available send error response to client in ivalid token
            logger_all.info("Invalid Token")
            return { response_code: 0, response_status: 201, response_msg: 'Invalid Token' };
        }

        logger_all.info("[USER ID ] : " + user_id);
        if (user_master_id == 1) {
            const userIds = await db.query("SELECT user_id FROM user_management");
            const array_userid = userIds.map(user => user.user_id);
            let array_list_userid_string = array_userid.join("','");

            // SQL query for user_master_id == 1
            detail_report = `
                SELECT DISTINCT
                    c.campaign_name, 
                    c.message_content, 
                    c.unique_compose_id, 
                    c.compose_ucp_id, 
                    c.total_mobile_no_count, 
                    c.compose_entry_date, 
                    c.ucp_status,  
                    u.user_name, 
                    sr.total_success, 
                    sr.total_failed, 
                    sr.total_delivered 
                FROM compose_smpp AS c
                JOIN user_management AS u ON c.user_id = u.user_id
                JOIN user_summary_report AS sr ON c.compose_ucp_id = sr.com_msg_id
                WHERE c.ucp_status IN ('V', 'S', 'Y') 
                  AND c.user_id IN ('${array_list_userid_string}')
                  AND sr.generate_status = 'Y'
            `;
        }
        else {
            console.log("elseif");

            // SQL query for user_master_id == 2
            detail_report = `
                SELECT DISTINCT
                    c.campaign_name, 
                    c.message_content, 
                    c.unique_compose_id, 
                    c.compose_ucp_id, 
                    c.total_mobile_no_count, 
                    c.compose_entry_date, 
                    c.ucp_status,  
                    u.user_name, 
                    sr.total_success, 
                    sr.total_failed, 
                    sr.total_delivered 
                FROM compose_smpp AS c
                JOIN user_management AS u ON c.user_id = u.user_id
                JOIN user_summary_report AS sr ON c.compose_ucp_id = sr.com_msg_id
                WHERE c.ucp_status IN ('V', 'S', 'Y') 
                  AND (c.user_id = '${user_id}' OR u.parent_id = ${user_id})
                  AND sr.generate_status = 'Y'
            `;
        }


        const get_report = await db.query(detail_report + ` ORDER BY c.compose_entry_date DESC`);

        if (get_report.length == 0) {
            return { response_code: 0, response_status: 201, response_msg: 'No Data available' };
        } else {
            return { response_code: 1, response_status: 200, response_msg: 'Success', num_of_rows: get_report.length, report: get_report };
        }
    }
    catch (e) { // any error occurres send error response to client
        logger_all.info("[ OtpDetailedReport failed response] : " + e)
        return { response_code: 0, response_status: 201, response_msg: 'Error Occurred ' };
    }

}
// OtpDeliveryReport- end

// DetailedReportWhatsapp - start 
async function DetailedReportWhatsapp(req) {
    try {

        let { user_id, user_master_id } = req.body
        let detail_report = "";
        // query parameters
        logger_all.info("[DetailedReportWhatsapp query parameters] : " + JSON.stringify(req.body));

        if (user_master_id == 1) {
            detail_report = `
                SELECT DISTINCT c.campaign_name,c.unique_compose_id, c.compose_ucp_id, c.total_mobile_no_count, c.compose_entry_date, c.ucp_status, u.user_name, sr.total_success, sr.total_failed, sr.total_delivered FROM compose_whatsapp AS c JOIN user_management AS u ON c.user_id = u.user_id JOIN user_summary_report AS sr ON c.compose_ucp_id = sr.com_msg_id WHERE c.ucp_status IN ('V', 'S', 'Y') AND sr.generate_status = 'Y'`;
        }
        else {

            // SQL query for user_master_id == 2
            detail_report = `SELECT DISTINCT c.campaign_name, c.unique_compose_id, c.compose_ucp_id, c.total_mobile_no_count, c.compose_entry_date, c.ucp_status, u.user_name, sr.total_success, sr.total_failed, sr.total_delivered FROM compose_whatsapp AS c JOIN user_management AS u ON c.user_id = u.user_id JOIN user_summary_report AS sr ON c.compose_ucp_id = sr.com_msg_id WHERE c.ucp_status IN ('V', 'S', 'Y') AND (c.user_id = '${user_id}' OR u.parent_id = ${user_id}) AND sr.generate_status = 'Y'`;
        }


        const get_report = await db.query(detail_report + ` ORDER BY c.compose_entry_date DESC`);

        if (get_report.length == 0) {
            return { response_code: 0, response_status: 201, response_msg: 'No Data available' };
        } else {
            return { response_code: 1, response_status: 200, response_msg: 'Success', num_of_rows: get_report.length, report: get_report };
        }
    }
    catch (e) { // any error occurres send error response to client
        logger_all.info("[ DetailedReportWhatsapp failed response] : " + e)
        return { response_code: 0, response_status: 201, response_msg: 'Error Occurred ' };
    }

}
// DetailedReportWhatsapp- end

// using for module exporting
module.exports = {
    OtpDeliveryReport,
    OtpDetailedReport,
    DetailedReportWhatsapp
};
