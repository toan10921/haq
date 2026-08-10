<?php
namespace Elementor;

class T888_Pet_Category_Carousel extends T888_Widget_Base
{
    public function get_name()
    {
        return 't888-pet-category-carousel';
    }

    public function get_title()
    {
        return __('Pet Category Carousel', 'nebon');
    }

    public function get_icon()
    {
        return 'eicon-image-carousel';
    }

    public function get_categories()
    {
        return ['t888-elements'];
    }

    public function get_script_depends()
    {
        return ['elementor-t888-pet-category-carousel', 'swiper'];
    }

    public function get_style_depends()
    {
        return ['elementor-t888-pet-category-carousel', 'e-swiper'];
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

    protected function _register_controls()
    {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Content', 'nebon'),
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Title', 'nebon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('EXPLORE CATEGORIES', 'nebon'),
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'category_select',
            [
                'label' => __('Select Category', 'nebon'),
                'type' => Controls_Manager::SELECT2,
                'options' => $this->get_product_categories(),
                'multiple' => false,
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'category_image',
            [
                'label' => __('Custom Image', 'nebon'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $repeater->add_control(
            'custom_title',
            [
                'label' => __('Custom Title (Optional)', 'nebon'),
                'type' => Controls_Manager::TEXT,
                'description' => __('Leave blank to use category name directly.', 'nebon'),
            ]
        );

        $repeater->add_control(
            'bg_color',
            [
                'label' => __('Box Background Color', 'nebon'),
                'type' => Controls_Manager::COLOR,
                'default' => '#faeaea',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .cat-box-bg' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $repeater->add_control(
            'img_heading',
            [
                'label' => __('Image Positioning', 'nebon'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $repeater->add_control(
            'image_width',
            [
                'label' => __('Image Width', 'nebon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 500],
                    '%' => ['min' => 0, 'max' => 200],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .cat-img' => 'width: {{SIZE}}{{UNIT}}; max-width: none;',
                ],
            ]
        );

        $repeater->add_control(
            'image_top',
            [
                'label' => __('Image Top Position', 'nebon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => ['min' => -300, 'max' => 300],
                    '%' => ['min' => -100, 'max' => 100],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .cat-img' => 'top: {{SIZE}}{{UNIT}}; bottom: auto;',
                ],
            ]
        );

        $repeater->add_control(
            'image_bottom',
            [
                'label' => __('Image Bottom Position', 'nebon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => ['min' => -300, 'max' => 300],
                    '%' => ['min' => -100, 'max' => 100],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .cat-img' => 'bottom: {{SIZE}}{{UNIT}}; top: auto;',
                ],
            ]
        );

        $repeater->add_control(
            'image_left',
            [
                'label' => __('Image Left Position', 'nebon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => ['min' => -300, 'max' => 300],
                    '%' => ['min' => -50, 'max' => 150],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .cat-img' => 'left: {{SIZE}}{{UNIT}}; right: auto; transform: none;',
                ],
            ]
        );

        $repeater->add_control(
            'image_right',
            [
                'label' => __('Image Right Position', 'nebon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => ['min' => -300, 'max' => 300],
                    '%' => ['min' => -50, 'max' => 150],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .cat-img' => 'right: {{SIZE}}{{UNIT}}; left: auto; transform: none;',
                ],
            ]
        );
        
        $repeater->add_control(
            'image_z_index',
            [
                'label' => __('Z-Index', 'nebon'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .cat-img' => 'z-index: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
            'categories_list',
            [
                'label' => __('Categories', 'nebon'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ custom_title || "Category" }}}',
                'default' => [
                    [
                        'custom_title' => __('BIRD SHOP', 'nebon'),
                        'bg_color' => '#faeaea',
                    ],
                    [
                        'custom_title' => __('FISH SHOP', 'nebon'),
                        'bg_color' => '#f6ebd5',
                    ],
                    [
                        'custom_title' => __('DOG SHOP', 'nebon'),
                        'bg_color' => '#dff1fa',
                    ],
                    [
                        'custom_title' => __('CAT SHOP', 'nebon'),
                        'bg_color' => '#facbbf',
                    ],
                    [
                        'custom_title' => __('HAMSTER SHOP', 'nebon'),
                        'bg_color' => '#f8e3bf',
                    ],
                ]
            ]
        );

        $this->add_control(
            'columns',
            [
                'label' => __('Carousel Columns', 'nebon'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '5',
                'options' => [
                    '3' => '3 Columns',
                    '4' => '4 Columns',
                    '5' => '5 Columns',
                    '6' => '6 Columns',
                ],
            ]
        );

        $this->end_controls_section();

        // ========== STYLE TAB ========== //

        // --- Box Style --- //
        $this->start_controls_section(
            'box_style_section',
            [
                'label' => __('Category Box', 'nebon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'box_padding',
            [
                'label' => __('Box Padding', 'nebon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .cat-box-bg' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'box_width',
            [
                'label' => __('Box Width', 'nebon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 600,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .cat-box-bg' => 'width: {{SIZE}}{{UNIT}}; margin-left: auto; margin-right: auto;',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'box_height',
            [
                'label' => __('Box Height (px)', 'nebon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 600,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .cat-box-bg' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'box_border_radius',
            [
                'label' => __('Border Radius', 'nebon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .cat-box-bg' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();



        // --- Text Content Style --- //
        $this->start_controls_section(
            'text_style_section',
            [
                'label' => __('Text Content', 'nebon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        
        // Category Title
        $this->add_control(
            'cat_title_heading',
            [
                'label' => __('Category Title', 'nebon'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'cat_title_color',
            [
                'label' => __('Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cat-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'cat_title_typography',
                'label' => __('Typography', 'nebon'),
                'selector' => '{{WRAPPER}} .cat-title',
            ]
        );

        $this->add_responsive_control(
            'cat_title_margin',
            [
                'label' => __('Margin', 'nebon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .cat-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Category Count
        $this->add_control(
            'cat_count_heading',
            [
                'label' => __('Item Count Text', 'nebon'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'cat_count_color',
            [
                'label' => __('Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cat-count' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'cat_count_typography',
                'label' => __('Typography', 'nebon'),
                'selector' => '{{WRAPPER}} .cat-count',
            ]
        );

        $this->add_responsive_control(
            'cat_count_margin',
            [
                'label' => __('Margin', 'nebon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .cat-count' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        // Z-Index for text wrapper
        $this->add_control(
            'text_z_index',
            [
                'label' => __('Text Z-Index', 'nebon'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'selectors' => [
                    '{{WRAPPER}} .cat-text-wrap' => 'z-index: {{VALUE}}; position: relative;',
                ],
            ]
        );

        $this->end_controls_section();

        // --- Header (Main Title) Style --- //
        $this->start_controls_section(
            'header_style_section',
            [
                'label' => __('Header Style', 'nebon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'header_margin_bottom',
            [
                'label' => __('Header Margin Bottom (px)', 'nebon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .header-nav-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'main_title_color',
            [
                'label' => __('Title Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .main-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'main_title_typography',
                'label' => __('Title Typography', 'nebon'),
                'selector' => '{{WRAPPER}} .main-title',
            ]
        );

        $this->end_controls_section();

        // --- Navigation Arrows --- //
        $this->start_controls_section(
            'nav_style_section',
            [
                'label' => __('Navigation Arrows', 'nebon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'nav_bg_color',
            [
                'label' => __('Background Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .header-nav button' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'nav_color',
            [
                'label' => __('Arrow Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .header-nav button' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'nav_size',
            [
                'label' => __('Arrow Box Size (px)', 'nebon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 60,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .header-nav button' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; padding: 0 !important; display: inline-flex; align-items: center; justify-content: center;',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        parent::render();
        $settings = $this->get_element_settings();
        tech888f_get_template_elementor_widget('t888-pet-category-carousel', 't888-pet-category-carousel', $settings, true);
    }
}
