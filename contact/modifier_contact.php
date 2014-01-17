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

if(!empty($_POST['id_contact']))					
{
	//on sécurise les données transmises, avant de les injecter dans la bdd.
	
	//données du premier onglet
	$id_contact = $_POST['id_contact'];
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
	
	
	//a cause des soucis des valeurs des checkbox, a revoir.
	$investisseur = ($investisseur == ('on' OR '1')) ? 1 : 0;
	$notaire = ($notaire == ('on' OR '1')) ? 1 : 0;
	$prescripteur = ($prescripteur == ('on' OR '1')) ? 1 : 0;
	$syndic = ($syndic == ('on' OR '1')) ? 1 : 0;
	$autre = ($autre == ('on' OR '1')) ? 1 : 0;
	$demandeur = ($demandeur == ('on' OR '1')) ? 1 : 0;
	$confrere = ($confrere == ('on' OR '1')) ? 1 : 0;
	$offreur = ($offreur == ('on' OR '1')) ? 1 : 0;
	$prospect = ($prospect == ('on' OR '1')) ? 1 : 0;
	
	//données du second onglet
	
	$origine_contact = $_POST['origine_contact'];
	/*$nom2 = $_POST['nom2'];
	$societe2 = $_POST['societe2'];*/
	$accord_financier_origine = $_POST['accord_financier_origine'];
	$support_publicitaire = $_POST['support_publicitaire'];
	
	//données du troisième onglet

	$requete = "UPDATE contact
				SET	civilite = '$civilite',	
					nom_contact = '$nom_contact',
					prenom_contact = '$prenom_contact',
					adresse = '$adresse',
					suite = '$suite',
					cp = '$cp',
					ville = '$ville',
					pays = '$pays',
					societe = '$societe',
					forme_juridique = '$forme_juridique',
					capital = '$capital',
					siege = '$siege',
					fonction = '$fonction',
					observations = '$observations',
					telephone = '$telephone',
					telephone2 = '$telephone2',
					telecopie = '$telecopie',
					portable = '$portable',
					site_web = '$site_web',
					RCS = '$RCS',
					lieu_RCS = '$lieu_RCS',
					investisseur = '$investisseur',
					notaire = '$notaire',
					prescripteur = '$prescripteur',
					syndic = '$syndic',
					autre = '$autre',
					demandeur = '$demandeur',
					confrere = '$confrere',
					offreur = '$offreur',
					prospect = '$prospect',
					origine_contact = '$origine_contact',
					accord_financier_origine = '$accord_financier_origine',
					support_publicitaire = '$support_publicitaire'
				WHERE id_contact = '$id_contact'";
	$return = mysql_query($requete);
	
}
?>	
<script type="text/javascript">
	parent.Shadowbox.close();
</script>
	

	

</body>
</html>