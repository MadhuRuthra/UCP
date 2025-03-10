
// Import necessary modules and dependencies
const db = require("../../db_connect/connect");
require("dotenv").config();
const main = require('../../logger')

// ContentTemplateBusiness - start
async function ContentTemplateBusiness(req) {
    const logger_all = main.logger_all;
    const logger = main.logger;

    try {
        // Get the authorization header token
        const header_token = req.headers['authorization'];
        // Log the request body
        logger_all.info("[ContentTemplateBusiness] : " + JSON.stringify(req.body));

        // Execute the query
        const business_category = await db.query(`SELECT * FROM sender_business_category where business_category_status = 'Y' ORDER BY sender_buscategory_id Asc`);

        // Check if any rows are returned
        if (business_category.length === 0) {
            return {
                response_code: 0,
                response_status: 201,
                response_msg: 'No Data Available'
            };
        } else {
            // Return the data along with the success message
            return {
                response_code: 1,
                response_status: 200,
                response_msg: 'Success',
                result: business_category // include the query result here
            };
        }
    } catch (e) {
        // Log and return an error response in case of failure
        logger_all.info("[ContentTemplateBusiness failed response] : " + e);
        return {
            response_code: 0,
            response_status: 201,
            response_msg: 'Error occurred'
        };
    }
}
// ContentTemplateBusiness - end

// ContentTemplateHeaderSenderid - start
async function ContentTemplateHeaderSenderid(req) {
    const logger_all = main.logger_all;
    const logger = main.logger;

    try {
        // Get the authorization header token
        const header_token = req.headers['authorization'];
        const { user_id } = req.body;
        // Log the request body
        logger_all.info("[ContentTemplateHeaderSenderid] : " + JSON.stringify(req.body));

        // Execute the query
        const business_category = await db.query(`SELECT * FROM cm_senderid where sender_status = 'Y' and user_id = '${user_id}' and exist_new_senderid = 'N' ORDER BY sender_title Asc`);

        // Check if any rows are returned
        if (business_category.length === 0) {
            return {
                response_code: 0,
                response_status: 201,
                response_msg: 'No Data Available'
            };
        } else {
            // Return the data along with the success message
            return {
                response_code: 1,
                response_status: 200,
                response_msg: 'Success',
                result: business_category // include the query result here
            };
        }
    } catch (e) {
        // Log and return an error response in case of failure
        logger_all.info("[ failed response] : " + e);
        return {
            response_code: 0,
            response_status: 201,
            response_msg: 'Error occurred'
        };
    }
}
// ContentTemplateBusiness - end

// ContentTemplateHeaderSenderid - start
async function ConsentTmpl(req) {
    const logger_all = main.logger_all;
    const logger = main.logger;

    try {
        // Get the authorization header token
        const header_token = req.headers['authorization'];
        const { user_id } = req.body;
        // Log the request body
        logger_all.info("[ConsentTmpl] : " + JSON.stringify(req.body));
        // const select_ex_new_senderid = await db.query(`SELECT * FROM cm_senderid WHERE exist_new_senderid = 'N'`)
        // let exist_new_senderid = select_ex_new_senderid[0].exist_new_senderid;
        // Execute the query
        const business_category = await db.query(`SELECT cs.cm_sender_id, cs.user_id, cs.sender_operator, cs.sender_temptype, cs.sender_buscategory, cs.sender_title, cs.sender_explanation, cs.sender_documents, cs.sender_status, cs.sender_entrydate, cs.exist_new_senderid, cct.cm_consent_id, cct.cm_consent_tmplname, cct.cm_consent_brand, cct.cm_consent_msg, cct.cm_consent_docs, cct.cm_consent_status, cct.cm_consent_entrydt FROM cm_senderid cs JOIN cm_consent_template cct ON cs.cm_sender_id = cct.cm_sender_id WHERE cs.exist_new_senderid = 'N' AND cct.cm_consent_status = 'Y' AND cs.user_id = '${user_id}' ORDER BY cct.cm_consent_tmplname ASC;`);


        // Check if any rows are returned
        if (business_category.length === 0) {
            return {
                response_code: 0,
                response_status: 201,
                response_msg: 'No Data Available'
            };
        } else {
            // Return the data along with the success message
            return {
                response_code: 1,
                response_status: 200,
                response_msg: 'Success',
                result: business_category // include the query result here
            };
        }
    } catch (e) {
        // Log and return an error response in case of failure
        logger_all.info("[ConsentTmpl failed response] : " + e);
        return {
            response_code: 0,
            response_status: 201,
            response_msg: 'Error occurred'
        };
    }
}
// ContentTemplateBusiness - end

