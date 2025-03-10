/*
It is used to one of which is user input validation.
SendMessage function to validate the user.

Version : 1.0
Author : Madhubala (YJ0009)
Date : 05-Jul-2023
*/
// Import the required packages and libraries
const Joi = require("@hapi/joi");
// To declare SendMessage object
const SendMessage = Joi.object().keys({
  // Object Properties are define  
  receiver_nos_path: Joi.string().optional().label("File Location"),
  request_id: Joi.string().required().label("Request ID"),
  total_mobile_count: Joi.string().optional().label("total_mobile_count"),
  messages: Joi.string().required().label("message"),
  character_count: Joi.string().required().label("character_count"),
  user_id: Joi.string().optional().label("User Id"),
  message_type: Joi.string().required().label("message_type"),
  rights_name: Joi.string().required().label('Rights Name'),
  group_id: Joi.string().optional().label('Group id'),
}).options({ abortEarly: false });
// To exports the SendMessage module
module.exports = SendMessage
