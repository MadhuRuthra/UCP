/*  {
  receiver_nos_path: '/var/www/html/ucp/uploads/compose_variables/1_file_1731915325835.csv',
  messages: 'Welcome',
  character_count: '7',
  request_id: '1_2024322130533_6811',
  total_mobile_count: '2',
  rights_name: 'SMPP',
  header: '4',
  txt_sms_type: 'unicode'
}*/
const Joi = require('@hapi/joi');

const compose_smpp_validation = Joi.object().keys({
    receiver_nos_path: Joi.string().optional().label("receiver_nos_path"),
    messages: Joi.string().optional().label("messages"),
    character_count: Joi.string().optional().label("character_count"),
    total_mobile_count: Joi.string().optional().label("total_mobile_count"),
    request_id: Joi.string().optional().label("request_id"),
    rights_name: Joi.string().optional().label("rights_name"),
    txt_sms_type: Joi.string().optional().label("txt_sms_type"),
    header: Joi.string().optional().label("header"),
    templateName: Joi.string().optional().label("templateName"),
}).options({ abortEarly: false });

module.exports = compose_smpp_validation
 
