/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `ch_favorites` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint NOT NULL,
  `favorite_id` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `ch_messages` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_id` bigint NOT NULL,
  `to_id` bigint NOT NULL,
  `body` varchar(5000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `chats` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `message_at` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `post_admin_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `chats_user_id_foreign` (`user_id`),
  KEY `chats_post_admin_id_foreign` (`post_admin_id`),
  CONSTRAINT `chats_post_admin_id_foreign` FOREIGN KEY (`post_admin_id`) REFERENCES `post_admins` (`id`) ON DELETE CASCADE,
  CONSTRAINT `chats_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `comments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `post_id` bigint unsigned NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `comment_at` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parent_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_user_id_foreign` (`user_id`),
  KEY `comments_post_id_foreign` (`post_id`),
  KEY `comments_parent_id_foreign` (`parent_id`),
  CONSTRAINT `comments_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `post_admins` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `is_active` tinyint(1) NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `post_id` bigint unsigned NOT NULL,
  `about` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `post_admins_user_id_foreign` (`user_id`),
  KEY `post_admins_post_id_foreign` (`post_id`),
  CONSTRAINT `post_admins_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `post_admins_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `post_users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `is_active` tinyint(1) NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `post_id` bigint unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `post_users_user_id_foreign` (`user_id`),
  KEY `post_users_post_id_foreign` (`post_id`),
  CONSTRAINT `post_users_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `post_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `posts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `about` text COLLATE utf8mb4_unicode_ci,
  `place` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `posts_category_id_foreign` (`category_id`),
  CONSTRAINT `posts_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `pricings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint unsigned NOT NULL,
  `price` int NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pricings_post_id_foreign` (`post_id`),
  CONSTRAINT `pricings_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `testimonials` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `post_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `testimonials_post_id_foreign` (`post_id`),
  CONSTRAINT `testimonials_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `transactions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `booking_trx_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `pricing_id` bigint unsigned NOT NULL,
  `total_ticket` int unsigned NOT NULL,
  `grand_total` int unsigned NOT NULL,
  `is_paid` tinyint(1) NOT NULL,
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `proof` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `started_at` date NOT NULL,
  `ended_at` date NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transactions_user_id_foreign` (`user_id`),
  KEY `transactions_pricing_id_foreign` (`pricing_id`),
  CONSTRAINT `transactions_pricing_id_foreign` FOREIGN KEY (`pricing_id`) REFERENCES `pricings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `active_status` tinyint(1) NOT NULL DEFAULT '0',
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'avatar.png',
  `dark_mode` tinyint(1) NOT NULL DEFAULT '0',
  `messenger_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;





INSERT INTO `categories` (`id`, `name`, `slug`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Wisata Alam', 'wisata-alam', NULL, '2025-03-30 14:59:50', '2025-03-30 14:59:50');
INSERT INTO `categories` (`id`, `name`, `slug`, `deleted_at`, `created_at`, `updated_at`) VALUES
(2, 'Wisata Sejarah', 'wisata-sejarah', NULL, '2025-03-30 15:38:47', '2025-03-30 15:38:47');




INSERT INTO `ch_messages` (`id`, `from_id`, `to_id`, `body`, `attachment`, `seen`, `created_at`, `updated_at`) VALUES
('0c848f98-045e-491b-ab88-a4f246114832', 2, 17, 'halooo terima kasih sudah menghubungi, apa yang saya bisa bantu?', NULL, 1, '2025-04-14 16:22:21', '2025-04-14 16:22:22');
INSERT INTO `ch_messages` (`id`, `from_id`, `to_id`, `body`, `attachment`, `seen`, `created_at`, `updated_at`) VALUES
('11051edd-21fd-48ec-ab94-03deb43bde4f', 4, 19, 'ohh oke silahkan klik tombol pesan tiket saja ya tinggal ikuti alur nya', NULL, 1, '2025-04-20 17:47:09', '2025-04-20 17:47:11');
INSERT INTO `ch_messages` (`id`, `from_id`, `to_id`, `body`, `attachment`, `seen`, `created_at`, `updated_at`) VALUES
('2bbcc18b-4cca-4eff-94f4-af4deb064c8e', 5, 8, 'holaaaaa', NULL, 1, '2025-04-13 16:55:32', '2025-04-13 16:55:33');
INSERT INTO `ch_messages` (`id`, `from_id`, `to_id`, `body`, `attachment`, `seen`, `created_at`, `updated_at`) VALUES
('553d9ef7-7d36-4621-b1e6-4e07574a846b', 2, 10, 'baikk terimakasih admin', NULL, 1, '2025-04-17 17:12:49', '2025-04-17 17:12:57'),
('5576d974-56f6-4c7e-b343-04df2012698a', 17, 2, '', '{\"new_name\":\"3c472c90-0012-4d61-9f30-257fb0106d4d.jpg\",\"old_name\":\"0eb3568f-ab93-45a9-859a-81c09610df87.jpeg\"}', 1, '2025-04-14 16:22:35', '2025-04-14 16:22:36'),
('5bc5b6ea-47f3-4e43-829f-064e2c6b1d80', 8, 5, 'p adimnnn', NULL, 1, '2025-04-13 16:55:26', '2025-04-13 16:55:27'),
('6157658c-4aac-4fcd-89b9-1178e506096a', 2, 10, 'haloo ada yg bisa dibantu?', NULL, 1, '2025-04-17 17:10:19', '2025-04-17 17:10:22'),
('71c61209-cae5-4c4c-80a2-178145e297be', 10, 2, '🥰🥰🥰', NULL, 1, '2025-04-17 17:13:27', '2025-04-17 17:13:28'),
('9324dcdd-d134-4b36-b960-e16a7da64534', 17, 2, 'konnichiwaa aku ingin tanya sepitar pemesanan', NULL, 1, '2025-04-14 16:21:46', '2025-04-14 16:22:03'),
('95580f14-73d0-45e2-9d66-b85a8ef7c891', 10, 2, 'saya ingin bertanya soal pemesanan ticket', NULL, 1, '2025-04-17 17:10:41', '2025-04-17 17:10:44'),
('9c2a72b3-407c-4880-b750-1061c64db58d', 10, 2, 'okee anda silahkan klik tombol tiket, lalu isi data dan pilih jumlah ticket yg ingin di pesan dan pilih tanggal', NULL, 1, '2025-04-17 17:12:32', '2025-04-17 17:12:35'),
('bd719226-1fd0-4e54-b6b5-3122f2c491ab', 4, 19, 'haloo ada yg bisa saya bantu?', NULL, 1, '2025-04-20 17:44:48', '2025-04-20 17:44:50'),
('c5aa4b85-0e06-4e8f-9806-17245d36f420', 2, 10, 'saya ingin pesan taman godzilla', NULL, 1, '2025-04-17 17:11:37', '2025-04-17 17:11:41'),
('cd26b1e0-55ee-4e73-8f13-35453b4d28b9', 10, 3, 'ted', NULL, 1, '2025-04-13 11:22:42', '2025-04-13 16:26:39'),
('d5a7ff0c-8de6-48d0-a0fa-f54127c9a224', 10, 3, 'halooo minami', NULL, 1, '2025-04-13 10:45:23', '2025-04-13 16:26:39'),
('daa47db7-4b34-4adc-8480-6b1d315715a2', 10, 2, 'bolehhh anda ingin pesan tempat wisata yg mana?', NULL, 1, '2025-04-17 17:11:10', '2025-04-17 17:11:13'),
('dbd99a69-1413-471a-af1d-161086e16248', 2, 17, '😍😍😍', NULL, 1, '2025-04-14 16:22:57', '2025-04-14 16:22:58'),
('eab32882-21af-4925-8ab1-69a85c578b9d', 19, 4, 'Halooo admin', NULL, 1, '2025-04-20 17:43:41', '2025-04-20 17:44:36'),
('ed64abd2-98f2-4141-8a4c-888c51d260dc', 10, 2, 'sama sama, senang bisa membantu', NULL, 1, '2025-04-17 17:13:06', '2025-04-17 17:13:09'),
('ef35859b-6cb1-41f2-919f-e1823e44f677', 10, 2, 'Haloo admin', NULL, 1, '2025-04-17 17:09:34', '2025-04-17 17:10:14'),
('ef986b26-4b08-4814-acb5-165c483b666d', 19, 4, 'saya ingin pesan ticket untuk taman magroove kak', NULL, 1, '2025-04-20 17:46:39', '2025-04-20 17:46:42');



INSERT INTO `comments` (`id`, `user_id`, `post_id`, `comment`, `comment_at`, `created_at`, `updated_at`, `parent_id`) VALUES
(3, 3, 1, 'Wowww Cantikkk😍', '2025-03-30', '2025-03-30 15:27:25', '2025-04-22 04:35:56', NULL);
INSERT INTO `comments` (`id`, `user_id`, `post_id`, `comment`, `comment_at`, `created_at`, `updated_at`, `parent_id`) VALUES
(4, 7, 1, 'Tempat ini sangat indah, Aku sangat menyukainya!!!😍', '2025-04-03', '2025-04-03 06:40:55', '2025-04-03 06:40:55', NULL);
INSERT INTO `comments` (`id`, `user_id`, `post_id`, `comment`, `comment_at`, `created_at`, `updated_at`, `parent_id`) VALUES
(11, 3, 1, '😍😍😍', '2025-04-22', '2025-04-22 04:36:08', '2025-04-22 04:36:08', 4);
INSERT INTO `comments` (`id`, `user_id`, `post_id`, `comment`, `comment_at`, `created_at`, `updated_at`, `parent_id`) VALUES
(16, 19, 1, 'Sangat Indah😍', '2025-04-22', '2025-04-22 06:39:22', '2025-04-22 06:39:22', NULL),
(17, 25, 1, 'Benarr sekalii😆', '2025-04-22', '2025-04-22 06:48:15', '2025-04-22 06:48:15', 16),
(18, 25, 2, 'Biru meronaa🩵😀', '2025-04-22', '2025-04-22 17:39:09', '2025-04-22 17:39:09', NULL),
(22, 9, 1, '☆*: .｡. o(≧▽≦)o .｡.:*☆', '2025-04-23', '2025-04-23 06:37:23', '2025-04-23 06:37:51', 3),
(25, 23, 1, '(*/ω＼*)', '2025-04-23', '2025-04-23 16:04:45', '2025-04-23 16:04:45', 3);







INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(2, '0001_01_01_000001_create_cache_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(3, '0001_01_01_000002_create_jobs_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(4, '2025_03_27_161017_create_categories_table', 1),
(5, '2025_03_27_161038_create_posts_table', 1),
(6, '2025_03_27_161228_create_testimonials_table', 1),
(7, '2025_03_27_161257_create_chats_table', 1),
(8, '2025_03_27_161308_create_comments_table', 1),
(9, '2025_03_27_161325_create_pricings_table', 1),
(10, '2025_03_27_161336_create_transactions_table', 1),
(11, '2025_03_28_034938_create_post_users_table', 1),
(12, '2025_03_28_034946_create_post_admins_table', 1),
(13, '2025_03_29_014756_create_permission_tables', 1),
(14, '2025_04_03_072846_add_post_admin_id_to_chats_table', 2),
(15, '2025_04_10_999999_add_active_status_to_users', 3),
(16, '2025_04_10_999999_add_avatar_to_users', 3),
(17, '2025_04_10_999999_add_dark_mode_to_users', 3),
(18, '2025_04_10_999999_add_messenger_color_to_users', 3),
(19, '2025_04_10_999999_create_chatify_favorites_table', 3),
(20, '2025_04_10_999999_create_chatify_messages_table', 3),
(21, '2025_04_22_030452_add_parent_id_to_comments_table', 4);



INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1);
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(2, 'App\\Models\\User', 2);
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(3, 'App\\Models\\User', 3);
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(2, 'App\\Models\\User', 4),
(2, 'App\\Models\\User', 5),
(1, 'App\\Models\\User', 6),
(3, 'App\\Models\\User', 7),
(3, 'App\\Models\\User', 8),
(3, 'App\\Models\\User', 9),
(3, 'App\\Models\\User', 10),
(3, 'App\\Models\\User', 11),
(3, 'App\\Models\\User', 13),
(3, 'App\\Models\\User', 14),
(3, 'App\\Models\\User', 15),
(3, 'App\\Models\\User', 16),
(3, 'App\\Models\\User', 17),
(3, 'App\\Models\\User', 19),
(3, 'App\\Models\\User', 21),
(3, 'App\\Models\\User', 22),
(3, 'App\\Models\\User', 23),
(3, 'App\\Models\\User', 24),
(3, 'App\\Models\\User', 25),
(3, 'App\\Models\\User', 26);





INSERT INTO `post_admins` (`id`, `is_active`, `user_id`, `post_id`, `about`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 1, '\"Hai, saya Mauren Grabriella, seorang penggemar wisata yang suka menjelajahi tempat-tempat baru dan berbagi pengalaman dengan Anda. Saya percaya bahwa setiap perjalanan adalah cerita yang berharga, dan saya ingin membantu Anda menciptakan cerita indah dengan Holi-Rang. Jika Anda butuh informasi, rekomendasi, atau sekadar berbagi pengalaman seru, saya selalu siap membantu! Yuk, jelajahi keindahan alam bersama!\"', NULL, '2025-03-30 15:22:37', '2025-03-30 15:22:37');
INSERT INTO `post_admins` (`id`, `is_active`, `user_id`, `post_id`, `about`, `deleted_at`, `created_at`, `updated_at`) VALUES
(2, 1, 5, 2, '\"Selamat datang di Holi-Rang! Saya Rika Andini, seorang pecinta wisata alam yang senang berbagi pengalaman dan informasi kepada Anda. Dengan pengalaman lebih dari 2 tahun di industri pariwisata, saya berkomitmen untuk memberikan layanan terbaik kepada semua pengunjung. Jangan sungkan untuk bertanya atau berdiskusi tentang destinasi yang Anda minati. Saya berharap bisa membantu perjalanan wisata Anda menjadi lebih menyenangkan dan penuh kenangan!\"', NULL, '2025-03-30 15:32:27', '2025-04-13 16:17:24');
INSERT INTO `post_admins` (`id`, `is_active`, `user_id`, `post_id`, `about`, `deleted_at`, `created_at`, `updated_at`) VALUES
(3, 1, 4, 3, '\"Halo! Saya Vonny Felicia, seseorang yang percaya bahwa keindahan alam adalah obat terbaik bagi jiwa. Sebagai admin di Holi-Rang, saya ingin membantu Anda menemukan ketenangan dan petualangan di berbagai destinasi indah yang kami tawarkan. Jika ada yang ingin ditanyakan mengenai perjalanan Anda, saya dengan senang hati akan membantu. Selamat berpetualang dan ciptakan kenangan indah bersama orang tersayang!\"', NULL, '2025-03-30 15:36:57', '2025-03-30 15:36:57');
INSERT INTO `post_admins` (`id`, `is_active`, `user_id`, `post_id`, `about`, `deleted_at`, `created_at`, `updated_at`) VALUES
(4, 1, 2, 4, '\"Hai, saya Maureen Gabriella, seorang penggemar wisata yang suka menjelajahi tempat-tempat baru dan berbagi pengalaman dengan Anda. Saya percaya bahwa setiap perjalanan adalah cerita yang berharga, dan saya ingin membantu Anda menciptakan cerita indah dengan Holi-Rang. Jika Anda butuh informasi, rekomendasi, atau sekadar berbagi pengalaman seru, saya selalu siap membantu! Yuk, jelajahi keindahan alam bersama!\"', NULL, '2025-03-30 15:48:40', '2025-03-30 15:48:40');



INSERT INTO `posts` (`id`, `name`, `slug`, `thumbnail`, `about`, `place`, `category_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Tebing Koja (Kandang Godzilla)', 'tebing-koja-kandang-godzilla', '01JQKS4B7YRJZ0CESQB4DSYCHW.webp', 'Tebing Koja, yang juga dikenal sebagai Kandang Godzilla, adalah destinasi wisata alam yang terletak di Solear, Kabupaten Tangerang, Banten. Tempat ini menawarkan pemandangan tebing-tebing kapur yang menjulang tinggi dengan kombinasi danau dan hamparan sawah hijau yang menambah keindahan alamnya.\n\nWisata ini mendapatkan julukan Kandang Godzilla karena lanskapnya yang unik menyerupai habitat makhluk prasejarah. Dengan panorama yang eksotis dan suasana yang masih alami, Tebing Koja menjadi tempat favorit bagi wisatawan dan fotografer yang ingin mengabadikan keindahan alam yang Instagrammable.', 'Solear, Kabupaten Tangerang, Banten', 1, NULL, '2025-03-30 15:01:11', '2025-03-30 15:01:11');
INSERT INTO `posts` (`id`, `name`, `slug`, `thumbnail`, `about`, `place`, `category_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(2, 'Danau Biru Cisoka', 'danau-biru-cisoka', '01JQKS5XPS66MXSB9CQSV998QF.webp', 'Danau Biru Cisoka adalah destinasi wisata alam yang terletak di Cisoka, Kabupaten Tangerang, Banten. Danau ini terkenal karena warna airnya yang unik, yang bisa berubah dari biru kehijauan hingga toska, tergantung pada kondisi cuaca dan pencahayaan.\n\nAwalnya, Danau Biru Cisoka merupakan bekas galian tambang pasir yang kemudian terisi air secara alami. Pemandangan di sekitar danau yang dikelilingi tebing-tebing eksotis menambah daya tarik tersendiri bagi para pengunjung yang ingin berfoto atau sekadar menikmati ketenangan alam.\n\nDi lokasi ini, wisatawan juga bisa menikmati berbagai aktivitas, seperti berkeliling danau dengan perahu kecil, bersantai di gazebo, atau sekadar menikmati suasana alam yang asri. Danau Biru Cisoka menjadi pilihan tepat bagi pencinta wisata alam yang ingin melepas penat dan berburu spot foto Instagramable.', 'Cisoka, Kabupaten Tangerang, Banten.', 1, NULL, '2025-03-30 15:02:03', '2025-03-30 15:02:03');
INSERT INTO `posts` (`id`, `name`, `slug`, `thumbnail`, `about`, `place`, `category_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(3, 'Taman Mangrove Ketapang', 'taman-mangrove-ketapang', '01JQKS75DT5QWSG8SD8JZ5QHS7.webp', 'Taman Mangrove Ketapang adalah destinasi ekowisata yang terletak di Kecamatan Mauk, Kabupaten Tangerang, Banten. Tempat ini menawarkan keindahan alam hutan bakau yang hijau dan asri, sekaligus berperan penting dalam menjaga keseimbangan ekosistem pesisir.\n\nPengunjung dapat menikmati suasana yang tenang dengan berjalan di jembatan kayu yang membelah hutan mangrove, berfoto di berbagai spot menarik, serta menjelajahi kawasan ini dengan perahu untuk melihat lebih dekat keanekaragaman hayati di sekitar. Selain itu, wisatawan juga bisa berpartisipasi dalam kegiatan penanaman mangrove sebagai bentuk pelestarian lingkungan.', 'Jalan Raya Tanjung Kait, Desa Ketapang, Kecamatan Mauk, Kabupaten Tangerang.', 1, NULL, '2025-03-30 15:02:43', '2025-03-30 15:02:43');
INSERT INTO `posts` (`id`, `name`, `slug`, `thumbnail`, `about`, `place`, `category_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(4, 'Museum Benteng Heritage', 'museum-benteng-heritage', '01JQKVHWQJ8PS2JX1WPAHDCQP6.jpg', 'Museum Benteng Heritage adalah salah satu destinasi wisata sejarah yang wajib dikunjungi di Tangerang. Museum ini menampilkan sejarah peranakan Tionghoa di Indonesia, khususnya di Tangerang yang dikenal sebagai \"Cina Benteng.\" Dengan arsitektur khas Tionghoa yang masih terjaga, pengunjung dapat menikmati berbagai koleksi bersejarah seperti foto-foto lama, barang antik, dan peninggalan budaya. Tempat ini menjadi saksi bisu perjalanan panjang komunitas Tionghoa di Tangerang sejak abad ke-17.', 'Pasar Lama, Kota Tangerang', 2, NULL, '2025-03-30 15:43:32', '2025-03-30 15:43:32');

INSERT INTO `pricings` (`id`, `post_id`, `price`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 2, 75000, NULL, '2025-03-30 15:04:22', '2025-03-30 15:04:22');
INSERT INTO `pricings` (`id`, `post_id`, `price`, `deleted_at`, `created_at`, `updated_at`) VALUES
(2, 3, 65000, NULL, '2025-03-30 15:04:35', '2025-03-30 15:04:35');
INSERT INTO `pricings` (`id`, `post_id`, `price`, `deleted_at`, `created_at`, `updated_at`) VALUES
(3, 1, 85000, NULL, '2025-03-30 15:04:43', '2025-03-30 15:04:43');
INSERT INTO `pricings` (`id`, `post_id`, `price`, `deleted_at`, `created_at`, `updated_at`) VALUES
(4, 4, 30000, NULL, '2025-04-03 16:27:44', '2025-04-03 16:27:44');



INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'super admin', 'web', '2025-03-30 14:53:54', '2025-03-30 14:53:54');
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(2, 'admin', 'web', '2025-03-30 14:53:54', '2025-03-30 14:53:54');
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(3, 'customer', 'web', '2025-03-30 14:53:54', '2025-03-30 14:53:54');

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('dDtXXmzZjEujGLONC5fTo7fNhSZCaxEsrLFlz9o3', NULL, '118.137.72.91', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMXBhcG0xUFhUYTNXa29Lc0RvQkNCUlNGVUg1WkhhQmtQS0cyVkJMWiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTM6Imh0dHBzOi8vYmY4Mi0xMTgtMTM3LTcyLTkxLm5ncm9rLWZyZWUuYXBwL2F1dGgvZ29vZ2xlIjt9czo1OiJzdGF0ZSI7czo0MDoieFpjb3ptTnlGb2hiY3pwOWtrT2pZeU5XNFdPRWhzUTNNcDBmNmJ4ciI7fQ==', 1745462786);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('JZOAwzRLi3XEbIiTfZngvDzcuLvM58HUGGSvoenB', NULL, '118.137.72.91', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVTIzR0dJdEJQNFh5aDF6cDd0VHJ2Z01HUENUMHI2MTl2UTFHcGV6bCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHBzOi8vN2Y5Yy0xMTgtMTM3LTcyLTkxLm5ncm9rLWZyZWUuYXBwIjt9fQ==', 1745464829);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('T4CdWu3tZvBiWLHYpbB6pE8VFbHzRxdDegIuZcAd', NULL, '118.137.72.91', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidWQ4SDlYaVRXd1EwRk04WEdnUVhiYkx2QnJyMTNTcWhIajFWaHlESSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHBzOi8vYzRmYi0xMTgtMTM3LTcyLTkxLm5ncm9rLWZyZWUuYXBwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1745462278);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('YnMOX1DLtjqghOTqB14f1e5iqNdNOT6S6QfHpKXu', NULL, '34.101.92.69', 'Veritrans', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiSWFITVNmUDlRSjdibmc3M2xEazFxZXhwakdRSHNOeTNXWUtQdW81bCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1745464722),
('yPNXc9BZt6AXecqFF2QIIkxpQgNRNZQjAsSEbkTI', 23, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMVl0RHBaRENFejNWcjFYQVZjT1lhWWhBTFR1S1VvbGh2VlJSdDhITSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQvcG9zdC90ZWJpbmcta29qYS1rYW5kYW5nLWdvZHppbGxhIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjM7fQ==', 1745466488);

INSERT INTO `testimonials` (`id`, `name`, `photo`, `description`, `post_id`, `created_at`, `updated_at`) VALUES
(1, 'Riko Fukumoto', '01JQKS8F6ZK712JV9S97XRMZ4P.png', 'This is nice place😍', 1, '2025-03-30 15:03:26', '2025-03-30 15:03:26');
INSERT INTO `testimonials` (`id`, `name`, `photo`, `description`, `post_id`, `created_at`, `updated_at`) VALUES
(2, 'Miselia Ikhwan', '01JR54VAX2BMS23K07Q729N17M.jpg', 'View nya bagus bangetttt😍', 1, '2025-04-06 08:53:04', '2025-04-06 08:53:04');
INSERT INTO `testimonials` (`id`, `name`, `photo`, `description`, `post_id`, `created_at`, `updated_at`) VALUES
(3, 'Yuki Yamada', '01JR54X0EFY88XYQPYC1T875K7.jpg', 'Really cool for stories🔥', 1, '2025-04-06 08:53:59', '2025-04-06 08:53:59');
INSERT INTO `testimonials` (`id`, `name`, `photo`, `description`, `post_id`, `created_at`, `updated_at`) VALUES
(4, 'Marsha Lenanthea', '01JSEV5FZHB7ACT4ENM8SHKZZY.jpg', 'Danau nya biru cantik🩵', 2, '2025-04-22 13:31:57', '2025-04-22 13:31:57'),
(5, 'Rina Armetia', '01JSEV7P64M8QNPQ2XDFFNKGB3.jpg', 'Lautan biru yang Indahh😊', 2, '2025-04-22 13:33:09', '2025-04-22 13:33:09'),
(6, 'Kanon Chan', '01JSEVA6PKSTJ3V908Q16ZSDRT.jpeg', 'Danau yang menyejukkan hati🩵😊', 2, '2025-04-22 13:34:32', '2025-04-22 13:34:32'),
(7, 'Kang-Min Ah', '01JSEVCEWCSCTAGFWR1HCJQR36.jpg', 'Beautiful & Green💚😀', 3, '2025-04-22 13:35:46', '2025-04-22 13:35:46'),
(8, 'Reva Fidela', '01JSEVE2BBBX8T9Q75H8VSP4JZ.webp', 'Taman yang menyejukkan💚', 3, '2025-04-22 13:36:38', '2025-04-22 13:36:38'),
(9, 'Yoo-Jin soo', '01JSEVF8T8BE76726912BN6MJ7.webp', 'I like this place😊', 3, '2025-04-22 13:37:18', '2025-04-22 13:37:18'),
(10, 'Anin Aditya', '01JSEVH8WXCXRPKHHPP3H4XHGJ.webp', 'Tempat nya sangat monumental👌', 4, '2025-04-22 13:38:23', '2025-04-22 13:38:23'),
(11, 'Freya Jayawardhana', '01JSEVM1X04JYDVBPYPAJTF1PT.webp', 'Full of History😊', 4, '2025-04-22 13:39:54', '2025-04-22 13:39:54');

INSERT INTO `transactions` (`id`, `booking_trx_id`, `user_id`, `pricing_id`, `total_ticket`, `grand_total`, `is_paid`, `payment_type`, `proof`, `started_at`, `ended_at`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'HLRANG2204', 3, 2, 3, 225000, 1, 'Manual', NULL, '2025-04-21', '2025-04-22', '2025-04-23 06:34:54', '2025-04-02 19:08:55', '2025-04-23 06:34:54');
INSERT INTO `transactions` (`id`, `booking_trx_id`, `user_id`, `pricing_id`, `total_ticket`, `grand_total`, `is_paid`, `payment_type`, `proof`, `started_at`, `ended_at`, `deleted_at`, `created_at`, `updated_at`) VALUES
(2, 'HLRANG2904', 7, 3, 3, 195000, 1, 'Manual', NULL, '2025-04-15', '2025-04-16', NULL, '2025-04-03 06:28:54', '2025-04-03 06:31:35');
INSERT INTO `transactions` (`id`, `booking_trx_id`, `user_id`, `pricing_id`, `total_ticket`, `grand_total`, `is_paid`, `payment_type`, `proof`, `started_at`, `ended_at`, `deleted_at`, `created_at`, `updated_at`) VALUES
(3, 'HLRANG6221', 8, 1, 4, 340000, 1, 'Manual', NULL, '2025-04-15', '2025-04-16', NULL, '2025-04-03 12:57:23', '2025-04-03 16:28:20');
INSERT INTO `transactions` (`id`, `booking_trx_id`, `user_id`, `pricing_id`, `total_ticket`, `grand_total`, `is_paid`, `payment_type`, `proof`, `started_at`, `ended_at`, `deleted_at`, `created_at`, `updated_at`) VALUES
(4, 'HLRANG9568', 9, 4, 1, 30000, 1, 'Midtrans', NULL, '2025-04-20', '2025-04-21', '2025-04-23 06:36:55', '2025-04-03 16:32:02', '2025-04-23 06:36:55'),
(5, 'HLRANG9567', 10, 2, 5, 325000, 1, 'Midtrans', NULL, '2025-04-24', '2025-04-25', NULL, '2025-04-20 11:25:20', '2025-04-20 11:25:20'),
(6, 'HLRANG6319', 10, 3, 3, 255000, 1, 'Midtrans', NULL, '2025-04-22', '2025-04-23', '2025-04-23 06:27:00', '2025-04-20 17:24:53', '2025-04-23 06:27:00'),
(7, 'HLRANG2118', 10, 4, 5, 150000, 1, 'Midtrans', NULL, '2025-04-24', '2025-04-25', NULL, '2025-04-23 16:44:06', '2025-04-23 16:44:06'),
(8, 'HLRANG7445', 23, 1, 4, 300000, 1, 'Midtrans', NULL, '2025-04-24', '2025-04-25', NULL, '2025-04-24 03:18:42', '2025-04-24 03:18:42');

INSERT INTO `users` (`id`, `name`, `photo`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `active_status`, `avatar`, `dark_mode`, `messenger_color`) VALUES
(1, 'Naufal Najmi Kardiansyah', '01JQKRTGPV0WHZ6XVMS26K2AFC.png', 'teamholirang@gmail.com', NULL, '$2y$12$bAR0mKLm02qAs6eBggv7e.t5XEVet0hoXXylPq8rRO2e.RTCJVU0y', '5t25x1s1Uw7gSian9vJOOL03Eq3Mg7N8cLbQHmxI8ss5qisdo9IEXFyGkoIz', '2025-03-30 14:53:55', '2025-03-30 14:55:49', 0, 'avatar.png', 0, NULL);
INSERT INTO `users` (`id`, `name`, `photo`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `active_status`, `avatar`, `dark_mode`, `messenger_color`) VALUES
(2, 'Mauren Gabriella', '01JQKRZKMREPZRRFQ6ST8MWRN8.jpg', 'btralice@gmail.com', NULL, '$2y$12$t/6QdrBBTK8Lo/.jtM9/Fu4Ksyujk1El44QvZMWkbPg2X1OC34HnK', NULL, '2025-03-30 14:58:36', '2025-04-17 17:13:37', 0, 'avatar.png', 0, '#4CAF50');
INSERT INTO `users` (`id`, `name`, `photo`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `active_status`, `avatar`, `dark_mode`, `messenger_color`) VALUES
(3, 'Minami Hamabe', '01JQKS0T7HBSVS6F4H545FPZ11.jpg', 'minami04@gmail.com', NULL, '$2y$12$R5uU1IKZF5dvFHv7Z.G70.BpW0.UbD9QGbrSeSJHs/cmcJcso7WXy', 'jtiIZYdIquW9YfINxvZ43zeU4NcG7l9BJkOhGD5imrQrxgkyAktNHg9nqiVm', '2025-03-30 14:59:16', '2025-04-13 16:29:12', 1, 'avatar.png', 0, NULL);
INSERT INTO `users` (`id`, `name`, `photo`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `active_status`, `avatar`, `dark_mode`, `messenger_color`) VALUES
(4, 'Vonny Felicia', '01JQKV0VK51YA7ZBAAJDNZ5V3H.jpg', 'vonzyfelicia@gmail.com', NULL, '$2y$12$tHjQ7qxFHM4GYWjHIzoGD.PHQF8.PHijiuTZf7mfrnEd6sVvZu/si', NULL, '2025-03-30 15:34:14', '2025-04-20 17:46:20', 1, 'avatar.png', 0, NULL),
(5, 'Rika Andini', '01JRQYZWY4VQ1P0ZXYHRM1SPE1.jpg', 'rikaapi@gmail.com', NULL, '$2y$12$BkbzEjNC5SO8rkRcVB1bOeW8h2X0TqimUT0gP7i91JBu9gNQ6V3Ea', NULL, '2025-03-30 15:34:54', '2025-04-13 16:55:52', 0, 'avatar.png', 0, NULL),
(6, 'Marsha Lenanthea', '01JQKV3JQE5AQQXZT27M6D6AYD.jpg', 'marshajkt48@gmail.com', NULL, '$2y$12$OWj3Or6rjQceRptTB8sw1.SXNzlvgBPvLVtfhRDFYf7gCmla6lhuW', '0TDWGASRUMgkRBrIay8RaofYa0QzD7aPocCYGFFE4swc0R352TEgqMt0Cble', '2025-03-30 15:35:43', '2025-03-30 15:35:43', 0, 'avatar.png', 0, NULL),
(7, 'Hanie Adelia', '01JQX40HMBE9RP163999PEF1WJ.jpg', 'hanieaa@gmail.com', NULL, '$2y$12$UqTheAvplT5fao9sr2PA.uHXSvzkvWqLmrz6yyKmvjxOc9N35rPP2', NULL, '2025-04-03 06:04:31', '2025-04-03 06:04:31', 0, 'avatar.png', 0, NULL),
(8, 'Rasya Marani', '01JQXVHWWP43RB7GTP932YR5HH.webp', 'rasyaam@gmail.com', NULL, '$2y$12$DZ8W/U8CwzRJ2eoa9eu4dOJRBcQI0O7qyCXxGaueIAISiw/Mi2cam', NULL, '2025-04-03 12:55:57', '2025-04-13 16:54:38', 0, 'avatar.png', 0, NULL),
(9, 'Riko Fukumoto', 'photo/OTO7IoXi2fn9VBJxenhxaKYJJKlI90OSoRHlQMQq.jpg', 'rikochan@gmail.com', NULL, '$2y$12$WT.i8uLLlxhPxk1LUpYtBOnBqqdIzuwMxA7ZFEvu.0fnCYtBmS7uG', NULL, '2025-04-03 16:30:08', '2025-04-10 07:07:26', 0, 'avatar.png', 0, NULL),
(10, 'Hanni Pham', 'photo/CetFC2ZiSpLxB5tJMDhwUQ5AR0nzTSIXvPdGbMfA.jpg', 'hanninj04@gmail.com', NULL, '$2y$12$H4hvBusjCyAXCL6fAzKbi.hZoWKuVuxzsCv6W2WDcBR7AgLCefdtu', NULL, '2025-04-06 18:02:40', '2025-04-17 17:10:13', 1, 'f54c720d-eea9-45b8-a2d1-f019a6ac4dc1.jpg', 0, '#4CAF50'),
(11, 'Grency Cantika', '01JR64Y60WETVJPTSMY0QNMBC8.jpg', 'grencycantika@gmail.com', NULL, '$2y$12$3gXQ7/M3vLA9755At1SjhuFMX5q5QYbH4TIKfRdcHJLw6gvq8KBG2', NULL, '2025-04-06 18:13:03', '2025-04-06 18:13:52', 0, 'avatar.png', 0, NULL),
(13, 'Sakura Haruno', 'photo/vlLluCeBXgRzFUDCBHK24YOXecyiEHkiuQlQZqd7.webp', 'sakura004@gmail.com', NULL, '$2y$12$ftnAYg8s8o20DF3gdf3ju.Ctb3k/Iwx9b8PWuOa0yp9qg5UbN3TOK', NULL, '2025-04-10 00:54:41', '2025-04-10 01:35:38', 0, 'avatar.png', 0, NULL),
(14, 'Vania Ananda Putri', '01JS9Z1YSB4FVAR9KQE9VD9X35.webp', 'vaniaku06@gmail.com', NULL, '$2y$12$AYpfPp6ckSFhwIAuW26th.s0rpS0ThnsnPvDJiHzlLFkXUlXavD5S', NULL, '2025-04-10 01:45:15', '2025-04-20 16:03:44', 0, 'avatar.png', 0, NULL),
(15, 'Kim Yong Joo', 'photo/9gNsCVQe0E4tHUTojayA9QhYdrNa6rwCUEjhG1wT.webp', 'kimcute@gmail.com', NULL, '$2y$12$RrgpATO84mlYy.n9npQVmuPGOi/7aqxLB7rmsPZMaLtJYA192BIaK', NULL, '2025-04-10 02:22:25', '2025-04-10 02:26:01', 0, 'avatar.png', 0, NULL),
(16, 'Peter Parker', 'photo/907EtjiyYAHEIvyS9xIXEs449Y7FTkdb1B96yd2n.jpg', 'peterpk01@gmail.com', NULL, '$2y$12$D/9WUpESenbh4jiPD4TnuetCgl6HO96kuNWZEDE/c2cM5F.dXMquS', NULL, '2025-04-10 02:28:11', '2025-04-10 02:31:00', 0, 'avatar.png', 0, NULL),
(17, 'Kanon Haruno', 'photo/6JibRA7hI90cGjlO89z7a3bzzFQJqAIGzPfcA86a.jpg', 'kanonchan@gmail.com', NULL, '$2y$12$qq1JOXAarWbEjBsPzYPcjOltc20ITHgroJSkPszi0DPRzTEF4hYHS', NULL, '2025-04-10 02:32:42', '2025-04-20 17:36:24', 0, 'avatar.png', 0, NULL),
(19, 'Kang-Min Ah', 'photo/owKojVQQfjPjgIW0AFMpOlhPg3wJSR3DS2KUVhFW.jpg', 'kaminah006@gmail.com', NULL, '$2y$12$IHvvM2WKIoAUyiD/8MbuSeVuuynzLtWRFr.vvhYxH0MzCHrQavzY2', NULL, '2025-04-20 17:38:22', '2025-04-20 17:47:26', 0, 'avatar.png', 0, NULL),
(21, 'Naufal Najmi Kardiansyah', 'photo/1AQRqZIYbNZrvtY3GJmxB6khCMdm0Wa5cEqQPEQz.jpg', 'naufalnajmi04@gmail.com', NULL, '$2y$12$ioOG.nhfEv4ErwiQA36kzeJ646lg4z8jO4CX5t5xHgvOt0TTp7xHS', NULL, '2025-04-21 02:26:56', '2025-04-21 02:39:19', 0, 'avatar.png', 0, NULL),
(22, 'Blue Sundays', NULL, 'bluesundays.ofc@gmail.com', NULL, '$2y$12$qG3ud.eI5btYcuBbgqz6BekHazyLUc4JNcw.8U7p29lQOS5Q9kQF2', NULL, '2025-04-21 02:35:57', '2025-04-21 02:35:57', 0, 'avatar.png', 0, NULL),
(23, 'Naufal Rock', 'photo/f2jrADScw1sAlyNJBf9JyXgBxcEujN5xAAu3UKz4.webp', 'coldbass04@gmail.com', NULL, '$2y$12$DJv59glfSOifS.gfn8LBfetNyqjlvqW/YQOl1v4qCmC6r86XRptpu', NULL, '2025-04-21 03:16:13', '2025-04-22 05:23:35', 0, 'avatar.png', 0, NULL),
(24, 'Rika Amelia', NULL, 'rikaamel27@gmail.com', NULL, '$2y$12$d2cgQtcJst86fFn.HcGDoOKOvvPUlVAGctXQ4HqkIOBnjBMMYIHoC', NULL, '2025-04-21 03:52:38', '2025-04-21 03:52:38', 0, 'avatar.png', 0, NULL),
(25, 'Blue Sunday', 'photo/Lu8hVjBvEgfIFqzXHwChccoEtf71LABPg7Pe3Krb.png', 'bluesundaymusic.official@gmail.com', NULL, '$2y$12$s2XPmLsDpi41o6NpHEutmOGrmem4NiwtBrq.OMAZfA75JD4vBKc.C', NULL, '2025-04-22 06:46:54', '2025-04-22 17:40:53', 0, 'avatar.png', 0, NULL),
(26, 'Nayla Samantha', NULL, 'naynay004@gmail.com', NULL, '$2y$12$UoNGbGW26Grj.RZcikpoqOwAIt/mUkDST.B08uyUp4wOuiSFCGFoa', NULL, '2025-04-22 16:43:30', '2025-04-22 16:43:30', 0, 'avatar.png', 0, NULL);


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;