<?php
require_once('mysql.class.php');
// Classe générique des actions effectuées sur une page d'admin
  abstract class Controller {
  // Constructeur de la classe
  function __construct($table, $showForm=true) {
    $this->table = $table;
    $this->showForm = $showForm; // Pour afficher toujours le formulaire
    $this->page = $_REQUEST['page'];
	$this->npage = $_REQUEST['npage'];
    if ($this->showForm && !isset($this->page)) $this->page = 0; // Affiche toujours le formulaire
	$this->url = 'index.php?';
    $this->imagePath = '../../';		
    $this->processAction($_REQUEST['action'], $_REQUEST['typeaction']);	
  }

  // Exécute l'action souhaitée
  protected function processAction($action, $typeaction) {
  
    switch ($action) {   
      case 'add':
        $this->add($typeaction);
        break;
       
      case 'del':
        $this->delete();
        break;
      
      case 'save':
        $this->save();
        break;
     
      
      default: 	$this->index(); 
    }
  }

  // Renvoie une liste d'articles
  abstract function getList();

  // Renvoie l'article courant
  function getArticle() {
    return Mysql::get_object_from_id($this->table, $this->page);
  }

  // Redirige sur la page par défaut
  function redirect($page='', $npage='',$typeaction='') { 
    $paramStr = $page? '&page=' . $page : '';
	if ($npage){$paramStr .= '&npage='.$npage;}
    if ($typeaction){$paramStr .= '&typeaction='.$typeaction;}
    header('Location: ' . $this->url . $paramStr);
  }

  // Affiche la page d'admin
  function index() { 
  
    // Liste des articles
    $this->articles = $this->getList();
    
    // Affichage d'un article particulier
    if ($this->page != 0) {
      $this->article = $this->getArticle();
         
    }
	include(dirname(__FILE__) . '/../template.html.php');
  }

  // Ajoute un article
  function add($typeaction) {
    if ($typeaction){
      $this->url .= '&page=0&typeaction='.$typeaction;
    }else{
      $this->url .= '&page=0';   
    }
    $this->redirect();
  }

  // Supprime un article
  function delete() {
    Mysql::delete($this->table, $this->page);
    $this->redirect();
  }

  // Duplique un article
  function duplicate() {
    $this->index();
  }

  // Sauve un article
  function save($transfert=false) {
    $this->redirect();
  }
  
  // Sauve les modifications apportées à la liste
  function saveList() {
    $this->redirect();
  }
}
?>
