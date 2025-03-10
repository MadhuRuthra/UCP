/*
API that allows your frontend to communicate with your backend server (Node.js) for processing and retrieving data.
To access a MySQL database with Node.js and can be use it.
This API is used in product menu functions which is used to list product menu & header.

Version : 1.0
Author : Selvalakshmi N (YJ0018)
Date : 03-DEC-2024
*/

const db = require("../../db_connect/connect");
require("dotenv").config();
const main = require('../../logger')
const fs = require('fs');
const csv = require('csv-parser');
const path = require('path');

async function Add_Contact(req) {
	const logger_all = main.logger_all;
	const logger = main.logger;

	try {
		// Validate req.body
		if (!req.body || typeof req.body !== "object") {
			throw new Error("Invalid request body");
		}

		const { user_id, group_id, contact_no, contact_name, contact_email, contact_operator, contact_status, contact_id ,import_file,total_mobile_count} = req.body;

		const valid_mobile_numbers = [], push_name_and_values = [];
          let inserted_ids = [],insert_count = 1;
		logger_all.info("[Add_Contact query parameters]: " + JSON.stringify(req.body));

		if (contact_id) {
			const updateQuery = `UPDATE contact_management SET contact_status = ?, contact_name = ?, contact_email = ?,contact_operator = ?,contact_status = ? WHERE contact_mgtgrp_id = ? and user_id = ? and contact_mgt_id = ? `;
			const updateResult = await db.query(updateQuery, [contact_status, contact_name, contact_email, contact_operator, contact_status, group_id, user_id, contact_id]);

			if (updateResult.affectedRows) {
				return { response_code: 1, response_status: 200, response_msg: "Success" };
			} else {
				return { response_code: 0, response_status: 204, response_msg: "No data available" };
			}
		} else if(import_file){


      // Fetch the CSV file
      await fs.createReadStream(import_file)

        // Read the CSV file from the stream
        .pipe(csv({
          headers: false
        }))

        // Set headers to false since there are no column headers
        .on('data', (row) => {
          if (Object.values(row).every(value => value === '')) {
            return;
          }

          const firstColumnValue = row[0].trim();
          const name = row[1] ? row[1].trim() : '';
          valid_mobile_numbers.push(firstColumnValue)
          //push_name.push(name)
          const otherValues = [];
          for (let i = 1; i < Object.keys(row).length; i++) { // Start from 2 to skip mobile number and name
            if (row[i]) {
              otherValues.push(row[i].trim());
            }
          }
          push_name_and_values.push([...otherValues]);

        })
        .on('error', (error) => {
          console.error('Error:', error.message);
        })
        .on('end', async () => {
          logger_all.info(valid_mobile_numbers)
          //Insert compose details to compose_msg_status table
          let insert_numbers = ""
          insert_numbers = `INSERT INTO contact_management VALUES`;
          let insertId;
          //Loop for receiver numbers
          if (valid_mobile_numbers.length === 0) {
            logger_all.info("[API RESPONSE] " + JSON.stringify({ response_code: 0, response_status: 201, response_msg: 'Failed', request_id: request_id }))
            return res.json({ response_code: 0, response_status: 201, response_msg: 'Failed', request_id: request_id });
          }


          for (let k = 0; k < valid_mobile_numbers.length; k) {

            if (k == valid_mobile_numbers.length) {
              break;
            }
            //Insert compose data
            insert_numbers = insert_numbers + "" + `(NULL,'${group_id}','${valid_mobile_numbers[k]}','-','-','-','Y',CURRENT_TIMESTAMP,'${user_id}'),`;

            //check if insert_count is 1000, insert 1000 splits data
            // If batch size is 1000, execute the insert query
            if (insert_count === 1000) {
              insert_numbers = insert_numbers.slice(0, -1); // Remove trailing comma
              let insert_numbers_result = await db.query(insert_numbers);

              let first_insert_id = insert_numbers_result.insertId; // First inserted ID

              // Log the correct number of inserted IDs
              for (let j = 0; j < 1000; j++) {
                let current_id = first_insert_id + j;
                inserted_ids.push(current_id);
                logger_all.info(`Inserted ID: ${current_id}`);
              }

              // Reset for the next batch
              insert_count = 0;
              insert_numbers = `INSERT INTO contact_management VALUES`;
            }
            insert_count = insert_count + 1;
            k++;
          }

          //After the loops complete, this if statement checks if any pending insert queries are left to be executed. If so, it executes
          if (insert_numbers !== `INSERT INTO contact_management VALUES`) {
            insert_numbers = insert_numbers.slice(0, -1); // Remove trailing comma
            let insert_numbers_result = await db.query(insert_numbers);

            let first_insert_id = insert_numbers_result.insertId; // First inserted row ID
            let affectedRows = insert_numbers_result.affectedRows
            // Log only the remaining inserted IDs
            for (let j = 0; j < affectedRows; j++) {
              let current_id = first_insert_id + j;
              inserted_ids.push(current_id);
              logger_all.info(`Inserted ID: ${current_id}`);
            }
            insertId = insert_numbers_result.insertId;
          }

          logger_all.info(`Total Inserted IDs: ${JSON.stringify(inserted_ids)}`);

		});
		}else {
			const checkQuery = `SELECT * FROM contact_management WHERE contact_mgtgrp_id = ? AND user_id = ? `;
			const [existingGroup] = await db.query(checkQuery, [group_id, user_id]);

			if (existingGroup?.length > 0) {
				return { response_code: 1, response_status: 204, response_msg: "This title is already used. Please try another." };
			}

			const insertQuery = `INSERT INTO contact_management VALUES (NULL, ?, ?, ?,?,?,?, CURRENT_TIMESTAMP, ?)`;
			const insertResult = await db.query(insertQuery, [group_id, contact_no, contact_name, contact_email, contact_operator, contact_status, user_id]);

			if (insertResult.affectedRows) {
				return { response_code: 1, response_status: 200, response_msg: "Success" };
			} else {
				return { response_code: 0, response_status: 204, response_msg: "No data available" };
			}
		}
		if (inserted_ids) {
			return { response_code: 1, response_status: 200, response_msg: "Success" };
		} else {
			return { response_code: 0, response_status: 204, response_msg: "No data available" };
		}
	} catch (error) {
		logger_all.error("[Add_Contact failed response]: " + error.message);
		return { response_code: 0, response_status: 500, response_msg: "An error occurred." };
	}
}

module.exports = {
	Add_Contact,
};
