<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>S O S A | Error</title>
    <link rel="stylesheet" href="../../assests/include/bootstrap-3.3.7.min.css">
    <style>
        .container {
            margin-top: 2%;
        }

        body {
          background-color: #EEEEEE;
        }
    </style>
</head>

<body>

<div class="container">
    <div class="panel panel-danger">
        <div class="panel-heading">
            <h3 class="panel-title">Site Error</h3>
        </div>
        <div class="panel-body">
            <?php
            if (isset($_SESSION["DB_ERROR_MSG"])) {
                echo "There was an error trying to connect to the database.<br>";
                echo "<b>Error: " . $_SESSION["DB_ERROR_MSG"] . "</b>";
            } else {
                echo "An error has occurred in your site that has prevented it from continuing.";
            }
        ?>
        </div>
    </div>
</div>

</body>
</html>

<?php die() ?>