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

    /**
     * @param $id
     * @return bool
     */
    public function isProductExists($id) {
        $stmt = $this->pdoInstance->prepare("SELECT id FROM products WHERE id = ? LIMIT 1");
        return $stmt->execute([$id]) && $stmt->rowCount() == 1;
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
        return in_array($attribute, ["id", "name", "type", "price", "stock"]);
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