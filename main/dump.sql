CREATE DATABASE IF NOT EXISTS `log1c` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `log1c`;

CREATE TABLE IF NOT EXISTS `accounts` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
  	`username` varchar(50) NOT NULL,
  	`password` varchar(255) NOT NULL,
  	`email` varchar(100) NOT NULL,
	`activation_code` varchar(50) NOT NULL DEFAULT '',
    `rememberme` varchar(255) NOT NULL DEFAULT '',
	`role` enum('Member','Admin') NOT NULL DEFAULT 'Member',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO `accounts` (`id`, `username`, `password`, `email`, `role`) VALUES
(1, 'admin', '$2y$10$ZU7Jq5yZ1U/ifeJoJzvLbenjRyJVkSzmQKQc.X0KDPkfR3qs/iA7O', 'admin@example.com', 'Admin')
