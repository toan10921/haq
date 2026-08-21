<?php

namespace Elementor;

class T888_Shop_Search extends T888_Widget_Base
{
    public function get_name() { return 't888-shop-search'; }
    public function get_title() { return __('Shop Product Search', 'nebon'); }
    public function get_icon() { return 'eicon-search'; }
    public function get_categories() { return ['t888-elements']; }
    public function get_script_depends() { return ['elementor-t888-shop-search']; }

    protected function is_dynamic_content(): bool
    {
        return true;
    }

    public function enque_scripts()
    {
        parent::enque_scripts();

        wp_localize_script('elementor-t888-shop-search', 't888ShopSearch', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
        ]);
    }

    protected function register_controls()
    {
        $this->start_controls_section('content', ['label' => __('Search', 'nebon')]);
        $this->add_control('placeholder', [
            'label' => __('Placeholder', 'nebon'), 'type' => Controls_Manager::TEXT,
            'default' => __('Search products...', 'nebon'), 'label_block' => true,
        ]);
        $this->add_control('button_label', [
            'label' => __('Accessible Button Label', 'nebon'), 'type' => Controls_Manager::TEXT,
            'default' => __('Search products', 'nebon'), 'label_block' => true,
        ]);
        $this->add_control('live_search', [
            'label' => __('Live Search While Typing', 'nebon'), 'type' => Controls_Manager::SWITCHER,
            'default' => 'yes', 'return_value' => 'yes',
        ]);
        $this->add_control('minimum_characters', [
            'label' => __('Minimum Characters', 'nebon'), 'type' => Controls_Manager::NUMBER,
            'default' => 1, 'min' => 1, 'max' => 10, 'condition' => ['live_search' => 'yes'],
        ]);
        $this->add_control('typing_delay', [
            'label' => __('Typing Delay (ms)', 'nebon'), 'type' => Controls_Manager::NUMBER,
            'default' => 350, 'min' => 100, 'max' => 2000, 'step' => 50, 'condition' => ['live_search' => 'yes'],
        ]);
        $this->end_controls_section();

        $this->start_controls_section('box_style', ['label' => __('Box', 'nebon'), 'tab' => Controls_Manager::TAB_STYLE]);
        $this->add_control('box_background', [
            'label' => __('Background', 'nebon'), 'type' => Controls_Manager::COLOR, 'default' => '#f6f6f6',
            'selectors' => ['{{WRAPPER}} .t888-shop-search' => 'background-color: {{VALUE}};'],
        ]);
        $this->add_responsive_control('box_padding', [
            'label' => __('Padding', 'nebon'), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => ['px'],
            'default' => ['top' => 30, 'right' => 24, 'bottom' => 30, 'left' => 24, 'unit' => 'px', 'isLinked' => false],
            'selectors' => ['{{WRAPPER}} .t888-shop-search' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
        ]);
        $this->add_control('accent_color', [
            'label' => __('Accent Color', 'nebon'), 'type' => Controls_Manager::COLOR, 'default' => '#ef4b00',
            'selectors' => ['{{WRAPPER}} .t888-shop-search::before' => 'background-color: {{VALUE}};'],
        ]);
        $this->end_controls_section();

        $this->start_controls_section('field_style', ['label' => __('Input', 'nebon'), 'tab' => Controls_Manager::TAB_STYLE]);
        $this->add_control('field_background', [
            'label' => __('Background', 'nebon'), 'type' => Controls_Manager::COLOR, 'default' => '#ffffff',
            'selectors' => ['{{WRAPPER}} .t888-shop-search__form' => 'background-color: {{VALUE}};'],
        ]);
        $this->add_control('field_border', [
            'label' => __('Border Color', 'nebon'), 'type' => Controls_Manager::COLOR, 'default' => '#dedede',
            'selectors' => ['{{WRAPPER}} .t888-shop-search__form' => 'border-color: {{VALUE}};'],
        ]);
        $this->end_controls_section();
    }

    protected function render()
    {
        parent::render();
        $settings = $this->get_settings_for_display();
        $settings['search_value'] = isset($_GET['product_search'])
            ? sanitize_text_field(wp_unslash($_GET['product_search']))
            : (isset($_GET['s']) ? sanitize_text_field(wp_unslash($_GET['s'])) : '');
        $settings['form_action'] = remove_query_arg(['product_search', 's', 'post_type', 'product-page', 'paged'], get_current_url());
        tech888f_get_template_elementor_widget('t888-shop-search', false, $settings, true);
    }
}
