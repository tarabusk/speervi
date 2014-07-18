<?php
include ('variables-site.php');
$nom_rep = explode('/', $_SERVER['SCRIPT_NAME']);
$theme = $nom_rep[count($nom_rep)-2];
$MailClient='tarabusk@gmail.com';
$NomDuSite='Téléprospection ';
$MetaAuthor='<meta name="author" lang="fr" content="tarabusk.net"> ';
if(!isset($AjouterBaliseMeta)){$AjouterBaliseMeta=$MetaAuthor;}
else {$AjouterBaliseMeta.=$MetaAuthor;}

?>