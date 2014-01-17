<?php
$idcom=@mysql_connect("127.0.0.1", "user1", "user1") or die("Erreur connexion");
$idbase=@mysql_select_db("test1") or die("Erreur database");
@mysql_query("SET CHARACTER SET 'UTF8'");

$query = "SELECT * FROM document WHERE id_document = ".$_GET['id_document'].";";
$result = mysql_query($query);

$res = mysql_fetch_array($result);

$tableau[] = array(
  'id_document' => $res['id_document'],
  'libelle_document' => $res['libelle_document'],
  'texte_document' => $res['texte_document']
);

echo json_encode($tableau);