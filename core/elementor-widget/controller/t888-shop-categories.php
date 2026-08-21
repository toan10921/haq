<?php

namespace Elementor;

class T888_Shop_Categories extends T888_Widget_Base
{
    public function get_name() { return 't888-shop-categories'; }
    public function get_title() { return __('Shop Product Categories', 'nebon'); }
    public function get_icon() { return 'eicon-product-categories'; }
    public function get_categories() { return ['t888-elements']; }

    protected function is_dynamic_content(): bool
    {
        return true;
    }

    protected function register_controls()
    {
        $this->start_controls_section('content', ['label' => __('Categories', 'nebon')]);
        $this->add_control('title', [
            'label' => __('Title', 'nebon'), 'type' => Controls_Manager::TEXT,
            'default' => __('Product categories', 'nebon'), 'label_block' => true,
        ]);
        $this->add_control('hide_empty', [
            'label' => __('Hide Empty', 'nebon'), 'type' => Controls_Manager::SWITCHER,
            'default' => 'yes', 'return_value' => 'yes',
        ]);
        $this->add_control('show_count', [
            'label' => __('Show Product Count', 'nebon'), 'type' => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
        ]);
        $this->add_control('show_all', [
            'label' => __('Show All Products Link', 'nebon'), 'type' => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
        ]);
        $this->add_control('all_label', [
            'label' => __('All Products Label', 'nebon'), 'type' => Controls_Manager::TEXT,
            'default' => __('Tất cả', 'nebon'), 'condition' => ['show_all' => 'yes'],
        ]);
        $this->add_control('hierarchical', [
            'label' => __('Show Hierarchy', 'nebon'), 'type' => Controls_Manager::SWITCHER,
            'default' => 'yes', 'return_value' => 'yes',
        ]);
        $this->add_control('orderby', [
            'label' => __('Order By', 'nebon'), 'type' => Controls_Manager::SELECT, 'default' => 'name',
            'options' => ['name' => __('Name', 'nebon'), 'count' => __('Product count', 'nebon'), 'menu_order' => __('Menu order', 'nebon')],
        ]);
        $this->end_controls_section();

        $this->start_controls_section('box_style', ['label' => __('Box', 'nebon'), 'tab' => Controls_Manager::TAB_STYLE]);
        $this->add_control('background', [
            'label' => __('Background', 'nebon'), 'type' => Controls_Manager::COLOR, 'default' => '#f6f6f6',
            'selectors' => ['{{WRAPPER}} .t888-shop-categories' => 'background-color: {{VALUE}};'],
        ]);
        $this->add_control('accent', [
            'label' => __('Accent Color', 'nebon'), 'type' => Controls_Manager::COLOR, 'default' => '#ef4b00',
            'selectors' => [
                '{{WRAPPER}} .t888-shop-categories::before' => 'background-color: {{VALUE}};',
                '{{WRAPPER}} .t888-shop-categories__link:hover' => 'color: {{VALUE}};',
                '{{WRAPPER}} .t888-shop-categories__link.is-active' => 'color: {{VALUE}};',
            ],
        ]);
        $this->add_responsive_control('padding', [
            'label' => __('Padding', 'nebon'), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => ['px'],
            'default' => ['top' => 30, 'right' => 24, 'bottom' => 24, 'left' => 24, 'unit' => 'px', 'isLinked' => false],
            'selectors' => ['{{WRAPPER}} .t888-shop-categories' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
        ]);
        $this->end_controls_section();

        $this->start_controls_section('text_style', ['label' => __('Text', 'nebon'), 'tab' => Controls_Manager::TAB_STYLE]);
        $this->add_control('title_color', [
            'label' => __('Title Color', 'nebon'), 'type' => Controls_Manager::COLOR, 'default' => '#111111',
            'selectors' => ['{{WRAPPER}} .t888-shop-categories__title' => 'color: {{VALUE}};'],
        ]);
        $this->add_group_control(Group_Control_Typography::get_type(), ['name' => 'title_typography', 'selector' => '{{WRAPPER}} .t888-shop-categories__title']);
        $this->add_control('link_color', [
            'label' => __('Link Color', 'nebon'), 'type' => Controls_Manager::COLOR, 'default' => '#777777',
            'selectors' => ['{{WRAPPER}} .t888-shop-categories__link' => 'color: {{VALUE}};'],
        ]);
        $this->end_controls_section();
    }

    protected function render()
    {
        parent::render();
        $settings = $this->get_settings_for_display();
        $settings['terms'] = taxonomy_exists('product_cat') ? get_terms([
            'taxonomy' => 'product_cat', 'hide_empty' => ($settings['hide_empty'] ?? 'yes') === 'yes',
            'orderby' => $settings['orderby'] ?? 'name', 'order' => 'ASC',
        ]) : [];
        $settings['default_product_category_id'] = (int) get_option('default_product_cat', 0);
        $settings['active_slug'] = !empty($_GET['product_cat']) ? sanitize_title(wp_unslash($_GET['product_cat'])) : (is_tax('product_cat') ? get_queried_object()->slug : '');
        tech888f_get_template_elementor_widget('t888-shop-categories', false, $settings, true);
    }
}
