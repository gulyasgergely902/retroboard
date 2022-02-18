CREATE TABLE `boards` (
    `board_id` INT(11) NOT NULL AUTO_INCREMENT,
    `board_name` VARCHAR(64) NOT NULL,
    `secure` INT(11) NOT NULL DEFAULT 0,
    `board_password` VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY (board_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `stickies` (
    `sticky_id` INT(11) NOT NULL AUTO_INCREMENT,
    `sticky_type` INT(11) NOT NULL,
    `bid` INT(11) NOT NULL,
    `sticky_content` VARCHAR(512) NOT NULL,
    `group_id` INT(11) NOT NULL DEFAULT -1,
    `linked_sticky` INT(10) UNSIGNED NOT NULL DEFAULT 0,
    `linked_content` VARCHAR(512) NOT NULL DEFAULT '',
    PRIMARY KEY (sticky_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `groups` (
    `group_id` INT(11) NOT NULL AUTO_INCREMENT,
    `group_name` VARCHAR(128) NOT NULL,
    `board_id` INT(11) NOT NULL,
    `sticky_type` INT(11) NOT NULL DEFAULT -1,
    PRIMARY KEY (group_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;