<div class="panel">
    <div class="panel-heading">
        <ul class="breadcrumb">
            <li><a href="/DoAnTH02/Admin/author/index/">Author management</a></li>
            <li><a href="/DoAnTH02/Admin/author/add/">Add</a></li>
        </ul>
        <h3 style="text-align: center;">Adding a author</h3>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" method='POST' action="/DoAnTH02/Admin/author/do_add/" onsubmit="return do_add();">
            <div id="add_error_message"></div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="name">Name:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter author name" value="<?php  ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="address">Address:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="address" name="address" placeholder="Enter author address" value="<?php  ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="desciption">Description:</label>
                <div class="col-sm-10">
                    <textarea placeholder="Enter author desciption" class="form-control" rows="5" name="description" id="description"></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input class="btn btn-success" type="submit" name="add" value="add">
                    <input class="btn btn-danger" type="reset" name="reset" value="cancel">
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    function do_add() {
        var name = $("#name").val();
        var description = $("#description").val();
        var address = $("#address").val();
        var ajaxConfig = {
            type: "POST",
            url: "/DoAnTH02/Admin/author/do_add/",
            data: {
                name: name,
                address: address,
                description: description,
            },
            success: function(response) {
                if (response == "") {
                    $("#add_error_message").fadeIn(1000, function() {
                        $("#add_error_message").html("<div class='alert alert-success' style='width:100%; margin:auto;'>Add successfully</div>");
                        $("#add_error_message").fadeOut(3000);
                    })
                } else {
                    $("#add_error_message").fadeIn(1000, function() {
                        $("#add_error_message").html("<div class='alert alert-danger' style='width:100%; margin:auto;'>" + response + "</div>");
                        $("#btn_add").html("try again");
                    })
                }
            }
        }
        $.ajax(ajaxConfig);
        return false;
    }
</script>