<?php

/** define global constant */

define('ASSETS_VER', '1.5.5');

/**
 * require global config
 */
require_once trailingslashit(get_template_directory()) . 'core/class/class-global-config.php';

/**
 * require plugin activation
 */

require_once trailingslashit(get_template_directory()) . 'core/class/class-tgm-plugin-activation.php';
require_once trailingslashit(get_template_directory()) . 'core/class/class-require-plugins.php';
/** itergrate elementor call before template-helper to ensure that instance exist before add action init */
require_once trailingslashit(get_template_directory()) . 'core/class/trait/blog-post-trait.php';
require_once trailingslashit(get_template_directory()) . 'core/class/trait/shop-product-trait.php';
require_once trailingslashit(get_template_directory()) . 'core/class/class-elementor-widgets.php';
require_once trailingslashit(get_template_directory()) . 'core/class/class-template-helper.php';
require_once trailingslashit(get_template_directory()) . 'core/class/class-woocommerce-helper.php';
require_once trailingslashit(get_template_directory()) . 'core/class/class-woocommerce-variable.php';
require_once trailingslashit(get_template_directory()) . 'core/class/class-google-fonts.php';
require_once trailingslashit(get_template_directory()) . 'core/helper/helper.php';

require_once trailingslashit(get_template_directory()) . 'core/class/class-custom-walker-category.php';

/**
 * require class for mega menu
 */
require_once trailingslashit(get_template_directory()) . 'core/class/mega-menu/base-walker-mega-menu.php';
require_once trailingslashit(get_template_directory()) . 'core/class/mega-menu/admin/custom-field-walker-nav-menu.php';
require_once trailingslashit(get_template_directory()) . 'core/class/mega-menu/admin/walker-admin-nav-menu.php';
require_once trailingslashit(get_template_directory()) . 'core/class/mega-menu/frontend/walker-nav-menu-frontend.php';

/** register customizer-settings (theme options) */
require_once trailingslashit(get_template_directory()) . 'core/customizer/customizer.php';


/** register post type */
require_once trailingslashit(get_template_directory()) . 'core/post-type/mega-page.php';
require_once trailingslashit(get_template_directory()) . 'core/post-type/header-page.php';
require_once trailingslashit(get_template_directory()) . 'core/post-type/footer-page.php';


require_once trailingslashit(get_template_directory()) . 'core/widget/list-post.php';
require_once trailingslashit(get_template_directory()) . 'core/widget/social-icons.php';
require_once trailingslashit(get_template_directory()) . 'core/widget/author.php';
require_once trailingslashit(get_template_directory()) . 'core/widget/image-text.php';
require_once trailingslashit(get_template_directory()) . 'core/widget/filter-price.php';
require_once trailingslashit(get_template_directory()) . 'core/widget/filter-brand.php';
require_once trailingslashit(get_template_directory()) . 'core/widget/list-product.php';
require_once trailingslashit(get_template_directory()) . 'core/widget/filter-attribute.php';
require_once trailingslashit(get_template_directory()) . 'core/widget/select-mega.php';

require_once trailingslashit(get_template_directory()) . 'core/custom-fields/metabox-product-controller.php';
require_once trailingslashit(get_template_directory()) . 'core/custom-fields/metabox-post-controller.php';
require_once trailingslashit(get_template_directory()) . 'core/custom-fields/metabox-page-controller.php';
require_once trailingslashit(get_template_directory()) . 'core/custom-fields/metabox-header-controller.php';
require_once trailingslashit(get_template_directory()) . 'core/custom-fields/metabox-footer-controller.php';

require_once trailingslashit(get_template_directory()) . 'core/function.php';