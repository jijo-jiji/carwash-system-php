-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 04, 2026 at 10:19 AM
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
-- Database: `carwash`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(6) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password`) VALUES
(1, 'admin', '12345');

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `branch_id` varchar(4) NOT NULL,
  `branch_name` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`branch_id`, `branch_name`) VALUES
('S1', 'CS Bangi'),
('S2', 'CS Kelang'),
('S3', 'CS Damansara'),
('S4', 'CS Putrajaya'),
('S5', 'CS Shah Alam'),
('S6', 'CS Kuala Lumpur');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `cust_id` int(3) NOT NULL,
  `cust_name` varchar(60) DEFAULT NULL,
  `cust_hp` varchar(15) DEFAULT NULL,
  `age` int(6) DEFAULT NULL,
  `gender` varchar(6) DEFAULT NULL,
  `work` varchar(20) DEFAULT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`cust_id`, `cust_name`, `cust_hp`, `age`, `gender`, `work`, `username`, `password`) VALUES
(1, 'azizi', '123456', 18, 'Male', 'SUV', 'Azizi_27', '123'),
(2, 'adan ', 'kim', 40, 'Female', 'MPV', 'adan123', '123');

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `Qid` int(3) NOT NULL,
  `Q1` varchar(20) DEFAULT NULL,
  `Q2` varchar(20) DEFAULT NULL,
  `Q3a` varchar(20) DEFAULT NULL,
  `Q3b` varchar(20) DEFAULT NULL,
  `Q3c` varchar(20) DEFAULT NULL,
  `Q3d` varchar(20) DEFAULT NULL,
  `Q3e` varchar(20) DEFAULT NULL,
  `Q3f` varchar(20) DEFAULT NULL,
  `cust_id` int(3) DEFAULT NULL,
  `branch_id` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`Qid`, `Q1`, `Q2`, `Q3a`, `Q3b`, `Q3c`, `Q3d`, `Q3e`, `Q3f`, `cust_id`, `branch_id`) VALUES
(1, '2-3 times a month', 'Full detailing', 'Most', 'Most', 'Most', 'Most', 'Most', 'Some', 1, 'S5'),
(2, '2-3 times a month', 'Full detailing', 'Most', 'Most', 'Most', 'Most', 'Most', 'Some', 1, 'S5'),
(3, '2-3 times a month', 'Full detailing', 'Most', 'Most', 'Most', 'Most', 'Most', 'Most', 1, 'S1'),
(4, '2-3 times a month', 'Full detailing', 'Most', 'Most', 'Most', 'Most', 'Most', 'Most', 1, 'S2'),
(5, 'First time', 'Basic wash', 'Most', 'Most', 'Most', 'Most', 'Most', 'Most', 2, 'S1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`branch_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`cust_id`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`Qid`),
  ADD KEY `cust_id` (`cust_id`),
  ADD KEY `branch_id` (`branch_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `cust_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `Qid` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`cust_id`) REFERENCES `customer` (`cust_id`),
  ADD CONSTRAINT `question_ibfk_2` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
