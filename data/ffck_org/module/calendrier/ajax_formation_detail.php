<?php
include_once('page_calendrier.php');
session_start();

$arrayParams = &$_GET;
$id = utyGetString($arrayParams,'codex');
Calendrier::FormationDetail($id);
?>

