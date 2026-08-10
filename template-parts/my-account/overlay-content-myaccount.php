<div id="t888-account-panel" class="t888-account-root" aria-hidden="true">
        <div id="t888-account-overlay" class="my-account-overlay"></div>

        <div id="t888-account-content" class="my-account-content">
            <div class="my-account-heading d-flex align-items-center justify-content-between">
                <h5 class="fw-bold text-uppercase m-0 position-relative">
                    <?php echo esc_html__('Login', 'nebon'); ?>
                </h5>
                <div class="btn-close-my-account">
                    <a href="#" rel="nofollow">
                        <i class="la la-times"></i>
                        <span><?php echo esc_html__('Close', 'nebon'); ?></span>
                    </a>
                </div>
            </div>

            <?php if ( ! is_user_logged_in() ) : ?>
                <div class="my-account-main-body">
                    <form class="t888-login-form"
                          action="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>"
                          method="post" novalidate>
                        <input type="hidden" name="action" value="t888_do_login" />
                        <?php do_action('woocommerce_login_form_start'); ?>

                        <div class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide form-row-username">
                            <label for="username">
                                <?php echo esc_html__('Username or email address', 'nebon'); ?>
                                <span class="required" aria-hidden="true">*</span>
                                <span class="screen-reader-text"><?php esc_html_e('Required', 'nebon'); ?></span>
                            </label>
                            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text"
                                   name="username" value="">
                        </div>

                        <div class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide form-row-password">
                            <label for="password">
                                <?php echo esc_html__('Password', 'nebon'); ?>
                                <span class="required" aria-hidden="true">*</span>
                                <span class="screen-reader-text"><?php esc_html_e('Required', 'nebon'); ?></span>
                            </label>
                            <input class="woocommerce-Input woocommerce-Input--text input-text"
                                   type="password" name="password">
                        </div>

                        <div class="woocommerce-FormRow form-row">
                            <label for="rememberme" class="woocommerce-form__label woocommerce-form__label-for-checkbox">
                                <input class="woocommerce-form__input woocommerce-form__input-checkbox"
                                       name="rememberme" type="checkbox" value="forever" />
                                <?php echo esc_html__('Remember me', 'nebon'); ?>
                            </label>
                        </div>

                        <div class="form-row form-row-submit">
                            <button type="submit" class="woocommerce-Button button text-uppercase"
                                    name="login" value="<?php echo esc_attr__('Login', 'nebon'); ?>">
                                <?php echo esc_html__('Login', 'nebon'); ?>
                            </button>

                            <input type="hidden" name="redirect" value="<?php echo esc_url($redirect_url); ?>" />
                            <input type="hidden" name="woocommerce-login-nonce"
                                   value="<?php echo esc_attr( wp_create_nonce('woocommerce-login') ); ?>" />
                        </div>

                        <p class="t888-login-error d-none"></p>
                        <?php do_action('woocommerce_login_form'); ?>

                        <div class="woocommerce-LostPassword lost_password">
                            <a href="<?php echo esc_url( wp_lostpassword_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ) ); ?>">
                                <?php echo esc_html__('Lost your password?', 'nebon'); ?>
                            </a>
                        </div>

                        <?php do_action('woocommerce_login_form_end'); ?>
                    </form>

                    <?php if ( get_option('woocommerce_enable_myaccount_registration') === 'yes' ) : ?>
                        <div class="register-account d-flex flex-wrap align-items-center justify-content-center">
                            <i class="la la-user-alt-slash title48"></i>
                            <span><?php esc_html_e("Don't have an account?", 'nebon'); ?></span>
                            <a href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>">
                                <?php esc_html_e('Register', 'nebon'); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php else: ?>

            <?php endif; ?>
        </div>
    </div>