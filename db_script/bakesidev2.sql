-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 31, 2023 at 04:41 PM
-- Server version: 8.0.34-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bakesidev2`
--

-- --------------------------------------------------------

--
-- Table structure for table `donations`
--

CREATE TABLE `donations` (
  `id` int NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_general_ci NOT NULL,
  `amount` double(10,2) NOT NULL,
  `clientid` varchar(120) COLLATE utf8mb4_general_ci NOT NULL,
  `mmtransid` varchar(120) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `wallet_network` varchar(120) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `wallet_number` varchar(120) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `payment_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mm_transactions`
--

CREATE TABLE `mm_transactions` (
  `id` int NOT NULL,
  `clienttransid` varchar(120) COLLATE utf8mb4_general_ci NOT NULL,
  `clientreference` varchar(120) COLLATE utf8mb4_general_ci NOT NULL,
  `telcotransid` varchar(120) COLLATE utf8mb4_general_ci NOT NULL,
  `transactionid` varchar(120) COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(120) COLLATE utf8mb4_general_ci NOT NULL,
  `statusdate` varchar(120) COLLATE utf8mb4_general_ci NOT NULL,
  `reason` char(120) COLLATE utf8mb4_general_ci NOT NULL,
  `recorded_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `progress`
--

CREATE TABLE `progress` (
  `ID` varchar(15) NOT NULL,
  `sessionId` varchar(100) NOT NULL,
  `option` varchar(30) DEFAULT NULL,
  `donor_name` varchar(120) DEFAULT NULL,
  `amount` varchar(20) DEFAULT NULL,
  `network` varchar(22) NOT NULL,
  `walletno` varchar(15) DEFAULT NULL,
  `volunteer_name` varchar(120) DEFAULT NULL,
  `age` varchar(20) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tracking`
--

CREATE TABLE `tracking` (
  `ID` varchar(15) NOT NULL,
  `sessionId` varchar(100) NOT NULL,
  `mode` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `time` datetime NOT NULL,
  `userData` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `track` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int NOT NULL,
  `clientid` varchar(120) COLLATE utf8mb4_general_ci NOT NULL,
  `ussdtrafficid` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `donor_name` varchar(120) COLLATE utf8mb4_general_ci NOT NULL,
  `amount` double(10,2) NOT NULL,
  `status` varchar(120) COLLATE utf8mb4_general_ci NOT NULL,
  `reference` varchar(120) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telcotransid` varchar(120) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `wallet_num` varchar(120) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `wallet_network` varchar(120) COLLATE utf8mb4_general_ci NOT NULL,
  `trans_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `volunteers`
--

CREATE TABLE `volunteers` (
  `id` int NOT NULL,
  `full_name` varchar(120) DEFAULT NULL,
  `mobile_number` varchar(120) NOT NULL,
  `age` int DEFAULT NULL,
  `email` varchar(120) NOT NULL,
  `volunteered_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mm_transactions`
--
ALTER TABLE `mm_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `progress`
--
ALTER TABLE `progress`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tracking`
--
ALTER TABLE `tracking`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `volunteers`
--
ALTER TABLE `volunteers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `donations`
--
ALTER TABLE `donations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mm_transactions`
--
ALTER TABLE `mm_transactions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `volunteers`
--
ALTER TABLE `volunteers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
