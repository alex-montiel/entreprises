<?php
$idcom=@mysql_connect("127.0.0.1", "user1", "user1") or die("Erreur connexion");
$idbase=@mysql_select_db("test1") or die("Erreur database");
@mysql_query("SET CHARACTER SET 'UTF8'");

$columnNames = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
 WHERE TABLE_NAME='".$_GET['table']."'";

$columnNames = mysql_query($columnNames) or die("columns : ".mysql_error());

$tableau = array();
while ($name = mysql_fetch_array($columnNames)){
	$tableau[] = array(
		'column_name' => $name['COLUMN_NAME']
	);
}

echo json_encode($tableau);