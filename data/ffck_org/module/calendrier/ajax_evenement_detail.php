<?php
include_once('page_calendrier.php');
session_start();

$arrayParams = &$_GET;
$codex = utyGetString($arrayParams,'codex');
Calendrier::EvenementDetail($codex);
?>

