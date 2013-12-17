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

echo "
<div class='Menu'>
  <div class='LogIn'>
  <h4>Enregistrer vous !</h4>
  <br />
  <p>Ce contenu n'est accessible qu'aux membres de la guilde. Enregistrez-vous et attendez qu'un administrateur valide votre compte pour pouvoir y acc&eacute;der.</p>
  </div>
</div>

<div class='Page'>
  <div class='Core'>
  <h2>D&eacute;j&agrave; membre de la guilde ? <br /> Log In !</h2>
  <form action='../ucp.php' accept-charset='UTF-8' method='post'>
  <table>
  <tr><td>Login : </td><td><input type='text' name='username'></td></tr>
  <tr><td>Mot de passe : </td><td><input type='password' name='password'></td></tr>
  <tr><td>Connexion automatique : </td><td><input type='checkbox' name='autologin' /><input name='redirect' value='index.php' type='hidden'></td></tr>
  <tr><td></td><td><input type='submit' value='Connexion' name='login'> </td></tr>
  </table>
  </form>
  <br />
  <h3>Vous voulez nous rejoindre ?</h3>
  <p><a class='menu' href='../ucp.php?mode=register'>S'enregistrer</a></p>
  </div>
</div>

</div>
</body></html>";

?>