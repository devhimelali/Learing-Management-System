<?php
ob_start();
session_start();

include "./config/config.php";
$current_page = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1);
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-sidebar="dark" data-sidebar-size="lg" data-preloader="disable"
      data-theme="default" data-topbar="light" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <title><?= $title ?> - Best Learning Management System in Bangladesh </title>
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
<header>
    <section class="bg-primary">
        <div class="container d-flex justify-content-between align-items-center py-2">
            <ul class="d-flex align-items-center gap-4 mb-0 list-unstyled">
                <li>
                    <a href="" class="text-white d-flex align-items-center gap-1">
                        <i class="ph ph-phone-call"></i>
                        1112222434325
                    </a>
                </li>
                <li>
                    <a href="" class="text-white d-flex align-items-center gap-1">
                        <i class="ph ph-envelope"></i>
                        2x5bM@example.com
                    </a>
                </li>
            </ul>
            <ul class="d-flex align-items-center gap-3 mb-0 list-unstyled">
                <li>
                    <a href="" class="text-white d-flex align-items-center gap-1">
                        <i class="ph ph-facebook-logo"></i>
                    </a>
                </li>
                <li>
                    <a href="" class="text-white d-flex align-items-center gap-1">
                        <i class="ph ph-twitter-logo"></i>
                    </a>
                </li>
                <li>
                    <a href="" class="text-white d-flex align-items-center gap-1">
                        <i class="ph ph-linkedin-logo"></i>
                    </a>
                </li>
            </ul>
        </div>
    </section>
</header>
<!-- JAVASCRIPT -->
</body>
<script src="<?= BASE_URL ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= BASE_URL ?>assets/libs/simplebar/simplebar.min.js"></script>

<script src="<?= BASE_URL ?>assets/js/pages/password-addon.init.js"></script>

<script src="<?= BASE_URL ?>assets/libs/toastr/toastr.min.js"></script>
<script>
    function notify(type, msg, position = 'toast-bottom-right') {
        if (['success', 'info', 'warning', 'error'].includes(type)) {
            toastr.options = {
                closeButton: true,
                positionClass: position,
                progressBar: true
            };
            toastr[type](msg);
        } else {
            console.error(`Invalid toastr type: ${type}`);
        }
    }
    <?php if (!empty($errors)):
    foreach ($errors as $fieldErrors):
    foreach ($fieldErrors as $error):
    ?>
    notify('error', '<?= $error; ?>');
    <?php
    endforeach;
    endforeach;
    elseif (isset($error_message)): ?>
    notify('error', '<?= $error_message; ?>');
    <?php endif; ?>

    <?php if (isset($success_message)): ?>
    notify('success', '<?= $success_message; ?>');
    <?php endif; ?>

    // === Custom Toasts ===
    <?php if (isset($_SESSION['status'])): ?>
    notify('<?= $_SESSION['status']['type']; ?>', '<?= $_SESSION['status']['message']; ?>');
    <?php unset($_SESSION['status']);
    endif; ?>
</script>
</body>

</html>