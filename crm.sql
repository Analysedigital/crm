-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 04, 2025 at 07:21 AM
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
-- Database: `crm`
--

-- --------------------------------------------------------

--
-- Table structure for table `agent_profiles`
--

CREATE TABLE `agent_profiles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leads`
--

CREATE TABLE `leads` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `alternate_phone` varchar(50) DEFAULT NULL,
  `whatsapp_number` varchar(50) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `pincode` varchar(20) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `project_name` varchar(255) DEFAULT NULL,
  `property_type` enum('apartment','villa','plot','commercial') DEFAULT NULL,
  `location_interested` varchar(255) DEFAULT NULL,
  `budget_min` decimal(12,2) DEFAULT NULL,
  `budget_max` decimal(12,2) DEFAULT NULL,
  `source_id` int(11) DEFAULT NULL,
  `sub_source` varchar(150) DEFAULT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `domain` varchar(255) DEFAULT NULL,
  `campaign_name` varchar(150) DEFAULT NULL,
  `utm_source` varchar(255) DEFAULT NULL,
  `utm_medium` varchar(255) DEFAULT NULL,
  `utm_campaign` varchar(255) DEFAULT NULL,
  `assigned_agent` int(11) DEFAULT NULL,
  `status` enum('new','contacted','follow_up','converted','lost') DEFAULT 'new',
  `priority` enum('very_high','high','medium','low','very_low') DEFAULT 'medium',
  `lead_stage` enum('new','qualified','proposal','negotiation','won','lost') DEFAULT 'new',
  `followup_date` datetime DEFAULT NULL,
  `last_contacted_at` datetime DEFAULT NULL,
  `converted_at` datetime DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leads`
--

INSERT INTO `leads` (`id`, `name`, `phone`, `alternate_phone`, `whatsapp_number`, `email`, `address`, `city`, `state`, `pincode`, `subject`, `project_name`, `property_type`, `location_interested`, `budget_min`, `budget_max`, `source_id`, `sub_source`, `vendor_id`, `domain`, `campaign_name`, `utm_source`, `utm_medium`, `utm_campaign`, `assigned_agent`, `status`, `priority`, `lead_stage`, `followup_date`, `last_contacted_at`, `converted_at`, `notes`, `created_at`, `updated_at`) VALUES
(3, 'Anish R Test', '9999999999', NULL, NULL, 'test@gmail.com', NULL, NULL, NULL, NULL, 'Testing', NULL, NULL, NULL, NULL, NULL, 1, 'Google Lead', 1, '', NULL, NULL, NULL, NULL, 4, 'new', '', 'new', NULL, NULL, NULL, '', '2025-10-23 08:46:04', '2025-10-23 08:59:49'),
(4, 'John Doe', '9876543210', NULL, NULL, 'john@example.com', NULL, NULL, NULL, NULL, 'Interested in Product X', NULL, NULL, NULL, NULL, NULL, 1, 'Landing Page', NULL, 'alpha.com', NULL, NULL, NULL, NULL, NULL, 'new', '', 'new', NULL, NULL, NULL, NULL, '2025-10-23 10:16:20', NULL),
(5, 'John Doe', '9876543210', NULL, NULL, 'john@example.com', NULL, NULL, NULL, NULL, 'Interested in Product X', NULL, NULL, NULL, NULL, NULL, 1, 'Landing Page', 4, 'alpha.com', NULL, NULL, NULL, NULL, 4, 'new', '', 'new', NULL, NULL, NULL, NULL, '2025-10-23 10:26:13', NULL),
(6, 'John Doe', '9876543210', NULL, NULL, 'john@example.com', NULL, NULL, NULL, NULL, 'Interested in Product X', NULL, NULL, NULL, NULL, NULL, 1, 'Landing Page', 4, 'alpha.com', NULL, NULL, NULL, NULL, 4, 'new', '', 'new', NULL, NULL, NULL, NULL, '2025-10-23 10:28:45', NULL),
(7, 'John Doe', '9876543210', NULL, NULL, 'john@example.com', NULL, NULL, NULL, NULL, 'Interested in Product X', NULL, NULL, NULL, NULL, NULL, 1, 'Landing Page', 4, 'alpha.com', NULL, NULL, NULL, NULL, 4, 'new', '', 'new', NULL, NULL, NULL, NULL, '2025-10-23 10:30:45', NULL),
(8, 'John Doe', '9876543210', '', '', 'john@example.com', 'Mahathma Gandhi Road', 'Bengaluru', 'Karnataka', '560025', 'Interested in Product X', 'Artek', '', 'TVM', 300.00, 400.00, 1, 'Landing Page', 4, 'alpha.com', NULL, NULL, NULL, NULL, 4, 'new', 'high', 'new', '0000-00-00 00:00:00', NULL, NULL, '', '2025-10-23 10:35:04', '2025-11-04 01:03:11'),
(12, 'New Lead Test', '9999999999', '', '', 'test@gmail.com', '', '', '', '', 'Testing', '', '', '', 0.00, 0.00, 1, '', NULL, NULL, NULL, NULL, NULL, NULL, 4, 'new', 'medium', 'new', '0000-00-00 00:00:00', NULL, NULL, '', '2025-11-04 01:17:11', NULL),
(13, 'Suba Sree', '9876543210', NULL, NULL, 'sub@example.com', NULL, NULL, NULL, NULL, 'Interested in 2BHK apartment', NULL, NULL, NULL, NULL, NULL, 1, 'Google Ads', 4, 'alpha.com', NULL, NULL, NULL, NULL, 6, 'new', 'medium', 'new', NULL, NULL, NULL, NULL, '2025-11-04 01:39:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lead_assignments`
--

