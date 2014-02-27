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

//Title
echo "<h3>".$lng[p_FO_Div_Chantal_h3_1]."</h3>

<table>
<tr>";
//Retrieving event information
$sql="SELECT r.raid_event_ID,  UNIX_TIMESTAMP(r.dateRaid) AS dateRaid, r.event, r.map, r.color, r.time, u.username,r.comment,
      COUNT(p.character_ID) AS count
      FROM ".$gm_prefix."raid_event AS r 
      LEFT JOIN ".$table_prefix."users AS u ON u.user_ID=r.user_ID_leader
      LEFT JOIN ".$gm_prefix."raid_presence AS p ON p.dateEvent=r.dateRaid
      WHERE r.dateRaid >= DATE(CURDATE())
      GROUP BY r.raid_event_ID
	  ORDER BY r.dateRaid
      LIMIT 2";
$list=mysql_query($sql); 
while( $result=mysql_fetch_array($list))
{ 
$title = strftime('%A %e %B', $result['dateRaid']);
$title = utf8_encode( $title );
echo "<td>
     <p><b>".$title."</b><br />
     <b>".$result['event']."</b><br />
     ".$lng[t_raid_event_map]." : <b>".$result['map']."</b><br />
     ".$lng[t_raid_event_time]." : <b>".$result['time']."</b><br />
    ".$lng[t_raid_event_leader]." : <b>".$result['username']."</b><br />
    ".$lng[t_raid_event_comment]." : <b>".$result['comment']."</b><br/>
    ".$lng[p_FO_Div_Chantal_p_1]." : <b>".$result['count']."</b></p></td>" ;
     };

     echo "</tr></table>"

?>