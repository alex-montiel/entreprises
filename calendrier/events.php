<?php
	include("../include/connex.inc.php");
	
	$requete = "SELECT *
	 FROM contact, evenements INNER JOIN typedetache ON evenements.tache = typedetache.tache
	 WHERE contact.id_contact = evenements.id_contact
	 AND typedetache.emplacement = 'calendrier'
	 AND effectue = 0 AND id_utilisateur = ".$_GET['id_utilisateur'];
	$return = mysql_query($requete);
	while($donnees = mysql_fetch_array($return))
	{
		$start = new DateTime($donnees['debut']);
		$end = new DateTime($donnees['fin']);
		$tableau[] = array(
						'id' => $donnees['id_evenement'],
						'title' => $donnees['tache']." avec ".$donnees['nom_contact'],
						'start' => $start->format('Y-m-d\TH:i:sO'),
						'end' => $end->format('Y-m-d\TH:i:sO'),
						'body' => $donnees['commentaire'],
						'type' => "visite",
						'status' => $donnees['status']
					);
	}
	
	$requete = "SELECT *
	 FROM evenements
	 WHERE tache = 'Calendrier'
	 AND effectue = 0 AND id_utilisateur = ".$_GET['id_utilisateur'];
	$return = mysql_query($requete);
	while($donnees = mysql_fetch_array($return))
	{
		$start = new DateTime($donnees['debut']);
		$end = new DateTime($donnees['fin']);
		$tableau[] = array(
						'id' => $donnees['id_evenement'],
						'title' => $donnees['titre'],
						'start' => $start->format('Y-m-d\TH:i:sO'),
						'end' => $end->format('Y-m-d\TH:i:sO'),
						'body' => $donnees['commentaire'],
						'type' => "events",
						'status' => $donnees['status']
					);
	}
	
	
	echo json_encode($tableau);
?>
