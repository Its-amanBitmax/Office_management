-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2025 at 10:07 AM
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
-- Database: `task`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('pending','active','completed') NOT NULL DEFAULT 'pending',
  `schedule_at` datetime DEFAULT NULL,
  `scoring_scope` enum('selected','all') NOT NULL DEFAULT 'selected',
  `best_employee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `best_employee_description` text DEFAULT NULL,
  `keep_best_employee` tinyint(1) NOT NULL DEFAULT 0,
  `enable_best_employee` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `activity_employee`
--

CREATE TABLE `activity_employee` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `activity_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `user_type` enum('admin','employee') NOT NULL,
  `action` varchar(255) NOT NULL,
  `model` varchar(255) DEFAULT NULL,
  `model_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` text NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `user_type`, `action`, `model`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`) VALUES
(1, 1, 'admin', 'update', 'Employee', 1, 'Employee updated successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-26 16:28:07', '2025-09-26 16:28:07'),
(2, 1, 'admin', 'logout', NULL, NULL, 'Admin Aman logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-26 16:37:03', '2025-09-26 16:37:03'),
(3, 1, 'admin', 'login', NULL, NULL, 'Admin Aman logged in', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-26 16:37:06', '2025-09-26 16:37:06'),
(4, 1, 'admin', 'logout', NULL, NULL, 'Admin Aman logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-26 16:43:14', '2025-09-26 16:43:14'),
(5, 1, 'admin', 'login', NULL, NULL, 'Admin Aman logged in', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-26 16:43:17', '2025-09-26 16:43:17'),
(6, 1, 'admin', 'logout', NULL, NULL, 'Admin Aman logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-27 04:10:59', '2025-09-27 04:10:59'),
(7, 1, 'admin', 'login', NULL, NULL, 'Admin Aman logged in', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-27 04:11:02', '2025-09-27 04:11:02'),
(8, 1, 'admin', 'logout', NULL, NULL, 'Admin Aman logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-27 04:24:00', '2025-09-27 04:24:00'),
(9, 1, 'admin', 'login', NULL, NULL, 'Admin Aman logged in', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-27 04:24:04', '2025-09-27 04:24:04'),
(10, 2, 'admin', 'login', NULL, NULL, 'Admin Sakshi Sharma logged in', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-27 04:24:40', '2025-09-27 04:24:40'),
(11, 2, 'admin', 'logout', NULL, NULL, 'Admin Sakshi Sharma logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-27 04:27:47', '2025-09-27 04:27:47'),
(12, 1, 'admin', 'login', NULL, NULL, 'Admin Aman logged in', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-27 04:30:45', '2025-09-27 04:30:45'),
(13, 2, 'admin', 'login', NULL, NULL, 'Admin Sakshi Sharma logged in', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-27 04:41:49', '2025-09-27 04:41:49'),
(14, 2, 'admin', 'create', 'Expense', 3, 'Created expense: Cleaning item for ₹1300', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-27 04:42:52', '2025-09-27 04:42:52'),
(15, 2, 'admin', 'create', 'Expense', 4, 'Created expense: Cleaning item for ₹1300', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-27 04:42:52', '2025-09-27 04:42:52'),
(16, 2, 'admin', 'delete', 'Expense', 4, 'Deleted expense: Cleaning item for ₹1300.00', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-27 04:43:07', '2025-09-27 04:43:07'),
(17, 1, 'admin', 'logout', NULL, NULL, 'Admin Aman logged out', '127.0.0.1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Mobile Safari/537.36', '2025-09-27 06:22:29', '2025-09-27 06:22:29'),
(18, 1, 'admin', 'login', NULL, NULL, 'Admin Aman logged in', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-27 06:28:47', '2025-09-27 06:28:47'),
(19, 1, 'admin', 'logout', NULL, NULL, 'Admin Aman logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-27 07:40:35', '2025-09-27 07:40:35'),
(20, 1, 'admin', 'login', NULL, NULL, 'Admin Aman logged in', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-27 07:56:20', '2025-09-27 07:56:20'),
(21, 1, 'admin', 'logout', NULL, NULL, 'Admin Aman logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-27 07:58:10', '2025-09-27 07:58:10'),
(22, 1, 'admin', 'login', NULL, NULL, 'Admin Aman logged in', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-27 08:02:30', '2025-09-27 08:02:30'),
(23, 1, 'admin', 'update', 'Employee', 1, 'Employee updated successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-27 08:02:56', '2025-09-27 08:02:56');

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `address_type` varchar(50) NOT NULL,
  `street_address` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `employee_id`, `address_type`, `street_address`, `city`, `state`, `postal_code`, `country`, `created_at`, `updated_at`) VALUES
(29, 1, 'current', 'Gali no. 2', 'Greater Noida', 'Uttar Pradesh', '201306', 'India', '2025-09-27 08:02:56', '2025-09-27 08:02:56');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `company_logo` varchar(255) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('super_admin','sub_admin') NOT NULL DEFAULT 'sub_admin',
  `permissions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`permissions`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `phone`, `bio`, `profile_image`, `company_logo`, `company_name`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `permissions`) VALUES
