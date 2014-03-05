/*
SQLyog Ultimate v10.00 Beta1
MySQL - 5.5.15 : Database - darkgaze
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`darkgaze` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `darkgaze`;

/*Table structure for table `constants` */

DROP TABLE IF EXISTS `constants`;

CREATE TABLE `constants` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `type` enum('task_type','project_type','open_task_type','closed_task_type','priority_type') NOT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8;

/*Table structure for table `files` */

DROP TABLE IF EXISTS `files`;

CREATE TABLE `files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(80) DEFAULT NULL,
  `version` varchar(50) DEFAULT NULL,
  `type` int(10) unsigned DEFAULT NULL,
  `project` int(10) unsigned DEFAULT NULL,
  `milestone` int(10) unsigned DEFAULT NULL,
  `issue` int(10) unsigned DEFAULT NULL,
  `size` int(10) unsigned DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `constant` (`type`),
  KEY `milestone` (`milestone`),
  KEY `issue` (`issue`)
) DEFAULT CHARSET=utf8;

/*Table structure for table `groups` */

DROP TABLE IF EXISTS `groups`;

CREATE TABLE `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8;

/*Table structure for table `issue_rev` */

DROP TABLE IF EXISTS `issue_rev`;

CREATE TABLE `issue_rev` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `issue` int(10) unsigned NOT NULL,
  `rev` int(10) unsigned DEFAULT NULL,
  `relation` enum('related','fixes','causes') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `issue` (`id`),
  KEY `fk_issue_rev_issue_idx` (`issue`)
) DEFAULT CHARSET=utf8;

/*Table structure for table `logs` */

DROP TABLE IF EXISTS `logs`;

CREATE TABLE `logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `targetid` int(10) unsigned NOT NULL,
  `user` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `type` enum('task') NOT NULL,
  `serializeddata` text NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `milestone_issue` */

DROP TABLE IF EXISTS `milestone_issue`;

CREATE TABLE `milestone_issue` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `milestone` int(10) unsigned NOT NULL,
  `issue` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `milestone` (`milestone`),
  KEY `issue` (`issue`)
) DEFAULT CHARSET=utf8;

/*Table structure for table `milestones` */

DROP TABLE IF EXISTS `milestones`;

CREATE TABLE `milestones` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project` int(10) unsigned NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` text,
  `state` int(10) unsigned NOT NULL,
  `completion` float DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project` (`project`),
  KEY `statetype` (`state`)
) DEFAULT CHARSET=utf8;

/*Table structure for table `news` */

DROP TABLE IF EXISTS `news`;

CREATE TABLE `news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project` int(10) unsigned DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `title` varchar(80) DEFAULT NULL,
  `text` text,
  `category` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project` (`project`),
  KEY `category` (`category`)
) DEFAULT CHARSET=utf8;

/*Table structure for table `notes` */

DROP TABLE IF EXISTS `notes`;

CREATE TABLE `notes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `issue` int(10) unsigned DEFAULT NULL,
  `title` varchar(80) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `text` text,
  `user` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `issue` (`issue`),
  KEY `user` (`user`)
) DEFAULT CHARSET=utf8;

/*Table structure for table `pages` */

DROP TABLE IF EXISTS `pages`;

CREATE TABLE `pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(80) DEFAULT NULL,
  `content` text,
  `project` int(10) unsigned DEFAULT NULL,
  `type` enum('wikihome','none','link') DEFAULT NULL,
  `menulocation` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project` (`project`)
) DEFAULT CHARSET=utf8;

/*Table structure for table `project_constants` */

DROP TABLE IF EXISTS `project_constants`;

