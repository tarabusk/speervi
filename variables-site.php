<?php 
$MetaAuthor='<meta name="author" lang="fr" content="tarabusk.net"> ';
if(!isset($AjouterBaliseMeta)){$AjouterBaliseMeta=$MetaAuthor;}
else {$AjouterBaliseMeta.=$MetaAuthor;}

$GLOBALS['EnDevLocal']=stristr($_SERVER["HTTP_HOST"], 'localhost')!=false;
$GLOBALS['urlSite'] ="http://localhost/speervi/";

$serveur     = "localhost";
$utilisateur = "root";
$motDePasse  = "";
$base        = "speervi"; 

mysql_connect($serveur, $utilisateur, $motDePasse);
mysql_select_db($base) or die("Base de données inactive.". ini_get("mysql.default_host") );
  
?>