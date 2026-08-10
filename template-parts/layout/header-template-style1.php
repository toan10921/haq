<?php

namespace T888Core;
?>
<header class="header-default">
    <?php
    if (check_woocommerce_exists()) {
    ?>
        <div class="header-first">
            <div class="container">
                <div class="row">


                    <div class="col-6 d-flex justify-content-start col-delivery">
                        <div class="free-delivery-content">
                            <?php if (class_exists('T888Helper\T888Helper')) : ?>
                                <span><?php echo esc_html(get_theme_mod('header_intro_title', __('Free shipping for all orders of $150', 'nebon'))); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>


                    <div class="col-6 d-flex justify-content-end col-store-location">

                        <?php if (get_theme_mod('show_location', true)) : ?>
                            <div class="language-change">
                                <i class="las la-globe"></i>
                                <?php if (class_exists('T888Helper\T888Helper')) : ?>
                                    <span class="current-lang">England</span>
                                    <i class="las la-angle-down"></i>
                                    <ul class="language-dropdown">
                                        <li><a href="#">England</a></li>
                                        <li><a href="#">France</a></li>
                                        <li><a href="#">Spain</a></li>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <?php if (get_theme_mod('show_currency', true)) : ?>
                            <div class="currency-change">
                                <i class="las la-wallet"></i>
                                <?php if (class_exists('T888Helper\T888Helper')) : ?>
                                    <span><?php echo esc_html__('Currency', 'nebon'); ?></span>
                                    <i class="las la-angle-down"></i>
                                    <ul class="currency-dropdown">
                                        <li><a href="#">$ USD</a></li>
                                        <li><a href="#">€ EUR</a></li>
                                        <li><a href="#">£ GBP</a></li>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                    </div>


                </div>
            </div>
        </div>
    <?php
    }
    ?>
    <div class="header-title">
        <div class="container">
            <div class="row">
                <div class="col-3 d-flex align-items-center">
                    <div class="text-center">
                        <?php
                        $custom_logo_id = get_theme_mod('header_logo');
                        $custom_logo_url = wp_get_attachment_url($custom_logo_id);
                        $logo_icon = get_theme_mod('logo_icon', 'las la-rainbow');
                        $logo_text = get_theme_mod('logo_text', 'nebon');
                        ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
                            <?php if ($custom_logo_url) : ?>
                                <img src="<?php echo esc_url($custom_logo_url); ?>" alt="<?php bloginfo('name'); ?>" class="site-logo-img">
                            <?php else : ?>
                                <i class="<?php echo esc_attr($logo_icon); ?>"></i>
                                <span><?php echo esc_html($logo_text); ?></span>
                            <?php endif; ?>
                        </a>
                    </div>


                </div>

                <div class="col-6 text-center">
                    <div class="d-flex flex-wrap align-items-center justify-content-center main-nav ">
                        <?php
                        // check if menu have them_location or not
                        $walker = new t888f_Walker_Nav_Menu_Frontend();
                        if (has_nav_menu('header-menu')) :
                            wp_nav_menu(
                                array(
                                    'theme_location' => 'header-menu',
                                    'container_class' => 'header-menu',
                                    // 'items_wrap'           => '<button class="close"></button><h4 class="menu-header">MENU</h4><ul id="%1$s" class="%2$s">%3$s</ul>',
                                    'walker' => $walker,
                                )
                            );
                        else :
                            wp_nav_menu();
                        endif;
                        ?>
                    </div>
                </div>
                <div class="col-3 d-flex align-items-center justify-content-end">

                    <div class="header-extra">
                        <?php
                        if (check_woocommerce_exists()) {
                        ?>
                            <?php if (class_exists(('T888Helper\T888Helper'))) : ?>

                                <a href="#" class="person"><i class="la la-user"></i></a>
                                <div class="overlay-search-outer ">
                                    <div class="block-element block-search-element d-flex position-relative">
                                        <a id="trigger-overlay" href="javascript:void(0)" class="toggle-search d-flex align-items-center justify-content-center">
                                            <i class="las la-search"></i>
                                        </a>
                                        <div class="overlay overlay-genie" data-steps="m 701.56545,809.01175 35.16718,0 0,19.68384 -35.16718,0 z;m 698.9986,728.03569 41.23353,0 -3.41953,77.8735 -34.98557,0 z;m 687.08153,513.78234 53.1506,0 C 738.0505,683.9161 737.86917,503.34193 737.27015,806 l -35.90067,0 c -7.82727,-276.34892 -2.06916,-72.79261 -14.28795,-292.21766 z;m 403.87105,257.94772 566.31246,2.93091 C 923.38284,513.78233 738.73561,372.23931 737.27015,806 l -35.90067,0 C 701.32034,404.49318 455.17312,480.07689 403.87105,257.94772 z;M 51.871052,165.94772 1362.1835,168.87863 C 1171.3828,653.78233 738.73561,372.23931 737.27015,806 l -35.90067,0 C 701.32034,404.49318 31.173122,513.78234 51.871052,165.94772 z;m 52,26 1364,4 c -12.8007,666.9037 -273.2644,483.78234 -322.7299,776 l -633.90062,0 C 359.32034,432.49318 -6.6979288,733.83462 52,26 z;m 0,0 1439.999975,0 0,805.99999 -1439.999975,0 z">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 1440 806" preserveAspectRatio="none">
                                                <path class="overlay-path" d="m 701.56545,809.01175 35.16718,0 0,19.68384 -35.16718,0 z" />
                                            </svg>
                                            <form class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                                                <a href="javascript:void(0)" class="overlay-close"><i class="las la-times"></i></a>
                                                <input name="s" autocomplete="off" value="" type="text" placeholder="Bonjour! What are you searching for?" class="input-search fw-normal title13" />
                                                <input type="hidden" value="" name="post_type" id="post_type" />
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="mini-cart-box aside-box">
                                    <a href="#" class="mini-cart-link">
                                        <span class="cart-number"><?php echo esc_html(0); ?></span>
                                        <i class="lab la-opencart"></i>
                                    </a>
                                    <div class="mini-cart-overlay"></div>
                                    <div class="mini-cart-content dropdown-list">
                                        <div class="mini-cart-heading d-flex align-items-center justify-content-between">
                                            <span class="font-philosopher fw-bold text-uppercase"><?php echo esc_html__('Cart', 'nebon') ?></span>
                                            <div class="btn-close-mini-cart">
                                                <a href="#" rel="nofollow"><i class="la la-times"></i></a>
                                            </div>
                                        </div>
                                        <div class="mini-cart-main-body">
                                            <div class="mini-cart-main-content">
                                                <div class="mini-cart-empty"><?php echo esc_html('No products in the cart.', 'nebon') ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>