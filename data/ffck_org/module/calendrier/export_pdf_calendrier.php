<?php
session_start();

define('FPDF_FONTPATH','font/');
require('../lib/fpdf17/fpdf.php');

include_once("page_calendrier.php");

define('PAGE_WIDTH', 277);
define('PAGE_HEIGHT', 190);

define('STYLE_NOBORDER', 0);
define('STYLE_BORDER', 1);

define('POS_RIGHT', 0);
define('POS_NEXT_LINE', 1);
define('POS_BOTTOM', 2);

class FPDF_Calendrier extends FPDF
{
	function Footer()
	{
		$this->SetY(-15);
		$this->Line(10,285,200,285);
		$this->SetFont('Arial','I',8);
		$this->SetTextColor(0,0,0);
		$this->Cell(PAGE_WIDTH/2,10,'www.ffck.org',0,POS_RIGHT,'L');
		$this->Cell(PAGE_WIDTH/2,10,'Page '.$this->PageNo(),0,POS_RIGHT,'R');
	}
}

class PDF_Calendrier
{
	function __construct()
	{
		// Ouverture du Document PDF
		$pdf = new FPDF_Calendrier('L', 'mm','A4');
		$pdf->Open();
		$pdf->SetTitle("Calendrier F.F.C.K.");
		
		$pdf->SetAuthor("www.ffck.org");
		$pdf->SetCreator("www.ffck.org avec FPDF");
	
		$pdf->AddPage();
		$pdf->SetAutoPageBreak(true, 20);
		$pdf->Image('../img/bandeau_ffck_large.png',5,5,285,30,'png',"http://www.ffck.org");
		
		$pdf->SetTextColor(255,255,255);
		$pdf->SetFont('Arial','B',14);
		$pdf->SetX(3*PAGE_WIDTH/4);
		$pdf->Cell(PAGE_WIDTH/4,10, "CALENDRIER", STYLE_NOBORDER, POS_NEXT_LINE,'L');
		
		$today = getdate();
		$strToDay = sprintf('%02d/%02d/%04d à %02dh%02d',$today['mday'],$today['mon'],$today['year'],$today['hours'], $today['minutes']);
		
		$pdf->SetFont('Arial','B',8);
		$pdf->SetX(3*PAGE_WIDTH/4);
		$pdf->Cell(PAGE_WIDTH/4,4,utf8_decode('Edité le '.$strToDay), STYLE_NOBORDER, POS_NEXT_LINE,'L');
		$pdf->Ln(15);
			
		// Impression Grille ...
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('Arial','B',6);

		$pdf->SetX(5);
		$pdf->Cell(20,4,"Codex", STYLE_BORDER, POS_RIGHT,'C',0);
		$pdf->Cell(50,4,"Type", STYLE_BORDER, POS_RIGHT,'C', 0);
		//->Cell(40,4,utf8_decode("Activité"), STYLE_BORDER, POS_RIGHT,'C',0);
		$pdf->Cell(14,4,utf8_decode("Début"), STYLE_BORDER, POS_RIGHT,'C',0);
		$pdf->Cell(14,4,"Fin", STYLE_BORDER, POS_RIGHT,'C',0);
		$pdf->Cell(72,4,"Nom", STYLE_BORDER, POS_RIGHT,'C',0);
		$pdf->Cell(50,4,"Lieu", STYLE_BORDER, POS_RIGHT,'C',0);
		$pdf->Cell(65,4,"St.Organisatrice", STYLE_BORDER, POS_NEXT_LINE,'C',0);

		$tCalendrierSource = $_SESSION['calendrier_table'];

		$filter_lieu = utyGetSession('calendrier_filter_lieu');
		$tCalendrier = array();
		for ($i=0;$i<count($tCalendrierSource);$i++)
		{
			$row = $tCalendrierSource[$i];
			if ($filter_lieu != '')
			{
				$lieu = $row['lieu']; 
				if (stristr($lieu, $filter_lieu) === false)
					continue;
			}
			
			array_push($tCalendrier, $row);
		}
		Calendrier::Order($tCalendrier);

		$total = count($tCalendrier);
		for ($i=0;$i<$total;$i++)
		{
			$rCalendrier = $tCalendrier[$i];
			$codex = utyGetString($rCalendrier,'codex');
			$type = utyGetString($rCalendrier,'codeTypeEvenement');
			
			$pdf->SetX(5);
			$pdf->Cell(20,4, $codex, STYLE_BORDER, POS_RIGHT,'C',0);
			$pdf->Cell(50,4, utf8_decode(utyGetString($rCalendrier,'libelleTypeEvenement')." - ".utyGetString($rCalendrier,'libelleActivite')), STYLE_BORDER, POS_RIGHT,'C', 0);
			//$pdf->Cell(25,4, utf8_decode(utyGetString($rCalendrier,'libelleTypeEvenement')), STYLE_BORDER, POS_RIGHT,'C', 0);
			//$pdf->Cell(40,4, utf8_decode(utyGetString($rCalendrier,'libelleActivite')), STYLE_BORDER, POS_RIGHT,'C',0);
			$pdf->Cell(14,4, utyGetString($rCalendrier,'dateDebut'), STYLE_BORDER, POS_RIGHT,'C',0);
			$pdf->Cell(14,4, utyGetString($rCalendrier,'dateFin'), STYLE_BORDER, POS_RIGHT,'C',0);
			$pdf->Cell(72,4, utf8_decode(utyGetString($rCalendrier,'nomEvenement')), STYLE_BORDER, POS_RIGHT,'C',0);
			$pdf->Cell(50,4, mb_strimwidth(utf8_decode(utyGetString($rCalendrier,'lieu')),0,40), STYLE_BORDER, POS_RIGHT,'C',0);
			$pdf->Cell(65,4, mb_strimwidth(utf8_decode(utyGetString($rCalendrier,'structureOrganisatrice')),0,50), STYLE_BORDER, POS_NEXT_LINE,'C',0);
		}
		$pdf->Output();
	}
}

new PDF_Calendrier();
?>
