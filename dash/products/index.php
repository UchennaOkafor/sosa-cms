<?php

include "../../api/db/Database.php";
include "../../api/factory/ProductFactory.php";

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
    <script src="../../assests/include/jquery-3.1.1.min.js"></script>
    <script src="../../assests/include/bootstrap-3.3.7.min.js"></script>

    <script>
        $(function () {
            $('.navbar-toggle').click(function () {
                $('.navbar-nav').toggleClass('slide-in');
                $('.side-body').toggleClass('body-slide-in');
                //$('#search').removeClass('in').addClass('collapse').slideUp(200);
            });

            // Remove menu for searching
            $('#search-trigger').click(function () {
                $('.navbar-nav').removeClass('slide-in');
                $('.side-body').removeClass('body-slide-in');
            });
        });
    </script>

    <style>
        .profile-header-container{
            margin: 0 auto;
            text-align: center;
        }

        .profile-header-img {
            padding: 40px;
        }

        .profile-header-img > img.img-circle {
            border: 2px solid #51D2B7;
        }

        .rank-label-container {
            margin-top: -15px;
            text-align: center;
        }

        .label.label-default.rank-label {
            background-color: rgb(81, 210, 183);
            padding: 5px 10px 5px 10px;
            border-radius: 27px;
        }

        /*.navbar-brand {*/
        /*float: none;*/
        /*text-align: center;*/
        /*padding: 0;*/
        /*}*/






        .panel-body {
            padding: 4px;
        }

        .panel, .panel-heading {
            border-radius: 0;
        }

        #btn-new-product {
            float: right;
            margin-bottom: 10px;
        }

        .btn {
            border-radius: 2px;
        }
    </style>
</head>

<body>

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
                                <option>Id</option>
                                <option>Name</option>
                                <option>Price</option>
                                <option>Type</option>
                                <option>Stock</option>
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

                        if (empty($attribute) && empty($query)) {
                            $products = (new ProductFactory())->getAllProducts();
                        } else if (! empty($attribute) && ! empty($query)) {
                            //TODO make it fetch based on the attribute and query value
                            $products = (new ProductFactory())->getAllProducts();
                        }

                        foreach ($products as $product) {
                            ?>
                            <tr>
                                <td> <?php echo $product["id"] ?> </td>
                                <td> <?php echo $product["name"] ?> </td>
                                <td> <?php echo $product["type"] ?> </td>
                                <td> <?php echo "£" . $product["price"] ?> </td>
                                <td> <span class="<?php echo getLabelClassValue($product["stock_amount"]) ?>"><?php echo $product["stock_amount"] ?></span> </td>
                                <td> <?php echo $product["created_at"] ?> </td>
                                <td>
                                    <a class="btn btn-warning" href="http://www.stackoverflow.com/">Edit</a>
                                    <a class="btn btn-danger" href="http://www.stackoverflow.com/">Delete</a>
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


            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
                Launch demo modal
            </button>

            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel">Confirm delete</h4>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete this item?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>
</html>

<!--TODO make sure to remove all inline CSS -  search for style=" and implment the css-->
<!--TODO make sure to make the CSS non embedded-->
<!--TODO fix head html tag-->