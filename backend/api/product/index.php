<?php

session_start();

require "../../service/ProductService.php";

use \Sosa\Models\ResponseMessage;
use \Sosa\Service\ProductService;

//This is the API endpoint for the various AJAX requests.
$responseMsg = new ResponseMessage(false, []);

if (isset($_POST["csrf_token"]) && $_SESSION["csrf_token"] == $_POST["csrf_token"]) {

    $productService = new ProductService();
    $action = isset($_POST["action"]) ? $_POST["action"] : null;

    switch ($action) {
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
            $errorMessages[] = "Action not specified";
            break;
    }
} else {
    $responseMsg->errorMessages[] = "Request was not recognized by server. Please reload the page and try again [Invalid request token]";
}

echo json_encode($responseMsg);