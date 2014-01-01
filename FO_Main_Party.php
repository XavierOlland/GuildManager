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
$dateEvent = $_GET['date'];

//Creating language variables
//include('resources/language.php');

//Start of html page / Début du code html
echo "
<html>
<head>";
//Common <head> elements / Eléments <head> communs
	include('resources/php/FO_Head.php');

//Page specific <head> elements / Eléments <head> spécifique à la page
echo "
	<style> body {background-image:url('resources/images/Perso_BG.jpg');background-size:100%; background-repeat:no-repeat;}</style>

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
				<h2>Les groupes</h2>
				<p>Date de l'&eacute;v&eacute;nement : <input style='width:100px' type=\"text\" id=\"dateEvent\" /> 
				<input type='radio' name='type' value='auto' />Automatique <input type='radio' name='type' value='manuel' /> Manuel <input type='button' value='Cr&eacute;er les groupes' onclick=\"createParties()\"><br /></p>
				<div class='extand' id='result'>
        </div>
			</div>
			<div class='right'>
				<h6>Ordre des professions</h6>
				<table>
        <form name='profession' id='profession' method='POST' action=''>
				<tr>";
				$sql="SELECT p.profession_ID, p.partyOrder, a.color, a.text_ID, a.translation 
        FROM guild_profession AS p 
        INNER JOIN guild_param AS a ON a.param_ID=p.param_ID 
        ORDER BY p.partyOrder" ;
				$list=mysql_query($sql);
				while($result=mysql_fetch_array($list))
				{ echo "<tr>
								<td><img src='resources/images/".$result['text_ID']."_Icon.png'></td>
								<td>".$result['translation']."</td>
								<td><input type='hidden' name='id[]' value='".$result['profession_ID']."' />
										<input style='width:20px;' type='text' name='partyOrder".$result['profession_ID']."' value='".$result['partyOrder']."' /></td>
								</tr>";}
				echo "
				<tr><td colspan='2'><input type='submit' name='profession' value='Enregistrer'></td></tr>
				</form></table>
			</div>
		</div>
		<div class='Copyright'>Copyright &copy; 2013 Xavier Olland, publi&eacute; sous licence GNU AGPL</div>
	</div>";
//Presence module form management / Gestion du formulaire de présence
echo "
<script type=\"text/javascript\"> $(function() { $( \"#dateEvent\" ).datepicker({ dateFormat: \"yy-mm-dd\" }); });</script>

<script type=\"text/javascript\">
	function createParties(){   
		$.ajax({
			type: \"POST\",
			url: \"resources/php/FO_Div_Party.php\",
			data: \"dateEvent=\" + document.getElementById(\"dateEvent\").value +
						\"&type=\" + $(\"input[name=type]:checked\").val(),
			success: function(html){
				$(\"#result\").html(html);
			}
		});
		}
	</script>";
  
if (isset($_POST['profession'])) {
	foreach($_POST['id'] as $id)
{

$sql1="UPDATE guild_profession SET partyOrder= '".$_POST['partyOrder'.$id]."' WHERE profession_ID='".$id[$i]."'";
$result1=mysql_query($sql1);

}
}

;
echo "

	<script type=\"text/javascript\"  src=\"resources/js/Menu_Match.js\"></script>
</body>
</html>"; }
//Non authorized user / utilisateur non autorisé
else { include('resources/php/FO_Div_Register.php'); }
?>

