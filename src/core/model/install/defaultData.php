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
(26, 'en', 26, 0x5465726d73),
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

--
-- Daten für Tabelle `t_country`
--

INSERT INTO `t_country` (`geonameid`, `name`) VALUES
('2589581', 'Algeria'),
('3351879', 'Angola'),
('2395170', 'Benin'),
('933860', 'Botswana'),
('2361809', 'Burkina Faso'),
('433561', 'Burundi'),
('2233387', 'Cameroon'),
('3374766', 'Cape Verde'),
('239880', 'Central African Republic'),
('2434508', 'Chad'),
('921929', 'Comoros'),
('203312', 'Congo'),
('223816', 'Djibouti'),
('357994', 'Egypt'),
('2309096', 'Equatorial Guinea'),
('338010', 'Eritrea'),
('337996', 'Ethiopia'),
('2400553', 'Gabon'),
('2413451', 'Gambia'),
('2300660', 'Ghana'),
('2420477', 'Guinea'),
('2372248', 'Guinea-Bissau'),
('2287781', 'Ivory Coast'),
('192950', 'Kenya'),
('932692', 'Lesotho'),
('2275384', 'Liberia'),
('2215636', 'Libya'),
('1062947', 'Madagascar'),
('927384', 'Malawi'),
('2453866', 'Mali'),
('2378080', 'Mauritania'),
('934292', 'Mauritius'),
('1024031', 'Mayotte'),
('2542007', 'Morocco'),
('1036973', 'Mozambique'),
('3355338', 'Namibia'),
('2440476', 'Niger'),
('2328926', 'Nigeria'),
('2260494', 'Republic of the Congo'),
('49518', 'Rwanda'),
('935317', 'RÃ©union'),
('3370751', 'Saint Helena'),
('2245662', 'Senegal'),
('241170', 'Seychelles'),
('2403846', 'Sierra Leone'),
('51537', 'Somalia'),
('953987', 'South Africa'),
('7909807', 'South Sudan'),
('366755', 'Sudan'),
('934841', 'Swaziland'),
('2410758', 'SÃ£o TomÃ© and PrÃ­ncipe'),
('149590', 'Tanzania'),
('2363686', 'Togo'),
('2464461', 'Tunisia'),
('226074', 'Uganda'),
('2461445', 'Western Sahara'),
('895949', 'Zambia'),
('878675', 'Zimbabwe'),
('6697173', 'Antarctica'),
('3371123', 'Bouvet Island'),
('1546748', 'French Southern Territories'),
('1547314', 'Heard Island and McDonald Islands'),
('3474415', 'South Georgia and the South Sandwich Islands'),
('1149361', 'Afghanistan'),
('174982', 'Armenia'),
('587116', 'Azerbaijan'),
('290291', 'Bahrain'),
('1210997', 'Bangladesh'),
('1252634', 'Bhutan'),
('1282588', 'British Indian Ocean Territory'),
('1820814', 'Brunei'),
('1831722', 'Cambodia'),
('1814991', 'China'),
('2078138', 'Christmas Island'),
('1547376', 'Cocos [Keeling] Islands'),
('614540', 'Georgia'),
('1819730', 'Hong Kong'),
('1269750', 'India'),
('1643084', 'Indonesia'),
('130758', 'Iran'),
('99237', 'Iraq'),
('294640', 'Israel'),
('1861060', 'Japan'),
('248816', 'Jordan'),
('1522867', 'Kazakhstan'),
('285570', 'Kuwait'),
('1527747', 'Kyrgyzstan'),
('1655842', 'Laos'),
('272103', 'Lebanon'),
('1821275', 'Macao'),
('1733045', 'Malaysia'),
('1282028', 'Maldives'),
('2029969', 'Mongolia'),
('1327865', 'Myanmar [Burma]'),
('1282988', 'Nepal'),
('1873107', 'North Korea'),
('286963', 'Oman'),
('1168579', 'Pakistan'),
('6254930', 'Palestine'),
('1694008', 'Philippines'),
('289688', 'Qatar'),
('102358', 'Saudi Arabia'),
('1880251', 'Singapore'),
('1835841', 'South Korea'),
('1227603', 'Sri Lanka'),
('163843', 'Syria'),
('1668284', 'Taiwan'),
('1220409', 'Tajikistan'),
('1605651', 'Thailand'),
('298795', 'Turkey'),
('1218197', 'Turkmenistan'),
('290557', 'United Arab Emirates'),
('1512440', 'Uzbekistan'),
('1562822', 'Vietnam'),
('69543', 'Yemen'),
('783754', 'Albania'),
('3041565', 'Andorra'),
('2782113', 'Austria'),
('630336', 'Belarus'),
('2802361', 'Belgium'),
('3277605', 'Bosnia and Herzegovina'),
('732800', 'Bulgaria'),
('3202326', 'Croatia'),
('146669', 'Cyprus'),
('3077311', 'Czech Republic'),
('2623032', 'Denmark'),
('453733', 'Estonia'),
('2622320', 'Faroe Islands'),
('660013', 'Finland'),
('3017382', 'France'),
('2921044', 'Germany'),
('2411586', 'Gibraltar'),
('390903', 'Greece'),
('719819', 'Hungary'),
('2629691', 'Iceland'),
('2963597', 'Ireland'),
('3175395', 'Italy'),
('831053', 'Kosovo'),
('458258', 'Latvia'),
('3042058', 'Liechtenstein'),
('597427', 'Lithuania'),
('2960313', 'Luxembourg'),
('718075', 'Macedonia'),
('2562770', 'Malta'),
('617790', 'Moldova'),
('2993457', 'Monaco'),
('3194884', 'Montenegro'),
('2750405', 'Netherlands'),
('3144096', 'Norway'),
('798544', 'Poland'),
('2264397', 'Portugal'),
('798549', 'Romania'),
('2017370', 'Russia'),
('3168068', 'San Marino'),
('6290252', 'Serbia'),
('3057568', 'Slovakia'),
('3190538', 'Slovenia'),
('2510769', 'Spain'),
('607072', 'Svalbard and Jan Mayen'),
('2661886', 'Sweden'),
('2658434', 'Switzerland'),
('690791', 'Ukraine'),
('2635167', 'United Kingdom'),
('3164670', 'Vatican City'),
('661882', 'Ã…land'),
('3573511', 'Anguilla'),
('3576396', 'Antigua and Barbuda'),
('3577279', 'Aruba'),
('3572887', 'Bahamas'),
('3374084', 'Barbados'),
('3582678', 'Belize'),
('3573345', 'Bermuda'),
('7626844', 'Bonaire'),
('3577718', 'British Virgin Islands'),
('6251999', 'Canada'),
('3580718', 'Cayman Islands'),
('3624060', 'Costa Rica'),
('3562981', 'Cuba'),
('7626836', 'CuraÃ§ao'),
('3575830', 'Dominica'),
('3508796', 'Dominican Republic'),
('3585968', 'El Salvador'),
('3425505', 'Greenland'),
('3580239', 'Grenada'),
('3579143', 'Guadeloupe'),
('3595528', 'Guatemala'),
('3723988', 'Haiti'),
('3608932', 'Honduras'),
('3489940', 'Jamaica'),
('3570311', 'Martinique'),
('3996063', 'Mexico'),
('3578097', 'Montserrat'),
('3617476', 'Nicaragua'),
('3703430', 'Panama'),
('4566966', 'Puerto Rico'),
('3578476', 'Saint BarthÃ©lemy'),
('3575174', 'Saint Kitts and Nevis'),
('3576468', 'Saint Lucia'),
('3578421', 'Saint Martin'),
('3424932', 'Saint Pierre and Miquelon'),
('3577815', 'Saint Vincent and the Grenadines'),
('7609695', 'Sint Maarten'),
('3573591', 'Trinidad and Tobago'),
('3576916', 'Turks and Caicos Islands'),
('4796775', 'U.S. Virgin Islands'),
('6252001', 'United States'),
('5880801', 'American Samoa'),
('2077456', 'Australia'),
('1899402', 'Cook Islands'),
('2170371', 'Coral Sea Islands Territory'),
('1966436', 'East Timor'),
('2205218', 'Fiji'),
('4030656', 'French Polynesia'),
('4043988', 'Guam'),
('8335033', 'Jervis Bay Territory'),
('4030945', 'Kiribati'),
('2080185', 'Marshall Islands'),
('2081918', 'Micronesia'),
('2110425', 'Nauru'),
('2139685', 'New Caledonia'),
('2186224', 'New Zealand'),
('4036232', 'Niue'),
('2155115', 'Norfolk Island'),
('4041468', 'Northern Mariana Islands'),
('1559582', 'Palau'),
('2088628', 'Papua New Guinea'),
('4030699', 'Pitcairn Islands'),
('4034894', 'Samoa'),
('2103350', 'Solomon Islands'),
('2077507', 'Territory of Ashmore and Cartier Islands'),
('4031074', 'Tokelau'),
('4032283', 'Tonga'),
('2110297', 'Tuvalu'),
('5854968', 'U.S. Minor Outlying Islands'),
('2134431', 'Vanuatu'),
('4034749', 'Wallis and Futuna'),
('3865483', 'Argentina'),
('3923057', 'Bolivia'),
('3469034', 'Brazil'),
('3895114', 'Chile'),
('3686110', 'Colombia'),
('3658394', 'Ecuador'),
('3474414', 'Falkland Islands'),
('3381670', 'French Guiana'),
('3378535', 'Guyana'),
('3437598', 'Paraguay'),
('3932488', 'Peru'),
('3382998', 'Suriname'),
('3439705', 'Uruguay'),
('3625428', 'Venezuela');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=63 ;

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
(59, 26),
(60, 50),
(61, 2),
(62, 2);

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
(58, NULL, 'mode', 0x733a313a2232223b),
(60, NULL, 'orderForm', 0x733a373a224b6f6e74616b74223b),
(60, NULL, 'submitMessage', 0x733a37323a225468616e6b20796f7520666f7220796f7572206d6573736167652e2057652077696c6c20676574206261636b20746f20796f7520617320736f6f6e20617320706f737369626c652e223b),
(60, NULL, 'roleGroup', 0x733a323a223130223b),
(60, NULL, 'sendEmail', 0x733a313a2230223b),
(60, NULL, 'captcha', 0x733a313a2231223b);

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
(1, 0, 1, 0, 'login', 0x6c6f67696e, 0x6c6f67696e, 5, 1, 'login', 1, NULL, '2014-05-12 11:22:52'),
(2, 0, 2, 0, 'adminPages', 0x61646d696e5061676573, 0x61646d696e5061676573, 5, 1, 'adminPages', 5, NULL, '2014-05-12 11:23:20'),
(3, 0, 3, 0, 'startup', 0x73746172747570, 0x73746172747570, 5, 1, 'startup', 7, NULL, '2014-05-12 11:23:21'),
(4, 0, 4, 0, 'adminSites', 0x61646d696e5369746573, 0x61646d696e5369746573, 5, 1, 'adminSites', 8, NULL, '2014-05-12 11:23:26'),
(5, 0, 5, 0, 'adminDomains', 0x61646d696e446f6d61696e73, 0x61646d696e446f6d61696e73, 5, 1, 'adminDomains', 9, NULL, '2014-05-12 11:23:29'),
(6, 0, 6, 0, 'adminPackage', 0x61646d696e5061636b616765, 0x61646d696e5061636b616765, 5, 1, 'adminPackage', 10, NULL, '2014-05-12 11:24:56'),
(7, 0, 7, 0, 'pageConfig', 0x70616765436f6e666967, 0x70616765436f6e666967, 5, 1, 'pageConfig', 11, NULL, '2014-05-13 04:49:09'),
(8, 0, 8, 1, 'Online Dating', 0x4f6e6c696e6520446174696e67, 0x4f6e6c696e6520446174696e67, 4, 1, '', NULL, NULL, '2014-05-13 10:21:59'),
(9, 0, 9, 0, '', '', '', 3, 1, '', NULL, NULL, '2014-05-13 04:49:34'),
(10, 0, 10, 0, '', '', '', 3, 1, '', NULL, NULL, '2014-05-13 04:49:57'),
(11, 0, 11, 0, 'insertModule', 0x696e736572744d6f64756c65, 0x696e736572744d6f64756c65, 5, 1, 'insertModule', 12, NULL, '2014-05-13 04:50:02'),
(12, 0, 12, 0, 'userSearchResult', 0x75736572536561726368526573756c74, 0x75736572536561726368526573756c74, 3, 1, 'userSearchResult', 14, NULL, '2014-05-13 05:57:22'),
(13, 0, 13, 0, '', '', '', 5, 1, '', NULL, NULL, '2014-05-13 05:59:23'),
(14, 0, 14, 0, 'register', 0x7265676973746572, 0x7265676973746572, 5, 1, 'register', 16, NULL, '2014-05-13 06:00:20'),
(15, 0, 15, 0, 'userProfile', 0x7573657250726f66696c65, 0x7573657250726f66696c65, 3, 1, 'userProfile', 17, NULL, '2014-05-13 06:01:21'),
(16, 0, 16, 0, 'userDetails', 0x7573657244657461696c73, 0x7573657244657461696c73, 3, 1, 'userDetails', 18, NULL, '2014-05-13 06:07:53'),
(17, 0, 17, 0, 'profile', 0x70726f66696c65, 0x70726f66696c65, 5, 1, 'profile', 19, NULL, '2014-05-13 06:08:30'),
(18, 0, 18, 0, 'adminTranslations', 0x61646d696e5472616e736c6174696f6e73, 0x61646d696e5472616e736c6174696f6e73, 5, 1, 'adminTranslations', 23, NULL, '2014-05-13 08:57:16'),
(19, 0, 19, 0, 'userWall', 0x7573657257616c6c, 0x7573657257616c6c, 3, 1, 'userWall', 24, NULL, '2014-05-13 09:15:40'),
(20, 0, 20, 0, 'userGallery', 0x7573657247616c6c657279, 0x7573657247616c6c657279, 3, 1, 'userGallery', 27, NULL, '2014-06-13 17:26:49'),
(21, 0, 21, 0, 'userMessage', 0x757365724d657373616765, 0x757365724d657373616765, 3, 1, 'userMessage', 30, NULL, '2014-05-13 09:38:32'),
(22, 0, 22, 0, 'userFriends', 0x75736572467269656e6473, 0x75736572467269656e6473, 5, 1, 'userFriends', 32, NULL, '2014-05-13 09:39:48'),
(23, 0, 23, 0, 'userAddFriends', 0x75736572416464467269656e6473, 0x75736572416464467269656e6473, 5, 1, 'userAddFriends', 33, NULL, '2014-05-13 09:42:02'),
(24, 0, 24, 0, '', '', '', 5, 1, '', NULL, NULL, '2014-05-13 10:07:33'),
(25, 0, 25, 0, '', '', '', 5, 1, '', NULL, NULL, '2014-06-19 17:05:57'),
(26, 0, 26, 0, '', '', '', 5, 1, '', NULL, NULL, '2014-06-19 18:11:57'),
(27, 0, 27, 0, 'adminTemplates', 0x61646d696e54656d706c61746573, 0x61646d696e54656d706c61746573, 5, 1, 'adminTemplates', 35, NULL, '2014-05-13 10:14:19'),
(28, 0, 28, 0, 'Messages', 0x4d65737361676573, 0x4d65737361676573, 3, 1, '', NULL, NULL, '2014-05-14 04:00:13'),
(29, 0, 29, 0, 'Friends', 0x467269656e6473, 0x467269656e6473, 3, 1, '', NULL, NULL, '2014-05-14 04:01:26'),
(30, 0, 30, 0, 'Login', 0x4c6f67696e, 0x4c6f67696e, 5, 1, '', NULL, NULL, '2014-05-14 04:07:56'),
(31, 0, 31, 0, 'Logout', 0x4c6f676f7574, 0x4c6f676f7574, 5, 1, '', NULL, NULL, '2014-05-14 04:08:52'),
(32, 0, 32, 0, 'adminRoles', 0x61646d696e526f6c6573, 0x61646d696e526f6c6573, 5, 1, 'adminRoles', 40, NULL, '2014-05-14 04:15:34'),
(33, 0, 33, 0, 'unregistered', 0x756e72656769737465726564, 0x756e72656769737465726564, 0, 1, 'unregistered', 41, NULL, '2014-05-14 12:01:40'),
(34, 0, 34, 0, 'userFriend', 0x75736572467269656e64, 0x75736572467269656e64, 3, 1, 'userFriend', 42, NULL, '2014-05-15 05:01:51'),
(35, 0, 35, 0, 'Friend Requests', 0x467269656e64205265717565737473, 0x467269656e64205265717565737473, 3, 1, '', NULL, NULL, '2014-05-15 05:36:54'),
(36, 0, 36, 0, 'Search Users', 0x536561726368205573657273, 0x536561726368205573657273, 3, 1, '', NULL, NULL, '2014-05-17 05:38:35'),
(37, 0, 37, 0, '', '', '', 3, 1, '', NULL, NULL, '2014-05-17 05:38:51'),
(38, 0, 38, 0, '', '', '', 3, 1, '', NULL, NULL, '2014-05-17 05:39:56'),
(39, 0, 39, 0, 'adminSocialNotifications', 0x61646d696e536f6369616c4e6f74696669636174696f6e73, 0x61646d696e536f6369616c4e6f74696669636174696f6e73, 5, 1, 'adminSocialNotifications', 56, NULL, '2014-06-11 10:26:46'),
(40, 0, 40, 0, 'userProfileImage', 0x7573657250726f66696c65496d616765, 0x7573657250726f66696c65496d616765, 3, 1, 'userProfileImage', 57, NULL, '2014-06-13 15:28:23'),
(41, 0, 41, 0, 'Chat', 0x43686174, 0x43686174, 5, 1, '', NULL, NULL, '2014-06-18 10:12:47');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_page_roles`
--

CREATE TABLE IF NOT EXISTS `t_page_roles` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `roleid` int(10) NOT NULL,
  `pageid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=268 ;

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
(267, 13, 26),
(266, 10, 26),
(265, 9, 26),
(264, 8, 26),
(263, 7, 26),
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=63 ;

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
(59, 59, 'center', 41, 0),
(60, 60, 'center', 25, 1),
(61, 61, 'center', 25, 0),
(62, 62, 'center', 26, 0);

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
(NULL, 21, 'en', 0x3c696d6720616c743d22746f6e67756522207469746c653d22746f6e67756522207372633d22687474703a2f2f6c6f63616c686f73742f76626d73636d732f7265736f757263652f6a732f656c7274652f696d616765732f736d696c6579732f746f6e6775652e706e6722202f3e, NULL, 0),
(NULL, 61, 'en', 0x3c68313e436f6e746163743c2f68313e0d0a3c703e4865726520796f752063616e2073656e642075732061206d6573736167652e20496620796f75206861766520616e79207175657374696f6e73206f722077616e7420746f2074656c6c20757320736f6d657468696e672061626f757420746865207765622073697465206665656c206672656520746f20757365207468697320636f6e7461637420666f726d20746f2073656e642075732061206d6573736167652e3c2f703e, NULL, 0),
(NULL, 62, 'en', 0x3c68313e57454253495445205445524d5320414e4420434f4e444954494f4e533c2f68313e3c68333e496e74726f64756374696f6e3c2f68333e3c703e5468657365207465726d7320616e6420636f6e646974696f6e7320676f7665726e20796f757220757365206f66207468697320776562736974653b206279207573696e67207468697320776562736974652c20796f7520616363657074207468657365207465726d7320616e6420636f6e646974696f6e7320696e2066756c6c2e266e6273703b266e6273703b20496620796f752064697361677265652077697468207468657365207465726d7320616e6420636f6e646974696f6e73206f7220616e792070617274206f66207468657365207465726d7320616e6420636f6e646974696f6e732c20796f75206d757374206e6f7420757365207468697320776562736974652e203c2f703e3c703e5b596f75206d757374206265206174206c65617374205b31385d207965617273206f662061676520746f20757365207468697320776562736974652e266e6273703b204279207573696e6720746869732077656273697465205b616e64206279206167726565696e6720746f207468657365207465726d7320616e6420636f6e646974696f6e735d20796f752077617272616e7420616e6420726570726573656e74207468617420796f7520617265206174206c65617374205b31385d207965617273206f66206167652e5d3c2f703e3c703e5b546869732077656273697465207573657320636f6f6b6965732e266e6273703b204279207573696e672074686973207765627369746520616e64206167726565696e6720746f207468657365207465726d7320616e6420636f6e646974696f6e732c20796f7520636f6e73656e7420746f206f7572206f6e6c696e6534646174696e672e636f6d277320757365206f6620636f6f6b69657320696e206163636f7264616e6365207769746820746865207465726d73206f66206f6e6c696e6534646174696e672e636f6d2773205b7072697661637920706f6c696379202f20636f6f6b69657320706f6c6963795d2e5d3c2f703e3c68333e4c6963656e736520746f2075736520776562736974653c2f68333e3c703e556e6c657373206f7468657277697365207374617465642c206f6e6c696e6534646174696e672e636f6d202020616e642f6f7220697473206c6963656e736f7273206f776e2074686520696e74656c6c65637475616c2070726f70657274792072696768747320696e20746865207765627369746520616e64206d6174657269616c206f6e2074686520776562736974652e266e6273703b205375626a65637420746f20746865206c6963656e73652062656c6f772c20616c6c20746865736520696e74656c6c65637475616c2070726f706572747920726967687473206172652072657365727665642e3c2f703e3c703e596f75206d617920766965772c20646f776e6c6f616420666f722063616368696e6720707572706f736573206f6e6c792c20616e64207072696e74207061676573205b6f72205b4f5448455220434f4e54454e545d5d2066726f6d20746865207765627369746520666f7220796f7572206f776e20706572736f6e616c207573652c207375626a65637420746f20746865207265737472696374696f6e7320736574206f75742062656c6f7720616e6420656c7365776865726520696e207468657365207465726d7320616e6420636f6e646974696f6e732e3c2f703e203c703e596f75206d757374206e6f743a3c2f703e3c756c3e3c6c693e72657075626c697368206d6174657269616c2066726f6d207468697320776562736974652028696e636c7564696e672072657075626c69636174696f6e206f6e20616e6f746865722077656273697465292e3c2f6c693e3c6c693e73656c6c2c2072656e74206f72207375622d6c6963656e7365206d6174657269616c2066726f6d2074686520776562736974652e3c2f6c693e3c6c693e73686f7720616e79206d6174657269616c2066726f6d20746865207765627369746520696e207075626c69632e3c2f6c693e3c6c693e726570726f647563652c206475706c69636174652c20636f7079206f72206f7468657277697365206578706c6f6974206d6174657269616c206f6e2074686973207765627369746520666f72206120636f6d6d65726369616c20707572706f73652e3c2f6c693e3c6c693e65646974206f72206f7468657277697365206d6f6469667920616e79206d6174657269616c206f6e2074686520776562736974652e3c2f6c693e3c6c693e726564697374726962757465206d6174657269616c2066726f6d207468697320776562736974652e3c6272202f3e3c2f6c693e3c2f756c3e3c68333e41636365707461626c65207573653c2f68333e596f75206d757374206e6f74207573652074686973207765627369746520696e20616e79207761792074686174206361757365732c206f72206d61792063617573652c2064616d61676520746f207468652077656273697465206f7220696d706169726d656e74206f662074686520617661696c6162696c697479206f72206163636573736962696c697479206f662074686520776562736974653b206f7220696e20616e792077617920776869636820697320756e6c617766756c2c20696c6c6567616c2c206672617564756c656e74206f72206861726d66756c2c206f7220696e20636f6e6e656374696f6e207769746820616e7920756e6c617766756c2c20696c6c6567616c2c206672617564756c656e74206f72206861726d66756c20707572706f7365206f722061637469766974792e3c6272202f3e3c6272202f3e596f75206d757374206e6f74207573652074686973207765627369746520746f20636f70792c2073746f72652c20686f73742c207472616e736d69742c2073656e642c207573652c207075626c697368206f72206469737472696275746520616e79206d6174657269616c20776869636820636f6e7369737473206f6620286f72206973206c696e6b656420746f2920616e7920737079776172652c20636f6d70757465722076697275732c2054726f6a616e20686f7273652c20776f726d2c206b65797374726f6b65206c6f676765722c20726f6f746b6974206f72206f74686572206d616c6963696f757320636f6d707574657220736f6674776172652e3c6272202f3e3c6272202f3e596f75206d757374206e6f7420636f6e6475637420616e792073797374656d61746963206f72206175746f6d61746564206461746120636f6c6c656374696f6e20616374697669746965732028696e636c7564696e6720776974686f7574206c696d69746174696f6e207363726170696e672c2064617461206d696e696e672c20646174612065787472616374696f6e20616e6420646174612068617276657374696e6729206f6e206f7220696e2072656c6174696f6e20746f2074686973207765627369746520776974686f7574206f6e6c696e6534646174696e672e636f6d27732065787072657373207772697474656e20636f6e73656e742e3c6272202f3e3c6272202f3e596f75206d757374206e6f74207573652074686973207765627369746520666f7220616e7920707572706f7365732072656c6174656420746f206d61726b6574696e6720776974686f7574206f6e6c696e6534646174696e672e636f6d202027732065787072657373207772697474656e20636f6e73656e742e3c6272202f3e3c68333e52657374726963746564206163636573733c2f68333e3c703e6f6e6c696e6534646174696e672e636f6d2072657365727665732074686520726967687420746f2072657374726963742061636365737320746f2070726976617465206172656173206f66207468697320776562736974652c206f7220696e64656564207468697320656e7469726520776562736974652c206174206f6e6c696e6534646174696e672e636f6d2027732064697363726574696f6e2e3c2f703e4966206f6e6c696e6534646174696e672e636f6d20202070726f766964657320796f7520776974682061207573657220494420616e642070617373776f726420746f20656e61626c6520796f7520746f206163636573732072657374726963746564206172656173206f6620746869732077656273697465206f72206f7468657220636f6e74656e74206f722073657276696365732c20796f75206d75737420656e73757265207468617420746865207573657220494420616e642070617373776f726420617265206b65707420636f6e666964656e7469616c2e266e6273703b203c6272202f3e3c703e6f6e6c696e6534646174696e672e636f6d2020206d61792064697361626c6520796f7572207573657220494420616e642070617373776f726420696e206f6e6c696e6534646174696e672e636f6d277320736f6c652064697363726574696f6e20776974686f7574206e6f74696365206f72206578706c616e6174696f6e2e3c2f703e3c68333e5573657220636f6e74656e743c2f68333e3c703e496e207468657365207465726d7320616e6420636f6e646974696f6e732c2093796f7572207573657220636f6e74656e7494206d65616e73206d6174657269616c2028696e636c7564696e6720776974686f7574206c696d69746174696f6e20746578742c20696d616765732c20617564696f206d6174657269616c2c20766964656f206d6174657269616c20616e6420617564696f2d76697375616c206d6174657269616c29207468617420796f75207375626d697420746f207468697320776562736974652c20666f7220776861746576657220707572706f73652e3c2f703e596f75206772616e7420746f206f6e6c696e6534646174696e672e636f6d206120776f726c64776964652c2069727265766f6361626c652c206e6f6e2d6578636c75736976652c20726f79616c74792d66726565206c6963656e736520746f207573652c20726570726f647563652c2061646170742c207075626c6973682c207472616e736c61746520616e64206469737472696275746520796f7572207573657220636f6e74656e7420696e20616e79206578697374696e67206f7220667574757265206d656469612e20596f7520616c736f206772616e7420746f206f6e6c696e6534646174696e672e636f6d20202074686520726967687420746f207375622d6c6963656e7365207468657365207269676874732c20616e642074686520726967687420746f206272696e6720616e20616374696f6e20666f7220696e6672696e67656d656e74206f66207468657365207269676874732e3c6272202f3e3c703e596f7572207573657220636f6e74656e74206d757374206e6f7420626520696c6c6567616c206f7220756e6c617766756c2c206d757374206e6f7420696e6672696e676520616e792074686972642070617274792773206c6567616c207269676874732c20616e64206d757374206e6f742062652063617061626c65206f6620676976696e67207269736520746f206c6567616c20616374696f6e207768657468657220616761696e737420796f75206f72206f6e6c696e6534646174696e672e636f6d2020206f7220612074686972642070617274792028696e2065616368206361736520756e64657220616e79206170706c696361626c65206c6177292e3c2f703e3c703e596f75206d757374206e6f74207375626d697420616e79207573657220636f6e74656e7420746f2074686520776562736974652074686174206973206f72206861732065766572206265656e20746865207375626a656374206f6620616e7920746872656174656e6564206f722061637475616c206c6567616c2070726f63656564696e6773206f72206f746865722073696d696c617220636f6d706c61696e742e3c2f703e3c703e6f6e6c696e6534646174696e672e636f6d2072657365727665732074686520726967687420746f2065646974206f722072656d6f766520616e79206d6174657269616c207375626d697474656420746f207468697320776562736974652c206f722073746f726564206f6e206f6e6c696e6534646174696e672e636f6d2773736572766572732c206f7220686f73746564206f72207075626c69736865642075706f6e207468697320776562736974652e3c2f703e203c703e5b4e6f74776974687374616e64696e67205b4e414d4527535d2072696768747320756e646572207468657365207465726d7320616e6420636f6e646974696f6e7320696e2072656c6174696f6e20746f207573657220636f6e74656e742c206f6e6c696e6534646174696e672e636f6d202020646f6573206e6f7420756e64657274616b6520746f206d6f6e69746f7220746865207375626d697373696f6e206f66207375636820636f6e74656e7420746f2c206f7220746865207075626c69636174696f6e206f66207375636820636f6e74656e74206f6e2c207468697320776562736974652e5d3c2f703e3c68333e4e6f2077617272616e746965733c2f68333e5468697320776562736974652069732070726f7669646564209361732069739420776974686f757420616e7920726570726573656e746174696f6e73206f722077617272616e746965732c2065787072657373206f7220696d706c6965642e206f6e6c696e6534646174696e672e636f6d2020206d616b6573206e6f20726570726573656e746174696f6e73206f722077617272616e7469657320696e2072656c6174696f6e20746f20746869732077656273697465206f722074686520696e666f726d6174696f6e20616e64206d6174657269616c732070726f7669646564206f6e207468697320776562736974652e20266e6273703b3c6272202f3e3c6272202f3e576974686f7574207072656a756469636520746f207468652067656e6572616c697479206f662074686520666f7265676f696e67207061726167726170682c206f6e6c696e6534646174696e672e636f6d202020646f6573206e6f742077617272616e7420746861743a3c6272202f3e3c6f6c3e3c6c693e7468697320776562736974652077696c6c20626520636f6e7374616e746c7920617661696c61626c652c206f7220617661696c61626c6520617420616c6c3b206f723c2f6c693e3c6c693e74686520696e666f726d6174696f6e206f6e2074686973207765627369746520697320636f6d706c6574652c20747275652c206163637572617465206f72206e6f6e2d6d69736c656164696e672e3c6272202f3e3c2f6c693e3c2f6f6c3e3c703e4e6f7468696e67206f6e2074686973207765627369746520636f6e73746974757465732c206f72206973206d65616e7420746f20636f6e737469747574652c20616476696365206f6620616e79206b696e642e266e6273703b205b496620796f7520726571756972652061647669636520696e2072656c6174696f6e20746f20616e79205b6c6567616c2c2066696e616e6369616c206f72206d65646963616c5d206d617474657220796f752073686f756c6420636f6e73756c7420616e20617070726f7072696174652070726f66657373696f6e616c2e5d3c2f703e3c68333e4c696d69746174696f6e73206f66206c696162696c6974793c6272202f3e3c2f68333e3c703e6f6e6c696e6534646174696e672e636f6d77696c6c206e6f74206265206c6961626c6520746f20796f7520287768657468657220756e64657220746865206c6177206f6620636f6e746163742c20746865206c6177206f6620746f727473206f72206f74686572776973652920696e2072656c6174696f6e20746f2074686520636f6e74656e7473206f662c206f7220757365206f662c206f72206f746865727769736520696e20636f6e6e656374696f6e20776974682c207468697320776562736974653a3c2f703e3c6f6c3e3c6c693e205b746f2074686520657874656e7420746861742074686520776562736974652069732070726f766964656420667265652d6f662d6368617267652c20666f7220616e7920646972656374206c6f73733b5d266e6273703b3c2f6c693e3c6c693e666f7220616e7920696e6469726563742c207370656369616c206f7220636f6e73657175656e7469616c206c6f73733b206f72266e6273703b3c2f6c693e3c6c693e666f7220616e7920627573696e657373206c6f737365732c206c6f7373206f6620726576656e75652c20696e636f6d652c2070726f66697473206f7220616e7469636970617465640d0a20736176696e67732c206c6f7373206f6620636f6e747261637473206f7220627573696e6573732072656c6174696f6e73686970732c206c6f7373206f66200d0a72657075746174696f6e206f7220676f6f6477696c6c2c206f72206c6f7373206f7220636f7272757074696f6e206f6620696e666f726d6174696f6e206f7220646174612e3c6272202f3e3c2f6c693e3c2f6f6c3e3c703e5468657365206c696d69746174696f6e73206f66206c696162696c697479206170706c79206576656e206966206f6e6c696e6534646174696e672e636f6d20686173206265656e20657870726573736c792061647669736564206f662074686520706f74656e7469616c206c6f73733c2f703e3c68333e457863657074696f6e733c2f68333e3c703e4e6f7468696e6720696e2074686973207765627369746520646973636c61696d65722077696c6c206578636c756465206f72206c696d697420616e792077617272616e747920696d706c696564206279206c6177207468617420697420776f756c6420626520756e6c617766756c20746f206578636c756465206f72206c696d69743b20616e64206e6f7468696e6720696e2074686973207765627369746520646973636c61696d65722077696c6c206578636c756465206f72206c696d6974206f6e6c696e6534646174696e672e636f6d2773206c696162696c69747920696e2072657370656374206f6620616e793a3c2f703e3c756c3e3c6c693e6465617468206f7220706572736f6e616c20696e6a75727920636175736564206279206f6e6c696e6534646174696e672773206e65676c6967656e63653b3c2f6c693e3c6c693e6672617564206f72206672617564756c656e74206d6973726570726573656e746174696f6e206f6e207468652070617274206f66206f6e6c696e6534646174696e672e636f6d3b206f723c2f6c693e3c6c693e6d617474657220776869636820697420776f756c6420626520696c6c6567616c206f7220756e6c617766756c20666f72206f6e6c696e6534646174696e672e636f6d20746f206578636c756465206f72200d0a6c696d69742c206f7220746f20617474656d7074206f7220707572706f727420746f206578636c756465206f72206c696d69742c20697473206c696162696c6974792e20203c6272202f3e3c2f6c693e3c2f756c3e3c68333e526561736f6e61626c656e6573733c2f68333e3c703e4279207573696e67207468697320776562736974652c20796f75206167726565207468617420746865206578636c7573696f6e7320616e64206c696d69746174696f6e73206f66206c696162696c69747920736574206f757420696e2074686973207765627369746520646973636c61696d65722061726520726561736f6e61626c652e3c2f703e203c703e496620796f7520646f206e6f74207468696e6b20746865792061726520726561736f6e61626c652c20796f75206d757374206e6f7420757365207468697320776562736974652e3c2f703e3c68333e4f7468657220706172746965733c2f68333e3c703e5b596f752061636365707420746861742c2061732061206c696d69746564206c696162696c69747920656e746974792c206f6e6c696e6534646174696e672e636f6d2068617320616e20696e74657265737420696e206c696d6974696e672074686520706572736f6e616c206c696162696c697479206f6620697473206f6666696365727320616e6420656d706c6f796565732e266e6273703b20596f75206167726565207468617420796f752077696c6c206e6f74206272696e6720616e7920636c61696d20706572736f6e616c6c7920616761696e7374206f6e6c696e6534646174696e672e636f6d2773206f66666963657273206f7220656d706c6f7965657320696e2072657370656374206f6620616e79206c6f7373657320796f752073756666657220696e20636f6e6e656374696f6e20776974682074686520776562736974652e5d3c2f703e3c703e5b576974686f7574207072656a756469636520746f2074686520666f7265676f696e67207061726167726170682c5d20796f75206167726565207468617420746865206c696d69746174696f6e73206f662077617272616e7469657320616e64206c696162696c69747920736574206f757420696e2074686973207765627369746520646973636c61696d65722077696c6c2070726f74656374206f6e6c696e6534646174696e672e636f6d27732020206f666669636572732c20656d706c6f796565732c206167656e74732c207375627369646961726965732c20737563636573736f72732c2061737369676e7320616e64207375622d636f6e74726163746f72732061732077656c6c206173206f6e6c696e6534646174696e672e636f6d2e203c2f703e3c68333e556e656e666f72636561626c652070726f766973696f6e733c2f68333e3c703e496620616e792070726f766973696f6e206f662074686973207765627369746520646973636c61696d65722069732c206f7220697320666f756e6420746f2062652c20756e656e666f72636561626c6520756e646572206170706c696361626c65206c61772c20746861742077696c6c206e6f74206166666563742074686520656e666f7263656162696c697479206f6620746865206f746865722070726f766973696f6e73206f662074686973207765627369746520646973636c61696d65722e3c2f703e3c68333e496e64656d6e6974793c2f68333e3c703e596f752068657265627920696e64656d6e696679206f6e6c696e6534646174696e672e636f6d20616e6420756e64657274616b6520746f206b656570206f6e6c696e6534646174696e672e636f6d202020696e64656d6e696669656420616761696e737420616e79206c6f737365732c2064616d616765732c20636f7374732c206c696162696c697469657320616e6420657870656e7365732028696e636c7564696e6720776974686f7574206c696d69746174696f6e206c6567616c20657870656e73657320616e6420616e7920616d6f756e74732070616964206279206f6e6c696e6534646174696e672e636f6d202020746f206120746869726420706172747920696e20736574746c656d656e74206f66206120636c61696d206f722064697370757465206f6e2074686520616476696365206f66206f6e6c696e6534646174696e672e636f6d27736c6567616c2061647669736572732920696e637572726564206f72207375666665726564206279206f6e6c696e6534646174696e672e636f6d20202061726973696e67206f7574206f6620616e792062726561636820627920796f75206f6620616e792070726f766973696f6e206f66207468657365207465726d7320616e6420636f6e646974696f6e735b2c206f722061726973696e67206f7574206f6620616e7920636c61696d207468617420796f75206861766520627265616368656420616e792070726f766973696f6e206f66207468657365207465726d7320616e6420636f6e646974696f6e735d2e3c2f703e203c68333e4272656163686573206f66207468657365207465726d7320616e6420636f6e646974696f6e733c2f68333e3c703e576974686f7574207072656a756469636520746f206f6e6c696e6534646174696e672e636f6d27736f746865722072696768747320756e646572207468657365207465726d7320616e6420636f6e646974696f6e732c20696620796f7520627265616368207468657365207465726d7320616e6420636f6e646974696f6e7320696e20616e79207761792c206f6e6c696e6534646174696e672e636f6d2020206d61792074616b65207375636820616374696f6e206173206f6e6c696e6534646174696e672e636f6d2020206465656d7320617070726f70726961746520746f206465616c207769746820746865206272656163682c20696e636c7564696e672073757370656e64696e6720796f75722061636365737320746f2074686520776562736974652c2070726f6869626974696e6720796f752066726f6d20616363657373696e672074686520776562736974652c20626c6f636b696e6720636f6d707574657273207573696e6720796f757220495020616464726573732066726f6d20616363657373696e672074686520776562736974652c20636f6e74616374696e6720796f757220696e7465726e657420736572766963652070726f766964657220746f20726571756573742074686174207468657920626c6f636b20796f75722061636365737320746f20746865207765627369746520616e642f6f72206272696e67696e6720636f7572742070726f63656564696e677320616761696e737420796f752e3c2f703e203c68333e566172696174696f6e3c2f68333e3c703e6f6e6c696e6534646174696e672e636f6d2020206d617920726576697365207468657365207465726d7320616e6420636f6e646974696f6e732066726f6d2074696d652d746f2d74696d652e266e6273703b2052657669736564207465726d7320616e6420636f6e646974696f6e732077696c6c206170706c7920746f2074686520757365206f66207468697320776562736974652066726f6d207468652064617465206f6620746865207075626c69636174696f6e206f66207468652072657669736564207465726d7320616e6420636f6e646974696f6e73206f6e207468697320776562736974652e266e6273703b20506c6561736520636865636b2074686973207061676520726567756c61726c7920746f20656e7375726520796f75206172652066616d696c6961722077697468207468652063757272656e742076657273696f6e2e3c2f703e3c68333e41737369676e6d656e743c2f68333e3c703e6f6e6c696e6534646174696e672e636f6d2020206d6179207472616e736665722c207375622d636f6e7472616374206f72206f7468657277697365206465616c2077697468206f6e6c696e6534646174696e672e636f6d20202072696768747320616e642f6f72206f626c69676174696f6e7320756e646572207468657365207465726d7320616e6420636f6e646974696f6e7320776974686f7574206e6f74696679696e6720796f75206f72206f627461696e696e6720796f757220636f6e73656e742e3c2f703e3c703e596f75206d6179206e6f74207472616e736665722c207375622d636f6e7472616374206f72206f7468657277697365206465616c207769746820796f75722072696768747320616e642f6f72206f626c69676174696f6e7320756e646572207468657365207465726d7320616e6420636f6e646974696f6e732e266e6273703b203c6272202f3e3c2f703e3c68333e53657665726162696c6974793c2f68333e3c703e496620612070726f766973696f6e206f66207468657365207465726d7320616e6420636f6e646974696f6e732069732064657465726d696e656420627920616e7920636f757274206f72206f7468657220636f6d706574656e7420617574686f7269747920746f20626520756e6c617766756c20616e642f6f7220756e656e666f72636561626c652c20746865206f746865722070726f766973696f6e732077696c6c20636f6e74696e756520696e206566666563742e266e6273703b20496620616e7920756e6c617766756c20616e642f6f7220756e656e666f72636561626c652070726f766973696f6e20776f756c64206265206c617766756c206f7220656e666f72636561626c652069662070617274206f6620697420776572652064656c657465642c207468617420706172742077696c6c206265206465656d656420746f2062652064656c657465642c20616e64207468652072657374206f66207468652070726f766973696f6e2077696c6c20636f6e74696e756520696e206566666563742e203c2f703e3c68333e456e746972652061677265656d656e743c2f68333e3c703e5468657365207465726d7320616e6420636f6e646974696f6e7320636f6e737469747574652074686520656e746972652061677265656d656e74206265747765656e20796f7520616e64206f6e6c696e6534646174696e672e636f6d202020696e2072656c6174696f6e20746f20796f757220757365206f66207468697320776562736974652c20616e642073757065727365646520616c6c2070726576696f75732061677265656d656e747320696e2072657370656374206f6620796f757220757365206f66207468697320776562736974652e3c2f703e3c68333e4c617720616e64206a7572697364696374696f6e3c2f68333e5468657365207465726d7320616e6420636f6e646974696f6e732077696c6c20626520676f7665726e656420627920616e6420636f6e73747275656420696e206163636f7264616e63652077697468205b474f5645524e494e47204c41575d2c20616e6420616e792064697370757465732072656c6174696e6720746f207468657365207465726d7320616e6420636f6e646974696f6e732077696c6c206265207375626a65637420746f20746865205b6e6f6e2d5d6578636c7573697665206a7572697364696374696f6e206f662074686520636f75727473206f66205b4a5552495344494354494f4e5d2e3c6272202f3e3c6272202f3e5b526567697374726174696f6e7320616e6420617574686f7269736174696f6e733c6272202f3e3c6272202f3e5b5b4e414d455d20697320726567697374657265642077697468205b54524144452052454749535445525d2e266e6273703b20596f752063616e2066696e6420746865206f6e6c696e652076657273696f6e206f6620746865207265676973746572206174205b55524c5d2e266e6273703b205b4e414d4527535d20726567697374726174696f6e206e756d626572206973205b4e554d4245525d2e5d3c6272202f3e3c6272202f3e5b5b4e414d455d206973207375626a65637420746f205b415554484f5249534154494f4e20534348454d455d2c2077686963682069732073757065727669736564206279205b53555045525649534f525920415554484f524954595d2e5d3c6272202f3e3c6272202f3e5b5b4e414d455d20697320726567697374657265642077697468205b50524f46455353494f4e414c20424f44595d2e266e6273703b205b4e414d4527535d2070726f66657373696f6e616c207469746c65206973205b5449544c455d20616e6420697420686173206265656e206772616e74656420696e2074686520556e69746564204b696e67646f6d2e266e6273703b205b4e414d455d206973207375626a65637420746f20746865205b52554c45535d2077686963682063616e20626520666f756e64206174205b55524c5d2e5d3c6272202f3e3c6272202f3e5b5b4e414d455d207375627363726962657320746f2074686520666f6c6c6f77696e6720636f64655b735d206f6620636f6e647563743a205b434f4445285329204f4620434f4e445543545d2e266e6273703b205b546865736520636f6465732f7468697320636f64655d2063616e20626520636f6e73756c74656420656c656374726f6e6963616c6c79206174205b55524c2853295d2e3c6272202f3e3c6272202f3e5b5b4e414d4527535d205b5441585d206e756d626572206973205b4e554d4245525d2e5d5d3c6272202f3e3c6272202f3e5b4e414d4527535d2064657461696c733c6272202f3e3c6272202f3e5468652066756c6c206e616d65206f66205b4e414d455d206973205b46554c4c204e414d455d2e20266e6273703b3c6272202f3e3c6272202f3e5b5b4e414d455d206973207265676973746572656420696e205b4a5552495344494354494f4e5d20756e64657220726567697374726174696f6e206e756d626572205b4e554d4245525d2e5d20266e6273703b3c6272202f3e3c6272202f3e5b4e414d4527535d205b726567697374657265645d2061646472657373206973205b414444524553535d2e20266e6273703b3c6272202f3e3c6272202f3e596f752063616e20636f6e74616374205b4e414d455d20627920656d61696c20746f205b454d41494c5d2e3c6272202f3e3c6272202f3e3c68333e546572726f7269736d202f204c61773c2f68333e3c703e596f75206d6179206e6f742075736520746869732077656273697465207768696c65206469726563746c79206f7220696e6469726563746c7920636f6d6d6974696e67206f7220686176696e6720636f6d6d6974656420616e20616374206f6620746572726f7269736d2e205468757320796f75206d6179206e6f742075736520746869732077656273697465206966206f6e65206f7220616e79206f662074686520666f6c6c6f77696e672e3c2f703e3c6f6c3e3c6c693e436f6e73697374696e67206f66207061727469636c65732e266e6273703b3c2f6c693e3c6c693e4469726563746c79206f7220696e6469726563746c7920756e6465722074686520696e666c75656e6365206f6620677261766974792e20203c6272202f3e3c2f6c693e3c2f6f6c3e3c68333e4372656469743c2f68333e5468697320646f63756d656e74207761732063726561746564207573696e67206120436f6e74726163746f6c6f67792074656d706c61746520617661696c61626c6520617420687474703a2f2f7777772e667265656e65746c61772e636f6d2e, NULL, 0);

; */ ?>