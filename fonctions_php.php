<?php

require_once('constantes.php');

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
	$image_p = imagecreatetruecolor($largeur_finale, $hauteur_finale);
	$image_finale = imagecreatetruecolor($largeur_demande, $hauteur_demande);
    $blanc = imagecolorallocate($image_p, 250, 250, 250);
	 imagecolortransparent ($image_p,$blanc);
	 imagecolortransparent ($image_finale,$blanc);
    //imagefill($image_p, 0, 0, $blanc);
	imagefilledrectangle($image_p, 0, 0, $largeur_finale, $hauteur_finale, $blanc);	
	$image = imagecreatefromjpeg($fichier_origine);	
	imagecopyresampled($image_p, $image, 1, 1, 0, 0, $largeur_finale-2, $hauteur_finale-2, $largeur_origine, $hauteur_origine);
	imagecopy($image_finale, $image_p, 0, 0, 0, 0, $largeur_demande, $hauteur_demande);
	imagejpeg($image_finale, $fichier_resultat, 100);

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
