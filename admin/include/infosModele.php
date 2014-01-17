<?php
$idcom=@mysql_connect("127.0.0.1", "user1", "user1") or die("Erreur connexion");
$idbase=@mysql_select_db("test1") or die("Erreur database");
@mysql_query("SET CHARACTER SET 'UTF8'");

$query = "SELECT * FROM modele WHERE id_modele = ".$_POST['id'].";";
$result = mysql_query($query);

$res = mysql_fetch_array($result);

$tableau[] = array(
  'id_modele' => $res['id_modele'],
  'type_modele' => $res['type_modele'],
  'table_modele' => $res['table_modele'],
  'cle_table_modele' => $res['cle_table_modele'],
  'nom_modele' => $res['nom_modele'],
  'texte_modele' => $res['texte_modele']
);

echo json_encode($tableau);