(1, 'Aman', 'aman.profficial@gmail.com', '7065170513', 'hi! I am the Boss...', '1758947869.jpg', '1758947855.png', 'Bitmax technologies', NULL, '$2y$12$0RVXEiKrRFqYS1lSqXApouV6yPgoIYtwDKPN3rTg.lj2/GZdpuo..', NULL, NULL, '2025-09-27 04:37:49', 'super_admin', NULL),
(2, 'Sakshi Sharma', 'hr@bitmaxgroup.com', '9211318269', 'Hr', NULL, NULL, NULL, NULL, '$2y$12$2r2yWIPEyueIxRulNEe5de8r31PE6PsrdJEJZzZlgzGMCSOYM3cmS', NULL, '2025-09-24 05:28:00', '2025-09-26 07:45:22', 'sub_admin', '[\"Dashboard\",\"employees\",\"Employee Card\",\"attendance\",\"salary-slips\",\"expenses\",\"settings\"]');

-- --------------------------------------------------------

--
-- Table structure for table `assigned_items`
--

CREATE TABLE `assigned_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `stock_item_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `quantity_assigned` int(11) NOT NULL,
  `assigned_date` date NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `status` enum('Present','Absent','Leave','Half Day') NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bank_details`
--

CREATE TABLE `bank_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `account_number` varchar(50) DEFAULT NULL,
  `ifsc_code` varchar(50) DEFAULT NULL,
  `branch_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bank_details`
--

INSERT INTO `bank_details` (`id`, `employee_id`, `bank_name`, `account_number`, `ifsc_code`, `branch_name`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, NULL, NULL, '2025-09-05 23:25:50', '2025-09-05 23:37:54');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `criteria`
--

