<?php 
/******* REPLACE YOUR OWN URL BELOW *********/
$GLOBALS['urlSite'] ="http://localhost/speervi/";
/******* REPLACE YOUR OWN URL ABOVE  *********/


/******* REPLACE YOUR DATABASE PARAMETRES BELOW *********/
$serveur     = "localhost";
$utilisateur = "root";
$motDePasse  = "";
$base        = "speervi"; 
/******* REPLACE YOUR DATABASE PARAMETRES ABOVE *********/
/****** Check README to build your database *********/

/******* Nb max companies displayed on one page *********/
$GLOBALS['nbitemperpage']=15;


mysql_connect($serveur, $utilisateur, $motDePasse);
mysql_select_db($base) or die("Base de données inactive.". ini_get("mysql.default_host") );

$MetaAuthor='<meta name="author" lang="fr" content="tarabusk.net"> ';
if(!isset($AjouterBaliseMeta)){$AjouterBaliseMeta=$MetaAuthor;}
else {$AjouterBaliseMeta.=$MetaAuthor;}

$GLOBALS['EnDevLocal']=stristr($_SERVER["HTTP_HOST"], 'localhost')!=false;
  
?>