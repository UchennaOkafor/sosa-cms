<?php

namespace Cms\Database\Config;

use Exception;
use PDO;

class Database {

    const DB_HOST = "localhost";
    const DB_NAME = "sosa";
    const DB_USER = "root";
    const DB_PASS = "password55";

    private static $instance;
    private static $con;

    public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new Database();
        }

        return self::$con;
    }

    public function __construct() {
        $connectionString = "mysql:dbname=" . self::DB_HOST . ";dbname=" . self::DB_NAME;

        try {
            self::$con = new PDO($connectionString, self::DB_USER, self::DB_PASS);
            self::$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}