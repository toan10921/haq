<?php

namespace Elementor;

class T888_Shop_Product_Grid extends T888_Widget_Base
{
    public function get_name() { return 't888-shop-product-grid'; }
    public function get_title() { return __('Shop Product Grid', 'nebon'); }
    public function get_icon() { return 'eicon-products'; }
    public function get_categories() { return ['t888-elements']; }
    public function get_style_depends() { return ['elementor-t888-shop-product-grid']; }
    public function get_script_depends() { return ['elementor-t888-shop-product-grid']; }

    protected function is_dynamic_content(): bool
    {
        return true;
    }

    protected function register_controls()
    {
        $this->start_controls_section('query_section', ['label' => __('Products', 'nebon')]);
        $this->add_control('products_per_page', [
            'label' => __('Products Per Page', 'nebon'), 'type' => Controls_Manager::NUMBER,
            'default' => 9, 'min' => 1, 'max' => 100,
        ]);
        $this->add_responsive_control('columns', [
            'label' => __('Columns', 'nebon'), 'type' => Controls_Manager::SELECT,
            'default' => '3', 'tablet_default' => '2', 'mobile_default' => '2',
            'options' => ['1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6'],
            'selectors' => ['{{WRAPPER}} .t888-shop-grid' => '--t888-shop-columns: {{VALUE}};'],
        ]);
        $this->add_control('categories', [
            'label' => __('Limit to Categories', 'nebon'), 'type' => Controls_Manager::SELECT2,
            'multiple' => true, 'label_block' => true, 'options' => $this->category_options(),
        ]);
        $this->add_control('show_category_filter', [
            'label' => __('Show Category Filter', 'nebon'), 'type' => Controls_Manager::SWITCHER,
            'default' => '', 'return_value' => 'yes',
        ]);
        $this->add_control('all_categories_label', [
            'label' => __('All Categories Label', 'nebon'), 'type' => Controls_Manager::TEXT,
            'default' => __('Tất cả', 'nebon'), 'condition' => ['show_category_filter' => 'yes'],
        ]);
        $this->add_control('default_orderby', [
            'label' => __('Default Sorting', 'nebon'), 'type' => Controls_Manager::SELECT, 'default' => 'menu_order',
            'options' => [
                'menu_order' => __('Default sorting', 'nebon'), 'date' => __('Latest', 'nebon'),
                'popularity' => __('Popularity', 'nebon'), 'rating' => __('Rating', 'nebon'),
                'price' => __('Price: low to high', 'nebon'), 'price-desc' => __('Price: high to low', 'nebon'),
            ],
        ]);
        $this->add_control('show_sale_badge', [
            'label' => __('Show Sale Badge', 'nebon'), 'type' => Controls_Manager::SWITCHER,
            'default' => 'yes', 'return_value' => 'yes',
        ]);
        $this->add_control('show_contact_button', [
            'label' => __('Show Contact Button on Hover', 'nebon'), 'type' => Controls_Manager::SWITCHER,
            'default' => 'yes', 'return_value' => 'yes',
        ]);
        $this->add_control('contact_button_text', [
            'label' => __('Contact Button Label', 'nebon'), 'type' => Controls_Manager::TEXT,
            'default' => __('Liên hệ', 'nebon'), 'condition' => ['show_contact_button' => 'yes'],
        ]);
        $this->add_control('contact_button_link', [
            'label' => __('Contact Button Link', 'nebon'), 'type' => Controls_Manager::URL,
            'default' => ['url' => '#'], 'placeholder' => 'https://example.com/contact',
            'options' => ['url', 'is_external', 'nofollow'], 'label_block' => true,
            'condition' => ['show_contact_button' => 'yes'],
        ]);
        $this->add_control('show_pagination', [
            'label' => __('Show Pagination', 'nebon'), 'type' => Controls_Manager::SWITCHER,
            'default' => 'yes', 'return_value' => 'yes',
        ]);
        $this->add_control('empty_text', [
            'label' => __('Empty Message', 'nebon'), 'type' => Controls_Manager::TEXT,
            'default' => __('No products were found matching your selection.', 'nebon'), 'label_block' => true,
        ]);
        $this->end_controls_section();

        $this->start_controls_section('category_filter_style', [
            'label' => __('Category Filter', 'nebon'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => ['show_category_filter' => 'yes'],
        ]);
        $this->add_control('category_filter_background', [
            'label' => __('Background', 'nebon'), 'type' => Controls_Manager::COLOR, 'default' => '#f4f4f4',
            'selectors' => ['{{WRAPPER}} .t888-shop-categories' => 'background-color: {{VALUE}};'],
        ]);
        $this->add_control('category_filter_text_color', [
            'label' => __('Text Color', 'nebon'), 'type' => Controls_Manager::COLOR, 'default' => '#111111',
            'selectors' => ['{{WRAPPER}} .t888-shop-categories__link' => 'color: {{VALUE}};'],
        ]);
        $this->add_control('category_filter_active_color', [
            'label' => __('Active Color', 'nebon'), 'type' => Controls_Manager::COLOR, 'default' => '#ea5501',
            'selectors' => [
                '{{WRAPPER}} .t888-shop-categories__link:hover' => 'color: {{VALUE}};',
                '{{WRAPPER}} .t888-shop-categories__link.is-active' => 'color: {{VALUE}};',
                '{{WRAPPER}} .t888-shop-categories__link.is-active::before' => 'background-color: {{VALUE}};',
            ],
        ]);
        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'category_filter_typography',
            'selector' => '{{WRAPPER}} .t888-shop-categories__link',
        ]);
        $this->add_responsive_control('category_filter_gap', [
            'label' => __('Item Gap', 'nebon'), 'type' => Controls_Manager::SLIDER,
            'range' => ['px' => ['min' => 0, 'max' => 80]],
            'default' => ['unit' => 'px', 'size' => 30],
            'selectors' => ['{{WRAPPER}} .t888-shop-categories__list' => 'gap: {{SIZE}}{{UNIT}};'],
        ]);
        $this->end_controls_section();

