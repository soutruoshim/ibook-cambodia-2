/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 8.0.28-0ubuntu0.20.04.3 : Database - mightyebook
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*Table structure for table `app_settings` */

DROP TABLE IF EXISTS `app_settings`;

CREATE TABLE `app_settings` (
    `id` int unsigned NOT NULL AUTO_INCREMENT,
    `key` varchar(255) DEFAULT NULL,
    `value` longtext,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


/*Table structure for table `author` */

DROP TABLE IF EXISTS `author`;

CREATE TABLE `author` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `designation` varchar(255) DEFAULT NULL,
  `image` text,
  `youtube_url` text,
  `facebook_url` text,
  `instagram_url` text,
  `twitter_url` text,
  `website_url` text,
  `status` tinyint unsigned DEFAULT '1' COMMENT '0-Inactive,1-Active',
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `category` */

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category` (
	`id` bigint unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(255) DEFAULT NULL,
	`logo` text,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `book` */

DROP TABLE IF EXISTS `book`;

CREATE TABLE `book` (
	`id` bigint unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(255) DEFAULT NULL,
	`category_id` bigint unsigned DEFAULT NULL,
	`author_id` bigint unsigned DEFAULT NULL,
	`type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'file,url',
	`file` text COLLATE utf8mb4_general_ci,
	`logo` text COLLATE utf8mb4_general_ci,
	`description` text COLLATE utf8mb4_general_ci,
	`url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
	`is_popular` tinyint unsigned DEFAULT '1' COMMENT '0-No, 1- Yes',
	`is_featured` tinyint unsigned DEFAULT '1' COMMENT '0-No, 1- Yes',
	`created_at` timestamp NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `slider` */

DROP TABLE IF EXISTS `slider`;

CREATE TABLE `slider` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `url` text COLLATE utf8mb4_general_ci,
  `image` text COLLATE utf8mb4_general_ci,
  `status` tinyint unsigned DEFAULT '1' COMMENT '0-Inactive, 1- Active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
	`id` int unsigned NOT NULL AUTO_INCREMENT,
	`email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
	`password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
	`first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
	`last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
	`user_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'user',
	`profile_image` text COLLATE utf8mb4_general_ci,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`email`,`password`,`first_name`,`last_name`,`user_type`, `profile_image`) values (1,'admin@admin.com','21232f297a57a5a743894a0e4a801fc3','Admin','Admin', 'admin',NULL);

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `book_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_status` enum('pending','paid') COLLATE utf8_bin DEFAULT NULL,
  `paid_document` text COLLATE utf8_bin,
  `status` enum('pending','confirm','cancel') COLLATE utf8_bin NOT NULL DEFAULT 'pending',
  `create_dt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_dt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
COMMIT;


