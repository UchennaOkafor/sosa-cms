<?php

require "../../../backend/db/Database.php";
require "../../../backend/provider/ProductProvider.php";

use \Cms\Provider\ProductProvider;

$productId = "";
$csrfToken = "";

$success = false;
$message = "";

if (! isset($_POST["product_id"]) || ! isset($_POST["csrf_token"])) {
    $message = "Expected parameters missing";
} else {

    $productId = $_POST["product_id"];
    $csrfToken = $_POST["csrf_token"];

    if ($_SESSION["csrf_token"] == $csrfToken) {
        $productDeleted = (new ProductProvider())->deleteProduct($productId);

        $success = $productDeleted;
        $message = $productDeleted ? "Product has been successfully deleted" : "Product could not be deleted";
    } else {
        $message = "Request was not recognized by server. (Forged request)";
    }
}

echo json_encode(["success" => $success, "message" => $message]);