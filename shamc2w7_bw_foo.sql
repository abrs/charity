-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 31, 2021 at 08:31 AM
-- Server version: 5.6.41-84.1
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shamc2w7_bw_foo`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` varchar(255) DEFAULT NULL,
  `modified_by` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `name`, `is_enabled`, `created_by`, `modified_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'add_new_beneficiary', 1, 'tester1', 'tester1', NULL, '2021-02-03 16:15:29', '2021-02-03 16:18:32');

-- --------------------------------------------------------

--
-- Table structure for table `activity_workflow_steps`
--

CREATE TABLE `activity_workflow_steps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` varchar(255) DEFAULT NULL,
  `modified_by` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `activity_id` bigint(20) UNSIGNED DEFAULT NULL,
  `step_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_num` int(10) UNSIGNED NOT NULL,
  `finishing_percentage` varchar(255) DEFAULT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `activity_workflow_steps`
--

INSERT INTO `activity_workflow_steps` (`id`, `is_enabled`, `created_by`, `modified_by`, `deleted_at`, `activity_id`, `step_id`, `order_num`, `finishing_percentage`, `required`, `created_at`, `updated_at`) VALUES
(3, 1, 'khald2002', NULL, NULL, 1, 5, 1, '40', 1, '2021-02-04 11:07:40', '2021-02-04 11:07:40'),
(4, 1, 'khald2002', NULL, NULL, 1, 6, 2, '30', 1, '2021-02-04 11:08:38', '2021-02-04 11:08:38'),
(5, 1, 'khald2002', NULL, NULL, 1, 7, 5, '30', 1, '2021-02-04 11:08:52', '2021-02-04 11:08:52'),
(6, 1, 'khald2002', NULL, NULL, 1, 3, 3, '30', 1, '2021-02-04 11:08:52', '2021-02-04 11:08:52'),
(7, 1, 'khald2002', NULL, NULL, 1, 9, 4, '30', 1, '2021-02-04 11:08:52', '2021-02-04 11:08:52');

-- --------------------------------------------------------

--
-- Table structure for table `beneficiary_infos`
--

CREATE TABLE `beneficiary_infos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type_infos_id` bigint(20) UNSIGNED DEFAULT NULL,
  `location_id` bigint(20) UNSIGNED DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `second_name` varchar(255) DEFAULT NULL,
  `third_name` varchar(255) DEFAULT NULL,
  `fourth_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `known_as` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` bigint(20) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` varchar(255) DEFAULT NULL,
  `modified_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `birth` date DEFAULT NULL,
  `gender` tinyint(1) DEFAULT '0',
  `career` varchar(255) DEFAULT NULL,
  `polling_station_name` varchar(255) DEFAULT NULL,
  `national_number` bigint(20) UNSIGNED DEFAULT NULL,
  `is_alive` tinyint(1) NOT NULL DEFAULT '1',
  `standing` varchar(255) DEFAULT NULL,
  `date_of_death` date DEFAULT NULL,
  `is_special_needs` tinyint(1) NOT NULL DEFAULT '0',
  `special_needs_type_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `beneficiary_infos`
--

