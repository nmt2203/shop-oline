<div class="panel">
    <div class="panel-heading">
        <h3 style="text-align: center;">News management</h3>
    </div>
    <div class="panel-body">
        <nav class="navbar">
            <div class="container-fluid">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/DoAnTH02/Admin/news/add/"><span class="glyphicon glyphicon-plus"></span> Add</a></li>
                    <li><a href="/DoAnTH02/Admin/news/restore/"><span class="glyphicon glyphicon-repeat"></span> Restore</a></li>
                </ul>
            </div>
        </nav>
        <form method="POST" action="">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>
                            <button type="submit" onclick="on_mass_remove();" class="btn btn-danger" value='Mass Delete' name='mass_remove'><span class="glyphicon glyphicon-trash"></span> Mass delete</button>
                        </th>
                        <th>News ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th colspan="2" style="text-align: center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->data["news"] as $news) {
                    ?>
                        <tr>
                            <td align="center">
                                <input type="checkbox" name="mass_remove_list[]" value=<?php echo $news->news_id; ?>>
                            </td>
                            <td>
                                <?php echo $news->news_id; ?>
                            </td>
                            <td>
                                <img style="width: 70px; height : 70px;margin-left: auto;margin-right: auto;" src="/DoAnTH02/public/uploads/news_image/<?php echo $news->image; ?>">
                            </td>
                            <td>
                                <?php echo $news->name; ?>
                            </td>
                            <td>
                                <?php
                                $date = date_create($news->date);
                                echo date_format($date, "d-m-yy");
                                ?>
                            </td>
                            <td>
                                <a class="btn btn-info" href="/DoAnTH02/Admin/news/update/id=<?php echo $news->news_id; ?>"><span class="glyphicon glyphicon-edit"></span> Update</a>
                            </td>
                            <td>
                                <button class="btn btn-danger" onclick="on_remove(<?php echo $news->news_id; ?>);"><span class="glyphicon glyphicon-remove"></span> Remove</button>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </form>
        <div class="container-fluid">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <ul class="pagination">
                    <?php
                    for ($k = 1; $k <= $this->data["number_of_page"]; $k++) {
                        if ($k != $this->data["page"]) {
                            echo '<li><a href="/DoAnTH02/Admin/news/index/page=' . $k . '">' . $k . '</li>';
                        } else {
                            echo '<li class="active"><a href="/DoAnTH02/Admin/news/index/page=' . $k . '">' . $k . '</li>';
                        }
                    }
                    ?>
                </ul>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</div>
<script>
    function on_remove(id) {
        // document.location.reload(false);
        var strurl = "/DoAnTH02/Admin/news/do_remove/";
        var news_id = id;
        if (confirm("Are you sure want to delete this news ?") == true) {
            jQuery.ajax({
                url: strurl,
                type: 'POST',
                data: {
                    news_id: id,
                },
                success: function(response) {
                    if (response == "") {
                        alert("Removed successfully.");
                        document.location.reload(true);

                    } else {
                        alert(response);
                    }
                }
            });
        }

        return false;
    }

    function on_mass_remove() {
        try {
            var list = $("input[name='mass_remove_list[]']:checked").map(function() {
                return $(this).val();
            }).get();
            if (confirm("Are you sure want to delete all selected news ?") == true) {
                var ajaxConfig = {
                    type: "POST",
                    url: "/DoAnTH02/Admin/news/do_mass_remove/",
                    ProceData: false,
                    data: {
                        mass_remove_list: list,
                    },
                    success: function(response) {
                        if (response == "") {
                            alert("Mass removed.");
                        } else {
                            alert(response);
                        }
                    }
                }
                $.ajax(ajaxConfig);
            }
        } catch (err) {
            alert(err.message);
        }
        return false;

    }
</script>