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
/**************************** BIEN *******************************/

function AffecterImpagePrincipaleAubien ($id_bien, $lien_image){
  return Mysql::update('bien', array('image' => $lien_image), "WHERE id = '%s' ", $id_bien);
}


function getListeVentes($AvecOffLine=true){
  if ($AvecOffLine)
    return Mysql::get_list("SELECT * FROM `bien` WHERE location='0' ORDER BY online DESC, date_publication DESC");	 
  else
    return Mysql::get_list("SELECT * FROM `bien` WHERE location='0' AND online='1' ORDER BY date_publication DESC");	
}

function getListeLocationsDeType($id_type){
    return Mysql::get_list("SELECT * FROM `bien` WHERE location='1' AND id_type_bien='".$id_type."'  ORDER BY online DESC, date_publication DESC");		
}

function getLocationsDeReference($ref){
 return Mysql::get_list("SELECT * FROM `bien` WHERE location='1' AND ref='".$ref."' ORDER BY date_publication DESC");	
}

function getVentesDeReference($ref){
 return Mysql::get_list("SELECT * FROM `bien` WHERE location='0' AND ref='".$ref."' ORDER BY date_publication DESC");	
}

function getIDLocationDeReference($ref){
 return Mysql::get_object("SELECT id FROM  `bien`  WHERE location='1' AND ref='".$ref."'")->id;
}
function getIDVenteDeReference($ref){
 return Mysql::get_object("SELECT id FROM  `bien`  WHERE location='0' AND ref='".$ref."'")->id;
}

function getListeImageALaUneDesBiensVente (){
  return Mysql::get_list("SELECT image,titre,id,prix,location,id_type_bien FROM `bien` WHERE online='1' AND image_une='1' AND image!='' AND location='0' ORDER BY date_publication DESC LIMIT 2");	
}

function getListeImageALaUneDesBiensLocation  (){
  return Mysql::get_list("SELECT image,titre,id,prix,location,id_type_bien FROM `bien` WHERE online='1' AND  image_une='1' AND image!='' AND location='1' ORDER BY date_publication DESC LIMIT 4");	
}
function getListeImageDiapoDesBiens (){
  return Mysql::get_list("SELECT image,titre,description,prix,id,location,id_type_bien FROM `bien` WHERE online='1' AND  image_diapo='1' AND image!='' ORDER BY date_publication DESC");	
}
/*
function NbrDeBiensSelonCriteres ($location, $id_type_bien, $prix_min, $prix_max, $id_lieu,$surface_min, $surface_max){

echo $prix_min.'-'.$prix_max.'-'.$id_lieu.'-'.$surface_min.'-'.$surface_max;
if($location==''){$cond_location='location=0';}else{$cond_location='location='.$location;}
if(trim($prix_max=='')){$cond_prix_max='';}else{$cond_prix_max='AND prix<='.$prix_max;}
if(trim($prix_min=='')){$cond_prix_min='';}else{$cond_prix_min='AND prix>='.$prix_min;}
if($id_type_bien==''|| $id_type_bien==0){$cond_id_type_bien='';}else{$cond_id_type_bien='AND id_type_bien='.$id_type_bien;}
if($id_lieu=='0'||$id_lieu==''){$cond_id_lieu='';}else{$cond_id_lieu='AND (id_lieu='.$id_lieu.' OR id_pere='.$id_lieu.')';}
if($surface_max==''){$cond_surface_max='';}else{$cond_surface_max='AND surface<='.$surface_max;}
if($surface_min==''){$cond_surface_min='';}else{$cond_surface_min='AND surface>='.$surface_min;}

echo "SELECT id FROM `bien` WHERE ".$cond_location." ".$cond_id_type_bien." ".$cond_prix_max." ".$cond_prix_min."  ".$cond_id_lieu."  ".$cond_surface_max." ".$cond_surface_min;
return Mysql::get_nombre_lignes("SELECT id FROM `bien` WHERE ".$cond_location." ".$cond_id_type_bien." ".$cond_prix_max." ".$cond_prix_min."  ".$cond_id_lieu."  ".$cond_surface_max." ".$cond_surface_min);
$retour_total=mysql_query('SELECT COUNT(*) AS total FROM livredor'); //Nous récupérons le contenu de la requête dans $retour_total
$donnees_total=mysql_fetch_assoc($retour_total); //On range retour sous la forme d'un tableau.
$total=$donnees_total['total']; //On récupère le total pour le placer dans la variable $total.

}*/

