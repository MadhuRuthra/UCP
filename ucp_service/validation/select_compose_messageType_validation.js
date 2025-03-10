/*
It is used to one of which is user input validation.
select_compose_messageType_validation function to validate the user.

Version : 1.0
Author : Madhubala (YJ0009)
Date : 05-Jul-2023
*/
// Import the required packages and libraries
const Joi = require("@hapi/joi");
// To declare select_compose_messageType_validation object
const select_compose_messageType_validation = Joi.object().keys({
  // Object Properties are define
 
  rights_name: Joi.string().required().label("rights_name"),
  //login_id: Joi.string().required().label("Login ID"),

}).options({ abortEarly: false });
// To exports the select_compose_messageType_validation module
module.exports = select_compose_messageType_validation