<?php
  $serveur     = "localhost";
  $utilisateur = "root";
  $motDePasse  = "";
  $base        = "speervi"; 

  mysql_connect($serveur, $utilisateur, $motDePasse);
<<<<<<< HEAD
  mysql_select_db($base) or die("Base de données inactive.". ini_get("mysql.default_host") );
?>
=======
  mysql_select_db($base) or die("Base de donnÃ©es inactive.". ini_get("mysql.default_host") );
?>
>>>>>>> origin/master
