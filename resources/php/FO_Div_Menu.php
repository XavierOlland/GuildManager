<?php
/*  Guild Manager v1.0.3
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
	
echo "<div class='LogIn'>
				<h5>".$lng[g__menu]."</h5>";
				$sql="SELECT d.$local AS module, m.page, m.user
				FROM ".$gm_prefix."module AS m
				LEFT JOIN ".$gm_prefix."dictionnary AS d ON d.table_ID=m.module_ID AND d.entity_name='module' 
				WHERE m.active=1 
				ORDER BY m.rank" ;
				$list=mysql_query($sql);
				while($result=mysql_fetch_array($list))
				{ echo "<a class='menu' href='".$result['page']; 
				if($result['user']==1){echo "?user=".htmlentities($user->data['user_id'],ENT_QUOTES,"UTF-8");};
				echo "'>".$result['module']."</a><br />";};
				echo "
				<br />";
//User permissions test / Test des permissions utilisateur
			if (in_array($user->data['group_id'],$cfg_groups_backoffice)){echo "<a class='menu' href='BO_Main.php'>".$lng[g__setting]."</a><br />";};
				echo "<a class='menu' href='../index.php'>".$lng[g__return]."</a>
</div>"
?>