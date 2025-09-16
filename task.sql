-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 16, 2025 at 08:13 AM
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

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `title`, `description`, `status`, `schedule_at`, `scoring_scope`, `best_employee_id`, `best_employee_description`, `keep_best_employee`, `enable_best_employee`, `created_at`, `updated_at`) VALUES
(1, 'QnA with Points', 'test', 'active', '2025-09-07 23:00:00', 'selected', 1, 'hi', 0, 1, '2025-09-07 11:53:36', '2025-09-08 00:53:02');

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

--
-- Dumping data for table `activity_employee`
--

INSERT INTO `activity_employee` (`id`, `activity_id`, `employee_id`, `created_at`, `updated_at`) VALUES
(4, 1, 8, NULL, NULL),
(5, 1, 1, NULL, NULL),
(6, 1, 6, NULL, NULL),
(7, 1, 7, NULL, NULL);

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
(23, 1, 'current', 'Gali no. 2', 'Greater Noida', 'Uttar Pradesh', '201306', 'India', '2025-09-06 00:45:20', '2025-09-06 00:45:20');

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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `phone`, `bio`, `profile_image`, `company_logo`, `company_name`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Aman', 'aman.profficial@gmail.com', '7065170513', 'hi! I am the Boss...', '1757255788.png', '1757256766.png', 'Bitmax technologies', NULL, '$2y$12$0RVXEiKrRFqYS1lSqXApouV6yPgoIYtwDKPN3rTg.lj2/GZdpuo..', NULL, NULL, '2025-09-07 09:22:46');

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

--
-- Dumping data for table `criteria`
--

INSERT INTO `criteria` (`id`, `activity_id`, `name`, `description`, `max_points`, `created_at`, `updated_at`) VALUES
(23, 1, 'Personality', 'Hi!', 10, '2025-09-08 00:38:47', '2025-09-08 00:38:47'),
(24, 1, 'Boodhi', 'test', 10, '2025-09-08 00:38:47', '2025-09-08 00:38:47');

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
(4, 1, 'Aadhar', 'documents/LSvjGw0I4pxjcEFHVo7clbxeuUcPmRekZzQYiGWP.png', '2025-09-06 00:45:20', '2025-09-06 00:45:20'),
(5, 1, 'Pan', 'documents/bGqiznEKbfhCaPK48ZA8J2rLiq9BUNKQ5I1WotVX.png', '2025-09-06 00:45:20', '2025-09-06 00:45:20');

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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `employee_code`, `name`, `email`, `password`, `bank_name`, `account_number`, `ifsc_code`, `branch_name`, `basic_salary`, `hra`, `conveyance`, `medical`, `phone`, `hire_date`, `position`, `department`, `status`, `profile_image`, `created_at`, `updated_at`) VALUES
(1, 'EMP001', 'Aman Singh', 'aman@bitmaxgroup.com', '$2y$12$F89RHZnZuwuKFRpxkjLzIu2PiwDRPehui.LWQZk0QuQaS7Lk4VipO', 'PNB', '473858464376', 'ABCDE1234F', 'Sector 62', 18000.00, 0.00, 0.00, 0.00, '7065170513', '2025-08-12', 'Laravel Developer', 'Development', 'active', 'profile_images/pDnXMknjuoxcZJYVa7AlQfPuGCZjwXmMuRtNtAoI.png', '2025-09-05 04:18:47', '2025-09-07 10:16:29'),
(6, 'EMP002', 'Priya Patel', 'priya.patel@company.com', '$2y$12$nT76a1Au/NIcKNIEzx2qY.SpsAMj26r.RqsyJBfAl8VW6tH9WH9Gi', 'HDFC Bank', '234567890123', 'HDFC0001234', 'Sector 18, Noida', 60000.00, 18000.00, 19200.00, 6000.00, '+91-9876543211', '2023-02-20', 'HR Manager', 'Human Resources', 'active', NULL, '2025-09-07 11:18:06', '2025-09-07 11:18:06'),
(7, 'EMP003', 'Amit Kumar', 'amit.kumar@company.com', '$2y$12$RumiR5/jpDHT../rySApH.SoCYFVwqKOYKf.71JoNUdLJhtD07mLa', 'ICICI Bank', '345678901234', 'ICIC0001234', 'Rajouri Garden, Delhi', 75000.00, 22500.00, 19200.00, 7500.00, '+91-9876543212', '2023-03-10', 'Project Manager', 'IT', 'active', NULL, '2025-09-07 11:18:06', '2025-09-07 11:18:06'),
(8, 'EMP004', 'Sneha Gupta', 'sneha.gupta@company.com', '$2y$12$Q2nJ4j5CHI0RQzL1.l5nZe01lQEVWuSPKZJBGdP0EqcdwFqh9f3GC', 'Axis Bank', '456789012345', 'UTIB0001234', 'Karol Bagh, Delhi', 55000.00, 16500.00, 19200.00, 5500.00, '+91-9876543213', '2023-04-05', 'UI/UX Designer', 'Design', 'active', NULL, '2025-09-07 11:18:06', '2025-09-07 11:18:06'),
(9, 'EMP005', 'Vikram Singh', 'vikram.singh@company.com', '$2y$12$D1eUchVc95LJ0bryHvb7eug8v0318jJKhK6j7yeg5HEbV7ASOv5Um', 'Punjab National Bank', '567890123456', 'PUNB0123456', 'Lajpat Nagar, Delhi', 65000.00, 19500.00, 19200.00, 6500.00, '+91-9876543214', '2023-05-12', 'Business Analyst', 'Business', 'active', NULL, '2025-09-07 11:18:06', '2025-09-07 11:18:06'),
(10, 'EMP006', 'Kavita Jain', 'kavita.jain@company.com', '$2y$12$r3JK.jhZ.jctgvvNX2rakeZw3s58fOe0OyGeLd3WfJtYYdTsdmc.y', 'Kotak Mahindra Bank', '678901234567', 'KKBK0001234', 'Nehru Place, Delhi', 45000.00, 13500.00, 19200.00, 4500.00, '+91-9876543215', '2023-06-18', 'Marketing Executive', 'Marketing', 'active', NULL, '2025-09-07 11:18:06', '2025-09-07 11:18:06'),
(11, 'EMP007', 'Rajesh Verma', 'rajesh.verma@company.com', '$2y$12$jJbrhoZqUquMR2jdBPAgs.yWXMQNfguNk3/5XQHNwaOc/DCqWOuiC', 'Bank of Baroda', '789012345678', 'BARB0DELHI1', 'CP, Delhi', 55000.00, 16500.00, 19200.00, 5500.00, '+91-9876543216', '2023-07-25', 'System Administrator', 'IT', 'active', NULL, '2025-09-07 11:18:06', '2025-09-07 11:18:06'),
(12, 'EMP008', 'Meera Choudhary', 'meera.choudhary@company.com', '$2y$12$vXff0QEXCAKlmxBbfKxueuQdKzM/jFE.AzFBtRgHwg154V7ZAH6eG', 'IDBI Bank', '890123456789', 'IBKL0001234', 'Dwarka, Delhi', 40000.00, 12000.00, 19200.00, 4000.00, '+91-9876543217', '2023-08-30', 'Content Writer', 'Marketing', 'active', NULL, '2025-09-07 11:18:06', '2025-09-07 11:18:06');

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
(24, 1, 'BMDU', 'Laravel Developer', '2025-01-01', '2025-05-01', NULL, '2025-09-06 00:45:20', '2025-09-06 00:45:20');

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
(30, '2025_09_12_000000_create_invited_visitors_table', 26);

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

