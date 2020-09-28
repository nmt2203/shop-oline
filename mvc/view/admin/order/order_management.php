<div class="panel">
    <div class="panel-heading">
        <h3 style="text-align: center;">Order management</h3>
    </div>
    <div class="panel-body">
        <nav class="navbar">
            <div class="container-fluid">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/DoAnTH02/Admin/order/history/"><span class="glyphicon glyphicon-film"></span> History</a></li>
                </ul>
            </div>
        </nav>
        <form method="POST">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>Order id</th>
                        <th>Customer</th>
                        <th>Phone number</th>
                        <th>Total cost</th>
                        <th>Order date</th>
                        <th>Status</th>
                        <th colspan="3" style="text-align: center;">Action</th>
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
                                <?php
                                switch ($order->status) {
                                    case 0:
                                        echo "<button class='btn btn-primary' onclick='on_process(".$order->order_id.")'> In process </button>";
                                        break;
                                    case 1:
                                        echo "<button class='btn btn-warning' onclick='on_delivery(".$order->order_id.")'> Delivery </button>";
                                        break;
                                    case 2:
                                        echo "<button class='btn btn-success' onclick='on_payment(".$order->order_id.")'> Confirm payment </button>";
                                        break;
                                }
                                ?>
                            </td>
                            <td>
                                <a class="btn btn-info" href="/DoAnTH02/Admin/order/details/id=<?php echo $order->order_id; ?>"><span class="glyphicon glyphicon-edit"></span> Details</a>
                            </td>
                            <td>
                                <button name="delete" class="btn btn-danger" onclick="on_remove(<?php echo $order->order_id; ?>);" value='Delete'><span class="glyphicon glyphicon-remove"></span> Remove</button>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </form>
        <div class="container-fluid">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <ul class="pagination">
                    <?php
                    for ($k = 1; $k <= $this->data["number_of_page"]; $k++) {
                        if ($k != $this->data["page"]) {
                            echo '<li><a href="/DoAnTH02/Admin/order/index/page=' . $k . '">' . $k . '</li>';
                        } else {
                            echo '<li class="active"><a href="/DoAnTH02/Admin/order/index/page=' . $k . '">' . $k . '</li>';
                        }
                    }
                    ?>
                </ul>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</div>
<script>
    function on_process(id) {
        var strurl = "/DoAnTH02/Admin/order/do_process_order/";
        var order_id = id;
        if (confirm("Are you sure want to process this order ?") == true) {
            jQuery.ajax({
                url: strurl,
                type: 'POST',
                data: {
                    order_id: id,
                    status : 1,
                },
                success: function(response) {
                    if (response == "") {
                        alert("Start processing order.");
                        document.location.reload(true);
                    } else {
                        alert(response);
                    }
                }
            });
        }
        return false;
    }
    function on_delivery(id) {
        var strurl = "/DoAnTH02/Admin/order/do_process_order/";
        var order_id = id;
        if (confirm("Are you sure want to delivery this order ?") == true) {
            jQuery.ajax({
                url: strurl,
                type: 'POST',
                data: {
                    order_id: id,
                    status : 2,
                },
                success: function(response) {
                    if (response == "") {
                        alert("Start delivering order.");
                        document.location.reload(true);
                    } else {
                        alert(response);
                    }
                }
            });
        }
        return false;
    }
    function on_payment(id) {
        var strurl = "/DoAnTH02/Admin/order/do_process_order/";
        var order_id = id;
        if (confirm("Are you sure want to confirm payment this order ?") == true) {
            jQuery.ajax({
                url: strurl,
                type: 'POST',
                data: {
                    order_id: id,
                    status : 3,
                },
                success: function(response) {
                    if (response == "") {
                        alert("Processed order.");
                        document.location.reload(true);
                    } else {
                        alert(response);
                    }
                }
            });
        }
        return false;
    }


    function on_remove(id) {
        var strurl = "/DoAnTH02/Admin/order/do_remove/";
        var order_id = id;
        if (confirm("Are you sure want to delete this order ?") == true) {
            jQuery.ajax({
                url: strurl,
                type: 'POST',
                data: {
                    order_id: id,
                },
                success: function(response) {
                    if (response == "") {
                        alert("Removed successfully.");
                        document.location.reload(true);

                    } else {
                        alert(response);
                    }
                }
            });
        }
        return false;
    }
    
</script>