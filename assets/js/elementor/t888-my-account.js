jQuery(document).ready(function($) {
    var $panel = $('#t888-account-panel');
    var $overlay = $panel.find('.my-account-overlay');
    var $content = $panel.find('.my-account-content');
    var $form = $panel.find('.t888-login-form');
    var successMessage = 'Login successful. Reloading your account...';

    function closeAccountPanel() {
        $panel.removeClass('active-my-account');
        $('body').removeClass('account-panel-open');
    }

    // === TOGGLE PANEL ===
    $(document).on('click', '.my-account-icon:not(.logged-in)', function(e) {
        e.preventDefault();
        console.log('[MyAccount] Open panel');
        $panel.addClass('active-my-account');
        $('body').addClass('account-panel-open'); 
    });

    $(document).on('click', '.btn-close-my-account, .my-account-overlay', function(e) {
        e.preventDefault();
        console.log('[MyAccount] Close panel');
        closeAccountPanel();
    });

    // === AJAX: get nonce  ===
    if (!$('.my-account-icon').hasClass('logged-in')) {
        $.ajax({
            url: t888_ajax_object.ajax_url,
            type: 'POST',
            data: { action: 't888_get_login_nonce' },
            success: function(response) {
                if (response.success) {
                    $form.find('input[name="woocommerce-login-nonce"]').val(response.data.nonce);
                    console.log('[MyAccount] Nonce loaded ✅');
                }
            },
            error: function(xhr, status, error) {
                console.error('[MyAccount] AJAX error:', error);
            }
        });
    }

    // === AJAX LOGIN ===
    $(document).on('submit', '.t888-login-form', function(e) {
        e.preventDefault();
        var $form = $(this);
        var $message = $form.find('.t888-login-error');
        var redirectUrl = $form.find('input[name="redirect"]').val() || window.location.href;

        $message
            .removeClass('d-none')
            .hide()
            .removeAttr('style');

        $form.find('button[type="submit"]').prop('disabled', true);

        $.ajax({
            url: t888_ajax_object.ajax_url,
            type: 'POST',
            data: $form.serialize(),
            success: function(response) {
                if (!response.success) {
                    $message
                        .removeClass('t888-login-success')
                        .html(response.data)
                        .show();
                    $form.find('button[type="submit"]').prop('disabled', false);
                    return;
                }

                $('.my-account-icon').addClass('logged-in');
                $message
                    .addClass('t888-login-success')
                    .text(response.data || successMessage)
                    .show();

                setTimeout(function() {
                    closeAccountPanel();
                    window.location.href = redirectUrl;
                }, 500);
            },
            error: function(xhr, status, error) {
                console.error('[MyAccount] AJAX error:', error);
                $message
                    .removeClass('t888-login-success')
                    .text('An error occurred. Please try again.')
                    .show();
                $form.find('button[type="submit"]').prop('disabled', false);
            }
        });
    });
});
