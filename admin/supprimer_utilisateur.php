<?php 
session_start();
include("../include/connex.inc.php");


if($_POST['nego_supprimer'] != '' && $_POST['next_nego'] != '')
{
	$nego_supprimer = $_POST['nego_supprimer'];
	$next_nego = $_POST['next_nego'];
	
	$requete = "DELETE FROM utilisateur WHERE id_utilisateur = ".$nego_supprimer;
	$return = mysql_query($requete);
	if(!$return)
	{
		$_SESSION['info'] = "Une erreur s'est produite".mysql_error();
	}
	else
	{
		$requete = "SELECT nom_utilisateur FROM utilisateur WHERE id_utilisateur=".$next_nego;
		$return = mysql_query($requete);
		$donnees = mysql_fetch_array($return);
		
		//$requete = "UPDATE offre SET id_utilisateur = '$next_nego', suivi = '".$donnees['nom_utilisateur']."'  WHERE id_utilisateur=".$nego_supprimer;
		$requete = "UPDATE offre SET id_utilisateur = '$next_nego' WHERE id_utilisateur=".$nego_supprimer;
		$return = mysql_query($requete);
		if(!$return)
		{
			$_SESSION['info'] = "Une erreur s'est produite".mysql_error();
		}
		else
		{
			$_SESSION['info'] = "L'utilisateur a bien été supprimer.";
		}	
	}
}
else
{
	$_SESSION['info'] = "Veuillez choisir un négociateur pour les transferts des données!";

}
header("Location:afficher_profil.php?requete=utilisateur&id_utilisateur=".$_POST['nego_supprimer']);
?>