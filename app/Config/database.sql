SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

CREATE TABLE `activities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `description` text NOT NULL,
  `quantity` float NOT NULL DEFAULT '0',
  `measure` text NOT NULL,
  `measure_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE `awarded_badges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `badge_id` int(10) unsigned NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `measure_id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `badges` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `measure_id` int(10) unsigned DEFAULT '0',
  `quantity_goal` float NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `awarded_badges_count` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE `measures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `measure_si` text NOT NULL,
  `measure_pl` text NOT NULL,
  `flag` tinyint(1) NOT NULL,
  `activity_count` int(11) NOT NULL DEFAULT '0',
  `badge_count` int(11) NOT NULL DEFAULT '0',
  `measures_sum_count` int(11) NOT NULL DEFAULT '0' COMMENT 'users_count',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `measures_sums` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_type` varchar(30) NOT NULL DEFAULT '''''',
  `parent_id` int(11) NOT NULL,
  `modified` datetime NOT NULL,
  `measure_id` int(11) NOT NULL,
  `quantity_sum` float NOT NULL,
  `activity_count` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `twitter_id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `access_token` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `access_token_secret` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '''''',
  `location` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '''''',
  `name` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `activity_count` int(11) NOT NULL,
  `awarded_badge_count` int(11) NOT NULL DEFAULT '0',
  `measures_sum_count` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `twitter_id` (`twitter_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
