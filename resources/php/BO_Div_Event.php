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
$id = $_GET['id'];
$date = $_GET['date'];
$action = $_GET['action'];
$title = strftime('%A %e %B', $date);
$title = utf8_encode( $title );
$sqlday = date('l', $date);
$sqldate = date('Y\-m\-d', $date);
$today = date('Y-m-d', time());

//Action management / Gestion des actions
if( $action == 'delete')
{
$sql1="DELETE FROM ".$gm_prefix."raid_event WHERE raid_event_ID='$id'"; 
if (!mysql_query($sql1,$con)){$actionresult=$lng[g__error_delete];}
else {
echo "
<script type=\"text/javascript\">$(\"#result\").load(\"resources/php/BO_Div_Calendar.php?date=$today\");</script>
<p class='red'>".$lng[p_BO_Div_Event_p_1]."</p><br />
<p>".$lng[p_BO_Div_Event_p_2]."</p>";
}
 ; }
else {
	if( $action == 'update'){
	$sql0="SELECT raid_event_id FROM ".$gm_prefix."raid_event WHERE dateRaid='$_POST[dateRaid]' AND raid_event_ID!=$id";
	$list0=mysql_query($sql0);
	$count=mysql_num_rows($list0);
	if( $count != 0 ){
		echo "<p class='red'>".$lng[p_BO_Div_Event_p_3]."</p><br />"; 
							}
				
	else {	
		if ($id == 0){
			$sql1="INSERT INTO ".$gm_prefix."raid_event ( dateRaid, time, map, color, event, user_ID_leader, comment ) VALUES ('$_POST[dateRaid]','$_POST[time]','$_POST[map]','$_POST[color]','$_POST[event]','$_POST[user_ID_leader]','$_POST[comment]')"; 
			if (!mysql_query($sql1,$con)){$actionresult=$lng[g__error_create];}
		else { $id = mysql_insert_id();
			echo "
			<script type=\"text/javascript\">$(\"#result\").load(\"resources/php/BO_Div_Calendar.php?date=$today\");</script>
			<p class='red'>".$lng[p_BO_Div_Event_p_4]."</p><br />";
			};}	
		else {
			$sql1="UPDATE ".$gm_prefix."raid_event SET dateRaid='$_POST[dateRaid]', time='$_POST[time]', map='$_POST[map]', color='$_POST[color]', event='$_POST[event]', user_ID_leader='$_POST[user_ID_leader]', comment='$_POST[comment]' WHERE raid_event_ID='$id'"; 
		if (!mysql_query($sql1,$con)){$actionresult=$lng[g__error_create];}
		else { 
			echo "
			<script type=\"text/javascript\">$(\"#result\").load(\"resources/php/BO_Div_Calendar.php?date=$today\");</script>
			<p class='red'>".$lng[p_BO_Div_Event_p_4]."</p><br />";
			};}	;
		
		};
	};
}; 
 
if ($id == 0){echo "<script type=\"text/javascript\">$(\"#delete\").hide()</script>";} else {echo "<script type=\"text/javascript\">$(\"#delete\").show()</script>";};

//Retrieving event information
$sql="SELECT r.raid_event_ID,  r.event, r.map, r.color, r.time, u.user_ID, r.comment
      FROM ".$gm_prefix."raid_event AS r 
      LEFT JOIN ".$table_prefix."users AS u ON u.user_ID=r.user_ID_leader
      WHERE r.raid_event_ID=$id";
