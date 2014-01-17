<?php
session_start();
include("../include/connex.inc.php");

if($_POST['id_utilisateur'] != '')
{
	$id_utilisateur = $_POST['id_utilisateur'];
	$agence = $_POST['agence'];
	$status = $_POST['status'];
	$nom = $_POST['nom'];
	$prenom = $_POST['prenom'];
	$login = $_POST['login'];
	$telephone = $_POST['telephone'];
	$portable = $_POST['portable'];
	$mail = $_POST['mail'];	
	
	$requete="UPDATE utilisateur 
				SET id_agence = '$agence',
					status_utilisateur = '$status',
					nom_utilisateur = '$nom',
					prenom_utilisateur = '$prenom',
					login_utilisateur = '$login',
					tel_utilisateur = '$telephone',
					portable_utilisateur = '$portable',
					mail_utilisateur = '$mail'
				WHERE id_utilisateur = '$id_utilisateur'";
	$return = mysql_query($requete);
	
	if(!$return)
	{
		$_SESSION['info'] = "Une erreur s'est produite: ".mysql_error();
	}
	else
	{
		$_SESSION['info'] = "L'utilisateur est bien modifié.";
	}
	header("Location:afficher_profil.php?requete=utilisateur&id_utilisateur=".$id_utilisateur);

}



?>