-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 04, 2014 at 02:33 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `wg_rvlmoversdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `rvl_address_list`
--

DROP TABLE IF EXISTS `rvl_address_list`;
CREATE TABLE IF NOT EXISTS `rvl_address_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `address_code` varchar(20) NOT NULL,
  `address` varchar(150) NOT NULL,
  `address_type` varchar(20) NOT NULL COMMENT 'Delivery / Pick Up Point / Delivery Point',
  `category_type` varchar(15) NOT NULL COMMENT 'Warehouse / Dealer',
  `status` varchar(10) NOT NULL COMMENT 'Active / Inactive',
  `is_archive` varchar(5) NOT NULL COMMENT 'Yes / No',
  `date_created` varchar(20) NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_update_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `rvl_address_list`
--

INSERT INTO `rvl_address_list` (`id`, `client_id`, `address_code`, `address`, `address_type`, `category_type`, `status`, `is_archive`, `date_created`, `last_update`, `last_update_by`) VALUES
(1, 11, 'HC-LAG', 'Laguna', 'Delivery Address', 'Warehouse', 'Active', 'No', '', '2013-12-21 06:48:52', 0),
(2, 11, 'HC-BTGS', 'Batangas', 'Delivery Address', 'Warehouse', 'Active', 'No', '', '2013-12-21 06:48:54', 0),
(3, 11, 'HC-CVTE', 'Cavite', 'Delivery Address', 'Warehouse', 'Active', 'No', '', '2013-12-21 06:48:54', 0),
(4, 11, 'HC-BLCN', 'Bulacan', 'Delivery Address', 'Warehouse', 'Active', 'No', '', '2013-12-21 06:48:55', 0),
(5, 11, 'HC-PAMPGA', 'Pampang', 'Delivery Address', 'Warehouse', 'Active', 'No', '', '2013-12-21 06:48:56', 0),
(6, 11, 'HC-TRLC', 'Tarlac', 'Delivery Address', 'Warehouse', 'Active', 'No', '', '2013-12-21 06:48:56', 0),
(7, 11, 'HC-NECIJA', 'Nueva Ecija', 'Delivery Address', 'Warehouse', 'Active', 'No', '', '2013-12-21 06:48:57', 0),
(8, 11, 'HC-ISBLA', 'Isabela', 'Delivery Address', 'Warehouse', 'Active', 'No', '', '2013-12-21 06:48:59', 0),
(9, 11, 'PRT-BAUAN', 'Bauan Port', '', 'Dealer', 'Active', 'No', '', '2013-12-21 06:50:03', 0),
(10, 11, 'HCPI-STA.ROSA', 'Sta. Rosa', '', 'Warehouse', 'Active', 'No', '', '2013-12-21 08:30:32', 0);

-- --------------------------------------------------------

--
-- Table structure for table `rvl_client_address_list`
--

DROP TABLE IF EXISTS `rvl_client_address_list`;
CREATE TABLE IF NOT EXISTS `rvl_client_address_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `address` varchar(150) NOT NULL,
  `address_type` varchar(15) NOT NULL COMMENT 'Pick Up Point / Delivery Point',
  `status` varchar(10) NOT NULL COMMENT 'Active / Inactive',
  `is_archive` varchar(10) NOT NULL COMMENT 'Yes / No',
  `date_created` varchar(20) NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_update_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `rvl_client_address_list`
--

INSERT INTO `rvl_client_address_list` (`id`, `client_id`, `address`, `address_type`, `status`, `is_archive`, `date_created`, `last_update`, `last_update_by`) VALUES
(1, 1, 'Bauan Port Batangas', 'Pick Up Point', 'Active', 'No', '', '2013-09-24 11:21:03', 0),
(2, 1, 'Tanauan 1 .Sto. Tomas', 'Pick Up Point', 'Active', 'No', '', '2013-09-24 11:21:18', 0),
(3, 1, 'Tanauan 2.San Bartolome', 'Pick Up Point', 'Active', 'No', '', '2013-09-24 11:21:34', 0),
(4, 1, 'NYK Calamba', 'Pick Up Point', 'Active', 'No', '', '2013-09-24 11:21:41', 0),
(5, 1, 'Makiling, Calamba', 'Pick Up Point', 'Active', 'No', '', '2013-09-24 11:21:52', 0);

-- --------------------------------------------------------

--
-- Table structure for table `rvl_client_list`
--

DROP TABLE IF EXISTS `rvl_client_list`;
CREATE TABLE IF NOT EXISTS `rvl_client_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_name` varchar(100) NOT NULL,
  `delivery_address_code` varchar(20) NOT NULL,
  `delivery_address` varchar(150) NOT NULL,
  `contact_person` varchar(50) NOT NULL,
  `status` varchar(10) NOT NULL COMMENT 'Active / Inactive',
  `is_archive` varchar(10) NOT NULL COMMENT 'Yes / No',
  `date_created` varchar(20) NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_update_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `rvl_client_list`
--

INSERT INTO `rvl_client_list` (`id`, `client_name`, `delivery_address_code`, `delivery_address`, `contact_person`, `status`, `is_archive`, `date_created`, `last_update`, `last_update_by`) VALUES
(1, 'MITSUBISHI MOTORS PHILIPPINES', 'HC-ISBLA', 'Imelda Avenue, Cainta Rizal', '', 'Active', 'No', '', '2013-10-18 17:47:25', 0),
(2, 'FORD GROUP PHILIPPINES', 'HC-LAG', 'Imelda Avenue, Cainta Rizal', '', 'Active', 'No', '', '2013-10-18 17:47:30', 0),
(3, 'TOYOTA CARS', 'HC-LAG', 'Imelda Avenue, Cainta Rizal', '', 'Active', 'No', '', '2013-10-18 17:48:57', 0),
(4, 'TOYOTA SAN FERNANDO PAMPANGA, INC', 'HC-LAG', 'Imelda Avenue, Cainta Rizal', '', 'Active', 'No', '', '2013-10-18 17:47:31', 0),
(5, 'NISSAN PHILIPPINES', 'HC-LAG', 'Imelda Avenue, Cainta Rizal', '', 'Active', 'No', '', '2013-10-18 17:47:33', 0),
(6, 'BMW PHILIPPINES INC', 'HC-LAG', 'Imelda Avenue, Cainta Rizal', '', 'Active', 'No', '', '2013-10-18 17:47:34', 0),
(7, 'FAST SERVICES CORPORATION', 'HC-HC-LAG', 'Imelda Avenue, Cainta Rizal', '', 'Active', 'No', '', '2013-10-18 17:47:35', 0),
(8, 'TRANSWORLD BROKERAGE CORP', 'HC-LAG', 'Imelda Avenue, Cainta Rizal', '', 'Active', 'No', '', '2013-10-18 17:47:36', 0),
(9, 'NYK LOGISTICS', 'HC-LAG', 'Imelda Avenue, Cainta Rizal', '', 'Active', 'No', '', '2013-10-18 17:47:36', 0),
(10, 'CEVA LOGISTICS', 'HC-LAG', 'Imelda Avenue, Cainta Rizal', '', 'Active', 'No', '', '2013-10-18 17:47:37', 0),
(11, 'HONDA', 'HC-ISBLA', 'Imelda Avenue, Cainta Rizal', '', 'Active', 'No', '', '2013-12-19 14:16:59', 0);

-- --------------------------------------------------------

--
-- Table structure for table `rvl_delivery_plan_tracking`
--

DROP TABLE IF EXISTS `rvl_delivery_plan_tracking`;
CREATE TABLE IF NOT EXISTS `rvl_delivery_plan_tracking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dr_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `datetime_confirmed` varchar(20) NOT NULL,
  `confirmed_type` varchar(20) NOT NULL COMMENT 'Warehouse / Dealer',
  `date_created` varchar(20) NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_update_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rvl_delivery_receipt`
--

DROP TABLE IF EXISTS `rvl_delivery_receipt`;
CREATE TABLE IF NOT EXISTS `rvl_delivery_receipt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `delivery_no` char(20) NOT NULL,
  `client_id` int(11) NOT NULL,
  `client_name` varchar(50) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `warehouse_name` varchar(50) NOT NULL,
  `driver_id` varchar(100) NOT NULL,
  `driver_name` varchar(50) NOT NULL,
  `other_driver_id` int(11) NOT NULL,
  `other_driver_name` varchar(50) NOT NULL,
  `truck_id` int(11) NOT NULL,
  `truck_model` varchar(50) NOT NULL,
  `plate_no` varchar(30) NOT NULL,
  `delivery_date` varchar(20) NOT NULL,
  `delivery_address_code` varchar(20) NOT NULL,
  `delivery_address` varchar(150) NOT NULL,
  `pick_up_point_code` varchar(20) NOT NULL,
  `pickup_point` varchar(150) NOT NULL,
  `delivery_point_code` varchar(20) NOT NULL,
  `delivery_point` varchar(150) NOT NULL,
  `delivery_type` varchar(15) NOT NULL COMMENT 'Standard / Special',
  `status` varchar(25) NOT NULL,
  `billing_status` varchar(15) NOT NULL COMMENT 'Pending / Billed / Paid',
  `remarks` varchar(150) NOT NULL,
  `warehouse_datetime_in` varchar(20) NOT NULL,
  `warehouse_datetime_out` varchar(20) NOT NULL,
  `dealer_datetime_in` varchar(20) NOT NULL,
  `dealer_datetime_out` varchar(20) NOT NULL,
  `billing_date` varchar(20) NOT NULL,
  `is_archive` varchar(10) NOT NULL,
  `is_already_generated` varchar(10) NOT NULL DEFAULT 'No' COMMENT 'Yes / No',
  `date_created` varchar(20) NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_update_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rvl_driver_list`
--

DROP TABLE IF EXISTS `rvl_driver_list`;
CREATE TABLE IF NOT EXISTS `rvl_driver_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `assigned_truck_id` int(11) NOT NULL,
  `assigned_type` varchar(10) NOT NULL COMMENT 'Porter / Jockey',
  `firstname` varchar(30) NOT NULL,
  `middlename` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `driver_license` varchar(20) NOT NULL,
  `status` varchar(10) NOT NULL COMMENT 'active / inactive',
  `is_archive` varchar(10) NOT NULL COMMENT 'Yes / No',
  `date_created` varchar(20) NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_update_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `rvl_driver_list`
