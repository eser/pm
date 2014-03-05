DROP TABLE `files`;

DROP TABLE `milestone_issue`;

DROP TABLE `milestones`;

DROP TABLE `news`;

DROP TABLE `notes`;

DROP TABLE `pages`;

DROP TABLE `project_user`;

DROP TABLE `projectroles`;

DROP TABLE `sections`;

DROP TABLE `statetypes`;

DROP TABLE `task_rev`;

DROP TABLE `timespent`;

RENAME TABLE `siteroles` TO `roles`;

RENAME TABLE `user_group` TO `user_groups`;

CREATE TABLE `task_revisions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `task` int(10) unsigned NOT NULL,
  `revision` int(10) unsigned NOT NULL,
  `relation` enum('related','fixes','causes') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_task_revision_task_idx` (`task`)
) DEFAULT CHARSET=utf8;

ALTER TABLE `roles`   
  ADD COLUMN `login` TINYINT(1) UNSIGNED NOT NULL AFTER `administer`;

UPDATE `roles` SET `login`='1', `active`='1';

ALTER TABLE `users`   
  CHANGE `siterole` `role` INT(10) UNSIGNED NOT NULL;

ALTER TABLE `tasks`   
  ADD COLUMN `duedate` DATETIME NULL AFTER `enddate`;

CREATE TABLE `project_users`(
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `project` INT UNSIGNED NOT NULL,
  `user` INT UNSIGNED NOT NULL,
  `relation` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8;

ALTER TABLE `constants`   
  CHANGE `type` `type` ENUM('task_type','project_type','open_task_type','closed_task_type','priority_type','project_relation_type') CHARSET utf8 COLLATE utf8_general_ci NOT NULL;
