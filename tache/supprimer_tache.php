<?php

include("../include/connex.inc.php");


if($_POST['id_tache']!='')	//si l'id recu n'est pas nul
{
	$id_tache = $_POST['id_tache'];
	$requete = "DELETE FROM tache WHERE id_tache =".$id_tache;
	$return = mysql_query($requete);
	
	if(!$return)
	{
		echo mysql_error();
	}
}

?>