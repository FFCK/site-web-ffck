<?php
include_once('page_calendrier.php');
session_start();

$arrayParams = &$_GET;

$_SESSION['calendrier_type_evenement'] = utyGetString($arrayParams, 'type_evenement');

$_SESSION['calendrier_famille_formation'] = utyGetString($arrayParams, 'famille_formation');
$_SESSION['calendrier_type_formation'] = utyGetArray($arrayParams, 'type_formation');
$_SESSION['calendrier_activite'] = utyGetArray($arrayParams, 'activite');
$_SESSION['calendrier_niveau'] = utyGetArray($arrayParams, 'niveau');

$_SESSION['calendrier_saison'] = utyGetString($arrayParams, 'saison');
$_SESSION['calendrier_mois'] = utyGetString($arrayParams, 'mois');
$_SESSION['calendrier_debut'] = utyGetString($arrayParams, 'debut');
$_SESSION['calendrier_fin'] = utyGetString($arrayParams, 'fin');

$_SESSION['calendrier_filter_activite'] = '';

$_SESSION['calendrier_order_col'] = 'dateDebut';
$_SESSION['calendrier_order_asc'] = '1';

Calendrier::Load();
?>