function NbrDeBiensSelonCriteres ($location, $id_type_bien, $prix_min, $prix_max, $id_lieu,$surface_min, $surface_max){
$prix_min=str_replace(' ','',$prix_min);
$prix_max=str_replace(' ','',$prix_max);
$surface_max=str_replace(' ','',$surface_max);
$surface_min=str_replace(' ','',$surface_min);
if($location==''){$cond_location='b.location=0';}else{$cond_location='b.location='.$location;}
if(trim($prix_max=='')){$cond_prix_max='';}else{$cond_prix_max='AND b.prix<='.$prix_max;}
if(trim($prix_min=='')){$cond_prix_min='';}else{$cond_prix_min='AND b.prix>='.$prix_min;}
if($id_type_bien==''|| $id_type_bien==0){$cond_id_type_bien='';}else{$cond_id_type_bien='AND b.id_type_bien='.$id_type_bien;}
if($id_lieu=='0'||$id_lieu==''){$cond_id_lieu='';}else{$cond_id_lieu='AND (b.id_lieu='.$id_lieu.' OR l.id_pere='.$id_lieu.')';}
if($surface_max==''){$cond_surface_max='';}else{$cond_surface_max='AND b.surface<='.$surface_max;}
if($surface_min==''){$cond_surface_min='';}else{$cond_surface_min='AND b.surface>='.$surface_min;}
//echo "SELECT b.id FROM `bien` b, `lieu` l WHERE b.id_lieu=l.id AND ".$cond_location." ".$cond_id_type_bien." ".$cond_prix_max." ".$cond_prix_min."  ".$cond_id_lieu."  ".$cond_surface_max." ".$cond_surface_min;
return Mysql::get_nombre_lignes("SELECT b.id FROM `bien` b, `lieu` l WHERE b.id_lieu=l.id AND online='1' AND ".$cond_location." ".$cond_id_type_bien." ".$cond_prix_max." ".$cond_prix_min."  ".$cond_id_lieu."  ".$cond_surface_max." ".$cond_surface_min);
/*$retour_total=mysql_query('SELECT COUNT(*) AS total FROM livredor'); //Nous récupérons le contenu de la requête dans $retour_total
$donnees_total=mysql_fetch_assoc($retour_total); //On range retour sous la forme d'un tableau.
$total=$donnees_total['total']; //On récupère le total pour le placer dans la variable $total.
*/
}

function ListeDesBiensSelonCriteres ($location, $id_type_bien, $prix_min, $prix_max, $id_lieu,$surface_min, $surface_max, $limite){
$prix_min=str_replace(' ','',$prix_min);
$prix_max=str_replace(' ','',$prix_max);
$surface_max=str_replace(' ','',$surface_max);
$surface_min=str_replace(' ','',$surface_min);
if($location==''){$cond_location='location=0';}else{$cond_location='location='.$location;}
if(trim($prix_max=='')){$cond_prix_max='';}else{$cond_prix_max='AND prix<='.$prix_max;}
if(trim($prix_min=='')){$cond_prix_min='';}else{$cond_prix_min='AND prix>='.$prix_min;}
if($id_type_bien==''|| $id_type_bien==0){$cond_id_type_bien='';}else{$cond_id_type_bien='AND id_type_bien='.$id_type_bien;}
if($id_lieu=='0'||$id_lieu==''){$cond_id_lieu='';}else{$cond_id_lieu='AND (id_lieu='.$id_lieu.' OR id_pere='.$id_lieu.')';}
if($surface_max==''){$cond_surface_max='';}else{$cond_surface_max='AND surface<='.$surface_max;}
if($surface_min==''){$cond_surface_min='';}else{$cond_surface_min='AND surface>='.$surface_min;}
//echo "SELECT * FROM `bien` WHERE ".$cond_location." ".$cond_id_type_bien." ".$cond_prix_max." ".$cond_prix_min." ".$cond_id_lieu."  ".$cond_surface_max." ".$cond_surface_min." ORDER BY prix ASC LIMIT ".$limite;
$requete= "SELECT DISTINCT  b.* FROM `bien` b, `lieu` l WHERE online='1' AND ".$cond_location." ".$cond_id_type_bien." ".$cond_prix_max." ".$cond_prix_min." 
".$cond_id_lieu."  ".$cond_surface_max." ".$cond_surface_min." ORDER BY prix ASC LIMIT ".$limite;
//echo $requete;
return Mysql::get_list($requete);
}

