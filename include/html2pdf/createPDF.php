<?php
require_once '../connex.inc.php';
require_once 'html2pdf.class.php';

// ENTETE ET PIED DE PAGE
$query = "SELECT * FROM infos_fiches";
$result = mysql_query($query);

$res = mysql_fetch_assoc($result);
$pied = stripslashes($res['texte_bas']);
$entete = stripcslashes($res['texte_haut']);

// Modification chemin images
$entete = str_replace("src=\"../", "src=\"../../", $entete);
$pied = str_replace("src=\"../", "src=\"../../", $pied);


// MILIEU
$query = "SELECT nom_photo FROM offre_photo WHERE id_offre = '" . $_GET['id'] . "' AND id_photo =
 (SELECT MIN(id_photo) FROM offre_photo WHERE id_offre = '" . $_GET['id'] . "')";

$result = mysql_query($query) or die(mysql_error());

$img = mysql_fetch_assoc($result);

$query = "SELECT type_offre, adresse, suite, code_postal, ville, zone_activite,
 qualite_emplacement, descriptif, equipement, loyer_annuel,
 loyer_mensuel, prix_murs, tva_murs, provision_vente, impot_proprio, impot_locataire,
 prix_fond_commerce, paiement, hono_trans_location, hono_redac_location, hono_trans_vente,
 hono_redac_vente, hono_total_location, hono_total_vente, regime_fiscal, type_bail,
 garantie, locaux, atelier, bureau, depot, magasin, terrain, surface_total,
 date_dispo_location, date_dispo_vente FROM offre
 WHERE id_offre = '" . $_GET['id'] . "'";
//echo $query;
$result = mysql_query($query) or die(mysql_error());

$res = mysql_fetch_assoc($result);

// données HTML
ob_start();
include '../../fiches/commerciale.php';
$content = ob_get_clean();

// convertion
//require_once('html2pdf.class.php');
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