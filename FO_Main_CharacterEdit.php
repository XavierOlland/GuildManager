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
$action = $_GET['action']; 

//Creating language variables
//include('resources/language.php');

//Executing Action / Execution de l'action
//Mise à jour
if ($action=='update'){
$sql1="UPDATE guild_character SET user_ID ='$_POST[user_ID]', character_ID='$_POST[character_ID]', name='$_POST[name]', param_ID_race='$_POST[race]', param_ID_profession='$_POST[profession]', level='$_POST[level]', level_wvw='$_POST[level_wvw]', comment='$_POST[comment]', main=(case WHEN '$_POST[main]'='1' THEN 1 ELSE 0 END), param_ID_gameplay='$_POST[gameplay]', build='$_POST[build]' WHERE character_ID='$_POST[character_ID]' "; 
if (!mysql_query($sql1,$con)){$actionresult="Erreur dans l'enregistrement.";} 
else { $actionresult="<p class='red'>Le personnage a &eacute;t&eacute; mis &agrave; jour.</p>";} ; };
//Création
if ($action=='create'){ 
$sql1="INSERT INTO guild_character (user_ID, name, param_ID_race, param_ID_profession, level, level_wvw, comment, main, param_ID_gameplay, build ) VALUES ('$_POST[user_ID]','$_POST[name]','$_POST[race]','$_POST[profession]','$_POST[level]','$_POST[level_wvw]','$_POST[comment]',CASE WHEN '$_POST[main]'='1' THEN 1 ELSE 0 END,'$_POST[gameplay]','$_POST[build]')"; 
if (!mysql_query($sql1,$con)){$actionresult="Erreur dans l'enregistrement.";} 
else { $actionresult="<p class='red'>Le personnage a &eacute;t&eacute; cr&eacute;&eacute;.</p>";} ; };

