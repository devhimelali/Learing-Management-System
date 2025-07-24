<?php
include("layouts/header.php");
unset($_SESSION["admin"]);
header("Location: " . ADMIN_URL . "login.php");
$_SESSION["status"] = [
    "type" => "success",
    "message" => "Logged out successfully.",
];
?>