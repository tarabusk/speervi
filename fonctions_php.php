<?php

require_once('variables-site.php');



	// Récupère la liste des Societes à afficher
	
function ImporterSocietes(){
	// vérification sur la session authentification (la session est elle enregistrée ?) 
	// ici les éventuelles actions en cas de réussite de la connexion 
	//require_once('connect.php'); 
	//$sql=mysql_query("DELETE FROM communes"); 

	//========================= 
	// Traitement des donnees 
	//========================= 

	//recupere le nom du fichier indiqué par l'user 
	$fichier=$_FILES["userfile"]["name"]; 
	// ouverture du fichier en lecture 
	if ($fichier) 
	{ 
	  //ouverture du fichier temporaire 
	  $fp = fopen ($_FILES["userfile"]["tmp_name"], "r"); 
	} 
	else{ 
		// fichier inconnu 
		?> 
		<!--<p align="center" >- Importation échouée -</p> 
		<p align="center" ><B>Désolé, mais vous n'avez pas spécifié de chemin valide ...</B></p> -->
		<?php 
		//exit(); 
	} 
	// declaration de la variable "cpt" qui permettra de conpter le nombre d'enregistrement réalisé 
	$cpt=0; $cptNon=0;$nligne=0;
	?> 
<!--	<p align="center">- Importation Réussie -</p> 
	<p align="right"><a href="#bas">Bas de page</a></p> 
-->
	<?php 
	// importation 
	if ($fp &&  strrchr($fichier,'.')=='.csv'){ 
		while (!feof($fp)) 
		{   set_time_limit(0);
			$ligne = fgets($fp,4096); 
			// on crée un tableau des élements séparés par des points virgule 
			$liste = explode(";",$ligne); 
			// premier élément 
			$liste[0] = ( isset($liste[0]) ) ? $liste[0] : Null; 
			$liste[1] = ( isset($liste[1]) ) ? $liste[1] : Null; 
			$liste[2] = ( isset($liste[2]) ) ? $liste[2] : Null; 
			$liste[3] = ( isset($liste[3]) ) ? $liste[3] : Null; 
			$liste[4] = ( isset($liste[4]) ) ? $liste[4] : Null; 
			$liste[5] = ( isset($liste[5]) ) ? $liste[5] : Null; 
			$liste[6] = ( isset($liste[6]) ) ? $liste[6] : Null; 
			$liste[7] = ( isset($liste[7]) ) ? $liste[7] : Null; 
			$liste[8] = ( isset($liste[8]) ) ? $liste[8] : Null; 
			$liste[9] = ( isset($liste[9]) ) ? $liste[9] : Null; 
			$liste[10] = ( isset($liste[10]) ) ? $liste[10] : Null; 
			$liste[11] = ( isset($liste[11]) ) ? $liste[11] : Null; 
			$liste[12] = ( isset($liste[12]) ) ? $liste[12] : Null; 
			$liste[13] = ( isset($liste[13]) ) ? $liste[13] : Null; 

			$nom         = $liste[0]; 
			$dirigeant   = $liste[1]; 
			$adresse     = $liste[2]; 
			$cp          = $liste[3]; 
			$ville       = $liste[4]; 
			$telephone   = $liste[5]; 
			$email       = $liste[6]; 
			$naf         = $liste[7].'-'.$liste[8];  
			$autre       = $liste[9].' / '.$liste[10].' / '.$liste[11].' / '.$liste[12].' / '.$liste[13];  
			/* 
			0 RAISON SOCIALE | 1 DIRIGEANT | 2 ADRESSE |  3 CP | 4 VILLE |  5 TELEPHONE | 6 EMAIL | 7 CODE NAF | 8 LIBELLE NAF | 9 RUBRIQUE PROFESSIONNELLE | 10 FORME JURIDIQUE | 
			11 STATUT ETS | 12 EFFECTIF | 13 DEBUT ACTIVITE

			*/
			/*$site_web=$liste[3]; 
			$nom_contact=$liste[3]; 
			$prenom_contact=$liste[3]; 
			$tel_contact=$liste[3]; 
			$portable_contact=$liste[3]; 
			$email_contact=$liste[3]; */
			
			// pour eviter qu un champs "nom" du fichier soit vide 
			if ($nom!=''  && $nligne > 0) { 			
				//echo '<a href="#"> Actualiser la page </a>';
				// requete et insertion ligne par ligne 
				// champs1 id en general dc on affecte pas de valeur 
				if (!getSocieteDeNomEtDeVille(mysql_real_escape_string($nom), mysql_real_escape_string($ville))){
				  // nouvel ajout, compteur incrémenté 
				  $cpt++; 
				   Mysql::insert('societe', array(
					 'nom' => $nom,		                     
					  'adresse' => $adresse,	
					  'cp' => $cp,	  
					  'ville' => $ville,						  																 
					  'telephone' => $telephone,	  					 
					  'email' => $email,
					  'dirigeant'=>$dirigeant,
					  'naf'=>$naf,
					  'autre'=>$autre));
					 
				  $class_import="";
				}else{
				  $cptNon++;
				  $class_import="non_importe";				
				}				
			/*	$str='
				<table id="table_import" bgcolor="#eeeeee"> 
					<tr class="'.$class_import.'"> 			
					<td width="361" >'.$nom.'</td> 
					<td width="361">'.$ville.'</td> 
					</tr> 
				</table>
			';*/
			} $nligne++;
		}
		// fermeture du fichier 
		fclose($fp); 
		//on supprime la derniere car elle est vide 
		$str.= '<br><br>Nombre de sociétés importées : '. $cpt.'<br/>';
		$str.= 'Nombre de sociétés non importées (en double): '. $cptNon.'<br/>';	
	}
	return $str;
}

