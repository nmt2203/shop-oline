<?php $user = $this->data["user"]; ?>
<div class="panel">
    <div class="row">
        <div class="col-md-3 panel">
            <?php require "personal_side_bar.php"; ?>
        </div>
        <div class="col-md-9">
            <h3 class="modal-title" style="text-align:center;">Personal imformation</h3>
            <div style="width: 100%; margin:auto;">
                <form id="update_form" class="form-horizontal" method="POST" action="/DoAnTH02/Account/do_change_imformation/" onsubmit="return do_update_account();">
                    <div id="update_error_message"></div>
                    <div class="form-group">
                        <label for="name" class="control-label col-sm-2 ">Name: </label>
                        <div class="col-sm-10">
                            <input type="hidden" id="update_user_id" name="user_id" value="<?php echo $user->user_id; ?>">
                            <input type="text" id="update_name" name="name" class="form-control" value="<?php echo $user->name; ?>" placeholder="Enter your name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="username" class="control-label col-sm-2 ">Username: </label>
                        <div class="col-sm-10">
                            <input type="text" id="update_username" name="username" class="form-control" value="<?php echo $user->username; ?>" placeholder="Enter your name" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="province_id" class="control-label col-sm-2 ">Province/City: </label>
                        <div class="col-sm-10">
                            <select onclick="onChangeProvince()" class="form-control" name="province_id" id="province">
                                <option value="">---Choose province---</option>
                                <?php
                                foreach ($this->data["province"] as $province) { ?>
                                    <option value="<?php echo $province->province_id; ?> " <?php if ($user->province_id == $province->province_id) echo "selected"; ?>> <?php echo $province->name; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="district_id" class="control-label col-sm-2 ">District: </label>
                        <div class="col-sm-10">
                            <select onclick="onChangeDistrict()" class="form-control" name="district_id" id="district">
                                <option value="">---Please choose a province or city first---</option>
                                <?php
                                foreach ($this->data["district"] as $district) { ?>
                                    <option value="<?php echo $district->district_id; ?> " <?php if ($user->district_id == $district->district_id) echo "selected"; ?>> <?php echo $district->name; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="ward_id" class="control-label col-sm-2 ">Ward: </label>
                        <div class="col-sm-10">
                            <select class="form-control" name="ward_id" id="ward">
                                <option value="">---Please choose a district first---</option>
                                <?php
                                foreach ($this->data["ward"] as $ward) { ?>
                                    <option value="<?php echo $ward->ward_id; ?> " <?php if ($user->ward_id == $ward->ward_id) echo "selected"; ?>> <?php echo $ward->name; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="control-label col-sm-2 ">Address: </label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="update_address" name="address" value="<?php echo $user->address; ?>" placeholder="Enter address">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="number" class="control-label col-sm-2 ">Number: </label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="update_number" name="number" value="<?php echo $user->number; ?>" placeholder="Enter address">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-hidden"></div>
                        <div class="col-sm-10">
                            <button type="submit" id="btn_update" name="btn_update" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function do_update_account() {
        var user_id = $("#update_user_id").val();
        var name = $("#update_name").val();
        var address = $("#update_address").val();
        var number = $("#update_number").val();
        var province_id = $("#province").val();
        var district_id = $("#district").val();
        var ward_id = $("#ward").val();
        var ajaxConfig = {
            type: "POST",
            url: "/DoAnTH02/Account/do_change_imformation/",
            data: {
                user_id : user_id,
                name : name,
                address : address,
                number : number,
                province_id : province_id,
                district_id : district_id,
                ward_id : ward_id,
            },
            beforeSend: function() {
                $("#update_error_message").fadeOut();
                $("#btn_update").html("Waiting.....");
            },
            success: function(response) {
                if (response == "") {
                    $("#update_error_message").fadeIn(1000, function() {
                        $("#update_error_message").html("<div class='alert alert-success' style='width:100%; margin:auto;'>Update successfully</div>");
                        $("#btn_update").html("Ok");
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
</script>