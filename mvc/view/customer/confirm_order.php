<div class="row">
    <div class="col-md-6">
        <h3><b>Your address for shipping</b></h3>
        <?php $user = $this->data["current_user"]; ?>
        <div class="row">
            <form class="form-horizontal" method="POST" action="/DoAnTH02/Shopping/do_order/" onsubmit="return do_order();">
                <div class="form-group">
                    <label for="name" class="control-label col-sm-2 ">Customer: </label>
                    <div class="col-sm-8">
                        <input type="hidden" name="user_id" id="user_id" value="<?php echo $_SESSION["user_id"];?>">
                        <input type="hidden" name="cost" id="cost" value="<?php echo $this->data["get_total_cost"];?>">
                        <input type="text" id="name" name="name" class="form-control" value="<?php echo $user->name ?>" placeholder="Enter your name" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label for="receiver" class="control-label col-sm-2 ">Receiver: </label>
                    <div class="col-sm-8">
                        <input type="text" id="receiver" name="receiver" class="form-control" value="<?php echo $user->name ?>" placeholder="Enter reciever name" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="province_id" class="control-label col-sm-2 ">Province/City: </label>
                    <div class="col-sm-8">
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
                    <div class="col-sm-8">
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
                    <div class="col-sm-8">
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
                    <div class="col-sm-8">
                        <input type="address" class="form-control" id="address" name="address" value="<?php echo $user->address; ?>" placeholder="Enter address" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="number" class="control-label col-sm-2 ">Number: </label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="number" name="number" value="<?php echo $user->number;?>" placeholder="Enter phone number" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2 col-sm-hidden"></div>
                    <div class="col-sm-8">
                        <button type="submit" id="confirm_order" name="confirm_order" class="btn btn-primary">Order</button>
                        <button style="float:right;" type="reset" class="btn btn-danger">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-6">
        <h3><b>Order details</b></h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Book</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Cost</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($this->data["get_all_carts_books"] as $book) {
                ?>
                    <tr>
                        <td>
                            <?php echo $book->name; ?>
                        </td>
                        <td>
                            <?php
                            foreach ($this->data["get_all_carts"] as $cart) {
                                if ($cart->book_id == $book->book_id) {
                                    echo $cart->quantity;
                                }
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            foreach ($this->data["get_all_carts_coupons"] as $coupons) {
                                foreach ($coupons as $id => $value) {
                                    if ($book->book_id == $id) {
                                        echo  $book->price * (1 - $value) . "<small> vnd</small>";
                                    }
                                }
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            foreach ($this->data["get_all_carts_coupons"] as $coupons) {
                                foreach ($this->data["get_all_carts"] as $cart) {
                                    foreach ($coupons as $id => $value) {
                                        if ($book->book_id == $id && $book->book_id == $cart->book_id) {
                                            echo  $book->price * (1 - $value) * $cart->quantity . "<small> vnd</small>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </td>
                    </tr>
                <?php
                }
                ?>
                <tr style="color:red;">
                    <td colspan="3">
                        Total cost :
                    </td>
                    <td>
                        <p><?php echo $this->data["get_total_cost"] . "<small> vnd</small>"; ?> </p>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
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

    function do_order() {
        var user_id = $("#user_id").val();
        var cost = $("#cost").val();
        var receiver = $("#receiver").val();
        var province_id = $("#province").val();
        var district_id = $("#district").val();
        var ward_id = $("#ward").val();
        var address = $("#address").val();
        var number = $("#number").val();

        var ajaxConfig = {
            type: "POST",
            url: "/DoAnTH02/Shopping/do_order/",
            data: {
                user_id : user_id,
                cost : cost,
                receiver : receiver,
                province_id : province_id,
                district_id : district_id,
                ward_id : ward_id,
                address : address,
                number : number,
            },
            success: function(response) {
                if (response == "") {
                    alert("Your order has been saved.")
                    window.location.href="/DoAnTH02/Shopping/index/";
                } else {
                   alert("Error occurred, please check again!" + response);
                }
            }
        }
        $.ajax(ajaxConfig);
        return false;
    }
</script>