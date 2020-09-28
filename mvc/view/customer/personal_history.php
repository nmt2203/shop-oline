<div class="panel">
    <div class="row">
        <div class="col-md-3 panel">
            <?php require "personal_side_bar.php"; ?>
        </div>
        <div class="col-md-9">
            <table class="table">
                <h3 style="text-align: center;">Order</h3>
                <thead>
                    <tr>
                        <th>Order id</th>
                        <th>Date</th>
                        <th>Cost</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($this->data["orders"] as $order) { ?>
                        <tr>
                            <td>
                                <?php echo $order->order_id; ?>
                            </td>
                            <td>
                                <?php echo date_format(date_create($order->order_date), "d-m-yy"); ?>
                            </td>
                            <td>
                                <?php echo $order->cost . "<small> vnd</small>"; ?>
                            </td>
                            <td>
                                <?php
                                switch ($order->status) {
                                    case 0:
                                        echo "<button class='btn btn-default'> Waiting for administator </button>";
                                        break;
                                    case 1:
                                        echo "<button class='btn btn-warning'>In process </button>";
                                        break;
                                    case 2:
                                        echo "<button class='btn btn-danger'>On delivery </button>";
                                        break;
                                    case 3:
                                        echo "<button class='btn btn-success'>Done </button>";
                                        break;
                                }
                                ?>
                            </td>
                            <td>
                                <a href="/DoAnTH02/Account/order_details/id=<?php echo $order->order_id; ?>/" class="btn btn-info">Info</button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <ul class="pagination">
                <?php
                for ($n = 1; $n <= $this->data["number_of_page"]; $n++) {
                    if ($n != $this->data["page"]) { ?>
                        <li><a href="/DoAnTH02/Account/transaction_history/page=<?php echo $n; ?>"> <?php echo $n; ?> </a></li>;
                    <?php
                    } else {
                    ?>
                        <li class="active"><a href="/DoAnTH02/Account/transaction_history/page=<?php echo $n; ?>"> <?php echo $n; ?> </a></li>
                <?php
                    }
                }
                ?>
            </ul>
        </div>
    </div>
</div>