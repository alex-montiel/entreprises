<?php

require_once('../include/connex.inc.php');
require('../include/fpdf/fpdf.php');

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
		
	function tableau($tache, $date, $commentaire, $nom)
	{
		
		$this->Cell(40, 8, utf8_decode($tache), 1);
		$this->Cell(40, 8, $date, 1, 0, 'C');
		$this->Cell(75, 4, utf8_decode($commentaire), 1, 2);
		$this->Cell(75, 4, utf8_decode($nom), 1, 1);
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


if(isset($_GET['id']) && isset($_GET['debut']) && isset($_GET['fin']))
{
	$id_offre = $_GET['id'];
	$debut = $_GET['debut'];
	$fin = $_GET['fin'];
	$requete = "SELECT contact.nom_contact, contact.civilite, contact.adresse, contact.prenom_contact, contact.cp, contact.ville, contact.societe, offre.adresse AS offre_adresse, offre.code_postal AS offre_cp, offre.ville AS offre_ville
				FROM tache 
				JOIN offre ON tache.id_offre = offre.id_offre
				JOIN contact ON offre.mandant_id = contact.id_contact
				 
				WHERE tache.id_offre ='$id_offre'"  ;
	$return = mysql_query($requete);
	$donnees = mysql_fetch_array($return);
	
	
	
	
	$pdf=new PDF();
	$pdf->AddPage();
	$pdf->SetFont('Arial', '', 10);
	$pdf->SetDrawColor(0,0,0);
	$pdf->SetTextColor(64,128,128);
	$pdf->Rect(10, 10, 90, 50);
	$pdf->SetLeftMargin(120);
	$pdf->SetXY(120, 19);
	$pdf->SetFont('Arial', '', 12);
	$pdf->SetTextColor(0,0,0);
	
	$pdf->Cell(90, 8, $donnees['civilite']." ".utf8_decode($donnees['nom_contact']) ." ".utf8_decode($donnees['prenom_contact']), 0, 1);
	$pdf->Cell(90, 8, utf8_decode($donnees['societe']), 0, 1);
	$pdf->Cell(90, 8, utf8_decode($donnees['adresse']), 0, 1);
	$pdf->Cell(90, 8, $donnees['cp']."   -   ". strtoupper(utf8_decode($donnees['ville']))  , 0, 1);
	
	$pdf->SetLeftMargin(45);
	$pdf->SetXY(45, 70);
	$pdf->SetFont('Arial', '', 10);
	$pdf->Cell(12, 3, "Objet :",'B');
	$pdf->SetXY(60, 70);
	$pdf->Cell(12, 3, "Bilan d'action", 0, 1);
	$pdf->Cell(50, 10, utf8_decode($donnees['offre_adresse'])."  -  ".$donnees['offre_cp']."  ".$donnees['offre_ville']);
	$pdf->SetY(95);
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(155, 5, "Cher client, ", 0, 1);
	$pdf->Cell(155, 5, "Veuillez trouver ci-dessous un bilan des actions r\351alis\351es suite au mandat que vous avez bien voulu nous confier. ", 0, 1);
	$pdf->SetY(110);
	
	$pdf->Cell(40, 4, "Moyens", 1, 0, 'C');
	$pdf->Cell(40, 4, "Date", 1, 0, 'C');
	$pdf->Cell(75, 4, "Commentaire", 1, 1, 'C');
	
	$requete = "SELECT tache.tache, tache.date, tache.commentaire, contact.civilite, contact.nom_contact, contact.societe, contact.forme_juridique
				FROM tache
				LEFT OUTER JOIN contact ON tache.id_visiteur = contact.id_contact
				WHERE tache.id_offre=".$id_offre." AND tache.date >= '$debut' AND tache.date <= '$fin' AND tache.tache != 'Appel telephonique'
				ORDER BY tache.date";
	$return = mysql_query($requete);
	while($tache = mysql_fetch_array($return))
	{
		if($tache['nom_contact'] != NULL)
		{
		$pdf->tableau($tache['tache'], date2fr($tache['date']), $tache['commentaire'], $tache['civilite']." ".$tache['nom_contact']."  -  ".strtoupper($tache['forme_juridique'])." ".$tache['societe']);
		}
		else
		{
			$pdf->tableau($tache['tache'], date2fr($tache['date']), $tache['commentaire'], "");
		}
	}
	
	$pdf->Ln();

	$pdf->MultiCell(155, 5, "En vous remerciant de votre confiance et restant \340 votre disposition, nous vous prions d'agr\351er, cher client, l'expression de nos sentiments les plus d\351vou\351s.", 0, 1);
	
	
	
	
	
	
	$pdf->Output();
}


?>