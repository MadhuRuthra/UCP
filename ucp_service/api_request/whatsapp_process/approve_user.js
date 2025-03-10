/*
This api has chat API functions which is used to connect the mobile chat.
This page is act as a Backend page which is connect with Node JS API and PHP Frontend.
It will collect the form details and send it to API.
After get the response from API, send it back to Frontend.

Version : 1.0
Author : 
 (YJ0009)
Date : 05-Jul-2023
*/
// Import the required packages and libraries
const db = require("../../db_connect/connect");
const dotenv = require('dotenv');
dotenv.config();
require('dotenv').config()
const env = process.env
const main = require('../../logger');
const { use } = require("./route");
const nodemailer = require('nodemailer');
const api_url = env.API_URL;
const media_bearer = env.MEDIA_BEARER;
const axios = require('axios');
// ApproveSenderId - start
async function ApproveSenderId(req, res) {
    var logger_all = main.logger_all;
    var logger = main.logger;
    try {

        var header_json = req.headers;
        let ip_address = header_json['x-forwarded-for'];
        // get the data from req.body to update in DB
        let mobile_number = req.body.mobile_number;
        let phone_number_id = req.body.phone_number_id;
        let whatsapp_business_acc_id = req.body.whatsapp_business_acc_id;
        let bearer_token = req.body.bearer_token;

        // succ_template for store all the success template in automatic template creation and failed_template for store all the failed template in automatic template creation
        var succ_template = [];
        var failed_template = [];

        logger.info("[user approve query parameters] : " + JSON.stringify(req.body));

        const insert_api_log_result = await db.query(
            `INSERT INTO api_log VALUES(NULL, 0, '${req.originalUrl}', '${ip_address}', '${req.body.request_id}', 'N', '-', '0000-00-00 00:00:00', 'Y', CURRENT_TIMESTAMP)`
        );


        const check_req_id_result = await db.query(`SELECT * FROM api_log WHERE request_id = '${req.body.request_id}' AND response_status != 'N' AND api_log_status='Y'`);

        if (check_req_id_result.length != 0) {

            logger_all.info("[failed response] : Request already processed");
            logger.info("[API RESPONSE] " + JSON.stringify({ request_id: req.body.request_id, response_code: 0, response_status: 201, response_msg: 'Request already processed', request_id: req.body.request_id }))

            const log_update_result = await db.query(`UPDATE api_log SET response_status = 'F',response_date = CURRENT_TIMESTAMP, response_comments = 'Request already processed' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);

            return ({ response_code: 0, response_status: 201, response_msg: 'Request already processed', request_id: req.body.request_id });

        }

        // To check the given mobile number is available or not
        const check_user = await db.query(`SELECT * from whatsapp_config WHERE concat(country_code, mobile_no) = '${mobile_number}' AND is_qr_code='N'`);

        // if user not available send error response to client
        if (check_user.length == 0) {
            logger_all.info("[user not available] : " + mobile_number)
            logger.info("[API RESPONSE] " + JSON.stringify({ response_code: 0, response_status: 201, response_msg: 'Invalid user.', request_id: req.body.request_id }))

            const log_update_result = await db.query(`UPDATE api_log SET response_status = 'F',response_date = CURRENT_TIMESTAMP, response_comments = 'Invalid user' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);

            return ({ response_code: 0, response_status: 201, response_msg: 'Invalid user.', request_id: req.body.request_id });
        }
        else {

            // if user is available then process the will be continued
            // check the whatsapp_config_status is Y. If Yes send error response to the client. If not process will be continued.	

            if (check_user[0].whatspp_config_status == 'Y') {

                logger_all.info("[user already available] : " + mobile_number)
                logger.info("[API RESPONSE] " + JSON.stringify({ response_code: 0, response_status: 201, response_msg: 'User already exists.', request_id: req.body.request_id }))

                const log_update_result = await db.query(`UPDATE api_log SET response_status = 'F',response_date = CURRENT_TIMESTAMP, response_comments = 'User already exists' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);

                return ({ response_code: 0, response_status: 201, response_msg: 'User already exists.', request_id: req.body.request_id });
            }

            else {
                // update the phone number id, whatsapp_business_acc_id, bearer token for the given mobile number
                const update_user = await db.query(`UPDATE whatsapp_config SET phone_number_id = '${phone_number_id}',whatsapp_business_acc_id = '${whatsapp_business_acc_id}',bearer_token = '${bearer_token}',whatspp_config_status = 'Y',whatspp_config_apprdate = CURRENT_TIMESTAMP,available_credit=200 WHERE concat(country_code, mobile_no) = '${mobile_number}' AND whatspp_config_status = 'N'`);

                // check if the user have a any user. Based on the user we will get all approved templates
                const select_id = await db.query(`SELECT * from whatsapp_config WHERE user_id = '${check_user[0].user_id}' AND whatspp_config_status = 'Y' ORDER BY whatspp_config_id ASC`);

                // if user doesn't have any user, means this is the first user then no need to request templates.
                if (select_id.length > 1) {

                    // api url to get the all template for the existing user
                    api_url_updated = `${api_url}${select_id[0].whatsapp_business_acc_id}/message_templates`

                    var get_temp = {
                        method: 'get',
                        url: api_url_updated,
                        headers: {
                            'Authorization': 'Bearer ' + select_id[0].bearer_token,
                        }
                    };

                    logger_all.info("[template get request] : " + JSON.stringify(get_temp))
                    // process api request
                    await axios(get_temp)
                        .then(async function (response) {

                            logger_all.info("[template response] : " + JSON.stringify(response.data))

                            // api url to the given user to request template
                            var api_url_user = `${api_url}${whatsapp_business_acc_id}/message_templates`

                            // if no template available then send success repsonse to client.
                            if (response.data.data.length == 0) {
                                logger_all.info("[ No template available] : " + mobile_number)
                                logger.info("[API RESPONSE] " + JSON.stringify({
                                    response_code: 1, response_status: 200, response_msg: 'No templates available.', request_id: req.body.request_id
                                }))

                                const log_update_result = await db.query(`UPDATE api_log SET response_status = 'F',response_date = CURRENT_TIMESTAMP, response_comments = 'No templates available' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);

                                return ({ response_code: 1, response_status: 200, response_msg: 'No templates available.', request_id: req.body.request_id });
                            }

                            // loop all the approved template to send same template request for the given sender id
                            for (var i = 0; i < response.data.data.length; i++) {

                                // check if the template approved otherwise we are not going to send request for this template
                                if (response.data.data[i].status = 'APPROVED') {
                                    // flag to check if the template has media
                                    var isMedia = false;
                                    var mediaPlace;
                                    var variable_status = 0;

                                    // check if the template is in our db
                                    const select_lang = await db.query(`SELECT * FROM message_template tmp
											LEFT JOIN master_language lan on lan.language_id = tmp.language_id
											WHERE tmp.template_name = '${response.data.data[i].name}' AND lan.language_code = '${response.data.data[i].language}' AND tmp.template_status = 'Y'`);

                                    if (select_lang.length != 0) {

                                        // loop all the components to check if the template have variables and media. 
                                        for (var p = 0; p < response.data.data[i].components.length; p++) {

                                            // if template has variables set variable_status as how many variables the template has.
                                            if (response.data.data[i].components[p]['type'] == 'body' || response.data.data[i].components[p]['type'] == 'BODY') {
                                                if (response.data.data[i].components[p]['example']) {
                                                    variable_status = response.data.data[i].components[p]['example']['body_text'][0].length
                                                }
                                            }

                                            // if template has media set ismedia flag as true and set the position of the media json in mediaplace
                                            if (response.data.data[i].components[p]['type'] == 'HEADER' && response.data.data[i].components[p]['format'] != 'TEXT') {
                                                logger_all.info("Media found")
                                                isMedia = true;
                                                mediaPlace = p;
                                            }
                                        }

                                        // insert template in db
                                        const insert_new_usr = await db.query(`INSERT INTO message_template VALUES(NULL,${check_user[0].whatspp_config_id},'${select_lang[0].unique_template_id}','${response.data.data[i].name}',${select_lang[0].language_id},'${response.data.data[i].category}','${JSON.stringify(response.data.data[i].components)}','-',1,'N',CURRENT_TIMESTAMP,'0000-00-00 00:00:00',${variable_status})`);
                                        // ismedia found in this template. we have to get the media and get the header_handle value of the media by using the below facebbok api
                                        if (isMedia) {
                                            // url of the media
                                            var h_file = await getHeaderFile(response.data.data[i].components[mediaPlace]['example']['header_handle'][0]);

                                            if (h_file) {

                                                // send request to the api to get the header_handle
                                                var command = `curl -X POST \
                            "${api_url}${h_file[0]}" \
                            --header "Authorization: OAuth ${media_bearer}" \
                            --header "file_offset: 0" \
                            --data-binary @${h_file[1]}`

                                                child = exec(command, async function (error, stdout, stderr) {

                                                    logger_all.info(' stdout: ' + stdout);
                                                    logger_all.info(' stderr: ' + stderr);

                                                    var curl_output = JSON.parse(stdout);
                                                    fs.unlinkSync(h_file[1]);
                                                    header_value = curl_output.h;
                                                    // return curl_output.h
                                                    // })

                                                    // after got the header_handle value replace the old header_handle with new one.
                                                    response.data.data[i].components[mediaPlace]['example']['header_handle'][0] = header_value;

                                                    // json for request a template
                                                    var tmpl_data = {
                                                        name: response.data.data[i].name,
                                                        language: response.data.data[i].language,
                                                        category: response.data.data[i].category,
                                                        components: response.data.data[i].components
                                                    }

                                                    var post_temp = {
                                                        method: 'post',
                                                        url: api_url_user,
                                                        headers: {
                                                            'Authorization': 'Bearer ' + select_id[0].bearer_token,
                                                        },
                                                        params: tmpl_data
                                                    };

                                                    logger_all.info("[template post request] : " + JSON.stringify(post_temp))

                                                    // request to the api to create template in facebook
                                                    await axios(post_temp)
                                                        .then(async function (response) {

                                                            logger_all.info("[template response] : " + JSON.stringify(response.data))

                                                            // if successfully requested, then update the template status and template id
                                                            const update_succ = await db.query(`UPDATE message_template SET template_response_id = '${response.data.id}',template_status = 'S' WHERE template_id = ${insert_new_usr.insertId}`);

                                                            // push the success template in succ_template
                                                            succ_template.push({ template_name: response.data.data[i].name })

                                                            // check if this is the last template, so we can send response to client.
                                                            if (i == response.data.data.length - 1) {
                                                                logger.info("[API RESPONSE] " + JSON.stringify({ response_code: 1, response_status: 200, response_msg: 'Success', succ_template: succ_template, failed_template: failed_template, request_id: req.body.request_id }))

                                                                const log_update_result = await db.query(`UPDATE api_log SET response_status = 'S',response_date = CURRENT_TIMESTAMP, response_comments = 'Success' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);

                                                                return ({ response_code: 1, response_status: 200, response_msg: 'Success', succ_template: succ_template, failed_template: failed_template, request_id: req.body.request_id });
                                                            }

                                                        })
                                                        .catch(async function (error) {
                                                            logger_all.info("[template approval failed response] : " + error)

                                                            // if any error or failure, update the template status as F
                                                            const update_failure_temp = await db.query(`UPDATE message_template SET template_status = 'F' WHERE template_id = ${insert_new_usr.insertId}`);

                                                            // push the failed template in failed_template array
                                                            failed_template.push({ template_name: response.data.data[i].name, reason: error.message })

                                                            // check if this is the last template, so we can send response to client.
                                                            if (i == response.data.data.length - 1) {
                                                                logger.info("[API RESPONSE] " + JSON.stringify({ response_code: 1, response_status: 200, response_msg: 'Success', succ_template: succ_template, failed_template: failed_template, request_id: req.body.request_id }))

                                                                const log_update_result = await db.query(`UPDATE api_log SET response_status = 'S',response_date = CURRENT_TIMESTAMP, response_comments = 'Success' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);

                                                                return ({ response_code: 1, response_status: 200, response_msg: 'Success', succ_template: succ_template, failed_template: failed_template, request_id: req.body.request_id });
                                                            }
                                                        })
                                                })
                                            }
                                        }
                                        else {
                                            // if template doesn't have media directly we can request template
                                            var tmpl_data = {
                                                name: response.data.data[i].name,
                                                language: response.data.data[i].language,
                                                category: response.data.data[i].category,
                                                components: response.data.data[i].components
                                            }

                                            var post_temp = {
                                                method: 'post',
                                                url: api_url_user,
                                                headers: {
                                                    'Authorization': 'Bearer ' + select_id[0].bearer_token,
                                                },
                                                params: tmpl_data
                                            };

                                            logger_all.info("[template post request] : " + JSON.stringify(post_temp))

                                            await axios(post_temp)
                                                .then(async function (response) {

                                                    logger_all.info("[template response] : " + JSON.stringify(response.data))

                                                    // if successfully requested, then update the template status and template id
                                                    const update_succ = await db.query(`UPDATE message_template SET template_response_id = '${response.data.id}',template_status = 'S' WHERE template_id = ${insert_new_usr.insertId}`);

                                                    // push the success template in succ_template
                                                    succ_template.push({ template_name: response.data.data[i].name })

                                                    // check if this is the last template, so we can send response to client.
                                                    if (i == response.data.data.length - 1) {
                                                        logger.info("[API RESPONSE] " + JSON.stringify({ response_code: 1, response_status: 200, response_msg: 'Success', succ_template: succ_template, failed_template: failed_template, request_id: req.body.request_id }))

                                                        const log_update_result = await db.query(`UPDATE api_log SET response_status = 'S',response_date = CURRENT_TIMESTAMP, response_comments = 'Success' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);

                                                        return ({ response_code: 1, response_status: 200, response_msg: 'Success', succ_template: succ_template, failed_template: failed_template, request_id: req.body.request_id });
                                                    }

                                                })
                                                .catch(async function (error) {
                                                    logger_all.info("[template approval failed response] : " + error)

                                                    // if any error or failure, update the template status as F
                                                    const update_failure_temp = await db.query(`UPDATE message_template SET template_status = 'F' WHERE template_id = ${insert_new_usr.insertId}`);

                                                    // push the failed template in failed_template array
                                                    failed_template.push({ template_name: response.data.data[i].name, reason: error.message })

                                                    // check if this is the last template, so we can send response to client.
                                                    if (i == response.data.data.length - 1) {
                                                        logger.info("[API RESPONSE] " + JSON.stringify({ response_code: 1, response_status: 200, response_msg: 'Success', succ_template: succ_template, failed_template: failed_template, request_id: req.body.request_id }))

                                                        const log_update_result = await db.query(`UPDATE api_log SET response_status = 'S',response_date = CURRENT_TIMESTAMP, response_comments = 'Success' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);

                                                        return ({ response_code: 1, response_status: 200, response_msg: 'Success', succ_template: succ_template, failed_template: failed_template, request_id: req.body.request_id });
                                                    }
                                                })
                                        }
                                    }
                                    else {
                                        // if the template not available in db then we are not going to request for that template
                                        logger_all.info("[template not available] : " + response.data.data[i].name + " - " + response.data.data[i].language)
                                        // push the failed template in failed_template array
                                        failed_template.push({ template_name: response.data.data[i].name, reason: 'Template not available' })

                                        // check if this is the last template, so we can send response to client.
                                        if (i == response.data.data.length - 1) {
                                            logger.info("[API RESPONSE] " + JSON.stringify({ response_code: 1, response_status: 200, response_msg: 'Success', succ_template: succ_template, failed_template: failed_template, request_id: req.body.request_id }))

                                            const log_update_result = await db.query(`UPDATE api_log SET response_status = 'S',response_date = CURRENT_TIMESTAMP, response_comments = 'Success' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);

                                            return ({ response_code: 1, response_status: 200, response_msg: 'Success', succ_template: succ_template, failed_template: failed_template, request_id: req.body.request_id });
                                        }

                                    }
                                }
                                else {
                                    // template not approved by facebook then we are not going to request for that template
                                    logger_all.info("[template not approved] : " + response.data.data[i].name + " - " + response.data.data[i].language)
                                    // push the failed template in failed_template array
                                    failed_template.push({ template_name: response.data.data[i].name, reason: 'Template not approved' })

                                    // check if this is the last template, so we can send response to client
                                    if (i == response.data.data.length - 1) {
                                        logger.info("[API RESPONSE] " + JSON.stringify({ response_code: 1, response_status: 200, response_msg: 'Success', succ_template: succ_template, failed_template: failed_template, request_id: req.body.request_id }))

                                        const log_update_result = await db.query(`UPDATE api_log SET response_status = 'S',response_date = CURRENT_TIMESTAMP, response_comments = 'Success' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);

                                        return ({ response_code: 1, response_status: 200, response_msg: 'Success', succ_template: succ_template, failed_template: failed_template, request_id: req.body.request_id });
                                    }
                                }
                            }

                        })
                        .catch(async function (error) {
                            // any error occurres send error response to client
                            logger_all.info("[user approval failed response] : " + error)
                            logger.info("[API RESPONSE] " + JSON.stringify({ response_code: 0, response_status: 201, response_msg: 'Error occurred while getting templates', request_id: req.body.request_id }))

                            const log_update_result = await db.query(`UPDATE api_log SET response_status = 'F',response_date = CURRENT_TIMESTAMP, response_comments = 'Error occurred while getting templates' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);

                            return ({ response_code: 0, response_status: 201, response_msg: 'Error occurred while getting templates', request_id: req.body.request_id });

                        })
                }
                else {
                    // if this is the new user we don't have to request for any template.
                    logger_all.info("[New user - No template available] : " + mobile_number)
                    logger.info("[API RESPONSE] " + JSON.stringify({ response_code: 1, response_status: 200, response_msg: 'New user', request_id: req.body.request_id }))

                    const log_update_result = await db.query(`UPDATE api_log SET response_status = 'S',response_date = CURRENT_TIMESTAMP, response_comments = 'New user' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);

                    return ({ response_code: 1, response_status: 200, response_msg: 'Success', request_id: req.body.request_id });

                }

            }
        }
    }

    catch (e) {
        // any error occurres send error response to client
        logger_all.info("[user approval failed response] : " + e)
        logger.info("[API RESPONSE] " + JSON.stringify({ response_code: 0, response_status: 201, response_msg: 'Error occurred', request_id: req.body.request_id }))

        const log_update_result = await db.query(`UPDATE api_log SET response_status = 'F',response_date = CURRENT_TIMESTAMP, response_comments = 'Error occurred' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);

        return ({ response_code: 0, response_status: 201, response_msg: 'Error occurred', request_id: req.body.request_id });

    }
}
// ApproveSenderId - end


// using for module exporting
module.exports = {
ApproveSenderId
}
