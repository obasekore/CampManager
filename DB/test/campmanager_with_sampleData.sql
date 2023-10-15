-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 14, 2017 at 08:55 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `campmanager`
--
CREATE DATABASE IF NOT EXISTS `campmanager` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `campmanager`;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
`admin_id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `role` int(11) NOT NULL COMMENT 'SUPER,REGISTRAR,SECURITY,LOGISTICS',
  `password` varchar(150) NOT NULL,
  `last_login` varchar(50) NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `num_retries` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `firstname`, `lastname`, `username`, `email`, `role`, `password`, `last_login`, `remember_token`, `created_at`, `updated_at`, `num_retries`) VALUES
(1, 'Hammed', 'Obasekore', 'obas', 'obasekore.hammed@gmail.com', 1, '99ab873a21f8f05991f6722fbad8da280b46d384d9d997b5a04288e67a69d66db2c3b91e2473ed76e8485f2761dc9c3c8c2a45599b6064865d846f18472644e7', '1505371117', NULL, '2017-06-23 23:00:00', '2017-06-23 23:00:00', 0),
(2, 'Ibrahim', 'Jamiu', 'omotola', 'ibrahimomotola38%40yahoo.com', 2, '4a1afb05dd8b2931e5746f4183739252cd066cf40df0f64dcb8378800a798295b4a905859461b6727ff7c003f44b30e039d6e0f400f09736204e6da8cba92959', '1504956982', NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE IF NOT EXISTS `attendances` (
`id` int(10) unsigned NOT NULL,
  `delegateDetailId` int(10) unsigned NOT NULL,
  `campId` int(10) unsigned NOT NULL,
  `categoryId` int(10) unsigned NOT NULL,
  `underPay` int(11) DEFAULT NULL,
  `personResponsible` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'name & number',
  `house` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `attendances`
--

INSERT INTO `attendances` (`id`, `delegateDetailId`, `campId`, `categoryId`, `underPay`, `personResponsible`, `house`, `created_at`, `updated_at`) VALUES
(3, 10, 2, 5, 0, '', 'AbuBakar', '2017-08-02 04:11:37', '2017-08-02 04:11:37'),
(4, 11, 2, 5, 0, '', 'AbuBakar', '2017-08-03 00:24:10', '2017-08-03 00:24:10'),
(5, 12, 2, 5, 200, 'Ummuh Nusaybah Anoba', 'Meimoona', '2017-08-03 10:44:37', '2017-08-03 10:44:37'),
(9, 14, 4, 5, 0, '', 'AbuBakar', '2017-09-08 08:16:56', '2017-09-08 08:16:56'),
(10, 11, 4, 5, 0, '', 'AbuBakar', '2017-09-08 10:31:14', '2017-09-08 10:31:14');

-- --------------------------------------------------------

--
-- Table structure for table `campfee`
--

CREATE TABLE IF NOT EXISTS `campfee` (
`id` int(11) NOT NULL,
  `campId` int(10) unsigned NOT NULL,
  `categoryId` int(10) unsigned NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `campfee`
--

INSERT INTO `campfee` (`id`, `campId`, `categoryId`, `amount`) VALUES
(1, 2, 5, 2000),
(2, 2, 3, 1500),
(3, 2, 1, 1000),
(4, 2, 4, 1500),
(10, 4, 5, 1500);

-- --------------------------------------------------------

--
-- Table structure for table `camps`
--

CREATE TABLE IF NOT EXISTS `camps` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `theme` text COLLATE utf8_unicode_ci NOT NULL,
  `memoryVerse` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'images:image/Q23;audio:mp3/Q23',
  `Location` text COLLATE utf8_unicode_ci NOT NULL,
  `DOP` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'serialize array of amount by category',
  `house` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'serialize array of house by gender',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1:active, 0:inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `camps`
--

INSERT INTO `camps` (`id`, `name`, `theme`, `memoryVerse`, `Location`, `DOP`, `amount`, `house`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Holiday Islamic Course', 'The Pioneer', 'Suratul Nisai Verse 23', 'Baboko Waziri, General Hospital Ilorin', 'AbdulRauf Gidado; Hassan Tawakalt', '', 'a:2:{s:4:"male";a:4:{i:0;s:8:"AbuBakar";i:1;s:4:"Umar";i:2;s:3:"Ali";i:3;s:6:"Uthman";}s:6:"female";a:4:{i:0;s:5:"Aisha";i:1;s:8:"Meimoona";i:2;s:8:"Khadijah";i:3;s:7:"Salamah";}}', 1, '2017-07-01 04:01:41', '2017-07-01 04:01:41'),
(2, 'Weekend Training Course', 'The Vanguard ', 'Suratul Nisai Verse 23', 'Baboko Waziri, General Hospital Ilorin', 'AbdulRauf Gidado; Hassan Tawakalt', '', 'a:2:{s:4:"male";a:4:{i:0;s:8:"AbuBakar";i:1;s:4:"Umar";i:2;s:3:"Ali";i:3;s:6:"Uthman";}s:6:"female";a:4:{i:0;s:5:"Aisha";i:1;s:8:"Meimoona";i:2;s:8:"Khadijah";i:3;s:7:"Salamah";}}', 1, '2017-07-01 04:01:55', '2017-07-01 04:01:55'),
(4, 'BCC', 'The Youth', 'Q 5 Vs 90-91', 'Akerebiata', 'Amanatullahi', '', 'a:2:{s:4:"male";a:1:{i:0;s:8:"AbuBakar";}s:6:"female";a:1:{i:0;s:5:"Aisha";}}', 1, '2017-09-08 08:15:06', '2017-09-08 08:15:06');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Lower', 'For Delegates in JSS 1 and JSS 2', 1, '2017-06-29 23:00:00', '0000-00-00 00:00:00'),
(3, 'Intermediate ', 'For Delegates in JSS 3 and SS 1', 1, '2017-06-30 03:36:46', '2017-06-30 03:36:46'),
(4, 'Upper', 'For Delegates in SS 2 and SS 3', 1, '2017-06-30 03:37:52', '2017-06-30 03:37:52'),
(5, 'Da`awah', 'For Delegates in Higher Institution', 1, '2017-06-30 03:38:40', '2017-06-30 03:38:40'),
(6, 'Officials', 'Any one that holds post of responsibilities in camp', 1, '2017-08-27 11:05:20', '2017-08-27 11:05:20');

