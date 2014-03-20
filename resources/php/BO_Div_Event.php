 <?php 
 /* Guild Manager v1.1.0 (Princesse d’Ampshere)
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
$id = $_GET['id'];
$date = $_GET['date'];
$action = $_GET['action'];
$title = strftime('%A %e %B', $date);
$title = utf8_encode( $title );
$sqlday = date('l', $date);
$sqldate = date('Y\-m\-d', $date);
$today = date('Y-m-d', time());

if( strlen($id) == 0 ){ 
	$sql="SELECT raid_event_id FROM ".$gm_prefix."raid_event WHERE dateEvent='$sqldate'";
	$list=mysqli_query($con,$sql);
	$result=mysqli_fetch_row($list);
	$id = $result[0]; if( strlen($id) == 0 ){ $id = 0; }; 
};

if ($id == 0){ echo "<script>$(\"#delete\").hide()</script>";} else {echo "<script >$(\"#delete\").show()</script>";};

//Retrieving event information
$sql="SELECT r.raid_event_ID,  r.event, r.map, r.color, r.time, u.user_ID, r.comment
      FROM ".$gm_prefix."raid_event AS r 
      LEFT JOIN ".$table_prefix."users AS u ON u.user_ID=r.user_ID_leader
      WHERE r.raid_event_ID=$id";
 
$list=mysqli_query($con,$sql); 
while( $result=mysqli_fetch_row($list))
{
echo "<form name='raidevent' id='RaidEvent' method='POST' action='' onsubmit=\"return false\">
     <input type='hidden' name='raid_id' id='raid_id' value='".$id."'>
     <input type='text' id='dateEvent' class='h3' value='".$title."'/>
     <input type='hidden' name='dateEvent' id='hiddenDateEvent' value='".$sqldate."'><br />
     <input type='text' name='event' class='h4' value='".$result[1]."' /><br />
     <table>
		<tr><td colspan='2'><p>".$lng[t_raid_event_map]." : <input type='text' name='map' class='p' value='".$result[2]."'/>
		<tr><td colspan='2'><p>".$lng[t_raid_event_color]." : <select name='color' class='p'>
			<option value='#606060' ";  if ($result[3]=='#606060') { echo "selected" ;}; echo ">-</option>
			<option value='#A80000' style='color:#A80000;' ";  if ($result[3]=='#A80000') { echo "selected" ;}; echo ">".$lng[g__red]."</option>
			<option value='#0033FF' style='color:#0033FF;' ";  if ($result[3]=='#0033FF') { echo "selected" ;}; echo ">".$lng[g__blue]."</option>
			<option value='#006600' style='color:#006600;' ";  if ($result[3]=='#006600') { echo "selected" ;}; echo ">".$lng[g__green]."</option>
			<option value='#CC9933' style='color:#CC9933;' ";  if ($result[3]=='#CC9933') { echo "selected" ;}; echo ">".$lng[g__gold]."</option>
			</select></p></td></tr>
		<tr><td colspan='2'><p>".$lng[t_raid_event_time]." : <input type='text' name='time' class='p' value='".$result[4]."'/></p></td></tr>
		<tr><td colspan='2'><p>".$lng[t_raid_event_leader]." : <select name='user_ID_leader' class='p'>";
		$sqlC="SELECT u.username, u.user_ID FROM ".$table_prefix."users AS u INNER JOIN ".$gm_prefix."userinfo AS i ON i.user_ID=u.user_ID WHERE i.commander=1";
		$listC=mysqli_query($con,$sqlC);
		while($resultC=mysqli_fetch_array($list,MYSQLI_ASSOCC))
		{ echo "<option value='".$resultC['user_ID']."' " ;if ($resultC['user_ID']==$result[5]) { echo "selected" ;}; echo ">".$resultC['username']."</option>";};
		echo "</select></p></td></tr>
		<tr class='top'><td><p>".$lng[t_raid_event_comment]." : </p></td><td>
		<textArea style='width:240px; height:80px;' form='raidevent' name='comment' >".$result[6]."</textArea></td></tr>";
	 
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
$list1=mysqli_query($con,$sql1);
$count=mysqli_num_rows($list1);

     echo "
     <tr><td colspan='2'><p style='font-weight:bold;'>$count ".$lng[p_BO_Div_Event_p_5]."</p></td></tr>
	 <tr><td colspan='2'><input type='submit' value='".$lng[g__save]."'></form></td></tr>
	 <tr><td colspan='2'><input type='button' id='delete' value='".$lng[g__delete]."' onclick=\"deleteEvent()\"></td></tr>
	 </table>
	 
	 
<script>
$('#RaidEvent').submit(function(){   
		$.ajax({
			type: \"POST\",
			url: \"resources/php/BO_Script_Event.php\",
			data: $('#raidevent').serialize() + \"&date=$date&id=$id&action=update\",
			success: function(){
				$(\"#BO_Calendar\").load(\"resources/php/BO_Div_Calendar.php?date=$today\");
				$(\"#BO_Event\").load(\"resources/php/BO_Div_Event.php?date=$date\");
			}
		});
});
</script>";
	
//DELETE
echo "<script>
function deleteEvent(){   
		 $.post(\"resources/php/BO_Script_Event.php\",{id:$id,action:'delete'},function(){
				$(\"#BO_Calendar\").load(\"resources/php/BO_Div_Calendar.php?date=$today\");
				$(\"#BO_Event\").load(\"resources/php/BO_Div_Event.php?date=$date&id=0\");
			});
			}</script>";

//Date picker
		echo "<script> $(function() { $( \"#dateEvent\" ).datepicker({ 
dateFormat: \"DD d MM\",  altField: \"#hiddenDateEvent\",
altFormat: \"yy-mm-dd\" }); });</script>
";
};

 ?>