/*
function ListeDesBiensSelonCriteres ($location, $id_type_bien, $prix, $id_lieu,$surface, $limite){

if($location==''){$cond_location='location=0';}else{$cond_location='location='.$location;}
if(trim($prix=='')){$cond_prix='';}else{$cond_prix='AND prix>='.$prix;}
if($id_type_bien==''|| $id_type_bien==0){$cond_id_type_bien='';}else{$cond_id_type_bien='AND id_type_bien='.$id_type_bien;}
if($id_lieu=='0'||$id_lieu==''){$cond_id_lieu='';}else{$cond_id_lieu='AND id_lieu='.$id_lieu;}
if($surface==''){$cond_surface='';}else{$cond_surface='AND surface<='.$surface;}

//echo "SELECT * FROM `bien` WHERE ".$cond_location." ".$cond_id_type_bien." ".$cond_prix." ".$cond_id_lieu."  ".$cond_surface." ORDER BY date_publication DESC LIMIT ".$limite;
return Mysql::get_list("SELECT * FROM `bien` WHERE ".$cond_location." ".$cond_id_type_bien." ".$cond_prix." ".$cond_id_lieu."  ".$cond_surface." ORDER BY prix ASC LIMIT ".$limite);
}*/
/*
function ListeDesBiensSelonCriteres ($id_type_bien, $prix, $id_lieu, $limite){
	return Mysql::get_list("
    SELECT  b.* 
	FROM `bien` b , `type_bien` tb, `lieu` l
	WHERE   tb.id=b.id_type_bien AND b.prix<=".$prix." AND l.id=a.id_genre AND r.id=a.id_rubrique AND le.id=a.id_lecteur
		ORDER BY a.date_publication DESC LIMIT ".$limite); 		
}
*/
function AffecterDateAlerteAuBien ($id_bien,$i){
//return Mysql::update('bien', array('envoi_alerte' => 'NOW()'), " WHERE id = '%s' ", $id_bien);
$sql = "update bien set envoi_alerte = NOW(), envoi_nb=".$i." where id = '".$id_bien."' ";	  
		$query = mysql_query($sql);
}

function IDTypeDuBienDID($idbien){
  $strType=Mysql::get_object("SELECT tb.id FROM `type_bien` tb, `bien` b WHERE tb.id = b.id_type_bien AND b.id=".$idbien );
  //echo "SELECT tb.id FROM `type_bien` tb, `bien` b WHERE tb.id = b.id_type_bien AND b.id=".$idbien;
  if ($strType){
    return $strType->id;
  }
}

function IDPageSelonBien($idbien){
  $LeBien=Mysql::get_object("SELECT location FROM bien WHERE id=".$idbien);
  if($LeBien){

	  $type_bien=$LeBien->location;
	  if ($type_bien==0){//vente
	    return IDPageVente();
	  }else{ //location
	    return IDPageLocation();
	  }
  }else return IDPageAccueil();
}

/********** PAGE ****************/

function IDPageAccueil(){
  return Mysql::get_object("SELECT id FROM page WHERE home_page=1")->id;		
}
function IDPageLocation(){
  return Mysql::get_object("SELECT id FROM page WHERE zz_template='index-location.php'")->id;		
}
function IDPageVente(){
  return Mysql::get_object("SELECT id FROM page WHERE zz_template='index-ventes.php'")->id;		
}
function getListePagesMeres(){
  return Mysql::get_list("SELECT * FROM `page`  WHERE est_mere=1 ORDER BY  ordre ASC");
}

function ProchainIDPage(){
  $LArticle = Mysql::get_object("SELECT id FROM page ORDER BY id DESC LIMIT 0, 1");                         
  return $LArticle->id + 1;
}

function getListePages(){
  return Mysql::get_list("SELECT * FROM `page` WHERE online=1 ORDER BY ordre ASC");
      
}

function getListePagesMenu(){
  return Mysql::get_list("SELECT * FROM `page` WHERE online=1 AND id_page_mere= 0 AND menu_principal='1' ORDER BY ordre ASC");
      
}
function getListePagesSousMenu($id_page_mere){
  return Mysql::get_list("SELECT * FROM `page` WHERE online=1 AND id_page_mere= ".$id_page_mere."  ORDER BY ordre ASC");    
}

function SupprimerToutesLesPagesDAccueil(){
return Mysql::get_list("UPDATE `page` SET `home_page`=0");
}

