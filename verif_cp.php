<?php
	//connexion à la base de données
	include("include/connex.inc.php");
	include("include/myparam.inc.php");

	

//page php permettant la vérification du code postal fourni dans le formulaire contact
//s'il n'existe aucune ville ===> 0		retour au formulaire pour modification
// s'il existe plusieurs villes ===> 1  ouverture fenetre popup pour le choix de la ville
// s'il n'existe qu'une ligne ===> envoie du nom de la ville	insertion de la valeur dans le champ


$cp = $_GET['cp'];

$requete = $requete = "SELECT nom FROM ville_cp WHERE cp = ".$cp."";
$return = mysql_query($requete);
$nbre_ligne = mysql_num_rows($return);
$donnees = mysql_fetch_array($return);

if($nbre_ligne == 0)
{
	echo "0";
}
elseif($nbre_ligne == 1)
{
	echo $donnees['nom'];
}
else
{
	echo "1";
}
?>

