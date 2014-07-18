<?php  
require_once ('../fichiers-recquis.php');

if ($_GET['action'] == "SupprimerEchange") { SupprimerEchange(); } 

if ($_GET['action'] == "SupprimerRencontre") { SupprimerRencontre(); } 
if ($_GET['action'] == "RemplirFormRencontre") { RemplirFormRencontre(); } 
if ($_GET['action'] == "RemplirFormEchange") { RemplirFormEchange(); } 

function SupprimerEchange() {
   echo $_REQUEST['id_echange'];
  if ($_REQUEST['id_echange'] != ''){ 
     SupprimerLEchange($_REQUEST['id_echange']);
	   
  }   
  echo "1";
  exit(0);
}
function SupprimerRencontre() {
   echo $_REQUEST['id_rencontre'];
  if ($_REQUEST['id_rencontre'] != ''){ 
     SupprimerLaRencontre($_REQUEST['id_rencontre']);
	   
  }   
  echo "1";
  exit(0);
}

function RemplirFormRencontre() {	    
  $LaRencontre=getEnregistrement ('rencontre', $_REQUEST['id_rencontre']);
  
  header('Content-type: application/json');
  ?>
  {
      "date": "<?php echo datefrFrancaise($LaRencontre->date_rencontre);?>" ,
	  "commentaire": "<?php echo utf8_encode($LaRencontre->commentaire);?>" ,
	  "type_rencontre": "<?php echo $LaRencontre->type_rencontre;?>" ,
	  "id_rencontre": "<?php echo $LaRencontre->id;?>" 
  }
  <?php
	exit(0);
}

function RemplirFormEchange() {	    
  $Laechange=getEnregistrement ('echange', $_REQUEST['id_echange']);
  
  header('Content-type: application/json');
  ?>
  {
      "date": "<?php echo datefrFrancaise($Laechange->date_echange);?>" ,
	  "commentaire": "<?php echo utf8_encode($Laechange->commentaire);?>" ,
	  "type_echange": "<?php echo $Laechange->type_echange;?>" ,
	  "id_echange": "<?php echo $Laechange->id;?>"
  }
  <?php
	exit(0);
}
?>
 