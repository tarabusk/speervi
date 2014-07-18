<?php
require_once(dirname(__FILE__)."/classes/mysql.class.php");

/**************************** GENERAL *******************************/

function getEnregistrement($NomTable, $id_table){                         
  return Mysql::get_object("SELECT * FROM  `".$NomTable."`  WHERE id =".$id_table."");	   
}

function getListe($NomTable,$ordre){
  return Mysql::get_list("SELECT * FROM `".$NomTable."` ORDER BY ".$ordre." ASC");	
}

function getListeInverse($NomTable,$ordre){
  return Mysql::get_list("SELECT * FROM `".$NomTable."` ORDER BY ".$ordre." DESC");	
}

function getListeSocietes(){
    return Mysql::get_list("SELECT * FROM `societe` ORDER BY nom ASC");	
}

function GetRequeteRechercheParNom ($nom='', $ville='', $npage=1, $nbppage){

 if ($nom!='' && $ville!=''){
   $requete = "SELECT nom, id,temperature FROM `societe` WHERE (nom LIKE '%".$nom."%' OR naf LIKE '%".$nom."%') AND ville LIKE '%".$ville."%'";
    }
  else if ($nom!=''){
    $requete = "SELECT nom, id,temperature FROM `societe` WHERE nom LIKE '%".$nom."%' OR naf LIKE '%".$nom."%' ";	
  }else{
    $requete = "SELECT nom, id,temperature FROM `societe` WHERE ville LIKE '%".$ville."%' ";	
  }
  $p_lignes_par_page = $nbppage;
	$nl=Mysql::get_nombre_lignes($requete);
	
	$p_nb_page         = ceil( $nl/$p_lignes_par_page);
	if ($npage=='') $npage=1;
	$p_page_courante   = $npage;
  
	if ($p_page_courante >$p_nb_page) $p_page_courante=1;
	$p_premiere_ligne=($p_page_courante * $p_lignes_par_page)-$p_lignes_par_page ;
	
	if ($p_nb_page==1)
	  $p_requete_limite=$p_lignes_par_page;
	else
	  $p_requete_limite=$p_premiere_ligne.','.$p_lignes_par_page;
	//echo  $requete.' LIMIT ' .$p_requete_limite. ' ORDER BY nom ASC<br/>';
	return $requete.' ORDER BY nom ASC LIMIT ' .$p_requete_limite. ' ';
}
function getListeSocietesRechercheNom($nom='', $ville='', $npage, $nbppage){
    return Mysql::get_list(GetRequeteRechercheParNom($nom, $ville, $npage, $nbppage));	
}


function getListeSocietesParPage($npage,$nbppage){
    $p_lignes_par_page = $nbppage;
	$nl=Mysql::get_nombre_lignes("SELECT * from societe");
	$p_nb_page         = ceil( $nl/$p_lignes_par_page);
	$p_page_courante   = $npage;
  
	if ($p_page_courante >$p_nb_page) $p_page_courante=1;
	$p_premiere_ligne=($p_page_courante * $p_lignes_par_page)-$p_lignes_par_page ;
	
	if ($p_nb_page==1)
	  $p_requete_limite=$p_lignes_par_page;
	else
	  $p_requete_limite=$p_premiere_ligne.','.$p_lignes_par_page;
	  
    return Mysql::get_list("SELECT * FROM `societe` ORDER BY nom ASC LIMIT ".$p_requete_limite);	
}

