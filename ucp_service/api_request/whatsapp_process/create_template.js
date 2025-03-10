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
const main = require('../../logger');
const getHeaderFile = require('./getHeader');
// createtemplate - start
async function createtemplate(req, res) {
    // get all the data from the api body and headers
    const { logger_all, logger } = main;
    try {

        var header_json = req.headers;
        let ip_address = header_json['x-forwarded-for'];

        // get current_year to generate a template name
        const day = new Date();
        var current_year = day.getFullYear().toString();

        // get today's julian date to generate template name
        Date.prototype.julianDate = function () {
            var j = parseInt((this.getTime() - new Date('Dec 30,' + (this.getFullYear() - 1) + ' 23:00:00').getTime()) / 86400000).toString(),
                i = 3 - j.length;
            while (i-- > 0) j = 0 + j;
            return j
        };

        const { language, category: temp_category, code: temp_details, media_url, user_id } = req.body;
        const temp_components = req.body.components;

        //  initialize required variable and arrays. 
        var full_short_name, unique_id, media_type, h_file, error_array = [], variable_count = 0;

        await db.query(`INSERT INTO api_log VALUES(NULL, 0, '${req.originalUrl}', '${ip_address}', '${req.body.request_id}', 'N', '-', '0000-00-00 00:00:00', 'Y', CURRENT_TIMESTAMP)`);

        const check_req_id_result = await db.query(`SELECT * FROM api_log WHERE request_id = '${req.body.request_id}' AND response_status != 'N' AND api_log_status='Y'`);

        if (check_req_id_result.length != 0) {

            logger_all.info("[failed response] : Request already processed");
            logger.info("[API RESPONSE] " + JSON.stringify({ request_id: req.body.request_id, response_code: 0, response_status: 201, response_msg: 'Request already processed', request_id: req.body.request_id }))
            await db.query(`UPDATE api_log SET response_status = 'F',response_date = CURRENT_TIMESTAMP, response_comments = 'Request already processed' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);

            return ({ response_code: 0, response_status: 201, response_msg: 'Request already processed', request_id: req.body.request_id });

        }
        // if req.body contains user_id we are checking both user_id and bearer token are valid and store some information like short_name for generate a template name

        const get_user_id = await db.query(`SELECT * FROM user_management WHERE user_id = '${user_id}'`);
        full_short_name = get_user_id[0].user_short_name;

        // get the unique_serial_number to generate unique template name
        const get_unique_id = await db.query(`SELECT unique_template_id FROM message_template ORDER BY template_id DESC limit 1`);

        // if nothing returns this is going to be a first template so make it as 001
        if (get_unique_id.length == 0) {
            unique_id = '001'
        }
        else {
            // Get the serial number of the latest template
            var serial_id = get_unique_id[0].unique_template_id.slice(-3); // Get last 3 characters
            var temp_id = parseInt(serial_id) + 1;

            // Add leading zeros if necessary
            unique_id = temp_id.toString().padStart(3, '0');

        }

        var tmp_details;
        var tmp_details_test;

        // if receive media_url get the media type of the media
        if (media_url) {
            console.log("Media_url" + media_url)
            h_file = await getHeaderFile.getHeaderFile(media_url);
        }

        // check the template code is received to make the pld code work
        if (!temp_details) {
            // initialize the code 
            tmp_details = '000000000';
            // function to set the character ina string at a specific position
            function setCharAt(index, chr) {
                if (index > tmp_details.length - 1) return tmp_details;
                tmp_details = tmp_details.substring(0, index) + chr + tmp_details.substring(index + 1);
                return tmp_details.substring(0, index) + chr + tmp_details.substring(index + 1);
            }

            // check the template have english text or other language, media or not, buttons - to validate the template have all of the components as mentioned in the template_code.
            // if it is not same, then something is missing we send a error response to client
            for (var p = 0; p < temp_components.length; p++) {
                // Replace &amp; with & in text
                if (temp_components[p]['text']) {
                    temp_components[p]['text'] = temp_components[p]['text'].replace(/&amp;/g, "&");
                }

                // Handle body type
                if (temp_components[p]['type'].toUpperCase() == 'BODY') {
                    if (temp_components[p]['example']) {
                        var variable_count = temp_components[p]['example']['body_text'][0].length;
                    }
                    setCharAt(0, language == 'en_US' || language == 'en_GB' ? "t" : "l");
                }

                // Handle header type
                if (temp_components[p]['type'].toUpperCase() == 'HEADER') {
                    setCharAt(1, "h");
                }

                // Handle footer type
                if (temp_components[p]['type'].toUpperCase() == 'FOOTER') {
                    setCharAt(8, "f");
                }

                // Handle buttons type
                if (temp_components[p]['type'].toUpperCase() == 'BUTTONS') {
                    temp_components[p]['buttons'].forEach(function (button) {
                        if (button['type'] == 'URL') setCharAt(6, "u");
                        if (button['type'] == 'QUICK_REPLY') setCharAt(7, "r");
                        if (button['type'] == 'PHONE_NUMBER') setCharAt(5, "c");
                    });
                }

                // Handle media type
                if (media_url && h_file) {
                    if (h_file[2] == 'IMAGE') {
                        setCharAt(2, "i");
                    } else if (h_file[2] == 'VIDEO') {
                        setCharAt(3, "v");
                    } else if (h_file[2] == 'DOCUMENT') {
                        setCharAt(4, "d");
                    }
                }
            }
        }
        // this block doing the same work as the previos block
        else {

            tmp_details_test = '000000000';
            /*function setCharAtTest(index, chr) {
                if (index > tmp_details_test.length - 1) return tmp_details_test;
                tmp_details_test = tmp_details_test.substring(0, index) + chr + tmp_details_test.substring(index + 1);
                return tmp_details_test.substring(0, index) + chr + tmp_details_test.substring(index + 1);
            }*/

            function setCharAtTest(index, chr) {
    // Check if the index is valid
    if (index < 0 || index >= tmp_details_test.length) {
        console.warn(`Invalid index: ${index}`);
        return tmp_details_test; // Return the original string if index is out of bounds
    }
    // Update the global string and return it
    tmp_details_test = tmp_details_test.substring(0, index) + chr + tmp_details_test.substring(index + 1);
    return tmp_details_test;
}


            if (temp_details[2].toString() == 'i') {
                if (temp_details[3].toString() != '0' || temp_details[4].toString() != '0') {
                    logger.info("[API RESPONSE] " + JSON.stringify({ response_code: 0, response_status: 201, response_msg: 'Mismatch code.', request_id: req.body.request_id }))

                    await db.query(`UPDATE api_log SET response_status = 'F',response_date = CURRENT_TIMESTAMP, response_comments = 'Mismatch code' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);

                    return res.json({ response_code: 0, response_status: 201, response_msg: 'Mismatch code.', request_id: req.body.request_id });
                }
                media_type = 'IMAGE'
                setCharAtTest(2, "i");
            }

            else if (temp_details[3].toString() == 'v') {
                if (temp_details[2].toString() != '0' || temp_details[4].toString() != '0') {
                    logger.info("[API RESPONSE] " + JSON.stringify({ response_code: 0, response_status: 201, response_msg: 'Mismatch code.', request_id: req.body.request_id }))

                    await db.query(`UPDATE api_log SET response_status = 'F',response_date = CURRENT_TIMESTAMP, response_comments = 'Mismatch code' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);

                    return res.json({ response_code: 0, response_status: 201, response_msg: 'Mismatch code.', request_id: req.body.request_id });
                }
                media_type = 'VIDEO'
                setCharAtTest(3, "v");
            }

            else if (temp_details[4].toString() == 'd') {
                if (temp_details[3].toString() != '0' || temp_details[2].toString() != '0') {
                    logger.info("[API RESPONSE] " + JSON.stringify({ response_code: 0, response_status: 201, response_msg: 'Mismatch code.', request_id: req.body.request_id }))

                    await db.query(`UPDATE api_log SET response_status = 'F',response_date = CURRENT_TIMESTAMP, response_comments = 'Mismatch code' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);

                    return res.json({ response_code: 0, response_status: 201, response_msg: 'Mismatch code.', request_id: req.body.request_id });
                }
                media_type = 'DOCUMENT'
                setCharAtTest(4, "d");
            }

            for (var p = 0; p < temp_components.length; p++) {
                if (temp_components[p]['type'] == 'body' || temp_components[p]['type'] == 'BODY') {
                    temp_components[p]['text'] = temp_components[p]['text'].replace(/&amp;/g, "&")
                    if (temp_components[p]['example']) {
                        variable_count = temp_components[p]['example']['body_text'][0].length
                    }
                    if (language == 'en_US' || language == 'en_GB') {
                        setCharAtTest(0, "t");
                    }
                    else {
                        setCharAtTest(0, "l");
                    }

                }

                if (temp_components[p]['type'] == 'HEADER') {
                    temp_components[p]['text'] = temp_components[p]['text'].replace(/&amp;/g, "&")
                    setCharAtTest(1, "h");
                }

                if (temp_components[p]['type'] == 'FOOTER') {
                    temp_components[p]['text'] = temp_components[p]['text'].replace(/&amp;/g, "&")
                    setCharAtTest(8, "f");
                }
                /*if (temp_components[p]['type'] == 'BUTTONS') {
                     console.log("temp_components[p]['buttons'].length"+temp_components[p]['buttons'].length)
                    for (var b = 0; b < temp_components[p]['buttons'].length; b++) {
                       console.log("temp_components[p]['buttons'][b]['type']" + temp_components[p]['buttons'][b]['type'])
                        if (temp_components[p]['buttons'][b]['type'] == 'URL') {
                            setCharAtTest(6, "u");
                        }
                        if (temp_components[p]['buttons'][b]['type'] == 'QUICK_REPLY') {
                            setCharAtTest(7, "r");
                        }

                        if (temp_components[p]['buttons'][b]['type'] == 'PHONE_NUMBER') {
                            setCharAtTest(5, "c");
                        }

                    }

                }*/

if (temp_components[p]['type'] === 'BUTTONS' && Array.isArray(temp_components[p]['buttons'])) {
    for (var b = 0; b < temp_components[p]['buttons'].length; b++) {
        const buttonType = temp_components[p]['buttons'][b]['type'];
        console.log("Processing button type:", buttonType); // Debugging
        if (buttonType === 'URL') {
            setCharAtTest(6, "u");
        } else if (buttonType === 'QUICK_REPLY') {
            setCharAtTest(7, "r");
        } else if (buttonType === 'PHONE_NUMBER') {
            setCharAtTest(5, "c");
        }
    }
}


            }

            // if media found in the component
            if (media_type) {
                // if media type found but media url not in request media is required. so we send error response to the client
                if (!media_url) {
                    logger.info("[API RESPONSE] " + JSON.stringify({ response_code: 0, response_status: 201, response_msg: 'Mismatch code', request_id: req.body.request_id }))

                    await db.query(`UPDATE api_log SET response_status = 'F',response_date = CURRENT_TIMESTAMP, response_comments = 'Mismatch code' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);

                    return res.json({ response_code: 0, response_status: 201, response_msg: 'Mismatch code', request_id: req.body.request_id });
                }
                // if media_url is in the request
                else {
                    // check the type of media. if we receive .mp4 file and media_type image, it is not going to work. Checked here and send error response to the client
                    if (media_type == 'IMAGE' || media_type == 'VIDEO') {
                        if (media_type != h_file[2]) {
                            logger.info("[API RESPONSE] " + JSON.stringify({ response_code: 0, response_status: 201, response_msg: 'Mismatch media type.', request_id: req.body.request_id }))


                            await db.query(`UPDATE api_log SET response_status = 'F',response_date = CURRENT_TIMESTAMP, response_comments = 'Mismatch media type' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);

                            return res.json({ response_code: 0, response_status: 201, response_msg: 'Mismatch media type.', request_id: req.body.request_id });
                        }
                    }
                }
            }

            else {
                // if media_type not found but we recieve media_url we send error response to the client
                if (media_url) {
                    logger.info("[API RESPONSE] " + JSON.stringify({ response_code: 0, response_status: 201, response_msg: 'Mismatch code', request_id: req.body.request_id }))
                    await db.query(`UPDATE api_log SET response_status = 'F',response_date = CURRENT_TIMESTAMP, response_comments = 'Mismatch code' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);

                    return res.json({ response_code: 0, response_status: 201, response_msg: 'Mismatch code', request_id: req.body.request_id });
                }
            }

            // if both our template code and request template code are not same, send error response to the client
console.log(tmp_details_test +"tmp_details_test")
console.log(temp_details +"temp_details")
            if (tmp_details_test != temp_details) {
                logger.info("[API RESPONSE] " + JSON.stringify({ response_code: 0, response_status: 201, response_msg: 'Mismatch code', request_id: req.body.request_id }))

                await db.query(`UPDATE api_log SET response_status = 'F',response_date = CURRENT_TIMESTAMP, response_comments = 'Mismatch code' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);

                return res.json({ response_code: 0, response_status: 201, response_msg: 'Mismatch code', request_id: req.body.request_id });
            }

            // if everything fine assign the recieved template code in one variable
            tmp_details = temp_details;
        }
        // generate unique template name 
        let temp_name = `te_${full_short_name}_${tmp_details}_${current_year.substring(2)}${day.getMonth() + 1}${day.getDate()}_${unique_id}`;
        let unique_template_id = `tmplt_${full_short_name}_${new Date().julianDate()}_${unique_id}`;

        const usedCampaignIds = new Set();
        function generateCampaignId() {
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            let campaignId;

            do {
                campaignId = '';
                for (let i = 0; i < 10; i++) {
                    const randomIndex = Math.floor(Math.random() * characters.length);
                    campaignId += characters.charAt(randomIndex);
                }
            } while (usedCampaignIds.has(campaignId));

            usedCampaignIds.add(campaignId);

            // Add any additional formatting if needed
            return campaignId;
        }
        // Example usage:
        const templateid = generateCampaignId();

        // get the all sender number which are mapped to the user
        const mobile_number = await db.query(`SELECT whatspp_config_id, user_id, concat(country_code,mobile_no) mobile_no, bearer_token,phone_number_id,whatsapp_business_acc_id FROM whatsapp_config where (user_id = '${user_id}' or user_id in ('${user_id}')) and whatspp_config_status = 'Y'`);

        // if the user has nothing send error response to the client  
        if (mobile_number.length == 0) {
            logger.info("[API RESPONSE] " + JSON.stringify({ response_code: 0, response_status: 201, response_msg: 'No number available', request_id: req.body.request_id }))

            await db.query(`UPDATE api_log SET response_status = 'F',response_date = CURRENT_TIMESTAMP, response_comments = 'No number available' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);

            res.json({ response_code: 0, response_status: 201, response_msg: 'No number available', request_id: req.body.request_id });
        }
        else {

            // loop fo all the sender_number the user have
            for (var i = 0; i < mobile_number.length; i++) {

                // check if the language is in our db 
                const select_lang = await db.query(`SELECT * from master_language WHERE language_code = '${language}' AND language_status = 'Y'`);

                if (select_lang.length == 0) {
                    logger_all.info("[template approval failed number] : " + mobile_number[i] + " - language not available in DB")
                    error_array.push({ mobile_number: mobile_number[i].mobile_no, reason: 'Language not available' })
                }

                // get the whatsapp business id, bearer token for the sender number from db
                await db.query(`INSERT INTO message_template VALUES(NULL,${mobile_number[i].whatspp_config_id},'${unique_template_id}','${temp_name}',${select_lang[0].language_id},'${temp_category}','${JSON.stringify(temp_components)}','-','${user_id}','N',CURRENT_TIMESTAMP,'0000-00-00 00:00:00',${variable_count},${media_url ? `'${media_url}'` : 'NULL'},${media_type ? `'${media_type}'` : 'NULL'},NULL,'${templateid}')`);
            }

        }

        await db.query(`UPDATE api_log SET response_status = 'S', response_date = CURRENT_TIMESTAMP, response_comments = 'Success' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);

        // Returning the response should be the last action.
        return { response_code: 1, response_status: 200, response_msg: 'Success ', request_id: req.body.request_id };


    }
    catch (e) {
        logger_all.info(e);
        // if error occurred send error response to the client
        logger_all.info("[template approval failed response] : " + e)
        logger.info("[API RESPONSE] " + JSON.stringify({ response_code: 0, response_status: 201, response_msg: 'Error occurred ', request_id: req.body.request_id }))
        await db.query(`UPDATE api_log SET response_status = 'F',response_date = CURRENT_TIMESTAMP, response_comments = 'Error occurred' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);

        return ({ response_code: 0, response_status: 201, response_msg: 'Error occurred ', request_id: req.body.request_id });

    }
}
// createtemplate - end


// using for module exporting
module.exports = {
    createtemplate
}
