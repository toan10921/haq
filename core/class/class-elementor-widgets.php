<?php

namespace Elementor;

/**
 * Custom Elementor Widgets get singleton instance of elementor
 */
class Custom_Elementor_Widgets
{
    /**
     * Instance property, reference to singleton instance
     */
    public static $instance = null;

    /**
     * List of widgets to register
     * @var array
     */


    public static $list_widgets = [
        't888-slider',
        't888-title',
        't888-accordion',
        't888-testimonial',
        't888-product-group',
        't888-feature-box',
        't888-quote-box',
        't888-video',
        't888-tip-list',
        't888-short-post-info',
        't888-image-link-box',
        't888-product-tabs',
        't888-discount-products',
        't888-featured-categories',
        't888-advertise',
        't888-about-us',
        't888-history-timeline',
        // 't888-product-hotspot',
        't888-image-compare',
        't888-team',
        't888-location',
        't888-logo',
        't888-menu',
        't888-my-account',
        't888-search-form',
        't888-mini-cart',
        't888-hot-deals',
        't888-list-gallery',
        't888-my-wishlist',
        't888-phone',
        't888-social-list',
        't888-list-post',
        't888-list-product',
        't888-product-info',
        't888-button',
        't888-feature-products',
        't888-pet-info-box',
        't888-pet-promo-banner',
        't888-pet-promo-banner-advanced',
        't888-pet-sale-banner',
        't888-banner-ads',
        't888-pet-hot-deals-carousel',
        't888-pet-hotdeals-countdown',
        't888-pet-shop-category',
        't888-pet-mega-menu',
        'cat-mega-menu-home2',
        'fish-mega-menu-home2',
        'bird-mega-menu-home2',
        't888-pet-category-carousel',
        'pet-cate-carousel-home2',
        't888-top-brands-grid',
        't888-pet-product-carousel',
        't888-pet-shop-carousel',
        't888-footer-newsletter',
        't888-footer-features',
        't888-footer-contact',
        't888-footer-social-payment',
        't888-footer-copyright',
        't888-footer-links',
    ];

    /**
     * Get instance of singleton
     * @return Custom_Elementor_Widgets
     */
    public static function get_instance(): Custom_Elementor_Widgets
    {
        if (is_null(static::$instance)) {
            static::$instance = new self();
        }
        return static::$instance;
    }

    /**
     * Custom_Elementor_Widgets constructor.
     */

    protected function __construct()
    {
        add_action('elementor/widgets/register', [$this, 'register_widgets']);
        add_action('elementor/elements/categories_registered', [$this, 'add_elementor_widget_categories']);
        add_action('elementor/icons_manager/additional_tabs', [$this, 'add_elementor_icon_libraries']);
        if (isset($_GET['elementor-preview'])) {
            add_action('elementor/preview/init', [$this, 'add_elementor_override_preview_css']);
        }
    }

    function add_elementor_widget_categories($elements_manager)
    {

        $elements_manager->add_category(
            't888-elements',
            [
                'title' => esc_html__('Nebon Elements', 'nebon'),
                'icon' => 'fa fa-plug',
            ]
        );
    }

    /**
     * Register elementor widgets
     * @return void
     */
    public function register_widgets()
    {
        // Load base widget class using WordPress function
        $base_widget_file = get_template_directory() . '/core/elementor-widget/t888-widget-base.php';
        if (file_exists($base_widget_file)) {
            require_once $base_widget_file;
        }

        foreach (self::$list_widgets as $widget) {
            // Use WordPress function for widget files
            $widget_file = get_template_directory() . '/core/elementor-widget/controller/' . $widget . '.php';

            if (!file_exists($widget_file)) {
                continue; // Remove echo as it can break AJAX/JSON responses
            }

            require_once $widget_file;

            $widget = str_replace('-', '_', $widget);
            $class_name = 'Elementor\\' . ucwords($widget);

            if (class_exists($class_name)) {
                \Elementor\Plugin::instance()->widgets_manager->register(new $class_name());
            }
        }
    }

    public function add_elementor_icon_libraries($tabs)
    {
        $tabs['lineawesome'] = [
            'name' => 'lineawesome',
            'label' => __('Line Awesome', 'nebon'),
            'url' => get_template_directory_uri() . '/assets/css/libs/line-awesome.min.css',
            'enqueue' => [],
            'prefix' => 'la-',
            'displayPrefix' => 'la',
            'labelIcon' => 'la la-star',
            'ver' => '1.3.0',
            'fetchJson' => get_template_directory_uri() . '/assets/js/libs/lineawesome.js?v=' . ASSETS_VER,
            'native' => false,
        ];
        return $tabs;
    }

    public function add_elementor_override_preview_css()
    {
        add_action('wp_enqueue_scripts', function () {
            // read file _variables.css
            $file_path = get_template_directory() . '/assets/css/_variables.css';
            $css = file_get_contents($file_path);
            wp_add_inline_style('editor-preview', $css);
        }, 1000);
    }
}
