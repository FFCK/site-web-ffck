<?php
session_start();

include_once("../lib/PHPExcel_1.7.8/Classes/PHPExcel.php");
include_once("../lib/PHPExcel_1.7.8/Classes/PHPExcel/Writer/Excel5.php");
include_once("base.php");

$objPHPExcel = new PHPExcel();

// Quelques propriétes
$objPHPExcel->getProperties()->setCreator("F.F.C.K.");
$objPHPExcel->getProperties()->setLastModifiedBy("F.F.C.K.");
$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX");
$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX");
$objPHPExcel->getProperties()->setDescription("Office 2007 XLSX - F.F.C.K.");

//Les Données
$objPHPExcel->setActiveSheetIndex(0);

// Titre Global ...
$objPHPExcel->getActiveSheet()->mergeCells('A1:J1');
$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'CALENDRIER');
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
		
// Titre des colonnes
for ($c='A';$c<='J';$c++)
	$objPHPExcel->getActiveSheet()->getColumnDimension($c)->setAutoSize(true);
		
$objPHPExcel->getActiveSheet()->getStyle('A3:J3')->getFont()->setBold(true);

$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Type');
$objPHPExcel->getActiveSheet()->SetCellValue('B3', 'Activité');
$objPHPExcel->getActiveSheet()->SetCellValue('C3', 'Codex');
$objPHPExcel->getActiveSheet()->SetCellValue('D3', 'Nom');
$objPHPExcel->getActiveSheet()->SetCellValue('E3', 'Début');
$objPHPExcel->getActiveSheet()->SetCellValue('F3', 'Fin');
$objPHPExcel->getActiveSheet()->SetCellValue('G3', 'Lieu');
$objPHPExcel->getActiveSheet()->SetCellValue('H3', 'St.Organisatrice');

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

$total = count($tCalendrierSource);
for ($i=0;$i<$total;$i++)
{
	$rCalendrier = $tCalendrier[$i];
	$codex = utyGetString($rCalendrier,'codex');
	$type = utyGetString($rCalendrier,'codeTypeEvenement');
	
	$objPHPExcel->getActiveSheet()->SetCellValue('A'.($i+4), utyGetString($rCalendrier,'libelleTypeEvenement'));
	$objPHPExcel->getActiveSheet()->SetCellValue('B'.($i+4), utyGetString($rCalendrier,'libelleActivite'));
	$objPHPExcel->getActiveSheet()->SetCellValue('C'.($i+4), $codex);
	$objPHPExcel->getActiveSheet()->SetCellValue('D'.($i+4), utyGetString($rCalendrier,'nomEvenement'));
	$objPHPExcel->getActiveSheet()->SetCellValue('E'.($i+4), utyGetString($rCalendrier,'dateDebut'));
	$objPHPExcel->getActiveSheet()->SetCellValue('F'.($i+4), utyGetString($rCalendrier,'dateFin'));
	$objPHPExcel->getActiveSheet()->SetCellValue('G'.($i+4), utyGetString($rCalendrier,'lieu'));
	$objPHPExcel->getActiveSheet()->SetCellValue('H'.($i+4), utyGetString($rCalendrier,'structureOrganisatrice'));
}

// On nomme notre feuillet
$objPHPExcel->getActiveSheet()->setTitle('Calendrier');
		
// Détruit les données du tampon de sortie et éteint la tamporisation de sortie
ob_end_clean();
	
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		
// Redirect output to a client's web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="calendrier.xls"');
header('Cache-Control: max-age=0');
		
$objWriter->save('php://output');
exit;
?>
