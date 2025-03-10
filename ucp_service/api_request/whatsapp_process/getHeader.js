// Import the required packages and libraries
const fs = require('fs');
var axios = require('axios');
const env = process.env;
const api_url = env.API_URL;
const app_id = env.APP_ID;
const MEDIA_URL = env.MEDIA_URL;
const media_bearer = env.MEDIA_BEARER;
var util = require('util');
const main = require('../../logger');

async function getHeaderFile(media_file) {
    var logger = main.logger;
    var logger_all = main.logger_all;

    // Get current date 
    var day = new Date();
    // Declare the array
    var header_value = [];
    // Declare the variables
    let media_name;
    var config = {
        method: 'get',
        url: media_file,
        headers: {},
        responseType: 'arraybuffer'
    };

    try {
        const response = await axios(config);

        // Response header request
        logger_all.info("[get session request] : " + JSON.stringify(response.headers));

        // Upload the header media option
        var media_type = response.headers['content-type'].split("/");
        media_name = `upload_${day.getDate()}${day.getHours()}${day.getMinutes()}${day.getSeconds()}_${response.headers['content-length']}.${media_type[1]}`;

        fs.writeFileSync(media_name, response.data); // Save the file synchronously

        logger_all.info("[upload image success response] : file written in - " + media_name);

        // Get session variable declaration
        var get_session = {
            method: 'post',
            url: `${api_url}${app_id}/uploads`,
            params: {
                file_length: response.headers['content-length'],
                file_type: response.headers['content-type'],
                access_token: media_bearer,
            }
        };


        logger_all.info("[get session request] : " + JSON.stringify(get_session));

        // Get session with to send the response 
        const uploadResponse = await axios(get_session);
        logger_all.info("[get session response] : " + util.inspect(uploadResponse.data));

        header_value.push(uploadResponse.data.id);
        header_value.push(media_name);
        if (media_type[0] == 'image') {
            header_value.push('IMAGE');
        } else if (media_type[0] == 'video') {
            header_value.push('VIDEO');
        } else {
            header_value.push('DOCUMENT');
        }

        return header_value; // Return the header value when all operations succeed
    } catch (error) {
        logger_all.error("[Error] : " + error.message);

        // Ensure cleanup on error
        if (media_name && fs.existsSync(media_name)) {
            fs.unlinkSync(media_name);
        }

        // Return null or some error message
        return null;
    }
}

// Module export
module.exports = {
    getHeaderFile,
};
