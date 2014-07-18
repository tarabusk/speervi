<?php
include ('variables-site.php');

$MailClient='tarabusk@gmail.com';
$NomDuSite='Téléprospection ';
$MetaAuthor='<meta name="author" lang="fr" content="tarabusk.net"> ';
if(!isset($AjouterBaliseMeta)){$AjouterBaliseMeta=$MetaAuthor;}
else {$AjouterBaliseMeta.=$MetaAuthor;}

?>