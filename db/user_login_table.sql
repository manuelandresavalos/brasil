CREATE TABLE IF NOT EXISTS `user_login` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`user_name` varchar(255) NOT NULL,
	`user_email` varchar(255) NOT NULL,
	`user_password` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
)