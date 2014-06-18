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
-- Tabellenstruktur für Tabelle `ajax_chat_invitations`
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
-- Tabellenstruktur für Tabelle `ajax_chat_messages`
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
-- Tabellenstruktur für Tabelle `ajax_chat_online`
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
-- Tabellenstruktur für Tabelle `t_backup`
--

CREATE TABLE IF NOT EXISTS `t_backup` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_cms_customer`
--

CREATE TABLE IF NOT EXISTS `t_cms_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_cms_version`
--

CREATE TABLE IF NOT EXISTS `t_cms_version` (
  `version` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;

--
-- Daten für Tabelle `t_code`
--

INSERT INTO `t_code` (`id`, `lang`, `code`, `value`) VALUES
(1, 'en', 1, 0x6c6f67696e),
(2, 'en', 2, 0x61646d696e5061676573),
(3, 'en', 3, 0x73746172747570),
(4, 'en', 4, 0x61646d696e5369746573),
(5, 'en', 5, 0x61646d696e446f6d61696e73),
(6, 'en', 6, 0x61646d696e5061636b616765),
(7, 'en', 7, 0x70616765436f6e666967),
(8, 'en', 8, 0x4f6e6c696e6520446174696e67),
(9, 'en', 9, 0x50726f66696c65),
(10, 'en', 10, 0x536561726368),
(11, 'en', 11, 0x696e736572744d6f64756c65),
(12, 'en', 12, 0x75736572536561726368526573756c74),
(13, 'en', 13, 0x4c6f67696e),
(14, 'en', 14, 0x7265676973746572),
(15, 'en', 15, 0x7573657250726f66696c65),
(16, 'en', 16, 0x7573657244657461696c73),
(17, 'en', 17, 0x70726f66696c65),
(18, 'en', 18, 0x61646d696e5472616e736c6174696f6e73),
(19, 'en', 19, 0x7573657257616c6c),
(20, 'en', 20, 0x7573657247616c6c657279),
(21, 'en', 21, 0x757365724d657373616765),
(22, 'en', 22, 0x75736572467269656e6473),
(23, 'en', 23, 0x75736572416464467269656e6473),
(24, 'en', 24, 0x496d7072657373756d),
(25, 'en', 25, 0x436f6e74616374),
(26, 'en', 26, 0x41474273),
(27, 'en', 27, 0x61646d696e54656d706c61746573),
(28, 'en', 28, 0x4d65737361676573),
(29, 'en', 29, 0x467269656e6473),
(30, 'en', 30, 0x4c6f67696e),
(31, 'en', 31, 0x4c6f676f7574),
(32, 'en', 32, 0x61646d696e526f6c6573),
(33, 'en', 33, 0x756e72656769737465726564),
(34, 'en', 34, 0x75736572467269656e64),
(35, 'en', 35, 0x467269656e64205265717565737473),
(36, 'en', 36, 0x536561726368205573657273),
(37, 'en', 37, 0x4e6577205573657273),
(38, 'en', 38, 0x526563656e746c7920416374697665205573657273),
(39, 'en', 39, 0x61646d696e536f6369616c4e6f74696669636174696f6e73),
(40, 'en', 40, 0x7573657250726f66696c65496d616765),
(41, 'en', 41, 0x43686174);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_comment`
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
-- Tabellenstruktur für Tabelle `t_confirm`
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
-- Tabellenstruktur für Tabelle `t_country`
--

