<?php

use \Cms\Provider\ProductProvider;

require "middleware.php";
require "../../backend/provider/ProductProvider.php";

$attribute = "";
$query = "";

if (isset($_GET["attr"]) && isset($_GET["query"])) {
    $attribute = $_GET["attr"];
    $query = $_GET["query"];
}

function getLabelClassValue($quantityAmount) {
    $quantityAmount = intval($quantityAmount);
    $classValue = "label ";

    if ($quantityAmount >= 30) {
        $classValue .= "label-success";
    } else if ($quantityAmount >= 15) {
        $classValue .= "label-warning";
    } else if ($quantityAmount < 15) {
        $classValue .= "label-danger";
    }

    return $classValue;
}

function sanitizeHtml($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>S O S A | Dashboard</title>

    <link rel="stylesheet" href="../../assests/include/bootstrap-3.3.7.min.css">
    <link rel="stylesheet" href="../../assests/include/sidebar-nav.css">
    <link rel="stylesheet" href="../../assests/css/laf.css">

    <script src="../../assests/include/jquery-3.1.1.min.js"></script>
    <script src="../../assests/include/bootstrap-3.3.7.min.js"></script>
    <script src="../../assests/js/main.js"></script>
</head>

<body>

<input id="csrf_token" type="hidden" value="<?php echo $_SESSION["csrf_token"] ?>">

<div class="row">

    <?php require("../../dash/products/include/sidenav.html") ?>

    <!-- Main Content -->
    <div class="container-fluid">

        <div class="side-body">
            <div class="page-header">
                <h3>Inventory console</h3>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Manage products</div>
                <div class="container-fluid">
                    <br>
                    <form action="/sosa-cms/dash/products/" class="form-inline">
                        <div class="form-group">
                            <label for="searchFilters">Refine search by</label>
                            <select id="searchFilters" name="attr" class="form-control">
                                <option <?php if ($attribute == "id") echo "selected" ?>>id</option>
                                <option <?php if ($attribute == "name") echo "selected" ?>>name</option>
                                <option <?php if ($attribute == "price") echo "selected" ?>>price</option>
                                <option <?php if ($attribute == "type") echo "selected" ?>>type</option>
                                <option <?php if ($attribute == "stock") echo "selected" ?>>stock</option>
                            </select>

                            <input name="query" type="text" class="form-control" placeholder="Search" value="<?php if ($query != "") echo sanitizeHtml($query); ?>">

                            <button id="btn-new-product" type="submit" class="btn btn-primary">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                        </div>
                    </form>

                </div>

                <div class="container-fluid">
                    <table class="table table-responsive table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Date Added</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>

                        <?php
                        $products = [];
                        $productProvider = new ProductProvider();

                        if (empty($attribute) || empty($query)) {
                            $products = $productProvider->getAllProducts();
                        } else if (! empty($attribute) && ! empty($query)) {
                            $products = $productProvider->getProductsByAttribute($attribute, $query);
                        }

                        if ($products != null) {
                            foreach ($products as $product) {
                                ?>
                                <tr data-product-id="<?php echo $product["id"] ?>">
                                    <td> <?php echo $product["id"] ?> </td>
                                    <td> <?php echo sanitizeHtml($product["name"]); ?> </td>
                                    <td> <?php echo $product["type"] ?> </td>
                                    <td> <?php echo "£" . $product["price"] ?> </td>
                                    <td> <span class="<?php echo getLabelClassValue($product["stock"]) ?>"><?php echo $product["stock"] ?></span> </td>
                                    <td> <?php echo $product["created_at"] ?> </td>
                                    <td>
                                        <a class="btn btn-warning btn-edit" data-product-id="<?php echo $product["id"] ?>">Edit</a>
                                        <a class="btn btn-danger btn-delete" data-product-id="<?php echo $product["id"] ?>" data-product-name="<?php echo sanitizeHtml($product["name"]) ?>">Delete</a>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>

                        </tbody>
                    </table>

                    <?php
                    if ($products == null) {
                        $filteredInput = sanitizeHtml($query);
                        $warningAlert =
                            "<div class=\"alert alert-warning\">
                                Sorry, but no item with the $attribute <strong>\"$filteredInput\"</strong> could be found in the database. Please refine your search query.
                            </div>";

                        echo $warningAlert;
                    }
                    ?>
                    <button id="btn-new-product" class="btn btn-primary">new product
                        <span class="glyphicon glyphicon-plus-sign"></span>
                    </button>
                    <br>
                    <br>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title">Confirm delete</h4>
                        </div>
                        <div id="deleteModalBody" class="modal-body"> </div>
                        <div class="modal-footer">
                            <button id="btn-delete-item" type="button" class="btn btn-danger">Yes</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                        </div>

                    </div>
                </div>
            </div>
            <div id="deleteAlert" class="alert alert-dismissable hidden" role="alert"></div>
        </div>
    </div>
</div>

</body>
</html>

<!--TODO fix head html tag-->
<!--TODO ensure that data output to the user has been well sanatized to prevent XSS attacks-->
<!--TODO Work on the naming conventions for all id elements. Make sure they use the dash convention and not pascal casing, so btn-new-product instead of btnNewProduct-->
<!--TODO Once design of site is complete, try and implement Bootstrap4-->
<!--TODO Remove all <br> tags-->