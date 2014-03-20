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

$id = $_POST['character_ID'];

//Executing Action / Execution de l'action
//Mise à jour
if ( $id != 0 ){
$sql1="UPDATE ".$gm_prefix."character SET user_ID ='$_POST[user_ID]', character_ID='$_POST[character_ID]', name='$_POST[name]', param_ID_race='$_POST[race]', param_ID_profession='$_POST[profession]', level='$_POST[level]', level_wvw='$_POST[level_wvw]', comment='$_POST[comment]', main=(case WHEN '$_POST[main]'='1' THEN 1 ELSE 0 END), param_ID_gameplay='$_POST[gameplay]', build='$_POST[build]' WHERE character_ID='$_POST[character_ID]' "; 
if (!mysqli_query($con,$sql1)){$actionresult=$lng[g__error_record];} 
else { $actionresult="<p class='red'>".$lng[p_FO_Main_CharacterEdit_update]."</p>";} ; 
$id = $_POST['character_ID'] ; };
//Création
if ( $id == 0 ){ 
$sql1="INSERT INTO ".$gm_prefix."character (user_ID, name, param_ID_race, param_ID_profession, level, level_wvw, comment, main, param_ID_gameplay, build ) VALUES ('$_POST[user_ID]','$_POST[name]','$_POST[race]','$_POST[profession]','$_POST[level]','$_POST[level_wvw]','$_POST[comment]',CASE WHEN '$_POST[main]'='1' THEN 1 ELSE 0 END,'$_POST[gameplay]','$_POST[build]')"; 
if (!mysqli_query($con,$sql1)){$actionresult=$lng[g__error_record];} 
else { $actionresult="<p class='red'>".$lng[p_FO_Main_CharacterEdit_create]."</p>";} ;
$id = mysqli_insert_id($con) ; };

echo $id ;


