SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";




CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(200) NOT NULL,
  `ip_address` varchar(200) NOT NULL,
  `user_agent` varchar(199) NOT NULL,
  `last_activity` varchar(199) NOT NULL,
  `user_data` longtext CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




CREATE TABLE IF NOT EXISTS `email_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `smtp_host` varchar(100) NOT NULL,
  `smtp_port` varchar(100) NOT NULL,
  `smtp_user` varchar(100) NOT NULL,
  `smtp_password` varchar(100) NOT NULL,
  `status` enum('0','1') NOT NULL,
  `deleted` enum('0','1') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




CREATE TABLE IF NOT EXISTS `event_search` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `search_keyword` varchar(250) DEFAULT NULL,
  `searched_at` date DEFAULT NULL,
  `description` longtext,
  `name` varchar(250) DEFAULT NULL,
  `place` longtext,
  `start_time` varchar(200) DEFAULT NULL,
  `event_id` varchar(150) DEFAULT NULL,
  `can_guests_invite` varchar(100) DEFAULT NULL,
  `cover` longtext,
  `picture` longtext,
  `declined_count` varchar(150) DEFAULT NULL,
  `guest_list_enabled` varchar(150) DEFAULT NULL,
  `interested_count` varchar(150) DEFAULT NULL,
  `is_page_owned` varchar(150) DEFAULT NULL,
  `is_viewer_admin` varchar(150) DEFAULT NULL,
  `maybe_count` varchar(150) DEFAULT NULL,
  `noreply_count` varchar(150) DEFAULT NULL,
  `owner` longtext,
  `timezone` varchar(100) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `updated_time` varchar(150) DEFAULT NULL,
  `attending_count` varchar(150) DEFAULT NULL,
  `deleted` enum('0','1') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`searched_at`,`search_keyword`,`name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




CREATE TABLE IF NOT EXISTS `facebook_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `app_name` varchar(100) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `api_id` varchar(250) DEFAULT NULL,
  `api_secret` varchar(250) DEFAULT NULL,
  `user_access_token` varchar(500) DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




CREATE TABLE IF NOT EXISTS `forget_password` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `confirmation_code` varchar(15) CHARACTER SET latin1 NOT NULL,
  `email` varchar(100) CHARACTER SET latin1 NOT NULL,
  `success` int(11) NOT NULL DEFAULT '0',
  `expiration` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




CREATE TABLE IF NOT EXISTS `group_search` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `search_keyword` varchar(200) DEFAULT NULL,
  `searched_at` date DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `icon` varchar(250) DEFAULT NULL,
  `group_id` varchar(250) DEFAULT NULL,
  `picture` longtext,
  `cover` longtext,
  `description` longtext,
  `member_request_count` varchar(250) DEFAULT NULL,
  `owner` longtext,
  `privacy` varchar(250) DEFAULT NULL,
  `updated_time` varchar(200) DEFAULT NULL,
  `deleted` enum('0','1') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`searched_at`,`search_keyword`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `leads` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `date_time` varchar(50) NOT NULL,
  `no_of_search` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `email` (`email`(191),`no_of_search`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




CREATE TABLE IF NOT EXISTS `lead_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mailchimp_api_key` varchar(100) DEFAULT NULL,
  `mailchimp_list_id` varchar(100) DEFAULT NULL,
  `search_limit` int(11) NOT NULL DEFAULT '600',
  `search_result_display_limit` int(11) NOT NULL DEFAULT '50',
  `subscriber_download_limit` int(11) NOT NULL DEFAULT '150',
  `allowed_download_per_email` int(11) NOT NULL DEFAULT '5',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




CREATE TABLE IF NOT EXISTS `location_search` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `search_keyword` varchar(200) DEFAULT NULL,
  `searched_at` date DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `location_id` varchar(200) DEFAULT NULL,
  `website` text,
  `category` varchar(200) DEFAULT NULL,
  `location` longtext,
  `cover` longtext,
  `posts` longtext,
  `picture` longtext,
  `likes` longtext,
  `about` longtext,
  `founded` longtext,
  `is_always_open` varchar(100) DEFAULT NULL,
  `is_verified` varchar(100) DEFAULT NULL,
  `talking_about_count` varchar(150) DEFAULT NULL,
  `link` text,
  `is_published` varchar(50) DEFAULT NULL,
  `is_unclaimed` varchar(50) DEFAULT NULL,
  `fan_count` varchar(150) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `awards` longtext,
  `deleted` enum('0','1') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`search_keyword`,`searched_at`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_name` varchar(250) CHARACTER SET latin1 DEFAULT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;



