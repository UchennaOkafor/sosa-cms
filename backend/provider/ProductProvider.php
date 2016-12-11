<?php

namespace Sosa\Provider;

use Sosa\Database\Config\Database;
use PDO;


/**
 * This is the database abstraction layer of the system
 * Class ProductProvider
 * @package Sosa\Provider
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

    public function getTotalProductsCount() {
        return intval($this->pdoInstance->query("SELECT COUNT(*) FROM products")->fetchColumn());
    }

    /**
     * Checks if a product exists in the database
     * @param $id int The id of the product to check
     * @return bool Boolean result of operation
     */
    public function isProductExists($id) {
        $stmt = $this->pdoInstance->prepare("SELECT id FROM products WHERE id = ? LIMIT 1");
        return $stmt->execute(array($id)) && $stmt->rowCount() == 1;
    }

    public function addProduct($name, $price, $stock, $type, $size) {
        $stmt = $this->pdoInstance->prepare("INSERT INTO products(name, price, stock, size, type)
                                             VALUES(?, ?, ?, ?, ?)");

        return $stmt->execute(array($name, $price, $stock, $size, $type)) && $stmt->rowCount() == 1;
    }

    /**
     * Retrieves an array of all products in the database
     * @return array|null
     */
    public function getAllProducts() {
        $stmt = $this->pdoInstance->prepare("SELECT * FROM products");

        if ($stmt->execute() && $result = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
            return $result;
        }

        return null;
    }

    public function editProduct($id, $name, $price, $stock, $type, $size) {
        $stmt = $this->pdoInstance->prepare("UPDATE products 
                                             SET name = ?, `type` = ?, price = ?, stock = ?, size = ? 
                                             WHERE id = ?");

        return $stmt->execute(array($name, $type, $price, $stock, $size, $id));
    }

    /**
     * Retrieves a product from the database based on the Id
     * @param $id int the id of the target product
     * @return array|null the product if found, else null
     */
    public function getProductById($id) {
        $stmt = $this->pdoInstance->prepare("SELECT * FROM products WHERE id = ?");

        if ($stmt->execute(array($id)) && $result = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
            return $result[0];
        }

        return null;
    }

    /**
     * Retrieves all products from the database whose attribute have a searched for value
     * @param $attribute string The product attribute to search by
     * @param $value string|mixed The value to search by
     * @return array|null An array of the matched products or null if nothing
     */
    public function getProductsByAttribute($attribute, $value) {
        $attribute = strtolower($attribute);
        $requiresWildcard = $attribute == "name";

        if ($this->isValidProductAttribute($attribute)) {
            $stmt = $this->pdoInstance->prepare("SELECT * FROM products WHERE $attribute LIKE ?");

            if ($stmt->execute(array($requiresWildcard ? "%$value%" : $value)) && $result = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
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
        return in_array($attr, array("id", "name", "type", "size", "price", "stock"));
    }

    /**
     * Deletes a product from the database based on the id of the product
     * @param $id int the Id of the product to delete
     * @return bool Boolean result of operation
     */
    public function deleteProduct($id) {
        $stmt = $this->pdoInstance->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute(array($id));
    }
}