        $this->start_controls_section('grid_style', ['label' => __('Grid', 'nebon'), 'tab' => Controls_Manager::TAB_STYLE]);
        $this->add_responsive_control('column_gap', [
            'label' => __('Column Gap', 'nebon'), 'type' => Controls_Manager::SLIDER,
            'range' => ['px' => ['min' => 0, 'max' => 80]], 'default' => ['unit' => 'px', 'size' => 24],
            'selectors' => ['{{WRAPPER}} .t888-shop-grid' => 'column-gap: {{SIZE}}{{UNIT}};'],
        ]);
        $this->add_responsive_control('row_gap', [
            'label' => __('Row Gap', 'nebon'), 'type' => Controls_Manager::SLIDER,
            'range' => ['px' => ['min' => 0, 'max' => 80]], 'default' => ['unit' => 'px', 'size' => 32],
            'selectors' => ['{{WRAPPER}} .t888-shop-grid' => 'row-gap: {{SIZE}}{{UNIT}};'],
        ]);
        $this->add_control('image_background', [
            'label' => __('Image Background', 'nebon'), 'type' => Controls_Manager::COLOR, 'default' => '#f3f7fb',
            'selectors' => ['{{WRAPPER}} .t888-shop-card__image' => 'background-color: {{VALUE}};'],
        ]);
        $this->add_control('image_ratio', [
            'label' => __('Image Ratio', 'nebon'), 'type' => Controls_Manager::SELECT, 'default' => '1 / 1',
            'options' => ['1 / 1' => __('Square', 'nebon'), '4 / 5' => __('Portrait', 'nebon'), '4 / 3' => __('Landscape', 'nebon')],
            'selectors' => ['{{WRAPPER}} .t888-shop-card__image' => 'aspect-ratio: {{VALUE}};'],
        ]);
        $this->end_controls_section();

