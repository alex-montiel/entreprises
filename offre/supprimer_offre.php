<?php

include("../include/connex.inc.php");
include("../include/myparam.inc.php");


if($_GET[id]!='')	//si l'id recu n'est pas nul
{
	$id_offre = $_REQUEST[id];
	$requete = "DELETE FROM offre WHERE id_offre =".$id_offre;
	mysql_query($requete);
	$requete = "DELETE FROM offre_surface WHERE id_offre =".$id_offre;
	mysql_query($requete);
	
	$requete = "SELECT nom_photo FROM offre_photo WHERE id_offre=".$id_offre;
	$return = mysql_query($requete);
	
	while($photo = mysql_fetch_array($return))
	{
		unlink($rep_upload.$photo['nom_photo']);
	}
	
	$requete = "DELETE FROM offre_photo WHERE id_offre=".$id_offre;
	$return = mysql_query($requete);
	
}

?>