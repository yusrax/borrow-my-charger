<?php
session_start();
require_once('Views/template/header.phtml');
require_once ('Models/UserDataSet.php');
require_once('Models/ChargePointDataSet.php');

$view = new stdClass();
$view->pageTitle = 'Login';




if (isset($_POST["Save"])) {

    //getting data and filtering malicious code after user has updated personal information
    $newUsername = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $newName = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
    $newPhoneNo = filter_var($_POST["number"], FILTER_SANITIZE_STRING);

    $profile = new UserDataSet();

    //checking if the user made any updates and making changes if any
    if (!Empty($newUsername)) {
        $profile->updateUsername($newUsername);

    }

    if (!Empty($newName)) {
        $profile->updateName($newName);
    }

    if (!Empty($newPhoneNo)) {
        $profile->updateNumber($newPhoneNo);

    }


}


if(isset($_POST["submit"])) {

    //getting data from form to create a new Charge Point and filtering malicious code
    $address = filter_var($_POST["address1"], FILTER_SANITIZE_STRING);
    $city = filter_var($_POST["address2"], FILTER_SANITIZE_STRING);
    $postcode = filter_var($_POST["postcode"], FILTER_SANITIZE_STRING);
    $lat = filter_var($_POST["lat"], FILTER_SANITIZE_STRING);
    $lng = filter_var($_POST["lng"], FILTER_SANITIZE_STRING);
    $cost = filter_var($_POST["cost"], FILTER_SANITIZE_STRING);
    $owner = filter_var($_SESSION["UserId"], FILTER_SANITIZE_STRING);


    //validating form by checking for empty input
    if (Empty($address) || Empty($city) || Empty($postcode) || Empty($lat) || Empty($lng) || Empty($cost) || Empty($owner)){
        header ("location: profile.php?error=emptyInput");
    } else {

        //registering the new Charge Point
        $register = new ChargePointDataSet();
        $register->register( $address, $city, $postcode, $lat, $lng, $cost , $owner);
        header ("location: profile.php?=chargepointregistered");

    }

}



if (isset($_POST["Done"])) {

    //getting data and filtering malicious code after user has updated Charge Point information
    $newAddress = filter_var($_POST["address1"], FILTER_SANITIZE_STRING);
    $newCity = filter_var($_POST["address2"], FILTER_SANITIZE_STRING);
    $newPostcode = filter_var($_POST["postcode"], FILTER_SANITIZE_STRING);
    $newLat = filter_var($_POST["lat"], FILTER_SANITIZE_STRING);
    $newLng = filter_var($_POST["lng"], FILTER_SANITIZE_STRING);
    $newCost = filter_var($_POST["cost"], FILTER_SANITIZE_STRING);


    $chargePoint = new ChargePointDataSet();

    ////checking if the user made any updates and making changes if any
    if (!Empty($newAddress)) {
        $chargePoint->updateAddress($newAddress);
    }

    if (!Empty($newCity)) {
        $chargePoint->updateCity($newCity);
    }

    if (!Empty($newPostcode)) {
        $chargePoint->updatePostcode($newPostcode);
    }

    if (!Empty($newLat)) {
        $chargePoint->updateLat($newLat);
    }

    if (!Empty($newLng)) {
        $chargePoint->updateLng($newLng);
    }

    if (!Empty($newCost)) {
        $chargePoint->updateCost($newCost);
    }

}






require_once('Views/profile.phtml');