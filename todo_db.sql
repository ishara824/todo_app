-- Adminer 4.8.1 MySQL 5.6.23 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE DATABASE `todo_db` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `todo_db`;

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `failed_jobs`;

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `jobs`;

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `migrations`;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1,	'2014_10_12_000000_create_users_table',	1),
(2,	'2014_10_12_100000_create_password_resets_table',	1),
(3,	'2019_08_19_000000_create_failed_jobs_table',	1),
(4,	'2019_12_14_000001_create_personal_access_tokens_table',	1),
(5,	'2022_10_05_155909_create_todo_lists_table',	1),
(6,	'2022_10_06_051700_create_todo_items_table',	1),
(7,	'2022_10_08_165706_create_jobs_table',	1);

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `password_resets`;

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `personal_access_tokens`;
INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1,	'App\\Models\\User',	1,	'MyApp',	'c6e2f0e096c9f9aa014da406e969f1012fecd6dc8a096edc230fbe302af1deaf',	'[\"*\"]',	NULL,	NULL,	'2022-10-09 13:19:42',	'2022-10-09 13:19:42'),
(2,	'App\\Models\\User',	1,	'MyApp',	'd17a177c96eae690c5dc168b348b7b8a707d2f539d2948c9a947fed8e26456d9',	'[\"*\"]',	NULL,	NULL,	'2022-10-09 13:19:53',	'2022-10-09 13:19:53'),
(3,	'App\\Models\\User',	2,	'MyApp',	'9c91018f63d28bb4613c1514f53a8605e950ec026768831173d449444ee66bf7',	'[\"*\"]',	NULL,	NULL,	'2022-10-09 13:31:41',	'2022-10-09 13:31:41'),
(4,	'App\\Models\\User',	2,	'MyApp',	'f4b8236ec5e0f3e03d7159412255dbf225d2106adc4edfb2c59624bb6b8f1cba',	'[\"*\"]',	NULL,	NULL,	'2022-10-09 13:31:53',	'2022-10-09 13:31:53'),
(5,	'App\\Models\\User',	1,	'MyApp',	'2ee6a163839acb050aa4fae1daac9415121cc04c14b680ddd4d29135f46133d3',	'[\"*\"]',	NULL,	NULL,	'2022-10-09 15:12:49',	'2022-10-09 15:12:49');

DROP TABLE IF EXISTS `todo_items`;
CREATE TABLE `todo_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `todo_list_id` bigint(20) unsigned NOT NULL,
  `item_description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `due_time` time DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_by` bigint(20) unsigned NOT NULL,
  `updated_by` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `todo_items`;
INSERT INTO `todo_items` (`id`, `todo_list_id`, `item_description`, `due_date`, `due_time`, `completed_at`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1,	1,	'Task one update',	'2022-10-09',	'19:52:00',	NULL,	1,	1,	1,	'2022-10-09 13:20:58',	'2022-10-09 13:22:25'),
(2,	1,	'task two',	'2022-10-09',	'19:55:00',	'2022-10-09 13:23:54',	2,	1,	1,	'2022-10-09 13:23:15',	'2022-10-09 13:23:54'),
(3,	1,	'task three',	'2022-10-09',	'19:58:00',	'2022-10-09 13:25:29',	2,	1,	1,	'2022-10-09 13:25:18',	'2022-10-09 13:25:29'),
(4,	3,	'task 1 for admin2',	'2022-10-09',	'20:03:00',	NULL,	1,	2,	2,	'2022-10-09 13:32:58',	'2022-10-09 13:32:58');

DROP TABLE IF EXISTS `todo_lists`;
CREATE TABLE `todo_lists` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) unsigned NOT NULL,
  `updated_by` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `todo_lists`;
INSERT INTO `todo_lists` (`id`, `description`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1,	'Task List One',	1,	1,	'2022-10-09 13:20:05',	'2022-10-09 13:20:05'),
(2,	'Task List Two',	1,	1,	'2022-10-09 13:20:23',	'2022-10-09 13:20:23'),
(3,	'Task List one (admin2)',	2,	2,	'2022-10-09 13:32:17',	'2022-10-09 13:32:17'),
(4,	'Task List two (admin2)',	2,	2,	'2022-10-09 13:32:37',	'2022-10-09 13:32:37');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE `users`;
INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `phone_number`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1,	'Admin',	'Admin',	'ishara824@outlook.com',	'1212121212',	NULL,	'$2y$10$v//LHQNjjAXQqh7fLdym4uCHM/esyGbqnOS4mT87/2jFTHX0H8MEa',	NULL,	'2022-10-09 13:19:42',	'2022-10-09 13:19:42'),
(2,	'AdminTwo',	'AdminTwo',	'admin2@admin.com',	'3232323232',	NULL,	'$2y$10$GGj0XDn87qNZN1oUDfgmjOpRX2Yg8esVh8B1EhqqR/JjcykETrEj2',	NULL,	'2022-10-09 13:31:41',	'2022-10-09 13:31:41');

-- 2022-10-09 15:14:38
