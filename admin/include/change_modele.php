<?php
include '../../include/connex.inc.php';
include '../../include/myparam.inc.php';

if (isset($_POST['id_modele']) && $_POST['id_modele'] != ""){
	// UPDATE
	try {
		$stringUpdateTxt = "UPDATE modele SET 
		 type_modele = '".$_POST['type_modele']."', 
		 table_modele = '".$_POST['table']."',
		 cle_table_modele = '".$_POST['cle_table_modele']."',
		 texte_modele = '" . $_POST['content'] . "',
		 nom_modele = '".$_POST['nom_modele']."'
		 WHERE id_modele='".$_POST['id_modele']."'";
		$reqUpdateTxt = mysql_query($stringUpdateTxt) or die(mysql_error());
		
		header("Location: ../afficher_profil.php?requete=modele");
	}
	catch (Exception $e) {
		echo $e->getMessage();
	}
}
else{	
	// INSERT
	try {
		$stringUpdateTxt = "INSERT INTO modele() VALUES(
		 '',
		 '".$_POST['type_modele']."', 
		 '".$_POST['table']."',
		 '".$_POST['cle_table_modele']."',
		 '".$_POST['nom_modele']."',
		 '".$_POST['content']."'
		)";
		$reqUpdateTxt = mysql_query($stringUpdateTxt) or die(mysql_error());
		
		header("Location: ../afficher_profil.php?requete=modele");
	}
	catch (Exception $e) {
		echo $e->getMessage();
	}
}