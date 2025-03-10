const path = require('path');

const db = require('../db_connect/connect');
const jwt = require("jsonwebtoken")
const main = require('../logger');

const VerifyUser = async (req, res, next) => {
    let logger_all = main.logger_all
    let logger = main.logger

    let header_json = req.headers;
    let request_id = req.body.request_id;
    try {
        // Check if ip address is present in req.body, if not use undefined
        const ip_address = header_json['x-forwarded-for'] ? `'${req.body.ip_address}'` : `'-'`;
        logger_all.info("request ID : " + request_id)
        logger.info("[API REQUEST] " + req.originalUrl + " - " + JSON.stringify(req.body) + " - " + JSON.stringify(req.headers) + " - " + ip_address)
      
        let user_id;
        const bearerHeader = req.headers['authorization'];
        let parameters = '';
        if (bearerHeader) {
            parameters += `,'${bearerHeader}'`;
        } else {
            parameters += `,null`;
        }

        if (req.body.user_id) {
            parameters += `,'${req.body.user_id}'`;
        } else {
            parameters += `,null`;
        }

        let update_api_log_result = await db.query(`CALL update_api_log('${req.originalUrl}',${ip_address},'${req.body.request_id}' ${parameters})`);


        user_id = update_api_log_result[0][0].response_user_id;
        if (update_api_log_result[0][0].Success) {
            try {
                let user_bearer_token = bearerHeader.split('Bearer ')[1];
                jwt.verify(user_bearer_token, process.env.ACCESS_TOKEN_SECRET);
                req['body']['user_id'] = user_id;
                next();
            } catch (e) {
                logger_all.info("[Validate user error] : " + e);
                let update_logout_result = await db.query(`UPDATE user_log SET user_log_status = 'O',logout_time = CURRENT_TIMESTAMP WHERE  user_id = '${user_id}'`);
               
                const update_api_log = await db.query(`UPDATE api_log SET response_status = 'F',response_date = CURRENT_TIMESTAMP, response_comments = 'Token expired' WHERE request_id = '${request_id}' AND response_status = 'N'`);

                let response_json_3 = { request_id: request_id, response_code: 0, response_status: 403, response_msg: 'Token expired' }
                logger_all.info("[API RESPONSE] " + JSON.stringify(response_json_3))

                return res
                    .status(403)
                    .send(response_json_3);
            }

        } else if (update_api_log_result[0][0].Status) {
            let response_json = { request_id: request_id, response_code: 0, response_status: 201, response_msg: update_api_log_result[0][0].response_msg }
            logger_all.info("[API RESPONSE] " + JSON.stringify(response_json))

            return res
                .status(201)
                .send(response_json);

        } else {
            let response_json = { request_id: request_id, response_code: 0, response_status: 403, response_msg: update_api_log_result[0][0].response_msg }
            logger_all.info("[API RESPONSE] " + JSON.stringify(response_json))

            return res
                .status(403)
                .send(response_json);
        }

    }

    catch (e) {
        logger_all.info("[Validate user error] : " + e);

        const update_api_log = await db.query(`UPDATE api_log SET response_status = 'F',response_date = CURRENT_TIMESTAMP, response_comments = 'Error occurred' WHERE request_id = '${request_id}' AND response_status = 'N'`);

        let response_json = { request_id: request_id, response_code: 0, response_status: 201, response_msg: 'Error occurred' }
        logger_all.info("[API RESPONSE] " + JSON.stringify(response_json))
        logger.info("[API RESPONSE] " + JSON.stringify(response_json))
        res.json(response_json);
    }
}
module.exports = VerifyUser;