// ContentTemplateHeaderSenderid - start
async function consenttmpl_exists(req) {
    const logger_all = main.logger_all;
    const logger = main.logger;

    try {
        // Get the authorization header token
        const header_token = req.headers['authorization'];
        const { user_id } = req.body;
        // Log the request body
        logger_all.info("[consenttmpl_exists] : " + JSON.stringify(req.body));
        // const select_ex_new_senderid = await db.query(`SELECT * FROM cm_senderid WHERE exist_new_senderid = 'N'`)
        // let exist_new_senderid = select_ex_new_senderid[0].exist_new_senderid;
        // Execute the query
        const business_category = await db.query(`SELECT cs.cm_sender_id, cs.user_id, cs.sender_operator, cs.sender_temptype, cs.sender_buscategory, cs.sender_title, cs.sender_explanation, cs.sender_documents, cs.sender_status, cs.sender_entrydate, cs.exist_new_senderid, cct.cm_consent_id, cct.cm_consent_tmplname, cct.cm_consent_brand, cct.cm_consent_msg, cct.cm_consent_docs, cct.cm_consent_status, cct.cm_consent_entrydt FROM cm_senderid cs JOIN cm_consent_template cct ON cs.cm_sender_id = cct.cm_sender_id WHERE cs.exist_new_senderid = 'E' AND cct.cm_consent_status = 'Y' AND cs.user_id = '${user_id}' ORDER BY cct.cm_consent_tmplname ASC;`);


        // Check if any rows are returned
        if (business_category.length === 0) {
            return {
                response_code: 0,
                response_status: 201,
                response_msg: 'No Data Available'
            };
        } else {
            // Return the data along with the success message
            return {
                response_code: 1,
                response_status: 200,
                response_msg: 'Success',
                result: business_category // include the query result here
            };
        }
    } catch (e) {
        // Log and return an error response in case of failure
        logger_all.info("[consenttmpl_exists failed response] : " + e);
        return {
            response_code: 0,
            response_status: 201,
            response_msg: 'Error occurred'
        };
    }
}
// ContentTemplateBusiness - end

// content_template_headersenderid_exist - start
async function content_template_headersenderid_exist(req) {
    const logger_all = main.logger_all;
    const logger = main.logger;

    try {
        // Get the authorization header token
        const header_token = req.headers['authorization'];
        const { user_id } = req.body;
        // Log the request body
        logger_all.info("[content_template_headersenderid_exist] : " + JSON.stringify(req.body));

        // Execute the query
        const business_category = await db.query(`SELECT * FROM cm_senderid where sender_status = 'Y' and user_id = '${user_id}' and exist_new_senderid = 'E' ORDER BY sender_title Asc`);

        // Check if any rows are returned
        if (business_category.length === 0) {
            return {
                response_code: 0,
                response_status: 201,
                response_msg: 'No Data Available'
            };
        } else {
            // Return the data along with the success message
            return {
                response_code: 1,
                response_status: 200,
                response_msg: 'Success',
                result: business_category // include the query result here
            };
        }
    } catch (e) {
        // Log and return an error response in case of failure
        logger_all.info("[content_template_headersenderid_exist failed response] : " + e);
        return {
            response_code: 0,
            response_status: 201,
            response_msg: 'Error occurred'
        };
    }
}
// ContentTemplateBusiness - end


