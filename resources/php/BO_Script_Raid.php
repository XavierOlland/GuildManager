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

//Event cleaning / Nettoyage des évènements
if ( $_POST['DB_Event'] == 'on' ) {
	if ( $_POST['DB_Event_DateCB'] == 'on' ) { $date = "AND '".$_POST['DB_Event_hiddenDate']."' >= dateEvent"; };
	$sql1="DELETE FROM ".$gm_prefix."raid_event WHERE raid_event_ID!=0 $date"; 
	if (!mysqli_query($con,$sql1)){$actionresult=$lng['g__error_delete'];} else { $actionresult=$lng['p_BO_Script_Raid_Event']; };
	echo "<script>alert(\"$actionresult\")</script>";
};
//Presence cleaning / Nettoyage des présence
//Date management / Gestion de la date
if ( $_POST['DB_Player_DateCB'] == 'on' ) { $date = "AND '".$_POST['DB_Player_hiddenDate']."' >= dateEvent"; };
//Complete cleaning /Nettoyage complet
if ( $_POST['DB_Player'] == 'on' ) {
	$sql1="DELETE FROM ".$gm_prefix."raid_player WHERE 1 $date"; 
	if (!mysqli_query($con,$sql1)){$actionresult=$lng['g__error_delete'];} else { $actionresult=$lng['p_BO_Script_Raid_Player']; };
	echo "<script>alert(\"$actionresult\")</script>";
}
else { 
	//Presences only / Presences seulement
	if ( $_POST['DB_Player_Presence'] == 'on' ) { 
		$sql1="DELETE FROM ".$gm_prefix."raid_player WHERE presence=1 $date"; 
		if (!mysqli_query($con,$sql1)){$actionresult=$lng['g__error_delete'];} else { $actionresult=$lng['p_BO_Script_Raid_Presence']; };
		echo "<script>alert(\"$actionresult\")</script>";
	};
	//Absences only / Absences seulement
	if ( $_POST['DB_Player_Absence'] == 'on' ) {
		$sql1="DELETE FROM ".$gm_prefix."raid_player WHERE presence=0 $date"; 
		if (!mysqli_query($con,$sql1)){$actionresult=$lng['g__error_delete'];} else { $actionresult=$lng['p_BO_Script_Raid_Absence']; };
		echo "<script>alert(\"$actionresult\")</script>";
	};
};

?>