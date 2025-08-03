-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table probashi.amenities
CREATE TABLE IF NOT EXISTS `amenities` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `amenity_type_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `amenities_amenity_type_id_foreign` (`amenity_type_id`),
  KEY `amenities_user_id_foreign` (`user_id`),
  CONSTRAINT `amenities_amenity_type_id_foreign` FOREIGN KEY (`amenity_type_id`) REFERENCES `amenity_types` (`id`) ON DELETE CASCADE,
  CONSTRAINT `amenities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table probashi.amenities: ~0 rows (approximately)

-- Dumping structure for table probashi.amenity_types
CREATE TABLE IF NOT EXISTS `amenity_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `amenity_types_user_id_foreign` (`user_id`),
  CONSTRAINT `amenity_types_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table probashi.amenity_types: ~0 rows (approximately)

-- Dumping structure for table probashi.areas
CREATE TABLE IF NOT EXISTS `areas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `country_id` bigint unsigned NOT NULL,
  `city_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `areas_country_id_foreign` (`country_id`),
  KEY `areas_city_id_foreign` (`city_id`),
  CONSTRAINT `areas_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE,
  CONSTRAINT `areas_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table probashi.areas: ~0 rows (approximately)
INSERT INTO `areas` (`id`, `country_id`, `city_id`, `name`, `photo`, `created_at`, `updated_at`) VALUES
	(4, 1, 2, 'General Help ', NULL, '2024-08-19 17:42:24', '2024-08-19 17:42:24');

-- Dumping structure for table probashi.bookings
CREATE TABLE IF NOT EXISTS `bookings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `package_id` bigint unsigned NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `number_of_days` int NOT NULL,
  `price_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `booking_price` decimal(10,2) NOT NULL,
  `payment_option` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'not_paid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `room_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  PRIMARY KEY (`id`),
  KEY `bookings_user_id_foreign` (`user_id`),
  KEY `bookings_package_id_foreign` (`package_id`),
  CONSTRAINT `bookings_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE,
  CONSTRAINT `bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table probashi.bookings: ~0 rows (approximately)

-- Dumping structure for table probashi.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table probashi.cache: ~7 rows (approximately)
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
	('356a192b7913b04c54574d18c28d46e6395428ab', 'i:1;', 1753688024),
	('356a192b7913b04c54574d18c28d46e6395428ab:timer', 'i:1753688024;', 1753688024),
	('902ba3cda1883801594b6e1b452790cc53948fda', 'i:1;', 1723870546),
	('902ba3cda1883801594b6e1b452790cc53948fda:timer', 'i:1723870546;', 1723870546),
	('spatie.permission.cache', 'a:3:{s:5:"alias";a:4:{s:1:"a";s:2:"id";s:1:"b";s:4:"name";s:1:"c";s:10:"guard_name";s:1:"r";s:5:"roles";}s:11:"permissions";a:13:{i:0;a:4:{s:1:"a";i:1;s:1:"b";s:14:"package.create";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:1;a:4:{s:1:"a";i:2;s:1:"b";s:12:"package.edit";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:2;a:4:{s:1:"a";i:3;s:1:"b";s:12:"package.show";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:3;a:4:{s:1:"a";i:4;s:1:"b";s:14:"package.delete";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:4;a:4:{s:1:"a";i:5;s:1:"b";s:7:"booking";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:5;a:4:{s:1:"a";i:6;s:1:"b";s:4:"user";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:6;a:4:{s:1:"a";i:7;s:1:"b";s:7:"earning";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:7;a:4:{s:1:"a";i:8;s:1:"b";s:15:"role.permission";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:8;a:4:{s:1:"a";i:9;s:1:"b";s:13:"package.setup";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:9;a:4:{s:1:"a";i:10;s:1:"b";s:9:"dashboard";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:10;a:4:{s:1:"a";i:11;s:1:"b";s:11:"my-packages";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:11;a:4:{s:1:"a";i:12;s:1:"b";s:7:"package";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:12;a:4:{s:1:"a";i:13;s:1:"b";s:13:"site.settings";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}}s:5:"roles";a:1:{i:0;a:3:{s:1:"a";i:1;s:1:"b";s:11:"Super Admin";s:1:"c";s:3:"web";}}}', 1753774003),
	('superadmin@gmail.com|85.255.237.28', 'i:1;', 1723907201),
	('superadmin@gmail.com|85.255.237.28:timer', 'i:1723907201;', 1723907201);

-- Dumping structure for table probashi.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table probashi.cache_locks: ~0 rows (approximately)

-- Dumping structure for table probashi.cities
CREATE TABLE IF NOT EXISTS `cities` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `country_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cities_country_id_foreign` (`country_id`),
  CONSTRAINT `cities_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table probashi.cities: ~0 rows (approximately)
INSERT INTO `cities` (`id`, `country_id`, `name`, `photo`, `created_at`, `updated_at`) VALUES
	(2, 1, 'Dhaka', NULL, '2024-08-17 21:48:24', '2024-08-17 21:48:24');

-- Dumping structure for table probashi.countries
CREATE TABLE IF NOT EXISTS `countries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `symbol` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table probashi.countries: ~0 rows (approximately)
INSERT INTO `countries` (`id`, `name`, `symbol`, `currency`, `photo`, `created_at`, `updated_at`) VALUES
	(1, 'Bangladesh', 'BDT', 'BDT', 'photos/fRLY5rKPN3PdvxUCfmVnlAydneMQ6dapxLja7f6a.png', '2024-08-17 08:54:50', '2024-08-17 08:54:50');

-- Dumping structure for table probashi.entire_properties
CREATE TABLE IF NOT EXISTS `entire_properties` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `package_id` bigint unsigned DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `entire_properties_user_id_foreign` (`user_id`),
  KEY `entire_properties_package_id_foreign` (`package_id`),
  CONSTRAINT `entire_properties_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE,
  CONSTRAINT `entire_properties_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table probashi.entire_properties: ~0 rows (approximately)

-- Dumping structure for table probashi.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
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

-- Dumping data for table probashi.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table probashi.footers
CREATE TABLE IF NOT EXISTS `footers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `footer_logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `terms_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `terms_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `privacy_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `privacy_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rights_reserves_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table probashi.footers: ~0 rows (approximately)
INSERT INTO `footers` (`id`, `footer_logo`, `address`, `email`, `contact_number`, `website`, `terms_title`, `terms_link`, `privacy_title`, `privacy_link`, `rights_reserves_text`, `created_at`, `updated_at`) VALUES
	(1, NULL, 'fgik', 'istiakjoypurhat@gmail.com', '01717893432', '76576657', 'jkg', 'https://hello.com', 'https://hello.com', 'https://hello.com', 'https://hello.com', '2024-08-16 22:52:22', '2024-08-16 22:52:22');

