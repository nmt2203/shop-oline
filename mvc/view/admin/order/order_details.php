<?php $order = $this->data["order"]; ?>
<div class="panel">
    <div class="panel-heading">
        <ul class="breadcrumb">
            <li><a href="/DoAnTH02/Admin/order/index/">Order management</a></li>
            <li><a href="/DoAnTH02/Admin/order/details/">Details</a></li>
        </ul>
        <h3 style="text-align: center;">Order details</h3>
    </div>
    <div>
        <table class="table">
            <?php foreach ($this->data["users"] as $user) {
                if ($user->user_id == $order->user_id) { ?>
                    <tr>
                        <h4> <?php echo "Customer : ".$user->name; ?> </h4>
                    </tr>
                    <tr>
                        <h4> <?php echo "Username : ".$user->username; ?> </h4>
                    </tr>
            <?php
                }
            } ?>

            <tr>
                <h4>Receiver : <?php echo $order->receiver; ?></h4>
            </tr>
            <tr>
                <h4>Phone number : <?php echo $order->number; ?></h4>
            </tr>
            <tr>
                <h4>Order date : <?php echo $order->order_date; ?></h4>
            </tr>
            <tr>
                <h4>Delivery address : <?php echo $order->address; ?></h4>
            </tr>
            <tr>
                <h4>Order ID : <?php echo $order->order_id; ?></h4>
            </tr>
        </table>

        <table class="table">
            <th>STT</th>
            <th>Image</th>
            <th>Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Cost</th>
            <?php
            $STT = 0;
            $total_cost = 0;
            foreach ($this->data["order_details"] as $order_details) {
                foreach ($this->data["book_order_details"] as $book_order_details) {
                    if ($order_details->book_id == $book_order_details->book_id) {
            ?>
                        <tr>
                            <td><?php echo $STT += 1; ?></td>
                            <td> <img src="/DoAnTH02/public/uploads/book_image/<?php echo $book_order_details->image; ?>" width="70px;" height="100px;"></td>
                            <td> <?php echo $book_order_details->name; ?> </td>
                            <td> <?php echo $order_details->quantity; ?> </td>
                            <?php
                            $coupon_for_this_book = 1;
                            foreach ($this->data["coupons"] as $coupon) {
                                if ($coupon->coupon_id == $book_order_details->coupon_id) {
                                    $coupon_for_this_book = 1 - $coupon->content;
                                }
                            }
                            ?>
                            <td> <?php echo $book_order_details->price * $coupon_for_this_book . "<small> vnd</small>"; ?> </td>
                            <td> <?php $total_cost += $book_order_details->price * $coupon_for_this_book * $order_details->quantity;
                                    echo $book_order_details->price * $coupon_for_this_book * $order_details->quantity . "<small> vnd</small>"; ?>
                            </td>
                        </tr>
            <?php
                    }
                }
            }
            ?>
            <tr>
                <td colspan="5">
                    <h3>Total cost </h3>
                </td>
                <td >
                    <h3 style="color: red;"><?php echo  $total_cost . "<smal>vnd</small>"; ?> </h3>
                </td>
            </tr>
        </table>
    </div>
</div>