
-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 17, 2013 at 09:54 AM
-- Server version: 5.1.69
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `u325746634_gm`
--

-- --------------------------------------------------------

--
-- Table structure for table `guild_character`
--

CREATE TABLE IF NOT EXISTS `guild_character` (
  `character_ID` int(11) NOT NULL AUTO_INCREMENT,
  `user_ID` int(11) NOT NULL,
  `name` varchar(19) COLLATE utf8_bin NOT NULL,
  `level` int(11) DEFAULT '0',
  `level_wvw` int(11) DEFAULT '0',
  `comment` mediumtext COLLATE utf8_bin NOT NULL,
  `main` tinyint(1) NOT NULL DEFAULT '0',
  `build` varchar(255) COLLATE utf8_bin NOT NULL,
  `param_ID_gameplay` int(11) NOT NULL,
  `param_ID_race` int(11) NOT NULL,
  `param_ID_profession` int(11) NOT NULL,
  PRIMARY KEY (`character_ID`),
  KEY `param_ID_classe` (`param_ID_profession`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=64 ;


--
-- Table structure for table `guild_module`
--

CREATE TABLE IF NOT EXISTS `guild_module` (
  `module_ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(254) COLLATE utf8_bin NOT NULL,
  `description` varchar(254) COLLATE utf8_bin NOT NULL,
  `page` varchar(254) COLLATE utf8_bin NOT NULL,
  `user` tinyint(1) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `rank` int(11) NOT NULL,
  PRIMARY KEY (`module_ID`),
  UNIQUE KEY `module_ID` (`module_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Dumping data for table `guild_module`
--

INSERT INTO `guild_module` (`module_ID`, `name`, `description`, `page`, `user`, `active`, `rank`) VALUES
(1, 'User Information', 'Mes infos', 'FO_Main_User.php', 1, 1, 5),
(2, 'Characters', 'Mes personnages', 'FO_Main_Character.php', 1, 1, 4),
(3, 'Bus', 'Le Bus', 'FO_Main_Bus.php', 0, 1, 2),
(4, 'Parties', 'Les Groupes', 'FO_Main_Party.php', 0, 1, 3),
(5, 'Raids', 'Les raids', 'FO_Main_Raid.php', 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `guild_param`
--

CREATE TABLE IF NOT EXISTS `guild_param` (
  `param_ID` int(11) NOT NULL AUTO_INCREMENT,
  `text_ID` varchar(255) COLLATE utf8_bin NOT NULL,
  `type` varchar(255) COLLATE utf8_bin NOT NULL,
  `value` varchar(255) COLLATE utf8_bin NOT NULL,
  `image` varchar(255) COLLATE utf8_bin NOT NULL,
  `color` varchar(7) COLLATE utf8_bin NOT NULL,
  `translation` varchar(255) COLLATE utf8_bin NOT NULL,
  `complement` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`param_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=29 ;

--
-- Dumping data for table `guild_param`
--

INSERT INTO `guild_param` (`param_ID`, `text_ID`, `type`, `value`, `image`, `color`, `translation`, `complement`) VALUES
(1, 'Elementalist', 'profession', 'El&eacute;mentaliste', 'Elementaliste', '#EF8585', 'El&eacute;mentaliste', ''),
(2, 'Mesmer', 'profession', 'Envouteur', 'Envouteur', '#F4CDFE', 'Envouteur', ''),
(3, 'Guardian', 'profession', 'Gardien', 'Gardien', '#A3D5E2', 'Gardien', ''),
(4, 'Warrior', 'profession', 'Guerrier', 'Guerrier', '#EEDAB0', 'Guerrier', ''),
(5, 'Engineer', 'profession', 'Ing&eacute;nieur', 'Ingenieur', '#DFAD8B', 'Ing&eacute;nieur', ''),
(6, 'Necromancer', 'profession', 'N&eacute;cromant', 'Necromant', '#90BFAC', 'N&eacute;cromant', ''),
(7, 'Ranger', 'profession', 'Rodeur', 'Rodeur', '#A2CB63', 'Rodeur', ''),
(8, 'Thief', 'profession', 'Voleur', 'Voleur', '#D3C2C4', 'Voleur', ''),
(9, 'Asura', 'race', 'Asura', 'Asura', '', 'Asura', ''),
(10, 'Charr', 'race', 'Charr', 'Charr', '', 'Charr', ''),
(11, 'Human', 'race', 'Humain', 'Humain', '', 'Humain', ''),
(12, 'Norn', 'race', 'Norn', 'Norn', '', 'Norn', ''),
(13, 'Sylvari', 'race', 'Sylvari', 'Sylvari', '', 'Sylvari', ''),
(14, '', 'gameplay', 'DPS', '', '#FF0033', 'DPS', ''),
(15, '', 'gameplay', 'Support', '', '#3399FF', 'Support', ''),
(16, '', 'gameplay', 'Heal', '', '#009933', 'Heal', ''),
(17, '', 'gameplay', 'Tank/DPS', '', '#FF9933', 'Tank/DPS', ''),
(18, '', 'gameplay', 'Tank/Heal', '', '#99CC33', 'Tank/Heal', ''),
(19, '', 'gameplay', 'DPS/Support', '', '#9966FF', 'DPS/Support', ''),
(20, '', 'gameplay', '-', '', '', '-', ''),
(22, 'saturday', 'day', '1', '', '', 'Samedi', '6'),
(23, 'sunday', 'day', '2', '', '', 'Dimanche', '7'),
(24, 'monday', 'day', '3', '', '', 'Lundi', '1'),
(25, 'tuesday', 'day', '4', '', '', 'Mardi', '2'),
(26, 'wednesday', 'day', '5', '', '', 'Mercredi', '3'),
(27, 'thursday', 'day', '6', '', '', 'Jeudi', '4'),
(28, 'friday', 'day', '7', '', '', 'Vendredi', '5');

-- --------------------------------------------------------

--
-- Table structure for table `guild_profession`
--

CREATE TABLE IF NOT EXISTS `guild_profession` (
  `profession_ID` int(11) NOT NULL,
  `name` varchar(254) COLLATE utf8_bin NOT NULL,
  `param_ID` int(11) NOT NULL,
  `user_ID_coach` int(11) DEFAULT NULL,
  `strategy` longtext COLLATE utf8_bin NOT NULL,
  `build` varchar(255) COLLATE utf8_bin NOT NULL,
  `partyOrder` int(11) NOT NULL,
  UNIQUE KEY `profession_ID` (`profession_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `guild_profession`
--

INSERT INTO `guild_profession` (`profession_ID`, `name`, `param_ID`, `user_ID_coach`, `strategy`, `build`, `partyOrder`) VALUES
(1, 'Elementalist', 1, NULL, '', '', 3),
(2, 'Mesmer', 2, NULL, '', '', 5),
(3, 'Guardian', 3, NULL, '', '', 1),
(4, 'Warrior', 4, NULL, '', '', 2),
(5, 'Engineer', 5, NULL, '', '', 6),
(6, 'Necromancer', 6, NULL, '', '', 4),
(7, 'Ranger', 7, NULL, '', '', 7),
(8, 'Thief', 8, NULL, '', '', 8);

-- --------------------------------------------------------

--
-- Table structure for table `guild_raid_absence`
--

CREATE TABLE IF NOT EXISTS `guild_raid_absence` (
  `raid_absence_ID` int(11) NOT NULL AUTO_INCREMENT,
  `user_ID` int(11) NOT NULL,
  `dateAbsence` date NOT NULL,
  PRIMARY KEY (`raid_absence_ID`),
  UNIQUE KEY `raid_absent_ID` (`raid_absence_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Table structure for table `guild_raid_event`
--

CREATE TABLE IF NOT EXISTS `guild_raid_event` (
  `raid_event_ID` int(11) NOT NULL AUTO_INCREMENT,
  `dateRaid` date NOT NULL,
  `time` varchar(255) COLLATE utf8_bin NOT NULL,
  `map` varchar(255) COLLATE utf8_bin NOT NULL,
  `color` varchar(7) COLLATE utf8_bin NOT NULL,
  `event` varchar(255) COLLATE utf8_bin NOT NULL,
  `user_ID_leader` int(11) NOT NULL,
  `comment` varchar(1000) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`raid_event_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=41 ;

--
-- Dumping data for table `guild_raid_event`
--

INSERT INTO `guild_raid_event` (`raid_event_ID`, `dateRaid`, `time`, `map`, `color`, `event`, `user_ID_leader`, `comment`) VALUES
(0, '2013-11-11', 'ex. 21h-23h', 'ex :Vizunah, rouge, etc...', '#006600', 'évènement', 48, 'Commentaire'),
(1, '2013-12-20', 'ex. 21h-23h', 'ex :Vizunah, rouge, etc...', '#0033FF', 'évènement', 48, 'Commentaire');

-- --------------------------------------------------------

--
-- Table structure for table `guild_raid_presence`
--

CREATE TABLE IF NOT EXISTS `guild_raid_presence` (
  `raid_presence_ID` int(11) NOT NULL AUTO_INCREMENT,
  `user_ID` int(11) NOT NULL,
  `dateEvent` date NOT NULL,
  `character_ID` int(11) NOT NULL,
  PRIMARY KEY (`raid_presence_ID`),
  UNIQUE KEY `raid_presence_ID` (`raid_presence_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=86 ;

-- --------------------------------------------------------

--
-- Table structure for table `guild_userinfo`
--

CREATE TABLE IF NOT EXISTS `guild_userinfo` (
  `user_ID` int(11) NOT NULL,
  `commander` tinyint(1) NOT NULL,
  `comment` mediumtext COLLATE utf8_bin NOT NULL,
  `monday` tinyint(1) NOT NULL DEFAULT '0',
  `tuesday` tinyint(1) NOT NULL DEFAULT '0',
  `wednesday` tinyint(1) NOT NULL DEFAULT '0',
  `thursday` tinyint(1) NOT NULL DEFAULT '0',
  `friday` tinyint(1) NOT NULL DEFAULT '0',
  `saturday` tinyint(1) NOT NULL DEFAULT '0',
  `sunday` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
