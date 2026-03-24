-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2026 at 07:14 AM
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
-- Database: `ecommerce_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `product_id`, `quantity`, `added_at`) VALUES
(1, 5, 2, '2026-03-24 06:04:07'),
(2, 16, 1, '2026-03-24 06:08:06'),
(3, 13, 1, '2026-03-24 06:08:08');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(20) DEFAULT NULL,
  `customer_address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `product_name`, `price`, `quantity`, `payment_method`, `order_date`, `customer_name`, `customer_phone`, `customer_address`) VALUES
(13, 'laptop', 30.00, 2, 'UPI', '2026-03-02 15:26:00', 'Deepika', '9100667529', 'Gudur'),
(14, 'Gaming Mouse', 25.00, 1, 'UPI', '2026-03-02 15:26:00', 'Deepika', '9100667529', 'Gudur'),
(15, 'laptop', 30.00, 1, 'UPI', '2026-03-03 03:45:28', 'raju', '215845131', 'Korimerla'),
(16, 'Gaming Mouse', 2000.00, 1, 'UPI', '2026-03-03 03:45:28', 'raju', '215845131', 'Korimerla'),
(17, 'pencil', 33.00, 1, 'UPI', '2026-03-03 03:45:28', 'raju', '215845131', 'Korimerla'),
(18, 'Mechanical Keyboard', 75.00, 2, 'UPI', '2026-03-03 03:45:28', 'raju', '215845131', 'Korimerla'),
(19, 'cricket bat', 50.00, 1, 'UPI', '2026-03-03 04:03:57', 'arun', '1234567890', 'Korimerla.'),
(20, 'Gaming Mouse', 2000.00, 1, 'UPI', '2026-03-03 04:03:57', 'arun', '1234567890', 'Korimerla.'),
(21, 'Mechanical Keyboard', 5000.00, 1, 'UPI', '2026-03-03 04:03:57', 'arun', '1234567890', 'Korimerla.'),
(22, 'Webcam HD', 100.00, 1, 'UPI', '2026-03-03 04:03:57', 'arun', '1234567890', 'Korimerla.'),
(23, 'cricket bat', 50.00, 2, 'COD', '2026-03-24 05:00:16', 'Praveen Bellamkonda', '9100667529', '42, Avadi-Vel Tech Road'),
(24, 'laptop', 30.00, 1, 'COD', '2026-03-24 05:00:16', 'Praveen Bellamkonda', '9100667529', '42, Avadi-Vel Tech Road'),
(25, 'Gaming Mouse', 2000.00, 1, 'COD', '2026-03-24 05:00:16', 'Praveen Bellamkonda', '9100667529', '42, Avadi-Vel Tech Road');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`) VALUES
(2, 'Webcam HD', 100.00, 'Webcam HD.jpg'),
(3, 'Mechanical Keyboard', 5000.00, 'Mechanical Keyboard.jpg'),
(4, 'pencil', 33.00, 'pencil.jpg'),
(5, 'laptop', 30.00, 'laptop.jpg'),
(13, 'USB-C Hub', 50.00, 'USB-C Hub.jpg'),
(14, 'Gaming Mouse', 2000.00, 'Gaming Mouse.jpg'),
(16, 'cricket bat', 50.00, 'cricket bat.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
