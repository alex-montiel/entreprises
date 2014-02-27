<?php
error_reporting(E_ERROR);
include 'include/connex.inc.php';


//print_r($_GET['TValues']);

// Fonction de recherche des bases à utiliser
$stringRequestDb = "";

foreach ($_GET['TDbs'] as $db){
	if (empty($stringRequestDb)){
		$stringRequestDb = $db;
	}
	else{
		$stringRequestDb .= ", " . $db;
	}
}

// Fonctions de recherches des champs à visualiser
$stringRequestFields="";
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
$stringRequest="";
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

//Calcul du nombre d'enregistrements pour la pagination
//if(isset($_SESSION['conf_pagination'])){
//   $pagination = $_SESSION['conf_pagination'];
//}else{
//   $pagination = 15;
//}

$pagination = $_GET['pagination'];
if($stringRequestDb == 'agence, contact'){
    $request = 'SELECT COUNT(id_contact) AS total FROM '.$stringRequestDb.';';
    $tableSql = 'contact';
}else if($stringRequestDb == 'offre, utilisateur'){
    $request = 'SELECT COUNT(id_offre) AS total FROM '.$stringRequestDb.';';
    $tableSql = 'offre';
}
$resultat = mysql_query($request);
$nbLignes = mysql_fetch_assoc($resultat);
$total = $nbLignes['total'];

//Calcul du nombre de pages
$nbPage = ceil($total / $pagination);

if(isset($_GET['page']) && $_GET['page']!= 0){
    $pageActuelle = intval($_GET['page']);
    if ($pageActuelle > $nbPage){
        $pageActuelle = $nbPage;
    }
}else{
    $pageActuelle = 1;
}

//Calcul du premier enregistrement a afficher
$premiereEntree = ($pageActuelle - 1)*$pagination;

$request = "SELECT " . $stringRequestFields . " FROM " . $stringRequestDb . $stringRequest . $conditions . " LIMIT ".$premiereEntree.",".$pagination.";";
//echo "Requete ".$request;

$response = mysql_query($request);
$nbLine = mysql_num_rows($response);
//$data = mysql_fetch_array($response);

if(isset($_GET['choix']) && $_GET['choix'] != 'tous' ){
    if($_GET['choix'] != 1 && $_GET['choix'] != "undefined"){
        $requete = "SELECT COUNT(*) AS 'total' FROM " . $stringRequestDb . $stringRequest . $conditions;
        $reponse = mysql_query($requete);
        $nb_lignes = mysql_fetch_assoc($reponse);
        $nb_total = $nb_lignes['total'];
        $nb_page = ceil($nb_total / $pagination);
        
        $passage = 1;
        
        //Envoie du numéro de la derniere page au javascript
        foreach($_GET['TSelect'] as $field){
            if ($passage == sizeof($_GET['TSelect'])){
                echo $nb_page;
            }else{
                echo $nb_page."*";
            }
            $passage++;
        }           
        
    }  
}
// Renvoie données
if ($nbLine == 0){
	echo "0";
}
else{
	/*$passage = 1;
	foreach ($_GET['TSelect'] as $field){
		if ($passage == sizeof($_GET['TSelect'])){
			echo $data[$field];
		}
		else {
			echo $data[$field]."*";
		}
		$passage++;
	}*/
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
        header('index.php?requete='.$tableSql.'&page='.$pageActuelle.'&nbpage='.$nbPage);
}
?>

