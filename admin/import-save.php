
<?php
//__________________________________________________________________________________________
/*  echo '<div  id="fichier_csv">';
  $fichier='../fichier.csv';
if (file_exists($fichier))
{
	//On l'ouvre en mode "read only"
	$fp = fopen($fichier, 'r');
	//On va générer l'affichage sous forme de tableau
	echo '<table>';
	//Tant que l'on n'a pas fini de lire le fichier
	while (!feof($fp)){
	echo '<tr>';
	//On lit les 4096 caractères de la ligne
	$ligne = fgets($fp,4096);
	// On met dans un tableau toutes les données, séparées par des points virgules 
	$liste = explode(';',$ligne);
	// On crée une colonne contenant les données pour chacune d'entre elles en parsant le tableau 
	foreach($liste as $element)
	{
	echo '<td>' . trim($element) . '</td>';
	}
	echo "</tr>";
	}
	//On ferme le fichier et la balise de tableau
	echo '</table>';
	fclose($fp);
}
else
echo "Fichier introuvable !";
echo '</div>';*/
//-------------------------------------------------------------------------------------------------
?>
<div id="div_import">
<form method="post" name="fomulaire_import" id="fomulaire_import"enctype="multipart/form-data" action="#"> 
	Selectionner votre fichier *.csv :
	<input type="file" name="userfile" value="userfile"/>
	<input type="submit" value="Envoyer" name="envoyer"> 	
</form> 

<?php 
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
<p align="center" >- Importation échouée -</p> 
<p align="center" ><B>Désolé, mais vous n'avez pas spécifié de chemin valide ...</B></p> 
<?php 
exit(); 
} 
// declaration de la variable "cpt" qui permettra de conpter le nombre d'enregistrement réalisé 
$cpt=0; 
?> 
<p align="center">- Importation Réussie -</p> 
<p align="right"><a href="#bas">Bas de page</a></p> 

<?php 
// importation 
echo $fp.'iitttttttttttttttttti';
if ($fp){ echo 'kkk';
	while (!feof($fp)) 
	{ 
		$ligne = fgets($fp,4096); 
		// on crée un tableau des élements séparés par des points virgule 
		$liste = explode(";",$ligne); 
		// premier élément 
		$liste[0] = ( isset($liste[0]) ) ? $liste[0] : Null; 
		$liste[1] = ( isset($liste[1]) ) ? $liste[1] : Null; 
		$liste[2] = ( isset($liste[2]) ) ? $liste[2] : Null; 

		$champs1=$liste[0]; 
		$champs2=$liste[1]; 
		$champs3=$liste[2]; 

		// pour eviter qu un champs "nom" du fichier soit vide 
		if ($champs1!='') 
		{ 
		// nouvel ajout, compteur incrémenté 
		$cpt++; 
		// requete et insertion ligne par ligne 
		// champs1 id en general dc on affecte pas de valeur 
		mysql_query("INSERT INTO essai(champs1, champs2, champs3) VALUES('$champs1','$champs2','$champs3' )"); 
		$dep="dep"; 
		mysql_query("DELETE FROM essai WHERE (dep='$dep')"); 
		?> 
		<table bgcolor="#eeeeee"> 
			<tr> 
			<td width="124">Eléments importés :</td> 
			<td width="361"><?php echo $liste[0];?></td> 
			<td width="361"><?php echo $liste[1];?></td> 
			</tr> 
		</table> 
		<?php 
		} 
	} 

	// fermeture du fichier 
	fclose($fp); 
	//on supprime la derniere car elle est vide 
}

//================== 
// FIN 
//================== 
?> 
<br><br>Nombre de valeurs nouvellement enregistrées: <b><?php echo $cpt;?>
<div>