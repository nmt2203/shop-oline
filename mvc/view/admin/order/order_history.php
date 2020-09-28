<div class="panel">
    <div class="panel-heading">
        <ul class="breadcrumb">
            <li><a href="/DoAnTH02/Admin/order/index/">Order management</a></li>
            <li><a href="/DoAnTH02/Admin/order/history/">History</a></li>
        </ul>
        <h3 style="text-align: center;">History transaction</h3>
    </div>
    <div>
        <!-- <form method="POST"> -->
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Phone number</th>
                    <th>Total cost</th>
                    <th>Order date</th>
                    <th>Status</th>
                    <th style="text-align: center;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($this->data["orders"] as $order) {
                ?>
                    <tr>
                        <td>
                            <?php echo $order->order_id; ?>
                        </td>
                        <?php
                        foreach ($this->data["users"] as $user) {
                            if ($user->user_id == $order->user_id) {
                        ?>
                                <td>
                                    <?php echo $user->name; ?>
                                </td>
                                <td>
                                    <?php echo $user->number; ?>
                                </td>
                        <?php
                            }
                        }
                        ?>
                        <td>
                            <?php echo $order->cost . "<small> d</small>"; ?>
                        </td>
                        <td>
                            <?php echo $order->order_date; ?>
                        </td>
                        <td>
                            <?php
                            switch ($order->status) {
                                case 0:
                                    echo "Waiting for administrator";
                                    break;
                                case 1:
                                    echo "In process";
                                    break;
                                case 2:
                                    echo "On the way";
                                    break;
                                case 3:
                                    echo "Delivered";
                                    break;
                            }
                            ?>
                        </td>
                        <td>
                            <a class="btn btn-info" href="/DoAnTH02/Admin/order/details/id=<?php echo $order->order_id; ?>"><span class="glyphicon glyphicon-edit"></span> Details</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        <!-- </form> -->
        <div class="container-fluid">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <ul class="pagination">
                    <?php
                    for ($k = 1; $k <= $this->data["number_of_page"]; $k++) {
                        if ($k != $this->data["page"]) {
                            echo '<li><a href="/DoAnTH02/Admin/order/history/page=' . $k . '">' . $k . '</li>';
                        } else {
                            echo '<li class="active"><a href="/DoAnTH02/Admin/order/history/page=' . $k . '">' . $k . '</li>';
                        }
                    }
                    ?>
                </ul>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</div>