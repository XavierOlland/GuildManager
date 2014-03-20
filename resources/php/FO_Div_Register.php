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


echo "
<div id='Left'>
  <div id='Menu'>
  <h4>".$lng[g_FO_Div_Register_h4_1]."</h4>
  <br />
  <p>".$lng[g_FO_Div_Register_p_1]."</p>
  </div>
</div>

<div id='Page'>
  <div id='Core'>
  <h2>".$lng[g_FO_Div_Register_h2_1]."</h2>
  <form action='../ucp.php' accept-charset='UTF-8' method='post'>
  <table>
  <tr><td>".$lng[g_FO_Div_Register_td_1]." : </td><td><input type='text' name='username'></td></tr>
  <tr><td>".$lng[g_FO_Div_Register_td_2]." : </td><td><input type='password' name='password'></td></tr>
  <tr><td>".$lng[g_FO_Div_Register_td_3]." : </td><td><input type='checkbox' name='autologin' /><input name='redirect' value='index.php' type='hidden'></td></tr>
  <tr><td></td><td><input type='submit' value='".$lng[g_FO_Div_Register_td_4]."' name='login'> </td></tr>
  </table>
  </form>
  <br />
  <h3>".$lng[g_FO_Div_Register_h3_1]."</h3>
  <p><a id='Menu' href='../ucp.php?mode=register'>".$lng[g_FO_Div_Register_p_2]."</a></p>
  </div>
</div>

</div>
</body></html>";

?>