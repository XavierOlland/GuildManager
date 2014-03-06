<?php
/*  Guild Manager v1.0.4
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
$id = $_GET['user'];
$action = $_GET['action'];

//Delete / Suppression
if ( $action=='delete'  && is_numeric($id) && in_array($user->data['group_id'],$cfg_groups_backoffice) ){ $actionresult=0;
//Characters / Personnages
$sql1="DELETE FROM ".$gm_prefix."character WHERE user_ID='$id'"; 
if (!mysql_query($sql1,$con)){$actionresult=1;} 
//Raid
$sql2="DELETE FROM ".$gm_prefix."raid_presence WHERE user_ID='$id'";
if (!mysql_query($sql2,$con)){$actionresult=2;} 
$sql3="DELETE FROM ".$gm_prefix."raid_absence WHERE user_ID='$id'";
if (!mysql_query($sql3,$con)){$actionresult=3;} 
//User information / Information utilisateur
$sql4="DELETE FROM ".$gm_prefix."userinfo WHERE user_ID='$id'";
if (!mysql_query($sql4,$con)){$actionresult=4;}  
if ($actionresult > 0 ) {echo $lng[g__error_record]." ($actionresult)<br />";} 
else { header( 'Location: index.php'); die(); }; 
  
};


//Start of html page / Début du code html
echo "
<html>
<head>";
	//Common <head> elements / Eléments <head> communs
	include('resources/php/FO_Head.php');
	//Page specific <head> elements / Eléments <head> spécifique à la page
	echo "
	<style> body {background-image:url('resources/images/Perso_BG.jpg');background-size:100%; background-repeat:no-repeat;}"; 

	echo "</style>
</head>

<body>
	<div class='Main'>
		<div class='Title'><h1>".$cfg_title."</h1></div>";
		//User permissions test / Test des permissions utilisateur
		if ( in_array($user->data['group_id'],$cfg_groups) ){
		//Registered user code / Code pour utilisateurs enregistrés
		echo "
		<div class='Menu'>";
			include('resources/php/FO_Div_Menu.php');
			include('resources/php/FO_Div_Match.php');
		echo "</div>";

		echo "
		<div class='Page'>
			<div class='Core'>";

//MySQL interaction for update/creation / Enregistrement et mise à jour mySQL
if ( $action=='update' ){
	$line = mysql_result(mysql_query("SELECT count(*) FROM ".$gm_prefix."userinfo WHERE user_ID = '$id'"),0);

	//Update / Mise à jour
	if ( $line > 0){
		$sql1="UPDATE ".$gm_prefix."userinfo SET 
		commander = case WHEN '$_POST[commander]'='on' THEN 1 ELSE 0 END,
		comment = '$_POST[comment]',
		monday = case WHEN '$_POST[monday]'='1' THEN 1 ELSE 0 END,
		tuesday = case WHEN '$_POST[tuesday]'='1' THEN 1 ELSE 0 END,
		wednesday = case WHEN '$_POST[wednesday]'='1' THEN 1 ELSE 0 END,
		thursday = case WHEN '$_POST[thursday]'='1' THEN 1 ELSE 0 END,
		friday = case WHEN '$_POST[friday]'='1' THEN 1 ELSE 0 END,
		saturday = case WHEN '$_POST[saturday]'='1' THEN 1 ELSE 0 END,
		sunday = case WHEN '$_POST[sunday]'='1' THEN 1 ELSE 0 END 
		WHERE user_ID='$id'"; }
 
	//Row creation on first use / Création de l'enregistrement lors de la première utilisation
	else { $sql1="INSERT INTO ".$gm_prefix."userinfo 
		(user_ID, commander, comment, monday, tuesday, wednesday, thursday, friday, saturday, sunday)
		VALUES ('$id','$_POST[commander]','$POST[comment]',
		case WHEN '$_POST[monday]'='1' THEN 1 ELSE 0 END,
		case WHEN '$_POST[tuesday]'='1' THEN 1 ELSE 0 END,
		case WHEN '$_POST[wednesday]'='1' THEN 1 ELSE 0 END,
		case WHEN '$_POST[thursday]'='1' THEN 1 ELSE 0 END,
		case WHEN '$_POST[friday]'='1' THEN 1 ELSE 0 END,
		case WHEN '$_POST[saturday]'='1' THEN 1 ELSE 0 END,
		case WHEN '$_POST[sunday]'='1' THEN 1 ELSE 0 END)"; };

	if (!mysql_query($sql1,$con)){die(mysql_error().$lng[g__error_record].$sql1);} 
	else { echo $lng[FO_Main_User_update]."<br>"; }; 
};

//User information query / Requête des informations utilisateurs
$sql="SELECT user_ID, commander, comment, monday, tuesday, wednesday, thursday, friday, saturday, sunday 
FROM ".$gm_prefix."userinfo 
WHERE user_ID = '$id'";
$result = mysql_query($sql);
$userinfo = mysql_fetch_array($result);

//If viewer different from user : form is disabled / Si le lecteur est différent de l'utilisateur : le formulaire est désactivé
if ( $id != $usertest  || in_array($user->data['group_id'], array('1')) ) { $disabled="disabled"; };
$player = mysql_result(mysql_query("SELECT username FROM ".$table_prefix."users WHERE user_id='".$id."'"),0);

//Creating view/form / Création de la vue et du formulaire
echo "
				<h2>".$player."</h2>

				<form id='user' action='FO_Main_User.php?user=".$id."&action=update' method='post'> 
				<input type='hidden' name='user_ID' value='".$id."'>

				<h3>".$lng[FO_Main_User_h3_1]."</h3>
				<table>
					<tr>
						<td>".$lng[t_userinfo_commander]." :</td><td><input type='checkbox' name='commander' value'1' "; if ($userinfo['commander']) { echo "checked " ;} ; echo $disabled."/></td></tr>
					<tr class='top'>
						<td>".$lng[t_userinfo_comment]." :</td>
						<td><textarea form='user' id='comment' name='comment' rows='4' cols='35' ".$disabled.">".$userinfo['comment']."</textarea></td>
					</tr>
					<tr><td colspan='2'>
						<div id='absence'>
							<h4>".$lng[FO_Main_User_h4_1]."</h4>
							<table>
								<tr>
									<th>".$lng[t_day_0]."</th>
									<th>".$lng[t_day_1]."</th>
									<th>".$lng[t_day_2]."</th>
									<th>".$lng[t_day_3]."</th>
									<th>".$lng[t_day_4]."</th>
									<th>".$lng[t_day_5]."</th>
									<th>".$lng[t_day_6]."</th>
								</tr>
								<tr>
									<td class='center'><input type='checkbox' name='friday' value='1' "; if ($userinfo['friday']) { echo "checked " ;} ; echo $disabled."/></td>
									<td class='center'><input type='checkbox' name='saturday' value='1' "; if ($userinfo['saturday']) { echo "checked " ;} ; echo $disabled."/></td>
									<td class='center'><input type='checkbox' name='sunday' value='1' "; if ($userinfo['sunday']) { echo "checked " ;} ; echo $disabled."/></td>
									<td class='center'><input type='checkbox' name='monday' value='1' "; if ($userinfo['monday']) { echo "checked " ;} ; echo $disabled."/></td>
									<td class='center'><input type='checkbox' name='tuesday' value='1' "; if ($userinfo['tuesday']) { echo "checked " ;} ; echo $disabled."/></td>
									<td class='center'><input type='checkbox' name='wednesday' value='1' "; if ($userinfo['wednesday']) { echo "checked " ;} ; echo $disabled."/></td>
									<td class='center'><input type='checkbox' name='thursday' value='1' "; if ($userinfo['thursday']) { echo "checked " ;} ; echo $disabled."/></td>
								</tr>
							</table>
						</div>
						</td>
					</tr>
					<tr><td></td><td><input type='submit' value='".$lng[g__save]."' ".$disabled."/>";
					//Suppress user / Suppression de l'utilisateur
					if (in_array($user->data['group_id'],$cfg_groups_backoffice)){ 
					echo " <a class='Menu' href='FO_Main_User.php?user=".$id."&action=delete' onclick=\"return confirm('".$lng[p_FO_Main_User_warning_1].$player.$lng[p_FO_Main_User_warning_2]."');\" >".$lng[g__delete]."</a>"; };
					echo "</td></tr>
				</table>
				</form>
			</div>

			<div class='Right'>";
//Right Menu / Menu de droite

if ( $id == $usertest ) { echo "<h5>".$lng[p_FO_Main_User_h5_1]."</h5>"; } 
else { echo "<h5>".$lng[p_FO_Main_User_h5_2]." ".$player."</h5>"; };

echo "
				<br />
				<table>";
$sql="SELECT a.user_ID, a.character_ID, a.name, a.param_ID_profession, c.text_ID, c.color 
FROM ".$gm_prefix."character AS a 
INNER JOIN ".$gm_prefix."param AS c ON c.param_ID=a.param_ID_profession 
WHERE a.user_ID = ".$id."
ORDER BY a.main DESC, a.param_ID_profession";
$list=mysql_query($sql);
while($character=mysql_fetch_array($list))
{ echo "
				<tr style='background-color:".$character['color']."'>
					<td><a href='FO_Main_Profession.php?id=".$character['param_ID_profession']."' ><img src='resources/images/".$character['text_ID']."_Icon.png'></a></td>
					<td><a class='table' href='FO_Main_CharacterEdit.php?character=".$character['character_ID']."'>".$character['name']."</a></td>
				</tr>"; };
echo "
				</table>
			</div>
		</div>
		<div class='Copyright'>".$lng[g__copyright]."</div>
	</div>
<script>var api_lng = '$api_lng'; var default_world_id = $api_srv</script>
<script src=\"resources/js/Menu_Match.js\"></script>
</body>
</html>"; } 

//Non authorized user / utilisateur non autorisé
else { include('resources/php/FO_Div_Register.php'); }
?>

