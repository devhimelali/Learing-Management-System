<!-- JAVASCRIPT -->
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