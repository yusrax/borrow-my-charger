<?php
//logging out of the application

    session_start();
    session_destroy();
    header("location: index.php");
    exit();












