/*
API that allows your frontend to communicate with your backend server (Node.js) for processing and retrieving data.
To access a MySQL database with Node.js and can be use it.
This page is used in template function which is used to get a template
details.

Version : 1.0
Author : Madhubala (YJ0009)
Date : 05-Jul-2023
*/
// Import the required packages and libraries
const db = require("../../db_connect/connect");
const main = require('../../logger')
require('dotenv').config();
// getTemplate - start
async function getTemplate(req) {
  try {
    var logger_all = main.logger_all

    // get all the req data
    let user_id = req.body.user_id;
    var select_template = [];
    // query parameters
    logger_all.info("[get template query parameters] : " + JSON.stringify(req.body));

      select_template = await db.query(`SELECT distinct tmp.unique_template_id template_id,tmp.template_name, lng.language_code, tmp.body_variable_count,tmp.template_message FROM message_template tmp left join master_language lng on lng.language_id = tmp.language_id left join user_management usr on tmp.created_user = usr.user_id where tmp.template_status = 'Y' and (usr.user_id = '${user_id}' or usr.parent_id = '${user_id}') GROUP BY unique_template_id ORDER BY tmp.template_name ASC`);
    
    // to return the success message 
    return { response_code: 1, response_status: 200, response_msg: 'Success ', num_of_rows: select_template.length, templates: select_template };
  }
  catch (e) { // any error occurres send error response to client
    logger_all.info("[get template failed response] : " + e)
    return { response_code: 0, response_status: 201, response_msg: 'Error Occurred ' };
  }
}
// getTemplate - end

// using for module exporting
module.exports = {
  getTemplate,
};
