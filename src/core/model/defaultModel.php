<?php /* ;

 CREATE TABLE IF NOT EXISTS `t_backup` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
-- Tabellenstruktur für Tabelle `t_cms_customer`
--

CREATE TABLE IF NOT EXISTS `t_cms_customer` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `t_cms_customer`
--

INSERT INTO `t_cms_customer` (`id`, `userid`) VALUES
(0, 1),
(0, 2);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

--
-- Daten für Tabelle `t_code`
--

INSERT INTO `t_code` (`id`, `lang`, `code`, `value`) VALUES
(1, 'en', 1, 0x6c6f67696e),
(2, 'en', 2, 0x61646d696e5061676573),
(3, 'en', 3, 0x73746172747570),
(4, 'en', 4, 0x61646d696e5369746573),
(5, 'en', 5, 0x61646d696e54656d706c61746573),
(6, 'en', 6, 0x70616765436f6e666967),
(7, 'en', 7, 0x486f6d65),
(8, 'en', 8, 0x696e736572744d6f64756c65),
(9, 'en', 9, 0x41727469636c6573),
(10, 'en', 10, 0x5061727469636c65697a6174696f6e),
(11, 'en', 11, 0x496d7072657373756d),
(12, 'en', 12, 0x41474273),
(13, 'en', 13, 0x436f6e74616374),
(14, 'en', 14, 0x4d696e6420436f6e74726f6c),
(15, 'en', 15, 0x55464f73),
(16, 'en', 16, 0x61646d696e4d656e7573),
(17, 'en', 17, 0x4c6f67696e),
(18, 'en', 18, 0x70726f6475637447726f757073),
(19, 'en', 19, 0x61646d696e4d6f64756c6573),
(20, 'en', 20, 0x61646d696e4d6f64756c6573),
(21, 'en', 21, 0x61646d696e446f6d61696e73),
(22, 'en', 22, 0x61646d696e4d65737361676573),
(23, 'en', 23, 0x61646d696e5061636b616765),
(24, 'en', 24, 0x636f6e6669675461626c6573),
(25, 'en', 25, 0x61646d696e4e6577736c6574746572),
(26, 'en', 26, 0x61646d696e4e6577736c6574746572),
(27, 'en', 27, 0x54686520476c6f636b65),
(28, 'en', 28, 0x61646d696e5472616e736c6174696f6e73),
(29, 'en', 29, 0x50726f6a65637473),
(30, 'en', 30, 0x76626d73636d73),
(31, 'en', 31, 0x7068705061636b6572),
(32, 'en', 32, 0x7a65726f20656e657267792070756d70),
(33, 'en', 33, 0x466f726d20456469746f72),
(34, 'en', 34, 0x416e746920546572726f7269736d),
(35, 'en', 35, 0x50726f66696c65),
(36, 'en', 36, 0x53696c766573746572204dfc686c68617573),
(37, 'en', 37, 0x4672616e7369736b61204b6169736572),
(38, 'en', 38, 0x4d65646963616c);

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
-- Tabellenstruktur für Tabelle `t_domain`
--

CREATE TABLE IF NOT EXISTS `t_domain` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `url` varchar(200) NOT NULL,
  `siteid` int(10) NOT NULL,
  `domaintrackerscript` blob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `t_domain`
--

INSERT INTO `t_domain` (`id`, `url`, `siteid`, `domaintrackerscript`) VALUES
(1, 'localhost', 1, NULL);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_gallery_page`
--

CREATE TABLE IF NOT EXISTS `t_gallery_page` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `pageid` int(10) NOT NULL,
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Daten für Tabelle `t_menu`
--

INSERT INTO `t_menu` (`id`, `page`, `type`, `parent`, `active`, `lang`, `position`) VALUES
(1, 7, 1, NULL, 1, 'en', 1),
(2, 9, 1, NULL, 1, 'en', 2),
(3, 10, 1, 9, 1, 'en', 3),
(4, 11, 2, NULL, 1, 'en', 4),
(5, 12, 2, NULL, 1, 'en', 6),
(6, 13, 2, NULL, 1, 'en', 5),
(7, 14, 1, 9, 1, 'en', 7),
(8, 15, 1, 9, 1, 'en', 8),
(9, 17, 3, NULL, 1, 'en', 9),
(10, 27, 1, 9, 1, 'en', 10),
(11, 29, 1, NULL, 1, 'en', 11),
(12, 30, 1, 29, 1, 'en', 12),
(13, 31, 1, 29, 1, 'en', 13),
(14, 32, 1, 29, 1, 'en', 14),
(15, 33, 1, 29, 1, 'en', 15),
(16, 34, 1, 9, 1, 'en', 16),
(17, 35, 1, NULL, 1, 'en', 17),
(18, 36, 1, 35, 1, 'en', 18),
(19, 37, 1, 35, 1, 'en', 19),
(20, 38, 1, 9, 1, 'en', 20);

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
(2, 'Top Menu', 1),
(3, 'Bottom Menu', 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=76 ;

--
-- Daten für Tabelle `t_module`
--

INSERT INTO `t_module` (`id`, `name`, `sysname`, `include`, `description`, `interface`, `inmenu`, `category`, `position`, `static`) VALUES
(2, 'Wysiwyg Editor', '', 'modules/editor/wysiwygPageView.php', '', 'WysiwygPageView', 1, 1, 0, 0),
(13, 'Login', 'login', 'modules/users/loginModule.php', 0x616c6c6f777320796f7520746f20656e74657220616e6420657869742061646d696e206d6f6465, 'LoginModule', 1, 4, 0, 1),
(16, 'Newsletters', 'adminNewsletter', 'modules/newsletter/newsletterModule.php', '', 'NewsletterModule', 1, 3, 0, 1),
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
(75, 'Admin Translations', 'adminTranslations', 'modules/admin/adminTranslationsModule.php', NULL, 'AdminTranslationsModule', 0, 0, 0, 1);

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
  `value` blob NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci;

--
-- Daten für Tabelle `t_module_instance_params`
--

INSERT INTO `t_module_instance_params` (`instanceid`, `name`, `value`) VALUES
(2, 'selectedStyle', 0x733a313a2231223b),
(3, 'selectedStyle', 0x733a313a2231223b),
(4, 'selectedStyle', 0x733a313a2231223b),
(3, 'selectedMenu', 0x733a313a2231223b),
(2, 'selectedMenu', 0x733a313a2232223b),
(16, 'orderForm', 0x733a373a224b6f6e74616b74223b),
(16, 'roleGroup', 0x733a313a2237223b),
(16, 'sendEmail', 0x733a313a2230223b),
(16, 'captcha', 0x733a313a2231223b),
(4, 'selectedMenu', 0x733a313a2233223b);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_module_roles`
--

CREATE TABLE IF NOT EXISTS `t_module_roles` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `customrole` int(10) NOT NULL,
  `modulerole` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1316 ;

--
-- Daten für Tabelle `t_module_roles`
--

INSERT INTO `t_module_roles` (`id`, `customrole`, `modulerole`) VALUES
(1117, 8, 'forum.thread.create'),
(1118, 8, 'chat.user'),
(1119, 8, 'chat.view'),
(1120, 8, 'comment.post'),
(1121, 8, 'users.profile'),
(1122, 8, 'message.inbox'),
(1123, 8, 'events.callender'),
(1124, 8, 'events.list'),
(1125, 8, 'shop.basket.view'),
(1126, 8, 'shop.basket.details.edit'),
(1185, 7, 'products.view'),
(1186, 7, 'forum.view'),
(1187, 7, 'comment.post'),
(1188, 7, 'gallery.view'),
(1189, 7, 'shop.basket.view'),
(1190, 7, 'shop.basket.details.edit'),
(1253, 10, 'wysiwyg.edit'),
(1254, 10, 'login.edit'),
(1255, 10, 'newsletter.edit'),
(1256, 10, 'newsletter.send'),
(1257, 10, 'products.edit'),
(1258, 10, 'products.view'),
(1259, 10, 'roles.register.edit'),
(1260, 10, 'users.edit'),
(1261, 10, 'sitemap.edit'),
(1262, 10, 'modules.insert'),
(1263, 10, 'forum.topic.create'),
(1264, 10, 'forum.thread.create'),
(1265, 10, 'forum.view'),
(1266, 10, 'forum.admin'),
(1267, 10, 'forum.moderator'),
(1268, 10, 'forum.thread.post'),
(1269, 10, 'chat.user'),
(1270, 10, 'chat.view'),
(1271, 10, 'comment.post'),
(1272, 10, 'comment.edit'),
(1273, 10, 'comment.delete'),
(1274, 10, 'comment.show.email'),
(1275, 10, 'backup.create'),
(1276, 10, 'backup.load'),
(1277, 10, 'backup.delete'),
(1278, 10, 'users.register.edit'),
(1279, 10, 'user.info.edit'),
(1280, 10, 'user.info.admin'),
(1281, 10, 'user.info.owner'),
(1282, 10, 'admin.roles.edit'),
(1283, 10, 'gallery.edit'),
(1284, 10, 'gallery.view'),
(1285, 10, 'message.inbox'),
(1286, 10, 'events.callender'),
(1287, 10, 'events.list'),
(1288, 10, 'events.edit'),
(1289, 10, 'template.edit'),
(1290, 10, 'template.view'),
(1291, 10, 'orders.edit'),
(1292, 10, 'orders.view'),
(1293, 10, 'orders.all'),
(1294, 10, 'orders.confirm'),
(1295, 10, 'orders.finnish'),
(1296, 10, 'dm.tables.config'),
(1297, 10, 'dm.forms.edit'),
(1298, 10, 'shop.basket.view'),
(1299, 10, 'shop.basket.status.edit'),
(1300, 10, 'shop.basket.edit'),
(1301, 10, 'shop.basket.details.view'),
(1302, 10, 'shop.basket.details.edit'),
(1303, 10, 'slideshow.edit'),
(1304, 10, 'filesystem.all'),
(1305, 10, 'filesystem.user'),
(1306, 10, 'filesystem.www'),
(1307, 10, 'filesystem.edit'),
(1308, 10, 'events.users.all'),
(1309, 10, 'menu.edit'),
(1310, 10, 'pages.editmenu'),
(1311, 10, 'pages.edit'),
(1312, 10, 'payment.edit'),
(1313, 10, 'social.edit'),
(1314, 10, 'admin.edit'),
(1315, 10, 'translations.edit');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=59 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

--
-- Daten für Tabelle `t_page`
--

INSERT INTO `t_page` (`id`, `type`, `namecode`, `welcome`, `title`, `keywords`, `description`, `template`, `siteid`, `code`, `codeid`, `pagetrackerscript`, `modifydate`) VALUES
(1, 0, 1, 0, 'login', 0x6c6f67696e, 0x6c6f67696e, 5, 1, 'login', 1, NULL, '0000-00-00 00:00:00'),
(2, 0, 2, 0, 'adminPages', 0x61646d696e5061676573, 0x61646d696e5061676573, 5, 1, 'adminPages', 5, NULL, '0000-00-00 00:00:00'),
(3, 0, 3, 0, 'startup', 0x73746172747570, 0x73746172747570, 5, 1, 'startup', 7, NULL, '0000-00-00 00:00:00'),
(4, 0, 4, 0, 'adminSites', 0x61646d696e5369746573, 0x61646d696e5369746573, 5, 1, 'adminSites', 8, NULL, '0000-00-00 00:00:00'),
(5, 0, 5, 0, 'adminTemplates', 0x61646d696e54656d706c61746573, 0x61646d696e54656d706c61746573, 5, 1, 'adminTemplates', 9, NULL, '0000-00-00 00:00:00'),
(6, 0, 6, 0, 'pageConfig', 0x70616765436f6e666967, 0x70616765436f6e666967, 5, 1, 'pageConfig', 10, NULL, '0000-00-00 00:00:00'),
(7, 0, 7, 1, '', '', '', 5, 1, '', NULL, NULL, '2013-11-17 14:35:42'),
(8, 0, 8, 0, 'insertModule', 0x696e736572744d6f64756c65, 0x696e736572744d6f64756c65, 5, 1, 'insertModule', 11, NULL, '0000-00-00 00:00:00'),
(9, 0, 9, 0, '', '', '', 5, 1, '', NULL, NULL, '0000-00-00 00:00:00'),
(10, 0, 10, 0, '', '', '', 5, 1, '', NULL, NULL, '2013-11-22 15:29:36'),
(11, 0, 11, 0, '', '', '', 5, 1, '', NULL, NULL, '0000-00-00 00:00:00'),
(12, 0, 12, 0, '', '', '', 5, 1, '', NULL, NULL, '0000-00-00 00:00:00'),
(13, 0, 13, 0, '', '', '', 5, 1, '', NULL, NULL, '0000-00-00 00:00:00'),
(14, 0, 14, 0, '', '', '', 5, 1, '', NULL, NULL, '2013-11-22 13:33:07'),
(15, 0, 15, 0, '', '', '', 5, 1, '', NULL, NULL, '2013-11-22 13:32:21'),
(16, 0, 16, 0, 'adminMenus', 0x61646d696e4d656e7573, 0x61646d696e4d656e7573, 5, 1, 'adminMenus', 17, NULL, '0000-00-00 00:00:00'),
(17, 0, 17, 0, '', '', '', 5, 1, '', NULL, NULL, '0000-00-00 00:00:00'),
(18, 0, 18, 0, 'productGroups', 0x70726f6475637447726f757073, 0x70726f6475637447726f757073, 5, 1, 'productGroups', 19, NULL, '0000-00-00 00:00:00'),
(20, 0, 20, 0, 'adminModules', 0x61646d696e4d6f64756c6573, 0x61646d696e4d6f64756c6573, 5, 1, 'adminModules', 21, NULL, '0000-00-00 00:00:00'),
(21, 0, 21, 0, 'adminDomains', 0x61646d696e446f6d61696e73, 0x61646d696e446f6d61696e73, 5, 1, 'adminDomains', 25, NULL, '0000-00-00 00:00:00'),
(22, 0, 22, 0, 'adminMessages', 0x61646d696e4d65737361676573, 0x61646d696e4d65737361676573, 5, 1, 'adminMessages', 26, NULL, '0000-00-00 00:00:00'),
(23, 0, 23, 0, 'adminPackage', 0x61646d696e5061636b616765, 0x61646d696e5061636b616765, 5, 1, 'adminPackage', 27, NULL, '0000-00-00 00:00:00'),
(24, 0, 24, 0, 'configTables', 0x636f6e6669675461626c6573, 0x636f6e6669675461626c6573, 5, 1, 'configTables', 29, NULL, '0000-00-00 00:00:00'),
(26, 0, 26, 0, 'adminNewsletter', 0x61646d696e4e6577736c6574746572, 0x61646d696e4e6577736c6574746572, 5, 1, 'adminNewsletter', 31, NULL, '0000-00-00 00:00:00'),
(27, 0, 27, 0, 'The Glocke', 0x54686520476c6f636b65, 0x54686520476c6f636b65, 5, 1, '', NULL, NULL, '2013-11-22 13:31:12'),
(28, 0, 28, 0, 'adminTranslations', 0x61646d696e5472616e736c6174696f6e73, 0x61646d696e5472616e736c6174696f6e73, 5, 1, 'adminTranslations', 33, NULL, '0000-00-00 00:00:00'),
(29, 0, 29, 0, 'Projects', 0x50726f6a65637473, 0x50726f6a65637473, 5, 1, '', NULL, NULL, '0000-00-00 00:00:00'),
(30, 0, 30, 0, 'vbmscms', 0x76626d73636d73, 0x76626d73636d73, 5, 1, '', NULL, NULL, '2013-11-22 15:31:47'),
(31, 0, 31, 0, 'phpPacker', 0x7068705061636b6572, 0x7068705061636b6572, 5, 1, '', NULL, NULL, '0000-00-00 00:00:00'),
(32, 0, 32, 0, 'zero energy pump', 0x7a65726f20656e657267792070756d70, 0x7a65726f20656e657267792070756d70, 5, 1, '', NULL, NULL, '2013-11-22 13:29:00'),
(33, 0, 33, 0, '', '', '', 5, 1, '', NULL, NULL, '2013-11-22 15:31:11'),
(34, 0, 34, 0, 'Anti Terrorism', 0x416e746920546572726f7269736d, 0x416e746920546572726f7269736d, 5, 1, '', NULL, NULL, '0000-00-00 00:00:00'),
(35, 0, 35, 0, '', '', '', 5, 1, '', NULL, NULL, '2013-11-17 15:06:56'),
(36, 0, 36, 0, '', '', '', 5, 1, '', NULL, NULL, '2013-11-22 15:27:43'),
(37, 0, 37, 0, '', '', '', 5, 1, '', NULL, NULL, '2013-11-22 15:28:24'),
(38, 0, 38, 0, 'Medical', 0x4d65646963616c, 0x4d65646963616c, 5, 1, '', NULL, NULL, '2013-11-22 12:50:30');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_page_roles`
--

CREATE TABLE IF NOT EXISTS `t_page_roles` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `roleid` int(10) NOT NULL,
  `pageid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=111 ;

--
-- Daten für Tabelle `t_page_roles`
--

INSERT INTO `t_page_roles` (`id`, `roleid`, `pageid`) VALUES
(10, 13, 7),
(9, 10, 7),
(8, 9, 7),
(7, 8, 7),
(6, 7, 7),
(55, 13, 9),
(54, 10, 9),
(53, 9, 9),
(52, 8, 9),
(51, 7, 9),
(16, 7, 10),
(17, 8, 10),
(18, 9, 10),
(19, 10, 10),
(20, 13, 10),
(21, 7, 11),
(22, 8, 11),
(23, 9, 11),
(24, 10, 11),
(25, 13, 11),
(26, 7, 12),
(27, 8, 12),
(28, 9, 12),
(29, 10, 12),
(30, 13, 12),
(31, 7, 13),
(32, 8, 13),
(33, 9, 13),
(34, 10, 13),
(35, 13, 13),
(36, 7, 14),
(37, 8, 14),
(38, 9, 14),
(39, 10, 14),
(40, 13, 14),
(41, 7, 15),
(42, 8, 15),
(43, 9, 15),
(44, 10, 15),
(45, 13, 15),
(46, 7, 17),
(47, 8, 17),
(48, 9, 17),
(49, 10, 17),
(50, 13, 17),
(56, 7, 27),
(57, 8, 27),
(58, 9, 27),
(59, 10, 27),
(60, 13, 27),
(61, 7, 29),
(62, 8, 29),
(63, 9, 29),
(64, 10, 29),
(65, 13, 29),
(66, 7, 30),
(67, 8, 30),
(68, 9, 30),
(69, 10, 30),
(70, 13, 30),
(71, 7, 31),
(72, 8, 31),
(73, 9, 31),
(74, 10, 31),
(75, 13, 31),
(76, 7, 32),
(77, 8, 32),
(78, 9, 32),
(79, 10, 32),
(80, 13, 32),
(81, 7, 33),
(82, 8, 33),
(83, 9, 33),
(84, 10, 33),
(85, 13, 33),
(86, 7, 34),
(87, 8, 34),
(88, 9, 34),
(89, 10, 34),
(90, 13, 34),
(91, 7, 35),
(92, 8, 35),
(93, 9, 35),
(94, 10, 35),
(95, 13, 35),
(96, 7, 36),
(97, 8, 36),
(98, 9, 36),
(99, 10, 36),
(100, 13, 36),
(101, 7, 37),
(102, 8, 37),
(103, 9, 37),
(104, 10, 37),
(105, 13, 37),
(106, 7, 38),
(107, 8, 38),
(108, 9, 38),
(109, 10, 38),
(110, 13, 38);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Daten für Tabelle `t_roles`
--

INSERT INTO `t_roles` (`id`, `name`, `userid`, `roleid`) VALUES
(1, '7', 1, 7),
(2, '8', 1, 8),
(3, '9', 1, 9),
(4, '10', 1, 10),
(5, '13', 1, 13),
(6, '7', 2, 7),
(7, '8', 2, 8),
(8, '9', 2, 9),
(9, '10', 2, 10),
(10, '13', 2, 13);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_roles_custom`
--

CREATE TABLE IF NOT EXISTS `t_roles_custom` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Daten für Tabelle `t_roles_custom`
--

INSERT INTO `t_roles_custom` (`id`, `name`) VALUES
(7, 'guest'),
(8, 'user'),
(9, 'editor'),
(10, 'admin'),
(13, 'newsletter');

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

--
-- Daten für Tabelle `t_session`
--

INSERT INTO `t_session` (`userid`, `sessionid`, `sessionkey`, `ip`, `name`, `lastpolltime`, `logintime`) VALUES
(NULL, '74e2237667e91339d51e0d8394d3ce6ccd165c71', 'ACp1f+YvILXaAS6iu7lc/wy6drLshx30tDUWNoce', '127.0.0.1', 'guest_6436209', '2013-11-22 15:32:50', NULL);

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `t_site`
--

INSERT INTO `t_site` (`id`, `name`, `description`, `sitetrackerscript`, `cmscustomerid`) VALUES
(1, 'vbmscms', 0x76626d73636d7320696e6974616c2073697465, NULL, 0),
(2, 'vbmscms', 0x76626d73636d7320696e6974616c2073697465, NULL, 0);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=35 ;

--
-- Daten für Tabelle `t_site_template`
--

INSERT INTO `t_site_template` (`id`, `siteid`, `templateid`, `main`) VALUES
(1, 1, 2, 0),
(2, 1, 3, 0),
(3, 1, 4, 0),
(4, 1, 5, 1);

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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Daten für Tabelle `t_template`
--

INSERT INTO `t_template` (`id`, `name`, `template`, `interface`, `html`, `css`, `js`) VALUES
(2, 'Docpanel Demo Template', '', '', 0x3c64697620636c6173733d226672616d65446976223e0d0a202020203c64697620636c6173733d22746f704d656e75446976223e0d0a20202020202020203c64697620636c6173733d22746f704d656e754d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e6d656e752e746f704d656e7520636d733f2667743b0d0a2020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22686561646572446976223e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d226865616465724d656e75446976223e0d0a20202020202020203c64697620636c6173733d226865616465724d656e754d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e6d656e752e6865616465724d656e7520636d733f2667743b0d0a2020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22626f64795269676874446976223e0d0a20202020202020203c64697620636c6173733d22666c6f6174436f6e7461696e6572446976223e0d0a2020202020202020202020203c64697620636c6173733d22626f647952696768744d617267696e446976223e0d0a20202020202020202020202020202020266c743b3f636d732074656d706c6174652e617265612e726967687420636d733f2667743b0d0a202020202020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a2020202020202020202020203c2f6469763e0d0a20202020202020203c2f6469763e0d0a20202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22626f64794c656674446976223e0d0a20202020202020203c64697620636c6173733d22666c6f6174436f6e7461696e6572446976223e0d0a2020202020202020202020203c64697620636c6173733d22626f64794c6566744d617267696e446976223e0d0a20202020202020202020202020202020266c743b3f636d732074656d706c6174652e617265612e6c65667420636d733f2667743b0d0a202020202020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a2020202020202020202020203c2f6469763e0d0a20202020202020203c2f6469763e0d0a20202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22626f647944697620626f64794469764c6566744d617267696e20626f647944697652696768744d617267696e223e0d0a20202020202020203c64697620636c6173733d22666c6f6174436f6e7461696e6572446976223e0d0a2020202020202020202020203c64697620636c6173733d22626f64794d617267696e446976223e0d0a20202020202020202020202020202020266c743b3f636d732074656d706c6174652e6d61696e2e63656e74657220636d733f2667743b0d0a202020202020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a2020202020202020202020203c2f6469763e0d0a20202020202020203c2f6469763e0d0a20202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22666f6f7465724d656e75446976223e0d0a20202020202020203c64697620636c6173733d22666f6f7465724d656e754d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e6d656e752e666f6f7465724d656e7520636d733f2667743b0d0a2020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a3c2f6469763e, 0x626f6479207b0d0a2020202070616464696e673a3070783b0d0a202020206d617267696e3a3070783b0d0a7d202020200d0a2e6672616d65446976207b0d0a202020206d696e2d77696474683a2037303070783b0d0a202020206d617267696e3a2030707820313070782030707820313070783b0d0a7d0d0a2e746f704d656e75446976207b0d0a202020206d617267696e3a2030707820313070782030707820313070783b0d0a7d0d0a2e746f704d656e754d617267696e446976207b0d0a20202020666c6f61743a2072696768743b0d0a7d0d0a2e686561646572446976207b0d0a20202020636c6561723a20626f74683b0d0a202020206865696768743a2031303070783b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e6865616465724d656e75446976207b0d0a202020206d696e2d6865696768743a20333070783b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c282767726164536d616c6c2e6769662729207768697465207265706561742d783b0d0a7d0d0a2e6865616465724d656e754d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e626f6479446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f64794d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e626f64794469764c6566744d617267696e207b0d0a202020206d617267696e2d6c6566743a2032313070783b0d0a7d0d0a2e626f647944697652696768744d617267696e207b0d0a202020206d617267696e2d72696768743a2032313070783b0d0a7d0d0a2e626f64795269676874446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a2020202077696474683a2032303070783b0d0a20202020666c6f61743a2072696768743b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f647952696768744d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e626f64794c656674446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a2020202077696474683a2032303070783b0d0a20202020666c6f61743a206c6566743b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f64794c6566744d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e666f6f7465724d656e75446976207b0d0a20202020636c6561723a20626f74683b0d0a202020206d696e2d6865696768743a20333070783b0d0a202020206d617267696e3a2031307078203070782031307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c282767726164536d616c6c2e6769662729207768697465207265706561742d783b0d0a7d0d0a2e666f6f7465724d656e754d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e666c6f6174436f6e7461696e6572446976207b0d0a20202020666c6f61743a6c6566743b0d0a2020202077696474683a313030253b0d0a7d, ''),
(3, 'Docpanel Left Demo Template', '', '', 0x3c64697620636c6173733d226672616d65446976223e0d0a202020203c64697620636c6173733d22746f704d656e75446976223e0d0a20202020202020203c64697620636c6173733d22746f704d656e754d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e6d656e752e746f704d656e7520636d733f2667743b0d0a2020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22686561646572446976223e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d226865616465724d656e75446976223e0d0a20202020202020203c64697620636c6173733d226865616465724d656e754d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e6d656e752e6865616465724d656e7520636d733f2667743b0d0a2020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22626f64794c656674446976223e0d0a20202020202020203c64697620636c6173733d22666c6f6174436f6e7461696e6572446976223e0d0a2020202020202020202020203c64697620636c6173733d22626f64794c6566744d617267696e446976223e0d0a20202020202020202020202020202020266c743b3f636d732074656d706c6174652e617265612e6c65667420636d733f2667743b0d0a202020202020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a2020202020202020202020203c2f6469763e0d0a20202020202020203c2f6469763e0d0a20202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22626f647944697620626f64794469764c6566744d617267696e223e0d0a20202020202020203c64697620636c6173733d22666c6f6174436f6e7461696e6572446976223e0d0a2020202020202020202020203c64697620636c6173733d22626f64794d617267696e446976223e0d0a20202020202020202020202020202020266c743b3f636d732074656d706c6174652e6d61696e2e63656e74657220636d733f2667743b0d0a202020202020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a2020202020202020202020203c2f6469763e0d0a20202020202020203c2f6469763e0d0a20202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22666f6f7465724d656e75446976223e0d0a20202020202020203c64697620636c6173733d22666f6f7465724d656e754d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e6d656e752e666f6f7465724d656e7520636d733f2667743b0d0a2020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a3c2f6469763e, 0x626f6479207b0d0a2020202070616464696e673a3070783b0d0a202020206d617267696e3a3070783b0d0a7d202020200d0a2e6672616d65446976207b0d0a202020206d696e2d77696474683a2037303070783b0d0a202020206d617267696e3a2030707820313070782030707820313070783b0d0a7d0d0a2e746f704d656e75446976207b0d0a202020206d617267696e3a2030707820313070782030707820313070783b0d0a7d0d0a2e746f704d656e754d617267696e446976207b0d0a20202020666c6f61743a2072696768743b0d0a7d0d0a2e686561646572446976207b0d0a20202020636c6561723a20626f74683b0d0a202020206865696768743a2031303070783b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e6865616465724d656e75446976207b0d0a202020206d696e2d6865696768743a20333070783b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c282767726164536d616c6c2e6769662729207768697465207265706561742d783b0d0a7d0d0a2e6865616465724d656e754d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e626f6479446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f64794d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e626f64794469764c6566744d617267696e207b0d0a202020206d617267696e2d6c6566743a2032313070783b0d0a7d0d0a2e626f647944697652696768744d617267696e207b0d0a202020206d617267696e2d72696768743a2032313070783b0d0a7d0d0a2e626f64795269676874446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a2020202077696474683a2032303070783b0d0a20202020666c6f61743a2072696768743b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f647952696768744d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e626f64794c656674446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a2020202077696474683a2032303070783b0d0a20202020666c6f61743a206c6566743b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f64794c6566744d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e666f6f7465724d656e75446976207b0d0a20202020636c6561723a20626f74683b0d0a202020206d696e2d6865696768743a20333070783b0d0a202020206d617267696e3a2031307078203070782031307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c282767726164536d616c6c2e6769662729207768697465207265706561742d783b0d0a7d0d0a2e666f6f7465724d656e754d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e666c6f6174436f6e7461696e6572446976207b0d0a20202020666c6f61743a6c6566743b0d0a2020202077696474683a313030253b0d0a7d, ''),
(4, 'Docpanel Right Demo Template', '', '', 0x3c64697620636c6173733d226672616d65446976223e0d0a202020203c64697620636c6173733d22746f704d656e75446976223e0d0a20202020202020203c64697620636c6173733d22746f704d656e754d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e6d656e752e746f704d656e7520636d733f2667743b0d0a2020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22686561646572446976223e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d226865616465724d656e75446976223e0d0a20202020202020203c64697620636c6173733d226865616465724d656e754d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e6d656e752e6865616465724d656e7520636d733f2667743b0d0a2020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22626f64795269676874446976223e0d0a20202020202020203c64697620636c6173733d22666c6f6174436f6e7461696e6572446976223e0d0a2020202020202020202020203c64697620636c6173733d22626f647952696768744d617267696e446976223e0d0a20202020202020202020202020202020266c743b3f636d732074656d706c6174652e617265612e726967687420636d733f2667743b0d0a202020202020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a2020202020202020202020203c2f6469763e0d0a20202020202020203c2f6469763e0d0a20202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22626f647944697620626f647944697652696768744d617267696e223e0d0a20202020202020203c64697620636c6173733d22666c6f6174436f6e7461696e6572446976223e0d0a2020202020202020202020203c64697620636c6173733d22626f64794d617267696e446976223e0d0a20202020202020202020202020202020266c743b3f636d732074656d706c6174652e6d61696e2e63656e74657220636d733f2667743b0d0a202020202020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a2020202020202020202020203c2f6469763e0d0a20202020202020203c2f6469763e0d0a20202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22666f6f7465724d656e75446976223e0d0a20202020202020203c64697620636c6173733d22666f6f7465724d656e754d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e6d656e752e666f6f7465724d656e7520636d733f2667743b0d0a2020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a3c2f6469763e, 0x626f6479207b0d0a2020202070616464696e673a3070783b0d0a202020206d617267696e3a3070783b0d0a7d202020200d0a2e6672616d65446976207b0d0a202020206d696e2d77696474683a2037303070783b0d0a202020206d617267696e3a2030707820313070782030707820313070783b0d0a7d0d0a2e746f704d656e75446976207b0d0a202020206d617267696e3a2030707820313070782030707820313070783b0d0a7d0d0a2e746f704d656e754d617267696e446976207b0d0a20202020666c6f61743a2072696768743b0d0a7d0d0a2e686561646572446976207b0d0a20202020636c6561723a20626f74683b0d0a202020206865696768743a2031303070783b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e6865616465724d656e75446976207b0d0a202020206d696e2d6865696768743a20333070783b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c282767726164536d616c6c2e6769662729207768697465207265706561742d783b0d0a7d0d0a2e6865616465724d656e754d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e626f6479446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f64794d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e626f64794469764c6566744d617267696e207b0d0a202020206d617267696e2d6c6566743a2032313070783b0d0a7d0d0a2e626f647944697652696768744d617267696e207b0d0a202020206d617267696e2d72696768743a2032313070783b0d0a7d0d0a2e626f64795269676874446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a2020202077696474683a2032303070783b0d0a20202020666c6f61743a2072696768743b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f647952696768744d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e626f64794c656674446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a2020202077696474683a2032303070783b0d0a20202020666c6f61743a206c6566743b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f64794c6566744d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e666f6f7465724d656e75446976207b0d0a20202020636c6561723a20626f74683b0d0a202020206d696e2d6865696768743a20333070783b0d0a202020206d617267696e3a2031307078203070782031307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c282767726164536d616c6c2e6769662729207768697465207265706561742d783b0d0a7d0d0a2e666f6f7465724d656e754d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e666c6f6174436f6e7461696e6572446976207b0d0a20202020666c6f61743a6c6566743b0d0a2020202077696474683a313030253b0d0a7d, ''),
(5, 'Docpanel Stack Demo Template', '', '', 0x3c64697620636c6173733d226672616d65446976223e0d0a202020203c64697620636c6173733d22746f704d656e75446976223e0d0a20202020202020203c64697620636c6173733d22746f704d656e754d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e6d656e752e746f704d656e7520636d733f2667743b0d0a2020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22686561646572446976223e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d226865616465724d656e75446976223e0d0a20202020202020203c64697620636c6173733d226865616465724d656e754d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e6d656e752e6865616465724d656e7520636d733f2667743b0d0a2020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22626f6479446976223e0d0a20202020202020203c64697620636c6173733d22666c6f6174436f6e7461696e6572446976223e0d0a2020202020202020202020203c64697620636c6173733d22626f64794d617267696e446976223e0d0a20202020202020202020202020202020266c743b3f636d732074656d706c6174652e6d61696e2e63656e74657220636d733f2667743b0d0a202020202020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a2020202020202020202020203c2f6469763e0d0a20202020202020203c2f6469763e0d0a20202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22666f6f7465724d656e75446976223e0d0a20202020202020203c64697620636c6173733d22666f6f7465724d656e754d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e6d656e752e666f6f7465724d656e7520636d733f2667743b0d0a2020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a3c2f6469763e, 0x626f6479207b0d0a2020202070616464696e673a3070783b0d0a202020206d617267696e3a3070783b0d0a7d202020200d0a2e6672616d65446976207b0d0a202020206d696e2d77696474683a2037303070783b0d0a202020206d617267696e3a2030707820313070782030707820313070783b0d0a7d0d0a2e746f704d656e75446976207b0d0a202020206d617267696e3a2030707820313070782030707820313070783b0d0a7d0d0a2e746f704d656e754d617267696e446976207b0d0a20202020666c6f61743a2072696768743b0d0a7d0d0a2e686561646572446976207b0d0a20202020636c6561723a20626f74683b0d0a202020206865696768743a2031303070783b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e6865616465724d656e75446976207b0d0a202020206d696e2d6865696768743a20333070783b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c282767726164536d616c6c2e6769662729207768697465207265706561742d783b0d0a7d0d0a2e6865616465724d656e754d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e626f6479446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f64794d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e626f64794469764c6566744d617267696e207b0d0a202020206d617267696e2d6c6566743a2032313070783b0d0a7d0d0a2e626f647944697652696768744d617267696e207b0d0a202020206d617267696e2d72696768743a2032313070783b0d0a7d0d0a2e626f64795269676874446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a2020202077696474683a2032303070783b0d0a20202020666c6f61743a2072696768743b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f647952696768744d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e626f64794c656674446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a2020202077696474683a2032303070783b0d0a20202020666c6f61743a206c6566743b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f64794c6566744d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e666f6f7465724d656e75446976207b0d0a20202020636c6561723a20626f74683b0d0a202020206d696e2d6865696768743a20333070783b0d0a202020206d617267696e3a2031307078203070782031307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c282767726164536d616c6c2e6769662729207768697465207265706561742d783b0d0a7d0d0a2e666f6f7465724d656e754d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e666c6f6174436f6e7461696e6572446976207b0d0a20202020666c6f61743a6c6566743b0d0a2020202077696474683a313030253b0d0a7d, ''),
(1, 'Admin Template', 'core/template/adminTemplate.php', 'AdminTemplate', NULL, NULL, NULL);

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
  `code` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=51 ;

--
-- Daten für Tabelle `t_templatearea`
--

INSERT INTO `t_templatearea` (`id`, `name`, `pageid`, `type`, `position`, `code`) VALUES
(1, 'center', 1, 13, 0, 'login'),
(2, 'topMenu', 0, 59, 0, 'menu'),
(3, 'headerMenu', 0, 59, 0, 'menu'),
(4, 'footerMenu', 0, 59, 0, 'menu'),
(5, 'center', 2, 70, 0, 'adminPages'),
(6, 'adminMenu', 0, 69, 0, 'adminMenu'),
(7, 'center', 3, 44, 0, 'startup'),
(8, 'center', 4, 72, 0, 'adminSites'),
(9, 'center', 5, 38, 0, 'adminTemplates'),
(10, 'center', 6, 60, 0, 'pageConfig'),
(11, 'center', 8, 45, 0, 'insertModule'),
(12, 'center', 7, 2, 0, ''),
(13, 'center', 7, 27, 1, ''),
(14, 'center', 10, 2, 0, ''),
(15, 'center', 11, 2, 0, ''),
(16, 'center', 13, 50, 0, ''),
(17, 'center', 16, 71, 0, 'adminMenus'),
(18, 'center', 17, 13, 0, ''),
(19, 'center', 18, 65, 0, 'productGroups'),
(21, 'center', 20, 39, 0, 'adminModules'),
(22, 'center', 9, 2, 0, ''),
(23, 'center', 14, 2, 0, ''),
(39, 'center', 36, 2, 0, ''),
(25, 'center', 21, 40, 0, 'adminDomains'),
(26, 'center', 22, 73, 0, 'adminMessages'),
(27, 'center', 23, 74, 0, 'adminPackage'),
(28, 'center', 15, 2, 0, ''),
(29, 'center', 24, 49, 0, 'configTables'),
(31, 'center', 26, 16, 0, 'adminNewsletter'),
(32, 'center', 27, 2, 0, ''),
(33, 'center', 28, 75, 0, 'adminTranslations'),
(34, 'center', 30, 2, 0, ''),
(35, 'center', 31, 2, 0, ''),
(36, 'center', 32, 2, 0, ''),
(37, 'center', 33, 2, 0, ''),
(38, 'center', 34, 2, 0, ''),
(40, 'center', 37, 2, 0, ''),
(41, 'center', 38, 2, 0, ''),
(42, 'center', 33, 27, 1, ''),
(43, 'center', 30, 27, 1, ''),
(44, 'center', 32, 27, 1, ''),
(45, 'center', 31, 27, 1, ''),
(46, 'center', 34, 27, 1, ''),
(47, 'center', 27, 27, 1, ''),
(48, 'center', 15, 27, 1, ''),
(49, 'center', 14, 27, 1, ''),
(50, 'center', 10, 27, 1, '');

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
-- Tabellenstruktur für Tabelle `t_users`
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
  `image` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `t_users`
--

INSERT INTO `t_users` (`id`, `username`, `password`, `authkey`, `email`, `firstname`, `lastname`, `objectid`, `registerdate`, `birthdate`, `active`, `image`) VALUES
(1, 'vbms', 'fbbe3be04d98a0e73c18b25d38ac6cf1', NULL, 'silkyfx@gmail.com', 'sil', 'muh', 5, '2013-11-01', '0000-00-00', 1, NULL),
(2, 'vbms', 'fbbe3be04d98a0e73c18b25d38ac6cf1', NULL, 'silkyfx@gmail.com', 'sil', 'muh', 8, '2013-11-22', '0000-00-00', 1, NULL);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=55 ;

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
(53, 16, 'FormItemTextArea1', '', 'Label', 2, 1, NULL, NULL, 0x4465736372697074696f6e, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_vdb_object`
--

CREATE TABLE IF NOT EXISTS `t_vdb_object` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `tableid` int(10) NOT NULL,
  `viewed` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=9 ;

--
-- Daten für Tabelle `t_vdb_object`
--

INSERT INTO `t_vdb_object` (`id`, `tableid`, `viewed`) VALUES
(4, 2, 1),
(5, 2, 1),
(7, 9, 0),
(8, 2, 0);

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

--
-- Daten für Tabelle `t_vdb_value`
--

INSERT INTO `t_vdb_value` (`objectid`, `columnid`, `value`) VALUES
(4, 1, ''),
(4, 2, ''),
(4, 3, ''),
(4, 4, ''),
(4, 5, ''),
(4, 6, ''),
(4, 7, 0x30),
(4, 8, ''),
(4, 24, ''),
(4, 49, ''),
(5, 1, ''),
(5, 2, ''),
(5, 3, ''),
(5, 4, ''),
(5, 5, ''),
(5, 6, ''),
(5, 7, 0x30),
(5, 8, ''),
(5, 24, ''),
(5, 49, ''),
(7, 36, 0x74657374206e616d652032),
(7, 37, 0x6672696564726963682e61737472696440676d61696c2e636f6d),
(7, 39, 0x74657374207375626a65637432),
(7, 38, 0x74657374206d65737361676520322074657374206d65737361676520322074657374206d65737361676520322074657374206d65737361676520322074657374206d65737361676520322074657374206d65737361676520322074657374206d65737361676520322074657374206d65737361676520322074657374206d65737361676520322074657374206d657373617374206d65737361676520322074657374206d65737361676520322074657374206d65737361676520322074657374206d65737361676520322074657374206d65737361676520322074657374206d65737361676520322074657374206d65737361676520322074657374206d65737361676520322074657374206d657373617374206d65737361676520322074657374206d65737361676520322074657374206d65737361676520322074657374206d65737361676520322074657374206d65737361676520322074657374206d65737361676520322074657374206d65737361676520322074657374206d65737361676520322074657374206d65737361676520322074657374206d65737361676520322074657374206d65737361676520322074657374206d65737361676520322074657374206d65737361676520322074657374206d65737361676520322074657374206d65737361676520322074657374206d65737361676520322074657374206d65737361676520322074657374206d65737361676520322074657374206d65737361676520322074657374206d65737361676520322074657374206d65737361676520322074657374206d65737361676520322074657374206d65737361676520322074657374206d65737361676520322074657374206d657373616765203220),
(8, 1, ''),
(8, 2, ''),
(8, 3, ''),
(8, 4, ''),
(8, 5, ''),
(8, 6, ''),
(8, 7, 0x30),
(8, 8, ''),
(8, 24, ''),
(8, 49, '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_wysiwygpage`
--

CREATE TABLE IF NOT EXISTS `t_wysiwygpage` (
  `id` int(10) unsigned DEFAULT NULL,
  `pageid` int(10) unsigned DEFAULT NULL,
  `lang` varchar(5) NOT NULL,
  `content` blob,
  `title` varchar(100) DEFAULT NULL,
  `area` int(5) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `t_wysiwygpage`
--

INSERT INTO `t_wysiwygpage` (`id`, `pageid`, `lang`, `content`, `title`, `area`) VALUES
(NULL, 12, 'en', 0x3c68333e57656c636f6d653c2f68333e4c6f67696e207468656e20726967687420636c69636b206f6e20636f6e74656e7420616e642073656c6563742065646974206d6f64756c6520746f20656469742074686520636f6e74656e74206f6620746865206d6f64756c652e20636865636b206f7574207468652061727469636c65732e20492068617665206e6f742066696e6e69736865642074686520636d73206265636175736520692077617320746f72747572656420627920746865206765726d616e20676f7665726e6d656e74206f766572207365766572616c2079656172732e20496d206c6f6f6b696e6720666f7220736f6d656f6e6520746f20636f6e74696e75652074686520776f726b2e3c6272202f3e3c6272202f3e3c6872202f3e, NULL, 0),
(NULL, 32, 'en', 0x3c68333e54686520476c6f636b652028486f6c6f6772617068696320556e6976657273652047656e657261746f72293c2f68333e203c696d67207374796c653d22666c6f61743a72696768743b70616464696e672d6c6566743a323070783b77696474683a333234707822207372633d2266696c65732f7777772f556e62656e616e6e742e504e4722202f3e496e20746865207365636f6e6420776f726c64207761722041646f6c66204869746c657220616e6420746865204765726d616e2061726d79207265736561726368656420616e6369656e7420746563686e6f6c6f6769657320616e64207765726520696e20736561726368206f662077686174207468657920636f6e736964657265642074686520686f6c7920677261696c2e2041646f6c66204869746c65722074686f7567687420746865792068616420666f756e642069742e2054686579207765726520646576656c6f70696e672061207365637265742064657669636520746861742074686579206e616d65642074686520676c6f636b652e2054686520676c6f636b65207761732061206c697175696420737461746520686f6c6f6772616d2067656e657261746f722061206b696e64206f6620686f6c6f6772617068696320756e6976657273652067656e657261746f722e20546f20756e6465727374616e642077686174206973206d65616e7420636f6e736964657220612063616d65726120706f696e74656420696e746f20612074656c65766973696f6e20746861742069732073686f77696e672074686520696d6167652066726f6d207468652063616d6572612e205468652074656c65766973696f6e2077696c6c20646973706c617920696e66696e69746520696d6167657320696e736964652065616368206f746865722e204561636820696d61676520697320736570617261746564206279206f6e652074696d6520737465702c207468652074696d6520746861742069742074616b657320666f722074686520696d6167652066726f6d207468652063616d65726120746f20626520646973706c61796564206f6e207468652074656c65766973696f6e2073637265656e2e204561636820726563757273696f6e20697320616e20696d616765206675727468657220696e2074686520706173742e2054686520676c6f636b65207468656f72792069732074686174207370696e6e696e6720706c61736d612063616e20636f7572736520612072656672616374696f6e206f66206c696768742070726f647563696e6720616e20696d616765206f662074686520696e707574206c696768742e20496e2074686520696d616765207468657265206973206675727468657220696e66696e69746520726563757273696f6e73206f66207468652073616d6520696d6167652073696d696c617220746f207468652063616d6572612061742074656c65766973696f6e206566666563742e204561636820696d61676520697320736570617261746564206279206f6e652074696d6520737465702c20746865206d696e696d756d2073746570206f6620612070686f746f6e2e2054696d652063616e20626520636f6e736964657265642061732074686520737465702066726f6d206f6e6520696d61676520746f20746865206e657874206f7220746865206d696e696d756d2073746570206f6620612070686f746f6e2e20497420776173206d656e74696f6e65642062792061205275737369616e2075666f2065787065727420696e206120766964656f2069207761746368656420696e20796f75747562652c2077687920776520646f206e6f74206d656574206265696e6773207468617420686176652074726176656c656420746f20706c616e65742065617274682c20626563617573652074686520686176652073756368206120746563686e6f6c6f676965732e20546865792073696d706c7920637265617465206120686f6c6f6772616d206f662074696d6520616e64206d65657420757320696e2074686520686f6c6f6772616d207468656e2064656369646520696620746861742773207768617420746865792077616e7420746f20646f206f72206b65657020747279696e67206e657720636f6d62696e6174696f6e73206f662074696d652e20203c6272202f3e3c6833207374796c653d22636c6561723a626f7468223e5768617420696620746865206675747572652068617070656e656420696e2074686520706173743c2f68333e202020202020203c696d67207374796c653d22666c6f61743a72696768743b70616464696e672d6c6566743a3230707822207372633d2266696c65732f7777772f6d61646f6e61322e504e4722202f3e4d616e7920736369656e7469737473206861766520636f6e7369646572656420746865207175657374696f6e20636f756c64206120756e69766572736520636f756c6420657869737420696e73696465206120756e6976657273652e2049662073756368206120746563686e6f6c6f67696573206578697374732061732074686520686f6c6f6772617068696320756e6976657273652067656e657261746f7220776865726520697420697320706f737369626c6520746f207265706c6179206c696768742e204f757473696465206f66207468697320756e697665727365207765206d6967687420616c726561647920626520696e207468652066757475726520696e736964652061206465766963652074686174207265706c6179732074696d652e204966206120737061636520637261667420746861742069732063617061626c65206f662073757065726c756d696e616c2074656c65706f72746174696f6e2c2074656c65706f7274732032303133206c6967687420796561727320617761792066726f6d20656172746820746865206c696768742074726176656c696e6720617761792066726f6d207468652065617274682061742074686174206c6f636174696f6e2077696c6c206265206f66207468652074696d65207768656e204a6573757320776173206f6e2065617274682e204966207468652063726577207765726520746f20637265617465206120686f6c6f6772616d206f662074686174206c696768742074696d6520776f756c64207265706c61792066726f6d207468652079656172203020616761696e2e20416c736f2074686520637261667420776f756c6420626520696e2074686520686f6c6f6772616d2032303133206c6967687420796561727320617761792066726f6d2065617274682e2049662074686520637261667420696e2074686520686f6c6f6772616d2077617320746f2074656c65706f7274206261636b20746f206561727468207468657920776f756c642061727269766520696e20746865207965617220302e204a75737420696e2074696d6520746f207769746e65737320746865206269727468206f66204a657375732e204d6179207468697320656666656374206578706c61696e207468652070726573656e6365206f6620616e6369656e742073706163652063726166742e20203c6272202f3e3c6272202f3e3c64697620636c6173733d22636c656172223e3c2f6469763e, NULL, 0),
(NULL, 34, 'en', 0x3c68323e3c696d67207374796c653d2277696474683a34363370783b6865696768743a32333770783b666c6f61743a726967687422207372633d22687474703a2f2f6c6f63616c686f73742f76626d73636d732f66696c65732f7777772f76636d732e504e472220616c743d222022202f3e76626d73636d733c2f68323e3c703e504850206a717565727920434d5320666561747572696e67206d6f64756c6520616e642074656d706c61746520706c7567696e7320696e746572666163652e3c6272202f3e3c2f703e3c68333e4465736372697074696f6e3a3c2f68333e4561737920746f2061646d696e69737465722050485020434d532c20666561747572696e67206561737920746f20646576656c6f70206d6f64756c6520616e6420776562200d0a7365727669636520696e746572666163657320616e642074656d706c6174652073797374656d2077697468205759534957594720656469742066756e6374696f6e616c6974792e200d0a53697465732063616e2068617665206d756c7469706c6520646f6d61696e7320616e6420616e20696e7374616e6365206f662074686520434d532063616e20686f7374200d0a6d756c7469706c652073697465732e20436f6d6d65726369616c206d6f64756c6520696e746572666163652077686572652075736572732063616e2062757920616e64200d0a646576656c6f706572732063616e2073656c6c206d6f64756c6573206f722074656d706c617465732e3c6272202f3e3c68333e46656174757265733a3c2f68333e3c756c3e3c6c693e446576656c6f70657220667269656e646c79206d6f64756c652073797374656d20746f206372656174652076696577733c2f6c693e3c6c693e44617461206d6f64656c2073797374656d20776974682071756572792061706920746f2063726561746520616e64206d61696e7461696e2064796e616d6963207461626c65733c2f6c693e3c6c693e41646d696e69737465722077656273697465207573696e6720647261672d64726f7020616e6420696e73657274696e67206d6f64756c65733c2f6c693e3c6c693e54656d706c6174652073797374656d207468617420737570706f72747320706879736963616c2074656d706c61746573206f72207669727475616c2077797369777967206564697461626c652074656d706c617465733c2f6c693e3c6c693e557365722041646d696e2c20757365722070726f66696c652c20726f6c652067726f75702061646d696e697374726174696f6e206d6f64756c65733c2f6c693e3c6c693e466f72756d2c20636861742c206b6f6e74616b742c2070726976617465206d65737361676520616e6420636f6d6d656e7473206d6f64756c65733c2f6c693e3c6c693e47616c6c65727920616e6420736c69646573686f77206d6f64756c65733c2f6c693e3c6c693e4576656e7473206c69737420616e6420736d616c6c206f722066756c6c73637265656e206576656e74732063616c6c656e6461723c2f6c693e3c6c693e4e6577736c6574746572206f726465722c2064657369676e20616e642073656e64696e67206d6f64756c65733c2f6c693e3c6c693e46696c6573797374656d2062726f777365722077697468206d756c7469706c6520636f6e7465787420726f6f74732028757365722c7777772c74656d706c6174652c6d6f64756c652c657463293c2f6c693e3c6c693e4d756c746920646f6d61696e7320666f722061207369746520616e64206d756c7469207369746573206f6e2061207365727665723c2f6c693e3c6c693e53696d706c652073686f772073797374656d20776974682070726f64756374206c6973742c206f72646572732c2062696c6c7320616e642073686f706261736b6574206d6f64756c65733c2f6c693e3c6c693e4175746f6d61746963206d61696e74656e616e6365206f66206d6574612066696c6573206c696b6520726f626f74732e7478742c20736974656d616c2e786d6c20616e64207273732066656564733c2f6c693e3c2f756c3e3c68333e446f776e6c6f61643a3c2f68333e3c703e76626d73636d7320697320686f7374656420627920736f75726365666f726765203c61207461726765743d225f626c616e6b2220687265663d22687474703a2f2f636f64652e676f6f676c652e636f6d2f702f76626d73636d732f223e446f776e6c6f61642076626d73636d733c2f613e203c6272202f3e3c6272202f3e3c2f703e, NULL, 0),
(NULL, 14, 'en', 0x3c6469763e3c68313e3c696d67207374796c653d22666c6f61743a726967687422207372633d2266696c65732f7777772f636576696c69616e2e504e472220616c743d227061727469636c65697a6174696f6e22202f3e5061727469636c65697a6174696f6e3c2f68313e3c68333e5061727469636c65697a6174696f6e20202f2064652d205061727469636c65697a6174696f6e20203c6272202f3e3c2f68333e3c703e5061727469636c65697a6174696f6e20697320746f20636f6e7665727420656e6572677920746f200d0a7061727469636c6573206f722064652d207061727469636c65697a6174696f6e20746f20636f6e76657274207061727469636c657320746f20656e657267792e200d0a54656c65706f72746174696f6e20697320746f207573652064652d207061727469636c65697a6174696f6e20616e6420746f20706572666f726d200d0a72652d207061727469636c65697a6174696f6e20617420616e6f74686572206c6f636174696f6e2e3c2f703e20203c2f6469763e3c6833207374796c653d22636c6561723a626f7468223e5061727469636c6573202f20636f666665652064726f70733c2f68333e3c696d6720616c743d227061727469636c65697a6174696f6e22207374796c653d22666c6f61743a72696768743b77696474683a33323870783b6865696768743a313132707822207372633d2266696c65732f7777772f636f6666656525323064726f702e504e4722202f3e7061727469636c65730d0a2061726520656e6572677920736176656420696e206120726567696f6e206f662073706163652e20612073696d696c6172206566666563742063616e206265206f627365727665640d0a20696e206120636f66666565206375702e207768656e20746865207269676874207761766520636f6d62696e6174696f6e2068617070656e7320612064726f70206973200d0a666f726d656420746861742069732068656c6420746f67657468657220627920737572666163652074656e73696f6e2e2074686573652061726520706f736574697665200d0a636f666665652064726f70732e206e6567617469766520636f666665652064726f70732061726520616c736f20706f737369626c652e3c6272202f3e3c6833207374796c653d22636c6561723a626f7468223e5061727469636c6573202f205061727469636c65697a6174696f6e20203c2f68333e3c696d6720616c743d227061727469636c65697a6174696f6e22207374796c653d2277696474683a34393070783b6865696768743a32373070783b666c6f61743a726967687422207372633d2266696c65732f7777772f656e6572677925323064726f702e504e4722202f3e5061727469636c65730d0a2068617070656e207768656e2061206365727461696e20656e65726779206c6576656c206973207265616368656420696e206120726567696f6e206f662073706163652e20496e200d0a6f7264657220746f207265616368207468617420656e65726779206c6576656c206120636f6d62696e6174696f6e206f662077617665732069732072657175697265642e200d0a4f6e63652074686520636f727265637420656e65726779206c6576656c206973207265616368656420616e20656e657267792064726f7020697320666f726d65642e20546865200d0a666967757265206973206120706f736974697665207061727469636c6520666f72206578616d706c6520612070726f746f6e2e20456c656374726f6e7320776f756c64206265200d0a666f726d65642077697468206e656761746976652077617665732e20546f20636f6e7665727420656e6572677920696e746f207061727469636c65732069732063616c6c6564200d0a7061727469636c65697a6174696f6e2e20546f20636f6e76657274207061727469636c657320696e746f20656e657267792069732063616c6c6564200d0a64657061727469636c65697a6174696f6e2e20426f74682061726520686967686c7920636c617373696669656420666f7220676f6f6420726561736f6e732e2046697273746c79200d0a696d6167696e652069662065766572796f6e652068616420746865207265717569726564206465766963657320617420686f6d652e20496620736f6d656f6e652077656e7420746f0d0a204d63446f6e616c64277320616e6420626f75676874207468656d73656c76657320612063686565736562757267657220616e6420736176656420746865207061727469636c65200d0a636f6e66696775726174696f6e2062792064657061727469636c65697a696e6720697420616e642075706c6f6164696e6720746865207061727469636c65200d0a636f6e66696775726174696f6e2e20497420776f756c64207468656e20626520706f737369626c6520746f20646f776e6c6f61642074686520636865657365627572676572200d0a616e64207061727469636c65697a652069742e204261736963616c6c79206d616b696e672061206475706c6963617465206f66207468652073616d65200d0a6368656573656275726765722e205065726861707320746865206d61696e20726561736f6e20666f72207468697320736563726563792069732069662061207061727469636c65730d0a20656e6572677920776f756c642062652073636174746572656420697420776f756c6420626520746865206869676865737420706f737369626c6520616d6f756e74206f66200d0a656e657267792e204566666563746976656c7920616e206176657261676520676f6c662062616c6c20776f756c642063726561746520616e206578706c6f73696f6e206c696b6520610d0a204869726f7368696d6120626f6d622069662069747320656e7469726520656e6572677920776f756c64206265207363617474657265642e20203c6272202f3e3c6833207374796c653d22636c6561723a626f7468223e7761766520616e74697761766520706169723c2f68333e3c696d6720616c743d227061727469636c65697a6174696f6e22207374796c653d2277696474683a32393670783b6865696768743a31363170783b666c6f61743a726967687422207372633d2266696c65732f7777772f77617665253230706169722e504e4722202f3e7768656e0d0a2061206265616d206f66206c69676874206973207061727469616c79207265666c656374656420746865206265616d2069732073706c697420696e746f2074776f2070617274732e0d0a206f6e65206265616d206973207265666c656374656420746865206f7468657220636f756e74657270617274206265616d2074726176656c73207468726f75676820746865200d0a6f626a6563742e207768656e206f6e65206f6620746865206265616d732069732073746f70656420627920616e206f626a6563742069747320636f756e74657270617274200d0a6265616d2073746f707320696d65646561746c79206174207468652073616d652064697374616e63652066726f6d207768657265206974207761732073706c697420696e746f200d0a74776f2070617274732e203c6272202f3e3c6833207374796c653d22636c6561723a626f7468223e656e65726779207472616e73666572203c2f68333e3c696d6720616c743d227061727469636c65697a6174696f6e22207374796c653d2277696474683a36373070783b6865696768743a31353770783b666c6f61743a726967687422207372633d2266696c65732f7777772f656e657267792532307472616e736665722e504e4722202f3e656e657267792063616e206265207472616e736665726564207573696e672074686520636f756e7465722070617274206265616d202877617665292e207768656e206120776176650d0a2063616e63656c7320736f6d6520656e657267792073746f72656420696e207370616365206173206120706172746963656c207468652063616e63656c656420656e65726779200d0a6973207669736962656c20696e2074686520636f756e74657220776176652e20203c6272202f3e3c6833207374796c653d22636c6561723a626f7468223e74656c65706f72746174696f6e3c2f68333e7768656e0d0a20616c6c20656e6572677920746861742061207061727469636c6520636f6e7369737473206f662069732063616e63656c656420746f207a65726f207573696e6720746865200d0a636f726573706f6e64696e6720616e746977617665206265616d732074686520656e657267792077696c6c206170706561722061742074686520636f726573706f6e64696e67200d0a706f736974696f6e206f6e2074686520636f756e7465727061727420776176652e2065666665637469766c792074686520656e65726779207468617420746865200d0a7061727469636c6520636f6e7369737473206f6620686173206265656e207472616e73666572656420746f20616e6f7468657220706f736974696f6e206265636175736520616c6c0d0a2074686520656e657267792069732070726573656e7420746865207061727469636c652077696c6c20666f726d2e206e61736120686173206265656e200d0a6578706572696d656e74696e6720776974682074656c65706f72746174696f6e2e2061207265706f727465642075666f207468652074656c65706f72746174696f6e200d0a7472616e73706f72742064697363206d617920616c72656164792062652061626c6520746f2074656c65706f727420697473656c662e20203c6272202f3e3c6272202f3e3c64697620636c6173733d22636c656172223e3c2f6469763e, NULL, 0),
(NULL, 15, 'en', 0x3c68323e496d7072657373756d3c2f68323e3c7461626c653e3c74626f64793e3c74723e3c74643e4e616d653a0d0a3c2f74643e3c74643e0d0a53696c766573746572204dfc686c686175730d0a3c2f74643e3c2f74723e3c74723e3c74643e0d0a416464726573733a0d0a3c2f74643e3c74643e0d0a4b616e747374722e2031362c203830383037204dfc6e6368656e0d0a3c2f74643e3c2f74723e3c74723e3c74643e0d0a452d4d61696c3a0d0a3c2f74643e3c74643e0d0a73696c6b7966785b61745d686f746d61696c5b646f745d64650d0a3c2f74643e3c2f74723e3c74723e3c74643e0d0a44617465206f662062697274683a0d0a3c2f74643e3c74643e0d0a31332e322e313938360d0a3c2f74643e3c2f74723e3c74723e3c74643e0d0a506c616365206f722062697274683a0d0a3c2f74643e3c74643e0d0a43617374656c6c61722c20537061696e0d0a3c2f74643e3c2f74723e3c74723e3c74643e0d0a46616368626572656963683a0d0a3c2f74643e3c74643e0d0a536f66747761726520646576656c6f706d656e742c206d61696e74656e616e636520616e642074657374696e670d0a3c2f74643e3c2f74723e3c74723e3c74643e0d0a576562736974653a0d0a3c2f74643e3c74643e0d0a3c61207461726765743d225f626c616e6b2220687265663d22687474703a2f2f76626d73636f64652e636f6d223e76626d73636f64652e636f6d3c2f613e3c2f74643e3c2f74723e3c2f74626f64793e3c2f7461626c653e, NULL, 0),
(NULL, 22, 'en', 0x3c68333e3c696d67207374796c653d22666c6f61743a726967687422207372633d2266696c65732f7777772f636576696c69616e2e504e4722202f3e426c61636b2050726f6a656374732028636576696c69616e20636f6e74726f6c6c293c2f68333e636576696c69616e20636f6e74726f6c6c206973206f667465726e20646f6e652077697468204243492028627261696e20636f6d707574657220696e7465726661636529206f667465726e2070656f706c652077696c6c206265207573656420746f2063726561746520706f6c69746963616c2070726f626c656d732e20736f6d65207265706f72742075666f207369676874696e67732c20616c69616e20616264756374696f6e7320616e64206b6e6f776c616765206f662073656372657420746563686e6f6c6f676965732e207468652076696374756d73206172652062726f6b656e20736f6369616c792c2073657875616c7920616e6420706572736f6e616c792e204243492063616e206265207573656420746f207472616e736d697420736f756e64732c20696d616765732c20736d656c6c732c2066616b65206d656d6f7269657320616e642074686f75676874732e207468652076696374756d73206d6179207265706f72742074656c65706174686963206361706162696c69746569732e2073796e7468657469632074656c657061746879206578697374732073696e63652031393637206163636f7264696e6720746f2077696b69706564696120616e6420697320646f6e652077697468204243492e20692077696c6c206578706c61696e20736f6d65206f6620746865206d6574686f647320616e6420746563686e6f6c6f67696573207573656420746861742069206c6561726e65642061626f757420647572696e67206d7920657870657269656e63652e3c6272202f3e0d0a3c6120687265663d223f6e3d5061727469636c65697a6174696f6e26616d703b703d313022207461726765743d225f626c616e6b223e3c68333e5061727469636c65697a6174696f6e3c2f68333e3c2f613e20436f6e76657274696e6720656e6572677920746f206d61737320616e64207472616e73706f7274206f66206d61737320617320656e657267792e3c6272202f3e0d0a3c6120687265663d223f6e3d4d696e642b436f6e74726f6c26616d703b703d313422207461726765743d225f626c616e6b223e3c68333e4d696e64436f6e74726f6c3c2f68333e3c2f613e204d6f6465726e20627261696e20636f6d707574657220696e74657266616365207573696e67207175616e74756d20656e746167656c6d656e7420616e64206d7920657870657269656e6365732e3c6272202f3e0d0a3c6120687265663d223f6e3d55464f7326616d703b703d313522207461726765743d225f626c616e6b223e3c68333e55464f733c2f68333e3c2f613e204d696c6974617279207370616365206372616674207573696e672074656e73696f6e2063616e63656c696e672e3c6272202f3e0d0a3c6120687265663d223f6e3d5468652b476c6f636b6526616d703b703d323722207461726765743d225f626c616e6b223e3c68333e54686520476c6f636b653c2f68333e3c2f613e20416e6369656e742073656372657420746563686e6f6c6f6769652074686520686f6c6f6772617068696320756e6976657273652067656e657261746f722e, NULL, 0),
(NULL, 23, 'en', 0x3c68333e5075626c69632061776172656e6573733c2f68333e3c68333e3c2f68333e3c696d67207374796c653d22666c6f61743a72696768743b77696474683a32353370783b70616464696e672d6c6566743a3230707822207372633d2266696c65732f7777772f627261696e436f6d7075746572496e746572666163652e504e4722202f3e6d6f73742070656f706c6520617265206e6f74206177617265206f66207468652063757272656e74207374617465200d0a6f6620746563686e6f6c6f677920726567617264696e67206263692e206263692063616e206265207573656420746f20706572666f726d2073796e746865746963200d0a74656c6570617468792077696b69706564696120636f6e6669726d732074686174207468697320686173206265656e2070726f76656e20706f737369626c652073696e6365200d0a313936372e20687474703a2f2f656e2e77696b6970656469612e6f72672f77696b692f53796e7468657469635f74656c657061746879206d6f6465726e20776972656c6573730d0a206263692075736520227175616e74756d20656e74616e676c656d656e742220746f206d65737375726520616e64206170706c79200d0a766f6c746167657320696e2074686520627261696e2e2070687963686f74726f6e6963732069732074686520776561706f6e20666f726d206f662073796e746865746963200d0a74656c65706174687920697420776173206f6666696369616c79207573656420696e207468652069726171207761722062792074686520616d65726963616e2061726d792e200d0a746865736520776972656c657373206263692061726520636c617373696669656420626563617573652070686f746f6e2074656c65706f72746174696f6e2069732075736564200d0a746f2065737461626c697368207061727469636c65206475616c6974792e20636f6d756e69636174696f6e206f766572207175616e74756d20656e74616e676c656d656e74200d0a68617070656e7320696e7374616e746c792c20636f6d756e69636174696f6e206d6574686f647320717569636b6572207468616e20746865207370656564206f66206c69676874200d0a616e6420616e7920666f726d206f662074656c65706f72746174696f6e20697320636c61737369666965642e3c6272202f3e3c6833207374796c653d22636c6561723a626f7468223e5175616e74756d20456e74616e676c656d656e743c2f68333e496620736f6d65206f662074686520656e6572677920746861742061200d0a7061727469636c6520636f6e7369737473206f66206973207472616e73666572656420746f20616e6f74686572207061727469636c6520736f20746861742074776f200d0a7061727469636c657320686176652065786368616e67656420736f6d6520656e657267792e2061206c696e6b207065727369737473206265747765656e207468652074776f200d0a7061727469636c65732e207468657920617265207468656e206475616c6564207061727469636c65732e207768656e206174746d6f7320617265206475616c6564206966206f6e650d0a206f662074686520656c656374726f6e7320696e206f6e65206f6620746865206174746f6d7320696f6e697a6573207468656e20746865206f746865722061746f6d2077696c6c200d0a616c736f200d0a696f6e697a652e2054686973206566666563740d0a2068617070656e7320696e7374616e746c79206f76657220616e792064697374616e63652e20746865206566666563742063616e206265207573656420746f200d0a636f6d756e696361746520696e7374616e746c79206f76657220616e792064697374616e63652e3c6272202f3e3c68333e427261696e20436f6d707574657220496e746572666163652028424349293c2f68333e5175616e74756d0d0a20656e74616e676c656d656e742020206973207573656420746f20696e206d6f6465726e20627261696e20636f6d707574657220696e74657266616365732e207768656e2061200d0a7369676e616c206973207472616e7366657265640d0a2066726f6d206f6e6520627261696e20746f20616e6f7468657220746865207375626a6563742077696c6c206e6f746963652e20466f72206578616d706c652069662061200d0a706572736f6e206c6f6f6b7320617420612072656420626f726420616e6420746865207369676e616c206973207472616e7366657265642066726f6d206f6e65206f70746963616c0d0a206e6572766520746f20616e6f7468657220746865206f7468657220706572736f6e2077696c6c20736565207468652072656420626f6172642e204966207369676e616c73200d0a66726f6d200d0a736f6d65206c6f626573206f662074686520627261696e206172652065786368616e6765642074686f676874732c20736d656c6c732c20746f6e65732c200d0a696d6167657320616e64206665656c696e67732063616e206265207472616e7366657265642066726f6d206f6e6520706572736f6e20746f20616e6f746865722e20626369200d0a7761732064656d6f6e737472617465642061742074686520776f726c6473206c61726765737420636f6d756e69636174696f6e7320666169722c200d0a69742077617320706f737369626c6520746f206275792074656c6570617468792c20746869732077696c6c2068617665206265656e207573696e672042434920746f200d0a636f6d756e696361746520617564696f207369676e616c732066726f6d206f6e6520706572736f6e20746f20616e6f746865722e20203c6272202f3e3c6833207374796c653d22636c6561723a626f7468223e4d697373696e67206c6177732e3c2f68333e3c696d67207374796c653d22666c6f61743a72696768743b70616464696e672d6c6566743a3230707822207372633d2266696c65732f7777772f68616d6d65722e504e4722202f3e54686572650d0a2069732061206c61772070726f626c656d20696e204765726d616e792c206974206973206c6567616c20746f20746f727475726520746572726f72697374732e204c696b65200d0a6d616e79206c61777320746869732077696c6c2073696d706c792062652075736564206173206120776f726b2061726f756e6420696e2074686973206361736520746f200d0a656e61626c652070656f706c6520746f20626520746f7274757265642e20666f72206578616d706c6520696620736f6d656f6e6520636f6d706c61696e732061626f75742061200d0a706f6c696365206d616e206265696e6720616772657373697665207468656e2069747320636f6d706c61696e696e672061626f7574202273746161747320676577616c7422200d0a286765726d616e20776f7264292c2070656f706c652077686f20646f20736f206172652022737461617473206665696e642220286765726d616e20776f7264292e2061200d0a22737461617473206665696e64222063616e20626520612074797065206f6620746572726f726973742e20736f20697420697320706f737369626c6520746f20746f7274757265200d0a736f6d656f6e6520666f7220636f6d706c61696e696e672061626f75742074686520706f6c6963652068697474696e6720736f6d656f6e65206f7220617320696e206d79200d0a636173652074686174206920636f6d706c61696e65642061626f75742074686520706f6c6963652073656c6c696e67206472756773207468656e2077617320746f727475726564200d0a616e64207361696420746f206265206120746572726f726973742e206120706f737369626c65206c617720776f756c64206265207468617420696620736f6d656f6e65206973200d0a746f20626520746f72747572656420666f7220616e7920726561736f6e20746861742061207075626c696320636f75727420636173652069732072657175697265642077686572650d0a20746865207375626a65637420617474656e647320696e20706572736f6e20616c736f207468652074656c657061746869632061747461636b6572206d7573742072657665696c200d0a6869732074727565206964656e7469747920736f207468617420636f6d706c61696e74732061726520706f737369626c652e203c6272202f3e3c6833207374796c653d22636c6561723a626f7468223e4d7920546f72747572652e3c2f68333e4e696e650d0a2079656172732061676f2061206a756467652074616c6b656420746f206d65207573696e67204243492e204261636b207468656e204920686172646c79206e6f74696365642074686174206920776173206265696e6720696e7465726f67617465642e20496e203230313120492077656e7420746f20616e20756e646572636f76657220636f7020746f206275792074776f206772616d73206f6620776565642e200d0a4865207761732077616e74696e6720746f2061736b207175657374696f6e732061626f757420736f6d652064727567206465616c65727320616e6420776173207665727920616767726573736976652e20490d0a2073756767657374656420746f20636f6d706c61696e20746861742074686520706f6c69636520686164206265656e2073656c6c696e6720647275677320626563617573652049200d0a6469646e2774206c696b65207468652061676772657373696f6e2070617274206f662069742e20492077617320666f7263656420746f2074616b696e6720313030206772616d73200d0a6f662068617368206f6666206f662068696d207769746820626f64696c792061676772657373696f6e20616e64207468726561742e2053696e6365207468656e20492068617665200d0a6265656e20746865207375626a656374206f6620612062636920696e746572726f676174696f6e2e204974206973206e6f74206a75737420616e20696e746572726f676174696f6e0d0a2061626f7574206472756720747261696420616e796d6f726520746865792068617665206265656e20746f72747572696e67206d652e2054686579206361757365207061696e20616e640d0a20746872656174656e20746f206b696c6c206d65206576657279206461792e205468652061747461636b657220636c61696d7320686973206964656e7469747920746f206265200d0a74686520626e6420616e642073686f757473206174206d652074686174206920616d206120746572726f72697374207768696c652068757274696e67206d6520616c6c20646179200d0a6c6f6e672e206920646f206e6f7420696e74656e6420746f206875727420616e796f6e65206f72206d7973656c6620736f206920616d206e6f74206120746572726f72697374200d0a496d206a757374206120736f66747761726520646576656c6f70657220616e6420646f206e6f74206465736572766520746f20626520746f727475726564206c696b65200d0a746869732e2054686973206a75646765207468617420686173206265656e20696e766f6c76656420686173206261646c792062726f6b656e20746865206c61772c206865200d0a616c736f2073686f7773206d6520696d61676573206f6620746572726f722061747461636b7320616e6420737567676573747320697420746f206265206d792074686f756768742c0d0a20647572696e6720612062636920636f7572742063617365206920636f756c64206e6f7420636f6e74726f6c206d792073746174656d656e747320746865792073696d706c79200d0a676574206d6520746f20736179207768617420746865792077616e7420746f20686561722e20696d206120736f66747761726520646576656c6f706572207468617420646f7365200d0a6e6f7420696e74656e64206861726d20746f20616e796f6e65206163636f7264696e6720746f2074686973206a7564676520696d206120746572726f726973742e203c6272202f3e3c68333e53746f7020546f72747572652e3c2f68333e43616e0d0a20796f7520706c656173652073746f70207468697320746f72747572652e204f6e652077617920746f20646f207468697320776f756c6420626520746f2074656c6c207468656d200d0a746f2073746f7020646f696e672069742e20416e6f746865722077617920776f756c642062652077697468207175616e74756d20656e74616e676c656d656e74206d6574686f642c0d0a20746f2072656d6f76652074686520626369206279207265676973746572696e672061206e6577206f6e652e20546869732061747461636b657220686173206265656e200d0a636f756c73696e6720706f6c69746963616c20736974756174696f6e732e2041667465722074656c6c696e67206d6520746f2073656c6c2077656564206d79206d6f74686572200d0a7761732073756767657374656420746f2062652074686520456e676c6973682074656163686572206f6620746865207072696e63657373206f6620546861696c616e64206279200d0a746865206765726d616e20676f7665726e6d656e742e20416c736f206d792062726f7468657220616e64206d6f746865722061726520667269656e6473207769746820736f6d65200d0a6d656d62657273206f66207573206465706172746d656e74206f6620737461746520736f206920616d206e6f2077617920616c6c6f77656420746f2062652063616c6c6564206f720d0a206265206120746572726f726973742e20692077617320616c736f20666f7263656420696e746f2062656c696576696e6720746861742074686520707265736964656e74206f66200d0a537061696e20616e642074686520707265736964656e74206f66204974616c792061726520696e766f6c76656420696e20647275672074726961642e20496e206120626369200d0a636f757274206361736520692077617320666f7263656420746f206d616b652073746174656d656e747320746861742074686579207765726520696e766f6c76656420696e200d0a647275672074726961642e20536f6d65206f662074686973206163746976697469657320686173206265656e2063616c6c656420626c61636b2070726f6a656374732e204966200d0a74686973206973204765726d616e79277320626c61636b2070726f6a656374732c2073696d706c79206d616b696e672074726f75626c65207468656e20706c656173652074656c6c0d0a207468656d20746f2067726f7720757020616e64206d616b6520736f6d652075666f73206f722073756368206c696b6520696e73746561642e20200d0a3c6272202f3e3c6272202f3e3c64697620636c6173733d22636c656172223e3c2f6469763e, NULL, 0),
(NULL, 28, 'en', 0x3c68333e3c696d67207374796c653d22666c6f61743a72696768743b70616464696e672d6c6566743a3230707822207372633d2266696c65732f7777772f74656e73696f6e2e504e4722202f3e55464f73202f20466c79696e67206469736373202f206d696c697461727920737061636520637261667420203c2f68333e466c79696e6720646973637320617265207265706f7274656420616c6c206f7665722074686520776f726c642e205468657365207365656d20746f206265206d696c6974617279207370616365206372616674207468617420617265206b657074207365637265742e2054686520726561736f6e207768792074686579206172652073656372657420697320626563617573652074686572652070726f70756c73696f6e2073797374656d20646f7365206e6f742075736520656e657267792e2054656e73696f6e2063616e63656c696e672063616e206265207573656420746f20637265617465207075736820696e2061206365727461696e20646972656374696f6e206f72206c6f7373206f66207765696768742e20546865206669677572652073686f77732074776f206d61676e657420636f6e6573207468617420726570656c2065616368206f746865722c20776974682074686520746f707320637574206f66662c20666f7263656420746f67657468657220776974682074776f206d6574616c20706c6174657320616e642061206e757420616e6420626f6c7420686f6c64696e67207468652061707061726174757320746f6765746865722e2054686520626c7565206c696e65732073686f772074686520726570656c6c696e6720666f72636520766563746f722074686520726564206c696e65732073686f772074686520636f6d706f6e656e7473206f662074686520666f7263652e2054686520686f72697a6f6e74616c20636f6d706f6e656e7473206f6620666f726365206172652063616e63656c656420746f207a65726f2061732074656e73696f6e2e2054686572652062792074686520766572746963616c20666f72636520776f756c64206e6f7420657175616c207468652074656e73696f6e20696e20746865206e757420616e6420626f6c742e205468652061707061726174757320776f756c64207765696768206c657373207768656e20617373656d626c6564207468616e2069747320696e646976696475616c207061727473207768656e20776569676865642073657061726174656c792e2054686520726561736f6e20776879207468697320697320736563726574206973206265636175736520697420646f7365206e6f74206275726e206675656c20616e642063616e206265207573656420746f2063726561746520656e657267792e20203c6272202f3e3c6272202f3e3c64697620636c6173733d22636c656172223e3c2f6469763e, NULL, 0),
(NULL, 35, 'en', 0x3c68323e7068705061636b65723c2f68323e3c703e4372656174657320616e20696e7374616c6c657220666f7220706870206170706c69636174696f6e732e20203c6272202f3e3c2f703e3c68333e4465736372697074696f6e3a3c2f68333e3c703e4561737920746f207573652073696d706c7920707574207468652066696c6520696e746f20746865206469726563746f727920796f75207769736820746f207061636b200d0a696e746f20616e20696e7374616c6c65722c2073656c6563742074686520726f6f74206469726563746f727920616e6420746865206e616d65206f6620746865200d0a696e7374616c6c65722066696c65207468656e2073706563696669792077697463682066696c652073686f756c64206265207265646972656374656420746f206166746572200d0a74686520696e7374616c6c657220686173206265656e2065786563757465642e203c2f703e3c703e54686520696e7374616c6c65722066696c652074686174206973200d0a63726561746564206279207068705061636b65722073746f72657320616c6c2066696c657320696e20636f6d7072657373656420737461746520616c6c207061636b6564200d0a696e746f206f6e65207068702066696c652e205768656e2074686520696e7374616c6c65722069732065786563757465642069742073696d706c7920756e7061636b7320746865200d0a66696c657320616e642072656469726563747320746f20746865206e6578742066696c6520666f72206578616d706c6520696e6465782e7068702e203c2f703e20203c68333e446f776e6c6f61643a3c2f68333e3c703e7068705061636b657220697320686f7374656420627920636f64652e676f6f676c652e636f6d203c61207461726765743d225f626c616e6b2220687265663d22687474703a2f2f636f64652e676f6f676c652e636f6d2f702f7068707061636b6572223e446f776e6c6f6164207068705061636b65723c2f613e3c2f703e, NULL, 0),
(NULL, 36, 'en', 0x3c68323e3c696d67207374796c653d2277696474683a34343670783b6865696768743a32343870783b666c6f61743a726967687422207372633d22687474703a2f2f6c6f63616c686f73742f76626d73636d732f66696c65732f7777772f70706d6f62696c2e504e4722202f3e7a65726f20656e657267792070756d703c2f68323e20203c696d67207374796c653d22666c6f61743a72696768743b77696474683a3070783b6865696768743a30707822207372633d22687474703a2f2f6c6f63616c686f73742f76626d73636d732f66696c65732f7777772f70706d6f62696c2e504e4722202f3e412070756d70207468617420646f7365206e6f742075736520656e65726779206f72206275726e206675656c2069742063616e206265207573656420746f2063726561746520656e657267792e3c6272202f3e3c68323e4465736372697074696f6e3c2f68323e5468652074616e6b206973207375626d657267656420756e6465722077617465722e3c6272202f3e506970652066726f6d2076616c7665203120676f65732066726f6d2074686520696e73696465206f6620626f74746f6d206f66207468652074616e6b20746f2074686520737572666163652e3c6272202f3e56616c7665203220636f6e6e6563747320696e73696465206f662074616e6b20746f206f757473696465206f662074616e6b2e20203c6272202f3e3c6272202f3e3c6272202f3e3c6469763e3c7374726f6e673e3c2f7374726f6e673e3c2f6469763e3c7374726f6e673e537461746520313a203c2f7374726f6e673e3c6272202f3e76616c76652031206973206f70656e20616e642076616c7665203220697320636c6f7365642e3c6272202f3e496e7465726e616c20707265737375726520697320736c696768746c792061626f766520312041544d2e204966206d6f726520707265737375726520697320696e207468652074616e6b20776174657220776f756c6420636f6d65206f7574206f662076616c766520312e3c6272202f3e3c6272202f3e3c7374726f6e673e537461746520323a3c2f7374726f6e673e3c6272202f3e76616c7665203120697320636c6f73656420616e642076616c76652032206973206f70656e2e3c6272202f3e576174657220776f756c6420676f20696e746f207468652074616e6b20696e6372656173696e67207468652061697220707265737375726520746f2061626f766520322041544d2e3c6272202f3e3c6272202f3e3c7374726f6e673e537461746520333a3c2f7374726f6e673e3c6272202f3e76616c7665203220697320636c6f73656420616e642076616c76652031206973206f70656e2e3c6272202f3e576174657220776f756c6420676f206f7574206f662076616c7665203120756e74696c207374617465203120697320726561636865642e3c6272202f3e3c6272202f3e3c7374726f6e673e4d656368616e6963733a3c2f7374726f6e673e3c6272202f3e610d0a207377696d6d657220696e73696465207468652074616e6b20676f657320757020647572696e67207374617465203220616e64206261636b20646f776e20647572696e67200d0a7374617465203320616e642070726f766964657320656e6572677920746f206f70656e20616e6420636c6f7365207468652076616c7665732e20203c6272202f3e3c6272202f3e3c6872202f3e, NULL, 0),
(NULL, 37, 'en', 0x3c68323e3c696d67207374796c653d22666c6f61743a726967687422207372633d2266696c65732f7777772f666f726d456469746f722e504e472220616c743d222022202f3e466f726d456469746f723c2f68323e53696d706c65206a717565727920666f726d20656469746f723c6272202f3e3c68323e4465736372697074696f6e3c2f68323e546865206964656120697320746f20616c6c6f772074686520757365722f61646d696e20746f2062652061626c6520746f206564697420666f726d73207065722064726167200d0a64726f702e2020697473207772697474656e2077697468206a71756572792e20627920657874656e64696e6720616e20616273747261637420666f726d4974656d20636c617373200d0a697420697320706f737369626c6520746f20696e636c75646520796f7572206f776e20666f726d20776964676574732074686520666f726d732063616e20696e636c756465200d0a76616c69646174696f6e2e20203c6272202f3e3c68323e446f776e6c6f61643c2f68323e736f7572636520697320686f7374656420617420676f6f676c65203c61207461726765743d225f626c616e6b2220687265663d22687474703a2f2f636f64652e676f6f676c652e636f6d2f702f76626d732d666f726d2d656469746f722f223e646f776e6c6f616420706167653c2f613e20203c6272202f3e3c6272202f3e3c6872202f3e, NULL, 0),
(NULL, 12, 'en', '', NULL, 0),
(NULL, 38, 'en', 0x3c68313e546572726f72697374204c61772050726f626c656d20203c2f68313e3c6469763e496e204765726d616e79206974206973206c6567616c20746f20746f727475726520746572726f72697374732e203c6272202f3e3c68333e3c696d67207374796c653d2277696474683a32353370783b6865696768743a32303070783b666c6f61743a726967687422207372633d22687474703a2f2f6c6f63616c686f73742f76626d73636d732f66696c65732f7777772f68616d6d65722e504e4722202f3e536974756174696f6e3c2f68333e0d0a2020496e204765726d616e79206974206973206c6567616c20746f20746f727475726520746572726f72697374732e202054686973206c6561647320746f2061206c6172676572200d0a6e756d626572206f6620746572726f72697374732e205468657920617265207265676973746572656420746f20626520746572726f726973747320736f20746861742074686579200d0a63616e206c6567616c6c7920626520746f7274757265642e20496620697420776f756c64206e6f74206265206c6567616c20746f20746f727475726520746572726f7269737473200d0a7468656e2074686520676f7665726e6d656e7420776f756c64207265676973746572206c6573732070656f706c6520746f20626520746572726f72697374732e20496e200d0a6f7264657220746f2070726f7465637420696e6e6f63656e7420636976696c69616e73206f6e652073686f756c64206769766520746572726f7269737473206d6f7265200d0a7269676874732e203c2f6469763e203c68333e506f737369626c65204e6565646564204c6177733c2f68333e3c6f6c3e3c6c693e2020546572726f726973747320617265206e6f7420616c6c6f77656420746f20626520746f7274757265642e266e6273703b3c2f6c693e3c6c693e496e206f7264657220666f7220736f6d656f6e6520746f206265207265676973746572656420617320746572726f726973742074686579206d75737420706879736963616c6c79200d0a617474656e642061206c6567616c206f70656e20636f75727420636173652028776974686f75742074656c6570617468792920776865726520746865792061726520666f756e64200d0a746f206265206775696c7479206f6620746572726f7269736d2e266e6273703b3c2f6c693e3c6c693e4d616e6970756c6174696e67206120636976696c69616e20696e746f207468696e6b696e6720746572726f726973742074686f756768747320697320616e20616374206f66200d0a746572726f7269736d2062792074686520706572736f6e2077686f2077617320706572666f726d696e6720746865206d616e6970756c6174696f6e2e266e6273703b3c2f6c693e3c6c693e546f72747572696e67206120636976696c69616e20697320616e20616374206f6620746572726f7269736d2e266e6273703b3c2f6c693e3c6c693e46616c73656c79207265706f7274696e67206120636976696c69616e206173206120746572726f7269737420746f20636f7572736520706f6c69746963616c2070726f626c656d7320697320616e20616374206f6620746572726f7269736d2e266e6273703b3c2f6c693e3c6c693e46616c73656c79207265706f7274696e67206120636976696c69616e206173206120746572726f7269737420696e206f7264657220746f20746f7274757265207468656d20697320616e20616374206f6620746572726f7269736d2e3c2f6c693e3c6c693e46616c73656c79207265706f7274696e67206120636976696c69616e20746f206265206120746572726f7269737420697320616e20616374206f6620746572726f7269736d2e266e6273703b3c2f6c693e3c6c693e436f6d706c61696e696e672061626f757420636f7272757074206163746976697469657320746861742074686520676f7665726e6d656e7420697320696e766f6c76656420696e206973206e6f7420616e20616374206f6620746572726f7269736d2e266e6273703b3c2f6c693e3c6c693e50656f706c6520617265206e6f7420746572726f72697374732062656361757365206f662072656c6967696f6e2c20706c616365206f662062697274682c20726163652c20706f6c69746963616c206f72206574686963616c206f70696e696f6e2e3c2f6c693e3c2f6f6c3e, NULL, 0),
(NULL, 32, 'en', 0x3c68333e54686520476c6f636b652028486f6c6f6772617068696320556e6976657273652047656e657261746f72293c2f68333e203c696d67207374796c653d22666c6f61743a72696768743b70616464696e672d6c6566743a323070783b77696474683a333234707822207372633d2266696c65732f7777772f556e62656e616e6e742e504e4722202f3e496e20746865207365636f6e6420776f726c64207761722041646f6c66204869746c657220616e6420746865204765726d616e2061726d79207265736561726368656420616e6369656e7420746563686e6f6c6f6769657320616e64207765726520696e20736561726368206f662077686174207468657920636f6e736964657265642074686520686f6c7920677261696c2e2041646f6c66204869746c65722074686f7567687420746865792068616420666f756e642069742e2054686579207765726520646576656c6f70696e672061207365637265742064657669636520746861742074686579206e616d65642074686520676c6f636b652e2054686520676c6f636b65207761732061206c697175696420737461746520686f6c6f6772616d2067656e657261746f722061206b696e64206f6620686f6c6f6772617068696320756e6976657273652067656e657261746f722e20546f20756e6465727374616e642077686174206973206d65616e7420636f6e736964657220612063616d65726120706f696e74656420696e746f20612074656c65766973696f6e20746861742069732073686f77696e672074686520696d6167652066726f6d207468652063616d6572612e205468652074656c65766973696f6e2077696c6c20646973706c617920696e66696e69746520696d6167657320696e736964652065616368206f746865722e204561636820696d61676520697320736570617261746564206279206f6e652074696d6520737465702c207468652074696d6520746861742069742074616b657320666f722074686520696d6167652066726f6d207468652063616d65726120746f20626520646973706c61796564206f6e207468652074656c65766973696f6e2073637265656e2e204561636820726563757273696f6e20697320616e20696d616765206675727468657220696e2074686520706173742e2054686520676c6f636b65207468656f72792069732074686174207370696e6e696e6720706c61736d612063616e20636f7572736520612072656672616374696f6e206f66206c696768742070726f647563696e6720616e20696d616765206f662074686520696e707574206c696768742e20496e2074686520696d616765207468657265206973206675727468657220696e66696e69746520726563757273696f6e73206f66207468652073616d6520696d6167652073696d696c617220746f207468652063616d6572612061742074656c65766973696f6e206566666563742e204561636820696d61676520697320736570617261746564206279206f6e652074696d6520737465702c20746865206d696e696d756d2073746570206f6620612070686f746f6e2e2054696d652063616e20626520636f6e736964657265642061732074686520737465702066726f6d206f6e6520696d61676520746f20746865206e657874206f7220746865206d696e696d756d2073746570206f6620612070686f746f6e2e20497420776173206d656e74696f6e65642062792061205275737369616e2075666f2065787065727420696e206120766964656f2069207761746368656420696e20796f75747562652c2077687920776520646f206e6f74206d656574206265696e6773207468617420686176652074726176656c656420746f20706c616e65742065617274682c20626563617573652074686520686176652073756368206120746563686e6f6c6f676965732e20546865792073696d706c7920637265617465206120686f6c6f6772616d206f662074696d6520616e64206d65657420757320696e2074686520686f6c6f6772616d207468656e2064656369646520696620746861742773207768617420746865792077616e7420746f20646f206f72206b65657020747279696e67206e657720636f6d62696e6174696f6e73206f662074696d652e20203c6272202f3e3c6833207374796c653d22636c6561723a626f7468223e5768617420696620746865206675747572652068617070656e656420696e2074686520706173743c2f68333e202020202020203c696d67207374796c653d22666c6f61743a72696768743b70616464696e672d6c6566743a3230707822207372633d2266696c65732f7777772f6d61646f6e61322e504e4722202f3e4d616e7920736369656e7469737473206861766520636f6e7369646572656420746865207175657374696f6e20636f756c64206120756e69766572736520636f756c6420657869737420696e73696465206120756e6976657273652e2049662073756368206120746563686e6f6c6f67696573206578697374732061732074686520686f6c6f6772617068696320756e6976657273652067656e657261746f7220776865726520697420697320706f737369626c6520746f207265706c6179206c696768742e204f757473696465206f66207468697320756e697665727365207765206d6967687420616c726561647920626520696e207468652066757475726520696e736964652061206465766963652074686174207265706c6179732074696d652e204966206120737061636520637261667420746861742069732063617061626c65206f662073757065726c756d696e616c2074656c65706f72746174696f6e2c2074656c65706f7274732032303133206c6967687420796561727320617761792066726f6d20656172746820746865206c696768742074726176656c696e6720617761792066726f6d207468652065617274682061742074686174206c6f636174696f6e2077696c6c206265206f66207468652074696d65207768656e204a6573757320776173206f6e2065617274682e204966207468652063726577207765726520746f20637265617465206120686f6c6f6772616d206f662074686174206c696768742074696d6520776f756c64207265706c61792066726f6d207468652079656172203020616761696e2e20416c736f2074686520637261667420776f756c6420626520696e2074686520686f6c6f6772616d2032303133206c6967687420796561727320617761792066726f6d2065617274682e2049662074686520637261667420696e2074686520686f6c6f6772616d2077617320746f2074656c65706f7274206261636b20746f206561727468207468657920776f756c642061727269766520696e20746865207965617220302e204a75737420696e2074696d6520746f207769746e65737320746865206269727468206f66204a657375732e204d6179207468697320656666656374206578706c61696e207468652070726573656e6365206f6620616e6369656e742073706163652063726166742e20203c6272202f3e3c6272202f3e3c64697620636c6173733d22636c656172223e3c2f6469763e, NULL, 0),
(NULL, 28, 'en', 0x3c68333e3c696d67207374796c653d22666c6f61743a72696768743b70616464696e672d6c6566743a3230707822207372633d2266696c65732f7777772f74656e73696f6e2e504e4722202f3e55464f73202f20466c79696e67206469736373202f206d696c697461727920737061636520637261667420203c2f68333e466c79696e6720646973637320617265207265706f7274656420616c6c206f7665722074686520776f726c642e205468657365207365656d20746f206265206d696c6974617279207370616365206372616674207468617420617265206b657074207365637265742e2054686520726561736f6e207768792074686579206172652073656372657420697320626563617573652074686572652070726f70756c73696f6e2073797374656d20646f7365206e6f742075736520656e657267792e2054656e73696f6e2063616e63656c696e672063616e206265207573656420746f20637265617465207075736820696e2061206365727461696e20646972656374696f6e206f72206c6f7373206f66207765696768742e20546865206669677572652073686f77732074776f206d61676e657420636f6e6573207468617420726570656c2065616368206f746865722c20776974682074686520746f707320637574206f66662c20666f7263656420746f67657468657220776974682074776f206d6574616c20706c6174657320616e642061206e757420616e6420626f6c7420686f6c64696e67207468652061707061726174757320746f6765746865722e2054686520626c7565206c696e65732073686f772074686520726570656c6c696e6720666f72636520766563746f722074686520726564206c696e65732073686f772074686520636f6d706f6e656e7473206f662074686520666f7263652e2054686520686f72697a6f6e74616c20636f6d706f6e656e7473206f6620666f726365206172652063616e63656c656420746f207a65726f2061732074656e73696f6e2e2054686572652062792074686520766572746963616c20666f72636520776f756c64206e6f7420657175616c207468652074656e73696f6e20696e20746865206e757420616e6420626f6c742e205468652061707061726174757320776f756c64207765696768206c657373207768656e20617373656d626c6564207468616e2069747320696e646976696475616c207061727473207768656e20776569676865642073657061726174656c792e2054686520726561736f6e20776879207468697320697320736563726574206973206265636175736520697420646f7365206e6f74206275726e206675656c20616e642063616e206265207573656420746f2063726561746520656e657267792e20203c6272202f3e3c6272202f3e3c64697620636c6173733d22636c656172223e3c2f6469763e, NULL, 0);
INSERT INTO `t_wysiwygpage` (`id`, `pageid`, `lang`, `content`, `title`, `area`) VALUES
(NULL, 39, 'en', 0x3c68323e50726f66696c652053696c766573746572204dfc686c686175733c2f68323e3c703e54686973206973206d792070726f66696c6520706167652074686174204920616d207573696e670d0a746f206170706c7920666f722061206a6f62206173206120736f66747761726520646576656c6f706572206f7220736f667477617265207465737465722e20496620796f752061726520696e74657265737465640d0a706c6561736520636f6e74616374206d652070657220656d61696c206f722063616c6c206d65206f6e206d79206d6f62696c652e20596f752063616e20616c736f20646f776e6c6f6164206d79206365727469666963617465732c206578616d20726573756c747320616e64207468697320646f63756d656e74203c6120687265663d222f66696c65732f7777772f63762e7a6970223e686572653c2f613e206f7220617320706466203c6120687265663d222f66696c65732f7777772f63762e706466223e686572653c2f613e3c6272202f3e3c6120687265663d222f66696c65732f7777772f63762e7a6970223e3c2f613e3c2f703e0d0a3c6872202f3e0d0a3c7461626c652077696474683d2231303025223e3c74626f64793e3c74723e3c746420636c6173733d22636f6e74726174223e0d0a3c68333e44657461696c733a3c2f68333e0d0a3c7461626c6520636c6173733d226e6f77726170223e3c74626f64793e3c74723e3c74643e0d0a4e616d653a0d0a3c2f74643e3c74643e0d0a53696c766573746572204dfc686c686175730d0a3c2f74643e3c2f74723e3c74723e3c74643e0d0a416464726573733a0d0a3c2f74643e3c74643e0d0a4b616e747374722e2031362c203830383037204dfc6e6368656e0d0a3c2f74643e3c2f74723e3c74723e3c74643e0d0a54656c3a0d0a3c2f74643e3c74643e0d0a3031373633383834353934320d0a3c2f74643e3c2f74723e3c74723e3c74643e0d0a452d4d61696c3a0d0a3c2f74643e3c74643e0d0a73696c6b7966785b61745d686f746d61696c2e64650d0a3c2f74643e3c2f74723e3c74723e3c74643e0d0a44617465206f662062697274683a0d0a3c2f74643e3c74643e0d0a31332e322e313938360d0a3c2f74643e3c2f74723e3c74723e3c74643e0d0a506c616365206f722062697274683a0d0a3c2f74643e3c74643e0d0a43617374656c6c61722c20537061696e0d0a3c2f74643e3c2f74723e3c74723e3c74643e0d0a46616368626572656963683a0d0a3c2f74643e3c74643e0d0a536f66747761726520646576656c6f706d656e742c206d61696e74656e616e636520616e642074657374696e670d0a3c2f74643e3c2f74723e3c74723e3c74643e0d0a576562736974653a0d0a3c2f74643e3c74643e0d0a3c61207461726765743d225f626c616e6b2220687265663d22687474703a2f2f76626d73636f64652e636f6d223e76626d73636f64652e636f6d3c2f613e0d0a3c2f74643e3c2f74723e3c2f74626f64793e3c2f7461626c653e0d0a3c2f74643e3c746420636c6173733d22657870616e6420616c69676e5269676874223e0d0a3c696d67207374796c653d2277696474683a31353370783b6865696768743a313938707822207372633d2266696c65732f7777772f73696c6b612e504e4722202f3e0d0a3c2f74643e3c2f74723e3c2f74626f64793e3c2f7461626c653e0d0a3c6272202f3e0d0a3c6872202f3e3c68333e4c616e6775616765733a3c2f68333e3c703e4765726d616e20616e6420456e676c6973682028626f746820706572666563740d0a626563617573652069206772657720757020696e20456e676c616e64293c2f703e20200d0a3c6872202f3e3c68333e4f7065726174696e672073797374656d733a3c2f68333e3c703e57696e646f777320616e64204c696e75783c2f703e20200d0a3c6872202f3e3c68333e50726f6772616d6d696e6720736b696c6c733a3c2f68333e3c703e492068617665206d6f7265207468616e20313020796561727320686f6262790d0a70726f6772616d6d696e6720657870657269656e636520616e642068617665206265656e20776f726b696e6720617320612070726f6772616d6d657220666f72207468650d0a6c61737420352079656172732e20492068617665206265656e20667265656c616e63696e6720617320612077656220646576656c6f70657220666f722061626f757420320d0a79656172732e20492063616e20776f726b20696e646570656e64656e746c79206f7220696e2061207465616d2e2049206d616b6520776562206170706c69636174696f6e730d0a696e206a617661206f722070687020616e64206465736b746f70206170706c69636174696f6e7320696e206a6176612c204920616c736f20686176650d0a657870657269656e636520646576656c6f70696e67203364206170706c69636174696f6e7320696e20632b2b2077697468206f70656e676c206f7220610d0a677261706869637320656e67696e652e20536f6d652074696d652061676f204920616c736f206578706572696d656e746564207769746820632320616e640d0a766172696f757320736372697074696e67206c616e677561676573207375636820617320707974686f6e20616e6420727562792c20492068617665207468650d0a6162696c69747920746f20717569636b6c79206c6561726e206e6577206c616e677561676573206966206e65656465642e2042656c6f7720697320612062726965660d0a73756d6d6572793a3c2f703e0d0a3c703e6a6176612c207377696e672c206a61766165652c206a6176616d652c2068696265726e6174652c206a73702c206a73662c20786d6c20657870657269656e636520776974680d0a6d616e79206170697320616e6420746865206162696c69747920746f20717569636b6c79206c6561726e20686f7720746f207573652061206e6577206170692e3c2f703e3c703e6d7973716c2c206f7261636c652c2073716c3c6272202f3e3c2f703e0d0a3c703e7068702c206a6176617363726970742c2068746d6c2c206373732c2078736c742c20776562736572766963657320657870657269656e63652077697468206d6f737420636f6d6d6f6e207765620d0a746563686e6f6c6f676965732e3c2f703e3c703e632b2b2c204f70656e676c2c20657870657269656e636520776974682077696e646f7773203332206170692c2072656e646572696e6720656e67696e657320616e640d0a7068797369637320656e67696e65732e3c2f703e3c6872207374796c653d2277696474683a313030253b6865696768743a31707822206e6f73686164653d226e6f736861646522202f3e3c68333e536563757269747920736b696c6c733a3c2f68333e2020492068617665206b6e6f776c65646765206f6620636f6d70757465722073656375726974790d0a697373756573206d61696e6c792066726f6d206f6e6c696e65206861636b696e67206368616c6c656e67657320616e6420666978696e672062756773207768696c650d0a646f696e6720736f667477617265206d61696e74656e616e63652e205375626a6563747320696e636c7564653a2073796d6d657472696320616e640d0a6173796d6d657472696320656e6372797074696f6e2c2068617368696e672c206c6f63616c20616e642072656d6f74652066696c6520696e636c7573696f6e2c0d0a72656d6f746520636f646520657865637574696f6e2c2063726f7373207369746520736372697074696e672c2073716c20696e6a656374696f6e2c206275666665720d0a6f766572666c6f772c2061706163686520616e6420746f6d63617420636f6e66696775726174696f6e2070726f626c656d732e20492063616e2066696e640d0a73656375726974792070726f626c656d732062792072656164696e6720636f6465206f7220736561726368696e6720666f72207265706f727465640d0a76756c6e65726162696c69746965732e3c6272202f3e202020203c6272202f3e20200d0a3c6872202f3e3c68333e50726f6a656374733a3c2f68333e3c703e3c7374726f6e673e76626d73636d733a3c2f7374726f6e673e203c61207461726765743d225f626c616e6b2220687265663d22687474703a2f2f636f64652e676f6f676c652e636f6d2f702f76626d73636d73223e636f64652e676f6f676c652e636f6d2f702f76626d73636d733c2f613e3c2f703e0d0a3c703e76626d73636d7320697320612066726565206f70656e20736f7572636520636f6e74656e740d0a6d616e6167656d656e742073797374656d207468617420692077726f7465206d7973656c66206261736564206f6e207068702c206d7973716c20646174616261736520616e64206a71756572792e2049742073746172746564206f666620617320746865206261636b656e642074686174206920776173207573696e6720746f206d616b6520776562736974657320616e64206772616475616c792065766f6c76656420696e746f20612066756c6c20636d732e204920737461727465642070726f6772616d6d696e672069742061742074686520656e64206f66203230313020616e64206861766520636f6e74696e7565642074696c6c20746f6461792e2076626d73636d7320686173206265656e207573656420696e0d0a666f6c6c6f77696e672077656273697465733a20737574616e676f2e636f6d2c0d0a73757472616e736c6174696f6e2e636f6d2c20632d6c696e652e64652c2061736e2d65762e64652f6e65772f76626d73636d732f2c206e79736d2d65762e64652c0d0a636173746c6573756e2e636f6d2c206e796d7068656e6275726765722d6d61676963732e646520616e64206f74686572733c2f703e0d0a3c703e3c7374726f6e673e7068705061636b65723a3c2f7374726f6e673e203c61207461726765743d225f626c616e6b2220687265663d22687474703a2f2f636f64652e676f6f676c652e636f6d2f702f7068707061636b6572223e636f64652e676f6f676c652e636f6d2f702f7068707061636b65723c2f613e3c2f703e0d0a3c703e73696d706c65206f70656e20736f7572636520706870207363726970742074686174206372656174657320616e20696e7374616c6c657220666f7220706870206170706c69636174696f6e732e2069742077617320612074776f206461792070726f6a656374207468617420692070726f6772616d6d656420736f6d652074696d652061726f756e642061756775737420323031322e204561737920746f207573652073696d706c79200d0a707574207468652066696c6520696e746f20746865206469726563746f727920796f75207769736820746f207061636b20696e746f20616e20696e7374616c6c65722c200d0a73656c6563742074686520726f6f74206469726563746f727920616e6420746865206e616d65206f662074686520696e7374616c6c65722066696c65207468656e200d0a73706563696669792077697463682066696c652073686f756c64206265207265646972656374656420746f2061667465722074686520696e7374616c6c657220686173206265656e0d0a2065786563757465642e2054686520696e7374616c6c65722066696c6520746861742069732063726561746564206279207068705061636b65722073746f7265730d0a20616c6c2066696c657320696e20636f6d7072657373656420737461746520616c6c207061636b656420696e746f206f6e65207068702066696c652e205768656e20746865200d0a696e7374616c6c65722069732065786563757465642069742073696d706c7920756e7061636b73207468652066696c657320616e642072656469726563747320746f20746865200d0a6e6578742066696c6520666f72206578616d706c6520696e6465782e7068702e203c2f703e0d0a3c703e3c7374726f6e673e6175746f7365617263683a3c2f7374726f6e673e203c61207461726765743d225f626c616e6b2220687265663d22687474703a2f2f706567617375732e6d656e74612e64652f61732f223e706567617375732e6d656e74612e64652f61732f3c2f613e3c2f703e0d0a3c703e63617220737065637320616e6420696d6167657320206461746162617365206261736564206f6e206a73662c20666163656c6574732c206a6176617363726970742c0d0a7269636866616365732c20737072696e672c2068696265726e6174652c2061706163686520636f6d6d6f6e732c20706f692074686174207573657320746865206f7261636c652064617461626173652e20492070726f6772616d6d6564207468697320696e2061207465616d20776974682035206f746865722070656f706c652066726f6d20323030372d323031312e20546865206d61696e20637573746f6d657220776173206461696d6c65722063687279736c6572206275742074686520736f6674776172652077617320616c736f207573656420627920626d7720616e642076772e3c2f703e0d0a3c703e3c7374726f6e673e6175746f7365653a3c2f7374726f6e673e3c2f703e0d0a3c703e636172207069637475726573206461746162617365206261736564206f6e206a73702c0d0a78736c742c2073747275747320616e6420746865206f7261636c652064617461626173652e206974207761732070726f6772616d6d656420696e207468652079656172203230303620756e74696c6c2032303130207768656e20736f6d65206c617374206368616e67652072657175657374732077657265206d6164652e20746865206d61696e206964656120626568696e64207468697320736f6674776172652077617320746f2062652061626c6520746f20736f727420706963747572657320696e746f2067726f7570732e2076696577206f722073656172636820666f72206365727461696e20696d616765732e20322070656f706c65207765726520696e766f6c656420696e2070726f6772616d6d696e67207468697320736f66747761726520627574206974206e6576657220666f756e6420612062696720637573746f6d65722e206576656e7475616c7920697420776173207265706c61636564206279206175746f7365617263682e3c2f703e0d0a3c703e3c7374726f6e673e4d4d493a3c2f7374726f6e673e203c61207461726765743d225f626c616e6b2220687265663d22687474703a2f2f6d6574616c616e646d61726b65642e6465223e6d6574616c616e646d61726b65642e64653c2f613e3c2f703e0d0a3c703e73746f636b2065786368616e6765207765627369746520666f72205369656d656e730d0a6261736564266e6273703b6a6176612c206a73702c2078736c742c207374727574732c2061706163686520636f6d6d6f6e732c206a6672656563686172742c20706f692c20526575746572732064617461266e6273703b66656564206170692e20616e64206d7973716c2064617461626173652e20496e20746869732070726f6a656374206920776173206d61696e6c7920646f696e67206d61696e7461696e616e636520616e64206368616e676520726571756573747320666f72207468652066726f6e74656e642e206920616c736f2077726f74652074686520646f63756d656e74206d616e61676d656e742073797374656d20616e64206164646564206d6f7265207365637572652076616c69646174696f6e2e207468652070726f6a65637420626567616e2061726f756e64203230303620616e64206973207374696c6c206265696e6720646576656c6f70656420746f64617920692077617320776f726b696e67206f6e2069742066726f6d20323030372074696c6c20323031312e204920616c736f2070726f6772616d6d65642061206465736b746f7020636c69656e7420616e64207765622066726f6e74656420666f7220696e7465726e616c207573652077697468696e20746865207369656d656e7320696e7472616e65742e3c2f703e0d0a3c703e3c7374726f6e673e6c63696e6e6f753a3c2f7374726f6e673e3c2f703e0d0a3c703e6372656174657320696e7374616c6c65727320666f722077696e646f77730d0a65786563757461626c6573206261736564206f6e206a6176612c207377696e6720616e6420696e6e6f20696e7374616c6c6572207363726970742e20492077726f746520746869732070726f6772616d206f6e206d79206f776e2061726f756e642032303037206974207761732061206f6e65206d6f6e74682070726f6a6563742e205768656e206974207761732066696e6e69736865642069206d6164652061206e65772066726f6e74656e6420627574207468652070726f6772616d20776173206e6576657220757365642070726f6475637469766c792e3c2f703e0d0a3c703e3c7374726f6e673e736b62753a3c2f7374726f6e673e3c2f703e3c703e656d706c6f796565207374617469737469637320616e64207461736b206d616e6167656d656e740d0a746f6f6c206261736564206f6e206a73662c207269636866616365732c2061706163686520636f6d6d6f6e732c20706f692c206a66726565636861727420616e64206f7261636c652064617461626173652e20492070726f6772616d6d6564207468697320616c6f6e6520666f722061626f7574203120796561722066726f6d20323030382d323030392e2054686520746f6f6c20776173207468656e207573656420696e7465726e616c792061742074686520636f6d6170616e79206920776f726b206174207468652074696d652e3c2f703e3c703e3c7374726f6e673e4f746865722070726f6a656374733a3c2f7374726f6e673e3c2f703e0d0a3c703e736d616c6c20326420616e642033642067616d6573206f722064656d6f207363656e65730d0a6261736564206f6e20632b2b20616e64206f70656e676c2e204d616e7920736d616c6c2077697a617264206c696b652070726f6772616d73206261736564206f6e0d0a6a6176612c207377696e672e3c2f703e3c6872202f3e0d0a3c68333e4361726565722074696d65206c696e653a3c2f68333e0d0a3c7461626c6520636c6173733d22616c69676e546f70222077696474683d2231303025223e3c74626f64793e3c74723e3c746420636c6173733d22616c69676e526967687420636f6e7472616374223e0d0a312e31322e323030330d0a3c2f74643e3c74643e2d3c2f74643e3c746420636c6173733d22636f6e7472616374223e0d0a33312e332e323030340d0a3c2f74643e3c746420636c6173733d22657870616e64223e0d0a54656c6570686f6e652073657276696365206174205a656e6974682057696e646f77732c204e6f72776963682c20456e676c616e640d0a3c2f74643e3c2f74723e3c74723e3c746420636c6173733d22616c69676e526967687420636f6e7472616374223e0d0a312e342e323030340d0a3c2f74643e3c74643e2d3c2f74643e3c746420636c6173733d22636f6e7472616374223e0d0a33302e362e323030340d0a3c2f74643e3c746420636c6173733d22657870616e64223e0d0a5072616b74696b756d2061742047e472746e65726569204b6965736c6963682c20546f7267617520616e2064657220456c62650d0a3c2f74643e3c2f74723e3c74723e3c746420636c6173733d22616c69676e526967687420636f6e7472616374223e0d0a312e312e323030350d0a3c2f74643e3c74643e2d3c2f74643e3c746420636c6173733d22636f6e7472616374223e0d0a31312e322e323030370d0a3c2f74643e3c746420636c6173733d22657870616e64223e0d0a736b69207465616368657220617420736b69207363686f6f6c2049736d616e696e670d0a3c2f74643e3c2f74723e3c74723e3c746420636c6173733d22616c69676e526967687420636f6e7472616374223e0d0a312e31302e323030360d0a3c2f74643e3c74643e2d3c2f74643e3c746420636c6173733d22636f6e7472616374223e0d0a312e31312e323030370d0a3c2f74643e3c746420636c6173733d22657870616e64223e0d0a4d63446f6e616c64732c2056657264697374722e2c203831323437204dfc6e6368656e0d0a3c2f74643e3c2f74723e3c74723e3c746420636c6173733d22616c69676e526967687420636f6e7472616374223e0d0a312e31312e323030360d0a3c2f74643e3c74643e2d3c2f74643e3c746420636c6173733d22636f6e7472616374223e0d0a32382e322e323030370d0a3c2f74643e3c746420636c6173733d22657870616e64223e0d0a5072616b74696b756d206174204c6f676f20436f6e73756c742041472c20456e7a69616e7374722e2034412c20383233313920537461726e62657267207461736b733a2070726f6772616d6d696e6720696e206a6176612c2068696265726e61746520616e6420736f6674776172652074657374696e672e0d0a3c2f74643e3c2f74723e3c74723e3c746420636c6173733d22616c69676e526967687420636f6e7472616374223e0d0a312e392e323030370d0a3c2f74643e3c74643e2d3c2f74643e3c746420636c6173733d22636f6e7472616374223e0d0a33312e382e323031300d0a3c2f74643e3c746420636c6173733d22657870616e64223e0d0a41757362696c64756e67207a756d2046616368696e666f726d6174696b65722066fc7220416e77656e64756e6773656e747769636b6c756e67206174204d656e74612041472c20426f64656e7365657374722e20342c203831323431204dfc6e6368656e2c206578616d20617420496e6475737472696520756e642048616e64656c736b616d6d6572204f62657262617965726e0d0a3c2f74643e3c2f74723e3c74723e3c746420636c6173733d22616c69676e526967687420636f6e7472616374223e0d0a312e392e323031300d0a3c2f74643e3c74643e2d3c2f74643e3c746420636c6173733d22636f6e7472616374223e0d0a3f3f20323031310d0a3c2f74643e3c746420636c6173733d22657870616e64223e0d0a736f66747761726520646576656c6f706572206174204d656e74612041472c204765726d616e69617374722e2031302c204dfc6e6368656e2c207461736b733a20736f66747761726520646576656c6f706d656e7420696e206a61766120616e64204c696e757820736572766572206d61696e74656e616e63650d0a3c2f74643e3c2f74723e3c74723e3c746420636c6173733d22616c69676e526967687420636f6e7472616374223e0d0a32312e352e323031300d0a3c2f74643e3c74643e2d3c2f74643e3c746420636c6173733d22636f6e7472616374223e0d0a746f6461790d0a3c2f74643e3c746420636c6173733d22657870616e64223e0d0a667265656c616e636520736f66747761726520646576656c6f7065720d0a3c2f74643e3c2f74723e3c2f74626f64793e3c2f7461626c653e0d0a3c6272202f3e3c6872202f3e0d0a3c68333e5363686f6f6c3a3c2f68333e0d0a3c7461626c6520636c6173733d22616c69676e546f70222077696474683d2231303025223e3c74626f64793e3c74723e3c746420636c6173733d22616c69676e526967687420636f6e7472616374223e0d0a392e313939340d0a3c2f74643e3c74643e2d3c2f74643e3c746420636c6173733d22636f6e7472616374223e0d0a372e313939360d0a3c2f74643e3c746420636c6173733d22657870616e64223e0d0a53742e20416e64726577732026616d703b2053742e204d61726b73205363686f6f6c2c205375726269746f6e2c205375727265792c20456e676c616e640d0a3c2f74643e3c2f74723e3c74723e3c746420636c6173733d22616c69676e526967687420636f6e7472616374223e0d0a392e313939360d0a3c2f74643e3c74643e2d3c2f74643e3c746420636c6173733d22636f6e7472616374223e0d0a372e313939390d0a3c2f74643e3c746420636c6173733d22657870616e64223e0d0a48696e63686c657920576f6f64205363686f6f6c2c205375726269746f6e2c205375727265792c20456e676c616e640d0a3c2f74643e3c2f74723e3c74723e3c746420636c6173733d22616c69676e526967687420636f6e7472616374223e0d0a392e313939390d0a3c2f74643e3c74643e2d3c2f74643e3c746420636c6173733d22636f6e7472616374223e0d0a372e323030320d0a3c2f74643e3c746420636c6173733d22657870616e64223e0d0a4c616e676c6579205363686f6f6c2c204c6f64646f6e2c204e6f72666f6c6b2c20456e676c616e643a204743534520286973207468652073616d65206173204d6974746c657265205265696665292049542c204d617468656d61746963732c204368656d69737472792c2062696f6c6f67792c20706879736963732c20746563686e6963616c2064726177696e672c206472616d612c20656e676c6973682c206765726d616e20616e642073706f7274730d0a3c2f74643e3c2f74723e3c74723e3c746420636c6173733d22616c69676e526967687420636f6e7472616374223e0d0a392e323030320d0a3c2f74643e3c74643e2d3c2f74643e3c746420636c6173733d22636f6e7472616374223e0d0a31322e323030320d0a3c2f74643e3c746420636c6173733d22657870616e64223e0d0a506173746f6e20436f6c6c6567652c204e6f72776963682c204e6f72666f6c6b2c20456e676c616e640d0a3c2f74643e3c2f74723e3c74723e3c746420636c6173733d22616c69676e526967687420636f6e7472616374223e0d0a323030340d0a3c2f74643e3c74643e2d3c2f74643e3c746420636c6173733d22636f6e7472616374223e0d0a323030360d0a3c2f74643e3c746420636c6173733d22657870616e64223e0d0a4d65726365727320436f6c6c6567652c20576172652c2048657274732e2c20456e676c616e6420284665726e7374756469756d293a20706879736963732c206368656d697374727920616e64206d617468656d61746963730d0a3c2f74643e3c2f74723e3c2f74626f64793e3c2f7461626c653e, NULL, 0),
(NULL, 40, 'en', 0x3c68313e4356266e6273703b4672616e7a69736b61204b61697365723c2f68313e3c7461626c652072756c65733d226e6f6e65223e3c74626f64793e3c74723e3c74643e0d0a3c7461626c653e3c74626f64793e3c74723e3c74643e0d0a44617465206f662062697274683a3c2f74643e3c74643e32312e31312e313938313c2f74643e3c2f74723e3c74723e3c74643e4d6172726965643a3c2f74643e3c74643e4e6f3c2f74643e3c2f74723e3c74723e3c74643e4368696c6472656e3a3c2f74643e3c74643e4e6f6e653c2f74643e3c2f74723e3c74723e3c74643e436f6c6c656765206465677265653a3c2f74643e3c74643e5265616c736368756c61627363686c7573732f4d6974746c6572657220536368756c61627363686c7573733c2f74643e3c2f74723e3c74723e3c74643e416464726573733a3c2f74643e3c74643e52697474657273747220313134204265726c696e204465757463686c616e64266e6273703b3c2f74643e3c2f74723e3c74723e3c74643e54656c3a266e6273703b3c2f74643e3c74643e303137363834353336393238266e6273703b3c2f74643e3c2f74723e3c74723e3c74643e456d61696c3a3c2f74643e3c74643e3c6120687265663d226d61696c746f3a6672616e7a69736b615f6b616973657240726f636b65746d61696c2e636f6d223e6672616e7a69736b615f6b616973657240726f636b65746d61696c2e636f6d3c2f613e3c2f74643e3c2f74723e3c74723e3c74643e50726f66657373696f6e3a3c2f74643e3c74643e5365742064657369676e2c2073746167652064657369676e2c266e6273703b6c6f6f6b696e67266e6273703b666f72266e6273703b747261696e696e67266e6273703b696e266e6273703b6c6162656c206d616e6167656d656e74266e6273703b616e64266e6273703b6576656e74656e67656e656572696e673c2f74643e3c2f74723e3c74723e3c74643e4c616e6775616765733a266e6273703b3c2f74643e3c74643e4765726d616e2c20456e6c6973683c2f74643e3c2f74723e3c74723e3c74643e4544562d4b6e6f6c656467653a266e6273703b3c2f74643e3c74643e57696e646f77732c266e6273703b4c696e75782c266e6273703b4d61632c266e6273703b50686f746f73686f702c204f70656e204f66666963652c266e6273703b4d53266e6273703b4f66666963652c2041626c746f6e652c266e6273703b4d75736963204d616b65722c204754413c2f74643e3c2f74723e3c74723e3c74643e3c703e486f62626965733a3c2f703e3c2f74643e3c74643e46696c6d204c61796f757420206a6f75726e616c69736d2c20726573656172636820692077616e7420746f2066756e642061206c6162656c20636f6f6b696e67206162656c746f6e652074726176656c696e672c20617274266e6273703b616e64206f7267616e69736174696f6e206d757369632020636f6d756e69747920776f726b202077656c64696e6720207061727479206f7267616e69736174696f6e2c266e6273703b266e6273703b3c2f74643e3c2f74723e3c2f74626f64793e3c2f7461626c653e0d0a3c2f74643e3c74643e0d0a3c696d67207372633d2266696c65732f7777772f6d757369635f736d616c6c2e706e6722202f3e0d0a3c2f74643e3c2f74723e3c2f74626f64793e3c2f7461626c653e0d0a3c7461626c652072756c65733d226e6f6e65223e3c74626f64793e3c74723e3c74643e3c68333e536368756c656e3c2f68333e3c2f74643e3c74643e203c6272202f3e3c2f74643e3c2f74723e3c74723e3c74643e30312e30392e31393837206269732030312e30392e313939313a3c2f74643e3c74643e266e6273703b7072696d617279207363686f6f6c204e61646973747261df65204dfc6e6368656e2c3c2f74643e3c2f74723e3c74723e3c74643e30312e30392e31393931206269732030312e30392e313939373a3c2f74643e3c74643e266e6273703b47656f72672d42fc63686e65722d5265616c736368756c65204dfc6e6368656e2c203c2f74643e3c2f74723e3c74723e3c74643e30312e30392e31393937206269732030312e30392e313939383a3c2f74643e3c74643e266e6273703b4861757074736368756c652050756c6c6163682c207175616c6966697a696572656e646572204861757074736368756c61627363686c7573732c3c2f74643e3c2f74723e3c74723e3c74643e30312e30392e31393939206269732030312e30392e323030313a3c2f74643e3c74643e266e6273703b464f5320416e746f6e2d46696e6765726c652d5a656e7472756d204dfc6e6368656e2c3c2f74643e3c2f74723e3c74723e3c74643e30312e30392e32303032206269732030312e30352e323030333a3c2f74643e3c74643e266e6273703b4774692047616c77617920746563686e6963616c20696e737469747574652c2047616c7761792f49726c616e642c3c2f74643e3c2f74723e3c74723e3c74643e3c68333e756e69766572736974793c2f68333e3c2f74643e3c74643e203c6272202f3e3c2f74643e3c2f74723e3c74723e3c74643e30312e30392e32303037206269732030312e30392e323030383a3c2f74643e3c74643e266e6273703b556e6976657273697479206f662057616c65732041626572797468777974682f474220466163682042612066696e65206172743c2f74643e3c2f74723e3c74723e3c74643e2030312e30392e32303034206269732030312e30392e323030373a3c2f74643e3c74643e266e6273703b84446965204574616765932c424653207363686f6f6c206f667420686520706572666f726d696e67206172747320652e562e2c204265726c696e2c207374617465207363686f6f6c2066696e6520617274697374207365742064657369676e207374616765207365742064657369676e20776f726b3c2f74643e3c2f74723e3c74723e3c74643e30312e31312e32303031206269732030312e31322e323030323a3c2f74643e3c74643e266e6273703b7661756768746f6e206d6f76696570726f64756374696f6e732047616c7761792f49726c612053657420736b7269707464657369676e2073686565707320736c6173683c2f74643e3c2f74723e3c74723e3c74643e30312e30342e32303035206269732030312e30392e323030373a3c2f74643e3c74643e266e6273703b6172747363686f6f6c7320616e642073747564696f203c2f74643e3c2f74723e3c74723e3c74643e30312e31312e32303039206269732030312e30392e323031303a3c2f74643e3c74643e266e6273703b52616475676120652e562e204265726c696e2c206172742074656163686572206c69766564726176696e672c6c616e6473636170653c2f74643e3c2f74723e3c74723e3c74643e30312e30312e32303039206269732030312e31322e323031313a3c2f74643e3c74643e667265656c616e63696e672061732073657464657369676e657220616e64202066696e657061696e7465722064617320844f62657262617965726973636865205374e464746574686561746572932c2064617320844672656965204c616e646573746865617465722042617965726e932c2064617320546865617465727a656c742084446173205363686c6f7373932c204dfc6e6368656e20646173204dfc6e63686e657220566f6c6b737468656174657220756e64206469652084436f6c6f757273207468656174657220636f6d70616e79932067616c6c65727920776f726b2073656c6c696e67207061696e74696e6773266e6273703b3c2f74643e3c2f74723e3c74723e3c74643e3c703e303330312e323031302e203130312e31312e323031313a266e6273703b266e6273703b203c2f703e3c2f74643e3c74643e3c703e782d62656c696562696720426172204265726c696e2c204261726d616e6167656d656e74266e6273703b4f7267616e6973696e6720636f6e636572747320616e64206576656e7473743c2f703e203c2f74643e3c2f74723e3c74723e3c74643e266e6273703b30332e30312e32303131202d2030362e30332e323031313a203c2f74643e3c74643e44726974747765726b204265726c696e206d6574616c6c6275696c64696e672077656c64696e673c2f74643e3c2f74723e3c74723e3c74643e266e6273703b30332e30312e32303131202d20312e323031313a203c2f74643e3c74643e266e6273703b686f6f74616e616e6e792062726978746f6e206c6f6e646f6e207072616b74696b6120736f756e64746563686e696369616e3c2f74643e3c2f74723e3c74723e3c74643e266e6273703b3c2f74643e3c74643e266e6273703b3c2f74643e3c2f74723e3c74723e3c74643e266e6273703b3c2f74643e3c74643e266e6273703b3c2f74643e3c2f74723e3c74723e3c74643e266e6273703b3c2f74643e3c74643e266e6273703b3c2f74643e3c2f74723e3c2f74626f64793e3c2f7461626c653e3c703e266e6273703b203c2f703e, NULL, 0),
(NULL, 41, 'en', 0x3c68313e4d65646963616c3c2f68313e416c7465726e617469766520706879736963732063616e20616c736f206265207573656420696e206d65646963616c206170706c69636174696f6e732e, NULL, 0);

; */ ?>