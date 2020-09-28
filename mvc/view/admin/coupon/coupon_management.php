<div class="panel">
    <div class="panel-heading">
        <h3 style="text-align: center;">Coupon management</h3>
    </div>
    <div class="panel-body">
        <nav class="navbar">
            <div class="container-fluid">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/DoAnTH02/Admin/coupon/add/"><span class="glyphicon glyphicon-plus"></span> Add</a></li>
                    <li><a href="/DoAnTH02/Admin/coupon/restore/"><span class="glyphicon glyphicon-repeat"></span> Restore</a></li>
                </ul>
            </div>
        </nav>
        <form method="POST">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>
                            <button type="submit" onclick="on_mass_remove();" class="btn btn-danger" value='Mass Delete' name='mass_delete'><span class="glyphicon glyphicon-trash"></span> Mass delete</button>
                        </th>
                        <th>Coupon ID</th>
                        <th>Cotent</th>
                        <th colspan="2" style="text-align: center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->data["coupons"] as $coupon) {
                    ?>
                        <tr>
                            <td align="center">
                                <input type="checkbox" name="mass_remove_list[]" value=<?php echo $coupon->coupon_id; ?>>
                            </td>
                            <td>
                                <?php echo $coupon->coupon_id; ?>
                            </td>
                            <td>
                                <?php echo $coupon->content * 100 . "%"; ?>
                            </td>
                            <td>
                                <a class="btn btn-info" href="/DoAnTH02/Admin/coupon/update/id=<?php echo $coupon->coupon_id; ?>"><span class="glyphicon glyphicon-edit"></span> Update</a>
                            </td>
                            <td>
                                <button name="delete" class="btn btn-danger" onclick="on_remove(<?php echo $coupon->coupon_id; ?>);" value='Delete'><span class="glyphicon glyphicon-remove"></span> Remove</button>
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
                            echo '<li><a href="/DoAnTH02/Admin/coupon/index/page=' . $k . '">' . $k . '</li>';
                        } else {
                            echo '<li class="active"><a href="/DoAnTH02/Admin/coupon/index/page=' . $k . '">' . $k . '</li>';
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
    function on_remove(id) {
        var strurl = "/DoAnTH02/Admin/coupon/do_remove/";
        var coupon_id = id;
        if (confirm("Are you sure want to delete this product ?") == true) {
            jQuery.ajax({
                url: strurl,
                type: 'POST',
                data: {
                    coupon_id: id,
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

    function on_mass_remove() {
        try {
            var list = $("input[name='mass_remove_list[]']:checked").map(function() {
                return $(this).val();
            }).get();
            // alert(list);
            if (confirm("Are you sure want to delete all selected products ?") == true) {
                var ajaxConfig = {
                    type: "POST",
                    url: "/DoAnTH02/Admin/coupon/do_mass_remove/",
                    data: {
                        mass_remove_list: list,
                    },
                    success: function(response) {
                        if (response == "") {
                            alert("Mass removed.");
                            document.location.reload(true);
                        } else {
                            alert(response);
                        }
                    }
                }
                $.ajax(ajaxConfig);
            }
        } catch (err) {
            alert(err.message);
        }
        return false;

    }
</script>