<?php   require_once('../../classes/form.class.php'); 
require_once('../../fonctions_php.php'); 

?>

<script type="text/javascript">
<!--
/*
function champsok() {
	//check si TITRE renseigné
	if (document.formulaire_envoi_fichier.titre.value == 0) {
		alert("<?php echo 'Vous devez entrer un titre' ?>");
		return false;
	}	
	
	if (document.formulaire_envoi_fichier.titreLien.value == 0) {
		alert("<?php echo 'Vous devez entrer un titre pour le lien vers cette page' ?>");
		return false;
	}	
	if (document.formulaire_envoi_fichier.title.value == 0) {
		alert("<?php echo 'Vous devez entrer un titre pour le title de la page' ?>");
		return false;
	}	
	
	//check si titre ONLINE checké
	if (!document.formulaire_envoi_fichier.online.checked) {
		return confirm("<?php echo 'Cette info ne sera pas mise en ligne.\n Si c\'est une erreur, annulez et cochez la case Publié'?>");
	}
	
	return true;
}
//-->
*/
</script>
<h2 id="titre_formulaire"><?php echo $this->action_admin ?></h2>
<?php if ($this->page != 0 && !$this->article->est_mere) { ?>
<a href="<?php echo '../../'.$this->article->zz_template.'?page='.$this->article->id;?>" target="_blank"> &rarr; Visualiser la page </a>
<?php } ?>
<form enctype="multipart/form-data" name="formulaire_envoi_fichier" id="formulaire_envoi_fichier" class="article_form" method="post" action="" onsubmit="return champsok()">
    <div id="publier">	
		<?php
		    if ($GLOBALS['id-connec']<2){    
				echo Form::checkbox('online', ($this->page == '0') || ($this->article->online == '1'), 'publier').'<br/>'; 
				echo Form::text('ordre', $this->ordrereel, 'ordre', '', 'largeur_petit').'<br/>';
				echo Form::checkbox('home_page', ($this->article->home_page == '1'), 'Page d\'accueil').'<br/>';
				
			}else{
			   echo Form::hidden('online', ($this->page == '0') || ($this->article->online == '1'), 'online') ;
			   echo Form::hidden('home_page', ($this->article->home_page == '1'), 'home_page') ;
			   echo Form::hidden('ordre',  $this->ordrereel, 'ordre') ;
			}
	     ?>
	</div>
	<?php echo Form::hidden('action', 'save', 'action') ?>
	<?php echo Form::hidden('id', $this->article->id) ?>
	
	
		
	<div style="clear:both"> </div>
	<?php 
	  echo Form::text('titre_menu', $this->article->titre_menu, 'Titre du menu').'<br/>';	  
	  if ($GLOBALS['id-connec']<2) {
	    echo 'Dans menu principal  '.Form::radio('menu_principal', array (1=>'oui', 0=>'Non'), $this->article->menu_principal).'<br/>';
	    echo 'Est un menu père  '.Form::radio('est_mere', array (1=>'oui', 0=>'Non'), $this->article->est_mere).'<br/>';
	  }
	  else{  
	    echo Form::hidden('menu_principal',  $this->article->menu_principal, 'menu_principal') ;
	    echo Form::hidden('est_mere',  $this->article->est_mere, 'est_mere') ;
		}
	  
	  echo '<div id="page_reelle">';
	  if ($GLOBALS['id-connec']<2) {echo Form::select('id_page_mere', $this->pages, $this->pagechoisie,'Menu père').'<br/>'; }
	  else {echo Form::hidden('id_page_mere',  $this->pagechoisie, 'id_page_mere') ;}
	  echo Form::text('titre_page', $this->article->titre_page, 'Titre de la page');
	  echo Form::texteditor('texte', $this->article->texte, 'Contenu de la page').'<br/>';	
	  
  	  if ($GLOBALS['id-connec']<2){	 
	    echo Form::text('balise_title', $this->article->balise_title, 'balise title').'<br/>';
	    echo Form::text('balise_description', $this->article->balise_description, 'balise description').'<br/>'; 
		
	    echo Form::select('zz_template', $this->templates, $this->templatechoisi,'Fichier template').'<br/>';	
	    echo Form::text('zz_url', $this->article->zz_url, 'URL lien (lettres et \'-\')');	
	  }else{
	    echo Form::hidden('balise_title', $this->article->balise_title, 'balise title').'<br/>';
	    echo Form::hidden('balise_description', $this->article->balise_description, 'balise description').'<br/>';
    	echo Form::hidden('zz_template', $this->templatechoisi, 'zz_template') ;
		echo Form::hidden('zz_url', $this->article->zz_url, 'zz_url') ;
	  }
	  echo '</div>';
	  echo Form::ValiderEtSupprimer($this->page != 0);
	?>
	
	
</form>
<script>  	
	$(function() {
	   
		$("#est_mere_0").click(function() {  //pasmenu pere
         $("#page_reelle").css('display','block');
		
        });
 
	    $("#est_mere_1").click(function() {// menu pere
           $("#page_reelle").css('display','none');
        });
		
		if($("#est_mere_1").attr('checked')){
	  
		 $("#page_reelle").css('display','none');
	   }
        
	});
</script>
