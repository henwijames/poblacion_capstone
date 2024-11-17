-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2024 at 09:53 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `poblacion`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `first_name`, `middle_name`, `last_name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(7, 'Fulgencio', '', 'Mercado', 'admin@gmail.com', '$2y$10$2pND2IXd2h1McSXzGeAQKeYmAVqMBBID3i2ZvICqsjDtoFuoHD7cK', '2024-09-27 06:56:10', '2024-09-27 07:23:08'),
(8, 'Lovelita', '', 'De Ramos', 'admin@admin.com', '$2y$10$.NtkR6Jvpoo0RPnB./7sFuxIRR/bayoeWW0jqqlnBvTWxbmNDT6nm', '2024-09-27 07:40:13', '2024-09-27 07:45:48'),
(10, 'Henry  James', '', 'Ribano', 'admin_henry@gmail.com', '$2y$10$0bDAevjiNdytaL80xD5ThejqJzKHzBOX60pPRGuWo9rdAosQXvbTO', '2024-11-10 08:16:45', '2024-11-10 08:16:45');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `listing_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `check_in` date NOT NULL,
  `booking_status` enum('pending','verified','declined','') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_amount` decimal(10,2) NOT NULL,
  `landlord_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `id` int(11) NOT NULL,
  `listing_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`id`, `listing_id`, `user_id`, `message`, `created_at`) VALUES
(1, 56, 1, 'mabaho  ang kanalski', '2024-11-16 20:22:26'),
(2, 56, 1, 'hahahahha', '2024-11-16 20:27:47');

-- --------------------------------------------------------

--
-- Table structure for table `email_verification`
--

CREATE TABLE `email_verification` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(32) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `expires_at` timestamp NOT NULL DEFAULT (current_timestamp() + interval 1 hour)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `landlords`
--

CREATE TABLE `landlords` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `property_name` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `permit` varchar(255) NOT NULL,
  `qr_payment` varchar(255) NOT NULL,
  `mode_of_payment` varchar(50) NOT NULL,
  `account_status` enum('pending','declined','verified','banned') NOT NULL,
  `profile_picture` varchar(255) NOT NULL,
  `email_verified` tinyint(1) DEFAULT NULL,
  `mobile_verified` tinyint(1) DEFAULT NULL,
  `verification_code` varchar(6) DEFAULT NULL,
  `verification_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `landlords`
--

INSERT INTO `landlords` (`id`, `first_name`, `middle_name`, `last_name`, `email`, `address`, `property_name`, `phone_number`, `password`, `permit`, `qr_payment`, `mode_of_payment`, `account_status`, `profile_picture`, `email_verified`, `mobile_verified`, `verification_code`, `verification_expires_at`) VALUES
(1, 'Juan Lorenzo', 'Benico', 'Aguilar', 'juanlorenzo@gmail.com', 'Butong Taal', 'Lorenzo\'s  Apartment ', '09097897897', '$2y$10$C8qBc9lY6yiIMwDNqWv3cOpILbidyx87vqG6DmpT1YXppJiiaNtNe', 'housesss.jpg', 'uploads/a74131c6-139a-4bac-8406-49c7cbdb1af2.jpg', 'GCash', 'declined', 'uploads/juan.jpg', 0, 0, '0', NULL),
(2, 'Kate Angeline', 'Atienza', 'Anuran', 'kateangelineanuran@gmail.com', 'Midwest Subdivision, Matingain 1, Lemery, Batangas', 'Kate Anuran Rental', '09691756861', '$2y$10$fOXsZ/.exxuCAZHH7704N.TI3I/kp.mPlJVjn54iw.QUej/H4tmZy', '', '', '', 'pending', '', 0, 0, '0', NULL),
(3, 'Jhian Carl', 'Marcellana', 'Ribano', 'jhianribano27@gmail.com', 'Ibaba', 'Jhian Rental', '09691756862', '$2y$10$A1bq8q5tB6Jrv21ek5sW5.ZILk5O82W0vp70HApoo3X4svmfjkzRe', '', '', '', 'verified', '', 0, 0, '0', NULL),
(17, 'Henry James', 'Marcellana', 'Ribano', 'henryjamesribano20@gmail.com', 'Laguile Ibaba, Taal, Batangas', 'Henrys\' Rental Apartment', '09691756860', '$2y$10$fOXsZ/.exxuCAZHH7704N.TI3I/kp.mPlJVjn54iw.QUej/H4tmZy', '', '', '', 'verified', 'uploads/Passport Size.png', 1, 1, '633346', '2024-11-10 13:45:01');

