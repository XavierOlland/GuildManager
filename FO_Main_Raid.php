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

//PHPBB connection / Connexion à phpBB
include('resources/phpBB_Connect.php');
//GuildManager main configuration file / Fichier de configuration principal GuildManager
include('resources/config.php');
//Language management / Gestion des traductions
include('resources/language.php');

//Page variables creation / Création des variables spécifiques pour la page
$date = date('Y-m-d', time());

//Creating language variables
//include('resources/language.php');

//Start of html page / Début du code html
echo "
<html>
<head>";
//Common <head> elements / Eléments <head> communs
	include('resources/php/FO_Head.php');
//Page specific <head> elements / Eléments <head> spécifique à la page
echo "
<style> body {background-image:url('resources/images/Perso_BG.jpg');background-size:100%; background-repeat:no-repeat;} </style>
</head>

<body>
	<div class='Main'>
		<div class='Title'><h1>".$cfg_title."</h1></div>";
//User permissions test / Test des permissions utilisateur
			if (in_array($user->data['group_id'],$cfg_groups)){
			//Registered user code / Code pour utilisateurs enregistrés
		echo "
		<div class='Menu'>";
			include('resources/php/FO_Div_Menu.php');
			include('resources/php/FO_Div_Match.php');
		echo "</div>";
	 echo "
		<div class='Page'>
			<div class='Core'>";
				//Calendar display / Affichage du calendrier
				echo "<h2>".$lng[p_FO_Main_Raid_h2_1]."</h2>
				<br />
				<div class='extand' id='result'></div>";
				//Event display / Affichage des évènements
				echo "<div id='event'><p>".$lng[p_FO_Main_Raid_p_1]."</p></div>
				<div id='parties'></div>";
				//To come...
				//if (in_array($user->data['group_id'],$cfg_groups_backoffice)){ 
				//echo "<a class='menu' onclick=\"$('#result').load('resources/php/BO_Div_Calendar.php?date=$date');\" href='#'>".$lng[g__edit_mode]."</a>"; };
			echo "</div>
			<div class='Right'>";
//Presence-Absence module / Module de gestion des présences-absence
if ($cfg_calendar_mode == 'Presence'){
//Mode de gestion "Présence"
echo "<h5>".$lng[p_FO_Main_Raid_h5_1]."</h5>
			<div id=\"presence\"></div>"; }
else { 
//Mode de gestion "Absence"
echo "<h5>".$lng[p_FO_Main_Raid_h5_2]."</h5>
			<h6>".$lng[p_FO_Main_Raid_h6_1]."</h6>
			<form action=\"\" method=\"post\">
			<table>
				<tr><td>".$lng[g__date]." : </td><td><input style='width:100px' type=\"text\" id=\"dateEvent\" /></td></tr>
				<tr><td></td><td><input style='width:100px' type=\"button\" name=\"submit\" id=\"submit\" value=\"".$lng[g__save]."\" onclick=\"saveAbsence()\"/></td></tr>
			</table>
			</form>
			<div id=\"absence\"></div>";
};
echo "
			</div>
		</div>
		<div class='Copyright'>".$lng[g__copyright]."</div>
	</div>";
//Scripts
//Match up score / Affichage des scores du match up
echo "
	<script>var api_lng = '$api_lng'; var default_world_id = $api_srv</script>
	<script type=\"text/javascript\"  src=\"resources/js/Menu_Match.js\"></script> ";
//Loading module / chargement des modules 
echo "
	<script type=\"text/javascript\">
	$('#result').load(\"resources/php/FO_Div_Calendar.php?user_ID=$usertest&date=$date\");
	$('#presence').load(\"resources/php/FO_Div_Presence.php?user_ID=".$usertest."\");
	</script>";
//Presence module form management / Gestion du formulaire de présence
echo "
	<script type=\"text/javascript\"> $(function() { $( \"#dateEvent\" ).datepicker(); });</script>
</body>
</html>"; }
//Non authorized user / utilisateur non autorisé
else { include('resources/php/FO_Div_Register.php'); }
?>
