<?php
$idcom = connex();

function connex() {
	include_once("myparam.inc.php");
	$idcom=@mysql_connect(MYHOST, MYUSER, MYPASS) or die("Erreur connexion");
	$idbase=@mysql_select_db(MYBASE) or die("Erreur database");
	@mysql_query("SET CHARACTER SET 'UTF8'");
	return $idcom;
}
?>
