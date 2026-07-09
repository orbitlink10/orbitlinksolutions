-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 23, 2024 at 09:29 PM
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
-- Database: `starlink`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Starlink Kits', 'starlink-kits', '2024-08-21 16:04:16', '2024-08-21 16:04:16'),
(2, 'Mounts & Installation', 'mounts-&-installation', '2024-08-21 16:05:15', '2024-08-21 16:05:15'),
(3, 'Networking', 'networking', '2024-08-21 16:05:53', '2024-08-21 16:05:53'),
(4, 'Power & Travel', 'power-&-travel', '2024-08-21 16:06:14', '2024-08-21 16:06:14');

-- --------------------------------------------------------

--
-- Table structure for table `counties`
--

CREATE TABLE `counties` (
  `id` int(11) NOT NULL,
  `county_code` varchar(3) NOT NULL DEFAULT '1',
  `name` varchar(150) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `counties`
--

INSERT INTO `counties` (`id`, `county_code`, `name`, `created_at`, `updated_at`) VALUES
(1, '1', 'Nairobi City', '2023-11-08 14:42:24', '2023-11-08 14:42:52'),
(2, '1', 'Nyeri', '2023-11-08 14:42:24', '2023-11-08 14:42:52'),
(3, '1', 'Kiambu', '2023-11-08 14:42:24', '2023-11-08 14:42:52'),
(4, '1', 'Baringo', '2023-11-08 14:42:24', '2023-11-08 14:42:52'),
(5, '1', 'Kericho', '2023-11-08 14:42:24', '2023-11-08 14:42:52'),
(6, '1', 'Machakos', '2023-11-08 14:42:24', '2023-11-08 14:42:52'),
(7, '1', 'Makueni', '2023-11-08 14:42:24', '2023-11-08 14:42:52'),
(8, '1', 'Mombasa', '2023-11-08 14:42:24', '2023-11-08 14:42:52'),
(9, '1', 'Kwale', '2023-11-08 14:42:24', '2023-11-08 14:42:52'),
(10, '1', 'Kilifi', '2023-11-08 14:42:24', '2023-11-08 14:42:52'),
(11, '1', 'Tana River', '2023-11-08 14:42:24', '2023-11-08 14:42:52'),
(12, '1', 'Lamu', '2023-11-08 14:42:24', '2023-11-08 14:42:52'),
(13, '1', 'Taita-Taveta', '2023-11-08 14:42:24', '2023-11-08 14:42:52'),
(14, '1', 'Garissa', '2023-11-08 14:42:24', '2023-11-08 14:42:52'),
(15, '1', 'Wajir', '2023-11-08 14:42:24', '2023-11-08 14:42:52'),
(16, '1', 'Mandera', '2023-11-08 14:42:24', '2023-11-08 14:42:52'),
(17, '1', 'Marsabit', '2023-11-08 14:42:24', '2023-11-08 14:42:52'),
(18, '1', 'Isiolo', '2023-11-08 14:42:24', '2023-11-08 14:42:52'),
(19, '1', 'Meru', '2023-11-08 14:42:24', '2023-11-08 14:42:52'),
(20, '1', 'Tharaka-Nithi', '2023-11-08 14:42:24', '2023-11-08 14:42:52'),
(21, '1', 'Embu', '2023-11-08 14:42:24', '2023-11-08 14:42:52'),
(22, '1', 'Kitui', '2023-11-08 14:42:24', '2023-11-08 14:42:52'),
(23, '1', 'Nyandarua', '2023-11-08 14:42:24', '2023-11-08 14:42:52'),
(24, '1', 'Kirinyaga', '2023-11-08 14:42:24', '2023-11-08 14:42:52'),
(25, '1', 'Muranga', '2023-11-08 14:42:24', '2023-11-08 14:42:52'),
(26, '1', 'Turkana', '2023-11-08 14:42:24', '2023-11-08 14:42:52'),
(27, '1', 'West Pokot', '2023-11-08 14:42:24', '2023-11-08 14:42:52'),
(28, '1', 'Samburu', '2023-11-08 14:42:24', '2023-11-08 14:42:52'),
(29, '1', 'Trans Nzoia', '2023-11-08 14:42:24', '2023-11-08 14:42:52'),
(30, '1', 'Uasin Gishu', '2023-11-08 14:42:24', '2023-11-08 14:42:52'),
(31, '1', 'Elgeyo Marakwet', '2023-11-08 14:42:24', '2023-11-08 14:42:52'),
(32, '1', 'Nandi', '2023-11-08 14:42:24', '2023-11-08 14:42:52'),
(33, '1', 'Laikipia', '2023-11-08 14:42:24', '2023-11-08 14:42:52'),
(34, '1', 'Nakuru', '2023-11-08 14:42:24', '2023-11-08 14:42:52'),
(35, '1', 'Narok', '2023-11-08 14:42:24', '2023-11-08 14:42:52'),
(36, '1', 'Kajiado', '2023-11-08 14:42:24', '2023-11-08 14:42:52'),
(37, '1', 'Bomet', '2023-11-08 14:42:24', '2023-11-08 14:42:52'),
(38, '1', 'Kakamega', '2023-11-08 14:42:24', '2023-11-08 14:42:52'),
(39, '1', 'Vihiga', '2023-11-08 14:42:24', '2023-11-08 14:42:52'),
(40, '1', 'Bungoma', '2023-11-08 14:42:24', '2023-11-08 14:42:52'),
(41, '1', 'Busia', '2023-11-08 14:42:24', '2023-11-08 14:42:52'),
(42, '1', 'Siaya', '2023-11-08 14:42:24', '2023-11-08 14:42:52'),
(43, '1', 'Kisumu', '2023-11-08 14:42:24', '2023-11-08 14:42:52'),
(44, '1', 'Homa Bay', '2023-11-08 14:42:24', '2023-11-08 14:42:52'),
(45, '1', 'Migori', '2023-11-08 14:42:24', '2023-11-08 14:42:52'),
(46, '1', 'Kisii', '2023-11-08 14:42:24', '2023-11-08 14:42:52'),
(47, '1', 'Nyamira', '2023-11-08 14:42:24', '2023-11-08 14:42:52'),
(55, '1', 'Bypasses', '2023-11-08 11:44:29', '2023-11-08 11:55:04');

-- --------------------------------------------------------

--
-- Table structure for table `engquiries`
--

CREATE TABLE `engquiries` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `engquiries`
--

INSERT INTO `engquiries` (`id`, `name`, `email`, `phone`, `subject`, `message`, `created_at`, `updated_at`) VALUES
(1, 'samuel Ngumi', 'mngumi44@gmail.com', '0795280062', 'Lead backend developer', 'I am looking for a backend laravel developer.', '2023-10-24 00:02:35', '2023-10-24 00:02:35'),
(2, 'samuel Ngumi', 'mngumi44@gmail.com', '0795280062', 'Graphic Designer', 'Am looking for Graphic Design job', '2023-10-24 00:03:59', '2023-10-24 00:03:59');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2023_06_27_062914_create_categories_table', 1),
(7, '2023_06_27_062914_create_sub_categories_table', 1),
(8, '2023_06_27_062915_create_posts_table', 1),
(9, '2023_06_27_062957_create_tags_table', 1),
(10, '2023_06_27_070805_create_post_tags_table', 1),
(11, '2024_08_21_181044_create_pages_table', 2),
(12, '2024_08_21_182236_create_products_table', 2),
(13, '2024_08_22_131951_create_transactions_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `id` int(10) UNSIGNED NOT NULL,
  `option_key` text DEFAULT NULL,
  `option_value` text DEFAULT NULL,
  `site_name` varchar(255) DEFAULT NULL,
  `site_type` int(11) DEFAULT 0,
  `site_email_address` varchar(255) DEFAULT NULL,
  `footer_address` varchar(255) DEFAULT NULL,
  `site_phone_number` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `currency_sign` varchar(255) DEFAULT NULL,
  `about_title` varchar(255) DEFAULT NULL,
  `about_info` text DEFAULT NULL,
  `profile_name` varchar(255) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `paypal_client_id` varchar(1000) DEFAULT NULL,
  `main_site` varchar(255) DEFAULT NULL,
  `post_interval` varchar(255) DEFAULT NULL,
  `config_priceperslide` varchar(255) DEFAULT NULL,
  `config_coupon` varchar(255) NOT NULL DEFAULT 'YES',
  `config_upsells` varchar(255) NOT NULL DEFAULT 'YES',
  `afrs_username` varchar(255) DEFAULT NULL,
  `afrs_from` varchar(255) DEFAULT NULL,
  `afrs_apikey` varchar(1000) DEFAULT NULL,
  `sms_count` varchar(255) NOT NULL DEFAULT '0',
  `saseni_savings` varchar(255) DEFAULT '0',
  `sms_balance` varchar(255) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `option_key`, `option_value`, `site_name`, `site_type`, `site_email_address`, `footer_address`, `site_phone_number`, `logo`, `currency_sign`, `about_title`, `about_info`, `profile_name`, `designation`, `paypal_client_id`, `main_site`, `post_interval`, `config_priceperslide`, `config_coupon`, `config_upsells`, `afrs_username`, `afrs_from`, `afrs_apikey`, `sms_count`, `saseni_savings`, `sms_balance`) VALUES
(1, 'description', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'YES', 'YES', NULL, NULL, NULL, '0', '0', '0'),
(2, 'home_page_description', '<p><span style=\"color: rgb(51, 51, 51); font-family: &quot;Work Sans&quot;, sans-serif;\">We understand the job&nbsp;</span><span style=\"color: rgb(51, 51, 51); font-family: &quot;Work Sans&quot;, sans-serif; font-size: 1rem;\">searching process can be a pain for most people. However, we are here for each other, we are here to share opportunities, and to show you how to get to them with less hassle and more confidence.</span><br></p>', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'YES', 'YES', NULL, NULL, NULL, '0', '0', '0'),
(4, 'trending_jobs', 'Trending Jobs', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'YES', 'YES', NULL, NULL, NULL, '0', '0', '0'),
(5, 'files', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'YES', 'YES', NULL, NULL, NULL, '0', '0', '0'),
(6, 'kenya_jobs', 'Kenya No.1 Jobs Site', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'YES', 'YES', NULL, NULL, NULL, '0', '0', '0'),
(7, 'contact_description', 'Fill in the form or send us an email for feedback and enquiries.', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'YES', 'YES', NULL, NULL, NULL, '0', '0', '0'),
(8, 'contact_title', 'How can we help you?', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'YES', 'YES', NULL, NULL, NULL, '0', '0', '0'),
(9, 'contact_phone', '+254701234456', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'YES', 'YES', NULL, NULL, NULL, '0', '0', '0'),
(10, 'contact_email', 'info@ikokazikenya', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'YES', 'YES', NULL, NULL, NULL, '0', '0', '0'),
(11, 'conatct_title', 'How can we help you?', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'YES', 'YES', NULL, NULL, NULL, '0', '0', '0'),
(12, 'twiter', 'https://twitter.com/', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'YES', 'YES', NULL, NULL, NULL, '0', '0', '0'),
(13, 'facebook', 'https://www.facebook.com/', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'YES', 'YES', NULL, NULL, NULL, '0', '0', '0'),
(14, 'linkedin', 'https://www.linkedin.com/in', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'YES', 'YES', NULL, NULL, NULL, '0', '0', '0'),
(15, 'instagram', 'https://www.instagram.com/', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'YES', 'YES', NULL, NULL, NULL, '0', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `alter_text` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `head_2` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `App\Models\Category` bigint(20) UNSIGNED NOT NULL,
  `App\Models\SubCategory` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post_tags`
--

CREATE TABLE `post_tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` varchar(255) NOT NULL,
  `tag_id` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `price` decimal(8,2) NOT NULL,
  `discount` decimal(8,2) DEFAULT NULL,
  `quantity` int(50) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `sub_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `stock` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `sku`, `price`, `discount`, `quantity`, `photo`, `slug`, `description`, `category_id`, `sub_category_id`, `stock`, `is_active`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Sam Test', NULL, 6000.00, NULL, NULL, 'uploads/images/Starlink Kenya Logo-1724276491.png', 'sam-test', '<p>ghjkl</p>', 3, 9, 0, 1, '2024-08-21 19:12:12', '2024-08-21 18:41:31', '2024-08-21 19:12:12'),
(2, 'Dual antena', NULL, 8000.00, NULL, 60, 'uploads/images/shop-product-1-1-1724308300.jpg', 'dual-antena', '<p>he term \"dual antenna\" typically refers to a system or device equipped with two antennas instead of one. This configuration can enhance signal reception and transmission capabilities in various technologies, such as wireless networks, mobile phones, and satellite communications. Dual antennas can operate in diversity mode to improve the quality and reliability of the signal by mitigating issues like signal fading and interference. This setup is particularly beneficial in environments where signal quality is compromised due to obstacles or distance. Dual antenna systems can also support advanced communication techniques like Multiple Input Multiple Output (MIMO), which significantly increases data throughput and link range without requiring additional bandwidth.<br></p>', 3, 6, 0, 1, NULL, '2024-08-22 03:31:41', '2024-08-22 04:23:07'),
(3, 'Signal device', NULL, 35000.00, NULL, 200, 'uploads/images/shop-product-1-7-1724308383.jpg', 'signal-device', '<p>The term \"signal device\" generally refers to any apparatus or system designed to transmit or receive signals for communication, measurement, or control purposes. These devices can include a wide range of technologies, from simple visual indicators like traffic lights and warning lights to more complex electronic devices like radios, GPS units, and network routers. Signal devices are essential in various fields, including telecommunications, automotive, aerospace, and industrial automation, where they facilitate the transfer of information, ensure safety, and control mechanisms within systems. They operate by converting and processing different types of energy (such as electrical, optical, or acoustic) into meaningful signals that can be easily understood and utilized by humans or machines.<br></p>', 4, 4, 0, 1, NULL, '2024-08-22 03:33:03', '2024-08-22 04:22:47');

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `name`, `slug`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'Standard Kit', 'standard-kit', 1, '2024-08-21 16:32:46', '2024-08-21 16:32:46'),
(2, 'High Performance Kit', 'high-performance-kit', 1, '2024-08-21 16:33:29', '2024-08-21 16:33:29'),
(3, 'Flat High Performance Kit', 'flat-high-performance-kit', 1, '2024-08-21 16:33:58', '2024-08-21 16:33:58'),
(4, 'Mounts', 'mounts', 2, '2024-08-21 16:34:25', '2024-08-21 16:34:25'),
(5, 'Cable Routing', 'cable-routing', 2, '2024-08-21 16:34:55', '2024-08-21 16:34:55'),
(6, 'Wi-Fi Enhancements', 'wi-fi-enhancements', 3, '2024-08-21 16:35:24', '2024-08-21 16:35:24'),
(7, 'Connectivity', 'connectivity', 3, '2024-08-21 16:35:46', '2024-08-21 16:35:46'),
(8, 'Power', 'power', 4, '2024-08-21 16:36:11', '2024-08-21 16:36:11'),
(9, 'Travel', 'travel', 4, '2024-08-21 16:36:50', '2024-08-21 16:36:50');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `trans_id` varchar(255) NOT NULL,
  `msisdn` varchar(255) NOT NULL,
  `trans_amount` double NOT NULL,
  `bill_ref` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `trans_type` varchar(255) NOT NULL,
  `businesss_code` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `user_type` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `user_type`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'samuel Dev', 'admin@demo.com', 'admin', NULL, '$2y$10$iyC0zZxECgj5AZgI/1EojO/f0.xpdabLOcmuNsCLPQp9w5PG0.DVW', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pages_slug_unique` (`slug`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `posts_slug_unique` (`slug`);

--
-- Indexes for table `post_tags`
--
ALTER TABLE `post_tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_sku_unique` (`sku`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_sub_category_id_foreign` (`sub_category_id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post_tags`
--
ALTER TABLE `post_tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_sub_category_id_foreign` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