function datefr($date_sql) {
	return date('d-m-Y h:i:s', strtotime($date_sql));
}

function datefrFrancaise($date_sql) {
	return date('d/m/Y H:i', strtotime($date_sql));
}

function datefrFrancaiseReduite($date_sql) {
	return date('d/m/y H:i', strtotime($date_sql));
}

function datefrSansHeure($date_sql) {
	return date('d/m/Y', strtotime($date_sql));
} 
function datefrFrancaiseAvecA($date_sql) {
	return date('d/m/Y à H:i', strtotime($date_sql));
}
function HeurefrFrancaise($date_sql) {
	return date('H:i', strtotime($date_sql));
}

function dateFrancaiseLitterale($date_sql){

if (setlocale(LC_TIME, 'fr_FR') == '') {
    setlocale(LC_TIME, 'FRA');  //correction problème pour windows
    $format_jour = '%#d';
} else {
    $format_jour = '%e';
}

return strftime("%A $format_jour %B %Y", strtotime($date_sql));
// affiche : vendredi 18 avril 2008
//echo strftime("%a $format_jour %b %Y", strtotime('2008-04-18'));
// affiche : ven. 18 avr. 2008 
}
function find_file($dirs,$filename,$exact=false){
 
    $dir = @scandir($dirs);
    if(is_array($dir) AND !empty($dir)){
    foreach($dir as $file){
    if(($file !== '.') AND ($file!=='..')){
    if (is_file($dirs.'/'.$file)){
        $filepath =  realpath($dirs.'/'.$file);
 
        if(!$exact){
            $pos = strpos($file,$filename);
            if($pos === false) {
            }
            else {
                if(file_exists($filepath) AND is_file($filepath)){
                echo str_replace($filename,'<span style="color:red;font-weight:bold">'.$filename.'</span>',$filepath).' ('.round(filesize($filepath)/1024).'kb)<br />';
                }
            }
        }
        elseif(($file == $filename)){
 
            if(file_exists($filepath) AND is_file($filepath)){
                echo str_replace($filename,'<span style="color:red;font-weight:bold">'.$filename.'</span>',$filepath).' ('.round(filesize($filepath)/1024).'kb)<br />';
            }
        }
    }
    else{
        find_file($dirs.'/'.$file,$filename,$exact);
    }
    }
    }
    }
}


