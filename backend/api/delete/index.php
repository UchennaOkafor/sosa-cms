<?php

session_start();

require "../../../backend/db/Database.php";
require "../../../backend/provider/ProductProvider.php";

use \Cms\Provider\ProductProvider;

$productId = "";
$csrfToken = "";

$success = false;
$message = "";

if (! isset($_GET["product_id"]) || ! isset($_GET["csrf_token"])) {
    $message = "Missing expected parameters";
} else {

    $productId = $_GET["product_id"];
    $csrfToken = $_GET["csrf_token"];

    if ($_SESSION["csrf_token"] == $csrfToken) {
        $productDeleted = (new ProductProvider())->deleteProduct($productId);

        $success = $productDeleted;
        $message = $productDeleted ? "Product has been successfully deleted" : "Product could not be deleted";
    } else {
        $message = "Request was not recognized by server. Please reload the page and try again";
    }
}

echo json_encode(["success" => $success, "message" => $message]);
//TODO make sure in deployment mode to change it to _POST. Because the phpStorm IDE is not allowing the use of post variables for some reason