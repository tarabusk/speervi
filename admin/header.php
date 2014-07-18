<?php
session_start();
require_once(dirname(__FILE__)."/../connexion-sql.php");
include_once (dirname(__FILE__)."/variables-admin.php");
include_once (dirname(__FILE__)."/../fonctions_mysql.php");
include_once (dirname(__FILE__)."/../fonctions_php.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr" dir="ltr">
<head>

<title><?php echo $action_admin; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="X-UA-Compatible" content="chrome=1" />
<link rel="stylesheet/less" type="text/css" href="<?php echo $CheminRacine;?>admin.less"/>

<script src="<?php echo $CheminRacine;?>../scripts/less-1.3.0.min.js" type="text/javascript"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo $CheminRacine;?>../scripts/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="<?php echo $CheminRacine;?>../scripts/jquery.qtip-1.0.0-rc3.min.js"></script>
<script type="text/javascript" src="<?php echo $CheminRacine;?>admin.js"></script> 

<link rel='stylesheet' type='text/css' href='<?php echo $CheminRacine;?>../scripts/timepicker/jquery.ui.timepicker.css' />
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
</head>

<body>
   <div id="content">
	<div id="header">	
		<div id="fond_acces_faq">
		
		  <?php 
		    $idconnec=$_SERVER["REDIRECT_REMOTE_USER"];		
			 if ($idconnec=='test') echo 'Connexion version DEMO'; else echo $idconnec;
		  ?>
		  <div style="clear:both;"></div>
		 </div>	
		<a id="acces_site" href="<?php echo $CheminRacine;?>planning/index.php" alt="">&bull;&nbsp;&bull;&nbsp;Planning des rappels&nbsp; &bull;&nbsp; &bull;<?php// echo $titre_site;?></a>
		<a id="acces_site" href="<?php echo $CheminRacine;?>" alt="">&bull;&nbsp;&bull;&nbsp;&nbsp;Liste des sociétés &nbsp;<?php// echo $titre_site;?></a>
		<a id="titre_header" href="<?php echo $CheminRacine;?>" alt=""> Gestion Téléprospection </a>		
	</div>	
