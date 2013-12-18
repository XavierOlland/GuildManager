<?php
//MySQL connection / Connexion à MySQL
include('../../../config.php');
//GuildManager main configuration file / Fichier de configuration principal GuildManager
include('../config.php');

//Title
echo "<h3>Ev&eacute;nements à venir</h3>

<table>
<tr>";
//Retrieving event information
$sql="SELECT r.raid_event_ID,  UNIX_TIMESTAMP(r.dateRaid) AS dateRaid, r.event, r.map, r.color, r.time, u.username,r.comment,
      COUNT(p.character_ID) AS count
      FROM guild_raid_event AS r 
      LEFT JOIN ".$table_prefix."users AS u ON u.user_ID=r.user_ID_leader
      LEFT JOIN guild_raid_presence AS p ON p.dateEvent=r.dateRaid
      WHERE r.dateRaid >= DATE(CURDATE())
      GROUP BY r.raid_event_ID
      LIMIT 2";
$list=mysql_query($sql); 
while( $result=mysql_fetch_array($list))
{ 
$title = strftime('%A %e %B', $result['dateRaid']);
$title = utf8_encode( $title );
echo "<td>
     <p><b>".$title."</b><br />
     <b>".$result['event']."</b><br />
     Carte : <b>".$result['map']."</b><br />
     Couleur : <b>".$result['color']."</b><br />
     Horaires : <b>".$result['time']."</b><br />
     Lead : <b>".$result['username']."</b><br />
     Commentaire : <b>".$result['comment']."</b><br/>
     Nombre de participants : <b>".$result['count']."</b></p></td>" ;
     };

     echo "</tr></table>"

?>