// dlt_list - start
async function dlt_list(req) {
    const logger_all = main.logger_all;
    const logger = main.logger;

    try {
        // Get the authorization header token
        const header_token = req.headers['authorization'];
        const { user_id } = req.body;
        // Log the request body
        logger_all.info("[dlt_list] : " + JSON.stringify(req.body));

        // Execute the query
        const business_category = await db.query(`SELECT * FROM cm_senderid snd LEFT JOIN user_management usr on snd.user_id = usr.user_id LEFT JOIN sms_route_master rut on rut.sms_route_id = snd.dlt_process LEFT JOIN sender_business_category cat on snd.sender_buscategory = cat.sender_buscategory_id where snd.user_id = '${user_id}' Order by snd.cm_sender_id desc`);

        // Check if any rows are returned
        if (business_category.length === 0) {
            return {
                response_code: 0,
                response_status: 201,
                response_msg: 'No Data Available'
            };
        } else {
            // Return the data along with the success message
            return {
                response_code: 1,
                response_status: 200,
                response_msg: 'Success',
                result: business_category // include the query result here
            };
        }
    } catch (e) {
        // Log and return an error response in case of failure
        logger_all.info("[dlt_list failed response] : " + e);
        return {
            response_code: 0,
            response_status: 201,
            response_msg: 'Error occurred'
        };
    }
}
// dlt_list - end

// dlt_consent_list - start
async function dlt_consent_list(req) {
    const logger_all = main.logger_all;
    const logger = main.logger;

    try {
        // Get the authorization header token
        const header_token = req.headers['authorization'];
        const { user_id } = req.body;
        // Log the request body
        logger_all.info("[dlt_consent_list] : " + JSON.stringify(req.body));

        // Execute the query
        const business_category = await db.query(`SELECT * FROM cm_consent_template tmp LEFT JOIN user_management usr on tmp.user_id = usr.user_id LEFT JOIN cm_senderid snd on snd.cm_sender_id = tmp.cm_sender_id where tmp.user_id = '${user_id}' Order by tmp.cm_consent_id desc`);

        // Check if any rows are returned
        if (business_category.length === 0) {
            return {
                response_code: 0,
                response_status: 201,
                response_msg: 'No Data Available'
            };
        } else {
            // Return the data along with the success message
            return {
                response_code: 1,
                response_status: 200,
                response_msg: 'Success',
                result: business_category // include the query result here
            };
        }
    } catch (e) {
        // Log and return an error response in case of failure
        logger_all.info("[dlt_consent_list failed response] : " + e);
        return {
            response_code: 0,
            response_status: 201,
            response_msg: 'Error occurred'
        };
    }
}
// dlt_consent_list - end

// dlt_content_list - start
async function dlt_content_list(req) {
    const logger_all = main.logger_all;
    const logger = main.logger;

    try {
        // Get the authorization header token
        const header_token = req.headers['authorization'];
        const { user_id } = req.body;
        // Log the request body
        logger_all.info("[dlt_content_list] : " + JSON.stringify(req.body));

        // Execute the query
        const business_category = await db.query(`SELECT * FROM cm_content_template ntmp LEFT JOIN user_management usr on ntmp.user_id = usr.user_id LEFT JOIN cm_senderid snd on snd.cm_sender_id = ntmp.cm_sender_id LEFT JOIN cm_consent_template tmp on tmp.cm_consent_id = ntmp.cm_consent_id LEFT JOIN sender_business_category cat on ntmp.cn_template_buscategory = cat.sender_buscategory_id where ntmp.user_id = '${user_id}' Order by ntmp.cm_content_tmplid desc`);

        // Check if any rows are returned
        if (business_category.length === 0) {
            return {
                response_code: 0,
                response_status: 201,
                response_msg: 'No Data Available'
            };
        } else {
            // Return the data along with the success message
            return {
                response_code: 1,
                response_status: 200,
                response_msg: 'Success',
                result: business_category // include the query result here
            };
        }
    } catch (e) {
        // Log and return an error response in case of failure
        logger_all.info("[dlt_content_list failed response] : " + e);
        return {
            response_code: 0,
            response_status: 201,
            response_msg: 'Error occurred'
        };
    }
}
// dlt_consent_list - end

