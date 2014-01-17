<!-- Script permettant l'insertion d'un nouveau contact dans la table contact de la bdd,
	 Une fois ceci fait, ce script ferme la fenetre contact pour revenir à l'index -->


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
	include("../include/connex.inc.php");
?>


<title>Ajouter un contact</title>
</head>

<body>
<?php	
if(!empty($_POST['nom_contact']))					
{
	//on sécurise les données transmises, avant de les injecter dans la bdd.
	
	//données du premier onglet
	$id_contact = "\N";				
	$civilite = $_POST['civilite'];
	$nom_contact = $_POST['nom_contact'];
	$prenom_contact = $_POST['prenom_contact'];
	$adresse = $_POST['adresse'];
	$suite = $_POST['suite'];
	$cp = $_POST['cp'];
	$ville = $_POST['ville'];
	$pays = $_POST['pays'];
	$societe = $_POST['societe'];
	$forme_juridique = $_POST['forme_juridique'];
	$capital = $_POST['capital'];
	$siege = $_POST['siege'];
	$fonction = $_POST['fonction'];
	$observations = $_POST['observations'];
	$telephone = $_POST['telephone'];
	$telephone2 = $_POST['telephone2'];
	$telecopie = $_POST['telecopie'];
	$portable = $_POST['portable'];
	$site_web = $_POST['site_web'];
	$RCS = $_POST['RCS'];
	$lieu_RCS = $_POST['lieu_RCS'];
	$investisseur = $_POST['investisseur'];
	$notaire = $_POST['notaire'];
	$prescripteur = $_POST['prescripteur'];
	$syndic = $_POST['syndicat'];
	$autre = $_POST['autre'];
	$demandeur = $_POST['demandeur'];
	$confrere = $_POST['confrere'];
	$offreur = $_POST['offreur'];
	$prospect = $_POST['prospect'];
	$id_agence = $_POST['id_agence'];
	
	//données du second onglet
	
	$origine_contact = $_POST['origine_contact'];
	/*$nom2 = $_POST['nom2'];
	$societe2 = $_POST['societe2'];*/
	$accord_financier_origine = $_POST['accord_financier_origine'];
	$support_publicitaire = $_POST['support_publicitaire'];
	
	//données du troisième onglet

	
	//crétion de la requete
	$requete = "INSERT INTO contact (id_contact, civilite, nom_contact, prenom_contact, adresse, suite, cp, ville, pays, societe, forme_juridique, capital, siege, fonction, observations, telephone, telephone2, telecopie, portable, site_web, RCS, lieu_RCS, investisseur, notaire, prescripteur, syndic, autre, demandeur, confrere, offreur, prospect, origine_contact, accord_financier_origine, support_publicitaire, id_agence) 
				VALUES(	'$id_contact', '$civilite', '$nom_contact', '$prenom_contact',
						'$adresse', '$suite', '$cp', '$ville',
						'$pays', '$societe', '$forme_juridique', '$capital', '$siege',
						'$fonction', '$observations', '$telephone', '$telephone2',
						'$telecopie', '$portable', '$site_web', '$RCS', '$lieu_RCS',
						'$investisseur', '$notaire', '$prescripteur', '$syndic',
						'$autre', '$demandeur', '$confrere', '$offreur',
						'$prospect', '$origine_contact', '$accord_financier_origine',
						'$support_publicitaire', '$id_agence')";

	//appelle mysql
	$result =@ mysql_query($requete);
}
?>	
<script type="text/javascript">
	//permet de fermer la fenetre contact pour revenir sur l'index
	parent.Shadowbox.close();
</script>
	

	

</body>
</html>