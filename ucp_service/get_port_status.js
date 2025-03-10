// get_port_status.js
const axios = require('axios');
const dotenv = require('dotenv');
const logger_all = require('./logger.js');
const util = require('util');

dotenv.config();

const env = process.env;
const sendUser = env.sendUser;
const sendPassword = env.sendPassword;
const getPortStatus = env.getPortStatus;
const No_Of_port = env.No_Of_port;

const getPortStatusData = async () => {
  const data_getPortStatus = JSON.stringify({
    user: sendUser,
    password: sendPassword,
    port: No_Of_port,
  });

  const config_getPortStatus = {
    method: 'post',
    maxBodyLength: Infinity,
    url: getPortStatus,
    headers: {
      'Content-Type': 'application/json',
    },
    data: data_getPortStatus,
  };

  try {
    const response = await axios.request(config_getPortStatus);
    const responseData = response.data;
    console.log("Response Data:", responseData);
    logger_all.info("Response Data: " + JSON.stringify(responseData));

    const simStatus = responseData.simStatus;

    // Count the entries with "insert": 1
    const insertedCount = simStatus.filter((sim) => sim.insert === 1).length;

    console.log(`Number of SIMs with "insert": 1 is: ${insertedCount}`);
    logger_all.info(`Number of SIMs with "insert": 1 is: ${insertedCount}`);

    //const batchSize = insertedCount * 2;

    return { insertedCount }; // Return the values
  } catch (error) {
    console.error("Error in API call:", util.inspect(error, { depth: null, colors: true }));
    throw new Error('Failed to fetch port status');
  }
};

module.exports = getPortStatusData;
