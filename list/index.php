<?php
session_start();
$GLOBALS['psel']="1";
require('../fichiers-recquis.php');
require('../fonctions_php.php');
$TableAction =  $_REQUEST['typeaction'];
// Societes
class ControllerSociete extends Controller {
	
	function getList() {
	   if ($_FILES["userfile"]["name"]) $this->result_import=ImporterSocietes();
       $nbitemparpage= 250;
	   if (isset($_REQUEST['ref'])){
	    $_SESSION['ref']=$_REQUEST['ref'];  	  
	   }
	   if (isset($_REQUEST['refville'])){
	    $_SESSION['refville']=$_REQUEST['refville'];	  
	   }
	   if (isset($_REQUEST['npage'])){
	    $_SESSION['npage']=$_REQUEST['npage'];	  
	   }
       if (($_SESSION['ref']!='') || ($_SESSION['refville']!='')){         
          $this->npage=$_SESSION['npage'];			  
		  $this->pagination=AfficherPaginationRecherche($_SESSION['npage'], $nbitemparpage, $_SESSION['ref'], $_SESSION['refville']);         		
		  return getListeSocietesRechercheNom($_SESSION['ref'], $_SESSION['refville'],$_SESSION['npage'], $nbitemparpage);} 
        else if ($_SESSION['npage']){
          $this->pagination=AfficherPagination($_SESSION['npage'], $nbitemparpage);
          $this->npage=$_SESSION['npage'];			
          return getListeSocietesParPage($_SESSION['npage'], $nbitemparpage);
        }else 	{
          $this->pagination=AfficherPagination($_SESSION['npage'], $nbitemparpage);
          $this->npage=$_SESSION['npage'];			
		  return getListeSocietesParPage(1,$nbitemparpage);
		  }
	}
	// Affichage
	function index() { 
	  
	   
	    $this->nom_sing='société';
		$this->nom_plur='sociétés';
		
		if ($_REQUEST['page']){
		  $this->action_admin='Modifier une '.$this->nom_sing;
		}else{
		  $this->action_admin='Créer une '.$this->nom_sing;
		}		
		return parent::index();
	}
    function delete() {		  
	  SurSuppressionSociete($this->page);	 
      return parent::delete(true);   
	}
	
	// Action effectuée lors de la validation de la liste
	function saveList() {
		
	}
	
	// Action effectuée lors de la validation du formulaire
	function save() {	
	   	
		$champsUpdate = array('nom' => $_REQUEST['nom'],												
						      'adresse' => $_REQUEST['adresse'],	
							  'cp' => $_REQUEST['cp'],	
							  'ville' => $_REQUEST['ville'],
							  'telephone' => $_REQUEST['telephone'],
							  'email' => $_REQUEST['email'],
							  'site_web' => $_REQUEST['site_web'],
							  'nom_contact' => $_REQUEST['nom_contact'],
							  'prenom_contact' => $_REQUEST['prenom_contact'],
							  'tel_contact' => $_REQUEST['tel_contact'],
							  'portable_contact' => $_REQUEST['portable_contact'],
							  'email_contact' => $_REQUEST['email_contact'],
							  'temperature' => $_REQUEST['temperature'],
							  'dirigeant' => $_REQUEST['dirigeant'],
							  'naf' => $_REQUEST['naf'],
							  'autre' => $_REQUEST['autre'],
								
							 );	
		$champsInsert = $champsUpdate;								 		
		$id = $_REQUEST['id'];
		if ($id) {			
			// Update
			Mysql::update($this->table, $champsUpdate, "WHERE `id` = '%d'", $id);
		}
		else {
			// Insert
			$id = Mysql::insert($this->table, $champsInsert);
			
		}		
		$this->redirect($id); // Rechargement de la page avec l'Bien courant
	}
	
}

class ControllerEchange extends Controller {
	
	// Récupère la liste des Echanges à afficher
	function getList() {
	         return getListeEchanges(); 		
	}
	// Affichage
	function index() { 
	   $this->EstLocation=1;
	   
	    $this->nom_sing='une société';
		$this->nom_plur='sociétés';
		
		if ($_REQUEST['page']){
		  $this->action_admin='Modifier une '.$this->nom_sing;
		}else{
		  $this->action_admin='Ajouter une '.$this->nom_sing;
		}
	   
		return parent::index();
	}
    function delete() {		  
	  SurSuppressionEchange($this->page);	 
      return parent::delete(true);   
	}
	
	// Action effectuée lors de la validation de la liste
	function saveList() {
		
	}
	
	// Action effectuée lors de la validation du formulaire
	function save() {}
}

switch ($TableAction){
  case 1  : new ControllerSociete('societe');break;
  case 2  : new ControllerEchange('echange');break;
  default : new ControllerSociete('societe');
  }

?>
