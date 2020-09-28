<?php $publisher = $this->data["publisher"]; ?>
<div class="panel">
    <div class="panel-heading">
        <ul class="breadcrumb">
            <li><a href="/DoAnTH02/Admin/publisher/index/">Publisher management</a></li>
            <li><a href="/DoAnTH02/Admin/publisher/update/id=<?php echo $publisher->publisher_id; ?>/">Update</a></li>
        </ul>
        <h3 style="text-align: center;">Updating a publisher</h3>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" method='POST' action="/DoAnTH02/Admin/publisher/do_update/" onsubmit="return do_update();">
            <div class="form-group">
                <label class="control-label col-sm-2" for="publisher_id">ID:</label>
                <div class="col-sm-10">
                    <input type="hidden" value="<?php echo $publisher->publisher_id; ?>" name="publisher_id" id="publisher_id">
                    <input type="number" class="form-control" placeholder="Enter publisher id" value="<?php echo $publisher->publisher_id; ?>" disabled>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="name">Name:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter publisher name" value="<?php echo $publisher->name; ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="address">Address:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="address" name="address" placeholder="Enter publisher address" value="<?php echo $publisher->address; ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="email">Email:</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter publisher email" value="<?php echo $publisher->email; ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="number">Number:</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" id="number" name="number" placeholder="Enter publisher number" value="<?php echo $publisher->number; ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="status">Status:</label>
                <div class="col-sm-9">
                    <select class="form-control" name="status">
                        <option value="">Choose status</opption>
                        <option value='0' <?php if ($publisher->status == 0) {
                                                echo "selected";
                                            }
                                            ?>>Disable </option>
                        <option value='1' <?php if ($publisher->status == 1) {
                                                echo "selected";
                                            }
                                            ?>>Enable </option>
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
    function do_update() {
        var publisher_id = $("#publisher_id").val();
        var name = $("#name").val();
        var address = $("#address").val();
        var email = $("#email").val();
        var number = $("#number").val();
        var status = $("#status").val();
        var ajaxConfig = {
            type: "POST",
            url: "/DoAnTH02/Admin/publisher/do_update/",
            data: {
                publisher_id: publisher_id,
                name: name,
                address: address,
                email: email,
                number: number,
                status: status,
            },
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
        $.ajax(ajaxConfig);
        return false;
    }
</script>