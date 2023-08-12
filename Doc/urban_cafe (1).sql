-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 25, 2022 at 05:04 AM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `urban_cafe`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `status`, `created_at`) VALUES
(2, 'Motton', 1, '2022-04-21 09:41:36'),
(3, 'Chiken', 1, '2022-04-21 09:41:47');

-- --------------------------------------------------------

--
-- Table structure for table `orderitems`
--

DROP TABLE IF EXISTS `orderitems`;
CREATE TABLE IF NOT EXISTS `orderitems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` float(11,2) NOT NULL DEFAULT '0.00',
  `product_amount` double(20,2) NOT NULL DEFAULT '0.00',
  `is_kot_generated` tinyint(4) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orderitems`
--

INSERT INTO `orderitems` (`id`, `order_id`, `user_id`, `product_id`, `quantity`, `product_amount`, `is_kot_generated`, `status`, `created_at`) VALUES
(16, 6, 4, 5, 1.00, 320.00, 1, 1, '2022-05-25 09:52:48'),
(15, 5, 4, 6, 1.00, 120.00, 1, 1, '2022-05-25 00:00:00'),
(3, 2, 4, 8, 1.00, 633.00, 0, 1, '2022-05-05 09:07:37'),
(4, 2, 4, 7, 1.00, 80.00, 0, 1, '2022-05-05 09:07:37'),
(18, 7, 4, 8, 1.00, 633.00, 1, 1, '2022-05-25 10:45:18'),
(17, 6, 4, 6, 2.00, 120.00, 1, 1, '2022-05-25 09:52:48'),
(7, 3, 4, 6, 1.00, 120.00, 0, 1, '2022-05-08 09:18:28'),
(8, 4, 4, 7, 1.00, 80.00, 0, 1, '2022-05-10 08:48:48'),
(9, 4, 4, 8, 1.00, 633.00, 0, 1, '2022-05-10 08:48:48'),
(10, 5, 4, 5, 2.00, 320.00, 1, 1, '2022-05-10 09:10:55'),
(13, 5, 4, 7, 2.00, 80.00, 1, 0, '2022-05-23 00:00:00'),
(12, 5, 4, 3, 2.00, 500.00, 1, 1, '2022-05-10 09:10:55'),
(19, 7, 4, 3, 1.00, 500.00, 1, 1, '2022-05-25 10:45:18'),
(20, 4, 4, 3, 3.00, 500.00, 0, 1, '2022-05-26 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `invoice_no` varchar(255) DEFAULT NULL,
  `order_amount` double(20,2) NOT NULL DEFAULT '0.00',
  `discount_amount` double(20,2) NOT NULL DEFAULT '0.00',
  `gst_percentage` float(11,2) NOT NULL DEFAULT '0.00',
  `gst_amount` double(20,0) NOT NULL DEFAULT '0',
  `total_amount` double(20,2) NOT NULL DEFAULT '0.00',
  `order_type` enum('PERCEL','TABLE') NOT NULL DEFAULT 'TABLE',
  `table_no` varchar(255) NOT NULL,
  `customer_name` int(255) DEFAULT NULL,
  `customer_mobile` varchar(15) DEFAULT NULL,
  `customer_address` text,
  `customer_aadhar_no` varchar(20) DEFAULT NULL,
  `customer_pin` varchar(10) DEFAULT NULL,
  `is_order_final` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 for KOT Order, 1 for Final Order',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 = Pending, 1 = Completed',
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_id`, `invoice_no`, `order_amount`, `discount_amount`, `gst_percentage`, `gst_amount`, `total_amount`, `order_type`, `table_no`, `customer_name`, `customer_mobile`, `customer_address`, `customer_aadhar_no`, `customer_pin`, `is_order_final`, `status`, `created_at`) VALUES
(6, 4, 'ORD6', '0000000006', 560.00, 60.00, 0.00, 0, 500.00, 'TABLE', '5', 0, '', '', NULL, NULL, 0, 1, '2022-05-25 09:52:48'),
(2, 4, 'ORD2', '0000000002', 713.00, 0.00, 0.00, 0, 713.00, 'TABLE', '5', 0, '', '', NULL, NULL, 1, 1, '2022-05-05 09:07:37'),
(3, 4, 'ORD3', '0000000003', 1260.00, 0.00, 0.00, 0, 1260.00, 'TABLE', '5', 0, '', '', NULL, NULL, 0, 1, '2022-05-08 09:18:28'),
(4, 4, 'ORD4', '0000000004', 2213.00, 0.00, 0.00, 0, 2213.00, 'TABLE', '6', 0, '', '', NULL, NULL, 0, 1, '2022-05-10 08:48:48'),
(5, 4, 'ORD5', '0000000005', 1920.00, 100.00, 0.00, 0, 1820.00, 'TABLE', '9', 0, '', '', NULL, NULL, 1, 1, '2022-05-10 09:10:55'),
(7, 4, 'ORD7', '0000000007', 1133.00, 33.00, 0.00, 0, 1100.00, 'PERCEL', '', 0, '', '', NULL, NULL, 1, 1, '2022-05-25 10:45:18');

