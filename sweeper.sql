-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 29, 2021 at 07:34 AM
-- Server version: 8.0.27-0ubuntu0.20.04.1
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sweeper`
--

-- --------------------------------------------------------

--
-- Table structure for table `advertisement`
--

CREATE TABLE `advertisement` (
  `id` int NOT NULL,
  `title` varchar(250) NOT NULL,
  `description` text,
  `banner_image` varchar(250) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `start_at` timestamp NULL DEFAULT NULL,
  `end_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `advertisement`
--

INSERT INTO `advertisement` (`id`, `title`, `description`, `banner_image`, `status`, `start_at`, `end_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 'Ad 1', 'Banner Ads', '1633201433_banner_Clearance-sale-90.jpg', 0, '2021-10-02 18:30:00', '2021-10-08 18:30:00', '2021-10-02 13:24:49', '2021-10-02 14:00:16', NULL),
(4, 'Flipkart Ad', 'Banner Ads', '1633203277_banner_BBDTipSheet_mainbanner.jpg', 1, '2021-10-02 00:00:00', '2021-10-19 00:00:00', '2021-10-02 14:04:37', '2021-10-02 19:55:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int NOT NULL,
  `city_name` varchar(250) NOT NULL,
  `city_code` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `city_name`, `city_code`, `created_at`, `updated_at`, `deleted_at`) VALUES
(6, 'New York City', 'NY', '2021-11-03 18:09:40', '2021-11-03 18:09:40', NULL),
(7, 'Los Angeles', 'LA', '2021-11-03 18:10:06', '2021-11-03 18:10:06', NULL),
(8, 'Chicago', 'CH', '2021-11-03 18:10:19', '2021-11-03 18:10:19', NULL),
(9, 'Houston', 'HO', '2021-11-03 18:10:31', '2021-11-03 18:10:31', NULL),
(10, 'Phoenix', 'PH', '2021-11-03 18:10:42', '2021-11-03 18:10:42', NULL),
(11, 'Philadelphia', 'PHA', '2021-11-03 18:11:31', '2021-11-03 18:11:31', NULL),
(12, 'San Antonio', 'SA', '2021-11-03 18:11:45', '2021-11-03 18:11:45', NULL),
(13, 'San Diego', 'SD', '2021-11-03 18:11:59', '2021-11-03 18:11:59', NULL),
(14, 'Dallas', 'DA', '2021-11-03 18:12:33', '2021-11-03 18:12:33', NULL),
(15, 'Las Vegas', 'LV', '2021-11-03 18:13:10', '2021-11-03 18:13:10', NULL),
(16, 'Long Beach', 'LB', '2021-11-03 18:13:50', '2021-11-03 18:13:50', NULL),
(17, 'Jersey City', 'JC', '2021-11-03 18:14:30', '2021-11-03 18:14:30', NULL),
(18, 'Columbus', 'CO', '2021-11-03 18:15:39', '2021-11-03 18:15:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `driver_current_route`
--

CREATE TABLE `driver_current_route` (
  `id` int NOT NULL,
  `driver_id` int NOT NULL,
  `route_id` int NOT NULL,
  `route_name` varchar(250) NOT NULL,
  `route_coordinates` longtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `driver_current_route`
--

INSERT INTO `driver_current_route` (`id`, `driver_id`, `route_id`, `route_name`, `route_coordinates`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 141, 86, 'Test3', '[{\"lat\":26.8194464,\"lng\":75.6215641},{\"lat\":26.819478,\"lng\":75.6214255},{\"lat\":26.819613,\"lng\":75.6211795},{\"lat\":26.8195821,\"lng\":75.6209831}]', '2021-11-14 18:49:00', '2021-11-14 18:49:00', NULL),
(9, 146, 80, 'Test route', '[{\"lat\":26.8196512,\"lng\":75.6202761},{\"lat\":26.8196948,\"lng\":75.6201464},{\"lat\":26.8195806,\"lng\":75.6208484}]', '2021-11-25 17:50:31', '2021-11-25 17:50:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `driver_friends`
--

CREATE TABLE `driver_friends` (
  `id` int NOT NULL,
  `send_by` int NOT NULL,
  `send_to` int NOT NULL,
  `status` enum('accepted','rejected','requested','blocked') NOT NULL DEFAULT 'requested',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `driver_friends`
--

INSERT INTO `driver_friends` (`id`, `send_by`, `send_to`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(34, 142, 132, 'accepted', '2021-11-06 17:00:41', '2021-11-06 17:21:13', NULL),
(35, 132, 143, 'accepted', '2021-11-06 17:21:22', '2021-11-06 17:33:25', NULL),
(36, 147, 148, 'accepted', '2021-11-10 06:25:38', '2021-11-10 06:26:34', NULL),
(37, 155, 148, 'requested', '2021-11-13 17:00:52', '2021-11-13 17:00:52', NULL),
(38, 155, 147, 'requested', '2021-11-13 17:00:54', '2021-11-13 17:00:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `driver_routes`
--

CREATE TABLE `driver_routes` (
  `id` int NOT NULL,
  `driver_id` int NOT NULL,
  `route_name` varchar(250) NOT NULL,
  `route_desc` text,
  `route_time` varchar(250) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `route_coordinates` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `driver_routes`
--

INSERT INTO `driver_routes` (`id`, `driver_id`, `route_name`, `route_desc`, `route_time`, `status`, `route_coordinates`, `created_at`, `updated_at`, `deleted_at`) VALUES
(78, 142, 'vvvv', '', NULL, 0, '[{\"lat\":26.8196512,\"lng\":75.6202761},{\"lat\":26.8196948,\"lng\":75.6201464},{\"lat\":26.8195806,\"lng\":75.6208484}]', '2021-11-06 13:41:53', '2021-11-07 16:02:12', NULL),
(79, 132, 'Test route', '', NULL, 0, '[{\"lat\":26.8190291,\"lng\":75.6207997},{\"lat\":26.8190109,\"lng\":75.6206994}]', '2021-11-06 19:15:45', '2021-11-06 19:15:45', NULL),
(80, 146, 'Test route', '', NULL, 0, '[{\"lat\":27.3788124,\"lng\":75.9614918},{\"lat\":27.3787225,\"lng\":75.9614378}]', '2021-11-06 19:18:41', '2021-11-06 19:18:41', NULL),
(81, 147, 'failed route', '', NULL, 0, '[{\"lat\":28.6554265,\"lng\":77.4518234},{\"lat\":28.6553445,\"lng\":77.4518928},{\"lat\":28.6552686,\"lng\":77.4519499}]', '2021-11-07 07:52:47', '2021-11-07 07:52:47', NULL),
(82, 140, 'tesss', '', NULL, 0, '[{\"lat\":27.3788124,\"lng\":75.9614918},{\"lat\":27.3787225,\"lng\":75.9614378}]', '2021-11-07 12:40:01', '2021-11-07 12:40:01', NULL),
(83, 147, 'moving route', '', NULL, 0, '[{\"lat\":28.6552573,\"lng\":77.4520517},{\"lat\":28.6553157,\"lng\":77.4519429},{\"lat\":28.6554158,\"lng\":77.4518613},{\"lat\":28.6552774,\"lng\":77.4518719},{\"lat\":28.6551855,\"lng\":77.4519214},{\"lat\":28.6550978,\"lng\":77.4519704},{\"lat\":28.6549981,\"lng\":77.452009},{\"lat\":28.6549048,\"lng\":77.4520502},{\"lat\":28.6550609,\"lng\":77.4520344},{\"lat\":28.6550838,\"lng\":77.4519023},{\"lat\":28.6549492,\"lng\":77.4520049},{\"lat\":28.654948,\"lng\":77.4521247},{\"lat\":28.654837,\"lng\":77.4521049},{\"lat\":28.6547259,\"lng\":77.4520795},{\"lat\":28.6545699,\"lng\":77.4520691},{\"lat\":28.6544764,\"lng\":77.4521432},{\"lat\":28.6544153,\"lng\":77.4522381},{\"lat\":28.6543215,\"lng\":77.4522144},{\"lat\":28.6542309,\"lng\":77.45226},{\"lat\":28.6541074,\"lng\":77.4522182},{\"lat\":28.6540173,\"lng\":77.4521492},{\"lat\":28.6539296,\"lng\":77.4521086},{\"lat\":28.65385,\"lng\":77.4521674},{\"lat\":28.6538041,\"lng\":77.4522566},{\"lat\":28.6537511,\"lng\":77.4520812},{\"lat\":28.6536445,\"lng\":77.4520585},{\"lat\":28.6535719,\"lng\":77.4521354},{\"lat\":28.6534553,\"lng\":77.4521498},{\"lat\":28.6533632,\"lng\":77.4521431}]', '2021-11-07 14:29:54', '2021-11-07 14:29:54', NULL),
(84, 132, 'Test 1', '', NULL, 0, '[{\"lat\":26.8194464,\"lng\":75.6215641},{\"lat\":26.819478,\"lng\":75.6214255}]', '2021-11-07 15:35:56', '2021-11-07 15:35:56', NULL),
(85, 132, 'Test2', '', NULL, 0, '[{\"lat\":26.8194464,\"lng\":75.6215641},{\"lat\":26.819478,\"lng\":75.6214255},{\"lat\":26.819613,\"lng\":75.6211795}]', '2021-11-07 15:36:09', '2021-11-08 18:13:15', NULL),
(86, 144, 'Test3', '', NULL, 0, '[{\"lat\":26.8194464,\"lng\":75.6215641},{\"lat\":26.819478,\"lng\":75.6214255},{\"lat\":26.819613,\"lng\":75.6211795},{\"lat\":26.8195821,\"lng\":75.6209831}]', '2021-11-07 15:36:29', '2021-11-07 21:04:42', NULL),
(87, 143, 'balaji', '', NULL, 0, '[{\"lat\":26.8012575,\"lng\":75.8627034},{\"lat\":26.8011619,\"lng\":75.8627857},{\"lat\":26.8010907,\"lng\":75.8628716},{\"lat\":26.8009896,\"lng\":75.8629279},{\"lat\":26.8008867,\"lng\":75.8629037},{\"lat\":26.8007741,\"lng\":75.862915},{\"lat\":26.8006932,\"lng\":75.862999},{\"lat\":26.8007051,\"lng\":75.8631166},{\"lat\":26.8006976,\"lng\":75.8632445},{\"lat\":26.800639,\"lng\":75.8633521},{\"lat\":26.8005204,\"lng\":75.8633296},{\"lat\":26.8004167,\"lng\":75.86328},{\"lat\":26.8003219,\"lng\":75.8632359},{\"lat\":26.8003087,\"lng\":75.863108},{\"lat\":26.8003294,\"lng\":75.8629955},{\"lat\":26.8003491,\"lng\":75.8628884},{\"lat\":26.8003849,\"lng\":75.8627874},{\"lat\":26.8003987,\"lng\":75.862677},{\"lat\":26.8004134,\"lng\":75.8625707},{\"lat\":26.8004351,\"lng\":75.8624703},{\"lat\":26.8004635,\"lng\":75.8623511},{\"lat\":26.8004874,\"lng\":75.8622483},{\"lat\":26.8004036,\"lng\":75.8621799},{\"lat\":26.8003228,\"lng\":75.8621007},{\"lat\":26.8003457,\"lng\":75.8619799},{\"lat\":26.8003508,\"lng\":75.8618535},{\"lat\":26.8003588,\"lng\":75.8617237},{\"lat\":26.8003635,\"lng\":75.8616138},{\"lat\":26.8003505,\"lng\":75.8615086},{\"lat\":26.800357,\"lng\":75.8613885},{\"lat\":26.8003658,\"lng\":75.8612668},{\"lat\":26.8003582,\"lng\":75.8613696},{\"lat\":26.8003459,\"lng\":75.8614944},{\"lat\":26.8003457,\"lng\":75.861602},{\"lat\":26.800352,\"lng\":75.8617324},{\"lat\":26.8003472,\"lng\":75.8618661},{\"lat\":26.8003345,\"lng\":75.8619903},{\"lat\":26.8003291,\"lng\":75.8621129},{\"lat\":26.8004131,\"lng\":75.8621757},{\"lat\":26.8004397,\"lng\":75.8622931},{\"lat\":26.800415,\"lng\":75.86242},{\"lat\":26.8003725,\"lng\":75.8625289},{\"lat\":26.8003384,\"lng\":75.8626476},{\"lat\":26.8003399,\"lng\":75.8627485},{\"lat\":26.8003222,\"lng\":75.8628851},{\"lat\":26.8003169,\"lng\":75.8630132},{\"lat\":26.8003518,\"lng\":75.8631307},{\"lat\":26.800384,\"lng\":75.8632258},{\"lat\":26.8004945,\"lng\":75.8632173},{\"lat\":26.8005673,\"lng\":75.8631549},{\"lat\":26.8006294,\"lng\":75.8630394},{\"lat\":26.8006799,\"lng\":75.8629427},{\"lat\":26.8007052,\"lng\":75.862838},{\"lat\":26.8008,\"lng\":75.8628559},{\"lat\":26.8009067,\"lng\":75.8628304},{\"lat\":26.8010036,\"lng\":75.8627694},{\"lat\":26.8010949,\"lng\":75.86271},{\"lat\":26.801179,\"lng\":75.8626102},{\"lat\":26.8011918,\"lng\":75.8624841},{\"lat\":26.8010457,\"lng\":75.8626357},{\"lat\":26.8011774,\"lng\":75.8626447}]', '2021-11-07 16:36:31', '2021-11-08 15:57:56', NULL),
(88, 132, 'Driver route', '', NULL, 0, '[{\"lat\":26.8198438,\"lng\":75.6198179},{\"lat\":26.819878,\"lng\":75.6201686}]', '2021-11-08 18:30:49', '2021-11-08 18:30:49', NULL),
(89, 148, 'test route', '', NULL, 0, '[]', '2021-11-10 09:16:27', '2021-11-10 09:22:56', NULL),
(90, 149, 't', '', NULL, 0, '[]', '2021-11-10 18:09:50', '2021-11-10 18:09:50', NULL),
(91, 149, 'rr', '', NULL, 0, '[]', '2021-11-10 18:10:30', '2021-11-10 18:10:30', NULL),
(92, 150, 'x', '', NULL, 0, '[]', '2021-11-10 18:20:46', '2021-11-10 18:20:46', NULL),
(93, 150, '1', '', NULL, 0, '[]', '2021-11-13 16:17:47', '2021-11-13 16:17:47', NULL),
(94, 155, 'r', '', NULL, 0, '[]', '2021-11-13 16:55:23', '2021-11-13 16:55:23', NULL),
(95, 155, 'rrrr', '', NULL, 0, '[]', '2021-11-13 17:26:07', '2021-11-13 17:26:07', NULL),
(96, 151, 'h', '', NULL, 0, '[]', '2021-11-19 08:57:25', '2021-11-19 08:57:25', NULL),
(97, 151, 'mm tt', '', NULL, 0, '[]', '2021-11-19 09:00:27', '2021-11-19 09:00:27', NULL),
(98, 151, 'route 3', '', NULL, 0, '[]', '2021-11-19 09:03:08', '2021-11-19 09:03:08', NULL),
(99, 146, 'route', '', NULL, 0, '[]', '2021-11-25 17:06:51', '2021-11-25 17:06:51', NULL),
(100, 156, 'hhhjjj', '', NULL, 0, '[]', '2021-11-26 18:36:48', '2021-11-26 18:36:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mail_templates`
--

CREATE TABLE `mail_templates` (
  `id` int NOT NULL,
  `name` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_to` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_from` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `reply_email` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_type` enum('verification_mail','forget_password','login','register','changes') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mail_templates`
--

INSERT INTO `mail_templates` (`id`, `name`, `subject`, `mail_to`, `mail_from`, `reply_email`, `message`, `mail_type`, `created_at`, `updated_at`, `deleted_at`) VALUES
(7, 'Test', 'Verification OTP', 'user', 'admin@admim.com', 'admin@admim.com', 'OTP : {otp}', 'verification_mail', '2021-09-25 01:49:26', '2021-09-25 01:49:26', NULL),
(8, 'Test', 'Forgot OTP', 'user', 'admin@admin.com', 'admin@admin.com', 'OTP : {otp}', 'forget_password', '2021-09-25 02:12:28', '2021-09-25 02:12:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_resets_table', 1),
(2, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(3, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(4, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(5, '2016_06_01_000004_create_oauth_clients_table', 1),
(6, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(7, '2019_09_10_000000_create_permissions_table', 1),
(8, '2019_09_10_000001_create_roles_table', 1),
(9, '2019_09_10_000002_create_users_table', 1),
(10, '2019_09_10_000003_create_permission_role_pivot_table', 1),
(11, '2019_09_10_000004_create_role_user_pivot_table', 1),
(12, '2019_12_14_000001_create_personal_access_tokens_table', 2),
(13, '2021_09_18_212154_create_drivers_table', 3),
(14, '2021_09_18_213952_add_phone_to_users_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `title` varchar(250) NOT NULL,
  `description` text,
  `status` enum('new','seen') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'new',
  `type` varchar(250) NOT NULL,
  `extra` text,
  `date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `title`, `description`, `status`, `type`, `extra`, `date`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 144, 'Route is shared', 'Driver shared route with you!', 'new', 'route_shared', '{\"route_id\":86,\"shared_to_id\":144,\"shared_to_name\":\"test demo\",\"shared_to_profile_pic\":\"\",\"shared_by_id\":132,\"shared_by_name\":\"Driver\",\"shared_by_profile_pic\":\"http:\\/\\/15.206.93.215\\/sweeper\\/images\\/6186c4cc012db_132_userprofile.jpg\",\"route_name\":\"Test3\",\"shared_date\":\"2021-11-07 20:10:50\"}', NULL, '2021-11-07 20:10:50', '2021-11-07 20:10:50', NULL),
(3, 132, 'Route is accepted', 'Driver accepted your route!', 'new', 'route_shared', '{\"route_name\":\"Test3\",\"route_id\":\"86\",\"response_by_id\":144,\"response_by_name\":\"Driver\",\"response_by_profile_pic\":\"\",\"response\":\"accepted\",\"shared_date\":\"2021-11-07 20:10:50\"}', NULL, '2021-11-07 21:08:36', '2021-11-07 21:08:36', NULL),
(4, 143, 'Route is shared', 'Driver shared route with you!', 'new', 'route_shared', '{\"route_id\":\"87\",\"shared_to_id\":\"143\",\"shared_to_name\":\"Derek Driver\",\"shared_to_profile_pic\":\"http:\\/\\/15.206.93.215\\/sweeper\\/images\\/6186af8069bf0_143_userprofile.jpg\",\"shared_by_id\":132,\"shared_by_name\":\"Driver\",\"shared_by_profile_pic\":\"http:\\/\\/15.206.93.215\\/sweeper\\/images\\/6186c4cc012db_132_userprofile.jpg\",\"route_name\":\"balaji\",\"shared_date\":\"2021-11-08 15:54:58\"}', NULL, '2021-11-08 15:54:58', '2021-11-08 15:54:58', NULL),
(5, 132, 'Route is accepted', 'Derek Driver accepted your route!', 'new', 'route_shared', '{\"route_name\":\"balaji\",\"route_id\":\"87\",\"response_by_id\":143,\"response_by_name\":\"Derek Driver\",\"response_by_profile_pic\":\"http:\\/\\/15.206.93.215\\/sweeper\\/images\\/6186af8069bf0_143_userprofile.jpg\",\"response\":\"accepted\",\"shared_date\":\"2021-11-08 15:54:58\"}', NULL, '2021-11-08 15:57:56', '2021-11-08 15:57:56', NULL),
(6, 132, 'Route is shared', 'Jess Driver shared route with you!', 'new', 'route_shared', '{\"route_id\":\"85\",\"shared_to_id\":\"132\",\"shared_to_name\":\"Driver\",\"shared_to_profile_pic\":\"http:\\/\\/15.206.93.215\\/sweeper\\/images\\/6186c4cc012db_132_userprofile.jpg\",\"shared_by_id\":142,\"shared_by_name\":\"Jess Driver\",\"shared_by_profile_pic\":\"http:\\/\\/15.206.93.215\\/sweeper\\/images\\/6186b9028c0b3_142_userprofile.jpg\",\"route_name\":\"Test2\",\"shared_date\":\"2021-11-08 17:01:23\"}', NULL, '2021-11-08 17:01:23', '2021-11-08 17:01:23', NULL),
(7, 142, 'Route is accepted', 'Driver accepted your route!', 'new', 'route_shared', '{\"route_name\":\"Test2\",\"route_id\":\"85\",\"response_by_id\":132,\"response_by_name\":\"Driver\",\"response_by_profile_pic\":\"http:\\/\\/15.206.93.215\\/sweeper\\/images\\/6186c4cc012db_132_userprofile.jpg\",\"response\":\"accepted\",\"shared_date\":\"2021-11-08 17:01:23\"}', NULL, '2021-11-08 18:13:15', '2021-11-08 18:13:15', NULL),
(8, 142, 'Route is accepted', 'Driver accepted your route!', 'new', 'route_shared', '{\"route_name\":\"Test2\",\"route_id\":\"85\",\"response_by_id\":132,\"response_by_name\":\"Driver\",\"response_by_profile_pic\":\"http:\\/\\/15.206.93.215\\/sweeper\\/images\\/6186c4cc012db_132_userprofile.jpg\",\"response\":\"accepted\",\"shared_date\":\"2021-11-08 17:01:23\"}', NULL, '2021-11-08 18:14:13', '2021-11-08 18:14:13', NULL),
(9, 142, 'Route is accepted', 'Driver accepted your route!', 'new', 'route_shared', '{\"route_name\":\"Test2\",\"route_id\":\"85\",\"response_by_id\":132,\"response_by_name\":\"Driver\",\"response_by_profile_pic\":\"http:\\/\\/15.206.93.215\\/sweeper\\/images\\/6186c4cc012db_132_userprofile.jpg\",\"response\":\"accepted\",\"shared_date\":\"2021-11-08 17:01:23\"}', NULL, '2021-11-08 18:15:55', '2021-11-08 18:15:55', NULL),
(10, 142, 'Route is accepted', 'Driver accepted your route!', 'new', 'route_shared', '{\"route_name\":\"Test2\",\"route_id\":\"85\",\"response_by_id\":132,\"response_by_name\":\"Driver\",\"response_by_profile_pic\":\"http:\\/\\/15.206.93.215\\/sweeper\\/images\\/6186c4cc012db_132_userprofile.jpg\",\"response\":\"accepted\",\"shared_date\":\"2021-11-08 17:01:23\"}', NULL, '2021-11-08 18:17:05', '2021-11-08 18:17:05', NULL),
(11, 142, 'Route is accepted', 'Driver accepted your route!', 'new', 'route_shared', '{\"route_name\":\"Test2\",\"route_id\":\"85\",\"response_by_id\":132,\"response_by_name\":\"Driver\",\"response_by_profile_pic\":\"http:\\/\\/15.206.93.215\\/sweeper\\/images\\/6186c4cc012db_132_userprofile.jpg\",\"response\":\"accepted\",\"shared_date\":\"2021-11-08 17:01:23\"}', NULL, '2021-11-08 18:18:02', '2021-11-08 18:18:02', NULL),
(12, 142, 'Route is accepted', 'Driver accepted your route!', 'new', 'route_shared', '{\"route_name\":\"Test2\",\"route_id\":\"85\",\"response_by_id\":132,\"response_by_name\":\"Driver\",\"response_by_profile_pic\":\"http:\\/\\/15.206.93.215\\/sweeper\\/images\\/6186c4cc012db_132_userprofile.jpg\",\"response\":\"accepted\",\"shared_date\":\"2021-11-08 17:01:23\"}', NULL, '2021-11-08 18:18:54', '2021-11-08 18:18:54', NULL),
(13, 142, 'Route is accepted', 'Driver accepted your route!', 'new', 'route_shared', '{\"route_name\":\"Test2\",\"route_id\":\"85\",\"response_by_id\":132,\"response_by_name\":\"Driver\",\"response_by_profile_pic\":\"http:\\/\\/15.206.93.215\\/sweeper\\/images\\/6186c4cc012db_132_userprofile.jpg\",\"response\":\"accepted\",\"shared_date\":\"2021-11-08 17:01:23\"}', NULL, '2021-11-08 18:19:40', '2021-11-08 18:19:40', NULL),
(14, 142, 'Route is accepted', 'Driver accepted your route!', 'new', 'route_shared', '{\"route_name\":\"Test2\",\"route_id\":\"85\",\"response_by_id\":132,\"response_by_name\":\"Driver\",\"response_by_profile_pic\":\"http:\\/\\/15.206.93.215\\/sweeper\\/images\\/6186c4cc012db_132_userprofile.jpg\",\"response\":\"accepted\",\"shared_date\":\"2021-11-08 17:01:23\"}', NULL, '2021-11-08 18:21:38', '2021-11-08 18:21:38', NULL),
(15, 142, 'Route is accepted', 'Driver accepted your route!', 'new', 'route_shared', '{\"route_name\":\"Test2\",\"route_id\":\"85\",\"response_by_id\":132,\"response_by_name\":\"Driver\",\"response_by_profile_pic\":\"http:\\/\\/15.206.93.215\\/sweeper\\/images\\/6186c4cc012db_132_userprofile.jpg\",\"response\":\"accepted\",\"shared_date\":\"2021-11-08 17:01:23\"}', NULL, '2021-11-08 18:22:04', '2021-11-08 18:22:04', NULL),
(16, 132, 'Route is accepted', 'Derek Driver accepted your route!', 'new', 'route_shared', '{\"route_name\":\"balaji\",\"route_id\":\"87\",\"response_by_id\":143,\"response_by_name\":\"Derek Driver\",\"response_by_profile_pic\":\"http:\\/\\/15.206.93.215\\/sweeper\\/images\\/6186af8069bf0_143_userprofile.jpg\",\"response\":\"accepted\",\"shared_date\":\"2021-11-08 15:54:58\"}', NULL, '2021-11-08 18:26:00', '2021-11-08 18:26:00', NULL),
(17, 148, 'Route is shared', 'sam watson shared route with you!', 'new', 'route_shared', '{\"route_id\":\"89\",\"shared_to_id\":\"148\",\"shared_to_name\":\"gimmy\",\"shared_to_profile_pic\":\"http:\\/\\/15.206.93.215\\/sweeper\\/images\\/618b6531d19b1_148_userprofile.jpg\",\"shared_by_id\":147,\"shared_by_name\":\"sam watson\",\"shared_by_profile_pic\":\"http:\\/\\/15.206.93.215\\/sweeper\\/images\\/6187855127056_147_userprofile.jpg\",\"route_name\":\"test route\",\"shared_date\":\"2021-11-10 09:21:32\"}', NULL, '2021-11-10 09:21:32', '2021-11-10 09:21:32', NULL),
(18, 147, 'Route is accepted', 'gimmy accepted your route!', 'new', 'route_shared', '{\"route_name\":\"test route\",\"route_id\":\"89\",\"response_by_id\":148,\"response_by_name\":\"gimmy\",\"response_by_profile_pic\":\"http:\\/\\/15.206.93.215\\/sweeper\\/images\\/618b6531d19b1_148_userprofile.jpg\",\"response\":\"accepted\",\"shared_date\":\"2021-11-10 09:21:32\"}', NULL, '2021-11-10 09:22:56', '2021-11-10 09:22:56', NULL),
(19, 147, 'Route is accepted', 'gimmy accepted your route!', 'new', 'route_shared', '{\"route_name\":\"test route\",\"route_id\":\"89\",\"response_by_id\":148,\"response_by_name\":\"gimmy\",\"response_by_profile_pic\":\"http:\\/\\/15.206.93.215\\/sweeper\\/images\\/618b6531d19b1_148_userprofile.jpg\",\"response\":\"accepted\",\"shared_date\":\"2021-11-10 09:21:32\"}', NULL, '2021-11-10 09:22:58', '2021-11-10 09:22:58', NULL),
(20, 147, 'Route is rejected', 'gimmy rejected your route!', 'new', 'route_shared', '{\"route_id\":\"89\",\"response_by_id\":148,\"response_by_name\":\"gimmy\",\"response_by_profile_pic\":\"http:\\/\\/15.206.93.215\\/sweeper\\/images\\/618b6531d19b1_148_userprofile.jpg\",\"response\":\"rejected\",\"shared_date\":\"2021-11-10 09:21:32\"}', NULL, '2021-11-10 09:23:00', '2021-11-10 09:23:00', NULL),
(21, 147, 'Route is accepted', 'gimmy accepted your route!', 'new', 'route_shared', '{\"route_name\":\"test route\",\"route_id\":\"89\",\"response_by_id\":148,\"response_by_name\":\"gimmy\",\"response_by_profile_pic\":\"http:\\/\\/15.206.93.215\\/sweeper\\/images\\/618b6531d19b1_148_userprofile.jpg\",\"response\":\"accepted\",\"shared_date\":\"2021-11-10 09:21:32\"}', NULL, '2021-11-10 09:23:03', '2021-11-10 09:23:03', NULL),
(22, 144, 'Route is shared', 'Driver shared route with you!', 'new', 'route_shared', '{\"route_id\":86,\"shared_to_id\":144,\"shared_to_name\":\"test demo\",\"shared_to_profile_pic\":\"\",\"shared_by_id\":132,\"shared_by_name\":\"Driver\",\"shared_by_profile_pic\":\"http:\\/\\/15.206.93.215\\/sweeper\\/images\\/6186c4cc012db_132_userprofile.jpg\",\"route_name\":\"Test3\",\"shared_date\":\"2021-11-19 20:17:17\"}', NULL, '2021-11-19 20:17:17', '2021-11-19 20:17:17', NULL),
(24, 144, 'Route is shared', 'Rohan Kumar shared route with you!', 'new', 'route_shared', '{\"route_id\":86,\"shared_to_id\":144,\"shared_to_name\":\"Karan\",\"shared_to_profile_pic\":\"\",\"shared_by_id\":132,\"shared_by_name\":\"Rohan Kumar\",\"shared_by_profile_pic\":\"http:\\/\\/15.206.93.215\\/sweeper\\/images\\/6186c4cc012db_132_userprofile.jpg\",\"route_name\":\"Test3\",\"shared_date\":\"2021-11-19 20:30:18\"}', '2021-11-25 02:14:24', '2021-11-19 20:30:18', '2021-11-19 20:30:18', NULL),
(25, 142, 'Route is accepted', 'Driver Buddy accepted your route!', 'new', 'route_shared', '{\"route_name\":\"Test2\",\"route_id\":\"85\",\"response_by_id\":132,\"response_by_name\":\"Driver Buddy\",\"response_by_profile_pic\":\"http:\\/\\/15.206.93.215\\/sweeper\\/images\\/619d0909d7f33_132_userprofile.jpg\",\"response\":\"accepted\",\"shared_date\":\"2021-11-08 17:01:23\"}', '2021-11-25 19:39:16', '2021-11-25 19:39:16', '2021-11-25 19:39:16', NULL),
(26, 142, 'Route is accepted', 'Driver Buddy accepted your route!', 'new', 'route_shared', '{\"route_name\":\"Test2\",\"route_id\":\"85\",\"response_by_id\":132,\"response_by_name\":\"Driver Buddy\",\"response_by_profile_pic\":\"http:\\/\\/15.206.93.215\\/sweeper\\/images\\/619d0909d7f33_132_userprofile.jpg\",\"response\":\"accepted\",\"shared_date\":\"2021-11-08 17:01:23\"}', '2021-11-25 19:39:18', '2021-11-25 19:39:18', '2021-11-25 19:39:18', NULL),
(27, 143, 'Route is shared', 'Driver Buddy shared route with you!', 'new', 'route_shared', '{\"route_id\":\"88\",\"shared_to_id\":\"143\",\"shared_to_name\":\"Derek Driver\",\"shared_to_profile_pic\":\"http:\\/\\/15.206.93.215\\/sweeper\\/images\\/6186af8069bf0_143_userprofile.jpg\",\"shared_by_id\":132,\"shared_by_name\":\"Driver Buddy\",\"shared_by_profile_pic\":\"http:\\/\\/15.206.93.215\\/sweeper\\/images\\/619d0909d7f33_132_userprofile.jpg\",\"route_name\":\"Driver route\",\"shared_date\":\"2021-11-25 19:40:39\"}', '2021-11-30 00:00:00', '2021-11-25 19:40:39', '2021-11-25 19:40:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('005af749f70825f77ce9874143962354993af64e1afc2dc4b3b0005cac6d8ddd577a2df7236be074', 109, 1, '109-2021-11-01 05:57:35', '[]', 0, '2021-11-01 05:57:35', '2021-11-01 05:57:35', '2022-11-01 05:57:35'),
('005e75df7141bf38cabf8969841d06e1bc0b5c415370495764281e7817682182a2083307e4b58c5a', 14, 1, '14-2021-09-24 05:11:21', '[]', 0, '2021-09-24 05:11:21', '2021-09-24 05:11:21', '2022-09-24 05:11:21'),
('00d63e4ebeb5621c8de8b39f72f9695e33236bddc8152db393cc39e9aa2af8e62b3e1cab53abd1f4', 65, 1, '65-2021-09-28 18:49:13', '[]', 0, '2021-09-28 18:49:13', '2021-09-28 18:49:13', '2022-09-28 18:49:13'),
('0142738347e8b220828672ce849f29fa57baeba1c5ea1e7ae3a19a155a0aa167faf4817c3ceb46c4', 112, 1, '112-2021-10-22 05:33:17', '[]', 0, '2021-10-22 05:33:17', '2021-10-22 05:33:17', '2022-10-22 05:33:17'),
('020cdb758c6ab679860629fc98dd1994d4fcef8998d81f615e30bc239469ee31636cbadee4406f91', 164, 1, '164-2021-11-26 19:13:10', '[]', 0, '2021-11-26 19:13:10', '2021-11-26 19:13:10', '2022-11-26 19:13:10'),
('04601da8eed70c90c0c003e0b2e726ebecbdc926550cc08adb3f773c6cb54d2098a160a5a5bbb44f', 149, 1, '149-2021-11-13 16:22:56', '[]', 0, '2021-11-13 16:22:56', '2021-11-13 16:22:56', '2022-11-13 16:22:56'),
('04d5aee3b8c5608abbfd51c4d6204ea1e5fd30842c3a1bd8d8992a075f3d2a6a7ca4844736f6f77c', 9, 1, '91632418439', '[]', 0, '2021-09-23 17:33:59', '2021-09-23 17:33:59', '2022-09-23 17:33:59'),
('04f2c09e2f969a46a661bdca168e207e2da08a1fc2efa94267ae56ea690ca6a0141fff5222bca6b7', 126, 1, '126-2021-10-30 17:13:42', '[]', 0, '2021-10-30 17:13:42', '2021-10-30 17:13:42', '2022-10-30 17:13:42'),
('068e3f87d9cb7b8d19983188a3b7cd433049fb0b87cb34d66b31005e8d11efbf3e9e049c4573545c', 15, 1, '15-2021-09-24 16:45:39', '[]', 0, '2021-09-24 16:45:39', '2021-09-24 16:45:39', '2022-09-24 16:45:39'),
('070dacadbcac87b9adba7cf777824654aba50210c2cb5d04bffe9cf8a00793ed2a944fd304cf47a4', 70, 1, '70-2021-09-29 05:49:11', '[]', 0, '2021-09-29 05:49:11', '2021-09-29 05:49:11', '2022-09-29 05:49:11'),
('07dcc21944c34e50ec2c6e9d13d46f9c0146ca985c743738f33ba74b6cfa648b2d49030d890a1fe3', 54, 1, '54-2021-09-27 18:41:54', '[]', 0, '2021-09-27 18:41:54', '2021-09-27 18:41:54', '2022-09-27 18:41:54'),
('0802de6a7f66bd5508b4cc759ecfa3a4f9ac2b50e570b0c1bc62a1e56e91dee4d1697f97a1ac24d9', 65, 1, '65-2021-09-28 18:49:48', '[]', 0, '2021-09-28 18:49:48', '2021-09-28 18:49:48', '2022-09-28 18:49:48'),
('0803474fc0b0791712d82a9d8993029e65c277aba8d8727c1aa12f8d8f173f003e0f3458b98149df', 64, 1, '64-2021-09-28 19:49:43', '[]', 0, '2021-09-28 19:49:43', '2021-09-28 19:49:43', '2022-09-28 19:49:43'),
('080438604afe87cabfaf528ca81b4f9aa48512bf9ca3e64598b3576aee335b89a2d799a2ce87821b', 64, 1, '64-2021-09-28 19:49:45', '[]', 0, '2021-09-28 19:49:45', '2021-09-28 19:49:45', '2022-09-28 19:49:45'),
('085d0149cf50e7572a4434fda2e802d0b95a7c4a4bec8189943bc54675b7b91eb4711f051970a405', 118, 1, '118-2021-10-23 15:52:43', '[]', 0, '2021-10-23 15:52:43', '2021-10-23 15:52:43', '2022-10-23 15:52:43'),
('0c0be1fbb6b014956ef178eee42786b4141aa81d0e5eba9604ae671c03604fbd0bb60932fab98f82', 102, 1, '102-2021-10-26 18:43:51', '[]', 0, '2021-10-26 18:43:51', '2021-10-26 18:43:51', '2022-10-26 18:43:51'),
('0e74c44c6d97ab55f20074dd69f583fb6126c574777c4d6a12939d94034f6a50bc6900cad1618976', 151, 1, '151-2021-11-13 06:10:22', '[]', 0, '2021-11-13 06:10:22', '2021-11-13 06:10:22', '2022-11-13 06:10:22'),
('1015f198a1dcf2257e560905d8737815de2a5bbb3a7e02227dbbddec227a28e1a4d7ee481ed87755', 54, 1, '54-2021-09-27 18:46:13', '[]', 0, '2021-09-27 18:46:13', '2021-09-27 18:46:13', '2022-09-27 18:46:13'),
('103d79f9ef7f2b204ef112c59966689c20ffc00d74e3b918769245bced8fd3599a4507aa659d9098', 158, 1, '158-2021-11-26 05:14:21', '[]', 0, '2021-11-26 05:14:21', '2021-11-26 05:14:21', '2022-11-26 05:14:21'),
('166b3ce924e867663a5422c335d15b5ed3916b6df8b378f5abf9c35617b4152bf5d74c0778eea9f5', 147, 1, '147-2021-11-09 17:56:37', '[]', 0, '2021-11-09 17:56:37', '2021-11-09 17:56:37', '2022-11-09 17:56:37'),
('169417ad4de698dbe54538ab0278299b3ee522c15dc76cf2fd9deb6c3be9de763f67471a1aba5f2d', 102, 1, '102-2021-10-22 19:33:16', '[]', 0, '2021-10-22 19:33:16', '2021-10-22 19:33:16', '2022-10-22 19:33:16'),
('1903d80a8665b587115e2f7cd5b9eb91077d5c734b7d373826f2a5c787a453f2ed7c3fb0da5b92bf', 26, 1, '26-2021-09-25 19:54:25', '[]', 0, '2021-09-25 19:54:25', '2021-09-25 19:54:25', '2022-09-25 19:54:25'),
('199a93184069f176b6fb3cfa5e2f2f76985fc7b6cc9a0c3b4eded55c66c2129153073cb1ffd1fd77', 54, 1, '54-2021-09-27 18:40:15', '[]', 0, '2021-09-27 18:40:15', '2021-09-27 18:40:15', '2022-09-27 18:40:15'),
('19ed675988b4b009acecf733a902636d2aa80aa3d5fc5327615141c261d1d88252d8839ab622afcb', 26, 1, '26-2021-09-25 18:23:45', '[]', 0, '2021-09-25 18:23:45', '2021-09-25 18:23:45', '2022-09-25 18:23:45'),
('1ab5215f2c4681c868218fbb8a2fafa5859e8fd3efa0ef01aa26cec42a6b2b086ab49e87780d64cb', 96, 1, '96-2021-09-29 19:01:58', '[]', 0, '2021-09-29 19:01:58', '2021-09-29 19:01:58', '2022-09-29 19:01:58'),
('1b2ffc64d8582fe45feffdda9677d5f457199b8c3db4e505b5ed0a6ee68658e22e6b9134471e2ceb', 54, 1, '54-2021-09-27 18:54:32', '[]', 0, '2021-09-27 18:54:32', '2021-09-27 18:54:32', '2022-09-27 18:54:32'),
('1c7313453b6c180548dc03165d83496fd5b0ce3943f0d1e6861f558ec1e697d19e39cc1e9db5245a', 51, 1, '51-2021-09-27 14:37:51', '[]', 0, '2021-09-27 14:37:51', '2021-09-27 14:37:51', '2022-09-27 14:37:51'),
('1e88dc2f3ef7b9d62d681fae1e434a26414f3b636ff7a48abf7924872ee13198a9b143aec135a0ac', 31, 1, '31-2021-09-26 03:30:35', '[]', 0, '2021-09-26 03:30:35', '2021-09-26 03:30:35', '2022-09-26 03:30:35'),
('1f32bb98beaa727ccc952ba5fd526d196c476760e52b589cc5edb0f61ca98ab78a315b8dad855da1', 64, 1, '64-2021-09-28 19:42:27', '[]', 0, '2021-09-28 19:42:27', '2021-09-28 19:42:27', '2022-09-28 19:42:27'),
('209264320a745e892e725cd0fc11f3bd3de021776e203d68bb00ced325844a2085f7d03a1a809fa7', 15, 1, '15-2021-09-24 17:43:49', '[]', 0, '2021-09-24 17:43:49', '2021-09-24 17:43:49', '2022-09-24 17:43:49'),
('218069b52905c1398a8c7f5050d3af94c34fc9e4ba9d6f0b3cef74e35f6465f65697334f4857f7db', 102, 1, '102-2021-10-18 15:13:56', '[]', 0, '2021-10-18 15:13:56', '2021-10-18 15:13:56', '2022-10-18 15:13:56'),
('236ce1979a4346d8d4abb2bba81d140d4a1c7fac6ef223fc8c506eee3a4bda2a089451e79e2e01c2', 54, 1, '54-2021-09-27 18:36:54', '[]', 0, '2021-09-27 18:36:54', '2021-09-27 18:36:54', '2022-09-27 18:36:54'),
('23997496097c0dd4b2c59bdcf7f15002586b071a8751ccd4d82f97f7a3d171778393859f45c5ffdb', 54, 1, '54-2021-09-27 18:41:44', '[]', 0, '2021-09-27 18:41:44', '2021-09-27 18:41:44', '2022-09-27 18:41:44'),
('25980d0788c2761ef5f599f69107a6f9dafe523cdb07588e2604aa27e7ac8ca7a9b61360e81c3777', 54, 1, '54-2021-09-27 18:40:44', '[]', 0, '2021-09-27 18:40:44', '2021-09-27 18:40:44', '2022-09-27 18:40:44'),
('297c3a97ba19021215d54a85490b884f2fee9266b5272f1d6f200f50d2e6f87370a2699c1fbdfce7', 43, 1, '43-2021-09-27 07:04:00', '[]', 0, '2021-09-27 07:04:00', '2021-09-27 07:04:00', '2022-09-27 07:04:00'),
('2a25afad3ca5d546494ada7707af1727076f7bef0780d207ee390cf80d3449689554a63a4912b0f1', 66, 1, '66-2021-09-28 19:19:18', '[]', 0, '2021-09-28 19:19:18', '2021-09-28 19:19:18', '2022-09-28 19:19:18'),
('2aa65d40d91dd1c51ddcea8648747e913db799c26ab3cdc448ca126749feae0ac02e6e0f37bde0ed', 99, 1, '99-2021-09-29 19:28:29', '[]', 0, '2021-09-29 19:28:29', '2021-09-29 19:28:29', '2022-09-29 19:28:29'),
('2ae2174fa7d110fac311d8b9672ca62a036c1577f10169749a04950fe4f747da8a637e87337289da', 57, 1, '57-2021-09-29 18:01:28', '[]', 0, '2021-09-29 18:01:28', '2021-09-29 18:01:28', '2022-09-29 18:01:28'),
('2bfa78b306a6e5ca870318130583b6139acb48bd2510b4af0c370c91cfc3fcc2703c76a503a6f1fb', 54, 1, '54-2021-09-27 18:55:46', '[]', 0, '2021-09-27 18:55:46', '2021-09-27 18:55:46', '2022-09-27 18:55:46'),
('2c3b402bb599dfe2ef614913da1342529a3b2552ef12d0a1a1897ead1f834a1b0b3b0394d2c58ae1', 32, 1, '32-2021-09-26 03:34:06', '[]', 0, '2021-09-26 03:34:06', '2021-09-26 03:34:06', '2022-09-26 03:34:06'),
('2d5e45400014565802dace642256ed1a82ab362f46a90583b743cad360fb13202be600274114f59d', 12, 1, '12-2021-09-23 19:37:58', '[]', 0, '2021-09-23 19:37:58', '2021-09-23 19:37:58', '2022-09-23 19:37:58'),
('2f5e8097ea578f9936a318dd84e0f6acaa42c6f1a9afc9caed3b776ca0c3a16fe99c2dca5414e8ef', 144, 1, '144-2021-11-19 20:18:52', '[]', 0, '2021-11-19 20:18:52', '2021-11-19 20:18:52', '2022-11-19 20:18:52'),
('30e8c06c65ae80c22ff8b557cc44245eeb0d943d58c207b8f67bbbe90deeafeae5d099c6cf75800e', 97, 1, '97-2021-09-29 19:00:59', '[]', 0, '2021-09-29 19:00:59', '2021-09-29 19:00:59', '2022-09-29 19:00:59'),
('31db65dda6d6261db90902c0ee39674dd3a3e1224de3910af7dd27bc910a4eec99dc256295b5bd72', 38, 1, '38-2021-09-26 17:22:47', '[]', 0, '2021-09-26 17:22:47', '2021-09-26 17:22:47', '2022-09-26 17:22:47'),
('32f0ab3628648ff400299b9cbe76453aae09bdfde5c088c09990e08f526667ef643a741f6d4bea05', 96, 1, '96-2021-10-22 19:06:19', '[]', 0, '2021-10-22 19:06:19', '2021-10-22 19:06:19', '2022-10-22 19:06:19'),
('331a1269c97b87305f3ddd44687b52e86b24a9276558cd9cf2c7f37c7ec3818e28e93b744e9773e9', 73, 1, '73-2021-09-29 06:04:23', '[]', 0, '2021-09-29 06:04:23', '2021-09-29 06:04:23', '2022-09-29 06:04:23'),
('346e267fffde756c43712cbc987f4605a18480dd413e5467a2f86d2ef604affa3bcb40c90aebcb7b', 158, 1, '158-2021-11-26 05:15:09', '[]', 0, '2021-11-26 05:15:09', '2021-11-26 05:15:09', '2022-11-26 05:15:09'),
('34bb1d5c5f01be122bb79f690c424c1d718cf373b324cdc88ab443d69472d15f924cf5fed67206c5', 98, 1, '98-2021-09-29 19:03:24', '[]', 0, '2021-09-29 19:03:24', '2021-09-29 19:03:24', '2022-09-29 19:03:24'),
('3548fa7a4f5dedf067b0b65b6b78ba393c969232a8530a34ae80ed80ec86ccfc206eb411f88f9b5b', 7, 1, '71632418404', '[]', 0, '2021-09-23 17:33:24', '2021-09-23 17:33:24', '2022-09-23 17:33:24'),
('36695dd83266238a12f94acb5df0675a208a70d617393332f4abd0511d7aa5b758968da79ef68992', 130, 1, '130-2021-11-01 07:42:53', '[]', 0, '2021-11-01 07:42:53', '2021-11-01 07:42:53', '2022-11-01 07:42:53'),
('36c97a75c6581bfc61cc28abeb84a7ec30082a62b807c4c5b59fab1a8a5086a8533fb29c6f1aa27c', 24, 1, '24-2021-09-25 15:41:39', '[]', 0, '2021-09-25 15:41:39', '2021-09-25 15:41:39', '2022-09-25 15:41:39'),
('3ac57798f20515a44733119dd1c8205c0807b38fe9a16d3c860874389da276bfdf66f6c39d91e07c', 62, 1, '62-2021-09-28 17:53:22', '[]', 0, '2021-09-28 17:53:22', '2021-09-28 17:53:22', '2022-09-28 17:53:22'),
('3b602bdb1b32995115f16b2224ab00ca3cd9d9fd5bb35219eddb9fb1b52a10fa7f3e76971cd3639d', 96, 1, '96-2021-09-29 18:39:20', '[]', 0, '2021-09-29 18:39:20', '2021-09-29 18:39:20', '2022-09-29 18:39:20'),
('3ba6710817bd63813e98ecc57ef9194458a9ef95b4d5a8992ede53b37a0216713dfbfbeb6a0fd96c', 94, 1, '94-2021-09-29 18:28:50', '[]', 0, '2021-09-29 18:28:50', '2021-09-29 18:28:50', '2022-09-29 18:28:50'),
('3dabc4a64b18c53d5070b392d5449542c7780b4b1d9dce1fe6a096b070f1dd53404a882432988b1e', 79, 1, '79-2021-09-29 06:28:05', '[]', 0, '2021-09-29 06:28:05', '2021-09-29 06:28:05', '2022-09-29 06:28:05'),
('3e570a068a1ea4c05418d0c2f57c508d770063e8ef0b0f5fb5b0440aac7393d243444694a0d6e6dc', 24, 1, '24-2021-09-25 15:43:57', '[]', 0, '2021-09-25 15:43:57', '2021-09-25 15:43:57', '2022-09-25 15:43:57'),
('3e6aacb0d08fb4506eb3933a389821dfd2d4ec2f6fff6cc89e8b0d6be152b5c908f911b5a9ee0805', 148, 1, '148-2021-11-10 06:20:42', '[]', 0, '2021-11-10 06:20:42', '2021-11-10 06:20:42', '2022-11-10 06:20:42'),
('4239155d73078a8e9f1eb3e61775b7feb4062c3f32cb2af0b7ccb91b86b2e98d20bd5b0a39ccea28', 72, 1, '72-2021-09-29 05:57:53', '[]', 0, '2021-09-29 05:57:53', '2021-09-29 05:57:53', '2022-09-29 05:57:53'),
('425e35d9f70a0f294b4c41cadbbca650fb541912f3a72f65bf826d072c34b360b8256a1f863dda40', 158, 1, '158-2021-11-26 05:14:31', '[]', 0, '2021-11-26 05:14:31', '2021-11-26 05:14:31', '2022-11-26 05:14:31'),
('430566ab6e9ec20912a1b6603b3d7d33315ed6a48e0619d3fb64baba3024f94b2151282181cb5ac8', 105, 1, '105-2021-10-12 15:06:48', '[]', 0, '2021-10-12 15:06:48', '2021-10-12 15:06:48', '2022-10-12 15:06:48'),
('4557a5b724d739bedd6c0aafb63c73922871a09de497768de673575e1f74c4326de55e2973553bf5', 68, 1, '68-2021-09-29 05:41:09', '[]', 0, '2021-09-29 05:41:09', '2021-09-29 05:41:09', '2022-09-29 05:41:09'),
('4838d62c60f230eb0e9ffb321468d2ce4a56b14a5250c11fa46d93b6753a783e38cbc29f9f8a6a2f', 127, 1, '127-2021-11-01 19:21:40', '[]', 0, '2021-11-01 19:21:40', '2021-11-01 19:21:40', '2022-11-01 19:21:40'),
('487395f3bf09e77486ea9f7756dea58d8c6348747063d6da972694c694f744197e067809813fbc7c', 50, 1, '50-2021-09-27 14:30:45', '[]', 0, '2021-09-27 14:30:45', '2021-09-27 14:30:45', '2022-09-27 14:30:45'),
('48a5817fff25b65c7081be644f22e949ad9e1c05414b2f47693d5768ea2109d24dea77cfcef04650', 1, 1, '1-2021-09-25 19:07:35', '[]', 0, '2021-09-25 19:07:35', '2021-09-25 19:07:35', '2022-09-25 19:07:35'),
('48cdd0d86d41d4d36b6949675f74cebbd4d3bf98b2f32d0d9103733fdfb21774cd3dc252d27245ec', 109, 1, '109-2021-10-20 10:00:14', '[]', 0, '2021-10-20 10:00:14', '2021-10-20 10:00:14', '2022-10-20 10:00:14'),
('48ff52d808f8017ce4f110e16fdb77085b25c5a84d50626011e91649f500afb8d6bafd8891ff8239', 96, 1, '96-2021-09-29 18:42:01', '[]', 0, '2021-09-29 18:42:01', '2021-09-29 18:42:01', '2022-09-29 18:42:01'),
('4b25d6c36c7d4d3891f0036b596c43c746d80c76139bd12dcf29e2b1920178f359da25d1e330c100', 96, 1, '96-2021-10-22 18:58:42', '[]', 0, '2021-10-22 18:58:42', '2021-10-22 18:58:42', '2022-10-22 18:58:42'),
('4b9ea876bb1143b9109311ae7e417dd56faba14ff7f9159690cb62a8870cbfbdc6f6bcd7249cf7a8', 96, 1, '96-2021-10-22 19:08:09', '[]', 0, '2021-10-22 19:08:09', '2021-10-22 19:08:09', '2022-10-22 19:08:09'),
('4bb82aca210466582b2f6017b72719e818dab942cab455164d7f128c3b283962c3ec5415390b10e0', 98, 1, '98-2021-09-29 19:05:19', '[]', 0, '2021-09-29 19:05:19', '2021-09-29 19:05:19', '2022-09-29 19:05:19'),
('4cefef4a8d07613198282dcac2c5e79d564739246b3f9c2a469ea60fd667a1f1dbba6a2930223d3c', 97, 1, '97-2021-09-29 19:02:53', '[]', 0, '2021-09-29 19:02:53', '2021-09-29 19:02:53', '2022-09-29 19:02:53'),
('4d83383f7b0588947ec546ab6180b9c149cc024ccab3f7b5a5ffcb6cde9124e2b52ff38d76c25738', 97, 1, '97-2021-09-29 19:01:09', '[]', 0, '2021-09-29 19:01:09', '2021-09-29 19:01:09', '2022-09-29 19:01:09'),
('4fc0de67800b2b2ec43dc16ad6b3b52c3fba529f8211968df22bb5d7c2e06ed056a6140270d8ccf7', 23, 1, '23-2021-09-25 18:25:25', '[]', 0, '2021-09-25 18:25:25', '2021-09-25 18:25:25', '2022-09-25 18:25:25'),
('518935df0666e731d1df5141b8da5da22acff9e0cc9fcd4061d4a8fd2604502a871fa51052e99208', 151, 1, '151-2021-11-13 16:51:03', '[]', 0, '2021-11-13 16:51:03', '2021-11-13 16:51:03', '2022-11-13 16:51:03'),
('51b480d711bbff418fc8c7a94526b664df7054b3046d2ec491da916e57cdc98897fa43f59d9402a7', 6, 1, '61632418284', '[]', 0, '2021-09-23 17:31:24', '2021-09-23 17:31:24', '2022-09-23 17:31:24'),
('544d776ef3bbc8a2b94e1f80c268f2c9187848860abf55c5cc208231f735d7815adf0f07bbed9fd8', 58, 1, '58-2021-09-28 16:11:20', '[]', 0, '2021-09-28 16:11:20', '2021-09-28 16:11:20', '2022-09-28 16:11:20'),
('54cbaf773cc78689623de87349936dcae1dfaf9818ff2927d2ae84e8ad972c22f1df4e340b380d8c', 43, 1, '43-2021-09-27 13:05:40', '[]', 0, '2021-09-27 13:05:40', '2021-09-27 13:05:40', '2022-09-27 13:05:40'),
('54fa1a0a824a140e9752f3c63d4dda860fb0b3d52e3ffee68a2322e68c9e28dd94a5801c40c36359', 118, 1, '118-2021-10-24 10:12:08', '[]', 0, '2021-10-24 10:12:08', '2021-10-24 10:12:08', '2022-10-24 10:12:08'),
('551810a638cadf25369ed5490296330c57bfa428db63ee7b66a687c9de9cc9df0bc2dfdb915870c9', 144, 1, '144-2021-11-25 17:22:31', '[]', 0, '2021-11-25 17:22:31', '2021-11-25 17:22:31', '2022-11-25 17:22:31'),
('559249eb9c368a84e463038079623951a3572119bad2b1793ecbe427baf339278a3a5207aa3783a9', 28, 1, '28-2021-09-28 15:13:10', '[]', 0, '2021-09-28 15:13:10', '2021-09-28 15:13:10', '2022-09-28 15:13:10'),
('564802583a31d64114f7b7a857e2af0b67e4b64f9623bc29b04cd25f06003e943d095a317d4eff97', 125, 1, '125-2021-10-26 18:53:59', '[]', 0, '2021-10-26 18:53:59', '2021-10-26 18:53:59', '2022-10-26 18:53:59'),
('57c53b48031ca6836c398b859bcea87dd165e5ffe956846f4afce8bf948c77cc05c9ad4a0dd21044', 85, 1, '85-2021-09-29 06:41:11', '[]', 0, '2021-09-29 06:41:11', '2021-09-29 06:41:11', '2022-09-29 06:41:11'),
('58f1a9d5e5ec17dca6e2b12fad468e10289f18b8cb708d2c5aeba3a1c168f2acfe039266f18469d8', 22, 1, '22-2021-09-25 14:40:37', '[]', 0, '2021-09-25 14:40:37', '2021-09-25 14:40:37', '2022-09-25 14:40:37'),
('595f9e9647d0bc78191c6ac6c0d125336c55bbb45ea3153856bab76c7077d98e39b97772b8d6fa85', 96, 1, '96-2021-09-29 18:57:14', '[]', 0, '2021-09-29 18:57:14', '2021-09-29 18:57:14', '2022-09-29 18:57:14'),
('59cd8056eca245ee45ffa6520dbfebcb3c9de61b038e1ba6dc2347d8f58a613f8f723911134047c3', 27, 1, '27-2021-09-25 15:49:47', '[]', 0, '2021-09-25 15:49:47', '2021-09-25 15:49:47', '2022-09-25 15:49:47'),
('5a86278c6d22a82296cfacef280186d42cfd52893b8a016f895fa2e06700d1ab9ccb0f60421f162c', 144, 1, '144-2021-11-06 15:39:26', '[]', 0, '2021-11-06 15:39:26', '2021-11-06 15:39:26', '2022-11-06 15:39:26'),
('5afb3038caead1e1ea2746ed6e2af8ee5df619dd261e0c3366e4d039944acadea91e60fe4925aaba', 78, 1, '78-2021-09-29 06:24:36', '[]', 0, '2021-09-29 06:24:36', '2021-09-29 06:24:36', '2022-09-29 06:24:36'),
('5b70c6fbfb3d52244547f81ba48894f3f8313707ddc93179673a6bb2678e2a9d283f3bc0b793f4d3', 59, 1, '59-2021-09-28 16:12:06', '[]', 0, '2021-09-28 16:12:06', '2021-09-28 16:12:06', '2022-09-28 16:12:06'),
('5eacf4b29d8a60647555f27509936a48d5efdefc8543671d760a0d2ffc2108d3245cfd9ef9cbc279', 131, 1, '131-2021-11-01 08:15:31', '[]', 0, '2021-11-01 08:15:31', '2021-11-01 08:15:31', '2022-11-01 08:15:31'),
('60f45d46f687c57d0c81f53f78fea9fac80140354cfd0b8d64f5ad44d4a8cae9ebd3802a8c97fe67', 97, 1, '97-2021-09-29 19:00:05', '[]', 0, '2021-09-29 19:00:05', '2021-09-29 19:00:05', '2022-09-29 19:00:05'),
('60f61f01f46fba44bd503e9871c17ba99697092975c6bc13d7fb3760d0b45827c8779876bdd7fec8', 1, 1, '1-2021-09-23 19:22:34', '[]', 0, '2021-09-23 19:22:34', '2021-09-23 19:22:34', '2022-09-23 19:22:34'),
('6158f4dca681788bcdfa02d1d67744981e1f371a91caedfc02b9658f4ee4da24f0535e63ae96373a', 18, 1, '18-2021-09-24 19:43:22', '[]', 0, '2021-09-24 19:43:22', '2021-09-24 19:43:22', '2022-09-24 19:43:22'),
('63da6533819120614716723f985c970ae75a2d1748b58352732115d05226b9d5cb7bc4a4a5abe973', 84, 1, '84-2021-09-29 06:38:21', '[]', 0, '2021-09-29 06:38:21', '2021-09-29 06:38:21', '2022-09-29 06:38:21'),
('68a85b36410e24b4a07620d4450aa5ad00c0601079ee986f9dd769ca7ea0daaeffc62c1f45947761', 114, 1, '114-2021-10-20 12:50:05', '[]', 0, '2021-10-20 12:50:05', '2021-10-20 12:50:05', '2022-10-20 12:50:05'),
('6905ff480306e7265c41e23fe7ab31f6b1263cd7224b4ebe76727637a1bee68c8327639b6beee5dc', 97, 1, '97-2021-09-29 18:55:53', '[]', 0, '2021-09-29 18:55:53', '2021-09-29 18:55:53', '2022-09-29 18:55:53'),
('6932231309ed07d218ac86b6cd3146225cc2494a0db9a658b3df4d1345679856ecf4a0021dec5027', 15, 1, '15-2021-09-24 16:46:55', '[]', 0, '2021-09-24 16:46:55', '2021-09-24 16:46:55', '2022-09-24 16:46:55'),
('6ad8f3f126bda6de3cb199b065bd1b4cafb9514cffe1f50bd15bd174da51d370d80fd98e5eda1c4b', 28, 1, '28-2021-09-28 15:14:25', '[]', 0, '2021-09-28 15:14:25', '2021-09-28 15:14:25', '2022-09-28 15:14:25'),
('6b44fdc4169e639929e68c6273e9eb0e21d00925aaceea192206e1757e28a132e5c177388d02f90c', 118, 1, '118-2021-10-23 16:02:29', '[]', 0, '2021-10-23 16:02:29', '2021-10-23 16:02:29', '2022-10-23 16:02:29'),
('6b8e041919ba42ebc0b05d8419a25d6e155a50d31ee77e182254ec4e605e3319488052367c83d122', 28, 1, '28-2021-09-28 15:13:20', '[]', 0, '2021-09-28 15:13:20', '2021-09-28 15:13:20', '2022-09-28 15:13:20'),
('6baa911365115368885f7f81bac6a64b5d17a11edc735682f2577e4282755555169b34ff5d5b1ac7', 16, 1, '16-2021-09-24 16:47:29', '[]', 0, '2021-09-24 16:47:29', '2021-09-24 16:47:29', '2022-09-24 16:47:29'),
('6c398207c31cfec9c2f8d986050a2dcd2f689738b2747c29137f95dd9ba15e6d82188bc6227d1557', 57, 1, '57-2021-09-29 18:00:02', '[]', 0, '2021-09-29 18:00:02', '2021-09-29 18:00:02', '2022-09-29 18:00:02'),
('6c692842cd0963918c301302dfbe7f87f93e48882ec24f03d93831b8c7229ed7fbe56b2005906454', 76, 1, '76-2021-09-29 06:21:38', '[]', 0, '2021-09-29 06:21:38', '2021-09-29 06:21:38', '2022-09-29 06:21:38'),
('6cdca975256d09137b81eb7f4d61ef6968ef5e8a75d7eb598883dc4b670b2ee2dc73b9a174c9c3b3', 125, 1, '125-2021-10-26 19:15:34', '[]', 0, '2021-10-26 19:15:34', '2021-10-26 19:15:34', '2022-10-26 19:15:34'),
('6d085b6b5e2e37589de7308800a5974be4d78cf2ab12e844a3c78480747e33cdf4b38a1cae21884d', 97, 1, '97-2021-09-29 18:55:47', '[]', 0, '2021-09-29 18:55:47', '2021-09-29 18:55:47', '2022-09-29 18:55:47'),
('6e3bc766c0bcaa0fce3307abb558c5b6bb373140e1b7cf319129e82a683009d5504c559ce2728794', 145, 1, '145-2021-11-06 15:46:18', '[]', 0, '2021-11-06 15:46:18', '2021-11-06 15:46:18', '2022-11-06 15:46:18'),
('6fef86916a0ed5f7019e935f2922fbc9cc94c9ae9caadbfeb3ec6aa847e2193ae03c497672cdbc40', 147, 1, '147-2021-11-07 07:49:55', '[]', 0, '2021-11-07 07:49:55', '2021-11-07 07:49:55', '2022-11-07 07:49:55'),
('700d041ff1324f6779d7b17dc1cb9459808c2552357361c28bf6a61c77ef7284958047604e8a962e', 37, 1, '37-2021-09-26 17:20:26', '[]', 0, '2021-09-26 17:20:26', '2021-09-26 17:20:26', '2022-09-26 17:20:26'),
('714d0e649e4f569065d752085d956b238de542074dd5cf534450114869f07ae8d805d3def5172a7a', 97, 1, '97-2021-09-29 18:58:10', '[]', 0, '2021-09-29 18:58:10', '2021-09-29 18:58:10', '2022-09-29 18:58:10'),
('72d0949aa25f2aea5ad5e9eabce39dcb15d2f8ffb6c91275a379204f97ad3f17f8ee5245e539b9cd', 155, 1, '155-2021-11-13 16:54:02', '[]', 0, '2021-11-13 16:54:02', '2021-11-13 16:54:02', '2022-11-13 16:54:02'),
('72f1e7634e55835ce445834f53905dd33115b2f24a46f19bfbda21289553aedf65fe3872eeb83be0', 96, 1, '96-2021-10-22 18:59:57', '[]', 0, '2021-10-22 18:59:57', '2021-10-22 18:59:57', '2022-10-22 18:59:57'),
('75410093568fdd5c3727bd7ea8365c0cde2df190c1a8e9484e5f0d898d5a4c349aa3fd4636132be7', 17, 1, '17-2021-09-24 18:20:03', '[]', 0, '2021-09-24 18:20:03', '2021-09-24 18:20:03', '2022-09-24 18:20:03'),
('765fa882ef597f141b7e6c2dec6a260b4d929b4ae4ecdcdc91b5897c046cbb17c586a57224a38db4', 46, 1, '46-2021-09-27 13:04:43', '[]', 0, '2021-09-27 13:04:43', '2021-09-27 13:04:43', '2022-09-27 13:04:43'),
('769db2da5365d5d2f901f7f12f3309bff9de0cbc3d3318a3949fec7a022e24cd590bebef79b2dffb', 15, 1, '15-2021-09-24 18:17:20', '[]', 0, '2021-09-24 18:17:20', '2021-09-24 18:17:20', '2022-09-24 18:17:20'),
('7797980bb851c22b76b25997a1c4efe56fe3a8e5f5e3ced198a542522e3335169acb92ab587de9e9', 44, 1, '44-2021-09-27 10:47:55', '[]', 0, '2021-09-27 10:47:55', '2021-09-27 10:47:55', '2022-09-27 10:47:55'),
('7923592ff8e1632db72d6247c85c110c5c10c876d3eb5e7ca9d7229c1597a8e678947f227adfc9d5', 47, 1, '47-2021-09-27 13:22:22', '[]', 0, '2021-09-27 13:22:22', '2021-09-27 13:22:22', '2022-09-27 13:22:22'),
('7b5c0af605a4761e5d10164bfad3f7beffc02cf00a69e06a66ad64973dd88b3a44d052ae5f97741d', 97, 1, '97-2021-09-29 19:07:56', '[]', 0, '2021-09-29 19:07:56', '2021-09-29 19:07:56', '2022-09-29 19:07:56'),
('7c7ecb575ecd6c3ab2434b9aa9a8b0a6b742a3647b211863305920eb50b2c4006a3c613468d5c0a6', 122, 1, '122-2021-10-24 10:13:34', '[]', 0, '2021-10-24 10:13:34', '2021-10-24 10:13:34', '2022-10-24 10:13:34'),
('7e3374a90cf3652493ef606d669602acb3593361affdfd359b0cd1e201ba4950a67b47c001bff75d', 102, 1, '102-2021-10-26 19:10:01', '[]', 0, '2021-10-26 19:10:01', '2021-10-26 19:10:01', '2022-10-26 19:10:01'),
('7f21f128779a6fb496b062fe7fe7c973902704a35ddc7d4b03493e134a278762037ceb091aca5952', 117, 1, '117-2021-10-22 16:29:06', '[]', 0, '2021-10-22 16:29:06', '2021-10-22 16:29:06', '2022-10-22 16:29:06'),
('83904bb9118c650f5319790e9ecdca84b9d3a31222a68c313e86dfb371c2755bb28c2e5171256466', 98, 1, '98-2021-09-29 19:07:05', '[]', 0, '2021-09-29 19:07:05', '2021-09-29 19:07:05', '2022-09-29 19:07:05'),
('845bedb6b54b11269e2f15cd9a5f20159b7190711cbeea18f53ebef86e70b270c7dbddbeb9606af1', 80, 1, '80-2021-09-29 06:34:06', '[]', 0, '2021-09-29 06:34:06', '2021-09-29 06:34:06', '2022-09-29 06:34:06'),
('86a46a046300286624e7bf0b5a07fa09e23bfcedf37fff2c241176d3b943f68ddad7b92674fee2d9', 19, 1, '19-2021-09-25 13:30:52', '[]', 0, '2021-09-25 13:30:53', '2021-09-25 13:30:53', '2022-09-25 13:30:53'),
('875a330595633ef70ca0cff187b657023aa8c6bbeae97a8e4d9e7a1364eebf0d0ef8ca370d6c0bb9', 11, 1, '111632421592', '[]', 0, '2021-09-23 18:26:32', '2021-09-23 18:26:32', '2022-09-23 18:26:32'),
('87a0fa39f00fbc37680c26c576686adecf2612b60a4d213168521684c768d595e8849a94ef9093f7', 125, 1, '125-2021-10-26 18:54:53', '[]', 0, '2021-10-26 18:54:53', '2021-10-26 18:54:53', '2022-10-26 18:54:53'),
('8945e8961e407146bd7b67f93467916b64057caadce705f746fddb0fd4131090a9f52c806f08a03f', 5, 1, '51632419032', '[]', 0, '2021-09-23 17:43:52', '2021-09-23 17:43:52', '2022-09-23 17:43:52'),
('8a90b68244ec67780093a3f9a9458a4a58e6d128993ca97b99aa0e6d2b3dd5492e4f7bfbbf6a8622', 108, 1, '108-2021-10-13 07:29:32', '[]', 0, '2021-10-13 07:29:32', '2021-10-13 07:29:32', '2022-10-13 07:29:32'),
('8ad3a0c4259a3289e9c92007990637e857ebac38d841c9694047043667e15ddfdc91f766cc35ce9b', 52, 1, '52-2021-09-27 15:13:49', '[]', 0, '2021-09-27 15:13:49', '2021-09-27 15:13:49', '2022-09-27 15:13:49'),
('8ae791fd39eda28db70b4598e4f3a8f44ea32a3b678e056941e1e8ba14e249ffbb60e5f0bb73df74', 82, 1, '82-2021-09-29 06:36:11', '[]', 0, '2021-09-29 06:36:11', '2021-09-29 06:36:11', '2022-09-29 06:36:11'),
('8b5b73d6adcec3bb747486d0f14c7880c98407e2cdaf05ef1450fb48fc1077a562a29e4c45f2d424', 77, 1, '77-2021-09-29 06:22:22', '[]', 0, '2021-09-29 06:22:22', '2021-09-29 06:22:22', '2022-09-29 06:22:22'),
('8bc47520a9cb86dde5ebaddd50873904172cf47dfba996f3d1d18bd5b39269445f3895d153593f7b', 100, 1, '100-2021-10-15 16:40:58', '[]', 0, '2021-10-15 16:40:58', '2021-10-15 16:40:58', '2022-10-15 16:40:58'),
('8c76ffeaab89698a67b62f97663e7c63cac3239d699dcb19503965e9e76ba2d40dc376400d15335b', 83, 1, '83-2021-09-29 06:37:53', '[]', 0, '2021-09-29 06:37:53', '2021-09-29 06:37:53', '2022-09-29 06:37:53'),
('8cfda4db7bea68912a3aa2dcb2c25f9a9cf61f14df37bfee8866031d59923af2a33219861c9f853b', 156, 1, '156-2021-11-27 15:00:03', '[]', 0, '2021-11-27 15:00:03', '2021-11-27 15:00:03', '2022-11-27 15:00:03'),
('8ddf1657e97b6fe12c7f4e7ac0b12b5865961329c6034594b94b7ddf6698306c51f8faf250648fae', 127, 1, '127-2021-10-31 07:12:07', '[]', 0, '2021-10-31 07:12:08', '2021-10-31 07:12:08', '2022-10-31 07:12:08'),
('8e33440792ab8d07071f95e514c8350c075d1066359df719d599700980dd98b5d99a5c8eee951358', 122, 1, '122-2021-10-26 18:43:26', '[]', 0, '2021-10-26 18:43:26', '2021-10-26 18:43:26', '2022-10-26 18:43:26'),
('8f7b7173482fa813ec4c2cd399aefc6a057c706194c434114920eaa7698e7fdb07e43770da9d4c3a', 15, 1, '15-2021-09-25 18:25:07', '[]', 0, '2021-09-25 18:25:07', '2021-09-25 18:25:07', '2022-09-25 18:25:07'),
('8f87d8321efcfa34e14d04f01e0e6c4435dd416ac24f28bfc93ed09797d1b245d46a9c62ab70a7c8', 20, 1, '20-2021-09-25 14:04:18', '[]', 0, '2021-09-25 14:04:18', '2021-09-25 14:04:18', '2022-09-25 14:04:18'),
('8f8eb28c1334e1b247661d54a8c9deeace8690caa123ceb93a39d20c5265476fd54d35459b9b28b9', 24, 1, '24-2021-09-25 15:03:51', '[]', 0, '2021-09-25 15:03:51', '2021-09-25 15:03:51', '2022-09-25 15:03:51'),
('94a690480b977a43a3117d69ecd4b2c1f901b160834a1cedf25d643a6efa80d1ff82fe8550b1ae6f', 97, 1, '97-2021-09-30 03:16:28', '[]', 0, '2021-09-30 03:16:28', '2021-09-30 03:16:28', '2022-09-30 03:16:28'),
('9624b1e184e9cbe8668c9f155c693299a1b680d3f857109f34ac2884cebbcd35bb776ebec748d164', 141, 1, '141-2021-11-06 16:40:42', '[]', 0, '2021-11-06 16:40:42', '2021-11-06 16:40:42', '2022-11-06 16:40:42'),
('96540deec73973a23387791bc8c32ec316d9819f4138686e5723f5b33417e4762b8f5765a0dd930e', 64, 1, '64-2021-09-28 19:42:45', '[]', 0, '2021-09-28 19:42:45', '2021-09-28 19:42:45', '2022-09-28 19:42:45'),
('966b6de7f99a2154ac74b242c6686b356c4781cb695679f9d55b6237586763d110c226da08a4acc6', 97, 1, '97-2021-09-29 19:01:32', '[]', 0, '2021-09-29 19:01:32', '2021-09-29 19:01:32', '2022-09-29 19:01:32'),
('97615f2fc88625fb10dec913a0caf5fd372d0204b7b6abdd029fd25028ddd7902624652bde9096fe', 5, 1, '51632386499', '[]', 0, '2021-09-23 08:41:39', '2021-09-23 08:41:39', '2022-09-23 08:41:39'),
('97a18b4742c0b5a7359756eccf728f95c1e7c4758bf768d385a15c03f8bc447d48f2bce70b53d54a', 42, 1, '42-2021-09-26 19:27:06', '[]', 0, '2021-09-26 19:27:06', '2021-09-26 19:27:06', '2022-09-26 19:27:06'),
('9897d1b4f98a3ff98dbf6bd71d9c74cb18e4b42878e8eb147095340d61d0b97e5ca3fa4b6df36303', 144, 1, '144-2021-11-14 17:17:36', '[]', 0, '2021-11-14 17:17:36', '2021-11-14 17:17:36', '2022-11-14 17:17:36'),
('9b907148b6bf4d74a3ef6a215e503bd0862762f9ded255725d32dc5d56802ab2e8b7e56425c2dbea', 118, 1, '118-2021-10-23 16:04:00', '[]', 0, '2021-10-23 16:04:00', '2021-10-23 16:04:00', '2022-10-23 16:04:00'),
('9bfa64abd73ae8919696f733b0c0079c471c5ec72c2960bc6767ec1d71941a82f1688e4a51ae8483', 68, 1, '68-2021-09-29 05:42:30', '[]', 0, '2021-09-29 05:42:30', '2021-09-29 05:42:30', '2022-09-29 05:42:30'),
('9e2ae44527eecdabb4c587a44376d3920cb22907f9345d08459ab7226ebd4558d1a2ded23366c0b1', 24, 1, '24-2021-09-25 18:24:52', '[]', 0, '2021-09-25 18:24:52', '2021-09-25 18:24:52', '2022-09-25 18:24:52'),
('9ea010e12e2bd185312e5441acc627f65f1b499d0e344a6370ef9ae16746e8da625a2a9405daaea3', 35, 1, '35-2021-09-26 17:12:11', '[]', 0, '2021-09-26 17:12:11', '2021-09-26 17:12:11', '2022-09-26 17:12:11'),
('9f2be025416032208f494aa64c25a640d66ea4258efac9972ae3c86388b633d8b7996b37c8a0d552', 116, 1, '116-2021-10-22 16:28:37', '[]', 0, '2021-10-22 16:28:37', '2021-10-22 16:28:37', '2022-10-22 16:28:37'),
('a00af8ffad965e5b9a0782b7511c8632666adc690da5283e8490c823a5b4530205c51371913528c2', 2, 1, '21631950840', '[]', 0, '2021-09-18 02:10:40', '2021-09-18 02:10:40', '2022-09-18 07:40:40'),
('a033c50d0389311278b0693bbea363035c4c9875076c0c8e0e8ab5dd491217e07a2b544caac32407', 99, 1, '99-2021-09-29 19:25:41', '[]', 0, '2021-09-29 19:25:41', '2021-09-29 19:25:41', '2022-09-29 19:25:41'),
('a393b1d580e6f38fc2138f91a9a21c9d5e198012c4160cf6860b6b18222760a2ac7a75f859fae361', 98, 1, '98-2021-09-29 19:07:36', '[]', 0, '2021-09-29 19:07:36', '2021-09-29 19:07:36', '2022-09-29 19:07:36'),
('a528b2cb1fe6aa3e003d1a9a7f1dc74b5f0bc3d5d12dfbcb3cc674c94dfbb8228f877fc60fa1cd67', 1, 1, '1-2021-09-25 19:04:57', '[]', 0, '2021-09-25 19:04:57', '2021-09-25 19:04:57', '2022-09-25 19:04:57'),
('a6d18eb6cc355515c80a6fbef4206abfcb25e5a58da9176d6c96f9ef6dd360737aa621532126de18', 66, 1, '66-2021-09-28 19:19:56', '[]', 0, '2021-09-28 19:19:56', '2021-09-28 19:19:56', '2022-09-28 19:19:56'),
('a757db27d67078348e69a82b058870bfc3671e4d459c8266e2c33140fcd744d5b3108d13401a7f2c', 57, 1, '57-2021-09-29 17:59:02', '[]', 0, '2021-09-29 17:59:02', '2021-09-29 17:59:02', '2022-09-29 17:59:02'),
('a88c24edefeb0944d813949468c52e31c97062a1eff15b8150f377f29e6dcaccca6bc52487349a21', 154, 1, '154-2021-11-13 16:48:52', '[]', 0, '2021-11-13 16:48:52', '2021-11-13 16:48:52', '2022-11-13 16:48:52'),
('ab38912952bf64a0482513b4670ddc3bbc7e961dd596bd0c68a560a2e8273236f6a731a6a13e6671', 121, 1, '121-2021-10-23 18:49:44', '[]', 0, '2021-10-23 18:49:44', '2021-10-23 18:49:44', '2022-10-23 18:49:44'),
('acb9a04e3cac32f5f93dfcd1b60bd42e3931baf04294b97fc03e0a8f8bb2400b095498a4dbd1fb10', 97, 1, '97-2021-09-29 18:59:31', '[]', 0, '2021-09-29 18:59:31', '2021-09-29 18:59:31', '2022-09-29 18:59:31'),
('acfc3670d00b5542a06f93e7d5510ae971f846a611a1aa0878c04c44a7f3ad97db789ea2a527c89b', 111, 1, '111-2021-10-18 12:49:45', '[]', 0, '2021-10-18 12:49:45', '2021-10-18 12:49:45', '2022-10-18 12:49:45'),
('adbc277c69cbfe26820ef701b11dbec6bba71b3d99d94edb0cd870293860e5357c8caf3f413614fd', 25, 1, '25-2021-09-25 18:25:20', '[]', 0, '2021-09-25 18:25:20', '2021-09-25 18:25:20', '2022-09-25 18:25:20'),
('af0e657822194c07025b388c732b216a6b386c36f7c01cdaf7a73aadaa88d0b8e27d4db011585fce', 97, 1, '97-2021-09-29 19:08:49', '[]', 0, '2021-09-29 19:08:49', '2021-09-29 19:08:49', '2022-09-29 19:08:49'),
('af2c9d19c8ef32b68bca19aa351666f336a69aafcc8eb6e46442a8cd6031ec79ade896cb1ae2fc9b', 21, 1, '21-2021-09-25 14:29:48', '[]', 0, '2021-09-25 14:29:48', '2021-09-25 14:29:48', '2022-09-25 14:29:48'),
('af42ea11d7d4ee736ae32514acecb4842edcb8e6705e60809c0fcfd5cf55baa57aff27fd1c15c0bd', 131, 1, '131-2021-11-01 08:17:30', '[]', 0, '2021-11-01 08:17:30', '2021-11-01 08:17:30', '2022-11-01 08:17:30'),
('afbd8f950b99d7e084918f16f286ad2020892c5129af045dc2e5101ae5c972da34e7716240e95ff8', 81, 1, '81-2021-09-29 06:34:40', '[]', 0, '2021-09-29 06:34:40', '2021-09-29 06:34:40', '2022-09-29 06:34:40'),
('b0f1d8d6b30bf5275864fd7ccb64a0ace1930864fb3b1870c7cf48ecd1ae8072538ae5a3dcf27199', 61, 1, '61-2021-09-28 17:51:58', '[]', 0, '2021-09-28 17:51:58', '2021-09-28 17:51:58', '2022-09-28 17:51:58'),
('b23a203e31c45c12f4c733424349d3f59c48375c3f23de6f3fd65aed7f7e29028e7210becb09310a', 118, 1, '118-2021-10-23 15:51:13', '[]', 0, '2021-10-23 15:51:13', '2021-10-23 15:51:13', '2022-10-23 15:51:13'),
('b24e29c3b16b9b06bb179cb49206e7b52f48c8eb6dd525ebbf9b52e3491948c37e6419ed93fd2e59', 97, 1, '97-2021-09-29 18:53:02', '[]', 0, '2021-09-29 18:53:02', '2021-09-29 18:53:02', '2022-09-29 18:53:02'),
('b43b20e4327aee54739b23ee8e110ec345d53f61584652269e7d56ad5baa86743f233f8f1158c84c', 118, 1, '118-2021-10-23 15:35:16', '[]', 0, '2021-10-23 15:35:16', '2021-10-23 15:35:16', '2022-10-23 15:35:16'),
('b49de79ff4c8565b75da8ac4cd412a9020a7dc7d49500f6864fdbd710e92cc035b58d4cbba1dc055', 149, 1, '149-2021-11-13 16:20:33', '[]', 0, '2021-11-13 16:20:33', '2021-11-13 16:20:33', '2022-11-13 16:20:33'),
('b9e4825bdc8168fbce733bf195a9f6c7acdadfe34a75fc0744e9d824c2fa4e3dcf84f41129cea7d0', 115, 1, '115-2021-10-20 12:57:33', '[]', 0, '2021-10-20 12:57:33', '2021-10-20 12:57:33', '2022-10-20 12:57:33'),
('bb165463c6d30229ecf3a3ca48e5674cc49fbffd82eec333e5f95d2829b05c52ff8f9cfe20302ccc', 99, 1, '99-2021-09-29 19:25:05', '[]', 0, '2021-09-29 19:25:05', '2021-09-29 19:25:05', '2022-09-29 19:25:05'),
('bc5b0d0125375cbddf3d0ea46a38487cc218001645fe5e6775664ce957cd39389510e27f84754710', 165, 1, '165-2021-11-26 19:15:45', '[]', 0, '2021-11-26 19:15:45', '2021-11-26 19:15:45', '2022-11-26 19:15:45'),
('bc905254de6ed17c95ba9337f565e72feaf943924a89fcddcbbd354af6ea90953fd36affbb3c47f4', 120, 1, '120-2021-10-23 17:39:20', '[]', 0, '2021-10-23 17:39:20', '2021-10-23 17:39:20', '2022-10-23 17:39:20'),
('bdda768b2361dc72e64b37be78166c6a68de1e2078413cc5afc88d370f80b6fc17c85bbe4dfbf180', 126, 1, '126-2021-10-26 18:55:44', '[]', 0, '2021-10-26 18:55:44', '2021-10-26 18:55:44', '2022-10-26 18:55:44'),
('bfbc8ec7c73180948a24dc7c12bc149f69723d7fe9f7b74dc23f8fa1047ba94765a6e116cc61962b', 65, 1, '65-2021-09-28 19:43:45', '[]', 0, '2021-09-28 19:43:45', '2021-09-28 19:43:45', '2022-09-28 19:43:45'),
('c01e4622c647bc02bc8c3f088cd01307dd85d5fbe18e8c24e25b0d8d2a81c499702ef66751ffa274', 53, 1, '53-2021-09-27 15:14:53', '[]', 0, '2021-09-27 15:14:53', '2021-09-27 15:14:53', '2022-09-27 15:14:53'),
('c1027205906096fce7b1bd5644a217f437bfdf2f1707c29568eb64f36452e0489349b856c7063158', 125, 1, '125-2021-10-26 18:54:49', '[]', 0, '2021-10-26 18:54:49', '2021-10-26 18:54:49', '2022-10-26 18:54:49'),
('c158286f6689504571dcaf25d0286f07c5aa0892c51368d8280cfbd57eea68ee176f634fbfe76caf', 15, 1, '15-2021-09-25 15:43:19', '[]', 0, '2021-09-25 15:43:19', '2021-09-25 15:43:19', '2022-09-25 15:43:19'),
('c33bdfbafb1433f48ec34f3acefe4b248e9d3dacd5b5418cf2629d909588e49c6352a7ae91820f6f', 100, 1, '100-2021-10-13 17:50:44', '[]', 0, '2021-10-13 17:50:44', '2021-10-13 17:50:44', '2022-10-13 17:50:44'),
('c409153751fb82d2e7784f7f421299e2e90e4e378f0f3a4e81ff57d5118cd72a8143026e184b0874', 1, 1, '11632385625', '[]', 0, '2021-09-23 08:27:06', '2021-09-23 08:27:06', '2022-09-23 08:27:06'),
('c44e4ae5977cd9af361e3618ae886ee335c22c452ea2e740e39dce382106aa31a7e19604279fcddf', 96, 1, '96-2021-10-09 16:21:02', '[]', 0, '2021-10-09 16:21:02', '2021-10-09 16:21:02', '2022-10-09 16:21:02'),
('c4c7571b4eb5105e2eb151cbb8893f528077d1953a5dfec36ed9eaec6c3fb924117390c6a22165e9', 8, 1, '81632418437', '[]', 0, '2021-09-23 17:33:57', '2021-09-23 17:33:57', '2022-09-23 17:33:57'),
('c500057d785da1be26fe57fcc6e3bf27863b914177a4dc9c47642a63cb65b41778939125e3fd9780', 64, 1, '64-2021-09-28 19:49:48', '[]', 0, '2021-09-28 19:49:48', '2021-09-28 19:49:48', '2022-09-28 19:49:48'),
('c52ab4764818658c42515d19f1b6f327094a96fdc855e3ea1400d3a48f73817706f49daf32f2342e', 28, 1, '28-2021-09-27 18:08:51', '[]', 0, '2021-09-27 18:08:51', '2021-09-27 18:08:51', '2022-09-27 18:08:51'),
('c771bb9f1d87276b835e845024e3cca2aeead124952aa0a6c88fd0c8a65d5ac3aad765e15420e9b5', 97, 1, '97-2021-09-29 19:08:10', '[]', 0, '2021-09-29 19:08:10', '2021-09-29 19:08:10', '2022-09-29 19:08:10'),
('c85524c8d2f5a5bc502cccb3daaadf222492ee4070f00b4c96e33ca4b379b5e332512a6b1ab11db6', 145, 1, '145-2021-11-06 15:47:26', '[]', 0, '2021-11-06 15:47:26', '2021-11-06 15:47:26', '2022-11-06 15:47:26'),
('c871702203cc4c00e8de365fd374896e9f46551a0e0f21d9004007da16abb23c0706a6586acbb1e5', 23, 1, '23-2021-09-25 14:49:29', '[]', 0, '2021-09-25 14:49:29', '2021-09-25 14:49:29', '2022-09-25 14:49:29'),
('c8cf95aa2d724a5a729b19376d8b16150b76c6687942c399252456a75400f6287f9f98e79cb302fc', 1, 1, '1-2021-09-25 19:10:13', '[]', 0, '2021-09-25 19:10:13', '2021-09-25 19:10:13', '2022-09-25 19:10:13'),
('c9f60a9a8c7b32f4d891eac8ca84621633143c6be53115df4f6e66b72ba7d0d5332f30b861fe7c47', 96, 1, '96-2021-10-22 19:08:59', '[]', 0, '2021-10-22 19:08:59', '2021-10-22 19:08:59', '2022-10-22 19:08:59'),
('cb984cb81ddaca0ee3fba1e58bddc374d9ab1c7383e752bc9cccca18701eef79de2e6046add37967', 96, 1, '96-2021-09-29 18:41:02', '[]', 0, '2021-09-29 18:41:02', '2021-09-29 18:41:02', '2022-09-29 18:41:02'),
('ccb4e0f0273b9e27d549c0808f3d2e8e133be91c2c12f57a41e209b4c8633aa608ca39a2a823e8a8', 97, 1, '97-2021-09-29 18:56:47', '[]', 0, '2021-09-29 18:56:47', '2021-09-29 18:56:47', '2022-09-29 18:56:47'),
('cde6adcf0b47bb3246b141e59ea1bb0ddebd8b0bd3117034f01030d56c1d52fb2e270b43ecd548f4', 106, 1, '106-2021-10-12 15:07:27', '[]', 0, '2021-10-12 15:07:27', '2021-10-12 15:07:27', '2022-10-12 15:07:27'),
('cde7d6f379477e3601aae501d11e5eeb857342a5811b68fd223af9f2cea5558b0e971674df200e5b', 126, 1, '126-2021-10-30 18:05:54', '[]', 0, '2021-10-30 18:05:54', '2021-10-30 18:05:54', '2022-10-30 18:05:54'),
('ce3431735fd11b4da24ce31c85bfb6269d42e957b7bbd7f3e6087c7538383bc163d9edf54a808ab0', 95, 1, '95-2021-09-29 18:35:40', '[]', 0, '2021-09-29 18:35:40', '2021-09-29 18:35:40', '2022-09-29 18:35:40'),
('ce3ff33829e0f7d8e6765b118cf2fe25acff245bf903e25a488cb70bc31010db3b7e58dc1fb491ef', 118, 1, '118-2021-10-23 19:03:13', '[]', 0, '2021-10-23 19:03:13', '2021-10-23 19:03:13', '2022-10-23 19:03:13'),
('ceee20d682bf95896f09a49eb76df0c3615e80519f33122439d741bf3fd1b8993474f0314b7881ad', 27, 1, '27-2021-09-25 15:50:04', '[]', 0, '2021-09-25 15:50:04', '2021-09-25 15:50:04', '2022-09-25 15:50:04'),
('cfc4a4c9abb3258f70228adf6e05080e4c588d23f93e80babe4fc32ebb8c538d1546c958eb74eaa6', 118, 1, '118-2021-10-23 19:01:20', '[]', 0, '2021-10-23 19:01:20', '2021-10-23 19:01:20', '2022-10-23 19:01:20'),
('d054338b0e1dbda8fd836ec7e0bfda1ee0bbae6d5033a234239f50884466b2920f2fddf1b7491f01', 159, 1, '159-2021-11-27 02:35:55', '[]', 0, '2021-11-27 02:35:55', '2021-11-27 02:35:55', '2022-11-27 02:35:55'),
('d0ba21183291ff077722dffc2d2994dc1d6fbd649e6c94c3c0d5bf92cc9bc7667e39a32760bae038', 125, 1, '125-2021-10-26 18:50:41', '[]', 0, '2021-10-26 18:50:41', '2021-10-26 18:50:41', '2022-10-26 18:50:41'),
('d1545e11d4cf11105e1354f650f93a6644d22b2af97acbb8413a9b0272377062a39a087e63c3fa96', 143, 1, '143-2021-11-08 16:05:39', '[]', 0, '2021-11-08 16:05:39', '2021-11-08 16:05:39', '2022-11-08 16:05:39'),
('d185c481069d4e5200f3602f41a91214f9624cac630dfcc20d2f50c567321ee23bc32fa4a17c82f5', 143, 1, '143-2021-11-08 15:59:46', '[]', 0, '2021-11-08 15:59:46', '2021-11-08 15:59:46', '2022-11-08 15:59:46'),
('d1927c0f6deac6b657dbd780285a148772c811d217dfc20bd83613f82ff804c553f3151edd2df3ee', 28, 1, '28-2021-09-26 18:31:54', '[]', 0, '2021-09-26 18:31:54', '2021-09-26 18:31:54', '2022-09-26 18:31:54'),
('d19d6cd60bafa76ab56884af7615adac6e8f0e121e05e71494199b96ecfdc138d2a48b3ab2134623', 118, 1, '118-2021-10-23 16:29:22', '[]', 0, '2021-10-23 16:29:22', '2021-10-23 16:29:22', '2022-10-23 16:29:22'),
('d2117e6b7e2d8b97c5662caf63d5b74b3a879a39d9b1bad33f4e695bcb6df02f3bcbd05d183495c0', 57, 1, '57-2021-09-29 17:59:26', '[]', 0, '2021-09-29 17:59:26', '2021-09-29 17:59:26', '2022-09-29 17:59:26'),
('d34d0992397a1a4da4b16adbca36b9325b34db0a4d4b73c6485b6e934cf8245928d69db9f5069d85', 30, 1, '30-2021-09-26 02:03:02', '[]', 0, '2021-09-26 02:03:02', '2021-09-26 02:03:02', '2022-09-26 02:03:02'),
('d3e9cd2278d7273440b34c549d0632ff754dbcf5a8cc859380feae317dfa6e793b932f3fbf4aad57', 2, 1, '21631950820', '[]', 0, '2021-09-18 02:10:20', '2021-09-18 02:10:20', '2022-09-18 07:40:20'),
('d3f2522a2e89a13bbdf5ccdb1a2e68d6ffb0e4fda869f4a1de9c6e3eda23af0329611dde724c871d', 1, 1, '11632421563', '[]', 0, '2021-09-23 18:26:03', '2021-09-23 18:26:03', '2022-09-23 18:26:03'),
('d411f450478421b2ab4cdec874eabfa6f1bc7853feaff2b3e08a850336d5133abec22169bc8f45c2', 158, 1, '158-2021-11-26 05:14:59', '[]', 0, '2021-11-26 05:14:59', '2021-11-26 05:14:59', '2022-11-26 05:14:59'),
('d42a9db8b6e33f1133d81400ea997c3843bf38b78d176870d98d665b5ea0e6461a2de522b17d1d3f', 18, 1, '18-2021-09-24 20:09:23', '[]', 0, '2021-09-24 20:09:23', '2021-09-24 20:09:23', '2022-09-24 20:09:23'),
('d43882b328ca43d08aa079066cf960aa71a7a9818223c1ff3a01be29102ca0aef09d1f5e23d55b94', 122, 1, '122-2021-10-24 10:13:55', '[]', 0, '2021-10-24 10:13:55', '2021-10-24 10:13:55', '2022-10-24 10:13:55'),
('d6073807f27f996b8af165944e311900e2ade95648d6cd029a0a1226adb72e1c9b15b8a4d5ebbefd', 71, 1, '71-2021-09-29 05:55:42', '[]', 0, '2021-09-29 05:55:42', '2021-09-29 05:55:42', '2022-09-29 05:55:42'),
('d61d1dc819fa6bc9cddcb2e0a26b5c16c4f759686bd3e8d98ad6105268c0087d2507543a852b0b31', 97, 1, '97-2021-09-29 19:08:08', '[]', 0, '2021-09-29 19:08:08', '2021-09-29 19:08:08', '2022-09-29 19:08:08'),
('d80980c81a036dd2a6b194b222bb8aa1c9425e5cfeedb6e1906bea8750958c2fff8d13d4dec0f306', 107, 1, '107-2021-10-12 15:13:44', '[]', 0, '2021-10-12 15:13:44', '2021-10-12 15:13:44', '2022-10-12 15:13:44'),
('d8bc1a539996b37c6c127af198ea1eb661e6f7db5f00b1f185754c786360badae038aef757168218', 126, 1, '126-2021-10-30 18:07:57', '[]', 0, '2021-10-30 18:07:57', '2021-10-30 18:07:57', '2022-10-30 18:07:57'),
('d8e601cad5b01ba32e5c46a308036745f53e8a928c5ee7fe95c52964401f70d948bb1a27365ababd', 36, 1, '36-2021-09-26 17:16:41', '[]', 0, '2021-09-26 17:16:41', '2021-09-26 17:16:41', '2022-09-26 17:16:41'),
('da4be6a1dc43cc3707738088844732c9dae1af98caab60ee7127d98cf7e0d5f4af1f890f1247327b', 153, 1, '153-2021-11-13 16:47:26', '[]', 0, '2021-11-13 16:47:26', '2021-11-13 16:47:26', '2022-11-13 16:47:26'),
('da8f4b468c68f4ee0195cafaf1ca41141d8da280dd28dd33702f51c2db12929769315c380bbe8e36', 126, 1, '126-2021-10-30 18:29:41', '[]', 0, '2021-10-30 18:29:41', '2021-10-30 18:29:41', '2022-10-30 18:29:41'),
('dd963344cafd7e4f9fd582e436e6fdf305759e47169b141dfbab0adeccf001a27ddfa946d6da1a7f', 126, 1, '126-2021-10-26 18:52:51', '[]', 0, '2021-10-26 18:52:51', '2021-10-26 18:52:51', '2022-10-26 18:52:51'),
('ddd329b12ef86adbbfe69fc40875513a1b4fc94e34f9f02cc31dd06ee4fc665861c3cc62b5a14802', 143, 1, '143-2021-11-08 15:56:06', '[]', 0, '2021-11-08 15:56:06', '2021-11-08 15:56:06', '2022-11-08 15:56:06'),
('dde23028861e0f82b8e48043ab3a32404ed0b6163855c2ac75aa57ae2f9798165c153fb5c0f6f933', 69, 1, '69-2021-09-29 05:48:12', '[]', 0, '2021-09-29 05:48:12', '2021-09-29 05:48:12', '2022-09-29 05:48:12'),
('de30bcc604fcd910db3b601a9363b28e1da2000b4ec397604b96c77a85a74c70eedc1dfa49a57f8c', 97, 1, '97-2021-09-29 18:54:49', '[]', 0, '2021-09-29 18:54:49', '2021-09-29 18:54:49', '2022-09-29 18:54:49'),
('df175a2b12a2f2749c4a3d6d1fcea98e7ea208910ed8c00de69520fb65ee41295fc6ff547c9d232b', 97, 1, '97-2021-09-29 18:49:08', '[]', 0, '2021-09-29 18:49:08', '2021-09-29 18:49:08', '2022-09-29 18:49:08'),
('dfe5f6d95abf8bfa513e1c9606ad9e9aaff293bd650ff65b727bb89bf42add663b0cb4a60de15238', 66, 1, '66-2021-09-28 19:29:04', '[]', 0, '2021-09-28 19:29:04', '2021-09-28 19:29:04', '2022-09-28 19:29:04'),
('e485378a0c174b8a26d348922b14dfd8b745d94b79591fbda04816a5bc996dd7c6a3a957d3dff58f', 99, 1, '99-2021-09-29 19:16:12', '[]', 0, '2021-09-29 19:16:12', '2021-09-29 19:16:12', '2022-09-29 19:16:12'),
('e51026eebfb413009b41a722cd24d215eee78e41b0ee3362a2b50fa7e044e329bdd0e709a681efea', 10, 1, '101632418453', '[]', 0, '2021-09-23 17:34:13', '2021-09-23 17:34:13', '2022-09-23 17:34:13'),
('e5edcd6c28fa880f925b22671849bc0f9a13230d0a92fcede65a9deb46019852d4fbd7e3f0ebd27d', 97, 1, '97-2021-09-29 19:07:47', '[]', 0, '2021-09-29 19:07:47', '2021-09-29 19:07:47', '2022-09-29 19:07:47'),
('e78e21354cb5d5c3ecdd149e2598ee44c25f41f7e60df4d0bd519a9c77b562f050fd05012b359e91', 74, 1, '74-2021-09-29 06:11:32', '[]', 0, '2021-09-29 06:11:32', '2021-09-29 06:11:32', '2022-09-29 06:11:32'),
('e7c532b8dcba4d103eb3f36808b15e82a4c1b12feab86168314423ddffb1632237ae2d4297e55368', 101, 1, '101-2021-09-30 05:27:45', '[]', 0, '2021-09-30 05:27:45', '2021-09-30 05:27:45', '2022-09-30 05:27:45'),
('e952e2ec4da35a61c2f9da262f93d32a1673325574637090a168286a62915604408faba563b0459b', 159, 1, '159-2021-11-26 05:17:50', '[]', 0, '2021-11-26 05:17:50', '2021-11-26 05:17:50', '2022-11-26 05:17:50'),
('ea04547b193309fd37ad2a86c3c7488f77499c09c1355f0bdd3904d51f8f32f57f832d839704ec3e', 98, 1, '98-2021-09-29 19:06:40', '[]', 0, '2021-09-29 19:06:40', '2021-09-29 19:06:40', '2022-09-29 19:06:40'),
('ea70efb579b2eee762363ba481e93e3c10a2438387ae78407cca131a8030300d562bc2dbc141ad93', 147, 1, '147-2021-11-26 05:11:48', '[]', 0, '2021-11-26 05:11:48', '2021-11-26 05:11:48', '2022-11-26 05:11:48'),
('ec5e1d0a891591f50374d397001da62bc4456c839bdf06cdab2cb5c787bd9dd3a78bea6d13786391', 75, 1, '75-2021-09-29 06:13:30', '[]', 0, '2021-09-29 06:13:30', '2021-09-29 06:13:30', '2022-09-29 06:13:30'),
('ee80393a2729ab5134c3984e0127c47ad5f18f95fea7013d33a2464a2e16fd0d81261a3f8ddacc05', 40, 1, '40-2021-09-26 17:44:14', '[]', 0, '2021-09-26 17:44:14', '2021-09-26 17:44:14', '2022-09-26 17:44:14'),
('f05990a8001476b6a72da99694827408a5026be0197e4a05e2814f7142672559bd83d8bfa226298d', 45, 1, '45-2021-09-27 10:50:47', '[]', 0, '2021-09-27 10:50:47', '2021-09-27 10:50:47', '2022-09-27 10:50:47'),
('f08acd43a7d0a1eff5d9e7ed66d630e74cf7b1f773420fa3f0c805d4f695072da8f28fd9ef54e526', 96, 1, '96-2021-10-22 19:06:04', '[]', 0, '2021-10-22 19:06:04', '2021-10-22 19:06:04', '2022-10-22 19:06:04'),
('f0d2ce90229fadae1dd4635428662fe5af4aabb3b5b7947d15d2db9f2d83fe4e927332653ed4607e', 102, 1, '102-2021-11-01 07:36:02', '[]', 0, '2021-11-01 07:36:02', '2021-11-01 07:36:02', '2022-11-01 07:36:02'),
('f1ade905e820b73fa8cf94f607fcf8f7fb6202aab827e2c5c615af9e0db44a2c5d219be575d52cf7', 64, 1, '64-2021-09-28 19:42:34', '[]', 0, '2021-09-28 19:42:34', '2021-09-28 19:42:34', '2022-09-28 19:42:34'),
('f20ca33acd0e6dce2c817783cc4385dbe6d3c1dafb1f72830b5a6eb2c968bead0e3d37882bf24c96', 112, 1, '112-2021-10-21 16:59:11', '[]', 0, '2021-10-21 16:59:11', '2021-10-21 16:59:11', '2022-10-21 16:59:11'),
('f4bea71997805a6028bf68981a1cac35405d73325c9cb0b882b277cf3f23100026147172e0440135', 118, 1, '118-2021-10-23 19:04:11', '[]', 0, '2021-10-23 19:04:11', '2021-10-23 19:04:11', '2022-10-23 19:04:11'),
('f7a61f3293c925ae831869aa7b179e75a9af0223a9bce65d5396c4f7a0335452a3d05c8472199274', 2, 1, '21631950996', '[]', 0, '2021-09-18 02:13:16', '2021-09-18 02:13:16', '2022-09-18 07:43:16'),
('f881aea0d37b77c1aa43f31e6ee62778acbd43851d17b0e40d5ad39e261e25a9378714b934781e82', 97, 1, '97-2021-09-29 19:02:06', '[]', 0, '2021-09-29 19:02:06', '2021-09-29 19:02:06', '2022-09-29 19:02:06'),
('f9783db90dacbb23326c05aad3dab15835cc00f29154c989f70bd4ba390a1f855690eb143774e9f0', 126, 1, '126-2021-10-28 18:05:54', '[]', 0, '2021-10-28 18:05:54', '2021-10-28 18:05:54', '2022-10-28 18:05:54'),
('fc29d88e0f17dd94b47ee53d1ae349071fc80a5346f0860c58899a17915d5876f7005aa96cd0ce3b', 64, 1, '64-2021-09-28 19:42:22', '[]', 0, '2021-09-28 19:42:22', '2021-09-28 19:42:22', '2022-09-28 19:42:22'),
('fce4e04c809720013813fec77d74bbb2f1edc78c61f73ee23ccc070948065cc0748937695b1a2ebb', 25, 1, '25-2021-09-25 15:29:29', '[]', 0, '2021-09-25 15:29:29', '2021-09-25 15:29:29', '2022-09-25 15:29:29');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `scopes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', 'hu5EFnzViy4p59CFqxJ0zMvp95dToTwwQK9DuTa0', NULL, 'http://localhost', 1, 0, 0, '2021-09-18 02:07:49', '2021-09-18 02:07:49'),
(2, NULL, 'Laravel Password Grant Client', 'OsV00QX04FyH4PQRD8F1LJQZTuX6dAx4bpV2dzYR', 'users', 'http://localhost', 0, 1, 0, '2021-09-18 02:07:49', '2021-09-18 02:07:49');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint UNSIGNED NOT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2021-09-18 02:07:49', '2021-09-18 02:07:49');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `subscription_id` int NOT NULL,
  `status` varchar(250) NOT NULL,
  `payment_id` varchar(250) DEFAULT NULL,
  `trans_id` varchar(250) DEFAULT NULL,
  `charge_id` varchar(250) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `balance_transaction` varchar(250) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `user_id`, `subscription_id`, `status`, `payment_id`, `trans_id`, `charge_id`, `amount`, `balance_transaction`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 151, 2, 'succeeded', 'pi_3JvReXItQT8ZzyO11xY9Xtyg', 'pi_3JvReXItQT8ZzyO11xY9Xtyg', 'ch_3JvReXItQT8ZzyO11vt6IsX4', 25, 'txn_3JvReXItQT8ZzyO11QituDMg', '2021-11-13 19:12:42', '2021-11-13 19:12:42', NULL),
(2, 151, 2, 'succeeded', 'pi_3JvSANItQT8ZzyO126UL22uS', 'pi_3JvSANItQT8ZzyO126UL22uS', 'ch_3JvSANItQT8ZzyO12D66Y36m', 25, 'txn_3JvSANItQT8ZzyO121zna3Hu', '2021-11-13 19:45:36', '2021-11-13 19:45:36', NULL),
(3, 151, 2, 'succeeded', 'pi_3JvSjwItQT8ZzyO11eZoqO9U', 'pi_3JvSjwItQT8ZzyO11eZoqO9U', 'ch_3JvSjwItQT8ZzyO11TKSVnqg', 25, 'txn_3JvSjwItQT8ZzyO11cF6wHIH', '2021-11-13 20:22:21', '2021-11-13 20:22:21', NULL),
(4, 132, 2, 'succeeded', 'pi_3JxGQkItQT8ZzyO10d6XExpR', 'pi_3JxGQkItQT8ZzyO10d6XExpR', 'ch_3JxGQkItQT8ZzyO10XAQSiQz', 25, 'txn_3JxGQkItQT8ZzyO10kYmJvGt', '2021-11-18 19:38:00', '2021-11-18 19:38:00', NULL),
(5, 132, 2, 'succeeded', 'pi_3JxGfsItQT8ZzyO10oH1NpjK', 'pi_3JxGfsItQT8ZzyO10oH1NpjK', 'ch_3JxGfsItQT8ZzyO10Yb2opW2', 25, 'txn_3JxGfsItQT8ZzyO10X89TOxn', '2021-11-18 19:53:38', '2021-11-18 19:53:38', NULL),
(6, 132, 2, 'succeeded', 'pi_3JxGv4ItQT8ZzyO11VvK4T3S', 'pi_3JxGv4ItQT8ZzyO11VvK4T3S', 'ch_3JxGv4ItQT8ZzyO11mEOglT6', 25, 'txn_3JxGv4ItQT8ZzyO11cuyIJHP', '2021-11-18 20:09:19', '2021-11-18 20:09:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `title`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'permission_create', '2019-09-10 08:30:26', '2019-09-10 08:30:26', NULL),
(2, 'permission_edit', '2019-09-10 08:30:26', '2019-09-10 08:30:26', NULL),
(3, 'permission_show', '2019-09-10 08:30:26', '2019-09-10 08:30:26', NULL),
(4, 'permission_delete', '2019-09-10 08:30:26', '2019-09-10 08:30:26', NULL),
(5, 'permission_access', '2019-09-10 08:30:26', '2019-09-10 08:30:26', NULL),
(6, 'role_create', '2019-09-10 08:30:26', '2019-09-10 08:30:26', NULL),
(7, 'role_edit', '2019-09-10 08:30:26', '2019-09-10 08:30:26', NULL),
(8, 'role_show', '2019-09-10 08:30:26', '2019-09-10 08:30:26', NULL),
(9, 'role_delete', '2019-09-10 08:30:26', '2019-09-10 08:30:26', NULL),
(10, 'role_access', '2019-09-10 08:30:26', '2019-09-10 08:30:26', NULL),
(11, 'user_management_access', '2019-09-10 08:30:26', '2019-09-10 08:30:26', NULL),
(12, 'user_create', '2019-09-10 08:30:26', '2019-09-10 08:30:26', NULL),
(13, 'user_edit', '2019-09-10 08:30:26', '2019-09-10 08:30:26', NULL),
(14, 'user_show', '2019-09-10 08:30:26', '2019-09-10 08:30:26', NULL),
(15, 'user_delete', '2019-09-10 08:30:26', '2019-09-10 08:30:26', NULL),
(16, 'user_access', '2019-09-10 08:30:26', '2019-09-10 08:30:26', NULL),
(18, 'city_access', '2021-10-02 04:21:10', '2021-10-02 04:21:10', NULL),
(19, 'city_show', '2021-10-02 04:44:12', '2021-10-02 04:44:12', NULL),
(20, 'city_edit', '2021-10-02 04:44:21', '2021-10-02 04:44:21', NULL),
(21, 'city_delete', '2021-10-02 04:44:28', '2021-10-02 04:44:28', NULL),
(22, 'city_create', '2021-10-02 04:45:04', '2021-10-02 04:45:04', NULL),
(23, 'advertisement_access', '2021-10-02 06:13:23', '2021-10-02 06:13:23', NULL),
(24, 'advertisement_edit', '2021-10-02 06:38:40', '2021-10-02 06:38:40', NULL),
(25, 'advertisement_create', '2021-10-02 06:39:18', '2021-10-02 06:39:18', NULL),
(26, 'advertisement_delete', '2021-10-02 06:39:51', '2021-10-02 06:39:51', NULL),
(27, 'advertisement_edit', '2021-10-02 12:28:06', '2021-10-02 12:28:06', NULL),
(28, 'advertisement_delete', '2021-10-02 13:22:30', '2021-10-02 13:22:30', NULL),
(29, 'subscription_create', '2021-10-09 20:57:29', '2021-10-09 20:57:29', NULL),
(30, 'subscription_access', '2021-10-09 20:58:20', '2021-10-09 20:58:20', NULL),
(31, 'subscription_edit', '2021-10-09 20:58:35', '2021-10-09 20:58:35', NULL),
(32, 'subscription_delete', '2021-10-09 20:58:43', '2021-10-09 20:58:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `role_id` int UNSIGNED NOT NULL,
  `permission_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`role_id`, `permission_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15),
(1, 16),
(1, 18),
(1, 19),
(1, 20),
(1, 21),
(1, 22),
(1, 23),
(1, 24),
(1, 25),
(1, 26),
(1, 27),
(1, 28),
(1, 29),
(1, 30),
(1, 31),
(1, 32);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\User', 2, '21631949766', 'adb66621efd545b9aa578776dbc56a00f7eb946173ee642875dc11bd1188fb33', '[\"*\"]', NULL, '2021-09-18 01:52:46', '2021-09-18 01:52:46'),
(2, 'App\\User', 2, '21631949775', 'd6ad236a89d1391ae8b33f386e4a60422c6ca2e204583b3439ec56f9ab312669', '[\"*\"]', NULL, '2021-09-18 01:52:55', '2021-09-18 01:52:55'),
(3, 'App\\User', 2, '21631950518', 'e4850dce1f93f34854f588235dda52dc88680b0572b417a5fb792056657077cc', '[\"*\"]', NULL, '2021-09-18 02:05:18', '2021-09-18 02:05:18');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int NOT NULL,
  `title` varchar(250) NOT NULL,
  `short_description` text,
  `description` longtext,
  `status` varchar(250) NOT NULL,
  `user_id` int NOT NULL,
  `parrent_id` int NOT NULL DEFAULT '0',
  `type` varchar(250) NOT NULL DEFAULT 'post',
  `slug` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `short_description`, `description`, `status`, `user_id`, `parrent_id`, `type`, `slug`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Terms & Conditions', NULL, '<p>Terms &amp; Conditions</p>', 'publish', 1, 0, 'page', 'terms-conditions', '2021-11-06 08:14:19', '2021-11-06 09:39:42', NULL),
(2, 'Privacy Policy', NULL, '<p>Privacy Policy</p>', 'publish', 1, 0, 'page', 'privacy-policy', '2021-11-06 08:19:16', '2021-11-06 08:52:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `title`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', '2019-09-10 08:30:26', '2019-09-10 08:30:26', NULL),
(2, 'User', '2019-09-10 08:30:26', '2019-09-10 08:30:26', NULL),
(3, 'Driver', '2021-09-18 16:03:50', '2021-09-18 16:03:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `user_id` int UNSIGNED NOT NULL,
  `role_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`user_id`, `role_id`) VALUES
(1, 1),
(132, 3),
(133, 2),
(136, 2),
(138, 2),
(139, 2),
(140, 3),
(141, 3),
(142, 3),
(143, 3),
(144, 3),
(145, 3),
(146, 3),
(149, 2),
(150, 3),
(151, 2),
(152, 2),
(153, 2),
(154, 2),
(155, 3),
(156, 3),
(157, 2),
(159, 3),
(160, 2),
(161, 3),
(162, 3),
(163, 3),
(164, 3),
(165, 2),
(166, 3),
(167, 2);

-- --------------------------------------------------------

--
-- Table structure for table `share_route`
--

CREATE TABLE `share_route` (
  `id` int NOT NULL,
  `share_by` int NOT NULL,
  `share_to` int NOT NULL,
  `route_id` int NOT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `status` enum('shared','accepted','rejected') NOT NULL DEFAULT 'shared',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `share_route`
--

INSERT INTO `share_route` (`id`, `share_by`, `share_to`, `route_id`, `date`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 132, 143, 87, NULL, 'accepted', '2021-11-08 15:54:58', '2021-11-08 15:57:56', NULL),
(3, 142, 132, 85, NULL, 'accepted', '2021-11-08 17:01:23', '2021-11-08 18:13:15', NULL),
(4, 147, 148, 89, NULL, 'accepted', '2021-11-10 09:21:32', '2021-11-10 09:23:02', NULL),
(8, 132, 144, 86, '2021-11-25 02:10:21', 'shared', '2021-11-19 20:30:18', '2021-11-19 20:30:18', NULL),
(9, 132, 143, 88, '2021-11-30 00:00:00', 'shared', '2021-11-25 19:40:39', '2021-11-25 19:40:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subscription`
--

CREATE TABLE `subscription` (
  `id` int NOT NULL,
  `title` varchar(250) NOT NULL,
  `description` text,
  `price` varchar(250) NOT NULL,
  `type` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `number` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `subscription`
--

INSERT INTO `subscription` (`id`, `title`, `description`, `price`, `type`, `number`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Free Plan', '<h3><strong>Free Plan</strong></h3>\r\n\r\n<ul>\r\n	<li>It is a long-established</li>\r\n	<li>fact that a reader will be</li>\r\n	<li>distracted by the readable</li>\r\n	<li>content of a page</li>\r\n	<li>when looking at its layout.</li>\r\n</ul>', '0', 'month', 1, '2021-10-09 21:20:26', '2021-11-05 19:23:22', NULL),
(2, '6 Month Plan', '', '25', 'month', 6, '2021-10-09 21:35:58', '2021-11-01 20:21:29', NULL),
(3, '3 Month Plan', '<h3><strong>3 Month Plan</strong></h3>\r\n\r\n<ul>\r\n	<li>It is a long-established</li>\r\n	<li>fact that a reader will be</li>\r\n	<li>distracted by the readable</li>\r\n	<li>content of a page</li>\r\n	<li>when looking at its layout.</li>\r\n	<li>a new point</li>\r\n</ul>', '40', 'month', 3, '2021-10-09 21:36:48', '2021-11-01 20:03:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` bigint DEFAULT NULL,
  `device_id` text COLLATE utf8mb4_unicode_ci,
  `customer_id` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lat` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lng` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  `isEmailVerified` int DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notification_status` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `device_id`, `customer_id`, `lat`, `lng`, `email_verified_at`, `isEmailVerified`, `password`, `remember_token`, `notification_status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', 'admin@admin.com', 0, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$qyxYm.2dlaXROvs0OrGHseo4qbeissRMqNWdhlcr/vUqE62vN94Fi', 'oh5gk7kxYc4BGnM4pkuCKmK4fSAaNmbRSEpGCxmP5udqWgdxjX1K4Oz6frkN', 1, '2019-09-10 08:30:26', '2019-09-10 08:30:26', NULL),
(132, 'Driver Buddy', 'driver@mailinator.com', NULL, '711c1e33f1e4165a', 'cus_KcSupEy3NMqzhh', '26.8102021', '75.6308103', NULL, 1, '$2y$10$HwR5zDCgZn.x/fsnVlEXQej8PEdnHMux/DSP0bGSWx6ADDAOPBpBC', NULL, 1, '2021-11-03 09:21:34', '2021-11-26 18:58:05', NULL),
(133, 'tapan', 'tapang786@gmail.com', NULL, '9e0407b5596e4e4a', NULL, NULL, NULL, NULL, 1, '$2y$10$c/IM02VhB323Eix8e4W.iu.AW/pnxbA5hWGwWQWwkzSl29uQqfnvC', NULL, 1, '2021-11-04 16:10:58', '2021-11-04 16:11:25', NULL),
(136, 'test user', 'test@test.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$uojUAh14hpS0LO5hCuxLYe34X6MtAsWpqUFA3rrItajluJVXXzQHO', NULL, 1, '2021-11-05 20:39:38', '2021-11-05 20:39:38', NULL),
(138, 'test user 2', 'demo@demo1.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$SE4UNzC6CSo0je3zu2MFfOdV8W9VqB4KX8iS6jP0MYhH5piGdT8oi', NULL, 1, '2021-11-05 20:43:13', '2021-11-05 20:43:13', NULL),
(139, 'Miky', 'miky@gmailmiky.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$VJiIb7f12w08Dbsrmof5lusPYoOTvSqtI6/hYJaZc6stVwhfNBwh.', NULL, 1, '2021-11-05 20:52:50', '2021-11-05 20:52:50', NULL),
(140, 'navin', 'goldenstone111@gmail.com', NULL, '711c1e33f1e4165a', NULL, '26.8011499', '75.8622487', NULL, 1, '$2y$10$9xHCx3A3xzeg.LQEdg2mfuzdZahYGftErObmi3DUDbrZiTsmx4NGu', NULL, 1, '2021-11-06 04:07:52', '2021-11-07 15:59:17', NULL),
(141, 'Driver Jess', 'DriverJess@mailinator.com', NULL, '3ef9e794dcc911d5', NULL, '26.8227768', '75.6235365', NULL, 1, '$2y$10$9GZUVg73gBWF1PJZAXhHDuMbsAcTZAjRX9PyXeriwZd/Le5G4im3S', NULL, 1, '2021-11-06 14:34:55', '2021-11-06 16:32:08', NULL),
(142, 'Jess Driver', 'jd@mailinator.com', NULL, '3ef9e794dcc911d5', NULL, '26.8205695', '75.6175089', NULL, 1, '$2y$10$qlLF83DvGQ9q24Nd6gkHP.rgemC/P8KqVwF2EonWa3HRFvZBRyPFW', NULL, 1, '2021-11-06 14:35:27', '2021-11-08 17:01:09', NULL),
(143, 'Derek Driver', 'dd@mailinator.com', NULL, '3ef9e794dcc911d5', NULL, '26.8255673', '75.619172', NULL, 1, '$2y$10$zW/72hHCFuCCSVX/J791JuVdu5EZGd7WFKL6DfD8/sfi.nWw3JwVy', NULL, 1, '2021-11-06 14:35:41', '2021-11-06 17:33:20', NULL),
(144, 'Karan', 'driver@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$gX.k57DWExTU9YP9qv67LuP9Du4So93YNaix3/NMvxi37pY6VJZ1G', NULL, 1, '2021-11-06 15:39:26', '2021-11-19 20:20:16', NULL),
(145, 'Raj Kumar', 'driver@gmail1.com', 8978978978, NULL, NULL, '2343', '7437', NULL, NULL, '$2y$10$aq4t2ASE5gyfErHrG4lQne3sg1.nVROX6q4ZLRoSDIkOLt1.g9xuW', NULL, 0, '2021-11-06 15:46:18', '2021-11-06 16:01:34', NULL),
(146, 'Aron', 'aron@mailinator.com', NULL, '3ef9e794dcc911d5', NULL, '26.8210581', '75.6173534', NULL, 1, '$2y$10$iJGHajZr4XVGLBnJfw1PlufmUe1ZYLD/XYcozyewE7pslYy8euEWS', NULL, 1, '2021-11-06 19:13:51', '2021-11-25 17:59:51', NULL),
(149, 'Vishwas K', 'vishwas_kumar_er@yahoo.co.in', NULL, 'c391c2f4cabec739', NULL, '28.6142571', '77.4254766', NULL, 1, '$2y$10$C5hoauxxFdir.FfxZPLt7eWzagKBqJyuatEK2ubj2kvcrHbI1Vkf2', NULL, 1, '2021-11-10 18:00:15', '2021-11-25 18:18:04', NULL),
(150, 'VKV', 'coolvish19862000@gmail.com', NULL, 'c391c2f4cabec739', NULL, NULL, NULL, NULL, 1, '$2y$10$G2CYpeRZ0JzyqqbzLl2.sOouvSKURIvdxVg3H6inJVk8Ycztxvsea', NULL, 1, '2021-11-10 18:19:28', '2021-11-13 15:48:10', NULL),
(151, 'Neha Sharma', 'lx.neha.sharma@gmail.com', NULL, '9e0407b5596e4e4a', 'cus_KaaeWrb88iKZMv', NULL, NULL, NULL, 1, '$2y$10$HvnvuwjrmfIzyyoNwXIP4uFYQyijBvCwQLogs9l5RS7TA/uzxuol2', NULL, 1, '2021-11-13 06:10:22', '2021-11-13 16:53:03', NULL),
(152, 'VKP', 'verma.poonam233@gmail.com', NULL, '510635cfef65ef24', NULL, '28.6149056', '77.425802', NULL, 1, '$2y$10$3rF7/raAoN.PrYGVDlRWfeUeOE4/oM1ib7qnl02tSPDJhD/DqEn6C', NULL, 1, '2021-11-13 16:01:10', '2021-11-13 16:44:51', NULL),
(153, 'VKR', 'manyaverma214@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$ONb2OnV/cZSacQVmpaTfxu6td06kUhhurSmMZkKTuV2ctR2eTshuK', NULL, 1, '2021-11-13 16:47:26', '2021-11-13 16:47:26', NULL),
(154, 'VKR', 'manyaverma2014@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$GqmQPLULuwAC2PpKN8u8rOIwfc1SQjGhMhps.qRlqufc66lgRRWNa', NULL, 1, '2021-11-13 16:48:52', '2021-11-13 16:48:52', NULL),
(155, 'vks', 'bhargavseema13@gmail.com', NULL, '510635cfef65ef24', NULL, '28.6149088', '77.4258127', NULL, 1, '$2y$10$prkwla1YNr1/PxepvWKU1OPXv9NyyNq8JTvxcRfTV90YC2oYDWKGC', NULL, 1, '2021-11-13 16:54:02', '2021-11-13 18:15:45', NULL),
(156, 'bravo', 'bravo@mailinator.com', NULL, '3ef9e794dcc911d5', NULL, '26.8102021', '75.6308103', NULL, 1, '$2y$10$0.o8b3sBYKvZP3ZhpnTE3uQ6tcaDuDUIBDT5NFJX9m9Hx4hgJWYM6', NULL, 1, '2021-11-25 20:11:58', '2021-11-26 15:37:57', NULL),
(157, 'susain', 'androidwithseemant@gmail.com', NULL, '1b8156c20db86a2e', NULL, '28.655316', '77.4517241', NULL, 1, '$2y$10$L8kGDnSSHtW4tWETZwgRtutt3OT2wfpH2w45VrR6/JRhfh5XxLOui', NULL, 1, '2021-11-26 05:09:08', '2021-11-27 02:34:57', NULL),
(159, 'sam driver', 'seemantsharma001@gmail.com', NULL, '1b8156c20db86a2e', NULL, NULL, NULL, NULL, 1, '$2y$10$3P9PTuNheydwfr7KZkVehOupkCD.btUU1X7f1f51KZkXzQYyZ6m2q', NULL, 1, '2021-11-26 05:16:02', '2021-11-27 02:36:16', NULL),
(160, 'User Bravo', 'ub@mailinator.com', NULL, '3ef9e794dcc911d5', 'cus_KfUOXrq5ExpT7n', NULL, NULL, NULL, 1, '$2y$10$fJdCNkjArz72xphu5eLgY.4QFPUjz2UZKMsh8M75NIJmK9sXsS7f2', NULL, 1, '2021-11-26 18:04:33', '2021-11-26 18:44:26', NULL),
(161, 'Calo', 'calo@mailinator.com', NULL, '3ef9e794dcc911d5', NULL, NULL, NULL, NULL, 1, '$2y$10$325.katVr66VTtL05qkyv.G6u0f00mXDji0YTvCP6DqmWEFQruBVe', NULL, 1, '2021-11-26 19:01:17', '2021-11-26 19:01:44', NULL),
(162, 'calo driver', 'cd@mailinator.com', NULL, '3ef9e794dcc911d5', NULL, NULL, NULL, NULL, 1, '$2y$10$nIFCGhZD5LWNVF89eF.xB.w3MMMVPMtryp5ge4nw3s/zCI6h8rmFi', NULL, 1, '2021-11-26 19:02:51', '2021-11-26 19:03:14', NULL),
(163, 'DDD', 'ddd@mailinator.com', NULL, '3ef9e794dcc911d5', NULL, NULL, NULL, NULL, 1, '$2y$10$ZijiApHlTHwCezwMUay6qO6hN.SIsfF8UXy.uhI47cpbZGhPS.b3i', NULL, 1, '2021-11-26 19:08:52', '2021-11-26 19:09:15', NULL),
(164, 'kkk', 'kkk@mailinator.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$grU4kyPFb2XWCP7FOaZkfuupkaqn1DI1CqszxylDV.NvyltlxwR4a', NULL, 1, '2021-11-26 19:13:10', '2021-11-26 19:13:10', NULL),
(165, 'kkkk', 'kkkk@mailinator.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$ZOAFjGOs.DGzh.Gwp4/B7eqWVBikrh2qJm3C8tZdbUVTtJNbY7TeC', NULL, 1, '2021-11-26 19:15:45', '2021-11-26 19:15:45', NULL),
(166, 'Draw', 'Draw@mailinator.com', NULL, '3ef9e794dcc911d5', NULL, NULL, NULL, NULL, 1, '$2y$10$kbXmI4/edbR4QD0b7539pO0oeMjBFiy0vqf1bPAEOFm5pXzL3mWQe', NULL, 1, '2021-11-26 19:16:08', '2021-11-26 19:16:37', NULL),
(167, 'Bro', 'bro@mailinator.com', NULL, '3ef9e794dcc911d5', NULL, NULL, NULL, NULL, 1, '$2y$10$LljfqIBqkd75EYv08olJieaGNBJEMftivdAsVTCkxZlMO5ssr7hM6', NULL, 1, '2021-11-26 19:18:13', '2021-11-26 19:18:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_cards`
--

CREATE TABLE `user_cards` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `user_customer_id` varchar(250) NOT NULL,
  `card_token` varchar(250) NOT NULL,
  `status` int NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_cards`
--

INSERT INTO `user_cards` (`id`, `user_id`, `user_customer_id`, `card_token`, `status`, `created_at`, `updated_at`) VALUES
(1, 151, 'cus_KaaeWrb88iKZMv', 'card_1JvPptItQT8ZzyO1Vmhx9w2k', 0, '2021-11-13 17:16:18', '2021-11-13 17:16:18'),
(2, 151, 'cus_KaaeWrb88iKZMv', 'card_1JvQ68ItQT8ZzyO19u4X6CPA', 0, '2021-11-13 17:33:05', '2021-11-13 17:33:05'),
(3, 151, 'cus_KaaeWrb88iKZMv', 'card_1JvQAmItQT8ZzyO1HFpuBGay', 0, '2021-11-13 17:37:53', '2021-11-13 17:37:53'),
(4, 151, 'cus_KaaeWrb88iKZMv', 'card_1JvQB9ItQT8ZzyO1cVG2LYnb', 0, '2021-11-13 17:38:16', '2021-11-13 17:38:16'),
(5, 151, 'cus_KaaeWrb88iKZMv', 'card_1JvRSAItQT8ZzyO11Wv9NJwG', 0, '2021-11-13 18:59:55', '2021-11-13 18:59:55'),
(6, 151, 'cus_KaaeWrb88iKZMv', 'card_1JvReWItQT8ZzyO1pjkmVzzZ', 0, '2021-11-13 19:12:41', '2021-11-13 19:12:41'),
(7, 151, 'cus_KaaeWrb88iKZMv', 'card_1JvSALItQT8ZzyO1fGLLsGam', 0, '2021-11-13 19:45:35', '2021-11-13 19:45:35'),
(8, 132, 'cus_KcSupEy3NMqzhh', 'card_1JxGQjItQT8ZzyO1WibBWDKZ', 0, '2021-11-18 19:37:58', '2021-11-18 19:37:58'),
(9, 132, 'cus_KcSupEy3NMqzhh', 'card_1JxGfrItQT8ZzyO1L9SuyB22', 0, '2021-11-18 19:53:36', '2021-11-18 19:53:36'),
(10, 132, 'cus_KcSupEy3NMqzhh', 'card_1JxGv2ItQT8ZzyO1eiywdnih', 0, '2021-11-18 20:09:17', '2021-11-18 20:09:17');

-- --------------------------------------------------------

--
-- Table structure for table `user_login_devices`
--

CREATE TABLE `user_login_devices` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `device_id` text NOT NULL,
  `is_remember` int NOT NULL,
  `ceated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_meta`
--

CREATE TABLE `user_meta` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `key` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_meta`
--

INSERT INTO `user_meta` (`id`, `user_id`, `key`, `value`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 139, 'profile_pic', 'images/1636146419_139_home-office1.jpeg', '2021-11-05 20:52:50', '2021-11-05 21:06:59', NULL),
(2, 140, 'profile_pic', 'images/618641428bf51_140_userprofile.jpg', '2021-11-06 04:12:16', '2021-11-06 08:48:02', NULL),
(3, 136, 'profile_pic', 'images/1636180471_136_BBDTipSheet_mainbanner.jpg', '2021-11-06 06:34:31', '2021-11-06 06:34:31', NULL),
(4, 132, 'profile_pic', 'images/619d0909d7f33_132_userprofile.jpg', '2021-11-06 12:37:34', '2021-11-23 15:30:17', NULL),
(5, 132, 'city', 'Jersey City', '2021-11-06 15:03:27', '2021-11-06 18:09:16', NULL),
(6, 145, 'profile_pic', 'images/6186bbf273dc7_145_userprofile.jpg', '2021-11-06 16:00:56', '2021-11-06 17:31:30', NULL),
(7, 145, 'address', 'jaipur, Rajasthan', '2021-11-06 16:00:56', '2021-11-06 16:00:56', NULL),
(8, 145, 'age', '36', '2021-11-06 16:00:56', '2021-11-06 16:00:56', NULL),
(9, 145, 'gender', 'male', '2021-11-06 16:00:56', '2021-11-06 16:00:56', NULL),
(10, 145, 'dob', '1994-08-25', '2021-11-06 16:00:56', '2021-11-06 16:00:56', NULL),
(11, 145, 'online', '1', '2021-11-06 16:00:56', '2021-11-06 17:31:30', NULL),
(12, 142, 'city', 'Jaipur', '2021-11-06 16:12:38', '2021-11-06 16:12:38', NULL),
(13, 142, 'lat', '26.9143', '2021-11-06 16:12:38', '2021-11-06 16:12:38', NULL),
(14, 142, 'lng', '75.8068', '2021-11-06 16:12:38', '2021-11-06 16:12:38', NULL),
(15, 142, 'profile_pic', 'images/6186b9028c0b3_142_userprofile.jpg', '2021-11-06 16:30:35', '2021-11-06 17:18:58', NULL),
(16, 141, 'profile_pic', 'images/6186ae08071c3_141_userprofile.jpg', '2021-11-06 16:32:08', '2021-11-06 16:32:08', NULL),
(17, 132, 'remember_devices', '[\"3ef9e794dcc911d5\",\"711c1e33f1e4165a\"]', '2021-11-06 16:35:10', '2021-11-07 16:00:54', NULL),
(18, 142, 'remember_devices', '[\"3ef9e794dcc911d5\"]', '2021-11-06 16:36:01', '2021-11-06 16:36:01', NULL),
(19, 141, 'remember_devices', '[\"3ef9e794dcc911d5\"]', '2021-11-06 16:37:04', '2021-11-06 16:37:04', NULL),
(20, 143, 'remember_devices', '[\"3ef9e794dcc911d5\"]', '2021-11-06 16:37:57', '2021-11-06 16:37:57', NULL),
(21, 143, 'profile_pic', 'images/6186af8069bf0_143_userprofile.jpg', '2021-11-06 16:38:24', '2021-11-06 16:38:24', NULL),
(22, 145, 'city', 'jaipur', '2021-11-06 17:23:36', '2021-11-06 17:31:30', NULL),
(23, 146, 'remember_devices', '[\"3ef9e794dcc911d5\"]', '2021-11-06 19:14:25', '2021-11-06 19:14:25', NULL),
(24, 146, 'profile_pic', 'images/6186d42e7b0ce_146_userprofile.jpg', '2021-11-06 19:14:41', '2021-11-06 19:14:54', NULL),
(25, 146, 'city', 'Los Angeles', '2021-11-06 19:14:41', '2021-11-06 19:14:41', NULL),
(26, 147, 'remember_devices', '[\"f48cd69c8cd09857\"]', '2021-11-07 07:50:22', '2021-11-07 07:50:22', NULL),
(27, 147, 'profile_pic', 'images/6187855127056_147_userprofile.jpg', '2021-11-07 07:50:41', '2021-11-07 07:50:41', NULL),
(28, 147, 'city', 'Houston', '2021-11-07 07:50:41', '2021-11-07 07:50:41', NULL),
(29, 140, 'remember_devices', '[\"711c1e33f1e4165a\"]', '2021-11-07 12:38:21', '2021-11-07 12:38:21', NULL),
(30, 148, 'remember_devices', '[\"f4056ac11fde7d55\"]', '2021-11-10 06:21:15', '2021-11-10 06:21:15', NULL),
(31, 148, 'profile_pic', 'images/618b6531d19b1_148_userprofile.jpg', '2021-11-10 06:22:41', '2021-11-10 06:22:41', NULL),
(32, 148, 'city', 'Los Angeles', '2021-11-10 06:22:41', '2021-11-10 06:22:41', NULL),
(33, 149, 'profile_pic', 'images/618c0a4397fb3_149_userprofile.jpg', '2021-11-10 18:06:16', '2021-11-10 18:06:59', NULL),
(34, 149, 'city', 'Chicago', '2021-11-10 18:06:16', '2021-11-10 18:06:59', NULL),
(35, 150, 'profile_pic', 'images/618fe1706a062_150_userprofile.jpg', '2021-11-10 18:20:22', '2021-11-13 16:01:52', NULL),
(36, 150, 'city', 'Las Vegas', '2021-11-10 18:20:22', '2021-11-13 15:50:02', NULL),
(37, 150, 'remember_devices', '[\"c391c2f4cabec739\"]', '2021-11-10 18:27:31', '2021-11-10 18:27:31', NULL),
(38, 133, 'profile_pic', 'images/618e24b9e90a4_133_userprofile.jpg', '2021-11-12 08:24:25', '2021-11-12 08:24:25', NULL),
(39, 151, 'profile_pic', 'images/618f5780a25f1_151_userprofile.jpg', '2021-11-13 06:13:20', '2021-11-13 06:13:20', NULL),
(40, 152, 'remember_devices', '[\"510635cfef65ef24\"]', '2021-11-13 16:01:36', '2021-11-13 16:01:36', NULL),
(41, 152, 'profile_pic', 'images/618fe17bc7fe4_152_userprofile.jpg', '2021-11-13 16:02:03', '2021-11-13 16:02:03', NULL),
(42, 152, 'city', 'Las Vegas', '2021-11-13 16:02:03', '2021-11-13 16:02:03', NULL),
(43, 149, 'remember_devices', '[\"c391c2f4cabec739\"]', '2021-11-13 16:33:14', '2021-11-13 16:33:14', NULL),
(44, 155, 'remember_devices', '[\"510635cfef65ef24\"]', '2021-11-13 16:54:25', '2021-11-13 16:54:25', NULL),
(45, 155, 'profile_pic', 'images/618fedcdb1607_155_userprofile.jpg', '2021-11-13 16:54:37', '2021-11-13 16:54:37', NULL),
(46, 155, 'city', 'Las Vegas', '2021-11-13 16:54:37', '2021-11-13 16:54:37', NULL),
(47, 156, 'profile_pic', 'images/619fee4c9ca4b_156_userprofile.jpg', '2021-11-25 20:13:00', '2021-11-25 20:13:00', NULL),
(48, 156, 'city', 'Chicago', '2021-11-25 20:13:00', '2021-11-25 20:13:00', NULL),
(49, 157, 'remember_devices', '[\"f48cd69c8cd09857\",\"1b8156c20db86a2e\"]', '2021-11-26 05:09:31', '2021-11-27 02:34:57', NULL),
(50, 157, 'profile_pic', 'images/61a06c1ac5305_157_userprofile.jpg', '2021-11-26 05:09:46', '2021-11-26 05:09:46', NULL),
(51, 157, 'city', 'Chicago', '2021-11-26 05:09:46', '2021-11-26 05:09:46', NULL),
(52, 158, 'remember_devices', '[\"f48cd69c8cd09857\"]', '2021-11-26 05:12:48', '2021-11-26 05:12:48', NULL),
(53, 158, 'profile_pic', 'images/61a06cd9ebccb_158_userprofile.jpg', '2021-11-26 05:12:57', '2021-11-26 05:12:57', NULL),
(54, 158, 'city', 'Houston', '2021-11-26 05:12:57', '2021-11-26 05:12:57', NULL),
(55, 159, 'remember_devices', '[\"f48cd69c8cd09857\",\"1b8156c20db86a2e\"]', '2021-11-26 05:16:47', '2021-11-27 02:36:16', NULL),
(56, 159, 'profile_pic', 'images/61a06dc874683_159_userprofile.jpg', '2021-11-26 05:16:56', '2021-11-26 05:16:56', NULL),
(57, 159, 'city', 'Chicago', '2021-11-26 05:16:56', '2021-11-26 05:16:56', NULL),
(58, 156, 'remember_devices', '[\"3ef9e794dcc911d5\"]', '2021-11-26 15:26:49', '2021-11-26 15:26:49', NULL),
(59, 160, 'remember_devices', '[\"3ef9e794dcc911d5\"]', '2021-11-26 18:05:08', '2021-11-26 18:05:08', NULL),
(60, 160, 'profile_pic', 'images/61a12297a6142_160_userprofile.jpg', '2021-11-26 18:08:23', '2021-11-26 18:08:23', NULL),
(61, 160, 'city', 'Los Angeles', '2021-11-26 18:08:23', '2021-11-26 18:08:23', NULL),
(62, 161, 'profile_pic', 'images/61a12f275cc3f_161_userprofile.jpg', '2021-11-26 19:01:59', '2021-11-26 19:01:59', NULL),
(63, 161, 'city', 'Los Angeles', '2021-11-26 19:01:59', '2021-11-26 19:01:59', NULL),
(64, 162, 'remember_devices', '[\"3ef9e794dcc911d5\"]', '2021-11-26 19:03:14', '2021-11-26 19:03:14', NULL),
(65, 162, 'profile_pic', 'images/61a12f7b0d737_162_userprofile.jpg', '2021-11-26 19:03:23', '2021-11-26 19:03:23', NULL),
(66, 162, 'city', 'Phoenix', '2021-11-26 19:03:23', '2021-11-26 19:03:23', NULL),
(67, 161, 'remember_devices', '[\"3ef9e794dcc911d5\"]', '2021-11-26 19:08:04', '2021-11-26 19:08:04', NULL),
(68, 163, 'remember_devices', '[\"3ef9e794dcc911d5\"]', '2021-11-26 19:09:15', '2021-11-26 19:09:15', NULL),
(69, 163, 'profile_pic', 'images/61a130e9c4da7_163_userprofile.jpg', '2021-11-26 19:09:29', '2021-11-26 19:09:29', NULL),
(70, 163, 'city', 'Houston', '2021-11-26 19:09:29', '2021-11-26 19:09:29', NULL),
(71, 166, 'remember_devices', '[\"3ef9e794dcc911d5\"]', '2021-11-26 19:16:37', '2021-11-26 19:16:37', NULL),
(72, 166, 'profile_pic', 'images/61a132b74d72a_166_userprofile.jpg', '2021-11-26 19:17:11', '2021-11-26 19:17:11', NULL),
(73, 166, 'city', 'Long Beach', '2021-11-26 19:17:11', '2021-11-26 19:17:11', NULL),
(74, 167, 'remember_devices', '[\"3ef9e794dcc911d5\"]', '2021-11-26 19:18:46', '2021-11-26 19:18:46', NULL),
(75, 167, 'profile_pic', 'images/61a13323396b2_167_userprofile.jpg', '2021-11-26 19:18:59', '2021-11-26 19:18:59', NULL),
(76, 167, 'city', 'Houston', '2021-11-26 19:18:59', '2021-11-26 19:18:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_subscription`
--

CREATE TABLE `user_subscription` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `subscription_id` int NOT NULL,
  `title` varchar(250) NOT NULL,
  `description` text,
  `price` float NOT NULL,
  `start_date` timestamp NOT NULL,
  `end_date` timestamp NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_subscription`
--

INSERT INTO `user_subscription` (`id`, `user_id`, `subscription_id`, `title`, `description`, `price`, `start_date`, `end_date`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 133, 3, '3 Month Plan', '3 Month Plan', 40, '2021-11-01 01:18:49', '2022-02-01 01:18:49', '2021-11-01 20:23:03', '2021-11-01 20:23:03', NULL),
(2, 135, 2, '6 Month Plan', '', 25, '2021-11-05 20:12:35', '2022-05-05 20:12:35', '2021-11-05 19:29:18', '2021-11-05 20:12:35', NULL),
(3, 136, 3, '3 Month Plan', '<h3><strong>3 Month Plan</strong></h3>\r\n\r\n<ul>\r\n	<li>It is a long-established</li>\r\n	<li>fact that a reader will be</li>\r\n	<li>distracted by the readable</li>\r\n	<li>content of a page</li>\r\n	<li>when looking at its layout.</li>\r\n	<li>a new point</li>\r\n</ul>', 40, '2021-11-06 06:34:36', '2022-02-06 06:34:36', '2021-11-05 20:39:38', '2021-11-06 06:34:36', NULL),
(4, 137, 1, 'Free Plan', '<h3><strong>Free Plan</strong></h3>\r\n\r\n<ul>\r\n	<li>It is a long-established</li>\r\n	<li>fact that a reader will be</li>\r\n	<li>distracted by the readable</li>\r\n	<li>content of a page</li>\r\n	<li>when looking at its layout.</li>\r\n</ul>', 0, '2021-11-05 20:42:26', '2021-12-05 20:42:26', '2021-11-05 20:42:26', '2021-11-05 20:42:26', NULL),
(5, 138, 1, 'Free Plan', '<h3><strong>Free Plan</strong></h3>\r\n\r\n<ul>\r\n	<li>It is a long-established</li>\r\n	<li>fact that a reader will be</li>\r\n	<li>distracted by the readable</li>\r\n	<li>content of a page</li>\r\n	<li>when looking at its layout.</li>\r\n</ul>', 0, '2021-11-05 20:43:13', '2021-12-05 20:43:13', '2021-11-05 20:43:13', '2021-11-05 20:43:13', NULL),
(6, 139, 1, 'Free Plan', '<h3><strong>Free Plan</strong></h3>\r\n\r\n<ul>\r\n	<li>It is a long-established</li>\r\n	<li>fact that a reader will be</li>\r\n	<li>distracted by the readable</li>\r\n	<li>content of a page</li>\r\n	<li>when looking at its layout.</li>\r\n</ul>', 0, '2021-11-05 21:06:59', '2021-12-05 21:06:59', '2021-11-05 20:52:50', '2021-11-05 21:06:59', NULL),
(7, 151, 2, '6 Month Plan', '', 25, '2021-11-13 20:22:21', '2022-05-13 20:22:21', '2021-11-13 16:50:13', '2021-11-13 20:22:21', NULL),
(8, 132, 2, '6 Month Plan', '', 25, '2021-11-18 20:09:19', '2022-05-18 20:09:19', '2021-11-18 19:38:00', '2021-11-18 20:09:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_verifications_token`
--

CREATE TABLE `user_verifications_token` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `otp` int NOT NULL,
  `expire` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `type` enum('forget_password','registration_otp','phone') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_verifications_token`
--

INSERT INTO `user_verifications_token` (`id`, `user_id`, `otp`, `type`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 69, 249420, 'registration_otp', '2021-09-29 05:48:12', '2021-09-29 05:48:12', NULL),
(2, 70, 772793, 'registration_otp', '2021-09-29 05:49:11', '2021-09-29 05:49:11', NULL),
(3, 71, 158531, 'registration_otp', '2021-09-29 05:55:42', '2021-09-29 05:55:42', NULL),
(4, 72, 335109, 'registration_otp', '2021-09-29 05:57:53', '2021-09-29 05:57:53', NULL),
(5, 73, 911929, 'registration_otp', '2021-09-29 06:04:23', '2021-09-29 06:04:23', NULL),
(6, 74, 589390, 'registration_otp', '2021-09-29 06:11:32', '2021-09-29 06:11:32', NULL),
(7, 75, 420163, 'registration_otp', '2021-09-29 06:13:30', '2021-09-29 06:13:30', NULL),
(8, 76, 974062, 'registration_otp', '2021-09-29 06:21:38', '2021-09-29 06:21:38', NULL),
(9, 77, 687358, 'registration_otp', '2021-09-29 06:22:22', '2021-09-29 06:22:22', NULL),
(10, 78, 796168, 'registration_otp', '2021-09-29 06:24:36', '2021-09-29 06:24:36', NULL),
(11, 79, 101323, 'registration_otp', '2021-09-29 06:28:05', '2021-09-29 06:28:05', NULL),
(12, 80, 434173, 'registration_otp', '2021-09-29 06:34:06', '2021-09-29 06:34:06', NULL),
(13, 81, 529984, 'registration_otp', '2021-09-29 06:34:40', '2021-09-29 06:34:40', NULL),
(14, 82, 388734, 'registration_otp', '2021-09-29 06:36:11', '2021-09-29 06:36:11', NULL),
(15, 83, 378479, 'registration_otp', '2021-09-29 06:37:53', '2021-09-29 06:37:53', NULL),
(23, 20, 240488, 'forget_password', '2021-09-29 17:22:31', '2021-09-29 17:22:31', NULL),
(38, 99, 150412, 'registration_otp', '2021-09-29 19:28:38', '2021-09-29 19:28:38', NULL),
(47, 100, 310182, 'forget_password', '2021-09-30 05:06:51', '2021-09-30 05:06:51', NULL),
(56, 105, 713176, 'registration_otp', '2021-10-12 15:06:48', '2021-10-12 15:06:48', NULL),
(57, 106, 361501, 'registration_otp', '2021-10-12 15:07:27', '2021-10-12 15:07:27', NULL),
(76, 114, 449115, 'registration_otp', '2021-10-20 12:50:05', '2021-10-20 12:50:05', NULL),
(81, 116, 408506, 'registration_otp', '2021-10-22 16:28:37', '2021-10-22 16:28:37', NULL),
(85, 120, 990199, 'registration_otp', '2021-10-23 17:39:20', '2021-10-23 17:39:20', NULL),
(87, 121, 126263, 'registration_otp', '2021-10-23 18:49:44', '2021-10-23 18:49:44', NULL),
(88, 122, 574104, 'registration_otp', '2021-10-24 10:13:34', '2021-10-24 10:13:34', NULL),
(121, 144, 370632, 'registration_otp', '2021-11-06 15:39:26', '2021-11-06 15:39:26', NULL),
(122, 145, 353175, 'registration_otp', '2021-11-06 15:46:18', '2021-11-06 15:46:18', NULL),
(138, 153, 117518, 'registration_otp', '2021-11-13 16:47:26', '2021-11-13 16:48:38', NULL),
(139, 154, 591087, 'registration_otp', '2021-11-13 16:48:52', '2021-11-13 16:50:25', NULL),
(151, 164, 380341, 'registration_otp', '2021-11-26 19:13:10', '2021-11-26 19:13:10', NULL),
(152, 165, 756641, 'registration_otp', '2021-11-26 19:15:45', '2021-11-26 19:15:45', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `advertisement`
--
ALTER TABLE `advertisement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `driver_current_route`
--
ALTER TABLE `driver_current_route`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `driver_friends`
--
ALTER TABLE `driver_friends`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `driver_routes`
--
ALTER TABLE `driver_routes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mail_templates`
--
ALTER TABLE `mail_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD KEY `role_id_fk_6744` (`role_id`),
  ADD KEY `permission_id_fk_6744` (`permission_id`);

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
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD KEY `user_id_fk_6753` (`user_id`),
  ADD KEY `role_id_fk_6753` (`role_id`);

--
-- Indexes for table `share_route`
--
ALTER TABLE `share_route`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscription`
--
ALTER TABLE `subscription`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_cards`
--
ALTER TABLE `user_cards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_login_devices`
--
ALTER TABLE `user_login_devices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_meta`
--
ALTER TABLE `user_meta`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_subscription`
--
ALTER TABLE `user_subscription`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_verifications_token`
--
ALTER TABLE `user_verifications_token`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `advertisement`
--
ALTER TABLE `advertisement`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `driver_current_route`
--
ALTER TABLE `driver_current_route`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `driver_friends`
--
ALTER TABLE `driver_friends`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `driver_routes`
--
ALTER TABLE `driver_routes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `mail_templates`
--
ALTER TABLE `mail_templates`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `share_route`
--
ALTER TABLE `share_route`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `subscription`
--
ALTER TABLE `subscription`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=168;

--
-- AUTO_INCREMENT for table `user_cards`
--
ALTER TABLE `user_cards`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_login_devices`
--
ALTER TABLE `user_login_devices`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_meta`
--
ALTER TABLE `user_meta`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `user_subscription`
--
ALTER TABLE `user_subscription`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_verifications_token`
--
ALTER TABLE `user_verifications_token`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_id_fk_6744` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_id_fk_6744` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_id_fk_6753` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_id_fk_6753` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
