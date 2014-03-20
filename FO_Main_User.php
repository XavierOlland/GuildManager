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
$id = $_GET['user'];
$row = mysqli_fetch_row(mysqli_query($con,"SELECT username FROM ".$table_prefix."users WHERE user_id='".$id."'"));
$player = $row[0];

//User information query / Requête des informations utilisateurs
$sql="SELECT user_ID, commander, comment, monday, tuesday, wednesday, thursday, friday, saturday, sunday FROM ".$gm_prefix."userinfo WHERE user_ID = '$id'";
$result = mysqli_query($con,$sql);
$userinfo = mysqli_fetch_array($result,MYSQLI_ASSOC);

//If viewer different from user : form is disabled / Si le lecteur est différent de l'utilisateur : le formulaire est désactivé
if ( $id != $usertest || in_array($user->data['group_id'], array('1')) ) { $disabled="disabled"; };

//Start of html page / Début du code html
echo "
<html>
<head>";
	//Common <head> elements / Eléments <head> communs
	include('resources/php/FO_Head.php');
	//Page specific <head> elements / Eléments <head> spécifiques à la page
	echo "
</head>

<body>
	<div id='Main'>
		<div id='Title'><h1>".$cfg_title."</h1></div>";
		//User permissions test / Test des permissions utilisateur
		if ( in_array($user->data['group_id'],$cfg_groups) ){
		//Registered user code / Code pour utilisateurs enregistrés
		echo "
		<div id='Left'>";
			include('resources/php/FO_Div_Menu.php');
			include('resources/php/FO_Div_Match.php');
		echo "</div>";

		echo "
		<div id='Page'>
			<div id='Core'>";
			//Creating view/form / Création de la vue et du formulaire
			echo "
				<h2>".$player."</h2>
				<form id='User' action='' method='post' onsubmit=\"return false\"> 
				<input type='hidden' name='id' value='$id'>
				<h3>".$lng['p_FO_Main_User_h3_1']."</h3>
				<table>
					<tr>
						<td>".$lng['t_userinfo_commander']." :</td><td><input type='checkbox' name='commander' "; if ($userinfo['commander']) { echo "checked " ;} ; echo $disabled."/></td></tr>
					<tr class='top'>
						<td>".$lng['t_userinfo_comment']." :</td>
						<td><textarea form='user' id='comment' name='comment' rows='4' cols='35' ".$disabled.">".$userinfo['comment']."</textarea></td>
					</tr>
					<tr>
						<td colspan='2'>
						<div id='Presence'>
							<h3>".$lng['p_FO_Main_User_h3_2']."</h3>
							<table>
								<tr>
									<th>".$lng['t_day_0']."</th>
									<th>".$lng['t_day_1']."</th>
									<th>".$lng['t_day_2']."</th>
									<th>".$lng['t_day_3']."</th>
									<th>".$lng['t_day_4']."</th>
									<th>".$lng['t_day_5']."</th>
									<th>".$lng['t_day_6']."</th>
								</tr>
								<tr>
									<td class='center'><input type='checkbox' name='friday' "; if ($userinfo['friday']) { echo "checked " ;} ; echo $disabled."/></td>
									<td class='center'><input type='checkbox' name='saturday' "; if ($userinfo['saturday']) { echo "checked " ;} ; echo $disabled."/></td>
									<td class='center'><input type='checkbox' name='sunday' "; if ($userinfo['sunday']) { echo "checked " ;} ; echo $disabled."/></td>
									<td class='center'><input type='checkbox' name='monday' "; if ($userinfo['monday']) { echo "checked " ;} ; echo $disabled."/></td>
									<td class='center'><input type='checkbox' name='tuesday' "; if ($userinfo['tuesday']) { echo "checked " ;} ; echo $disabled."/></td>
									<td class='center'><input type='checkbox' name='wednesday' "; if ($userinfo['wednesday']) { echo "checked " ;} ; echo $disabled."/></td>
									<td class='center'><input type='checkbox' name='thursday' "; if ($userinfo['thursday']) { echo "checked " ;} ; echo $disabled."/></td>
								</tr>
							</table>
						</div>
						</td>
					</tr>
					<tr>
						<td></td><td><input type='submit' value='".$lng['g__save']."' ".$disabled."/></td>
					</tr>
				</table>
				</form>
				<div id='Result'></div>
				<br />
				<br />";
				//Admin panel / Panneau admin
					if (in_array($user->data['group_id'],$cfg_groups_backoffice)){ echo "
					<input id='AdminLink' class='admin' type='button' href='javascript.void()' onclick=\"adminPanelShow()\" value='".$lng['g__adminPanel']."'/>
					<div class='Extand' id='AdminPanel' style='display:none;'>
						<form id='Admin' action='FO_Main_User.php?user=".$id."' method='post' onsubmit=\"return confirm('".$lng['p_FO_Main_User_warning_1'].$player.$lng['p_FO_Main_User_warning_2']."');\"> 
							<input type='hidden' name='action' value='delete'>
							<fieldset class='admin'>
							<legend class='admin'>".$lng['g__adminPanel']."</legend>
							<br />
							<p>
							<input type='checkbox' id='DeletePlayer' name='deletePlayer'> ".$lng['p_FO_Main_User_deletePlayer']."</p><br />
							<p style='margin-left:25px;'>
							<input type='checkbox' class='delete' name='raid_player' onclick=\"resetDeletePlayer();\"> ".$lng['p_FO_Main_User_raid_player']."<br />
							<input type='checkbox' class='delete' name='character' onclick=\"resetDeletePlayer();\"> ".$lng['p_FO_Main_User_character']."<br />
							<input type='checkbox' class='delete' name='userinfo' onclick=\"resetDeletePlayer();\"> ".$lng['p_FO_Main_User_userinfo']."<br />
							</p>
							<br />
							<input type='submit' value='".$lng['g__delete']."' /><br /><br />
							<p style='font-size:12px;'>".$lng['p_FO_Main_User_warning_3']."</p>
							<input id='AdminLink2' class='admin' type='button' href='javascript.void()' onclick=\"adminPanelHide()\" value='".$lng['g__hide']."'/>							
					</fieldset>
					</form>
					</div>";};
				echo"				
			</div>
			<div id='Right'>";
				//Right Menu / Menu de droite
				if ( $id == $usertest ) { echo "<h5>".$lng['p_FO_Main_User_h5_1']."</h5>"; } 
				else { echo "<h5>".$lng['p_FO_Main_User_h5_2']." ".$player."</h5>"; };
				echo "
				<br />
				<table>";
				$sql="SELECT a.user_ID, a.character_ID, a.name, a.param_ID_profession, c.text_ID, c.color 
				FROM ".$gm_prefix."character AS a 
				INNER JOIN ".$gm_prefix."param AS c ON c.param_ID=a.param_ID_profession 
				WHERE a.user_ID = ".$id."
				ORDER BY a.main DESC, a.param_ID_profession";
				$list=mysqli_query($con,$sql);
				while($character=mysqli_fetch_array($list,MYSQLI_ASSOC))
				{ echo "
				<tr style='background-color:".$character['color']."'>
					<td><a href='FO_Main_Profession.php?id=".$character['param_ID_profession']."' ><img src='resources/theme/$theme/images/".$character['text_ID']."_Icon.png'></a></td>
					<td><a class='colorbg' href='FO_Main_CharacterEdit.php?character=".$character['character_ID']."'>".$character['name']."</a></td>
				</tr>"; };
				echo "
				</table>
			</div>
		</div>
		<div id='Copyright'>".$lng['g__copyright']."</div>
	</div>";
//Scripts
//Match up score / Affichage des scores du match up
echo "
	<script>var api_lng = '$api_lng'; var default_world_id = $api_srv</script>
	<script src=\"resources/js/Menu_Match.js\"></script> ";	
//Scripts BackOffice
//Hide & Show admin panel / Affichage & masquage de la zone admin
echo "
	<script>function adminPanelShow(){ $('#AdminLink').hide(  'blind' );$('#AdminPanel').show( 'blind' );}</script>
	<script>function adminPanelHide(){ $('#AdminPanel').hide( 'blind' );$('#AdminLink').show(  'blind' );}</script>";
//Form interface / Interface du Formulaire
echo "
	<script>$(document).ready(function () {	$('#DeletePlayer').click(function () { $('.delete').prop('checked', isChecked('DeletePlayer')); }); });
			function isChecked(deleteId) { var id = '#' + deleteId;  return $(id).is(\":checked\");}
			function resetDeletePlayer() {
				if ($(\".delete\").length == $(\".delete:checked\").length) { $(\"#DeletePlayer\").attr(\"checked\", \"checked\"); } 
				else { $(\"#DeletePlayer\").removeAttr(\"checked\"); };
			}
	</script>";
//Forms Execution /Exécution des formulaires
echo "
	<script>
		$('#Admin').submit(function(){   
			$.ajax({
				type: \"POST\",
				url: \"resources/php/BO_Script_User.php\",
				data: $('#Admin').serialize(),
				success: function(html){
					$(\"#Result\").html(html);
				}
			});
		});
	</script>
	<script>
		$('#User').submit(function(){   
			$.ajax({
				type: \"POST\",
				url: \"resources/php/FO_Script_User.php\",
				data: $('#User').serialize(),
				success: function(html){
					$(\"#Result\").html(html);
				}
			});
		});
	</script>	
</body>
</html>";
	} 

//Non authorized user / utilisateur non autorisé
else { include('resources/php/FO_Div_Register.php'); }
?>

