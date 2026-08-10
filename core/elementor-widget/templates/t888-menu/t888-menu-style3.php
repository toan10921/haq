<?php
$menu_id = $menu_id ?? '';
$category_menu_id = $category_menu_id ?? '';
$menu_location = $menu_location ?? '';
$menu_location_categories_mobile = $menu_location_categories_mobile ?? '';
?>

<button class="menu-toggle-mobile">
    <i class="las la-bars"></i>
</button>
<div class="mobile-menu-overlay"></div>
<div class="mobile-menu-wrapper">
    <div class="mobile-menu-inner">
        <div class="mobile-menu-tabs">
            <button class="tab-btn active" data-tab="main-menu"><?php esc_html_e('Menu', 'nebon'); ?></button>
            <button class="tab-btn" data-tab="category-menu"><?php esc_html_e('Categories', 'nebon'); ?></button>
        </div>

        <div class="mobile-menu-content">
            <div class="tab-content active" id="main-menu">
                <?php
                $main_menu_args = [
                    'menu_class' => 'mobile-menu-list',
                    'container' => false,
                    'walker' => new \T888Core\t888f_Walker_Nav_Menu_Frontend(),
                ];

                if (!empty($menu_location) && has_nav_menu($menu_location)) {
                    $main_menu_args['theme_location'] = $menu_location;
                } elseif (!empty($menu_id)) {
                    $main_menu_args['menu'] = (int) $menu_id;
                }

                wp_nav_menu($main_menu_args);
                ?>
            </div>

            <div class="tab-content" id="category-menu">
                <?php
                $category_menu_args = [
                    'menu_class' => 'mobile-menu-list',
                    'container' => false,
                    'walker' => new \T888Core\t888f_Walker_Nav_Menu_Frontend(),
                ];

                if (!empty($menu_location_categories_mobile) && has_nav_menu($menu_location_categories_mobile)) {
                    $category_menu_args['theme_location'] = $menu_location_categories_mobile;
                } elseif (!empty($category_menu_id)) {
                    $category_menu_args['menu'] = (int) $category_menu_id;
                }

                wp_nav_menu($category_menu_args);
                ?>
            </div>
        </div>
    </div>
</div>
