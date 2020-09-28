<?php require "header.php"; ?>
<div class="panel-body">
    <div class="container">
        <?php
        if (array_key_exists("component",$this->data)) {
            require $this->data["component"];
        }
        ?>
    </div>
</div>

<?php require "footer.php" ?>