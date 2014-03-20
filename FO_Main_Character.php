<?php
/*  Guild Manager v1.1.0 (Princesse d’Ampshere)
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
$id = $_GET['character'];
$action = $_GET['action'];
if (in_array($user->data['group_id'],$cfg_groups_backoffice)){ $admin = 1; };
//Start of html page / Début du code html
echo "
<html>
<head>";
//Common <head> elements / Eléments <head> communs
	include('resources/php/FO_Head.php');
//Page specific <head> elements / Eléments <head> spécifique à la page
echo "
</head>

<body>
	<div id='Main'>
		<div id='Title'><h1>".$cfg_title."</h1></div>";
//User permissions test / Test des permissions utilisateur
			if (in_array($user->data['group_id'],$cfg_groups)){
			//Registered user code / Code pour utilisateurs enregistrés
		echo "
		<div id='Left'>";
			include('resources/php/FO_Div_Menu.php');
			include('resources/php/FO_Div_Match.php');
		echo "</div>";
		echo "
		<div id='Page'>
			<div id='CoreFull'>";
				//Character deletion / Suppression d'un personnage
				if ($action=='delete'){
				$id = $_GET['character'];
				//Checking user identity / Vérification de l'identité de l'exécutant
				$test = mysqli_fetch_row(mysqli_query($con,"SELECT user_ID FROM ".$gm_prefix."character WHERE character_ID='$id'"));
				if ( $test[0] == $user->data['user_id'] ) {
				$sql1="DELETE FROM ".$gm_prefix."character WHERE character_ID='$id'"; 
				if (!mysqli_query($con,$sql1)){die(mysqli_error()."<p>".$lng[p_FO_Main_Character_delete_error]."</p>".$sql1);}; 
				echo "<p>".$lng['p_FO_Main_Character_delete_success']."</p>"; }; };

				//Diplay of characters / Affichage de la liste des personnage
				$sql="SELECT a.user_ID, a.character_ID, a.name, a.param_ID_race, rd.$local AS race, a.param_ID_profession, pd.$local AS profession, 
				CASE WHEN IFNULL(a.main,0)=1 THEN '".$lng[g__yes]."' ELSE '".$lng[g__no]."' END AS main, 
				a.level, a.level_wvw, a.build,CASE WHEN LENGTH(a.build) > 0 THEN CONCAT('<a class=\'colorbg\' href=\'',a.build,'\' target=\'blank\'>".$lng[g__see]."</a>') ELSE '' END AS buildlink,
				a.comment, c.text_ID, c.color, a.param_ID_gameplay, o.value AS gameplay 
				FROM ".$gm_prefix."character AS a 
				INNER JOIN ".$gm_prefix."param AS c ON c.param_ID=a.param_ID_profession
				INNER JOIN ".$gm_prefix."param AS r ON r.param_ID=a.param_ID_race
				LEFT JOIN ".$gm_prefix."dictionary AS rd ON rd.table_ID=r.param_ID AND rd.entity_name='param' 					
				INNER JOIN ".$gm_prefix."param AS o ON o.param_ID=a.param_ID_gameplay
				INNER JOIN ".$gm_prefix."profession AS p ON p.param_ID=c.param_ID
				LEFT JOIN ".$gm_prefix."dictionary AS pd ON pd.table_ID=p.param_ID AND pd.entity_name='param' 
				WHERE a.user_ID = ".$user->data['user_id']." 
				ORDER BY a.main DESC, a.param_ID_profession";
				$list=mysqli_query($con,$sql);
				echo "
				<h2>".$lng['p_FO_Main_Character_h2_1']."</h2>
				<table border=1>
					<tr>
						<th></th>
						<th>".$lng['g__character']."</th>
						<th>".$lng['t_character_race']."</th>
						<th>".$lng['t_character_profession']."</th>
						<th>".$lng['t_character_main']."</th>
						<th>".$lng['t_character_level']."</th>
						<th>".$lng['t_character_level_wvw']."</th>
						<th>".$lng['t_character_gameplay']."</th>
						<th>".$lng['t_character_build']."</th>
						<th>".$lng['t_character_comment']."</th>
						<th></th>
					</tr>";
					
					while($result=mysqli_fetch_array($list,MYSQLI_ASSOC))
					{ echo "
					<tr style='background-color:".$result['color']."'>
						<td class='colorbg'><a onclick=\"$('#Result').load('resources/php/FO_Div_Profession.php?id=".$result['param_ID_profession']."');$('#result').show( 'blind' );\" href=\"javascript:void(0)\"><img src='resources/theme/$theme/images/".$result['text_ID']."_Icon.png'></a></td>
						<td class='colorbg'><a class='colorbg' href='FO_Main_CharacterEdit.php?character=".$result['character_ID']."'>".$result['name']."</a></td>
						<td class='colorbg'>".$result['race']."</td>
						<td class='colorbg'><a class='colorbg' href='FO_Main_Profession.php?id=".$result['param_ID_profession']."&admin=$admin' >".$result['profession']."</a></td>
						<td class='colorbg'>".$result['main']."</td>
						<td class='colorbg'>".$result['level']."</td>
						<td class='colorbg'>".$result['level_wvw']."</td>
						<td class='colorbg'>".$result['gameplay']."</td>
						<td class='colorbg'>".$result['buildlink']."</td>
						<td class='colorbg'>".$result['comment']."</td>
						<td class='colorbg'><a class='colorbg' href='FO_Main_Character.php?action=delete&character=".$result['character_ID']."' onclick=\"return confirm('".$lng['p_FO_Main_Character_warning_1'].$result['name'].$lng['p_FO_Main_Character_warning_2']."');\">".$lng['g__del']."</a></td>
						</tr>";};
					
					//Profession display / Affichage des professions
					echo "
					<tr>
						<td><img src='resources/theme/$theme/images/upperReturn.png'></td>
						<td id='Left' colspan='10'>".$lng['p_FO_Main_Character_td_1']."</td>
					</tr>
				</table>
				<br />
				<a class='table' href='FO_Main_CharacterEdit.php?character=0'>".$lng['p_FO_Main_Character_a_1']."</a><br />
				<br />
				<div id='Result'></div>
			</div>
		</div>
		<div id='Copyright'>".$lng['g__copyright']."</div>
    </div>
	<script>var api_lng = '$api_lng'; var default_world_id = $api_srv</script>
	<script src=\"resources/js/Menu_Match.js\"></script>
</body>
</html>"; }
//Non authorized user / utilisateur non autorisé
else { include('resources/php/FO_Div_Register.php'); }
?>

