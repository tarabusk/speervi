<?php
session_start();
require_once(dirname(__FILE__)."/../connexion-sql.php");
include_once (dirname(__FILE__)."/variables-admin.php");
include_once (dirname(__FILE__)."/../fonctions_mysql.php");
include_once (dirname(__FILE__)."/../fonctions_php.php");

?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $action_admin; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta http-equiv="X-UA-Compatible" content="chrome=1" />
	<link rel="stylesheet/less" type="text/css" href="<?php echo $CheminRacine;?>admin.less"/>
	<link rel='stylesheet' type='text/css' href='<?php echo $CheminRacine;?>../scripts/timepicker/jquery.ui.timepicker.css' />
	<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
</head>

<body>
   <div id="content">
	<div id="header">			
		<div class="onglet_menu">
			<a  href="<?php echo $CheminRacine;?>planning/index.php" alt="">&bull;&nbsp;&bull;&nbsp;Planning des rappels&nbsp; &bull;&nbsp; &bull;<?php// echo $titre_site;?></a>
		</div>
		<div class="onglet_menu">
			<a id="acces_site" href="<?php echo $CheminRacine;?>" alt="">&bull;&nbsp;&bull;&nbsp;&nbsp;Liste des sociétés &nbsp;<?php// echo $titre_site;?></a>
		</div>
		<a id="titre_header" href="<?php echo $CheminRacine;?>" alt=""> Gestion Téléprospection </a>	
        <div id="fond_acces_faq">		
		  <?php 
		    $idconnec=$_SERVER["REDIRECT_REMOTE_USER"];		
			 if ($idconnec=='test') echo 'Connexion version DEMO'; else echo $idconnec;
		  ?>
		  <div style="clear:both;"></div>
		 </div>			
	</div>	