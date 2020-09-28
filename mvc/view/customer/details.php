<style>
    /* css for the picture and basic imformation of the book */
    body {
        font-family: 'open sans';
        overflow-x: hidden;
    }

    img {
        max-width: 80%;
    }

    .preview {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -webkit-flex-direction: column;
        -ms-flex-direction: column;
        flex-direction: column;
    }

    @media screen and (max-width: 996px) {
        .preview {
            margin-bottom: 20px;
        }
    }

    .preview-pic {
        -webkit-box-flex: 1;
        -webkit-flex-grow: 1;
        -ms-flex-positive: 1;
        flex-grow: 1;
    }

    .preview-thumbnail.nav-tabs {
        border: none;
        margin-top: 15px;
    }

    .preview-thumbnail.nav-tabs li {
        width: 18%;
        margin-right: 2.5%;
    }

    .preview-thumbnail.nav-tabs li img {
        max-width: 100%;
        display: block;
    }

    .preview-thumbnail.nav-tabs li a {
        padding: 0;
        margin: 0;
    }

    .preview-thumbnail.nav-tabs li:last-of-type {
        margin-right: 0;
    }

    .tab-content {
        overflow: hidden;
    }

    .tab-content img {
        width: 100%;
        -webkit-animation-name: opacity;
        animation-name: opacity;
        -webkit-animation-duration: .3s;
        animation-duration: .3s;
    }

    .card {
        /* margin-top: 50px; */
        background: #eee;
        padding: 3em;
        line-height: 1.5em;
    }

    @media screen and (min-width: 997px) {
        .wrapper {
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
        }
    }

    .details {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -webkit-flex-direction: column;
        -ms-flex-direction: column;
        flex-direction: column;
    }

    .colors {
        -webkit-box-flex: 1;
        -webkit-flex-grow: 1;
        -ms-flex-positive: 1;
        flex-grow: 1;
    }

    .product-title,
    .price,
    .sizes,
    .colors {
        text-transform: UPPERCASE;
        font-weight: bold;
    }

    .checked,
    .price span {
        color: #ff9f1a;
    }

    .product-title,
    .rating,
    .product-description,
    .price,
    .vote,
    .sizes {
        margin-bottom: 15px;
    }

    .product-title {
        margin-top: 0;
    }

    .size {
        margin-right: 10px;
    }

    .size:first-of-type {
        margin-left: 40px;
    }

    .color {
        display: inline-block;
        vertical-align: middle;
        margin-right: 10px;
        height: 2em;
        width: 2em;
        border-radius: 2px;
    }

    .color:first-of-type {
        margin-left: 20px;
    }

    .add-to-cart,
    .like {
        background: #ff9f1a;
        padding: 1.2em 1.5em;
        border: none;
        text-transform: UPPERCASE;
        font-weight: bold;
        color: #fff;
        -webkit-transition: background .3s ease;
        transition: background .3s ease;
    }

    .add-to-cart:hover,
    .like:hover {
        background: #b36800;
        color: #fff;
    }

    .not-available {
        text-align: center;
        line-height: 2em;
    }

    .not-available:before {
        font-family: fontawesome;
        content: "\f00d";
        color: #fff;
    }

    .orange {
        background: #ff9f1a;
    }

    .green {
        background: #85ad00;
    }

    .blue {
        background: #0076ad;
    }

    .tooltip-inner {
        padding: 1.3em;
    }

    @-webkit-keyframes opacity {
        0% {
            opacity: 0;
            -webkit-transform: scale(3);
            transform: scale(3);
        }

        100% {
            opacity: 1;
            -webkit-transform: scale(1);
            transform: scale(1);
        }
    }

    @keyframes opacity {
        0% {
            opacity: 0;
            -webkit-transform: scale(3);
            transform: scale(3);
        }

        100% {
            opacity: 1;
            -webkit-transform: scale(1);
            transform: scale(1);
        }
    }

    /* end of css for book */

    /* // css for comment */
    @import url(//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css);

    /*Comment List styles*/
    .comment-list .row {
        margin-bottom: 0px;
    }

    .comment-list .panel .panel-heading {
        padding: 4px 15px;
        position: absolute;
        border: none;
        /*Panel-heading border radius*/
        border-top-right-radius: 0px;
        top: 1px;
    }

    .comment-list .panel .panel-heading.right {
        border-right-width: 0px;
        /*Panel-heading border radius*/
        border-top-left-radius: 0px;
        right: 16px;
    }

    .comment-list .panel .panel-heading .panel-body {
        padding-top: 6px;
    }

    .comment-list figcaption {
        /*For wrapping text in thumbnail*/
        word-wrap: break-word;
    }

    /* Portrait tablets and medium desktops */
    @media (min-width: 768px) {

        .comment-list .arrow:after,
        .comment-list .arrow:before {
            content: "";
            position: absolute;
            width: 0;
            height: 0;
            border-style: solid;
            border-color: transparent;
        }

        .comment-list .panel.arrow.left:after,
        .comment-list .panel.arrow.left:before {
            border-left: 0;
        }

        /*****Left Arrow*****/
        /*Outline effect style*/
        .comment-list .panel.arrow.left:before {
            left: 0px;
            top: 30px;
            /*Use boarder color of panel*/
            border-right-color: inherit;
            border-width: 16px;
        }

        /*Background color effect*/
        .comment-list .panel.arrow.left:after {
            left: 1px;
            top: 31px;
            /*Change for different outline color*/
            border-right-color: #FFFFFF;
            border-width: 15px;
        }

        /*****Right Arrow*****/
        /*Outline effect style*/
        .comment-list .panel.arrow.right:before {
            right: -16px;
            top: 30px;
            /*Use boarder color of panel*/
            border-left-color: inherit;
            border-width: 16px;
        }

        /*Background color effect*/
        .comment-list .panel.arrow.right:after {
            right: -14px;
            top: 31px;
            /*Change for different outline color*/
            border-left-color: #FFFFFF;
            border-width: 15px;
        }
    }

    .comment-list .comment-post {
        margin-top: 6px;
    }

    /* end of css for comment */
</style>
<div>
    <?php
    if ($this->data["book"] != null) {
        $book = $this->data["book"]; ?>
        <div class="panel-body">
            <!-- <div class="panel-heading"> -->
                <ul class="breadcrumb" style="margin-bottom: 0px;">
                    <li><a href="/DoAnTH02/Home/index/">Home</a></li>
                    <li><a href="/DoAnTH02/Details/index/id=<?php echo $book->book_id; ?>/">Details</a></li>
                    <li><a href="#"><?php echo $book->name; ?></a></li>
                </ul>
            <!-- </div> -->
            <div class="card">
                <h3 style="text-align: center;">Details of the book</h3>
                <div class="card">
                    <div class="container-fliud">
                        <div class="wrapper row">
                            <div class="preview col-md-6">
                                <div class="preview-pic tab-content">
                                    <div class="tab-pane active" id="pic-1"><img src="
                                <?php if ($book->image != "")
                                    echo "/DoAnTH02/public/uploads/book_image/$book->image";
                                else
                                    echo "/DoAnTH02/public/uploads/book_image/no_image.jpg";
                                ?>" /></div>
                                </div>
                            </div>
                            <div class="details col-md-6">
                                <h3 class="product-title"><?php echo $book->name; ?></h3>
                                <div class="rating">
                                    <h4 style="font-size : 30px;">
                                        <a href="/DoAnTH02/Details/rating/id=<?php echo $book->book_id; ?>/score=1/" title="Horrible"><span class="<?php if ($this->data["average_score"] < 1.0) echo "glyphicon glyphicon-star-empty";
                                                                                                                                                    else echo "glyphicon glyphicon-star"; ?>"></span></a>
                                        <a href="/DoAnTH02/Details/rating/id=<?php echo $book->book_id; ?>/score=2/" title="Bad"><span class="<?php if ($this->data["average_score"] < 2.0) echo "glyphicon glyphicon-star-empty";
                                                                                                                                                else echo "glyphicon glyphicon-star"; ?>"></span></a>
                                        <a href="/DoAnTh02/Details/rating/id=<?php echo $book->book_id; ?>/score=3/" title="Average"><span class="<?php if ($this->data["average_score"] < 3.0) echo "glyphicon glyphicon-star-empty";
                                                                                                                                                    else echo "glyphicon glyphicon-star"; ?>"></span></a>
                                        <a href="/DoAnTh02/Details/rating/id=<?php echo $book->book_id; ?>/score=4/" title="Good"><span class="<?php if ($this->data["average_score"] < 4.0) echo "glyphicon glyphicon-star-empty";
                                                                                                                                                else echo "glyphicon glyphicon-star"; ?>"></span></a>
                                        <a href="/DoAnTh02/Details/rating/id=<?php echo $book->book_id; ?>/score=5/" title="Awesome"><span class="<?php if ($this->data["average_score"] < 5.0) echo "glyphicon glyphicon-star-empty";
                                                                                                                                                    else echo "glyphicon glyphicon-star"; ?>"></span></a>
                                    </h4>
                                    <p>Average : <?php echo $this->data["average_score"]; ?> / 5 - <?php echo $this->data["all_rating_reviews"]; ?> votes </p>
                                </div>
                                <p class="product-description"><?php echo $book->description; ?></p>
                                <h4 class="price">current price: <?php if ($book->coupon_id == null) {
                                                                        echo $book->price . " " . "<small> vnd </small>";
                                                                    } else {
                                                                        foreach ($this->data["coupons"] as $coupons) {
                                                                            if ($book->coupon_id == $coupons->coupon_id) {
                                                                                $sale = $book->price * (1 - $coupons->content);
                                                                                $coupon = $coupons->content * 100;
                                                                                echo "<span style='color:red'> " . $sale . "<small> vnd </small></span>" . " <span style='color:blue' class='glyphicon glyphicon-circle-arrow-left'></span>" . "  
                                                                            " . "<span style='text-decoration-line:line-through'> " . $book->price . "<small> vnd </small> </span><p style='color:red'>sale off : $coupon %</p>";
                                                                            }
                                                                        }
                                                                    }
                                                                    ?>
                                </h4>
                                <h5 class="price">Status :
                                    <span> <?php
                                            switch ($book->status) {
                                                case 1:
                                                    echo "Available";
                                                    break;
                                                case 2:
                                                    echo "Removed";
                                                    break;
                                            }
                                            ?>
                                    </span></h5>
                                <h5 class="sizes">Author :
                                    <?php
                                    foreach ($this->data["authors"] as $author) {
                                        if ($book->author_id == $author->author_id) {
                                            echo "<a href='/DoAnTH02/Filter/according_to_author/id=$author->author_id/page=1'>" . $author->name . "</a>";
                                            break;
                                        }
                                    }
                                    ?>
                                </h5>
                                <h5 class="sizes">Category :
                                    <?php
                                    foreach ($this->data["categories"] as $category) {
                                        if ($book->category_id == $category->category_id) {
                                            echo "<a href='/DoAnTH02/Filter/according_to_category/id=$category->category_id/page=1'>" . $category->name . "</a>";
                                            break;
                                        }
                                    }
                                    ?>
                                </h5>
                                <h5 class="sizes">Publisher :
                                    <?php
                                    foreach ($this->data["publishers"] as $publisher) {
                                        if ($book->publisher_id == $publisher->publisher_id) {
                                            echo "<a href='/DoAnTH02/Filter/according_to_publisher/id=$publisher->publisher_id/page=1'>" . $publisher->name . "</a>";
                                            break;
                                        }
                                    }
                                    ?>
                                </h5>
                                <div class="action">
                                    <button onclick="onAddCart(<?php echo $book->book_id; ?>);" class="btn btn-info btn-lg">Add To Cart  <span class="glyphicon glyphicon-shopping-cart"></span></button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <h3>Leave a comment here</h3>
                <div class="col-md-6">
                    <form method="POST" action="/DoAnTH02/Details/add_comment/" onsubmit="return on_add_comment();">
                        <div class="form-group">
                            <input type="hidden" id="comment_book_id" name="book_id" value="<?php echo $book->book_id; ?>">
                            <input type="hidden" id="comment_reply" name="reply" value="">
                            <textarea class="form-control" rows="5" id="comment_description" name="description" placeholder="<?php if (!isset($_SESSION["user_id"])) {
                                                                                                                                    echo "You need to login to leave a comment";
                                                                                                                                } else {
                                                                                                                                    echo "Enter your comment";
                                                                                                                                } ?>"></textarea>
                        </div>
                        <div class="form-group">
                            <?php if (isset($_SESSION["user_id"])) { ?>
                                <button type="submit" name="submit" class="btn btn-primary"><span class="glyphicon glyphicon-send"></span> Send</button>
                            <?php  } ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php
    }
    if (count($this->data["comments"]) > 0) {
    ?>
        <div class="panel-footer">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="page-header">Comments</h2>
                    <section class="comment-list" id="comments_list">
                        <?php echo $this->data["display_comments"]; ?>
                    </section>
                </div>
            </div>
        </div>
    <?php
    } else {
    ?>
        <h4>No comment can be found!</h4>
    <?php
    }
    ?>
    <div class="reply_row" style="display : none;">
        <form method="POST" action="/DoAnTH02/Details/add_comment/" onsubmit="return on_add_reply();">
            <div class="form-group">
                <input type="hidden" id="reply_book_id" name="book_id" value="<?php echo $book->book_id; ?>">
                <input type="hidden" id="reply_reply" name="reply" value="">
                <textarea class="form-control" rows="5" id="reply_description" name="description" placeholder="Enter your reply comment"></textarea>
            </div>
            <div class="form-group">
                <?php if (isset($_SESSION["user_id"])) {  ?>
                    <button type="submit" id="add_reply" class="btn btn-success" name="submit" class="btn btn-primary"><span class="glyphicon glyphicon-send"></span> Send</button>
                    <button class="btn btn-danger" onclick="close_reply();"><span class="glyphicon glyphicon-remove"></span> Close</button>
                <?php  } ?>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    function onAddCart(id) {
        <?php if (isset($_SESSION["user_id"])) { ?>
            $.ajax({
                url: "/DoAnTH02/Shopping/add_to_cart/",
                type: 'POST',
                data: {
                    book_id: id,
                },
                success: function(response) {
                    if (response == "Insert") {
                        alert("A book was added to the shopping cart.");
                    } else {
                        if (response == "Update") {
                            alert("Increase the quantity of the selected book by 1.");
                        } else {
                            alert(response);
                        }
                    }
                }
            });
        <?php } else { ?>
            alert("You need to login to add product to cart.");
        <?php
        } ?>
        return false;
    }

    function reply(caller) {
        $("#reply_reply").val($(caller).attr('data-commentID'));
        $(".reply_row").insertAfter($(caller));
        $('.reply_row').show();
    }

    function close_reply() {
        $('.reply_row').hide();
    }

    function on_add_comment() {
        var reply = $("#comment_reply").val();
        var book_id = $("#comment_book_id").val();
        var description = $("#comment_description").val();
        var ajaxConfig = {
            type: "POST",
            url: "/DoAnTH02/Details/add_comment/",
            data: {
                reply: reply,
                book_id: book_id,
                description: description,
            },
            success: function(response) {
                if (response == "") {
                    alert("A new comment has been added.");
                    document.location.reload(true);
                } else {
                    alert(response);
                }
            }
        };
        $.ajax(ajaxConfig);
        return false;
    }

    function on_add_reply() {
        var reply = $("#reply_reply").val();
        var book_id = $("#reply_book_id").val();
        var description = $("#reply_description").val();
        $.ajax({
            url: "/DoAnTH02/Details/add_comment/",
            type: 'POST',
            data: {
                book_id: book_id,
                reply: reply,
                description: description,
            },
            success: function(response) {
                if (response == "") {
                    alert("A new reply has been added.");
                    document.location.reload(true);
                } else {
                    alert(response);
                }
            }
        });
        return false;
    }
</script>