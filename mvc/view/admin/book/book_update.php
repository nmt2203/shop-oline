<div class="panel">
    <div class="panel-heading">
        <ul class="breadcrumb">
            <li><a href="/DoAnTH02/Admin/book/index/">Book management</a></li>
            <li><a href="/DoAnTH02/Admin/book/update/id=<?php echo $this->data["book"]->book_id;?>">Update</a></li>
        </ul>
        <h3 style="text-align: center;">Updating a book</h3>
    </div>
    <div class="panel-body">
        <?php $book = $this->data["book"]; ?>
        <form class="form-horizontal" method='POST' enctype='multipart/form-data' action="/DoAnTH02/Admin/book/do_update/" onsubmit="return do_update(this);">
            <div id="update_error_message"></div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="id">ID:</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" name="id" placeholder="Enter book id" value="<?php echo $book->book_id; ?>" disabled>
                    <input type="hidden" class="form-control" name="book_id" placeholder="Enter book id" value="<?php echo $book->book_id; ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="name">Name:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="name" placeholder="Enter book name" value="<?php echo $book->name; ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="description">Description:</label>
                <div class="col-sm-10">
                    <textarea name="description" class="form-control" rows="5" placeholder="Enter description"><?php echo $book->description; ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="amount">Quantity:</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" name="quantity" placeholder="Enter book quantity" value="<?php echo $book->quantity;  ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="price">Price:</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" name="price" placeholder="Enter book price" value="<?php echo $book->price; ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="date">Date:</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" name="date" placeholder="Enter book date" value="<?php echo $book->date; ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="image">Image:</label>
                <div class="col-sm-10">
                    <input type="file" class="form-control" id="selected_image" name="image" placeholder="Select image">
                    <div class="form-group">
                        <label class="control-label col-sm-1" for="current_image">Current:</label>
                        <div class="col-sm-5">
                            <input type='hidden' class="form-control" name='current_image' value='<?php echo $book->image; ?>'>
                            <img src="/DoAnTH02/public/uploads/book_image/<?php echo $book->image; ?>" style="width: 250px;height:200px;">
                        </div>
                        <label class="control-label col-sm-1" for="current_image">New selected:</label>
                        <div class="col-sm-5">
                            <img id="image_tag" width="300px;" height="200px;" alt="new image" class="img-response" src="">

                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="author_id">Author:</label>
                <div class="col-sm-9">
                    <select class="form-control" name="author_id">
                        <?php
                        echo "<option>Select author </option>";
                        foreach ($this->data["authors"] as $author) {
                            if ($book->author_id != $author->author_id)
                                echo "<option value='$author->author_id'>$author->author_id - $author->name </option>";
                            else
                                echo "<option value='$author->author_id' selected>$author->author_id - $author->name </option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="category_id">Category:</label>
                <div class="col-sm-9">
                    <select class="form-control" name="category_id">
                        <?php
                        echo "<option>Select category </option>";
                        foreach ($this->data["categories"] as $category) {
                            if ($book->category_id != $category->category_id)
                                echo "<option value='$category->category_id'>$category->category_id - $catgegory->name </option>";
                            else
                                echo "<option value='$category->category_id' selected>$category->category_id - $category->name </option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="coupon_id">Coupon:</label>
                <div class="col-sm-9">
                    <select class="form-control" name="coupon_id">
                        <?php
                        echo "<option>Select coupon </option>";
                        foreach ($this->data["coupons"] as $coupon) {
                            $coupon_percent = $coupon->content * 100;
                            if ($book->coupon_id != $coupon->coupon_id)
                                echo "<option value='$coupon->coupon_id'>$coupon->coupon_id - $coupon_percent% </option>";
                            else
                                echo "<option value='$coupon->coupon_id' selected>$coupon->coupon_id - $coupon_percent% </option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2" for="publisher_id">Publisher:</label>
                <div class="col-sm-9">
                    <select class="form-control" name="publisher_id">
                        <?php
                        echo "<option>Select publisher </option>";
                        foreach ($this->data["publishers"] as $publisher) {
                            if ($book->publisher_id != $publisher->publisher_id)
                                echo "<option value='$publisher->publisher_id'>$publisher->publisher_id - $catgegory->name </option>";
                            else
                                echo "<option value='$publisher->publisher_id' selected>$publisher->publisher_id - $publisher->name </option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="status">Status:</label>
                <div class="col-sm-9">
                    <select class="form-control" name="status">
                        <option value='1' <?php if ($book->status == 1) echo "selected"; ?>>Enable </option>
                        <option value='2' <?php if ($book->status == 2) echo "selected"; ?>>Disable </option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input class="btn btn-success" type="submit" name="submit" value="update">
                    <input class="btn btn-danger" type="reset" name="reset" value="cancel">
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#image_tag').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#selected_image").change(function() {
        readURL(this);
    });

    function do_update(formData) {
        // alert(formData);
        var ajaxConfig = {
            type: "POST",
            url: "/DoAnTH02/Admin/book/do_update/",
            data: new FormData(formData),
            success: function(response) {
                if (response == "") {
                    $("#update_error_message").fadeIn(1000, function() {
                        $("#update_error_message").html("<div class='alert alert-success' style='width:100%; margin:auto;'>update successfully</div>");
                        $("#update_error_message").fadeOut(2000);
                    })
                } else {
                    $("#update_error_message").fadeIn(1000, function() {
                        $("#update_error_message").html("<div class='alert alert-danger' style='width:100%; margin:auto;'>" + response + "</div>");
                        $("#btn_update").html("try again");
                    })
                }
            }
        }
        if ($(formData).attr('enctype') == "multipart/form-data") {
            ajaxConfig["contentType"] = false;
            ajaxConfig["processData"] = false;
        }
        $.ajax(ajaxConfig);
        return false;
    }
</script>