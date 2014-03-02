ALTER TABLE `users` CHANGE COLUMN `siterole` `role` INT(10) UNSIGNED NOT NULL;

CREATE TABLE `project_users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `project` INT UNSIGNED NOT NULL,
  `user` INT UNSIGNED NOT NULL,
  `relation` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8;

ALTER TABLE `tasks` ADD COLUMN `milestone` INT UNSIGNED NOT NULL AFTER `owner`;
ALTER TABLE `tasks` ADD COLUMN `duedate` DATETIME NULL AFTER `startdate`;
ALTER TABLE `tasks` CHANGE COLUMN `enddate` `enddate` DATETIME NULL;

ALTER TABLE `constants` CHANGE COLUMN `type` `type` ENUM('task_type','project_type','open_task_type','closed_task_type','priority_type','project_relation_type') NOT NULL;