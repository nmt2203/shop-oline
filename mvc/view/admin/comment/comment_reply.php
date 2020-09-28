<?php
$comment = $this->data["comment"];
$book = $this->data["book"];
?>
<div class="panel">
    <div class="panel-heading">
        <ul class="breadcrumb">
            <li><a href="/DoAnTH02/Admin/comment/index/">Comment management</a></li>
            <li><a href="/DoAnTH02/Admin/comment/reply/id=<?php echo $comment->comment_id; ?>">Reply</a></li>
        </ul>
        <h3 style="text-align: center;">Reply a comment</h3>
    </div>
    <div class="panel-body">
        <div class="col-md-8">
            <form class="form-horizontal" method='POST' action="/DoAnTH02/Admin/comment/do_reply/" onsubmit="return do_reply();">
                <div id="reply_error_message"></div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="comment_id">Comment ID:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="comment_id" value="<?php echo $comment->comment_id; ?>" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="comment">Customer comment:</label>
                    <div class="col-sm-10">
                        <input type="hidden" id="book_id" value="<?php echo $comment->book_id; ?>">
                        <input type="hidden" id="comment_id" value="<?php echo $comment->comment_id; ?>">
                        <textarea id="comment" class="form-control" rows="5" disabled><?php echo $comment->description; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="reply">Your reply:</label>
                    <div class="col-sm-10">
                        <textarea id="reply" class="form-control" rows="5" placeholder="Enter your reply"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input class="btn btn-success" type="submit" name="reply" value="Reply">
                        <input class="btn btn-danger" type="reset" name="reset" value="Cancel">
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-4">
            <form class="form-horizontal">
                <div class="form-group">
                    <div class="col-sm-10">
                        <img src="/DoAnTH02/public/uploads/book_image/<?php echo $book->image; ?>" style="width: 250px;height:200px;">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="book_name" value="<?php echo $book->book_id." - ".$book->name; ?>" disabled>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function do_reply() {
        var reply = $("#comment_id").val();
        var book_id = $("#book_id").val();
        var description = $("#reply").val();
        var ajaxConfig = {
            type: "POST",
            url: "/DoAnTH02/Admin/comment/do_reply/",
            data: {
                reply : reply,
                book_id : book_id,
                description: description,
            },
            success: function(response) {
                if (response == "") {
                    $("#reply_error_message").fadeIn(1000, function() {
                        $("#reply_error_message").html("<div class='alert alert-success' style='width:100%; margin:auto;'>Reply successfully</div>");
                        $("#reply_error_message").fadeOut(3000);
                    })
                } else {
                    $("#reply_error_message").fadeIn(1000, function() {
                        $("#reply_error_message").html("<div class='alert alert-danger' style='width:100%; margin:auto;'>" + response + "</div>");
                        $("#btn_reply").html("try again");
                    })
                }
            }
        }
        $.ajax(ajaxConfig);
        return false;
    }
</script>