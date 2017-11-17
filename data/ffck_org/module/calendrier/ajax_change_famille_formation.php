<?php
include_once('page_calendrier.php');
session_start();

$arrayParams = &$_GET;
$famille_formation = utyGetString($arrayParams,'famille_formation');
$_SESSION['calendrier_famille_formation'] = $famille_formation;
Calendrier::ComboEvenementTypeFormation();
?>

