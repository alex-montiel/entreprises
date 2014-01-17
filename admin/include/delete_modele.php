<?php
include '../../include/myparam.inc.php';
include '../../include/connex.inc.php';

if (isset($_POST['id_modele']) && $_POST['id_modele'] != ""){
	try {
		$query = "DELETE FROM modele WHERE id_modele = '".$_POST['id_modele']."'";
		mysql_query($query);
		
		header("Location: ../afficher_profil.php?requete=modele");
	}
	catch (Exception $e) {
		echo $e->getMessage();
	}
}
