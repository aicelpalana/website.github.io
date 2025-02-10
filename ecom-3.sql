-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 10, 2025 at 04:39 AM
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
-- Database: `ecom`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`) VALUES
(5, 'Food', 'images/food.jpg'),
(6, 'Beauty Products', 'images/beauty.jpg'),
(7, 'Shoes', 'images/shoes.jpg'),
(8, 'Women Clothing', 'images/women.jpg'),
(9, 'Men Clothing', 'images/men.jpg'),
(10, 'Bags', 'images/bags.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'pending',
  `ordered_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `completed_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `seller_id`, `product_id`, `quantity`, `total_price`, `status`, `ordered_at`, `completed_at`) VALUES
(4, 8, 7, 6, 1, 20.00, 'Pending', '2025-02-10 01:19:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `product_name` text NOT NULL,
  `product_price` text NOT NULL,
  `product_description` text NOT NULL,
  `product_image` text NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `sale_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seller_products`
--

CREATE TABLE `seller_products` (
  `id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `product_name` text NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `product_description` text NOT NULL,
  `product_image` text NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seller_products`
--

INSERT INTO `seller_products` (`id`, `seller_id`, `product_name`, `product_price`, `product_description`, `product_image`, `category_id`, `created_at`, `updated_at`) VALUES
(6, 7, 'Chocolate Kitkat', 150.00, 'Coco', '../pages/images/472621554_1324259702331963_2849074956129842515_n.jpg', 5, '2025-02-10 00:45:17', '2025-02-10 01:28:11'),
(7, 7, 'Strawberry Kitkat', 140.00, 'Nestle mini', '../pages/images/473271565_1334809977940250_8431103907478647733_n.jpg', 5, '2025-02-10 01:15:49', '2025-02-10 01:15:49'),
(8, 7, 'Meiji Almond', 135.00, 'Meiji', '../pages/images/475481565_924105256380257_1973004592432136036_n.jpg', 5, '2025-02-10 01:17:04', '2025-02-10 01:17:04'),
(9, 7, 'Meiji Macadamia', 135.00, 'Meiji', '../pages/images/474891163_496901823431605_1334691321854452058_n.jpg', 5, '2025-02-10 03:14:51', '2025-02-10 03:14:51'),
(10, 7, 'Nike Heritage Waistpack Black', 999.00, 'Black', '../pages/images/475700373_601841079428391_2356215605140440548_n.jpg', 10, '2025-02-10 03:17:54', '2025-02-10 03:22:34'),
(11, 7, 'Nike Elemental Premium Backpack 21L', 1695.00, 'Black/Orange/Red', '../pages/images/474661336_1029923572515828_8797598761800823662_n.jpg', 10, '2025-02-10 03:19:27', '2025-02-10 03:19:27'),
(12, 7, 'Nike Hayward Backpack 26L', 2195.00, 'Black', '../pages/images/476755807_609587541845577_242734752012510391_n.jpg', 10, '2025-02-10 03:21:04', '2025-02-10 03:21:04'),
(13, 7, 'Nike Heritage Retro Fanny Pack 1L', 1095.00, 'Bkack', '../pages/images/476298559_1706159306663133_802103437054775109_n.jpg', 10, '2025-02-10 03:22:19', '2025-02-10 03:22:19');

-- --------------------------------------------------------

--
-- Table structure for table `type`
--

CREATE TABLE `type` (
  `id` int(11) NOT NULL,
  `type_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `type`
--

INSERT INTO `type` (`id`, `type_name`) VALUES
(1, 'Customer'),
(2, 'Seller');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` text NOT NULL,
  `password` text NOT NULL,
  `name` text NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `name`, `id`) VALUES
('medux', 'marie', '', 1),
('seller', 'jen', 'jenny', 2),
('aicel', '$2y$10$hh1PPOuTpyYifMfEHF54tuBpjG4tdqElgrVGp3jIhK2FDkSHDSAPO', '', 5),
('macy', '$2y$10$CDLs1VlVcQL385XLPBnKCOqSDnpF84mi4tyk74Q3LD2DRQmyp8elS', '', 6),
('jennifer', 'jen', '', 7),
('macyy', 'macy', '', 8);

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`id`, `user_id`, `type_id`) VALUES
(1, 6, 1),
(2, 7, 2),
(3, 8, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `cart_ibfk_2` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `seller_id` (`seller_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seller_id` (`seller_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `seller_products`
--
ALTER TABLE `seller_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seller_id` (`seller_id`),
  ADD KEY `seller_products_ibfk_2` (`category_id`);

--
-- Indexes for table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_type` (`user_id`,`type_id`),
  ADD KEY `type_id` (`type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seller_products`
--
ALTER TABLE `seller_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `type`
--
ALTER TABLE `type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `seller_products` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`product_id`) REFERENCES `seller_products` (`id`);

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `sales_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `seller_products` (`id`);

--
-- Constraints for table `seller_products`
--
ALTER TABLE `seller_products`
  ADD CONSTRAINT `seller_products_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `seller_products_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `user_type`
--
ALTER TABLE `user_type`
  ADD CONSTRAINT `user_type_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_type_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `type` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
