-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2026 at 06:58 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_real-estate`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'House'),
(2, 'Apartment'),
(3, 'Land');

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `property_id` int(11) NOT NULL,
  `property_name` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `location` varchar(150) NOT NULL,
  `category_id` int(11) NOT NULL,
  `status` enum('For Sale','For Rent') NOT NULL,
  `img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`property_id`, `property_name`, `price`, `location`, `category_id`, `status`, `img`) VALUES
(1, '', '0.00', '', 0, '', ''),
(2, 'New Apartment ', '99999999.99', '', 0, '', 'vanilla-frappe.jpg'),
(3, 'New Apartment ', '99999999.99', '', 0, '', 'vanilla-frappe.jpg'),
(4, 'New Apartment ', '99999999.99', '', 0, '', 'vanilla-frappe.jpg'),
(5, '', '0.00', '', 2, '', ''),
(6, '', '0.00', '', 2, '', ''),
(7, '', '0.00', '', 0, '', ''),
(8, '', '0.00', '', 0, '', ''),
(9, '', '0.00', '', 0, '', ''),
(10, 'Raphou Juice', '6.00', 'ytttytyetey', 2, '', 'vanilla-frappe.jpg'),
(11, 'Raphou Juice', '6.00', 'ytttytyetey', 2, '', 'vanilla-frappe.jpg'),
(12, 'Raphou Juice', '6.00', 'ytttytyetey', 2, '', 'vanilla-frappe.jpg'),
(13, 'Villa 30xd1', '5.00', 'New York', 2, '', 'Macha-Starbuck.jpg'),
(14, 'Condo_234xW', '23999999.00', 'South Korea', 2, '', 'K-Condo.jpg'),
(15, 'Condo_234xW', '23999999.00', 'South Korea', 2, '', 'K-Condo.jpg'),
(26, '56-hatari Aparment', '2320000.00', 'Phnom Penh', 2, '', '1768581120_Apartment.jpg'),
(27, '56-hatari Aparment', '2320000.00', 'Phnom Penh', 2, '', '1768581135_Apartment.jpg'),
(28, '56-hatari Aparment', '2320000.00', 'Phnom Penh', 2, '', '1768581161_Apartment.jpg'),
(29, '56-hatari Aparment', '2320000.00', 'Phnom Penh', 2, '', '1768581174_Apartment.jpg'),
(30, '56-hatari Aparment', '2320000.00', 'Phnom Penh', 2, '', '1768581199_Apartment.jpg'),
(31, '56-hatari Aparment', '2320000.00', 'Phnom Penh', 2, '', '1768581233_Apartment.jpg'),
(32, '56-hatari Aparment', '2320000.00', 'Phnom Penh', 2, '', '1768581251_Apartment.jpg'),
(33, '56-hatari Aparment', '2320000.00', 'Phnom Penh', 2, '', '1768581272_Apartment.jpg'),
(34, '56-hatari Aparment', '2320000.00', 'Phnom Penh', 2, '', '1768581305_Apartment.jpg'),
(35, '56-hatari Aparment', '2320000.00', 'Phnom Penh', 2, '', '1768581325_Apartment.jpg'),
(36, '56-hatari Aparment', '2320000.00', 'Phnom Penh', 2, '', '1768581341_Apartment.jpg'),
(37, '56-hatari Aparment', '2320000.00', 'Phnom Penh', 2, '', '1768581367_Apartment.jpg'),
(38, '56-hatari Aparment', '2320000.00', 'Phnom Penh', 2, '', '1768581380_Apartment.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `properties_details`
--

CREATE TABLE `properties_details` (
  `details_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `size` varchar(50) NOT NULL,
  `bedrooms` int(11) NOT NULL,
  `bathrooms` int(11) NOT NULL,
  `kitchen_rooms` int(11) NOT NULL,
  `dining_rooms` int(11) NOT NULL,
  `living_rooms` int(11) NOT NULL,
  `area` varchar(100) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbluser`
--

CREATE TABLE `tbluser` (
  `user_id` int(20) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `pws` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbluser`
--

INSERT INTO `tbluser` (`user_id`, `user_name`, `email`, `pws`) VALUES
(1, 'Raphou Phal', 'Raphou@gmail.com', 'Raphou.p$3030'),
(2, 'G-Dragon', 'g.dragron1988@gmail.com', 'dragon.#88gd');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `email`, `password`, `role`) VALUES
(1, 'admin', 'admin@gmail.com', '123456', 'admin'),
(2, 'jason', 'jason2005@gmail.com', 'jason@2025', ''),
(3, 'The Rock', 'rocky@gmail.com', 'rocky@123', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`property_id`);

--
-- Indexes for table `properties_details`
--
ALTER TABLE `properties_details`
  ADD PRIMARY KEY (`details_id`);

--
-- Indexes for table `tbluser`
--
ALTER TABLE `tbluser`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `property_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `properties_details`
--
ALTER TABLE `properties_details`
  MODIFY `details_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `user_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
