<?php
require_once('include/connex.inc.php');
require('include/fpdf/fpdf.php');

function date2fr($date)
{
	if($date != "0000-00-OO")
	{
		@list($annee,$mois,$jour)=explode('-',$date);				//récupération des différentes valeurs en utilisant les / comme séparateurs
   		return @date('d/m/Y',mktime(0,0,0,$mois,$jour,$annee));		//retour de la date modifié au bon format grace é un mktime
	}
}


class PDF extends FPDF
{
	function Titre($titre, $marge)
	{
		$this->SetLeftMargin($marge * 100 + 10);
		$this-> Ln(5);
		$this->SetFont('Arial', '', 12);
		$this->SetTextColor(255,255,255);
		$this->SetFillColor(0,0,0);
		$this->Cell(90, 10, $titre, 1, 1, 'C', 'TRUE');
		
		
	}
	
	function Texte($contenu, $marge)
	{
		$this->SetFont('Arial', '', 8);
		$this->SetTextColor(0,0,0);
		$this->SetLeftMargin(12 + $marge*100);
		$this->Ln(2);
		$hauteur = $this->GetStringWidth($contenu)/85 + 1;
		$this->MultiCell(85, $hauteur, $contenu, 0, 1);
		$this->Ln(3);
	}
	
	function Footer()
	{
    	
    	$this->SetY(-30);
    	//Police Arial italique 8
    	$this->SetFont('Arial','I',8);
    	//Numéro de page centré
    	$this->Line(10, 267, 200, 267);
    	$this->Cell(80, 5, 'Document non contractuel redige le:', 0, 0);
    	$this->SetLeftMargin(110);
    	$this->Cell(80, 5, 'Votre Conseiller', 0, 1);
    	$this->SetX(10);
    	$this->Cell(80, 5, date("l d F Y"), 0, 0);
	}

}

if($_GET['id'] != '')
{

$id_offre = $_GET['id'];

$requete = "SELECT * FROM offre WHERE id_offre =".$id_offre;
$return = mysql_query($requete);
$donnees = mysql_fetch_array($return);

$requete  ="SELECT nom_photo FROM offre_photo WHERE id_offre=".$id_offre;
$return = mysql_query($requete);
$photo = mysql_fetch_array($return);




$pdf=new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);
$pdf->SetDrawColor(64,128,128);
$pdf->SetTextColor(64,128,128);
$pdf->Cell(80);
$pdf->Cell(70,6,'Fiche COMMERCIALE',1,0);
$pdf->Cell(20, 6, 'Numero:');
$longueur = $pdf->GetStringWidth($donnees['id_offre']);
$pdf->SetX((200-$longueur));
$pdf->SetTextColor(0,0,0);
$pdf->Cell($longueur, 6, $donnees['id_offre'], 0, 1);
$pdf->Cell(190, 1, '', 'B', 1);
$pdf->SetDrawColor(0,0,0);
$pdf->Rect(10, 20, 90, 50);
$pdf->SetXY(45, 23);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(55, 20, strtoupper($donnees['type_offre']), 0, 2, 'C');
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(55, 10, $donnees['zone_activite'], 0, 2, 'C');
$pdf->Cell(55,10, $donnees['secteur_geo'], 0, 1, 'C');
$pdf->Ln(10);


$pdf->Titre('Qualite de l\'emplacement', 0);
if($donnees['qualite_emplacement'] != 'non precise')
{
	$pdf->Texte($donnees['qualite_emplacement'], 0);
}
$pdf->Texte($donnees['desserte'], 0);




$pdf->Titre('Descriptif', 0);
$pdf->Texte($donnees['descriptif'], 0);

$pdf->Titre('Equipements', 0);
$pdf->Texte($donnees['equipement'], 0);

$pdf->Titre('Commentaire', 0);
$pdf->Texte($donnees['location_comm'], 0);

if(isset($photo['nom_photo']))
{
	//$pdf->Image($_SERVER[DOCUMENT_ROOT].'/photo/'.$photo['nom_photo'], 110, 20, '', 55);
	$pdf->Image("photo/".$photo['nom_photo'], 110, 20, '', 55);
}


$pdf->SetXY(150, 94.2);
$pdf->Titre('Conditions Financieres', 1);
if($donnees['loyer_annuel'] != '0')
{
	$pdf->Texte('Loyer annuel:  '.$donnees['loyer_annuel'], 1);
}
if($donnees['prix_murs'] != '0')
{
$pdf->Texte('Prix de vente:   '.$donnees['prix_murs'], 1);
}
if($donnees['provision_location'] != '0')
{
$pdf->Texte('Provisions pour charges:   '.$donnees['provision_location'], 1);
}
if($donnees['impot_proprio'] != '0')
{
$pdf->Texte('Taxe foncieres é charges du propriétaire:   '.$donnees['impot_proprio'], 1);
}
if($donnees['impot_locataire'] != '0')
{
$pdf->Texte('Taxe foncieres é charges du locataire:   '.$donnees['impot_locataire'], 1);
}
if($donnees['pas_de_porte'] != '0')
{
$pdf->Texte('Prix de cession:   '.$donnees['pas_de_porte'], 1);
}
if($donnees['prix_fond_commerce'] != '0')
{
$pdf->Texte('Prix du fond de commerce:    '.$donnees['prix_fond_commerce'], 1);

}
if($donnees['paiement'] != '')
{
$pdf->Texte('Paiement:    '.$donnees['paiement'], 1);
}


$pdf->Titre('Honoraires', 1);
$pdf->Texte($donnees['hono_trans_location'], 1);
$pdf->Texte($donnees['hono_redac_location'], 1);

$pdf->Titre('Conditions Juridiques', 1);
if($donnees['type_bail'] != '')
{
$pdf->Texte('Type de bail: '.$donnees['type_bail'], 1);
}
if($donnees['regime_fiscal'] != '')
{
$pdf->Texte('Regime Fiscal: '.$donnees['regime_fiscal'], 1);
}
if($donnees['garantie'] != '')
{
$pdf->Texte('Depot de garantie: '.$donnees['garantie'], 1);
}

$pdf->Titre('Disponibilite', 1);
if($donnees['date_dispo_location'] != '0000-00-00')
{
$pdf->Texte(date2fr($donnees['date_dispo_location']), 1);
}

$pdf->SetLeftMargin(10);







$pdf->Output();

}
?>