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
        .container {
            width: 90%;
            margin-top: 50px;
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
            <form>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                </div>
                <fieldset class="form-group">
                    <legend>Type</legend>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="optionsRadios" id="optionsRadios1" value="option1" checked>
                            Accessory
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="optionsRadios" id="optionsRadios2" value="option2">
                            Clothes
                        </label>
                    </div>
                </fieldset>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

<!--            <form action="/sosa-cms/backend/api/delete/" method="post">-->
<!--                Name: <input type="text" name="product_id" value="0"><br>-->
<!--                E-mail: <input type="text" name="csrf_token" value="6867ef1aeb4dfd689187c939d791fced80724e259204f75b9f4bb10c9650935d"><br>-->
<!--                <input type="submit">-->
<!--            </form>-->
        </div>



    </div>
</div>

</body>
</html>