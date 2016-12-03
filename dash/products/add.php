<?php
require "middleware.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>S O S A | Dashboard</title>

    <link rel="stylesheet" href="../../assests/vendor/bootstrap-3.3.7.min.css">
    <link rel="stylesheet" href="../../assests/css/sidebar-nav.css">
    <link rel="stylesheet" href="../../assests/css/laf.css">

    <script src="../../assests/vendor/jquery-3.1.1.min.js"></script>
    <script src="../../assests/vendor/bootstrap-3.3.7.min.js"></script>
    <script src="../../assests/js/main.js"></script>

    <style>
        body{ background: #EDECEC}

        .box {
            border-radius: 0;
            display: block;
            margin-top: 60px;
            padding: 50px 25px 10px;

            background: #FFF none repeat scroll 0 0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            margin-bottom: 30px;
        }

        .box-icon {
            background-color: #FFFFFF;
            border-radius: 50%;
            display: table;
            margin: -80px auto 0;
        }

        .box-icon > img {
            width: 128px;
            height: 128px;
        }

        .box-icon span {
            color: #fff;
            display: table-cell;
            text-align: center;
            vertical-align: middle;
        }

        .info h4 {
            font-size: 22px;
            text-transform: uppercase;
        }

        .info > p {
            color: #717171;
            font-size: 16px;
            padding-top: 10px;
            text-align: justify;
        }

        hr {
            margin-top: 53px;
            margin-bottom: 9px;
        }
    </style>
</head>
<body>

<div class="row">
    <?php require("../../dash/products/include/sidenav.html") ?>
    <!-- Main Content -->
    <div class="container">
        <div class="side-body">
            <div class="box">
                <div class="box-icon">
                    <img src="https://cdn4.iconfinder.com/data/icons/e-commerce-and-shopping-3/500/checked-checklist-notepad-128.png" alt=""/>
                </div>
                <div class="info">
                    <h4 class="text-center">Add new product</h4>
                    <form>
                        <div class="form-group">
                            <label class="control-label" for="name">Name</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                </div>
                                <input class="form-control" id="name" name="name" type="text"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="price">Price</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-gbp"></span>
                                </div>
                                <input class="form-control" id="price" name="price" type="text"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="stock">Stock</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-tasks"></span>
                                </div>
                                <input class="form-control" id="stock" name="stock" type="text"/>
                            </div>
                        </div>

                        <div class="form-group input-group">
                            <label for="size">Size</label>
                            <select id="size" name="size" class="form-control">
                                <option>XS</option>
                                <option>S</option>
                                <option>M</option>
                                <option>L</option>
                                <option>XL</option>
                            </select>
                        </div>

                        <label>Category</label>
                        <div class="form-group">
                            <label class="radio-inline">
                                <input type="radio" name="category" id="inlineRadio1" value="clothes" checked> Clothes
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="category" id="inlineRadio2" value="accessory"> Accessory
                            </label>
                        </div>

                        <input name="csrf_token" type="hidden" value="<?php echo $_SESSION["csrf_token"] ?>">

                        <hr>
                        <input type="submit" class="btn btn-success pull-right" value="Add product">
                        <hr>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>