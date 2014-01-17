<?php
include '../include/connex.inc.php';
include '../include/myparam.inc.php';

$query = "UPDATE document SET texte_document = '".$_POST['texte_document']."' WHERE id_document = ".$_POST['id_document'].";";
mysql_query($query) or die(mysql_error());