        $this->start_controls_section('product_style', ['label' => __('Product Content', 'nebon'), 'tab' => Controls_Manager::TAB_STYLE]);
        $this->add_control('title_color', [
            'label' => __('Title Color', 'nebon'), 'type' => Controls_Manager::COLOR, 'default' => '#111111',
            'selectors' => ['{{WRAPPER}} .t888-shop-card__title' => 'color: {{VALUE}};'],
        ]);
        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'title_typography', 'selector' => '{{WRAPPER}} .t888-shop-card__title',
        ]);
        $this->add_control('price_color', [
            'label' => __('Price Color', 'nebon'), 'type' => Controls_Manager::COLOR, 'default' => '#252525',
            'selectors' => ['{{WRAPPER}} .t888-shop-card__price' => 'color: {{VALUE}};'],
        ]);
        $this->add_control('accent_color', [
            'label' => __('Accent Color', 'nebon'), 'type' => Controls_Manager::COLOR, 'default' => '#EA5501',
            'selectors' => [
                '{{WRAPPER}} .t888-shop-card__sale' => 'background-color: {{VALUE}};',
                '{{WRAPPER}} .t888-shop-pagination .current' => 'color: {{VALUE}};',
                '{{WRAPPER}} .t888-shop-card__contact:hover' => 'background-color: {{VALUE}};',
            ],
        ]);
        $this->add_control('contact_button_background', [
            'label' => __('Contact Button Background', 'nebon'), 'type' => Controls_Manager::COLOR, 'default' => '#1f1f1f',
            'selectors' => ['{{WRAPPER}} .t888-shop-card__contact' => 'background-color: {{VALUE}};'],
        ]);
        $this->add_control('contact_button_text_color', [
            'label' => __('Contact Button Text Color', 'nebon'), 'type' => Controls_Manager::COLOR, 'default' => '#ffffff',
            'selectors' => ['{{WRAPPER}} .t888-shop-card__contact' => 'color: {{VALUE}};'],
        ]);
        $this->end_controls_section();
    }

    private function category_options()
    {
        $options = [];
        if (!taxonomy_exists('product_cat')) return $options;
        $terms = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false]);
        if (!is_wp_error($terms)) foreach ($terms as $term) $options[$term->term_id] = $term->name;
        return $options;
    }

    private function filter_categories($settings)
    {
        if (empty($settings['show_category_filter']) || $settings['show_category_filter'] !== 'yes') return [];

        $args = [
            'taxonomy' => 'product_cat',
            'hide_empty' => true,
            'orderby' => 'name',
            'order' => 'ASC',
        ];
        $selected_categories = array_values(array_filter(array_map('absint', (array) ($settings['categories'] ?? []))));
        if ($selected_categories) $args['include'] = $selected_categories;

        $terms = get_terms($args);
        return is_wp_error($terms) ? [] : $terms;
    }

    private function build_query($settings)
    {
        $per_page = max(1, (int) ($settings['products_per_page'] ?? 9));
        $paged = max(1, (int) get_query_var('paged'), isset($_GET['product-page']) ? (int) $_GET['product-page'] : 1);
        $orderby = isset($_GET['orderby']) ? sanitize_key(wp_unslash($_GET['orderby'])) : ($settings['default_orderby'] ?? 'menu_order');
        $args = [
            'post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => $per_page,
            'paged' => $paged, 'ignore_sticky_posts' => true,
        ];

        $product_name_search = !empty($_GET['product_search'])
            ? sanitize_text_field(wp_unslash($_GET['product_search']))
            : (!empty($_GET['s']) ? sanitize_text_field(wp_unslash($_GET['s'])) : '');
        if ($product_name_search !== '') $args['t888_product_name_search'] = $product_name_search;
        $tax_query = [];
        $selected_categories = array_values(array_filter(array_map('absint', (array) ($settings['categories'] ?? []))));
        if ($selected_categories) {
            $tax_query[] = ['taxonomy' => 'product_cat', 'field' => 'term_id', 'terms' => $selected_categories];
        }
        if (!empty($_GET['product_cat'])) {
            $requested_category_slug = sanitize_title(wp_unslash($_GET['product_cat']));
            $requested_category = get_term_by('slug', $requested_category_slug, 'product_cat');

            // Resolve the slug first and query by term ID. This avoids the
            // product_cat query var from the Elementor preview/main query
            // leaking into or overriding this secondary product query.
            if ($requested_category instanceof \WP_Term) {
                $tax_query[] = [
                    'taxonomy'         => 'product_cat',
                    'field'            => 'term_id',
                    'terms'            => [(int) $requested_category->term_id],
                    'operator'         => 'IN',
                    'include_children' => true,
                ];
            } else {
                $args['post__in'] = [0];
            }
        } elseif (is_tax('product_cat')) {
            $term = get_queried_object();
            if ($term instanceof \WP_Term) $tax_query[] = ['taxonomy' => 'product_cat', 'field' => 'term_id', 'terms' => [$term->term_id]];
        }
        if (function_exists('wc_get_product_visibility_term_ids')) {
            $visibility = wc_get_product_visibility_term_ids();
            if (!empty($visibility['exclude-from-catalog'])) {
                $tax_query[] = ['taxonomy' => 'product_visibility', 'field' => 'term_taxonomy_id', 'terms' => [$visibility['exclude-from-catalog']], 'operator' => 'NOT IN'];
            }
        }
        if ($tax_query) $args['tax_query'] = array_merge(['relation' => 'AND'], $tax_query);

        $meta_query = [];
        $min_price = isset($_GET['min_price']) && $_GET['min_price'] !== '' ? (float) wp_unslash($_GET['min_price']) : null;
        $max_price = isset($_GET['max_price']) && $_GET['max_price'] !== '' ? (float) wp_unslash($_GET['max_price']) : null;
        if ($min_price !== null || $max_price !== null) {
            $meta_query[] = ['key' => '_price', 'value' => [$min_price ?? 0, $max_price ?? PHP_INT_MAX], 'compare' => 'BETWEEN', 'type' => 'DECIMAL(10,2)'];
        }
        if ($meta_query) $args['meta_query'] = $meta_query;

        switch ($orderby) {
            case 'price': $args += ['meta_key' => '_price', 'orderby' => 'meta_value_num', 'order' => 'ASC']; break;
            case 'price-desc': $args += ['meta_key' => '_price', 'orderby' => 'meta_value_num', 'order' => 'DESC']; break;
            case 'popularity': $args += ['meta_key' => 'total_sales', 'orderby' => 'meta_value_num', 'order' => 'DESC']; break;
            case 'rating': $args += ['meta_key' => '_wc_average_rating', 'orderby' => 'meta_value_num', 'order' => 'DESC']; break;
            case 'date': $args += ['orderby' => 'date', 'order' => 'DESC']; break;
            default: $args += ['orderby' => ['menu_order' => 'ASC', 'title' => 'ASC']];
        }
        $search_by_product_name = static function ($where, $query) {
            $keyword = trim((string) $query->get('t888_product_name_search'));
            if ($keyword === '') return $where;

            global $wpdb;
            $like = '%' . $wpdb->esc_like($keyword) . '%';
            return $where . $wpdb->prepare(
                " AND {$wpdb->posts}.post_title LIKE %s",
                $like
            );
        };

        add_filter('posts_where', $search_by_product_name, 10, 2);
        try {
            return new \WP_Query($args);
        } finally {
            remove_filter('posts_where', $search_by_product_name, 10);
        }
    }

    protected function render()
    {
        parent::render();
        $settings = $this->get_settings_for_display();
        if (!function_exists('wc_get_product')) {
            if (current_user_can('edit_theme_options')) echo '<p>' . esc_html__('WooCommerce must be active to display this widget.', 'nebon') . '</p>';
            return;
        }
        $settings['query'] = $this->build_query($settings);
        $settings['current_page'] = max(1, (int) get_query_var('paged'), isset($_GET['product-page']) ? (int) $_GET['product-page'] : 1);
        $settings['filter_categories'] = $this->filter_categories($settings);
        $settings['active_category_slug'] = !empty($_GET['product_cat'])
            ? sanitize_title(wp_unslash($_GET['product_cat']))
            : '';
        if ($settings['active_category_slug'] === '' && is_tax('product_cat')) {
            $active_term = get_queried_object();
            if ($active_term instanceof \WP_Term) $settings['active_category_slug'] = $active_term->slug;
        }
        tech888f_get_template_elementor_widget('t888-shop-product-grid', false, $settings, true);
    }
}