--
-- Dumping data for table `points`
--

INSERT INTO `points` (`id`, `activity_id`, `from_employee_id`, `to_employee_id`, `criteria_id`, `points`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 6, 23, 8, '2025-09-08 00:43:01', '2025-09-08 00:43:01'),
(2, 1, 1, 6, 24, 6, '2025-09-08 00:43:01', '2025-09-08 00:43:01'),
(3, 1, 1, 7, 23, 6, '2025-09-08 00:43:01', '2025-09-08 00:43:01'),
(4, 1, 1, 7, 24, 9, '2025-09-08 00:43:01', '2025-09-08 00:43:01'),
(5, 1, 1, 8, 23, 8, '2025-09-08 00:43:01', '2025-09-08 00:43:01'),
(6, 1, 1, 8, 24, 8, '2025-09-08 00:43:01', '2025-09-08 00:43:01'),
(7, 1, 6, 1, 23, 10, '2025-09-08 00:53:02', '2025-09-08 00:53:02'),
(8, 1, 6, 1, 24, 10, '2025-09-08 00:53:02', '2025-09-08 00:53:02'),
(9, 1, 6, 7, 23, 7, '2025-09-08 00:53:02', '2025-09-08 00:53:02'),
(10, 1, 6, 7, 24, 6, '2025-09-08 00:53:02', '2025-09-08 00:53:02'),
(11, 1, 6, 8, 23, 7, '2025-09-08 00:53:02', '2025-09-08 00:53:02'),
(12, 1, 6, 8, 24, 8, '2025-09-08 00:53:02', '2025-09-08 00:53:02');

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
(25, 1, '12th', 'MBS', 2024, '60', '2025-09-06 00:45:20', '2025-09-06 00:45:20');

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

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `employee_id`, `task_id`, `title`, `content`, `sent_to_admin`, `sent_to_team_lead`, `team_lead_id`, `status`, `review`, `rating`, `attachment`, `created_at`, `updated_at`, `admin_review`, `admin_rating`, `admin_status`, `team_lead_review`, `team_lead_rating`, `team_lead_status`) VALUES
(3, 1, 1, 'Work Started', 'hiii', 1, 0, NULL, 'sent', 'hiiii', 5, 'reports/NGqluciEzrYs8J5DKb6i7yuTI8eDRxll1jfHSEyh.png', '2025-09-06 03:28:33', '2025-09-07 02:34:29', '1624872647', 5, 'read', NULL, NULL, NULL),
(6, 1, 2, 'hii', 'gdjhsg', 1, 0, NULL, 'sent', NULL, NULL, 'reports/zdmyy0weOdS0EAg6d6B3a7K7G23h5PV0xBBXDbnA.png', '2025-09-07 02:06:59', '2025-09-07 02:06:59', NULL, NULL, NULL, NULL, NULL, NULL);

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
('YyFgGH0o5tqs5iEvrSZMDB4d7rvjPQttrGkxrjAZ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYmNjRGZCYWJOWTZrN2k2RWFUeXhpY0RidDVVcGZPUlZNaUNaZFFPZiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fX0=', 1758003148);

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

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `task_name`, `description`, `assigned_to`, `assigned_team`, `team_members`, `team_created_by`, `team_lead_id`, `start_date`, `end_date`, `status`, `priority`, `progress`, `created_at`, `updated_at`) VALUES
(1, 'Test', 'Just a testing!', 1, 'Individual', NULL, NULL, NULL, '2025-09-05', '2025-09-05', 'Completed', 'Low', 100.00, '2025-09-05 04:22:58', '2025-09-06 03:36:47'),
(2, 'team', 'hiii', NULL, 'Team', '[\"2\"]', 'team_lead', 1, '2025-09-06', '2025-09-10', 'In Progress', 'Medium', 10.00, '2025-09-06 05:36:04', '2025-09-06 23:49:09');

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
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `experiences`
--
ALTER TABLE `experiences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

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
