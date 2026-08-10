<?php

namespace Elementor;

class T888_Feature_Products extends T888_Widget_Base
{
    public function __construct(array $data = [], array $args = null)
    {
        parent::__construct($data, $args);
    }

    public function get_name()
    {
        return 't888-feature-products';
    }

    public function get_title()
    {
        return __('Feature Products', 'nebon');
    }

    public function get_icon()
    {
        return 'eicon-products';
    }

    public function get_categories()
    {
        return ['t888-elements'];
    }

    public function get_script_depends()
    {
        return ['elementor-t888-feature-products', 'swiper'];
    }

    public function get_style_depends()
    {
        return ['elementor-t888-feature-products', 'e-swiper'];
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'layout_section',
            [
                'label' => __('Layout Options', 'nebon'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Tiêu đề chính
        $this->add_control(
            'main_title',
            [
                'label' => __('Main Title', 'nebon'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Featured', 'nebon'),
            ]
        );

        // Repeater chọn sản phẩm + ảnh nền riêng
        $repeater = new Repeater();

        $repeater->add_control(
            'product',
            [
                'label' => __('Select Product', 'nebon'),
                'type' => Controls_Manager::SELECT2,
                'label_block' => true,
                'options' => $this->get_products_options(),
                'multiple' => false,
            ]
        );

        $repeater->add_control(
            'product_bg',
            [
                'label' => __('Product Background Image', 'nebon'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'product_list',
            [
                'label' => __('Products List', 'nebon'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ product }}}',
            ]
        );

        $this->end_controls_section();
    }

    private function get_products_options()
    {
        if (!post_type_exists('product')) return [];

        $query = new \WP_Query([
            'post_type'      => 'product',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
        ]);

        $options = [];
        foreach ($query->posts as $post) {
            $options[$post->ID] = $post->post_title;
        }

        return $options;
    }

    protected function render()
    {
        parent::render();
        $settings = $this->get_settings_for_display();
        $style = isset($settings['style']) ? $settings['style'] : 'style1';
        tech888f_get_template_elementor_widget('t888-feature-products', $style, $settings, true);
    }
}