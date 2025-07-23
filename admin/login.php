<?php
include('layouts/header.php');

// === Check if user is already logged in ===
if (isset($_SESSION['admin'])) {
    header('Location: ' . ADMIN_URL . 'dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        // === Input validation ===
        if (empty($email)) {
            throw new Exception('Please enter your email.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Please enter a valid email address.');
        }

        if (empty($password)) {
            throw new Exception('Please enter your password.');
        }

        if (strlen($password) < 6) {
            throw new Exception('Password must be at least 6 characters.');
        }

        // === Query user from database ===
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email AND role = 'admin'");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            throw new Exception('User not found. Please check your email.');
        }

        if (!password_verify($password, $user['password'])) {
            throw new Exception('Invalid credentials. Please provide valid password.');
        }

        // === Set session and redirect ===
        $_SESSION['admin'] = $user;
        header('Location: ' . ADMIN_URL . 'dashboard.php');
        exit;

    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}

?>

<section class="auth-page-wrapper py-5 position-relative d-flex align-items-center justify-content-center min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card mb-0">
                    <div class="row g-0 align-items-center">
                        <!--end col-->
                        <div class="col-xxl-12 mx-auto">
                            <div class="card mb-0 border-0 shadow-none">
                                <div class="card-body p-sm-5">
                                    <div class="text-center">
                                        <h5 class="fs-3xl">Welcome Back</h5>
                                        <p class="text-muted">Sign in to continue to </p>
                                        <?php if (isset($error_message)): ?>
                                            <div class="alert alert-danger" role="alert">
                                                <?php echo $error_message; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="p-2 mt-2">
                                        <form action="" method="post" id="loginForm">
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email <span
                                                        class="text-danger">*</span></label>
                                                <div class="position-relative ">
                                                    <input type="email" class="form-control  password-input"
                                                        name="email" id="email" placeholder="Enter email"
                                                        value="<?= $_POST['email'] ?? '' ?>">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <div class="float-end">
                                                    <a href="" class="text-muted">Forgot
                                                        password?</a>
                                                </div>
                                                <label class="form-label" for="password-input">Password <span
                                                        class="text-danger">*</span></label>
                                                <div class="position-relative auth-pass-inputgroup mb-3">
                                                    <input type="password" class="form-control pe-5 password-input "
                                                        placeholder="Enter password" name="password"
                                                        id="password-input">
                                                    <button
                                                        class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                        type="button" id="password-addon"><i
                                                            class="ri-eye-fill align-middle"></i></button>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>

                                            <!-- <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember"
                                                    id="remember">
                                                <label class="form-check-label" for="remember">Remember
                                                    me</label>
                                            </div> -->

                                            <div class="mt-4">
                                                <button class="btn btn-primary w-100" name="login_submit" type="submit"
                                                    id="submitBtn">Sign
                                                    In
                                                </button>
                                            </div>
                                        </form>

                                        <div class="text-center mt-4">
                                            <p class="mb-0">Don't have an account ?
                                                <a href="" class="fw-semibold text-secondary text-decoration-underline">
                                                    SignUp</a>
                                            </p>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>
    <!--end container-->
</section>
<!-- <script>
    $(document).ready(function () {
        $('#loginForm').on('submit', function (e) {
            e.preventDefault();

            var $form = $(this);
            var formData = new FormData(this);

            // Clear previous errors
            $form.find('.invalid-feedback').text('');
            $form.find('.is-invalid').removeClass('is-invalid');

            $.ajax({
                url: '/admin/login.php', // current file
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (data) {
                    if (data.success) {
                        window.location.href = data.redirect;
                    } else if (data.errors) {
                        $.each(data.errors, function (key, message) {
                            var $input = $('[name="' + key + '"]');
                            $input.addClass('is-invalid');
                            $input.closest('.position-relative, .mb-3, .form-group').find('.invalid-feedback').text(message);
                        });
                    } else if (data.message) {
                        toastr.error(data.message);
                    }
                },

                error: function (xhr, status, error) {
                    console.log(xhr)
                }
            });
        });
    });
</script> -->

<?php include('layouts/auth-footer.php'); ?>