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

$id = $_POST['user'];

//Delete / Suppression
if ( is_numeric($id) && in_array($user->data['group_id'],$cfg_groups_backoffice) ){ 
$actionresult=0;
//Characters / Personnages
if ( $_POST['character'] == 'on' ){
	$sql1="DELETE FROM ".$gm_prefix."character WHERE user_ID='$id'"; 
	if (!mysqli_query($con,$sql1)){$actionresult=1;} ;}
//Raid
if ( $_POST['raid_player'] == 'on' ){
	$sql2="DELETE FROM ".$gm_prefix."raid_player WHERE user_ID='$id'";
	if (!mysqli_query($con,$sql2)){$actionresult=2;} ;} 
//User information / Information utilisateur
if ( $_POST['userinfo'] == 'on' ){
	$sql3="DELETE FROM ".$gm_prefix."userinfo WHERE user_ID='$id'";
	if (!mysqli_query($con,$sql3)){$actionresult=3;} ;}  

	if ($actionresult > 0 ) {echo $lng[g__error_record]." ($actionresult)<br />";} 
else { if( $_POST['deletePlayer'] == 'on'  ){ echo "<script>alert(\"Utilisateur supprimé\")</script>"; header( 'Location: index.php'); die();}; }; 
  
};
