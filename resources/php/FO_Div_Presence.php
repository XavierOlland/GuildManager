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

//MySQL connection / Connexion à MySQL
include('../../../config.php');
//GuildManager main configuration file / Fichier de configuration principal GuildManager
include('../config.php');


//Enregistrement dans la base de données
$usertest = $_GET['user_ID'];
$raid_presence_ID=$_GET['delete'];

if (strlen($raid_presence_ID) > 0){ 
$sql1="DELETE FROM guild_raid_presence WHERE raid_presence_ID='$raid_presence_ID'"; 
if (!mysql_query($sql1,$con)){$actionresult="Erreur dans la suppression.";} ; };


//Liste des absences futures

echo "
<table>
<tr><th>Date</th><th>Perso</th><th></th></tr>";

mysql_query("SET lc_time_names = 'fr_FR'");
$sql="SELECT p.raid_presence_ID, DATE_FORMAT(p.dateEvent,'%a %e.%m') AS dateEvent, p.dateEvent AS dateSql, c.name 
FROM guild_raid_presence AS p
INNER JOIN guild_character AS c ON c.character_ID=p.character_ID
WHERE p.user_ID = ".$usertest."
AND DATE(p.dateEvent) >= DATE(NOW())
ORDER BY p.dateEvent ASC";
$list=mysql_query($sql);
while($result=mysql_fetch_array($list))
{ $date =strtotime($result['dateSql']);
echo "<tr>
        <td>".$result['dateEvent']."</td>
        <td>".$result['name']."</td>
        <td><a class='menu' onclick=\"deletePresence('".$result['raid_presence_ID']."','".$date."')\" href='#'>X</a></td>
        </tr>";  } ;
echo "</table>

<script type=\"text/javascript\">
	function deletePresence(id,dateSql){   
				$(\"#event\").load(\"resources/php/FO_Div_Event.php?user_ID=$usertest&type=day&id=0&date=\" + dateSql  );
				$(\"#presence\").load(\"resources/php/FO_Div_Presence.php?user_ID=$usertest&delete=\" + id);
			}
	
	</script>";

?>