<?php
/*  Guild Manager v1.1.0 (Princesse d�Ampshere)
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

//MySQL connection / Connexion � MySQL
include('../../../config.php');
//GuildManager main configuration file / Fichier de configuration principal GuildManager
include('../config.php');
//Language management / Gestion des traductions
include('../language.php');


//locale variables / Variables locales
$date = $_POST['dateEvent'];
$sqlday = date('l', $date);
$sqldate = date('Y\-m\-d', $date);
$type = $_POST['type'];


//Party prepartation / Pr�paration des groupes
if ($date == '2012-08-31'){
	$sql="SELECT a.user_ID, a.character_ID, a.name, a.param_ID_profession, c.text_ID,  c.color, u.username 
	FROM ".$gm_prefix."character AS a 
	INNER JOIN ".$gm_prefix."param AS c ON c.param_ID=a.param_ID_profession 
	INNER JOIN ".$gm_prefix."profession AS p ON p.param_ID=c.param_ID
	LEFT JOIN ".$table_prefix."users AS u ON u.user_ID=a.user_ID
	WHERE a.main=1 
	ORDER BY p.partyOrder";
	}
else {
	$sql="SELECT x.user_ID, x.character_ID, x.name, x.text_ID, x.color
	FROM 
	(SELECT u.user_ID, c.character_ID, c.name, p1.text_ID, p1.color, p2.partyorder
	FROM ".$table_prefix."users AS u
	INNER JOIN ".$gm_prefix."raid_player AS r ON r.user_ID=u.user_ID 
	INNER JOIN ".$gm_prefix."character AS c ON c.character_ID=r.character_ID 
	INNER JOIN ".$gm_prefix."param AS p1 ON p1.param_ID=c.param_ID_profession
	INNER JOIN ".$gm_prefix."profession AS p2 ON p2.param_ID=p1.param_ID
	WHERE r.dateEvent='$sqldate' AND r.presence=1
	UNION
	SELECT  u.user_ID, c.character_ID, c.name, p1.text_ID, p1.color, p2.partyorder
	FROM ".$table_prefix."users AS u
	INNER JOIN ".$gm_prefix."userinfo AS m ON m.user_ID=u.user_ID
	INNER JOIN ".$gm_prefix."character AS c ON c.user_ID=u.user_ID 
	INNER JOIN ".$gm_prefix."param AS p1 ON p1.param_ID=c.param_ID_profession
	INNER JOIN ".$gm_prefix."profession AS p2 ON p2.param_ID=p1.param_ID
	WHERE m.$sqlday=1 AND c.main=1) AS x
	WHERE x.user_ID NOT IN (SELECT user_ID FROM ".$gm_prefix."raid_player WHERE dateEvent='$sqldate' and presence=0)
	GROUP BY x.user_ID
	ORDER BY x.partyOrder" ; 
	}; 
	
	$list=mysqli_query($con,$sql);
	$count=mysqli_num_rows($list);
	$number=ceil($count/5); $number2=$number+$party_add;
	$partyNum=1;$counter=1;

echo " <head>
<style>
ul.link { list-style-type: none; margin: 0px; padding: 0px; }
li.party { margin: 0 0px 5px 0px; padding: 0px; width:100%}</style>
<script>
$(function() {
$( \"";
while ( $partyNum <= $number2 ){ echo "#party_".$partyNum; if($partyNum < $number2){ echo ","; } ;  $partyNum++; }; $partyNum=1;
echo "\" ).sortable( {
connectWith: \".link\"
}).disableSelection();
});
</script>
</head>

<h3>".$lng[p_FO_Div_Party_h3_1]."</h3>
				<table>";
				
				    if ( $type == 'manuel'){
					echo "<tr>";
					while ( $partyNum <= $number2 ){ echo"<th>".$lng[p_FO_Div_Party_party]." $partyNum</th><td></td>"; $partyNum++; } ;
					$partyNum=1; echo "</tr><tr class='top'>";
					while($result=mysqli_fetch_array($list,MYSQLI_ASSOC)){
					if ( $counter == 1 ){ echo"<td><ul id='party_$partyNum' class='link'>"; $partyNum++; } ;
						echo "
						<li class=\"party\" style='background-color:".$result['color']."' ><img src='resources/theme/$theme/images/".$result['text_ID']."_Icon.png'> ".$result['name']." </li>";
					if ( $counter == 5 ){ echo "<li> - </li></ul></td><td></td>"; $counter=1; } else { $counter++; } ;
					} ;
					if ( $counter > 1 ){ echo "<li> - </li></ul></td><td></td>"; $counter=1; };
					while ($partyNum <= $number2 ){ echo"<td><ul id='party_$partyNum' class='link'><li> - </li></ul></td><td></td>"; $partyNum++; };
					
					echo "</tr><tr><td style='height:auto' colspan='2'></td></tr>";}
					else {
					echo "<colgroup>
							<col span='1' style='width:26px'>
							<col style='width:auto'>
						  </colgroup><tr>";
					while ( $partyNum <= $number ){ echo"<th colspan='2'>".$lng[p_FO_Div_Party_party]." $partyNum</th><td></td>"; $partyNum++; } ;
					echo "</tr>";
					while($result=mysqli_fetch_array($list,MYSQLI_ASSOC))
					{ if ($counter == 1){ echo "<tr>";} ;
					echo "
						<td style='background-color:".$result['color']."'><a href='FO_Main_Profession.php?id=".$result['param_ID_profession']."'>
							<img src='resources/theme/$theme/images/".$result['text_ID']."_Icon.png'></a></td> 
              <td class='colorbg' style='background-color:".$result['color']."'><a class='colorbg' alt='".$result['username']."' href='FO_Main_CharacterEdit.php?character=".$result['character_ID']."'>".$result['name']."</a></td>
              <td></td>";
					if ($counter == $number){ echo "</tr>"; $counter=1;} else{ $counter++; } ;
					};
					};
					
			echo "</table>
				<br />";
?>

