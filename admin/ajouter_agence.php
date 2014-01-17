<?php
session_start();
include("../include/connex.inc.php");

if(isset($_POST['nom']))
{
	$nom = $_POST['nom'];
	$adresse = $_POST['adresse'];
	$cp = $_POST['cp'];
	$ville = $_POST['ville'];
	$tel = $_POST['tel'];
	$mail = $_POST['mail'];
	
	$requete = "INSERT INTO agence (nom_agence, adresse_agence, cp_agence, ville_agence, tel_agence, mail_agence)
				VALUES ('$nom', '$adresse', '$cp', '$ville', '$tel', '$mail')";
	$return = mysql_query($requete);
	if(!$return)
	{
		$_SESSION['info'] = "Une erreur s'est produite: ".mysql_error();
	}
	else
	{
		$_SESSION['info'] = "L'agence est bien enregistrée.";
	}
	header("Location:afficher_profil.php?requete=agence");
}

?>