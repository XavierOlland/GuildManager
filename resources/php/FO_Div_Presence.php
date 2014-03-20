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

//MySQL connection / Connexion à MySQL
include('../../../config.php');
//GuildManager main configuration file / Fichier de configuration principal GuildManager
include('../config.php');
//Language management / Gestion des traductions
include('../language.php');

mysqli_query($con,"SET lc_time_names = '$local'");
$usertest = $_GET['user_ID'];
$raid_player_ID=$_GET['delete'];

if (strlen($raid_player_ID) > 0){ 
$sql1="DELETE FROM ".$gm_prefix."raid_player WHERE raid_player_ID='$raid_player_ID'"; 
if (!mysqli_query($con,$sql1)){$actionresult=$lng[g__error_delete];} ; };


//Liste des absences futures
echo "
<h5>".$lng[p_FO_Div_Presence_h5_1]."</h5>
<h6>".$lng[p_FO_Div_Presence_h6_1]."</h6>
<table><tr>";

//Day ordering / Ordre des jours
	$sql = "SELECT LEFT( d.$local, 1 ), d.en_EN
	FROM ".$gm_prefix."param AS p 
	LEFT JOIN ".$gm_prefix."dictionary AS d ON d.table_ID=p.param_ID AND d.entity_name='param'
	WHERE p.type = 'day'  
	ORDER BY value";
	
	$list=mysqli_query($con,$sql);
	while($result=mysqli_fetch_row($list))
	{ $sql1="SELECT ".$result[1]." FROM guild_userinfo WHERE user_ID=$usertest";
		$list1=mysqli_query($con,$sql1);
		while($result1=mysqli_fetch_row($list1))
	{ if( $result1[0] == 1 ){ echo "<th class='center' width='18'>".$result[0]."</th>" ; }
	else { echo "<td class='fade' width='18'>".$result[0]."</td>" ; }; }; };

echo "</tr></table>
<h6>".$lng[p_FO_Div_Presence_h6_2]."</h6>
<table>
	<tr>
		<th>".$lng[g__date]."</th>
		<th>".$lng[g__perso]."</th>
		<th>X</th>
	</tr>";

mysqli_query($con,"SET lc_time_names = '$local'");
$sql="SELECT p.raid_player_ID, DATE_FORMAT(p.dateEvent,'%a %e.%m') AS dateEvent, p.dateEvent AS dateSql, c.name 
FROM ".$gm_prefix."raid_player AS p
INNER JOIN ".$gm_prefix."character AS c ON c.character_ID=p.character_ID
WHERE p.user_ID = ".$usertest." AND presence=1
AND dateEvent >= DATE(now())
ORDER BY p.dateEvent ASC";
$list=mysqli_query($con,$sql);
while($result=mysqli_fetch_array($list,MYSQLI_ASSOC))
{ $date = strtotime($result['dateSql']);
echo "<tr>
        <td>".$result['dateEvent']."</td>
        <td>".$result['name']."</td>
        <td><a class='table' onclick=\"deletePresence('".$result['raid_player_ID']."','".$date."')\" href=\"javascript:void(0)\">X</a></td>
        </tr>";  } ;
echo "</table>
<br />
<h5>".$lng[p_FO_Div_Presence_h5_2]."</h5>
<table>
	<tr>
		<th>".$lng[g__date]."</th>
		<th>X</th>
	</tr>";

$sql="SELECT raid_player_ID, DATE_FORMAT(dateEvent,'%W %e %M') AS dateEvent
FROM ".$gm_prefix."raid_player  
WHERE user_ID = ".$usertest." AND presence=0 
AND dateEvent >= DATE(now())
ORDER BY dateEvent ASC";

$list=mysqli_query($con,$sql);
while($result=mysqli_fetch_array($list,MYSQLI_ASSOC))
{ $date = strtotime($result['dateEvent'])	;

echo "<tr>
			<td>".$result['dateEvent']."</td>
			<td><a class='table' onclick=\"deletePresence('".$result['raid_player_ID']."','".$date."')\" href=\"javascript:void(0)\">X</a></td>
      </tr>";  } ;
echo "</table>

<script>
	function deletePresence(id,date){   
				$(\"#FO_Event\").load(\"resources/php/FO_Div_Event.php?user_ID=$usertest&date=\" + date  );
				$(\"#Right\").load(\"resources/php/FO_Div_Presence.php?user_ID=$usertest&delete=\" + id);
			}
</script>";

?>