--

INSERT INTO `rvl_driver_list` (`id`, `employee_id`, `assigned_truck_id`, `assigned_type`, `firstname`, `middlename`, `lastname`, `full_name`, `driver_license`, `status`, `is_archive`, `date_created`, `last_update`, `last_update_by`) VALUES
(7, 25, 3, 'Porter', 'Ismael', 'Vermug', 'Balondo', 'Ismael Vermug Balondo Jr', 'N04-93-286673', 'Active', 'No', '2013-12-17 09:28:00', '2013-12-17 01:28:00', 1),
(6, 24, 2, 'Porter', 'Eriberto', 'Espina', 'Malacas', 'Eriberto Espina Malacas ', 'E01-97-020202', 'Active', 'No', '2013-12-17 09:25:55', '2013-12-17 01:25:55', 1),
(5, 23, 1, 'Porter', 'Nilo', 'Barriaga', 'Capin', 'Nilo Barriaga Capin Jr', 'D04-00-154643', 'Active', 'No', '2013-12-17 09:23:19', '2013-12-17 01:23:19', 1),
(8, 26, 5, 'Porter', 'Ceferrino', 'Rodriguez', 'Terrible', 'Ceferrino Rodriguez Terrible ', 'D04-80-015535', 'Active', 'No', '2013-12-17 09:29:13', '2013-12-17 01:29:13', 1),
(9, 27, 6, 'Porter', 'Norberto', 'Andaya', 'Ilao', 'Norberto Andaya Ilao ', 'D06-91-086928', 'Active', 'No', '2013-12-17 09:30:03', '2013-12-17 01:30:03', 1),
(10, 28, 1, 'Jockey', 'Numeriano', 'Cadacio', 'Manlangit', 'Numeriano Cadacio Manlangit ', 'D18-07-007073', 'Active', 'No', '2013-12-17 09:30:52', '2013-12-17 01:30:52', 1),
(11, 29, 2, 'Jockey', 'Elmer', 'Tagud', 'Bersabal', 'Elmer Tagud Bersabal ', 'N26-00-041050', 'Active', 'No', '2013-12-17 09:32:03', '2013-12-17 01:32:03', 1),
(12, 30, 3, 'Jockey', 'Ricardo', 'Miranda', 'Mayano', 'Ricardo Miranda Mayano ', 'D04-72-009100', 'Active', 'No', '2013-12-17 09:33:10', '2013-12-17 01:33:10', 1),
(13, 31, 4, 'Jockey', 'Renato', 'Ramos', 'Ramos', 'Renato Ramos Ramos ', 'N18-76-014882', 'Active', 'No', '2013-12-17 09:34:03', '2013-12-17 01:34:03', 1),
(14, 32, 5, 'Jockey', 'Edgardo', 'Rutaquio', 'Tuayon', 'Edgardo Rutaquio Tuayon ', 'C05-94-076071', 'Active', 'No', '2013-12-17 09:35:23', '2013-12-17 01:35:23', 1),
(15, 33, 6, 'Jockey', 'Jayson', 'Soriano', 'Nazareno', 'Jayson Soriano Nazareno ', 'D06-00-215888', 'Active', 'No', '2013-12-17 09:36:12', '2013-12-17 01:36:12', 1);

-- --------------------------------------------------------

--
-- Table structure for table `rvl_employee`
--

