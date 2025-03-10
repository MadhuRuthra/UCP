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
const CmntsConsentid = Joi.object().keys({
  // Object Properties are define  
  /* $replace_txt = '{
    "user_id" : "' . $_SESSION['yjucp_user_id'] . '",
    "consentid" : "' . $senconsentiderid . '",
     "apprej_status" : "' . $apprej_status . '",
     "apprej_cmnts" : "' . $apprej_cmnts . '"
}'; */
  user_id: Joi.string().optional().label("User Id"),
  consentid: Joi.string().required().label("Consent ID"),
  apprej_cmnts : Joi.string().optional().label("Approve Reject Comments"),
  apprej_status: Joi.string().required().label("Approve_Reject Status")

}).options({ abortEarly: false });
// To exports the CmntsSenderid module
module.exports = CmntsConsentid