function ImageRedim($fichier_origine,$largeur_demande, $hauteur_demande, $fichier_resultat) // on ne fixe que la largeur
{

	// Calcul des nouvelles dimensions
	list($largeur_origine, $hauteur_origine) = getimagesize($fichier_origine);
	$hauteur_temporaire = round(($largeur_demande * $hauteur_origine) / $largeur_origine);
    if ($hauteur_temporaire <$hauteur_demande){
	  $largeur_finale = round(($hauteur_demande * $largeur_origine) / $hauteur_origine);
	 // echo 'largeur_finale ::: '.$largeur_finale.'-'.;
	  $hauteur_finale =  $hauteur_demande;
	}else{
	  $largeur_finale = $largeur_demande;
	  $hauteur_finale = $hauteur_temporaire;
	}
	//echo 'largeur_finale : '.$largeur_finale.'  - $hauteur_finale : '.$hauteur_finale.' <br/> largeurdemande : '. $largeur_demande. ' hauteur_demande : '.$hauteur_demande;
	$image_p = imagecreatetruecolor($largeur_finale, $hauteur_finale);
	$image_finale = imagecreatetruecolor($largeur_demande, $hauteur_demande);
    $blanc = imagecolorallocate($image_p, 250, 250, 250);
	 imagecolortransparent ($image_p,$blanc);
	 imagecolortransparent ($image_finale,$blanc);
    //imagefill($image_p, 0, 0, $blanc);
	imagefilledrectangle($image_p, 0, 0, $largeur_finale, $hauteur_finale, $blanc);	
	$image = imagecreatefromjpeg($fichier_origine);
	//$image = imagecreatefrompng($fichier_origine);
	//http://www.siteduzero.com/tutoriel-3-14597-creer-des-images-en-php.html
	//$ecart=($hauteur_finale-$hauteur_demande) / 2;
	//if ($ecart >=0) imagecopyresampled($image_p, $image, 1, 1, 0, $ecart, $largeur_finale-2, $hauteur_demande-2, $largeur_origine, ($hauteur_origine-$ecart));
	//else {		
	imagecopyresampled($image_p, $image, 1, 1, 0, 0, $largeur_finale-2, $hauteur_finale-2, $largeur_origine, $hauteur_origine);
	imagecopy($image_finale, $image_p, 0, 0, 0, 0, $largeur_demande, $hauteur_demande);
	//}
	// Affichage
	imagejpeg($image_finale, $fichier_resultat, 100);

}

//imagecopy($dest, $src, 0, 0, 20, 13, 80, 40);

function supprimer_repertoire($dir) {

 
  $current_dir = opendir($dir); 
  while($entryname = readdir($current_dir))  
  {  
	   if(is_dir("$dir/$entryname") and ($entryname != "." and $entryname!=".."))  
	   { 
	   supprimer_repertoire("${dir}/${entryname}"); 
	   }  
	   elseif($entryname != "." and $entryname!="..") 
	   { 
	   unlink("${dir}/${entryname}"); 
	   } 	  
	  } //Fin tant que   
	  closedir($current_dir); 
	  rmdir(${dir}); 

} 

function ScanDirectory($Directory){
  $MyDirectory = opendir($Directory) or die('Erreur : répertoire non trouvé : '.$Directory);
	while($Entry = @readdir($MyDirectory)) {
		if(is_dir($Directory.'/'.$Entry)&& $Entry != '.' && $Entry != '..') {
                         echo '<ul>'.$Directory;
			ScanDirectory($Directory.'/'.$Entry);
                        echo '</ul>';
		}
		else {
			echo '<li>'.$Entry.'</li>';
                }
	}
  closedir($MyDirectory);
}
function ParcourirLesImagesDuReperoire($rep){
    $rep=$rep.'/files/';
    $Myrep = opendir($rep) or die('Erreur : répertoire non trouvé : '.$rep);
	while($Entry = @readdir($Myrep)) {
		if(!(is_dir($rep.'/'.$Entry)&& $Entry != '.' && $Entry != '..')) {
            $extension=strtolower(strrchr($Entry,'.'));
			if (in_array ($extension, array ('.gif','.jpg','.jpeg','.png'))){
			   	
			  echo '<li>'.$Entry.'</li>';
			} 
        }
	}
  closedir($Myrep);			
}

