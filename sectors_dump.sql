-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 29, 2022 at 12:00 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sectors`
--

-- --------------------------------------------------------

--
-- Table structure for table `sector`
--

CREATE TABLE `sector` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sector`
--

INSERT INTO `sector` (`id`, `name`, `value`, `parent`) VALUES
(1, 'Manufacturing', '1', NULL),
(2, 'Construction materials', '19', 1),
(3, 'Electronics and Optics', '18', 1),
(4, 'Food and Beverage', '6', 1),
(5, 'Bakery & confectionery products', '342', 4),
(6, 'Beverages', '43', 4),
(7, 'Fish & fish products ', '42', 4),
(8, 'Meat & meat products', '40', 4),
(9, 'Milk & dairy products ', '39', 4),
(10, 'Other', '437', 4),
(11, 'Sweets & snack food', '378', 4),
(12, 'Furniture', '13', 1),
(13, 'Bathroom/sauna ', '389', 12),
(14, 'Bedroom', '385', 12),
(15, 'Children’s room ', '390', 12),
(16, 'Kitchen ', '98', 12),
(17, 'Living room ', '101', 12),
(18, 'Office', '392', 12),
(19, 'Other (Furniture)', '394', 12),
(20, 'Outdoor ', '341', 12),
(21, 'Project furniture', '99', 12),
(22, 'Machinery', '12', 1),
(23, 'Machinery components', '94', 22),
(24, 'Machinery equipment/tools', '91', 22),
(25, 'Manufacture of machinery ', '224', 22),
(26, 'Maritime', '97', 22),
(27, 'Aluminium and steel workboats ', '271', 26),
(28, 'Boat/Yacht building', '269', 26),
(29, 'Ship repair and conversion', '230', 26),
(30, 'Metal structures', '93', 22),
(31, 'Other', '508', 22),
(32, 'Repair and maintenance service', '227', 22),
(33, 'Metalworking', '11', 1),
(34, 'Construction of metal structures', '67', 33),
(35, 'Houses and buildings', '263', 33),
(36, 'Metal products', '267', 33),
(37, 'Metal works', '542', 33),
(38, 'CNC-machining', '75', 37),
(39, 'Forgings, Fasteners ', '62', 37),
(40, 'Gas, Plasma, Laser cutting', '69', 37),
(41, 'MIG, TIG, Aluminum welding', '66', 37),
(42, 'Plastic and Rubber', '9', 1),
(43, 'Packaging', '54', 42),
(44, 'Plastic goods', '556', 42),
(45, 'Plastic processing technology', '559', 42),
(46, 'Blowing', '55', 45),
(47, 'Moulding', '57', 45),
(48, 'Plastics welding and processing', '53', 45),
(49, 'Plastic profiles', '560', 42),
(50, 'Printing ', '5', 1),
(51, 'Advertising', '148', 50),
(52, 'Book/Periodicals printing', '150', 50),
(53, 'Labelling and packaging printing', '145', 50),
(54, 'Textile and Clothing', '7', 1),
(55, 'Clothing', '44', 54),
(56, 'Textile', '45', 54),
(57, 'Wood', '8', 1),
(58, 'Other (Wood)', '337', 57),
(59, 'Wooden building materials', '51', 57),
(60, 'Wooden houses', '47', 57),
(61, 'Other', '3', NULL),
(62, 'Creative industries', '37', 61),
(63, 'Energy technology', '29', 61),
(64, 'Environment', '33', 61),
(65, 'Service', '2', NULL),
(66, 'Business services', '25', 65),
(67, 'Engineering', '35', 65),
(68, 'Information Technology and Telecommunications', '28', 65),
(69, 'Data processing, Web portals, E-marketing', '581', 68),
(70, 'Programming, Consultancy', '576', 68),
(71, 'Software, Hardware', '121', 68),
(72, 'Telecommunications', '122', 68),
(73, 'Tourism', '22', 65),
(74, 'Translation services', '141', 65),
(75, 'Transport and Logistics', '21', 65),
(76, 'Air', '111', 75),
(77, 'Rail', '114', 75),
(78, 'Road', '112', 75),
(79, 'Water', '113', 75);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sectors` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '(DC2Type:array)',
  `agree_to_terms` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `sectors`, `agree_to_terms`) VALUES
(8, 'UUUMAASN', 'a:1:{i:0;s:1:\"1\";}', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sector`
--
ALTER TABLE `sector`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sector`
--
ALTER TABLE `sector`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