function LienPageReecris($id_page){
    $LaPage= Mysql::get_object("SELECT zz_template,zz_url,home_page FROM page WHERE id=".$id_page);	
	if ($LaPage->home_page){
	   return './';
	}else if ($LaPage->zz_url !=''){
	   return $LaPage->zz_url;
	}else{
	  return $LaPage->zz_template.'?page='.$id_page;
	}
}
function LienPourPagination($id_page,$npagin){
    $LaPage= Mysql::get_object("SELECT zz_template,zz_url,home_page FROM page WHERE id=".$id_page);	
	if ($LaPage->home_page){
	   return './';
	}else if ($LaPage->zz_url !=''){
	   if ($npagin==1)
	     return $LaPage->zz_url;
	   else
	     return $LaPage->zz_url.'-'.$npagin;
	}else{
	  return $LaPage->zz_template.'?page='.$id_page.'&npage='.$npagin;
	}
}

/********** LIEUX ****************/

function getListeLieuxPeresDisponibles($id_lieu){
if ($id_lieu==0)
  return Mysql::get_list("SELECT * FROM `lieu` WHERE id_pere=0 ORDER BY nom ASC");
else
  return Mysql::get_list("SELECT * FROM `lieu` WHERE id!=".$id_lieu." AND id_pere=0 ORDER BY nom ASC");
}

function getListeLieux(){
  return Mysql::get_list("SELECT * FROM `lieu` ORDER BY (((id_pere=0)*id*1000)+((id_pere>0)*(id_pere*1000) + id)) ASC");
}

function getListeLieuxUtilises(){
/* Je prends tous les lieux utilisés ou les pères dont un des fils est utilisé */
  $Listeinitiale= Mysql::get_list("SELECT * FROM `lieu` ORDER BY (((id_pere=0)*id*1000)+((id_pere>0)*(id_pere*1000) + id)) DESC");
  $Listefinale=array();
  $estpere=true;
  $AfficherPere=0;
  foreach ($Listeinitiale AS $LeLieu){
    if (($LeLieu->id_pere == 0)&& ($AfficherPere==$LeLieu->id)) {
	  $Listefinale[]=$LeLieu;
	}else
    if (Mysql::get_object("SELECT id FROM bien WHERE id_lieu=".$LeLieu->id)){
	   $Listefinale[]=$LeLieu;
	   if ($LeLieu->id_pere > 0){
	     $AfficherPere= $LeLieu->id_pere;
	   }
	}	
  }
  return array_reverse($Listefinale); 
}

function IDLieuPere($id_lieu){
return Mysql::get_object("SELECT id_pere FROM lieu WHERE id=".$id_lieu)->id_pere;
}

function NomDuLieu ($id_lieu){
  if ($id_lieu>0){
	  $Nom= Mysql::get_object("SELECT nom FROM lieu WHERE id=".$id_lieu)->nom;
	  $id_pere=IDLieuPere($id_lieu) ;
	  $NomFinal=$Nom;
	  if ($id_pere>0){
	    $Nom_pere=Mysql::get_object("SELECT nom FROM lieu WHERE id=".$id_pere)->nom;
		$NomFinal.=' - '.$Nom_pere;
	  }
	
  }else $NomFinal='';
  return $NomFinal;
}
function SurSuppressionLieu($id_lieu){
  return Mysql::update('bien', array('id_lieu' => 0), "WHERE id_lieu = '%s' ", $id_lieu);
}

/********** TYPE_BIEN ****************/

