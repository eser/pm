CREATE TABLE `attachments`(  
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `targetid` INT UNSIGNED NOT NULL,
  `user` INT UNSIGNED NOT NULL,
  `created` DATETIME NOT NULL,
  `path` VARCHAR(255) NOT NULL,
  `description` TEXT NOT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO `constants` (`name`, `type`) VALUES ('Member', 'project_relation_type');
