<div class="panel">
    <div class="panel-heading">
        <ul class="breadcrumb">
            <li><a href="/DoAnTH02/Admin/comment/index/">Comment management</a></li>
            <li><a href="/DoAnTH02/Admin/comment/restore/">Restore</a></li>
        </ul>
        <h3 style="text-align: center;">Trash can</h3>
    </div>
    <div>
        <form method="POST" action="">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Book name</th>
                        <th>Image</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->data["comments"] as $comment) {
                        foreach ($this->data["books"] as $book) {
                            if ($comment->book_id == $book->book_id) {
                    ?>
                                <tr>
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
                                        <button name="restore" class="btn btn-success" onclick="return do_restore(<?php echo $comment->comment_id; ?>);" value='Restore'><span class="glyphicon glyphicon-ok"></span> Restore</button>
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
                            echo '<li><a href="/DoAnTH02/Admin/comment/restore/page=' . $k . '">' . $k . '</li>';
                        } else {
                            echo '<li class="active"><a href="/DoAnTH02/Admin/comment/restore/page=' . $k . '">' . $k . '</li>';
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
        if (confirm("Are you sure want to restore this comment ?") == true) {
            var ajaxConfig = {
                type: "POST",
                url: "/DoAnTH02/Admin/comment/do_restore/",
                data: {
                    comment_id: id,
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
</script>