<?php

//script permettant la suppression d'un contact

include('../include/connex.inc.php');


if($_GET[id]!='')	//si l'id recu n'est pas nul
{
	$id_contact = $_REQUEST[id];										//on sécurise l'id
	$requete = "DELETE FROM contact WHERE id_contact =".$id_contact;	//création de la requete pour la suppresion
	$return = mysql_query($requete);									//envoie de la requete
}
	
header('Location: index.php');											//redirection vers index.php
?>
