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

$id = $_POST['id'];
$row = mysqli_fetch_row(mysqli_query($con,"SELECT count(*) FROM ".$gm_prefix."userinfo WHERE user_ID = '$id'"));
$line = $row[0];
//Update / Mise à jour
if ( $line > 0){
$sql1="UPDATE ".$gm_prefix."userinfo SET 
		commander = case WHEN '$_POST[commander]'='on' THEN 1 ELSE 0 END,
		comment = '$_POST[comment]',
		monday = case WHEN '$_POST[monday]'='on' THEN 1 ELSE 0 END,
		tuesday = case WHEN '$_POST[tuesday]'='on' THEN 1 ELSE 0 END,
		wednesday = case WHEN '$_POST[wednesday]'='on' THEN 1 ELSE 0 END,
		thursday = case WHEN '$_POST[thursday]'='on' THEN 1 ELSE 0 END,
		friday = case WHEN '$_POST[friday]'='on' THEN 1 ELSE 0 END,
		saturday = case WHEN '$_POST[saturday]'='on' THEN 1 ELSE 0 END,
		sunday = case WHEN '$_POST[sunday]'='on' THEN 1 ELSE 0 END 
		WHERE user_ID='$id'"; 
}
 
//Row creation on first use / Création de l'enregistrement lors de la première utilisation
else { $sql1="INSERT INTO ".$gm_prefix."userinfo 
		(user_ID, commander, comment, monday, tuesday, wednesday, thursday, friday, saturday, sunday)
		VALUES ('$id','$_POST[commander]','$POST[comment]',
		case WHEN '$_POST[monday]'='on' THEN 1 ELSE 0 END,
		case WHEN '$_POST[tuesday]'='on' THEN 1 ELSE 0 END,
		case WHEN '$_POST[wednesday]'='on' THEN 1 ELSE 0 END,
		case WHEN '$_POST[thursday]'='on' THEN 1 ELSE 0 END,
		case WHEN '$_POST[friday]'='on' THEN 1 ELSE 0 END,
		case WHEN '$_POST[saturday]'='on' THEN 1 ELSE 0 END,
		case WHEN '$_POST[sunday]'='on' THEN 1 ELSE 0 END)"; 
};

if (!mysqli_query($con,$sql1)){die(mysqli_error().$lng[g__error_record].$sql1);} 
else { echo "<script>alert(\"".$lng['p_FO_Script_User_update']."\")</script>"; }; 

