<?php
$title = "Edit Profile";
include("layouts/top.php");
if (!isset($_SESSION["admin"])) {
    header("Location: " . ADMIN_URL . "login.php");
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
                <form action="" method="POST" id="profileInfoUpdateForm">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="<?= $_SESSION["admin"]["name"] ?>">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="<?= $_SESSION["admin"]["email"] ?>">
                        </div>
                        <div class="col-md-8 mb-3">
                            <label for="avatar" class="form-label">Profile Picture</label>
                            <input type="file" class="form-control" id="avatar" name="avatar">
                        </div>
                        <div class="col-md-4 text-center mb-3">
                            <img src="<?= $_SESSION["admin"]["avatar"] ?? BASE_URL . 'assets/images/no-avatar.png' ?>"
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
<?php include("layouts/footer.php"); ?>