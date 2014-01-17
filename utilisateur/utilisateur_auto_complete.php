<?php
session_start();
include("../include/connex.inc.php");



$q = strtolower($_GET["q"]);
if (!$q) return;

$requete = "SELECT id_utilisateur, nom_utilisateur, prenom_utilisateur, status_utilisateur FROM utilisateur WHERE id_agence = ".$_SESSION['agence'];
$return = mysql_query($requete);



$tableau = array();

while($donnees = mysql_fetch_array($return))
	{
		if (strpos(strtolower($donnees['nom_utilisateur']), $q) !== false) {
			$tableau[] = array(
						'name' => $donnees['nom_utilisateur'],
						'prenom' => $donnees['prenom_utilisateur'],
						'id' => $donnees['id_utilisateur'],
						'status' => $donnees['status_utilisateur']
						
					);
			}
	}
	
	echo json_encode($tableau);