CREATE TABLE `criteria` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `activity_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `max_points` int(11) NOT NULL DEFAULT 10,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `document_type` varchar(100) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `employee_id`, `document_type`, `file_path`, `created_at`, `updated_at`) VALUES
(6, 1, 'aadhar', 'documents/NRZ5CukUpMJqWOcTcKjiGDtPXB2rZjz3XtdP9zVz.pdf', '2025-09-27 08:02:57', '2025-09-27 08:02:57');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_code` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `account_number` varchar(50) DEFAULT NULL,
  `ifsc_code` varchar(20) DEFAULT NULL,
  `branch_name` varchar(255) DEFAULT NULL,
  `basic_salary` decimal(10,2) DEFAULT NULL,
  `hra` decimal(10,2) DEFAULT NULL,
  `conveyance` decimal(10,2) DEFAULT NULL,
  `medical` decimal(10,2) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `hire_date` date NOT NULL,
  `position` varchar(100) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'active',
  `profile_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `dob` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `employee_code`, `name`, `email`, `password`, `bank_name`, `account_number`, `ifsc_code`, `branch_name`, `basic_salary`, `hra`, `conveyance`, `medical`, `phone`, `hire_date`, `position`, `department`, `status`, `profile_image`, `created_at`, `updated_at`, `dob`) VALUES
(1, 'EMP001', 'Aman Singh', 'aman@bitmaxgroup.com', '$2y$12$82AkiZ6paFEJS9Hovf3RueHCoLeN.Xd2RoEFYmTveRHysqXH7BcxG', 'PNB', '473858464376', 'ABCDE1234F', 'Sector 62', 18000.00, 0.00, 0.00, 0.00, '7065170513', '2025-05-07', 'Laravel Developer', 'Development', 'active', 'profile_images/GS45DGmtQGtTzDwqluVBEqjM3rEMiNDHQQdwNyiz.jpg', '2025-09-05 04:18:47', '2025-09-24 02:48:24', '2006-12-14'),
(6, 'EMP002', 'Priya Patel', 'priya.patel@company.com', '$2y$12$nT76a1Au/NIcKNIEzx2qY.SpsAMj26r.RqsyJBfAl8VW6tH9WH9Gi', 'HDFC Bank', '234567890123', 'HDFC0001234', 'Sector 18, Noida', 60000.00, 18000.00, 19200.00, 6000.00, '+91-9876543211', '2023-02-20', 'HR Manager', 'Human Resources', 'active', NULL, '2025-09-07 11:18:06', '2025-09-07 11:18:06', NULL),
(7, 'EMP003', 'Amit Kumar', 'amit.kumar@company.com', '$2y$12$RumiR5/jpDHT../rySApH.SoCYFVwqKOYKf.71JoNUdLJhtD07mLa', 'ICICI Bank', '345678901234', 'ICIC0001234', 'Rajouri Garden, Delhi', 75000.00, 22500.00, 19200.00, 7500.00, '+91-9876543212', '2023-03-10', 'Project Manager', 'IT', 'active', NULL, '2025-09-07 11:18:06', '2025-09-07 11:18:06', NULL),
(8, 'EMP004', 'Sneha Gupta', 'sneha.gupta@company.com', '$2y$12$Q2nJ4j5CHI0RQzL1.l5nZe01lQEVWuSPKZJBGdP0EqcdwFqh9f3GC', 'Axis Bank', '456789012345', 'UTIB0001234', 'Karol Bagh, Delhi', 55000.00, 16500.00, 19200.00, 5500.00, '+91-9876543213', '2023-04-05', 'UI/UX Designer', 'Design', 'active', NULL, '2025-09-07 11:18:06', '2025-09-07 11:18:06', NULL),
(9, 'EMP005', 'Vikram Singh', 'vikram.singh@company.com', '$2y$12$D1eUchVc95LJ0bryHvb7eug8v0318jJKhK6j7yeg5HEbV7ASOv5Um', 'Punjab National Bank', '567890123456', 'PUNB0123456', 'Lajpat Nagar, Delhi', 65000.00, 19500.00, 19200.00, 6500.00, '+91-9876543214', '2023-05-12', 'Business Analyst', 'Business', 'active', NULL, '2025-09-07 11:18:06', '2025-09-07 11:18:06', NULL),
(10, 'EMP006', 'Kavita Jain', 'kavita.jain@company.com', '$2y$12$r3JK.jhZ.jctgvvNX2rakeZw3s58fOe0OyGeLd3WfJtYYdTsdmc.y', 'Kotak Mahindra Bank', '678901234567', 'KKBK0001234', 'Nehru Place, Delhi', 45000.00, 13500.00, 19200.00, 4500.00, '+91-9876543215', '2023-06-18', 'Marketing Executive', 'Marketing', 'active', NULL, '2025-09-07 11:18:06', '2025-09-07 11:18:06', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `category` varchar(255) NOT NULL,
  `expense_date` date NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `title`, `amount`, `category`, `expense_date`, `created_by`, `created_at`, `updated_at`) VALUES
(2, 'Snacks', 500.00, 'milk,sweets', '2025-09-26', 1, '2025-09-26 09:15:44', '2025-09-26 09:15:44'),
(3, 'Cleaning item', 1300.00, 'tissues, lizol', '2025-09-27', 2, '2025-09-27 04:42:52', '2025-09-27 04:42:52');

-- --------------------------------------------------------

--
-- Table structure for table `expense_budget`
--

CREATE TABLE `expense_budget` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `budget_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `remaining_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expense_budget`
--

INSERT INTO `expense_budget` (`id`, `budget_amount`, `remaining_amount`, `created_at`, `updated_at`) VALUES
(1, 6000.00, 4200.00, '2025-09-26 07:22:46', '2025-09-27 04:43:07');

