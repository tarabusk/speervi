<?php  require_once('../classes/form.class.php');  

?>
<a class="ajouter_liste" href="<?php echo htmlspecialchars($this->url . '&action=add') ?>"><?php echo 'Ajouter une société'; ?></a>
<form name="formulaire_recherche" id="formulaire_recherche" method="post" action="<?php echo $this->url; ?>" onsubmit="return LancerRecherche()">
    <?php
	$refno        = '';
	$refchoisie   = '';
	$villechoisie = '';
   // echo 'session : '.$_SESSION['refville']. ' - requete : '.$_REQUEST['refville'];
	if (isset($_SESSION["ref"]) || isset($_SESSION["refville"])){
	  $refchoisie=$_SESSION["ref"];
	  $refno= '<br/> &rarr; <a style="font-style:italic;" href="'.$this->url.'&ref=&refville=&npage="> Retrouver toutes les sociétés </a>';
	  $villechoisie=$_SESSION["refville"];
	}
	 echo  '&nbsp;&nbsp;&nbsp;'.Form::text('recherche_ref', $refchoisie, '&rarr; Rechercher par nom / NAF','','').'<br/>';
	 echo '&nbsp;&nbsp;&nbsp;'.Form::text('recherche_ville', $villechoisie, '&rarr; Rechercher par ville','','') .Form::btn_Valider();
	 echo $refno;
    ?>
</form>

<form name="formulaire_liste" method="post" action="<?php echo htmlspecialchars($this->url . '&action=list_apply') ?>">
	<table class="liste_articles">
		<thead>
			<tr>			
				<?php if($GLOBALS['id-connec']<1){ ?>		
				<th width="20"><?php echo 'ID' ?></th>
				
				<?php } ?>
				<th width="350"><?php echo 'Liste des '. $this->nom_plur; ?></th>	
<th width="20"><?php 'Sup.' ?></th>				
				
			</tr>
		</thead>
		<tbody>
		<?php ?>
			<?php foreach ($this->articles as $article): ?>			
			<?php $urlPage = $this->url . '&page=' . $article->id.'&npage='.$this->npage ; 
			if (isset($_REQUEST["ref"])) {$urlPage.='&ref='.$_REQUEST["ref"].'&refville='.$_REQUEST["refville"];}?>
			<tr <?php echo ($this->page == $article->id)? ' class="active"' : (!$article->online? ' class="offline"' : '') ?>>
				<?php if($GLOBALS['id-connec']<1){ ?>			 			
				  <td class="id_article"><?php echo $article->id ?></td>
				<?php } ?>		        
				<td class="titre_article"><a href="<?php echo htmlspecialchars($urlPage) ?>"><?php echo AfficherTemperature($article->temperature).$article->nom; ?></a></td>	
                <td class="action_article"><?php echo Form::del_button($urlPage . '&action=del') ?></td>				
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

</form>
<?php echo $this->pagination; ?>
<?php include ('import.php') ?>

<script type="text/javascript">
<!--
function LancerRecherche() {	   
    document.forms['formulaire_recherche'].action = document.forms['formulaire_recherche'].action+'&ref='+document.formulaire_recherche.recherche_ref.value+'&refville='+document.formulaire_recherche.recherche_ville.value ;	
	return true;
}
function ValiderChoixTypeBien(idtype_bien) {	  
    document.forms['formulaire_recherche_type'].action = document.forms['formulaire_recherche_type'].action+'&rech_type='+idtype_bien;
	document.forms['formulaire_recherche_type'].submit();
}
//-->
</script>

