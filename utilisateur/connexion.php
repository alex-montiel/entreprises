<?php
error_reporting(E_ALL);
session_start();

include("../include/connex.inc.php");

if(isset($_POST['login']) && isset($_POST['mdp']))
{
	if ($_POST['login'] == "")
	{
		header("Location:../accueil.php");
		exit();
	}
	else
	{
		$login = $_POST['login'];
	}
	
	if($_POST['mdp'] != "")
	{
	  //echo md5($_POST['mdp']);
		$mdp = md5($_POST['mdp']);
	}
	else
	{
		$mdp = $_POST['mdp'];
	}
	
	// Informations utilisateur
	$requete = "SELECT mdp_utilisateur, id_utilisateur, id_agence, nom_utilisateur
				FROM utilisateur
				WHERE login_utilisateur='$login'";
	$return = mysql_query($requete);
	if (mysql_errno()) {
  		echo("MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$requete\n<br>");
        } 
	$donnees = mysql_fetch_array($return);
	if($donnees['mdp_utilisateur'] == $mdp)
	{
		$_SESSION['acces'] = "oui";
		$_SESSION['login'] = $login;
		$_SESSION['id'] = $donnees['id_utilisateur'];
		$_SESSION['agence'] = $donnees['id_agence'];
		$_SESSION['nom'] = $donnees['nom_utilisateur'];
                $Nom_de_la_page="../index.php";
                //include_once "$Nom_de_la_page";
                header("Location:../index.php",false);
                exit(); 
		
	}
	else
	{
                $Nom_de_la_page="../accueil.php";
                //include_once "$Nom_de_la_page";
                header("Location:../accueil.php",false);
                exit(); 
		
	}
}

?>

