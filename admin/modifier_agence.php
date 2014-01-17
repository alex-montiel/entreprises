<?php
session_start();
include("../include/connex.inc.php");

if(isset($_POST['id_agence']))
{
	$id_agence = $_POST['id_agence'];
	$nom = $_POST['nom'];
	$adresse = $_POST['adresse'];
	$cp = $_POST['cp'];
	$ville = $_POST['ville'];
	$tel = $_POST['tel'];
	$mail = $_POST['mail'];
	
	$requete = "UPDATE agence
				SET nom_agence = '$nom', adresse_agence='$adresse', cp_agence='$cp', ville_agence='$ville', tel_agence='$tel', mail_agence='$mail'
				WHERE id_agence =".$id_agence;
	$return = mysql_query($requete);
	if(!$return)
	{
		$_SESSION['info'] = "Une erreur s'est produite: ".mysql_error();
	}
	else
	{
		$_SESSION['info'] = "L'agence est modifiée";
	}
	header("Location:afficher_profil.php?requete=agence&id_agence=".$id_agence);
}
else
{
	header("Location:afficher_profil.php?requete=agence");
}


?>