<?php 
include('header.php');
if (isset($_REQUEST["rv"])){
  $id_rencontre=$_REQUEST["rv"];
  $LaRencontreSel = getEnregistrement('rencontre', $id_rencontre);
  $LaSocieteSel   = getEnregistrement('societe', $LaRencontreSel->id_societe);
}
?>
<div id="contenu">
    <div id="liste_planning">
		
		<?php
		$datejour='';
		echo '<ul>';
		foreach (GetListeRencontresFutures() AS $LaRencontre){
		  $nouveaudatejour=datefrSansHeure($LaRencontre->date_rencontre); 
		  if ($nouveaudatejour != $datejour){
		    echo '</ul> <div class="jour_planning">'.dateFrancaiseLitterale($LaRencontre->date_rencontre).'</div><ul>';
			$datejour= $nouveaudatejour;
		  }
		  if (isset($id_rencontre) && $LaRencontre->id == $id_rencontre) $class_li='class="class_li"'; else $class_li='';
		  echo '<li '.$class_li.'><a href="planning.php?rv='.$LaRencontre->id.'">'.HeurefrFrancaise($LaRencontre->date_rencontre).' <br/> '.NomSocieteDId($LaRencontre->id_societe).'</a></li>';
		}
		?>
		</ul>
	
	</div> 
	<?php if (isset ($LaSocieteSel)){ ?>
    <div id="resume_planning"> 
	  <div>
	    <h1><?php echo $LaSocieteSel->nom; ?></h1>
		<?php 
		  echo 'Rappeler le : '.dateFrancaiseLitterale($LaRencontreSel->date_rencontre).' a '.HeurefrFrancaise($LaRencontreSel->date_rencontre);
          echo $LaRencontreSel->commentaire; ?>
	  </div>
	  <div>
	    <h2> Contact </h2>
		<?php echo $LaSocieteSel->prenom_contact.' '. $LaSocieteSel->nom_contact;
		      echo 'Téléphone : '. $LaSocieteSel->tel_contact;
			  echo 'Portable  : '. $LaSocieteSel->portable_contact;
			  echo 'Email  : '. $LaSocieteSel->email_contact;
		?>
	  </div>
	</div>
	<?php } ?>
	<div style="clear:both"> </div>
</div>
<?php
include ('footer.php');
?>