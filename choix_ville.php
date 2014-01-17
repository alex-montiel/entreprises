<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<?php
	include("include/connex.inc.php");

	
?>


<title>Choix d'une ville</title>

<script type="text/javascript">
function afficheVille(ville) {
	
	parent.document.getElementById('ville').value = ville;
	parent.Shadowbox.close();
}

</script>

</head>

<body>
<?php

//test de l'arrivé du cp par la méthode GET



if(!isset($_GET['codepostal']))
{
	echo "<script type=text/javascript>";
	echo "alert('Le code postal ne passe pas...') </script>";
}
else
{
	//on sécurise le code postal
	$cp = $_GET['codepostal'];
	
	//requete pour appeler les différentes villes
	
	$requete = "SELECT nom FROM ville_cp WHERE cp = '".$cp."'";
	$return =@ mysql_query($requete);
	while($donnees =mysql_fetch_array($return))
	{
		echo ("<p onclick=\"afficheVille('".$donnees['nom']."')\">".$donnees['nom']."</p>");
	}
	
	
}

?>

</body>
</html>