DROP TABLE IF EXISTS `rvl_employee`;
CREATE TABLE IF NOT EXISTS `rvl_employee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_code` varchar(20) NOT NULL COMMENT 'auto generate',
  `client_id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `suffix` varchar(10) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL COMMENT 'Male / Female',
  `birthdate` varchar(20) NOT NULL,
  `email_address` varchar(50) NOT NULL,
  `employee_status` varchar(10) NOT NULL COMMENT 'Active / Inactive',
  `tin` varchar(20) NOT NULL,
  `sss` varchar(30) NOT NULL,
  `is_archive` varchar(10) NOT NULL COMMENT 'Yes / No',
  `date_created` varchar(20) NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_update_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `rvl_employee`
--

INSERT INTO `rvl_employee` (`id`, `employee_code`, `client_id`, `firstname`, `middlename`, `lastname`, `suffix`, `full_name`, `gender`, `birthdate`, `email_address`, `employee_status`, `tin`, `sss`, `is_archive`, `date_created`, `last_update`, `last_update_by`) VALUES
(1, 'rvl-000001', 0, 'Leo Angelo', 'Lariba', 'Diaz', '', 'Leo Angelo Lariba Diaz ', 'Male', '2013-10-29', 'leoangelo.diaz@gmail.com', 'Active', '', '', 'No', '2013-11-10 10:20:29', '2013-11-10 14:20:29', 1),
(16, 'coordinator', 0, 'coordinator', 'coordinator', 'coordinator', 'coordinato', 'coordinator coordinator coordinator coordinator', 'Male', '1980-11-13', 'coordinator@coordinator.com', 'Active', '', '', 'No', '2013-11-13 09:15:46', '2013-11-13 13:15:46', 1),
(15, 'driver-0002', 0, 'Nico', 'G', 'Solis', '', 'Nico G Solis ', 'Male', '1980-11-11', 'nico.solis@rvl.com', 'Active', '', '', 'No', '2013-11-11 11:22:19', '2013-11-11 15:22:19', 1),
(14, 'driver-0001', 1, 'Alvin', 'A', 'Paderes', 'Jr', 'Alvin A Paderes Jr', 'Male', '1980-11-12', 'alvin.paderes@rvl.com', 'Active', '', '', 'No', '2013-11-11 11:22:24', '2013-11-11 15:22:24', 1),
(17, 'central.dispatcher', 0, 'central.dispatcher', 'central.dispatcher', 'central.dispatcher', 'central.di', 'central.dispatcher central.dispatcher central.disp', 'Male', '1980-11-13', 'central.dispatcher@rvl.com', 'Active', '', '', 'No', '2013-11-13 09:16:21', '2013-11-13 13:16:21', 1),
(18, 'guard1', 1, 'guard1', 'guard1', 'guard1', 'guard1', 'guard1 guard1 guard1 guard1', 'Male', '1980-11-13', 'guard1@rvl.com', 'Active', '', '', 'No', '2013-11-16 02:48:46', '2013-11-15 18:48:46', 1),
(19, 'guard2', 1, 'guard2', 'guard2', 'guard2', 'guard2', 'guard2 guard2 guard2 guard2', 'Male', '1980-11-13', 'guard2@rvl.com', 'Active', '', '', 'No', '2013-11-13 09:17:56', '2013-11-16 04:15:59', 1),
(20, 'guard3', 3, 'guard3', 'guard3', 'guard3', 'guard3', 'guard3 guard3 guard3 guard3', 'Female', '1980-11-13', 'guard3@rvl.com', 'Active', '', '', 'No', '2013-11-13 09:18:15', '2013-11-13 13:18:15', 1),
(21, 'billing', 0, 'billing', 'billing', 'billing', 'billing', 'billing billing billing billing', 'Female', '1980-11-13', 'billing@rvl.com', 'Active', '', '', 'No', '2013-11-13 09:18:41', '2013-11-13 13:18:41', 1),
(22, 'payroll.staff', 0, 'payroll.staff', 'payroll.staff', 'payroll.staff', 'payroll.st', 'payroll.staff payroll.staff payroll.staff payroll.', 'Male', '1980-11-13', 'payroll.staff@rvl.com', 'Active', '', '', 'No', '2013-11-13 09:21:38', '2013-11-13 13:21:38', 1),
(23, '1005', 0, 'Nilo', 'Barriaga', 'Capin', 'Jr', 'Nilo Barriaga Capin Jr', 'Male', '1978-08-17', 'nilo.barriaga@rvl.com', 'Active', '', '', 'No', '2013-12-17 09:23:19', '2013-12-17 01:23:19', 1),
(24, '1008', 0, 'Eriberto', 'Espina', 'Malacas', '', 'Eriberto Espina Malacas ', 'Male', '1977-04-16', 'eriberto.malacas@rvl.com', 'Active', '', '', 'No', '2013-12-17 09:25:55', '2013-12-17 01:25:55', 1),
(25, '1013', 0, 'Ismael', 'Vermug', 'Balondo', 'Jr', 'Ismael Vermug Balondo Jr', 'Male', '1980-12-17', 'ismael.vermug@rvl.com', 'Active', '', '', 'No', '2013-12-17 09:28:00', '2013-12-17 01:28:00', 1),
(26, '1015', 0, 'Ceferrino', 'Rodriguez', 'Terrible', '', 'Ceferrino Rodriguez Terrible ', 'Male', '1980-12-17', 'ceferrino.terrible@rvl.com', 'Active', '', '', 'No', '2013-12-17 09:29:13', '2013-12-17 01:29:13', 1),
(27, '1017', 0, 'Norberto', 'Andaya', 'Ilao', '', 'Norberto Andaya Ilao ', 'Male', '1980-12-17', 'norberto.ilao@rvl.com', 'Active', '', '', 'No', '2013-12-17 09:30:03', '2013-12-17 01:30:03', 1),
(28, '1020', 0, 'Numeriano', 'Cadacio', 'Manlangit', '', 'Numeriano Cadacio Manlangit ', 'Male', '1980-12-17', 'numeriano.cadacio@rvl.com', 'Active', '', '', 'No', '2013-12-17 09:30:52', '2013-12-17 01:30:52', 1),
(29, '1021', 0, 'Elmer', 'Tagud', 'Bersabal', '', 'Elmer Tagud Bersabal ', 'Male', '1980-12-17', 'elmer.tagud@rvl.com', 'Active', '', '', 'No', '2013-12-17 09:32:03', '2013-12-17 01:32:03', 1),
(30, '1023', 0, 'Ricardo', 'Miranda', 'Mayano', '', 'Ricardo Miranda Mayano ', 'Male', '1980-12-17', 'ricardo.mayano@rvl.com', 'Active', '', '', 'No', '2013-12-17 09:33:10', '2013-12-17 01:33:10', 1),
(31, '1024', 0, 'Renato', 'Ramos', 'Ramos', '', 'Renato Ramos Ramos ', 'Male', '1980-12-17', 'renato.ramos@rvl.com', 'Active', '', '', 'No', '2013-12-17 09:34:03', '2013-12-17 01:34:03', 1),
(32, '1028', 0, 'Edgardo', 'Rutaquio', 'Tuayon', '', 'Edgardo Rutaquio Tuayon ', 'Male', '1980-12-17', 'edgardo.tuayon@rvl.com', 'Active', '', '', 'No', '2013-12-17 09:35:23', '2013-12-17 01:35:23', 1),
(33, '1029', 0, 'Jayson', 'Soriano', 'Nazareno', '', 'Jayson Soriano Nazareno ', 'Male', '1980-12-17', 'jayson.soriano@rvl.com', 'Active', '', '', 'No', '2013-12-17 09:36:12', '2013-12-17 01:36:12', 1);

-- --------------------------------------------------------

--
-- Table structure for table `rvl_payroll_register`
--

DROP TABLE IF EXISTS `rvl_payroll_register`;
CREATE TABLE IF NOT EXISTS `rvl_payroll_register` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `delivery_receipt_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `delivery_date` varchar(20) NOT NULL,
  `date_time_in` varchar(20) NOT NULL,
  `date_time_out` varchar(20) NOT NULL,
  `total_hours` varchar(15) NOT NULL,
  `rate` varchar(15) NOT NULL,
  `basic_pay` varchar(15) NOT NULL,
  `is_generated` varchar(10) NOT NULL DEFAULT 'No' COMMENT 'Yes / No',
  `date_created` varchar(20) NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_update_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rvl_position`
--

DROP TABLE IF EXISTS `rvl_position`;
CREATE TABLE IF NOT EXISTS `rvl_position` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department_id` int(11) NOT NULL,
  `position_name` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `is_archive` varchar(10) NOT NULL COMMENT 'Yes / No',
  `date_created` varchar(20) NOT NULL,
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_modified_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `rvl_position`
--

