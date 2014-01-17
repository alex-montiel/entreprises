<?php
	session_start();
	
	include("../include/connex.inc.php");
	
	if(isset($_POST['telephone']) && isset($_POST['portable']) && isset($_POST['mail']))
	{
		$id_utilisateur = $_SESSION['id'];
		$telephone = $_POST['telephone'];
		$portable = $_POST['portable'];
		$mail = $_POST['mail'];
		
		$requete = "UPDATE utilisateur 
					SET tel_utilisateur = '$telephone', 
						portable_utilisateur = '$portable',
						mail_utilisateur = '$mail'
					WHERE id_utilisateur =".$id_utilisateur;
		$return = mysql_query($requete);
		
		if(!$return)
		{
			echo "Une erreur s'est produite: ".mysql_error();
		}
		else
		{
			header("Location:../index.php");
			$_SESSION['info'] = "Votre Profil é bien était mis é jour.";
		}
	}
	
	


?>