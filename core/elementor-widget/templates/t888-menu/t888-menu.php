<?php

/**
 * Navigation Menu Widget Template - Style 1
 * Simple horizontal navigation menu
 */
$menu_id = $menu_id ?? '';
$style = $style ?? 'style1';
$menu_location = $menu_location ?? 'header-menu';
?>
<div class="d-flex flex-wrap align-items-center  main-nav ">
    <?php
    $walker = new \T888Core\t888f_Walker_Nav_Menu_Frontend();
    $args = [
        'walker' => $walker,
        'menu_id' => 'menu-style1',
    ];

    if (!empty($menu_location) && has_nav_menu($menu_location)) {
        $args['theme_location'] = $menu_location;
    } elseif (!empty($menu_id)) {
        $args['menu'] = (int) $menu_id;
    }

    if (!empty($args['theme_location']) || !empty($args['menu'])) :
        wp_nav_menu($args);
    else :
        wp_nav_menu();
    endif;
    ?>
</div>
