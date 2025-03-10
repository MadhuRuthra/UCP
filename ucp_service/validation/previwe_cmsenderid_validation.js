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
const previwe_cmsenderid_validation = Joi.object().keys({
  // Object Properties are define
  user_id: Joi.string().optional().label("User Id"),
  t_cm_sender_id: Joi.string().optional().label("t_cm_sender_id"),
  t_cm_consent_id: Joi.string().optional().label("t_cm_consent_id")
}).options({ abortEarly: false });
// To exports the AvailableCreditsList module
module.exports = previwe_cmsenderid_validation
 