INSERT INTO `rvl_position` (`id`, `department_id`, `position_name`, `description`, `is_archive`, `date_created`, `last_modified`, `last_modified_by`) VALUES
(1, 1, 'Driver', '', 'No', '', '2013-12-19 15:27:53', 0);

-- --------------------------------------------------------

--
-- Table structure for table `rvl_position_rate`
--

DROP TABLE IF EXISTS `rvl_position_rate`;
CREATE TABLE IF NOT EXISTS `rvl_position_rate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position_id` int(11) NOT NULL,
  `daily_rate` int(11) NOT NULL,
  `status` varchar(20) NOT NULL COMMENT 'Active / Inactive',
  `date_created` varchar(20) NOT NULL,
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_modified_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `rvl_position_rate`
--

INSERT INTO `rvl_position_rate` (`id`, `position_id`, `daily_rate`, `status`, `date_created`, `last_modified`, `last_modified_by`) VALUES
(1, 1, 350, 'Active', '', '2013-12-19 15:28:43', 0);

-- --------------------------------------------------------

--
-- Table structure for table `rvl_rate_honda`
--

DROP TABLE IF EXISTS `rvl_rate_honda`;
CREATE TABLE IF NOT EXISTS `rvl_rate_honda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pick_up_point` varchar(20) NOT NULL,
  `destination` varchar(20) NOT NULL,
  `load_unit` int(11) NOT NULL,
  `hauling_charge` varchar(20) NOT NULL,
  `delivery_type` varchar(10) NOT NULL,
  `status` varchar(10) NOT NULL COMMENT 'Active / Inactive',
  `single` varchar(10) NOT NULL,
  `straight` varchar(10) NOT NULL,
  `trailer` varchar(10) NOT NULL,
  `date_created` varchar(20) NOT NULL,
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_modified_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=49 ;

--
-- Dumping data for table `rvl_rate_honda`
--

