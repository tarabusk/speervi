<?php 
session_start(); 
include_once ("variables-admin.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $action_admin; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta http-equiv="X-UA-Compatible" content="chrome=1" />
	<link rel="stylesheet/less" type="text/css" href="<?php echo $CheminRacine;?>admin.less"/>
	<link rel='stylesheet' type='text/css' href='<?php echo $CheminRacine;?>scripts/timepicker/jquery.ui.timepicker.css' />
	<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
	<link href='http://fonts.googleapis.com/css?family=Oswald:400,700,300' rel='stylesheet' type='text/css'>
</head>

<body>
   <div id="content">
	<div id="header">				
		 <?php $classSel = $GLOBALS['psel']==1?"onglet_sel":"";  ?>
		<div class="onglet_menu <?php echo $classSel; ?>">		   
			<a href="<?php echo $CheminRacine;?>list/" alt="">List of Companies</a>
		</div>
		 <?php $classSel = $GLOBALS['psel']==2?"onglet_sel":""; ?> 
		<div class="onglet_menu <?php echo $classSel; ?>">	   
			<a href="<?php echo $CheminRacine;?>planning/" alt="">Call Back</a>
		</div>
		<a id="titre_header" href="<?php echo $CheminRacine;?>" alt=""> Telephone selling management </a>	
        <div id="fond_acces_faq">		
		  <?php 
		    $idconnec=$_SERVER["REDIRECT_REMOTE_USER"];		
			 if ($idconnec=='test') echo 'Connexion version DEMO'; else echo $idconnec;
		  ?>
		  <div style="clear:both;"></div>
		 </div>			
	</div>	
