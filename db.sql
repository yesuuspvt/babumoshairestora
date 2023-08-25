-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 25, 2023 at 07:28 AM
-- Server version: 10.5.19-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u264078735_babumosairesto`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `status`, `created_at`) VALUES
(1, 'auguf', 1, '2023-08-11 07:56:07'),
(2, 'chineeses', 1, '2023-08-11 07:57:31');

-- --------------------------------------------------------

--
-- Table structure for table `orderitems`
--

CREATE TABLE `orderitems` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` float(11,2) NOT NULL DEFAULT 0.00,
  `product_amount` double(20,2) NOT NULL DEFAULT 0.00,
  `product_gst_percentage` float(10,2) NOT NULL,
  `product_gst_amount` float(10,2) NOT NULL,
  `product_amount_after_gst` double(20,2) NOT NULL,
  `is_kot_generated` tinyint(4) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `orderitems`
--

INSERT INTO `orderitems` (`id`, `order_id`, `user_id`, `product_id`, `quantity`, `product_amount`, `product_gst_percentage`, `product_gst_amount`, `product_amount_after_gst`, `is_kot_generated`, `status`, `created_at`) VALUES
(29, 14, 8, 1, 2.00, 50.00, 7.00, 3.50, 53.50, 1, 1, '2023-08-24 08:30:16'),
(28, 13, 8, 2, 4.00, 10.00, 5.00, 0.50, 10.50, 1, 1, '2023-08-24 08:25:31'),
(27, 13, 8, 1, 2.00, 50.00, 7.00, 3.50, 53.50, 1, 1, '2023-08-24 08:25:31'),
(26, 12, 8, 2, 10.00, 10.00, 5.00, 0.50, 10.50, 1, 1, '2023-08-21 02:52:57'),
(25, 12, 8, 3, 1.00, 260.00, 10.00, 26.00, 286.00, 1, 1, '2023-08-21 02:52:56'),
(24, 11, 8, 4, 1.00, 120.00, 10.00, 12.00, 132.00, 1, 1, '2023-08-21 02:16:29'),
(23, 11, 8, 1, 2.00, 50.00, 7.00, 3.50, 53.50, 1, 1, '2023-08-21 02:16:28'),
(22, 10, 8, 2, 1.00, 10.00, 5.00, 0.50, 10.50, 0, 1, '2023-08-20 00:00:00'),
(20, 10, 8, 1, 1.00, 50.00, 7.00, 3.50, 53.50, 1, 1, '2023-08-20 02:13:18'),
(21, 10, 8, 4, 2.00, 120.00, 10.00, 12.00, 132.00, 0, 1, '2023-08-20 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `invoice_no` varchar(255) DEFAULT NULL,
  `order_amount` double(20,2) NOT NULL DEFAULT 0.00,
  `discount_type` varchar(10) NOT NULL,
  `discount_percentage` float(10,2) NOT NULL,
  `discount_amount` double(20,2) NOT NULL DEFAULT 0.00,
  `gst_percentage` float(11,2) NOT NULL DEFAULT 0.00,
  `gst_amount` double(20,0) NOT NULL DEFAULT 0,
  `total_amount` double(20,2) NOT NULL DEFAULT 0.00,
  `total_amount_after_gst` double(20,2) NOT NULL,
  `payment_type` varchar(10) NOT NULL,
  `order_type` enum('PERCEL','TABLE') NOT NULL DEFAULT 'TABLE',
  `table_no` varchar(255) NOT NULL,
  `customer_name` int(255) DEFAULT NULL,
  `customer_mobile` varchar(15) DEFAULT NULL,
  `customer_address` text DEFAULT NULL,
  `customer_aadhar_no` varchar(20) DEFAULT NULL,
  `customer_pin` varchar(10) DEFAULT NULL,
  `is_order_final` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 for KOT Order, 1 for Final Order',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 = Pending, 1 = Completed',
  `created_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_id`, `invoice_no`, `order_amount`, `discount_type`, `discount_percentage`, `discount_amount`, `gst_percentage`, `gst_amount`, `total_amount`, `total_amount_after_gst`, `payment_type`, `order_type`, `table_no`, `customer_name`, `customer_mobile`, `customer_address`, `customer_aadhar_no`, `customer_pin`, `is_order_final`, `status`, `created_at`) VALUES
(14, 8, 'ORD14', '0000000014', 100.00, '', 0.00, 0.00, 0.00, 7, 100.00, 107.00, 'cash', 'TABLE', '1', 0, '', '', NULL, NULL, 0, 1, '2023-08-24 08:30:15'),
(13, 8, 'ORD13', '0000000013', 140.00, '', 0.00, 0.00, 0.00, 9, 140.00, 149.00, '', 'PERCEL', '', 0, '', '', NULL, NULL, 0, 1, '2023-08-24 08:25:29'),
(12, 8, 'ORD12', '0000000012', 360.00, '', 0.00, 0.00, 0.00, 31, 360.00, 391.00, '', 'PERCEL', '', 0, '', '', NULL, NULL, 0, 1, '2023-08-21 02:52:55'),
(11, 8, 'ORD11', '0000000011', 220.00, '', 0.00, 0.00, 0.00, 19, 220.00, 239.00, '', 'PERCEL', '', 0, '', '', NULL, NULL, 1, 1, '2023-08-21 02:16:28'),
(10, 8, 'ORD10', '0000000010', 300.00, '', 0.00, 20.00, 0.00, 28, 270.00, 270.00, '', 'PERCEL', '', 0, '', '', NULL, NULL, 1, 1, '2023-08-20 02:13:17');

