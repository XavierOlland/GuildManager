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

//PHPBB connection / Connexion à phpBB
include('resources/phpBB_Connect.php');
//GuildManager main configuration file / Fichier de configuration principal GuildManager
include('resources/config.php');

//Page variables creation / Création des variables spécifiques pour la page
$id = $_GET['user'];
$action = $_GET['action'];

//Creating language variables
//include('resources/language.php');

//Start of html page / Début du code html
echo "
<html>
<head>";
//Common <head> elements / Eléments <head> communs
	include('resources/php/FO_Head.php');

//Page specific <head> elements / Eléments <head> spécifique à la page
//Scripts
//Stats
echo "
	<script type=\"text/javascript\" src=\"resources/style/jquery.jqplot.min.js\"></script>
	<script type=\"text/javascript\" src=\"resources/style/jqplot.pieRenderer.js\"></script>
	<link rel='stylesheet' type='text/css' href='resources/style/jquery.jqplot.css' />
	<script type=\"text/javascript\">$(document).ready(function(){
		var data = [";
		$total=mysql_result(mysql_query("SELECT count(character_ID) FROM guild_character WHERE main=1"),0);
		$sql="SELECT c.translation, COUNT( a.character_ID )/$total AS num, c.color
		FROM guild_character AS a
		INNER JOIN guild_param AS c ON c.param_ID = a.param_ID_profession
		WHERE a.main =1
		GROUP BY c.param_ID " ;
		$list=mysql_query($sql);
		$count=mysql_num_rows($list);
		while($result=mysql_fetch_array($list)){
		echo "['".$result['translation']."', ".$result['num']."]"; $count--; if( $count > 0) {echo",";};};
		echo " ];
		var plot1 = jQuery.jqplot ('piechart1', [data],
		{
			seriesDefaults: {
				renderer: jQuery.jqplot.PieRenderer,
				rendererOptions: {
					showDataLabels: true,
					sliceMargin: 2
				}
			},
			legend: { show:false, location: 's' },
			seriesColors: [ ";
										$list2=mysql_query($sql);
										$count=mysql_num_rows($list2);
										while($result2=mysql_fetch_array($list2))
										{ echo "'".$result2['color']."'" ; $count--; if( $count > 0) {echo",";};};
echo " ],
			grid: {
				drawGridLines: false,  
				background: 'transparent',
				borderWidth: 0.0,
				shadow: false
			} 
		});

	});
	</script>
  <script>
