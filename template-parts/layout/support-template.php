<?php if (get_theme_mod('show_support', 'off') === 'on') : ?>
    <?php
    $image_intro       = get_theme_mod('image_intro', '');
    $title_intro       = get_theme_mod('title_intro', __('Tache - Woocomerce WordPress theme', 'nebon'));
    $link_intro        = get_theme_mod('link_intro', 'https://themeforest.net/user/7uptheme');
    $title_link_intro  = get_theme_mod('title_link_intro', __('Buy Now', 'nebon'));
    $main_color1         = get_theme_mod('t888_main_color1', '#000000');
    $main_color1_switch  = get_theme_mod('t888_main_color1-switch', '#cccccc');
    $main_color2         = get_theme_mod('t888_main_color2', '#b88166');
    $main_color2_switch  = get_theme_mod('t888_main_color2_switch', '#ffde00');
    $link_support        = get_theme_mod('link_support', 'https://7uptheme.net/');
    $link_guide          = get_theme_mod('link_guide', 'https://7uptheme.net/');
    ?>
    <div class="t888-floating-buttons">
        <button id="t888ToggleSwitcher" class="btn btn-toggle button">
            <i class="las la-long-arrow-alt-left"></i>
            <span><?php esc_html_e('Open', 'nebon'); ?></span>
        </button>
        <button class="btn btn-support button">
            <a href="<?php echo esc_url($link_support); ?>" target="_blank" rel="noopener">
                <i class="las la-life-ring"></i>
                <span><?php esc_html_e('Support', 'nebon'); ?></span>
            </a>
        </button>
        <button class="btn btn-guide button">
            <a href="<?php echo esc_url($link_guide); ?>" target="_blank" rel="noopener">
                <i class="las la-book"></i>
                <span><?php esc_html_e('Guide', 'nebon'); ?></span>
            </a>
        </button>
    </div>

    <div id="color-switcher" class="t888-color-switcher">

        <?php if ($image_intro || $title_intro || $link_intro) : ?>
            <div class="t888-intro-block">
                <?php if ($image_intro) : ?>
                    <div class="intro-image">
                        <img src="<?php echo esc_url($image_intro); ?>" alt="<?php echo esc_attr($title_intro); ?>">
                    </div>
                <?php endif; ?>

                <?php if ($title_intro) : ?>
                    <h3 class="intro-title"><?php echo esc_html($title_intro); ?></h3>
                <?php endif; ?>

                <?php if ($link_intro && $title_link_intro) : ?>
                    <a href="<?php echo esc_url($link_intro); ?>" class="intro-button button d-block primary" target="_blank" rel="noopener">
                        <?php echo esc_html($title_link_intro); ?>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <h4><?php esc_html_e('Choose main color', 'nebon'); ?></h4>
        <div class="d-flex align-items-center justify-content-center" style="gap:10px;">
            <div style="border: 1px solid rgba(184,129,102,.3); border-radius: 50%;">
                <button class="switch-color color-toggle-btn active"
                    data-var="--third-color"
                    data-color="<?php echo esc_attr($main_color2); ?>"
                    style="background:<?php echo esc_attr($main_color2); ?>;">
                </button>
            </div>
            <div style="border: 1px solid rgba(184,129,102,.3); border-radius: 50%;">
                <button class="switch-color color-toggle-btn"
                    data-var="--third-color"
                    data-color="<?php echo esc_attr($main_color2_switch); ?>"
                    style="background:<?php echo esc_attr($main_color2_switch); ?>;">
                </button>
            </div>
        </div>
        <h4><?php esc_html_e('Choose main color 2', 'nebon'); ?></h4>
        <div class="d-flex align-items-center justify-content-center" style="gap:10px;">
            <div style="border: 1px solid rgba(184,129,102,.3); border-radius: 50%;">
                <button class="switch-color color-toggle-btn active"
                    data-var="--primary-color"
                    data-color="<?php echo esc_attr($main_color1); ?>"
                    style="background:<?php echo esc_attr($main_color1); ?>;">
                </button>
            </div>
            <div style="border: 1px solid rgba(184,129,102,.3); border-radius: 50%;">
                <button class="switch-color color-toggle-btn"
                    data-var="--primary-color"
                    data-color="<?php echo esc_attr($main_color1_switch); ?>"
                    style="background:<?php echo esc_attr($main_color1_switch); ?>;">
                </button>
            </div>
        </div>
        <?php if (get_theme_mod('left_to_right', 'on') === 'on'): ?>
            <div id="layout-toggle-wrapper">
                <a href="#" id="toggle-direction" class="switch-dir-buton  button d-block primary"><?php esc_html_e('Switch LTR ', 'nebon'); ?><i class="las la-exchange-alt"></i><?php esc_html_e(' RTL', 'nebon'); ?></a>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>