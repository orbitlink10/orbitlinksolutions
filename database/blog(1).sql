-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 17, 2023 at 08:49 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

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
(6, '2023_06_27_062915_create_posts_table', 2),
(7, '2023_06_27_062957_create_tags_table', 2),
(8, '2023_06_27_070805_create_post_tags_table', 3);

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
  `description` text DEFAULT NULL,
  `user_id` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `description`, `user_id`, `created_at`, `updated_at`) VALUES
(7, 'Exploring Laravel\'s Blade Templating Engine: A Powerful Tool for Web Development', 'Are you looking for a robust and efficient way to manage your web application\'s views? Look no further than Laravel\'s Blade templating engine! In this post, we\'ll dive deep into the world of Blade and discover its powerful features that make web development a breeze.\r\n\r\nJoin me as we explore the basics of Blade syntax, including control structures, template inheritance, and reusable components. We\'ll also discuss how to pass data to views, utilize conditional statements, and implement loops for dynamic content rendering.\r\n\r\nFurthermore, we\'ll uncover advanced Blade techniques such as extending layouts, working with Blade directives, and utilizing Blade\'s powerful template caching capabilities. These techniques will help you create clean and organized view files while optimizing performance.\r\n\r\nWhether you\'re a seasoned Laravel developer or just starting with Blade templating, this post will equip you with the knowledge and skills to leverage Blade\'s full potential. Get ready to enhance your web development workflow with Laravel\'s Blade templating engine and take your applications to the next level!\r\n\r\nSo, let\'s dive into the world of Blade and unlock its immense potential together. Stay tuned for this informative exploration of Laravel\'s Blade templating engine!', '1', '2023-06-27 05:18:14', '2023-06-27 05:18:14'),
(8, 'Top 5 Laravel Packages You Should Know About', 'Top 5 Laravel Packages You Should Know About\"\r\nLaravel is known for its vibrant ecosystem and extensive package support. If you want to supercharge your Laravel applications, check out these top five Laravel packages that can save you time and effort. From authentication to caching and beyond, these packages will take your development experience to the next level. Don\'t miss out on these incredible tools!\r\n\r\nTitle: \"Building RESTful APIs with Laravel: A Step-by-Step Tutorial\"\r\nAre you looking to build robust and scalable RESTful APIs? Laravel makes it a breeze! Join me in this step-by-step tutorial where we\'ll explore how to create RESTful APIs using Laravel\'s powerful features like routing, controllers, and Eloquent ORM. By the end of this tutorial, you\'ll have a solid foundation to build your own APIs with Laravel.\r\n\r\nTitle: \"Debugging Techniques in Laravel: Tips and Tricks\"\r\nDebugging can be a challenging part of the development process, but fear not! In this post, I\'ll share some invaluable debugging techniques specifically tailored for Laravel developers. From using Laravel\'s built-in debugging tools to leveraging third-party packages, we\'ll cover various strategies to help you squash those pesky bugs and streamline your development workflow.\r\n\r\nTitle: \"Scaling Laravel Applications: Strategies for High Traffic Websites\"\r\nAs your Laravel application grows, scaling becomes a crucial consideration. In this post, we\'ll explore different strategies and best practices for scaling Laravel applications to handle high traffic and maintain performance. From optimizing database queries to leveraging caching mechanisms, you\'ll learn essential techniques to ensure your Laravel app can handle the load.\r\n\r\nRemember, these are just sample posts, but they should give you an idea of the topics you can explore when writing about Laravel. Feel free to modify and expand on these ideas to create your own engaging content!', '1', '2023-06-27 05:19:12', '2023-06-27 05:19:12'),
(9, 'Optimizing Database Performance in Laravel: Best Practices and Techniques', 'As a Laravel developer, you know that database performance plays a critical role in the overall efficiency of your application. In this post, we\'ll delve into the realm of optimizing database performance in Laravel and explore best practices and techniques to ensure your application runs smoothly and efficiently.\r\n\r\nJoin me as we uncover strategies for optimizing database queries, such as utilizing eager loading, eager constraints, and query caching. We\'ll also explore how to effectively use indexes, leverage database transactions, and implement database sharding for scalability.\r\n\r\nAdditionally, we\'ll dive into advanced techniques like database query profiling and analyzing slow queries using Laravel\'s query log and EXPLAIN.', '1', '2023-06-27 05:59:21', '2023-06-27 05:59:21'),
(10, 'To Complete ASP Data Collection Form', 'guffffty', '1', '2023-06-27 06:09:01', '2023-06-27 06:09:01');

-- --------------------------------------------------------

--
-- Table structure for table `post_tags`
--

CREATE TABLE `post_tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` varchar(255) NOT NULL,
  `tag_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post_tags`
--

INSERT INTO `post_tags` (`id`, `post_id`, `tag_id`, `created_at`, `updated_at`) VALUES
(7, '7', 1, '2023-06-27 05:18:14', '2023-06-27 05:18:14'),
(8, '7', 2, '2023-06-27 05:18:14', '2023-06-27 05:18:14'),
(9, '7', 3, '2023-06-27 05:18:14', '2023-06-27 05:18:14'),
(10, '7', 4, '2023-06-27 05:18:14', '2023-06-27 05:18:14'),
(11, '8', 1, '2023-06-27 05:19:12', '2023-06-27 05:19:12'),
(12, '8', 2, '2023-06-27 05:19:12', '2023-06-27 05:19:12'),
(13, '8', 3, '2023-06-27 05:19:12', '2023-06-27 05:19:12'),
(14, '9', 1, '2023-06-27 05:59:21', '2023-06-27 05:59:21'),
(15, '9', 2, '2023-06-27 05:59:21', '2023-06-27 05:59:21'),
(16, '10', 1, '2023-06-27 06:09:01', '2023-06-27 06:09:01'),
(17, '10', 2, '2023-06-27 06:09:01', '2023-06-27 06:09:01'),
(18, '10', 3, '2023-06-27 06:09:01', '2023-06-27 06:09:01'),
(19, '10', 4, '2023-06-27 06:09:01', '2023-06-27 06:09:01');

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

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Health', '2023-06-27 03:55:55', '2023-06-27 03:55:55'),
(2, 'Leisure', '2023-06-27 03:57:53', '2023-06-27 03:57:53'),
(3, 'Meditation', '2023-06-27 03:58:01', '2023-06-27 03:58:01'),
(4, 'Programming', '2023-06-27 05:16:52', '2023-06-27 05:16:52');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Ezekiel Muki', 'ezekielmuki42@gmail.com', NULL, '$2y$10$LXuaJloz3QNAnvHosDveMes.vGcq5ZF2WjlQbqXh0AXABwkep3ere', 'Nosu0CzHfHSSUxRzPe1MOwvYtGlKFzCPED8a6czKI772HZRmRljuTyLYSsYY', '2023-06-27 03:27:56', '2023-06-27 03:27:56');

--
-- Indexes for dumped tables
--

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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_tags`
--
ALTER TABLE `post_tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
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
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `post_tags`
--
ALTER TABLE `post_tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
