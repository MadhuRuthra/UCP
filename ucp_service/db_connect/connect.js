const mysql = require('mysql2/promise');
const main = require('./../logger');
require('dotenv').config();

const config = {
  db: {
    host: process.env.DB_HOST ,
    user: process.env.DB_USER ,
    password: process.env.DB_PASSWORD ,
    database: process.env.DB_NAME,
  },
  listPerPage: process.env.LIST_PER_PAGE || 10,
};

const pool = mysql.createPool(config.db);

var logger_all = main.logger_all;

async function query(sql, params) {
  logger_all.info("[SQL QUERY] : " + sql);

  try {
    const [rows] = await pool.execute(sql, params);
    logger_all.info("[SQL QUERY RESULT] : " + JSON.stringify(rows));
    return rows;
  } catch (error) {
    logger_all.error("[SQL QUERY ERROR] : " + error.message);
    console.error('Database Error:', error);
    throw error;
  }
}

module.exports = {
  query,
  config,
};
