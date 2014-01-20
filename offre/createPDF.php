<?php

error_reporting(E_ALL);
include '../include/connex.inc.php';
include '../include/myparam.inc.php';

require_once '../include/html2pdf/html2pdf.class.php';

// MILIEU
$query = "SELECT libelle_document, texte_document FROM document
 WHERE id_document = '" . $_GET['id'] . "'";

$result = mysql_query($query) or die(mysql_error());
$res = mysql_fetch_assoc($result);

// PIED
$query = "SELECT * FROM infos_fiches";
$result = mysql_query($query);

$resPied = mysql_fetch_assoc($result);
$pied = stripslashes($resPied['texte_bas']);

// données HTML
ob_start();
include 'document.php';
$content = ob_get_clean();

// convertion
try{
	$html2pdf = new HTML2PDF('P', 'A4', 'fr');
	
	$html2pdf->setDefaultFont('Arial');
	$html2pdf->writeHTML($content);
	$html2pdf->Output('createPDF.pdf', isset($_GET['vuehtml']));
}
catch(HTML2PDF_exception $e) {
	echo $e;
	exit;
}
?>