/*
It is used to one of which is user input validation.
AvailableCreditsList function to validate the user.

Version : 1.0
Author : Sabena yasmin (YJ0008)
Date : 30-Sep-2023
*/
// Import the required packages and libraries
const Joi = require("@hapi/joi");
// To declare AvailableCreditsList object 
const save_senderid_validation = Joi.object().keys({
  // Object Properties are define
  user_id: Joi.string().optional().label("User Id"),
  slt_operator: Joi.string().optional().label(" Select Operator"),
  dlt_process: Joi.string().optional().label("DLT Process"),
  slt_template_type: Joi.string().optional().label("Select Template Type"),
  //license_docs: Joi.string().optional().label("License Docs"),
  slt_business_category: Joi.string().optional().label("Select Business Category"),
  header_sender_id: Joi.string().optional().label("Header Sende Id"),
  txt_explanation: Joi.string().optional().label("Text Explanation"),
  ex_new_senderid: Joi.string().optional().label("Ex New Sende Id"),
  filename: Joi.string().optional().label("File Name"),
  filename1: Joi.string().optional().label("File Name 1"),
  txt_constempname: Joi.string().optional().label("txt_constempname"),
  txt_consbrndname: Joi.string().optional().label("txt_consbrndname"),
  txt_consmsg: Joi.string().optional().label("txt_consmsg"),
  request_id: Joi.string().optional().label("Request ID")

}).options({ abortEarly: false });
// To exports the AvailableCreditsList module
module.exports = save_senderid_validation
