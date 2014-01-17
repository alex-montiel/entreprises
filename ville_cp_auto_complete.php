<?php

include("include/connex.inc.php");


if($_GET['data'] == "mandant")
{
	$requete = "SELECT nom_contact FROM Contact";
	$return = mysql_query($requete);
	while($donnees = mysql_fetch_array($return))
	{
		echo $donnees['nom_contact']."\n";	
	}
}
elseif($_GET['data'] == "ville")
{
	$requete = "SELECT nom FROM ville_cp";
	$return = mysql_query($requete);
	while($donnees = mysql_fetch_array($return))
	{
		echo $donnees['nom']."\n";	
	}
}
		

?>


