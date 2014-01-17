<?php
session_start();
include("../include/connex.inc.php");
	$day = $_POST['day'];
	if($_POST['data'] == "today")
	{
		$requete = "SELECT evenements.id_evenement
					FROM evenements INNER JOIN typedetache ON evenements.tache = typedetache.tache
					WHERE typedetache.emplacement = \"tache\" AND evenements.debut <= '$day'
					AND id_utilisateur = '".$_POST['id']."';";
	}
	else
	{
		$requete = "SELECT evenements.id_evenement
					FROM evenements INNER JOIN typedetache ON evenements.tache = typedetache.tache
					WHERE typedetache.emplacement = \"tache\" AND evenements.debut like '$day %'
					AND evenements.debut <> NOW() AND id_utilisateur = '".$_POST['id']."';";
	}
	
	$return = mysql_query($requete) or die(mysql_error());
	$nbre_tache = mysql_num_rows($return);
	echo($nbre_tache);
?>