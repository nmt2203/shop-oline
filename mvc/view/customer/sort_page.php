<div class="panel">
    <div class="panel-heading">
        <ul class="breadcrumb">
            <li><a href="/DoAnTH02/Home/index/">Home</a></li>
            <li><a href="/DoAnTH02/Filter/according_to_category/id=1/page=1/">Filter</a></li>
            <li><a href="/DoAnTH02/Filter/<?php echo $this->data["sort_type"] ?>"><?php echo $this->data["title"]; ?></a></li>
        </ul>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h4 style="text-align: center;"> Sort : <?php echo $this->data["title"]; ?></h4>
                </div>
            </div>
            <div class="col-md-8">
                <?php
                if (count($this->data["books"]) > 0) {
                ?>
                    <div class="row">
                        <?php
                        foreach ($this->data["books"] as $books) {
                            if ($books->book_id == null) {
                                continue;
                            }
                        ?>
                            <div class="col-md-4">
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
                        <?php
                        }
                        ?>
                    </div>
                    <div>
                        <?php
                        if ($this->data["sort_type"] != "sort_sale" && $this->data["sort_type"] != "sort_rate") { ?>
                            <ul class="pagination">
                                <?php
                                for ($n = 1; $n <= $this->data["number_of_page"]; $n++) {
                                    if ($n != $this->data["page"]) { ?>
                                        <li><a href="/DoAnTH02/Filter/<?php echo $this->data["sort_type"]; ?>/page=<?php echo $n; ?>"> <?php echo $n; ?> </a></li>
                                    <?php
                                    } else {
                                    ?>
                                        <li class="active"><a href="/DoAnTH02/Filter/<?php echo $this->data["sort_type"]; ?>/page=<?php echo $n; ?>"> <?php echo $n; ?> </a></li>
                                <?php
                                    }
                                }
                                ?>
                            </ul>
                        <?php
                        }

                        ?>
                    </div>
                <?php
                } else {
                ?>
                    <div>
                        <h3>Empty</h3>
                    </div>
                <?php
                }

                ?>
            </div>
            <div class="col-md-4">
                <h4>Sort</h4>
                <ul class="list-group">
                    <li class="list-group-item"><a href="/DoAnTH02/Filter/sort_a_to_z/page=1">A to Z</a></li>
                    <li class="list-group-item"><a href="/DoAnTH02/Filter/sort_date/page=1">Newest update</a></li>
                    <li class="list-group-item"><a href="/DoAnTH02/Filter/sort_sale/page=1">Most sale</a></li>
                    <li class="list-group-item"><a href="/DoAnTH02/Filter/sort_rate/page=1">Most rate</a></li>
                    <li class="list-group-item"><a href="/DoAnTH02/Filter/sort_sale_off/page=1">Sale off</a></li>
                </ul>
            </div>
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