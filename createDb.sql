CREATE TABLE IF NOT EXISTS `users` (
  `user_id` INT(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255),
  `name` varchar(255),
  `last_name` varchar(255),
  `phone` INT(255),
  `password` varchar(255),
  `registered_at` INT(255),
  `last_login_at` INT(255)
  NOT NULL, PRIMARY KEY (`user_id`) )
  ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
