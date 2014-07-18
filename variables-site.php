<?php 
$MetaAuthor='<meta name="author" lang="fr" content="tarabusk.net"> ';
if(!isset($AjouterBaliseMeta)){$AjouterBaliseMeta=$MetaAuthor;}
else {$AjouterBaliseMeta.=$MetaAuthor;}

$GLOBALS['EnDevLocal']=stristr($_SERVER["HTTP_HOST"], 'localhost')!=false;
$GLOBALS['urlSite'] ="http://localhost/speervi/";
?>