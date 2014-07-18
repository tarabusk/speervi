<?php
require('../fichiers-recquis.php');
require('../../fonctions_php.php');
$GLOBALS['psel']="2";
// Plannings
class ControllerSociete extends Controller {
	
	// R�cup�re la liste des Plannings � afficher
	function getList() {
	  
	}
	// Affichage
	function index() { 	  
		return parent::index();
	}
    function delete() {		  
	  SurSuppressionSociete($this->page);	 
      return parent::delete(true);   
	}
	
	// Action effectu�e lors de la validation de la liste
	function saveList() {
		
	}
	
	// Action effectu�e lors de la validation du formulaire
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
	
	// R�cup�re la liste des Echanges � afficher
	function getList() {
	         return getListeEchanges(); 		
	}
	// Affichage
	function index() { 
	   $this->EstLocation=1;
	   
	    $this->nom_sing='une soci�t�';
		$this->nom_plur='soci�t�s';
		
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
	
	// Action effectu�e lors de la validation de la liste
	function saveList() {
		
	}
	
	// Action effectu�e lors de la validation du formulaire
	function save() {}
}

switch ($TableAction){
  case 1  : new ControllerSociete('societe');break;
  case 2  : new ControllerEchange('echange');break;
  default : new ControllerSociete('societe');
  }

?>
