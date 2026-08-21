<?php

/**
 * Navigation Menu Widget Template - Style 5.
 * Uses the WordPress menu selected in the widget and only changes presentation.
 */
$menu_id = isset($menu_id) ? absint($menu_id) : 0;
$menu_location = isset($menu_location) ? (string) $menu_location : '';
$menu_dom_id = 't888-menu-style5-' . sanitize_html_class($widget_id ?? wp_unique_id('menu-'));

$add_style5_link_class = static function ($atts) {
    $atts['class'] = trim(($atts['class'] ?? '') . ' menu-link');
    return $atts;
};

$menu_args = [
    'container' => false,
    'menu_class' => 't888-menu-style5__list',
    'menu_id' => $menu_dom_id,
    'fallback_cb' => false,
    'depth' => 0,
];

// The explicitly selected menu is authoritative. Use the location only as fallback.
if ($menu_id > 0) {
    $menu_args['menu'] = $menu_id;
} elseif ($menu_location !== '' && has_nav_menu($menu_location)) {
    $menu_args['theme_location'] = $menu_location;
}
?>
<nav class="t888-menu-style5" aria-label="<?php esc_attr_e('Primary navigation', 'nebon'); ?>">
    <?php if (!empty($menu_args['menu']) || !empty($menu_args['theme_location'])) :
        add_filter('nav_menu_link_attributes', $add_style5_link_class, 10, 1);
        try {
            wp_nav_menu($menu_args);
        } finally {
            remove_filter('nav_menu_link_attributes', $add_style5_link_class, 10);
        }
    elseif (current_user_can('edit_theme_options')) : ?>
        <span class="t888-menu-style5__empty">
            <?php esc_html_e('Select a WordPress menu in the Select Menu control.', 'nebon'); ?>
        </span>
    <?php endif; ?>
</nav>
