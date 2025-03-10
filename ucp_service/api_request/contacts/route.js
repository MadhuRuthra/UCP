/*
Routes are used in direct incoming API requests to backend resources.
It defines how our application should handle all the HTTP requests by the client.
This page is used to routing the product menu.

Version : 1.0
Author : Selvalakshmi N (YJ0018)
Date : 03-DEC-2024
*/

const express = require("express");
const router = express.Router();
require("dotenv").config();
const validator = require('../../validation/middleware')
const valid_user = require("../../validation/valid_user_middleware");

const AddContacts = require("./add_contacts");
const AddGroup = require("./add_group");
const Group_List = require("./group_list");
const ViewGroup = require("./view_group");
const Contact_List = require("./contact_list");
const ViewContact = require("./view_contacts");
const ManagePlans = require("./create_plans");
const ViewPlan = require("./view_plans");
const CampaignListValidation = require("../../validation/menu_list_validation");

const main = require('../../logger');

router.post(
  "/add_contacts",
  valid_user,
  async function (req, res, next) {
    try {
      const logger = main.logger

      const result = await AddContacts.Add_Contact(req);

      logger.info("[API RESPONSE] " + JSON.stringify(result))

      res.json(result);

    } catch (err) {
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);

// Start route to retrieve the Add_Group
router.post(
  "/add_group",
  // validator.body(CampaignListValidation),
  valid_user,
  async function (req, res, next) {
    try {
      const logger = main.logger

      // Call the product_header function to fetch the user's Add_Group
      const result = await AddGroup.Add_Group(req);

      logger.info("[API RESPONSE - Add_Group] " + JSON.stringify(result))

      res.json(result);

    } catch (err) {
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// End route to retrieve the Add_Group

// Start route to retrieve the GroupList
router.get(
  "/group_list",
  // validator.body(CampaignListValidation),
  valid_user,
  async function (req, res, next) {
    try {
      const logger = main.logger

      // Call the product_header function to fetch the user's Group_List
      const result = await Group_List.GroupList(req);

      logger.info("[API RESPONSE - Group_List] " + JSON.stringify(result))

      res.json(result);

    } catch (err) {
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// End route to retrieve the Group_List

// Start route to retrieve the GroupList
router.get(
  "/contact_list",
  // validator.body(CampaignListValidation),
  valid_user,
  async function (req, res, next) {
    try {
      const logger = main.logger

      // Call the product_header function to fetch the user's ContactList
      const result = await Contact_List.ContactList(req);

      logger.info("[API RESPONSE - ContactList] " + JSON.stringify(result))

      res.json(result);

    } catch (err) {
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// End route to retrieve the Group_List


// Start route to retrieve the GroupList
router.get(
  "/view_group",
  // validator.body(CampaignListValidation),
  valid_user,
  async function (req, res, next) {
    try {
      const logger = main.logger

      // Call the product_header function to fetch the user's Group_List
      const result = await ViewGroup.View_Group(req);

      logger.info("[API RESPONSE - Group_List] " + JSON.stringify(result))

      res.json(result);

    } catch (err) {
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// End route to retrieve the Group_List

// Start route to retrieve the ViewContact
router.get(
  "/view_contact",
  // validator.body(CampaignListValidation),
  valid_user,
  async function (req, res, next) {
    try {
      const logger = main.logger

      // Call the product_header function to fetch the user's ViewContact
      const result = await ViewContact.View_Contact(req);

      logger.info("[API RESPONSE - ViewContact] " + JSON.stringify(result))

      res.json(result);

    } catch (err) {
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// End route to retrieve the ViewContact
// Create plans -Start
router.post(
  "/create_plans",
  valid_user,
  async function (req, res, next) {
    try {
      const logger = main.logger

      const result = await ManagePlans.Manage_Plans(req);

      logger.info("[API RESPONSE] " + JSON.stringify(result))

      res.json(result);

    } catch (err) {
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// Create plans - End


// Start route to retrieve the Plans 
router.get(
  "/view_plans",
  // validator.body(CampaignListValidation),
  valid_user,
  async function (req, res, next) {
    try {
      const logger = main.logger

      // Call the product_header function to fetch the user's Group_List
      const result = await ViewPlan.View_Plans(req);

      logger.info("[API RESPONSE - Plan_List] " + JSON.stringify(result))

      res.json(result);

    } catch (err) {
      console.error(`Error while getting data`, err.message);
      next(err);
    }
  }
);
// End route to retrieve the Plan_List

module.exports = router;
