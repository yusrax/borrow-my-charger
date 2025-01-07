<?php
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

require_once ('Models/Database.php');
require_once ('Models/ChargePointData.php');
require_once('Models/ChargePointDataSet.php');

$view = new stdClass();
$view->pageTitle = 'Home';

$chargePointDataSet = new ChargePointDataSet();
$view->chargePointDataSet = $chargePointDataSet->fetchAllChargePoints();
$view->chargePointDataSetJson = $chargePointDataSet->fetchAllChargePointsJson();





require_once('Views/home.phtml');


