-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 02, 2015 at 07:25 AM
-- Server version: 5.5.40-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `vbmscms`
--

-- --------------------------------------------------------

--
-- Table structure for table `ajax_chat_bans`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Dumping data for table `ajax_chat_messages`
--

INSERT INTO `ajax_chat_messages` (`id`, `userID`, `userName`, `userRole`, `channel`, `dateTime`, `ip`, `text`) VALUES
(1, 2147483647, 'ChatBot', 4, 0, '2015-02-27 14:17:56', '\0\0', '/login vbms'),
(2, 1, 'vbms', 3, 0, '2015-02-27 14:18:24', '\0\0', 'the');

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

--
-- Dumping data for table `ajax_chat_online`
--

INSERT INTO `ajax_chat_online` (`userID`, `userName`, `userRole`, `channel`, `dateTime`, `ip`) VALUES
(1, 'vbms', 3, 0, '2015-02-27 14:18:49', '\0\0');

-- --------------------------------------------------------

--
-- Table structure for table `piwik_access`
--

CREATE TABLE IF NOT EXISTS `piwik_access` (
  `login` varchar(100) NOT NULL,
  `idsite` int(10) unsigned NOT NULL,
  `access` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`login`,`idsite`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `piwik_goal`
--

CREATE TABLE IF NOT EXISTS `piwik_goal` (
  `idsite` int(11) NOT NULL,
  `idgoal` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `match_attribute` varchar(20) NOT NULL,
  `pattern` varchar(255) NOT NULL,
  `pattern_type` varchar(10) NOT NULL,
  `case_sensitive` tinyint(4) NOT NULL,
  `allow_multiple` tinyint(4) NOT NULL,
  `revenue` float NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idsite`,`idgoal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `piwik_logger_api_call`
--

CREATE TABLE IF NOT EXISTS `piwik_logger_api_call` (
  `idlogger_api_call` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `class_name` varchar(255) DEFAULT NULL,
  `method_name` varchar(255) DEFAULT NULL,
  `parameter_names_default_values` text,
  `parameter_values` text,
  `execution_time` float DEFAULT NULL,
  `caller_ip` varbinary(16) NOT NULL,
  `timestamp` timestamp NULL DEFAULT NULL,
  `returned_value` text,
  PRIMARY KEY (`idlogger_api_call`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `piwik_logger_error`
--

CREATE TABLE IF NOT EXISTS `piwik_logger_error` (
  `idlogger_error` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `timestamp` timestamp NULL DEFAULT NULL,
  `message` text,
  `errno` int(10) unsigned DEFAULT NULL,
  `errline` int(10) unsigned DEFAULT NULL,
  `errfile` varchar(255) DEFAULT NULL,
  `backtrace` text,
  PRIMARY KEY (`idlogger_error`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `piwik_logger_exception`
--

CREATE TABLE IF NOT EXISTS `piwik_logger_exception` (
  `idlogger_exception` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `timestamp` timestamp NULL DEFAULT NULL,
  `message` text,
  `errno` int(10) unsigned DEFAULT NULL,
  `errline` int(10) unsigned DEFAULT NULL,
  `errfile` varchar(255) DEFAULT NULL,
  `backtrace` text,
  PRIMARY KEY (`idlogger_exception`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `piwik_logger_message`
--

CREATE TABLE IF NOT EXISTS `piwik_logger_message` (
  `idlogger_message` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `timestamp` timestamp NULL DEFAULT NULL,
  `message` text,
  PRIMARY KEY (`idlogger_message`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `piwik_log_action`
--

CREATE TABLE IF NOT EXISTS `piwik_log_action` (
  `idaction` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` text,
  `hash` int(10) unsigned NOT NULL,
  `type` tinyint(3) unsigned DEFAULT NULL,
  `url_prefix` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`idaction`),
  KEY `index_type_hash` (`type`,`hash`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=410 ;

--
-- Dumping data for table `piwik_log_action`
--

INSERT INTO `piwik_log_action` (`idaction`, `name`, `hash`, `type`, `url_prefix`) VALUES
(1, 'login', 2852702992, 4, NULL),
(2, 'makeufo.de/?action=printInstallingView&session=nodb', 2295402921, 1, 0),
(3, 'Online Dating', 1537816587, 4, NULL),
(4, 'makeufo.de/?c=dJjxR%2F46XGs9Ngx0GitdZtyWqjtTCk', 3378537563, 1, 0),
(5, 'adminPages', 2626238602, 4, NULL),
(6, 'makeufo.de/?c=9xM0XbGoc6Sqz1zV20RSDhyfzx4Yr%2B', 332279631, 1, 0),
(7, 'makeufo.de/?c=yZuxKc4UfKjUXD7Loi8kpJbkieaEQw', 3615915838, 1, 0),
(8, 'makeufo.de/?c=loBGKfOtkFeySMlxSli%2BG5yCfwGV9v', 3887726532, 1, 0),
(9, 'makeufo.de/?c=PXopbbPe8gLmr%2FZlVwvRrShAI97Pfz', 3014670174, 1, 0),
(10, 'makeufo.de/?c=iH82dY1%2BsCynIF4EYK4NUyFvgRMbF7', 1280842974, 1, 0),
(11, 'adminTemplates', 1471790411, 4, NULL),
(12, 'makeufo.de/?c=VOMD2KFtambuc2LPSytEepTBqVgvHW&adminTemplateId=5&id=5', 3933780093, 1, 0),
(13, 'makeufo.de/?c=uBUhkU6lhZ524p%2BP0Jgo85Z2qsrb3v&adminTemplateId=4&id=4', 478410237, 1, 0),
(14, 'makeufo.de/?c=EN9eQxj%2BKaFpQM6%2Bcg9HT7TiYJPQRx', 1619079659, 1, 0),
(15, 'makeufo.de/?c=0phPczMbC87TCrT%2BVnaPrLdy1rHZdV', 3950152882, 1, 0),
(16, 'makeufo.de/?c=o7rKmqsF1CY2PkG1pNAk%2BeINoxKjIl', 595822508, 1, 0),
(17, 'makeufo.de/?c=4FC8elnWBiNa%2FfnmSHCpDmxgX8dfOB', 258022592, 1, 0),
(18, 'makeufo.de/?c=7W8rPUn2uqeVrEBOpslkidjY2jtErg', 3273573750, 1, 0),
(19, 'makeufo.de/?c=fn03lc7%2BboTOSEu%2Bdre4Io1jXyWsJy', 1729702477, 1, 0),
(20, 'makeufo.de/?c=wP59F76ts7W5Q%2B50wpYdwYltVbyspL&adminTemplateId=4&id=4', 58314035, 1, 0),
(21, 'makeufo.de/?c=vBUHG8MlB1gRpSoGwxmJhoNBfHXgQ0&adminTemplateId=2&id=2', 1465937888, 1, 0),
(22, 'makeufo.de/?c=c%2FImUrQZvHk8mb3IkYOw%2F%2F%2FFNpZA5p', 3345868927, 1, 0),
(23, 'makeufo.de/?c=QAwLAwrkuBfFgKYsDu83RNG%2FwVOHMl', 1509989878, 1, 0),
(24, 'makeufo.de/?c=W4vXh2s8ni%2BgX0O%2FYmpbhfyjfUGXf%2B', 896093077, 1, 0),
(25, 'makeufo.de/?c=J6iyw1tz1d7JTgUU2XfKf%2FEcAxHjYr&adminTemplateId=3&id=3', 2832600171, 1, 0),
(26, 'makeufo.de/?c=k080StlD2%2FGsVQGjjYrh1jAnL%2FV1BF&adminTemplateId=2&id=2', 2382564408, 1, 0),
(27, 'makeufo.de/?c=rv8jgJSatS5aXsfem1WTWuQpDDNRpR', 1586209354, 1, 0),
(28, 'makeufo.de/?n=Profile&p=9', 83765735, 1, 0),
(29, 'makeufo.de/?n=Profile&p=9&testset', 1349976557, 1, 0),
(30, 'makeufo.de/?c=2NYx16Ii194OlUMme%2BUcdrh82s7ALv', 647514391, 1, 0),
(31, 'makeufo.de/?c=QRO%2BhEq09Rfp%2B8duT%2BUvUxSxI3aR7s', 2720178668, 1, 0),
(32, 'makeufo.de/?c=Y8GKlx4jhSuAtZ8OPgGQ7YptMpNOiy', 3946368478, 1, 0),
(33, 'makeufo.de/?c=GYkXrXdhogLRhgfqbwdSQeTY03W4q%2B', 1204952548, 1, 0),
(34, 'makeufo.de/?c=2CG2%2B5MOiBeDb97HE06zVSgAp2RiHD', 4073538188, 1, 0),
(35, 'makeufo.de/?c=WFYwjvLPBjXvUAzyiBZEXTb00gOZw2&adminTemplateId=2&id=2', 1058497954, 1, 0),
(36, 'makeufo.de/?c=YQsBxskEf0tk%2B88m7ImHZnse3e0mGk&adminTemplateId=2&id=2', 4102851880, 1, 0),
(37, 'makeufo.de/?c=KWA7JqBvDWMdbUIMrNcVmXzLtRz1k8&adminTemplateId=3&id=3', 1370183261, 1, 0),
(38, 'makeufo.de/?c=0tA01QNuHoWta9o1lf8mS43bsfGtxl', 1906921605, 1, 0),
(39, 'makeufo.de/?c=ZmTN8OsybyQPHxdc921HlF2wBxrjMA&adminTemplateId=2&id=2', 2747967622, 1, 0),
(40, 'makeufo.de/?c=YBSlosEkiA1kTgez1omsKiic22ZHYl&adminTemplateId=3&id=3', 208745179, 1, 0),
(41, 'makeufo.de/?c=ihdF4XLF78S%2F8NKW9gTcz9%2B%2BGnEWji', 393608665, 1, 0),
(42, 'makeufo.de/?c=4EH9FwuekcjmPDGOae2hQW4NdG69p0&adminTemplateId=2&id=2', 3986987423, 1, 0),
(43, 'makeufo.de/?c=aaMjw3l%2BueOte6YSN1l%2BPXxUOCuyVc&adminTemplateId=4&id=4', 974278096, 1, 0),
(44, 'makeufo.de/?c=RgrezxKtQth%2BcGuUOLc8Hoz6pfa393', 1048711333, 1, 0),
(45, 'makeufo.de/?c=KvAyNcDnxpZgc58CcQfBq8wN%2BZxHjd&adminTemplateId=5&id=5', 2012013941, 1, 0),
(46, 'makeufo.de/?c=TN8%2F00RG%2FPYGfjhcL7iNCpAH1mmZM9', 4246121557, 1, 0),
(47, 'makeufo.de/?c=F19eQLcV6xc5Z%2F1KSD2J7vmO8mbsHW&adminTemplateId=2&id=2', 2168836559, 1, 0),
(48, 'makeufo.de/?c=M1XY%2Bv4vCGwKCSD4dGyHXrAmQkbyGW&adminTemplateId=4&id=4', 3903829871, 1, 0),
(49, 'makeufo.de/?c=f8feKxtHwX%2BuqRrqMrkL3jPFfWO82V', 1928812136, 1, 0),
(50, 'makeufo.de/?c=Urp0HSo0%2BbLaHAJEik6GfosH3dXNaZ', 2289753751, 1, 0),
(51, 'makeufo.de/?c=NgXI9CZak%2B7XNIJNjyEpRd%2F3i%2FnEJg&adminTemplateId=5&id=5', 1672362289, 1, 0),
(52, 'makeufo.de/?c=Udx5fA2avBrMy%2BZvavPsPdl78%2BkA5O', 565754038, 1, 0),
(53, 'makeufo.de/?c=dCqvNIOdiE5DI%2F4GZNEYmDzCCUGZgF&adminTemplateId=4&id=4', 2248446917, 1, 0),
(54, 'makeufo.de/?c=%2FF9DZRnST37hJavYB3Elyu77CgMWRy&adminTemplateId=3&id=3', 82544076, 1, 0),
(55, 'makeufo.de/?c=mCB75i%2BTolsafdJPaXHz8nSFAUCiPt', 309872426, 1, 0),
(56, 'makeufo.de/?c=vKcllFTIBu54baiSa7t6lRAEB9kT02', 2547173712, 1, 0),
(57, 'makeufo.de/?n=Login&p=30', 2999113362, 1, 0),
(58, 'makeufo.de/?c=QAwLxQif2qzM64x9I25e8v2MTG8O5s', 2018089634, 1, 0),
(59, 'makeufo.de/?n=Online+Dating&p=8', 1429833246, 1, 0),
(60, 'makeufo.de/?c=j3cPlssPwcpmuZ6KVNp1dYETi8CcZa', 3082343882, 1, 0),
(61, 'makeufo.de/?c=6XGIJYFSoN5%2Bo1bYzNqPainyUcz6cF', 1895549441, 1, 0),
(62, 'makeufo.de/?c=p7R6fuV3NMcbh%2FSGuYiY5K36sOqAFF', 2583119110, 1, 0),
(63, 'makeufo.de/?c=NmozvMkgVXL1XFX11L7EUIj9EEMGuu', 1200311203, 1, 0),
(64, 'makeufo.de/?c=F7bqSKzvvWuEMzcQRHvgM932tvFHdJ', 3496085637, 1, 0),
(65, 'makeufo.de/?c=fw13z0bj%2BbZZ4Apr6ZKEE7Aqc1WECE', 3058573721, 1, 0),
(66, 'makeufo.de/?c=AX5WYHgXboQYKpun2DStX9c0X6BH5f', 451727343, 1, 0),
(67, 'makeufo.de/?c=VwscUcE1ah2aOhN3mwZoPKlWNVwSND&adminTemplateId=2&id=2', 1512226596, 1, 0),
(68, 'makeufo.de/?c=MejJdUxFF75HoxZ4yzeotS4pACqOZ%2F&adminTemplateId=4&id=4', 2425981872, 1, 0),
(69, 'makeufo.de/?c=3DpsZI9Mazc2O9YI1hSVD0ZASk61b6', 250675779, 1, 0),
(70, 'makeufo.de/?c=FUtfZaG8taWMhzUTcrEv0dyF6y%2BL89', 2103363908, 1, 0),
(71, 'makeufo.de/?c=1EPdp2kocwXT8q9BcUOlofLcVduq85', 1790022905, 1, 0),
(72, 'makeufo.de/?c=jJzohYW%2Fg5F3Zm1TE1EiENaRVPQDhN', 959706366, 1, 0),
(73, 'makeufo.de/?c=hH6EcqbLMBIR84nYx9GkBq6nN%2BwgTy', 1606244809, 1, 0),
(74, 'makeufo.de/?c=lgaUsbfeQijX4WCL4xyIbglzbAUmkG', 3398386035, 1, 0),
(75, 'makeufo.de/?c=7U0T0cTwCGOk1yQ%2BLkmK%2FWPfLQm2m5', 4087822929, 1, 0),
(76, 'makeufo.de/?c=p7dpq8WvpgsGZcHLFUDmXdgi0BSZB5', 383243583, 1, 0),
(77, 'makeufo.de/?c=bUXlXDUMR3FCQkovbAYWrH%2BBQC7gCR', 1147680658, 1, 0),
(78, 'makeufo.de/?c=ibTK6apTUQcTk8Ssl41akvuFatMXV3', 1359259714, 1, 0),
(79, 'makeufo.de/?c=ctjJxK6iBXq5mYLUmZTACXUc91M1TN&adminTemplateId=4&id=4', 2129662481, 1, 0),
(80, 'makeufo.de/?c=FQWXdkEgjQVX4%2F85t%2BjZ7idqdagAU1', 1919258606, 1, 0),
(81, 'makeufo.de/?c=LS2N5tv1h5AZZ1JDsWiyN3oX5RQCTs', 1834092567, 1, 0),
(82, 'makeufo.de/?c=N%2F%2FBoLSpxM%2F8dUljhYnKNiycwUlgO3', 3908235708, 1, 0),
(83, 'makeufo.de/', 1328045606, 1, 0),
(84, 'makeufo.de/?c=pgr7Jf2mejAlX6SFf8riBerP0hx%2Bip', 1750512810, 1, 0),
(85, 'makeufo.de/?c=2RY7RO%2BKw%2FiCFquz36Bm14fK7dMeS1', 3063940392, 1, 0),
(86, 'makeufo.de/?c=1hK4ZkOqraCa7e%2BSw6jV201jwc1AB1', 3791631581, 1, 0),
(87, 'makeufo.de/?c=RUAcnC8y%2Fa1NLL7nSY7PBGUuj4ECH5', 128992003, 1, 0),
(88, 'makeufo.de/?c=beIwrxIWsUB3RWSiezXW53bXU2kQSh', 314758978, 1, 0),
(89, 'makeufo.de/?c=mNQtDkwHLRkCZa7n3wKS9mJIY%2F7gF7', 1165968895, 1, 0),
(90, 'adminDomains', 3879555195, 4, NULL),
(91, 'makeufo.de/?c=YnpFKMxt3YwjTTqxTSKtVJJLWobsLZ', 3879282201, 1, 0),
(92, 'makeufo.de/?c=CjjhnemgZidE2KYf95mzcPxuJPBHoU', 3254242425, 1, 0),
(93, 'makeufo.de/?c=QtfethO9c%2Bb8NmFUrOB6VxjSCcdWzp', 2671890985, 1, 0),
(94, 'makeufo.de/?c=XLPshTlopt%2FMK1UI5jvy5aNlMFuxNY', 3541776556, 1, 0),
(95, 'makeufo.de/?c=JcSpYC6itddz0LzY6%2BiWhLI6w0X6ci', 634584129, 1, 0),
(96, 'makeufo.de/?c=1tMHxujIVWw7lWpTjEVs8NrKZY%2BOhK', 4023318448, 1, 0),
(97, 'makeufo.de/?c=h4biYzHlTK0GBvSo4iweJm4TWkNVXz', 1789323178, 1, 0),
(98, 'makeufo.de/?c=0GJ0qjR9mxzzey1qoClUart8CRtQVm', 955104772, 1, 0),
(99, 'makeufo.de/?c=D5IILsHBcaSDApiigJwkTZAJI%2F4G33', 1332150555, 1, 0),
(100, 'gpinboard.com/', 4168487032, 1, 0),
(101, 'gpinboard.com/?c=WaVNo7EM%2FMRC%2B3qw13v4l6iQcFtUGa', 1062648386, 1, 0),
(102, 'gpinboard.com/?c=cmKHw5Ym8XaOA5sRcHpqfiIjKPTUy2', 3043499827, 1, 0),
(103, 'gpinboard.com/?c=sx6eKOe9fCHMCXZM96x9SaZo3SvRfg', 1632602188, 1, 0),
(104, 'gpinboard.com/?c=yY16bC6miX1k08F1%2Fa1vwako%2B7GRBi', 1617867642, 1, 0),
(105, 'gpinboard.com/?c=1CqCqEpzp%2BWhQvaKZIF40P1nJ%2Bmhpl', 1323625098, 1, 0),
(106, 'gpinboard.com/?c=LiPVhdSS2xaet5jCyeKR%2FkDckeWVTM', 3414334407, 1, 0),
(107, 'gpinboard.com/?c=OTXMfbAgpam9uAuKgSju339Tkjalux&adminTemplateId=4&id=4', 1977322564, 1, 0),
(108, 'gpinboard.com/?c=9x5645TslgtsllFrRT05ayjYvklJfD', 1476826594, 1, 0),
(109, 'gpinboard.com/?c=%2FSysetGcSd3v2amzruZadE%2BngkBRQU', 3408438293, 1, 0),
(110, 'gpinboard.com/?c=L6zl%2FAVQhISVqFqk5%2FlSNnnnF5JH1B', 1491945588, 1, 0),
(111, 'gpinboard.com/?c=l4D%2BZnKaj0Wbpzlvw6CUabSjc5Epu3', 3940175014, 1, 0),
(112, 'gpinboard.com/?c=i3gRGtUNB7NRJYUGCXFd7D14hiPCP4', 3900608359, 1, 0),
(113, 'gpinboard.com/?c=tPH4Kf%2BDhekkn2lmwdL2uNKm0EtDOZ', 3188418959, 1, 0),
(114, 'gpinboard.com/?c=d4NsgW1rJ89qLIzkhOrb%2FejJc7f0%2BB', 1571112447, 1, 0),
(115, 'gpinboard.com/?c=vmv%2BVpAXy4UBbARO1Uk9fZmX2jtKaW&adminPageId=8', 3187697697, 1, 0),
(116, 'gpinboard.com/?c=l0Qkl%2BfPGkmdvvKtclqjvIQkqfZPUy', 3975916837, 1, 0),
(117, 'gpinboard.com/?c=7h4KSPBkk6TkWRDZDTRcWECsklf2ke', 3015031632, 1, 0),
(118, 'gpinboard.com/?c=%2F%2FVeaxow3v3W8eQbJ3AIsX1O3r1eRf', 2687812516, 1, 0),
(119, 'gpinboard.com/?c=rEoifwfHySVJTOpQHhUR5vJ8CSmHUG', 1654191102, 1, 0),
(120, 'gpinboard.com/?c=XGX%2F61RGmlTpVmJjovvMe%2FC55TIis0', 337922479, 1, 0),
(121, 'gpinboard.com/?c=nQlGCbpr40XVM7hZKzSegbOzIpg61J', 2193324983, 1, 0),
(122, 'gpinboard.com/?c=FQEupBcqKaedtWsk61ilPd7iikjnxu', 103986734, 1, 0),
(123, 'gpinboard.com/?c=JbfA6l%2BnkIaGRfvyCaOzwyflMACwf3', 4208354483, 1, 0),
(124, 'gpinboard.com/?c=koLB8P%2By8X6HrGpDltaBeizjIch4vY', 1938657744, 1, 0),
(125, 'gpinboard.com/?c=gujtgVy1eyU1GEEzPG4NrTK3uN85mJ', 4009796420, 1, 0),
(126, 'gpinboard.com/?c=Kczv7s6jH8NMC68JaxaO9MWmRQ4DYw', 357677013, 1, 0),
(127, 'gpinboard.com/?c=Sd6OWgU7y5ppIMomsCMPkqujLPoaR3', 318578410, 1, 0),
(128, 'gpinboard.com/?c=EfW%2FWu0BrbcB3Hy%2BLqwXw71f2s2F9Y&adminTemplateId=2&id=2', 633530962, 1, 0),
(129, 'gpinboard.com/?c=nB3eAvOvyucTAGFhQyraN%2Bi90ugc0Z&adminTemplateId=4&id=4', 437356527, 1, 0),
(130, 'gpinboard.com/?c=IRBTYYfWvUFnOfI64E7j%2FoFr6yyEdR', 2585697809, 1, 0),
(131, 'gpinboard.com/?c=7dRXRe0%2FRrcPjyPiNaeTW3f4PJyN0s', 734932845, 1, 0),
(132, 'gpinboard.com/?c=iqdjkntI%2FtfkkssAX15Q6CZdm%2F4xJL', 1214262394, 1, 0),
(133, 'gpinboard.com/?c=1jR%2BT5H4mCDpxyVG78w5VVgrkjDOjQ', 714459702, 1, 0),
(134, 'gpinboard.com/?c=hdU3%2BlfWVTC%2BlAVHnSsXDhkyepgZI6', 106386674, 1, 0),
(135, 'gpinboard.com/?c=EnWklqD4pqS90pywBRm%2F%2BSCBJeE4Eb', 2929397733, 1, 0),
(136, 'gpinboard.com/?c=LMrHlT5EWnxTk4NHD4TWtCJWgLiKSj', 2949816018, 1, 0),
(137, 'gpinboard.com/?c=geklTRMOWk%2B9qCpVt2TqqVw3Ifnia9', 467013550, 1, 0),
(138, 'gpinboard.com/?c=%2FplQwgw5rMNO0gS4m8hINEkVISVbBY', 759059946, 1, 0),
(139, 'gpinboard.com/?c=MHGTl2N8MuTxTix%2FJ9Z4quBNTvYpdc', 4158357383, 1, 0),
(140, 'gpinboard.com/?c=aeX4iR2AOBkhoMM449UktzKnks9WBh', 2448380709, 1, 0),
(141, 'gpinboard.com/?c=Dk5UfwtHL4vCxtJIHuk94fFv2U77UM', 3269943082, 1, 0),
(142, 'gpinboard.com/?c=MEVGdCJVSBxOk6fPRXWyrUkIVAkGfp', 565365949, 1, 0),
(143, 'gpinboard.com/?c=1%2FVwWig7Qa6yGjsls350OkjFYXr4fc&adminTemplateId=4&id=4', 1458259740, 1, 0),
(144, 'gpinboard.com/?c=%2Bf7xyryn1Dx4Tw7ZrpoXCm%2FnEBr4jp', 2229252193, 1, 0),
(145, 'gpinboard.com/?c=%2FCFr8FXCWcIjd8hp9qTah%2FUAnQVFic', 28167941, 1, 0),
(146, 'gpinboard.com/?c=H70kHpa3EVlshWwEKgo4MXVISxODyA', 2361253491, 1, 0),
(147, 'Sitemap Online Dating', 2846307336, 4, NULL),
(148, 'gpinboard.com/?n=Sitemap&p=44', 3366720172, 1, 0),
(149, 'gpinboard.com/?c=jN1loqYAIEd7NPRlnrkEjBh9XoOlUr', 1460107582, 1, 0),
(150, 'gpinboard.com/?c=%2BDtNb9ZlrZMVPSXgGjdcx8hHIVr7wV', 1185716661, 1, 0),
(151, 'gpinboard.com/?c=yr27MT8X4sGCGy03H8nwkuE%2FRFd9mI&id=7', 218624921, 1, 0),
(152, 'gpinboard.com/?c=UeovMq65yaET0WIiFow8z2oeS5pIBr', 3785163452, 1, 0),
(153, 'gpinboard.com/?c=0skzycw46Nx%2Fj0LcaZDyPmNhkmUAvZ', 195173394, 1, 0),
(154, 'gpinboard.com/?c=wDFf1TfvblxwY1J8M0AIRMxvmRaPs7', 3065805323, 1, 0),
(155, 'gpinboard.com/?c=t8%2BXMSLtMS2RAWz3q41BtN1%2B5ln0Dy', 3848828405, 1, 0),
(156, 'gpinboard.com/?c=d5BZGk8x8U%2FHFe%2FuQKRYsUY2nug5TL', 686746214, 1, 0),
(157, 'gpinboard.com/?c=WpRHSwBf5qK7ckjSO2XYDo3N78MLNi', 487700108, 1, 0),
(158, 'gpinboard.com/?c=Rc82n5sUh878x%2FNPDZBqFn4iSlmR3M&id=8', 3879943025, 1, 0),
(159, 'gpinboard.com/?c=2iHiKXMibb9v%2FBxQYAIcj649uq%2FzpM&id=7', 1227215794, 1, 0),
(160, 'gpinboard.com/?n=Online+Dating&p=8', 1852120609, 1, 0),
(161, 'gpinboard.com/?c=vTR8NomZxMsegzf%2BVi5v7iwfL0U3Zy', 2811222609, 1, 0),
(162, 'gpinboard.com/?c=qDlxGWcn2z8root1RcZdssP17BEkVr', 1553277328, 1, 0),
(163, 'pageConfig', 1067399424, 4, NULL),
(164, 'gpinboard.com/?c=uN%2BZqY7ChmEtuMX%2BcObyVkW9Xp6H9s', 2169207676, 1, 0),
(165, 'gpinboard.com/?c=PitVviMSsytpsEA9PqXDB7sahUHjqp', 3384497856, 1, 0),
(166, 'gpinboard.com the global pinboard network', 617392273, 4, NULL),
(167, 'gpinboard.com/?n=Home&p=8', 4248957937, 1, 0),
(168, 'gpinboard.com/?c=3FXdPqElbrhFEBUFK%2F2mu25Iy4zcI7', 3444920618, 1, 0),
(169, 'gpinboard.com/?c=mSidCOHqwZS%2FVN9jDpSCm5GmtBHbL9', 855689001, 1, 0),
(170, 'gpinboard.com/?c=sg7Nnc7T1sFHsTJ1cCCMBK9C85U3bF&id=4', 3054590650, 1, 0),
(171, 'gpinboard.com/?c=%2Fn5jYgr9sPopmZaxeYExw7aIR7PQz3', 1090581151, 1, 0),
(172, 'gpinboard.com/?c=REp8Bx97pDheyYHw7S5LrPyccNIXG4', 2161934292, 1, 0),
(173, 'gpinboard.com/?c=KtiHqFOMJR28z14xE0Hq26OgN8pdNR', 1490969989, 1, 0),
(174, 'gpinboard.com/?c=wUYdhcKvXVmIt2wyMxO469tyq5Ds%2BE', 1130737241, 1, 0),
(175, 'gpinboard.com/?c=WVgPO96BZ9l7IIB54UXz17%2BmOoSMNK', 3815798587, 1, 0),
(176, 'gpinboard.com/?c=iu25XN2vCp0PxlIsHmGQ1klMLS%2B9Hk', 866567499, 1, 0),
(177, 'gpinboard.com/?c=Hk1ro0Bvw931Eegc8Bsc1Tge80wvvG&adminTemplateId=3&id=3', 3324158957, 1, 0),
(178, 'gpinboard.com/?c=Hk1ro0Bvw931Eegc8Bsc1Tge80wvvG&adminTemplateId=3', 2030429123, 1, 0),
(179, 'gpinboard.com/?c=Hk1ro0Bvw931Eegc8Bsc1Tge80wvvG', 1078320973, 1, 0),
(180, 'gpinboard.com/?c=881Hjx5Ye2NvkFvVWX4kwA348McxDK', 1263775984, 1, 0),
(181, 'gpinboard.com/?c=hXOdYE1zMsLRQTTir%2Fmu1N4AZEm%2BHt', 2573492059, 1, 0),
(182, 'gpinboard.com/?c=O9yFi2SXFSOjP2ljqhh3lMx1s4oRLh', 2279763419, 1, 0),
(183, 'gpinboard.com/?c=6937cgTqTv%2BIVNn%2BKCJ5Z8v8Wm7Eec', 238018255, 1, 0),
(184, 'gpinboard.com/?c=YcCtbOZogZqnd%2BbAFoBQcwZpolv2Iz', 2389290806, 1, 0),
(185, 'gpinboard.com/?c=UdM2TAyr16dLdJV0Wqj6sDskyIUUD0', 1606854285, 1, 0),
(186, 'gpinboard.com/?c=Btm0jnWFjAYENjduzBn3y6v71P2k55&adminTemplateId=2&id=2', 3738501057, 1, 0),
(187, 'gpinboard.com/?c=U4CUS6r8B79VsdGBAfQX5GKtyzPX4P&adminTemplateId=3&id=3', 1197617485, 1, 0),
(188, 'gpinboard.com/?c=gFVgQMkl%2BSXFqaA%2FKIZA2L6s5hWWGU', 2630376888, 1, 0),
(189, 'gpinboard.com/?c=Ua7w2LVCb9pTiUoftrVCY5eVw8g%2F%2FM', 1199203231, 1, 0),
(190, 'gpinboard.com/?c=Eo3lRR7WJmYAfU%2F2eOz86wDc%2Fn9teT', 3117565483, 1, 0),
(191, 'gpinboard.com/?c=fNuUUBT8itXeA7GS4S0LS%2BGTjkBlIi', 2219738223, 1, 0),
(192, 'gpinboard.com/?c=fKxxtmyFqGCwInh5gZmI%2FecfyrFe51&id=4', 2689735373, 1, 0),
(193, 'gpinboard.com/?c=qaAL%2FzWytGQZqjZNQMsY3kiaOxf1lO', 1849207575, 1, 0),
(194, 'gpinboard.com/?c=YttIprMOOe5Mbcf21W5ESvFRNf0mRS&id=4', 1031792725, 1, 0),
(195, 'gpinboard.com/?c=9G4yanp5OaFmxJKWRM%2FlkebScfQCvJ', 1282246954, 1, 0),
(196, 'gpinboard.com/?c=zshuzPX2BSs3sSGgNGDyxFPU%2FLof5P&id=25', 1260626688, 1, 0),
(197, 'gpinboard.com/?c=0jlqGSy4du6hGNVRgovPTScLx909Vr', 2335437363, 1, 0),
(198, 'gpinboard.com/?c=Pjph4jG5SGfMuu%2BPCAfdgZCFNYieE5&adminTemplateId=4&id=4', 1873345909, 1, 0),
(199, 'gpinboard.com/?c=5VcfNkXlsPnszrdiBTVxTYaXubLPX8&adminTemplateId=25&id=25', 3596057400, 1, 0),
(200, 'gpinboard.com/?n=Contact&p=25', 3721044832, 1, 0),
(201, 'gpinboard.com/?c=Qso7cay3CmPLxa0fqc7kkGDijBjmTD', 1153526802, 1, 0),
(202, 'gpinboard.com/?c=vEzDA7dmMB07sVJcjQud726p7bD0i%2F', 1931313914, 1, 0),
(203, 'gpinboard.com/?c=OkAtr0NyCaRwjHh2grseiKv63bALcs', 2182196681, 1, 0),
(204, 'gpinboard.com/?c=uxWZ0FktvH7sA83az0vrNpZLqDPMt7', 3465344357, 1, 0),
(205, 'gpinboard.com/?c=ZEyASZpMNkNxEA7WuebCdok%2FzJW5tx', 2755221384, 1, 0),
(206, 'gpinboard.com/?c=bhwGqT%2Fi9fO2IBCKp557%2FzcU3GfLjM', 3474770446, 1, 0),
(207, 'gpinboard.com/?c=buXNae5SHVkmres375RrEmsmcQjRHL', 3734367033, 1, 0),
(208, 'gpinboard.com/?c=nx1yNXZsUlTjfeqJaT2liX%2FVwrhs4n', 1799608032, 1, 0),
(209, 'gpinboard.com/?c=e%2Fb93zhTeBIVH5Mi6BM8Q6rLzfTynK', 482637700, 1, 0),
(210, 'gpinboard.com/?c=fuWP4b3aSJZrMz9kc6OQGDojQjDRpW', 3902917602, 1, 0),
(211, 'gpinboard.com/?c=PAm5Tfg9MUBOE%2FQqFm8lGWSHhYL0B6', 1020680029, 1, 0),
(212, 'gpinboard.com/?c=r6UUIYAKVlm03HblldbdfVJzuJ%2BTd4', 2575822763, 1, 0),
(213, 'gpinboard.com/?c=IISsijMwF8gk2q8Wyoi8muHg0Nd3sm', 870080400, 1, 0),
(214, 'gpinboard.com/?c=pofR9z6NBGiZXvqotjd0rWAUovqqb3', 260627090, 1, 0),
(215, 'gpinboard.com/?c=swXHvHgc3hDTpkVwrWL1MpydOmFa1g', 2598257681, 1, 0),
(216, 'gpinboard.com/?c=aM19LxTNcSkQDuTGeJlHzet38bVAMs', 3686031526, 1, 0),
(217, 'gpinboard.com/?c=qQBFTW69k9Sc0jo009UNpxhBgVTdJw', 2571921331, 1, 0),
(218, 'gpinboard.com/?c=nYJPty9FPVZwZj38wJobvsMpTSDXuO&id=1', 2679697483, 1, 0),
(219, 'gpinboard.com/?c=c2yge3lhK1ZmW%2BarABttwSBYaWanH7', 1988065486, 1, 0),
(220, 'gpinboard.com/?c=YaN1FOjQMh00BO2DdyTiMOnL2lGx7a', 601315649, 1, 0),
(221, 'gpinboard.com/?c=jH102fyKgNq7nQX7cG5DaYehlmhtSq', 910506014, 1, 0),
(222, 'gpinboard.com/?c=zfDFgxIgE%2BmoqiAJEPx0XRUnsPsnDJ', 2601137991, 1, 0),
(223, 'gpinboard.com/?c=0Rrs%2BHVbnr%2B4hHRHIdhMMErDhtR3AV', 2917145301, 1, 0),
(224, 'gpinboard.com/?c=1VHXnpgg5v%2FmrOim5u%2F9nWDprFMMJn', 1004556549, 1, 0),
(225, 'gpinboard.com/?c=ObvyyxyB%2B4hZUR33%2FghYDhVhYu%2Fu6U&adminTemplateId=4&id=4', 2960223765, 1, 0),
(226, 'gpinboard.com/?c=o16uWGKr2M0UbqqksjpJ9lnQevMXod', 2340960897, 1, 0),
(227, 'gpinboard.com/?c=pHKcdcrug1dZT4%2BOjbmnecMdQld7Br&adminTemplateId=2&id=2', 4098996702, 1, 0),
(228, 'gpinboard.com/?c=Qo84BaA4lBV6vnRQJxM0ZAz1F46KQ4', 1326375249, 1, 0),
(229, 'gpinboard.com/?c=NWSyprBVA9STZ9lqB0CB%2Fhk2IzyYNe&adminTemplateId=3&id=3', 239842798, 1, 0),
(230, 'gpinboard.com/?c=Lm5wq1xIwF47OlWfV7vf5oxY1%2Bj7o%2B', 2729995893, 1, 0),
(231, 'gpinboard.com/?c=%2B7O4kot%2BtcQWFPPQD49k0coD3YnDMd&adminTemplateId=5&id=5', 836936315, 1, 0),
(232, 'gpinboard.com/?c=WM9QefAAZLkzj683axcpwEAEMDl6Fg', 83423400, 1, 0),
(233, 'gpinboard.com/?c=hLjMZCKDz6U%2BGvVwkeNLNbXJoZT%2FYs&adminTemplateId=25&id=25', 3681634438, 1, 0),
(234, 'gpinboard.com/?c=ucA8nP01Un98fF6ecBqTmH1%2BjeXtIn', 3712342902, 1, 0),
(235, 'gpinboard.com/?c=jO8n8X5x0Wn78PqK01a5E8pBLmivV%2F', 1496024661, 1, 0),
(236, 'gpinboard.com/?c=%2Bc%2FkQh5rHRUJ73vMJ2uz1xE0C%2FhkCe', 1599286509, 1, 0),
(237, 'gpinboard.com/?c=TUh7dJLuO1VkCcEXXdu7vwc5NOd1%2FY', 1330123083, 1, 0),
(238, 'gpinboard.com/?c=emG5qPlUsYTBwD%2FH3I5VAKndgvYFr%2B&adminTemplateId=5&id=5', 454316018, 1, 0),
(239, 'gpinboard.com/?c=8kFip55knBJetkk7GTV%2FFaRw7v4NdT', 3873102347, 1, 0),
(240, 'gpinboard.com/?c=f4%2F6RmerBhRaz0sxaWuZRnWIAtTvj2&adminTemplateId=3&id=3', 884798193, 1, 0),
(241, 'gpinboard.com/?c=Cqw4xL%2FubCGYL0zpJMU5zpaK0dAxxw', 912820643, 1, 0),
(242, 'gpinboard.com/?c=MsJNcTFIBdRwVax9n1%2BDrwqhUR6dQ6&adminTemplateId=2&id=2', 4140023823, 1, 0),
(243, 'gpinboard.com/?c=nCN8sGj%2FPo0VYgPHfF7ynXvVvQk%2FVe', 1438217726, 1, 0),
(244, 'gpinboard.com/?c=zwBzJoDUgx7zv3HqlyjfePyDinUMAN&adminPageId=8', 1807999834, 1, 0),
(245, 'gpinboard.com/?c=7wZn9qt1x%2BXBYkiP4JeAp3MBb%2Bybiq', 3831983497, 1, 0),
(246, 'gpinboard.com/?c=iWiOrZQC%2FNRB6Qrsi6f%2FrmEZOkKxDN', 2366690542, 1, 0),
(247, 'gpinboard.com/?c=S9Q3G%2BqaoysSBtGPpnU0C0iZ%2B3r%2Bdh', 623849006, 1, 0),
(248, 'gpinboard.com/?c=%2FmhUUuvt2qb3D%2F%2Bdc9psiLPnPWiZmi', 2130462621, 1, 0),
(249, 'gpinboard.com/?c=21hdO91kkgPT8aIYFE9T%2BCthFW8Uox', 1211300854, 1, 0),
(250, 'gpinboard.com/?c=I6BVnLUm6GU8viAZpqfRWJ3fTI2Kz5', 2258785218, 1, 0),
(251, 'gpinboard.com/?n=Profile&p=9', 218089715, 1, 0),
(252, 'gpinboard.com/?c=ZTkDih5fgOUOELEaYLgXHbhez3bglk', 3731981913, 1, 0),
(253, 'gpinboard.com/?c=%2FkmwvySLTaA%2FJxuBdS77WBZ2iHjJ%2Fu', 3960463752, 1, 0),
(254, 'gpinboard.com/?c=CcJu1fXpgxqbbsCoFZcU9ghLJ1qK6T', 3533754993, 1, 0),
(255, 'gpinboard.com/?c=erk6q9OA251zBhmZMNjQy4dO5qVvxY', 11624212, 1, 0),
(256, 'gpinboard.com/?c=ssuZXRzH35foI95L9ltM1PRcOs8coC', 1163291920, 1, 0),
(257, 'gpinboard.com/?c=1rJJFVSetshaAXdY0ARd4xF6qDg6D7', 306968129, 1, 0),
(258, 'gpinboard.com/?c=55S3rj3P6n%2B1rHeA6okzVM7FQqtONs&adminTemplateId=5&id=5', 4207766193, 1, 0),
(259, 'gpinboard.com/?c=SArCBbkVxvZIxj0%2Bbt1xtZsDONuTTm&adminTemplateId=25&id=25', 3773337428, 1, 0),
(260, 'gpinboard.com/?c=cKnc5CYKUq8fxjBVZo%2BwfEMq7dq6zt&adminTemplateId=4&id=4', 3544097126, 1, 0),
(261, 'gpinboard.com/?c=nKx1qr%2B21evfLXx4alMKDQRgFp4lNf', 420016269, 1, 0),
(262, 'gpinboard.com/?c=cVL3abcdD8vj%2Fn0LV7BP%2Bk%2Fz2kiAPu', 4211690837, 1, 0),
(263, 'Logout', 845213721, 4, NULL),
(264, 'gpinboard.com/?n=Logout&p=31', 2281738768, 1, 0),
(265, 'gpinboard.com/?c=6GKyxCyMlx2QxF6TcjgKQbM8AjPbBP', 3600826159, 1, 0),
(266, 'gpinboard.com/?c=0MIqTAZNcQlXQdptGz3UrvHdN5bocw', 1701819565, 1, 0),
(267, 'gpinboard.com/?c=B7gk6if1lDEpc%2BVV%2B9NkD08RsKymDG', 2569505095, 1, 0),
(268, 'gpinboard.com/?c=sy07UtLaG0h7ervsUZyPC3sOhrhb4K', 3611471894, 1, 0),
(269, 'gpinboard.com/?c=oSGl%2FZ8g8Z5Lo1TKlIJpe7lu4TIgNS', 4172484760, 1, 0),
(270, 'gpinboard.com/?c=XrllYVu4L1zjFKAnv3lQcy06Oc5EXB', 3774609918, 1, 0),
(271, 'gpinboard.com/?c=f55r5l2dVSB8xR6qrEMM8aYWPOR5pL', 2574748015, 1, 0),
(272, 'gpinboard.com/?c=gKI6OX2JprC5Vy6ZHeqGdGHjaxab4l&adminTemplateId=4&id=4', 2211919614, 1, 0),
(273, 'gpinboard.com/?c=N4lAecc7G%2BnUPkwXTEPzfPlmfsrvwM&adminTemplateId=2&id=2', 3145610490, 1, 0),
(274, 'gpinboard.com/?c=95D8XLZamiyPe2hydcYfpHx6%2BmpmLu', 1702843279, 1, 0),
(275, 'gpinboard.com/?c=NaeF22Flpwjfkox2Otjrm8rpcJLOgH&adminTemplateId=3&id=3', 188052212, 1, 0),
(276, 'gpinboard.com/?c=aWjVrCgFoxSOWrpf%2FSzWtzZZbDJPsc', 1614757475, 1, 0),
(277, 'gpinboard.com/?c=0%2FgiG0%2FZpzyrFWtwiG7H2HrQXnn5W8&adminTemplateId=5&id=5', 2851612501, 1, 0),
(278, 'gpinboard.com/?c=x%2F7Trz%2Bl2HV5y8dkcj6hUaE37hLIBZ', 605277468, 1, 0),
(279, 'gpinboard.com/?c=t3fv1fdJMLq7aMTkBww580%2BncWYqRI&adminTemplateId=25&id=25', 730935139, 1, 0),
(280, 'gpinboard.com/?c=hezVwd2HBRpgnRhDyUi04MPw%2Fq%2BC89', 985709358, 1, 0),
(281, 'gpinboard.com/?c=WKeUsNwYX6P60P5ES4pvBmTLY010eM', 1236775843, 1, 0),
(282, 'gpinboard.com/?c=FI8vXyWwgkxZrCWNVlhxrE%2FZPlev3%2B', 3579329215, 1, 0),
(283, 'gpinboard.com/?n=Login&p=30', 3726569439, 1, 0),
(284, 'gpinboard.com/?c=OyWCfPgYRIu6gG1QQnTpvU%2FMBIgBgc', 4270354929, 1, 0),
(285, 'gpinboard.com/?c=ssjYIyiVHT184TAOdB5vFl5VKWa8M8', 2713898050, 1, 0),
(286, 'gpinboard.com/?c=3wyJFuXZRkh%2ByO%2BpkuLsKF1l%2BSnUg8', 2380739782, 1, 0),
(287, 'gpinboard.com/?c=VY4aKKjxpg84hOuet5nhQwKqfqqBoq', 1828520812, 1, 0),
(288, 'gpinboard.com/?c=QO44KfiFKfvbA37udBZAKWkGvMxDc%2F', 3838350012, 1, 0),
(289, 'gpinboard.com/?c=SGUCe3R3%2BtFOd00al0Mf86VlMsBmM3', 324383822, 1, 0),
(290, 'gpinboard.com/?c=6s33fQzIoV4qZWZ%2Be7aM9UcFwP2IlT', 1140329556, 1, 0),
(291, 'gpinboard.com/?c=lKCEuqU52FgEozSN%2F%2FRJJ5EPk369P7&adminTemplateId=25&id=25', 932665125, 1, 0),
(292, 'gpinboard.com/?c=%2BeGQKQ5bRdzwv7o%2Bo8SY30%2BWSugJXk', 412516466, 1, 0),
(293, 'gpinboard.com/?c=Wl%2B1HjG%2FdgJSpGUd374TxoZ3Sc69%2FK&adminTemplateId=5&id=5', 1203353005, 1, 0),
(294, 'gpinboard.com/?c=qpQ3c3ECdt0JV1I1IkI8Tv8Q8cRDzx', 156831771, 1, 0),
(295, 'gpinboard.com/?c=tcGe0wcVkAHOukH8i%2BchO70aVYdNLm&adminTemplateId=4&id=4', 1742233249, 1, 0),
(296, 'gpinboard.com/?c=M0OH8jaQ%2BsI%2FU%2B9Kfv5WzBMFBzUKFe', 3343501112, 1, 0),
(297, 'gpinboard.com/?c=VDD4rOdpuJPieXzY8Ur46kDyx8NCY8&adminTemplateId=3&id=3', 130654207, 1, 0),
(298, 'gpinboard.com/?c=wUT2p5y%2B8aDXk9McoFkzSw2Qb7qQ5F', 4205355235, 1, 0),
(299, 'gpinboard.com/?c=YC8KrgUxOFC1beiYprnawhg8i6BLNb&adminTemplateId=2&id=2', 3947686833, 1, 0),
(300, 'gpinboard.com/?c=yStBDkp0nbDFlUeDUAhAnEpkW%2FJgDP', 2384408865, 1, 0),
(301, 'gpinboard.com/?c=WTb7jmi9SmzaV3%2BKC1YKxIm2bGgLIi', 4144487280, 1, 0),
(302, 'gpinboard.com/?c=6NmBF5ASIh1IS%2FKdvI96OFUaIWumSX', 3138144741, 1, 0),
(303, 'gpinboard.com/?c=K%2FVhJ%2Bljau%2FNih6Vnhl7dXEuC8A5J3', 2167668376, 1, 0),
(304, 'gpinboard.com/?c=OiVSSztVn0%2FwSnnMPirhR1EdNZW1iA', 1885417863, 1, 0),
(305, 'gpinboard.com/?c=aIGYk69R5eYszkkDtsKEDPg8I0%2BA71', 3125154326, 1, 0),
(306, 'gpinboard.com/?c=KmJxFxvRkFBFgxdHrdS7eXEUyiQPoG', 3507411587, 1, 0),
(307, 'gpinboard.com/?c=nipvoJCnzL9PFh%2BEmqZVVVhPm9me5o', 3640146919, 1, 0),
(308, 'gpinboard.com/?c=KK6wtW1ZP28S6mlD24%2B7UsQndr%2BZ38&adminTemplateId=25&id=25', 1702579862, 1, 0),
(309, 'gpinboard.com/?c=0Hd8M00nUFb6EwLDqXLIU6fzvkIZeh&adminTemplateId=5&id=5', 1440803595, 1, 0),
(310, 'gpinboard.com/?c=eLbMSO%2BwiRfUNeXs4%2F9eLjAFEanQB0', 569701936, 1, 0),
(311, 'gpinboard.com/?c=7E1iomIzWomJ%2F0bFlNOVKc7bgALwcP&adminTemplateId=4&id=4', 4153790847, 1, 0),
(312, 'gpinboard.com/?c=p7IwYTK1FQlttCZmEYfmEwBnKgDURF&adminTemplateId=3&id=3', 775739027, 1, 0),
(313, 'gpinboard.com/?c=4YIBjNEJaD%2FcovmcpavdyC5H8xncF%2F', 4413463, 1, 0),
(314, 'gpinboard.com/?c=zqm0rqYysnYp%2BUzucNVzEWAo%2F5uGa5&adminTemplateId=2&id=2', 1477191420, 1, 0),
(315, 'gpinboard.com/?c=qVQrAVZRn%2F55wwmpYPdkCSy5HpOPMU', 2381417019, 1, 0),
(316, 'gpinboard.com/?c=cphOwPPdnWikbwLjd2PUcoeCyZW76L', 2938048600, 1, 0),
(317, 'gpinboard.com/?c=%2BFA3HJbE7nX31g5HufHPYod5z0EMYn', 2834524360, 1, 0),
(318, 'gpinboard.com/?c=QhnOHYEzJwVznINO2XzB5xPk2LvieB', 958373656, 1, 0),
(319, 'gpinboard.com/?c=U%2BAcPaclRAFKcIdnsKI3R9h3N80KI9&adminTemplateId=25&id=25', 2435670879, 1, 0),
(320, 'gpinboard.com/?c=el4jJhMjP5A%2FyfpMsTdcDGXrfzofaH', 1884482795, 1, 0),
(321, 'gpinboard.com/?c=zZgfIoRU%2F9v4tOrDz6ztcGqkczYuGf', 1410316717, 1, 0),
(322, 'gpinboard.com/?c=cmUiulePI0QEWmjeUP0v1%2B4VIDcI8Z', 1536890731, 1, 0),
(323, 'gpinboard.com/?c=rEfL4JQ%2BrYqacHIxGOL2SOAsluqnD5', 4286640119, 1, 0),
(324, 'Messages', 578059456, 4, NULL),
(325, 'gpinboard.com/?n=Messages&p=28', 2744181049, 1, 0),
(326, 'userProfileImage', 8811591, 4, NULL),
(327, 'gpinboard.com/?c=dtlXMvsubx%2Fh5Ff0KJptpC48sGhqtD', 3020060841, 1, 0),
(328, '8aacaa731075f28d95158a1e6b4a07eae29cef05', 704067823, 8, NULL),
(329, 'gpinboard.com/?c=xbgUnDDrUM8db917tUwGogqpv19b4e&lat=45&lng=0&zoom=10', 3108700555, 1, 0),
(330, 'gpinboard.com/?c=JF6SETWgIIJLLH1oE1%2BqLufXJzwdnu&lat=45&lng=0&zoom=10', 511934499, 1, 0),
(331, 'gpinboard.com/?static=login', 4193198628, 1, 0),
(332, 'gpinboard.com/?c=OQ2ilLFJjAxP%2FpQ8%2Fz%2Fz0H%2B7YF57wZ', 4016881301, 1, 0),
(333, 'gpinboard.com/?c=2toVn%2FAxoeL180NKMhuIcBJIGjK87B', 1011058748, 1, 0),
(334, 'gpinboard.com/?c=4%2BBAoKKFp1bzY%2BXRhSwNjSicA0%2BJyu', 2624328684, 1, 0),
(335, 'gpinboard.com/?c=KlWxASsmlsvcwW1TUuqfL3OCeSnnjc', 2394990607, 1, 0),
(336, 'gpinboard.com/?c=aRxV%2BeQc2kGD9olTO2hBl8rS5NrPyf', 2812710294, 1, 0),
(337, 'gpinboard.com/?c=uh4WN5oMx4geTiSwzIyJz3nz%2FiRLRw', 958632065, 1, 0),
(338, 'gpinboard.com/?c=0dWbPA5MNb7VRQN4vR9cVcJ6BSMVDJ', 3863958966, 1, 0),
(339, 'gpinboard.com/?c=Xmzv%2F6D2wF3Qt8gx2ogIRGAm6vyb%2FU&adminTemplateId=25&id=25', 1418735025, 1, 0),
(340, 'gpinboard.com/?c=TPCip1Sej%2FIP7X1ZaMguHQA8hSSQ6A', 1603203714, 1, 0),
(341, 'gpinboard.com/?c=0W7B7vRKwz03AyjRlzZJFaTbX1YDQr&adminTemplateId=4&id=4', 2774886526, 1, 0),
(342, 'gpinboard.com/?c=B9VswFJY4a6Zi2CmwfnUv4wAEdhP3R&adminTemplateId=25&id=25', 3853622082, 1, 0),
(343, 'gpinboard.com/?c=s7onHoW1yu4%2B1mYssax4F9d85tRMLL', 1505700892, 1, 0),
(344, 'gpinboard.com/?c=qZgN2jT%2BA%2F9yqLRsC%2FdAo%2BlmLORdqH&adminTemplateId=5&id=5', 2742420281, 1, 0),
(345, 'gpinboard.com/?c=pbElCh9RkIuWToNPq3mdhhBR79w4FM', 817562707, 1, 0),
(346, 'gpinboard.com/?c=ESELOnZBbiy2ngCh8sFDK%2FRq7tQhwg&adminTemplateId=4&id=4', 1265263033, 1, 0),
(347, 'gpinboard.com/?c=CKb27GWIZROlStwNSKZMgCj9Kujuwv', 2337822073, 1, 0),
(348, 'gpinboard.com/?c=qIYapk3VuhZWSzfuvwACs%2FGP4C91e4&adminTemplateId=3&id=3', 4079481348, 1, 0),
(349, 'gpinboard.com/?c=bnYp0Asong55V3Uask%2Bj8GP6r5fwS2', 1177580832, 1, 0),
(350, 'gpinboard.com/?c=OYDNKDYFtxVfZ%2FOBnDWN5OHFVa4T1f&adminTemplateId=2&id=2', 578314109, 1, 0),
(351, 'gpinboard.com/?c=jOtPAURtac5AaKaY0Xr3OSSgNhi1cm', 1371184135, 1, 0),
(352, 'gpinboard.com/?c=kEEu6TBtUlSli2wYOWfazYoKYHK3Jz', 826492742, 1, 0),
(353, 'gpinboard.com/?c=7mv0K6yQspD4fxDBE1mwBc9h49y11M&lat=45&lng=0&zoom=10', 1824854093, 1, 0),
(354, '6d61955400a6d92a5a00e08f8d98184906192106', 3530754618, 8, NULL),
(355, 'gpinboard.com/?c=ElTpEvtdOnHpU7WV8tV3fLsr9Xo9wJ&lat=45&lng=0&zoom=10', 3268469760, 1, 0),
(356, 'gpinboard.com/?c=djoEmQnxEOYwMkJjiCuppy90uXGhrF', 1917295093, 1, 0),
(357, 'gpinboard.com/?c=paQRz6RFqTjBybZExiZvgTisaYgfz%2B', 1252216464, 1, 0),
(358, 'gpinboard.com/?c=U%2BAe0m3kVJIT3ovrC%2FauCseLc7p1MY&adminTemplateId=25&id=25', 1484414561, 1, 0),
(359, 'gpinboard.com/?c=Br3GjyQaUkPokNlGtbd7ZW6kBp35C3', 3936433548, 1, 0),
(360, 'gpinboard.com/?c=nJTsd2Nn5aK%2B8ZQesQKK36Cgw0RJT%2B', 454685569, 1, 0),
(361, 'gpinboard.com/?c=8HD%2BN%2B4PN1gdnmWAw8i37KVkUO%2FWg7&lat=45&lng=0&zoom=10', 4111194404, 1, 0),
(362, 'gpinboard.com/?c=FgD5XzuRegzP8k8FAo6Wmjk7VW7giN', 1723710982, 1, 0),
(363, 'gpinboard.com/?c=uiNqB9kA%2FzA1Cv%2FYe%2FCL0Cfq3OuwFQ&lat=45.0184472337662&lng=0&zoom=10', 2953701137, 1, 0),
(364, 'gpinboard.com/?c=Hrm5ZGfIyAXappc%2BwXhq9rfk5So06s', 2174932270, 1, 0),
(365, 'gpinboard.com/?c=6EUwLvnNq1vDm24juzxLdf5G3%2Bz7xh&lat=45&lng=0&zoom=10', 1214148055, 1, 0),
(366, 'gpinboard.com/?c=HbGngw6xGp4Rff%2Fyknj6NMkw4fOik7', 3777110052, 1, 0),
(367, 'gpinboard.com/?c=aq3KjzHPuAQtg7OGIcn1eHKcYJ7WL1', 4022493281, 1, 0),
(368, 'adminRoles', 180613944, 4, NULL),
(369, 'gpinboard.com/?c=gLx6En91jatTefqZe0kGgn2jQkU6tj', 565830520, 1, 0),
(370, 'gpinboard.com/?c=NNZr8BajsWBpVHuKitzlgGljFR1tGC&group=10', 2068436872, 1, 0),
(371, 'gpinboard.com/?c=u6ZgO%2FNJWSpNR626K1CXsxnoDRqV%2Bb', 2398251065, 1, 0),
(372, 'gpinboard.com/?c=dbYr%2BAr1CkxofkIbMnDFBgXIaP9HsM', 983206926, 1, 0),
(373, 'gpinboard.com/?c=yYl2iZzQqahbeBwzAyBWTI2C6Xic%2BZ', 135441719, 1, 0),
(374, 'gpinboard.com/?c=QIwfWAOWU0E3t6p7HMdN%2BiJAaUAHxh', 551241334, 1, 0),
(375, 'gpinboard.com/?c=BzsNOWdXcE2bWoRebGgG90AiBNNNJt&lat=45&lng=0&zoom=10', 1670226328, 1, 0),
(376, 'gpinboard.com/?c=kCPyD%2BYGF24zwbn6Zm87H2j1RQrZUM', 2306129525, 1, 0),
(377, 'gpinboard.com/?c=1WY3zHZ3EF%2BDj2nSrYXHyT67%2F7FRnT&lat=45&lng=0&zoom=10', 1502170392, 1, 0),
(378, 'gpinboard.com/?c=3l7Bl2S11Vjh9gZH2iTFS6Qq8VcbFv', 3959616310, 1, 0),
(379, 'gpinboard.com/?c=w7SApeOoA7Efhor9%2FbtOlG2inOidbA&lat=45&lng=0&zoom=10', 4007059059, 1, 0),
(380, 'gpinboard.com/?c=NjjIRZtIW1196RYcDA9JR0r17gcLvs', 2777625210, 1, 0),
(381, 'gpinboard.com/?c=eHV29rXlUFFSUy9vN%2F0wSQNk%2FJdkww&lat=45&lng=0&zoom=10', 1520924010, 1, 0),
(382, 'gpinboard.com/?c=okwOMvrq%2Bf1oD%2Bqj3Xx7fd3e6TRHQ6', 1547477830, 1, 0),
(383, 'gpinboard.com/?c=d9EZqI7FomCkd1%2FIP5kuwUFNgIgyxD', 795645852, 1, 0),
(384, 'gpinboard.com/?c=2vrO2WyaC2kRFPLXSbyYbA1J1oA8Gw&lat=45&lng=0&zoom=10', 4254377427, 1, 0),
(385, 'gpinboard.com/?c=kJM8mRz5T5ZDIok4S6UizqkvSEmKqp', 932107215, 1, 0),
(386, 'gpinboard.com/?c=QkUNHwi9W8gN0hHcZpZjVuR9a2KN51&lat=45&lng=0&zoom=10', 3730020960, 1, 0),
(387, 'gpinboard.com/?c=illQcrFtesMs7Q%2BLEcFbF9ROkUP57l&lat=45&lng=0&zoom=10', 3402505606, 1, 0),
(388, 'gpinboard.com/?c=sLl1r0jqA9d3RLP%2Bqblfzx3LKQ%2FodN', 590450887, 1, 0),
(389, 'gpinboard.com/?c=ilX5lvABPvYZOkxHq3FeZczHF%2B1abg', 2723654700, 1, 0),
(390, 'gpinboard.com/?c=50IUJpeeuviNZhp32pPghUoUyhDD8I', 379307010, 1, 0),
(391, 'gpinboard.com/?c=ft8%2B9TRzpQ1rXjS%2BRlidRhO7e1Cz8S', 2671441611, 1, 0),
(392, 'gpinboard.com/?c=LEvM%2Fozqg%2FZiKp2wsNwKhW7dYRZLXn', 473229743, 1, 0),
(393, 'gpinboard.com/?c=1mLGV0LWR1%2Bho9I%2Bl3h7hZcJu%2BhtIM', 2417182249, 1, 0),
(394, 'gpinboard.com/?c=BsluxUOlIzrtjbGBolum6XaFbuvyMy', 1701423899, 1, 0),
(395, 'gpinboard.com/?c=QUW6rwu0kZ%2BDjmT4pZzB1StgE6pWPX', 3359192601, 1, 0),
(396, 'gpinboard.com/?c=H5Fji4gaWj6tDLAEkbtmxAqQ0HImvQ', 3586056835, 1, 0),
(397, 'gpinboard.com/?c=pDzXx25ZdJ%2F%2BrHVuGqY9nUKsoORCL2', 476374575, 1, 0),
(398, 'gpinboard.com/?c=OWBODuNTlOgD8UvA171bfr6oEEwst4', 298531518, 1, 0),
(399, 'gpinboard.com/?c=Vs50NcFIFp1hDbpWusfs7KmwnusyJb', 770312942, 1, 0),
(400, 'gpinboard.com/?c=zytFyQatV3B7c%2FumOylTlVk9gESMR8', 1721854209, 1, 0),
(401, 'gpinboard.com/?c=sDJRrCp4pTzo0V9E3hZ97LE9aV17i9', 2296746340, 1, 0),
(402, 'gpinboard.com/?c=MXJMA5lTtKvlXUZ9mO7Px9OhWbwoeH', 3238509727, 1, 0),
(403, 'gpinboard.com/?c=qAFUCAcYZIojcxWHxm%2B1M92ecZFHqV', 4167507494, 1, 0),
(404, 'gpinboard.com/?c=BHgcjSvjujvIKFf8lNWnu47ey5kXO6', 3534134304, 1, 0),
(405, 'gpinboard.com/?c=LqCr2jqIoJQbrzylxxXTQkaRxBiamq', 1327926649, 1, 0),
(406, 'gpinboard.com/?c=mQbuYTPPqgWO6FdciTccIURtOz51lg', 574137792, 1, 0),
(407, 'adminSites', 16611228, 4, NULL),
(408, 'gpinboard.com/?c=n3NvuC9EQwZCtMVAp7gl7Cq%2FwpZZVC', 1231201536, 1, 0),
(409, 'gpinboard.com/?c=6BUJrD8sLZOclxIdgh1l8NfmOAOyK6', 485516028, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `piwik_log_conversion`
--

CREATE TABLE IF NOT EXISTS `piwik_log_conversion` (
  `idvisit` int(10) unsigned NOT NULL,
  `idsite` int(10) unsigned NOT NULL,
  `idvisitor` binary(8) NOT NULL,
  `server_time` datetime NOT NULL,
  `idaction_url` int(11) DEFAULT NULL,
  `idlink_va` int(11) DEFAULT NULL,
  `referer_visit_server_date` date DEFAULT NULL,
  `referer_type` int(10) unsigned DEFAULT NULL,
  `referer_name` varchar(70) DEFAULT NULL,
  `referer_keyword` varchar(255) DEFAULT NULL,
  `visitor_returning` tinyint(1) NOT NULL,
  `visitor_count_visits` smallint(5) unsigned NOT NULL,
  `visitor_days_since_first` smallint(5) unsigned NOT NULL,
  `visitor_days_since_order` smallint(5) unsigned NOT NULL,
  `location_country` char(3) NOT NULL,
  `location_region` char(2) DEFAULT NULL,
  `location_city` varchar(255) DEFAULT NULL,
  `location_latitude` float(10,6) DEFAULT NULL,
  `location_longitude` float(10,6) DEFAULT NULL,
  `url` text NOT NULL,
  `idgoal` int(10) NOT NULL,
  `buster` int(10) unsigned NOT NULL,
  `idorder` varchar(100) DEFAULT NULL,
  `items` smallint(5) unsigned DEFAULT NULL,
  `revenue` float DEFAULT NULL,
  `revenue_subtotal` float DEFAULT NULL,
  `revenue_tax` float DEFAULT NULL,
  `revenue_shipping` float DEFAULT NULL,
  `revenue_discount` float DEFAULT NULL,
  `custom_var_k1` varchar(200) DEFAULT NULL,
  `custom_var_v1` varchar(200) DEFAULT NULL,
  `custom_var_k2` varchar(200) DEFAULT NULL,
  `custom_var_v2` varchar(200) DEFAULT NULL,
  `custom_var_k3` varchar(200) DEFAULT NULL,
  `custom_var_v3` varchar(200) DEFAULT NULL,
  `custom_var_k4` varchar(200) DEFAULT NULL,
  `custom_var_v4` varchar(200) DEFAULT NULL,
  `custom_var_k5` varchar(200) DEFAULT NULL,
  `custom_var_v5` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`idvisit`,`idgoal`,`buster`),
  UNIQUE KEY `unique_idsite_idorder` (`idsite`,`idorder`),
  KEY `index_idsite_datetime` (`idsite`,`server_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `piwik_log_conversion_item`
--

CREATE TABLE IF NOT EXISTS `piwik_log_conversion_item` (
  `idsite` int(10) unsigned NOT NULL,
  `idvisitor` binary(8) NOT NULL,
  `server_time` datetime NOT NULL,
  `idvisit` int(10) unsigned NOT NULL,
  `idorder` varchar(100) NOT NULL,
  `idaction_sku` int(10) unsigned NOT NULL,
  `idaction_name` int(10) unsigned NOT NULL,
  `idaction_category` int(10) unsigned NOT NULL,
  `idaction_category2` int(10) unsigned NOT NULL,
  `idaction_category3` int(10) unsigned NOT NULL,
  `idaction_category4` int(10) unsigned NOT NULL,
  `idaction_category5` int(10) unsigned NOT NULL,
  `price` float NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  `deleted` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`idvisit`,`idorder`,`idaction_sku`),
  KEY `index_idsite_servertime` (`idsite`,`server_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `piwik_log_link_visit_action`
--

CREATE TABLE IF NOT EXISTS `piwik_log_link_visit_action` (
  `idlink_va` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `idsite` int(10) unsigned NOT NULL,
  `idvisitor` binary(8) NOT NULL,
  `server_time` datetime NOT NULL,
  `idvisit` int(10) unsigned NOT NULL,
  `idaction_url` int(10) unsigned DEFAULT NULL,
  `idaction_url_ref` int(10) unsigned DEFAULT '0',
  `idaction_name` int(10) unsigned DEFAULT NULL,
  `idaction_name_ref` int(10) unsigned NOT NULL,
  `time_spent_ref_action` int(10) unsigned NOT NULL,
  `custom_var_k1` varchar(200) DEFAULT NULL,
  `custom_var_v1` varchar(200) DEFAULT NULL,
  `custom_var_k2` varchar(200) DEFAULT NULL,
  `custom_var_v2` varchar(200) DEFAULT NULL,
  `custom_var_k3` varchar(200) DEFAULT NULL,
  `custom_var_v3` varchar(200) DEFAULT NULL,
  `custom_var_k4` varchar(200) DEFAULT NULL,
  `custom_var_v4` varchar(200) DEFAULT NULL,
  `custom_var_k5` varchar(200) DEFAULT NULL,
  `custom_var_v5` varchar(200) DEFAULT NULL,
  `custom_float` float DEFAULT NULL,
  PRIMARY KEY (`idlink_va`),
  KEY `index_idvisit` (`idvisit`),
  KEY `index_idsite_servertime` (`idsite`,`server_time`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=502 ;

--
-- Dumping data for table `piwik_log_link_visit_action`
--

INSERT INTO `piwik_log_link_visit_action` (`idlink_va`, `idsite`, `idvisitor`, `server_time`, `idvisit`, `idaction_url`, `idaction_url_ref`, `idaction_name`, `idaction_name_ref`, `time_spent_ref_action`, `custom_var_k1`, `custom_var_v1`, `custom_var_k2`, `custom_var_v2`, `custom_var_k3`, `custom_var_v3`, `custom_var_k4`, `custom_var_v4`, `custom_var_k5`, `custom_var_v5`, `custom_float`) VALUES
(1, 2, 'ªëµ˙*ﬁG ', '2014-12-30 02:48:20', 1, 2, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 214),
(2, 2, 'ªëµ˙*ﬁG ', '2014-12-30 02:49:02', 1, 2, 2, 1, 1, 42, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 322),
(3, 2, 'ªëµ˙*ﬁG ', '2014-12-30 02:49:11', 1, 4, 2, 3, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 342),
(4, 2, 'ªëµ˙*ﬁG ', '2014-12-30 02:49:20', 1, 6, 4, 5, 3, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 414),
(5, 2, 'ªëµ˙*ﬁG ', '2014-12-30 02:49:25', 1, 7, 6, 0, 5, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 2, 'ªëµ˙*ﬁG ', '2014-12-30 02:49:25', 1, 8, 7, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 2, 'ªëµ˙*ﬁG ', '2014-12-30 02:49:25', 1, 9, 8, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 2, 'ªëµ˙*ﬁG ', '2014-12-30 02:49:25', 1, 10, 9, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 2, 'ªëµ˙*ﬁG ', '2014-12-30 02:51:10', 1, 12, 10, 11, 5, 105, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 481),
(10, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:05:18', 2, 13, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5647),
(11, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:05:48', 2, 14, 13, 3, 1, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 609),
(12, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:06:01', 2, 15, 14, 5, 3, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 440),
(13, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:06:06', 2, 16, 15, 0, 5, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:06:06', 2, 17, 16, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:06:07', 2, 18, 17, 0, 5, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:06:07', 2, 19, 18, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:06:14', 2, 20, 19, 11, 5, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 384),
(18, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:16:09', 2, 21, 20, 11, 11, 595, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 430),
(19, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:19:35', 2, 22, 21, 11, 11, 206, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 910),
(20, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:21:45', 2, 23, 22, 11, 11, 130, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 344),
(21, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:22:04', 2, 23, 23, 11, 11, 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 498),
(22, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:23:02', 2, 24, 23, 11, 11, 58, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 364),
(23, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:23:21', 2, 24, 24, 11, 11, 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 327),
(24, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:23:34', 2, 25, 24, 11, 11, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 426),
(25, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:23:41', 2, 26, 25, 11, 11, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 316),
(26, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:24:12', 2, 27, 26, 3, 11, 31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 340),
(27, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:24:37', 2, 27, 27, 1, 3, 25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 424),
(28, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:24:44', 2, 28, 27, 0, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 840),
(29, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:25:21', 2, 28, 28, 0, 1, 37, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 326),
(30, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:25:32', 2, 29, 28, 0, 1, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 346),
(31, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:27:32', 2, 30, 29, 5, 1, 120, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 445),
(32, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:27:39', 2, 31, 30, 0, 5, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(33, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:27:40', 2, 32, 31, 0, 5, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(34, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:27:40', 2, 33, 32, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(35, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:27:41', 2, 34, 33, 0, 5, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(36, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:27:49', 2, 35, 34, 11, 5, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 371),
(37, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:29:07', 2, 36, 35, 11, 11, 78, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 395),
(38, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:29:54', 2, 37, 36, 11, 11, 47, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 365),
(39, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:30:33', 2, 38, 37, 11, 11, 39, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 358),
(40, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:30:42', 2, 39, 38, 11, 11, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 412),
(41, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:30:54', 2, 40, 39, 11, 11, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 380),
(42, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:31:04', 2, 41, 40, 11, 11, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 408),
(43, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:31:17', 2, 42, 41, 11, 11, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 398),
(44, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:31:23', 2, 43, 42, 11, 11, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 275),
(45, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:31:33', 2, 44, 43, 11, 11, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 368),
(46, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:31:45', 2, 45, 44, 11, 11, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 746),
(47, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:32:00', 2, 46, 45, 11, 11, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 463),
(48, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:32:10', 2, 47, 46, 11, 11, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 484),
(49, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:32:24', 2, 48, 47, 11, 11, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 383),
(50, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:32:49', 2, 49, 48, 11, 11, 25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 352),
(51, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:33:13', 2, 50, 49, 11, 11, 24, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 304),
(52, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:33:24', 2, 51, 50, 11, 11, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 346),
(53, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:34:09', 2, 52, 51, 11, 11, 45, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 353),
(54, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:34:26', 2, 53, 52, 11, 11, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 332),
(55, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:34:39', 2, 54, 53, 11, 11, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 322),
(56, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:35:01', 2, 55, 54, 11, 11, 22, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 506),
(57, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:35:29', 2, 56, 55, 0, 11, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 369),
(58, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:36:09', 2, 57, 56, 0, 11, 40, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 374),
(59, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:36:14', 2, 58, 57, 0, 11, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 256),
(60, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:37:07', 2, 58, 58, 1, 11, 53, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 403),
(61, 2, 'ªëµ˙*ﬁG ', '2014-12-30 11:42:52', 2, 59, 58, 3, 1, 345, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 385),
(62, 2, 'ªëµ˙*ﬁG ', '2014-12-30 15:03:31', 3, 59, 0, 3, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 857),
(63, 2, 'ªëµ˙*ﬁG ', '2014-12-30 15:22:28', 3, 60, 59, 3, 3, 1137, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 357),
(64, 2, 'ªëµ˙*ﬁG ', '2014-12-30 15:25:21', 3, 59, 60, 3, 3, 173, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 385),
(65, 2, 'ªëµ˙*ﬁG ', '2014-12-30 16:10:32', 4, 59, 0, 3, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 689),
(66, 2, 'ªëµ˙*ﬁG ', '2014-12-30 16:11:03', 4, 61, 59, 1, 3, 31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 872),
(67, 2, 'ªëµ˙*ﬁG ', '2014-12-30 16:11:25', 4, 62, 61, 5, 1, 22, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 450),
(68, 2, 'ªëµ˙*ﬁG ', '2014-12-30 16:11:31', 4, 63, 62, 0, 5, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(69, 2, 'ªëµ˙*ﬁG ', '2014-12-30 16:11:32', 4, 64, 63, 0, 5, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(70, 2, 'ªëµ˙*ﬁG ', '2014-12-30 16:11:32', 4, 65, 64, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(71, 2, 'ªëµ˙*ﬁG ', '2014-12-30 16:11:32', 4, 66, 65, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(72, 2, 'ªëµ˙*ﬁG ', '2014-12-30 16:11:55', 4, 67, 66, 11, 5, 23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 357),
(73, 2, 'ªëµ˙*ﬁG ', '2014-12-30 16:12:07', 4, 68, 67, 11, 11, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 361),
(74, 2, 'ªëµ˙*ﬁG ', '2014-12-30 16:15:37', 4, 69, 68, 11, 11, 210, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 437),
(75, 2, 'ªëµ˙*ﬁG ', '2014-12-30 16:19:11', 4, 70, 69, 11, 11, 214, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 287),
(76, 2, 'ªëµ˙*ﬁG ', '2014-12-30 16:20:26', 4, 71, 70, 11, 11, 75, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 372),
(77, 2, 'ªëµ˙*ﬁG ', '2014-12-30 16:21:06', 4, 72, 71, 11, 11, 40, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 416),
(78, 2, 'ªëµ˙*ﬁG ', '2014-12-30 16:21:32', 4, 72, 72, 11, 11, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 355),
(79, 2, 'ªëµ˙*ﬁG ', '2014-12-30 16:27:46', 4, 73, 72, 1, 11, 374, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 365),
(80, 2, 'ªëµ˙*ﬁG ', '2014-12-30 16:27:56', 4, 59, 73, 3, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 392),
(81, 2, 'ªëµ˙*ﬁG ', '2014-12-30 16:28:05', 4, 59, 59, 3, 3, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 365),
(82, 2, 'ªëµ˙*ﬁG ', '2014-12-30 16:38:34', 4, 59, 59, 3, 3, 629, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 401),
(83, 2, 'ªëµ˙*ﬁG ', '2014-12-30 16:40:08', 4, 74, 59, 5, 3, 94, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 433),
(84, 2, 'ªëµ˙*ﬁG ', '2014-12-30 16:40:17', 4, 75, 74, 0, 5, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(85, 2, 'ªëµ˙*ﬁG ', '2014-12-30 16:40:17', 4, 76, 75, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(86, 2, 'ªëµ˙*ﬁG ', '2014-12-30 16:40:19', 4, 77, 76, 0, 5, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87, 2, 'ªëµ˙*ﬁG ', '2014-12-30 16:40:19', 4, 78, 77, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(88, 2, 'ªëµ˙*ﬁG ', '2014-12-30 16:40:30', 4, 79, 78, 11, 5, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 376),
(89, 2, 'ªëµ˙*ﬁG ', '2014-12-30 16:48:09', 4, 80, 79, 11, 11, 459, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 349),
(90, 2, 'ªëµ˙*ﬁG ', '2014-12-30 16:49:51', 4, 81, 80, 11, 11, 102, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 826),
(91, 2, 'ªëµ˙*ﬁG ', '2014-12-30 16:51:16', 4, 82, 81, 11, 11, 85, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 719),
(92, 2, 'ªëµ˙*ﬁG ', '2015-01-02 12:34:54', 5, 83, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1209),
(93, 2, 'ªëµ˙*ﬁG ', '2015-01-02 12:35:10', 5, 84, 83, 3, 1, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 363),
(94, 2, 'ªëµ˙*ﬁG ', '2015-01-02 12:35:20', 5, 85, 84, 5, 3, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 434),
(95, 2, 'ªëµ˙*ﬁG ', '2015-01-02 12:35:22', 5, 86, 85, 0, 5, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(96, 2, 'ªëµ˙*ﬁG ', '2015-01-02 12:35:22', 5, 87, 86, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(97, 2, 'ªëµ˙*ﬁG ', '2015-01-02 12:35:22', 5, 88, 87, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(98, 2, 'ªëµ˙*ﬁG ', '2015-01-02 12:35:23', 5, 89, 88, 0, 5, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(99, 2, 'ªëµ˙*ﬁG ', '2015-01-02 12:35:54', 5, 91, 89, 90, 5, 31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 416),
(100, 2, 'ªëµ˙*ﬁG ', '2015-01-02 12:36:16', 5, 92, 91, 90, 90, 22, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 436),
(101, 2, 'ªëµ˙*ﬁG ', '2015-01-02 12:36:36', 5, 93, 92, 90, 90, 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2145),
(102, 2, 'ªëµ˙*ﬁG ', '2015-01-02 12:36:41', 5, 94, 93, 90, 90, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(103, 2, 'ªëµ˙*ﬁG ', '2015-01-02 12:36:53', 5, 95, 94, 90, 90, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1213),
(104, 2, 'ªëµ˙*ﬁG ', '2015-01-02 12:36:57', 5, 96, 95, 90, 90, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 323),
(105, 2, 'ªëµ˙*ﬁG ', '2015-01-02 12:37:09', 5, 97, 96, 90, 90, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1127),
(106, 2, 'ªëµ˙*ﬁG ', '2015-01-02 12:37:12', 5, 98, 97, 90, 90, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 253),
(107, 2, 'ªëµ˙*ﬁG ', '2015-01-02 12:37:22', 5, 99, 98, 90, 90, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1224),
(108, 2, 'ªëµ˙*ﬁG ', '2015-01-02 12:38:17', 5, 100, 99, 1, 90, 55, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 906),
(109, 2, 'ªëµ˙*ﬁG ', '2015-01-02 12:40:10', 5, 101, 100, 3, 1, 113, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 320),
(110, 2, 'Väwô>⁄', '2015-01-02 13:16:07', 6, 100, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1738),
(111, 2, 'Väwô>⁄', '2015-01-02 13:16:15', 6, 102, 100, 5, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 415),
(112, 2, 'Väwô>⁄', '2015-01-02 13:16:22', 6, 103, 102, 0, 5, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 440),
(113, 2, 'Väwô>⁄', '2015-01-02 13:16:24', 6, 104, 103, 0, 5, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 470),
(114, 2, 'Väwô>⁄', '2015-01-02 13:16:24', 6, 105, 104, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 547),
(115, 2, 'Väwô>⁄', '2015-01-02 13:16:24', 6, 106, 105, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 600),
(116, 2, 'Väwô>⁄', '2015-01-02 13:16:43', 6, 107, 106, 11, 5, 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 844),
(117, 2, 'Väwô>⁄', '2015-01-02 13:19:18', 6, 108, 107, 11, 11, 155, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 350),
(118, 2, 'Väwô>⁄', '2015-01-02 13:21:04', 6, 109, 108, 1, 11, 106, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 372),
(119, 2, 'Väwô>⁄', '2015-01-02 13:25:21', 6, 109, 109, 1, 1, 257, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 402),
(120, 2, 'Väwô>⁄', '2015-01-02 13:26:04', 6, 110, 109, 5, 1, 43, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 468),
(121, 2, 'Väwô>⁄', '2015-01-02 13:26:08', 6, 111, 110, 0, 5, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(122, 2, 'Väwô>⁄', '2015-01-02 13:26:09', 6, 112, 111, 0, 5, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(123, 2, 'Väwô>⁄', '2015-01-02 13:26:09', 6, 113, 112, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(124, 2, 'Väwô>⁄', '2015-01-02 13:26:09', 6, 114, 113, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(125, 2, 'Väwô>⁄', '2015-01-02 13:26:34', 6, 115, 114, 5, 5, 25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 408),
(126, 2, 'Väwô>⁄', '2015-01-02 13:26:38', 6, 116, 115, 0, 5, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(127, 2, 'Väwô>⁄', '2015-01-02 13:26:39', 6, 117, 116, 0, 5, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(128, 2, 'Väwô>⁄', '2015-01-02 13:26:39', 6, 118, 117, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(129, 2, 'Väwô>⁄', '2015-01-02 13:26:39', 6, 119, 118, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(130, 2, 'Väwô>⁄', '2015-01-02 13:27:06', 6, 120, 119, 3, 5, 27, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 356),
(131, 2, 'Väwô>⁄', '2015-01-02 13:27:21', 6, 121, 120, 1, 3, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 406),
(132, 2, 'Väwô>⁄', '2015-01-02 13:27:32', 6, 122, 121, 1, 1, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 339),
(133, 2, 'Väwô>⁄', '2015-01-02 13:31:03', 6, 122, 122, 1, 1, 211, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 375),
(134, 2, 'Väwô>⁄', '2015-01-02 13:35:38', 6, 100, 122, 1, 1, 275, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 325),
(135, 2, 'Väwô>⁄', '2015-01-02 13:36:40', 6, 100, 100, 1, 1, 62, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 368),
(136, 2, 'Väwô>⁄', '2015-01-02 13:43:27', 6, 100, 100, 1, 1, 407, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 399),
(137, 2, 'Väwô>⁄', '2015-01-02 13:46:38', 6, 100, 100, 1, 1, 191, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 377),
(138, 2, 'Väwô>⁄', '2015-01-02 13:46:48', 6, 100, 100, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 332),
(139, 2, 'Väwô>⁄', '2015-01-02 13:48:46', 6, 100, 100, 1, 1, 118, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 397),
(140, 2, 'Väwô>⁄', '2015-01-02 13:48:57', 6, 100, 100, 1, 1, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 356),
(141, 2, 'Väwô>⁄', '2015-01-02 13:49:48', 6, 100, 100, 1, 1, 51, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 393),
(142, 2, 'Väwô>⁄', '2015-01-02 13:50:41', 6, 100, 100, 1, 1, 53, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 404),
(143, 2, 'Väwô>⁄', '2015-01-02 13:51:54', 6, 100, 100, 1, 1, 73, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 396),
(144, 2, 'Väwô>⁄', '2015-01-02 13:52:05', 6, 100, 100, 1, 1, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 445),
(145, 2, 'Väwô>⁄', '2015-01-02 13:52:36', 6, 100, 100, 1, 1, 31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 350),
(146, 2, 'Väwô>⁄', '2015-01-02 13:52:48', 6, 100, 100, 1, 1, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 350),
(147, 2, 'Väwô>⁄', '2015-01-02 13:54:15', 6, 100, 100, 1, 1, 87, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 377),
(148, 2, 'Väwô>⁄', '2015-01-02 13:56:33', 6, 100, 100, 1, 1, 138, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 413),
(149, 2, 'Väwô>⁄', '2015-01-02 13:59:50', 6, 100, 100, 1, 1, 197, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 420),
(150, 2, 'Väwô>⁄', '2015-01-02 14:02:05', 6, 100, 100, 1, 1, 135, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 370),
(151, 2, 'Väwô>⁄', '2015-01-02 14:04:09', 6, 100, 100, 1, 1, 124, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 394),
(152, 2, 'Väwô>⁄', '2015-01-02 14:21:26', 6, 100, 100, 1, 1, 1037, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 483),
(153, 2, 'Väwô>⁄', '2015-01-02 14:21:59', 6, 100, 100, 1, 1, 33, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 414),
(154, 2, 'Väwô>⁄', '2015-01-02 14:22:54', 6, 100, 100, 1, 1, 55, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 362),
(155, 2, 'Väwô>⁄', '2015-01-02 14:24:55', 6, 123, 100, 5, 1, 121, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 518),
(156, 2, 'Väwô>⁄', '2015-01-02 14:25:13', 6, 125, 123, 0, 5, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(157, 2, 'Väwô>⁄', '2015-01-02 14:25:13', 6, 124, 125, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(158, 2, 'Väwô>⁄', '2015-01-02 14:25:13', 6, 126, 124, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(159, 2, 'Väwô>⁄', '2015-01-02 14:25:13', 6, 127, 126, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(160, 2, 'Väwô>⁄', '2015-01-02 14:25:19', 6, 128, 127, 11, 5, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 387),
(161, 2, 'Väwô>⁄', '2015-01-02 14:25:28', 6, 129, 128, 11, 11, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 383),
(162, 2, 'Väwô>⁄', '2015-01-02 14:28:03', 6, 130, 129, 11, 11, 155, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 474),
(163, 2, 'Väwô>⁄', '2015-01-02 14:28:11', 6, 130, 130, 11, 11, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 408),
(164, 2, 'Väwô>⁄', '2015-01-02 14:28:59', 6, 131, 130, 1, 11, 48, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 382),
(165, 2, 'Väwô>⁄', '2015-01-02 14:30:12', 6, 132, 131, 5, 1, 73, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 422),
(166, 2, 'Väwô>⁄', '2015-01-02 14:30:16', 6, 133, 132, 0, 5, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(167, 2, 'Väwô>⁄', '2015-01-02 14:30:16', 6, 134, 133, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(168, 2, 'Väwô>⁄', '2015-01-02 14:30:16', 6, 135, 134, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(169, 2, 'Väwô>⁄', '2015-01-02 14:30:17', 6, 136, 135, 0, 5, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(170, 2, 'Väwô>⁄', '2015-01-02 14:34:42', 6, 137, 136, 1, 5, 265, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 393),
(171, 2, 'Väwô>⁄', '2015-01-02 14:35:16', 6, 138, 137, 5, 1, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 487),
(172, 2, 'Väwô>⁄', '2015-01-02 14:35:20', 6, 139, 138, 0, 5, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(173, 2, 'Väwô>⁄', '2015-01-02 14:35:20', 6, 140, 139, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(174, 2, 'Väwô>⁄', '2015-01-02 14:35:20', 6, 141, 140, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(175, 2, 'Väwô>⁄', '2015-01-02 14:35:21', 6, 142, 141, 0, 5, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(176, 2, 'Väwô>⁄', '2015-01-02 14:35:28', 6, 143, 142, 11, 5, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 374),
(177, 2, 'Väwô>⁄', '2015-01-02 14:35:53', 6, 144, 143, 11, 11, 25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 351),
(178, 2, 'Väwô>⁄', '2015-01-02 14:35:56', 6, 145, 144, 1, 11, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 304),
(179, 2, 'Väwô>⁄', '2015-01-02 14:36:23', 6, 146, 145, 1, 1, 27, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 303),
(180, 2, 'Väwô>⁄', '2015-01-02 14:36:30', 6, 148, 146, 147, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 377),
(181, 2, 'Väwô>⁄', '2015-01-02 14:36:34', 6, 149, 148, 1, 147, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 257),
(182, 2, 'Väwô>⁄', '2015-01-02 14:36:45', 6, 150, 149, 1, 1, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 367),
(183, 2, 'Väwô>⁄', '2015-01-02 14:37:08', 6, 151, 150, 1, 1, 23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 364),
(184, 2, 'Väwô>⁄', '2015-01-02 14:37:41', 6, 152, 151, 1, 1, 33, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 376),
(185, 2, 'Väwô>⁄', '2015-01-02 14:37:50', 6, 152, 152, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 456),
(186, 2, 'Väwô>⁄', '2015-01-02 14:38:38', 6, 153, 152, 1, 1, 48, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 304),
(187, 2, 'Väwô>⁄', '2015-01-02 14:39:50', 6, 154, 153, 1, 1, 72, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 491),
(188, 2, 'Väwô>⁄', '2015-01-02 14:40:31', 6, 154, 154, 1, 1, 41, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 349),
(189, 2, 'Väwô>⁄', '2015-01-02 14:41:32', 6, 155, 154, 1, 1, 61, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 423),
(190, 2, 'Väwô>⁄', '2015-01-02 14:42:43', 6, 155, 155, 1, 1, 71, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 369),
(191, 2, 'Väwô>⁄', '2015-01-02 14:43:25', 6, 156, 155, 1, 1, 42, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 367),
(192, 2, 'Väwô>⁄', '2015-01-02 14:43:36', 6, 157, 156, 1, 1, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 377),
(193, 2, 'Väwô>⁄', '2015-01-02 14:43:53', 6, 158, 157, 1, 1, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 638),
(194, 2, 'Väwô>⁄', '2015-01-02 14:44:10', 6, 159, 158, 1, 1, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 373),
(195, 2, 'Väwô>⁄', '2015-01-02 14:44:20', 6, 160, 159, 3, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 397),
(196, 2, 'Väwô>⁄', '2015-01-02 14:44:22', 6, 161, 160, 1, 3, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 300),
(197, 2, 'Väwô>⁄', '2015-01-02 14:44:32', 6, 162, 161, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 359),
(198, 2, 'Väwô>⁄', '2015-01-02 14:44:48', 6, 164, 162, 163, 1, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 431),
(199, 2, 'Väwô>⁄', '2015-01-02 14:46:00', 6, 165, 164, 163, 163, 72, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 332),
(200, 2, 'Väwô>⁄', '2015-01-02 14:46:06', 6, 167, 165, 166, 163, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 472),
(201, 2, 'Väwô>⁄', '2015-01-02 14:46:16', 6, 167, 167, 166, 166, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 386),
(202, 2, 'Väwô>⁄', '2015-01-02 14:46:22', 6, 168, 167, 166, 166, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 370),
(203, 2, 'Väwô>⁄', '2015-01-02 14:46:29', 6, 169, 168, 166, 166, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 394),
(204, 2, 'Väwô>⁄', '2015-01-02 14:46:42', 6, 170, 169, 166, 166, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 373),
(205, 2, 'Väwô>⁄', '2015-01-02 14:47:32', 6, 171, 170, 166, 166, 50, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 400),
(206, 2, 'Väwô>⁄', '2015-01-02 14:47:57', 6, 167, 171, 166, 166, 25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 357),
(207, 2, 'Väwô>⁄', '2015-01-02 14:48:36', 6, 172, 167, 5, 166, 39, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 482),
(208, 2, 'Väwô>⁄', '2015-01-02 14:48:39', 6, 173, 172, 0, 5, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(209, 2, 'Väwô>⁄', '2015-01-02 14:48:39', 6, 174, 173, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(210, 2, 'Väwô>⁄', '2015-01-02 14:48:40', 6, 175, 174, 0, 5, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(211, 2, 'Väwô>⁄', '2015-01-02 14:48:40', 6, 176, 175, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(212, 2, 'Väwô>⁄', '2015-01-02 14:48:52', 6, 177, 176, 11, 5, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 348),
(213, 2, 'Väwô>⁄', '2015-01-02 14:49:00', 6, 178, 177, 11, 11, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 420),
(214, 2, 'Väwô>⁄', '2015-01-02 14:49:08', 6, 179, 178, 11, 11, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 415),
(215, 2, 'Väwô>⁄', '2015-01-02 14:49:19', 6, 180, 179, 166, 11, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 340),
(216, 2, 'Väwô>⁄', '2015-01-02 14:49:23', 6, 181, 180, 5, 166, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 341),
(217, 2, 'Väwô>⁄', '2015-01-02 14:49:28', 6, 182, 181, 0, 5, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(218, 2, 'Väwô>⁄', '2015-01-02 14:49:28', 6, 183, 182, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(219, 2, 'Väwô>⁄', '2015-01-02 14:49:28', 6, 184, 183, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(220, 2, 'Väwô>⁄', '2015-01-02 14:49:28', 6, 185, 184, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(221, 2, 'Väwô>⁄', '2015-01-02 14:49:37', 6, 186, 185, 11, 5, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 614),
(222, 2, 'Väwô>⁄', '2015-01-02 14:58:56', 6, 187, 186, 11, 11, 559, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 469),
(223, 2, 'Väwô>⁄', '2015-01-02 14:59:18', 6, 187, 187, 11, 11, 22, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 391),
(224, 2, 'Väwô>⁄', '2015-01-02 15:00:31', 6, 100, 187, 166, 11, 73, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3138),
(225, 2, 'Väwô>⁄', '2015-01-02 15:00:41', 6, 188, 100, 11, 166, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 421),
(226, 2, 'Väwô>⁄', '2015-01-02 15:01:55', 6, 189, 188, 11, 11, 74, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 374),
(227, 2, 'Väwô>⁄', '2015-01-02 15:02:06', 6, 190, 189, 11, 11, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 403),
(228, 2, 'Väwô>⁄', '2015-01-02 15:02:21', 6, 191, 190, 11, 11, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 749),
(229, 2, 'Väwô>⁄', '2015-01-02 15:02:39', 6, 192, 191, 11, 11, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 405),
(230, 2, 'Väwô>⁄', '2015-01-02 15:02:50', 6, 193, 192, 11, 11, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 410),
(231, 2, 'Väwô>⁄', '2015-01-02 15:03:06', 6, 194, 193, 11, 11, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 417),
(232, 2, 'Väwô>⁄', '2015-01-02 15:03:23', 6, 195, 194, 11, 11, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 491),
(233, 2, 'Väwô>⁄', '2015-01-02 15:03:33', 6, 196, 195, 11, 11, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 481),
(234, 2, 'Väwô>⁄', '2015-01-02 15:04:44', 6, 197, 196, 11, 11, 71, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 408),
(235, 2, 'Väwô>⁄', '2015-01-02 15:05:01', 6, 198, 197, 11, 11, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 445),
(236, 2, 'Väwô>⁄', '2015-01-02 15:05:16', 6, 199, 198, 11, 11, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 445),
(237, 2, 'Väwô>⁄', '2015-01-03 11:24:03', 7, 100, 0, 166, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 380),
(238, 2, 'Väwô>⁄', '2015-01-03 11:24:19', 7, 148, 100, 147, 166, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 337),
(239, 2, 'Väwô>⁄', '2015-01-03 11:25:49', 7, 200, 148, 0, 147, 90, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 341),
(240, 2, 'Väwô>⁄', '2015-01-03 11:26:46', 7, 167, 200, 166, 147, 57, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 585),
(241, 2, 'Väwô>⁄', '2015-01-03 11:28:08', 7, 201, 167, 166, 166, 82, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 271),
(242, 2, 'Väwô>⁄', '2015-01-03 11:28:21', 7, 202, 201, 3, 166, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(243, 2, 'Väwô>⁄', '2015-01-03 11:29:59', 7, 167, 202, 166, 3, 98, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 413),
(244, 2, 'Väwô>⁄', '2015-01-03 11:30:34', 7, 203, 167, 166, 166, 35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 369),
(245, 2, 'Väwô>⁄', '2015-01-03 11:30:51', 7, 204, 203, 5, 166, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 402),
(246, 2, 'Väwô>⁄', '2015-01-03 11:31:05', 7, 205, 204, 0, 5, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(247, 2, 'Väwô>⁄', '2015-01-03 11:31:05', 7, 206, 205, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(248, 2, 'Väwô>⁄', '2015-01-03 11:31:05', 7, 207, 206, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(249, 2, 'Väwô>⁄', '2015-01-03 11:31:06', 7, 208, 207, 0, 5, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(250, 2, 'Väwô>⁄', '2015-01-03 11:31:07', 7, 209, 208, 0, 5, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(251, 2, 'Väwô>⁄', '2015-01-03 11:31:18', 7, 210, 209, 5, 5, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 332),
(252, 2, 'Väwô>⁄', '2015-01-03 11:31:29', 7, 211, 210, 0, 5, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(253, 2, 'Väwô>⁄', '2015-01-03 11:31:31', 7, 212, 211, 0, 5, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(254, 2, 'Väwô>⁄', '2015-01-03 11:31:33', 7, 214, 212, 0, 5, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(255, 2, 'Väwô>⁄', '2015-01-03 11:31:33', 7, 215, 212, 0, 5, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(256, 2, 'Väwô>⁄', '2015-01-03 11:31:33', 7, 213, 212, 0, 5, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(257, 2, 'Väwô>⁄', '2015-01-03 11:32:22', 7, 216, 213, 166, 5, 49, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 350),
(258, 2, 'Väwô>⁄', '2015-01-03 11:32:32', 7, 217, 216, 166, 166, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1204),
(259, 2, 'Väwô>⁄', '2015-01-03 11:32:44', 7, 218, 217, 166, 166, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 350),
(260, 2, 'Väwô>⁄', '2015-01-03 11:33:23', 7, 219, 218, 5, 166, 39, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 789),
(261, 2, 'Väwô>⁄', '2015-01-03 11:33:25', 7, 220, 219, 0, 5, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(262, 2, 'Väwô>⁄', '2015-01-03 11:33:26', 7, 221, 220, 0, 5, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(263, 2, 'Väwô>⁄', '2015-01-03 11:33:26', 7, 222, 221, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(264, 2, 'Väwô>⁄', '2015-01-03 11:33:26', 7, 223, 222, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(265, 2, 'Väwô>⁄', '2015-01-03 11:33:28', 7, 224, 223, 0, 5, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(266, 2, 'Väwô>⁄', '2015-01-03 11:33:35', 7, 225, 224, 11, 5, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 364),
(267, 2, 'Väwô>⁄', '2015-01-03 11:34:22', 7, 226, 225, 11, 11, 47, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 524),
(268, 2, 'Väwô>⁄', '2015-01-03 11:36:32', 7, 227, 226, 11, 11, 130, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 763),
(269, 2, 'Väwô>⁄', '2015-01-03 11:36:41', 7, 228, 227, 11, 11, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 388),
(270, 2, 'Väwô>⁄', '2015-01-03 11:36:48', 7, 229, 228, 11, 11, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 398),
(271, 2, 'Väwô>⁄', '2015-01-03 11:36:57', 7, 230, 229, 11, 11, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 347),
(272, 2, 'Väwô>⁄', '2015-01-03 11:37:06', 7, 231, 230, 11, 11, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 320),
(273, 2, 'Väwô>⁄', '2015-01-03 11:37:16', 7, 232, 231, 11, 11, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 366),
(274, 2, 'Väwô>⁄', '2015-01-03 11:37:24', 7, 233, 232, 11, 11, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 368),
(275, 2, 'Väwô>⁄', '2015-01-03 11:37:45', 7, 234, 233, 11, 11, 21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 405),
(276, 2, 'Väwô>⁄', '2015-01-03 11:41:36', 7, 235, 234, 11, 11, 231, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 455),
(277, 2, 'Väwô>⁄', '2015-01-03 11:41:57', 7, 236, 235, 11, 11, 21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 465),
(278, 2, 'Väwô>⁄', '2015-01-03 11:42:17', 7, 237, 236, 11, 11, 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 438),
(279, 2, 'Väwô>⁄', '2015-01-03 11:42:25', 7, 238, 237, 11, 11, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 544),
(280, 2, 'Väwô>⁄', '2015-01-03 11:42:38', 7, 239, 238, 11, 11, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 365),
(281, 2, 'Väwô>⁄', '2015-01-03 11:42:46', 7, 240, 239, 11, 11, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 431),
(282, 2, 'Väwô>⁄', '2015-01-03 11:42:58', 7, 241, 240, 11, 11, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(283, 2, 'Väwô>⁄', '2015-01-03 11:43:14', 7, 242, 241, 11, 11, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 364),
(284, 2, 'Väwô>⁄', '2015-01-03 11:43:39', 7, 243, 242, 11, 11, 25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 356),
(285, 2, 'Väwô>⁄', '2015-01-03 11:44:05', 7, 244, 243, 5, 11, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 423),
(286, 2, 'Väwô>⁄', '2015-01-03 11:44:08', 7, 245, 244, 0, 5, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(287, 2, 'Väwô>⁄', '2015-01-03 11:44:09', 7, 246, 245, 0, 5, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(288, 2, 'Väwô>⁄', '2015-01-03 11:44:09', 7, 247, 246, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(289, 2, 'Väwô>⁄', '2015-01-03 11:44:09', 7, 248, 247, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(290, 2, 'Väwô>⁄', '2015-01-03 11:44:09', 7, 249, 248, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(291, 2, 'Väwô>⁄', '2015-01-03 11:44:59', 7, 250, 249, 166, 5, 50, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 324),
(292, 2, 'Väwô>⁄', '2015-01-03 11:45:11', 7, 251, 250, 0, 166, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 290),
(293, 2, 'Väwô>⁄', '2015-01-03 11:45:18', 7, 251, 251, 0, 166, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 304),
(294, 2, 'Väwô>⁄', '2015-01-03 11:51:24', 7, 252, 251, 5, 166, 366, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1810),
(295, 2, 'Väwô>⁄', '2015-01-03 11:51:30', 7, 253, 252, 0, 5, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(296, 2, 'Väwô>⁄', '2015-01-03 11:51:30', 7, 254, 253, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(297, 2, 'Väwô>⁄', '2015-01-03 11:51:30', 7, 255, 254, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(298, 2, 'Väwô>⁄', '2015-01-03 11:51:30', 7, 256, 255, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(299, 2, 'Väwô>⁄', '2015-01-03 11:51:30', 7, 257, 256, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(300, 2, 'Väwô>⁄', '2015-01-03 11:51:45', 7, 258, 257, 11, 5, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 389),
(301, 2, 'Väwô>⁄', '2015-01-03 11:51:53', 7, 259, 258, 11, 11, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 516),
(302, 2, 'Väwô>⁄', '2015-01-03 11:52:14', 7, 260, 259, 11, 11, 21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 568),
(303, 2, 'Väwô>⁄', '2015-01-03 11:54:30', 7, 261, 260, 11, 11, 136, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 342),
(304, 2, 'Väwô>⁄', '2015-01-03 11:55:29', 7, 262, 261, 0, 11, 59, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 321),
(305, 2, 'Väwô>⁄', '2015-01-03 11:55:35', 7, 264, 262, 263, 11, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 284),
(306, 2, 'Väwô>⁄', '2015-01-03 11:59:03', 7, 167, 264, 166, 263, 208, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 378),
(307, 2, 'Väwô>⁄', '2015-01-03 11:59:48', 7, 265, 167, 166, 166, 45, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 293),
(308, 2, 'Väwô>⁄', '2015-01-03 12:00:34', 7, 266, 265, 5, 166, 46, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1137),
(309, 2, 'Väwô>⁄', '2015-01-03 12:00:47', 7, 267, 266, 0, 5, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(310, 2, 'Väwô>⁄', '2015-01-03 12:00:49', 7, 268, 267, 0, 5, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(311, 2, 'Väwô>⁄', '2015-01-03 12:00:49', 7, 269, 268, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(312, 2, 'Väwô>⁄', '2015-01-03 12:00:49', 7, 270, 269, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(313, 2, 'Väwô>⁄', '2015-01-03 12:00:49', 7, 271, 270, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(314, 2, 'Väwô>⁄', '2015-01-03 12:01:05', 7, 272, 271, 11, 5, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1992),
(315, 2, 'Väwô>⁄', '2015-01-03 12:02:22', 7, 273, 272, 11, 11, 77, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 344),
(316, 2, 'Väwô>⁄', '2015-01-03 12:02:36', 7, 274, 273, 11, 11, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 739),
(317, 2, 'Väwô>⁄', '2015-01-03 12:02:52', 7, 275, 274, 11, 11, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 737),
(318, 2, 'Väwô>⁄', '2015-01-03 12:03:02', 7, 276, 275, 11, 11, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 498),
(319, 2, 'Väwô>⁄', '2015-01-03 12:03:10', 7, 277, 276, 11, 11, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 464),
(320, 2, 'Väwô>⁄', '2015-01-03 12:03:26', 7, 278, 277, 11, 11, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 357),
(321, 2, 'Väwô>⁄', '2015-01-03 12:03:33', 7, 279, 278, 11, 11, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 364),
(322, 2, 'Väwô>⁄', '2015-01-03 12:04:17', 7, 280, 279, 11, 11, 44, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 413),
(323, 2, 'Väwô>⁄', '2015-01-03 12:04:29', 7, 281, 280, 166, 11, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 319),
(324, 2, 'Väwô>⁄', '2015-01-03 12:07:32', 7, 264, 281, 263, 166, 183, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 448),
(325, 2, 'Väwô>⁄', '2015-01-03 12:08:38', 7, 282, 264, 263, 263, 66, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 336),
(326, 2, 'Väwô>⁄', '2015-01-03 12:08:43', 7, 167, 282, 166, 263, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 289),
(327, 2, 'Väwô>⁄', '2015-01-03 12:09:52', 7, 283, 167, 0, 166, 69, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 325),
(328, 2, 'Väwô>⁄', '2015-01-03 12:10:19', 7, 284, 283, 3, 166, 27, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 411),
(329, 2, 'Väwô>⁄', '2015-01-03 12:11:22', 7, 285, 284, 5, 3, 63, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 407),
(330, 2, 'Väwô>⁄', '2015-01-03 12:11:26', 7, 286, 285, 0, 5, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(331, 2, 'Väwô>⁄', '2015-01-03 12:11:27', 7, 287, 286, 0, 5, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(332, 2, 'Väwô>⁄', '2015-01-03 12:11:28', 7, 288, 287, 0, 5, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(333, 2, 'Väwô>⁄', '2015-01-03 12:11:28', 7, 289, 288, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(334, 2, 'Väwô>⁄', '2015-01-03 12:11:28', 7, 290, 289, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(335, 2, 'Väwô>⁄', '2015-01-03 12:11:36', 7, 291, 290, 11, 5, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 363),
(336, 2, 'Väwô>⁄', '2015-01-03 12:14:05', 7, 292, 291, 11, 11, 149, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 335),
(337, 2, 'Väwô>⁄', '2015-01-03 12:14:15', 7, 293, 292, 11, 11, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 292),
(338, 2, 'Väwô>⁄', '2015-01-03 12:14:25', 7, 294, 293, 11, 11, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 345),
(339, 2, 'Väwô>⁄', '2015-01-03 12:14:34', 7, 295, 294, 11, 11, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 355),
(340, 2, 'Väwô>⁄', '2015-01-03 12:14:44', 7, 296, 295, 11, 11, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 370),
(341, 2, 'Väwô>⁄', '2015-01-03 12:14:51', 7, 297, 296, 11, 11, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 347),
(342, 2, 'Väwô>⁄', '2015-01-03 12:15:02', 7, 298, 297, 11, 11, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 403),
(343, 2, 'Väwô>⁄', '2015-01-03 12:15:10', 7, 299, 298, 11, 11, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 339),
(344, 2, 'Väwô>⁄', '2015-01-03 12:15:20', 7, 300, 299, 11, 11, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 411),
(345, 2, 'Väwô>⁄', '2015-01-03 12:15:25', 7, 301, 300, 3, 11, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 261),
(346, 2, 'Väwô>⁄', '2015-01-03 12:16:35', 7, 302, 301, 5, 3, 70, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 705),
(347, 2, 'Väwô>⁄', '2015-01-03 12:16:40', 7, 303, 302, 0, 5, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(348, 2, 'Väwô>⁄', '2015-01-03 12:16:40', 7, 304, 303, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(349, 2, 'Väwô>⁄', '2015-01-03 12:16:41', 7, 305, 304, 0, 5, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(350, 2, 'Väwô>⁄', '2015-01-03 12:16:41', 7, 306, 304, 0, 5, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(351, 2, 'Väwô>⁄', '2015-01-03 12:16:41', 7, 307, 306, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(352, 2, 'Väwô>⁄', '2015-01-03 12:16:48', 7, 308, 307, 11, 5, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 379),
(353, 2, 'Väwô>⁄', '2015-01-03 12:17:21', 7, 309, 308, 11, 11, 33, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 363),
(354, 2, 'Väwô>⁄', '2015-01-03 12:18:02', 7, 310, 309, 11, 11, 41, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 363),
(355, 2, 'Väwô>⁄', '2015-01-03 12:18:10', 7, 311, 310, 11, 11, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 345),
(356, 2, 'Väwô>⁄', '2015-01-03 12:18:18', 7, 312, 311, 11, 11, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 354),
(357, 2, 'Väwô>⁄', '2015-01-03 12:18:38', 7, 313, 312, 11, 11, 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 323),
(358, 2, 'Väwô>⁄', '2015-01-03 12:18:45', 7, 314, 313, 11, 11, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 349),
(359, 2, 'Väwô>⁄', '2015-01-03 12:19:02', 7, 315, 314, 11, 11, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 361),
(360, 2, 'Väwô>⁄', '2015-01-03 12:19:10', 7, 316, 315, 3, 11, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 242),
(361, 2, 'Väwô>⁄', '2015-01-03 13:24:59', 8, 167, 0, 166, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 345),
(362, 2, 'Väwô>⁄', '2015-01-03 14:27:13', 9, 167, 0, 166, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 416),
(363, 2, 'Väwô>⁄', '2015-01-03 14:43:39', 9, 283, 167, 0, 166, 986, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 757),
(364, 2, 'Väwô>⁄', '2015-01-03 14:44:33', 9, 317, 283, 3, 166, 54, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6094),
(365, 2, 'Väwô>⁄', '2015-01-03 14:45:05', 9, 318, 317, 5, 3, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2504),
(366, 2, 'Väwô>⁄', '2015-01-03 14:46:05', 9, 319, 318, 11, 5, 60, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2174),
(367, 2, 'Väwô>⁄', '2015-01-03 14:47:35', 9, 320, 319, 11, 11, 90, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4218),
(368, 2, 'Väwô>⁄', '2015-01-03 14:48:41', 9, 321, 320, 11, 11, 66, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1544),
(369, 2, 'Väwô>⁄', '2015-01-03 14:49:34', 9, 322, 321, 3, 11, 53, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 701),
(370, 2, 'Väwô>⁄', '2015-01-03 14:49:47', 9, 167, 322, 166, 3, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 532),
(371, 2, 'Väwô>⁄', '2015-01-03 14:52:29', 9, 167, 167, 166, 166, 162, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 653),
(372, 2, 'Väwô>⁄', '2015-01-03 15:13:31', 9, 167, 167, 166, 166, 1262, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 399),
(373, 2, 'Väwô>⁄', '2015-01-03 15:18:04', 9, 167, 167, 166, 166, 273, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 720),
(374, 2, 'Väwô>⁄', '2015-01-03 15:23:10', 9, 167, 167, 166, 166, 306, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 366),
(375, 2, 'Väwô>⁄', '2015-01-03 15:23:56', 9, 323, 167, 166, 166, 46, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 692),
(376, 2, 'Väwô>⁄', '2015-01-03 15:30:25', 9, 325, 323, 324, 166, 389, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 356),
(377, 2, 'Väwô>⁄', '2015-01-03 15:31:38', 9, 327, 325, 326, 324, 73, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 335),
(378, 2, 'Väwô>⁄', '2015-01-03 15:32:00', 9, 327, 327, 326, 326, 22, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 831);
INSERT INTO `piwik_log_link_visit_action` (`idlink_va`, `idsite`, `idvisitor`, `server_time`, `idvisit`, `idaction_url`, `idaction_url_ref`, `idaction_name`, `idaction_name_ref`, `time_spent_ref_action`, `custom_var_k1`, `custom_var_v1`, `custom_var_k2`, `custom_var_v2`, `custom_var_k3`, `custom_var_v3`, `custom_var_k4`, `custom_var_v4`, `custom_var_k5`, `custom_var_v5`, `custom_float`) VALUES
(379, 2, '©ÈπAΩúU∑', '2015-01-05 06:03:35', 10, 83, 0, 166, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(380, 2, 'Väwô>⁄', '2015-01-05 15:43:46', 11, 100, 0, 166, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 328),
(381, 2, 'Väwô>⁄', '2015-01-05 15:44:02', 11, NULL, 100, 328, 166, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 324),
(382, 2, 'Väwô>⁄', '2015-01-05 16:15:19', 12, 329, 0, 166, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2463),
(383, 2, 'Väwô>⁄', '2015-01-05 16:18:43', 12, NULL, 329, 328, 166, 204, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 490),
(384, 2, 'Väwô>⁄', '2015-01-05 16:18:46', 12, 100, NULL, 166, 328, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 515),
(385, 2, 'Väwô>⁄', '2015-01-05 16:18:59', 12, 330, 100, 166, 166, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 980),
(386, 2, 'Väwô>⁄', '2015-01-05 16:24:12', 12, 330, 330, 166, 166, 313, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 727),
(387, 2, 'Väwô>⁄', '2015-01-05 16:41:06', 12, 100, 330, 166, 166, 1014, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 683),
(388, 2, 'Väwô>⁄', '2015-01-05 16:42:10', 12, 100, 100, 166, 166, 64, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 267),
(389, 2, 'Väwô>⁄', '2015-01-05 16:43:04', 12, 331, 100, 1, 166, 54, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 360),
(390, 2, 'Väwô>⁄', '2015-01-05 16:43:36', 12, 332, 331, 3, 1, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 370),
(391, 2, 'Väwô>⁄', '2015-01-05 16:43:45', 12, 333, 332, 5, 3, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 437),
(392, 2, 'Väwô>⁄', '2015-01-05 16:43:52', 12, 334, 333, 0, 5, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(393, 2, 'Väwô>⁄', '2015-01-05 16:43:55', 12, 335, 334, 0, 5, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(394, 2, 'Väwô>⁄', '2015-01-05 16:43:56', 12, 336, 335, 0, 5, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(395, 2, 'Väwô>⁄', '2015-01-05 16:43:56', 12, 338, 336, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(396, 2, 'Väwô>⁄', '2015-01-05 16:43:56', 12, 337, 335, 0, 5, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(397, 2, 'Väwô>⁄', '2015-01-05 16:44:23', 12, 339, 337, 11, 5, 27, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 360),
(398, 2, 'Väwô>⁄', '2015-01-05 16:45:03', 12, 340, 339, 11, 11, 40, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 468),
(399, 2, 'Väwô>⁄', '2015-01-05 16:45:17', 12, 341, 340, 11, 11, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 306),
(400, 2, 'Väwô>⁄', '2015-01-05 16:45:35', 12, 342, 341, 11, 11, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 431),
(401, 2, 'Väwô>⁄', '2015-01-05 16:46:26', 12, 343, 342, 11, 11, 51, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 447),
(402, 2, 'Väwô>⁄', '2015-01-05 16:46:37', 12, 344, 343, 11, 11, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 375),
(403, 2, 'Väwô>⁄', '2015-01-05 16:47:04', 12, 345, 344, 11, 11, 27, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 359),
(404, 2, 'Väwô>⁄', '2015-01-05 16:47:15', 12, 346, 345, 11, 11, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 413),
(405, 2, 'Väwô>⁄', '2015-01-05 16:47:40', 12, 347, 346, 11, 11, 25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 763),
(406, 2, 'Väwô>⁄', '2015-01-05 16:47:54', 12, 348, 347, 11, 11, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 372),
(407, 2, 'Väwô>⁄', '2015-01-05 16:48:12', 12, 349, 348, 11, 11, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 416),
(408, 2, 'Väwô>⁄', '2015-01-05 16:48:21', 12, 350, 349, 11, 11, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 406),
(409, 2, 'Väwô>⁄', '2015-01-05 16:48:45', 12, 351, 350, 11, 11, 24, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 379),
(410, 2, 'Väwô>⁄', '2015-01-05 16:51:32', 12, 352, 351, 3, 11, 167, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 423),
(411, 2, 'Väwô>⁄', '2015-01-05 16:51:45', 12, 167, 352, 166, 3, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 348),
(412, 2, 'Väwô>⁄', '2015-01-05 16:52:02', 12, 353, 167, 166, 166, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 321),
(413, 2, 'Väwô>⁄', '2015-01-05 16:52:59', 12, 353, 353, 166, 166, 57, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 452),
(414, 2, 'Väwô>⁄', '2015-01-05 17:04:59', 12, 353, 353, 166, 166, 720, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 413),
(415, 2, 'Väwô>⁄', '2015-01-05 17:08:33', 12, 353, 353, 166, 166, 214, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 347),
(416, 2, 'Väwô>⁄', '2015-01-05 17:15:24', 12, 353, 353, 166, 166, 411, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 306),
(417, 2, 'Väwô>⁄', '2015-01-05 17:15:49', 12, 353, 353, 166, 166, 25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 320),
(418, 2, 'Väwô>⁄', '2015-01-05 17:17:02', 12, 353, 353, 166, 166, 73, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 352),
(419, 2, 'Väwô>⁄', '2015-01-05 17:35:00', 12, 353, 353, 166, 166, 1078, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 668),
(420, 2, 'Väwô>⁄', '2015-01-05 17:37:32', 12, 353, 353, 166, 166, 152, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 400),
(421, 2, 'Väwô>⁄', '2015-01-10 02:59:39', 13, 100, 0, 166, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 225),
(422, 2, 'Väwô>⁄', '2015-01-10 03:00:12', 13, NULL, 100, 354, 166, 33, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 293),
(423, 2, 'Väwô>⁄', '2015-01-10 04:53:39', 14, 100, 0, 166, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 451),
(424, 2, 'Väwô>⁄', '2015-01-10 04:54:43', 14, 355, 100, 166, 166, 64, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 306),
(425, 2, 'Väwô>⁄', '2015-01-10 05:00:14', 14, 167, 355, 166, 166, 331, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 734),
(426, 2, 'Väwô>⁄', '2015-01-10 05:00:37', 14, 331, 167, 1, 166, 23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 311),
(427, 2, 'Väwô>⁄', '2015-01-10 05:00:56', 14, 356, 331, 3, 1, 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 314),
(428, 2, 'Väwô>⁄', '2015-01-10 05:01:18', 14, 356, 356, 3, 3, 22, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 314),
(429, 2, 'Väwô>⁄', '2015-01-10 05:02:03', 14, 357, 356, 5, 3, 45, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 430),
(430, 2, 'Väwô>⁄', '2015-01-10 05:02:34', 14, 358, 357, 11, 5, 31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 351),
(431, 2, 'Väwô>⁄', '2015-01-10 05:04:06', 14, 359, 358, 11, 11, 92, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 336),
(432, 2, 'Väwô>⁄', '2015-01-10 05:04:25', 14, 360, 359, 3, 11, 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 339),
(433, 2, 'Väwô>⁄', '2015-01-10 05:04:43', 14, 100, 360, 166, 3, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 284),
(434, 2, 'Väwô>⁄', '2015-01-10 05:05:12', 14, 100, 100, 166, 166, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 247),
(435, 2, 'Väwô>⁄', '2015-01-10 05:05:36', 14, 361, 100, 166, 166, 24, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 314),
(436, 2, 'Väwô>⁄', '2015-01-10 05:08:45', 14, 362, 361, 166, 166, 189, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 223),
(437, 2, 'Väwô>⁄', '2015-01-10 05:09:56', 14, 362, 362, 166, 166, 71, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 223),
(438, 2, 'Väwô>⁄', '2015-01-10 08:12:28', 15, 363, 0, 166, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 422),
(439, 2, 'Väwô>⁄', '2015-01-10 08:12:51', 15, 283, 363, 0, 166, 23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 308),
(440, 2, 'Väwô>⁄', '2015-01-10 08:13:21', 15, 364, 283, 3, 166, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 606),
(441, 2, 'Väwô>⁄', '2015-01-10 08:13:39', 15, 167, 364, 166, 3, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 414),
(442, 2, 'Väwô>⁄', '2015-01-10 08:15:52', 15, 365, 167, 166, 166, 133, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 421),
(443, 2, 'Väwô>⁄', '2015-01-10 08:16:44', 15, 366, 365, 166, 166, 52, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 269),
(444, 2, 'Väwô>⁄', '2015-01-10 08:18:10', 15, 367, 366, 5, 166, 86, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 367),
(445, 2, 'Väwô>⁄', '2015-01-10 08:21:29', 15, 369, 367, 368, 5, 199, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 564),
(446, 2, 'Väwô>⁄', '2015-01-10 08:21:51', 15, 370, 369, 368, 368, 22, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 552),
(447, 2, 'Väwô>⁄', '2015-01-10 08:22:18', 15, 371, 370, 368, 368, 27, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 919),
(448, 2, 'Väwô>⁄', '2015-01-10 08:22:36', 15, 372, 371, 166, 368, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 276),
(449, 2, 'Väwô>⁄', '2015-01-10 08:23:11', 15, 264, 372, 263, 166, 35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 332),
(450, 2, 'Väwô>⁄', '2015-01-10 08:23:27', 15, 373, 264, 263, 263, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 224),
(451, 2, 'Väwô>⁄', '2015-01-10 08:23:41', 15, 283, 373, 0, 263, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 442),
(452, 2, 'Väwô>⁄', '2015-01-10 08:24:08', 15, 374, 283, 3, 263, 27, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 309),
(453, 2, 'Väwô>⁄', '2015-01-10 08:24:43', 15, 167, 374, 166, 3, 35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 305),
(454, 2, 'Väwô>⁄', '2015-01-10 08:25:09', 15, 375, 167, 166, 166, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 360),
(455, 2, 'Väwô>⁄', '2015-01-10 08:26:03', 15, 376, 375, 166, 166, 54, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 203),
(456, 2, 'Väwô>⁄', '2015-01-10 08:30:55', 15, 377, 376, 166, 166, 292, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 318),
(457, 2, 'Väwô>⁄', '2015-01-10 08:31:43', 15, 378, 377, 166, 166, 48, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 267),
(458, 2, 'Väwô>⁄', '2015-01-10 08:35:14', 15, 379, 378, 166, 166, 211, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 307),
(459, 2, 'Väwô>⁄', '2015-01-10 08:35:55', 15, 380, 379, 166, 166, 41, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 297),
(460, 2, 'Väwô>⁄', '2015-01-10 08:38:06', 15, 380, 380, 166, 166, 131, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 297),
(461, 2, 'Väwô>⁄', '2015-01-10 08:39:14', 15, 167, 380, 166, 166, 68, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 294),
(462, 2, 'Väwô>⁄', '2015-01-10 08:39:28', 15, 381, 167, 166, 166, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 795),
(463, 2, 'Väwô>⁄', '2015-01-10 08:42:57', 15, 382, 381, 166, 166, 209, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 298),
(464, 2, 'Väwô>⁄', '2015-01-10 08:43:37', 15, 383, 382, 166, 166, 40, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 261),
(465, 2, 'Väwô>⁄', '2015-01-10 08:44:44', 15, 383, 383, 166, 166, 67, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 261),
(466, 2, 'Väwô>⁄', '2015-01-10 08:45:47', 15, 384, 383, 166, 166, 63, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 298),
(467, 2, 'Väwô>⁄', '2015-01-10 08:49:10', 15, 385, 384, 166, 166, 203, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 252),
(468, 2, 'Väwô>⁄', '2015-01-10 08:50:01', 15, 386, 385, 166, 166, 51, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 333),
(469, 2, 'Väwô>⁄', '2015-01-10 08:53:47', 15, 386, 386, 166, 166, 226, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 305),
(470, 2, 'Väwô>⁄', '2015-01-10 08:54:44', 15, 386, 386, 166, 166, 57, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 308),
(471, 2, 'Väwô>⁄', '2015-01-12 13:24:50', 16, 100, 0, 166, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 41731),
(472, 2, 'Väwô>⁄', '2015-01-12 13:25:05', 16, 100, 100, 166, 166, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 291),
(473, 2, 'Väwô>⁄', '2015-01-12 13:27:57', 16, 387, 100, 166, 166, 172, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 361),
(474, 2, 'Väwô>⁄', '2015-01-12 13:29:22', 16, 388, 387, 166, 166, 85, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1003),
(475, 2, 'Väwô>⁄', '2015-01-12 13:29:38', 16, 389, 388, 166, 166, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 293),
(476, 2, 'Väwô>⁄', '2015-01-12 19:11:53', 17, 390, 0, 166, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 370),
(477, 2, 'Väwô>⁄', '2015-01-13 08:12:03', 18, 100, 0, 166, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 364),
(478, 2, 'Väwô>⁄', '2015-01-13 08:12:12', 18, 283, 100, 0, 166, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 316),
(479, 2, 'Väwô>⁄', '2015-01-13 08:12:23', 18, 391, 283, 3, 166, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 345),
(480, 2, 'Väwô>⁄', '2015-01-13 08:12:31', 18, 283, 391, 0, 3, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 370),
(481, 2, 'Väwô>⁄', '2015-01-13 08:13:02', 18, 392, 283, 0, 3, 31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 314),
(482, 2, 'Väwô>⁄', '2015-01-13 08:13:31', 18, 393, 392, 0, 3, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 395),
(483, 2, 'Väwô>⁄', '2015-01-13 08:13:42', 18, 394, 393, 0, 3, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 443),
(484, 2, 'Väwô>⁄', '2015-01-13 08:16:14', 18, 395, 394, 0, 3, 152, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 358),
(485, 2, 'Väwô>⁄', '2015-01-13 08:16:30', 18, 396, 395, 5, 3, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 496),
(486, 2, 'Väwô>⁄', '2015-01-13 08:16:36', 18, 397, 396, 0, 5, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 271),
(487, 2, 'Väwô>⁄', '2015-01-13 08:16:37', 18, 398, 397, 0, 5, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 305),
(488, 2, 'Väwô>⁄', '2015-01-13 08:16:38', 18, 399, 398, 0, 5, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 353),
(489, 2, 'Väwô>⁄', '2015-01-13 08:16:38', 18, 400, 399, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 430),
(490, 2, 'Väwô>⁄', '2015-01-13 08:16:38', 18, 401, 400, 0, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 395),
(491, 2, 'Väwô>⁄', '2015-01-13 08:17:34', 18, 402, 401, 90, 5, 56, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 433),
(492, 2, 'Väwô>⁄', '2015-01-13 08:17:47', 18, 403, 402, 90, 90, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 404),
(493, 2, 'Väwô>⁄', '2015-01-13 08:18:07', 18, 404, 403, 90, 90, 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1954),
(494, 2, 'Väwô>⁄', '2015-01-13 08:18:12', 18, 405, 404, 90, 90, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 274),
(495, 2, 'Väwô>⁄', '2015-01-13 08:18:21', 18, 406, 405, 90, 90, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2368),
(496, 2, 'Väwô>⁄', '2015-01-13 08:50:30', 19, 408, 0, 407, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 404),
(497, 2, 'Väwô>⁄', '2015-01-13 08:50:44', 19, 409, 408, 0, 407, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 338),
(498, 2, 'Väwô>⁄', '2015-01-13 08:51:36', 19, 167, 409, 166, 407, 52, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 312),
(499, 2, 'Väwô>⁄', '2015-01-13 08:52:07', 19, 167, 167, 166, 166, 31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 288),
(500, 2, 'Väwô>⁄', '2015-01-13 08:52:11', 19, 167, 167, 166, 166, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 288),
(501, 2, 'Väwô>⁄', '2015-01-13 08:52:48', 19, 167, 167, 166, 166, 37, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 288);

-- --------------------------------------------------------

--
-- Table structure for table `piwik_log_profiling`
--

CREATE TABLE IF NOT EXISTS `piwik_log_profiling` (
  `query` text NOT NULL,
  `count` int(10) unsigned DEFAULT NULL,
  `sum_time_ms` float DEFAULT NULL,
  UNIQUE KEY `query` (`query`(100))
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `piwik_log_visit`
--

CREATE TABLE IF NOT EXISTS `piwik_log_visit` (
  `idvisit` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idsite` int(10) unsigned NOT NULL,
  `idvisitor` binary(8) NOT NULL,
  `visitor_localtime` time NOT NULL,
  `visitor_returning` tinyint(1) NOT NULL,
  `visitor_count_visits` smallint(5) unsigned NOT NULL,
  `visitor_days_since_last` smallint(5) unsigned NOT NULL,
  `visitor_days_since_order` smallint(5) unsigned NOT NULL,
  `visitor_days_since_first` smallint(5) unsigned NOT NULL,
  `visit_first_action_time` datetime NOT NULL,
  `visit_last_action_time` datetime NOT NULL,
  `visit_exit_idaction_url` int(11) unsigned DEFAULT '0',
  `visit_exit_idaction_name` int(11) unsigned NOT NULL,
  `visit_entry_idaction_url` int(11) unsigned NOT NULL,
  `visit_entry_idaction_name` int(11) unsigned NOT NULL,
  `visit_total_actions` smallint(5) unsigned NOT NULL,
  `visit_total_searches` smallint(5) unsigned NOT NULL,
  `visit_total_time` smallint(5) unsigned NOT NULL,
  `visit_goal_converted` tinyint(1) NOT NULL,
  `visit_goal_buyer` tinyint(1) NOT NULL,
  `referer_type` tinyint(1) unsigned DEFAULT NULL,
  `referer_name` varchar(70) DEFAULT NULL,
  `referer_url` text NOT NULL,
  `referer_keyword` varchar(255) DEFAULT NULL,
  `config_id` binary(8) NOT NULL,
  `config_os` char(3) NOT NULL,
  `config_browser_name` varchar(10) NOT NULL,
  `config_browser_version` varchar(20) NOT NULL,
  `config_resolution` varchar(9) NOT NULL,
  `config_pdf` tinyint(1) NOT NULL,
  `config_flash` tinyint(1) NOT NULL,
  `config_java` tinyint(1) NOT NULL,
  `config_director` tinyint(1) NOT NULL,
  `config_quicktime` tinyint(1) NOT NULL,
  `config_realplayer` tinyint(1) NOT NULL,
  `config_windowsmedia` tinyint(1) NOT NULL,
  `config_gears` tinyint(1) NOT NULL,
  `config_silverlight` tinyint(1) NOT NULL,
  `config_cookie` tinyint(1) NOT NULL,
  `location_ip` varbinary(16) NOT NULL,
  `location_browser_lang` varchar(20) NOT NULL,
  `location_country` char(3) NOT NULL,
  `location_region` char(2) DEFAULT NULL,
  `location_city` varchar(255) DEFAULT NULL,
  `location_latitude` float(10,6) DEFAULT NULL,
  `location_longitude` float(10,6) DEFAULT NULL,
  `custom_var_k1` varchar(200) DEFAULT NULL,
  `custom_var_v1` varchar(200) DEFAULT NULL,
  `custom_var_k2` varchar(200) DEFAULT NULL,
  `custom_var_v2` varchar(200) DEFAULT NULL,
  `custom_var_k3` varchar(200) DEFAULT NULL,
  `custom_var_v3` varchar(200) DEFAULT NULL,
  `custom_var_k4` varchar(200) DEFAULT NULL,
  `custom_var_v4` varchar(200) DEFAULT NULL,
  `custom_var_k5` varchar(200) DEFAULT NULL,
  `custom_var_v5` varchar(200) DEFAULT NULL,
  `location_provider` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idvisit`),
  KEY `index_idsite_config_datetime` (`idsite`,`config_id`,`visit_last_action_time`),
  KEY `index_idsite_datetime` (`idsite`,`visit_last_action_time`),
  KEY `index_idsite_idvisitor` (`idsite`,`idvisitor`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `piwik_log_visit`
--

INSERT INTO `piwik_log_visit` (`idvisit`, `idsite`, `idvisitor`, `visitor_localtime`, `visitor_returning`, `visitor_count_visits`, `visitor_days_since_last`, `visitor_days_since_order`, `visitor_days_since_first`, `visit_first_action_time`, `visit_last_action_time`, `visit_exit_idaction_url`, `visit_exit_idaction_name`, `visit_entry_idaction_url`, `visit_entry_idaction_name`, `visit_total_actions`, `visit_total_searches`, `visit_total_time`, `visit_goal_converted`, `visit_goal_buyer`, `referer_type`, `referer_name`, `referer_url`, `referer_keyword`, `config_id`, `config_os`, `config_browser_name`, `config_browser_version`, `config_resolution`, `config_pdf`, `config_flash`, `config_java`, `config_director`, `config_quicktime`, `config_realplayer`, `config_windowsmedia`, `config_gears`, `config_silverlight`, `config_cookie`, `location_ip`, `location_browser_lang`, `location_country`, `location_region`, `location_city`, `location_latitude`, `location_longitude`, `custom_var_k1`, `custom_var_v1`, `custom_var_k2`, `custom_var_v2`, `custom_var_k3`, `custom_var_v3`, `custom_var_k4`, `custom_var_v4`, `custom_var_k5`, `custom_var_v5`, `location_provider`) VALUES
(1, 2, 'ªëµ˙*ﬁG ', '03:48:19', 1, 3, 9, 0, 9, '2014-12-30 02:48:20', '2014-12-30 02:51:10', 12, 11, 2, 1, 9, 0, 171, 0, 0, 1, '', 'http://makeufo.de/?action=printInstallingView&session=nodb', '', '¢ñ2∂›∏Ç', 'LIN', 'FF', '33.0', '1280x800', 0, 1, 1, 0, 1, 0, 1, 0, 0, 1, 'Ÿ˛ûV', 'en-us,en', 'de', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 't-ipconnect.de'),
(2, 2, 'ªëµ˙*ﬁG ', '12:05:18', 1, 4, 0, 0, 9, '2014-12-30 11:05:18', '2014-12-30 11:42:52', 59, 3, 13, 1, 52, 0, 2255, 0, 0, 1, '', 'http://makeufo.de/?c=VOMD2KFtambuc2LPSytEepTBqVgvHW&adminTemplateId=5&id=5', '', '¢ñ2∂›∏Ç', 'LIN', 'FF', '33.0', '1280x800', 0, 1, 1, 0, 1, 0, 1, 0, 0, 1, 'Ÿ˛ûV', 'en-us,en', 'de', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 't-ipconnect.de'),
(3, 2, 'ªëµ˙*ﬁG ', '16:03:31', 1, 5, 0, 0, 9, '2014-12-30 15:03:31', '2014-12-30 15:25:21', 59, 3, 59, 3, 3, 0, 1311, 0, 0, 1, '', '', '', '¢ñ2∂›∏Ç', 'LIN', 'FF', '33.0', '1280x800', 0, 1, 1, 0, 1, 0, 1, 0, 0, 1, 'Ÿ˛ûV', 'en-us,en', 'de', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 't-ipconnect.de'),
(4, 2, 'ªëµ˙*ﬁG ', '17:10:32', 1, 6, 0, 0, 9, '2014-12-30 16:10:32', '2014-12-30 16:51:16', 82, 11, 59, 3, 27, 0, 2445, 0, 0, 1, '', 'http://makeufo.de/?n=Online+Dating&p=8', '', '¢ñ2∂›∏Ç', 'LIN', 'FF', '33.0', '1280x800', 0, 1, 1, 0, 1, 0, 1, 0, 0, 1, 'Ÿ˛ûV', 'en-us,en', 'de', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 't-ipconnect.de'),
(5, 2, 'ªëµ˙*ﬁG ', '13:34:54', 1, 7, 3, 0, 12, '2015-01-02 12:34:54', '2015-01-02 12:40:10', 101, 3, 83, 1, 18, 0, 317, 0, 0, 1, '', '', '', '≠∂Eó∆ß', 'LIN', 'FF', '33.0', '1280x800', 0, 1, 1, 0, 1, 0, 1, 0, 0, 1, 'Ÿ˛îÁ', 'en-us,en', 'de', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 't-ipconnect.de'),
(6, 2, 'Väwô>⁄', '14:16:07', 1, 2, 0, 0, 0, '2015-01-02 13:16:07', '2015-01-02 15:05:16', 199, 11, 100, 1, 127, 0, 6550, 0, 0, 1, '', '', '', '≠∂Eó∆ß', 'LIN', 'FF', '33.0', '1280x800', 0, 1, 1, 0, 1, 0, 1, 0, 0, 1, 'Ÿ˛îÁ', 'en-us,en', 'de', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 't-ipconnect.de'),
(7, 2, 'Väwô>⁄', '12:24:03', 1, 3, 1, 0, 1, '2015-01-03 11:24:03', '2015-01-03 12:19:10', 316, 3, 100, 166, 124, 0, 3308, 0, 0, 1, '', '', '', '^}‘∂1˝º', 'LIN', 'FF', '33.0', '1280x800', 0, 1, 1, 0, 1, 0, 1, 0, 0, 1, 'Ÿ˛ò%', 'en-us,en', 'de', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 't-ipconnect.de'),
(8, 2, 'Väwô>⁄', '14:24:59', 1, 4, 0, 0, 1, '2015-01-03 13:24:59', '2015-01-03 13:24:59', 167, 166, 167, 166, 1, 0, 0, 0, 0, 1, '', 'http://gpinboard.com/?c=cphOwPPdnWikbwLjd2PUcoeCyZW76L', '', '^}‘∂1˝º', 'LIN', 'FF', '33.0', '1280x800', 0, 1, 1, 0, 1, 0, 1, 0, 0, 1, 'Ÿ˛ò%', 'en-us,en', 'de', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 't-ipconnect.de'),
(9, 2, 'Väwô>⁄', '15:27:12', 1, 5, 0, 0, 1, '2015-01-03 14:27:13', '2015-01-03 15:32:00', 327, 326, 167, 166, 17, 0, 3888, 0, 0, 1, '', '', '', '^}‘∂1˝º', 'LIN', 'FF', '33.0', '1280x800', 0, 1, 1, 0, 1, 0, 1, 0, 0, 1, 'Ÿ˛ò%', 'en-us,en', 'de', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 't-ipconnect.de'),
(10, 2, '©ÈπAΩúU∑', '22:03:34', 0, 1, 0, 0, 0, '2015-01-05 06:03:35', '2015-01-05 06:03:35', 83, 166, 83, 166, 1, 0, 0, 0, 0, 1, '', '', '', 'j’núΩ', 'WXP', 'IE', '6.0', '1024x768', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'œfä', 'en-us,*', 'us', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Ip'),
(11, 2, 'Väwô>⁄', '16:43:46', 1, 6, 2, 0, 3, '2015-01-05 15:43:46', '2015-01-05 15:44:02', NULL, 328, 100, 166, 2, 1, 17, 0, 0, 1, '', '', '', '-æ¢P÷‚ö^', 'LIN', 'FF', '33.0', '1280x800', 0, 1, 1, 0, 1, 0, 1, 0, 0, 1, '["{‘', 'en-us,en', 'de', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 't-ipconnect.de'),
(12, 2, 'Väwô>⁄', '17:15:19', 1, 7, 0, 0, 3, '2015-01-05 16:15:19', '2015-01-05 17:37:32', 353, 166, 329, 166, 39, 1, 4934, 0, 0, 1, '', '', '', '-æ¢P÷‚ö^', 'LIN', 'FF', '33.0', '1280x800', 0, 1, 1, 0, 1, 0, 1, 0, 0, 1, '["{‘', 'en-us,en', 'de', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 't-ipconnect.de'),
(13, 2, 'Väwô>⁄', '03:59:38', 1, 8, 4, 0, 8, '2015-01-10 02:59:39', '2015-01-10 03:00:12', NULL, 354, 100, 166, 2, 1, 34, 0, 0, 1, '', '', '', '59Iì@£¡', 'LIN', 'FF', '33.0', '1280x800', 0, 1, 1, 0, 1, 0, 1, 0, 0, 1, 'Ÿ˛ëH', 'en-us,en', 'de', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 't-ipconnect.de'),
(14, 2, 'Väwô>⁄', '05:53:39', 1, 9, 0, 0, 8, '2015-01-10 04:53:39', '2015-01-10 05:09:56', 362, 166, 100, 166, 15, 0, 978, 0, 0, 1, '', '', '', '59Iì@£¡', 'LIN', 'FF', '33.0', '1280x800', 0, 1, 1, 0, 1, 0, 1, 0, 0, 1, 'Ÿ˛ëH', 'en-us,en', 'de', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 't-ipconnect.de'),
(15, 2, 'Väwô>⁄', '09:12:24', 1, 10, 0, 0, 8, '2015-01-10 08:12:28', '2015-01-10 08:54:44', 386, 166, 363, 166, 33, 0, 2537, 0, 0, 1, '', 'http://gpinboard.com/?c=FgD5XzuRegzP8k8FAo6Wmjk7VW7giN', '', '59Iì@£¡', 'LIN', 'FF', '33.0', '1280x800', 0, 1, 1, 0, 1, 0, 1, 0, 0, 1, 'Ÿ˛ëH', 'en-us,en', 'de', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 't-ipconnect.de'),
(16, 2, 'Väwô>⁄', '14:24:49', 1, 11, 2, 0, 10, '2015-01-12 13:24:50', '2015-01-12 13:29:38', 389, 166, 100, 166, 5, 0, 289, 0, 0, 1, '', '', '', '´ÀL»J.', 'LIN', 'FF', '33.0', '1280x800', 0, 1, 1, 0, 1, 0, 1, 0, 0, 1, 'Ÿ˛ôá', 'en-us,en', 'de', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 't-ipconnect.de'),
(17, 2, 'Väwô>⁄', '20:11:53', 1, 12, 0, 0, 10, '2015-01-12 19:11:53', '2015-01-12 19:11:53', 390, 166, 390, 166, 1, 0, 0, 0, 0, 1, '', 'http://gpinboard.com/?c=ilX5lvABPvYZOkxHq3FeZczHF%2B1abg', '', 'w¿§≈–Dt', 'LIN', 'FF', '33.0', '1280x800', 0, 1, 1, 0, 1, 0, 1, 0, 0, 1, '["re', 'en-us,en', 'de', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 't-ipconnect.de'),
(18, 2, 'Väwô>⁄', '09:12:03', 1, 13, 1, 0, 11, '2015-01-13 08:12:03', '2015-01-13 08:18:21', 406, 90, 100, 166, 19, 0, 379, 0, 0, 1, '', '', '', '‹˚◊‹:µ', 'LIN', 'FF', '33.0', '1280x800', 0, 1, 1, 0, 1, 0, 1, 0, 0, 1, 'Ÿ˛ê;', 'en-us,en', 'de', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 't-ipconnect.de'),
(19, 2, 'Väwô>⁄', '09:50:29', 1, 14, 0, 0, 11, '2015-01-13 08:50:30', '2015-01-13 08:52:48', 167, 166, 408, 407, 6, 0, 139, 0, 0, 1, '', 'http://gpinboard.com/?c=mQbuYTPPqgWO6FdciTccIURtOz51lg', '', '‹˚◊‹:µ', 'LIN', 'FF', '33.0', '1280x800', 0, 1, 1, 0, 1, 0, 1, 0, 0, 1, 'Ÿ˛ê;', 'en-us,en', 'de', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 't-ipconnect.de');

-- --------------------------------------------------------

--
-- Table structure for table `piwik_option`
--

CREATE TABLE IF NOT EXISTS `piwik_option` (
  `option_name` varchar(255) NOT NULL,
  `option_value` longtext NOT NULL,
  `autoload` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`option_name`),
  KEY `autoload` (`autoload`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `piwik_option`
--

INSERT INTO `piwik_option` (`option_name`, `option_value`, `autoload`) VALUES
('delete_logs_enable', '0', 0),
('delete_logs_max_rows_per_query', '100000', 0),
('delete_logs_older_than', '180', 0),
('delete_logs_schedule_lowest_interval', '7', 0),
('delete_reports_enable', '0', 0),
('delete_reports_keep_basic_metrics', '1', 0),
('delete_reports_keep_day_reports', '0', 0),
('delete_reports_keep_month_reports', '1', 0),
('delete_reports_keep_range_reports', '0', 0),
('delete_reports_keep_segment_reports', '0', 0),
('delete_reports_keep_week_reports', '0', 0),
('delete_reports_keep_year_reports', '1', 0),
('delete_reports_older_than', '12', 0),
('geoip.updater_last_run_time', '1420848000', 0),
('lastTrackerCronRun', '1421136723', 0),
('MobileMessaging_DelegatedManagement', 'false', 0),
('piwikUrl', 'http://gpinboard.com//modules/statistics/piwik/', 1),
('SitesManager_DefaultTimezone', 'Europe/Amsterdam', 0),
('TaskScheduler.timetable', 'a:5:{s:41:"Piwik_CoreAdminHome.purgeOutdatedArchives";i:1421193603;s:37:"Piwik_PrivacyManager.deleteReportData";i:1421193603;s:34:"Piwik_PrivacyManager.deleteLogData";i:1421193603;s:41:"Piwik_UserCountry_GeoIPAutoUpdater.update";i:1423008040;s:40:"Piwik_CoreAdminHome.optimizeArchiveTable";i:1421193603;}', 0),
('UpdateCheck_LastTimeChecked', '1421137084', 1),
('UpdateCheck_LatestVersion', '2.10.0', 0),
('version_Actions', '1.12', 1),
('version_Annotations', '1.12', 1),
('version_API', '1.12', 1),
('version_core', '1.12', 1),
('version_CoreAdminHome', '1.12', 1),
('version_CoreHome', '1.12', 1),
('version_CorePluginsAdmin', '1.12', 1),
('version_CoreUpdater', '1.12', 1),
('version_CustomVariables', '1.12', 1),
('version_Dashboard', '1.12', 1),
('version_DoNotTrack', '1.12', 1),
('version_ExampleAPI', '0.1', 1),
('version_ExamplePlugin', '0.1', 1),
('version_ExampleRssWidget', '0.1', 1),
('version_Feedback', '1.12', 1),
('version_Goals', '1.12', 1),
('version_ImageGraph', '1.12', 1),
('version_Installation', '1.12', 1),
('version_LanguagesManager', '1.12', 1),
('version_Live', '1.12', 1),
('version_Login', '1.12', 1),
('version_MobileMessaging', '1.12', 1),
('version_MultiSites', '1.12', 1),
('version_Overlay', '1.12', 1),
('version_PDFReports', '1.12', 1),
('version_PrivacyManager', '1.12', 1),
('version_Provider', '1.12', 1),
('version_Proxy', '1.12', 1),
('version_Referers', '1.12', 1),
('version_SegmentEditor', '1.12', 1),
('version_SEO', '1.12', 1),
('version_SitesManager', '1.12', 1),
('version_Transitions', '1.12', 1),
('version_UserCountry', '1.12', 1),
('version_UserCountryMap', '1.12', 1),
('version_UserSettings', '1.12', 1),
('version_UsersManager', '1.12', 1),
('version_VisitFrequency', '1.12', 1),
('version_VisitorInterest', '1.12', 1),
('version_VisitsSummary', '1.12', 1),
('version_VisitTime', '1.12', 1),
('version_Widgetize', '1.12', 1);

-- --------------------------------------------------------

--
-- Table structure for table `piwik_report`
--

CREATE TABLE IF NOT EXISTS `piwik_report` (
  `idreport` int(11) NOT NULL AUTO_INCREMENT,
  `idsite` int(11) NOT NULL,
  `login` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `idsegment` int(11) DEFAULT NULL,
  `period` varchar(10) NOT NULL,
  `hour` tinyint(4) NOT NULL DEFAULT '0',
  `type` varchar(10) NOT NULL,
  `format` varchar(10) NOT NULL,
  `reports` text NOT NULL,
  `parameters` text,
  `ts_created` timestamp NULL DEFAULT NULL,
  `ts_last_sent` timestamp NULL DEFAULT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idreport`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `piwik_segment`
--

CREATE TABLE IF NOT EXISTS `piwik_segment` (
  `idsegment` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `definition` text NOT NULL,
  `login` varchar(100) NOT NULL,
  `enable_all_users` tinyint(4) NOT NULL DEFAULT '0',
  `enable_only_idsite` int(11) DEFAULT NULL,
  `auto_archive` tinyint(4) NOT NULL DEFAULT '0',
  `ts_created` timestamp NULL DEFAULT NULL,
  `ts_last_edit` timestamp NULL DEFAULT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idsegment`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `piwik_session`
--

CREATE TABLE IF NOT EXISTS `piwik_session` (
  `id` char(32) NOT NULL,
  `modified` int(11) DEFAULT NULL,
  `lifetime` int(11) DEFAULT NULL,
  `data` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `piwik_site`
--

CREATE TABLE IF NOT EXISTS `piwik_site` (
  `idsite` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(90) NOT NULL,
  `main_url` varchar(255) NOT NULL,
  `ts_created` timestamp NULL DEFAULT NULL,
  `ecommerce` tinyint(4) DEFAULT '0',
  `sitesearch` tinyint(4) DEFAULT '1',
  `sitesearch_keyword_parameters` text NOT NULL,
  `sitesearch_category_parameters` text NOT NULL,
  `timezone` varchar(50) NOT NULL,
  `currency` char(3) NOT NULL,
  `excluded_ips` text NOT NULL,
  `excluded_parameters` text NOT NULL,
  `excluded_user_agents` text NOT NULL,
  `group` varchar(250) NOT NULL,
  `keep_url_fragment` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idsite`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `piwik_site`
--

INSERT INTO `piwik_site` (`idsite`, `name`, `main_url`, `ts_created`, `ecommerce`, `sitesearch`, `sitesearch_keyword_parameters`, `sitesearch_category_parameters`, `timezone`, `currency`, `excluded_ips`, `excluded_parameters`, `excluded_user_agents`, `group`, `keep_url_fragment`) VALUES
(1, 'vbmscode', 'http://vbmscode.com', '2014-02-14 10:35:58', 0, 1, '', '', 'Europe/Amsterdam', 'USD', '', '', '', '', 0),
(2, 'vbmscms', 'http://makeufo.de', '2014-12-30 01:48:16', 0, 1, '', '', 'Europe/Amsterdam', 'USD', '', '', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `piwik_site_url`
--

CREATE TABLE IF NOT EXISTS `piwik_site_url` (
  `idsite` int(10) unsigned NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`idsite`,`url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `piwik_site_url`
--

INSERT INTO `piwik_site_url` (`idsite`, `url`) VALUES
(2, 'http://gpinboard.com'),
(2, 'http://vbmscms-vbms.c9.io'),
(2, 'http://worldpinboard.com'),
(2, 'http://www.gpinboard.com'),
(2, 'http://www.worldpinboard.com');

-- --------------------------------------------------------

--
-- Table structure for table `piwik_user`
--

CREATE TABLE IF NOT EXISTS `piwik_user` (
  `login` varchar(100) NOT NULL,
  `password` char(32) NOT NULL,
  `alias` varchar(45) NOT NULL,
  `email` varchar(100) NOT NULL,
  `token_auth` char(32) NOT NULL,
  `date_registered` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`login`),
  UNIQUE KEY `uniq_keytoken` (`token_auth`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `piwik_user`
--

INSERT INTO `piwik_user` (`login`, `password`, `alias`, `email`, `token_auth`, `date_registered`) VALUES
('anonymous', '', 'anonymous', 'anonymous@example.org', 'anonymous', '2014-02-14 10:34:52');

-- --------------------------------------------------------

--
-- Table structure for table `piwik_user_dashboard`
--

CREATE TABLE IF NOT EXISTS `piwik_user_dashboard` (
  `login` varchar(100) NOT NULL,
  `iddashboard` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `layout` text NOT NULL,
  PRIMARY KEY (`login`,`iddashboard`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `piwik_user_language`
--

CREATE TABLE IF NOT EXISTS `piwik_user_language` (
  `login` varchar(100) NOT NULL,
  `language` varchar(10) NOT NULL,
  PRIMARY KEY (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `t_cms_customer`
--

INSERT INTO `t_cms_customer` (`id`, `userid`) VALUES
(1, 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=61 ;

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
(8, 'en', 8, 0x486f6d65),
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
(55, 'en', 55, 0x7573657250726f66696c6527206f7220313d31202d2d),
(56, 'en', 56, 0x70696e626f617264),
(57, 'en', 57, 0x70696e626f617264),
(58, 'en', 58, 0x62696e626f617264),
(59, 'en', 59, 0x70696e626f6172644d6170),
(60, 'en', 60, 0x70696e626f6172644d6170);

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
('935317', 'R√É∆í√Ü‚Äô√É‚Äö√Ç¬©union'),
('3370751', 'Saint Helena'),
('2245662', 'Senegal'),
('241170', 'Seychelles'),
('2403846', 'Sierra Leone'),
('51537', 'Somalia'),
('953987', 'South Africa'),
('7909807', 'South Sudan'),
('366755', 'Sudan'),
('934841', 'Swaziland'),
('2410758', 'S√É∆í√Ü‚Äô√É‚Äö√Ç¬£o Tom√É∆í√Ü‚Äô√É‚Äö√Ç¬© and Pr√É∆í√Ü‚Äô√É‚Äö√Ç¬≠ncipe'),
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
('661882', '√É∆í√Ü‚Äô√É¬¢√¢‚Äö¬¨√Ç¬¶land'),
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
('7626836', 'Cura√É∆í√Ü‚Äô√É‚Äö√Ç¬ßao'),
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
('3578476', 'Saint Barth√É∆í√Ü‚Äô√É‚Äö√Ç¬©lemy'),
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
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `url` varchar(200) NOT NULL,
  `siteid` int(10) NOT NULL,
  `domaintrackerscript` blob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `t_domain`
--

INSERT INTO `t_domain` (`id`, `url`, `siteid`, `domaintrackerscript`) VALUES
(1, 'online4dating.net', 1, ''),
(2, 'www.online4dating.net', 1, ''),
(3, 'makeufo.com', 2, ''),
(4, 'makeufo.de', 1, ''),
(5, 'gpinboard.com', 1, ''),
(6, 'www.gpinboard.com', 1, ''),
(7, 'worldpinboard.com', 1, ''),
(8, 'www.worldpinboard.com', 1, ''),
(9, 'vbmscms-vbms.c9.io', 1, ''),
(10, 'localhost', 1, NULL);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `t_gallery_category`
--

INSERT INTO `t_gallery_category` (`id`, `title`, `description`, `image`, `parent`, `orderkey`) VALUES
(1, 'root_1', 0x726f6f745f31, 0, NULL, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `t_gallery_page`
--

INSERT INTO `t_gallery_page` (`id`, `typeid`, `rootcategory`, `type`) VALUES
(1, 1, 1, '1');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci AUTO_INCREMENT=43 ;

--
-- Dumping data for table `t_icon`
--

INSERT INTO `t_icon` (`id`, `iconfile`, `width`, `height`) VALUES
(1, 0x7265736f757263652f696d672f69636f6e732f4469616772616d2e706e67, 64, 64),
(2, 0x7265736f757263652f696d672f69636f6e732f4275792e706e67, 64, 64),
(3, 0x7265736f757263652f696d672f69636f6e732f436c6f636b2e706e67, 64, 64),
(4, 0x7265736f757263652f696d672f69636f6e732f506c75732e706e67, 64, 64),
(5, 0x7265736f757263652f696d672f69636f6e732f4c6566742e706e67, 64, 64),
(6, 0x7265736f757263652f696d672f69636f6e732f466c61672e706e67, 64, 64),
(7, 0x7265736f757263652f696d672f69636f6e732f486f6d652e706e67, 64, 64),
(8, 0x7265736f757263652f696d672f69636f6e732f466f6c6465722e706e67, 64, 64),
(9, 0x7265736f757263652f696d672f69636f6e732f5365617263682e706e67, 64, 64),
(10, 0x7265736f757263652f696d672f69636f6e732f557365722e706e67, 64, 64),
(11, 0x7265736f757263652f696d672f69636f6e732f54726173682e706e67, 64, 64),
(12, 0x7265736f757263652f696d672f69636f6e732f4c6162656c2e706e67, 64, 64),
(13, 0x7265736f757263652f696d672f69636f6e732f5761726e696e672e706e67, 64, 64),
(14, 0x7265736f757263652f696d672f69636f6e732f416464726573732e706e67, 64, 64),
(15, 0x7265736f757263652f696d672f69636f6e732f5072696e742e706e67, 64, 64),
(16, 0x7265736f757263652f696d672f69636f6e732f476561722e706e67, 64, 64),
(17, 0x7265736f757263652f696d672f69636f6e732f4b65792e706e67, 64, 64),
(18, 0x7265736f757263652f696d672f69636f6e732f50656e63696c2e706e67, 64, 64),
(19, 0x7265736f757263652f696d672f69636f6e732f536869656c642e706e67, 64, 64),
(20, 0x7265736f757263652f696d672f69636f6e732f476c6f62652e706e67, 64, 64),
(21, 0x7265736f757263652f696d672f69636f6e732f4272696566636173652e706e67, 64, 64),
(22, 0x7265736f757263652f696d672f69636f6e732f5469636b2e706e67, 64, 64),
(23, 0x7265736f757263652f696d672f69636f6e732f426f6f6b6d61726b2e706e67, 64, 64),
(24, 0x7265736f757263652f696d672f69636f6e732f53746f702e706e67, 64, 64),
(25, 0x7265736f757263652f696d672f69636f6e732f496e666f2e706e67, 64, 64),
(26, 0x7265736f757263652f696d672f69636f6e732f537461746973746963732e706e67, 64, 64),
(27, 0x7265736f757263652f696d672f69636f6e732f50726573656e742e706e67, 64, 64),
(28, 0x7265736f757263652f696d672f69636f6e732f4d6f6e69746f722e706e67, 64, 64),
(29, 0x7265736f757263652f696d672f69636f6e732f536176652e706e67, 64, 64),
(30, 0x7265736f757263652f696d672f69636f6e732f446f63756d656e742e706e67, 64, 64),
(31, 0x7265736f757263652f696d672f69636f6e732f48656c702e706e67, 64, 64),
(32, 0x7265736f757263652f696d672f69636f6e732f44656c6574652e706e67, 64, 64),
(33, 0x7265736f757263652f696d672f69636f6e732f55702e706e67, 64, 64),
(34, 0x7265736f757263652f696d672f69636f6e732f427562626c652e706e67, 64, 64),
(35, 0x7265736f757263652f696d672f69636f6e732f57616c6c65742e706e67, 64, 64),
(36, 0x7265736f757263652f696d672f69636f6e732f426c6f636b2e706e67, 64, 64),
(37, 0x7265736f757263652f696d672f69636f6e732f43616c656e6461722e706e67, 64, 64),
(38, 0x7265736f757263652f696d672f69636f6e732f446f776e2e706e67, 64, 64),
(39, 0x7265736f757263652f696d672f69636f6e732f48656172742e706e67, 64, 64),
(40, 0x7265736f757263652f696d672f69636f6e732f4c65747465722e706e67, 64, 64),
(41, 0x7265736f757263652f696d672f69636f6e732f436c6970626f6172642e706e67, 64, 64),
(42, 0x7265736f757263652f696d672f69636f6e732f52696768742e706e67, 64, 64);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

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
(28, 50, 0, NULL, 0, 'en', 28),
(30, 57, 0, NULL, 0, 'en', 29),
(31, 60, 0, NULL, 0, 'en', 30);

-- --------------------------------------------------------

--
-- Table structure for table `t_menu_instance`
--

CREATE TABLE IF NOT EXISTS `t_menu_instance` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `siteid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=103 ;

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
(101, 'Pinboard', 'pinboard', 'modules/pinboard/pinboardModule.php', NULL, 'PinboardModule', 1, 0, 0, 1),
(102, 'Pinboard Search Box', 'pinboardSearchBox', 'modules/pinboard/pinboardSearchBoxModule.php', NULL, 'PinboardSearchBoxModule', 1, 0, 0, 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=108 ;

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
(83, 2),
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
(100, 0),
(101, 100),
(102, 101),
(103, 101),
(104, 0),
(106, 102),
(107, 100);

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
(2, NULL, 'selectedStyle', 0x733a313a2237223b),
(3, NULL, 'selectedStyle', 0x733a313a2234223b),
(4, NULL, 'selectedStyle', 0x733a313a2237223b),
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
(2, NULL, 'selectedMenu', 0x733a313a2231223b),
(34, NULL, 'networks', 0x623a313b),
(34, NULL, 'register', 0x623a313b),
(34, NULL, 'reset', 0x623a313b),
(36, NULL, 'mode', 0x733a313a2231223b),
(38, NULL, 'mode', 0x733a313a2231223b),
(39, NULL, 'networks', 0x623a313b),
(39, NULL, 'register', 0x623a313b),
(39, NULL, 'reset', 0x623a313b),
(2, NULL, 'selectedStyle', 0x733a313a2237223b),
(3, NULL, 'selectedStyle', 0x733a313a2234223b),
(4, NULL, 'selectedStyle', 0x733a313a2237223b),
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
(2, NULL, 'selectedMenu', 0x733a313a2231223b),
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
(2, NULL, 'selectedStyle', 0x733a313a2237223b),
(3, NULL, 'selectedStyle', 0x733a313a2234223b),
(4, NULL, 'selectedStyle', 0x733a313a2237223b),
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
(2, NULL, 'selectedMenu', 0x733a313a2231223b),
(34, NULL, 'networks', 0x623a313b),
(34, NULL, 'register', 0x623a313b),
(34, NULL, 'reset', 0x623a313b),
(36, NULL, 'mode', 0x733a313a2231223b),
(38, NULL, 'mode', 0x733a313a2231223b),
(39, NULL, 'networks', 0x623a313b),
(39, NULL, 'register', 0x623a313b),
(39, NULL, 'reset', 0x623a313b),
(2, NULL, 'selectedStyle', 0x733a313a2237223b),
(3, NULL, 'selectedStyle', 0x733a313a2234223b),
(4, NULL, 'selectedStyle', 0x733a313a2237223b),
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
(2, NULL, 'selectedMenu', 0x733a313a2231223b),
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
(88, NULL, 'mode', 0x733a313a2231223b),
(89, NULL, 'mode', 0x733a313a2231223b),
(90, NULL, 'mode', 0x733a313a2231223b),
(92, NULL, 'mode', 0x733a313a2231223b),
(93, NULL, 'mode', 0x733a313a2231223b),
(95, NULL, 'mode', 0x733a313a2231223b),
(18, NULL, 'mode', 0x733a313a2231223b),
(107, NULL, 'hide', 0x623a313b);

-- --------------------------------------------------------

--
-- Table structure for table `t_module_roles`
--

CREATE TABLE IF NOT EXISTS `t_module_roles` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `customrole` int(10) NOT NULL,
  `modulerole` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2277 ;

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
(2167, 8, 'forum.thread.create'),
(2168, 8, 'forum.view'),
(2169, 8, 'forum.thread.post'),
(2170, 8, 'chat.view'),
(2171, 8, 'comment.post'),
(2172, 8, 'gallery.view'),
(2173, 8, 'gallery.owner'),
(2174, 8, 'message.inbox'),
(2175, 8, 'events.callender'),
(2176, 8, 'events.list'),
(2177, 8, 'shop.basket.view'),
(2178, 8, 'shop.basket.details.edit'),
(2179, 8, 'user.profile.view'),
(2180, 8, 'user.profile.owner'),
(2181, 8, 'user.search.view'),
(2182, 8, 'user.friend.view'),
(2183, 8, 'user.friendRequest.view'),
(2184, 8, 'user.image.view'),
(2185, 8, 'pinboardMap.create'),
(2186, 8, 'pinboard.createNote'),
(2187, 10, 'wysiwyg.edit'),
(2188, 10, 'login.edit'),
(2189, 10, 'newsletter.edit'),
(2190, 10, 'newsletter.send'),
(2191, 10, 'products.edit'),
(2192, 10, 'products.view'),
(2193, 10, 'roles.register.edit'),
(2194, 10, 'users.edit'),
(2195, 10, 'sitemap.edit'),
(2196, 10, 'modules.insert'),
(2197, 10, 'forum.topic.create'),
(2198, 10, 'forum.thread.create'),
(2199, 10, 'forum.view'),
(2200, 10, 'forum.admin'),
(2201, 10, 'forum.moderator'),
(2202, 10, 'forum.thread.post'),
(2203, 10, 'chat.edit'),
(2204, 10, 'chat.view'),
(2205, 10, 'comment.post'),
(2206, 10, 'comment.edit'),
(2207, 10, 'comment.delete'),
(2208, 10, 'comment.show.email'),
(2209, 10, 'backup.create'),
(2210, 10, 'backup.load'),
(2211, 10, 'backup.delete'),
(2212, 10, 'users.register.edit'),
(2213, 10, 'user.info.edit'),
(2214, 10, 'user.info.admin'),
(2215, 10, 'user.info.owner'),
(2216, 10, 'admin.roles.edit'),
(2217, 10, 'gallery.edit'),
(2218, 10, 'gallery.view'),
(2219, 10, 'gallery.owner'),
(2220, 10, 'message.inbox'),
(2221, 10, 'events.callender'),
(2222, 10, 'events.list'),
(2223, 10, 'events.edit'),
(2224, 10, 'template.edit'),
(2225, 10, 'template.view'),
(2226, 10, 'domains.edit'),
(2227, 10, 'domains.view'),
(2228, 10, 'orders.edit'),
(2229, 10, 'orders.view'),
(2230, 10, 'orders.all'),
(2231, 10, 'orders.confirm'),
(2232, 10, 'orders.finnish'),
(2233, 10, 'dm.tables.config'),
(2234, 10, 'dm.forms.edit'),
(2235, 10, 'shop.basket.view'),
(2236, 10, 'shop.basket.status.edit'),
(2237, 10, 'shop.basket.edit'),
(2238, 10, 'shop.basket.details.view'),
(2239, 10, 'shop.basket.details.edit'),
(2240, 10, 'slideshow.edit'),
(2241, 10, 'filesystem.all'),
(2242, 10, 'filesystem.user'),
(2243, 10, 'filesystem.www'),
(2244, 10, 'filesystem.edit'),
(2245, 10, 'events.users.all'),
(2246, 10, 'menu.edit'),
(2247, 10, 'pages.editmenu'),
(2248, 10, 'pages.edit'),
(2249, 10, 'payment.edit'),
(2250, 10, 'social.edit'),
(2251, 10, 'admin.edit'),
(2252, 10, 'site.edit'),
(2253, 10, 'site.view'),
(2254, 10, 'translations.edit'),
(2255, 10, 'emailList.edit'),
(2256, 10, 'emailSent.edit'),
(2257, 10, 'ukash.edit'),
(2258, 10, 'user.profile.edit'),
(2259, 10, 'user.profile.view'),
(2260, 10, 'user.profile.owner'),
(2261, 10, 'message.edit'),
(2262, 10, 'user.search.edit'),
(2263, 10, 'user.search.view'),
(2264, 10, 'user.friend.edit'),
(2265, 10, 'user.friend.view'),
(2266, 10, 'user.friendRequest.edit'),
(2267, 10, 'user.friendRequest.view'),
(2268, 10, 'user.image.edit'),
(2269, 10, 'user.image.view'),
(2270, 10, 'adminSocialNotifications.edit'),
(2271, 10, 'user.profile.privateDetails'),
(2272, 10, 'pinboardMap.edit'),
(2273, 10, 'pinboardMap.create'),
(2274, 10, 'pinboard.edit'),
(2275, 10, 'pinboard.admin'),
(2276, 10, 'pinboard.createNote');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=61 ;

--
-- Dumping data for table `t_page`
--

INSERT INTO `t_page` (`id`, `type`, `namecode`, `welcome`, `title`, `keywords`, `description`, `template`, `siteid`, `code`, `codeid`, `pagetrackerscript`, `modifydate`) VALUES
(1, 0, 1, 0, 'login', 0x6c6f67696e, 0x6c6f67696e, 4, 1, 'login', 1, NULL, '2014-11-22 22:00:31'),
(2, 0, 2, 0, 'adminPages', 0x61646d696e5061676573, 0x61646d696e5061676573, 5, 1, 'adminPages', 5, NULL, '2014-05-12 05:23:20'),
(3, 0, 3, 0, 'startup', 0x73746172747570, 0x73746172747570, 5, 1, 'startup', 7, NULL, '2014-05-12 05:23:21'),
(4, 0, 4, 0, 'adminSites', 0x61646d696e5369746573, 0x61646d696e5369746573, 5, 1, 'adminSites', 8, NULL, '2014-05-12 05:23:26'),
(5, 0, 5, 0, 'adminDomains', 0x61646d696e446f6d61696e73, 0x61646d696e446f6d61696e73, 5, 1, 'adminDomains', 9, NULL, '2014-05-12 05:23:29'),
(6, 0, 6, 0, 'adminPackage', 0x61646d696e5061636b616765, 0x61646d696e5061636b616765, 5, 1, 'adminPackage', 10, NULL, '2014-05-12 05:24:56'),
(7, 0, 7, 0, 'pageConfig', 0x70616765436f6e666967, 0x70616765436f6e666967, 5, 1, 'pageConfig', 11, NULL, '2014-05-12 22:49:09'),
(8, 0, 8, 1, 'gpinboard.com the global pinboard network', 0x70696e626f617264, 0x6770696e626f6172642e636f6d2074686520676c6f62616c2070696e626f617264206e6574776f726b, 25, 1, '', NULL, NULL, '2014-11-22 20:26:43'),
(9, 0, 9, 0, '', '', '', 26, 1, '', NULL, NULL, '2014-05-12 22:49:34'),
(10, 0, 10, 0, '', '', '', 3, 1, '', NULL, NULL, '2014-05-12 22:49:57'),
(11, 0, 11, 0, 'insertModule', 0x696e736572744d6f64756c65, 0x696e736572744d6f64756c65, 5, 1, 'insertModule', 12, NULL, '2014-05-12 22:50:02'),
(12, 0, 12, 0, 'userSearchResult', 0x75736572536561726368526573756c74, 0x75736572536561726368526573756c74, 3, 1, 'userSearchResult', 14, NULL, '2014-05-12 23:57:22'),
(13, 0, 13, 0, '', '', '', 4, 1, '', NULL, NULL, '2015-01-13 08:16:11'),
(14, 0, 14, 0, 'register', 0x7265676973746572, 0x7265676973746572, 5, 1, 'register', 16, NULL, '2014-11-17 03:45:49'),
(15, 0, 15, 0, 'Online Dating', 0x6f6e6c696e6520646174696e67, 0x4f6e6c696e6520646174696e6720757365722070726f66696c65, 2, 1, 'userProfile', 17, NULL, '2014-05-13 00:01:21'),
(16, 0, 16, 0, 'userDetails', 0x7573657244657461696c73, 0x7573657244657461696c73, 2, 1, 'userDetails', 18, NULL, '2014-05-13 00:07:53'),
(17, 0, 17, 0, 'profile', 0x70726f66696c65, 0x70726f66696c65, 5, 1, 'profile', 19, NULL, '2014-05-13 00:08:30'),
(18, 0, 18, 0, 'adminTranslations', 0x61646d696e5472616e736c6174696f6e73, 0x61646d696e5472616e736c6174696f6e73, 5, 1, 'adminTranslations', 23, NULL, '2014-05-13 02:57:16'),
(19, 0, 19, 0, 'userWall', 0x7573657257616c6c, 0x7573657257616c6c, 2, 1, 'userWall', 24, NULL, '2014-05-13 03:15:40'),
(20, 0, 20, 0, 'userGallery', 0x7573657247616c6c657279, 0x7573657247616c6c657279, 3, 1, 'userGallery', 27, NULL, '2014-11-16 10:01:28'),
(21, 0, 21, 0, 'userMessage', 0x757365724d657373616765, 0x757365724d657373616765, 3, 1, 'userMessage', 30, NULL, '2014-05-13 03:38:32'),
(22, 0, 22, 0, 'userFriends', 0x75736572467269656e6473, 0x75736572467269656e6473, 5, 1, 'userFriends', 32, NULL, '2014-05-13 03:39:48'),
(23, 0, 23, 0, 'userAddFriends', 0x75736572416464467269656e6473, 0x75736572416464467269656e6473, 5, 1, 'userAddFriends', 33, NULL, '2014-05-13 03:42:02'),
(24, 0, 24, 0, '', '', '', 5, 1, '', NULL, NULL, '2014-11-07 14:07:21'),
(25, 0, 25, 0, '', '', '', 5, 1, '', NULL, NULL, '2014-06-19 11:05:57'),
(26, 0, 26, 0, '', '', '', 5, 1, '', NULL, NULL, '2014-06-19 12:11:57'),
(27, 0, 27, 0, 'adminTemplates', 0x61646d696e54656d706c61746573, 0x61646d696e54656d706c61746573, 5, 1, 'adminTemplates', 35, NULL, '2014-05-13 04:14:19'),
(28, 0, 28, 0, 'Messages', 0x4d65737361676573, 0x4d65737361676573, 3, 1, '', NULL, NULL, '2014-05-13 22:00:13'),
(29, 0, 29, 0, 'Friends', 0x467269656e6473, 0x467269656e6473, 3, 1, '', NULL, NULL, '2014-05-13 22:01:26'),
(30, 0, 30, 0, 'Login', 0x4c6f67696e, 0x4c6f67696e, 5, 1, '', NULL, NULL, '2014-05-13 22:07:56'),
(31, 0, 31, 0, 'Logout', 0x4c6f676f7574, 0x4c6f676f7574, 4, 1, '', NULL, NULL, '2014-11-23 01:55:08'),
(32, 0, 32, 0, 'adminRoles', 0x61646d696e526f6c6573, 0x61646d696e526f6c6573, 5, 1, 'adminRoles', 40, NULL, '2014-05-13 22:15:34'),
(33, 0, 33, 0, 'unregistered', 0x756e72656769737465726564, 0x756e72656769737465726564, 0, 1, 'unregistered', 41, NULL, '2014-05-14 06:01:40'),
(34, 0, 34, 0, 'userFriend', 0x75736572467269656e64, 0x75736572467269656e64, 3, 1, 'userFriend', 42, NULL, '2014-05-14 23:01:51'),
(35, 0, 35, 0, 'Friend Requests', 0x467269656e64205265717565737473, 0x467269656e64205265717565737473, 3, 1, '', NULL, NULL, '2014-05-14 23:36:54'),
(36, 0, 36, 0, 'Search Users', 0x536561726368205573657273, 0x536561726368205573657273, 3, 1, '', NULL, NULL, '2014-05-16 23:38:35'),
(37, 0, 37, 0, '', '', '', 3, 1, '', NULL, NULL, '2014-05-16 23:38:51'),
(38, 0, 38, 0, '', '', '', 3, 1, '', NULL, NULL, '2014-05-16 23:39:56'),
(39, 0, 39, 0, 'adminSocialNotifications', 0x61646d696e536f6369616c4e6f74696669636174696f6e73, 0x61646d696e536f6369616c4e6f74696669636174696f6e73, 5, 1, 'adminSocialNotifications', 56, NULL, '2014-06-11 04:26:46'),
(40, 0, 40, 0, 'userProfileImage', 0x7573657250726f66696c65496d616765, 0x7573657250726f66696c65496d616765, 3, 1, 'userProfileImage', 57, NULL, '2014-06-13 09:28:23'),
(41, 0, 41, 0, 'Chat', 0x43686174, 0x43686174, 5, 1, '', NULL, NULL, '2014-06-18 04:12:47'),
(42, 0, 42, 0, 'adminNewsletter', 0x61646d696e4e6577736c6574746572, 0x61646d696e4e6577736c6574746572, 5, 1, 'adminNewsletter', 64, NULL, '2014-10-09 04:20:03'),
(43, 0, 43, 0, 'userFriendRequest', 0x75736572467269656e6452657175657374, 0x75736572467269656e6452657175657374, 5, 1, 'userFriendRequest', 65, NULL, '2014-10-16 05:24:59'),
(44, 0, 44, 0, 'Sitemap Online Dating', 0x536974656d6170206f6e6c696e6520646174696e67, 0x53697465206d617020666f72206f6e6c696e65203420646174696e6720746865206f6e6c792066726565206f6e6c696e6520646174696e67206e6574776f726b73, 4, 1, '', NULL, NULL, '2014-11-07 14:14:22'),
(45, 0, 45, 0, 'adminMenus', 0x61646d696e4d656e7573, 0x61646d696e4d656e7573, 5, 1, 'adminMenus', 71, NULL, '2014-11-08 09:37:29'),
(46, 0, 46, 0, 'adminUsers', 0x61646d696e5573657273, 0x61646d696e5573657273, 5, 1, 'adminUsers', 72, NULL, '2014-11-08 15:36:17'),
(50, 0, 50, 0, 'userInfo', 0x75736572496e666f, 0x75736572496e666f, 2, 1, 'userInfo', 90, NULL, '2014-11-23 00:46:55'),
(49, 0, 49, 0, 'userSettings', 0x7573657253657474696e6773, 0x7573657253657474696e6773, 2, 1, 'userSettings', 87, NULL, '2014-11-23 00:26:28'),
(51, 0, 51, 0, 'userProfile''A=0', 0x7573657250726f66696c6527413d30, 0x7573657250726f66696c6527413d30, 5, 1, 'userProfile''A=0', 97, NULL, '2014-11-26 19:30:34'),
(54, 0, 54, 0, 'userProfilea'' -- a', 0x7573657250726f66696c656127202d2d2061, 0x7573657250726f66696c656127202d2d2061, 0, 2, 'userProfilea'' -- a', 99, NULL, '2014-11-27 21:33:35'),
(53, 0, 53, 0, 'userProfilea', 0x7573657250726f66696c6561, 0x7573657250726f66696c6561, 0, 2, 'userProfilea', 98, NULL, '2014-11-27 21:33:30'),
(55, 0, 55, 0, 'userProfile'' or 1=1 --', 0x7573657250726f66696c6527206f7220313d31202d2d, 0x7573657250726f66696c6527206f7220313d31202d2d, 0, 2, 'userProfile'' or 1=1 --', 100, NULL, '2014-11-27 21:33:53'),
(57, 0, 57, 0, 'pinboard', 0x70696e626f617264, 0x70696e626f617264, 5, 1, 'pinboard', 103, NULL, '2015-01-14 16:19:58'),
(58, 0, 58, 0, 'binboard', 0x62696e626f617264, 0x62696e626f617264, 5, 1, 'binboard', 104, NULL, '2015-01-23 21:48:22'),
(60, 0, 60, 0, 'pinboardMap', 0x70696e626f6172644d6170, 0x70696e626f6172644d6170, 25, 1, 'pinboardMap', 107, NULL, '2015-02-25 23:52:55');

-- --------------------------------------------------------

--
-- Table structure for table `t_page_roles`
--

CREATE TABLE IF NOT EXISTS `t_page_roles` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `roleid` int(10) NOT NULL,
  `pageid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=435 ;

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
(385, 10, 8),
(384, 7, 8),
(419, 13, 9),
(418, 10, 9),
(417, 9, 9),
(416, 8, 9),
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
(383, 13, 55),
(386, 7, 56),
(387, 8, 56),
(388, 9, 56),
(389, 10, 56),
(390, 13, 56),
(415, 13, 57),
(414, 10, 57),
(413, 9, 57),
(412, 8, 57),
(411, 7, 57),
(396, 7, 58),
(397, 8, 58),
(398, 9, 58),
(399, 10, 58),
(400, 13, 58),
(401, 7, 59),
(402, 8, 59),
(403, 9, 59),
(404, 10, 59),
(405, 13, 59),
(434, 13, 60),
(433, 10, 60),
(432, 9, 60),
(431, 8, 60),
(430, 7, 60);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `t_pinboard`
--

INSERT INTO `t_pinboard` (`id`, `name`, `description`, `lat`, `lng`, `userid`, `iconid`, `createdate`, `updatedate`) VALUES
(3, 'work in progress', 0x776f726b20696e2070726f67726573732064657363, 48.0975666400476, 11.352079244531296, 1, 16, '2015-02-08 18:10:34', '2015-02-08 18:10:34'),
(4, 'faterstetten', 0x76617465727374657474656e206465736372697074696f6e, 48.103069376690755, 11.534726949609421, 1, 10, '2015-02-24 09:53:12', '2015-02-24 09:53:12'),
(5, 'name', 0x64657363, 0, 0, 1, 31, '2015-02-26 02:30:33', '2015-02-26 02:30:33'),
(6, 'etewtewt', 0x736466736466736466, 0, 0, 1, 7, '2015-02-27 14:22:04', '2015-02-27 14:22:04');

-- --------------------------------------------------------

--
-- Table structure for table `t_pinboard_note`
--

CREATE TABLE IF NOT EXISTS `t_pinboard_note` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `typeid` int(11) NOT NULL,
  `message` blob NOT NULL,
  `pinboardid` int(11) NOT NULL,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `createdate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `t_pinboard_note`
--

INSERT INTO `t_pinboard_note` (`id`, `userid`, `type`, `typeid`, `message`, `pinboardid`, `x`, `y`, `createdate`) VALUES
(7, 1, 0, 0, 0x6173646661736673616466, 3, 0, 0, '2015-02-09 19:04:12'),
(8, 1, 0, 0, 0x61736466616661736661736466647366, 3, 0, 0, '2015-02-09 19:16:25'),
(9, 1, 0, 0, 0x617364666173646620617366207364666173206673646661736673662061736466617364662061736620736466617320667364666173667366206173646661736466206173662073646661732066736466617366736620617364666173646620617366207364666173206673646661736673662061736466617364662061736620736466617320667364666173667366206173646661736466206173662073646661732066736466617366736620, 3, 0, 0, '2015-02-09 19:38:32');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `t_roles`
--

INSERT INTO `t_roles` (`id`, `name`, `userid`, `roleid`) VALUES
(1, '7', 1, 7),
(2, '8', 1, 8),
(3, '9', 1, 9),
(4, '10', 1, 10),
(5, '13', 1, 13);

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

--
-- Dumping data for table `t_session`
--

INSERT INTO `t_session` (`userid`, `sessionid`, `sessionkey`, `ip`, `name`, `lastpolltime`, `logintime`) VALUES
(1, '5cad72278c620f5066b1d6beca8b3c6c12d54d82', 'ZTDSbHaHs4JYTpEaZmsNVdFEwGBxwN8clwKGYPZL', '127.0.0.1', 'vbms', '2015-02-27 13:39:35', '2015-02-27 13:11:25');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `t_site`
--

INSERT INTO `t_site` (`id`, `name`, `description`, `sitetrackerscript`, `cmscustomerid`, `piwikid`, `facebookappid`, `facebooksecret`, `googleclientid`, `googleclientsecret`, `twitterkey`, `twittersecret`) VALUES
(1, 'vbmscms', 0x76626d73636d7320696e6974616c2073697465, '', 1, 2, '', '', '', '', '', '');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `t_site_template`
--

INSERT INTO `t_site_template` (`id`, `siteid`, `templateid`, `main`) VALUES
(1, 1, 2, 0),
(2, 1, 3, 0),
(3, 1, 4, 0),
(4, 1, 5, 1),
(5, 1, 25, 0),
(6, 1, 26, 0);

-- --------------------------------------------------------

--
-- Table structure for table `t_site_users`
--

CREATE TABLE IF NOT EXISTS `t_site_users` (
  `siteid` int(11) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_site_users`
--

INSERT INTO `t_site_users` (`siteid`, `userid`) VALUES
(0, 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `t_template`
--

INSERT INTO `t_template` (`id`, `name`, `template`, `interface`, `html`, `css`, `js`, `main`) VALUES
(2, 'Docpanel Demo Template', '', '', 0x3c64697620636c6173733d2263656e746572486f6c6465722063656e7465724c6566744d617267696e2063656e74657252696768744d617267696e223e0d0a2020266c743b3f636d732074656d706c6174652e6d61696e2e63656e74657220636d733f2667743b0d0a3c2f6469763e0d0a3c64697620636c6173733d226c656674486f6c646572223e0d0a2020266c743b3f636d732074656d706c6174652e617265612e6c65667420636d733f2667743b0d0a3c2f6469763e0d0a3c64697620636c6173733d227269676874486f6c646572223e0d0a2020266c743b3f636d732074656d706c6174652e617265612e726967687420636d733f2667743b0d0a3c2f6469763e0d0a3c64697620636c6173733d22746f704d656e75486f6c646572223e0d0a20203c64697620636c6173733d22746f704c6566744d656e75486f6c646572223e0d0a20202020266c743b3f636d732074656d706c6174652e6d656e752e746f704d656e7520636d733f2667743b0d0a20203c2f6469763e0d0a20203c64697620636c6173733d22736561726368486f6c646572223e0d0a20202020266c743b3f636d732074656d706c6174652e6d6f64756c652e7374617469632e70696e626f617264536561726368426f782e73656172636820636d733f2667743b0d0a20203c2f6469763e0d0a3c2f6469763e0d0a3c64697620636c6173733d22746f704d656e75486f6c646572223e0d0a2020266c743b3f636d732074656d706c6174652e6d656e752e746f704d656e7520636d733f2667743b0d0a3c2f6469763e0d0a3c64697620636c6173733d22626f74746f6d4d656e75486f6c646572223e0d0a2020266c743b3f636d732074656d706c6174652e6d656e752e666f6f7465724d656e7520636d733f2667743b0d0a3c2f6469763e0d0a3c64697620636c6173733d22674d6170486f6c646572223e3c2f6469763e0d0a3c64697620636c6173733d226d6170486f6c646572223e0d0a2020266c743b3f636d732074656d706c6174652e6d6f64756c652e7374617469632e70696e626f6172644d61702e6d617020636d733f2667743b0d0a3c2f6469763e, 0x626f6479207b0d0a096261636b67726f756e642d636f6c6f723a20726762283230302c3230302c323030293b0d0a7d0d0a2e736561726368486f6c646572207b0d0a6865696768743a20333070783b0d0a6d617267696e2d6c6566743a2034303070783b0d0a202020206d617267696e2d72696768743a2032303070783b0d0a7d0d0a2e736561726368486f6c64657220696e707574207b0d0a202020206261636b67726f756e642d636f6c6f723a2077686974653b0d0a20202020626f726465723a2030206e6f6e653b0d0a202020206865696768743a20323870783b0d0a202020206c696e652d6865696768743a20323870783b0d0a202020206d617267696e3a20303b0d0a2020202070616464696e673a20303b0d0a2020202077696474683a20313030253b0d0a7d0d0a2e6d61696e4d656e75486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20333570783b0d0a0972696768743a20353070783b0d0a0977696474683a2033303070783b0d0a096865696768743a20343070783b0d0a096261636b67726f756e642d636f6c6f723a20626c61636b3b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2032303b0d0a626f726465723a2030707820317078203170782031707820736f6c69642073696c7665723b0d0a7d0d0a2e6d6170486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a203070783b0d0a0972696768743a203070783b0d0a097a2d696e6465783a2031353b0d0a7d0d0a2e674d6170486f6c646572207b0d0a09706f736974696f6e3a2066697865643b0d0a09746f703a203070783b0d0a096c6566743a203070783b0d0a0972696768743a203070783b0d0a09626f74746f6d3a203070783b0d0a097a2d696e6465783a2031303b0d0a7d0d0a2e63656e746572486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20343070783b0d0a096c6566743a20353070783b0d0a0972696768743a20353070783b0d0a09626f74746f6d3a20333570783b0d0a096261636b67726f756e642d636f6c6f723a2077686974653b0d0a2020202066696c7465723a20616c706861286f7061636974793d3930293b0d0a202020207a2d696e6465783a2033303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a20202020626f726465722d746f702d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d746f702d72696768742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d72696768742d7261646975733a203570783b0d0a626f782d736861646f773a20307078203070782035707820726762283232302c203232302c20323230293b0d0a6f766572666c6f772d793a206175746f3b0d0a6f766572666c6f772d783a2068696464656e3b0d0a7d0d0a2e63656e746572486f6c646572496e76697369626c65207b0d0a09626f74746f6d3a206175746f3b0d0a626f726465723a20307078206e6f6e653b0d0a7d0d0a2e63656e746572486f6c646572496e76697369626c65202e76636d735f61726561207b0d0a6d696e2d6865696768743a3070783b0d0a7d0d0a2e63656e746572486f6c646572496e76697369626c65202e70616e656c207b0d0a7d0d0a2e63656e7465724c6566744d617267696e207b0d0a096c6566743a2032363070783b0d0a7d0d0a2e63656e74657252696768744d617267696e207b0d0a0972696768743a2032363070783b0d0a7d0d0a2e63656e74657252696768744269674d617267696e207b0d0a2020202020202072696768743a2034323570783b0d0a7d0d0a2e6c656674486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20343070783b0d0a096c6566743a20353070783b0d0a0977696474683a2032303070783b0d0a096865696768743a206175746f3b0d0a096261636b67726f756e642d636f6c6f723a2077686974653b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2033303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a626f782d736861646f773a20307078203070782035707820726762283232302c203232302c20323230293b0d0a20202020626f726465722d746f702d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d746f702d72696768742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d72696768742d7261646975733a203570783b0d0a7d0d0a2e7269676874486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20343070783b0d0a0972696768743a20353070783b0d0a0977696474683a2032303070783b0d0a096865696768743a206175746f3b0d0a096261636b67726f756e642d636f6c6f723a2077686974653b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2033303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a626f782d736861646f773a20307078203070782035707820726762283232302c203232302c20323230293b0d0a20202020626f726465722d746f702d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d746f702d72696768742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d72696768742d7261646975733a203570783b0d0a7d0d0a2e7269676874426967486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20343070783b0d0a0972696768743a20353070783b0d0a0977696474683a2033343570783b0d0a096865696768743a206175746f3b0d0a096261636b67726f756e642d636f6c6f723a2077686974653b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2033303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a2020202070616464696e673a20313070783b0d0a626f782d736861646f773a20307078203070782035707820726762283232302c203232302c20323230293b0d0a20202020626f726465722d746f702d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d746f702d72696768742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d72696768742d7261646975733a203570783b0d0a7d0d0a2e746f704d656e75486f6c646572207b0d0a09706f736974696f6e3a2066697865643b0d0a09746f703a203070783b0d0a096c6566743a20353070783b0d0a0972696768743a20353070783b0d0a096865696768743a20333070783b0d0a096261636b67726f756e642d636f6c6f723a20626c61636b3b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2033303b0d0a626f782d736861646f773a20307078203070782035707820726762283232302c203232302c20323230293b0d0a20202020626f726465722d626f74746f6d2d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d72696768742d7261646975733a203570783b0d0a7d0d0a2e746f704c6566744d656e75486f6c646572207b0d0a666c6f61743a206c6566743b0d0a7d0d0a0d0a2e626f74746f6d4d656e75486f6c646572207b0d0a09706f736974696f6e3a2066697865643b0d0a09626f74746f6d3a203070783b0d0a096c6566743a20373070783b0d0a0972696768743a2034313070783b0d0a096865696768743a20323570783b0d0a096261636b67726f756e642d636f6c6f723a20626c61636b3b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2033303b0d0a626f782d736861646f773a20307078203070782035707820726762283232302c203232302c20323230293b0d0a20202020626f726465722d746f702d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d746f702d72696768742d7261646975733a203570783b0d0a7d0d0a, '', 0),
(3, 'Docpanel Left Demo Template', '', '', 0x3c64697620636c6173733d2263656e746572486f6c6465722063656e7465724c6566744d617267696e223e0d0a2020266c743b3f636d732074656d706c6174652e6d61696e2e63656e74657220636d733f2667743b0d0a3c2f6469763e0d0a3c64697620636c6173733d226c656674486f6c646572223e0d0a2020266c743b3f636d732074656d706c6174652e617265612e6c65667420636d733f2667743b0d0a3c2f6469763e0d0a3c64697620636c6173733d22746f704d656e75486f6c646572223e0d0a20203c64697620636c6173733d22746f704c6566744d656e75486f6c646572223e0d0a20202020266c743b3f636d732074656d706c6174652e6d656e752e746f704d656e7520636d733f2667743b0d0a20203c2f6469763e0d0a20203c64697620636c6173733d22736561726368486f6c646572223e0d0a20202020266c743b3f636d732074656d706c6174652e6d6f64756c652e7374617469632e70696e626f617264536561726368426f782e73656172636820636d733f2667743b0d0a20203c2f6469763e0d0a3c2f6469763e0d0a3c64697620636c6173733d22746f704d656e75486f6c646572223e0d0a2020266c743b3f636d732074656d706c6174652e6d656e752e746f704d656e7520636d733f2667743b0d0a3c2f6469763e0d0a3c64697620636c6173733d22626f74746f6d4d656e75486f6c646572223e0d0a2020266c743b3f636d732074656d706c6174652e6d656e752e666f6f7465724d656e7520636d733f2667743b0d0a3c2f6469763e0d0a3c64697620636c6173733d22674d6170486f6c646572223e3c2f6469763e0d0a3c64697620636c6173733d226d6170486f6c646572223e0d0a2020266c743b3f636d732074656d706c6174652e6d6f64756c652e7374617469632e70696e626f6172644d61702e6d617020636d733f2667743b0d0a3c2f6469763e, 0x626f6479207b0d0a096261636b67726f756e642d636f6c6f723a20726762283230302c3230302c323030293b0d0a7d0d0a2e736561726368486f6c646572207b0d0a6865696768743a20333070783b0d0a6d617267696e2d6c6566743a2034303070783b0d0a202020206d617267696e2d72696768743a2032303070783b0d0a7d0d0a2e736561726368486f6c64657220696e707574207b0d0a202020206261636b67726f756e642d636f6c6f723a2077686974653b0d0a20202020626f726465723a2030206e6f6e653b0d0a202020206865696768743a20323870783b0d0a202020206c696e652d6865696768743a20323870783b0d0a202020206d617267696e3a20303b0d0a2020202070616464696e673a20303b0d0a2020202077696474683a20313030253b0d0a7d0d0a2e6d61696e4d656e75486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20333570783b0d0a0972696768743a20353070783b0d0a0977696474683a2033303070783b0d0a096865696768743a20343070783b0d0a096261636b67726f756e642d636f6c6f723a20626c61636b3b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2032303b0d0a626f726465723a2030707820317078203170782031707820736f6c69642073696c7665723b0d0a7d0d0a2e6d6170486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a203070783b0d0a0972696768743a203070783b0d0a097a2d696e6465783a2031353b0d0a7d0d0a2e674d6170486f6c646572207b0d0a09706f736974696f6e3a2066697865643b0d0a09746f703a203070783b0d0a096c6566743a203070783b0d0a0972696768743a203070783b0d0a09626f74746f6d3a203070783b0d0a097a2d696e6465783a2031303b0d0a7d0d0a2e63656e746572486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20343070783b0d0a096c6566743a20353070783b0d0a0972696768743a20353070783b0d0a09626f74746f6d3a20333570783b0d0a096261636b67726f756e642d636f6c6f723a2077686974653b0d0a2020202066696c7465723a20616c706861286f7061636974793d3930293b0d0a202020207a2d696e6465783a2033303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a20202020626f726465722d746f702d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d746f702d72696768742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d72696768742d7261646975733a203570783b0d0a626f782d736861646f773a20307078203070782035707820726762283232302c203232302c20323230293b0d0a6f766572666c6f772d793a206175746f3b0d0a6f766572666c6f772d783a2068696464656e3b0d0a7d0d0a2e63656e746572486f6c646572496e76697369626c65207b0d0a09626f74746f6d3a206175746f3b0d0a626f726465723a20307078206e6f6e653b0d0a7d0d0a2e63656e746572486f6c646572496e76697369626c65202e76636d735f61726561207b0d0a6d696e2d6865696768743a3070783b0d0a7d0d0a2e63656e746572486f6c646572496e76697369626c65202e70616e656c207b0d0a7d0d0a2e63656e7465724c6566744d617267696e207b0d0a096c6566743a2032363070783b0d0a7d0d0a2e63656e74657252696768744d617267696e207b0d0a0972696768743a2032363070783b0d0a7d0d0a2e63656e74657252696768744269674d617267696e207b0d0a2020202020202072696768743a2034323570783b0d0a7d0d0a2e6c656674486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20343070783b0d0a096c6566743a20353070783b0d0a0977696474683a2032303070783b0d0a096865696768743a206175746f3b0d0a096261636b67726f756e642d636f6c6f723a2077686974653b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2033303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a626f782d736861646f773a20307078203070782035707820726762283232302c203232302c20323230293b0d0a20202020626f726465722d746f702d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d746f702d72696768742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d72696768742d7261646975733a203570783b0d0a7d0d0a2e7269676874486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20343070783b0d0a0972696768743a20353070783b0d0a0977696474683a2032303070783b0d0a096865696768743a206175746f3b0d0a096261636b67726f756e642d636f6c6f723a2077686974653b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2033303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a626f782d736861646f773a20307078203070782035707820726762283232302c203232302c20323230293b0d0a20202020626f726465722d746f702d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d746f702d72696768742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d72696768742d7261646975733a203570783b0d0a7d0d0a2e7269676874426967486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20343070783b0d0a0972696768743a20353070783b0d0a0977696474683a2033343570783b0d0a096865696768743a206175746f3b0d0a096261636b67726f756e642d636f6c6f723a2077686974653b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2033303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a2020202070616464696e673a20313070783b0d0a626f782d736861646f773a20307078203070782035707820726762283232302c203232302c20323230293b0d0a20202020626f726465722d746f702d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d746f702d72696768742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d72696768742d7261646975733a203570783b0d0a7d0d0a2e746f704d656e75486f6c646572207b0d0a09706f736974696f6e3a2066697865643b0d0a09746f703a203070783b0d0a096c6566743a20353070783b0d0a0972696768743a20353070783b0d0a096865696768743a20333070783b0d0a096261636b67726f756e642d636f6c6f723a20626c61636b3b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2033303b0d0a626f782d736861646f773a20307078203070782035707820726762283232302c203232302c20323230293b0d0a20202020626f726465722d626f74746f6d2d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d72696768742d7261646975733a203570783b0d0a7d0d0a2e746f704c6566744d656e75486f6c646572207b0d0a666c6f61743a206c6566743b0d0a7d0d0a0d0a2e626f74746f6d4d656e75486f6c646572207b0d0a09706f736974696f6e3a2066697865643b0d0a09626f74746f6d3a203070783b0d0a096c6566743a20373070783b0d0a0972696768743a2034313070783b0d0a096865696768743a20323570783b0d0a096261636b67726f756e642d636f6c6f723a20626c61636b3b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2033303b0d0a626f782d736861646f773a20307078203070782035707820726762283232302c203232302c20323230293b0d0a20202020626f726465722d746f702d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d746f702d72696768742d7261646975733a203570783b0d0a7d0d0a, '', 0),
(4, 'Docpanel Right Demo Template', '', '', 0x3c64697620636c6173733d2263656e746572486f6c6465722063656e74657252696768744269674d617267696e223e0d0a2020266c743b3f636d732074656d706c6174652e6d61696e2e63656e74657220636d733f2667743b0d0a3c2f6469763e0d0a3c64697620636c6173733d227269676874426967486f6c646572223e0d0a2020266c743b3f636d732074656d706c6174652e617265612e726967687420636d733f2667743b0d0a3c2f6469763e0d0a3c64697620636c6173733d22746f704d656e75486f6c646572223e0d0a20203c64697620636c6173733d22746f704c6566744d656e75486f6c646572223e0d0a20202020266c743b3f636d732074656d706c6174652e6d656e752e746f704d656e7520636d733f2667743b0d0a20203c2f6469763e0d0a20203c64697620636c6173733d22736561726368486f6c646572223e0d0a20202020266c743b3f636d732074656d706c6174652e6d6f64756c652e7374617469632e70696e626f617264536561726368426f782e73656172636820636d733f2667743b0d0a20203c2f6469763e0d0a3c2f6469763e0d0a3c64697620636c6173733d22626f74746f6d4d656e75486f6c646572223e0d0a2020266c743b3f636d732074656d706c6174652e6d656e752e666f6f7465724d656e7520636d733f2667743b0d0a3c2f6469763e0d0a3c64697620636c6173733d22674d6170486f6c646572223e3c2f6469763e0d0a3c64697620636c6173733d226d6170486f6c646572223e0d0a2020266c743b3f636d732074656d706c6174652e6d6f64756c652e7374617469632e70696e626f6172644d61702e6d617020636d733f2667743b0d0a3c2f6469763e, 0x626f6479207b0d0a096261636b67726f756e642d636f6c6f723a20726762283230302c3230302c323030293b0d0a7d0d0a2e736561726368486f6c646572207b0d0a6865696768743a20333070783b0d0a6d617267696e2d6c6566743a2034303070783b0d0a202020206d617267696e2d72696768743a2032303070783b0d0a7d0d0a2e736561726368486f6c64657220696e707574207b0d0a202020206261636b67726f756e642d636f6c6f723a2077686974653b0d0a20202020626f726465723a2030206e6f6e653b0d0a202020206865696768743a20323870783b0d0a202020206c696e652d6865696768743a20323870783b0d0a202020206d617267696e3a20303b0d0a2020202070616464696e673a20303b0d0a2020202077696474683a20313030253b0d0a7d0d0a2e6d61696e4d656e75486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20333570783b0d0a0972696768743a20353070783b0d0a0977696474683a2033303070783b0d0a096865696768743a20343070783b0d0a096261636b67726f756e642d636f6c6f723a20626c61636b3b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2032303b0d0a626f726465723a2030707820317078203170782031707820736f6c69642073696c7665723b0d0a7d0d0a2e6d6170486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a203070783b0d0a0972696768743a203070783b0d0a097a2d696e6465783a2031353b0d0a7d0d0a2e674d6170486f6c646572207b0d0a09706f736974696f6e3a2066697865643b0d0a09746f703a203070783b0d0a096c6566743a203070783b0d0a0972696768743a203070783b0d0a09626f74746f6d3a203070783b0d0a097a2d696e6465783a2031303b0d0a7d0d0a2e63656e746572486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20343070783b0d0a096c6566743a20353070783b0d0a0972696768743a20353070783b0d0a09626f74746f6d3a20333570783b0d0a096261636b67726f756e642d636f6c6f723a2077686974653b0d0a2020202066696c7465723a20616c706861286f7061636974793d3930293b0d0a202020207a2d696e6465783a2033303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a20202020626f726465722d746f702d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d746f702d72696768742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d72696768742d7261646975733a203570783b0d0a626f782d736861646f773a20307078203070782035707820726762283232302c203232302c20323230293b0d0a6f766572666c6f772d793a206175746f3b0d0a6f766572666c6f772d783a2068696464656e3b0d0a7d0d0a2e63656e746572486f6c646572496e76697369626c65207b0d0a09626f74746f6d3a206175746f3b0d0a626f726465723a20307078206e6f6e653b0d0a7d0d0a2e63656e746572486f6c646572496e76697369626c65202e76636d735f61726561207b0d0a6d696e2d6865696768743a3070783b0d0a7d0d0a2e63656e746572486f6c646572496e76697369626c65202e70616e656c207b0d0a7d0d0a2e63656e7465724c6566744d617267696e207b0d0a096c6566743a2032363070783b0d0a7d0d0a2e63656e74657252696768744d617267696e207b0d0a0972696768743a2032363070783b0d0a7d0d0a2e63656e74657252696768744269674d617267696e207b0d0a2020202020202072696768743a2034323570783b0d0a7d0d0a2e6c656674486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20343070783b0d0a096c6566743a20353070783b0d0a0977696474683a2032303070783b0d0a096865696768743a206175746f3b0d0a096261636b67726f756e642d636f6c6f723a2077686974653b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2033303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a626f782d736861646f773a20307078203070782035707820726762283232302c203232302c20323230293b0d0a20202020626f726465722d746f702d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d746f702d72696768742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d72696768742d7261646975733a203570783b0d0a7d0d0a2e7269676874486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20343070783b0d0a0972696768743a20353070783b0d0a0977696474683a2032303070783b0d0a096865696768743a206175746f3b0d0a096261636b67726f756e642d636f6c6f723a2077686974653b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2033303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a626f782d736861646f773a20307078203070782035707820726762283232302c203232302c20323230293b0d0a20202020626f726465722d746f702d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d746f702d72696768742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d72696768742d7261646975733a203570783b0d0a7d0d0a2e7269676874426967486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20343070783b0d0a0972696768743a20353070783b0d0a0977696474683a2033343570783b0d0a096865696768743a206175746f3b0d0a096261636b67726f756e642d636f6c6f723a2077686974653b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2033303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a2020202070616464696e673a20313070783b0d0a626f782d736861646f773a20307078203070782035707820726762283232302c203232302c20323230293b0d0a20202020626f726465722d746f702d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d746f702d72696768742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d72696768742d7261646975733a203570783b0d0a7d0d0a2e746f704d656e75486f6c646572207b0d0a09706f736974696f6e3a2066697865643b0d0a09746f703a203070783b0d0a096c6566743a20353070783b0d0a0972696768743a20353070783b0d0a096865696768743a20333070783b0d0a096261636b67726f756e642d636f6c6f723a20626c61636b3b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2033303b0d0a626f782d736861646f773a20307078203070782035707820726762283232302c203232302c20323230293b0d0a20202020626f726465722d626f74746f6d2d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d72696768742d7261646975733a203570783b0d0a7d0d0a2e746f704c6566744d656e75486f6c646572207b0d0a666c6f61743a206c6566743b0d0a7d0d0a0d0a2e626f74746f6d4d656e75486f6c646572207b0d0a09706f736974696f6e3a2066697865643b0d0a09626f74746f6d3a203070783b0d0a096c6566743a20373070783b0d0a0972696768743a2034313070783b0d0a096865696768743a20323570783b0d0a096261636b67726f756e642d636f6c6f723a20626c61636b3b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2033303b0d0a626f782d736861646f773a20307078203070782035707820726762283232302c203232302c20323230293b0d0a20202020626f726465722d746f702d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d746f702d72696768742d7261646975733a203570783b0d0a7d0d0a, '', 0),
(25, 'Map Template', '', '', 0x3c64697620636c6173733d2263656e746572486f6c6465722063656e746572486f6c646572496e76697369626c65223e0d0a2020266c743b3f636d732074656d706c6174652e6d61696e2e63656e74657220636d733f2667743b0d0a3c2f6469763e0d0a3c64697620636c6173733d22746f704d656e75486f6c646572223e0d0a20203c64697620636c6173733d22746f704c6566744d656e75486f6c646572223e0d0a20202020266c743b3f636d732074656d706c6174652e6d656e752e746f704d656e7520636d733f2667743b0d0a20203c2f6469763e0d0a20203c64697620636c6173733d22736561726368486f6c646572223e0d0a20202020266c743b3f636d732074656d706c6174652e6d6f64756c652e7374617469632e70696e626f617264536561726368426f782e73656172636820636d733f2667743b0d0a20203c2f6469763e0d0a3c2f6469763e0d0a3c64697620636c6173733d22626f74746f6d4d656e75486f6c646572223e0d0a2020266c743b3f636d732074656d706c6174652e6d656e752e666f6f7465724d656e7520636d733f2667743b0d0a3c2f6469763e0d0a3c64697620636c6173733d22674d6170486f6c646572223e3c2f6469763e0d0a3c64697620636c6173733d226d6170486f6c646572223e0d0a2020266c743b3f636d732074656d706c6174652e6d6f64756c652e7374617469632e70696e626f6172644d61702e6d617020636d733f2667743b0d0a3c2f6469763e, 0x626f6479207b0d0a096261636b67726f756e642d636f6c6f723a20726762283230302c3230302c323030293b0d0a7d0d0a2e736561726368486f6c646572207b0d0a6865696768743a20333070783b0d0a6d617267696e2d6c6566743a2034303070783b0d0a202020206d617267696e2d72696768743a2032303070783b0d0a7d0d0a2e736561726368486f6c64657220696e707574207b0d0a202020206261636b67726f756e642d636f6c6f723a2077686974653b0d0a20202020626f726465723a2030206e6f6e653b0d0a202020206865696768743a20323870783b0d0a202020206c696e652d6865696768743a20323870783b0d0a202020206d617267696e3a20303b0d0a2020202070616464696e673a20303b0d0a2020202077696474683a20313030253b0d0a7d0d0a2e6d61696e4d656e75486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20333570783b0d0a0972696768743a20353070783b0d0a0977696474683a2033303070783b0d0a096865696768743a20343070783b0d0a096261636b67726f756e642d636f6c6f723a20626c61636b3b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2032303b0d0a626f726465723a2030707820317078203170782031707820736f6c69642073696c7665723b0d0a7d0d0a2e6d6170486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a203070783b0d0a0972696768743a203070783b0d0a097a2d696e6465783a2031353b0d0a7d0d0a2e674d6170486f6c646572207b0d0a09706f736974696f6e3a2066697865643b0d0a09746f703a203070783b0d0a096c6566743a203070783b0d0a0972696768743a203070783b0d0a09626f74746f6d3a203070783b0d0a097a2d696e6465783a2031303b0d0a7d0d0a2e63656e746572486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20343070783b0d0a096c6566743a20353070783b0d0a0972696768743a20353070783b0d0a09626f74746f6d3a20333570783b0d0a096261636b67726f756e642d636f6c6f723a2077686974653b0d0a2020202066696c7465723a20616c706861286f7061636974793d3930293b0d0a202020207a2d696e6465783a2031353b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a20202020626f726465722d746f702d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d746f702d72696768742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d72696768742d7261646975733a203570783b0d0a626f782d736861646f773a20307078203070782035707820726762283232302c203232302c20323230293b0d0a6f766572666c6f772d793a206175746f3b0d0a6f766572666c6f772d783a2068696464656e3b0d0a7d0d0a2e63656e746572486f6c646572496e76697369626c65207b0d0a09626f74746f6d3a206175746f3b0d0a626f726465723a20307078206e6f6e653b0d0a7d0d0a2e63656e746572486f6c646572496e76697369626c65202e76636d735f61726561207b0d0a6d696e2d6865696768743a3070783b0d0a7d0d0a2e63656e746572486f6c646572496e76697369626c65202e70616e656c207b0d0a7d0d0a2e63656e7465724c6566744d617267696e207b0d0a096c6566743a2032363070783b0d0a7d0d0a2e63656e74657252696768744d617267696e207b0d0a0972696768743a2032363070783b0d0a7d0d0a2e63656e74657252696768744269674d617267696e207b0d0a2020202020202072696768743a2034323570783b0d0a7d0d0a2e6c656674486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20343070783b0d0a096c6566743a20353070783b0d0a0977696474683a2032303070783b0d0a096865696768743a206175746f3b0d0a096261636b67726f756e642d636f6c6f723a2077686974653b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2033303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a626f782d736861646f773a20307078203070782035707820726762283232302c203232302c20323230293b0d0a20202020626f726465722d746f702d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d746f702d72696768742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d72696768742d7261646975733a203570783b0d0a7d0d0a2e7269676874486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20343070783b0d0a0972696768743a20353070783b0d0a0977696474683a2032303070783b0d0a096865696768743a206175746f3b0d0a096261636b67726f756e642d636f6c6f723a2077686974653b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2033303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a626f782d736861646f773a20307078203070782035707820726762283232302c203232302c20323230293b0d0a20202020626f726465722d746f702d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d746f702d72696768742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d72696768742d7261646975733a203570783b0d0a7d0d0a2e7269676874426967486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20343070783b0d0a0972696768743a20353070783b0d0a0977696474683a2033343570783b0d0a096865696768743a206175746f3b0d0a096261636b67726f756e642d636f6c6f723a2077686974653b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2033303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a2020202070616464696e673a20313070783b0d0a626f782d736861646f773a20307078203070782035707820726762283232302c203232302c20323230293b0d0a20202020626f726465722d746f702d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d746f702d72696768742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d72696768742d7261646975733a203570783b0d0a7d0d0a2e746f704d656e75486f6c646572207b0d0a09706f736974696f6e3a2066697865643b0d0a09746f703a203070783b0d0a096c6566743a20353070783b0d0a0972696768743a20353070783b0d0a096865696768743a20333070783b0d0a096261636b67726f756e642d636f6c6f723a20626c61636b3b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2033303b0d0a626f782d736861646f773a20307078203070782035707820726762283232302c203232302c20323230293b0d0a20202020626f726465722d626f74746f6d2d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d72696768742d7261646975733a203570783b0d0a7d0d0a2e746f704c6566744d656e75486f6c646572207b0d0a666c6f61743a206c6566743b0d0a7d0d0a0d0a2e626f74746f6d4d656e75486f6c646572207b0d0a09706f736974696f6e3a2066697865643b0d0a09626f74746f6d3a203070783b0d0a096c6566743a20373070783b0d0a0972696768743a2034313070783b0d0a096865696768743a20323570783b0d0a096261636b67726f756e642d636f6c6f723a20626c61636b3b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2033303b0d0a626f782d736861646f773a20307078203070782035707820726762283232302c203232302c20323230293b0d0a20202020626f726465722d746f702d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d746f702d72696768742d7261646975733a203570783b0d0a7d0d0a, '', 0),
(5, 'Docpanel Stack Demo Template', '', '', 0x3c64697620636c6173733d2263656e746572486f6c646572223e0d0a2020266c743b3f636d732074656d706c6174652e6d61696e2e63656e74657220636d733f2667743b0d0a3c2f6469763e0d0a3c64697620636c6173733d22746f704d656e75486f6c646572223e0d0a20203c64697620636c6173733d22746f704c6566744d656e75486f6c646572223e0d0a20202020266c743b3f636d732074656d706c6174652e6d656e752e746f704d656e7520636d733f2667743b0d0a20203c2f6469763e0d0a20203c64697620636c6173733d22736561726368486f6c646572223e0d0a20202020266c743b3f636d732074656d706c6174652e6d6f64756c652e7374617469632e70696e626f617264536561726368426f782e73656172636820636d733f2667743b0d0a20203c2f6469763e0d0a3c2f6469763e0d0a3c64697620636c6173733d22626f74746f6d4d656e75486f6c646572223e0d0a2020266c743b3f636d732074656d706c6174652e6d656e752e666f6f7465724d656e7520636d733f2667743b0d0a3c2f6469763e0d0a3c64697620636c6173733d22674d6170486f6c646572223e3c2f6469763e0d0a3c64697620636c6173733d226d6170486f6c646572223e0d0a2020266c743b3f636d732074656d706c6174652e6d6f64756c652e7374617469632e70696e626f6172644d61702e6d617020636d733f2667743b0d0a3c2f6469763e, 0x626f6479207b0d0a096261636b67726f756e642d636f6c6f723a20726762283230302c3230302c323030293b0d0a7d0d0a2e736561726368486f6c646572207b0d0a6865696768743a20333070783b0d0a6d617267696e2d6c6566743a2034303070783b0d0a202020206d617267696e2d72696768743a2032303070783b0d0a7d0d0a2e736561726368486f6c64657220696e707574207b0d0a202020206261636b67726f756e642d636f6c6f723a2077686974653b0d0a20202020626f726465723a2030206e6f6e653b0d0a202020206865696768743a20323870783b0d0a202020206c696e652d6865696768743a20323870783b0d0a202020206d617267696e3a20303b0d0a2020202070616464696e673a20303b0d0a2020202077696474683a20313030253b0d0a7d0d0a2e6d61696e4d656e75486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20333570783b0d0a0972696768743a20353070783b0d0a0977696474683a2033303070783b0d0a096865696768743a20343070783b0d0a096261636b67726f756e642d636f6c6f723a20626c61636b3b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2032303b0d0a626f726465723a2030707820317078203170782031707820736f6c69642073696c7665723b0d0a7d0d0a2e6d6170486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a203070783b0d0a0972696768743a203070783b0d0a097a2d696e6465783a2031353b0d0a7d0d0a2e674d6170486f6c646572207b0d0a09706f736974696f6e3a2066697865643b0d0a09746f703a203070783b0d0a096c6566743a203070783b0d0a0972696768743a203070783b0d0a09626f74746f6d3a203070783b0d0a097a2d696e6465783a2031303b0d0a7d0d0a2e63656e746572486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20343070783b0d0a096c6566743a20353070783b0d0a0972696768743a20353070783b0d0a09626f74746f6d3a20333570783b0d0a096261636b67726f756e642d636f6c6f723a2077686974653b0d0a2020202066696c7465723a20616c706861286f7061636974793d3930293b0d0a202020207a2d696e6465783a2031353b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a20202020626f726465722d746f702d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d746f702d72696768742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d72696768742d7261646975733a203570783b0d0a626f782d736861646f773a20307078203070782035707820726762283232302c203232302c20323230293b0d0a6f766572666c6f772d793a206175746f3b0d0a6f766572666c6f772d783a2068696464656e3b0d0a7d0d0a2e63656e746572486f6c646572496e76697369626c65207b0d0a09626f74746f6d3a206175746f3b0d0a626f726465723a20307078206e6f6e653b0d0a7d0d0a2e63656e746572486f6c646572496e76697369626c65202e76636d735f61726561207b0d0a6d696e2d6865696768743a3070783b0d0a7d0d0a2e63656e746572486f6c646572496e76697369626c65202e70616e656c207b0d0a7d0d0a2e63656e7465724c6566744d617267696e207b0d0a096c6566743a2032363070783b0d0a7d0d0a2e63656e74657252696768744d617267696e207b0d0a0972696768743a2032363070783b0d0a7d0d0a2e63656e74657252696768744269674d617267696e207b0d0a2020202020202072696768743a2034323570783b0d0a7d0d0a2e6c656674486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20343070783b0d0a096c6566743a20353070783b0d0a0977696474683a2032303070783b0d0a096865696768743a206175746f3b0d0a096261636b67726f756e642d636f6c6f723a2077686974653b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2033303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a626f782d736861646f773a20307078203070782035707820726762283232302c203232302c20323230293b0d0a20202020626f726465722d746f702d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d746f702d72696768742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d72696768742d7261646975733a203570783b0d0a7d0d0a2e7269676874486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20343070783b0d0a0972696768743a20353070783b0d0a0977696474683a2032303070783b0d0a096865696768743a206175746f3b0d0a096261636b67726f756e642d636f6c6f723a2077686974653b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2033303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a626f782d736861646f773a20307078203070782035707820726762283232302c203232302c20323230293b0d0a20202020626f726465722d746f702d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d746f702d72696768742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d72696768742d7261646975733a203570783b0d0a7d0d0a2e7269676874426967486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20343070783b0d0a0972696768743a20353070783b0d0a0977696474683a2033343570783b0d0a096865696768743a206175746f3b0d0a096261636b67726f756e642d636f6c6f723a2077686974653b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2033303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a2020202070616464696e673a20313070783b0d0a626f782d736861646f773a20307078203070782035707820726762283232302c203232302c20323230293b0d0a20202020626f726465722d746f702d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d746f702d72696768742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d72696768742d7261646975733a203570783b0d0a7d0d0a2e746f704d656e75486f6c646572207b0d0a09706f736974696f6e3a2066697865643b0d0a09746f703a203070783b0d0a096c6566743a20353070783b0d0a0972696768743a20353070783b0d0a096865696768743a20333070783b0d0a096261636b67726f756e642d636f6c6f723a20626c61636b3b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2033303b0d0a626f782d736861646f773a20307078203070782035707820726762283232302c203232302c20323230293b0d0a20202020626f726465722d626f74746f6d2d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d72696768742d7261646975733a203570783b0d0a7d0d0a2e746f704c6566744d656e75486f6c646572207b0d0a666c6f61743a206c6566743b0d0a7d0d0a0d0a2e626f74746f6d4d656e75486f6c646572207b0d0a09706f736974696f6e3a2066697865643b0d0a09626f74746f6d3a203070783b0d0a096c6566743a20373070783b0d0a0972696768743a2034313070783b0d0a096865696768743a20323570783b0d0a096261636b67726f756e642d636f6c6f723a20626c61636b3b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2033303b0d0a626f782d736861646f773a20307078203070782035707820726762283232302c203232302c20323230293b0d0a20202020626f726465722d746f702d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d746f702d72696768742d7261646975733a203570783b0d0a7d0d0a, '', 1),
(1, 'Admin Template', 'core/template/adminTemplate.php', 'AdminTemplate', NULL, NULL, NULL, 0),
(26, 'Wall Template', '', '', 0x3c64697620636c6173733d2263656e746572486f6c6465722063656e7465724c6566744d617267696e2063656e74657252696768744d617267696e223e0d0a2020266c743b3f636d732074656d706c6174652e6d61696e2e63656e74657220636d733f2667743b0d0a3c2f6469763e0d0a3c64697620636c6173733d226c656674486f6c646572223e0d0a2020266c743b3f636d732074656d706c6174652e617265612e6c65667420636d733f2667743b0d0a3c2f6469763e0d0a3c64697620636c6173733d227269676874486f6c646572223e0d0a2020266c743b3f636d732074656d706c6174652e617265612e726967687420636d733f2667743b0d0a3c2f6469763e0d0a3c64697620636c6173733d22746f704d656e75486f6c646572223e0d0a20203c64697620636c6173733d22746f704c6566744d656e75486f6c646572223e0d0a20202020266c743b3f636d732074656d706c6174652e6d656e752e746f704d656e7520636d733f2667743b0d0a20203c2f6469763e0d0a20203c64697620636c6173733d22736561726368486f6c646572223e0d0a20202020266c743b3f636d732074656d706c6174652e6d6f64756c652e7374617469632e70696e626f617264536561726368426f782e73656172636820636d733f2667743b0d0a20203c2f6469763e0d0a3c2f6469763e0d0a3c64697620636c6173733d22746f704d656e75486f6c646572223e0d0a2020266c743b3f636d732074656d706c6174652e6d656e752e746f704d656e7520636d733f2667743b0d0a3c2f6469763e0d0a3c64697620636c6173733d22626f74746f6d4d656e75486f6c646572223e0d0a2020266c743b3f636d732074656d706c6174652e6d656e752e666f6f7465724d656e7520636d733f2667743b0d0a3c2f6469763e0d0a3c64697620636c6173733d22674d6170486f6c646572223e3c2f6469763e0d0a3c64697620636c6173733d226d6170486f6c646572223e0d0a2020266c743b3f636d732074656d706c6174652e6d6f64756c652e7374617469632e70696e626f6172644d61702e6d617020636d733f2667743b0d0a3c2f6469763e, 0x626f6479207b0d0a096261636b67726f756e642d636f6c6f723a20726762283230302c3230302c323030293b0d0a7d0d0a2e736561726368486f6c646572207b0d0a6865696768743a20333070783b0d0a6d617267696e2d6c6566743a2034303070783b0d0a202020206d617267696e2d72696768743a2032303070783b0d0a7d0d0a2e736561726368486f6c64657220696e707574207b0d0a202020206261636b67726f756e642d636f6c6f723a2077686974653b0d0a20202020626f726465723a2030206e6f6e653b0d0a202020206865696768743a20323870783b0d0a202020206c696e652d6865696768743a20323870783b0d0a202020206d617267696e3a20303b0d0a2020202070616464696e673a20303b0d0a2020202077696474683a20313030253b0d0a7d0d0a2e6d61696e4d656e75486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20333570783b0d0a0972696768743a20353070783b0d0a0977696474683a2033303070783b0d0a096865696768743a20343070783b0d0a096261636b67726f756e642d636f6c6f723a20626c61636b3b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2032303b0d0a626f726465723a2030707820317078203170782031707820736f6c69642073696c7665723b0d0a7d0d0a2e6d6170486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a203070783b0d0a0972696768743a203070783b0d0a097a2d696e6465783a2031353b0d0a7d0d0a2e674d6170486f6c646572207b0d0a09706f736974696f6e3a2066697865643b0d0a09746f703a203070783b0d0a096c6566743a203070783b0d0a0972696768743a203070783b0d0a09626f74746f6d3a203070783b0d0a097a2d696e6465783a2031303b0d0a7d0d0a2e63656e746572486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20343070783b0d0a096c6566743a20353070783b0d0a0972696768743a20353070783b0d0a202020207a2d696e6465783a2033303b0d0a7d0d0a2e63656e746572486f6c646572496e76697369626c65207b0d0a09626f74746f6d3a206175746f3b0d0a626f726465723a20307078206e6f6e653b0d0a7d0d0a2e63656e746572486f6c646572496e76697369626c65202e76636d735f61726561207b0d0a6d696e2d6865696768743a3070783b0d0a7d0d0a2e63656e746572486f6c646572496e76697369626c65202e70616e656c207b0d0a7d0d0a2e63656e7465724c6566744d617267696e207b0d0a096c6566743a2032363070783b0d0a7d0d0a2e63656e74657252696768744d617267696e207b0d0a0972696768743a2032363070783b0d0a7d0d0a2e63656e74657252696768744269674d617267696e207b0d0a2020202020202072696768743a2034323570783b0d0a7d0d0a2e6c656674486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20343070783b0d0a096c6566743a20353070783b0d0a0977696474683a2032303070783b0d0a096865696768743a206175746f3b0d0a096261636b67726f756e642d636f6c6f723a2077686974653b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2033303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a626f782d736861646f773a20307078203070782035707820726762283232302c203232302c20323230293b0d0a20202020626f726465722d746f702d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d746f702d72696768742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d72696768742d7261646975733a203570783b0d0a7d0d0a2e7269676874486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20343070783b0d0a0972696768743a20353070783b0d0a0977696474683a2032303070783b0d0a096865696768743a206175746f3b0d0a096261636b67726f756e642d636f6c6f723a2077686974653b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2033303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a626f782d736861646f773a20307078203070782035707820726762283232302c203232302c20323230293b0d0a20202020626f726465722d746f702d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d746f702d72696768742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d72696768742d7261646975733a203570783b0d0a7d0d0a2e7269676874426967486f6c646572207b0d0a09706f736974696f6e3a206162736f6c7574653b0d0a09746f703a20343070783b0d0a0972696768743a20353070783b0d0a0977696474683a2033343570783b0d0a096865696768743a206175746f3b0d0a096261636b67726f756e642d636f6c6f723a2077686974653b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2033303b0d0a20202020626f726465723a2031707820736f6c69642073696c7665723b0d0a2020202070616464696e673a20313070783b0d0a626f782d736861646f773a20307078203070782035707820726762283232302c203232302c20323230293b0d0a20202020626f726465722d746f702d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d746f702d72696768742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d72696768742d7261646975733a203570783b0d0a7d0d0a2e746f704d656e75486f6c646572207b0d0a09706f736974696f6e3a2066697865643b0d0a09746f703a203070783b0d0a096c6566743a20353070783b0d0a0972696768743a20353070783b0d0a096865696768743a20333070783b0d0a096261636b67726f756e642d636f6c6f723a20626c61636b3b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2033303b0d0a626f782d736861646f773a20307078203070782035707820726762283232302c203232302c20323230293b0d0a20202020626f726465722d626f74746f6d2d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d626f74746f6d2d72696768742d7261646975733a203570783b0d0a7d0d0a2e746f704c6566744d656e75486f6c646572207b0d0a666c6f61743a206c6566743b0d0a7d0d0a0d0a2e626f74746f6d4d656e75486f6c646572207b0d0a09706f736974696f6e3a2066697865643b0d0a09626f74746f6d3a203070783b0d0a096c6566743a20373070783b0d0a0972696768743a2034313070783b0d0a096865696768743a20323570783b0d0a096261636b67726f756e642d636f6c6f723a20626c61636b3b0d0a096f7061636974793a20302e383b0d0a2020202066696c7465723a20616c706861286f7061636974793d3830293b0d0a202020207a2d696e6465783a2033303b0d0a626f782d736861646f773a20307078203070782035707820726762283232302c203232302c20323230293b0d0a20202020626f726465722d746f702d6c6566742d7261646975733a203570783b0d0a20202020626f726465722d746f702d72696768742d7261646975733a203570783b0d0a7d0d0a, '', 0);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=108 ;

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
(83, 83, 'center', 13, 0),
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
(100, 100, '', 55, 0),
(101, 101, 'map', 0, 0),
(103, 103, 'center', 57, 0),
(104, 104, 'center', 58, 0),
(107, 107, 'center', 60, 0),
(106, 106, 'search', 0, 0);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `t_user`
--

INSERT INTO `t_user` (`id`, `username`, `password`, `authkey`, `email`, `firstname`, `lastname`, `gender`, `objectid`, `registerdate`, `logindate`, `birthdate`, `active`, `image`, `imagex`, `imagey`, `imagew`, `imageh`, `facebook_uid`, `twitter_uid`, `lastonline`, `profileviews`, `orientation`, `religion`, `ethnicity`, `about`, `relationship`) VALUES
(1, 'vbms', 'fbbe3be04d98a0e73c18b25d38ac6cf1', '2de2e57cada1d89c8cddbfea0c49dbaaff2b40cc', 'silkyfx@hotmail.de', 'silvester', 'm√ºhlhaus', 1, 0, '2014-12-30 03:48:13', '2015-02-27 14:11:25', '2014-02-13', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-12-30 02:48:13', NULL, NULL, NULL, NULL, NULL, NULL);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `t_user_wall_event`
--

INSERT INTO `t_user_wall_event` (`id`, `type`, `typeid`, `userid`, `date`) VALUES
(4, 7, 7, 1, '2015-02-09 18:04:13'),
(3, 1, NULL, 1, '2015-02-08 16:59:34'),
(5, 7, 8, 1, '2015-02-09 18:16:25'),
(6, 7, 9, 1, '2015-02-09 18:38:32');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=5 ;

--
-- Dumping data for table `t_user_wall_post`
--

INSERT INTO `t_user_wall_post` (`id`, `srcuserid`, `comment`, `eventid`, `date`) VALUES
(2, 1, 0x7468697320697320612074657374206d6573736167652066726f6d2076626d73, 3, '2015-02-08 16:59:34'),
(3, 1, 0x7465737420636f6d6d656e74, 3, '2015-02-08 17:00:01'),
(4, 1, 0x747468697320697320612074657374207265706c79, 6, '2015-02-27 13:16:59');

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
(NULL, 83, 'en', 0x3c68313e4c6f67696e3c2f68313e0d0a3c703e596f75206e65656420746f206c6f67696e20746f20757365207468697320666561747572652e20596f752063616e203c6120687265663d22687474703a2f2f6f6e6c696e6534646174696e672e6e65743f7374617469633d7265676973746572223e72656769737465723c2f613e20666f722066726565206f72206c6f67696e20776974682061206e6574776f726b206c696b652066616365626f6f6b206f7220676f6f676c652e3c2f703e0d0a3c68333e52656769737465723c2f68333e0d0a3c703e496620796f7520646f6e2774206861766520616e206163636f756e7420796f752063616e203c6120687265663d22687474703a2f2f6f6e6c696e6534646174696e672e6e65743f7374617469633d7265676973746572223e72656769737465723c2f613e20666f7220696e7374616e742066726565206163636573732e3c2f703e, NULL, 0),
(NULL, 96, 'en', 0x3c68313e4c6f676f75743c2f68313e0d0a3c703e4c6f676f7574207768656e2066696e6e6973686564207573696e6720796f7572206163636f756e7420746f206b65657020796f7572206163636f756e7420736166652e3c2f703e, NULL, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