-- --------------------------------------------------------

--
-- Table structure for table `delegatedetails`
--

CREATE TABLE IF NOT EXISTS `delegatedetails` (
`id` int(10) unsigned NOT NULL,
  `surname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `firstName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `otherName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Male, Female',
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `school_department_placeOfWork` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name_next_of_kin` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `number_next_of_kin` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address_next_of_kin` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `delegatedetails`
--

INSERT INTO `delegatedetails` (`id`, `surname`, `firstName`, `otherName`, `gender`, `address`, `school_department_placeOfWork`, `email`, `phone_number`, `state`, `name_next_of_kin`, `number_next_of_kin`, `address_next_of_kin`, `status`, `created_at`, `updated_at`) VALUES
(10, 'OBASEKORE', 'Hammed', 'Olatunde', 'Male', 'Lane 2, Jimoh Ojeniyi Street Beside An-Nur Nursery/Primary School Agodongbo Folatyre Oyo', 'Egypt Japan University of Science and Technology', 'obasekore.hammed@gmail.com', '8058905913', '.......', 'Alhaji OBASEKORE, Waheed', '08033784097', 'Lane 2, Jimoh Ojeniyi Street Beside An-Nur Nursery/Primary School Agodongbo Folatyre Oyo', 1, '2017-07-27 05:29:05', '2017-08-02 04:11:37'),
(11, 'IBRAHIM', 'JAMIU', 'OMOTOLA', 'Male', '2, ILEDU ROAD, TANKE ILORIN', 'University of Ilorin', 'ibrahimjamiu@yahoo.com', '8082739416', '.......', 'Alhaji Anaseku', '08082739416', 'Magudu Lagos', 1, '2017-07-27 06:07:23', '2017-08-03 00:24:10'),
(12, 'MOHAMMED', 'BILQIS', 'BOLANLE', 'Female', 'LAGOS HOSTEL, UNILORIN', 'University of Ilorin,Statistics', 'omobolapretty@gmail.com', '8031924636', '.......', 'Nurah Mohammed', '07068152726', 'Unilag', 1, '2017-08-03 10:44:37', '2017-08-03 10:44:37'),
(13, 'OLURODE', 'ZAINAB', '', 'Female', 'OKE ODO, TANKE', 'University of Ilorin,Science Education', 'bintjash@gmail.com', '8164177386', '.......', 'Dr. Olurode', '08033813391', 'FMC Bida Niger state', 1, '2017-08-03 11:11:40', '2017-08-03 11:11:40'),
(14, 'Mustopha', 'Mustopha', 'Al-Ameen', 'Male', '20, Sheikh Rabiu Adebayo street, Fate-Tanke, Ilorin', 'Taoheed Secondary School', 'mustofaalameen54@gmail.com', '9028803463', '.......', 'Mustofa', '09028803463', '20, Sheikh Rabiu Adebayo street, Fate-Tanke, Ilorin.', 1, '2017-08-27 11:22:48', '2017-08-27 11:22:48');

-- --------------------------------------------------------

--
-- Table structure for table `expenditures`
--

CREATE TABLE IF NOT EXISTS `expenditures` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `purpose` text COLLATE utf8_unicode_ci NOT NULL,
  `phoneNumber` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `campId` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `expenditures`
--

INSERT INTO `expenditures` (`id`, `name`, `purpose`, `phoneNumber`, `amount`, `created_at`, `updated_at`, `campId`) VALUES
(2, 'Mambila', '1 Bag of Rice', '081667788991', 5800, '2017-08-08 09:04:29', '2017-08-26 10:55:32', 2);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
`id` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `url` text NOT NULL,
  `status` bit(2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `title`, `url`, `status`, `created_at`) VALUES
(1, 'Dashboard', 'dashboard.php', b'01', '2017-08-10 17:16:19'),
(2, 'Manage Categories', 'categories.php', b'01', '2017-08-10 17:16:19'),
(3, 'Delegate Registration', 'delegateRegister.php', b'01', '2017-08-10 17:16:19'),
(4, 'View Delegates', 'delegateRegisteredInCamp.php', b'01', '2017-08-10 17:16:19'),
(5, 'Camp Account', 'expenditure.php', b'01', '2017-08-10 17:16:19'),
(6, 'Logistics', 'logistics.php', b'01', '2017-08-10 17:18:03'),
(7, 'Register Camp', 'regCamp.php', b'01', '2017-08-10 17:18:03'),
(8, 'Settings', 'settings.php', b'00', '2017-08-10 17:18:45');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2016_11_23_222043_create_delegate_details_table', 1),
('2016_11_23_223402_create_categories_table', 1),
('2016_11_23_223439_create_camps_table', 1),
('2016_11_23_223515_create_attendances_table', 1),
('2016_11_23_223606_create_expenditures_table', 1),
('2016_11_23_223708_create_signed_out_records_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
`id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `accessible` text NOT NULL COMMENT 'Serialized Array of accessible pages',
  `status` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `title`, `accessible`, `status`) VALUES