CREATE TABLE `lead_assignments` (
  `id` bigint(20) NOT NULL,
  `lead_id` bigint(20) NOT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `assigned_by` int(11) DEFAULT NULL,
  `assigned_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `reason` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lead_assignments`
--

INSERT INTO `lead_assignments` (`id`, `lead_id`, `agent_id`, `assigned_by`, `assigned_at`, `reason`) VALUES
(1, 4, 4, NULL, '2025-10-23 10:16:20', 'Round-Robin'),
(2, 5, 4, NULL, '2025-10-23 10:26:13', 'Round-Robin'),
(3, 6, 4, NULL, '2025-10-23 10:28:45', 'Round-Robin'),
(4, 7, 4, NULL, '2025-10-23 10:30:45', 'Round-Robin'),
(5, 8, 4, NULL, '2025-10-23 10:35:04', 'Round-Robin'),
(6, 12, 4, 5, '2025-11-04 05:47:11', 'Manual assignment from admin panel'),
(7, 13, 6, NULL, '2025-11-04 01:39:07', 'Round-Robin');

-- --------------------------------------------------------

--
-- Table structure for table `lead_sources`
--

CREATE TABLE `lead_sources` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lead_sources`
--

INSERT INTO `lead_sources` (`id`, `name`, `created_at`) VALUES
(1, 'Google', '2025-10-23 08:44:46'),
(2, 'Meta', '2025-11-04 06:19:00');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `k` varchar(100) NOT NULL,
  `v` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`k`, `v`) VALUES
('last_agent_id', '6');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','agent') NOT NULL DEFAULT 'agent',
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `status`, `created_at`, `updated_at`) VALUES
(4, 'Agent User Test', 'agent@example.com', '$2y$10$1aaApL/hfP4.uxAVCX4tdOsOI/Qcf6CMYVdR5QxRe.Auv.y61th4e', 'agent', 1, '2025-10-23 06:38:34', '2025-10-23 06:57:00'),
(5, 'Anish R', 'anish.raju@analysedigital.com', '$2y$10$mjfnJ/4zD5a5YiobLXkryu8EbfNpsRCtX/ID8iR2hOr592/Ik4q5i', 'admin', 1, '2025-10-23 07:08:07', NULL),
(6, 'Vignesh', 'vignesh.sg@analysedigital.com', '$2y$10$0/ZiC.fa6BvohLOgZ/NrheQ/4txFb65Ciaa4LRkQGFhQgexwZvTPm', 'agent', 1, '2025-11-04 06:08:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` int(11) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `domain` varchar(255) NOT NULL,
  `api_key` varchar(255) NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `name`, `domain`, `api_key`, `status`, `created_at`) VALUES
(1, 'Vendor One', 'vendorone.com', 'APIKEY123', 1, '2025-10-23 07:44:19'),
(2, 'Vendor Two', 'vendortwo.com', 'APIKEY456', 1, '2025-10-23 07:44:19'),
(3, 'Vendor Three', 'vendorthree.com', 'APIKEY789', 1, '2025-10-23 07:44:19'),
(4, 'Alpha Leads', 'alpha.com', 'ALPHA123API', 1, '2025-10-23 09:22:35'),
(5, 'Beta Marketing', 'beta.com', 'BETA456API', 1, '2025-10-23 09:22:35'),
(6, 'Gamma Sources', 'gamma.com', 'GAMMA789API', 1, '2025-10-23 09:22:35'),
(7, 'Delta Solutions', 'delta.com', 'DELTA321API', 1, '2025-10-23 09:22:35'),
(8, 'Epsilon Partners', 'epsilon.com', 'EPSILON654API', 1, '2025-10-23 09:22:35'),
(10, 'Test', 'vendornew.com', 'AIzaSyADZXjetl7iNU0ajm3BsPFPIZyBFLsYtes', 1, '2025-10-23 09:28:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agent_profiles`
--
ALTER TABLE `agent_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `source_id` (`source_id`),
  ADD KEY `assigned_agent` (`assigned_agent`),
  ADD KEY `created_at` (`created_at`),
  ADD KEY `fk_leads_vendor` (`vendor_id`);

--
-- Indexes for table `lead_assignments`
--
ALTER TABLE `lead_assignments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lead_sources`
--
ALTER TABLE `lead_sources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`k`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `domain` (`domain`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agent_profiles`
--
ALTER TABLE `agent_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leads`
--
ALTER TABLE `leads`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `lead_assignments`
--
ALTER TABLE `lead_assignments`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `lead_sources`
--
ALTER TABLE `lead_sources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `agent_profiles`
--
ALTER TABLE `agent_profiles`
  ADD CONSTRAINT `agent_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `leads`
--
ALTER TABLE `leads`
  ADD CONSTRAINT `fk_leads_vendor` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `leads_ibfk_1` FOREIGN KEY (`source_id`) REFERENCES `lead_sources` (`id`),
  ADD CONSTRAINT `leads_ibfk_2` FOREIGN KEY (`assigned_agent`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
