<div class="panel">
    <div class="panel-heading">
        <ul class="breadcrumb">
            <li><a href="/DoAnTH02/Admin/category/index/">Category management</a></li>
            <li><a href="/DoAnTH02/Admin/category/restore/">Restore</a></li>
        </ul>
        <h3 style="text-align: center;">Trash can</h3>
    </div>
    <div>
        <form method="POST" action="">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>Category id</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th colspan="3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->data["categories"] as $category) {
                    ?>
                        <tr>
                            <td>
                                <?php echo $category->category_id; ?>
                            </td>
                            <td>
                                <?php echo $category->name; ?>
                            </td>
                            <td>
                                <textarea class="form_control" rows="5" cols="50"> <?php echo $category->description; ?> </textarea>
                            </td>
                            <td>
                                <button name="restore" class="btn btn-success" onclick="return do_restore(<?php echo $category->category_id; ?>);" value='Restore'><span class="glyphicon glyphicon-ok"></span> Restore</button>
                            </td>
                            <td>
                                <a href="/DoAnTH02/Admin/category/update/id=<?php echo $category->category_id; ?>" name="details" class="btn btn-primary" value='Details'><span class="glyphicon glyphicon-edit"></span> Details</a>
                            </td>
                            <td>
                                <button name="restore" class="btn btn-danger" onclick="return do_delete(<?php echo $category->category_id; ?>);" value='Delete'><span class="glyphicon glyphicon-remove"></span> Delete</button>
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
                            echo '<li><a href="/DoAnTH02/Admin/category/restore/page=' . $k . '">' . $k . '</li>';
                        } else {
                            echo '<li class="active"><a href="/DoAnTH02/Admin/category/restore/page=' . $k . '">' . $k . '</li>';
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
        if (confirm("Are you sure want to restore this category ?") == true) {
            var ajaxConfig = {
                type: "POST",
                url: "/DoAnTH02/Admin/category/do_restore/",
                data: {
                    category_id: id,
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
        if (confirm("Are you sure want to delete this category for good ?") == true) {
            var ajaxConfig = {
                type: "POST",
                url: "/DoAnTH02/Admin/category/do_delete/",
                data: {
                    category_id: id,
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