INSERT INTO `rvl_rate_honda` (`id`, `pick_up_point`, `destination`, `load_unit`, `hauling_charge`, `delivery_type`, `status`, `single`, `straight`, `trailer`, `date_created`, `last_modified`, `last_modified_by`) VALUES
(1, 'HCPI-STA.ROSA', 'HC-LAG', 5, '1308', 'Outbound', 'Active', '350', '450', '500', '', '2013-12-25 12:56:50', 0),
(2, 'HCPI-STA.ROSA', 'HC-CVTE', 7, '1308', 'Outbound', 'Active', '350', '450', '500', '', '2013-12-25 12:57:35', 0),
(3, 'HCPI-STA.ROSA', 'HC-CVTE', 5, '1305', 'Outbound', 'Active', '350', '450', '500', '', '2013-12-25 12:57:35', 0),
(4, 'HCPI-STA.ROSA', 'HC-ISABELA', 5, '8585', 'Outbound', 'Active', '350', '450', '500', '', '2013-12-25 12:57:35', 0),
(5, 'HCPI-STA.ROSA', 'HC-LAOAG', 5, '10798', 'Outbound', 'Active', '350', '450', '500', '', '2013-12-25 12:57:35', 0),
(6, 'HCPI-STA.ROSA', 'HC-ALABANG', 5, '1377', 'Outbound', 'Active', '350', '450', '500', '', '2013-12-25 12:57:35', 0),
(7, 'HCPI-STA.ROSA', 'HC-MAKATI', 5, '1596', 'Outbound', 'Active', '350', '450', '500', '', '2013-12-25 12:57:35', 0),
(8, 'HCPI-STA.ROSA', 'HC-GLOBAL', 5, '1651', 'Outbound', 'Active', '350', '450', '500', '', '2013-12-25 12:57:35', 0),
(9, 'HCPI-STA.ROSA', 'HC-MANILA', 5, '1663', 'Outbound', 'Active', '350', '450', '500', '', '2013-12-25 12:57:35', 0),
(10, 'HCPI-STA.ROSA', 'HC-SHAW', 5, '1683', 'Outbound', 'Active', '350', '450', '500', '', '2013-12-25 12:57:35', 0),
(11, 'HCPI-STA.ROSA', 'HC-PASIG', 5, '1706', 'Outbound', 'Active', '350', '450', '500', '', '2013-12-25 12:57:35', 0),
(12, 'HCPI-STA.ROSA', 'HC-PIER 12', 5, '1743', 'Outbound', 'Active', '350', '450', '500', '', '2013-12-25 12:57:35', 0),
(13, 'HCPI-STA.ROSA', 'HC-MARIKINA', 5, '1792', 'Outbound', 'Active', '350', '450', '500', '', '2013-12-25 12:57:35', 0),
(14, 'HCPI-STA.ROSA', 'HC-QC', 5, '1792', 'Outbound', 'Active', '350', '450', '500', '', '2013-12-25 12:57:35', 0),
(15, 'HCPI-STA.ROSA', 'HC-KALOOKAN', 5, '1829', 'Outbound', 'Active', '350', '450', '500', '', '2013-12-25 12:57:35', 0),
(16, 'HCPI-STA.ROSA', 'HC-FAIRVIEW', 5, '1875', 'Outbound', 'Active', '350', '450', '500', '', '2013-12-25 12:57:35', 0),
(17, 'HCPI-STA.ROSA', 'HC-CVTE', 1, '1378', 'Outbound', 'Active', '350', '450', '500', '', '2013-12-25 12:57:35', 0),
(18, 'HCPI-STA.ROSA', 'HC-SP LAGUNA', 6, '1626', 'Outbound', 'Active', '350', '450', '500', '', '2013-12-25 12:57:35', 0),
(19, 'HCPI-STA.ROSA', 'HC-RIZAL', 6, '1829', 'Outbound', 'Active', '350', '450', '500', '', '2013-12-25 12:57:35', 0),
(20, 'HCPI-STA.ROSA', 'HC-BATANGAS', 6, '2056', 'Outbound', 'Active', '350', '450', '500', '', '2013-12-25 12:57:35', 0),
(21, 'HCPI-STA.ROSA', 'HC-BAUANPORT', 6, '2101', 'Outbound', 'Active', '350', '450', '500', '', '2013-12-25 12:57:35', 0),
(22, 'HCPI-STA.ROSA', 'HC-BULACAN', 6, '2526', 'Outbound', 'Active', '350', '450', '500', '', '2013-12-25 12:57:35', 0),
(23, 'HCPI-STA.ROSA', 'HC-PAMPANGA', 6, '3079', 'Outbound', 'Active', '350', '450', '500', '', '2013-12-25 12:57:35', 0),
(24, 'HCPI-STA.ROSA', 'HC-TARLAC*', 6, '4317', 'Outbound', 'Active', '350', '450', '500', '', '2013-12-25 12:57:35', 0),
(25, 'HCPI-STA.ROSA', 'HC-ALABANG', 6, '1412', 'Outbound', 'Active', '350', '450', '500', '', '2013-12-25 12:57:35', 0),
(26, 'HCPI-STA.ROSA', 'HC-MAKATI', 6, '1649', 'Outbound', 'Active', '350', '450', '500', '', '2013-12-25 12:57:35', 0),
(27, 'HCPI-STA.ROSA', 'HC-GLOBAL', 6, '1705', 'Outbound', 'Active', '350', '450', '500', '', '2013-12-25 12:57:35', 0),
(28, 'HCPI-STA.ROSA', 'HC-MANILA', 6, '1730', 'Outbound', 'Active', '350', '450', '500', '', '2013-12-25 12:57:35', 0),
(29, 'HCPI-STA.ROSA', 'HC-SHAW', 6, '1755', 'Outbound', 'Active', '350', '450', '500', '', '2013-12-25 12:57:35', 0),
(30, 'HCPI-STA.ROSA', 'HC-PASIG', 6, '1783', 'Outbound', 'Active', '350', '450', '500', '', '2013-12-25 12:57:35', 0),
(31, 'HCPI-STA.ROSA', 'HC-PIER 12', 6, '1828', 'Outbound', 'Active', '350', '450', '500', '', '2013-12-25 12:57:35', 0),
(32, 'HCPI-STA.ROSA', 'HC-MARIKINA', 6, '1887', 'Outbound', 'Active', '350', '450', '500', '', '2013-12-25 12:57:35', 0),
(33, 'HCPI-STA.ROSA', 'HC-MARIKINA', 7, '1638', 'Outbound', 'Active', '350', '450', '500', '', '2013-12-25 12:57:35', 0),
(34, 'HCPI-STA.ROSA', 'HC-PIER 12', 7, '1587', 'Outbound', 'Active', '350', '450', '500', '', '2013-12-25 12:57:35', 0),
(35, 'HCPI-STA.ROSA', 'HC-PASIG', 7, '1548', 'Outbound', 'Active', '350', '450', '500', '', '2013-12-25 12:57:35', 0),
(36, 'HCPI-STA.ROSA', 'HC-SHAW', 7, '1525', 'Outbound', 'Active', '350', '450', '500', '', '2013-12-25 12:57:35', 0),
(37, 'HCPI-STA.ROSA', 'HC-MANILA', 7, '1504', 'Outbound', 'Active', '350', '450', '500', '', '2013-12-25 12:57:35', 0),
(38, 'HCPI-STA.ROSA', 'HC-GLOBAL', 7, '1482', 'Outbound', 'Active', '350', '450', '500', '', '2013-12-25 12:57:35', 0),
(39, 'HCPI-STA.ROSA', 'HC-MAKATI', 7, '1434', 'Outbound', 'Active', '350', '450', '500', '', '2013-12-25 12:57:35', 0),
(40, 'HCPI-STA.ROSA', 'HC-ALABANG', 7, '1231', 'Outbound', 'Active', '350', '450', '500', '', '2013-12-25 12:57:35', 0),
(41, 'HCPI-STA.ROSA', 'HC-PAMPANGA', 7, '2660', 'Outbound', 'Active', '350', '450', '500', '', '2013-12-25 12:57:35', 0),
(42, 'HCPI-STA.ROSA', 'HC-BULACAN', 7, '2185', 'Outbound', 'Active', '350', '450', '500', '', '2013-12-25 12:57:35', 0),
(43, 'HCPI-STA.ROSA', 'HC-BAUANPORT', 7, '1822', 'Outbound', 'Active', '350', '450', '500', '', '2013-12-25 12:57:35', 0),
(44, 'HCPI-STA.ROSA', 'HC-BATANGAS', 7, '1783', 'Outbound', 'Active', '350', '450', '500', '', '2013-12-25 12:57:35', 0),
(45, 'HCPI-STA.ROSA', 'HC-RIZAL', 7, '1588', 'Outbound', 'Active', '350', '450', '500', '', '2013-12-25 12:57:35', 0),
(46, 'HCPI-STA.ROSA', 'HC-SP LAGUNA', 7, '1414', 'Outbound', 'Active', '350', '450', '500', '', '2013-12-25 12:57:35', 0),
(47, 'HCPI-STA.ROSA', 'HC-CVTE', 5, '1202', 'Special', 'Active', '350', '450', '500', '', '2013-12-25 12:57:35', 0),
(48, 'HCPI-STA.ROSA', 'HC-LAG', 5, '2500', 'Special', 'Active', '350', '450', '500', '', '2013-12-25 12:57:35', 0);

-- --------------------------------------------------------

--
-- Table structure for table `rvl_settings_rate`
--

DROP TABLE IF EXISTS `rvl_settings_rate`;
CREATE TABLE IF NOT EXISTS `rvl_settings_rate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `witholding_tax` varchar(10) NOT NULL,
  `sss` varchar(10) NOT NULL,
  `philhealth` varchar(10) NOT NULL,
  `pagibig` varchar(10) NOT NULL,
  `status` varchar(10) NOT NULL COMMENT 'Active / Inactive',
  `date_created` varchar(20) NOT NULL,
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_modified_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `rvl_settings_rate`
--

INSERT INTO `rvl_settings_rate` (`id`, `witholding_tax`, `sss`, `philhealth`, `pagibig`, `status`, `date_created`, `last_modified`, `last_modified_by`) VALUES
(1, '9', '1', '5', '10', 'Active', '', '2013-12-21 04:14:30', 0),
(2, '10', '10', '10', '10', 'Inactive', '', '2013-12-19 14:53:43', 0);

-- --------------------------------------------------------

--
-- Table structure for table `rvl_trip_rates`
--

DROP TABLE IF EXISTS `rvl_trip_rates`;
CREATE TABLE IF NOT EXISTS `rvl_trip_rates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `pick_up_point` varchar(20) NOT NULL COMMENT 'address_code',
  `delivery_address` varchar(20) NOT NULL COMMENT 'address_code',
  `trip_type` varchar(20) NOT NULL COMMENT 'Inbound / Outbound',
  `amount` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `rvl_trip_rates`
--

INSERT INTO `rvl_trip_rates` (`id`, `client_id`, `pick_up_point`, `delivery_address`, `trip_type`, `amount`) VALUES
(1, 1, 'HC-LAG', 'HC-ISBLA', 'Inbound', '1500'),
(3, 1, 'HC-LAG', 'HC-ISBLA', 'Outbound', '1000');

-- --------------------------------------------------------

--
-- Table structure for table `rvl_truck_list`
--

