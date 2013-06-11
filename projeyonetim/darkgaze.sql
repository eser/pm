-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- Anamakine: localhost
-- Üretim Zamanı: 11 Haziran 2013 saat 18:28:04
-- Sunucu sürümü: 5.0.51
-- PHP Sürümü: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Veritabanı: `darkgaze`
-- 

-- --------------------------------------------------------

-- 
-- Tablo yapısı: `constants`
-- 

CREATE TABLE `constants` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(30) default NULL,
  `type` enum('issue_type','project_type') NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Tablo döküm verisi `constants`
-- 


-- --------------------------------------------------------

-- 
-- Tablo yapısı: `files`
-- 

CREATE TABLE `files` (
  `id` int(11) NOT NULL auto_increment,
  `filename` varchar(80) default NULL,
  `version` varchar(50) default NULL,
  `type` int(11) default NULL,
  `project` int(11) default NULL,
  `milestone` int(11) default NULL,
  `issue` int(11) default NULL,
  `size` int(11) default NULL,
  `description` text,
  PRIMARY KEY  (`id`),
  KEY `constant` (`type`),
  KEY `milestone` (`milestone`),
  KEY `issue` (`issue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Tablo döküm verisi `files`
-- 


-- --------------------------------------------------------

-- 
-- Tablo yapısı: `group`
-- 

CREATE TABLE `group` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(45) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Tablo döküm verisi `group`
-- 


-- --------------------------------------------------------

-- 
-- Tablo yapısı: `issues`
-- 

CREATE TABLE `issues` (
  `id` int(11) NOT NULL auto_increment,
  `project` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `subject` varchar(80) default NULL,
  `text` text,
  `status` int(11) NOT NULL,
  `priority` int(11) default NULL,
  `progress` int(11) default NULL,
  `start` datetime default NULL,
  `estimatedtime` int(11) default NULL,
  `end` datetime default NULL,
  `assignee` int(11) default NULL,
  `issues` int(11) default NULL,
  `section` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `issue_project` (`project`),
  KEY `statetype` (`status`),
  KEY `constant` (`type`),
  KEY `assignee` (`assignee`),
  KEY `issues` (`issues`),
  KEY `section` (`section`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Tablo döküm verisi `issues`
-- 


-- --------------------------------------------------------

-- 
-- Tablo yapısı: `issue_rev`
-- 

CREATE TABLE `issue_rev` (
  `id` int(11) NOT NULL auto_increment,
  `issue` int(11) NOT NULL,
  `rev` int(11) default NULL,
  `relation` enum('related','fixes','causes') default NULL,
  PRIMARY KEY  (`id`),
  KEY `issue` (`id`),
  KEY `fk_issue_rev_issue_idx` (`issue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Tablo döküm verisi `issue_rev`
-- 


-- --------------------------------------------------------

-- 
-- Tablo yapısı: `milestones`
-- 

CREATE TABLE `milestones` (
  `id` int(11) NOT NULL auto_increment,
  `project` int(11) NOT NULL,
  `name` varchar(50) default NULL,
  `description` text,
  `state` int(11) NOT NULL,
  `completion` float default NULL,
  `date` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `project` (`project`),
  KEY `statetype` (`state`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Tablo döküm verisi `milestones`
-- 


-- --------------------------------------------------------

-- 
-- Tablo yapısı: `milestone_issue`
-- 

CREATE TABLE `milestone_issue` (
  `id` int(11) NOT NULL auto_increment,
  `milestone` int(11) NOT NULL,
  `issue` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `milestone` (`milestone`),
  KEY `issue` (`issue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Tablo döküm verisi `milestone_issue`
-- 


-- --------------------------------------------------------

-- 
-- Tablo yapısı: `news`
-- 

CREATE TABLE `news` (
  `id` int(11) NOT NULL auto_increment,
  `project` int(11) default NULL,
  `date` datetime default NULL,
  `title` varchar(80) default NULL,
  `text` text,
  `category` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `project` (`project`),
  KEY `category` (`category`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Tablo döküm verisi `news`
-- 


-- --------------------------------------------------------

-- 
-- Tablo yapısı: `notes`
-- 

CREATE TABLE `notes` (
  `id` int(11) NOT NULL auto_increment,
  `issue` int(11) default NULL,
  `title` varchar(80) default NULL,
  `date` datetime default NULL,
  `text` text,
  `user` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `issue` (`issue`),
  KEY `user` (`user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Tablo döküm verisi `notes`
-- 


-- --------------------------------------------------------

-- 
-- Tablo yapısı: `pages`
-- 

CREATE TABLE `pages` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(80) default NULL,
  `content` text,
  `project` int(11) default NULL,
  `type` enum('wikihome','none','link') default NULL,
  `menulocation` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `project` (`project`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Tablo döküm verisi `pages`
-- 


-- --------------------------------------------------------

-- 
-- Tablo yapısı: `projectroles`
-- 

CREATE TABLE `projectroles` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(20) default NULL,
  `svnreadonly` tinyint(1) default NULL,
  `svnmodify` tinyint(1) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Tablo döküm verisi `projectroles`
-- 


-- --------------------------------------------------------

-- 
-- Tablo yapısı: `projects`
-- 

CREATE TABLE `projects` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(30) default NULL,
  `title` varchar(80) default NULL,
  `subtitle` varchar(80) default NULL,
  `shortdescription` varchar(250) default NULL,
  `description` text,
  `parent` int(11) default NULL,
  `created` datetime default NULL,
  `type` int(11) NOT NULL,
  `sourceforge` tinyint(1) default NULL,
  `public` tinyint(1) default NULL,
  `license` varchar(150) default NULL,
  PRIMARY KEY  (`id`),
  KEY `project_parent` (`parent`),
  KEY `project_type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Tablo döküm verisi `projects`
-- 


-- --------------------------------------------------------

-- 
-- Tablo yapısı: `project_user`
-- 

CREATE TABLE `project_user` (
  `id` int(11) NOT NULL auto_increment,
  `project` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `role` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `project_user_project` (`project`),
  KEY `project_user_user` (`user`),
  KEY `project_user_role` (`role`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Tablo döküm verisi `project_user`
-- 


-- --------------------------------------------------------

-- 
-- Tablo yapısı: `sections`
-- 

CREATE TABLE `sections` (
  `id` int(11) NOT NULL auto_increment,
  `project` int(11) default NULL,
  `name` varchar(30) default NULL,
  `description` text,
  PRIMARY KEY  (`id`),
  KEY `section_project` (`project`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Tablo döküm verisi `sections`
-- 


-- --------------------------------------------------------

-- 
-- Tablo yapısı: `siteroles`
-- 

CREATE TABLE `siteroles` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(25) default NULL,
  `createproject` tinyint(1) default NULL,
  `createuser` tinyint(1) default NULL,
  `deleteuser` tinyint(1) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Tablo döküm verisi `siteroles`
-- 


-- --------------------------------------------------------

-- 
-- Tablo yapısı: `statetypes`
-- 

CREATE TABLE `statetypes` (
  `id` int(11) NOT NULL auto_increment,
  `name` int(11) default NULL,
  `type` int(11) default NULL,
  `status` enum('open','close') default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Tablo döküm verisi `statetypes`
-- 


-- --------------------------------------------------------

-- 
-- Tablo yapısı: `timespent`
-- 

CREATE TABLE `timespent` (
  `id` int(11) NOT NULL auto_increment,
  `issue` int(11) default NULL,
  `duration` float default NULL,
  `user` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `issue` (`issue`),
  KEY `user` (`user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Tablo döküm verisi `timespent`
-- 


-- --------------------------------------------------------

-- 
-- Tablo yapısı: `users`
-- 

CREATE TABLE `users` (
  `id` int(11) NOT NULL auto_increment,
  `sfid` text,
  `name` varchar(25) default NULL,
  `username` varchar(25) default NULL,
  `password` varchar(32) default NULL,
  `email` varchar(40) default NULL,
  `phone` text,
  `role` int(11) NOT NULL,
  `bio` text,
  `page` text,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  KEY `users_role` (`role`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Tablo döküm verisi `users`
-- 


-- --------------------------------------------------------

-- 
-- Tablo yapısı: `user_group`
-- 

CREATE TABLE `user_group` (
  `id` int(11) NOT NULL auto_increment,
  `user` int(11) NOT NULL,
  `group` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user` (`user`),
  KEY `group` (`group`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Tablo döküm verisi `user_group`
-- 

