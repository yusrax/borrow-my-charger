<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION["UserId"])) {
    // Redirect to home page
    header("Location: home.php");
    exit;
}

require_once ('Models/Database.php');
require_once ('Models/UserDataSet.php');
require_once ('Models/UserData.php');

$view = new stdClass();
$view->pageTitle = 'Login';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    header('Content-Type: application/json');

    $username = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $pwd = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    $login = new UserDataSet();

    if ($login->checkUsername($username)) {
        if ($login->verify($username, $pwd)) {
            $user = $login->verify($username, $pwd);
            $_SESSION["UserId"] = $user["idUsers"];
            $_SESSION["email"] = $user["Username"];
            $_SESSION["name"] = $user["Realname"];
            $_SESSION["avatar"] = $user["ProfilePhoto"];
            $_SESSION["number"] = $user["PhoneNo"];

            //checking if user has a charge point to display
            $login->viewChargePoint($_SESSION["UserId"]);
            $response['success'] = true;
        } else {
            $response['message'] = 'Incorrect password.';
        }
    } else {
        $response['message'] = 'Account does not exist.';
    }

    echo json_encode($response);
    exit;

} else {
    require_once('Views/index.phtml');
}








