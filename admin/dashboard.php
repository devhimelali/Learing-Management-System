<?php
$title = "Dashboard";
include("layouts/top.php");
if (!isset($_SESSION["admin"])) {
    header("Location: " . ADMIN_URL . "login.php");
    $_SESSION["status"] = [
        "type" => "error",
        "message" => "Please login as admin to access this page.",
    ];
}
?>
<?php echo $current_page ?>
<?php include("layouts/footer.php"); ?>