function AfficherImagesDuRepertoirePourBien($rep,$img_principale){
    $repthumb=$rep.'/thumbnails/';
    $rep=$rep.'/files/';
	
    $Myrep = opendir($rep) or die('Erreur : répertoire non trouvé : '.$rep);
	echo '<ul>';
	$i=0;
	while($Entry = @readdir($Myrep)) {
		if(!(is_dir($rep.'/'.$Entry)&& $Entry != '.' && $Entry != '..')) {
            $extension=strtolower(strrchr($Entry,'.'));
			if (in_array ($extension, array ('.gif','.jpg','.jpeg','.png')) && ($img_principale!=$rep.$Entry)){
			  if ($i>3)
                echo '<li><a style="display:none" href="'.$rep.$Entry.'" class="lightbox" title=" '.GetLabelDeLaPhoto($rep.$Entry).'"><img src="'.$repthumb.$Entry.'" height="80"  alt="" /></a></li>';
              else 
			    echo '<li><a href="'.$rep.$Entry.'" class="lightbox" title=" '.GetLabelDeLaPhoto($rep.$Entry).'"><img src="'.$repthumb.$Entry.'" height="80"  alt="" /></a></li>';
			  $i++;
			} 
        }
		
	}
	echo '</ul>';
  closedir($Myrep);			
}

function AfficherImagesDuReperoire($rep){
    $repthumb=$rep.'/thumbnails/';
    $rep=$rep.'/files/';
	
    $Myrep = opendir($rep) or die('Erreur : répertoire non trouvé : '.$rep);
	echo '<ul>';
	while($Entry = @readdir($Myrep)) {
		if(!(is_dir($rep.'/'.$Entry)&& $Entry != '.' && $Entry != '..')) {
            $extension=strtolower(strrchr($Entry,'.'));
			if (in_array ($extension, array ('.gif','.jpg','.jpeg','.png'))){
			   	
			  echo '<li><a href="'.$rep.$Entry.'" class="lightbox" title=" '.GetLabelDeLaPhoto($rep.$Entry).'"><img src="'.$repthumb.$Entry.'" height="80"  alt="" /></a></li>';
			} 
        }
	}
	echo '</ul>';
  closedir($Myrep);			
}

function ParcourirLesMiniaturesDuReperoire($rep){
    $rep=$rep.'/thumbnails/';
    $Myrep = opendir($rep) or die('Erreur : répertoire non trouvé : '.$rep);
	while($Entry = @readdir($Myrep)) {
		if(!(is_dir($rep.'/'.$Entry)&& $Entry != '.' && $Entry != '..')) {
            $extension=strtolower(strrchr($Entry,'.'));
			if (in_array ($extension, array ('.gif','.jpg','.jpeg','.png'))){
			   	
			  echo '<li>'.$Entry.'</li>';
			} 
        }
	}
  closedir($Myrep);			
}
function ParcourirLesTemplates(){
    $items=array();
    if ($GLOBALS['EnDevLocal'])
      $rep=$_SERVER["DOCUMENT_ROOT"].'/'.$GLOBALS['repsite'];
	else
	  $rep=$_SERVER["DOCUMENT_ROOT"].'/'.$GLOBALS['repsite'];
	//echo 'JJJJJJJJJJJJJJ '.$_SERVER["DOCUMENT_ROOT"];
	///$items[]='JJJJJJJJJJJJJJ '.$_SERVER["DOCUMENT_ROOT"];
    $Myrep = opendir($rep) or die('Erreur : répertoire non trouvé : '.$rep);
	while($Entry = @readdir($Myrep)) {
		if(!(is_dir($rep.'/'.$Entry)&& $Entry != '.' && $Entry != '..')) {
     
			if (preg_match('`^index`', $Entry)){		   	
			  $items[]= $Entry;
			} 
        }
	}
  closedir($Myrep);		
  return  $items;
}

