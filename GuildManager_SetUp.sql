-- phpMyAdmin SQL Dump
-- version OVH
-- http://www.phpmyadmin.net
--
-- Host: mysql51-107.perso
-- Generation Time: Feb 08, 2014 at 02:49 PM
-- Server version: 5.1.66
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `guildmanager`
--

-- --------------------------------------------------------

--
-- Table structure for table `gm_character`
--

CREATE TABLE IF NOT EXISTS `gm_character` (
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
  KEY `param_ID_classe` (`param_ID_profession`),
  KEY `main` (`main`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gm_dictionnary`
--

CREATE TABLE IF NOT EXISTS `gm_dictionnary` (
  `dictionnary_ID` int(11) NOT NULL AUTO_INCREMENT,
  `variable_name` varchar(254) COLLATE utf8_bin NOT NULL,
  `entity` varchar(254) COLLATE utf8_bin NOT NULL,
  `entity_name` varchar(254) COLLATE utf8_bin DEFAULT NULL,
  `table_ID` int(11) DEFAULT NULL,
  `table_column_name` varchar(254) COLLATE utf8_bin DEFAULT NULL,
  `en_EN` mediumtext COLLATE utf8_bin,
  `fr_FR` mediumtext COLLATE utf8_bin,
  UNIQUE KEY `dictionnary_ID` (`dictionnary_ID`),
  KEY `entity_name` (`entity_name`),
  KEY `entity` (`entity`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=167 ;

--
-- Dumping data for table `gm_dictionnary`
--

INSERT INTO `gm_dictionnary` (`dictionnary_ID`, `variable_name`, `entity`, `entity_name`, `table_ID`, `table_column_name`, `en_EN`, `fr_FR`) VALUES
(1, 'day_0', 'table', 'param', 28, NULL, 'Friday', 'Vendredi'),
(2, 'day_1', 'table', 'param', 22, NULL, 'Saturday', 'Samedi'),
(3, 'day_2', 'table', 'param', 23, NULL, 'Sunday', 'Dimanche'),
(4, 'day_3', 'table', 'param', 24, NULL, 'Monday', 'Lundi'),
(5, 'day_4', 'table', 'param', 25, NULL, 'Tuesday', 'Mardi'),
(6, 'day_5', 'table', 'param', 26, NULL, 'Wednesday', 'Mercredi'),
(7, 'day_6', 'table', 'param', 27, NULL, 'Thursday', 'Jeudi'),
(8, 'profession_1', 'table', 'param', 1, NULL, 'Elementalist', 'Elémentaliste'),
(9, 'profession_2', 'table', 'param', 2, NULL, 'Mesmer', 'Envouteur'),
(10, 'profession_3', 'table', 'param', 3, NULL, 'Guardian', 'Gardien'),
(11, 'profession_4', 'table', 'param', 4, NULL, 'Warrior', 'Guerrier'),
(12, 'profession_5', 'table', 'param', 5, NULL, 'Engineer', 'Ingénieur'),
(13, 'profession_6', 'table', 'param', 6, NULL, 'Necromancer', 'Nécromant'),
(14, 'profession_7', 'table', 'param', 7, NULL, 'Ranger', 'Rodeur'),
(15, 'profession_8', 'table', 'param', 8, NULL, 'Thief', 'Voleur'),
(16, 'race_1', 'table', 'param', 9, NULL, 'Asura', 'Asura'),
(17, 'race_2', 'table', 'param', 10, NULL, 'Charr', 'Charr'),
(18, 'race_3', 'table', 'param', 11, NULL, 'Human', 'Human'),
(19, 'race_4', 'table', 'param', 12, NULL, 'Norn', 'Norn'),
(20, 'race_5', 'table', 'param', 13, NULL, 'Sylvari', 'Sylvari'),
(21, 'gameplay_1', 'table', 'param', 14, NULL, 'DPS', 'DPS'),
(22, 'gameplay_2', 'table', 'param', 15, NULL, 'Support', 'Support'),
(23, 'gameplay_3', 'table', 'param', 16, NULL, 'Heal', 'Heal'),
(24, 'gameplay_4', 'table', 'param', 17, NULL, 'Tank/DPS', 'Tank/DPS'),
(25, 'gameplay_5', 'table', 'param', 18, NULL, 'Tank/Heal', 'Tank/Heal'),
(26, 'gameplay_6', 'table', 'param', 19, NULL, 'DPS/Support', 'DPS/Support'),
(27, 'gameplay_0', 'table', 'param', 20, NULL, '-', '-'),
(28, 'character_name', 'table', 'character', NULL, 'name', 'Name', 'Personnage'),
(29, 'character_level', 'table', 'character', NULL, 'level', 'Level', 'Niveau'),
(30, 'character_level_wvw', 'table', 'character', NULL, 'level_wvw', 'WvW', 'McM'),
(31, 'character_comment', 'table', 'character', NULL, 'comment', 'Comment', 'Commentaire'),
(32, 'character_main', 'table', 'character', NULL, 'main', 'Main', 'Principal'),
(33, 'character_build', 'table', 'character', NULL, 'build', 'Build', 'Build'),
(34, 'character_gameplay', 'table', 'character', NULL, 'param_ID_gameplay', 'Gameplay', 'Gameplay'),
(35, 'character_race', 'table', 'character', NULL, 'param_ID_race', 'Race', 'Race'),
(36, 'character_profession', 'table', 'character', NULL, 'param_ID_profession', 'Profession', 'Profession'),
(37, 'module_name', 'table', 'module', NULL, 'name', 'Name', 'Nom'),
(38, 'module_description', 'table', 'module', NULL, 'description', 'Description', 'Description'),
(39, 'module_active', 'table', 'module', NULL, 'active', 'Active', 'Actif'),
(40, 'module_rank', 'table', 'module', NULL, 'rank', 'Rank', 'Ordre'),
(41, 'profession_name', 'table', 'profession', NULL, 'name', 'Name', 'Nom'),
(42, 'profession_coach', 'table', 'profession', NULL, 'user_ID_coach', 'Coach', 'Coach'),
(43, 'profession_strategy', 'table', 'profession', NULL, 'strategy', 'Strategy', 'Stratégie'),
(44, 'profession_build', 'table', 'profession', NULL, 'build', 'Advised build', 'Build conseillé'),
(45, 'profession_partyorder', 'table', 'profession', NULL, 'partyOrder', 'Party order', 'Ordre pour les groupes'),
(46, '_player', 'generic', NULL, NULL, '', 'Player', 'Joueur'),
(47, 'raid_absence_date', 'table', 'raid_absence', NULL, 'dateAsence', 'Absence date', 'Date d''absence'),
(48, '_user', 'generic', NULL, NULL, NULL, 'User', 'Utilisateur'),
(49, 'raid_event_color', 'table', 'raid_event', NULL, 'dateEvent', 'Color', 'Couleur'),
(50, '_date', 'generic', '', NULL, '', 'Date', 'Date'),
(51, 'raid_event_time', 'table', 'raid_event', NULL, 'time', 'Time', 'Horaires'),
(52, 'raid_event_map', 'table', 'raid_event', NULL, 'map', 'Map', 'Carte'),
(53, 'raid_event_event', 'table', 'raid_event', NULL, 'event', 'Event', 'Evénement'),
(54, 'raid_event_leader', 'table', 'raid_event', NULL, 'user_ID_leader', 'Leader', 'Commandant'),
(55, 'raid_event_comment', 'table', 'raid_event', NULL, 'comment', 'Comment', 'Commentaire'),
(56, '_copyright', 'generic', NULL, NULL, NULL, 'Copyright &copy; 2013 Xavier Olland, published under GNU AGPL license', 'Copyright &copy; 2013 Xavier Olland, publi&eacute; sous licence GNU AGPL'),
(57, 'index_h2_1', 'page', 'index', NULL, NULL, 'Welcome to the guild management tool', 'Bienvenue dans l''outil de gestion de guilde'),
(58, 'index_p_1', 'page', 'index', NULL, NULL, 'A simple but powerfull tool, with real pieces of tool in it !', 'Un outil simple et performant avec des vrais morceaux d''outils dedans<br />'),
(59, 'FO_Main_Bus_td_1', 'page', 'FO_Main_Bus', NULL, NULL, 'Click an icon to display the profession information.', 'Cliquez sur une icône pour afficher les personnages de la classe.'),
(60, '_create_parties', 'generic', NULL, NULL, NULL, 'Create parties', 'Crées les groupes'),
(61, '_auto', 'generic', NULL, NULL, NULL, 'Auto', 'Auto'),
(62, '_manual', 'generic', NULL, NULL, NULL, 'Manual', 'Manuel'),
(63, 'FO_Main_Bus_h5_1', 'page', 'FO_Main_Bus', NULL, NULL, 'Statistics', 'Statistiques'),
(64, 'FO_Main_Bus_h6_1', 'page', 'FO_Main_Bus', NULL, NULL, 'Professions', 'Professions'),
(65, 'FO_Main_Bus_h6_2', 'page', 'FO_Main_Bus', NULL, NULL, 'Gameplays', 'Gameplays'),
(66, 'module_1', 'table', 'module', 1, NULL, 'User information', 'Mes informations'),
(67, 'module_2', 'table', 'module', 2, NULL, 'My characters', 'Mes personnages'),
(68, 'module_3', 'table', 'module', 3, NULL, 'The Bus', 'Le Bus'),
(69, 'module_4', 'table', 'module', 4, NULL, 'Parties', 'Les groupes'),
(70, 'module_5', 'table', 'module', 5, NULL, 'Raid planner', 'Les raids'),
(71, '_menu', 'generic', 'FO_Div_Menu', NULL, NULL, 'Menu', 'Menu'),
(72, '_setting', 'generic', 'FO_Div_Menu', NULL, NULL, 'Settings', 'Paramètrage'),
(73, '_return', 'generic', 'FO_Div_Menu', NULL, NULL, 'Back to the forum', 'Retour au forum'),
(74, '_matchup', 'generic', 'FO_Div_Match', NULL, NULL, 'Match Up', 'Match Up'),
(75, 'FO_Div_Party_h3_1', 'page', 'FO_Div_Party', NULL, NULL, 'Players organization', 'Répartition des joueurs'),
(76, 'FO_Div_Party_party', 'page', 'FO_Div_Party', NULL, NULL, 'Party', 'Groupe'),
(77, 'FO_Main_Character_td_1', 'page', 'FO_Main_Character', NULL, NULL, 'Click an icon to display the profession information.', 'Cliquez sur une icône pour afficher les personnages de la classe.'),
(78, 'FO_Main_Character_a_1', 'page', 'FO_Main_Character', NULL, NULL, 'Add new character', 'Ajouter un personnage'),
(79, 'FO_Main_Bus_h2_1', 'page', 'FO_Main_Bus', NULL, NULL, 'The Bus', 'Le Bus'),
(80, 'FO_Main_Character_h2_1', 'page', 'FO_Main_Character', NULL, NULL, 'My characters', 'Mes personnages'),
(81, 'FO_Main_Character_delete_error', 'page', 'FO_Main_Character', NULL, NULL, 'Error while suppressing character.', 'Erreur lors de la suppression.'),
(82, 'FO_Main_Character_delete_success', 'page', 'FO_Main_Character', NULL, NULL, 'The character has been deleted.', 'Le personnage a été supprimé.'),
(83, 'FO_Main_Character_warning_1', 'page', 'FO_Main_Character', NULL, NULL, 'Are you sure you want to delete ', 'Etes-vous certain de vouloir supprimer '),
(84, 'FO_Main_Character_warning_2', 'page', 'FO_Main_Character', NULL, NULL, ' ? This action cannot be cancelled.', ' ? Cette action est irréversible.'),
(85, '_yes', 'generic', NULL, NULL, NULL, 'Yes', 'Oui'),
(86, '_no', 'generic', NULL, NULL, NULL, 'No', 'Non'),
(87, '_del', 'generic', NULL, NULL, NULL, 'del.', 'suppr.'),
(88, '_see', 'generic', NULL, NULL, NULL, 'See', 'Voir'),
(89, 'FO_Div_Profession_h3_1', 'page', 'FO_Div_Profession', NULL, NULL, 'General information', 'Informations générales'),
(90, 'FO_Div_Profession_h3_2', 'page', 'FO_Div_Profession', NULL, NULL, 'Main characters', 'Personnages principaux'),
(91, 'FO_Div_Profession_h3_3', 'page', 'FO_Div_Profession', NULL, NULL, 'Rerolls', 'Personnages secondaires'),
(92, '_character', 'generic', NULL, NULL, NULL, 'Character', 'Personnage'),
(93, '_save', 'generic', NULL, NULL, NULL, 'Save', 'Enregistrer'),
(94, 'FO_Main_CharacterEdit_h5_1', 'page', 'FO_Main_CharacterEdit', NULL, NULL, 'My other characters', 'Mes autres personnages'),
(95, 'FO_Main_CharacterEdit_h5_3', 'page', 'FO_Main_CharacterEdit', NULL, NULL, 'The other', 'Les autres'),
(96, 'FO_Main_CharacterEdit_h5_2', 'page', 'FO_Main_CharacterEdit', NULL, NULL, 'The other character of', 'Les autres personnages de'),
(97, 'FO_Main_CharacterEdit_a_1', 'page', 'FO_Main_CharacterEdit', NULL, NULL, 'Add new character', 'Ajouter un personnage'),
(98, '_error_record', 'generic', NULL, NULL, NULL, 'Error while saving. Try again.', 'Erreur lors de l''enregistrement. Essayez à nouveau.'),
(99, 'FO_Main_CharacterEdit_update', 'page', 'FO_Main_CharacterEdit', NULL, NULL, 'The character has been updated.', 'Le personnage a été mis à jour.'),
(100, 'FO_Main_CharacterEdit_create', 'page', 'FO_Main_CharacterEdit', NULL, NULL, 'The character has been created.', 'Le personnage a été créé.'),
(101, 'profession_1', 'table', 'param_plural', 1, NULL, 'Elementalists', 'Elémentalistes'),
(102, 'profession_2_plural', 'table', 'param_plural', 2, NULL, 'Mesmers', 'Envouteurs'),
(103, 'profession_3_plural', 'table', 'param_plural', 3, NULL, 'Guardians', 'Gardiens'),
(104, 'profession_4_plural', 'table', 'param_plural', 4, NULL, 'Warriors', 'Guerriers'),
(105, 'profession_5_plural', 'table', 'param_plural', 5, NULL, 'Engineers', 'Ingénieurs'),
(106, 'profession_6_plural', 'table', 'param_plural', 6, NULL, 'Necromancers', 'Nécromants'),
(107, 'profession_7_plural', 'table', 'param_plural', 7, NULL, 'Rangers', 'Rodeurs'),
(108, 'profession_8_plural', 'table', 'param_plural', 8, NULL, 'Thieves', 'Voleurs'),
(109, 'FO_Main_User_update', 'page', 'FO_Main_User', NULL, NULL, 'Your information has been updated', 'Vos informations ont bien été mises à jour.'),
(110, 'FO_Main_User_h3_1', 'page', 'FO_Main_User', NULL, NULL, 'Information', 'Informations'),
(111, 'FO_Main_User_h4_1', 'page', 'FO_Main_User', NULL, NULL, 'Presence day', 'Jours de présence'),
(112, 'FO_Main_User_h4_1', '', NULL, NULL, NULL, NULL, NULL),
(113, 'FO_Main_User_h5_1', 'page', 'FO_Main_User', NULL, NULL, 'My other characters', 'Mes autres personnages'),
(114, 'FO_Main_User_h5_2', 'page', 'FO_Main_User', NULL, NULL, 'The characters of', 'Les personnages de'),
(115, 'userinfo_commander', 'table', 'userinfo', NULL, NULL, 'Commander', 'Commandant'),
(116, 'userinfo_comment', 'table', 'userinfo', NULL, NULL, 'Comment', 'Commentaire'),
(117, 'FO_Main_Raid_h2_1', 'page', 'FO_Main_Raid', NULL, NULL, 'Raids calendar', 'Calendrier des raids'),
(118, 'FO_Main_Raid_p_1', 'page', 'FO_Main_Raid', NULL, NULL, 'Click on an event to display its details here.', 'Cliquez sur un événement pour afficher le détail ici.'),
(119, 'FO_Main_Raid_h5_1', 'page', 'FO_Main_Raid', NULL, NULL, 'My presence', 'Mes présences'),
(120, 'FO_Main_Raid_h5_2', 'page', 'FO_Main_Raid', NULL, NULL, 'My absence', 'Mes absences'),
(121, 'FO_Main_Raid_h6_1', 'page', 'FO_Main_Raid', NULL, NULL, 'Register an absence', 'Enregistrer une absence'),
(122, 'FO_Div_Absence_h6_1', 'page', 'FO_Div_Absence', NULL, NULL, 'Registered absence', 'Absence prévues'),
(123, '_error_delete', 'generic', NULL, NULL, NULL, 'Error while deleting.', 'Erreur lors de la suppression.'),
(124, 'FO_Div_Calendar_a_1', 'page', 'FO_Div_Calendar', NULL, NULL, 'Prev.', 'Préc.'),
(125, 'FO_Div_Calendar_a_2', 'page', 'FO_Div_Calendar', NULL, NULL, 'Current month', 'Mois en cours'),
(126, 'FO_Div_Calendar_a_3', 'page', 'FO_Div_Calendar', NULL, NULL, 'Next', 'Suiv.'),
(127, 'FO_Div_Event_join', 'page', 'FO_Div_Event', NULL, NULL, 'Join', 'Participer'),
(128, 'FO_Div_Event_p_1', 'page', 'FO_Div_Event', NULL, NULL, 'Participating', 'Membres présents'),
(129, '_perso', 'generic', NULL, NULL, NULL, 'Character', 'Perso'),
(130, 'FO_Div_Chantal_h3_1', 'page', 'FO_Div_Chantal', NULL, NULL, 'Events to come', 'Evénements à venir'),
(131, 'FO_Div_Chantal_p_1', 'page', 'FO_Div_Chantal', NULL, NULL, 'Participants', 'Participants'),
(132, 'BO_Main_h2_1', 'page', 'BO_Main', NULL, NULL, 'Setting tool', 'Outil de parametrage'),
(133, 'BO_Main_p_1', 'page', 'BO_Main', NULL, NULL, 'Click on an event to display its details here.', 'Cliquez sur un événement pour afficher le détail ici.'),
(134, 'BO_Div_Calendar_a_1', 'page', 'BO_Div_Calendar', NULL, NULL, 'Prev.', 'Préc.'),
(135, 'BO_Div_Calendar_a_2', 'page', 'BO_Div_Calendar', NULL, NULL, 'Current month', 'Mois en cours'),
(136, 'BO_Div_Calendar_a_3', 'page', 'BO_Div_Calendar', NULL, NULL, 'Next', 'Suiv.'),
(137, 'BO_Div_Event_p_1', 'page', 'BO_Div_Event', NULL, NULL, 'In the left menu you can activate/deactivate access to the different modules.<br/>Just below you can handle the event in the calendar.', 'Dans le menu de gauche vous pouvez activer/désactiver les accés aux différents modules.<br />Ci-dessous vous pouvez gérer les événements de l''agenda.'),
(138, 'BO_Main_h2_2', 'page', 'BO_Main', NULL, NULL, 'Raids calendar', 'Calendrier des raids'),
(139, 'BO_Div_Event_p_2', 'page', 'BO_Div_Event', NULL, NULL, 'Participating', 'Membres présents'),
(140, '_module', 'generic', NULL, NULL, NULL, 'Module', 'Module'),
(141, '_act', 'generic', NULL, NULL, NULL, 'Act.', 'Act.'),
(142, '_order', 'generic', NULL, NULL, NULL, 'Order', 'Ordre'),
(143, 'BO_Div_Event_p_1', 'page', 'BO_Div_Event', NULL, NULL, 'Event Deleted', 'Evénement supprimé.'),
(144, 'BO_Div_Event_p_2', 'page', 'BO_Div_Event', NULL, NULL, 'Click on an event to display its details here.', 'Cliquez sur un événement pour afficher le détail ici.'),
(145, 'BO_Div_Event_p_3', 'page', 'BO_Div_Event', NULL, NULL, 'There is already an event this date. You should first edit this event.', 'Un événement existe déjà à cette date. Par sécurité, vous devez éditer directement cet événement.'),
(146, 'BO_Div_Event_p_4', 'page', 'BO_Div_Event', NULL, NULL, 'Event updated.', 'Evénement mis à jour.'),
(147, '_delete', 'generic', NULL, NULL, NULL, 'Delete', 'Supprimer'),
(148, '_edit_mode', 'generic', NULL, NULL, NULL, 'Go to edit mode', 'Modifiez le calendrier'),
(149, 'FO_Div_Register_h4_1', 'generic', 'FO_Div_Register', NULL, NULL, 'Register !', 'Enregistrez vous !'),
(150, 'FO_Div_Register_p_1', 'generic', 'FO_Div_Register', NULL, NULL, 'This content is only available for guild members. Register first, and wait for administrator to give you access.', 'Ce contenu n''est accessible qu''aux membres de la guilde. Enregistrez-vous et attendez qu''un administrateur valide votre compte pour pouvoir y accéder.'),
(151, 'FO_Div_Register_h2_1', 'generic', 'FO_Div_Register', NULL, NULL, 'Already a member ? Log In !', 'Déjà membre de la guilde ? Log In !'),
(152, 'FO_Div_Register_td_1', 'generic', 'FO_Div_Register', NULL, NULL, 'Login', 'Login'),
(153, 'FO_Div_Register_td_2', 'generic', 'FO_Div_Register', NULL, NULL, 'Password', 'Mot de passe'),
(154, 'FO_Div_Register_td_3', 'generic', 'FO_Div_Register', NULL, NULL, 'Stay connected', 'Connexion automatique'),
(155, 'FO_Div_Register_td_4', 'generic', 'FO_Div_Register', NULL, NULL, 'Connection', 'Connexion'),
(156, 'FO_Div_Register_h3_1', 'generic', 'FO_Div_Register', NULL, NULL, 'Want to join ?', 'Vous voulez nous rejoindre ?'),
(157, 'FO_Div_Register_p_2', 'generic', 'FO_Div_Register', NULL, NULL, 'Register', 'S''enregistrer'),
(158, 'BO_Div_Event_p_5', 'page', 'BO_Div_Event', NULL, NULL, 'Participating', 'Membres présents'),
(159, 'FO_Div_Event_a_1', 'page', 'FO_Div_Event', NULL, NULL, 'You need to register a character prior to joining the event.', 'Vous devez enregistrer un personnage pour participer aux évènements.'),
(160, '_red', 'generic', '', NULL, NULL, 'Red', 'Rouge'),
(161, '_blue', 'generic', '', NULL, NULL, 'Blue', 'Bleu'),
(162, '_green', 'generic', '', NULL, NULL, 'Green', 'Vert'),
(163, '_gold', 'generic', '', NULL, NULL, 'Gold', 'Doré'),
(164, '_error_character', 'generic', NULL, NULL, NULL, 'You have to select a character in order to join the event.', 'Vous devez sélectionner un personnage pour participer à l''évènement.'),
(165, 'FO_Main_User_warning_1', 'page', 'FO_Main_User', NULL, NULL, 'User ', 'L''utilisateur '),
(166, 'FO_Main_User_warning_2', 'page', 'FO_Main_User', NULL, NULL, ' and all his character will be deleted. This action cannot be cancelled. Are you sure you want to continue ?', ' et tous ces personnages seront supprimés. Cette action est irréversible. ëtes vous certains de vouloir continuer ?');

-- --------------------------------------------------------

--
-- Table structure for table `gm_module`
--

CREATE TABLE IF NOT EXISTS `gm_module` (
  `module_ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(254) COLLATE utf8_bin NOT NULL,
  `description` varchar(254) COLLATE utf8_bin NOT NULL,
  `page` varchar(254) COLLATE utf8_bin NOT NULL,
  `user` tinyint(1) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `rank` int(11) NOT NULL,
  UNIQUE KEY `module_ID` (`module_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=6 ;

--
-- Dumping data for table `gm_module`
--

INSERT INTO `gm_module` (`module_ID`, `name`, `description`, `page`, `user`, `active`, `rank`) VALUES
(1, 'User Information', 'Mes infos', 'FO_Main_User.php', 1, 1, 5),
(2, 'Characters', 'Mes personnages', 'FO_Main_Character.php', 1, 1, 4),
(3, 'Bus', 'Le Bus', 'FO_Main_Bus.php', 0, 1, 2),
(5, 'Raids', 'Les raids', 'FO_Main_Raid.php', 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `gm_param`
--

CREATE TABLE IF NOT EXISTS `gm_param` (
  `param_ID` int(11) NOT NULL AUTO_INCREMENT,
  `text_ID` varchar(255) COLLATE utf8_bin NOT NULL,
  `type` varchar(255) COLLATE utf8_bin NOT NULL,
  `value` varchar(255) COLLATE utf8_bin NOT NULL,
  `image` varchar(255) COLLATE utf8_bin NOT NULL,
  `color` varchar(7) COLLATE utf8_bin NOT NULL,
  `translation` varchar(255) COLLATE utf8_bin NOT NULL,
  `complement` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`param_ID`),
  KEY `type` (`type`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=29 ;

--
-- Dumping data for table `gm_param`
--

INSERT INTO `gm_param` (`param_ID`, `text_ID`, `type`, `value`, `image`, `color`, `translation`, `complement`) VALUES
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
(28, 'friday', 'day', '0', '', '', 'Vendredi', '5');

-- --------------------------------------------------------

--
-- Table structure for table `gm_profession`
--

CREATE TABLE IF NOT EXISTS `gm_profession` (
  `profession_ID` int(11) NOT NULL,
  `name` varchar(254) COLLATE utf8_bin NOT NULL,
  `param_ID` int(11) NOT NULL,
  `user_ID_coach` int(11) DEFAULT NULL,
  `strategy` longtext COLLATE utf8_bin NOT NULL,
  `build` varchar(255) COLLATE utf8_bin NOT NULL,
  `partyOrder` int(11) NOT NULL,
  UNIQUE KEY `profession_ID` (`profession_ID`),
  KEY `param_ID` (`param_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `gm_profession`
--

INSERT INTO `gm_profession` (`profession_ID`, `name`, `param_ID`, `user_ID_coach`, `strategy`, `build`, `partyOrder`) VALUES
(1, 'Elementalist', 1, NULL, '', '', 3),
(2, 'Mesmer', 2, NULL, '', '', 5),
(3, 'Guardian', 3, 51, '', 'http://gw2skills.net/editor/?fUMQJASWlUgqCHFSLEmIFSuAbBYPwI4LjueQRYIDB-jkDBYLAoLKaUEQkFA0HJL7pIasVWFRjVXDTVKpqXBSFD2cG2gWQzfIpyAovAA-w', 1),
(4, 'Warrior', 4, 53, '', '', 2),
(5, 'Engineer', 5, NULL, '', '', 6),
(6, 'Necromancer', 6, 50, '', '', 4),
(7, 'Ranger', 7, NULL, '', '', 7),
(8, 'Thief', 8, NULL, '', '', 8);

-- --------------------------------------------------------

--
-- Table structure for table `gm_raid_absence`
--

CREATE TABLE IF NOT EXISTS `gm_raid_absence` (
  `raid_absence_ID` int(11) NOT NULL AUTO_INCREMENT,
  `user_ID` int(11) NOT NULL,
  `dateAbsence` date NOT NULL,
  UNIQUE KEY `raid_absent_ID` (`raid_absence_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gm_raid_event`
--

CREATE TABLE IF NOT EXISTS `gm_raid_event` (
  `raid_event_ID` int(11) NOT NULL AUTO_INCREMENT,
  `dateRaid` date NOT NULL,
  `time` varchar(255) COLLATE utf8_bin NOT NULL,
  `map` varchar(255) COLLATE utf8_bin NOT NULL,
  `color` varchar(7) COLLATE utf8_bin NOT NULL,
  `event` varchar(255) COLLATE utf8_bin NOT NULL,
  `user_ID_leader` int(11) NOT NULL,
  `comment` varchar(1000) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`raid_event_ID`),
  KEY `dateRaid` (`dateRaid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Dumping data for table `gm_raid_event`
--

INSERT INTO `gm_raid_event` (`raid_event_ID`, `dateRaid`, `time`, `map`, `color`, `event`, `user_ID_leader`, `comment`) VALUES
(0, '2014-02-08', '21-23', 'Home', '#000066', 'Raid', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `gm_raid_presence`
--

CREATE TABLE IF NOT EXISTS `gm_raid_presence` (
  `raid_presence_ID` int(11) NOT NULL AUTO_INCREMENT,
  `user_ID` int(11) NOT NULL,
  `dateEvent` date NOT NULL,
  `character_ID` int(11) NOT NULL,
  UNIQUE KEY `raid_presence_ID` (`raid_presence_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gm_userinfo`
--

CREATE TABLE IF NOT EXISTS `gm_userinfo` (
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
