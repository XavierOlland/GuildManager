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

$id = $_GET['id']; 
$admin = $_GET['admin'];

if ( strlen($id) == 0 ) { echo "<h3>".$lng['p_FO_Div_Profession_p_1']."</h3>";}
else {
$sqli="SELECT a.param_ID, a.text_ID, a.image, a.color, d.$local, u.user_id,
        u.username, CASE WHEN LENGTH(p.build) > 0 THEN CONCAT('<a href=\'' ,p.build, '\' target=\'blank\'>".$lng[g__see]."</a>') ELSE '' END AS buildlink, p.build, p.strategy
        FROM ".$gm_prefix."profession AS p
        LEFT JOIN ".$gm_prefix."param AS a ON a.param_ID=p.param_ID
        LEFT JOIN ".$table_prefix."users AS u ON u.user_ID=p.user_ID_coach
		LEFT JOIN ".$gm_prefix."dictionary AS d ON d.table_ID=a.param_ID AND entity_name='param_plural'
        WHERE p.param_ID='$id'" ;
$listi=mysqli_query($con,$sqli);
while($resulti=mysqli_fetch_row($listi))
{ 
 echo "
	<h2>".$resulti[4]."</h2>
	<h3>".$lng['p_FO_Div_Profession_h3_1']."</h3>
		<p style='margin-left:10px;'>
		".$lng['t_profession_coach']." : <b>".$resulti[6]."</b><br />
		".$lng['t_profession_build']." : <b>".$resulti[7]."</b><br />
		".$lng['t_profession_strategy']." : <b>".$resulti[9]."</b><br />

		</p><br />";
		//Admin panel / Panneau admin
			if ($admin == 1){ echo "
			<input id='AdminLink' class='admin' type='button' href='javascript.void()' onclick=\"adminPanelShow()\" value='".$lng['g__adminPanel']."'/>
			<div class='extand' id='AdminPanel' style='display:none;'>
			<form id='admin' action='FO_Main_Profession.php?id=".$id."' method='post' > 
				<input type='hidden' name='action' value='update'>
				<fieldset class='admin'>
				<legend class='admin'>".$lng['g__adminPanel']."</legend>
				<table>
					<tr><td>".$lng['t_profession_coach']." :</td><td>
					<select form='admin' id='coach' name='coach' class='p'>";
					$sqlC="SELECT u.username, u.user_ID FROM ".$table_prefix."users AS u INNER JOIN ".$gm_prefix."userinfo AS i ON i.user_ID=u.user_ID";
					$listC=mysqli_query($con,$sqlC);
					while($resultC=mysqli_fetch_array($listC,MYSQLI_ASSOC))
					{ echo "<option value='".$resultC['user_ID']."' " ;if ($resultC['user_ID']==$resulti[5]) { echo "selected" ;}; echo ">".$resultC['username']."</option>";
};
echo "</select></td></tr>
					<tr><td>".$lng['t_profession_build']." : </td><td><input class='p' form='admin' style='width:400px;' class='p' type='text' id='build' name='build' value='".$resulti[8]."'/></td></tr>
					<tr class='top'><td>".$lng['t_profession_strategy']." : </td><td><textarea style='width:400px; height:80px;' form='admin' id='strategy' name='strategy'>".$resulti[9]."</textarea></td></tr>
					<tr><td colspan='2'><input type='submit' value='".$lng['g__save']."' /></td></tr>
				</table>
				<input id='AdminLink2' class='admin' type='button' href='javascript.void()' onclick=\"adminPanelHide()\" value='".$lng['g__hide']."'/>							
				</fieldset>
			</div>
			<br />"; };
		
$sqlp="SELECT a.user_ID, a.character_ID, a.name, a.param_ID_race, rd.$local AS race, a.param_ID_profession, c.text_ID AS profession, 
CASE WHEN IFNULL(a.main,0)=1 THEN 'Oui' ELSE 'Non' END AS main, 
a.level, a.level_wvw, a.build,CASE WHEN LENGTH(a.build) > 0 THEN CONCAT('<a class=\'colorbg\' href=\'',a.build,'\' target=\'blank\'>".$lng['g__see']."</a>') ELSE '' END AS buildlink,
 a.comment, c.text_ID, c.color, a.param_ID_gameplay, o.value AS gameplay, 
CASE WHEN s.session_time > (s.session_time-3600) THEN 'Online' ELSE 'Offline' END AS online, u.username
FROM ".$gm_prefix."character AS a 
INNER JOIN ".$gm_prefix."param AS c ON c.param_ID=a.param_ID_profession 
INNER JOIN ".$gm_prefix."param AS r ON r.param_ID=a.param_ID_race
LEFT JOIN ".$gm_prefix."dictionary AS rd ON rd.table_ID=r.param_ID AND rd.entity_name='param' 	 
INNER JOIN ".$gm_prefix."param AS o ON o.param_ID=a.param_ID_gameplay
LEFT JOIN ".$table_prefix."sessions AS s ON s.session_user_ID=a.user_ID
INNER JOIN ".$table_prefix."users AS u ON u.user_ID=a.user_ID
WHERE a.main=1 AND a.param_ID_profession='$id' 
GROUP BY a.character_ID 
ORDER BY a.name" ;

$listp=mysqli_query($con,$sqlp);
if( mysqli_num_rows($listp)>0){
echo "
	<h3>".$lng[p_FO_Div_Profession_h3_2]."</h3>
		<table>
			<colgroup>
				<col span='1' style='width:16px'>
				<col span='1' style='width:26px'>
				<col style='width:auto'>
			</colgroup>
			<tr>
				<th></th>
				<th></th>
				<th>".$lng['t_character_name']."</th>
				<th>".$lng['g__player']."</th>
				<th>".$lng['t_character_race']."</th>
				<th>".$lng['t_character_level']."</th>
				<th>".$lng['t_character_level_wvw']."</th>
				<th>".$lng['t_character_gameplay']."</th>
				<th>".$lng['t_character_build']."</th>
				<th>".$lng['t_character_comment']."</th>
			</tr>";

			while($resultp=mysqli_fetch_array($listp,MYSQLI_ASSOC))
			{ echo "
			<tr style='background-color:".$resultp['color']."'>
				<td class='colorbg'><img src='resources/theme/$theme/images/".$resultp['online'].".png'></td>
				<td class='colorbg'><img src='resources/theme/$theme/images/".$resultp['text_ID']."_Icon.png'></td>
				<td class='colorbg'><a class='colorbg' href='FO_Main_CharacterEdit.php?character=".$resultp['character_ID']."'>".$resultp['name']."</a></td>
				<td class='colorbg'>".$resultp['username']."</td>
				<td class='colorbg'>".$resultp['race']."</td>
				<td class='colorbg'>".$resultp['level']."</td>
				<td class='colorbg'>".$resultp['level_wvw']."</td>
				<td class='colorbg'>".$resultp['gameplay']."</td>
				<td class='colorbg'>".$resultp['buildlink']."</td>
				<td class='colorbg'>".$resultp['comment']."</td>
			</tr>"; };
			echo "
		</table>
		<br />"; } 
		$sqlp="SELECT a.user_ID, a.character_ID, a.name, a.param_ID_race, rd.$local AS race, a.param_ID_profession,c.text_ID AS profession, 
		CASE WHEN IFNULL(a.main,0)=1 THEN 'Oui' ELSE 'Non' END AS main, 
		a.level, a.level_wvw, a.build,CASE WHEN LENGTH(a.build) > 0 THEN CONCAT('<a class=\'colorbg\' href=\'',a.build,'\' target=\'blank\'>".$lng[g__see]."</a>') ELSE '' END AS buildlink,
		a.comment, c.text_ID, c.color, a.param_ID_gameplay, o.value AS gameplay, 
		CASE WHEN s.session_time > (s.session_time-3600) THEN 'Online' ELSE 'Offline' END AS online, u.username
		FROM ".$gm_prefix."character AS a 
		INNER JOIN ".$gm_prefix."param AS c ON c.param_ID=a.param_ID_profession 
		INNER JOIN ".$gm_prefix."param AS r ON r.param_ID=a.param_ID_race
		LEFT JOIN ".$gm_prefix."dictionary AS rd ON rd.table_ID=r.param_ID AND rd.entity_name='param' 			
		LEFT JOIN ".$gm_prefix."param AS o ON o.param_ID=a.param_ID_gameplay
		LEFT JOIN ".$table_prefix."sessions AS s ON s.session_user_ID=a.user_ID
		INNER JOIN ".$table_prefix."users AS u ON u.user_ID=a.user_ID
		WHERE IFNULL(a.main,0)=0 AND a.param_ID_profession='$id' 
		GROUP BY a.character_ID 
		ORDER BY a.name" ;
		$listp=mysqli_query($con,$sqlp);
		if( mysqli_num_rows($listp)>0){ 
		echo "
	<h3>".$lng[p_FO_Div_Profession_h3_3]."</h3>
		<table>
			<colgroup>
				<col span='1' style='width:16px'>
				<col span='1' style='width:26px'>
				<col style='width:auto'>
			</colgroup>
			<tr>
				<th></th>
   				<th></th>
				<th>".$lng['t_character_name']."</th>
				<th>".$lng['g__player']."</th>
				<th>".$lng['t_character_race']."</th>
				<th>".$lng['t_character_level']."</th>
				<th>".$lng['t_character_level_wvw']."</th>
				<th>".$lng['t_character_gameplay']."</th>
				<th>".$lng['t_character_build']."</th>
				<th>".$lng['t_character_comment']."</th>
			</tr>"; 
			while($resultp=mysqli_fetch_array($listp,MYSQLI_ASSOC))
			{ echo "
			<tr style='background-color:".$resultp['color']."'>
				<td class='colorbg'><img src='resources/theme/$theme/images/".$resultp['online'].".png'></td>
				<td class='colorbg'><img src='resources/theme/$theme/images/".$resultp['text_ID']."_Icon.png'></td>
				<td class='colorbg'><a class='colorbg' href='FO_Main_CharacterEdit.php?character=".$resultp['character_ID']."'>".$resultp['name']."</a></td>
				<td class='colorbg'>".$resultp['username']."</td>
				<td class='colorbg'>".$resultp['race']."</td>
				<td class='colorbg'>".$resultp['level']."</td>
				<td class='colorbg'>".$resultp['level_wvw']."</td>
				<td class='colorbg'>".$resultp['gameplay']."</td>
				<td class='colorbg'>".$resultp['buildlink']."</td>
				<td class='colorbg'>".$resultp['comment']."</td>
			</tr>";};
			echo "
		</table>
		<br />";};
};
} 
?>