$list=mysql_query($sql); 
while( $result=mysql_fetch_row($list))
{
echo "<form name='raidevent' id='raidevent' method='POST' action='' onsubmit=\"return false\">
     <input type='hidden' name='raid_id' id='raid_id' value='".$id."'>
     <input type='text' id='dateEvent' class='h3' value='".$title."'/>
     <input type='hidden' name='dateRaid' id='hiddenDateEvent' value='".$sqldate."'><br />
     <input type='text' name='event' class='h4' value='".$result[1]."' /><br />
     <table>
     <tr class='top'>
		<td><p>".$lng[t_raid_event_map]." :</p></td>
		<td><input type='text' name='map' class='p' value='".$result[2]."'/></td>
		<td>".$lng[t_raid_event_comment]." :</td></tr>
     <tr class='top'>
		<td><p>".$lng[t_raid_event_color]." :</p></td>
		<td><select name='color' class='p''>
			<option value='#606060' ";  if ($result[3]=='#606060') { echo "selected" ;}; echo ">-</option>
			<option value='#A80000' style='color:#A80000;' ";  if ($result[3]=='#A80000') { echo "selected" ;}; echo ">".$lng[g__red]."</option>
			<option value='#0033FF' style='color:#0033FF;' ";  if ($result[3]=='#0033FF') { echo "selected" ;}; echo ">".$lng[g__blue]."</option>
			<option value='#006600' style='color:#006600;' ";  if ($result[3]=='#006600') { echo "selected" ;}; echo ">".$lng[g__green]."</option>
			<option value='#CC9933' style='color:#CC9933;' ";  if ($result[3]=='#CC9933') { echo "selected" ;}; echo ">".$lng[g__gold]."</option>
			</select></td>
		<td rowspan='3'>
		<style type='text/css'>textarea { width:170px; height:77px; background-color: transparent; border-style:none none solid solid; border-color:#333333; border-width:1px; font-family: guildText; color:#000000; font-size:16px; font-weight:bold;}</style>
		<textArea form='raidevent' name='comment' >".$result[6]."</textArea></td></tr>
     <tr class='top'>
      <td><p>".$lng[t_raid_event_time]." :</p></td>
      <td><input type='text' name='time' class='p' value='".$result[4]."'/></td>
     <tr class='top'>
      <td><p>".$lng[t_raid_event_leader]." :</p></td>
      <td><select name='user_ID_leader' class='p'>";
      $sqlC="SELECT u.username, u.user_ID FROM ".$table_prefix."users AS u INNER JOIN ".$gm_prefix."userinfo AS i ON i.user_ID=u.user_ID WHERE i.commander=1";
	  $listC=mysql_query($sqlC);
while($resultC=mysql_fetch_array($listC))
{ echo "<option value='".$resultC['user_ID']."' " ;if ($resultC['user_ID']==$result[5]) { echo "selected" ;}; echo ">".$resultC['username']."</option>";
};
echo "</select>
      </td></tr>
     <tr><td colspan='2' class='center'><input type='submit' value='".$lng[g__save]."'></form></td><td>
     <input type='button' id='delete' value='".$lng[g__delete]."' onclick=\"deleteEvent($id)\">
     </td></tr>
     
     <tr class='top'><td colspan='3'>
     ".$lng[p_BO_Div_Event_p_5]." : </p>
     
     <table>";
if ($cfg_calendar_mode == 'Presence'){ 
$sql = "SELECT CASE WHEN s.session_time > (s.session_time-3600) THEN 'Online' ELSE 'Offline' END AS online, 
u.user_ID, u.username,p.character_ID, p.name, p.param_ID_profession, c.text_ID, c.color
FROM ".$table_prefix."users AS u
INNER JOIN ".$gm_prefix."raid_presence AS r ON r.user_ID=u.user_ID
INNER JOIN ".$gm_prefix."character AS p ON p.character_ID=r.character_ID
INNER JOIN ".$gm_prefix."param AS c ON c.param_ID=p.param_ID_profession
LEFT JOIN ".$table_prefix."sessions AS s ON s.session_user_ID=u.user_ID
WHERE r.dateEvent='$sqldate' 
GROUP BY u.user_ID 
ORDER BY p.param_ID_profession";}
else {
$sql = "SELECT CASE WHEN s.session_time > (s.session_time-3600) THEN 'Online' ELSE 'Offline' END AS online, 
u.user_ID, u.username,p.character_ID, p.name, p.param_ID_profession, c.text_ID, c.color
FROM ".$table_prefix."users AS u
INNER JOIN ".$gm_prefix."userinfo AS m ON m.user_ID=u.user_ID
INNER JOIN ".$gm_prefix."character AS p ON p.user_ID=u.user_ID AND p.main=1
INNER JOIN ".$gm_prefix."param AS c ON c.param_ID=p.param_ID_profession
LEFT JOIN ".$table_prefix."sessions AS s ON s.session_user_ID=u.user_ID
WHERE m.$sqlday=1 
m.user_ID NOT IN (SELECT user_ID FROM ".$gm_prefix."raid_absence WHERE dateAbsence='$sqldate')
ORDER BY p.param_ID_profession";};
$list=mysql_query($sql);
while($result=mysql_fetch_array($list))
{ echo "<tr style='background-color:".$result['color']."'>
<td><img src='resources/images/".$result['online'].".png'></td>
<td><a href='FO_Main_Profession.php?id=".$result['param_ID_profession']."' ><img src='resources/images/".$result['text_ID']."_Icon.png'></a></td>
<td><a class='table' href='FO_Main_CharacterEdit.php?character=".$result['character_ID']."'>".$result['name']."</a></td>
<td><a class='table' href='FO_Main_User.php?user=".$result['user_ID']."'>".$result['username']."</a></td>
</tr>"; };
echo"</table></td></tr></table>





<script type=\"text/javascript\">
$('#raidevent').submit(function(event){   
		$.ajax({
			type: \"POST\",
			url: \"resources/php/BO_Div_Event.php?date=$date&id=$id&action=update\",
			data: $('#raidevent').serialize(),
   success: function(html){
				$(\"#result\").load(\"resources/php/BO_Div_Calendar.php?date=$today\");
				$(\"#event\").html(html);
 }
 });
 });

	</script>
<script type=\"text/javascript\">
	function deleteEvent(id){
  $(\"#event\").load(\"resources/php/BO_Div_Event.php?date=$sqldate&action=delete&id=\" + id);
  }
</script>
<script type=\"text/javascript\"> $(function() { $( \"#dateEvent\" ).datepicker({ 
dateFormat: \"DD d MM\",  altField: \"#hiddenDateEvent\",
altFormat: \"yy-mm-dd\" }); });</script>
";
};

 ?>