function advScanDir( $dir, $mode )
{
 // creation du tableau qui va contenir les elements du dossier
 $items = array();
 
 // ajout du slash a la fin du chemin s'il n'y est pas
 if( !preg_match( "/^.*\/$/", $dir ) ) $dir .= '/';
 
 // Ouverture du repertoire demande
  $handle = opendir( $dir );
 
 // si pas d'erreur d'ouverture du dossier on lance le scan
 if( $handle != false )
 {
  
  // Parcours du repertoire
  while( $item = readdir($handle) )
  {
   if($item != '.' && $item != '..')
   {
    // selon le mode choisi
    switch( $mode )
    {
     case 'DOSSIERS_SEULEMENT' :
      if( is_dir( $dir.$item ) )
       $items[] = $item;
      break;
     
     case 'FICHIERS_SEULEMENT' :
      if( !is_dir( $dir.$item ) )
       $items[] = $item;
      break;
     
     case  'TOUT' :
      $items[] = $item;
    
    }
   }
  }
  
  // Fermeture du repertoire
  closedir($handle);
   
  return $items;
  
 }
 else return false;
  
}

function PrixFormate($LePrix){
return number_format($LePrix, 0, '', ' ');
}

function MiniatureDeLImage($lien_image){
 if ($lien_image=='')
   return  'photos/defaut.jpg';
 else
   return str_replace('files', 'thumbnails',$lien_image);
}

function GenereURLREWRITING(){
	$codeConstant='
	#Options +FollowSymLinks 
	RewriteEngine On';

	$codeConstant.='
	RewriteCond %{HTTP_HOST} ^www\.'.$GLOBALS['urlPourHtAccess'].'(.*)$ [NC]
    RewriteRule (.*) '.$GLOBALS['urlSite'].'/$1 [R=301,L]
	ErrorDocument  404  '.$GLOBALS['urlSite'].'
    ErrorDocument  403  '.$GLOBALS['urlSite'].'
	#RewriteRule ^index\.php$ '.$GLOBALS['urlSite'].' [QSA,L,R=301]
	RewriteRule ^bien-([0-9]+).php$ bien.php?bien=$1 [L]
	RewriteRule ^vente-bien-([0-9]+).php$ bien.php?bien=$1 [L]
	RewriteRule ^location-bien-([0-9]+).php$ bien.php?bien=$1 [L] 
	RewriteRule ^vente-([a-zA-Z\-]+)-bien-([0-9]+).php$ bien.php?bien=$2 [L]
	RewriteRule ^location-([a-zA-Z\-]+)-bien-([0-9]+).php$ bien.php?bien=$2 [L]
    
    	' ;
	//echo dirname(__FILE__)."/.htaccess";
	$fp = fopen(dirname(__FILE__)."/.htaccess","w" ); // ouverture du fichier en écriture
	fputs($fp, "$codeConstant" );

	foreach (getListe ('page', 'ordre') as $LaPage){
	    if ($LaPage->home_page==1){		 
		  $redirection = '  DirectoryIndex '.$LaPage->zz_template.'?page='.$LaPage->id.' index.html index.php '  ;
		  fputs($fp, "\n" ); // on va a la ligne
		  fputs($fp, "$redirection" ); // on écrit la redirection dans le fichier
		}		
		else if ($LaPage->zz_url!='' && $LaPage->home_page!=1){
			$redirection = 'RewriteRule ^'.$LaPage->zz_url.'$ '.$LaPage->zz_template.'?page='.$LaPage->id.' [L] '     ;
			fputs($fp, "\n" ); // on va a la ligne
			fputs($fp, "$redirection" ); // on écrit la redirection dans le fichier
			$redirection = 'RewriteRule ^'.$LaPage->zz_url.'-([0-9]+)$ '.$LaPage->zz_template.'?page='.$LaPage->id.'&npage=$1 [L] '     ;
			fputs($fp, "\n" ); // on va a la ligne
			fputs($fp, "$redirection" ); // on écrit la redirection pour la pagination de la page
		}
	}
	foreach (getListe('redirection', 'id') as $LaRedirection){
	  $redirection = 'RewriteRule ^'.$LaRedirection->avant.'$ '.$LaRedirection->apres.' [L,R=301] '     ;
	  fputs($fp, "\n" ); // on va a la ligne
	  fputs($fp, "$redirection" ); // on écrit la redirection dans le fichier
	}
	
	fclose($fp);
}
// Génère un cryptage hash
function getHash($chaine) {
  return md5('tara!' . $chaine . '!busk');
}

