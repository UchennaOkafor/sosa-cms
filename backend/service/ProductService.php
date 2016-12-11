<?php

namespace Sosa\Service;

use Sosa\Models\ResponseMessage;
use Sosa\Provider\ProductProvider;

require "../../db/Database.php";
require "../../provider/ProductProvider.php";
require "../../models/ResponseMessage.php";

/**
 * This is the business logic layer of the application
 * Class ProductService
 * @package Sosa\Service
 */
class ProductService {

    /**
     * @var ProductProvider
     */
    private $productProvider;

    function __construct() {
        $this->productProvider = new ProductProvider();
    }

    public function tryDeleteProduct($id) {
        $errorMessages = array();
        $success = false;

        if (! $this->productProvider->isProductExists($id)) {
            $errorMessages[] = "Product you tried to delete does not exist, sorry.";
        } else {
            $success = $this->productProvider->deleteProduct($id);
        }

        return new ResponseMessage($success, $errorMessages);
    }

    public function tryEditProduct($id, $name, $price, $stock, $size, $type) {
        $msg = $this->validateProductInput($name, $price, $stock, $size, $type);

        if (! $this->productProvider->isProductExists($id)) {
            $msg->errorMessages[] = "Product Id does not exist";
            $msg->success = false;
        } else {
            if ($msg->success) {
                $msg->success = $this->productProvider->editProduct($id, $name, $price, $stock, $type, $size);
            }
        }

        return $msg;
    }

    public function tryAddProduct($name, $price, $stock, $size, $type) {
        $msg = $this->validateProductInput($name, $price, $stock, $size, $type);

        if ($msg->success) {
            $msg->success = $this->productProvider->addProduct($name, $price, $stock, $type, $size);
        }

        return $msg;
    }

    private function validateProductInput($name, $price, $stock, $size, $type) {
        $errorMessages = array();

        if (empty($name) || strlen($name) > 100) {
            $errorMessages[] = "Product name cannot be empty or be greater than 100 characters";
        }

        if (! preg_match("/^\d{1,8}(\.\d{1,2})?$/", $price)) {
            $errorMessages[] = "Price entered must a valid 2 decimal place number. Price must not be greater than 8 digits";
        }

        if (! filter_var($stock, FILTER_VALIDATE_INT)) {
            $errorMessages[] = "Stock value is not a valid integer";
        }

        if (! in_array($size, array("XS", "S", "M", "L", "XL", "N/A"))) {
            $errorMessages[] = "Invalid size entered";
        }

        if (! in_array($type, array("Clothes", "Accessory"))) {
            $errorMessages[] = "Product must either be an Accessory or Clothes";
        }

        $success = sizeof($errorMessages) == 0;
        return new ResponseMessage($success, $errorMessages);
    }
}