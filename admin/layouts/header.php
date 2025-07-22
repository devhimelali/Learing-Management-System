<?php
ob_start();
session_start();
include "../config/config.php";
$current_page = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1);
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-sidebar="dark" data-sidebar-size="lg" data-preloader="disable"
    data-theme="default" data-topbar="light" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Minimal Admin & Dashboard Template" name="description">
    <meta content="Themesbrand" name="author">
    <script src="<?= BASE_URL ?>assets/libs/jquery/jquery.min.js"></script>
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Fonts css load -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link id="fontsLink"
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet">

    <!-- Layout config Js -->
    <!-- Bootstrap Css -->
    <link href="<?= BASE_URL ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <!-- Icons Css -->
    <link href="<?= BASE_URL ?>assets/css/icons.min.css" rel="stylesheet" type="text/css">
    <!-- App Css-->
    <link href="<?= BASE_URL ?>assets/css/app.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/libs/toastr/toastr.min.css">
    <!-- Layout config Js -->
    <script src="<?= BASE_URL ?>assets/js/layout.js"></script>

    <!-- Sweet Alert CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/libs/sweetalert2/sweetalert2.min.css">
</head>

<body>