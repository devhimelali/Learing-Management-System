</div><!--end row-->
</div>
<!-- container-fluid -->
</div>
<!-- End Page-content -->

<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <script>
                    document.write(new Date().getFullYear())
                </script>
                © <?= APP_NAME ?>.
            </div>
            <div class="col-sm-6">
                <div class="text-sm-end d-none d-sm-block">
                    Design & Develop by 4emus
                </div>
            </div>
        </div>
    </div>
</footer>
</div>
<!-- end main content-->

</div>
<!-- END layout-wrapper -->
<!--start back-to-top-->
<button class="btn btn-dark btn-icon" id="back-to-top">
    <i class="bi bi-caret-up fs-3xl"></i>
</button>
<!--end back-to-top-->

<!--preloader-->
<div id="preloader">
    <div id="status">
        <div class="spinner-border text-primary avatar-sm" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>

<div id="loader"
    style="display: none; position: fixed; top: 50%; left: 50%;
    transform: translate(-50%, -50%); z-index: 1051; background-color: rgba(208,208,208,0.3); width: 100% ; height: 100%;">
    <div class="d-flex justify-content-center align-items-center h-100">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>


<!-- JAVASCRIPT -->
<script src="<?= BASE_URL ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= BASE_URL ?>assets/libs/simplebar/simplebar.min.js"></script>
<script src="<?= BASE_URL ?>assets/libs/toastr/toastr.min.js"></script>
<!-- Sweet Alerts js -->
<script src="<?= BASE_URL ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>

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

    function show(type, options) {
        if (['info', 'success', 'warning', 'error'].includes(type)) {
            toastr[type](options);
        } else {
            toastr.show(options);
        }
    }

    function ajaxBeforeSend(formSelector, buttonSelector) {
        $(formSelector).find('.is-invalid').removeClass('is-invalid');
        $(buttonSelector).prop('disabled', true);
        $(buttonSelector).html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...'
        );
    }

    function handleAjaxErrors(xhr, status, error) {
        switch (xhr.status) {
            case 400:
                notify('error',
                    'The request could not be processed due to invalid input. Please review your data and try again.'
                );
                break;
            case 401:
                notify('error', 'Your session has expired or you are not logged in. Please log in to continue.');
                break;
            case 403:
                notify('error',
                    'You do not have permission to perform this action. Please contact your administrator if you believe this is an error.'
                );
                break;
            case 404:
                notify('error',);
                message = 'The requested resource could not be found. It may have been moved or deleted.';
                break;
            case 422:
                let errors = xhr.responseJSON.errors;
                $.each(errors, function (key, value) {
                    notify('error', value);
                    let input = $('[name="' + key + '"]');
                    input.addClass('is-invalid');
                    if (input.closest('.auth-pass-inputgroup').length) {
                        input.closest('.auth-pass-inputgroup').find('.invalid-feedback').text(value);
                    } else {
                        input.next('.invalid-feedback').text(value);
                    }
                });
                break;
            case 429:
                notify('error', 'Too many requests. Please try again later.');
                break;
            case 500:
                notify('error',
                    'An unexpected server error occurred. Please try again later or contact support if the issue persists.'
                );
                break;
            case 0:
                notify('error',
                    'Network connection lost or server is unreachable. Please check your internet connection and try again.'
                );
                break;
            default:
                notify('error', 'An unknown error occurred. Please try again or contact support.');
                break;
        }
    }

    function ajaxComplete(buttonSelector, defaultText = 'Save') {
        $(buttonSelector).prop('disabled', false);
        $(buttonSelector).html(defaultText);
    }
</script>
<!-- App js -->
<script src="<?= BASE_URL ?>assets/js/app.js"></script>
</body>

</html>