-- Dumping structure for table probashi.footer_section_fours
CREATE TABLE IF NOT EXISTS `footer_section_fours` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `footer_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `footer_section_fours_footer_id_foreign` (`footer_id`),
  CONSTRAINT `footer_section_fours_footer_id_foreign` FOREIGN KEY (`footer_id`) REFERENCES `footers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table probashi.footer_section_fours: ~0 rows (approximately)

-- Dumping structure for table probashi.footer_section_threes
CREATE TABLE IF NOT EXISTS `footer_section_threes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `footer_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `footer_section_threes_footer_id_foreign` (`footer_id`),
  CONSTRAINT `footer_section_threes_footer_id_foreign` FOREIGN KEY (`footer_id`) REFERENCES `footers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table probashi.footer_section_threes: ~0 rows (approximately)

-- Dumping structure for table probashi.footer_section_twos
CREATE TABLE IF NOT EXISTS `footer_section_twos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `footer_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `footer_section_twos_footer_id_foreign` (`footer_id`),
  CONSTRAINT `footer_section_twos_footer_id_foreign` FOREIGN KEY (`footer_id`) REFERENCES `footers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table probashi.footer_section_twos: ~0 rows (approximately)

-- Dumping structure for table probashi.headers
CREATE TABLE IF NOT EXISTS `headers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table probashi.headers: ~1 rows (approximately)
INSERT INTO `headers` (`id`, `logo`, `created_at`, `updated_at`) VALUES
	(2, 'logos/iuh3xxS0sI8wCnd27hrGpfvRo8AjDEBatnbfhc3S.jpg', '2025-07-26 22:58:45', '2025-07-26 22:58:45');

-- Dumping structure for table probashi.hero_sections
CREATE TABLE IF NOT EXISTS `hero_sections` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `background_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_small` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_big` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table probashi.hero_sections: ~1 rows (approximately)
INSERT INTO `hero_sections` (`id`, `background_image`, `title_small`, `title_big`, `created_at`, `updated_at`) VALUES
	(3, 'background_images/fK6BWutFGYcf8U9e8tklKZPB3kGs5LkuTwIIEoCg.png', 'Need Help Abroad', 'We are here to help you', '2025-07-20 03:31:27', '2025-07-20 03:31:27');

-- Dumping structure for table probashi.home_data
CREATE TABLE IF NOT EXISTS `home_data` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `section_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table probashi.home_data: ~0 rows (approximately)
INSERT INTO `home_data` (`id`, `section_title`, `created_at`, `updated_at`) VALUES
	(1, 'asdfasdf', '2024-08-16 22:50:09', '2024-08-16 22:50:09');

-- Dumping structure for table probashi.home_data_items
CREATE TABLE IF NOT EXISTS `home_data_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `home_data_id` bigint unsigned NOT NULL,
  `item_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_des` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `home_data_items_home_data_id_foreign` (`home_data_id`),
  CONSTRAINT `home_data_items_home_data_id_foreign` FOREIGN KEY (`home_data_id`) REFERENCES `home_data` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table probashi.home_data_items: ~0 rows (approximately)
INSERT INTO `home_data_items` (`id`, `home_data_id`, `item_image`, `item_title`, `item_des`, `created_at`, `updated_at`) VALUES
	(1, 1, 'images/4yLbAUi4ipUxN1SQOilFDi8AAVkktoK9VQrHNuG5.png', 'adsf', 'f', '2024-08-16 22:50:18', '2024-08-16 22:50:18');

-- Dumping structure for table probashi.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
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

-- Dumping data for table probashi.jobs: ~0 rows (approximately)

-- Dumping structure for table probashi.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
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

-- Dumping data for table probashi.job_batches: ~0 rows (approximately)

-- Dumping structure for table probashi.maintains
CREATE TABLE IF NOT EXISTS `maintains` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `maintain_type_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `maintains_maintain_type_id_foreign` (`maintain_type_id`),
  KEY `maintains_user_id_foreign` (`user_id`),
  CONSTRAINT `maintains_maintain_type_id_foreign` FOREIGN KEY (`maintain_type_id`) REFERENCES `maintain_types` (`id`) ON DELETE CASCADE,
  CONSTRAINT `maintains_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table probashi.maintains: ~0 rows (approximately)
