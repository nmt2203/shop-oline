<?php 
    if (isset($_SESSION["user_id"])) {
        if ($_SESSION["user_authority"] != 1) {
            header("Location: /DoAnTH02/Admin/administrator/login/");
        }
    }
    else {
        header("Location: /DoAnTH02/Admin/administrator/login/");
    }
?>