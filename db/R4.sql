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
