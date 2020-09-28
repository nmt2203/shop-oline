<?php $user = $this->data["user"]; ?>
<div class="panel">
    <div class="panel-heading">
        <h3 style="text-align: center;">Administrator</h3>
    </div>
    <div class="panel-body">
        <form id="update_form" class="form-horizontal" method="POST" action="/DoAnTH02/Admin/administrator/do_update/" onsubmit="return do_update();">
            <div id="update_error_message"></div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="user_id">ID:</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" placeholder="Enter user id" value="<?php echo $user->user_id; ?>" disabled>
                    <input type="hidden" class="form-control" id="user_id" placeholder="Enter user id" value="<?php echo $user->user_id; ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="name">Name:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter user name" value="<?php echo $user->name; ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="username">Username:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="username" placeholder="Enter user name" value="<?php echo $user->username; ?>" disabled>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="address">Address:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="address" name="address" placeholder="Enter user address" value="<?php echo $user->address; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="province" class="control-label col-sm-2 ">Province/City: </label>
                <div class="col-sm-10">
                    <select onclick="onChangeProvince()"  class="form-control" name="province_id" id="province">
                        <option value="">---Choose province---</option>
                        <?php
                        foreach ($this->data["provinces"] as $province) { ?>
                            <option value="<?php echo $province->province_id; ?> " <?php if ($province->province_id == $user->province_id) echo "selected"; ?>> <?php echo $province->name; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="district" class="control-label col-sm-2 ">District: </label>
                <div class="col-sm-10">
                    <select onclick="onChangeDistrict()" class="form-control" name="district_id" id="district">
                        <option value="">---Please choose a province or city first---</option>
                        <?php
                        foreach ($this->data["districts"] as $district) { ?>
                            <option value="<?php echo $district->district_id; ?> " <?php if ($district->district_id == $user->district_id) echo "selected"; ?>> <?php echo $district->name; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="ward" class="control-label col-sm-2 ">Ward: </label>
                <div class="col-sm-10">
                    <select class="form-control" name="ward_id" id="ward">
                        <option value="">---Please choose a district first---</option>
                        <?php
                        foreach ($this->data["wards"] as $ward) { ?>
                            <option value="<?php echo $ward->ward_id; ?> " <?php if ($ward->ward_id == $user->ward_id) echo "selected"; ?>> <?php echo $ward->name; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2" for="number">Number:</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" id="number" name="number" placeholder="" value="<?php echo $user->number; ?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-2 col-sm-hidden"></div>
                <div class="col-sm-10">
                    <button type="submit" id="btn_update" name="btn_update" class="btn btn-primary">Update</button>
                    <button type="reset"  name="btn_reset" class="btn btn-danger">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    function do_update() {
        var user_id = $("#user_id").val();
        var name = $("#name").val();
        var address = $("#address").val();
        var number = $("#number").val();
        var province_id = $("#province").val();
        var district_id = $("#district").val();
        var ward_id = $("#ward").val();
        var ajaxConfig = {
            type: "POST",
            url: "/DoAnTH02/Admin/administrator/do_update/",
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