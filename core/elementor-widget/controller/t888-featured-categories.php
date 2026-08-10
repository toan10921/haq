<?php

namespace Elementor;

class T888_Featured_Categories extends T888_Widget_Base
{
    public function get_name()
    {
        return 't888-featured-categories';
    }

    public function get_title()
    {
        return __('Featured Categories', 'nebon');
    }

    public function get_icon()
    {
        return 'eicon-info-circle';
    }

    public function get_categories()
    {
        return ['t888-elements'];
    }

    public function get_script_depends()
    {
        return ['elementor-t888-featured-categories'];
    }

    public function get_style_depends()
    {
        return ['elementor-t888-featured-categories'];
    }

    protected function _register_controls()
{
    // Header section
    $this->start_controls_section('section_header', [
        'label' => __('Header', 'nebon'),
    ]);

    $this->add_control('section_title', [
        'label' => __('Title', 'nebon'),
        'type' => Controls_Manager::TEXT,
        'default' => __('View all categories', 'nebon'),
    ]);

    $this->add_control('section_link', [
        'label' => __('Link', 'nebon'),
        'type' => Controls_Manager::URL,
        'placeholder' => __('https://your-link.com', 'nebon'),
        'show_external' => true,
        'default' => [
            'url' => '#',
            'is_external' => false,
            'nofollow' => false,
        ],
    ]);

    $this->end_controls_section();

    // Style selection
    $this->start_controls_section('section_style', [
        'label' => __('Style Settings', 'nebon'),
    ]);

    $this->add_control('style', [
        'label' => __('Style', 'nebon'),
        'type' => Controls_Manager::SELECT,
        'default' => 'style1',
        'options' => [
            'style1' => __('Style 1', 'nebon'),
            'style2' => __('Style 2', 'nebon'),
            'style3' => __('Style 3', 'nebon'),
            
        ],
    ]);

    $this->end_controls_section();

    // Section for style1 & style2: fixed 3 categories
    $this->start_controls_section('section_fixed_categories', [
        'label' => __('Fixed Categories (Style 1 & 2)', 'nebon'),
        'condition' => [
            'style!' => 'style3',
        ],
    ]);

    for ($i = 1; $i <= 3; $i++) {
        $this->add_control("category_{$i}_select", [
            'label' => __('Select Category #', 'nebon') . $i,
            'type' => Controls_Manager::SELECT2,
            'options' => $this->get_product_categories(),
            'multiple' => false,
            'label_block' => true,
        ]);

        $this->add_control("category_{$i}_image", [
            'label' => __('Category Image #', 'nebon') . $i,
            'type' => Controls_Manager::MEDIA,
            'default' => [
                'url' => Utils::get_placeholder_image_src(),
            ],
        ]);
    }

    $this->end_controls_section();

    // Section for style3: repeater dynamic categories
    $this->start_controls_section('section_dynamic_categories', [
        'label' => __('Dynamic Categories (Style 3)', 'nebon'),
        'condition' => [
            'style' => 'style3',
        ],
    ]);

    $repeater = new \Elementor\Repeater();

    $repeater->add_control('category_select', [
        'label' => __('Select Category', 'nebon'),
        'type' => Controls_Manager::SELECT2,
        'options' => $this->get_product_categories(),
        'multiple' => false,
        'label_block' => true,
    ]);

    $repeater->add_control('category_image', [
        'label' => __('Category Image', 'nebon'),
        'type' => Controls_Manager::MEDIA,
        'default' => ['url' => Utils::get_placeholder_image_src()],
    ]);

    $this->add_control('category_list', [
        'label' => __('Category List', 'nebon'),
        'type' => Controls_Manager::REPEATER,
        'fields' => $repeater->get_controls(),
        'title_field' => '{{ category_select }}',
    ]);
    $this->add_control('style3_columns', [
    'label' => __('Columns (for Style 3)', 'nebon'),
    'type' => Controls_Manager::SELECT,
    'default' => '5',
    'options' => [
        '2' => '2 Columns',
        '3' => '3 Columns',
        '4' => '4 Columns',
        '5' => '5 Columns',
        '6' => '6 Columns',
    ],
    'condition' => [
        'style' => 'style3',
    ],
]);
    $this->end_controls_section();
}


    private function get_product_categories()
    {
        $terms = get_terms([
            'taxonomy' => 'product_cat',
            'hide_empty' => false,
        ]);

        $options = [];
        if (!is_wp_error($terms) && !empty($terms)) {
            foreach ($terms as $term) {
                $options[$term->term_id] = $term->name;
            }
        }

        return $options;
    }


    protected function render()
    {
        parent::render();
        $settings =  $this->get_element_settings();
        $style = isset($settings['style']) ? $settings['style'] : 'style1';
        tech888f_get_template_elementor_widget('t888-featured-categories', $style, $settings, true);
    }
}
