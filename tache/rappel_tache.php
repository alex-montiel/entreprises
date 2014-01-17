<?php
	include("../include/connex.inc.php");
	
	if(isset($_GET['id_evenement']))
	{
		$id = $_GET['id_evenement'];
		
		$requete = "SELECT * FROM evenements E, contact C WHERE id_evenement = ".$id." AND E.id_contact = C.id_contact";
		$return = mysql_query($requete) or die(mysql_error());
		
		$tableau = array();
		while($donnees = mysql_fetch_array($return))
		{
			$time_start_tache = new DateTime($donnees['debut']);
			$time_end_tache = new DateTime($donnees['fin']);
				
			$date = new DateTime($donnees['debut']);
			$date = $date->format("d/m/Y");
	
			$tableau[] = array(
							'type_tache' => $donnees['tache'],
							'date_start_tache' => $donnees['debut'],
							'comm_tache' => $donnees['commentaire'],
							'date_start_tache' => $date,
							'visiteur_id' => $donnees['id_contact'],
							'visiteur' => $donnees['nom_contact'],
							'status' => $donnees['status'],
							'time_start_tache' => $time_start_tache->format('H:i'),
							'time_end_tache' => $time_end_tache->format('H:i')
						);
		}
		echo json_encode($tableau);
	}
	
	
?>
