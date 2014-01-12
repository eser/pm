ALTER TABLE `issue_rev` CHANGE `issue` `task` INT( 10 ) UNSIGNED NOT NULL;

RENAME TABLE `issue_rev` TO `task_rev` ;

ALTER TABLE task_rev DROP INDEX issue;

