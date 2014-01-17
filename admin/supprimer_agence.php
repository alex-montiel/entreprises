<?php
session_start();
include("../include/connex.inc.php");
include("../include/myparam.inc.php");

if(isset($_POST['id_agence']))
{
	$id_agence = $_POST['id_agence'];
	
	//requete pour supprimer les utilisateurs
	
	//suppresion des utilisateurs de l'agence
	$requete = "DELETE FROM utilisateur WHERE id_agence=".$id_agence;
	$return = mysql_query($requete);
	if(!$return)
	{
		$_SESSION['info'] = "Une erreur s'est produite: ".mysql_error();
		header("Location:afficher_profil.php?requete=agence&id_agence=".$id_agence);
	}
	
	
	//recuperation des offres de l'agence
	$requete = "SELECT id_offre FROM offre WHERE id_agence=".$id_agence;
	$return = mysql_query($requete);
	if(!$return)
	{
		$_SESSION['info'] = "Une erreur s'est produite: ".mysql_error();
		header("Location:afficher_profil.php?requete=agence&id_agence=".$id_agence);
	}
	while($donnees = mysql_fetch_array($return))
	{
		//suppresion des surfaces de l'offre
		$requete="DELETE FROM offre_surface WHERE id_offre=".$donnees['id_offre'];
		$return = mysql_query($requete);
		if(!$return)
		{
			$_SESSION['info'] = "Une erreur s'est produite: ".mysql_error();
			header("Location:afficher_profil.php?requete=agence&id_agence=".$id_agence);
		}
		
		//récupération des photos de l'offre
		$requete = "SELECT nom_photo FROM offre_photo WHERE id_offre=".$donnees['id_offre'];
		$return = mysql_query($requete);
		if(!$return)
		{
			$_SESSION['info'] = "Une erreur s'est produite: ".mysql_error();
			header("Location:afficher_profil.php?requete=agence&id_agence=".$id_agence);
		}
		while($photo = mysql_fetch_array($return))
		{
			//destruction des fichiers photos
			unlink($rep_upload.$photo['nom_photo']);
		}
		
		//destruction des photo dans la bdd
		$requete = "DELETE FROM offre_photo WHERE id_offre=".$donnees['id_offre'];
		$return = mysql_query($requete);
		if(!$return)
		{
			$_SESSION['info'] = "Une erreur s'est produite: ".mysql_error();
			header("Location:afficher_profil.php?requete=agence&id_agence=".$id_agence);
		}
	}
	
	//destruction des offres dans la bdd
	$requete="DELETE FROM offre WHERE id_agence=".$id_agence;
	$return = mysql_query($requete);
	if(!$return)
	{
		$_SESSION['info'] = "Une erreur s'est produite: ".mysql_error();
	}
	
	//destruction des contacts de l'agence
	$requete="DELETE FROM contact WHERE id_agence=".$id_agence;
	$return = mysql_query($requete);
	
	//requete pour supprimer l'agence de la table
	$requete = "DELETE FROM agence WHERE id_agence=".$id_agence;
	$return = mysql_query($requete);
	if(!$return)
	{
		$_SESSION['info'] = "Une erreur s'est produite: ".mysql_error();
	}
	else
	{
		$_SESSION['info'] = "L'agence ainsi que toutes les données sont supprimées.";
	}
	
	header("Location:afficher_profil.php?requete=agence");
	
}



?>