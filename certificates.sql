-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2024 at 02:00 PM
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
-- Database: `halal_certificates`
--

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--

CREATE TABLE `certificates` (
  `certificate_no` int(100) NOT NULL,
  `Company_Name` varchar(50) NOT NULL,
  `Valid_Until` int(100) NOT NULL,
  `Product` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `certificates`
--

INSERT INTO `certificates` (`certificate_no`, `Company_Name`, `Valid_Until`, `Product`) VALUES
(1, '123', 2024, 'abc2'),
(23, '34', 2024, '43efds'),
(21321, 'swewqe', 2024, 'wedad'),
(21322, 'asdsa', 2024, 'asdas');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD UNIQUE KEY `Certificate Number` (`certificate_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `certificate_no` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21323;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