-- --------------------------------------------------------

--
-- Table structure for table `productimages`
--

CREATE TABLE `productimages` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `productimages`
--

INSERT INTO `productimages` (`id`, `product_id`, `image`, `status`) VALUES
(3, 1, '1692099379_eaf6f20753d17456292c.jpg', 1),
(2, 2, '1692099332_961a5c07ab2e3cf32d14.jpg', 1),
(4, 3, '1692099433_4ff08f8847d34434a80a.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` float(11,2) NOT NULL DEFAULT 0.00,
  `gst` float(10,2) NOT NULL,
  `unit` float(10,2) NOT NULL,
  `is_available` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL,
  `modified_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `restaurant_id`, `category_id`, `name`, `description`, `price`, `gst`, `unit`, `is_available`, `created_at`, `modified_at`) VALUES
(1, 0, 1, 'egg roll', 'non veg', 50.00, 7.00, 5.00, 1, '2023-08-11 08:58:17', '2023-08-20 02:05:44'),
(2, 0, 1, 'momo', '', 10.00, 5.00, 50.00, 1, '2023-08-14 02:41:06', '2023-08-15 06:35:32'),
(3, 0, 1, 'chicken do pyaza', '', 260.00, 10.00, 1.00, 1, '2023-08-15 06:37:12', '2023-08-15 06:37:12'),
(4, 0, 2, 'chaumin', '', 120.00, 10.00, 1.00, 1, '2023-08-15 06:37:52', '2023-08-15 06:37:52');

-- --------------------------------------------------------

--
-- Table structure for table `restaurants`
--

CREATE TABLE `restaurants` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL,
  `modified_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `restaurants`
--

INSERT INTO `restaurants` (`id`, `name`, `address`, `image`, `status`, `created_at`, `modified_at`) VALUES
(1, 'Babumashai Restora , 1', 'hgfy', '', 1, '2023-08-11 08:56:52', '2023-08-11 08:56:52');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `role` varchar(255) NOT NULL,
  `shift` varchar(50) NOT NULL,
  `restaurant_id` int(11) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL,
  `modified_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `shift`, `restaurant_id`, `full_name`, `address`, `mobile`, `email`, `gender`, `is_active`, `created_at`, `modified_at`) VALUES
(1, 'admin', '$2y$10$Dnplk3bOhLNPSzwhE6nXxeeVY.w.gEzNJQ9jjwTMZN4Xy7IkmrBpu', 'Super_Admin', '', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2022-04-10 15:52:04', '2022-04-10 15:52:04'),
(4, 'tamluk', '$2y$10$0zc3eVUKDTEyBcSN4k2tiuJ5xN7l1F1Pq6BMO8KlzOyzXEpK2wAXW', 'User', '', NULL, 'Gopal Koley', 'sfsf', '3322445566', 'asc@we.hj', 'M', 1, '2022-04-19 10:00:52', '2023-08-12 01:45:37'),
(5, 'ujjal', '$2y$10$7Ez/ZO7gTWiATfdlLVdoneYdM1/80I.bLK3hxwUuHHbk8MBsIyUjO', 'User', '', NULL, 'Ujjal Koley', 'VILL - Padumbasan, PO - Tamluk, PS - Tamluk, Dist. - Purba Medinipur\r\nTest', '8159873780', 'yesuus11@gmail.com', 'M', 0, '2022-07-17 02:59:17', '2023-08-12 01:45:53'),
(7, 'soma', '$2y$10$7I0yzscyazNMFE1f9OZvP.vbG5AsdgKVwr76mAL52KmGTMYh4/3pO', 'Super_Admin', 'day', NULL, 'soma', 'Padumbasan\r\nManiktala\r\nTamluk', '7797166550', 'admin@mjlob.com', 'F', 1, '2023-08-12 00:58:22', '2023-08-14 02:49:44'),
(8, 'sura', '$2y$10$ssTEylzKP2nOHvVhjr6JuO1mExzPe4hZt/.e/38CE4jl1ivgsDlMy', 'User', 'day', NULL, 'sura', 'Banganagar, Falta, South 24 pgs', '7797166554', NULL, 'M', 1, '2023-08-14 02:50:42', '2023-08-14 02:50:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orderitems`
--
ALTER TABLE `orderitems`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `productimages`
--
ALTER TABLE `productimages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orderitems`
--
ALTER TABLE `orderitems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `productimages`
--
ALTER TABLE `productimages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
