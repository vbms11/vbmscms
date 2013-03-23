-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 13. Dez 2011 um 16:40
-- Server Version: 5.5.16
-- PHP-Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `vbmscms`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_articlepage`
--

CREATE TABLE IF NOT EXISTS `t_articlepage` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lang` varchar(5) NOT NULL,
  `articleid` int(10) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` blob NOT NULL,
  `pageid` int(4) NOT NULL,
  `orderkey` int(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_backup`
--

CREATE TABLE IF NOT EXISTS `t_backup` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Daten für Tabelle `t_backup`
--

INSERT INTO `t_backup` (`id`, `name`, `date`) VALUES
(2, 'db-backup-1317176634-72b2a01884a8488ad3fd8e07d4e7fc79.sql', '2011-09-28'),
(3, 'db-backup-1317177521-72b2a01884a8488ad3fd8e07d4e7fc79.sql', '2011-09-28'),
(4, 'db-backup-1319075559-b79d86e21357dfa5e69e674bacbfdbec.sql', '2011-10-20');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_chat_message`
--

CREATE TABLE IF NOT EXISTS `t_chat_message` (
  `room` int(10) NOT NULL,
  `version` int(10) NOT NULL,
  `message` blob NOT NULL,
  `user` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_chat_room`
--

CREATE TABLE IF NOT EXISTS `t_chat_room` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_chat_room_session`
--

CREATE TABLE IF NOT EXISTS `t_chat_room_session` (
  `room` int(10) NOT NULL,
  `sessionid` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_cms_version`
--

