/*
It is used to one of which is user input validation.
ChangePassword function to validate the user.

Version : 1.0
Author : Madhubala (YJ0009)
Date : 05-Jul-2023
*/
// Import the required packages and libraries
const Joi = require("@hapi/joi");
// To declare ChangePassword object
const GenerateReport = Joi.object().keys({
  // Object Properties are define
  user_id: Joi.string().optional().label("User Id"),
  rights_name: Joi.string().optional().label("Rights Name")
}).options({ abortEarly: false });
// To exports the ChangePassword module
module.exports = GenerateReport