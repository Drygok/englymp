CREATE TABLE `ENG_results` (
	`ID` INT(11) NOT NULL AUTO_INCREMENT,
	`Question` TINYTEXT NOT NULL COLLATE 'utf8mb4_general_ci',
	`Answer` TINYTEXT NOT NULL COLLATE 'utf8mb4_general_ci',
	`Token` TINYTEXT NOT NULL COLLATE 'utf8mb4_general_ci',
	PRIMARY KEY (`ID`) USING BTREE
)
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
;

CREATE TABLE `ENG_tokens` (
	`ID` INT(11) NOT NULL AUTO_INCREMENT,
	`Name` TINYTEXT NOT NULL COLLATE 'utf8mb4_general_ci',
	`Surname` TINYTEXT NOT NULL COLLATE 'utf8mb4_general_ci',
	`Group` TINYTEXT NOT NULL COLLATE 'utf8mb4_general_ci',
	`Teacher` TINYTEXT NOT NULL COLLATE 'utf8mb4_general_ci',
	`Token` CHAR(64) NOT NULL DEFAULT '' COLLATE 'utf8mb4_general_ci',
	`Phone` TINYTEXT NOT NULL COLLATE 'utf8mb4_general_ci',
	PRIMARY KEY (`ID`) USING BTREE
)
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
;