CREATE TABLE IF NOT EXISTS `t_cms_version` (
  `version` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `t_cms_version`
--

INSERT INTO `t_cms_version` (`version`) VALUES
(0.4),
(0.41);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_code`
--

CREATE TABLE IF NOT EXISTS `t_code` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lang` varchar(4) NOT NULL,
  `code` int(10) unsigned NOT NULL,
  `value` blob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Daten für Tabelle `t_code`
--

INSERT INTO `t_code` (`id`, `lang`, `code`, `value`) VALUES
(1, 'de', 1, 0x73746172747570),
(2, 'de', 2, 0x7061676573),
(3, 'de', 3, 0x6c6f67696e),
(4, 'de', 4, 0x73746172747570),
(5, 'de', 5, 0x737461746963),
(6, 'de', 6, 0x537461727470616765);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_comment`
--

CREATE TABLE IF NOT EXISTS `t_comment` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `moduleid` int(10) NOT NULL,
  `name` varchar(200) NOT NULL,
  `comment` blob NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_confirm`
--

CREATE TABLE IF NOT EXISTS `t_confirm` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `hash` varchar(40) NOT NULL,
  `link` blob NOT NULL,
  `args` blob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_domain`
--

CREATE TABLE IF NOT EXISTS `t_domain` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `url` varchar(200) NOT NULL,
  `siteid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Daten für Tabelle `t_domain`
--

INSERT INTO `t_domain` (`id`, `url`, `siteid`) VALUES
(1, 'asn-ev.de', 1),
(2, 'relaunch.asn-ev.de', 1),
(3, 'sutango.com', 2),
(4, 'www.sutango.com', 2),
(5, 'www.sutranslation.com', 3),
(6, 'sutranslation.com', 3),
(7, 'castlesun.com', 4),
(8, 'www.castlesun.com', 4),
(9, 'nysm.de', 5),
(10, 'localhost', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_event`
--

CREATE TABLE IF NOT EXISTS `t_event` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` blob NOT NULL,
  `type` int(5) NOT NULL,
  `userid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_forum_post`
--

CREATE TABLE IF NOT EXISTS `t_forum_post` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(10) NOT NULL,
  `threadid` int(10) NOT NULL,
  `message` blob NOT NULL,
  `createdate` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Daten für Tabelle `t_forum_post`
--

INSERT INTO `t_forum_post` (`id`, `userid`, `threadid`, `message`, `createdate`) VALUES
(5, 1, 7, 0x436f636b7461696c73206665686c656e207363686f6e20696d6d657221204765736368fc7474656c7420756e64206e6963687420676572fc68727421, '2011-09-02'),
(6, 1, 7, 0x636f6f6c0d0a, '2011-09-03');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_forum_thread`
--

CREATE TABLE IF NOT EXISTS `t_forum_thread` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `message` blob NOT NULL,
  `parent` int(10) NOT NULL,
  `createdate` date NOT NULL,
  `views` int(5) NOT NULL,
  `replies` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_forum_topic`
--

CREATE TABLE IF NOT EXISTS `t_forum_topic` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `parent` int(10) NOT NULL,
  `createdate` date NOT NULL,
  `userid` int(11) NOT NULL,
  `views` int(10) NOT NULL,
  `replies` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_gallery_category`
--

CREATE TABLE IF NOT EXISTS `t_gallery_category` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `description` blob NOT NULL,
  `image` int(10) DEFAULT NULL,
  `parent` int(10) DEFAULT NULL,
  `orderkey` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_gallery_image`
--

CREATE TABLE IF NOT EXISTS `t_gallery_image` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `image` varchar(50) NOT NULL,
  `orderkey` int(10) NOT NULL,
  `categoryid` int(10) NOT NULL,
  `description` blob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_gallery_page`
--

CREATE TABLE IF NOT EXISTS `t_gallery_page` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `pageid` int(10) NOT NULL,
  `rootcategory` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Daten für Tabelle `t_gallery_page`
--

INSERT INTO `t_gallery_page` (`id`, `pageid`, `rootcategory`) VALUES
(4, 758, 18),
(5, 774, 25),
(6, 780, 26),
(7, 813, 36);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_kontaktpage`
--

CREATE TABLE IF NOT EXISTS `t_kontaktpage` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `pageid` int(10) NOT NULL,
  `email` varchar(200) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `emailtext` blob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_menu`
--

CREATE TABLE IF NOT EXISTS `t_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `page` int(10) unsigned NOT NULL,
  `type` int(5) unsigned NOT NULL,
  `parent` int(10) DEFAULT NULL,
  `active` int(1) NOT NULL,
  `lang` varchar(5) NOT NULL DEFAULT 'en',
  `position` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `t_menu`
--

INSERT INTO `t_menu` (`id`, `page`, `type`, `parent`, `active`, `lang`, `position`) VALUES
(1, 6, 99, NULL, 1, 'de', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_message`
--

CREATE TABLE IF NOT EXISTS `t_message` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `srcuser` int(10) NOT NULL,
  `dstuser` int(10) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `message` blob NOT NULL,
  `senddate` date NOT NULL,
  `opened` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `t_message`
--

INSERT INTO `t_message` (`id`, `srcuser`, `dstuser`, `subject`, `message`, `senddate`, `opened`) VALUES
(2, 1, 1, 'esraseraserse asfa sdfa sef afe', 0x6173646673616c20666a6c6a65206a6661656c736120666a656c206a61666c73656a66206c61736a666c65736a20667366617366206173646673616c20666a6c6a65206a6661656c736120666a656c206a61666c73656a66206c61736a666c65736a20667366617366206173646673616c20666a6c6a65206a6661656c736120666a656c206a61666c73656a66206c61736a666c65736a20667366617366206173646673616c20666a6c6a65206a6661656c736120666a656c206a61666c73656a66206c61736a666c65736a20667366617366206173646673616c20666a6c6a65206a6661656c736120666a656c206a61666c73656a66206c61736a666c65736a20667366617366206173646673616c20666a6c6a65206a6661656c736120666a656c206a61666c73656a66206c61736a666c65736a20667366617366206173646673616c20666a6c6a65206a6661656c736120666a656c206a61666c73656a66206c61736a666c65736a20667366617366206173646673616c20666a6c6a65206a6661656c736120666a656c206a61666c73656a66206c61736a666c65736a20667366617366206173646673616c20666a6c6a65206a6661656c736120666a656c206a61666c73656a66206c61736a666c65736a2066736661736620, '2011-09-20', 0),
(3, 1, 1, 'asdfasfdsadf', 0x6173646661736466617364666173646673, '2011-11-19', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_module`
--

CREATE TABLE IF NOT EXISTS `t_module` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `sysname` varchar(100) NOT NULL,
  `include` varchar(100) NOT NULL,
  `description` blob,
  `interface` varchar(50) DEFAULT NULL,
  `inmenu` int(1) NOT NULL,
  `category` int(10) NOT NULL,
  `position` int(10) NOT NULL,
  `static` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

--
-- Daten für Tabelle `t_module`
--

INSERT INTO `t_module` (`id`, `name`, `sysname`, `include`, `description`, `interface`, `inmenu`, `category`, `position`, `static`) VALUES
(1, 'Seitenmanager', 'pages', 'modules/pages/pagesView.php', 0x616c6c6f777320796f7520746f206564697420746865206d656e75, 'PagesView', 0, 4, 0, 1),
(4, 'Articles', '', 'modules/articles/articlesPageView.php', '', 'ArticlesPageView', 1, 1, 0, 0),
(2, 'Wysiwyg Editor', '', 'modules/wysiwyg/wysiwygPageView.php', '', 'WysiwygPageView', 1, 1, 0, 0),
(14, 'Kontaktformular', '', 'modules/kontakt/kontaktPageView.php', 0x616c6c6f777320746865207573657220746f2073656e642068696d20616e20656d61696c, 'KontaktPageView', 1, 2, 0, 0),
(13, 'Login', 'login', 'modules/login/loginPageView.php', 0x616c6c6f777320796f7520746f20656e74657220616e6420657869742061646d696e206d6f6465, 'LoginPageView', 0, 4, 0, 1),
(15, 'Emailliste', '', 'modules/newsletter/listsPageView.php', '', 'ListsPageView', 1, 3, 0, 0),
(16, 'Newsletters', '', 'modules/newsletter/newsletterPageView.php', '', 'NewsletterPageView', 1, 3, 0, 0),
(17, 'Produkteliste', '', 'modules/products/productsPageView.php', '', 'ProductsPageView', 1, 1, 0, 0),
(18, 'Newsletter bestellen', '', 'modules/newsletter/subscribePageView.php', '', 'SubscribePageView', 1, 3, 0, 0),
(24, 'Benutser Verwaltung', '', 'modules/users/usersPageView.php', '', 'UsersPageView', 1, 4, 0, 0),
(21, 'Sitemap', '', 'modules/sitemap/sitemapPageView.php', '', 'SitemapPageView', 1, 1, 0, 0),
(22, 'Suche', 'search', 'modules/search/searchPageView.php', '', 'SearchPageView', 1, 4, 0, 1),
(25, 'Forum', '', 'modules/forum/forumPageView.php', '', 'ForumPageView', 1, 2, 0, 0),
(26, 'Chat', '', 'modules/chat/chatPageView.php', '', 'ChatPageView', 1, 2, 0, 0),
(27, 'Comments', '', 'modules/comments/commentsView.php', '', 'CommentsView', 1, 2, 0, 0),
(37, 'Database backup', '', 'modules/admin/backupView.php', '', 'BackupView', 1, 4, 0, 0),
(29, 'Register', '', 'modules/users/registerPageView.php', '', 'RegisterPageView', 1, 4, 0, 0),
(30, 'Profile', '', 'modules/users/profilePageView.php', '', 'ProfilePageView', 1, 4, 0, 0),
(32, 'Role Administration', '', 'modules/admin/rolesView.php', '', 'RolesView', 1, 4, 0, 0),
(33, 'Gallery', '', 'modules/gallery/galleryView.php', '', 'GalleryView', 1, 1, 0, 0),
(34, 'Messages', '', 'modules/forum/messagePageView.php', '', 'MessagePageView', 1, 2, 0, 0),
(35, 'Events Callender', '', 'modules/events/callenderView.php', '', 'CallenderView', 1, 1, 0, 0),
(36, 'Events List', '', 'modules/events/eventsList.php', '', 'EventsListView', 1, 1, 0, 0),
(38, 'Templates Manager', '', 'modules/admin/templatesView.php', '', 'TemplatesView', 1, 4, 0, 0),
(39, 'Modules Manager', '', 'modules/admin/modulesView.php', '', 'ModulesView', 1, 4, 0, 0),
(40, 'Domains Manager', '', 'modules/admin/domainsView.php', '', 'DomainsView', 1, 4, 0, 0),
(41, 'Images', 'images', 'modules/admin/systemService.php', '', 'SystemService', 0, 4, 0, 1),
(42, 'Seo Settings', 'seo', 'modules/admin/seoView.php', '', 'SeoView', 0, 4, 0, 0),
(44, 'Startup Welcome', 'startup', 'modules/admin/startupView.php', NULL, 'StartupView', 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_module_category`
--

CREATE TABLE IF NOT EXISTS `t_module_category` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `position` int(10) NOT NULL,
  `name` varchar(200) COLLATE latin1_german2_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=5 ;

--
-- Daten für Tabelle `t_module_category`
--

INSERT INTO `t_module_category` (`id`, `position`, `name`) VALUES
(1, 1, 'Common'),
(2, 2, 'Communication'),
(3, 3, 'Newsletter'),
(4, 4, 'System');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_module_instance`
--

CREATE TABLE IF NOT EXISTS `t_module_instance` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `moduleid` int(10) NOT NULL,
  `templateareaid` int(10) NOT NULL,
  PRIMARY KEY (`id`,`moduleid`,`templateareaid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_module_instance_params`
--

CREATE TABLE IF NOT EXISTS `t_module_instance_params` (
  `instanceid` int(10) NOT NULL,
  `name` varchar(100) COLLATE latin1_german2_ci NOT NULL,
  `value` blob NOT NULL,
  PRIMARY KEY (`instanceid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_module_roles`
--

CREATE TABLE IF NOT EXISTS `t_module_roles` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `customrole` int(10) NOT NULL,
  `modulerole` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=167 ;

--
-- Daten für Tabelle `t_module_roles`
--

INSERT INTO `t_module_roles` (`id`, `customrole`, `modulerole`) VALUES
(93, 8, 'forum.thread.create'),
(94, 8, 'forum.thread.view'),
(95, 8, 'chat.user'),
(96, 8, 'chat.view'),
(97, 8, 'comment.post'),
(98, 8, 'events.callender'),
(99, 8, 'events.list'),
(100, 8, 'users.profile'),
(101, 8, 'message.inbox'),
(109, 0, 'chat.user'),
(110, 0, 'chat.view'),
(111, 0, 'comment.post'),
(112, 0, 'gallery.view'),
(113, 0, 'events.callender'),
(114, 0, 'events.list'),
(115, 0, 'forum.view'),
(121, 7, 'forum.view'),
(122, 7, 'chat.user'),
(123, 7, 'chat.view'),
(124, 7, 'comment.post'),
(125, 7, 'gallery.view'),
(126, 7, 'events.callender'),
(127, 7, 'events.list'),
(128, 10, 'pages.editmenu'),
(129, 10, 'pages.edit'),
(130, 10, 'articles.edit'),
(131, 10, 'wysiwyg.edit'),
(132, 10, 'kontakt.edit'),
(133, 10, 'login.edit'),
(134, 10, 'newsletter.emails.edit'),
(135, 10, 'newsletter.edit'),
(136, 10, 'newsletter.send'),
(137, 10, 'products.edit'),
(138, 10, 'newsletter.subscribe.edit'),
(139, 10, 'users.edit'),
(140, 10, 'sitemap.edit'),
(141, 10, 'info.edit'),
(142, 10, 'forum.topic.create'),
(143, 10, 'forum.thread.create'),
(144, 10, 'forum.view'),
(145, 10, 'forum.admin'),
(146, 10, 'forum.moderator'),
(147, 10, 'forum.thread.post'),
(148, 10, 'chat.user'),
(149, 10, 'chat.view'),
(150, 10, 'comment.post'),
(151, 10, 'comment.edit'),
(152, 10, 'comment.delete'),
(153, 10, 'backup.create'),
(154, 10, 'backup.load'),
(155, 10, 'backup.delete'),
(156, 10, 'users.profile'),
(157, 10, 'admin.roles.edit'),
(158, 10, 'gallery.edit'),
(159, 10, 'gallery.view'),
(160, 10, 'message.inbox'),
(161, 10, 'events.callender'),
(162, 10, 'events.list'),
(163, 10, 'events.edit'),
(164, 10, 'spider.configure'),
(165, 10, 'spider.start'),
(166, 10, 'spider.view');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_newsletter_confirm`
--

CREATE TABLE IF NOT EXISTS `t_newsletter_confirm` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `emailgroup` int(10) NOT NULL,
  `hash` varchar(100) NOT NULL,
  `pageid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_newsletter_email`
--

CREATE TABLE IF NOT EXISTS `t_newsletter_email` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `emailgroup` int(10) unsigned NOT NULL,
  `name` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Daten für Tabelle `t_newsletter_email`
--

INSERT INTO `t_newsletter_email` (`id`, `email`, `emailgroup`, `name`) VALUES
(7, 'test@test.com', 9, 'test');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_newsletter_emailgroup`
--

CREATE TABLE IF NOT EXISTS `t_newsletter_emailgroup` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Daten für Tabelle `t_newsletter_emailgroup`
--

INSERT INTO `t_newsletter_emailgroup` (`id`, `name`) VALUES
(9, 'Vorstand'),
(10, 'Mitglieder'),
(11, 'ForumMitglieder'),
(12, 'Ehemalige');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_newsletter_subscribe`
--

CREATE TABLE IF NOT EXISTS `t_newsletter_subscribe` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `pageid` int(10) NOT NULL,
  `lang` varchar(5) NOT NULL,
  `content` blob,
  `emailtext` blob,
  `emailsent` blob,
  `confirmed` blob,
  `emailgroup` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16358 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_page`
--

CREATE TABLE IF NOT EXISTS `t_page` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` int(5) unsigned NOT NULL,
  `namecode` int(10) unsigned NOT NULL,
  `welcome` int(1) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `keywords` blob,
  `description` blob NOT NULL,
  `template` int(10) NOT NULL,
  `siteid` int(10) DEFAULT '1',
  `code` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Daten für Tabelle `t_page`
--

INSERT INTO `t_page` (`id`, `type`, `namecode`, `welcome`, `title`, `keywords`, `description`, `template`, `siteid`, `code`) VALUES
(4, 0, 4, 0, 'startup', 0x73746172747570, 0x73746172747570, 5, 1, 'startup'),
(2, 0, 2, 0, 'pages', 0x7061676573, 0x7061676573, 5, 1, 'pages'),
(3, 0, 3, 0, 'login', 0x6c6f67696e, 0x6c6f67696e, 5, 1, 'login'),
(5, 0, 5, 0, 'static', 0x737461746963, 0x737461746963, 5, 1, 'static'),
(6, 0, 6, 1, '', '', '', 5, 1, '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_page_roles`
--

CREATE TABLE IF NOT EXISTS `t_page_roles` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `roleid` int(10) NOT NULL,
  `pageid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Daten für Tabelle `t_page_roles`
--

INSERT INTO `t_page_roles` (`id`, `roleid`, `pageid`) VALUES
(1, 7, 6),
(2, 8, 6),
(3, 9, 6),
(4, 10, 6);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_product`
--

CREATE TABLE IF NOT EXISTS `t_product` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `img` varchar(50) NOT NULL,
  `text` blob NOT NULL,
  `pageid` int(10) NOT NULL,
  `lang` varchar(5) NOT NULL,
  `productpage` blob,
  `productpagevisible` int(1) NOT NULL,
  `position` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=313 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_roles`
--

CREATE TABLE IF NOT EXISTS `t_roles` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `userid` int(10) NOT NULL,
  `roleid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `t_roles`
--

INSERT INTO `t_roles` (`id`, `name`, `userid`, `roleid`) VALUES
(1, 'admin', 1, 10);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_roles_custom`
--

CREATE TABLE IF NOT EXISTS `t_roles_custom` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Daten für Tabelle `t_roles_custom`
--

INSERT INTO `t_roles_custom` (`id`, `name`) VALUES
(7, 'guest'),
(8, 'user'),
(9, 'editor'),
(10, 'admin');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_session`
--

CREATE TABLE IF NOT EXISTS `t_session` (
  `userid` int(10) DEFAULT NULL,
  `sessionid` varchar(40) NOT NULL,
  `publicid` int(10) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `name` varchar(100) NOT NULL,
  `lastpolltime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_site`
--

CREATE TABLE IF NOT EXISTS `t_site` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `description` blob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Daten für Tabelle `t_site`
--

INSERT INTO `t_site` (`id`, `name`, `description`) VALUES
(1, 'asn', ''),
(2, 'sutango', ''),
(3, 'sutranslation', ''),
(4, 'castelsun', ''),
(5, 'nbm', '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_site_module`
--

CREATE TABLE IF NOT EXISTS `t_site_module` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `siteid` int(10) NOT NULL,
  `moduleid` varchar(10) COLLATE latin1_german2_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_site_template`
--

CREATE TABLE IF NOT EXISTS `t_site_template` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `siteid` int(10) NOT NULL,
  `templateid` int(10) NOT NULL,
  `main` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=6 ;

--
-- Daten für Tabelle `t_site_template`
--

INSERT INTO `t_site_template` (`id`, `siteid`, `templateid`, `main`) VALUES
(5, 1, 5, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_subscribeinfo`
--

CREATE TABLE IF NOT EXISTS `t_subscribeinfo` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `bereich` varchar(100) DEFAULT NULL,
  `anrede` varchar(100) DEFAULT NULL,
  `vorname` varchar(100) DEFAULT NULL,
  `nachname` varchar(100) DEFAULT NULL,
  `firma` varchar(100) DEFAULT NULL,
  `strasse` varchar(100) DEFAULT NULL,
  `hausnummer` varchar(100) DEFAULT NULL,
  `plz` varchar(100) DEFAULT NULL,
  `stadt` varchar(100) DEFAULT NULL,
  `telefon` varchar(100) DEFAULT NULL,
  `fax` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `anliegen` blob,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_subscribeinfopage`
--

CREATE TABLE IF NOT EXISTS `t_subscribeinfopage` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `text` blob NOT NULL,
  `confirmtext` blob NOT NULL,
  `confirmedtext` blob NOT NULL,
  `submittext` blob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_template`
--

CREATE TABLE IF NOT EXISTS `t_template` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `template` varchar(100) NOT NULL,
  `interface` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Daten für Tabelle `t_template`
--

INSERT INTO `t_template` (`id`, `name`, `template`, `interface`) VALUES
(1, 'tango full page', 'template/sutango/main.php', 'TangoFullPageTemplate'),
(2, 'asn split page', 'template/asn/split.php', 'AsnSplitPageTemplate'),
(3, 'sutranslation full page', 'template/sutranslation/main.php', 'TranslationFullPage'),
(4, 'sutranslation split page', 'template/sutranslation/split.php', 'TranslationSplitPage'),
(5, 'vbmscms full page 	', 'template/vbmscms/main.php', 'VbmscmsFullPage'),
(6, 'CastleSun full page', 'template/castlesun/main.php', 'CastlesunFullPage'),
(7, 'split page', 'template/nbm/split.php', 'SplitPageTemplate'),
(8, 'full page', 'template/nbm/main.php', 'FullPageTemplate');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_templatearea`
--

CREATE TABLE IF NOT EXISTS `t_templatearea` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `pageid` int(10) NOT NULL,
  `type` int(10) NOT NULL,
  `position` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=810 ;

--
-- Daten für Tabelle `t_templatearea`
--

INSERT INTO `t_templatearea` (`id`, `name`, `pageid`, `type`, `position`) VALUES
(806, 'center', 2, 1, -1),
(807, 'center', 3, 13, -1),
(808, 'center', 4, 44, -1),
(809, 'center', 5, 0, -1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_users`
--

CREATE TABLE IF NOT EXISTS `t_users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `objectid` int(10) NOT NULL,
  `registerdate` date NOT NULL,
  `birthdate` date NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4611 ;

--
-- Daten für Tabelle `t_users`
--

INSERT INTO `t_users` (`id`, `username`, `password`, `email`, `firstname`, `lastname`, `objectid`, `registerdate`, `birthdate`, `active`) VALUES
(1, 'admin', '098f6bcd4621d373cade4e832627b4f6', 'silkyfx@hotmail.de', '', '', 11, '0000-00-00', '0000-00-00', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_vdb_column`
--

CREATE TABLE IF NOT EXISTS `t_vdb_column` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `tableid` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `edittype` int(5) NOT NULL,
  `position` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Daten für Tabelle `t_vdb_column`
--

INSERT INTO `t_vdb_column` (`id`, `tableid`, `name`, `edittype`, `position`) VALUES
(1, 2, 'Username', 1, 1),
(2, 2, 'Firstname', 1, 1),
(3, 2, 'Lastname', 1, 1),
(4, 2, 'Email', 1, 1),
(5, 2, 'Date Of Birth', 7, 1),
(6, 2, 'Register Date', 7, 1),
(7, 2, 'active', 8, 1),
(8, 2, 'registered', 8, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_vdb_object`
--

CREATE TABLE IF NOT EXISTS `t_vdb_object` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `tableid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_vdb_table`
--

CREATE TABLE IF NOT EXISTS `t_vdb_table` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `t_vdb_table`
--

INSERT INTO `t_vdb_table` (`id`, `name`) VALUES
(2, 'userAttribs');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_vdb_value`
--

CREATE TABLE IF NOT EXISTS `t_vdb_value` (
  `objectid` int(10) NOT NULL,
  `columnid` int(10) NOT NULL,
  `value` blob NOT NULL,
  KEY `objectid` (`objectid`),
  KEY `columnid` (`columnid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
