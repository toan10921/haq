<?php

/**
 * Created by khangtrinh.
 * User: khangtrinh
 * Date: 13/06/2024
 * Time: 04:20 PM
 */

namespace Elementor;

// if (!defined('ABSPATH')) {
//     exit; // Exit if accessed directly
// }

class T888_List_Product extends T888_Widget_Base
{
    use \T888Core\ShopProductTrait;
    /**
     * Get widget name.
     */
    public function get_name()
    {
        return 't888-list-product';
    }

    /**
     * Get widget title.
     */
    public function get_title()
    {
        return __('List Product', 'nebon');
    }

    /**
     * Get widget icon.
     */
    public function get_icon()
    {
        return 'eicon-products';
    }
    /**
     * Add script depends.
     *
     * Register new script to enqueue by the handler.
     *
     * @since 1.9.0
     * @access public
     *
     * @param string $handler Depend script handler.
     */
    public function get_script_depends()
    {
        return [];
    }

    /**
     * Add style depends.
     *
     * Register new style to enqueue by the handler.
     *
     * @since 1.9.0
     * @access public
     *
     * @param string $handler Depend style handler.
     */
    public function get_style_depends()
    {
        return [];
    }

    public function enque_scripts()
    {
        parent::enque_scripts();

        wp_localize_script('elementor-t888-list-product', 't888_ajax_object ', [
            'ajax_url' => admin_url('admin-ajax.php'),
        ]);
    }
    /**
     * Get widget categories.
     */
    public function get_categories()
    {
        return ['t888-elements'];
    }

   public function get_product_order_by()
    {
    return [
        'menu_order' => __('Sắp xếp mặc định', 'nebon'),
        'popularity' => __('Theo độ phổ biến', 'nebon'),
        'rating'     => __('Theo đánh giá trung bình', 'nebon'),
        'date'       => __('Sản phẩm mới nhất', 'nebon'),
        'price'      => __('Giá từ thấp đến cao', 'nebon'),
        'price-desc' => __('Giá từ cao đến thấp', 'nebon'),
    ];
    }

