<?php

namespace Elementor;

class T888_Shop_Price_Filter extends T888_Widget_Base
{
    public function get_name() { return 't888-shop-price-filter'; }
    public function get_title() { return __('Shop Price Filter', 'nebon'); }
    public function get_icon() { return 'eicon-price-list'; }
    public function get_categories() { return ['t888-elements']; }
    public function get_script_depends() { return ['elementor-t888-shop-price-filter']; }

    protected function is_dynamic_content(): bool
    {
        return true;
    }

    protected function register_controls()
    {
        $this->start_controls_section('content', ['label' => __('Price Filter', 'nebon')]);
        $this->add_control('title', [
            'label' => __('Title', 'nebon'), 'type' => Controls_Manager::TEXT,
            'default' => __('Filter by price', 'nebon'), 'label_block' => true,
        ]);
        $this->add_control('button_text', [
            'label' => __('Button Text', 'nebon'), 'type' => Controls_Manager::TEXT,
            'default' => __('Filter', 'nebon'),
        ]);
        $this->add_control('currency_source', [
            'label' => __('Currency Symbol', 'nebon'), 'type' => Controls_Manager::SELECT, 'default' => 'woocommerce',
            'options' => ['woocommerce' => __('WooCommerce currency', 'nebon'), 'custom' => __('Custom symbol', 'nebon')],
        ]);
        $this->add_control('custom_currency_symbol', [
            'label' => __('Custom Currency Symbol', 'nebon'), 'type' => Controls_Manager::TEXT,
            'default' => '$', 'condition' => ['currency_source' => 'custom'],
        ]);
        $this->add_control('range_source', [
            'label' => __('Price Range', 'nebon'), 'type' => Controls_Manager::SELECT, 'default' => 'automatic',
            'options' => ['automatic' => __('Automatic from products', 'nebon'), 'manual' => __('Manual', 'nebon')],
        ]);
        $this->add_control('manual_min', [
            'label' => __('Minimum Price', 'nebon'), 'type' => Controls_Manager::NUMBER, 'default' => 0,
            'condition' => ['range_source' => 'manual'],
        ]);
        $this->add_control('manual_max', [
            'label' => __('Maximum Price', 'nebon'), 'type' => Controls_Manager::NUMBER, 'default' => 1000,
            'condition' => ['range_source' => 'manual'],
        ]);
        $this->end_controls_section();

        $this->start_controls_section('box_style', ['label' => __('Box', 'nebon'), 'tab' => Controls_Manager::TAB_STYLE]);
        $this->add_control('background', [
            'label' => __('Background', 'nebon'), 'type' => Controls_Manager::COLOR, 'default' => '#f6f6f6',
            'selectors' => ['{{WRAPPER}} .t888-price-filter' => 'background-color: {{VALUE}};'],
        ]);
        $this->add_responsive_control('padding', [
            'label' => __('Padding', 'nebon'), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => ['px'],
            'default' => ['top' => 32, 'right' => 23, 'bottom' => 33, 'left' => 23, 'unit' => 'px', 'isLinked' => false],
            'selectors' => ['{{WRAPPER}} .t888-price-filter' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
        ]);
        $this->add_control('accent', [
            'label' => __('Accent Color', 'nebon'), 'type' => Controls_Manager::COLOR, 'default' => '#ef4b00',
            'selectors' => [
                '{{WRAPPER}} .t888-price-filter::before' => 'background-color: {{VALUE}};',
                '{{WRAPPER}} .t888-price-filter__range-fill' => 'background-color: {{VALUE}};',
                '{{WRAPPER}} .t888-price-filter__range::-webkit-slider-thumb' => 'background-color: {{VALUE}};',
                '{{WRAPPER}} .t888-price-filter__range::-moz-range-thumb' => 'background-color: {{VALUE}};',
                '{{WRAPPER}} .t888-price-filter__button' => 'background-color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_section();

        $this->start_controls_section('text_style', ['label' => __('Text', 'nebon'), 'tab' => Controls_Manager::TAB_STYLE]);
        $this->add_control('title_color', [
            'label' => __('Title Color', 'nebon'), 'type' => Controls_Manager::COLOR, 'default' => '#111111',
            'selectors' => ['{{WRAPPER}} .t888-price-filter__title' => 'color: {{VALUE}};'],
        ]);
        $this->add_group_control(Group_Control_Typography::get_type(), ['name' => 'title_typography', 'selector' => '{{WRAPPER}} .t888-price-filter__title']);
        $this->end_controls_section();
    }

    private function automatic_range()
    {
        global $wpdb;
        $table = !empty($wpdb->wc_product_meta_lookup) ? $wpdb->wc_product_meta_lookup : $wpdb->prefix . 'wc_product_meta_lookup';
        $row = $wpdb->get_row("SELECT FLOOR(MIN(min_price)) AS min_price, CEIL(MAX(max_price)) AS max_price FROM {$table} WHERE min_price IS NOT NULL AND max_price IS NOT NULL");
        return $row ? [(float) $row->min_price, (float) $row->max_price] : [0, 1000];
    }

    protected function render()
    {
        parent::render();
        $settings = $this->get_settings_for_display();
        [$range_min, $range_max] = ($settings['range_source'] ?? 'automatic') === 'manual'
            ? [(float) ($settings['manual_min'] ?? 0), (float) ($settings['manual_max'] ?? 1000)]
            : $this->automatic_range();
        if ($range_max <= $range_min) $range_max = $range_min + 20;
        $settings['range_min'] = $range_min;
        $settings['range_max'] = $range_max;
        $settings['current_min'] = isset($_GET['min_price']) && $_GET['min_price'] !== '' ? max($range_min, (float) wp_unslash($_GET['min_price'])) : $range_min;
        $settings['current_max'] = isset($_GET['max_price']) && $_GET['max_price'] !== '' ? min($range_max, (float) wp_unslash($_GET['max_price'])) : $range_max;
        $settings['is_full_range'] = $settings['current_min'] <= $range_min
            && $settings['current_max'] >= $range_max;
        $settings['currency_symbol'] = ($settings['currency_source'] ?? 'woocommerce') === 'custom'
            ? (string) ($settings['custom_currency_symbol'] ?? '$')
            : (function_exists('get_woocommerce_currency_symbol') ? get_woocommerce_currency_symbol() : '$');
        tech888f_get_template_elementor_widget('t888-shop-price-filter', false, $settings, true);
    }
}
