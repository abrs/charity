-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 18, 2021 at 02:12 PM
-- Server version: 8.0.18
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bw_foo`
--

-- --------------------------------------------------------

--
-- Table structure for table `activitable`
--

CREATE TABLE `activitable` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `activity_id` bigint(20) UNSIGNED NOT NULL,
  `activitable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activitable_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activitable`
--

INSERT INTO `activitable` (`id`, `activity_id`, `activitable_type`, `activitable_id`, `created_at`, `updated_at`) VALUES
(7, 1, 'App\\Models\\Beneficiary_Info', 23, '2021-04-08 07:50:38', '2021-04-08 07:50:38');

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `modified_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `name`, `is_enabled`, `created_by`, `modified_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'add_new_beneficiary', 1, 'tester1', 'tester1', NULL, '2021-02-03 14:15:29', '2021-04-05 09:16:09');

-- --------------------------------------------------------

--
-- Table structure for table `activity_workflow_steps`
--

CREATE TABLE `activity_workflow_steps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `activitable_id` bigint(20) UNSIGNED DEFAULT NULL,
  `step_id` bigint(20) UNSIGNED DEFAULT NULL,
  `step_supervisor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `step_supervisor_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_num` int(10) UNSIGNED NOT NULL,
  `finishing_percentage` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_workflow_steps`
--

INSERT INTO `activity_workflow_steps` (`id`, `is_enabled`, `created_by`, `modified_by`, `deleted_at`, `activitable_id`, `step_id`, `step_supervisor_id`, `step_supervisor_type`, `order_num`, `finishing_percentage`, `required`, `created_at`, `updated_at`, `status_id`, `description`) VALUES
(3, 1, 'khald2002', NULL, NULL, 7, 6, 3, NULL, 1, '50', 1, '2021-04-08 08:32:37', '2021-04-14 04:12:48', 1, 'The description field is required.'),
(4, 1, 'khald2002', NULL, NULL, 7, 7, 3, NULL, 2, '50', 1, '2021-04-12 07:19:02', '2021-04-12 07:19:02', 1, 'needs manager approval');

-- --------------------------------------------------------

--
-- Table structure for table `beneficiary_infos`
--

CREATE TABLE `beneficiary_infos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type_infos_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `second_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `third_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fourth_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `known_as` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `career` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `standing` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_death` date DEFAULT NULL,
  `is_special_needs` tinyint(1) NOT NULL DEFAULT '0',
  `birth` date DEFAULT NULL,
  `gender` tinyint(1) NOT NULL DEFAULT '0',
  `national_number` bigint(20) UNSIGNED DEFAULT NULL,
  `age` int(10) UNSIGNED DEFAULT NULL,
  `is_alive` tinyint(1) NOT NULL DEFAULT '1',
  `special_needs_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `beneficiary_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `polling_station_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `beneficiary_infos`
--

INSERT INTO `beneficiary_infos` (`id`, `type_infos_id`, `is_enabled`, `created_by`, `modified_by`, `deleted_at`, `created_at`, `updated_at`, `first_name`, `second_name`, `third_name`, `fourth_name`, `last_name`, `known_as`, `career`, `standing`, `date_of_death`, `is_special_needs`, `birth`, `gender`, `national_number`, `age`, `is_alive`, `special_needs_type_id`, `beneficiary_type_id`, `phone`, `polling_station_id`) VALUES
(23, 33, 1, 'khald2002', NULL, NULL, '2021-04-08 07:50:37', '2021-04-18 11:05:37', 'khald', 'ghali', 'sami', 'Gorge', 'hadi', 'Abo Abdo', 'engineer', NULL, NULL, 1, NULL, 1, 34562365, 20, 1, 1, 1, NULL, NULL),
(36, 48, 1, 'khald2002', NULL, NULL, '2021-04-17 08:56:09', '2021-04-17 08:56:09', 'khald', 'ghali', 'sami', 'Gorge', 'hadi', 'Abo Abdo', 'engineer', NULL, NULL, 1, NULL, 1, 34562365, 20, 1, 1, 1, NULL, NULL),
(39, NULL, 0, 'khald2002', NULL, NULL, '2021-04-18 08:04:08', '2021-04-18 08:04:08', 'khald', 'ghali', 'sami', 'Gorge', 'hadi', 'Abo Abdo', 'engineer', NULL, NULL, 1, NULL, 1, 34562365, 20, 1, 1, NULL, NULL, NULL),
(40, NULL, 0, 'khald2002', NULL, NULL, '2021-04-18 08:11:52', '2021-04-18 08:11:52', 'khald', 'ghali', 'sami', 'Gorge', 'hadi', 'Abo Abdo', 'engineer', NULL, NULL, 1, NULL, 1, 34562365, 20, 1, 1, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `beneficiary_types`
--

CREATE TABLE `beneficiary_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` text COLLATE utf8mb4_unicode_ci,
  `modified_by` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `beneficiary_types`
--

INSERT INTO `beneficiary_types` (`id`, `name`, `is_enabled`, `created_by`, `modified_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'accepted', 1, 'khald2002', NULL, NULL, '2021-04-17 05:53:21', '2021-04-17 05:53:21'),
(2, 'pending registered', 1, 'khald2002', NULL, NULL, '2021-04-17 05:55:54', '2021-04-17 05:55:54'),
(3, 'rejected', 1, 'khald2002', NULL, NULL, '2021-04-17 05:56:49', '2021-04-17 05:56:49');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `action_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `eventable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `eventable_id` bigint(20) UNSIGNED NOT NULL,
  `to_eventable_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `to_eventable_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `action_name`, `eventable_type`, `eventable_id`, `to_eventable_type`, `to_eventable_id`, `ip`, `message`, `user_id`, `created_at`, `updated_at`) VALUES
