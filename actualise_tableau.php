<?php
include 'include/connex.inc.php';

//print_r($_GET['TValues']);

// Fonction de recherche des bases à utiliser
$stringRequestDb;
foreach ($_GET['TDbs'] as $db){
	if (empty($stringRequestDb)){
		$stringRequestDb = $db;
	}
	else{
		$stringRequestDb .= ", " . $db;
	}
}

// Fonctions de recherches des champs à visualiser
$stringRequestFields;
foreach ($_GET['TSelect'] as $field){
	$alias = "";
	if(preg_match("/[.]/", $field)){ // Renomme champs si necessaire
		$alias = " as '".$field."'";
	}
	
	if (empty($stringRequestFields)){
		$stringRequestFields = $field . $alias;
	}
	else{
		$stringRequestFields .= ", " . $field . $alias;
	}
}

// Fonctions de recherche des conditions
function createRequestBegin($val, $nameVar, $stringRequest){
	// un champs a déjà été renseigné, donc il existe un WHERE
	if(empty($stringRequest) && !empty($val)){
		$result = " WHERE " . $nameVar . " like '" . $val . "%'";
	}
	elseif (!empty($val)){
		$result = " AND " . $nameVar . " like '" . $val . "%'";
	}
	
	return $result;
}

function createRequestIn($val, $nameVar, $stringRequest){
	// un champs a déjà été renseigné, donc il existe un WHERE
	if(empty($stringRequest) && !empty($val)){
		$result = " WHERE " . $nameVar . " like '%" . $val . "%'";
	}
	elseif (!empty($val)){
		$result = " AND " . $nameVar . " like '%" . $val . "%'";
	}
	
	return $result;
}


// Création requête
$stringRequest;
switch ($_GET['choix']) {
	case "tous":
		// Aucune condition
		$stringRequest = $stringRequest;
		break;
	case "debut":
		// Passage de la valeur saisie et du nom champs SQL
		//$stringRequest = createRequestBegin($_GET['TValues'][0], $_GET['TIds'][0], $stringRequest);
		for ($i = 0; $i < sizeof($_GET['TIds']); $i++){
			$stringRequest .= createRequestBegin($_GET['TValues'][$i], $_GET['TIds'][$i], $stringRequest);
		}
		break;
	case "contient":
		// Passage de la valeur saisie et du nom champs SQL
		//$stringRequest = createRequestIn($_GET['TValues'][0], $_GET['TIds'][0], $stringRequest);
		for ($i = 0; $i < sizeof($_GET['TIds']); $i++){
			$stringRequest .= createRequestIn($_GET['TValues'][$i], $_GET['TIds'][$i], $stringRequest);
		}
		break;
}

if ($_GET['conditions']){
	if($stringRequest){
		$conditions = " AND " .$_GET['conditions'];
	}
	else{
		$conditions = " WHERE " . $_GET['conditions'];
	}
}

$request = "SELECT " . $stringRequestFields . " FROM " . $stringRequestDb . $stringRequest . $conditions . ";";
//echo $request;

$response = mysql_query($request);
$nbLine = mysql_num_rows($response);
$data = mysql_fetch_array($response);

// Renvoie données
if ($nbLine == 0){
	echo "0";
}
else{
	$passage = 1;
	foreach ($_GET['TSelect'] as $field){
		if ($passage == sizeof($_GET['TSelect'])){
			echo $data[$field];
		}
		else {
			echo $data[$field]."*";
		}
		$passage++;
	}
	while ($data = mysql_fetch_array($response)){
		echo "/";
		$passage = 1;
		foreach ($_GET['TSelect'] as $field){
			if ($passage == sizeof($_GET['TSelect'])){
				echo $data[$field];
			}
			else {
				echo $data[$field]."*";
			}
			$passage++;
		}
	}
}
?>