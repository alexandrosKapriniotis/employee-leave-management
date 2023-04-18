-- --------------------------------------------------------
-- Διακομιστής:                  127.0.0.1
-- Έκδοση διακομιστή:            10.1.9-MariaDB - mariadb.org binary distribution
-- Λειτ. σύστημα διακομιστή:     Win32
-- HeidiSQL Έκδοση:              12.0.0.6468
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for employee_portal
CREATE DATABASE IF NOT EXISTS `employee_portal` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `employee_portal`;

-- Dumping structure for πίνακας employee_portal.applications
CREATE TABLE IF NOT EXISTS `applications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `reason` text NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_users_applications` (`user_id`),
  CONSTRAINT `FK_user_applications` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;

-- Dumping data for table employee_portal.applications: ~2 rows (approximately)
INSERT INTO `applications` (`id`, `date_from`, `date_to`, `reason`, `status`, `user_id`, `created_at`) VALUES
	(26, '2023-04-19', '2023-06-26', 'i am going to Paris!', 'approved', 2, '2023-04-17 18:32:04'),
	(27, '2023-06-12', '2023-06-16', 'i am going to Vilnius!!', 'approved', 2, '2023-04-17 18:36:50');

-- Dumping structure for πίνακας employee_portal.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table employee_portal.migrations: ~2 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `created_at`) VALUES
	(1, 'm0001_initial.php', '2023-04-17 17:09:08'),
	(2, 'm0002_applications.php', '2023-04-17 17:09:08');

-- Dumping structure for πίνακας employee_portal.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('employee','admin') DEFAULT 'employee',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=139 DEFAULT CHARSET=latin1;

-- Dumping data for table employee_portal.users: ~4 rows (approximately)
INSERT INTO `users` (`id`, `email`, `first_name`, `last_name`, `password`, `user_type`, `created_at`) VALUES
	(1, 'info@employeeportal.space', 'Alexandros', 'Kapriniotis', '$2y$10$o5KJ0MJQJtIdGI/60k53wugX4L3/lGYv8hvpogZAHgFaLAs1LxFvq', 'admin', '2023-04-17 17:10:30'),
	(2, 'employeeportal597@gmail.com', 'Ash', 'Ketchum', '$2y$10$06ifGtkoqXWxyYfqPqZW3uthUMCGZQrX0JGtQwobrRdSFV3.zP2u.', 'employee', '2023-04-17 17:10:30');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
