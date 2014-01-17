<?php
session_start();
include("../include/connex.inc.php");

function checkmdp($mdp)
	{
		if($mdp == '')
		{
			$_SESSION['info'] = "Le mot de passe est vide.";
			return 'empty';
		}
		elseif(strlen($mdp) < 6) 
		{
			$_SESSION['info'] = "Le mot de passe doit faire au moins 6 caractéres.";
			return 'tooshort';
		}
		elseif(strlen($mdp) > 50)
		{
			$_SESSION['info'] = "Le mot de passe doit faire moins de 50 caractéres.";
			return 'toolong';
		}
		else
		{
			if(!preg_match('#[0-9]{1,}#', $mdp))
			{
				$_SESSION['info'] = "Le mot de passe doit contenir au moins un nombre.";
				return 'nofigure';
			}
			else if(!preg_match('#[A-Z]{1,}#', $mdp))
			{
				$_SESSION['info'] = "Le mot de passe doit contenir au moins une masjuscule.";
				return 'noupcap';
			} 
			else return 'ok';
		}
	}
	
function checklogin($log)
{
	if($log == "")
	{
		$_SESSION['info'] = "Le login est pas renseigné!";
		return "vide";	
	}
	
	
	$requete = "SELECT login_utilisateur FROM utilisateur";
	$retour = mysql_query($requete);
	
	while($donnees = mysql_fetch_array($retour))
	{
		if($log == $donnees['login_utilisateur'])
		{
			$_SESSION['info'] = "Le login existe déjé!";
			return 'existant';
		}
	}
	return 'ok';
}


if(isset($_POST['login']) && isset($_POST['mdp']))
{
	if(checklogin($_POST['login']) != "ok" || checkmdp($_POST['mdp']) != "ok")
	{
		header("Location:afficher_profil.php?requete=utilisateur");
	}
	else
	{
		$agence = $_POST['agence'];
		$status = $_POST['status'];
		$nom = $_POST['nom'];
		$prenom = $_POST['prenom'];
		$login = $_POST['login'];
		$mdp = md5($_POST['mdp']);
		$telephone = $_POST['telephone'];
		$portable = $_POST['portable'];
		$mail = $_POST['mail'];
		
		$requete = "INSERT INTO utilisateur (id_agence, login_utilisateur, mdp_utilisateur, status_utilisateur, nom_utilisateur, prenom_utilisateur, tel_utilisateur, portable_utilisateur, mail_utilisateur)
					VALUES ('$agence', '$login', '$mdp', '$status', '$nom', '$prenom', '$telephone', '$portable', '$mail')";
		$return = mysql_query($requete);
		if(!$return)
		{
			$_SESSION['info'] = "Une erreur s'est produite: ".mysql_error();
		}
		else
		{
			$_SESSION['info'] = "Le nouvel utilisateur est bien enregistré.";
		}
		header("Location:afficher_profil.php?requete=utilisateur");
	}
}

?>