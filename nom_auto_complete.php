<?php
session_start();
include("include/connex.inc.php");

$q = strtolower($_GET["q"]);
if (!$q) return;

$requete = "SELECT id_contact, nom_contact, prenom_contact, societe, ville, portable, civilite FROM contact WHERE id_agence=".$_SESSION['agence'];
$return = mysql_query($requete);

$tableau = array();

while($donnees = mysql_fetch_array($return))
	{
		if (strpos(strtolower($donnees['nom_contact']), $q) !== false) {
			$tableau[] = array(
						'name' => $donnees['nom_contact'],
						'prenom' => $donnees['prenom_contact'],
						'id' => $donnees['id_contact'],
						'societe' => $donnees['societe'],
						'ville' => $donnees['ville'],
						'portable' => $donnees['portable'],
						'civilite' => $donnees['civilite']
						
					);
			}
		if (strpos(strtolower($donnees['prenom_contact']), $q) !== false) {
			$tableau[] = array(
						'name' => $donnees['nom_contact'],
						'prenom' => $donnees['prenom_contact'],
						'id' => $donnees['id_contact'],
						'societe' => $donnees['societe'],
						'ville' => $donnees['ville'],
						'portable' => $donnees['portable'],
						'civilite' => $donnees['civilite']
						
					);
			}
	}
	
echo json_encode($tableau);