<?php
include_once('page_calendrier.php');
session_start();

$arrayParams = &$_GET;
$_SESSION['calendrier_filter_lieu'] =  utyGetString($arrayParams, 'filter_lieu');
Calendrier::Filter();
?>

