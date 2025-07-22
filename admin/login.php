<?php include('layouts/header.php'); ?>

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
                                        <form action="{{route('login')}}" method="post" id="loginForm">

                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email <span
                                                        class="text-danger">*</span></label>
                                                <div class="position-relative ">
                                                    <input type="email" class="form-control  password-input"
                                                        name="email" id="email" placeholder="Enter email">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <div class="float-end">
                                                    <a href="{{route('password.request')}}" class="text-muted">Forgot
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

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember"
                                                    id="remember">
                                                <label class="form-check-label" for="remember">Remember
                                                    me</label>
                                            </div>

                                            <div class="mt-4">
                                                <button class="btn btn-primary w-100" type="submit" id="submitBtn">Sign
                                                    In
                                                </button>
                                            </div>
                                        </form>

                                        <div class="text-center mt-4">
                                            <p class="mb-0">Don't have an account ?
                                                <a href="{{route('register')}}"
                                                    class="fw-semibold text-secondary text-decoration-underline">
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

<?php include('layouts/auth-footer.php'); ?>