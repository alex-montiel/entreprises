<?php
	include('../include/connex.inc.php');

	if(isset($_POST['id']))
	{
		
		$id = $_POST['id'];
		$start = $_POST['start'];
		$end = $_POST['end'];
		$title = $_POST['title'];
		$body = $_POST['body'];
		
		$requete = 'UPDATE evenements SET debut = "'.$start.'",
										  fin = "'.$end.'",
										  titre = "'.$title.'",
										  commentaire = "'.$body.'"
										  WHERE id_evenement = '.$id;
		$return = mysql_query($requete);
		if(!$return)
		{
			echo mysql_error();
		}

	}

?>