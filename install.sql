SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE `ed_city` (
  `city_id` int(11) NOT NULL,
  `name` mediumtext NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

INSERT INTO `ed_city` (`city_id`, `name`) VALUES
(1, '中西區'),
(2, '灣仔區'),
(3, '東區'),
(4, '南區'),
(5, '油尖旺區'),
(6, '深水埗區'),
(7, '九龍城區'),
(8, '黃大仙區'),
(9, '觀塘區'),
(10, '葵青區'),
(11, '荃灣區'),
(12, '屯門區'),
(13, '元朗區'),
(14, '北區'),
(15, '大埔區'),
(16, '沙田區'),
(17, '西貢區'),
(18, '離島區');

CREATE TABLE `ed_courses` (
  `courses_id` int(11) NOT NULL,
  `providers_id` int(11) NOT NULL,
  `title` mediumtext NOT NULL,
  `short_description` mediumtext,
  `full_description` mediumtext,
  `city_id` int(3) NOT NULL DEFAULT '1',
  `full_address` mediumtext,
  `teacher` mediumtext,
  `total_seats` int(5) NOT NULL DEFAULT '0',
  `taken_seats` int(5) NOT NULL DEFAULT '0',
  `category_id` int(3) NOT NULL DEFAULT '1',
  `price` mediumtext NOT NULL,
  `remarks` mediumtext,
  `status` int(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `ed_courses_attendance` (
  `attendance_id` int(11) NOT NULL,
  `courses_id` int(11) NOT NULL,
  `lessons_id` int(11) NOT NULL,
  `members_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `ed_courses_category` (
  `category_id` int(11) NOT NULL,
  `name` mediumtext NOT NULL,
  `color` mediumtext NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `ed_courses_documents` (
  `documents_id` int(11) NOT NULL,
  `courses_id` int(11) NOT NULL,
  `path` mediumtext NOT NULL,
  `description` mediumtext,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `ed_courses_lessons` (
  `lessons_id` int(11) NOT NULL,
  `courses_id` int(11) NOT NULL,
  `start_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `ed_courses_photos` (
  `photos_id` int(11) NOT NULL,
  `courses_id` int(11) NOT NULL,
  `path` mediumtext NOT NULL,
  `description` mediumtext,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `ed_courses_registration` (
  `registration_id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `courses_id` int(11) NOT NULL,
  `members_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `ed_members` (
  `members_id` int(11) NOT NULL,
  `username` mediumtext NOT NULL,
  `password` mediumtext NOT NULL,
  `name` mediumtext,
  `email` mediumtext,
  `phone` mediumtext,
  `birth_date` timestamp NULL DEFAULT NULL,
  `edu_level` int(11) DEFAULT NULL,
  `address` mediumtext,
  `scores` mediumtext,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `remember_token` mediumtext
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `ed_providers` (
  `providers_id` int(11) NOT NULL,
  `username` mediumtext NOT NULL,
  `password` mediumtext NOT NULL,
  `title` mediumtext NOT NULL,
  `description` mediumtext,
  `city_id` int(11) NOT NULL,
  `phone` mediumtext,
  `email` mediumtext NOT NULL,
  `office_address` mediumtext,
  `gov_registered` int(11) NOT NULL DEFAULT '0',
  `logo_path` mediumtext,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `remember_token` mediumtext NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `ed_transaction_records` (
  `transaction_id` int(11) NOT NULL,
  `courses_id` int(11) NOT NULL,
  `providers_id` int(11) NOT NULL,
  `members_id` int(11) NOT NULL,
  `amounts` mediumtext NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `ref_id` longtext,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

ALTER TABLE `ed_city`
  ADD PRIMARY KEY (`city_id`);

ALTER TABLE `ed_courses`
  ADD PRIMARY KEY (`courses_id`);

ALTER TABLE `ed_courses_attendance`
  ADD PRIMARY KEY (`attendance_id`);

ALTER TABLE `ed_courses_category`
  ADD PRIMARY KEY (`category_id`);

ALTER TABLE `ed_courses_documents`
  ADD PRIMARY KEY (`documents_id`);

ALTER TABLE `ed_courses_lessons`
  ADD PRIMARY KEY (`lessons_id`);

ALTER TABLE `ed_courses_photos`
  ADD PRIMARY KEY (`photos_id`);

ALTER TABLE `ed_courses_registration`
  ADD PRIMARY KEY (`registration_id`);

ALTER TABLE `ed_members`
  ADD PRIMARY KEY (`members_id`);

ALTER TABLE `ed_providers`
  ADD PRIMARY KEY (`providers_id`);

ALTER TABLE `ed_transaction_records`
  ADD PRIMARY KEY (`transaction_id`);

ALTER TABLE `ed_city`
  MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;

ALTER TABLE `ed_courses`
  MODIFY `courses_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;

ALTER TABLE `ed_courses_attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;

ALTER TABLE `ed_courses_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;

ALTER TABLE `ed_courses_documents`
  MODIFY `documents_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;

ALTER TABLE `ed_courses_lessons`
  MODIFY `lessons_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;

ALTER TABLE `ed_courses_photos`
  MODIFY `photos_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;

ALTER TABLE `ed_courses_registration`
  MODIFY `registration_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;

ALTER TABLE `ed_members`
  MODIFY `members_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;

ALTER TABLE `ed_providers`
  MODIFY `providers_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;

ALTER TABLE `ed_transaction_records`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;