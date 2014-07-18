<?php
require_once('../fichiers-recquis.php');
require_once('../../fonctions_php.php'); 
// Pages
class ControllerPage extends Controller {
	
	// Récupère la liste des articles à afficher
	function getList() {
		return getListe('page', 'ordre');
	}
	// Affichage
	function index() {
		
		$this->nom_sing='une page';
		$this->nom_plur='pages';
		if ($_REQUEST['page']){
		  $this->action_admin='Modifier '.$this->nom_sing;
		}else{
		  $this->action_admin='Ajouter '.$this->nom_sing;
		}
		
		$this->pages = array();
		$this->pages[0]='...';
		foreach (getListePagesMeres() as $LaPage) {
			$this->pages[$LaPage->id] = $LaPage->titre_menu;			
		}
		$this->templates=array();		
		 foreach(ParcourirLesTemplates() as $valeur)
		 {
		   $this->templates[$valeur] = $valeur;
		 }
		
		
		if ($_REQUEST['page']!=0){
		  $LaPage = getEnregistrement('page', $_REQUEST['page']);
		  $this->pagechoisie=$LaPage->id_page_mere;
		  
		  $LaPageMere = getEnregistrement('page',$LaPage->id_page_mere);
		  if( $LaPage->id_page_mere==0) 
	        $this->ordrereel= $LaPage->ordre/100;
		  else 
		    $this->ordrereel=($LaPage->ordre - $LaPageMere->ordre)/10;
		  $this->templatechoisi=$LaPage->zz_template;
		}else{
		  $this->templatechoisi='index.php';
		}
		return parent::index();
	}

	
	// Action effectuée lors de la validation de la liste
	 function saveList() { 
		
	}
	
	// Action effectuée lors de la validation du formulaire
	function save($transfert=false) {
	    if ($_REQUEST['est_mere']==1){
		  $titre_page='';
		  $texte=='';
		  $baliseTitle='';
		  $baliseDescription='';
		  $zz_template='';
		}else{
		  if($_REQUEST['titre_page']==''){$titre_page=$_REQUEST['titre_menu'];}else{$titre_page=$_REQUEST['titre_page'];};
		  $texte=$_REQUEST['texte'];
		  $baliseTitle=$_REQUEST['balise_title'];
		  $baliseDescription=$_REQUEST['balise_description'];
		  $zz_template=$_REQUEST['zz_template'];
		  if ($zz_template==''){
		    $zz_template='index.php';
		  }
		}
		
		if($_REQUEST['id_page_mere']>0){
		  $LaMere=getEnregistrement('page',$_REQUEST['id_page_mere']);
		  $ordremere=$LaMere->ordre;		 
		  $ordre=$ordremere+$_REQUEST['ordre']*10;	
          $menu_principal=	$LaMere->menu_principal;	  
		}else{
		  $ordre= $_REQUEST['ordre']*100;
		  $menu_principal=$_REQUEST['menu_principal'];
		}
		if ($_REQUEST['id']){
		  $LaPage_old=getEnregistrement('page', $_REQUEST['id']);
		  $old_zz_url= $LaPage_old->zz_url;
		  $old_home_page= $LaPage_old->home_page;
		 // echo $LaPage_old->titre_menu.'--'.$LaPage_old->titre_page.'--'.$LaPage_old->home_page.'--'.$LaPage_old->online.'<br/>';
		}else {
		  $old_zz_url= '';
		  $old_home_page='';
		}
		if ($_REQUEST['home_page']){
		  SupprimerToutesLesPagesDAccueil();
		}
		$champsUpdate = array(		                     
							  'titre_page' => $titre_page,												
						      'titre_menu' => $_REQUEST['titre_menu'],	
							  'est_mere' => $_REQUEST['est_mere'],					 							  
                              'id_page_mere' => $_REQUEST['id_page_mere'],								  
							  'texte' => $texte,	
                              'menu_principal' => $menu_principal,										  
							  'balise_title' => $baliseTitle,
							  'balise_description' => $baliseDescription,
							  'home_page' => $_REQUEST['home_page'],
							  'ordre' => $ordre,
							  'zz_url' => $_REQUEST['zz_url'],
							  'zz_template'=>$zz_template,
							  'online'=>$_REQUEST['online']
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
		 if ($old_zz_url != $_REQUEST['zz_url'] || $old_home_page!=isset($_REQUEST['home_page'])){	
		  GenereURLREWRITING();
	    }
		$this->redirect($id); 
	}
}
new ControllerPage('page');

?>
