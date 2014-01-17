<?php
	session_start();
	include('../include/connex.inc.php');

	if(isset($_POST['start']))
	{	
		$id = "\N";
		$start = new DateTime($_POST['start']);
		$end = new DateTime($_POST['end']);
		$title = $_POST['title'];
		$body = $_POST['body'];
		
		$requete = "INSERT INTO evenements (id_evenement, debut, fin, titre, commentaire, id_utilisateur) 
							VALUES ('$id', '".$start->format('Y-m-d H:i:s')."', '".$end->format('Y-m-d H:i:s')."', '$title', '$body', '".$_SESSION['id']."')";
		$return = mysql_query($requete) or die(mysql_error());
		
		if(!$return)
		{
			echo("erreur");
		}
	}
?>