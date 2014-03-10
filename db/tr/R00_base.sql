-- MySQL dump 10.13  Distrib 5.6.13, for Win32 (x86)
--
-- Host: localhost    Database: pm
-- ------------------------------------------------------
-- Server version	5.6.16


--
-- Table structure for table `constants`
--

DROP TABLE IF EXISTS `constants`;
CREATE TABLE `constants` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `type` enum('task_type','project_type','open_task_type','closed_task_type','priority_type','project_relation_type') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `constants`
--

LOCK TABLES `constants` WRITE;
INSERT INTO `constants` VALUES
(1,'Geliştirme','task_type'),
(2,'Düzeltme','task_type'),
(3,'Özellik','task_type'),
(4,'Proje','project_type'),
(5,'Servis','project_type'),
(6,'Fırsat','project_type'),
(7,'Yeni','open_task_type'),
(8,'Devam Etmekte','open_task_type'),
(9,'Onay Bekliyor','open_task_type'),
(10,'Ertelendi','open_task_type'),
(11,'Tamamlandı','closed_task_type'),
(12,'İptal Edildi','closed_task_type'),
(13,'Düşük','priority_type'),
(14,'Orta','priority_type'),
(15,'Yüksek','priority_type'),
(16,'Acil','priority_type'),
(17,'Proje Yöneticisi','project_relation_type'),
(18,'Proje Üyesi','project_relation_type');
UNLOCK TABLES;

--
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
CREATE TABLE `files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `targetid` int(10) unsigned NOT NULL,
  `user` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `type` enum('task') NOT NULL,
  `filename` varchar(255) NOT NULL,
  `mimetype` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `deleted` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
INSERT INTO `groups` VALUES
(1,'Firma'),
(2,'Yazılım Geliştirme');
UNLOCK TABLES;

--
-- Table structure for table `logs`
--

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

--
-- Table structure for table `notes`
--

DROP TABLE IF EXISTS `notes`;
CREATE TABLE `notes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `targetid` int(10) unsigned NOT NULL,
  `user` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `type` enum('task') NOT NULL,
  `description` text NOT NULL,
  `deleted` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `title` varchar(255) NOT NULL,
  `html` text NOT NULL,
  `project` int(10) unsigned NOT NULL,
  `type` enum('passive','unlisted','menu') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
INSERT INTO `pages` VALUES
(1,'test','Deneme Sayfası','bold italic underline<div>test</div>',1,'menu');
UNLOCK TABLES;

--
-- Table structure for table `project_constants`
--

