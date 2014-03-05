ALTER TABLE `task_files`
CHANGE COLUMN `task` `targetid` INT(10) UNSIGNED NOT NULL,
ADD COLUMN `user` INT UNSIGNED NOT NULL AFTER `targetid`,
ADD COLUMN `created` DATETIME NOT NULL AFTER `user`,
ADD COLUMN `type` ENUM('task') NOT NULL AFTER `created`,
ADD COLUMN `path` VARCHAR(255) NOT NULL AFTER `mimetype`,
ADD COLUMN `description` TEXT NOT NULL AFTER `path`,
RENAME TO `files`;

ALTER TABLE `task_notes`
CHANGE COLUMN `task` `targetid` INT(10) UNSIGNED NOT NULL,
CHANGE COLUMN `text` `description` TEXT NOT NULL,
ADD COLUMN `type` ENUM('task') NOT NULL AFTER `created`,
RENAME TO `notes`;
