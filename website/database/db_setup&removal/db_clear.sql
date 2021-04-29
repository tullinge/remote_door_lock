DROP TABLE RDL_users;
DROP TABLE RDL_log;
DROP TABLE RDL_esp32_config;

CREATE TABLE RDL_users (
	`id` INT NOT NULL AUTO_INCREMENT,
	`given_name` VARCHAR(50) NOT NULL,
	`family_name` VARCHAR(50) NOT NULL,
	`email` VARCHAR(150) NOT NULL,
	`rank` int(2) NOT NULL DEFAULT 1,
	`added_by` VARCHAR(150) NOT NULL,
	`time_added` TIMESTAMP NOT NULL DEFAULT NOW(),
	PRIMARY KEY (id),
	ADD UNIQUE KEY `email` (`email`)
);
CREATE TABLE RDL_log (
    `id` INT NOT NULL AUTO_INCREMENT,
	`given_name` VARCHAR(50) NOT NULL,
	`family_name` VARCHAR(50) NOT NULL,
	`email` VARCHAR(150) NOT NULL,
	`time` TIMESTAMP NOT NULL DEFAULT NOW(),
	PRIMARY KEY (id)
);

CREATE TABLE `RDL_esp32_config` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`unit_name` varchar(50) DEFAULT NULL,
	`log_table` varchar(50) NOT NULL,
	`servo` tinyint(4) NOT NULL DEFAULT 0,
	`toggle` tinyint(4) NOT NULL DEFAULT 0,
	`delay_timer` int(11) NOT NULL DEFAULT 500,
	`act_timer` int(11) NOT NULL DEFAULT 1000,
	`output_pin` int(11) NOT NULL DEFAULT 0,
	`led_pin` int(11) NOT NULL DEFAULT 1,
	`servo_extended` int(12) NOT NULL DEFAULT 5,
	`servo_retracted` int(12) NOT NULL DEFAULT 25,
	PRIMARY KEY (id)
);