-- --------------------------------------------------------

--
-- Table structure for table `productimages`
--

DROP TABLE IF EXISTS `productimages`;
CREATE TABLE IF NOT EXISTS `productimages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `productimages`
--

INSERT INTO `productimages` (`id`, `product_id`, `image`, `status`) VALUES
(11, 5, '1650461396_6455f4d8f642a9df88ff.jpg', 1),
(5, 3, '1650294375_2ecf8b8be158fa872fb6.jpg', 1),
(6, 3, '1650294375_81c8b6a6265d8a8c9440.png', 1),
(10, 5, '1650461396_6a0282993e22183577c6.png', 1),
(12, 6, '1650461418_3f836b064bbec9fe77e8.jpg', 1),
(13, 6, '1650461418_1454f605e590612e52fd.jpg', 1),
(14, 7, '1650553214_1d991e6b3e5e6ad56bad.png', 1),
(15, 8, '1650870280_fda879020c57469f5612.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `restaurant_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` float(11,2) NOT NULL DEFAULT '0.00',
  `is_available` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `modified_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `restaurant_id`, `category_id`, `name`, `description`, `price`, `is_available`, `created_at`, `modified_at`) VALUES
(3, 1, 2, 'abc', 'testing....', 500.00, 1, '2022-04-18 10:06:15', '2022-04-25 02:03:04'),
(5, 1, 2, 'ss', 'sdasd', 320.00, 1, '2022-04-20 08:29:56', '2022-04-25 02:03:51'),
(6, 1, 3, 'test', 'sdfsf', 120.00, 1, '2022-04-20 08:30:18', '2022-04-25 02:04:02'),
(7, 1, 2, 'Motton Jhol', 'sfsfsf', 80.00, 1, '2022-04-21 10:00:14', '2022-04-25 02:04:10'),
(8, 1, 2, 'sfsf', 'sfdsdfsf', 633.00, 1, '2022-04-25 02:04:40', '2022-04-25 02:04:40');

-- --------------------------------------------------------

--
-- Table structure for table `restaurants`
--

DROP TABLE IF EXISTS `restaurants`;
CREATE TABLE IF NOT EXISTS `restaurants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `modified_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `restaurants`
--

INSERT INTO `restaurants` (`id`, `name`, `address`, `image`, `status`, `created_at`, `modified_at`) VALUES
(1, 'Urban Cafe', 'sfsf', '1649765822_7b1e33c9a0c1fb1766f2.jpg', 1, '2022-04-12 07:17:02', '2022-04-13 09:37:17'),
(5, 'Night Cafe', 'Kolkata', '1649862299_dc372be525fd48a8e759.png', 1, '2022-04-13 09:37:58', '2022-04-13 10:04:59');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `role` varchar(255) NOT NULL,
  `restaurant_id` int(11) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `address` text,
  `mobile` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `modified_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `restaurant_id`, `full_name`, `address`, `mobile`, `email`, `gender`, `is_active`, `created_at`, `modified_at`) VALUES
(1, 'admin', '$2y$10$Dnplk3bOhLNPSzwhE6nXxeeVY.w.gEzNJQ9jjwTMZN4Xy7IkmrBpu', 'Super_Admin', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2022-04-10 15:52:04', '2022-04-10 15:52:04'),
(4, 'tamluk', '$2y$10$0zc3eVUKDTEyBcSN4k2tiuJ5xN7l1F1Pq6BMO8KlzOyzXEpK2wAXW', 'Admin', 1, 'Gopal Koley', 'sfsf', '3322445566', 'asc@we.hj', 'M', 1, '2022-04-19 10:00:52', '2022-04-19 10:00:52');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
