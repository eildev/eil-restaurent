-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2024 at 01:58 PM
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
-- Database: `eclipse_pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_transactions`
--

CREATE TABLE `account_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_id` bigint(20) UNSIGNED DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `purpose` varchar(255) DEFAULT NULL,
  `debit` decimal(12,2) DEFAULT NULL,
  `credit` decimal(12,2) DEFAULT NULL,
  `balance` decimal(12,2) NOT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `account_transactions`
--

INSERT INTO `account_transactions` (`id`, `account_id`, `branch_id`, `purpose`, `debit`, `credit`, `balance`, `note`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Deposit', 200000.00, NULL, -200000.00, NULL, '2024-05-06 22:12:22', '2024-05-06 22:12:22'),
(2, 1, 1, 'Deposit', 5000.00, NULL, -205000.00, NULL, '2024-05-06 22:51:31', '2024-05-06 22:51:31'),
(3, 1, 1, 'Deposit', 200000.00, NULL, -405000.00, NULL, '2024-05-06 22:53:47', '2024-05-06 22:53:47'),
(4, 1, 1, 'Deposit', 40000.00, NULL, -445000.00, NULL, '2024-05-06 22:56:12', '2024-05-06 22:56:12'),
(5, 1, 1, 'Deposit', 40000.00, NULL, -485000.00, NULL, '2024-05-06 22:57:39', '2024-05-06 22:57:39'),
(6, 1, 1, 'receive', NULL, 700.00, -484300.00, NULL, '2024-05-06 23:14:21', '2024-05-06 23:14:21'),
(7, 1, 1, 'Withdraw', NULL, 2000.00, -482300.00, NULL, '2024-05-06 23:26:32', '2024-05-06 23:26:32'),
(8, 1, 1, 'Withdraw', NULL, 4000.00, -478300.00, NULL, '2024-05-06 23:43:36', '2024-05-06 23:43:36'),
(9, 1, 1, 'Withdraw', NULL, 1500.00, -476800.00, NULL, '2024-05-07 00:50:38', '2024-05-07 00:50:38'),
(10, 3, 1, 'Withdraw', NULL, 900000.00, 900000.00, NULL, '2024-05-07 00:53:53', '2024-05-07 00:53:53'),
(11, 1, 1, 'Withdraw', NULL, 100.00, -476700.00, NULL, '2024-05-07 03:08:37', '2024-05-07 03:08:37'),
(12, 1, 1, 'Deposit', 20000.00, NULL, -496700.00, NULL, '2024-05-07 03:18:30', '2024-05-07 03:18:30'),
(13, 1, 1, 'Deposit', 10000.00, NULL, -506700.00, NULL, '2024-05-07 03:19:42', '2024-05-07 03:19:42'),
(14, 1, 1, 'Deposit', 189000.00, NULL, -695700.00, NULL, '2024-05-18 18:00:00', '2024-05-18 21:48:11'),
(15, 1, 1, 'Withdraw', NULL, 31500.00, -664200.00, NULL, '2024-05-18 21:57:42', '2024-05-18 21:57:42'),
(16, 1, 1, 'Withdraw', NULL, 31500.00, -632700.00, NULL, '2024-05-18 21:59:13', '2024-05-18 21:59:13'),
(17, 1, 1, 'Deposit', 395978.00, NULL, -1028678.00, NULL, '2024-05-17 18:00:00', '2024-05-18 22:17:04'),
(18, 1, 1, 'Withdraw', NULL, 3000.00, -629700.00, NULL, '2024-05-27 00:08:37', '2024-05-27 00:08:37'),
(19, 5, 1, 'Deposit', 500.00, NULL, -500.00, NULL, '2024-05-26 18:00:00', '2024-05-27 04:12:29'),
(20, 1, 1, 'Withdraw', NULL, 210.00, -629490.00, NULL, '2024-05-27 04:14:52', '2024-05-27 04:14:52');

-- --------------------------------------------------------

--
-- Table structure for table `actual_payments`
--

CREATE TABLE `actual_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `payment_type` enum('receive','pay') NOT NULL,
  `payment_method` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL,
  `date` date DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `actual_payments`
--

INSERT INTO `actual_payments` (`id`, `branch_id`, `payment_type`, `payment_method`, `customer_id`, `supplier_id`, `amount`, `date`, `note`, `created_at`, `updated_at`) VALUES
(1, 1, 'pay', 1, NULL, 1, 200000.00, '2024-05-07', NULL, '2024-05-06 22:12:22', '2024-05-06 22:12:22'),
(2, 1, 'pay', 1, NULL, 1, 5000.00, '2024-05-07', NULL, '2024-05-06 22:51:31', '2024-05-06 22:51:31'),
(3, 1, 'pay', 1, NULL, 1, 200000.00, '2024-05-07', NULL, '2024-05-06 22:53:47', '2024-05-06 22:53:47'),
(4, 1, 'pay', 1, NULL, 1, 40000.00, '2024-05-07', NULL, '2024-05-06 22:56:12', '2024-05-06 22:56:12'),
(5, 1, 'pay', 1, NULL, 1, 40000.00, '2024-05-07', NULL, '2024-05-06 22:57:39', '2024-05-06 22:57:39'),
(6, 1, 'receive', 1, 2, NULL, 700.00, '2024-05-07', NULL, '2024-05-06 23:14:21', '2024-05-06 23:14:21'),
(7, 1, 'receive', 1, 1, NULL, 2000.00, '2023-01-27', NULL, '2024-05-06 23:26:32', '2024-05-06 23:26:32'),
(8, 1, 'receive', 1, 3, NULL, 4000.00, '2024-05-07', NULL, '2024-05-06 23:43:36', '2024-05-06 23:43:36'),
(9, 1, 'receive', 1, 1, NULL, 1500.00, '2024-05-07', NULL, '2024-05-07 00:50:38', '2024-05-07 00:50:38'),
(10, 1, 'receive', 3, 1, NULL, 900000.00, '2024-05-07', NULL, '2024-05-07 00:53:53', '2024-05-07 00:53:53'),
(11, 1, 'pay', 1, NULL, 3, 20000.00, '2024-05-07', NULL, '2024-05-07 03:18:30', '2024-05-07 03:18:30'),
(12, 1, 'pay', 1, NULL, 1, 189000.00, '2024-05-19', NULL, '2024-05-18 21:48:11', '2024-05-18 21:48:11'),
(13, 1, 'receive', 1, 1, NULL, 31500.00, '2024-05-19', NULL, '2024-05-18 21:57:42', '2024-05-18 21:57:42'),
(14, 1, 'receive', 1, 1, NULL, 31500.00, '2024-05-19', NULL, '2024-05-18 21:59:13', '2024-05-18 21:59:13'),
(15, 1, 'pay', 1, NULL, 1, 395978.00, '2024-05-18', NULL, '2024-05-18 22:17:04', '2024-05-18 22:17:04'),
(16, 1, 'receive', 1, 5, NULL, 3000.00, '2024-05-27', NULL, '2024-05-27 00:08:37', '2024-05-27 00:08:37'),
(17, 1, 'pay', 5, NULL, 2, 500.00, '2024-05-27', NULL, '2024-05-27 04:12:29', '2024-05-27 04:12:29'),
(18, 1, 'receive', 1, 5, NULL, 210.00, '2024-05-27', NULL, '2024-05-27 04:14:52', '2024-05-27 04:14:52');

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `branch_name` varchar(150) NOT NULL,
  `manager_name` varchar(150) DEFAULT NULL,
  `phone_number` varchar(20) NOT NULL,
  `account` varchar(255) NOT NULL,
  `email` varchar(200) DEFAULT NULL,
  `opening_balance` decimal(12,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banks`
--

INSERT INTO `banks` (`id`, `name`, `branch_name`, `manager_name`, `phone_number`, `account`, `email`, `opening_balance`, `created_at`, `updated_at`) VALUES
(1, 'Cash', 'Cash', 'Cash', 'Cash', '123456', NULL, 0.00, '2024-05-06 21:37:25', '2024-05-06 21:37:25'),
(2, 'Bkash', 'Mobile Banking', 'Bkash', '01846456834', '01846456834', NULL, 0.00, '2024-05-06 21:38:12', '2024-05-06 21:38:12'),
(3, 'Nagad', 'Mobile Banking', 'Nagad', '01846456834', '01846456834', NULL, 0.00, '2024-05-06 21:39:53', '2024-05-06 21:39:53'),
(4, 'Rocket', 'Mobile Banking', 'Rocket', '01846456834', '01846456834', NULL, 0.00, '2024-05-06 21:42:50', '2024-05-06 21:42:50'),
(5, 'City Bank', 'Banasree Bank', 'something', '04511240555', '04511240555', NULL, 0.00, '2024-05-06 21:43:35', '2024-05-06 21:43:35');

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `logo` varchar(50) DEFAULT NULL,
  `manager_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `name`, `address`, `phone`, `email`, `logo`, `manager_id`, `created_at`, `updated_at`) VALUES
(1, 'Eclipse Blends and Blossom', 'House 41, Road 6, Block E, Banasree, Rampura, Dhaka, Bangladesh', '0191734426', 'ebb@gmail.com', '1357397012.jpg', NULL, '2024-05-06 03:15:55', '2024-05-19 23:40:12');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `slug`, `image`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Local Brand', 'local-brand', NULL, NULL, '2024-05-06 03:40:22', '2024-05-06 03:40:22'),
(2, 'Hatil', 'hatil', NULL, NULL, '2024-05-06 03:40:29', '2024-05-06 03:40:29'),
(3, 'Walton', 'walton', NULL, NULL, '2024-05-06 03:40:37', '2024-05-06 03:40:37'),
(4, 'Samsung', 'samsung', NULL, NULL, '2024-05-06 03:40:44', '2024-05-06 03:40:44'),
(5, 'Apple', 'apple', NULL, NULL, '2024-05-06 03:40:59', '2024-05-06 03:40:59'),
(6, 'Easy', 'easy', NULL, 'Easy Fashion Ltd. | The Most Loved & Top Pioneer Fashion .', '2024-05-27 00:39:49', '2024-05-27 00:39:49');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `slug` varchar(250) DEFAULT NULL,
  `image` varchar(250) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `image`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Food', 'food', NULL, 1, '2024-05-06 03:35:55', '2024-05-27 00:11:29'),
(3, 'Electronics', 'electronics', NULL, 1, '2024-05-06 03:36:17', '2024-05-06 03:36:19'),
(4, 'Fashion', 'fashion', NULL, 1, '2024-05-06 03:36:39', '2024-05-06 03:36:41'),
(5, 'Furniture', 'furniture', NULL, 0, '2024-05-06 03:37:55', '2024-05-06 03:37:55'),
(6, 'Sports', 'sports', NULL, 1, '2024-05-27 00:34:51', '2024-05-27 00:34:57');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `opening_receivable` decimal(12,2) DEFAULT NULL,
  `opening_payable` decimal(12,2) DEFAULT NULL,
  `wallet_balance` decimal(14,2) NOT NULL DEFAULT 0.00,
  `total_receivable` decimal(20,2) NOT NULL DEFAULT 0.00,
  `total_payable` decimal(20,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `branch_id`, `name`, `email`, `phone`, `address`, `opening_receivable`, `opening_payable`, `wallet_balance`, `total_receivable`, `total_payable`, `created_at`, `updated_at`) VALUES
(1, 1, 'Jackob', 'nayemhassan1111@gmail.com', '01723343865', NULL, 0.00, 0.00, 0.00, 967000.00, 967000.00, '2024-05-06 23:02:11', '2024-05-18 21:59:13'),
(3, 1, 'William', NULL, '+1 (349) 525-6061', NULL, 0.00, 0.00, -750.00, 3250.00, 4000.00, '2024-05-06 23:02:58', '2024-05-06 23:43:36'),
(4, 1, 'Jack', 'jack@gmail.oom', '0193096441', 'Bangladesh', 0.00, 0.00, 1000.00, 0.00, 0.00, '2024-05-18 22:56:23', '2024-05-18 22:59:08'),
(5, 1, 'Jack User', 'user@gmail.oom', '019336741', 'Dhaka Bangladesh', NULL, NULL, 20.00, 3210.00, 3210.00, '2024-05-18 23:01:01', '2024-05-27 04:14:52');

-- --------------------------------------------------------

--
-- Table structure for table `damages`
--

CREATE TABLE `damages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL,
  `main_unit_qty` int(11) DEFAULT NULL,
  `sub_unit_qty` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(200) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(200) DEFAULT NULL,
  `nid` varchar(20) DEFAULT NULL,
  `pic` varchar(50) DEFAULT NULL,
  `designation` varchar(50) DEFAULT NULL,
  `salary` decimal(12,2) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `branch_id`, `full_name`, `address`, `phone`, `email`, `nid`, `pic`, `designation`, `salary`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Jack paul', 'Bangladesh', '01933496741', 'jalepaul@gmail.oom', '532323', NULL, 'Nihil voluptatibus', 20000.00, '0', '2024-05-19 01:08:22', '2024-05-19 01:08:22'),
(2, 1, 'Jack User', 'Bangladesh', '0193396741', 'user@gmail.oom', '532323', '566940484.jpg', 'Nihil voluptatibus', 20000.00, '0', '2024-05-19 02:23:07', '2024-05-19 02:23:07');

-- --------------------------------------------------------

--
-- Table structure for table `employee_salaries`
--

CREATE TABLE `employee_salaries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `debit` decimal(12,2) DEFAULT NULL COMMENT 'Submit Salary',
  `creadit` decimal(12,2) DEFAULT NULL COMMENT 'Employee Salary on Employee Salary Table',
  `balance` decimal(12,2) NOT NULL COMMENT 'creadit - debit',
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_salaries`
--

INSERT INTO `employee_salaries` (`id`, `branch_id`, `employee_id`, `date`, `debit`, `creadit`, `balance`, `note`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2024-05-19', 20010.00, 20000.00, -10.00, NULL, '2024-05-19 01:08:41', '2024-05-19 01:09:01'),
(2, 1, 2, '2024-05-29', 5000.00, 20000.00, 15000.00, 'Advance', '2024-05-27 04:24:53', '2024-05-27 04:24:53');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `expense_date` date NOT NULL,
  `expense_category_id` bigint(20) UNSIGNED NOT NULL,
  `purpose` varchar(255) NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `spender` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `bank_account_id` int(11) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `branch_id`, `expense_date`, `expense_category_id`, `purpose`, `amount`, `spender`, `image`, `bank_account_id`, `note`, `created_at`, `updated_at`) VALUES
(1, 1, '2024-05-15', 1, 'Velit officia dolor', 3423.00, 'Splender', NULL, 4, NULL, '2024-05-15 03:24:08', '2024-05-15 03:24:08'),
(2, 1, '2024-05-15', 1, 'Velit officia dolor', 3423.00, 'fsdfsddfds', '422594649.jpg', 3, 'sdf', '2024-05-15 03:41:54', '2024-05-15 05:18:02'),
(3, 1, '2024-05-15', 1, 'Labore qui laborum', 222.00, 'fsdfsd3', NULL, 4, 'ef', '2024-05-15 03:42:22', '2024-05-15 03:42:22'),
(4, 1, '2024-05-29', 2, 'Sale', 500.00, 'Majid', NULL, 5, NULL, '2024-05-27 04:19:54', '2024-05-27 04:19:54');

-- --------------------------------------------------------

--
-- Table structure for table `expense_categories`
--

CREATE TABLE `expense_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expense_categories`
--

INSERT INTO `expense_categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'New', '2024-05-15 03:20:52', '2024-05-15 03:20:52'),
(2, 'Vara', '2024-05-27 04:19:21', '2024-05-27 04:19:21');

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
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
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
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_03_21_060106_create_categories_table', 1),
(6, '2024_03_23_041120_create_sub_categories_table', 1),
(7, '2024_03_24_040653_create_brands_table', 1),
(8, '2024_03_24_041239_create_branches_table', 1),
(9, '2024_03_24_045439_create_customers_table', 1),
(10, '2024_03_25_034000_create_suppliers_table', 1),
(11, '2024_03_27_040311_create_units_table', 1),
(12, '2024_03_27_050102_create_psizes_table', 1),
(13, '2024_03_30_062219_create_banks_table', 1),
(14, '2024_03_30_070215_create_employees_table', 1),
(15, '2024_03_31_035725_create_expense_categories_table', 1),
(16, '2024_03_31_035749_create_expenses_table', 1),
(17, '2024_03_31_075613_create_products_table', 1),
(18, '2024_04_02_043320_create_purchases_table', 1),
(20, '2024_04_02_045010_create_purchase_items_table', 1),
(21, '2024_04_02_051218_create_payment_methods_table', 1),
(22, '2024_04_02_051435_create_actual_payments_table', 1),
(23, '2024_04_02_051856_create_taxes_table', 1),
(25, '2024_04_03_051500_create_transactions_table', 1),
(26, '2024_04_18_084751_create_sales_table', 1),
(27, '2024_04_18_090501_create_sale_items_table', 1),
(28, '2024_04_18_091047_create_pos_settings_table', 1),
(29, '2024_04_18_091250_create_damages_table', 1),
(30, '2024_04_24_063523_create_employee_salaries_table', 1),
(31, '2024_04_30_042330_create_sms_table', 1),
(32, '2024_04_30_043422_create_sms_categories_table', 1),
(33, '2024_04_30_085908_create_jobs_table', 1),
(34, '2024_05_05_094007_create_account_transactions_table', 1),
(35, '2024_04_02_044525_create_promotions_table', 2),
(36, '2024_04_02_062515_create_promotion_details_table', 2),
(37, '2024_05_20_084233_create_permission_tables', 3);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(1, 'App\\Models\\User', 14),
(9, 'App\\Models\\User', 19),
(11, 'App\\Models\\User', 20),
(11, 'App\\Models\\User', 23),
(12, 'App\\Models\\User', 21),
(13, 'App\\Models\\User', 24);

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
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `group_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `group_name`, `created_at`, `updated_at`) VALUES
(17, 'pos.menu', 'web', 'pos', '2024-05-22 07:07:59', '2024-05-22 07:07:59'),
(18, 'pos-manage.menu', 'web', 'pos-manage', '2024-05-22 07:08:44', '2024-05-22 07:08:44'),
(19, 'pos-manage.invoice', 'web', 'pos-manage', '2024-05-22 07:10:03', '2024-05-22 07:10:03'),
(20, 'pos-manage.edit', 'web', 'pos-manage', '2024-05-22 07:10:12', '2024-05-22 07:10:12'),
(21, 'pos-manage.delete', 'web', 'pos-manage', '2024-05-22 07:10:22', '2024-05-22 07:10:22'),
(22, 'products.menu', 'web', 'products', '2024-05-22 07:12:08', '2024-05-22 07:12:08'),
(23, 'products.list', 'web', 'products', '2024-05-22 07:12:22', '2024-05-22 07:12:22'),
(24, 'products.edit', 'web', 'products', '2024-05-22 07:13:26', '2024-05-22 07:13:26'),
(25, 'products.delete', 'web', 'products', '2024-05-22 07:13:44', '2024-05-22 07:13:44'),
(26, 'category.menu', 'web', 'category', '2024-05-22 07:14:46', '2024-05-22 07:14:46'),
(27, 'category.edit', 'web', 'category', '2024-05-22 07:14:59', '2024-05-22 07:14:59'),
(28, 'category.delete', 'web', 'category', '2024-05-22 07:15:13', '2024-05-22 07:15:13'),
(29, 'subcategory.menu', 'web', 'sub-category', '2024-05-22 07:15:50', '2024-05-22 07:15:50'),
(30, 'subcategory.edit', 'web', 'sub-category', '2024-05-22 07:16:01', '2024-05-22 07:16:01'),
(31, 'subcategory.delete', 'web', 'sub-category', '2024-05-22 07:16:16', '2024-05-22 07:16:16'),
(32, 'brand.menu', 'web', 'brand', '2024-05-22 07:17:06', '2024-05-22 07:17:06'),
(33, 'brand.edit', 'web', 'brand', '2024-05-22 07:17:18', '2024-05-22 07:17:18'),
(34, 'brand.delete', 'web', 'brand', '2024-05-22 07:17:30', '2024-05-22 07:17:30'),
(35, 'unit.menu', 'web', 'unit', '2024-05-22 07:18:02', '2024-05-22 07:18:02'),
(36, 'unit.edit', 'web', 'unit', '2024-05-22 07:18:15', '2024-05-22 07:18:15'),
(37, 'unit.delete', 'web', 'unit', '2024-05-22 07:18:30', '2024-05-22 07:18:30'),
(38, 'products-size.menu', 'web', 'product-size', '2024-05-22 07:19:29', '2024-05-22 07:19:29'),
(39, 'products-size.add', 'web', 'product-size', '2024-05-22 07:19:50', '2024-05-22 07:19:50'),
(40, 'products-size.edit', 'web', 'product-size', '2024-05-22 07:20:04', '2024-05-22 07:20:04'),
(41, 'products-size.delete', 'web', 'product-size', '2024-05-22 07:20:19', '2024-05-22 07:20:19'),
(42, 'tax.menu', 'web', 'taxes', '2024-05-22 07:20:48', '2024-05-22 22:27:51'),
(43, 'tax.edit', 'web', 'taxes', '2024-05-22 07:20:59', '2024-05-22 07:20:59'),
(44, 'tax.delete', 'web', 'taxes', '2024-05-22 07:21:11', '2024-05-22 07:21:11'),
(45, 'products.add', 'web', 'products', '2024-05-22 21:56:58', '2024-05-22 21:56:58'),
(46, 'supplier.menu', 'web', 'supplier', '2024-05-22 22:35:04', '2024-05-22 22:35:04'),
(47, 'supplier.edit', 'web', 'supplier', '2024-05-22 22:35:25', '2024-05-22 22:35:25'),
(48, 'supplier.delete', 'web', 'supplier', '2024-05-22 22:35:46', '2024-05-22 22:35:46'),
(49, 'purchase.menu', 'web', 'purchase', '2024-05-22 22:36:30', '2024-05-22 22:36:30'),
(50, 'purchase.add', 'web', 'purchase', '2024-05-22 22:36:48', '2024-05-22 22:36:48'),
(51, 'purchase.list', 'web', 'purchase', '2024-05-22 22:39:14', '2024-05-22 22:39:14'),
(52, 'purchase.edit', 'web', 'purchase', '2024-05-22 22:39:37', '2024-05-22 22:39:37'),
(53, 'purchase.delete', 'web', 'purchase', '2024-05-22 22:39:54', '2024-05-22 22:39:54'),
(54, 'promotion.menu', 'web', 'promotion', '2024-05-22 22:41:02', '2024-05-22 22:41:02'),
(55, 'promotion.add', 'web', 'promotion', '2024-05-22 22:41:22', '2024-05-22 22:41:22'),
(56, 'promotion.edit', 'web', 'promotion', '2024-05-22 22:42:15', '2024-05-22 22:42:15'),
(57, 'promotion.delete', 'web', 'promotion', '2024-05-22 22:42:36', '2024-05-22 22:42:36'),
(58, 'promotion-details.menu', 'web', 'promotion-details', '2024-05-22 22:43:34', '2024-05-22 22:43:34'),
(59, 'promotion-details.add', 'web', 'promotion-details', '2024-05-22 22:43:52', '2024-05-22 22:43:52'),
(60, 'promotion-details.edit', 'web', 'promotion-details', '2024-05-22 22:44:06', '2024-05-22 22:44:06'),
(61, 'promotion-details.delete', 'web', 'promotion-details', '2024-05-22 22:44:19', '2024-05-22 22:44:19'),
(62, 'damage.menu', 'web', 'damage', '2024-05-22 22:45:15', '2024-05-22 22:45:15'),
(63, 'damage.add', 'web', 'damage', '2024-05-22 22:45:33', '2024-05-22 22:45:33'),
(64, 'damage.edit', 'web', 'damage', '2024-05-22 22:45:51', '2024-05-22 22:45:51'),
(65, 'damage.delete', 'web', 'damage', '2024-05-22 22:46:03', '2024-05-22 22:46:03'),
(66, 'bank.menu', 'web', 'bank', '2024-05-22 22:46:44', '2024-05-22 22:46:44'),
(67, 'bank.edit', 'web', 'bank', '2024-05-22 22:46:59', '2024-05-22 22:46:59'),
(68, 'bank..delete', 'web', 'bank', '2024-05-22 22:47:15', '2024-05-22 22:47:15'),
(69, 'expense.menu', 'web', 'expense', '2024-05-22 22:48:15', '2024-05-22 22:48:15'),
(70, 'expense.edit', 'web', 'expense', '2024-05-22 22:48:45', '2024-05-22 22:48:45'),
(71, 'expense.delete', 'web', 'expense', '2024-05-22 22:49:00', '2024-05-22 22:49:00'),
(72, 'transaction.menu', 'web', 'transaction', '2024-05-22 22:49:43', '2024-05-22 22:49:43'),
(73, 'transaction.history', 'web', 'transaction', '2024-05-22 22:50:36', '2024-05-22 22:50:36'),
(74, 'transaction.delete', 'web', 'transaction', '2024-05-22 22:50:52', '2024-05-22 22:50:52'),
(75, 'customer.menu', 'web', 'customer', '2024-05-22 22:51:36', '2024-05-22 22:51:36'),
(76, 'customer.add', 'web', 'customer', '2024-05-22 22:51:54', '2024-05-22 22:51:54'),
(77, 'customer.edit', 'web', 'customer', '2024-05-22 22:52:13', '2024-05-22 22:52:13'),
(78, 'customer.delete', 'web', 'customer', '2024-05-22 22:52:29', '2024-05-22 22:52:29'),
(79, 'employee.menu', 'web', 'employee', '2024-05-22 22:56:49', '2024-05-22 22:56:49'),
(80, 'employee.add', 'web', 'employee', '2024-05-22 22:57:07', '2024-05-22 22:57:07'),
(81, 'employee.edit', 'web', 'employee', '2024-05-22 22:57:21', '2024-05-22 22:57:21'),
(82, 'employee.delete', 'web', 'employee', '2024-05-22 22:57:38', '2024-05-22 22:57:38'),
(83, 'employee-salary.menu', 'web', 'employee-salary', '2024-05-22 22:59:05', '2024-05-22 22:59:05'),
(84, 'employee-salary.add', 'web', 'employee-salary', '2024-05-22 22:59:34', '2024-05-22 22:59:34'),
(85, 'employee-salary.edit', 'web', 'employee-salary', '2024-05-22 22:59:51', '2024-05-22 22:59:51'),
(86, 'employee-salary.delete', 'web', 'employee-salary', '2024-05-22 23:00:08', '2024-05-22 23:00:08'),
(87, 'advanced-employee-salary.menu', 'web', 'advanced-employee-salary', '2024-05-22 23:01:08', '2024-05-22 23:01:08'),
(88, 'employee-salary.list', 'web', 'employee-salary', '2024-05-23 00:08:22', '2024-05-23 00:08:22'),
(89, 'crm.menu', 'web', 'crm', '2024-05-23 00:12:27', '2024-05-23 00:12:27'),
(90, 'crm.customize-customer', 'web', 'crm', '2024-05-23 00:12:53', '2024-05-23 00:12:53'),
(91, 'crm.email-marketing', 'web', 'crm', '2024-05-23 00:13:11', '2024-05-23 00:13:11'),
(92, 'crm.sms-marketing', 'web', 'crm', '2024-05-23 00:13:32', '2024-05-23 00:13:32'),
(93, 'report.menu', 'web', 'report', '2024-05-23 00:23:59', '2024-05-23 00:23:59'),
(94, 'role-and-permission.menu', 'web', 'role-and-permissions', '2024-05-23 00:25:28', '2024-05-23 00:25:28'),
(95, 'role-and-permission.all-permission', 'web', 'role-and-permissions', '2024-05-23 00:26:16', '2024-05-23 00:26:16'),
(96, 'role-and-permission.all-permission.add', 'web', 'role-and-permissions', '2024-05-23 00:27:09', '2024-05-23 00:27:09'),
(97, 'role-and-permission.all-permission.edit', 'web', 'role-and-permissions', '2024-05-23 00:27:29', '2024-05-23 00:27:29'),
(98, 'role-and-permission.all-permission.delete', 'web', 'role-and-permissions', '2024-05-23 00:27:41', '2024-05-23 00:27:41'),
(99, 'role-and-permission.all-role', 'web', 'role-and-permissions', '2024-05-23 00:34:39', '2024-05-23 00:34:39'),
(100, 'role-and-permission.all-role.add', 'web', 'role-and-permissions', '2024-05-23 00:34:56', '2024-05-23 00:34:56'),
(101, 'role-and-permission.all-role.edit', 'web', 'role-and-permissions', '2024-05-23 00:35:11', '2024-05-23 00:35:11'),
(102, 'role-and-permission.all-role.delete', 'web', 'role-and-permissions', '2024-05-23 00:35:26', '2024-05-23 00:35:26'),
(103, 'role-and-permission.role-in-permission', 'web', 'role-and-permissions', '2024-05-23 00:43:57', '2024-05-23 00:43:57'),
(104, 'role-and-permission-check-role-permission', 'web', 'role-and-permissions', '2024-05-23 00:45:35', '2024-05-23 00:45:35'),
(105, 'role-and-permission-check-role-permission.edit', 'web', 'role-and-permissions', '2024-05-23 00:45:48', '2024-05-23 00:45:48'),
(106, 'role-and-permission-check-role-permission.delete', 'web', 'role-and-permissions', '2024-05-23 00:46:02', '2024-05-23 00:46:02'),
(107, 'admin-manage.menu', 'web', 'admin-manage', '2024-05-23 00:49:29', '2024-05-23 00:49:29'),
(108, 'admin-manage.add', 'web', 'admin-manage', '2024-05-23 00:49:43', '2024-05-23 00:49:43'),
(109, 'admin-manage.edit', 'web', 'admin-manage', '2024-05-23 00:50:05', '2024-05-23 00:50:05'),
(110, 'admin-manage.delete', 'web', 'admin-manage', '2024-05-23 00:50:24', '2024-05-23 00:50:24'),
(111, 'admin-manage.list', 'web', 'admin-manage', '2024-05-23 00:50:50', '2024-05-23 00:50:50'),
(112, 'settings.menu', 'web', 'settings', '2024-05-23 00:59:59', '2024-05-23 00:59:59'),
(113, 'branch.menu', 'web', 'branch', '2024-05-23 01:00:24', '2024-05-23 01:00:24'),
(114, 'branch.add', 'web', 'branch', '2024-05-23 01:00:42', '2024-05-23 01:05:27'),
(115, 'branch.edit', 'web', 'branch', '2024-05-23 01:00:56', '2024-05-23 01:00:56'),
(116, 'branch.delete', 'web', 'branch', '2024-05-23 01:01:09', '2024-05-23 01:01:09');

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
-- Table structure for table `pos_settings`
--

