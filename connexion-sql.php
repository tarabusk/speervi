<?php
  $serveur     = "localhost";
  $utilisateur = "root";
  $motDePasse  = "";
  $base        = "speervi"; 

  mysql_connect($serveur, $utilisateur, $motDePasse);
  mysql_select_db($base) or die("Base de données inactive.". ini_get("mysql.default_host") );
?>

