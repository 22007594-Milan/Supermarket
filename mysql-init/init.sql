-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2025 at 08:25 AM
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
-- Database: `supermarket`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `product_id`, `quantity`, `created_at`) VALUES
(26, 10, 7, 2, '2025-05-14 19:26:01');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `shipping_address` text DEFAULT NULL,
  `status` enum('Pending','Processing','Shipped','Delivered','Cancelled') DEFAULT 'Pending',
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_method` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_amount`, `shipping_address`, `status`, `date`, `payment_method`, `created_at`) VALUES
(1, 10, NULL, NULL, 'Pending', '2025-05-11 21:22:38', '', '2025-05-13 02:18:58'),
(2, 10, NULL, NULL, 'Pending', '2025-05-11 21:22:46', '', '2025-05-13 02:18:58'),
(4, 10, NULL, NULL, 'Pending', '2025-05-11 21:25:52', '', '2025-05-13 02:18:58'),
(5, 10, 5.00, 'Woodlands drive 60', 'Pending', '2025-05-11 21:31:02', '', '2025-05-13 02:18:58'),
(6, 10, NULL, 'Woodlands drive 60', 'Shipped', '2025-05-11 21:31:08', '', '2025-05-13 02:18:58'),
(7, 10, 5.00, 'Woodlands drive 60', 'Pending', '2025-05-11 21:31:33', '', '2025-05-13 02:18:58'),
(8, 10, 10.00, 'Woodlands drive 60', 'Delivered', '2025-05-11 21:32:09', '', '2025-05-13 02:18:58'),
(9, 10, 5.00, 'Woodlands drive 60', 'Pending', '2025-05-11 21:32:40', '', '2025-05-13 02:18:58'),
(10, 10, 10.00, 'HI', 'Pending', '2025-05-12 17:43:40', '', '2025-05-13 02:18:58'),
(11, 10, 5.00, 'YUGUKHB', 'Pending', '2025-05-12 17:44:41', '', '2025-05-13 02:18:58'),
(13, 10, 10.00, 'WOODLANDS SJHX', 'Pending', '2025-05-12 18:19:12', 'Credit Card', '2025-05-13 02:19:12'),
(14, 10, 15.00, 'JEDBKJ', 'Pending', '2025-05-12 18:22:24', 'Credit Card', '2025-05-13 02:22:24'),
(15, 10, 5.00, 'MILAN', 'Delivered', '2025-05-12 18:27:53', 'Credit Card', '2025-05-13 02:27:53'),
(16, 10, 10.00, 'hfcxj', 'Shipped', '2025-05-12 18:44:31', 'Credit Card', '2025-05-13 02:44:31'),
(17, 12, 5.00, 'admiralry', 'Cancelled', '2025-05-14 17:23:54', 'Credit Card', '2025-05-15 01:23:54'),
(18, 10, 11.60, 'kdejeldn', 'Delivered', '2025-05-14 18:18:08', 'Credit Card', '2025-05-15 02:18:08'),
(19, 12, 5.60, 'sjwsxjbhsaw', 'Pending', '2025-05-14 18:21:44', 'Credit Card', '2025-05-15 02:21:44'),
(20, 10, 13.40, 'ekjfc', 'Pending', '2025-05-14 18:52:09', 'Credit Card', '2025-05-15 02:52:09'),
(21, 10, 7.20, 'sdlj', 'Pending', '2025-05-14 18:52:54', 'Credit Card', '2025-05-15 02:52:54'),
(22, 10, 7.20, 'kuhio', 'Pending', '2025-05-14 18:54:58', 'Credit Card', '2025-05-15 02:54:58'),
(23, 10, 11.20, 'iygohop;', 'Pending', '2025-05-14 19:06:17', 'Credit Card', '2025-05-15 03:06:17'),
(24, 10, 5.00, 'edlcie', 'Cancelled', '2025-05-14 19:06:41', 'Credit Card', '2025-05-15 03:06:41'),
(25, 10, 11.20, 'iy7t7', 'Cancelled', '2025-05-14 19:12:13', 'Credit Card', '2025-05-15 03:12:13'),
(26, 10, 5.00, 'uho8i', 'Cancelled', '2025-05-14 19:25:13', 'Credit Card', '2025-05-15 03:25:13'),
(27, 10, 6.60, 'ae;ldea', 'Cancelled', '2025-05-14 19:25:43', 'Credit Card', '2025-05-15 03:25:43'),
(28, 10, 5.00, 'kfkerfk', 'Cancelled', '2025-05-14 20:12:03', 'Credit Card', '2025-05-15 04:12:03');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(3, 15, 4, 1, 5.00),
(4, 16, 4, 2, 5.00),
(5, 17, 4, 1, 5.00),
(6, 18, 4, 1, 5.00),
(7, 18, 7, 3, 2.20),
(8, 19, 8, 1, 5.60),
(9, 20, 7, 1, 2.20),
(10, 20, 8, 2, 5.60),
(11, 21, 4, 1, 5.00),
(12, 21, 7, 1, 2.20),
(13, 22, 4, 1, 5.00),
(14, 22, 7, 1, 2.20),
(15, 23, 8, 2, 5.60),
(16, 24, 4, 1, 5.00),
(17, 25, 8, 2, 5.60),
(18, 26, 4, 1, 5.00),
(19, 27, 7, 3, 2.20),
(20, 28, 4, 1, 5.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `stock` int(11) DEFAULT 0,
  `category` varchar(50) NOT NULL DEFAULT 'Fruit'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `stock`, `category`) VALUES
