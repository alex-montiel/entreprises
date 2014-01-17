<?php
include '../include/connex.inc.php';
include '../include/myparam.inc.php';

function date2fr($date){
	if($date != "0000-00-OO"){
		//récupération des différentes valeurs en utilisant les / comme séparateurs
		@list($annee,$mois,$jour) = explode('-',$date);
		
		//retour de la date modifié au bon format grace à un mktime
		return @date('d/m/Y',mktime(0,0,0,$mois,$jour,$annee));
	}
}

$query = "SELECT * FROM document ORDER By date_creation DESC";
$result = mysql_query($query);

$return = array();

while ($res = mysql_fetch_array($result)){
	$dateCrea = date2fr($res['date_creation']). " ".substr($res['date_creation'], 10);
	
	$return[] = array(
		'id_document' => $res['id_document'],
		'date_creation' => $dateCrea,
		'libelle_document' => $res['libelle_document'],
		'texte_document' => $res['texte_document']
	);
}

echo json_encode($return);