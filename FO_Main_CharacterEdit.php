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
$id = $_GET['character']; if ( strlen($id) == 0 ) { $id = 0 ; };
$usertest = htmlentities($user->data['user_id'],ENT_QUOTES,"UTF-8");


//Character info query / Récupération des informations du personnage
$sql="SELECT c.user_ID, c.character_ID, c.name, c.param_ID_race, c.param_ID_profession, c.main, c.level, c.level_wvw, c.build, 
CASE WHEN LENGTH(c.build) > 0 THEN CONCAT('<a href=',c.build,'>".$lng[g__see]."</a>') ELSE '' END AS buildlink,
c.comment, c.param_ID_gameplay, u.username 
FROM ".$gm_prefix."character AS c 
INNER JOIN ".$table_prefix."users AS u ON u.user_ID=c.user_ID
WHERE character_ID = '$id'";
$result = mysqli_query($con,$sql);
$perso = mysqli_fetch_array($result,MYSQLI_ASSOC);

//Start of html page / Début du code html
echo "
<html>
<head>";
//Common <head> elements / Eléments <head> communs
	include('resources/php/FO_Head.php');
	//Dynamic background / Fond d'écran dynamique
if ( $theme_dynamic_bg == 1 ) {
if ( $id==0 ) { $class = 'Main' ; } 
else { $row = mysqli_fetch_row(mysqli_query($con,"SELECT text_ID FROM ".$gm_prefix."param 
INNER JOIN ".$gm_prefix."character ON ".$gm_prefix."character.param_ID_profession=".$gm_prefix."param.param_ID 
WHERE character_ID='$id'")); 
$class = $row[0]; } ; 
echo "
<style> body {background-image:url('resources/theme/$theme/images/".$class."_BG.jpg');background-size:100%; background-repeat:no-repeat;} </style>" ;};


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
		echo "
		</div>";
		echo "
		<div id='Page'>
			<div id='Core'>";

//Action result /Résultat de l'action
	echo "<div id='result'></div>";
//If viewer different from user : form is disabled / Si le lecteur est différent de l'utilisateur : le formulaire est désactivé
				if ( $perso['user_ID'] == $usertest || $id==0 ) { $disabled=""; } else { $disabled="disabled"; };

echo "

				<div id='CharacterTitle'><h2>".$lng['g__character']." : ".$perso['name']."</h2></div>
				<form id='Character' action='' method='post' onsubmit=\"return false\">
				<input type='hidden' name='user_ID' value='".$usertest."'>
				<input type='hidden' id='character_ID' name='character_ID' value='".$perso['character_ID']."'>
				<p>
				<table>
					<tr><td>".$lng['t_character_name']." :</td><td><input class='p' type='text' name='name' value='".$perso['name']."' ".$disabled." /></td><td></td></tr>
					<tr><td>".$lng['t_character_race']." :</td><td><select class='p' name='race' ".$disabled.">";
					$sqlr="SELECT p.param_ID, d.$local AS value FROM ".$gm_prefix."param AS p LEFT JOIN ".$gm_prefix."dictionary AS d ON d.table_ID=p.param_ID AND entity_name='param' WHERE type = 'race'";
					$listr=mysqli_query($con,$sqlr);      
					while($resultr=mysqli_fetch_array($listr,MYSQLI_ASSOC))
					{ echo "<option value='".$resultr['param_ID']."' " ;
					 if ($resultr['param_ID']==$perso['param_ID_race']) { echo "selected" ;} ;
					 echo ">".$resultr['value']."</option>";
					};
					echo "</select></td><td></td></tr>
					<tr><td>".$lng['t_character_profession']." : </td><td><select class='p' name='profession' ".$disabled.">";
					$sqlp="SELECT p.param_ID, d.$local AS value FROM ".$gm_prefix."param AS p LEFT JOIN ".$gm_prefix."dictionary AS d ON d.table_ID=p.param_ID AND entity_name='param' WHERE type = 'profession'";
					$listp=mysqli_query($con,$sqlp);
					while($resultp=mysqli_fetch_array($listp,MYSQLI_ASSOC))
					{ echo "<option value='".$resultp['param_ID']."' " ;
					 if ($resultp['param_ID']==$perso['param_ID_profession']) { echo "selected" ;} ;
					echo ">".$resultp['value']."</option>" ;
					};
					echo "</select></td><td></td></tr>
					<tr><td>".$lng['t_character_main']." :</td><td><input class='p' type='checkbox' name='main' value='1' ".$disabled; if ($perso['main']) { echo " checked" ;} ;echo "/></td><td></td></tr>
					<tr><td>".$lng['t_character_level']." :</td><td><input class='p' type='text' name='level' value='".$perso['level']."' ".$disabled."/></td><td></td></tr>
					<tr><td>".$lng['t_character_level_wvw']." :</td><td><input class='p' type='text' name='level_wvw' value='".$perso['level_wvw']."' ".$disabled."/></td><td></td></tr>
					<tr><td>".$lng['t_character_gameplay']." :</td><td><select class='p' name='gameplay' ".$disabled.">";
					$sqlg="SELECT p.param_ID, d.$local AS value FROM ".$gm_prefix."param AS p LEFT JOIN ".$gm_prefix."dictionary AS d ON d.table_ID=p.param_ID AND entity_name='param'  WHERE type = 'gameplay'";
					$listg=mysqli_query($con,$sqlg);
					while($resultg=mysqli_fetch_array($listg,MYSQLI_ASSOC))
					{ echo "<option value='".$resultg['param_ID']."' " ;
					 if ($resultg['param_ID']==$perso['param_ID_gameplay']) { echo "selected" ;} ;
					 echo ">".$resultg['value']."</option>" ;
					};
					echo "</select>
					</td><td></td></tr>
					<tr><td>".$lng['t_character_build']." :</td><td><input class='p' type='text' name='build' value='".$perso['build']."' ".$disabled."/> ".$perso['buildlink']."</td></tr>
					<tr><td></td><td>
					( <a class='menu' href='http://en.gw2skills.net/editor/' target='blank' >GW2 Skills</a> ,
					 <a class='menu' href='http://intothemists.com/calc/' target='blank' >Into the mists</a> ,
					 <a class='menu' href='http://gw2buildcraft.com/calculator/' target='blank' >GW2 BuildCraft</a> )</td></tr>
					<tr class='top'><td>".$lng['t_character_comment']." :</td><td colspan='2'><textarea name='comment' form='Character' rows='3' cols='50' ".$disabled.">".$perso['comment']."</textarea></td></tr>
					<tr><td colspan='3'></td></tr>
					<tr><td></td><td><input type='submit' value='".$lng['g__save']."' ".$disabled."/></td><td></td></tr>
				</table></p>
				</form>
				<div id='Result'></div>
				</div>";
				
//Other characters / Autres personnages
//Of the user / de l'utilisateur
echo "
				<div id='Right'>";
				if ( $perso['user_ID'] == $usertest || $id == 0){
				echo "<h5>".$lng['p_FO_Main_CharacterEdit_h5_1']."</h5>
				<table>";
					$sqlp="SELECT a.user_ID, a.character_ID, a.name, a.param_ID_profession, c.text_ID, c.color 
					FROM ".$gm_prefix."character AS a 
					INNER JOIN ".$gm_prefix."param AS c ON c.param_ID=a.param_ID_profession 
					WHERE a.user_ID = ".$usertest." 
					AND character_ID != '".$perso['character_ID']."' 
					ORDER BY a.main DESC, a.param_ID_profession"; }
				else {
				echo "<h5>".$lng['p_FO_Main_CharacterEdit_h5_2']." ".$perso['username']."</h5>
				<table>";
					$sqlp="SELECT a.user_ID, a.character_ID, a.name, a.param_ID_profession, c.text_ID, c.color 
					FROM ".$gm_prefix."character AS a 
					INNER JOIN ".$gm_prefix."param AS c ON c.param_ID=a.param_ID_profession 
					WHERE a.user_ID = ".$perso['user_ID']." 
					ORDER BY a.main DESC, a.param_ID_profession";};
				$listp=mysqli_query($con,$sqlp);
				while($resultp=mysqli_fetch_array($listp,MYSQLI_ASSOC))
				{ echo "<tr style='background-color:".$resultp['color']."'>
				<td><a href='FO_Main_Profession.php?id=".$resultp['param_ID_profession']."' ><img src='resources/theme/$theme/images/".$resultp['text_ID']."_Icon.png'></a></td>
				<td><a class='colorbg' href='FO_Main_CharacterEdit.php?character=".$resultp['character_ID']."'>".$resultp['name']."</a></td></tr>"; };
				echo "
				</table><br />
					<a id='Right' href='FO_Main_CharacterEdit.php?character=0'>".$lng['p_FO_Main_CharacterEdit_a_1']."</a><br />" ;
					if ( $id != 0 )  {
					$row = mysqli_fetch_row(mysqli_query($con,"SELECT $local FROM ".$gm_prefix."dictionary WHERE table_ID='".$perso['param_ID_profession']."' AND entity_name='param_plural'")); $profession = $row[0];

					//of the same profession / de la même profession
					echo "
					<br />
					<h5>".$lng['p_FO_Main_CharacterEdit_h5_3']." ".$profession."</h5>
					<table>";
						$sqlp="SELECT a.user_ID, a.character_ID, a.name, u.username, a.param_ID_profession, c.text_ID, c.color 
						FROM ".$gm_prefix."character AS a 
						INNER JOIN ".$gm_prefix."param AS c ON c.param_ID=a.param_ID_profession 
						INNER JOIN ".$table_prefix."users AS u ON u.user_id=a.user_ID
						WHERE a.user_ID != ".$perso['user_ID']." 
						AND a.param_ID_profession='".$perso['param_ID_profession']."'
						ORDER BY a.main DESC";
						$listp=mysqli_query($con,$sqlp);
						while($resultp=mysqli_fetch_array($listp,MYSQLI_ASSOC))
						{ echo "<tr style='background-color:".$resultp['color']."'>
						<td><a href='FO_Main_Profession.php?id=".$resultp['param_ID_profession']."' ><img src='resources/theme/$theme/images/".$resultp['text_ID']."_Icon.png'></a></td>
						<td><a class='colorbg' href='FO_Main_CharacterEdit.php?character=".$resultp['character_ID']."'>".$resultp['name']."</a></td></tr>"; };
		echo "</table>" ; } ; 
		echo "
				</div>
			</div>
		<div id='Copyright'>".$lng['g__copyright']."</div>
	</div>
	<script>
		$('#Character').submit(function(){   
			$.ajax({
				type: \"POST\",
				url: \"resources/php/FO_Script_Character.php\",
				data: $('#Character').serialize(),
				success: function(id){ 
					$('#character_ID').val(id); }
			});
		});
	</script>
	<script>var api_lng = '$api_lng'; var default_world_id = $api_srv</script>
	<script src=\"resources/js/Menu_Match.js\"></script>
</body>
</html>" ;}  
//Non authorized user / utilisateur non autorisé
else { include('resources/php/FO_Div_Register.php'); }
?>

