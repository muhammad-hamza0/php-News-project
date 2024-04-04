-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 04, 2024 at 09:45 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `news-site`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `post` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `post`) VALUES
(42, 'Sports', 3),
(40, 'Entertainment', 5),
(41, 'Politics', 2);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `post_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `category` varchar(100) NOT NULL,
  `post_date` varchar(50) NOT NULL,
  `author` int(11) NOT NULL,
  `post_img` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_id`, `title`, `description`, `category`, `post_date`, `author`, `post_img`) VALUES
(71, 'Nisi natus atque vel', 'Fugiat ratione anim', '41', '03 Apr, 2024', 29, '1712143938-1712142115-Rectangle 319 (1).png'),
(72, 'Laborum Omnis dolor', 'Quia quisquam et rer', '41', '03 Apr, 2024', 29, '1712143945-image 39.png'),
(73, 'Duis ad dicta tempor', 'Quia velit qui volup', '40', '03 Apr, 2024', 29, '1712143951-1712142115-Rectangle 319 (1).png'),
(51, 'Post 2', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer', '42', '26 Mar, 2024', 25, 'image 39.png'),
(50, 'Post 1', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer', '40', '26 Mar, 2024', 25, 'service-details__benefits-img.jpg (2).png'),
(49, 'testing2', 'testing2testing2testing2', '40', '26 Mar, 2024', 25, 'image 38.png'),
(74, 'Similique sit esse n', 'Sunt sunt animi vol', '40', '03 Apr, 2024', 29, '1712144308-1712142115-Rectangle 319 (1).png'),
(75, 'Sed molestias nesciu', 'Velit modi nemo volu', '40', '03 Apr, 2024', 29, '1712144316-1712142680-icons8-approval-96 1.png'),
(76, 'Reprehenderit corpo', 'Et enim cupidatat fu', '42', '03 Apr, 2024', 29, '1712144322-image 38.png'),
(77, 'Totam commodi libero', 'Deleniti adipisicing', '42', '03 Apr, 2024', 29, '1712144344-service-details__benefits-img.jpg (2).png');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `logo_img` varchar(200) NOT NULL,
  `footer_description` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`logo_img`, `footer_description`) VALUES
('news.jpg', '© Copyright 2024 All right reserved Muhammad Hamza');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(40) DEFAULT NULL,
  `role` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `last_name`, `username`, `password`, `role`) VALUES
(25, 'muhammad', 'hamza', 'hamzaamin', '30f64f3171b1fa24a1698bdf0b435b19', 1),
(26, 'waqas', 'khan', 'waqas', '81dc9bdb52d04dc20036dbd8313ed055', 0),
(27, 'Jacob Wade', 'Scott Crane', 'Ab in iusto magni qu', 'f3ed11bbdb94fd9ebdefbaf646ab94d3', 1),
(28, 'Fallon Blair', 'Tasha Jenkins', 'Non rem cum voluptat', 'f3ed11bbdb94fd9ebdefbaf646ab94d3', 1),
(29, 'ezhar', 'karin', 'ezhar karim', '81dc9bdb52d04dc20036dbd8313ed055', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`),
  ADD UNIQUE KEY `post_id` (`post_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