DROP TABLE IF EXISTS `rvl_truck_list`;
CREATE TABLE IF NOT EXISTS `rvl_truck_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `truck_model` varchar(50) NOT NULL,
  `plate_number` varchar(30) NOT NULL,
  `description` varchar(150) NOT NULL,
  `status` varchar(15) NOT NULL COMMENT 'Available / Not Available',
  `capacity` int(11) NOT NULL,
  `remaining` int(11) NOT NULL,
  `has_epass` varchar(5) NOT NULL COMMENT 'Yes / No',
  `epass_tag_serial` varchar(20) NOT NULL,
  `class_type` varchar(10) NOT NULL COMMENT 'C1 / C2 / C3',
  `truck_type` varchar(20) NOT NULL,
  `is_archive` varchar(10) NOT NULL COMMENT 'Yes / No',
  `date_created` varchar(20) NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_update_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `rvl_truck_list`
--

INSERT INTO `rvl_truck_list` (`id`, `truck_model`, `plate_number`, `description`, `status`, `capacity`, `remaining`, `has_epass`, `epass_tag_serial`, `class_type`, `truck_type`, `is_archive`, `date_created`, `last_update`, `last_update_by`) VALUES
(1, 'Isuzu', 'TYF 507', '', 'Available', 1, 1, 'Yes', '0327204915', 'C2\n', 'Single', 'No', '', '2013-12-25 17:14:46', 0),
(2, 'Isuzu', 'TYG 182	\n', '', 'Available', 5, 5, 'Yes', '0327204916', 'C2\n', 'Straight', 'No', '', '2013-12-25 13:36:41', 0),
(3, 'Isuzu', 'TYG 190	', '', 'Available', 7, 7, 'Yes', '1237216585', 'C2\n', 'Trailer', 'No', '', '2013-12-22 07:08:06', 0),
(4, 'Isuzu', 'TXZ 548', '', 'Available', 1, 1, 'Yes', '1237216590', 'C2\n', 'Single', 'No', '', '2013-12-25 17:14:46', 0),
(5, 'Isuzu', 'TYG 304', '', 'Available', 5, 5, 'Yes', '1237216584', 'C2\n', 'Straight', 'No', '', '2013-12-21 06:30:58', 0),
(6, 'Isuzu', 'TYG 210', '', 'Available', 7, 7, 'Yes', '1301161099', 'C2\n', 'Trailer', 'No', '', '2013-12-21 06:30:53', 0);

-- --------------------------------------------------------

--
-- Table structure for table `rvl_user`
--

DROP TABLE IF EXISTS `rvl_user`;
CREATE TABLE IF NOT EXISTS `rvl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `employee_code` varchar(20) NOT NULL,
  `email_address` varchar(30) NOT NULL,
  `username` varchar(150) NOT NULL,
  `password` text NOT NULL,
  `hash` text NOT NULL,
  `secret_key` varchar(250) NOT NULL,
  `account_type` varchar(50) NOT NULL,
  `account_status` varchar(10) NOT NULL COMMENT 'Active / Inactive',
  `last_change_password` varchar(20) NOT NULL,
  `date_created` varchar(20) NOT NULL,
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `rvl_user`
--

