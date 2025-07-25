<?php
$title = "Reset Password";
include('layouts/header.php');
include('../helper/validation-helper.php');

// === Check if user is already logged in ===
if (isset($_SESSION['admin'])) {
    header('Location: ' . ADMIN_URL . 'dashboard.php');
    $_SESSION['status'] = [
        'type' => 'success',
        'message' => 'You are already logged in.',
    ];
    exit;
}

if (empty($_GET['token']) && empty($_GET['email'])) {
    header('Location: ' . ADMIN_URL . 'login.php');
    $_SESSION['status'] = [
        'type' => 'error',
        'message' => 'Invalid token.',
    ];
    exit;
}



try {
    $token = $_GET['token'];
    $email = $_GET['email'];

    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email AND password_reset_token = :password_reset_token');
    $stmt->bindParam(':password_reset_token', $token);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $total = $stmt->rowCount();

    if ($total == 0) {
        header('Location: ' . ADMIN_URL . 'login.php');
        $_SESSION['status'] = [
            'type' => 'error',
            'message' => 'Please provide valid token.',
        ];
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $rules = [
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:6|confirmed',
        ];

        $errors = validateInputs($_POST, $rules);
        if (count($errors) > 0) {
            throw new Exception('Invalid credentials. Please provide valid email and password.');
        }

        // === Query user from database ===
        $query = $pdo->prepare("SELECT * FROM users WHERE email = :email AND password_reset_token = :password_reset_token AND role = 'admin'");
        $query->bindParam(':password_reset_token', $token);
        $query->bindParam(':email', $email);
        $query->execute();
        $total = $query->rowCount();

        if ($total == 0) {
            throw new Exception('User not found.');
        } else {
            $stmt = $pdo->prepare('UPDATE users SET password = :password, password_reset_token = NULL WHERE email = :email AND password_reset_token = :password_reset_token');
            $stmt->bindParam(':password_reset_token', $token);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', password_hash($_POST['password'], PASSWORD_DEFAULT));
            $stmt->execute();
            $success_message = 'Password changed successfully.';

            header('Location: ' . ADMIN_URL . 'login.php');
            $_SESSION['status'] = [
                'type' => 'success',
                'message' => $success_message,
            ];
            exit;
        }
    }

} catch (Exception $e) {
    $error_message = $e->getMessage();
}

?>

<section class="auth-page-wrapper py-5 position-relative d-flex align-items-center justify-content-center min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="mb-0 card">
                    <div class="row g-0 align-items-center">
                        <div class="mx-auto col-xxl-12">
                            <div class="mb-0 border-0 shadow-none card">
                                <div class="card-body p-sm-3 m-lg-4">
                                    <div class="text-center">
                                        <h5 class="fs-3xl">Create new password</h5>
                                        <p class="mb-3 text-muted">Your new password must be different from previous
                                            used
                                            password.
                                        </p>
                                    </div>

                                    <div class="p-2">
                                        <form method="POST" action="" id="resetPasswordForm">
                                            <input type="hidden" name="token" value="<?= $token ?>">
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    value="<?= $email ?>" readonly>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="password">Password</label>
                                                <div class="position-relative auth-pass-inputgroup">
                                                    <input type="password" class="form-control pe-5 password-input"
                                                        placeholder="Enter password" id="password" name="password">
                                                    <button
                                                        class="top-0 btn btn-link position-absolute end-0 text-decoration-none text-muted password-addon"
                                                        type="button" id="password-addon"><i
                                                            class="align-middle ri-eye-fill"></i></button>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label" for="password-confirmation">Confirm
                                                    Password</label>
                                                <div class="mb-3 position-relative auth-pass-inputgroup">
                                                    <input type="password" class="form-control pe-5 password-input"
                                                        placeholder="Confirm password" id="password-confirmation"
                                                        name="password_confirmation">
                                                    <button
                                                        class="top-0 btn btn-link position-absolute end-0 text-decoration-none text-muted password-addon"
                                                        type="button"><i class="align-middle ri-eye-fill"></i></button>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="mt-4">
                                                <button class="btn btn-primary w-100" type="submit" id="submitBtn">Reset
                                                    Password
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="mt-4 text-center">
                                        <p class="mb-0">Wait, I remember my password...
                                            <a href="<?= ADMIN_URL ?>login.php"
                                                class="fw-semibold text-primary text-decoration-underline">
                                                Click here </a>
                                        </p>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include('layouts/auth-footer.php'); ?>