<?php
$main_color1       = get_theme_mod('t888_main_color1', '#000000');
$main_color1_switch = get_theme_mod('t888_main_color1-switch', '#ffffff');
$main_color2       = get_theme_mod('t888_main_color2', '#b88166');
$main_color2_switch = get_theme_mod('t888_main_color2_switch', '#cccccc');
?>

<div id="color-switcher" class="t888-color-switcher">
    <h4><?php esc_html_e('Choose Main Color', 'nebon'); ?></h4>
    <button class="switch-color" data-var="--primary-color" data-color="<?php echo esc_attr($main_color1); ?>" style="background:<?php echo esc_attr($main_color1); ?>"></button>
    <button class="switch-color" data-var="--primary-color" data-color="<?php echo esc_attr($main_color1_switch); ?>" style="background:<?php echo esc_attr($main_color1_switch); ?>"></button>

    <h4><?php esc_html_e('Choose Main Color 2', 'nebon'); ?></h4>
    <button class="switch-color" data-var="--third-color" data-color="<?php echo esc_attr($main_color2); ?>" style="background:<?php echo esc_attr($main_color2); ?>"></button>
    <button class="switch-color" data-var="--third-color" data-color="<?php echo esc_attr($main_color2_switch); ?>" style="background:<?php echo esc_attr($main_color2_switch); ?>"></button>
</div>
