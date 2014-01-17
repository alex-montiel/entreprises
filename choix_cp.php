<!-- Page permettant l'affichage des codes postaux pour une ville -->


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Choix d'un Code Postal</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<?php
		include("include/connex.inc.php");
	?>
	
	<script type="text/javascript">
		function afficheCp(cp) {
			//insertion du code postal choisit dans le formulaire
			parent.document.getElementById('cp').value = cp;
			//fermeture de la fenetre popup
			parent.Shadowbox.close();
		}
	</script>
</head>

<body bgcolor="white">
<?php

//test de l'arrivé de la ville par la méthode GET



if(!isset($_GET['ville']))
{
	echo "<script type=text/javascript>";
	echo "alert('Une erreur s'est produite.') </script>";
}
else
{
	//on sécurise le code postal
	$ville = $_GET['ville'];
	
	//requete pour appeler les différentes villes
	
	$requete = "SELECT cp FROM ville_cp WHERE nom = '".$ville."'";
	$return =@ mysql_query($requete);
	while($donnees =mysql_fetch_array($return))
	{
		echo ("<p onclick=\"afficheCp('".$donnees['cp']."')\">".$donnees['cp']."</p>");
		//avec appelle de la fonction afficheCP onclick.
	}
	
	
}

?>

</body>
</html>