<?php

	//connexion à la base de données
	include("../include/connex.inc.php");
	include("../include/myparam.inc.php");

	
	$id_photo = $_GET['id_photo'];
	
	$requete = "SELECT * FROM offre_photo WHERE id_photo=".$id_photo;
	$return = mysql_query($requete);
	$photo = mysql_fetch_array($return);
	
	$requete = "DELETE FROM offre_photo WHERE id_photo=".$id_photo;
	$return = mysql_query($requete);
	
	$supprim = unlink($rep_upload.$photo['nom_photo']);
	
	if($supprim == 1 && $return == 1)
	{
		echo $photo['nom_photo'];
	}
	else
	{
		echo("erreur");
	}
	


?>