function strTypeDuBien($id_type_bien){

$LeBien=  Mysql::get_object("SELECT  nom
	FROM  `type_bien` 
	WHERE   id=".$id_type_bien);
if ($LeBien){
  return $LeBien->nom;
}else{
  return '';
} 	
}
function SurSuppressionTypeBien($id_type_bien){
  return Mysql::update('bien', array('id_type_bien' => 0), "WHERE id_type_bien = '%s' ", $id_type_bien);
}

function getListeTypesBienUtilises(){
  $Listeinitiale=getListe('type_bien', 'nom');
  $Listefinale=array();
  foreach ($Listeinitiale AS $LeType){
    if (Mysql::get_object("SELECT id FROM bien WHERE id_type_bien=".$LeType->id)){
	   $Listefinale[]=$LeType;
	}
  }
  return $Listefinale;
}
function getListeTypesBienUtilisesALaLocation(){
  $Listeinitiale=getListe('type_bien', 'nom');
  $Listefinale=array();
  foreach ($Listeinitiale AS $LeType){
    if (Mysql::get_object("SELECT id FROM bien WHERE location='1' AND id_type_bien=".$LeType->id)){
	   $Listefinale[]=$LeType;
	}
  }
  return $Listefinale;
}
/********** FORM_CONTACT ****************/

function EnvoiDUnFormulaireDeContact($nom,$prenom,$email,$telephone,$message,$id_bien){
    if ($id_bien>0){
	  return Mysql::insert('form_contact', array(
	  'nom' => $nom,		                     
	  'prenom' => $prenom,	
      'email' => $email,	  
	  'telephone' => $telephone,						  																 
	  'message' => $message,	  					 
	  'date_envoi' => 'NOW()',
	  'id_bien'=> $id_bien));
		return true;
	}else return false;
}

/********** ALERTE ****************/

function AjouterUneAlerte ($email,$location, $id_type_bien, $prix_min, $prix_max, $id_lieu,$surface_min, $surface_max,$nb_pieces_min,$nb_pieces_max) {
  if ($id_type_bien>0){
	  $LID= Mysql::insert('alerte', array(
	  'email' => $email,		  
	  'location' => $location,		                     
	  'prix_min' => $prix_min,	
      'prix_max' => $prix_max,	
      'id_type_bien' => $id_type_bien,		  
	  'id_lieu' => $id_lieu,						  																 
	  'surface_min' => $surface_min,	
	  'surface_max' => $surface_max,	
	  'nb_pieces_max' => $nb_pieces_max,	
	  'nb_pieces_min' => $nb_pieces_min,	
	  'date_alerte' => 'NOW()'));
	  $LeHash=getHash($LID); // On détermine un code MD5 unique pour identifier le retour de mail
      Mysql::update('alerte', array("hash" => $LeHash), "WHERE id = '%s'", $LID);
		return true;
	}else return false;
}

function SupprimerAlerteDehash($hash){
  return Mysql::query("
    DELETE FROM alerte
    WHERE hash = '%s'", $hash);
}
function ListeDesAlertesRepondantAuxCriteres ($location, $id_type_bien, $prix, $id_lieu,$surface,$nb_pieces){
	if($location==''){$cond_location='location=0';}else{$cond_location='location='.$location;}
	if(trim($prix=='')){$cond_prix='';}else{$cond_prix='AND prix_min<='.$prix.' AND prix_max >='.$prix;}
	if($id_type_bien==''|| $id_type_bien==0){$cond_id_type_bien='';}else{$cond_id_type_bien='AND id_type_bien='.$id_type_bien;}
	if($id_lieu=='0'||$id_lieu==''){$cond_id_lieu='';}else{$cond_id_lieu='AND id_lieu='.$id_lieu;}
	if($surface==''){$cond_surface='';}else{$cond_surface='AND surface_min<='.$surface.' AND surface_max >='.$surface;}
	if($nb_pieces==''){$cond_piece='';}else{$cond_piece='AND nb_pieces_min<='.$nb_pieces.' AND nb_pieces_min >='.$nb_pieces;}
//	echo "SELECT * FROM `alerte` WHERE ".$cond_location." ".$cond_id_type_bien." ".$cond_prix." ".$cond_id_lieu."  ".$cond_surface." ".$cond_piece." ORDER BY date_alerte DESC";
	return Mysql::get_list("SELECT * FROM `alerte` WHERE ".$cond_location." ".$cond_id_type_bien." ".$cond_prix." ".$cond_id_lieu."  ".$cond_surface." ".$cond_piece." ORDER BY date_alerte DESC ");
}

function getAlertesParMail($mail){
  return Mysql::get_list("SELECT  * FROM  `alerte` WHERE   email='".$mail."'"); 			
}
/********** ALERTE_EMAIL****************/
// Crée pour controler l'envoi des emails


function AjouterAlerteEmail ($id_bien,$id_alerte) {
	   Mysql::insert('alerte_email', array(
	  'id_bien' => $id_bien,		  
	  'id_alerte' => $id_alerte,		                     
	  'date_envoi' => 'NOW()'));	 
}

function getListeEnvoisPourLAlerte($idalerte){
  return Mysql::get_list("SELECT * FROM `alerte_email` WHERE id_alerte='".$idalerte."' ");
}

/********** INFOS-ANNEXES ****************/

function AfficherTexteInfoAnnexeDeNom($nom){
  $texte=  Mysql::get_object("SELECT texte FROM  `infos_annexes`  WHERE nom='".$nom."' ")->texte;
  if ( $texte) return  $texte; else return '';
}


?>