CREATE TABLE `pos_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `header_text` varchar(255) DEFAULT NULL,
  `footer_text` varchar(255) DEFAULT NULL,
  `invoice_type` enum('a4','pos') NOT NULL,
  `invoice_logo_type` enum('Logo','Name','Both') NOT NULL DEFAULT 'Logo',
  `barcode_type` enum('single','a4') NOT NULL,
  `low_stock` int(11) NOT NULL DEFAULT 10,
  `dark_mode` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pos_settings`
--

INSERT INTO `pos_settings` (`id`, `company`, `logo`, `address`, `email`, `facebook`, `phone`, `header_text`, `footer_text`, `invoice_type`, `invoice_logo_type`, `barcode_type`, `low_stock`, `dark_mode`, `created_at`, `updated_at`) VALUES
(1, 'EIL POS', NULL, 'Banasree,Dhaka,Bangladesh', 'ebbdemo@gmail.com', 'https:/www.ebb.com', '017..', 'Demo Header', 'Demo Footer', 'a4', 'Logo', 'single', 5, 2, '2024-05-06 03:15:55', '2024-05-27 05:55:20');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `subcategory_id` bigint(20) UNSIGNED NOT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `cost` decimal(8,2) DEFAULT NULL,
  `price` decimal(8,2) NOT NULL,
  `details` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `main_unit_stock` int(11) NOT NULL DEFAULT 0,
  `total_sold` int(11) NOT NULL DEFAULT 0,
  `color` varchar(255) DEFAULT NULL,
  `size_id` int(11) DEFAULT NULL,
  `unit_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `branch_id`, `barcode`, `category_id`, `subcategory_id`, `brand_id`, `cost`, `price`, `details`, `image`, `stock`, `main_unit_stock`, `total_sold`, `color`, `size_id`, `unit_id`, `created_at`, `updated_at`) VALUES
(1, 'Walton Primo X TV', 1, '123456', 3, 3, 3, 18000.00, 30000.00, NULL, NULL, 25, 20, 35, '#000000', 7, 2, '2024-05-06 03:48:45', '2024-05-18 22:17:04'),
(2, 'Walton Mobile HD', 1, '123457', 3, 4, 3, 9000.00, 12000.00, NULL, NULL, 103, 90, 0, '#000000', 6, 2, '2024-05-06 03:56:33', '2024-05-06 22:57:39'),
(3, 'T-shirt', 1, '1234568', 4, 5, 1, 150.00, 250.00, NULL, NULL, 200, 100, 30, '#000000', 1, 2, '2024-05-06 04:03:42', '2024-05-07 03:18:30'),
(4, 'Jeans Pant', 1, '1234569', 4, 6, 1, 350.00, 500.00, NULL, NULL, 109, 100, 1, '#000000', 4, 2, '2024-05-06 04:06:33', '2024-05-06 23:14:21'),
(6, 'Black Coffee', 1, '123465', 2, 1, 1, 90.00, 120.00, NULL, NULL, 110, 200, 0, '#000000', NULL, 2, '2024-05-06 04:26:23', '2024-05-06 22:53:47'),
(7, 'Single Sofa', 1, '879454', 5, 7, 2, 30000.00, 50000.00, NULL, NULL, 15, 20, 0, '#000000', NULL, 2, '2024-05-06 04:28:08', '2024-05-06 22:53:47'),
(8, 'Single Table for single man', 1, '200544', 5, 8, 2, 2000.00, 3000.00, NULL, NULL, 110, 200, 0, '#000000', NULL, 2, '2024-05-06 04:29:04', '2024-05-06 22:56:12'),
(9, 'Fresh Automill Rice', 1, '546413', 2, 2, 1, 50.00, 80.00, NULL, NULL, 125, 200, 0, '#000000', NULL, 1, '2024-05-06 04:30:10', '2024-05-06 22:56:12'),
(10, 'Polo Shirt', 1, '837642', 4, 5, 1, 100.00, 200.00, NULL, '506960915.jpg', 9, 0, 1, '#af4646', 1, 2, '2024-05-19 00:04:39', '2024-05-27 04:14:52'),
(12, 'Pant-1', 1, '515710', 4, 6, 1, 1200.00, 1500.00, NULL, '1249419639.jpg', 8, 0, 2, '#292424', 3, 2, '2024-05-27 00:01:47', '2024-05-27 00:08:37');

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `promotion_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `discount_type` enum('percentage','fixed_amount') NOT NULL,
  `discount_value` int(11) NOT NULL,
  `status` enum('active','expired','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `promotions`
--

INSERT INTO `promotions` (`id`, `promotion_name`, `description`, `start_date`, `end_date`, `discount_type`, `discount_value`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Flat Discount', NULL, '2024-05-01', '2024-05-31', 'percentage', 5, 'active', '2024-05-07 04:25:49', NULL),
(2, 'abc', NULL, '2024-05-01', '2024-05-31', 'percentage', 10, 'active', '2024-05-27 04:26:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `promotion_details`
--

CREATE TABLE `promotion_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `promotion_id` bigint(20) UNSIGNED NOT NULL,
  `promotion_type` enum('wholesale','products','customers','branch') NOT NULL,
  `logic` text NOT NULL,
  `additional_conditions` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `promotion_details`
--

INSERT INTO `promotion_details` (`id`, `promotion_id`, `promotion_type`, `logic`, `additional_conditions`, `created_at`, `updated_at`) VALUES
(1, 2, 'products', '3,10', 1, '2024-05-27 04:28:18', '2024-05-27 04:28:18'),
(2, 2, 'wholesale', 'all', NULL, '2024-05-27 04:47:27', '2024-05-27 04:47:27');

-- --------------------------------------------------------

--
-- Table structure for table `psizes`
--

CREATE TABLE `psizes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `size` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `psizes`
--

INSERT INTO `psizes` (`id`, `category_id`, `size`, `created_at`, `updated_at`) VALUES
(1, 4, 'M', '2024-05-06 03:45:03', '2024-05-06 03:45:03'),
(2, 4, 'S', '2024-05-06 03:45:12', '2024-05-06 03:45:12'),
(3, 4, 'L', '2024-05-06 03:45:21', '2024-05-06 03:45:21'),
(4, 4, 'XL', '2024-05-06 03:45:30', '2024-05-06 03:45:30'),
(5, 4, 'XXL', '2024-05-06 03:45:37', '2024-05-06 03:45:37'),
(6, 3, '12 Inch', '2024-05-06 03:45:51', '2024-05-06 03:45:51'),
(7, 3, '34 inch', '2024-05-06 03:46:01', '2024-05-06 03:46:01'),
(8, 4, 'XL', '2024-05-27 03:51:52', '2024-05-27 03:52:18');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `purchse_date` date NOT NULL,
  `total_quantity` decimal(12,2) NOT NULL,
  `total_amount` decimal(12,2) NOT NULL,
  `invoice` varchar(255) DEFAULT NULL,
  `discount_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `sub_total` decimal(12,2) NOT NULL,
  `tax` int(11) DEFAULT NULL,
  `grand_total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `paid` decimal(12,2) NOT NULL DEFAULT 0.00,
  `due` decimal(12,2) NOT NULL DEFAULT 0.00,
  `carrying_cost` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_method` int(11) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `document` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `branch_id`, `supplier_id`, `purchse_date`, `total_quantity`, `total_amount`, `invoice`, `discount_amount`, `sub_total`, `tax`, `grand_total`, `paid`, `due`, `carrying_cost`, `payment_method`, `note`, `document`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2024-05-07', 20.00, 270000.00, NULL, 0.00, 270000.00, NULL, 270000.00, 200000.00, 70000.00, 0.00, 1, NULL, NULL, '2024-05-06 22:12:22', '2024-05-06 22:12:22'),
(2, 1, 1, '2024-05-07', 20.00, 5000.00, '1', -250.00, 4750.00, NULL, 4750.00, 5000.00, -250.00, 0.00, 1, NULL, NULL, '2024-05-06 22:51:31', '2024-05-06 22:51:31'),
(3, 1, 1, '2024-05-07', 15.00, 150900.00, NULL, 0.00, 150900.00, 5, 158445.00, 200000.00, -41555.00, 0.00, 1, NULL, NULL, '2024-05-06 22:53:47', '2024-05-06 22:53:47'),
(4, 1, 1, '2024-05-07', 35.00, 21250.00, NULL, 0.00, 21250.00, NULL, 21250.00, 40000.00, -18750.00, 0.00, 1, NULL, NULL, '2024-05-06 22:56:12', '2024-05-06 22:56:12'),
(5, 1, 1, '2024-05-07', 3.00, 27000.00, NULL, 0.00, 27000.00, NULL, 27000.00, 40000.00, -13000.00, 0.00, 1, NULL, NULL, '2024-05-06 22:57:39', '2024-05-06 22:57:39'),
(6, 1, 3, '2024-05-07', 200.00, 30000.00, NULL, 0.00, 30000.00, NULL, 30000.00, 10000.00, 0.00, 0.00, 1, NULL, NULL, '2024-05-07 03:18:30', '2024-05-07 03:19:42'),
(7, 1, 1, '2024-05-19', 10.00, 180000.00, NULL, 0.00, 180000.00, 5, 189000.00, 189000.00, 0.00, 0.00, 1, NULL, '210544788.jpg', '2024-05-18 21:48:11', '2024-05-18 21:48:11'),
(8, 1, 1, '2024-05-18', 20.00, 360000.00, NULL, 20.00, 359980.00, 10, 395978.00, 395978.00, 0.00, 2000.00, 1, NULL, NULL, '2024-05-18 22:17:04', '2024-05-18 22:17:04'),
(9, 1, 2, '2024-05-27', 10.00, 1000.00, NULL, 0.00, 1000.00, NULL, 1000.00, 500.00, 500.00, 0.00, 5, NULL, NULL, '2024-05-27 04:12:29', '2024-05-27 04:12:29');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_items`
--

CREATE TABLE `purchase_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_items`
--

INSERT INTO `purchase_items` (`id`, `purchase_id`, `product_id`, `unit_price`, `quantity`, `total_price`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 18000.00, 10, 180000.00, '2024-05-06 22:12:22', '2024-05-06 22:12:22'),
(2, 1, 2, 9000.00, 10, 90000.00, '2024-05-06 22:12:22', '2024-05-06 22:12:22'),
(3, 2, 3, 150.00, 10, 1500.00, '2024-05-06 22:51:31', '2024-05-06 22:51:31'),
(4, 2, 4, 350.00, 10, 3500.00, '2024-05-06 22:51:31', '2024-05-06 22:51:31'),
(5, 3, 6, 90.00, 10, 900.00, '2024-05-06 22:53:47', '2024-05-06 22:53:47'),
(6, 3, 7, 30000.00, 5, 150000.00, '2024-05-06 22:53:47', '2024-05-06 22:53:47'),
(7, 4, 8, 2000.00, 10, 20000.00, '2024-05-06 22:56:12', '2024-05-06 22:56:12'),
(8, 4, 9, 50.00, 25, 1250.00, '2024-05-06 22:56:12', '2024-05-06 22:56:12'),
(9, 5, 2, 9000.00, 3, 27000.00, '2024-05-06 22:57:39', '2024-05-06 22:57:39'),
(10, 6, 3, 150.00, 200, 30000.00, '2024-05-07 03:18:30', '2024-05-07 03:18:30'),
(11, 7, 1, 18000.00, 10, 180000.00, '2024-05-18 21:48:11', '2024-05-18 21:48:11'),
(12, 8, 1, 18000.00, 20, 360000.00, '2024-05-18 22:17:04', '2024-05-18 22:17:04'),
(13, 9, 10, 100.00, 10, 1000.00, '2024-05-27 04:12:29', '2024-05-27 04:12:29');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'web', '2024-05-20 04:09:27', '2024-05-20 04:14:00'),
(9, 'Admin', 'web', '2024-05-22 07:24:25', '2024-05-22 07:24:25'),
(10, 'User', 'web', '2024-05-22 07:24:33', '2024-05-22 07:24:33'),
(11, 'Extra', 'web', '2024-05-22 21:48:22', '2024-05-22 21:48:22'),
(12, 'Employee', 'web', '2024-05-25 22:03:52', '2024-05-25 22:03:52'),
(13, 'Demo', 'web', '2024-05-27 01:42:05', '2024-05-27 01:42:05');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(17, 1),
(17, 13),
(18, 1),
(18, 13),
(19, 1),
(19, 13),
(20, 1),
(20, 13),
(21, 1),
(21, 13),
(22, 1),
(22, 11),
(22, 13),
(23, 1),
(23, 11),
(23, 13),
(24, 1),
(24, 13),
(25, 1),
(25, 13),
(26, 1),
(26, 13),
(27, 1),
(27, 13),
(28, 1),
(28, 13),
(29, 1),
(29, 13),
(30, 1),
(30, 13),
(31, 1),
(31, 13),
(32, 1),
(32, 9),
(32, 10),
(32, 13),
(33, 1),
(33, 9),
(33, 10),
(33, 13),
(34, 1),
(34, 9),
(34, 10),
(34, 13),
(35, 1),
(35, 13),
(36, 1),
(36, 13),
(37, 1),
(37, 13),
(38, 1),
(38, 13),
(39, 1),
(39, 13),
(40, 1),
(40, 13),
(41, 1),
(41, 13),
(42, 1),
(42, 13),
(43, 1),
(43, 13),
(44, 1),
(44, 13),
(45, 1),
(45, 13),
(46, 1),
(46, 13),
(47, 1),
(47, 13),
(48, 1),
(48, 13),
(49, 1),
(49, 13),
(50, 1),
(50, 13),
(51, 1),
(51, 13),
(52, 1),
(52, 13),
(53, 1),
(53, 13),
(54, 1),
(54, 13),
(55, 1),
(55, 13),
(56, 1),
(56, 13),
(57, 1),
(57, 13),
(58, 1),
(58, 13),
(59, 1),
(59, 13),
(60, 1),
(60, 13),
(61, 1),
(61, 13),
(62, 1),
(62, 13),
(63, 1),
(63, 13),
(64, 1),
(64, 13),
(65, 1),
(65, 13),
(66, 1),
(66, 13),
(67, 1),
(67, 13),
(68, 1),
(68, 13),
(69, 1),
(69, 13),
(70, 1),
(70, 13),
(71, 1),
(71, 13),
(72, 1),
(72, 13),
(73, 1),
(73, 13),
(74, 1),
(74, 13),
(75, 1),
(75, 13),
(76, 1),
(76, 13),
(77, 1),
(77, 13),
(78, 1),
(78, 13),
(79, 1),
(79, 13),
(80, 1),
(80, 13),
(81, 1),
(81, 13),
(82, 1),
(82, 13),
(83, 1),
(83, 13),
(84, 1),
(84, 13),
(85, 1),
(85, 13),
(86, 1),
(86, 13),
(87, 1),
(87, 13),
(88, 1),
(88, 13),
(89, 1),
(89, 13),
(90, 1),
(90, 13),
(91, 1),
(91, 13),
(92, 1),
(92, 13),
(93, 1),
(93, 13),
(94, 1),
(94, 13),
(95, 1),
(95, 13),
(96, 1),
(96, 13),
(97, 1),
(98, 1),
(99, 1),
(99, 13),
(100, 1),
(100, 13),
(101, 1),
(102, 1),
(103, 1),
(103, 13),
(104, 1),
(104, 13),
(105, 1),
(106, 1),
(107, 1),
(107, 13),
(108, 1),
(108, 13),
(109, 1),
(110, 1),
(111, 1),
(111, 13),
(112, 1),
(112, 13),
(113, 1),
(113, 12),
(113, 13),
(114, 1),
(114, 12),
(114, 13),
(115, 1),
(115, 12),
(115, 13),
(116, 1),
(116, 12),
(116, 13);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `sale_date` date DEFAULT NULL,
  `sale_by` int(11) DEFAULT NULL,
  `invoice_number` varchar(255) DEFAULT NULL,
  `order_type` enum('general','online') NOT NULL DEFAULT 'general',
  `delivery_charge` decimal(8,2) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `discount` varchar(255) DEFAULT NULL,
  `change_amount` decimal(12,2) DEFAULT NULL,
  `actual_discount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `tax` int(11) DEFAULT NULL,
  `receivable` decimal(12,2) DEFAULT NULL,
  `paid` decimal(12,2) NOT NULL DEFAULT 0.00,
  `returned` decimal(12,2) NOT NULL DEFAULT 0.00,
  `final_receivable` decimal(12,2) NOT NULL DEFAULT 0.00,
  `due` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_purchase_cost` decimal(12,2) DEFAULT NULL,
  `profit` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_method` int(11) NOT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `branch_id`, `customer_id`, `sale_date`, `sale_by`, `invoice_number`, `order_type`, `delivery_charge`, `quantity`, `total`, `discount`, `change_amount`, `actual_discount`, `tax`, `receivable`, `paid`, `returned`, `final_receivable`, `due`, `total_purchase_cost`, `profit`, `payment_method`, `note`, `created_at`, `updated_at`) VALUES
(2, 1, 1, '2023-01-27', 0, '102049', 'general', NULL, 10, 2500.00, NULL, 2500.00, 0.00, NULL, 2500.00, 2500.00, 0.00, 2500.00, 0.00, NULL, 2350.00, 1, NULL, '2024-05-06 23:26:32', '2024-05-07 03:08:37'),
(3, 1, 3, '2024-05-07', 0, '106905', 'general', NULL, 13, 3250.00, NULL, 3250.00, 0.00, NULL, 3250.00, 4000.00, 0.00, 3250.00, -750.00, NULL, 3100.00, 1, NULL, '2024-05-06 23:43:36', '2024-05-06 23:43:36'),
(4, 1, 1, '2024-05-07', 0, '121106', 'general', NULL, 6, 1500.00, NULL, 1500.00, 0.00, NULL, 1500.00, 1500.00, 0.00, 1500.00, 0.00, NULL, 1350.00, 1, NULL, '2024-05-07 00:50:38', '2024-05-07 00:50:38'),
(5, 1, 1, '2024-05-07', 0, '110048', 'general', NULL, 30, 900000.00, NULL, 900000.00, 0.00, NULL, 900000.00, 900000.00, 0.00, 900000.00, 0.00, NULL, 882000.00, 3, NULL, '2024-05-07 00:53:53', '2024-05-07 00:53:53'),
(6, 1, 3, '2024-05-19', 0, '109352', 'general', NULL, 2, 60000.00, 'No Discount', 60000.00, 3000.00, 5, 63000.00, 63000.00, 0.00, 63000.00, 0.00, NULL, 45000.00, 1, NULL, '2024-05-18 21:52:45', '2024-05-18 21:52:45'),
(7, 1, 3, '2024-05-19', 0, '119978', 'general', NULL, 2, 60000.00, 'No Discount', 60000.00, 3000.00, 5, 63000.00, 63000.00, 0.00, 63000.00, 0.00, NULL, 45000.00, 1, NULL, '2024-05-18 21:52:49', '2024-05-18 21:52:49'),
(8, 1, 3, '2024-05-19', 0, '106293', 'general', NULL, 2, 60000.00, 'No Discount', 60000.00, 3000.00, 5, 63000.00, 63000.00, 0.00, 63000.00, 0.00, NULL, 45000.00, 1, NULL, '2024-05-18 21:52:50', '2024-05-18 21:52:50'),
(9, 1, 3, '2024-05-19', 0, '118197', 'general', NULL, 2, 60000.00, 'No Discount', 60000.00, 3000.00, 5, 63000.00, 63000.00, 0.00, 63000.00, 0.00, NULL, 45000.00, 1, NULL, '2024-05-18 21:52:51', '2024-05-18 21:52:51'),
(10, 1, 3, '2024-05-19', 0, '122178', 'general', NULL, 2, 60000.00, 'No Discount', 60000.00, 3000.00, 5, 63000.00, 63000.00, 0.00, 63000.00, 0.00, NULL, 45000.00, 1, NULL, '2024-05-18 21:52:51', '2024-05-18 21:52:51'),
(11, 1, 3, '2024-05-19', 0, '111742', 'general', NULL, 2, 60000.00, 'No Discount', 60000.00, 3000.00, 5, 63000.00, 63000.00, 0.00, 63000.00, 0.00, NULL, 45000.00, 1, NULL, '2024-05-18 21:52:52', '2024-05-18 21:52:52'),
(12, 1, 3, '2024-05-19', 0, '121614', 'general', NULL, 2, 60000.00, 'No Discount', 60000.00, 3000.00, 5, 63000.00, 63000.00, 0.00, 63000.00, 0.00, NULL, 45000.00, 1, NULL, '2024-05-18 21:52:53', '2024-05-18 21:52:53'),
(13, 1, 3, '2024-05-19', 0, '106797', 'general', NULL, 2, 60000.00, 'No Discount', 60000.00, 3000.00, 5, 63000.00, 63000.00, 0.00, 63000.00, 0.00, NULL, 45000.00, 1, NULL, '2024-05-18 21:52:54', '2024-05-18 21:52:54'),
(14, 1, 3, '2024-05-19', 0, '108642', 'general', NULL, 2, 60000.00, 'No Discount', 60000.00, 3000.00, 5, 63000.00, 63000.00, 0.00, 63000.00, 0.00, NULL, 45000.00, 1, NULL, '2024-05-18 21:52:54', '2024-05-18 21:52:54'),
(15, 1, 3, '2024-05-19', 0, '113935', 'general', NULL, 2, 60000.00, 'No Discount', 60000.00, 3000.00, 5, 63000.00, 63000.00, 0.00, 63000.00, 0.00, NULL, 45000.00, 1, NULL, '2024-05-18 21:52:55', '2024-05-18 21:52:55'),
(16, 1, 3, '2024-05-19', 0, '117007', 'general', NULL, 2, 60000.00, 'No Discount', 60000.00, 3000.00, 5, 63000.00, 63000.00, 0.00, 63000.00, 0.00, NULL, 45000.00, 1, NULL, '2024-05-18 21:52:56', '2024-05-18 21:52:56'),
(17, 1, 3, '2024-05-19', 0, '112824', 'general', NULL, 2, 60000.00, 'No Discount', 60000.00, 3000.00, 5, 63000.00, 63000.00, 0.00, 63000.00, 0.00, NULL, 45000.00, 1, NULL, '2024-05-18 21:52:57', '2024-05-18 21:52:57'),
(18, 1, 3, '2024-05-19', 0, '117208', 'general', NULL, 2, 60000.00, 'No Discount', 60000.00, 3000.00, 5, 63000.00, 63000.00, 0.00, 63000.00, 0.00, NULL, 45000.00, 1, NULL, '2024-05-18 21:52:58', '2024-05-18 21:52:58'),
(19, 1, 1, '2024-05-19', 0, '103031', 'general', NULL, 1, 30000.00, 'No Discount', 30000.00, 1500.00, 5, 31500.00, 31500.00, 0.00, 31500.00, 0.00, NULL, 13500.00, 1, NULL, '2024-05-18 21:53:59', '2024-05-18 21:53:59'),
(20, 1, 1, '2024-05-19', 0, '116535', 'general', NULL, 1, 30000.00, 'No Discount', 30000.00, 1500.00, 5, 31500.00, 31500.00, 0.00, 31500.00, 0.00, NULL, 13500.00, 1, NULL, '2024-05-18 21:54:03', '2024-05-18 21:54:03'),
(21, 1, 1, '2024-05-19', 0, '118396', 'general', NULL, 1, 30000.00, 'No Discount', 30000.00, 1500.00, 5, 31500.00, 31500.00, 0.00, 31500.00, 0.00, NULL, 13500.00, 1, NULL, '2024-05-18 21:54:04', '2024-05-18 21:54:04'),
(22, 1, 1, '2024-05-19', 0, '110888', 'general', NULL, 1, 30000.00, 'No Discount', 30000.00, 1500.00, 5, 31500.00, 31500.00, 0.00, 31500.00, 0.00, NULL, 13500.00, 1, NULL, '2024-05-18 21:54:04', '2024-05-18 21:54:04'),
(23, 1, 1, '2024-05-19', 0, '111956', 'general', NULL, 1, 30000.00, 'No Discount', 30000.00, 1500.00, 5, 31500.00, 31500.00, 0.00, 31500.00, 0.00, NULL, 13500.00, 1, NULL, '2024-05-18 21:54:06', '2024-05-18 21:54:06'),
(24, 1, 1, '2024-05-19', 0, '115939', 'general', NULL, 1, 30000.00, 'No Discount', 30000.00, 1500.00, 5, 31500.00, 31500.00, 0.00, 31500.00, 0.00, NULL, 13500.00, 1, NULL, '2024-05-18 21:54:20', '2024-05-18 21:54:20'),
(25, 1, 1, '2024-05-19', 0, '118248', 'general', NULL, 1, 30000.00, 'No Discount', 30000.00, 1500.00, 5, 31500.00, 31500.00, 0.00, 31500.00, 0.00, NULL, 13500.00, 1, NULL, '2024-05-18 21:57:42', '2024-05-18 21:57:42'),
(26, 1, 1, '2024-05-19', 0, '103077', 'general', NULL, 1, 30000.00, 'No Discount', 30000.00, 1500.00, 5, 31500.00, 31500.00, 0.00, 31500.00, 0.00, NULL, 13500.00, 1, NULL, '2024-05-18 21:59:13', '2024-05-18 21:59:13'),
(27, 1, 5, '2024-05-27', 0, '110584', 'general', NULL, 2, 3000.00, 'No Discount', 3000.00, 0.00, NULL, 3000.00, 3000.00, 0.00, 3000.00, 0.00, NULL, 1800.00, 1, NULL, '2024-05-27 00:08:37', '2024-05-27 00:08:37'),
(28, 1, 5, '2024-05-27', 0, '117118', 'general', NULL, 1, 200.00, 'No Discount', 200.00, 10.00, 5, 210.00, 210.00, 0.00, 210.00, 0.00, NULL, 110.00, 1, NULL, '2024-05-27 04:14:52', '2024-05-27 04:14:52');

-- --------------------------------------------------------

--
-- Table structure for table `sale_items`
--

CREATE TABLE `sale_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `rate` decimal(10,2) NOT NULL,
  `discount` int(11) DEFAULT NULL,
  `main_unit_qty` int(11) DEFAULT NULL,
  `sub_unit_qty` int(11) DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `sub_total` decimal(12,2) NOT NULL,
  `total_purchase_cost` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sale_items`
--

INSERT INTO `sale_items` (`id`, `sale_id`, `product_id`, `rate`, `discount`, `main_unit_qty`, `sub_unit_qty`, `qty`, `sub_total`, `total_purchase_cost`, `created_at`, `updated_at`) VALUES
(3, 2, 3, 250.00, NULL, NULL, NULL, 10, 2500.00, 1500.00, '2024-05-06 23:26:32', '2024-05-06 23:26:32'),
(4, 3, 3, 250.00, NULL, NULL, NULL, 13, 3250.00, 1950.00, '2024-05-06 23:43:36', '2024-05-06 23:43:36'),
(5, 4, 3, 250.00, NULL, NULL, NULL, 6, 1500.00, 900.00, '2024-05-07 00:50:38', '2024-05-07 00:50:38'),
(6, 5, 1, 30000.00, NULL, NULL, NULL, 30, 900000.00, 540000.00, '2024-05-07 00:53:53', '2024-05-07 00:53:53'),
(7, 25, 1, 30000.00, 0, NULL, NULL, 3, 30000.00, 54000.00, '2024-05-18 21:57:42', '2024-05-18 21:57:42'),
(8, 26, 1, 30000.00, 0, NULL, NULL, 2, 30000.00, 36000.00, '2024-05-18 21:59:13', '2024-05-18 21:59:13'),
(9, 27, 12, 1500.00, 0, NULL, NULL, 2, 3000.00, 2400.00, '2024-05-27 00:08:37', '2024-05-27 00:08:37'),
(10, 28, 10, 200.00, 0, NULL, NULL, 1, 200.00, 100.00, '2024-05-27 04:14:52', '2024-05-27 04:14:52');

-- --------------------------------------------------------

--
-- Table structure for table `sms`
--

CREATE TABLE `sms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `purpose` varchar(255) DEFAULT NULL,
  `number` varchar(20) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sms`
--

INSERT INTO `sms` (`id`, `customer_id`, `purpose`, `number`, `message`, `created_at`, `updated_at`) VALUES
(1, 1, 'No Purpose', '01723343865', 'Hello', '2024-05-06 23:26:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sms_categories`
--

CREATE TABLE `sms_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `slug` varchar(250) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `category_id`, `name`, `slug`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 'Juice', 'juice', NULL, 0, '2024-05-06 03:38:16', '2024-05-06 03:38:16'),
(2, 2, 'Frozen Food', 'frozen-food', NULL, 0, '2024-05-06 03:38:29', '2024-05-06 03:38:29'),
(3, 3, 'TV or Monitor', 'tv-or-monitor', NULL, 0, '2024-05-06 03:38:46', '2024-05-06 03:38:46'),
(4, 3, 'Mobile', 'mobile', NULL, 0, '2024-05-06 03:38:55', '2024-05-06 03:38:55'),
(5, 4, 'T-shirt', 't-shirt', NULL, 0, '2024-05-06 03:39:05', '2024-05-06 03:39:05'),
(6, 4, 'Pant', 'pant', NULL, 0, '2024-05-06 03:39:17', '2024-05-06 03:39:17'),
(7, 5, 'Sofa', 'sofa', NULL, 0, '2024-05-06 03:39:31', '2024-05-06 03:39:31'),
(8, 5, 'Table', 'table', NULL, 0, '2024-05-06 03:39:39', '2024-05-06 03:39:39'),
(9, 6, 'Jersey', 'jersey', '17639217.jpg', 0, '2024-05-27 00:36:20', '2024-05-27 00:36:20');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `opening_receivable` decimal(12,2) DEFAULT NULL,
  `opening_payable` decimal(12,2) DEFAULT NULL,
  `wallet_balance` decimal(14,2) NOT NULL DEFAULT 0.00,
  `total_receivable` decimal(20,2) NOT NULL DEFAULT 0.00,
  `total_payable` decimal(20,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `branch_id`, `name`, `email`, `phone`, `address`, `opening_receivable`, `opening_payable`, `wallet_balance`, `total_receivable`, `total_payable`, `created_at`, `updated_at`) VALUES
(1, 1, 'Jhon Wick', NULL, '+88 01715000027', NULL, NULL, NULL, -3555.00, 1066423.00, 1069978.00, '2024-05-06 04:30:54', '2024-05-18 22:17:04'),
(2, 1, 'SK Traders', NULL, '+1 (349) 525-6061', NULL, NULL, NULL, 500.00, 1000.00, 500.00, '2024-05-06 04:31:55', '2024-05-27 04:12:29'),
(3, 1, 'PK Traders', NULL, '+88 01715000027', NULL, NULL, NULL, 0.00, 30000.00, 10000.00, '2024-05-06 21:33:51', '2024-05-07 03:19:42'),
(4, 1, 'Super Traders', NULL, '01738743583', NULL, NULL, NULL, 0.00, 0.00, 0.00, '2024-05-06 21:34:16', '2024-05-06 21:34:16'),
(5, 1, 'My Store', NULL, '01984545834', NULL, NULL, NULL, 0.00, 0.00, 0.00, '2024-05-06 21:35:16', '2024-05-06 21:35:16'),
(6, 1, 'user@gmail.oom', 'user11@gmail.oom', '01996741', 'Mymensinh', NULL, NULL, 0.00, 0.00, 0.00, '2024-05-27 03:53:21', '2024-05-27 03:53:21');

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

CREATE TABLE `taxes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `percentage` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `taxes`
--

INSERT INTO `taxes` (`id`, `name`, `percentage`, `created_at`, `updated_at`) VALUES
(1, 'Govt. Tax', '5', '2024-05-06 03:46:37', '2024-05-06 03:46:37'),
(2, '10', '10', '2024-05-06 03:46:51', '2024-05-06 03:46:51'),
(3, '7', '7', '2024-05-06 03:47:02', '2024-05-06 03:47:02'),
(4, '15', '15', '2024-05-06 03:47:10', '2024-05-06 03:47:10');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `payment_type` enum('receive','pay') NOT NULL COMMENT 'Recieve or Pay',
  `particulars` varchar(255) DEFAULT NULL COMMENT 'Purchase #12 or Paid to Supplyer/Sale #10 Received from Customer',
  `customer_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `debit` decimal(12,2) DEFAULT NULL,
  `credit` decimal(12,2) DEFAULT NULL,
  `balance` decimal(14,2) NOT NULL,
  `payment_method` int(11) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `date`, `payment_type`, `particulars`, `customer_id`, `supplier_id`, `debit`, `credit`, `balance`, `payment_method`, `note`, `created_at`, `updated_at`) VALUES
(1, '2024-05-18', 'pay', 'Purchase#8', NULL, 1, 1069978.00, 1066423.00, -3555.00, 1, 'abcd', '2024-05-06 22:12:22', '2024-05-18 22:17:04'),
(2, '2024-05-07', 'receive', 'Sale#1', 2, NULL, 700.00, 748.13, 48.13, 1, NULL, '2024-05-06 23:14:21', '2024-05-06 23:14:21'),
(3, '2024-05-19', 'receive', 'Sale#26', 1, NULL, 966500.00, 967000.00, 500.00, 1, NULL, '2024-05-06 23:26:32', '2024-05-18 21:59:13'),
(4, '2024-05-07', 'receive', 'Sale#2', 1, NULL, 400.00, NULL, 400.00, 1, NULL, '2024-05-06 23:42:32', '2024-05-06 23:42:32'),
(5, '2024-05-07', 'receive', 'Sale#3', 3, NULL, 4000.00, 3250.00, -750.00, 1, NULL, '2024-05-06 23:43:36', '2024-05-06 23:43:36'),
(6, '2024-05-07', 'receive', 'Sale#2', 1, NULL, 100.00, NULL, 100.00, 1, NULL, '2024-05-07 03:08:37', '2024-05-07 03:08:37'),
(7, '2024-05-07', 'pay', 'Purchase#6', NULL, 3, 20000.00, 30000.00, 10000.00, 1, NULL, '2024-05-07 03:18:30', '2024-05-07 03:18:30'),
(8, '2024-05-07', 'pay', 'Purchase#6', NULL, 3, 10000.00, NULL, -10000.00, 1, NULL, '2024-05-07 03:19:42', '2024-05-07 03:19:42'),
(9, '2024-05-27', 'receive', 'Sale#28', 5, NULL, 3210.00, 3210.00, 0.00, 1, NULL, '2024-05-27 00:08:37', '2024-05-27 04:14:52'),
(10, '2024-05-27', 'pay', 'Purchase#9', NULL, 2, 500.00, 1000.00, 500.00, 5, NULL, '2024-05-27 04:12:29', '2024-05-27 04:12:29');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(40) NOT NULL,
  `related_to_unit` varchar(40) DEFAULT NULL,
  `related_sign` varchar(20) DEFAULT NULL,
  `related_by` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `name`, `related_to_unit`, `related_sign`, `related_by`, `created_at`, `updated_at`) VALUES
(1, 'KG', '1', '*', 1000, '2024-05-06 03:41:23', '2024-05-06 03:41:23'),
(2, 'pc', '1', '*', 1, '2024-05-06 03:41:41', '2024-05-06 03:41:41'),
(3, 'Dozon', '12', '/', 12, '2024-05-06 03:42:23', '2024-05-06 03:42:23'),
(4, 'Pair', '2', '/', 2, '2024-05-06 03:42:50', '2024-05-06 03:42:50'),
(5, 'Liter', '1', '*', 1000, '2024-05-06 04:13:26', '2024-05-06 04:13:26'),
(6, 'Pieces', '5', '+', 20, '2024-05-27 00:43:43', '2024-05-27 00:44:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `photo`, `address`, `email_verified_at`, `branch_id`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'EBB', 'ebb@gmail.com', NULL, NULL, NULL, NULL, 1, '$2y$10$HkATiONt8miuTP.kJgmXCumEcebwPc7OSoBeTjJsgzz5rZYcP5u3O', NULL, '2024-05-06 03:15:55', '2024-05-06 03:15:55'),
(19, 'Semi Admin', 'ebb1@gmail.com', '0193396741', NULL, 'Sunt nulla ut nostr', NULL, 1, '$2y$10$RA3PUvj4VC.dddts03aNN.yYT5DdgOevC7OyASP4a3CpMfrwJ5zZW', NULL, '2024-05-22 07:30:31', '2024-05-22 07:30:31'),
(20, 'extra', 'extra@gmail.com', '2846081749', NULL, 'Sunt nulla ut nostr', NULL, 1, '$2y$10$iFMk4rWd9rbeCIaqLptRj.yj9MreG37eLGco5hMgUEVKUmmXu9uvC', NULL, '2024-05-22 22:12:39', '2024-05-22 22:12:39'),
(21, 'Employee', 'employee@gmail.com', '2846081749', NULL, 'Sunt nulla ut nostr', NULL, 1, '$2y$10$CuGn6K9eJrwus8K8EQpoIeiyzkh7JGcGlqpVNipuCSSKanMBWc.si', NULL, '2024-05-25 22:04:45', '2024-05-25 22:04:45'),
(23, 'ebb', 'user1@gmail.Com', '0193396741', NULL, 'Bangladesh', NULL, 1, '$2y$10$9LavoKWTe.v/K6EWNMhpuOolRf.K4AHOS76zk.DtZsIzPO1P2vlh.', NULL, '2024-05-25 22:21:00', '2024-05-25 22:21:00'),
(24, 'Demo', 'demo@gmail.com', '0193396741', NULL, 'Masterbari,Hobirbari, Bhaluka ,Mymensingh, Bangladesh', NULL, 1, '$2y$10$ULaYdtbfIgYuTwQrIV56U.Hp/DopzA7SKRtj8jqucTrWopeXaFfTm', NULL, '2024-05-27 01:41:29', '2024-05-27 03:09:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_transactions`
--
ALTER TABLE `account_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_transactions_account_id_foreign` (`account_id`),
  ADD KEY `account_transactions_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `actual_payments`
--
ALTER TABLE `actual_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `actual_payments_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brands_name_unique` (`name`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customers_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `damages`
--
ALTER TABLE `damages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `damages_branch_id_foreign` (`branch_id`),
  ADD KEY `damages_product_id_foreign` (`product_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employees_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `employee_salaries`
--
ALTER TABLE `employee_salaries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_salaries_branch_id_foreign` (`branch_id`),
  ADD KEY `employee_salaries_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expenses_branch_id_foreign` (`branch_id`),
  ADD KEY `expenses_expense_category_id_foreign` (`expense_category_id`);

--
-- Indexes for table `expense_categories`
--
ALTER TABLE `expense_categories`
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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `pos_settings`
--
ALTER TABLE `pos_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_barcode_unique` (`barcode`),
  ADD KEY `products_branch_id_foreign` (`branch_id`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_subcategory_id_foreign` (`subcategory_id`),
  ADD KEY `products_brand_id_foreign` (`brand_id`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promotion_details`
--
ALTER TABLE `promotion_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `promotion_details_promotion_id_foreign` (`promotion_id`);

--
-- Indexes for table `psizes`
--
ALTER TABLE `psizes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `psizes_category_id_foreign` (`category_id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchases_branch_id_foreign` (`branch_id`),
  ADD KEY `purchases_supplier_id_foreign` (`supplier_id`);

--
-- Indexes for table `purchase_items`
--
ALTER TABLE `purchase_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_items_purchase_id_foreign` (`purchase_id`),
  ADD KEY `purchase_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_branch_id_foreign` (`branch_id`),
  ADD KEY `sales_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_items_sale_id_foreign` (`sale_id`);

--
-- Indexes for table `sms`
--
ALTER TABLE `sms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sms_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `sms_categories`
--
ALTER TABLE `sms_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_categories_category_id_foreign` (`category_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `suppliers_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `taxes`
--
ALTER TABLE `taxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
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
-- AUTO_INCREMENT for table `account_transactions`
--
ALTER TABLE `account_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `actual_payments`
--
ALTER TABLE `actual_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `damages`
--
ALTER TABLE `damages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `employee_salaries`
--
ALTER TABLE `employee_salaries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `expense_categories`
--
ALTER TABLE `expense_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pos_settings`
--
ALTER TABLE `pos_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `promotion_details`
--
ALTER TABLE `promotion_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `psizes`
--
ALTER TABLE `psizes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `purchase_items`
--
ALTER TABLE `purchase_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `sms`
--
ALTER TABLE `sms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sms_categories`
--
ALTER TABLE `sms_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `taxes`
--
ALTER TABLE `taxes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account_transactions`
--
ALTER TABLE `account_transactions`
  ADD CONSTRAINT `account_transactions_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `banks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `account_transactions_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `actual_payments`
--
ALTER TABLE `actual_payments`
  ADD CONSTRAINT `actual_payments_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `damages`
--
ALTER TABLE `damages`
  ADD CONSTRAINT `damages_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `damages_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_salaries`
--
ALTER TABLE `employee_salaries`
  ADD CONSTRAINT `employee_salaries_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employee_salaries_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `expenses_expense_category_id_foreign` FOREIGN KEY (`expense_category_id`) REFERENCES `expense_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `sub_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `promotion_details`
--
ALTER TABLE `promotion_details`
  ADD CONSTRAINT `promotion_details_promotion_id_foreign` FOREIGN KEY (`Promotion_id`) REFERENCES `promotions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `psizes`
--
ALTER TABLE `psizes`
  ADD CONSTRAINT `psizes_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchases_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchase_items`
--
ALTER TABLE `purchase_items`
  ADD CONSTRAINT `purchase_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchase_items_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sales_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD CONSTRAINT `sale_items_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sms`
--
ALTER TABLE `sms`
  ADD CONSTRAINT `sms_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD CONSTRAINT `sub_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD CONSTRAINT `suppliers_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
