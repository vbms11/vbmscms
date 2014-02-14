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
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `t_code`
--

INSERT INTO `t_code` (`id`, `lang`, `code`, `value`) VALUES
(1, 'en', 1, 0x756e72656769737465726564);

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_menu_instance`
--

CREATE TABLE IF NOT EXISTS `t_menu_instance` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `siteid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=82 ;

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
(26, 'Chat', '', 'modules/chat/chatPageView.php', '', 'ChatPageView', 1, 2, 0, 0),
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
(81, 'ukash paypal', 'ukashpaypal', 'modules/ukashpaypal/ukashpaypalModule.php', NULL, 'UkashPaypalModule', 1, 0, 0, 1);

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

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_module_roles`
--

CREATE TABLE IF NOT EXISTS `t_module_roles` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `customrole` int(10) NOT NULL,
  `modulerole` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1519 ;

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
(1449, 10, 'wysiwyg.edit'),
(1450, 10, 'login.edit'),
(1451, 10, 'newsletter.edit'),
(1452, 10, 'newsletter.send'),
(1453, 10, 'products.edit'),
(1454, 10, 'products.view'),
(1455, 10, 'roles.register.edit'),
(1456, 10, 'users.edit'),
(1457, 10, 'sitemap.edit'),
(1458, 10, 'modules.insert'),
(1459, 10, 'forum.topic.create'),
(1460, 10, 'forum.thread.create'),
(1461, 10, 'forum.view'),
(1462, 10, 'forum.admin'),
(1463, 10, 'forum.moderator'),
(1464, 10, 'forum.thread.post'),
(1465, 10, 'chat.user'),
(1466, 10, 'chat.view'),
(1467, 10, 'comment.post'),
(1468, 10, 'comment.edit'),
(1469, 10, 'comment.delete'),
(1470, 10, 'comment.show.email'),
(1471, 10, 'backup.create'),
(1472, 10, 'backup.load'),
(1473, 10, 'backup.delete'),
(1474, 10, 'users.register.edit'),
(1475, 10, 'user.info.edit'),
(1476, 10, 'user.info.admin'),
(1477, 10, 'user.info.owner'),
(1478, 10, 'admin.roles.edit'),
(1479, 10, 'gallery.edit'),
(1480, 10, 'gallery.view'),
(1481, 10, 'message.inbox'),
(1482, 10, 'events.callender'),
(1483, 10, 'events.list'),
(1484, 10, 'events.edit'),
(1485, 10, 'template.edit'),
(1486, 10, 'template.view'),
(1487, 10, 'domains.edit'),
(1488, 10, 'domains.view'),
(1489, 10, 'orders.edit'),
(1490, 10, 'orders.view'),
(1491, 10, 'orders.all'),
(1492, 10, 'orders.confirm'),
(1493, 10, 'orders.finnish'),
(1494, 10, 'dm.tables.config'),
(1495, 10, 'dm.forms.edit'),
(1496, 10, 'shop.basket.view'),
(1497, 10, 'shop.basket.status.edit'),
(1498, 10, 'shop.basket.edit'),
(1499, 10, 'shop.basket.details.view'),
(1500, 10, 'shop.basket.details.edit'),
(1501, 10, 'slideshow.edit'),
(1502, 10, 'filesystem.all'),
(1503, 10, 'filesystem.user'),
(1504, 10, 'filesystem.www'),
(1505, 10, 'filesystem.edit'),
(1506, 10, 'events.users.all'),
(1507, 10, 'menu.edit'),
(1508, 10, 'pages.editmenu'),
(1509, 10, 'pages.edit'),
(1510, 10, 'payment.edit'),
(1511, 10, 'social.edit'),
(1512, 10, 'admin.edit'),
(1513, 10, 'site.edit'),
(1514, 10, 'site.view'),
(1515, 10, 'translations.edit'),
(1516, 10, 'emailList.edit'),
(1517, 10, 'emailSent.edit'),
(1518, 10, 'ukash.edit');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `t_page`
--

INSERT INTO `t_page` (`id`, `type`, `namecode`, `welcome`, `title`, `keywords`, `description`, `template`, `siteid`, `code`, `codeid`, `pagetrackerscript`, `modifydate`) VALUES
(1, 0, 1, 0, 'unregistered', 0x756e72656769737465726564, 0x756e72656769737465726564, 0, 1, 'unregistered', 1, NULL, '2014-02-14 12:43:02');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_page_roles`
--

