<?php 
$GLOBALS['EnDevLocal']=stristr($_SERVER["HTTP_HOST"], 'localhost')!=false;

if ($GLOBALS['EnDevLocal']){
  $GLOBALS['urlPourHtAccess']="localhost/taraspeervi/";
  $GLOBALS['urlSite'] ="http://".$urlPourHtAccess;
  $GLOBALS['repsite']="speervi/";
}else{   
  $GLOBALS['urlPourHtAccess']="tarabusk.net/taraspeervi";
  $GLOBALS['urlSite']="http://".$urlPourHtAccess;
  $GLOBALS['repsite']="speervi/";
}
?>