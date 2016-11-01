<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>S O S A | Clothing</title>

    <link rel="stylesheet" href="../assests/include/bootstrap-3.3.7.min.css">
    <link rel="stylesheet" href="../assests/include/sidebar-nav.css">
    <script src="../assests/include/jquery-3.1.1.min.js"></script>
    <script src="../assests/include/bootstrap-3.3.7.min.js"></script>
    <script>
        $(function () {
            $('.navbar-toggle').click(function () {
                $('.navbar-nav').toggleClass('slide-in');
                $('.side-body').toggleClass('body-slide-in');
                $('#search').removeClass('in').addClass('collapse').slideUp(200);
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
            width: 120px;
            height: 120px;
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
        .navbar-brand {
            float: none;
            text-align: center;
            padding: 0;
        }






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

                    <div class="profile-header-container">
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
                            S O S A | CMS
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
                                    <li><a href="#">add</a></li>
                                    <li><a href="#">edit</a></li>
                                    <li><a href="#">delete</a></li>
                                    <li><a href="#">view</a></li>
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
            <h3>Manage items</h3>

            <div class="panel panel-default">
                <div class="panel-heading">Items</div>

                <div class="container-fluid input-group-btn">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default">Attribute</button>
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>



                        <label><input style="border-radius: 0px" ="text" class="form-control" aria-label="..."></label>

                        <button id="btn-new-product" class="btn btn-primary">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>


                    </div>
                </div>

                <div class="container-fluid">
                    <table class="table table-responsive table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>Tic Tac Tie</td>
                            <td>£15.87</td>
                            <td><span class="label label-success">50</span></td>
                            <td>
                                <button class="btn btn-warning">Edit</button>
                                <button class="btn btn-danger">Delete</button>
                            </td>
                        </tr>

                        <tr>
                            <td>4</td>
                            <td>Jordan Horizons</td>
                            <td>£95.99</td>
                            <td><span class="label label-warning">20</span></td>
                            <td>
                                <button class="btn btn-warning">Edit</button>
                                <button class="btn btn-danger">Delete</button>
                            </td>
                        </tr>

                        <tr>
                            <td>15</td>
                            <td>Nike Addidas Flux</td>
                            <td>£56.99</td>
                            <td><span class="label label-danger">2</span></td>
                            <td>
                                <button class="btn btn-warning">Edit</button>
                                <button class="btn btn-danger">Delete</button>
                            </td>
                        </tr>
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