(2, 'Create', 'App\\Models\\Type', 31, NULL, NULL, NULL, ' Created Type testingEvents', 3, '2021-03-28 08:40:33', '2021-03-28 08:40:33'),
(3, 'Create', 'App\\Models\\Type', 32, NULL, NULL, NULL, 'khald2002 Created Type testingEvents1', 3, '2021-03-28 08:41:28', '2021-03-28 08:41:28'),
(5, 'Update', 'App\\Models\\Type', 32, NULL, NULL, NULL, 'khald2002 Updated Type some name for testing', 3, '2021-03-29 03:38:53', '2021-03-29 03:38:53'),
(6, 'Update', 'App\\Models\\Type', 32, NULL, NULL, NULL, 'khald2002 Updated App\\Models\\Type some name for testing', 3, '2021-03-29 03:56:01', '2021-03-29 03:56:01'),
(7, 'Update', 'App\\Models\\Type', 32, NULL, NULL, NULL, 'khald2002 Updated \\Type some name for testingytv', 3, '2021-03-29 04:04:22', '2021-03-29 04:04:22'),
(8, 'Update', 'App\\Models\\Type', 32, NULL, NULL, NULL, 'khald2002 Updated Type some name for testing', 3, '2021-03-29 04:11:33', '2021-03-29 04:11:33'),
(9, 'Update', 'App\\Models\\Type', 32, NULL, NULL, NULL, 'khald2002 Updated Type ', 3, '2021-03-29 05:04:06', '2021-03-29 05:04:06'),
(10, 'Update', 'App\\Models\\Type', 32, NULL, NULL, NULL, 'khald2002 Updated Type some name for testiIIAALL, ', 3, '2021-03-29 05:10:16', '2021-03-29 05:10:16'),
(11, 'Update', 'App\\Models\\Type_Info', 28, NULL, NULL, NULL, 'khald2002 Updated Type_Info 2, ', 3, '2021-03-29 05:17:40', '2021-03-29 05:17:40'),
(12, 'Update', 'App\\Models\\Type_Info', 4, NULL, NULL, NULL, 'khald2002 Updated Type_Info 2, 9, ', 3, '2021-03-29 05:24:53', '2021-03-29 05:24:53'),
(13, 'Update', 'App\\Models\\Type_Info', 7, NULL, NULL, NULL, 'khald2002 Updated Type_Info user_id: 4, type_id: 33, ', 3, '2021-03-29 05:30:36', '2021-03-29 05:30:36'),
(14, 'Update', 'App\\Models\\Type_Info', 7, NULL, NULL, NULL, 'khald2002 Updated Type_Info user_id: 4, type_id: 9, ', 3, '2021-03-29 06:03:30', '2021-03-29 06:03:30'),
(15, 'Update', 'App\\Models\\Type_Info', 7, NULL, NULL, NULL, 'khald2002 Updated Type_Info user_id: 4, type_id: 33, ', 3, '2021-03-29 06:05:34', '2021-03-29 06:05:34'),
(16, 'Create', 'App\\Models\\Point', 7, NULL, NULL, NULL, 'khald2002 Created Point name: delete me, ', 3, '2021-03-29 06:12:52', '2021-03-29 06:12:52'),
(17, 'Delete', 'App\\Models\\Point', 7, NULL, NULL, NULL, 'khald2002 Deleted Point name: delete me, ', 3, '2021-03-29 06:13:58', '2021-03-29 06:13:58'),
(18, 'Create', 'App\\Models\\UserRelation', 1, NULL, NULL, NULL, 'khald2002 Created UserRelation relation_id: 1, user_id: 3, s_user_id: , family_budget: , ', 3, '2021-04-04 05:27:43', '2021-04-04 05:27:43'),
(19, 'Create', 'App\\User', 29, NULL, NULL, NULL, 'khald2002 Created User user_name: hamdi, ', 3, '2021-04-07 06:53:27', '2021-04-07 06:53:27'),
(20, 'Create', 'App\\User', 30, NULL, NULL, NULL, 'khald2002 Created User user_name: hamdiii, ', 3, '2021-04-07 06:58:45', '2021-04-07 06:58:45'),
(21, 'Create', 'App\\User', 31, NULL, NULL, NULL, 'khald2002 Created User user_name: hamooood, ', 3, '2021-04-11 08:07:39', '2021-04-11 08:07:39'),
(22, 'Create', 'App\\User', 32, NULL, NULL, NULL, 'khald2002 Created User user_name: hameeeeed, ', 3, '2021-04-11 08:08:12', '2021-04-11 08:08:12'),
(23, 'Create', 'App\\Models\\Point', 8, NULL, NULL, NULL, 'khald2002 Created Point name: Husaynia, ', 3, '2021-04-13 09:28:16', '2021-04-13 09:28:16'),
(24, 'Create', 'App\\Models\\Location', 4, NULL, NULL, NULL, 'khald2002 Created Location name: Damascus, point_id: 8, ', 3, '2021-04-13 09:28:35', '2021-04-13 09:28:35'),
(25, 'Create', 'App\\Models\\UserRelation', 2, NULL, NULL, NULL, 'khald2002 Created UserRelation relation_id: 1, user_id: 3, s_user_id: , family_budget: , ', 3, '2021-04-15 10:36:28', '2021-04-15 10:36:28'),
(26, 'Create', 'App\\Models\\UserRelation', 3, NULL, NULL, NULL, 'khald2002 Created UserRelation relation_id: 1, user_id: 3, s_user_id: 5, family_budget: , ', 3, '2021-04-15 10:37:15', '2021-04-15 10:37:15'),
(27, 'Create', 'App\\Models\\BeneficiaryType', 1, NULL, NULL, NULL, 'khald2002 Created BeneficiaryType name: accepted, ', 3, '2021-04-17 05:53:22', '2021-04-17 05:53:22'),
(28, 'Create', 'App\\Models\\BeneficiaryType', 2, NULL, NULL, NULL, 'khald2002 Created BeneficiaryType name: pending registered, ', 3, '2021-04-17 05:55:54', '2021-04-17 05:55:54'),
(29, 'Create', 'App\\Models\\BeneficiaryType', 3, NULL, NULL, NULL, 'khald2002 Created BeneficiaryType name: rejected, ', 3, '2021-04-17 05:56:49', '2021-04-17 05:56:49'),
(31, 'Create', 'App\\User', 34, NULL, NULL, NULL, 'khald2002 Created User user_name: hamiiiiiiiiiiieeed, ', 3, '2021-04-17 07:42:38', '2021-04-17 07:42:38'),
(32, 'Create', 'App\\User', 35, NULL, NULL, NULL, 'khald2002 Created User user_name: hamiiiiiiiiiiieeed, ', 3, '2021-04-17 07:55:08', '2021-04-17 07:55:08'),
(36, 'Create', 'App\\User', 39, NULL, NULL, NULL, 'khald2002 Created User user_name: hamiiiiiiiiiiieeed, ', 3, '2021-04-17 08:17:08', '2021-04-17 08:17:08'),
(40, 'Create', 'App\\User', 43, NULL, NULL, NULL, 'khald2002 Created User user_name: hamiiiiiiiiiiieeed, ', 3, '2021-04-17 08:56:09', '2021-04-17 08:56:09'),
(41, 'Create', 'App\\Models\\PollingStation', 1, NULL, NULL, NULL, 'khald2002 Created PollingStation name: زمردة, location_id: 4, ', 3, '2021-04-18 10:18:28', '2021-04-18 10:18:28'),
(42, 'Update', 'App\\Models\\PollingStation', 1, NULL, NULL, NULL, 'khald2002 Updated PollingStation name: بون بون, location_id: 4, ', 3, '2021-04-18 10:24:51', '2021-04-18 10:24:51');

-- --------------------------------------------------------

--
-- Table structure for table `fields`
--

CREATE TABLE `fields` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_enabled` tinyint(1) NOT NULL,
  `name_in_db` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fields`
--