INSERT INTO `modules` (`id`, `module_name`, `deleted`) VALUES
(1, 'page search', '0'),
(2, 'page search by location', '0'),
(3, 'group search', '0'),
(4, 'user search', '0'),
(5, 'event search', '0');




CREATE TABLE IF NOT EXISTS `package` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `package_name` varchar(250) NOT NULL,
  `module_ids` varchar(250) CHARACTER SET latin1 NOT NULL,
  `monthly_limit` text,
  `price` varchar(20) NOT NULL DEFAULT '0',
  `validity` int(11) NOT NULL,
  `is_default` enum('0','1') NOT NULL,
  `deleted` enum('0','1') CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;



INSERT INTO `package` (`id`, `package_name`, `module_ids`, `monthly_limit`, `price`, `validity`, `is_default`, `deleted`) VALUES
(1, 'Trial', '5,3,1,2,4', '{"5":"0","3":"0","1":"0","2":"0","4":"0"}', 'Trial', 7, '1', '0');




CREATE TABLE IF NOT EXISTS `page_search` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `search_keyword` varchar(200) DEFAULT NULL,
  `phone` varchar(150) DEFAULT NULL,
  `page_id` varchar(150) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `emails` longtext,
  `website` varchar(250) DEFAULT NULL,
  `likes` longtext,
  `about` longtext,
  `founded` varchar(100) DEFAULT NULL,
  `category` varchar(150) DEFAULT NULL,
  `location` longtext,
  `posts` longtext,
  `cover` longtext,
  `picture` longtext,
  `is_always_open` varchar(100) DEFAULT NULL,
  `is_community_page` varchar(100) DEFAULT NULL,
  `is_verified` varchar(100) DEFAULT NULL,
  `mission` longtext,
  `start_info` longtext,
  `username` varchar(150) DEFAULT NULL,
  `talking_about_count` varchar(150) DEFAULT NULL,
  `link` varchar(200) DEFAULT NULL,
  `is_published` varchar(150) DEFAULT NULL,
  `is_unclaimed` varchar(150) DEFAULT NULL,
  `can_post` varchar(150) DEFAULT NULL,
  `can_checkin` varchar(150) DEFAULT NULL,
  `fan_count` varchar(150) DEFAULT NULL,
  `searched_at` date DEFAULT NULL,
  `deleted` enum('0','1') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`searched_at`,`search_keyword`,`name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `page_search_guest` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `search_keyword` varchar(200) DEFAULT NULL,
  `phone` varchar(150) DEFAULT NULL,
  `page_id` varchar(150) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `emails` longtext,
  `website` varchar(250) DEFAULT NULL,
  `likes` longtext,
  `about` longtext,
  `founded` varchar(100) DEFAULT NULL,
  `category` varchar(150) DEFAULT NULL,
  `location` longtext,
  `posts` longtext,
  `cover` longtext,
  `picture` longtext,
  `is_always_open` varchar(100) DEFAULT NULL,
  `is_community_page` varchar(100) DEFAULT NULL,
  `is_verified` varchar(100) DEFAULT NULL,
  `mission` longtext,
  `start_info` longtext,
  `username` varchar(150) DEFAULT NULL,
  `talking_about_count` varchar(150) DEFAULT NULL,
  `link` varchar(200) DEFAULT NULL,
  `is_published` varchar(150) DEFAULT NULL,
  `is_unclaimed` varchar(150) DEFAULT NULL,
  `can_post` varchar(150) DEFAULT NULL,
  `can_checkin` varchar(150) DEFAULT NULL,
  `fan_count` varchar(150) DEFAULT NULL,
  `searched_at` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`searched_at`,`search_keyword`,`name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




CREATE TABLE IF NOT EXISTS `payment_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `paypal_email` varchar(250) NOT NULL,
  `currency` enum('USD','AUD','CAD','EUR','ILS','NZD','RUB','SGD','SEK') NOT NULL,
  `deleted` enum('0','1') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;


INSERT INTO `payment_config` (`id`, `paypal_email`, `currency`, `deleted`) VALUES
(1, 'Paypalemail@example.com', 'EUR', '0');




CREATE TABLE IF NOT EXISTS `transaction_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `verify_status` varchar(200) NOT NULL,
  `first_name` varchar(250) CHARACTER SET utf8 NOT NULL,
  `last_name` varchar(250) CHARACTER SET utf8 NOT NULL,
  `paypal_email` varchar(200) NOT NULL,
  `receiver_email` varchar(200) NOT NULL,
  `country` varchar(100) NOT NULL,
  `payment_date` varchar(250) NOT NULL,
  `payment_type` varchar(100) NOT NULL,
  `transaction_id` varchar(150) NOT NULL,
  `paid_amount` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cycle_start_date` date NOT NULL,
  `cycle_expired_date` date NOT NULL,
  `package_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
