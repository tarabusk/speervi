<?php   
require_once('../classes/form.class.php');
require_once('../fonctions_php.php');
if (isset($_REQUEST["rv"])){
  $id_rencontre=$_REQUEST["rv"];
  $LaRencontreSel = getEnregistrement('rencontre', $id_rencontre);
  $LaSocieteSel   = getEnregistrement('societe', $LaRencontreSel->id_societe);
}
if ($_REQUEST ['date_echange']){
	$date   = $_REQUEST ['date_echange'];
	$day    = substr($date,0,2);
	$month  = substr($date,3,2);
	$year   = substr($date,6,4);
	$hour   = substr($date,11,2);
	$minute = substr($date,14,2);
	$second = substr($date,17,2);
	$timestamp= mktime($hour,$minute,$second,$month,$day,$year);
	$dateSQL=date('Y-m-d H:i:s',$timestamp); 	 
	if ($_REQUEST ['id_echange'] == 0)
      AjouterUnEchange($this->article->id, $dateSQL, $_REQUEST ['commentaire_echange'], $_REQUEST ['type_echange']);
	else
	  ModifierLEchange($_REQUEST ['id_echange'], $this->article->id, $dateSQL, $_REQUEST ['commentaire_echange'], $_REQUEST ['type_echange']);
}
if ($_REQUEST ['date_rencontre']){
	$date   = $_REQUEST ['date_rencontre'];
	$day    = substr($date,0,2);
	$month  = substr($date,3,2);
	$year   = substr($date,6,4);
	$hour   = substr($date,11,2);
	$minute = substr($date,14,2);
	$second = substr($date,17,2);
	$timestamp= mktime($hour,$minute,$second,$month,$day,$year);
	$dateSQL=date('Y-m-d H:i:s',$timestamp); 	
    if ($_REQUEST ['id_rencontre'] == 0) 
	  AjouterUneRecontre($this->article->id, $dateSQL, $_REQUEST ['commentaire_rencontre'], $_REQUEST ['type_rencontre']);
	else 
	  ModifierLaRencontre($_REQUEST ['id_rencontre'], $this->article->id, $dateSQL, $_REQUEST ['commentaire_rencontre'], $_REQUEST ['type_rencontre']);
}
if ($_REQUEST ['id_rencontre_ok']){
  TransformerRencontreEnEchange($_REQUEST ['id_rencontre_ok']);
}

 ?>
 
