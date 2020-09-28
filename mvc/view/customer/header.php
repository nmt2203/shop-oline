<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Shop Online</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- /* product  */ -->
    <style>
        .product-grid {
            /* font-family: Raleway, sans-serif; */
            text-align: center;
            padding: 0 0 72px;
            border: 1px solid rgba(0, 0, 0, .1);
            overflow: hidden;
            position: relative;
            z-index: 1
        }

        .product-grid .product-image {
            position: relative;
            transition: all .3s ease 0s
        }

        .product-grid .product-image a {
            display: block
        }

        .product-grid .product-image img {
            width: 100%;
            height: 200px;
        }

        .product-grid .pic-1 {
            opacity: 1;
            transition: all .3s ease-out 0s
        }

        .product-grid:hover .pic-1 {
            opacity: 1
        }

        .product-grid .pic-2 {
            opacity: 0;
            position: absolute;
            top: 0;
            left: 0;
            transition: all .3s ease-out 0s
        }

        .product-grid:hover .pic-2 {
            opacity: 1
        }

        .product-grid .social {
            width: 150px;
            padding: 0;
            margin: 0;
            list-style: none;
            opacity: 0;
            transform: translateY(-50%) translateX(-50%);
            position: absolute;
            top: 60%;
            left: 50%;
            z-index: 1;
            transition: all .3s ease 0s
        }

        .product-grid:hover .social {
            opacity: 1;
            top: 50%
        }

        .product-grid .social li {
            display: inline-block
        }

        .product-grid .social li a {
            color: #fff;
            background-color: #333;
            font-size: 16px;
            line-height: 40px;
            text-align: center;
            height: 40px;
            width: 40px;
            margin: 0 2px;
            display: block;
            position: relative;
            transition: all .3s ease-in-out
        }

        .product-grid .social li a:hover {
            color: #fff;
            background-color: #ef5777
        }

        .product-grid .social li a:after,
        .product-grid .social li a:before {
            content: attr(data-tip);
            color: #fff;
            background-color: #000;
            font-size: 12px;
            letter-spacing: 1px;
            line-height: 20px;
            padding: 1px 5px;
            white-space: nowrap;
            opacity: 0;
            transform: translateX(-50%);
            position: absolute;
            left: 50%;
            top: -30px
        }

        .product-grid .social li a:after {
            content: '';
            height: 15px;
            width: 15px;
            border-radius: 0;
            transform: translateX(-50%) rotate(45deg);
            top: -20px;
            z-index: -1
        }

        .product-grid .social li a:hover:after,
        .product-grid .social li a:hover:before {
            opacity: 1
        }

        .product-grid .product-discount-label,
        .product-grid .product-new-label {
            color: #fff;
            background-color: #ef5777;
            font-size: 12px;
            text-transform: uppercase;
            padding: 2px 7px;
            display: block;
            position: absolute;
            top: 10px;
            left: 0
        }

        .product-grid .product-discount-label {
            background-color: #333;
            left: auto;
            right: 0
        }

        .product-grid .rating {
            color: #FFD200;
            font-size: 12px;
            padding: 12px 0 0;
            margin: 0;
            list-style: none;
            position: relative;
            z-index: -1
        }

        .product-grid .rating li.disable {
            color: rgba(0, 0, 0, .2)
        }

        .product-grid .product-content {
            background-color: #fff;
            text-align: left;
            padding: 12px 0;
            margin: 0 auto;
            position: absolute;
            left: 0;
            right: 0;
            bottom: -27px;
            z-index: 1;
            transition: all .3s
        }

        .product-grid .product-content a:link {
            text-decoration-line: none;
        }

        .product-grid:hover .product-content {
            bottom: 0
        }

        .product-grid .title {
            font-size: 12px;
            font-weight: 200s;
            text-align: center;
            letter-spacing: .5px;
            text-transform: capitalize;
            margin: 0 0 10px;
            transition: all .3s ease 0s
            text-align: center;
        }
        .product-grid .title-authors {
            font-size: 12px;
            font-weight: 200s;
            text-align: center;
            letter-spacing: .5px;
            text-transform: capitalize;
            margin: 0 0 10px;
            transition: all .3s ease 0s
            text-align: center;
        }

        .product-grid .title-authors a {
            font-size: 12px;
            color: #828282;
            text-align: center;
        }
        .clear-fix{
            clear: both;
        }

        .product-content .title a:hover,
        .product-content:hover .title a {

            color: #ef5777
        }

        .product-content:hover .title-authors a {
            text-align: center;

            color: #b3f0ff;
        }

        .product-grid .price {
            color: #333;
            font-size: 17px;
            font-family: Montserrat, sans-serif;
            font-weight: 700;
            letter-spacing: .6px;
            margin-bottom: 8px;
            text-align: center;
            transition: all .3s
        }

        .product-grid .price span {
            color: #999;
            font-size: 13px;
            font-weight: 400;
            text-decoration: line-through;
            margin-left: 3px;
            display: inline-block
        }

        .product-grid .add-to-cart {
            color: #000;
            font-size: 13px;
            font-weight: 600
        }

        @media only screen and (max-width:990px) {
            .product-grid {
                margin-bottom: 30px
            }
        }

        /* slider */
        .transition-timer-carousel .carousel-caption {
            background: -moz-linear-gradient(top, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.1) 4%, rgba(0, 0, 0, 0.5) 32%, rgba(0, 0, 0, 1) 100%);
            /* FF3.6+ */
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, rgba(0, 0, 0, 0)), color-stop(4%, rgba(0, 0, 0, 0.1)), color-stop(32%, rgba(0, 0, 0, 0.5)), color-stop(100%, rgba(0, 0, 0, 1)));
            /* Chrome,Safari4+ */
            background: -webkit-linear-gradient(top, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.1) 4%, rgba(0, 0, 0, 0.5) 32%, rgba(0, 0, 0, 1) 100%);
            /* Chrome10+,Safari5.1+ */
            background: -o-linear-gradient(top, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.1) 4%, rgba(0, 0, 0, 0.5) 32%, rgba(0, 0, 0, 1) 100%);
            /* Opera 11.10+ */
            background: -ms-linear-gradient(top, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.1) 4%, rgba(0, 0, 0, 0.5) 32%, rgba(0, 0, 0, 1) 100%);
            /* IE10+ */
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.1) 4%, rgba(0, 0, 0, 0.5) 32%, rgba(0, 0, 0, 1) 100%);
            /* W3C */
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#00000000', endColorstr='#000000', GradientType=0);
            /* IE6-9 */
            width: 100%;
            left: 0px;
            right: 0px;
            bottom: 0px;
            text-align: left;
            padding-top: 5px;
            padding-left: 15%;
            padding-right: 15%;
        }

        .transition-timer-carousel .carousel-caption .carousel-caption-header {
            margin-top: 10px;
            font-size: 24px;
        }

        @media (min-width: 970px) {

            /* Lower the font size of the carousel caption header so that our caption
    doesn't take up the full image/slide on smaller screens */
            .transition-timer-carousel .carousel-caption .carousel-caption-header {
                font-size: 36px;
            }
        }

        .transition-timer-carousel .carousel-indicators {
            bottom: 0px;
            margin-bottom: 5px;
        }

        .transition-timer-carousel .carousel-control {
            z-index: 11;
        }

        .transition-timer-carousel .transition-timer-carousel-progress-bar {
            height: 5px;
            background-color: #5cb85c;
            width: 0%;
            margin: -5px 0px 0px 0px;
            border: none;
            z-index: 11;
            position: relative;
        }

        .transition-timer-carousel .transition-timer-carousel-progress-bar.animate {
            /* We make the transition time shorter to avoid the slide transitioning
    before the timer bar is "full" - change the 4.25s here to fit your
    carousel's transition time */
            -webkit-transition: width 4.25s linear;
            -moz-transition: width 4.25s linear;
            -o-transition: width 4.25s linear;
            transition: width 4.25s linear;
        }

        /* end of slider */
        .center_title {
            text-align: center;
            background-color: blue;
            color: white;
        }
    </style>
    <script>
        $(document).ready(function() {
            //Events that reset and restart the timer animation when the slides change
            $("#transition-timer-carousel").on("slide.bs.carousel", function(event) {
                //The animate class gets removed so that it jumps straight back to 0%
                $(".transition-timer-carousel-progress-bar", this)
                    .removeClass("animate").css("width", "0%");
            }).on("slid.bs.carousel", function(event) {
                //The slide transition finished, so re-add the animate class so that
                //the timer bar takes time to fill up
                $(".transition-timer-carousel-progress-bar", this)
                    .addClass("animate").css("width", "100%");
            });
            //Kick off the initial slide animation when the document is ready
            $(".transition-timer-carousel-progress-bar", "#transition-timer-carousel")
                .css("width", "100%");
        });
    </script>
    <style>
        #result {
            position: absolute;
            width: 100%;
            max-width: 400px;
            cursor: pointer;
            overflow-y: auto;
            max-height: 200px;
            box-sizing: border-box;
            z-index: 1001;
        }
    </style>

