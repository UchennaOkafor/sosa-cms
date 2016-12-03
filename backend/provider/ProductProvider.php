<?php

namespace Cms\Provider;

use Cms\Database\Config\Database;
use PDO;

/**
 * This class is used to abstract the basic CRUD functionality of the products table. Including other functionality.
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
     * Checks if a product exists in the database
     * @param $id int The id of the product to check
     * @return bool Boolean result of operation
     */
    public function isProductExists($id) {
        $stmt = $this->pdoInstance->prepare("SELECT id FROM products WHERE id = ? LIMIT 1");
        return $stmt->execute([$id]) && $stmt->rowCount() == 1;
    }

    /**
     * Retrieves an array of all products in the system
     * @return array|null
     */
    public function getAllProducts() {
        $stmt = $this->pdoInstance->prepare("SELECT * FROM products");

        if ($stmt->execute() && $result = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
            return $result;
        }

        return null;
    }

    public function editProduct($productId, $name, $type, $price, $stock) {

    }

    public function getProductById($id) {

    }

    /**
     * Retrieves all products from the database whose attribute have a searched for value
     * @param $attribute string The product attribute to search by
     * @param $value string|mixed The value to search by
     * @return array|null An array of the matched products or null if nothing
     */
    public function getProductsByAttribute($attribute, $value) {
        $attribute = strtolower($attribute);

        if ($this->isValidProductAttribute($attribute)) {
            $stmt = $this->pdoInstance->prepare("SELECT * FROM products WHERE $attribute LIKE ?");

            if ($stmt->execute(["%$value%"]) && $result = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
                return $result;
            }
        }

        return null;
    }

    /**
     * Checks if the given product Id is a valid products attribute with exception of created_at being omitted
     * @param $attr string given attribute value
     * @return bool the boolean result of the operation
     */
    private function isValidProductAttribute($attr) {
        return in_array($attr, ["id", "name", "type", "size", "price", "stock"]);
    }

    /**
     * Deletes a product from the database based on the productId
     * @param $id int the Id of the product to delete
     * @return bool Boolean result of operation
     */
    public function deleteProduct($id) {
        $stmt = $this->pdoInstance->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }
}

//TODO make it so if the user selects a specific attribute like ID, or Size, Stock that it will use equal instead of LIKE to find results