-- --------------------------------------------------------

--
-- Table structure for table `expense_budget_history`
--

CREATE TABLE `expense_budget_history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `action` enum('add','update') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `old_budget` decimal(10,2) NOT NULL,
  `new_budget` decimal(10,2) NOT NULL,
  `remaining` decimal(10,2) NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expense_budget_history`
--

INSERT INTO `expense_budget_history` (`id`, `action`, `amount`, `old_budget`, `new_budget`, `remaining`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'add', 1000.00, 5000.00, 6000.00, 5500.00, 1, '2025-09-26 09:52:00', '2025-09-26 09:52:00');

-- --------------------------------------------------------

--
-- Table structure for table `experiences`
--

CREATE TABLE `experiences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `responsibilities` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `experiences`
--

INSERT INTO `experiences` (`id`, `employee_id`, `company_name`, `position`, `start_date`, `end_date`, `responsibilities`, `created_at`, `updated_at`) VALUES
(30, 1, 'BMDU', 'Laravel Developer', NULL, NULL, NULL, '2025-09-27 08:02:56', '2025-09-27 08:02:56');

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
-- Table structure for table `family_details`
--

CREATE TABLE `family_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `relation` varchar(50) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `contact_number` varchar(50) DEFAULT NULL,
  `aadhar` text DEFAULT NULL,
  `pan` text DEFAULT NULL,
  `aadhar_file` varchar(255) DEFAULT NULL,
  `pan_file` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `family_details`
--

INSERT INTO `family_details` (`id`, `employee_id`, `relation`, `name`, `contact_number`, `aadhar`, `pan`, `aadhar_file`, `pan_file`, `created_at`, `updated_at`) VALUES
(17, 1, 'father', 'Amrender Singh', '7065170513', '834758348587', 'ADVHA82389SD', 'documents/20p5wVP8cRgTSd0N7YbsWzYCZaDpbS9EPMAxADcg.png', 'documents/eTmsaAP9ZJ31aUKvZhQEaHRxHcshl6iQSID4f117.png', '2025-09-06 00:38:57', '2025-09-06 00:45:20');

-- --------------------------------------------------------

--
-- Table structure for table `invited_visitors`
--

CREATE TABLE `invited_visitors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `purpose` varchar(255) DEFAULT NULL,
  `invited_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
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
(1, '2025_09_05_094940_rename_payroll_table_to_payrolls', 1),
(2, '2025_09_05_115846_create_reports_table', 2),
(3, '2025_09_06_045341_make_relation_nullable_in_family_details_table', 3),
(4, '2025_09_06_045459_make_name_nullable_in_family_details_table', 4),
(5, '2025_09_06_050108_alter_payrolls_table_make_net_salary_nullable_and_payment_date_nullable', 5),
(6, '2025_09_06_050701_make_bank_name_and_account_number_nullable_in_bank_details_table', 6),
(7, '2025_09_06_050819_make_basic_salary_nullable_in_payrolls_table', 7),
(8, '2025_09_06_070848_add_rating_to_reports_table', 8),
(9, '2025_09_06_073416_add_task_id_to_reports_table', 9),
(10, '2025_09_06_091711_add_team_created_by_to_tasks_table', 10),
(11, '2025_09_06_110400_update_team_created_by_enum_in_tasks_table', 11),
(12, '2025_09_07_063507_add_review_columns_to_reports_table', 12),
(13, '2025_09_07_075536_create_ratings_table', 13),
(14, '2024_06_01_000000_add_company_logo_and_name_to_admin_table', 14),
(15, '2024_06_02_000000_add_phone_company_to_admins_table', 15),
(16, '2025_09_07_100000_create_activities_table', 16),
(17, '2025_09_07_110000_create_activity_employee_table', 17),
(18, '2024_09_07_110000_create_activity_employee_table', 18),
(23, '2025_09_07_181759_add_scoring_scope_to_activities_table', 19),
(24, '2025_09_07_180138_create_criteria_table', 20),
(25, '2025_09_08_000000_add_best_employee_fields_to_activities_table', 21),
(26, '2025_09_08_000001_add_enable_best_employee_to_activities_table', 22),
(27, '2025_09_09_103606_create_attendances_table', 23),
(28, '2025_09_10_000000_create_salary_slips_table', 24),
(29, '2025_09_11_000000_create_visitors_table', 25),
(30, '2025_09_12_000000_create_invited_visitors_table', 26),
(31, '2025_09_23_124911_add_dob_to_employees_table', 27),
(32, '2025_09_23_172127_create_stock_items_table', 28),
(33, '2025_09_23_172153_create_assigned_items_table', 29),
(34, '2025_09_24_101925_add_role_and_permissions_to_admins_table', 30),
(37, '2025_09_26_120445_create_expenses_table', 31),
(38, '2025_09_26_130000_create_expense_budget_table', 32),
(39, '2025_09_26_150704_create_expense_budget_history_table', 33),
(40, '2025_09_26_151934_add_remaining_to_expense_budget_history_table', 34),
(41, '2025_09_26_213835_create_activity_logs_table', 35);

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
-- Table structure for table `payrolls`
--

