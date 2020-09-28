<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Add icon library -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #b3f0ff;
        }

        * {
            box-sizing: border-box;
        }

        .input-container {
            display: -ms-flexbox;
            /* IE10 */
            display: flex;
            width: 100%;
            margin-bottom: 15px;
        }

        .icon {
            padding: 10px;
            background: dodgerblue;
            color: white;
            min-width: 50px;
            text-align: center;
        }

        .input-field {
            width: 100%;
            padding: 10px;
            outline: none;
        }

        .input-field:focus {
            border: 2px solid dodgerblue;
        }

        /* Set a style for the submit button */
        .btn {
            background-color: dodgerblue;
            color: white;
            padding: 15px 20px;
            border: none;
            cursor: pointer;
            width: 100%;
            opacity: 0.9;
        }

        .btn:hover {
            opacity: 1;
        }
    </style>
</head>

<body>
    <div class="panel panel-primary" style="margin-top: 150px; width : 400px; margin-left : auto; margin-right : auto;">
        <div class="panel-heading">
            <h2 style="text-align: center;">Administrator Login Form</h2>
        </div>
        <div class="panel-body">
            <form action="/DoAnTH02/Admin/administrator/do_login/" method="POST" onsubmit="return do_login();" style="max-width:500px;margin:auto;">
                <div id="login_error_message"></div>
                <div class="input-container">
                    <i class="fa fa-user icon"></i>
                    <input class="input-field" id="login_username" type="text" placeholder="Username" name="username">
                </div>
                <div class="input-container">
                    <i class="fa fa-key icon"></i>
                    <input class="input-field" id="login_password" type="password" placeholder="Password" name="password">
                </div>
                <button type="submit" id="btn_login" class="btn">Login</button>
            </form>
        </div>
    </div>
</body>

</html>
<script type="text/javascript">
    function do_login() {
        var username = $("#login_username").val();
        var password = $("#login_password").val();
        if (username != "" && password != "") {
            $.ajax({
                type: "POST",
                url: "/DoAnTH02/Admin/administrator/do_login/",
                data: {
                    username: username,
                    password: password,
                },
                beforeSend: function() {
                    $("#login_error_message").html("");
                    $("#login_error_message").fadeOut();
                    $("#btn_login").html("Waiting.....");
                },
                success: function(response) {
                    if (response == "") {
                        $("#login_error_message").fadeIn(1000, function() {
                            $("#login_error_message").html("<div class='alert alert-success' style='width:100%; margin:auto;'>Login successfully</div>");
                            setTimeout('window.location.href="/DoAnTH02/Admin/index/"', 2000);
                        })
                    } else {
                        $("#login_error_message").fadeIn(1000, function() {
                            $("#login_error_message").html("<div class='alert alert-danger' style='width:100%; margin:auto;'>" + response + "</div>");
                            $("#btn_login").html("Try again");
                            $("#login_error_message").fadeOut(3000);
                            // $("#login_error_message").html("");
                        })
                    }
                }
            });
        } else {
            $("#login_error_message").fadeIn(1000, function() {
                $("#login_error_message").html("<div class='alert alert-danger' style='width:100%; margin:auto;'>You must enter both email and password. </div>");
            })
        }
        return false;
    }
</script>