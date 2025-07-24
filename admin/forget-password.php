<?php
$title = "Forget Password";
include('layouts/header.php');

// === Check if user is already logged in ===
if (isset($_SESSION['admin'])) {
    header('Location: ' . ADMIN_URL . 'dashboard.php');
    exit;
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $email = trim($_POST['email'] ?? '');

        // === Input validation ===
        if (empty($email)) {
            throw new Exception('Please enter your email.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Please enter a valid email address.');
        }

        // === Query user from database ===
        $query = $pdo->prepare("SELECT * FROM users WHERE email = :email AND role = 'admin'");
        $query->bindParam(':email', $email);
        $query->execute();
        $total = $query->rowCount();

        if (empty($total)) {
            throw new Exception('User not found.');
        }

        // === Generate password reset token ===
        $token = bin2hex(random_bytes(32));

        $email_message = "Please click on the following link in order to reset the password: <a href=" . BASE_URL . "reset-password.php?email=" . $email . "&token=" . $token . ">Reset Password</a>";
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USERNAME;
        $mail->Password = SMTP_PASSWORD;
        $mail->SMTPSecure = SMTP_ENCRYPTION;
        $mail->Port = SMTP_PORT;
        $user = $query->fetch(PDO::FETCH_ASSOC);
        $mail->setFrom(SMTP_FROM);
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset';
        $mail->Body = $email_message;

        if ($mail->send()) {
            $success_message = 'Password reset link has been sent to your email.';
        } else {
            $error_message = 'Failed to send password reset link. Please try again.';
        }


    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}
?>

<section class="auth-page-wrapper py-5 position-relative d-flex align-items-center justify-content-center min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="mb-0 card">
                    <div class="row g-0 align-items-center">
                        <!--end col-->
                        <div class="mx-auto col-xxl-12">
                            <div class="mb-0 border-0 shadow-none card">
                                <div class="card-body p-sm-2 m-lg-4">
                                    <div class="mt-2 text-center">
                                        <h5 class="fs-3xl">Forgot Password?</h5>
                                        <div class="pb-4">
                                            <img src="<?= BASE_URL ?>assets/images/auth/email.png" alt=""
                                                class="avatar-md">
                                        </div>
                                    </div>
                                    <?php
                                    if (isset($error_message)): ?>
                                        <div class="mx-2 mb-2 text-center border-0 alert alert-danger infoBox" role="alert">
                                            <?php echo $error_message; ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (isset($success_message)): ?>
                                        <div class="mx-2 mb-2 text-center border-0 alert alert-success infoBox"
                                            role="alert">
                                            <?php echo $success_message; ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="p-2">
                                        <form method="POST" action="" id="forgotPasswordForm">
                                            <div class="mb-4">
                                                <label class="form-label" for="email">Email</label>
                                                <input type="email" class="form-control password-input" id="email"
                                                    name="email" value="<?= $_POST['email'] ?? '' ?>"
                                                    placeholder="Enter Email">
                                                <div class="invalid-feedback"></div>
                                            </div>

                                            <div class="mt-4 text-center">
                                                <button class="btn btn-primary w-100" type="submit" id="submitBtn">Send
                                                    Reset
                                                    Link
                                                </button>
                                            </div>
                                        </form><!-- end form -->
                                    </div>
                                    <div class="mt-4 text-center">
                                        <p class="mb-0">Wait, I remember my password...
                                            <a href="<?= ADMIN_URL ?>login.php"
                                                class="fw-semibold text-primary text-decoration-underline">
                                                Click here
                                            </a>
                                        </p>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
            </div>
        </div>
    </div>
</section>

<?php include('layouts/auth-footer.php'); ?>