<?php
include '../include/myparam.inc.php';
include '../include/connex.inc.php';

if (isset($_POST['id_modele']) && $_POST['id_modele'] != ""){
	// TABLE DU MODELE
	$queryTable = "SELECT table_modele FROM modele WHERE id_modele = '".$_POST['id_modele']."'";
	$resultTable = mysql_query($queryTable);
	
	$resTable = mysql_fetch_array($resultTable);
	$table = $resTable['table_modele'];
	
	// ENTETES COLONNES
	$columns = array();
	$columnNames = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
	 WHERE TABLE_NAME='".$table."'
	 UNION 
	 SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
	 WHERE TABLE_NAME='contact'
	 ";
	$columnNames = mysql_query($columnNames) or die("columns : ".mysql_error());
	
	while ($name = mysql_fetch_array($columnNames)){
		$columns[] = $name['COLUMN_NAME'];
	}
	
	// DONNEES
	$queryData = "SELECT * FROM contact, ".$table.$_POST['conditions'];
	$resultData = mysql_query($queryData) or die("data : ".mysql_error());
	
	$data = mysql_fetch_array($resultData);
	
	// MODELE
	$selectModele = "SELECT nom_modele, texte_modele FROM modele WHERE id_modele = '".$_POST['id_modele']."'";
	$selectModele = mysql_query($selectModele) or die("modele : ".mysql_error());
	
	$modele = mysql_fetch_array($selectModele);
	$stringModele = $modele['texte_modele'];
	$libelleDoc = $modele['nom_modele'];
	
	$finalString = $stringModele;
		
	$newString = explode("!-", strip_tags($stringModele));
	
	// RECHERCHE
	$newContent = array();
	foreach ($newString as $subString){
		$newContent[] = explode("-!", $subString);
		//echo $newContent[2][0];
	}
	unset($newContent[0]); // Supprime premier element (vide)
	
	
	// MODIFICATION
	$i = 0;
	foreach ($newContent as $content) {
		switch ($content[0]){
			case in_array($content[0], $columns):
				$replace = $data[$content[0]];
				break;
			case 'date':
				$replace = date('d/m/Y');
				break;
			case 'dpe':
				$replace = "!- --> DPE <-- -!";
				break;
			case 'image':
				$replace = "!- --> IMAGE <-- -!";
				break;
			default: // inconnu
				$replace = "!-".$content[0]."-!";
				break;
		}
		
		$finalString = str_replace("!-".$content[0]."-!", $replace, $finalString);
		
		$i++;
	}
	echo $finalString;
	
	// CREATION NOUVEAU DOCUMENT
	$insertDoc = "INSERT INTO document() VALUES('', NOW(), '".$libelleDoc."','".$finalString."');";
	mysql_query($insertDoc) or die("Création : ".mysql_error());
	
	//header('Location: index.php');
}