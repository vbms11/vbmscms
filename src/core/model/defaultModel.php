<?php /* ;

CREATE TABLE `t_backup` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(200) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- 
-- Tabellenstruktur für Tabelle `t_chat_message`
-- 

CREATE TABLE `t_chat_message` (
  `room` int(10) NOT NULL,
  `version` int(10) NOT NULL,
  `message` blob NOT NULL,
  `user` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Daten für Tabelle `t_chat_message`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `t_chat_room`
-- 

CREATE TABLE `t_chat_room` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(200) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Daten für Tabelle `t_chat_room`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `t_chat_room_session`
-- 

CREATE TABLE `t_chat_room_session` (
  `room` int(10) NOT NULL,
  `sessionid` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci;

-- 
-- Daten für Tabelle `t_chat_room_session`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `t_cms_version`
-- 

CREATE TABLE `t_cms_version` (
  `version` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- 
-- Tabellenstruktur für Tabelle `t_code`
-- 

CREATE TABLE `t_code` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `lang` varchar(4) NOT NULL,
  `code` int(10) unsigned NOT NULL,
  `value` blob NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=473 DEFAULT CHARSET=latin1 AUTO_INCREMENT=473 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `t_comment`
-- 

CREATE TABLE `t_comment` (
  `id` int(10) NOT NULL auto_increment,
  `moduleid` int(10) NOT NULL,
  `name` varchar(200) NOT NULL,
  `comment` blob NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `t_confirm`
-- 

CREATE TABLE `t_confirm` (
  `id` int(10) NOT NULL auto_increment,
  `hash` varchar(40) NOT NULL,
  `moduleid` int(10) NOT NULL,
  `args` blob NOT NULL,
  `expiredate` date NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Daten für Tabelle `t_confirm`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `t_domain`
-- 

CREATE TABLE `t_domain` (
  `id` int(10) NOT NULL auto_increment,
  `url` varchar(200) NOT NULL,
  `siteid` int(10) NOT NULL,
  `domaintrackerscript` blob,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

-- 
-- Daten für Tabelle `t_domain`
-- 

INSERT INTO `t_domain` VALUES (14, 'localhost', 1, NULL);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `t_event`
-- 

CREATE TABLE `t_event` (
  `id` int(10) NOT NULL auto_increment,
  `date` date NOT NULL,
  `houres` int(10) NOT NULL default '0',
  `minutes` int(10) NOT NULL default '0',
  `starthoure` int(10) NOT NULL,
  `startminute` int(10) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` blob NOT NULL,
  `type` int(5) NOT NULL,
  `userid` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Daten für Tabelle `t_event`
-- 

INSERT INTO `t_event` VALUES (1, '0000-00-00', 0, 0, 0, 0, 'birthday!', 0x4861707079204269727468646179207662206d73, 1, 2);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `t_forum_post`
-- 

CREATE TABLE `t_forum_post` (
  `id` int(10) NOT NULL auto_increment,
  `userid` int(10) NOT NULL,
  `threadid` int(10) NOT NULL,
  `message` blob NOT NULL,
  `createdate` date NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Daten für Tabelle `t_forum_post`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `t_forum_thread`
-- 

CREATE TABLE `t_forum_thread` (
  `id` int(10) NOT NULL auto_increment,
  `userid` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `message` blob NOT NULL,
  `parent` int(10) NOT NULL,
  `createdate` date NOT NULL,
  `views` int(5) NOT NULL,
  `replies` int(5) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Daten für Tabelle `t_forum_thread`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `t_forum_topic`
-- 

CREATE TABLE `t_forum_topic` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `parent` int(10) NOT NULL,
  `createdate` date NOT NULL,
  `userid` int(11) NOT NULL,
  `views` int(10) NOT NULL,
  `replies` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Daten für Tabelle `t_forum_topic`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `t_gallery_category`
-- 

CREATE TABLE `t_gallery_category` (
  `id` int(10) NOT NULL auto_increment,
  `title` varchar(100) NOT NULL,
  `description` blob NOT NULL,
  `image` int(10) default NULL,
  `parent` int(10) default NULL,
  `orderkey` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `t_gallery_image`
-- 

CREATE TABLE `t_gallery_image` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(100) NOT NULL,
  `image` varchar(50) NOT NULL,
  `orderkey` int(10) NOT NULL,
  `categoryid` int(10) NOT NULL,
  `description` blob NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `t_gallery_page`
-- 

CREATE TABLE `t_gallery_page` (
  `id` int(10) NOT NULL auto_increment,
  `pageid` int(10) NOT NULL,
  `rootcategory` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- 
-- Daten für Tabelle `t_gallery_page`
-- 

INSERT INTO `t_gallery_page` VALUES (2, 20929, 5);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `t_language`
-- 

CREATE TABLE `t_language` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(10) NOT NULL,
  `local` varchar(10) NOT NULL,
  `flag` varchar(100) NOT NULL,
  `active` int(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- 
-- Daten für Tabelle `t_language`
-- 

INSERT INTO `t_language` VALUES (1, 'de', 'de', 'de.gif', 1);
INSERT INTO `t_language` VALUES (2, 'it', 'it_en', 'flag_italy.gif', 0);
INSERT INTO `t_language` VALUES (3, 'en', 'en', 'gb.gif', 1);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `t_menu`
-- 

CREATE TABLE `t_menu` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `page` int(10) unsigned NOT NULL,
  `type` int(5) unsigned NOT NULL,
  `parent` int(10) default NULL,
  `active` int(1) NOT NULL,
  `lang` varchar(5) NOT NULL default 'en',
  `position` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=81 DEFAULT CHARSET=latin1 AUTO_INCREMENT=81 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `t_menu_instance`
-- 

CREATE TABLE `t_menu_instance` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `siteid` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- 
-- Daten für Tabelle `t_menu_instance`
-- 

INSERT INTO `t_menu_instance` VALUES (1, 'Main Menu', 1);
INSERT INTO `t_menu_instance` VALUES (2, 'Top Menu', 1);
INSERT INTO `t_menu_instance` VALUES (3, 'Bottom Menu', 1);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `t_menu_style`
-- 

CREATE TABLE `t_menu_style` (
  `id` int(10) NOT NULL auto_increment,
  `cssclass` blob NOT NULL,
  `cssstyle` blob NOT NULL,
  `name` varchar(200) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- 
-- Daten für Tabelle `t_menu_style`
-- 

INSERT INTO `t_menu_style` VALUES (4, 0x706c61696e4469764d656e75, 0x2e706c61696e4469764d656e75207b0d0a202020206d617267696e2d6c6566743a363070783b0d0a202020206865696768743a333270783b0d0a202020206c696e652d6865696768743a333270783b0d0a20202020666f6e743a20312e31656d2f33327078202248656c7665746963615730312d426c6b436e4f626c222c73616e732d73657269663b0d0a20202020666f6e742d7765696768743a626f6c643b0d0a7d0d0a2e706c61696e4469764d656e75202e7364646d207b0d0a20202020666f6e742d73697a653a20313570783b0d0a7d0d0a2e706c61696e4469764d656e75202e7364646d206469762061207b0d0a20202020746578742d6465636f726174696f6e3a206e6f6e653b0d0a2020202070616464696e673a20307078203770783b0d0a202020206d617267696e3a203070783b0d0a20202020636f6c6f723a20234646463b0d0a20202020666f6e742d7374796c653a6974616c69633b0d0a7d0d0a2e706c61696e4469764d656e75202e7364646d2064697620612e7364646d53656c6563746564207b0d0a20202020636f6c6f723a20234646444430303b0d0a7d0d0a2e706c61696e4469764d656e75202e7364646d2064697620613a686f766572207b0d0a20202020636f6c6f723a20234646444430303b0d0a20202020626f726465723a203170782030707820736f6c69642073696c7665723b0d0a7d0d0a2e706c61696e4469764d656e75202e7364646d2064697620646976207b0d0a202020206261636b67726f756e642d636f6c6f723a20726762283235302c3235302c323530293b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a7d0d0a2e706c61696e4469764d656e75202e7364646d206469762064697620613a686f766572207b0d0a202020206261636b67726f756e642d636f6c6f723a207267622835332c2035322c203532293b0d0a20202020626f726465723a203170782030707820736f6c69642073696c7665723b0d0a7d0d0a2e706c61696e4469764d656e75202e7364646d20646976206469762061207b0d0a202020206261636b67726f756e642d636f6c6f723a207267622835332c2035322c203532293b0d0a20202020636f6c6f723a20234646463b0d0a7d0d0a2e706c61696e4469764d656e75202e7364646d206469762064697620612e7364646d53656c6563746564207b0d0a20202020666f6e742d7765696768743a20626f6c643b0d0a20202020636f6c6f723a234646463b0d0a7d0d0a2e706c61696e4469764d656e75202e7364646d2064697620612e7364646d4669727374207b0d0a2020202070616464696e672d6c6566743a203070783b0d0a20202020626f726465722d6c6566743a20307078206e6f6e653b0d0a7d, 'Main Menu');
INSERT INTO `t_menu_style` VALUES (5, 0x6c6576656c73, 0x2f2a206669727374206c6576656c202a2f0d0a0d0a2e6c6576656c73207b0d0a2020202070616464696e673a2031307078203070782030707820313070783b0d0a7d0d0a2e6c6576656c73202e7364646d207b0d0a20202020666c6f61743a6c6566743b0d0a7d0d0a2e6c6576656c73202e7364646d20646976207b0d0a20202020666c6f61743a6e6f6e653b0d0a7d0d0a2e6c6576656c73202e7364646d206469762061207b0d0a20202020636f6c6f723a20626c61636b3b0d0a20202020746578742d6465636f726174696f6e3a206e6f6e653b0d0a20202020746578742d616c69676e3a206c6566743b0d0a2020202070616464696e673a203570783b0d0a20202020666f6e742d7765696768743a626f6c643b0d0a20202020666f6e742d73697a653a20313470783b0d0a7d0d0a2e6c6576656c73202e7364646d2064697620613a686f766572207b0d0a09746578742d6465636f726174696f6e3a20756e6465726c696e653b0d0a7d0d0a2e6c6576656c73202e7364646d2064697620612e7364646d4669727374207b0d0a20202020626f726465722d6c6566743a20307078206e6f6e653b0d0a7d0d0a2e6c6576656c73202e7364646d20646976202e7364646d53656c6563746564207b0d0a20202020646973706c61793a20626c6f636b3b0d0a20202020636f6c6f723a207265643b0d0a7d0d0a0d0a2f2a207365636f6e64206c6576656c202a2f0d0a0d0a2e6c6576656c73202e7364646d2064697620646976207b0d0a20202020706f736974696f6e3a2072656c61746976653b0d0a202020206261636b67726f756e643a206e6f6e653b0d0a7d0d0a2e6c6576656c73202e7364646d20646976206469762061207b0d0a20202020636f6c6f723a20233030364335353b0d0a20202020666f6e742d73697a653a20313270783b0d0a20202020666f6e742d7765696768743a206e6f726d616c3b0d0a202020206261636b67726f756e643a2075726c28272e2e2f696d672f6c697374655f7a65696368656e2e6769662729206e6f2d7265706561743b0d0a202020206261636b67726f756e642d706f736974696f6e3a2030707820313070783b0d0a202020206d617267696e2d6c6566743a20313070783b0d0a2020202070616464696e672d6c6566743a20313070783b0d0a7d0d0a2e6c6576656c73202e7364646d206469762064697620612e7364646d53656c6563746564207b0d0a20202020666f6e742d7765696768743a20626f6c643b0d0a20202020636f6c6f723a20626c61636b3b0d0a7d0d0a2e6c6576656c73202e7364646d206469762064697620613a686f766572207b0d0a20202020636f6c6f723a20626c61636b3b0d0a20202020746578742d6465636f726174696f6e3a206e6f6e653b0d0a7d0d0a0d0a2f2a207468697264206c6576656c202a2f0d0a0d0a2e6c6576656c73202e7364646d206469762064697620646976207b0d0a20202020706f736974696f6e3a206162736f6c7574653b0d0a202020206261636b67726f756e643a20726762283234302c3234302c323430293b0d0a20202020746f703a3070783b0d0a202020206c6566743a31303070783b0d0a7d0d0a2e6c6576656c73202e7364646d2064697620646976206469762061207b0d0a20202020636f6c6f723a20233030364335353b0d0a20202020666f6e742d73697a653a20313270783b0d0a20202020666f6e742d7765696768743a206e6f726d616c3b0d0a202020206261636b67726f756e643a2075726c28272e2e2f696d672f6c697374655f7a65696368656e2e6769662729206e6f2d7265706561743b0d0a202020206261636b67726f756e642d706f736974696f6e3a2030707820313070783b0d0a202020206d617267696e2d6c6566743a20313070783b0d0a2020202070616464696e672d6c6566743a20313070783b0d0a7d0d0a2e6c6576656c73202e7364646d20646976206469762064697620612e7364646d53656c6563746564207b0d0a20202020666f6e742d7765696768743a20626f6c643b0d0a20202020636f6c6f723a20626c61636b3b0d0a7d0d0a2e6c6576656c73202e7364646d20646976206469762064697620613a686f766572207b0d0a20202020636f6c6f723a20626c61636b3b0d0a20202020746578742d6465636f726174696f6e3a206e6f6e653b0d0a7d, 'Stack Menu');
INSERT INTO `t_menu_style` VALUES (7, 0x746f704469764d656e7520, 0x2e746f704469764d656e75207b0d0a202020206d617267696e2d6c6566743a313070783b0d0a202020206865696768743a323270783b0d0a20202020666f6e743a203131707820417269616c2c73616e732d73657269663b0d0a20202020636f6c6f723a20234646463b0d0a202020206c696e652d6865696768743a323270783b0d0a7d0d0a2e746f704469764d656e75202e7364646d207b0d0a7d0d0a2e746f704469764d656e75202e7364646d206469762061207b0d0a20202020746578742d6465636f726174696f6e3a206e6f6e653b0d0a2020202070616464696e673a20307078203770783b0d0a202020206d617267696e3a203070783b0d0a20202020666f6e742d7765696768743a6e6f726d616c3b0d0a7d0d0a2e746f704469764d656e75202e7364646d2064697620612e7364646d53656c6563746564207b0d0a20202020636f6c6f723a20234646444430303b0d0a7d0d0a2e746f704469764d656e75202e7364646d2064697620613a686f766572207b0d0a20202020636f6c6f723a20234646444430303b0d0a7d0d0a2e746f704469764d656e75202e7364646d2064697620646976207b0d0a202020206261636b67726f756e642d636f6c6f723a20726762283235302c3235302c323530293b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a2020202070616464696e673a203470783b0d0a7d0d0a2e746f704469764d656e75202e7364646d206469762064697620613a686f766572207b0d0a202020206261636b67726f756e642d636f6c6f723a20726762283234302c3234302c323430293b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a2020202070616464696e673a203370782033707820337078203470783b0d0a7d0d0a2e746f704469764d656e75202e7364646d20646976206469762061207b0d0a202020206261636b67726f756e642d636f6c6f723a20726762283235302c3235302c323530293b0d0a2020202070616464696e673a203470783b0d0a7d0d0a2e746f704469764d656e75202e7364646d206469762064697620612e7364646d53656c6563746564207b0d0a20202020666f6e742d7765696768743a20626f6c643b0d0a20202020636f6c6f723a626c61636b3b0d0a7d0d0a2e746f704469764d656e75202e7364646d2064697620612e7364646d4669727374207b0d0a2020202070616464696e672d6c6566743a203070783b0d0a20202020626f726465722d6c6566743a20307078206e6f6e653b0d0a7d, 'Top Menu');
INSERT INTO `t_menu_style` VALUES (8, 0x626f74746f6d4469764d656e75, 0x2e626f74746f6d4469764d656e75207b0d0a202020206d617267696e2d6c6566743a363070783b0d0a202020206865696768743a343870783b0d0a20202020666f6e743a203131707820417269616c2c73616e732d73657269663b0d0a202020206c696e652d6865696768743a343870783b0d0a7d0d0a2e626f74746f6d4469764d656e75202e7364646d207b0d0a7d0d0a2e626f74746f6d4469764d656e75202e7364646d206469762061207b0d0a20202020746578742d6465636f726174696f6e3a206e6f6e653b0d0a2020202070616464696e673a20307078203770783b0d0a202020206d617267696e3a203070783b0d0a20202020666f6e742d7765696768743a6e6f726d616c3b0d0a20202020636f6c6f723a20234646463b0d0a7d0d0a2e626f74746f6d4469764d656e75202e7364646d2064697620612e7364646d53656c6563746564207b0d0a20202020636f6c6f723a20234646444430303b0d0a7d0d0a2e626f74746f6d4469764d656e75202e7364646d2064697620613a686f766572207b0d0a20202020636f6c6f723a20234646444430303b0d0a7d0d0a2e626f74746f6d4469764d656e75202e7364646d2064697620646976207b0d0a202020206261636b67726f756e642d636f6c6f723a20726762283235302c3235302c323530293b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a2020202070616464696e673a203470783b0d0a7d0d0a2e626f74746f6d4469764d656e75202e7364646d206469762064697620613a686f766572207b0d0a202020206261636b67726f756e642d636f6c6f723a20726762283234302c3234302c323430293b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a2020202070616464696e673a203370782033707820337078203470783b0d0a7d0d0a2e626f74746f6d4469764d656e75202e7364646d20646976206469762061207b0d0a202020206261636b67726f756e642d636f6c6f723a20726762283235302c3235302c323530293b0d0a2020202070616464696e673a203470783b0d0a7d0d0a2e626f74746f6d4469764d656e75202e7364646d206469762064697620612e7364646d53656c6563746564207b0d0a20202020666f6e742d7765696768743a20626f6c643b0d0a20202020636f6c6f723a626c61636b3b0d0a7d0d0a2e626f74746f6d4469764d656e75202e7364646d2064697620612e7364646d4669727374207b0d0a2020202070616464696e672d6c6566743a203070783b0d0a20202020626f726465722d6c6566743a20307078206e6f6e653b0d0a7d, 'Bottom Menu');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `t_message`
-- 

CREATE TABLE `t_message` (
  `id` int(10) NOT NULL auto_increment,
  `srcuser` int(10) NOT NULL,
  `dstuser` int(10) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `message` blob NOT NULL,
  `senddate` date NOT NULL,
  `opened` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Daten für Tabelle `t_message`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `t_module`
-- 

CREATE TABLE `t_module` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `sysname` varchar(100) NOT NULL,
  `include` varchar(100) NOT NULL,
  `description` blob,
  `interface` varchar(50) default NULL,
  `inmenu` int(1) NOT NULL,
  `category` int(10) NOT NULL,
  `position` int(10) NOT NULL,
  `static` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=68 DEFAULT CHARSET=latin1 AUTO_INCREMENT=68 ;

-- 
-- Daten für Tabelle `t_module`
-- 

INSERT INTO `t_module` VALUES (1, 'Seitenmanager', 'pages', 'modules/pages/pagesView.php', 0x616c6c6f777320796f7520746f206564697420746865206d656e75, 'PagesView', 0, 4, 0, 1);
INSERT INTO `t_module` VALUES (2, 'Wysiwyg Editor', '', 'modules/wysiwyg/wysiwygPageView.php', '', 'WysiwygPageView', 1, 1, 0, 0);
INSERT INTO `t_module` VALUES (13, 'Login', 'login', 'modules/users/loginModule.php', 0x616c6c6f777320796f7520746f20656e74657220616e6420657869742061646d696e206d6f6465, 'LoginModule', 1, 4, 0, 1);
INSERT INTO `t_module` VALUES (16, 'Newsletters', '', 'modules/newsletter/newsletterPageView.php', '', 'NewsletterPageView', 1, 3, 0, 0);
INSERT INTO `t_module` VALUES (17, 'Produkteliste', '', 'modules/products/productsPageView.php', '', 'ProductsPageView', 1, 1, 0, 0);
INSERT INTO `t_module` VALUES (62, 'Subscribe to role', 'subscribe', 'modules/users/registerRoleModule.php', NULL, 'RegisterRoleModule', 1, 0, 0, 1);
INSERT INTO `t_module` VALUES (24, 'Benutser Verwaltung', '', 'modules/users/usersPageView.php', '', 'UsersPageView', 1, 4, 0, 0);
INSERT INTO `t_module` VALUES (21, 'Sitemap', '', 'modules/sitemap/sitemapPageView.php', '', 'SitemapPageView', 1, 1, 0, 0);
INSERT INTO `t_module` VALUES (22, 'Suche', 'search', 'modules/search/searchPageView.php', '', 'SearchPageView', 1, 4, 0, 1);
INSERT INTO `t_module` VALUES (45, 'Insert Module', 'insertModule', 'modules/admin/insertModuleView.php', '', 'InsertModuleView', 0, 4, 0, 1);
INSERT INTO `t_module` VALUES (25, 'Forum', '', 'modules/forum/forumPageView.php', '', 'ForumPageView', 1, 2, 0, 0);
INSERT INTO `t_module` VALUES (26, 'Chat', '', 'modules/chat/chatPageView.php', '', 'ChatPageView', 1, 2, 0, 0);
INSERT INTO `t_module` VALUES (27, 'Comments', '', 'modules/comments/commentsView.php', '', 'CommentsView', 1, 2, 0, 0);
INSERT INTO `t_module` VALUES (37, 'Database backup', '', 'modules/admin/backupView.php', '', 'BackupView', 1, 4, 0, 0);
INSERT INTO `t_module` VALUES (29, 'Register', 'register', 'modules/users/registerModule.php', '', 'RegisterModule', 1, 4, 0, 1);
INSERT INTO `t_module` VALUES (30, 'Profile', '', 'modules/users/profilePageView.php', '', 'ProfilePageView', 1, 4, 0, 0);
INSERT INTO `t_module` VALUES (32, 'Role Administration', '', 'modules/admin/rolesView.php', '', 'RolesView', 1, 4, 0, 0);
INSERT INTO `t_module` VALUES (33, 'Gallery', '', 'modules/gallery/galleryView.php', '', 'GalleryView', 1, 1, 0, 0);
INSERT INTO `t_module` VALUES (34, 'Messages', '', 'modules/forum/messagePageView.php', '', 'MessagePageView', 1, 2, 0, 0);
INSERT INTO `t_module` VALUES (35, 'Events Callender', '', 'modules/events/callenderView.php', '', 'CallenderView', 1, 1, 0, 0);
INSERT INTO `t_module` VALUES (36, 'Events List', '', 'modules/events/eventsList.php', '', 'EventsListView', 1, 1, 0, 0);
INSERT INTO `t_module` VALUES (38, 'Templates Manager', '', 'modules/admin/templatesView.php', '', 'TemplatesView', 1, 4, 0, 0);
INSERT INTO `t_module` VALUES (39, 'Modules Manager', '', 'modules/admin/modulesView.php', '', 'ModulesView', 1, 4, 0, 0);
INSERT INTO `t_module` VALUES (40, 'Domains Manager', '', 'modules/admin/domainsView.php', '', 'DomainsView', 1, 4, 0, 0);
INSERT INTO `t_module` VALUES (41, 'Images', 'system', 'modules/admin/systemService.php', '', 'SystemService', 0, 4, 0, 1);
INSERT INTO `t_module` VALUES (42, 'Seo Settings', 'seo', 'modules/admin/seoView.php', '', 'SeoView', 0, 4, 0, 1);
INSERT INTO `t_module` VALUES (44, 'Startup Welcome', 'startup', 'modules/admin/startupView.php', '', 'StartupView', 0, 4, 0, 1);
INSERT INTO `t_module` VALUES (47, 'product Orders', '', 'modules/products/ordersView.php', '', 'OrdersView', 1, 5, 0, 0);
INSERT INTO `t_module` VALUES (48, 'Images Service', 'images', 'modules/admin/imagesService.php', '', 'ImageGenerator', 0, 4, 0, 1);
INSERT INTO `t_module` VALUES (49, 'Configure Tables', 'configTables', 'modules/datamodel/configureTablesView.php', '', 'ConfigureTablesView', 1, 5, 1, 1);
INSERT INTO `t_module` VALUES (50, 'Form View', '', 'modules/datamodel/formsView.php', '', 'FormsView', 1, 5, 0, 0);
INSERT INTO `t_module` VALUES (51, 'Results View', '', 'modules/datamodel/resultsView.php', '', 'ResultsView', 1, 4, 0, 0);
INSERT INTO `t_module` VALUES (52, 'Shopping Basket', 'shopBasket', 'modules/products/shopBasketView.php', NULL, 'ShopBasketView', 1, 5, 1, 1);
INSERT INTO `t_module` VALUES (53, 'Slideshow', '', 'modules/gallery/slideshowView.php', NULL, 'SlideshowView', 1, 1, 1, 0);
INSERT INTO `t_module` VALUES (54, 'File System Service', 'fileSystem', 'modules/admin/fileSystemService.php', NULL, 'FileSystemService', 0, 4, 0, 1);
INSERT INTO `t_module` VALUES (55, 'File Manager', '', 'modules/filesystem/filesystemView.php', NULL, 'FilesystemView', 1, 4, 1, 0);
INSERT INTO `t_module` VALUES (56, 'Rechnungen', '', 'modules/products/shopBillsView.php', NULL, 'ShopBillsView', 1, 4, 1, 0);
INSERT INTO `t_module` VALUES (57, 'Full Screen Callendar', '', 'modules/events/fullCallendarView.php', NULL, 'FullCallendarView', 1, 1, 0, 0);
INSERT INTO `t_module` VALUES (58, 'Events Table', 'eventsTable', 'modules/events/eventsTable.php', NULL, 'EventsTableView', 1, 0, 0, 1);
INSERT INTO `t_module` VALUES (59, 'Plain Menu', 'menu', 'modules/pages/menuModule.php', NULL, 'MenuView', 1, 0, 0, 0);
INSERT INTO `t_module` VALUES (60, 'Page Config', 'pageConfig', 'modules/pages/pageConfigModule.php', NULL, 'PageConfigModule', 0, 0, 0, 1);
INSERT INTO `t_module` VALUES (61, 'Confirm', 'confirm', 'modules/admin/confirmModuleView.php', NULL, 'ConfirmView', 0, 0, 0, 1);
INSERT INTO `t_module` VALUES (63, 'Languages', '', 'modules/admin/languagesModule.php', NULL, 'LanguagesModule', 1, 0, 0, 0);
INSERT INTO `t_module` VALUES (64, 'Search Box', '', 'modules/search/searchBoxModule.php', NULL, 'SearchBoxModule', 1, 0, 0, 0);
INSERT INTO `t_module` VALUES (65, 'Product Groups', 'productGroups', 'modules/products/productGroupsModule.php', '', 'ProductGroupsModule', 1, 0, 0, 1);
INSERT INTO `t_module` VALUES (66, 'Payment', 'payment', 'modules/products/paymentModule.php', '', 'PaymentModule', 0, 0, 0, 1);
INSERT INTO `t_module` VALUES (67, 'Social Networks', '', 'modules/social/socialModule.php', '', 'SocialModule', 1, 0, 0, 0);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `t_module_category`
-- 

CREATE TABLE `t_module_category` (
  `id` int(10) NOT NULL auto_increment,
  `position` int(10) NOT NULL,
  `name` varchar(200) collate latin1_german2_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=1 ;

-- 
-- Daten für Tabelle `t_module_category`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `t_module_instance`
-- 

CREATE TABLE `t_module_instance` (
  `id` int(10) NOT NULL auto_increment,
  `moduleid` int(10) NOT NULL,
  `templateareaid` int(10) NOT NULL,
  PRIMARY KEY  (`id`,`moduleid`,`templateareaid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=1 ;

-- 
-- Daten für Tabelle `t_module_instance`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `t_module_instance_params`
-- 

CREATE TABLE `t_module_instance_params` (
  `instanceid` int(10) NOT NULL,
  `name` varchar(100) collate latin1_german2_ci NOT NULL,
  `value` blob NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci;


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `t_module_roles`
-- 

CREATE TABLE `t_module_roles` (
  `id` int(10) NOT NULL auto_increment,
  `customrole` int(10) NOT NULL,
  `modulerole` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1185 DEFAULT CHARSET=latin1 AUTO_INCREMENT=1185 ;

-- 
-- Daten für Tabelle `t_module_roles`
-- 

INSERT INTO `t_module_roles` VALUES (1112, 7, 'products.view');
INSERT INTO `t_module_roles` VALUES (1113, 7, 'forum.view');
INSERT INTO `t_module_roles` VALUES (1114, 7, 'gallery.view');
INSERT INTO `t_module_roles` VALUES (1115, 7, 'shop.basket.view');
INSERT INTO `t_module_roles` VALUES (1116, 7, 'shop.basket.details.edit');
INSERT INTO `t_module_roles` VALUES (1117, 8, 'forum.thread.create');
INSERT INTO `t_module_roles` VALUES (1118, 8, 'chat.user');
INSERT INTO `t_module_roles` VALUES (1119, 8, 'chat.view');
INSERT INTO `t_module_roles` VALUES (1120, 8, 'comment.post');
INSERT INTO `t_module_roles` VALUES (1121, 8, 'users.profile');
INSERT INTO `t_module_roles` VALUES (1122, 8, 'message.inbox');
INSERT INTO `t_module_roles` VALUES (1123, 8, 'events.callender');
INSERT INTO `t_module_roles` VALUES (1124, 8, 'events.list');
INSERT INTO `t_module_roles` VALUES (1125, 8, 'shop.basket.view');
INSERT INTO `t_module_roles` VALUES (1126, 8, 'shop.basket.details.edit');
INSERT INTO `t_module_roles` VALUES (1127, 10, 'pages.editmenu');
INSERT INTO `t_module_roles` VALUES (1128, 10, 'pages.edit');
INSERT INTO `t_module_roles` VALUES (1129, 10, 'wysiwyg.edit');
INSERT INTO `t_module_roles` VALUES (1130, 10, 'login.edit');
INSERT INTO `t_module_roles` VALUES (1131, 10, 'newsletter.edit');
INSERT INTO `t_module_roles` VALUES (1132, 10, 'newsletter.send');
INSERT INTO `t_module_roles` VALUES (1133, 10, 'products.edit');
INSERT INTO `t_module_roles` VALUES (1134, 10, 'products.view');
INSERT INTO `t_module_roles` VALUES (1135, 10, 'roles.register.edit');
INSERT INTO `t_module_roles` VALUES (1136, 10, 'users.edit');
INSERT INTO `t_module_roles` VALUES (1137, 10, 'sitemap.edit');
INSERT INTO `t_module_roles` VALUES (1138, 10, 'modules.insert');
INSERT INTO `t_module_roles` VALUES (1139, 10, 'forum.topic.create');
INSERT INTO `t_module_roles` VALUES (1140, 10, 'forum.thread.create');
INSERT INTO `t_module_roles` VALUES (1141, 10, 'forum.view');
INSERT INTO `t_module_roles` VALUES (1142, 10, 'forum.admin');
INSERT INTO `t_module_roles` VALUES (1143, 10, 'forum.moderator');
INSERT INTO `t_module_roles` VALUES (1144, 10, 'forum.thread.post');
INSERT INTO `t_module_roles` VALUES (1145, 10, 'chat.user');
INSERT INTO `t_module_roles` VALUES (1146, 10, 'chat.view');
INSERT INTO `t_module_roles` VALUES (1147, 10, 'comment.post');
INSERT INTO `t_module_roles` VALUES (1148, 10, 'comment.edit');
INSERT INTO `t_module_roles` VALUES (1149, 10, 'comment.delete');
INSERT INTO `t_module_roles` VALUES (1150, 10, 'backup.create');
INSERT INTO `t_module_roles` VALUES (1151, 10, 'backup.load');
INSERT INTO `t_module_roles` VALUES (1152, 10, 'backup.delete');
INSERT INTO `t_module_roles` VALUES (1153, 10, 'users.register.edit');
INSERT INTO `t_module_roles` VALUES (1154, 10, 'users.profile');
INSERT INTO `t_module_roles` VALUES (1155, 10, 'admin.roles.edit');
INSERT INTO `t_module_roles` VALUES (1156, 10, 'gallery.edit');
INSERT INTO `t_module_roles` VALUES (1157, 10, 'gallery.view');
INSERT INTO `t_module_roles` VALUES (1158, 10, 'message.inbox');
INSERT INTO `t_module_roles` VALUES (1159, 10, 'events.callender');
INSERT INTO `t_module_roles` VALUES (1160, 10, 'events.list');
INSERT INTO `t_module_roles` VALUES (1161, 10, 'events.edit');
INSERT INTO `t_module_roles` VALUES (1162, 10, 'template.edit');
INSERT INTO `t_module_roles` VALUES (1163, 10, 'template.view');
INSERT INTO `t_module_roles` VALUES (1164, 10, 'orders.edit');
INSERT INTO `t_module_roles` VALUES (1165, 10, 'orders.view');
INSERT INTO `t_module_roles` VALUES (1166, 10, 'orders.all');
INSERT INTO `t_module_roles` VALUES (1167, 10, 'orders.confirm');
INSERT INTO `t_module_roles` VALUES (1168, 10, 'orders.finnish');
INSERT INTO `t_module_roles` VALUES (1169, 10, 'dm.tables.config');
INSERT INTO `t_module_roles` VALUES (1170, 10, 'dm.forms.edit');
INSERT INTO `t_module_roles` VALUES (1171, 10, 'shop.basket.view');
INSERT INTO `t_module_roles` VALUES (1172, 10, 'shop.basket.status.edit');
INSERT INTO `t_module_roles` VALUES (1173, 10, 'shop.basket.edit');
INSERT INTO `t_module_roles` VALUES (1174, 10, 'shop.basket.details.view');
INSERT INTO `t_module_roles` VALUES (1175, 10, 'shop.basket.details.edit');
INSERT INTO `t_module_roles` VALUES (1176, 10, 'slideshow.edit');
INSERT INTO `t_module_roles` VALUES (1177, 10, 'filesystem.all');
INSERT INTO `t_module_roles` VALUES (1178, 10, 'filesystem.user');
INSERT INTO `t_module_roles` VALUES (1179, 10, 'filesystem.www');
INSERT INTO `t_module_roles` VALUES (1180, 10, 'filesystem.edit');
INSERT INTO `t_module_roles` VALUES (1181, 10, 'events.users.all');
INSERT INTO `t_module_roles` VALUES (1182, 10, 'menu.edit');
INSERT INTO `t_module_roles` VALUES (1183, 10, 'payment.edit');
INSERT INTO `t_module_roles` VALUES (1184, 10, 'social.edit');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `t_newsletter`
-- 

CREATE TABLE `t_newsletter` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `text` blob NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Daten für Tabelle `t_newsletter`
-- 

INSERT INTO `t_newsletter` VALUES (1, 'Test Newsletter', 0x486920256e616d65252c3c6272202f3e3c6272202f3e5468697320697320612074657374206e6577736c6574746572207468617420686173206265656e2073656e7420746f20796f757220656d61696c20616464726573732025656d61696c253c6272202f3e3c6272202f3e6b696e642072656761726473);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `t_newsletter_email`
-- 

CREATE TABLE `t_newsletter_email` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `email` varchar(100) NOT NULL,
  `name` varchar(200) NOT NULL,
  `confirmed` int(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Daten für Tabelle `t_newsletter_email`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `t_newsletter_emailgroup`
-- 

CREATE TABLE `t_newsletter_emailgroup` (
  `emailid` int(10) NOT NULL auto_increment,
  `roleid` int(50) NOT NULL,
  PRIMARY KEY  (`emailid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Daten für Tabelle `t_newsletter_emailgroup`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `t_order`
-- 

CREATE TABLE `t_order` (
  `id` int(10) NOT NULL auto_increment,
  `userid` int(10) NOT NULL,
  `distributorid` int(10) default NULL,
  `roleid` int(10) NOT NULL,
  `status` int(3) NOT NULL,
  `orderdate` date NOT NULL,
  `objectid` int(10) default NULL,
  `orderform` int(10) NOT NULL,
  `rabatt` decimal(10,0) NOT NULL,
  `paymethod` int(10) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `t_order_attribute`
-- 

CREATE TABLE `t_order_attribute` (
  `id` int(10) NOT NULL auto_increment,
  `name` blob NOT NULL,
  `value` blob NOT NULL,
  `orderid` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=59 ;


-- 
-- Tabellenstruktur für Tabelle `t_order_product`
-- 

CREATE TABLE `t_order_product` (
  `id` int(10) NOT NULL auto_increment,
  `productid` int(10) NOT NULL,
  `orderid` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=latin1 AUTO_INCREMENT=68 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `t_page`
-- 

CREATE TABLE `t_page` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `type` int(5) unsigned NOT NULL,
  `namecode` int(10) unsigned NOT NULL,
  `welcome` int(1) NOT NULL,
  `title` varchar(100) default NULL,
  `keywords` blob,
  `description` blob NOT NULL,
  `template` int(10) NOT NULL,
  `siteid` int(10) default '1',
  `code` varchar(40) default NULL,
  `codeid` int(10) default NULL,
  `sitetrackerscript` blob,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=71 DEFAULT CHARSET=latin1 AUTO_INCREMENT=71 ;


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `t_page_roles`
-- 

CREATE TABLE `t_page_roles` (
  `id` int(10) NOT NULL auto_increment,
  `roleid` int(10) NOT NULL,
  `pageid` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=167 DEFAULT CHARSET=latin1 AUTO_INCREMENT=167 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `t_product`
-- 

CREATE TABLE `t_product` (
  `id` int(10) NOT NULL auto_increment,
  `img` varchar(50) NOT NULL,
  `galleryid` int(10) default NULL,
  `textcode` int(10) NOT NULL,
  `shorttextcode` blob NOT NULL,
  `titelcode` int(10) NOT NULL,
  `price` decimal(10,2) default NULL,
  `shipping` decimal(10,2) NOT NULL,
  `weight` decimal(10,2) NOT NULL,
  `groupid` int(10) NOT NULL,
  `position` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `minimum` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=142 DEFAULT CHARSET=latin1 AUTO_INCREMENT=142 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `t_product_group`
-- 

CREATE TABLE `t_product_group` (
  `id` int(10) NOT NULL auto_increment,
  `namecode` int(10) NOT NULL,
  `parent` int(10) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=28 ;

-- 
-- Daten für Tabelle `t_product_group`
-- 


-- 
-- Tabellenstruktur für Tabelle `t_product_group_module`
-- 

CREATE TABLE `t_product_group_module` (
  `moduleid` int(10) NOT NULL,
  `groupid` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `t_roles`
-- 

CREATE TABLE `t_roles` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(100) default NULL,
  `userid` int(10) NOT NULL,
  `roleid` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `t_roles_custom`
-- 

CREATE TABLE `t_roles_custom` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- 
-- Daten für Tabelle `t_roles_custom`
-- 

INSERT INTO `t_roles_custom` VALUES (7, 'guest');
INSERT INTO `t_roles_custom` VALUES (8, 'user');
INSERT INTO `t_roles_custom` VALUES (9, 'editor');
INSERT INTO `t_roles_custom` VALUES (10, 'admin');
INSERT INTO `t_roles_custom` VALUES (13, 'newsletter');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `t_session`
-- 

CREATE TABLE `t_session` (
  `userid` int(10) default NULL,
  `sessionid` varchar(40) NOT NULL,
  `sessionkey` varchar(40) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `name` varchar(100) NOT NULL,
  `lastpolltime` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `logintime` timestamp NULL default NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `t_site` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(200) NOT NULL,
  `description` blob NOT NULL,
  `sitetrackerscript` blob,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Daten für Tabelle `t_site`
-- 

INSERT INTO `t_site` VALUES (1, 'vbmscms admin', '', NULL);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `t_site_module`
-- 

CREATE TABLE `t_site_module` (
  `id` int(10) NOT NULL auto_increment,
  `siteid` int(10) NOT NULL,
  `moduleid` varchar(10) collate latin1_german2_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=1 ;

-- 
-- Daten für Tabelle `t_site_module`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `t_site_template`
-- 

CREATE TABLE `t_site_template` (
  `id` int(10) NOT NULL auto_increment,
  `siteid` int(10) NOT NULL,
  `templateid` int(10) NOT NULL,
  `main` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=34 ;

-- 
-- Daten für Tabelle `t_site_template`
-- 

INSERT INTO `t_site_template` VALUES (27, 1, 19, 0);
INSERT INTO `t_site_template` VALUES (28, 1, 20, 0);
INSERT INTO `t_site_template` VALUES (31, 1, 21, 0);
INSERT INTO `t_site_template` VALUES (30, 1, 22, 1);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `t_template`
-- 

CREATE TABLE `t_template` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `template` varchar(100) NOT NULL,
  `interface` varchar(100) NOT NULL,
  `html` blob,
  `css` blob,
  `js` blob,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

-- 
-- Daten für Tabelle `t_template`
-- 

INSERT INTO `t_template` VALUES (1, 'vbmscms Admin Template', '', '', 0x3c64697620636c6173733d226672616d65446976223e0d0a202020203c64697620636c6173733d22686561646572446976223e0d0a20202020202020203c64697620636c6173733d226865616465724d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e617265612e6d656e7520636d733f2667743b0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22626f6479446976223e0d0a20202020202020203c64697620636c6173733d22626f64794d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e6d61696e2e63656e74657220636d733f2667743b0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a3c2f6469763e, 0x626f6479207b0d0a70616464696e673a3070783b0d0a6d617267696e3a3070783b0d0a7d202020200d0a0d0a2e6672616d65446976207b0d0a20202020202020206d696e2d77696474683a2037303070783b0d0a202020207d0d0a202020202e686561646572446976207b0d0a20202020202020206865696768743a20343070783b0d0a20202020202020206d617267696e3a20313070783b0d0a2020202020202020626f726465723a20317078206461736865642073696c7665723b0d0a6261636b67726f756e643a2075726c282767726164536d616c6c2e6769662729207768697465207265706561742d783b0d0a202020207d0d0a202020202e6865616465724d617267696e446976207b0d0a20202020202020206d617267696e3a313070783b0d0a202020207d0d0a202020202e626f6479446976207b0d0a20202020202020206d696e2d6865696768743a2032303070783b0d0a20202020202020206d617267696e3a20313070783b0d0a2020202020202020626f726465723a20317078206461736865642073696c7665723b0d0a6261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a202020207d0d0a202020202e626f64794d617267696e446976207b0d0a20202020202020206d617267696e3a313070783b0d0a202020207d, '');
INSERT INTO `t_template` VALUES (19, 'Docpanel Demo Template', '', '', 0x3c6469762069643d22706167654672616d65446976223e0d0a20202020202020203c6469762069643d22686561646572446976223e0d0a2020202020203c6469762069643d22686561646572546f6f6c73446976223e0d0a202020202020202020202020202020203c6469762069643d226865616465724c616e67734d656e75223e266c743b3f636d732074656d706c6174652e617265612e6c616e677320636d733f2667743b3c2f6469763e0d0a202020202020202020202020202020203c6469762069643d22686561646572546f6f6c734d656e75223e266c743b3f636d732074656d706c6174652e617265612e73656172636820636d733f2667743b3c2f6469763e0d0a202020202020202020202020202020203c6469762069643d226865616465724d656e75536561726368223e266c743b3f636d732074656d706c6174652e6d656e752e68656164657220636d733f2667743b3c2f6469763e0d0a2020202020202020202020203c2f6469763e0d0a2020202020266c743b3f636d732074656d706c6174652e617265612e68656164657220636d733f2667743b0d0a20202020202020203c2f6469763e0d0a20202020202020203c6469762069643d22746f704d656e75446976223e0d0a20202020266c743b3f636d732074656d706c6174652e6d656e752e746f7020636d733f2667743b0d0a20202020202020203c2f6469763e0d0a20202020202020203c6469762069643d22626f6479546f70446976223e0d0a2020202020266c743b3f636d732074656d706c6174652e617265612e746f70626f647920636d733f2667743b0d0a20202020202020203c2f6469763e0d0a20202020202020203c6469762069643d22626f6479446976223e0d0a2020202020202020202020203c6469762069643d22626f64794d617267696e446976223e0d0a2020202020266c743b3f636d732074656d706c6174652e6d61696e2e626f647920636d733f2667743b0d0a2020202020202020202020203c2f6469763e0d0a20202020202020203c2f6469763e0d0a20202020202020203c6469762069643d22736f6369616c446976223e0d0a2020202020202020202020203c6469762069643d22736f6369616c4d617267696e446976223e0d0a2020202020266c743b3f636d732074656d706c6174652e617265612e736f6369616c20636d733f2667743b0d0a2020202020202020202020203c2f6469763e0d0a20202020202020203c2f6469763e0d0a20202020202020203c6469762069643d22626f74746f6d4d656e75446976223e0d0a20202020266c743b3f636d732074656d706c6174652e6d656e752e626f74746f6d20636d733f2667743b0d0a20202020202020203c2f6469763e0d0a20202020202020203c6469762069643d22636f70795269676874446976223e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e, 0x626f6479207b0d0a202020206d617267696e3a203070783b0d0a202020206261636b67726f756e643a20626c61636b3b0d0a7d0d0a23706167654672616d65446976207b0d0a202020206d696e2d77696474683a3130303070783b0d0a7d0d0a23686561646572446976207b0d0a202020206261636b67726f756e643a2075726c28276d656e74615f62696b655f7472616e73706172656e742e706e672729206e6f2d72657065617420626c61636b3b0d0a202020206261636b67726f756e642d706f736974696f6e3a2036307078203070783b0d0a202020206865696768743a20373570783b0d0a7d0d0a23746f704d656e75446976207b0d0a202020206261636b67726f756e643a2075726c28276d656e75477261642e706e67272920626c61636b3b0d0a202020206865696768743a20333270783b0d0a7d0d0a23626f6479546f70446976207b0d0a0d0a7d0d0a23626f6479446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a202020206261636b67726f756e643a2075726c282762672e6a70672729207265706561743b0d0a2020202070616464696e673a2034307078203070783b0d0a7d0d0a23626f64794d617267696e446976207b0d0a202020206d617267696e3a2030707820363070783b0d0a7d0d0a23736f6369616c446976207b0d0a0d0a7d0d0a23736f6369616c4d617267696e446976207b0d0a202020206d617267696e3a323070783b0d0a7d0d0a23626f74746f6d4d656e75446976207b0d0a202020206261636b67726f756e643a2075726c28276d656e75426f74746f6d477261642e706e67272920626c61636b3b0d0a202020206865696768743a20343870783b0d0a7d0d0a23636f70795269676874446976207b0d0a202020206d696e2d6865696768743a20323070783b0d0a7d0d0a23686561646572546f6f6c73446976207b0d0a20202020706f736974696f6e3a206162736f6c7574653b0d0a20202020746f703a20323570783b0d0a2020202072696768743a20333570783b0d0a7d0d0a23686561646572546f6f6c734d656e752c20236865616465724d656e755365617263682c20236865616465724c616e67734d656e75207b0d0a20202020666c6f61743a6c6566743b0d0a7d, '');
INSERT INTO `t_template` VALUES (20, 'Docpanel Left Demo Template', '', '', 0x3c6469762069643d22706167654672616d65446976223e0d0a20202020202020203c6469762069643d22686561646572446976223e0d0a2020202020203c6469762069643d22686561646572546f6f6c73446976223e0d0a202020202020202020202020202020203c6469762069643d226865616465724c616e67734d656e75223e266c743b3f636d732074656d706c6174652e617265612e6c616e677320636d733f2667743b3c2f6469763e0d0a202020202020202020202020202020203c6469762069643d22686561646572546f6f6c734d656e75223e266c743b3f636d732074656d706c6174652e617265612e73656172636820636d733f2667743b3c2f6469763e0d0a202020202020202020202020202020203c6469762069643d226865616465724d656e75536561726368223e266c743b3f636d732074656d706c6174652e6d656e752e68656164657220636d733f2667743b3c2f6469763e0d0a2020202020202020202020203c2f6469763e0d0a2020202020266c743b3f636d732074656d706c6174652e617265612e68656164657220636d733f2667743b0d0a20202020202020203c2f6469763e0d0a20202020202020203c6469762069643d22746f704d656e75446976223e0d0a20202020266c743b3f636d732074656d706c6174652e6d656e752e746f7020636d733f2667743b0d0a20202020202020203c2f6469763e0d0a20202020202020203c6469762069643d22626f6479546f70446976223e0d0a2020202020266c743b3f636d732074656d706c6174652e617265612e746f70626f647920636d733f2667743b0d0a20202020202020203c2f6469763e0d0a20202020202020203c6469762069643d22626f6479446976223e0d0a2020202020202020202020203c6469762069643d22626f64794d617267696e446976223e0d0a2020202020266c743b3f636d732074656d706c6174652e6d61696e2e626f647920636d733f2667743b0d0a2020202020202020202020203c2f6469763e0d0a20202020202020203c2f6469763e0d0a20202020202020203c6469762069643d22736f6369616c446976223e0d0a2020202020202020202020203c6469762069643d22736f6369616c4d617267696e446976223e0d0a2020202020266c743b3f636d732074656d706c6174652e617265612e736f6369616c20636d733f2667743b0d0a2020202020202020202020203c2f6469763e0d0a20202020202020203c2f6469763e0d0a20202020202020203c6469762069643d22626f74746f6d4d656e75446976223e0d0a20202020266c743b3f636d732074656d706c6174652e6d656e752e626f74746f6d20636d733f2667743b0d0a20202020202020203c2f6469763e0d0a20202020202020203c6469762069643d22636f70795269676874446976223e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e, 0x626f6479207b0d0a202020206d617267696e3a203070783b0d0a202020206261636b67726f756e643a20626c61636b3b0d0a7d0d0a23706167654672616d65446976207b0d0a202020206d696e2d77696474683a3130303070783b0d0a7d0d0a23686561646572446976207b0d0a202020206261636b67726f756e643a2075726c28276d656e74615f62696b655f7472616e73706172656e742e706e672729206e6f2d72657065617420626c61636b3b0d0a202020206261636b67726f756e642d706f736974696f6e3a2036307078203070783b0d0a202020206865696768743a20373570783b0d0a7d0d0a23746f704d656e75446976207b0d0a202020206261636b67726f756e643a2075726c28276d656e75477261642e706e67272920626c61636b3b0d0a202020206865696768743a20333270783b0d0a7d0d0a23626f6479546f70446976207b0d0a0d0a7d0d0a23626f6479446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a202020206261636b67726f756e643a2075726c282762672e6a70672729207265706561743b0d0a2020202070616464696e673a2034307078203070783b0d0a7d0d0a23626f64794d617267696e446976207b0d0a202020206d617267696e3a2030707820363070783b0d0a7d0d0a23736f6369616c446976207b0d0a0d0a7d0d0a23736f6369616c4d617267696e446976207b0d0a202020206d617267696e3a323070783b0d0a7d0d0a23626f74746f6d4d656e75446976207b0d0a202020206261636b67726f756e643a2075726c28276d656e75426f74746f6d477261642e706e67272920626c61636b3b0d0a202020206865696768743a20343870783b0d0a7d0d0a23636f70795269676874446976207b0d0a202020206d696e2d6865696768743a20323070783b0d0a7d0d0a23686561646572546f6f6c73446976207b0d0a20202020706f736974696f6e3a206162736f6c7574653b0d0a20202020746f703a20323570783b0d0a2020202072696768743a20333570783b0d0a7d0d0a23686561646572546f6f6c734d656e752c20236865616465724d656e755365617263682c20236865616465724c616e67734d656e75207b0d0a20202020666c6f61743a6c6566743b0d0a7d, '');
INSERT INTO `t_template` VALUES (21, 'Docpanel Right Demo Template', '', '', 0x3c6469762069643d22706167654672616d65446976223e0d0a20202020202020203c6469762069643d22686561646572446976223e0d0a2020202020203c6469762069643d22686561646572546f6f6c73446976223e0d0a202020202020202020202020202020203c6469762069643d226865616465724c616e67734d656e75223e266c743b3f636d732074656d706c6174652e617265612e6c616e677320636d733f2667743b3c2f6469763e0d0a202020202020202020202020202020203c6469762069643d22686561646572546f6f6c734d656e75223e266c743b3f636d732074656d706c6174652e617265612e73656172636820636d733f2667743b3c2f6469763e0d0a202020202020202020202020202020203c6469762069643d226865616465724d656e75536561726368223e266c743b3f636d732074656d706c6174652e6d656e752e68656164657220636d733f2667743b3c2f6469763e0d0a2020202020202020202020203c2f6469763e0d0a2020202020266c743b3f636d732074656d706c6174652e617265612e68656164657220636d733f2667743b0d0a20202020202020203c2f6469763e0d0a20202020202020203c6469762069643d22746f704d656e75446976223e0d0a20202020266c743b3f636d732074656d706c6174652e6d656e752e746f7020636d733f2667743b0d0a20202020202020203c2f6469763e0d0a20202020202020203c6469762069643d22626f6479546f70446976223e0d0a2020202020266c743b3f636d732074656d706c6174652e617265612e746f70626f647920636d733f2667743b0d0a20202020202020203c2f6469763e0d0a20202020202020203c6469762069643d22626f6479446976223e0d0a2020202020202020202020203c6469762069643d22626f64794d617267696e446976223e0d0a2020202020266c743b3f636d732074656d706c6174652e6d61696e2e626f647920636d733f2667743b0d0a2020202020202020202020203c2f6469763e0d0a20202020202020203c2f6469763e0d0a20202020202020203c6469762069643d22736f6369616c446976223e0d0a2020202020202020202020203c6469762069643d22736f6369616c4d617267696e446976223e0d0a2020202020266c743b3f636d732074656d706c6174652e617265612e736f6369616c20636d733f2667743b0d0a2020202020202020202020203c2f6469763e0d0a20202020202020203c2f6469763e0d0a20202020202020203c6469762069643d22626f74746f6d4d656e75446976223e0d0a20202020266c743b3f636d732074656d706c6174652e6d656e752e626f74746f6d20636d733f2667743b0d0a20202020202020203c2f6469763e0d0a20202020202020203c6469762069643d22636f70795269676874446976223e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e, 0x626f6479207b0d0a202020206d617267696e3a203070783b0d0a202020206261636b67726f756e643a20626c61636b3b0d0a7d0d0a23706167654672616d65446976207b0d0a202020206d696e2d77696474683a3130303070783b0d0a7d0d0a23686561646572446976207b0d0a202020206261636b67726f756e643a2075726c28276d656e74615f62696b655f7472616e73706172656e742e706e672729206e6f2d72657065617420626c61636b3b0d0a202020206261636b67726f756e642d706f736974696f6e3a2036307078203070783b0d0a202020206865696768743a20373570783b0d0a7d0d0a23746f704d656e75446976207b0d0a202020206261636b67726f756e643a2075726c28276d656e75477261642e706e67272920626c61636b3b0d0a202020206865696768743a20333270783b0d0a7d0d0a23626f6479546f70446976207b0d0a0d0a7d0d0a23626f6479446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a202020206261636b67726f756e643a2075726c282762672e6a70672729207265706561743b0d0a2020202070616464696e673a2034307078203070783b0d0a7d0d0a23626f64794d617267696e446976207b0d0a202020206d617267696e3a2030707820363070783b0d0a7d0d0a23736f6369616c446976207b0d0a0d0a7d0d0a23736f6369616c4d617267696e446976207b0d0a202020206d617267696e3a323070783b0d0a7d0d0a23626f74746f6d4d656e75446976207b0d0a202020206261636b67726f756e643a2075726c28276d656e75426f74746f6d477261642e706e67272920626c61636b3b0d0a202020206865696768743a20343870783b0d0a7d0d0a23636f70795269676874446976207b0d0a202020206d696e2d6865696768743a20323070783b0d0a7d0d0a23686561646572546f6f6c73446976207b0d0a20202020706f736974696f6e3a206162736f6c7574653b0d0a20202020746f703a20323570783b0d0a2020202072696768743a20333570783b0d0a7d0d0a23686561646572546f6f6c734d656e752c20236865616465724d656e755365617263682c20236865616465724c616e67734d656e75207b0d0a20202020666c6f61743a6c6566743b0d0a7d, '');
INSERT INTO `t_template` VALUES (22, 'Docpanel Stack Demo Template', '', '', 0x3c6469762069643d22706167654672616d65446976223e0d0a20202020202020203c6469762069643d22686561646572446976223e0d0a2020202020203c6469762069643d22686561646572546f6f6c73446976223e0d0a202020202020202020202020202020203c6469762069643d226865616465724c616e67734d656e75223e266c743b3f636d732074656d706c6174652e617265612e6c616e677320636d733f2667743b3c2f6469763e0d0a202020202020202020202020202020203c6469762069643d22686561646572546f6f6c734d656e75223e266c743b3f636d732074656d706c6174652e617265612e73656172636820636d733f2667743b3c2f6469763e0d0a202020202020202020202020202020203c6469762069643d226865616465724d656e75536561726368223e266c743b3f636d732074656d706c6174652e6d656e752e68656164657220636d733f2667743b3c2f6469763e0d0a2020202020202020202020203c2f6469763e0d0a2020202020266c743b3f636d732074656d706c6174652e617265612e68656164657220636d733f2667743b0d0a20202020202020203c2f6469763e0d0a20202020202020203c6469762069643d22746f704d656e75446976223e0d0a20202020266c743b3f636d732074656d706c6174652e6d656e752e746f7020636d733f2667743b0d0a20202020202020203c2f6469763e0d0a20202020202020203c6469762069643d22626f6479546f70446976223e0d0a2020202020266c743b3f636d732074656d706c6174652e617265612e746f70626f647920636d733f2667743b0d0a20202020202020203c2f6469763e0d0a20202020202020203c6469762069643d22626f6479446976223e0d0a2020202020202020202020203c6469762069643d22626f64794d617267696e446976223e0d0a2020202020266c743b3f636d732074656d706c6174652e6d61696e2e626f647920636d733f2667743b0d0a2020202020202020202020203c2f6469763e0d0a20202020202020203c2f6469763e0d0a20202020202020203c6469762069643d22736f6369616c446976223e0d0a2020202020202020202020203c6469762069643d22736f6369616c4d617267696e446976223e0d0a2020202020266c743b3f636d732074656d706c6174652e617265612e736f6369616c20636d733f2667743b0d0a2020202020202020202020203c2f6469763e0d0a20202020202020203c2f6469763e0d0a20202020202020203c6469762069643d22626f74746f6d4d656e75446976223e0d0a20202020266c743b3f636d732074656d706c6174652e6d656e752e626f74746f6d20636d733f2667743b0d0a20202020202020203c2f6469763e0d0a20202020202020203c6469762069643d22636f70795269676874446976223e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e, 0x626f6479207b0d0a202020206d617267696e3a203070783b0d0a202020206261636b67726f756e643a20626c61636b3b0d0a7d0d0a23706167654672616d65446976207b0d0a202020206d696e2d77696474683a3130303070783b0d0a7d0d0a23686561646572446976207b0d0a202020206261636b67726f756e643a2075726c28276d656e74615f62696b655f7472616e73706172656e742e706e672729206e6f2d72657065617420626c61636b3b0d0a202020206261636b67726f756e642d706f736974696f6e3a2036307078203070783b0d0a202020206865696768743a20373570783b0d0a7d0d0a23746f704d656e75446976207b0d0a202020206261636b67726f756e643a2075726c28276d656e75477261642e706e67272920626c61636b3b0d0a202020206865696768743a20333270783b0d0a7d0d0a23626f6479546f70446976207b0d0a0d0a7d0d0a23626f6479446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a202020206261636b67726f756e643a2075726c282762672e6a70672729207265706561743b0d0a2020202070616464696e673a2034307078203070783b0d0a7d0d0a23626f64794d617267696e446976207b0d0a202020206d617267696e3a2030707820363070783b0d0a7d0d0a23736f6369616c446976207b0d0a0d0a7d0d0a23736f6369616c4d617267696e446976207b0d0a202020206d617267696e3a323070783b0d0a7d0d0a23626f74746f6d4d656e75446976207b0d0a202020206261636b67726f756e643a2075726c28276d656e75426f74746f6d477261642e706e67272920626c61636b3b0d0a202020206865696768743a20343870783b0d0a7d0d0a23636f70795269676874446976207b0d0a202020206d696e2d6865696768743a20323070783b0d0a7d0d0a23686561646572546f6f6c73446976207b0d0a20202020706f736974696f6e3a206162736f6c7574653b0d0a20202020746f703a20323570783b0d0a2020202072696768743a20333570783b0d0a7d0d0a23686561646572546f6f6c734d656e752c20236865616465724d656e755365617263682c20236865616465724c616e67734d656e75207b0d0a20202020666c6f61743a6c6566743b0d0a7d, '');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `t_templatearea`
-- 

CREATE TABLE `t_templatearea` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `pageid` int(10) NOT NULL,
  `type` int(10) NOT NULL,
  `position` int(10) NOT NULL,
  `code` varchar(50) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21121 DEFAULT CHARSET=latin1 AUTO_INCREMENT=21121 ;


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `t_track`
-- 

CREATE TABLE `t_track` (
  `clientip` blob NOT NULL,
  `href` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Daten für Tabelle `t_track`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `t_users`
-- 

CREATE TABLE `t_users` (
  `id` int(10) NOT NULL auto_increment,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `authkey` varchar(10) default NULL,
  `email` varchar(200) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `objectid` int(10) NOT NULL,
  `registerdate` date NOT NULL,
  `birthdate` date NOT NULL,
  `active` tinyint(1) NOT NULL,
  `image` int(10) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `t_vdb_column`
-- 

CREATE TABLE `t_vdb_column` (
  `id` int(10) NOT NULL auto_increment,
  `tableid` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `edittype` int(5) NOT NULL,
  `position` int(5) NOT NULL,
  `refcolumn` int(10) default NULL,
  `objectidcolumn` int(10) default NULL,
  `description` blob,
  `required` int(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=latin1 AUTO_INCREMENT=49 ;

-- 
-- Daten für Tabelle `t_vdb_column`
-- 

INSERT INTO `t_vdb_column` VALUES (1, 2, 'Username', 1, 1, 9, 14, '', 0);
INSERT INTO `t_vdb_column` VALUES (2, 2, 'Firstname', 1, 2, 12, 14, '', 0);
INSERT INTO `t_vdb_column` VALUES (3, 2, 'Lastname', 1, 3, 13, 14, '', 0);
INSERT INTO `t_vdb_column` VALUES (4, 2, 'Email', 1, 4, 11, 14, '', 0);
INSERT INTO `t_vdb_column` VALUES (5, 2, 'Date Of Birth', 7, 5, 16, 14, '', 0);
INSERT INTO `t_vdb_column` VALUES (6, 2, 'Register Date', 7, 6, 15, 14, '', 0);
INSERT INTO `t_vdb_column` VALUES (7, 2, 'active', 8, 7, 17, 14, '', 0);
INSERT INTO `t_vdb_column` VALUES (8, 2, 'registered', 8, 8, NULL, 14, '', 0);
INSERT INTO `t_vdb_column` VALUES (9, 3, 'username', 1, 9, NULL, NULL, 0x736673646678783132617364, 1);
INSERT INTO `t_vdb_column` VALUES (10, 3, 'password', 1, 10, NULL, NULL, '', 1);
INSERT INTO `t_vdb_column` VALUES (11, 3, 'email', 1, 11, NULL, NULL, '', 1);
INSERT INTO `t_vdb_column` VALUES (12, 3, 'firstname', 1, 12, NULL, NULL, '', 1);
INSERT INTO `t_vdb_column` VALUES (13, 3, 'lastname', 1, 13, NULL, NULL, '', 1);
INSERT INTO `t_vdb_column` VALUES (14, 3, 'objectid', 1, 14, NULL, NULL, '', 0);
INSERT INTO `t_vdb_column` VALUES (15, 3, 'registerdate', 7, 15, NULL, NULL, '', 0);
INSERT INTO `t_vdb_column` VALUES (16, 3, 'birthdate', 7, 16, NULL, NULL, '', 0);
INSERT INTO `t_vdb_column` VALUES (17, 3, 'active', 8, 17, NULL, NULL, '', 0);
INSERT INTO `t_vdb_column` VALUES (37, 9, 'Email', 1, 2, NULL, NULL, '', 0);
INSERT INTO `t_vdb_column` VALUES (36, 9, 'Name', 1, 1, NULL, NULL, '', 0);
INSERT INTO `t_vdb_column` VALUES (24, 2, 'Firma', 1, 24, NULL, NULL, '', 0);
INSERT INTO `t_vdb_column` VALUES (39, 9, 'Subject', 1, 3, NULL, NULL, '', 0);
INSERT INTO `t_vdb_column` VALUES (38, 9, 'Message', 2, 4, NULL, NULL, '', 0);
INSERT INTO `t_vdb_column` VALUES (40, 10, ' Vorname (first name) ', 1, 2, NULL, NULL, '', 1);
INSERT INTO `t_vdb_column` VALUES (41, 10, 'Nachname (last name)', 1, 3, NULL, NULL, '', 1);
INSERT INTO `t_vdb_column` VALUES (42, 10, 'Firmenname (company name) optional', 1, 4, NULL, NULL, '', 0);
INSERT INTO `t_vdb_column` VALUES (43, 10, 'Strasse (street)', 1, 5, NULL, NULL, '', 1);
INSERT INTO `t_vdb_column` VALUES (44, 10, 'Hausnummer (house number)', 1, 6, NULL, NULL, '', 1);
INSERT INTO `t_vdb_column` VALUES (45, 10, 'Stadt (city)', 1, 7, NULL, NULL, '', 1);
INSERT INTO `t_vdb_column` VALUES (46, 10, 'Postleitzahl (post code)', 1, 8, NULL, NULL, '', 1);
INSERT INTO `t_vdb_column` VALUES (47, 10, 'Land (country)', 1, 9, NULL, NULL, '', 1);
INSERT INTO `t_vdb_column` VALUES (48, 10, 'instructions', 9, 1, NULL, NULL, 0x44657461696c20496e666f726d6174696f6e3a, 0);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `t_vdb_object`
-- 

CREATE TABLE `t_vdb_object` (
  `id` int(10) NOT NULL auto_increment,
  `tableid` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=50 ;

CREATE TABLE `t_vdb_table` (
  `physical` int(1) NOT NULL,
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- 
-- Daten für Tabelle `t_vdb_table`
-- 

INSERT INTO `t_vdb_table` VALUES (0, 2, 'userAttribs');
INSERT INTO `t_vdb_table` VALUES (1, 3, 't_users');
INSERT INTO `t_vdb_table` VALUES (0, 4, 'orderAttribs');
INSERT INTO `t_vdb_table` VALUES (0, 9, 'Kontakt');
INSERT INTO `t_vdb_table` VALUES (0, 10, 'orderDetails');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `t_vdb_value`
-- 

CREATE TABLE `t_vdb_value` (
  `objectid` int(10) NOT NULL,
  `columnid` int(10) NOT NULL,
  `value` blob NOT NULL,
  KEY `objectid` (`objectid`),
  KEY `columnid` (`columnid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `t_wysiwygpage` (
  `id` int(10) unsigned default NULL,
  `pageid` int(10) unsigned default NULL,
  `lang` varchar(5) NOT NULL,
  `content` blob,
  `title` varchar(100) default NULL,
  `area` int(5) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

; */ ?>