-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 02, 2020 at 09:21 AM
-- Server version: 10.3.22-MariaDB-0ubuntu0.19.10.1
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ucctest`
--

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `vehicle_id` int(5) NOT NULL,
  `vehicle_no` char(20) NOT NULL,
  `vehicle_name` varchar(100) NOT NULL,
  `category` enum('motorcycle','cars','truck') NOT NULL,
  `engine_displacement_cc` float NOT NULL,
  `engine_displacement_liter` float NOT NULL,
  `engine_displacement_inc` float NOT NULL,
  `engine_power` int(5) NOT NULL,
  `price` double NOT NULL,
  `currency` varchar(5) NOT NULL,
  `location` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`vehicle_id`, `vehicle_no`, `vehicle_name`, `category`, `engine_displacement_cc`, `engine_displacement_liter`, `engine_displacement_inc`, `engine_power`, `price`, `currency`, `location`) VALUES
(16, '450AM', 'BMW X1', 'cars', 1500, 1.5, 91536, 140, 35200, 'USD', 'US'),
(17, '450SRM', 'Dodge Challenger', 'cars', 5700, 5.7, 347837, 345, 34295, 'USD', 'US');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`vehicle_id`),
  ADD UNIQUE KEY `vehicle_no` (`vehicle_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `vehicle_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
