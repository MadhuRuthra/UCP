/*
API that allows your frontend to communicate with your backend server (Node.js) for processing and retrieving data.
To access a MySQL database with Node.js and can be use it.
This page is used in template function which is used to get a single template
details.

Version : 1.0
Author : Madhubala (YJ0009)
Date : 05-Jul-2023
*/
// Import the required packages and libraries
const db = require("../../db_connect/connect");
const main = require('../../logger')
const env = process.env;
require('dotenv').config();
var axios = require('axios');
const nodemailer = require('nodemailer');
const api_url = env.API_URL;
const media_bearer = env.MEDIA_BEARER;

// ApproveRejectTemplate - start
async function ApproveRejectTemplate(req) {
  try {
    var logger_all = main.logger_all

    // get current Date and time
    var day = new Date();
    var today_date = day.getFullYear() + '-' + (day.getMonth() + 1) + '-' + day.getDate();
    var today_time = day.getHours() + ":" + day.getMinutes() + ":" + day.getSeconds();
    var current_date = today_date + ' ' + today_time;

    // get all the req data
    var change_status = req.body.change_status;
    var template_id = req.body.template_id;
    var reject_reason = req.body.reject_reason;
    var selected_user_id = req.body.selected_user_id;


    var succ_array = [], error_array = [];


    // get the all sender number which are mapped to the user
    const mobile_number = await db.query(`SELECT whatspp_config_id, user_id, concat(country_code,mobile_no) mobile_no, bearer_token,phone_number_id,whatsapp_business_acc_id FROM whatsapp_config where (user_id = '${selected_user_id}' or user_id in ('${selected_user_id}')) and whatspp_config_status = 'Y' AND is_qr_code = 'N'`);


    // Extract separate arrays for each field
    const sender_number = mobile_number.map(row => row.mobile_no);
    const sender_number_bearer_token = mobile_number.map(row => row.bearer_token);
    // const phoneNumberIds = mobile_number.map(row => row.phone_number_id);
    const sender_number_business_id = mobile_number.map(row => row.whatsapp_business_acc_id);



    if (mobile_number.length == 0) {
      logger.info("[API RESPONSE] " + JSON.stringify({ response_code: 0, response_status: 201, response_msg: 'No number available', request_id: req.body.request_id }))
    }
    else {

      // loop fo all the sender_number the user have
      for (var i = 0; i < mobile_number.length; i++) {

        var get_template = await db.query(`SELECT * from message_template WHERE unique_template_id = '${template_id}' AND template_status = 'N' `)
        const temp_insert_ids = template_id.map(row => row.template_id);

        const { template_id,language_id,template_category, temp_name : template_name, media_url, media_type } = get_template[0];

          // check if the language is in our db 
          const select_lang = await db.query(`SELECT * from master_language WHERE language_id = '${language_id}' AND language_status = 'Y'`);
          const language = language.map(row => row.language_code);

          

        // if no sender_number found send error response to the client
        if (sender_number.length == 0) {
          logger.info("[API RESPONSE] " + JSON.stringify({ response_code: 0, response_status: 201, response_msg: 'No number available or Language not available', request_id: req.body.request_id }))
          await db.query(`UPDATE api_log SET response_status = 'F',response_date = CURRENT_TIMESTAMP, response_comments = 'No number available or language not available' WHERE request_id = '${req.body.request_id}' AND response_status = 'N'`);

          res.json({ response_code: 0, response_status: 201, response_msg: 'No number available or Language not available', request_id: req.body.request_id });
        }
        else {
          // if media is in template
          if (media_url) {

            // get the header_handle value for the media
            var command = `curl -X POST \
                    "${api_url}${h_file[0]}" \
                    --header "Authorization: OAuth ${media_bearer}" \
                    --header "file_offset: 0" \
                    --data-binary @${h_file[1]}`

            child = exec(command, async function (error, stdout, stderr) {

              logger_all.info(' stdout: ' + stdout);
              logger_all.info(' stderr: ' + stderr);

              var curl_output = JSON.parse(stdout);

              // add media json block in components
              temp_components.push({
                "type": "HEADER",
                "format": media_type,
                "example": { "header_handle": [curl_output.h] }
              })

              fs.unlinkSync(h_file[1]);

              // loop for the sender numbers in the user to request template for all sender numbers
              for (var i = 0; i < sender_number.length; i++) {
                // api url will have the sender number's whatsapp business acc id
                api_url_updated = `${api_url}${sender_number_business_id[i]}/message_templates`

                // json for request template
                var data = {
                  name: temp_name,
                  language: language,
                  category: template_category,
                  components: temp_components
                };

                var temp_msg = {
                  method: 'post',
                  url: api_url_updated,
                  headers: {
                    'Authorization': 'Bearer ' + sender_number_bearer_token[i],
                  },
                  params: data
                };

                logger_all.info("[template approval request] : " + JSON.stringify(temp_msg))

                await axios(temp_msg)
                  .then(async function (response) {
                    logger_all.info("[template approval success number] : " + sender_number[i] + " - " + util.inspect(response.data))
                    // push the success template in succ_template
                    succ_array.push({ mobile_number: sender_number[i], template_id: unique_template_id, template_name: temp_name })

                    // if successfully requested, then update the template status and template id
                    const update_succ = await db.query(`UPDATE message_template SET template_response_id = '${response.data.id}', template_status = 'S',template_message = '${JSON.stringify(temp_components)}' WHERE template_id = ${temp_insert_ids[i]}`);

                    // increment the counter
                    count++;
                    // check if this is the last sender number, so we can send response to client
                    if (count == sender_number.length) {
                      res_send();
                    }

                  })
                  .catch(async function (error) {
                    logger_all.info("[template approval failed number] : " + sender_number[i] + " - " + error)

                    // push the failed template in failed_template array
                    error_array.push({ mobile_number: sender_number[i], reason: error.message })

                    // if any error or failure, update the template status as F
                    await db.query(`UPDATE message_template SET template_status = 'F' WHERE template_id = ${temp_insert_ids[i]}`);

                    // increment the counter
                    count++;
                    // check if this is the last sender number, so we can send response to client
                    if (count == sender_number.length) {
                      res_send();
                    }
                  })
                // }

              }
              // if got error when get header_handle, all template request will fail. push the all number in failed_array
              if (error !== null) {
                logger_all.info("[upload file failed number] : " + error)

                for (var f = 0; f < temp_insert_ids; f++) {

                  await db.query(`UPDATE message_template SET template_status = 'F' WHERE template_id = ${temp_insert_ids[f]}`);
                  error_array.push({ mobile_number: sender_number[f], reason: 'Image upload failed' })

                }

                res_send();
              }

            });

          }
          // if media is not in template
          else {

            // loop for the sender numbers in the user to request template for all sender numbers
            for (var i = 0; i < sender_number.length; i++) {

              // api url will have the sender number's whatsapp business acc id
              api_url_updated = `${api_url}${sender_number_business_id[i]}/message_templates`

              // json for request template
              var data = {
                name: temp_name,
                language: language,
                category: temp_category,
                components: temp_components
              };

              var temp_msg = {
                method: 'post',
                url: api_url_updated,
                headers: {
                  'Authorization': 'Bearer ' + sender_number_bearer_token[i],
                },
                params: data
              };

              logger_all.info("[template approval request] : " + JSON.stringify(temp_msg))

              await axios(temp_msg)
                .then(async function (response) {
                  logger_all.info("[template approval success number] : " + sender_number[i] + " - " + util.inspect(response.data))
                  // push the success template in succ_template
                  succ_array.push({ mobile_number: sender_number[i], template_id: unique_template_id, template_name: temp_name })

                  // if successfully requested, then update the template status and template id

                  await db.query(`UPDATE message_template SET template_response_id = '${response.data.id}', template_status = 'S',template_message = '${JSON.stringify(temp_components)}' WHERE template_id = ${temp_insert_ids[i]}`);

                  // increment the counter
                  count++
                  // check if this is the last sender number, so we can send response to client
                  if (count == sender_number.length) {
                    res_send()
                  }
                })
                .catch(async function (error) {
                  logger_all.info("[template approval failed number] : " + sender_number[i] + " - " + error)
                  // push the failed template in failed_template array
                  error_array.push({ mobile_number: sender_number[i], reason: error.message })

                  // if any error or failure, update the template status as F
                  await db.query(`UPDATE message_template SET template_status = 'F' WHERE template_id = ${temp_insert_ids[i]}`);

                  // increment the counter
                  count++
                  // check if this is the last sender number, so we can send response to client
                  if (count == sender_number.length) {
                    res_send()
                  }
                })
            }
          }
        }

        // query parameters
        logger_all.info("[ApproveRejectTemplate query parameters] : " + JSON.stringify(req.body));
        // to check template_id and update the message_template table in template status and approve date.
        var approve_template = `UPDATE message_template SET template_status = '${change_status}', approve_date = '${current_date}',reject_reason = '${reject_reason}' WHERE unique_template_id = '${template_id}'`;
        logger_all.info("[update query request] : " + approve_template)

        update_template_status = await db.query(approve_template);

        logger_all.info("[update query response] : " + JSON.stringify(update_template_status))
        // if the update_template_status is '0' to send the 'No data available' message
        if (update_template_status.affectedRows != 0) {
          return {
            response_code: 1,
            response_status: 200,
            num_of_rows: update_template_status.length,
            response_msg: 'Success'
          };

        } else { // otherwise to send the 'Success' in response message.
          return {
            response_code: 1,
            response_status: 204,
            response_msg: 'No data available'
          };
        }
      }
    }

  } catch (e) { // any error occurres send error response to client
    logger_all.info("[ApproveRejectTemplate failed response] : " + e)
    return {
      response_code: 0,
      response_status: 201,
      response_msg: 'Error occured'
    };
  }
}
// WhatsappSenderID - end
// using for module exporting
module.exports = {
  ApproveRejectTemplate
};