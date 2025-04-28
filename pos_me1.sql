-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Apr 26, 2025 at 01:05 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos_me`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `created_at`, `updated_at`) VALUES
(1, 'Minuman', '2025-04-24 09:37:34', '2025-04-24 14:09:06'),
(2, 'Makanan', '2025-04-24 13:00:04', '2025-04-24 14:09:10'),
(3, 'Snack', '2025-04-25 07:18:30', '2025-04-25 07:18:30');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_04_24_123747_create_roles_table', 1),
(5, '2025_04_24_124127_create_user_roles_table', 2),
(6, '2025_04_24_160054_create_categories_table', 3),
(7, '2025_04_24_160155_create_products_table', 3),
(8, '2025_04_24_160220_create_orders_table', 3),
(9, '2025_04_24_160307_create_orders_details_table', 3),
(10, '2025_04_25_142544_add_stock_to_products_table', 4),
(11, '2025_04_25_162113_create_stock_histories_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `order_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_date` date NOT NULL,
  `order_amount` decimal(10,2) NOT NULL,
  `order_change` decimal(10,2) NOT NULL,
  `order_status` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_code`, `order_date`, `order_amount`, `order_change`, `order_status`, `created_at`, `updated_at`) VALUES
(1, 'TWPOS-KS-1745515538', '2025-04-24', 15000.00, 5000.00, 1, '2025-04-24 10:25:38', '2025-04-24 10:25:38'),
(2, 'TWPOS-KS-1745515627', '2025-04-24', 15000.00, 5000.00, 1, '2025-04-24 10:27:07', '2025-04-24 10:27:07'),
(3, 'TWPOS-KS-1745515732', '2025-04-24', 15000.00, 5000.00, 1, '2025-04-24 10:28:52', '2025-04-24 10:28:52'),
(4, 'TWPOS-KS-1745588100', '2025-04-25', 10000.00, 0.00, 1, '2025-04-25 06:35:00', '2025-04-25 06:35:00'),
(5, 'TWPOS-KS-1745588140', '2025-04-25', 10000.00, 20000.00, 1, '2025-04-25 06:35:40', '2025-04-25 06:35:40'),
(6, 'TWPOS-KS-1745590869', '2025-04-25', 20000.00, 30000.00, 1, '2025-04-25 07:21:09', '2025-04-25 07:21:09'),
(7, 'TWPOS-KS-1745592858', '2025-04-25', 20000.00, 30000.00, 1, '2025-04-25 07:54:18', '2025-04-25 07:54:18'),
(8, 'TWPOS-KS-1745595312', '2025-04-25', 10000.00, 0.00, 1, '2025-04-25 08:35:12', '2025-04-25 08:35:12'),
(9, 'TWPOS-KS-1745595354', '2025-04-25', 10000.00, 0.00, 1, '2025-04-25 08:35:54', '2025-04-25 08:35:54'),
(10, 'TWPOS-KS-1745595445', '2025-04-25', 10000.00, 0.00, 1, '2025-04-25 08:37:25', '2025-04-25 08:37:25'),
(12, 'TWPOS-KS-1745596407', '2025-04-25', 10000.00, 0.00, 1, '2025-04-25 08:53:27', '2025-04-25 08:53:27'),
(13, 'TWPOS-KS-1745598684', '2025-04-25', 10000.00, 0.00, 1, '2025-04-25 09:31:24', '2025-04-25 09:31:24'),
(14, 'TWPOS-KS-1745598693', '2025-04-25', 48000.00, 52000.00, 1, '2025-04-25 09:31:33', '2025-04-25 09:31:33'),
(15, 'TWPOS-KS-1745606003', '2025-04-25', 382000.00, 18000.00, 1, '2025-04-25 11:33:23', '2025-04-25 11:33:23'),
(16, 'TWPOS-KS-1745653250', '2025-04-26', 15000.00, 5000.00, 1, '2025-04-26 00:40:50', '2025-04-26 00:40:50'),
(17, 'TWPOS-KS-1745656452', '2025-04-26', 20000.00, 0.00, 1, '2025-04-26 01:34:12', '2025-04-26 01:34:12'),
(18, 'TWPOS-KS-1745656560', '2025-04-26', 200000.00, 0.00, 1, '2025-04-26 01:36:00', '2025-04-26 01:36:00'),
(19, 'TWPOS-KS-1745656595', '2025-04-26', 200000.00, 0.00, 1, '2025-04-26 01:36:35', '2025-04-26 01:36:35'),
(20, 'TWPOS-KS-1745656604', '2025-04-26', 15000.00, 5000.00, 1, '2025-04-26 01:36:44', '2025-04-26 01:36:44'),
(21, 'TWPOS-KS-1745656746', '2025-04-26', 15000.00, 5000.00, 1, '2025-04-26 01:39:06', '2025-04-26 01:39:06'),
(22, 'TWPOS-KS-1745656795', '2025-04-26', 729000.00, 0.00, 1, '2025-04-26 01:39:55', '2025-04-26 01:39:55'),
(23, 'TWPOS-KS-1745656829', '2025-04-26', 10000.00, 0.00, 1, '2025-04-26 01:40:29', '2025-04-26 01:40:29'),
(24, 'TWPOS-KS-1745668813', '2025-04-26', 55000.00, 0.00, 1, '2025-04-26 05:00:13', '2025-04-26 05:00:13'),
(27, 'TWPOS-KS-1745671502', '2025-04-26', 75000.00, 25000.00, 1, '2025-04-26 05:45:02', '2025-04-26 05:45:02');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `qty` int NOT NULL,
  `order_price` decimal(10,2) NOT NULL,
  `order_subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `qty`, `order_price`, `order_subtotal`, `created_at`, `updated_at`) VALUES
(4, 4, 3, 1, 10000.00, 10000.00, '2025-04-25 06:35:00', '2025-04-25 06:35:00'),
(5, 5, 3, 1, 10000.00, 10000.00, '2025-04-25 06:35:40', '2025-04-25 06:35:40'),
(6, 6, 3, 2, 10000.00, 20000.00, '2025-04-25 07:21:09', '2025-04-25 07:21:09'),
(7, 7, 3, 2, 10000.00, 20000.00, '2025-04-25 07:54:18', '2025-04-25 07:54:18'),
(8, 8, 3, 1, 10000.00, 10000.00, '2025-04-25 08:35:12', '2025-04-25 08:35:12'),
(9, 9, 3, 1, 10000.00, 10000.00, '2025-04-25 08:35:54', '2025-04-25 08:35:54'),
(10, 10, 3, 1, 10000.00, 10000.00, '2025-04-25 08:37:25', '2025-04-25 08:37:25'),
(12, 12, 3, 1, 10000.00, 10000.00, '2025-04-25 08:53:27', '2025-04-25 08:53:27'),
(13, 13, 3, 1, 10000.00, 10000.00, '2025-04-25 09:31:24', '2025-04-25 09:31:24'),
(14, 14, 4, 4, 12000.00, 48000.00, '2025-04-25 09:31:33', '2025-04-25 09:31:33'),
(15, 15, 5, 1, 25000.00, 25000.00, '2025-04-25 11:33:23', '2025-04-25 11:33:23'),
(16, 15, 6, 1, 20000.00, 20000.00, '2025-04-25 11:33:23', '2025-04-25 11:33:23'),
(17, 15, 7, 2, 20000.00, 40000.00, '2025-04-25 11:33:23', '2025-04-25 11:33:23'),
(18, 15, 8, 1, 15000.00, 15000.00, '2025-04-25 11:33:23', '2025-04-25 11:33:23'),
(19, 15, 4, 1, 12000.00, 12000.00, '2025-04-25 11:33:23', '2025-04-25 11:33:23'),
(20, 15, 3, 1, 10000.00, 10000.00, '2025-04-25 11:33:23', '2025-04-25 11:33:23'),
(21, 15, 10, 2, 15000.00, 30000.00, '2025-04-25 11:33:23', '2025-04-25 11:33:23'),
(22, 15, 9, 1, 15000.00, 15000.00, '2025-04-25 11:33:23', '2025-04-25 11:33:23'),
(23, 15, 11, 13, 15000.00, 195000.00, '2025-04-25 11:33:23', '2025-04-25 11:33:23'),
(24, 15, 12, 1, 20000.00, 20000.00, '2025-04-25 11:33:23', '2025-04-25 11:33:23'),
(25, 16, 9, 1, 15000.00, 15000.00, '2025-04-26 00:40:50', '2025-04-26 00:40:50'),
(26, 17, 12, 1, 20000.00, 20000.00, '2025-04-26 01:34:12', '2025-04-26 01:34:12'),
(27, 18, 12, 10, 20000.00, 200000.00, '2025-04-26 01:36:00', '2025-04-26 01:36:00'),
(28, 19, 12, 10, 20000.00, 200000.00, '2025-04-26 01:36:35', '2025-04-26 01:36:35'),
(29, 20, 11, 1, 15000.00, 15000.00, '2025-04-26 01:36:44', '2025-04-26 01:36:44'),
(30, 21, 9, 1, 15000.00, 15000.00, '2025-04-26 01:39:06', '2025-04-26 01:39:06'),
(31, 22, 5, 7, 25000.00, 175000.00, '2025-04-26 01:39:55', '2025-04-26 01:39:55'),
(32, 22, 6, 2, 20000.00, 40000.00, '2025-04-26 01:39:55', '2025-04-26 01:39:55'),
(33, 22, 9, 3, 15000.00, 45000.00, '2025-04-26 01:39:55', '2025-04-26 01:39:55'),
(34, 22, 10, 4, 15000.00, 60000.00, '2025-04-26 01:39:55', '2025-04-26 01:39:55'),
(35, 22, 3, 4, 10000.00, 40000.00, '2025-04-26 01:39:55', '2025-04-26 01:39:55'),
(36, 22, 4, 2, 12000.00, 24000.00, '2025-04-26 01:39:55', '2025-04-26 01:39:55'),
(37, 22, 8, 3, 15000.00, 45000.00, '2025-04-26 01:39:55', '2025-04-26 01:39:55'),
(38, 22, 7, 4, 20000.00, 80000.00, '2025-04-26 01:39:55', '2025-04-26 01:39:55'),
(39, 22, 11, 4, 15000.00, 60000.00, '2025-04-26 01:39:55', '2025-04-26 01:39:55'),
(40, 22, 12, 8, 20000.00, 160000.00, '2025-04-26 01:39:55', '2025-04-26 01:39:55'),
(41, 23, 3, 1, 10000.00, 10000.00, '2025-04-26 01:40:29', '2025-04-26 01:40:29'),
(42, 24, 14, 1, 20000.00, 20000.00, '2025-04-26 05:00:13', '2025-04-26 05:00:13'),
(43, 24, 12, 1, 20000.00, 20000.00, '2025-04-26 05:00:13', '2025-04-26 05:00:13'),
(44, 24, 11, 1, 15000.00, 15000.00, '2025-04-26 05:00:13', '2025-04-26 05:00:13'),
(53, 27, 15, 5, 15000.00, 75000.00, '2025-04-26 05:45:02', '2025-04-26 05:45:02');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `product_description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `product_name`, `product_photo`, `product_price`, `stock`, `product_description`, `is_active`, `created_at`, `updated_at`) VALUES
(3, 1, 'matcha-latte', 'product/DqT9VhXIzD8EUxWa4QyudZ9QmCH2qS149zdz8SQV.png', 10000.00, 216, '-', 1, '2025-04-24 14:17:18', '2025-04-26 01:40:29'),
(4, 2, 'choco-glaze-donut', 'product/b7KH2zLlOzIFB7oU1nF3a0HgDroW4iDIONXI1rtO.png', 12000.00, 97, '-', 1, '2025-04-25 07:57:56', '2025-04-26 01:39:55'),
(5, 2, 'beef-burger', 'product/AkyvLZckxlR9Di2W6duqz5Ntgs3wsGe0QBhwg9oq.png', 25000.00, 1, '-', 1, '2025-04-25 11:28:53', '2025-04-26 03:07:49'),
(6, 2, 'choco-glaze-donut-peanut', 'product/ovW8RQIFiF1UEdRKcuyAjPnRWEwiLbQjgr9fLhGE.png', 20000.00, 96, '-', 1, '2025-04-25 11:30:22', '2025-04-26 01:39:55'),
(7, 2, 'cinnamon-roll', 'product/F7Kxed6XW71syQ4ERqQ1lmnzMCdMt7ZWYTxkrPC1.png', 20000.00, 0, '-', 1, '2025-04-25 11:30:43', '2025-04-26 03:07:59'),
(8, 1, 'coffee-latte', 'product/g4ANj8KRUeCinUKSQXi4vBLWacZoGa19vINKKxZJ.png', 15000.00, 96, '-', 1, '2025-04-25 11:31:06', '2025-04-26 01:39:55'),
(9, 2, 'croissant', 'product/K40qQsGae7KKVvR9LMRvr1RwpxIa4EMwqfEvU0ol.png', 15000.00, 94, '-', 1, '2025-04-25 11:31:31', '2025-04-26 01:39:55'),
(10, 1, 'ice-chocolate', 'product/og7XSt20mOfTHSL6OoGDOPLSoOXgvCiPmGUWPBMV.png', 15000.00, 144, '-', 1, '2025-04-25 11:31:53', '2025-04-26 01:39:55'),
(11, 1, 'ice-tea', 'product/YaZocsd4Ko9Apej6LcvLoGyIu4Q2eEqh0YIBDqeB.png', 15000.00, 81, '-', 1, '2025-04-25 11:32:12', '2025-04-26 05:00:13'),
(12, 2, 'red-glaze-donut', 'product/MWMsMCyYsywf9g1ksjhEq63xrmZqt6IuPhc1dckU.png', 20000.00, 69, '-', 1, '2025-04-25 11:32:45', '2025-04-26 05:00:13'),
(14, 2, 'sandwich', 'product/CImr2KC72RSlKgMfvWvn0t8Cdq6oUiJ2i3cXyI3k.png', 20000.00, 99, '-', 1, '2025-04-26 04:56:14', '2025-04-26 05:00:13'),
(15, 2, 'sawarma', 'product/7iWuTYFiQVBsypqAtDmLH6tooovsqatczddLmJzG.png', 15000.00, 95, '-', 1, '2025-04-26 04:56:56', '2025-04-26 05:45:02');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'pimpinan', 1, NULL, NULL),
(2, 'admin', 1, NULL, NULL),
(3, 'kasir', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('GN1Hw5tGALpoyjKkGGlxpM84CPUwCefEUIDtofFO', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoib09SQk53bUMzVk81TFM4UWVwU1VUNm5rMGFKYTNYSVUyVng0REdIVCI7czo1OiJhbGVydCI7YTowOnt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fX0=', 1745672667),
('H03r1egtH8y1ORVIdX6Gr2Q1leovAahquqFZ6AKd', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUFpKaHBZNVZMRnBodWYwYThweFYwbkpsTkJiZjJDMjlzQUx4U296ZCI7czo1OiJhbGVydCI7YTowOnt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fX0=', 1745672444);

-- --------------------------------------------------------

--
-- Table structure for table `stock_histories`
--

CREATE TABLE `stock_histories` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `stock_change` int NOT NULL,
  `transaction_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_histories`
--

INSERT INTO `stock_histories` (`id`, `product_id`, `stock_change`, `transaction_type`, `created_at`, `updated_at`) VALUES
(1, 3, -1, 'sale', '2025-04-25 09:31:24', '2025-04-25 09:31:24'),
(2, 4, -4, 'sale', '2025-04-25 09:31:33', '2025-04-25 09:31:33'),
(3, 3, 70, 'restock', '2025-04-25 10:10:08', '2025-04-25 10:10:08'),
(4, 5, -1, 'sale', '2025-04-25 11:33:23', '2025-04-25 11:33:23'),
(5, 6, -1, 'sale', '2025-04-25 11:33:23', '2025-04-25 11:33:23'),
(6, 7, -2, 'sale', '2025-04-25 11:33:23', '2025-04-25 11:33:23'),
(7, 8, -1, 'sale', '2025-04-25 11:33:23', '2025-04-25 11:33:23'),
(8, 4, -1, 'sale', '2025-04-25 11:33:23', '2025-04-25 11:33:23'),
(9, 3, -1, 'sale', '2025-04-25 11:33:23', '2025-04-25 11:33:23'),
(10, 10, -2, 'sale', '2025-04-25 11:33:23', '2025-04-25 11:33:23'),
(11, 9, -1, 'sale', '2025-04-25 11:33:23', '2025-04-25 11:33:23'),
(12, 11, -13, 'sale', '2025-04-25 11:33:23', '2025-04-25 11:33:23'),
(13, 12, -1, 'sale', '2025-04-25 11:33:23', '2025-04-25 11:33:23'),
(14, 3, 1, 'restock', '2025-04-25 11:47:47', '2025-04-25 11:47:47'),
(15, 3, 1, 'restock', '2025-04-25 11:47:48', '2025-04-25 11:47:48'),
(16, 9, -1, 'sale', '2025-04-26 00:40:50', '2025-04-26 00:40:50'),
(17, 12, -1, 'sale', '2025-04-26 01:34:12', '2025-04-26 01:34:12'),
(18, 12, -10, 'sale', '2025-04-26 01:36:00', '2025-04-26 01:36:00'),
(19, 12, -10, 'sale', '2025-04-26 01:36:35', '2025-04-26 01:36:35'),
(20, 11, -1, 'sale', '2025-04-26 01:36:44', '2025-04-26 01:36:44'),
(21, 9, -1, 'sale', '2025-04-26 01:39:06', '2025-04-26 01:39:06'),
(22, 5, -7, 'sale', '2025-04-26 01:39:55', '2025-04-26 01:39:55'),
(23, 6, -2, 'sale', '2025-04-26 01:39:55', '2025-04-26 01:39:55'),
(24, 9, -3, 'sale', '2025-04-26 01:39:55', '2025-04-26 01:39:55'),
(25, 10, -4, 'sale', '2025-04-26 01:39:55', '2025-04-26 01:39:55'),
(26, 3, -4, 'sale', '2025-04-26 01:39:55', '2025-04-26 01:39:55'),
(27, 4, -2, 'sale', '2025-04-26 01:39:55', '2025-04-26 01:39:55'),
(28, 8, -3, 'sale', '2025-04-26 01:39:55', '2025-04-26 01:39:55'),
(29, 7, -4, 'sale', '2025-04-26 01:39:55', '2025-04-26 01:39:55'),
(30, 11, -4, 'sale', '2025-04-26 01:39:55', '2025-04-26 01:39:55'),
(31, 12, -8, 'sale', '2025-04-26 01:39:55', '2025-04-26 01:39:55'),
(32, 3, -1, 'sale', '2025-04-26 01:40:29', '2025-04-26 01:40:29'),
(33, 14, -1, 'sale', '2025-04-26 05:00:13', '2025-04-26 05:00:13'),
(34, 12, -1, 'sale', '2025-04-26 05:00:13', '2025-04-26 05:00:13'),
(35, 11, -1, 'sale', '2025-04-26 05:00:13', '2025-04-26 05:00:13'),
(44, 15, -5, 'sale', '2025-04-26 05:45:02', '2025-04-26 05:45:02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(3, 'Admin', 'admin@gmail.com', NULL, '$2y$12$CoTAANeCP3QvKBdZ/XdL5.6AIDwL/gA2fRYI/fybvGSW03PwDeBT2', NULL, '2025-04-24 09:25:33', '2025-04-24 12:53:24'),
(4, 'Pimpinan', 'pimpinan@gmail.com', NULL, '$2y$12$WNcm5bdEOGvW93DwxWHgBuXIeL4CtxcpVH.hs2xsfW1OnsYCJlDSO', NULL, '2025-04-24 09:25:33', '2025-04-24 14:01:19'),
(5, 'Kasir', 'Kasir@gmail.com', NULL, '$2y$12$oPF.01t4.JfInnhmQR8V8uQKDYZLprvpbyQL/pQ7I0Vg187WVdZ8m', NULL, '2025-04-24 09:25:34', '2025-04-24 14:01:29');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id`, `created_at`, `updated_at`, `user_id`, `role_id`) VALUES
(2, NULL, NULL, 4, 1),
(3, NULL, NULL, 5, 3),
(4, NULL, NULL, 3, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

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
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_details_order_id_foreign` (`order_id`),
  ADD KEY `order_details_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `stock_histories`
--
ALTER TABLE `stock_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_histories_product_id_foreign` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_roles_user_id_foreign` (`user_id`),
  ADD KEY `user_roles_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `stock_histories`
--
ALTER TABLE `stock_histories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `order_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `stock_histories`
--
ALTER TABLE `stock_histories`
  ADD CONSTRAINT `stock_histories_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `user_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `user_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
