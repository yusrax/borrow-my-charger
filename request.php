<?php

require_once ('Models/Database.php');
require_once ('Models/ChargePointData.php');
require_once('Models/ChargePointDataSet.php');


$view = new stdClass();
$view->pageTitle = 'Request';

$chargePoints = new ChargePointDataSet();

if (isset($_GET['chargeid'])){

    //getting requested Charge Point id from url
    $id = (int) $_GET['chargeid'];

    //retrieving Charge Point Details
    $view->chargePoints = $chargePoints->getDetail($id);


}


require_once('Views/request.phtml');



