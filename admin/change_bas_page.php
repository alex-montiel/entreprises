<?php
session_start();
include("../include/connex.inc.php");

// Insertion
try {
	$stringUpdateTxt = "UPDATE infos_fiches SET texte_bas = '" . $_POST['content'] . "'";
	$reqUpdateTxt = mysql_query($stringUpdateTxt) or die(mysql_error());
	
	header('Location: afficher_profil.php');
}
catch (Exception $e) {
	echo $e->getMessage();
}

// Enleve les magic quotes
//stripslashes()