<?php
/*  Guild Manager v1.0.4
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

echo "<div class='LogInBO'>
				<h5>".$lng[g__menu]."</h5>
				<form name='module' id='module' method='POST' action=''>
				<table>
				<tr><th>".$lng[g__module]."</th><th>".$lng[g__act]."</th><th>".$lng[g__order]."</th></tr>";
				$sql="SELECT a.module_ID, a.description, a.page, a.user, a.rank,
				CASE WHEN active=1 THEN 'checked' ELSE '' END AS checked
				FROM ".$gm_prefix."module AS a  
				ORDER BY a.rank" ;
				$list=mysql_query($sql);
        $count=mysql_num_rows($list);

				while($result=mysql_fetch_array($list))
				{ echo "<tr><td><a class='menu' href='".$result['page']; 
				if($result['user']==1){echo "?user=".htmlentities($user->data['user_id'],ENT_QUOTES,"UTF-8");};
				echo "'>".$result['description']."</a></td>
				<td><input type='hidden' name='id[]' value='".$result['module_ID']."' />
        <input type='checkbox' name='module".$result['module_ID']."' value='1' ".$result['checked']."/></td>
        <td><input style='width:20px;' type='text' name='rank".$result['module_ID']."' value='".$result['rank']."'/></td></tr>";};
				echo "
				<tr><td colspan='2'><input type='submit' name='module' value='".$lng[g__save]."'></td></tr>
				</table>
				</form><br />
				<a class='menu' href='../index.php'>".$lng[g__return]."</a>
</div>";
    

if (isset($_POST['module'])) {
	foreach($_POST['id'] as $id)
{
//ECHO "UPDATE ".$gm_prefix."module SET active=CASE WHEN '".$_POST['module'.$id]."' = '1' THEN 1 ELSE 0 END WHERE module_ID='".$id[$i]."'";

$sql1="UPDATE ".$gm_prefix."module SET active= '".$_POST['module'.$id]."', rank= '".$_POST['rank'.$id]."' WHERE module_ID='".$id[$i]."'";
$result1=mysql_query($sql1);

}
}
 if(isset($result1))
  {
   header("location:BO_Main.php");
 }
;
echo "
<script > 
$('#module').submit(function () {
 sendmodule();
 return false;
})</script>";
?>