CREATE TABLE IF NOT EXISTS `t_page_roles` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `roleid` int(10) NOT NULL,
  `pageid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
(NULL, 'a1413e04529fdce63a8b87b857280339bde6f148', 'lv+OSnQBwBMl6ZL3V5M7oKGNO26ovOvA6Ve8Lj7x', '127.0.0.1', 'guest_2921545', '2014-02-14 12:43:02', NULL);

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
(3, 'Docpanel Left Demo Template', '', '', 0x3c64697620636c6173733d226672616d65446976223e0d0a202020203c64697620636c6173733d22746f704d656e75446976223e0d0a20202020202020203c64697620636c6173733d22746f704d656e754d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e6d656e752e746f704d656e7520636d733f2667743b0d0a2020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22686561646572446976223e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d226865616465724d656e75446976223e0d0a20202020202020203c64697620636c6173733d226865616465724d656e754d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e6d656e752e6865616465724d656e7520636d733f2667743b0d0a2020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22626f64794c656674446976223e0d0a20202020202020203c64697620636c6173733d22666c6f6174436f6e7461696e6572446976223e0d0a2020202020202020202020203c64697620636c6173733d22626f64794c6566744d617267696e446976223e0d0a20202020202020202020202020202020266c743b3f636d732074656d706c6174652e617265612e6c65667420636d733f2667743b0d0a202020202020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a2020202020202020202020203c2f6469763e0d0a20202020202020203c2f6469763e0d0a20202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22626f647944697620626f64794469764c6566744d617267696e223e0d0a20202020202020203c64697620636c6173733d22666c6f6174436f6e7461696e6572446976223e0d0a2020202020202020202020203c64697620636c6173733d22626f64794d617267696e446976223e0d0a20202020202020202020202020202020266c743b3f636d732074656d706c6174652e6d61696e2e63656e74657220636d733f2667743b0d0a202020202020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a2020202020202020202020203c2f6469763e0d0a20202020202020203c2f6469763e0d0a20202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22666f6f7465724d656e75446976223e0d0a20202020202020203c64697620636c6173733d22666f6f7465724d656e754d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e6d656e752e666f6f7465724d656e7520636d733f2667743b0d0a2020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a3c2f6469763e, 0x626f6479207b0d0a2020202070616464696e673a3070783b0d0a202020206d617267696e3a3070783b0d0a7d202020200d0a2e6672616d65446976207b0d0a202020206d696e2d77696474683a2037303070783b0d0a202020206d617267696e3a2030707820313070782030707820313070783b0d0a7d0d0a2e746f704d656e75446976207b0d0a202020206d617267696e3a2030707820313070782030707820313070783b0d0a7d0d0a2e746f704d656e754d617267696e446976207b0d0a20202020666c6f61743a2072696768743b0d0a7d0d0a2e686561646572446976207b0d0a20202020636c6561723a20626f74683b0d0a202020206865696768743a2031303070783b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e6865616465724d656e75446976207b0d0a202020206d696e2d6865696768743a20333070783b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c282767726164536d616c6c2e6769662729207768697465207265706561742d783b0d0a7d0d0a2e6865616465724d656e754d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e626f6479446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f64794d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e626f64794469764c6566744d617267696e207b0d0a202020206d617267696e2d6c6566743a2032313070783b0d0a7d0d0a2e626f647944697652696768744d617267696e207b0d0a202020206d617267696e2d72696768743a2032313070783b0d0a7d0d0a2e626f64795269676874446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a2020202077696474683a2032303070783b0d0a20202020666c6f61743a2072696768743b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f647952696768744d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e626f64794c656674446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a2020202077696474683a2032303070783b0d0a20202020666c6f61743a206c6566743b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f64794c6566744d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e666f6f7465724d656e75446976207b0d0a20202020636c6561723a20626f74683b0d0a202020206d696e2d6865696768743a20333070783b0d0a202020206d617267696e3a2031307078203070782031307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c282767726164536d616c6c2e6769662729207768697465207265706561742d783b0d0a7d0d0a2e666f6f7465724d656e754d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e666c6f6174436f6e7461696e6572446976207b0d0a20202020666c6f61743a6c6566743b0d0a2020202077696474683a313030253b0d0a7d, '', 0),
(4, 'Docpanel Right Demo Template', '', '', 0x3c64697620636c6173733d226672616d65446976223e0d0a202020203c64697620636c6173733d22746f704d656e75446976223e0d0a20202020202020203c64697620636c6173733d22746f704d656e754d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e6d656e752e746f704d656e7520636d733f2667743b0d0a2020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22686561646572446976223e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d226865616465724d656e75446976223e0d0a20202020202020203c64697620636c6173733d226865616465724d656e754d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e6d656e752e6865616465724d656e7520636d733f2667743b0d0a2020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22626f64795269676874446976223e0d0a20202020202020203c64697620636c6173733d22666c6f6174436f6e7461696e6572446976223e0d0a2020202020202020202020203c64697620636c6173733d22626f647952696768744d617267696e446976223e0d0a20202020202020202020202020202020266c743b3f636d732074656d706c6174652e617265612e726967687420636d733f2667743b0d0a202020202020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a2020202020202020202020203c2f6469763e0d0a20202020202020203c2f6469763e0d0a20202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22626f647944697620626f647944697652696768744d617267696e223e0d0a20202020202020203c64697620636c6173733d22666c6f6174436f6e7461696e6572446976223e0d0a2020202020202020202020203c64697620636c6173733d22626f64794d617267696e446976223e0d0a20202020202020202020202020202020266c743b3f636d732074656d706c6174652e6d61696e2e63656e74657220636d733f2667743b0d0a202020202020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a2020202020202020202020203c2f6469763e0d0a20202020202020203c2f6469763e0d0a20202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22666f6f7465724d656e75446976223e0d0a20202020202020203c64697620636c6173733d22666f6f7465724d656e754d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e6d656e752e666f6f7465724d656e7520636d733f2667743b0d0a2020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a3c2f6469763e, 0x626f6479207b0d0a2020202070616464696e673a3070783b0d0a202020206d617267696e3a3070783b0d0a7d202020200d0a2e6672616d65446976207b0d0a202020206d696e2d77696474683a2037303070783b0d0a202020206d617267696e3a2030707820313070782030707820313070783b0d0a7d0d0a2e746f704d656e75446976207b0d0a202020206d617267696e3a2030707820313070782030707820313070783b0d0a7d0d0a2e746f704d656e754d617267696e446976207b0d0a20202020666c6f61743a2072696768743b0d0a7d0d0a2e686561646572446976207b0d0a20202020636c6561723a20626f74683b0d0a202020206865696768743a2031303070783b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e6865616465724d656e75446976207b0d0a202020206d696e2d6865696768743a20333070783b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c282767726164536d616c6c2e6769662729207768697465207265706561742d783b0d0a7d0d0a2e6865616465724d656e754d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e626f6479446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f64794d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e626f64794469764c6566744d617267696e207b0d0a202020206d617267696e2d6c6566743a2032313070783b0d0a7d0d0a2e626f647944697652696768744d617267696e207b0d0a202020206d617267696e2d72696768743a2032313070783b0d0a7d0d0a2e626f64795269676874446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a2020202077696474683a2032303070783b0d0a20202020666c6f61743a2072696768743b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f647952696768744d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e626f64794c656674446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a2020202077696474683a2032303070783b0d0a20202020666c6f61743a206c6566743b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f64794c6566744d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e666f6f7465724d656e75446976207b0d0a20202020636c6561723a20626f74683b0d0a202020206d696e2d6865696768743a20333070783b0d0a202020206d617267696e3a2031307078203070782031307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c282767726164536d616c6c2e6769662729207768697465207265706561742d783b0d0a7d0d0a2e666f6f7465724d656e754d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e666c6f6174436f6e7461696e6572446976207b0d0a20202020666c6f61743a6c6566743b0d0a2020202077696474683a313030253b0d0a7d, '', 0),
(5, 'Docpanel Stack Demo Template', '', '', 0x3c64697620636c6173733d226672616d65446976223e0d0a202020203c64697620636c6173733d22746f704d656e75446976223e0d0a20202020202020203c64697620636c6173733d22746f704d656e754d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e6d656e752e746f704d656e7520636d733f2667743b0d0a2020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22686561646572446976223e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d226865616465724d656e75446976223e0d0a20202020202020203c64697620636c6173733d226865616465724d656e754d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e6d656e752e6865616465724d656e7520636d733f2667743b0d0a2020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22626f6479446976223e0d0a20202020202020203c64697620636c6173733d22666c6f6174436f6e7461696e6572446976223e0d0a2020202020202020202020203c64697620636c6173733d22626f64794d617267696e446976223e0d0a20202020202020202020202020202020266c743b3f636d732074656d706c6174652e6d61696e2e63656e74657220636d733f2667743b3c64697620636c6173733d22636c656172223e3c2f6469763e0d0a2020202020202020202020203c2f6469763e0d0a20202020202020203c2f6469763e0d0a20202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22666f6f7465724d656e75446976223e0d0a20202020202020203c64697620636c6173733d22666f6f7465724d656e754d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e6d656e752e666f6f7465724d656e7520636d733f2667743b0d0a2020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a3c2f6469763e, 0x626f6479207b0d0a2020202070616464696e673a3070783b0d0a202020206d617267696e3a3070783b0d0a7d202020200d0a2e6672616d65446976207b0d0a202020206d696e2d77696474683a2037303070783b0d0a202020206d617267696e3a2030707820313070782030707820313070783b0d0a7d0d0a2e746f704d656e75446976207b0d0a202020206d617267696e3a2030707820313070782030707820313070783b0d0a7d0d0a2e746f704d656e754d617267696e446976207b0d0a20202020666c6f61743a2072696768743b0d0a7d0d0a2e686561646572446976207b0d0a20202020636c6561723a20626f74683b0d0a202020206865696768743a2031303070783b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e6865616465724d656e75446976207b0d0a202020206d696e2d6865696768743a20333070783b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c282767726164536d616c6c2e6769662729207768697465207265706561742d783b0d0a7d0d0a2e6865616465724d656e754d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e626f6479446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f64794d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e626f64794469764c6566744d617267696e207b0d0a202020206d617267696e2d6c6566743a2032313070783b0d0a7d0d0a2e626f647944697652696768744d617267696e207b0d0a202020206d617267696e2d72696768743a2032313070783b0d0a7d0d0a2e626f64795269676874446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a2020202077696474683a2032303070783b0d0a20202020666c6f61743a2072696768743b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f647952696768744d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e626f64794c656674446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a2020202077696474683a2032303070783b0d0a20202020666c6f61743a206c6566743b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f64794c6566744d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e666f6f7465724d656e75446976207b0d0a20202020636c6561723a20626f74683b0d0a202020206d696e2d6865696768743a20333070783b0d0a202020206d617267696e3a2031307078203070782031307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c282767726164536d616c6c2e6769662729207768697465207265706561742d783b0d0a7d0d0a2e666f6f7465724d656e754d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e666c6f6174436f6e7461696e6572446976207b0d0a20202020666c6f61743a6c6566743b0d0a2020202077696474683a313030253b0d0a7d, '', 1),
(1, 'Admin Template', 'core/template/adminTemplate.php', 'AdminTemplate', NULL, NULL, NULL, 0);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `t_templatearea`
--

INSERT INTO `t_templatearea` (`id`, `name`, `pageid`, `type`, `position`, `code`) VALUES
(1, '', 1, 77, 0, 'unregistered');

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=16 ;

--
-- Daten für Tabelle `t_vdb_object`
--

INSERT INTO `t_vdb_object` (`id`, `tableid`, `viewed`) VALUES
(4, 2, 1),
(5, 2, 1),
(7, 9, 0),
(8, 2, 0),
(9, 9, 1),
(10, 2, 0),
(11, 2, 0),
(12, 2, 0),
(13, 2, 0),
(14, 2, 0),
(15, 2, 0);

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
(8, 49, ''),
(9, 36, 0x74657374206e616d65),
(9, 37, 0x6672696564726963682e61737472696440676d61696c2e636f6d),
(9, 39, 0x73616566),
(9, 38, 0x736466736566736466736466736466),
(10, 1, ''),
(10, 2, ''),
(10, 3, ''),
(10, 4, ''),
(10, 5, ''),
(10, 6, ''),
(10, 7, 0x30),
(10, 8, ''),
(10, 24, ''),
(10, 49, ''),
(11, 1, ''),
(11, 2, ''),
(11, 3, ''),
(11, 4, ''),
(11, 5, ''),
(11, 6, ''),
(11, 7, 0x30),
(11, 8, ''),
(11, 24, ''),
(11, 49, ''),
(12, 1, ''),
(12, 2, ''),
(12, 3, ''),
(12, 4, ''),
(12, 5, ''),
(12, 6, ''),
(12, 7, 0x30),
(12, 8, 0x30),
(12, 24, ''),
(12, 49, ''),
(13, 1, ''),
(13, 2, ''),
(13, 3, ''),
(13, 4, ''),
(13, 5, ''),
(13, 6, ''),
(13, 7, 0x30),
(13, 8, ''),
(13, 24, ''),
(13, 49, ''),
(14, 1, 0x7465737431),
(14, 2, 0x74657374),
(14, 3, 0x74657374),
(14, 4, 0x7465737440656d61696c2e636f6d),
(14, 5, 0x30322f31372f32303134),
(14, 6, 0x30322f30332f32303134),
(14, 7, 0x31),
(14, 8, 0x31),
(14, 24, 0x74657374),
(14, 49, 0x74657374),
(15, 1, ''),
(15, 2, ''),
(15, 3, ''),
(15, 4, ''),
(15, 5, ''),
(15, 6, ''),
(15, 7, ''),
(15, 8, ''),
(15, 55, ''),
(15, 24, ''),
(15, 49, '');

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

; */ ?>