if ($action=='create' ) { $id = mysql_insert_id() ; } 
else { $id = $_GET['character'] ; }
if ($action=='new' ) { $class = 'Perso' ; } 
else { $class = mysql_result(mysql_query("SELECT text_ID FROM guild_param 
INNER JOIN guild_character ON guild_character.param_ID_profession=guild_param.param_ID 
WHERE character_ID='$id'"),0); } ;
$usertest = htmlentities($user->data['user_id'],ENT_QUOTES,"UTF-8");

$sql="SELECT c.user_ID, c.character_ID, c.name, c.param_ID_race, c.param_ID_profession, c.main, c.level, c.level_wvw, c.build, 
CASE WHEN LENGTH(c.build) > 0 THEN CONCAT('<a href=',c.build,'>Voir</a>') ELSE '' END AS buildlink,
c.comment, c.param_ID_gameplay, u.username 
FROM guild_character AS c 
INNER JOIN ".$table_prefix."users AS u ON u.user_ID=c.user_ID
WHERE character_ID = '$id'";
$result = mysql_query($sql);
$perso = mysql_fetch_array($result);



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
		echo "
		<div class='Menu'>";
					include('resources/php/FO_Div_Menu.php');
					include('resources/php/FO_Div_Match.php');
		echo "
		</div>";
		echo "
		<div class='Page'>
			<div class='Core'>";

//Action result /Résultat de l'action
	echo "<div id='result'></div>";
//If viewer different from user : form is disabled / Si le lecteur est différent de l'utilisateur : le formulaire est désactivé
				if ( $perso['user_ID'] == $usertest || $action=='new') { $disabled=""; } else { $disabled="disabled"; };

//Existing Character / Personnage existant
				if ( strlen($id) > 0 ) {
				echo $actionresult."
				<h2>Personnage : ".$perso['name']."</h2>

				<form id='perso' action='FO_Main_CharacterEdit.php?character=".$perso['character_ID']."&action=update' method='post'>
				<input type='hidden' name='user_ID' value='".$perso['user_ID']."'>
				<input type='hidden' name='character_ID' value='".$perso['character_ID']."'>
				<p>
				<table>
					<tr><td>Nom :</td><td><input type='text' name='name' value='".$perso['name']."' ".$disabled." /></td><td></td></tr>
					<tr><td>Race :</td><td><select name='race' ".$disabled.">";
					$sqlr="SELECT param_ID, text_ID FROM guild_param WHERE type = 'Race'";
					$listr=mysql_query($sqlr);      
					while($resultr=mysql_fetch_array($listr))
					{ echo "<option value='".$resultr['param_ID']."' " ;
					 if ($resultr['param_ID']==$perso['param_ID_race']) { echo "selected" ;} ;
					 echo ">".$resultr['text_ID']."</option>";
					};
					echo "</select></td><td></td></tr>
					<tr><td>Profession : </td><td><select name='profession' ".$disabled.">";
					$sqlc="SELECT param_ID, text_ID,translation FROM guild_param WHERE type = 'profession'";
					$listc=mysql_query($sqlc);
					while($resultc=mysql_fetch_array($listc))
					{ echo "<option value='".$resultc['param_ID']."' " ;
					 if ($resultc['param_ID']==$perso['param_ID_profession']) { echo "selected" ;} ;
					echo ">".$resultc['translation']."</option>" ;
					};
					echo "</select></td><td></td></tr>
					<tr><td>Principal :</td><td><input type='checkbox' name='main' value='1' ".$disabled; if ($perso['main']) { echo " checked" ;} ;echo "/></td><td></td></tr>
					<tr><td>Level :</td><td><input type='text' name='level' value='".$perso['level']."' ".$disabled."/></td><td></td></tr>
					<tr><td>Level McM :</td><td><input type='text' name='level_wvw' value='".$perso['level_wvw']."' ".$disabled."/></td><td></td></tr>
					<tr><td>Gameplay :</td><td><select name='gameplay' ".$disabled.">";
					$sqlo="SELECT param_ID, value FROM guild_param WHERE type = 'gameplay'";
					$listo=mysql_query($sqlo);
					while($resulto=mysql_fetch_array($listo))
					{ echo "<option value='".$resulto['param_ID']."' " ;
					 if ($resulto['param_ID']==$perso['param_ID_gameplay']) { echo "selected" ;} ;
					 echo ">".$resulto['value']."</option>" ;
					};
					echo "</select>
					</td><td></td></tr>
					<tr><td>Build :</td><td><input type='text' name='build' value='".$perso['build']."' ".$disabled."/> ".$perso['buildlink']."</td></tr>
					<tr><td></td><td>
					( <a class='menu' href='http://en.gw2skills.net/editor/' target='blank' >GW2 Skills</a> ,
					 <a class='menu' href='http://intothemists.com/calc/' target='blank' >Into the mists</a> ,
					 <a class='menu' href='http://gw2buildcraft.com/calculator/' target='blank' >GW2 BuildCraft</a> )</td></tr>
					<tr><td>Commentaire :</td><td colspan='2'><textarea name='comment' form='perso' rows='5' cols='50' ".$disabled.">".$perso['comment']."</textarea></td></tr>" ; }

//New character / Nouveau personnage
else { echo "
				<h2>Personnage : </h2>
				<form id='perso2' action='FO_Main_CharacterEdit.php?action=create' method='post'> 
				<input type='hidden' name='user_ID' value='".$usertest."' />
				<table>
					<tr><td>Nom :</td><td><input type='text' name='name' /></td><td></td></tr>
					<tr><td>Race :</td><td><select name='race'>";
					$sqlr="SELECT param_ID, value FROM guild_param WHERE type = 'Race'";
					$listr=mysql_query($sqlr);
					while($resultr=mysql_fetch_array($listr))
					{ echo "<option value='".$resultr['param_ID']."'>".$resultr['value']."</option>"; };
					echo "</select></td><td></td></tr>
					<tr><td>Profession : </td><td><select name='profession'>";
					$sqlc="SELECT param_ID, text_ID, translation FROM guild_param WHERE type = 'profession'";
					$listc=mysql_query($sqlc);
					while($resultc=mysql_fetch_array($listc))
					{ echo "<option value='".$resultc['param_ID']."' >".$resultc['translation']."</option>" ; };
					echo "</select></td><td></td></tr>
					<tr><td>Principal :</td><td><input type='checkbox' name='main' value='1' /></td><td></td></tr>
					<tr><td>Level :</td><td><input type='text' name='level' value='0'/></td><td></td></tr>
					<tr><td>Level McM:</td><td><input type='text' name='level_wvw' value='0'/></td><td></td></tr>
					<tr><td>Gameplay :</td><td><select name='gameplay'>";
					$sqlo="SELECT param_ID, value FROM guild_param WHERE type = 'gameplay'";
					$listo=mysql_query($sqlo);
					while($resulto=mysql_fetch_array($listo))
					{ echo "<option value='".$resulto['param_ID']."' >".$resulto['value']."</option>" ; };
					echo "</select></td><td></td></tr>
					<tr><td>Build :</td><td><input type='text' name='build' '/></td><td>
					( <a class='menu' href='http://en.gw2skills.net/editor/' target='blank' >GW2 Skills</a> ,
					 <a class='menu' href='http://intothemists.com/calc/' target='blank' >Into the mists</a> ,
					 <a class='menu' href='http://gw2buildcraft.com/calculator/' target='blank' >GW2 BuildCraft</a> )</td></tr>
					<tr><td>Commentaire :</td><td colspan='2'><textarea name='comment' form='perso2' rows='5' cols='50' ></textarea></td></tr>";
};
echo "
					<tr><td colspan='3'></td></tr>
					<tr><td></td><td><input type='submit' value='Enregistrer' ".$disabled."/></td><td></td></tr>
				</table></p>
				</form> 
				</div>";
//Other characters / Autres personnages
//Of the user / de l'utilisateur
echo "
				<div class='Right'>";
				if ( $perso['user_ID'] == $usertest || $action=='new'){
				echo "<h5>Mes autres personnages</h5>
				<table>";
					$sqlp="SELECT a.user_ID, a.character_ID, a.name, a.param_ID_profession, c.text_ID, c.color 
					FROM guild_character AS a 
					INNER JOIN guild_param AS c ON c.param_ID=a.param_ID_profession 
					WHERE a.user_ID = ".$usertest." 
					AND character_ID != '".$perso['character_ID']."' 
					ORDER BY a.main DESC, a.param_ID_profession"; }
				else {
				echo "<h5>Les personnages de ".$perso['username']."</h5>
				<table>";
					$sqlp="SELECT a.user_ID, a.character_ID, a.name, a.param_ID_profession, c.text_ID, c.color 
					FROM guild_character AS a 
					INNER JOIN guild_param AS c ON c.param_ID=a.param_ID_profession 
					WHERE a.user_ID = ".$perso['user_ID']." 
					ORDER BY a.main DESC, a.param_ID_profession";};
					$listp=mysql_query($sqlp);
					while($resultp=mysql_fetch_array($listp))
					{ echo "<tr style='background-color:".$resultp['color']."'>
					<td><a href='FO_Main_Profession.php?id=".$resultp['param_ID_profession']."' ><img src='resources/images/".$resultp['text_ID']."_Icon.png'></a></td>
					<td><a class='table' href='FO_Main_CharacterEdit.php?character=".$resultp['character_ID']."'>".$resultp['name']."</a></td></tr>"; };
echo "
				</table><br />
					<a class='right' href='FO_Main_CharacterEdit.php?action=new'>Ajouter un personnage</a><br />" ;
					if ( $action != 'new' )  {
$classe = mysql_result(mysql_query("SELECT translation FROM guild_param WHERE param_ID='".$perso['param_ID_profession']."'"),0);

//of the same profession / de la même profession
echo "
					<br />
					<h5>Les autres ".$classe."s</h5>
					<table>";
						$sqlp="SELECT a.user_ID, a.character_ID, a.name, u.username, a.param_ID_profession, c.text_ID, c.color 
						FROM guild_character AS a 
						INNER JOIN guild_param AS c ON c.param_ID=a.param_ID_profession 
						INNER JOIN ".$table_prefix."users AS u ON u.user_id=a.user_ID
						WHERE a.user_ID != ".$perso['user_ID']." 
						AND a.param_ID_profession='".$perso['param_ID_profession']."'
						ORDER BY a.main DESC";
						$listp=mysql_query($sqlp);
						while($resultp=mysql_fetch_array($listp))
						{ echo "<tr style='background-color:".$resultp['color']."'>
						<td><a href='FO_Main_Profession.php?id=".$resultp['param_ID_profession']."' ><img src='resources/images/".$resultp['text_ID']."_Icon.png'></a></td>
						<td><a class='table' href='FO_Main_CharacterEdit.php?character=".$resultp['character_ID']."'>".$resultp['name']."</a></td></tr>"; };
		echo "</table>" ; } ; 
echo "
				</div>
			</div>
		<div class='Copyright'>Copyright &copy; 2013 Xavier Olland, publi&eacute; sous licence GNU AGPL</div>
	</div>
	<script type=\"text/javascript\"  src=\"resources/js/Menu_Match.js\"></script>
</body>
</html>" ;}  
//Non authorized user / utilisateur non autorisé
else { include('resources/php/FO_Div_Register.php'); }
?>