<script type="text/javascript">
<!--
function champsok() {
	//check si TITRE renseigné
	if (document.formulaire_envoi_fichier.nom.value == 0) {
		alert("<?php echo 'Vous devez entrer un nom pour la societe' ?>");
		return false;
	}		
	if (editeur.getData()  == '') {
		alert("<?php echo 'Vous devez entrer une description' ?>");
		return false;
	}		
	return true;
}
function champsechangeok() {
 
	if (document.form_echange.date_echange.value == '') {return false}
	else return true;
}
function champsrencontreok() {
 
	if (document.form_echange.date_rencontre.value == '') {return false}
	else return true;
}
function champsrencontre_okok(){
  return true;
}
//-->
</script>



	<?php if ($this->page > 0){ ?>
	  <h1> <?php echo $this->article->nom; ?></h1>
	<hr>
	<h2 id="titre_encart_rencontre"> Rappels </h2>
	    <?php $LaDerniereRencontre=GetDernierRencontreSociete($this->article->id);
		     if ($LaDerniereRencontre){  
              echo '<div class="liste"> <div id="div_rappel"> Rappeler le : '.datefrFrancaiseAvecA ($LaDerniereRencontre->date_rencontre).' - '.$LaDerniereRencontre->commentaire.'</div></div>';
			  ?>
			  <div class="formulaire">
			  <form enctype="multipart/form-data" name="form_rencontre_ok" id="form_rencontre_ok" class="article_form" method="post" action="" onsubmit="return champsrencontre_okok()">
			    <?php echo Form::hidden('id_rencontre_ok', $LaDerniereRencontre->id);
				      echo Form::btn_valider('Rappel effectué!');
				?>
			  </form>
			  </div>
			  <?php
            }else{
              echo '<div class="liste"><div id="div_rappel"> Aucun rappel programmé </div></div>';
			  ?>
			    <div class="formulaire">
			    <div id="encart_rencontre">		         	
					<form enctype="multipart/form-data" name="form_rencontre" id="form_rencontre" class="article_form" method="post" action="" onsubmit="return champsrencontreok()">
					  Ajouter un rappel le : <input name="date_rencontre" id="date_rencontre" type="text" class="largeur_petit3"/>			  
					  <?php echo Form::hidden('type_rencontre', 'telephone'); ?> 
					 <br/><label for="commentaire_rencontre"> Commentaire </label><br/>
					 <textarea name="commentaire_rencontre" id="commentaire_rencontre" cols="105" rows="6"  class="largeur_moygrand"></textarea>
					 <?php 
					  echo Form::hidden('id_rencontre', 0);
					  echo Form::btn_valider('Ajouter un rappel');
					  ?>		
					  </form>
		        </div>
				</div>
		<?php
			  
            }		 ?>
	   
			<div style="clear:both"></div>
	

	
    <?php }else{ ?>
	 <h1> &larr; Choose one of the call back that has to be done </h1>
	   <?php } ?>
		<?php if ($this->page > 0){ ?>
		<hr><div  id="encart_echange"><div title="Vider les champs pour ajouter un nouvel échange" id="ajouter_echange"> + </div>
		<h2 id="titre_encart_echange"> Echanges </h2>
		
		
		   <div class="liste">
			<ul>
			<?php	
			$ni=0;
			foreach(GetListesEchangesSociete ($this->article->id) AS $LEchange){
			  $ni++;
			  echo '<li  class="echange_li" id="echange_li_'.$LEchange->id.'"><span class="date_echange"> '.datefrFrancaiseAvecA ($LEchange->date_echange).' </span> - '.$LEchange->commentaire.'  <div class="supprimer_echange" id="echange_'.$LEchange->id.'"  title="Supprimer l\'échange"> x </div> </li>';
			}
			if($ni==0) echo 'Pas encore d\'échange avec cette société';
			?>
			</ul>
			</div>
			<div class="formulaire">			
			<form enctype="multipart/form-data" name="form_echange" id="form_echange" class="article_form" method="post" action="" onsubmit="return champsechangeok()">
			  Date : <input name="date_echange" id="date_echange" type="text" class="largeur_petit3"/><br/>
			  <?php echo Form::hidden('type_echange', 'telephone'); ?>
			  <!--<input type="radio" name="type_echange" value="telephone" checked="checked"> Téléphonique &nbsp;&nbsp;
			  <input type="radio" name="type_echange" value="physique" > Rendez-vous physique &nbsp;&nbsp;
			  <input type="radio" name="type_echange" value="email"> Email <br/>-->
			  <?php echo Form::textarea('commentaire_echange', '','Commentaire','','largeur_moygrand');
			  echo Form::hidden('id_echange', 0);
			  echo Form::btn_valider('Ajouter un nouvel échange');
			  ?>
			</form>
			</div>
			<div style="clear:both"></div>
		 </div>
	<?php } ?>
	<hr>
	<?php if ($this->page > 0){ ?>
    <h2 id="titre_encart_societe" > Société </h2>
    <div id="encart_societe">
	 <form enctype="multipart/form-data" name="formulaire_envoi_fichier" id="formulaire_envoi_fichier" class="article_form" method="post" action="" onsubmit="return champsok()">
	   <div class="liste">

		<?php echo Form::hidden('action', 'save', 'action') ?>
		<?php echo Form::hidden('id', $this->article->id) ?>	
		<?php 		
		echo Form::text('nom', $this->article->nom, 'Nom','','largeur_grand').'<br/>' ;
		?>
		<?php ($this->article->temperature=='indetermine')?$check='checked="checked"':$check=''; ?>
		 <input type="radio" name="temperature" value="indetermine"  <?php echo $check; ?>> Indeterminé &nbsp;&nbsp;
		 <?php ($this->article->temperature=='chaud')?$check='checked="checked"':$check=''; ?>
		 <input type="radio" name="temperature" value="chaud" <?php echo $check; ?>> Chaud &nbsp;&nbsp;
		 <?php ($this->article->temperature=='tiede')?$check='checked="checked"':$check=''; ?>
		 <input type="radio" name="temperature" value="tiede" <?php echo $check; ?>> Tiède &nbsp;&nbsp;
		 <?php ($this->article->temperature=='froid')?$check='checked="checked"':$check=''; ?>
		 <input type="radio" name="temperature" value="froid"<?php echo $check; ?>> Froid <br/>
		<?php
		echo Form::textarea('adresse', $this->article->adresse,'Adresse','','largeur_moyen') .'<br/>' ;
		echo Form::text('cp', $this->article->cp, 'CP','','largeur_petit1')  ;
		echo Form::text('ville', $this->article->ville, 'Ville','','largeur_petit4') .'<br/>' ;
		echo Form::text('telephone', $this->article->telephone, 'Téléphone','','largeur_petit3') .'<br/>' ;
		echo Form::text('email', $this->article->email, 'E-mail','','largeur_moyen')   .'<br/>' ;
		echo Form::text('site_web', $this->article->site_web, 'Site WEB','','largeur_moyen') .'<br/>' ;
		echo Form::text('dirigeant', $this->article->dirigeant, 'Dirigeant','','largeur_moyen') .'<br/>' ;
		echo Form::text('naf', $this->article->naf, 'NAF','','largeur_grand') .'<br/>' ;
		echo Form::text('autre', $this->article->autre, 'Autre','','largeur_grand') .'<br/>' ;
		?></div>
		<div class="formulaire"><?php
		echo '<div id="titre_contact"> Contact </div>';
		echo Form::text('nom_contact', $this->article->nom_contact, 'Nom du contact','','largeur_moyen')   .'<br/>' ;
		echo Form::text('prenom_contact', $this->article->prenom_contact, 'Prénom du contact','','largeur_moyen') .'<br/>' ;
		echo Form::text('tel_contact', $this->article->tel_contact, 'Téléphone du contact&nbsp;&nbsp;','','largeur_petit3')   .'<br/>' ;
		echo Form::text('portable_contact', $this->article->portable_contact, 'Portable du contact &nbsp;&nbsp;&nbsp;&nbsp;','','largeur_petit3') .'<br/>' ;
		echo Form::text('email_contact', $this->article->email_contact, 'Email du contact','','largeur_moyen') .'<br/>' ;
		?>
		</div>
		<div style="clear:both"> </div>
	<?php echo Form::ValiderEtSupprimer($this->page != 0);?>	
	</form>   
	</div>
	<?php } ?>