ALTER TABLE `transaction_history` ADD `stripe_card_source` TEXT NOT NULL;


CREATE TABLE IF NOT EXISTS `usage_log` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `usage_month` int(11) NOT NULL,
  `usage_year` year(4) NOT NULL,
  `usage_count` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


 CREATE
 ALGORITHM = UNDEFINED
 VIEW `view_usage_log`
 (id,module_id,user_id,usage_month,usage_year,usage_count)
 AS select * from usage_log where `usage_month`=MONTH(curdate()) and `usage_year`= YEAR(curdate()) ;




CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(99) NOT NULL,
  `email` varchar(99) NOT NULL,
  `mobile` varchar(100) NOT NULL,
  `password` varchar(99) NOT NULL,
  `address` text NOT NULL,
  `user_type` enum('Member','Admin') NOT NULL,
  `status` enum('1','0') NOT NULL,
  `add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `activation_code` varchar(20) DEFAULT NULL,
  `expired_date` datetime NOT NULL,
  `package_id` int(11) NOT NULL,
  `deleted` enum('0','1') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;



INSERT INTO `users` (`id`, `name`, `email`, `mobile`, `password`, `address`, `user_type`, `status`, `add_date`, `activation_code`, `expired_date`, `package_id`, `deleted`) VALUES
(1, '', '', '', '', '', 'Admin', '1', '2016-06-11 18:00:00', NULL, '0000-00-00 00:00:00', 0, '0');




CREATE TABLE IF NOT EXISTS `user_search` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `search_keyword` varchar(200) DEFAULT NULL,
  `searched_at` date DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `user_fb_id` varchar(250) DEFAULT NULL,
  `cover` longtext,
  `picture` longtext,
  `install_type` varchar(250) DEFAULT NULL,
  `is_verified` varchar(100) DEFAULT NULL,
  `last_name` varchar(150) DEFAULT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `link` text,
  `deleted` enum('0','1') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`search_keyword`,`searched_at`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `native_api` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `api_key` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;



CREATE TABLE IF NOT EXISTS `widget` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `domain_name` varchar(100) DEFAULT NULL,
  `widget_type` enum('page_search') NOT NULL DEFAULT 'page_search',
  `border` varchar(50) NOT NULL DEFAULT '0px',
  `width` varchar(50) NOT NULL DEFAULT '100%',
  `height` varchar(50) NOT NULL DEFAULT '100%',
  `background` varchar(50) NOT NULL DEFAULT '#ffffff',
  `color` varchar(50) NOT NULL DEFAULT '#000000',
  `icon_color` varchar(50) NOT NULL DEFAULT '31B809E',
  `input_border_color` varchar(50) NOT NULL DEFAULT '#cccccc',
  `button_style` enum('danger','info','primary','success','warning') NOT NULL DEFAULT 'primary',
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




CREATE TABLE `ad_config` (
  `id` int(11) NOT NULL,
  `section1_html` longtext,
  `section1_html_mobile` longtext,
  `section2_html` longtext,
  `section3_html` longtext,
  `section4_html` longtext,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `ad_config`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `ad_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `page_search` CHANGE `link` `link` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `page_search_guest` CHANGE `link` `link` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `location_search` CHANGE `link` `link` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `user_search` CHANGE `link` `link` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

CREATE TABLE `connectivity_config` (
  `id` int(11) NOT NULL,
  `google_api_key` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
ALTER TABLE `connectivity_config`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `connectivity_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
INSERT INTO `connectivity_config` (`id`, `google_api_key`) VALUES
(1, 'AIzaSyBG0sIVBWReW1Q0WGkWO28uGaKWhQp7Q4c');


ALTER TABLE `page_search` ADD `video` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `deleted`;
        ALTER TABLE `location_search` ADD `video` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `deleted`;
        INSERT INTO `modules` (`id`, `module_name`, `deleted`) VALUES (6, 'facebook page insight', '0');
        CREATE TABLE IF NOT EXISTS `facebook_page_insight_page_list` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `user_id` int(11) NOT NULL,
          `page_id` varchar(250) DEFAULT NULL,
          `page_name` text,
          `page_email` varchar(250) DEFAULT NULL,
          `page_cover` longtext,
          `page_profile` longtext,
          `page_access_token` longtext,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
        ALTER TABLE `connectivity_config` ADD `recaptcha_site_key` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `google_api_key`, ADD `recaptcha_secret_key` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `recaptcha_site_key`;

        ALTER TABLE `payment_config` ADD `stripe_secret_key` VARCHAR(150) NOT NULL AFTER `paypal_email`, ADD `stripe_publishable_key` VARCHAR(150) NOT NULL AFTER `stripe_secret_key`;