-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 04, 2020 at 07:18 PM
-- Server version: 5.7.26
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mini_inventory_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `manufacturer_tb`
--

DROP TABLE IF EXISTS `manufacturer_tb`;
CREATE TABLE IF NOT EXISTS `manufacturer_tb` (
  `manufacturer_id` int(11) NOT NULL AUTO_INCREMENT,
  `manufacturer_name` varchar(255) NOT NULL,
  PRIMARY KEY (`manufacturer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `manufacturer_tb`
--

INSERT INTO `manufacturer_tb` (`manufacturer_id`, `manufacturer_name`) VALUES
(1, 'Tata Motors'),
(2, 'Maruti'),
(3, 'Hyundai'),
(4, 'Verna');

-- --------------------------------------------------------

--
-- Table structure for table `model_images`
--

DROP TABLE IF EXISTS `model_images`;
CREATE TABLE IF NOT EXISTS `model_images` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT,
  `model_id` varchar(255) NOT NULL,
  `image_path` varchar(1000) NOT NULL,
  PRIMARY KEY (`image_id`),
  KEY `model_id` (`model_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `model_tb`
--

DROP TABLE IF EXISTS `model_tb`;
CREATE TABLE IF NOT EXISTS `model_tb` (
  `model_id` varchar(11) NOT NULL,
  `model_name` varchar(255) NOT NULL,
  `model_color` varchar(255) NOT NULL,
  `model_manufacturer_year` int(11) NOT NULL,
  `registration_number` varchar(255) NOT NULL,
  `Note` text NOT NULL,
  `inventory` int(11) NOT NULL,
  `manufacturer_id` int(11) NOT NULL,
  PRIMARY KEY (`model_id`),
  KEY `manufacturer_id` (`manufacturer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `model_tb`
--

INSERT INTO `model_tb` (`model_id`, `model_name`, `model_color`, `model_manufacturer_year`, `registration_number`, `Note`, `inventory`, `manufacturer_id`) VALUES
('48104', 'Nano', 'yellow', 2015, '5678', 'Best in market', 1, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