INSERT INTO `rvl_user` (`id`, `employee_id`, `employee_code`, `email_address`, `username`, `password`, `hash`, `secret_key`, `account_type`, `account_status`, `last_change_password`, `date_created`, `last_modified`) VALUES
(1, 1, 'rvl-000001', 'leoangelo.diaz@gmail.com', 'mrtongkatali', 'Hrkd0DA9ESsuOBsAwGxqmypGESd7Lg7MOi1EhHo5Rgy7dRIqTuAs7GRJkRLpLF5rG/lJW4F3B2JwIM5FXRGL7w==', 'sha256:1000:QyyAaGSLsQrY5EQccfu405Q8vQMLUfMP:xYK9IO6maddY6tfn/9QaeY35r9JiqlKK', '', 'Super Admin', 'Active', '', '2013-11-09 03:22:42', '2013-11-10 06:06:08'),
(13, 16, 'coordinator', 'coordinator@coordinator.com', 'coordinator', 'JYz0hetSzEnL6wWCqloOvA5KPWVEZs7iE/Lib9AoUAds3FAmzV1SOWH9iUOHEB6cy0qpVIHCVdoxBmaSuM/U+g==', 'sha256:1000:yB/WJP/4ateBI/1JZb9QjZXaUC4zuHOu:3aABtAwGf65Dpep8ZI19zPKes+mwXvB5', '', 'Coordinator', 'Active', '', '2013-11-13 09:15:46', '2013-11-13 13:15:46'),
(12, 15, 'driver-0002', 'nico.solis@rvl.com', 'nico.solis', 'MJqlXmYrkzXE33RQMri0PjVjq2oZipI6qHKN6TRScXWGjjGWoObI6whYOsDRl4GYjgRS9Q2nGDc+YOtXoOSxLw==', 'sha256:1000:shQ/D8HR8aujdmRxOUoFzxSLgxs/EWYu:LdTA7c0aZAcVEwGN51Moet9e91331Dh7', '', 'Driver', 'Active', '', '2013-11-11 11:22:08', '2013-11-11 15:22:08'),
(11, 14, 'DRIVER-0001', 'alvin.paderes@rvl.com', 'alvin.aileen', '70zKw57oXf/s/poaRBJuHqdQsfjj4ByPQ4tVnZgHrZ8rSGh3fW5xVFEeDngT8vvVAebZH43UbHyvdtwf/atKTw==', 'sha256:1000:4lOeFDQftbfedXEzBC0JkEasGWKOJ3zZ:E8BDgIBTXn4lP5QuvbIAnrnObhtSftJZ', '', 'Driver', 'Active', '', '2013-11-11 10:28:43', '2013-11-11 15:21:24'),
(14, 17, 'central.dispatcher', 'central.dispatcher@rvl.com', 'central.dispatcher', '+FczIgPxrZnnHktGiuF4tXLkjFHr1MCDv/U5hEGAyVAMbROgSPZmMtFIvB7e1BIvtqIo5vtT1coczS6t+CCs4w==', 'sha256:1000:4f7Phzi3MmDjIb3R6nmO14UV95unD6VF:FUjBNT9dpiuNE8DvHvZ0k/W06xTSRl4s', '', 'Central Dispatcher', 'Active', '', '2013-11-13 09:16:10', '2013-11-13 13:16:21'),
(15, 18, 'guard1', 'guard1@rvl.com', 'guard1', 'rYJRHvvwb0risXFsSsfCDbbfuZ9zo5GES1hu+JA2IvjmJbwDz7UdPlcOKRzUkfN5ee0BGWjqbg5cHw0+ZfA/MA==', 'sha256:1000:9ZPn8z+HRgYA5L4PaHGHqaZ9g+HDN5yk:r5PX4AN9QB8K1Vlxt8efeNeSxuKpOc/1', '', 'Guard', 'Active', '', '2013-11-13 09:17:33', '2013-11-13 13:17:33'),
(16, 19, 'guard2', 'guard2@rvl.com', 'guard2', 'NamEnnpMskB7dkfs4Olx7e4RQ3GxWbycsse8bAVS2ZvzRE2YhloAtVG590vUZLhe1/JjrUkYNMfmCgUD8HyY+A==', 'sha256:1000:L4R8i3AYjq58lQA5A/vQQ/r/76AhBp0W:6A0vVTfiDGNAFcz5xDk7VT25XeWnnMUP', '', 'Guard', 'Active', '', '2013-11-13 09:17:56', '2013-11-13 13:17:56'),
(17, 20, 'guard3', 'guard3@rvl.com', 'guard3', 'K96UFJS1R8p50h9KgvlN4POW5LfaEt/3wHQjm7ezRV5x7T/IY8keNspKSu/EPCZcdd+RclFOfan4Ahz5rVUlBQ==', 'sha256:1000:a9fjhrTmZzvir1R/NB/nJuRQTkgCr/mQ:NDxeK+6+f3IcMYsQPTVS0kxta5XB3JaH', '', 'Guard', 'Active', '', '2013-11-13 09:18:15', '2013-11-13 13:18:15'),
(18, 21, 'billing', 'billing@rvl.com', 'billing', 'WEK/XYlGK1ZxdOirFW2Chx19cff17w4BhamegkGCExMZ4RaNkJVFH4lQYUfkKyK9qD/JJJH53vH2KStTC+BSPQ==', 'sha256:1000:s3xsCJpWdDL1OV8FnWJmEYePhMB1c1ci:1bzGpYANzkdXNC0GfWv7z4gta3V50Fp/', '', 'Billing', 'Active', '', '2013-11-13 09:18:41', '2013-11-13 13:18:41'),
(19, 22, 'payroll.staff', 'payroll.staff@rvl.com', 'payroll.staff', 'Gfmdhvs466l2AGqIjfOmTuZeFgjwihW9kl3nSECwgENj+VPFcYCDRHnVzPtMf+dCuvjayE7MD1TVVthGKmFJmw==', 'sha256:1000:MUIm0NZnvMPUMSou/1ZoT5s+ndvEwgTe:upGt7v7ukoVfyUpz89Rv/C1LJOW465mG', '', 'Payroll', 'Active', '', '2013-11-13 09:21:24', '2013-11-13 13:21:24'),
(20, 23, '1005', 'nilo.barriaga@rvl.com', 'nilo.barriaga', '21/Qq/KP7eaefYmjBW1RrO1K2rDj/qBV7xAHFKX4IitGoQqt0dCEx6AV9YAegC1xIX0vQLed0+B3dIY1IZdpcg==', 'sha256:1000:NmszTJF/UTpGxV2jm0pQaXJrNfO7+eP1:0Aawczg77A3Woa0/wei9rYQFMzIN29wt', '', 'Driver', 'Active', '', '2013-12-17 09:23:19', '2013-12-17 01:23:19'),
(21, 24, '1008', 'eriberto.malacas@rvl.com', 'eriberto.malacas', 'BTVRRV4BpcXud8oiuzlMhmyRo/5ryyeRo8wfGYZufTPMC7CzzPPKiI1TTSYA1B/67T3skxYZ31vA4JD/qDxEFw==', 'sha256:1000:ZX4VGawZGA7IhkJ922AN4xF5kT0598+r:k4QMxKMienHqvUnE+7wdu3cg/TSdXQG4', '', 'Driver', 'Active', '', '2013-12-17 09:25:55', '2013-12-17 01:25:55'),
(22, 25, '1013', 'ismael.vermug@rvl.com', 'ismael.vermug', 'nRDLPxi0rczo1s2eM7nYe79LZhIYdPALSbnb3+KVOsoGny48FZayLo3gP5yTIc+Q7q6eyCkBKAoZje7egITUbQ==', 'sha256:1000:W5FnsZMiO2Vm8rvvF2F4U+V86bThgdqO:3IX2Gt/jQ9FKg8ZKwXAATGAAcpKaFlDL', '', 'Driver', 'Active', '', '2013-12-17 09:28:00', '2013-12-17 01:28:00'),
(23, 26, '1015', 'ceferrino.terrible@rvl.com', 'ceferrino.terrible', 'tuqyz8kZsGJz0d+xurTL50QO7BF9Kps2T+4cMSwxZZz0ZSwtFPNNPuPUUBh2rFq/1Nr6d6ZuOjmIvWOmlZPJFA==', 'sha256:1000:ft8mI30uz1IdN6Pl6r3LQlEq+3q82hol:JVo4oejOj/059Jp2eDvcrOdIOPHxA6Qy', '', 'Driver', 'Active', '', '2013-12-17 09:29:13', '2013-12-17 01:29:13'),
(24, 27, '1017', 'norberto.ilao@rvl.com', 'norberto.ilao', 'XT5tuWUWGI2z5iQNUFMdZN6me5/NK5fFA8e2sPZTy/3dqKypIM6m8g00e+dDhKhnQbxShZ+NnBR6s0FONNMSmA==', 'sha256:1000:jocZpQWqW9ccIx+Y5sp5hobQqNTtTTYz:Hrq7WtgtQ3P/1kUGdPIZp0seZ6fdBE8I', '', 'Driver', 'Active', '', '2013-12-17 09:30:03', '2013-12-17 01:30:03'),
(25, 28, '1020', 'numeriano.cadacio@rvl.com', 'numeriano.cadacio', 'XnYBrtLiVieAwS23ThX057+MAiUizZDZQR/CPGy8bkrrq/BYSfCcWRaEqoJto1NK34a05zmb6GWlc9QtfWD8sw==', 'sha256:1000:Z38bZ/8QlMJ6UYDUrl5b+x92I2Unvkoy:TzrY9/PJ+cWKB20rhPlqK9ifc0sjpKwd', '', 'Driver', 'Active', '', '2013-12-17 09:30:52', '2013-12-17 01:30:52'),
(26, 29, '1021', 'elmer.tagud@rvl.com', 'elmer.tagud', 'PyCnMB04TRMRj/D4QmZAqnGr0tUuSB8hg8KPCQCSMcmfsIO5Y21CLJxsdQ4ADpH5qqXyFKjYvFmRg3avgZI3DA==', 'sha256:1000:dKDh15vVgO9VMf1IVj4FbuyKTk4kcPhz:DHxCZC7XsXYa7OIB6VfJyiTLGKVviwP3', '', 'Driver', 'Active', '', '2013-12-17 09:32:03', '2013-12-17 01:32:03'),
(27, 30, '1023', 'ricardo.mayano@rvl.com', 'ricardo.mayano', 'C6WaIAGqNIUYqPlItyPVdOJJofZnQhS0jtTUayu4NZQBc8GmabqGXnrUJXTear5Bv7mqox+thsSX0ECh7n9rQw==', 'sha256:1000:ZSrxI9grFo2ILSuBwGBb3YAnkV2rB5SS:UuoS3EMk44txIMV0dm77ctz3zxWb2Nvx', '', 'Driver', 'Active', '', '2013-12-17 09:33:10', '2013-12-17 01:33:10'),
(28, 31, '1024', 'renato.ramos@rvl.com', 'renato.ramos', 'QpHOGvrRyEisRANLPuzusDN24OLajBFK/HOoIOtieGP/OsySjy+iycVVwSyeFs/NL3n49U/iMRembWQatC6KdQ==', 'sha256:1000:t+HtTPWt4ojzlE3xkdKRMDwOB1/aIP0z:cehvV+acOerL14kWtkethodxW78/5nbl', '', 'Driver', 'Active', '', '2013-12-17 09:34:03', '2013-12-17 01:34:03'),
(29, 32, '1028', 'edgardo.tuayon@rvl.com', 'edgardo.tuayon', 'oNPCafvQocBehKGFzpRO3/FMH98z9XCJf3aDuEWmTAg3S154vsiN+XvKTLyoVqaNztTR3Zs/2zY3y+zTo21+PA==', 'sha256:1000:XpngCItBGsww6GKkVHeyjEWFj/vZwgEl:VXLWD2gJXsAqhqWO8S+T4HkWr28q7fVv', '', 'Driver', 'Active', '', '2013-12-17 09:35:23', '2013-12-17 01:35:23'),
(30, 33, '1029', 'jayson.soriano@rvl.com', 'jayson.soriano', 'yIO7s6fgkjBW3hHDWqBGEtjwJ7C+m48edAVBvO6HsqJitC580STgxdPKA8ugcBFjxP9u9Ru8xaUigY9/lbkAIg==', 'sha256:1000:avJ8KjS8O5cOAGZF0XR9Hur9wb4lxShM:Lm2wXmPi6qZFQKXB83VL21F31DQ3XZNX', '', 'Driver', 'Active', '', '2013-12-17 09:36:12', '2013-12-17 01:36:12');

