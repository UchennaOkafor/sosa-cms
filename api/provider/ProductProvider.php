<?php

namespace Cms\Provider;

use Cms\Database\Config\Database;
use PDO;

/**
 * Class ProductProvider
 */
class ProductProvider {

    /**
     * @var $pdoInstance
     */
    private $pdoInstance;

    /**
     * ProductFactory constructor.
     */
    public function __construct() {
        $this->pdoInstance = Database::getInstance();
    }

    /*
     *
     */
    public function getAllProducts() {
        $stmt = $this->pdoInstance->prepare("SELECT * FROM products");

        if ($stmt->execute() && $result = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
            return $result;
        }

        return null;
    }

    /**
     * @param $productId
     * @param $name
     * @param $type
     * @param $price
     * @param $stock
     */
    public function editProduct($productId, $name, $type, $price, $stock) {

    }

    /**
     * @param $attribute
     * @param $value
     * @return array|null
     */
    public function getProductsByAttribute($attribute, $value) {
        if ($this->isValidProductAttribute($attribute)) {
            $command = $this->getSqlCommand($attribute);

            $stmt = $this->pdoInstance->prepare("SELECT * FROM products WHERE $attribute $command ?");

            if ($stmt->execute([$command == "=" ? $value : "%$value%"]) && $result = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
                return $result;
            }
        }

        return null;
    }

    /**
     * @param $attribute
     * @return bool
     */
    private function isValidProductAttribute($attribute) {
        $acceptedValues = ["id", "name", "type", "price", "stock"];
        return in_array($attribute, $acceptedValues);
    }

    /**
     * @param $attribute
     * @return string
     */
    private function getSqlCommand($attribute) {
        return $attribute == "name" ? "LIKE" : "=";
    }

    /**
     * @param $productId
     * @return bool
     */
    public function deleteProduct($productId) {
        $stmt = $this->pdoInstance->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$productId]);
    }
}