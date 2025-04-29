-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 02, 2025 at 07:28 PM
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
-- Database: `quiz`
--

-- --------------------------------------------------------

--
-- Table structure for table `gym_membership`
--

CREATE TABLE `gym_membership` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `birthdate` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `gym_experience` enum('yes','no') NOT NULL,
  `blood_group` enum('A+','A-','B+','B-','AB+','AB-','O+','O-') NOT NULL,
  `allergies` text DEFAULT NULL,
  `past_surgeries` text DEFAULT NULL,
  `health_issues` text DEFAULT NULL,
  `emergency_contact` varchar(255) NOT NULL,
  `emergency_phone` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gym_membership`
--

INSERT INTO `gym_membership` (`id`, `name`, `birthdate`, `email`, `phone`, `gym_experience`, `blood_group`, `allergies`, `past_surgeries`, `health_issues`, `emergency_contact`, `emergency_phone`, `created_at`, `password`) VALUES
(1, '', '0000-00-00', '', '', '', '', '', '', '', '', '', '2025-01-18 05:03:31', ''),
(2, '', '0000-00-00', '', '', '', '', '', '', '', '', '', '2025-01-18 05:06:13', ''),
(3, 'Viraj Jadhav', '2025-01-08', 'jadhavviraj5454@gmail.com', '09359551789', 'yes', 'O+', 'ikhfgukjf', 'sdfsdf', 'sdfsdfsdf', '1234567890', '0897654321', '2025-01-18 05:08:30', ''),
(4, 'Viraj Jadhav', '2025-01-08', 'jadhavviraj5454@gmail.com', '09359551789', 'yes', 'O+', 'ikhfgukjf', 'sdfsdf', 'sdfsdfsdf', '1234567890', '0897654321', '2025-01-18 05:08:57', ''),
(5, 'Viraj Jadhav', '2025-01-08', 'jadhavviraj5454@gmail.com', '09359551789', 'yes', 'O+', 'ikhfgukjf', 'sdfsdf', 'sdfsdfsdf', '1234567890', '0897654321', '2025-01-18 05:11:16', ''),
(6, 'Viraj Jadhav', '2025-01-06', 'jadhavviraj5454@gmail.com', '09359551789', 'yes', 'B-', 'slxkcjghvas', 'sidjfghsdhjk;gc', 'SKLUDCVGHSDHJKL;GFHJKLDZGC', '1234567890', '087653421', '2025-01-18 05:12:42', ''),
(7, 'Viraj Jadhav', '2025-01-02', 'jadhavviraj5454@gmail.com', '09359551789', 'yes', 'AB-', 'TGYHUJK', 'TGYHJNKM', 'FTGYHJK', '1234567890', '09359551789', '2025-01-19 05:31:58', ''),
(8, 'Viraj Jadhav', '2024-12-31', 'jadhavviraj5454@gmail.com', '09359551789', 'yes', 'A+', 'dfvbnm,', 'sdfgsa', 'asdfasdf', '', '09359551789', '2025-01-19 08:15:30', ''),
(9, 'mayur', '2025-01-08', 'mayur5454@gmail.com', '09359551789', 'no', 'O+', 'tgfhjk', 'fgdsa', 'DFGHJKL', '', '09359551789', '2025-01-19 08:16:35', ''),
(10, 'mayur', '2025-01-08', 'mayur5454@gmail.com', '09359551789', 'no', 'O+', 'tgfhjk', 'fgdsa', 'DFGHJKL', '', '09359551789', '2025-01-19 08:22:34', ''),
(11, 'mayur', '2025-01-08', 'mayur5454@gmail.com', '09359551789', 'no', 'O+', 'tgfhjk', 'fgdsa', 'DFGHJKL', 'Viraj Jadhav', '09359551789', '2025-01-19 08:22:45', ''),
(12, 'Viraj Jadhav', '2025-01-01', 'jadhavviraj5454@gmail.com', '09359551789', 'no', 'A+', 'asdfad', 'asdasd', 'asdfasdf', 'Viraj Jadhav', '09359551789', '2025-01-19 08:32:44', 'Viraj'),
(13, 'viraj', '2025-01-08', 'v@gmail.com', '09359551789', 'yes', 'O+', '123', '321', '123', 'Viraj Jadhav', '09359551789', '2025-01-19 08:57:12', '123'),
(14, 'Viraj Jadhav', '2003-05-22', 'jadhavviraj5454@gmail.com', '09359551789', 'yes', 'A+', 'no', 'no', 'lorem', 'Viraj Jadhav', '09359551789', '2025-02-09 17:23:40', '123'),
(15, 'mayur kapadi', '2010-02-03', 'mayur@gmail.com', '9393929281', 'no', 'B-', 'no', 'yes', 'yes', 'viraj', '8292817156', '2025-03-15 07:23:02', '2323'),
(16, 'ZEREF VIRAJ', '2003-05-22', 'ZEREF@gmail.com', '9359551789', 'yes', 'A+', 'NOoee', 'noee', 'nope', 'Viraj Jadhav', '09359551789', '2025-03-20 07:06:43', '123'),
(17, 'mayur dnyaneshwar kapadi', '2004-06-23', 'mayurkapadi23@gmail.com', '9921332521', 'no', 'B-', 'no', 'no', 'no', 'Viraj Jadhav', '8292817156', '2025-03-20 07:10:41', 'Mayur23');

-- --------------------------------------------------------

--
-- Table structure for table `membership_bills`
--

CREATE TABLE `membership_bills` (
  `bill_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `package_name` varchar(255) NOT NULL,
  `package_duration` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `add_ons` text DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_status` enum('pending','paid','failed') NOT NULL DEFAULT 'pending',
  `payment_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `membership_bills`
