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

//Start of html page / Début du code html
echo	"<html>
<head>";
	include('resources/php/FO_Head.php');
	echo "<style> body {background-image:url('resources/images/Perso_BG.jpg');background-size:100%; background-repeat:no-repeat;} </style>
</head>
<body>
	<div class='Main'>
		<div class='Title'><h1> $cfg_title </h1></div>";
		//User permissions test / Test des permissions utilisateur
		if (in_array($user->data['group_id'],$cfg_groups)){
		//Registered user code / Code pour utilisateurs enregistrés
		echo "
		<div class='Menu'>";
			include('resources/php/FO_Div_Menu.php');
			include('resources/php/FO_Div_Match.php');
		echo "
		</div>";
		echo "
		<div class='Page'>
			<div class='Core'>
			<h2>".$lng[p_index_h2_1]."</h2>
			<p>".$lng[p_index_p_1]."</p>
				<div id='Lobby'></div>
			</div>
			<div class='right'></div>
			<div class='Copyright'>".$lng[g__copyright]."</div>
		</div>
	</div>
	<script >
		$('#Lobby').load(\"resources/php/FO_Div_Chantal.php\");
	</script>
	<script>var api_lng = '$api_lng'; var default_world_id = $api_srv</script>
	<script  src=\"resources/js/Menu_Match.js\"></script>  
</body>
</html>"; }
//Non authorized user / utilisateur non autorisé
else { include('resources/php/FO_Div_Register.php'); }
?>
