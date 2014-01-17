<?php
include '../include/connex.inc.php';
include '../include/myparam.inc.php';

$query = "SELECT * FROM document WHERE id_document = ".$_GET['id_document'].";";
$result = mysql_query($query);

$res = mysql_fetch_array($result);

$tableau[] = array(
  'id_document' => $res['id_document'],
  'libelle_document' => $res['libelle_document'],
  'texte_document' => $res['texte_document']
);

echo json_encode($tableau);