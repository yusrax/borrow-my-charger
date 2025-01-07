<?php

$view = new stdClass();
$view->pageTitle = 'Sign Up';
require_once('Models/Database.php');
require_once('Models/UserDataSet.php');

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    header("Content-Type: application/json");


    //getting new user data from form

    $username = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $full_name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $pwd1 = filter_input(INPUT_POST, 'pwd1', FILTER_SANITIZE_STRING);
    $phoneNo = filter_input(INPUT_POST, 'number', FILTER_SANITIZE_NUMBER_INT);


    $register = new UserDataSet();

    //checking if the account already exists
    if (!$register->checkUsername($username)) {
        //creating a new user
        $avatar = 'https://robohash.org/' . $username . '.jpg';
        $register->register($username, $full_name, $pwd1, $avatar, $phoneNo);
        echo json_encode(["status" => "success"]);

    } else {
        echo json_encode(["status" => "error", "message" => "Username already exists. Login"]);
    }

    exit();
}



require_once('Views/register.phtml');



