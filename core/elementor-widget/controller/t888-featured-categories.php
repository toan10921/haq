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
        return ['swiper', 'elementor-t888-featured-categories'];
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
        'condition' => ['style!' => 'style4'],
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
            'style4' => __('Style 4 - Product Category Slider', 'nebon'),
            
        ],
    ]);

    $this->end_controls_section();

    // Section for style1 & style2: fixed 3 categories
    $this->start_controls_section('section_fixed_categories', [
        'label' => __('Fixed Categories (Style 1 & 2)', 'nebon'),
        'condition' => [
            'style' => ['style1', 'style2'],
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

    // Section for style3 and style4: repeater dynamic categories
    $this->start_controls_section('section_dynamic_categories', [
        'label' => __('Product Categories', 'nebon'),
        'condition' => [
            'style' => ['style3', 'style4'],
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
        'description' => __('Optional. Leave empty to use the WooCommerce category thumbnail.', 'nebon'),
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

    $this->start_controls_section('section_style4_slider', [
        'label' => __('Category Slider', 'nebon'),
        'condition' => ['style' => 'style4'],
    ]);

    $this->add_control('style4_slides_desktop', [
        'label' => __('Slides on Desktop', 'nebon'),
        'type' => Controls_Manager::SELECT,
        'default' => '3',
        'options' => [
            '1' => __('1 Slide', 'nebon'),
            '2' => __('2 Slides', 'nebon'),
            '3' => __('3 Slides', 'nebon'),
            '4' => __('4 Slides', 'nebon'),
        ],
    ]);

    $this->add_control('style4_slides_tablet', [
        'label' => __('Slides on Tablet', 'nebon'),
        'type' => Controls_Manager::SELECT,
        'default' => '2',
        'options' => [
            '1' => __('1 Slide', 'nebon'),
            '2' => __('2 Slides', 'nebon'),
            '3' => __('3 Slides', 'nebon'),
        ],
    ]);

    $this->add_control('style4_slides_mobile', [
        'label' => __('Slides on Mobile', 'nebon'),
        'type' => Controls_Manager::SELECT,
        'default' => '1',
        'options' => [
            '1' => __('1 Slide', 'nebon'),
            '2' => __('2 Slides', 'nebon'),
        ],
    ]);

    $this->add_control('style4_gap', [
        'label' => __('Slide Gap (px)', 'nebon'),
        'type' => Controls_Manager::NUMBER,
        'min' => 0,
        'max' => 100,
        'default' => 30,
    ]);

    $this->add_control('style4_autoplay', [
        'label' => __('Autoplay', 'nebon'),
        'type' => Controls_Manager::SWITCHER,
        'label_on' => __('Yes', 'nebon'),
        'label_off' => __('No', 'nebon'),
        'return_value' => 'yes',
        'default' => 'yes',
    ]);

    $this->add_control('style4_autoplay_delay', [
        'label' => __('Autoplay Delay (ms)', 'nebon'),
        'type' => Controls_Manager::NUMBER,
        'min' => 1000,
        'max' => 15000,
        'step' => 250,
        'default' => 4500,
        'condition' => ['style4_autoplay' => 'yes'],
    ]);

    $this->add_control('style4_transition_speed', [
        'label' => __('Transition Speed (ms)', 'nebon'),
        'type' => Controls_Manager::NUMBER,
        'min' => 200,
        'max' => 3000,
        'step' => 50,
        'default' => 650,
    ]);

    $this->add_control('style4_loop', [
        'label' => __('Infinite Loop', 'nebon'),
        'type' => Controls_Manager::SWITCHER,
        'label_on' => __('Yes', 'nebon'),
        'label_off' => __('No', 'nebon'),
        'return_value' => 'yes',
        'default' => 'yes',
    ]);

    $this->add_control('style4_navigation', [
        'label' => __('Navigation Arrows', 'nebon'),
        'type' => Controls_Manager::SWITCHER,
        'label_on' => __('Show', 'nebon'),
        'label_off' => __('Hide', 'nebon'),
        'return_value' => 'yes',
        'default' => 'yes',
    ]);

    $this->end_controls_section();

    $this->start_controls_section('section_style4_design', [
        'label' => __('Category Showcase', 'nebon'),
        'tab' => Controls_Manager::TAB_STYLE,
        'condition' => ['style' => 'style4'],
    ]);

    $this->add_responsive_control('style4_card_height', [
        'label' => __('Card Height', 'nebon'),
        'type' => Controls_Manager::SLIDER,
        'range' => ['px' => ['min' => 320, 'max' => 760]],
        'default' => ['size' => 500, 'unit' => 'px'],
        'tablet_default' => ['size' => 460, 'unit' => 'px'],
        'mobile_default' => ['size' => 430, 'unit' => 'px'],
        'selectors' => [
            '{{WRAPPER}} .category-showcase-card' => 'height: {{SIZE}}{{UNIT}};',
        ],
    ]);

    $this->add_control('style4_accent_color', [
        'label' => __('Accent Color', 'nebon'),
        'type' => Controls_Manager::COLOR,
        'default' => '#f45100',
        'selectors' => [
            '{{WRAPPER}} .category-showcase-count, {{WRAPPER}} .category-showcase-action' => 'background-color: {{VALUE}};',
            '{{WRAPPER}} .category-showcase-nav:hover, {{WRAPPER}} .category-showcase-nav:focus-visible' => 'border-color: {{VALUE}}; background-color: {{VALUE}};',
        ],
    ]);

    $this->add_control('style4_title_color', [
        'label' => __('Title Color', 'nebon'),
        'type' => Controls_Manager::COLOR,
        'default' => '#ffffff',
        'selectors' => [
            '{{WRAPPER}} .category-showcase-title' => 'color: {{VALUE}};',
        ],
    ]);

    $this->add_group_control(Group_Control_Typography::get_type(), [
        'name' => 'style4_title_typography',
        'selector' => '{{WRAPPER}} .category-showcase-title',
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
