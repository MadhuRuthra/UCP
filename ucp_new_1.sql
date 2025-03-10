-- phpMyAdmin SQL Dump
-- version 5.2.1-1.el9
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 03, 2025 at 04:54 AM
-- Server version: 8.0.40
-- PHP Version: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ucp_new_1`
--

-- --------------------------------------------------------

--
-- Table structure for table `compose_smpp_status_1`
--

CREATE TABLE `compose_smpp_status_1` (
  `comsmpp_status_id` bigint NOT NULL,
  `compose_smpp_id` int NOT NULL,
  `mobile_no` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `smpp_content` varchar(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `mobileno_valid` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `comsmpp_status` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `comsmpp_entry_date` timestamp NULL DEFAULT NULL,
  `comsmpp_sent_date` timestamp NULL DEFAULT NULL,
  `smpp_comments` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `delivery_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `compose_smpp_status_1`
--

INSERT INTO `compose_smpp_status_1` (`comsmpp_status_id`, `compose_smpp_id`, `mobile_no`, `smpp_content`, `mobileno_valid`, `comsmpp_status`, `comsmpp_entry_date`, `comsmpp_sent_date`, `smpp_comments`, `delivery_date`) VALUES
(1, 1, '919890398903', 'Dear_coustomer', 'V', 'N', '2025-01-02 11:09:10', NULL, NULL, NULL),
(2, 1, '919890312345', 'Dear_coustomer', 'V', 'N', '2025-01-02 11:09:10', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `compose_ucp_status_1`
--

CREATE TABLE `compose_ucp_status_1` (
  `comsms_status_id` bigint NOT NULL,
  `compose_sms_id` int NOT NULL,
  `mobile_no` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sms_content` varchar(2000) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `mobileno_valid` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `comsms_status` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `comsms_entry_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comsms_sent_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `sms_comments` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `delivery_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compose_ucp_status_1`
--

INSERT INTO `compose_ucp_status_1` (`comsms_status_id`, `compose_sms_id`, `mobile_no`, `sms_content`, `mobileno_valid`, `comsms_status`, `comsms_entry_date`, `comsms_sent_date`, `sms_comments`, `delivery_date`) VALUES
(1, 29, '918838964597', 'dksdnksdks', 'V', 'Q', '2025-01-29 13:04:22', NULL, 'SMS IN QUEUE', NULL),
(2, 28, '9834759874', 'knskndks', 'V', 'Q', '2025-01-29 13:04:42', NULL, 'SMS IN QUEUE', NULL),
(3, 27, '919890398903', 'knksnsskd', 'V', 'Q', '2025-01-29 13:04:49', NULL, 'SMS IN QUEUE', NULL),
(4, 27, '919890312345', 'knksnsskd', 'V', 'Q', '2025-01-29 13:04:49', NULL, 'SMS IN QUEUE', NULL),
(5, 26, '9834759874', 'skdksdskds', 'V', 'Q', '2025-01-29 13:04:55', NULL, 'SMS IN QUEUE', NULL),
(6, 25, '919890398903', 'skdnskndsk', 'V', 'Q', '2025-01-29 13:05:01', NULL, 'SMS IN QUEUE', NULL),
(7, 25, '919890312345', 'skdnskndsk', 'V', 'Q', '2025-01-29 13:05:01', NULL, 'SMS IN QUEUE', NULL),
(8, 24, '9834759874', 'skdnsk', 'V', 'Q', '2025-01-29 13:05:08', NULL, 'SMS IN QUEUE', NULL),
(9, 23, '919890398903', 'heloo', 'V', 'Q', '2025-01-29 13:05:16', NULL, 'SMS IN QUEUE', NULL),
(10, 23, '919890312345', 'heloo', 'V', 'Q', '2025-01-29 13:05:16', NULL, 'SMS IN QUEUE', NULL),
(11, 22, '919890398903', 'nknknsksdknsk', 'V', 'Q', '2025-01-29 13:05:21', NULL, 'SMS IN QUEUE', NULL),
(12, 22, '919890312345', 'nknknsksdknsk', 'V', 'Q', '2025-01-29 13:05:21', NULL, 'SMS IN QUEUE', NULL),
(13, 1, '919890398903', 'hello', 'V', 'Q', '2025-01-30 12:50:27', NULL, 'SMS IN QUEUE', NULL),
(14, 1, '919890312345', 'hello', 'V', 'Q', '2025-01-30 12:50:27', NULL, 'SMS IN QUEUE', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `compose_whatsapp_status_tmpl_1`
--

CREATE TABLE `compose_whatsapp_status_tmpl_1` (
  `comwtap_status_id` int NOT NULL,
  `compose_whatsapp_id` int NOT NULL,
  `mobile_no` varchar(13) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `comments` varchar(100) NOT NULL,
  `comwtap_status` char(1) NOT NULL,
  `comwtap_entry_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `response_status` char(1) DEFAULT NULL,
  `response_message` varchar(100) DEFAULT NULL,
  `response_id` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `response_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `delivery_status` char(1) DEFAULT NULL,
  `delivery_date` timestamp NULL DEFAULT NULL,
  `read_date` timestamp NULL DEFAULT NULL,
  `read_status` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `compose_smpp_status_1`
--
ALTER TABLE `compose_smpp_status_1`
  ADD PRIMARY KEY (`comsmpp_status_id`),
  ADD KEY `compose_smpp_id` (`compose_smpp_id`),
  ADD KEY `mobile_no` (`mobile_no`);

--
-- Indexes for table `compose_ucp_status_1`
--
ALTER TABLE `compose_ucp_status_1`
  ADD PRIMARY KEY (`comsms_status_id`),
  ADD KEY `comsms_status_id` (`comsms_status_id`,`compose_sms_id`);

--
-- Indexes for table `compose_whatsapp_status_tmpl_1`
--
ALTER TABLE `compose_whatsapp_status_tmpl_1`
  ADD PRIMARY KEY (`comwtap_status_id`),
  ADD KEY `compose_whatsapp_id` (`compose_whatsapp_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `compose_smpp_status_1`
--
ALTER TABLE `compose_smpp_status_1`
  MODIFY `comsmpp_status_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `compose_ucp_status_1`
--
ALTER TABLE `compose_ucp_status_1`
  MODIFY `comsms_status_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `compose_whatsapp_status_tmpl_1`
--
ALTER TABLE `compose_whatsapp_status_tmpl_1`
  MODIFY `comwtap_status_id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
