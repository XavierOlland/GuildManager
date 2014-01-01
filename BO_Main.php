<?php 
//PHPBB connection / Connexion à phpBB
include('resources/phpBB_Connect.php');
//GuildManager main configuration file / Fichier de configuration principal GuildManager
include('resources/config.php');

//Page variables creation / Création des variables spécifiques pour la page
$date = date('Y-m-d', time());

//Start of html page / Début du code html
echo	"<html>
<head>";
include('resources/php/FO_Head.php');
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
			<div class='MenuBO'>";
					include('resources/php/BO_Div_Menu.php');
					//include('resources/php/FO_Div_Match.php');
		echo "
			</div>";
			echo "
			<div class='PageBO'>
				<div class='CoreBO'>
				<h2>Outils de param&egrave;trage</h2>
				<p>Dans le menu de gauche vous pouvez activer/d&eacute;sactiver les acc&egrave;diff&eacute;rents modules.<br />
				Ci-dessous vous pouvez g&eacute;rer les &eacute;v&egrave;nements de l'agenda.</p>
				<br />
				<h2>Calendrier des raids</h2>
				<br />
				<div class='extand' id='result'></div>";
//Event display / Affichage des évènements
echo "<div id='eventR'></div>
<div id='event'><p>Cliquez sur un &eacute;v&eacute;nement pour afficher le d&eacute;tail ici.</p></div>
				</div>

			</div>
			<div class='Copyright'>Copyright &copy; 2013 Xavier Olland, publi&eacute; sous licence GNU AGPL</div>
		</div>";
//Scripts
//Loading module / chargement des modules 
echo "
<script type=\"text/javascript\">
$('#result').load(\"resources/php/BO_Div_Calendar.php?date=".$date."\");
</script>";
//Presence module form management / Gestion du formulaire de présence
echo "
<script type=\"text/javascript\"  src=\"resources/js/Menu_Match.js\"></script>  
			</body></html>"; }
//Non authorized user / utilisateur non autorisé
else { include('resources/php/FO_Div_Register.php'); }
?>
