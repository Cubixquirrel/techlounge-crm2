-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 21, 2020 at 07:34 AM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `techlounge_crm2`
--

-- --------------------------------------------------------

--
-- Table structure for table `business`
--

CREATE TABLE `business` (
  `id` int(11) NOT NULL,
  `business_name` varchar(100) NOT NULL,
  `stage` varchar(100) NOT NULL,
  `stage_order` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `business`
--

INSERT INTO `business` (`id`, `business_name`, `stage`, `stage_order`) VALUES
(1, 'MSME', 'Temporarily Pending', '2'),
(2, 'MSME', 'OTP Not Given', '3'),
(3, 'MSME', 'Aadhaar Issue', '4'),
(4, 'MSME', 'DNF', '5'),
(5, 'MSME', 'Number Delivered', '6'),
(6, 'MSME', 'Certificate Delivered', '7'),
(7, 'FSSAI', 'Temporarily Pending', '2'),
(8, 'FSSAI', 'Document Pending', '3'),
(9, 'FSSAI', 'Application Delivered / Certificate Pending', '5'),
(10, 'FSSAI', 'DNF', '4'),
(11, 'FSSAI', 'Certificate Delivered', '6'),
(12, 'FSSAI', 'Refund', '7'),
(13, 'GST', 'Temporarily Pending', '2'),
(14, 'GST', 'Document Pending', '3'),
(15, 'GST', 'Application Done / Certificate Pending', '5'),
(16, 'GST', 'DNF', '4'),
(17, 'GST', 'Certificate Issued', '6'),
(18, 'GST', 'Refund', '7'),
(19, 'ISO', 'Temporarily Pending', '2'),
(20, 'ISO', 'Document Pending', '3'),
(21, 'ISO', 'Sample Provided / Final Pending', '5'),
(22, 'ISO', 'DNF', '4'),
(23, 'ISO', 'Approved By Client / Final Pending', '6'),
(24, 'ISO', 'Certificate Delivered', '7'),
(25, 'DSC', 'Temporarily Pending', '2'),
(26, 'DSC', 'Document Pending', '3'),
(27, 'DSC', 'Application Processed / Delivery Pending', '5'),
(28, 'DSC', 'DNF', '4'),
(29, 'DSC', 'Courier Sent', '6'),
(30, 'DSC', 'Refund', '7'),
(31, 'DL', 'Aadhaar / DL Issue', '3'),
(32, 'DL', 'Document Pending', '4'),
(33, 'DL', 'Appn Generated PP', '5'),
(34, 'DL', 'Fee Stuck', '6'),
(35, 'DL', 'Fee Paid Slot Pending', '7'),
(36, 'DL', 'Slot Booked', '8'),
(37, 'PP', 'Temporarily Pending', '2'),
(38, 'PP', 'Details Pending', '3'),
(39, 'PP', 'Form Failed / Application Pending', '5'),
(40, 'PP', 'DNF', '4'),
(41, 'PP', 'Appointment Delivered', '6'),
(42, 'PP', 'Certificate Delivered', '7'),
(43, 'OTHERS', 'Temporarily Pending', '2'),
(44, 'OTHERS', 'OTP Not Given', '3'),
(45, 'OTHERS', 'Aadhaar Issue', '4'),
(46, 'OTHERS', 'DNF', '5'),
(47, 'OTHERS', 'Number Delivered', '6'),
(48, 'OTHERS', 'Certificate Delivered', '7'),
(67, 'MSME', 'Refund', '8'),
(70, 'MSME', 'Pending', '1'),
(71, 'FSSAI', 'Pending', '1'),
(72, 'GST', 'Pending', '1'),
(73, 'ISO', 'Pending', '1'),
(74, 'DSC', 'Pending', '1'),
(75, 'DL', 'Pending', '1'),
(77, 'OTHERS', 'Pending', '1'),
(79, 'PP', 'Pending', '1'),
(84, 'DL', 'LD PP', '9'),
(85, 'DL', 'Case Closed', '10'),
(86, 'DL', 'Refund', '11'),
(87, 'DL', 'DNF', '2'),
(88, 'ISO', 'Refund', '8');

-- --------------------------------------------------------

--
-- Table structure for table `campaign`
--

CREATE TABLE `campaign` (
  `id` int(11) NOT NULL,
  `campaign_name` varchar(100) NOT NULL,
  `campaign_schedule_time` varchar(100) NOT NULL,
  `campaign_email_group` varchar(100) NOT NULL,
  `campaign_email_group_type` varchar(100) NOT NULL,
  `campaign_from_email` varchar(100) NOT NULL,
  `campaign_subject` varchar(200) NOT NULL,
  `campaign_message` text NOT NULL,
  `campaign_date` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `campaign_email`
--

CREATE TABLE `campaign_email` (
  `id` int(11) NOT NULL,
  `campaign_id` varchar(100) NOT NULL,
  `form_id` varchar(100) NOT NULL,
  `business` varchar(100) NOT NULL,
  `email_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `campaign_email_lists`
--

CREATE TABLE `campaign_email_lists` (
  `id` int(11) NOT NULL,
  `domain` varchar(100) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `email_id` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `campaign_unsubscribe_lists`
--

CREATE TABLE `campaign_unsubscribe_lists` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `campaign_unsubscribe_lists`
--

INSERT INTO `campaign_unsubscribe_lists` (`id`, `email`) VALUES
(1, 'developer@techlounge.co.in');

-- --------------------------------------------------------

--
-- Table structure for table `cid`
--

CREATE TABLE `cid` (
  `id` int(11) NOT NULL,
  `client_id` varchar(100) NOT NULL,
  `form_id` varchar(100) NOT NULL,
  `cid` varchar(100) NOT NULL,
  `first_otp` varchar(100) NOT NULL,
  `final_otp` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `complaint_forms`
--

CREATE TABLE `complaint_forms` (
  `id` int(11) NOT NULL,
  `business` varchar(200) NOT NULL,
  `complaint_id` varchar(200) NOT NULL,
  `form_name` varchar(200) NOT NULL,
  `applicant_name` varchar(200) NOT NULL,
  `mobile_number` varchar(200) NOT NULL,
  `email_id` varchar(200) NOT NULL,
  `docs` varchar(200) NOT NULL,
  `order_id` varchar(200) NOT NULL,
  `transaction_date` varchar(200) NOT NULL,
  `transaction_amount` varchar(200) NOT NULL,
  `complaint_details` text NOT NULL,
  `website` varchar(200) NOT NULL,
  `assigned_to` varchar(200) NOT NULL,
  `status` varchar(200) NOT NULL,
  `stage` varchar(100) NOT NULL,
  `form_created_on` varchar(200) NOT NULL,
  `form_date` varchar(100) NOT NULL,
  `form_month` varchar(100) NOT NULL,
  `form_year` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `complaint_status`
--

CREATE TABLE `complaint_status` (
  `id` int(11) NOT NULL,
  `business` varchar(100) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `complaint_status`
--

INSERT INTO `complaint_status` (`id`, `business`, `title`, `description`) VALUES
(1, 'MSME', 'Pending', 'Payment received, form processing pending.'),
(2, 'MSME', 'Aadhaar / OTP Not Given', 'Payment received, form pending due to required details. Note: Our executive will get in touch with you soon for required details.'),
(3, 'MSME', 'DNF', 'Payment received, form pending due to details mismatched from our system. Please resubmit your form with same mobile number or email id as used while making payment.'),
(4, 'FSSAI', 'Pending', 'Payment received, form processing pending.');

-- --------------------------------------------------------

--
-- Table structure for table `complaint_timeline`
--

CREATE TABLE `complaint_timeline` (
  `id` int(11) NOT NULL,
  `meta_id` varchar(100) NOT NULL,
  `meta_name` varchar(200) NOT NULL,
  `meta_description` text NOT NULL,
  `meta_user` varchar(200) NOT NULL,
  `meta_type` varchar(200) NOT NULL,
  `form_created_on` varchar(200) NOT NULL,
  `form_created_time` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `edit_form_link`
--

CREATE TABLE `edit_form_link` (
  `id` int(11) NOT NULL,
  `form_id` int(12) NOT NULL,
  `panel_form_id` varchar(200) NOT NULL,
  `full_link` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `email`
--

CREATE TABLE `email` (
  `id` int(11) NOT NULL,
  `template` varchar(100) NOT NULL,
  `message` varchar(1000) NOT NULL,
  `team` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `email`
--

INSERT INTO `email` (`id`, `template`, `message`, `team`) VALUES
(6, 'RZP-KFS-MSME-Rs1999', 'Sir/Ma\'am,\r\nWhile processing your application, it was noticed that payment is pending, click on link to make payment https://rzp.io/l/x235RQQ\r\nTeam Udyam', 'MSME'),
(7, 'RZP-KFS-MSME-Rs2700', 'Sir/Ma\'am,\r\nWhile processing your application, it was noticed that payment is pending, click on link to make payment https://rzp.io/l/MIpzEtc\r\nTeam Udyam', 'MSME'),
(10, 'RZP-KFS-GST-PROPRIETORSHIP-Rs1500', 'Dear Sir/Ma\'am,\r\nWhile processing your application for GST Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/P2o7o2O\r\nTeam GST', 'GST'),
(11, 'RZP-KFS-GST-Rs2000', 'Dear Sir/Ma\'am,\r\nWhile processing your application for GST Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/Y4rcLXe\r\nTeam GST', 'GST'),
(13, 'RZP-KFS-ISO-9001-Rs3499', ' Sir/Ma\'am,\r\nWhile processing your application for ISO 9001 : 2015 Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/WTgFSSQ\r\n\r\nTeam ISO', 'ISO'),
(14, 'RZP-KFS-ISO-14001-Rs4499', 'Sir/Ma\'am,\r\nWhile processing your application for ISO 14001 : 2015 Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/XuQ2X0m\r\n\r\nTeam ISO', 'ISO'),
(15, 'RZP-KFS-ISO-18001-Rs5499', 'Sir/Ma\'am,\r\nWhile processing your application for OHSAS 18001 : 2007 Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/TuVz2PX\r\n\r\nTeam ISO', 'ISO'),
(16, 'RZP-KFS-ISO-20000-Rs7500', 'Sir/Ma\'am,\r\nWhile processing your application for ISO 20000 : 2011 Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/6X5sJRw\r\n\r\nTeam ISO', 'ISO'),
(17, 'RZP-KFS-ISO-22000-Rs7999', 'Sir/Ma\'am,\r\nWhile processing your application for ISO 22000 : 2005 Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/VPz7JMM\r\nTeam ISO', 'ISO'),
(18, 'RZP-KFS-ISO-13485-Rs7999', 'Sir/Ma\'am,\r\nWhile processing your application for ISO 13485 : 2016 Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/v35fUKA\r\nTeam ISO', 'ISO'),
(19, 'RZP-KFS-ISO-HACCP-Rs8500', 'Sir/Ma\'am,\r\nWhile processing your application for HACCP Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/bXRD15w\r\n\r\nTeam ISO', 'ISO'),
(20, 'RZP-KFS-ISO-27001-Rs8500', 'Sir/Ma\'am,\r\nWhile processing your application for ISO 27001 : 2013 Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/fnv4e7E\r\nTeam ISO', 'ISO'),
(21, 'RZP-KFS-ISO-29990-Rs8500', 'Sir/Ma\'am,\r\nWhile processing your application for ISO 29990 : 2010 Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/pZjyDbd\r\nTeam ISO', 'ISO'),
(22, 'RZP-KFS-ISO-50001-Rs20000', 'Sir/Ma\'am,\r\nWhile processing your application for ISO 50001 : 2011 Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/wn4kDUv\r\nTeam ISO', 'ISO'),
(24, 'RZP-KFS-DSC-CLASS II (S/E) 1 YEAR-Rs1049', 'Sir/Ma\'am,\r\nWhile processing your application for Class II (S/E) 1 Year Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/rgONDJe\r\n\r\nTeam DSC', 'DSC'),
(25, 'RZP-KFS-DSC-CLASS II (S/E) 2 YEARS-Rs1099', ' Sir/Ma\'am,\r\nWhile processing your application for Class II (S/E) 2 Years Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/GrqcUzD\r\n\r\nTeam DSC', 'DSC'),
(26, 'RZP-KFS-DSC-CLASS II (COMBO) 1 YEAR-Rs1249', 'Sir/Ma\'am,\r\nWhile processing your application Class II (Combo) 1 Year Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/ly6pBvx\r\n\r\nTeam DSC', 'DSC'),
(27, 'RZP-KFS-DSC-CLASS II (COMBO) 2 YEARS-Rs1299', 'Sir/Ma\'am,\r\nWhile processing your application for Class II (Combo) 2 Years Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/Gb8o1nA\r\n\r\nTeam DSC', 'DSC'),
(28, 'RZP-KFS-DSC-CLASS III (S/E) 1 YEAR-Rs3200', 'Sir/Ma\'am,\r\nWhile processing your application for Class III (S/E) 1 Year Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/4RG1fJ9\r\n\r\nTeam DSC', 'DSC'),
(29, 'RZP-KFS-DSC-CLASS III (S/E) 2 YEARS-Rs3250', 'Sir/Ma\'am,\r\nWhile processing your application for Class III (S/E) 2 Years Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/S9G7yFA\r\n\r\nTeam DSC', 'DSC'),
(30, 'RZP-KFS-DSC-CLASS III (COMBO) 1 YEAR-Rs3300', 'Sir/Ma\'am,\r\nWhile processing your application for Class III (Combo) 1 Year Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/Rvbu7EF\r\n\r\nTeam DSC', 'DSC'),
(31, 'RZP-KFS-DSC-CLASS III (COMBO) 2 YEARS-Rs3400', 'Sir/Ma\'am,\r\nWhile processing your application for Class III (Combo) 2 Years Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/4pdQFYg\r\n\r\nTeam DSC', 'DSC'),
(32, 'RZP-KFS-DSC-DGFT 2 YEARS-Rs5900', 'Sir/Ma\'am,\r\nWhile processing your application for DGFT 2 Years Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/AwmhOgO\r\n\r\nTeam DSC', 'DSC'),
(34, 'RZP-KFS-FSSAI NORMAL-1 YEAR-Rs2299', 'Sir/Ma\'am,\r\nWhile processing your application for FSSAI 1 Year Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/wNrEBDH\r\n<br>\r\n<br>\r\nTeam FSSAI', 'FSSAI'),
(35, 'RZP-KFS-FSSAI NORMAL-2 YEARS-Rs2999', 'Sir/Ma\'am,\r\nWhile processing your application for FSSAI 2 Years Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/xVMqU2T\r\n\r\n<br>\r\n<br>\r\nTeam FSSAI', 'FSSAI'),
(36, 'RZP-KFS-FSSAI NORMAL-3 YEARS-Rs3699', 'Sir/Ma\'am,\r\nWhile processing your application for FSSAI 3 Years Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/UJf50Ev\r\n\r\n<br>\r\n<br>\r\n\r\nTeam FSSAI', 'FSSAI'),
(37, 'RZP-KFS-FSSAI NORMAL-4 YEARS-Rs4399', 'Sir/Ma\'am,\r\nWhile processing your application for FSSAI 4 Years Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/Ck3r5ka\r\n<br>\r\n<br>\r\n\r\nTeam FSSAI', 'FSSAI'),
(38, 'RZP-KFS-FSSAI NORMAL-5 YEARS-Rs5099', ' Sir/Ma\'am,\r\nWhile processing your application for FSSAI 5 Years Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/aYy7s99\r\n<br>\r\n<br>\r\n\r\nTeam FSSAI', 'FSSAI'),
(40, 'RZP-KFS-SP-Rs3500', 'Sir/Ma\'am,\r\nWhile processing application, it was noticed that payment is pending, click on link to make payment https://rzp.io/l/lyku2Zg\r\nSole Proprietor', 'OTHERS');

-- --------------------------------------------------------

--
-- Table structure for table `email_cron`
--

CREATE TABLE `email_cron` (
  `id` int(11) NOT NULL,
  `form_id` varchar(100) NOT NULL,
  `website` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `date` varchar(100) NOT NULL,
  `time` varchar(100) NOT NULL,
  `is_mail` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `email_processor`
--

CREATE TABLE `email_processor` (
  `id` int(11) NOT NULL,
  `template_name` varchar(1000) NOT NULL,
  `business_name` varchar(1000) NOT NULL,
  `business_stage` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `email_processor`
--

INSERT INTO `email_processor` (`id`, `template_name`, `business_name`, `business_stage`) VALUES
(51, 'Delivery Of Udyam Registration Number', 'MSME', 'Number Delivered'),
(52, 'Print Udyam Registration Certificate', 'MSME', 'Certificate Delivered'),
(53, 'Delivery of Udyog Aadhaar Registration Certificate (Print UAM Certificate)', 'MSME', 'Certificate Delivered'),
(54, 'Delivery of Udyog Aadhaar Registration Certificate (Updated UAM Certificate)', 'MSME', 'Certificate Delivered'),
(60, 'Aadhaar Validation Issue', 'MSME', 'Aadhaar Issue'),
(66, 'Aadhaar Mobile Issue', 'MSME', 'Aadhaar Issue'),
(67, 'OTP Not Given', 'MSME', 'OTP Not Given'),
(68, 'DNF', 'MSME', 'DNF'),
(77, 'Driving Licence Aadhaar DL Issue', 'DL', 'Aadhaar / DL Issue'),
(78, 'Driving Licence Detail Document Pending', 'DL', 'Document Pending'),
(79, 'Delivery of Learners Licence', 'DL', 'Appn Generated PP'),
(80, 'Delivery of Permanent Driving Licence', 'DL', 'Appn Generated PP'),
(81, 'Delivery of Learners Permanent Driving Licence', 'DL', 'Appn Generated PP'),
(82, 'Delivery of Driving Licence Renewal', 'DL', 'Appn Generated PP');

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE `forms` (
  `id` int(11) NOT NULL,
  `form_id` varchar(100) NOT NULL,
  `vendor_array` varchar(1000) NOT NULL,
  `business_array` varchar(1000) NOT NULL,
  `website_array` varchar(1000) NOT NULL,
  `amount_array` varchar(1000) NOT NULL,
  `status_array` varchar(1000) NOT NULL,
  `pay_vendor` varchar(100) NOT NULL,
  `pay_status` varchar(100) NOT NULL,
  `payment_id` varchar(100) NOT NULL,
  `order_id` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL DEFAULT 'Website',
  `vendor` varchar(100) NOT NULL,
  `business` varchar(100) NOT NULL,
  `website` varchar(100) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `complaint_status` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `mobile` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `form_name` varchar(100) NOT NULL,
  `assigned_to` varchar(100) NOT NULL,
  `dropped` varchar(100) NOT NULL,
  `dropped_by` varchar(100) NOT NULL,
  `mark_as_paid_by` varchar(100) NOT NULL,
  `processor` varchar(100) NOT NULL,
  `stage` varchar(100) NOT NULL,
  `delivered_on` varchar(100) NOT NULL,
  `remarks` varchar(4000) NOT NULL,
  `dl_application_number` varchar(100) NOT NULL,
  `date_slot` varchar(100) NOT NULL,
  `schedule_cid` varchar(100) NOT NULL,
  `schedule_date` varchar(100) NOT NULL,
  `payment_verification` varchar(100) NOT NULL,
  `is_follow_up` varchar(100) NOT NULL,
  `is_comment` varchar(100) NOT NULL,
  `is_assigned` varchar(100) NOT NULL,
  `is_cron` varchar(100) NOT NULL,
  `is_cron_issue_count` varchar(100) NOT NULL,
  `is_updated` varchar(100) NOT NULL,
  `date` varchar(100) NOT NULL,
  `form_date` varchar(100) NOT NULL,
  `form_month` varchar(100) NOT NULL,
  `form_year` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `print_gid`
--

CREATE TABLE `print_gid` (
  `id` int(11) NOT NULL,
  `print_gid` varchar(100) NOT NULL,
  `uam` varchar(100) NOT NULL,
  `client_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `razorpay_merchant`
--

CREATE TABLE `razorpay_merchant` (
  `id` int(11) NOT NULL,
  `merchant_id` varchar(100) NOT NULL,
  `key_id` varchar(200) NOT NULL,
  `key_secret` varchar(200) NOT NULL,
  `merchant_name` varchar(100) NOT NULL,
  `display_name` varchar(100) NOT NULL,
  `website_name` varchar(100) NOT NULL,
  `vendor` varchar(100) NOT NULL,
  `business` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sms`
--

CREATE TABLE `sms` (
  `id` int(11) NOT NULL,
  `template` varchar(100) NOT NULL,
  `message` varchar(1000) NOT NULL,
  `team` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sms`
--

INSERT INTO `sms` (`id`, `template`, `message`, `team`) VALUES
(6, 'RZP-KFS-MSME-Rs1999', 'While processing your application, it was noticed that payment of Rs. 1999/- is pending, click on link to make payment \r\n\r\nhttps://rzp.io/l/x235RQQ\r\n', 'MSME'),
(7, 'RZP-KFS-MSME-Rs2700', 'While processing your application, it was noticed that payment of Rs. 2700/- is pending, click on link to make payment\r\n\r\nhttps://rzp.io/l/MIpzEtc', 'MSME'),
(10, 'RZP-KFS-GST-PROPRIETORSHIP-Rs1500', 'Dear Sir/Ma\'am,\r\nWhile processing your application for GST Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/P2o7o2O\r\nTeam GST', 'GST'),
(11, 'RZP-KFS-GST-Rs2000', 'Dear Sir/Ma\'am,\r\nWhile processing your application for GST Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/Y4rcLXe\r\nTeam GST', 'GST'),
(13, 'RZP-KFS-ISO-9001-Rs3499', ' Sir/Ma\'am,\r\nWhile processing your application for ISO 9001 : 2015 Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/WTgFSSQ\r\n\r\nTeam ISO', 'ISO'),
(14, 'RZP-KFS-ISO-14001-Rs4499', 'Sir/Ma\'am,\r\nWhile processing your application for ISO 14001 : 2015 Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/XuQ2X0m\r\n\r\nTeam ISO', 'ISO'),
(15, 'RZP-KFS-ISO-18001-Rs5499', 'Sir/Ma\'am,\r\nWhile processing your application for OHSAS 18001 : 2007 Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/TuVz2PX\r\n\r\nTeam ISO', 'ISO'),
(16, 'RZP-KFS-ISO-20000-Rs7500', 'Sir/Ma\'am,\r\nWhile processing your application for ISO 20000 : 2011 Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/6X5sJRw\r\n\r\nTeam ISO', 'ISO'),
(17, 'RZP-KFS-ISO-22000-Rs7999', 'Sir/Ma\'am,\r\nWhile processing your application for ISO 22000 : 2005 Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/VPz7JMM\r\nTeam ISO', 'ISO'),
(18, 'RZP-KFS-ISO-13485-Rs7999', 'Sir/Ma\'am,\r\nWhile processing your application for ISO 13485 : 2016 Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/v35fUKA\r\nTeam ISO', 'ISO'),
(19, 'RZP-KFS-ISO-HACCP-Rs8500', 'Sir/Ma\'am,\r\nWhile processing your application for HACCP Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/bXRD15w\r\n\r\nTeam ISO', 'ISO'),
(20, 'RZP-KFS-ISO-27001-Rs8500', 'Sir/Ma\'am,\r\nWhile processing your application for ISO 27001 : 2013 Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/fnv4e7E\r\nTeam ISO', 'ISO'),
(21, 'RZP-KFS-ISO-29990-Rs8500', 'Sir/Ma\'am,\r\nWhile processing your application for ISO 29990 : 2010 Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/pZjyDbd\r\nTeam ISO', 'ISO'),
(22, 'RZP-KFS-ISO-50001-Rs20000', 'Sir/Ma\'am,\r\nWhile processing your application for ISO 50001 : 2011 Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/wn4kDUv\r\nTeam ISO', 'ISO'),
(24, 'RZP-KFS-DSC-CLASS II (S/E) 1 YEAR-Rs1049', 'Sir/Ma\'am,\r\nWhile processing your application for Class II (S/E) 1 Year Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/rgONDJe\r\n\r\nTeam DSC', 'DSC'),
(25, 'RZP-KFS-DSC-CLASS II (S/E) 2 YEARS-Rs1099', ' Sir/Ma\'am,\r\nWhile processing your application for Class II (S/E) 2 Years Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/GrqcUzD\r\n\r\nTeam DSC', 'DSC'),
(26, 'RZP-KFS-DSC-CLASS II (COMBO) 1 YEAR-Rs1249', 'Sir/Ma\'am,\r\nWhile processing your application Class II (Combo) 1 Year Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/ly6pBvx\r\n\r\nTeam DSC', 'DSC'),
(27, 'RZP-KFS-DSC-CLASS II (COMBO) 2 YEARS-Rs1299', 'Sir/Ma\'am,\r\nWhile processing your application for Class II (Combo) 2 Years Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/Gb8o1nA\r\n\r\nTeam DSC', 'DSC'),
(28, 'RZP-KFS-DSC-CLASS III (S/E) 1 YEAR-Rs3200', 'Sir/Ma\'am,\r\nWhile processing your application for Class III (S/E) 1 Year Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/4RG1fJ9\r\n\r\nTeam DSC', 'DSC'),
(29, 'RZP-KFS-DSC-CLASS III (S/E) 2 YEARS-Rs3250', 'Sir/Ma\'am,\r\nWhile processing your application for Class III (S/E) 2 Years Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/S9G7yFA\r\n\r\nTeam DSC', 'DSC'),
(30, 'RZP-KFS-DSC-CLASS III (COMBO) 1 YEAR-Rs3300', 'Sir/Ma\'am,\r\nWhile processing your application for Class III (Combo) 1 Year Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/Rvbu7EF\r\n\r\nTeam DSC', 'DSC'),
(31, 'RZP-KFS-DSC-CLASS III (COMBO) 2 YEARS-Rs3400', 'Sir/Ma\'am,\r\nWhile processing your application for Class III (Combo) 2 Years Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/4pdQFYg\r\n\r\nTeam DSC', 'DSC'),
(32, 'RZP-KFS-DSC-DGFT 2 YEARS-Rs5900', 'Sir/Ma\'am,\r\nWhile processing your application for DGFT 2 Years Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/AwmhOgO\r\n\r\nTeam DSC', 'DSC'),
(34, 'RZP-KFS-FSSAI NORMAL-1 YEAR-Rs1799', 'Sir/Ma\'am,\r\nWhile processing your application for FSSAI 1 Year Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/wNrEBDH\r\n\r\nTeam FSSAI', 'FSSAI'),
(35, 'RZP-KFS-FSSAI NORMAL-2 YEARS-Rs2699', 'Sir/Ma\'am,\r\nWhile processing your application for FSSAI 2 Years Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/xVMqU2T\r\n\r\nTeam FSSAI', 'FSSAI'),
(36, 'RZP-KFS-FSSAI NORMAL-3 YEARS-Rs3399', 'Sir/Ma\'am,\r\nWhile processing your application for FSSAI 3 Years Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/UJf50Ev\r\n\r\nTeam FSSAI', 'FSSAI'),
(37, 'RZP-KFS-FSSAI NORMAL-4 YEARS-Rs4099', 'Sir/Ma\'am,\r\nWhile processing your application for FSSAI 4 Years Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/Ck3r5ka\r\n\r\nTeam FSSAI', 'FSSAI'),
(38, 'RZP-KFS-FSSAI NORMAL-5 YEARS-Rs4799', ' Sir/Ma\'am,\r\nWhile processing your application for FSSAI 5 Years Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/aYy7s99\r\n\r\nTeam FSSAI', 'FSSAI'),
(40, 'RZP-KFS-SP-Rs3500', 'Sir/Ma\'am,\r\nWhile processing application, it was noticed that payment is pending, click on link to make payment https://rzp.io/l/lyku2Zg\r\nSole Proprietor', 'OTHERS');

-- --------------------------------------------------------

--
-- Table structure for table `timeline`
--

CREATE TABLE `timeline` (
  `id` int(11) NOT NULL,
  `meta_id` varchar(100) NOT NULL,
  `meta_name` varchar(1000) NOT NULL,
  `meta_description` varchar(1000) NOT NULL,
  `meta_user` varchar(100) NOT NULL,
  `form_created_on` varchar(100) NOT NULL,
  `form_created_time` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `track_ip`
--

CREATE TABLE `track_ip` (
  `id` int(11) NOT NULL,
  `ip` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `created_on` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_email` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_profile` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `user_ext` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_role` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_team` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_web` varchar(2000) COLLATE utf8_unicode_ci NOT NULL,
  `user_status` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `is_hold` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '00-00-0000 00:00:00 PM',
  `last_logout` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '00-00-0000 00:00:00 PM'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='user data';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_password_hash`, `user_password`, `user_profile`, `user_ext`, `user_role`, `user_team`, `user_web`, `user_status`, `is_hold`, `last_login`, `last_logout`) VALUES
(3, 'Fahad Razi', 'fr@techlounge.co.in', '$2y$10$wqia9Qwp5xIHYLrYFptMEekh0VWF8N0JI/ReJIQaVAz7Fqg3QwJJW', 'technocrats@1603#', '', '', 'Admin', 'MSME,FSSAI,GST,ISO,DSC,DL,PP,OTHERS', '', 'false', 'false', '17-10-2020 15:06:16', '17-10-2020 14:57:32'),
(4, 'All Log', 'all_log@techlounge.co.in', '$2y$10$IZmRtrdu3/zT6daZIO3/GOJpHUOA1ZdzXOrR65ufYHKYermQi/mxa', 'kfs@KFS2516#', '', '', 'Processor,Complaint,Sales', 'MSME,FSSAI,GST,ISO,DSC,DL,PP,OTHERS', '', 'false', 'false', '15-10-2020 10:29:24', '15-10-2020 10:58:13'),
(5, 'Processor Log', 'processor_log@techlounge.co.in', '$2y$10$IZmRtrdu3/zT6daZIO3/GOJpHUOA1ZdzXOrR65ufYHKYermQi/mxa', 'kfs@KFS2516#', '', '', 'Processor', 'MSME,FSSAI,GST,ISO,DSC,DL,PP,OTHERS', '', 'false', 'false', '17-10-2020 14:57:46', '17-10-2020 15:06:08'),
(6, 'Complaint Log', 'complaint_log@techlounge.co.in', '$2y$10$IZmRtrdu3/zT6daZIO3/GOJpHUOA1ZdzXOrR65ufYHKYermQi/mxa', 'kfs@KFS2516#', '', '', 'Complaint', 'MSME,FSSAI,GST,ISO,DSC,DL,PP,OTHERS', '', 'false', 'false', '20-09-2020 12:42:11', '20-09-2020 14:26:53'),
(7, 'Sales Log', 'sales_log@techlounge.co.in', '$2y$10$IZmRtrdu3/zT6daZIO3/GOJpHUOA1ZdzXOrR65ufYHKYermQi/mxa', 'kfs@KFS2516#', '', '', 'Sales', 'MSME,FSSAI,GST,ISO,DSC,DL,PP,OTHERS', '', 'false', 'false', '20-09-2020 16:20:11', '20-09-2020 16:23:01'),
(8, 'Editor Log', 'editor_log@techlounge.co.in', '$2y$10$IZmRtrdu3/zT6daZIO3/GOJpHUOA1ZdzXOrR65ufYHKYermQi/mxa', 'kfs@KFS2516#', '', '', 'Editor', 'MSME,FSSAI,GST,ISO,DSC,DL,PP,OTHERS', '%22UDYAM.ORG.IN%22%2C%22EUDYOGAADHAAR.ORG%22%2C%22MSMEREGISTRAR.ORG%22', 'false', 'false', '22-09-2020 16:09:38', '22-09-2020 16:11:30');

-- --------------------------------------------------------

--
-- Table structure for table `users_login`
--

CREATE TABLE `users_login` (
  `id` int(11) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `user_auth` varchar(100) NOT NULL,
  `user_status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users_team`
--

CREATE TABLE `users_team` (
  `id` int(11) NOT NULL,
  `team` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_team`
--

INSERT INTO `users_team` (`id`, `team`) VALUES
(1, 'MSME'),
(2, 'FSSAI'),
(3, 'GST'),
(4, 'ISO'),
(5, 'DSC'),
(6, 'DL'),
(7, 'PP'),
(8, 'OTHERS');

-- --------------------------------------------------------

--
-- Table structure for table `whatsapp`
--

CREATE TABLE `whatsapp` (
  `id` int(11) NOT NULL,
  `template` varchar(100) NOT NULL,
  `message` varchar(1000) NOT NULL,
  `team` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `whatsapp`
--

INSERT INTO `whatsapp` (`id`, `template`, `message`, `team`) VALUES
(6, 'RZP-KFS-MSME-Rs1999', 'While processing your application, it was noticed that payment of Rs. 1999/- is pending, click on link to make payment\r\n\r\nhttps://rzp.io/l/x235RQQ\r\n', 'MSME'),
(7, 'RZP-KFS-MSME-Rs2700', 'While processing your application, it was noticed that payment of Rs. 2700/- is pending, click on link to make payment\r\n\r\nhttps://rzp.io/l/MIpzEtc\r\n', 'MSME'),
(10, 'RZP-KFS-GST-PROPRIETORSHIP-Rs1500', 'Dear Sir/Ma\'am,\r\nWhile processing your application for GST Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/P2o7o2O\r\nTeam GST', 'GST'),
(11, 'RZP-KFS-GST-Rs2000', 'Dear Sir/Ma\'am,\r\nWhile processing your application for GST Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/Y4rcLXe\r\nTeam GST', 'GST'),
(13, 'RZP-KFS-ISO-9001-Rs3499', ' Sir/Ma\'am,\r\nWhile processing your application for ISO 9001 : 2015 Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/WTgFSSQ\r\n\r\nTeam ISO', 'ISO'),
(14, 'RZP-KFS-ISO-14001-Rs4499', 'Sir/Ma\'am,\r\nWhile processing your application for ISO 14001 : 2015 Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/XuQ2X0m\r\n\r\nTeam ISO', 'ISO'),
(15, 'RZP-KFS-ISO-18001-Rs5499', 'Sir/Ma\'am,\r\nWhile processing your application for OHSAS 18001 : 2007 Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/TuVz2PX\r\n\r\nTeam ISO', 'ISO'),
(16, 'RZP-KFS-ISO-20000-Rs7500', 'Sir/Ma\'am,\r\nWhile processing your application for ISO 20000 : 2011 Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/6X5sJRw\r\n\r\nTeam ISO', 'ISO'),
(17, 'RZP-KFS-ISO-22000-Rs7999', 'Sir/Ma\'am,\r\nWhile processing your application for ISO 22000 : 2005 Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/VPz7JMM\r\nTeam ISO', 'ISO'),
(18, 'RZP-KFS-ISO-13485-Rs7999', 'Sir/Ma\'am,\r\nWhile processing your application for ISO 13485 : 2016 Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/v35fUKA\r\nTeam ISO', 'ISO'),
(19, 'RZP-KFS-ISO-HACCP-Rs8500', 'Sir/Ma\'am,\r\nWhile processing your application for HACCP Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/bXRD15w\r\n\r\nTeam ISO', 'ISO'),
(20, 'RZP-KFS-ISO-27001-Rs8500', 'Sir/Ma\'am,\r\nWhile processing your application for ISO 27001 : 2013 Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/fnv4e7E\r\nTeam ISO', 'ISO'),
(21, 'RZP-KFS-ISO-29990-Rs8500', 'Sir/Ma\'am,\r\nWhile processing your application for ISO 29990 : 2010 Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/pZjyDbd\r\nTeam ISO', 'ISO'),
(22, 'RZP-KFS-ISO-50001-Rs20000', 'Sir/Ma\'am,\r\nWhile processing your application for ISO 50001 : 2011 Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/wn4kDUv\r\nTeam ISO', 'ISO'),
(24, 'RZP-KFS-DSC-CLASS II (S/E) 1 YEAR-Rs1049', 'Sir/Ma\'am,\r\nWhile processing your application for Class II (S/E) 1 Year Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/rgONDJe\r\n\r\nTeam DSC', 'DSC'),
(25, 'RZP-KFS-DSC-CLASS II (S/E) 2 YEARS-Rs1099', ' Sir/Ma\'am,\r\nWhile processing your application for Class II (S/E) 2 Years Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/GrqcUzD\r\n\r\nTeam DSC', 'DSC'),
(26, 'RZP-KFS-DSC-CLASS II (COMBO) 1 YEAR-Rs1249', 'Sir/Ma\'am,\r\nWhile processing your application Class II (Combo) 1 Year Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/ly6pBvx\r\n\r\nTeam DSC', 'DSC'),
(27, 'RZP-KFS-DSC-CLASS II (COMBO) 2 YEARS-Rs1299', 'Sir/Ma\'am,\r\nWhile processing your application for Class II (Combo) 2 Years Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/Gb8o1nA\r\n\r\nTeam DSC', 'DSC'),
(28, 'RZP-KFS-DSC-CLASS III (S/E) 1 YEAR-Rs3200', 'Sir/Ma\'am,\r\nWhile processing your application for Class III (S/E) 1 Year Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/4RG1fJ9\r\n\r\nTeam DSC', 'DSC'),
(29, 'RZP-KFS-DSC-CLASS III (S/E) 2 YEARS-Rs3250', 'Sir/Ma\'am,\r\nWhile processing your application for Class III (S/E) 2 Years Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/S9G7yFA\r\n\r\nTeam DSC', 'DSC'),
(30, 'RZP-KFS-DSC-CLASS III (COMBO) 1 YEAR-Rs3300', 'Sir/Ma\'am,\r\nWhile processing your application for Class III (Combo) 1 Year Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/Rvbu7EF\r\n\r\nTeam DSC', 'DSC'),
(31, 'RZP-KFS-DSC-CLASS III (COMBO) 2 YEARS-Rs3400', 'Sir/Ma\'am,\r\nWhile processing your application for Class III (Combo) 2 Years Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/4pdQFYg\r\n\r\nTeam DSC', 'DSC'),
(32, 'RZP-KFS-DSC-DGFT 2 YEARS-Rs5900', 'Sir/Ma\'am,\r\nWhile processing your application for DGFT 2 Years Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/AwmhOgO\r\n\r\nTeam DSC', 'MAIN'),
(33, '------------------------------------------------------------------', '', 'MAIN'),
(34, 'RZP-KFS-FSSAI NORMAL-1 YEAR-Rs1799', 'Sir/Ma\'am,\r\nWhile processing your application for FSSAI 1 Year Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/wNrEBDH\r\n\r\nTeam FSSAI', 'MAIN'),
(35, 'RZP-KFS-FSSAI NORMAL-2 YEARS-Rs2699', 'Sir/Ma\'am,\r\nWhile processing your application for FSSAI 2 Years Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/xVMqU2T\r\n\r\nTeam FSSAI', 'FSSAI'),
(36, 'RZP-KFS-FSSAI NORMAL-3 YEARS-Rs3399', 'Sir/Ma\'am,\r\nWhile processing your application for FSSAI 3 Years Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/UJf50Ev\r\n\r\nTeam FSSAI', 'FSSAI'),
(37, 'RZP-KFS-FSSAI NORMAL-4 YEARS-Rs4099', 'Sir/Ma\'am,\r\nWhile processing your application for FSSAI 4 Years Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/Ck3r5ka\r\n\r\nTeam FSSAI', 'FSSAI'),
(38, 'RZP-KFS-FSSAI NORMAL-5 YEARS-Rs4799', ' Sir/Ma\'am,\r\nWhile processing your application for FSSAI 5 Years Certificate, it was noticed that your payment is still pending, please click on link below to make payment\r\nhttps://rzp.io/l/aYy7s99\r\n\r\nTeam FSSAI', 'FSSAI'),
(40, 'RZP-KFS-SP-Rs3500', 'Sir/Ma\'am,\r\nWhile processing application, it was noticed that payment is pending, click on link to make payment https://rzp.io/l/lyku2Zg\r\nSole Proprietor', 'OTHERS');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `business`
--
ALTER TABLE `business`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `campaign`
--
ALTER TABLE `campaign`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `campaign_email`
--
ALTER TABLE `campaign_email`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `campaign_email_lists`
--
ALTER TABLE `campaign_email_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `campaign_unsubscribe_lists`
--
ALTER TABLE `campaign_unsubscribe_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cid`
--
ALTER TABLE `cid`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `complaint_forms`
--
ALTER TABLE `complaint_forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `complaint_status`
--
ALTER TABLE `complaint_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `complaint_timeline`
--
ALTER TABLE `complaint_timeline`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `edit_form_link`
--
ALTER TABLE `edit_form_link`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email`
--
ALTER TABLE `email`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_cron`
--
ALTER TABLE `email_cron`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_processor`
--
ALTER TABLE `email_processor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `print_gid`
--
ALTER TABLE `print_gid`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `razorpay_merchant`
--
ALTER TABLE `razorpay_merchant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms`
--
ALTER TABLE `sms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timeline`
--
ALTER TABLE `timeline`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `track_ip`
--
ALTER TABLE `track_ip`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- Indexes for table `users_login`
--
ALTER TABLE `users_login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_team`
--
ALTER TABLE `users_team`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `whatsapp`
--
ALTER TABLE `whatsapp`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `business`
--
ALTER TABLE `business`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `campaign`
--
ALTER TABLE `campaign`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `campaign_email`
--
ALTER TABLE `campaign_email`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `campaign_email_lists`
--
ALTER TABLE `campaign_email_lists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `campaign_unsubscribe_lists`
--
ALTER TABLE `campaign_unsubscribe_lists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cid`
--
ALTER TABLE `cid`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `complaint_forms`
--
ALTER TABLE `complaint_forms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `complaint_status`
--
ALTER TABLE `complaint_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `complaint_timeline`
--
ALTER TABLE `complaint_timeline`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `edit_form_link`
--
ALTER TABLE `edit_form_link`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email`
--
ALTER TABLE `email`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `email_cron`
--
ALTER TABLE `email_cron`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_processor`
--
ALTER TABLE `email_processor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `print_gid`
--
ALTER TABLE `print_gid`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `razorpay_merchant`
--
ALTER TABLE `razorpay_merchant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sms`
--
ALTER TABLE `sms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `timeline`
--
ALTER TABLE `timeline`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `track_ip`
--
ALTER TABLE `track_ip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users_login`
--
ALTER TABLE `users_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_team`
--
ALTER TABLE `users_team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `whatsapp`
--
ALTER TABLE `whatsapp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
