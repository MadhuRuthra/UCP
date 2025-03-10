/*
API that allows your frontend to communicate with your backend server (Node.js) for processing and retrieving data.
To access a MySQL database with Node.js and can be use it.
This is a main page for starting API the process.This page to routing the subpages page and then process are executed.

Version : 1.0
Author : Sabena yasmin P(YJ0008)
Date : 23-Sep-2023
*/

// Import the required packages and libraries
const express = require("express");
const dotenv = require('dotenv');
const axios = require('axios');
const cron = require('node-cron'); 
var cors = require("cors");
const db = require('./db_connect/connect');
const { logger, logger_all } = require('./logger');
const env = process.env;
dotenv.config();
require("dotenv").config();
const DB_NAME = env.DB_NAME;
const API_URL = env.API_URL;
const bodyParser = require('body-parser');
const fs = require('fs');

// Database Connections
const app = express();
const port = env.PORT;


// Process Validations
const MobileLogin = require("./mobile_login/route");
const Login = require("./login/route");
const Logout = require("./logout/route");
const list = require("./api_request/list/route");
const cron_msg = require("./api_request/cron_msg/route");
const report = require("./api_request/report/report_route");
const Site_Menu = require("./api_request/site_menu/route");
const Purchasecredit = require("./api_request/purchase_credits/route");
const Composesms = require("./api_request/compose_sms/route");
const Composesmpp = require("./api_request/compose_smpp/route");
const DashboardAPI = require("./api_request/dashboard/route");
const template = require("./api_request/template/route");
const Message = require("./api_request/send_messages/send_message_route");
const WhatsappProcess = require("./api_request/whatsapp_process/route");
const SenderId = require("./api_request/sender_id/sender_id_route");
const ComposeWhatsapp = require("./api_request/compose_whatsapp/route");
const Contacts = require("./api_request/contacts/route");
var client_data;
// CORS configuration to allow both yejejai.in and the IP address
app.use(cors({
    origin: ['http://yeejai.in', 'http://192.168.29.244'] // Allow multiple origins
}));

// Express configuration
app.use(express.json({ limit: '500mb' }));
app.use(express.urlencoded({
    extended: true,
    limit: '500mb'
}));

app.get("/", (req, res) => {
    res.json({ message: "success" });
});

// Create the HTTP server (not HTTPS)
const httpServer = require('http').createServer(app);
/*const io = require('socket.io')(httpServer, {
    cors: {
        origin: "*",
    },
});*/
const io = require('socket.io')(httpServer, {
  cors: {
    origin: "*",  // This allows all origins; you can specify specific origins instead
    methods: ["GET", "POST"],
    allowedHeaders: ["Content-Type"],
    credentials: true
  }
});

// Allows you to send emits from express
app.use(function (request, response, next) {
    request.io = io;
    next();
});

// API routes for webhook function
app.get('/webhook', function (req, res) {
    if (req.query['hub.mode'] == 'subscribe' && req.query['hub.verify_token'] == 'yeejai123') {
        res.send(req.query['hub.challenge']);
    } else {
        res.sendStatus(400);
    }
});

// Parse application/x-www-form-urlencoded
app.use(bodyParser.urlencoded({ extended: false }));
// Parse application/json
app.use(bodyParser.json());

// API initialization
app.use("/login", Login);
app.use("/contacts", Contacts);
app.use("/", Composesms);
app.use("/", Composesmpp);
app.use("/mobile_login", MobileLogin);
app.use("/logout", Logout);
app.use("/dashboard", DashboardAPI);
app.use("/list", list);
app.use("/report", report);
app.use("/purchase_credit", Purchasecredit);
app.use("/site_menu", Site_Menu);
app.use("/template", template);
app.use("/sender_id", SenderId);
app.use("/whsp_process", WhatsappProcess);
app.use("/", ComposeWhatsapp);
app.use("/message", Message);

// Schedule a cron job to run every 5 seconds
// cron.schedule('*/5 * * * * *', async () => {
//         logger_all.info("Cron Running");
      
//         try {
//           logger_all.info("Calling cron send msg every 5 seconds");
//           await cron_msg(); // Ensure cron_msg() is async if it returns a promise
//         } catch (error) {
//           logger_all.error("Error in cron job:", error);
//           console.error("Error in cron job:", error);
//         }
//       });
      

// Listen for connections at the /ucp_whatsapp/ namespace
const whatsappNamespace = io.of('/ucp_whatsapp');

whatsappNamespace.on('connection', (socket) => {
    console.log('User connected to /ucp_whatsapp/ namespace');
    socket.on('disconnect', () => {
        console.log('User disconnected from /ucp_whatsapp/ namespace');
    });
});

// Start the HTTP server and listen on the port
// httpServer.listen(port, () => {
//     logger.info(`App started listening at http://yeejai.in:${port}`);
// });

httpServer.listen(port, () => {
        logger.info(`App started listening at http://localhost:${port}`);
    });
    

module.exports = client_data;
