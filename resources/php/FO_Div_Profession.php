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


$id = $_GET['id']; 

 $sqli="SELECT a.param_ID, a.text_ID, a.image, a.color, a.translation,
        u.username, p.strategy, CASE WHEN LENGTH(p.build) > 0 THEN CONCAT('<a href=\'',p.build,'\' target=\'blank\'>Voir</a>') ELSE '' END AS buildlink
        FROM guild_profession AS p
        LEFT JOIN guild_param AS a ON a.param_ID=p.param_ID
        LEFT JOIN ".$table_prefix."users AS u ON u.user_ID=p.user_ID_coach
        WHERE p.param_ID='$id'" ;
$listi=mysql_query($sqli);
while($resulti=mysql_fetch_row($listi))
{ 
 echo "
	<h2>".$resulti[4]."s</h2>
	<h3>Infos g&eacute;n&eacute;rales </h3>
		<p>
		Coach : <b>".$resulti[5]."</b><br />
		Strat&eacute;gie : <b>".$resulti[6]."</b><br />
		Build conseill&eacute; : <b>".$resulti[7]."</b><br />
		</p><br />";
$sqlp="SELECT a.user_ID, a.character_ID, a.name, a.param_ID_race, r.text_ID AS race, a.param_ID_profession,c.text_ID AS profession, 
CASE WHEN IFNULL(a.main,0)=1 THEN 'Oui' ELSE 'Non' END AS main, 
a.level, a.level_wvw, a.build,CASE WHEN LENGTH(a.build) > 0 THEN CONCAT('<a href=\'',a.build,'\' target=\'blank\'>Voir</a>') ELSE '' END AS buildlink,
 a.comment, c.text_ID, c.color, a.param_ID_gameplay, o.value AS gameplay, 
CASE WHEN s.session_time > (s.session_time-3600) THEN 'Online' ELSE 'Offline' END AS online, u.username
FROM guild_character AS a 
INNER JOIN guild_param AS c ON c.param_ID=a.param_ID_profession 
INNER JOIN guild_param AS r ON r.param_ID=a.param_ID_race 
INNER JOIN guild_param AS o ON o.param_ID=a.param_ID_gameplay
LEFT JOIN ".$table_prefix."sessions AS s ON s.session_user_ID=a.user_ID
INNER JOIN ".$table_prefix."users AS u ON u.user_ID=a.user_ID
WHERE a.main=1 AND a.param_ID_profession='$id' 
GROUP BY a.character_ID 
ORDER BY a.name" ;
$listp=mysql_query($sqlp);
if( mysql_num_rows($listp)>0){
echo "
<h3>Personnages principaux</h3>
   <table>
     <colgroup>
    <col span='1' style='width:16px'>
    <col span='1' style='width:26px'>
    <col style='width:auto'>
  </colgroup>
   <tr>
   <th></th>
   <th></th>
   <th>Personnage</th>
   <th>Joueur</th>
   <th>Race</th>
   <th>Level</th>
   <th>McM</th>
   <th>Gameplay</th>
   <th>Build</th>
   <th>Commentaire</th>
   </tr>";

while($resultp=mysql_fetch_array($listp))
{ echo "<tr style='background-color:".$resultp['color']."'><td><img src='resources/images/".$resultp['online'].".png'></td>
<td><img src='resources/images/".$resultp['text_ID']."_Icon.png'></td>
<td><a class='table' href='FO_Main_CharacterEdit.php?character=".$resultp['character_ID']."'>".$resultp['name']."</a></td>
<td>".$resultp['username']."</td>
<td>".$resultp['race']."</td>
<td>".$resultp['level']."</td>
<td>".$resultp['level_wvw']."</td>
<td>".$resultp['gameplay']."</td>
<td>".$resultp['buildlink']."</td>
<td>".$resultp['comment']."</td>
</tr>";
};
echo "</table>
<br />"; } 
$sqlp="SELECT a.user_ID, a.character_ID, a.name, a.param_ID_race, r.text_ID AS race, a.param_ID_profession,c.text_ID AS profession, 
CASE WHEN IFNULL(a.main,0)=1 THEN 'Oui' ELSE 'Non' END AS main, 
a.level, a.level_wvw, a.build,CASE WHEN LENGTH(a.build) > 0 THEN CONCAT('<a href=\'',a.build,'\' target=\'blank\'>Voir</a>') ELSE '' END AS buildlink,
 a.comment, c.text_ID, c.color, a.param_ID_gameplay, o.value AS gameplay, 
CASE WHEN s.session_time > (s.session_time-3600) THEN 'Online' ELSE 'Offline' END AS online, u.username
FROM guild_character AS a 
INNER JOIN guild_param AS c ON c.param_ID=a.param_ID_profession 
INNER JOIN guild_param AS r ON r.param_ID=a.param_ID_race 
LEFT JOIN guild_param AS o ON o.param_ID=a.param_ID_gameplay
LEFT JOIN ".$table_prefix."sessions AS s ON s.session_user_ID=a.user_ID
INNER JOIN ".$table_prefix."users AS u ON u.user_ID=a.user_ID
WHERE IFNULL(a.main,0)=0 AND a.param_ID_profession='$id' 
GROUP BY a.character_ID 
ORDER BY a.name" ;
$listp=mysql_query($sqlp);
if( mysql_num_rows($listp)>0){ 
echo "<h3>Rerolls</h3>
<table>
  <colgroup>
    <col span='1' style='width:16px'>
    <col span='1' style='width:26px'>
    <col style='width:auto'>
  </colgroup>
   <tr>
   <th></th>
   <th></th>
   <th>Personnage</th>
   <th>Joueur</th>
   <th>Race</th>
   <th>Level</th>
   <th>McM</th>
   <th>Gameplay</th>
   <th>Build</th>
   <th>Commentaire</th>
   </tr>"; 
while($resultp=mysql_fetch_array($listp))
{ echo "<tr style='background-color:".$resultp['color']."'><td><img src='resources/images/".$resultp['online'].".png'></td>
<td><img src='resources/images/".$resultp['text_ID']."_Icon.png'></td>
<td><a class='table' href='FO_Main_CharacterEdit.php?character=".$resultp['character_ID']."'>".$resultp['name']."</a></td>
<td>".$resultp['username']."</td>
<td>".$resultp['race']."</td>
<td>".$resultp['level']."</td>
<td>".$resultp['level_wvw']."</td>
<td>".$resultp['gameplay']."</td>
<td>".$resultp['buildlink']."</td>
<td>".$resultp['comment']."</td></tr>";
};
echo "</table>

<br />";};

} 
?>