<?php 

	// Récupère la liste des Societes à afficher
	/*
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
	$cpt=0; $cptNon=0;
	?> 
<!--	<p align="center">- Importation Réussie -</p> 
	<p align="right"><a href="#bas">Bas de page</a></p> 
-->
	<?php 
	// importation 
	if ($fp){ 
		while (!feof($fp)) 
		{ 
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

			$nom=$liste[0]; 
			$adresse=$liste[2]; 
			$cp=$liste[3]; 
			$ville=$liste[4]; 
			$telephone=$liste[5]; 
			$email=$liste[7]; 
			//*$site_web=$liste[3]; 
			//$nom_contact=$liste[3]; 
			//$prenom_contact=$liste[3]; 
			//$tel_contact=$liste[3]; 
			//$portable_contact=$liste[3]; 
			//$email_contact=$liste[3]; 
			

			// pour eviter qu un champs "nom" du fichier soit vide 
			if ($nom!='') { 				
				echo '<a href="#"> Actualiser la page </a>';
				// requete et insertion ligne par ligne 
				// champs1 id en general dc on affecte pas de valeur 
				if (!getSocieteDeNomEtDeVille(addslashes($nom), addslashes($ville))){
				  // nouvel ajout, compteur incrémenté 
				  $cpt++; 
				   Mysql::insert('societe', array(
					 'nom' => addslashes($nom),		                     
					  'adresse' => addslashes($adresse),	
					  'cp' => addslashes($cp),	  
					  'ville' => addslashes($ville),						  																 
					  'telephone' => addslashes($telephone),	  					 
					  'email' => 'email'));
				//  mysql_query("INSERT INTO societe(nom, adresse, cp, ville, telephone, email) VALUES('$nom','$adresse','$cp','$ville', '$telephone', '$email' )"); 
				//  $dep="dep"; 
				 // mysql_query("DELETE FROM essai WHERE (dep='$dep')"); 
				  $class_import="";
				}else{
				  $cptNon++;
				  $class_import="non_importe";				
				}
				
				?> 
			<!--	<table id="table_import" bgcolor="#eeeeee"> 
					<tr class="<?php// echo $class_import; ?>"> 			
					<td width="361" ><?php //echo $nom;?></td> 
					<td width="361"><?php //echo $ville;?></td> 
					</tr> 
				</table> -->
				<?php 
			} 
		} 

		// fermeture du fichier 
		fclose($fp); 
		//on supprime la derniere car elle est vide 
	//	echo '<br><br>Nombre de sociétés importées : '. $cpt.'<br/>';
	//	echo 'Nombre de sociétés non importées (en double): '. $cptNon.'<br/>';
	}
	}
	*/
$txt_info='Utilitaire d\'import fichier .csv comportant une liste de sociétés.

Organisation des colonnes : 
Colonne 1 : RAISON SOCIALE 
Colonne 1 : RAISON SOCIALE | 
Colonne 2 :  DIRIGEANT | 
Colonne 3 : ADRESSE | 
Colonne 4 : CP | 
Colonne 5 : VILLE | 
Colonne 6 : TELEPHONE | 
Colonne 7 : EMAIL | 
Colonne 8 : CODE NAF | 
Colonne 9 : LIBELLE NAF | 
Colonne 10 : RUBRIQUE PROFESSIONNELLE | 
Colonne 11 : FORME JURIDIQUE | 
Colonne 12 : STATUT ETS | 
Colonne 13 : EFFECTIF | 
Colonne 14 : DEBUT ACTIVITE';
?>

<div id="div_import" title="<?php echo $txt_info; ?>">
	<form method="post" name="fomulaire_import" id="fomulaire_import"enctype="multipart/form-data" action="#"> 
		Importer un fichier *.csv :
		<input type="file" name="userfile" value="userfile"/>
		<input type="submit" value="Importer" name="envoyer"> 	
	</form> 
</div>