<?php
session_start();
require_once ('Models/Database.php');
require_once ('Models/ChargePointData.php');
require_once('Models/ChargePointDataSet.php');
require_once('Models/Search.php');

$view = new stdClass();


if (isset($_GET['query'])){
    //getting search query from url
    $parameter = $_GET['query'];
    $chargePointDataSet = new Search();
    $results = $chargePointDataSet->numOfResults($parameter);

    //checking if search query returns results
    if (!$results){
        header("location: home.php?sorry=notfound");
    } else {

        //displaying query results
        $_SESSION['results'] = $results;
        if (!isset($_GET['resultspage'])) {
            //setting default page to 1
            $pages = 1;
        } else {
            $pages = $_GET['resultspage'];
        }
        $view->chargePointData = $chargePointDataSet->search($parameter, $pages);
    }

}


