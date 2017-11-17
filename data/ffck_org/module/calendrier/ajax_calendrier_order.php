<?php
session_start();
include_once('page_calendrier.php');

$arrayParams = &$_GET;
$_SESSION['calendrier_order_col'] = utyGetString($arrayParams, 'order');
$_SESSION['calendrier_order_asc'] = utyGetString($arrayParams, 'asc', '1');
Calendrier::Filter();
?>

