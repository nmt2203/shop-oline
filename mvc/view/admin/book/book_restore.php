<div class="panel">
    <div class="panel-heading">
        <ul class="breadcrumb">
            <li><a href="/DoAnTH02/Admin/book/index/">Book management</a></li>
            <li><a href="/DoAnTH02/Admin/book/restore/">Restore</a></li>
        </ul>
        <h3 style="text-align: center;">Trash can</h3>
    </div>
    <div>
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>Book id</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th colspan="3">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($this->data["books"] as $book) {
                ?>
                    <tr>
                        <td>
                            <?php echo $book->book_id; ?>
                        </td>
                        <td>
                            <img style="width: 70px; height : 70px;margin-left: auto;margin-right: auto;" src="/DoAnTH02/public/uploads/book_image/<?php echo $book->image; ?>">
                        </td>
                        <td>
                            <?php echo $book->name; ?>
                        </td>
                        <td>
                            <?php echo $book->price; ?>
                        </td>
                        <td>
                            <button name="restore" class="btn btn-success" onclick="return do_restore(<?php echo $book->book_id; ?>);" value='Restore'><span class="glyphicon glyphicon-ok"></span> Restore</button>
                        </td>
                        <td>
                            <a href="/DoAnTH02/Admin/book/update/id=<?php echo $book->book_id; ?>" name="details" class="btn btn-primary" value='Details'><span class="glyphicon glyphicon-edit"></span> Details</a>
                        </td>
                        <td>
                            <button name="restore" class="btn btn-danger" onclick="return do_delete(<?php echo $book->book_id; ?>);" value='Delete'><span class="glyphicon glyphicon-remove"></span> Delete</button>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        <div class="container-fluid">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <ul class="pagination">
                    <?php
                    for ($k = 1; $k <= $this->data["number_of_page"]; $k++) {
                        if ($k != $this->data["page"]) {
                            echo '<li><a href="/DoAnTH02/Admin/book/restore/page=' . $k . '">' . $k . '</li>';
                        } else {
                            echo '<li class="active"><a href="/DoAnTH02/Admin/book/restore/page=' . $k . '">' . $k . '</li>';
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
                url: "/DoAnTH02/Admin/book/do_restore/",
                data: {
                    book_id: id,
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
                url: "/DoAnTH02/Admin/book/do_delete/",
                data: {
                    book_id: id,
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