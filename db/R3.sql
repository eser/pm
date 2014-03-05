ALTER TABLE `siteroles`   
  CHANGE `name` `name` VARCHAR(25) CHARSET utf8 COLLATE utf8_general_ci NOT NULL,
  CHANGE `createproject` `createproject` TINYINT(1) UNSIGNED NOT NULL,
  CHANGE `createuser` `createuser` TINYINT(1) UNSIGNED NOT NULL,
  CHANGE `deleteuser` `deleteuser` TINYINT(1) UNSIGNED NOT NULL,
  CHANGE `administer` `administer` TINYINT(1) UNSIGNED NOT NULL;

ALTER TABLE `siteroles`   
  ADD COLUMN `active` TINYINT(1) UNSIGNED NOT NULL AFTER `administer`;

ALTER TABLE `users`   
  ADD COLUMN `active` TINYINT(1) UNSIGNED NOT NULL AFTER `page`;