CREATE TABLE `payrolls` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `basic_salary` decimal(10,2) DEFAULT NULL,
  `bonus` decimal(10,2) NOT NULL DEFAULT 0.00,
  `deductions` decimal(10,2) NOT NULL DEFAULT 0.00,
  `net_salary` decimal(10,2) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payrolls`
--

INSERT INTO `payrolls` (`id`, `employee_id`, `basic_salary`, `bonus`, `deductions`, `net_salary`, `payment_date`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 0.00, 0.00, NULL, NULL, '2025-09-05 23:33:09', '2025-09-05 23:39:12');

-- --------------------------------------------------------

--
-- Table structure for table `points`
--

CREATE TABLE `points` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `activity_id` bigint(20) UNSIGNED NOT NULL,
  `from_employee_id` bigint(20) UNSIGNED NOT NULL,
  `to_employee_id` bigint(20) UNSIGNED NOT NULL,
  `criteria_id` bigint(20) UNSIGNED NOT NULL,
  `points` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `qualifications`
--

CREATE TABLE `qualifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `degree` varchar(255) NOT NULL,
  `institution` varchar(255) NOT NULL,
  `year_of_passing` int(11) NOT NULL,
  `grade` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `qualifications`
--

INSERT INTO `qualifications` (`id`, `employee_id`, `degree`, `institution`, `year_of_passing`, `grade`, `created_at`, `updated_at`) VALUES
(31, 1, '12th', 'MBS', 2024, '60', '2025-09-27 08:02:56', '2025-09-27 08:02:56');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `stars` tinyint(3) UNSIGNED NOT NULL,
  `rating_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `employee_id`, `stars`, `rating_date`, `created_at`, `updated_at`) VALUES
(3, 1, 5, '2025-09-07', '2025-09-07 02:35:21', '2025-09-07 02:35:21');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `task_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `sent_to_admin` tinyint(1) NOT NULL DEFAULT 1,
  `sent_to_team_lead` tinyint(1) NOT NULL DEFAULT 0,
  `team_lead_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('sent','read','responded') NOT NULL DEFAULT 'sent',
  `review` text DEFAULT NULL,
  `rating` tinyint(3) UNSIGNED DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `admin_review` text DEFAULT NULL,
  `admin_rating` int(11) DEFAULT NULL,
  `admin_status` enum('sent','read','responded') DEFAULT NULL,
  `team_lead_review` text DEFAULT NULL,
  `team_lead_rating` int(11) DEFAULT NULL,
  `team_lead_status` enum('sent','read','responded') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salary_slips`
--

