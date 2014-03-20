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
$date = date('Y-m-d', time());
$dateInput = date('d-m-Y', time());
$dateEvent = strtotime($date);
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
			<div id='Core'>";
			if (in_array($user->data['group_id'],$cfg_groups_backoffice)){ 
			echo "<input id='adminLink' class='admin' type='button' href='javascript.void()' onclick=\"adminPanelShow()\" value='".$lng['g__adminPanel']."'/>";
			};
					
				//BOX 1	
				echo "<div id='FO_Raid'>";
				echo "<div style='clear:left;'><h2>".$lng['p_FO_Main_Raid_h2_1']."</h2></div>";
					//BOX 1.1 - Calendar
					echo "<div id='FO_Calendar' style='float:left;'></div>";
					//BOX 1.2 - Event
					echo "<div id='FO_Event' class='Event'><p><br /><br /><img src='resources/theme/$theme/images/Previous.png'>".$lng['p_FO_Main_Raid_p_1']."</p></div>";
					//BOX 1.3 - Party
					echo "<div id='FO_Party' style='clear:left;'></div>";
				echo "</div>";
				
				//BOX 2 - Admin Zone
				if (in_array($user->data['group_id'],$cfg_groups_backoffice)){ 
				echo "<div id='BO_Raid' id='adminPanel' style='display:none;'>
				<form id='Admin' method='post' action='' onsubmit=\"return confirm('".$lng['p_FO_Main_Raid_warning_1']."');\"> 
					<fieldset class='admin'>
					<legend class='admin'>".$lng['g__adminPanel']."</legend>";
				echo "<div style='clear:left;'><h2>".$lng['p_FO_Main_Raid_h2_2']."</h2></div>";
					//BOX 2.1 - Calendar
					echo "<div id='BO_Calendar' style='float:left;'></div>";
					//BOX 2.2 - Event
					echo "<div id='BO_Event' class='Event'><p><br /><br /><img src='resources/theme/$theme/images/Previous.png'>".$lng['p_FO_Main_Raid_p_2']."</p></div>";
					//BOX 2.3 - Panel
					echo "<div id='BO_Panel' style='clear:left;'>
							<br />
							<h6>".$lng['p_FO_Main_Raid_h6_1']."</h6>
							<br />
							<p>
							<input type='checkbox' id='DB_Event' name='DB_Event'> ".$lng['p_FO_Main_Raid_DB_Event']."</p>
							<p style='margin-left:25px;'>
							<input type='checkbox' id='DB_Event_DateCB' name='DB_Event_DateCB'> ".$lng['p_FO_Main_Raid_DB_Event_Date']." <input type='text' id='DB_Event_Date' name='DB_Event_Date' class='p' style='width:90px' value='$dateInput'> ".$lng['g__included']."
							<input type='hidden' name='DB_Event_hiddenDate' id='DB_Event_hiddenDate' value='$date'></p>
							<br />
							</p>
							<p><input type='checkbox' id='DB_Player' name='DB_Player'> ".$lng['p_FO_Main_Raid_DB_Player']."</p>
							<p style='margin-left:25px;'>
							<input type='checkbox' class='player' id='DB_Player_Presence' name='DB_Player_Presence' onclick=\"resetPlayer();\"> ".$lng['p_FO_Main_Raid_DB_Player_Presence']."<br />
							<input type='checkbox' class='player' id='DB_Player_Absence' name='DB_Player_Absence' onclick=\"resetPlayer();\"> ".$lng['p_FO_Main_Raid_DB_Player_Absence']."<br />
							<input type='checkbox' id='DB_Player_DateCB' name='DB_Player_DateCB'> ".$lng['p_FO_Main_Raid_DB_Player_Date']." <input type='text' id='DB_Player_Date' name='DB_Player_Date' class='p' style='width:90px' value='$dateInput'> ".$lng['g__included']."
							<input type='hidden' name='DB_Player_hiddenDate' id='DB_Player_hiddenDate' value='$date'>
							<br />
							<br />
							</p>
							<input type='submit' value='".$lng['g__clean']."' /><br /><br />											
							<input id='adminLink2' class='admin' type='button' href='javascript.void()' onclick=\"adminPanelHide()\" value='".$lng['g__hide']."'/>
							<div id='Result'></div>
						  </div>							
					</fieldset>
				</form>
				</div>"; };

				//END OF CORE
				echo "</div>
			<div id='Right'></div>
		</div>
		<div id='Copyright'>".$lng['g__copyright']."</div>
	</div>";
	
//Scripts
//Match up score / Affichage des scores du match up
echo "
	<script>var api_lng = '$api_lng'; var default_world_id = $api_srv</script>
	<script src=\"resources/js/Menu_Match.js\"></script> ";
//Loading modules / chargement des modules 
echo "
	<script>
		$('#FO_Calendar').load(\"resources/php/FO_Div_Calendar.php?user_ID=$usertest&date=$date\");
		$('#BO_Calendar').load(\"resources/php/BO_Div_Calendar.php?user_ID=$usertest&date=$date\");
		$('#Right').load(\"resources/php/FO_Div_Presence.php?user_ID=$usertest\");
	</script>";
	
//Scripts BackOffice
//Hide & Show admin panel / Affichage & masquage de la zone admin
echo "
	<script>function adminPanelShow(){ $('#adminLink').hide(  'blind' );$('#FO_Raid').hide(  'blind' );$('#BO_Raid').show( 'blind' );}</script>
	<script>function adminPanelHide(){ $('#BO_Raid').hide( 'blind' );$('#FO_Raid').show(  'blind' );$('#adminLink').show(  'blind' );}</script>";
//Form interface / Interface du Formulaire
echo "
	<script> $(function() { $( \"#DB_Event_Date\" ).datepicker({ 
		dateFormat: \"dd/mm/yy\",  altField: \"#DB_Event_hiddenDate\",
		altFormat: \"yy-mm-dd\" }); });
	</script>
	<script>$(document).ready(function () {	$('#DB_Player').click(function () { $('.player').prop('checked', isChecked('DB_Player')); }); });
			function isChecked(playerId) { var id = '#' + playerId;  return $(id).is(\":checked\");}
			function resetPlayer() {
				if ($(\".player\").length == $(\".player:checked\").length)
				{ $(\"#DB_Player\").attr(\"checked\", \"checked\"); } 
				else { $(\"#DB_Player\").removeAttr(\"checked\"); } ;}
	</script>
	<script> $(function() { $( \"#DB_Player_Date\" ).datepicker({ 
		dateFormat: \"dd/mm/yy\",  altField: \"#DB_Player_hiddenDate\",
		altFormat: \"yy-mm-dd\" }); });
	</script>";
//Form Execution /Exécution du formulaire
echo "
	<script>
		$('#Admin').submit(function(){   
			$.ajax({
				type: \"POST\",
				url: \"resources/php/BO_Script_Raid.php\",
				data: $('#admin').serialize(),
				success: function(html){
					$(\"#Result\").html(html);
					$(\"#BO_Calendar\").load(\"resources/php/BO_Div_Calendar.php?user_ID=$usertest&date=$date\");
					$(\"#BO_Event\").load(\"resources/php/BO_Div_Event.php?date=$dateEvent\");
				}
			});
		});
	</script>";
echo "
</body>
</html>"; }
//Non authorized user / utilisateur non autorisé
else { include('resources/php/FO_Div_Register.php'); }
?>
