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
 
//MySQL connection / Connexion à MySQL
include('../../../config.php');
//GuildManager main configuration file / Fichier de configuration principal GuildManager
include('../config.php');

//Enregistrement dans la base de données
$usertest = $_POST['user_ID'];
if (strlen($usertest) == 0 ){$usertest = $_GET['user_ID'];};
$raid_absence_ID=$_GET['delete'];

if ($_POST['action']=='create'){ 
$sql1="INSERT INTO guild_raid_absence (user_ID, dateAbsence ) VALUES ('$usertest',STR_TO_DATE('$_POST[dateAbsence]', '%d/%m/%Y'))"; 
if (!mysql_query($sql1,$con)){$actionresult="Erreur dans l'enregistrement.";} ; };

if (strlen($raid_absence_ID) > 0){ 
$sql1="DELETE FROM guild_raid_absence WHERE raid_absence_ID='$raid_absence_ID'"; 
if (!mysql_query($sql1,$con)){$actionresult="Erreur dans la suppression.";} ; };


//Liste des absences futures

echo "
<h6>Absences pr&eacute;vues</h6>
<table>";

mysql_query("SET lc_time_names = 'FO_FR'");
$sql="SELECT raid_absence_ID, DATE_FORMAT(dateAbsence,'%W %e %M') AS dateAbsence 
FROM guild_raid_absence 
WHERE user_ID = ".$usertest." 
ORDER BY dateAbsence ASC";
$list=mysql_query($sql);
while($result=mysql_fetch_array($list))
{ echo "<tr>
        <td>".$result['dateAbsence']."</td>
        <td><a class='menu' onclick=\"$('#absence').load('resources/php/FO_Div_Absence.php?delete=".$result['raid_absence_ID']."&user_ID=".$usertest."');\" href='#'>X</a></td>
        </tr>";  } ;
echo "</table>";

?>