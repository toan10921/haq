<?php

/**
 * Created by Sublime Text 2.
 * User: toanngo92
 * Date: 07/01/2025
 * Time: 10:20 AM
 */

namespace T888Core;

if (class_exists("woocommerce")) {
    /**
     * Class WoocommerceHelper
     * 
     * Singleton class to provide WooCommerce-related customizations and utility functions.
     * 
     * @package T888Core
     */
    class WoocommerceHelper
    {
        /**
         * @var WoocommerceHelper|null The single instance of the class.
         */
        private static $instance = null;
        private $shop_posts_per_page;

        /**
         * Get the single instance of the class.
         * 
         * @return WoocommerceHelper The single instance of the class.
         */
        public static function instance()
        {
            if (self::$instance == null) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        /**
         * Prevent cloning of the instance.
         */
        private function __clone() {}

        /**
         * Prevent unserializing of the instance.
         */
        public function __wakeup() {}

        /**
         * WoocommerceHelper constructor.
         * Initializes the hooks and customizations for WooCommerce.
         */
        public function __construct()
        {
            if (class_exists("woocommerce")) {
                $this->shop_posts_per_page = isset($_GET['posts_per_page']) ? intval($_GET['posts_per_page']) : get_theme_mod('product_number_general', 12);

                // Enqueue custom scripts compare for WooCommerce, fix shop not work
                wp_enqueue_script('yith-woocompare-main');

                // Handle ajax action
                $this->handle_ajax_action();
                // Remove woocommerce hook
                $this->remove_woocommerce_hook();
                // Add woocommerce hook
                $this->add_woocommerce_hook();

                add_action('wp_ajax_t888_load_mini_cart', [$this, 'loadMiniCart']);
                add_action('wp_ajax_nopriv_t888_load_mini_cart', [$this, 'loadMiniCart']);
                add_action('wp_ajax_t888_remove_cart_item', [$this, 'remove_cart_item']);
                add_action('wp_ajax_nopriv_t888_remove_cart_item', [$this, 'remove_cart_item']);
                add_action('wp_ajax_t888_update_cart_item_quantity', [$this, 'update_cart_item_quantity']);
                add_action('wp_ajax_nopriv_t888_update_cart_item_quantity', [$this, 'update_cart_item_quantity']);
                add_action('template_redirect', [$this, 't888f_track_product_views']);
                add_action('wp_enqueue_scripts', [$this, 'enqueue_woocommerce_assets']);

                // add ajax action for my account
                add_action('wp_ajax_t888_get_login_nonce', [$this, 'get_login_nonce']);
                add_action('wp_ajax_nopriv_t888_get_login_nonce', [$this, 'get_login_nonce']);
                // add ajax action for login
                add_action('wp_ajax_t888_do_login', [$this, 'do_login_woocommerce']);
                add_action('wp_ajax_nopriv_t888_do_login', [$this, 'do_login_woocommerce']);

                // add ajax action for product quick view
                add_action('wp_ajax_t888_quickview_product', [$this, 'quick_view_product']);
                add_action('wp_ajax_nopriv_t888_quickview_product', [$this, 'quick_view_product']);
                // modify query shop, archive, product category, product tag
                add_action('pre_get_posts', [$this, 'modify_param_woocommerce_main_query'], 20);

                // search form element
                add_action('wp_ajax_ajax_search_form', [$this, 'ajax_search']);
                add_action('wp_ajax_nopriv_ajax_search_form', [$this, 'ajax_search']);
                // add set to cart elemet
                add_action('wp_ajax_t888_add_set_to_cart', [$this, 't888_ajax_add_set_to_cart']);
                add_action('wp_ajax_nopriv_t888_add_set_to_cart', [$this, 't888_ajax_add_set_to_cart']);
            }
        }

        function modify_param_woocommerce_main_query($query)
        {
            // fix Call to undefined function is_shop() error
            if (!check_woocommerce_exists()) {
                return;
            }

            if (!is_admin() && $query->is_main_query() && (is_shop() || is_product_category() || is_product_taxonomy() || is_product_tag())) {
                // change query url to shop page

                $query->set('posts_per_page', $this->shop_posts_per_page);
                // Pagination
                if (isset($_GET['posts_per_page'])) {
                    $query->set('posts_per_page', intval($_GET['posts_per_page']));
                }

                $tax_query  = [];
                $meta_query = [];

                if (!empty($_GET['brand'])) {
                    $brands = explode(',', sanitize_text_field($_GET['brand']));
                    $tax_query[] = [
                        'taxonomy' => 'product_brand',
                        'field'    => 'slug',
                        'terms'    => $brands,
                        'operator' => 'IN',
                    ];
                }

                foreach ($_GET as $key => $value) {
                    if (strpos($key, 'pa_') === 0 && !empty($value)) {
                        if (is_array($value)) {
                            $terms = array_map('sanitize_text_field', $value);
                        } else {
                            $terms = explode(',', sanitize_text_field($value));
                        }

                        $tax_query[] = array(
                            'taxonomy' => $key,
                            'field'    => 'slug',
                            'terms'    => $terms,
                            'operator' => 'IN',
                        );
                    }
                }

                if (isset($_GET['min_price']) || isset($_GET['max_price'])) {
                    $min_price = isset($_GET['min_price']) ? floatval($_GET['min_price']) : 0;
                    $max_price = isset($_GET['max_price']) ? floatval($_GET['max_price']) : PHP_INT_MAX;

                    $meta_query[] = [
                        'key'     => '_price',
                        'value'   => [$min_price, $max_price],
                        'compare' => 'BETWEEN',
                        'type'    => 'DECIMAL',
                    ];
                }

                if (!empty($tax_query)) {
                    $query->set('tax_query', array_merge(['relation' => 'AND'], $tax_query));
                }

                if (!empty($meta_query)) {
                    $query->set('meta_query', $meta_query);
                }
                if (isset($_GET['s']) && !empty($_GET['s'])) {
                    $query->set('s', sanitize_text_field($_GET['s']));
                }

                if (isset($_GET['product_cat']) && !empty($_GET['product_cat'])) {
                    $categories = explode(',', sanitize_text_field($_GET['product_cat']));
                    $tax_query[] = [
                        'taxonomy' => 'product_cat',
                        'field'    => 'slug',
                        'terms'    => $categories,
                        'operator' => 'IN',
                    ];
                    $query->set('tax_query', array_merge(['relation' => 'AND'], $tax_query));
                }
            }
        }

        /**
         * Remove default WooCommerce hooks.
         *
         * @return void
         */


        public function remove_woocommerce_hook()
        {
            // remove default woocommerce breadcrumb
            remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
            // remove default woocommerce content wrapper
            remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 30);
            remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 30);
            // remove default result count
            remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
            // remove default catalog ordering
            remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
            // remove default woocommerce sidebar
            remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
            // remove default product header
            // remove_action('woocommerce_shop_loop_header', 'woocommerce_product_taxonomy_archive_description', 10);
            // remove default woocommerce pagination
            remove_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 10);


            // remove_action('woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10);

            // Remove action loop product
            // remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
            // remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
            // remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
            // remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
            // remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
            // remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
            // remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
            // remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

            // Remove action single product comment all for defaults

            // Remove default product images & flashsale
            remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
            remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
            // remove_action('woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20);
            // remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
            // remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
            // remove_action( 'woocommerce_single_product_summary','woocommerce_template_single_add_to_cart',30 );
            // remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
            // remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
            remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);

            // Remove rating in list products
            remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
            // Remove add to cart in list products
            // remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
            if( function_exists('YITH_WCWL_Frontend') ){
                   remove_action('woocommerce_after_add_to_cart_form', array(YITH_WCWL_Frontend(), 'print_button'), 5);
            }
            // remove action upsell single product
            remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
        }

        /**
         * Add custom WooCommerce hooks.
         *
         * @return void
         */
        public function add_woocommerce_hook()
        {
            add_action('woocommerce_before_main_content', [$this, 't888f_woocommerce_breadcrumb'], 20);
            // add_action('woocommerce_before_main_content', [$this, 't888f_before_woocommerce_main_content'], 10);
            // add_action('woocommerce_after_main_content', [$this, 't888f_after_woocommerce_main_content'], 10);
            add_action('t888f_before_woocommerce_content',  [$this, 't888f_before_woocommerce_main_content'], 10);
            add_action('t888f_after_woocommerce_content', [$this, 't888f_after_woocommerce_main_content'], 10);
            add_action('woocommerce_after_single_product_summary', [$this, 't888f_before_product_tab'], 1);
            add_action('t888f_after_product_tabs', [$this, 't888f_after_product_tab'], 10);
            add_action('t888f_before_product', [$this, 't888f_before_product_page'], 10);
            add_action('t888f_after_product', [$this, 't888f_after_product_page'], 30);
            // add_action('woocommerce_single_product_summary', [$this, 'combination_cart_wishlish_before'], 29);
            // add_action('woocommerce_single_product_summary', [$this, 'combination_cart_wishlish_after'], 32);
            // add_action('woocommerce_single_product_summary', 'woocommerce_breadcrumb', 1);
            // add_action('woocommerce_archive_description', 't888f_woocommerce_taxonomy_archive_description', 10);
            // add_action('woocommerce_archive_description', 't888f_description_category', 15);

            // add_action('woocommerce_after_single_product_summary', 't888f_product_tabs_before', 5);
            // add_action('woocommerce_after_single_product_summary', 't888f_product_tabs', 10);
            // add_action('woocommerce_after_single_product_summary', 't888f_product_tabs_after', 15);
            add_action('t888f_after_product', [$this, 't888f_single_upsell_product'], 15);
            add_action('t888f_after_product', [$this, 't888f_single_related_product'], 20);
            add_action('t888f_after_product', [$this, 't888f_single_lastest_product'], 25);
            add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 6);
            add_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 11);
            add_action('woocommerce_single_product_summary', [$this, 't888f_viewing_question'], 12);
            add_action('woocommerce_single_product_summary', [$this, 't888f_image_safe_checkout'], 40);
            add_filter('woocommerce_product_review_comment_form_args', [$this, 'customize_woocommerce_review_form'],);
            // add_action('woocommerce_single_product_summary', [$this, 't888f_product_tabs'], 40);
            add_action('woocommerce_after_shop_loop_item_title', [$this, 'short_des_list_product'], 5);
            // add_action('woocommerce_before_shop_loop', [$this, 'custom_woocommerce_ordering'], 30);

            add_action('woocommerce_after_add_to_cart_button', [$this, 'custom_add_wishlist_compare_buttons'], 15);
            add_action('woocommerce_single_variation', [$this, 'open_custom_add_user_actions'], 15);
            add_action('woocommerce_after_single_variation', [$this, 'close_custom_add_user_actions'], 20);

            // custom ordering
            add_action('t888f_custom_woocommerce_ordering', [$this, 'custom_woocommerce_ordering'], 30);
            // custom wishlist compare buttons
            add_action('t888f_custom_add_wishlist_compare_buttons', [$this, 'custom_add_wishlist_compare_buttons'], 15, 2);


            add_action('t888f_yith_wishlist_button', [$this, 'yith_wishlist_button'], 10, 1);
            add_action('t888f_yith_compare_button', [$this, 'yith_compare_button'], 10, 1);
            add_filter('woocommerce_product_tabs', [$this, 't888f_add_custom_tab'], 30);
        }

        public function enqueue_woocommerce_assets()
        {
            if ((is_shop() || is_product_category()) && get_theme_mod('shop_ajax_general') === 'on') {
                $script_path = '/assets/js/ajax.js';
                wp_enqueue_script(
                    'tache-ajax',
                    get_template_directory_uri() . $script_path,
                    array('jquery'),
                    filemtime(get_template_directory() . $script_path),
                    true
                );

                wp_localize_script('tache-ajax', 'tacheAjax', [
                    'ajaxurl' => admin_url('admin-ajax.php'),
                    'is_ajax_enabled' => true,
                ]);
            }
        }

        function t888f_track_product_views()
        {
            if (is_product()) {
                global $post;

                $views = get_post_meta($post->ID, 'product_view_count', true);
                $views = $views ? intval($views) : 0;

                if (!isset($_SESSION)) session_start();
                $key = 'viewed_' . $post->ID;
                if (empty($_SESSION[$key])) {
                    $_SESSION[$key] = true;
                    update_post_meta($post->ID, 'product_view_count', $views + 1);
                }
            }
        }

        function open_custom_add_user_actions()
        {
            echo '<div class="grouped-product-actions">';
        }

        function close_custom_add_user_actions()
        {
            t888f_get_template('woocommerce/single-product-structure/user-action', '', array(), true);
            echo '</div>';
        }

        function custom_add_wishlist_compare_buttons($product_id, $product = null): void
        {
            t888f_get_template(
                'woocommerce/single-product-structure/wishlist-compare',
                '',
                ['product_id' => (int) $product_id, 'product' => $product],
                true
            );
        }


        function custom_woocommerce_ordering()
        {
            if (! is_shop() && ! is_product_category()) {
                return;
            }

            $orderby_options = array(
                'menu_order' => esc_html__('Default sorting', 'nebon'),
                'popularity' => esc_html__('Sort by popularity', 'nebon'),
                'rating'     => esc_html__('Sort by average rating', 'nebon'),
                'date'       => esc_html__('Sort by latest', 'nebon'),
                'price'      => esc_html__('Sort by price: low to high', 'nebon'),
                'price-desc' => esc_html__('Sort by price: high to low', 'nebon'),
            );

            $current_orderby = isset($_GET['orderby']) ? wc_clean($_GET['orderby']) : 'date';
            t888f_get_template('woocommerce/shop-structure/order-filter', '', array(
                'orderby_options' => $orderby_options,
                'current_orderby' => $current_orderby
            ), true);
        }

        /**
         * Display related products on a single product page.
         *
         * This function outputs a placeholder HTML for related products.
         * The actual template rendering logic needs to be implemented.
         *
         * @return void
         */

        function t888f_show_single_product_data()
        {
            $show_latest     = get_theme_mod('show_latest_products', 'on');
            $show_upsell     = get_theme_mod('show_upsell_product_extra_display', 'on');
            $show_related    = get_theme_mod('show_related_products_extra_display', 'on');
            $number     = get_theme_mod('single_number_extra_display', '4');
            $size       = get_theme_mod('show_single_size_extra_display', '');
            $item_style   = get_theme_mod('single_item_style_extra_display', '');
            $attr = array(
                'show_latest'   => $show_latest,
                'show_upsell'   => $show_upsell,
                'show_related'  => $show_related,
                'number'        => $number,
                'size'          => $size,
                'item_style'    => $item_style
            );
            return $attr;
        }

        public function t888f_single_upsell_product()
        {
            if (get_theme_mod('show_upsell_product_extra_display', 'on') !== 'on') {
                return;
            }

            $attr = $this->t888f_show_single_product_data();
            t888f_get_template('woocommerce/single-product/upsell', get_post_format(), $attr, true);
        }

        public function t888f_single_lastest_product()
        {
            if (get_theme_mod('show_latest_products', 'on') !== 'on') {
                return;
            }

            $attr = $this->t888f_show_single_product_data();
            t888f_get_template('woocommerce/single-product/latest', get_post_format(), $attr, true);
        }

        public function t888f_single_related_product()
        {
            if (get_theme_mod('show_related_products_extra_display', 'on') !== 'on') {
                return;
            }

            t888f_get_template('woocommerce/single-product/related', get_post_format(), array(), true);
        }


        function short_des_list_product()
        {
            global $post;

            if (has_excerpt($post->ID)) {
                echo '<div class="product-short-description">';
                echo wp_trim_words(apply_filters('woocommerce_short_description', $post->post_excerpt), 8, '...');
                echo '</div>';
            }
        }

        function customize_woocommerce_review_form($args)
        {
            // Add placeholder for Name
            if (isset($args['fields']['author'])) {
                $args['fields']['author'] = str_replace(
                    '<input',
                    '<input placeholder="' . esc_attr__('Your Name*', 'nebon') . '"',
                    $args['fields']['author']
                );
            }

            // Add placeholder for Email
            if (isset($args['fields']['email'])) {
                $args['fields']['email'] = str_replace(
                    '<input',
                    '<input placeholder="' . esc_attr__('Your Email*', 'nebon') . '"',
                    $args['fields']['email']
                );
            }

            // Add placeholder for Review (textarea)
            if (isset($args['comment_field'])) {
                $args['comment_field'] = str_replace(
                    '<textarea',
                    '<textarea placeholder="' . esc_attr__('Your comment*', 'nebon') . '"',
                    $args['comment_field']
                );
            }

            return $args;
        }

        function t888f_viewing_question()
        {
            $views = get_post_meta(get_the_ID(), 'product_view_count', true);
            t888f_get_template('woocommerce/single-product-structure/viewing-question', '', array(
                'views' => $views ? intval($views) : 0
            ), true);
        }


        function t888f_image_safe_checkout()
        {
            $images_json = get_theme_mod('image_safe_checkout_repeater');

            $images = json_decode($images_json, true);

            if (!empty($images) && is_array($images)) {
                echo '<div class="guarantee-safe-checkout">';
                echo '<div class="guarantee-header">' . esc_html__('Guarantee Safe Checkout', 'nebon') . '</div>';
                echo '<div class="guarantee-logos">';

                foreach ($images as $image) {
                    if (!empty($image['image_only_url'])) {
                        echo '<img src="' . esc_url($image['image_only_url']) . '" alt="Guarantee Logo" class="extra-image">';
                    }
                }

                echo '</div></div>';
            }
        }

        function t888f_product_tabs()
        {
            // Show tab below cart
            woocommerce_output_product_data_tabs();
        }

        /**
         * Handle AJAX actions for WooCommerce.
         *
         * @return void
         */
        public function handle_ajax_action()
        {
            // Add to cart ajax
            add_action('wp_ajax_add_to_cart_ajax', [$this, 'add_to_cart_ajax']);
            add_action('wp_ajax_nopriv_add_to_cart_ajax', [$this, 'add_to_cart_ajax']);
            // Add multiple product to cart ajax
            add_action('wp_ajax_add_multi_product_to_cart_ajax', [$this, 'add_multi_product_to_cart_ajax']);
            add_action('wp_ajax_nopriv_add_multi_product_to_cart_ajax', [$this, 'add_multi_product_to_cart_ajax']);

            // Update mini cart ajax
            add_action('wp_ajax_update_mini_cart_ajax', [$this, 'update_mini_cart_ajax']);
            add_action('wp_ajax_nopriv_update_mini_cart_ajax', [$this, 'update_mini_cart_ajax']);
            // Remove product mini cart ajax
            add_action('wp_ajax_remove_product_mini_cart_ajax', [$this, 'remove_product_mini_cart_ajax']);
            add_action('wp_ajax_nopriv_remove_product_mini_cart_ajax', [$this, 'remove_product_mini_cart_ajax']);
            // product quickview -method nay can xu ly them vi co get_theme_mod toi option chua tao
            // Load More Product Tabs
            add_action('wp_ajax_t888_load_more_products', [$this, 'load_more_product_tabs']);
            add_action('wp_ajax_nopriv_t888_load_more_products', [$this, 'load_more_product_tabs']);
            // load more list product
            add_action('wp_ajax_t888_list_product_loadmore', [$this, 'list_product_loadmore']);
            add_action('wp_ajax_nopriv_t888_list_product_loadmore', [$this, 'list_product_loadmore']);
        }

        /**
         * Load more products for the list product.
         *
         * @return void
         */
        public function list_product_loadmore()
        {

            $paged = max(1, (int) ($_POST['paged'] ?? 1));
            $slug  = sanitize_text_field($_POST['slug'] ?? 'product');
            $style = sanitize_text_field($_POST['style'] ?? 'list');

            $template_view = ($style === 'grid')
                ? 'woocommerce/loop/grid/grid'
                : 'woocommerce/loop/list/list';

            $query_vars = [];
            if (!empty($_POST['query_vars'])) {
                $query_vars = json_decode(stripslashes((string) $_POST['query_vars']), true) ?: [];
            }

            $query_vars['no_found_rows'] = false;
            $query_vars['post_status']   = $query_vars['post_status'] ?? 'publish';
            $query_vars['paged'] = $paged;

            $query = new \WP_Query($query_vars);

            $html = t888f_get_template(
                'woocommerce/shop-structure/loadmore-products',
                '',
                [
                    'query'         => $query,
                    'template_view' => $template_view,
                    'style'         => $style,
                    'slug'          => $slug,
                ],
                false
            );

            wp_send_json_success([
                'html'       => $html,
                'max_pages'  => (int) $query->max_num_pages,
                'next_page'  => (int) $paged,
                'have_posts' => (bool) $query->have_posts(),
            ]);
        }


        /**
         * Load more products for the product tabs.
         *
         * @return void
         */
        public function load_more_product_tabs()
        {
            $paged          = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
            $filter_mode    = sanitize_text_field($_POST['filter_mode'] ?? 'categories');
            $product_filter = sanitize_text_field($_POST['product_filter'] ?? 'new');
            $product_limit  = intval($_POST['product_limit'] ?? 8);

            if ($filter_mode === 'products' && !empty($_POST['product_ids'])) {
                $product_ids = array_map('intval', $_POST['product_ids']);
                $offset = ($paged - 1) * $product_limit;
                $ids_to_show = array_slice($product_ids, $offset, $product_limit);

                $args = [
                    'post_type' => 'product',
                    'post__in' => $ids_to_show,
                    'orderby' => 'post__in',
                    'posts_per_page' => -1,
                ];
                $query = new \WP_Query($args);
            } else {
                // $categories = !empty($_POST['categories']) ? array_map('intval', $_POST['categories']) : [];
                // $query = t888_get_products_by_type($product_filter, $categories, $product_limit, $paged);
                if (!empty($_POST['categories'])) {
                    if (is_string($_POST['categories'])) {
                        // If it's a comma-separated string
                        if (strpos($_POST['categories'], ',') !== false) {
                            $categories = array_map('intval', explode(',', $_POST['categories']));
                        }
                        // If it's a JSON string
                        else if (strpos($_POST['categories'], '[') === 0) {
                            $categories = array_map('intval', json_decode(stripslashes($_POST['categories']), true) ?: []);
                        }
                        // If it's a single category ID
                        else {
                            $categories = [intval($_POST['categories'])];
                        }
                    }
                    // If it's already an array
                    else if (is_array($_POST['categories'])) {
                        $categories = array_map('intval', $_POST['categories']);
                    } else {
                        $categories = [];
                    }
                } else {
                    $categories = [];
                }

                $query = t888_get_products_by_type($product_filter, $categories, $product_limit, $paged);
            }

            $html = t888f_get_template('woocommerce/shop-structure/loadmore-products', '', [
                'query' => $query,
                'template_view' => 'woocommerce/loop/grid/grid',
                'style' => 'grid',
                // 'slug' => 'product'
            ], false);

            wp_send_json_success(['html' => $html]);
        }

        /**
         * Handle AJAX "Add to Cart" action.
         *
         * @return void
         */
        public function add_to_cart_ajax()
        {
            $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
            $quantity = empty($_POST['quantity']) ? 1 : apply_filters('woocommerce_stock_amount', $_POST['quantity']);
            $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);

            if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity)) {
                do_action('woocommerce_ajax_added_to_cart', $product_id);

                $ret = $this->get_custom_cart_fragments();
                $this->json_headers();
                echo json_encode(array(
                    "success" => true,
                    "data" => $ret,
                ));
            } else {
                $this->json_headers();
                $data = array(
                    'error' => true,
                    'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id)
                );
                echo json_encode($data);
            }
            die();
        }

        /**
         * Handle AJAX "Add Multiple Products to Cart" action.
         *
         * @return void
         */
        public function add_multi_product_to_cart_ajax()
        {
            $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
            if (isset($_POST['lst_upsale'])) {
                $lst_upsale = json_decode(stripslashes($_POST['lst_upsale']));
                if (is_array($lst_upsale)) {
                    foreach ($lst_upsale as $value) {
                        $quantity = 1;
                        $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $value->upsale_id, $quantity);
                        if ($passed_validation && WC()->cart->add_to_cart($value->upsale_id, $value->upsale_quantity, 0, array(), array('upsale_price' => $value->upsale_price, 'parent_product' => $product_id))) {
                            do_action('woocommerce_ajax_added_to_cart', $value->upsale_id);
                        }
                    }
                }
            }
            $quantity = empty($_POST['quantity']) ? 1 : apply_filters('woocommerce_stock_amount', $_POST['quantity']);
            $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);

            if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity)) {
                do_action('woocommerce_ajax_added_to_cart', $product_id);
                // \WC_AJAX::get_refreshed_fragments();
                $this->get_custom_cart_fragments();
            } else {
                // header application/json
                $this->json_headers();
                $data = array(
                    'error' => true,
                    'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id)
                );
                echo json_encode($data);
            }
            die();
        }

        /**
         * Handle AJAX "Update Mini Cart" action.
         *
         * @return void
         */
        public function update_mini_cart_ajax()
        {
            do_action('woocommerce_before_calculate_totals');
            \WC_AJAX::get_refreshed_fragments();
            die();
        }

        /**
         * Handle AJAX "Remove Product from Mini Cart" action.
         *
         * @return void
         */
        public function remove_product_mini_cart_ajax()
        {
            global $woocommerce;
            $cart_item_key = sanitize_text_field($_POST['cart_item_key']);
            if ($woocommerce->cart->get_cart_item($cart_item_key)) {
                $woocommerce->cart->remove_cart_item($cart_item_key);
            }
            $arr_item_key = json_decode(stripslashes($_POST['lst_item_key_child']));
            foreach ($arr_item_key as $value) {
                if ($woocommerce->cart->get_cart_item($value)) {
                    $woocommerce->cart->remove_cart_item($value);
                }
            }
            \WC_AJAX::get_refreshed_fragments();
            die();
        }



        /**
         * Render the single product upsell template.
         *
         * This method is intended to handle the rendering of upsell products
         * on a single product page. The actual logic needs to be implemented.
         *
         * @return void
         */
        public function t888f_woocommerce_template_single_upsale() {}

        /**
         * Add custom tabs to WooCommerce products.
         *
         * @param array $tabs Existing product tabs.
         * @return array Modified product tabs.
         */
        public function t888f_custom_product_tab($tabs)
        {
            $data_tabs = get_post_meta(get_the_ID(), 't888f_product_tab_data', true);
            if (!empty($data_tabs) and is_array($data_tabs)) {
                foreach ($data_tabs as $key => $data_tab) {
                    if (isset($data_tab['tab_content']) && $data_tab['tab_content'] != ' ') {
                        $tabs['t888f_custom_tab_' . $key] = array(
                            'title' => (!empty($data_tab['title']) ? $data_tab['title'] : $key),
                            'priority' => (!empty($data_tab['priority']) ? (int)$data_tab['priority'] : 50),
                            'callback' => 't888f_render_tab',
                            'content' => apply_filters('the_content', $data_tab['tab_content']) //this allows shortcodes in custom tabs
                        );
                    }
                }
            }
            return $tabs;
        }
        public function t888f_add_custom_tab($tabs)
        {
            global $post;
            if (!$post) return $tabs;

            $title    = get_post_meta($post->ID, 'add_custom_tab_title', true);
            $content  = get_post_meta($post->ID, 'add_custom_tab_content', true);
            $priority = intval(get_post_meta($post->ID, 'priority', true));

            if (!$priority) $priority = 50;

            if ($title && $content) {
                $tabs['custom_tab'] = [
                    'title'    => $title,
                    'priority' => $priority,
                    'callback' => function () use ($content) {
                        echo wpautop(do_shortcode($content));
                    }
                ];
            }

            return $tabs;
        }


        public function t888f_woocommerce_breadcrumb()
        {
            t888f_breadcrumb(' <i class="las la-angle-right step-breadcrumb"></i> ');
        }

        public function t888f_before_woocommerce_main_content()
        {
            // Add customize template action to before main content
            // add content before main section

            $append_content_before_shop = get_theme_mod('append_content_before_shop', null);
            if ($append_content_before_shop) {
                echo '<div class="shop-append-content-before">' . TemplateHelper::_get_elementor_content($append_content_before_shop) . '</div>';
            }
        }

        public function t888f_after_woocommerce_main_content()
        {
            // Add customize template action to after main content
            // add content after main section
            $append_content_after_shop = get_theme_mod('append_content_after_shop', null);
            if ($append_content_after_shop) {
                echo '<div class="shop-append-content-after">' . TemplateHelper::_get_elementor_content($append_content_after_shop) . '</div>';
            }
        }
        public function t888f_before_product_tab()
        {
            global $post;
            if (! $post) return;
            $meta_value = get_post_meta($post->ID, 'append_content_before_product_tab_custom', true);
            if (empty($meta_value) || $meta_value === 'choose_one' || $meta_value === '0') {
                $meta_value = get_theme_mod('append_content_before_product_tab', null);
            }
            if (!empty($meta_value) && $meta_value !== 'choose_one') {
                echo TemplateHelper::_get_elementor_content($meta_value);
            }
        }
        public function t888f_after_product_tab()
        {
            global $post;
            if (! $post) return;
            $meta_value = get_post_meta($post->ID, 'append_content_after_product_tab_custom', true);
            if (empty($meta_value) || $meta_value === 'choose_one' || $meta_value === '0') {
                $meta_value = get_theme_mod('append_content_after_product_tab', null);
            }
            if (!empty($meta_value) && $meta_value !== 'choose_one') {
                echo TemplateHelper::_get_elementor_content($meta_value);
            }
        }

        public function t888f_before_product_page()
        {
            if (!is_singular('product')) {
                return;
            }
            global $post;
            if (! $post) return;
            $meta_value = get_post_meta($post->ID, 'append_content_before_product_page_custom', true);
            if (empty($meta_value) || $meta_value === 'choose_one' || $meta_value === '0') {
                $meta_value = get_theme_mod('append_content_before_product_page', null);
            }
            if (!empty($meta_value) && $meta_value !== 'choose_one') {
                echo TemplateHelper::_get_elementor_content($meta_value);
            }
        }
        public function t888f_after_product_page()
        {
            if (!is_singular('product')) {
                return;
            }
            global $post;
            if (! $post) return;
            $meta_value = get_post_meta($post->ID, 'append_content_after_product_page_custom', true);
            if (empty($meta_value) || $meta_value === 'choose_one' || $meta_value === '0') {
                $meta_value = get_theme_mod('append_content_after_product_page', null);
            }
            if (!empty($meta_value) && $meta_value !== 'choose_one') {
                echo TemplateHelper::_get_elementor_content($meta_value);
            }
        }

        /**
         * Set JSON headers for AJAX responses.
         *
         * @return void
         */
        public function json_headers()
        {
            header('Content-Type: application/json; charset=utf-8');
        }

        function get_custom_cart_fragments()
        {
            ob_start();

            // Ví dụ: render lại icon cart hoặc số lượng
            woocommerce_mini_cart(); // hoặc template riêng

            $mini_cart_html = ob_get_clean();

            return [
                'fragments' => [
                    'div.widget_shopping_cart_content' => $mini_cart_html,
                ],
                'cart_hash' => WC()->cart->get_cart_hash(),
                'cart_count' => WC()->cart->get_cart_contents_count(),
            ];
        }

        public function loadMiniCart()
        {
            global $wpdb, $woocommerce;

            // \WC_AJAX::get_refreshed_fragments();
            $resp = $this->get_custom_cart_fragments();
            wp_send_json_success($resp);
        }

        public function remove_cart_item()
        {
            global $wpdb, $woocommerce;
            if (!isset($_POST['cart_item_key'])) {
                wp_send_json_error(['message' => __('Invalid request', 'nebon')]);
            }

            $cart_item_key = sanitize_text_field($_POST['cart_item_key']);
            $cart = WC()->cart;
            // Try to remove the item
            $removed = $cart->remove_cart_item($cart_item_key);

            if ($removed) {
                // Lấy fragment HTML mới để update giỏ hàng
                $resp = $this->get_custom_cart_fragments();
                wp_send_json_success($resp);
            } else {
                // Nếu không thành công, trả về thông báo lỗi
                wp_send_json_error(['message' => __('Failed to remove item from cart', 'nebon')]);
            }
        }

        public function update_cart_item_quantity()
        {
            global $woocommerce;

            if (!isset($_POST['cart_item_key']) || !isset($_POST['quantity'])) {
                wp_send_json_error(['message' => __('Invalid request', 'nebon')]);
            }

            $cart_item_key = sanitize_text_field($_POST['cart_item_key']);
            $quantity = intval($_POST['quantity']);

            if ($quantity < 0) {
                wp_send_json_error(['message' => __('Quantity cannot be negative', 'nebon')]);
            }

            // Update the cart item quantity
            $woocommerce->cart->set_quantity($cart_item_key, $quantity);

            // Get refreshed fragments
            $resp = $this->get_custom_cart_fragments();
            wp_send_json_success($resp);
        }

        public function get_login_nonce()
        {
            // Check if the user is logged in
            if (is_user_logged_in()) {
                wp_send_json_error(__('You are already logged in.', 'nebon'));
            }
            // Generate a nonce for the login form
            $nonce = wp_create_nonce('woocommerce-login');

            // Return the nonce as a JSON response
            wp_send_json_success(['nonce' => $nonce]);
        }

        public function do_login_woocommerce()
        {
            // Check if the user is already logged in
            if (is_user_logged_in()) {
                wp_send_json_error(__('You are already logged in.', 'nebon'));
            }

            // Verify the nonce
            if (!isset($_POST['woocommerce-login-nonce']) || !wp_verify_nonce($_POST['woocommerce-login-nonce'], 'woocommerce-login')) {
                wp_send_json_error(__('Invalid nonce.', 'nebon'));
            }

            // Get the login credentials
            $username = sanitize_text_field($_POST['username']);
            $password = sanitize_text_field($_POST['password']);

            // Attempt to log the user in
            $credentials = array(
                'user_login' => $username,
                'user_password' => $password,
                'remember' => true,
            );

            $user = wp_signon($credentials, false);

            if (is_wp_error($user)) {
                wp_send_json_error($user->get_error_message());
            } else {
                wp_send_json_success(__('Login successful.', 'nebon'));
            }
        }

        /**
         * Render the quickview content for a product.
         *
         * @return void
         */

        public function quick_view_product()
        {
            $product_id = absint($_POST['product_id']);
            $query = new \WP_Query(array(
                'post_type' => 'product',
                'post__in' => array($product_id)
            ));
            if (empty($style)) $style = '';
            if ($query->have_posts()):
                echo '<div class="woocommerce single-product product-popup-content ' . esc_attr($style) . '"><div class="product detail-product">';
                while ($query->have_posts()) : $query->the_post();

                    t888f_get_template('woocommerce/single-product/detail', $style, false, true);
                endwhile;
                echo '</div></div>';
            endif;
            wp_reset_postdata();
        }

        public function yith_wishlist_button($args = array())
        {
            $defaults = array(
                'text'       => '',
                'icon'       => '',
                'class'      => '',
                'echo'       => true,
                'product_id' => 0,
            );
            $args = wp_parse_args($args, $defaults);

            $pid = (int) $args['product_id'];
            if (! $pid) {
                global $product;
                if ($product instanceof WC_Product) {
                    $pid = (int) $product->get_id();
                } else {
                    $pid = (int) get_the_ID();
                }
            }

            $html = '';

            if (function_exists('yith_wcwl_is_product_in_wishlist')) {
                $in_wishlist = yith_wcwl_is_product_in_wishlist($pid);
                if ($in_wishlist) {
                    $args['text']  = $args['text'] ?: esc_html__('Added to Wishlist', 'nebon');
                    $args['icon']  = '<i class="la la-check" aria-hidden="true"></i>';
                    $args['class'] = trim($args['class'] . ' added');
                }
            }

            if (empty($args['text']))  $args['text']  = esc_html__('Wishlist', 'nebon');
            if (empty($args['icon']))  $args['icon']  = '<i class="lar la-heart" aria-hidden="true"></i>';
            if (empty($args['class'])) $args['class'] = 'yith-wcwl-add-to-wishlist-button';

            if (defined('YITH_WCWL') || function_exists('yith_wcwl_is_product_in_wishlist')) {
                $url  = esc_url(add_query_arg('add_to_wishlist', $pid));
                $html = sprintf(
                    '<a title="%s" href="%s" class="add_to_wishlist wishlist-link %s" rel="nofollow" data-product-id="%d" data-product-title="%s">%s</a>',
                    esc_attr($args['text']),
                    $url,
                    esc_attr($args['class']),
                    $pid,
                    esc_attr(get_the_title($pid)),
                    $args['icon']
                );
            }

            if (! empty($args['echo'])) {
                echo apply_filters('tech888f_output_content', $html);
                return;
            }
            return $html;
        }


        public function yith_compare_button($args = array())
        {
            $defaults = array(
                'text'       => '',
                'icon'       => '',
                'class'      => '',
                'product_id' => 0,
                'echo'       => true,
            );
            $args = wp_parse_args($args, $defaults);

            $pid = (int) $args['product_id'];
            if (! $pid) {
                global $product;
                if ($product instanceof WC_Product) {
                    $pid = (int) $product->get_id();
                } else {
                    $pid = (int) get_the_ID();
                }
            }

            if (class_exists('\YITH_WooCompare_Products_List')) {
                $in_compare = \YITH_WooCompare_Products_List::instance()->has($pid);
                if ($in_compare) {
                    $args['text']  = $args['text'] ?: esc_html__('Added to Compare', 'nebon');
                    $args['icon']  = '<i class="la la-check" aria-hidden="true"></i>';
                    $args['class'] = trim($args['class'] . ' added');
                }
            }

            if (empty($args['text']))  $args['text'] = esc_html__('Compare', 'nebon');
            if (empty($args['icon']))  $args['icon'] = '<i class="la la-refresh" aria-hidden="true"></i>';

            $html = '';

            if (class_exists('YITH_Woocompare')) {
                $cp_link = add_query_arg(
                    array(
                        'action' => 'yith-woocompare-add-product',
                        'id'     => $pid,
                    )
                );

                $html = sprintf(
                    '<div class="woocommerce product compare-button"><a title="%s" href="%s" class="compare button %s" data-product_id="%d">%s</a></div>',
                    esc_attr($args['text']),
                    esc_url($cp_link),
                    esc_attr($args['class']),
                    $pid,
                    $args['icon']
                );
            }

            if (!empty($args['echo'])) {
                echo apply_filters('tech888f_output_content', $html);
                return;
            }
            return $html;
        }


        // this function is used to handle AJAX search requests from t888-search-form elementor widget
        public function ajax_search()
        {

            $search_query = isset($_POST['s']) ? sanitize_text_field($_POST['s']) : '';
            $post_type = isset($_POST['post_type']) ? sanitize_text_field($_POST['post_type']) : 'post';
            $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';

            $shop_url = get_permalink(wc_get_page_id('shop'));
            // build param url from search query
            $param_url = add_query_arg([
                's' => $search_query,
                'post_type' => $post_type,
                'category' => $category,
            ], $shop_url);

            $args = [
                's' => $search_query,
                'post_type' => $post_type,
                'posts_per_page' => 10,
                'post_status' => 'publish',
            ];

            if (!empty($category)) {
                if ($post_type == 'post') {
                    $args['tax_query'] = [
                        [
                            'taxonomy' => 'category',
                            'field' => 'slug',
                            'terms' => $category,
                        ],
                    ];
                }
                if ($post_type == 'product') {
                    $args['tax_query'] = [
                        [
                            'taxonomy' => 'product_cat',
                            'field' => 'slug',
                            'terms' => $category,
                        ],
                    ];
                }
            }

            $query = new \WP_Query($args);

            // render view
            $html = tech888f_get_template_elementor_widget('t888-search-form-ajax', '', [
                'query' => $query,
                'post_type' => $post_type,
                'param_url' => $param_url,
            ], false);

            wp_send_json_success($html);
        }

        function t888_ajax_add_set_to_cart()
        {
            if (!isset($_POST['product_ids'])) {
                wp_send_json_error(__('Missing product list.', 'nebon'));
            }

            $product_ids = json_decode(stripslashes($_POST['product_ids']), true);

            if (!is_array($product_ids)) {
                wp_send_json_error(__('Invalid data format.', 'nebon'));
            }

            foreach ($product_ids as $product_id) {
                $product = wc_get_product($product_id);
                if ($product && $product->is_purchasable()) {
                    WC()->cart->add_to_cart($product_id, 1);
                }
            }

            // Refresh the cart fragments
            $fragments = $this->get_custom_cart_fragments();

            wp_send_json_success($fragments);
        }
    }

    WoocommerceHelper::instance();
}
