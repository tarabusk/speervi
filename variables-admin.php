<?php
$titre_site="Speervi";

$GLOBALS['EnDevLocal']=stristr ($_SERVER["HTTP_HOST"], 'localhost')!=false;
  
$path = preg_replace("#" . $_SERVER["DOCUMENT_ROOT"] . "#", "/", preg_replace('/\\\\/', '/', dirname(__FILE__))) . '/';
$path = preg_replace("#//#", "/", $path); // Vieille version d'Apache
$CheminRacine = $path ; 
$CheminSite ='/';
 
(isset ($_REQUEST["page"]))?$page = $_REQUEST["page"]:$page ='';


if ($GLOBALS['EnDevLocal'])
  $id_connec=$_SERVER["REMOTE_USER"];
else
  $id_connec=$_SERVER["REDIRECT_REMOTE_USER"];
  
if($id_connec=='tarabusk'){
  $GLOBALS['id-connec']=0;
}else {
  $GLOBALS['id-connec']=1;
}

if (isset($this))$action_admin=$this->action_admin;else $action_admin='Administration du site';

?>