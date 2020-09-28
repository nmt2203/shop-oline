<div class="row">
    <!-- The carousel -->
    <div id="transition-timer-carousel" class="carousel slide transition-timer-carousel" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#transition-timer-carousel" data-slide-to="0" class="active"></li>
            <li data-target="#transition-timer-carousel" data-slide-to="1"></li>
            <li data-target="#transition-timer-carousel" data-slide-to="2"></li>
        </ol>
        <!-- Wrapper for slides -->
        <div class="carousel-inner">
            <div class="item active">
                <img src="/DoAnTH02/public/uploads/decoration/slide-1.jpg" />
                <div class="carousel-caption">
                    <h1 class="carousel-caption-header">
                        Once you learn to read, you will be forever free.
                    </h1>
                    <p class="carousel-caption-text hidden-sm hidden-xs">
                    </p>
                </div>
            </div>
            <div class="item">
                <img src="/DoAnTH02/public/uploads/decoration/slide-2.jpg" />
                <div class="carousel-caption">
                    <h3 class="carousel-caption-header">
                        There is no friend as loyal as a book.
                    </h3>
                    <p class="carousel-caption-text hidden-sm hidden-xs">
                    </p>
                </div>
            </div>
            <div class="item">
                <img src="/DoAnTH02/public/uploads/decoration/slide-3.jpg" />
                <div class="carousel-caption">
                    <h1 class="carousel-caption-header">
                        A book is a dream that you hold in your hands.
                    </h1>
                    <p class="carousel-caption-text hidden-sm hidden-xs">
                    </p>
                </div>
            </div>
        </div>
        <!-- Controls -->
        <a class="left carousel-control" href="#transition-timer-carousel" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
        </a>
        <a class="right carousel-control" href="#transition-timer-carousel" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
        </a>
        <!-- Timer "progress bar" -->
        <hr class="transition-timer-carousel-progress-bar animate" />
    </div>
