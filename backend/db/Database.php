<?php

namespace Sosa\Database\Config;

use PDO;
use PDOException;

class Database
{
    const DB_HOST = "localhost";
    const DB_NAME = "sosa";
    const DB_USER = "root";
    const DB_PASS = "password55";

    private static $dbInstance;
    private static $pdoInstance;

    public static $hasConnection = true;
    public static $dbErrorMsg = null;

    public static function getInstance() {
        if (is_null(self::$dbInstance)) {
            self::$dbInstance = new Database();
        }

        return self::$pdoInstance;
    }

    public function __construct() {
        $connectionString = "mysql:host=" . self::DB_HOST . ";dbname=" . self::DB_NAME;

        try {
            self::$pdoInstance = new PDO($connectionString, self::DB_USER, self::DB_PASS);
            self::$pdoInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            self::$hasConnection = false;
            self::$dbErrorMsg = $e->getMessage();
        }
    }
}