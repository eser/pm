ALTER TABLE `pages`
ADD COLUMN `type` ENUM('passive', 'unlisted', 'menu') NOT NULL AFTER `project`;
