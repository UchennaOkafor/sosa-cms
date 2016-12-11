<?php

session_start();

require "../../service/ProductService.php";

use \Sosa\Models\ResponseMessage;
use \Sosa\Service\ProductService;

//This is the API endpoint for the various AJAX requests.
$responseMsg = new ResponseMessage(false, array());

if (isset($_POST["csrf_token"]) && $_SESSION["csrf_token"] == $_POST["csrf_token"]) {

    normalizePostForm();
    $productService = new ProductService();

    switch ($_POST["action"]) {
        case "add":
            $responseMsg = $productService->tryAddProduct($_POST["name"], $_POST["price"], $_POST["stock"], $_POST["size"], $_POST["type"]);
            break;

        case "edit":
            $responseMsg = $productService->tryEditProduct($_POST["id"], $_POST["name"], $_POST["price"], $_POST["stock"], $_POST["size"], $_POST["type"]);
            break;

        case "delete":
            $responseMsg = $productService->tryDeleteProduct($_POST["id"]);
            break;

        default:
            $errorMessages[] = "Request action not specified";
            break;
    }
} else {
    $responseMsg->errorMessages[] = "Request was not recognized by server. Please reload the page and try again [Invalid request token].";
}

echo json_encode($responseMsg);

/**
 * Used to normalize post form so that if any of the data is not set in the post super globa, it will all be set to null anyway.
 * This later get's validated and rejected.
 */
function normalizePostForm() {
    $keys = array("id", "name", "price" , "stock", "size", "type", "action");

    foreach ($keys as $key) {
        if (! isset($_POST[$key])) {
            $_POST[$key] = null;
        }
    }
}