    /**
     * Register controls.
     */
    protected function _register_controls()
    {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('List Product', 'nebon'),
            ]
        );

        $this->add_control(
            'show_number_filter',
            [
                'label' => __('Show Number Filter', 'nebon'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'on',
                'label_on' => __('On', 'nebon'),
                'label_off' => __('Off', 'nebon'),
            ]
        );

        $this->add_control(
            'show_type_filter',
            [
                'label' => __('Show Type Filter', 'nebon'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'on',
                'label_on' => __('On', 'nebon'),
                'label_off' => __('Off', 'nebon'),
            ]
        );

        $this->add_control(
            'show_custom_ordering_dropdown',
            [
                'label' => __('Show Custom Ordering Dropdown', 'nebon'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'on',
                'label_on' => __('On', 'nebon'),
                'label_off' => __('Off', 'nebon'),
            ]
        );

        $this->add_control(
            'style',
            [
                'label' => __('Style', 'nebon'),
                'type' => Controls_Manager::SELECT,
                'options' => $this->get_list_products_styles(),
            ]
        );

        $this->add_control(
            'item_grid_style',
            [
                'label' => __('Item Grid Style', 'nebon'),
                'type' => Controls_Manager::SELECT,
                'default' => 'style1',
                'options' => [
                    'style1' => __('Default', 'nebon'),
                    // 'style2' => __('Style 2', 'nebon'),
                ],
                'condition' => [
                    'style' => 'grid',
                ],
            ]
        );
        $this->add_control(
            'thumb_animation',
            [
                'label' => __('Thumbnail Animation', 'nebon'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'default-grid-thumb',
                'options' => $this->get_product_thumb_animation(),
                'condition' => [
                    'style' => 'grid',
                ],
            ]
        );

        $this->add_control(
            'item_list_style',
            [
                'label' => __('Item List Style', 'nebon'),
                'type' => Controls_Manager::SELECT,
                'default' => 'style1',
                'options' => [
                    'style1' => __('Default', 'nebon'),
                    'style2' => __('Style 2 - Homepage 4 Box 4', 'nebon'),
                ],
                'condition' => [
                    'style' => 'list',
                ],
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label' => __('Number of Product', 'nebon'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 50,
                'default' => 4,
            ]
        );

        $this->add_control(
            'product_categories',
            [
                'label' => __('Select Categories', 'nebon'),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->get_categories_options(),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'order_by',
            [
                'label' => __('Order By', 'nebon'),
                'type' => Controls_Manager::SELECT,
                'default' => 'date',
                'options' => $this->get_product_order_by(),
            ]
        );

        $this->add_control(
            'gap',
            [
                'label' => __('Gaps', 'nebon'),
                'type' => Controls_Manager::SELECT,
                'default' => '30',
                'options' => [
                    '10' => __('10px', 'nebon'),
                    '20' => __('20px', 'nebon'),
                    '30' => __('30px', 'nebon'),
                    '40' => __('40px', 'nebon'),
                ],

            ]
        );

        $this->add_control(
            'columns',
            [
                'label' => __('Columns (for Grid Style)', 'nebon'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '3',
                'options' => [
                    // '1' => __('1 Column', 'nebon'),
                    '2' => __('2 Columns', 'nebon'),
                    '3' => __('3 Columns', 'nebon'),
                    '4' => __('4 Columns', 'nebon'),
                    '5' => __('5 Columns', 'nebon'),
                ],
                'condition' => [
                    'style' => 'grid',
                ],
            ]
        );

        $this->add_control(
            'pagination_type',
            [
                'label' => __('Pagination Type', 'nebon'),
                'type' => Controls_Manager::SELECT,
                'default' => 'pagination',
                'options' => [
                    'pagination' => __('Pagination', 'nebon'),
                    'loadmore'   => __('Load More', 'nebon'),
                ],
            ]
        );


        $this->end_controls_section();
    }

    private function get_categories_options()
    {
        $terms = get_terms([
            'taxonomy' => 'product_cat',
            'hide_empty' => false,
        ]);

        $options = [];
        if (!is_wp_error($terms)) {
            foreach ($terms as $term) {
                $options[$term->term_id] = $term->name;
            }
        }
        return $options;
    }

    public function get_args_query($posts_per_page = 12)
    {
        $order = $order ?? 'DESC';
        $order_by = isset($_GET['orderby'])
            ? sanitize_text_field($_GET['orderby'])
            : ($order_by ?? 'date');


        $categories = $product_categories ?? [];
        $style = $style ?? ($settings['style'] ?? 'list');
        $gap = $gap ?? ($settings['gap'] ?? '30');
        $slug = $slug ?? 'product';
        $paged = get_query_var('paged') ?: 1;
        $default_columns = $columns ?? '3';
        $columns = isset($_GET['view']) && $_GET['view'] === 'grid' ? $default_columns : '';
        $pagination_type = $pagination_type ?? 'pagination';
        $args = [
            'post_type' => 'product',
            'posts_per_page' => $posts_per_page,
            'orderby' => $order_by,
            'order' => $order,
            'paged' => $paged,
        ];

        if (isset($_GET['s']) && !empty($_GET['s'])) {
            $search_query = sanitize_text_field($_GET['s']);
            $args['s'] = $search_query;
        }

        if (!empty($_GET['product_search']) && is_scalar($_GET['product_search'])) {
            $args['t888_main_product_name_search'] = sanitize_text_field(
                wp_unslash((string) $_GET['product_search'])
            );
        }

        $min_price_val = isset($_GET['min_price']) ? floatval($_GET['min_price']) : null;
        $max_price_val = isset($_GET['max_price']) ? floatval($_GET['max_price']) : null;

        if ($min_price_val !== null || $max_price_val !== null) {
            $price_query = [
                'key'     => '_price',
                'type'    => 'NUMERIC',
                'compare' => 'BETWEEN',
                'value'   => [
                    $min_price_val ?? 0,
                    $max_price_val ?? 999999,
                ],
            ];

            if (!isset($args['meta_query'])) {
                $args['meta_query'] = [];
            }

            $args['meta_query'][] = $price_query;
        }

        switch ($order_by) {
            case 'price':
                $args['meta_key'] = '_price';
                $args['orderby'] = 'meta_value_num';
                $args['order'] = 'ASC';
                break;

            case 'price-desc':
                $args['meta_key'] = '_price';
                $args['orderby'] = 'meta_value_num';
                $args['order'] = 'DESC';
                break;

            case 'popularity':
                $args['meta_key'] = 'total_sales';
                $args['orderby'] = 'meta_value_num';
                $args['order'] = 'DESC';
                break;

            case 'rating':
                $args['meta_key'] = '_wc_average_rating';
                $args['orderby'] = 'meta_value_num';
                $args['order'] = 'DESC';
                break;

            case 'rand':
                $args['orderby'] = 'rand';
                break;

            case 'title':
                $args['orderby'] = 'title';
                $args['order'] = 'ASC';
                break;

            case 'menu_order':
                $args['orderby'] = 'menu_order title';
                $args['order'] = 'ASC';
                break;

            case 'date':
            default:
                $args['orderby'] = 'date';
                $args['order'] = 'DESC';
                break;
        }

        $tax_query = [];

        if (!empty($_GET['product_cat'])) {
            $requested_categories = wp_unslash($_GET['product_cat']);
            $category_slugs = is_string($requested_categories)
                ? array_values(array_filter(array_map('sanitize_title', explode(',', $requested_categories))))
                : [];

            if (!empty($category_slugs)) {
                $tax_query[] = [
                    'taxonomy'         => 'product_cat',
                    'field'            => 'slug',
                    'terms'            => $category_slugs,
                    'operator'         => 'IN',
                    'include_children' => true,
                ];
            }
        }

        if (!empty($categories)) {
            $tax_query[] = [
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => $categories,
            ];
        }

        if (!empty($_GET['brand'])) {
            $brand_slugs = explode(',', sanitize_text_field($_GET['brand']));
            $tax_query[] = [
                'taxonomy' => 'product_brand',
                'field'    => 'slug',
                'terms'    => $brand_slugs,
                'operator' => 'IN',
            ];
        }

        foreach ($_GET as $key => $value) {
            if (strpos($key, 'pa_') === 0 && !empty($value)) {
                $terms = explode(',', sanitize_text_field($value));
                $tax_query[] = [
                    'taxonomy' => $key,
                    'field'    => 'slug',
                    'terms'    => $terms,
                    'operator' => 'IN',
                ];
            }
        }

        if (!empty($tax_query)) {
            $args['tax_query'] = $tax_query;
        }

        return $args;
    }

    public function get_list_products_query($posts_per_page = 12)
    {
        $args = $this->get_args_query($posts_per_page);
        $query = new \WP_Query($args);
        return $query;
    }

    public function get_per_page_options()
    {
        return [9, 12, 18, 24];
    }

    /**
     * Render widget output on the frontend.
     */
    protected function render()
    {
        parent::render();
        $settings = $this->get_settings_for_display();
        $style = isset($settings['style']) ? $settings['style'] : 'style1';
        $posts_per_page = isset($_GET['posts_per_page']) && is_numeric($_GET['posts_per_page'])
            ? intval($_GET['posts_per_page'])
            : max(1, intval($settings['posts_per_page'] ?? 12));

        // Shop and product taxonomy pages already have a WooCommerce main
        // query containing the current category/tag/filter context. Reusing it
        // keeps the product loop, result count and pagination in sync. Normal
        // pages and Elementor previews still use the widget's own query.
        $use_archive_query = (
            (function_exists('is_shop') && is_shop())
            || (function_exists('is_product_taxonomy') && is_product_taxonomy())
        ) && isset($GLOBALS['wp_query']) && $GLOBALS['wp_query'] instanceof \WP_Query;

        if ($use_archive_query) {
            // Clone the populated query so rendering this Elementor widget does
            // not consume the global loop before wp_head() or another plugin
            // needs the archive context.
            $query = clone $GLOBALS['wp_query'];
            $archive_per_page = (int) $query->get('posts_per_page');
            if ($archive_per_page > 0) {
                $posts_per_page = $archive_per_page;
            }
        } else {
            $query = $this->get_list_products_query($posts_per_page);
        }

        $settings['posts_per_page'] = $posts_per_page;
        $settings['query'] = $query;
        $per_page_options = $this->get_per_page_options();
        $settings['per_page_options'] = $per_page_options;
        $orderby_options = $this->get_product_order_by();
        $settings['orderby_options'] = $orderby_options;
        $view = isset($_GET['view']) ? sanitize_text_field($_GET['view']) : ($settings['style'] == 'list' ? 'list' : 'grid');
        $settings['view'] = $view;
        $template_view = $view === 'list' ? 'woocommerce/loop/list/list' : 'woocommerce/loop/grid/grid';
        $settings['template_view'] = $template_view;
        $layout_styles = [
            'grid' => 'las la-grip-horizontal',
            'list' => 'las la-list'
        ];
        $settings['layout_styles'] = $layout_styles;
        $animation_class = $settings['thumb_animation'] ?? 'default-grid-thumb';
        $settings['animation_class'] = $animation_class;
        $paged = max(1, (int) $query->get('paged'), (int) get_query_var('paged'));
        $total = (int) $query->found_posts;
        $start = $total > 0 ? (($paged - 1) * $posts_per_page) + 1 : 0;
        $end = min($start + $posts_per_page - 1, $total);
        $current_orderby = isset($_GET['orderby']) ? sanitize_text_field($_GET['orderby']) : $settings['order_by'] ?? 'date';
        $settings['paged'] = $paged;
        $show_number_filter = $settings['show_number_filter'] === 'yes' ? 'on' : 'off';
        $show_type_filter = $settings['show_type_filter'] === 'yes' ? 'on' : 'off';
        $show_custom_ordering_dropdown = $settings['show_custom_ordering_dropdown'] === 'yes' ? 'on' : 'off';
        // top filter arguments
        $args_filter = [
            'style' => $style,
            'posts_per_page' => $posts_per_page,
            'show_number_filter' => $show_number_filter,
            'show_type_filter' => $show_type_filter,
            'show_custom_ordering_dropdown' => $show_custom_ordering_dropdown,
            'current_url' => get_current_url(),
            'layout_styles' => $layout_styles,
            'per_page_options' => $per_page_options,
            'paged' => $paged,
            'total' => $total,
            'start' => $start,
            'end' => $end,
            'current_orderby' => $current_orderby ?? 'date',
            'orderby_options' => $orderby_options,
        ];

        $settings['args'] = $use_archive_query
            ? $query->query_vars
            : $this->get_args_query($posts_per_page);
        $custom_classes = preg_split('/\s+/', trim((string) ($settings['_css_classes'] ?? '')));
        $settings['use_shop_card'] = in_array('listsp', $custom_classes, true);


        // only render top filter if there are products to display
        if ($query->have_posts()) {
            t888f_get_template("layout/top-filter", '', $args_filter, true);
        }

        tech888f_get_template_elementor_widget('t888-list-product', '', $settings, true);
    }
}
