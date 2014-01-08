<?php
/*  Guild Manager v1.0.3
	Guild Manager has been designed to help Guild Wars 2 (and other MMOs) guilds to organize themselves for PvP battles.
    Copyright (C) 2013  Xavier Olland

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU Affero General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>. */

//MySQL connection / Connexion MySQL
$con = mysql_connect($dbhost,$dbuser,$dbpasswd);

if (!$con) { die('Could not connect: ' . mysql_error()); } 
mysql_select_db($dbname, $con);
mysql_set_charset('utf8');

//locale variables / Variables locales
//local / locale => en_EN || fr_FR
$local = 'en_EN';
date_default_timezone_set('Europe/Brussels');
setlocale(LC_ALL, $local);

//GuildManager table prefix / Préfixe des tables Guild Manager
$gm_prefix = 'gm_';

//Guild Wars 2 api variables / Variables de l'API Guild Wars 2
//Server ID can be found here : https://api.guildwars2.com/v1/world_names.json?lang=en
//L'ID du serveur peut être récupéré ici : https://api.guildwars2.com/v1/world_names.json?lang=fr
$api_srv = 2103;
$api_lng = substr($local, 0, 2 );

//phpBB Groups permissions / Permissions des groupes phpBB
//Standard (members / membres)
$cfg_groups = array('5','8','9');
//Backoffice (officer / officiers)
$cfg_groups_backoffice = array('5','9');

//Guild Manager display title / Titre affiché dans Guild Manager
$cfg_title = 'Guild Manager';

//Calendar variables / Variables du calendrier
//Mode : Absence/Presence
$cfg_calendar_mode = 'Presence';
//Limit for event display in the past ('x day') / Limite d'affichage des événements passés en jours ('x day').
$event_limit = '7 day';


?>