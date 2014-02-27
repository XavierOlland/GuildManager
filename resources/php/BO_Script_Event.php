 <?php 
 /* Guild Manager v1.0.4
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

if ( $_POST['raid_id'] == 0){
$sql1="INSERT INTO ".$gm_prefix."raid_event ( dateRaid, time, map, color, event, user_ID_leader, comment ) VALUES ('$_POST[dateRaid]','$_POST[time]','$_POST[map]','$_POST[color]','$_POST[event]','$_POST[user_ID_leader]','$_POST[comment]')"; 
$test=mysql_insert_id();
$response="<p class='red'>Ev&egrave;nement cr&eacute;&eacute; $test</p>"; 
}
else{
$sql1="UPDATE ".$gm_prefix."raid_event SET dateRaid='$_POST[dateRaid]', time='$_POST[time]', map='$_POST[map]', color='$_POST[color]', event='$_POST[event]', user_ID_leader='$_POST[user_ID_leader]', comment='$_POST[comment]' WHERE raid_event_ID='$_POST[raid_id]'"; 
$response="<p class='red'>Ev&egrave;nement modifi&eacute;</p>";};

if (!mysql_query($sql1,$con)){$actionresult="Erreur dans l'enregistrement.";} else {echo $response;}; 

?>