<?php

use Cms\Database\Config\Database;

class ProductFactory {

    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance();
    }

    public function getAllProducts() {
        $stmt = $this->pdo->prepare("SELECT * FROM products");

        if ($stmt->execute() && $result = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
            return $result;
        }

        return null;
    }
}