function GenererZatyrzorr(){
	$codeConstant='AuthGroupFiles /dev/null' ;	
	$fp = fopen(dirname(__FILE__)."/.htaccess","a" ); 
	fputs($fp, "\n" ); 
	fputs($fp, "$codeConstant" );
	fclose($fp);
}

function EnvoyerAlertes($id_bien){
      $LeBien=getEnregistrement('bien',$id_bien);	
	  $i=0;
      if($LeBien){	     	  
	  $message_retour='';
	  foreach (ListeDesAlertesRepondantAuxCriteres($LeBien->location, $LeBien->id_type_bien, $LeBien->prix, $LeBien->id_lieu,$LeBien->surface,$LeBien->nb_pieces) as $Lalerte){
	 
		 //auth.smtp.1and1.fr port 25 -- src : http://a-pellegrini.developpez.com/tutoriels/php/mail/
			ini_set("SMTP","auth.smtp.1and1.fr") ;//$_SERVER["SERVER_ADMIN"]
			$to = $Lalerte->email;
			
			// Subject
			$subject = 'Une nouvelle annonce immobilière proposée par '.$NomDuSite;
			// Message			
			//$msg .= 'Content-type: text/html; charset=utf-8'."\r\n\r\n";			
	
			$ImageMiniature=str_replace('files','thumbnails',$LeBien->image);
		
			$msg = '		   
				<div style="padding:5px; margin:auto;width:600px; background-color:#bfd70e; border:#000000 thin solid; border-radius: 15px; -moz-border-radius: 15px;-webkit-border-radius: 15px;">     
				'.$NomDuSite.' vous propose un bien correspondant à vos critères de recherche
				<img style=""  src="'.$GLOBALS['urlSite'].$ImageMiniature.'" />';			
				
				 if($LeBien->id_type_bien!=0) $msg .= strTypeDuBien($LeBien->id_type_bien).'<br/>';
				 if($LeBien->prix!=0) $msg .=  'Prix : '.PrixFormate($LeBien->prix).' € <br/>';
				 if($LeBien->id_lieu!=0) $msg .=  'Lieu : '.NomDuLieu($LeBien->id_lieu).'<br>';
 				 if($LeBien->surface!=0) $msg .=  'Surface :'.$LeBien->surface.'m² <br/> ';
				 if($LeBien->nb_pieces!=0) $msg .=  'Nombre de pièces :'.$LeBien->nb_pieces.' <br/> ';
				 if($LeBien->description!='') $msg .=  $LeBien->description; 
				 if($LeBien->charges!='') $msg .=  'Charges : '.$LeBien->charges.'  <br/>';
				 if($LeBien->impots!=0) $msg .=  'Impôts fonciers : '.PrixFormate($LeBien->impots).' € <br/>	
                			 
				</div>		'."\r\n";	
			$msg .='div style="padding:5px; margin:auto;width:600px; background-color:#bfd70e; border:#000000 thin solid; border-radius: 15px; -moz-border-radius: 15px;-webkit-border-radius: 15px;">     
			       
					 Pour vous désinscrire des messages d\'alerte <a href="'.$GLOBALS['urlSite'].'desinscription.php?hash='.$Lalerte->hash.'">cliquez ici</a> 	
				  </div>';	
			$headers = 'From: '.$NomDuSite.' <mail@server.com>'."\r\n";		
			//$headers .= 'Bcc: Moi <moi@server.com>; lui <lui@server2.com>'."\r\n";
			$headers .= 'Mime-Version: 1.0'."\r\n";
			$headers .= 'Content-type: text/html; charset=utf-8'."\r\n";
			$headers .= "\r\n";		
			
			$EnvoiMailFailed = !mail($to, $subject, $msg, $headers);
		  if (!$EnvoiMailFailed) $i++;
		  $message_retour.='<br/>'.$Lalerte->email;
		 
		  AjouterAlerteEmail ($LeBien->id,$Lalerte->id);
		}
		AffecterDateAlerteAuBien($id_bien,$i);
		}
		return $i.' emails envoyés'.$message_retour;
	}
