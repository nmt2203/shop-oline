<?php $user = $this->data["user"]; ?>
<div class="panel">
    <div class="panel-heading">
        <ul class="breadcrumb">
            <li><a href="/DoAnTH02/Admin/user/index/">User management</a></li>
            <li><a href="/DoAnTH02/Admin/user/update/id=<?php echo $user->user_id; ?>">Update</a></li>
        </ul>
        <h3 style="text-align: center;">User details</h3>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" method='POST' action="">
            <div id="update_error_message"></div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="user_id">ID:</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" placeholder="Enter user id" value="<?php echo $user->user_id; ?>" disabled>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="name">Name:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter user name" value="<?php echo $user->name; ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="username">username:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="username" placeholder="Enter user name" value="<?php echo $user->username; ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="address">Address:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="address" name="address" placeholder="Enter user address" value="<?php echo $user->address; ?>">
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
                <label for="district" class="control-label col-sm-2 ">District: </label>
                <div class="col-sm-10">
                    <select class="form-control" name="district_id" id="district">
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
                <label for="province" class="control-label col-sm-2 ">Province/City: </label>
                <div class="col-sm-10">
                    <select class="form-control" name="province_id" id="province">
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
                <label class="control-label col-sm-2" for="number">Number:</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" id="number" name="number" placeholder="" value="<?php echo $user->number; ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="status">Status:</label>
                <div class="col-sm-10">
                    <select class="form-control" id="status" name="status">
                        <option value="">Choose status</opption>
                        <option value='0' <?php if ($user->status == 0) {
                                                echo "selected";
                                            }
                                            ?>>Disable </option>
                        <option value='1' <?php if ($user->status == 1) {
                                                echo "selected";
                                            }
                                            ?>>Enable </option>
                    </select>
                </div>
            </div>
        </form>
    </div>
</div>