$(document).ready(function(){
  $(\"#stat1_next\").click(function(){
    $(\"#stat1\").hide();
    $(\"#piechart1\").hide();
    $(\"#stat2\").show();
    var data = [";
		$total=mysql_result(mysql_query("SELECT count(character_ID) FROM guild_character WHERE main=1"),0);
		$sql="SELECT c.translation, COUNT( a.character_ID )/$total AS num, c.color
		FROM guild_character AS a
		INNER JOIN guild_param AS c ON c.param_ID = a.param_ID_gameplay
		WHERE a.main =1
		GROUP BY c.param_ID " ;
		$list=mysql_query($sql);
		$count=mysql_num_rows($list);
		while($result=mysql_fetch_array($list)){
		echo "['".$result['translation']."', ".$result['num']."]"; $count--; if( $count > 0) {echo",";};};
		echo " ];
		var plot1 = jQuery.jqplot ('piechart2', [data],
		{
			seriesDefaults: {
				renderer: jQuery.jqplot.PieRenderer,
				rendererOptions: {
					showDataLabels: true,
					sliceMargin: 2
				}
			},
			legend: { show:true, location: 's' },
			seriesColors: [ ";
										$list2=mysql_query($sql);
										$count=mysql_num_rows($list2);
										while($result2=mysql_fetch_array($list2))
										{ echo "'".$result2['color']."'" ; $count--; if( $count > 0) {echo",";};};
echo " ],
			grid: {
				drawGridLines: false,  
				background: 'transparent',
				borderWidth: 0.0,
				shadow: false
			} 
		});
  });
  $(\"#stat2_next\").click(function(){
    $(\"#stat2\").hide();
    $(\"#stat1\").show();
    $(\"#piechart1\").show();
  });
});
</script>
  
	<style> body {background-image:url('resources/images/Perso_BG.jpg');background-size:100%; background-repeat:no-repeat;}
          #stat2 {display:none;}
          #stat1 img {float:right;}
          #stat2 a {float:right;} </style>
</head>
<body>
	<div class='Main'>
		<div class='Title'><h1>".$cfg_title."</h1></div>";
//User permissions test / Test des permissions utilisateur
			if (in_array($user->data['group_id'],$cfg_groups)){
			//Registered user code / Code pour utilisateurs enregistrés
		echo "
		<div class='Menu'>";
					include('resources/php/FO_Div_Menu.php');
					include('resources/php/FO_Div_Match.php');
		echo "
		</div>";
		echo "
		<div class='Page'>
			<div class='Core'>
				<h2>Le Bus</h2>
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
						<th>Profession</th>
						<th>Level</th>
						<th>McM</th>
						<th>Gameplay</th>
						<th>Build</th>
					</tr>";
					$sqlp="SELECT a.user_ID, a.character_ID, a.name, a.param_ID_race, r.translation AS race, a.param_ID_profession, c.value AS profession, 
					a.level, a.level_wvw, a.build, CASE WHEN LENGTH(a.build) > 0 THEN CONCAT('<a href=\'',a.build,'\' target=\'blank\'>Voir</a>') ELSE '' END AS buildlink,
					a.comment, c.text_ID, c.translation, c.color, a.param_ID_gameplay, o.value AS gameplay, 
					CASE WHEN s.session_time > (s.session_time-3600) THEN 'Online' ELSE 'Offline' END AS online, u.username
					FROM guild_character AS a  
					INNER JOIN guild_param AS c ON c.param_ID=a.param_ID_profession 
					INNER JOIN guild_param AS r ON r.param_ID=a.param_ID_race 
					INNER JOIN guild_param AS o ON o.param_ID=a.param_ID_gameplay
          INNER JOIN guild_profession AS p ON p.param_ID=c.param_ID
					LEFT JOIN ".$table_prefix."sessions AS s ON s.session_user_ID=a.user_ID
					LEFT JOIN ".$table_prefix."users AS u ON u.user_ID=a.user_ID
					WHERE a.main=1 
					GROUP BY a.character_ID
					ORDER BY p.partyOrder, a.name" ; 
					$listp=mysql_query($sqlp);
					while($resultp=mysql_fetch_array($listp))
					{ echo "
					<tr style='background-color:".$resultp['color']."'>
						<td><img src='resources/images/".$resultp['online'].".png'></td>
						<td><a onclick=\"$('#result').load('resources/php/FO_Div_Profession.php?id=".$resultp['param_ID_profession']."');$('#result').show();\" href='#'>
							<img src='resources/images/".$resultp['text_ID']."_Icon.png'></a></td>
						<td><a class='table' href='FO_Main_CharacterEdit.php?character=".$resultp['character_ID']."'>".$resultp['name']."</a></td>
						<td>".$resultp['username']."</td>
						<td>".$resultp['race']."</td>
						<td><a class='table' href='FO_Main_Profession.php?id=".$resultp['param_ID_profession']."' >".$resultp['translation']."</a></td>
						<td>".$resultp['level']."</td>
						<td>".$resultp['level_wvw']."</td>
						<td>".$resultp['gameplay']."</td>
						<td>".$resultp['buildlink']."</td>
					</tr>";
					};
					echo "
					<tr>
						<td></td>
						<td><img src='resources/images/upperReturn.png'></td>
						<td colspan='10'>Cliquez sur une ic&ocirc;ne pour afficher les personnages de la classe.</td>
					</tr>
					<tr>
						<td></td><td></td><td colspan='10'>ou alors <a class='table' href='#'' onclick=\"createParties()\">affichez les groupes</a></td>
					</tr>
				</table>
				<br />
				<br />
				<div class='extand' id='result'></div>
			</div>
			<div class='right'>
				<h5>Statistiques</h5>
				<div id='stat1'>
					<h6>Professions</h6>
					<div id='piechart1'></div>
					<p class='right'><table class='right'><tr><td><img src='resources/images/Next.png' /></td><td><a class='mright' id='stat1_next' href='#'>GamePlays</a></td></tr></table></p>
				</div>

				<div id='stat2'>
					<h6>GamePlays</h6>
					<div id='piechart2'></div>
					<p class='right'><table class='right'><tr><td><img src='resources/images/Next.png' /></td><td><a class='mright' id='stat2_next' href='#'>Professions</a></td></tr></table></p>
				</div>
			</div>
		</div>
		<div class='Copyright'>Copyright &copy; 2013 Xavier Olland, publi&eacute; sous licence GNU AGPL</div>
	</div>
<script type=\"text/javascript\">
	function createParties(){   
		$.ajax({
			type: \"POST\",
			url: \"resources/php/FO_Div_Party.php\",
			data: \"dateEvent=2012-08-31\" +
						\"&type=auto\",
			success: function(html){
				$(\"#result\").html(html);
			}
		});
		
		}
	
	</script>
	<script type=\"text/javascript\"  src=\"resources/js/Menu_Match.js\"></script>
</body>
</html>"; }
//Non authorized user / utilisateur non autorisé
else { include('resources/php/FO_Div_Register.php'); }
?>

