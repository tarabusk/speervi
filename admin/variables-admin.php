<?php
$titre_site="Speervi";

$GLOBALS['EnDevLocal']=stristr ($_SERVER["HTTP_HOST"], 'localhost')!=false;
if ($GLOBALS['EnDevLocal']){
  $path = preg_replace("#" . $_SERVER["DOCUMENT_ROOT"] . "#", "/", preg_replace('/\\\\/', '/', dirname(__FILE__))) . '/';
  $path = preg_replace("#//#", "/", $path); // Vieille version d'Apache
  $CheminRacine = $path ; 
  $CheminSite ='/';
  $CheminRacineDirect = '/speervi';
 
}else{  
  $CheminSite ='http://tarabusk.net/taraspeervi';
  $CheminRacine = $CheminSite.'/admin/' ; 
  $CheminRacineDirect = '/';
 
}

(isset ($_REQUEST["page"]))?$page = $_REQUEST["page"]:$page ='';
$nom_rep = explode('/', $_SERVER['SCRIPT_NAME']);
$theme = $nom_rep[count($nom_rep)-2];

if ($GLOBALS['EnDevLocal'])
  $id_connec=$_SERVER["REMOTE_USER"];
else
  $id_connec=$_SERVER["REDIRECT_REMOTE_USER"];
  
if($id_connec=='tarabusk'){
  $GLOBALS['id-connec']=0;
}else if ($id_connec=='speeral'){
  $GLOBALS['id-connec']=1;
}else if ($id_connec=='test'){
  $GLOBALS['id-connec']=10;  
}else{
 $GLOBALS['id-connec']=2;  
}

if (isset($this))$action_admin=$this->action_admin;else $action_admin='Administration du site';

?>