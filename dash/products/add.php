<?php session_start(); ?>

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
    </style>
</head>

<body>

<input id="csrf_token" type="hidden" value="<?php echo $_SESSION["csrf_token"] ?>">

<div class="row">

    <?php require("../../dash/products/include/sidenav.html") ?>

    <!-- Main Content -->
    <div class="container">
        <div class="side-body">
            <div class="box">
                <div class="box-icon">
                    <img src="https://cdn0.iconfinder.com/data/icons/round-ui-icons/128/tick_green.png" alt=""/>
                </div>
                <div class="info">
                    <h4 class="text-center">Action successful</h4>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Name</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter product name">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">Type</label>
                        <input class="form-control" id="exampleInputPassword1" placeholder="Enter product ">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputAmount">Product price</label>
                        <div class="input-group">
                            <div class="input-group-addon">£</div>
                            <input type="text" class="form-control" id="exampleInputAmount" placeholder="Amount">
                        </div>
                    </div>

                    <label>Category</label>
                    <div class="form-group">
                        <label class="radio-inline">
                            <input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="clothes"> Clothes
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="inlineRadioOptions" id="inlineRadio2" value="accessory"> Accessory
                        </label>
                    </div>

                    <a href="" class="btn btn-primary">Add product</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>