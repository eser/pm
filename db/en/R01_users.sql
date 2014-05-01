ALTER TABLE `users`
ADD COLUMN `language` VARCHAR(50) NOT NULL AFTER `active`,
ADD COLUMN `sendmails` TINYINT(1) UNSIGNED NOT NULL AFTER `language`;

ALTER TABLE `task_revisions`
CHANGE COLUMN `revision` `revision` VARCHAR(255) NOT NULL;
