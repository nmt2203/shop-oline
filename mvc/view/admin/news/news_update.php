<?php $news = $this->data["news"]; ?>
<div class="panel">
    <div class="panel-heading">
        <ul class="breadcrumb">
            <li><a href="/DoAnTH02/Admin/news/index/">News management</a></li>
            <li><a href="/DoAnTH02/Admin/news/update/id=<?php echo $news->news_id; ?>">Update</a></li>
        </ul>
        <h3 style="text-align: center;">Updating a news</h3>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" method='POST' enctype='multipart/form-data' action="/DoAnTH02/Admin/news/do_update/" onsubmit="return do_update(this);" >
            <div id="update_error_message"></div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="ID">ID:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="ID" placeholder="Enter news id" value="<?php echo $news->news_id ?>" disabled>
                    <input type="hidden" class="form-control" name="news_id" placeholder="Enter news id" value="<?php echo $news->news_id ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="name">Title:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="name" placeholder="Enter news name" value="<?php echo $news->name ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="content">Content:</label>
                <div class="col-sm-10">
                    <textarea id="content" class="form-control" name="content" rows="5" placeholder="Enter content" required><?php echo $news->content; ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="image">Image:</label>
                <div class="col-sm-10">
                    <input type="file" class="form-control" id="selected_image" name="image" placeholder="Select image">
                    <div class="form-group">
                        <label class="control-label col-sm-1" for="current_image">Current:</label>
                        <div class="col-sm-5">
                            <input type='hidden' class="form-control" name='current_image' value='<?php echo $news->image; ?>'>
                            <img src="/DoAnTH02/public/uploads/news_image/<?php echo $news->image; ?>" style="width: 200px;height:300px;">
                        </div>
                        <label class="control-label col-sm-1" for="current_image">New selected:</label>
                        <div class="col-sm-5">
                            <img id="image_tag" width="200px;" height="300px;" alt="new image" class="img-response" src="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="date">Date:</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" name="date" placeholder="Enter news date" value="<?php echo $news->date; ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="status">Status:</label>
                <div class="col-sm-10">
                    <select class="form-control" name="status">
                        <option value='0' <?php if ($news->status == 0) echo "selected"; ?>>Disable </option>
                        <option value='1' <?php if ($news->status == 1) echo "selected"; ?>>Enable </option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input class="btn btn-success" type="submit" name="update" value="Update">
                    <input class="btn btn-danger" type="reset" name="reset" value="cancel">
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    CKEDITOR.replace("content");
</script>

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
    function do_update(formData) {
        var form_data = new FormData(formData);
        var content = CKEDITOR.instances.content.getData();
        form_data.append("content",content);
        var ajaxConfig = {
            type: "POST",
            url: "/DoAnTH02/Admin/news/do_update/",
            data: form_data,
            success: function(response) {
                if (response == "") {
                    $("#update_error_message").fadeIn(1000, function() {
                        $("#update_error_message").html("<div class='alert alert-success' style='width:100%; margin:auto;'>update successfully</div>");
                        $("#update_error_message").fadeOut(3000);
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