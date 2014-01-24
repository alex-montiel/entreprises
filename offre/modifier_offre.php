<?php

	include("../include/connex.inc.php");
	include("../include/myparam.inc.php");
	
	function date2mysql($date)
	{
		if($date != "")
		{
		@list($jour,$mois,$annee)=explode('/',$date);				//récupération des différentes valeurs en utilisant les / comme séparateurs
   		return @date('Y-m-d',mktime(0,0,0,$mois,$jour,$annee));		//retour de la date modifié au bon format grace à un mktime
   		}
   		else
   		{
   			return $date;
   		}
	}
	
if(!empty($_POST['classement']))					
{
	//on sécurise les données transmises, avant de les injecter dans la bdd.
	$id_offre = $_POST['id_offre'];
		//$suivi = $_POST['suivi'];
	//$mandant = $_POST['mandant'];
	//$proprietaire = $_POST['proprietaire'];
	$id_utilisateur_suivi = $_POST['id_utilisateur'];
	$id_contact_mandant = $_POST['mantant_id'];
	$id_contact_proprietaire = $_POST['proprietaire_id'];
	$classement = $_POST['classement'];
	$type_offre= $_POST['type_offre'];
	$type_transaction= $_POST['type_transaction'];
	$generalite_comm = $_POST['generalite_comm'];
	$moyens_de_visite = $_POST['moyens_de_visite'];
	$louer_vendre = $_POST['louer_vendre'];
	$locaux = $_POST['locaux'];
	$nbre_surface = $_POST['nbre_surface'];
	$nbre_photo = $_POST['nbre_photo'];
	$surface_total = $_POST['surface_total'];
	$divisible = $_POST['divisible'];
	$zone_activite = $_POST['zone_activite'];
	$secteur_geo = $_POST['secteur_geo'];
	$adresse = $_POST['adresse'];
	$suite = $_POST['suite'];
	$code_postal = $_POST['cp'];
	$ville = $_POST['ville'];
	$pays = $_POST['pays'];
	$qualite_emplacement = $_POST['qualite_emplacement'];
	$descriptif = $_POST['descriptif'];
	$equipement = $_POST['equipement'];
	$etat = $_POST['etat'];
	$standing = $_POST['standing'];
	$acces = $_POST['acces'];
	$desserte = $_POST['desserte'];
	$date_bail = date2mysql($_POST['date_bail']);		//convertion de la date grâce à la fonction date2mysql
	$regime_fiscal = $_POST['regime_fiscal'];
	$type_bail = $_POST['type_bail'];
	$garantie = $_POST['garantie'];
	$location_notes = $_POST['location_notes'];
	$location_comm = $_POST['location_comm'];
	$date_dispo_location = date2mysql($_POST['date_dispo_location']);	//convertion de la date grâce à la fonction date2mysql
	$duree = $_POST['duree'];
	$loue_par = $_POST['loue_par'];
	$pas_de_porte = $_POST['pas_de_porte'];
	$loyer_annuel = $_POST['loyer_annuel'];
	$provision_location = $_POST['provision_location'];
	$paiement = $_POST['paiement'];
	$loyer_mensuel = $_POST['loyer_mensuel'];
	$loyer_m2 = $_POST['loyer_m2'];
	$impot_foncier = $_POST['impot_foncier'];
	$impot_locataire = $_POST['impot_locataire'];
	$impot_proprio = $_POST['impot_proprio'];
	$autres_taxes = $_POST['autres_taxes'];
	$notes_vente = $_POST['notes_vente'];
	$comm_vente = $_POST['comm_vente'];
	$date_dispo_vente = date2mysql($_POST['date_dispo_vente']);			//convertion de la date grâce à la fonction date2mysql
	$prix_murs = $_POST['prix_murs'];
	$tva_murs = $_POST['tva_murs'];
	$prix_fond_commerce = $_POST['prix_fond_commerce'];
	$prix_m2 = $_POST['prix_m2'];
	$provision_vente = $_POST['provision_vente'];
	$impot_foncier_vente = $_POST['impot_foncier_vente'];
	$autres_taxes_vente = $_POST['autres_taxes_vente'];
	$hono_trans_location = $_POST['hono_trans_location'];
	$hono_redac_location = $_POST['hono_redac_location'];
	$hono_total_location = $_POST['hono_total_location'];
	$hono_trans_vente = $_POST['hono_trans_vente'];
	$hono_redac_vente = $_POST['hono_redac_vente'];
	$hono_total_vente = $_POST['hono_total_vente'];	
	$nbre_photo_upload = $_POST['nbre_photo_upload'];
	$mandant_id = $_POST['mandant_id'];
	$proprietaire_id = $_POST['proprietaire_id'];
	$loue_par_id = $_POST['loue_par_id'];
	$id_utilisateur = $_POST['id_utilisateur'];
	
	$divisible = ($divisible == ('on' OR '1')) ? 1 : 0;


	
	//la requete pour envoyer sur la bdd offre
	
	$requete = "UPDATE offre SET id_utilisateur_suivi='$id_utilisateur_suivi', id_contact_mandant='$id_contact_mandant', id_contact_proprietaire='$id_contact_proprietaire', classement='$classement', type_offre='$type_offre', type_transaction='$type_transaction', generalite_comm='$generalite_comm', moyens_de_visite='$moyens_de_visite', louer_vendre='$louer_vendre', locaux='$locaux', surface_total='$surface_total', divisible='$divisible', zone_activite='$zone_activite', secteur_geo='$secteur_geo', adresse='$adresse', suite='$suite', code_postal='$code_postal', ville='$ville', pays='$pays', qualite_emplacement='$qualite_emplacement', descriptif='$descriptif', equipement='$equipement', etat='$etat', standing='$standing', acces='$acces', desserte='$desserte', date_bail='$date_bail', regime_fiscal='$regime_fiscal', type_bail='$type_bail', garantie='$garantie', location_notes='$location_notes', location_comm='$location_comm', date_dispo_location='$date_dispo_location', duree='$duree', loue_par='$loue_par', pas_de_porte='$pas_de_porte', loyer_annuel='$loyer_annuel', provision_location='$provision_location', paiement='$paiement', loyer_mensuel='$loyer_mensuel', loyer_m2='$loyer_m2', impot_foncier='$impot_foncier', impot_locataire='$impot_locataire', impot_proprio='$impot_proprio', autres_taxes='$autres_taxes', notes_vente='$notes_vente', comm_vente='$comm_vente', date_dispo_vente='$date_dispo_vente', prix_murs='$prix_murs', tva_murs='$tva_murs', prix_fond_commerce='$prix_fond_commerce', prix_m2='$prix_m2', provision_vente='$provision_vente', impot_foncier_vente='$impot_foncier_vente', autres_taxes_vente='$autres_taxes_vente', hono_trans_location='$hono_trans_location', hono_redac_location='$hono_redac_location', hono_total_location='$hono_total_location', hono_trans_vente='$hono_trans_vente', hono_redac_vente='$hono_redac_vente', hono_total_vente ='$hono_total_vente', mandant_id = '$mandant_id', proprietaire_id = '$proprietaire_id', loue_par_id = '$loue_par_id', id_utilisateur = '$id_utilisateur' WHERE id_offre = $id_offre";
					
	$return = mysql_query($requete);
	
	$requete = "DELETE FROM offre_surface WHERE id_offre = '$id_offre'";
	$return = mysql_query($requete);
	
	for($i=1; $i<= $nbre_surface; $i++)
	{
		$type = $_POST['type_'.$i];
		$repere = $_POST['repere_'.$i];
		$surface = $_POST['surface_'.$i];
		$commentaire = $_POST['comm_surface_'.$i];
		$requete = "INSERT INTO offre_surface (id_offre, type, repere, surface, commentaire)
							VALUES( '$id_offre', '$type', '$repere', '$surface', '$commentaire')";
		$return =@ mysql_query($requete);
	}
	
	
	$id_photo = "\N";
	
	if($nbre_photo > $nbre_photo_upload)
	{
		for($i=$nbre_photo_upload+1; $i<= $nbre_photo; $i++)
		{
			//régularisation du nom
			$_FILES['photo'.$i]['name'] = ereg_replace("[^a-z0-9._]","", str_replace(" ","_", str_replace("%20", "_", strtolower($_FILES['photo'.$i]['name']))));
			//nouveau nom
			$photo_nom 		= $id_offre."_".$i."_".$_FILES['photo'.$i]['name'];
			//lien pour le fichier d'upload
			$upload_file	= $rep_upload.$photo_nom;
			$id_photo = "\N";
			//déplacement des fichiers, puis insertion dans la bdd
			if(move_uploaded_file($_FILES['photo'.$i]['tmp_name'], $upload_file))
			{
				$requete="INSERT INTO offre_photo (id_photo, id_offre, nom_photo) 
							VALUES('$id_photo', '$id_offre', '$photo_nom')";
				$return = mysql_query($requete);
			}
		}
	}
	
	
}
	
	


?>
<script type="text/javascript">
	//permet de fermer la fenetre contact pour revenir sur l'index
        window.close();
        var win = window.open("", "Liste des offres");
        if(win.location == "about:blank"){
            win.close();
            window.open("", "Liste des offres");
            win.location = 'index.php?requete=offre';
        }else{
            window.open("", "Liste des offres");
            win.location = 'index.php?requete=offre';
        }
</script>