INSERT INTO `fields` (`id`, `name`, `is_enabled`, `name_in_db`, `created_at`, `updated_at`) VALUES
(1, 'الاسم الأول', 1, 'name', NULL, NULL),
(2, 'اسم الأب', 1, 'address', NULL, NULL),
(3, 'اسم الجد', 1, 'phone', NULL, NULL),
(4, 'الاسم الأخير', 1, 'email', NULL, NULL),
(5, 'اللقب', 1, 'date', NULL, NULL),
(6, 'المواليد', 1, 'location_id', NULL, NULL),
(7, 'عنوان السكن', 1, 'type_infos_id', NULL, NULL),
(8, 'الحسينية', 1, 'type_infos_id', NULL, NULL),
(9, 'الجنس', 1, 'type_infos_id', NULL, NULL),
(10, 'المهنة', 1, 'type_infos_id', NULL, NULL),
(11, 'مكان العمل', 1, 'type_infos_id', NULL, NULL),
(12, 'رقم الهاتف1', 1, 'type_infos_id', NULL, NULL),
(13, 'رقم الهاتف2', 1, 'type_infos_id', NULL, NULL),
(14, 'عدد أفراد العائلة', 1, 'type_infos_id', NULL, NULL),
(15, 'اسم المركز الانتخابي', 1, 'type_infos_id', NULL, NULL),
(16, 'رقم البطاقة الوطنية', 1, 'type_infos_id', NULL, NULL),
(17, 'على قيد الحياة', 1, 'type_infos_id', NULL, NULL),
(18, 'القائم مكانه', 1, 'type_infos_id', NULL, NULL),
(19, 'تاريخ الوفاة', 1, 'type_infos_id', NULL, NULL),
(20, 'من ذوي الاحتياجات الخاصة', 1, 'type_infos_id', NULL, NULL),
(21, 'نوع الاحتياج الخاص', 1, 'type_infos_id', NULL, NULL),
(22, 'مستوى دخل العائلة', 1, 'type_infos_id', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE `forms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_enabled` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `forms`
--

INSERT INTO `forms` (`id`, `name`, `is_enabled`, `created_at`, `updated_at`) VALUES
(1, 'استمارة مستفيد', 1, NULL, NULL),
(2, 'form2', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `form_fields`
--

CREATE TABLE `form_fields` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `form_id` bigint(20) UNSIGNED NOT NULL,
  `field_id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) DEFAULT NULL,
  `property_id` bigint(20) UNSIGNED DEFAULT NULL,
  `input_id` bigint(20) UNSIGNED DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `form_fields`
--

INSERT INTO `form_fields` (`id`, `form_id`, `field_id`, `section_id`, `property_id`, `input_id`, `value`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, 1, 14, NULL, NULL, NULL),
(2, 1, 2, NULL, 1, 14, NULL, NULL, NULL),
(3, 1, 3, NULL, 1, 14, NULL, NULL, NULL),
(4, 1, 4, NULL, 1, 14, NULL, NULL, NULL),
(5, 1, 5, NULL, 1, 14, NULL, NULL, NULL),
(6, 1, 6, NULL, 1, 28, NULL, NULL, NULL),
(7, 1, 7, NULL, 1, 14, NULL, NULL, NULL),
(8, 1, 8, NULL, 1, 14, NULL, NULL, NULL),
(9, 1, 9, NULL, 1, 37, NULL, NULL, NULL),
(10, 1, 9, NULL, 2, 39, NULL, NULL, NULL),
(11, 1, 9, NULL, 2, 40, NULL, NULL, NULL),
(12, 1, 10, NULL, 1, 14, NULL, NULL, NULL),
(13, 1, 11, NULL, 1, 14, NULL, NULL, NULL),
(14, 1, 12, NULL, 1, 31, NULL, NULL, NULL),
(15, 1, 13, NULL, 1, 31, NULL, NULL, NULL),
(16, 1, 14, NULL, 1, 31, NULL, NULL, NULL),
(17, 1, 15, NULL, 1, 14, NULL, NULL, NULL),
(18, 1, 16, NULL, 1, 31, NULL, NULL, NULL),
(19, 1, 17, NULL, 1, 37, NULL, NULL, NULL),
(20, 1, 17, NULL, 2, 41, NULL, NULL, NULL),
(21, 1, 17, NULL, 2, 42, NULL, NULL, NULL),
(22, 1, 18, NULL, 1, 14, NULL, NULL, NULL),
(23, 1, 19, NULL, 1, 28, NULL, NULL, NULL),
(24, 1, 20, NULL, 1, 37, NULL, NULL, NULL),
(25, 1, 20, NULL, 2, 41, NULL, NULL, NULL),
(26, 1, 20, NULL, 2, 42, NULL, NULL, NULL),
(27, 1, 21, NULL, 1, 14, NULL, NULL, NULL),
(28, 1, 22, NULL, 1, 14, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `form_field_values`
--

CREATE TABLE `form_field_values` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `form_id` bigint(20) UNSIGNED NOT NULL,
  `field_id` bigint(20) UNSIGNED NOT NULL,
  `owner_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `form_field_values`
--

INSERT INTO `form_field_values` (`id`, `form_id`, `field_id`, `owner_id`, `user_id`, `value`, `created_at`, `updated_at`) VALUES
(129, 1, 1, 4, 3, 'سارة', NULL, NULL),
(130, 1, 2, 4, 3, 'عماد', NULL, NULL),
(131, 1, 3, 4, 3, 'الجد', NULL, NULL),
(132, 1, 4, 4, 3, 'الاسم الاخير', NULL, NULL),
(133, 1, 5, 4, 3, 'اللقب', NULL, NULL),
(134, 1, 6, 4, 3, '10/10/2020', NULL, NULL),
(135, 1, 7, 4, 3, 'السكن', NULL, NULL),
(136, 1, 1, 2, 3, 'سارة', NULL, NULL),
(137, 1, 2, 2, 3, 'عماد', NULL, NULL),
(138, 1, 3, 2, 3, 'الجد', NULL, NULL),
(139, 1, 4, 2, 3, 'الاسم الاخير', NULL, NULL),
(140, 1, 5, 2, 3, 'اللقب', NULL, NULL),
(141, 1, 6, 2, 3, '10/10/2020', NULL, NULL),
(142, 1, 7, 2, 3, 'السكن', NULL, NULL),
(143, 1, 12, 2, 3, '09999988', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inputs`
--

CREATE TABLE `inputs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `label` varchar(255) NOT NULL,
  `type` enum('string','date','dateTime','boolean','int','float','image','pdf','office','textFile','select','mobile') NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  `input_id` bigint(20) UNSIGNED DEFAULT NULL,
  `property_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `inputs`
--

INSERT INTO `inputs` (`id`, `label`, `type`, `value`, `input_id`, `property_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(14, '', 'string', NULL, NULL, 1, NULL, NULL, NULL),
(28, '', 'date', NULL, NULL, 1, NULL, NULL, NULL),
(29, '', 'dateTime', NULL, NULL, 1, NULL, NULL, NULL),
(30, '', 'boolean', NULL, NULL, 1, NULL, NULL, NULL),
(31, '', 'int', '', NULL, 1, NULL, NULL, NULL),
(32, '', 'float', NULL, NULL, 1, NULL, NULL, NULL),
(33, '', 'image', NULL, NULL, 1, NULL, NULL, NULL),
(34, '', 'pdf', NULL, NULL, 1, NULL, NULL, NULL),
(35, '', 'office', NULL, NULL, 1, NULL, NULL, NULL),
(36, '', 'textFile', NULL, NULL, 1, NULL, NULL, NULL),
(37, '', 'select', NULL, NULL, 1, NULL, NULL, NULL),
(38, '', 'mobile', NULL, NULL, 1, NULL, NULL, NULL),
(39, 'ذكر', '', NULL, NULL, 2, NULL, NULL, NULL),
(40, 'أنثى', '', NULL, NULL, 2, NULL, NULL, NULL),
(41, 'نعم', '', NULL, NULL, 2, NULL, NULL, NULL),
(42, 'لا', '', NULL, NULL, 2, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abbrivation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` text COLLATE utf8mb4_unicode_ci,
  `modified_by` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `title`, `abbrivation`, `is_enabled`, `created_by`, `modified_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'english', 'en', 1, 'khald2002', NULL, NULL, '2021-03-30 08:21:39', '2021-03-30 08:22:29'),
(2, 'arabic', 'ar', 1, 'khald2002', 'khald2002', NULL, '2021-03-30 08:21:51', '2021-03-30 08:25:48');

-- --------------------------------------------------------

--
-- Table structure for table `language_sentence`
--

CREATE TABLE `language_sentence` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sentence_id` bigint(20) UNSIGNED DEFAULT NULL,
  `language_id` bigint(20) UNSIGNED DEFAULT NULL,
  `translation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `language_sentence`
--

INSERT INTO `language_sentence` (`id`, `sentence_id`, `language_id`, `translation`, `is_enabled`, `created_by`, `modified_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(5, 3, 1, 'main page', 1, NULL, NULL, NULL, '2021-04-14 06:29:42', '2021-04-14 06:29:42');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `point_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `modified_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `point_id`, `name`, `deleted_at`, `is_enabled`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(4, 8, 'Damascus', NULL, 1, 'khald2002', NULL, '2021-04-13 09:28:35', '2021-04-13 09:28:35');

-- --------------------------------------------------------

--
-- Table structure for table `location_types`
--

CREATE TABLE `location_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `location_types`
--

INSERT INTO `location_types` (`id`, `name`, `is_enabled`, `created_by`, `modified_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'job', 1, 'khald2002', NULL, NULL, '2021-02-25 10:32:20', '2021-02-25 10:32:20'),
(2, 'resident', 1, 'khald2002', 'khald2002', NULL, '2021-02-25 10:33:03', '2021-02-25 10:36:31'),
(3, 'إقامة', 1, 'khald2002', NULL, '2021-02-25 10:34:11', '2021-02-25 10:33:13', '2021-02-25 10:34:11');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(4, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(6, '2016_06_01_000004_create_oauth_clients_table', 1),
(7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(8, '2021_01_05_084036_create_permission_tables', 1),
(10, '2021_01_12_075043_create_types_table', 2),
(11, '2021_01_07_143158_create_type_infos_table', 3),
(15, '2021_01_13_104150_create_party_infos_table', 4),
(16, '2021_01_18_132129_create_points_table', 5),
(17, '2021_01_18_145042_create_locations_table', 6),
(19, '2014_10_12_000000_create_users_table', 8),
(24, '2021_01_21_142738_create_relations_table', 11),
(27, '2021_01_27_120415_add_bwire_attributes_to_roles', 13),
(28, '2021_01_27_152245_add_bwire_attributes_to_permissions', 14),
(29, '2021_02_02_122857_create_statuses_table', 15),
(33, '2021_02_03_152227_create_steps_table', 16),
(34, '2021_02_03_155934_create_activities_table', 17),
(36, '2021_02_04_111805_create_step_approvals_table', 19),
(37, '2021_02_25_115434_create_location_types_table', 20),
(40, '2021_02_25_141728_create_phone_types_table', 22),
(42, '2021_02_28_100926_create_special_need_types_table', 24),
(44, '2021_03_28_100424_create_events_table', 26),
(45, '2021_03_30_075618_create_sentences_table', 27),
(48, '2021_03_30_080240_create_language_sentence_table', 29),
(49, '2021_03_30_080146_create_languages_table', 30),
(51, '2021_02_25_113747_create_user_location_table', 32),
(52, '2021_02_25_153324_create_phones_table', 33),
(53, '2021_01_18_114018_create_beneficiary_infos_table', 34),
(54, '2021_02_28_114056_add_new_requirements_to_beneficiary_infos_table', 35),
(56, '2021_04_06_093657_create_activitable_table', 37),
(57, '2021_02_03_162424_create_activity_workflow_steps_table', 38),
(58, '2021_04_06_104148_add_activity_id_to_activitable_table', 39),
(59, '2021_04_06_123544_add_description_to_step_approvals_table', 40),
(60, '2021_04_08_083716_add_step_supervisor_references_to_activity_workflow_steps_table', 41),
(61, '2021_04_12_110109_add_status_id_and_description_to_activity_workflow_steps_table', 42),
(62, '2021_04_14_113125_create_beneficiary_types_table', 43),
(63, '2021_04_17_104729_add_beneficiary_type_id_to_beneficiary_infos_table', 44),
(64, '2021_04_1_124643_create_user_relations_table', 45),
(65, '2021_04_18_113528_add_phone_to_beneficiary_infos_table', 46),
(66, '2021_04_18_121954_create_polling_stations_table', 47),
(67, '2021_04_18_130724_change_polling_station_name_in_beneficiary_infos_table', 48);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\User', 1),
(1, 'App\\User', 3),
(3, 'App\\User', 3),
(1, 'App\\User', 24),
(1, 'App\\User', 25),
(1, 'App\\User', 28),
(1, 'App\\User', 29),
(1, 'App\\User', 30),
(1, 'App\\User', 31),
(1, 'App\\User', 32),
(1, 'App\\User', 34),
(1, 'App\\User', 35),
(1, 'App\\User', 39),
(1, 'App\\User', 43);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `scopes` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('087efc77e3ed4a5ef5bf40d40d37af11b2746ca8882365376ce4df1c2f4d287498071f1ec2d05402', 3, 2, 'Personal Access Token', '[]', 0, '2021-04-05 09:41:23', '2021-04-05 09:41:23', '2021-04-12 12:41:24'),
('0a300ba4a15b347b4b64c8ff05bd807bc32f6a925f4d51949851d75acbff1cf6361c5bf2192adb2d', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-04 08:45:57', '2021-02-04 08:45:57', '2021-01-04 10:45:57'),
('19008ddb3fa7c66220debb2e4acc5075eba2c053ea6f50b18952f84ccdf246d7109c056d6767c2e0', 2, 2, 'Personal Access Token', '[]', 0, '2021-01-06 11:04:02', '2021-01-06 11:04:02', '2021-01-13 13:04:02'),
('1a5964fa6868539a1fb23c440b83d7a562743b338daffffd83237d1749dd112ac26dfc27cb5694b1', 4, 2, 'Personal Access Token', '[]', 0, '2021-01-20 10:34:55', '2021-01-20 10:34:55', '2021-01-27 12:34:55'),
('1f3c450fe4b0a3a58ca24006ed7c8ad438a099cff7ed32688a4eb7a822fb8d45022f28e7d41bbb06', 3, 2, 'Personal Access Token', '[]', 0, '2021-03-14 07:31:13', '2021-03-14 07:31:13', '2021-03-21 09:31:14'),
('2c1089836c5821d54b115f2cc823d26c62f64b766a9881913a96a48c0d7f3eb5c80c8754d5b85cbf', 1, 2, 'Personal Access Token', '[]', 1, '2021-01-06 12:17:44', '2021-01-06 12:17:44', '2021-01-13 14:17:44'),
('4bd2627e01dfe430fc0bc1e2d2f370b3b5b049862ab9c9db4b68b3849f3f68d8c14708219b4d5801', 3, 2, 'Personal Access Token', '[]', 0, '2021-04-12 05:28:11', '2021-04-12 05:28:11', '2021-04-19 08:28:12'),
('61ba8f581fb79e045b3eaabb493511b524b8866c4af4a7110da6d086980405dcd208171893706233', 3, 2, 'Personal Access Token', '[]', 1, '2021-04-13 09:36:10', '2021-04-13 09:36:10', '2021-04-20 12:36:11'),
('6a678e2ed114cdff969b60295ade3049f0e43a8ac74dfaa9010a1a00e77b63b6e8eebf49fbaa0087', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-18 15:31:44', '2021-02-18 15:31:44', '2021-02-25 17:31:45'),
('7fea5ace6c22f42a6f089f0f6a611fed387c31256210592609bc486bfce0aa93696ddfb9a7228794', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-28 05:38:29', '2021-02-28 05:38:29', '2021-03-07 07:38:30'),
('8e9ba96e9b17b00f9f8bbe64a8d5133382102ed054ca8594231f885487a244200ca3eff6b73bf80a', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-03 16:27:47', '2021-02-03 16:27:47', '2021-02-10 18:27:48'),
('97698c9747cc9a703e9cb3b43bf1d1d5a1dffc980641a63177d3b91d938806af07343ab911f63216', 1, 2, 'Personal Access Token', '[]', 0, '2021-01-06 10:55:21', '2021-01-06 10:55:21', '2021-01-13 12:55:22'),
('9dc997fd5cceda023a5df22190de3924e0c036cac59a7478b82224193a861a5e4805e9ab91c30348', 1, 2, 'Personal Access Token', '[]', 1, '2021-01-06 11:44:35', '2021-01-06 11:44:35', '2021-01-13 13:44:35'),
('a2096f45589bf9f93a7b19bd54e66f0ecb8237d7029e5bb87919be38c5a556079512783186267e38', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-17 08:37:17', '2021-02-17 08:37:17', '2021-02-24 10:37:17'),
('a9f452ebcb4fb62b7f4e0a40aa6d0ee039b4a4fafa0777aca30052af1bd4f35002117b11d8e45970', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-16 10:23:12', '2021-02-16 10:23:12', '2021-02-23 12:23:12'),
('aa4699aca5c55f9ce59b9f17712fbf22437247bb9d9e8d4be22096acb05c66103e8c1404a10e4f70', 3, 2, 'Personal Access Token', '[]', 0, '2021-04-11 07:23:37', '2021-04-11 07:23:37', '2021-04-18 10:23:38'),
('b01574fc3432f6079351556b607d2532de234bd45eee1e93d5cccdc0f5a85f35e6606731e6585b08', 3, 2, 'Personal Access Token', '[]', 0, '2021-04-05 09:47:46', '2021-04-05 09:47:46', '2021-04-12 12:47:46'),
('be96548fd7db2c006893338b50913f533d535801586bae25ab380f9c46bb90bd9ca66067a0dda5c7', 3, 2, 'Personal Access Token', '[]', 0, '2021-04-13 09:33:34', '2021-04-13 09:33:34', '2021-04-20 12:33:35'),
('caf700461adcf3275bf3b4121689bccf7de9aa9fda33233928dcc1133e19b2821cb464bb50d32cf0', 1, 2, 'Personal Access Token', '[]', 0, '2021-01-06 10:56:55', '2021-01-06 10:56:55', '2021-01-13 12:56:56'),
('d3e2de050e773df03edd5c389a2366fe79afb5eef9146a77f894bdb6942e968dd503107ca92a8f47', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-11 14:13:43', '2021-02-11 14:13:43', '2021-02-18 16:13:44'),
('d443e931b533195e218736b9685d65d1b4044d01cd10cfba1e85f5206193b2e656a4ece945036d5a', 4, 2, 'Personal Access Token', '[]', 0, '2021-01-20 09:00:31', '2021-01-20 09:00:31', '2022-01-20 11:00:31'),
('d8468b9a2098851bb111e4040920074bb2709c3120cfca789772b0c55f9438cf8a2220fa0613106c', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-17 10:30:53', '2021-02-17 10:30:53', '2021-02-24 12:30:53'),
('de78b34fb7b3d4935ea2d81bdb269131f076fb0cd470c7c450e5457e56f05b982be82aa3d7f41452', 3, 2, 'Personal Access Token', '[]', 0, '2021-04-13 09:35:40', '2021-04-13 09:35:40', '2021-04-20 12:35:40'),
('ee192b5927cdd044a895ae6d8b230743bc8615201ec7a3e878b426c4467d35878560fd4a33764bcb', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-18 10:10:44', '2021-02-18 10:10:44', '2021-02-25 12:10:44'),
('ef22f4cdd75770167fe3c3c0d52d4bdbc50ba8a33d0480453299df262a4eddbee93b17c9d1c6a195', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-17 12:48:49', '2021-02-17 12:48:49', '2021-02-24 14:48:50'),
('f9d06dba2b6ba0afe5e74b46fb36c93da09ded76184a65921c9a66244068a009aa2ebb9e3957d169', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-03 16:29:16', '2021-02-03 16:29:16', '2020-02-03 18:30:17'),
('f9f49b36db197f71cbdbf301e4bff472c33bed9a7683958c3f794869e66166f74f415c0ad13cf159', 3, 2, 'Personal Access Token', '[]', 0, '2021-01-19 08:52:58', '2021-01-19 08:52:58', '2020-01-19 10:52:58'),
('f9f8309edb3779ca269531ab0ef3238b61dd0843adc3bd9eb4a66a60935d84f85dfb1e7657d7d9fe', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-03 16:16:01', '2021-02-03 16:16:01', '2020-02-03 18:16:01'),
('fca7f395b8bba08e985d78b76aada8c532bcf74ab959fe4d3c35ea187ec1d75f38b1e8baed13e512', 1, 2, 'Personal Access Token', '[]', 1, '2021-01-06 11:38:33', '2021-01-06 11:38:33', '2021-01-13 13:38:34');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `secret` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `provider` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `redirect` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Default password grant client', 'vnXDzeyS7mS0cHMuSfme9hQyZaDz7IAJQbZ8aLXP', NULL, 'http://localhost', 0, 1, 0, '2021-01-06 10:53:54', '2021-01-06 10:53:54'),
(2, NULL, 'Default personal access client', 'ioh8gcbRcT5DZ5HGuRD2DCXnSmTB9sLkOeZpDB2k', NULL, 'http://localhost', 1, 0, 0, '2021-01-06 10:53:54', '2021-01-06 10:53:54');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 2, '2021-01-06 10:53:54', '2021-01-06 10:53:54');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `access_token_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `party_infos`
--

CREATE TABLE `party_infos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type_infos_id` bigint(20) UNSIGNED DEFAULT NULL,
  `code` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `modified_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `party_infos`
--

INSERT INTO `party_infos` (`id`, `type_infos_id`, `code`, `deleted_at`, `is_enabled`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(6, 4, '2021-01-14 13:50:50tcsdT', NULL, 1, 'tester1', NULL, '2021-01-14 11:50:50', '2021-01-14 11:50:50'),
(7, 7, '2021-01-19 11:07:37E8sDN', NULL, 1, 'khald2002', NULL, '2021-01-19 09:07:37', '2021-01-19 09:07:37');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `modified_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`, `is_enabled`, `created_by`, `modified_by`, `deleted_at`) VALUES
(1, 'foo-edit-beneficiary', 'api', '2021-01-27 13:44:38', '2021-01-27 13:48:10', 1, 'tester1', 'tester1', NULL),
(2, 'foo-delete-beneficiary', 'api', '2021-01-27 13:44:45', '2021-01-27 13:44:45', 1, 'tester1', NULL, NULL),
(3, 'foo-add-beneficiary', 'api', '2021-01-27 13:44:49', '2021-01-27 13:44:49', 1, 'tester1', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `phones`
--

CREATE TABLE `phones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `number` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `phones`
--

INSERT INTO `phones` (`id`, `number`, `phone_type_id`, `user_id`, `created_at`, `updated_at`, `is_enabled`, `created_by`, `modified_by`, `deleted_at`) VALUES
(1, '0993546678', 1, 3, '2021-04-04 05:08:06', NULL, 1, 'khald2002', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `phone_types`
--

CREATE TABLE `phone_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` text COLLATE utf8mb4_unicode_ci,
  `modified_by` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `phone_types`
--

INSERT INTO `phone_types` (`id`, `name`, `is_enabled`, `created_by`, `modified_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'mobile', 1, 'khald2002', NULL, NULL, '2021-02-25 12:49:11', '2021-02-25 12:49:11'),
(2, 'home', 1, 'khald2002', 'khald2002', NULL, '2021-02-25 12:49:36', '2021-02-25 12:55:34');

-- --------------------------------------------------------

--
-- Table structure for table `points`
--

CREATE TABLE `points` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` varchar(255) DEFAULT NULL,
  `modified_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `points`
--

INSERT INTO `points` (`id`, `name`, `deleted_at`, `is_enabled`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(8, 'Husaynia', NULL, 1, 'khald2002', NULL, '2021-04-13 09:28:16', '2021-04-13 09:28:16');

-- --------------------------------------------------------

--
-- Table structure for table `polling_stations`
--

CREATE TABLE `polling_stations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `location_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `polling_stations`
--

INSERT INTO `polling_stations` (`id`, `location_id`, `name`, `is_enabled`, `created_by`, `modified_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 4, 'بون بون', 1, 'khald2002', 'khald2002', NULL, '2021-04-18 10:18:28', '2021-04-18 10:24:50');

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'type', NULL, NULL),
(2, 'choices', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `propertyables`
--

CREATE TABLE `propertyables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `propertyables_type` varchar(255) NOT NULL,
  `propertyables_id` bigint(20) UNSIGNED NOT NULL,
  `property_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `propertyables`
--

INSERT INTO `propertyables` (`id`, `propertyables_type`, `propertyables_id`, `property_id`, `created_at`, `updated_at`) VALUES
(1, 'Field', 1, 1, NULL, NULL),
(2, 'Field', 2, 1, NULL, NULL),
(3, 'Field', 3, 1, NULL, NULL),
(4, 'Field', 4, 1, NULL, NULL),
(5, 'Field', 5, 1, NULL, NULL),
(6, 'Field', 6, 1, NULL, NULL),
(7, 'Field', 7, 1, NULL, NULL),
(8, 'Field', 8, 1, NULL, NULL),
(10, 'Field', 9, 1, NULL, NULL),
(11, 'Field', 9, 2, NULL, NULL),
(12, 'Field', 10, 1, NULL, NULL),
(13, 'Field', 11, 1, NULL, NULL),
(14, 'Field', 12, 1, NULL, NULL),
(15, 'Field', 13, 1, NULL, NULL),
(16, 'Field', 13, 1, NULL, NULL),
(17, 'Field', 14, 1, NULL, NULL),
(18, 'Field', 15, 1, NULL, NULL),
(19, 'Field', 16, 1, NULL, NULL),
(20, 'Field', 17, 1, NULL, NULL),
(21, 'Field', 17, 2, NULL, NULL),
(22, 'Field', 18, 1, NULL, NULL),
(23, 'Field', 19, 1, NULL, NULL),
(24, 'Field', 20, 1, NULL, NULL),
(25, 'Field', 20, 2, NULL, NULL),
(26, 'Field', 21, 1, NULL, NULL),
(27, 'Field', 22, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `relations`
--

CREATE TABLE `relations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `code` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `modified_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `relations`
--

INSERT INTO `relations` (`id`, `name`, `description`, `code`, `is_enabled`, `created_by`, `modified_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'fmaily', 'fmily member relation', '2021-01-26 12:39:47sHMQe', 1, 'tester1', NULL, NULL, '2021-01-26 10:39:47', '2021-01-26 10:39:47'),
(2, 'wife', 'wife relation', '2021-01-26 12:40:014JcVq', 1, 'tester1', NULL, NULL, '2021-01-26 10:40:01', '2021-01-26 10:41:58'),
(3, 'daughter', 'daughter relation', '2021-01-26 12:41:102BkvE', 1, 'tester1', NULL, NULL, '2021-01-26 10:41:10', '2021-01-26 10:41:10'),
(4, 'Breadwinner', '', '2021-02-28 07:41:00uB3ln', 1, 'khald2002', NULL, NULL, '2021-02-28 05:41:00', '2021-02-28 05:41:00'),
(5, 'testttttttt', '', '2021-02-28 08:59:58sseQp', 1, 'khald2002', NULL, NULL, '2021-02-28 06:59:58', '2021-02-28 06:59:58');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `modified_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`, `is_enabled`, `created_by`, `modified_by`, `deleted_at`) VALUES
(1, 'normal', 'web', '2021-01-27 10:56:06', '2021-01-27 13:08:47', 1, 'tester1', 'tester1', NULL),
(2, 'manager', 'web', '2021-01-27 11:02:34', '2021-01-27 11:02:34', 1, 'tester1', NULL, NULL),
(3, 'custodian', 'web', '2021-01-27 12:50:39', '2021-01-27 12:50:39', 1, 'tester1', NULL, NULL),
(7, 'testtttttttt', 'web', '2021-02-18 05:38:19', '2021-02-18 05:38:19', 1, 'khald2002', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sentences`
--

CREATE TABLE `sentences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `body` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` text COLLATE utf8mb4_unicode_ci,
  `modified_by` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sentences`
--

INSERT INTO `sentences` (`id`, `body`, `is_enabled`, `created_by`, `modified_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(3, 'main_page', 1, 'khald2002', NULL, NULL, '2021-04-14 06:29:42', '2021-04-14 06:29:42');

-- --------------------------------------------------------

--
-- Table structure for table `special_need_types`
--

CREATE TABLE `special_need_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` text COLLATE utf8mb4_unicode_ci,
  `modified_by` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `special_need_types`
--

INSERT INTO `special_need_types` (`id`, `name`, `created_at`, `updated_at`, `is_enabled`, `created_by`, `modified_by`, `deleted_at`) VALUES
(1, 'short vision', '2021-02-28 08:41:22', '2021-02-28 08:49:32', 1, 'khald2002', 'khald2002', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE `statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `modified_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `name`, `is_enabled`, `created_by`, `modified_by`, `deleted_at`) VALUES
(1, 'pending', 1, 'tester1', NULL, NULL),
(2, 'waiting', 1, 'tester1', NULL, NULL),
(3, 'approved', 1, 'tester1', NULL, NULL),
(4, 'cancelled', 1, 'tester1', NULL, NULL),
(5, 'not started', 1, 'tester1', NULL, NULL),
(6, 'in progress', 1, 'tester1', NULL, NULL),
(7, 'completed', 1, 'tester1', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `steps`
--

CREATE TABLE `steps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `modified_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `steps`
--

INSERT INTO `steps` (`id`, `name`, `description`, `is_enabled`, `created_by`, `modified_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(6, 'request server approval', NULL, 1, 'khald2002', NULL, NULL, '2021-02-04 09:08:38', '2021-02-04 09:08:38'),
(7, 'request manager approval', NULL, 1, 'khald2002', NULL, NULL, '2021-02-04 09:08:52', '2021-02-04 09:08:52');

-- --------------------------------------------------------

--
-- Table structure for table `step_approvals`
--

CREATE TABLE `step_approvals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `activity_workflow_steps_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` text,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `modified_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `step_approvals`
--

INSERT INTO `step_approvals` (`id`, `created_at`, `updated_at`, `activity_workflow_steps_id`, `status_id`, `description`, `is_enabled`, `created_by`, `modified_by`, `deleted_at`) VALUES
(4, '2021-04-08 08:32:37', '2021-04-08 08:32:37', 3, 1, 'your request has been sent and waiting server approval', 1, 'khald2002', NULL, NULL),
(6, '2021-04-12 07:19:02', '2021-04-12 07:19:02', 4, 1, 'your request has been sent and waiting manager approval', 1, 'khald2002', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `modified_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`id`, `name`, `deleted_at`, `is_enabled`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(8, 'party', NULL, 1, 'tester1', 'tester1', '2021-01-12 08:31:53', '2021-01-12 08:40:44'),
(9, 'beneficiary', NULL, 1, 'tester1', NULL, '2021-02-02 14:35:03', '2021-02-02 14:35:03'),
(10, 'doctor', NULL, 1, 'khald2002', NULL, '2021-03-01 08:38:08', '2021-03-01 08:38:08'),
(11, 'engineer', NULL, 1, 'khald2002', NULL, '2021-03-01 08:39:31', '2021-03-01 08:39:31'),
(31, 'testingEvents', NULL, 1, 'khald2002', NULL, '2021-03-28 08:40:33', '2021-03-28 08:40:33'),
(32, 'some name for testiIIAALL', NULL, 1, 'khald2002', 'khald2002', '2021-03-28 08:41:28', '2021-03-29 05:10:16'),
(33, 'testingEvents2', NULL, 1, 'khald2002', NULL, '2021-03-28 08:50:14', '2021-03-28 08:50:14');

-- --------------------------------------------------------

--
-- Table structure for table `type_infos`
--

CREATE TABLE `type_infos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `modified_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `type_infos`
--

INSERT INTO `type_infos` (`id`, `user_id`, `type_id`, `deleted_at`, `is_enabled`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(4, 2, 9, NULL, 1, NULL, 'khald2002', '2021-01-12 10:57:22', '2021-03-29 05:24:53'),
(5, 2, 8, NULL, 1, 'tester1', NULL, '2021-01-19 08:01:54', '2021-01-19 08:01:54'),
(6, 3, 8, NULL, 1, 'tester1', NULL, '2021-01-19 08:38:45', '2021-01-19 08:38:45'),
(7, 4, 33, NULL, 1, 'khald2002', 'khald2002', '2021-01-19 09:07:37', '2021-03-29 06:05:33'),
(28, 2, 33, NULL, 1, 'khald2002', 'khald2002', '2021-02-04 13:53:06', '2021-03-29 05:17:40'),
(32, 28, 9, NULL, 1, 'khald2002', NULL, '2021-04-04 09:17:50', '2021-04-04 09:17:50'),
(33, 3, 9, NULL, 1, 'khald2002', NULL, '2021-04-05 08:56:23', '2021-04-05 08:56:23'),
(48, 43, 9, NULL, 1, 'khald2002', NULL, '2021-04-17 08:56:09', '2021-04-17 08:56:09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `modified_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `password`, `user_name`, `email`, `deleted_at`, `is_enabled`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(1, '$2y$10$hZwYoatPvjQzYMCod5NbFu9XCyEsGTa6ccJAi1JP7lp6bDIR6qMsS', 'tester1', NULL, NULL, 1, NULL, NULL, '2021-01-19 08:01:23', '2021-01-19 08:01:23'),
(2, '$2y$10$9YOd9uoupn7fAHRObw7wx.ZuckqpXI.77psxNEF3u2BL31IEDuMpa', 'sami2002', NULL, NULL, 1, 'tester1', NULL, '2021-01-19 08:01:54', '2021-01-19 08:01:54'),
(3, '$2y$10$Udl4ABpHpSVaA4uPZsigt.u4Dy0VVRb61y.qSIe.yocgrCFqPoxsK', 'khald2002', NULL, NULL, 1, 'tester1', NULL, '2021-01-19 08:38:45', '2021-01-19 08:38:45'),
(4, '$2y$10$ynA1g61LHYYSpwicKwZ.ZOJN8vM9EC7a7ZrO6JmdqHqeNda828tnC', 'soso2002', NULL, NULL, 1, 'khald2002', NULL, '2021-01-19 09:07:37', '2021-01-19 09:07:37'),
(5, '$2y$10$CLAykW0yza8GiJx4Ec94NeWACFT6xKZotwzMslV/ikUgCpq/SjGfW', 'koko34', NULL, NULL, 1, NULL, NULL, '2021-01-27 09:39:51', '2021-01-27 09:39:51'),
(24, '$2y$10$bZw0u7A5SBSt6DLL8TkHduxt1RfLuDlZyQuVliXrkk1j0O9LGqRYm', 'oioi34', NULL, NULL, 1, NULL, NULL, '2021-02-17 10:53:07', '2021-02-17 10:53:07'),
(28, '$2y$10$CTBbvnt.mqxXwa6/bbsGBen5xE7Gn5a/rSwsyOKYp/jrkOSgSMjpK', 'golden roger', NULL, NULL, 1, NULL, NULL, '2021-04-04 09:17:50', '2021-04-04 09:17:50'),
(43, '$2y$10$P360UtwDybQrmK7UWALqj.6B3ne1h86Vg9R9Yo23D3uriX3AwjAci', 'hamiiiiiiiiiiieeed', NULL, NULL, 1, NULL, NULL, '2021-04-17 08:56:09', '2021-04-17 08:56:09');

-- --------------------------------------------------------

--
-- Table structure for table `user_location`
--

CREATE TABLE `user_location` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `location_type_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `location_id` bigint(20) UNSIGNED NOT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_location`
--

INSERT INTO `user_location` (`id`, `location_type_id`, `user_id`, `location_id`, `is_enabled`, `created_by`, `modified_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(2, 2, 3, 4, 1, 'khald2002', NULL, NULL, '2021-04-13 09:29:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_relations`
--

CREATE TABLE `user_relations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `relation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `beneficiary_id` bigint(20) UNSIGNED DEFAULT NULL,
  `family_budget` bigint(20) UNSIGNED DEFAULT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_relations`
--

INSERT INTO `user_relations` (`id`, `relation_id`, `user_id`, `beneficiary_id`, `family_budget`, `is_enabled`, `created_by`, `modified_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 40, NULL, 1, 'khald2002', NULL, NULL, '2021-04-18 08:11:52', '2021-04-18 08:11:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activitable`
--
ALTER TABLE `activitable`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activitable_activitable_type_activitable_id_index` (`activitable_type`,`activitable_id`),
  ADD KEY `activitable_activity_id_foreign` (`activity_id`);

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `activity_workflow_steps`
--
ALTER TABLE `activity_workflow_steps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_workflow_steps_activitable_id_foreign` (`activitable_id`),
  ADD KEY `activity_workflow_steps_step_id_foreign` (`step_id`),
  ADD KEY `activity_workflow_steps_status_id_foreign` (`status_id`);

--
-- Indexes for table `beneficiary_infos`
--
ALTER TABLE `beneficiary_infos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `beneficiary_infos_type_infos_id_foreign` (`type_infos_id`),
  ADD KEY `beneficiary_infos_special_needs_type_id_foreign` (`special_needs_type_id`),
  ADD KEY `beneficiary_infos_beneficiary_type_id_foreign` (`beneficiary_type_id`),
  ADD KEY `beneficiary_infos_polling_station_id_foreign` (`polling_station_id`);

--
-- Indexes for table `beneficiary_types`
--
ALTER TABLE `beneficiary_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `events_eventable_type_eventable_id_index` (`eventable_type`,`eventable_id`),
  ADD KEY `events_to_eventable_type_to_eventable_id_index` (`to_eventable_type`,`to_eventable_id`),
  ADD KEY `events_user_id_foreign` (`user_id`);

--
-- Indexes for table `fields`
--
ALTER TABLE `fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form_fields`
--
ALTER TABLE `form_fields`
  ADD PRIMARY KEY (`id`),
  ADD KEY `form_fields_form_id_foreign` (`form_id`),
  ADD KEY `form_fields_field_id_foreign` (`field_id`),
  ADD KEY `form_fields_property_id_foreign` (`property_id`),
  ADD KEY `form_fields_input_id_foreign` (`input_id`);

--
-- Indexes for table `form_field_values`
--
ALTER TABLE `form_field_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `form_field_values_form_id_foreign` (`form_id`),
  ADD KEY `form_field_values_field_id_foreign` (`field_id`),
  ADD KEY `form_fields_owner_id_foreign` (`owner_id`),
  ADD KEY `form_fields_user_id_foreign` (`user_id`);

--
-- Indexes for table `inputs`
--
ALTER TABLE `inputs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inputs_input_id_foreign` (`input_id`),
  ADD KEY `inputs_property_id_foreign` (`property_id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `language_sentence`
--
ALTER TABLE `language_sentence`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `language_sentence_sentence_id_language_id_unique` (`sentence_id`,`language_id`),
  ADD KEY `language_sentence_language_id_foreign` (`language_id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `locations_point_id_foreign` (`point_id`);

--
-- Indexes for table `location_types`
--
ALTER TABLE `location_types`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `party_infos`
--
ALTER TABLE `party_infos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `party_infos_code_unique` (`code`),
  ADD KEY `party_infos_type_infos_id_foreign` (`type_infos_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phones`
--
ALTER TABLE `phones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phones_number_unique` (`number`),
  ADD KEY `phones_phone_type_id_foreign` (`phone_type_id`),
  ADD KEY `phones_user_id_foreign` (`user_id`);

--
-- Indexes for table `phone_types`
--
ALTER TABLE `phone_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `points`
--
ALTER TABLE `points`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `polling_stations`
--
ALTER TABLE `polling_stations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `polling_stations_location_id_foreign` (`location_id`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `propertyables`
--
ALTER TABLE `propertyables`
  ADD PRIMARY KEY (`id`),
  ADD KEY `propertyable_propertyable_type_propertyable_id_index` (`propertyables_type`(191),`propertyables_id`),
  ADD KEY `propertyable_property_id_foreign` (`property_id`);

--
-- Indexes for table `relations`
--
ALTER TABLE `relations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `relations_code_unique` (`code`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sentences`
--
ALTER TABLE `sentences`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `special_need_types`
--
ALTER TABLE `special_need_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `steps`
--
ALTER TABLE `steps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `step_approvals`
--
ALTER TABLE `step_approvals`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_activity_workflow_step_id` (`activity_workflow_steps_id`),
  ADD KEY `step_approvals_activity_workflow_steps_id_foreign` (`activity_workflow_steps_id`),
  ADD KEY `step_approvals_status_id_foreign` (`status_id`);

--
-- Indexes for table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `type_infos`
--
ALTER TABLE `type_infos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type_infos_type_id_user_id_unique` (`type_id`,`user_id`),
  ADD KEY `type_infos_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_user_name_unique` (`user_name`),
  ADD UNIQUE KEY `foreign_email` (`email`);

--
-- Indexes for table `user_location`
--
ALTER TABLE `user_location`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_lul` (`location_type_id`,`user_id`,`location_id`),
  ADD KEY `user_location_user_id_foreign` (`user_id`),
  ADD KEY `user_location_location_id_foreign` (`location_id`);

--
-- Indexes for table `user_relations`
--
ALTER TABLE `user_relations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_r_u_s` (`relation_id`,`user_id`,`beneficiary_id`),
  ADD KEY `user_relations_user_id_foreign` (`user_id`),
  ADD KEY `user_relations_beneficiary_id_foreign` (`beneficiary_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activitable`
--
ALTER TABLE `activitable`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `activity_workflow_steps`
--
ALTER TABLE `activity_workflow_steps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `beneficiary_infos`
--
ALTER TABLE `beneficiary_infos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `beneficiary_types`
--
ALTER TABLE `beneficiary_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `form_fields`
--
ALTER TABLE `form_fields`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `form_field_values`
--
ALTER TABLE `form_field_values`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT for table `inputs`
--
ALTER TABLE `inputs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `language_sentence`
--
ALTER TABLE `language_sentence`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `location_types`
--
ALTER TABLE `location_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `party_infos`
--
ALTER TABLE `party_infos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `phones`
--
ALTER TABLE `phones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `phone_types`
--
ALTER TABLE `phone_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `points`
--
ALTER TABLE `points`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `polling_stations`
--
ALTER TABLE `polling_stations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `propertyables`
--
ALTER TABLE `propertyables`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `relations`
--
ALTER TABLE `relations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sentences`
--
ALTER TABLE `sentences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `special_need_types`
--
ALTER TABLE `special_need_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `steps`
--
ALTER TABLE `steps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `step_approvals`
--
ALTER TABLE `step_approvals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `type_infos`
--
ALTER TABLE `type_infos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `user_location`
--
ALTER TABLE `user_location`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_relations`
--
ALTER TABLE `user_relations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activitable`
--
ALTER TABLE `activitable`
  ADD CONSTRAINT `activitable_activity_id_foreign` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `activity_workflow_steps`
--
ALTER TABLE `activity_workflow_steps`
  ADD CONSTRAINT `activity_workflow_steps_activitable_id_foreign` FOREIGN KEY (`activitable_id`) REFERENCES `activitable` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `activity_workflow_steps_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `activity_workflow_steps_step_id_foreign` FOREIGN KEY (`step_id`) REFERENCES `steps` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `beneficiary_infos`
--
ALTER TABLE `beneficiary_infos`
  ADD CONSTRAINT `beneficiary_infos_beneficiary_type_id_foreign` FOREIGN KEY (`beneficiary_type_id`) REFERENCES `beneficiary_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `beneficiary_infos_polling_station_id_foreign` FOREIGN KEY (`polling_station_id`) REFERENCES `polling_stations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `beneficiary_infos_special_needs_type_id_foreign` FOREIGN KEY (`special_needs_type_id`) REFERENCES `special_need_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `beneficiary_infos_type_infos_id_foreign` FOREIGN KEY (`type_infos_id`) REFERENCES `type_infos` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT;

--
-- Constraints for table `form_field_values`
--
ALTER TABLE `form_field_values`
  ADD CONSTRAINT `form_field_values_field_id_foreign` FOREIGN KEY (`field_id`) REFERENCES `fields` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `form_field_values_form_id_foreign` FOREIGN KEY (`form_id`) REFERENCES `forms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `form_fields_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `form_fields_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `language_sentence`
--
ALTER TABLE `language_sentence`
  ADD CONSTRAINT `language_sentence_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `language_sentence_sentence_id_foreign` FOREIGN KEY (`sentence_id`) REFERENCES `sentences` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `locations`
--
ALTER TABLE `locations`
  ADD CONSTRAINT `locations_point_id_foreign` FOREIGN KEY (`point_id`) REFERENCES `points` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `party_infos`
--
ALTER TABLE `party_infos`
  ADD CONSTRAINT `party_infos_type_infos_id_foreign` FOREIGN KEY (`type_infos_id`) REFERENCES `type_infos` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `phones`
--
ALTER TABLE `phones`
  ADD CONSTRAINT `phones_phone_type_id_foreign` FOREIGN KEY (`phone_type_id`) REFERENCES `phone_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `phones_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `polling_stations`
--
ALTER TABLE `polling_stations`
  ADD CONSTRAINT `polling_stations_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `propertyables`
--
ALTER TABLE `propertyables`
  ADD CONSTRAINT `propertyable_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `step_approvals`
--
ALTER TABLE `step_approvals`
  ADD CONSTRAINT `step_approvals_activity_workflow_steps_id_foreign` FOREIGN KEY (`activity_workflow_steps_id`) REFERENCES `activity_workflow_steps` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `step_approvals_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `type_infos`
--
ALTER TABLE `type_infos`
  ADD CONSTRAINT `type_infos_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `type_infos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_location`
--
ALTER TABLE `user_location`
  ADD CONSTRAINT `user_location_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_location_location_type_id_foreign` FOREIGN KEY (`location_type_id`) REFERENCES `location_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_location_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_relations`
--
ALTER TABLE `user_relations`
  ADD CONSTRAINT `user_relations_beneficiary_id_foreign` FOREIGN KEY (`beneficiary_id`) REFERENCES `beneficiary_infos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_relations_relation_id_foreign` FOREIGN KEY (`relation_id`) REFERENCES `relations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_relations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
