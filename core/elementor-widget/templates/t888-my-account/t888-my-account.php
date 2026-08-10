<div class="my-account my-account-aside <?php echo esc_attr($style); ?>">
    <a href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>"
       class="person title24 my-account-icon <?php echo is_user_logged_in() ? 'logged-in' : ''; ?>"
       aria-expanded="false" aria-controls="t888-account-panel">
        <i class="la la-user"></i>
    </a>
</div>