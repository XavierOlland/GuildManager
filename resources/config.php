<?php
/*  Guild Manager has been designed to help Guild Wars 2 (and other MMOs) guilds to organize themselves for PvP battles.
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

//Enter here your mySql connection details
$con = mysql_connect($dbhost,$dbuser,$dbpasswd);
if (!$con) { die('Could not connect: ' . mysql_error()); } 
mysql_select_db($dbname, $con);
mysql_set_charset('utf8');
//locale variables / Variables locale
date_default_timezone_set('Europe/Brussels');
setlocale(LC_ALL, 'fr_FR');

//phpBB Groups permissions / Permissions des groupes phpBB
//Standard (members / membres)
$cfg_groups = array('5','8','9');
//Backoffice (officer / officiers)
$cfg_groups_backoffice = array('5','9');

//Title
$cfg_title = 'Guild Manager';

//Calendar variables / Variables du calendrier
$cfg_calendar_mode = 'Presence'
?>