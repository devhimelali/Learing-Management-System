<?php
include("layouts/header.php");
unset($_SESSION["admin"]);
header("Location: " . ADMIN_URL . "login.php");
?>