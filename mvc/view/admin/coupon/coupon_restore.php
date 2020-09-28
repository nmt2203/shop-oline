<div class="panel">
    <div class="panel-heading">
        <ul class="breadcrumb">
            <li><a href="/DoAnTH02/Admin/coupon/index/">Coupon management</a></li>
            <li><a href="/DoAnTH02/Admin/coupon/restore/">Restore</a></li>
        </ul>
        <h3 style="text-align: center;">Trash can</h3>
    </div>
    <div>
        <form method="POST" action="">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>Coupon id</th>
                        <th>Content</th>
                        <th colspan="3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->data["coupons"] as $coupon) {
                    ?>
                        <tr>
                            <td>
                                <?php echo $coupon->coupon_id; ?>
                            </td>
                            <td>
                                <?php echo $coupon->content * 100 ."%" ; ?>
                            </td>
                            <td>
                                <button name="restore" class="btn btn-success" onclick="return do_restore(<?php echo $coupon->coupon_id; ?>);" value='Restore'><span class="glyphicon glyphicon-ok"></span> Restore</button>
                            </td>
                            <td>
                                <a href="/DoAnTH02/Admin/coupon/update/id=<?php echo $coupon->coupon_id; ?>" name="details" class="btn btn-primary" value='Details'><span class="glyphicon glyphicon-edit"></span> Details</a>
                            </td>
                            <td>
                                <button name="restore" class="btn btn-danger" onclick="return do_delete(<?php echo $coupon->coupon_id; ?>);" value='Delete'><span class="glyphicon glyphicon-remove"></span> Delete</button>
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
                            echo '<li><a href="/DoAnTH02/Admin/coupon/restore/page=' . $k . '">' . $k . '</li>';
                        } else {
                            echo '<li class="active"><a href="/DoAnTH02/Admin/coupon/restore/page=' . $k . '">' . $k . '</li>';
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
    function do_restore(id) {
        if (confirm("Are you sure want to restore this product ?") == true) {
            var ajaxConfig = {
                type: "POST",
                url: "/DoAnTH02/Admin/coupon/do_restore/",
                data: {
                    coupon_id: id,
                },
                success: function(response) {
                    if (response == "") {
                        alert("Restored.");
                        document.location.reload(true);
                    } else {
                        alert(response);
                    }
                }
            }
            $.ajax(ajaxConfig);
        }
        return false;
    }

    function do_delete(id) {
        if (confirm("Are you sure want to delete this product ?") == true) {
            var ajaxConfig = {
                type: "POST",
                url: "/DoAnTH02/Admin/coupon/do_delete/",
                data: {
                    coupon_id: id,
                },
                success: function(response) {
                    if (response == "") {
                        alert("Deleted.");
                        document.location.reload(true);
                    } else {
                        alert(response);
                    }
                }
            }
            $.ajax(ajaxConfig);
        }
        return false;
    }
</script>