INSERT INTO `maintains` (`id`, `maintain_type_id`, `name`, `photo`, `user_id`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Property Chittagong', 'photos/pCbQ9V2QPKdAgCoa3NAcUFmWTc6oe7a1Z9dxLgD6.webp', 1, '2025-07-26 23:33:15', '2025-07-26 23:33:15');

-- Dumping structure for table probashi.maintain_types
CREATE TABLE IF NOT EXISTS `maintain_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `maintain_types_user_id_foreign` (`user_id`),
  CONSTRAINT `maintain_types_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table probashi.maintain_types: ~0 rows (approximately)
INSERT INTO `maintain_types` (`id`, `type`, `user_id`, `created_at`, `updated_at`) VALUES
	(1, 'Amenity One', 1, '2025-07-26 23:32:08', '2025-07-26 23:32:08');

-- Dumping structure for table probashi.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table probashi.migrations: ~40 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2024_03_09_225738_create_entire_properties_table', 1),
	(5, '2024_05_04_085346_create_permission_tables', 1),
	(6, '2024_05_31_122519_create_countries_table', 1),
	(7, '2024_05_31_122551_create_cities_table', 1),
	(8, '2024_05_31_122627_create_areas_table', 1),
	(9, '2024_05_31_122652_create_property_types_table', 1),
	(10, '2024_05_31_122719_create_properties_table', 1),
	(11, '2024_05_31_122745_create_maintain_types_table', 1),
	(12, '2024_05_31_122813_create_maintains_table', 1),
	(13, '2024_05_31_122840_create_amenity_types_table', 1),
	(14, '2024_05_31_122909_create_amenities_table', 1),
	(15, '2024_06_03_075503_create_packages_table', 1),
	(16, '2024_06_03_075543_create_rooms_table', 1),
	(17, '2024_06_03_075649_create_package_maintains_table', 1),
	(18, '2024_06_03_075728_create_package_amenities_table', 1),
	(19, '2024_06_03_075831_create_photos_table', 1),
	(20, '2024_06_06_103923_create_room_prices_table', 1),
	(21, '2024_06_10_002741_add_video_link_to_packages_table', 1),
	(22, '2024_06_10_010842_add_package_id_to_entire_properties_table', 1),
	(23, '2024_06_10_105212_add_phone_to_users_table', 1),
	(24, '2024_06_20_042545_create_bookings_table', 1),
	(25, '2024_06_20_042641_create_payments_table', 1),
	(26, '2024_07_02_081135_create_headers_table', 1),
	(27, '2024_07_02_081156_create_hero_sections_table', 1),
	(28, '2024_07_02_081217_create_footers_table', 1),
	(29, '2024_07_02_081446_create_terms_and_privacy_table', 1),
	(30, '2024_07_02_112310_create_footer_section_twos_table', 1),
	(31, '2024_07_02_112407_create_footer_section_threes_table', 1),
	(32, '2024_07_02_114405_create_footer_section_fours_table', 1),
	(33, '2024_07_02_114531_create_social_links_table', 1),
	(34, '2024_07_07_164304_create_home_data_table', 1),
	(35, '2024_07_07_170550_create_home_data_items_table', 1),
	(36, '2024_07_14_185728_create_privacy_policies_table', 1),
	(37, '2024_07_14_185730_create_terms_conditions_table', 1),
	(38, '2024_07_15_172202_add_proof_fields_to_users_table', 1),
	(39, '2024_07_31_160825_create_partner_terms_conditions_table', 1),
	(40, '2024_08_01_205830_add_room_id_to_bookings_table', 1);

-- Dumping structure for table probashi.model_has_permissions
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table probashi.model_has_permissions: ~0 rows (approximately)

-- Dumping structure for table probashi.model_has_roles
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table probashi.model_has_roles: ~5 rows (approximately)
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
	(1, 'App\\Models\\User', 1),
	(4, 'App\\Models\\User', 2),
	(1, 'App\\Models\\User', 7),
	(4, 'App\\Models\\User', 10),
	(3, 'App\\Models\\User', 11);

-- Dumping structure for table probashi.packages
CREATE TABLE IF NOT EXISTS `packages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `country_id` bigint unsigned NOT NULL,
  `city_id` bigint unsigned NOT NULL,
  `area_id` bigint unsigned NOT NULL,
  `property_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `map_link` text COLLATE utf8mb4_unicode_ci,
  `number_of_rooms` int NOT NULL,
  `number_of_kitchens` int NOT NULL,
  `common_bathrooms` int NOT NULL,
  `seating` int NOT NULL,
  `details` text COLLATE utf8mb4_unicode_ci,
  `video_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `packages_country_id_foreign` (`country_id`),
  KEY `packages_city_id_foreign` (`city_id`),
  KEY `packages_area_id_foreign` (`area_id`),
  KEY `packages_property_id_foreign` (`property_id`),
  KEY `packages_user_id_foreign` (`user_id`),
  CONSTRAINT `packages_area_id_foreign` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `packages_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE,
  CONSTRAINT `packages_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE,
  CONSTRAINT `packages_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE,
  CONSTRAINT `packages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table probashi.packages: ~0 rows (approximately)

-- Dumping structure for table probashi.package_amenities
CREATE TABLE IF NOT EXISTS `package_amenities` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `package_id` bigint unsigned NOT NULL,
  `amenity_id` bigint unsigned NOT NULL,
  `price` decimal(8,2) DEFAULT NULL,
  `is_paid` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `package_amenities_package_id_foreign` (`package_id`),
  KEY `package_amenities_amenity_id_foreign` (`amenity_id`),
  KEY `package_amenities_user_id_foreign` (`user_id`),
  CONSTRAINT `package_amenities_amenity_id_foreign` FOREIGN KEY (`amenity_id`) REFERENCES `amenities` (`id`) ON DELETE CASCADE,
  CONSTRAINT `package_amenities_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE,
  CONSTRAINT `package_amenities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table probashi.package_amenities: ~0 rows (approximately)

-- Dumping structure for table probashi.package_maintains
CREATE TABLE IF NOT EXISTS `package_maintains` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `package_id` bigint unsigned NOT NULL,
  `maintain_id` bigint unsigned NOT NULL,
  `price` decimal(8,2) DEFAULT NULL,
  `is_paid` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `package_maintains_package_id_foreign` (`package_id`),
  KEY `package_maintains_maintain_id_foreign` (`maintain_id`),
  KEY `package_maintains_user_id_foreign` (`user_id`),
  CONSTRAINT `package_maintains_maintain_id_foreign` FOREIGN KEY (`maintain_id`) REFERENCES `maintains` (`id`) ON DELETE CASCADE,
  CONSTRAINT `package_maintains_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE,
  CONSTRAINT `package_maintains_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table probashi.package_maintains: ~0 rows (approximately)

-- Dumping structure for table probashi.partner_terms_conditions
CREATE TABLE IF NOT EXISTS `partner_terms_conditions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table probashi.partner_terms_conditions: ~0 rows (approximately)

-- Dumping structure for table probashi.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table probashi.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table probashi.payments
CREATE TABLE IF NOT EXISTS `payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `booking_id` bigint unsigned NOT NULL,
  `payment_method` enum('cash','card','bank_transfer') COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payments_booking_id_foreign` (`booking_id`),
  CONSTRAINT `payments_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table probashi.payments: ~0 rows (approximately)

-- Dumping structure for table probashi.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table probashi.permissions: ~13 rows (approximately)
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'package.create', 'web', '2024-08-04 10:57:40', '2024-08-04 10:57:40'),
	(2, 'package.edit', 'web', '2024-08-04 10:57:40', '2024-08-04 10:57:40'),
	(3, 'package.show', 'web', '2024-08-04 10:57:40', '2024-08-04 10:57:40'),
	(4, 'package.delete', 'web', '2024-08-04 10:57:40', '2024-08-04 10:57:40'),
	(5, 'booking', 'web', '2024-08-04 10:57:40', '2024-08-04 10:57:40'),
	(6, 'user', 'web', '2024-08-04 10:57:40', '2024-08-04 10:57:40'),
	(7, 'earning', 'web', '2024-08-04 10:57:40', '2024-08-04 10:57:40'),
	(8, 'role.permission', 'web', '2024-08-04 10:57:40', '2024-08-04 10:57:40'),
	(9, 'package.setup', 'web', '2024-08-04 10:57:40', '2024-08-04 10:57:40'),
	(10, 'dashboard', 'web', '2024-08-04 10:57:40', '2024-08-04 10:57:40'),
	(11, 'my-packages', 'web', '2024-08-04 10:57:40', '2024-08-04 10:57:40'),
	(12, 'package', 'web', '2024-08-04 10:57:40', '2024-08-04 10:57:40'),
	(13, 'site.settings', 'web', '2024-08-04 10:57:40', '2024-08-04 10:57:40');

-- Dumping structure for table probashi.photos
CREATE TABLE IF NOT EXISTS `photos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `package_id` bigint unsigned NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `photos_package_id_foreign` (`package_id`),
  KEY `photos_user_id_foreign` (`user_id`),
  CONSTRAINT `photos_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE,
  CONSTRAINT `photos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table probashi.photos: ~0 rows (approximately)

-- Dumping structure for table probashi.privacy_policies
CREATE TABLE IF NOT EXISTS `privacy_policies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table probashi.privacy_policies: ~0 rows (approximately)
INSERT INTO `privacy_policies` (`id`, `title`, `content`, `created_at`, `updated_at`) VALUES
	(1, 'gsfdg', 'gsdfgsdfgsdfg', '2024-08-16 22:50:34', '2024-08-16 22:50:34');

-- Dumping structure for table probashi.properties
CREATE TABLE IF NOT EXISTS `properties` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `country_id` bigint unsigned NOT NULL,
  `city_id` bigint unsigned NOT NULL,
  `property_type_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `properties_country_id_foreign` (`country_id`),
  KEY `properties_city_id_foreign` (`city_id`),
  KEY `properties_property_type_id_foreign` (`property_type_id`),
  KEY `properties_user_id_foreign` (`user_id`),
  CONSTRAINT `properties_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE,
  CONSTRAINT `properties_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE,
  CONSTRAINT `properties_property_type_id_foreign` FOREIGN KEY (`property_type_id`) REFERENCES `property_types` (`id`) ON DELETE CASCADE,
  CONSTRAINT `properties_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table probashi.properties: ~0 rows (approximately)
INSERT INTO `properties` (`id`, `country_id`, `city_id`, `property_type_id`, `name`, `photo`, `user_id`, `created_at`, `updated_at`) VALUES
	(1, 1, 2, 1, 'Protocol Service', NULL, 1, '2025-07-27 05:23:44', '2025-07-27 05:23:44');

-- Dumping structure for table probashi.property_types
CREATE TABLE IF NOT EXISTS `property_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `property_types_user_id_foreign` (`user_id`),
  CONSTRAINT `property_types_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table probashi.property_types: ~0 rows (approximately)
INSERT INTO `property_types` (`id`, `type`, `user_id`, `created_at`, `updated_at`) VALUES
	(1, 'Protocol', 1, '2025-07-27 05:23:08', '2025-07-27 05:23:08');

-- Dumping structure for table probashi.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table probashi.roles: ~4 rows (approximately)
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'Super Admin', 'web', '2024-08-04 10:57:40', '2024-08-04 10:57:40'),
	(2, 'Admin', 'web', '2024-08-04 10:57:40', '2024-08-04 10:57:40'),
	(3, 'Partner', 'web', '2024-08-04 10:57:40', '2024-08-04 10:57:40'),
	(4, 'User', 'web', '2024-08-04 10:57:40', '2024-08-04 10:57:40');

-- Dumping structure for table probashi.role_has_permissions
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table probashi.role_has_permissions: ~13 rows (approximately)
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
	(1, 1),
	(2, 1),
	(3, 1),
	(4, 1),
	(5, 1),
	(6, 1),
	(7, 1),
	(8, 1),
	(9, 1),
	(10, 1),
	(11, 1),
	(12, 1),
	(13, 1);

-- Dumping structure for table probashi.rooms
CREATE TABLE IF NOT EXISTS `rooms` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `package_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number_of_beds` int NOT NULL,
  `number_of_bathrooms` int NOT NULL,
  `day_deposit` decimal(8,2) DEFAULT NULL,
  `weekly_deposit` decimal(8,2) DEFAULT NULL,
  `monthly_deposit` decimal(8,2) DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rooms_package_id_foreign` (`package_id`),
  KEY `rooms_user_id_foreign` (`user_id`),
  CONSTRAINT `rooms_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rooms_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table probashi.rooms: ~0 rows (approximately)

-- Dumping structure for table probashi.room_prices
CREATE TABLE IF NOT EXISTS `room_prices` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `room_id` bigint unsigned DEFAULT NULL,
  `type` enum('Day','Week','Month') COLLATE utf8mb4_unicode_ci NOT NULL,
  `fixed_price` decimal(8,2) NOT NULL,
  `discount_price` decimal(8,2) DEFAULT NULL,
  `booking_price` decimal(8,2) NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `entire_property_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `room_prices_room_id_foreign` (`room_id`),
  KEY `room_prices_user_id_foreign` (`user_id`),
  KEY `room_prices_entire_property_id_foreign` (`entire_property_id`),
  CONSTRAINT `room_prices_entire_property_id_foreign` FOREIGN KEY (`entire_property_id`) REFERENCES `entire_properties` (`id`) ON DELETE CASCADE,
  CONSTRAINT `room_prices_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  CONSTRAINT `room_prices_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table probashi.room_prices: ~0 rows (approximately)

-- Dumping structure for table probashi.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
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

-- Dumping data for table probashi.sessions: ~55 rows (approximately)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('2c3tVbiTDDdE0Lu2K4AAhGfSsdsUNQRyfy8B48ow', NULL, '35.90.89.252', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUm5FMFdpbHh5S1ZEcVFSVGtvRjhUWjEzMHdOY01hUk5URkR0azhWWiI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyNDoiaHR0cHM6Ly9wcm9iYXNoaXBsdXMuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1752322321),
	('2lTYp2PgY3DEDIZTbfmVNFLNJSsf0S2wN0956J6r', NULL, '149.56.150.88', 'Mozilla/5.0 (compatible; Dataprovider.com)', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiempxUkw5dmluNkZGdlpJWlRYb2dPbDJ1bFFPdEgxUXJDV01BanhUUiI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyNzoiaHR0cDovL3d3dy5wcm9iYXNoaXBsdXMuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1752321577),
	('3a0qkkPrab8Py9G5Sgy5k6iCMBXp8ElfBDew7Cy6', NULL, '160.202.146.107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiRnRJaHE2eHlVbWpjRUk5ckZ1ZkJrVDVCcUZCQTVFRXpWYzh1R0tCRCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMDoiaHR0cHM6Ly9wcm9iYXNoaXBsdXMuY29tL2FkbWluIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vcHJvYmFzaGlwbHVzLmNvbS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MTg6ImZsYXNoZXI6OmVudmVsb3BlcyI7YTowOnt9fQ==', 1752408133),
	('3PsLi1RMmlSppLIQ466YrS7nE7gmDWiLU4vU1zQ6', NULL, '104.248.194.95', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVVBqeWlTeWxBZ0ZsNXpVYmNvQXVWclpBbDlGTEUxQ0pmN2pZQ3hpWCI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyNDoiaHR0cHM6Ly9wcm9iYXNoaXBsdXMuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1752409437),
	('5qSJXVLpYY3hDJ9N4SdkkEVTnZv1ZSyHjA8pZRVi', NULL, '143.110.223.199', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibjYwck1WZElwUTdaRnZ4N25PdUhROEs5Unp2MlhibWZBQldNRkhXNiI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyMzoiaHR0cDovL3Byb2Jhc2hpcGx1cy5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1752930326),
	('6cBkT9cPxh5qJWMY0FhiJWbsBzcWL0fYEFcNzPc1', NULL, '160.202.146.107', 'WhatsApp/2.2526.2 W', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNkNmNWFkUmpYNEtwbzR1c3VTMHdvRWhyRVBpY3hMSGdJMVhCUzlJSSI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyNDoiaHR0cHM6Ly9wcm9iYXNoaXBsdXMuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1752467808),
	('6yetjL3cNv7QNmt5NqMK80gYFgJTlNdQPWXvr3tl', NULL, '138.197.9.219', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoib0N3aFRmYkluaWU4cjZ2NTNuS2F5OHR5MlRGcVB5MVBoaWwzZGxjaCI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyMzoiaHR0cDovL3Byb2Jhc2hpcGx1cy5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1752583814),
	('8MCtJmBwAIH1YxLul2gUge5GtOc9W6UoQ2Zgc5tS', NULL, '149.56.160.241', 'Mozilla/5.0 (Linux; Android 10; SM-G981B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.162 Mobile Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoieTB6UFZBMlBVU0JBaGFGd2Jtc28zYXhXREgwRzlKNlJWdUN5TGY3byI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyNzoiaHR0cDovL3d3dy5wcm9iYXNoaXBsdXMuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1752321553),
	('8NIBOyJ7GEljzFvtdvcqVGO8sbFz1Taant7X5Yww', NULL, '5.133.192.87', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWVcyU1E4bXVNZHk5eWphTUFuU0pOVm43RHNoR2NSRzlDcEZrbHhoMiI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyNDoiaHR0cHM6Ly9wcm9iYXNoaXBsdXMuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1752723003),
	('aq66Ynt0smU3nUaFRCHKCefemV3mcqfpj4JGR6DA', NULL, '23.105.143.125', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTlpkaUFVb2VtSGxTMEM0SlNVQ2hJMnZsaUI2aDlFTzBSb2lqdnA2NiI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozMzoiaHR0cHM6Ly9wcm9iYXNoaXBsdXMuY29tL3BhY2thZ2VzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1752508031),
	('bCKO8LdUBTCaWAeHABkBRCVjZNSqSO2kEDLIAHb0', NULL, '185.191.171.4', 'Mozilla/5.0 (compatible; SemrushBot/7~bl; +http://www.semrush.com/bot.html)', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWVhSa2hVTXVLbTd6VVNaRXdENmZVZzY2WUNHTGlZcnJDeGpFVUdhSyI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyNDoiaHR0cHM6Ly9wcm9iYXNoaXBsdXMuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1752759222),
	('BvwFc0kIxHGh6uqJTlqKMbEhse8XQ1WbqEB7ffnN', NULL, '44.244.20.63', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/68.0.3440.106 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTTFZTU9DSFZSNWcweW5CbFVKNUYxdHBFMnV3R3F2S0JSMDM2YjJ5dyI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyMzoiaHR0cDovL3Byb2Jhc2hpcGx1cy5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1752322329),
	('CRQuqwmiVl8YpkBZBr0ewLezG7Boe88vAy8w459H', NULL, '40.77.167.73', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm) Chrome/116.0.1938.76 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZ1B2QzJhNlJUSjRiTExMU2hTSkhpTW96MVp4a2ZRSjZhUmxqTk82NiI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0MDoiaHR0cHM6Ly9wcm9iYXNoaXBsdXMuY29tL3BhY2thZ2VzP3BhZ2U9MSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1752820984),
	('d0J3WKYIxg2GIKBtl0bvpQZZQoCAHaZGXDWqXwN2', NULL, '146.190.47.212', 'Mozilla/5.0 (X11; Linux x86_64; rv:137.0) Gecko/20100101 Firefox/137.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUlVJNGhWMG1CNWtncEtRekVZY2tWNGkzeHFoN1hVS2VkM0pRTTVkYiI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyNDoiaHR0cHM6Ly9wcm9iYXNoaXBsdXMuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1752729959),
	('eXgCVaweOVXJDVjX07n14M8M9rL8E0T4Lq8VonWs', NULL, '209.38.242.21', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMUFJVEFmbTh2VEFuR0YwdmpyWGxCMjNZTGJXV0w1V1puUmt6Mjh6bSI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyNzoiaHR0cDovL3d3dy5wcm9iYXNoaXBsdXMuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1752761099),
	('ExZKVikevX600ESrs3WO5VWJI4lqxafqb1JbDXFu', NULL, '52.40.14.62', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.97 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRERMWURGVzJPa21qNkYybGw2VW1WRmlFdzJ3VVVWMklvcklpMjRMMSI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyNDoiaHR0cHM6Ly9wcm9iYXNoaXBsdXMuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1752573065),
	('Fx8TivnwPkiAuiFpU7KKni1Vn3zMpii33rum9tyt', NULL, '66.249.66.10', 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWmhPQXg2U1hPa1Q4UWFNWGF6dE1KbThOdmQ4eG02b0NoQVRKc0N4ZyI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyNDoiaHR0cHM6Ly9wcm9iYXNoaXBsdXMuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1752842653),
	('gkck7pMZhnK42NuNM5rDHOPjn365CaQPSQVlNXRG', NULL, '206.189.122.48', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidzNWVzl3aE1kTm9sMVo3YVpvRWUwWDdxT1RsS2d5cWFMWnc1ZVZ3cSI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyOToiaHR0cHM6Ly9tYWlsLnByb2Jhc2hpcGx1cy5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1752677915),
	('gWOpkbzw6LzlJeEKOCb2NWEIpj6mZPmsZZhV6GYe', NULL, '160.202.146.107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZ1hvMmRManNEVjIxSDExWVZ3QXgwM0o0d3RrVlRwMDRoTXhxcHRRRSI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyNDoiaHR0cHM6Ly9wcm9iYXNoaXBsdXMuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1752603339),
	('h9t5iGSkMSBn3sAnbWhiVJ2T3th1sL1IaT9coYg3', NULL, '17.241.75.199', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.4 Safari/605.1.15 (Applebot/0.1; +http://www.apple.com/go/applebot)', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiN2Q3ZFQ1dDVESHFDbDlHeGhWU2VwajVYZEI0VDl6N1VRYzU0ZmRMMCI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0MzoiaHR0cHM6Ly93d3cucHJvYmFzaGlwbHVzLmNvbS9wcml2YWN5LXBvbGljeSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1752856878),
	('HnXwWhLcBWZaWXNl0NYDDrBvHtwx4N38sfeHyDO7', NULL, '35.90.89.252', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUVNjMmZ2Z1Q0aGkxeExoemRUMkV0emt6QkhORUp6bGEyU3VuQlJFRyI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyMzoiaHR0cDovL3Byb2Jhc2hpcGx1cy5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1752322319),
	('IMl8taUpkbFeXQy7RrKaSqm0YFxgx3n3PMeovb7h', NULL, '42.236.17.70', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36; 360Spider', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibXNubVRIelhaOWE4MVpHdVF5bTZpMVpqd0lWMmRvVWxYMkk3dm1TaiI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyNzoiaHR0cDovL3d3dy5wcm9iYXNoaXBsdXMuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1752392745),
	('IyVFAbk9EprJMNol3piVnEYXEQz6knDQBUT4J8WG', NULL, '66.249.66.10', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.7151.103 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNXNZa3hOb3Y4Q21UOVEydkRZOGtKbDdqTVFXUGxZSUgwQktXMEE0eiI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyNDoiaHR0cHM6Ly9wcm9iYXNoaXBsdXMuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1752842653),
	('jkp2Q4GQzAPAJQumHugxik1ioCCOJUu2X7Nsue4w', NULL, '34.136.68.155', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaWI0SVZHSlVWbHhFcmlDV0pMY2Z4Vjhmdmh4bDl6YVFlc0h4NUg4WCI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyMzoiaHR0cDovL3Byb2Jhc2hpcGx1cy5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1752514272),
	('kiQd3MgI9BmuFiM2lKcIckZGIkAoHitsHsXGByIn', NULL, '149.56.150.88', 'Mozilla/5.0 (compatible; Dataprovider.com)', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRjQzanBZeEQwWmdDTkVnN0cwVE5oMFJMMEpxQlNWR1Vic1ZkRWY2bSI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyODoiaHR0cHM6Ly93d3cucHJvYmFzaGlwbHVzLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1752321582),
	('kNNMcpIGWxvfmJxFLAY3eHVe7zEISOKbIVhRsWDW', NULL, '34.50.84.218', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiR0VxM010Q2JjSXlTOGltRVN5SGZ3aGpWN0xET3E4TkxPc0hKSmFTUiI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyMzoiaHR0cDovL3Byb2Jhc2hpcGx1cy5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1752884415),
	('KOkIH07kX1ivTbpiaMsnsgQiEypruYmnWu2698M1', NULL, '42.236.17.196', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36; 360Spider', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRWFNN3Z1Qk5tWE5YSUJsYll5SXBxS0FHbUJSeTN4RjZWdEdZTFMxTCI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyNzoiaHR0cDovL3d3dy5wcm9iYXNoaXBsdXMuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1752751177),
	('kPPIipd716yVubXiN2gvJrONfliXDMig3Y6VZPtQ', NULL, '44.244.130.214', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/68.0.3440.106 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRTRBaFZGNllQaUExSDViNXFyVGtjVXdXclhjY0IyM3poZDJTVWdIMyI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyMzoiaHR0cDovL3Byb2Jhc2hpcGx1cy5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1752586096),
	('KwuvEnMNO4xOPUirRyhaYvjFS6CC1g6Se57tzZxh', NULL, '42.236.17.199', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36; 360Spider', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicU5NZEpDSmtnNkVybGtocTAwQkxjUk5WcTFpR2ZoTkd4OGR2ZDAzRyI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyMzoiaHR0cDovL3Byb2Jhc2hpcGx1cy5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1752410465),
	('L14LXb4hpQUvaaczIWNzmXRRaIDFBFwIIMP0G1wV', NULL, '207.46.13.9', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm) Chrome/116.0.1938.76 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicEx3WDJON3F0bFZXdjRXOVlqSmJMcEhiYkpPeGJ1STVhN3R6bldyayI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyNDoiaHR0cHM6Ly9wcm9iYXNoaXBsdXMuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1752878066),
	('lezi5KyrgPIK92uZLE4Qn6cqk0EFZ6zcnMQPfuFN', NULL, '54.191.179.48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidVhYZEN1bkVsM0o1TTRnbWNhY0E2NWwybFVDUHBqWlJXUzd2WDNOdCI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyMzoiaHR0cDovL3Byb2Jhc2hpcGx1cy5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1752586091),
	('M1CyrmWdAbFj0Lk4CqRJVE2RpkCRRBwl8BD5fpF6', NULL, '54.213.72.181', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/68.0.3440.106 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZ2ptQlprMERQQW00bTJMZGtxeFdIdXVFSDVVcHZDZXIxMVY5R2JMSiI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyMzoiaHR0cDovL3Byb2Jhc2hpcGx1cy5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1752322336),
	('mUCnYpiTMNucjdp6nvdQvF3pc3PFWfxTWYZXT1Cs', NULL, '44.245.100.217', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/68.0.3440.106 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUzJkSmk4WFhDZFNCU243amE2MzNxb0NMMXN1dFFVc3NJdDVuYkIxNyI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyMzoiaHR0cDovL3Byb2Jhc2hpcGx1cy5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1752586101),
	('n8Ad6qQfwi2eGmY9qqk2PJwHRcYMWQIBIJgVLY39', NULL, '3.84.111.86', 'Mozilla/5.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoid0Y3Z2EzOGFpNnhaZjRua3Z1anlKcFR1THkyeHBsWHFuWFN1TDVtMCI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyMzoiaHR0cDovL3Byb2Jhc2hpcGx1cy5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1752867264),
	('nJ8wkOsvcj14H0PAY1rkj8dbKWbrLnXcnLta0Vt5', NULL, '3.253.211.203', 'Pandalytics/2.0 (https://domainsbot.com/pandalytics/)', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSzhQdGo0TUxKekJCU2VtUm9HZVdXM2dpUkI4V2xDWVR4djBIUGtDZyI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyMzoiaHR0cDovL3Byb2Jhc2hpcGx1cy5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1752643417),
	('Nw4KUSt4a5lE8GWJcgOeD65LOAVvT2cMcaEsafaE', NULL, '45.95.243.10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiamJjTm9hNUx5Sk9HZTRCcG43cGl3ZFk2emlFdGFQcWV3cVhYUEUxUCI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyMzoiaHR0cDovL3Byb2Jhc2hpcGx1cy5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1752486299),
	('oeUGziSlZUuphhfQDvtEP9PwmHTgHJI5tFkBTflK', NULL, '146.190.47.212', 'Mozilla/5.0 (X11; Linux x86_64; rv:137.0) Gecko/20100101 Firefox/137.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYTNvZVZudE9IZzBMckR5TlZmV2lNZFgxRFdsaVByU0d1akFrcm9BQSI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyMzoiaHR0cDovL3Byb2Jhc2hpcGx1cy5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1752729958),
	('oLEMzrUbfqRvw9PlGikNYV2OpFdkZe69zs7qD8R5', NULL, '138.197.9.219', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibWxIMGhvWXdZZ2RkdVFCWnNaSGcyNmRTNDFjNEVpMGdlT0tIeWdqcSI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyNDoiaHR0cHM6Ly9wcm9iYXNoaXBsdXMuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1752583814),
	('oRkQMceQFledgEuNxUoHDqrWQ77KrIGcmirhFVZl', NULL, '54.191.179.48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQlo2RGREbjdFenFESGVFMmF5amNwVTFYVWhXYTlhaWl2bFkyS1dTTyI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyNDoiaHR0cHM6Ly9wcm9iYXNoaXBsdXMuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1752586092),
	('Q4LxklS1zOQjezThT0j1seeaSpMQvLEXR4I4Udi6', NULL, '44.195.98.156', 'Python/3.10 aiohttp/3.12.14', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTm9yV1czQ2tJbjdISU1NeXpmMURmbFBxaW04aHVQQ1BuaTdtdTNXcyI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyNDoiaHR0cHM6Ly9wcm9iYXNoaXBsdXMuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1752712617),
	('rvGXszKlHaQm92DKC9Kb8aR9uesNDybZHeWU8xsl', NULL, '142.93.43.9', 'Mozilla/5.0 (X11; Linux x86_64; rv:137.0) Gecko/20100101 Firefox/137.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibE1HeHBERWtqaTJwTFBaS1hxZGUwTm8xamRvcUZkSXhNRHV4OWsxNCI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyNDoiaHR0cHM6Ly9wcm9iYXNoaXBsdXMuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1752757193),
	('SKJLbg7qNNNCMVIakXLHlPU1bOzquzvx6cNF3yTd', NULL, '68.183.129.11', 'curl/7.88.1', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRlNjb0VHeWlRMnpScjRxU01TMFJoNDRKUTRtUm0zNVZTVG1xZFFldiI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyMzoiaHR0cDovL3Byb2Jhc2hpcGx1cy5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1752897841),
	('TAOM75kKRfkBfryOvYCLGPfC3TEOpp05FSvPZ44t', NULL, '185.191.171.11', 'Mozilla/5.0 (compatible; SemrushBot/7~bl; +http://www.semrush.com/bot.html)', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUkJsSXphemVLVWg4SGNwb0ZwelYwV0ttSzhSVUxOUTVlYk43ZnZkQyI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozOToiaHR0cHM6Ly9wcm9iYXNoaXBsdXMuY29tL3ByaXZhY3ktcG9saWN5Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1752407329),
	('te5C7kJk5sgmV8ViatEO8Q5HRbySThxlHhJ0Cjki', NULL, '149.56.160.241', 'Mozilla/5.0 (compatible; Dataprovider.com)', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiT0kxNG1maEMyaEZlbEQwN0E2dWp2d01IbGVUT3ZrOFB6R2xwMzRXSyI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyODoiaHR0cHM6Ly93d3cucHJvYmFzaGlwbHVzLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1752321546),
	('TG4H7Qt6XYpSkEwX9tA2hPQ99oTIYLuqwDAuiEZn', NULL, '143.110.223.199', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYnp1a1p4dDFhd1VQeklZWDVjd0x6NWc3Nm10MHdkODJRdjA4UUtSdSI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyNDoiaHR0cHM6Ly9wcm9iYXNoaXBsdXMuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1752930327),
	('tWDr5pmFdBV4lfdnxWmwJrvidyKCEUycw13yybr3', 1, '160.202.146.107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiVlVkWG01eVgyWTJWc1hyMnZmMEkwaVNkZWZKZUxRRTN6NmltTmJhaSI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozMDoiaHR0cHM6Ly9wcm9iYXNoaXBsdXMuY29tL3VzZXJzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1752513671),
	('uCFZcGXMvBAWhyEui3ufIYgb9CgfHDvgCHofZGBA', NULL, '209.38.242.21', 'Mozilla/5.0 (X11; Linux x86_64; rv:137.0) Gecko/20100101 Firefox/137.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZ1FMaGExUnNCN09mZVF0WFphMTgxTUpTSXZSTFY2VDRRZFFEdmlmWCI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyODoiaHR0cHM6Ly93d3cucHJvYmFzaGlwbHVzLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1752761099),
	('v7mgWs4CEvwJuk9cUrUlKq6zQ3BHEsYptIGzJdxi', NULL, '160.202.146.107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWnFXTXZzYmM4bjhIcU45aWtSYjhOc2d2M3JzRG9qOG5jdzR3YWF2aCI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyNDoiaHR0cHM6Ly9wcm9iYXNoaXBsdXMuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1752487734),
	('vbnaITJL3JLjrVhFBWypuJtdAexPUG2gg2Rbe78c', NULL, '206.189.122.48', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaWtOcTljbWtmRVpZTVF4RmE4Qkl2T0lKZWJySmdLaTVMYUtmdkRCVSI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyODoiaHR0cDovL21haWwucHJvYmFzaGlwbHVzLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1752677915),
	('vYxaKK02pkCGkJHecbXyWUWU2rjUBzPHZQBcOroP', NULL, '42.236.17.217', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36; 360Spider', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiY1ZZbjZHWmpZNk9ZT3kwUFdDVEJxNjBhZlNwSHJtb3FzZGo5R0czNyI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyMzoiaHR0cDovL3Byb2Jhc2hpcGx1cy5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1752758860),
	('WABheOUtWhST9zP5PU0kY50H7sgMt2AkQGddJdpL', NULL, '104.248.194.95', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRjlYdEpHNGdVTWp6Wm56dzVpVFdaZ1owS25wVnFtUGh4bElwU3JpZiI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyMzoiaHR0cDovL3Byb2Jhc2hpcGx1cy5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1752409435),
	('wAtLRCGetm02EZHKAQAbbxdM05dZro8lgaymyXzV', NULL, '34.19.64.83', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUVBLeVhjdUtTNXVuSkYzYUZOaWN1TGl2TWZkdDdlaE9mcTRDNnZpUyI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyMzoiaHR0cDovL3Byb2Jhc2hpcGx1cy5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1752465576),
	('WlZB3Ib3BYM71mieDCPF8Me9TEL0U71jC4Q8DjFw', NULL, '142.93.43.9', 'Mozilla/5.0 (X11; Linux x86_64; rv:137.0) Gecko/20100101 Firefox/137.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRkxJWnc0a09ERmxVWWFwS2hsOWNWazdMRGdJa0JRcEZmNjdrUmlqaSI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyMzoiaHR0cDovL3Byb2Jhc2hpcGx1cy5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1752757193),
	('wT53xZO9uC7Wjmlw7mSBw3jpCjS0TiphzsoWMNIo', NULL, '42.83.147.55', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko)Chrome/74.0.3729.169 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZjlNU1F4R3VLSVVhS1QxVzlQVFdYTnhwNVZwTWhmYm5WOFlPbjhVeiI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyNDoiaHR0cHM6Ly9wcm9iYXNoaXBsdXMuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1752360658),
	('xwTp43Tz4BVWC4qxFyazX4wiHAMnyybshSuuCRA7', NULL, '45.87.153.22', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiQW85R3JHZ2lZakdRQ0hZSmtJSkl3bEh0bUF4NjN5c0JIUzFCYlVHZSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1752459882);

-- Dumping structure for table probashi.social_links
CREATE TABLE IF NOT EXISTS `social_links` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `footer_section_four_id` bigint unsigned NOT NULL,
  `icon_class` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `social_links_footer_section_four_id_foreign` (`footer_section_four_id`),
  CONSTRAINT `social_links_footer_section_four_id_foreign` FOREIGN KEY (`footer_section_four_id`) REFERENCES `footer_section_fours` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table probashi.social_links: ~0 rows (approximately)

-- Dumping structure for table probashi.terms_and_privacy
CREATE TABLE IF NOT EXISTS `terms_and_privacy` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `terms_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `terms_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `privacy_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `privacy_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rights_reserves_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table probashi.terms_and_privacy: ~0 rows (approximately)

-- Dumping structure for table probashi.terms_conditions
CREATE TABLE IF NOT EXISTS `terms_conditions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table probashi.terms_conditions: ~0 rows (approximately)
INSERT INTO `terms_conditions` (`id`, `title`, `content`, `created_at`, `updated_at`) VALUES
	(1, 'edrtfgujhyrty', 'ujertyuryu', '2024-08-16 22:51:39', '2024-08-16 22:51:39');

-- Dumping structure for table probashi.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `looking_for` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `photo_id_proof_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo_id_proof_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_proof_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_proof_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_phone_number_unique` (`phone_number`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table probashi.users: ~5 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `phone`, `phone_number`, `email_verified_at`, `password`, `country`, `city`, `looking_for`, `remember_token`, `created_at`, `updated_at`, `photo_id_proof_type`, `photo_id_proof_path`, `user_proof_type`, `user_proof_path`) VALUES
	(1, 'Super Admin', 'superadmin@mail.com', '01717893432', '01717893432', NULL, '$2y$12$UT5q/t1gZtdM52pzByqLNO/ttWaiye8L/AxhGlSnI3xZgkvdiOZZW', NULL, NULL, NULL, NULL, '2024-08-04 10:57:40', '2025-07-28 01:36:49', NULL, NULL, NULL, NULL),
	(2, 'Istiak Hossaindfhg', NULL, NULL, NULL, NULL, '$2y$12$FwMeVWKLpUj4Ht6n.tKy.e7IbpwRx.Oeb3JbBfsf0CmUSincrcp5O', NULL, 'Joypurhat', 'Halal Investment', NULL, '2024-08-04 10:58:33', '2024-08-04 10:58:33', NULL, NULL, NULL, NULL),
	(7, 'Super Admin', NULL, NULL, '00991122', NULL, '$2y$12$.J3SNJdoQzY22rLPQeMzJeFYvSazBk.cjm9gVOM/IkiSmbnM9mEZS', NULL, NULL, NULL, 'EJyP1ktY2DEpcZoONQJu1JBLriru9RBWPHO82Bml49ptaBZn6mEoqpI3PaLo', '2024-08-17 08:30:52', '2024-08-17 08:30:52', NULL, NULL, NULL, NULL),
	(10, 'Rashel Mahmud', 'rashel.mahmud@yahoo.com', NULL, '07713196702', NULL, '$2y$12$rsUZDm1GV9wdbMJUr06yMOyIUvoUZ.rNANG6pd2IAIdwj8TbuOVLi', 'United Kingdom', 'Newcastle Upon Tune', '4', NULL, '2024-08-19 17:44:33', '2024-08-19 17:44:57', NULL, NULL, NULL, NULL),
	(11, 'Marshall Weber', 'xymix@mailinator.com', NULL, NULL, NULL, '$2y$12$vrh/eoplTmAIcMMl1mKKfeBdK7UoWTDox.U/LXVSywc4qsB7ots6.', NULL, NULL, NULL, NULL, '2025-07-14 21:20:42', '2025-07-14 21:20:42', NULL, NULL, NULL, NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
