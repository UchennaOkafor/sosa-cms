<?php

session_start();

use Cms\Database\Config\Database;

require "../../backend/db/Database.php";

//Initializes the pdo instance, if an error occurs it will throw an error message.
Database::getInstance();

if (! Database::$hasConnection) {
    $_SESSION["DB_ERROR_MSG"] = Database::$dbErrorMsg;
    require ("error.php");
}

if (! isset($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = generateCsrfToken();
}

function generateCsrfToken() {
    if (function_exists('mcrypt_create_iv')) {
        return bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
    } else {
        return bin2hex(openssl_random_pseudo_bytes(32));
    }
}