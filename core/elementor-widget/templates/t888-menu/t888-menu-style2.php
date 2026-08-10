<?php

/**
 * Navigation Menu Widget Template - Style 2
 * Simple horizontal navigation menu
 */
$menu_id = $menu_id ?? '';
$menu_location = $menu_location ?? 'header-menu';
?>
<div class="d-flex flex-wrap align-items-center style2 main-nav ">
    <?php
    $walker = new \T888Core\t888f_Walker_Nav_Menu_Frontend();
    $args = [
        'container_class' => esc_attr($style),
        'walker' => $walker,
    ];

    if (!empty($menu_location) && has_nav_menu($menu_location)) {
        $args['theme_location'] = $menu_location;
    } elseif (!empty($menu_id)) {
        $args['menu'] = (int) $menu_id;
    }

    wp_nav_menu($args);
    ?>
</div>
