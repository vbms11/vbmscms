<?php /* ;

CREATE TABLE IF NOT EXISTS `ajax_chat_bans` (
  `userID` int(11) NOT NULL,
  `userName` varchar(64) COLLATE utf8_bin NOT NULL,
  `dateTime` datetime NOT NULL,
  `ip` varbinary(16) NOT NULL,
  PRIMARY KEY (`userID`),
  KEY `userName` (`userName`),
  KEY `dateTime` (`dateTime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `ajax_chat_invitations`
--

CREATE TABLE IF NOT EXISTS `ajax_chat_invitations` (
  `userID` int(11) NOT NULL,
  `channel` int(11) NOT NULL,
  `dateTime` datetime NOT NULL,
  PRIMARY KEY (`userID`,`channel`),
  KEY `dateTime` (`dateTime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `ajax_chat_messages`
--

CREATE TABLE IF NOT EXISTS `ajax_chat_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `userName` varchar(64) COLLATE utf8_bin NOT NULL,
  `userRole` int(1) NOT NULL,
  `channel` int(11) NOT NULL,
  `dateTime` datetime NOT NULL,
  `ip` varbinary(16) NOT NULL,
  `text` text COLLATE utf8_bin,
  PRIMARY KEY (`id`),
  KEY `message_condition` (`id`,`channel`,`dateTime`),
  KEY `dateTime` (`dateTime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ajax_chat_online`
--

CREATE TABLE IF NOT EXISTS `ajax_chat_online` (
  `userID` int(11) NOT NULL,
  `userName` varchar(64) COLLATE utf8_bin NOT NULL,
  `userRole` int(1) NOT NULL,
  `channel` int(11) NOT NULL,
  `dateTime` datetime NOT NULL,
  `ip` varbinary(16) NOT NULL,
  PRIMARY KEY (`userID`),
  KEY `userName` (`userName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `t_backup`
--

CREATE TABLE IF NOT EXISTS `t_backup` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_cms_customer`
--

CREATE TABLE IF NOT EXISTS `t_cms_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_cms_version`
--

CREATE TABLE IF NOT EXISTS `t_cms_version` (
  `version` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_code`
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
-- Table structure for table `t_comment`
--

CREATE TABLE IF NOT EXISTS `t_comment` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `moduleid` int(10) NOT NULL,
  `name` varchar(200) NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `comment` blob NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_confirm`
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
-- Table structure for table `t_country`
--

CREATE TABLE IF NOT EXISTS `t_country` (
  `geonameid` varchar(20) COLLATE utf8_bin NOT NULL,
  `name` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `t_domain`
--

CREATE TABLE IF NOT EXISTS `t_domain` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `url` varchar(200) NOT NULL,
  `siteid` int(10) NOT NULL,
  `domaintrackerscript` blob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_email`
--

CREATE TABLE IF NOT EXISTS `t_email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(200) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_event`
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
-- Table structure for table `t_forum_post`
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
-- Table structure for table `t_forum_thread`
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
-- Table structure for table `t_forum_topic`
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
-- Table structure for table `t_gallery_category`
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
-- Table structure for table `t_gallery_image`
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
-- Table structure for table `t_gallery_page`
--

CREATE TABLE IF NOT EXISTS `t_gallery_page` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `typeid` int(11) NOT NULL,
  `rootcategory` int(10) NOT NULL,
  `type` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_icon`
--

CREATE TABLE IF NOT EXISTS `t_icon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iconfile` blob NOT NULL,
  `width` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_language`
--

CREATE TABLE IF NOT EXISTS `t_language` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `local` varchar(10) NOT NULL,
  `flag` varchar(100) NOT NULL,
  `active` int(1) NOT NULL,
  `isdefault` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `t_language`
--

INSERT INTO `t_language` (`id`, `code`, `name`, `local`, `flag`, `active`, `isdefault`) VALUES
(1, 'de', 'German', 'de', 'de.gif', 1, 0),
(2, 'it', 'Italian', 'it_en', 'flag_italy.gif', 0, 0),
(3, 'en', 'English', 'en', 'gb.gif', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `t_menu`
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
-- Table structure for table `t_menu_instance`
--

CREATE TABLE IF NOT EXISTS `t_menu_instance` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `siteid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_menu_style`
--

CREATE TABLE IF NOT EXISTS `t_menu_style` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `cssclass` blob NOT NULL,
  `cssstyle` blob NOT NULL,
  `name` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `t_menu_style`
--

INSERT INTO `t_menu_style` (`id`, `cssclass`, `cssstyle`, `name`) VALUES
(1, '', '', 'Plain Menu'),
(4, 0x706c61696e4469764d656e75, 0x2e706c61696e4469764d656e75207b0d0a202020206865696768743a20323070783b0d0a202020206c696e652d6865696768743a20323070783b0d0a20202020666f6e742d7765696768743a626f6c643b0d0a7d0d0a2e706c61696e4469764d656e75202e7364646d207b0d0a20202020666f6e742d73697a653a20313570783b0d0a7d0d0a2e706c61696e4469764d656e75202e7364646d206469762061207b0d0a20202020746578742d6465636f726174696f6e3a206e6f6e653b0d0a2020202070616464696e673a20307078203770783b0d0a202020206d617267696e3a203070783b0d0a20202020636f6c6f723a2077686974653b0d0a7d0d0a2e706c61696e4469764d656e75202e7364646d2064697620612e7364646d53656c6563746564207b0d0a7d0d0a2e706c61696e4469764d656e75202e7364646d2064697620613a686f766572207b0d0a20202020626f726465723a203170782030707820736f6c69642073696c7665723b0d0a7d0d0a2e706c61696e4469764d656e75202e7364646d2064697620646976207b0d0a202020206d696e2d77696474683a2031303070783b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a7d0d0a2e706c61696e4469764d656e75202e7364646d206469762064697620613a686f766572207b0d0a202020206261636b67726f756e642d636f6c6f723a20726762283230302c203230302c20323030293b0d0a20202020626f726465723a203170782030707820736f6c69642073696c7665723b0d0a7d0d0a2e706c61696e4469764d656e75202e7364646d20646976206469762061207b0d0a7d0d0a2e706c61696e4469764d656e75202e7364646d206469762064697620612e7364646d53656c6563746564207b0d0a7d0d0a2e706c61696e4469764d656e75202e7364646d2064697620612e7364646d4669727374207b0d0a2020202070616464696e672d6c6566743a203070783b0d0a20202020626f726465722d6c6566743a20307078206e6f6e653b0d0a7d, 'Main Menu'),
(5, 0x6c6576656c73, 0x2f2a206669727374206c6576656c202a2f0d0a0d0a2e6c6576656c73207b0d0a2020202070616464696e673a2031307078203070782030707820313070783b0d0a7d0d0a2e6c6576656c73202e7364646d207b0d0a20202020666c6f61743a6c6566743b0d0a7d0d0a2e6c6576656c73202e7364646d20646976207b0d0a20202020666c6f61743a6e6f6e653b0d0a7d0d0a2e6c6576656c73202e7364646d206469762061207b0d0a20202020636f6c6f723a20626c61636b3b0d0a20202020746578742d6465636f726174696f6e3a206e6f6e653b0d0a20202020746578742d616c69676e3a206c6566743b0d0a2020202070616464696e673a203570783b0d0a20202020666f6e742d7765696768743a626f6c643b0d0a20202020666f6e742d73697a653a20313470783b0d0a7d0d0a2e6c6576656c73202e7364646d2064697620613a686f766572207b0d0a09746578742d6465636f726174696f6e3a20756e6465726c696e653b0d0a7d0d0a2e6c6576656c73202e7364646d2064697620612e7364646d4669727374207b0d0a20202020626f726465722d6c6566743a20307078206e6f6e653b0d0a7d0d0a2e6c6576656c73202e7364646d20646976202e7364646d53656c6563746564207b0d0a20202020646973706c61793a20626c6f636b3b0d0a20202020636f6c6f723a207265643b0d0a7d0d0a0d0a2f2a207365636f6e64206c6576656c202a2f0d0a0d0a2e6c6576656c73202e7364646d2064697620646976207b0d0a20202020706f736974696f6e3a2072656c61746976653b0d0a202020206261636b67726f756e643a206e6f6e653b0d0a7d0d0a2e6c6576656c73202e7364646d20646976206469762061207b0d0a20202020636f6c6f723a20233030364335353b0d0a20202020666f6e742d73697a653a20313270783b0d0a20202020666f6e742d7765696768743a206e6f726d616c3b0d0a202020206261636b67726f756e643a2075726c28272e2e2f696d672f6c697374655f7a65696368656e2e6769662729206e6f2d7265706561743b0d0a202020206261636b67726f756e642d706f736974696f6e3a2030707820313070783b0d0a202020206d617267696e2d6c6566743a20313070783b0d0a2020202070616464696e672d6c6566743a20313070783b0d0a7d0d0a2e6c6576656c73202e7364646d206469762064697620612e7364646d53656c6563746564207b0d0a20202020666f6e742d7765696768743a20626f6c643b0d0a20202020636f6c6f723a20626c61636b3b0d0a7d0d0a2e6c6576656c73202e7364646d206469762064697620613a686f766572207b0d0a20202020636f6c6f723a20626c61636b3b0d0a20202020746578742d6465636f726174696f6e3a206e6f6e653b0d0a7d0d0a0d0a2f2a207468697264206c6576656c202a2f0d0a0d0a2e6c6576656c73202e7364646d206469762064697620646976207b0d0a20202020706f736974696f6e3a206162736f6c7574653b0d0a202020206261636b67726f756e643a20726762283234302c3234302c323430293b0d0a20202020746f703a3070783b0d0a202020206c6566743a31303070783b0d0a7d0d0a2e6c6576656c73202e7364646d2064697620646976206469762061207b0d0a20202020636f6c6f723a20233030364335353b0d0a20202020666f6e742d73697a653a20313270783b0d0a20202020666f6e742d7765696768743a206e6f726d616c3b0d0a202020206261636b67726f756e643a2075726c28272e2e2f696d672f6c697374655f7a65696368656e2e6769662729206e6f2d7265706561743b0d0a202020206261636b67726f756e642d706f736974696f6e3a2030707820313070783b0d0a202020206d617267696e2d6c6566743a20313070783b0d0a2020202070616464696e672d6c6566743a20313070783b0d0a7d0d0a2e6c6576656c73202e7364646d20646976206469762064697620612e7364646d53656c6563746564207b0d0a20202020666f6e742d7765696768743a20626f6c643b0d0a20202020636f6c6f723a20626c61636b3b0d0a7d0d0a2e6c6576656c73202e7364646d20646976206469762064697620613a686f766572207b0d0a20202020636f6c6f723a20626c61636b3b0d0a20202020746578742d6465636f726174696f6e3a206e6f6e653b0d0a7d, 'Stack Menu'),
(7, 0x746f704469764d656e7520, 0x2e746f704469764d656e75207b0d0a202020206d617267696e2d6c6566743a313070783b0d0a202020206865696768743a323270783b0d0a20202020666f6e743a203131707820417269616c2c73616e732d73657269663b0d0a202020206c696e652d6865696768743a323270783b0d0a7d0d0a2e746f704469764d656e75202e7364646d207b0d0a7d0d0a2e746f704469764d656e75202e7364646d206469762061207b0d0a20202020746578742d6465636f726174696f6e3a206e6f6e653b0d0a2020202070616464696e673a20307078203770783b0d0a202020206d617267696e3a203070783b0d0a20202020666f6e742d7765696768743a6e6f726d616c3b0d0a20202020636f6c6f723a20236666663b0d0a7d0d0a2e746f704469764d656e75202e7364646d2064697620612e7364646d53656c6563746564207b0d0a20202020636f6c6f723a20234646444430303b0d0a7d0d0a2e746f704469764d656e75202e7364646d2064697620613a686f766572207b0d0a20202020636f6c6f723a20234646444430303b0d0a7d0d0a2e746f704469764d656e75202e7364646d2064697620646976207b0d0a202020206261636b67726f756e642d636f6c6f723a20726762283235302c3235302c323530293b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a2020202070616464696e673a203470783b0d0a7d0d0a2e746f704469764d656e75202e7364646d206469762064697620613a686f766572207b0d0a202020206261636b67726f756e642d636f6c6f723a20726762283234302c3234302c323430293b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a2020202070616464696e673a203370782033707820337078203470783b0d0a7d0d0a2e746f704469764d656e75202e7364646d20646976206469762061207b0d0a202020206261636b67726f756e642d636f6c6f723a20726762283235302c3235302c323530293b0d0a2020202070616464696e673a203470783b0d0a7d0d0a2e746f704469764d656e75202e7364646d206469762064697620612e7364646d53656c6563746564207b0d0a20202020666f6e742d7765696768743a20626f6c643b0d0a7d0d0a2e746f704469764d656e75202e7364646d2064697620612e7364646d4669727374207b0d0a2020202070616464696e672d6c6566743a203070783b0d0a20202020626f726465722d6c6566743a20307078206e6f6e653b0d0a7d, 'Top Menu'),
(8, 0x626f74746f6d4469764d656e75, 0x2e626f74746f6d4469764d656e75207b0d0a202020206d617267696e2d6c6566743a363070783b0d0a202020206865696768743a343870783b0d0a20202020666f6e743a203131707820417269616c2c73616e732d73657269663b0d0a202020206c696e652d6865696768743a343870783b0d0a7d0d0a2e626f74746f6d4469764d656e75202e7364646d207b0d0a7d0d0a2e626f74746f6d4469764d656e75202e7364646d206469762061207b0d0a20202020746578742d6465636f726174696f6e3a206e6f6e653b0d0a2020202070616464696e673a20307078203770783b0d0a202020206d617267696e3a203070783b0d0a20202020666f6e742d7765696768743a6e6f726d616c3b0d0a20202020636f6c6f723a20234646463b0d0a7d0d0a2e626f74746f6d4469764d656e75202e7364646d2064697620612e7364646d53656c6563746564207b0d0a20202020636f6c6f723a20234646444430303b0d0a7d0d0a2e626f74746f6d4469764d656e75202e7364646d2064697620613a686f766572207b0d0a20202020636f6c6f723a20234646444430303b0d0a7d0d0a2e626f74746f6d4469764d656e75202e7364646d2064697620646976207b0d0a202020206261636b67726f756e642d636f6c6f723a20726762283235302c3235302c323530293b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a2020202070616464696e673a203470783b0d0a7d0d0a2e626f74746f6d4469764d656e75202e7364646d206469762064697620613a686f766572207b0d0a202020206261636b67726f756e642d636f6c6f723a20726762283234302c3234302c323430293b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a2020202070616464696e673a203370782033707820337078203470783b0d0a7d0d0a2e626f74746f6d4469764d656e75202e7364646d20646976206469762061207b0d0a202020206261636b67726f756e642d636f6c6f723a20726762283235302c3235302c323530293b0d0a2020202070616464696e673a203470783b0d0a7d0d0a2e626f74746f6d4469764d656e75202e7364646d206469762064697620612e7364646d53656c6563746564207b0d0a20202020666f6e742d7765696768743a20626f6c643b0d0a20202020636f6c6f723a626c61636b3b0d0a7d0d0a2e626f74746f6d4469764d656e75202e7364646d2064697620612e7364646d4669727374207b0d0a2020202070616464696e672d6c6566743a203070783b0d0a20202020626f726465722d6c6566743a20307078206e6f6e653b0d0a7d, 'Bottom Menu');

-- --------------------------------------------------------

--
-- Table structure for table `t_module`
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=102 ;

--
-- Dumping data for table `t_module`
--

INSERT INTO `t_module` (`id`, `name`, `sysname`, `include`, `description`, `interface`, `inmenu`, `category`, `position`, `static`) VALUES
(2, 'Wysiwyg Editor', '', 'modules/editor/wysiwygPageView.php', '', 'WysiwygPageView', 1, 1, 0, 0),
(13, 'Login', 'login', 'modules/users/loginModule.php', 0x616c6c6f777320796f7520746f20656e74657220616e6420657869742061646d696e206d6f6465, 'LoginModule', 1, 4, 0, 1),
(16, 'Newsletters', 'adminNewsletter', 'modules/newsletter/newsletterModule.php', '', 'NewsletterModule', 1, 3, 0, 1),
(17, 'Produkteliste', '', 'modules/products/productsPageView.php', '', 'ProductsPageView', 1, 1, 0, 0),
(62, 'Subscribe to role', 'subscribe', 'modules/users/registerRoleModule.php', NULL, 'RegisterRoleModule', 1, 0, 0, 1),
(24, 'Benutser Verwaltung', 'adminUsers', 'modules/users/usersPageView.php', '', 'UsersPageView', 1, 4, 0, 1),
(21, 'Sitemap', '', 'modules/sitemap/sitemapPageView.php', '', 'SitemapPageView', 1, 1, 0, 0),
(22, 'Suche', 'search', 'modules/search/searchPageView.php', '', 'SearchPageView', 1, 4, 0, 1),
(45, 'Insert Module', 'insertModule', 'modules/admin/insertModuleView.php', '', 'InsertModuleView', 0, 4, 0, 1),
(25, 'Forum', '', 'modules/forum/forumPageView.php', '', 'ForumPageView', 1, 2, 0, 0),
(26, 'Chat', 'chat', 'modules/chat/chatModule.php', '', 'ChatModule', 1, 2, 0, 1),
(27, 'Comments', '', 'modules/comments/commentsView.php', '', 'CommentsView', 1, 2, 0, 0),
(37, 'Database backup', '', 'modules/admin/backupView.php', '', 'BackupView', 1, 4, 0, 0),
(29, 'Register', 'register', 'modules/users/registerModule.php', '', 'RegisterModule', 1, 4, 0, 1),
(30, 'Profile', '', 'modules/users/profilePageView.php', '', 'ProfilePageView', 1, 4, 0, 0),
(32, 'Role Administration', 'adminRoles', 'modules/admin/rolesView.php', '', 'RolesView', 1, 4, 0, 1),
(33, 'Gallery', '', 'modules/gallery/galleryView.php', '', 'GalleryView', 1, 1, 0, 0),
(34, 'Messages', '', 'modules/forum/messagePageView.php', '', 'MessagePageView', 1, 2, 0, 0),
(35, 'Events Callender', '', 'modules/events/callenderView.php', '', 'CallenderView', 1, 1, 0, 0),
(36, 'Events List', '', 'modules/events/eventsList.php', '', 'EventsListView', 1, 1, 0, 0),
(38, 'Templates Manager', 'adminTemplates', 'modules/admin/adminTemplatesModule.php', '', 'AdminTemplatesModule', 1, 4, 0, 1),
(39, 'Modules Manager', 'adminModules', 'modules/admin/adminModulesModule.php', '', 'AdminModulesModule', 1, 4, 0, 1),
(40, 'Domains Manager', 'adminDomains', 'modules/admin/adminDomainsModule.php', '', 'AdminDomainsModule', 1, 4, 0, 1),
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
(55, 'File Manager', '', 'modules/admin/filesystemView.php', NULL, 'FilesystemView', 1, 4, 1, 0),
(56, 'Rechnungen', '', 'modules/products/shopBillsView.php', NULL, 'ShopBillsView', 1, 4, 1, 0),
(57, 'Full Screen Callendar', '', 'modules/events/fullCallendarView.php', NULL, 'FullCallendarView', 1, 1, 0, 0),
(58, 'Events Table', 'eventsTable', 'modules/events/eventsTable.php', NULL, 'EventsTableView', 1, 0, 0, 1),
(59, 'Plain Menu', 'menu', 'modules/admin/menuModule.php', NULL, 'MenuView', 1, 0, 0, 0),
(60, 'Page Config', 'pageConfig', 'modules/admin/pageConfigModule.php', NULL, 'PageConfigModule', 0, 0, 0, 1),
(61, 'Confirm', 'confirm', 'modules/admin/confirmModuleView.php', NULL, 'ConfirmView', 0, 0, 0, 1),
(63, 'Languages', '', 'modules/admin/languagesModule.php', NULL, 'LanguagesModule', 1, 0, 0, 0),
(64, 'Search Box', '', 'modules/search/searchBoxModule.php', NULL, 'SearchBoxModule', 1, 0, 0, 0),
(65, 'Product Groups', 'productGroups', 'modules/products/productGroupsModule.php', '', 'ProductGroupsModule', 1, 0, 0, 1),
(66, 'Payment', 'payment', 'modules/products/paymentModule.php', '', 'PaymentModule', 0, 0, 0, 1),
(67, 'Social Networks', '', 'modules/social/socialModule.php', '', 'SocialModule', 1, 0, 0, 0),
(68, 'Menu Styles', 'menuStyles', 'modules/admin/menuStylesModule.php', NULL, 'MenuStylesModule', 0, 0, 0, 1),
(69, 'Admin Menu', 'adminMenu', 'modules/admin/adminMenuModule.php', NULL, 'AdminMenuModule', 0, 0, 0, 1),
(70, 'Admin Pages', 'adminPages', 'modules/admin/adminPagesModule.php', NULL, 'AdminPagesModule', 0, 0, 0, 1),
(71, 'Admin Menus', 'adminMenus', 'modules/admin/adminMenusModule.php', NULL, 'AdminMenusModule', 0, 0, 0, 1),
(72, 'Sites Manager', 'adminSites', 'modules/admin/adminSitesModule.php', NULL, 'AdminSitesModule', 0, 0, 0, 1),
(73, 'Admin Messages', 'adminMessages', 'modules/admin/adminMessagesModule.php', NULL, 'AdminMessagesModule', 0, 0, 0, 1),
(74, 'Admin Package', 'adminPackage', 'modules/admin/adminPackageModule.php', NULL, 'AdminPackageModule', 0, 0, 0, 1),
(75, 'Admin Translations', 'adminTranslations', 'modules/admin/adminTranslationsModule.php', NULL, 'AdminTranslationsModule', 0, 0, 0, 1),
(76, 'Statistics', 'statistics', 'modules/statistics/statisticsModule.php', NULL, 'StatisticsModule', 0, 0, 0, 1),
(77, 'unregistered', 'unregistered', 'modules/admin/unregisteredModule.php', NULL, 'UnregisteredModule', 0, 0, 0, 1),
(78, 'Email List', 'emailList', 'modules/newsletter/emailListModule.php', NULL, 'EmailListModule', 1, 0, 0, 1),
(80, 'Email List Send Module', 'emailListSend', 'modules/newsletter/emailListSendModule.php', NULL, 'EmailListSendModule', 1, 0, 0, 1),
(81, 'ukash paypal', 'ukashpaypal', 'modules/ukashpaypal/ukashpaypalModule.php', NULL, 'UkashPaypalModule', 1, 0, 0, 1),
(82, 'User Profile', 'userProfile', 'modules/users/userProfileModule.php', NULL, 'UserProfileModule', 1, 0, 0, 1),
(83, 'User Details', 'userDetails', 'modules/users/userDetailsModule.php', NULL, 'UserDetailsModule', 1, 0, 0, 1),
(84, 'User Gallery', 'userGallery', 'modules/users/userGalleryModule.php', NULL, 'UserGalleryModule', 1, 0, 0, 1),
(85, 'User Wall', 'userWall', 'modules/users/userWallModule.php', NULL, 'UserWallModule', 1, 0, 0, 1),
(86, 'User Message', 'userMessage', 'modules/users/userMessageModule.php', NULL, 'UserMessageModule', 1, 0, 0, 1),
(87, 'User Search', 'userSearch', 'modules/users/userSearchModule.php', NULL, 'UserSearchModule', 1, 0, 0, 1),
(88, 'Facebook Comments', 'facebookComments', 'modules/social/facebookCommentsModule.php', NULL, 'FacebookCommentsModule', 1, 0, 0, 0),
(89, 'Facebook Like Button', 'facebookLikeButton', 'modules/social/facebookLikeButtonModule.php', NULL, 'FacebookLikeButtonModule', 1, 0, 0, 0),
(92, 'User Friend List', 'userFriend', 'modules/users/userFriendModule.php', NULL, 'UserFriendModule', 1, 0, 0, 1),
(91, 'User Search Results', 'userSearchResult', 'modules/users/userSearchResultModule.php', 0x30, 'UserSearchResultModule', 1, 0, 0, 1),
(93, 'User Friend Requests', 'userFriendRequest', 'modules/users/userFriendRequestModule.php', NULL, 'UserFriendRequestModule', 1, 0, 0, 1),
(94, 'User Search New Users', 'userSearchNew', 'modules/users/userSearchNewUsersModule.php', NULL, 'UserSearchNewUsersModule', 1, 0, 0, 1),
(95, 'User Search Recent Active', 'userSearchActive', 'modules/users/userSearchActiveUsersModule.php', NULL, 'UserSearchActiveUsersModule', 1, 0, 0, 1),
(96, 'User Profile Image', 'userProfileImage', 'modules/users/userProfileImageModule.php', NULL, 'UserProfileImageModule', 1, 0, 0, 1),
(97, 'Admin Social Notifications', 'adminSocialNotifications', 'modules/admin/adminSocialNotificationsModule.php', NULL, 'AdminSocialNotificationsModule', 0, 0, 0, 1),
(98, 'User Info', 'userInfo', 'modules/users/userInfoModule.php', NULL, 'UserInfoModule', 1, 0, 0, 1),
(99, 'User Settings', 'userSettings', 'modules/users/userSettingsModule.php', NULL, 'UserSettingsModule', 1, 0, 0, 1),
(100, 'Pinboard Map', 'pinboardMap', 'modules/pinboard/pinboardMapModule.php', NULL, 'PinboardMapModule', 1, 0, 0, 1),
(101, 'Pinboard', 'pinboard', 'modules/pinboard/pinboardModule.php', NULL, 'PinboardModule', 1, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `t_module_category`
--

CREATE TABLE IF NOT EXISTS `t_module_category` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `position` int(10) NOT NULL,
  `name` varchar(200) COLLATE latin1_german2_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_module_instance`
--

CREATE TABLE IF NOT EXISTS `t_module_instance` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `moduleid` int(10) NOT NULL,
  PRIMARY KEY (`id`,`moduleid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_module_instance_params`
--

CREATE TABLE IF NOT EXISTS `t_module_instance_params` (
  `instanceid` int(10) DEFAULT NULL,
  `moduleid` int(11) DEFAULT NULL,
  `name` varchar(100) COLLATE latin1_german2_ci NOT NULL,
  `value` blob NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_module_roles`
--

CREATE TABLE IF NOT EXISTS `t_module_roles` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `customrole` int(10) NOT NULL,
  `modulerole` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2167 ;

--
-- Dumping data for table `t_module_roles`
--

INSERT INTO `t_module_roles` (`id`, `customrole`, `modulerole`) VALUES
(1787, 7, 'products.view'),
(1788, 7, 'forum.view'),
(1789, 7, 'comment.post'),
(1790, 7, 'gallery.view'),
(1791, 7, 'shop.basket.view'),
(1792, 7, 'shop.basket.details.edit'),
(1793, 7, 'user.profile.view'),
(1794, 7, 'user.search.view'),
(1977, 8, 'forum.thread.create'),
(1978, 8, 'forum.view'),
(1979, 8, 'forum.thread.post'),
(1980, 8, 'chat.user'),
(1981, 8, 'chat.view'),
(1982, 8, 'comment.post'),
(1983, 8, 'gallery.view'),
(1984, 8, 'gallery.owner'),
(1985, 8, 'message.inbox'),
(1986, 8, 'events.callender'),
(1987, 8, 'events.list'),
(1988, 8, 'shop.basket.view'),
(1989, 8, 'shop.basket.details.edit'),
(1990, 8, 'user.profile.view'),
(1991, 8, 'user.profile.owner'),
(1992, 8, 'user.search.view'),
(1993, 8, 'user.friend.view'),
(1994, 8, 'user.friendRequest.view'),
(1995, 8, 'user.image.view'),
(2080, 10, 'wysiwyg.edit'),
(2081, 10, 'login.edit'),
(2082, 10, 'newsletter.edit'),
(2083, 10, 'newsletter.send'),
(2084, 10, 'products.edit'),
(2085, 10, 'products.view'),
(2086, 10, 'roles.register.edit'),
(2087, 10, 'users.edit'),
(2088, 10, 'sitemap.edit'),
(2089, 10, 'modules.insert'),
(2090, 10, 'forum.topic.create'),
(2091, 10, 'forum.thread.create'),
(2092, 10, 'forum.view'),
(2093, 10, 'forum.admin'),
(2094, 10, 'forum.moderator'),
(2095, 10, 'forum.thread.post'),
(2096, 10, 'chat.edit'),
(2097, 10, 'chat.view'),
(2098, 10, 'comment.post'),
(2099, 10, 'comment.edit'),
(2100, 10, 'comment.delete'),
(2101, 10, 'comment.show.email'),
(2102, 10, 'backup.create'),
(2103, 10, 'backup.load'),
(2104, 10, 'backup.delete'),
(2105, 10, 'users.register.edit'),
(2106, 10, 'user.info.edit'),
(2107, 10, 'user.info.admin'),
(2108, 10, 'user.info.owner'),
(2109, 10, 'admin.roles.edit'),
(2110, 10, 'gallery.edit'),
(2111, 10, 'gallery.view'),
(2112, 10, 'gallery.owner'),
(2113, 10, 'message.inbox'),
(2114, 10, 'events.callender'),
(2115, 10, 'events.list'),
(2116, 10, 'events.edit'),
(2117, 10, 'template.edit'),
(2118, 10, 'template.view'),
(2119, 10, 'domains.edit'),
(2120, 10, 'domains.view'),
(2121, 10, 'orders.edit'),
(2122, 10, 'orders.view'),
(2123, 10, 'orders.all'),
(2124, 10, 'orders.confirm'),
(2125, 10, 'orders.finnish'),
(2126, 10, 'dm.tables.config'),
(2127, 10, 'dm.forms.edit'),
(2128, 10, 'shop.basket.view'),
(2129, 10, 'shop.basket.status.edit'),
(2130, 10, 'shop.basket.edit'),
(2131, 10, 'shop.basket.details.view'),
(2132, 10, 'shop.basket.details.edit'),
(2133, 10, 'slideshow.edit'),
(2134, 10, 'filesystem.all'),
(2135, 10, 'filesystem.user'),
(2136, 10, 'filesystem.www'),
(2137, 10, 'filesystem.edit'),
(2138, 10, 'events.users.all'),
(2139, 10, 'menu.edit'),
(2140, 10, 'pages.editmenu'),
(2141, 10, 'pages.edit'),
(2142, 10, 'payment.edit'),
(2143, 10, 'social.edit'),
(2144, 10, 'admin.edit'),
(2145, 10, 'site.edit'),
(2146, 10, 'site.view'),
(2147, 10, 'translations.edit'),
(2148, 10, 'emailList.edit'),
(2149, 10, 'emailSent.edit'),
(2150, 10, 'ukash.edit'),
(2151, 10, 'user.profile.edit'),
(2152, 10, 'user.profile.view'),
(2153, 10, 'user.profile.owner'),
(2154, 10, 'message.edit'),
(2155, 10, 'user.search.edit'),
(2156, 10, 'user.search.view'),
(2157, 10, 'user.friend.edit'),
(2158, 10, 'user.friend.view'),
(2159, 10, 'user.friendRequest.edit'),
(2160, 10, 'user.friendRequest.view'),
(2161, 10, 'user.image.edit'),
(2162, 10, 'user.image.view'),
(2163, 10, 'adminSocialNotifications.edit'),
(2164, 10, 'user.profile.privateDetails'),
(2165, 10, 'pinboardMap.edit'),
(2166, 10, 'pinboardMap.create');

-- --------------------------------------------------------

--
-- Table structure for table `t_newsletter`
--

CREATE TABLE IF NOT EXISTS `t_newsletter` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `text` blob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `t_newsletter`
--

INSERT INTO `t_newsletter` (`id`, `name`, `text`) VALUES
(1, 'teste', 0x746573617465736174657374657374);

-- --------------------------------------------------------

--
-- Table structure for table `t_newsletter_email`
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
-- Table structure for table `t_newsletter_emailgroup`
--

CREATE TABLE IF NOT EXISTS `t_newsletter_emailgroup` (
  `emailid` int(10) NOT NULL AUTO_INCREMENT,
  `roleid` int(50) NOT NULL,
  PRIMARY KEY (`emailid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_order`
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
  `paymethod` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_order_attribute`
--

CREATE TABLE IF NOT EXISTS `t_order_attribute` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` blob NOT NULL,
  `value` blob NOT NULL,
  `orderid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_order_product`
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
-- Table structure for table `t_page`
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
  `pagetrackerscript` blob,
  `modifydate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_page_roles`
--

CREATE TABLE IF NOT EXISTS `t_page_roles` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `roleid` int(10) NOT NULL,
  `pageid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_pinboard`
--

CREATE TABLE IF NOT EXISTS `t_pinboard` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE latin1_german1_ci NOT NULL,
  `description` blob NOT NULL,
  `lat` double NOT NULL,
  `lng` double NOT NULL,
  `userid` int(11) NOT NULL,
  `iconid` int(11) NOT NULL,
  `createdate` datetime NOT NULL,
  `updatedate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_pinboard_note`
--

CREATE TABLE IF NOT EXISTS `t_pinboard_note` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `typeid` int(11) NOT NULL,
  `message` int(11) NOT NULL,
  `pinboardid` int(11) NOT NULL,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `createdate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_product`
--

CREATE TABLE IF NOT EXISTS `t_product` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `img` varchar(50) NOT NULL,
  `galleryid` int(10) DEFAULT NULL,
  `textcode` int(10) NOT NULL,
  `shorttextcode` blob NOT NULL,
  `titelcode` int(10) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `shipping` decimal(10,2) NOT NULL,
  `weight` decimal(10,2) NOT NULL,
  `groupid` int(10) NOT NULL,
  `position` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `minimum` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_product_group`
--

CREATE TABLE IF NOT EXISTS `t_product_group` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `namecode` int(10) NOT NULL,
  `parent` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_product_group_module`
--

CREATE TABLE IF NOT EXISTS `t_product_group_module` (
  `moduleid` int(10) NOT NULL,
  `groupid` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_roles`
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
-- Table structure for table `t_roles_custom`
--

CREATE TABLE IF NOT EXISTS `t_roles_custom` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `system` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `t_roles_custom`
--

INSERT INTO `t_roles_custom` (`id`, `name`, `system`) VALUES
(7, 'guest', 1),
(8, 'user', 1),
(9, 'moderator', 1),
(10, 'admin', 1),
(13, 'newsletter', 1);

-- --------------------------------------------------------

--
-- Table structure for table `t_session`
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

-- --------------------------------------------------------

--
-- Table structure for table `t_site`
--

CREATE TABLE IF NOT EXISTS `t_site` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `description` blob NOT NULL,
  `sitetrackerscript` blob,
  `cmscustomerid` int(11) DEFAULT NULL,
  `piwikid` int(11) NOT NULL,
  `facebookappid` blob NOT NULL,
  `facebooksecret` blob NOT NULL,
  `googleclientid` blob NOT NULL,
  `googleclientsecret` blob NOT NULL,
  `twitterkey` blob NOT NULL,
  `twittersecret` blob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_site_module`
--

CREATE TABLE IF NOT EXISTS `t_site_module` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `siteid` int(10) NOT NULL,
  `moduleid` varchar(10) COLLATE latin1_german2_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_site_template`
--

CREATE TABLE IF NOT EXISTS `t_site_template` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `siteid` int(10) NOT NULL,
  `templateid` int(10) NOT NULL,
  `main` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_site_users`
--

CREATE TABLE IF NOT EXISTS `t_site_users` (
  `siteid` int(11) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_social_notifications`
--

CREATE TABLE IF NOT EXISTS `t_social_notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `siteid` int(11) NOT NULL,
  `friend_request` blob NOT NULL,
  `friend_confirmed` blob NOT NULL,
  `wall_post` blob NOT NULL,
  `wall_reply` blob NOT NULL,
  `message_received` blob NOT NULL,
  `sender_email` blob NOT NULL,
  `friend_request_title` blob NOT NULL,
  `friend_confirmed_title` blob NOT NULL,
  `wall_post_title` blob NOT NULL,
  `wall_reply_title` blob NOT NULL,
  `message_received_title` blob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- Dumping data for table `t_social_notifications`
--

INSERT INTO `t_social_notifications` (`id`, `siteid`, `friend_request`, `friend_confirmed`, `wall_post`, `wall_reply`, `message_received`, `sender_email`, `friend_request_title`, `friend_confirmed_title`, `wall_post_title`, `wall_reply_title`, `message_received_title`) VALUES
(1, 1, 0x3c64697620636c6173733d226d657373616765436f6e7461696e6572223e0d0a20202020202020203c68333e467269656e6420526571756573743c2f68333e0d0a20202020202020203c703e0d0a20202020202020202020202048692025647374557365726e616d65252c0d0a2020202020202020202020203c6272202f3e0d0a2020202020202020202020203c6120687265663d22257372635573657250726f66696c654c696e6b25223e25737263557365726e616d65252028257372635573657241676525293c2f613e200d0a20202020202020202020202066726f6d20257372635573657243697479252c206861732073656e7420796f75206120667269656e642072657175657374210d0a20202020202020203c2f703e0d0a20202020202020203c703e0d0a2020202020202020202020203c6120687265663d2225636f6e6669726d4c696e6b25223e436f6e6669726d20467269656e6420526571756573743c2f613e0d0a20202020202020203c2f703e0d0a20202020202020203c7020636c6173733d22666f6f746572223e0d0a202020202020202020202020596f752061726520726563656976696e67207468697320656d61696c206265636175736520796f75206172652061207265676973746572642075736572206f66200d0a2020202020202020202020203c6120687265663d22256170706c69636174696f6e4c696e6b25223e6f6e6c696e6534646174696e672e6e65743c2f613e200d0a2020202020202020202020206f6e65206f6620746865206f6e6c7920746f74616c792066726565206f6e6c696e6520646174696e67206e6574776f726b732e0d0a20202020202020203c2f703e0d0a202020203c2f6469763e, 0x3c64697620636c6173733d226d657373616765436f6e7461696e6572223e0d0a20202020202020203c68333e467269656e6420526571756573742041636365707465643c2f68333e0d0a20202020202020203c703e0d0a20202020202020202020202048692025647374557365726e616d65252c0d0a2020202020202020202020203c6272202f3e0d0a2020202020202020202020203c6120687265663d22257372635573657250726f66696c654c696e6b25223e25737263557365726e616d65252028257372635573657241676525293c2f613e200d0a20202020202020202020202066726f6d20257372635573657243697479252c2068617320616363657074656420796f757220667269656e642072657175657374210d0a20202020202020203c2f703e0d0a20202020202020203c703e0d0a2020202020202020202020203c6120687265663d2225636f6e6669726d4c696e6b25223e566965772025737263557365726e616d652527732070726f66696c653c2f613e0d0a20202020202020203c2f703e0d0a20202020202020203c7020636c6173733d22666f6f746572223e0d0a202020202020202020202020596f752061726520726563656976696e67207468697320656d61696c206265636175736520796f75206172652061207265676973746572642075736572206f66200d0a2020202020202020202020203c6120687265663d22256170706c69636174696f6e4c696e6b25223e6f6e6c696e6534646174696e672e6e65743c2f613e200d0a2020202020202020202020206f6e65206f6620746865206f6e6c7920746f74616c792066726565206f6e6c696e6520646174696e67206e6574776f726b732e0d0a20202020202020203c2f703e0d0a202020203c2f6469763e, 0x3c64697620636c6173733d226d657373616765436f6e7461696e6572223e0d0a20202020202020203c68333e57616c6c204d6573736167653c2f68333e0d0a20202020202020203c703e0d0a20202020202020202020202048692025647374557365726e616d65252c0d0a2020202020202020202020203c6272202f3e0d0a2020202020202020202020203c6120687265663d22257372635573657250726f66696c654c696e6b25223e25737263557365726e616d65252028257372635573657241676525293c2f613e200d0a20202020202020202020202066726f6d202573726355736572436f756e747279252068617320706f737465642061206d657373616765206f6e20796f75722077616c6c2e0d0a20202020202020203c2f703e0d0a20202020202020203c703e0d0a2020202020202020202020203c6120687265663d22256d6573736167654c696e6b25223e56696577204d6573736167653c2f613e0d0a20202020202020203c2f703e0d0a20202020202020203c7020636c6173733d22666f6f746572223e0d0a202020202020202020202020596f752061726520726563656976696e67207468697320656d61696c206265636175736520796f75206172652061207265676973746572642075736572206f66200d0a2020202020202020202020203c6120687265663d22256170706c69636174696f6e4c696e6b25223e6f6e6c696e6534646174696e672e6e65743c2f613e200d0a2020202020202020202020206f6e65206f6620746865206f6e6c7920746f74616c792066726565206f6e6c696e6520646174696e67206e6574776f726b732e0d0a20202020202020203c2f703e0d0a202020203c2f6469763e, 0x3c64697620636c6173733d226d657373616765436f6e7461696e6572223e0d0a20202020202020203c68333e57616c6c204d657373616765205265706c793c2f68333e0d0a20202020202020203c703e0d0a20202020202020202020202048692025647374557365726e616d65252c0d0a2020202020202020202020203c6272202f3e0d0a2020202020202020202020203c6120687265663d22257372635573657250726f66696c654c696e6b25223e25737263557365726e616d65252028257372635573657241676525293c2f613e200d0a20202020202020202020202066726f6d202573726355736572436f756e7472792520686173207265706c69656420746f2061206d657373616765206f6e20796f75722077616c6c2e0d0a20202020202020203c2f703e0d0a20202020202020203c703e0d0a2020202020202020202020203c6120687265663d22256d6573736167654c696e6b25223e56696577204d6573736167653c2f613e0d0a20202020202020203c2f703e0d0a20202020202020203c7020636c6173733d22666f6f746572223e0d0a202020202020202020202020596f752061726520726563656976696e67207468697320656d61696c206265636175736520796f75206172652061207265676973746572642075736572206f66200d0a2020202020202020202020203c6120687265663d22256170706c69636174696f6e4c696e6b25223e6f6e6c696e6534646174696e672e6e65743c2f613e200d0a2020202020202020202020206f6e65206f6620746865206f6e6c7920746f74616c792066726565206f6e6c696e6520646174696e67206e6574776f726b732e0d0a20202020202020203c2f703e0d0a202020203c2f6469763e, 0x3c64697620636c6173733d226d657373616765436f6e7461696e6572223e0d0a20202020202020203c68333e4d6573736167652052656365697665643c2f68333e0d0a20202020202020203c703e0d0a20202020202020202020202048692025647374557365726e616d65252c0d0a2020202020202020202020203c6272202f3e0d0a2020202020202020202020203c6120687265663d22257372635573657250726f66696c654c696e6b25223e25737263557365726e616d65252028257372635573657241676525293c2f613e200d0a20202020202020202020202066726f6d202573726355736572436f756e74727925206861732073656e7420796f752061206d6573736167652e0d0a20202020202020203c2f703e0d0a20202020202020203c703e0d0a2020202020202020202020203c6120687265663d22256d6573736167654c696e6b25223e56696577204d6573736167653c2f613e0d0a20202020202020203c2f703e0d0a20202020202020203c7020636c6173733d22666f6f746572223e0d0a202020202020202020202020596f752061726520726563656976696e67207468697320656d61696c206265636175736520796f75206172652061207265676973746572642075736572206f66200d0a2020202020202020202020203c6120687265663d22256170706c69636174696f6e4c696e6b25223e6f6e6c696e6534646174696e672e6e65743c2f613e200d0a2020202020202020202020206f6e65206f6620746865206f6e6c7920746f74616c792066726565206f6e6c696e6520646174696e67206e6574776f726b732e0d0a20202020202020203c2f703e0d0a202020203c2f6469763e, 0x6e6f2d7265706c79406f6e6c696e6534646174696e672e6e6574, 0x25737263557365726e616d65252028257372635573657241676525292077616e747320746f20626520796f757220667269656e64, 0x25737263557365726e616d65252028257372635573657241676525292068617320636f6e6669726d656420796f757220667269656e642072657175657374, 0x25737263557365726e616d652520282573726355736572416765252920706f73746564206f6e20796f75722077616c6c, 0x25737263557365726e616d6525202825737263557365724167652529207265706c69656420746f20796f75722077616c6c20706f7374, 0x25737263557365726e616d65252028257372635573657241676525292073656e7420796f752061206d657373616765);

-- --------------------------------------------------------

--
-- Table structure for table `t_template`
--

CREATE TABLE IF NOT EXISTS `t_template` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `template` varchar(100) NOT NULL,
  `interface` varchar(100) NOT NULL,
  `html` blob,
  `css` blob,
  `js` blob,
  `main` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `t_template`
--

INSERT INTO `t_template` (`id`, `name`, `template`, `interface`, `html`, `css`, `js`, `main`) VALUES
(2, 'Docpanel Demo Template', '', '', 0x3c64697620636c6173733d2263656e746572486f6c6465722063656e7465724c6566744d617267696e2063656e74657252696768744d617267696e223e0d0a2020266c743b3f636d732074656d706c6174652e6d61696e2e63656e74657220636d733f2667743b0d0a3c2f6469763e0d0a3c64697620636c6173733d226c656674486f6c646572223e0d0a2020266c743b3f636d732074656d706c6174652e617265612e6c65667420636d733f2667743b0d0a3c2f6469763e0d0a3c64697620636c6173733d227269676874486f6c646572223e0d0a2020266c743b3f636d732074656d706c6174652e617265612e726967687420636d733f2667743b0d0a3c2f6469763e0d0a3c64697620636c6173733d22736561726368486f6c646572223e0d0a2020266c743b3f636d732074656d706c6174652e617265612e73656172636820636d733f2667743b0d0a3c2f6469763e0d0a3c64697620636c6173733d22746f704d656e75486f6c646572223e0d0a2020266c743b3f636d732074656d706c6174652e6d656e752e746f704d656e7520636d733f2667743b0d0a3c2f6469763e0d0a3c64697620636c6173733d22626f74746f6d4d656e75486f6c646572223e0d0a2020266c743b3f636d732074656d706c6174652e6d656e752e666f6f7465724d656e7520636d733f2667743b0d0a3c2f6469763e0d0a3c64697620636c6173733d22674d6170486f6c646572223e3c2f6469763e0d0a3c64697620636c6173733d226d6170486f6c646572223e0d0a2020266c743b3f636d732074656d706c6174652e6d6f64756c652e7374617469632e70696e626f6172644d61702e6d617020636d733f2667743b0d0a3c2f6469763e, 0x626f6479207b0d0a096261636b67726f756e642d636f6c6f723a20726762283230302c3230302c323030293b0d0a7d0d0a2e736561726368486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20333570783b0d0a096c6566743a20353070783b0d0a0977696474683a2032303070783b0d0a096865696768743a20343070783b0d0a096261636b67726f756e642d636f6c6f723a20626c61636b3b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2032303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a7d0d0a2e6d61696e4d656e75486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20333570783b0d0a0972696768743a20353070783b0d0a0977696474683a2033303070783b0d0a096865696768743a20343070783b0d0a096261636b67726f756e642d636f6c6f723a20626c61636b3b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2032303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a0d0a7d0d0a2e6d6170486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a203070783b0d0a096c6566743a203070783b0d0a0972696768743a203070783b0d0a09626f74746f6d3a203070783b0d0a097a2d696e6465783a2031303b0d0a7d0d0a2e63656e746572486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20383570783b0d0a096c6566743a20353070783b0d0a0972696768743a20353070783b0d0a09626f74746f6d3a20333570783b0d0a096261636b67726f756e642d636f6c6f723a2077686974653b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2032303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a7d0d0a2e63656e746572486f6c646572496e76697369626c65207b0d0a09626f74746f6d3a206175746f3b0d0a626f726465723a20307078206e6f6e653b0d0a7d0d0a2e63656e746572486f6c646572496e76697369626c65202e76636d735f61726561207b0d0a6d696e2d6865696768743a3070783b0d0a7d0d0a2e63656e7465724c6566744d617267696e207b0d0a096c6566743a2032363070783b0d0a7d0d0a2e63656e74657252696768744d617267696e207b0d0a0972696768743a2032363070783b0d0a7d0d0a2e63656e74657252696768744269674d617267696e207b0d0a2020202020202072696768743a2034323570783b0d0a7d0d0a2e6c656674486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20383570783b0d0a096c6566743a20353070783b0d0a0977696474683a2032303070783b0d0a096865696768743a206175746f3b0d0a096261636b67726f756e642d636f6c6f723a2077686974653b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2032303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a7d0d0a2e7269676874486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20383570783b0d0a0972696768743a20353070783b0d0a0977696474683a2032303070783b0d0a096865696768743a206175746f3b0d0a096261636b67726f756e642d636f6c6f723a2077686974653b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2032303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a7d0d0a2e7269676874426967486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20383570783b0d0a0972696768743a20353070783b0d0a0977696474683a2033343570783b0d0a096865696768743a206175746f3b0d0a096261636b67726f756e642d636f6c6f723a2077686974653b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2032303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a2020202070616464696e673a20313070783b0d0a7d0d0a2e746f704d656e75486f6c646572207b0d0a09706f736974696f6e3a2066697865643b0d0a09746f703a203070783b0d0a096c6566743a20353070783b0d0a0972696768743a20353070783b0d0a096865696768743a20323570783b0d0a096261636b67726f756e642d636f6c6f723a20626c61636b3b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2032303b0d0a7d0d0a0d0a2e626f74746f6d4d656e75486f6c646572207b0d0a09706f736974696f6e3a2066697865643b0d0a09626f74746f6d3a203070783b0d0a096c6566743a20353070783b0d0a0972696768743a20353070783b0d0a096865696768743a20323570783b0d0a096261636b67726f756e642d636f6c6f723a20626c61636b3b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2032303b0d0a7d0d0a, '', 0),
(3, 'Docpanel Left Demo Template', '', '', 0x3c64697620636c6173733d2263656e746572486f6c6465722063656e7465724c6566744d617267696e223e0d0a2020266c743b3f636d732074656d706c6174652e6d61696e2e63656e74657220636d733f2667743b0d0a3c2f6469763e0d0a3c64697620636c6173733d226c656674486f6c646572223e0d0a2020266c743b3f636d732074656d706c6174652e617265612e6c65667420636d733f2667743b0d0a3c2f6469763e0d0a3c64697620636c6173733d22736561726368486f6c646572223e0d0a2020266c743b3f636d732074656d706c6174652e617265612e73656172636820636d733f2667743b0d0a3c2f6469763e0d0a3c64697620636c6173733d22746f704d656e75486f6c646572223e0d0a2020266c743b3f636d732074656d706c6174652e6d656e752e746f704d656e7520636d733f2667743b0d0a3c2f6469763e0d0a3c64697620636c6173733d22626f74746f6d4d656e75486f6c646572223e0d0a2020266c743b3f636d732074656d706c6174652e6d656e752e666f6f7465724d656e7520636d733f2667743b0d0a3c2f6469763e0d0a3c64697620636c6173733d22674d6170486f6c646572223e3c2f6469763e0d0a3c64697620636c6173733d226d6170486f6c646572223e0d0a2020266c743b3f636d732074656d706c6174652e6d6f64756c652e7374617469632e70696e626f6172644d61702e6d617020636d733f2667743b0d0a3c2f6469763e, 0x626f6479207b0d0a096261636b67726f756e642d636f6c6f723a20726762283230302c3230302c323030293b0d0a7d0d0a2e736561726368486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20333570783b0d0a096c6566743a20353070783b0d0a0977696474683a2032303070783b0d0a096865696768743a20343070783b0d0a096261636b67726f756e642d636f6c6f723a20626c61636b3b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2032303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a7d0d0a2e6d61696e4d656e75486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20333570783b0d0a0972696768743a20353070783b0d0a0977696474683a2033303070783b0d0a096865696768743a20343070783b0d0a096261636b67726f756e642d636f6c6f723a20626c61636b3b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2032303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a0d0a7d0d0a2e6d6170486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a203070783b0d0a096c6566743a203070783b0d0a0972696768743a203070783b0d0a09626f74746f6d3a203070783b0d0a097a2d696e6465783a2031303b0d0a7d0d0a2e63656e746572486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20383570783b0d0a096c6566743a20353070783b0d0a0972696768743a20353070783b0d0a09626f74746f6d3a20333570783b0d0a096261636b67726f756e642d636f6c6f723a2077686974653b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2032303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a7d0d0a2e63656e746572486f6c646572496e76697369626c65207b0d0a09626f74746f6d3a206175746f3b0d0a626f726465723a20307078206e6f6e653b0d0a7d0d0a2e63656e746572486f6c646572496e76697369626c65202e76636d735f61726561207b0d0a6d696e2d6865696768743a3070783b0d0a7d0d0a2e63656e7465724c6566744d617267696e207b0d0a096c6566743a2032363070783b0d0a7d0d0a2e63656e74657252696768744d617267696e207b0d0a0972696768743a2032363070783b0d0a7d0d0a2e63656e74657252696768744269674d617267696e207b0d0a2020202020202072696768743a2034323570783b0d0a7d0d0a2e6c656674486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20383570783b0d0a096c6566743a20353070783b0d0a0977696474683a2032303070783b0d0a096865696768743a206175746f3b0d0a096261636b67726f756e642d636f6c6f723a2077686974653b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2032303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a7d0d0a2e7269676874486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20383570783b0d0a0972696768743a20353070783b0d0a0977696474683a2032303070783b0d0a096865696768743a206175746f3b0d0a096261636b67726f756e642d636f6c6f723a2077686974653b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2032303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a7d0d0a2e7269676874426967486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20383570783b0d0a0972696768743a20353070783b0d0a0977696474683a2033343570783b0d0a096865696768743a206175746f3b0d0a096261636b67726f756e642d636f6c6f723a2077686974653b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2032303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a2020202070616464696e673a20313070783b0d0a7d0d0a2e746f704d656e75486f6c646572207b0d0a09706f736974696f6e3a2066697865643b0d0a09746f703a203070783b0d0a096c6566743a20353070783b0d0a0972696768743a20353070783b0d0a096865696768743a20323570783b0d0a096261636b67726f756e642d636f6c6f723a20626c61636b3b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2032303b0d0a7d0d0a0d0a2e626f74746f6d4d656e75486f6c646572207b0d0a09706f736974696f6e3a2066697865643b0d0a09626f74746f6d3a203070783b0d0a096c6566743a20353070783b0d0a0972696768743a20353070783b0d0a096865696768743a20323570783b0d0a096261636b67726f756e642d636f6c6f723a20626c61636b3b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2032303b0d0a7d0d0a, '', 0),
(4, 'Docpanel Right Demo Template', '', '', 0x3c64697620636c6173733d2263656e746572486f6c6465722063656e74657252696768744269674d617267696e223e0d0a2020266c743b3f636d732074656d706c6174652e6d61696e2e63656e74657220636d733f2667743b0d0a3c2f6469763e0d0a3c64697620636c6173733d227269676874426967486f6c646572223e0d0a2020266c743b3f636d732074656d706c6174652e617265612e726967687420636d733f2667743b0d0a3c2f6469763e0d0a3c64697620636c6173733d22736561726368486f6c646572223e0d0a2020266c743b3f636d732074656d706c6174652e617265612e73656172636820636d733f2667743b0d0a3c2f6469763e0d0a3c64697620636c6173733d22746f704d656e75486f6c646572223e0d0a2020266c743b3f636d732074656d706c6174652e6d656e752e746f704d656e7520636d733f2667743b0d0a3c2f6469763e0d0a3c64697620636c6173733d22626f74746f6d4d656e75486f6c646572223e0d0a2020266c743b3f636d732074656d706c6174652e6d656e752e666f6f7465724d656e7520636d733f2667743b0d0a3c2f6469763e0d0a3c64697620636c6173733d22674d6170486f6c646572223e3c2f6469763e0d0a3c64697620636c6173733d226d6170486f6c646572223e0d0a2020266c743b3f636d732074656d706c6174652e6d6f64756c652e7374617469632e70696e626f6172644d61702e6d617020636d733f2667743b0d0a3c2f6469763e, 0x626f6479207b0d0a096261636b67726f756e642d636f6c6f723a20726762283230302c3230302c323030293b0d0a7d0d0a2e736561726368486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20333570783b0d0a096c6566743a20353070783b0d0a0977696474683a2032303070783b0d0a096865696768743a20343070783b0d0a096261636b67726f756e642d636f6c6f723a20626c61636b3b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2032303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a7d0d0a2e6d61696e4d656e75486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20333570783b0d0a0972696768743a20353070783b0d0a0977696474683a2033303070783b0d0a096865696768743a20343070783b0d0a096261636b67726f756e642d636f6c6f723a20626c61636b3b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2032303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a0d0a7d0d0a2e6d6170486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a203070783b0d0a096c6566743a203070783b0d0a0972696768743a203070783b0d0a09626f74746f6d3a203070783b0d0a097a2d696e6465783a2031303b0d0a7d0d0a2e63656e746572486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20383570783b0d0a096c6566743a20353070783b0d0a0972696768743a20353070783b0d0a09626f74746f6d3a20333570783b0d0a096261636b67726f756e642d636f6c6f723a2077686974653b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2032303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a7d0d0a2e63656e746572486f6c646572496e76697369626c65207b0d0a09626f74746f6d3a206175746f3b0d0a626f726465723a20307078206e6f6e653b0d0a7d0d0a2e63656e746572486f6c646572496e76697369626c65202e76636d735f61726561207b0d0a6d696e2d6865696768743a3070783b0d0a7d0d0a2e63656e7465724c6566744d617267696e207b0d0a096c6566743a2032363070783b0d0a7d0d0a2e63656e74657252696768744d617267696e207b0d0a0972696768743a2032363070783b0d0a7d0d0a2e63656e74657252696768744269674d617267696e207b0d0a2020202020202072696768743a2034323570783b0d0a7d0d0a2e6c656674486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20383570783b0d0a096c6566743a20353070783b0d0a0977696474683a2032303070783b0d0a096865696768743a206175746f3b0d0a096261636b67726f756e642d636f6c6f723a2077686974653b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2032303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a7d0d0a2e7269676874486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20383570783b0d0a0972696768743a20353070783b0d0a0977696474683a2032303070783b0d0a096865696768743a206175746f3b0d0a096261636b67726f756e642d636f6c6f723a2077686974653b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2032303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a7d0d0a2e7269676874426967486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20383570783b0d0a0972696768743a20353070783b0d0a0977696474683a2033343570783b0d0a096865696768743a206175746f3b0d0a096261636b67726f756e642d636f6c6f723a2077686974653b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2032303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a2020202070616464696e673a20313070783b0d0a7d0d0a2e746f704d656e75486f6c646572207b0d0a09706f736974696f6e3a2066697865643b0d0a09746f703a203070783b0d0a096c6566743a20353070783b0d0a0972696768743a20353070783b0d0a096865696768743a20323570783b0d0a096261636b67726f756e642d636f6c6f723a20626c61636b3b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2032303b0d0a7d0d0a0d0a2e626f74746f6d4d656e75486f6c646572207b0d0a09706f736974696f6e3a2066697865643b0d0a09626f74746f6d3a203070783b0d0a096c6566743a20353070783b0d0a0972696768743a20353070783b0d0a096865696768743a20323570783b0d0a096261636b67726f756e642d636f6c6f723a20626c61636b3b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2032303b0d0a7d0d0a, '', 0),
(25, 'Map Template', '', '', 0x3c64697620636c6173733d2263656e746572486f6c6465722063656e746572486f6c646572496e76697369626c65223e0d0a2020266c743b3f636d732074656d706c6174652e6d61696e2e63656e74657220636d733f2667743b0d0a3c2f6469763e0d0a3c64697620636c6173733d22736561726368486f6c646572223e0d0a2020266c743b3f636d732074656d706c6174652e617265612e73656172636820636d733f2667743b0d0a3c2f6469763e0d0a3c64697620636c6173733d22746f704d656e75486f6c646572223e0d0a2020266c743b3f636d732074656d706c6174652e6d656e752e746f704d656e7520636d733f2667743b0d0a3c2f6469763e0d0a3c64697620636c6173733d22626f74746f6d4d656e75486f6c646572223e0d0a2020266c743b3f636d732074656d706c6174652e6d656e752e666f6f7465724d656e7520636d733f2667743b0d0a3c2f6469763e0d0a3c64697620636c6173733d22674d6170486f6c646572223e3c2f6469763e0d0a3c64697620636c6173733d226d6170486f6c646572223e0d0a2020266c743b3f636d732074656d706c6174652e6d6f64756c652e7374617469632e70696e626f6172644d61702e6d617020636d733f2667743b0d0a3c2f6469763e, 0x626f6479207b0d0a096261636b67726f756e642d636f6c6f723a20726762283230302c3230302c323030293b0d0a7d0d0a2e736561726368486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20333570783b0d0a096c6566743a20353070783b0d0a0977696474683a2032303070783b0d0a096865696768743a20343070783b0d0a096261636b67726f756e642d636f6c6f723a20626c61636b3b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2032303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a7d0d0a2e6d61696e4d656e75486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20333570783b0d0a0972696768743a20353070783b0d0a0977696474683a2033303070783b0d0a096865696768743a20343070783b0d0a096261636b67726f756e642d636f6c6f723a20626c61636b3b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2032303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a0d0a7d0d0a2e6d6170486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a203070783b0d0a096c6566743a203070783b0d0a0972696768743a203070783b0d0a09626f74746f6d3a203070783b0d0a097a2d696e6465783a2032303b0d0a7d0d0a2e674d6170486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a203070783b0d0a096c6566743a203070783b0d0a0972696768743a203070783b0d0a09626f74746f6d3a203070783b0d0a097a2d696e6465783a2031303b0d0a7d0d0a2e63656e746572486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20383570783b0d0a096c6566743a20353070783b0d0a0972696768743a20353070783b0d0a09626f74746f6d3a20333570783b0d0a096261636b67726f756e642d636f6c6f723a2077686974653b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2033303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a7d0d0a2e63656e746572486f6c646572496e76697369626c65207b0d0a09626f74746f6d3a206175746f3b0d0a626f726465723a20307078206e6f6e653b0d0a7d0d0a2e63656e746572486f6c646572496e76697369626c65202e76636d735f61726561207b0d0a6d696e2d6865696768743a3070783b0d0a7d0d0a2e63656e746572486f6c646572496e76697369626c65202e70616e656c207b0d0a202020206d617267696e3a20323070783b0d0a7d0d0a2e63656e7465724c6566744d617267696e207b0d0a096c6566743a2032363070783b0d0a7d0d0a2e63656e74657252696768744d617267696e207b0d0a0972696768743a2032363070783b0d0a7d0d0a2e63656e74657252696768744269674d617267696e207b0d0a2020202020202072696768743a2034323570783b0d0a7d0d0a2e6c656674486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20383570783b0d0a096c6566743a20353070783b0d0a0977696474683a2032303070783b0d0a096865696768743a206175746f3b0d0a096261636b67726f756e642d636f6c6f723a2077686974653b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2033303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a7d0d0a2e7269676874486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20383570783b0d0a0972696768743a20353070783b0d0a0977696474683a2032303070783b0d0a096865696768743a206175746f3b0d0a096261636b67726f756e642d636f6c6f723a2077686974653b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2033303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a7d0d0a2e7269676874426967486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20383570783b0d0a0972696768743a20353070783b0d0a0977696474683a2033343570783b0d0a096865696768743a206175746f3b0d0a096261636b67726f756e642d636f6c6f723a2077686974653b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2033303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a2020202070616464696e673a20313070783b0d0a7d0d0a2e746f704d656e75486f6c646572207b0d0a09706f736974696f6e3a2066697865643b0d0a09746f703a203070783b0d0a096c6566743a20353070783b0d0a0972696768743a20353070783b0d0a096865696768743a20323570783b0d0a096261636b67726f756e642d636f6c6f723a20626c61636b3b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2033303b0d0a7d0d0a0d0a2e626f74746f6d4d656e75486f6c646572207b0d0a09706f736974696f6e3a2066697865643b0d0a09626f74746f6d3a203070783b0d0a096c6566743a20353070783b0d0a0972696768743a20353070783b0d0a096865696768743a20323570783b0d0a096261636b67726f756e642d636f6c6f723a20626c61636b3b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2033303b0d0a7d0d0a, '', 0),
(5, 'Docpanel Stack Demo Template', '', '', 0x3c64697620636c6173733d2263656e746572486f6c646572223e0d0a2020266c743b3f636d732074656d706c6174652e6d61696e2e63656e74657220636d733f2667743b0d0a3c2f6469763e0d0a3c64697620636c6173733d22736561726368486f6c646572223e0d0a2020266c743b3f636d732074656d706c6174652e617265612e73656172636820636d733f2667743b0d0a3c2f6469763e0d0a3c64697620636c6173733d22746f704d656e75486f6c646572223e0d0a2020266c743b3f636d732074656d706c6174652e6d656e752e746f704d656e7520636d733f2667743b0d0a3c2f6469763e0d0a3c64697620636c6173733d22626f74746f6d4d656e75486f6c646572223e0d0a2020266c743b3f636d732074656d706c6174652e6d656e752e666f6f7465724d656e7520636d733f2667743b0d0a3c2f6469763e0d0a3c64697620636c6173733d22674d6170486f6c646572223e3c2f6469763e0d0a3c64697620636c6173733d226d6170486f6c646572223e0d0a2020266c743b3f636d732074656d706c6174652e6d6f64756c652e7374617469632e70696e626f6172644d61702e6d617020636d733f2667743b0d0a3c2f6469763e, 0x626f6479207b0d0a096261636b67726f756e642d636f6c6f723a20726762283230302c3230302c323030293b0d0a7d0d0a2e736561726368486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20333570783b0d0a096c6566743a20353070783b0d0a0977696474683a2032303070783b0d0a096865696768743a20343070783b0d0a096261636b67726f756e642d636f6c6f723a20626c61636b3b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2032303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a7d0d0a2e6d61696e4d656e75486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20333570783b0d0a0972696768743a20353070783b0d0a0977696474683a2033303070783b0d0a096865696768743a20343070783b0d0a096261636b67726f756e642d636f6c6f723a20626c61636b3b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2032303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a0d0a7d0d0a2e6d6170486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a203070783b0d0a096c6566743a203070783b0d0a0972696768743a203070783b0d0a09626f74746f6d3a203070783b0d0a097a2d696e6465783a2031303b0d0a7d0d0a2e63656e746572486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20383570783b0d0a096c6566743a20353070783b0d0a0972696768743a20353070783b0d0a09626f74746f6d3a20333570783b0d0a096261636b67726f756e642d636f6c6f723a2077686974653b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2032303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a7d0d0a2e63656e746572486f6c646572496e76697369626c65207b0d0a09626f74746f6d3a206175746f3b0d0a626f726465723a20307078206e6f6e653b0d0a7d0d0a2e63656e746572486f6c646572496e76697369626c65202e76636d735f61726561207b0d0a6d696e2d6865696768743a3070783b0d0a7d0d0a2e63656e7465724c6566744d617267696e207b0d0a096c6566743a2032363070783b0d0a7d0d0a2e63656e74657252696768744d617267696e207b0d0a0972696768743a2032363070783b0d0a7d0d0a2e63656e74657252696768744269674d617267696e207b0d0a2020202020202072696768743a2034323570783b0d0a7d0d0a2e6c656674486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20383570783b0d0a096c6566743a20353070783b0d0a0977696474683a2032303070783b0d0a096865696768743a206175746f3b0d0a096261636b67726f756e642d636f6c6f723a2077686974653b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2032303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a7d0d0a2e7269676874486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20383570783b0d0a0972696768743a20353070783b0d0a0977696474683a2032303070783b0d0a096865696768743a206175746f3b0d0a096261636b67726f756e642d636f6c6f723a2077686974653b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2032303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a7d0d0a2e7269676874426967486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20383570783b0d0a0972696768743a20353070783b0d0a0977696474683a2033343570783b0d0a096865696768743a206175746f3b0d0a096261636b67726f756e642d636f6c6f723a2077686974653b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2032303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a2020202070616464696e673a20313070783b0d0a7d0d0a2e746f704d656e75486f6c646572207b0d0a09706f736974696f6e3a2066697865643b0d0a09746f703a203070783b0d0a096c6566743a20353070783b0d0a0972696768743a20353070783b0d0a096865696768743a20323570783b0d0a096261636b67726f756e642d636f6c6f723a20626c61636b3b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2032303b0d0a7d0d0a0d0a2e626f74746f6d4d656e75486f6c646572207b0d0a09706f736974696f6e3a2066697865643b0d0a09626f74746f6d3a203070783b0d0a096c6566743a20353070783b0d0a0972696768743a20353070783b0d0a096865696768743a20323570783b0d0a096261636b67726f756e642d636f6c6f723a20626c61636b3b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2032303b0d0a7d0d0a, '', 1),
(1, 'Admin Template', 'core/template/adminTemplate.php', 'AdminTemplate', NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `t_templatearea`
--

CREATE TABLE IF NOT EXISTS `t_templatearea` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `instanceid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `pageid` int(10) NOT NULL,
  `position` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_track`
--

CREATE TABLE IF NOT EXISTS `t_track` (
  `clientip` blob NOT NULL,
  `href` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_user`
--

CREATE TABLE IF NOT EXISTS `t_user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `authkey` varchar(40) DEFAULT NULL,
  `email` varchar(200) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `gender` int(1) NOT NULL,
  `objectid` int(10) NOT NULL,
  `registerdate` datetime NOT NULL,
  `logindate` datetime NOT NULL,
  `birthdate` date NOT NULL,
  `active` tinyint(1) NOT NULL,
  `image` int(10) DEFAULT NULL,
  `imagex` int(11) DEFAULT NULL,
  `imagey` int(11) DEFAULT NULL,
  `imagew` int(11) DEFAULT NULL,
  `imageh` int(11) DEFAULT NULL,
  `facebook_uid` varchar(100) DEFAULT NULL,
  `twitter_uid` varchar(100) DEFAULT NULL,
  `lastonline` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `profileviews` int(10) DEFAULT NULL,
  `orientation` int(4) DEFAULT NULL,
  `religion` int(4) DEFAULT NULL,
  `ethnicity` int(4) DEFAULT NULL,
  `about` blob,
  `relationship` int(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_user_address`
--

CREATE TABLE IF NOT EXISTS `t_user_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `address` blob NOT NULL,
  `postcode` varchar(30) COLLATE utf8_bin NOT NULL,
  `continent` varchar(100) COLLATE utf8_bin NOT NULL,
  `continentid` int(20) NOT NULL,
  `country` varchar(100) COLLATE utf8_bin NOT NULL,
  `countryid` int(20) NOT NULL,
  `state` varchar(100) COLLATE utf8_bin NOT NULL,
  `stateid` int(20) NOT NULL,
  `region` varchar(100) COLLATE utf8_bin NOT NULL,
  `regionid` int(20) NOT NULL,
  `city` varchar(100) COLLATE utf8_bin NOT NULL,
  `cityid` int(20) NOT NULL,
  `longditude` double DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `vectorx` double DEFAULT NULL,
  `vectory` double DEFAULT NULL,
  `vectorz` double DEFAULT NULL,
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_user_friend`
--

CREATE TABLE IF NOT EXISTS `t_user_friend` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `srcuserid` int(11) NOT NULL,
  `dstuserid` int(11) NOT NULL,
  `confirmed` tinyint(1) NOT NULL,
  `createdate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_user_message`
--

CREATE TABLE IF NOT EXISTS `t_user_message` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `srcuser` int(10) NOT NULL,
  `dstuser` int(10) NOT NULL,
  `subject` varchar(100) CHARACTER SET latin1 NOT NULL,
  `message` blob NOT NULL,
  `senddate` date NOT NULL,
  `opened` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_user_wall_event`
--

CREATE TABLE IF NOT EXISTS `t_user_wall_event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL,
  `typeid` int(11) DEFAULT NULL,
  `userid` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_user_wall_post`
--

CREATE TABLE IF NOT EXISTS `t_user_wall_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `srcuserid` int(11) NOT NULL,
  `comment` blob NOT NULL,
  `eventid` int(11) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_vdb_column`
--

CREATE TABLE IF NOT EXISTS `t_vdb_column` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `tableid` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `value` blob NOT NULL,
  `label` varchar(100) NOT NULL,
  `edittype` int(5) NOT NULL,
  `position` int(5) NOT NULL,
  `refcolumn` int(10) DEFAULT NULL,
  `objectidcolumn` int(10) DEFAULT NULL,
  `description` blob NOT NULL,
  `required` int(1) NOT NULL,
  `validator` int(10) NOT NULL,
  `minlength` int(10) NOT NULL,
  `maxlength` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=56 ;

--
-- Dumping data for table `t_vdb_column`
--

INSERT INTO `t_vdb_column` (`id`, `tableid`, `name`, `value`, `label`, `edittype`, `position`, `refcolumn`, `objectidcolumn`, `description`, `required`, `validator`, `minlength`, `maxlength`) VALUES
(1, 2, 'Username', '', 'Username', 1, 1, 9, 14, '', 0, 0, 0, 0),
(2, 2, 'Firstname', '', 'Firstname', 1, 2, 12, 14, '', 0, 0, 0, 0),
(3, 2, 'Lastname', '', 'Lastname', 1, 3, 13, 14, '', 0, 0, 0, 0),
(4, 2, 'Email', '', 'Email', 1, 4, 11, 14, '', 0, 0, 0, 0),
(5, 2, 'Date Of Birth', '', 'Date Of Birth', 7, 5, 16, 14, '', 0, 0, 0, 0),
(6, 2, 'Register Date', '', 'Register Date', 7, 6, 15, 14, '', 0, 0, 0, 0),
(7, 2, 'active', '', 'active', 8, 7, 17, 14, '', 0, 0, 0, 0),
(8, 2, 'registered', '', 'registered', 8, 8, NULL, 14, '', 0, 0, 0, 0),
(9, 3, 'username', '', 'username', 1, 9, NULL, NULL, 0x736673646678783132617364, 1, 0, 0, 0),
(10, 3, 'password', '', 'password', 1, 10, NULL, NULL, '', 1, 0, 0, 0),
(11, 3, 'email', '', 'email', 1, 11, NULL, NULL, '', 1, 0, 0, 0),
(12, 3, 'firstname', '', 'firstname', 1, 12, NULL, NULL, '', 1, 0, 0, 0),
(13, 3, 'lastname', '', 'lastname', 1, 13, NULL, NULL, '', 1, 0, 0, 0),
(14, 3, 'objectid', '', 'objectid', 1, 14, NULL, NULL, '', 0, 0, 0, 0),
(15, 3, 'registerdate', '', 'registerdate', 7, 15, NULL, NULL, '', 0, 0, 0, 0),
(16, 3, 'birthdate', '', 'birthdate', 7, 16, NULL, NULL, '', 0, 0, 0, 0),
(17, 3, 'active', '', 'active', 8, 17, NULL, NULL, '', 0, 0, 0, 0),
(37, 9, 'Email', '', 'Email', 1, 2, NULL, NULL, '', 0, 0, 0, 0),
(36, 9, 'Name', '', 'Name', 1, 1, NULL, NULL, '', 0, 0, 0, 0),
(24, 2, 'Firma', '', 'Firma', 1, 24, NULL, NULL, '', 0, 0, 0, 0),
(39, 9, 'Subject', '', 'Subject', 1, 3, NULL, NULL, '', 0, 0, 0, 0),
(38, 9, 'Message', '', 'Message', 2, 4, NULL, NULL, '', 0, 0, 0, 0),
(40, 10, ' Vorname (first name) ', '', ' Vorname (first name) ', 1, 2, NULL, NULL, '', 1, 0, 0, 0),
(41, 10, 'Nachname (last name)', '', 'Nachname (last name)', 1, 3, NULL, NULL, '', 1, 0, 0, 0),
(42, 10, 'Firmenname (company name) optional', '', 'Firmenname (company name) optional', 1, 4, NULL, NULL, '', 0, 0, 0, 0),
(43, 10, 'Strasse (street)', '', 'Strasse (street)', 1, 5, NULL, NULL, '', 1, 0, 0, 0),
(44, 10, 'Hausnummer (house number)', '', 'Hausnummer (house number)', 1, 6, NULL, NULL, '', 1, 0, 0, 0),
(45, 10, 'Stadt (city)', '', 'Stadt (city)', 1, 7, NULL, NULL, '', 1, 0, 0, 0),
(46, 10, 'Postleitzahl (post code)', '', 'Postleitzahl (post code)', 1, 8, NULL, NULL, '', 1, 0, 0, 0),
(47, 10, 'Land (country)', '', 'Land (country)', 1, 9, NULL, NULL, '', 1, 0, 0, 0),
(48, 10, 'instructions', '', 'instructions', 9, 1, NULL, NULL, 0x44657461696c20496e666f726d6174696f6e3a, 0, 0, 0, 0),
(49, 2, 'test', '', 'test', 1, 25, NULL, NULL, '', 0, 0, 0, 0),
(50, 15, 'FormItemCheckbox1', '', 'Label', 8, 1, NULL, NULL, 0x4465736372697074696f6e, 0, 0, 0, 0),
(51, 15, 'FormItemTime51', '', 'Label', 0, 1, NULL, NULL, 0x4465736372697074696f6e, 0, 0, 0, 0),
(52, 15, 'FormItemTextArea52', '', 'Label', 2, 3, NULL, NULL, 0x4465736372697074696f6e, 0, 0, 0, 0),
(53, 16, 'FormItemTextArea1', '', 'Label', 2, 1, NULL, NULL, 0x4465736372697074696f6e, 0, 0, 0, 0),
(55, 2, 'FormItemSelect9', 0x746573742c74686973, 'Label', 10, 9, NULL, NULL, 0x4465736372697074696f6e, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `t_vdb_object`
--

CREATE TABLE IF NOT EXISTS `t_vdb_object` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `tableid` int(10) NOT NULL,
  `viewed` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_vdb_table`
--

CREATE TABLE IF NOT EXISTS `t_vdb_table` (
  `physical` int(1) NOT NULL,
  `system` int(1) NOT NULL,
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `t_vdb_table`
--

INSERT INTO `t_vdb_table` (`physical`, `system`, `id`, `name`) VALUES
(0, 1, 2, 'userAttribs'),
(1, 1, 3, 't_users'),
(0, 0, 4, 'orderAttribs'),
(0, 0, 9, 'Kontakt'),
(0, 0, 10, 'orderDetails'),
(0, 0, 16, 'the new form');

-- --------------------------------------------------------

--
-- Table structure for table `t_vdb_value`
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
-- Table structure for table `t_wysiwygpage`
--

CREATE TABLE IF NOT EXISTS `t_wysiwygpage` (
  `id` int(10) unsigned DEFAULT NULL,
  `moduleid` int(10) unsigned DEFAULT NULL,
  `lang` varchar(5) NOT NULL,
  `content` blob,
  `title` varchar(100) DEFAULT NULL,
  `area` int(5) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

; */ ?>
