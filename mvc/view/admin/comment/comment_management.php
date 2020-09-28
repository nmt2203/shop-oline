<div class="panel">
    <div class="panel-heading">
        <h3 style="text-align: center;">Comments management</h3>
    </div>
    <div class="panel-body">
        <nav class="navbar">
            <div class="container-fluid">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/DoAnTH02/Admin/comment/restore/"><span class="glyphicon glyphicon-repeat"></span> Restore</a></li>
                </ul>
            </div>
        </nav>
        <form method="POST">
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            <button type="submit" onclick="on_mass_remove();" class="btn btn-danger" value='Mass Delete' name='mass_delete'><span class="glyphicon glyphicon-trash"></span> Mass delete</button>
                        </th>
                        <th>ID</th>
                        <th>Book name</th>
                        <th>Image</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th colspan="2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->data["comments"] as $comment) {
                        foreach ($this->data["books"] as $book) {
                            if ($comment->book_id == $book->book_id) {
                    ?>
                                <tr>
                                    <td align="center">
                                        <input type="checkbox" name="mass_remove_list[]" value=<?php echo $comment->comment_id; ?>>
                                    </td>
                                    <td>
                                        <?php echo $comment->comment_id; ?>
                                    </td>
                                    <td>
                                        <a href="/DoAnTH02/Details/index/id=<?php echo $book->book_id; ?>"><?php echo $book->name; ?> </a>
                                    </td>
                                    <td>
                                        <img src="/DoAnTH02/public/uploads/book_image/<?php echo $book->image; ?>" width="50px;" height="70px;">
                                    </td>
                                    <td>
                                        <?php echo date_format(date_create($comment->date), "d-m-yy"); ?>
                                    </td>
                                    <td>
                                        <textarea rows="3"><?php echo $comment->description; ?></textarea>
                                    </td>
                                    <td>
                                        <a class="btn btn-info" href="/DoAnTH02/Admin/comment/reply/id=<?php echo $comment->comment_id; ?>"><span class="glyphicon glyphicon-send"></span> Reply</a>
                                    </td>
                                    <td>
                                        <button name="delete" class="btn btn-danger" onclick="on_remove(<?php echo $comment->comment_id; ?>);" value='Delete'><span class="glyphicon glyphicon-remove"></span> Remove</button>
                                    </td>
                                </tr>
                    <?php
                            }
                        }
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
                            echo '<li><a href="/DoAnTH02/Admin/comment/index/page=' . $k . '">' . $k . '</li>';
                        } else {
                            echo '<li class="active"><a href="/DoAnTH02/Admin/comment/index/page=' . $k . '">' . $k . '</li>';
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
        var strurl = "/DoAnTH02/Admin/comment/do_remove/";
        var comment_id = id;
        if (confirm("Are you sure want to delete this comment ?") == true) {
            jQuery.ajax({
                url: strurl,
                type: 'POST',
                data: {
                    comment_id: id,
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
            if (confirm("Are you sure want to delete all selected comments ?") == true) {
                var ajaxConfig = {
                    type: "POST",
                    url: "/DoAnTH02/Admin/comment/do_mass_remove/",
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