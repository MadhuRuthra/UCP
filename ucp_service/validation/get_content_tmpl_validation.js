const Joi = require('@hapi/joi');

const get_content_tmpl_validation = Joi.object().keys({
  selectedValue_tmplname: Joi.string().optional().label("Select Template ID")
}).options({ abortEarly: false });

module.exports = get_content_tmpl_validation

