   /*
It is used to one of which is user input validation.
CmntsSenderid function to validate the user.

Version : 1.0
Author : Madhubala (YJ0009)
Date : 05-Jul-2023
*/
// Import the optional packages and libraries
const Joi = require("@hapi/joi");
// To declare CmntsSenderid object 
const CmntsConsentid = Joi.object().keys({
  // Object Properties are define  
  user_id: Joi.string().optional().label("User Id"),
  contentid: Joi.string().optional().label("Content ID"),
  apprej_cmnts : Joi.string().optional().label("Approve Reject Comments"),
  apprej_status: Joi.string().optional().label("Approve_Reject Status"),
  aprg_cmstid: Joi.string().optional().label("aprg_cmstid"),
}).options({ abortEarly: false });
// To exports the CmntsSenderid module
module.exports = CmntsConsentid

