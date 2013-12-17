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
include('resources/config.php');

//Page variables creation / Création des variables spécifiques pour la page
$id = $_GET['character'];
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
echo "
<style> body {background-image:url('resources/images/Perso_BG.jpg');background-size:100%; background-repeat:no-repeat;} </style>
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
		echo "</div>";
	 echo "
   <div class='Page'>
   <div class='CoreFull'>";
//Character deletion / Suppression d'un personnage
if ($action=='delete'){
$id=$_GET['character'];
//Checking user identity / Vérification de l'identité de l'exécutant
$test=mysql_result(mysql_query("SELECT user_ID FROM guild_character WHERE character_ID='$id'"),0);
if ($test==$user->data['user_id']) {
$sql1="DELETE FROM guild_character WHERE character_ID='$id' "; 
if (!mysql_query($sql1,$con)){die(mysql_error()."<p>Erreur lors de la suppression.</p>".$sql1);} ; 
echo "<p>Le personnage a &eacute;t&eacute; supprim&eacute;.</p>"; }; };

//Diplay of characters / Affichage de la liste des personnage
   echo "<h2>Mes personnages</h2>
   <table border=1>
   <tr>
   <th></th>
   <th>Nom</th>
   <th>Race</th>
   <th>Profession</th>
   <th>Principal</th>
   <th>Level</th>
   <th>WvW</th>
   <th>Gameplay</th>
   <th>Build</th>
   <th>Commentaire</th>
   <th></th>
   </tr>";
$sql="SELECT a.user_ID, a.character_ID, a.name, a.param_ID_race, r.text_ID AS race, a.param_ID_profession,c.value AS profession, 
CASE WHEN IFNULL(a.main,0)=1 THEN 'Oui' ELSE 'Non' END AS main, 
a.level, a.level_wvw, a.build,CASE WHEN LENGTH(a.build) > 0 THEN CONCAT('<a href=\'',a.build,'\' target=\'blank\'>Voir</a>') ELSE '' END AS buildlink,
 a.comment, c.text_ID, c.translation, c.color, a.param_ID_gameplay, o.value AS gameplay 
FROM guild_character AS a 
INNER JOIN guild_param AS c ON c.param_ID=a.param_ID_profession 
INNER JOIN guild_param AS r ON r.param_ID=a.param_ID_race 
LEFT JOIN guild_param AS o ON o.param_ID=a.param_ID_gameplay 
WHERE a.user_ID = ".$user->data['user_id']." 
ORDER BY a.main DESC, a.param_ID_profession";
$list=mysql_query($sql);
while($result=mysql_fetch_array($list))
{ echo "<tr style='background-color:".$result['color']."'>
<td><a onclick=\"$('#result').load('resources/php/FO_Div_Profession.php?id=".$result['param_ID_profession']."');$('#result').show();\" href='#'>
    <img src='resources/images/".$result['text_ID']."_Icon.png'></a></td>
<td><a class='table' href='FO_Main_CharacterEdit.php?character=".$result['character_ID']."'>".$result['name']."</a></td>
<td>".$result['race']."</td>
<td><a class='table' href='FO_Main_Profession.php?id=".$result['param_ID_profession']."' >".$result['translation']."</a></td>
<td>".$result['main']."</td><td>".$result['level']."</td><td>".$result['level_wvw']."</td>
<td>".$result['gameplay']."</td>
<td>".$result['buildlink']."</td>
<td>".$result['comment']."</td>
<td><a class='table' href='FO_Main_Character.php?action=delete&character=".$result['character_ID']."' onclick=\"return confirm('Etes vous certain de vouloir supprimer ".$result['name']."? Cette action est irr&eacute;versible.');\">Suppr.</a></td>
</tr>";
};
//Profession display / Affichage des professions
echo "
<tr>
<td><img src='resources/images/upperReturn.png'></td>
<td class='left' colspan='10'>Cliquez sur une ic&ocirc;ne pour afficher les personnages de la classe.</td></tr>
</table>
<br />
<a class='table' href='FO_Main_CharacterEdit.php?action=new'>Ajouter un personnage</a><br />
<br />
<div id='result'></div>


</div>
      </div>
		<div class='Copyright'>Copyright &copy; 2013 Xavier Olland, publi&eacute; sous licence GNU AGPL</div>
      </div>
      <script type=\"text/javascript\"  src=\"resources/js/Menu_Match.js\"></script>
			</body></html>"; }
//Non authorized user / utilisateur non autorisé
else { include('resources/php/FO_Div_Register.php'); }
?>

