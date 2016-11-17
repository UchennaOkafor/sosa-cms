<?php

use \Cms\Provider\ProductProvider;

require "middleware.php";
require "../../backend/provider/ProductProvider.php";

$attribute = "";
$query = "";

if (isset($_GET["attr"]) && isset($_GET["q"])) {
    $attribute = $_GET["attr"];
    $query = $_GET["q"];
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
                                <div class="form-group">
                                    <input name="q" type="text" class="form-control" placeholder="Search">
                                </div>

                                <input name="attr" type="hidden" value="Name">
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
            <h4>Ayy lmao</h4>

            <div class="panel panel-default">
                <div class="panel-heading">Manage products</div>

                <div class="container-fluid">

                    <br>
                    <form action="http://localhost:63342/sosa-cms/dash/products/" class="form-inline">
                        <div class="form-group">
                            <label for="optionFilters">Refine search by</label>
                            <select id="optionFilters" name="attr" class="form-control">
                                <option>id</option>
                                <option>name</option>
                                <option>price</option>
                                <option>type</option>
                                <option>stock</option>
                            </select>

                            <input name="q" type="text" class="form-control" placeholder="Search">

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

                        foreach ($products as $product) {
                            ?>
                            <tr>
                                <td> <?php echo $product["id"] ?> </td>
                                <td> <?php echo $product["name"] ?> </td>
                                <td> <?php echo $product["type"] ?> </td>
                                <td> <?php echo "£" . $product["price"] ?> </td>
                                <td> <span class="<?php echo getLabelClassValue($product["stock"]) ?>"><?php echo $product["stock"] ?></span> </td>
                                <td> <?php echo $product["created_at"] ?> </td>
                                <td>
                                    <a class="btn btn-warning btn-edit" data-product-id="<?php echo $product["id"] ?>">Edit</a>
                                    <a class="btn btn-danger btn-delete" data-product-id="<?php echo $product["id"] ?>">Delete</a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>

                        </tbody>
                    </table>

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
<!--TODO make sure to implement such that the when searching for an item, if no item is found it'll display that-->