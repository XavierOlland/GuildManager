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

if (isset($_POST['profession'])) {
	foreach($_POST['id'] as $idp)
{
$sql1="UPDATE ".$gm_prefix."profession SET partyOrder= '".$_POST['partyOrder'.$idp]."' WHERE profession_ID='".$idp[$i]."'";
$result1=mysqli_query($con,$sql1);
}}
;

//Page variables creation / Création des variables spécifiques pour la page
$id = $_GET['id'];
if (in_array($user->data['group_id'],$cfg_groups_backoffice)){ $admin = 1; };


//Start of html page / Début du code html
echo "
<html>
<head>";
//Common <head> elements / Eléments <head> communs
	include('resources/php/FO_Head.php');
//Page specific <head> elements / Eléments <head> spécifique à la page
//Dynamic background / Fond d'écran dynamique
if ( $theme_dynamic_bg == 1 ) {
if ( strlen($id) == 0 ) { $class = 'Main';} 
else { $row = mysqli_fetch_row(mysqli_query($con,"SELECT text_ID FROM ".$gm_prefix."param WHERE param_ID=$id")); $class=$row[0];};
echo "
<style> body {background-image:url('resources/theme/$theme/images/".$class."_BG.jpg');background-size:100%; background-repeat:no-repeat;} </style>" ;};
echo "
</head>

	<body>
	<div id='Main'>
		<div id='Title'><h1>".$cfg_title."</h1></div>";
//User permissions test / Test des permissions utilisateur
			if (in_array($user->data['group_id'],$cfg_groups)){
			//Registered user code / Code pour utilisateurs enregistrés
	echo "<div id='Left'>";
			include('resources/php/FO_Div_Menu.php');
			include('resources/php/FO_Div_Match.php');
		echo "</div>
		<div id='Page'>
			<div id='Core'>
				<div class='Extand' id='Result'></div>
			</div>";	
			echo "<div id='Right'>
				<div id='Professions'>
				<h5>".$lng['p_FO_Main_Profession_h5_1']."</h5>
				<table>
				<tr>";
				$sql="SELECT p.profession_ID, a.text_ID, d.$local AS translation
				FROM ".$gm_prefix."profession AS p 
				INNER JOIN ".$gm_prefix."param AS a ON a.param_ID=p.param_ID 
				LEFT JOIN ".$gm_prefix."dictionary AS d ON d.table_ID=p.param_ID AND d.entity_name='param'
				WHERE a.type='profession' 
				ORDER BY p.partyOrder" ;
				
				$list=mysqli_query($con,$sql);
				while($result=mysqli_fetch_row($list))
				{ echo "<tr>
							<td><a onclick=\"";//Dynamic background / Fond d'écran dynamique
							if ( $theme_dynamic_bg == 1 ) {echo "$('body').css('background-image', 'url(resources/theme/$theme/images/".$result[1]."_BG.jpg)');" ;};
							echo "					
								$('#Result').load('resources/php/FO_Div_Profession.php?id=".$result[0]."&admin=$admin');\" href=\"javascript:void(0)\">
								<img src='resources/theme/$theme/images/".$result[1]."_Icon.png'></a></td>
								<td><a class='table' onclick=\"";
							//Dynamic background / Fond d'écran dynamique
							if ( $theme_dynamic_bg == 1 ) {echo "$('body').css('background-image', 'url(resources/theme/$theme/images/".$result[1]."_BG.jpg)');" ;};
							echo "
								
								$('#Result').load('resources/php/FO_Div_Profession.php?id=".$result[0]."&admin=$admin');\" href=\"javascript:void(0)\">".$result[2]."</a></td>
								</tr>";}
				echo "</table><br /><br /><br />
				</div>";
				if (in_array($user->data['group_id'],$cfg_groups_backoffice)){ echo "
				<input id='AdminLinkRight' class='admin' type='button' href='javascript.void()' onclick=\"adminPanelShow2()\" value='".$lng['g__adminPanel']."'/>
				<div id='AdminPanel2' style='margin:0px;padding:2px;display:none;'>
					<form name='profession' id='profession' method='POST' action=''>
					<fieldset class='adminRight'>
					<legend class='admin'>".$lng['g__adminPanel']."</legend>
					<br />
					<table>
		<tr><th colspan='2'>".$lng['g__profession']."</th><th width='20'>#</th></tr>";
		$sql="SELECT p.profession_ID, p.partyOrder, a.color, a.text_ID, d.$local AS translation
		FROM ".$gm_prefix."profession AS p 
		INNER JOIN ".$gm_prefix."param AS a ON a.param_ID=p.param_ID 
		LEFT JOIN ".$gm_prefix."dictionary AS d ON d.table_ID=a.param_ID AND d.entity_name='param'
		WHERE a.type='profession' 
		ORDER BY p.partyOrder" ;
		$list=mysqli_query($con,$sql);
		while($result=mysqli_fetch_array($list,MYSQLI_ASSOC))
		{ echo "<tr>
					<td><img src='resources/theme/$theme/images/".$result['text_ID']."_Icon.png'></td>
					<td>".$result['translation']."</td>
					<td class='center'><input type='hidden' name='id[]' value='".$result['profession_ID']."' />
						<input style='width:20px;' type='text' name='partyOrder".$result['profession_ID']."' value='".$result['partyOrder']."' /></td>
				</tr>";}
		echo "<tr><td colspan='2'><input type='submit' name='profession' value='".$lng['g__save']."'></td></tr>
	</table>
	<input id='AdminLinkRight2' class='admin' type='button' href='javascript.void()' onclick=\"adminPanelHide2()\" value='".$lng['g__hide']."'/>
	</fieldset>
	</form>
	<br /></div>" ; };
				echo "
			</div>
		</div>
		<div id='Copyright'>".$lng['g__copyright']."</div>
	</div>
	<script>function adminPanelShow(){ $('#AdminLink').hide( 'blind' );$('#AdminPanel').show( 'blind' );}</script>
	<script>function adminPanelHide(){ $('#AdminPanel').hide( 'blind' );$('#AdminLink').show(  'blind' );}</script>
	<script>function adminPanelShow2(){ $('#Professions').hide( 'blind' );$('#AdminLinkRight').hide( );$('#AdminPanel2').show( 'blind' );}</script>
	<script>function adminPanelHide2(){ $('#AdminPanel2').hide( 'blind' );$('#Professions').show( 'blind' );$('#AdminLinkRight').show( );}</script>
	<script>$('#Result').load('resources/php/FO_Div_Profession.php?id=".$id."&admin=$admin');</script>
	<script>var api_lng = '$api_lng'; var default_world_id = $api_srv</script>
	<script src=\"resources/js/Menu_Match.js\"></script>
</body>
</html>"; }
//Non authorized user / utilisateur non autorisé
else { include('resources/php/FO_Div_Register.php'); }
?>
