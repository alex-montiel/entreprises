<?php
	//page php permettant la vérification de la ville fournie dans le formulaire contact
	//s'il n'existe aucun code postal ===> 0		retour au formulaire pour modification
	// s'il existe plusieurs codes postal ===> 1  ouverture fenetre popup pour le choix du code postal
	// s'il n'existe qu'une ligne ===> envoie du code postal pour insertion de la valeur dans le champ correspondant
	
	
	
	//connexion à la base de données
	include ("include/connex.inc.php");
	
	$ville = $_GET['ville'];
	$requete = "SELECT cp FROM ville_cp WHERE nom = '".$ville."'";
	$return = mysql_query($requete);
	$nbre_ligne = mysql_num_rows($return);
	$donnees = mysql_fetch_array($return);

	
	if($nbre_ligne == 0)
	{
		echo "0";
	}
	elseif($nbre_ligne == 1)
	{
		echo $donnees['cp'];
	}
	else
	{
		echo "1";
	}
	
	


?>