</head>

<body>
    <div class="panel-group">
        <div class="panel-heading">
            <div class="container">
                <nav class="nav">
                    <ul class="nav navbar-nav navbar-right">
                        <?php if (!isset($_SESSION["user_id"])) { ?>
                            <li><a class="btn-primary" href="#" data-toggle="modal" data-target="#login_form"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                            <div class="modal fade" id="login_form" role="dialog">
                                <div class="modal-dialog" style="background-color: white;">
                                    <?php
                                    require "login.php";
                                    ?>
                                </div>
                            </div>
                            <li><a class="btn btn-default btn-sm" href="/DoAnTH02/Home/register/"><span class="glyphicon glyphicon-user"></span> Signup</a></li>
                            <?php } else {
                            if ($_SESSION["user_authority"] != 1) {  ?>
                                <li><a class="btn-primary" class="btn btn-primary btn-sm" href='#'><span class='glyphicon glyphicon-user'></span>Hello <?php echo $_SESSION["user_name"]; ?></a></li>
                            <?php } else { ?>
                                <li><a class="btn-primary" class="btn btn-primary btn-sm" href='/DoAnTH02/Admin/'><span class='glyphicon glyphicon-globe'> Managemnt</a></li>
                            <?php
                            } ?>
                            <li><a class="btn btn-default btn-sm" href="/DoAnTH02/Home/do_logout/"><span class="glyphicon glyphicon-log-out"></span>Log out</a></li>
                        <?php } ?>
                    </ul>
                </nav>
                <div class="row" style="margin-top: 10px;">
                    <div class="col-md-3">
                        <a href="/DoAnTH02/Home/index/"><img style="margin-left: auto;margin-right:auto;display:block;" width="100px;" height="100px;" src="<?php echo "http://localhost:8080/DoAnTH02/public/uploads/decoration/book-logo.jpg"; ?>"></a>
                    </div>
                    <div class="col-md-5">
                        <form style="margin-top: auto;margin-bottom:auto;" class="form-inline navbar-form" method="POST" action="/DoAnTH02/Filter/according_to_search_name/">
                            <!-- <form style="margin-top: auto;margin-bottom:auto;" class="form-inline navbar-form" method="POST" action="/DoAnTH02/Filter/live_search/"> -->
                            <div class="form-group form-group-lg">
                                <div class="text-primary"><i class="fa fa-phone"></i> 099999999</div>
                                <div class="text-primary"><i class="fa fa-envelope-square"></i> contact@bookshop.vn</div>
                                <input type="text" class="form-control" id="search_name" name="search_name" placeholder="Search">
                                <input type="hidden" class="form-control" name="page" value="1" placeholder="Search">
                                <button name="search_button" class="btn btn-info btn-lg" type="submit">
                                    <i class="glyphicon glyphicon-search"></i>
                                </button>
                                <ul class="list-group" id="result"></ul>

                                <script>
                                    $(document).ready(function() {
                                        $("#search_name").keyup(function() {
                                            var query = $("#search_name").val();
                                            if (query != "" || query != null) {
                                                $.ajax({
                                                    url: '/DoAnTH02/Filter/live_search/',
                                                    method: 'POST',
                                                    data: {
                                                        search_name: query,
                                                    },
                                                    success: function(data) {
                                                        $("#result").html(data);
                                                    },
                                                });
                                            }
                                        });
                                    });
                                </script>
                            </div>
                        </form>
                    </div>
                    <?php
                    if (isset($_SESSION["user_id"])) {
                    ?>
                        <div class="col-md-2">
                            <a href="/DoAnTH02/Account/">
                                <img style="margin-left: auto;margin-right:auto;display:block;" width="50px;" height="50px;" src="<?php echo "/DoAnTH02/public/uploads/decoration/book-user.png"; ?>">
                                <p style="text-align: center;">Account</p>
                            </a>
                        </div>
                        <div class="col-md-2">
                            <a href="/DoAnTH02/Shopping/index/">
                                <img style="margin-left: auto;margin-right:auto;display:block;" width="50px;" height="50px;" src="<?php echo "/DoAnTH02/public/uploads/decoration/cart2.png"; ?>">
                                <p style="text-align: center;">Cart (<?php echo count($this->data["get_all_carts"]); ?>)</p>
                                <p style="text-align: center;"><?php echo $this->data["total_cost"]; ?> <small> vnd</small></p>
                            </a>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <nav class="navbar navbar-inverse">
                    <ul class="nav navbar-nav">
                        <li><a href="/DoAnTH02/Home/"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <span class="glyphicon glyphicon-user"></span> Author <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <?php
                                foreach ($this->data["authors"] as $authors) {
                                ?>
                                    <li><a href="/DoAnTH02/Filter/according_to_author/id=<?php echo $authors->author_id; ?>/page=1"><?php echo $authors->name; ?></a></li>
                                <?php
                                }
                                ?>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <span class="glyphicon glyphicon-th"></span> Category <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <?php
                                foreach ($this->data["categories"] as $category) {
                                ?>
                                    <li><a href="/DoAnTH02/Filter/according_to_category/id=<?php echo $category->category_id; ?>/page=1/"><?php echo $category->name; ?></a></li>
                                <?php
                                }
                                ?>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <span class="glyphicon glyphicon-king"></span> Publisher <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <?php
                                foreach ($this->data["publishers"] as $publisher) {
                                ?>
                                    <li><a href="/DoAnTH02/Filter/according_to_publisher/id=<?php echo $publisher->publisher_id; ?>/page=1/"><?php echo $publisher->name; ?></a></li>
                                <?php
                                }
                                ?>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <span class="glyphicon glyphicon-sort"></span> Sort <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="/DoAnTH02/Filter/sort_a_to_z/page=1/">A-Z</a></li>
                                <li><a href="/DoAnTH02/Filter/sort_date/page=1/">Date</a></li>
                                <li><a href="/DoAnTH02/Filter/sort_sale/page=1/">Most Sale</a></li>
                                <li><a href="/DoAnTH02/Filter/sort_rate/page=1/">Most rating</a></li>
                                <li><a href="/DoAnTH02/Filter/sort_sale_off/page=1/">Sale off</a></li>
                            </ul>
                        </li>
                        <li><a href="/DoAnTH02/Home/news/page=1/"><span class="glyphicon glyphicon-info-sign"></span> News</a></li>
                        <li><a href="/DoAnTH02/Home/introduction/"><span class="glyphicon glyphicon-asterisk"></span> Introduction</a></li>
                        <!-- <li><a href="#"><span class="glyphicon glyphicon-phone-alt"></span> Contact</a></li> -->
                    </ul>
                </nav>
            </div>
        </div>