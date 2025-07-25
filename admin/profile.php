<?php
$title = "Edit Profile";
include("layouts/top.php");
include("../helper/validation-helper.php");
if (!isset($_SESSION["admin"])) {
    header("Location: " . ADMIN_URL . "login.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["form_type"]) && $_POST["form_type"] == "profile_edit_form") {

    try {
        // === Input validation ===
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'avatar' => 'nullable|image|mimes:jpg,png,jpeg,gif',
        ];

        $errors = validateInputs($_POST, $rules);
        if (count($errors) > 0) {
            throw new Exception(message: 'Validation error occurred.');
        }

        // === Prepare avatar filename (if uploaded) ===
        $avatarFilename = $_SESSION['admin']['avatar'] ?? null;

        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/uploads/avatars/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileTmp = $_FILES['avatar']['tmp_name'];
            $fileExt = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
            $newName = uniqid('avatar_', true) . '.' . strtolower($fileExt);
            $savePath = $uploadDir . $newName;

            // Move uploaded file
            if (!move_uploaded_file($fileTmp, $savePath)) {
                throw new Exception('Failed to upload avatar image.');
            }

            // Optionally delete old avatar (if not default)
            if (!empty($avatarFilename) && file_exists($uploadDir . $avatarFilename)) {
                unlink($uploadDir . $avatarFilename);
            }

            $avatarFilename = $newName;
        }

        // === Update user ===
        $stmt = $pdo->prepare('UPDATE users SET name = :name, email = :email, avatar = :avatar WHERE id = :id');
        $stmt->bindParam(':name', $_POST['name']);
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->bindParam(':avatar', $avatarFilename);
        $stmt->bindParam(':id', $_SESSION['admin']['id']);
        $stmt->execute();

        // === Fetch updated user and update session ===
        $stmt = $pdo->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->bindParam(':id', $_SESSION['admin']['id']);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['admin'] = $user;
            $success_message = 'Profile updated successfully.';
            // Redirect to profile page
            header('Location: ' . ADMIN_URL . 'profile.php');
            exit;
        }
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}

?>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Edit Profile</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="<?= ADMIN_URL ?>dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item active">User Profile</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-2">Update Profile Information</h4>
            </div>
            <hr class="m-0">
            <div class="card-body">
                <form action="" method="POST" id="profileInfoUpdateForm" enctype="multipart/form-data">
                    <input type="hidden" name="form_type" value="profile_edit_form">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control <?= $errors["name"] ? "is-invalid" : "" ?>" id="name"
                                name="name" value="<?= $_SESSION["admin"]["name"] ?>">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control <?= $errors["email"] ? "is-invalid" : "" ?>"
                                id="email" name="email" value="<?= $_SESSION["admin"]["email"] ?>">
                        </div>
                        <div class="col-md-8 mb-3">
                            <label for="avatar" class="form-label">Profile Picture</label>
                            <input type="file" class="form-control <?= $errors["avatar"] ? "is-invalid" : "" ?>"
                                id="avatar" name="avatar">
                        </div>
                        <div class="col-md-4 text-center mb-3">
                            <img id="avatarPreview"
                                src="<?= ADMIN_URL . 'uploads/avatars/' . $_SESSION["admin"]["avatar"] ?? BASE_URL . 'assets/images/no-avatar.png' ?>"
                                class="img-fluid img-thumbnail" width="100">
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-secondary"
                                id="profileInfoUpdateSubmitBtn">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-2">Update Password</h4>
            </div>
            <hr class="m-0">
            <div class="card-body">
                <form action="" method="POST" id="updatePasswordForm">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="current_password">Current Password <span
                                    class="text-danger">*</span></label>
                            <div class="position-relative auth-pass-inputgroup">
                                <input type="password" class="form-control pe-5 password-input "
                                    placeholder="Enter your current password" id="current_password"
                                    name="current_password">
                                <button
                                    class="top-0 btn btn-link position-absolute end-0 text-decoration-none text-muted password-addon"
                                    type="button"><i class="align-middle ri-eye-fill"></i></button>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="password">Password <span class="text-danger">*</span></label>
                            <div class="position-relative auth-pass-inputgroup">
                                <input type="password" class="form-control pe-5 password-input "
                                    placeholder="Enter password" id="password" name="password">
                                <button
                                    class="top-0 btn btn-link position-absolute end-0 text-decoration-none text-muted password-addon"
                                    type="button"><i class="align-middle ri-eye-fill"></i></button>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="password-confirmation">Confirm Password <span
                                    class="text-danger">*</span></label>
                            <div class="position-relative auth-pass-inputgroup">
                                <input type="password" class="form-control pe-5 password-input "
                                    placeholder="Enter confirm password" id="password-confirmation"
                                    name="password_confirmation">
                                <button
                                    class="top-0 btn btn-link position-absolute end-0 text-decoration-none text-muted password-addon"
                                    type="button" id="password-addon"><i class="align-middle ri-eye-fill"></i></button>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-secondary" id="updatePasswordSubmitBtn">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="<?= BASE_URL ?>assets/js/pages/password-addon.init.js"></script>
<script>
    $(document).ready(function () {
        $('#avatar').on('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    $('#avatarPreview').attr('src', e.target.result);
                }
                reader.readAsDataURL(file);
            }
        });
    });
</script>
<?php include("layouts/footer.php"); ?>