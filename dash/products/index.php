<?php
$attribute = "";
$query = "";

if (isset($_GET["attr"]) && isset($_GET["q"])) {
    $attribute = $_GET["attr"];
    $query = $_GET["q"];
}

function getLabelClassValue($quantityAmount) {
    $classValue = "label ";

    if ($quantityAmount >= 30) {
        $classValue .= "label-success";
    } else if ($quantityAmount >= 20) {
        $classValue .= "label-warning";
    } else if ($quantityAmount <= 10) {
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
                                    <input type="text" class="form-control" placeholder="Search">
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
            <h4>Ayy lmao</h4>

            <div class="panel panel-default">
                <div class="panel-heading">Manage products</div>

                <div class="container-fluid">
                    <label for="optionFilters">Refine search by</label>
                    <select id="optionFilters" class="form-control">
                        <option>Id</option>
                        <option>Name</option>
                        <option>Price</option>
                        <option>Type</option>
                        <option>Stock</option>
                    </select>

                    <div class="col-xs-6">
                        <input type="text" class="form-control" placeholder="Search">
                    </div>

                    <button id="btn-new-product" class="btn btn-primary">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
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
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>

                        <?php

                        if (! empty($attribute) && ! empty($query)) {

                            include "../../api/db/Database.php";
                            include "../../api/factory/ProductFactory.php";

                            $products = (new ProductFactory())->getAllProducts();

                            foreach ($products as $product) {
                                ?>
                                <tr>
                                    <td> <?php echo $product["id"]  ?> </td>
                                    <td> <?php echo $product["name"]  ?> </td>
                                    <td> <?php echo $product["type"]  ?> </td>
                                    <td> <?php echo $product["price"] ?> </td>
                                    <td> <span class="<?php echo getLabelClassValue(intval($product["stock_amount"])) ?>"><?php echo $product["stock_amount"] ?></span> </td>
                                    <td>
                                        <button class="btn btn-warning">Edit</button>
                                        <button class="btn btn-danger">Delete</button>
                                    </td>
                                </tr>
                            <?php } } ?>

                        </tbody>
                    </table>

                    <button id="btn-new-product" class="btn btn-primary">new product
                        <span class="glyphicon glyphicon-plus-sign"></span>
                    </button>
                    <br>
                    <br>
                </div>
            </div>

            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>

        </div>
    </div>

</body>
</html>

<!--TODO make sure to remove all inline CSS -  search for style=" and implment the css-->
<!--TODO make sure to make the CSS non embedded-->
<!--TODO fix head html tag-->