/*
It is used to one of which is user input validation.
CmntsSenderid function to validate the user.

Version : 1.0
Author : Madhubala (YJ0009)
Date : 05-Jul-2023
*/
// Import the required packages and libraries
const Joi = require("@hapi/joi");
// To declare CmntsSenderid object 
const CmntsSenderid = Joi.object().keys({
  // Object Properties are define  
  user_id: Joi.string().optional().label("User Id"),
  senderid: Joi.string().required().label("Sender ID"),
  apprej_cmnts : Joi.string().optional().label("apprej_cmnts"),
  apprej_status: Joi.string().required().label("Approve_Reject Status"),
  aprg_hdrid: Joi.string().required().label("aprg_hdrid"),

}).options({ abortEarly: false });
// To exports the CmntsSenderid module
module.exports = CmntsSenderid