function AfficherPagination($npage,$nbppage){
    $str='';
   if ($npage=='') $npage=1;
   $p_lignes_par_page = $nbppage;
	$nl=Mysql::get_nombre_lignes("SELECT * FROM societe");
	$p_nb_page         = ceil( $nl/$p_lignes_par_page);
	$p_page_courante   = $npage;
  
	if ($p_page_courante >$p_nb_page) $p_page_courante=1;
	$p_premiere_ligne=($p_page_courante * $p_lignes_par_page)-$p_lignes_par_page ;
	
	if ($p_nb_page==1)
	  $p_requete_limite=$p_lignes_par_page;
	else
	  $p_requete_limite=$p_premiere_ligne.','.$p_lignes_par_page;

      if ($p_nb_page>1){
	        $urlCourante=$_SERVER["REQUEST_URI"];
            $urlGet = explode("?",$urlCourante);
            $urlCourante=  $urlGet[0];
			$str.= '<p align="center">Page : '; //Pour l'affichage, on centre la liste des pages
			for($i=1; $i<=$p_nb_page; $i++) //On fait notre boucle
			{
				 //On va faire notre condition
				 if($i==$p_page_courante) //Si il s'agit de la page actuelle...
				 {
					 $str.= ' <span class="page_courante"> '.$i.' </span> '; 
				 }	
				 else //Sinon...
				 {				    
					   $str.= ' <a href="'.$urlCourante.'?npage='.$i.'">'.$i.'</a> ';					 
				 }
			}
			$str.= '</p>';
		}
		return $str;
}

function AfficherPaginationRecherche($npage,$nbppage, $nom,$ville){
    $str='';
   if ($npage=='') $npage=1;
   $p_lignes_par_page = $nbppage;
    
	 if ($nom!='' && $ville!=''){
   $requete = "SELECT nom, id,temperature FROM `societe` WHERE (nom LIKE '%".$nom."%' OR naf LIKE '%".$nom."%') AND ville LIKE '%".$ville."%'";
    }
  else if ($nom!=''){
    $requete = "SELECT nom, id,temperature FROM `societe` WHERE nom LIKE '%".$nom."%' OR naf LIKE '%".$nom."%' ";	
  }else{
    $requete = "SELECT nom, id,temperature FROM `societe` WHERE ville LIKE '%".$ville."%' ";	
  }
  $p_lignes_par_page = $nbppage;
	$nl=Mysql::get_nombre_lignes($requete);
	
	//$nl=Mysql::get_nombre_lignes(GetRequeteRechercheParNom($nom, $ville, $npage, $nbppage));
	$p_nb_page         = ceil( $nl/$p_lignes_par_page);
	$p_page_courante   = $npage;
  
	if ($p_page_courante >$p_nb_page) $p_page_courante=1;
	$p_premiere_ligne=($p_page_courante * $p_lignes_par_page)-$p_lignes_par_page ;
	
	if ($p_nb_page==1)
	  $p_requete_limite=$p_lignes_par_page;
	else
	  $p_requete_limite=$p_premiere_ligne.','.$p_lignes_par_page;

      if ($p_nb_page>1){
	        $urlCourante=$_SERVER["REQUEST_URI"];
            $urlGet = explode("?",$urlCourante);
            $urlCourante=  $urlGet[0];
			$str.= '<p align="center">Page : '; //Pour l'affichage, on centre la liste des pages
			for($i=1; $i<=$p_nb_page; $i++) //On fait notre boucle
			{
				 //On va faire notre condition
				 if($i==$p_page_courante) //Si il s'agit de la page actuelle...
				 {
					 $str.= ' <span class="page_courante"> '.$i.' </span> '; 
				 }	
				 else //Sinon...
				 {				    
					   $str.= ' <a href="'.$urlCourante.'?npage='.$i.'">'.$i.'</a> ';					 
				 }
			}
			$str.= '</p>';
		}
		return $str;
}

function GetListesEchangesSociete ($id_societe){
  if ($id_societe > 0)
  return Mysql::get_list("SELECT * FROM `echange` WHERE id_societe = ".$id_societe." ORDER BY date_echange DESC");	
}

