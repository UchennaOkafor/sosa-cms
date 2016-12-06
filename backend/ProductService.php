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

        if ($this->productProvider->isProductExists($id)) {
            $msg->errorMessages[] = "Product Id does not exist";
        }

        if ($msg->success) {
            $msg->success = $this->productProvider->addProduct($name, $price, $stock, $size, $type);
        }

        return $msg;
    }

    public function tryAddProduct($name, $price, $stock, $size, $type) {
        $msg = $this->validateProductInput($name, $price, $stock, $size, $type);

        if ($msg->success) {
            $msg->success = $this->productProvider->addProduct($name, $price, $stock, $size, $type);
        }

        return $msg;
    }

    private function validateProductInput($name, $price, $stock, $size, $type) {
        $errorMsgs = [];

        if (empty($name) || strlen($name) > 150) {
            $errorMsgs["error_msgs"][] = "Product name cannot be empty or be greater than 150 characters";
        }

        if (! filter_var($price, FILTER_VALIDATE_FLOAT)) {
            $errorMsgs["error_msgs"][] = "Price entered must a valid 2 decimal place number";
        }

        if (! filter_var($stock, FILTER_VALIDATE_INT)) {
            $errorMsgs["error_msgs"][] = "Stock value is not a valid integer";
        }

        if (! in_array($size, ["XS", "S", "M", "L", "XL"])) {
            $errorMsgs["error_msgs"][] = "Invalid size entered";
        }

        if (! in_array($type, ["Clothes", "Accessory"])) {
            $errorMsgs["error_msgs"][] = "Product must either be an accessory or clothes";
        }

        $success = sizeof($errorMsgs) == 0;
        return new ResponseMessage($success, "", $errorMsgs);
    }

    public function requiredParamsNotEmpty($postParameters) {

        foreach ($postParameters as $value) {
            if (! isset($_POST[$value])) {
                return false;
            }
        }

        return true;
    }
}