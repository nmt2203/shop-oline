<div class="row">
    <?php if ($this->data["get_all_carts"] != null) { ?>
        <h3>Shopping Cart</h3>
        <div class="col-md-8">
            <div class="panel">
                <div class="row">
                    <div>
                        <table class="table">
                            <thead>
                                <tr style="background:#f3f3f3;">
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Cost</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($this->data["get_all_carts_books"] as $book) {

                                ?>
                                    <tr>
                                        <td><img src="/DoAnTH02/public/uploads/book_image/<?php echo $book->image; ?>" width="70px;" height="100px;"></td>
                                        <td><?php echo $book->name; ?></td>
                                        <td>
                                            <?php
                                            foreach ($this->data["get_all_carts_coupons"] as $coupons) {
                                                foreach ($coupons as $id => $value) {
                                                    if ($book->book_id == $id) {
                                                        echo  $book->price * (1 - $value);
                                                    }
                                                }
                                            }
                                            ?>
                                        </td>
                                        <?php
                                        foreach ($this->data["get_all_carts"] as $cart) {
                                            if ($book->book_id == $cart->book_id) {
                                        ?>
                                                <td><input name="quantity" id=<?php echo $cart->book_id; ?> type="number" value="<?php echo $cart->quantity;?>" min="1" max="<?php echo $book->quantity; ?>" onchange="onChangeQuantity(<?php echo $book->book_id;?>)"></td>
                                                <td>
                                                    <?php
                                                    foreach ($this->data["get_all_carts_coupons"] as $coupons) {
                                                        foreach ($coupons as $id => $value) {
                                                            if ($book->book_id == $id) {
                                                                echo  $book->price * (1 - $value) * $cart->quantity;
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </td>
                                        <?php
                                            }
                                        }
                                        ?>
                                        <td>
                                            <button class="btn btn-danger" onclick="onDeleteCart(<?php echo $book->book_id; ?>)"><i class="glyphicon glyphicon-trash"></i></button>
                                        </td>
                                    </tr>
                                <?php

                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <table class="table">
                    <thead>
                        <tr style="background:#f3f3f3;">
                            <th>Total cost : <span style="color:red; font-size : 30px;"> <?php echo $this->data["get_total_cost"]; ?> </span> <small style="color:red;"> vnd</small></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                The max quantity you can change in the field Quantity is the amount of available book left in the store  .
                            </td>
                        </tr>
                        <tr>
                            <td>
                                If you buy directly from the store , you will get 5% discount on any book.
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <button class="btn btn-success btn-block" onclick="onCheckOut();"> Check out </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    <?php } else { ?>
        <div style="text-align: center;">
            <h3>The shopping cart is empty.</h3>
            <a href="/DoAnTH02/Home/index/" class="btn btn-primary"><span class="glyphicon glyphicon-shopping-cart"></span> Continue to purchase</a>
        </div>
    <?php } ?>
</div>

<script>
    function onChangeQuantity(id) {
        document.location.reload(false);
        var quantity = document.getElementById(id).value;
        var strurl = "/DoAnTH02/Shopping/do_change_quantity/";
        jQuery.ajax({
            url: strurl,
            type: 'POST',
            dataType: 'json',
            data: {
                book_id: id,
                quantity: quantity
            },
            success: function(data) {
                document.location.reload(true);
            }
        });
    }

    function onDeleteCart(id) {
        var strurl = "/DoAnTH02/Shopping/do_delete_cart/";
        if (confirm("Are you sure want to delete this product ?") == true) {
            jQuery.ajax({
                url: strurl,
                type: 'POST',
                data: {
                    book_id: id,
                },
                success: function(data) {
                    document.location.reload(true);
                }
            });
        }
    }

    function onCheckOut() {
        $.ajax({
            url: "/DoAnTH02/Shopping/check_out/",
            type: 'POST',
            data: {},
            success: function(response) {
                if (response == "") {
                    window.location.href="/DoAnTH02/Shopping/confirm_order/";
                } else {
                    alert(response);
                }
            }
        });
        return false;
    }
</script>