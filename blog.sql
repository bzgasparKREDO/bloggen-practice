-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 19, 2022 at 03:22 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `account_id` int(11) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(1) NOT NULL DEFAULT 'U'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`account_id`, `username`, `password`, `role`) VALUES
(1, 'bzgaspar', '$2y$10$wSHIJEU.vjUp8YfupPYJz.kaLE9wpxtOcu05pk52AqhnaU2Z7y0Q.', 'A'),
(2, 'mjvb', '$2y$10$LAUSa.QiqVdCahZg7w.5YuUC66QJgQH5.q77kN9SOj1iLH5d5Oc9e', 'U'),
(3, 'eunice', '$2y$10$PnM4lD9vPx3Ezg/DRa.V4uMFGwyPPEVEbUm11lLFPk49AeC7E8rrm', 'U'),
(8, 'kyleJ', '$2y$10$9aZ0B.jLNIRWUips692Xi.KCoMlXthGURICpWAaviIvweFTlE9x/2', 'U');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Gaming'),
(12, 'Travel'),
(20, 'Environment');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `post_title` varchar(45) NOT NULL,
  `date_posted` date NOT NULL,
  `category_id` int(11) NOT NULL,
  `post_message` text NOT NULL,
  `account_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `post_title`, `date_posted`, `category_id`, `post_message`, `account_id`) VALUES
(1, 'dsadasdasdas', '2022-09-16', 1, 'dasdasdasdasdsa', 1),
(2, 'dasdasdasdas updated3', '2022-09-15', 1, 'dasdasdasdas', 2),
(3, 'dasdasd asdsad 23123', '2022-09-17', 1, 'dasdsadsadasdsa', 2),
(5, 'Forest', '2022-09-19', 12, 'Into the woods', 1),
(6, 'sdasdasdasds 2', '2022-09-17', 12, 'dasdasdasdasdas', 1),
(8, 'River', '2022-09-20', 20, 'Cagayan River', 1),
(9, 'Youtube', '2022-09-18', 13, 'A lot of Bloggers are on youtube', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `contact_number` varchar(45) NOT NULL,
  `address` varchar(45) NOT NULL,
  `avatar` varchar(45) DEFAULT NULL,
  `account_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `contact_number`, `address`, `avatar`, `account_id`) VALUES
(1, 'BILL ZHEDRICK', 'GASPAR', '1234567890', 'Philippines', 'Bill Zhedrick A. Gaspar2.jpg', 1),
(2, 'MARYJANE', 'BARACAO', '1234567890', 'Isabela', NULL, 2),
(3, 'eunice', 'gaspar', '12312312312312', 'Isabela', NULL, 3),
(4, 'BILL ZHEDRICK1', 'GASPAR1', '12345678901', 'Isabela1', NULL, 4),
(8, 'kyle', 'jaham', '1234567890', 'Brazil', NULL, 8),
(9, 'kyle', 'jaham', '1234567890', 'Philippines', NULL, 9);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`account_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