-- --------------------------------------------------------

--
-- Table structure for table `landlord_resets`
--

CREATE TABLE `landlord_resets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expiration` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `listings`
--

CREATE TABLE `listings` (
  `id` int(11) NOT NULL,
  `listing_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `bedrooms` int(11) NOT NULL,
  `bathrooms` int(11) NOT NULL,
  `amenities` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`amenities`)),
  `utilities` longtext NOT NULL,
  `sqft` int(11) NOT NULL,
  `rent` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `property_type` varchar(50) DEFAULT NULL,
  `mode_of_payment` varchar(50) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` enum('not occupied','occupied','pending') DEFAULT 'not occupied',
  `payment_options` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `listings`
--

INSERT INTO `listings` (`id`, `listing_name`, `address`, `bedrooms`, `bathrooms`, `amenities`, `utilities`, `sqft`, `rent`, `description`, `created_at`, `updated_at`, `property_type`, `mode_of_payment`, `user_id`, `status`, `payment_options`) VALUES
(11, '', 'Poblacion 1,  Taal, Batangas', 1, 4, '[\"gym\",\"balcony\",\"swimming pool\",\"airconditioned\",\"parking\"]', '', 1320, 2000.00, 'Located in the heart of Poblacion 1, Taal, Batangas, this spacious apartment combines modern amenities with a touch of historical charm. The property boasts a comfortable 1320 sqft of living space, including 1 bedroom and 4 bathrooms, making it perfect for small families or individuals seeking a serene, yet convenient, living environment.', '2024-09-20 06:23:09', '2024-11-16 00:27:11', 'apartment', 'GCash', 1, 'not occupied', '[\"one month deposit\",\"one month advance\"]'),
(13, 'House 1', 'Poblacion 2, Taal, Batangas', 2, 2, '[\"swimming pool\",\"airconditioned\",\"parking\"]', '', 1300, 2300.00, 'Nice and Peaceful', '2024-09-21 00:41:18', '2024-11-16 07:55:51', 'apartment', '', 2, 'occupied', NULL),
(14, '', 'Poblacion 7, Taal, Batangas', 1, 1, '[\"balcony\",\"airconditioned\",\"parking\"]', '', 1300, 1800.00, 'Relaxing and Nice Ambience', '2024-09-21 00:47:15', '2024-11-16 00:27:01', 'apartment', '', 3, 'not occupied', NULL),
(54, 'House 1', 'Poblacion 1, Taal, Batangas', 2, 2, '[\"parking\"]', '', 2223, 3000.00, 'Nice and good surrounding environment', '2024-10-16 12:46:47', '2024-11-16 00:26:57', 'apartment', 'GCash', 1, 'not occupied', '[\"one month deposit\",\"one month advance\"]'),
(55, 'House 2', 'Poblacion 2, Taal, Batangas', 2, 2, '[\"parking\"]', '', 2223, 3000.00, 'Nice environment and vintage', '2024-10-16 13:03:19', '2024-11-16 07:55:46', 'apartment', '', 2, 'not occupied', '[\"one month deposit\"]'),
(56, 'House 1', 'Poblacion 2, Taal, Batangas', 2, 1, '[\"parking\"]', '', 2000, 100.00, 'Nice and  Refreshing', '2024-11-10 05:46:49', '2024-11-16 07:27:00', 'apartment', '', 17, 'occupied', '[\"one month deposit\"]'),
(57, 'House 2', 'Poblacion 4, Taal, Batangas', 2, 2, '[\"airconditioned\",\"parking\"]', '[\"water\"]', 1800, 2100.00, 'Goods and nice', '2024-11-17 05:45:18', '2024-11-17 06:03:39', 'apartment', '', 17, 'not occupied', '[\"one month deposit\",\"one month advance\"]');

-- --------------------------------------------------------

--
-- Table structure for table `listing_images`
--

CREATE TABLE `listing_images` (
  `id` int(11) NOT NULL,
  `listing_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `listing_images`
--

INSERT INTO `listing_images` (`id`, `listing_id`, `image_path`, `created_at`) VALUES
(72, 13, 'uploads/house1.jpg', '2024-09-21 00:41:18'),
(73, 13, 'uploads/2.jpg', '2024-09-21 00:41:18'),
(74, 13, 'uploads/house3.jpg', '2024-09-21 00:41:18'),
(75, 13, 'uploads/4.jpg', '2024-09-21 00:41:18'),
(76, 13, 'uploads/20110430-TAAL-D80-0258[4].jpg', '2024-09-21 00:41:18'),
(77, 14, 'uploads/4.jpg', '2024-09-21 00:47:15'),
(78, 14, 'uploads/R.jpg', '2024-09-21 00:47:15'),
(79, 14, 'uploads/house3.jpg', '2024-09-21 00:47:15'),
(80, 14, 'uploads/house2.jpg', '2024-09-21 00:47:15'),
(81, 14, 'uploads/house1.jpg', '2024-09-21 00:47:15'),
(90, 11, 'uploads/bahay5.jpg', '2024-09-27 05:26:56'),
(91, 11, 'uploads/bahay4.jpg', '2024-09-27 05:26:56'),
(92, 11, 'uploads/bahay3.jpg', '2024-09-27 05:26:56'),
(93, 11, 'uploads/bahay2.jpg', '2024-09-27 05:26:56'),
(94, 11, 'uploads/bahay.jpg', '2024-09-27 05:26:56'),
(200, 55, 'uploads/house.jpg', '2024-10-16 13:03:19'),
(201, 55, 'uploads/housee.jpg', '2024-10-16 13:03:19'),
(202, 55, 'uploads/houseee.JPG', '2024-10-16 13:03:19'),
(203, 55, 'uploads/housesss.jpg', '2024-10-16 13:03:19'),
(204, 55, 'uploads/housessss.jpg', '2024-10-16 13:03:19'),
(245, 54, 'uploads/461656017_2572529632934043_8939575303808328902_n.jpg', '2024-10-17 14:11:59'),
(246, 54, 'uploads/461742441_2572529536267386_1579039671550759601_n.jpg', '2024-10-17 14:11:59'),
(247, 54, 'uploads/461613460_2572529259600747_7789132301899025475_n.jpg', '2024-10-17 14:11:59'),
(248, 54, 'uploads/461640138_2572529072934099_7397048506917232191_n.jpg', '2024-10-17 14:11:59'),
(249, 54, 'uploads/461649425_2572528649600808_8520742528152719600_n.jpg', '2024-10-17 14:11:59'),
(250, 56, 'uploads/house.jpg', '2024-11-10 05:46:49'),
(251, 56, 'uploads/houseee.JPG', '2024-11-10 05:46:49'),
(252, 56, 'uploads/housesss.jpg', '2024-11-10 05:46:49'),
(253, 56, 'uploads/bahay3.jpg', '2024-11-10 05:46:49'),
(254, 56, 'uploads/bahay2.jpg', '2024-11-10 05:46:49'),
(255, 57, 'uploads/bahay5.jpg', '2024-11-17 05:45:18'),
(256, 57, 'uploads/bahay2.jpg', '2024-11-17 05:45:18'),
(257, 57, 'uploads/bahay.jpg', '2024-11-17 05:45:18'),
(258, 57, 'uploads/house.jpg', '2024-11-17 05:45:18'),
(259, 57, 'uploads/house2.jpg', '2024-11-17 05:45:18');

-- --------------------------------------------------------

--
-- Table structure for table `rent`
--

CREATE TABLE `rent` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `landlord_id` int(11) NOT NULL,
  `listing_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `due_month` date DEFAULT NULL,
  `rent_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `rent_status` enum('pending','paid','declined','kicked') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rent`
--

INSERT INTO `rent` (`id`, `user_id`, `landlord_id`, `listing_id`, `amount`, `due_month`, `rent_date`, `rent_status`) VALUES
(7, 1, 2, 13, 2300.00, '2024-12-16', '2024-11-16 05:52:50', 'pending'),
(8, 1, 17, 56, 200.00, '2025-02-16', '2024-11-16 07:13:26', 'paid'),
(9, 1, 2, 55, 6000.00, NULL, '2024-11-17 05:31:11', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `tenants`
--

CREATE TABLE `tenants` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `phone_number` varchar(50) NOT NULL,
  `validid` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `account_status` enum('pending','verified','declined','banned') NOT NULL DEFAULT 'pending',
  `profile_picture` varchar(255) NOT NULL,
  `email_verified` tinyint(1) DEFAULT 0,
  `mobile_verified` tinyint(1) DEFAULT 0,
  `verification_code` varchar(6) DEFAULT NULL,
  `verification_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tenants`
--

INSERT INTO `tenants` (`id`, `first_name`, `middle_name`, `last_name`, `email`, `address`, `phone_number`, `validid`, `password`, `account_status`, `profile_picture`, `email_verified`, `mobile_verified`, `verification_code`, `verification_expires_at`) VALUES
(1, 'Henry James', 'Marcellana', 'Ribano', 'henryjamesribano27@gmail.com', 'Laguile Ibaba, Taal, Batangas', '09691756861', 'house3.jpg', '$2y$10$4MLhcnFrpm/BHxRC./0YmetvDiw5Qi1gqYfNPk6/B399NodD.OSwK', 'verified', 'profile_1.png', 1, 1, '548866', '2024-11-08 04:13:15'),
(3, 'Jhian Carl', 'Marcellana', 'Ribano', 'jhiancarl@gmail.com', 'Ibaba', '09691756862', 'graduation.png', '$2y$10$HixVdMwLGX3zplOqM1VymuO5xHS046BTCpypuo8upEsnEAebU08am', 'verified', '', 0, 0, NULL, NULL),
(4, 'Genelyn', 'Marcellana', 'Ribano', 'genelynribano@gmail.com', 'Ibaba', '09691756863', 'me.jpg', '$2y$10$5F2xUww/uyNE9F8rOi2lDu.96KACwEDdSHFvS4KtlLkkxjm1HW85u', 'pending', '', 0, 0, NULL, NULL),
(5, 'Enrique', 'Remolacio', 'Ribano Jr.', 'enriqueribanojr@gmail.com', 'Taal Batangas', '09089087908', 'me.jpg', '$2y$10$lJW76CNIJIdRw3F.dQwXz.t8ABE4Do3KSr1RB5Vskb5fXzMM0JD6S', 'pending', '', 0, 0, NULL, NULL),
(14, 'John Michael', '', 'Castor', 'johnmichaelbcastor@gmail.com', 'Boboy, San Luis, Batangas', '09508796062', '461656017_2572529632934043_8939575303808328902_n.jpg', '$2y$10$A6wlu.yTAiT3JJev6eKtg.OagyJTZoEzhsK9xqCscDGvfgMd1TKZW', 'verified', '', 1, 1, '326145', '2024-10-21 09:37:35'),
(15, 'James', 'Marcellana', 'Ribano', 'henryjamesribano29@gmail.com', 'Laguile Ibaba, Taal, Batangas', '09691756864', '461656017_2572529632934043_8939575303808328902_n.jpg', '$2y$10$s6iUZ1JlDQR9SlZxRSMzn.mNyFa44UZOFmOujTmBvLaoODIkHKFc2', 'pending', '', 1, 1, '335224', '2024-11-06 13:15:18'),
(22, 'Juan Lorenzo', 'Benico', 'Aguilar', 'henryribano27@gmail.com', 'Laguile Ibaba, Taal, Batangas', '09691756860', '9b8615a78cc18e496ddd0d14a4f32d8c.jpg', '$2y$10$O45W8zKNiN4LQeancfcUKO9uSoQCkzRSBQw4ND1ys5nr0Wah5q0SK', 'declined', 'profile_22.jpg', 1, 1, '491835', '2024-11-11 16:35:01');

-- --------------------------------------------------------

--
-- Table structure for table `tenant_resets`
--

CREATE TABLE `tenant_resets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expiration` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `landlord_id` int(11) NOT NULL,
  `listing_id` int(11) NOT NULL,
  `apartment_name` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `reference_number` varchar(50) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `transaction_status` enum('pending','completed','declined','') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `user_id`, `landlord_id`, `listing_id`, `apartment_name`, `amount`, `transaction_date`, `reference_number`, `details`, `transaction_status`) VALUES
(29, 1, 2, 13, 'Poblacion 2, Taal, Batangas', 2300.00, '2024-11-16 05:52:50', '1022696681377', 'Payment for booking #23', 'completed'),
(31, 1, 17, 56, 'Poblacion 2, Taal, Batangas', 200.00, '2024-11-16 07:13:26', '1234567891011', 'Payment for booking #29', 'completed'),
(34, 1, 17, 56, 'Poblacion 2, Taal, Batangas', 100.00, '2024-11-16 08:08:15', '0969175686010', 'Paid', 'completed'),
(35, 1, 2, 13, 'Poblacion 2, Taal, Batangas', 2300.00, '2024-11-16 15:08:19', '0969175686010', 'Paid', 'pending'),
(36, 1, 2, 55, 'Poblacion 2, Taal, Batangas', 6000.00, '2024-11-17 05:31:11', '1234567891011', 'Payment for booking #39', 'pending');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `listing_id` (`listing_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_landlord` (`landlord_id`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`),
  ADD KEY `listing_id` (`listing_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `email_verification`
--
ALTER TABLE `email_verification`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`);

--
-- Indexes for table `landlords`
--
ALTER TABLE `landlords`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `landlord_resets`
--
ALTER TABLE `landlord_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `listings`
--
ALTER TABLE `listings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `listing_images`
--
ALTER TABLE `listing_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `listing_id` (`listing_id`);

--
-- Indexes for table `rent`
--
ALTER TABLE `rent`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `landlord_id` (`landlord_id`),
  ADD KEY `listing_id` (`listing_id`);

--
-- Indexes for table `tenants`
--
ALTER TABLE `tenants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tenant_resets`
--
ALTER TABLE `tenant_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `landlord_id` (`landlord_id`),
  ADD KEY `listing_id` (`listing_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `email_verification`
--
ALTER TABLE `email_verification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `landlords`
--
ALTER TABLE `landlords`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `landlord_resets`
--
ALTER TABLE `landlord_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `listings`
--
ALTER TABLE `listings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `listing_images`
--
ALTER TABLE `listing_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=260;

--
-- AUTO_INCREMENT for table `rent`
--
ALTER TABLE `rent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tenants`
--
ALTER TABLE `tenants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tenant_resets`
--
ALTER TABLE `tenant_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`listing_id`) REFERENCES `listings` (`id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `tenants` (`id`),
  ADD CONSTRAINT `fk_landlord` FOREIGN KEY (`landlord_id`) REFERENCES `listings` (`user_id`);

--
-- Constraints for table `complaints`
--
ALTER TABLE `complaints`
  ADD CONSTRAINT `complaints_ibfk_1` FOREIGN KEY (`listing_id`) REFERENCES `listings` (`id`),
  ADD CONSTRAINT `complaints_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `tenants` (`id`);

--
-- Constraints for table `landlord_resets`
--
ALTER TABLE `landlord_resets`
  ADD CONSTRAINT `landlord_resets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `landlords` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `listing_images`
--
ALTER TABLE `listing_images`
  ADD CONSTRAINT `listing_images_ibfk_1` FOREIGN KEY (`listing_id`) REFERENCES `listings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rent`
--
ALTER TABLE `rent`
  ADD CONSTRAINT `rent_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rent_ibfk_2` FOREIGN KEY (`landlord_id`) REFERENCES `landlords` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rent_ibfk_3` FOREIGN KEY (`listing_id`) REFERENCES `listings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tenant_resets`
--
ALTER TABLE `tenant_resets`
  ADD CONSTRAINT `tenant_resets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`landlord_id`) REFERENCES `landlords` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_ibfk_3` FOREIGN KEY (`listing_id`) REFERENCES `listings` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
