<?php
	include("../include/connex.inc.php");

	
	if(isset($_POST['id_evenement']))
	{
		$id_tache =  $_POST['id_evenement'];
		$id_offre = $_POST['id_offre'];
		$id_contact = $_POST['id_contact'];
		$tache = $_POST['tache'];
		$date = $_POST['date'];
		$start = $_POST['start'];
		$end = $_POST['end'];
		$visiteur_id = $_POST['visiteur_id'];
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
		
		$requete = "UPDATE evenements SET debut = '$start', fin = '$end', commentaire = '$commentaire' WHERE id_evenement = '$id_tache'";
		
		$return = mysql_query($requete);
		
		if(!$return)
		{
			echo mysql_error();
		}
	}
	elseif(isset($_POST['id']))	//mise à jour à partir du calendrier
	{
		$id_tache =  $_POST['id'];
		$start = $_POST['start'];
		$end = $_POST['end'];
		$commentaire = $_POST['body'];
		$status = $_POST['status'];
		
		$date = new DateTime($start);
		$date = $date->format("Y-m-d");
		
		$requete = "UPDATE evenements SET debut = '$start', fin = '$end', commentaire = '$commentaire', status = '$status' WHERE id_evenement = '$id_tache'";
		$return = mysql_query($requete);
		
		if(!$return)
		{
			echo mysql_error();
		}
	}
	else
	{
		if(isset($_POST['id_evenement']))
		{
			$id_tache =  $_POST['id_evenement'];
			$date = $_POST['date'];
			$start = $_POST['start'];
			$end = $_POST['end'];
			$commentaire = $_POST['comm'];
			
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

			
			$requete = "UPDATE evenements SET debut = '$start', fin = '$end', commentaire = '$commentaire', WHERE id_evenement = '$id_tache'";
			
			$return = mysql_query($requete);
			
			if(!$return)
			{
				echo mysql_error();
			}
		}
	}
	
?>