<br/>
<br/>


<script>  	
jQuery(function($){ 
	
	$("#date_echange").datetimepicker({stepMinute: 5,dateFormat: 'dd/mm/yy', hourMin:8, hourMax:20});
	$("#date_rencontre").datetimepicker({stepMinute: 5,dateFormat: 'dd/mm/yy', hourMin:8, hourMax:20});
	$("#titre_encart_rencontre").click(function() {  
	  $("#encart_rencontre").slideToggle();
	});
	$("#titre_encart_echange").click(function() {  
	  $("#encart_echange").slideToggle();
	});
	$("#titre_encart_societe").click(function() {  
	  $("#encart_societe").slideToggle();
	});
	
	$(".echange_li").click(function() {  
	  $(".echange_li").removeClass("class_li");
	  $(this).addClass("class_li");
	  
	});
	
	$(".rencontre_li").click(function(){  	 
	  $(".rencontre_li").removeClass("class_li");
	  $(this).addClass("class_li");
	  var monid_rencontre= $(this).attr('id').replace('rencontre_li_','');
	  
	  $.ajax({
				url: 'ajax.php?action=RemplirFormRencontre',				   
				data   : {id_rencontre : monid_rencontre},
				  cache: false,
				  dataType: "json",
				error : function(request, error) { // Info Debuggage si erreur          
					    alert("Erreur Rencontre - responseText: "+request.responseText);
						},
				  success: function(data) { 
				          $("#id_rencontre").val(data.id_rencontre);	 
                          $("#date_rencontre").val(data.date);	
                          $("#commentaire_rencontre").val(data.commentaire);
						  $("#form_rencontre input:radio[value="+data.type_rencontre+"]").attr("checked","checked");
						  }
			  })
	 
	});
	
	$(".echange_li").click(function(){  	   
	  $(".echange_li").removeClass("class_li");
	  $(this).addClass("class_li");
	  var monid_echange= $(this).attr('id').replace('echange_li_','');
	  $("#ajouter_echange").fadeIn();
	  $.ajax({
				url: 'ajax.php?action=RemplirFormEchange',				   
				data   : {id_echange : monid_echange},
				  cache: false,
				  dataType: "json",
				error : function(request, error) { // Info Debuggage si erreur          
					    alert("Erreur Echange - responseText: "+request.responseText);
						},
				  success: function(data) { 
				  
				          $("#id_echange").val(data.id_echange);	
                          $("#date_echange").val(data.date);	
                          $("#commentaire_echange").val(data.commentaire);
						 
						  $("#form_echange input[type='submit']").val('Modifier l\'échange'); 
						  $("#form_echange input:radio[value="+data.type_echange+"]").attr("checked","checked");
						  }
			  })
	 
	});
	
	$("#ajouter_echange").click(function() {  	
	  $("#id_echange").val(0);	
	  $("#date_echange").val('');	
	  $("#commentaire_echange").val(''); 
	  $("#form_echange input[type='submit']").val('Ajouter un nouvel échange'); 	
      $(this).fadeOut();
	  $(".liste li").removeClass("class_li");
	});
	
	$(".supprimer_echange").click(function() {  
		  if (confirm ('Confirmez-vous la suppression ?')){
			  var monid_echange= $(this).attr('id').replace('echange_','');
					$.ajax({
						  url: 'ajax.php?action=SupprimerEchange',
						   
						data   : {id_echange : monid_echange},
						  cache: false,
						  dataType: "json",
						error : function(request, error) { // Info Debuggage si erreur          
								alert("Erreur sous genre - responseText: "+request.responseText);
								},
						  success: function(data) { 
							  $("#echange_li_"+monid_echange).hide();				      					   
								  } 
					  })
					  
				event.stopPropagation();  
			}
		});
		$(".supprimer_rencontre").click(function() {  
	        if (confirm ('Confirmez-vous la suppression ?')){
				var monid_rencontre= $(this).attr('id').replace('rencontre_','');
				$.ajax({
					  url: 'ajax.php?action=SupprimerRencontre',
					   
					data   : {id_rencontre : monid_rencontre},
					  cache: false,
					  dataType: "json",
					error : function(request, error) { // Info Debuggage si erreur          
							alert("Erreur sous genre - responseText: "+request.responseText);
							},
					  success: function(data) { 
						  $("#rencontre_li_"+monid_rencontre).hide();				      					   
							  } 
				  })
			 }		
		});

	});
  </script>

