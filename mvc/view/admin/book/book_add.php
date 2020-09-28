<div class="panel">
    <div class="panel-heading">
        <ul class="breadcrumb">
            <li><a href="/DoAnTH02/Admin/book/index/">Book management</a></li>
            <li><a href="/DoAnTH02/Admin/book/add/">Add</a></li>
        </ul>
        <h3 style="text-align: center;">Adding a book</h3>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" method='POST' action="/DoAnTH02/Admin/book/do_add/" enctype='multipart/form-data' onsubmit="return do_add(this);">
            <div id="add_error_message"></div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="name">Name:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="name" placeholder="Enter book name" value="<?php  ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="desciption">Description:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="description" placeholder="Enter book desciption" value="<?php  ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="amount">Quantity:</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" name="quantity" placeholder="Enter book quantity" value="<?php  ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="price">Price:</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" name="price" placeholder="Enter book price" value="<?php ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="date">Date:</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" name="date" placeholder="Enter book date" value="<?php  ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="image">Image:</label>
                <div class="col-sm-6">
                    <input type="file" class="form-control" id="image_selected" name="image" placeholder="Select image" required>
                </div>
                <div class="col-sm-4">
                    <img id="image_tag" width="300px;" height="200px;" class="img-response" src="">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="author_id">Author:</label>
                <div class="col-sm-9">
                    <select class="form-control" name="author_id" required>
                        <?php
                        echo "<option>Select author </option>";
                        foreach ($this->data["authors"] as $author) {
                            echo "<option value='$author->author_id'>$author_id - $author->name </option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="category_id">Category:</label>
                <div class="col-sm-9">
                    <select class="form-control" name="category_id" required>
                        <?php
                        echo "<option>Select category </option>";
                        foreach ($this->data['categories'] as $category) {
                            echo "<option value='$category->category_id'>$category->category_id - $category->name </option>";
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
                            $coupons = $coupon->content * 100;
                            echo "<option value='$coupon->coupon_id'>$coupon->coupon_id - $coupons % </option>";
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
                            echo "<option value='$publisher->publisher_id'>$publisher->publisher_id - $publisher->name </option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input class="btn btn-success" type="submit" id="btn_add" name="add" value="add">
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
    $("#image_selected").change(function() {
        readURL(this);
    });
    function do_add(formData) {
        // alert(formData);
        var ajaxConfig = {
            type: "POST",
            url: "/DoAnTH02/Admin/book/do_add/",
            data: new FormData(formData),
            success: function(response) {
                if (response == "Ok") {
                    $("#add_error_message").fadeIn(1000, function() {
                        $("#add_error_message").html("<div class='alert alert-success' style='width:100%; margin:auto;'>Add successfully</div>");
                        $("#add_error_message").fadeOut(2000);
                    })
                } else {
                    $("#add_error_message").fadeIn(1000, function() {
                        $("#add_error_message").html("<div class='alert alert-danger' style='width:100%; margin:auto;'>" + response + "</div>");
                        $("#btn_add").html("try again");
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