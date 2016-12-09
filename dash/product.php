<?php
require "middleware.php";
require "../backend/provider/ProductProvider.php";

use \Sosa\Provider\ProductProvider;

$id = null;
$product = null;
$actionIsAdd = true;

if (isset($_GET["id"])) {
    $productProvider = new ProductProvider();
    $id = $_GET["id"];

    if ($productProvider->isProductExists($_GET["id"])) {
        $actionIsAdd = false;
        $product = $productProvider->getProductById($id);
    } else {
        header("location: product.php?action=add");
    }
}
?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>S O S A | Dashboard</title>

    <link rel="stylesheet" href="../assests/css/bootstrap-3.3.7.min.css">
    <link rel="stylesheet" href="../assests/css/sidebar-nav.css">
    <link rel="stylesheet" href="../assests/css/laf.css">

    <script src="../assests/vendor/jquery-3.1.1.min.js"></script>
    <script src="../assests/vendor/bootstrap-3.3.7.min.js"></script>
    <script src="../assests/js/main.js"></script>

    <style>
        /*Full credits to the owner of the card css, full link below*/
        /*http://bootsnipp.com/snippets/featured/box-material-design*/

        .box {
            border-radius: 0;
            display: block;
            margin-top: 60px;
            padding: 50px 25px 10px;

            background: #FFF none repeat scroll 0 0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            margin-bottom: 30px;

            max-width: 680px;
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
    <?php require("../dash/include/sidenav.html") ?>
    <!-- Main Content -->
    <div class="container">
        <div class="side-body">
<!--            Full credits to the owner of the card layout, link below-->
<!--            http://bootsnipp.com/snippets/featured/box-material-design-->
            <div class="box">
                <div class="box-icon">
                    <!-- Got image from https://www.iconfinder.com/icons/532781/checked_checklist_checkmark_clipboard_notepad_report_tasks_icon#size=128 -->
                    <img src="../assests/images/checklist-product.png" alt=""/>
                </div>
                <div class="info">
                    <h4 class="text-center"><?php echo $actionIsAdd ? "Add new product" : "Edit product" ?></h4>

                    <form id="multipurpose-form" method="POST" action="../backend/api/product/">
                        <div class="form-group input-group <?php if ($actionIsAdd) echo "hidden" ?>">
                            <label class="control-label" for="id">Id</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-lock"></span>
                                </div>
                                <input class="form-control" id="id" name="id" type="text" value="<?php if (! $actionIsAdd) echo $product["id"]; ?>" readonly/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="txt-name">Name</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                </div>
                                <?php  function sanitizeHtml($string) {
                                    return htmlspecialchars($string, ENT_QUOTES, "UTF-8");
                                }?>
                                <textarea class="form-control" id="txt-name" name="name" maxlength="100" required><?php if (! $actionIsAdd) echo sanitizeHtml($product["name"]); ?></textarea>
                            </div>
                            <label id="lbl-char-remaining" class="pull-right">100 character(s) remaining</label>
                        </div>

                        <div class="form-group input-group">
                            <label class="control-label" for="price">Price</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-gbp"></span>
                                </div>
                                <input class="form-control" id="price" name="price" type="number" min="0.01" step="0.01" " value="<?php if (! $actionIsAdd) echo $product["price"]; ?>" required/>
                            </div>
                        </div>

                        <div class="form-group input-group">
                            <label class="control-label" for="stock">Stock</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-tasks"></span>
                                </div>
                                <input class="form-control" id="stock" name="stock" type="number" min="1" value="<?php if (! $actionIsAdd) echo $product["stock"]; ?>" required/>
                            </div>
                        </div>

                        <div class="form-group input-group">
                            <label for="size">Size</label>
                            <select id="size" name="size" class="form-control" required>
                                <option <?php if ($product != null && $product["size"] == "XS") echo "selected"; ?>>XS</option>
                                <option <?php if ($product != null && $product["size"] == "S") echo "selected"; ?>>S</option>
                                <option <?php if ($product != null && $product["size"] == "M") echo "selected"; ?>>M</option>
                                <option <?php if ($product != null && $product["size"] == "L") echo "selected"; ?>>L</option>
                                <option <?php if ($product != null && $product["size"] == "XL") echo "selected"; ?>>XL</option>
                            </select>
                        </div>

                        <label>Type</label>
                        <div class="form-group">
                            <label class="radio-inline">
                                <input type="radio" name="type" id="clothes-radio" value="Clothes" checked>Clothes
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="type" id="accessory-radio" value="Accessory" <?php if ($product != null && $product["type"] == "Accessory") echo "checked"; ?>>Accessory
                            </label>
                        </div>

                        <input name="action" type="hidden" value="<?php echo $actionIsAdd ? "add" : "edit" ?>">
                        <input name="csrf_token" type="hidden" value="<?php echo $_SESSION["csrf_token"] ?>">

                        <hr>
                        <input type="submit" class="btn <?php echo $actionIsAdd ? "btn-primary" : "btn-success" ?> pull-right" value="<?php echo $actionIsAdd ? "Add product" : "Update product" ?> ">
                        <hr>
                    </form>
                </div>

                <div id="multipurpose-alert" class="alert hidden" role="alert"></div>
            </div>
            <a class="btn btn-default" href="view.php">
                <span class="glyphicon glyphicon-arrow-left"></span>
                Return
            </a>
        </div>
    </div>
</div>
</body>
</html>