CREATE TABLE IF NOT EXISTS `t_country` (
  `geonameid` varchar(20) COLLATE utf8_bin NOT NULL,
  `name` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_domain`
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
-- Tabellenstruktur für Tabelle `t_email`
--

CREATE TABLE IF NOT EXISTS `t_email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(200) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_event`
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
-- Tabellenstruktur für Tabelle `t_forum_post`
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
  `typeid` int(11) NOT NULL,
  `rootcategory` int(10) NOT NULL,
  `type` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_language`
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
-- Daten für Tabelle `t_language`
--

INSERT INTO `t_language` (`id`, `code`, `name`, `local`, `flag`, `active`, `isdefault`) VALUES
(1, 'de', 'German', 'de', 'de.gif', 1, 0),
(2, 'it', 'Italian', 'it_en', 'flag_italy.gif', 0, 0),
(3, 'en', 'English', 'en', 'gb.gif', 1, 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Daten für Tabelle `t_menu`
--

INSERT INTO `t_menu` (`id`, `page`, `type`, `parent`, `active`, `lang`, `position`) VALUES
(1, 8, 1, NULL, 1, 'en', 1),
(2, 9, 1, NULL, 1, 'en', 2),
(3, 10, 1, NULL, 1, 'en', 15),
(4, 13, 2, NULL, 1, 'en', 4),
(5, 15, 0, NULL, 0, 'en', 5),
(6, 19, 0, NULL, 0, 'en', 6),
(7, 12, 0, NULL, 0, 'en', 7),
(8, 20, 0, NULL, 0, 'en', 8),
(9, 16, 0, NULL, 0, 'en', 9),
(10, 21, 0, NULL, 0, 'en', 10),
(11, 24, 3, NULL, 1, 'en', 13),
(12, 25, 3, NULL, 1, 'en', 16),
(13, 26, 3, NULL, 1, 'en', 17),
(14, 28, 1, NULL, 1, 'en', 3),
(15, 29, 1, NULL, 1, 'en', 14),
(16, 30, 3, NULL, 1, 'en', 11),
(17, 31, 3, NULL, 1, 'en', 12),
(18, 34, 0, NULL, 0, 'en', 18),
(19, 35, 1, 29, 1, 'en', 19),
(20, 36, 1, 10, 1, 'en', 20),
(21, 37, 1, 10, 1, 'en', 21),
(22, 38, 1, 10, 1, 'en', 22),
(23, 40, 0, NULL, 0, 'en', 23),
(24, 41, 1, NULL, 1, 'en', 24);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_menu_instance`
--

CREATE TABLE IF NOT EXISTS `t_menu_instance` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `siteid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `t_menu_instance`
--

INSERT INTO `t_menu_instance` (`id`, `name`, `siteid`) VALUES
(1, 'Main Menu', 1),
(2, 'Bottom Menu', 1),
(3, 'Top Menu', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_menu_style`
--

CREATE TABLE IF NOT EXISTS `t_menu_style` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `cssclass` blob NOT NULL,
  `cssstyle` blob NOT NULL,
  `name` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Daten für Tabelle `t_menu_style`
--

INSERT INTO `t_menu_style` (`id`, `cssclass`, `cssstyle`, `name`) VALUES
(1, '', '', 'Plain Menu'),
(4, 0x706c61696e4469764d656e75, 0x2e706c61696e4469764d656e75207b0d0a202020206865696768743a20323070783b0d0a202020206c696e652d6865696768743a20323070783b0d0a20202020666f6e742d7765696768743a626f6c643b0d0a7d0d0a2e706c61696e4469764d656e75202e7364646d207b0d0a20202020666f6e742d73697a653a20313570783b0d0a7d0d0a2e706c61696e4469764d656e75202e7364646d206469762061207b0d0a20202020746578742d6465636f726174696f6e3a206e6f6e653b0d0a2020202070616464696e673a20307078203770783b0d0a202020206d617267696e3a203070783b0d0a20202020636f6c6f723a20626c61636b3b0d0a7d0d0a2e706c61696e4469764d656e75202e7364646d2064697620612e7364646d53656c6563746564207b0d0a7d0d0a2e706c61696e4469764d656e75202e7364646d2064697620613a686f766572207b0d0a20202020626f726465723a203170782030707820736f6c69642073696c7665723b0d0a7d0d0a2e706c61696e4469764d656e75202e7364646d2064697620646976207b0d0a202020206d696e2d77696474683a2031303070783b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a7d0d0a2e706c61696e4469764d656e75202e7364646d206469762064697620613a686f766572207b0d0a202020206261636b67726f756e642d636f6c6f723a20726762283230302c203230302c20323030293b0d0a20202020626f726465723a203170782030707820736f6c69642073696c7665723b0d0a7d0d0a2e706c61696e4469764d656e75202e7364646d20646976206469762061207b0d0a7d0d0a2e706c61696e4469764d656e75202e7364646d206469762064697620612e7364646d53656c6563746564207b0d0a7d0d0a2e706c61696e4469764d656e75202e7364646d2064697620612e7364646d4669727374207b0d0a2020202070616464696e672d6c6566743a203070783b0d0a20202020626f726465722d6c6566743a20307078206e6f6e653b0d0a7d, 'Main Menu'),
(5, 0x6c6576656c73, 0x2f2a206669727374206c6576656c202a2f0d0a0d0a2e6c6576656c73207b0d0a2020202070616464696e673a2031307078203070782030707820313070783b0d0a7d0d0a2e6c6576656c73202e7364646d207b0d0a20202020666c6f61743a6c6566743b0d0a7d0d0a2e6c6576656c73202e7364646d20646976207b0d0a20202020666c6f61743a6e6f6e653b0d0a7d0d0a2e6c6576656c73202e7364646d206469762061207b0d0a20202020636f6c6f723a20626c61636b3b0d0a20202020746578742d6465636f726174696f6e3a206e6f6e653b0d0a20202020746578742d616c69676e3a206c6566743b0d0a2020202070616464696e673a203570783b0d0a20202020666f6e742d7765696768743a626f6c643b0d0a20202020666f6e742d73697a653a20313470783b0d0a7d0d0a2e6c6576656c73202e7364646d2064697620613a686f766572207b0d0a09746578742d6465636f726174696f6e3a20756e6465726c696e653b0d0a7d0d0a2e6c6576656c73202e7364646d2064697620612e7364646d4669727374207b0d0a20202020626f726465722d6c6566743a20307078206e6f6e653b0d0a7d0d0a2e6c6576656c73202e7364646d20646976202e7364646d53656c6563746564207b0d0a20202020646973706c61793a20626c6f636b3b0d0a20202020636f6c6f723a207265643b0d0a7d0d0a0d0a2f2a207365636f6e64206c6576656c202a2f0d0a0d0a2e6c6576656c73202e7364646d2064697620646976207b0d0a20202020706f736974696f6e3a2072656c61746976653b0d0a202020206261636b67726f756e643a206e6f6e653b0d0a7d0d0a2e6c6576656c73202e7364646d20646976206469762061207b0d0a20202020636f6c6f723a20233030364335353b0d0a20202020666f6e742d73697a653a20313270783b0d0a20202020666f6e742d7765696768743a206e6f726d616c3b0d0a202020206261636b67726f756e643a2075726c28272e2e2f696d672f6c697374655f7a65696368656e2e6769662729206e6f2d7265706561743b0d0a202020206261636b67726f756e642d706f736974696f6e3a2030707820313070783b0d0a202020206d617267696e2d6c6566743a20313070783b0d0a2020202070616464696e672d6c6566743a20313070783b0d0a7d0d0a2e6c6576656c73202e7364646d206469762064697620612e7364646d53656c6563746564207b0d0a20202020666f6e742d7765696768743a20626f6c643b0d0a20202020636f6c6f723a20626c61636b3b0d0a7d0d0a2e6c6576656c73202e7364646d206469762064697620613a686f766572207b0d0a20202020636f6c6f723a20626c61636b3b0d0a20202020746578742d6465636f726174696f6e3a206e6f6e653b0d0a7d0d0a0d0a2f2a207468697264206c6576656c202a2f0d0a0d0a2e6c6576656c73202e7364646d206469762064697620646976207b0d0a20202020706f736974696f6e3a206162736f6c7574653b0d0a202020206261636b67726f756e643a20726762283234302c3234302c323430293b0d0a20202020746f703a3070783b0d0a202020206c6566743a31303070783b0d0a7d0d0a2e6c6576656c73202e7364646d2064697620646976206469762061207b0d0a20202020636f6c6f723a20233030364335353b0d0a20202020666f6e742d73697a653a20313270783b0d0a20202020666f6e742d7765696768743a206e6f726d616c3b0d0a202020206261636b67726f756e643a2075726c28272e2e2f696d672f6c697374655f7a65696368656e2e6769662729206e6f2d7265706561743b0d0a202020206261636b67726f756e642d706f736974696f6e3a2030707820313070783b0d0a202020206d617267696e2d6c6566743a20313070783b0d0a2020202070616464696e672d6c6566743a20313070783b0d0a7d0d0a2e6c6576656c73202e7364646d20646976206469762064697620612e7364646d53656c6563746564207b0d0a20202020666f6e742d7765696768743a20626f6c643b0d0a20202020636f6c6f723a20626c61636b3b0d0a7d0d0a2e6c6576656c73202e7364646d20646976206469762064697620613a686f766572207b0d0a20202020636f6c6f723a20626c61636b3b0d0a20202020746578742d6465636f726174696f6e3a206e6f6e653b0d0a7d, 'Stack Menu'),
(7, 0x746f704469764d656e7520, 0x2e746f704469764d656e75207b0d0a202020206d617267696e2d6c6566743a313070783b0d0a202020206865696768743a323270783b0d0a20202020666f6e743a203131707820417269616c2c73616e732d73657269663b0d0a20202020636f6c6f723a20234646463b0d0a202020206c696e652d6865696768743a323270783b0d0a7d0d0a2e746f704469764d656e75202e7364646d207b0d0a7d0d0a2e746f704469764d656e75202e7364646d206469762061207b0d0a20202020746578742d6465636f726174696f6e3a206e6f6e653b0d0a2020202070616464696e673a20307078203770783b0d0a202020206d617267696e3a203070783b0d0a20202020666f6e742d7765696768743a6e6f726d616c3b0d0a7d0d0a2e746f704469764d656e75202e7364646d2064697620612e7364646d53656c6563746564207b0d0a20202020636f6c6f723a20234646444430303b0d0a7d0d0a2e746f704469764d656e75202e7364646d2064697620613a686f766572207b0d0a20202020636f6c6f723a20234646444430303b0d0a7d0d0a2e746f704469764d656e75202e7364646d2064697620646976207b0d0a202020206261636b67726f756e642d636f6c6f723a20726762283235302c3235302c323530293b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a2020202070616464696e673a203470783b0d0a7d0d0a2e746f704469764d656e75202e7364646d206469762064697620613a686f766572207b0d0a202020206261636b67726f756e642d636f6c6f723a20726762283234302c3234302c323430293b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a2020202070616464696e673a203370782033707820337078203470783b0d0a7d0d0a2e746f704469764d656e75202e7364646d20646976206469762061207b0d0a202020206261636b67726f756e642d636f6c6f723a20726762283235302c3235302c323530293b0d0a2020202070616464696e673a203470783b0d0a7d0d0a2e746f704469764d656e75202e7364646d206469762064697620612e7364646d53656c6563746564207b0d0a20202020666f6e742d7765696768743a20626f6c643b0d0a20202020636f6c6f723a626c61636b3b0d0a7d0d0a2e746f704469764d656e75202e7364646d2064697620612e7364646d4669727374207b0d0a2020202070616464696e672d6c6566743a203070783b0d0a20202020626f726465722d6c6566743a20307078206e6f6e653b0d0a7d, 'Top Menu'),
(8, 0x626f74746f6d4469764d656e75, 0x2e626f74746f6d4469764d656e75207b0d0a202020206d617267696e2d6c6566743a363070783b0d0a202020206865696768743a343870783b0d0a20202020666f6e743a203131707820417269616c2c73616e732d73657269663b0d0a202020206c696e652d6865696768743a343870783b0d0a7d0d0a2e626f74746f6d4469764d656e75202e7364646d207b0d0a7d0d0a2e626f74746f6d4469764d656e75202e7364646d206469762061207b0d0a20202020746578742d6465636f726174696f6e3a206e6f6e653b0d0a2020202070616464696e673a20307078203770783b0d0a202020206d617267696e3a203070783b0d0a20202020666f6e742d7765696768743a6e6f726d616c3b0d0a20202020636f6c6f723a20234646463b0d0a7d0d0a2e626f74746f6d4469764d656e75202e7364646d2064697620612e7364646d53656c6563746564207b0d0a20202020636f6c6f723a20234646444430303b0d0a7d0d0a2e626f74746f6d4469764d656e75202e7364646d2064697620613a686f766572207b0d0a20202020636f6c6f723a20234646444430303b0d0a7d0d0a2e626f74746f6d4469764d656e75202e7364646d2064697620646976207b0d0a202020206261636b67726f756e642d636f6c6f723a20726762283235302c3235302c323530293b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a2020202070616464696e673a203470783b0d0a7d0d0a2e626f74746f6d4469764d656e75202e7364646d206469762064697620613a686f766572207b0d0a202020206261636b67726f756e642d636f6c6f723a20726762283234302c3234302c323430293b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a2020202070616464696e673a203370782033707820337078203470783b0d0a7d0d0a2e626f74746f6d4469764d656e75202e7364646d20646976206469762061207b0d0a202020206261636b67726f756e642d636f6c6f723a20726762283235302c3235302c323530293b0d0a2020202070616464696e673a203470783b0d0a7d0d0a2e626f74746f6d4469764d656e75202e7364646d206469762064697620612e7364646d53656c6563746564207b0d0a20202020666f6e742d7765696768743a20626f6c643b0d0a20202020636f6c6f723a626c61636b3b0d0a7d0d0a2e626f74746f6d4469764d656e75202e7364646d2064697620612e7364646d4669727374207b0d0a2020202070616464696e672d6c6566743a203070783b0d0a20202020626f726465722d6c6566743a20307078206e6f6e653b0d0a7d, 'Bottom Menu');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=98 ;

--
-- Daten für Tabelle `t_module`
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
(93, 'User Friend Requests', 'userFriendRequest', 'modules/users/UserFriendRequestModule.php', NULL, 'UserFriendRequestModule', 1, 0, 0, 1),
(94, 'User Search New Users', 'userSearchNew', 'modules/users/userSearchNewUsersModule.php', NULL, 'UserSearchNewUsersModule', 1, 0, 0, 1),
(95, 'User Search Recent Active', 'userSearchActive', 'modules/users/userSearchActiveUsersModule.php', NULL, 'UserSearchActiveUsersModule', 1, 0, 0, 1),
(96, 'User Profile Image', 'userProfileImage', 'modules/users/userProfileImageModule.php', NULL, 'UserProfileImageModule', 1, 0, 0, 1),
(97, 'Admin Social Notifications', 'adminSocialNotifications', 'modules/admin/adminSocialNotificationsModule.php', NULL, 'AdminSocialNotificationsModule', 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_module_category`
--

CREATE TABLE IF NOT EXISTS `t_module_category` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `position` int(10) NOT NULL,
  `name` varchar(200) COLLATE latin1_german2_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_module_instance`
--

CREATE TABLE IF NOT EXISTS `t_module_instance` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `moduleid` int(10) NOT NULL,
  PRIMARY KEY (`id`,`moduleid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=60 ;

--
-- Daten für Tabelle `t_module_instance`
--

INSERT INTO `t_module_instance` (`id`, `moduleid`) VALUES
(1, 13),
(2, 59),
(3, 59),
(4, 59),
(5, 70),
(6, 69),
(7, 44),
(8, 72),
(9, 40),
(10, 74),
(11, 60),
(12, 45),
(13, 87),
(14, 91),
(15, 13),
(16, 29),
(17, 82),
(18, 83),
(19, 0),
(20, 2),
(22, 82),
(23, 75),
(24, 85),
(25, 82),
(26, 87),
(27, 84),
(28, 82),
(29, 82),
(30, 86),
(31, 82),
(32, 0),
(33, 0),
(34, 13),
(35, 38),
(36, 82),
(37, 86),
(38, 82),
(39, 13),
(40, 32),
(41, 77),
(42, 92),
(43, 92),
(44, 82),
(45, 82),
(46, 93),
(47, 95),
(48, 87),
(49, 95),
(50, 87),
(51, 94),
(52, 87),
(53, 95),
(54, 85),
(55, 85),
(56, 97),
(57, 96),
(58, 82),
(59, 26);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_module_instance_params`
--

CREATE TABLE IF NOT EXISTS `t_module_instance_params` (
  `instanceid` int(10) DEFAULT NULL,
  `moduleid` int(11) DEFAULT NULL,
  `name` varchar(100) COLLATE latin1_german2_ci NOT NULL,
  `value` blob NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci;

--
-- Daten für Tabelle `t_module_instance_params`
--

INSERT INTO `t_module_instance_params` (`instanceid`, `moduleid`, `name`, `value`) VALUES
(2, NULL, 'selectedStyle', 0x733a313a2231223b),
(3, NULL, 'selectedStyle', 0x733a313a2231223b),
(4, NULL, 'selectedStyle', 0x733a313a2231223b),
(1, NULL, 'networks', 0x623a313b),
(1, NULL, 'register', 0x623a313b),
(1, NULL, 'reset', 0x623a313b),
(3, NULL, 'selectedMenu', 0x733a313a2231223b),
(4, NULL, 'selectedMenu', 0x733a313a2233223b),
(15, NULL, 'networks', 0x623a313b),
(15, NULL, 'register', 0x623a313b),
(15, NULL, 'reset', 0x623a313b),
(16, NULL, 'userRoles', 0x613a313a7b693a303b733a313a2238223b7d),
(16, NULL, 'requireConfirmEmail', 0x733a313a2230223b),
(22, NULL, 'mode', 0x733a313a2231223b),
(17, NULL, 'mode', 0x733a313a2232223b),
(25, NULL, 'mode', 0x733a313a2232223b),
(29, NULL, 'mode', 0x733a313a2232223b),
(31, NULL, 'mode', 0x733a313a2232223b),
(27, NULL, 'mode', 0x733a313a2233223b),
(24, NULL, 'mode', 0x733a313a2232223b),
(2, NULL, 'selectedMenu', 0x733a313a2233223b),
(34, NULL, 'networks', 0x623a313b),
(34, NULL, 'register', 0x623a313b),
(34, NULL, 'reset', 0x623a313b),
(36, NULL, 'mode', 0x733a313a2231223b),
(38, NULL, 'mode', 0x733a313a2231223b),
(39, NULL, 'networks', 0x623a313b),
(39, NULL, 'register', 0x623a313b),
(39, NULL, 'reset', 0x623a313b),
(2, NULL, 'selectedStyle', 0x733a313a2231223b),
(3, NULL, 'selectedStyle', 0x733a313a2231223b),
(4, NULL, 'selectedStyle', 0x733a313a2231223b),
(1, NULL, 'networks', 0x623a313b),
(1, NULL, 'register', 0x623a313b),
(1, NULL, 'reset', 0x623a313b),
(3, NULL, 'selectedMenu', 0x733a313a2231223b),
(4, NULL, 'selectedMenu', 0x733a313a2233223b),
(15, NULL, 'networks', 0x623a313b),
(15, NULL, 'register', 0x623a313b),
(15, NULL, 'reset', 0x623a313b),
(16, NULL, 'userRoles', 0x613a313a7b693a303b733a313a2238223b7d),
(16, NULL, 'requireConfirmEmail', 0x733a313a2230223b),
(22, NULL, 'mode', 0x733a313a2231223b),
(17, NULL, 'mode', 0x733a313a2232223b),
(25, NULL, 'mode', 0x733a313a2232223b),
(29, NULL, 'mode', 0x733a313a2232223b),
(31, NULL, 'mode', 0x733a313a2232223b),
(27, NULL, 'mode', 0x733a313a2233223b),
(24, NULL, 'mode', 0x733a313a2232223b),
(2, NULL, 'selectedMenu', 0x733a313a2233223b),
(34, NULL, 'networks', 0x623a313b),
(34, NULL, 'register', 0x623a313b),
(34, NULL, 'reset', 0x623a313b),
(36, NULL, 'mode', 0x733a313a2231223b),
(38, NULL, 'mode', 0x733a313a2231223b),
(39, NULL, 'networks', 0x623a313b),
(39, NULL, 'register', 0x623a313b),
(39, NULL, 'reset', 0x623a313b),
(44, NULL, 'mode', 0x733a313a2232223b),
(45, NULL, 'mode', 0x733a313a2231223b),
(46, NULL, 'mode', 0x733a313a2231223b),
(28, NULL, 'mode', 0x733a313a2232223b),
(30, NULL, 'mode', 0x733a313a2231223b),
(42, NULL, 'mode', 0x733a313a2232223b),
(54, NULL, 'mode', 0x733a313a2232223b),
(55, NULL, 'mode', 0x733a313a2231223b),
(57, NULL, 'mode', 0x733a313a2232223b),
(58, NULL, 'mode', 0x733a313a2232223b),
(2, NULL, 'selectedStyle', 0x733a313a2231223b),
(3, NULL, 'selectedStyle', 0x733a313a2231223b),
(4, NULL, 'selectedStyle', 0x733a313a2231223b),
(1, NULL, 'networks', 0x623a313b),
(1, NULL, 'register', 0x623a313b),
(1, NULL, 'reset', 0x623a313b),
(3, NULL, 'selectedMenu', 0x733a313a2231223b),
(4, NULL, 'selectedMenu', 0x733a313a2233223b),
(15, NULL, 'networks', 0x623a313b),
(15, NULL, 'register', 0x623a313b),
(15, NULL, 'reset', 0x623a313b),
(16, NULL, 'userRoles', 0x613a313a7b693a303b733a313a2238223b7d),
(16, NULL, 'requireConfirmEmail', 0x733a313a2230223b),
(22, NULL, 'mode', 0x733a313a2231223b),
(17, NULL, 'mode', 0x733a313a2232223b),
(25, NULL, 'mode', 0x733a313a2232223b),
(29, NULL, 'mode', 0x733a313a2232223b),
(31, NULL, 'mode', 0x733a313a2232223b),
(27, NULL, 'mode', 0x733a313a2233223b),
(24, NULL, 'mode', 0x733a313a2232223b),
(2, NULL, 'selectedMenu', 0x733a313a2233223b),
(34, NULL, 'networks', 0x623a313b),
(34, NULL, 'register', 0x623a313b),
(34, NULL, 'reset', 0x623a313b),
(36, NULL, 'mode', 0x733a313a2231223b),
(38, NULL, 'mode', 0x733a313a2231223b),
(39, NULL, 'networks', 0x623a313b),
(39, NULL, 'register', 0x623a313b),
(39, NULL, 'reset', 0x623a313b),
(2, NULL, 'selectedStyle', 0x733a313a2231223b),
(3, NULL, 'selectedStyle', 0x733a313a2231223b),
(4, NULL, 'selectedStyle', 0x733a313a2231223b),
(1, NULL, 'networks', 0x623a313b),
(1, NULL, 'register', 0x623a313b),
(1, NULL, 'reset', 0x623a313b),
(3, NULL, 'selectedMenu', 0x733a313a2231223b),
(4, NULL, 'selectedMenu', 0x733a313a2233223b),
(15, NULL, 'networks', 0x623a313b),
(15, NULL, 'register', 0x623a313b),
(15, NULL, 'reset', 0x623a313b),
(16, NULL, 'userRoles', 0x613a313a7b693a303b733a313a2238223b7d),
(16, NULL, 'requireConfirmEmail', 0x733a313a2230223b),
(22, NULL, 'mode', 0x733a313a2231223b),
(17, NULL, 'mode', 0x733a313a2232223b),
(25, NULL, 'mode', 0x733a313a2232223b),
(29, NULL, 'mode', 0x733a313a2232223b),
(31, NULL, 'mode', 0x733a313a2232223b),
(27, NULL, 'mode', 0x733a313a2233223b),
(24, NULL, 'mode', 0x733a313a2232223b),
(2, NULL, 'selectedMenu', 0x733a313a2233223b),
(34, NULL, 'networks', 0x623a313b),
(34, NULL, 'register', 0x623a313b),
(34, NULL, 'reset', 0x623a313b),
(36, NULL, 'mode', 0x733a313a2231223b),
(38, NULL, 'mode', 0x733a313a2231223b),
(39, NULL, 'networks', 0x623a313b),
(39, NULL, 'register', 0x623a313b),
(39, NULL, 'reset', 0x623a313b),
(44, NULL, 'mode', 0x733a313a2232223b),
(45, NULL, 'mode', 0x733a313a2231223b),
(46, NULL, 'mode', 0x733a313a2231223b),
(28, NULL, 'mode', 0x733a313a2232223b),
(30, NULL, 'mode', 0x733a313a2231223b),
(42, NULL, 'mode', 0x733a313a2232223b),
(54, NULL, 'mode', 0x733a313a2232223b),
(55, NULL, 'mode', 0x733a313a2231223b),
(57, NULL, 'mode', 0x733a313a2232223b),
(58, NULL, 'mode', 0x733a313a2232223b);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_module_roles`
--

CREATE TABLE IF NOT EXISTS `t_module_roles` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `customrole` int(10) NOT NULL,
  `modulerole` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1996 ;

--
-- Daten für Tabelle `t_module_roles`
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
(1892, 10, 'wysiwyg.edit'),
(1893, 10, 'login.edit'),
(1894, 10, 'newsletter.edit'),
(1895, 10, 'newsletter.send'),
(1896, 10, 'products.edit'),
(1897, 10, 'products.view'),
(1898, 10, 'roles.register.edit'),
(1899, 10, 'users.edit'),
(1900, 10, 'sitemap.edit'),
(1901, 10, 'modules.insert'),
(1902, 10, 'forum.topic.create'),
(1903, 10, 'forum.thread.create'),
(1904, 10, 'forum.view'),
(1905, 10, 'forum.admin'),
(1906, 10, 'forum.moderator'),
(1907, 10, 'forum.thread.post'),
(1908, 10, 'chat.user'),
(1909, 10, 'chat.view'),
(1910, 10, 'comment.post'),
(1911, 10, 'comment.edit'),
(1912, 10, 'comment.delete'),
(1913, 10, 'comment.show.email'),
(1914, 10, 'backup.create'),
(1915, 10, 'backup.load'),
(1916, 10, 'backup.delete'),
(1917, 10, 'users.register.edit'),
(1918, 10, 'user.info.edit'),
(1919, 10, 'user.info.admin'),
(1920, 10, 'user.info.owner'),
(1921, 10, 'admin.roles.edit'),
(1922, 10, 'gallery.edit'),
(1923, 10, 'gallery.view'),
(1924, 10, 'gallery.owner'),
(1925, 10, 'message.inbox'),
(1926, 10, 'events.callender'),
(1927, 10, 'events.list'),
(1928, 10, 'events.edit'),
(1929, 10, 'template.edit'),
(1930, 10, 'template.view'),
(1931, 10, 'domains.edit'),
(1932, 10, 'domains.view'),
(1933, 10, 'orders.edit'),
(1934, 10, 'orders.view'),
(1935, 10, 'orders.all'),
(1936, 10, 'orders.confirm'),
(1937, 10, 'orders.finnish'),
(1938, 10, 'dm.tables.config'),
(1939, 10, 'dm.forms.edit'),
(1940, 10, 'shop.basket.view'),
(1941, 10, 'shop.basket.status.edit'),
(1942, 10, 'shop.basket.edit'),
(1943, 10, 'shop.basket.details.view'),
(1944, 10, 'shop.basket.details.edit'),
(1945, 10, 'slideshow.edit'),
(1946, 10, 'filesystem.all'),
(1947, 10, 'filesystem.user'),
(1948, 10, 'filesystem.www'),
(1949, 10, 'filesystem.edit'),
(1950, 10, 'events.users.all'),
(1951, 10, 'menu.edit'),
(1952, 10, 'pages.editmenu'),
(1953, 10, 'pages.edit'),
(1954, 10, 'payment.edit'),
(1955, 10, 'social.edit'),
(1956, 10, 'admin.edit'),
(1957, 10, 'site.edit'),
(1958, 10, 'site.view'),
(1959, 10, 'translations.edit'),
(1960, 10, 'emailList.edit'),
(1961, 10, 'emailSent.edit'),
(1962, 10, 'ukash.edit'),
(1963, 10, 'user.profile.edit'),
(1964, 10, 'user.profile.view'),
(1965, 10, 'user.profile.owner'),
(1966, 10, 'message.edit'),
(1967, 10, 'user.search.edit'),
(1968, 10, 'user.search.view'),
(1969, 10, 'user.friend.edit'),
(1970, 10, 'user.friend.view'),
(1971, 10, 'user.friendRequest.edit'),
(1972, 10, 'user.friendRequest.view'),
(1973, 10, 'user.image.edit'),
(1974, 10, 'user.image.view'),
(1975, 10, 'user.image.own'),
(1976, 10, 'adminSocialNotifications.edit'),
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
(1995, 8, 'user.image.view');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_newsletter`
--

CREATE TABLE IF NOT EXISTS `t_newsletter` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `text` blob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `t_newsletter`
--

INSERT INTO `t_newsletter` (`id`, `name`, `text`) VALUES
(1, 'teste', 0x746573617465736174657374657374);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_newsletter_email`
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
-- Tabellenstruktur für Tabelle `t_newsletter_emailgroup`
--

CREATE TABLE IF NOT EXISTS `t_newsletter_emailgroup` (
  `emailid` int(10) NOT NULL AUTO_INCREMENT,
  `roleid` int(50) NOT NULL,
  PRIMARY KEY (`emailid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_order`
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
-- Tabellenstruktur für Tabelle `t_order_attribute`
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
-- Tabellenstruktur für Tabelle `t_order_product`
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
  `codeid` int(10) DEFAULT NULL,
  `pagetrackerscript` blob,
  `modifydate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;

--
-- Daten für Tabelle `t_page`
--

INSERT INTO `t_page` (`id`, `type`, `namecode`, `welcome`, `title`, `keywords`, `description`, `template`, `siteid`, `code`, `codeid`, `pagetrackerscript`, `modifydate`) VALUES
(1, 0, 1, 0, 'login', 0x6c6f67696e, 0x6c6f67696e, 5, 1, 'login', 1, NULL, '2014-05-12 13:22:52'),
(2, 0, 2, 0, 'adminPages', 0x61646d696e5061676573, 0x61646d696e5061676573, 5, 1, 'adminPages', 5, NULL, '2014-05-12 13:23:20'),
(3, 0, 3, 0, 'startup', 0x73746172747570, 0x73746172747570, 5, 1, 'startup', 7, NULL, '2014-05-12 13:23:21'),
(4, 0, 4, 0, 'adminSites', 0x61646d696e5369746573, 0x61646d696e5369746573, 5, 1, 'adminSites', 8, NULL, '2014-05-12 13:23:26'),
(5, 0, 5, 0, 'adminDomains', 0x61646d696e446f6d61696e73, 0x61646d696e446f6d61696e73, 5, 1, 'adminDomains', 9, NULL, '2014-05-12 13:23:29'),
(6, 0, 6, 0, 'adminPackage', 0x61646d696e5061636b616765, 0x61646d696e5061636b616765, 5, 1, 'adminPackage', 10, NULL, '2014-05-12 13:24:56'),
(7, 0, 7, 0, 'pageConfig', 0x70616765436f6e666967, 0x70616765436f6e666967, 5, 1, 'pageConfig', 11, NULL, '2014-05-13 06:49:09'),
(8, 0, 8, 1, 'Online Dating', 0x4f6e6c696e6520446174696e67, 0x4f6e6c696e6520446174696e67, 4, 1, '', NULL, NULL, '2014-05-13 12:21:59'),
(9, 0, 9, 0, '', '', '', 3, 1, '', NULL, NULL, '2014-05-13 06:49:34'),
(10, 0, 10, 0, '', '', '', 3, 1, '', NULL, NULL, '2014-05-13 06:49:57'),
(11, 0, 11, 0, 'insertModule', 0x696e736572744d6f64756c65, 0x696e736572744d6f64756c65, 5, 1, 'insertModule', 12, NULL, '2014-05-13 06:50:02'),
(12, 0, 12, 0, 'userSearchResult', 0x75736572536561726368526573756c74, 0x75736572536561726368526573756c74, 3, 1, 'userSearchResult', 14, NULL, '2014-05-13 07:57:22'),
(13, 0, 13, 0, '', '', '', 5, 1, '', NULL, NULL, '2014-05-13 07:59:23'),
(14, 0, 14, 0, 'register', 0x7265676973746572, 0x7265676973746572, 5, 1, 'register', 16, NULL, '2014-05-13 08:00:20'),
(15, 0, 15, 0, 'userProfile', 0x7573657250726f66696c65, 0x7573657250726f66696c65, 3, 1, 'userProfile', 17, NULL, '2014-05-13 08:01:21'),
(16, 0, 16, 0, 'userDetails', 0x7573657244657461696c73, 0x7573657244657461696c73, 3, 1, 'userDetails', 18, NULL, '2014-05-13 08:07:53'),
(17, 0, 17, 0, 'profile', 0x70726f66696c65, 0x70726f66696c65, 5, 1, 'profile', 19, NULL, '2014-05-13 08:08:30'),
(18, 0, 18, 0, 'adminTranslations', 0x61646d696e5472616e736c6174696f6e73, 0x61646d696e5472616e736c6174696f6e73, 5, 1, 'adminTranslations', 23, NULL, '2014-05-13 10:57:16'),
(19, 0, 19, 0, 'userWall', 0x7573657257616c6c, 0x7573657257616c6c, 3, 1, 'userWall', 24, NULL, '2014-05-13 11:15:40'),
(20, 0, 20, 0, 'userGallery', 0x7573657247616c6c657279, 0x7573657247616c6c657279, 3, 1, 'userGallery', 27, NULL, '2014-06-13 19:26:49'),
(21, 0, 21, 0, 'userMessage', 0x757365724d657373616765, 0x757365724d657373616765, 3, 1, 'userMessage', 30, NULL, '2014-05-13 11:38:32'),
(22, 0, 22, 0, 'userFriends', 0x75736572467269656e6473, 0x75736572467269656e6473, 5, 1, 'userFriends', 32, NULL, '2014-05-13 11:39:48'),
(23, 0, 23, 0, 'userAddFriends', 0x75736572416464467269656e6473, 0x75736572416464467269656e6473, 5, 1, 'userAddFriends', 33, NULL, '2014-05-13 11:42:02'),
(24, 0, 24, 0, '', '', '', 5, 1, '', NULL, NULL, '2014-05-13 12:07:33'),
(25, 0, 25, 0, '', '', '', 5, 1, '', NULL, NULL, '2014-05-13 12:08:22'),
(26, 0, 26, 0, '', '', '', 5, 1, '', NULL, NULL, '2014-05-13 12:09:53'),
(27, 0, 27, 0, 'adminTemplates', 0x61646d696e54656d706c61746573, 0x61646d696e54656d706c61746573, 5, 1, 'adminTemplates', 35, NULL, '2014-05-13 12:14:19'),
(28, 0, 28, 0, 'Messages', 0x4d65737361676573, 0x4d65737361676573, 3, 1, '', NULL, NULL, '2014-05-14 06:00:13'),
(29, 0, 29, 0, 'Friends', 0x467269656e6473, 0x467269656e6473, 3, 1, '', NULL, NULL, '2014-05-14 06:01:26'),
(30, 0, 30, 0, 'Login', 0x4c6f67696e, 0x4c6f67696e, 5, 1, '', NULL, NULL, '2014-05-14 06:07:56'),
(31, 0, 31, 0, 'Logout', 0x4c6f676f7574, 0x4c6f676f7574, 5, 1, '', NULL, NULL, '2014-05-14 06:08:52'),
(32, 0, 32, 0, 'adminRoles', 0x61646d696e526f6c6573, 0x61646d696e526f6c6573, 5, 1, 'adminRoles', 40, NULL, '2014-05-14 06:15:34'),
(33, 0, 33, 0, 'unregistered', 0x756e72656769737465726564, 0x756e72656769737465726564, 0, 1, 'unregistered', 41, NULL, '2014-05-14 14:01:40'),
(34, 0, 34, 0, 'userFriend', 0x75736572467269656e64, 0x75736572467269656e64, 3, 1, 'userFriend', 42, NULL, '2014-05-15 07:01:51'),
(35, 0, 35, 0, 'Friend Requests', 0x467269656e64205265717565737473, 0x467269656e64205265717565737473, 3, 1, '', NULL, NULL, '2014-05-15 07:36:54'),
(36, 0, 36, 0, 'Search Users', 0x536561726368205573657273, 0x536561726368205573657273, 3, 1, '', NULL, NULL, '2014-05-17 07:38:35'),
(37, 0, 37, 0, '', '', '', 3, 1, '', NULL, NULL, '2014-05-17 07:38:51'),
(38, 0, 38, 0, '', '', '', 3, 1, '', NULL, NULL, '2014-05-17 07:39:56'),
(39, 0, 39, 0, 'adminSocialNotifications', 0x61646d696e536f6369616c4e6f74696669636174696f6e73, 0x61646d696e536f6369616c4e6f74696669636174696f6e73, 5, 1, 'adminSocialNotifications', 56, NULL, '2014-06-11 12:26:46'),
(40, 0, 40, 0, 'userProfileImage', 0x7573657250726f66696c65496d616765, 0x7573657250726f66696c65496d616765, 3, 1, 'userProfileImage', 57, NULL, '2014-06-13 17:28:23'),
(41, 0, 41, 0, 'Chat', 0x43686174, 0x43686174, 5, 1, '', NULL, NULL, '2014-06-18 12:12:47');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_page_roles`
--

CREATE TABLE IF NOT EXISTS `t_page_roles` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `roleid` int(10) NOT NULL,
  `pageid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=263 ;

--
-- Daten für Tabelle `t_page_roles`
--

INSERT INTO `t_page_roles` (`id`, `roleid`, `pageid`) VALUES
(1, 7, 1),
(2, 8, 1),
(3, 9, 1),
(4, 10, 1),
(5, 13, 1),
(6, 7, 2),
(7, 8, 2),
(8, 9, 2),
(9, 10, 2),
(10, 13, 2),
(11, 7, 3),
(12, 8, 3),
(13, 9, 3),
(14, 10, 3),
(15, 13, 3),
(16, 7, 4),
(17, 8, 4),
(18, 9, 4),
(19, 10, 4),
(20, 13, 4),
(21, 7, 5),
(22, 8, 5),
(23, 9, 5),
(24, 10, 5),
(25, 13, 5),
(26, 7, 6),
(27, 8, 6),
(28, 9, 6),
(29, 10, 6),
(30, 13, 6),
(31, 7, 7),
(32, 8, 7),
(33, 9, 7),
(34, 10, 7),
(35, 13, 7),
(188, 10, 28),
(187, 9, 28),
(186, 8, 28),
(208, 10, 8),
(207, 7, 8),
(98, 13, 9),
(97, 10, 9),
(96, 9, 9),
(95, 8, 9),
(45, 7, 10),
(46, 8, 10),
(47, 9, 10),
(48, 10, 10),
(49, 13, 10),
(50, 7, 11),
(51, 8, 11),
(52, 9, 11),
(53, 10, 11),
(54, 13, 11),
(118, 13, 12),
(117, 10, 12),
(116, 9, 12),
(115, 8, 12),
(114, 7, 12),
(60, 7, 13),
(61, 8, 13),
(62, 9, 13),
(63, 10, 13),
(64, 13, 13),
(65, 7, 14),
(66, 8, 14),
(67, 9, 14),
(68, 10, 14),
(69, 13, 14),
(89, 13, 15),
(88, 10, 15),
(87, 9, 15),
(86, 8, 15),
(85, 7, 15),
(133, 13, 16),
(132, 10, 16),
(131, 9, 16),
(130, 8, 16),
(129, 7, 16),
(80, 7, 17),
(81, 8, 17),
(82, 9, 17),
(83, 10, 17),
(84, 13, 17),
(99, 7, 18),
(100, 8, 18),
(101, 9, 18),
(102, 10, 18),
(103, 13, 18),
(113, 13, 19),
(112, 10, 19),
(111, 9, 19),
(110, 8, 19),
(109, 7, 19),
(128, 13, 20),
(127, 10, 20),
(126, 9, 20),
(125, 8, 20),
(124, 7, 20),
(143, 13, 21),
(142, 10, 21),
(141, 9, 21),
(140, 8, 21),
(139, 7, 21),
(144, 7, 22),
(145, 8, 22),
(146, 9, 22),
(147, 10, 22),
(148, 13, 22),
(149, 7, 23),
(150, 8, 23),
(151, 9, 23),
(152, 10, 23),
(153, 13, 23),
(154, 7, 24),
(155, 8, 24),
(156, 9, 24),
(157, 10, 24),
(158, 13, 24),
(159, 7, 25),
(160, 8, 25),
(161, 9, 25),
(162, 10, 25),
(163, 13, 25),
(164, 7, 26),
(165, 8, 26),
(166, 9, 26),
(167, 10, 26),
(168, 13, 26),
(174, 7, 27),
(175, 8, 27),
(176, 9, 27),
(177, 10, 27),
(178, 13, 27),
(189, 13, 28),
(190, 8, 29),
(191, 9, 29),
(192, 10, 29),
(193, 13, 29),
(194, 7, 30),
(195, 10, 30),
(196, 8, 31),
(197, 9, 31),
(198, 10, 31),
(199, 13, 31),
(200, 7, 32),
(201, 8, 32),
(202, 9, 32),
(203, 10, 32),
(204, 13, 32),
(209, 7, 33),
(210, 8, 33),
(211, 9, 33),
(212, 10, 33),
(213, 13, 33),
(223, 13, 34),
(222, 10, 34),
(221, 9, 34),
(220, 8, 34),
(219, 7, 34),
(224, 7, 35),
(225, 8, 35),
(226, 9, 35),
(227, 10, 35),
(228, 13, 35),
(229, 7, 36),
(230, 8, 36),
(231, 9, 36),
(232, 10, 36),
(233, 13, 36),
(234, 7, 37),
(235, 8, 37),
(236, 9, 37),
(237, 10, 37),
(238, 13, 37),
(239, 7, 38),
(240, 8, 38),
(241, 9, 38),
(242, 10, 38),
(243, 13, 38),
(244, 7, 39),
(245, 8, 39),
(246, 9, 39),
(247, 10, 39),
(248, 13, 39),
(258, 13, 40),
(257, 10, 40),
(256, 9, 40),
(255, 8, 40),
(254, 7, 40),
(259, 8, 41),
(260, 9, 41),
(261, 10, 41),
(262, 13, 41);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_product`
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
-- Tabellenstruktur für Tabelle `t_product_group`
--

CREATE TABLE IF NOT EXISTS `t_product_group` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `namecode` int(10) NOT NULL,
  `parent` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_product_group_module`
--

CREATE TABLE IF NOT EXISTS `t_product_group_module` (
  `moduleid` int(10) NOT NULL,
  `groupid` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_roles`
--

CREATE TABLE IF NOT EXISTS `t_roles` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `userid` int(10) NOT NULL,
  `roleid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Daten für Tabelle `t_roles`
--

INSERT INTO `t_roles` (`id`, `name`, `userid`, `roleid`) VALUES
(1, '7', 1, 7),
(2, '8', 1, 8),
(3, '9', 1, 9),
(4, '10', 1, 10),
(5, '13', 1, 13);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_roles_custom`
--

CREATE TABLE IF NOT EXISTS `t_roles_custom` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `system` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Daten für Tabelle `t_roles_custom`
--

INSERT INTO `t_roles_custom` (`id`, `name`, `system`) VALUES
(7, 'guest', 1),
(8, 'user', 1),
(9, 'moderator', 1),
(10, 'admin', 1),
(13, 'newsletter', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_session`
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
-- Tabellenstruktur für Tabelle `t_site`
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
  `twitterkey` blob NOT NULL,
  `twittersecret` blob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_site_users`
--

CREATE TABLE IF NOT EXISTS `t_site_users` (
  `siteid` int(11) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_social_notifications`
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
-- Daten für Tabelle `t_social_notifications`
--

INSERT INTO `t_social_notifications` (`id`, `siteid`, `friend_request`, `friend_confirmed`, `wall_post`, `wall_reply`, `message_received`, `sender_email`, `friend_request_title`, `friend_confirmed_title`, `wall_post_title`, `wall_reply_title`, `message_received_title`) VALUES
(1, 1, 0x667269656e64526571756573742e6465736372697074696f6e, 0x667269656e64436f6e6669726d65642e6465736372697074696f6e, 0x77616c6c506f73742e6465736372697074696f6e, 0x77616c6c5265706c792e6465736372697074696f6e, 0x6d65737361676552656365697665642e6465736372697074696f6e, 0x6e6f2d7265706c79406c6f63616c686f73742e636f6d, 0x667269656e64526571756573742e7375626a656374, 0x667269656e64436f6e6669726d65642e7375626a656374, 0x77616c6c506f73742e7375626a656374, 0x77616c6c5265706c792e7375626a656374, 0x6d65737361676552656365697665642e7375626a656374);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_template`
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Daten für Tabelle `t_template`
--

INSERT INTO `t_template` (`id`, `name`, `template`, `interface`, `html`, `css`, `js`, `main`) VALUES
(2, 'Docpanel Demo Template', '', '', 0x3c64697620636c6173733d226672616d65446976223e0d0a202020203c64697620636c6173733d22746f704d656e75446976223e0d0a20202020202020203c64697620636c6173733d22746f704d656e754d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e6d656e752e746f704d656e7520636d733f2667743b0d0a2020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22686561646572446976223e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d226865616465724d656e75446976223e0d0a20202020202020203c64697620636c6173733d226865616465724d656e754d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e6d656e752e6865616465724d656e7520636d733f2667743b0d0a2020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22626f64795269676874446976223e0d0a20202020202020203c64697620636c6173733d22666c6f6174436f6e7461696e6572446976223e0d0a2020202020202020202020203c64697620636c6173733d22626f647952696768744d617267696e446976223e0d0a20202020202020202020202020202020266c743b3f636d732074656d706c6174652e617265612e726967687420636d733f2667743b0d0a202020202020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a2020202020202020202020203c2f6469763e0d0a20202020202020203c2f6469763e0d0a20202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22626f64794c656674446976223e0d0a20202020202020203c64697620636c6173733d22666c6f6174436f6e7461696e6572446976223e0d0a2020202020202020202020203c64697620636c6173733d22626f64794c6566744d617267696e446976223e0d0a20202020202020202020202020202020266c743b3f636d732074656d706c6174652e617265612e6c65667420636d733f2667743b0d0a202020202020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a2020202020202020202020203c2f6469763e0d0a20202020202020203c2f6469763e0d0a20202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22626f647944697620626f64794469764c6566744d617267696e20626f647944697652696768744d617267696e223e0d0a20202020202020203c64697620636c6173733d22666c6f6174436f6e7461696e6572446976223e0d0a2020202020202020202020203c64697620636c6173733d22626f64794d617267696e446976223e0d0a20202020202020202020202020202020266c743b3f636d732074656d706c6174652e6d61696e2e63656e74657220636d733f2667743b0d0a202020202020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a2020202020202020202020203c2f6469763e0d0a20202020202020203c2f6469763e0d0a20202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22666f6f7465724d656e75446976223e0d0a20202020202020203c64697620636c6173733d22666f6f7465724d656e754d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e6d656e752e666f6f7465724d656e7520636d733f2667743b0d0a2020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a3c2f6469763e, 0x626f6479207b0d0a2020202070616464696e673a3070783b0d0a202020206d617267696e3a3070783b0d0a7d202020200d0a2e6672616d65446976207b0d0a202020206d696e2d77696474683a2037303070783b0d0a202020206d617267696e3a2030707820313070782030707820313070783b0d0a7d0d0a2e746f704d656e75446976207b0d0a202020206d617267696e3a2030707820313070782030707820313070783b0d0a7d0d0a2e746f704d656e754d617267696e446976207b0d0a20202020666c6f61743a2072696768743b0d0a7d0d0a2e686561646572446976207b0d0a20202020636c6561723a20626f74683b0d0a202020206865696768743a2031303070783b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e6865616465724d656e75446976207b0d0a202020206d696e2d6865696768743a20333070783b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c282767726164536d616c6c2e6769662729207768697465207265706561742d783b0d0a7d0d0a2e6865616465724d656e754d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e626f6479446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f64794d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e626f64794469764c6566744d617267696e207b0d0a202020206d617267696e2d6c6566743a2032313070783b0d0a7d0d0a2e626f647944697652696768744d617267696e207b0d0a202020206d617267696e2d72696768743a2032313070783b0d0a7d0d0a2e626f64795269676874446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a2020202077696474683a2032303070783b0d0a20202020666c6f61743a2072696768743b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f647952696768744d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e626f64794c656674446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a2020202077696474683a2032303070783b0d0a20202020666c6f61743a206c6566743b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f64794c6566744d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e666f6f7465724d656e75446976207b0d0a20202020636c6561723a20626f74683b0d0a202020206d696e2d6865696768743a20333070783b0d0a202020206d617267696e3a2031307078203070782031307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c282767726164536d616c6c2e6769662729207768697465207265706561742d783b0d0a7d0d0a2e666f6f7465724d656e754d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e666c6f6174436f6e7461696e6572446976207b0d0a20202020666c6f61743a6c6566743b0d0a2020202077696474683a313030253b0d0a7d, '', 0),
(3, 'Docpanel Left Demo Template', '', '', 0x3c64697620636c6173733d226672616d65446976223e0d0a202020203c64697620636c6173733d22746f704d656e75446976223e0d0a20202020202020203c64697620636c6173733d22746f704d656e754d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e6d656e752e746f704d656e7520636d733f2667743b0d0a2020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22686561646572446976223e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d226865616465724d656e75446976223e0d0a20202020202020203c64697620636c6173733d226865616465724d656e754d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e6d656e752e6865616465724d656e7520636d733f2667743b0d0a2020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22626f64794c656674446976223e0d0a20202020202020203c64697620636c6173733d22666c6f6174436f6e7461696e6572446976223e0d0a2020202020202020202020203c64697620636c6173733d22626f64794c6566744d617267696e446976223e0d0a20202020202020202020202020202020266c743b3f636d732074656d706c6174652e617265612e6c65667420636d733f2667743b0d0a202020202020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a2020202020202020202020203c2f6469763e0d0a20202020202020203c2f6469763e0d0a20202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22626f647944697620626f64794469764c6566744d617267696e223e0d0a20202020202020203c64697620636c6173733d22666c6f6174436f6e7461696e6572446976223e0d0a2020202020202020202020203c64697620636c6173733d22626f64794d617267696e446976223e0d0a20202020202020202020202020202020266c743b3f636d732074656d706c6174652e6d61696e2e63656e74657220636d733f2667743b0d0a202020202020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a2020202020202020202020203c2f6469763e0d0a20202020202020203c2f6469763e0d0a20202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22666f6f7465724d656e75446976223e0d0a20202020202020203c64697620636c6173733d22666f6f7465724d656e754d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e6d656e752e666f6f7465724d656e7520636d733f2667743b0d0a2020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a3c2f6469763e, 0x626f6479207b0d0a2020202070616464696e673a3070783b0d0a202020206d617267696e3a3070783b0d0a7d202020200d0a2e6672616d65446976207b0d0a202020206d696e2d77696474683a2037303070783b0d0a202020206d617267696e3a2030707820313070782030707820313070783b0d0a7d0d0a2e746f704d656e75446976207b0d0a202020206d617267696e3a2030707820313070782030707820313070783b0d0a7d0d0a2e746f704d656e754d617267696e446976207b0d0a20202020666c6f61743a2072696768743b0d0a7d0d0a2e686561646572446976207b0d0a20202020636c6561723a20626f74683b0d0a202020206865696768743a2031303070783b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e6865616465724d656e75446976207b0d0a202020206d696e2d6865696768743a20333070783b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c282767726164536d616c6c2e6769662729207768697465207265706561742d783b0d0a7d0d0a2e6865616465724d656e754d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e626f6479446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f64794d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e626f64794469764c6566744d617267696e207b0d0a202020206d617267696e2d6c6566743a2032303670783b0d0a7d0d0a2e626f647944697652696768744d617267696e207b0d0a202020206d617267696e2d72696768743a2032313070783b0d0a7d0d0a2e626f64795269676874446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a2020202077696474683a2032303070783b0d0a20202020666c6f61743a2072696768743b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f647952696768744d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e626f64794c656674446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a2020202077696474683a2031393470783b0d0a20202020666c6f61743a206c6566743b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f64794c6566744d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e666f6f7465724d656e75446976207b0d0a20202020636c6561723a20626f74683b0d0a202020206d696e2d6865696768743a20333070783b0d0a202020206d617267696e3a2031307078203070782031307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c282767726164536d616c6c2e6769662729207768697465207265706561742d783b0d0a7d0d0a2e666f6f7465724d656e754d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e666c6f6174436f6e7461696e6572446976207b0d0a20202020666c6f61743a6c6566743b0d0a2020202077696474683a313030253b0d0a7d, '', 0),
(4, 'Docpanel Right Demo Template', '', '', 0x3c64697620636c6173733d226672616d65446976223e0d0a202020203c64697620636c6173733d22746f704d656e75446976223e0d0a20202020202020203c64697620636c6173733d22746f704d656e754d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e6d656e752e746f704d656e7520636d733f2667743b0d0a2020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22686561646572446976223e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d226865616465724d656e75446976223e0d0a20202020202020203c64697620636c6173733d226865616465724d656e754d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e6d656e752e6865616465724d656e7520636d733f2667743b0d0a2020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22626f64795269676874446976223e0d0a20202020202020203c64697620636c6173733d22666c6f6174436f6e7461696e6572446976223e0d0a2020202020202020202020203c64697620636c6173733d22626f647952696768744d617267696e446976223e0d0a20202020202020202020202020202020266c743b3f636d732074656d706c6174652e617265612e726967687420636d733f2667743b0d0a202020202020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a2020202020202020202020203c2f6469763e0d0a20202020202020203c2f6469763e0d0a20202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22626f647944697620626f647944697652696768744d617267696e223e0d0a20202020202020203c64697620636c6173733d22666c6f6174436f6e7461696e6572446976223e0d0a2020202020202020202020203c64697620636c6173733d22626f64794d617267696e446976223e0d0a20202020202020202020202020202020266c743b3f636d732074656d706c6174652e6d61696e2e63656e74657220636d733f2667743b0d0a202020202020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a2020202020202020202020203c2f6469763e0d0a20202020202020203c2f6469763e0d0a20202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22666f6f7465724d656e75446976223e0d0a20202020202020203c64697620636c6173733d22666f6f7465724d656e754d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e6d656e752e666f6f7465724d656e7520636d733f2667743b0d0a2020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a3c2f6469763e, 0x626f6479207b0d0a2020202070616464696e673a3070783b0d0a202020206d617267696e3a3070783b0d0a7d202020200d0a2e6672616d65446976207b0d0a202020206d696e2d77696474683a2037303070783b0d0a202020206d617267696e3a2030707820313070782030707820313070783b0d0a7d0d0a2e746f704d656e75446976207b0d0a202020206d617267696e3a2030707820313070782030707820313070783b0d0a7d0d0a2e746f704d656e754d617267696e446976207b0d0a20202020666c6f61743a2072696768743b0d0a7d0d0a2e686561646572446976207b0d0a20202020636c6561723a20626f74683b0d0a202020206865696768743a2031303070783b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e6865616465724d656e75446976207b0d0a202020206d696e2d6865696768743a20333070783b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c282767726164536d616c6c2e6769662729207768697465207265706561742d783b0d0a7d0d0a2e6865616465724d656e754d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e626f6479446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f64794d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e626f64794469764c6566744d617267696e207b0d0a202020206d617267696e2d6c6566743a2032313070783b0d0a7d0d0a2e626f647944697652696768744d617267696e207b0d0a202020206d617267696e2d72696768743a2033373570783b0d0a7d0d0a2e626f64795269676874446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a2020202077696474683a2033363570783b0d0a20202020666c6f61743a2072696768743b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f647952696768744d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e626f64794c656674446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a2020202077696474683a2032303070783b0d0a20202020666c6f61743a206c6566743b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f64794c6566744d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e666f6f7465724d656e75446976207b0d0a20202020636c6561723a20626f74683b0d0a202020206d696e2d6865696768743a20333070783b0d0a202020206d617267696e3a2031307078203070782031307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c282767726164536d616c6c2e6769662729207768697465207265706561742d783b0d0a7d0d0a2e666f6f7465724d656e754d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e666c6f6174436f6e7461696e6572446976207b0d0a20202020666c6f61743a6c6566743b0d0a2020202077696474683a313030253b0d0a7d, '', 0),
(5, 'Docpanel Stack Demo Template', '', '', 0x3c64697620636c6173733d226672616d65446976223e0d0a202020203c64697620636c6173733d22746f704d656e75446976223e0d0a20202020202020203c64697620636c6173733d22746f704d656e754d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e6d656e752e746f704d656e7520636d733f2667743b0d0a2020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22686561646572446976223e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d226865616465724d656e75446976223e0d0a20202020202020203c64697620636c6173733d226865616465724d656e754d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e6d656e752e6865616465724d656e7520636d733f2667743b0d0a2020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22626f6479446976223e0d0a20202020202020203c64697620636c6173733d22666c6f6174436f6e7461696e6572446976223e0d0a2020202020202020202020203c64697620636c6173733d22626f64794d617267696e446976223e0d0a20202020202020202020202020202020266c743b3f636d732074656d706c6174652e6d61696e2e63656e74657220636d733f2667743b3c64697620636c6173733d22636c656172223e3c2f6469763e0d0a2020202020202020202020203c2f6469763e0d0a20202020202020203c2f6469763e0d0a20202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22666f6f7465724d656e75446976223e0d0a20202020202020203c64697620636c6173733d22666f6f7465724d656e754d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e6d656e752e666f6f7465724d656e7520636d733f2667743b0d0a2020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a3c2f6469763e, 0x626f6479207b0d0a2020202070616464696e673a3070783b0d0a202020206d617267696e3a3070783b0d0a7d202020200d0a2e6672616d65446976207b0d0a202020206d696e2d77696474683a2037303070783b0d0a202020206d617267696e3a2030707820313070782030707820313070783b0d0a7d0d0a2e746f704d656e75446976207b0d0a202020206d617267696e3a2030707820313070782030707820313070783b0d0a7d0d0a2e746f704d656e754d617267696e446976207b0d0a20202020666c6f61743a2072696768743b0d0a7d0d0a2e686561646572446976207b0d0a20202020636c6561723a20626f74683b0d0a202020206865696768743a2031303070783b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e6865616465724d656e75446976207b0d0a202020206d696e2d6865696768743a20333070783b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c282767726164536d616c6c2e6769662729207768697465207265706561742d783b0d0a7d0d0a2e6865616465724d656e754d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e626f6479446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f64794d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e626f64794469764c6566744d617267696e207b0d0a202020206d617267696e2d6c6566743a2032313070783b0d0a7d0d0a2e626f647944697652696768744d617267696e207b0d0a202020206d617267696e2d72696768743a2032313070783b0d0a7d0d0a2e626f64795269676874446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a2020202077696474683a2032303070783b0d0a20202020666c6f61743a2072696768743b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f647952696768744d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e626f64794c656674446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a2020202077696474683a2032303070783b0d0a20202020666c6f61743a206c6566743b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f64794c6566744d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e666f6f7465724d656e75446976207b0d0a20202020636c6561723a20626f74683b0d0a202020206d696e2d6865696768743a20333070783b0d0a202020206d617267696e3a2031307078203070782031307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c282767726164536d616c6c2e6769662729207768697465207265706561742d783b0d0a7d0d0a2e666f6f7465724d656e754d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e666c6f6174436f6e7461696e6572446976207b0d0a20202020666c6f61743a6c6566743b0d0a2020202077696474683a313030253b0d0a7d, '', 1),
(1, 'Admin Template', 'core/template/adminTemplate.php', 'AdminTemplate', NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_templatearea`
--

CREATE TABLE IF NOT EXISTS `t_templatearea` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `instanceid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `pageid` int(10) NOT NULL,
  `position` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=60 ;

--
-- Daten für Tabelle `t_templatearea`
--

INSERT INTO `t_templatearea` (`id`, `instanceid`, `name`, `pageid`, `position`) VALUES
(1, 1, 'center', 1, 0),
(2, 2, 'topMenu', 0, 0),
(3, 3, 'headerMenu', 0, 0),
(4, 4, 'footerMenu', 0, 0),
(5, 5, 'center', 2, 0),
(6, 6, 'adminMenu', 0, 0),
(7, 7, 'center', 3, 0),
(8, 8, 'center', 4, 0),
(9, 9, 'center', 5, 0),
(10, 10, 'center', 6, 0),
(11, 11, 'center', 7, 0),
(12, 12, 'center', 11, 0),
(13, 13, 'left', 10, 0),
(14, 14, 'center', 12, 0),
(15, 15, 'center', 13, 0),
(16, 16, 'center', 14, 0),
(17, 17, 'left', 15, 0),
(18, 18, 'center', 16, 0),
(19, 19, 'center', 17, 0),
(20, 20, 'center', 8, 1),
(34, 34, 'right', 8, 0),
(22, 22, 'left', 9, 0),
(23, 23, 'center', 18, 0),
(24, 24, 'center', 19, 0),
(25, 25, 'left', 19, 0),
(26, 26, 'left', 12, 0),
(27, 27, 'center', 20, 0),
(28, 28, 'left', 20, 0),
(29, 29, 'left', 16, 0),
(30, 30, 'center', 21, 0),
(31, 31, 'left', 21, 0),
(32, 32, 'center', 22, 0),
(33, 33, 'center', 23, 0),
(35, 35, 'center', 27, 0),
(36, 36, 'left', 28, 0),
(37, 37, 'center', 28, 0),
(38, 38, 'left', 29, 0),
(39, 39, 'center', 31, 0),
(40, 40, 'center', 32, 0),
(41, 41, '', 33, 0),
(42, 42, 'center', 34, 0),
(43, 43, 'center', 29, 0),
(44, 44, 'left', 34, 0),
(45, 45, 'left', 35, 0),
(46, 46, 'center', 35, 0),
(47, 47, 'center', 10, 0),
(48, 48, 'left', 36, 0),
(49, 49, 'center', 36, 0),
(50, 50, 'left', 37, 0),
(51, 51, 'center', 37, 0),
(52, 52, 'left', 38, 0),
(53, 53, 'center', 38, 0),
(54, 54, 'center', 15, 0),
(55, 55, 'center', 9, 0),
(56, 56, 'center', 39, 0),
(57, 57, 'center', 40, 0),
(58, 58, 'left', 40, 0),
(59, 59, 'center', 41, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_track`
--

CREATE TABLE IF NOT EXISTS `t_track` (
  `clientip` blob NOT NULL,
  `href` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_user`
--

CREATE TABLE IF NOT EXISTS `t_user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `authkey` varchar(40) DEFAULT NULL,
  `email` varchar(200) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_user_address`
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
-- Tabellenstruktur für Tabelle `t_user_friend`
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
-- Tabellenstruktur für Tabelle `t_user_message`
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
-- Tabellenstruktur für Tabelle `t_user_wall_post`
--

CREATE TABLE IF NOT EXISTS `t_user_wall_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL,
  `typeid` int(11) NOT NULL,
  `srcuserid` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `comment` blob NOT NULL,
  `parent` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_vdb_column`
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
-- Daten für Tabelle `t_vdb_column`
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
-- Tabellenstruktur für Tabelle `t_vdb_object`
--

CREATE TABLE IF NOT EXISTS `t_vdb_object` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `tableid` int(10) NOT NULL,
  `viewed` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_vdb_table`
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
-- Daten für Tabelle `t_vdb_table`
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
-- Tabellenstruktur für Tabelle `t_vdb_value`
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
-- Tabellenstruktur für Tabelle `t_wysiwygpage`
--

CREATE TABLE IF NOT EXISTS `t_wysiwygpage` (
  `id` int(10) unsigned DEFAULT NULL,
  `moduleid` int(10) unsigned DEFAULT NULL,
  `lang` varchar(5) NOT NULL,
  `content` blob,
  `title` varchar(100) DEFAULT NULL,
  `area` int(5) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `t_wysiwygpage`
--

INSERT INTO `t_wysiwygpage` (`id`, `moduleid`, `lang`, `content`, `title`, `area`) VALUES
(NULL, 20, 'en', 0x3c68313e4f6e6c696e6520446174696e673c2f68313e0d0a3c703e57656c636f6d6520746f206d79206f6e6c696e6520646174696e672e204f6e65206f66207468652066657720746f74616c792066726565206f6e6c696e6520646174696e67206e6574776f726b732e3c2f703e0d0a3c68333e4d79204f6e6c696e6520446174696e673c2f68333e0d0a3c703e4d79206f6e6c696e6520646174696e67206973206f6e65206f6620746865206f6e6c792066726565206f6e6c696e6520646174696e67206e6574776f726b732e205265676973746572206e6f7720616e6420656e6a6f792066726565206f6e6c696e6520646174696e672e205768656e2069207761732073696e676c65206920736561726368656420666f72206f6e6c696e6520646174696e672077656220736974657320616e64206576656e20706179656420746f20757365206f6e652e204920736f6f6e206e6f746963656420636f6d6d65726369616c206f6e6c696e6520646174696e672077656220736974657320617265206f667465726e207363616d7320776974682066616b652075736572732e20546865792077657265206a757374206166746572206d79206d6f6e65792e20536f2069206465636964656420746f206d616b65206d79206f776e2066726565206f6e6c696e6520646174696e672077656220736974652e20536f20686572652069742069732e20506c65617365207265676973746572206e6f7720736f207468617420776520676574206173206d616e7920757365727320617320706f737369626c652e3c2f703e, NULL, 0),
(NULL, 21, 'en', 0x3c696d6720616c743d22746f6e67756522207469746c653d22746f6e67756522207372633d22687474703a2f2f6c6f63616c686f73742f76626d73636d732f7265736f757263652f6a732f656c7274652f696d616765732f736d696c6579732f746f6e6775652e706e6722202f3e, NULL, 0),
(NULL, 20, 'en', 0x3c68313e4f6e6c696e6520446174696e673c2f68313e0d0a3c703e57656c636f6d6520746f206d79206f6e6c696e6520646174696e672e204f6e65206f66207468652066657720746f74616c792066726565206f6e6c696e6520646174696e67206e6574776f726b732e3c2f703e0d0a3c68333e4d79204f6e6c696e6520446174696e673c2f68333e0d0a3c703e4d79206f6e6c696e6520646174696e67206973206f6e65206f6620746865206f6e6c792066726565206f6e6c696e6520646174696e67206e6574776f726b732e205265676973746572206e6f7720616e6420656e6a6f792066726565206f6e6c696e6520646174696e672e205768656e2069207761732073696e676c65206920736561726368656420666f72206f6e6c696e6520646174696e672077656220736974657320616e64206576656e20706179656420746f20757365206f6e652e204920736f6f6e206e6f746963656420636f6d6d65726369616c206f6e6c696e6520646174696e672077656220736974657320617265206f667465726e207363616d7320776974682066616b652075736572732e20546865792077657265206a757374206166746572206d79206d6f6e65792e20536f2069206465636964656420746f206d616b65206d79206f776e2066726565206f6e6c696e6520646174696e672077656220736974652e20536f20686572652069742069732e20506c65617365207265676973746572206e6f7720736f207468617420776520676574206173206d616e7920757365727320617320706f737369626c652e3c2f703e, NULL, 0),
(NULL, 21, 'en', 0x3c696d6720616c743d22746f6e67756522207469746c653d22746f6e67756522207372633d22687474703a2f2f6c6f63616c686f73742f76626d73636d732f7265736f757263652f6a732f656c7274652f696d616765732f736d696c6579732f746f6e6775652e706e6722202f3e, NULL, 0),
(NULL, 20, 'en', 0x3c68313e4f6e6c696e6520446174696e673c2f68313e0d0a3c703e57656c636f6d6520746f206d79206f6e6c696e6520646174696e672e204f6e65206f66207468652066657720746f74616c792066726565206f6e6c696e6520646174696e67206e6574776f726b732e3c2f703e0d0a3c68333e4d79204f6e6c696e6520446174696e673c2f68333e0d0a3c703e4d79206f6e6c696e6520646174696e67206973206f6e65206f6620746865206f6e6c792066726565206f6e6c696e6520646174696e67206e6574776f726b732e205265676973746572206e6f7720616e6420656e6a6f792066726565206f6e6c696e6520646174696e672e205768656e2069207761732073696e676c65206920736561726368656420666f72206f6e6c696e6520646174696e672077656220736974657320616e64206576656e20706179656420746f20757365206f6e652e204920736f6f6e206e6f746963656420636f6d6d65726369616c206f6e6c696e6520646174696e672077656220736974657320617265206f667465726e207363616d7320776974682066616b652075736572732e20546865792077657265206a757374206166746572206d79206d6f6e65792e20536f2069206465636964656420746f206d616b65206d79206f776e2066726565206f6e6c696e6520646174696e672077656220736974652e20536f20686572652069742069732e20506c65617365207265676973746572206e6f7720736f207468617420776520676574206173206d616e7920757365727320617320706f737369626c652e3c2f703e, NULL, 0),
(NULL, 21, 'en', 0x3c696d6720616c743d22746f6e67756522207469746c653d22746f6e67756522207372633d22687474703a2f2f6c6f63616c686f73742f76626d73636d732f7265736f757263652f6a732f656c7274652f696d616765732f736d696c6579732f746f6e6775652e706e6722202f3e, NULL, 0),
(NULL, 20, 'en', 0x3c68313e4f6e6c696e6520446174696e673c2f68313e0d0a3c703e57656c636f6d6520746f206d79206f6e6c696e6520646174696e672e204f6e65206f66207468652066657720746f74616c792066726565206f6e6c696e6520646174696e67206e6574776f726b732e3c2f703e0d0a3c68333e4d79204f6e6c696e6520446174696e673c2f68333e0d0a3c703e4d79206f6e6c696e6520646174696e67206973206f6e65206f6620746865206f6e6c792066726565206f6e6c696e6520646174696e67206e6574776f726b732e205265676973746572206e6f7720616e6420656e6a6f792066726565206f6e6c696e6520646174696e672e205768656e2069207761732073696e676c65206920736561726368656420666f72206f6e6c696e6520646174696e672077656220736974657320616e64206576656e20706179656420746f20757365206f6e652e204920736f6f6e206e6f746963656420636f6d6d65726369616c206f6e6c696e6520646174696e672077656220736974657320617265206f667465726e207363616d7320776974682066616b652075736572732e20546865792077657265206a757374206166746572206d79206d6f6e65792e20536f2069206465636964656420746f206d616b65206d79206f776e2066726565206f6e6c696e6520646174696e672077656220736974652e20536f20686572652069742069732e20506c65617365207265676973746572206e6f7720736f207468617420776520676574206173206d616e7920757365727320617320706f737369626c652e3c2f703e, NULL, 0),
(NULL, 21, 'en', 0x3c696d6720616c743d22746f6e67756522207469746c653d22746f6e67756522207372633d22687474703a2f2f6c6f63616c686f73742f76626d73636d732f7265736f757263652f6a732f656c7274652f696d616765732f736d696c6579732f746f6e6775652e706e6722202f3e, NULL, 0);

; */ ?>