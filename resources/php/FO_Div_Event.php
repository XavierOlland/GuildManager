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
//Language management / Gestion des traductions
include('../language.php');

//Page variables creation / Création des variables spécifiques pour la page
$usertest = $_GET['user_ID'];
$date = $_GET['date'];
$id = $_GET['id'];
$action = $_GET['action'];
$character_ID = $_POST['character_ID'];
$title = strftime('%A %e %B', $date);
$title = utf8_encode( $title );
$sqlday = date('l', $date);
$sqldate = date('Y\-m\-d', $date);

//creating ID if missing
if ( $id == 0 ){ 
	$list=mysql_query("SELECT raid_event_ID FROM ".$gm_prefix."raid_event WHERE dateRaid='$sqldate'");
	while( $result=mysql_fetch_row($list) ) { $id = $result[0]; };
};


//Registering player
if ( $action != 2 ){ 

	$count = mysql_num_rows(mysql_query("SELECT * FROM ".$gm_prefix."raid_player WHERE dateEvent='$sqldate' AND user_ID=$usertest"));
	$list=mysql_query("SELECT $sqlday FROM ".$gm_prefix."userinfo WHERE user_ID=$usertest");
	while( $result=mysql_fetch_row($list) ) { $day = $result[0]; };
	
		if( $count == 0 )
			{ $sql1="INSERT INTO ".$gm_prefix."raid_player (user_ID, dateEvent, character_ID, presence ) VALUES ($usertest,'$sqldate',$character_ID,$action)"; }
		else { 
		if ( $action==0 && $day==0 ) { 
			//echo "DELETE FROM ".$gm_prefix."raid_player WHERE user_ID=$usertest AND dateEvent='$sqldate'";
			$sql1 = "DELETE FROM ".$gm_prefix."raid_player WHERE user_ID=$usertest AND dateEvent='$sqldate'" ;
			 }
			else { 
			//echo "UPDATE ".$gm_prefix."raid_player SET character_ID='$character_ID', presence='$action' WHERE user_ID=$usertest AND dateEvent='$sqldate'"; 
			$sql1 = "UPDATE ".$gm_prefix."raid_player SET character_ID='$character_ID', presence='$action' WHERE user_ID=$usertest AND dateEvent='$sqldate'"; };
			};
	
	if (!mysql_query($sql1,$con)){$actionresult=$lng[g__error_record]; }; 
	
	};

//Retrieving event information
$sql="SELECT r.raid_event_ID, r.event, r.map, r.time, u.username,r.comment 
      FROM ".$gm_prefix."raid_event AS r 
      LEFT JOIN ".$table_prefix."users AS u ON u.user_ID=r.user_ID_leader
      WHERE r.raid_event_ID=$id";