CREATE TABLE `salary_slips` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `month` varchar(255) NOT NULL,
  `year` year(4) NOT NULL,
  `basic_salary` decimal(10,2) NOT NULL,
  `hra` decimal(10,2) NOT NULL DEFAULT 0.00,
  `conveyance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `medical` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_working_days` int(11) NOT NULL,
  `present_days` int(11) NOT NULL,
  `absent_days` int(11) NOT NULL,
  `leave_days` int(11) NOT NULL,
  `half_day_count` int(11) NOT NULL,
  `gross_salary` decimal(10,2) NOT NULL,
  `deductions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`deductions`)),
  `net_salary` decimal(10,2) NOT NULL,
  `generated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `pdf_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('3fJykNadeEdCOl8RBFI2e63y1hJ2NJcRRWOXfw2h', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZXB6dGppVm1UUlBGSmFtME4zZEtXaVhadUhmdWlnd0tXVU9tZU9FYyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9lbXBsb3llZXMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUyOiJsb2dpbl9hZG1pbl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1758960178),
('9DyIETVi8aNxQimCujW1MWcubHGk0RBk0u6WEPmi', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZWlodFFnREFUd3E0M1F0eDhjMkRQSWtCb1Vud3puRUVEVE1aZmpLNSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9lbXBsb3llZS9wcm9maWxlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1NToibG9naW5fZW1wbG95ZWVfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1758960334),
('CRQCMwulGihhDJ75DQ7HfD7JcsaJwMfyLP2aLovP', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoieDNpRlNSZzlOTGRFbkdFMlVsMkh3NDA0eWNiakxpV1hyaFNMeXUwUCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9leHBlbnNlcyI7fXM6NTI6ImxvZ2luX2FkbWluXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1758947339),
('PmF9gwBWgA2eIwuaVvQk28cj6tE21SCbEAcZvEcC', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiamtmZVJVVWNUWGlWMzlzMEdvYVRaMWI3eThtTXR4WUNsMEJwTDhwcSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9lbXBsb3llZS9wcm9maWxlIjt9czo1NToibG9naW5fZW1wbG95ZWVfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1758959913),
('qKBtOeb5EMLpuuY8mYcTdZtJb447xQMSjK7wC7d9', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibHk2eThnb1JyamJJT2owbUtUa0R1QUEzRFJYYzRzZmNpVjczZ2hiQyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9sb2dpbiI7fX0=', 1758947268),
('X85LMvxfI8iIAe3cHN3AhOadcg1D1kL2UQteJu3p', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRWM0OHkzUk5XTXJLd2xORkNiS2tpdUs0MmhWUHJIdXlLdmRYUU5NbyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9lbXBsb3llZS1jYXJkP2VtcGxveWVlPTEiO31zOjUyOiJsb2dpbl9hZG1pbl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1758948361);

-- --------------------------------------------------------

--
-- Table structure for table `stock_items`
--

CREATE TABLE `stock_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `unit` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'Price per unit'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `task_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `assigned_to` bigint(20) UNSIGNED DEFAULT NULL,
  `assigned_team` enum('Individual','Team') NOT NULL,
  `team_members` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`team_members`)),
  `team_created_by` enum('admin','user','team_lead') DEFAULT NULL,
  `team_lead_id` bigint(20) UNSIGNED DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('Not Started','In Progress','Completed','On Hold') NOT NULL DEFAULT 'Not Started',
  `priority` enum('Low','Medium','High') NOT NULL DEFAULT 'Medium',
  `progress` decimal(5,2) NOT NULL DEFAULT 0.00,
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
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `purpose` varchar(255) DEFAULT NULL,
  `visited_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activities_best_employee_id_foreign` (`best_employee_id`);

--
-- Indexes for table `activity_employee`
--
ALTER TABLE `activity_employee`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `activity_employee_activity_id_employee_id_unique` (`activity_id`,`employee_id`),
  ADD KEY `activity_employee_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_user_id_user_type_index` (`user_id`,`user_type`),
  ADD KEY `activity_logs_model_model_id_index` (`model`,`model_id`);

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addresses_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `assigned_items`
--
ALTER TABLE `assigned_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assigned_items_stock_item_id_foreign` (`stock_item_id`),
  ADD KEY `assigned_items_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `attendances_employee_id_date_unique` (`employee_id`,`date`);

