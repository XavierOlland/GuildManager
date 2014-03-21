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

$sql="SELECT CONCAT(LEFT(entity,1),'_',variable_name) AS name, $local 
FROM ".$gm_prefix."dictionary 
WHERE entity IN ( 'table' , 'generic' )";
$result=mysqli_query($con,$sql);
$lng = array();
while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) { $lng[$row['name']] = $row[$local]; };

$page = str_ireplace('.php','',basename($_SERVER['PHP_SELF']) );
$sql="SELECT CONCAT(LEFT(entity,1),'_',variable_name) AS name, $local 
FROM ".$gm_prefix."dictionary 
WHERE entity='page' AND entity_name='$page'";
$result=mysqli_query($con,$sql);
while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) { $lng[$row['name']] = $row[$local]; };
?>