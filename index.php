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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
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


    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container">
            <style>
                .navbar-brand {
                    padding-top: 6px;
                    padding-bottom: 4px;
                }
            </style>
            <a class="navbar-brand fw-bold" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Courses</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Instructors</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Blog</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                           aria-expanded="false">
                            Dropdown
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link">
                            Contact Us
                        </a>
                    </li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <!-- Search Form -->
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
                    </form>

                    <!-- Styles -->
                    <style>
                        .icon-btn {
                            position: relative;
                            width: 36px;
                            height: 36px;
                            border: 2px solid #3762EA;
                            border-radius: 50%;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            transition: background-color 0.3s, border-color 0.3s;
                            cursor: pointer;
                        }

                        .icon-btn:hover {
                            background-color: #3762EA;
                            border-color: #2c50c0;
                        }

                        .icon-btn:hover i {
                            color: #fff;
                        }

                        .icon-btn i {
                            font-size: 1rem;
                            color: #3762EA;
                            transition: color 0.3s;
                        }

                        .count-badge {
                            position: absolute;
                            top: -9px;
                            right: -7px;
                            background-color: #3762EA;
                            color: #fff;
                            font-size: 0.65rem;
                            padding: 4px 6px;
                            border-radius: 50%;
                            font-weight: bold;
                            line-height: 1;
                        }
                        i.bi.bi-heart.fw-bold {
                            padding-top: 4px;
                        }
                    </style>

                    <!-- Cart Icon -->
                    <div class="icon-btn" title="View Cart">
                        <i class="bi bi-cart fw-bold"></i>
                        <div class="count-badge">3</div>
                    </div>

                    <!-- Wishlist Icon -->
                    <div class="icon-btn" title="Wishlist">
                        <i class="bi bi-heart fw-bold"></i>
                        <div class="count-badge">5</div>
                    </div>
                </div>


            </div>
        </div>
    </nav>
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