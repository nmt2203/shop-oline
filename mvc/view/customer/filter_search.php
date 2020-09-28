<?php
// print_r($this->data["categorized_books"]);
?>
<div class="row">
    <h3 style="text-align: center;"> Searching for : <?php echo $this->data["search_name"] ?></h3>
    <h4 style="text-align: center;"> There are <?php echo ($this->data["count_book_according_to_search_name"]); ?> results </h4>
    <div class="col-md-12">
        <?php
        if (count($this->data["books"]) > 0) {
        ?>
            <div class="row">
                <?php
                foreach ($this->data["books"] as $books) {
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
                                    <li><a href="/DoAnTH02/Details/index/id=<?php echo $books->book_id;?>" data-tip="Quick View"><span class="glyphicon glyphicon-search"></span></a></li>
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
                                <a class="add-to-cart" onclick="onAddCart(<?php echo $book->book_id; ?>);" href="">+ Add To Cart</a>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
            <div style="margin: 15px;">
                <form method="POST" action="/DoAnTH02/Filter/according_to_search_name/">
                    <input type="hidden" name="search_name" value="<?php echo $this->data["search_name"]; ?>">
                    <?php
                    for ($n = 1; $n <= $this->data["number_of_page"]; $n++) {
                        if ($n != $this->data["page"]) { ?>
                            <input class="btn btn-default" type="submit" name="page" value="<?php echo $n; ?>">
                        <?php
                        } else {
                        ?>
                            <input class="btn btn-primary" type="submit" name="page" value="<?php echo $n; ?>">
                    <?php
                        }
                    }
                    ?>
                </form>
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