--

INSERT INTO `membership_bills` (`bill_id`, `user_id`, `plan_id`, `package_name`, `package_duration`, `phone`, `add_ons`, `amount`, `payment_status`, `payment_date`, `created_at`) VALUES
(1, 13, 1, '1 Month Plan', '1 Month', '9359551789', 'Personal Training,Cardio,Diet Plan', 3800.00, 'pending', NULL, '2025-03-20 02:00:00'),
(2, 17, 8, '1 Month Plan', '1 Month', '9921332521', 'Personal Training,Cardio', 3000.00, 'paid', NULL, '2025-03-20 01:41:14'),
(3, 16, 13, '1 Month Plan', '1 Month', '9359551789', 'Diet Plan', 2300.00, 'pending', NULL, '2025-03-26 04:03:48'),
(4, 16, 14, '6 Months Plan', '6 Months', '9359551789', 'None', 7500.00, 'pending', NULL, '2025-04-02 17:21:44');

-- --------------------------------------------------------

--
-- Table structure for table `membership_selection`
--

CREATE TABLE `membership_selection` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `package_name` varchar(255) NOT NULL,
  `package_price` decimal(10,2) NOT NULL,
  `add_ons` text DEFAULT NULL,
  `selected_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `membership_selection`
--

INSERT INTO `membership_selection` (`id`, `user_id`, `package_name`, `package_price`, `add_ons`, `selected_at`) VALUES
(1, 13, '1 Month Plan', 3800.00, 'Personal Training,Cardio,Diet Plan', '2025-03-17 16:52:17'),
(2, 13, '1 Month Plan', 3800.00, 'Personal Training,Cardio,Diet Plan', '2025-03-17 17:00:00'),
(3, 13, '1 Month Plan', 3800.00, 'Personal Training,Cardio,Diet Plan', '2025-03-17 17:03:50'),
(4, 13, '1 Month Plan', 3800.00, 'Personal Training,Cardio,Diet Plan', '2025-03-17 17:10:55'),
(5, 13, '1 Month Plan', 3800.00, 'Personal Training,Cardio,Diet Plan', '2025-03-17 17:37:31'),
(6, 13, '1 Month Plan', 3800.00, 'Personal Training,Cardio,Diet Plan', '2025-03-20 03:08:21'),
(7, 13, '1 Month Plan', 3800.00, 'Personal Training,Cardio,Diet Plan', '2025-03-20 07:02:27'),
(8, 17, '1 Month Plan', 3000.00, 'Personal Training,Cardio', '2025-03-20 07:11:14'),
(9, 13, '1 Month Plan', 3800.00, 'Personal Training,Cardio,Diet Plan', '2025-03-20 07:30:25'),
(10, 13, '1 Month Plan', 3800.00, 'Personal Training,Cardio,Diet Plan', '2025-03-21 06:24:30'),
(11, 13, '1 Month Plan', 3800.00, 'Personal Training,Cardio,Diet Plan', '2025-03-23 07:45:57'),
(12, 13, '1 Month Plan', 3800.00, 'Personal Training,Cardio,Diet Plan', '2025-03-26 03:41:31'),
(13, 16, '1 Month Plan', 2300.00, 'Diet Plan', '2025-03-26 03:42:54'),
(14, 16, '6 Months Plan', 7500.00, 'None', '2025-04-02 17:20:55');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_results`
--

CREATE TABLE `quiz_results` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `plan_id` int(11) DEFAULT NULL,
  `quiz_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`quiz_data`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_results`
--

