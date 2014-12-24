<?php /* ;


CREATE TABLE IF NOT EXISTS `ajax_chat_bans` (
  `userID` int(11) NOT NULL,
  `userName` varchar(64) COLLATE utf8_bin NOT NULL,
  `dateTime` datetime NOT NULL,
  `ip` varbinary(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `ajax_chat_invitations`
--

CREATE TABLE IF NOT EXISTS `ajax_chat_invitations` (
  `userID` int(11) NOT NULL,
  `channel` int(11) NOT NULL,
  `dateTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `ajax_chat_messages`
--

CREATE TABLE IF NOT EXISTS `ajax_chat_messages` (
`id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `userName` varchar(64) COLLATE utf8_bin NOT NULL,
  `userRole` int(1) NOT NULL,
  `channel` int(11) NOT NULL,
  `dateTime` datetime NOT NULL,
  `ip` varbinary(16) NOT NULL,
  `text` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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
  `ip` varbinary(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `t_backup`
--

CREATE TABLE IF NOT EXISTS `t_backup` (
`id` int(10) NOT NULL,
  `name` varchar(200) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_cms_customer`
--

CREATE TABLE IF NOT EXISTS `t_cms_customer` (
`id` int(11) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
`id` int(10) unsigned NOT NULL,
  `lang` varchar(4) NOT NULL,
  `code` int(10) unsigned NOT NULL,
  `value` blob NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_code`
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
(15, 'en', 15, 0x4f6e6c696e6520446174696e67),
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
(41, 'en', 41, 0x43686174),
(42, 'en', 42, 0x61646d696e4e6577736c6574746572),
(43, 'en', 43, 0x75736572467269656e6452657175657374),
(44, 'en', 44, 0x536974656d6170),
(45, 'en', 45, 0x61646d696e4d656e7573),
(46, 'en', 46, 0x61646d696e5573657273),
(47, 'en', 47, 0x75736572496e666f),
(48, 'en', 48, 0x7573657253657474696e6773),
(49, 'en', 49, 0x7573657253657474696e6773),
(50, 'en', 50, 0x75736572496e666f),
(51, 'en', 51, 0x7573657250726f66696c6527413d30),
(52, 'en', 52, 0x4c657473204d616b6520412055464f),
(53, 'en', 53, 0x7573657250726f66696c6561),
(54, 'en', 54, 0x7573657250726f66696c656127202d2d2061),
(55, 'en', 55, 0x7573657250726f66696c6527206f7220313d31202d2d);

-- --------------------------------------------------------

--
-- Table structure for table `t_comment`
--

CREATE TABLE IF NOT EXISTS `t_comment` (
`id` int(10) NOT NULL,
  `moduleid` int(10) NOT NULL,
  `name` varchar(200) NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `comment` blob NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_confirm`
--

CREATE TABLE IF NOT EXISTS `t_confirm` (
`id` int(10) NOT NULL,
  `hash` varchar(40) NOT NULL,
  `moduleid` int(10) NOT NULL,
  `args` blob NOT NULL,
  `expiredate` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_country`
--

CREATE TABLE IF NOT EXISTS `t_country` (
  `geonameid` varchar(20) COLLATE utf8_bin NOT NULL,
  `name` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `t_country`
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
('935317', 'RÃƒÂ©union'),
('3370751', 'Saint Helena'),
('2245662', 'Senegal'),
('241170', 'Seychelles'),
('2403846', 'Sierra Leone'),
('51537', 'Somalia'),
('953987', 'South Africa'),
('7909807', 'South Sudan'),
('366755', 'Sudan'),
('934841', 'Swaziland'),
('2410758', 'SÃƒÂ£o TomÃƒÂ© and PrÃƒÂ­ncipe'),
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
('661882', 'Ãƒâ€¦land'),
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
('7626836', 'CuraÃƒÂ§ao'),
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
('3578476', 'Saint BarthÃƒÂ©lemy'),
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
-- Table structure for table `t_domain`
--

CREATE TABLE IF NOT EXISTS `t_domain` (
`id` int(10) NOT NULL,
  `url` varchar(200) NOT NULL,
  `siteid` int(10) NOT NULL,
  `domaintrackerscript` blob
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_domain`
--

INSERT INTO `t_domain` (`id`, `url`, `siteid`, `domaintrackerscript`) VALUES
(1, 'online4dating.net', 1, ''),
(2, 'www.online4dating.net', 1, ''),
(3, 'makeufo.com', 2, '');

-- --------------------------------------------------------

--
-- Table structure for table `t_email`
--

CREATE TABLE IF NOT EXISTS `t_email` (
`id` int(11) NOT NULL,
  `email` varchar(200) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `t_event`
--

CREATE TABLE IF NOT EXISTS `t_event` (
`id` int(10) NOT NULL,
  `date` date NOT NULL,
  `houres` int(10) NOT NULL DEFAULT '0',
  `minutes` int(10) NOT NULL DEFAULT '0',
  `starthoure` int(10) NOT NULL,
  `startminute` int(10) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` blob NOT NULL,
  `type` int(5) NOT NULL,
  `userid` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_forum_post`
--

CREATE TABLE IF NOT EXISTS `t_forum_post` (
`id` int(10) NOT NULL,
  `userid` int(10) NOT NULL,
  `threadid` int(10) NOT NULL,
  `message` blob NOT NULL,
  `createdate` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_forum_thread`
--

CREATE TABLE IF NOT EXISTS `t_forum_thread` (
`id` int(10) NOT NULL,
  `userid` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `message` blob NOT NULL,
  `parent` int(10) NOT NULL,
  `createdate` date NOT NULL,
  `views` int(5) NOT NULL,
  `replies` int(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_forum_topic`
--

CREATE TABLE IF NOT EXISTS `t_forum_topic` (
`id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `parent` int(10) NOT NULL,
  `createdate` date NOT NULL,
  `userid` int(11) NOT NULL,
  `views` int(10) NOT NULL,
  `replies` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_gallery_category`
--

CREATE TABLE IF NOT EXISTS `t_gallery_category` (
`id` int(10) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` blob NOT NULL,
  `image` int(10) DEFAULT NULL,
  `parent` int(10) DEFAULT NULL,
  `orderkey` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_gallery_image`
--

CREATE TABLE IF NOT EXISTS `t_gallery_image` (
`id` int(10) unsigned NOT NULL,
  `title` varchar(100) NOT NULL,
  `image` varchar(50) NOT NULL,
  `orderkey` int(10) NOT NULL,
  `categoryid` int(10) NOT NULL,
  `description` blob NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_gallery_page`
--

CREATE TABLE IF NOT EXISTS `t_gallery_page` (
`id` int(10) NOT NULL,
  `typeid` int(11) NOT NULL,
  `rootcategory` int(10) NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_language`
--

CREATE TABLE IF NOT EXISTS `t_language` (
`id` int(10) NOT NULL,
  `code` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `local` varchar(10) NOT NULL,
  `flag` varchar(100) NOT NULL,
  `active` int(1) NOT NULL,
  `isdefault` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

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
`id` int(10) unsigned NOT NULL,
  `page` int(10) unsigned NOT NULL,
  `type` int(5) unsigned NOT NULL,
  `parent` int(10) DEFAULT NULL,
  `active` int(1) NOT NULL,
  `lang` varchar(5) NOT NULL DEFAULT 'en',
  `position` int(10) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_menu`
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
(24, 41, 1, NULL, 1, 'en', 24),
(25, 44, 3, NULL, 1, 'en', 25),
(26, 1, 0, NULL, 0, 'en', 26),
(27, 49, 0, NULL, 0, 'en', 27),
(28, 50, 0, NULL, 0, 'en', 28);

-- --------------------------------------------------------

--
-- Table structure for table `t_menu_instance`
--

CREATE TABLE IF NOT EXISTS `t_menu_instance` (
`id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `siteid` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_menu_instance`
--

INSERT INTO `t_menu_instance` (`id`, `name`, `siteid`) VALUES
(1, 'Main Menu', 1),
(2, 'Bottom Menu', 1),
(3, 'Top Menu', 1);

-- --------------------------------------------------------

--
-- Table structure for table `t_menu_style`
--

CREATE TABLE IF NOT EXISTS `t_menu_style` (
`id` int(10) NOT NULL,
  `cssclass` blob NOT NULL,
  `cssstyle` blob NOT NULL,
  `name` varchar(200) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_menu_style`
--

INSERT INTO `t_menu_style` (`id`, `cssclass`, `cssstyle`, `name`) VALUES
(1, '', '', 'Plain Menu'),
(4, 0x706c61696e4469764d656e75, 0x2e706c61696e4469764d656e75207b0d0a202020206865696768743a20323070783b0d0a202020206c696e652d6865696768743a20323070783b0d0a20202020666f6e742d7765696768743a626f6c643b0d0a7d0d0a2e706c61696e4469764d656e75202e7364646d207b0d0a20202020666f6e742d73697a653a20313570783b0d0a7d0d0a2e706c61696e4469764d656e75202e7364646d206469762061207b0d0a20202020746578742d6465636f726174696f6e3a206e6f6e653b0d0a2020202070616464696e673a20307078203770783b0d0a202020206d617267696e3a203070783b0d0a20202020636f6c6f723a20626c61636b3b0d0a7d0d0a2e706c61696e4469764d656e75202e7364646d2064697620612e7364646d53656c6563746564207b0d0a7d0d0a2e706c61696e4469764d656e75202e7364646d2064697620613a686f766572207b0d0a20202020626f726465723a203170782030707820736f6c69642073696c7665723b0d0a7d0d0a2e706c61696e4469764d656e75202e7364646d2064697620646976207b0d0a202020206d696e2d77696474683a2031303070783b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a7d0d0a2e706c61696e4469764d656e75202e7364646d206469762064697620613a686f766572207b0d0a202020206261636b67726f756e642d636f6c6f723a20726762283230302c203230302c20323030293b0d0a20202020626f726465723a203170782030707820736f6c69642073696c7665723b0d0a7d0d0a2e706c61696e4469764d656e75202e7364646d20646976206469762061207b0d0a7d0d0a2e706c61696e4469764d656e75202e7364646d206469762064697620612e7364646d53656c6563746564207b0d0a7d0d0a2e706c61696e4469764d656e75202e7364646d2064697620612e7364646d4669727374207b0d0a2020202070616464696e672d6c6566743a203070783b0d0a20202020626f726465722d6c6566743a20307078206e6f6e653b0d0a7d, 'Main Menu'),
(5, 0x6c6576656c73, 0x2f2a206669727374206c6576656c202a2f0d0a0d0a2e6c6576656c73207b0d0a2020202070616464696e673a2031307078203070782030707820313070783b0d0a7d0d0a2e6c6576656c73202e7364646d207b0d0a20202020666c6f61743a6c6566743b0d0a7d0d0a2e6c6576656c73202e7364646d20646976207b0d0a20202020666c6f61743a6e6f6e653b0d0a7d0d0a2e6c6576656c73202e7364646d206469762061207b0d0a20202020636f6c6f723a20626c61636b3b0d0a20202020746578742d6465636f726174696f6e3a206e6f6e653b0d0a20202020746578742d616c69676e3a206c6566743b0d0a2020202070616464696e673a203570783b0d0a20202020666f6e742d7765696768743a626f6c643b0d0a20202020666f6e742d73697a653a20313470783b0d0a7d0d0a2e6c6576656c73202e7364646d2064697620613a686f766572207b0d0a09746578742d6465636f726174696f6e3a20756e6465726c696e653b0d0a7d0d0a2e6c6576656c73202e7364646d2064697620612e7364646d4669727374207b0d0a20202020626f726465722d6c6566743a20307078206e6f6e653b0d0a7d0d0a2e6c6576656c73202e7364646d20646976202e7364646d53656c6563746564207b0d0a20202020646973706c61793a20626c6f636b3b0d0a20202020636f6c6f723a207265643b0d0a7d0d0a0d0a2f2a207365636f6e64206c6576656c202a2f0d0a0d0a2e6c6576656c73202e7364646d2064697620646976207b0d0a20202020706f736974696f6e3a2072656c61746976653b0d0a202020206261636b67726f756e643a206e6f6e653b0d0a7d0d0a2e6c6576656c73202e7364646d20646976206469762061207b0d0a20202020636f6c6f723a20233030364335353b0d0a20202020666f6e742d73697a653a20313270783b0d0a20202020666f6e742d7765696768743a206e6f726d616c3b0d0a202020206261636b67726f756e643a2075726c28272e2e2f696d672f6c697374655f7a65696368656e2e6769662729206e6f2d7265706561743b0d0a202020206261636b67726f756e642d706f736974696f6e3a2030707820313070783b0d0a202020206d617267696e2d6c6566743a20313070783b0d0a2020202070616464696e672d6c6566743a20313070783b0d0a7d0d0a2e6c6576656c73202e7364646d206469762064697620612e7364646d53656c6563746564207b0d0a20202020666f6e742d7765696768743a20626f6c643b0d0a20202020636f6c6f723a20626c61636b3b0d0a7d0d0a2e6c6576656c73202e7364646d206469762064697620613a686f766572207b0d0a20202020636f6c6f723a20626c61636b3b0d0a20202020746578742d6465636f726174696f6e3a206e6f6e653b0d0a7d0d0a0d0a2f2a207468697264206c6576656c202a2f0d0a0d0a2e6c6576656c73202e7364646d206469762064697620646976207b0d0a20202020706f736974696f6e3a206162736f6c7574653b0d0a202020206261636b67726f756e643a20726762283234302c3234302c323430293b0d0a20202020746f703a3070783b0d0a202020206c6566743a31303070783b0d0a7d0d0a2e6c6576656c73202e7364646d2064697620646976206469762061207b0d0a20202020636f6c6f723a20233030364335353b0d0a20202020666f6e742d73697a653a20313270783b0d0a20202020666f6e742d7765696768743a206e6f726d616c3b0d0a202020206261636b67726f756e643a2075726c28272e2e2f696d672f6c697374655f7a65696368656e2e6769662729206e6f2d7265706561743b0d0a202020206261636b67726f756e642d706f736974696f6e3a2030707820313070783b0d0a202020206d617267696e2d6c6566743a20313070783b0d0a2020202070616464696e672d6c6566743a20313070783b0d0a7d0d0a2e6c6576656c73202e7364646d20646976206469762064697620612e7364646d53656c6563746564207b0d0a20202020666f6e742d7765696768743a20626f6c643b0d0a20202020636f6c6f723a20626c61636b3b0d0a7d0d0a2e6c6576656c73202e7364646d20646976206469762064697620613a686f766572207b0d0a20202020636f6c6f723a20626c61636b3b0d0a20202020746578742d6465636f726174696f6e3a206e6f6e653b0d0a7d, 'Stack Menu'),
(7, 0x746f704469764d656e7520, 0x2e746f704469764d656e75207b0d0a202020206d617267696e2d6c6566743a313070783b0d0a202020206865696768743a323270783b0d0a20202020666f6e743a203131707820417269616c2c73616e732d73657269663b0d0a20202020636f6c6f723a20234646463b0d0a202020206c696e652d6865696768743a323270783b0d0a7d0d0a2e746f704469764d656e75202e7364646d207b0d0a7d0d0a2e746f704469764d656e75202e7364646d206469762061207b0d0a20202020746578742d6465636f726174696f6e3a206e6f6e653b0d0a2020202070616464696e673a20307078203770783b0d0a202020206d617267696e3a203070783b0d0a20202020666f6e742d7765696768743a6e6f726d616c3b0d0a7d0d0a2e746f704469764d656e75202e7364646d2064697620612e7364646d53656c6563746564207b0d0a20202020636f6c6f723a20234646444430303b0d0a7d0d0a2e746f704469764d656e75202e7364646d2064697620613a686f766572207b0d0a20202020636f6c6f723a20234646444430303b0d0a7d0d0a2e746f704469764d656e75202e7364646d2064697620646976207b0d0a202020206261636b67726f756e642d636f6c6f723a20726762283235302c3235302c323530293b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a2020202070616464696e673a203470783b0d0a7d0d0a2e746f704469764d656e75202e7364646d206469762064697620613a686f766572207b0d0a202020206261636b67726f756e642d636f6c6f723a20726762283234302c3234302c323430293b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a2020202070616464696e673a203370782033707820337078203470783b0d0a7d0d0a2e746f704469764d656e75202e7364646d20646976206469762061207b0d0a202020206261636b67726f756e642d636f6c6f723a20726762283235302c3235302c323530293b0d0a2020202070616464696e673a203470783b0d0a7d0d0a2e746f704469764d656e75202e7364646d206469762064697620612e7364646d53656c6563746564207b0d0a20202020666f6e742d7765696768743a20626f6c643b0d0a20202020636f6c6f723a626c61636b3b0d0a7d0d0a2e746f704469764d656e75202e7364646d2064697620612e7364646d4669727374207b0d0a2020202070616464696e672d6c6566743a203070783b0d0a20202020626f726465722d6c6566743a20307078206e6f6e653b0d0a7d, 'Top Menu'),
(8, 0x626f74746f6d4469764d656e75, 0x2e626f74746f6d4469764d656e75207b0d0a202020206d617267696e2d6c6566743a363070783b0d0a202020206865696768743a343870783b0d0a20202020666f6e743a203131707820417269616c2c73616e732d73657269663b0d0a202020206c696e652d6865696768743a343870783b0d0a7d0d0a2e626f74746f6d4469764d656e75202e7364646d207b0d0a7d0d0a2e626f74746f6d4469764d656e75202e7364646d206469762061207b0d0a20202020746578742d6465636f726174696f6e3a206e6f6e653b0d0a2020202070616464696e673a20307078203770783b0d0a202020206d617267696e3a203070783b0d0a20202020666f6e742d7765696768743a6e6f726d616c3b0d0a20202020636f6c6f723a20234646463b0d0a7d0d0a2e626f74746f6d4469764d656e75202e7364646d2064697620612e7364646d53656c6563746564207b0d0a20202020636f6c6f723a20234646444430303b0d0a7d0d0a2e626f74746f6d4469764d656e75202e7364646d2064697620613a686f766572207b0d0a20202020636f6c6f723a20234646444430303b0d0a7d0d0a2e626f74746f6d4469764d656e75202e7364646d2064697620646976207b0d0a202020206261636b67726f756e642d636f6c6f723a20726762283235302c3235302c323530293b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a2020202070616464696e673a203470783b0d0a7d0d0a2e626f74746f6d4469764d656e75202e7364646d206469762064697620613a686f766572207b0d0a202020206261636b67726f756e642d636f6c6f723a20726762283234302c3234302c323430293b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a2020202070616464696e673a203370782033707820337078203470783b0d0a7d0d0a2e626f74746f6d4469764d656e75202e7364646d20646976206469762061207b0d0a202020206261636b67726f756e642d636f6c6f723a20726762283235302c3235302c323530293b0d0a2020202070616464696e673a203470783b0d0a7d0d0a2e626f74746f6d4469764d656e75202e7364646d206469762064697620612e7364646d53656c6563746564207b0d0a20202020666f6e742d7765696768743a20626f6c643b0d0a20202020636f6c6f723a626c61636b3b0d0a7d0d0a2e626f74746f6d4469764d656e75202e7364646d2064697620612e7364646d4669727374207b0d0a2020202070616464696e672d6c6566743a203070783b0d0a20202020626f726465722d6c6566743a20307078206e6f6e653b0d0a7d, 'Bottom Menu');

-- --------------------------------------------------------

--
-- Table structure for table `t_module`
--

CREATE TABLE IF NOT EXISTS `t_module` (
`id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `sysname` varchar(100) NOT NULL,
  `include` varchar(100) NOT NULL,
  `description` blob,
  `interface` varchar(50) DEFAULT NULL,
  `inmenu` int(1) NOT NULL,
  `category` int(10) NOT NULL,
  `position` int(10) NOT NULL,
  `static` tinyint(1) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=100 DEFAULT CHARSET=latin1;

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
(99, 'User Settings', 'userSettings', 'modules/users/userSettingsModule.php', NULL, 'UserSettingsModule', 1, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `t_module_category`
--

CREATE TABLE IF NOT EXISTS `t_module_category` (
`id` int(10) NOT NULL,
  `position` int(10) NOT NULL,
  `name` varchar(200) COLLATE latin1_german2_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_module_instance`
--

CREATE TABLE IF NOT EXISTS `t_module_instance` (
`id` int(10) NOT NULL,
  `moduleid` int(10) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=101 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci;

--
-- Dumping data for table `t_module_instance`
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
(62, 2),
(63, 95),
(64, 16),
(65, 93),
(66, 2),
(67, 21),
(69, 2),
(70, 2),
(71, 71),
(72, 24),
(74, 2),
(75, 98),
(76, 98),
(77, 98),
(78, 98),
(79, 2),
(80, 95),
(81, 67),
(82, 67),
(83, 2),
(84, 95),
(85, 67),
(86, 0),
(87, 99),
(88, 82),
(89, 98),
(90, 98),
(92, 82),
(93, 98),
(95, 98),
(96, 2),
(97, 0),
(98, 0),
(99, 0),
(100, 0);

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

--
-- Dumping data for table `t_module_instance_params`
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
(60, NULL, 'captcha', 0x733a313a2231223b),
(76, NULL, 'mode', 0x733a313a2232223b),
(75, NULL, 'mode', 0x733a313a2231223b),
(77, NULL, 'mode', 0x733a313a2232223b),
(81, NULL, 'socialButtons', 0x613a39343a7b733a31393a2273745f666f726d737072696e675f6c61726765223b733a31303a22466f726d737072696e67223b733a31383a2273745f766b6f6e74616b74655f6c61726765223b733a393a22566b6f6e74616b7465223b733a31353a2273745f79616d6d65725f6c61726765223b733a363a2259616d6d6572223b733a31333a2273745f796967675f6c61726765223b733a353a222059696767223b733a31333a2273745f78696e675f6c61726765223b733a343a2258696e67223b733a31383a2273745f766f786f706f6c69735f6c61726765223b733a393a22564f586f706f6c6973223b733a31343a2273745f78657270695f6c61726765223b733a353a225865727069223b733a31343a2273745f78616e67615f6c61726765223b733a353a2258616e6761223b733a31383a2273745f776f726470726573735f6c61726765223b733a393a22576f72645072657373223b733a31353a2273745f7265646469745f6c61726765223b733a363a22526564646974223b733a31353a2273745f6e65746c6f675f6c61726765223b733a363a224e65746c6f67223b733a31333a2273745f766972625f6c61726765223b733a343a2256697262223b733a31353a2273745f76696164656f5f6c61726765223b733a363a2256696164656f223b733a31353a2273745f74756d626c725f6c61726765223b733a363a2254756d626c72223b733a31363a2273745f747970657061645f6c61726765223b733a373a2254797065506164223b733a31393a2273745f746563686e6f726174695f6c61726765223b733a31303a22546563686e6f72617469223b733a32303a2273745f7374756d626c6575706f6e5f6c61726765223b733a31313a225374756d626c6555706f6e223b733a31353a2273745f736f6e69636f5f6c61726765223b733a363a22536f6e69636f223b733a31373a2273745f73746172746c61705f6c61726765223b733a383a2253746172746c6170223b733a31373a2273745f73746172746169645f6c61726765223b733a383a225374617274616964223b733a31373a2273745f736c617368646f745f6c61726765223b733a383a22536c617368646f74223b733a31333a2273745f73696e615f6c61726765223b733a343a2253696e61223b733a31363a2273745f7365676e616c6f5f6c61726765223b733a373a225365676e616c6f223b733a31373a2273745f6e65777376696e655f6c61726765223b733a383a224e65777376696e65223b733a32353a2273745f72616973655f796f75725f766f6963655f6c61726765223b733a31363a22526169736520596f757220566f696365223b733a31343a2273745f6f726b75745f6c61726765223b733a353a224f726b7574223b733a31383a2273745f6f6b6e6f74697a69655f6c61726765223b733a393a224f6b6e6f74697a6965223b733a31363a2273745f6d61696c5f72755f6c61726765223b733a373a226d61696c2e7275223b733a31363a2273745f6e6574766f757a5f6c61726765223b733a373a224e6574766f757a223b733a32303a2273745f6d69737465725f776f6e675f6c61726765223b733a373a224d7220576f6e67223b733a31363a2273745f6d6f73686172655f6c61726765223b733a373a226d6f5368617265223b733a31333a2273745f6d6978785f6c61726765223b733a343a224d697878223b733a31383a2273745f6d657373656e6765725f6c61726765223b733a393a224d657373656e676572223b733a31363a2273745f6d656e65616d655f6c61726765223b733a373a224d656e65616d65223b733a32353a2273745f676f6f676c655f7472616e736c6174655f6c61726765223b733a31363a22476f6f676c65205472616e736c617465223b733a32303a2273745f6c6976656a6f75726e616c5f6c61726765223b733a31313a224c6976654a6f75726e616c223b733a31383a2273745f6c696e6b61676f676f5f6c61726765223b733a393a226c696e6b61476f476f223b733a31373a2273745f6b61626f6f646c655f6c61726765223b733a383a224b61626f6f646c65223b733a31373a2273745f6a756d70746167735f6c61726765223b733a383a224a756d7074616773223b733a31393a2273745f696e73746170617065725f6c61726765223b733a31303a22496e7374617061706572223b733a31353a2273745f6964656e74695f6c61726765223b733a393a226964656e74692e6361223b733a31343a2273745f68797665735f6c61726765223b733a353a224879766573223b733a31353a2273745f686174656e615f6c61726765223b733a363a22486174656e61223b733a32323a2273745f676f6f676c655f7265616465725f6c61726765223b733a31333a22476f6f676c6520526561646572223b733a32323a2273745f676f6f676c655f626d61726b735f6c61726765223b733a393a22426f6f6b6d61726b73223b733a31343a2273745f66776973705f6c61726765223b733a353a226677697370223b733a31353a2273745f676f6f676c655f6c61726765223b733a363a22476f6f676c65223b733a31393a2273745f667269656e64666565645f6c61726765223b733a31303a22467269656e6446656564223b733a31333a2273745f66756e705f6c61726765223b733a343a2246756e70223b733a31363a2273745f667265737175695f6c61726765223b733a373a2246726573717569223b733a31383a2273745f7368617265746869735f6c61726765223b733a393a22536861726554686973223b733a31343a2273745f666f6c6b645f6c61726765223b733a393a22666f6c6b642e636f6d223b733a32303a2273745f66617368696f6c697374615f6c61726765223b733a31313a2246617368696f6c69737461223b733a31333a2273745f6661726b5f6c61726765223b733a343a224661726b223b733a31373a2273745f657665726e6f74655f6c61726765223b733a383a22457665726e6f7465223b733a31343a2273745f63617265325f6c61726765223b733a353a224361726532223b733a31353a2273745f65646d6f646f5f6c61726765223b733a363a2245646d6f646f223b733a31343a2273745f647a6f6e655f6c61726765223b733a353a22445a6f6e65223b733a32333a2273745f646f746e657473686f75746f75745f6c61726765223b733a31333a222e6e65742053686f75746f7574223b733a31343a2273745f646969676f5f6c61726765223b733a353a22446969676f223b733a31333a2273745f646967675f6c61726765223b733a343a2244696767223b733a31383a2273745f64656c6963696f75735f6c61726765223b733a393a2244656c6963696f7573223b733a31383a2273745f6465616c73706c75735f6c61726765223b733a31303a224465616c73706c2e7573223b733a31363a2273745f63757272656e745f6c61726765223b733a373a2243757272656e74223b733a31383a2273745f636f726b626f6172645f6c61726765223b733a393a22436f726b626f617264223b733a31353a2273745f636f72616e6b5f6c61726765223b733a363a22636f52616e6b223b733a31373a2273745f636f6e6e6f7465615f6c61726765223b733a383a22436f6e6e6f746561223b733a31383a2273745f63697465756c696b655f6c61726765223b733a393a2243697465554c696b65223b733a31333a2273745f636869715f6c61726765223b733a343a2263686971223b733a32313a2273745f6275735f65786368616e67655f6c61726765223b733a393a2241646420746f204258223b733a31373a2273745f627261696e6966795f6c61726765223b733a383a22427261696e696679223b733a31393a2273745f62756464796d61726b735f6c61726765223b733a31303a2242756464794d61726b73223b733a31393a2273745f676f6f676c65706c75735f6c61726765223b733a383a22476f6f676c65202b223b733a31363a2273745f626c6f676765725f6c61726765223b733a373a22426c6f67676572223b733a31383a2273745f626c6f676d61726b735f6c61726765223b733a393a22426c6f676d61726b73223b733a31333a2273745f626c69705f6c61726765223b733a343a22426c6970223b733a31383a2273745f626c696e6b6c6973745f6c61726765223b733a393a22426c696e6b6c697374223b733a31333a2273745f6265626f5f6c61726765223b733a343a224265626f223b733a31333a2273745f6172746f5f6c61726765223b733a343a224172746f223b733a31343a2273745f62616964755f6c61726765223b733a353a224261696475223b733a32343a2273745f616d617a6f6e5f776973686c6973745f6c61726765223b733a31353a22416d617a6f6e20576973686c697374223b733a31383a2273745f616c6c766f696365735f6c61726765223b733a393a22416c6c766f69636573223b733a31343a2273745f61646674795f6c61726765223b733a353a224164667479223b733a31373a2273745f66616365626f6f6b5f6c61726765223b733a383a2246616365626f6f6b223b733a31363a2273745f747769747465725f6c61726765223b733a353a225477656574223b733a31373a2273745f6c696e6b6564696e5f6c61726765223b733a383a224c696e6b6564496e223b733a31383a2273745f70696e7465726573745f6c61726765223b733a393a2250696e746572657374223b733a31343a2273745f656d61696c5f6c61726765223b733a353a22456d61696c223b733a31363a2273745f6d7973706163655f6c61726765223b733a373a224d795370616365223b733a31323a2273745f6e34675f6c61726765223b733a333a224e3447223b733a31343a2273745f6e756a696a5f6c61726765223b733a353a224e556a696a223b733a32323a2273745f6f646e6f6b6c6173736e696b695f6c61726765223b733a31333a224f646e6f6b6c6173736e696b69223b733a31383a2273745f737065656474696c655f6c61726765223b733a393a22537065656474696c65223b733a31383a2273745f7374756d70656469615f6c61726765223b733a393a225374756d7065646961223b7d),
(82, NULL, 'socialButtons', 0x613a39343a7b733a31393a2273745f666f726d737072696e675f6c61726765223b733a31303a22466f726d737072696e67223b733a31383a2273745f766b6f6e74616b74655f6c61726765223b733a393a22566b6f6e74616b7465223b733a31353a2273745f79616d6d65725f6c61726765223b733a363a2259616d6d6572223b733a31333a2273745f796967675f6c61726765223b733a353a222059696767223b733a31333a2273745f78696e675f6c61726765223b733a343a2258696e67223b733a31383a2273745f766f786f706f6c69735f6c61726765223b733a393a22564f586f706f6c6973223b733a31343a2273745f78657270695f6c61726765223b733a353a225865727069223b733a31343a2273745f78616e67615f6c61726765223b733a353a2258616e6761223b733a31383a2273745f776f726470726573735f6c61726765223b733a393a22576f72645072657373223b733a31353a2273745f7265646469745f6c61726765223b733a363a22526564646974223b733a31353a2273745f6e65746c6f675f6c61726765223b733a363a224e65746c6f67223b733a31333a2273745f766972625f6c61726765223b733a343a2256697262223b733a31353a2273745f76696164656f5f6c61726765223b733a363a2256696164656f223b733a31353a2273745f74756d626c725f6c61726765223b733a363a2254756d626c72223b733a31363a2273745f747970657061645f6c61726765223b733a373a2254797065506164223b733a31393a2273745f746563686e6f726174695f6c61726765223b733a31303a22546563686e6f72617469223b733a32303a2273745f7374756d626c6575706f6e5f6c61726765223b733a31313a225374756d626c6555706f6e223b733a31353a2273745f736f6e69636f5f6c61726765223b733a363a22536f6e69636f223b733a31373a2273745f73746172746c61705f6c61726765223b733a383a2253746172746c6170223b733a31373a2273745f73746172746169645f6c61726765223b733a383a225374617274616964223b733a31373a2273745f736c617368646f745f6c61726765223b733a383a22536c617368646f74223b733a31333a2273745f73696e615f6c61726765223b733a343a2253696e61223b733a31363a2273745f7365676e616c6f5f6c61726765223b733a373a225365676e616c6f223b733a31373a2273745f6e65777376696e655f6c61726765223b733a383a224e65777376696e65223b733a32353a2273745f72616973655f796f75725f766f6963655f6c61726765223b733a31363a22526169736520596f757220566f696365223b733a31343a2273745f6f726b75745f6c61726765223b733a353a224f726b7574223b733a31383a2273745f6f6b6e6f74697a69655f6c61726765223b733a393a224f6b6e6f74697a6965223b733a31363a2273745f6d61696c5f72755f6c61726765223b733a373a226d61696c2e7275223b733a31363a2273745f6e6574766f757a5f6c61726765223b733a373a224e6574766f757a223b733a32303a2273745f6d69737465725f776f6e675f6c61726765223b733a373a224d7220576f6e67223b733a31363a2273745f6d6f73686172655f6c61726765223b733a373a226d6f5368617265223b733a31333a2273745f6d6978785f6c61726765223b733a343a224d697878223b733a31383a2273745f6d657373656e6765725f6c61726765223b733a393a224d657373656e676572223b733a31363a2273745f6d656e65616d655f6c61726765223b733a373a224d656e65616d65223b733a32353a2273745f676f6f676c655f7472616e736c6174655f6c61726765223b733a31363a22476f6f676c65205472616e736c617465223b733a32303a2273745f6c6976656a6f75726e616c5f6c61726765223b733a31313a224c6976654a6f75726e616c223b733a31383a2273745f6c696e6b61676f676f5f6c61726765223b733a393a226c696e6b61476f476f223b733a31373a2273745f6b61626f6f646c655f6c61726765223b733a383a224b61626f6f646c65223b733a31373a2273745f6a756d70746167735f6c61726765223b733a383a224a756d7074616773223b733a31393a2273745f696e73746170617065725f6c61726765223b733a31303a22496e7374617061706572223b733a31353a2273745f6964656e74695f6c61726765223b733a393a226964656e74692e6361223b733a31343a2273745f68797665735f6c61726765223b733a353a224879766573223b733a31353a2273745f686174656e615f6c61726765223b733a363a22486174656e61223b733a32323a2273745f676f6f676c655f7265616465725f6c61726765223b733a31333a22476f6f676c6520526561646572223b733a32323a2273745f676f6f676c655f626d61726b735f6c61726765223b733a393a22426f6f6b6d61726b73223b733a31343a2273745f66776973705f6c61726765223b733a353a226677697370223b733a31353a2273745f676f6f676c655f6c61726765223b733a363a22476f6f676c65223b733a31393a2273745f667269656e64666565645f6c61726765223b733a31303a22467269656e6446656564223b733a31333a2273745f66756e705f6c61726765223b733a343a2246756e70223b733a31363a2273745f667265737175695f6c61726765223b733a373a2246726573717569223b733a31383a2273745f7368617265746869735f6c61726765223b733a393a22536861726554686973223b733a31343a2273745f666f6c6b645f6c61726765223b733a393a22666f6c6b642e636f6d223b733a32303a2273745f66617368696f6c697374615f6c61726765223b733a31313a2246617368696f6c69737461223b733a31333a2273745f6661726b5f6c61726765223b733a343a224661726b223b733a31373a2273745f657665726e6f74655f6c61726765223b733a383a22457665726e6f7465223b733a31343a2273745f63617265325f6c61726765223b733a353a224361726532223b733a31353a2273745f65646d6f646f5f6c61726765223b733a363a2245646d6f646f223b733a31343a2273745f647a6f6e655f6c61726765223b733a353a22445a6f6e65223b733a32333a2273745f646f746e657473686f75746f75745f6c61726765223b733a31333a222e6e65742053686f75746f7574223b733a31343a2273745f646969676f5f6c61726765223b733a353a22446969676f223b733a31333a2273745f646967675f6c61726765223b733a343a2244696767223b733a31383a2273745f64656c6963696f75735f6c61726765223b733a393a2244656c6963696f7573223b733a31383a2273745f6465616c73706c75735f6c61726765223b733a31303a224465616c73706c2e7573223b733a31363a2273745f63757272656e745f6c61726765223b733a373a2243757272656e74223b733a31383a2273745f636f726b626f6172645f6c61726765223b733a393a22436f726b626f617264223b733a31353a2273745f636f72616e6b5f6c61726765223b733a363a22636f52616e6b223b733a31373a2273745f636f6e6e6f7465615f6c61726765223b733a383a22436f6e6e6f746561223b733a31383a2273745f63697465756c696b655f6c61726765223b733a393a2243697465554c696b65223b733a31333a2273745f636869715f6c61726765223b733a343a2263686971223b733a32313a2273745f6275735f65786368616e67655f6c61726765223b733a393a2241646420746f204258223b733a31373a2273745f627261696e6966795f6c61726765223b733a383a22427261696e696679223b733a31393a2273745f62756464796d61726b735f6c61726765223b733a31303a2242756464794d61726b73223b733a31393a2273745f676f6f676c65706c75735f6c61726765223b733a383a22476f6f676c65202b223b733a31363a2273745f626c6f676765725f6c61726765223b733a373a22426c6f67676572223b733a31383a2273745f626c6f676d61726b735f6c61726765223b733a393a22426c6f676d61726b73223b733a31333a2273745f626c69705f6c61726765223b733a343a22426c6970223b733a31383a2273745f626c696e6b6c6973745f6c61726765223b733a393a22426c696e6b6c697374223b733a31333a2273745f6265626f5f6c61726765223b733a343a224265626f223b733a31333a2273745f6172746f5f6c61726765223b733a343a224172746f223b733a31343a2273745f62616964755f6c61726765223b733a353a224261696475223b733a32343a2273745f616d617a6f6e5f776973686c6973745f6c61726765223b733a31353a22416d617a6f6e20576973686c697374223b733a31383a2273745f616c6c766f696365735f6c61726765223b733a393a22416c6c766f69636573223b733a31343a2273745f61646674795f6c61726765223b733a353a224164667479223b733a31373a2273745f66616365626f6f6b5f6c61726765223b733a383a2246616365626f6f6b223b733a31363a2273745f747769747465725f6c61726765223b733a353a225477656574223b733a31373a2273745f6c696e6b6564696e5f6c61726765223b733a383a224c696e6b6564496e223b733a31383a2273745f70696e7465726573745f6c61726765223b733a393a2250696e746572657374223b733a31343a2273745f656d61696c5f6c61726765223b733a353a22456d61696c223b733a31363a2273745f6d7973706163655f6c61726765223b733a373a224d795370616365223b733a31323a2273745f6e34675f6c61726765223b733a333a224e3447223b733a31343a2273745f6e756a696a5f6c61726765223b733a353a224e556a696a223b733a32323a2273745f6f646e6f6b6c6173736e696b695f6c61726765223b733a31333a224f646e6f6b6c6173736e696b69223b733a31383a2273745f737065656474696c655f6c61726765223b733a393a22537065656474696c65223b733a31383a2273745f7374756d70656469615f6c61726765223b733a393a225374756d7065646961223b7d),
(85, NULL, 'socialButtons', 0x613a39343a7b733a31393a2273745f666f726d737072696e675f6c61726765223b733a31303a22466f726d737072696e67223b733a31383a2273745f766b6f6e74616b74655f6c61726765223b733a393a22566b6f6e74616b7465223b733a31353a2273745f79616d6d65725f6c61726765223b733a363a2259616d6d6572223b733a31333a2273745f796967675f6c61726765223b733a353a222059696767223b733a31333a2273745f78696e675f6c61726765223b733a343a2258696e67223b733a31383a2273745f766f786f706f6c69735f6c61726765223b733a393a22564f586f706f6c6973223b733a31343a2273745f78657270695f6c61726765223b733a353a225865727069223b733a31343a2273745f78616e67615f6c61726765223b733a353a2258616e6761223b733a31383a2273745f776f726470726573735f6c61726765223b733a393a22576f72645072657373223b733a31353a2273745f7265646469745f6c61726765223b733a363a22526564646974223b733a31353a2273745f6e65746c6f675f6c61726765223b733a363a224e65746c6f67223b733a31333a2273745f766972625f6c61726765223b733a343a2256697262223b733a31353a2273745f76696164656f5f6c61726765223b733a363a2256696164656f223b733a31353a2273745f74756d626c725f6c61726765223b733a363a2254756d626c72223b733a31363a2273745f747970657061645f6c61726765223b733a373a2254797065506164223b733a31393a2273745f746563686e6f726174695f6c61726765223b733a31303a22546563686e6f72617469223b733a32303a2273745f7374756d626c6575706f6e5f6c61726765223b733a31313a225374756d626c6555706f6e223b733a31353a2273745f736f6e69636f5f6c61726765223b733a363a22536f6e69636f223b733a31373a2273745f73746172746c61705f6c61726765223b733a383a2253746172746c6170223b733a31373a2273745f73746172746169645f6c61726765223b733a383a225374617274616964223b733a31373a2273745f736c617368646f745f6c61726765223b733a383a22536c617368646f74223b733a31333a2273745f73696e615f6c61726765223b733a343a2253696e61223b733a31363a2273745f7365676e616c6f5f6c61726765223b733a373a225365676e616c6f223b733a31373a2273745f6e65777376696e655f6c61726765223b733a383a224e65777376696e65223b733a32353a2273745f72616973655f796f75725f766f6963655f6c61726765223b733a31363a22526169736520596f757220566f696365223b733a31343a2273745f6f726b75745f6c61726765223b733a353a224f726b7574223b733a31383a2273745f6f6b6e6f74697a69655f6c61726765223b733a393a224f6b6e6f74697a6965223b733a31363a2273745f6d61696c5f72755f6c61726765223b733a373a226d61696c2e7275223b733a31363a2273745f6e6574766f757a5f6c61726765223b733a373a224e6574766f757a223b733a32303a2273745f6d69737465725f776f6e675f6c61726765223b733a373a224d7220576f6e67223b733a31363a2273745f6d6f73686172655f6c61726765223b733a373a226d6f5368617265223b733a31333a2273745f6d6978785f6c61726765223b733a343a224d697878223b733a31383a2273745f6d657373656e6765725f6c61726765223b733a393a224d657373656e676572223b733a31363a2273745f6d656e65616d655f6c61726765223b733a373a224d656e65616d65223b733a32353a2273745f676f6f676c655f7472616e736c6174655f6c61726765223b733a31363a22476f6f676c65205472616e736c617465223b733a32303a2273745f6c6976656a6f75726e616c5f6c61726765223b733a31313a224c6976654a6f75726e616c223b733a31383a2273745f6c696e6b61676f676f5f6c61726765223b733a393a226c696e6b61476f476f223b733a31373a2273745f6b61626f6f646c655f6c61726765223b733a383a224b61626f6f646c65223b733a31373a2273745f6a756d70746167735f6c61726765223b733a383a224a756d7074616773223b733a31393a2273745f696e73746170617065725f6c61726765223b733a31303a22496e7374617061706572223b733a31353a2273745f6964656e74695f6c61726765223b733a393a226964656e74692e6361223b733a31343a2273745f68797665735f6c61726765223b733a353a224879766573223b733a31353a2273745f686174656e615f6c61726765223b733a363a22486174656e61223b733a32323a2273745f676f6f676c655f7265616465725f6c61726765223b733a31333a22476f6f676c6520526561646572223b733a32323a2273745f676f6f676c655f626d61726b735f6c61726765223b733a393a22426f6f6b6d61726b73223b733a31343a2273745f66776973705f6c61726765223b733a353a226677697370223b733a31353a2273745f676f6f676c655f6c61726765223b733a363a22476f6f676c65223b733a31393a2273745f667269656e64666565645f6c61726765223b733a31303a22467269656e6446656564223b733a31333a2273745f66756e705f6c61726765223b733a343a2246756e70223b733a31363a2273745f667265737175695f6c61726765223b733a373a2246726573717569223b733a31383a2273745f7368617265746869735f6c61726765223b733a393a22536861726554686973223b733a31343a2273745f666f6c6b645f6c61726765223b733a393a22666f6c6b642e636f6d223b733a32303a2273745f66617368696f6c697374615f6c61726765223b733a31313a2246617368696f6c69737461223b733a31333a2273745f6661726b5f6c61726765223b733a343a224661726b223b733a31373a2273745f657665726e6f74655f6c61726765223b733a383a22457665726e6f7465223b733a31343a2273745f63617265325f6c61726765223b733a353a224361726532223b733a31353a2273745f65646d6f646f5f6c61726765223b733a363a2245646d6f646f223b733a31343a2273745f647a6f6e655f6c61726765223b733a353a22445a6f6e65223b733a32333a2273745f646f746e657473686f75746f75745f6c61726765223b733a31333a222e6e65742053686f75746f7574223b733a31343a2273745f646969676f5f6c61726765223b733a353a22446969676f223b733a31333a2273745f646967675f6c61726765223b733a343a2244696767223b733a31383a2273745f64656c6963696f75735f6c61726765223b733a393a2244656c6963696f7573223b733a31383a2273745f6465616c73706c75735f6c61726765223b733a31303a224465616c73706c2e7573223b733a31363a2273745f63757272656e745f6c61726765223b733a373a2243757272656e74223b733a31383a2273745f636f726b626f6172645f6c61726765223b733a393a22436f726b626f617264223b733a31353a2273745f636f72616e6b5f6c61726765223b733a363a22636f52616e6b223b733a31373a2273745f636f6e6e6f7465615f6c61726765223b733a383a22436f6e6e6f746561223b733a31383a2273745f63697465756c696b655f6c61726765223b733a393a2243697465554c696b65223b733a31333a2273745f636869715f6c61726765223b733a343a2263686971223b733a32313a2273745f6275735f65786368616e67655f6c61726765223b733a393a2241646420746f204258223b733a31373a2273745f627261696e6966795f6c61726765223b733a383a22427261696e696679223b733a31393a2273745f62756464796d61726b735f6c61726765223b733a31303a2242756464794d61726b73223b733a31393a2273745f676f6f676c65706c75735f6c61726765223b733a383a22476f6f676c65202b223b733a31363a2273745f626c6f676765725f6c61726765223b733a373a22426c6f67676572223b733a31383a2273745f626c6f676d61726b735f6c61726765223b733a393a22426c6f676d61726b73223b733a31333a2273745f626c69705f6c61726765223b733a343a22426c6970223b733a31383a2273745f626c696e6b6c6973745f6c61726765223b733a393a22426c696e6b6c697374223b733a31333a2273745f6265626f5f6c61726765223b733a343a224265626f223b733a31333a2273745f6172746f5f6c61726765223b733a343a224172746f223b733a31343a2273745f62616964755f6c61726765223b733a353a224261696475223b733a32343a2273745f616d617a6f6e5f776973686c6973745f6c61726765223b733a31353a22416d617a6f6e20576973686c697374223b733a31383a2273745f616c6c766f696365735f6c61726765223b733a393a22416c6c766f69636573223b733a31343a2273745f61646674795f6c61726765223b733a353a224164667479223b733a31373a2273745f66616365626f6f6b5f6c61726765223b733a383a2246616365626f6f6b223b733a31363a2273745f747769747465725f6c61726765223b733a353a225477656574223b733a31373a2273745f6c696e6b6564696e5f6c61726765223b733a383a224c696e6b6564496e223b733a31383a2273745f70696e7465726573745f6c61726765223b733a393a2250696e746572657374223b733a31343a2273745f656d61696c5f6c61726765223b733a353a22456d61696c223b733a31363a2273745f6d7973706163655f6c61726765223b733a373a224d795370616365223b733a31323a2273745f6e34675f6c61726765223b733a333a224e3447223b733a31343a2273745f6e756a696a5f6c61726765223b733a353a224e556a696a223b733a32323a2273745f6f646e6f6b6c6173736e696b695f6c61726765223b733a31333a224f646e6f6b6c6173736e696b69223b733a31383a2273745f737065656474696c655f6c61726765223b733a393a22537065656474696c65223b733a31383a2273745f7374756d70656469615f6c61726765223b733a393a225374756d7065646961223b7d),
(88, NULL, 'mode', 0x733a313a2231223b),
(89, NULL, 'mode', 0x733a313a2231223b),
(90, NULL, 'mode', 0x733a313a2231223b),
(92, NULL, 'mode', 0x733a313a2231223b),
(93, NULL, 'mode', 0x733a313a2231223b),
(95, NULL, 'mode', 0x733a313a2231223b),
(18, NULL, 'mode', 0x733a313a2231223b);

-- --------------------------------------------------------

--
-- Table structure for table `t_module_roles`
--

CREATE TABLE IF NOT EXISTS `t_module_roles` (
`id` int(10) NOT NULL,
  `customrole` int(10) NOT NULL,
  `modulerole` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2080 DEFAULT CHARSET=latin1;

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
(1996, 10, 'wysiwyg.edit'),
(1997, 10, 'login.edit'),
(1998, 10, 'newsletter.edit'),
(1999, 10, 'newsletter.send'),
(2000, 10, 'products.edit'),
(2001, 10, 'products.view'),
(2002, 10, 'roles.register.edit'),
(2003, 10, 'users.edit'),
(2004, 10, 'sitemap.edit'),
(2005, 10, 'modules.insert'),
(2006, 10, 'forum.topic.create'),
(2007, 10, 'forum.thread.create'),
(2008, 10, 'forum.view'),
(2009, 10, 'forum.admin'),
(2010, 10, 'forum.moderator'),
(2011, 10, 'forum.thread.post'),
(2012, 10, 'chat.edit'),
(2013, 10, 'chat.view'),
(2014, 10, 'comment.post'),
(2015, 10, 'comment.edit'),
(2016, 10, 'comment.delete'),
(2017, 10, 'comment.show.email'),
(2018, 10, 'backup.create'),
(2019, 10, 'backup.load'),
(2020, 10, 'backup.delete'),
(2021, 10, 'users.register.edit'),
(2022, 10, 'user.info.edit'),
(2023, 10, 'user.info.admin'),
(2024, 10, 'user.info.owner'),
(2025, 10, 'admin.roles.edit'),
(2026, 10, 'gallery.edit'),
(2027, 10, 'gallery.view'),
(2028, 10, 'gallery.owner'),
(2029, 10, 'message.inbox'),
(2030, 10, 'events.callender'),
(2031, 10, 'events.list'),
(2032, 10, 'events.edit'),
(2033, 10, 'template.edit'),
(2034, 10, 'template.view'),
(2035, 10, 'domains.edit'),
(2036, 10, 'domains.view'),
(2037, 10, 'orders.edit'),
(2038, 10, 'orders.view'),
(2039, 10, 'orders.all'),
(2040, 10, 'orders.confirm'),
(2041, 10, 'orders.finnish'),
(2042, 10, 'dm.tables.config'),
(2043, 10, 'dm.forms.edit'),
(2044, 10, 'shop.basket.view'),
(2045, 10, 'shop.basket.status.edit'),
(2046, 10, 'shop.basket.edit'),
(2047, 10, 'shop.basket.details.view'),
(2048, 10, 'shop.basket.details.edit'),
(2049, 10, 'slideshow.edit'),
(2050, 10, 'filesystem.all'),
(2051, 10, 'filesystem.user'),
(2052, 10, 'filesystem.www'),
(2053, 10, 'filesystem.edit'),
(2054, 10, 'events.users.all'),
(2055, 10, 'menu.edit'),
(2056, 10, 'pages.editmenu'),
(2057, 10, 'pages.edit'),
(2058, 10, 'payment.edit'),
(2059, 10, 'social.edit'),
(2060, 10, 'admin.edit'),
(2061, 10, 'site.edit'),
(2062, 10, 'site.view'),
(2063, 10, 'translations.edit'),
(2064, 10, 'emailList.edit'),
(2065, 10, 'emailSent.edit'),
(2066, 10, 'ukash.edit'),
(2067, 10, 'user.profile.edit'),
(2068, 10, 'user.profile.view'),
(2069, 10, 'user.profile.owner'),
(2070, 10, 'message.edit'),
(2071, 10, 'user.search.edit'),
(2072, 10, 'user.search.view'),
(2073, 10, 'user.friend.edit'),
(2074, 10, 'user.friend.view'),
(2075, 10, 'user.friendRequest.edit'),
(2076, 10, 'user.friendRequest.view'),
(2077, 10, 'user.image.edit'),
(2078, 10, 'user.image.view'),
(2079, 10, 'adminSocialNotifications.edit');

-- --------------------------------------------------------

--
-- Table structure for table `t_newsletter`
--

CREATE TABLE IF NOT EXISTS `t_newsletter` (
`id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `text` blob NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

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
`id` int(10) unsigned NOT NULL,
  `email` varchar(100) NOT NULL,
  `name` varchar(200) NOT NULL,
  `confirmed` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_newsletter_emailgroup`
--

CREATE TABLE IF NOT EXISTS `t_newsletter_emailgroup` (
`emailid` int(10) NOT NULL,
  `roleid` int(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_order`
--

CREATE TABLE IF NOT EXISTS `t_order` (
`id` int(10) NOT NULL,
  `userid` int(10) NOT NULL,
  `distributorid` int(10) DEFAULT NULL,
  `roleid` int(10) NOT NULL,
  `status` int(3) NOT NULL,
  `orderdate` date NOT NULL,
  `objectid` int(10) DEFAULT NULL,
  `orderform` int(10) NOT NULL,
  `rabatt` decimal(10,0) NOT NULL,
  `paymethod` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_order_attribute`
--

CREATE TABLE IF NOT EXISTS `t_order_attribute` (
`id` int(10) NOT NULL,
  `name` blob NOT NULL,
  `value` blob NOT NULL,
  `orderid` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_order_product`
--

CREATE TABLE IF NOT EXISTS `t_order_product` (
`id` int(10) NOT NULL,
  `productid` int(10) NOT NULL,
  `orderid` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_page`
--

CREATE TABLE IF NOT EXISTS `t_page` (
`id` int(10) unsigned NOT NULL,
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
  `modifydate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_page`
--

INSERT INTO `t_page` (`id`, `type`, `namecode`, `welcome`, `title`, `keywords`, `description`, `template`, `siteid`, `code`, `codeid`, `pagetrackerscript`, `modifydate`) VALUES
(1, 0, 1, 0, 'login', 0x6c6f67696e, 0x6c6f67696e, 4, 1, 'login', 1, NULL, '2014-11-22 23:00:31'),
(2, 0, 2, 0, 'adminPages', 0x61646d696e5061676573, 0x61646d696e5061676573, 5, 1, 'adminPages', 5, NULL, '2014-05-12 07:23:20'),
(3, 0, 3, 0, 'startup', 0x73746172747570, 0x73746172747570, 5, 1, 'startup', 7, NULL, '2014-05-12 07:23:21'),
(4, 0, 4, 0, 'adminSites', 0x61646d696e5369746573, 0x61646d696e5369746573, 5, 1, 'adminSites', 8, NULL, '2014-05-12 07:23:26'),
(5, 0, 5, 0, 'adminDomains', 0x61646d696e446f6d61696e73, 0x61646d696e446f6d61696e73, 5, 1, 'adminDomains', 9, NULL, '2014-05-12 07:23:29'),
(6, 0, 6, 0, 'adminPackage', 0x61646d696e5061636b616765, 0x61646d696e5061636b616765, 5, 1, 'adminPackage', 10, NULL, '2014-05-12 07:24:56'),
(7, 0, 7, 0, 'pageConfig', 0x70616765436f6e666967, 0x70616765436f6e666967, 5, 1, 'pageConfig', 11, NULL, '2014-05-13 00:49:09'),
(8, 0, 8, 0, 'Online Dating', 0x4f6e6c696e6520446174696e67, 0x4f6e6c696e6520446174696e67, 4, 1, '', NULL, NULL, '2014-11-22 21:26:43'),
(9, 0, 9, 0, '', '', '', 2, 1, '', NULL, NULL, '2014-05-13 00:49:34'),
(10, 0, 10, 0, '', '', '', 3, 1, '', NULL, NULL, '2014-05-13 00:49:57'),
(11, 0, 11, 0, 'insertModule', 0x696e736572744d6f64756c65, 0x696e736572744d6f64756c65, 5, 1, 'insertModule', 12, NULL, '2014-05-13 00:50:02'),
(12, 0, 12, 0, 'userSearchResult', 0x75736572536561726368526573756c74, 0x75736572536561726368526573756c74, 3, 1, 'userSearchResult', 14, NULL, '2014-05-13 01:57:22'),
(13, 0, 13, 0, '', '', '', 4, 1, '', NULL, NULL, '2014-11-22 23:01:13'),
(14, 0, 14, 0, 'register', 0x7265676973746572, 0x7265676973746572, 5, 1, 'register', 16, NULL, '2014-11-17 04:45:49'),
(15, 0, 15, 0, 'Online Dating', 0x6f6e6c696e6520646174696e67, 0x4f6e6c696e6520646174696e6720757365722070726f66696c65, 2, 1, 'userProfile', 17, NULL, '2014-05-13 02:01:21'),
(16, 0, 16, 0, 'userDetails', 0x7573657244657461696c73, 0x7573657244657461696c73, 2, 1, 'userDetails', 18, NULL, '2014-05-13 02:07:53'),
(17, 0, 17, 0, 'profile', 0x70726f66696c65, 0x70726f66696c65, 5, 1, 'profile', 19, NULL, '2014-05-13 02:08:30'),
(18, 0, 18, 0, 'adminTranslations', 0x61646d696e5472616e736c6174696f6e73, 0x61646d696e5472616e736c6174696f6e73, 5, 1, 'adminTranslations', 23, NULL, '2014-05-13 04:57:16'),
(19, 0, 19, 0, 'userWall', 0x7573657257616c6c, 0x7573657257616c6c, 2, 1, 'userWall', 24, NULL, '2014-05-13 05:15:40'),
(20, 0, 20, 0, 'userGallery', 0x7573657247616c6c657279, 0x7573657247616c6c657279, 3, 1, 'userGallery', 27, NULL, '2014-11-16 11:01:28'),
(21, 0, 21, 0, 'userMessage', 0x757365724d657373616765, 0x757365724d657373616765, 3, 1, 'userMessage', 30, NULL, '2014-05-13 05:38:32'),
(22, 0, 22, 0, 'userFriends', 0x75736572467269656e6473, 0x75736572467269656e6473, 5, 1, 'userFriends', 32, NULL, '2014-05-13 05:39:48'),
(23, 0, 23, 0, 'userAddFriends', 0x75736572416464467269656e6473, 0x75736572416464467269656e6473, 5, 1, 'userAddFriends', 33, NULL, '2014-05-13 05:42:02'),
(24, 0, 24, 0, '', '', '', 5, 1, '', NULL, NULL, '2014-11-07 15:07:21'),
(25, 0, 25, 0, '', '', '', 5, 1, '', NULL, NULL, '2014-06-19 13:05:57'),
(26, 0, 26, 0, '', '', '', 5, 1, '', NULL, NULL, '2014-06-19 14:11:57'),
(27, 0, 27, 0, 'adminTemplates', 0x61646d696e54656d706c61746573, 0x61646d696e54656d706c61746573, 5, 1, 'adminTemplates', 35, NULL, '2014-05-13 06:14:19'),
(28, 0, 28, 0, 'Messages', 0x4d65737361676573, 0x4d65737361676573, 3, 1, '', NULL, NULL, '2014-05-14 00:00:13'),
(29, 0, 29, 0, 'Friends', 0x467269656e6473, 0x467269656e6473, 3, 1, '', NULL, NULL, '2014-05-14 00:01:26'),
(30, 0, 30, 0, 'Login', 0x4c6f67696e, 0x4c6f67696e, 5, 1, '', NULL, NULL, '2014-05-14 00:07:56'),
(31, 0, 31, 0, 'Logout', 0x4c6f676f7574, 0x4c6f676f7574, 4, 1, '', NULL, NULL, '2014-11-23 02:55:08'),
(32, 0, 32, 0, 'adminRoles', 0x61646d696e526f6c6573, 0x61646d696e526f6c6573, 5, 1, 'adminRoles', 40, NULL, '2014-05-14 00:15:34'),
(33, 0, 33, 0, 'unregistered', 0x756e72656769737465726564, 0x756e72656769737465726564, 0, 1, 'unregistered', 41, NULL, '2014-05-14 08:01:40'),
(34, 0, 34, 0, 'userFriend', 0x75736572467269656e64, 0x75736572467269656e64, 3, 1, 'userFriend', 42, NULL, '2014-05-15 01:01:51'),
(35, 0, 35, 0, 'Friend Requests', 0x467269656e64205265717565737473, 0x467269656e64205265717565737473, 3, 1, '', NULL, NULL, '2014-05-15 01:36:54'),
(36, 0, 36, 0, 'Search Users', 0x536561726368205573657273, 0x536561726368205573657273, 3, 1, '', NULL, NULL, '2014-05-17 01:38:35'),
(37, 0, 37, 0, '', '', '', 3, 1, '', NULL, NULL, '2014-05-17 01:38:51'),
(38, 0, 38, 0, '', '', '', 3, 1, '', NULL, NULL, '2014-05-17 01:39:56'),
(39, 0, 39, 0, 'adminSocialNotifications', 0x61646d696e536f6369616c4e6f74696669636174696f6e73, 0x61646d696e536f6369616c4e6f74696669636174696f6e73, 5, 1, 'adminSocialNotifications', 56, NULL, '2014-06-11 06:26:46'),
(40, 0, 40, 0, 'userProfileImage', 0x7573657250726f66696c65496d616765, 0x7573657250726f66696c65496d616765, 3, 1, 'userProfileImage', 57, NULL, '2014-06-13 11:28:23'),
(41, 0, 41, 0, 'Chat', 0x43686174, 0x43686174, 5, 1, '', NULL, NULL, '2014-06-18 06:12:47'),
(42, 0, 42, 0, 'adminNewsletter', 0x61646d696e4e6577736c6574746572, 0x61646d696e4e6577736c6574746572, 5, 1, 'adminNewsletter', 64, NULL, '2014-10-09 06:20:03'),
(43, 0, 43, 0, 'userFriendRequest', 0x75736572467269656e6452657175657374, 0x75736572467269656e6452657175657374, 5, 1, 'userFriendRequest', 65, NULL, '2014-10-16 07:24:59'),
(44, 0, 44, 0, 'Sitemap Online Dating', 0x536974656d6170206f6e6c696e6520646174696e67, 0x53697465206d617020666f72206f6e6c696e65203420646174696e6720746865206f6e6c792066726565206f6e6c696e6520646174696e67206e6574776f726b73, 4, 1, '', NULL, NULL, '2014-11-07 15:14:22'),
(45, 0, 45, 0, 'adminMenus', 0x61646d696e4d656e7573, 0x61646d696e4d656e7573, 5, 1, 'adminMenus', 71, NULL, '2014-11-08 10:37:29'),
(46, 0, 46, 0, 'adminUsers', 0x61646d696e5573657273, 0x61646d696e5573657273, 5, 1, 'adminUsers', 72, NULL, '2014-11-08 16:36:17'),
(50, 0, 50, 0, 'userInfo', 0x75736572496e666f, 0x75736572496e666f, 2, 1, 'userInfo', 90, NULL, '2014-11-23 01:46:55'),
(49, 0, 49, 0, 'userSettings', 0x7573657253657474696e6773, 0x7573657253657474696e6773, 2, 1, 'userSettings', 87, NULL, '2014-11-23 01:26:28'),
(51, 0, 51, 0, 'userProfile''A=0', 0x7573657250726f66696c6527413d30, 0x7573657250726f66696c6527413d30, 5, 1, 'userProfile''A=0', 97, NULL, '2014-11-26 20:30:34'),
(54, 0, 54, 0, 'userProfilea'' -- a', 0x7573657250726f66696c656127202d2d2061, 0x7573657250726f66696c656127202d2d2061, 0, 2, 'userProfilea'' -- a', 99, NULL, '2014-11-27 22:33:35'),
(53, 0, 53, 0, 'userProfilea', 0x7573657250726f66696c6561, 0x7573657250726f66696c6561, 0, 2, 'userProfilea', 98, NULL, '2014-11-27 22:33:30'),
(55, 0, 55, 0, 'userProfile'' or 1=1 --', 0x7573657250726f66696c6527206f7220313d31202d2d, 0x7573657250726f66696c6527206f7220313d31202d2d, 0, 2, 'userProfile'' or 1=1 --', 100, NULL, '2014-11-27 22:33:53');

-- --------------------------------------------------------

--
-- Table structure for table `t_page_roles`
--

CREATE TABLE IF NOT EXISTS `t_page_roles` (
`id` int(10) NOT NULL,
  `roleid` int(10) NOT NULL,
  `pageid` int(10) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=384 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_page_roles`
--

INSERT INTO `t_page_roles` (`id`, `roleid`, `pageid`) VALUES
(325, 7, 48),
(319, 13, 1),
(318, 10, 1),
(317, 9, 1),
(316, 7, 1),
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
(305, 13, 9),
(304, 10, 9),
(303, 9, 9),
(302, 8, 9),
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
(324, 13, 13),
(323, 10, 13),
(322, 9, 13),
(321, 8, 13),
(320, 7, 13),
(65, 7, 14),
(66, 8, 14),
(67, 9, 14),
(68, 10, 14),
(69, 13, 14),
(301, 13, 15),
(300, 10, 15),
(299, 9, 15),
(298, 8, 15),
(297, 7, 15),
(354, 13, 16),
(353, 10, 16),
(352, 9, 16),
(351, 8, 16),
(350, 7, 16),
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
(310, 13, 19),
(309, 10, 19),
(308, 9, 19),
(307, 8, 19),
(306, 7, 19),
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
(291, 10, 30),
(290, 7, 30),
(358, 13, 31),
(357, 10, 31),
(356, 9, 31),
(355, 8, 31),
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
(262, 13, 41),
(268, 7, 42),
(269, 8, 42),
(270, 9, 42),
(271, 10, 42),
(272, 13, 42),
(273, 7, 43),
(274, 8, 43),
(275, 9, 43),
(276, 10, 43),
(277, 13, 43),
(278, 7, 44),
(279, 8, 44),
(280, 9, 44),
(281, 10, 44),
(282, 13, 44),
(283, 7, 45),
(284, 8, 45),
(285, 9, 45),
(286, 10, 45),
(287, 13, 45),
(292, 7, 46),
(293, 8, 46),
(294, 9, 46),
(295, 10, 46),
(296, 13, 46),
(311, 7, 47),
(312, 8, 47),
(313, 9, 47),
(314, 10, 47),
(315, 13, 47),
(326, 8, 48),
(327, 9, 48),
(328, 10, 48),
(329, 13, 48),
(339, 13, 49),
(338, 10, 49),
(337, 9, 49),
(336, 8, 49),
(335, 7, 49),
(349, 13, 50),
(348, 10, 50),
(347, 9, 50),
(346, 8, 50),
(345, 7, 50),
(359, 7, 51),
(360, 8, 51),
(361, 9, 51),
(362, 10, 51),
(363, 13, 51),
(364, 7, 52),
(365, 8, 52),
(366, 9, 52),
(367, 10, 52),
(368, 13, 52),
(369, 7, 53),
(370, 8, 53),
(371, 9, 53),
(372, 10, 53),
(373, 13, 53),
(374, 7, 54),
(375, 8, 54),
(376, 9, 54),
(377, 10, 54),
(378, 13, 54),
(379, 7, 55),
(380, 8, 55),
(381, 9, 55),
(382, 10, 55),
(383, 13, 55);

-- --------------------------------------------------------

--
-- Table structure for table `t_product`
--

CREATE TABLE IF NOT EXISTS `t_product` (
`id` int(10) NOT NULL,
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
  `minimum` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_product_group`
--

CREATE TABLE IF NOT EXISTS `t_product_group` (
`id` int(10) NOT NULL,
  `namecode` int(10) NOT NULL,
  `parent` int(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci;

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
`id` int(10) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `userid` int(10) NOT NULL,
  `roleid` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_roles_custom`
--

CREATE TABLE IF NOT EXISTS `t_roles_custom` (
`id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `system` int(1) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

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
`id` int(10) NOT NULL,
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
  `twittersecret` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_site_module`
--

CREATE TABLE IF NOT EXISTS `t_site_module` (
`id` int(10) NOT NULL,
  `siteid` int(10) NOT NULL,
  `moduleid` varchar(10) COLLATE latin1_german2_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_site_template`
--

CREATE TABLE IF NOT EXISTS `t_site_template` (
`id` int(10) NOT NULL,
  `siteid` int(10) NOT NULL,
  `templateid` int(10) NOT NULL,
  `main` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci;

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
`id` int(11) NOT NULL,
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
  `message_received_title` blob NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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
`id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `template` varchar(100) NOT NULL,
  `interface` varchar(100) NOT NULL,
  `html` blob,
  `css` blob,
  `js` blob,
  `main` tinyint(1) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_template`
--

INSERT INTO `t_template` (`id`, `name`, `template`, `interface`, `html`, `css`, `js`, `main`) VALUES
(2, 'Docpanel Demo Template', '', '', 0x3c64697620636c6173733d226672616d65446976223e0d0a202020203c64697620636c6173733d22746f704d656e75446976223e0d0a20202020202020203c64697620636c6173733d22746f704d656e754d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e6d656e752e746f704d656e7520636d733f2667743b0d0a2020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22686561646572446976223e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d226865616465724d656e75446976223e0d0a20202020202020203c64697620636c6173733d226865616465724d656e754d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e6d656e752e6865616465724d656e7520636d733f2667743b0d0a2020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22626f64795269676874446976223e0d0a20202020202020203c64697620636c6173733d22666c6f6174436f6e7461696e6572446976223e0d0a2020202020202020202020203c64697620636c6173733d22626f647952696768744d617267696e446976223e0d0a20202020202020202020202020202020266c743b3f636d732074656d706c6174652e617265612e726967687420636d733f2667743b0d0a202020202020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a2020202020202020202020203c2f6469763e0d0a20202020202020203c2f6469763e0d0a20202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22626f64794c656674446976223e0d0a20202020202020203c64697620636c6173733d22666c6f6174436f6e7461696e6572446976223e0d0a2020202020202020202020203c64697620636c6173733d22626f64794c6566744d617267696e446976223e0d0a20202020202020202020202020202020266c743b3f636d732074656d706c6174652e617265612e6c65667420636d733f2667743b0d0a202020202020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a2020202020202020202020203c2f6469763e0d0a20202020202020203c2f6469763e0d0a20202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22626f647944697620626f64794469764c6566744d617267696e20626f647944697652696768744d617267696e223e0d0a20202020202020203c64697620636c6173733d22666c6f6174436f6e7461696e6572446976223e0d0a2020202020202020202020203c64697620636c6173733d22626f64794d617267696e446976223e0d0a20202020202020202020202020202020266c743b3f636d732074656d706c6174652e6d61696e2e63656e74657220636d733f2667743b0d0a202020202020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a2020202020202020202020203c2f6469763e0d0a20202020202020203c2f6469763e0d0a20202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22666f6f7465724d656e75446976223e0d0a20202020202020203c64697620636c6173733d22666f6f7465724d656e754d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e6d656e752e666f6f7465724d656e7520636d733f2667743b0d0a2020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a3c2f6469763e, 0x626f6479207b0d0a2020202070616464696e673a3070783b0d0a202020206d617267696e3a3070783b0d0a7d202020200d0a2e6672616d65446976207b0d0a202020206d696e2d77696474683a2037303070783b0d0a202020206d617267696e3a2030707820313070782030707820313070783b0d0a7d0d0a2e746f704d656e75446976207b0d0a202020206d617267696e3a2030707820313070782030707820313070783b0d0a7d0d0a2e746f704d656e754d617267696e446976207b0d0a20202020666c6f61743a2072696768743b0d0a7d0d0a2e686561646572446976207b0d0a20202020636c6561723a20626f74683b0d0a202020206865696768743a2031303070783b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e6865616465724d656e75446976207b0d0a202020206d696e2d6865696768743a20333070783b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c282767726164536d616c6c2e6769662729207768697465207265706561742d783b0d0a7d0d0a2e6865616465724d656e754d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e626f6479446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f64794d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e626f64794469764c6566744d617267696e207b0d0a202020206d617267696e2d6c6566743a2032313070783b0d0a7d0d0a2e626f647944697652696768744d617267696e207b0d0a202020206d617267696e2d72696768743a2032313070783b0d0a7d0d0a2e626f64795269676874446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a2020202077696474683a2032303070783b0d0a20202020666c6f61743a2072696768743b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f647952696768744d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e626f64794c656674446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a2020202077696474683a2032303070783b0d0a20202020666c6f61743a206c6566743b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f64794c6566744d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e666f6f7465724d656e75446976207b0d0a20202020636c6561723a20626f74683b0d0a202020206d696e2d6865696768743a20333070783b0d0a202020206d617267696e3a2031307078203070782031307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c282767726164536d616c6c2e6769662729207768697465207265706561742d783b0d0a7d0d0a2e666f6f7465724d656e754d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e666c6f6174436f6e7461696e6572446976207b0d0a20202020666c6f61743a6c6566743b0d0a2020202077696474683a313030253b0d0a7d, '', 0),
(3, 'Docpanel Left Demo Template', '', '', 0x3c64697620636c6173733d226672616d65446976223e0d0a202020203c64697620636c6173733d22746f704d656e75446976223e0d0a20202020202020203c64697620636c6173733d22746f704d656e754d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e6d656e752e746f704d656e7520636d733f2667743b0d0a2020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22686561646572446976223e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d226865616465724d656e75446976223e0d0a20202020202020203c64697620636c6173733d226865616465724d656e754d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e6d656e752e6865616465724d656e7520636d733f2667743b0d0a2020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22626f64794c656674446976223e0d0a20202020202020203c64697620636c6173733d22666c6f6174436f6e7461696e6572446976223e0d0a2020202020202020202020203c64697620636c6173733d22626f64794c6566744d617267696e446976223e0d0a20202020202020202020202020202020266c743b3f636d732074656d706c6174652e617265612e6c65667420636d733f2667743b0d0a202020202020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a2020202020202020202020203c2f6469763e0d0a20202020202020203c2f6469763e0d0a20202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22626f647944697620626f64794469764c6566744d617267696e223e0d0a20202020202020203c64697620636c6173733d22666c6f6174436f6e7461696e6572446976223e0d0a2020202020202020202020203c64697620636c6173733d22626f64794d617267696e446976223e0d0a20202020202020202020202020202020266c743b3f636d732074656d706c6174652e6d61696e2e63656e74657220636d733f2667743b0d0a202020202020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a2020202020202020202020203c2f6469763e0d0a20202020202020203c2f6469763e0d0a20202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22666f6f7465724d656e75446976223e0d0a20202020202020203c64697620636c6173733d22666f6f7465724d656e754d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e6d656e752e666f6f7465724d656e7520636d733f2667743b0d0a2020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a3c2f6469763e, 0x626f6479207b0d0a2020202070616464696e673a3070783b0d0a202020206d617267696e3a3070783b0d0a7d202020200d0a2e6672616d65446976207b0d0a202020206d696e2d77696474683a2037303070783b0d0a202020206d617267696e3a2030707820313070782030707820313070783b0d0a7d0d0a2e746f704d656e75446976207b0d0a202020206d617267696e3a2030707820313070782030707820313070783b0d0a7d0d0a2e746f704d656e754d617267696e446976207b0d0a20202020666c6f61743a2072696768743b0d0a7d0d0a2e686561646572446976207b0d0a20202020636c6561723a20626f74683b0d0a202020206865696768743a2031303070783b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e6865616465724d656e75446976207b0d0a202020206d696e2d6865696768743a20333070783b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c282767726164536d616c6c2e6769662729207768697465207265706561742d783b0d0a7d0d0a2e6865616465724d656e754d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e626f6479446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f64794d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e626f64794469764c6566744d617267696e207b0d0a202020206d617267696e2d6c6566743a2032303670783b0d0a7d0d0a2e626f647944697652696768744d617267696e207b0d0a202020206d617267696e2d72696768743a2032313070783b0d0a7d0d0a2e626f64795269676874446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a2020202077696474683a2032303070783b0d0a20202020666c6f61743a2072696768743b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f647952696768744d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e626f64794c656674446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a2020202077696474683a2031393470783b0d0a20202020666c6f61743a206c6566743b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f64794c6566744d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e666f6f7465724d656e75446976207b0d0a20202020636c6561723a20626f74683b0d0a202020206d696e2d6865696768743a20333070783b0d0a202020206d617267696e3a2031307078203070782031307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c282767726164536d616c6c2e6769662729207768697465207265706561742d783b0d0a7d0d0a2e666f6f7465724d656e754d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e666c6f6174436f6e7461696e6572446976207b0d0a20202020666c6f61743a6c6566743b0d0a2020202077696474683a313030253b0d0a7d, '', 0),
(4, 'Docpanel Right Demo Template', '', '', 0x3c64697620636c6173733d226672616d65446976223e0d0a202020203c64697620636c6173733d22746f704d656e75446976223e0d0a20202020202020203c64697620636c6173733d22746f704d656e754d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e6d656e752e746f704d656e7520636d733f2667743b0d0a2020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22686561646572446976223e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d226865616465724d656e75446976223e0d0a20202020202020203c64697620636c6173733d226865616465724d656e754d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e6d656e752e6865616465724d656e7520636d733f2667743b0d0a2020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22626f64795269676874446976223e0d0a20202020202020203c64697620636c6173733d22666c6f6174436f6e7461696e6572446976223e0d0a2020202020202020202020203c64697620636c6173733d22626f647952696768744d617267696e446976223e0d0a20202020202020202020202020202020266c743b3f636d732074656d706c6174652e617265612e726967687420636d733f2667743b0d0a202020202020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a2020202020202020202020203c2f6469763e0d0a20202020202020203c2f6469763e0d0a20202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22626f647944697620626f647944697652696768744d617267696e223e0d0a20202020202020203c64697620636c6173733d22666c6f6174436f6e7461696e6572446976223e0d0a2020202020202020202020203c64697620636c6173733d22626f64794d617267696e446976223e0d0a20202020202020202020202020202020266c743b3f636d732074656d706c6174652e6d61696e2e63656e74657220636d733f2667743b0d0a202020202020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a2020202020202020202020203c2f6469763e0d0a20202020202020203c2f6469763e0d0a20202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22666f6f7465724d656e75446976223e0d0a20202020202020203c64697620636c6173733d22666f6f7465724d656e754d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e6d656e752e666f6f7465724d656e7520636d733f2667743b0d0a2020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a3c2f6469763e, 0x626f6479207b0d0a2020202070616464696e673a3070783b0d0a202020206d617267696e3a3070783b0d0a7d202020200d0a2e6672616d65446976207b0d0a202020206d696e2d77696474683a2037303070783b0d0a202020206d617267696e3a2030707820313070782030707820313070783b0d0a7d0d0a2e746f704d656e75446976207b0d0a202020206d617267696e3a2030707820313070782030707820313070783b0d0a7d0d0a2e746f704d656e754d617267696e446976207b0d0a20202020666c6f61743a2072696768743b0d0a7d0d0a2e686561646572446976207b0d0a20202020636c6561723a20626f74683b0d0a202020206865696768743a2031303070783b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e6865616465724d656e75446976207b0d0a202020206d696e2d6865696768743a20333070783b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c282767726164536d616c6c2e6769662729207768697465207265706561742d783b0d0a7d0d0a2e6865616465724d656e754d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e626f6479446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f64794d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e626f64794469764c6566744d617267696e207b0d0a202020206d617267696e2d6c6566743a2032313070783b0d0a7d0d0a2e626f647944697652696768744d617267696e207b0d0a202020206d617267696e2d72696768743a2033373570783b0d0a7d0d0a2e626f64795269676874446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a2020202077696474683a2033363570783b0d0a20202020666c6f61743a2072696768743b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f647952696768744d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e626f64794c656674446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a2020202077696474683a2032303070783b0d0a20202020666c6f61743a206c6566743b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f64794c6566744d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e666f6f7465724d656e75446976207b0d0a20202020636c6561723a20626f74683b0d0a202020206d696e2d6865696768743a20333070783b0d0a202020206d617267696e3a2031307078203070782031307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c282767726164536d616c6c2e6769662729207768697465207265706561742d783b0d0a7d0d0a2e666f6f7465724d656e754d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e666c6f6174436f6e7461696e6572446976207b0d0a20202020666c6f61743a6c6566743b0d0a2020202077696474683a313030253b0d0a7d, '', 0),
(5, 'Docpanel Stack Demo Template', '', '', 0x3c64697620636c6173733d226672616d65446976223e0d0a202020203c64697620636c6173733d22746f704d656e75446976223e0d0a20202020202020203c64697620636c6173733d22746f704d656e754d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e6d656e752e746f704d656e7520636d733f2667743b0d0a2020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22686561646572446976223e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d226865616465724d656e75446976223e0d0a20202020202020203c64697620636c6173733d226865616465724d656e754d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e6d656e752e6865616465724d656e7520636d733f2667743b0d0a2020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22626f6479446976223e0d0a20202020202020203c64697620636c6173733d22666c6f6174436f6e7461696e6572446976223e0d0a2020202020202020202020203c64697620636c6173733d22626f64794d617267696e446976223e0d0a20202020202020202020202020202020266c743b3f636d732074656d706c6174652e6d61696e2e63656e74657220636d733f2667743b3c64697620636c6173733d22636c656172223e3c2f6469763e0d0a2020202020202020202020203c2f6469763e0d0a20202020202020203c2f6469763e0d0a20202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a202020203c2f6469763e0d0a202020203c64697620636c6173733d22666f6f7465724d656e75446976223e0d0a20202020202020203c64697620636c6173733d22666f6f7465724d656e754d617267696e446976223e0d0a202020202020202020202020266c743b3f636d732074656d706c6174652e6d656e752e666f6f7465724d656e7520636d733f2667743b0d0a2020202020202020202020203c64697620636c6173733d22636c656172223e3c2f6469763e0d0a20202020202020203c2f6469763e0d0a202020203c2f6469763e0d0a3c2f6469763e, 0x626f6479207b0d0a2020202070616464696e673a3070783b0d0a202020206d617267696e3a3070783b0d0a7d202020200d0a2e6672616d65446976207b0d0a202020206d696e2d77696474683a2037303070783b0d0a202020206d617267696e3a2030707820313070782030707820313070783b0d0a7d0d0a2e746f704d656e75446976207b0d0a202020206d617267696e3a2030707820313070782030707820313070783b0d0a7d0d0a2e746f704d656e754d617267696e446976207b0d0a20202020666c6f61743a2072696768743b0d0a7d0d0a2e686561646572446976207b0d0a20202020636c6561723a20626f74683b0d0a202020206865696768743a2031303070783b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e6865616465724d656e75446976207b0d0a202020206d696e2d6865696768743a20333070783b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c282767726164536d616c6c2e6769662729207768697465207265706561742d783b0d0a7d0d0a2e6865616465724d656e754d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e626f6479446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f64794d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e626f64794469764c6566744d617267696e207b0d0a202020206d617267696e2d6c6566743a2032313070783b0d0a7d0d0a2e626f647944697652696768744d617267696e207b0d0a202020206d617267696e2d72696768743a2032313070783b0d0a7d0d0a2e626f64795269676874446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a2020202077696474683a2032303070783b0d0a20202020666c6f61743a2072696768743b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f647952696768744d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e626f64794c656674446976207b0d0a202020206d696e2d6865696768743a2032303070783b0d0a2020202077696474683a2032303070783b0d0a20202020666c6f61743a206c6566743b0d0a202020206d617267696e3a20313070782030707820307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c2827677261644269672e6769662729207768697465207265706561742d783b0d0a7d0d0a2e626f64794c6566744d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e666f6f7465724d656e75446976207b0d0a20202020636c6561723a20626f74683b0d0a202020206d696e2d6865696768743a20333070783b0d0a202020206d617267696e3a2031307078203070782031307078203070783b0d0a20202020626f726465723a20317078206461736865642073696c7665723b0d0a202020206261636b67726f756e643a2075726c282767726164536d616c6c2e6769662729207768697465207265706561742d783b0d0a7d0d0a2e666f6f7465724d656e754d617267696e446976207b0d0a202020206d617267696e3a313070783b0d0a7d0d0a2e666c6f6174436f6e7461696e6572446976207b0d0a20202020666c6f61743a6c6566743b0d0a2020202077696474683a313030253b0d0a7d, '', 1),
(1, 'Admin Template', 'core/template/adminTemplate.php', 'AdminTemplate', NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `t_templatearea`
--

CREATE TABLE IF NOT EXISTS `t_templatearea` (
`id` int(10) NOT NULL,
  `instanceid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `pageid` int(10) NOT NULL,
  `position` int(10) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=101 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_templatearea`
--

INSERT INTO `t_templatearea` (`id`, `instanceid`, `name`, `pageid`, `position`) VALUES
(1, 1, 'right', 1, 0),
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
(15, 15, 'right', 13, 0),
(16, 16, 'center', 14, 1),
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
(39, 39, 'right', 31, 0),
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
(62, 62, 'center', 26, 0),
(63, 63, 'center', 8, 2),
(64, 64, 'center', 42, 0),
(65, 65, 'center', 43, 0),
(66, 66, 'center', 44, 0),
(67, 67, 'center', 44, 1),
(69, 69, 'center', 24, 0),
(70, 70, 'center', 44, 2),
(71, 71, 'center', 45, 0),
(72, 72, 'center', 46, 0),
(74, 74, 'center', 14, 0),
(75, 75, 'right', 9, 0),
(76, 76, 'right', 15, 0),
(77, 77, 'right', 19, 0),
(78, 78, 'center', 47, 0),
(79, 79, 'center', 1, 0),
(80, 80, 'center', 1, 1),
(81, 81, 'center', 1, 2),
(82, 82, 'center', 8, 3),
(83, 83, 'center', 13, 0),
(84, 84, 'center', 13, 1),
(85, 85, 'center', 13, 2),
(86, 86, 'center', 48, 0),
(87, 87, 'center', 49, 0),
(88, 88, 'left', 49, 0),
(89, 89, 'right', 49, 0),
(90, 90, 'center', 50, 0),
(92, 92, 'left', 50, 0),
(93, 93, 'right', 50, 0),
(95, 95, 'right', 16, 0),
(96, 96, 'center', 31, 0),
(97, 97, 'center', 51, 0),
(98, 98, '', 53, 0),
(99, 99, '', 54, 0),
(100, 100, '', 55, 0);

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
`id` int(10) NOT NULL,
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
  `relationship` int(4) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_user_address`
--

CREATE TABLE IF NOT EXISTS `t_user_address` (
`id` int(11) NOT NULL,
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
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `t_user_friend`
--

CREATE TABLE IF NOT EXISTS `t_user_friend` (
`id` int(11) NOT NULL,
  `srcuserid` int(11) NOT NULL,
  `dstuserid` int(11) NOT NULL,
  `confirmed` tinyint(1) NOT NULL,
  `createdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `t_user_message`
--

CREATE TABLE IF NOT EXISTS `t_user_message` (
`id` int(10) NOT NULL,
  `srcuser` int(10) NOT NULL,
  `dstuser` int(10) NOT NULL,
  `subject` varchar(100) CHARACTER SET latin1 NOT NULL,
  `message` blob NOT NULL,
  `senddate` date NOT NULL,
  `opened` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `t_user_wall_event`
--

CREATE TABLE IF NOT EXISTS `t_user_wall_event` (
`id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `typeid` int(11) DEFAULT NULL,
  `userid` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_user_wall_post`
--

CREATE TABLE IF NOT EXISTS `t_user_wall_post` (
`id` int(11) NOT NULL,
  `srcuserid` int(11) NOT NULL,
  `comment` blob NOT NULL,
  `eventid` int(11) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `t_vdb_column`
--

CREATE TABLE IF NOT EXISTS `t_vdb_column` (
`id` int(10) NOT NULL,
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
  `maxlength` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;

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
`id` int(10) NOT NULL,
  `tableid` int(10) NOT NULL,
  `viewed` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_vdb_table`
--

CREATE TABLE IF NOT EXISTS `t_vdb_table` (
  `physical` int(1) NOT NULL,
  `system` int(1) NOT NULL,
`id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

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
  `value` blob NOT NULL
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

--
-- Dumping data for table `t_wysiwygpage`
--

INSERT INTO `t_wysiwygpage` (`id`, `moduleid`, `lang`, `content`, `title`, `area`) VALUES
(NULL, 20, 'en', 0x3c68313e4f6e6c696e6520446174696e673c2f68313e0d0a3c703e57656c636f6d6520746f206d79206f6e6c696e6520646174696e672e204f6e65206f66207468652066657720746f74616c6c792066726565206f6e6c696e6520646174696e67206e6574776f726b732e3c2f703e0d0a3c68333e4d79204f6e6c696e6520446174696e673c2f68333e0d0a3c703e4d79206f6e6c696e6520646174696e67206973206f6e65206f6620746865206f6e6c792066726565206f6e6c696e65203c61207469746c653d226f6e6c696e6520646174696e672220687265663d22687474703a2f2f656e2e77696b6970656469612e6f72672f77696b692f436f6d70617269736f6e5f6f665f6f6e6c696e655f646174696e675f7765627369746573223e646174696e67206e6574776f726b733c2f613e2e205265676973746572206e6f7720616e6420656e6a6f792066726565206f6e6c696e6520646174696e672e205768656e20492020207761732073696e676c65204920736561726368656420666f72206f6e6c696e6520646174696e672077656220736974657320616e64206576656e20706179656420746f20757365206f6e652e204920736f6f6e206e6f746963656420636f6d6d65726369616c206f6e6c696e6520646174696e672077656220736974657320617265206f6674656e207363616d7320776974682066616b652075736572732e20546865792077657265206a757374206166746572206d79206d6f6e65792e20536f2049206465636964656420746f206d616b65206d79206f776e2066726565206f6e6c696e6520646174696e672077656220736974652e20536f20686572652069742069732e20506c65617365207265676973746572206e6f7720736f207468617420776520676574206173206d616e7920757365727320617320706f737369626c652e3c2f703e0d0a3c68333e46726565204f6e6c696e6520446174696e673c2f68333e0d0a3c703e492077696c6c206b656570206f6e6c696e6534646174696e672e6e657420636f737420667265652e20496e2072657475726e20666f72206d79206566666f727420746f2070726f7669646520612066726565206f6e6c696e6520646174696e67206e6574776f726b2c204920776f756c64206265207665727920686170707920696620796f75206a757374207265636f6d6d656e642074686973206f6e6c696e6520646174696e67206e6574776f726b20746f20616c6c206f6620796f757220667269656e64732e20596f752063616e20757365206f70656e20696473206c696b65203c61207469746c653d22736f6369616c206e6574776f726b2220687265663d22687474703a2f2f7777772e66616365626f6f6b2e636f6d223e66616365626f6f6b3c2f613e206f72203c6120687265663d22687474703a2f2f676f6f676c652e636f6d223e676f6f676c653c2f613e20746f206c6f67696e2c20736f20796f7520646f6e2774206576656e206861766520746f2072656d656d62657220612070617373776f72642e20526567697374726174696f6e20697320717569636b20616e6420656173792c2074686f75207765207374696c6c207265717569726520736f6d6520696e666f726d6174696f6e206c696b6520796f757220616464726573732e205468697320696e666f726d6174696f6e206973207573656420627920746865207365617263682c20736f207468617420697420697320706f737369626c6520746f20646973706c61792070656f706c652077686f2061726520696e746572657374656420696e20646174696e6720796f7520616e64206c697665206e6561722062792e3c2f703e, NULL, 0),
(NULL, 21, 'en', 0x3c696d6720616c743d22746f6e67756522207469746c653d22746f6e67756522207372633d22687474703a2f2f6c6f63616c686f73742f76626d73636d732f7265736f757263652f6a732f656c7274652f696d616765732f736d696c6579732f746f6e6775652e706e6722202f3e, NULL, 0),
(NULL, 20, 'en', 0x3c68313e4f6e6c696e6520446174696e673c2f68313e0d0a3c703e57656c636f6d6520746f206d79206f6e6c696e6520646174696e672e204f6e65206f66207468652066657720746f74616c6c792066726565206f6e6c696e6520646174696e67206e6574776f726b732e3c2f703e0d0a3c68333e4d79204f6e6c696e6520446174696e673c2f68333e0d0a3c703e4d79206f6e6c696e6520646174696e67206973206f6e65206f6620746865206f6e6c792066726565206f6e6c696e65203c61207469746c653d226f6e6c696e6520646174696e672220687265663d22687474703a2f2f656e2e77696b6970656469612e6f72672f77696b692f436f6d70617269736f6e5f6f665f6f6e6c696e655f646174696e675f7765627369746573223e646174696e67206e6574776f726b733c2f613e2e205265676973746572206e6f7720616e6420656e6a6f792066726565206f6e6c696e6520646174696e672e205768656e20492020207761732073696e676c65204920736561726368656420666f72206f6e6c696e6520646174696e672077656220736974657320616e64206576656e20706179656420746f20757365206f6e652e204920736f6f6e206e6f746963656420636f6d6d65726369616c206f6e6c696e6520646174696e672077656220736974657320617265206f6674656e207363616d7320776974682066616b652075736572732e20546865792077657265206a757374206166746572206d79206d6f6e65792e20536f2049206465636964656420746f206d616b65206d79206f776e2066726565206f6e6c696e6520646174696e672077656220736974652e20536f20686572652069742069732e20506c65617365207265676973746572206e6f7720736f207468617420776520676574206173206d616e7920757365727320617320706f737369626c652e3c2f703e0d0a3c68333e46726565204f6e6c696e6520446174696e673c2f68333e0d0a3c703e492077696c6c206b656570206f6e6c696e6534646174696e672e6e657420636f737420667265652e20496e2072657475726e20666f72206d79206566666f727420746f2070726f7669646520612066726565206f6e6c696e6520646174696e67206e6574776f726b2c204920776f756c64206265207665727920686170707920696620796f75206a757374207265636f6d6d656e642074686973206f6e6c696e6520646174696e67206e6574776f726b20746f20616c6c206f6620796f757220667269656e64732e20596f752063616e20757365206f70656e20696473206c696b65203c61207469746c653d22736f6369616c206e6574776f726b2220687265663d22687474703a2f2f7777772e66616365626f6f6b2e636f6d223e66616365626f6f6b3c2f613e206f72203c6120687265663d22687474703a2f2f676f6f676c652e636f6d223e676f6f676c653c2f613e20746f206c6f67696e2c20736f20796f7520646f6e2774206576656e206861766520746f2072656d656d62657220612070617373776f72642e20526567697374726174696f6e20697320717569636b20616e6420656173792c2074686f75207765207374696c6c207265717569726520736f6d6520696e666f726d6174696f6e206c696b6520796f757220616464726573732e205468697320696e666f726d6174696f6e206973207573656420627920746865207365617263682c20736f207468617420697420697320706f737369626c6520746f20646973706c61792070656f706c652077686f2061726520696e746572657374656420696e20646174696e6720796f7520616e64206c697665206e6561722062792e3c2f703e, NULL, 0),
(NULL, 21, 'en', 0x3c696d6720616c743d22746f6e67756522207469746c653d22746f6e67756522207372633d22687474703a2f2f6c6f63616c686f73742f76626d73636d732f7265736f757263652f6a732f656c7274652f696d616765732f736d696c6579732f746f6e6775652e706e6722202f3e, NULL, 0),
(NULL, 20, 'en', 0x3c68313e4f6e6c696e6520446174696e673c2f68313e0d0a3c703e57656c636f6d6520746f206d79206f6e6c696e6520646174696e672e204f6e65206f66207468652066657720746f74616c6c792066726565206f6e6c696e6520646174696e67206e6574776f726b732e3c2f703e0d0a3c68333e4d79204f6e6c696e6520446174696e673c2f68333e0d0a3c703e4d79206f6e6c696e6520646174696e67206973206f6e65206f6620746865206f6e6c792066726565206f6e6c696e65203c61207469746c653d226f6e6c696e6520646174696e672220687265663d22687474703a2f2f656e2e77696b6970656469612e6f72672f77696b692f436f6d70617269736f6e5f6f665f6f6e6c696e655f646174696e675f7765627369746573223e646174696e67206e6574776f726b733c2f613e2e205265676973746572206e6f7720616e6420656e6a6f792066726565206f6e6c696e6520646174696e672e205768656e20492020207761732073696e676c65204920736561726368656420666f72206f6e6c696e6520646174696e672077656220736974657320616e64206576656e20706179656420746f20757365206f6e652e204920736f6f6e206e6f746963656420636f6d6d65726369616c206f6e6c696e6520646174696e672077656220736974657320617265206f6674656e207363616d7320776974682066616b652075736572732e20546865792077657265206a757374206166746572206d79206d6f6e65792e20536f2049206465636964656420746f206d616b65206d79206f776e2066726565206f6e6c696e6520646174696e672077656220736974652e20536f20686572652069742069732e20506c65617365207265676973746572206e6f7720736f207468617420776520676574206173206d616e7920757365727320617320706f737369626c652e3c2f703e0d0a3c68333e46726565204f6e6c696e6520446174696e673c2f68333e0d0a3c703e492077696c6c206b656570206f6e6c696e6534646174696e672e6e657420636f737420667265652e20496e2072657475726e20666f72206d79206566666f727420746f2070726f7669646520612066726565206f6e6c696e6520646174696e67206e6574776f726b2c204920776f756c64206265207665727920686170707920696620796f75206a757374207265636f6d6d656e642074686973206f6e6c696e6520646174696e67206e6574776f726b20746f20616c6c206f6620796f757220667269656e64732e20596f752063616e20757365206f70656e20696473206c696b65203c61207469746c653d22736f6369616c206e6574776f726b2220687265663d22687474703a2f2f7777772e66616365626f6f6b2e636f6d223e66616365626f6f6b3c2f613e206f72203c6120687265663d22687474703a2f2f676f6f676c652e636f6d223e676f6f676c653c2f613e20746f206c6f67696e2c20736f20796f7520646f6e2774206576656e206861766520746f2072656d656d62657220612070617373776f72642e20526567697374726174696f6e20697320717569636b20616e6420656173792c2074686f75207765207374696c6c207265717569726520736f6d6520696e666f726d6174696f6e206c696b6520796f757220616464726573732e205468697320696e666f726d6174696f6e206973207573656420627920746865207365617263682c20736f207468617420697420697320706f737369626c6520746f20646973706c61792070656f706c652077686f2061726520696e746572657374656420696e20646174696e6720796f7520616e64206c697665206e6561722062792e3c2f703e, NULL, 0),
(NULL, 21, 'en', 0x3c696d6720616c743d22746f6e67756522207469746c653d22746f6e67756522207372633d22687474703a2f2f6c6f63616c686f73742f76626d73636d732f7265736f757263652f6a732f656c7274652f696d616765732f736d696c6579732f746f6e6775652e706e6722202f3e, NULL, 0),
(NULL, 20, 'en', 0x3c68313e4f6e6c696e6520446174696e673c2f68313e0d0a3c703e57656c636f6d6520746f206d79206f6e6c696e6520646174696e672e204f6e65206f66207468652066657720746f74616c6c792066726565206f6e6c696e6520646174696e67206e6574776f726b732e3c2f703e0d0a3c68333e4d79204f6e6c696e6520446174696e673c2f68333e0d0a3c703e4d79206f6e6c696e6520646174696e67206973206f6e65206f6620746865206f6e6c792066726565206f6e6c696e65203c61207469746c653d226f6e6c696e6520646174696e672220687265663d22687474703a2f2f656e2e77696b6970656469612e6f72672f77696b692f436f6d70617269736f6e5f6f665f6f6e6c696e655f646174696e675f7765627369746573223e646174696e67206e6574776f726b733c2f613e2e205265676973746572206e6f7720616e6420656e6a6f792066726565206f6e6c696e6520646174696e672e205768656e20492020207761732073696e676c65204920736561726368656420666f72206f6e6c696e6520646174696e672077656220736974657320616e64206576656e20706179656420746f20757365206f6e652e204920736f6f6e206e6f746963656420636f6d6d65726369616c206f6e6c696e6520646174696e672077656220736974657320617265206f6674656e207363616d7320776974682066616b652075736572732e20546865792077657265206a757374206166746572206d79206d6f6e65792e20536f2049206465636964656420746f206d616b65206d79206f776e2066726565206f6e6c696e6520646174696e672077656220736974652e20536f20686572652069742069732e20506c65617365207265676973746572206e6f7720736f207468617420776520676574206173206d616e7920757365727320617320706f737369626c652e3c2f703e0d0a3c68333e46726565204f6e6c696e6520446174696e673c2f68333e0d0a3c703e492077696c6c206b656570206f6e6c696e6534646174696e672e6e657420636f737420667265652e20496e2072657475726e20666f72206d79206566666f727420746f2070726f7669646520612066726565206f6e6c696e6520646174696e67206e6574776f726b2c204920776f756c64206265207665727920686170707920696620796f75206a757374207265636f6d6d656e642074686973206f6e6c696e6520646174696e67206e6574776f726b20746f20616c6c206f6620796f757220667269656e64732e20596f752063616e20757365206f70656e20696473206c696b65203c61207469746c653d22736f6369616c206e6574776f726b2220687265663d22687474703a2f2f7777772e66616365626f6f6b2e636f6d223e66616365626f6f6b3c2f613e206f72203c6120687265663d22687474703a2f2f676f6f676c652e636f6d223e676f6f676c653c2f613e20746f206c6f67696e2c20736f20796f7520646f6e2774206576656e206861766520746f2072656d656d62657220612070617373776f72642e20526567697374726174696f6e20697320717569636b20616e6420656173792c2074686f75207765207374696c6c207265717569726520736f6d6520696e666f726d6174696f6e206c696b6520796f757220616464726573732e205468697320696e666f726d6174696f6e206973207573656420627920746865207365617263682c20736f207468617420697420697320706f737369626c6520746f20646973706c61792070656f706c652077686f2061726520696e746572657374656420696e20646174696e6720796f7520616e64206c697665206e6561722062792e3c2f703e, NULL, 0),
(NULL, 21, 'en', 0x3c696d6720616c743d22746f6e67756522207469746c653d22746f6e67756522207372633d22687474703a2f2f6c6f63616c686f73742f76626d73636d732f7265736f757263652f6a732f656c7274652f696d616765732f736d696c6579732f746f6e6775652e706e6722202f3e, NULL, 0),
(NULL, 61, 'en', 0x3c68313e436f6e746163743c2f68313e0d0a3c703e4865726520796f752063616e2073656e642075732061206d6573736167652e20496620796f75206861766520616e79207175657374696f6e73206f722077616e7420746f2074656c6c20757320736f6d657468696e672061626f757420746865207765622073697465206665656c206672656520746f20757365207468697320636f6e7461637420666f726d20746f2073656e642075732061206d6573736167652e3c2f703e, NULL, 0),
(NULL, 62, 'en', 0x3c6831207374796c653d22746578742d616c69676e3a63656e746572223e57454253495445205445524d5320414e4420434f4e444954494f4e533c2f68313e0d0a3c68333e496e74726f64756374696f6e3c2f68333e0d0a3c703e5468657365207465726d7320616e6420636f6e646974696f6e7320676f7665726e20796f757220757365206f66207468697320776562736974653b206279207573696e67207468697320776562736974652c20796f7520616363657074207468657365207465726d7320616e6420636f6e646974696f6e7320696e2066756c6c2e266e6273703b266e6273703b20496620796f752064697361677265652077697468207468657365207465726d7320616e6420636f6e646974696f6e73206f7220616e792070617274206f66207468657365207465726d7320616e6420636f6e646974696f6e732c20796f75206d757374206e6f7420757365207468697320776562736974652e3c2f703e0d0a3c703e596f75206d757374206265206174206c65617374203138207965617273206f662061676520746f20757365207468697320776562736974652e204279207573696e672074686973207765627369746520616e64206279206167726565696e6720746f207468657365207465726d7320616e6420636f6e646974696f6e7320796f752077617272616e7420616e6420726570726573656e74207468617420796f7520617265206174206c65617374203138207965617273206f66206167652e3c2f703e0d0a3c703e546869732077656273697465207573657320636f6f6b6965732e204279207573696e672074686973207765627369746520616e64206167726565696e6720746f207468657365207465726d7320616e6420636f6e646974696f6e732c20796f7520636f6e73656e7420746f206f7572206f6e6c696e6534646174696e672e636f6d277320757365206f6620636f6f6b69657320696e206163636f7264616e6365207769746820746865207465726d73206f66206f6e6c696e6534646174696e672e636f6d3c2f703e0d0a3c68333e4c6963656e736520746f2075736520776562736974653c2f68333e0d0a3c703e556e6c657373206f7468657277697365207374617465642c206f6e6c696e6534646174696e672e636f6d20616e642f6f7220697473206c6963656e736f7273206f776e2074686520696e74656c6c65637475616c2070726f70657274792072696768747320696e20746865207765627369746520616e64206d6174657269616c206f6e2074686520776562736974652e205375626a65637420746f20746865206c6963656e73652062656c6f772c20616c6c20746865736520696e74656c6c65637475616c2070726f706572747920726967687473206172652072657365727665642e3c2f703e0d0a3c703e596f75206d617920766965772c20646f776e6c6f616420666f722063616368696e6720707572706f736573206f6e6c792c20616e64207072696e742070616765732066726f6d20746865207765627369746520666f7220796f7572206f776e20706572736f6e616c207573652c207375626a65637420746f20746865207265737472696374696f6e7320736574206f75742062656c6f7720616e6420656c7365776865726520696e207468657365207465726d7320616e6420636f6e646974696f6e732e3c2f703e0d0a3c703e596f75206d757374206e6f743a3c2f703e0d0a3c756c3e0d0a3c6c693e72657075626c697368206d6174657269616c2066726f6d207468697320776562736974652028696e636c7564696e672072657075626c69636174696f6e206f6e20616e6f746865722077656273697465292e3c2f6c693e0d0a3c6c693e73656c6c2c2072656e74206f72207375622d6c6963656e7365206d6174657269616c2066726f6d2074686520776562736974652e3c2f6c693e0d0a3c6c693e73686f7720616e79206d6174657269616c2066726f6d20746865207765627369746520696e207075626c69632e3c2f6c693e0d0a3c6c693e726570726f647563652c206475706c69636174652c20636f7079206f72206f7468657277697365206578706c6f6974206d6174657269616c206f6e2074686973207765627369746520666f72206120636f6d6d65726369616c20707572706f73652e3c2f6c693e0d0a3c6c693e65646974206f72206f7468657277697365206d6f6469667920616e79206d6174657269616c206f6e2074686520776562736974652e3c2f6c693e0d0a3c6c693e726564697374726962757465206d6174657269616c2066726f6d207468697320776562736974652e3c2f6c693e0d0a3c2f756c3e0d0a3c68333e41636365707461626c65207573653c2f68333e0d0a3c703e596f75206d757374206e6f74207573652074686973207765627369746520696e20616e79207761792074686174206361757365732c206f72206d61792063617573652c2064616d61676520746f207468652077656273697465206f7220696d706169726d656e74206f662074686520617661696c6162696c697479206f72206163636573736962696c697479206f66207468652077656273697465206f7220696e20616e792077617920776869636820697320756e6c617766756c2c20696c6c6567616c2c206672617564756c656e74206f72206861726d66756c2c206f7220696e20636f6e6e656374696f6e207769746820616e7920756e6c617766756c2c20696c6c6567616c2c206672617564756c656e74206f72206861726d66756c20707572706f7365206f722061637469766974792e3c2f703e3c703e596f75206d757374206e6f74207573652074686973207765627369746520746f20636f70792c2073746f72652c20686f73742c207472616e736d69742c2073656e642c207573652c207075626c697368206f72206469737472696275746520616e79206d6174657269616c20776869636820636f6e7369737473206f6620286f72206973206c696e6b656420746f2920616e7920737079776172652c20636f6d70757465722076697275732c2054726f6a616e20686f7273652c20776f726d2c206b65797374726f6b65206c6f676765722c20726f6f746b6974206f72206f74686572206d616c6963696f757320636f6d707574657220736f6674776172652e3c2f703e0d0a3c703e596f75206d757374206e6f7420636f6e6475637420616e792073797374656d61746963206f72206175746f6d61746564206461746120636f6c6c656374696f6e20616374697669746965732028696e636c7564696e6720776974686f7574206c696d69746174696f6e207363726170696e672c2064617461206d696e696e672c20646174612065787472616374696f6e20616e6420646174612068617276657374696e6729206f6e206f7220696e2072656c6174696f6e20746f2074686973207765627369746520776974686f7574206f6e6c696e6534646174696e672e636f6d27732065787072657373207772697474656e20636f6e73656e742e3c2f703e0d0a3c703e596f75206d757374206e6f74207573652074686973207765627369746520666f7220616e7920707572706f7365732072656c6174656420746f206d61726b6574696e6720776974686f7574206f6e6c696e6534646174696e672e636f6d27732065787072657373207772697474656e20636f6e73656e742e3c2f703e0d0a3c68333e52657374726963746564206163636573733c2f68333e0d0a3c703e6f6e6c696e6534646174696e672e636f6d2072657365727665732074686520726967687420746f2072657374726963742061636365737320746f2070726976617465206172656173206f66207468697320776562736974652c206f7220696e64656564207468697320656e7469726520776562736974652c206174206f6e6c696e6534646174696e672e636f6d2027732064697363726574696f6e2e3c2f703e0d0a3c703e4966206f6e6c696e6534646174696e672e636f6d2070726f766964657320796f7520776974682061207573657220494420616e642070617373776f726420746f20656e61626c6520796f7520746f206163636573732072657374726963746564206172656173206f6620746869732077656273697465206f72206f7468657220636f6e74656e74206f722073657276696365732c20796f75206d75737420656e73757265207468617420746865207573657220494420616e642070617373776f726420617265206b65707420636f6e666964656e7469616c2e3c2f703e0d0a3c703e6f6e6c696e6534646174696e672e636f6d206d61792064697361626c6520796f7572207573657220494420616e642070617373776f726420696e206f6e6c696e6534646174696e672e636f6d277320736f6c652064697363726574696f6e20776974686f7574206e6f74696365206f72206578706c616e6174696f6e2e3c2f703e0d0a3c68333e5573657220636f6e74656e743c2f68333e0d0a3c703e496e207468657365207465726d7320616e6420636f6e646974696f6e732c2022796f7572207573657220636f6e74656e7422206d65616e73206d6174657269616c2028696e636c7564696e6720776974686f7574206c696d69746174696f6e20746578742c20696d616765732c20617564696f206d6174657269616c2c20766964656f206d6174657269616c20616e6420617564696f2d76697375616c206d6174657269616c29207468617420796f75207375626d697420746f207468697320776562736974652c20666f7220776861746576657220707572706f73652e3c2f703e0d0a3c703e596f75206772616e7420746f206f6e6c696e6534646174696e672e636f6d206120776f726c64776964652c2069727265766f6361626c652c206e6f6e2d6578636c75736976652c20726f79616c74792d66726565206c6963656e736520746f207573652c20726570726f647563652c2061646170742c207075626c6973682c207472616e736c61746520616e64206469737472696275746520796f7572207573657220636f6e74656e7420696e20616e79206578697374696e67206f7220667574757265206d656469612e20596f7520616c736f206772616e7420746f206f6e6c696e6534646174696e672e636f6d20202074686520726967687420746f207375622d6c6963656e7365207468657365207269676874732c20616e642074686520726967687420746f206272696e6720616e20616374696f6e20666f7220696e6672696e67656d656e74206f66207468657365207269676874732e3c2f703e0d0a3c703e596f7572207573657220636f6e74656e74206d757374206e6f7420626520696c6c6567616c206f7220756e6c617766756c2c206d757374206e6f7420696e6672696e676520616e792074686972642070617274792773206c6567616c207269676874732c20616e64206d757374206e6f742062652063617061626c65206f6620676976696e67207269736520746f206c6567616c20616374696f6e207768657468657220616761696e737420796f75206f72206f6e6c696e6534646174696e672e636f6d206f7220612074686972642070617274792028696e2065616368206361736520756e64657220616e79206170706c696361626c65206c6177292e3c2f703e0d0a3c703e596f75206d757374206e6f74207375626d697420616e79207573657220636f6e74656e7420746f2074686520776562736974652074686174206973206f72206861732065766572206265656e20746865207375626a656374206f6620616e7920746872656174656e6564206f722061637475616c206c6567616c2070726f63656564696e6773206f72206f746865722073696d696c617220636f6d706c61696e742e3c2f703e0d0a3c703e6f6e6c696e6534646174696e672e636f6d2072657365727665732074686520726967687420746f2065646974206f722072656d6f766520616e79206d6174657269616c207375626d697474656420746f207468697320776562736974652c206f722073746f726564206f6e206f6e6c696e6534646174696e672e636f6d27732020736572766572732c206f7220686f73746564206f72207075626c69736865642075706f6e207468697320776562736974652e3c2f703e0d0a3c703e4e6f74776974687374616e64696e67206f6e6c696e6534646174696e672e636f6d27732072696768747320756e646572207468657365207465726d7320616e6420636f6e646974696f6e7320696e2072656c6174696f6e20746f207573657220636f6e74656e742c206f6e6c696e6534646174696e672e636f6d20646f6573206e6f7420756e64657274616b6520746f206d6f6e69746f7220746865207375626d697373696f6e206f66207375636820636f6e74656e7420746f2c206f7220746865207075626c69636174696f6e206f66207375636820636f6e74656e74206f6e2c207468697320776562736974652e3c2f703e0d0a3c68333e4e6f2077617272616e746965733c2f68333e0d0a3c703e5468697320776562736974652069732070726f7669646564209361732069739420776974686f757420616e7920726570726573656e746174696f6e73206f722077617272616e746965732c2065787072657373206f7220696d706c6965642e206f6e6c696e6534646174696e672e636f6d206d616b6573206e6f20726570726573656e746174696f6e73206f722077617272616e7469657320696e2072656c6174696f6e20746f20746869732077656273697465206f722074686520696e666f726d6174696f6e20616e64206d6174657269616c732070726f7669646564206f6e207468697320776562736974652e3c2f703e203c703e576974686f7574207072656a756469636520746f207468652067656e6572616c697479206f662074686520666f7265676f696e67207061726167726170682c206f6e6c696e6534646174696e672e636f6d20646f6573206e6f742077617272616e7420746861743a3c2f703e0d0a3c6f6c3e0d0a3c6c693e7468697320776562736974652077696c6c20626520636f6e7374616e746c7920617661696c61626c652c206f7220617661696c61626c6520617420616c6c2e3c2f6c693e0d0a3c6c693e74686520696e666f726d6174696f6e206f6e2074686973207765627369746520697320636f6d706c6574652c20747275652c206163637572617465206f72206e6f6e2d6d69736c656164696e672e3c2f6c693e0d0a3c2f6f6c3e0d0a3c703e4e6f7468696e67206f6e2074686973207765627369746520636f6e73746974757465732c206f72206973206d65616e7420746f20636f6e737469747574652c20616476696365206f6620616e79206b696e642e20496620796f7520726571756972652061647669636520696e2072656c6174696f6e20746f20616e79206c6567616c2c2066696e616e6369616c206f72206d65646963616c206d617474657220796f752073686f756c6420636f6e73756c7420616e20617070726f7072696174652070726f66657373696f6e616c2e3c2f703e0d0a3c68333e4c696d69746174696f6e73206f66206c696162696c6974793c2f68333e0d0a3c703e6f6e6c696e6534646174696e672e636f6d2077696c6c206e6f74206265206c6961626c6520746f20796f7520287768657468657220756e64657220746865206c6177206f6620636f6e746163742c20746865206c6177206f6620746f727473206f72206f74686572776973652920696e2072656c6174696f6e20746f2074686520636f6e74656e7473206f662c206f7220757365206f662c206f72206f746865727769736520696e20636f6e6e656374696f6e20776974682c207468697320776562736974653a3c2f703e0d0a3c6f6c3e0d0a3c6c693e746f2074686520657874656e7420746861742074686520776562736974652069732070726f766964656420667265652d6f662d6368617267652c20666f7220616e7920646972656374206c6f73732e3c2f6c693e0d0a3c6c693e666f7220616e7920696e6469726563742c207370656369616c206f7220636f6e73657175656e7469616c206c6f73732e3c2f6c693e0d0a3c6c693e666f7220616e7920627573696e657373206c6f737365732c206c6f7373206f6620726576656e75652c20696e636f6d652c2070726f66697473206f7220616e74696369706174656420736176696e67732c206c6f7373206f6620636f6e747261637473206f7220627573696e6573732072656c6174696f6e73686970732c206c6f7373206f66200d0a72657075746174696f6e206f7220676f6f6477696c6c2c206f72206c6f7373206f7220636f7272757074696f6e206f6620696e666f726d6174696f6e206f7220646174612e3c2f6c693e0d0a3c2f6f6c3e0d0a3c703e5468657365206c696d69746174696f6e73206f66206c696162696c697479206170706c79206576656e206966206f6e6c696e6534646174696e672e636f6d20686173206265656e20657870726573736c792061647669736564206f662074686520706f74656e7469616c206c6f73732e3c2f703e0d0a3c68333e457863657074696f6e733c2f68333e0d0a3c703e4e6f7468696e6720696e2074686973207765627369746520646973636c61696d65722077696c6c206578636c756465206f72206c696d697420616e792077617272616e747920696d706c696564206279206c6177207468617420697420776f756c6420626520756e6c617766756c20746f206578636c756465206f72206c696d697420616e64206e6f7468696e6720696e2074686973207765627369746520646973636c61696d65722077696c6c206578636c756465206f72206c696d6974206f6e6c696e6534646174696e672e636f6d2773206c696162696c69747920696e2072657370656374206f6620616e793a3c2f703e0d0a3c756c3e0d0a3c6c693e6465617468206f7220706572736f6e616c20696e6a75727920636175736564206279206f6e6c696e6534646174696e672773206e65676c6967656e63652e3c2f6c693e0d0a3c6c693e6672617564206f72206672617564756c656e74206d6973726570726573656e746174696f6e206f6e207468652070617274206f66206f6e6c696e6534646174696e672e636f6d2e3c2f6c693e0d0a3c6c693e6d617474657220776869636820697420776f756c6420626520696c6c6567616c206f7220756e6c617766756c20666f72206f6e6c696e6534646174696e672e636f6d20746f206578636c756465206f72206c696d69742c206f7220746f20617474656d7074206f7220707572706f727420746f206578636c756465206f72206c696d69742c20697473206c696162696c6974792e3c2f6c693e0d0a3c2f756c3e0d0a3c68333e526561736f6e61626c656e6573733c2f68333e0d0a3c703e4279207573696e67207468697320776562736974652c20796f75206167726565207468617420746865206578636c7573696f6e7320616e64206c696d69746174696f6e73206f66206c696162696c69747920736574206f757420696e2074686973207765627369746520646973636c61696d65722061726520726561736f6e61626c652e3c2f703e0d0a3c703e496620796f7520646f206e6f74207468696e6b20746865792061726520726561736f6e61626c652c20796f75206d757374206e6f7420757365207468697320776562736974652e3c2f703e0d0a3c68333e4f7468657220706172746965733c2f68333e0d0a3c703e596f752061636365707420746861742c2061732061206c696d69746564206c696162696c69747920656e746974792c206f6e6c696e6534646174696e672e636f6d2068617320616e20696e74657265737420696e206c696d6974696e672074686520706572736f6e616c206c696162696c697479206f6620697473206f6666696365727320616e6420656d706c6f796565732e20596f75206167726565207468617420796f752077696c6c206e6f74206272696e6720616e7920636c61696d20706572736f6e616c6c7920616761696e7374206f6e6c696e6534646174696e672e636f6d2773206f66666963657273206f7220656d706c6f7965657320696e2072657370656374206f6620616e79206c6f7373657320796f752073756666657220696e20636f6e6e656374696f6e20776974682074686520776562736974652e3c2f703e0d0a3c703e576974686f7574207072656a756469636520746f2074686520666f7265676f696e67207061726167726170682c20796f75206167726565207468617420746865206c696d69746174696f6e73206f662077617272616e7469657320616e64206c696162696c69747920736574206f757420696e2074686973207765627369746520646973636c61696d65722077696c6c2070726f74656374206f6e6c696e6534646174696e672e636f6d2773206f666669636572732c20656d706c6f796565732c206167656e74732c207375627369646961726965732c20737563636573736f72732c2061737369676e7320616e64207375622d636f6e74726163746f72732061732077656c6c206173206f6e6c696e6534646174696e672e636f6d2e203c2f703e0d0a3c68333e556e656e666f72636561626c652070726f766973696f6e733c2f68333e0d0a3c703e496620616e792070726f766973696f6e206f662074686973207765627369746520646973636c61696d65722069732c206f7220697320666f756e6420746f2062652c20756e656e666f72636561626c6520756e646572206170706c696361626c65206c61772c20746861742077696c6c206e6f74206166666563742074686520656e666f7263656162696c697479206f6620746865206f746865722070726f766973696f6e73206f662074686973207765627369746520646973636c61696d65722e3c2f703e0d0a3c68333e496e64656d6e6974793c2f68333e0d0a3c703e596f752068657265627920696e64656d6e696679206f6e6c696e6534646174696e672e636f6d20616e6420756e64657274616b6520746f206b656570206f6e6c696e6534646174696e672e636f6d20696e64656d6e696669656420616761696e737420616e79206c6f737365732c2064616d616765732c20636f7374732c206c696162696c697469657320616e6420657870656e7365732028696e636c7564696e6720776974686f7574206c696d69746174696f6e206c6567616c20657870656e73657320616e6420616e7920616d6f756e74732070616964206279206f6e6c696e6534646174696e672e636f6d20746f206120746869726420706172747920696e20736574746c656d656e74206f66206120636c61696d206f722064697370757465206f6e2074686520616476696365206f66206f6e6c696e6534646174696e672e636f6d27736c6567616c2061647669736572732920696e637572726564206f72207375666665726564206279206f6e6c696e6534646174696e672e636f6d2061726973696e67206f7574206f6620616e792062726561636820627920796f75206f6620616e792070726f766973696f6e206f66207468657365207465726d7320616e6420636f6e646974696f6e73206f722061726973696e67206f7574206f6620616e7920636c61696d207468617420796f75206861766520627265616368656420616e792070726f766973696f6e206f66207468657365207465726d7320616e6420636f6e646974696f6e732e3c2f703e0d0a3c68333e4272656163686573206f66207468657365207465726d7320616e6420636f6e646974696f6e733c2f68333e0d0a3c703e576974686f7574207072656a756469636520746f206f6e6c696e6534646174696e672e636f6d2773206f746865722072696768747320756e646572207468657365207465726d7320616e6420636f6e646974696f6e732c20696620796f7520627265616368207468657365207465726d7320616e6420636f6e646974696f6e7320696e20616e79207761792c206f6e6c696e6534646174696e672e636f6d206d61792074616b65207375636820616374696f6e206173206f6e6c696e6534646174696e672e636f6d206465656d7320617070726f70726961746520746f206465616c207769746820746865206272656163682c20696e636c7564696e672073757370656e64696e6720796f75722061636365737320746f2074686520776562736974652c2070726f6869626974696e6720796f752066726f6d20616363657373696e672074686520776562736974652c20626c6f636b696e6720636f6d707574657273207573696e6720796f757220495020616464726573732066726f6d20616363657373696e672074686520776562736974652c20636f6e74616374696e6720796f757220696e7465726e657420736572766963652070726f766964657220746f20726571756573742074686174207468657920626c6f636b20796f75722061636365737320746f20746865207765627369746520616e642f6f72206272696e67696e6720636f7572742070726f63656564696e677320616761696e737420796f752e3c2f703e0d0a3c68333e566172696174696f6e3c2f68333e0d0a3c703e6f6e6c696e6534646174696e672e636f6d206d617920726576697365207468657365207465726d7320616e6420636f6e646974696f6e732066726f6d2074696d652d746f2d74696d652e2052657669736564207465726d7320616e6420636f6e646974696f6e732077696c6c206170706c7920746f2074686520757365206f66207468697320776562736974652066726f6d207468652064617465206f6620746865207075626c69636174696f6e206f66207468652072657669736564207465726d7320616e6420636f6e646974696f6e73206f6e207468697320776562736974652e20506c6561736520636865636b2074686973207061676520726567756c61726c7920746f20656e7375726520796f75206172652066616d696c6961722077697468207468652063757272656e742076657273696f6e2e3c2f703e0d0a3c68333e41737369676e6d656e743c2f68333e0d0a3c703e6f6e6c696e6534646174696e672e636f6d206d6179207472616e736665722c207375622d636f6e7472616374206f72206f7468657277697365206465616c2077697468206f6e6c696e6534646174696e672e636f6d2072696768747320616e642f6f72206f626c69676174696f6e7320756e646572207468657365207465726d7320616e6420636f6e646974696f6e7320776974686f7574206e6f74696679696e6720796f75206f72206f627461696e696e6720796f757220636f6e73656e742e3c2f703e0d0a3c703e596f75206d6179206e6f74207472616e736665722c207375622d636f6e7472616374206f72206f7468657277697365206465616c207769746820796f75722072696768747320616e642f6f72206f626c69676174696f6e7320756e646572207468657365207465726d7320616e6420636f6e646974696f6e732e3c2f703e0d0a3c68333e53657665726162696c6974793c2f68333e0d0a3c703e496620612070726f766973696f6e206f66207468657365207465726d7320616e6420636f6e646974696f6e732069732064657465726d696e656420627920616e7920636f757274206f72206f7468657220636f6d706574656e7420617574686f7269747920746f20626520756e6c617766756c20616e642f6f7220756e656e666f72636561626c652c20746865206f746865722070726f766973696f6e732077696c6c20636f6e74696e756520696e206566666563742e20496620616e7920756e6c617766756c20616e642f6f7220756e656e666f72636561626c652070726f766973696f6e20776f756c64206265206c617766756c206f7220656e666f72636561626c652069662070617274206f6620697420776572652064656c657465642c207468617420706172742077696c6c206265206465656d656420746f2062652064656c657465642c20616e64207468652072657374206f66207468652070726f766973696f6e2077696c6c20636f6e74696e756520696e206566666563742e3c2f703e0d0a3c68333e456e746972652061677265656d656e743c2f68333e0d0a3c703e5468657365207465726d7320616e6420636f6e646974696f6e7320636f6e737469747574652074686520656e746972652061677265656d656e74206265747765656e20796f7520616e64206f6e6c696e6534646174696e672e636f6d20696e2072656c6174696f6e20746f20796f757220757365206f66207468697320776562736974652c20616e642073757065727365646520616c6c2070726576696f75732061677265656d656e747320696e2072657370656374206f6620796f757220757365206f66207468697320776562736974652e3c2f703e, NULL, 0),
(NULL, 20, 'en', 0x3c68313e4f6e6c696e6520446174696e673c2f68313e0d0a3c703e57656c636f6d6520746f206d79206f6e6c696e6520646174696e672e204f6e65206f66207468652066657720746f74616c6c792066726565206f6e6c696e6520646174696e67206e6574776f726b732e3c2f703e0d0a3c68333e4d79204f6e6c696e6520446174696e673c2f68333e0d0a3c703e4d79206f6e6c696e6520646174696e67206973206f6e65206f6620746865206f6e6c792066726565206f6e6c696e65203c61207469746c653d226f6e6c696e6520646174696e672220687265663d22687474703a2f2f656e2e77696b6970656469612e6f72672f77696b692f436f6d70617269736f6e5f6f665f6f6e6c696e655f646174696e675f7765627369746573223e646174696e67206e6574776f726b733c2f613e2e205265676973746572206e6f7720616e6420656e6a6f792066726565206f6e6c696e6520646174696e672e205768656e20492020207761732073696e676c65204920736561726368656420666f72206f6e6c696e6520646174696e672077656220736974657320616e64206576656e20706179656420746f20757365206f6e652e204920736f6f6e206e6f746963656420636f6d6d65726369616c206f6e6c696e6520646174696e672077656220736974657320617265206f6674656e207363616d7320776974682066616b652075736572732e20546865792077657265206a757374206166746572206d79206d6f6e65792e20536f2049206465636964656420746f206d616b65206d79206f776e2066726565206f6e6c696e6520646174696e672077656220736974652e20536f20686572652069742069732e20506c65617365207265676973746572206e6f7720736f207468617420776520676574206173206d616e7920757365727320617320706f737369626c652e3c2f703e0d0a3c68333e46726565204f6e6c696e6520446174696e673c2f68333e0d0a3c703e492077696c6c206b656570206f6e6c696e6534646174696e672e6e657420636f737420667265652e20496e2072657475726e20666f72206d79206566666f727420746f2070726f7669646520612066726565206f6e6c696e6520646174696e67206e6574776f726b2c204920776f756c64206265207665727920686170707920696620796f75206a757374207265636f6d6d656e642074686973206f6e6c696e6520646174696e67206e6574776f726b20746f20616c6c206f6620796f757220667269656e64732e20596f752063616e20757365206f70656e20696473206c696b65203c61207469746c653d22736f6369616c206e6574776f726b2220687265663d22687474703a2f2f7777772e66616365626f6f6b2e636f6d223e66616365626f6f6b3c2f613e206f72203c6120687265663d22687474703a2f2f676f6f676c652e636f6d223e676f6f676c653c2f613e20746f206c6f67696e2c20736f20796f7520646f6e2774206576656e206861766520746f2072656d656d62657220612070617373776f72642e20526567697374726174696f6e20697320717569636b20616e6420656173792c2074686f75207765207374696c6c207265717569726520736f6d6520696e666f726d6174696f6e206c696b6520796f757220616464726573732e205468697320696e666f726d6174696f6e206973207573656420627920746865207365617263682c20736f207468617420697420697320706f737369626c6520746f20646973706c61792070656f706c652077686f2061726520696e746572657374656420696e20646174696e6720796f7520616e64206c697665206e6561722062792e3c2f703e, NULL, 0),
(NULL, 21, 'en', 0x3c696d6720616c743d22746f6e67756522207469746c653d22746f6e67756522207372633d22687474703a2f2f6c6f63616c686f73742f76626d73636d732f7265736f757263652f6a732f656c7274652f696d616765732f736d696c6579732f746f6e6775652e706e6722202f3e, NULL, 0),
(NULL, 20, 'en', 0x3c68313e4f6e6c696e6520446174696e673c2f68313e0d0a3c703e57656c636f6d6520746f206d79206f6e6c696e6520646174696e672e204f6e65206f66207468652066657720746f74616c6c792066726565206f6e6c696e6520646174696e67206e6574776f726b732e3c2f703e0d0a3c68333e4d79204f6e6c696e6520446174696e673c2f68333e0d0a3c703e4d79206f6e6c696e6520646174696e67206973206f6e65206f6620746865206f6e6c792066726565206f6e6c696e65203c61207469746c653d226f6e6c696e6520646174696e672220687265663d22687474703a2f2f656e2e77696b6970656469612e6f72672f77696b692f436f6d70617269736f6e5f6f665f6f6e6c696e655f646174696e675f7765627369746573223e646174696e67206e6574776f726b733c2f613e2e205265676973746572206e6f7720616e6420656e6a6f792066726565206f6e6c696e6520646174696e672e205768656e20492020207761732073696e676c65204920736561726368656420666f72206f6e6c696e6520646174696e672077656220736974657320616e64206576656e20706179656420746f20757365206f6e652e204920736f6f6e206e6f746963656420636f6d6d65726369616c206f6e6c696e6520646174696e672077656220736974657320617265206f6674656e207363616d7320776974682066616b652075736572732e20546865792077657265206a757374206166746572206d79206d6f6e65792e20536f2049206465636964656420746f206d616b65206d79206f776e2066726565206f6e6c696e6520646174696e672077656220736974652e20536f20686572652069742069732e20506c65617365207265676973746572206e6f7720736f207468617420776520676574206173206d616e7920757365727320617320706f737369626c652e3c2f703e0d0a3c68333e46726565204f6e6c696e6520446174696e673c2f68333e0d0a3c703e492077696c6c206b656570206f6e6c696e6534646174696e672e6e657420636f737420667265652e20496e2072657475726e20666f72206d79206566666f727420746f2070726f7669646520612066726565206f6e6c696e6520646174696e67206e6574776f726b2c204920776f756c64206265207665727920686170707920696620796f75206a757374207265636f6d6d656e642074686973206f6e6c696e6520646174696e67206e6574776f726b20746f20616c6c206f6620796f757220667269656e64732e20596f752063616e20757365206f70656e20696473206c696b65203c61207469746c653d22736f6369616c206e6574776f726b2220687265663d22687474703a2f2f7777772e66616365626f6f6b2e636f6d223e66616365626f6f6b3c2f613e206f72203c6120687265663d22687474703a2f2f676f6f676c652e636f6d223e676f6f676c653c2f613e20746f206c6f67696e2c20736f20796f7520646f6e2774206576656e206861766520746f2072656d656d62657220612070617373776f72642e20526567697374726174696f6e20697320717569636b20616e6420656173792c2074686f75207765207374696c6c207265717569726520736f6d6520696e666f726d6174696f6e206c696b6520796f757220616464726573732e205468697320696e666f726d6174696f6e206973207573656420627920746865207365617263682c20736f207468617420697420697320706f737369626c6520746f20646973706c61792070656f706c652077686f2061726520696e746572657374656420696e20646174696e6720796f7520616e64206c697665206e6561722062792e3c2f703e, NULL, 0),
(NULL, 21, 'en', 0x3c696d6720616c743d22746f6e67756522207469746c653d22746f6e67756522207372633d22687474703a2f2f6c6f63616c686f73742f76626d73636d732f7265736f757263652f6a732f656c7274652f696d616765732f736d696c6579732f746f6e6775652e706e6722202f3e, NULL, 0),
(NULL, 20, 'en', 0x3c68313e4f6e6c696e6520446174696e673c2f68313e0d0a3c703e57656c636f6d6520746f206d79206f6e6c696e6520646174696e672e204f6e65206f66207468652066657720746f74616c6c792066726565206f6e6c696e6520646174696e67206e6574776f726b732e3c2f703e0d0a3c68333e4d79204f6e6c696e6520446174696e673c2f68333e0d0a3c703e4d79206f6e6c696e6520646174696e67206973206f6e65206f6620746865206f6e6c792066726565206f6e6c696e65203c61207469746c653d226f6e6c696e6520646174696e672220687265663d22687474703a2f2f656e2e77696b6970656469612e6f72672f77696b692f436f6d70617269736f6e5f6f665f6f6e6c696e655f646174696e675f7765627369746573223e646174696e67206e6574776f726b733c2f613e2e205265676973746572206e6f7720616e6420656e6a6f792066726565206f6e6c696e6520646174696e672e205768656e20492020207761732073696e676c65204920736561726368656420666f72206f6e6c696e6520646174696e672077656220736974657320616e64206576656e20706179656420746f20757365206f6e652e204920736f6f6e206e6f746963656420636f6d6d65726369616c206f6e6c696e6520646174696e672077656220736974657320617265206f6674656e207363616d7320776974682066616b652075736572732e20546865792077657265206a757374206166746572206d79206d6f6e65792e20536f2049206465636964656420746f206d616b65206d79206f776e2066726565206f6e6c696e6520646174696e672077656220736974652e20536f20686572652069742069732e20506c65617365207265676973746572206e6f7720736f207468617420776520676574206173206d616e7920757365727320617320706f737369626c652e3c2f703e0d0a3c68333e46726565204f6e6c696e6520446174696e673c2f68333e0d0a3c703e492077696c6c206b656570206f6e6c696e6534646174696e672e6e657420636f737420667265652e20496e2072657475726e20666f72206d79206566666f727420746f2070726f7669646520612066726565206f6e6c696e6520646174696e67206e6574776f726b2c204920776f756c64206265207665727920686170707920696620796f75206a757374207265636f6d6d656e642074686973206f6e6c696e6520646174696e67206e6574776f726b20746f20616c6c206f6620796f757220667269656e64732e20596f752063616e20757365206f70656e20696473206c696b65203c61207469746c653d22736f6369616c206e6574776f726b2220687265663d22687474703a2f2f7777772e66616365626f6f6b2e636f6d223e66616365626f6f6b3c2f613e206f72203c6120687265663d22687474703a2f2f676f6f676c652e636f6d223e676f6f676c653c2f613e20746f206c6f67696e2c20736f20796f7520646f6e2774206576656e206861766520746f2072656d656d62657220612070617373776f72642e20526567697374726174696f6e20697320717569636b20616e6420656173792c2074686f75207765207374696c6c207265717569726520736f6d6520696e666f726d6174696f6e206c696b6520796f757220616464726573732e205468697320696e666f726d6174696f6e206973207573656420627920746865207365617263682c20736f207468617420697420697320706f737369626c6520746f20646973706c61792070656f706c652077686f2061726520696e746572657374656420696e20646174696e6720796f7520616e64206c697665206e6561722062792e3c2f703e, NULL, 0),
(NULL, 21, 'en', 0x3c696d6720616c743d22746f6e67756522207469746c653d22746f6e67756522207372633d22687474703a2f2f6c6f63616c686f73742f76626d73636d732f7265736f757263652f6a732f656c7274652f696d616765732f736d696c6579732f746f6e6775652e706e6722202f3e, NULL, 0),
(NULL, 20, 'en', 0x3c68313e4f6e6c696e6520446174696e673c2f68313e0d0a3c703e57656c636f6d6520746f206d79206f6e6c696e6520646174696e672e204f6e65206f66207468652066657720746f74616c6c792066726565206f6e6c696e6520646174696e67206e6574776f726b732e3c2f703e0d0a3c68333e4d79204f6e6c696e6520446174696e673c2f68333e0d0a3c703e4d79206f6e6c696e6520646174696e67206973206f6e65206f6620746865206f6e6c792066726565206f6e6c696e65203c61207469746c653d226f6e6c696e6520646174696e672220687265663d22687474703a2f2f656e2e77696b6970656469612e6f72672f77696b692f436f6d70617269736f6e5f6f665f6f6e6c696e655f646174696e675f7765627369746573223e646174696e67206e6574776f726b733c2f613e2e205265676973746572206e6f7720616e6420656e6a6f792066726565206f6e6c696e6520646174696e672e205768656e20492020207761732073696e676c65204920736561726368656420666f72206f6e6c696e6520646174696e672077656220736974657320616e64206576656e20706179656420746f20757365206f6e652e204920736f6f6e206e6f746963656420636f6d6d65726369616c206f6e6c696e6520646174696e672077656220736974657320617265206f6674656e207363616d7320776974682066616b652075736572732e20546865792077657265206a757374206166746572206d79206d6f6e65792e20536f2049206465636964656420746f206d616b65206d79206f776e2066726565206f6e6c696e6520646174696e672077656220736974652e20536f20686572652069742069732e20506c65617365207265676973746572206e6f7720736f207468617420776520676574206173206d616e7920757365727320617320706f737369626c652e3c2f703e0d0a3c68333e46726565204f6e6c696e6520446174696e673c2f68333e0d0a3c703e492077696c6c206b656570206f6e6c696e6534646174696e672e6e657420636f737420667265652e20496e2072657475726e20666f72206d79206566666f727420746f2070726f7669646520612066726565206f6e6c696e6520646174696e67206e6574776f726b2c204920776f756c64206265207665727920686170707920696620796f75206a757374207265636f6d6d656e642074686973206f6e6c696e6520646174696e67206e6574776f726b20746f20616c6c206f6620796f757220667269656e64732e20596f752063616e20757365206f70656e20696473206c696b65203c61207469746c653d22736f6369616c206e6574776f726b2220687265663d22687474703a2f2f7777772e66616365626f6f6b2e636f6d223e66616365626f6f6b3c2f613e206f72203c6120687265663d22687474703a2f2f676f6f676c652e636f6d223e676f6f676c653c2f613e20746f206c6f67696e2c20736f20796f7520646f6e2774206576656e206861766520746f2072656d656d62657220612070617373776f72642e20526567697374726174696f6e20697320717569636b20616e6420656173792c2074686f75207765207374696c6c207265717569726520736f6d6520696e666f726d6174696f6e206c696b6520796f757220616464726573732e205468697320696e666f726d6174696f6e206973207573656420627920746865207365617263682c20736f207468617420697420697320706f737369626c6520746f20646973706c61792070656f706c652077686f2061726520696e746572657374656420696e20646174696e6720796f7520616e64206c697665206e6561722062792e3c2f703e, NULL, 0),
(NULL, 21, 'en', 0x3c696d6720616c743d22746f6e67756522207469746c653d22746f6e67756522207372633d22687474703a2f2f6c6f63616c686f73742f76626d73636d732f7265736f757263652f6a732f656c7274652f696d616765732f736d696c6579732f746f6e6775652e706e6722202f3e, NULL, 0),
(NULL, 61, 'en', 0x3c68313e436f6e746163743c2f68313e0d0a3c703e4865726520796f752063616e2073656e642075732061206d6573736167652e20496620796f75206861766520616e79207175657374696f6e73206f722077616e7420746f2074656c6c20757320736f6d657468696e672061626f757420746865207765622073697465206665656c206672656520746f20757365207468697320636f6e7461637420666f726d20746f2073656e642075732061206d6573736167652e3c2f703e, NULL, 0);
INSERT INTO `t_wysiwygpage` (`id`, `moduleid`, `lang`, `content`, `title`, `area`) VALUES
(NULL, 62, 'en', 0x3c6831207374796c653d22746578742d616c69676e3a63656e746572223e57454253495445205445524d5320414e4420434f4e444954494f4e533c2f68313e0d0a3c68333e496e74726f64756374696f6e3c2f68333e0d0a3c703e5468657365207465726d7320616e6420636f6e646974696f6e7320676f7665726e20796f757220757365206f66207468697320776562736974653b206279207573696e67207468697320776562736974652c20796f7520616363657074207468657365207465726d7320616e6420636f6e646974696f6e7320696e2066756c6c2e266e6273703b266e6273703b20496620796f752064697361677265652077697468207468657365207465726d7320616e6420636f6e646974696f6e73206f7220616e792070617274206f66207468657365207465726d7320616e6420636f6e646974696f6e732c20796f75206d757374206e6f7420757365207468697320776562736974652e3c2f703e0d0a3c703e596f75206d757374206265206174206c65617374203138207965617273206f662061676520746f20757365207468697320776562736974652e204279207573696e672074686973207765627369746520616e64206279206167726565696e6720746f207468657365207465726d7320616e6420636f6e646974696f6e7320796f752077617272616e7420616e6420726570726573656e74207468617420796f7520617265206174206c65617374203138207965617273206f66206167652e3c2f703e0d0a3c703e546869732077656273697465207573657320636f6f6b6965732e204279207573696e672074686973207765627369746520616e64206167726565696e6720746f207468657365207465726d7320616e6420636f6e646974696f6e732c20796f7520636f6e73656e7420746f206f7572206f6e6c696e6534646174696e672e636f6d277320757365206f6620636f6f6b69657320696e206163636f7264616e6365207769746820746865207465726d73206f66206f6e6c696e6534646174696e672e636f6d3c2f703e0d0a3c68333e4c6963656e736520746f2075736520776562736974653c2f68333e0d0a3c703e556e6c657373206f7468657277697365207374617465642c206f6e6c696e6534646174696e672e636f6d20616e642f6f7220697473206c6963656e736f7273206f776e2074686520696e74656c6c65637475616c2070726f70657274792072696768747320696e20746865207765627369746520616e64206d6174657269616c206f6e2074686520776562736974652e205375626a65637420746f20746865206c6963656e73652062656c6f772c20616c6c20746865736520696e74656c6c65637475616c2070726f706572747920726967687473206172652072657365727665642e3c2f703e0d0a3c703e596f75206d617920766965772c20646f776e6c6f616420666f722063616368696e6720707572706f736573206f6e6c792c20616e64207072696e742070616765732066726f6d20746865207765627369746520666f7220796f7572206f776e20706572736f6e616c207573652c207375626a65637420746f20746865207265737472696374696f6e7320736574206f75742062656c6f7720616e6420656c7365776865726520696e207468657365207465726d7320616e6420636f6e646974696f6e732e3c2f703e0d0a3c703e596f75206d757374206e6f743a3c2f703e0d0a3c756c3e0d0a3c6c693e72657075626c697368206d6174657269616c2066726f6d207468697320776562736974652028696e636c7564696e672072657075626c69636174696f6e206f6e20616e6f746865722077656273697465292e3c2f6c693e0d0a3c6c693e73656c6c2c2072656e74206f72207375622d6c6963656e7365206d6174657269616c2066726f6d2074686520776562736974652e3c2f6c693e0d0a3c6c693e73686f7720616e79206d6174657269616c2066726f6d20746865207765627369746520696e207075626c69632e3c2f6c693e0d0a3c6c693e726570726f647563652c206475706c69636174652c20636f7079206f72206f7468657277697365206578706c6f6974206d6174657269616c206f6e2074686973207765627369746520666f72206120636f6d6d65726369616c20707572706f73652e3c2f6c693e0d0a3c6c693e65646974206f72206f7468657277697365206d6f6469667920616e79206d6174657269616c206f6e2074686520776562736974652e3c2f6c693e0d0a3c6c693e726564697374726962757465206d6174657269616c2066726f6d207468697320776562736974652e3c2f6c693e0d0a3c2f756c3e0d0a3c68333e41636365707461626c65207573653c2f68333e0d0a3c703e596f75206d757374206e6f74207573652074686973207765627369746520696e20616e79207761792074686174206361757365732c206f72206d61792063617573652c2064616d61676520746f207468652077656273697465206f7220696d706169726d656e74206f662074686520617661696c6162696c697479206f72206163636573736962696c697479206f66207468652077656273697465206f7220696e20616e792077617920776869636820697320756e6c617766756c2c20696c6c6567616c2c206672617564756c656e74206f72206861726d66756c2c206f7220696e20636f6e6e656374696f6e207769746820616e7920756e6c617766756c2c20696c6c6567616c2c206672617564756c656e74206f72206861726d66756c20707572706f7365206f722061637469766974792e3c2f703e3c703e596f75206d757374206e6f74207573652074686973207765627369746520746f20636f70792c2073746f72652c20686f73742c207472616e736d69742c2073656e642c207573652c207075626c697368206f72206469737472696275746520616e79206d6174657269616c20776869636820636f6e7369737473206f6620286f72206973206c696e6b656420746f2920616e7920737079776172652c20636f6d70757465722076697275732c2054726f6a616e20686f7273652c20776f726d2c206b65797374726f6b65206c6f676765722c20726f6f746b6974206f72206f74686572206d616c6963696f757320636f6d707574657220736f6674776172652e3c2f703e0d0a3c703e596f75206d757374206e6f7420636f6e6475637420616e792073797374656d61746963206f72206175746f6d61746564206461746120636f6c6c656374696f6e20616374697669746965732028696e636c7564696e6720776974686f7574206c696d69746174696f6e207363726170696e672c2064617461206d696e696e672c20646174612065787472616374696f6e20616e6420646174612068617276657374696e6729206f6e206f7220696e2072656c6174696f6e20746f2074686973207765627369746520776974686f7574206f6e6c696e6534646174696e672e636f6d27732065787072657373207772697474656e20636f6e73656e742e3c2f703e0d0a3c703e596f75206d757374206e6f74207573652074686973207765627369746520666f7220616e7920707572706f7365732072656c6174656420746f206d61726b6574696e6720776974686f7574206f6e6c696e6534646174696e672e636f6d27732065787072657373207772697474656e20636f6e73656e742e3c2f703e0d0a3c68333e52657374726963746564206163636573733c2f68333e0d0a3c703e6f6e6c696e6534646174696e672e636f6d2072657365727665732074686520726967687420746f2072657374726963742061636365737320746f2070726976617465206172656173206f66207468697320776562736974652c206f7220696e64656564207468697320656e7469726520776562736974652c206174206f6e6c696e6534646174696e672e636f6d2027732064697363726574696f6e2e3c2f703e0d0a3c703e4966206f6e6c696e6534646174696e672e636f6d2070726f766964657320796f7520776974682061207573657220494420616e642070617373776f726420746f20656e61626c6520796f7520746f206163636573732072657374726963746564206172656173206f6620746869732077656273697465206f72206f7468657220636f6e74656e74206f722073657276696365732c20796f75206d75737420656e73757265207468617420746865207573657220494420616e642070617373776f726420617265206b65707420636f6e666964656e7469616c2e3c2f703e0d0a3c703e6f6e6c696e6534646174696e672e636f6d206d61792064697361626c6520796f7572207573657220494420616e642070617373776f726420696e206f6e6c696e6534646174696e672e636f6d277320736f6c652064697363726574696f6e20776974686f7574206e6f74696365206f72206578706c616e6174696f6e2e3c2f703e0d0a3c68333e5573657220636f6e74656e743c2f68333e0d0a3c703e496e207468657365207465726d7320616e6420636f6e646974696f6e732c2022796f7572207573657220636f6e74656e7422206d65616e73206d6174657269616c2028696e636c7564696e6720776974686f7574206c696d69746174696f6e20746578742c20696d616765732c20617564696f206d6174657269616c2c20766964656f206d6174657269616c20616e6420617564696f2d76697375616c206d6174657269616c29207468617420796f75207375626d697420746f207468697320776562736974652c20666f7220776861746576657220707572706f73652e3c2f703e0d0a3c703e596f75206772616e7420746f206f6e6c696e6534646174696e672e636f6d206120776f726c64776964652c2069727265766f6361626c652c206e6f6e2d6578636c75736976652c20726f79616c74792d66726565206c6963656e736520746f207573652c20726570726f647563652c2061646170742c207075626c6973682c207472616e736c61746520616e64206469737472696275746520796f7572207573657220636f6e74656e7420696e20616e79206578697374696e67206f7220667574757265206d656469612e20596f7520616c736f206772616e7420746f206f6e6c696e6534646174696e672e636f6d20202074686520726967687420746f207375622d6c6963656e7365207468657365207269676874732c20616e642074686520726967687420746f206272696e6720616e20616374696f6e20666f7220696e6672696e67656d656e74206f66207468657365207269676874732e3c2f703e0d0a3c703e596f7572207573657220636f6e74656e74206d757374206e6f7420626520696c6c6567616c206f7220756e6c617766756c2c206d757374206e6f7420696e6672696e676520616e792074686972642070617274792773206c6567616c207269676874732c20616e64206d757374206e6f742062652063617061626c65206f6620676976696e67207269736520746f206c6567616c20616374696f6e207768657468657220616761696e737420796f75206f72206f6e6c696e6534646174696e672e636f6d206f7220612074686972642070617274792028696e2065616368206361736520756e64657220616e79206170706c696361626c65206c6177292e3c2f703e0d0a3c703e596f75206d757374206e6f74207375626d697420616e79207573657220636f6e74656e7420746f2074686520776562736974652074686174206973206f72206861732065766572206265656e20746865207375626a656374206f6620616e7920746872656174656e6564206f722061637475616c206c6567616c2070726f63656564696e6773206f72206f746865722073696d696c617220636f6d706c61696e742e3c2f703e0d0a3c703e6f6e6c696e6534646174696e672e636f6d2072657365727665732074686520726967687420746f2065646974206f722072656d6f766520616e79206d6174657269616c207375626d697474656420746f207468697320776562736974652c206f722073746f726564206f6e206f6e6c696e6534646174696e672e636f6d27732020736572766572732c206f7220686f73746564206f72207075626c69736865642075706f6e207468697320776562736974652e3c2f703e0d0a3c703e4e6f74776974687374616e64696e67206f6e6c696e6534646174696e672e636f6d27732072696768747320756e646572207468657365207465726d7320616e6420636f6e646974696f6e7320696e2072656c6174696f6e20746f207573657220636f6e74656e742c206f6e6c696e6534646174696e672e636f6d20646f6573206e6f7420756e64657274616b6520746f206d6f6e69746f7220746865207375626d697373696f6e206f66207375636820636f6e74656e7420746f2c206f7220746865207075626c69636174696f6e206f66207375636820636f6e74656e74206f6e2c207468697320776562736974652e3c2f703e0d0a3c68333e4e6f2077617272616e746965733c2f68333e0d0a3c703e5468697320776562736974652069732070726f7669646564209361732069739420776974686f757420616e7920726570726573656e746174696f6e73206f722077617272616e746965732c2065787072657373206f7220696d706c6965642e206f6e6c696e6534646174696e672e636f6d206d616b6573206e6f20726570726573656e746174696f6e73206f722077617272616e7469657320696e2072656c6174696f6e20746f20746869732077656273697465206f722074686520696e666f726d6174696f6e20616e64206d6174657269616c732070726f7669646564206f6e207468697320776562736974652e3c2f703e203c703e576974686f7574207072656a756469636520746f207468652067656e6572616c697479206f662074686520666f7265676f696e67207061726167726170682c206f6e6c696e6534646174696e672e636f6d20646f6573206e6f742077617272616e7420746861743a3c2f703e0d0a3c6f6c3e0d0a3c6c693e7468697320776562736974652077696c6c20626520636f6e7374616e746c7920617661696c61626c652c206f7220617661696c61626c6520617420616c6c2e3c2f6c693e0d0a3c6c693e74686520696e666f726d6174696f6e206f6e2074686973207765627369746520697320636f6d706c6574652c20747275652c206163637572617465206f72206e6f6e2d6d69736c656164696e672e3c2f6c693e0d0a3c2f6f6c3e0d0a3c703e4e6f7468696e67206f6e2074686973207765627369746520636f6e73746974757465732c206f72206973206d65616e7420746f20636f6e737469747574652c20616476696365206f6620616e79206b696e642e20496620796f7520726571756972652061647669636520696e2072656c6174696f6e20746f20616e79206c6567616c2c2066696e616e6369616c206f72206d65646963616c206d617474657220796f752073686f756c6420636f6e73756c7420616e20617070726f7072696174652070726f66657373696f6e616c2e3c2f703e0d0a3c68333e4c696d69746174696f6e73206f66206c696162696c6974793c2f68333e0d0a3c703e6f6e6c696e6534646174696e672e636f6d2077696c6c206e6f74206265206c6961626c6520746f20796f7520287768657468657220756e64657220746865206c6177206f6620636f6e746163742c20746865206c6177206f6620746f727473206f72206f74686572776973652920696e2072656c6174696f6e20746f2074686520636f6e74656e7473206f662c206f7220757365206f662c206f72206f746865727769736520696e20636f6e6e656374696f6e20776974682c207468697320776562736974653a3c2f703e0d0a3c6f6c3e0d0a3c6c693e746f2074686520657874656e7420746861742074686520776562736974652069732070726f766964656420667265652d6f662d6368617267652c20666f7220616e7920646972656374206c6f73732e3c2f6c693e0d0a3c6c693e666f7220616e7920696e6469726563742c207370656369616c206f7220636f6e73657175656e7469616c206c6f73732e3c2f6c693e0d0a3c6c693e666f7220616e7920627573696e657373206c6f737365732c206c6f7373206f6620726576656e75652c20696e636f6d652c2070726f66697473206f7220616e74696369706174656420736176696e67732c206c6f7373206f6620636f6e747261637473206f7220627573696e6573732072656c6174696f6e73686970732c206c6f7373206f66200d0a72657075746174696f6e206f7220676f6f6477696c6c2c206f72206c6f7373206f7220636f7272757074696f6e206f6620696e666f726d6174696f6e206f7220646174612e3c2f6c693e0d0a3c2f6f6c3e0d0a3c703e5468657365206c696d69746174696f6e73206f66206c696162696c697479206170706c79206576656e206966206f6e6c696e6534646174696e672e636f6d20686173206265656e20657870726573736c792061647669736564206f662074686520706f74656e7469616c206c6f73732e3c2f703e0d0a3c68333e457863657074696f6e733c2f68333e0d0a3c703e4e6f7468696e6720696e2074686973207765627369746520646973636c61696d65722077696c6c206578636c756465206f72206c696d697420616e792077617272616e747920696d706c696564206279206c6177207468617420697420776f756c6420626520756e6c617766756c20746f206578636c756465206f72206c696d697420616e64206e6f7468696e6720696e2074686973207765627369746520646973636c61696d65722077696c6c206578636c756465206f72206c696d6974206f6e6c696e6534646174696e672e636f6d2773206c696162696c69747920696e2072657370656374206f6620616e793a3c2f703e0d0a3c756c3e0d0a3c6c693e6465617468206f7220706572736f6e616c20696e6a75727920636175736564206279206f6e6c696e6534646174696e672773206e65676c6967656e63652e3c2f6c693e0d0a3c6c693e6672617564206f72206672617564756c656e74206d6973726570726573656e746174696f6e206f6e207468652070617274206f66206f6e6c696e6534646174696e672e636f6d2e3c2f6c693e0d0a3c6c693e6d617474657220776869636820697420776f756c6420626520696c6c6567616c206f7220756e6c617766756c20666f72206f6e6c696e6534646174696e672e636f6d20746f206578636c756465206f72206c696d69742c206f7220746f20617474656d7074206f7220707572706f727420746f206578636c756465206f72206c696d69742c20697473206c696162696c6974792e3c2f6c693e0d0a3c2f756c3e0d0a3c68333e526561736f6e61626c656e6573733c2f68333e0d0a3c703e4279207573696e67207468697320776562736974652c20796f75206167726565207468617420746865206578636c7573696f6e7320616e64206c696d69746174696f6e73206f66206c696162696c69747920736574206f757420696e2074686973207765627369746520646973636c61696d65722061726520726561736f6e61626c652e3c2f703e0d0a3c703e496620796f7520646f206e6f74207468696e6b20746865792061726520726561736f6e61626c652c20796f75206d757374206e6f7420757365207468697320776562736974652e3c2f703e0d0a3c68333e4f7468657220706172746965733c2f68333e0d0a3c703e596f752061636365707420746861742c2061732061206c696d69746564206c696162696c69747920656e746974792c206f6e6c696e6534646174696e672e636f6d2068617320616e20696e74657265737420696e206c696d6974696e672074686520706572736f6e616c206c696162696c697479206f6620697473206f6666696365727320616e6420656d706c6f796565732e20596f75206167726565207468617420796f752077696c6c206e6f74206272696e6720616e7920636c61696d20706572736f6e616c6c7920616761696e7374206f6e6c696e6534646174696e672e636f6d2773206f66666963657273206f7220656d706c6f7965657320696e2072657370656374206f6620616e79206c6f7373657320796f752073756666657220696e20636f6e6e656374696f6e20776974682074686520776562736974652e3c2f703e0d0a3c703e576974686f7574207072656a756469636520746f2074686520666f7265676f696e67207061726167726170682c20796f75206167726565207468617420746865206c696d69746174696f6e73206f662077617272616e7469657320616e64206c696162696c69747920736574206f757420696e2074686973207765627369746520646973636c61696d65722077696c6c2070726f74656374206f6e6c696e6534646174696e672e636f6d2773206f666669636572732c20656d706c6f796565732c206167656e74732c207375627369646961726965732c20737563636573736f72732c2061737369676e7320616e64207375622d636f6e74726163746f72732061732077656c6c206173206f6e6c696e6534646174696e672e636f6d2e203c2f703e0d0a3c68333e556e656e666f72636561626c652070726f766973696f6e733c2f68333e0d0a3c703e496620616e792070726f766973696f6e206f662074686973207765627369746520646973636c61696d65722069732c206f7220697320666f756e6420746f2062652c20756e656e666f72636561626c6520756e646572206170706c696361626c65206c61772c20746861742077696c6c206e6f74206166666563742074686520656e666f7263656162696c697479206f6620746865206f746865722070726f766973696f6e73206f662074686973207765627369746520646973636c61696d65722e3c2f703e0d0a3c68333e496e64656d6e6974793c2f68333e0d0a3c703e596f752068657265627920696e64656d6e696679206f6e6c696e6534646174696e672e636f6d20616e6420756e64657274616b6520746f206b656570206f6e6c696e6534646174696e672e636f6d20696e64656d6e696669656420616761696e737420616e79206c6f737365732c2064616d616765732c20636f7374732c206c696162696c697469657320616e6420657870656e7365732028696e636c7564696e6720776974686f7574206c696d69746174696f6e206c6567616c20657870656e73657320616e6420616e7920616d6f756e74732070616964206279206f6e6c696e6534646174696e672e636f6d20746f206120746869726420706172747920696e20736574746c656d656e74206f66206120636c61696d206f722064697370757465206f6e2074686520616476696365206f66206f6e6c696e6534646174696e672e636f6d27736c6567616c2061647669736572732920696e637572726564206f72207375666665726564206279206f6e6c696e6534646174696e672e636f6d2061726973696e67206f7574206f6620616e792062726561636820627920796f75206f6620616e792070726f766973696f6e206f66207468657365207465726d7320616e6420636f6e646974696f6e73206f722061726973696e67206f7574206f6620616e7920636c61696d207468617420796f75206861766520627265616368656420616e792070726f766973696f6e206f66207468657365207465726d7320616e6420636f6e646974696f6e732e3c2f703e0d0a3c68333e4272656163686573206f66207468657365207465726d7320616e6420636f6e646974696f6e733c2f68333e0d0a3c703e576974686f7574207072656a756469636520746f206f6e6c696e6534646174696e672e636f6d2773206f746865722072696768747320756e646572207468657365207465726d7320616e6420636f6e646974696f6e732c20696620796f7520627265616368207468657365207465726d7320616e6420636f6e646974696f6e7320696e20616e79207761792c206f6e6c696e6534646174696e672e636f6d206d61792074616b65207375636820616374696f6e206173206f6e6c696e6534646174696e672e636f6d206465656d7320617070726f70726961746520746f206465616c207769746820746865206272656163682c20696e636c7564696e672073757370656e64696e6720796f75722061636365737320746f2074686520776562736974652c2070726f6869626974696e6720796f752066726f6d20616363657373696e672074686520776562736974652c20626c6f636b696e6720636f6d707574657273207573696e6720796f757220495020616464726573732066726f6d20616363657373696e672074686520776562736974652c20636f6e74616374696e6720796f757220696e7465726e657420736572766963652070726f766964657220746f20726571756573742074686174207468657920626c6f636b20796f75722061636365737320746f20746865207765627369746520616e642f6f72206272696e67696e6720636f7572742070726f63656564696e677320616761696e737420796f752e3c2f703e0d0a3c68333e566172696174696f6e3c2f68333e0d0a3c703e6f6e6c696e6534646174696e672e636f6d206d617920726576697365207468657365207465726d7320616e6420636f6e646974696f6e732066726f6d2074696d652d746f2d74696d652e2052657669736564207465726d7320616e6420636f6e646974696f6e732077696c6c206170706c7920746f2074686520757365206f66207468697320776562736974652066726f6d207468652064617465206f6620746865207075626c69636174696f6e206f66207468652072657669736564207465726d7320616e6420636f6e646974696f6e73206f6e207468697320776562736974652e20506c6561736520636865636b2074686973207061676520726567756c61726c7920746f20656e7375726520796f75206172652066616d696c6961722077697468207468652063757272656e742076657273696f6e2e3c2f703e0d0a3c68333e41737369676e6d656e743c2f68333e0d0a3c703e6f6e6c696e6534646174696e672e636f6d206d6179207472616e736665722c207375622d636f6e7472616374206f72206f7468657277697365206465616c2077697468206f6e6c696e6534646174696e672e636f6d2072696768747320616e642f6f72206f626c69676174696f6e7320756e646572207468657365207465726d7320616e6420636f6e646974696f6e7320776974686f7574206e6f74696679696e6720796f75206f72206f627461696e696e6720796f757220636f6e73656e742e3c2f703e0d0a3c703e596f75206d6179206e6f74207472616e736665722c207375622d636f6e7472616374206f72206f7468657277697365206465616c207769746820796f75722072696768747320616e642f6f72206f626c69676174696f6e7320756e646572207468657365207465726d7320616e6420636f6e646974696f6e732e3c2f703e0d0a3c68333e53657665726162696c6974793c2f68333e0d0a3c703e496620612070726f766973696f6e206f66207468657365207465726d7320616e6420636f6e646974696f6e732069732064657465726d696e656420627920616e7920636f757274206f72206f7468657220636f6d706574656e7420617574686f7269747920746f20626520756e6c617766756c20616e642f6f7220756e656e666f72636561626c652c20746865206f746865722070726f766973696f6e732077696c6c20636f6e74696e756520696e206566666563742e20496620616e7920756e6c617766756c20616e642f6f7220756e656e666f72636561626c652070726f766973696f6e20776f756c64206265206c617766756c206f7220656e666f72636561626c652069662070617274206f6620697420776572652064656c657465642c207468617420706172742077696c6c206265206465656d656420746f2062652064656c657465642c20616e64207468652072657374206f66207468652070726f766973696f6e2077696c6c20636f6e74696e756520696e206566666563742e3c2f703e0d0a3c68333e456e746972652061677265656d656e743c2f68333e0d0a3c703e5468657365207465726d7320616e6420636f6e646974696f6e7320636f6e737469747574652074686520656e746972652061677265656d656e74206265747765656e20796f7520616e64206f6e6c696e6534646174696e672e636f6d20696e2072656c6174696f6e20746f20796f757220757365206f66207468697320776562736974652c20616e642073757065727365646520616c6c2070726576696f75732061677265656d656e747320696e2072657370656374206f6620796f757220757365206f66207468697320776562736974652e3c2f703e, NULL, 0),
(NULL, 66, 'en', 0x3c68313e536974656d6170204f6e6c696e6520446174696e673c2f68313e0d0a3c703e736974656d617020666f72206f6e6c696e6534646174696e672e6e6574206f6e65206f6620746865206f6e6c792066726565206f6e6c696e6520646174696e67206e6574776f726b733c2f703e0d0a3c68333e536974656d6170206f6e6c696e6534646174696e672e6e65743c2f68333e, NULL, 0),
(NULL, 69, 'en', 0x3c68313e496d7072657373756d3c2f68313e0d0a3c703e486572652069732074686520696e666f726d6174696f6e2061626f757420746865206f776e6572206f66206f6e6c696e6534646174696e672e6e65743c2f703e0d0a3c68333e436f6d70616e793c2f68333e0d0a3c7461626c653e3c74626f64793e3c74723e3c74643e4e616d653a0d0a3c2f74643e3c74643e0d0a76626d73636f64650d0a3c2f74643e3c2f74723e3c74723e3c74643e0d0a416464726573733a0d0a3c2f74643e3c74643e0d0a4b616e747374722e2031362c203830383037204dfc6e6368656e0d0a3c2f74643e3c2f74723e3c74723e3c74643e0d0a452d4d61696c3a0d0a3c2f74643e3c74643e0d0a73696c6b7966785b61745d686f746d61696c5b646f745d64650d0a3c2f74643e3c2f74723e3c74723e3c74643e0d0a576562736974653a0d0a3c2f74643e3c74643e0d0a3c6120687265663d22687474703a2f2f76626d73636f64652e636f6d223e76626d73636f64652e636f6d3c2f613e0d0a3c2f74643e3c2f74723e3c2f74626f64793e3c2f7461626c653e0d0a3c68333e496e666f3c2f68333e0d0a3c7461626c653e3c74626f64793e3c74723e3c74643e4e616d653a0d0a3c2f74643e3c74643e0d0a53696c766573746572204dfc686c686175730d0a3c2f74643e3c2f74723e3c74723e3c74643e0d0a416464726573733a0d0a3c2f74643e3c74643e0d0a4b616e747374722e2031362c203830383037204dfc6e6368656e0d0a3c2f74643e3c2f74723e3c74723e3c74643e0d0a452d4d61696c3a0d0a3c2f74643e3c74643e0d0a73696c6b7966785b61745d686f746d61696c5b646f745d64650d0a3c2f74643e3c2f74723e3c74723e3c74643e0d0a44617465206f662062697274683a0d0a3c2f74643e3c74643e0d0a31332e322e313938360d0a3c2f74643e3c2f74723e3c74723e3c74643e0d0a506c616365206f722062697274683a0d0a3c2f74643e3c74643e0d0a43617374656c6c61722c20537061696e0d0a3c2f74643e3c2f74723e3c74723e3c74643e0d0a576562736974653a0d0a3c2f74643e3c74643e0d0a3c6120687265663d22687474703a2f2f76626d73636f64652e636f6d223e76626d73636f64652e636f6d3c2f613e0d0a3c2f74643e3c2f74723e3c2f74626f64793e3c2f7461626c653e, NULL, 0),
(NULL, 70, 'en', 0x3c703e0d0a496620796f75207265717569726520616e79206d6f726520696e666f726d6174696f6e20726567617264696e6720737562207061676573206f66207468697320776562736974652c20646f6e277420686573697461746520746f20636f6e746163742075732076696120746865200d0a3c6120687265663d223f6e3d436f6e7461637426616d703b703d3235223e636f6e7461637420666f726d3c2f613e2e0d0a3c2f703e, NULL, 0),
(NULL, 74, 'en', 0x3c68313e526567697374657220557365723c2f68313e0d0a3c703e546f2066696e69736820726567697374726174696f6e20736f6d6520657874726120696e666f726d6174696f6e2069732072657175697265642e20546865207072697661746520696e666f726d6174696f6e2077696c6c206e6f742062652076697369626c6520746f206f746865722075736572732e20596f7572207265736964656e6365206c6f636174696f6e20697320726571756972656420736f207468617420697420697320706f737369626c6520666f7220757365727320746f2066696e64206f746865722075736572732077686f206c69766520636c6f73652062792e20596f75722061637475616c20616464726573732077696c6c206e6f74206265207075626c69736865642e20596f752063616e206f6e6c7920636f6d706c65746520726567697374726174696f6e206f6e636520796f7520686176652066696c6c6564206f75742065616368206669656c6420616e6420616363657074656420746865207573616765207465726d732e3c2f703e, NULL, 0),
(NULL, 79, 'en', 0x3c68313e4c6f67696e3c2f68313e0d0a3c703e596f75206e65656420746f206c6f67696e20746f20757365207468697320666561747572652e206f6e6c696e6534646174696e672e6e6574206973206f6e65206f6620746865206f6e6c792066726565206f6e6c696e6520646174696e67206e6574776f726b732e20596f752063616e203c6120687265663d22687474703a2f2f6f6e6c696e6534646174696e672e6e65743f7374617469633d7265676973746572223e72656769737465723c2f613e20666f722066726565206f72206c6f67696e20776974682061206e6574776f726b206c696b652066616365626f6f6b206f7220676f6f676c652e3c2f703e0d0a3c68333e52656769737465723c2f68333e0d0a3c703e506c65617365203c6120687265663d22687474703a2f2f6f6e6c696e6534646174696e672e6e65743f7374617469633d7265676973746572223e72656769737465723c2f613e20666f7220696e7374616e742066726565206f6e6c696e6520646174696e672e2054656c6c206f746865722070656f706c6520746f206a6f696e2074686520636f6d6d756e69747920736f2069742067726f77732e3c2f703e, NULL, 0),
(NULL, 83, 'en', 0x3c68313e4c6f67696e3c2f68313e0d0a3c703e596f75206e65656420746f206c6f67696e20746f20757365207468697320666561747572652e206f6e6c696e6534646174696e672e6e6574206973206f6e65206f6620746865206f6e6c792066726565206f6e6c696e6520646174696e67206e6574776f726b732e20596f752063616e203c6120687265663d22687474703a2f2f6f6e6c696e6534646174696e672e6e65743f7374617469633d7265676973746572223e72656769737465723c2f613e20666f722066726565206f72206c6f67696e20776974682061206e6574776f726b206c696b652066616365626f6f6b206f7220676f6f676c652e3c2f703e0d0a3c68333e52656769737465723c2f68333e0d0a3c703e506c65617365203c6120687265663d22687474703a2f2f6f6e6c696e6534646174696e672e6e65743f7374617469633d7265676973746572223e72656769737465723c2f613e20666f7220696e7374616e742066726565206f6e6c696e6520646174696e672e2054656c6c206f746865722070656f706c6520746f206a6f696e2074686520636f6d6d756e69747920736f2069742067726f77732e3c2f703e, NULL, 0),
(NULL, 96, 'en', 0x3c68313e4c6f676f75743c2f68313e0d0a3c703e4c6f676f7574207768656e2066696e6e6973686564207573696e6720796f7572206163636f756e7420746f206b65657020796f7572206163636f756e7420736166652e3c2f703e, NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ajax_chat_bans`
--
ALTER TABLE `ajax_chat_bans`
 ADD PRIMARY KEY (`userID`), ADD KEY `userName` (`userName`), ADD KEY `dateTime` (`dateTime`);

--
-- Indexes for table `ajax_chat_invitations`
--
ALTER TABLE `ajax_chat_invitations`
 ADD PRIMARY KEY (`userID`,`channel`), ADD KEY `dateTime` (`dateTime`);

--
-- Indexes for table `ajax_chat_messages`
--
ALTER TABLE `ajax_chat_messages`
 ADD PRIMARY KEY (`id`), ADD KEY `message_condition` (`id`,`channel`,`dateTime`), ADD KEY `dateTime` (`dateTime`);

--
-- Indexes for table `ajax_chat_online`
--
ALTER TABLE `ajax_chat_online`
 ADD PRIMARY KEY (`userID`), ADD KEY `userName` (`userName`);

--
-- Indexes for table `t_backup`
--
ALTER TABLE `t_backup`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_cms_customer`
--
ALTER TABLE `t_cms_customer`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_code`
--
ALTER TABLE `t_code`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_comment`
--
ALTER TABLE `t_comment`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_confirm`
--
ALTER TABLE `t_confirm`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_domain`
--
ALTER TABLE `t_domain`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_email`
--
ALTER TABLE `t_email`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `t_event`
--
ALTER TABLE `t_event`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_forum_post`
--
ALTER TABLE `t_forum_post`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_forum_thread`
--
ALTER TABLE `t_forum_thread`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_forum_topic`
--
ALTER TABLE `t_forum_topic`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_gallery_category`
--
ALTER TABLE `t_gallery_category`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_gallery_image`
--
ALTER TABLE `t_gallery_image`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_gallery_page`
--
ALTER TABLE `t_gallery_page`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_language`
--
ALTER TABLE `t_language`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_menu`
--
ALTER TABLE `t_menu`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_menu_instance`
--
ALTER TABLE `t_menu_instance`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_menu_style`
--
ALTER TABLE `t_menu_style`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_module`
--
ALTER TABLE `t_module`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_module_category`
--
ALTER TABLE `t_module_category`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_module_instance`
--
ALTER TABLE `t_module_instance`
 ADD PRIMARY KEY (`id`,`moduleid`);

--
-- Indexes for table `t_module_roles`
--
ALTER TABLE `t_module_roles`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_newsletter`
--
ALTER TABLE `t_newsletter`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_newsletter_email`
--
ALTER TABLE `t_newsletter_email`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_newsletter_emailgroup`
--
ALTER TABLE `t_newsletter_emailgroup`
 ADD PRIMARY KEY (`emailid`);

--
-- Indexes for table `t_order`
--
ALTER TABLE `t_order`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_order_attribute`
--
ALTER TABLE `t_order_attribute`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_order_product`
--
ALTER TABLE `t_order_product`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_page`
--
ALTER TABLE `t_page`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_page_roles`
--
ALTER TABLE `t_page_roles`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_product`
--
ALTER TABLE `t_product`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_product_group`
--
ALTER TABLE `t_product_group`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_roles`
--
ALTER TABLE `t_roles`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_roles_custom`
--
ALTER TABLE `t_roles_custom`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_site`
--
ALTER TABLE `t_site`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_site_module`
--
ALTER TABLE `t_site_module`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_site_template`
--
ALTER TABLE `t_site_template`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_social_notifications`
--
ALTER TABLE `t_social_notifications`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_template`
--
ALTER TABLE `t_template`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_templatearea`
--
ALTER TABLE `t_templatearea`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_user`
--
ALTER TABLE `t_user`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_user_address`
--
ALTER TABLE `t_user_address`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_user_friend`
--
ALTER TABLE `t_user_friend`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_user_message`
--
ALTER TABLE `t_user_message`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_user_wall_event`
--
ALTER TABLE `t_user_wall_event`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_user_wall_post`
--
ALTER TABLE `t_user_wall_post`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_vdb_column`
--
ALTER TABLE `t_vdb_column`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_vdb_object`
--
ALTER TABLE `t_vdb_object`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_vdb_table`
--
ALTER TABLE `t_vdb_table`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `t_vdb_value`
--
ALTER TABLE `t_vdb_value`
 ADD KEY `objectid` (`objectid`), ADD KEY `columnid` (`columnid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ajax_chat_messages`
--
ALTER TABLE `ajax_chat_messages`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_backup`
--
ALTER TABLE `t_backup`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_cms_customer`
--
ALTER TABLE `t_cms_customer`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_code`
--
ALTER TABLE `t_code`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=56;
--
-- AUTO_INCREMENT for table `t_comment`
--
ALTER TABLE `t_comment`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_confirm`
--
ALTER TABLE `t_confirm`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_domain`
--
ALTER TABLE `t_domain`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `t_email`
--
ALTER TABLE `t_email`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_event`
--
ALTER TABLE `t_event`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_forum_post`
--
ALTER TABLE `t_forum_post`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_forum_thread`
--
ALTER TABLE `t_forum_thread`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_forum_topic`
--
ALTER TABLE `t_forum_topic`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_gallery_category`
--
ALTER TABLE `t_gallery_category`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_gallery_image`
--
ALTER TABLE `t_gallery_image`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_gallery_page`
--
ALTER TABLE `t_gallery_page`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_language`
--
ALTER TABLE `t_language`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `t_menu`
--
ALTER TABLE `t_menu`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `t_menu_instance`
--
ALTER TABLE `t_menu_instance`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `t_menu_style`
--
ALTER TABLE `t_menu_style`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `t_module`
--
ALTER TABLE `t_module`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=100;
--
-- AUTO_INCREMENT for table `t_module_category`
--
ALTER TABLE `t_module_category`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_module_instance`
--
ALTER TABLE `t_module_instance`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=101;
--
-- AUTO_INCREMENT for table `t_module_roles`
--
ALTER TABLE `t_module_roles`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2080;
--
-- AUTO_INCREMENT for table `t_newsletter`
--
ALTER TABLE `t_newsletter`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `t_newsletter_email`
--
ALTER TABLE `t_newsletter_email`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_newsletter_emailgroup`
--
ALTER TABLE `t_newsletter_emailgroup`
MODIFY `emailid` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_order`
--
ALTER TABLE `t_order`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_order_attribute`
--
ALTER TABLE `t_order_attribute`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_order_product`
--
ALTER TABLE `t_order_product`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_page`
--
ALTER TABLE `t_page`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=56;
--
-- AUTO_INCREMENT for table `t_page_roles`
--
ALTER TABLE `t_page_roles`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=384;
--
-- AUTO_INCREMENT for table `t_product`
--
ALTER TABLE `t_product`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_product_group`
--
ALTER TABLE `t_product_group`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_roles`
--
ALTER TABLE `t_roles`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_roles_custom`
--
ALTER TABLE `t_roles_custom`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `t_site`
--
ALTER TABLE `t_site`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_site_module`
--
ALTER TABLE `t_site_module`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_site_template`
--
ALTER TABLE `t_site_template`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_social_notifications`
--
ALTER TABLE `t_social_notifications`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `t_template`
--
ALTER TABLE `t_template`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `t_templatearea`
--
ALTER TABLE `t_templatearea`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=101;
--
-- AUTO_INCREMENT for table `t_user`
--
ALTER TABLE `t_user`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_user_address`
--
ALTER TABLE `t_user_address`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_user_friend`
--
ALTER TABLE `t_user_friend`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_user_message`
--
ALTER TABLE `t_user_message`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_user_wall_event`
--
ALTER TABLE `t_user_wall_event`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_user_wall_post`
--
ALTER TABLE `t_user_wall_post`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_vdb_column`
--
ALTER TABLE `t_vdb_column`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=56;
--
-- AUTO_INCREMENT for table `t_vdb_object`
--
ALTER TABLE `t_vdb_object`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_vdb_table`
--
ALTER TABLE `t_vdb_table`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
; */ 
?>
