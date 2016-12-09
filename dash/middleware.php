<?php

session_start();

use Sosa\Database\Config\Database;

require "../backend/db/Database.php";

//Initializes the pdo instance, if an error occurs it will give rise to an error message
Database::getInstance();

if (! Database::$hasConnection) {
    $_SESSION["DB_ERROR_MSG"] = Database::$dbErrorMsg;
    require("error.php");
    die();
}

if (! isset($_SESSION["csrf_token"]) || $_SESSION["csrf_token"] == "") {
    $_SESSION["csrf_token"] = generateCsrfToken();
}

function generateCsrfToken() {
    return bin2hex(openssl_random_pseudo_bytes(32));
}