-- --------------------------------------------------------

--
-- Table structure for table `rvl_vehicle_color_list`
--

DROP TABLE IF EXISTS `rvl_vehicle_color_list`;
CREATE TABLE IF NOT EXISTS `rvl_vehicle_color_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `color` varchar(50) NOT NULL,
  `is_archive` varchar(10) NOT NULL COMMENT 'Yes / No',
  `date_created` varchar(20) NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_update_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `rvl_vehicle_color_list`
--

INSERT INTO `rvl_vehicle_color_list` (`id`, `color`, `is_archive`, `date_created`, `last_update`, `last_update_by`) VALUES
(1, 'Blue', 'No', '', '2013-09-18 07:38:52', 0),
(2, 'Red', 'No', '', '2013-09-18 07:38:52', 0),
(3, 'Yellow', 'No', '', '2013-09-18 07:38:52', 0),
(4, 'White', 'No', '', '2013-09-18 07:38:52', 0),
(5, 'Orange', 'No', '', '2013-09-18 07:38:52', 0),
(6, 'Gold', 'No', '', '2013-09-18 07:38:52', 0),
(7, 'Green', 'No', '', '2013-09-18 07:38:52', 0),
(8, 'Pink', 'No', '', '2013-09-18 07:38:52', 0),
(9, 'Black', 'No', '', '2013-09-18 07:38:52', 0),
(10, 'Silver', 'No', '', '2013-09-18 07:38:52', 0);

-- --------------------------------------------------------

--
-- Table structure for table `rvl_vehicle_model_list`
--

DROP TABLE IF EXISTS `rvl_vehicle_model_list`;
CREATE TABLE IF NOT EXISTS `rvl_vehicle_model_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(15) NOT NULL,
  `manufacturer` varchar(30) NOT NULL,
  `model_name` varchar(50) NOT NULL,
  `is_archive` varchar(10) NOT NULL COMMENT 'Yes / No',
  `date_created` varchar(20) NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_update_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `rvl_vehicle_model_list`
--

INSERT INTO `rvl_vehicle_model_list` (`id`, `category`, `manufacturer`, `model_name`, `is_archive`, `date_created`, `last_update`, `last_update_by`) VALUES
(1, 'Sedan', 'Mitsubishi', 'Mirage', 'No', '', '2013-09-24 10:40:05', 1),
(2, 'Sedan', 'Toyota', 'Corolla', 'No', '', '2013-09-24 10:40:05', 1),
(3, 'Sedan', 'Toyota', 'Prius', 'No', '', '2013-09-24 10:40:16', 1),
(4, 'Sedan', 'Toyota', 'Vios', 'No', '', '2013-09-24 10:40:16', 1),
(5, 'Sedan', 'Toyota', 'Yaris', 'No', '', '2013-09-24 10:40:17', 1),
(6, 'Sedan', 'Toyota', 'Camry', 'No', '', '2013-09-24 10:40:18', 1),
(7, 'Sedan', 'Toyota', 'FT86', 'No', '', '2013-09-24 10:40:19', 1),
(8, 'Sedan', 'Outsource-1', 'Eon', 'No', '', '2013-09-24 10:43:08', 1),
(9, 'Sedan', 'Outsource-1', 'Elantra', 'No', '', '2013-09-24 10:44:18', 1),
(10, 'Sedan', 'Outsource-1', 'Accent', 'No', '', '2013-09-24 10:44:23', 1),
(11, 'Sedan', 'Outsource-1', 'i10', 'No', '', '2013-09-24 10:44:27', 1),
(12, 'Sedan', 'Outsource-1', 'Getz', 'No', '', '2013-09-24 10:44:32', 1),
(13, 'Sedan', 'Outsource-1', 'Coupe', 'No', '', '2013-09-24 10:44:36', 1),
(14, 'Sedan', 'Honda', 'City', 'No', '', '2013-09-24 10:45:37', 1),
(15, 'Sedan', 'Honda', 'Civic', 'No', '', '2013-09-24 10:45:40', 1),
(16, 'Sedan', 'NYK Logistics', 'Mazda', 'No', '', '2013-09-24 10:46:36', 1),
(17, 'Sedan', 'NYK Logistics', 'Focus', 'No', '', '2013-09-24 10:46:37', 1),
(18, 'Sedan', 'NYK Logistics', 'Fiesta', 'No', '', '2013-09-24 10:46:39', 1);

-- --------------------------------------------------------

--
-- Table structure for table `rvl_vn_list`
--

DROP TABLE IF EXISTS `rvl_vn_list`;
CREATE TABLE IF NOT EXISTS `rvl_vn_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `delivery_receipt_id` int(11) NOT NULL,
  `vin_no` varchar(20) NOT NULL,
  `conduction_sticker_no` varchar(20) NOT NULL,
  `model` varchar(50) NOT NULL,
  `color` varchar(30) NOT NULL,
  `qty` varchar(10) NOT NULL,
  `settings` varchar(150) NOT NULL,
  `description` varchar(150) NOT NULL,
  `delivery_type` varchar(15) NOT NULL COMMENT 'Standard / Special',
  `date_created` varchar(20) NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_update_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rvl_warehouse_list`
--

DROP TABLE IF EXISTS `rvl_warehouse_list`;
CREATE TABLE IF NOT EXISTS `rvl_warehouse_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `warehouse_name` varchar(50) NOT NULL,
  `description` varchar(150) NOT NULL,
  `address` varchar(150) NOT NULL,
  `status` varchar(10) NOT NULL COMMENT 'Active / Inactive',
  `is_archive` varchar(10) NOT NULL COMMENT 'Yes / No',
  `date_created` varchar(20) NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `update_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
