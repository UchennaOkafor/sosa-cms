<?php

namespace Cms\Service;

use Cms\Models\ResponseMessage;
use Cms\Provider\ProductProvider;

require "db/Database.php";
require "provider/ProductProvider.php";
require "models/ResponseMessage.php";

class ProductService {

    /**
     * @var ProductProvider
     */
    private $productProvider;

    function __construct() {
        $this->productProvider = new ProductProvider();
    }

    public function tryDeleteProduct($id) {
        $errorMessages = [];
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
        $errorMsgs = [];

        if (empty($name) || strlen($name) > 100) {
            $errorMsgs[] = "Product name cannot be empty or be greater than 100 characters";
        }

        if (! preg_match("/^\d{1,8}(\.\d{1,2})?$/", $price)) {
            $errorMsgs[] = "Price entered must a valid 2 decimal place number. Price must not be greater than 8 digits";
        }

        if (! filter_var($stock, FILTER_VALIDATE_INT)) {
            $errorMsgs[] = "Stock value is not a valid integer";
        }

        if (! in_array($size, ["XS", "S", "M", "L", "XL"])) {
            $errorMsgs[] = "Invalid size entered";
        }

        if (! in_array($type, ["Clothes", "Accessory"])) {
            $errorMsgs[] = "Product must either be an Accessory or Clothes";
        }

        $success = sizeof($errorMsgs) == 0;
        return new ResponseMessage($success, $errorMsgs);
    }
}