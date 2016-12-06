<?php

session_start();

require "../../ProductService.php";
use \Cms\Models\ResponseMessage;
use \Cms\Service\ProductService;

$responseMsg = new ResponseMessage(false, []);

if (isset($_POST["csrf_token"]) && $_SESSION["csrf_token"] == $_POST["csrf_token"]) {

    $productService = new ProductService();
    $action = isset($_POST["action"]) ? $_POST["action"] : null;

    switch ($action) {
        case "add":
            $responseMsg = $productService->tryAddProduct($_POST["name"], $_POST["price"], $_POST["stock"], $_POST["type"], $_POST["size"]);
            break;

        case "edit":
            $responseMsg = $productService->tryEditProduct($_POST["product_id"], $_POST["name"], $_POST["price"], $_POST["stock"], $_POST["type"], $_POST["size"]);
            break;

        case "delete":
            $responseMsg = $productService->tryDeleteProduct($_POST["product_id"]);
            break;

        default:
            $errorMessages[] = "Action not specified";
            break;
    }

} else {
    $responseMsg->errorMessages[] = "Request was not recognized by server. Please reload the page and try again [Invalid request token]";
}

echo json_encode($responseMsg);