DROP TABLE IF EXISTS `project_constants`;
CREATE TABLE `project_constants` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project` int(10) unsigned NOT NULL,
  `name` varchar(30) NOT NULL,
  `type` enum('section_type','milestone_type') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `project_constants`
--

LOCK TABLES `project_constants` WRITE;
INSERT INTO `project_constants` VALUES
(1,1,'Geliştirme','section_type'),
(2,1,'Bakım','section_type'),
(3,1,'Kurulum Aşaması','milestone_type');
UNLOCK TABLES;

--
-- Table structure for table `project_users`
--

DROP TABLE IF EXISTS `project_users`;
CREATE TABLE `project_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project` int(10) unsigned NOT NULL,
  `user` int(10) unsigned NOT NULL,
  `relation` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `project_users`
--

LOCK TABLES `project_users` WRITE;
INSERT INTO `project_users` VALUES
(1,1,1,17),
(2,1,2,18);
UNLOCK TABLES;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
CREATE TABLE `projects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `title` varchar(80) NOT NULL,
  `subtitle` varchar(80) NOT NULL,
  `shortdescription` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `parent` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `type` int(10) unsigned NOT NULL,
  `sourceforge` tinyint(1) unsigned NOT NULL,
  `public` tinyint(1) unsigned NOT NULL,
  `license` varchar(150) NOT NULL,
  `owner` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `project_parent` (`parent`),
  KEY `project_type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
INSERT INTO `projects` VALUES
(1,'ornek-proje','Örnek Proje','...','Sisteminin yeni yazılıma geçirilmesi','description',0,'2013-09-27 11:16:52',4,0,0,'',0);
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `createproject` tinyint(1) unsigned NOT NULL,
  `createuser` tinyint(1) unsigned NOT NULL,
  `deleteuser` tinyint(1) unsigned NOT NULL,
  `administer` tinyint(1) unsigned NOT NULL,
  `login` tinyint(1) unsigned NOT NULL,
  `active` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
INSERT INTO `roles` VALUES
(1,'Yönetici',1,1,1,1,1,1),
(2,'Yetkili',1,1,0,0,1,1),
(3,'Kullanıcı',0,0,0,0,1,1),
(4,'Giriş Yapamaz',0,0,0,0,0,1);
UNLOCK TABLES;

--
-- Table structure for table `task_relatives`
--

DROP TABLE IF EXISTS `task_relatives`;
CREATE TABLE `task_relatives` (
  `task` int(10) unsigned NOT NULL,
  `type` enum('user','group') NOT NULL,
  `targetid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`task`,`type`,`targetid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `task_relatives`
--

LOCK TABLES `task_relatives` WRITE;
INSERT INTO `task_relatives` VALUES
(1,'group',2),
(2,'group',2);
UNLOCK TABLES;

--
-- Table structure for table `task_revisions`
--

DROP TABLE IF EXISTS `task_revisions`;
CREATE TABLE `task_revisions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `task` int(10) unsigned NOT NULL,
  `revision` int(10) unsigned NOT NULL,
  `relation` enum('related','fixes','causes') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_task_revision_task_idx` (`task`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `task_revisions`
--

LOCK TABLES `task_revisions` WRITE;
INSERT INTO `task_revisions` VALUES
(1,1,0,'related'),
(2,2,0,'related');
UNLOCK TABLES;

--
-- Table structure for table `tasks`
--

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
  `enddate` datetime DEFAULT NULL,
  `duedate` datetime DEFAULT NULL,
  `assignee` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `owner` int(10) unsigned NOT NULL,
  `milestone` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `issue_project` (`project`),
  KEY `statetype` (`status`),
  KEY `constant` (`type`),
  KEY `assignee` (`assignee`),
  KEY `section` (`section`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tasks`
--

LOCK TABLES `tasks` WRITE;
INSERT INTO `tasks` VALUES
(1,1,1,2,'Eski Bilgilerin Taşınması','Eski bilgilerin yeni sisteme aktarılması.',7,14,0,'2014-03-10 00:00:00',5,NULL,'2014-03-15 00:00:00',1,'2014-03-10 04:36:37',1,3),
(2,1,1,1,'Bilgi Giriş Formları','Formlardaki değerler gönderim esnasında kontrol edilecek, kullanıcıya veritabanı hatası yerine önceden uyarıda bulunulacak.<div>(Javascript ile desteklenebilir)</div>',7,14,0,'2014-03-10 00:00:00',15,NULL,'2014-03-22 00:00:00',1,'2014-03-10 04:38:33',1,3);
UNLOCK TABLES;

--
-- Table structure for table `user_groups`
--

DROP TABLE IF EXISTS `user_groups`;
CREATE TABLE `user_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL,
  `groupid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `userid_groupid` (`userid`,`groupid`),
  KEY `userid` (`userid`),
  KEY `groupid` (`groupid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_groups`
--

LOCK TABLES `user_groups` WRITE;
INSERT INTO `user_groups` VALUES
(1,1,1),
(2,1,2),
(3,2,1),
(4,2,2);
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `scmid` text NOT NULL,
  `name` varchar(25) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(40) NOT NULL,
  `phone` text NOT NULL,
  `role` int(10) unsigned NOT NULL,
  `bio` text NOT NULL,
  `page` text NOT NULL,
  `active` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  KEY `users_role` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
INSERT INTO `users` VALUES
(1,'github.com/larukedi','Eser Özvataf','laroux','123456','eser@sent.com','',1,'','http://eser.ozvataf.com/',1),
(2,'','Örnek Kullanıcı','user','123456','noone@nohost.com','',2,'','',1);
UNLOCK TABLES;