function URLCouranteSansParametres(){
	$urlCourante=$_SERVER["REQUEST_URI"];
	$urlGet = explode("?",$urlCourante);
	return  $urlGet[0]; 
}

function Reduire_Chaine($string, $word_limit, $lien)
{
  $string=strip_tags($string);
  $words = explode(' ', $string, ($word_limit + 1));
  if(count($words) > $word_limit){
    array_pop($words);$fin=' <a href="'.$lien.'">[...]</a>';
  }else
    $fin='';
  return implode(' ', $words).$fin;
}

function SupprimeLesAccents($mot){
    return strtr( $mot, "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ", 
                        "AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn" );
}

function ReecrireUrl($titre)
{
  // $titre= SupprimeLesAccents (strtolower($titre)); //Désaccentue le titre
   $titre=strtr( strtolower($titre), "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ", 
                        "AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn" );
   $titre= preg_replace('#[^a-z0-9_-]#','-',$titre); //Remplace tous les caractères autres que alphanumérique par des tirets
   while (strpos($titre,'--') !== false){
     $titre= str_replace('--','-',$titre); //Nettoyage des tirets superflus
   }
   return $titre;
}


function formatForUrl($texte)
{
    /* suppression des espaces en début et fin de chaîne*/
    $texte = trim($texte);
 
    /* suppression des accents, tréma et cédilles + qlq autres car. spéciaux */
    $aremplacer = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞ
    ßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿ&#340;&#341;';
    $enremplacement = 'aaaaaaaceeeeiiiidnoooooouuuuy
    bsaaaaaaaceeeeiiiidnoooooouuuyybyrr';
    $texte = utf8_decode($texte);    
    $texte = strtr($texte, utf8_decode($aremplacer), $enremplacement);

    /* mise en minuscule */
    $texte = strtolower($texte);

    /* suppression des espaces et car. non-alphanumériques */
    $texte = str_replace(" ",'-',$texte);
    $texte = preg_replace('#([^a-z0-9-_])#','-',$texte);

    /* suppression des tirets multiples */
    $texte = preg_replace('#([-]+)#','-',$texte);

/* ici vous pouvez couper les tirets de début et fin de chaine */
/* voir : http://blog.darklg.fr/94/nettoyer-une-chaine-pour-une-url-en-php/ */

    return $texte;
}

function URLdesBiens ($LeBien){
    $type=ReecrireUrl(strTypeDuBien($LeBien->id_type_bien));
	if ($type!='')$type.='-';
	if ($LeBien->location){
	  return 'location-'.$type.'bien-'.$LeBien->id.'.php';
	}else{
	  return 'vente-'.$type.'bien-'.$LeBien->id.'.php';
	}
}
function AfficherTemperature($temperature){
		       switch ($temperature)
				{
					case 'chaud': $couleur=red;break;
					case 'tiede': $couleur=orange;break;						
					case 'froid': $couleur=blue;	break;						
					default: $couleur=white;
					break;
				}
				return '<div id="div_temp" title="'.$temperature.'" style="background:'.$couleur.'"> </div>';
		} 

?>
