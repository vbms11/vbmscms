<?php
/* start of sql
;

CREATE TABLE IF NOT EXISTS `t_backup` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur fÃ¼r Tabelle `t_chat_message`
--

CREATE TABLE IF NOT EXISTS `t_chat_message` (
  `room` int(10) NOT NULL,
  `version` int(10) NOT NULL,
  `message` blob NOT NULL,
  `user` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur fÃ¼r Tabelle `t_chat_room`
--

CREATE TABLE IF NOT EXISTS `t_chat_room` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur fÃ¼r Tabelle `t_chat_room_session`
--

CREATE TABLE IF NOT EXISTS `t_chat_room_session` (
  `room` int(10) NOT NULL,
  `sessionid` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur fÃ¼r Tabelle `t_cms_version`
--

CREATE TABLE IF NOT EXISTS `t_cms_version` (
  `version` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten fÃ¼r Tabelle `t_cms_version`
--

INSERT INTO `t_cms_version` (`version`) VALUES
(0.5);

-- --------------------------------------------------------

--
-- Tabellenstruktur fÃ¼r Tabelle `t_code`
--

CREATE TABLE IF NOT EXISTS `t_code` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lang` varchar(4) NOT NULL,
  `code` int(10) unsigned NOT NULL,
  `value` blob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur fÃ¼r Tabelle `t_comment`
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
-- Tabellenstruktur fÃ¼r Tabelle `t_confirm`
--

CREATE TABLE IF NOT EXISTS `t_confirm` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `hash` varchar(40) NOT NULL,
  `moduleid` int(10) NOT NULL,
  `args` blob NOT NULL,
  `expiredate` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur fÃ¼r Tabelle `t_domain`
--

CREATE TABLE IF NOT EXISTS `t_domain` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `url` varchar(200) NOT NULL,
  `siteid` int(10) NOT NULL,
  `domaintrackerscript` blob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Daten fÃ¼r Tabelle `t_domain`
--

INSERT INTO `t_domain` (`id`, `url`, `siteid`, `domaintrackerscript`) VALUES
(14, 'localhost', 1, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur fÃ¼r Tabelle `t_event`
--

CREATE TABLE IF NOT EXISTS `t_event` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `houres` int(10) NOT NULL DEFAULT '0',
  `minutes` int(10) NOT NULL DEFAULT '0',
  `starthoure` int(10) NOT NULL,
  `startminute` int(10) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` blob NOT NULL,
  `type` int(5) NOT NULL,
  `userid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur fÃ¼r Tabelle `t_forum_post`
--

CREATE TABLE IF NOT EXISTS `t_forum_post` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(10) NOT NULL,
  `threadid` int(10) NOT NULL,
  `message` blob NOT NULL,
  `createdate` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur fÃ¼r Tabelle `t_forum_thread`
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
-- Tabellenstruktur fÃ¼r Tabelle `t_forum_topic`
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
-- Tabellenstruktur fÃ¼r Tabelle `t_gallery_category`
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
-- Tabellenstruktur fÃ¼r Tabelle `t_gallery_image`
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
-- Tabellenstruktur fÃ¼r Tabelle `t_gallery_page`
--

CREATE TABLE IF NOT EXISTS `t_gallery_page` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `pageid` int(10) NOT NULL,
  `rootcategory` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur fÃ¼r Tabelle `t_language`
--

CREATE TABLE IF NOT EXISTS `t_language` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL,
  `local` varchar(10) NOT NULL,
  `flag` varchar(100) NOT NULL,
  `active` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Daten fÃ¼r Tabelle `t_language`
--

INSERT INTO `t_language` (`id`, `name`, `local`, `flag`, `active`) VALUES
(1, 'de', 'de', 'flag_germany.gif', 1),
(2, 'it', 'it_en', 'flag_italy.gif', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur fÃ¼r Tabelle `t_menu`
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur fÃ¼r Tabelle `t_menu_instance`
--

CREATE TABLE IF NOT EXISTS `t_menu_instance` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `siteid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur fÃ¼r Tabelle `t_menu_style`
--

CREATE TABLE IF NOT EXISTS `t_menu_style` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `cssclass` blob NOT NULL,
  `cssstyle` blob NOT NULL,
  `name` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Daten fÃ¼r Tabelle `t_menu_style`
--

INSERT INTO `t_menu_style` (`id`, `cssclass`, `cssstyle`, `name`) VALUES
(4, 0x706c61696e4469764d656e75, 0x2e706c61696e4469764d656e75207b0d0a202020206865696768743a323070783b0d0a7d0d0a2e706c61696e4469764d656e75202e7364646d207b0d0a20202020666f6e742d73697a653a20313570783b0d0a7d0d0a2e706c61696e4469764d656e75202e7364646d206469762061207b0d0a20202020636f6c6f723a20233030364335353b0d0a20202020746578742d6465636f726174696f6e3a206e6f6e653b0d0a2020202070616464696e673a20307078203770783b0d0a202020206d617267696e3a203070783b0d0a20202020666f6e742d7765696768743a6e6f726d616c3b0d0a7d0d0a2e706c61696e4469764d656e75202e7364646d2064697620612e7364646d53656c6563746564207b0d0a20202020666f6e742d7765696768743a20626f6c643b0d0a20202020636f6c6f723a626c61636b3b0d0a7d0d0a2e706c61696e4469764d656e75202e7364646d2064697620613a686f766572207b0d0a20202020636f6c6f723a20233030364335353b0d0a7d0d0a2e706c61696e4469764d656e75202e7364646d2064697620646976207b0d0a202020206261636b67726f756e642d636f6c6f723a20726762283235302c3235302c323530293b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a2020202070616464696e673a203470783b0d0a7d0d0a2e706c61696e4469764d656e75202e7364646d206469762064697620613a686f766572207b0d0a202020206261636b67726f756e642d636f6c6f723a20726762283234302c3234302c323430293b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a2020202070616464696e673a203370782033707820337078203470783b0d0a7d0d0a2e706c61696e4469764d656e75202e7364646d20646976206469762061207b0d0a202020206261636b67726f756e642d636f6c6f723a20726762283235302c3235302c323530293b0d0a2020202070616464696e673a203470783b0d0a7d0d0a2e706c61696e4469764d656e75202e7364646d206469762064697620612e7364646d53656c6563746564207b0d0a20202020666f6e742d7765696768743a20626f6c643b0d0a20202020636f6c6f723a626c61636b3b0d0a7d0d0a2e706c61696e4469764d656e75202e7364646d2064697620612e7364646d4669727374207b0d0a2020202070616464696e672d6c6566743a203070783b0d0a20202020626f726465722d6c6566743a20307078206e6f6e653b0d0a7d, 'plain'),
(5, 0x6c6576656c73, 0x2f2a206669727374206c6576656c202a2f0d0a0d0a2e6c6576656c73207b0d0a2020202070616464696e673a2031307078203070782030707820313070783b0d0a7d0d0a2e6c6576656c73202e7364646d207b0d0a20202020666c6f61743a6c6566743b0d0a7d0d0a2e6c6576656c73202e7364646d20646976207b0d0a20202020666c6f61743a6e6f6e653b0d0a7d0d0a2e6c6576656c73202e7364646d206469762061207b0d0a20202020636f6c6f723a20626c61636b3b0d0a20202020746578742d6465636f726174696f6e3a206e6f6e653b0d0a20202020746578742d616c69676e3a206c6566743b0d0a2020202070616464696e673a203570783b0d0a20202020666f6e742d7765696768743a626f6c643b0d0a20202020666f6e742d73697a653a20313470783b0d0a7d0d0a2e6c6576656c73202e7364646d2064697620613a686f766572207b0d0a09746578742d6465636f726174696f6e3a20756e6465726c696e653b0d0a7d0d0a2e6c6576656c73202e7364646d2064697620612e7364646d4669727374207b0d0a20202020626f726465722d6c6566743a20307078206e6f6e653b0d0a7d0d0a2e6c6576656c73202e7364646d20646976202e7364646d53656c6563746564207b0d0a20202020646973706c61793a20626c6f636b3b0d0a20202020636f6c6f723a207265643b0d0a7d0d0a0d0a2f2a207365636f6e64206c6576656c202a2f0d0a0d0a2e6c6576656c73202e7364646d2064697620646976207b0d0a20202020706f736974696f6e3a2072656c61746976653b0d0a202020206261636b67726f756e643a206e6f6e653b0d0a7d0d0a2e6c6576656c73202e7364646d20646976206469762061207b0d0a20202020636f6c6f723a20233030364335353b0d0a20202020666f6e742d73697a653a20313270783b0d0a20202020666f6e742d7765696768743a206e6f726d616c3b0d0a202020206261636b67726f756e643a2075726c28272e2e2f696d672f6c697374655f7a65696368656e2e6769662729206e6f2d7265706561743b0d0a202020206261636b67726f756e642d706f736974696f6e3a2030707820313070783b0d0a202020206d617267696e2d6c6566743a20313070783b0d0a2020202070616464696e672d6c6566743a20313070783b0d0a7d0d0a2e6c6576656c73202e7364646d206469762064697620612e7364646d53656c6563746564207b0d0a20202020666f6e742d7765696768743a20626f6c643b0d0a20202020636f6c6f723a20626c61636b3b0d0a7d0d0a2e6c6576656c73202e7364646d206469762064697620613a686f766572207b0d0a20202020636f6c6f723a20626c61636b3b0d0a20202020746578742d6465636f726174696f6e3a206e6f6e653b0d0a7d0d0a0d0a2f2a207468697264206c6576656c202a2f0d0a0d0a2e6c6576656c73202e7364646d206469762064697620646976207b0d0a20202020706f736974696f6e3a206162736f6c7574653b0d0a202020206261636b67726f756e643a20726762283234302c3234302c323430293b0d0a20202020746f703a3070783b0d0a202020206c6566743a31303070783b0d0a7d0d0a2e6c6576656c73202e7364646d2064697620646976206469762061207b0d0a20202020636f6c6f723a20233030364335353b0d0a20202020666f6e742d73697a653a20313270783b0d0a20202020666f6e742d7765696768743a206e6f726d616c3b0d0a202020206261636b67726f756e643a2075726c28272e2e2f696d672f6c697374655f7a65696368656e2e6769662729206e6f2d7265706561743b0d0a202020206261636b67726f756e642d706f736974696f6e3a2030707820313070783b0d0a202020206d617267696e2d6c6566743a20313070783b0d0a2020202070616464696e672d6c6566743a20313070783b0d0a7d0d0a2e6c6576656c73202e7364646d20646976206469762064697620612e7364646d53656c6563746564207b0d0a20202020666f6e742d7765696768743a20626f6c643b0d0a20202020636f6c6f723a20626c61636b3b0d0a7d0d0a2e6c6576656c73202e7364646d20646976206469762064697620613a686f766572207b0d0a20202020636f6c6f723a20626c61636b3b0d0a20202020746578742d6465636f726174696f6e3a206e6f6e653b0d0a7d, 'leftlevels'),
(6, 0x74687265656c6576, '', 'threelev');

-- --------------------------------------------------------

--
-- Tabellenstruktur fÃ¼r Tabelle `t_message`
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur fÃ¼r Tabelle `t_module`
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=65 ;

--
-- Daten fÃ¼r Tabelle `t_module`
--

INSERT INTO `t_module` (`id`, `name`, `sysname`, `include`, `description`, `interface`, `inmenu`, `category`, `position`, `static`) VALUES
(1, 'Seitenmanager', 'pages', 'modules/pages/pagesView.php', 0x616c6c6f777320796f7520746f206564697420746865206d656e75, 'PagesView', 0, 4, 0, 1),
(2, 'Wysiwyg Editor', '', 'modules/wysiwyg/wysiwygPageView.php', '', 'WysiwygPageView', 1, 1, 0, 0),
(13, 'Login', 'login', 'modules/users/loginModule.php', 0x616c6c6f777320796f7520746f20656e74657220616e6420657869742061646d696e206d6f6465, 'LoginModule', 1, 4, 0, 1),
(16, 'Newsletters', '', 'modules/newsletter/newsletterPageView.php', '', 'NewsletterPageView', 1, 3, 0, 0),
(17, 'Produkteliste', '', 'modules/products/productsPageView.php', '', 'ProductsPageView', 1, 1, 0, 0),
(62, 'Subscribe to role', 'subscribe', 'modules/users/registerRoleModule.php', NULL, 'RegisterRoleModule', 1, 0, 0, 1),
(24, 'Benutser Verwaltung', '', 'modules/users/usersPageView.php', '', 'UsersPageView', 1, 4, 0, 0),
(21, 'Sitemap', '', 'modules/sitemap/sitemapPageView.php', '', 'SitemapPageView', 1, 1, 0, 0),
(22, 'Suche', 'search', 'modules/search/searchPageView.php', '', 'SearchPageView', 1, 4, 0, 1),
(45, 'Insert Module', 'insertModule', 'modules/admin/insertModuleView.php', '', 'InsertModuleView', 0, 4, 0, 1),
(25, 'Forum', '', 'modules/forum/forumPageView.php', '', 'ForumPageView', 1, 2, 0, 0),
(26, 'Chat', '', 'modules/chat/chatPageView.php', '', 'ChatPageView', 1, 2, 0, 0),
(27, 'Comments', '', 'modules/comments/commentsView.php', '', 'CommentsView', 1, 2, 0, 0),
(37, 'Database backup', '', 'modules/admin/backupView.php', '', 'BackupView', 1, 4, 0, 0),
(29, 'Register', 'register', 'modules/users/registerModule.php', '', 'RegisterModule', 1, 4, 0, 1),
(30, 'Profile', '', 'modules/users/profilePageView.php', '', 'ProfilePageView', 1, 4, 0, 0),
(32, 'Role Administration', '', 'modules/admin/rolesView.php', '', 'RolesView', 1, 4, 0, 0),
(33, 'Gallery', '', 'modules/gallery/galleryView.php', '', 'GalleryView', 1, 1, 0, 0),
(34, 'Messages', '', 'modules/forum/messagePageView.php', '', 'MessagePageView', 1, 2, 0, 0),
(35, 'Events Callender', '', 'modules/events/callenderView.php', '', 'CallenderView', 1, 1, 0, 0),
(36, 'Events List', '', 'modules/events/eventsList.php', '', 'EventsListView', 1, 1, 0, 0),
(38, 'Templates Manager', '', 'modules/admin/templatesView.php', '', 'TemplatesView', 1, 4, 0, 0),
(39, 'Modules Manager', '', 'modules/admin/modulesView.php', '', 'ModulesView', 1, 4, 0, 0),
(40, 'Domains Manager', '', 'modules/admin/domainsView.php', '', 'DomainsView', 1, 4, 0, 0),
(41, 'Images', 'system', 'modules/admin/systemService.php', '', 'SystemService', 0, 4, 0, 1),
(42, 'Seo Settings', 'seo', 'modules/admin/seoView.php', '', 'SeoView', 0, 4, 0, 1),
(44, 'Startup Welcome', 'startup', 'modules/admin/startupView.php', '', 'StartupView', 0, 4, 0, 1),
(47, 'product Orders', '', 'modules/products/ordersView.php', '', 'OrdersView', 1, 5, 0, 0),
(48, 'Images Service', 'images', 'modules/admin/imagesService.php', '', 'ImageGenerator', 0, 4, 0, 1),
(49, 'Configure Tables', 'configTables', 'modules/datamodel/configureTablesView.php', '', 'ConfigureTablesView', 1, 5, 1, 1),
(50, 'Form View', '', 'modules/datamodel/formsView.php', '', 'FormsView', 1, 5, 0, 0),
(51, 'Results View', '', 'modules/datamodel/resultsView.php', '', 'ResultsView', 1, 4, 0, 0),
(52, 'Shopping Basket', 'shopBasket', 'modules/products/shopBasketView.php', NULL, 'ShopBasketView', 1, 5, 1, 1),
(53, 'Slideshow', '', 'modules/gallery/slideshowView.php', NULL, 'SlideshowView', 1, 1, 1, 0),
(54, 'File System Service', 'fileSystem', 'modules/admin/fileSystemService.php', NULL, 'FileSystemService', 0, 4, 0, 1),
(55, 'File Manager', '', 'modules/filesystem/filesystemView.php', NULL, 'FilesystemView', 1, 4, 1, 0),
(56, 'Rechnungen', '', 'modules/products/shopBillsView.php', NULL, 'ShopBillsView', 1, 4, 1, 0),
(57, 'Full Screen Callendar', '', 'modules/events/fullCallendarView.php', NULL, 'FullCallendarView', 1, 1, 0, 0),
(58, 'Events Table', 'eventsTable', 'modules/events/eventsTable.php', NULL, 'EventsTableView', 1, 0, 0, 1),
(59, 'Plain Menu', 'menu', 'modules/pages/menuModule.php', NULL, 'MenuView', 1, 0, 0, 0),
(60, 'Page Config', 'pageConfig', 'modules/pages/pageConfigModule.php', NULL, 'PageConfigModule', 0, 0, 0, 1),
(61, 'Confirm', 'confirm', 'modules/admin/confirmModuleView.php', NULL, 'ConfirmView', 0, 0, 0, 1),
(63, 'Languages', '', 'modules/admin/languagesModule.php', NULL, 'LanguagesModule', 1, 0, 0, 0),
(64, 'Search Box', '', 'modules/search/searchBoxModule.php', NULL, 'SearchBoxModule', 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur fÃ¼r Tabelle `t_module_category`
--

CREATE TABLE IF NOT EXISTS `t_module_category` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `position` int(10) NOT NULL,
  `name` varchar(200) COLLATE latin1_german2_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur fÃ¼r Tabelle `t_module_instance`
--

CREATE TABLE IF NOT EXISTS `t_module_instance` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `moduleid` int(10) NOT NULL,
  `templateareaid` int(10) NOT NULL,
  PRIMARY KEY (`id`,`moduleid`,`templateareaid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur fÃ¼r Tabelle `t_module_instance_params`
--

CREATE TABLE IF NOT EXISTS `t_module_instance_params` (
  `instanceid` int(10) NOT NULL,
  `name` varchar(100) COLLATE latin1_german2_ci NOT NULL,
  `value` blob NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur fÃ¼r Tabelle `t_module_roles`
--

CREATE TABLE IF NOT EXISTS `t_module_roles` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `customrole` int(10) NOT NULL,
  `modulerole` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1047 ;

--
-- Daten fÃ¼r Tabelle `t_module_roles`
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
(932, 7, 'products.view'),
(933, 7, 'forum.view'),
(934, 7, 'gallery.view'),
(991, 10, 'pages.editmenu'),
(992, 10, 'pages.edit'),
(993, 10, 'wysiwyg.edit'),
(994, 10, 'login.edit'),
(995, 10, 'newsletter.edit'),
(996, 10, 'newsletter.send'),
(997, 10, 'products.edit'),
(998, 10, 'products.view'),
(999, 10, 'roles.register.edit'),
(1000, 10, 'users.edit'),
(1001, 10, 'sitemap.edit'),
(1002, 10, 'modules.insert'),
(1003, 10, 'forum.topic.create'),
(1004, 10, 'forum.thread.create'),
(1005, 10, 'forum.view'),
(1006, 10, 'forum.admin'),
(1007, 10, 'forum.moderator'),
(1008, 10, 'forum.thread.post'),
(1009, 10, 'chat.user'),
(1010, 10, 'chat.view'),
(1011, 10, 'comment.post'),
(1012, 10, 'comment.edit'),
(1013, 10, 'comment.delete'),
(1014, 10, 'backup.create'),
(1015, 10, 'backup.load'),
(1016, 10, 'backup.delete'),
(1017, 10, 'users.register.edit'),
(1018, 10, 'users.profile'),
(1019, 10, 'admin.roles.edit'),
(1020, 10, 'gallery.edit'),
(1021, 10, 'gallery.view'),
(1022, 10, 'message.inbox'),
(1023, 10, 'events.callender'),
(1024, 10, 'events.list'),
(1025, 10, 'events.edit'),
(1026, 10, 'template.edit'),
(1027, 10, 'template.view'),
(1028, 10, 'orders.edit'),
(1029, 10, 'orders.view'),
(1030, 10, 'orders.all'),
(1031, 10, 'orders.confirm'),
(1032, 10, 'orders.finnish'),
(1033, 10, 'dm.tables.config'),
(1034, 10, 'dm.forms.edit'),
(1035, 10, 'shop.basket.view'),
(1036, 10, 'shop.basket.status.edit'),
(1037, 10, 'shop.basket.edit'),
(1038, 10, 'shop.basket.details.view'),
(1039, 10, 'shop.basket.details.edit'),
(1040, 10, 'slideshow.edit'),
(1041, 10, 'filesystem.all'),
(1042, 10, 'filesystem.user'),
(1043, 10, 'filesystem.www'),
(1044, 10, 'filesystem.edit'),
(1045, 10, 'events.users.all'),
(1046, 10, 'menu.edit');

-- --------------------------------------------------------

--
-- Tabellenstruktur fÃ¼r Tabelle `t_newsletter`
--

CREATE TABLE IF NOT EXISTS `t_newsletter` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `text` blob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur fÃ¼r Tabelle `t_newsletter_email`
--

CREATE TABLE IF NOT EXISTS `t_newsletter_email` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `name` varchar(200) NOT NULL,
  `confirmed` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur fÃ¼r Tabelle `t_newsletter_emailgroup`
--

CREATE TABLE IF NOT EXISTS `t_newsletter_emailgroup` (
  `emailid` int(10) NOT NULL AUTO_INCREMENT,
  `roleid` int(50) NOT NULL,
  PRIMARY KEY (`emailid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur fÃ¼r Tabelle `t_order`
--

CREATE TABLE IF NOT EXISTS `t_order` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(10) NOT NULL,
  `distributorid` int(10) DEFAULT NULL,
  `roleid` int(10) NOT NULL,
  `status` int(3) NOT NULL,
  `orderdate` date NOT NULL,
  `objectid` int(10) DEFAULT NULL,
  `orderform` int(10) NOT NULL,
  `rabatt` decimal(10,0) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur fÃ¼r Tabelle `t_order_product`
--

CREATE TABLE IF NOT EXISTS `t_order_product` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `productid` int(10) NOT NULL,
  `orderid` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur fÃ¼r Tabelle `t_page`
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
  `codeid` int(10) DEFAULT NULL,
  `sitetrackerscript` blob,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur fÃ¼r Tabelle `t_page_roles`
--

CREATE TABLE IF NOT EXISTS `t_page_roles` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `roleid` int(10) NOT NULL,
  `pageid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur fÃ¼r Tabelle `t_product`
--

CREATE TABLE IF NOT EXISTS `t_product` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `img` varchar(50) NOT NULL,
  `text` blob NOT NULL,
  `titel` varchar(200) NOT NULL,
  `price` decimal(10,0) DEFAULT NULL,
  `pageid` int(10) NOT NULL,
  `lang` varchar(5) NOT NULL,
  `position` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `minimum` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur fÃ¼r Tabelle `t_roles`
--

CREATE TABLE IF NOT EXISTS `t_roles` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `userid` int(10) NOT NULL,
  `roleid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur fÃ¼r Tabelle `t_roles_custom`
--

CREATE TABLE IF NOT EXISTS `t_roles_custom` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Daten fÃ¼r Tabelle `t_roles_custom`
--

INSERT INTO `t_roles_custom` (`id`, `name`) VALUES
(7, 'guest'),
(8, 'user'),
(9, 'editor'),
(10, 'admin');

-- --------------------------------------------------------

--
-- Tabellenstruktur fÃ¼r Tabelle `t_session`
--

CREATE TABLE IF NOT EXISTS `t_session` (
  `userid` int(10) DEFAULT NULL,
  `sessionid` varchar(40) NOT NULL,
  `sessionkey` varchar(40) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `name` varchar(100) NOT NULL,
  `lastpolltime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `logintime` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten fÃ¼r Tabelle `t_session`
--

INSERT INTO `t_session` (`userid`, `sessionid`, `sessionkey`, `ip`, `name`, `lastpolltime`, `logintime`) VALUES
(NULL, 'aec985b187142b499e2f54b26847d9438feb3c43', 'ySK8obwfcDl3LyMiTtq3AY+c4bBfD+5C9jVCmEuB', '127.0.0.1', 'guest_3405506', '2012-10-10 10:39:05', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur fÃ¼r Tabelle `t_site`
--

CREATE TABLE IF NOT EXISTS `t_site` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `description` blob NOT NULL,
  `sitetrackerscript` blob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Daten fÃ¼r Tabelle `t_site`
--

INSERT INTO `t_site` (`id`, `name`, `description`, `sitetrackerscript`) VALUES
(1, 'vbmscms admin', '', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur fÃ¼r Tabelle `t_site_module`
--

CREATE TABLE IF NOT EXISTS `t_site_module` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `siteid` int(10) NOT NULL,
  `moduleid` varchar(10) COLLATE latin1_german2_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur fÃ¼r Tabelle `t_site_template`
--

CREATE TABLE IF NOT EXISTS `t_site_template` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `siteid` int(10) NOT NULL,
  `templateid` int(10) NOT NULL,
  `main` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=34 ;

--
-- Daten fÃ¼r Tabelle `t_site_template`
--

INSERT INTO `t_site_template` (`id`, `siteid`, `templateid`, `main`) VALUES
(1, 1, 1, 1),
(27, 1, 19, 0),
(28, 1, 20, 0),
(31, 1, 21, 0),
(30, 1, 22, 0),
(32, 1, 23, 0),
(33, 1, 24, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur fÃ¼r Tabelle `t_template`
--

CREATE TABLE IF NOT EXISTS `t_template` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `template` varchar(100) NOT NULL,
  `interface` varchar(100) NOT NULL,
  `html` blob,
  `css` blob,
  `js` blob,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Daten fÃ¼r Tabelle `t_template`
--

INSERT INTO `t_template` (`id`, `name`, `template`, `interface`, `html`, `css`, `js`) VALUES
(1, 'vbmscms Admin Template', '', '', 0x3c64697620636c6173733d226672616d65446976223e0d0a202020203c64697620636c6173733d22686561646572446976223e0d0a20202020202020203c64697620636c6173733d226865616465724d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e617265612e6d656e7520636d733f2667743b0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22626f6479446976223e0d0a20202020202020203c64697620636c6173733d22626f64794d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e6d61696e2e63656e74657220636d733f2667743b0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a3c2f6469763e, 0x626f6479207b0d0a70616464696e673a3070783b0d0a6d617267696e3a3070783b0d0a7d202020200d0a0d0a2e6672616d65446976207b0d0a20202020202020206d696e2d77696474683a2037303070783b0d0a202020207d0d0a202020202e686561646572446976207b0d0a20202020202020206865696768743a20343070783b0d0a20202020202020206d617267696e3a20313070783b0d0a2020202020202020626f726465723a20317078206461736865642073696c7665723b0d0a6261636b67726f756e643a2075726c282767726164536d616c6c2e6769662729207768697465207265706561742d783b0d0a202020207d0d0a202020202e6865616465724d617267696e446976207b0d0a20202020202020206d617267696e3a313070783b0d0a202020207d0d0a202020202e626f6479446976207b0d0a20202020202020206d696e2d6865696768743a2032303070783b0d0a20202020202020206d617267696e3a20313070783b0d0a2020202020202020626f726465723a20317078206461736865642073696c7665723b0d0a6261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a202020207d0d0a202020202e626f64794d617267696e446976207b0d0a20202020202020206d617267696e3a313070783b0d0a202020207d, ''),
(19, 'Docpanel Demo Template', '', '', 0x3c64697620636c6173733d226672616d65446976223e0d0a20203c212d2d20686561646572202d2d3e0d0a20203c64697620636c6173733d22686561646572446976223e0d0a202020203c64697620636c6173733d226865616465724d617267696e446976223e0d0a202020202020266c743b3f636d732074656d706c6174652e617265612e68656164657220636d733f2667743b0d0a202020203c2f6469763e0d0a20203c2f6469763e0d0a20203c64697620636c6173733d226d656e75446976223e0d0a202020203c64697620636c6173733d226d656e754d617267696e446976223e0d0a202020202020266c743b3f636d732074656d706c6174652e617265612e6d656e7520636d733f2667743b0d0a202020203c2f6469763e0d0a20203c2f6469763e0d0a20203c212d2d2063656e746572202d2d3e0d0a20203c64697620636c6173733d227269676874426f6479446976223e0d0a202020203c64697620636c6173733d227269676874426f64794d617267696e446976223e0d0a202020202020266c743b3f636d732074656d706c6174652e617265612e726967687420636d733f2667743b0d0a202020203c2f6469763e0d0a20203c2f6469763e0d0a20203c64697620636c6173733d226c656674426f6479446976223e0d0a202020203c64697620636c6173733d226c656674426f64794d617267696e446976223e0d0a202020202020266c743b3f636d732074656d706c6174652e617265612e6c65667420636d733f2667743b0d0a202020203c2f6469763e0d0a20203c2f6469763e0d0a20203c64697620636c6173733d22626f6479446976223e0d0a202020203c64697620636c6173733d22626f64794d617267696e446976223e0d0a202020202020266c743b3f636d732074656d706c6174652e6d61696e2e63656e74657220636d733f2667743b0d0a202020203c2f6469763e0d0a20203c2f6469763e0d0a20203c212d2d20666f6f746572202d2d3e0d0a20203c64697620636c6173733d22666f6f746572446976223e0d0a202020203c64697620636c6173733d22666f6f7465724d617267696e446976223e0d0a202020202020266c743b3f636d732074656d706c6174652e617265612e666f6f74657220636d733f2667743b0d0a202020203c2f6469763e0d0a20203c2f6469763e0d0a3c2f6469763e, 0x626f6479207b0d0a0970616464696e673a3070783b0d0a096d617267696e3a3070783b0d0a7d202020200d0a2e6672616d65446976207b0d0a096d696e2d77696474683a2038303070783b0d0a7d0d0a2e686561646572446976207b0d0a096d696e2d6865696768743a20363070783b0d0a096d617267696e3a20313070783b0d0a09626f726465723a20317078206461736865642073696c7665723b0d0a20202020202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e6865616465724d617267696e446976207b0d0a096261636b67726f756e643a2075726c28276c6f676f2e706e672729207269676874206e6f2d7265706561743b0d0a20202020202020206865696768743a20353070783b0d0a20202020202020206d617267696e3a203570783b0d0a7d0d0a2e6d656e75446976207b0d0a096d696e2d6865696768743a20333070783b0d0a096d617267696e3a203130707820313070782030707820313070783b0d0a09626f726465723a20317078206461736865642073696c7665723b0d0a20202020202020206261636b67726f756e643a2075726c282767726164536d616c6c2e6769662729207768697465207265706561742d783b0d0a7d0d0a2e6d656e754d617267696e446976207b0d0a096d617267696e3a203570783b0d0a7d0d0a2e7269676874426f6479446976207b0d0a0977696474683a2032303070783b0d0a09666c6f61743a2072696768743b0d0a096d617267696e3a20313070783b0d0a096d696e2d6865696768743a2032303070783b0d0a09626f726465723a20317078206461736865642073696c7665723b0d0a20202020202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e7269676874426f64794d617267696e446976207b0d0a096d617267696e3a20313070783b0d0a7d0d0a2e6c656674426f6479446976207b0d0a0977696474683a2032303070783b0d0a09666c6f61743a206c6566743b0d0a096d617267696e3a20313070783b0d0a096d696e2d6865696768743a2032303070783b0d0a09626f726465723a20317078206461736865642073696c7665723b0d0a20202020202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e6c656674426f64794d617267696e446976207b0d0a096d617267696e3a20313070783b0d0a7d0d0a2e626f6479446976207b0d0a096d617267696e3a20313070782032323070783b0d0a09626f726465723a20317078206461736865642073696c7665723b0d0a096d696e2d6865696768743a2032303070783b0d0a20202020202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f64794d617267696e446976207b0d0a096d617267696e3a313070783b0d0a7d0d0a2e666f6f746572446976207b0d0a096d617267696e3a313070783b0d0a096d696e2d6865696768743a20323070783b0d0a09626f726465723a20317078206461736865642073696c7665723b0d0a20202020202020206261636b67726f756e643a2075726c282767726164536d616c6c2e6769662729207768697465207265706561742d783b0d0a7d0d0a2e666f6f7465724d617267696e446976207b0d0a096d617267696e3a3570783b0d0a7d, ''),
(20, 'Docpanel Left Demo Template', '', '', 0x3c64697620636c6173733d226672616d65446976223e0d0a20203c212d2d20686561646572202d2d3e0d0a20203c64697620636c6173733d22686561646572446976223e0d0a202020203c64697620636c6173733d226865616465724d617267696e446976223e0d0a202020202020266c743b3f636d732074656d706c6174652e617265612e68656164657220636d733f2667743b0d0a202020203c2f6469763e0d0a20203c2f6469763e0d0a20203c64697620636c6173733d226d656e75446976223e0d0a202020203c64697620636c6173733d226d656e754d617267696e446976223e0d0a202020202020266c743b3f636d732074656d706c6174652e617265612e6d656e7520636d733f2667743b0d0a202020203c2f6469763e0d0a20203c2f6469763e0d0a20203c212d2d2063656e746572202d2d3e0d0a20203c64697620636c6173733d226c656674426f6479446976223e0d0a202020203c64697620636c6173733d226c656674426f64794d617267696e446976223e0d0a202020202020266c743b3f636d732074656d706c6174652e617265612e6c65667420636d733f2667743b0d0a202020203c2f6469763e0d0a20203c2f6469763e0d0a20203c64697620636c6173733d22626f6479446976223e0d0a202020203c64697620636c6173733d22626f64794d617267696e446976223e0d0a202020202020266c743b3f636d732074656d706c6174652e6d61696e2e63656e74657220636d733f2667743b0d0a202020203c2f6469763e0d0a20203c2f6469763e0d0a20203c212d2d20666f6f746572202d2d3e0d0a20203c64697620636c6173733d22666f6f746572446976223e0d0a202020203c64697620636c6173733d22666f6f7465724d617267696e446976223e0d0a202020202020266c743b3f636d732074656d706c6174652e617265612e666f6f74657220636d733f2667743b0d0a202020203c2f6469763e0d0a20203c2f6469763e0d0a3c2f6469763e, 0x626f6479207b0d0a0970616464696e673a3070783b0d0a096d617267696e3a3070783b0d0a7d202020200d0a2e6672616d65446976207b0d0a096d696e2d77696474683a2038303070783b0d0a7d0d0a2e686561646572446976207b0d0a096d696e2d6865696768743a20363070783b0d0a096d617267696e3a20313070783b0d0a09626f726465723a20317078206461736865642073696c7665723b0d0a20202020202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e6865616465724d617267696e446976207b0d0a096261636b67726f756e643a2075726c28276c6f676f2e706e672729207269676874206e6f2d7265706561743b0d0a20202020202020206865696768743a20353070783b0d0a20202020202020206d617267696e3a203570783b0d0a7d0d0a2e6d656e75446976207b0d0a096d696e2d6865696768743a20333070783b0d0a096d617267696e3a203130707820313070782030707820313070783b0d0a09626f726465723a20317078206461736865642073696c7665723b0d0a20202020202020206261636b67726f756e643a2075726c282767726164536d616c6c2e6769662729207768697465207265706561742d783b0d0a7d0d0a2e6d656e754d617267696e446976207b0d0a096d617267696e3a203570783b0d0a7d0d0a2e6c656674426f6479446976207b0d0a0977696474683a2032303070783b0d0a09666c6f61743a206c6566743b0d0a096d617267696e3a20313070783b0d0a096d696e2d6865696768743a2032303070783b0d0a09626f726465723a20317078206461736865642073696c7665723b0d0a20202020202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e6c656674426f64794d617267696e446976207b0d0a096d617267696e3a20313070783b0d0a7d0d0a2e626f6479446976207b0d0a096d617267696e3a2031307078203130707820313070782032323070783b0d0a09626f726465723a20317078206461736865642073696c7665723b0d0a096d696e2d6865696768743a2032303070783b0d0a20202020202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f64794d617267696e446976207b0d0a096d617267696e3a313070783b0d0a7d0d0a2e666f6f746572446976207b0d0a096d617267696e3a313070783b0d0a096d696e2d6865696768743a20323070783b0d0a09626f726465723a20317078206461736865642073696c7665723b0d0a20202020202020206261636b67726f756e643a2075726c282767726164536d616c6c2e6769662729207768697465207265706561742d783b0d0a7d0d0a2e666f6f7465724d617267696e446976207b0d0a096d617267696e3a3570783b0d0a7d, ''),
(21, 'Docpanel Right Demo Template', '', '', 0x3c64697620636c6173733d226672616d65446976223e0d0a20203c212d2d20686561646572202d2d3e0d0a20203c64697620636c6173733d22686561646572446976223e0d0a202020203c64697620636c6173733d226865616465724d617267696e446976223e0d0a202020202020266c743b3f636d732074656d706c6174652e617265612e68656164657220636d733f2667743b0d0a202020203c2f6469763e0d0a20203c2f6469763e0d0a20203c64697620636c6173733d226d656e75446976223e0d0a202020203c64697620636c6173733d226d656e754d617267696e446976223e0d0a202020202020266c743b3f636d732074656d706c6174652e617265612e6d656e7520636d733f2667743b0d0a202020203c2f6469763e0d0a20203c2f6469763e0d0a20203c212d2d2063656e746572202d2d3e0d0a20203c64697620636c6173733d227269676874426f6479446976223e0d0a202020203c64697620636c6173733d227269676874426f64794d617267696e446976223e0d0a202020202020266c743b3f636d732074656d706c6174652e617265612e726967687420636d733f2667743b0d0a202020203c2f6469763e0d0a20203c2f6469763e0d0a20203c64697620636c6173733d22626f6479446976223e0d0a202020203c64697620636c6173733d22626f64794d617267696e446976223e0d0a202020202020266c743b3f636d732074656d706c6174652e6d61696e2e63656e74657220636d733f2667743b0d0a202020203c2f6469763e0d0a20203c2f6469763e0d0a20203c212d2d20666f6f746572202d2d3e0d0a20203c64697620636c6173733d22666f6f746572446976223e0d0a202020203c64697620636c6173733d22666f6f7465724d617267696e446976223e0d0a202020202020266c743b3f636d732074656d706c6174652e617265612e666f6f74657220636d733f2667743b0d0a202020203c2f6469763e0d0a20203c2f6469763e0d0a3c2f6469763e, 0x626f6479207b0d0a0970616464696e673a3070783b0d0a096d617267696e3a3070783b0d0a7d202020200d0a2e6672616d65446976207b0d0a096d696e2d77696474683a2038303070783b0d0a7d0d0a2e686561646572446976207b0d0a096d696e2d6865696768743a20363070783b0d0a096d617267696e3a20313070783b0d0a09626f726465723a20317078206461736865642073696c7665723b0d0a7d0d0a2e6865616465724d617267696e446976207b0d0a096d617267696e3a20313070783b0d0a7d0d0a2e6d656e75446976207b0d0a096d696e2d6865696768743a20333070783b0d0a096d617267696e3a203130707820313070782030707820313070783b0d0a09626f726465723a20317078206461736865642073696c7665723b0d0a7d0d0a2e6d656e754d617267696e446976207b0d0a096d617267696e3a203570783b0d0a7d0d0a2e7269676874426f6479446976207b0d0a0977696474683a2032343070783b0d0a09666c6f61743a2072696768743b0d0a096d617267696e3a20313070783b0d0a096d696e2d6865696768743a2032303070783b0d0a09626f726465723a20317078206461736865642073696c7665723b0d0a7d0d0a2e7269676874426f64794d617267696e446976207b0d0a096d617267696e3a20313070783b0d0a7d0d0a2e626f6479446976207b0d0a096d617267696e3a2031307078203236307078203130707820313070783b0d0a09626f726465723a20317078206461736865642073696c7665723b0d0a096d696e2d6865696768743a2032303070783b0d0a7d0d0a2e626f64794d617267696e446976207b0d0a096d617267696e3a313070783b0d0a7d0d0a2e666f6f746572446976207b0d0a096d617267696e3a313070783b0d0a096d696e2d6865696768743a20323070783b0d0a09626f726465723a20317078206461736865642073696c7665723b0d0a7d0d0a2e666f6f7465724d617267696e446976207b0d0a096d617267696e3a3570783b0d0a7d, ''),
(23, 'Fat', '', '', 0x3c6469762069643d22746f70426f64794d617267696e446976223e0d0a202020202020202020202020202020203c6469762069643d22686561646572446976223e0d0a20202020202020202020202020202020202020203c6469762069643d22686561646572436f6e74656e74446976223e0d0a3c6469762069643d22746f704d656e75446976223e0d0a20202020202020202020202020202020266c743b3f636d732074656d706c6174652e617265612e746f7020636d733f2667743b0d0a2020202020202020202020203c2f6469763e0d0a2020202020202020202020202020202020202020202020203c6469762069643d226c616e6753656c656374223e0d0a20202020202020202020202020202020202020202020202020202020266c743b3f636d732074656d706c6174652e617265612e6c616e6720636d733f2667743b0d0a2020202020202020202020202020202020202020202020203c2f6469763e0d0a3c687220636c6173733d226872436c65617222202f3e0d0a2020202020203c6469763e0d0a20202020202020202020202020202020202020202020202020202020266c743b3f636d7320202074656d706c6174652e617265612e68656164657220636d733f2667743b0d0a2020202020203c2f6469763e0d0a20202020202020202020202020202020202020203c2f6469763e0d0a20202020202020202020202020202020202020203c6469762069643d226865616465724d656e75446976223e0d0a202020202020202020202020202020202020202020202020266c743b3f636d7320202074656d706c6174652e617265612e6d656e7520636d733f2667743b0d0a20202020202020202020202020202020202020203c2f6469763e0d0a202020202020202020202020202020203c2f6469763e0d0a202020202020202020202020202020203c6469762069643d22626f6479446976223e0d0a20202020202020202020202020202020202020203c6469762069643d22626f647946756c6c446976223e0d0a2020202020202020202020202020202020202020202020203c64697620636c6173733d226d617267696e446976223e0d0a20202020202020202020202020202020202020202020202020202020266c743b3f636d7320202074656d706c6174652e6d61696e2e6d61696e20636d733f2667743b0d0a2020202020202020202020202020202020202020202020203c2f6469763e0d0a20202020202020202020202020202020202020203c2f6469763e0d0a202020202020202020202020202020203c2f6469763e0d0a202020202020202020202020202020203c6469762069643d22666f6f746572446976223e0d0a20202020202020202020202020202020202020203c6469762069643d22666f6f7465724d656e75446976223e0d0a202020202020202020202020202020202020202020202020266c743b3f636d7320202074656d706c6174652e617265612e666f6f74657220636d733f2667743b0d0a20202020202020202020202020202020202020203c2f6469763e0d0a202020202020202020202020202020203c2f6469763e0d0a2020202020202020202020203c2f6469763e, 0x626f6479207b0d0a202020206261636b67726f756e643a2075726c28276d61696e4261636b67726f756e642e6a70672729207265706561743b0d0a096d617267696e3a203070783b0d0a2020202070616464696e673a203070783b0d0a7d0d0a23746f70426f64794261636b67726f756e64207b0d0a202020200d0a2020202070616464696e673a203130707820313030707820323070782031303070783b0d0a7d0d0a23746f70426f64794d617267696e446976207b0d0a202020206d617267696e3a2030252035253b0d0a202020206d696e2d77696474683a2038303070783b0d0a7d0d0a23746f704d656e75446976207b0d0a666c6f61743a72696768743b0d0a202020206865696768743a20323570783b0d0a7d0d0a23686561646572446976207b0d0a7d0d0a23686561646572436f6e74656e74446976207b0d0a7d0d0a236865616465724d656e75446976207b0d0a202020200d0a202020206865696768743a20333070783b0d0a7d0d0a23626f6479446976207b0d0a6261636b67726f756e643a2075726c2827626f64794261636b67726f756e642e706e672729207265706561742d783b0d0a2020202070616464696e673a203138707820313070783b0d0a7d0d0a23626f64794c656674446976207b0d0a20202020666c6f61743a206c6566743b0d0a202020206d617267696e3a203070782030707820307078203070783b0d0a202020202f2a2070616464696e673a20313070783b202a2f0d0a202020206d696e2d6865696768743a2033363070783b0d0a2020202077696474683a2032303070783b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a7d0d0a23626f647943656e746572446976207b0d0a202020206d617267696e3a2030707820307078203070782032313070783b200d0a202020202f2a2070616464696e673a2031307078203130707820307078203070783b2a2f0d0a202020206d696e2d6865696768743a2033363070783b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a7d0d0a23626f647943656e746572446976202e6d617267696e446976207b0d0a202020206d617267696e3a20313070783b0d0a7d0d0a23626f647946756c6c446976207b0d0a202020206d617267696e3a203070782030707820307078203070783b200d0a202020206d696e2d6865696768743a2033363070783b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a202020206261636b67726f756e642d636f6c6f723a77686974653b0d0a7d0d0a23626f647946756c6c446976202e6d617267696e446976207b0d0a202020206d617267696e3a20313070783b0d0a7d0d0a23666f6f746572446976207b0d0a202020206d696e2d6865696768743a20333070783b0d0a202020206261636b67726f756e643a20726762283139312c32312c3334293b0d0a7d0d0a23666f6f7465724d656e75446976207b0d0a0d0a7d0d0a0d0a0d0a23636d73426f6479446976207b0d0a202020206d617267696e2d626f74746f6d3a203070783b0d0a7d0d0a0d0a0d0a0d0a2f2a20746f70206d656e752a2f0d0a0d0a23746f704d656e75446976202e7364646d20646976207b0d0a20202020666c6f61743a2072696768743b0d0a7d0d0a23746f704d656e75446976202e7364646d20646976207b0d0a20202020666c6f61743a2072696768743b0d0a7d0d0a23746f704d656e75446976202e7364646d206469762061207b0d0a20202020636f6c6f723a20236666666666663b0d0a096261636b67726f756e643a206e6f6e6520726570656174207363726f6c6c2030203020234246313532323b0d0a7d0d0a23746f704d656e75446976202e7364646d2064697620613a686f766572207b0d0a20202020636f6c6f723a207267622838302c38302c313830293b0d0a7d0d0a0d0a2f2a20686561646572206d656e75202a2f0d0a0d0a236865616465724d656e75446976202e7364646d20646976207b0d0a202020206d617267696e3a203070782030707820357078203570783b0d0a2020202070616464696e673a203270783b0d0a202020206261636b67726f756e643a20726762283231302c3231302c323130293b0d0a7d0d0a236865616465724d656e75446976202e7364646d206469762061207b0d0a20202020636f6c6f723a207267622838302c38302c3830293b0d0a7d0d0a236865616465724d656e75446976202e7364646d2064697620613a686f766572207b0d0a20202020636f6c6f723a207267622838302c38302c313830293b0d0a7d0d0a0d0a2f2a20666f6f746572206d656e75202a2f0d0a0d0a23666f6f7465724d656e75446976202e7364646d20646976207b0d0a202020206d617267696e2d746f703a203270783b0d0a7d0d0a23666f6f7465724d656e75446976202e7364646d20646976207b0d0a20202020666c6f61743a2072696768743b0d0a7d0d0a0d0a2f2a206d656e7520636f6d6d6f6e2a2f0d0a0d0a2e7364646d202e7364646d427574746f6e2061207b0d0a2020202070616464696e673a203070783b0d0a7d0d0a2e7364646d202e7364646d427574746f6e207b0d0a2020202070616464696e673a203070783b0d0a202020206261636b67726f756e643a206e6f6e653b0d0a7d0d0a0d0a2f2a20202a2f0d0a0d0a23626f64794c656674446976202e7364646d20646976207b0d0a20202020666c6f61743a6e6f6e653b0d0a7d0d0a23626f64794c656674446976202e7364646d206469762061207b0d0a20202020746578742d616c69676e3a6c6566743b0d0a7d0d0a0d0a0d0a0d0a2f2a206c616e676167652073656c656374696f6e202a2f0d0a0d0a236c616e6753656c656374207b0d0a20202020666c6f61743a6c6566743b0d0a7d0d0a2e6c616e6753656c6563744c696e6b207b0d0a202020200d0a7d0d0a0d0a, ''),
(22, 'Docpanel Stack Demo Template', '', '', 0x3c64697620636c6173733d226672616d65446976223e0d0a20203c212d2d20686561646572202d2d3e0d0a20203c64697620636c6173733d22686561646572446976223e0d0a202020203c64697620636c6173733d226865616465724d617267696e446976223e0d0a202020202020266c743b3f636d732074656d706c6174652e617265612e68656164657220636d733f2667743b3c2f6469763e0d0a20203c2f6469763e0d0a20203c64697620636c6173733d226d656e75446976223e0d0a202020203c64697620636c6173733d226d656e754d617267696e446976223e0d0a202020202020266c743b3f636d732074656d706c6174652e617265612e6d656e7520636d733f2667743b0d0a202020203c2f6469763e0d0a20203c2f6469763e0d0a20203c212d2d2063656e746572202d2d3e0d0a20203c64697620636c6173733d22626f6479446976223e0d0a202020203c64697620636c6173733d22626f64794d617267696e446976223e0d0a202020202020266c743b3f636d732074656d706c6174652e6d61696e2e63656e74657220636d733f2667743b0d0a202020203c2f6469763e0d0a20203c2f6469763e0d0a20203c212d2d20666f6f746572202d2d3e0d0a20203c64697620636c6173733d22666f6f746572446976223e0d0a202020203c64697620636c6173733d22666f6f7465724d617267696e446976223e0d0a202020202020266c743b3f636d732074656d706c6174652e617265612e666f6f74657220636d733f2667743b0d0a202020203c2f6469763e0d0a20203c2f6469763e0d0a3c2f6469763e, 0x626f6479207b0d0a0970616464696e673a3070783b0d0a096d617267696e3a3070783b0d0a7d202020200d0a2e6672616d65446976207b0d0a096d696e2d77696474683a2038303070783b0d0a7d0d0a2e686561646572446976207b0d0a096d696e2d6865696768743a20363070783b0d0a096d617267696e3a20313070783b0d0a09626f726465723a20317078206461736865642073696c7665723b0d0a096261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e6865616465724d617267696e446976207b0d0a096261636b67726f756e643a2075726c28276c6f676f2e706e672729207269676874206e6f2d7265706561743b0d0a20202020202020206865696768743a20353070783b0d0a20202020202020206d617267696e3a203570783b0d0a7d0d0a2e6d656e75446976207b0d0a096d696e2d6865696768743a20333070783b0d0a096d617267696e3a203130707820313070782030707820313070783b0d0a09626f726465723a20317078206461736865642073696c7665723b0d0a096261636b67726f756e643a2075726c282767726164536d616c6c2e6769662729207768697465207265706561742d783b0d0a7d0d0a2e6d656e754d617267696e446976207b0d0a096d617267696e3a203570783b0d0a7d0d0a2e626f6479446976207b0d0a096d617267696e3a20313070783b0d0a09626f726465723a20317078206461736865642073696c7665723b0d0a096d696e2d6865696768743a2032303070783b0d0a096261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f64794d617267696e446976207b0d0a096d617267696e3a313070783b0d0a7d0d0a2e666f6f746572446976207b0d0a096d617267696e3a313070783b0d0a096d696e2d6865696768743a20323070783b0d0a09626f726465723a20317078206461736865642073696c7665723b0d0a096261636b67726f756e643a2075726c282767726164536d616c6c2e6769662729207768697465207265706561742d783b0d0a7d0d0a2e666f6f7465724d617267696e446976207b0d0a096d617267696e3a3570783b0d0a7d, ''),
(24, 'Fat Split', '', '', 0x3c6469762069643d22746f70426f64794d617267696e446976223e0d0a202020202020202020202020202020203c6469762069643d22686561646572446976223e0d0a20202020202020202020202020202020202020203c6469762069643d22686561646572436f6e74656e74446976223e0d0a3c6469762069643d22746f704d656e75446976223e0d0a20202020202020202020202020202020266c743b3f636d732074656d706c6174652e617265612e746f7020636d733f2667743b0d0a2020202020202020202020203c2f6469763e0d0a2020202020202020202020202020202020202020202020203c6469762069643d226c616e6753656c656374223e0d0a20202020202020202020202020202020202020202020202020202020266c743b3f636d732074656d706c6174652e617265612e6c616e6720636d733f2667743b0d0a2020202020202020202020202020202020202020202020203c2f6469763e0d0a3c687220636c6173733d226872436c65617222202f3e0d0a2020202020203c6469763e0d0a20202020202020202020202020202020202020202020202020202020266c743b3f636d7320202074656d706c6174652e617265612e68656164657220636d733f2667743b0d0a2020202020203c2f6469763e0d0a20202020202020202020202020202020202020203c2f6469763e0d0a20202020202020202020202020202020202020203c6469762069643d226865616465724d656e75446976223e0d0a202020202020202020202020202020202020202020202020266c743b3f636d7320202074656d706c6174652e617265612e6d656e7520636d733f2667743b0d0a20202020202020202020202020202020202020203c2f6469763e0d0a202020202020202020202020202020203c2f6469763e0d0a202020202020202020202020202020203c6469762069643d22626f6479446976223e0d0a20202020202020202020202020202020202020203c6469762069643d22626f64794c656674446976223e0d0a2020202020202020202020202020202020202020202020203c64697620636c6173733d226d617267696e446976223e0d0a20202020202020202020202020202020202020202020202020202020266c743b3f636d7320202074656d706c6174652e617265612e6c65667420636d733f2667743b0d0a2020202020202020202020202020202020202020202020203c2f6469763e0d0a20202020202020202020202020202020202020203c2f6469763e0d0a20202020202020202020202020202020202020203c6469762069643d22626f647943656e746572446976223e0d0a2020202020202020202020202020202020202020202020203c64697620636c6173733d226d617267696e446976223e0d0a20202020202020202020202020202020202020202020202020202020266c743b3f636d7320202074656d706c6174652e6d61696e2e6d61696e20636d733f2667743b0d0a2020202020202020202020202020202020202020202020203c2f6469763e0d0a20202020202020202020202020202020202020203c2f6469763e0d0a3c687220636c6173733d226872436c65617222202f3e0d0a202020202020202020202020202020203c2f6469763e0d0a202020202020202020202020202020203c6469762069643d22666f6f746572446976223e0d0a20202020202020202020202020202020202020203c6469762069643d22666f6f7465724d656e75446976223e0d0a202020202020202020202020202020202020202020202020266c743b3f636d7320202074656d706c6174652e617265612e666f6f74657220636d733f2667743b0d0a20202020202020202020202020202020202020203c2f6469763e0d0a202020202020202020202020202020203c2f6469763e0d0a2020202020202020202020203c2f6469763e, 0x626f6479207b0d0a202020206261636b67726f756e643a2075726c28276d61696e4261636b67726f756e642e6a70672729207265706561743b0d0a096d617267696e3a203070783b0d0a2020202070616464696e673a203070783b0d0a7d0d0a23746f70426f64794261636b67726f756e64207b0d0a202020200d0a2020202070616464696e673a203130707820313030707820323070782031303070783b0d0a7d0d0a23746f70426f64794d617267696e446976207b0d0a202020206d617267696e3a2030252035253b0d0a202020206d696e2d77696474683a2038303070783b0d0a7d0d0a23746f704d656e75446976207b0d0a666c6f61743a72696768743b0d0a202020206865696768743a20323570783b0d0a7d0d0a23686561646572446976207b0d0a7d0d0a23686561646572436f6e74656e74446976207b0d0a7d0d0a236865616465724d656e75446976207b0d0a202020200d0a202020206865696768743a20333070783b0d0a7d0d0a23626f6479446976207b0d0a6261636b67726f756e643a2075726c2827626f64794261636b67726f756e642e706e672729207265706561742d783b0d0a2020202070616464696e673a203138707820313070783b0d0a7d0d0a23626f64794c656674446976207b0d0a20202020666c6f61743a206c6566743b0d0a202020206d617267696e3a203070782030707820307078203070783b0d0a202020202f2a2070616464696e673a20313070783b202a2f0d0a202020206d696e2d6865696768743a2033363070783b0d0a2020202077696474683a2032303070783b0d0a202020206261636b67726f756e642d636f6c6f723a77686974653b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a7d0d0a23626f647943656e746572446976207b0d0a202020206d617267696e3a2030707820307078203070782032313070783b200d0a202020202f2a2070616464696e673a2031307078203130707820307078203070783b2a2f0d0a202020206d696e2d6865696768743a2033363070783b0d0a202020206261636b67726f756e642d636f6c6f723a77686974653b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a7d0d0a23626f647943656e746572446976202e6d617267696e446976207b0d0a202020206d617267696e3a20313070783b0d0a7d0d0a23626f647946756c6c446976207b0d0a202020206d617267696e3a203070782030707820307078203070783b200d0a202020206d696e2d6865696768743a2033363070783b0d0a202020206261636b67726f756e642d636f6c6f723a77686974653b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a202020206261636b67726f756e642d636f6c6f723a77686974653b0d0a7d0d0a23626f647946756c6c446976202e6d617267696e446976207b0d0a202020206d617267696e3a20313070783b0d0a7d0d0a23666f6f746572446976207b0d0a202020206d696e2d6865696768743a20333070783b0d0a202020206261636b67726f756e643a20726762283139312c32312c3334293b0d0a7d0d0a23666f6f7465724d656e75446976207b0d0a0d0a7d0d0a0d0a0d0a23636d73426f6479446976207b0d0a202020206d617267696e2d626f74746f6d3a203070783b0d0a7d0d0a0d0a0d0a0d0a2f2a20746f70206d656e752a2f0d0a0d0a23746f704d656e75446976202e7364646d20646976207b0d0a20202020666c6f61743a2072696768743b0d0a7d0d0a23746f704d656e75446976202e7364646d20646976207b0d0a20202020666c6f61743a2072696768743b0d0a7d0d0a23746f704d656e75446976202e7364646d206469762061207b0d0a20202020636f6c6f723a20236666666666663b0d0a096261636b67726f756e643a206e6f6e6520726570656174207363726f6c6c2030203020234246313532323b0d0a7d0d0a23746f704d656e75446976202e7364646d2064697620613a686f766572207b0d0a20202020636f6c6f723a207267622838302c38302c313830293b0d0a7d0d0a0d0a2f2a20686561646572206d656e75202a2f0d0a0d0a236865616465724d656e75446976202e7364646d20646976207b0d0a202020206d617267696e3a203070782030707820357078203570783b0d0a2020202070616464696e673a203270783b0d0a202020206261636b67726f756e643a20726762283231302c3231302c323130293b0d0a7d0d0a236865616465724d656e75446976202e7364646d206469762061207b0d0a20202020636f6c6f723a207267622838302c38302c3830293b0d0a7d0d0a236865616465724d656e75446976202e7364646d2064697620613a686f766572207b0d0a20202020636f6c6f723a207267622838302c38302c313830293b0d0a7d0d0a0d0a2f2a20666f6f746572206d656e75202a2f0d0a0d0a23666f6f7465724d656e75446976202e7364646d20646976207b0d0a202020206d617267696e2d746f703a203270783b0d0a7d0d0a23666f6f7465724d656e75446976202e7364646d20646976207b0d0a20202020666c6f61743a2072696768743b0d0a7d0d0a0d0a2f2a206d656e7520636f6d6d6f6e2a2f0d0a0d0a2e7364646d202e7364646d427574746f6e2061207b0d0a2020202070616464696e673a203070783b0d0a7d0d0a2e7364646d202e7364646d427574746f6e207b0d0a2020202070616464696e673a203070783b0d0a202020206261636b67726f756e643a206e6f6e653b0d0a7d0d0a0d0a2f2a20202a2f0d0a0d0a23626f64794c656674446976202e7364646d20646976207b0d0a20202020666c6f61743a6e6f6e653b0d0a7d0d0a23626f64794c656674446976202e7364646d206469762061207b0d0a20202020746578742d616c69676e3a6c6566743b0d0a7d0d0a0d0a0d0a0d0a2f2a206c616e676167652073656c656374696f6e202a2f0d0a0d0a236c616e6753656c656374207b0d0a20202020666c6f61743a6c6566743b0d0a7d0d0a2e6c616e6753656c6563744c696e6b207b0d0a202020200d0a7d0d0a0d0a, '');

-- --------------------------------------------------------

--
-- Tabellenstruktur fÃ¼r Tabelle `t_templatearea`
--

CREATE TABLE IF NOT EXISTS `t_templatearea` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `pageid` int(10) NOT NULL,
  `type` int(10) NOT NULL,
  `position` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur fÃ¼r Tabelle `t_track`
--

CREATE TABLE IF NOT EXISTS `t_track` (
  `clientip` blob NOT NULL,
  `href` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur fÃ¼r Tabelle `t_users`
--

CREATE TABLE IF NOT EXISTS `t_users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `authkey` varchar(10) DEFAULT NULL,
  `email` varchar(200) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `objectid` int(10) NOT NULL,
  `registerdate` date NOT NULL,
  `birthdate` date NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur fÃ¼r Tabelle `t_vdb_column`
--

CREATE TABLE IF NOT EXISTS `t_vdb_column` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `tableid` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `edittype` int(5) NOT NULL,
  `position` int(5) NOT NULL,
  `refcolumn` int(10) DEFAULT NULL,
  `objectidcolumn` int(10) DEFAULT NULL,
  `description` blob,
  `required` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

--
-- Daten fÃ¼r Tabelle `t_vdb_column`
--

INSERT INTO `t_vdb_column` (`id`, `tableid`, `name`, `edittype`, `position`, `refcolumn`, `objectidcolumn`, `description`, `required`) VALUES
(1, 2, 'Username', 1, 1, 9, 14, '', 0),
(2, 2, 'Firstname', 1, 2, 12, 14, '', 0),
(3, 2, 'Lastname', 1, 3, 13, 14, '', 0),
(4, 2, 'Email', 1, 4, 11, 14, '', 0),
(5, 2, 'Date Of Birth', 7, 5, 16, 14, '', 0),
(6, 2, 'Register Date', 7, 6, 15, 14, '', 0),
(7, 2, 'active', 8, 7, 17, 14, '', 0),
(8, 2, 'registered', 8, 8, NULL, 14, '', 0),
(9, 3, 'username', 1, 9, NULL, NULL, 0x736673646678783132617364, 1),
(10, 3, 'password', 1, 10, NULL, NULL, '', 1),
(11, 3, 'email', 1, 11, NULL, NULL, '', 1),
(12, 3, 'firstname', 1, 12, NULL, NULL, '', 1),
(13, 3, 'lastname', 1, 13, NULL, NULL, '', 1),
(14, 3, 'objectid', 1, 14, NULL, NULL, '', 0),
(15, 3, 'registerdate', 7, 15, NULL, NULL, '', 0),
(16, 3, 'birthdate', 7, 16, NULL, NULL, '', 0),
(17, 3, 'active', 8, 17, NULL, NULL, '', 0),
(37, 9, 'Email', 1, 2, NULL, NULL, '', 0),
(36, 9, 'Name', 1, 1, NULL, NULL, '', 0),
(24, 2, 'Firma', 1, 24, NULL, NULL, '', 0),
(39, 9, 'Subject', 1, 3, NULL, NULL, '', 0),
(38, 9, 'Message', 2, 4, NULL, NULL, '', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur fÃ¼r Tabelle `t_vdb_object`
--

CREATE TABLE IF NOT EXISTS `t_vdb_object` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `tableid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur fÃ¼r Tabelle `t_vdb_table`
--

CREATE TABLE IF NOT EXISTS `t_vdb_table` (
  `physical` int(1) NOT NULL,
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Daten fÃ¼r Tabelle `t_vdb_table`
--

INSERT INTO `t_vdb_table` (`physical`, `id`, `name`) VALUES
(0, 2, 'userAttribs'),
(1, 3, 't_users'),
(0, 4, 'orderAttribs'),
(0, 9, 'Kontakt');

-- --------------------------------------------------------

--
-- Tabellenstruktur fÃ¼r Tabelle `t_vdb_value`
--

CREATE TABLE IF NOT EXISTS `t_vdb_value` (
  `objectid` int(10) NOT NULL,
  `columnid` int(10) NOT NULL,
  `value` blob NOT NULL,
  KEY `objectid` (`objectid`),
  KEY `columnid` (`columnid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur fÃ¼r Tabelle `t_wysiwygpage`
--

CREATE TABLE IF NOT EXISTS `t_wysiwygpage` (
  `id` int(10) unsigned DEFAULT NULL,
  `pageid` int(10) unsigned DEFAULT NULL,
  `lang` varchar(5) NOT NULL,
  `content` blob,
  `title` varchar(100) DEFAULT NULL,
  `area` int(5) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

;
*/ end of sql
?>