<?php
$title = "Login";
include('layouts/header.php');
include('../helper/validation-helper.php');

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
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ];

        $errors = validateInputs($_POST, $rules);

        if (count($errors) > 0) {
            throw new Exception('Invalid credentials. Please provide valid email and password.');
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
                                        <p class="text-muted">Sign in to continue to <?= APP_NAME ?></p>
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
                                                    <a href="<?= ADMIN_URL ?>forget-password.php"
                                                        class="text-muted">Forgot
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

                                            <div class="mt-4">
                                                <button class="btn btn-primary w-100" name="login_submit" type="submit"
                                                    id="submitBtn">Sign
                                                    In
                                                </button>
                                            </div>
                                        </form>
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

<?php include('layouts/auth-footer.php'); ?>