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
const savetemplateid = Joi.object().keys({
  // Object Properties are define
  /*  $replace_txt = '{
    "user_id" : "' . $_SESSION['yjucp_user_id'] . '",
    "cn_template_type" : "' . $cn_template_type . '",
    "cn_template_buscategory" : "' . $cn_template_buscategory . '",
    "t_cm_sender_id" : "' . $t_cm_sender_id . '",
    "t_cm_consent_id" : "' . $t_cm_consent_id . '",
    "cn_msgtype" : "' . $cn_msgtype . '",
    "cn_template_name" : "' . $cn_template_name . '",
    "cn_message" : "' . $cn_message . '",
    "exist_new_template" : "' . $exist_new_template . '"
}'; */
  user_id: Joi.string().optional().label("User Id"),
  cn_template_type: Joi.string().optional().label("Content Template Type"),
  cn_template_buscategory: Joi.string().optional().label("Content Template Business Category"),
  t_cm_sender_id: Joi.string().optional().label("t cn sender id"),
  t_cm_consent_id: Joi.string().optional().label("t_cm_consent_id"),
  cn_msgtype: Joi.string().optional().label("Content Message Type"),
  cn_template_name: Joi.string().optional().label("content Template Name"),
  cn_message: Joi.string().optional().label("Content Message"),
  exist_new_template: Joi.string().optional().label("Exist New Template")
}).options({ abortEarly: false });
// To exports the AvailableCreditsList module
module.exports = savetemplateid
 