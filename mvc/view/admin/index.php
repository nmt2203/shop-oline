<?php require "header.php"; ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" style="padding : 0;">
            <?php require "sidebar.php";?>
        </div>
        <div class="col-md-10">
            <?php
            if (array_key_exists("component", $this->data)) {
                require $this->data["component"];
            }
            ?>
        </div>
    </div>
</div>


</body>
</html>