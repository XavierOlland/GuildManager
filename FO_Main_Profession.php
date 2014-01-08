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

//Page variables creation / Création des variables spécifiques pour la page
$id = $_GET['id']; 
$class = mysql_result(mysql_query("SELECT text_ID FROM ".$gm_prefix."param WHERE param_ID=$id"),0);
$color = mysql_result(mysql_query("SELECT color FROM ".$gm_prefix."param WHERE param_ID=$id"),0);

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
<style> body {background-image:url('resources/images/".$class."_BG.jpg');background-size:100%; background-repeat:no-repeat;} </style>
</head>

	<body>
	<div class='Main'>
		<div class='Title'><h1>".$cfg_title."</h1></div>";
//User permissions test / Test des permissions utilisateur
			if (in_array($user->data['group_id'],$cfg_groups)){
			//Registered user code / Code pour utilisateurs enregistrés
	echo "<div class='Menu'>";
			include('resources/php/FO_Div_Menu.php');
			include('resources/php/FO_Div_Match.php');
		echo "</div>
		<div class='Page'>
			<div class='Core'>
				<div class='extand' id='result'></div>
			</div>
			<div class='right'>
				<h6>Professions</h6>
				<table>
				<tr>";
				$sql="SELECT a.param_ID, a.color, a.text_ID, a.translation FROM ".$gm_prefix."param AS a WHERE a.type='profession'" ;
				$list=mysql_query($sql);
				while($result=mysql_fetch_row($list))
				{ echo "<tr>
								<td><a onclick=\"$('#result').load('resources/php/FO_Div_Profession.php?id=".$result[0]."');\" href='#'>
								<img src='resources/images/".$result[2]."_Icon.png'></a></td>
								<td><a class='table' onclick=\"$('#result').load('resources/php/FO_Div_Profession.php?id=".$result[0]."');\" href='#'>".$result[3]."</a></td>
								</tr>";}
				echo "</table></div>
		</div>
		<div class='Copyright'>Copyright &copy; 2013 Xavier Olland, publi&eacute; sous licence GNU AGPL</div>
	</div>
	<script type=\"text/javascript\">$('#result').load('resources/php/FO_Div_Profession.php?id=".$id."');</script>
	<script type=\"text/javascript\"  src=\"resources/js/Menu_Match.js\"></script>
</body>
</html>"; }
//Non authorized user / utilisateur non autorisé
else { include('resources/php/FO_Div_Register.php'); }
?>
