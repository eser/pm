ALTER TABLE `pages`
ADD COLUMN `type` ENUM('passive', 'unlisted', 'menu') NOT NULL AFTER `project`;

CREATE TABLE `task_relatives` (
  `task` INT UNSIGNED NOT NULL,
  `type` ENUM('user', 'group') NOT NULL,
  `targetid` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`task`, `type`, `targetid`)
);

DROP TABLE `attachments`;