// select_compose_messageType - start
async function select_compose_messageType(req) {
    const logger_all = main.logger_all;
    const logger = main.logger;

    try {
        // Get the authorization header token
        const header_token = req.headers['authorization'];
        const { user_id, rights_name } = req.body;
        // Log the request body
        logger_all.info("[select_compose_messageType] : " + JSON.stringify(req.body));
const select_smpp = await db.query(`SELECT * FROM rights_master WHERE rights_name = '${rights_name}'`);
let rights_id = select_smpp[0].rights_id;
        // Execute the query
        const business_category = await db.query(`SELECT smsrt.sms_route_title,smsrt.sms_route_id,
    smsrt.sms_route_desc,
    (SELECT mcl.available_messages
     FROM message_limit mcl 
     WHERE mcl.user_id = '${user_id}'
       AND mcl.rights_id = ${rights_id}) AS available_messages
    FROM 
    sms_route_master smsrt
    WHERE 
    smsrt.sms_route_status = 'Y';`);

        // Check if any rows are returned
        if (business_category.length === 0) {
            return {
                response_code: 0,
                response_status: 201,
                response_msg: 'No Data Available'
            };
        } else {
            // Return the data along with the success message
            return {
                response_code: 1,
                response_status: 200,
                response_msg: 'Success',
                result: business_category // include the query result here
            };
        }
    } catch (e) {
        // Log and return an error response in case of failure
        logger_all.info("[select_compose_messageType failed response] : " + e);
        return {
            response_code: 0,
            response_status: 201,
            response_msg: 'Error occurred'
        };
    }
}
// select_compose_messageType - end

// compose_headersender - start
async function compose_headersender(req) {
    const logger_all = main.logger_all;
    const logger = main.logger;

    try {
        // Get the authorization header token
        const header_token = req.headers['authorization'];
        const { user_id } = req.body;
        // Log the request body
        logger_all.info("[compose_headersender] : " + JSON.stringify(req.body));

        // Execute the query
        const business_category = await db.query(`SELECT * FROM cm_senderid where sender_status = 'Y' and user_id = '${user_id}' ORDER BY sender_title Asc`);

        // Check if any rows are returned
        if (business_category.length === 0) {
            return {
                response_code: 0,
                response_status: 201,
                response_msg: 'No Data Available'
            };
        } else {
            // Return the data along with the success message
            return {
                response_code: 1,
                response_status: 200,
                response_msg: 'Success',
                result: business_category // include the query result here
            };
        }
    } catch (e) {
        // Log and return an error response in case of failure
        logger_all.info("[compose_headersender failed response] : " + e);
        return {
            response_code: 0,
            response_status: 201,
            response_msg: 'Error occurred'
        };
    }
}
// compose_headersender - end


// get_content_tmpl - start
async function get_content_tmpl(req) {
    const logger_all = main.logger_all;
    const logger = main.logger;

    try {
        // Get the authorization header token
        const header_token = req.headers['authorization'];
        const { user_id, selectedValue_tmplname } = req.body;
        // Log the request body
        logger_all.info("[get_content_tmpl] : " + JSON.stringify(req.body));

        // Execute the query
        const business_category = await db.query(`SELECT * FROM cm_content_template WHERE cn_status = 'Y' AND cm_sender_id = '${selectedValue_tmplname}' AND user_id = '${user_id}' ORDER BY cn_template_name ASC`);

        // Check if any rows are returned
        if (business_category.length === 0) {
            return {
                response_code: 0,
                response_status: 201,
                response_msg: 'No Data Available'
            };
        } else {
            // Return the data along with the success message
            return {
                response_code: 1,
                response_status: 200,
                response_msg: 'Success',
                result: business_category // include the query result here
            };
        }
    } catch (e) {
        // Log and return an error response in case of failure
        logger_all.info("[get_content_tmpl failed response] : " + e);
        return {
            response_code: 0,
            response_status: 201,
            response_msg: 'Error occurred'
        };
    }
}
// get_content_tmpl - end

// using for module exporting
module.exports = {
    ContentTemplateBusiness,
    ContentTemplateHeaderSenderid,
    ConsentTmpl,
    consenttmpl_exists,
    content_template_headersenderid_exist,
    dlt_list,
    dlt_consent_list,
    dlt_content_list,
    select_compose_messageType,
    compose_headersender,
    get_content_tmpl

}
