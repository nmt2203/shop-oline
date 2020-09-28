<div class="panel">
    <div class="row">
        <div class="col-md-3 panel">
            <?php require "personal_side_bar.php"; ?>
        </div>
        <div class="col-md-9">
            <table class="table">
                <h3 style="text-align: center;">Comment</h3>
                <thead>
                    <tr>
                        <th>Comment id</th>
                        <th>Book name</th>
                        <th>Image</th>
                        <th>Date</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->data["comments"] as $comment) {
                        foreach ($this->data["books"] as $book) {
                            if ($comment->book_id == $book->book_id) {
                                if ($comment->status == 1) {
                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $comment->comment_id; ?>
                                        </td>
                                        <td>
                                            <a href="/DoAnTH02/Details/index/id=<?php echo $book->book_id; ?>"><?php echo $book->name; ?> </a>
                                        </td>
                                        <td>
                                            <img src="/DoAnTH02/public/uploads/book_image/<?php echo $book->image; ?>" width="70px;" height="100px;">
                                        </td>
                                        <td>
                                            <?php echo date_format(date_create($comment->date), "d-m-yy"); ?>
                                        </td>
                                        <td>
                                            <?php echo $comment->description; ?>
                                        </td>
                                    </tr>

                                    <?php ?>
                                <?php
                                } else {
                                ?>
                                    <tr>
                                        <td>
                                            <?php echo $comment->comment_id; ?>
                                        </td>
                                        <td>
                                            <a href="/DoAnTH02/Details/index/id=<?php echo $book->book_id; ?>"><?php echo $book->name; ?> </a>
                                        </td>
                                        <td>
                                            <img src="/DoAnTH02/public/uploads/book_image/<?php echo $book->image; ?>" width="70px;" height="100px;">
                                        </td>
                                        <td colspan="2" style="color:red;">
                                            This comment was removed by the administrator
                                        </td>
                                    </tr>
                    <?php
                                }
                            }
                        }
                    }

                    ?>
                </tbody>
            </table>
            <ul class="pagination">
                <?php
                for ($n = 1; $n <= $this->data["number_of_page"]; $n++) {
                    if ($n != $this->data["page"]) { ?>
                        <li><a href="/DoAnTH02/Account/comment_list/page=<?php echo $n; ?>"> <?php echo $n; ?> </a></li>;
                    <?php
                    } else {
                    ?>
                        <li class="active"><a href="/DoAnTH02/Account/comment_list/page=<?php echo $n; ?>"> <?php echo $n; ?> </a></li>
                <?php
                    }
                }
                ?>
            </ul>
        </div>
    </div>
</div>