INSERT INTO `quiz_results` (`id`, `user_id`, `plan_id`, `quiz_data`, `created_at`) VALUES
(1, 13, 5, '{\"0\":\"Fitness\",\"1\":\"Male\",\"2\":\"Lose Weight\",\"3\":\"Vegetarian\",\"4\":\"Beginner\",\"5\":\"3-4 days\",\"height\":\"178\",\"weight\":\"78\",\"age\":\"21\"}', '2025-03-17 17:38:01'),
(2, 13, 6, '{\"0\":\"Fitness\",\"1\":\"Female\",\"2\":\"Lose Weight\",\"3\":\"Vegetarian\",\"4\":\"Beginner\",\"5\":\"1-2 days\",\"height\":\"180\",\"weight\":\"78\",\"age\":\"21\"}', '2025-03-20 03:09:31'),
(3, 17, 8, '{\"0\":\"Fitness\",\"1\":\"Male\",\"2\":\"Build Muscle\",\"3\":\"Vegetarian\",\"4\":\"Beginner\",\"5\":\"Daily\",\"height\":\"188\",\"weight\":\"75\",\"age\":\"21\"}', '2025-03-20 07:12:42'),
(4, 13, 9, '{\"0\":\"Fitness\",\"1\":\"Male\",\"2\":\"Lose Weight\",\"3\":\"Vegetarian\",\"4\":\"Beginner\",\"5\":\"Daily\",\"height\":\"186\",\"weight\":\"70\",\"age\":\"21\"}', '2025-03-20 07:31:52'),
(5, 16, 13, '{\"0\":\"Fitness\",\"1\":\"Male\",\"2\":\"Lose Weight\",\"3\":\"Vegetarian\",\"4\":\"Beginner\",\"5\":\"1-2 days\",\"height\":\"185\",\"weight\":\"75\",\"age\":\"21\"}', '2025-03-26 03:46:50'),
(6, 16, 13, '{\"0\":\"Fitness\",\"1\":\"Male\",\"2\":\"Lose Weight\",\"3\":\"Vegetarian\",\"4\":\"Beginner\",\"5\":\"1-2 days\",\"height\":\"185\",\"weight\":\"75\",\"age\":\"21\"}', '2025-03-26 03:49:45'),
(7, 16, 13, '{\"0\":\"Fitness\",\"1\":\"Male\",\"2\":\"Lose Weight\",\"3\":\"Vegetarian\",\"4\":\"Beginner\",\"5\":\"1-2 days\",\"height\":\"185\",\"weight\":\"75\",\"age\":\"21\"}', '2025-03-26 03:51:17'),
(8, 16, 13, '{\"0\":\"Fitness\",\"1\":\"Male\",\"2\":\"Lose Weight\",\"3\":\"Vegetarian\",\"4\":\"Beginner\",\"5\":\"1-2 days\",\"height\":\"185\",\"weight\":\"75\",\"age\":\"21\"}', '2025-03-26 03:52:29'),
(9, 16, 13, '{\"0\":\"Fitness\",\"1\":\"Male\",\"2\":\"Lose Weight\",\"3\":\"Vegetarian\",\"4\":\"Beginner\",\"5\":\"1-2 days\",\"height\":\"185\",\"weight\":\"75\",\"age\":\"21\"}', '2025-03-26 04:03:06'),
(10, 16, 14, '{\"0\":\"Fitness\",\"1\":\"Male\",\"2\":\"Maintain Fitness\",\"3\":\"Non-Vegetarian\",\"4\":\"Intermediate\",\"5\":\"1-2 days\",\"height\":\"178\",\"weight\":\"78\",\"age\":\"21\"}', '2025-04-02 17:21:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gym_membership`
--
ALTER TABLE `gym_membership`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `membership_bills`
--
ALTER TABLE `membership_bills`
  ADD PRIMARY KEY (`bill_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `plan_id` (`plan_id`);

--
-- Indexes for table `membership_selection`
--
ALTER TABLE `membership_selection`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `quiz_results`
--
ALTER TABLE `quiz_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `plan_id` (`plan_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gym_membership`
--
ALTER TABLE `gym_membership`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `membership_bills`
--
ALTER TABLE `membership_bills`
  MODIFY `bill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `membership_selection`
--
ALTER TABLE `membership_selection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `quiz_results`
--
ALTER TABLE `quiz_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `membership_bills`
--
ALTER TABLE `membership_bills`
  ADD CONSTRAINT `membership_bills_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `gym_membership` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `membership_bills_ibfk_2` FOREIGN KEY (`plan_id`) REFERENCES `membership_selection` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `membership_selection`
--
ALTER TABLE `membership_selection`
  ADD CONSTRAINT `membership_selection_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `gym_membership` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quiz_results`
--
ALTER TABLE `quiz_results`
  ADD CONSTRAINT `quiz_results_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `gym_membership` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quiz_results_ibfk_2` FOREIGN KEY (`plan_id`) REFERENCES `membership_selection` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