INSERT INTO `beneficiary_infos` (`id`, `type_infos_id`, `location_id`, `first_name`, `second_name`, `third_name`, `fourth_name`, `last_name`, `known_as`, `address`, `phone`, `deleted_at`, `is_enabled`, `created_by`, `modified_by`, `created_at`, `updated_at`, `birth`, `gender`, `career`, `polling_station_name`, `national_number`, `is_alive`, `standing`, `date_of_death`, `is_special_needs`, `special_needs_type_id`) VALUES
(11, NULL, NULL, 'Soso', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, 0, NULL),
(12, NULL, NULL, 'Almazza', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, 0, NULL),
(13, NULL, NULL, '099999999', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, 0, NULL),
(14, NULL, NULL, 'Soso', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, 0, NULL),
(15, NULL, NULL, 'Almazza', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, 0, NULL),
(16, NULL, NULL, '099999999', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, 0, NULL),
(17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2021-02-20 23:51:35', '2021-02-20 23:51:35', NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, 0, NULL),
(18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2021-02-20 23:58:31', '2021-02-20 23:58:31', NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, 0, NULL),
(19, NULL, NULL, 'Soso', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, 0, NULL),
(20, NULL, NULL, 'Almazza', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, 0, NULL),
(21, NULL, NULL, '099999999', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, 0, NULL),
(22, NULL, NULL, 'Soso', NULL, NULL, NULL, NULL, NULL, 'Almazza', 99999999, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `beneficiary_location`
--

CREATE TABLE `beneficiary_location` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `location_type_id` bigint(20) UNSIGNED NOT NULL,
  `beneficiary_id` bigint(20) UNSIGNED NOT NULL,
  `location_id` bigint(20) UNSIGNED NOT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `beneficiary_relations`
--

CREATE TABLE `beneficiary_relations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `relation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `beneficiary_id` bigint(20) UNSIGNED DEFAULT NULL,
  `s_beneficiary_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` varchar(255) DEFAULT NULL,
  `modified_by` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `family_budget` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(18, 'Create', 'App\\Models\\Type', 10, NULL, NULL, NULL, 'khald2002 Created Type name: testttttttttt, ', 3, '2021-03-29 11:03:17', '2021-03-29 11:03:17');

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
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
(143, 1, 12, 4, 3, '09999988', NULL, NULL);

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

INSERT INTO `language_sentence` (`id`, `sentence_id`, `language_id`, `is_enabled`, `created_by`, `modified_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(2, 2, 1, 1, NULL, NULL, NULL, NULL, NULL),
(4, 1, 2, 1, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `point_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` text NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` varchar(255) DEFAULT NULL,
  `modified_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `location_types`
--

CREATE TABLE `location_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
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
(18, '2021_01_18_114018_create_beneficiary_infos_table', 7),
(19, '2014_10_12_000000_create_users_table', 8),
(24, '2021_01_21_142738_create_relations_table', 11),
(26, '2021_01_26_124643_create_beneficiary_relations_table', 12),
(27, '2021_01_27_120415_add_bwire_attributes_to_roles', 13),
(28, '2021_01_27_152245_add_bwire_attributes_to_permissions', 14),
(29, '2021_02_02_122857_create_statuses_table', 15),
(33, '2021_02_03_152227_create_steps_table', 16),
(34, '2021_02_03_155934_create_activities_table', 17),
(35, '2021_02_03_162424_create_activity_workflow_steps_table', 18),
(36, '2021_02_04_111805_create_step_approvals_table', 19);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\User', 1),
(3, 'App\\User', 3),
(1, 'App\\User', 24),
(1, 'App\\User', 25),
(1, 'App\\User', 26),
(2, 'App\\User', 26),
(1, 'App\\User', 27),
(1, 'App\\User', 28),
(1, 'App\\User', 29),
(1, 'App\\User', 30),
(3, 'App\\User', 31),
(2, 'App\\User', 32);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `scopes` text,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('001036d2dfc48140ab9591054e51e7e1d7fc80b6bd727e688fa57e4d716157976c189c1796313e23', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-21 16:21:47', '2021-02-21 16:21:47', '2021-02-28 16:21:47'),
('02166dad09884d4215d79c941139ff5023dd3617f46e7360696e14040ff74a896391d258a7843d34', 3, 2, 'Personal Access Token', '[]', 0, '2021-03-14 09:35:33', '2021-03-14 09:35:33', '2021-03-21 09:35:33'),
('0a300ba4a15b347b4b64c8ff05bd807bc32f6a925f4d51949851d75acbff1cf6361c5bf2192adb2d', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-04 10:45:57', '2021-02-04 10:45:57', '2021-01-04 10:45:57'),
('0a9d1f12be504d75e6207bab393e39c9bcb6b310df7d8127131632d3206eda1c43302bb5f7ae5566', 3, 2, 'Personal Access Token', '[]', 0, '2021-03-29 11:02:23', '2021-03-29 11:02:23', '2021-04-05 11:02:23'),
('0ea791eea5c0afea125cebb7cf1e022caad61d30384cdc07f8e7a4936dec3ba35029b45ee8648032', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-21 15:33:58', '2021-02-21 15:33:58', '2021-02-28 15:33:58'),
('0f54a8c2379e13a9042dc85fdc8705a027474d447a4e6e5f20c0ebb29c46a0055f6347bc471de27e', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-25 08:59:32', '2021-02-25 08:59:32', '2021-03-04 08:59:32'),
('0fd125c0500164cc1601f769574ba14c4ae9b394d06be10384dfd1ec9c75f938577103a624299619', 4, 2, 'Personal Access Token', '[]', 0, '2021-01-20 12:37:24', '2021-01-20 12:37:24', '2021-01-27 12:37:24'),
('158c3cdb13743d8e818635595e0812f95e437506e1b2ad2c3c1df046509b579d101ef8030680cd04', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-21 12:43:29', '2021-02-21 12:43:29', '2021-02-28 12:43:29'),
('15e1ad77bdb9ca2cd003f03c0646c48f2a14f27d595b8fce238e72853572495debf100070369c460', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-22 10:24:28', '2021-02-22 10:24:28', '2021-03-01 10:24:28'),
('173bf2ef69f92f5bd2b2b23266a3d1a1440f6aaea1449c43affc09473a1712a780d90afc444d9a43', 3, 2, 'Personal Access Token', '[]', 0, '2021-03-28 09:57:43', '2021-03-28 09:57:43', '2021-04-04 09:57:43'),
('19008ddb3fa7c66220debb2e4acc5075eba2c053ea6f50b18952f84ccdf246d7109c056d6767c2e0', 2, 2, 'Personal Access Token', '[]', 0, '2021-01-06 13:04:02', '2021-01-06 13:04:02', '2021-01-13 13:04:02'),
('1a15275f5636a9189a86d57a43aa9551bb97cbc1baec1f3412bc36d55a58a768cbee122fb0192eb5', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-22 10:03:18', '2021-02-22 10:03:18', '2021-03-01 10:03:18'),
('1a5964fa6868539a1fb23c440b83d7a562743b338daffffd83237d1749dd112ac26dfc27cb5694b1', 4, 2, 'Personal Access Token', '[]', 0, '2021-01-20 12:34:55', '2021-01-20 12:34:55', '2021-01-27 12:34:55'),
('1c5a0ba020e4edaed8f2c7050bcf8638b7fee5dab1cf77f7453588d43de26ac82559e3635aa4b94d', 3, 2, 'Personal Access Token', '[]', 0, '2021-03-29 11:35:51', '2021-03-29 11:35:51', '2021-04-05 11:35:51'),
('1de170e9d79ddaa21ffe2933f2901a401fe1bf9ad4a4b2f8f4e90122cf4c8441ec92693b8b27a359', 3, 2, 'Personal Access Token', '[]', 0, '2021-03-28 09:58:09', '2021-03-28 09:58:09', '2021-04-04 09:58:09'),
('1ef5ceca1edb6b53c316e034df1adcc92212c5936c6b9322cc0680d97a4ac1580d9645f35be131c2', 31, 2, 'Personal Access Token', '[]', 0, '2021-03-29 13:52:56', '2021-03-29 13:52:56', '2021-04-05 13:52:56'),
('20e245605425bb243076411c584420c60d49b8987c39ea47d68e97a0741d649610c340778b2340eb', 31, 2, 'Personal Access Token', '[]', 0, '2021-03-29 13:04:36', '2021-03-29 13:04:36', '2021-04-05 13:04:36'),
('21bc511dec2291be57264f4f04afb86cbec37e864bfcee60659c7c3a4ca79fed63764d6fe9e98a1c', 31, 2, 'Personal Access Token', '[]', 0, '2021-03-29 13:58:52', '2021-03-29 13:58:52', '2021-04-05 13:58:52'),
('244ed939730839d412634b77fc819fdf17ecf860c282cfbf9a801895936e5b26ced7756cd39935d3', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-22 11:59:32', '2021-02-22 11:59:32', '2021-03-01 11:59:32'),
('24b3c0268483731c5a3314d5054742860cf1baa806857fec3d9b5380f6525b2882431faa0636fbd1', 3, 2, 'Personal Access Token', '[]', 0, '2021-03-28 10:42:39', '2021-03-28 10:42:39', '2021-04-04 10:42:39'),
('254b19a33311a83f0ab7cb103b82f23d69d6274a424c4749002938c5c088bf93ecb8a3ab685c7242', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-21 12:38:30', '2021-02-21 12:38:30', '2021-02-28 12:38:30'),
('274af3577fe3cb5c77c1cf7fe971e322b443172e0625a45893573989cfc6d7d81f04c5d311fbbcb8', 31, 2, 'Personal Access Token', '[]', 0, '2021-03-29 14:02:25', '2021-03-29 14:02:25', '2021-04-05 14:02:25'),
('2904a3e893718430e47c9c06209ebf43bc8c79cec40925b3141e1e1d82a1c1696759eb825b862e8c', 31, 2, 'Personal Access Token', '[]', 0, '2021-03-29 13:55:34', '2021-03-29 13:55:34', '2021-04-05 13:55:34'),
('2c1089836c5821d54b115f2cc823d26c62f64b766a9881913a96a48c0d7f3eb5c80c8754d5b85cbf', 1, 2, 'Personal Access Token', '[]', 1, '2021-01-06 14:17:44', '2021-01-06 14:17:44', '2021-01-13 14:17:44'),
('2ed66e3521bc157107251243d01e5d97c7b4d152927e9f0b5ae5d2880c799f10b64dd72af1c144db', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-25 10:33:43', '2021-02-25 10:33:43', '2021-03-04 10:33:43'),
('34bc5276666cf99580ab07cbb65bf296d4d46d2ca235ab0f3614a48c8bdb6ce326ff85daf25c9e8a', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-21 14:47:08', '2021-02-21 14:47:08', '2021-02-28 14:47:08'),
('3c5e7895b2390e1eb58cda23d00d413e7f7c04a64778d669d3f1a8e53c57a0565d8c6ae73cf0d068', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-24 11:36:07', '2021-02-24 11:36:07', '2021-03-03 11:36:07'),
('3c6a771e0c6f6abe4730986fd546bd1045768f38663a2df4ec6efa339731cac839fda91010ea0317', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-18 17:31:56', '2021-02-18 17:31:56', '2021-02-25 17:31:56'),
('3cdc80ca8f5ab0a8f37d58e35ba108dd9ce3ac924a5dacbec93ad5123132ceff3e02a093f89d34d2', 32, 2, 'Personal Access Token', '[]', 0, '2021-03-29 13:07:37', '2021-03-29 13:07:37', '2021-04-05 13:07:37'),
('3d65f8a1365f2a35eab6c0192f85cdba92be9b15e8ba89ae0f8722601a27c72eedba45d348781f4a', 31, 2, 'Personal Access Token', '[]', 0, '2021-03-29 14:06:44', '2021-03-29 14:06:44', '2021-04-05 14:06:44'),
('3fb45d0691690f90f51d62bf39346b92d8f8598a5bf93ead9f70569327ea94eb99ef00bc62dd0f82', 3, 2, 'Personal Access Token', '[]', 0, '2021-03-28 11:37:44', '2021-03-28 11:37:44', '2021-04-04 11:37:45'),
('4cdb3a6068e349972fb8000ce053633b3d1cb7df2522753306b3513d88cff435f54a45963ade6ec1', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-21 16:33:14', '2021-02-21 16:33:14', '2021-02-28 16:33:14'),
('522ff40c81498d2dcc48b23f188e250609e2235c4cdbe9fdd3e3d1ec9098c6d518696c65c32a18d8', 32, 2, 'Personal Access Token', '[]', 0, '2021-03-29 13:52:35', '2021-03-29 13:52:35', '2021-04-05 13:52:35'),
('541af5104adb608560d79cb8421c9e880cb50653bcc530bdfe68fce733f6b1fee8c9f7cf8ddc18c0', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-21 16:22:57', '2021-02-21 16:22:57', '2021-02-28 16:22:58'),
('599fbb171e8ef9a1707ae5a17adeda973c6cf09fd8b891244328f461e736976665626533fe8dd64f', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-21 15:25:46', '2021-02-21 15:25:46', '2021-02-28 15:25:46'),
('59a59b9805edbd4187cf9e60d55e025b4a43ffdd9f36382d5ee2f9ba47644ca4649208b5aa67bf9e', 3, 2, 'Personal Access Token', '[]', 0, '2021-03-25 12:47:50', '2021-03-25 12:47:50', '2021-04-01 12:47:50'),
('6469873ddada348996ff949163f96786a27cf3b8a4636eb1a445bb4a0d82170de60d53dcd396e636', 4, 2, 'Personal Access Token', '[]', 0, '2021-01-20 11:01:00', '2021-01-20 11:01:00', '2021-01-27 11:01:00'),
('64d11fd9a0cf1028950d02e2b1ebb89563998860121ded7fcbf3b204a61d973694a5b201310bf312', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-22 15:07:57', '2021-02-22 15:07:57', '2021-03-01 15:07:57'),
('6c4a69c3ae5fb85e0c7ff04a6fc96054f6a8777931291b495300f4d9275fa4f8c063c9d9ba8d4293', 3, 2, 'Personal Access Token', '[]', 0, '2021-03-22 13:13:07', '2021-03-22 13:13:07', '2021-03-29 13:13:07'),
('6d299f500d6a662c38d78d318e4f6b26e353a5fdbe86d0f9258fb783a21ad341992ab958e685f096', 26, 2, 'Personal Access Token', '[]', 0, '2021-02-20 19:12:59', '2021-02-20 19:12:59', '2021-02-27 21:12:59'),
('77e43713eb8358bad888692f42bec78a82bb83959b1f506c21449cd7cafa40fa921899dc44ad780c', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-25 08:06:06', '2021-02-25 08:06:06', '2021-03-04 08:06:06'),
('78cdc7c62a57ed7f5993680119a969979a724d403ac4dfcf98eba11f70cac724a075bcccbb489400', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-25 07:33:39', '2021-02-25 07:33:39', '2021-03-04 07:33:39'),
('7fe57858a8a8efac295f1a8b29c2010cd6ba05b2870c0a57b619f8da752ce4f117bf22850b04aa67', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-25 08:10:58', '2021-02-25 08:10:58', '2021-03-04 08:10:58'),
('8124cfd51e3cf214538353f161cf08c1191bbe585c7bad92b2eae4a62e273657eb1555a6acc7b0cb', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-18 17:34:45', '2021-02-18 17:34:45', '2021-02-25 17:34:45'),
('858f790ef5792ea8ab5ce974223bf48d2e9ded14cc6f2696bf09b65bf3140fced239906a67ce8486', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-22 10:27:51', '2021-02-22 10:27:51', '2021-03-01 10:27:51'),
('8621108925a53c9d84e900a32de99e94f96bcc60a345988b2c8ebfca9bf824887e825821ac41e99d', 3, 2, 'Personal Access Token', '[]', 0, '2021-03-17 15:23:26', '2021-03-17 15:23:26', '2021-03-24 15:23:26'),
('863bb8170fc6a66e008845306666352b69a97b1e32137d2234c854715a0398975c744ddcd9da40d7', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-23 09:20:35', '2021-02-23 09:20:35', '2021-03-02 09:20:35'),
('8ce7888ca091841b605453140793eed28f25909daae31bc2eb7dc6786206dade1ffac722183d02f3', 3, 2, 'Personal Access Token', '[]', 0, '2021-03-24 11:21:45', '2021-03-24 11:21:45', '2021-03-31 11:21:45'),
('8e5d7279ecfbb0c58730828769b41f8ef128f1993d6603851c8969aac1bdc8ef598d9abbb94fab21', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-25 08:04:57', '2021-02-25 08:04:57', '2021-03-04 08:04:57'),
('8e9ba96e9b17b00f9f8bbe64a8d5133382102ed054ca8594231f885487a244200ca3eff6b73bf80a', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-03 18:27:47', '2021-02-03 18:27:47', '2021-02-10 18:27:48'),
('8f92cc1a15cd14b7c8c80d86e21ce08feb5ba0111399d67e80293a593b7ebc465caf5490895803c0', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-21 15:43:31', '2021-02-21 15:43:31', '2021-02-28 15:43:31'),
('945d888cc6b4dd98575d69d5fc8decd5182c11371f2b876e18bab4a9aced8c21821fa4173737acab', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-18 17:39:40', '2021-02-18 17:39:40', '2021-02-25 17:39:40'),
('95ddeb1e4de0352077b1387bed76de147855b048122592a3acf532f96bf74ce17f686c16e80a6f32', 3, 2, 'Personal Access Token', '[]', 0, '2021-03-29 12:37:32', '2021-03-29 12:37:32', '2021-04-05 12:37:32'),
('97698c9747cc9a703e9cb3b43bf1d1d5a1dffc980641a63177d3b91d938806af07343ab911f63216', 1, 2, 'Personal Access Token', '[]', 0, '2021-01-06 12:55:21', '2021-01-06 12:55:21', '2021-01-13 12:55:22'),
('99cb0f3bd59d4ba903a1b2c77fa717017c33b96de261b1fedda12fafd0a64016583153da4820bbcf', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-21 15:36:54', '2021-02-21 15:36:54', '2021-02-28 15:36:54'),
('9dc997fd5cceda023a5df22190de3924e0c036cac59a7478b82224193a861a5e4805e9ab91c30348', 1, 2, 'Personal Access Token', '[]', 1, '2021-01-06 13:44:35', '2021-01-06 13:44:35', '2021-01-13 13:44:35'),
('a023d560df231e453ba07713957bd4c23ab1230df006aebb6bb333e542a66ef2a6d68550f16d3650', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-21 13:17:41', '2021-02-21 13:17:41', '2021-02-28 13:17:41'),
('a0f138b2d5864839ce79e678553a2931534013a5d66b56d17da7407da83987b9195be699b9ea143e', 3, 2, 'Personal Access Token', '[]', 0, '2021-03-29 13:49:36', '2021-03-29 13:49:36', '2021-04-05 13:49:36'),
('a2096f45589bf9f93a7b19bd54e66f0ecb8237d7029e5bb87919be38c5a556079512783186267e38', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-17 10:37:17', '2021-02-17 10:37:17', '2021-02-24 10:37:17'),
('a287e1b31dd3afefff9b00bcf705f48a3d9e95dfeace3ac01a4d266ae19b06dae04ee7d70fc5abc6', 3, 2, 'Personal Access Token', '[]', 0, '2021-03-28 11:11:42', '2021-03-28 11:11:42', '2021-04-04 11:11:42'),
('a57d8e4ede60f560bfa66260871e41bcc329dfd51b709a50602bde4c54ca90092a6ca0a4beb02d3e', 31, 2, 'Personal Access Token', '[]', 0, '2021-03-29 14:02:47', '2021-03-29 14:02:47', '2021-04-05 14:02:47'),
('abeb3b731d23e846cdb4a1979287fe78f2a37823e9c9ec1ec16bd315c15e6314f7ef21a93e6f4ac2', 3, 2, 'Personal Access Token', '[]', 0, '2021-03-28 13:32:16', '2021-03-28 13:32:16', '2021-04-04 13:32:16'),
('ac8a792022b922213398556faba09b6143112008ef984566846bece9314bff73d256e9f2161d73f5', 3, 2, 'Personal Access Token', '[]', 0, '2021-03-28 13:07:58', '2021-03-28 13:07:58', '2021-04-04 13:07:58'),
('acecf048e7e732bad40ab3b56346be0a338b62a10f4fce49aa587773ad299abefb4cb88cd21312bf', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-22 12:39:21', '2021-02-22 12:39:21', '2021-03-01 12:39:21'),
('b92fda998a3c6fa3c57cd0e03dd69a65e0b5f51c2b408f586943141828a56b9bb1686d6441ebe341', 3, 2, 'Personal Access Token', '[]', 0, '2021-03-04 06:57:26', '2021-03-04 06:57:26', '2021-03-11 06:57:26'),
('b9722d240d5c76aaab753292df30b8bfbfe7119a9f74f9b73528acd9f91df4027b0b8c5c1e45a66f', 3, 2, 'Personal Access Token', '[]', 0, '2021-03-28 09:51:57', '2021-03-28 09:51:57', '2021-04-04 09:51:57'),
('baab5bb4fb63e480a70294d8e6009cfc1bcdf1e298a9312e7e278c7ae7dcead83d3cb6860695e904', 3, 2, 'Personal Access Token', '[]', 0, '2021-03-28 12:30:56', '2021-03-28 12:30:56', '2021-04-04 12:30:56'),
('beae1294038724da61bfda5237764c686b8d93a9386f5454ffd3cff018ad6f200dbbe6a84ba61a34', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-25 12:02:12', '2021-02-25 12:02:12', '2021-03-04 12:02:12'),
('c24d95956769496e21e1abe201962a58f3c6a0e1addf48d79ed770ec06c02842d68896d47c6674a6', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-23 09:19:41', '2021-02-23 09:19:41', '2021-03-02 09:19:41'),
('c993024f184b8a606f9bbeba0e869e92dc881e122f1149599515c7c35c0d10b8b7112afb76a06d83', 31, 2, 'Personal Access Token', '[]', 0, '2021-03-29 14:00:52', '2021-03-29 14:00:52', '2021-04-05 14:00:52'),
('caf700461adcf3275bf3b4121689bccf7de9aa9fda33233928dcc1133e19b2821cb464bb50d32cf0', 1, 2, 'Personal Access Token', '[]', 0, '2021-01-06 12:56:55', '2021-01-06 12:56:55', '2021-01-13 12:56:56'),
('cdd343ef6dca6f092429117d8510b5b7bf420500c53018c809ca06d2ec1bb8c658a8fe5495d2b008', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-21 15:29:26', '2021-02-21 15:29:26', '2021-02-28 15:29:26'),
('ce21911472431513ffdfc631421eb3faab2f3fc6b5f134a9192adae5cfe358ffbc0a40b7964e9995', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-22 15:01:20', '2021-02-22 15:01:20', '2021-03-01 15:01:20'),
('d3e2de050e773df03edd5c389a2366fe79afb5eef9146a77f894bdb6942e968dd503107ca92a8f47', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-11 16:13:43', '2021-02-11 16:13:43', '2021-02-18 16:13:44'),
('d443e931b533195e218736b9685d65d1b4044d01cd10cfba1e85f5206193b2e656a4ece945036d5a', 4, 2, 'Personal Access Token', '[]', 0, '2021-01-20 11:00:31', '2021-01-20 11:00:31', '2022-01-20 11:00:31'),
('d4585976d3c8de26f97658a358d7e15d407ef8906a7b73718b14425309d8e25e0ad7833ba88c7351', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-22 10:29:04', '2021-02-22 10:29:04', '2021-03-01 10:29:04'),
('d8468b9a2098851bb111e4040920074bb2709c3120cfca789772b0c55f9438cf8a2220fa0613106c', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-17 12:30:53', '2021-02-17 12:30:53', '2021-02-24 12:30:53'),
('de37e8995efc3a14384755ebbc8bbdf1a5e21dc141f8bd260697e990d870d2b1cf6c22366307eecd', 31, 2, 'Personal Access Token', '[]', 0, '2021-03-29 13:52:12', '2021-03-29 13:52:12', '2021-04-05 13:52:12'),
('ea54e68f12990c847c0ebf0c84e663d5af3e53dee93f2cb807b662ec9abbfbd038d37cf44d781cf3', 31, 2, 'Personal Access Token', '[]', 0, '2021-03-29 13:52:23', '2021-03-29 13:52:23', '2021-04-05 13:52:23'),
('ecdf8b127ecd92d116dc4a6d3942ebd5d7e854d3a48e0fd4650106e172afdc82f40ea3a38820d31b', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-25 07:25:14', '2021-02-25 07:25:14', '2021-03-04 07:25:14'),
('ee0c60ff485fb6d19ff358901187987b8ebbafbf7012bcca9688a4beb2cb7338cc1436a1731fb903', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-25 08:24:30', '2021-02-25 08:24:30', '2021-03-04 08:24:30'),
('ef22f4cdd75770167fe3c3c0d52d4bdbc50ba8a33d0480453299df262a4eddbee93b17c9d1c6a195', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-17 14:48:49', '2021-02-17 14:48:49', '2021-02-24 14:48:50'),
('efe2ca67ba75c6ef304d05e866a8b53d6084f3a8059558b9fb2addd24b4a89baa6af87f2d661c2a4', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-22 09:53:31', '2021-02-22 09:53:31', '2021-03-01 09:53:31'),
('f42998c2eb59c11fc7a2533c893cb12742cf0ad28f9d515036e30df9bf84d279b9649f8a8be87ed0', 3, 2, 'Personal Access Token', '[]', 0, '2021-03-28 13:20:12', '2021-03-28 13:20:12', '2021-04-04 13:20:12'),
('f6f9285bdae1555df0a4927dcef692123f56e4d290e55d48b50ea5088a8bfb4fc0e242256a3bc0e2', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-22 10:26:33', '2021-02-22 10:26:33', '2021-03-01 10:26:33'),
('f771314a403e27355e5ee0edf4feb63bd8cac589f8cc71269d93f151a0a6abe59700db6e2edd5a98', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-18 12:42:54', '2021-02-18 12:42:54', '2021-02-25 12:42:54'),
('f97eeb2970fd122cdba7257095ef97496b6efd311250dc61216c54ea835641d76179100f089212c7', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-25 07:21:47', '2021-02-25 07:21:47', '2021-03-04 07:21:47'),
('f9d06dba2b6ba0afe5e74b46fb36c93da09ded76184a65921c9a66244068a009aa2ebb9e3957d169', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-03 18:29:16', '2021-02-03 18:29:16', '2020-02-03 18:30:17'),
('f9f49b36db197f71cbdbf301e4bff472c33bed9a7683958c3f794869e66166f74f415c0ad13cf159', 3, 2, 'Personal Access Token', '[]', 0, '2021-01-19 10:52:58', '2021-01-19 10:52:58', '2020-01-19 10:52:58'),
('f9f8309edb3779ca269531ab0ef3238b61dd0843adc3bd9eb4a66a60935d84f85dfb1e7657d7d9fe', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-03 18:16:01', '2021-02-03 18:16:01', '2020-02-03 18:16:01'),
('fca7f395b8bba08e985d78b76aada8c532bcf74ab959fe4d3c35ea187ec1d75f38b1e8baed13e512', 1, 2, 'Personal Access Token', '[]', 1, '2021-01-06 13:38:33', '2021-01-06 13:38:33', '2021-01-13 13:38:34'),
('fd7ebb72e5ad7704c0a5fad2b561747abeb1ce572f08d329510a5ec89195ca362a941fb97137d619', 3, 2, 'Personal Access Token', '[]', 0, '2021-02-22 15:20:45', '2021-02-22 15:20:45', '2021-03-01 15:20:45'),
('ffad60dcf890bbf2fbc4d55893dce0bbd75018ea7bd37b3a495c2bb7de8c096d20446b7c1391636a', 3, 2, 'Personal Access Token', '[]', 0, '2021-03-28 13:30:57', '2021-03-28 13:30:57', '2021-04-04 13:30:58');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text,
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
  `name` varchar(255) NOT NULL,
  `secret` varchar(100) DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `redirect` text NOT NULL,
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
(1, NULL, 'Default password grant client', 'vnXDzeyS7mS0cHMuSfme9hQyZaDz7IAJQbZ8aLXP', NULL, 'http://localhost', 0, 1, 0, '2021-01-06 12:53:54', '2021-01-06 12:53:54'),
(2, NULL, 'Default personal access client', 'ioh8gcbRcT5DZ5HGuRD2DCXnSmTB9sLkOeZpDB2k', NULL, 'http://localhost', 1, 0, 0, '2021-01-06 12:53:54', '2021-01-06 12:53:54');

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
(1, 2, '2021-01-06 12:53:54', '2021-01-06 12:53:54');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) NOT NULL,
  `access_token_id` varchar(100) NOT NULL,
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
  `code` varchar(255) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` varchar(255) DEFAULT NULL,
  `modified_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `party_infos`
--

INSERT INTO `party_infos` (`id`, `type_infos_id`, `code`, `deleted_at`, `is_enabled`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(6, 4, '2021-01-14 13:50:50tcsdT', NULL, 1, 'tester1', NULL, '2021-01-14 13:50:50', '2021-01-14 13:50:50'),
(7, 7, '2021-01-19 11:07:37E8sDN', NULL, 1, 'khald2002', NULL, '2021-01-19 11:07:37', '2021-01-19 11:07:37');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` varchar(255) DEFAULT NULL,
  `modified_by` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`, `is_enabled`, `created_by`, `modified_by`, `deleted_at`) VALUES
(1, 'foo-edit-beneficiary', 'api', '2021-01-27 15:44:38', '2021-01-27 15:48:10', 1, 'tester1', 'tester1', NULL),
(2, 'foo-delete-beneficiary', 'api', '2021-01-27 15:44:45', '2021-01-27 15:44:45', 1, 'tester1', NULL, NULL),
(3, 'foo-add-beneficiary', 'api', '2021-01-27 15:44:49', '2021-01-27 15:44:49', 1, 'tester1', NULL, NULL);

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

-- --------------------------------------------------------

--
-- Table structure for table `points`
--

CREATE TABLE `points` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
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
(6, '{\"ar\": \"حسينية\", \"en\": \"Hussinya\"}', NULL, 1, 'khald2002', 'khald2002', '2021-02-16 15:04:48', '2021-02-16 15:09:17');

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
  `name` text NOT NULL,
  `description` text,
  `code` varchar(255) NOT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` varchar(255) DEFAULT NULL,
  `modified_by` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `relations`
--

INSERT INTO `relations` (`id`, `name`, `description`, `code`, `is_enabled`, `created_by`, `modified_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '{\"en\": \"fmaily\"}', '{\"en\": \"fmily member relation\"}', '2021-01-26 12:39:47sHMQe', 1, 'tester1', NULL, NULL, '2021-01-26 12:39:47', '2021-01-26 12:39:47'),
(2, '{\"en\": \"wife\"}', '{\"en\": \"wife relation\"}', '2021-01-26 12:40:014JcVq', 1, 'tester1', NULL, NULL, '2021-01-26 12:40:01', '2021-01-26 12:41:58'),
(3, '{\"en\": \"daughter\"}', '{\"en\": \"daughter relation\"}', '2021-01-26 12:41:102BkvE', 1, 'tester1', NULL, NULL, '2021-01-26 12:41:10', '2021-01-26 12:41:10');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` varchar(255) DEFAULT NULL,
  `modified_by` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`, `is_enabled`, `created_by`, `modified_by`, `deleted_at`) VALUES
(1, 'normal', 'web', '2021-01-27 12:56:06', '2021-01-27 15:08:47', 1, 'tester1', 'tester1', NULL),
(2, 'manager', 'web', '2021-01-27 13:02:34', '2021-01-27 13:02:34', 1, 'tester1', NULL, NULL),
(3, 'custodian', 'web', '2021-01-27 14:50:39', '2021-01-27 14:50:39', 1, 'tester1', NULL, NULL);

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
(1, 'الواجهة الرئيسية', 1, 'khald2002', 'khald2002', NULL, '2021-03-30 08:29:17', '2021-03-30 08:40:51'),
(2, 'main page', 1, 'khald2002', NULL, NULL, '2021-03-30 08:29:33', '2021-03-30 08:35:23');

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

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE `statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` varchar(255) DEFAULT NULL,
  `modified_by` varchar(255) DEFAULT NULL,
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
(5, '{\"en\": \"not started\"}', 1, 'tester1', NULL, NULL),
(6, '{\"en\": \"in progress\"}', 1, 'tester1', NULL, NULL),
(7, 'completed', 1, 'tester1', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `steps`
--

CREATE TABLE `steps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `description` text,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `optional` tinyint(1) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `modified_by` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `steps`
--

INSERT INTO `steps` (`id`, `name`, `description`, `is_enabled`, `optional`, `created_by`, `modified_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '{\"en\": \"add_new_beneficiary_details_step\"}', '{\"en\": \"adding a new beneificary details step\"}', 1, NULL, 'tester1', NULL, NULL, '2021-02-03 15:50:25', '2021-02-03 15:50:25'),
(2, '{\"en\": \"server_approval\"}', '{\"en\": \"needs approval from the server\"}', 1, NULL, 'tester1', NULL, NULL, '2021-02-03 15:51:06', '2021-02-03 15:51:06'),
(3, 'طلب تعديل الاستمارة', '{\"ar\": \"بحاجة لموافقة من المدير\", \"en\": \"needs approval from the manager\"}', 1, 1, 'khald2002', 'khald2002', NULL, '2021-02-17 10:41:01', '2021-02-17 10:43:02'),
(4, '{\"en\": \"testing step\"}', NULL, 1, NULL, 'tester1', NULL, NULL, '2021-02-03 17:52:06', '2021-02-03 17:52:06'),
(5, 'تعبئة الاستمارة', NULL, 1, NULL, 'khald2002', NULL, NULL, '2021-02-04 11:07:40', '2021-02-04 11:07:40'),
(6, 'موافقة الخادم', NULL, 1, NULL, 'khald2002', NULL, NULL, '2021-02-04 11:08:38', '2021-02-04 11:08:38'),
(7, 'موافقة المدير', NULL, 1, NULL, 'khald2002', NULL, NULL, '2021-02-04 11:08:52', '2021-02-04 11:08:52'),
(9, 'إعادة ارسال الاستمارة', NULL, 1, 1, 'khald2002', NULL, NULL, '2021-02-04 11:08:52', '2021-02-04 11:08:52');

-- --------------------------------------------------------

--
-- Table structure for table `step_approvals`
--

CREATE TABLE `step_approvals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `activity_workflow_steps_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `owner_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` varchar(255) DEFAULT NULL,
  `modified_by` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `step_approvals`
--

INSERT INTO `step_approvals` (`id`, `created_at`, `updated_at`, `activity_workflow_steps_id`, `user_id`, `owner_id`, `status_id`, `is_enabled`, `created_by`, `modified_by`, `deleted_at`) VALUES
(5, '2021-03-24 13:18:50', '2021-03-24 13:18:50', 3, 3, 4, 3, 1, NULL, NULL, NULL),
(6, '2021-03-28 13:12:18', '2021-03-28 13:12:18', 3, 3, 2, 3, 1, NULL, NULL, NULL),
(7, '2021-03-28 13:20:20', '2021-03-28 13:20:20', 4, 3, 2, 3, 1, NULL, NULL, NULL),
(8, '2021-03-29 13:06:53', '2021-03-29 13:06:53', 4, 31, 4, 3, 1, NULL, NULL, NULL),
(9, '2021-03-29 13:08:09', '2021-03-29 13:08:09', 5, 32, 4, 3, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` varchar(255) DEFAULT NULL,
  `modified_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`id`, `name`, `deleted_at`, `is_enabled`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(8, '{\"en\": \"party\"}', NULL, 1, 'tester1', 'tester1', '2021-01-12 10:31:53', '2021-01-12 10:40:44'),
(9, '{\"en\": \"beneficiary\"}', NULL, 1, 'tester1', NULL, '2021-02-02 16:35:03', '2021-02-02 16:35:03'),
(10, 'testttttttttt', NULL, 1, 'khald2002', NULL, '2021-03-29 11:03:17', '2021-03-29 11:03:17');

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
  `created_by` varchar(255) DEFAULT NULL,
  `modified_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `type_infos`
--

INSERT INTO `type_infos` (`id`, `user_id`, `type_id`, `deleted_at`, `is_enabled`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(4, 1, 8, NULL, 1, NULL, 'tester1', '2021-01-12 12:57:22', '2021-01-12 13:09:10'),
(5, 2, 8, NULL, 1, 'tester1', NULL, '2021-01-19 10:01:54', '2021-01-19 10:01:54'),
(6, 3, 8, NULL, 1, 'tester1', NULL, '2021-01-19 10:38:45', '2021-01-19 10:38:45'),
(7, 4, 8, NULL, 1, 'khald2002', NULL, '2021-01-19 11:07:37', '2021-01-19 11:07:37'),
(9, 22, 9, NULL, 1, 'tester1', NULL, '2021-02-03 11:39:24', '2021-02-03 11:39:24'),
(28, 2, 9, NULL, 1, 'khald2002', NULL, '2021-02-04 15:53:06', '2021-02-04 15:53:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` text,
  `email` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `is_enabled` tinyint(1) DEFAULT '1',
  `created_by` varchar(255) DEFAULT NULL,
  `modified_by` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_name` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `email`, `email_verified_at`, `password`, `user_name`, `deleted_at`, `is_enabled`, `created_by`, `modified_by`, `remember_token`, `created_at`, `updated_at`, `last_name`) VALUES
(1, '{\"en\": \"tester\"}', 'hi@test.com', NULL, '$2y$10$hZwYoatPvjQzYMCod5NbFu9XCyEsGTa6ccJAi1JP7lp6bDIR6qMsS', 'tester1', NULL, 1, NULL, NULL, NULL, '2021-01-19 10:01:23', '2021-01-19 10:01:23', 'null'),
(2, '{\"en\": \"sami\"}', 'sami@gmail.com', NULL, '$2y$10$9YOd9uoupn7fAHRObw7wx.ZuckqpXI.77psxNEF3u2BL31IEDuMpa', 'sami2002', NULL, 1, 'tester1', NULL, NULL, '2021-01-19 10:01:54', '2021-01-19 10:01:54', 'null'),
(3, '{\"en\": \"khald\"}', 'khald@gmail.com', NULL, '$2y$10$Udl4ABpHpSVaA4uPZsigt.u4Dy0VVRb61y.qSIe.yocgrCFqPoxsK', 'khald2002', NULL, 1, 'tester1', NULL, NULL, '2021-01-19 10:38:45', '2021-01-19 10:38:45', 'null'),
(4, '{\"en\": \"soso\"}', 'soso@gmail.com', NULL, '$2y$10$ynA1g61LHYYSpwicKwZ.ZOJN8vM9EC7a7ZrO6JmdqHqeNda828tnC', 'soso2002', NULL, 1, 'khald2002', NULL, NULL, '2021-01-19 11:07:37', '2021-01-19 11:07:37', 'null'),
(5, '{\"en\": \"koko\"}', 'koko@user.com', NULL, '$2y$10$CLAykW0yza8GiJx4Ec94NeWACFT6xKZotwzMslV/ikUgCpq/SjGfW', 'koko34', NULL, 1, NULL, NULL, NULL, '2021-01-27 11:39:51', '2021-01-27 11:39:51', 'null'),
(22, '{\"en\": \"sausan\"}', 'sausan@gmail.com', NULL, '$2y$10$faXlW5S8aGtKqORylUHwFOGvdwVmoyLp53guictON/WMbedZ6q7ZS', 'sausan2002', NULL, 1, 'tester1', NULL, NULL, '2021-02-03 11:39:24', '2021-02-03 11:39:24', 'null'),
(24, '{\"ar\": \"ويوي\", \"en\": \"oioi\"}', 'oioi@user.com', NULL, '$2y$10$bZw0u7A5SBSt6DLL8TkHduxt1RfLuDlZyQuVliXrkk1j0O9LGqRYm', 'oioi34', NULL, 1, NULL, NULL, NULL, '2021-02-17 12:53:07', '2021-02-17 12:53:07', '{\"ar\": \"ويوي\", \"en\": \"oioi\"}'),
(25, NULL, NULL, NULL, '$2y$10$ePWlVjTudHNjzNSTFtj3yuJLVaKYH3Am6yNQZ54bavyyILdmoR0lO', 'ususus23', NULL, 1, NULL, NULL, NULL, '2021-02-18 17:53:19', '2021-02-18 17:53:19', NULL),
(26, '{\"ar\":\"fn_ar\",\"en\":\"fn\"}', 'test@test.com', NULL, '$2y$10$eS4tlr0UJOsDjeC00.hSa.dG02dvuwTpOZnxY3tTHyoASgC1w3p4q', 'test', NULL, 1, NULL, NULL, NULL, '2021-02-20 19:09:08', '2021-02-20 19:09:08', '{\"ar\":\"ln_ar\",\"en\":\"ln_en\"}'),
(27, NULL, NULL, NULL, '$2y$10$YI/WrGYxiFGa2xOdqSv.BOCy2E8KL1KTp.4BzDnntufw.4dU2NmYm', 'hamad', NULL, 1, NULL, NULL, NULL, '2021-02-22 15:36:30', '2021-02-22 15:36:30', NULL),
(28, NULL, NULL, NULL, '$2y$10$F/rmgquioLm6PraqT5CCzekzfufFkcsefHAqkGAWhZtoQc2q4zAeW', 'tester11', NULL, 1, NULL, NULL, NULL, '2021-03-18 09:22:38', '2021-03-18 09:22:38', NULL),
(29, NULL, NULL, NULL, '$2y$10$MpYZup7VvLceNEDrCpRJAO4PLj69pzMmLmz4Et5gpAu4gZkVyxmSa', 'hamed', NULL, 1, NULL, NULL, NULL, '2021-03-18 11:18:33', '2021-03-18 11:18:33', NULL),
(30, NULL, NULL, NULL, '$2y$10$/N2c.b6osXp2IvFPiRupVej.YIku7cqSWpHEFnOQ4aMShduQzrkk6', 'hameddd', NULL, 1, NULL, NULL, NULL, '2021-03-18 11:28:48', '2021-03-18 11:28:48', NULL),
(31, 'custodian', 'custodian@gmail.com', NULL, '$2y$10$ldUOv6XjN3yFQ8ukoj9yTOY2soA.Qh.Sz013mpFf9uVmpjK5ZLPQG', 'custodian', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(32, 'manager', 'manager@gmail.com', NULL, '$2y$10$ldUOv6XjN3yFQ8ukoj9yTOY2soA.Qh.Sz013mpFf9uVmpjK5ZLPQG', 'manager', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

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
  ADD UNIQUE KEY `activity_workflow_steps_order_num_unique` (`order_num`),
  ADD KEY `activity_workflow_steps_activity_id_foreign` (`activity_id`),
  ADD KEY `activity_workflow_steps_step_id_foreign` (`step_id`);

--
-- Indexes for table `beneficiary_infos`
--
ALTER TABLE `beneficiary_infos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `beneficiary_infos_type_infos_id_foreign` (`type_infos_id`),
  ADD KEY `beneficiary_infos_location_id_foreign` (`location_id`),
  ADD KEY `beneficiary_infos_special_needs_type_id_foreign` (`special_needs_type_id`) USING BTREE;

--
-- Indexes for table `beneficiary_location`
--
ALTER TABLE `beneficiary_location`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_lbl` (`location_type_id`,`beneficiary_id`,`location_id`),
  ADD KEY `beneficiary_location_beneficiary_id_foreign` (`beneficiary_id`),
  ADD KEY `beneficiary_location_location_id_foreign` (`location_id`);

--
-- Indexes for table `beneficiary_relations`
--
ALTER TABLE `beneficiary_relations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_r_b_s` (`relation_id`,`beneficiary_id`,`s_beneficiary_id`),
  ADD KEY `beneficiary_relations_beneficiary_id_foreign` (`beneficiary_id`),
  ADD KEY `beneficiary_relations_s_beneficiary_id_foreign` (`s_beneficiary_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `events_eventable_type_eventable_id_index` (`eventable_type`(191),`eventable_id`),
  ADD KEY `events_to_eventable_type_to_eventable_id_index` (`to_eventable_type`(191),`to_eventable_id`),
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
  ADD UNIQUE KEY `phones_phone_unique` (`number`),
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
  ADD KEY `step_approvals_activity_workflow_steps_id_foreign` (`activity_workflow_steps_id`),
  ADD KEY `step_approvals_user_id_foreign` (`user_id`),
  ADD KEY `step_approvals_owner_id_foreign` (`owner_id`),
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
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `activity_workflow_steps`
--
ALTER TABLE `activity_workflow_steps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `beneficiary_infos`
--
ALTER TABLE `beneficiary_infos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `beneficiary_location`
--
ALTER TABLE `beneficiary_location`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `beneficiary_relations`
--
ALTER TABLE `beneficiary_relations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `location_types`
--
ALTER TABLE `location_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sentences`
--
ALTER TABLE `sentences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `step_approvals`
--
ALTER TABLE `step_approvals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `type_infos`
--
ALTER TABLE `type_infos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_workflow_steps`
--
ALTER TABLE `activity_workflow_steps`
  ADD CONSTRAINT `activity_workflow_steps_activity_id_foreign` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `activity_workflow_steps_step_id_foreign` FOREIGN KEY (`step_id`) REFERENCES `steps` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `beneficiary_infos`
--
ALTER TABLE `beneficiary_infos`
  ADD CONSTRAINT `beneficiary_infos_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `beneficiary_infos_type_infos_id_foreign` FOREIGN KEY (`type_infos_id`) REFERENCES `type_infos` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `beneficiary_location`
--
ALTER TABLE `beneficiary_location`
  ADD CONSTRAINT `beneficiary_location_beneficiary_id_foreign` FOREIGN KEY (`beneficiary_id`) REFERENCES `beneficiary_infos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `beneficiary_location_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `beneficiary_location_location_type_id_foreign` FOREIGN KEY (`location_type_id`) REFERENCES `location_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `beneficiary_relations`
--
ALTER TABLE `beneficiary_relations`
  ADD CONSTRAINT `beneficiary_relations_beneficiary_id_foreign` FOREIGN KEY (`beneficiary_id`) REFERENCES `beneficiary_infos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `beneficiary_relations_relation_id_foreign` FOREIGN KEY (`relation_id`) REFERENCES `relations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `beneficiary_relations_s_beneficiary_id_foreign` FOREIGN KEY (`s_beneficiary_id`) REFERENCES `beneficiary_infos` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION;

--
-- Constraints for table `form_fields`
--
ALTER TABLE `form_fields`
  ADD CONSTRAINT `form_fields_field_id_foreign` FOREIGN KEY (`field_id`) REFERENCES `fields` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `form_fields_form_id_foreign` FOREIGN KEY (`form_id`) REFERENCES `forms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `form_fields_input_id_foreign` FOREIGN KEY (`input_id`) REFERENCES `inputs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `form_fields_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`);

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
  ADD CONSTRAINT `phones_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `beneficiary_infos` (`id`) ON DELETE CASCADE;

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
  ADD CONSTRAINT `step_approvals_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `step_approvals_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `step_approvals_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `type_infos`
--
ALTER TABLE `type_infos`
  ADD CONSTRAINT `type_infos_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `type_infos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
