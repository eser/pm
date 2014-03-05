CREATE TABLE `attachments`(  
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `targetid` INT UNSIGNED NOT NULL,
  `user` INT UNSIGNED NOT NULL,
  `created` DATETIME NOT NULL,
  `path` VARCHAR(255) NOT NULL,
  `description` TEXT NOT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8;

INSERT INTO `constants` (`name`, `type`) VALUES ('Member', 'project_relation_type');

ALTER TABLE `projects`   
  CHANGE `name` `name` VARCHAR(30) CHARSET utf8 COLLATE utf8_general_ci NOT NULL,
  CHANGE `title` `title` VARCHAR(80) CHARSET utf8 COLLATE utf8_general_ci NOT NULL,
  CHANGE `subtitle` `subtitle` VARCHAR(80) CHARSET utf8 COLLATE utf8_general_ci NOT NULL,
  CHANGE `shortdescription` `shortdescription` VARCHAR(250) CHARSET utf8 COLLATE utf8_general_ci NOT NULL,
  CHANGE `description` `description` TEXT CHARSET utf8 COLLATE utf8_general_ci NOT NULL,
  CHANGE `parent` `parent` INT(10) UNSIGNED NOT NULL,
  CHANGE `created` `created` DATETIME NOT NULL,
  CHANGE `sourceforge` `sourceforge` TINYINT(1) UNSIGNED NOT NULL,
  CHANGE `public` `public` TINYINT(1) UNSIGNED NOT NULL,
  CHANGE `license` `license` VARCHAR(150) CHARSET utf8 COLLATE utf8_general_ci NOT NULL,
  ADD COLUMN `owner` INT UNSIGNED NOT NULL AFTER `license`;

ALTER TABLE `tasks`   
  ADD COLUMN `owner` INT UNSIGNED NOT NULL AFTER `created`;
