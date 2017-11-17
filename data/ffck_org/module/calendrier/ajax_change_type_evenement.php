<?php
include_once('page_calendrier.php');
session_start();

$arrayParams = &$_GET;
$type_evenement = utyGetString($arrayParams,'type_evenement');

$db = new MyBase();
Calendrier::ComboEvenement($db, $type_evenement);
?>

