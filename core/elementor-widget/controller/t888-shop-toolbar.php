<?php

namespace Elementor;

class T888_Shop_Toolbar extends T888_Widget_Base
{
    public function get_name() { return 't888-shop-toolbar'; }
    public function get_title() { return __('Shop Toolbar', 'nebon'); }
    public function get_icon() { return 'eicon-filter'; }
    public function get_categories() { return ['t888-elements']; }

    protected function is_dynamic_content(): bool
    {
        return true;
    }

    protected function register_controls()
    {
        $this->start_controls_section('content', ['label' => __('Content', 'nebon')]);
        $this->add_control('show_result', [
            'label' => __('Show Result Count', 'nebon'), 'type' => Controls_Manager::SWITCHER,
            'default' => 'yes', 'return_value' => 'yes',
        ]);
        $this->add_control('show_sorting', [
            'label' => __('Show Sorting', 'nebon'), 'type' => Controls_Manager::SWITCHER,
            'default' => 'yes', 'return_value' => 'yes',
        ]);
        $this->add_control('products_per_page', [
            'label' => __('Products Per Page', 'nebon'), 'type' => Controls_Manager::NUMBER,
            'default' => 9, 'min' => 1, 'max' => 100,
        ]);
        $this->add_control('categories', [
            'label' => __('Count Categories', 'nebon'), 'type' => Controls_Manager::SELECT2,
            'multiple' => true, 'label_block' => true, 'options' => $this->category_options(),
            'description' => __('Use the same categories selected in the Product Grid when building a custom shop page.', 'nebon'),
        ]);
        $this->end_controls_section();

        $this->start_controls_section('style_box', ['label' => __('Style', 'nebon'), 'tab' => Controls_Manager::TAB_STYLE]);
        $this->add_control('text_color', [
            'label' => __('Text Color', 'nebon'), 'type' => Controls_Manager::COLOR, 'default' => '#4b4b4b',
            'selectors' => ['{{WRAPPER}} .t888-shop-toolbar' => 'color: {{VALUE}};'],
        ]);
        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'typography', 'selector' => '{{WRAPPER}} .t888-shop-toolbar',
        ]);
        $this->add_control('field_border', [
            'label' => __('Select Border Color', 'nebon'), 'type' => Controls_Manager::COLOR, 'default' => '#e4e4e4',
            'selectors' => ['{{WRAPPER}} .t888-shop-toolbar__select' => 'border-color: {{VALUE}};'],
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

    protected function render()
    {
        parent::render();
        $settings = $this->get_settings_for_display();
        $settings['widget_id'] = sanitize_html_class($this->get_id());
        $per_page = max(1, (int) ($settings['products_per_page'] ?? 9));
        $paged = max(1, (int) get_query_var('paged'), isset($_GET['product-page']) ? (int) $_GET['product-page'] : 1);
        $total = 0;

        if (post_type_exists('product')) {
            $query_args = ['post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => 1, 'fields' => 'ids'];
            $product_name_search = !empty($_GET['product_search'])
                ? sanitize_text_field(wp_unslash($_GET['product_search']))
                : (!empty($_GET['s']) ? sanitize_text_field(wp_unslash($_GET['s'])) : '');
            if ($product_name_search !== '') $query_args['t888_product_name_search'] = $product_name_search;
            $tax_query = [];
            $selected_categories = array_values(array_filter(array_map('absint', (array) ($settings['categories'] ?? []))));
            if ($selected_categories) {
                $tax_query[] = ['taxonomy' => 'product_cat', 'field' => 'term_id', 'terms' => $selected_categories];
            }
            if (!empty($_GET['product_cat'])) {
                $requested_category_slug = sanitize_title(wp_unslash($_GET['product_cat']));
                $requested_category = get_term_by('slug', $requested_category_slug, 'product_cat');

                if ($requested_category instanceof \WP_Term) {
                    $tax_query[] = [
                        'taxonomy'         => 'product_cat',
                        'field'            => 'term_id',
                        'terms'            => [(int) $requested_category->term_id],
                        'operator'         => 'IN',
                        'include_children' => true,
                    ];
                } else {
                    $query_args['post__in'] = [0];
                }
            } elseif (is_tax('product_cat')) {
                $term = get_queried_object();
                if ($term instanceof \WP_Term) $tax_query[] = ['taxonomy' => 'product_cat', 'field' => 'term_id', 'terms' => [$term->term_id]];
            }
            if ($tax_query) $query_args['tax_query'] = array_merge(['relation' => 'AND'], $tax_query);
            $min_price = isset($_GET['min_price']) && $_GET['min_price'] !== '' ? (float) wp_unslash($_GET['min_price']) : null;
            $max_price = isset($_GET['max_price']) && $_GET['max_price'] !== '' ? (float) wp_unslash($_GET['max_price']) : null;
            if ($min_price !== null || $max_price !== null) {
                $query_args['meta_query'] = [[
                    'key' => '_price', 'value' => [$min_price ?? 0, $max_price ?? PHP_INT_MAX],
                    'compare' => 'BETWEEN', 'type' => 'DECIMAL(10,2)',
                ]];
            }
            $search_by_product_name = static function ($search, $query) {
                $keyword = trim((string) $query->get('t888_product_name_search'));
                if ($keyword === '') return $search;

                global $wpdb;
                $like = '%' . $wpdb->esc_like($keyword) . '%';
                return $wpdb->prepare(
                    " AND LOWER({$wpdb->posts}.post_title) LIKE LOWER(%s)",
                    $like
                );
            };
            add_filter('posts_search', $search_by_product_name, 10, 2);
            try {
                $count_query = new \WP_Query($query_args);
            } finally {
                remove_filter('posts_search', $search_by_product_name, 10);
            }
            $total = (int) $count_query->found_posts;
        }

        $start = $total ? (($paged - 1) * $per_page) + 1 : 0;
        $end = min($paged * $per_page, $total);
        $settings['result_text'] = sprintf(
            /* translators: 1: first result, 2: last result, 3: total results */
            __('Showing %1$s–%2$s of %3$s results', 'nebon'),
            number_format_i18n($start), number_format_i18n($end), number_format_i18n($total)
        );
        $settings['current_orderby'] = isset($_GET['orderby']) ? sanitize_key(wp_unslash($_GET['orderby'])) : 'menu_order';
        $settings['form_action'] = remove_query_arg(['orderby', 'product-page', 'paged']);
        tech888f_get_template_elementor_widget('t888-shop-toolbar', false, $settings, true);
    }
}