$list=mysql_query($sql); 
while( $result=mysql_fetch_row($list))
{
echo"<h3>".$title."</h3><br />
     <h4>".$result[1]."</h4><br />
     <table>
     <tr class='top'><td>
     <p>".$lng[t_raid_event_map]." : <b>".$result[2]."</b><br />
     ".$lng[t_raid_event_time]." : <b>".$result[3]."</b><br />
     ".$lng[t_raid_event_leader]." : <b>".$result[4]."</b><br />
     </td>
     <td>".$lng[t_raid_event_comment]." :<br /> ".$result[5]."</td></tr>
     <tr></tr>";
	 
	$sql0 = "SELECT presence FROM ".$gm_prefix."raid_player WHERE dateEvent='$sqldate' AND user_ID=$usertest 
	UNION SELECT $sqlday FROM ".$gm_prefix."userinfo WHERE $sqlday=1 AND user_ID=$usertest AND user_ID NOT IN (SELECT user_ID FROM ".$gm_prefix."raid_player WHERE dateEvent='$sqldate')
	GROUP BY user_ID";
	$list0=mysql_query($sql0); 
	$result0=mysql_fetch_row($list0);
	
	$sql1="SELECT a.character_ID, a.name, a.main
	FROM ".$gm_prefix."character AS a 
	WHERE a.user_ID = ".$usertest." 
	ORDER BY a.main DESC, a.param_ID_profession";
	$list1=mysql_query($sql1);
	$num_rows = mysql_num_rows($list1);
			
	if ($num_rows == 0) { echo "<tr class='top'><td colspan='2'><a class='menu' href='FO_Main_CharacterEdit.php?action=new'>".$lng[p_FO_Div_Event_a_1]."</a></td></tr>"; }
	else { 	
		echo "<tr class='top'><td colspan='2'>
			<select id=\"character_ID\" >";
			while($result1=mysql_fetch_array($list1))
			{ echo "<option value='".$result1['character_ID']."'";
			if ($result1['main']==1){ echo "selected"; }; echo " > ".$result1['name']."</option>"; };
			echo "</select>";
				
			if ($result0[0] == 0) { echo "<input type='button' value='".$lng[p_FO_Div_Event_join]."' onclick=\"eventPresence(1)\" href=\"javascript:void(0)\"></td></tr>"; }
			else { echo "<input type=\"button\" value=\"".$lng[p_FO_Div_Event_change]."\" onclick=\"eventPresence(1)\" href=\"javascript:void(0)\"></td></tr>
			<tr><td colspan='2'><input type=\"button\" value=\"".$lng[p_FO_Div_Event_leave]."\" onclick=\"eventPresence(0)\" href=\"javascript:void(0)\"></td></tr>"; 
			}; 
	}
	
$sql="SELECT x.online,x.user_ID, x.username,x.character_ID, x.name, x.param_ID_profession, x.text_ID, x.color
FROM 
(SELECT CASE WHEN s.session_time > (s.session_time-3600) THEN 'Online' ELSE 'Offline' END AS online,
u.user_ID, u.username,c.character_ID, c.name, c.param_ID_profession, p1.text_ID, p1.color, p2.partyorder
FROM ".$table_prefix."users AS u
INNER JOIN ".$gm_prefix."raid_player AS r ON r.user_ID=u.user_ID 
INNER JOIN ".$gm_prefix."character AS c ON c.character_ID=r.character_ID 
INNER JOIN ".$gm_prefix."param AS p1 ON p1.param_ID=c.param_ID_profession
INNER JOIN ".$gm_prefix."profession AS p2 ON p2.param_ID=p1.param_ID
LEFT JOIN ".$table_prefix."sessions AS s ON s.session_user_ID=u.user_ID
WHERE r.dateEvent='$sqldate' AND r.presence=1
UNION
SELECT  CASE WHEN s.session_time > (s.session_time-3600) THEN 'Online' ELSE 'Offline' END AS online,
u.user_ID, u.username,c.character_ID, c.name, c.param_ID_profession, p1.text_ID, p1.color, p2.partyorder
FROM ".$table_prefix."users AS u
INNER JOIN ".$gm_prefix."userinfo AS m ON m.user_ID=u.user_ID
INNER JOIN ".$gm_prefix."character AS c ON c.user_ID=u.user_ID 
INNER JOIN ".$gm_prefix."param AS p1 ON p1.param_ID=c.param_ID_profession
INNER JOIN ".$gm_prefix."profession AS p2 ON p2.param_ID=p1.param_ID
LEFT JOIN ".$table_prefix."sessions AS s ON s.session_user_ID=u.user_ID
WHERE m.$sqlday=1 AND c.main=1) AS x
WHERE 
x.user_ID NOT IN (SELECT user_ID FROM ".$gm_prefix."raid_player WHERE dateEvent='$sqldate' and presence=0)
GROUP BY x.user_ID
ORDER BY x.partyOrder";

$list=mysql_query($sql);
$count=mysql_num_rows($list);
     echo "
     <tr class='top'><td colspan='2'>
     <p>".$lng[p_FO_Div_Event_p_1]." ($count) : </p>
     <div id='members'>
     <table>";
while($result=mysql_fetch_array($list))
{ echo "<tr style='background-color:".$result['color']."'>
<td><img src='resources/images/".$result['online'].".png'></td>
<td><a href='FO_Main_Profession.php?id=".$result['param_ID_profession']."'><img src='resources/images/".$result['text_ID']."_Icon.png'></a></td>
<td><a class='table' href='FO_Main_CharacterEdit.php?character=".$result['character_ID']."'>".$result['name']."</a></td>
<td><a class='table' href='FO_Main_User.php?user=".$result['user_ID']."'>".$result['username']."</a></td>
</tr>"; };
echo "
</tr></table></div>

<img src='resources/images/Next.png'>
<a class='table' href=\"javascript:void(0)\"' onclick=\"createParties()\">".$lng[g__create_parties]."</a>
<input type='radio' name='type' value='auto' checked='checked'>".$lng[g__auto]."
<input type='radio' name='type' value='manuel'>".$lng[g__manual]."
</td></tr></table>
<script src='resources/style/jquery.min.js'></script> 
<script src='resources/style/jquery-ui.js'></script>

<script>
	function eventPresence(a){   
		$.ajax({
			type: \"POST\",
			url: \"resources/php/FO_Div_Event.php?user_ID=$usertest&id=$id&date=$date&action=\" + a,
			data: \"&character_ID=\" + document.getElementById(\"character_ID\").value,
			success: function(html){
			 $(\"#right\").load(\"resources/php/FO_Div_Presence.php?user_ID=$usertest\");
			 $(\"#event\").html(html);
			}
		});		
	}	
</script>
<script>
	function createParties(){   
		$.ajax({
			type: \"POST\",
			url: \"resources/php/FO_Div_Party.php\",
			data: \"dateEvent=$date\" +
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