--
-- Indexes for table `bank_details`
--
ALTER TABLE `bank_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bank_details_employee_id_foreign` (`employee_id`);

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
-- Indexes for table `criteria`
--
ALTER TABLE `criteria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `criteria_activity_id_foreign` (`activity_id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `documents_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employees_employee_code_unique` (`employee_code`),
  ADD UNIQUE KEY `employees_email_unique` (`email`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expenses_created_by_foreign` (`created_by`);

--
-- Indexes for table `expense_budget`
--
ALTER TABLE `expense_budget`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense_budget_history`
--
ALTER TABLE `expense_budget_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expense_budget_history_created_by_foreign` (`created_by`);

--
-- Indexes for table `experiences`
--
ALTER TABLE `experiences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `experience_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `family_details`
--
ALTER TABLE `family_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `family_details_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `invited_visitors`
--
ALTER TABLE `invited_visitors`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payrolls`
--
ALTER TABLE `payrolls`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payroll_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `points`
--
ALTER TABLE `points`
  ADD PRIMARY KEY (`id`),
  ADD KEY `points_activity_id_foreign` (`activity_id`),
  ADD KEY `points_from_employee_id_foreign` (`from_employee_id`),
  ADD KEY `points_to_employee_id_foreign` (`to_employee_id`);

--
-- Indexes for table `qualifications`
--
ALTER TABLE `qualifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `qualifications_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ratings_employee_id_rating_date_unique` (`employee_id`,`rating_date`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reports_employee_id_foreign` (`employee_id`),
  ADD KEY `reports_team_lead_id_foreign` (`team_lead_id`),
  ADD KEY `reports_task_id_foreign` (`task_id`);

--
-- Indexes for table `salary_slips`
--
ALTER TABLE `salary_slips`
  ADD PRIMARY KEY (`id`),
  ADD KEY `salary_slips_employee_id_month_year_index` (`employee_id`,`month`,`year`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `stock_items`
--
ALTER TABLE `stock_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tasks_assigned_to_foreign` (`assigned_to`),
  ADD KEY `tasks_team_lead_id_foreign` (`team_lead_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `activity_employee`
--
ALTER TABLE `activity_employee`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `assigned_items`
--
ALTER TABLE `assigned_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `bank_details`
--
ALTER TABLE `bank_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `criteria`
--
ALTER TABLE `criteria`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `expense_budget`
--
ALTER TABLE `expense_budget`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `expense_budget_history`
--
ALTER TABLE `expense_budget_history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `experiences`
--
ALTER TABLE `experiences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `family_details`
--
ALTER TABLE `family_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `invited_visitors`
--
ALTER TABLE `invited_visitors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `payrolls`
--
ALTER TABLE `payrolls`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `points`
--
ALTER TABLE `points`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `qualifications`
--
ALTER TABLE `qualifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `salary_slips`
--
ALTER TABLE `salary_slips`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_items`
--
ALTER TABLE `stock_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activities`
--
ALTER TABLE `activities`
  ADD CONSTRAINT `activities_best_employee_id_foreign` FOREIGN KEY (`best_employee_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `activity_employee`
--
ALTER TABLE `activity_employee`
  ADD CONSTRAINT `activity_employee_activity_id_foreign` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `activity_employee_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `assigned_items`
--
ALTER TABLE `assigned_items`
  ADD CONSTRAINT `assigned_items_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assigned_items_stock_item_id_foreign` FOREIGN KEY (`stock_item_id`) REFERENCES `stock_items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bank_details`
--
ALTER TABLE `bank_details`
  ADD CONSTRAINT `bank_details_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `criteria`
--
ALTER TABLE `criteria`
  ADD CONSTRAINT `criteria_activity_id_foreign` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `expense_budget_history`
--
ALTER TABLE `expense_budget_history`
  ADD CONSTRAINT `expense_budget_history_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`);

--
-- Constraints for table `experiences`
--
ALTER TABLE `experiences`
  ADD CONSTRAINT `experience_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `family_details`
--
ALTER TABLE `family_details`
  ADD CONSTRAINT `family_details_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payrolls`
--
ALTER TABLE `payrolls`
  ADD CONSTRAINT `payroll_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `points`
--
ALTER TABLE `points`
  ADD CONSTRAINT `points_activity_id_foreign` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `points_from_employee_id_foreign` FOREIGN KEY (`from_employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `points_to_employee_id_foreign` FOREIGN KEY (`to_employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `qualifications`
--
ALTER TABLE `qualifications`
  ADD CONSTRAINT `qualifications_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reports_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reports_team_lead_id_foreign` FOREIGN KEY (`team_lead_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `salary_slips`
--
ALTER TABLE `salary_slips`
  ADD CONSTRAINT `salary_slips_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `employees` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tasks_team_lead_id_foreign` FOREIGN KEY (`team_lead_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
