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

//Page variables creation / Création des variables spécifiques pour la page
$usertest = $_GET['user_ID'];
$type = $_GET['type'];
$date = $_GET['date'];
$id = $_GET['id'];
$title = strftime('%A %e %B', $date);
$title = utf8_encode( $title );
$sqlday = date('l', $date);
$sqldate = date('Y\-m\-d', $date);

//creating ID if missing
if ( $id == 0 ){
while( $result=mysql_fetch_row(mysql_query("SELECT raid_event_ID FROM guild_raid_event WHERE dateRaid='$date'")))
{ $id=$result[0];echo $id;};
};

//Registering player

if ($_POST['action']=='join'){ 
$sql1="INSERT INTO guild_raid_presence (user_ID, dateEvent, character_ID ) VALUES ('$usertest','$sqldate','$_POST[character_ID]' )"; 
if (!mysql_query($sql1,$con)){$actionresult="Erreur dans l'enregistrement.";} ; };

//Retrieving event information
$sql="SELECT r.raid_event_ID, r.event, r.map, r.time, u.username,r.comment 
      FROM guild_raid_event AS r 
      LEFT JOIN ".$table_prefix."users AS u ON u.user_ID=r.user_ID_leader
      WHERE r.raid_event_ID=$id";
$list=mysql_query($sql); 
while( $result=mysql_fetch_row($list))
{
echo"<h3>".$title."</h3><br />
     <h4>".$result[1]."</h4><br />
     <table>
     <tr class='top'><td>
     <p>Carte : <b>".$result[2]."</b><br />
     Horaires : <b>".$result[3]."</b><br />
     Lead : <b>".$result[4]."</b><br />
     </td>
     <td>Commentaire :<br /> ".$result[5]."</td></tr>
     <tr></tr>";
     if ($cfg_calendar_mode == 'Presence'){ 
     $sql = "SELECT * FROM guild_raid_presence WHERE dateEvent='$sqldate' AND user_ID=$usertest";
     $result=mysql_query($sql); 
     $num_rows = mysql_num_rows($result);
     //  $result=mysql_num_rows($list);
     
     if ($num_rows == 0) { echo"<tr class='top'><td colspan='2'>
     <select id=\"character_ID\" >";
$sql="SELECT a.character_ID, a.name, a.main, c.text_ID, c.color 
FROM guild_character AS a 
INNER JOIN guild_param AS c ON c.param_ID=a.param_ID_profession 
WHERE a.user_ID = ".$usertest." 
ORDER BY a.main DESC, a.param_ID_profession";
$list=mysql_query($sql);
while($result=mysql_fetch_array($list))
{ echo "<option value='".$result['character_ID']."'";
if ($result['main']==1){ echo "selected"; };
echo " > ".$result['name']."</option>";
};
echo "</select>
<input type='button' value='Participer' onclick=\"joinEvent()\" href='#'>
     </td><tr>";} 

     };

if ($cfg_calendar_mode == 'Presence'){ 
$sql = "SELECT CASE WHEN s.session_time > (s.session_time-3600) THEN 'Online' ELSE 'Offline' END AS online, 
u.user_ID, u.username,c.character_ID, c.name, c.param_ID_profession, p1.text_ID, p1.color
FROM ".$table_prefix."users AS u
INNER JOIN guild_raid_presence AS r ON r.user_ID=u.user_ID
INNER JOIN guild_character AS c ON c.character_ID=r.character_ID 
INNER JOIN guild_param AS p1 ON p1.param_ID=c.param_ID_profession
INNER JOIN guild_profession AS p2 ON p2.param_ID=p1.param_ID
LEFT JOIN ".$table_prefix."sessions AS s ON s.session_user_ID=u.user_ID
WHERE r.dateEvent='$sqldate' 
GROUP BY u.user_ID 
ORDER BY p2.partyOrder";}
else {
$sql = "SELECT CASE WHEN s.session_time > (s.session_time-3600) THEN 'Online' ELSE 'Offline' END AS online, 
u.user_ID, u.username,c.character_ID, c.name, c.param_ID_profession, p1.text_ID, p1.color
FROM ".$table_prefix."users AS u
INNER JOIN guild_userinfo AS m ON m.user_ID=u.user_ID
INNER JOIN guild_character AS c ON c.user_ID=u.user_ID AND c.main=1
INNER JOIN guild_param AS p1 ON p1.param_ID=c.param_ID_profession
INNER JOIN guild_profession AS p2 ON p2.param_ID=p1.param_ID
LEFT JOIN ".$table_prefix."sessions AS s ON s.session_user_ID=u.user_ID
WHERE m.$sqlday=1 
m.user_ID NOT IN (SELECT user_ID FROM guild_raid_absence WHERE dateAbsence='$sqldate')
ORDER BY p2.partyOrder";};
$list=mysql_query($sql);
$count=mysql_num_rows($list);
     echo "
     <tr class='top'><td colspan='2'>
     <p>Membres pr&eacute;sents ($count) : </p>
     <div id='members'>
     <table>";
while($result=mysql_fetch_array($list))
{ echo "<tr style='background-color:".$result['color']."'>
<td><img src='resources/images/".$result['online'].".png'></td>
<td><a href='FO_Main_Profession.php?id=".$result['param_ID_profession']."'><img src='resources/images/".$result['text_ID']."_Icon.png'></a></td>
<td><a class='table' href='FO_Main_CharacterEdit.php?character=".$result['character_ID']."'>".$result['name']."</a></td>
<td><a class='table' href='FO_Main_User.php?user=".$result['user_ID']."'>".$result['username']."</a></td>
</tr>"; };
echo"
</tr></table></div>

<img src='resources/images/Next.png'>
<a class='table' href='#' onclick=\"createParties()\">Cr&eacute;er les groupes</a> 
<input type='radio' name='type' value='auto' checked='checked'>Auto
<input type='radio' name='type' value='manuel'>Manuel
</td></tr></table>
<script src='resources/style/jquery.min.js'></script> 
<script src='resources/style/jquery-ui.js'></script>
<script type=\"text/javascript\">
	function joinEvent(){   
		$.ajax({
			type: \"POST\",
			url: \"resources/php/FO_Div_Event.php?user_ID=$usertest&type=$type&id=$id&date=$date\",
			data: \"action=join\" +
				  \"&character_ID=\" + document.getElementById(\"character_ID\").value,
			success: function(html){
			 $(\"#presence\").load(\"resources/php/FO_Div_Presence.php?user_ID=$usertest\");
				$(\"#event\").html(html);
			}
		});
		
		}
	
	</script>
<script type=\"text/javascript\">
	function createParties(){   
		$.ajax({
			type: \"POST\",
			url: \"resources/php/FO_Div_Party.php\",
			data: \"dateEvent=$sqldate\" +
				  \"&type=\" + $(\"input[name=type]:checked\").val(),
			success: function(html){
				$(\"#parties\").html(html);
				$('#members').hide( 'blind' );
				$('#parties').show( 'blind' );
			}
		});
		
		}
	
	</script>

";
};

 ?>