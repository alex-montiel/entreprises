<?php
include("../include/connex.inc.php");
include("../include/myparam.inc.php");

$query = "SELECT emplacement FROM typedetache WHERE tache = '".$_GET['tache']."';";
$result = mysql_query($query);

$return = mysql_fetch_array($result);

echo $return['emplacement'];
?>