CREATE TABLE `project_constants` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project` int(10) unsigned NOT NULL,
  `name` varchar(30) NOT NULL,
  `type` enum('section_type','milestone_type') NOT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8;

/*Table structure for table `project_user` */

DROP TABLE IF EXISTS `project_user`;

CREATE TABLE `project_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project` int(10) unsigned NOT NULL,
  `user` int(10) unsigned NOT NULL,
  `role` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `project_user_project` (`project`),
  KEY `project_user_user` (`user`),
  KEY `project_user_role` (`role`)
) DEFAULT CHARSET=utf8;

/*Table structure for table `projectroles` */

DROP TABLE IF EXISTS `projectroles`;

CREATE TABLE `projectroles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `svnreadonly` tinyint(1) DEFAULT NULL,
  `svnmodify` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8;

/*Table structure for table `projects` */

DROP TABLE IF EXISTS `projects`;

CREATE TABLE `projects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `title` varchar(80) DEFAULT NULL,
  `subtitle` varchar(80) DEFAULT NULL,
  `shortdescription` varchar(250) DEFAULT NULL,
  `description` text,
  `parent` int(10) unsigned DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `type` int(10) unsigned NOT NULL,
  `sourceforge` tinyint(1) DEFAULT NULL,
  `public` tinyint(1) DEFAULT NULL,
  `license` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project_parent` (`parent`),
  KEY `project_type` (`type`)
) DEFAULT CHARSET=utf8;

/*Table structure for table `sections` */

DROP TABLE IF EXISTS `sections`;

CREATE TABLE `sections` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project` int(10) unsigned DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `section_project` (`project`)
) DEFAULT CHARSET=utf8;

/*Table structure for table `siteroles` */

DROP TABLE IF EXISTS `siteroles`;

CREATE TABLE `siteroles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) DEFAULT NULL,
  `createproject` tinyint(1) unsigned DEFAULT NULL,
  `createuser` tinyint(1) unsigned DEFAULT NULL,
  `deleteuser` tinyint(1) unsigned DEFAULT NULL,
  `administer` tinyint(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8;

/*Table structure for table `statetypes` */

DROP TABLE IF EXISTS `statetypes`;

CREATE TABLE `statetypes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` int(10) unsigned DEFAULT NULL,
  `type` int(10) unsigned DEFAULT NULL,
  `status` enum('open','close') DEFAULT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8;

/*Table structure for table `tasks` */

DROP TABLE IF EXISTS `tasks`;

CREATE TABLE `tasks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project` int(10) unsigned NOT NULL,
  `type` int(10) unsigned NOT NULL,
  `section` int(10) unsigned NOT NULL,
  `subject` varchar(80) NOT NULL,
  `description` text NOT NULL,
  `status` int(10) unsigned NOT NULL,
  `priority` int(10) unsigned NOT NULL,
  `progress` int(10) unsigned NOT NULL,
  `startdate` datetime NOT NULL,
  `estimatedtime` int(10) unsigned NOT NULL,
  `enddate` datetime NOT NULL,
  `assignee` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `issue_project` (`project`),
  KEY `statetype` (`status`),
  KEY `constant` (`type`),
  KEY `assignee` (`assignee`),
  KEY `section` (`section`)
) DEFAULT CHARSET=utf8;

/*Table structure for table `timespent` */

DROP TABLE IF EXISTS `timespent`;

CREATE TABLE `timespent` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `issue` int(10) unsigned DEFAULT NULL,
  `duration` float DEFAULT NULL,
  `user` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `issue` (`issue`),
  KEY `user` (`user`)
) DEFAULT CHARSET=utf8;

/*Table structure for table `user_group` */

DROP TABLE IF EXISTS `user_group`;

CREATE TABLE `user_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL,
  `groupid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `userid_groupid` (`userid`,`groupid`),
  KEY `userid` (`userid`),
  KEY `groupid` (`groupid`)
) DEFAULT CHARSET=utf8;

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `scmid` text NOT NULL,
  `name` varchar(25) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(40) NOT NULL,
  `phone` text NOT NULL,
  `siterole` int(10) unsigned NOT NULL,
  `bio` text NOT NULL,
  `page` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  KEY `users_role` (`siterole`)
) DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
