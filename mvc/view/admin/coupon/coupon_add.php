<div class="panel">
    <div class="panel-heading">
        <ul class="breadcrumb">
            <li><a href="/DoAnTH02/Admin/coupon/index/">Coupon management</a></li>
            <li><a href="/DoAnTH02/Admin/coupon/add/">Add</a></li>
        </ul>
        <h3 style="text-align: center;">Adding a coupon</h3>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" method='POST' action="/DoAnTH02/Admin/coupon/do_add/" onsubmit="return do_add();">
            <div id="add_error_message"></div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="content">Content:</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" id="content" name="content" min="0" max="100" placeholder="Enter coupon %" value="<?php  ?>" required>
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
        var value = $("#content").val();
        var content = value / 100;
        var ajaxConfig = {
            type: "POST",
            url: "/DoAnTH02/Admin/coupon/do_add/",
            data: {
                content : content,
            },
            success: function(response) {
                if (response == "") {
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
        $.ajax(ajaxConfig);
        return false;
    }
</script>