-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 31, 2021 at 08:54 AM
-- Server version: 8.0.25-0ubuntu0.20.04.1
-- PHP Version: 7.1.33-37+ubuntu20.04.1+deb.sury.org+1
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `oopmvc`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";




DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `price` varchar(20) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `fullname`, `description`, `price`, `photo`, `category`) VALUES
(14, 'Modi Bixa 1', '61 Le Van Si - Hoa Minh -Lien Chieu', '+84123456789', '142057575862770.jpg', '04T2'),
(15, 'Modi bixa 23', '61 Le Van Si - Hoa Minh -Lien Chieu', '+84123456789', '142057577628814.jpg', '04T1'),
(16, 'Modi bixa 3', '61 Le Van Si - Hoa Minh -Lien Chieu', '+84123456789', '142057579643359.jpg', '04T2'),
(19, 'softdevelop test', '61 Le Van Si - Hoa Minh -Lien Chieu', '0976565434', '158918913571045.jpg', '45'),
(20, 'modi bixa', '61 Le Van Si - Hoa Minh -Lien Chieu', '+84123456789', '162153916635162.jpeg', '1234');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