(1, 'SUPER', '1,2,3,4,5,6,7,8', 1),
(2, 'HEAD_REG', '1,2,3,4,5,6,7', 1),
(3, 'SUB_REG', '1,3,4', 1),
(4, 'LOGISTICS', '1,4,5,6,8', 1),
(5, 'SECURITY', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
`id` int(11) NOT NULL,
  `EstName` varchar(255) NOT NULL,
  `logo` text NOT NULL,
  `moto` text NOT NULL,
  `defaultCampId` int(10) unsigned DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `EstName`, `logo`, `moto`, `defaultCampId`) VALUES
(1, 'STANDARD BEARERS ISLAMIC ORGANIZATION (SB)', 'images/sb-logo.jpg', 'Setting the standard...', 4);

-- --------------------------------------------------------

--
-- Table structure for table `signedoutrecords`
--

CREATE TABLE IF NOT EXISTS `signedoutrecords` (
`id` int(10) unsigned NOT NULL,
  `delegateDetailId` int(10) unsigned NOT NULL,
  `destination` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `purpose` text COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` text COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` int(11) NOT NULL COMMENT 'SUPER,REGISTRAR,SECURITY,LOGISTICS',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
 ADD PRIMARY KEY (`admin_id`), ADD UNIQUE KEY `username_unique` (`username`);

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
 ADD PRIMARY KEY (`id`), ADD KEY `attendances_delegatedetailid_foreign` (`delegateDetailId`), ADD KEY `attendances_campid_foreign` (`campId`), ADD KEY `attendances_categoryid_foreign` (`categoryId`);

--
-- Indexes for table `campfee`
--
ALTER TABLE `campfee`
 ADD PRIMARY KEY (`id`), ADD KEY `categoryId` (`categoryId`), ADD KEY `campId` (`campId`);

--
-- Indexes for table `camps`
--
ALTER TABLE `camps`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delegatedetails`
--
ALTER TABLE `delegatedetails`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenditures`
--
ALTER TABLE `expenditures`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
 ADD KEY `password_resets_email_index` (`email`), ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
 ADD PRIMARY KEY (`id`), ADD KEY `defaultCampId` (`defaultCampId`);

--
-- Indexes for table `signedoutrecords`
--
ALTER TABLE `signedoutrecords`
 ADD PRIMARY KEY (`id`), ADD KEY `signedoutrecords_delegatedetailid_foreign` (`delegateDetailId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `campfee`
--
ALTER TABLE `campfee`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `camps`
--
ALTER TABLE `camps`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `delegatedetails`
--
ALTER TABLE `delegatedetails`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `expenditures`
--
ALTER TABLE `expenditures`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `signedoutrecords`
--
ALTER TABLE `signedoutrecords`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendances`
--
ALTER TABLE `attendances`
ADD CONSTRAINT `attendances_campid_foreign` FOREIGN KEY (`campId`) REFERENCES `camps` (`id`),
ADD CONSTRAINT `attendances_categoryid_foreign` FOREIGN KEY (`categoryId`) REFERENCES `categories` (`id`),
ADD CONSTRAINT `attendances_delegatedetailid_foreign` FOREIGN KEY (`delegateDetailId`) REFERENCES `delegatedetails` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `campfee`
--
ALTER TABLE `campfee`
ADD CONSTRAINT `campfee_ibfk_1` FOREIGN KEY (`campId`) REFERENCES `camps` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `campfee_ibfk_2` FOREIGN KEY (`categoryId`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `settings`
--
ALTER TABLE `settings`
ADD CONSTRAINT `settings_ibfk_1` FOREIGN KEY (`defaultCampId`) REFERENCES `camps` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `signedoutrecords`
--
ALTER TABLE `signedoutrecords`
ADD CONSTRAINT `signedoutrecords_delegatedetailid_foreign` FOREIGN KEY (`delegateDetailId`) REFERENCES `delegatedetails` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
