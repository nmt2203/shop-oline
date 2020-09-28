<h3 class="modal-title" style="text-align:center;">Register Screen</h3>
<div style="width: 100%; margin:auto;">
    <form id="register_form" class="form-horizontal" method="POST" action="/DoAnTH02/Home/do_register/" onsubmit="return do_register(this);">
        <div id="register_error_message"></div>
        <div class="form-group">
            <label for="name" class="control-label col-sm-2 ">Name: </label>
            <div class="col-sm-8">
                <input type="text" id="register_name" name="name" class="form-control" value="" placeholder="Enter your name" required>
            </div>
        </div>
        <div class="form-group">
            <label for="text" class="control-label col-sm-2 ">Username: </label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="register_username" name="username" value="" placeholder="Enter email" required>
            </div>
        </div>
        <div class="form-group">
            <label for="password" class="control-label col-sm-2 ">Password: </label>
            <div class="col-sm-8">
                <input type="password" class="form-control" id="register_password" name="password" value="" placeholder="Enter password" required>
            </div>
        </div>
        <div class="form-group">
            <label for="re_password" class="control-label col-sm-2 ">Comfirm password: </label>
            <div class="col-sm-8">
                <input type="password" class="form-control" id="register_re_password" name="re_password" value="" placeholder="Re-enter password" required>
            </div>
        </div>
        <div class="form-group">
            <label for="province" class="control-label col-sm-2 ">Province/City: </label>
            <div class="col-sm-8">
                <select onclick="onChangeProvince()" class="form-control" name="province_id" id="province">
                    <option value="">---Choose province---</option>
                    <?php
                    foreach ($this->data["province"] as $province) { ?>
                        <option value="<?php echo $province->province_id;?> "> <?php echo $province->name;?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="district" class="control-label col-sm-2 ">District: </label>
            <div class="col-sm-8">
                <select onclick="onChangeDistrict()" class="form-control" name="district_id" id="district">
                    <option value="">---Please choose a province or city first---</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="ward" class="control-label col-sm-2 ">Ward: </label>
            <div class="col-sm-8">
                <select class="form-control" name="ward_id" id="ward">
                    <option value="">---Please choose a district first---</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="address" class="control-label col-sm-2 ">Address: </label>
            <div class="col-sm-8">
                <input type="address" class="form-control" id="register_address" name="address" value="" placeholder="Enter address" required>
            </div>
        </div>
        <div class="form-group">
            <label for="number" class="control-label col-sm-2 ">Number: </label>
            <div class="col-sm-8">
                <input type="number" class="form-control" id="register_number" name="number" value="" placeholder="Enter phone number" required>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-2 col-sm-hidden"></div>
            <div class="col-sm-8">
                <button type="submit" id="btn_register" name="btn_register" class="btn btn-primary">Register</button>
            </div>
        </div>
        <div style="float: right;">
            <a href="#" data-toggle="modal" data-target="#login_form" data-dismiss="modal">Already have an account? Login</a>
        </div>
    </form>
</div>
<script>
    function onChangeProvince() {
        var province_id = $("#province").val();
        $.ajax({
            type: "POST",
            url: "/DoAnTH02/Home/get_district/",
            data: {
                province_id: province_id,
            },
            success: function(response) {
                $("#district").html(response);
            }
        });

        return false;
    }

    function onChangeDistrict() {
        var district_id = $("#district").val();
        $.ajax({
            type: "POST",
            url: "/DoAnTH02/Home/get_ward/",
            data: {
                district_id: district_id,
            },
            success: function(response) {
                $("#ward").html(response);
            }
        });

        return false;
    }


    function do_register(formData) {
        var ajaxConfig = {
            type: "POST",
            url: "/DoAnTH02/Home/do_register/",
            data: new FormData(formData),
            success: function(response) {
                if (response == "Ok") {
                    $("#register_error_message").fadeIn(1000, function() {
                        $("#register_error_message").html("<div class='alert alert-success' style='width:100%; margin:auto;'>Register successfully</div>");
                    })
                    setTimeout('window.location.href="/DoAnTH02/Home/index/"', 2000);
                } else {
                    $("#register_error_message").fadeIn(1000, function() {
                        $("#register_error_message").html("<div class='alert alert-danger' style='width:100%; margin:auto;'>" + response + "</div>");
                        $("#btn_register").html("try again");
                    })
                }
            }
        }
        $.ajax(ajaxConfig);
        return false;
    }
</script>