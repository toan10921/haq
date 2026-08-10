<?php

namespace T888Core;
?>
<header class="header-default">
    <div class="header-title">
        <div class="container">
            <div class="row">
                <div class="col-3 d-flex align-items-center">
                    <div class="">
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
                <div class="col-9 d-flex align-items-center justify-content-end">
                    <div class="d-flex flex-wrap align-items-center justify-content-left main-nav ">
                        <?php
                        $walker = new t888f_Walker_Nav_Menu_Frontend();
                        if (has_nav_menu('header-menu')) :
                            wp_nav_menu(
                                array(
                                    'theme_location' => 'header-menu',
                                    'container_class' => 'header-menu',
                                    'walker' => $walker,
                                )
                            );
                        else :
                            wp_nav_menu(
                                array(
                                    'menu' => '',
                                    'container_class' => 'header-menu',
                                    'walker' => $walker,
                                )
                            );
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>