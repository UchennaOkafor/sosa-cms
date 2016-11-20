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
    <!-- Menu -->
    <div class="side-menu">

        <nav class="navbar navbar-default" role="navigation">

            <div class="navbar-header">
                <div class="brand-wrapper">
                    <!-- Hamburger -->
                    <button type="button" class="navbar-toggle">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <div class="profile-header-container hidden-xs">
                        <div class="profile-header-img">
                            <img class="img-circle" src="https://cdn3.iconfinder.com/data/icons/user-avatars-1/512/users-1-128.png" />
                            <!-- badge -->
                            <div class="rank-label-container">
                                <span class="label label-default rank-label">Welcome, Uchenna.</span>
                            </div>
                        </div>
                    </div>

                    <!-- Brand -->
                    <div class="brand-name-wrapper">
                        <a class="navbar-brand" href="#">
                            S O S A | Inventory
                        </a>
                    </div>

                    <!-- Search body -->
                    <div id="search" class="panel-collapse collapse in">
                        <div class="panel-body">
                            <form class="navbar-form" role="search">
                                <input name="attr" type="hidden" value="name">
                                <div class="form-group">
                                    <input name="query" type="text" class="form-control" placeholder="Search">
                                </div>
                                <button type="submit" class="btn btn-default "><span class="glyphicon glyphicon-search"></span></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Menu -->
            <div class="side-menu-container">
                <ul class="nav navbar-nav">

                    <li class="active"><a href="#"><span class="glyphicon glyphicon-home"></span> home</a></li>

                    <!-- Dropdown-->
                    <li class="panel panel-default" id="dropdown">
                        <a data-toggle="collapse" href="#dropdown-lvl1">
                            <span class="glyphicon glyphicon-th-list"></span> products <span class="caret"></span>
                        </a>

                        <!-- Dropdown level 1 -->
                        <div id="dropdown-lvl1" class="panel-collapse collapse">
                            <div class="panel-body">
                                <ul class="nav navbar-nav">
                                    <li><a href="#">view</a></li>
                                    <li><a href="#">add</a></li>
                                    <li><a href="#">edit</a></li>
                                    <li><a href="#">delete</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>

                    <li><a href="#"><span class="glyphicon glyphicon-cloud"></span> about</a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </div>

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
                                <option <?php if ($attribute == "id") echo "selected"; ?>>id</option>
                                <option <?php if ($attribute == "name") echo "selected"; ?>>name</option>
                                <option <?php if ($attribute == "price") echo "selected"; ?>>price</option>
                                <option <?php if ($attribute == "type") echo "selected"; ?>>type</option>
                                <option <?php if ($attribute == "stock") echo "selected"; ?>>stock</option>
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
                                <tr>
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
                            <button type="button" class="btn btn-danger">Yes</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>

<!--TODO fix head html tag-->
<!--TODO ensure that data output to the user has been well sanatized to prevent XSS attacks-->
<!--TODO ensure that