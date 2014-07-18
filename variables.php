<?php
include ('variables-site.php');
//$etat = $_REQUEST["etat"];
isset($_REQUEST['bien'])?$id_bien=$_REQUEST['bien']:$id_bien=0;
if ($id_bien!=0){
  $id_page=IDPageSelonBien($id_bien);// Se met sur la menu "vente" ou "location"
}else{

 $id_page = isset($_REQUEST['page'])?$_REQUEST['page']:IDPageAccueil(); 
}
$nom_rep = explode('/', $_SERVER['SCRIPT_NAME']);
$theme = $nom_rep[count($nom_rep)-2];

$MailClient='tarabusk@gmail.com';
$NomDuSite='Téléprospection SPEERAL';
$MetaAuthor='<meta name="author" lang="fr" content="tarabusk.net"> ';
if(!isset($AjouterBaliseMeta)){$AjouterBaliseMeta=$MetaAuthor;}
else {$AjouterBaliseMeta.=$MetaAuthor;}

//Variables du formulaire
$nb_max=1000000000000000;
if (isset ($_REQUEST["location"])){
    	$_SESSION['location']=$_REQUEST["location"];		
    }else if (!isset ($_SESSION["location"])){	  
	  $_SESSION['location']        ='1';
	}
	
	//Type bien
	if (isset ($_REQUEST["id_type_bien"])){
    	$_SESSION['id_type_bien']=$_REQUEST["id_type_bien"];		
    }else if (!isset ($_SESSION["id_type_bien"])){	
	  $_SESSION['id_type_bien']        ='Tous';
	}
	
    //Prix Max
	if (isset ($_REQUEST["prix_max"])){
    	$_SESSION['prix_max']=$_REQUEST["prix_max"];		
    }else if (!isset ($_SESSION["prix_max"])){	
	  $_SESSION['prix_max']        ='';//$nb_max;
	}
	
	 //Prix Min
	if (isset ($_REQUEST["prix_min"])){
    	$_SESSION['prix_min']=$_REQUEST["prix_min"];		
    }else if (!isset ($_SESSION["prix_min"])){	
	  $_SESSION['prix_min']        ='';//0;
	}
	
	//LIEU
	if (isset ($_REQUEST["id_lieu"])){
    	$_SESSION['id_lieu']=$_REQUEST["id_lieu"];		
    }else if (!isset ($_SESSION["id_lieu"])){	
	  $_SESSION['id_lieu']        ='Toutes';
	}
	
	//Surface Max
	if (isset ($_REQUEST["surface_max"])){
    	$_SESSION['surface_max']=$_REQUEST["surface_max"];		
    }else if (!isset ($_SESSION["surface_max"])){	
	  $_SESSION['surface_max']        ='';//$nb_max;
	}
	
	 //Surface Min
	if (isset ($_REQUEST["surface_min"])){
    	$_SESSION['surface_min']=$_REQUEST["surface_min"];		
    }else if (!isset ($_SESSION["surface_min"])){	
	  $_SESSION['surface_min']        ='';//0;
	}
	
?>