<?php

include('../include/connex.inc.php');


if(isset($_POST['id']))
	{	
		$id = $_POST['id'];
		$requete = "DELETE FROM evenements WHERE id_event = '$id'";
		$return = mysql_query($requete);
		if(!$return)
		{
			echo mysql_error();
		}
	}

?>