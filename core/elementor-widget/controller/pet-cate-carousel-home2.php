<?php
namespace Elementor;

class Pet_Cate_Carousel_Home2 extends T888_Widget_Base
{
    public function get_name()
    {
        return 'pet-cate-carousel-home2';
    }

    public function get_title()
    {
        return __('Pet Cate Carousel Home2', 'nebon');
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
        return ['elementor-pet-cate-carousel-home2', 'swiper'];
    }

    public function get_style_depends()
    {
        return ['elementor-pet-cate-carousel-home2', 'e-swiper'];
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
                'type' => Controls_Manager::TEXT,
                'default' => __('EXPLORE CATEGORIES', 'nebon'),
            ]
        );

        $this->add_control(
            'items_per_slide',
            [
                'label' => __('Items Per Slide', 'nebon'),
                'type' => Controls_Manager::SELECT,
                'default' => '5',
                'options' => [
                    '2' => __('2 Items', 'nebon'),
                    '3' => __('3 Items', 'nebon'),
                    '4' => __('4 Items', 'nebon'),
                    '5' => __('5 Items', 'nebon'),
                    '6' => __('6 Items', 'nebon'),
                ],
            ]
        );

        $this->add_control(
            'enable_slider',
            [
                'label' => __('Enable Slider', 'nebon'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'nebon'),
                'label_off' => __('No', 'nebon'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'slider_autoplay',
            [
                'label' => __('Autoplay Slide', 'nebon'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'nebon'),
                'label_off' => __('No', 'nebon'),
                'return_value' => 'yes',
                'default' => '',
                'condition' => [
                    'enable_slider' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'slider_autoplay_delay',
            [
                'label' => __('Autoplay Delay (Seconds)', 'nebon'),
                'type' => Controls_Manager::NUMBER,
                'default' => 3,
                'min' => 1,
                'condition' => [
                    'enable_slider' => 'yes',
                    'slider_autoplay' => 'yes',
                ],
            ]
        );

        $repeater = new Repeater();

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
                'label' => __('Custom Title', 'nebon'),
                'type' => Controls_Manager::TEXT,
                'description' => __('Leave blank to use category name.', 'nebon'),
            ]
        );

        $repeater->add_control(
            'bg_color',
            [
                'label' => __('Box Background Color', 'nebon'),
                'type' => Controls_Manager::COLOR,
                'default' => '#faeaea',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .pet-cate-carousel-home2__card' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $repeater->add_control(
            'img_heading',
            [
                'label' => __('Image Positioning', 'nebon'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $repeater->add_responsive_control(
            'image_width',
            [
                'label' => __('Image Width', 'nebon'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 500],
                    '%' => ['min' => 0, 'max' => 200],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .pet-cate-carousel-home2__image img' => 'width: {{SIZE}}{{UNIT}}; max-width: none;',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'image_top',
            [
                'label' => __('Image Top', 'nebon'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => ['min' => -300, 'max' => 300],
                    '%' => ['min' => -100, 'max' => 100],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .pet-cate-carousel-home2__image' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'image_left',
            [
                'label' => __('Image Left', 'nebon'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => ['min' => -300, 'max' => 300],
                    '%' => ['min' => -50, 'max' => 200],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .pet-cate-carousel-home2__image' => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $repeater->add_control(
            'image_z_index',
            [
                'label' => __('Image Z-Index', 'nebon'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .pet-cate-carousel-home2__image' => 'z-index: {{VALUE}};',
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
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_header',
            [
                'label' => __('Header', 'nebon'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'header_bg_color',
            [
                'label' => __('Header Background Color', 'nebon'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pet-cate-carousel-home2__header' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'main_title_color',
            [
                'label' => __('Title Color', 'nebon'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pet-cate-carousel-home2__title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'main_title_typography',
                'selector' => '{{WRAPPER}} .pet-cate-carousel-home2__title',
            ]
        );

        $this->add_responsive_control(
            'header_spacing',
            [
                'label' => __('Bottom Spacing', 'nebon'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['min' => 0, 'max' => 100],
                ],
                'selectors' => [
                    '{{WRAPPER}} .pet-cate-carousel-home2__header' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'slider_side_padding',
            [
                'label' => __('Slider Left/Right Padding', 'nebon'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'allowed_dimensions' => ['right', 'left'],
                'selectors' => [
                    '{{WRAPPER}} .pet-cate-carousel-home2__swiper' => 'padding-left: {{LEFT}}{{UNIT}}; padding-right: {{RIGHT}}{{UNIT}};',
                ],
                'default' => [
                    'unit' => 'px',
                    'left' => 30,
                    'right' => 30,
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_card',
            [
                'label' => __('Card', 'nebon'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'card_height',
            [
                'label' => __('Card Height', 'nebon'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['min' => 200, 'max' => 700],
                ],
                'selectors' => [
                    '{{WRAPPER}} .pet-cate-carousel-home2__card' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'card_padding',
            [
                'label' => __('Card Padding', 'nebon'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .pet-cate-carousel-home2__card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'card_border_radius',
            [
                'label' => __('Border Radius', 'nebon'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .pet-cate-carousel-home2__card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'space_between',
            [
                'label' => __('Space Between Slides', 'nebon'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['min' => 0, 'max' => 60],
                ],
                'selectors' => [
                    '{{WRAPPER}} .pet-cate-carousel-home2__swiper' => '--pet-cate-carousel-home2-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_text',
            [
                'label' => __('Text', 'nebon'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'cat_title_color',
            [
                'label' => __('Category Title Color', 'nebon'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pet-cate-carousel-home2__card-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'cat_title_typography',
                'selector' => '{{WRAPPER}} .pet-cate-carousel-home2__card-title',
            ]
        );

        $this->add_control(
            'cat_count_color',
            [
                'label' => __('Count Color', 'nebon'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pet-cate-carousel-home2__count' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'cat_count_typography',
                'selector' => '{{WRAPPER}} .pet-cate-carousel-home2__count',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_nav',
            [
                'label' => __('Navigation', 'nebon'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'nav_bg_color',
            [
                'label' => __('Background Color', 'nebon'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pet-cate-carousel-home2__nav button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'nav_color',
            [
                'label' => __('Arrow Color', 'nebon'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pet-cate-carousel-home2__nav button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'nav_box_size',
            [
                'label' => __('Button Size', 'nebon'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['min' => 24, 'max' => 80],
                ],
                'selectors' => [
                    '{{WRAPPER}} .pet-cate-carousel-home2__nav button' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        parent::render();
        $settings = $this->get_element_settings();
        tech888f_get_template_elementor_widget('pet-cate-carousel-home2', 'pet-cate-carousel-home2', $settings, true);
    }
}
