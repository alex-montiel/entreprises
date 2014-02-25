<?php
	session_start();
	include("../include/connex.inc.php");
	
	if($_SESSION['acces'] != "oui" && $_SESSION['login'] != "admin")
	{
		header("Location:../utilisateur/logout.php");			
	}
	else
	{
		$requete = "SELECT * FROM agence";
		$agence = mysql_query($requete);
		
		$requete = "SELECT * FROM utilisateur WHERE login_utilisateur != 'admin'";
		$utilisateur = mysql_query($requete);
	}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Administration de SquareEntreprise.fr</title>

        <link type="text/css" href="../include/jquery-autocomplete/jquery.autocomplete.css" rel="stylesheet" />
        
        <script type="text/javascript" src="../include/jquery.js"></script>
        <script type="text/javascript" src="../include/jquery-autocomplete/jquery.autocomplete.js"></script>
		<script type="text/javascript" src="../include/tiny_mce/tiny_mce.js"></script>
		
        <link rel="stylesheet" href="../style.css" type="text/css" media="screen" title="Normal" />


		<script type="text/javascript">
			$(window).ready(function(){
				$("#connexion").css({"margin-left": $(window).width() - $("#connexion").width() - 100});
				$("#captionTitle").css({"margin-left": $("table").width() / 2 - $("#captionTitle").width() / 2 - $("#buttons").width()});
			});
		</script>
</head>

<body>
	<h1 id="header"><span>Punfrance</span></h1>
	
	<p id="connexion">
		<?php
			if(isset($_SESSION['login']))
	      	{
	      		echo "Bonjour ".$_SESSION['login']." <a href=../index.php?requete=profil\">Profil</a>  <a href=\"../utilisateur/logout.php\">Déconnexion</a>"; 
	      		echo "<br/>".$_SESSION['info'];
	      	}
	      	$_SESSION['info'] = "";
		?>
	</p>
	
	<ul id="menuhorizontal">
		<li id="li1"><a href="afficher_profil.php?requete=utilisateur">Utilisateurs</a></li>
		<li id="li2"><a href="afficher_profil.php?requete=agence">Agences</a></li>
		<li id="li3"><a href="afficher_profil.php?requete=fiche">Fiches PDF</a></li>
		<li id="li4"><a href="afficher_profil.php?requete=modele">Modèles</a></li>
		<li id="li5" style="margin-left: 70px;"><a href="../index.php">Sortir</a></li>
	</ul>
	
	<ul id="menuvertical">
		<?php
			if(isset($_GET['requete']))
			{
				if($_GET['requete'] == "utilisateur")
				{
					echo '<li><a href="afficher_profil.php?requete=utilisateur">Ajouter un utilisateur</a></li>';
					while($donnees = mysql_fetch_array($utilisateur))
					{
						echo '<li><a href="afficher_profil.php?requete=utilisateur&id_utilisateur='.$donnees['id_utilisateur'].'">'.$donnees['login_utilisateur'].'</a></li>';
					}
				
				}
				elseif($_GET['requete'] == "agence")
				{
					echo '<li><a href="afficher_profil.php?requete=agence">Ajouter une agence</a></li>';
					while($donnees = mysql_fetch_array($agence))
					{
						echo '<li><a href="afficher_profil.php?requete=agence&id_agence='.$donnees['id_agence'].'">'.$donnees['nom_agence'].'</a></li>';
					}
				}
			
			}
		?>
		
		
	</ul>

	<div id="contenu">
		<?php
			if($_GET['id_utilisateur'])
			{
				include("utilisateur.php");
			}
			elseif($_GET['id_agence'])
			{
				include("agence.php");
			}
			
			switch ($_GET['requete']){
				case "utilisateur":
					include 'new_utilisateur.php';
					break;
				case "agence":
					include 'new_agence.php';
					break;
				case "fiche":
					include 'gestion_fiches.php';
					break;
				case "modele":
					include 'gestion_modeles.php';
					break;
			}
		?>
	</div>
</body>
</html>
