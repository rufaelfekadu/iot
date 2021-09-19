-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 19, 2021 at 09:44 PM
-- Server version: 8.0.26-0ubuntu0.20.04.2
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `iot`
--

-- --------------------------------------------------------

--
-- Table structure for table `appliance`
--

CREATE TABLE `appliance` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `office_id` int DEFAULT NULL,
  `appiance_type_id` int DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gpio_pin` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appliance`
--

INSERT INTO `appliance` (`id`, `name`, `status`, `office_id`, `appiance_type_id`, `location`, `gpio_pin`) VALUES
(7, 'fan', 0, 1, NULL, 'here', 5);

-- --------------------------------------------------------

--
-- Table structure for table `appliance_type`
--

CREATE TABLE `appliance_type` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `office`
--

CREATE TABLE `office` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `office`
--

INSERT INTO `office` (`id`, `name`, `description`) VALUES
(1, 'library', NULL),
(2, 'outdoor', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `office_id` int DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `roles`, `password`, `office_id`, `first_name`, `last_name`) VALUES
(1, 'robel', '[\"ROLE_ADMIN\"]', '$2y$13$0HAmEMAduobjteSQlWNefuX3qpqXxPfpTkLZ.MP9vLHvM4UDKW6va', 1, '', ''),
(8, 'samuel', '[]', '$2y$13$NDqLiSmO.nm8QqEJymkrzuKlimoFObUicRbb4HnA7sDw7Yzh7as9y', 1, '', ''),
(9, 'abebe.kebede', '[]', '$2y$13$PcapA0erMqfAUDN/SbAM1u/Y1F96R.id6bRdwvOVefQTvkM92sB5O', 2, 'abebe', 'kebede');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appliance`
--
ALTER TABLE `appliance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B4E6C110FFA0C224` (`office_id`),
  ADD KEY `IDX_B4E6C1105790BA5A` (`appiance_type_id`);

--
-- Indexes for table `appliance_type`
--
ALTER TABLE `appliance_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `office`
--
ALTER TABLE `office`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`),
  ADD KEY `IDX_8D93D649FFA0C224` (`office_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appliance`
--
ALTER TABLE `appliance`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `appliance_type`
--
ALTER TABLE `appliance_type`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `office`
--
ALTER TABLE `office`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appliance`
--
ALTER TABLE `appliance`
  ADD CONSTRAINT `FK_B4E6C1105790BA5A` FOREIGN KEY (`appiance_type_id`) REFERENCES `appliance_type` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_B4E6C110FFA0C224` FOREIGN KEY (`office_id`) REFERENCES `office` (`id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_8D93D649FFA0C224` FOREIGN KEY (`office_id`) REFERENCES `office` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
