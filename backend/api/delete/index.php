<?php

session_start();

require "../../../backend/db/Database.php";
require "../../../backend/provider/ProductProvider.php";

use \Cms\Provider\ProductProvider;

$productId = "";
$csrfToken = "";

$success = false;
$message = "";

if (! isset($_POST["product_id"]) || ! isset($_POST["csrf_token"])) {
    $message = "Missing expected parameters";
} else {

    $productId = $_POST["product_id"];
    $csrfToken = $_POST["csrf_token"];

    if ($_SESSION["csrf_token"] == $csrfToken) {
        $productProvider = new ProductProvider();

        if (! $productProvider->isProductExists($productId)) {
            $message = "Product you tried to delete does not exist, sorry.";
        } else {
            $productDeleted = $productProvider->deleteProduct($productId);
            $success = $productDeleted;
            $message = $productDeleted ? "Product has been successfully deleted" : "Product could not be deleted";
        }

    } else {
        $message = "Request was not recognized by server. Please reload the page and try again";
    }
}

echo json_encode(["success" => $success, "message" => $message]);