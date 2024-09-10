-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 10, 2024 at 08:19 PM
-- Server version: 8.0.39
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `saffee_raza_lifetrack`
--

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `type` enum('expense','income') COLLATE utf8mb4_general_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `type`, `amount`, `description`, `date`) VALUES
(7, 2, 'expense', 300.00, 'Food', '2024-09-10 15:52:11'),
(8, 2, 'income', 2000.00, 'Salary', '2024-09-08 15:52:25'),
(9, 2, 'expense', 100.00, 'Fuel', '2024-09-10 15:52:36'),
(10, 5, 'expense', 300.00, 'Test 2', '2024-09-10 15:57:51'),
(11, 5, 'expense', 400.00, 'Test 3', '2024-09-10 15:57:58'),
(12, 5, 'expense', 1200.00, 'Fuel 1', '2024-09-10 15:58:20'),
(13, 7, 'income', 2000.00, 'Salary', '2024-09-10 16:14:15'),
(14, 7, 'expense', 200.00, 'Food', '2024-09-10 16:14:23'),
(15, 7, 'expense', 100.00, 'Fuel', '2024-09-10 16:14:33'),
(16, 7, 'income', 5000.00, 'Freelance', '2024-09-10 16:14:50'),
(17, 7, 'expense', 10000.00, 'Car Buy', '2024-09-10 16:15:05');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(2, 'Admin', 'admin@gmail.com', '$2y$10$BzJ8jKC9xhe5R3XLfyU2Kuj8cOJcgO4M0ULwzf7Mzgnu9wXFBXJNS', 'admin', '2024-09-10 14:32:20'),
(5, 'Test 1', 'abc1@gmail.com', '$2y$10$sgNd3S03eiZCTQZhzU66O.8nwGH27VHXrs5WVkZ1IfoUK/J5KnWQe', 'user', '2024-09-10 15:56:48'),
(6, 'Test 2', 'abc2@gmail.com', '$2y$10$oM710Kr7fkvJXZ23YDu4U.yFt2vcieWXwNTM/3GVmZGb3VX.HtmCO', 'user', '2024-09-10 15:57:09'),
(7, 'Abcd', 'abc3@xyz.com', '$2y$10$6CCGzaRKLQN7YdCeDan8Leq6D4kzZ.noAhqzvLxd3BYuLUvpaLb6.', 'user', '2024-09-10 16:13:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