function SurSuppressionSociete($id_societe){
  return Mysql::query("
		DELETE FROM echange
		WHERE  id_societe= '%d'", $id_societe );
 return Mysql::query("
		DELETE FROM rencontre
		WHERE  id_societe= '%d'", $id_societe );
}


function AjouterUnEchange ($id_societe, $date_echange, $commentaire, $type_echange){
//echo "SELECT * FROM `echange` WHERE id_societe = ".$id_societe." AND date_echange='".$date_echange."'";
  if (!Mysql::get_object("SELECT * FROM `echange` WHERE id_societe = ".$id_societe." AND date_echange='".$date_echange."'")){ 
	  return  Mysql::insert('echange', array(
		  'id_societe' => $id_societe,		  
		  'date_echange' => $date_echange,	
		  'type_echange' => $type_echange,	  
		  'commentaire' => $commentaire));
  }else return false;
 }	
 
function ModifierLEchange ($id_echange, $id_societe, $date_echange, $commentaire, $type_echange){
  return Mysql::update('echange', array('id_societe' => $id_societe,'date_echange'=>$date_echange, 'commentaire'=>$commentaire), "WHERE id = '%d' ", $id_echange);
 
 }
function NomSocieteDId($id_societe){
  $LaSociete= Mysql::get_object("SELECT nom FROM `societe`  WHERE id=".$id_societe);
  if ($LaSociete) return $LaSociete->nom; else return '';
} 
function GetListeRencontresFutures(){
  return Mysql::get_list("SELECT * FROM `rencontre`  WHERE date_rencontre >= CURDATE() ORDER BY date_rencontre ASC");	
}
function TemperatureDeLaSociete($id_societe){
  $LaSociete=Mysql::get_object("SELECT temperature FROM `societe`  WHERE id ='".$id_societe."'");	
  if ($LaSociete) return $LaSociete->temperature; else return '';
}
 
 function AjouterUneRecontre ($id_societe, $date_rencontre, $commentaire, $type_rencontre){
  
   $Lobjet=Mysql::get_object("SELECT * FROM `rencontre` WHERE id_societe = ".$id_societe." AND date_rencontre='".$date_rencontre."'");
   if (!$Lobjet){ 
	  return Mysql::insert('rencontre', array(
		  'id_societe' => $id_societe,		  
		  'date_rencontre' => $date_rencontre,	
		  'type_rencontre' => $type_rencontre,	  
		  'commentaire' => $commentaire));
	}else {echo 'ssss';return false;}
 }	
 function ModifierLaRencontre ($id_rencontre, $id_societe, $date_rencontre, $commentaire, $type_rencontre){
  return Mysql::update('rencontre', array('id_societe' => $id_societe,'date_rencontre'=>$date_rencontre, 'commentaire'=>$commentaire), "WHERE id = '%d' ", $id_rencontre);
 
 }
function SupprimerLEchange($id_echange){
 return Mysql::query("
    DELETE FROM echange
    WHERE id = '%d'", $id_echange);
} 
function SupprimerLaRencontre($id_rencontre){
 return Mysql::query("
    DELETE FROM rencontre
    WHERE id = '%dS'", $id_rencontre);
} 
function GetListeRencontreSociete ($id_societe){
  if ($id_societe > 0)
  return Mysql::get_list("SELECT * FROM `rencontre` WHERE id_societe = ".$id_societe." ORDER BY date_rencontre DESC");	
}
function GetDernierRencontreSociete ($id_societe){
  if ($id_societe > 0)
  return Mysql::get_object("SELECT * FROM `rencontre` WHERE id_societe = ".$id_societe." ORDER BY date_rencontre DESC");	
}

function getSocieteDeNomEtDeVille($nom, $ville){
//echo "SELECT * FROM `societe` WHERE nom='".$nom."' AND ville='".$ville."'";
    return Mysql::get_object("SELECT * FROM `societe` WHERE nom='".$nom."' AND ville='".$ville."'");		
}

function TransformerRencontreEnEchange($id_rencontre){
  $LaRencontre=GetEnregistrement('rencontre', $id_rencontre);
  if ($LaRencontre){
	  Mysql::insert('echange', array(
		  'date_echange' => $LaRencontre->date_rencontre,		                     
		  'type_echange' => $LaRencontre->type_rencontre,	
		  'id_societe' => $LaRencontre->id_societe,	  
		  'commentaire'=> $LaRencontre->commentaire));
	  SupprimerLaRencontre($id_rencontre);
	  return true;
  }else return false;
}

?>
