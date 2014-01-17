<?php
	include("../include/connex.inc.php");

	
	if(isset($_POST['id']))
	{
		$id_tache = $_POST['id'];
		$effectue = $_POST['effectue'];
		
		$requete = "UPDATE evenements SET effectue = '$effectue' WHERE id_evenement = '$id_tache'";
		$return = mysql_query($requete);
		
		if(!$return)
		{
			echo mysql_error();
		} 
		
	}
?>