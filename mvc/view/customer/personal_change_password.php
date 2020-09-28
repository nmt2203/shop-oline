<div class="panel">
    <div class="row">
        <div class="col-md-3 panel">
            <?php require "personal_side_bar.php"; ?>
        </div>
        <div class="col-md-9">
            <?php
            $user = $this->data["user"];
            ?>
            <h3 style="text-align:center;">Change password</h3>
            <form id="change_password_form" class="form-horizontal" method="POST" action="/DoAnTH02/Account/do_change_password/" onsubmit="return do_change_password();">
                <div id="change_password_error_message"></div>
                <input type="hidden" id="user_id" name="user_id" value="<?php echo $user->user_id; ?>">
                <input type="hidden" id="username" name="username" value="<?php echo $user->username; ?>">
                <div class="form-group">
                    <label for="password" class="control-label col-sm-2">Old password: </label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="old_password" name="old_password" value="" placeholder="Enter old password" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="control-label col-sm-2">New password: </label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="new_password" name="new_password" value="" placeholder="Enter new password" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="control-label col-sm-2">Re-enter new password: </label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="re_new_password" name="re_new_password" value="" placeholder="Enter new password one more time" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary" id="btn_change_password" name="btn_change_password" class="btn btn-default">Change password</button>
                    </div>
                </div>
            </form>
            <script>
                function do_change_password() {
                    var user_id = $("#user_id").val();
                    var username = $("#username").val();
                    var old_password = $("#old_password").val();
                    var new_password = $("#new_password").val();
                    var re_new_password = $("#re_new_password").val();
                    if (old_password != "" && new_password != "" && re_new_password != "") {
                        if (new_password == re_new_password) {
                            $.ajax({
                                type: "POST",
                                url: "/DoAnTH02/Account/do_change_password/",
                                data: {
                                    user_id: user_id,
                                    username: username,
                                    password: old_password,
                                    new_password: new_password,
                                },
                                beforeSend: function() {
                                    $("#change_password_error_message").fadeOut();
                                    $("#btn_change_password").html("Waiting.....");
                                },
                                success: function(response) {
                                    if (response == "Ok") {
                                        $("#change_password_error_message").fadeIn(1000, function() {
                                            $("#change_password_error_message").html("<div class='alert alert-success' style='width:100%; margin:auto;'>Change password successfully</div>");
                                            setTimeout('window.location.href="/DoAnTH02/Home/do_logout/"', 2000);
                                        })
                                    } else {
                                        $("#change_password_error_message").fadeIn(1000, function() {
                                            $("#change_password_error_message").html("<div class='alert alert-danger' style='width:100%; margin:auto;'>" + response + "</div>");
                                            $("#btn_change_password").html("Try again");
                                        })
                                    }
                                }
                            });
                        } else {
                            $("#change_password_error_message").fadeIn(1000, function() {
                                $("#change_password_error_message").html("<div class='alert alert-danger' style='width:100%; margin:auto;'>New password and Re-enter password don't match. </div>");
                            })
                        }
                    } else {
                        $("#change_password_error_message").fadeIn(1000, function() {
                            $("#change_password_error_message").html("<div class='alert alert-danger' style='width:100%; margin:auto;'>You must enter both all field. </div>");
                        })
                    }
                    return false;
                }
            </script>
        </div>
    </div>
</div>