</div>
<div class="panel panel-primary" style="margin-top:10px;">
    <div class="panel-heading">
        <h3 style="text-align: center;">Most Rating</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <?php foreach ($this->data["most_rate"] as $books) {
                if ($books->book_id == null) continue;
            ?>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="product-grid">
                        <div class="product-image">
                            <a href="/DoAnTH02/Details/index/id=<?php echo $books->book_id; ?>/">
                                <?php if ($books->image != "") { ?>
                                    <img style="object-fit: cover; margin-left: auto;
     margin-right: auto; height: 300px;" class="pic-1" src="/DoAnTH02/public/uploads/book_image/<?php echo $books->image; ?>">
                                <?php  } else { ?>
                                    <img class="pic-1" src="/DoAnTH02/public/uploads/book_image/no_image.jpg">
                                <?php
                                } ?>
                            </a>
                            <ul class="social">
                                <li><a href="/DoAnTH02/Details/index/id=<?php echo $books->book_id; ?>/" data-tip="Quick View"><span class="glyphicon glyphicon-search"></span></a></li>
                                <li><a href="" onclick="onAddCart(<?php echo $books->book_id; ?>);" id="<?php if (isset($_SESSION["user_id"])) echo $books->book_id; ?>" onclick="onAddCart(<?php echo $books->book_id; ?>)" data-tip="Add to Cart"><span class="glyphicon glyphicon-shopping-cart"></span></a></li>
                            </ul>
                        </div>
                        <div class="product-content">
                            <h3 class="title"><a href="/DoAnTH02/Details/index/id=<?php echo $books->book_id; ?>/"><?php echo $books->name ?></a></h3>
                            <h3 class="title-authors" >
                                <?php foreach ($this->data["authors"] as $authors) {
                                    if ($authors->author_id == $books->author_id) {
                                ?>
                                        <a href="/DoAnTH02/Filter/according_to_author/id=<?php echo $authors->author_id; ?>/page=1"><?php echo $authors->name; ?></a>
                                <?php
                                    }
                                } ?>
                            </h3>
                            <div class="price ">
                                <?php if ($books->coupon_id == null) {
                                    echo $books->price . " " . "<small>vnd</small>";
                                } else {
                                    foreach ($this->data["coupons"] as $coupons) {
                                        if ($books->coupon_id == $coupons->coupon_id) {
                                            $sale = $books->price * (1 - $coupons->content);
                                            echo "<p style='color:red;float: left'> " . $sale . "<small>vnd</small></p>" . "<span style='text-decoration-line:line-through'> " . $books->price . "<small>vnd</small> </span>";
                                        }
                                    }
                                }
                                ?>
                                <br>
                                    <a class="add-to-cart" onclick="onAddCart(<?php echo $books->book_id; ?>);" href="">+ Add To Cart</a>
                            </div>

                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<div class="panel panel-success" style="margin-top:10px;">
    <div class="panel-heading">
        <h3 style="text-align: center;">Most sale</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <?php foreach ($this->data["most_sale"] as $books) {
                if ($books->book_id == null) continue;
            ?>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="product-grid">
                        <div class="product-image">
                            <a href="#">
                                <?php if ($books->image != "") { ?>
                                    <img class="pic-1" src="/DoAnTH02/public/uploads/book_image/<?php echo $books->image; ?>">
                                <?php  } else { ?>
                                    <img class="pic-1" src="/DoAnTH02/public/uploads/book_image/no_image.jpg">
                                <?php
                                } ?>
                            </a>
                            <ul class="social">
                                <li><a href="/DoAnTH02/Details/index/id=<?php echo $books->book_id; ?>/" data-tip="Quick View"><span class="glyphicon glyphicon-search"></span></a></li>
                                <li><a href="" onclick="onAddCart(<?php echo $books->book_id; ?>);" id="<?php if (isset($_SESSION["user_id"])) echo $books->book_id; ?>" onclick="onAddCart(<?php echo $books->book_id; ?>)" data-tip="Add to Cart"><span class="glyphicon glyphicon-shopping-cart"></span></a></li>
                            </ul>
                        </div>
                        <div class="product-content">
                            <h3 class="title"><a href="#"><?php echo $books->name ?></a></h3>
                            <h3 class="title">
                                <?php foreach ($this->data["authors"] as $authors) {
                                    if ($authors->author_id == $books->author_id) {
                                ?>
                                        <a href="#">by <?php echo $authors->name; ?></a>
                                <?php
                                    }
                                } ?>
                            </h3>
                            <div class="price">
                                <?php if ($books->coupon_id == null) {
                                    echo $books->price . " " . "<small>vnd</small>";
                                } else {
                                    foreach ($this->data["coupons"] as $coupons) {
                                        if ($books->coupon_id == $coupons->coupon_id) {
                                            $sale = $books->price * (1 - $coupons->content);
                                            echo "<p style='color:red'> " . $sale . "<small>vnd</small></p>" . "<span style='text-decoration-line:line-through'> " . $books->price . "<small>vnd</small> </span>";
                                        }
                                    }
                                }
                                ?>
                            </div>
                            <a class="add-to-cart" onclick="onAddCart(<?php echo $books->book_id; ?>);" href="">+ Add To Cart</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<div class="panel panel-info">
    <div class="panel-heading">
        <h3 style="text-align: center;">Newest update</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <?php foreach ($this->data["newest_update"] as $books) {
                if ($books->book_id == null) continue;
            ?>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="product-grid">
                        <div class="product-image">
                            <a href="#">
                                <?php if ($books->image != "") { ?>
                                    <img class="pic-1" src="/DoAnTH02/public/uploads/book_image/<?php echo $books->image; ?>">
                                <?php  } else { ?>
                                    <img class="pic-1" src="/DoAnTH02/public/uploads/book_image/no_image.jpg">
                                <?php
                                } ?>
                            </a>
                            <ul class="social">
                                <li><a href="/DoAnTH02/Details/index/id=<?php echo $books->book_id; ?>/" data-tip="Quick View"><span class="glyphicon glyphicon-search"></span></a></li>
                                <li><a href="" onclick="onAddCart(<?php echo $books->book_id; ?>);" id="<?php if (isset($_SESSION["user_id"])) echo $books->book_id; ?>" onclick="onAddCart(<?php echo $books->book_id; ?>)" data-tip="Add to Cart"><span class="glyphicon glyphicon-shopping-cart"></span></a></li>
                            </ul>
                        </div>
                        <div class="product-content">
                            <h3 class="title"><a href="#"><?php echo $books->name ?></a></h3>
                            <h3 class="title">
                                <?php foreach ($this->data["authors"] as $authors) {
                                    if ($authors->author_id == $books->author_id) {
                                ?>
                                        <a href="#">by <?php echo $authors->name; ?></a>
                                <?php
                                    }
                                } ?>
                            </h3>
                            <div class="price">
                                <?php if ($books->coupon_id == null) {
                                    echo $books->price . " " . "<small>vnd</small>";
                                } else {
                                    foreach ($this->data["coupons"] as $coupons) {
                                        if ($books->coupon_id == $coupons->coupon_id) {
                                            $sale = $books->price * (1 - $coupons->content);
                                            echo "<p style='color:red'> " . $sale . "<small>vnd</small></p>" . "<span style='text-decoration-line:line-through'> " . $books->price . "<small>vnd</small> </span>";
                                        }
                                    }
                                }
                                ?>
                            </div>
                            <a class="add-to-cart" onclick="onAddCart(<?php echo $books->book_id; ?>);" href="">+ Add To Cart</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<div class="panel panel-danger">
    <div class="panel-heading">
        <h3 style="text-align: center;">News</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <?php
            $count = 0;
            foreach ($this->data["news"] as $news) {
            ?>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="product-grid">
                        <div class="product-image">
                            <a href="#">
                                <?php if ($news->image != "") { ?>
                                    <img class="pic-1 " src="/DoAnTH02/public/uploads/news_image/<?php echo $news->image; ?>">
                                <?php  } ?>
                            </a>
                            <ul class="social">
                                <li><a href="/DoAnTH02/Home/news_details/id=<?php echo $news->news_id; ?>/" data-tip="Quick View"><span class="glyphicon glyphicon-search"></span></a></li>
                            </ul>
                        </div>
                        <div class="product-content">
                            <h3 class="title"><a href="#"><?php echo $news->name; ?></a></h3>
                        </div>
                    </div>
                </div>
            <?php
                $count++;
                if ($count == 3)
                    break;
            } ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    function onAddCart(id) {
        <?php if (isset($_SESSION["user_id"])) { ?>
            $.ajax({
                url: "/DoAnTH02/Shopping/add_to_cart/",
                type: 'POST',
                data: {
                    book_id: id,
                },
                success: function(response) {
                    if (response == "Insert") {
                        alert("A book was added to the shopping cart.");
                    } else {
                        if (response == "Update") {
                            alert("Increase the quantity of the selected book by 1.");
                        } else {
                            alert(response);
                        }
                    }
                }
            });
        <?php } else { ?>
            alert("You need to login to add product to cart.");
        <?php
        } ?>
        return false;
    }
</script>