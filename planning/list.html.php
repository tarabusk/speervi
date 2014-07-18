<?php require_once('../classes/form.class.php'); 
 require_once('../fonctions_php.php'); 
if (isset($_REQUEST["rv"])){
  $id_rencontre=$_REQUEST["rv"];
  $LaRencontreSel = getEnregistrement('rencontre', $id_rencontre);
  $LaSocieteSel   = getEnregistrement('societe', $LaRencontreSel->id_societe);
}

$datejour='';

echo '<ul class="liste_planning">';
$nrencontre=0;

foreach (GetListeRencontresFutures() AS $LaRencontre){
  
  $nouveaudatejour=datefrSansHeure($LaRencontre->date_rencontre); 
  if ($nouveaudatejour != $datejour){
    $nrencontre++;
    if ($datejour!='')echo '</ul>';
	echo '<div class="jour_planning">'.dateFrancaiseLitterale($LaRencontre->date_rencontre).'</div> <ul class="liste_planning">';
	$datejour= $nouveaudatejour;
  }
  if (isset($id_rencontre) && $LaRencontre->id == $id_rencontre) $class_li='class="class_li"'; else $class_li='';
  echo '<li '.$class_li.'><a href="index.php?rv='.$LaRencontre->id.'&page='.$LaRencontre->id_societe.'"><span style="font-size:12px;font-style:italic">'.HeurefrFrancaise($LaRencontre->date_rencontre).' </span>- '.NomSocieteDId($LaRencontre->id_societe).'</a>'.AfficherTemperature(TemperatureDeLaSociete($LaRencontre->id_societe)).'</li>';
}
?>
<?php if ($nrencontre==0) echo 'Aucun rappel programmé'; ?>
</ul>


