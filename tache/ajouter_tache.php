<?php
	session_start();
	include("../include/connex.inc.php");
	
	if(isset($_POST['id_offre']))
	{
		$id_offre = $_POST['id_offre'];
		//$id_contact = $_POST['id_contact'];
		$tache = $_POST['tache'];
		$date = $_POST['date'];
		$start = $_POST['start'];
		$end = $_POST['end'];
		$id_contact = $_POST['visiteur_id'];
		$visiteur = $_POST['visiteur'];
		$status = $_POST['status'];
		$commentaire = $_POST['comm'];
		
		$visiteur = $visiteur == 'Contact' ? '' : $visiteur;
		$commentaire = $commentaire == 'Commentaire' ? '' : $commentaire;
		 
		
		list($jour,$mois,$annee)=explode('/',$date);				//récupération des différentes valeurs en utilisant les / comme séparateurs
   		$date = date('Y-m-d',mktime(0,0,0,$mois,$jour,$annee));	
		
		
		if($start != '' && $start != 'heure de commencement')
		{
			$start = $date." ".$start.":00";
			
		}
		
		if($end != '' && $end != 'heure de fin')
		{
			$end = $date." ".$end.":00";
		}
		
		$requete = "INSERT INTO evenements (id_offre, id_contact, tache, status, debut, fin, commentaire, id_utilisateur) 
							VALUES ('$id_offre', '$id_contact', '$tache', '$status', '$start', '$end', '$commentaire', '".$_SESSION['id']."')";
		$return = mysql_query($requete);
		
		if(!$return)
		{
			echo "erreur";
		}
		else
		{
			echo mysql_insert_id();
		}

	}
	
?>