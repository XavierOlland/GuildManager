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

//PHPBB connection / Connexion à phpBB
include('resources/phpBB_Connect.php');
//GuildManager main configuration file / Fichier de configuration principal GuildManager
include('resources/config.php');

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
echo "<h2>Calendrier des raids</h2>
			<br />
			<div class='extand' id='result'></div>";
//Event display / Affichage des évènements
echo "<div id='event'><p>Cliquez sur un &eacute;v&eacute;nement pour afficher le d&eacute;tail ici.</p></div>
			<div id='parties'></div>
			</div>
			<div class='Right'>";
//Presence-Absence module / Module de gestion des présences-absence
if ($cfg_calendar_mode == 'Presence'){
//Mode de gestion "Présence"
echo "<h5>Mes pr&eacute;sences</h5>
			<div id=\"presence\"></div>"; }
else { 
//Mode de gestion "Absence"
echo "<h5>Mes absences</h5>
			<h6>Ajouter une absence</h6>
			<form action=\"\" method=\"post\">
			<table>
				<tr><td>Date : </td><td><input style='width:100px' type=\"text\" id=\"dateEvent\" /></td></tr>
				<tr><td></td><td><input style='width:100px' type=\"button\" name=\"submit\" id=\"submit\" value=\"Enregistrer\" onclick=\"saveAbsence()\"/></td></tr>
			</table>
			</form>
			<div id=\"absence\"></div>";
};
echo "
			</div>
		</div>
		<div class='Copyright'>Copyright &copy; 2013 Xavier Olland, publi&eacute; sous licence GNU AGPL</div>
	</div>";
//Scripts
//Match up score / Affichage des scores du match up
echo "
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
