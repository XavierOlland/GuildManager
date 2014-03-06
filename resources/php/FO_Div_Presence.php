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

//MySQL connection / Connexion à MySQL
include('../../../config.php');
//GuildManager main configuration file / Fichier de configuration principal GuildManager
include('../config.php');
//Language management / Gestion des traductions
include('../language.php');

mysql_query("SET lc_time_names = '$local'");
$usertest = $_GET['user_ID'];
$raid_player_ID=$_GET['delete'];

if (strlen($raid_player_ID) > 0){ 
$sql1="DELETE FROM ".$gm_prefix."raid_player WHERE raid_player_ID='$raid_player_ID'"; 
if (!mysql_query($sql1,$con)){$actionresult=$lng[g__error_delete];} ; };


//Liste des absences futures
echo "
<h5>".$lng[p_FO_Div_Presence_h5_1]."</h5>
<table>
	<tr>
		<th>".$lng[g__date]."</th>
		<th>".$lng[g__perso]."</th>
		<th>".$lng[g__del]."</th>
	</tr>";

mysql_query("SET lc_time_names = '$local'");
$sql="SELECT p.raid_player_ID, DATE_FORMAT(p.dateEvent,'%a %e.%m') AS dateEvent, p.dateEvent AS dateSql, c.name 
FROM ".$gm_prefix."raid_player AS p
INNER JOIN ".$gm_prefix."character AS c ON c.character_ID=p.character_ID
WHERE p.user_ID = ".$usertest." AND presence=1 
AND p.dateEvent >= DATE(now())
ORDER BY p.dateEvent ASC";

$list=mysql_query($sql);
while($result=mysql_fetch_array($list))
{ $date = strtotime($result['dateSql']);
echo "<tr>
        <td>".$result['dateEvent']."</td>
        <td>".$result['name']."</td>
        <td><a class='menu' onclick=\"deletePresence('".$result['raid_player_ID']."','".$date."')\" href=\"javascript:void(0)\">X</a></td>
        </tr>";  } ;
echo "</table>
<br />
<h5>".$lng[p_FO_Div_Presence_h5_2]."</h5>
<table>
	<tr>
		<th>".$lng[g__date]."</th>
		<th>".$lng[g__del]."</th>
	</tr>";

$sql="SELECT raid_player_ID, DATE_FORMAT(dateEvent,'%W %e %M') AS dateEvent
FROM ".$gm_prefix."raid_player  
WHERE user_ID = ".$usertest." AND presence=0
AND dateEvent >= DATE(now())
ORDER BY dateEvent ASC";


$list=mysql_query($sql);
while($result=mysql_fetch_array($list))
{ $date = strtotime($result['dateEvent'])	;

echo "<tr>
			<td>".$result['dateEvent']."</td>
			<td><a class='menu' onclick=\"deletePresence('".$result['raid_player_ID']."','".$date."')\" href=\"javascript:void(0)\">X</a></td>
      </tr>";  } ;
echo "</table>

<script type=\"text/javascript\">
	function deletePresence(id,date){   
				$(\"#event\").load(\"resources/php/FO_Div_Event.php?user_ID=$usertest&date=\" + date  );
				$(\"#right\").load(\"resources/php/FO_Div_Presence.php?user_ID=$usertest&delete=\" + id);
			}
</script>";

?>