(4, 'APPLE', NULL, 5.00, 'Screenshot 2025-05-01 190826.png', -3, 'Fruit'),
(7, 'Onion', NULL, 2.20, 'Screenshot 2025-05-15 021555.png', 0, 'Vegetable'),
(8, 'Milk', NULL, 5.60, 'Screenshot 2025-05-15 021700.png', 0, 'Dairy');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','student') DEFAULT 'student',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `verification_code` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`, `verification_code`) VALUES
(2, 'Milan Shaju Kannai', 'abc@gmail.com', '$2y$10$Yg.cC7PJKx5Gh/JQ4DT3IOd.q1AEdem7sDqLNszfP3N5NGE8GZpQe', 'admin', '2025-04-29 03:03:50', ''),
(3, 'Milan Shaju Kannai', 'abcd@gmail.com', '$2y$10$twmrCyzdFNQCJTipC3bS5..wChtcxnb.mnT9dmvM57lQweJnDK0BC', 'student', '2025-04-29 03:10:41', ''),
(4, 'abc', 'def@gmail.com', '$2y$10$keu7E1a6OqoIpNhe2CKyFerCBmH8n26D91Uus9PLj.0GdEFsMA8D.', 'student', '2025-04-29 03:55:15', ''),
(5, 'Milan Shaju ', 'efg@gmail.com', '$2y$10$5aX.RTE5KViLv5p2qHW5zu0biGGhdKfZERAEtvPQW5lyB3POk6XeO', 'admin', '2025-05-01 10:35:19', NULL),
(6, 'def', 'defgh@gmail.com', '$2y$10$cd80W7a4039tVfZU79F4N.ZQ3eVT5aWWz6R2QTNagv.UZfbwmh3dW', 'student', '2025-05-01 11:32:52', ''),
(7, 'milan', 'milan@gmail.com', '$2y$10$SXcioecwJ7Cpt.zUtp3UTuoAx8vm34/Lgyq0jF4a6f7ifj0q3y2Jy', 'student', '2025-05-06 07:26:21', ''),
(10, 'Alex', 'milanshajukannai16@gmail.com', '$2y$10$ki0RFZFWZzYdSUqCXv9Cm.oB5wLWnb45YpPjLyq.tRgYHd4FNtY5e', 'student', '2025-05-11 20:29:48', NULL),
(11, 'Milan Shaju', 'milanshaju12@gmail.com', '$2y$10$LJ6e/7zJvXdFIg53/1sTQunamQb99OxfUchEkI1NPc.ua4oAyE.aC', 'admin', '2025-05-11 21:43:29', NULL),
(12, 'robert', '22007594@myrp.edu.sg', '$2y$10$3Gpbw4r7HSvfn4w9CL.bBOQDBNerm0QGFGGSb14LlZbxTBFYbbB3q', 'student', '2025-05-14 17:22:05', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `carts_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;