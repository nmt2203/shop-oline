<div class="panel">
    <div class="panel-heading">
        <ul class="breadcrumb">
            <li><a href="/DoAnTH02/Admin/book/index/">Book management</a></li>
            <li><a href="/DoAnTH02/Admin/book/import/">Import</a></li>
        </ul>
        <h3 style="text-align: center;">Importing books</h3>
    </div>
    <div class="panel-body">
        <form id="form_1" method="POST" action="/DoAnTH02/Admin/book/import/" class="form-inline" >
            <div id="import_error_message"></div>
            <div class="form-group">
                <label class="control-label" for="import_number">Number of book:</label>
                <input type="number" id="import_number" class="form-control" name="import_number" min=1>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" name="go" value="Go">
            </div>
        </form>
        <div class="container-fluid" style="margin: 20px;">
            <div class="row">
                <form id="form_2" method="POST" class="form-horizontal" action="/DoAnTH02/Admin/book/do_import/" enctype='multipart/form-data' onsubmit="return do_import(this);">
                    <?php
                    for ($n = 0; $n < $this->data["import_number"]; $n++) {
                    ?>
                        <div class="panel panel-default">
                            <div class="form-group">
                                <input type="hidden" name="import_number" value="<?php echo $this->data["import_number"] ?>">
                                <label class="control-label col-sm-2" for="book_id">Select book ID:</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="book_id<?php echo $n; ?>">
                                        <?php
                                        foreach ($this->data["books"] as $book) {
                                        ?>
                                            <option value="<?php echo $book->book_id; ?>"><?php echo $book->book_id . " - " . $book->name; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="amount">Quantity:</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" name="quantity<?php echo $n; ?>">
                                </div>
                            </div>
                        </div>
                    <?php
                    }

                    if ($this->data["import_number"] != 0) {
                    ?>
                        <div class="form-group">
                            <input type="submit" class="btn btn-success btn" name="btn_import" value="OK">
                        </div>
                    <?php
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
        function do_import(formData) {
        // alert(formData);
        var ajaxConfig = {
            type: "POST",
            url: "/DoAnTH02/Admin/book/do_import/",
            data: new FormData(formData),
            success: function(response) {
                if (response == "") {
                    $("#import_error_message").fadeIn(1000, function() {
                        $("#import_error_message").html("<div class='alert alert-success' style='width:100%; margin:auto;'>Import successfully</div>");
                        $("#import_error_message").fadeOut(2000);
                    })
                } else {
                    $("#import_error_message").fadeIn(1000, function() {
                        $("#import_error_message").html("<div class='alert alert-danger' style='width:100%; margin:auto;'>" + response + "</div>");
                        $("#btn_import").html("try again");
                    })
                }
            }
        }
        if ($(formData).attr('enctype') == "multipart/form-data") {
            ajaxConfig["contentType"] = false;
            ajaxConfig["processData"] = false;
        }
        $.ajax(ajaxConfig);
        return false;
    }
</script>