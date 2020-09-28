<div class="panel">
    <div class="row">
        <div class="col-md-3 panel">
            <?php require "personal_side_bar.php"; ?>
        </div>
        <div class="col-md-9">
            <?php $order = $this->data["order"]; ?>
            <ul class="breadcrumb">
                <li><a href="/DoAnTH02/Account/order_list/page=1/">Order list</a></li>
                <li><a href="/DoAnTH02/Account/order_details/id=<?php echo $order->order_id; ?>"><?php echo "Order :" . $order->order_id; ?></a></li>
            </ul>
            <table class="table">
                <tr>
                    <h3 style="text-align: center; color : blue;">Details of the order</h3>
                </tr>
                <tr>
                    <h4>Phone number : <?php echo $order->number; ?></h4>
                </tr>
                <tr>
                    <h4>Order date : <?php echo $order->order_date; ?></h4>
                </tr>
                <tr>
                    <h4>Address : <?php echo $order->address; ?></h4>
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
                    <td colspan="6" align="right">
                        <h4 style="color: red;">Total cost : <?php echo  $total_cost . "<smal>vnd</small>"; ?> </h4>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>