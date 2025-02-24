-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 14, 2025 at 01:11 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `annacowebpagedb`
--

-- --------------------------------------------------------
CREATE DATABASE annacowebpagedb;
USE annacowebpagedb;
--
-- Table structure for table `adminkeys`
--

CREATE TABLE `adminkeys` (
  `adminKey` text NOT NULL,
  `accesLevel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adminkeys`
--

INSERT INTO `adminkeys` (`adminKey`, `accesLevel`) VALUES
('nTlZB78omGNDnQp7itx5nU2ghxVqUhcpRy9GVz0wLLmcK', 10);

-- --------------------------------------------------------

--
-- Table structure for table `contactrequests`
--

CREATE TABLE `contactrequests` (
  `firstAndLastName` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phoneNumber` varchar(15) DEFAULT NULL,
  `requestDate` date DEFAULT NULL,
  `isContacted` tinyint(1) DEFAULT 0,
  `contactDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contactrequests`
--

INSERT INTO `contactrequests` (`firstAndLastName`, `email`, `phoneNumber`, `requestDate`, `isContacted`, `contactDate`) VALUES
('Example Example', 'example@example.ex', '123412341254', '2025-02-17', 0, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
