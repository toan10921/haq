<?php

/**
 * Created by Sublime Text 2.
 * User: toanngo92
 * Date: 12/08/15
 * Time: 10:20 AM
 */

namespace T888Core;

use Elementor\Custom_Elementor_Widgets;

if (!defined('ABSPATH')) return;

/** 
 * Class TemplateHelper: define some methods to help load view templates, add actions, and filters in WordPress, all actions and filters of the theme should be defined here
 * @package tech888-core
 */

if (!class_exists('TemplateHelper')) {
    class TemplateHelper
    {
        private static $instance = null;

        private static function enqueue_elementor_template_assets($template_id)
        {
            $template_id = (int) $template_id;
            if ($template_id <= 0) return;
            if (!class_exists('\\Elementor\\Plugin')) return;

            $plugin = \Elementor\Plugin::instance();
            if (!isset($plugin->frontend)) return;

            // Ensure Elementor base/widget CSS (e.g. widget-divider) is printed in <head>.
            $plugin->frontend->enqueue_styles();
            $plugin->frontend->enqueue_scripts();
            
            if (defined('ELEMENTOR_ASSETS_URL') && defined('ELEMENTOR_VERSION')) {
                wp_enqueue_style(
                    't888f-elementor-widget-divider',
                    trailingslashit(ELEMENTOR_ASSETS_URL) . 'css/widget-divider.min.css',
                    array('elementor-frontend'),
                    ELEMENTOR_VERSION
                );

                // Header/footer templates are rendered after wp_head(). Enqueue widget-specific
                // styles here so Elementor Social Icons look identical in editor and frontend.
                wp_enqueue_style(
                    't888f-elementor-widget-social-icons',
                    trailingslashit(ELEMENTOR_ASSETS_URL) . 'css/widget-social-icons.min.css',
                    array('elementor-frontend'),
                    ELEMENTOR_VERSION
                );
            }

            // Header/footer content is rendered after wp_head(), so dependencies requested
            // from inside a custom widget's render() method would otherwise be printed too late.
            $button_css_path = get_template_directory() . '/assets/css/elementor/t888-button.css';
            if (file_exists($button_css_path)) {
                wp_enqueue_style(
                    'elementor-t888-button',
                    get_template_directory_uri() . '/assets/css/elementor/t888-button.css',
                    array(),
                    filemtime($button_css_path),
                    'all'
                );
            }

            // Enqueue the generated CSS file for this Elementor template.
            if (class_exists('\\Elementor\\Core\\Files\\CSS\\Post')) {
                try {
                    (new \Elementor\Core\Files\CSS\Post($template_id))->enqueue();
                } catch (\Throwable $e) {
                    // Avoid breaking the frontend if Elementor internals change.
                }
            } elseif (method_exists($plugin->frontend, 'enqueue_post_css')) {
                // Backward/alternate Elementor API.
                $plugin->frontend->enqueue_post_css($template_id);
            }
        }

        private function __construct()
        {

            // add action hook to wp_head

            add_action('wp_head', array(__CLASS__, '_wp_head'), 10);

            // Add filter to modify the title do not use because unitest
            // add_filter('wp_title', array(__CLASS__, '_wp_title'), 10, 2);

            // Add action after setup theme
            add_action('after_setup_theme', array(__CLASS__, '_after_setup_theme'));

            // Add action to enqueue main assets
            add_action('wp_enqueue_scripts', array(__CLASS__, 'enqueue_main_assets'), 20);

            // Register sidebar

            add_action('widgets_init', array(__CLASS__, '_add_sidebars'));

            // Add action to enqueue admin scripts

            add_action('admin_enqueue_scripts', array(__CLASS__, '_add_admin_scripts'));

            // Add action when switch theme

            add_action('after_switch_theme', array(__CLASS__, '_after_switch_theme'));

            // Enqueue CSS for Gutenberg editor
            add_action('enqueue_block_editor_assets', array(__CLASS__, 'enqueue_gutenberg_editor_styles'));

            // filter body class

            add_filter('body_class', array(__CLASS__, '_body_classes'));

            // Add action to add customize post query

            add_action('pre_get_posts', array(__CLASS__, '_pre_get_posts'));

            // Add action to before main content

            add_action('t888f_before_main_content', array(__CLASS__, '_before_main_content'), 20);
            add_action('t888f_after_main_content', array(__CLASS__, '_after_main_content'), 10);
            add_action('wp_enqueue_scripts', [__CLASS__, 'enqueue_header_footer_assets'], 20);
            add_action('elementor/preview/enqueue_styles', [__CLASS__, 'enqueue_header_footer_assets'], 99);
            add_action('elementor/frontend/after_enqueue_styles', [__CLASS__, 'enqueue_header_footer_assets'], 99);
            // Initialize Custom Elementor Widgets

            add_action('init', function () {
                if (class_exists('Elementor\Widget_Base')) {
                    Custom_Elementor_Widgets::get_instance();
                }
            });

            add_filter('the_content', array(__CLASS__, '_filter_content'), 99);

            add_filter('wp_editor_set_quality', function ($quality) {
                return 100;
            });
        }

        /**
         * Get the single instance of the class
         * @return TemplateHelper
         */
        public static function get_instance()
        {
            if (self::$instance === null) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        // Prevent cloning of the instance
        private function __clone() {}

        // Prevent unserializing of the instance
        public function __wakeup() {}


        /**
         * Load view for file in template-parts folder
         * @param string $view_name
         * @param string $slug
         * @param array $data
         * @param bool $echo
         * @param string $template_dir default is '/template-parts'
         * @return string
         * @since 1.0
         */

        static function _load_view_template($view_name,  $slug = '',  $data = array(),  $echo = FALSE, $template_dir = '/template-parts')
        {
            $template_path = get_template_directory();
            $stylesheet_path = get_stylesheet_directory();
            if (!empty($slug)) {
                $path = $stylesheet_path . $template_dir . '/' . $view_name . '-' . $slug . '.php';
                if ($template_path != $stylesheet_path && is_file($path)) $template = $path;
                else $template =  get_template_directory() . $template_dir . '/' . $view_name . '-' . $slug . '.php';
                if (!is_file($template)) {
                    $path = $stylesheet_path . $template_dir . '/' . $view_name . '.php';
                    if ($template_path != $stylesheet_path && is_file($path)) $template = $path;
                    else $template = get_template_directory() . $template_dir . '/' . $view_name . '.php';
                }
            } else {
                $path = $stylesheet_path . $template_dir . '/' . $view_name . '.php';
                if ($template_path != $stylesheet_path && is_file($path)) $template = $path;
                else $template = get_template_directory() . $template_dir . '/' . $view_name . '.php';
            }
            //Allow Template be filter
            $template = apply_filters('tech888f_load_view', $template, $view_name, $slug);
            if ($data) extract($data);
            if (file_exists($template)) {
                if (!$echo) {

                    ob_start();
                    include $template;
                    return @ob_get_clean();
                } else

                    include $template;
            } else {
                echo "<p>" . esc_html__("Template not found:", "nebon") . " $template</p>";
            }
            return '';
        }

        static function _load_view_template_elementor($view_name, $slug = '', $data = array(), $echo = FALSE)
        {
            $template_dir_elementor = apply_filters('_template_dir_elementor', '/core/elementor-widget/templates');
            return self::_load_view_template($view_name, $slug, $data, $echo, $template_dir_elementor);
        }

        /**
         * Get Elementor content by page ID
         * @param int $page_id
         * @return string
         */
        public static function _get_elementor_content($page_id = null): string
        {
            if (class_exists("\\Elementor\\Plugin")) {
                if ($page_id) {
                    $pluginElementor = \Elementor\Plugin::instance();
                    $contentElementor = $pluginElementor->frontend->get_builder_content_for_display($page_id, true);
                    return $contentElementor;
                }
            }
            return '';
        }

        static function enqueue_header_footer_assets()
        {
            $is_elementor = defined('ELEMENTOR_VERSION') && (
                \Elementor\Plugin::$instance->editor->is_edit_mode()
                || \Elementor\Plugin::$instance->preview->is_preview_mode()
                || isset($_GET['elementor-preview'])
            );

            $context_id = get_the_ID();
            if ($is_elementor) {
                if (isset($_GET['elementor-preview'])) {
                    $context_id = absint($_GET['elementor-preview']);
                } elseif (isset($_GET['preview_id'])) {
                    $context_id = absint($_GET['preview_id']);
                }
            }

            if ($context_id && get_post_type($context_id) === 'header_item') {
                $css_file = get_post_meta($context_id, 'page_assets_file', true);

                // xoá handle cũ nếu có để nạp đúng file của item
                wp_dequeue_style('t888f-header-template');
                wp_deregister_style('t888f-header-template');

                if (!empty($css_file)) {
                    $handle = $is_elementor ? 't888f-header-template-' . sanitize_key($css_file) : 't888f-header-template';
                    wp_enqueue_style(
                        $handle,
                        get_template_directory_uri() . "/assets/css/template-parts/layout/header-page/{$css_file}.css",
                        [],
                        ASSETS_VER,
                        'all'
                    );
                } else {
                    wp_enqueue_style(
                        't888f-header-template',
                        get_template_directory_uri() . "/assets/css/template-parts/layout/header-template-" . get_theme_mod('header_style', 'default') . ".css",
                        [],
                        ASSETS_VER,
                        'all'
                    );
                }
                return;
            }

            if ($context_id && get_post_type($context_id) === 'footer_item') {
                $css_file = get_post_meta($context_id, 'page_assets_file', true);

                wp_dequeue_style('t888f-footer-template');
                wp_deregister_style('t888f-footer-template');

                if (!empty($css_file)) {
                    $handle = $is_elementor ? 't888f-footer-template-' . sanitize_key($css_file) : 't888f-footer-template';
                    wp_enqueue_style(
                        $handle,
                        get_template_directory_uri() . "/assets/css/template-parts/layout/footer-page/{$css_file}.css",
                        [],
                        ASSETS_VER,
                        'all'
                    );
                } else {
                    wp_enqueue_style(
                        't888f-footer-template',
                        get_template_directory_uri() . "/assets/css/template-parts/layout/footer-template-" . get_theme_mod('footer_style', 'default') . ".css",
                        [],
                        ASSETS_VER,
                        'all'
                    );
                }
                return;
            }

            $header_page = get_theme_mod('header_page', '');
            $footer_page = get_theme_mod('footer_page', '');

            // If the site uses Elementor templates for header/footer, ensure Elementor assets are
            // enqueued early (before wp_head renders) even on non-Elementor pages.
            $active_header_id = 0;
            $active_footer_id = 0;

            if ($context_id && get_post_type($context_id) === 'page') {
                $custom_header_id = get_post_meta($context_id, 'custom_header_page', true);
                $custom_footer_id = get_post_meta($context_id, 'custom_footer_page', true);
                $active_header_id = !empty($custom_header_id) ? (int) $custom_header_id : (int) $header_page;
                $active_footer_id = !empty($custom_footer_id) ? (int) $custom_footer_id : (int) $footer_page;
            } else {
                $active_header_id = (int) $header_page;
                $active_footer_id = (int) $footer_page;
            }

            // Don't do extra work while editing templates in Elementor.
            if (!$is_elementor) {
                self::enqueue_elementor_template_assets($active_header_id);
                self::enqueue_elementor_template_assets($active_footer_id);
            }

            if ($context_id && get_post_type($context_id) === 'page') {
                $custom_header_id = get_post_meta($context_id, 'custom_header_page', true);
                if (!empty($custom_header_id)) {
                    $css_file = get_post_meta($custom_header_id, 'page_assets_file', true);
                    if (!empty($css_file)) {
                        $handle = $is_elementor ? 't888f-header-template-' . sanitize_key($css_file) : 't888f-header-template';
                        wp_enqueue_style(
                            $handle,
                            get_template_directory_uri() . "/assets/css/template-parts/layout/header-page/{$css_file}.css",
                            [],
                            ASSETS_VER,
                            'all'
                        );
                    }
                }

                $custom_footer_id = get_post_meta($context_id, 'custom_footer_page', true);
                if (!empty($custom_footer_id)) {
                    $css_file = get_post_meta($custom_footer_id, 'page_assets_file', true);
                    if (!empty($css_file)) {
                        $handle = $is_elementor ? 't888f-footer-template-' . sanitize_key($css_file) : 't888f-footer-template';
                        wp_enqueue_style(
                            $handle,
                            get_template_directory_uri() . "/assets/css/template-parts/layout/footer-page/{$css_file}.css",
                            [],
                            ASSETS_VER,
                            'all'
                        );
                    }
                }
            }

            if (empty($header_page)) {
                wp_enqueue_style(
                    't888f-header-template',
                    get_template_directory_uri() . "/assets/css/template-parts/layout/header-template-" . get_theme_mod('header_style', 'default') . ".css",
                    [],
                    ASSETS_VER,
                    'all'
                );
            }
            if (empty($footer_page)) {
                wp_enqueue_style(
                    't888f-footer-template',
                    get_template_directory_uri() . "/assets/css/template-parts/layout/footer-template-" . get_theme_mod('footer_style', 'default') . ".css",
                    [],
                    ASSETS_VER,
                    'all'
                );
            }

            $css_file = get_post_meta($header_page, 'page_assets_file', true);
            if (!empty($css_file)) {
                $handle = $is_elementor ? 't888f-header-template-' . sanitize_key($css_file) : 't888f-header-template';
                wp_enqueue_style(
                    $handle,
                    get_template_directory_uri() . "/assets/css/template-parts/layout/header-page/{$css_file}.css",
                    [],
                    ASSETS_VER,
                    'all'
                );
            }

            $css_file = get_post_meta($footer_page, 'page_assets_file', true);
            if (!empty($css_file)) {
                $handle = $is_elementor ? 't888f-footer-template-' . sanitize_key($css_file) : 't888f-footer-template';
                wp_enqueue_style(
                    $handle,
                    get_template_directory_uri() . "/assets/css/template-parts/layout/footer-page/{$css_file}.css",
                    [],
                    ASSETS_VER,
                    'all'
                );
            }
        }



        /**
         * Enqueue main assets
         * @return void
         */
        static function enqueue_main_assets(): void
        {
            self::enqueue_lib_assets();
            // Enqueue main assets
            wp_enqueue_style('t888f-theme', get_template_directory_uri() . '/assets/css/theme.css', array(), ASSETS_VER, 'all');
            wp_enqueue_style('t888f-hien', get_template_directory_uri() . '/assets/css/woocommerce-template.css', array(), ASSETS_VER, 'all');
            $contact_form_css_path = get_template_directory() . '/assets/css/components/contact-form.css';
            if (file_exists($contact_form_css_path)) {
                wp_enqueue_style(
                    't888f-contact-form',
                    get_template_directory_uri() . '/assets/css/components/contact-form.css',
                    array('t888f-theme'),
                    filemtime($contact_form_css_path),
                    'all'
                );
            }
            // The Elementor header is rendered after wp_head(), therefore its custom button
            // cannot wait until render() to request this stylesheet.
            $button_css_path = get_template_directory() . '/assets/css/elementor/t888-button.css';
            if (file_exists($button_css_path)) {
                wp_enqueue_style(
                    'elementor-t888-button',
                    get_template_directory_uri() . '/assets/css/elementor/t888-button.css',
                    array('t888f-theme'),
                    filemtime($button_css_path),
                    'all'
                );
            }
            $product_card_css_path = get_template_directory() . '/assets/css/components/product-card.css';
            $product_card_css_ver = file_exists($product_card_css_path) ? filemtime($product_card_css_path) : ASSETS_VER;
            wp_enqueue_style('t888f-product-card', get_template_directory_uri() . '/assets/css/components/product-card.css', array('t888f-theme'), $product_card_css_ver, 'all');
            $industrial_counter_css_path = get_template_directory() . '/assets/css/components/industrial-counter.css';
            if (file_exists($industrial_counter_css_path)) {
                wp_enqueue_style(
                    't888f-industrial-counter',
                    get_template_directory_uri() . '/assets/css/components/industrial-counter.css',
                    array('t888f-theme'),
                    filemtime($industrial_counter_css_path),
                    'all'
                );
            }
            // Enqueue main script
            wp_enqueue_script('t888f-script', get_template_directory_uri() . '/assets/js/script.js', array('jquery'), ASSETS_VER, true);
            wp_enqueue_script('t888f-ajax', get_template_directory_uri() . '/assets/js/ajax.js', array('jquery'), ASSETS_VER, true);
            wp_enqueue_script('t888f-ajax-filters', get_template_directory_uri() . '/assets/js/ajax-filters.js', array('jquery'), ASSETS_VER, true);
            // add global variable to the script
            wp_localize_script('t888f-ajax', 't888_ajax', [
                'ajax_url' => admin_url('admin-ajax.php'),
            ]);

            self::enqueue_header_footer_assets();
            // check if is single post

            if (is_single() && get_post_type() == 'post') {
                wp_enqueue_style('t888f-single-post', get_template_directory_uri() . '/assets/css/template-parts/layout/single-post.css', array(), ASSETS_VER, 'all');

                // add post tags to global variable meet tags cloud widget requirement,
                //  custom only for nebon theme  
                TemplateHelper::_add_post_tags_global_variable_to_js();
            }

            // if (check_woocommerce_exists() && is_product()) {
            // import directly to grid-default.css because it is used in quickview
            $single_product_css_path = get_template_directory() . '/assets/css/template-parts/layout/single-product.css';
            $single_product_css_ver = file_exists($single_product_css_path) ? filemtime($single_product_css_path) : ASSETS_VER;
            wp_enqueue_style('t888f-single-product', get_template_directory_uri() . '/assets/css/template-parts/layout/single-product.css', array(), $single_product_css_ver, 'all');
            wp_enqueue_script('t888f-single-product', get_template_directory_uri() . '/assets/js/single-product.js', array('jquery'), ASSETS_VER, true);
            // }
            // check if is woocommerce page
            // use swiper in global for page use shop elementor widget
            // if (check_woocommerce_exists() && is_woocommerce()) {
            wp_enqueue_style('t888-swiper', get_template_directory_uri() . '/assets/css/libs/swiper.min.css', array(), ASSETS_VER, 'all');
            wp_enqueue_script('t888-swiper', get_template_directory_uri() . '/assets/js/libs/swiper.min.js', array('jquery'), ASSETS_VER, true);
            // }

            wp_enqueue_script('fancybox', get_template_directory_uri() . '/assets/js/libs/fancybox.umd.js', array('jquery'), ASSETS_VER, true);
            wp_enqueue_script('event-move', get_template_directory_uri() . '/assets/js/libs/jquery.event.move.js', ['jquery'], null, true);
            wp_enqueue_script('twentytwenty', get_template_directory_uri() . '/assets/js/libs/jquery.twentytwenty.js', ['jquery', 'event-move'], null, true);
            wp_enqueue_script('overlay-js', get_template_directory_uri() . '/assets/js/libs/overlay.min.js', ['jquery'], null, true);
            wp_enqueue_script('rellax-js', get_template_directory_uri() . '/assets/js/libs/rellax.min.js', ['jquery'], null, true);
            wp_enqueue_script('masonry-js', get_template_directory_uri() . '/assets/js/libs/masonry.pkgd.min.js', ['jquery'], null, true);


            // enqueue responsive css

            wp_enqueue_style('t888f-responsive', get_template_directory_uri() . '/assets/css/theme-responsive.css', array(), ASSETS_VER, 'all');

            if (is_singular() && comments_open() && get_option('thread_comments')) {
                wp_enqueue_script('comment-reply');
            }
            wp_enqueue_script(
                'reply-hook',
                get_stylesheet_directory_uri() . '/assets/js/reply-hook.js',
                ['comment-reply', 'jquery'],
                '1.0',
                true
            );
            // jquery ui slider

            wp_enqueue_script('jquery-ui-slider');
            wp_enqueue_style('jquery-ui-css', get_template_directory_uri() . '/assets/css/libs/jquery-ui.min.css');
        }

        /**
         * Enqueue Gutenberg editor styles for gutenberg editor in widgets page
         * @return void
         */
        static function enqueue_gutenberg_editor_styles(): void
        {
            wp_enqueue_style(
                'gutenberg-editor-styles',
                get_template_directory_uri() . '/assets/admin/css/gutenberg-editor.css',
                array(),
                ASSETS_VER,
                'all'
            );
            wp_enqueue_style(
                'line-awesome-gutenberg',
                get_template_directory_uri() . '/assets/css/libs/line-awesome.min.css',
                array(),
                ASSETS_VER,
                'all'
            );
            
            // Add Google Fonts for Gutenberg editor
            wp_enqueue_style(
                'google-fonts-gutenberg',
                'https://fonts.googleapis.com/css2?family=Philosopher:ital,wght@0,400;0,700;1,400;1,700&family=Poppins:ital,wght@0,400;0,900;1,400;1,900&display=swap',
                array(),
                null
            );
        }


        /**
         * Enqueue library assets
         * @return void
         */
        static function enqueue_lib_assets(): void
        {
            // wp_enqueue_style('t888f-font-awesome', get_template_directory_uri() . '/assets/css/libs/font-awesome.min.css', array(), ASSETS_VER, 'all');
            wp_enqueue_style('t888f-line-awesome', get_template_directory_uri() . '/assets/css/libs/line-awesome.min.css', array(), ASSETS_VER, 'all');
            wp_enqueue_style('t888f-fancybox', get_template_directory_uri() . '/assets/css/libs/fancybox.css', array(), ASSETS_VER, 'all');
            wp_enqueue_style('t888f-twenty-twenty', get_template_directory_uri() . '/assets/css/libs/twentytwenty.css', array(), ASSETS_VER, 'all');
        }

        /**
         * Filter the title in WordPress, used in wp_title hook in __construct
         * @param string $title
         * @param string $sep
         * @return string
         * @since 1.0
         */
        static function _wp_title($title, $sep)
        {
            return $title;
        }

        /**
         * Action after setup theme, used to add theme support, post formats, image sizes, text domain, and register nav menus
         * @return void
         * @since 1.0
         */
        static function _after_setup_theme(): void
        {

            // load text domain after theme setup
            load_theme_textdomain('nebon', get_template_directory() . '/languages');

            // register nav menu
            register_nav_menus(
                array(
                    'header-menu' => __('Header Menu', 'nebon'),
                    'header-menu2' => __('Header Menu 2 (use for right menu in Header style 4)', 'nebon'),
                    'right-menu-header-3' => __('Right Menu Header Style 3 (use for right menu in Header style 3)', 'nebon'),
                    'mobile-menu' => __('Mobile Menu - Left Tab', 'nebon'),
                    'mobile-menu-categories' => __('Mobile Menu Categories - Right Tab (use for categories menu in Mobile)', 'nebon'),
                    // 'footer-menu' => __('Footer Menu', 'nebon') // for future use
                )
            );
            // Add theme support
            add_theme_support("title-tag");
            add_theme_support('automatic-feed-links');
            add_theme_support('post-thumbnails');
            add_theme_support('post-formats', array(
                'image',
                'video',
                'gallery',
                'audio',
                'quote'
            ));
            add_theme_support('html5', array(
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
            ));
            // add_theme_support('custom-header');
            add_theme_support('custom-background');

            // Add theme support for WooCommerce
            add_theme_support('wc-product-gallery-slider');
            add_theme_support('woocommerce', array(
                'gallery_thumbnail_image_width' => 150,
            ));

            add_theme_support('editor-styles');
            add_editor_style('assets/admin/css/gutenberg-editor.css');
            // add google fonts & line-awesome for gutenberg editor
            add_editor_style('https://fonts.googleapis.com/css2?family=Philosopher:ital,wght@0,400;0,700;1,400;1,700&family=Poppins:ital,wght@0,400;0,900;1,400;1,900&display=swap');
            add_editor_style('assets/css/libs/line-awesome.min.css');

            // Block editor friendly
            add_theme_support('wp-block-styles');
            add_theme_support('align-wide');
            add_theme_support('responsive-embeds');

            add_theme_support('custom-logo', array(
                'height'      => 55,
                'width'       => 145,
                'flex-width'  => true,
                'flex-height' => true,
            ));

            // Header image 
            // add_theme_support('custom-header', array(
            //     'width'              => 1920,
            //     'height'             => 75,
            //     'flex-width'         => true,
            //     'flex-height'        => true,
            //     'header-text'        => false,
            //     'default-text-color' => '000000',
            //     'uploads'            => true,
            // ));

            // Add custom image sizes
            add_image_size('post-list', 1040, 563, true); // 960px by 660px, cropped
            add_image_size('post-list2', 470, 400, true);
            add_image_size('post-list3', 505, 273, true);
            add_image_size('product-list-default', 327, 482, true); // 327px by 482px, cropped
            add_image_size('product-detail-main', 550, 825, true); // 550px by 825px, cropped
            add_image_size('product-grid-boxsale', 370, 410, true); // 370px by 410px, cropped
            // add_image_size('product-grid-default', 327, 482, true); // 276px by 408px, cropped
            add_image_size('product-feature-products', 265, 387, true); // 265px by 387px, cropped
            add_image_size('product-search-ajax', 150, 150, true); // 150px by 150px, cropped
            add_image_size('shop_thumbnail', 100, 150, true); // 100px by 150px, cropped
            add_image_size('product_detail_sticky762', 662, 762, true);
            add_image_size('post-thumbnail-widget', 100, 100, true); // 100px by 100px, cropped

            // Add custom image sizes to the media library dropdown

            add_filter('image_size_names_choose', array(__CLASS__, '_add_image_custom_sizes'));
        }

        /**
         * Add custom image sizes to the media library dropdown
         * @param array $sizes
         * @return array
         */

        static function _add_image_custom_sizes($sizes)
        {
            return array_merge($sizes, array(
                'post-list' => __('Post List Size', 'nebon'),
                'post-list2' => __('Post List Size 2', 'nebon'),
            ));
        }

        /**
         * Register sidebars
         * @return void
         */
        static function _add_sidebars(): void
        {
            register_sidebar(array(
                'name'          => __('Blog Sidebar', 'nebon'),
                'id'            => 'blog-sidebar',
                'description'   => __('A blog sidebar for use.', 'nebon'),
                'before_widget' => '<div class="widget">',
                'after_widget'  => '</div>',
                'before_title'  => '<h2 class="widget-title title">',
                'after_title'   => '</h2>',
            ));

            register_sidebar(array(
                'name'          => __('WooCommerce Sidebar', 'nebon'),
                'id'            => 'woocommerce-sidebar',
                'description'   => __('Sidebar for WooCommerce pages.', 'nebon'),
                'before_widget' => '<div class="widget %2$s">',
                'after_widget'  => '</div>', // HTML after each widget.
                'before_title'  => '<h2 class="widget-title">',
                'after_title'   => '</h2>',
            ));
        }

        /**
         * Enqueue admin scripts
         * @return void
         */
        static function _add_admin_scripts(): void
        {
            // Enqueue admin scripts
        }

        /**
         * Add classes to the body tag
         * @param array $classes
         * @return array
         */
        static function _body_classes($classes): array
        {
            // Add class to body tag
            $classes[] = 't888f-body';
            return $classes;
        }

        /**
         * Customize post query
         * @param WP_Query $query
         * @return void
         */
        static function _pre_get_posts($query): void
        {
            // Customize post query
        }

        /**
         * Action before main content
         * @return void
         */
        static function _before_main_content(): void
        {
            // Add customize template action to before main content
            // add breadcrumb
            t888f_breadcrumb(' <i class="las la-angle-right step-breadcrumb"></i> ');
            // add content before main section

            $blog_append_content_before_id = get_theme_mod('blog_append_content_before', null);
            if ($blog_append_content_before_id) {
                echo '<div class="blog-append-content-before">' . TemplateHelper::_get_elementor_content($blog_append_content_before_id) . '</div>';
            }
        }

        /**
         * Action after main content
         * @return void
         */
        static function _after_main_content(): void
        {
            // Add action to after main content
            // add content after main section
            $blog_append_content_after_id = get_theme_mod('blog_append_content_after', null);
            if ($blog_append_content_after_id) {
                echo '<div class="blog-append-content-after">' . TemplateHelper::_get_elementor_content($blog_append_content_after_id) . '</div>';
            }
        }

        /**
         * Filter content
         * @param string $content
         * @return string
         */
        static function _filter_content($content): string
        {
            // Filter content
            return $content;
        }

        /**
         * Action after switch theme
         * @return void
         */

        static function _after_switch_theme(): void {}

        /**
         * Action to add custom classes to the head tag
         * @return void
         */

        static function _wp_head(): void
        {
            // Add custom classes to the head tag

            // load google font default
            GoogleFont::getFontHtml(
                array(
                    0 =>
                    // 'Material+Symbols+Outlined:wght@100',
                    'Philosopher:ital,wght@0,400;0,700;1,400;1,700',
                    'Poppins:ital,wght@0,400;0,900;1,400;1,900'

                )
            );
        }

        static function _add_post_tags_global_variable_to_js()
        {
            // custom only for nebon theme
            $post_tags = wp_get_post_tags(get_the_ID());
            $tag_names = array_map(function ($tag) {
                return $tag->slug;
            }, $post_tags);

            $currentTags = json_encode(get_the_tags() ? wp_list_pluck(get_the_tags(), 'slug') : array());

            // add global variable to the script
            wp_localize_script('t888f-script', 'postTagsData', array(
                'postTags' => $tag_names,
                'currentTags' => $currentTags
            ));
        }

        public static function register_shortcodes()
        {
            if (function_exists('tech888f_register_shortcodes')) {
                tech888f_register_shortcodes('template', function ($atts) {
                    $atts = shortcode_atts([
                        'id' => ''
                    ], $atts);

                    $id = intval($atts['id']);
                    if (!$id) return '';

                    if (did_action('elementor/loaded')) {
                        // Render with CSS enabled so widgets (e.g. divider) work on non-Elementor pages.
                        return \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($id, true);
                    }

                    return '';
                });
            }
        }

        public static function render_preloader()
        {
            $enable = get_theme_mod('preload', 'off');
            if ($enable !== 'on') return;

            $bg_color     = get_theme_mod('background_preload', '#ffffff');
            $style        = get_theme_mod('preload_style', 'style1');
            $preload_img  = get_theme_mod('preload_image');
            t888f_get_template('common/preload', '', array(
                'bg_color' => $bg_color,
                'style' => $style,
                'preload_img' => $preload_img
            ), true);
        }
    }

    // Initialize the singleton instance
    TemplateHelper::get_instance();
    TemplateHelper::register_shortcodes();
}
