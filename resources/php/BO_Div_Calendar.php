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

//Creating needed date variables / Création des variables de dates nécessaires
$date = $_GET['date'] ;
$date = strtotime($date);
$day = date('d', $date) ;
$month = date('m', $date) ;
$year = date('Y', $date) ;
$computed_date = $year.'-'.$month.'-01';
$computed_date = date_create( $computed_date);
$prev = date_format(date_sub( $computed_date , date_interval_create_from_date_string("1 month")), 'Y-m-d');
$next = date_format(date_add( $computed_date , date_interval_create_from_date_string("2 month")), 'Y-m-d');
$current_day = date('d', time() );
$current_week = date('W', time() );
$current_month = date('m', time() );

//First day of the month / Premier jour du mois
$first_day = mktime(0,0,0,$month, 1, $year);
$title =strftime( '%B', $first_day);
$title = utf8_encode( $title );

//switching day numbers for WvW week / Modification des numéros de jours pour la semain McM
// Saturday = 1 /Samedi = 1

$computed_day = date( 'D', $first_day) ;

switch($computed_day) {
case "Sat": $blank = 0; break;
case "Sun": $blank = 1; break;
case "Mon": $blank = 2; break;
case "Tue": $blank = 3; break;
case "Wed": $blank = 4; break;
case "Thu": $blank = 5; break;
case "Fri": $blank = 6; break;

} ;

$days_in_month = cal_days_in_month(0, $month, $year) ; 
//Creating calendar / Création du calendrier
 echo "
<div id='calendar'>
<table border=1 width=294 >
<theader>
<tr><th colspan=7> $title $year </th></tr>
<tr>";
//Day ordering / Ordre des jours
$sql = "SELECT LEFT( translation, 1 ) FROM guild_param WHERE TYPE = 'day' ORDER BY value";
$list=mysql_query($sql);
while($result=mysql_fetch_row($list))
{ echo "<td class='center' width=42>".$result[0]."</td>" ; };
echo "
</tr>
</theader>
<tbody>";
//Day in week count / Compteur des jours de la semaine
$day_count = 1; echo "<tr>";
//Blank creation / Création des cases vides
while ( $blank > 0 ) { echo "<td></td>"; $blank = $blank-1;  $day_count++; }  
$day_num = 1;
//Count of days in month / Compteur des jours du mois
while ( $day_num <= $days_in_month ) 
{ 
//Retrieving day / Récupération du jour
$computed_date = strtotime($year."-".$month."-".$day_num);
$computed_day = date( 'D', $computed_date); 
//Day number correction / Correction des numéros de jours
switch($computed_day) {
case "Sat": $week_corrector = 2; break; 
case "Sun": $week_corrector = 2; break;
default : $week_corrector = 0; 
} ;
$pirate_day = ($day_num + $week_corrector);
$pirate_date = strtotime($year."-".$month."-".$pirate_day);
$computed_day = date( 'N', $computed_date);
$computed_week = date( 'W', $pirate_date);

//Week creation / Création des semaines
//Coming weeks / Semaines suivantes
//Retrieving Events / Récupération des évènements
if ( $computed_week >= $current_week ){ 
$sqlr="SELECT r.raid_event_ID, r.map, r.color, p.complement
FROM guild_raid_event AS r 
INNER JOIN guild_param AS p ON p.text_ID=DATE_FORMAT(r.dateRaid,'%W')
WHERE p.complement='$computed_day'
AND DATE_FORMAT(r.dateRaid,'%e')=$day_num";
$listr=mysql_query($sqlr); 
if( mysql_num_rows($listr)>0)
{ while( $resultr=mysql_fetch_row($listr)) 
{ echo "<td class='center' style='background-color:".$resultr[2].";color:#FFFFFF;";
if( $current_month == $month && $current_day == $day_num){echo "text-decoration:underline;border:solid 3px #606060";};
echo"'>
<a class='calendar' onclick=\"$('#event').load('resources/php/BO_Div_Event.php?id=".$resultr[0]."&date=$computed_date');$('#event').show();\" href='#'>".$day_num."</a></td>"; };}
else {echo "<td class='center' ";
if( $current_month == $month && $current_day == $day_num){echo "style='border:solid 2px #8c1922;'";};
echo "
><a style='text-decoration:none;color:#000000;' onclick=\"$('#event').load('resources/php/BO_Div_Event.php?id=0&date=$computed_date');$('#event').show();\" href='#'>".$day_num."</a></td>"; };
}
//Day without event / Jour sans évènement
else {echo "<td class='center' >".$day_num."</td>"; };
$day_num++; $day_count++;
//End of week / Fin de semaine
if ($day_count > 7) { echo "</tr><tr>"; $day_count = 1; }
}
//Blank creation / Création des cases vides
 while ( $day_count >1 && $day_count <=7 ) {  echo "<td> </td>";  $day_count++;  } 

//End of calendat, navigation / Fin du calendrier, navigation
echo "</tr>
</tbody>
<tfooter>
<tr class='footer'>
<td class='center' ><a class='menu' onclick=\"$('#result').load('resources/php/BO_Div_Calendar.php?date=".$prev."');$('#result').show();\" href='#'>Pr&eacute;c.</a></td>
<td class='center' colspan=5><a class='menu' onclick=\"$('#result').load('resources/php/BO_Div_Calendar.php?date=".$year."-".$current_month."-01');$('#result').show();\" href='#'>Mois en cours</a></td>
<td class='center'><a class='menu' onclick=\"$('#result').load('resources/php/BO_Div_Calendar.php?date=".$next."');$('#result').show();\" href='#'>Suiv.</a></td>
</tr>
</tfooter>
</table></div>
";
?>