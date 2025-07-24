<?php
$title = "Dashboard";
include("layouts/top.php");
if (!isset($_SESSION["admin"])) {
    header("Location: " . ADMIN_URL . "login.php");
}
?>
<?php echo $current_page ?>
<?php include("layouts/footer.php"); ?>