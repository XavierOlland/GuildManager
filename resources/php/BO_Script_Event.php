 <?php 
 /* Guild Manager v1.1.0 (Princesse d’Ampshere)
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

//MySQL connection / Connexion à MySQL
include('../../../config.php');
//GuildManager main configuration file / Fichier de configuration principal GuildManager
include('../config.php');
//Language management / Gestion des traductions
include('../language.php');

//Page variables creation / Création des variables spécifiques pour la page
$id = $_POST['id'];
$date = $_POST['date'];
$action = $_POST['action'];
$sqlday = date('l', $date);
$sqldate = date('Y\-m\-d', $date);
$today = date('Y-m-d', time());
echo $id;
//Action management / Gestion des actions
if( $action == 'delete')
{
$sql1="DELETE FROM ".$gm_prefix."raid_event WHERE raid_event_ID='$id'"; 
if (!mysqli_query($con,$sql1)){$actionresult=$lng[g__error_delete];}
else {
echo "
<p class='red'>".$lng['p_BO_Div_Event_p_1']."</p><br />
<p>".$lng['p_BO_Div_Event_p_2']."</p>";
}
 ; }
else {
	if( $action == 'update'){
	$sql0="SELECT raid_event_id FROM ".$gm_prefix."raid_event WHERE dateEvent='$_POST[dateEvent]' AND raid_event_ID!=$id";
	$list0=mysqli_query($con,$sql0);
	$count=mysqli_num_rows($list0);
	if( $count != 0 ){
		echo "<p class='red'>".$lng['p_BO_Div_Event_p_3']."</p><br />"; 
							}
				
	else {	
		if ($id == 0){
			$sql1="INSERT INTO ".$gm_prefix."raid_event ( dateEvent, time, map, color, event, user_ID_leader, comment ) VALUES ('$_POST[dateEvent]','$_POST[time]','$_POST[map]','$_POST[color]','$_POST[event]','$_POST[user_ID_leader]','$_POST[comment]')"; 
			if (!mysqli_query($con,$sql1)){$actionresult=$lng[g__error_create];}
		else { $id = mysql_insert_id();
			echo "
			<script>alert(\"Create\")</script>
			<p class='red'>".$lng[p_BO_Div_Event_p_4]."Create</p><br />";
			};}	
		else {
			$sql1="UPDATE ".$gm_prefix."raid_event SET dateEvent='$_POST[dateEvent]', time='$_POST[time]', map='$_POST[map]', color='$_POST[color]', event='$_POST[event]', user_ID_leader='$_POST[user_ID_leader]', comment='$_POST[comment]' WHERE raid_event_ID='$id'"; 
			if (!mysqli_query($con,$sql1)){$actionresult=$lng[g__error_create];}
			else { echo " <p class='red'>".$lng[p_BO_Div_Event_p_4]."Update</p><br />";};
		};
		
		};
	};
}; 
 

?>