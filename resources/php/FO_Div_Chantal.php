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

//Title
echo "<h3>".$lng[p_FO_Div_Chantal_h3_1]."</h3>

<table>
<tr>";
//Retrieving event information
$sql="SELECT r.raid_event_ID, UNIX_TIMESTAMP(r.dateEvent) AS dateEvent, r.event, r.map, r.color, r.time, u.username,r.comment,
	  r.dateEvent AS sqlDate, DATE_FORMAT(r.dateEvent,'%W') AS day
      FROM ".$gm_prefix."raid_event AS r 
      LEFT JOIN ".$table_prefix."users AS u ON u.user_ID=r.user_ID_leader
      WHERE r.dateEvent >= DATE(CURDATE())
      GROUP BY r.raid_event_ID
	  ORDER BY r.dateEvent
      LIMIT $event_next";

$list=mysqli_query($con,$sql); 
while( $result=mysqli_fetch_array($list,MYSQLI_ASSOC))
{ 
$sql1="SELECT x.online,x.user_ID, x.username,x.character_ID, x.name, x.param_ID_profession, x.text_ID, x.color
FROM 
(SELECT CASE WHEN s.session_time > (s.session_time-3600) THEN 'Online' ELSE 'Offline' END AS online,
u.user_ID, u.username,c.character_ID, c.name, c.param_ID_profession, p1.text_ID, p1.color, p2.partyorder
FROM ".$table_prefix."users AS u
INNER JOIN ".$gm_prefix."raid_player AS r ON r.user_ID=u.user_ID 
INNER JOIN ".$gm_prefix."character AS c ON c.character_ID=r.character_ID 
INNER JOIN ".$gm_prefix."param AS p1 ON p1.param_ID=c.param_ID_profession
INNER JOIN ".$gm_prefix."profession AS p2 ON p2.param_ID=p1.param_ID
LEFT JOIN ".$table_prefix."sessions AS s ON s.session_user_ID=u.user_ID
WHERE r.dateEvent='".$result['sqlDate']."' AND r.presence=1
UNION
SELECT  CASE WHEN s.session_time > (s.session_time-3600) THEN 'Online' ELSE 'Offline' END AS online,
u.user_ID, u.username,c.character_ID, c.name, c.param_ID_profession, p1.text_ID, p1.color, p2.partyorder
FROM ".$table_prefix."users AS u
INNER JOIN ".$gm_prefix."userinfo AS m ON m.user_ID=u.user_ID
INNER JOIN ".$gm_prefix."character AS c ON c.user_ID=u.user_ID 
INNER JOIN ".$gm_prefix."param AS p1 ON p1.param_ID=c.param_ID_profession
INNER JOIN ".$gm_prefix."profession AS p2 ON p2.param_ID=p1.param_ID
LEFT JOIN ".$table_prefix."sessions AS s ON s.session_user_ID=u.user_ID
WHERE m.".$result['day']."=1 AND c.main=1) AS x
WHERE 
x.user_ID NOT IN (SELECT user_ID FROM ".$gm_prefix."raid_player WHERE dateEvent='".$result['sqlDate']."' and presence=0)
GROUP BY x.user_ID
ORDER BY x.partyOrder";

$list1=mysqli_query($con,$sql1);
$count=mysqli_num_rows($list1);

$title = strftime('%A %e %B', $result['dateEvent']);
$title = utf8_encode( $title );

echo "<td>
     <p><b>".$title."</b><br />
     <b>".$result['event']."</b><br />
     ".$lng[t_raid_event_map]." : <b>".$result['map']."</b><br />
     ".$lng[t_raid_event_time]." : <b>".$result['time']."</b><br />
    ".$lng[t_raid_event_leader]." : <b>".$result['username']."</b><br />
    ".$lng[t_raid_event_comment]." : <b>".$result['comment']."</b><br/>
    ".$lng[p_FO_Div_Chantal_p_1]." : <b>$count</b></p></td>" ;
     };

     echo "</tr></table>";

?>