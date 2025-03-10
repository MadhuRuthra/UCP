/*It is used to one of which is user input validation.
Viewuser function to validate the user.

Version : 1.0
Author : Sabena Yasmin (YJ0008)
Date : 04-Nov-2023
*/
// Import the required packages and libraries
const Joi = require("@hapi/joi");
// To declare Viewuser object
const Viewuser = Joi.object().keys({
  // Object Properties are define
  user_id: Joi.string().optional().label("User ID"),
  rights_name: Joi.string().optional().label("Rights Name")
}).options({ abortEarly: false });
// To exports the Viewuser module
module.exports = Viewuser