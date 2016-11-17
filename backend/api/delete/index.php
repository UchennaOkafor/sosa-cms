<?php

require "../../../backend/db/Database.php";
require "../../../backend/provider/ProductProvider.php";

$productId = $_POST["product_id"];
$csrfToken = $_POST["csrf_token"];
$requestResponse = ["error_messages" => []];

if ($_SESSION["csrf_token"] == $csrfToken) {
    $requestResponse["msg"][] = "Request was not recognized by server. (CSRF GUARD)";
    $requestResponse["success"] = false;
} else {

}

$requestResponse["success"] = count($requestResponse["error_messages"]) == 0;
echo json_encode($requestResponse);